<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ListReport extends CI_Controller {

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
        $this->load->view('CrewDetail/list_report');
    }

    // ============================================================
    // MCU MODULE — View & AJAX Endpoints
    // ============================================================

    /**
     * Load MCU sub-view (dipanggil AJAX dari list_report.php sidebar)
     */
    public function view_mcu()
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
            WHERE a.deletes = '0'
        ";

        // Filter by idperson if provided
        if (!empty($idperson)) {
            $sql .= " AND a.id IN (
                SELECT id_report_mcu FROM report_mcu_person WHERE id_person = " . $this->db->escape($idperson) . "
            )";
        }

        $sql .= " ORDER BY a.id DESC";

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

        if (empty($id_report)) {
            echo json_encode(array('success' => false, 'message' => 'ID Report MCU tidak ditemukan'));
            return;
        }

        $report = $this->_getReportDetail($id_report);

        if (!$report) {
            echo json_encode(array('success' => false, 'message' => 'Data MCU tidak ditemukan'));
            return;
        }

        $persons = $this->_getPersonsByReport($id_report);

        echo json_encode(array(
            'success' => true,
            'data'    => array(
                'report'  => $report,
                'persons' => $persons
            )
        ));
    }

    /**
     * Soft delete MCU
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

        $mcuObj = new stdClass();
        for ($i = 0; $i < 11; $i++) {
            $prop = 'mcu' . ($i + 1);
            $mcuObj->$prop = isset($mcu[$i]) ? $mcu[$i] : 0;
        }

        $data = array(
            'persons'        => $persons,
            'mcu'            => $mcuObj,
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
    // PRIVATE HELPERS
    // ============================================================

    private function _getReportDetail($id_report)
    {
        $sql = "
            SELECT 
                a.id AS id_report,
                b.clinic_name, b.address_clinic, b.telp, b.fax,
                a.date_mcu,
                c.header_mcu,
                c.answer_1, c.answer_2, c.answer_3, c.answer_4, c.answer_5,
                c.answer_6, c.answer_7, c.answer_8, c.answer_9, c.answer_10, c.answer_11,
                a.status_mcu, a.signature_qr
            FROM report_mcu AS a
            INNER JOIN master_mcu AS b ON a.id_master_mcu = b.id
            INNER JOIN report_answer_mcu AS c ON a.id = c.id_report_mcu
            WHERE a.deletes = '0' AND a.id = ?
            LIMIT 1
        ";

        return $this->db->query($sql, array($id_report))->row();
    }

    private function _getPersonsByReport($id_report)
    {
        $sql = "
            SELECT id, id_report_mcu, id_person, name_person, rank, vessel_name
            FROM report_mcu_person
            WHERE id_report_mcu = ?
            ORDER BY id ASC
        ";

        return $this->db->query($sql, array($id_report))->result();
    }
}
?>
