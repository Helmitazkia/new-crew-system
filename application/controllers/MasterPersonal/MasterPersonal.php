<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MasterPersonal extends CI_Controller {
    
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
            'title'   => 'Crew Roster',
            'content' => 'Roster/MasterPersonal/master_personal'
        );

        $this->load->view('menu/main_CrewLifecycle', $data);
    }

    // KHUSUS AJAX
    public function getCrewRoster()
    {
        $this->load->view('Roster/MasterPersonal/master_personal');
    }

   
    public function getAllData_personal()
    {
        $txtSearch  = $this->input->post('txtSearch', true);
        $typeSearch = $this->input->post('typeSearch', true);
        $page       = (int) $this->input->post('page');
        $page   = ($page <= 0) ? 1 : $page;
        $limit  = 30;
        $offset = ($page - 1) * $limit;
        $dataContext = new DataContext();

        $where = " WHERE A.deletests = '0'
                AND (A.fname != '' OR A.mname != '' OR A.lname != '') ";
        
        $joinSea = "";

        if (!empty($txtSearch) && !empty($typeSearch)) {
            switch ($typeSearch) {
                case "id":
                    $where .= " AND A.idperson = '" . $this->db->escape_str($txtSearch) . "' ";
                    break;
                case "name":
                    $where .= " AND (
                        A.fname LIKE '%" . $this->db->escape_like_str($txtSearch) . "%' OR
                        A.mname LIKE '%" . $this->db->escape_like_str($txtSearch) . "%' OR
                        A.lname LIKE '%" . $this->db->escape_like_str($txtSearch) . "%' OR
                        CONCAT(A.fname,' ',A.mname,' ',A.lname) LIKE '%" . $this->db->escape_like_str($txtSearch) . "%'
                    )";
                    break;
                case "age":
                    $where .= " AND (YEAR(CURDATE()) - YEAR(A.dob)) = '" . $this->db->escape_str($txtSearch) . "' ";
                    break;
                case "rank":
                    $where .= " AND C.rankexp LIKE '%" . $this->db->escape_like_str($txtSearch) . "%' ";
                    $joinSea = "LEFT JOIN tblseaexp C ON C.idperson = A.idperson";
                    break;
                case "applied":
                    $where .= " AND A.applyfor LIKE '%" . $this->db->escape_like_str($txtSearch) . "%' ";
                    break;
                case "vessel":
                    $where .= " AND C.vslexp LIKE '%" . $this->db->escape_like_str($txtSearch) . "%' ";
                    $joinSea = "LEFT JOIN tblseaexp C ON C.idperson = A.idperson";
                    break;
                case "idPerson":
                    $where .= " AND A.idperson = '" . $this->db->escape_str($txtSearch) . "' ";
                    break;
                default:
                    $where .= " AND (
                        A.fname LIKE '%" . $this->db->escape_like_str($txtSearch) . "%' OR
                        A.mname LIKE '%" . $this->db->escape_like_str($txtSearch) . "%' OR
                        A.lname LIKE '%" . $this->db->escape_like_str($txtSearch) . "%'
                    )";
                    break;
            }
        }

        $sqlCount = "
            SELECT COUNT(DISTINCT A.idperson) AS total
            FROM mstpersonal A
            LEFT JOIN tblkota B ON A.pob = B.KdKota
            " . $joinSea . "
            " . $where . "
        ";

        $total = (int) $this->db->query($sqlCount)->row()->total;

        $sql = "
            SELECT 
                A.idperson,
                TRIM(CONCAT(A.fname,' ',A.mname,' ',A.lname)) AS fullName,
                A.applyfor,
                A.gender,
                A.religion,
                A.dob,
                A.inAktif,
                A.lower_rank,
                B.NmKota
            FROM mstpersonal A
            LEFT JOIN tblkota B ON A.pob = B.KdKota
            " . $joinSea . "
            " . $where . "
            GROUP BY A.idperson
            ORDER BY fullName ASC
            LIMIT $limit OFFSET $offset
        ";

        $rows = $this->db->query($sql)->result_array();

        $data = array();
        foreach ($rows as $row) {
            $data[] = array(
                'idperson'     => $row['idperson'],
                'fullName'     => $row['fullName'],
                'applyfor'     => strtoupper($row['applyfor']),
                'gender'       => $row['gender'],
                'religion'     => $row['religion'],
                'NmKota'        => $row['NmKota'],
                'dob'          => $dataContext->convertReturnName($row['dob']),
                'statusPerson' => ($row['inAktif'] == '0') ? 'Active' : 'Non Active',
                'lowerRank'    => ($row['lower_rank'] == '1') ? 'Yes' : 'No',
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'success' => true,
                'page'    => $page,
                'limit'   => $limit,
                'total'   => $total,
                'data'    => $data
            )));
    }
    public function getDataOnboard($searchNya = "")
    {
        $dataContext = new DataContext();
        $dbSeaExp = "";

        $whereNya = "
            WHERE A.deletests = '0'
            AND B.deletests = '0'
            AND B.signoffdt = '0000-00-00'
            AND A.inaktif = '0'
            AND D.deletests = '0'
        ";

        if ($searchNya == "search") {
            $txtSearch  = $this->input->post('txtSearch', true);
            $typeSearch = $this->input->post('typeSearch', true);

            if ($txtSearch != "") {
                switch ($typeSearch) {
                    case "id":
                        $whereNya .= " AND A.idperson = '".$txtSearch."' ";
                        break;

                    case "name":
                        $whereNya .= " AND (
                            A.fname LIKE '%".$txtSearch."%' OR
                            A.mname LIKE '%".$txtSearch."%' OR
                            A.lname LIKE '%".$txtSearch."%'
                        )";
                        break;

                    case "age":
                        $whereNya .= "
                            AND (SUBSTRING(CURDATE(),1,4)-SUBSTRING(A.dob,1,4)) = '".$txtSearch."'
                        ";
                        break;

                    case "rank":
                        $whereNya .= " AND E.rankexp LIKE '%".$txtSearch."%' ";
                        $dbSeaExp = "LEFT JOIN tblseaexp E ON E.idperson = A.idperson";
                        break;

                    case "applied":
                        $whereNya .= " AND A.applyfor LIKE '%".$txtSearch."%' ";
                        break;

                    case "vessel":
                        $whereNya .= " AND E.vslexp LIKE '%".$txtSearch."%' ";
                        $dbSeaExp = "LEFT JOIN tblseaexp E ON E.idperson = A.idperson";
                        break;
                }
            }
        }

        $sql = "
            SELECT 
                A.idperson,
                TRIM(CONCAT(A.fname,' ',A.mname,' ',A.lname)) AS fullName,
                A.applyfor,
                A.gender,
                A.religion,
                A.dob,
                C.NmKota,
                CASE WHEN A.inAktif = '0' THEN 'Aktif' ELSE 'Non Aktif' END AS statusPerson,
                CASE WHEN A.lower_rank = 1 THEN 'Yes' ELSE 'No' END AS lowerRank
            FROM mstpersonal A
            LEFT JOIN tblcontract B ON A.idperson = B.idperson
            LEFT JOIN tblkota C ON A.pob = C.KdKota
            LEFT JOIN mstvessel D ON D.kdvsl = B.signonvsl
            $dbSeaExp
            $whereNya
            GROUP BY A.idperson
            ORDER BY fullName ASC
        ";

        $rows = $this->MCrewscv->getDataQuery($sql);

        // FORMAT DOB DI BACKEND (optional tapi rapi)
        foreach ($rows as &$r) {
            $r->dob = $dataContext->convertReturnName($r->dob);
        }

        echo json_encode(array(
            'success' => true,
            'status'  => 'onboard',
            'data'    => $rows
        ));
    }

    public function getDataOnLeave($searchNya = "")
{
    $dataContext = new DataContext();
    $dbSeaExp = "";

    $whereNya = "
        WHERE A.deletests = '0'
        AND B.deletests = '0'
        AND A.inAktif = '0'
        AND A.inBlacklist = '0'
        AND B.idcontract IN (
            SELECT MAX(idcontract)
            FROM tblcontract
            WHERE idperson = B.idperson
            AND deletests = 0
        )
        AND (B.signoffdt != '0000-00-00' AND B.signoffdt <= CURDATE())
    ";

    /* ================= SEARCH ================= */
    if ($searchNya == "search") {
        $txtSearch  = $this->input->post('txtSearch', true);
        $typeSearch = $this->input->post('typeSearch', true);

        if ($txtSearch != "") {
            switch ($typeSearch) {
                case "id":
                    $whereNya .= " AND A.idperson = '".$txtSearch."' ";
                    break;

                case "name":
                    $whereNya .= " AND (
                        A.fname LIKE '%".$txtSearch."%' OR
                        A.mname LIKE '%".$txtSearch."%' OR
                        A.lname LIKE '%".$txtSearch."%'
                    )";
                    break;

                case "age":
                    $whereNya .= "
                        AND (SUBSTRING(CURDATE(),1,4)-SUBSTRING(A.dob,1,4)) = '".$txtSearch."'
                    ";
                    break;

                case "rank":
                    $whereNya .= " AND D.rankexp LIKE '%".$txtSearch."%' ";
                    $dbSeaExp = "LEFT JOIN tblseaexp D ON D.idperson = A.idperson";
                    break;

                case "applied":
                    $whereNya .= " AND A.applyfor LIKE '%".$txtSearch."%' ";
                    break;

                case "vessel":
                    $whereNya .= " AND D.vslexp LIKE '%".$txtSearch."%' ";
                    $dbSeaExp = "LEFT JOIN tblseaexp D ON D.idperson = A.idperson";
                    break;
            }
        }
    }

    /* ================= QUERY ================= */
    $sql = "
        SELECT 
            A.idperson,
            TRIM(CONCAT(A.fname,' ',A.mname,' ',A.lname)) AS fullName,
            A.applyfor,
            A.gender,
            A.religion,
            A.dob,
            C.NmKota,
            CASE WHEN A.inAktif = '0' THEN 'Aktif' ELSE 'Non Aktif' END AS statusPerson,
            CASE WHEN A.lower_rank = 1 THEN 'Yes' ELSE 'No' END AS lowerRank,
            B.signoffdt
        FROM mstpersonal A
        LEFT JOIN tblcontract B ON A.idperson = B.idperson
        LEFT JOIN tblkota C ON A.pob = C.KdKota
        $dbSeaExp
        $whereNya
        GROUP BY A.idperson
        ORDER BY fullName ASC
    ";

    $rows = $this->MCrewscv->getDataQuery($sql);

    /* ================= FORMAT DOB ================= */
    foreach ($rows as &$r) {
        $r->dob = $dataContext->convertReturnName($r->dob);
    }

    /* ================= JSON ================= */
    echo json_encode(array(
        'success' => true,
        'status'  => 'onleave',
        'total'   => count($rows),
        'data'    => $rows
    ));
}

