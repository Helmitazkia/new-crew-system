<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MenuMaster extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('isLogin')) {
            redirect('auth');
        }
        $this->load->model('MenuRole/MenuMasterModel');
        $this->load->model('HakAksesModel');
    }

    public function index() {
        $data['active_menu'] = 'menu_master';
        $data['title'] = 'Master Menu Utama - Master Data';
        $this->load->view('layout/header', $data);
        $this->load->view('MenuRole/MenuMaster/view_menu_master');
        $this->load->view('layout/footer');
    }

    public function getAllData() {
        $data = $this->MenuMasterModel->getAll();
        echo json_encode(array('success' => true, 'data' => $data));
    }

    public function save() {
        $menuId = $this->input->post('menuId');
        $menuCode = $this->input->post('menuCode');
        
        if ($this->MenuMasterModel->checkDuplicateCode($menuCode, $menuId)) {
            echo json_encode(array('status' => 'error', 'message' => 'Menu Code already exists!'));
            return;
        }

        $data = array(
            'menuCode' => $menuCode,
            'menuName' => $this->input->post('menuName'),
            'menuIcon' => $this->input->post('menuIcon'),
            'menuUrl'  => $this->input->post('menuUrl'),
            'menuOrder'=> $this->input->post('menuOrder'),
            'hasSubMenu'=> $this->input->post('hasSubMenu') ? 1 : 0,
            'isActive' => $this->input->post('isActive') ? 1 : 0
        );

        if (empty($menuId)) {
            $data['createdAt'] = date('Y-m-d H:i:s');
            $insert_id = $this->MenuMasterModel->insert($data);
            $success = $insert_id ? true : false;
        } else {
            $data['updatedAt'] = date('Y-m-d H:i:s');
            $success = $this->MenuMasterModel->update($menuId, $data) >= 0;
        }

        if ($success) {
            echo json_encode(array('status' => 'success', 'message' => 'Data saved successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to save data'));
        }
    }

    public function getById() {
        $id = $this->input->post('id');
        $data = $this->MenuMasterModel->getById($id);
        if ($data) {
            echo json_encode(array('status' => 'success', 'data' => $data));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Data not found'));
        }
    }

    public function delete() {
        $id = $this->input->post('id');
        if ($this->MenuMasterModel->delete($id)) {
            echo json_encode(array('status' => 'success', 'message' => 'Data deleted successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to delete data'));
        }
    }
}
