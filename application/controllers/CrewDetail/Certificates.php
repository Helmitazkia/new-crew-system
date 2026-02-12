<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificates extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->model('MCrewscv');
        $this->load->library('../controllers/DataContext');
        $this->load->library('session');
        $allowed_methods = array('do_login');
        $current_method = $this->router->fetch_method();
        if (
            !in_array($current_method, $allowed_methods) &&
            !$this->session->userdata('isLogin')
        ) {
            redirect('auth/login');
            exit;
        }
    }

 public function index()
{
    $dataContext = new DataContext();

    $data = array(
        'title'      => 'Active Roster',
        'optMstCert' => $dataContext->getMstCertificateByOption("","nama"),
        'optRank'    => $dataContext->getMstRankByOptionWithSelected("",""),
        'optCountry' => $dataContext->getCountryByOption("","kode"),
        'optType'    => $dataContext->getMstVesselTypeByOptionWithSelected("","")
    );

    $this->load->view('CrewDetail/certificates', $data);
}



public function getAllData_certificates()
{
    $dataContext = new DataContext();
    $idperson = $this->input->get('idperson');

    $sql = "
        SELECT
            idcertdoc,
            certname,
            expdate,
            display,
            certificate_file
        FROM tblcertdoc
        WHERE idperson = ?
        AND deletests = '0'
        ORDER BY expdate ASC
    ";

    $rows = $this->db->query($sql, array($idperson))->result_array();

    $data = array();
    foreach ($rows as $row) {

        $data[] = array(
            'certificate_name' => $row['certname'],
            'certificate_file' => $row['certificate_file'], // tambah ini
            'expiry_date'      => $row['expdate'] != "0000-00-00"
                                  ? date("d M Y", strtotime($row['expdate']))
                                  : '',
            'expiry_raw'       => $row['expdate'], // optional buat validasi warna
            'display'          => $row['display'],
            'idcertdoc'        => $row['idcertdoc']
        );
    }

    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(array(
            'success' => true,
            'data'    => $data
        )));
}

public function save_certificate()
{
    $dataContext = new DataContext();

    $idPerson = $this->input->post('idperson');
    $username = $this->session->userdata('userName') ?: 'system';
    $currentDate = date('Ymd/H:i:s');
    $data = array(
        'idperson'   => $idPerson,
        'certname'   => $this->input->post('certname'),
        'dispname'   => $this->input->post('dispname'),
        'license'    => $this->input->post('license'),
        'level'      => $this->input->post('level'),
        'nmrank'     => $this->input->post('nmrank'),
        'vsltype'    => $this->input->post('vsltype'),
        'docno'      => $this->input->post('docno'),
        'issdate'    => $this->input->post('issdate'),
        'expdate'    => $this->input->post('expdate'),
        'issplace'   => $this->input->post('issplace'),
        'issauth'    => $this->input->post('issauth'),
        'remarks'    => $this->input->post('remarks'),
        'display'    => $this->input->post('display'),
        'deletests'  => 0,
        'addusrdt'   => $username . '/' . $currentDate
    );

    // var_dump($data);exit;

    $this->db->insert('tblcertdoc', $data);
    $idEdit = $this->db->insert_id();

    // ==========================
    // UPLOAD FILE
    // ==========================
    if (!empty($_FILES['certificate_file']['name'])) {

        $dir = FCPATH . "uploadCertificate/";

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $fileName    = $_FILES["certificate_file"]["name"];
        $newFileName = "certificateDoc_" . $idPerson . "_" . $idEdit;

        $fileUploadNya = $dataContext->uploadFile(
            $_FILES["certificate_file"]['tmp_name'],
            $dir,
            $fileName,
            $newFileName
        );

        if ($fileUploadNya != "") {
            $this->db->where('idcertdoc', $idEdit);
            $this->db->update('tblcertdoc', array(
                'certificate_file' => $fileUploadNya
            ));
        }
    }

    echo json_encode(array(
        'status'  => true,
        'message' => 'Data saved successfully'
    ));
}

public function get_by_id()
{
    $id = $this->input->post('id');

    $this->db->where('idcertdoc', $id);
    $query = $this->db->get('tblcertdoc');

    if ($query->num_rows() > 0) {

        $row = $query->row_array();

        echo json_encode(array(
            'success' => true,
            'data'    => $row
        ));

    } else {

        echo json_encode(array(
            'success' => false,
            'message' => 'Data not found'
        ));

    }
}


public function update_certificate()
{
    $dataContext = new DataContext();
    
    $idEdit = $this->input->post('idcertdoc'); // ID dokumen yang diedit
    $idPerson = $this->input->post('idperson');
    $username = $this->session->userdata('userName') ?: 'system';
    $currentDate = date('Ymd/H:i:s');

    // 1. Siapkan data update (Gunakan 'updusrdt' sesuai format permintaan Anda)
    $data = array(
        'idperson'   => $idPerson,
        'certname'   => $this->input->post('certname'),
        'dispname'   => $this->input->post('dispname'),
        'license'    => $this->input->post('license'),
        'level'      => $this->input->post('level'),
        'nmrank'     => $this->input->post('nmrank'),
        'vsltype'    => $this->input->post('vsltype'),
        'docno'      => $this->input->post('docno'),
        'issdate'    => $this->input->post('issdate'),
        'expdate'    => $this->input->post('expdate'),
        'issplace'   => $this->input->post('issplace'),
        'issauth'    => $this->input->post('issauth'),
        'remarks'    => $this->input->post('remarks'),
        'display'    => $this->input->post('display'),
        'updusrdt'   => $username . '/' . $currentDate
    );

    // 2. Jalankan update text data dulu
    $this->db->where('idcertdoc', $idEdit);
    $this->db->update('tblcertdoc', $data);

    // 3. Cek apakah ada file baru yang diupload
    if (!empty($_FILES['certificate_file']['name'])) {
        
        $dir = FCPATH . "uploadCertificate/";

        // --- PROSES HAPUS FILE LAMA ---
        // Ambil nama file lama dari database berdasarkan ID
        $oldFile = $this->db->get_where('tblcertdoc', array('idcertdoc' => $idEdit))->row();
        
        if ($oldFile && !empty($oldFile->certificate_file)) {
            $pathFileLama = $dir . $oldFile->certificate_file;
            if (file_exists($pathFileLama)) {
                unlink($pathFileLama); // Menghapus file fisik di folder
            }
        }

        // --- PROSES UPLOAD FILE BARU ---
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $fileName    = $_FILES["certificate_file"]["name"];
        $newFileName = "certificateDoc_" . $idPerson . "_" . $idEdit;

        $fileUploadNya = $dataContext->uploadFile(
            $_FILES["certificate_file"]['tmp_name'],
            $dir,
            $fileName,
            $newFileName
        );

        if ($fileUploadNya != "") {
            $this->db->where('idcertdoc', $idEdit);
            $this->db->update('tblcertdoc', array(
                'certificate_file' => $fileUploadNya
            ));
        }
    }

    echo json_encode(array(
        'status'  => true,
        'message' => 'Data updated successfully'
    ));
}


public function delete_certificate()
{
    $id = $this->input->post('idcertdoc');
    $username = $this->session->userdata('userName') ?: 'system';
    $currentDate = date('Ymd/H:i:s');
    $data = array(
        'deletests' => 1,
        'delusrdt'  => $username . '/' . $currentDate
    );

    $this->db->where('idcertdoc', $id);
    $this->db->update('tblcertdoc', $data);

    echo json_encode(array(
        'status' => true,
        'message' => 'Data deleted successfully'
    ));
}




}
?>