<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Familiarization extends CI_Controller {

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
        $this->load->view('ListReport/Familiarization/view_familiar');
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
		$this->db->from('history_familiarization');

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
		// $self menggantikan $this agar bisa diakses di dalam closure (anonymous function)
		$self = $this;
		$getItem = function($field) use ($self) {
			$val = $self->input->post($field);
			return ($val !== false && $val !== null && $val !== '') ? (int)$val : null;
		};

		$data = array(
			'idperson'     => $this->input->post('idperson', true),
			'nama_crew'    => $this->input->post('nama_crew', true),
			'rank'         => $this->input->post('rank', true),
			'vessel'       => $this->input->post('vessel', true),
			'signon_date'  => date('Y-m-d', strtotime($this->input->post('signon_date', true))),
			'note'         => $this->input->post('note', true),
			'date_created' => date('Y-m-d H:i:s'),
			// Familiarization checklist items (1 = ✓, 0 = ✗, NULL = not answered)
			'item_1'       => $getItem('item_1'),
			'item_2'       => $getItem('item_2'),
			'item_3'       => $getItem('item_3'),
			'item_4'       => $getItem('item_4'),
			'item_5'       => $getItem('item_5'),
			'item_6'       => $getItem('item_6'),
			'item_7'       => $getItem('item_7'),
			'item_8'       => $getItem('item_8'),
			'item_9'       => $getItem('item_9'),
			'item_10'      => $getItem('item_10'),
			'item_11'      => $getItem('item_11'),
			'item_12'      => $getItem('item_12'),
			'item_13'      => $getItem('item_13'),
			'item_14'      => $getItem('item_14'),
			'item_15'      => $getItem('item_15'),
			'item_16'      => $getItem('item_16'),
		);

		$insert = $this->db->insert('history_familiarization', $data);
		$insert_id = $this->db->insert_id();

		if ($insert) {
			echo json_encode(array('success' => true, 'message' => 'History berhasil disimpan', 'id' => $insert_id));
		} else {
			echo json_encode(array('success' => false, 'message' => 'Gagal menyimpan history'));
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
		$delete = $this->db->delete('history_familiarization');

		if ($delete) {
			echo json_encode(array('success' => true, 'message' => 'Data berhasil dihapus'));
		} else {
			echo json_encode(array('success' => false, 'message' => 'Gagal menghapus data'));
		}
	}

    function familiarization_pdf()
	{
		$id = $this->input->post('id_history');
		if (!$id) {
			$id = $this->uri->segment(4); // segment 4 for ListReport/Familiarization/familiarization_pdf/ID
		}
		
		if (!$id) {
			echo "ID History tidak dikirim.";
			return;
		}

		$this->db->where('id', $id);
		$history = $this->db->get('history_familiarization')->row();

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
		$this->load->view("ListReport/Familiarization/form_familiar_pdf", $dataOut);
		$html = ob_get_contents();
		ob_end_clean();

		$mpdf->WriteHTML(utf8_encode($html));
		$mpdf->Output("Familiarization_{$crew->fullname}.pdf", "I");
		exit;
	}
}
