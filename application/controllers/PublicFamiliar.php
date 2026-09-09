<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicFamiliar extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MCrewscv');
    }

    // ============================================================
    //  HELPER: Load topics/departments dari DB
    // ============================================================
    private function _getTopicsForDept($deptName)
    {
        return $this->db
            ->where('dept_name', $deptName)
            ->where('is_active', 1)
            ->order_by('order_no', 'ASC')
            ->get('mst_fam_topic')->result();
    }

    private function _getDeptByName($deptName)
    {
        return $this->db->where('department_name', $deptName)
                        ->limit(1)
                        ->get('mst_fam_department')->row();
    }

    /**
     * Public page: Render checklist form for a department
     * URL: /PublicFamiliar/form/{token}
     */
    public function form($token = '')
    {
        if (empty($token)) {
            show_404();
            return;
        }

        // Validate token
        $link = $this->db->where('token', $token)
                         ->where('is_active', 1)
                         ->get('fam_public_links')->row();

        if (empty($link)) {
            $data['error_message'] = 'Link tidak valid atau sudah tidak aktif.';
            $this->load->view('Public/public_familiar_checklist', $data);
            return;
        }

        // Get batch data
        $this->db->where('batch_id', $link->batch_id);
        $batchRows = $this->db->get('history_familiarization')->result();

        if (empty($batchRows)) {
            $data['error_message'] = 'Data familiarization tidak ditemukan.';
            $this->load->view('Public/public_familiar_checklist', $data);
            return;
        }

        $master = $batchRows[0];

        // Get crew list
        $crewList = array();
        foreach ($batchRows as $row) {
            $crewList[] = array(
                'nama_crew' => $row->nama_crew,
                'rank'      => $row->rank,
                'vessel'    => $row->vessel
            );
        }

        // Load topics untuk department ini (dinamis dari mst_fam_topic)
        $checklistTopics = $this->_getTopicsForDept($link->department);

        // Get existing audit trail untuk pre-fill form
        $existingAudit = $this->db->where('batch_id', $link->batch_id)
                                  ->where('department', $link->department)
                                  ->get('fam_checklist_audit')->result();

        $auditMap = array();
        foreach ($existingAudit as $a) {
            // audit bisa memakai item_name = 'topic_N'
            $auditMap[$a->item_name] = $a;
        }

        $data = array(
            'link'            => $link,
            'master'          => $master,
            'crewList'        => $crewList,
            'checklistTopics' => $checklistTopics, // Ganti allowedItems + checklistItems
            'auditMap'        => $auditMap,
            'token'           => $token
        );

        $this->load->view('Public/public_familiar_checklist', $data);
    }

    /**
     * Public API: Submit checklist from department (dinamis)
     */
    public function submit_checklist()
    {
        $token        = $this->input->post('token', true);
        $filledByName = $this->input->post('filled_by_name', true);

        if (empty($token)) {
            echo json_encode(array('success' => false, 'message' => 'Token tidak valid!'));
            return;
        }

        if (empty($filledByName)) {
            echo json_encode(array('success' => false, 'message' => 'Nama pengisi harus diisi!'));
            return;
        }

        // Validate token
        $link = $this->db->where('token', $token)
                         ->where('is_active', 1)
                         ->get('fam_public_links')->row();

        if (empty($link)) {
            echo json_encode(array('success' => false, 'message' => 'Link tidak valid atau sudah tidak aktif!'));
            return;
        }

        // Load topics untuk departemen ini (dinamis)
        $topics = $this->_getTopicsForDept($link->department);
        if (empty($topics)) {
            echo json_encode(array('success' => false, 'message' => 'Tidak ada topic untuk departemen ini.'));
            return;
        }

        $this->db->trans_begin();

        $now        = date('Y-m-d H:i:s');
        $time_start = $this->input->post('time_start', true);
        $time_end   = $this->input->post('time_end', true);

        // Save time to fam_public_links
        $this->db->where('token', $token)
                 ->update('fam_public_links', array(
                     'time_start' => !empty($time_start) ? $time_start : null,
                     'time_end'   => !empty($time_end) ? $time_end : null
                 ));

        foreach ($topics as $topic) {
            $fieldName = 'topic_' . $topic->id;
            $val       = $this->input->post($fieldName);

            if ($val !== false && $val !== null && $val !== '') {
                $itemValue = (int) $val;
                $itemKey   = 'topic_' . $topic->id;

                // Delete old audit
                $this->db->where('batch_id', $link->batch_id)
                         ->where('item_name', $itemKey)
                         ->where('department', $link->department)
                         ->delete('fam_checklist_audit');

                // Insert new audit
                $this->db->insert('fam_checklist_audit', array(
                    'batch_id'       => $link->batch_id,
                    'item_name'      => $itemKey,
                    'item_value'     => $itemValue,
                    'department'     => $link->department,
                    'filled_by_name' => $filledByName,
                    'filled_at'      => $now
                ));

                // Update history_fam_topic_detail untuk semua crew dalam batch
                $historyRows = $this->db->where('batch_id', $link->batch_id)
                                        ->get('history_familiarization')->result();
                foreach ($historyRows as $h) {
                    // Upsert: cek apakah sudah ada
                    $existing = $this->db->where('history_id', $h->id)
                                         ->where('topic_id', $topic->id)
                                         ->get('history_fam_topic_detail')->row();
                    if ($existing) {
                        $this->db->where('history_id', $h->id)
                                 ->where('topic_id', $topic->id)
                                 ->update('history_fam_topic_detail', array('is_checked' => $itemValue));
                    } else {
                        $this->db->insert('history_fam_topic_detail', array(
                            'history_id' => $h->id,
                            'topic_id'   => $topic->id,
                            'is_checked' => $itemValue
                        ));
                    }
                }
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(array('success' => false, 'message' => 'Gagal menyimpan checklist'));
        } else {
            $this->db->trans_commit();

            // Generate QR untuk departemen ini (simpan ke history_fam_dept_signature)
            $deptRow = $this->_getDeptByName($link->department);
            if ($deptRow) {
                $crewRows = $this->db->where('batch_id', $link->batch_id)
                                     ->get('history_familiarization')->result();

                // Cek apakah sudah ada QR untuk dept ini
                $existingSig = !empty($crewRows)
                    ? $this->db->where('history_id', $crewRows[0]->id)
                               ->where('dept_id', $deptRow->id)
                               ->get('history_fam_dept_signature')->row()
                    : null;

                if (!$existingSig) {
                    $address_name = 'All Crew - Batch ' . $link->batch_id;
                    $qrFilename   = $this->_generateQRRecord(
                        $address_name,
                        $filledByName,
                        'fam_dept_' . strtolower(str_replace(array('/', ' ', '-'), '', $link->department)),
                        $link->department
                    );

                    if ($qrFilename) {
                        foreach ($crewRows as $h) {
                            $this->db->insert('history_fam_dept_signature', array(
                                'history_id'    => $h->id,
                                'dept_id'       => $deptRow->id,
                                'qr_code_value' => $qrFilename,
                                'signed_by'     => $filledByName,
                                'signed_at'     => $now
                            ));
                        }
                    }
                }
            }

            echo json_encode(array('success' => true, 'message' => 'Checklist berhasil disimpan. Terima kasih!'));
        }
    }

    /**
     * Public API: Form for Crew Confirmation (Shared Link)
     * Menampilkan semua topics dari DB secara dinamis
     */
    public function crew_checklist()
    {
        $batch_id = $this->input->get('batch', true);
        $token    = $this->input->get('token', true);

        if (md5($batch_id . 'CREW_ALL_SECRET') !== $token) {
            $data['error_message'] = 'Link tidak valid atau token kadaluarsa.';
            $this->load->view('Public/public_crew_checklist', $data);
            return;
        }

        $crewRows = $this->db->where('batch_id', $batch_id)->get('history_familiarization')->result();
        if (empty($crewRows)) {
            $data['error_message'] = 'Data batch tidak ditemukan.';
            $this->load->view('Public/public_crew_checklist', $data);
            return;
        }

        $master   = $crewRows[0];
        $crewList = array();
        foreach ($crewRows as $row) {
            $crewList[] = array(
                'idperson'  => $row->idperson,
                'nama_crew' => $row->nama_crew,
                'rank'      => $row->rank,
                'is_signed' => !empty($row->qr_crew)
            );
        }

        // Ambil audit trails
        $audits   = $this->db->where('batch_id', $batch_id)->get('fam_checklist_audit')->result();
        $auditMap = array();
        foreach ($audits as $au) {
            $auditMap[$au->item_name] = $au;
        }

        // Load semua topics aktif (dinamis)
        $checklistItems = $this->db->where('is_active', 1)
                                   ->order_by('order_no', 'ASC')
                                   ->get('mst_fam_topic')->result();

        // Pre-load topic detail values untuk master row (supaya view tidak perlu query DB langsung)
        $topicDetailMap = array();
        if (!empty($master->id)) {
            $details = $this->db->where('history_id', $master->id)->get('history_fam_topic_detail')->result();
            foreach ($details as $d) {
                $topicDetailMap[$d->topic_id] = $d->is_checked;
            }
        }

        $data = array(
            'batch_id'        => $batch_id,
            'token'           => $token,
            'master'          => $master,
            'crewList'        => $crewList,
            'auditMap'        => $auditMap,
            'checklistItems'  => $checklistItems,
            'topicDetailMap'  => $topicDetailMap
        );

        $this->load->view('Public/public_crew_checklist', $data);
    }

    /**
     * Public API: Submit crew signature
     */
    public function submit_crew_confirm()
    {
        $batch_id = $this->input->post('batch_id', true);
        $token = $this->input->post('token', true);
        $idperson = $this->input->post('idperson', true);

        // Validasi Token
        if (md5($batch_id . 'CREW_ALL_SECRET') !== $token) {
            echo json_encode(array('success' => false, 'message' => 'Token tidak valid!'));
            return;
        }

        if (empty($idperson)) {
            echo json_encode(array('success' => false, 'message' => 'Harap pilih identitas Anda!'));
            return;
        }

        // Get crew details
        $crew = $this->db->where('batch_id', $batch_id)
                         ->where('idperson', $idperson)
                         ->get('history_familiarization')->row();

        if (!$crew) {
            echo json_encode(array('success' => false, 'message' => 'Kru tidak ditemukan di dalam batch ini.'));
            return;
        }

        if (!empty($crew->qr_crew)) {
            echo json_encode(array('success' => false, 'message' => 'Anda sudah melakukan konfirmasi materi ini sebelumnya.'));
            return;
        }

        // Generate QR Crew
        $qrCrew = $this->_generateQRRecord($crew->nama_crew, $crew->nama_crew, 'fam_crew', "Crew");
        
        if ($qrCrew) {
            $this->db->where('id', $crew->id)
                     ->update('history_familiarization', array('qr_crew' => $qrCrew));
            echo json_encode(array('success' => true, 'message' => 'Konfirmasi berhasil disimpan. Tanda tangan Anda telah diterbitkan.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal membuat tanda tangan QR.'));
        }
    }

    // ============================================================
    //  PRIVATE UTILITIES
    // ============================================================

    private function _generateQRRecord($address, $createdBy, $prefix, $departement)
    {
        $dateNow = date("Y-m-d");
        $yearNow = date("Y");
        $monthNow = date("m");
        $noSurat = "1";
        $initDivisi = "DKP";
        $initCmp = "AES";
        $insSql = array();

        $batchno = $this->getBatchNo();
        $formatNoSrt = $this->createNo($noSurat, $initCmp, $initDivisi, $initDivisi, $monthNow, $yearNow);

        $insSql["batchno"]   = $batchno;
        $insSql["cmpcode"]   = $initCmp;
        $insSql["nosurat"]   = $formatNoSrt;
        $insSql["issueddiv"] = $initDivisi;
        $insSql["signedby"]  = $initDivisi;
        $insSql["address"]   = $address;
        $insSql["tglsurat"]  = $dateNow;
        $insSql["ket"]       = "Familiarization.".$departement;
        $insSql["copydoc"]   = "0";
        $insSql["canceldoc"] = "0";
        $insSql["createdby"] = $createdBy;

        $this->MCrewscv->insDataDb6($insSql, "tblEmpNoSurat");

        // Kembali ke default DB
        $this->db = $this->load->database('default', TRUE);

        return $this->_createQRCode($batchno, $prefix);
    }

    private function getBatchNo()
    {
        $batchNo = "1";
        $sql = " SELECT (batchno + 1) AS batchNo FROM tblempnosurat ORDER BY batchno DESC LIMIT 0,1 ";
        $data = $this->MCrewscv->getDataQueryDB6($sql);

        if (count($data) > 0) {
            $batchNo = $data[0]->batchNo;
        }
        return $batchNo;
    }

    private function createNo($noNya = "", $cdCmp = "", $cdKeluar = "", $cdTtd = "", $bln = "", $thn = "")
    {
        $dt = strlen($noNya);
        $outNo = "";
        if($dt == 1) {
            $outNo = "000".$noNya;
        } else if($dt == 2) {
            $outNo = "00".$noNya;
        } else if($dt == 3) {
            $outNo = "0".$noNya;
        } else {
            $outNo = $noNya;
        }		

        if($cdKeluar == $cdTtd) {
            $cdOutTtd = $cdKeluar;
        } else {
            $cdOutTtd = $cdKeluar."-".$cdTtd;
        }

        $outNo = $outNo."/".$cdCmp."/".$cdOutTtd."/".$bln.$thn;
        return $outNo;
    }

    private function _createQRCode($id, $type = 'fam')
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
}
