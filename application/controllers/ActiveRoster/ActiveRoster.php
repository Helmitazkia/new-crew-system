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

    // public function getActiveRoster()
    // {
    //     $data = array(
    //         'title' => 'Active Roster',
    //         'active_menu' => 'crew_roster',
    //         'content' => 'Roster/ActiveRoster/active_roster'
    //     );

    //     $this->load->view('menu/main_CrewLifecycle', $data);
    // }

    public function index()
    {
        $data = array(
            'title'   => 'Active Roster',
            'content' => 'Roster/ActiveRoster/active_roster'
        );

        $this->load->view('menu/main_CrewLifecycle', $data);
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
        ";

        $sql = "
            SELECT
                A.idperson,
                TRIM(CONCAT_WS(' ', A.fname, A.mname, A.lname)) AS fullName,
                A.applyfor,
                A.gender,
                A.religion,
                A.dob AS birth_date,
                K.NmKota AS birth_city,
                D.nmvsl,
                C.signoffdt,
                C.estsignoffdt, -- TAMBAHKAN INI
                SE.rankexp,
                CASE
                    WHEN A.inBlacklist = '1' AND K.deletests = '0' THEN 'Not For Emp'
                    WHEN A.inAktif = '1' AND A.inBlacklist = '0' THEN 'Non Aktif'
                    WHEN A.newapplicent = '1' AND K.deletests = '0' THEN 'Pickup'
                    WHEN C.signoffdt = '0000-00-00' AND A.inaktif = '0' AND A.deletests = '0' THEN 'On board'
                    WHEN C.signoffdt IS NOT NULL AND C.signoffdt != '0000-00-00' AND C.signoffdt <= CURDATE() THEN 'Stand By'
                END AS statusPerson
            FROM mstpersonal A
            LEFT JOIN (
                SELECT t.idperson, t.signonvsl, t.signoffdt, t.estsignoffdt
                FROM tblcontract t
                INNER JOIN (
                    SELECT idperson, MAX(idcontract) as max_idcontract
                    FROM tblcontract WHERE deletests = 0 GROUP BY idperson
                ) x ON x.idperson = t.idperson AND x.max_idcontract = t.idcontract
            ) C ON A.idperson = C.idperson
            LEFT JOIN tblkota K ON A.pob = K.KdKota 
            LEFT JOIN mstvessel D ON D.kdvsl = C.signonvsl
            LEFT JOIN (
                SELECT s1.idperson, s1.rankexp
                FROM tblseaexp s1
                WHERE s1.idexp = (
                    SELECT MAX(s2.idexp) FROM tblseaexp s2 WHERE s2.idperson = s1.idperson
                )
            ) SE ON a.idperson = SE.idperson
            $where
            GROUP BY A.idperson
            ORDER BY fullName ASC
        ";

        $rows = $this->db->query($sql)->result_array();
        $data = array();
        foreach ($rows as $row) {
            $city = $row['birth_city'];
            $date = $row['birth_date'];
            $dobFormatted = ($date && $date != '0000-00-00') ? $dataContext->convertReturnName($date) : '';

            $data[] = array(
                'idperson'     => $row['idperson'],
                'fullName'     => $row['fullName'],
                'applyfor'     => strtoupper($row['applyfor']),
                'gender'       => $row['gender'],
                'religion'     => $row['religion'],
                'nmvsl'        => $row['nmvsl'],
                'dob'          => trim($city . ($dobFormatted ? ', ' . $dobFormatted : '')),
                'statusPerson' => $row['statusPerson'],
                'rankexp'      => $row['rankexp'],
                'estsignoffdt' => $row['estsignoffdt'],
                'estsignoffdt_formatted' => ($row['estsignoffdt'] != '0000-00-00' && $row['estsignoffdt'] != '') ? $dataContext->convertReturnName($row['estsignoffdt']) : ''
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('success' => true, 'data' => $data)));
    }
}