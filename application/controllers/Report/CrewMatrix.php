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
        
        // Fetch dynamic certificates where show_matrix = 'Y'
        $sqlCert = "SELECT certname FROM mstcert WHERE deletests = 0 AND show_matrix = 'Y' ORDER BY certname ASC";
        // Supaya tidak error saat show_matrix belum dibuat, kita handle menggunakan num_fields atau try-catch
        // Namun karena MySQL di CI3, kita coba langsung. Jika error, CI akan memunculkan DB error.
        // Sebaiknya kita asumsikan kolom sudah dibuat seperti PRD.
        $data['dynamic_certs'] = $this->db->query($sqlCert)->result_array();

        $this->load->view('layout/header', $data);
        $this->load->view('Report/CrewMatrix/view_crewmatrix', $data);
        $this->load->view('layout/footer');
    }

    public function getData_crewMatrix()
    {
        // Get all active certificates
        $sqlCert = "SELECT certname FROM mstcert WHERE deletests = 0 AND show_matrix = 'Y'";
        $active_certs = $this->db->query($sqlCert)->result_array();

        // Build dynamic PIVOT for certificates
        $pivot_subquery_sql = "";
        $outer_select_sql = "";
        foreach ($active_certs as $cert) {
            $cert_name = $cert['certname'];
            $alias_iss = "iss_" . preg_replace('/[^a-zA-Z0-9]/', '_', $cert_name);
            $alias_exp = "exp_" . preg_replace('/[^a-zA-Z0-9]/', '_', $cert_name);
            
            // For subquery (doing the actual pivot)
            $pivot_subquery_sql .= " MAX(CASE WHEN certname = '".$this->db->escape_str($cert_name)."' THEN issdate END) AS {$alias_iss}, ";
            $pivot_subquery_sql .= " MAX(CASE WHEN certname = '".$this->db->escape_str($cert_name)."' THEN expdate END) AS {$alias_exp}, ";

            // For outer query (just selecting the pivoted columns from the 'cert' alias)
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
                FROM tblcertdoc
                WHERE deletests = '0'
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
}
