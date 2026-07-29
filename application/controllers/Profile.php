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
    public function index()
    {
        $userId = $this->session->userdata('userId');
        $this->db->where('userId', $userId);
        $data['user'] = $this->db->get('login')->row();
        
        $data['title'] = 'My Profile';
        $data['active_menu'] = 'dashboard';
        

        $this->load->view('auth/profile', $data);
        $this->load->view('layout/footer');
    }

    public function update_profile()
    {
        $userId = $this->session->userdata('userId');
        
        $update_data = array(
            'userFullNm' => $this->input->post('userFullNm'),
            'userInit' => $this->input->post('userInit')
        );

        // Handle Image Upload
        if (!empty($_FILES['image_profile']['name'])) {
            $upload_path   = FCPATH . 'assets/img/profile/';
            $allowed_types = array('jpg', 'jpeg', 'png');
            $max_size      = 2097152; // 2MB

            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0777, TRUE);
            }

            $file_name = $_FILES['image_profile']['name'];
            $file_size = $_FILES['image_profile']['size'];
            $file_tmp  = $_FILES['image_profile']['tmp_name'];
            
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            
            if (!in_array($file_ext, $allowed_types)) {
                $this->session->set_flashdata('error', 'Format gambar tidak valid. Hanya JPG dan PNG.');
                redirect('profile');
                return;
            }
            
            if ($file_size > $max_size) {
                $this->session->set_flashdata('error', 'Ukuran gambar terlalu besar (Maksimal 2MB).');
                redirect('profile');
                return;
            }

            $new_file_name = 'profile_' . $userId . '_' . time() . '.' . $file_ext;

            if (move_uploaded_file($file_tmp, $upload_path . $new_file_name)) {
                $update_data['image_profile'] = $new_file_name;
                
                // Remove old image
                $old_data = $this->db->get_where('login', array('userId' => $userId))->row();
                if (!empty($old_data->image_profile) && file_exists($upload_path . $old_data->image_profile)) {
                    unlink($upload_path . $old_data->image_profile);
                }
            } else {
                $this->session->set_flashdata('error', 'Gagal mengunggah gambar ke server.');
                redirect('profile');
                return;
            }
        }

        $this->db->where('userId', $userId);
        if ($this->db->update('login', $update_data)) {
            // Update session data
            $this->session->set_userdata('userFullNm', $update_data['userFullNm']);
            if (isset($update_data['image_profile'])) {
                $this->session->set_userdata('image_profile', $update_data['image_profile']);
            }
            $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui profil.');
        }
        
        redirect('profile');
    }
    public function getProfileAjax($idperson = null)
  {

    $data['title'] = 'Profile';
    $data['active_menu'] = 'crew_roster';
    $this->load->view('menu/header', $data); 
    $this->load->view('CrewDetail/profile', $data); 
    $this->load->view('menu/footer');
  }


}