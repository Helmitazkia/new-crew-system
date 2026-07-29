<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CrewMatrix extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MCrewscv');
        $this->load->library('../controllers/DataContext');
        $this->load->library('session');

        // Auth guard
        $current = $this->router->fetch_method();
        if (!$this->session->userdata('isLogin')) {
            redirect('auth/login');
            exit;
        }
    }

    public function view()
    {
        $data['title'] = 'Crew Matrix';
        $data['active_menu'] = 'crew_matrix';
        
        $sqlCert = "SELECT certname FROM mstcert WHERE deletests = 0 AND show_matrix = 'Y' ORDER BY certname ASC";
        $data['dynamic_certs'] = $this->db->query($sqlCert)->result_array();

        $this->load->view('layout/header', $data);
        $this->load->view('Report/CrewMatrix/view_crewmatrix', $data);
        $this->load->view('layout/footer');
    }

    public function getData_crewMatrix()
    {
        $sqlCert = "SELECT certname FROM mstcert WHERE deletests = 0 AND show_matrix = 'Y'";
        $active_certs = $this->db->query($sqlCert)->result_array();

        $pivot_subquery_sql = "";
        $outer_select_sql = "";
        foreach ($active_certs as $cert) {
            $cert_name = $cert['certname'];
            $alias_iss = "iss_" . preg_replace('/[^a-zA-Z0-9]/', '_', $cert_name);
            $alias_exp = "exp_" . preg_replace('/[^a-zA-Z0-9]/', '_', $cert_name);
            
            $pivot_subquery_sql .= " MAX(CASE WHEN certname = '".$this->db->escape_str($cert_name)."' THEN issdate END) AS {$alias_iss}, ";
            $pivot_subquery_sql .= " MAX(CASE WHEN certname = '".$this->db->escape_str($cert_name)."' THEN expdate END) AS {$alias_exp}, ";
            $outer_select_sql .= " cert.{$alias_iss}, ";
            $outer_select_sql .= " cert.{$alias_exp}, ";
        }

        $sql = "
            SELECT 
                A.idperson,
                TRIM(CONCAT_WS(' ', A.fname, A.mname, A.lname)) AS fullName,
                CASE 
                    WHEN C.signoffdt = '0000-00-00' THEN 'On Board'
                    ELSE 'Stand By' 
                END AS crew_status,
                IFNULL(MR.nmrank, '') AS nmrank,
                F.NmNegara,
                A.dob,
                D.nmvsl AS signonvsl,
                C.signondt,
                C.signoffdt,
                C.estsignoffdt,
                {$outer_select_sql}
                'dummy' AS dummy
            FROM mstpersonal A
            INNER JOIN (
                SELECT t.idperson, t.signonvsl, t.signondt, t.signoffdt, t.estsignoffdt, t.signonrank
                FROM tblcontract t
                INNER JOIN (
                    SELECT idperson, MAX(idcontract) AS max_idcontract
                    FROM tblcontract 
                    WHERE deletests = 0 
                    GROUP BY idperson
                ) x ON x.idperson = t.idperson AND x.max_idcontract = t.idcontract
            ) C ON A.idperson = C.idperson 
            LEFT JOIN (
                SELECT 
                    idperson,
                    {$pivot_subquery_sql}
                    'dummy' AS dummy
                FROM (
                    SELECT idperson, certname, issdate, expdate
                    FROM tblcertdoc
                    WHERE deletests = '0' AND certname NOT IN ('PASSPORT', 'SEAMAN BOOK') AND display = 'Y'
                    UNION ALL
                    SELECT idperson, 
                           CASE WHEN kdcert = 55 THEN 'PASSPORT' WHEN kdcert = 56 THEN 'SEAMAN BOOK' END AS certname,
                           docissdt AS issdate,
                           docexpdt AS expdate
                    FROM tblpersonaldoc
                    WHERE deletests = 0 AND kdcert IN (55, 56)
                ) combined_cert
                GROUP BY idperson
            ) cert ON A.idperson = cert.idperson
            LEFT JOIN mstrank MR ON C.signonrank = MR.kdrank
            LEFT JOIN mstvessel D ON D.kdvsl = C.signonvsl
            LEFT JOIN tblnegara F ON F.KdNegara = A.nationalid
            WHERE A.deletests = '0'
              AND A.noncrew = 0
              AND (A.inAktif = '0' OR A.inAktif IS NULL)
              AND (A.inBlacklist = '0' OR A.inBlacklist IS NULL)
            ORDER BY crew_status ASC, MR.urutan ASC, fullName ASC
        ";

        $rows = $this->db->query($sql)->result_array();

        $data = array();
        foreach ($rows as $row) {
            $data[] = $row;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'success' => true,
                'data'    => $data
            )));
    }

    public function exportCrewMatrixExcel()
    {
        $idpersons_json = $this->input->post('idpersons');

        if (empty($idpersons_json)) {
            show_error('No data to export or invalid request.');
            return;
        }

        $idpersons = json_decode($idpersons_json, true);
        if (empty($idpersons)) {
            show_error('No data to export.');
            return;
        }

        // Sanitize IDs
        $ids_escaped = array();
        foreach ($idpersons as $id) {
            $ids_escaped[] = $this->db->escape_str($id);
        }
        $ids = implode("','", $ids_escaped);

        // Get dynamic certs
        $sqlCert = "SELECT certname FROM mstcert WHERE deletests = 0 AND show_matrix = 'Y' ORDER BY certname ASC";
        $active_certs = $this->db->query($sqlCert)->result_array();

        $pivot_subquery_sql = "";
        $outer_select_sql = "";
        foreach ($active_certs as $cert) {
            $cert_name = $cert['certname'];
            $alias_iss = "iss_" . preg_replace('/[^a-zA-Z0-9]/', '_', $cert_name);
            $alias_exp = "exp_" . preg_replace('/[^a-zA-Z0-9]/', '_', $cert_name);
            $pivot_subquery_sql .= " MAX(CASE WHEN certname = '".$this->db->escape_str($cert_name)."' THEN issdate END) AS {$alias_iss}, ";
            $pivot_subquery_sql .= " MAX(CASE WHEN certname = '".$this->db->escape_str($cert_name)."' THEN expdate END) AS {$alias_exp}, ";
            $outer_select_sql .= " cert.{$alias_iss}, ";
            $outer_select_sql .= " cert.{$alias_exp}, ";
        }

        $sql = "
            SELECT
                A.idperson,
                TRIM(CONCAT_WS(' ', A.fname, A.mname, A.lname)) AS fullName,
                CASE WHEN C.signoffdt = '0000-00-00' THEN 'On Board' ELSE 'Stand By' END AS crew_status,
                IFNULL(MR.nmrank, '') AS nmrank,
                F.NmNegara,
                A.dob,
                D.nmvsl AS signonvsl,
                C.signondt,
                C.signoffdt,
                C.estsignoffdt,
                {$outer_select_sql}
                'dummy' AS dummy
            FROM mstpersonal A
            INNER JOIN (
                SELECT t.idperson, t.signonvsl, t.signondt, t.signoffdt, t.estsignoffdt, t.signonrank
                FROM tblcontract t
                INNER JOIN (
                    SELECT idperson, MAX(idcontract) AS max_idcontract
                    FROM tblcontract WHERE deletests = 0 GROUP BY idperson
                ) x ON x.idperson = t.idperson AND x.max_idcontract = t.idcontract
            ) C ON A.idperson = C.idperson
            LEFT JOIN (
                SELECT
                    idperson,
                    {$pivot_subquery_sql}
                    'dummy' AS dummy
                FROM (
                    SELECT idperson, certname, issdate, expdate
                    FROM tblcertdoc
                    WHERE deletests = '0' AND certname NOT IN ('PASSPORT', 'SEAMAN BOOK')
                    UNION ALL
                    SELECT idperson,
                           CASE WHEN kdcert = 55 THEN 'PASSPORT' WHEN kdcert = 56 THEN 'SEAMAN BOOK' END AS certname,
                           docissdt AS issdate, docexpdt AS expdate
                    FROM tblpersonaldoc
                    WHERE deletests = 0 AND kdcert IN (55, 56)
                ) combined_cert
                GROUP BY idperson
            ) cert ON A.idperson = cert.idperson
            LEFT JOIN mstrank MR ON C.signonrank = MR.kdrank
            LEFT JOIN mstvessel D ON D.kdvsl = C.signonvsl
            LEFT JOIN tblnegara F ON F.KdNegara = A.nationalid
            WHERE A.deletests = '0'
              AND A.idperson IN ('{$ids}')
            ORDER BY crew_status ASC, MR.urutan ASC, fullName ASC
        ";

        $rows = $this->db->query($sql)->result();

        $data['rows']         = $rows;
        $data['dynamic_certs'] = $active_certs;

        $this->load->view('Report/CrewMatrix/pdf_crewmatrix', $data);
    }
}
