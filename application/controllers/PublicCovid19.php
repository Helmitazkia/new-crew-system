<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicCovid19 extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Load required models and libraries
        $this->load->model('MCrewscv');
    }

    public function form($token = '')
    {
        if (empty($token)) {
            show_404();
            return;
        }

        $this->db->where('link_token', $token);
        $report = $this->db->get('report_covid19')->row();

        if (empty($report)) {
            show_404();
            return;
        }

        $data['report'] = $report;
        $data['token']  = $token;

        $this->load->view('Public/public_covid_19', $data);
    }

    public function submit_form()
    {
        $token = $this->input->post('token', true);
        if (empty($token)) {
            echo json_encode(array('success' => false, 'message' => 'Token tidak valid!'));
            return;
        }

        $this->db->where('link_token', $token);
        $report = $this->db->get('report_covid19')->row();

        if (empty($report)) {
            echo json_encode(array('success' => false, 'message' => 'Data tidak ditemukan!'));
            return;
        }

        // Generate QR Code menggunakan batchno (tblEmpNoSurat db6)
        $imgName = $this->_generateQRRecord($report->fullname, $report->fullname, 'COVID19');

        // Update database
        $update_data = array(
            'sign_on' => $imgName
        );
        $this->db->where('id', $report->id);
        $this->db->update('report_covid19', $update_data);

        echo json_encode(array('success' => true, 'message' => 'Tanda tangan berhasil disubmit.'));
    }

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
        $insSql["ket"]       = "COVID-19 Prevention & Stay Healthy Protocol";
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
            'savename' => FCPATH . 'assets/imgQRCodeCrewCV/' . $imgName,
            'logo'     => './assets/img/andhika.png'
        );

        $this->ciqrcode->generate($params);

        return $imgName;
    }
}
