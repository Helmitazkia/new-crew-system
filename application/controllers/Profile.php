<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Profile extends CI_Controller {
    
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
    
    // public function getProfile()
    // {
    //     $data['title'] = 'Profile';
    //     $data['active_menu'] = 'profile';
    //     $this->load->view('menu/header',$data); 
    //     $this->load->view('menu/sub_header');
    //     $this->load->view('Detail-Roster/Profile');
    //     $this->load->view('menu/footer');
    // }

    public function getProfileAjax($idperson = null)
  {

      $data['title'] = 'Profile';
      $data['active_menu'] = 'crew_roster';
      $this->load->view('menu/header', $data); 
      $this->load->view('CrewDetail/profile', $data); // Kirim data ke view
      $this->load->view('menu/footer');
  }

// public function getProfile($idperson = null)
// {
//     $data['title'] = 'Profile';
//     $this->load->view('DetailRoster/Profile', $data);
// }


}