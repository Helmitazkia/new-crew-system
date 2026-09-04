<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ActiveRoster extends CI_Controller {

  function __construct()
    {
        parent::__construct();

        $this->load->model('MCrewscv');
        $this->load->library('../controllers/DataContext');
        $this->load->library('session');
        $allowed_methods = array('do_login');
        $current_method = $this->router->fetch_method();
        if (
            !in_array($current_method, $allowed_methods) &&
            !$this->session->userdata('isLogin')
        ) {
            redirect('auth/login');
            exit;
        }
    }

    public function index()
    {
        $data = array(
            'title'   => 'Active Roster',
            'active_menu' => 'active_roster'
        );

        $this->load->view('layout/header', $data);
        $this->load->view('Roster/ActiveRoster/active_roster');
        $this->load->view('layout/footer');
    }

    public function getActiveRoster()
    {
        $this->load->view('Roster/ActiveRoster/active_roster');
    }
    
    public function getAllData_activeRoster()
    {
        $dataContext = new DataContext();
        $status = $this->input->post('status');

        $where = "
            WHERE A.deletests = '0'
            AND (A.fname != '' OR A.mname != '' OR A.lname != '')
            AND (A.inAktif = '0' OR A.inAktif IS NULL)
            AND (A.inBlacklist = '0' OR A.inBlacklist IS NULL)
        ";
        
        $sql = "
            SELECT
                A.idperson,
                TRIM(CONCAT_WS(' ', A.fname, A.mname, A.lname)) AS fullName,
                IFNULL(MR.nmrank, '') AS applyfor,
                IFNULL(MR.urutan, 9999) AS rank_urutan,
                A.gender,
                A.religion,
                A.dob AS birth_date,
                K.NmKota AS birth_city,
                D.nmvsl,
                C.signondt,
                C.signoffdt,
                C.estsignoffdt,
                A.inBlacklist,
                A.inAktif,
                A.newapplicent,
                A.inaktif,
                K.deletests AS kota_deletests,
                (SELECT rankexp FROM tblseaexp 
                    WHERE idperson = A.idperson AND deletests = '0' 
                    ORDER BY idexp DESC, todtexp DESC LIMIT 1) AS rankexp,
                (SELECT GROUP_CONCAT(DISTINCT V.nmvsl ORDER BY R.idcrewrotation SEPARATOR ', ')
                 FROM tblcrewrotation R
                 LEFT JOIN mstvessel V ON V.kdvsl = R.signonvsl AND V.deletests = '0'
                 WHERE R.replacement_idperson = A.idperson AND R.status = 'Submit' AND R.deletests = '0') AS next_vessel
            FROM mstpersonal A
            LEFT JOIN (
                SELECT t.idperson, t.signonvsl, t.signondt, t.signoffdt, t.estsignoffdt, t.signonrank
                FROM tblcontract t
                INNER JOIN (
                    SELECT idperson, MAX(idcontract) AS max_idcontract
                    FROM tblcontract WHERE deletests = 0 GROUP BY idperson
                ) x ON x.idperson = t.idperson AND x.max_idcontract = t.idcontract
            ) C ON A.idperson = C.idperson 
            LEFT JOIN mstrank MR ON C.signonrank = MR.kdrank AND MR.urutan > 0
            LEFT JOIN tblkota K ON A.pob = K.KdKota 
            LEFT JOIN mstvessel D ON D.kdvsl = C.signonvsl
            $where
            GROUP BY A.idperson
            ORDER BY fullName ASC
        ";

        $rows = $this->db->query($sql)->result_array();
        $today = date('Y-m-d');
        $data = array();
        foreach ($rows as $row) {
            $city = $row['birth_city'];
            $date = $row['birth_date'];
            $dobFormatted = ($date && $date != '0000-00-00') ? $dataContext->convertReturnName($date) : '';

            // On board: signoffdt kosong (0000-00-00) → pakai estsignoffdt
            // Stand By: signoffdt ada value DAN sudah lewat hari ini → pakai signoffdt_formatted
            $statusPerson = null;
            if (isset($row['inBlacklist']) && $row['inBlacklist'] == '1' && isset($row['kota_deletests']) && $row['kota_deletests'] == '0') {
                $statusPerson = 'Not For Emp';
            } elseif (isset($row['inAktif']) && $row['inAktif'] == '1' && isset($row['inBlacklist']) && $row['inBlacklist'] == '0') {
                $statusPerson = 'Non Aktif';
            } elseif (isset($row['newapplicent']) && $row['newapplicent'] == '1'  && $row['signondt'] === null) {
                $statusPerson = 'Pickup';
            } elseif (isset($row['signoffdt']) && $row['signoffdt'] !== '' && $row['signoffdt'] !== null && $row['signoffdt'] !== '0000-00-00' && $row['signoffdt'] <= $today) {
                // Stand By: signoffdt ada value dan sudah lewat hari ini → pakai signoffdt_formatted
                $statusPerson = 'Stand By';
            } else {
                // On board: signoffdt kosong (0000-00-00) → pakai estsignoffdt
                if (isset($row['signoffdt']) || isset($row['estsignoffdt'])) {
                    $statusPerson = 'On board';
                }
            }

            $signondt = isset($row['signondt']) ? $row['signondt'] : '';
            $signondt_formatted = ($signondt !== '0000-00-00' && $signondt !== '') ? $dataContext->convertReturnName($signondt) : '';
            
            $signoffdt = isset($row['signoffdt']) ? $row['signoffdt'] : '';
            $estsignoffdt = isset($row['estsignoffdt']) ? $row['estsignoffdt'] : '';
            $estsignoffdt_formatted = ($estsignoffdt !== '0000-00-00' && $estsignoffdt !== '') ? $dataContext->convertReturnName($estsignoffdt) : '';
            $signoffdt_formatted = ($signoffdt !== '0000-00-00' && $signoffdt !== '') ? $dataContext->convertReturnName($signoffdt) : '';

            // Active Roster hanya tampilkan On board & Stand By
            if ($statusPerson !== 'On board' && $statusPerson !== 'Stand By') {
                continue;
            }

            $nextVessel = isset($row['next_vessel']) ? trim($row['next_vessel']) : '';
            $data[] = array(
                'idperson'     => $row['idperson'],
                'fullName'     => $row['fullName'],
                'applyfor'     => strtoupper(isset($row['applyfor']) ? $row['applyfor'] : ''),
                'rank_urutan'  => $row['rank_urutan'],
                'gender'       => $row['gender'],
                'religion'     => $row['religion'],
                'nmvsl'        => $row['nmvsl'],
                'next_vessel'  => $nextVessel,
                'dob'          => trim($city . ($dobFormatted ? ', ' . $dobFormatted : '')),
                'statusPerson' => $statusPerson,
                'rankexp'      => $row['rankexp'],
                'signondt'     => $signondt,
                'signondt_formatted' => $signondt_formatted,
                'estsignoffdt' => $estsignoffdt,
                'estsignoffdt_formatted' => $estsignoffdt_formatted,
                'signoffdt' => $signoffdt,
                'signoffdt_formatted' => $signoffdt_formatted
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('success' => true, 'data' => $data)));
    }

    public function exportPdf_activeRoster()
    {
        $idpersons_json = $this->input->post('idpersons');
        $statusFilter = $this->input->post('statusFilter');
        
        if (empty($idpersons_json)) {
            show_error('No data to export or invalid request.');
            return;
        }

        $idpersons = json_decode($idpersons_json, true);
        if (empty($idpersons)) {
            show_error('No data to export.');
            return;
        }

        // Sanitize IDs (compatible with older PHP)
        $ids_escaped = array();
        foreach ($idpersons as $id) {
            $ids_escaped[] = $this->db->escape_str($id);
        }
        $ids = implode("','", $ids_escaped);

        $sql = "
            SELECT 
                A.idcontract,
                A.idperson,
                TRIM(CONCAT_WS(' ', D.fname, D.mname, D.lname)) AS fullName,
                D.dob,
                A.kdcmprec,
                A.signondt,
                A.signoffdt,
                A.estsignoffdt,
                IFNULL(B.nmrank, '') AS nmrank,
                IFNULL(B.urutan, 999) AS rank_urutan,
                C.nmvsl,
                A.lastvsl,
                A.estremark
            FROM tblcontract A
            INNER JOIN (
                SELECT idperson, MAX(idcontract) AS max_idcontract
                FROM tblcontract
                WHERE deletests = 0
                GROUP BY idperson
            ) max_c ON A.idperson = max_c.idperson AND A.idcontract = max_c.max_idcontract
            LEFT JOIN mstrank B ON B.kdrank = A.signonrank AND urutan > 0
            LEFT JOIN mstvessel C ON C.kdvsl = A.signonvsl
            LEFT JOIN mstpersonal D ON D.idperson = A.idperson
            WHERE A.deletests = 0 
            AND A.idperson IN ('$ids')
            GROUP BY A.idperson 
            ORDER BY rank_urutan ASC, fullName ASC
        ";

        $rows = $this->db->query($sql)->result_array();
        
        if (empty($statusFilter)) {
            $statusFilter = 'ON BOARD';
        }

        $data = array(
            'rows' => $rows,
            'statusFilter' => $statusFilter,
            'printDate' => date('d M Y H:i:s')
        );

        require(APPPATH . "views/frontend/pdf/mpdf60/mpdf.php");
        $mpdf = new mPDF('utf-8', 'A4-L'); // Landscape
        
        $html = $this->load->view('Roster/ActiveRoster/export_crewlist', $data, TRUE);
        $mpdf->WriteHTML($html);

        $mpdf->Output("CrewList_ActiveRoster_" . date('Ymd_His') . ".pdf", 'I');
        exit;
    }
}