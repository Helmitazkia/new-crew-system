<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compotents extends CI_Controller {

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

    private function _getCertificateMatrixOptionsArray()
    {
        $sql = "SELECT id, rank_id, rank_name, certificate_name 
                  FROM mstcertificatematrix 
                 WHERE 1=1 
              ORDER BY rank_name ASC, certificate_name ASC";
        $rows = $this->db->query($sql)->result();
        $out = array();
        foreach ($rows as $r) {
           $label = $r->certificate_name;
            $out[] = array("value" => $r->id, "text" => $label);
        }
        
        return $out;
    }

    public function index()
    {
        $dataContext = new DataContext();

        $data = array(
            "optionsCertificateMatrixJson" => json_encode($this->_getCertificateMatrixOptionsArray()),
        );
        $this->load->view('CrewDetail/compotenst', $data);
    }

    // ---------------------------------------------------------
    // LEFT SIDE: CERTIFICATES (VIEW ONLY)
    // ---------------------------------------------------------
    public function get_certificates()
    {
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
                'certificate_file' => $row['certificate_file'],
                'expiry_date'      => $row['expdate'] != "0000-00-00"
                                      ? date("d M Y", strtotime($row['expdate']))
                                      : '',
                'expiry_raw'       => $row['expdate'],
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


    // ---------------------------------------------------------
    // RIGHT SIDE: PLANNED TRAINING (CRUD)
    // ---------------------------------------------------------
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