public function getDataNonAktif($searchNya = "")
{
    $dataContext = new DataContext();
    $dbSeaExp = "";

    $whereNya = "
        WHERE A.deletests = '0'
        AND B.deletests = '0' 
        AND A.inAktif = '1'
        AND A.inBlacklist = '0'
    ";

    /* ================= SEARCH ================= */
    if ($searchNya == "search") {
        $txtSearch  = $this->input->post('txtSearch', true);
        $typeSearch = $this->input->post('typeSearch', true);

        if ($txtSearch != "") {
            switch ($typeSearch) {
                case "id":
                    $whereNya .= " AND A.idperson = '".$txtSearch."' ";
                    break;

                case "name":
                    $whereNya .= " AND (
                        A.fname LIKE '%".$txtSearch."%' OR
                        A.mname LIKE '%".$txtSearch."%' OR
                        A.lname LIKE '%".$txtSearch."%'
                    )";
                    break;

                case "age":
                    $whereNya .= "
                        AND (SUBSTRING(CURDATE(),1,4)-SUBSTRING(A.dob,1,4)) = '".$txtSearch."'
                    ";
                    break;

                case "rank":
                    $whereNya .= " AND D.rankexp LIKE '%".$txtSearch."%' ";
                    $dbSeaExp = "LEFT JOIN tblseaexp D ON D.idperson = A.idperson";
                    break;

                case "applied":
                    $whereNya .= " AND A.applyfor LIKE '%".$txtSearch."%' ";
                    break;

                case "vessel":
                    $whereNya .= " AND D.vslexp LIKE '%".$txtSearch."%' ";
                    $dbSeaExp = "LEFT JOIN tblseaexp D ON D.idperson = A.idperson";
                    break;
            }
        }
    }

    /* ================= QUERY ================= */
    $sql = "
        SELECT 
            A.idperson,
            TRIM(CONCAT(A.fname,' ',A.mname,' ',A.lname)) AS fullName,
            A.applyfor,
            A.gender,
            A.religion,
            A.dob,
            B.NmKota,
            CASE 
                WHEN A.inAktif = '0' THEN 'Aktif'
                ELSE 'Non Aktif'
            END AS statusPerson,
            CASE 
                WHEN A.lower_rank = 1 THEN 'Yes'
                ELSE 'No'
            END AS lowerRank
        FROM mstpersonal A
        LEFT JOIN tblkota B ON A.pob = B.KdKota
        $dbSeaExp
        $whereNya
        GROUP BY A.idperson
        ORDER BY fullName ASC
    ";

    $rows = $this->MCrewscv->getDataQuery($sql);

    /* ================= FORMAT DOB ================= */
    foreach ($rows as &$r) {
        $r->dob = $dataContext->convertReturnName($r->dob);
    }

    /* ================= JSON ================= */
    echo json_encode(array(
        'success' => true,
        'status'  => 'nonaktif',
        'total'   => count($rows),
        'data'    => $rows
    ));
}


