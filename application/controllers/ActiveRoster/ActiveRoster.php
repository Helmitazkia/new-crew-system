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

    // public function getAllData_activeRoster()
    // {
    //     $dataContext = new DataContext();

    //     $status = $this->input->post('status'); // optional

    //     $where = "
    //         WHERE A.deletests = '0'
    //         AND (A.fname != '' OR A.mname != '' OR A.lname != '')
    //     ";

    //     $sql = "
    //         SELECT
    //             A.idperson,
    //             TRIM(CONCAT_WS(' ', A.fname, A.mname, A.lname)) AS fullName,
    //             A.applyfor,
    //             A.gender,
    //             A.religion,
    //             A.dob,
    //             K.NmKota AS birth_city,
    //             A.dob AS birth_date,
    //             D.nmvsl,
    //             CASE
    //                 WHEN
    //                      A.inBlacklist = '1' AND K.deletests = '0'
    //                 THEN 'Not For Emp'
    //                 WHEN
    //                     A.inAktif = '1'
    //                     AND A.inBlacklist = '0'
    //                 THEN 'Non Aktif'
    //                 WHEN
    //                      A.newapplicent = '1' AND K.deletests = '0'
    //                 THEN 'Pickup'
    //                 WHEN 
    //                     C.signoffdt = '0000-00-00'
    //                     AND A.inaktif = '0'
    //                     AND A.deletests = '0'
    //                 THEN 'On board'
    //                 WHEN C.signoffdt IS NOT NULL
    //                     AND C.signoffdt != '0000-00-00'
    //                     AND C.signoffdt <= CURDATE()
    //                 THEN 'Stand By'
    //             END AS statusPerson

    //         FROM mstpersonal A  
    //         left join (
    //             select
    //                 t.idperson,
    //                 t.signonvsl,
    //                 t.signoffdt
    //             from
    //                 tblcontract t
    //             inner join (
    //                 select
    //                     idperson,
    //                     MAX(idcontract) as max_idcontract
    //                 from
    //                     tblcontract
    //                 where
    //                     deletests = 0
    //                 group by
    //                     idperson
    //             ) x
    //                 on
    //                 x.idperson = t.idperson
    //                 and x.max_idcontract = t.idcontract
    //         ) C on
    //             A.idperson = C.idperson

    //         LEFT JOIN tblkota K ON A.pob = K.KdKota 
    //         LEFT JOIN mstvessel D ON D.kdvsl = C.signonvsl
    //         $where
    //         ORDER BY fullName ASC
    //     ";
      

        

    //     $rows = $this->db->query($sql)->result_array();

    //     $data = array();
    //     foreach ($rows as $row) {
    //         $city = $row['birth_city'];
    //         $date = $row['birth_date'];
    //         $dobFormatted = '';
    //         if ($date && $date != '0000-00-00') {
    //             $dobFormatted = $dataContext->convertReturnName($date);
    //         }
    //         // $rankexp = $this->getLastRankExp($row['idperson']);

    //         $data[] = array(
    //             'idperson'      => $row['idperson'],
    //             'fullName'      => $row['fullName'],
    //             'applyfor'      => strtoupper($row['applyfor']),
    //             'gender'        => $row['gender'],
    //             'religion'      => $row['religion'],
    //             'nmvsl'         => $row['nmvsl'],
    //             'dob' => trim($city . ($dobFormatted ? ', ' . $dobFormatted : '')),
    //             'statusPerson' => $row['statusPerson']
    //             // 'rankexp'       => $rankexp
    //         );
    //     }



    //     $this->output
    //         ->set_content_type('application/json')
    //         ->set_output(json_encode(array(
    //             'success' => true,
    //             'data'    => $data
    //         )));
    // }

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
                A.dob,
                K.NmKota AS birth_city,
                A.dob AS birth_date,
                D.nmvsl,
                SE.rankexp, -- Kolom baru dari hasil JOIN
                CASE
                    WHEN A.inBlacklist = '1' AND K.deletests = '0' THEN 'Not For Emp'
                    WHEN A.inAktif = '1' AND A.inBlacklist = '0' THEN 'Non Aktif'
                    WHEN A.newapplicent = '1' AND K.deletests = '0' THEN 'Pickup'
                    WHEN C.signoffdt = '0000-00-00' AND A.inaktif = '0' AND A.deletests = '0' THEN 'On board'
                    WHEN C.signoffdt IS NOT NULL AND C.signoffdt != '0000-00-00' AND C.signoffdt <= CURDATE() THEN 'Stand By'
                END AS statusPerson
            FROM mstpersonal A
            LEFT JOIN (
                SELECT t.idperson, t.signonvsl, t.signoffdt
                FROM tblcontract t
                INNER JOIN (
                    SELECT idperson, MAX(idcontract) as max_idcontract
                    FROM tblcontract WHERE deletests = 0 GROUP BY idperson
                ) x ON x.idperson = t.idperson AND x.max_idcontract = t.idcontract
            ) C ON A.idperson = C.idperson
            LEFT JOIN tblkota K ON A.pob = K.KdKota 
            LEFT JOIN mstvessel D ON D.kdvsl = C.signonvsl
            
            /* SOLUSI AGAR CEPAT: Join Sekali Saja untuk rankexp */
            LEFT JOIN (
                SELECT s1.idperson, s1.rankexp
                FROM tblseaexp s1
                WHERE s1.idexp = (
                    SELECT MAX(s2.idexp) 
                    FROM tblseaexp s2 
                    WHERE s2.idperson = s1.idperson
                )
            ) SE ON a.idperson = SE.idperson
             
            $where
            group By A.idperson
            ORDER BY fullName ASC



        ";

        $rows = $this->db->query($sql)->result_array();

        $data = array();
        foreach ($rows as $row) {
            $city = $row['birth_city'];
            $date = $row['birth_date'];
            $dobFormatted = '';
            if ($date && $date != '0000-00-00') {
                $dobFormatted = $dataContext->convertReturnName($date);
            }

            $data[] = array(
                'idperson'     => $row['idperson'],
                'fullName'     => $row['fullName'],
                'applyfor'     => strtoupper($row['applyfor']),
                'gender'       => $row['gender'],
                'religion'     => $row['religion'],
                'nmvsl'        => $row['nmvsl'],
                'dob'          => trim($city . ($dobFormatted ? ', ' . $dobFormatted : '')),
                'statusPerson' => $row['statusPerson'],
                'rankexp'      => $row['rankexp']
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'success' => true,
                'data'    => $data
            )));
    }

    public function getLastRankExp($idperson)
    {
        $sql = "
            SELECT rankexp
            FROM tblseaexp
            WHERE idperson = ?
            ORDER BY todtexp DESC
            LIMIT 1
        ";

        $query = $this->db->query($sql, array($idperson));

        if ($query->num_rows() > 0) {
            return $query->row()->rankexp;
        }

        return null;
    }

    // public function getAllData_activeRoster()
    // {
    //     $dataContext = new DataContext();
    //     $status = $this->input->post('status');

    //     $where = "
    //         WHERE A.deletests = '0'
    //         AND (A.fname != '' OR A.mname != '' OR A.lname != '')
    //     ";

    //     $sql = "
    //         SELECT
    //             A.idperson,
    //             TRIM(CONCAT_WS(' ', A.fname, A.mname, A.lname)) AS fullName,
    //             A.applyfor,
    //             A.gender,
    //             A.religion,
    //             A.dob,
    //             K.NmKota AS birth_city,
    //             A.dob AS birth_date,
    //             D.nmvsl,
    //             CASE
    //                 WHEN A.inBlacklist = '1' AND K.deletests = '0' THEN 'Not For Emp'
    //                 WHEN A.inAktif = '1' AND A.inBlacklist = '0' THEN 'Non Aktif'
    //                 WHEN A.newapplicent = '1' AND K.deletests = '0' THEN 'Pickup'
    //                 WHEN C.signoffdt = '0000-00-00' AND A.inaktif = '0' AND A.deletests = '0' THEN 'On board'
    //                 WHEN C.signoffdt IS NOT NULL AND C.signoffdt != '0000-00-00' AND C.signoffdt <= CURDATE() THEN 'Stand By'
    //             END AS statusPerson
    //         FROM mstpersonal A
    //         LEFT JOIN (
    //             SELECT *
    //             FROM tblcontract t1
    //             WHERE t1.deletests = 0
    //             AND t1.idcontract = (
    //                 SELECT MAX(t2.idcontract)
    //                 FROM tblcontract t2
    //                 WHERE t2.idperson = t1.idperson
    //                 AND t2.deletests = 0
    //             )
    //         ) C ON A.idperson = C.idperson
    //         LEFT JOIN tblkota K ON A.pob = K.KdKota 
    //         LEFT JOIN mstvessel D ON D.kdvsl = C.signonvsl
    //         " . $where . "
    //         ORDER BY fullName ASC
    //     ";

    //     $rows = $this->db->query($sql)->result_array();
        
    //     // AMBIL SEMUA IDPERSON TANPA array_column()
    //     $personIds = array();
    //     foreach ($rows as $row) {
    //         $personIds[] = $row['idperson'];
    //     }
        
    //     // Panggil fungsi batch jika ada idperson
    //     if (!empty($personIds)) {
    //         $ranks = $this->getRankexpBatch($personIds);
    //     } else {
    //         $ranks = array();
    //     }

    //     $data = array();
    //     foreach ($rows as $row) {
    //         $city = $row['birth_city'];
    //         $date = $row['birth_date'];
    //         $dobFormatted = '';
    //         if ($date && $date != '0000-00-00') {
    //             $dobFormatted = $dataContext->convertReturnName($date);
    //         }

    //         $data[] = array(
    //             'idperson'      => $row['idperson'],
    //             'fullName'      => $row['fullName'],
    //             'applyfor'      => strtoupper($row['applyfor']),
    //             'gender'        => $row['gender'],
    //             'religion'      => $row['religion'],
    //             'nmvsl'         => $row['nmvsl'],
    //             'dob'           => trim($city . ($dobFormatted ? ', ' . $dobFormatted : '')),
    //             'statusPerson'  => $row['statusPerson'],
    //             'rankexp'       => isset($ranks[$row['idperson']]) ? $ranks[$row['idperson']] : null
    //         );
    //     }

    //     $this->output
    //         ->set_content_type('application/json')
    //         ->set_output(json_encode(array(
    //             'success' => true,
    //             'data'    => $data
    //         )));
    // }

    // // FUNGSI BARU UNTUK AMBIL RANKEXP BATCH
    // private function getRankexpBatch($personIds)
    // {
    //     if (empty($personIds)) {
    //         return array();
    //     }
        
    //     // Escape semua ID untuk keamanan
    //     $escapedIds = array();
    //     foreach ($personIds as $id) {
    //         $escapedIds[] = $this->db->escape($id);
    //     }
        
    //     $idsString = implode(',', $escapedIds);
        
    //     $sql = "
    //         SELECT s1.idperson, s1.rankexp
    //         FROM tblseaexp s1
    //         INNER JOIN (
    //             SELECT idperson, MAX(todtexp) as maxdate
    //             FROM tblseaexp
    //             WHERE idperson IN (" . $idsString . ")
    //             GROUP BY idperson
    //         ) s2 ON s1.idperson = s2.idperson AND s1.todtexp = s2.maxdate
    //     ";
        
    //     $result = $this->db->query($sql)->result_array();
        
    //     // Konversi ke format array [idperson => rankexp]
    //     $rankMap = array();
    //     foreach ($result as $row) {
    //         $rankMap[$row['idperson']] = $row['rankexp'];
    //     }
        
    //     return $rankMap;
    // }

    // // FUNGSI ALTERNATIF JIKA HANYA BUTUH SATU PERSON
    // private function getRankexpSingle($idperson)
    // {
    //     $sql = "
    //         SELECT rankexp 
    //         FROM tblseaexp 
    //         WHERE idperson = ?
    //         ORDER BY todtexp DESC 
    //         LIMIT 1
    //     ";
        
    //     $row = $this->db->query($sql, array($idperson))->row();
    //     return $row ? $row->rankexp : null;
    // }

}