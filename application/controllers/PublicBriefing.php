<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicBriefing extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MCrewscv');
    }

    public function form($token = '')
    {
        if (empty($token)) {
            show_404();
            return;
        }

        $this->db->where('link_token', $token);
        $history = $this->db->get('history_briefing')->row();

        if (empty($history)) {
            show_404();
            return;
        }

        // Parse existing checklist data if any
        $checklist_items = array();
        if (!empty($history->checklist_data)) {
            $checklist_items = explode(',', $history->checklist_data);
        }

        $data['history'] = $history;
        $data['checklist_items'] = $checklist_items;
        $data['token'] = $token;

        $this->load->view('Public/form_briefing_crew', $data);
    }

    public function submit_form()
    {
        $token = $this->input->post('token', true);
        if (empty($token)) {
            echo json_encode(array('success' => false, 'message' => 'Token tidak valid!'));
            return;
        }

        $this->db->where('link_token', $token);
        $history = $this->db->get('history_briefing')->row();

        if (empty($history)) {
            echo json_encode(array('success' => false, 'message' => 'Data tidak ditemukan!'));
            return;
        }

        // Get checklist
        $self = $this;
        $getItem = function($field) use ($self) {
            $val = $self->input->post($field);
            return ($val !== false && $val !== null && $val !== '') ? (int)$val : null;
        };

        $checklist_arr = array();
        for ($i = 1; $i <= 54; $i++) {
            $val = $getItem('item_' . $i);
            $checklist_arr[] = ($val !== null) ? $val : '';
        }
        $checklist_data = implode(',', $checklist_arr);

        // ==== Generate QR Code ====

                
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
        $insSql["address"] = $history->nama_crew;
        $insSql["tglsurat"] = $dateNow;
        $insSql["ket"] = "Briefing Check List Prior Joining Vessel";
        $insSql["copydoc"] = "0";
        $insSql["canceldoc"] = "0";
        $insSql["createdby"] = "Eva Marliana (Crew Manager)";
        $this->MCrewscv->insDataDb6($insSql,"tblEmpNoSurat");


        $qrImg = $this->_createQRCode($batchno, 'briefing');

        // Kembalikan koneksi ke database default
        $this->db = $this->load->database('default', TRUE);

        // Data to update
        $data_update = array(
            'checklist_data' => $checklist_data,
            'is_submitted' => 1,
            'signature_qr' => $qrImg
        );

        $this->db->where('id', $history->id);
        $update = $this->db->update('history_briefing', $data_update);

        if ($update) {
            echo json_encode(array('success' => true, 'message' => 'Berhasil mensubmit form Briefing. Terima kasih.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal mensubmit form.'));
        }
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

    private function _createQRCode($id, $type = 'briefing')
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
