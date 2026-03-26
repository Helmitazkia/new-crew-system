<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Traning extends CI_Controller {

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

    private function _getRankOptionsArray()
    {
        $rows = $this->MCrewscv->getData("kdrank, nmrank", "mstrank", "deletests = '0' AND urutan > 0", "urutan ASC, nmrank ASC");
        $out = array(array("value" => "", "text" => "- Select -"));
        foreach ($rows as $r) {
            $out[] = array("value" => $r->kdrank, "text" => $r->nmrank);
        }
        return $out;
    }

    private function _getVesselOptionsArray()
    {
        $rows = $this->MCrewscv->getData("kdvsl, nmvsl", "mstvessel", "deletests = '0' AND st_display = 'Y'", "nmvsl ASC");
        $out = array(array("value" => "", "text" => "- Select -"));
        foreach ($rows as $r) {
            $out[] = array("value" => $r->kdvsl, "text" => $r->nmvsl);
        }
        return $out;
    }

    private function _getCertificateMatrixOptionsArray()
    {
        $sql = "SELECT id, rank_id, rank_name, certificate_name 
                  FROM mstcertificatematrix 
                 WHERE 1=1 
              ORDER BY rank_name ASC, certificate_name ASC";
        $rows = $this->db->query($sql)->result();
        $out = array();
        foreach ($rows as $r) {
           // $label = trim(($r->rank_name ? $r->rank_name . " - " : "") . $r->certificate_name);
           $label = $r->certificate_name;
            $out[] = array("value" => $r->id, "text" => $label);
        }
        
        return $out;
    }

    private function _getVendorOptionsArray()
    {
        $rows = $this->db->query("SELECT id_vendor, vendor_name FROM master_vendor_training WHERE deletests = '0' ORDER BY vendor_name ASC")->result();
        $out = array(array("value" => "", "text" => "- Select -"));
        foreach ($rows as $r) {
            $out[] = array("value" => $r->id_vendor, "text" => $r->vendor_name);
        }
        return $out;
    }

    public function index()
    {
        $data = array(
            "optionsRankJson" => json_encode($this->_getRankOptionsArray()),
            "optionsVesselJson" => json_encode($this->_getVesselOptionsArray()),
            "optionsVendorJson" => json_encode($this->_getVendorOptionsArray()),
            "optionsCertificateMatrixJson" => json_encode($this->_getCertificateMatrixOptionsArray()),
        );
        $this->load->view('CrewDetail/training', $data);
    }

    /**
     * GET: Load assessment & training data from mstpersonal by idperson.
     * Returns: scormarlintes, scorces, ismeval, ismdate, scor_psychometric, scor_otg
     */
    public function get_training()
    {
        $idperson = $this->input->get('idperson');
        if (empty($idperson)) {
            header('Content-Type: application/json');
            echo json_encode(array('success' => false, 'message' => 'idperson required'));
            return;
        }
        $sql = "SELECT scormarlintes, scorces, ismeval, ismdate, scor_psychometric, scor_otg
                FROM mstpersonal
                WHERE idperson = ? LIMIT 1";
        $row = $this->db->query($sql, array($idperson))->row_array();
        if (!$row) {
            header('Content-Type: application/json');
            echo json_encode(array('success' => true, 'data' => array(
                'scormarlintes' => '', 'scorces' => '', 'ismeval' => '', 'ismdate' => '',
                'scor_psychometric' => '', 'scor_otg' => ''
            )));
            return;
        }
        header('Content-Type: application/json');
        echo json_encode(array('success' => true, 'data' => $row));
    }

    /**
     * POST: Save/Update assessment & training in mstpersonal by idperson.
     * Fields: idperson, txtCesScore->scorces, txtmarlinTest->scormarlintes,
     * txtEvaluation->ismeval, txtDate_training->ismdate, scor_psychometric, scor_otg
     */
    public function save_training()
    {
        $idperson = $this->input->post('idperson');
        if (empty($idperson)) {
            header('Content-Type: application/json');
            echo json_encode(array('success' => false, 'message' => 'idperson required'));
            return;
        }
        $scorces           = $this->input->post('txtCesScore') !== null ? trim($this->input->post('txtCesScore')) : '';
        $scormarlintes     = $this->input->post('txtmarlinTest') !== null ? trim($this->input->post('txtmarlinTest')) : '';
        $ismeval           = $this->input->post('txtEvaluation') !== null ? trim($this->input->post('txtEvaluation')) : '';
        $ismdate           = $this->input->post('txtDate_training') !== null ? trim($this->input->post('txtDate_training')) : '';
        $scor_psychometric = $this->input->post('scor_psychometric') !== null ? trim($this->input->post('scor_psychometric')) : '';
        $scor_otg          = $this->input->post('scor_otg') !== null ? trim($this->input->post('scor_otg')) : '';

        $data = array(
            'scorces'           => substr($scorces, 0, 20),
            'scormarlintes'     => substr($scormarlintes, 0, 20),
            'ismeval'           => substr($ismeval, 0, 100),
            'ismdate'           => $ismdate !== '' ? $ismdate : null,
            'scor_psychometric' => substr($scor_psychometric, 0, 20),
            'scor_otg'          => substr($scor_otg, 0, 20)
        );

        $this->db->where('idperson', $idperson);
        $this->db->update('mstpersonal', $data);

        header('Content-Type: application/json');
        echo json_encode(array('success' => true, 'message' => 'Data saved successfully'));
    }

    /**
     * GET: List Training Crew by idperson (name from JOIN mstpersonal).
     */
    public function getAllData_crewtraining()
    {
        $idperson = $this->input->get('idperson');
        if (empty($idperson)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('success' => false, 'data' => array(), 'message' => 'idperson required'))
            );
            return;
        }
        $sql = "SELECT A.*, TRIM(CONCAT_WS(' ', P.fname, P.mname, P.lname)) AS name, D.nmvsl, R.nmrank AS rank_nm, V.vendor_name
            FROM tblcrewtraining A
            LEFT JOIN mstpersonal P ON P.idperson = A.idperson
            LEFT JOIN mstvessel D ON D.kdvsl = A.kdvsl AND D.deletests = '0'
            LEFT JOIN mstrank R ON R.kdrank = A.rank AND R.deletests = '0'
            LEFT JOIN master_vendor_training V ON V.id_vendor = A.vendor AND V.deletests = '0'
            WHERE A.deletests = '0' AND A.idperson = ?
            ORDER BY A.start_date_training DESC, A.idcrewtraining DESC";
        $rows = $this->db->query($sql, array($idperson))->result_array();
        $data = array();
        foreach ($rows as $row) {
            $data[] = array(
                'idcrewtraining' => $row['idcrewtraining'],
                'idperson' => $row['idperson'],
                'name' => isset($row['name']) ? $row['name'] : '',
                'rank' => isset($row['rank']) ? $row['rank'] : '',
                'rank_display' => isset($row['rank_nm']) ? $row['rank_nm'] : (isset($row['rank']) ? $row['rank'] : ''),
                'kdvsl' => isset($row['kdvsl']) ? $row['kdvsl'] : '',
                'vessel' => isset($row['nmvsl']) ? $row['nmvsl'] : '',
                'vendor' => isset($row['vendor']) ? $row['vendor'] : '',
                'vendor_name' => isset($row['vendor_name']) ? $row['vendor_name'] : '',
                'location' => isset($row['location']) ? $row['location'] : '',
                'file_traning' => isset($row['file_traning']) ? $row['file_traning'] : '',
                'total_training' => $row['total_training'],
                'start_date_training' => $row['start_date_training'],
                'end_date_training' => $row['end_date_training'],
                'finish_date_training' => $row['finish_date_training'],
                'status' => isset($row['status']) ? $row['status'] : '',
                'detail_training' => isset($row['detail_training']) ? $row['detail_training'] : '',
                'remarks' => isset($row['remarks']) ? $row['remarks'] : '',
            );
        }
        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('success' => true, 'data' => $data))
        );
    }

    public function get_crewtraining_by_id()
    {
        $idcrewtraining = $this->input->post('idcrewtraining');
        $idperson = $this->input->post('idperson');
        if (empty($idcrewtraining) || empty($idperson)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('success' => false, 'message' => 'idcrewtraining and idperson required'))
            );
            return;
        }
        $sql = "SELECT idcrewtraining, idperson, rank, kdvsl, vendor, location, file_traning, total_training,
                start_date_training, end_date_training, finish_date_training, status, detail_training, remarks
                FROM tblcrewtraining
                WHERE deletests = '0' AND idcrewtraining = ? AND idperson = ?";
        $row = $this->db->query($sql, array($idcrewtraining, $idperson))->row_array();
        if (!$row) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('success' => false, 'message' => 'Data not found'))
            );
            return;
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($row));
    }

    public function save_crewtraining()
    {
        $idperson = $this->input->post('idperson');
        if (empty($idperson)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'idperson required'))
            );
            return;
        }
        $this->db->select_max('idcrewtraining');
        $q = $this->db->get('tblcrewtraining');
        $r = $q->row();
        $newId = ($r && $r->idcrewtraining) ? (int)$r->idcrewtraining + 1 : 1;

        $rank = $this->input->post('rank') !== null ? trim($this->input->post('rank')) : '';
        $kdvsl = $this->input->post('kdvsl') !== null ? trim($this->input->post('kdvsl')) : '';
        $vendor = $this->input->post('vendor') !== null ? trim($this->input->post('vendor')) : '';
        $location = $this->input->post('location') !== null ? trim($this->input->post('location')) : '';
        $total_training = $this->input->post('total_training') !== null ? (int)$this->input->post('total_training') : null;
        $start_date_training = $this->input->post('start_date_training') ?: null;
        $end_date_training = $this->input->post('end_date_training') ?: null;
        $finish_date_training = $this->input->post('finish_date_training') ?: null;
        $status = $this->input->post('status') !== null ? trim($this->input->post('status')) : '';
        $detail_training = $this->input->post('detail_training') !== null ? trim($this->input->post('detail_training')) : '';
        $remarks = $this->input->post('remarks') !== null ? trim($this->input->post('remarks')) : '';

        if ($start_date_training === '') $start_date_training = null;
        if ($end_date_training === '') $end_date_training = null;
        if ($finish_date_training === '') $finish_date_training = null;

        $file_traning = null;
        if (isset($_FILES['file_traning']['name']) && $_FILES['file_traning']['name'] != '') {
            $config['upload_path'] = './uploadFile/';
            $config['allowed_types'] = '*';
            $config['max_size'] = 10240;
            $config['file_name'] = 'training_' . $idperson . '_' . time();
            
            $CI =& get_instance();
            $CI->load->library('upload', $config);
            if (!isset($CI->upload)) {
                require_once BASEPATH . 'libraries/Upload.php';
                $CI->upload = new CI_Upload($config);
            }
            $CI->upload->initialize($config);
            
            if (!is_dir('./uploadFile/')) { mkdir('./uploadFile/', 0777, true); }
            if ($CI->upload->do_upload('file_traning')) {
                $uploadData = $CI->upload->data();
                $file_traning = $uploadData['file_name'];
            }
        }

        $data = array(
            'idcrewtraining' => $newId,
            'idperson' => $idperson,
            'rank' => substr($rank, 0, 50),
            'kdvsl' => substr($kdvsl, 0, 20),
            'vendor' => $vendor !== '' ? (int)$vendor : null,
            'location' => substr($location, 0, 255),
            'file_traning' => $file_traning,
            'total_training' => $total_training,
            'start_date_training' => $start_date_training,
            'end_date_training' => $end_date_training,
            'finish_date_training' => $finish_date_training,
            'status' => substr($status, 0, 20),
            'detail_training' => substr($detail_training, 0, 500),
            'remarks' => substr($remarks, 0, 500),
            'deletests' => '0',
        );
        $this->db->insert('tblcrewtraining', $data);
        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('status' => true, 'message' => 'Data saved successfully'))
        );
    }

    public function update_crewtraining()
    {
        $idcrewtraining = $this->input->post('idcrewtraining');
        $idperson = $this->input->post('idperson');
        if (empty($idcrewtraining) || empty($idperson)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'idcrewtraining and idperson required'))
            );
            return;
        }
        $rank = $this->input->post('rank') !== null ? trim($this->input->post('rank')) : '';
        $kdvsl = $this->input->post('kdvsl') !== null ? trim($this->input->post('kdvsl')) : '';
        $vendor = $this->input->post('vendor') !== null ? trim($this->input->post('vendor')) : '';
        $location = $this->input->post('location') !== null ? trim($this->input->post('location')) : '';
        $total_training = $this->input->post('total_training') !== null ? (int)$this->input->post('total_training') : null;
        $start_date_training = $this->input->post('start_date_training') ?: null;
        $end_date_training = $this->input->post('end_date_training') ?: null;
        $finish_date_training = $this->input->post('finish_date_training') ?: null;
        $status = $this->input->post('status') !== null ? trim($this->input->post('status')) : '';
        $detail_training = $this->input->post('detail_training') !== null ? trim($this->input->post('detail_training')) : '';
        $remarks = $this->input->post('remarks') !== null ? trim($this->input->post('remarks')) : '';

        if ($start_date_training === '') $start_date_training = null;
        if ($end_date_training === '') $end_date_training = null;
        if ($finish_date_training === '') $finish_date_training = null;

        $data = array(
            'rank' => substr($rank, 0, 50),
            'kdvsl' => substr($kdvsl, 0, 20),
            'vendor' => $vendor !== '' ? (int)$vendor : null,
            'location' => substr($location, 0, 255),
            'total_training' => $total_training,
            'start_date_training' => $start_date_training,
            'end_date_training' => $end_date_training,
            'finish_date_training' => $finish_date_training,
            'status' => substr($status, 0, 20),
            'detail_training' => substr($detail_training, 0, 500),
            'remarks' => substr($remarks, 0, 500),
        );

        if (isset($_FILES['file_traning']['name']) && $_FILES['file_traning']['name'] != '') {
            $config['upload_path'] = './uploadFile/';
            $config['allowed_types'] = '*';
            $config['max_size'] = 10240;
            $config['file_name'] = 'training_' . $idperson . '_' . time();
            
            $CI =& get_instance();
            $CI->load->library('upload', $config);
            if (!isset($CI->upload)) {
                require_once BASEPATH . 'libraries/Upload.php';
                $CI->upload = new CI_Upload($config);
            }
            $CI->upload->initialize($config);

            if (!is_dir('./uploadFile/')) { mkdir('./uploadFile/', 0777, true); }
            if ($CI->upload->do_upload('file_traning')) {
                $uploadData = $CI->upload->data();
                $data['file_traning'] = $uploadData['file_name'];
            }
        }

        $this->db->where('idcrewtraining', $idcrewtraining);
        $this->db->where('idperson', $idperson);
        $this->db->update('tblcrewtraining', $data);
        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('status' => true, 'message' => 'Data updated successfully'))
        );
    }

    public function delete_crewtraining()
    {
        $idcrewtraining = $this->input->post('idcrewtraining');
        if (empty($idcrewtraining)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'idcrewtraining required'))
            );
            return;
        }
        $this->db->where('idcrewtraining', $idcrewtraining);
        $this->db->update('tblcrewtraining', array('deletests' => '1'));
        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('status' => true, 'message' => 'Data deleted successfully'))
        );
    }

    public function get_training_matrix()
    {
        $idperson = $this->input->get('idperson');
        if (empty($idperson)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('success' => false, 'data' => array(), 'message' => 'idperson required'))
            );
            return;
        }
        $sql = "SELECT A.idcrewtraining_matrix, A.idperson, A.cert_matrix_id,
                       A.completed, A.remarks, B.rank_id, B.rank_name, B.certificate_name
                  FROM tblcrewtraining_matrix A
                  LEFT JOIN mstcertificatematrix B ON B.id = A.cert_matrix_id
                 WHERE A.deletests = 0 AND A.idperson = ?
                 ORDER BY B.rank_name ASC, B.certificate_name ASC, A.idcrewtraining_matrix ASC";
        $rows = $this->db->query($sql, array($idperson))->result_array();
        $data = array();
        foreach ($rows as $row) {
            $data[] = array(
                'idcrewtraining_matrix' => $row['idcrewtraining_matrix'],
                'idperson' => $row['idperson'],
                'cert_matrix_id' => $row['cert_matrix_id'],
                'rank_name' => isset($row['rank_name']) ? $row['rank_name'] : '',
                'training_name' => isset($row['certificate_name']) ? $row['certificate_name'] : '',
                'completed' => (int)$row['completed'],
                'remarks' => isset($row['remarks']) ? $row['remarks'] : '',
            );
        }
        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('success' => true, 'data' => $data))
        );
    }

    public function get_training_matrix_by_id()
    {
        $id = $this->input->post('idcrewtraining_matrix');
        $idperson = $this->input->post('idperson');
        if (empty($id) || empty($idperson)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('success' => false, 'message' => 'idcrewtraining_matrix and idperson required'))
            );
            return;
        }
        $sql = "SELECT idcrewtraining_matrix, idperson, cert_matrix_id, completed, remarks
                  FROM tblcrewtraining_matrix
                 WHERE deletests = 0 AND idcrewtraining_matrix = ? AND idperson = ?";
        $row = $this->db->query($sql, array($id, $idperson))->row_array();
        if (!$row) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('success' => false, 'message' => 'Data not found'))
            );
            return;
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($row));
    }

    public function save_training_matrix()
    {
        $idperson = $this->input->post('idperson');
        $cert_matrix_id = $this->input->post('cert_matrix_id');
        if (empty($idperson) || empty($cert_matrix_id)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'idperson and cert_matrix_id required'))
            );
            return;
        }
        $completed = $this->input->post('completed') ? 1 : 0;
        $remarks = $this->input->post('remarks') !== null ? trim($this->input->post('remarks')) : '';

        $username = $this->session->userdata("userName") ?: "system";
        $currentDate = date("Ymd/H:i:s");

        $data = array(
            'idperson' => $idperson,
            'cert_matrix_id' => (int)$cert_matrix_id,
            'completed' => $completed,
            'remarks' => substr($remarks, 0, 500) ?: null,
            'deletests' => 0,
            'addusrdt' => $username . "/" . $currentDate,
        );
        $this->db->insert('tblcrewtraining_matrix', $data);
        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('status' => true, 'message' => 'Training added successfully'))
        );
    }

    public function update_training_matrix()
    {
        $id = $this->input->post('idcrewtraining_matrix');
        $idperson = $this->input->post('idperson');
        if (empty($id) || empty($idperson)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'idcrewtraining_matrix and idperson required'))
            );
            return;
        }
        $completed = $this->input->post('completed') ? 1 : 0;
        $remarks = $this->input->post('remarks') !== null ? trim($this->input->post('remarks')) : '';
        $cert_matrix_id = $this->input->post('cert_matrix_id');

        $username = $this->session->userdata("userName") ?: "system";
        $currentDate = date("Ymd/H:i:s");

        $data = array(
            'completed' => $completed,
            'cert_matrix_id' => (int)$cert_matrix_id,
            'remarks' => substr($remarks, 0, 500) ?: null,
            'updusrdt' => $username . "/" . $currentDate,
        );
        $this->db->where('idcrewtraining_matrix', $id);
        $this->db->where('idperson', $idperson);
        $this->db->update('tblcrewtraining_matrix', $data);
        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('status' => true, 'message' => 'Training updated successfully'))
        );
    }

    public function update_training_completed()
    {
        $id = $this->input->post('idcrewtraining_matrix');
        $completed = $this->input->post('completed');
        if (empty($id)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'idcrewtraining_matrix required'))
            );
            return;
        }
        $completedVal = ($completed == 1 || $completed === '1') ? 1 : 0;
        $this->db->where('idcrewtraining_matrix', $id);
        $this->db->update('tblcrewtraining_matrix', array('completed' => $completedVal));
        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('status' => true, 'message' => 'Completed updated'))
        );
    }

    public function delete_training_matrix()
    {
        $id = $this->input->post('idcrewtraining_matrix');
        if (empty($id)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'idcrewtraining_matrix required'))
            );
            return;
        }
        $this->db->where('idcrewtraining_matrix', $id);
        $this->db->update('tblcrewtraining_matrix', array('deletests' => 1));
        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('status' => true, 'message' => 'Training deleted successfully'))
        );
    }

}
?>