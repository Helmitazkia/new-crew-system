<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NextPlan extends CI_Controller {

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
        $this->load->view('CrewDetail/next_plan');
    }

    /**
     * Detail read-only untuk Next Plan (mirip Crew Rotation detail tapi tanpa edit).
     * GET idcrewrotation
     */
    public function detail()
    {
        $idcrewrotation = $this->input->get('idcrewrotation');
        $row = null;
        if (!empty($idcrewrotation)) {
            $sql = "SELECT R.*, P.fullName AS onboard_name,
                    B.nmcmp AS company_name, C.nmrank AS onboard_rank_name, D.nmvsl AS onboard_vessel_name,
                    REPL.fullName AS replacement_name, L.nmvsl AS lastvsl_name,
                    E.nmremark AS signoffremark_name, NXVSL.nmvsl AS next_vessel_name
                    FROM tblcrewrotation R
                    LEFT JOIN (SELECT idperson, TRIM(CONCAT_WS(' ', fname, mname, lname)) AS fullName FROM mstpersonal WHERE deletests = '0') P ON P.idperson = R.idperson
                    LEFT JOIN mstcmprec B ON B.kdcmp = R.kdcmprec AND B.deletests = '0'
                    LEFT JOIN mstrank C ON C.kdrank = R.signonrank AND C.deletests = '0'
                    LEFT JOIN mstvessel D ON D.kdvsl = R.signonvsl AND D.deletests = '0'
                    LEFT JOIN (SELECT idperson, TRIM(CONCAT_WS(' ', fname, mname, lname)) AS fullName FROM mstpersonal WHERE deletests = '0') REPL ON REPL.idperson = R.replacement_idperson
                    LEFT JOIN mstvessel L ON L.kdvsl = R.lastvsl AND L.deletests = '0'
                    LEFT JOIN mstvessel NXVSL ON NXVSL.kdvsl = R.next_vessel AND NXVSL.deletests = '0'
                    LEFT JOIN mstremark E ON E.kdremark = R.signoffremark AND E.deletests = '0'
                    WHERE R.deletests = '0' AND R.idcrewrotation = ?";
            $row = $this->db->query($sql, array($idcrewrotation))->row_array();
        }
        $data = array('row' => $row);
        $this->load->view('CrewDetail/next_plan_detail', $data);
    }

}
?>