public function getDataNotForEmp($searchNya = "")
{
    $dataContext = new DataContext();
    $dbSeaExp = "";

    $whereNya = " WHERE A.deletests = '0' AND B.deletests = '0' AND A.inBlacklist = '1' ";

    /* ================= SEARCH ================= */
    if ($searchNya == "search") {
        $txtSearch  = $this->input->post('txtSearch', true);
        $typeSearch = $this->input->post('typeSearch', true);

        if ($txtSearch != "") {
            switch ($typeSearch) {
                case "id":
                    $whereNya .= " AND A.idperson = '".$txtSearch."' ";
                    break;

                case "name":
                    $whereNya .= " AND (
                        A.fname LIKE '%".$txtSearch."%' OR
                        A.mname LIKE '%".$txtSearch."%' OR
                        A.lname LIKE '%".$txtSearch."%'
                    )";
                    break;

                case "age":
                    $whereNya .= "
                        AND (SUBSTRING(CURDATE(),1,4)-SUBSTRING(A.dob,1,4)) = '".$txtSearch."'
                    ";
                    break;

                case "rank":
                    $whereNya .= " AND D.rankexp LIKE '%".$txtSearch."%' ";
                    $dbSeaExp = "LEFT JOIN tblseaexp D ON D.idperson = A.idperson";
                    break;

                case "applied":
                    $whereNya .= " AND A.applyfor LIKE '%".$txtSearch."%' ";
                    break;

                case "vessel":
                    $whereNya .= " AND D.vslexp LIKE '%".$txtSearch."%' ";
                    $dbSeaExp = "LEFT JOIN tblseaexp D ON D.idperson = A.idperson";
                    break;
            }
        }
    }

    /* ================= QUERY ================= */
    $sql = "
        SELECT 
            A.idperson,
            TRIM(CONCAT(A.fname,' ',A.mname,' ',A.lname)) AS fullName,
            A.applyfor,
            A.gender,
            A.religion,
            A.dob,
            B.NmKota,
            CASE 
                WHEN A.inAktif = '0' THEN 'Aktif'
                ELSE 'Non Aktif'
            END AS statusPerson,
            CASE 
                WHEN A.lower_rank = 1 THEN 'Yes'
                ELSE 'No'
            END AS lowerRank
        FROM mstpersonal A
        LEFT JOIN tblkota B ON A.pob = B.KdKota
        $dbSeaExp
        $whereNya
        GROUP BY A.idperson
        ORDER BY fullName ASC
    ";

    $rows = $this->MCrewscv->getDataQuery($sql);

    /* ================= FORMAT DOB ================= */
    foreach ($rows as &$r) {
        $r->dob = $dataContext->convertReturnName($r->dob);
    }

    /* ================= JSON ================= */
    echo json_encode(array(
        'success' => true,
        'status'  => 'nonforemp',
        'total'   => count($rows),
        'data'    => $rows
    ));
}

