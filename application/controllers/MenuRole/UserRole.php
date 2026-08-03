<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserRole extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('isLogin')) {
            redirect('auth');
        }
        $this->load->model('MenuRole/UserRoleModel');
        $this->load->model('HakAksesModel');
    }

    public function index() {
        $data['active_menu'] = 'user_role';
        $data['title'] = 'Master User Role - Master Data';
        $this->load->view('layout/header', $data);
        $this->load->view('MenuRole/UserRole/view_user_role');
        $this->load->view('layout/footer');
    }

    public function getAllData() {
        $data = $this->UserRoleModel->getAll();
        echo json_encode(array('success' => true, 'data' => $data));
    }

    public function save() {
        $roleId = $this->input->post('roleId');
        $roleCode = $this->input->post('roleCode');
        
        if ($this->UserRoleModel->checkDuplicateCode($roleCode, $roleId)) {
            echo json_encode(array('status' => 'error', 'message' => 'Role Code already exists!'));
            return;
        }

        $data = array(
            'roleCode' => $roleCode,
            'roleName' => $this->input->post('roleName'),
            'roleDesc' => $this->input->post('roleDesc'),
            'isActive' => $this->input->post('isActive') ? 1 : 0
        );

        if (empty($roleId)) {
            $data['createdAt'] = date('Y-m-d H:i:s');
            $insert_id = $this->UserRoleModel->insert($data);
            $success = $insert_id ? true : false;
        } else {
            $data['updatedAt'] = date('Y-m-d H:i:s');
            $success = $this->UserRoleModel->update($roleId, $data) >= 0;
        }

        if ($success) {
            echo json_encode(array('status' => 'success', 'message' => 'Data saved successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to save data'));
        }
    }

    public function getById() {
        $id = $this->input->post('id');
        $data = $this->UserRoleModel->getById($id);
        if ($data) {
            echo json_encode(array('status' => 'success', 'data' => $data));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Data not found'));
        }
    }

    public function delete() {
        $id = $this->input->post('id');
        if ($this->UserRoleModel->delete($id)) {
            echo json_encode(array('status' => 'success', 'message' => 'Data deleted successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to delete data'));
        }
    }
}
