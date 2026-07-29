<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Change_password extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('isLogin')) {
            redirect('auth/login');
            exit;
        }
    }

    public function index()
    {
        $data['title'] = 'Change Password';
        $data['active_menu'] = 'dashboard';
            
  
        $this->load->view('auth/change_password', $data);
        $this->load->view('layout/footer');
    }

    public function update_password()
    {
        $userId = $this->session->userdata('userId');
        
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');

        if ($new_password !== $confirm_password) {
            $this->session->set_flashdata('error', 'Konfirmasi password baru tidak cocok.');
            redirect('auth/change_password');
            return;
        }

        // Get current user data
        $this->db->where('userId', $userId);
        $user = $this->db->get('login')->row();

        if (md5($old_password) !== $user->userPass) {
            $this->session->set_flashdata('error', 'Password lama tidak sesuai.');
            redirect('auth/change_password');
            return;
        }

        // Update password
        $this->db->where('userId', $userId);
        if ($this->db->update('login', array('userPass' => md5($new_password)))) {
            $this->session->set_flashdata('success', 'Password berhasil diubah. Silakan login kembali dengan password baru.');
            // Opsional: Logout otomatis setelah ganti password
            // redirect('auth/login/do_logout');
        } else {
            $this->session->set_flashdata('error', 'Terjadi kesalahan. Gagal mengubah password.');
        }

        redirect('auth/change_password');
    }
}