public function getDataPickup($searchNya = "")
{
    $dataContext = new DataContext();
    $dbSeaExp = "";

    $whereNya = " WHERE A.deletests = '0' AND B.deletests = '0' AND A.newapplicent = '1' ";

    /* ================= SEARCH ================= */
    if ($searchNya == "search") {
        $txtSearch  = $this->input->post('txtSearch', true);
        $typeSearch = $this->input->post('typeSearch', true);

        if ($txtSearch != "") {
            switch ($typeSearch) {
                case "id":
                    $whereNya .= " AND A.idperson = '".$txtSearch."' ";
                    break;

                case "name":
                    $whereNya .= " AND (
                        A.fname LIKE '%".$txtSearch."%' OR
                        A.mname LIKE '%".$txtSearch."%' OR
                        A.lname LIKE '%".$txtSearch."%'
                    )";
                    break;

                case "age":
                    $whereNya .= "
                        AND (SUBSTRING(CURDATE(),1,4)-SUBSTRING(A.dob,1,4)) = '".$txtSearch."'
                    ";
                    break;

                case "rank":
                    $whereNya .= " AND D.rankexp LIKE '%".$txtSearch."%' ";
                    $dbSeaExp = "LEFT JOIN tblseaexp D ON D.idperson = A.idperson";
                    break;

                case "applied":
                    $whereNya .= " AND A.applyfor LIKE '%".$txtSearch."%' ";
                    break;

                case "vessel":
                    $whereNya .= " AND D.vslexp LIKE '%".$txtSearch."%' ";
                    $dbSeaExp = "LEFT JOIN tblseaexp D ON D.idperson = A.idperson";
                    break;
            }
        }
    }

    /* ================= QUERY ================= */
    $sql = "
        SELECT 
            A.idperson,
            TRIM(CONCAT(A.fname,' ',A.mname,' ',A.lname)) AS fullName,
            A.applyfor,
            A.gender,
            A.religion,
            A.dob,
            B.NmKota,
            CASE 
                WHEN A.inAktif = '0' THEN 'Aktif'
                ELSE 'Non Aktif'
            END AS statusPerson,
            CASE 
                WHEN A.lower_rank = 1 THEN 'Yes'
                ELSE 'No'
            END AS lowerRank,
            (SUBSTRING(CURDATE(),1,4) - SUBSTRING(A.dob,1,4)) AS umur,
            A.pic
        FROM mstpersonal A
        LEFT JOIN tblkota B ON A.pob = B.KdKota
        LEFT JOIN new_applicant NA ON A.email = NA.email
        $dbSeaExp
        $whereNya
        GROUP BY A.idperson
        ORDER BY fullName ASC
    ";

    $rows = $this->MCrewscv->getDataQuery($sql);

    /* ================= FORMAT DOB ================= */
    foreach ($rows as &$r) {
        $r->dob = $dataContext->convertReturnName($r->dob);
    }

    /* ================= JSON ================= */
    echo json_encode(array(
        'success' => true,
        'status'  => 'pickup',
        'total'   => count($rows),
        'data'    => $rows
    ));
}

}