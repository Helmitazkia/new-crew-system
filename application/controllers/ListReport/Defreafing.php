<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Defreafing extends CI_Controller {

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
        $this->load->view('ListReport/Defreafing/view_defreafing');
    }

    /* Start Form Debriefing */
	public function save_debriefing()
	{
			// ================= HEADER =================
			$report = array(
					'id_person'      => $this->input->post('idperson', true),
					'name_person'    => $this->input->post('nama_crew', true),
					'rank'           => $this->input->post('jabatan', true),
					'vessel_name'    => $this->input->post('vessel', true),
					'pelabuhan'      => $this->input->post('pelabuhan', true),
					'no_telp'        => $this->input->post('no_telp', true),
					'date_request'   => date('Y-m-d'),
					'sign_on'        => $this->input->post('tgl_join', true),
					'sign_off'       => $this->input->post('tgl_signoff', true),
					'available_join' => $this->input->post('siap_join', true)
			);

			$this->db->insert('report_debriefing', $report);
			$id_report = $this->db->insert_id();

			if (!$id_report) {
					echo json_encode(array(
							'success' => false,
							'message' => 'Gagal menyimpan debriefing'
					));
					return;
			}

			// ================= ANSWERS =================
			$answers_input = $this->input->post('answers', true);
			$answers_data  = json_decode($answers_input, true);

			$answers = array(
					'id_report_debriefing' => $id_report,
					'certificates'         => $this->input->post('certificates', true),
					'remarks'              => $this->input->post('remask_form_deb', true)
			);

			for ($i = 1; $i <= 10; $i++) {
					$key = 'answer_' . $i;
					$answers[$key] = isset($answers_data[$key]) ? $answers_data[$key] : '';
			}


			$this->db->insert('report_answer_debriefing', $answers);

			echo json_encode(array(
					'success' => true,
					'message' => 'Debriefing berhasil disimpan'
			));
	}

	public function delete_debriefing()
	{
			$id = $this->input->post('id', true);

			if (empty($id)) {
					echo json_encode(array(
							'success' => false,
							'message' => 'ID tidak valid'
					));
					return;
			}

			// cek data ada atau tidak
			$cek = $this->db->where('id', $id)->get('report_debriefing')->row();
			if (!$cek) {
					echo json_encode(array(
							'success' => false,
							'message' => 'Data tidak ditemukan'
					));
					return;
			}

			// mulai transaksi
			$this->db->trans_begin();

			// hapus detail jawaban
			$this->db->where('id_report_debriefing', $id)
							->delete('report_answer_debriefing');

			// hapus header
			$this->db->where('id', $id)
							->delete('report_debriefing');

			if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					echo json_encode(array(
							'success' => false,
							'message' => 'Gagal menghapus data'
					));
			} else {
					$this->db->trans_commit();
					echo json_encode(array(
							'success' => true,
							'message' => 'Data berhasil dihapus'
					));
			}
	}



	public function get_report_debriefing()
	{
			$idperson = $this->input->post('idperson', true);

			$this->db->select('*');
			$this->db->from('report_debriefing');

			if (!empty($idperson)) {
					$this->db->where('id_person', $idperson);
			}

			$this->db->order_by('id', 'DESC');
			$data = $this->db->get()->result();

			$result = array();
			foreach ($data as $row) {
					$row->date_request = !empty($row->date_request)
							? date('d M Y', strtotime($row->date_request))
							: '-';
					$result[] = $row;
			}

			echo json_encode(array(
					'success' => true,
					'data'    => $result
			));
	}

	public function get_report_debriefing_detail()
	{
			$id_report = $this->input->post('id_report', true);

			if (empty($id_report)) {
					echo json_encode(array('success' => false, 'message' => 'ID Report tidak ditemukan'));
					return;
			}

			$crew_db = $this->db
					->where('id', $id_report)
					->get('report_debriefing')
					->row();

			if (!$crew_db) {
					echo json_encode(array('success' => false, 'message' => 'Data debriefing tidak ditemukan'));
					return;
			}

			// Format dates
			$crew_db->sign_on_fmt = $crew_db->sign_on ? date('d M Y', strtotime($crew_db->sign_on)) : '-';
			$crew_db->sign_off_fmt = $crew_db->sign_off ? date('d M Y', strtotime($crew_db->sign_off)) : '-';
			$crew_db->available_join_fmt = $crew_db->available_join ? date('d M Y', strtotime($crew_db->available_join)) : '-';

			$ans_db = $this->db
					->where('id_report_debriefing', $id_report)
					->get('report_answer_debriefing')
					->row();

			echo json_encode(array(
					'success' => true,
					'data'    => array(
						'crew' => $crew_db,
						'answers' => $ans_db
					)
			));
	}




	function get_data_form_defbreafing()
	{
		$idperson = $this->input->post("idperson", true);

		$sql = "
			SELECT 
				D.nmvsl AS nama_kapal,
				B.signonport AS pelabuhan,
				C.nmrank AS jabatan,
				CONCAT_WS(' ', A.fname, A.mname, A.lname) AS nama_crew,
				A.telpno AS no_telp,
				B.signondt,
				B.estsignoffdt
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
					'nama_kapal'  => isset($row->nama_kapal) ? $row->nama_kapal : '',
					'pelabuhan'   => isset($row->pelabuhan) ? $row->pelabuhan : '',
					'jabatan'     => isset($row->jabatan) ? $row->jabatan : '',
					'nama_crew'   => isset($row->nama_crew) ? $row->nama_crew : '',
					'no_telp'     => isset($row->no_telp) ? $row->no_telp : '',
					'tgl_join'    => isset($row->signondt) ? $row->signondt : '',
					'tgl_signoff' => isset($row->estsignoffdt) ? $row->estsignoffdt : ''
				);
			}
		}

		echo json_encode(array(
			'success' => !empty($result),
			'data'    => $result
		));
	}


	public function generatePDF_Breafing()
	{
			$id_report = $this->input->post('id_report', true);

			if (empty($id_report)) {
					show_error('ID Report tidak valid');
			}

			$crew_db = $this->db
					->where('id', $id_report)
					->get('report_debriefing')
					->row();

			if (!$crew_db) {
					show_error('Data debriefing tidak ditemukan');
			}

			$crew = new stdClass();
			$crew->idperson    = $crew_db->id_person;
			$crew->nama_crew   = $crew_db->name_person;
			$crew->jabatan     = $crew_db->rank;
			$crew->vessel      = $crew_db->vessel_name;
			$crew->pelabuhan   = $crew_db->pelabuhan;
			$crew->no_telp     = $crew_db->no_telp;

			$crew->tgl_join    = $crew_db->sign_on 
					? date('d M Y', strtotime($crew_db->sign_on)) : '';
			$crew->tgl_signoff = $crew_db->sign_off 
					? date('d M Y', strtotime($crew_db->sign_off)) : '';
			$crew->siap_join   = $crew_db->available_join 
					? date('d M Y', strtotime($crew_db->available_join)) : '';


			$ans_db = $this->db
					->where('id_report_debriefing', $id_report)
					->get('report_answer_debriefing')
					->row();

			$answers = new stdClass();

			for ($i = 1; $i <= 10; $i++) {
					$key = 'answer_' . $i;
					$answers->$key = isset($ans_db->$key) ? $ans_db->$key : '';
			}

			$crew->certificates  = !empty($ans_db->certificates) ? $ans_db->certificates : '';
			$crew->remask_form_deb      = !empty($ans_db->remarks) ? $ans_db->remarks : '';



			$data = array(
					'crew'    => $crew,
					'answers' => $answers
			);

			// echo '<pre>';
			// print_r($ans_db);
			// exit;


			require(APPPATH . "views/frontend/pdf/mpdf60/mpdf.php");

			$mpdf = new mPDF('utf-8', 'A4');
			$mpdf->SetTitle('Form Debriefing');

			$html = $this->load->view('ListReport/Defreafing/form_defbreafing_pdf', $data, TRUE);
			$mpdf->WriteHTML($html);

			$filename = "DEBRIEFING_Form_" . date('Ymd_His') . ".pdf";
			$mpdf->Output($filename, 'I');
	}
}
