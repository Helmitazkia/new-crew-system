<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IntroductionReport extends CI_Controller {

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
        $data['optTax'] = $this->datacontext->getTaxByOption();
        $data['title'] = 'Instruction Report';
        $data['active_menu'] = 'instruction_letter';
        $this->load->view('layout/header', $data);
        $this->load->view('Report/IntroductionReport/view_introduction_report', $data);
        $this->load->view('layout/footer');
    }

    public function search_crew()
    {
        $keyword = $this->input->get('q');
        if ($keyword) {
            $keyword = $this->db->escape_like_str($keyword);
        }

        if (empty($keyword)) {
            $sql = "
                SELECT 
                    A.idperson,
                    CONCAT_WS(' ', A.fname, A.mname, A.lname) AS nama_crew,
                    A.applyfor,
                    A.vesselfor
                FROM mstpersonal A
                WHERE A.deletests = '0'
                AND (A.fname NOT IN ('', '-', ' ')  
                AND A.mname NOT IN ('', '-', ' ')  
                AND A.lname NOT IN ('', '-', ' ')) 
                ORDER BY A.fname ASC
                LIMIT 30
            ";
        }else {
            $sql = "
                SELECT 
                    A.idperson,
                    CONCAT_WS(' ', A.fname, A.mname, A.lname) AS nama_crew,
                    A.applyfor,
                    A.vesselfor
                FROM mstpersonal A
            WHERE 
                (A.fname LIKE '%$keyword%'
                OR A.mname LIKE '%$keyword%'
                OR A.lname LIKE '%$keyword%')
            AND A.deletests = '0'
            ORDER BY A.fname ASC
        ";
        }

        $data   = $this->MCrewscv->getDataQuery($sql);
        $result = array();

        if (!empty($data)) {
            foreach ($data as $row) {
                $result[] = array(
                    'id'        => $row->idperson,
                    'text'      => $row->nama_crew,
                    'idperson'  => $row->idperson
                );
            }
        }

        echo json_encode(array("items" => $result));
    }

    // Get specific crew info when selected
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
            B.signonport as port
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
        // Query grouping by batchID
        $sql = "
            SELECT 
                b.batchID,
                MAX(r.id) as id,
                r.date_created,
                r.company,
                r.vessel,
                r.port,
                GROUP_CONCAT(NULLIF(r.release_name, '') SEPARATOR ', ') as release_crews
            FROM batch_report_introduction b
            JOIN report_introduction r ON b.id_report_introduction = r.id
            WHERE r.deletes = '0'
            GROUP BY b.batchID, r.date_created, r.company, r.vessel, r.port
            ORDER BY MAX(r.id) DESC
        ";

        $data = $this->db->query($sql)->result();

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

        if (empty($post) || (empty($post['release_name']) && empty($post['successor_name']))) {
            echo json_encode(array('success' => false, 'message' => 'Data kru tidak boleh kosong'));
            return;
        }

        $batchID = 'BATCH-' . date('YmdHis') . '-' . rand(100, 999);
        $raw_date = isset($post['date_created']) ? $post['date_created'] : '';
        $date_created = $raw_date ? date('Y-m-d', strtotime($raw_date)) : date('Y-m-d');
        $company = isset($post['company']) ? $post['company'] : '';
        $vessel = isset($post['vessel']) ? $post['vessel'] : '';
        $port = isset($post['port']) ? $post['port'] : '';

        // Calculate max rows between release and successor arrays
        $max_rows = max(
            isset($post['release_name']) ? count($post['release_name']) : 0, 
            isset($post['successor_name']) ? count($post['successor_name']) : 0
        );
        
        $this->db->trans_start();

        for ($i = 0; $i < $max_rows; $i++) {
            $data = array(
                'company'               => $company,
                'vessel'                => $vessel,
                'port'                  => $port,
                'date_created'          => $date_created,
                
                'release_name'          => isset($post['release_name'][$i]) ? $post['release_name'][$i] : '',
                'release_rank'          => isset($post['release_rank'][$i]) ? $post['release_rank'][$i] : '',
                'release_reason'        => isset($post['release_reason'][$i]) ? $post['release_reason'][$i] : '',
                'release_others'        => isset($post['release_others'][$i]) ? $post['release_others'][$i] : '',
                
                'successor_name'        => isset($post['successor_name'][$i]) ? $post['successor_name'][$i] : '',
                'successor_rank'        => isset($post['successor_rank'][$i]) ? $post['successor_rank'][$i] : '',
                'successor_bs'          => isset($post['successor_bs'][$i]) ? $post['successor_bs'][$i] : '0',
                'successor_ot'          => isset($post['successor_ot'][$i]) ? $post['successor_ot'][$i] : '0',
                'successor_leavepay'    => isset($post['successor_leavepay'][$i]) ? $post['successor_leavepay'][$i] : '0',
                
                'addusrdate'            => date('Y-m-d H:i:s'),
                'userid_add'            => $userid,
                'deletes'               => 0
            );

            $this->db->insert('report_introduction', $data);
            $idReport = $this->db->insert_id();

            if ($idReport) {
                $batchData = array(
                    'batchID' => $batchID,
                    'idperson' => null, 
                    'id_report_introduction' => $idReport
                );
                $this->db->insert('batch_report_introduction', $batchData);
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo json_encode(array('success' => false, 'message' => 'Gagal menyimpan data'));
        } else {
            echo json_encode(array('success' => true, 'message' => 'Data berhasil disimpan', 'batchID' => $batchID));
        }
    }

    public function delete_report_introduction()
    {
        $batchID = $this->input->post('batchID', true);

        if (empty($batchID)) {
            echo json_encode(array('success' => false, 'message' => 'Batch ID tidak ditemukan'));
            return;
        }

        $sql = "UPDATE report_introduction 
                SET deletes = '1' 
                WHERE id IN (
                    SELECT id_report_introduction 
                    FROM batch_report_introduction 
                    WHERE batchID = ?
                )";
        $this->db->query($sql, array($batchID));

        echo json_encode(array('success' => true, 'message' => 'Data berhasil dihapus'));
    }

    public function get_detail_report_introduction()
    {
        $batchID = $this->input->post('batchID', true);
        if (empty($batchID)) {
            echo json_encode(array('success' => false, 'message' => 'Batch ID tidak ditemukan'));
            return;
        }

        $sql = "
            SELECT r.* 
            FROM report_introduction r
            JOIN batch_report_introduction b ON r.id = b.id_report_introduction
            WHERE b.batchID = ? AND r.deletes = '0'
            ORDER BY r.id ASC
        ";
        $reports = $this->db->query($sql, array($batchID))->result();

        if (empty($reports)) {
            echo json_encode(array('success' => false, 'message' => 'Data tidak ditemukan'));
            return;
        }

        echo json_encode(array('success' => true, 'data' => $reports));
    }

    public function generatePDF_Introduction($batchID = '')
    {
        if (empty($batchID)) {
            echo "Batch ID tidak ditemukan";
            return;
        }

        $sql = "
            SELECT r.* 
            FROM report_introduction r
            JOIN batch_report_introduction b ON r.id = b.id_report_introduction
            WHERE b.batchID = ? AND r.deletes = '0'
            ORDER BY r.id ASC
        ";
        $reports = $this->db->query($sql, array($batchID))->result();

        if (empty($reports)) {
            echo "Data Introduction tidak ditemukan";
            return;
        }

        foreach ($reports as $r) {
            if (!empty($r->release_others)) {
                $r->release_others = $this->datacontext->getTaxStatusById($r->release_others);
            }
        }

        $data['reports'] = $reports;
        $data['meta'] = $reports[0];

        require(APPPATH . "views/frontend/pdf/mpdf60/mpdf.php");

        $mpdf = new mPDF('utf-8', 'A4');
        $mpdf->SetTitle('Instruction Letter');
        $mpdf->SetFont('dejavusans');

        $html = $this->load->view('Report/IntroductionReport/form_introduction_pdf_report', $data, TRUE);
        $mpdf->WriteHTML($html);

        $filename = "Instruction_Letter_" . $batchID . ".pdf";
        $mpdf->Output($filename, 'I');
        exit;
    }
}
