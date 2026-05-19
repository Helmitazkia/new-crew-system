<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Spj extends CI_Controller {

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
        $this->load->view('ListReport/Spj/view_spj');
    }

    public function get_report_spj()
    {
        $idperson = $this->input->post('idperson', true);
        $sql = "
            SELECT 
                id, idperson, name, rank, destination, purpose, depart_date, 
                created_at, deletests
            FROM spj
            WHERE deletests = '0' 
              AND idperson = " . $this->db->escape($idperson) . "
            ORDER BY id DESC
        ";
        $data = $this->MCrewscv->getDataQuery($sql);
        $result = array();
        if (!empty($data)) {
            foreach ($data as $row) {
                $row->depart_date = !empty($row->depart_date) ? date('d M Y', strtotime($row->depart_date)) : '';
                $row->created_at = !empty($row->created_at) ? date('d M Y H:i:s', strtotime($row->created_at)) : '';
                $result[] = $row;
            }
        }
        echo json_encode(array('success' => !empty($result), 'data' => $result));
    }

    public function get_report_spj_detail()
    {
        $id_report = $this->input->post('id_report', true);
        $sql = "SELECT * FROM spj WHERE id = ? AND deletests = '0' LIMIT 1";
        $report = $this->db->query($sql, array($id_report))->row();
        
        if (!$report) {
            echo json_encode(array('success' => false, 'message' => 'Data SPJ tidak ditemukan'));
            return;
        }
        
        $sqlAccompany = "SELECT name, rank FROM spj_accompany WHERE spj_id = ? AND deletests = '0'";
        $persons = $this->db->query($sqlAccompany, array($id_report))->result();
        
        echo json_encode(array('success' => true, 'data' => array('report' => $report, 'persons' => $persons)));
    }

    public function delete_list_spj()
    {
        $id_report = $this->input->post('id_report', true);
        if (empty($id_report)) {
            echo json_encode(array('success' => false, 'message' => 'ID SPJ tidak ditemukan'));
            return;
        }
        $this->db->where('id', $id_report);
        $this->db->update('spj', array('deletests' => 1));
        
        // Also delete accompany
        $this->db->where('spj_id', $id_report);
        $this->db->update('spj_accompany', array('deletests' => 1));

        echo json_encode(array('success' => true, 'message' => 'Data SPJ berhasil dihapus'));
    }

    public function get_crew_by_name()
    {
        $keyword = $this->input->post('keyword', true);
        $keyword = $this->db->escape_like_str($keyword);
        $sql = "
            SELECT 
                A.idperson,
                CONCAT_WS(' ', A.fname, A.mname, A.lname) AS nama_crew,
                A.applyfor
            FROM mstpersonal A
            WHERE 
                A.fname LIKE '%$keyword%'
                OR A.mname LIKE '%$keyword%'
                OR A.lname LIKE '%$keyword%'
            ORDER BY A.fname ASC
            LIMIT 20
        ";
        $data = $this->MCrewscv->getDataQuery($sql);
        $result = array();
        if (!empty($data)) {
            foreach ($data as $row) {
                $result[] = array(
                    'idperson'  => $row->idperson,
                    'nama_crew' => $row->nama_crew,
                    'jabatan'   => $row->applyfor
                );
            }
        }
        echo json_encode(array('success' => !empty($result), 'data' => $result));
    }

    public function get_crew_info_by_idperson()
    {
        $idperson = $this->input->post('idperson', true);
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
        if ($data && empty($data->jabatan)) {
            $sqlFallback = "SELECT CONCAT_WS(' ', fname, mname, lname) AS nama_crew, applyfor AS jabatan FROM mstpersonal WHERE idperson = ? LIMIT 1";
            $dataFallback = $this->db->query($sqlFallback, array($idperson))->row();
            if ($dataFallback) {
                if (empty($data->jabatan)) $data->jabatan = $dataFallback->jabatan;
            }
        }
        echo json_encode(array('success' => !empty($data), 'data' => $data));
    }

        function getSpj($id = "")
    {
        if ($id == "") {
            echo json_encode(array('success' => false, 'message' => 'ID SPJ tidak ditemukan.'));
            return;
        }

        $sql = "
            SELECT 
                s.id,
                s.idperson,
                s.base_on,
                s.name,
                s.rank,
                s.destination,
                s.purpose,
                s.depart_date,
                s.arrival_date,
                s.transportation,
                s.note,
                s.created_at,
                s.updated_at,
                mp.fname,
                mp.mname,
                mp.lname,
                v.nmvsl AS vessel_name,
                ccmp.nmcmp AS company_name,
                v2.nmvsl AS contract_vessel_name
            FROM spj s
            LEFT JOIN mstpersonal mp ON mp.idperson = s.idperson
            LEFT JOIN mstvessel v ON TRIM(v.nmvsl) = TRIM(s.destination)
            LEFT JOIN mstcmprec ccmp ON ccmp.kdcmp = v.kdcmp
            LEFT JOIN tblcontract tc ON tc.idperson = s.idperson AND tc.deletests = '0'
            LEFT JOIN mstvessel v2 ON v2.kdvsl = tc.signonvsl AND v2.deletests = '0'
            WHERE s.id = '".$id."' AND s.deletests = '0'
            ORDER BY tc.signondt DESC, tc.idcontract DESC
            LIMIT 1
        ";

        $crewData = $this->MCrewscv->getDataQuery($sql);
        if (empty($crewData)) {
            echo json_encode(array('success' => false, 'message' => 'Data SPJ tidak ditemukan.'));
            return;
        }

        $crew = $crewData[0];

        $sqlAccompany = "
            SELECT name, rank
            FROM spj_accompany
            WHERE spj_id = '".$crew->id."' AND deletests = '0'
        ";
        $accompany = $this->MCrewscv->getDataQuery($sqlAccompany);

        $data['crew'] = $crew;
        $data['accompany'] = $accompany;


        require("application/views/frontend/pdf/mpdf60/mpdf.php");
        $mpdf = new mPDF('utf-8', 'A4');

        ob_start();
        $this->load->view('ListReport/Spj/form_spj_pdf', $data);
        $html = ob_get_contents();
        ob_end_clean();

        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output("SPJ_" . $crew->name . ".pdf", 'I');
        exit;
    }

    function saveSPJ()
    {
        $rawData = file_get_contents('php://input');
        $post = json_decode($rawData, true);

        if (empty($post['idperson'])) {
            echo json_encode(array('success' => false, 'message' => 'ID Person kosong'));
            return;
        }

        $idperson = trim($post['idperson']);

        $sql = "
            SELECT 
                a.idperson,
                TRIM(CONCAT(a.fname, ' ', a.mname, ' ', a.lname)) AS fullname,
                a.applyfor AS rank,
                c.nmvsl AS vessel
            FROM mstpersonal a
            LEFT JOIN tblcontract b ON a.idperson = b.idperson AND b.deletests = 0
            LEFT JOIN mstvessel c ON b.signonvsl = c.kdvsl AND c.deletests = 0
            WHERE a.deletests = 0 AND a.idperson = '".$idperson."'
            ORDER BY b.signondt DESC 
            LIMIT 1
        ";

        $data = $this->MCrewscv->getDataQuery($sql);
        if (empty($data)) {
            echo json_encode(array('success' => false, 'message' => 'Data personal tidak ditemukan'));
            return;
        }

        $p = $data[0];
        $dateNow = date('Y-m-d H:i:s');
        $username = $this->session->userdata('userInitCrewSystem');

        $header = array(
            'idperson'       => $idperson,
            'base_on'        => isset($post['base_on']) ? $post['base_on'] : '',
            'name'           => !empty($post['name']) ? $post['name'] : $p->fullname,
            'rank'           => !empty($post['rank']) ? $post['rank'] : $p->rank,
            'destination'    => isset($post['destination']) ? $post['destination'] : '',
            'purpose'        => isset($post['purpose']) ? $post['purpose'] : '',
            'depart_date'    => isset($post['depart_date']) ? $post['depart_date'] : NULL,
            'arrival_date'   => isset($post['arrival_date']) ? $post['arrival_date'] : NULL,
            'transportation' => isset($post['transportation']) ? $post['transportation'] : '',
            'note'           => isset($post['note']) ? $post['note'] : '',
            'created_by'     => $username,
            'created_at'     => $dateNow
        );

        $this->MCrewscv->insData('spj', $header);
        $spj_id = $this->db->insert_id();

        $accompany = isset($post['accompany']) ? $post['accompany'] : array();

        if (!empty($accompany) && is_array($accompany)) {
            foreach ($accompany as $a) {
                $name = isset($a['name']) ? $this->db->escape_str(trim($a['name'])) : '';
                $rank = isset($a['rank']) ? $this->db->escape_str(trim($a['rank'])) : '';

                if ($name !== '' || $rank !== '') {
                    $detail = array(
                        'idperson'   => $idperson,
                        'spj_id'     => $spj_id,
                        'name'       => $name,
                        'rank'       => $rank,
                        'created_at' => $dateNow
                    );
                    $this->MCrewscv->insData('spj_accompany', $detail);
                }
            }
        }

        echo json_encode(array(
            'success' => true,
            'message' => 'Data SPJ berhasil disimpan!',
            'spj_id'  => $spj_id
        ));
    }
}
