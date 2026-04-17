<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mlc extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('MCrewscv');
	}

	public function view()
	{
		$this->load->view('ListReport/MLC/view_mlc');
	}

	/* Start Form MLC */
	public function get_data_form_mlc()
	{
		$idperson = $this->input->post("idperson", true);
		
		$sql = "
			SELECT 
				B.signonvsl,
				CONCAT_WS(' ', A.fname, A.mname, A.lname) AS fullname,
				B.signondt,
				B.estsignoffdt,
				C.nmrank,
				D.nmvsl
			FROM mstpersonal A
			LEFT JOIN tblcontract B ON A.idperson = B.idperson
			LEFT JOIN mstrank C ON B.signonrank = C.kdrank
			LEFT JOIN mstvessel D ON B.signonvsl = D.kdvsl
			WHERE 1=1
				AND B.idperson = '$idperson'
			GROUP BY B.signonvsl, fullname, B.signondt, B.estsignoffdt, C.nmrank
			ORDER BY B.signondt DESC
			LIMIT 1
		";

		$data = $this->MCrewscv->getDataQuery($sql);
		$result = array();

		if (!empty($data)) {
			foreach ($data as $row) {
				$result[] = array(
					'signonvsl'    => isset($row->signonvsl) ? $row->signonvsl : '',
					'fullname'     => isset($row->fullname) ? $row->fullname : '',
					'signondt'     => (!empty($row->signondt) && $row->signondt != '0000-00-00')
										? date("d M Y", strtotime($row->signondt))
										: '',
					'estsignoffdt' => (!empty($row->estsignoffdt) && $row->estsignoffdt != '0000-00-00')
										? date("d M Y", strtotime($row->estsignoffdt))
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

	public function print_mlc_pdf()
	{
		$id = $this->input->post('id_report_mlc');

		if (empty($id)) {
			show_error('Invalid MLC ID');
		}

		// ambil report_mlc
		$mlc = $this->db->where('id', $id)->get('report_mlc')->row();
		if (!$mlc) {
			show_error('Data MLC tidak ditemukan');
		}

		// ambil jawaban
		$answers = $this->db
				->where('id_report_mlc', $id)
				->get('report_answer_form_mlc')
				->row();

		// crew object
		$crew = new stdClass();
		$crew->idperson = $mlc->id_person;
		$crew->fullname = $mlc->name_person;
		$crew->nmrank   = $mlc->rank;
		$crew->nmvsl    = $mlc->vessel_name;
		$crew->signondt = (!empty($mlc->date_request)) ? date('d M Y', strtotime($mlc->date_request)) : '';

		// checkbox
		$checkbox_data = array();
		for ($i = 1; $i <= 9; $i++) {
			$checkbox_data['statement_'.$i] = isset($answers->{'answer_'.$i}) ? (int)$answers->{'answer_'.$i} : 0;
		}

		$data = array(
			'crew'       => $crew,
			'checkboxes' => $checkbox_data,
			'all_data'   => $checkbox_data
		);

		require(APPPATH . "views/frontend/pdf/mpdf60/mpdf.php");
		$mpdf = new mPDF('utf-8', 'A4');

		// FIX: Use the specific MLC view folder
		$html = $this->load->view('ListReport/MLC/form_mlc_pdf', $data, TRUE);
		$mpdf->WriteHTML($html);

		$mpdf->Output("MLC_Form_{$crew->fullname}.pdf", 'I');
		exit;
	}

	public function save_form_mlc()
	{
		$checkbox_data = array();
		for ($i = 1; $i <= 9; $i++) {
			$value = $this->input->post('statement_' . $i);
			$checkbox_data['statement_' . $i] = ($value === '1') ? 1 : 0;
		}

		$crew = array(
			'id_person'    => $this->input->post('idperson'),
			'name_person'  => $this->input->post('fullname'),
			'rank'         => $this->input->post('nmrank'),
			'vessel_name'  => $this->input->post('nmvsl'),
			'date_request' => date('Y-m-d')
		);

		$this->db->trans_begin();

		$this->db->insert('report_mlc', $crew);
		$id_report_mlc = $this->db->insert_id();

		$answer_data = array(
			'id_report_mlc' => $id_report_mlc,
			'answer_1' => $checkbox_data['statement_1'],
			'answer_2' => $checkbox_data['statement_2'],
			'answer_3' => $checkbox_data['statement_3'],
			'answer_4' => $checkbox_data['statement_4'],
			'answer_5' => $checkbox_data['statement_5'],
			'answer_6' => $checkbox_data['statement_6'],
			'answer_7' => $checkbox_data['statement_7'],
			'answer_8' => $checkbox_data['statement_8'],
			'answer_9' => $checkbox_data['statement_9']
		);

		$this->db->insert('report_answer_form_mlc', $answer_data);
		
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			echo json_encode(array(
				'success' => false,
				'message' => 'Gagal menyimpan Form MLC'
			));
		} else {
			$this->db->trans_commit();
			echo json_encode(array(
				'success' => true,
				'message' => 'Form MLC berhasil dibuat'
			));
		}
	}

	public function get_report_mlc()
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
			FROM report_mlc a
			WHERE 1=1
		";

		// Search by idperson if provided
		if (!empty($idperson)) {
			$sql .= " AND a.id_person = '{$idperson}'";
		}

		$sql .= " ORDER BY a.id DESC";

		$data = $this->MCrewscv->getDataQuery($sql);
		$result = array();

		if (!empty($data)) {
			foreach ($data as $row) {
				$row->date_request = !empty($row->date_request) ? date('d M Y', strtotime($row->date_request)) : '-';
				$result[] = $row;
			}
		}

		echo json_encode(array(
			'success' => true,
			'data'    => $result
		));
	}

	public function get_report_mlc_detail()
	{
		$id = $this->input->post('id_report', true);
		if (empty($id)) {
			echo json_encode(array('success' => false, 'message' => 'Invalid ID'));
			return;
		}

		$mlc = $this->db->where('id', $id)->get('report_mlc')->row();
		if (!$mlc) {
			echo json_encode(array('success' => false, 'message' => 'Data tidak ditemukan'));
			return;
		}

		// Ambil data Sign On / Est Sign Off dari tblcontract dengan logic terbaru (Match Get Data)
		$idperson = $mlc->id_person;
		$sql = "
			SELECT 
				B.signondt,
				B.estsignoffdt
			FROM mstpersonal A
			LEFT JOIN tblcontract B ON A.idperson = B.idperson
			WHERE 1=1
				AND B.idperson = '{$idperson}'
			ORDER BY B.signondt DESC
			LIMIT 1
		";
		$contract_data = $this->MCrewscv->getDataQuery($sql);

		if (!empty($contract_data)) {
			$mlc->signondt = (!empty($contract_data[0]->signondt) && $contract_data[0]->signondt != '0000-00-00') 
								? date("d M Y", strtotime($contract_data[0]->signondt)) 
								: '';
			$mlc->estsignoffdt = (!empty($contract_data[0]->estsignoffdt) && $contract_data[0]->estsignoffdt != '0000-00-00') 
								? date("d M Y", strtotime($contract_data[0]->estsignoffdt)) 
								: '';
		} else {
			$mlc->signondt = '';
			$mlc->estsignoffdt = '';
		}

		$answers = $this->db->where('id_report_mlc', $id)->get('report_answer_form_mlc')->row();

		echo json_encode(array(
			'success' => true,
			'data' => array(
				'crew' => $mlc,
				'answers' => $answers
			)
		));
	}

	public function delete_report_mlc()
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

		// hapus jawaban dulu (child)
		$this->db->where('id_report_mlc', $id);
		$this->db->delete('report_answer_form_mlc');

		// hapus report mlc (parent)
		$this->db->where('id', $id);
		$this->db->delete('report_mlc');

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			echo json_encode(array(
				'success' => false,
				'message' => 'Gagal menghapus data MLC'
			));
		} else {
			$this->db->trans_commit();
			echo json_encode(array(
				'success' => true,
				'message' => 'Data MLC berhasil dihapus'
			));
		}
		exit;
	}
}
