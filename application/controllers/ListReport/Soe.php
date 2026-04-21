<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Soe extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MCrewscv');
	}

	public function view()
	{
		$this->load->view('ListReport/SOE/view_soe');
	}

	public function get_data_form_soe()
	{
		$idperson = $this->input->post("idperson", true);
		
		$sql = "
			SELECT 
				CONCAT_WS(' ', A.fname, A.mname, A.lname) AS fullname,
				B.signondt,
				C.nmrank,
				D.nmvsl
			FROM mstpersonal A
			LEFT JOIN tblcontract B ON A.idperson = B.idperson
			LEFT JOIN mstrank C ON B.signonrank = C.kdrank
			LEFT JOIN mstvessel D ON B.signonvsl = D.kdvsl
			WHERE 1=1
				AND B.idperson = '$idperson'
			ORDER BY B.signondt DESC
			LIMIT 1
		";

		$data = $this->MCrewscv->getDataQuery($sql);
		$result = array();

		if (!empty($data)) {
			foreach ($data as $row) {
				$result[] = array(
					'fullname'     => isset($row->fullname) ? $row->fullname : '',
					// Using sign_on date for Date attribute as requested by user
					'date_request' => (!empty($row->signondt) && $row->signondt != '0000-00-00')
										? date("d M Y", strtotime($row->signondt))
										: '',
					'nmrank'       => isset($row->nmrank) ? $row->nmrank : '',
					'nmvsl'        => isset($row->nmvsl) ? $row->nmvsl : ''
				);
			}
		}

		echo json_encode(array(
			'success' => !empty($result),
			'data'    => $result
		));
	}

	public function save_form_soe()
	{
		$crew = array(
			'id_person'    => $this->input->post('idperson'),
			'name_person'  => $this->input->post('fullname'),
			'rank'         => $this->input->post('nmrank'),
			'vessel_name'  => $this->input->post('nmvsl'),
			// From client side via text input (it gets it from sign_on date)
			'date_request' => $this->input->post('date_request'),
			'created_at'   => date('Y-m-d H:i:s')
		);

		$this->db->trans_begin();
		$this->db->insert('report_soe', $crew);
		$insert_id = $this->db->insert_id();
		
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			echo json_encode(array(
				'success' => false,
				'message' => 'Gagal menyimpan Statement of Employment'
			));
		} else {
			$this->db->trans_commit();
			echo json_encode(array(
				'success' => true,
				'message' => 'Statement of Employment berhasil dibuat',
				'id_report' => $insert_id
			));
		}
	}

	public function get_report_soe()
	{
		$idperson = $this->input->post('idperson', true);

		$sql = "
			SELECT
				a.id,
				a.id_person,
				a.name_person,
				a.rank,
				a.vessel_name,
				a.date_request
			FROM report_soe a
			WHERE 1=1
		";

		// Search by idperson if provided
		if (!empty($idperson)) {
			$sql .= " AND a.id_person = '{$idperson}'";
		}

		$sql .= " ORDER BY a.id DESC";

		$data = $this->MCrewscv->getDataQuery($sql);
		
		echo json_encode(array(
			'success' => true,
			'data'    => !empty($data) ? $data : array()
		));
	}

	public function get_report_soe_detail()
	{
		$id = $this->input->post('id_report', true);
		if (empty($id)) {
			echo json_encode(array('success' => false, 'message' => 'Invalid ID'));
			return;
		}

		$soe = $this->db->where('id', $id)->get('report_soe')->row();
		if (!$soe) {
			echo json_encode(array('success' => false, 'message' => 'Data tidak ditemukan'));
			return;
		}

		echo json_encode(array(
			'success' => true,
			'data' => array(
				'crew' => $soe
			)
		));
	}

	public function delete_report_soe()
	{
		$id = $this->input->post('id');

		if (empty($id)) {
			echo json_encode(array(
				'success' => false,
				'message' => 'ID tidak valid'
			));
			exit;
		}

		$this->db->trans_begin();

		// hapus report soe
		$this->db->where('id', $id);
		$this->db->delete('report_soe');

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			echo json_encode(array(
				'success' => false,
				'message' => 'Gagal menghapus data Statement of Employment'
			));
		} else {
			$this->db->trans_commit();
			echo json_encode(array(
				'success' => true,
				'message' => 'Data berhasil dihapus'
			));
		}
		exit;
	}

	public function print_soe_pdf()
	{
		$id = $this->input->post('id_report_soe');

		if (empty($id)) {
			show_error('Invalid SOE ID');
		}

		// ambil report_soe
		$soe = $this->db->where('id', $id)->get('report_soe')->row();
		if (!$soe) {
			show_error('Data Statement of Employment tidak ditemukan');
		}

		$data = array(
			'crew' => $soe
		);

		require(APPPATH . "views/frontend/pdf/mpdf60/mpdf.php");
		$mpdf = new mPDF('utf-8', 'A4');

		$html = $this->load->view('ListReport/SOE/form_soe', $data, TRUE);
		$mpdf->WriteHTML($html);

		$mpdf->Output("SOE_Form_{$soe->name_person}.pdf", 'I');
		exit;
	}

}