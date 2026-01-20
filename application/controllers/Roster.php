<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roster extends CI_Controller {
    
    // public function __construct()
    // {
    //     parent::__construct();
        
    //     // Cek session login
    //     if(!$this->session->userdata('is_login')) {
    //         redirect('auth/login'); // redirect ke login
    //     }
    // }
    
    public function getCrewRoster()
    {
        $data['title'] = 'Crew Roster';
        $this->load->view('menu/header',$data); 
        $this->load->view('Roster/index_crewRoster');
        $this->load->view('menu/footer');
    }
}
