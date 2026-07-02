<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Briefing extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MCrewscv');
        $this->load->library('../controllers/DataContext');
        $this->load->library('session');

        if (!$this->session->userdata('isLogin')) {
            redirect('auth/login');
            exit;
        }
    }

    public function view()
    {
        $this->load->view('ListReport/Briefing/view_briefing');
    }

	function getStatementCrew()
	{
		$idperson = $this->input->post('idperson');

		if ($idperson == "") {
			echo json_encode(array('success' => false, 'status' => false, 'message' => 'Id Person Kosong!'));
			return;
		}

		$sql = "
			SELECT 
				p.idperson,
				TRIM(CONCAT(p.fname, ' ', p.mname, ' ', p.lname)) AS fullname,
				DATE_FORMAT(p.dob, '%d-%m-%Y') AS date_of_birth,
				r.nmrank AS rankname,
				v.nmvsl AS vesselnm,
                c.signondt AS signondt,
                DATE_FORMAT(c.signondt, '%d-%m-%Y') AS signon_date,
				(
					SELECT MAX(c2.docno)
					FROM tblcertdoc c2
					WHERE c2.idperson = p.idperson
					AND c2.deletests = 0
					AND c2.certname LIKE '%PASSPORT%'
				) AS passport_no
			FROM mstpersonal p
			LEFT JOIN tblcontract c 
				ON c.idperson = p.idperson
				AND c.deletests = 'N'
				AND c.signondt = (
					SELECT MAX(signondt)
					FROM tblcontract
					WHERE idperson = p.idperson
					AND deletests = 'N'
				)
			LEFT JOIN mstvessel v ON v.kdvsl = c.signonvsl
			LEFT JOIN mstrank r ON r.kdrank = c.signonrank
			WHERE p.idperson = '$idperson'
			LIMIT 1
		";

		$result = $this->MCrewscv->getDataQuery($sql);
		$data   = (!empty($result)) ? $result[0] : null;

		$response = array(
			'success' => $data ? true : false,
			'status'  => $data ? true : false,
			'data'    => $data,
			'message' => $data ? "OK" : "Data tidak ditemukan",
			'today'   => date('d F Y')
		);

		echo json_encode($response);
	}

    public function get_history()
	{
		$idperson = $this->input->post('idperson', true);

		$this->db->select('*');
		$this->db->from('history_briefing');

		if (!empty($idperson)) {
			$this->db->where('idperson', $idperson);
		}

		$this->db->order_by('id', 'DESC');
		$data = $this->db->get()->result();

		$result = array();
		foreach ($data as $row) {
			$row->date_created_fmt = !empty($row->date_created)
				? date('d M Y H:i', strtotime($row->date_created))
				: '-';
            $row->link_url = !empty($row->link_token) ? base_url('PublicBriefing/form/' . $row->link_token) : '';
			$result[] = $row;
		}

		echo json_encode(array(
			'success' => true,
			'data'    => $result
		));
	}

	public function save_history()
	{
		// Helper: convert radio value (0/1) or NULL if not sent
    $self = $this;
		$getItem = function($field) use ($self) {
			$val = $self->input->post($field);
			return ($val !== false && $val !== null && $val !== '') ? (int)$val : null;
		};

        $checklist_arr = array();
        for ($i = 1; $i <= 54; $i++) {
            $val = $getItem('item_' . $i);
            $checklist_arr[] = ($val !== null) ? $val : ''; // Empty string if not answered
        }
        $checklist_data = implode(',', $checklist_arr);

        // Date briefing
        $date_briefing = $this->input->post('date_briefing', true);
        if(!empty($date_briefing)) {
            $date_briefing = date('Y-m-d', strtotime($date_briefing));
        } else {
            $date_briefing = null;
        }

		$data = array(
			'idperson'             => $this->input->post('idperson', true),
			'nama_crew'            => $this->input->post('nama_crew', true),
			'rank'                 => $this->input->post('rank', true),
			'vessel'               => $this->input->post('vessel', true),
            'date_briefing'        => $date_briefing,
            'mr_ms_by'             => $this->input->post('mr_ms_by', true),
            'prior_joining_vessel' => $this->input->post('prior_joining_vessel', true),
            'note'                 => $this->input->post('note', true),
		);

        $id = $this->input->post('id', true);

        if(empty($id)) {
            // INSERT
            $data['checklist_data'] = $checklist_data;
            $data['date_created'] = date('Y-m-d H:i:s');
            // Generate link token
            $data['link_token'] = md5(uniqid(rand(), true) . time());
            $data['is_submitted'] = 0;

            $insert = $this->db->insert('history_briefing', $data);
            $insert_id = $this->db->insert_id();

            if ($insert) {
                echo json_encode(array(
                    'success' => true, 
                    'message' => 'History berhasil disimpan. Link untuk crew telah digenerate.', 
                    'id' => $insert_id,
                    'link_url' => base_url('PublicBriefing/form/' . $data['link_token'])
                ));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Gagal menyimpan history'));
            }
        } else {
            // UPDATE
            $this->db->where('id', $id);
            $update = $this->db->update('history_briefing', $data);
            if ($update) {
                // Get token to return link
                $row = $this->db->get_where('history_briefing', array('id' => $id))->row();
                echo json_encode(array(
                    'success' => true, 
                    'message' => 'History berhasil diupdate.', 
                    'id' => $id,
                    'link_url' => base_url('PublicBriefing/form/' . $row->link_token)
                ));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Gagal mengupdate history'));
            }
        }
	}

	public function delete_history()
	{
		$id = $this->input->post('id', true);
		if (empty($id)) {
			echo json_encode(array('success' => false, 'message' => 'ID tidak valid'));
			return;
		}

		$this->db->where('id', $id);
		$delete = $this->db->delete('history_briefing');

		if ($delete) {
			echo json_encode(array('success' => true, 'message' => 'Data berhasil dihapus'));
		} else {
			echo json_encode(array('success' => false, 'message' => 'Gagal menghapus data'));
		}
	}

    function briefing_pdf()
	{
		$id = $this->input->post('id_history');
		if (!$id) {
			$id = $this->uri->segment(4); 
		}
		
		if (!$id) {
			echo "ID History tidak dikirim.";
			return;
		}

		$this->db->where('id', $id);
		$history = $this->db->get('history_briefing')->row();

		if (empty($history)) {
			echo "Data History tidak ditemukan.";
			return;
		}
        
        $idPerson = $history->idperson;

		$sql = "
			SELECT 
				p.idperson,
				TRIM(CONCAT(p.fname, ' ', p.mname, ' ', p.lname)) AS fullname,
				DATE_FORMAT(p.dob, '%d-%m-%Y') AS date_of_birth,
				r.nmrank AS rankname,
				v.nmvsl AS vesselnm,
                c.signondt AS signondt,
                DATE_FORMAT(c.signondt, '%d-%m-%Y') AS signon_date
			FROM mstpersonal p
			LEFT JOIN tblcontract c 
				ON c.idperson = p.idperson
				AND c.deletests = 'N'
				AND c.signondt = (
					SELECT MAX(signondt)
					FROM tblcontract
					WHERE idperson = p.idperson
					AND deletests = 'N'
				)
			LEFT JOIN mstvessel v ON v.kdvsl = c.signonvsl
			LEFT JOIN mstrank r ON r.kdrank = c.signonrank
			WHERE p.idperson = '$idPerson'
			LIMIT 1
		";

		$dataCrew = $this->MCrewscv->getDataQuery($sql);

		if (empty($dataCrew)) {
			echo "Data Person tidak ditemukan.";
			return;
		}

		$crew = $dataCrew[0];

		$dataOut['crew']    = $crew;
		$dataOut['history'] = $history;
		$dataOut['today']   = date('d F Y');

		require(APPPATH . "views/frontend/pdf/mpdf60/mpdf.php");
		$mpdf = new mPDF('utf-8', 'A4');

		ob_start();
		$this->load->view("ListReport/Briefing/form_pdf_briefing", $dataOut);
		$html = ob_get_contents();
		ob_end_clean();

		$mpdf->WriteHTML(utf8_encode($html));
		$mpdf->Output("Briefing_{$crew->fullname}.pdf", "I");
		exit;
	}
}
