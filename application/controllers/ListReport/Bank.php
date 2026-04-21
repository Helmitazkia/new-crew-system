<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bank extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MCrewscv');
	}

	public function view()
	{
		$this->load->view('ListReport/BANK/view_bank');
	}

	public function getDataBankCrew()
	{
		$idperson = $this->input->post('idperson');

		$sql = "
			SELECT 
				a.idperson,
				TRIM(CONCAT(a.fname, ' ', a.mname, ' ', a.lname)) AS fullname,
				a.ptn AS npwp,
				a.paddress AS address, 
				a.mobileno AS phone,
				a.fammobile AS emergency_phone,
				a.famfullname AS emergency_name,
				a.bank_name AS bank_name,
				a.norek AS bank_account,
				a.norek_name AS account_name,
				a.famrelateid AS relation,
				IFNULL(a.deletests, 0) AS deletests
			FROM mstpersonal a
			WHERE 
				a.deletests = 0
				AND a.idperson = '$idperson'
			LIMIT 1
		";

		$result = $this->MCrewscv->getDataQuery($sql);
		$data = (!empty($result)) ? $result[0] : null;

		$response = array(
			'fullname'         => $data ? $data->fullname : '',
			'npwp'             => $data ? $data->npwp : '',
			'address'          => $data ? $data->address : '',
			'phone'            => $data ? $data->phone : '',
			'emergency_phone'  => $data ? $data->emergency_phone : '',
			'relation'         => $data ? $data->relation : '',
			'bank_name'        => $data ? $data->bank_name : '',
			'bank_account'     => $data ? $data->bank_account : '',
			'account_name'     => $data ? $data->account_name : ''
		);

		echo json_encode(array('success' => true, 'data' => array($response)));
	}

	public function save_bank()
	{
		$data = array(
			'idperson'         => $this->input->post('idperson'),
			'status_data_bank' => $this->input->post('status_data_bank'),
			'fullname'         => $this->input->post('fullname'),
			'npwp'             => $this->input->post('npwp'),
			'address'          => $this->input->post('address'),
			'phone'            => $this->input->post('phone'),
			'emergency_phone'  => $this->input->post('emergency_phone'),
			'relation'         => $this->input->post('relation'),
			'bank_name'        => $this->input->post('bank_name'),
			'bank_account'     => $this->input->post('bank_account'),
			'account_name'     => $this->input->post('account_name'),
			'bank_address'     => $this->input->post('bank_address'),
			'created_at'       => date('Y-m-d H:i:s')
		);

		$this->db->trans_begin();
		$this->db->insert('report_bank', $data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			echo json_encode(array(
				'success' => false,
				'message' => 'Gagal menyimpan data Bank'
			));
		} else {
			$this->db->trans_commit();
			echo json_encode(array(
				'success' => true,
				'message' => 'Data Bank berhasil disimpan'
			));
		}
	}

	public function get_report_bank()
	{
		$idperson = $this->input->post('idperson', true);

		$sql = "SELECT * FROM report_bank WHERE 1=1 ";
		if (!empty($idperson)) {
			$sql .= " AND idperson = '{$idperson}'";
		}
		$sql .= " ORDER BY id DESC";

		$data = $this->MCrewscv->getDataQuery($sql);
		
		echo json_encode(array(
			'success' => true,
			'data'    => !empty($data) ? $data : array()
		));
	}

	public function get_report_bank_detail()
	{
		$id = $this->input->post('id', true);
		if (empty($id)) {
			echo json_encode(array('success' => false, 'message' => 'Invalid ID'));
			return;
		}

		$bank = $this->db->where('id', $id)->get('report_bank')->row();
		if (!$bank) {
			echo json_encode(array('success' => false, 'message' => 'Data tidak ditemukan'));
			return;
		}

		echo json_encode(array(
			'success' => true,
			'data'    => $bank
		));
	}

	public function delete_report_bank()
	{
		$id = $this->input->post('id');

		if (empty($id)) {
			echo json_encode(array('success' => false, 'message' => 'ID tidak valid'));
			exit;
		}

		$this->db->trans_begin();
		$this->db->where('id', $id);
		$this->db->delete('report_bank');

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			echo json_encode(array('success' => false, 'message' => 'Gagal menghapus data Bank'));
		} else {
			$this->db->trans_commit();
			echo json_encode(array('success' => true, 'message' => 'Data Bank berhasil dihapus'));
		}
	}

	public function print_bank_pdf()
	{
		$id = $this->input->post('id_report_bank');

		if (empty($id)) {
			show_error('Invalid Bank ID');
		}

		$crew = $this->db->where('id', $id)->get('report_bank')->row();
		if (!$crew) {
			show_error('Data Bank tidak ditemukan');
		}

		$data = array(
			'crew' => $crew
		);

		require(APPPATH . "views/frontend/pdf/mpdf60/mpdf.php");
		$mpdf = new mPDF('utf-8', 'A4');

		$html = $this->load->view('ListReport/BANK/form_bank_pdf', $data, TRUE);
		$mpdf->WriteHTML($html);

		$mpdf->Output("Bank_Statement_{$crew->fullname}.pdf", 'I');
		exit;
	}
}