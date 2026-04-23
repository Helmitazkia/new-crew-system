<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Covid19 extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MCrewscv');
        $this->load->library('../controllers/DataContext');
        $this->load->library('session');

        if (!$this->session->userdata('isLogin')) {
            redirect('auth/login');
            exit;
        }
    }

    public function view()
    {
        $this->load->view('ListReport/Covid19/view_covid19');
    }

    public function get_data_form_covid19()
    {
        $idperson = $this->input->post("idperson", true);
        
        $sql = "
            SELECT 
                CONCAT_WS(' ', A.fname, A.mname, A.lname) AS fullname,
                B.signondt,
                C.nmrank,
                D.nmvsl
            FROM mstpersonal A
            LEFT JOIN tblcontract B ON A.idperson = B.idperson
            LEFT JOIN mstrank C ON B.signonrank = C.kdrank
            LEFT JOIN mstvessel D ON B.signonvsl = D.kdvsl
            WHERE 1=1
                AND B.idperson = '$idperson'
            ORDER BY B.signondt DESC
            LIMIT 1
        ";

        $data = $this->MCrewscv->getDataQuery($sql);
        $result = array();

        if (!empty($data)) {
            foreach ($data as $row) {
                $result[] = array(
                    'fullname' => isset($row->fullname) ? $row->fullname : '',
                    'sign_on'  => isset($row->signondt) ? $row->signondt : '',
                    'nmrank'   => isset($row->nmrank) ? $row->nmrank : '',
                    'nmvsl'    => isset($row->nmvsl) ? $row->nmvsl : ''
                );
            }
        }

        echo json_encode(array(
            'success' => !empty($result),
            'data'    => $result
        ));
    }

    public function save_covid19()
    {
        $data = array(
            'id_person'    => $this->input->post('idperson'),
            'fullname'     => $this->input->post('fullname'),
            'rankname'     => $this->input->post('nmrank'),
            'vessel_name'  => $this->input->post('nmvsl'),
            'sign_on'      => $this->input->post('sign_on'),
            'created_at'   => date('Y-m-d H:i:s')
        );

        $this->db->trans_begin();
        $this->db->insert('report_covid19', $data);
        $insert_id = $this->db->insert_id();
        
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(array(
                'success' => false,
                'message' => 'Gagal menyimpan data Covid 19 Prevention'
            ));
        } else {
            $this->db->trans_commit();
            echo json_encode(array(
                'success' => true,
                'message' => 'Data Covid 19 Prevention berhasil disimpan',
                'id_report' => $insert_id
            ));
        }
    }

    public function get_report_covid19()
    {
        $idperson = $this->input->post('idperson', true);

        $sql = "SELECT * FROM report_covid19 WHERE 1=1 ";
        if (!empty($idperson)) {
            $sql .= " AND id_person = '{$idperson}'";
        }
        $sql .= " ORDER BY id DESC";

        $data = $this->MCrewscv->getDataQuery($sql);
        
        echo json_encode(array(
            'success' => true,
            'data'    => !empty($data) ? $data : array()
        ));
    }

    public function get_report_covid19_detail()
    {
        $id = $this->input->post('id_report', true);
        if (empty($id)) {
            echo json_encode(array('success' => false, 'message' => 'Invalid ID'));
            return;
        }

        $report = $this->db->where('id', $id)->get('report_covid19')->row();
        if (!$report) {
            echo json_encode(array('success' => false, 'message' => 'Data tidak ditemukan'));
            return;
        }

        echo json_encode(array(
            'success' => true,
            'data' => $report
        ));
    }

    public function delete_report_covid19()
    {
        $id = $this->input->post('id');

        if (empty($id)) {
            echo json_encode(array('success' => false, 'message' => 'ID tidak valid'));
            exit;
        }

        $this->db->trans_begin();
        $this->db->where('id', $id);
        $this->db->delete('report_covid19');

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(array('success' => false, 'message' => 'Gagal menghapus data Covid 19 Prevention'));
        } else {
            $this->db->trans_commit();
            echo json_encode(array('success' => true, 'message' => 'Data berhasil dihapus'));
        }
        exit;
    }

    public function print_covid19_pdf()
    {
        $id = $this->input->post('id_report_covid19');

        if (empty($id)) {
            show_error('Invalid Covid19 Report ID');
        }

        $crew = $this->db->where('id', $id)->get('report_covid19')->row();
        if (!$crew) {
            show_error('Data Covid 19 Prevention tidak ditemukan');
        }

        $data = array(
            'crew'  => $crew,
            'today' => date('d M Y', strtotime($crew->created_at))
        );

        require(APPPATH . "views/frontend/pdf/mpdf60/mpdf.php");
        $mpdf = new mPDF('utf-8', 'A4');

        $html = $this->load->view('ListReport/Covid19/form_covid_pdf', $data, TRUE);
        $mpdf->WriteHTML($html);

        $mpdf->Output("Covid19_Prevention_{$crew->fullname}.pdf", 'I');
        exit;
    }
}
