<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SubMenuMasterModel extends CI_Model {

    public function getAll() {
        return $this->db->query("
            SELECT sm.*, m.menuName as parentMenuName 
            FROM m_sub_menu sm
            LEFT JOIN m_menu m ON sm.menuId = m.menuId
        ")->result();
    }

    public function getById($id) {
        return $this->db->get_where('m_sub_menu', array('subMenuId' => $id))->row();
    }

    public function insert($data) {
        $this->db->insert('m_sub_menu', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('subMenuId', $id);
        $this->db->update('m_sub_menu', $data);
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->where('subMenuId', $id);
        $this->db->delete('m_sub_menu');
        return $this->db->affected_rows();
    }

    public function checkDuplicateCode($code, $id = null) {
        $this->db->where('subMenuCode', $code);
        if ($id) {
            $this->db->where('subMenuId !=', $id);
        }
        return $this->db->get('m_sub_menu')->num_rows() > 0;
    }
}
