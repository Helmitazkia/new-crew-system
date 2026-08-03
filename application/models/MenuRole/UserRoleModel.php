<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserRoleModel extends CI_Model {

    public function getAll() {
        return $this->db->get('m_user_role')->result();
    }

    public function getById($id) {
        return $this->db->get_where('m_user_role', array('roleId' => $id))->row();
    }

    public function insert($data) {
        $this->db->insert('m_user_role', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('roleId', $id);
        $this->db->update('m_user_role', $data);
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->where('roleId', $id);
        $this->db->delete('m_user_role');
        return $this->db->affected_rows();
    }

    public function checkDuplicateCode($code, $id = null) {
        $this->db->where('roleCode', $code);
        if ($id) {
            $this->db->where('roleId !=', $id);
        }
        return $this->db->get('m_user_role')->num_rows() > 0;
    }
}
