<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicBriefing extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MCrewscv');
    }

    public function form($token = '')
    {
        if (empty($token)) {
            show_404();
            return;
        }

        $this->db->where('link_token', $token);
        $history = $this->db->get('history_briefing')->row();

        if (empty($history)) {
            show_404();
            return;
        }

        // Parse existing checklist data if any
        $checklist_items = array();
        if (!empty($history->checklist_data)) {
            $checklist_items = explode(',', $history->checklist_data);
        }

        $data['history'] = $history;
        $data['checklist_items'] = $checklist_items;
        $data['token'] = $token;

        $this->load->view('Public/form_briefing_crew', $data);
    }

    public function submit_form()
    {
        $token = $this->input->post('token', true);
        if (empty($token)) {
            echo json_encode(array('success' => false, 'message' => 'Token tidak valid!'));
            return;
        }

        $this->db->where('link_token', $token);
        $history = $this->db->get('history_briefing')->row();

        if (empty($history)) {
            echo json_encode(array('success' => false, 'message' => 'Data tidak ditemukan!'));
            return;
        }

        // Get checklist
        $self = $this;
        $getItem = function($field) use ($self) {
            $val = $self->input->post($field);
            return ($val !== false && $val !== null && $val !== '') ? (int)$val : null;
        };

        $checklist_arr = array();
        for ($i = 1; $i <= 54; $i++) {
            $val = $getItem('item_' . $i);
            $checklist_arr[] = ($val !== null) ? $val : '';
        }
        $checklist_data = implode(',', $checklist_arr);

        // Data to update
        $data_update = array(
            'checklist_data' => $checklist_data,
            'is_submitted' => 1
        );

        $this->db->where('id', $history->id);
        $update = $this->db->update('history_briefing', $data_update);

        if ($update) {
            echo json_encode(array('success' => true, 'message' => 'Berhasil mensubmit form Briefing. Terima kasih.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal mensubmit form.'));
        }
    }
}
