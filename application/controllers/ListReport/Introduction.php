<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Introduction extends CI_Controller {

    function __construct()
	{
		parent::__construct();
		
		$this->load->model('MCrewscv');
		$this->load->helper(array('form', 'url'));
		$this->load->library('../controllers/DataContext');
        $this->load->library('session');
	}

    public function view()
    {
        $this->load->view('ListReport/Introduction/view_introduction');
    }

    public function get_crew_info_by_idperson()
    {
        $idperson = $this->input->post('idperson', true);

        // Join to tblcontract to get company, rank, vessel, port based on latest contract
        $sql = "
           select
              CONCAT_WS(' ', A.fname, A.mname, A.lname) as crew_name,
              C.nmrank as rank,
              D.nmvsl as vessel,
              E.nmcmp as company,
              B.signonport
            from
              mstpersonal A
            left join tblcontract B on
              A.idperson = B.idperson
              and B.deletests = '0'
            left join mstrank C on
              C.kdrank = B.signonrank
              and C.deletests = '0'
            left join mstvessel D on
              D.kdvsl = B.signonvsl
              and D.deletests = '0'
            left join mstcmprec E on
              E.kdcmp = B.kdcmprec
              and E.deletests = '0'
            where
              A.idperson = ?
            order by
              B.signondt desc,
              B.idcontract desc
            limit 1
        ";

        $data = $this->db->query($sql, array($idperson))->row();

        // If no contract, fallback to mstpersonal
        if ($data && empty($data->crew_name)) {
            $sqlFallback = "SELECT CONCAT_WS(' ', fname, mname, lname) AS crew_name, applyfor AS rank, vesselfor AS vessel FROM mstpersonal WHERE idperson = ? LIMIT 1";
            $dataFallback = $this->db->query($sqlFallback, array($idperson))->row();
            if ($dataFallback) {
                if (empty($data->crew_name)) $data->crew_name = $dataFallback->crew_name;
                if (empty($data->rank)) $data->rank = $dataFallback->rank;
                if (empty($data->vessel)) $data->vessel = $dataFallback->vessel;
            }
        }

        echo json_encode(array(
            'success' => !empty($data),
            'data'    => $data
        ));
    }

    public function get_report_introduction()
    {
        $idperson = $this->input->post('idperson', true);

        if (empty($idperson)) {
            echo json_encode(array('success' => false, 'data' => array()));
            return;
        }

        $sql = "
            SELECT *
            FROM report_introduction
            WHERE deletes = '0' AND idperson = ?
            ORDER BY id DESC
        ";

        $data = $this->db->query($sql, array($idperson))->result();

        foreach ($data as $row) {
            $row->date_created = !empty($row->date_created)
                ? date('d M Y', strtotime($row->date_created))
                : '-';
        }

        echo json_encode(array(
            'success' => true,
            'data'    => $data
        ));
    }

    public function submit_report_introduction()
    {
        $post = $this->input->post(NULL, TRUE);
        $userid = $this->session->userdata('idUserCrewSystem');

        if (empty($post)) {
            echo json_encode(array('success' => false, 'message' => 'Data kosong'));
            return;
        }

        $data = array(
            'idperson'              => isset($post['idperson']) ? $post['idperson'] : null,
            'company'               => isset($post['company']) ? $post['company'] : '',
            'vessel'                => isset($post['vessel']) ? $post['vessel'] : '',
            'port'                  => isset($post['port']) ? $post['port'] : '',
            'date_created'          => isset($post['date_created']) ? $post['date_created'] : date('Y-m-d'),
            
            'release_name'          => isset($post['release_name']) ? $post['release_name'] : '',
            'release_rank'          => isset($post['release_rank']) ? $post['release_rank'] : '',
            'release_reason'        => isset($post['release_reason']) ? $post['release_reason'] : '',
            'release_others'        => isset($post['release_others']) ? $post['release_others'] : '',
            
            'successor_name'        => isset($post['successor_name']) ? $post['successor_name'] : '',
            'successor_rank'        => isset($post['successor_rank']) ? $post['successor_rank'] : '',
            'successor_bs'          => isset($post['successor_bs']) ? $post['successor_bs'] : '0',
            'successor_ot'          => isset($post['successor_ot']) ? $post['successor_ot'] : '0',
            'successor_leavepay'    => isset($post['successor_leavepay']) ? $post['successor_leavepay'] : '0',
            
            'addusrdate'            => date('Y-m-d H:i:s'),
            'userid_add'            => $userid,
            'deletes'               => 0
        );

        $this->db->insert('report_introduction', $data);
        $idReport = $this->db->insert_id();

        if ($idReport) {
            echo json_encode(array('success' => true, 'message' => 'Data berhasil disimpan', 'id_report' => $idReport));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal menyimpan data'));
        }
    }

    public function delete_report_introduction()
    {
        $id = $this->input->post('id', true);

        if (empty($id)) {
            echo json_encode(array('success' => false, 'message' => 'ID tidak ditemukan'));
            return;
        }

        $this->db->where('id', $id);
        $this->db->update('report_introduction', array('deletes' => 1));

        echo json_encode(array('success' => true, 'message' => 'Data berhasil dihapus'));
    }

    public function generatePDF_Introduction($id = '')
    {
        if (empty($id)) {
            echo "ID Report tidak ditemukan";
            return;
        }

        $sql = "SELECT * FROM report_introduction WHERE id = ? AND deletes = '0' LIMIT 1";
        $report = $this->db->query($sql, array($id))->row();

        if (!$report) {
            echo "Data Introduction tidak ditemukan";
            return;
        }

        $data['report'] = $report;

        require(APPPATH . "views/frontend/pdf/mpdf60/mpdf.php");

        $mpdf = new mPDF('utf-8', 'A4');
        $mpdf->SetTitle('Instruction Letter');
        $mpdf->SetFont('dejavusans');

        $html = $this->load->view('ListReport/Introduction/form_introduction_pdf', $data, TRUE);
        $mpdf->WriteHTML($html);

        $filename = "Instruction_Letter_" . date('Ymd_His') . ".pdf";
        $mpdf->Output($filename, 'I');
        exit;
    }
}