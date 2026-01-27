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

    public function getActiveRoster()
    {
        $data = array(
            'title' => 'Active Roster',
            'active_menu' => 'crew_roster',
            'content' => 'Roster/ActiveRoster/active_roster'
        );

        $this->load->view('menu/main_CrewLifecycle', $data);
    }

}
