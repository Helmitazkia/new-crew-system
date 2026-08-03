<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MenuMasterModel extends CI_Model {

    public function getAll() {
        return $this->db->get('m_menu')->result();
    }

    public function getById($id) {
        return $this->db->get_where('m_menu', array('menuId' => $id))->row();
    }

    public function insert($data) {
        $this->db->insert('m_menu', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('menuId', $id);
        $this->db->update('m_menu', $data);
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->where('menuId', $id);
        $this->db->delete('m_menu');
        return $this->db->affected_rows();
    }

    public function checkDuplicateCode($code, $id = null) {
        $this->db->where('menuCode', $code);
        if ($id) {
            $this->db->where('menuId !=', $id);
        }
        return $this->db->get('m_menu')->num_rows() > 0;
    }
}
