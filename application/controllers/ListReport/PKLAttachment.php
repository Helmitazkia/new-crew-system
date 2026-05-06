<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PKLAttachment extends CI_Controller {

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
        $this->load->view('ListReport/PklAttachment/view_pkl_attachment');
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
				p.duration,
				TRIM(CONCAT(p.fname, ' ', p.mname, ' ', p.lname)) AS fullname,
				k.NmKota AS place_of_birth,
				DATE_FORMAT(p.dob, '%d-%m-%Y') AS date_of_birth,
				r.nmrank AS rankname,
				v.nmvsl AS vesselnm,
				(
					SELECT MAX(c2.docno)
					FROM tblcertdoc c2
					WHERE c2.idperson = p.idperson
					AND c2.deletests = 0
					AND c2.certname LIKE '%PASSPORT%'
				) AS passport_no
			FROM mstpersonal p
			LEFT JOIN tblkota k ON k.KdKota = p.pob
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
		$this->db->from('history_pkl_attachment');

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
		$data = array(
			'idperson'     => $this->input->post('idperson', true),
			'nama_crew'    => $this->input->post('nama_crew', true),
			'rank'         => $this->input->post('rank', true),
			'vessel'       => $this->input->post('vessel', true),
			'date_created' => date('Y-m-d H:i:s')
		);

		$insert = $this->db->insert('history_pkl_attachment', $data);

		if ($insert) {
			echo json_encode(array('success' => true, 'message' => 'History berhasil disimpan'));
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
		$delete = $this->db->delete('history_pkl_attachment');

		if ($delete) {
			echo json_encode(array('success' => true, 'message' => 'Data berhasil dihapus'));
		} else {
			echo json_encode(array('success' => false, 'message' => 'Gagal menghapus data'));
		}
	}

    function pkl_attachment_pdf()
	{
		$idPerson = $this->input->post('idperson');
		if (!$idPerson) {
			$idPerson = $this->uri->segment(3);
		}
		
		if (!$idPerson) {
			echo json_encode(array('success' => false, 'message' => 'ID Person tidak dikirim.'));
			return;
		}

		$sql = "
			SELECT 
				p.idperson,
				p.duration,
				TRIM(CONCAT(p.fname, ' ', p.mname, ' ', p.lname)) AS fullname,
				k.NmKota AS place_of_birth,
				DATE_FORMAT(p.dob, '%d-%m-%Y') AS date_of_birth,
				r.nmrank AS rankname,
				v.nmvsl AS vesselnm,
				(
					SELECT MAX(c2.docno)
					FROM tblcertdoc c2
					WHERE c2.idperson = p.idperson
					AND c2.deletests = 0
					AND c2.certname LIKE '%PASSPORT%'
				) AS passport_no
			FROM mstpersonal p
			LEFT JOIN tblkota k ON k.KdKota = p.pob
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
			echo json_encode(array('success' => false, 'message' => 'Data tidak ditemukan.'));
			return;
		}

		$crew = $dataCrew[0];

		$dataOut['crew']   = $crew;
		$dataOut['today']  = date('d F Y');

		require(APPPATH . "views/frontend/pdf/mpdf60/mpdf.php");
		$mpdf = new mPDF('utf-8', 'A4');

		ob_start();
		$this->load->view("ListReport/PklAttachment/form_pdf_pkl_attachment", $dataOut);
		$html = ob_get_contents();
		ob_end_clean();

		$mpdf->WriteHTML(utf8_encode($html));
		$mpdf->Output("PKL_Attachment_{$crew->fullname}.pdf", "I");
		exit;
	}
}