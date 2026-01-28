<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CrewRotation extends CI_Controller {
    
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
            'title'   => 'Crew Rotation',
            'content' => 'Roster/CrewRotation/crew_rotation'
        );

        $this->load->view('menu/main_CrewLifecycle', $data);
    }

    public function ajaxCrewRotation()
    {
        $this->load->view('Roster/CrewRotation/crew_rotation');
    }
}



