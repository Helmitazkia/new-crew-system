<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medical extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->helper(array('url', 'form'));
        
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

    public function view()
    {
        $this->load->view('ListReport/Medical/view_medical');
    }

    public function get_data()
    {
        $idperson = $this->input->post('idperson');
        if (!$idperson) {
            echo json_encode(array('success' => false, 'message' => 'ID Person is required', 'data' => array()));
            return;
        }

        $this->db->select('id, idperson, vaccine_name, vaccine_date, remark, vaccine_file, addusrdt');
        $this->db->from('tblvaccine');
        $this->db->where('idperson', $idperson);
        $this->db->where('deletests', 0);
        $this->db->order_by('vaccine_date', 'DESC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->result_array();
            foreach ($data as &$row) {
                if (!empty($row['vaccine_date']) && $row['vaccine_date'] != '0000-00-00') {
                    $row['vaccine_date_formatted'] = date('d M Y', strtotime($row['vaccine_date']));
                } else {
                    $row['vaccine_date_formatted'] = '-';
                }
            }
            echo json_encode(array('success' => true, 'data' => $data));
        } else {
            echo json_encode(array('success' => true, 'data' => array()));
        }
    }

    public function add_data()
    {
        $idperson = $this->input->post('idperson');
        $vaccine_name = $this->input->post('vaccine_name');
        $vaccine_date = $this->input->post('vaccine_date');
        $remark = $this->input->post('remark');
        
        $vaccine_file = '';

        if (!empty($_FILES['vaccine_file']['name'])) {
            $config['upload_path'] = './uploadFile/';
            $config['allowed_types'] = 'pdf|jpg|jpeg|png';
            $config['max_size'] = 5120; // 5MB
            $config['file_name'] = 'Medical_' . $idperson . '_' . time();

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('vaccine_file')) {
                $uploadData = $this->upload->data();
                $vaccine_file = $uploadData['file_name'];
            } else {
                echo json_encode(array('success' => false, 'message' => $this->upload->display_errors('','')));
                return;
            }
        }

        $data = array(
            'idperson' => $idperson,
            'vaccine_name' => $vaccine_name,
            'vaccine_date' => $vaccine_date,
            'remark' => $remark,
            'vaccine_file' => $vaccine_file,
            'addusrdt' => $this->session->userdata('fullname') . ' ' . date('Y-m-d H:i:s'),
            'editusrdt' => '',
            'deletests' => 0
        );

        $insert = $this->db->insert('tblvaccine', $data);

        if ($insert) {
            echo json_encode(array('success' => true, 'message' => 'Data added successfully'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to add data'));
        }
    }

    public function get_detail()
    {
        $id = $this->input->post('id');
        $idperson = $this->input->post('idperson');

        $this->db->select('*');
        $this->db->from('tblvaccine');
        $this->db->where('id', $id);
        $this->db->where('idperson', $idperson);
        $this->db->where('deletests', 0);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            echo json_encode(array('success' => true, 'data' => $query->row_array()));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Data not found'));
        }
    }

    public function update_data()
    {
        $id = $this->input->post('id');
        $idperson = $this->input->post('idperson');
        $vaccine_name = $this->input->post('vaccine_name');
        $vaccine_date = $this->input->post('vaccine_date');
        $remark = $this->input->post('remark');

        $data = array(
            'vaccine_name' => $vaccine_name,
            'vaccine_date' => $vaccine_date,
            'remark' => $remark,
            'editusrdt' => $this->session->userdata('fullname') . ' ' . date('Y-m-d H:i:s')
        );

        if (!empty($_FILES['vaccine_file']['name'])) {
            $config['upload_path'] = './uploadFile/';
            $config['allowed_types'] = 'pdf|jpg|jpeg|png';
            $config['max_size'] = 5120; // 5MB
            $config['file_name'] = 'Medical_' . $idperson . '_' . time();

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('vaccine_file')) {
                $uploadData = $this->upload->data();
                $data['vaccine_file'] = $uploadData['file_name'];
            } else {
                echo json_encode(array('success' => false, 'message' => $this->upload->display_errors('','')));
                return;
            }
        }

        $this->db->where('id', $id);
        $this->db->where('idperson', $idperson);
        $update = $this->db->update('tblvaccine', $data);

        if ($update) {
            echo json_encode(array('success' => true, 'message' => 'Data updated successfully'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to update data'));
        }
    }

    public function delete_data()
    {
        $id = $this->input->post('id');
        $idperson = $this->input->post('idperson');

        $this->db->where('id', $id);
        $this->db->where('idperson', $idperson);
        $update = $this->db->update('tblvaccine', array(
            'deletests' => 1, 
            'editusrdt' => $this->session->userdata('fullname') . ' ' . date('Y-m-d H:i:s')
        ));

        if ($update) {
            echo json_encode(array('success' => true, 'message' => 'Data deleted successfully'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to delete data'));
        }
    }
}
