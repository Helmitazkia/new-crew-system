<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcu extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MCrewscv');
        $this->load->library('../controllers/DataContext');
        $this->load->library('session');

        // Auth guard
        $allowed = array('print_approve_mcu', 'approve_mcu', 'reject_mcu');
        $current = $this->router->fetch_method();
        if (!in_array($current, $allowed) && !$this->session->userdata('isLogin')) {
            redirect('auth/login');
            exit;
        }
    }

    public function view()
    {
        $this->load->view('ListReport/MCU/view_mcu');
    }

    /**
     * List semua report MCU (untuk DataTables)
     */
    public function get_report_mcu()
    {
        $idperson = $this->input->post('idperson', true);

        $sql = "
            SELECT 
                a.id AS id_report_mcu,
                b.clinic_name,
                a.date_mcu,
                a.status_mcu,
                a.remarks_reject,
                a.upuserdate,
                a.userid_update
            FROM report_mcu AS a
            LEFT JOIN master_mcu AS b 
                ON a.id_master_mcu = b.id
            INNER JOIN report_mcu_person AS c
                ON a.id = c.id_report_mcu
            WHERE a.deletes = '0' 
              AND c.id_person = " . $this->db->escape($idperson) . "
            GROUP BY a.id
            ORDER BY a.id DESC
        ";

        $data   = $this->MCrewscv->getDataQuery($sql);
        $result = array();

        if (!empty($data)) {
            foreach ($data as $row) {
                $row->date_mcu = !empty($row->date_mcu)
                    ? date('d M Y', strtotime($row->date_mcu))
                    : '';
                $row->upuserdate = !empty($row->upuserdate)
                    ? date('d M Y H:i:s', strtotime($row->upuserdate))
                    : '';
                $result[] = $row;
            }
        }

        echo json_encode(array(
            'success' => !empty($result),
            'data'    => $result
        ));
    }

    /**
     * Detail report MCU (untuk modal detail)
     */
    public function get_report_mcu_detail()
    {
        $id_report = $this->input->post('id_report', true);
        $id_person = $this->input->post('idperson', true);

        if (empty($id_report)) {
            echo json_encode(array('success' => false, 'message' => 'ID Report MCU tidak ditemukan'));
            return;
        }

        $report = $this->_getReportDetail($id_report);

        if (!$report) {
            echo json_encode(array('success' => false, 'message' => 'Data MCU tidak ditemukan'));
            return;
        }

        $persons = $this->_getPersonsByReport($id_report,$id_person);

        echo json_encode(array(
            'success' => true,
            'data'    => array(
                'report'  => $report,
                'persons' => $persons
            )
        ));
    }

    /**
     * Data master klinik MCU
     */
    public function get_data_m_master_mcu()
    {
        $sql = "
            SELECT id, clinic_name, address_clinic, telp, fax, email
            FROM master_mcu
        ";

        $data   = $this->MCrewscv->getDataQuery($sql);
        $result = array();

        if (!empty($data)) {
            foreach ($data as $row) {
                $result[] = array(
                    'id'             => $row->id,
                    'clinic_name'    => $row->clinic_name,
                    'address_clinic' => $row->address_clinic,
                    'telp'           => $row->telp,
                    'fax'            => $row->fax,
                    'email'          => $row->email
                );
            }
        }

        echo json_encode(array(
            'success' => !empty($result),
            'data'    => $result
        ));
    }

    /**
     * Search crew by name (autocomplete)
     */
    public function get_crew_by_name()
    {
        $keyword = $this->input->post('keyword', true);
        $keyword = $this->db->escape_like_str($keyword);

        $sql = "
            SELECT 
                CONCAT_WS(' ', A.fname, A.mname, A.lname) AS nama_crew,
                A.applyfor,
                A.vesselfor
            FROM mstpersonal A
            WHERE 
                A.fname LIKE '%$keyword%'
                OR A.mname LIKE '%$keyword%'
                OR A.lname LIKE '%$keyword%'
            ORDER BY A.fname ASC
            LIMIT 20
        ";

        $data   = $this->MCrewscv->getDataQuery($sql);
        $result = array();

        if (!empty($data)) {
            foreach ($data as $row) {
                $result[] = array(
                    'nama_crew' => $row->nama_crew,
                    'jabatan'   => $row->applyfor,
                    'vessel'    => $row->vesselfor
                );
            }
        }

        echo json_encode(array(
            'success' => !empty($result),
            'data'    => $result
        ));
    }

    /**
     * Get company base vessel (distinct)
     */
    public function get_CompanyBaseVessel()
    {
        $sql = "
            SELECT DISTINCT nmcmp
            FROM mstvessel
            WHERE nmcmp IS NOT NULL
                AND TRIM(nmcmp) NOT IN ('', '-')
        ";

        $data   = $this->MCrewscv->getDataQuery($sql);
        $result = array();

        if (!empty($data)) {
            foreach ($data as $row) {
                $result[] = array(
                    'nmcmp' => isset($row->nmcmp) ? $row->nmcmp : ''
                );
            }
        }

        echo json_encode(array(
            'success' => !empty($result),
            'data'    => $result
        ));
    }

    /**
     * Get crew info for auto-filling based on idperson using tblcontract
     */
    public function get_crew_info_by_idperson()
    {
        $idperson = $this->input->post('idperson', true);

        // Join to tblcontract to get rank and vessel based on latest contract
        $sql = "
            SELECT 
                CONCAT_WS(' ', A.fname, A.mname, A.lname) AS nama_crew,
                C.nmrank AS jabatan,
                D.nmvsl AS vessel_name
            FROM mstpersonal A
            LEFT JOIN tblcontract B ON A.idperson = B.idperson AND B.deletests = '0'
            LEFT JOIN mstrank C ON C.kdrank = B.signonrank AND C.deletests = '0'
            LEFT JOIN mstvessel D ON D.kdvsl = B.signonvsl AND D.deletests = '0'
            WHERE A.idperson = ?
            ORDER BY B.signondt DESC, B.idcontract DESC
            LIMIT 1
        ";

        $data = $this->db->query($sql, array($idperson))->row();

        // If no contract found, fallback to mstpersonal
        if ($data && (empty($data->jabatan) || empty($data->vessel_name))) {
            $sqlFallback = "
                SELECT 
                    CONCAT_WS(' ', fname, mname, lname) AS nama_crew,
                    applyfor AS jabatan,
                    vesselfor AS vessel_name
                FROM mstpersonal
                WHERE idperson = ?
                LIMIT 1
            ";
            $dataFallback = $this->db->query($sqlFallback, array($idperson))->row();
            if ($dataFallback) {
                if (empty($data->jabatan)) $data->jabatan = $dataFallback->jabatan;
                if (empty($data->vessel_name)) $data->vessel_name = $dataFallback->vessel_name;
            }
        }

        echo json_encode(array(
            'success' => !empty($data),
            'data'    => $data
        ));
    }

    // ============================================================
    // CRUD OPERATIONS
    // ============================================================

    /**
     * Submit report MCU baru + kirim notifikasi email
     */
    public function submit_report_mcu()
    {
        $post       = $this->input->post(NULL, TRUE);
        $id_clinic  = $this->input->post('id_clinic', TRUE);
        $date_mcu   = $this->input->post('date_mcu', TRUE);
        $header_mcu = $this->input->post('header_mcu', TRUE);
        $userid     = $this->session->userdata('idUserCrewSystem');

        if (empty($post)) {
            echo json_encode(array('success' => false, 'message' => 'Data kosong'));
            return;
        }

        $crewList = isset($post['crew_list']) ? $post['crew_list'] : array();
        $mcu      = isset($post['mcu']) ? $post['mcu'] : array();

        $this->db->trans_begin();

        // 1. Insert report_mcu
        $reportMcu = array(
            'id_master_mcu' => $id_clinic,
            'status_mcu'    => 0,
            'date_mcu'      => $date_mcu,
            'addusrdate'    => date('Y-m-d H:i:s'),
            'userid_add'    => $userid,
            'deletes'       => 0
        );

        $this->db->insert('report_mcu', $reportMcu);
        $idReportMcu = $this->db->insert_id();

        if (!$idReportMcu) {
            $this->db->trans_rollback();
            echo json_encode(array('success' => false, 'message' => 'Gagal insert report_mcu'));
            return;
        }

        $subData    = isset($post['sub_data']) ? $post['sub_data'] : array();

        // 2. Insert report_answer_mcu
        $answerData = array(
            'id_report_mcu' => $idReportMcu,
            'header_mcu'    => $header_mcu
        );
        for ($i = 0; $i < 13; $i++) {
            $answerData['answer_' . ($i + 1)] = isset($mcu[$i]) ? $mcu[$i] : NULL;
        }

        // Sub answers
        for ($i = 1; $i <= 8; $i++) {
            $answerData['sub_answer_2_' . $i] = isset($subData['sub_answer_2_'.$i]) ? $subData['sub_answer_2_'.$i] : '0';
        }
        for ($i = 1; $i <= 6; $i++) {
            $answerData['sub_answer_5_' . $i] = isset($subData['sub_answer_5_'.$i]) ? $subData['sub_answer_5_'.$i] : '0';
        }

        $this->db->insert('report_answer_mcu', $answerData);

        // 3. Insert report_mcu_person
        foreach ($crewList as $crew) {
            $namaCrew = trim($crew['name_crew']);

            $query    = $this->db->query(
                "SELECT idperson FROM mstpersonal WHERE CONCAT_WS(' ', fname, mname, lname) = ? LIMIT 1",
                array($namaCrew)
            );
            $row      = $query->row();
            $idPerson = $row ? $row->idperson : NULL;

            $this->db->insert('report_mcu_person', array(
                'id_report_mcu' => $idReportMcu,
                'id_person'     => $idPerson,
                'name_person'   => $namaCrew,
                'rank'          => $crew['jabatan'],
                'vessel_name'   => $crew['vessel_name']
            ));
        }

        // 4. Commit & notify
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(array('success' => false, 'message' => 'Gagal simpan MCU'));
        } else {
            $this->db->trans_commit();
            $this->_sendNotificationMCU($idReportMcu);
            echo json_encode(array(
                'success'        => true,
                'message'        => 'MCU berhasil disimpan',
                'id_report_mcu'  => $idReportMcu
            ));
        }
    }

    /**
     * Soft delete MCU (set deletes = 1)
     */
    public function delete_list_mcu()
    {
        $id_report = $this->input->post('id_report', true);

        if (empty($id_report)) {
            echo json_encode(array('success' => false, 'message' => 'ID Report MCU tidak ditemukan'));
            return;
        }

        $this->db->where('id', $id_report);
        $this->db->update('report_mcu', array('deletes' => 1));

        echo json_encode(array('success' => true, 'message' => 'Data MCU berhasil dihapus'));
    }

    // ============================================================
    // PDF GENERATION
    // ============================================================

    /**
     * Generate PDF MCU form via mPDF
     */
    public function generatePDF_MCU()
    {
        $personsJson    = $this->input->post('persons');
        $mcu            = $this->input->post('mcu');
        $date_mcu       = $this->input->post('date_mcu', TRUE);
        $clinic_name    = $this->input->post('clinic_name', TRUE);
        $status_mcu     = $this->input->post('status_mcu', TRUE);
        $signature_qr   = $this->input->post('signature_qr', TRUE);
        $address_clinic = $this->input->post('address_clinic', TRUE);
        $telp           = $this->input->post('telp', TRUE);
        $fax            = $this->input->post('fax', TRUE);
        $header_mcu     = $this->input->post('header_mcu', TRUE);

        $subDataJson    = $this->input->post('sub_data');
        $subData = json_decode($subDataJson, true);
        if (!$subData) $subData = array();

        if (empty($personsJson) || empty($mcu)) {
            echo "Data MCU tidak lengkap";
            exit;
        }

        $persons = json_decode($personsJson);
        if (!is_array($persons)) {
            echo "Format crew tidak valid";
            exit;
        }

        if (is_string($mcu)) {
            $mcu = explode(',', $mcu);
        }

        // Build MCU checkbox object
        $mcuObj = new stdClass();
        for ($i = 0; $i < 13; $i++) {
            $prop = 'mcu' . ($i + 1);
            $mcuObj->$prop = isset($mcu[$i]) ? $mcu[$i] : 0;
        }

        $data = array(
            'persons'        => $persons,
            'mcu'            => $mcuObj,
            'subData'        => $subData,
            'date_mcu'       => $date_mcu,
            'clinic_name'    => $clinic_name,
            'address_clinic' => $address_clinic,
            'telp'           => $telp,
            'fax'            => $fax,
            'header_mcu'     => $header_mcu,
            'status_mcu'     => $status_mcu,
            'signature_qr'   => $signature_qr
        );

        require(APPPATH . "views/frontend/pdf/mpdf60/mpdf.php");

        $mpdf = new mPDF('utf-8', 'A4');
        $mpdf->SetTitle('Form MCU');
        $mpdf->SetFont('dejavusans');

        $html = $this->load->view('ListReport/MCU/form_mcu_pdf', $data, TRUE);
        $mpdf->WriteHTML($html);

        $filename = "MCU_Form_" . date('Ymd_His') . ".pdf";
        $mpdf->Output($filename, 'I');
        exit;
    }

    // ============================================================
    // APPROVE / REJECT FLOW
    // ============================================================

    /**
     * Preview halaman approve MCU (diakses via email link)
     */
    public function print_approve_mcu($hashId = '')
    {
        if (empty($hashId)) {
            show_error('ID MCU tidak valid');
            return;
        }

        $id_report = base64_decode(base64_decode(base64_decode($hashId)));

        if (!is_numeric($id_report)) {
            show_error('ID MCU tidak valid');
            return;
        }

        $report = $this->_getReportDetail($id_report);

        if (!$report) {
            show_error('Data MCU tidak ditemukan');
            return;
        }

        $persons = $this->_getPersonsforPrint($id_report);

        // Map answers to mcu object
        $mcu = new stdClass();
        for ($i = 1; $i <= 13; $i++) {
            $prop = 'mcu' . $i;
            $ans  = 'answer_' . $i;
            $mcu->$prop = (int) $report->$ans;
        }

        $subData = array();
        for ($i = 1; $i <= 8; $i++) {
            $prop = 'sub_answer_2_' . $i;
            $subData[$prop] = isset($report->$prop) ? $report->$prop : '0';
        }
        for ($i = 1; $i <= 6; $i++) {
            $prop = 'sub_answer_5_' . $i;
            $subData[$prop] = isset($report->$prop) ? $report->$prop : '0';
        }

        $data = array(
            'clinic_name'    => $report->clinic_name,
            'address_clinic' => $report->address_clinic,
            'telp'           => $report->telp,
            'fax'            => $report->fax,
            'date_mcu'       => $report->date_mcu,
            'mcu'            => $mcu,
            'subData'        => $subData,
            'persons'        => $persons,
            'id_report'      => $id_report,
            'hash_id'        => $hashId,
            'signature_qr'   => $report->signature_qr,
            'status_mcu'     => $report->status_mcu,
            'header_mcu'     => $report->header_mcu
        );

        $this->load->view('ListReport/MCU/print_approve_mcu', $data);
    }

    /**
     * Approve MCU + generate QR + email ke klinik
     */

  	function getBatchNo()
    {
        $batchNo = "1";
        $sql = " SELECT (batchno + 1) AS batchNo FROM tblempnosurat ORDER BY batchno DESC LIMIT 0,1 ";
        $data = $this->MCrewscv->getDataQueryDB6($sql);

        // print_r($data);exit;

        if(count($data) > 0)
        {
            $batchNo = $data[0]->batchNo;
        }

        return $batchNo;
    }

    function createNo($noNya = "",$cdCmp = "",$cdKeluar = "",$cdTtd = "",$bln = "",$thn = "")
    {
        $dt = strlen($noNya);
        $outNo = "";
        if($dt == 1)
        {
            $outNo = "000".$noNya;
        }
        else if($dt == 2)
        {
            $outNo = "00".$noNya;
        }
        else if($dt == 3)
        {
            $outNo = "0".$noNya;
        }
        else{
            $outNo = $noNya;
        }		

        if($cdKeluar == $cdTtd)
        {
            $cdOutTtd = $cdKeluar;
        }else{
            $cdOutTtd = $cdKeluar."-".$cdTtd;
        }

        $outNo = $outNo."/".$cdCmp."/".$cdOutTtd."/".$bln.$thn;
        
        return $outNo;
    }


    public function approve_mcu()
    {
           
        $hashId = $this->input->post('hash_id', true);

        $dateNow = date("Y-m-d");
		$yearNow = date("Y");
		$monthNow = date("m");
		$noSurat = "1";
		$initDivisi = "DKP";
		$initCmp = "AES";
		$insSql = array();
		$imgName = "";

        $batchno = $this->getBatchNo();
        $formatNoSrt = $this->createNo($noSurat,$initCmp,$initDivisi,$initDivisi,$monthNow,$yearNow);
        
        //$department = strtoupper($rsl[0]->department);
        
        $insSql["batchno"] = $batchno;
        $insSql["cmpcode"] = $initCmp;
        $insSql["nosurat"] = $formatNoSrt;
        $insSql["issueddiv"] = $initDivisi;
        $insSql["signedby"] = $initDivisi;
        $insSql["address"] = "Crewing New System";
        $insSql["tglsurat"] = $dateNow;
        $insSql["ket"] = "MCU Crewing";
        $insSql["copydoc"] = "0";
        $insSql["canceldoc"] = "0";
        $insSql["createdby"] = "Eva Marliana (Crew Manager)";
        $this->MCrewscv->insDataDb6($insSql,"tblEmpNoSurat");

        // $batchParams = base64_encode($batchno);


        if (empty($hashId)) {
            show_error('Invalid MCU ID');
        }

        $idReport = base64_decode(base64_decode(base64_decode($hashId)));

        if (!is_numeric($idReport)) {
            show_error('Invalid MCU ID');
        }

        // 1. Get klinik email
        $klinik = $this->db->query(
            "SELECT b.email FROM report_mcu AS a INNER JOIN master_mcu AS b ON a.id_master_mcu = b.id WHERE a.id = ? LIMIT 1",
            array($idReport)
        )->row();

        // 2. Create QR Code
        $qrImg = $this->_createQRCode($batchno, 'approveCM');

        // 3. Update status
        $this->db->where('id', $idReport);
        $this->db->update('report_mcu', array(
            'upuserdate'   => date('Y-m-d H:i:s'),
            'status_mcu'   => 1,
            'signature_qr' => $qrImg
        ));

        // 4. Email ke klinik jika ada
        $idEnc = base64_encode(base64_encode(base64_encode($idReport)));
        $link  = base_url("ListReport/Mcu/print_approve_mcu/$idEnc");
        if ($klinik && !empty($klinik->email)) {
            $this->_sendEmailToClinic($idReport, $klinik->email, $link);
        }

        $this->session->set_flashdata('swal_success', 'Approve MCU berhasil diproses!');
        redirect('ListReport/Mcu/print_approve_mcu/' . $hashId);
    }

    /**
     * Reject MCU + generate QR
     */
    public function reject_mcu()
    {
        $hashId         = $this->input->post('hash_id', true);
        $remarks_reject = $this->input->post('remarks_reject', true);

        $dateNow = date("Y-m-d");
		$yearNow = date("Y");
		$monthNow = date("m");
		$noSurat = "1";
		$initDivisi = "DKP";
		$initCmp = "AES";
		$insSql = array();
		$imgName = "";

        $batchno = $this->getBatchNo();
        $formatNoSrt = $this->createNo($noSurat,$initCmp,$initDivisi,$initDivisi,$monthNow,$yearNow);
        
        $department = strtoupper($rsl[0]->department);
        
        $insSql["batchno"] = $batchno;
        $insSql["cmpcode"] = $initCmp;
        $insSql["nosurat"] = $formatNoSrt;
        $insSql["issueddiv"] = $initDivisi;
        $insSql["signedby"] = $initDivisi;
        $insSql["address"] = "Crewing New System";
        $insSql["tglsurat"] = $dateNow;
        $insSql["ket"] = "MCU Crewing";
        $insSql["copydoc"] = "0";
        $insSql["canceldoc"] = "0";
        $insSql["createdby"] = "Eva Marliana (Crew Manager)";
        $this->MCrewscv->insDataDb6($insSql,"tblEmpNoSurat");

        if (empty($hashId)) {
            show_error('Invalid MCU ID');
        }

        $idReport = base64_decode(base64_decode(base64_decode($hashId)));

        if (!is_numeric($idReport)) {
            show_error('Invalid MCU ID');
        }

        if (empty($remarks_reject)) {
            show_error('Remark reject wajib diisi');
        }

        $qrImg = $this->_createQRCode($batchno, 'rejectCM');

        $this->db->where('id', $idReport);
        $this->db->update('report_mcu', array(
            'upuserdate'     => date('Y-m-d H:i:s'),
            'status_mcu'     => 2,
            'remarks_reject' => $remarks_reject,
            'date_reject'    => date('Y-m-d H:i:s'),
            'signature_qr'   => $qrImg
        ));

        $this->session->set_flashdata('swal_success', 'Reject MCU berhasil diproses!');
        redirect('ListReport/Mcu/print_approve_mcu/' . $hashId);
    }

    // ============================================================
    // PRIVATE HELPERS (DRY - eliminasi duplikasi)
    // ============================================================

    /**
     * Get detail report MCU with join master_mcu & report_answer_mcu
     */
    private function _getReportDetail($id_report)
    {
        $sql = "
            SELECT 
                a.id AS id_report,
                b.clinic_name,
                b.address_clinic,
                b.telp,
                b.fax,
                a.date_mcu,
                c.header_mcu,
                c.answer_1, c.answer_2, c.answer_3, c.answer_4, c.answer_5,
                c.answer_6, c.answer_7, c.answer_8, c.answer_9, c.answer_10, c.answer_11, c.answer_12, c.answer_13,
                c.sub_answer_2_1, c.sub_answer_2_2, c.sub_answer_2_3, c.sub_answer_2_4,
                c.sub_answer_2_5, c.sub_answer_2_6, c.sub_answer_2_7, c.sub_answer_2_8,
                c.sub_answer_5_1, c.sub_answer_5_2, c.sub_answer_5_3, c.sub_answer_5_4,
                c.sub_answer_5_5, c.sub_answer_5_6,
                a.status_mcu,
                a.signature_qr
            FROM report_mcu AS a
            INNER JOIN master_mcu AS b ON a.id_master_mcu = b.id
            INNER JOIN report_answer_mcu AS c ON a.id = c.id_report_mcu
            WHERE a.deletes = '0' AND a.id = ?
            LIMIT 1
        ";

        return $this->db->query($sql, array($id_report))->row();
    }

    /**
     * Get persons by report MCU ID
     */
    private function _getPersonsByReport($id_report,$id_person)
    {
        $sql = "
            SELECT id, id_report_mcu, id_person, name_person, rank, vessel_name
            FROM report_mcu_person
            WHERE id_report_mcu = ? AND id_person = ?
            ORDER BY id ASC
        ";

        return $this->db->query($sql, array($id_report,$id_person))->result();
    }

    private function _getPersonsforPrint($id_report)
    {
        $sql = "
            SELECT id, id_report_mcu, id_person, name_person, rank, vessel_name
            FROM report_mcu_person
            WHERE id_report_mcu = ? 
            ORDER BY id ASC
        ";

        return $this->db->query($sql, array($id_report))->result();
    }

    /**
     * Initialize PHPMailer with SMTP config
     */
    private function _initMailer()
    {
        require_once APPPATH . 'third_party/PHPMailer/PHPMailer/class.phpmailer.php';
        require_once APPPATH . 'third_party/PHPMailer/PHPMailer/class.smtp.php';

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host       = 'smtp.zoho.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'noreply@andhika.com';
        $mail->Password   = 'PCWLzCWDQH8C';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        return $mail;
    }

    /**
     * Build HTML table for crew list (email body)
     */
    private function _buildCrewHtml($persons, $withStyle = false)
    {
        $style = $withStyle ? ' style="border-collapse: collapse;"' : '';
        $trStyle = $withStyle ? ' style="background-color: #f2f2f2;"' : '';

        $html = '<table border="1" cellpadding="6" cellspacing="0" width="100%"' . $style . '>
            <tr' . $trStyle . '>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Kapal</th>
            </tr>';

        $no = 1;
        foreach ($persons as $p) {
            $html .= "
                <tr>
                    <td align='center'>$no</td>
                    <td>{$p->name_person}</td>
                    <td>{$p->rank}</td>
                    <td>{$p->vessel_name}</td>
                </tr>";
            $no++;
        }
        $html .= '</table>';

        return $html;
    }

    /**
     * Create QR Code for MCU approval/rejection
     */
    private function _createQRCode($id, $type = 'approveCM')
    {
        $this->load->library('ciqrcode');
        if (!isset($this->ciqrcode)) {
            if (!class_exists('Ciqrcode')) {
                require_once APPPATH . 'libraries/Ciqrcode.php';
            }
            $this->ciqrcode = new Ciqrcode();
        }

        $config = array(
            'cacheable' => true,
            'cachedir'  => './assets/imgQRCodeCrewCV/',
            'errorlog'  => './assets/imgQRCodeCrewCV/',
            'imagedir'  => './assets/imgQRCodeCrewCV/',
            'quality'   => true,
            'size'      => '1024'
        );

        $this->ciqrcode->initialize($config);

        $imgName = $type . '_' . base64_encode(base64_encode(base64_encode($id))) . '.png';

        $params = array(
            'data'     => "http://apps.andhika.com/myapps/myLetter/viewLetter/" . base64_encode($id),
            'level'    => 'H',
            'size'     => 6,
            'savename' => FCPATH . $config['imagedir'] . $imgName,
            'logo'     => './assets/img/andhika.png'
        );

        $this->ciqrcode->generate($params);

        return $imgName;
    }

    /**
     * Send notification email to Crew Manager after MCU submitted
     */
    private function _sendNotificationMCU($idReport)
    {
        $sqlHeader = "
            SELECT a.id AS id_report, b.clinic_name, a.date_mcu
            FROM report_mcu AS a
            INNER JOIN master_mcu AS b ON a.id_master_mcu = b.id
            WHERE a.deletes = '0' AND a.id = ?
            LIMIT 1
        ";

        $header = $this->db->query($sqlHeader, array($idReport))->row();
        if (!$header) return;

        $persons = $this->_getPersonsforPrint($idReport);

        $idEnc = base64_encode(base64_encode(base64_encode($idReport)));
        $link  = base_url("ListReport/Mcu/print_approve_mcu/$idEnc");

        $cmEmail = "helmi.tazkia@andhika.com";
        $this->_sendEmailMCU($cmEmail, $header, $persons, $link);
    }

    /**
     * Send MCU request email
     */
    private function _sendEmailMCU($to, $header, $persons, $link)
    {
        try {
            $mail = $this->_initMailer();
            $mail->setFrom('noreply@andhika.com', 'Crewing System');
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = 'Medical Check Up (MCU) Request';

            $crewHtml = $this->_buildCrewHtml($persons);

            $mail->Body = "
                <p>Dear Crew Manager / Bu Eva Marliana,</p>
                <p>Berikut permintaan <strong>Medical Check Up (MCU)</strong> yang telah disubmit:</p>
                <ul>
                    <li><strong>Klinik:</strong> {$header->clinic_name}</li>
                    <li><strong>Tanggal MCU:</strong> " . date('d M Y', strtotime($header->date_mcu)) . "</li>
                </ul>
                <p><strong>Daftar Crew:</strong></p>
                $crewHtml
                <p><strong>Preview / Print MCU:</strong><br><a href='$link'>Klik di sini</a></p>
                <br>
                <p><em>Email ini dikirim otomatis oleh Crewing System.</em></p>
            ";

            if (!$mail->send()) {
                log_message('error', 'MCU EMAIL ERROR: ' . $mail->ErrorInfo);
            }

        } catch (Exception $e) {
            log_message('error', 'MCU Email Error: ' . $e->getMessage());
        }
    }

    /**
     * Send approval email to clinic
     */
    private function _sendEmailToClinic($idReport, $clinicEmail, $link)
    {
        $sqlHeader = "
            SELECT a.id AS id_report, b.clinic_name, a.date_mcu, b.email
            FROM report_mcu AS a
            INNER JOIN master_mcu AS b ON a.id_master_mcu = b.id
            WHERE a.deletes = '0' AND a.id = ?
            LIMIT 1
        ";

        $header = $this->db->query($sqlHeader, array($idReport))->row();
        if (!$header) return;

        $persons = $this->_getPersonsforPrint($idReport);

        try {
            $mail = $this->_initMailer();
            $mail->setFrom('noreply@andhika.com', 'Crewing System - PT. Andhini Eka Karya Sejahtera');
            $mail->addAddress($clinicEmail);
            $mail->addCC('helmi.tazkia@andhika.com', 'Crew Manager');
            $mail->isHTML(true);
            $mail->Subject = 'Approval Medical Check Up (MCU) - ' . $header->clinic_name;

            $crewHtml = $this->_buildCrewHtml($persons, true);

            $mail->Body = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6;'>
                    <p>Kepada Yth,</p>
                    <p><strong>Manager/Koordinator {$header->clinic_name}</strong></p>
                    <p>Dengan hormat,</p>
                    <p>Berikut kami sampaikan bahwa <strong>Medical Check Up (MCU)</strong> untuk crew kami 
                    <strong>TELAH DISETUJUI</strong> dan dapat dilaksanakan sesuai jadwal:</p>
                    <ul>
                        <li><strong>Klinik:</strong> {$header->clinic_name}</li>
                        <li><strong>Tanggal MCU:</strong> " . date('d M Y', strtotime($header->date_mcu)) . "</li>
                        <li><strong>Jumlah Crew:</strong> " . count($persons) . " orang</li>
                    </ul>
                    <p><strong>Daftar Crew yang akan melakukan MCU:</strong></p>
                    $crewHtml
                    <p><strong>Preview / Print MCU:</strong><br><a href='$link'>Klik di sini</a></p>
                    <p>Mohon MCU dapat dilaksanakan sesuai prosedur. Biaya akan dibebankan kepada perusahaan 
                    sebagaimana kesepakatan sebelumnya.</p>
                    <p>Untuk informasi lebih lanjut, dapat menghubungi:</p>
                    <ul>
                        <li><strong>Eva Marliana</strong> (Crew Manager)</li>
                        <li>Email: Eva.marliana@andhika.com</li>
                    </ul>
                    <br>
                    <p>Hormat kami,</p>
                    <p><strong>PT. Andhini Eka Karya Sejahtera</strong><br>Crew Management Department</p>
                    <hr style='border: none; border-top: 1px solid #ddd; margin: 20px 0;'>
                    <p style='font-size: 12px; color: #666;'>
                        <em>Email ini dikirim otomatis dari Crewing System.<br>
                        Mohon tidak membalas email ini.</em>
                    </p>
                </div>
            ";

            if (!$mail->send()) {
                log_message('error', 'MCU CLINIC EMAIL ERROR: ' . $mail->ErrorInfo);
            }

        } catch (Exception $e) {
            log_message('error', 'MCU Clinic Email Error: ' . $e->getMessage());
        }
    }
}