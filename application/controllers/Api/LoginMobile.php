<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginMobile extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Allow CORS requests (useful for local Flutter testing or web apps)
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding');
    }

    public function index()
    {
        // Set response as JSON
        header('Content-Type: application/json');

        // Allow OPTIONS request for CORS preflight
        if ($this->input->server('REQUEST_METHOD') === 'OPTIONS') {
            exit();
        }

        // Check if method is POST
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            $this->output->set_status_header(405); // 405 Method Not Allowed
            echo json_encode(array(
                'status' => false,
                'message' => 'Method not allowed. Use POST.'
            ));
            return;
        }

        // Support for JSON Payload in API requests (Flutter often sends raw JSON)
        // Karena CI2 mungkin tidak support raw_input_stream, kita pakai file_get_contents bawaan PHP
        $stream_clean = file_get_contents('php://input');
        $request = json_decode($stream_clean, true);
        
        $user = isset($request['user']) ? $request['user'] : $this->input->post('user');
        $pass = isset($request['pass']) ? $request['pass'] : $this->input->post('pass');

        // Validation
        if (empty($user) || empty($pass)) {
            $this->output->set_status_header(400); // 400 Bad Request
            echo json_encode(array(
                'status' => false,
                'message' => 'Username dan password wajib diisi'
            ));
            return;
        }

        // Query User (Using existing logic with md5 hash)
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
            md5($pass)
        ));

        if ($query->num_rows() > 0) {
            $row = $query->row();

            // Update last login
            $this->db->query(
                "UPDATE login SET lastLogin = NOW() WHERE userId = ?",
                array($row->userId)
            );

            // Respond with user data
            $this->output->set_status_header(200); // 200 OK
            echo json_encode(array(
                'status' => true,
                'message' => 'Login berhasil',
                'data' => array(
                    'userId'     => $row->userId,
                    'userName'   => $row->userName,
                    'userFullNm' => $row->userFullNm,
                    'userType'   => $row->userType,
                    'userJenis'  => $row->userJenis,
                )
            ));

        } else {
            $this->output->set_status_header(401); // 401 Unauthorized
            echo json_encode(array(
                'status' => false,
                'message' => 'Username atau password salah'
            ));
        }
    }
}
