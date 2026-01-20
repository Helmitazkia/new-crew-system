<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index()
    {
        $this->load->view('auth/login');
    }

// public function index()
//   {
//     $this->load->view('menu/header');
//     $this->load->view('Roster/index_crewRoster');
//     $this->load->view('menu/footer');
//   }
  public function do_login()
  {
      header('Content-Type: application/json');

      $user = $this->input->post('user');
      $pass = $this->input->post('pass');

      // VALIDASI POST
      if (empty($user) || empty($pass)) {
          echo json_encode(array(
              'status' => false,
              'msg' => 'Username dan password wajib diisi'
          ));
          exit;
      }

      // QUERY LOGIN (PAKAI BINDING)
      $sql = "
          SELECT 
              userId,
              userName,
              userFullNm,
              userType,
              userJenis
          FROM login
          WHERE status = '0'
          AND userName = ?
          AND userPass = ?
          LIMIT 1
      ";

      $query = $this->db->query($sql, array(
          $user,
          md5($pass) // SESUAIKAN JIKA HASH BERBEDA
      ));

      // var_dump($query);exit;

      if ($query->num_rows() > 0) {

          $row = $query->row();

          // SET SESSION
          $this->session->set_userdata(array(
              'userId'     => $row->userId,
              'userName'   => $row->userName,
              'userFullNm' => $row->userFullNm,
              'userType'   => $row->userType,
              'userJenis'  => $row->userJenis,
              'isLogin'    => true
          ));

          // // UPDATE LAST LOGIN
          $this->db->query(
              "UPDATE login SET lastLogin = NOW() WHERE userId = ?",
              array($row->userId)
          );

          echo json_encode(array(
              'status' => true,
              'msg' => 'Login berhasil'
          ));

      } else {

          echo json_encode(array(
              'status' => false,
              'msg' => 'Username atau password salah'
          ));
      }
  }


  // Auth.php controller
public function do_logout()
{
    header('Content-Type: application/json');
    
    // Hapus semua session
    $this->session->unset_userdata(array(
        'userId',
        'userName', 
        'userFullNm',
        'userType',
        'userJenis',
        'isLogin'
    ));
    
    // Atau bisa juga dengan:
    $this->session->sess_destroy(); // Hapus seluruh session
    
    echo json_encode(array(
        'status' => true,
        'msg' => 'Logout berhasil'
    ));
    exit;
}

}