<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MasterFamiliarization extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('MCrewscv');
        $this->load->library('../controllers/DataContext');
        $this->load->library('session');

        // Check login status
        if (!$this->session->userdata('isLogin')) {
            redirect('auth/login');
            exit;
        }
    }

    // ==========================================
    // TOPIC
    // ==========================================
    public function topic()
    {
        $data['title'] = 'Master Familiarization Topic';
        $data['active_menu'] = 'master_fam_topic';
        $this->load->view('layout/header', $data);
        $this->load->view('MasterData/MasterFamiliarization/view_mst_fam_topic', $data);
        $this->load->view('layout/footer');
    }

    public function getAllDataTopic()
    {
        $sql = "SELECT * FROM mst_fam_topic ORDER BY order_no ASC, id ASC";
        $data = $this->db->query($sql)->result_array();
        echo json_encode(array('data' => $data));
    }

    public function getTopicById()
    {
        $id = $this->input->post('id');
        $row = $this->db->get_where('mst_fam_topic', array('id' => $id))->row_array();
        if ($row) {
            echo json_encode(array('status' => 'success', 'data' => $row));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Data not found'));
        }
    }

    public function saveTopic()
    {
        $id = $this->input->post('topicId');
        $data = array(
            'topic_name' => $this->input->post('topicName'),
            'order_no'   => $this->input->post('orderNo') ? $this->input->post('orderNo') : 0,
            'is_active'  => $this->input->post('isActive') ? 1 : 0
        );

        if (empty($id)) {
            $this->db->insert('mst_fam_topic', $data);
            $msg = 'Topic added successfully';
        } else {
            $this->db->where('id', $id);
            $this->db->update('mst_fam_topic', $data);
            $msg = 'Topic updated successfully';
        }

        if ($this->db->affected_rows() >= 0) {
            echo json_encode(array('status' => 'success', 'message' => $msg));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to save data'));
        }
    }

    public function deleteTopic()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('mst_fam_topic');
        echo json_encode(array('status' => 'success', 'message' => 'Topic deleted successfully'));
    }

    // ==========================================
    // DEPARTMENT
    // ==========================================
    public function department()
    {
        $data['title'] = 'Master Familiarization Department';
        $data['active_menu'] = 'master_fam_department';
        $this->load->view('layout/header', $data);
        $this->load->view('MasterData/MasterFamiliarization/view_mst_fam_department', $data);
        $this->load->view('layout/footer');
    }

    public function getAllDataDepartment()
    {
        $sql = "SELECT * FROM mst_fam_department ORDER BY id ASC";
        $data = $this->db->query($sql)->result_array();
        echo json_encode(array('data' => $data));
    }

    public function getDepartmentById()
    {
        $id = $this->input->post('id');
        $row = $this->db->get_where('mst_fam_department', array('id' => $id))->row_array();
        if ($row) {
            echo json_encode(array('status' => 'success', 'data' => $row));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Data not found'));
        }
    }

    public function saveDepartment()
    {
        $id = $this->input->post('deptId');
        $data = array(
            'department_name' => $this->input->post('departmentName'),
            'is_active'       => $this->input->post('isActive') ? 1 : 0
        );

        if (empty($id)) {
            $this->db->insert('mst_fam_department', $data);
            $msg = 'Department added successfully';
        } else {
            $this->db->where('id', $id);
            $this->db->update('mst_fam_department', $data);
            $msg = 'Department updated successfully';
        }

        if ($this->db->affected_rows() >= 0) {
            echo json_encode(array('status' => 'success', 'message' => $msg));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to save data'));
        }
    }

    public function deleteDepartment()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('mst_fam_department');
        echo json_encode(array('status' => 'success', 'message' => 'Department deleted successfully'));
    }
}
