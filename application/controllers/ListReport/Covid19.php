<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Covid19 extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MCrewscv');
        $this->load->library('../controllers/DataContext');
        $this->load->library('session');

        if (!$this->session->userdata('isLogin')) {
            redirect('auth/login');
            exit;
        }
    }

    public function view()
    {
        $this->load->view('ListReport/Covid19/view_covid19');
    }
}
