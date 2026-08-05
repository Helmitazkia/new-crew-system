<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AcceptentceLetter extends CI_Controller {

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
        $this->load->view('ListReport/AcceptentceLetter/view_acceptentce');
    }

	function acceptence()
	{
		$idPerson = $this->input->post('idperson');

		if (!$idPerson) {
			echo json_encode(array(
				'status'  => false,
				'message' => 'ID Person tidak dikirim'
			));
			return;
		}

		$sql = "
			SELECT 
				p.idperson,
				TRIM(CONCAT(p.fname, ' ', p.mname, ' ', p.lname)) AS nama_crew,

				-- TANGGAL STATEMENT DIGANTI MENJADI TANGGAL LAHIR
				DATE_FORMAT(p.dob, '%d %M %Y') AS tanggal_lahir,
				v.kdvsl,
				v.nmvsl AS nama_kapal,
				r.kdrank,
				r.nmrank AS nama_rank,
				p.file_statement,
				p.competency_cert as serpel
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
			WHERE p.idperson = '{$idPerson}'
		";

		$result = $this->MCrewscv->getDataQuery($sql);

		if ($result && count($result) > 0) {
			echo json_encode(array(
				'status' => true,
				'data'   => $result[0],
				'today'  => date('d F Y')
			));
		} else {
			echo json_encode(array(
				'status'  => false,
				'message' => 'Data tidak ditemukan'
			));
		}
	}

	function acceptence_pdf()
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
				TRIM(CONCAT(p.fname, ' ', p.mname, ' ', p.lname)) AS nama_crew,
				DATE_FORMAT(p.dob, '%d %M %Y') AS tanggal_lahir,
				v.nmvsl AS nama_kapal,
				r.nmrank AS nama_rank,
				p.competency_cert AS serpel
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
			WHERE p.idperson = '{$idPerson}'
		";

		$dataCrew = $this->MCrewscv->getDataQuery($sql);

		if (empty($dataCrew)) {
			echo json_encode(array('success' => false, 'message' => 'Data tidak ditemukan.'));
			return;
		}

		$crew = $dataCrew[0];

		$pdf_nama_crew = $this->input->post('pdf_nama_crew');
		$pdf_tanggal_lahir = $this->input->post('pdf_tanggal_lahir');
		$pdf_nama_rank = $this->input->post('pdf_nama_rank');
		$pdf_serpel = $this->input->post('pdf_serpel');
		$pdf_tanggal = $this->input->post('pdf_tanggal');

		if (!empty($pdf_nama_crew)) { $crew->nama_crew = $pdf_nama_crew; }
		if (!empty($pdf_tanggal_lahir)) { $crew->tanggal_lahir = $pdf_tanggal_lahir; }
		if (!empty($pdf_nama_rank)) { $crew->nama_rank = $pdf_nama_rank; }
		if (!empty($pdf_serpel)) { $crew->serpel = $pdf_serpel; }

		$dataOut['crew']   = $crew;
		$dataOut['today']  = !empty($pdf_tanggal) ? $pdf_tanggal : date('d F Y');

		require(APPPATH . "views/frontend/pdf/mpdf60/mpdf.php");
		$mpdf = new mPDF('utf-8', 'A4');

		ob_start();
		$this->load->view("ListReport/AcceptentceLetter/form_acceptentce_pdf", $dataOut);
		$html = ob_get_contents();
		ob_end_clean();

		$mpdf->WriteHTML(utf8_encode($html));
		$mpdf->Output("Acceptence_{$crew->nama_crew}.pdf", "I");
		exit;
	}

	public function get_history()
	{
		$idperson = $this->input->post('idperson', true);

		$this->db->select('*');
		$this->db->from('report_acceptance');

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

		$insert = $this->db->insert('report_acceptance', $data);

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
		$delete = $this->db->delete('report_acceptance');

		if ($delete) {
			echo json_encode(array('success' => true, 'message' => 'Data berhasil dihapus'));
		} else {
			echo json_encode(array('success' => false, 'message' => 'Gagal menghapus data'));
		}
	}
}
