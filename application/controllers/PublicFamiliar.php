<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicFamiliar extends CI_Controller {

    /**
     * Mapping checklist item => department
     */
    private $itemDepartmentMap = array(
        'item_1'  => 'Crewing',
        'item_2'  => 'QHSE',
        'item_3'  => 'DPA / Marine Safety',
        'item_4'  => 'DPA',
        'item_5'  => 'Operation',
        'item_6'  => 'DPA / Marine Safety',
        'item_7'  => 'Technical',
        'item_8'  => 'Purchasing',
        'item_9'  => 'Finance',
        'item_10' => 'Operation',
        'item_11' => 'DPA / Marine Safety',
        'item_12' => 'DPA / Marine Safety',
        'item_13' => 'DPA / Marine Safety',
        'item_14' => 'DPA / Marine Safety',
        'item_15' => 'Marine Safety',
        'item_16' => 'Marine Safety',
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MCrewscv');
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

        // Filter items for this department
        $allowedItems = array();
        foreach ($this->itemDepartmentMap as $item => $dept) {
            if ($dept === $link->department) {
                $allowedItems[] = $item;
            }
        }

        // Get existing audit trail for this batch+department
        $existingAudit = $this->db->where('batch_id', $link->batch_id)
                                  ->where('department', $link->department)
                                  ->get('fam_checklist_audit')->result();

        $auditMap = array();
        foreach ($existingAudit as $a) {
            $auditMap[$a->item_name] = $a;
        }

        // Checklist items definition
        $checklistItems = array(
            'item_1'  => array('no' => '1',    'topic' => 'Procedures Related Crewing (Payroll, Working Hours, etc)', 'dept' => 'Crewing'),
            'item_2'  => array('no' => '2',    'topic' => '- Quality, Health, Safety and Environmental (QHSE) Policy', 'dept' => 'QHSE'),
            'item_3'  => array('no' => '3',    'topic' => 'Safety Management System Manual and Document', 'dept' => 'DPA / Marine Safety'),
            'item_4'  => array('no' => '4',    'topic' => 'Duties and Responsibility', 'dept' => 'DPA'),
            'item_5'  => array('no' => '5',    'topic' => 'Procedures Related Ship Operation', 'dept' => 'Operation'),
            'item_6'  => array('no' => '6',    'topic' => 'Procedures Related Emergency', 'dept' => 'DPA / Marine Safety'),
            'item_7'  => array('no' => '7',    'topic' => 'Procedures Related Maintenance of Ship - Technical', 'dept' => 'Technical'),
            'item_8'  => array('no' => '8',    'topic' => 'Procedures Related Maintenance of Ship - Purchasing', 'dept' => 'Purchasing'),
            'item_9'  => array('no' => '9',    'topic' => 'Procedures Related Maintenance of Ship - Finance', 'dept' => 'Finance'),
            'item_10' => array('no' => '10',   'topic' => 'Procedures Related Cargo Handling', 'dept' => 'Operation'),
            'item_11' => array('no' => '11',   'topic' => 'Safety Drill', 'dept' => 'DPA / Marine Safety'),
            'item_12' => array('no' => '12',   'topic' => 'Procedures Related Health', 'dept' => 'DPA / Marine Safet'),
            'item_13' => array('no' => '13',   'topic' => 'Procedures Related Environmental Protection', 'dept' => 'DPA / Marine Safet'),
            'item_14' => array('no' => '14',   'topic' => 'Audit External / Internal', 'dept' => 'DPA / Marine Safety'),
            'item_15' => array('no' => '15',   'topic' => 'Hazard Identification / JSA', 'dept' => 'Marine Safety'),
            'item_16' => array('no' => '16',   'topic' => 'Wearing Personal Protective Equipment (PPE)', 'dept' => 'Marine Safety'),
        );

        $data = array(
            'link'           => $link,
            'master'         => $master,
            'crewList'       => $crewList,
            'allowedItems'   => $allowedItems,
            'auditMap'       => $auditMap,
            'checklistItems' => $checklistItems,
            'token'          => $token
        );

        $this->load->view('Public/public_familiar_checklist', $data);
    }

    /**
     * Public API: Submit checklist from department
     */
    public function submit_checklist()
    {
        $token = $this->input->post('token', true);
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

        // Get allowed items for this department
        $allowedItems = array();
        foreach ($this->itemDepartmentMap as $item => $dept) {
            if ($dept === $link->department) {
                $allowedItems[] = $item;
            }
        }

        $this->db->trans_begin();

        $now = date('Y-m-d H:i:s');

        foreach ($allowedItems as $itemName) {
            $val = $this->input->post($itemName);
            if ($val !== false && $val !== null && $val !== '') {
                $itemValue = (int) $val;

                // Delete old audit for this item+batch+dept (replace mode)
                $this->db->where('batch_id', $link->batch_id)
                         ->where('item_name', $itemName)
                         ->where('department', $link->department)
                         ->delete('fam_checklist_audit');

                // Insert new audit
                $this->db->insert('fam_checklist_audit', array(
                    'batch_id'       => $link->batch_id,
                    'item_name'      => $itemName,
                    'item_value'     => $itemValue,
                    'department'     => $link->department,
                    'filled_by_name' => $filledByName,
                    'filled_at'      => $now
                ));

                // Update history_familiarization item value (semua crew dalam batch)
                $this->db->where('batch_id', $link->batch_id)
                         ->update('history_familiarization', array($itemName => $itemValue));
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(array('success' => false, 'message' => 'Gagal menyimpan checklist'));
        } else {
            $this->db->trans_commit();

            // --- Generate QR for the Submitted Department ---
            $crewRows = $this->db->where('batch_id', $link->batch_id)->get('history_familiarization')->result();

            // Map the department name to the specific qr column
            $deptColumnMap = array(
                'DPA'                  => 'qr_dpa', // or 'DPA / Marine Safety' depending on string
                'DPA / Marine Safety'  => 'qr_dpa',
                'Technical'            => 'qr_dept_technical',
                'Marine Safety'        => 'qr_dept_marinesafety',
                'Finance'              => 'qr_dept_finance',
                'Purchasing'           => 'qr_dept_purchasing',
                'QHSE'                 => 'qr_dept_qhse',
                'Operation'            => 'qr_dept_operation',
                'Crewing'              => 'qr_dept_crewing'
            );

            $deptName = $link->department;
            $qrCol = isset($deptColumnMap[$deptName]) ? $deptColumnMap[$deptName] : '';

            if (!empty($qrCol)) {
                foreach ($crewRows as $crew) {
                    if (empty($crew->$qrCol)) {
                        $qrFilename = $this->_generateQRRecord($crew->nama_crew, $filledByName, 'fam_dept_' . strtolower(str_replace(array('/', ' '), '', $deptName)));
                        if ($qrFilename) {
                            $this->db->where('id', $crew->id)->update('history_familiarization', array($qrCol => $qrFilename));
                        }
                    }
                }
            }

            echo json_encode(array('success' => true, 'message' => 'Checklist berhasil disimpan. Terima kasih!'));
        }
    }

    // ============================================================
    //  QR CODE & DB6 LOGIC (HELPER)
    // ============================================================

    private function _generateQRRecord($address, $createdBy, $prefix)
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
        $insSql["ket"]       = "Familiarization Check List Prior Joining Vessel";
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
