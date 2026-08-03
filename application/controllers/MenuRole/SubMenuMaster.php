<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubMenuMaster extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('isLogin')) {
            redirect('auth');
        }
        $this->load->model('MenuRole/SubMenuMasterModel');
        $this->load->model('MenuRole/MenuMasterModel');
        $this->load->model('HakAksesModel');
    }

    public function index() {
        $data['active_menu'] = 'sub_menu_master';
        $data['title'] = 'Master Sub Menu - Master Data';
        $data['parents'] = $this->MenuMasterModel->getAll();
        $this->load->view('layout/header', $data);
        $this->load->view('MenuRole/SubMenuMaster/view_sub_menu_master', $data);
        $this->load->view('layout/footer');
    }

    public function getAllData() {
        $data = $this->SubMenuMasterModel->getAll();
        echo json_encode(array('success' => true, 'data' => $data));
    }

    public function save() {
        $subMenuId = $this->input->post('subMenuId');
        $subMenuCode = $this->input->post('subMenuCode');
        
        if ($this->SubMenuMasterModel->checkDuplicateCode($subMenuCode, $subMenuId)) {
            echo json_encode(array('status' => 'error', 'message' => 'Sub Menu Code already exists!'));
            return;
        }

        $data = array(
            'menuId'      => $this->input->post('menuId'),
            'subMenuCode' => $subMenuCode,
            'subMenuName' => $this->input->post('subMenuName'),
            'subMenuUrl'  => $this->input->post('subMenuUrl'),
            'subMenuOrder'=> $this->input->post('subMenuOrder'),
            'isActive'    => $this->input->post('isActive') ? 1 : 0
        );

        if (empty($subMenuId)) {
            $data['createdAt'] = date('Y-m-d H:i:s');
            $insert_id = $this->SubMenuMasterModel->insert($data);
            $success = $insert_id ? true : false;
        } else {
            $data['updatedAt'] = date('Y-m-d H:i:s');
            $success = $this->SubMenuMasterModel->update($subMenuId, $data) >= 0;
        }

        if ($success) {
            echo json_encode(array('status' => 'success', 'message' => 'Data saved successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to save data'));
        }
    }

    public function getById() {
        $id = $this->input->post('id');
        $data = $this->SubMenuMasterModel->getById($id);
        if ($data) {
            echo json_encode(array('status' => 'success', 'data' => $data));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Data not found'));
        }
    }

    public function delete() {
        $id = $this->input->post('id');
        if ($this->SubMenuMasterModel->delete($id)) {
            echo json_encode(array('status' => 'success', 'message' => 'Data deleted successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to delete data'));
        }
    }
}
