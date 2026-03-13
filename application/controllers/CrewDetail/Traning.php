<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Traning extends CI_Controller {

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
        $this->load->view('CrewDetail/training');
    }

    /**
     * GET: Load assessment & training data from mstpersonal by idperson.
     * Returns: scormarlintes, scorces, ismeval, ismdate, scor_psychometric, scor_otg
     */
    public function get_training()
    {
        $idperson = $this->input->get('idperson');
        if (empty($idperson)) {
            header('Content-Type: application/json');
            echo json_encode(array('success' => false, 'message' => 'idperson required'));
            return;
        }
        $sql = "SELECT scormarlintes, scorces, ismeval, ismdate, scor_psychometric, scor_otg
                FROM mstpersonal
                WHERE idperson = ? LIMIT 1";
        $row = $this->db->query($sql, array($idperson))->row_array();
        if (!$row) {
            header('Content-Type: application/json');
            echo json_encode(array('success' => true, 'data' => array(
                'scormarlintes' => '', 'scorces' => '', 'ismeval' => '', 'ismdate' => '',
                'scor_psychometric' => '', 'scor_otg' => ''
            )));
            return;
        }
        header('Content-Type: application/json');
        echo json_encode(array('success' => true, 'data' => $row));
    }

    /**
     * POST: Save/Update assessment & training in mstpersonal by idperson.
     * Fields: idperson, txtCesScore->scorces, txtmarlinTest->scormarlintes,
     * txtEvaluation->ismeval, txtDate_training->ismdate, scor_psychometric, scor_otg
     */
    public function save_training()
    {
        $idperson = $this->input->post('idperson');
        if (empty($idperson)) {
            header('Content-Type: application/json');
            echo json_encode(array('success' => false, 'message' => 'idperson required'));
            return;
        }
        $scorces           = $this->input->post('txtCesScore') !== null ? trim($this->input->post('txtCesScore')) : '';
        $scormarlintes     = $this->input->post('txtmarlinTest') !== null ? trim($this->input->post('txtmarlinTest')) : '';
        $ismeval           = $this->input->post('txtEvaluation') !== null ? trim($this->input->post('txtEvaluation')) : '';
        $ismdate           = $this->input->post('txtDate_training') !== null ? trim($this->input->post('txtDate_training')) : '';
        $scor_psychometric = $this->input->post('scor_psychometric') !== null ? trim($this->input->post('scor_psychometric')) : '';
        $scor_otg          = $this->input->post('scor_otg') !== null ? trim($this->input->post('scor_otg')) : '';

        $data = array(
            'scorces'           => substr($scorces, 0, 20),
            'scormarlintes'     => substr($scormarlintes, 0, 20),
            'ismeval'           => substr($ismeval, 0, 100),
            'ismdate'           => $ismdate !== '' ? $ismdate : null,
            'scor_psychometric' => substr($scor_psychometric, 0, 20),
            'scor_otg'          => substr($scor_otg, 0, 20)
        );

        $this->db->where('idperson', $idperson);
        $this->db->update('mstpersonal', $data);

        header('Content-Type: application/json');
        echo json_encode(array('success' => true, 'message' => 'Data saved successfully'));
    }

}
?>