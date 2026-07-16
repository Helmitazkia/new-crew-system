<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FamiliarReport extends CI_Controller {

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
        $data['title'] = 'Familiarization Report';
        $data['active_menu'] = 'familiar_report';
        $this->load->view('layout/header', $data);
        $this->load->view('Report/FamiliarReport/view_familiar_report');
        $this->load->view('layout/footer');
    }

    /**
     * List report familiarization (untuk DataTables)
     */
    public function get_report_familiar()
    {
        // Group by batch_id or id if batch_id is null
        $sql = "
            SELECT 
                COALESCE(batch_id, id) as group_id,
                MAX(date_created) as date_created,
                MAX(note) as note,
                COUNT(id) as total_crew
            FROM history_familiarization
            GROUP BY COALESCE(batch_id, id)
            ORDER BY MAX(date_created) DESC
        ";

        $data   = $this->MCrewscv->getDataQuery($sql);
        $result = array();

        if (!empty($data)) {
            foreach ($data as $row) {
                $row->date_created_fmt = !empty($row->date_created)
                    ? date('d M Y H:i', strtotime($row->date_created))
                    : '-';
                $result[] = $row;
            }
        }

        echo json_encode(array(
            'success' => true,
            'data'    => $result
        ));
    }

    /**
     * Detail report familiarization (untuk modal view/update)
     */
    public function get_report_familiar_detail()
    {
        $group_id = $this->input->post('group_id', true);

        if (empty($group_id)) {
            echo json_encode(array('success' => false, 'message' => 'ID tidak ditemukan'));
            return;
        }

        // Cari berdasarkan batch_id ATAU id (untuk fallback data lama)
        $this->db->where('batch_id', $group_id);
        $this->db->or_where('id', $group_id);
        $data = $this->db->get('history_familiarization')->result();

        if (empty($data)) {
            echo json_encode(array('success' => false, 'message' => 'Data tidak ditemukan'));
            return;
        }

        // Ambil data checklist dari salah satu row (karena semuanya sama dalam 1 batch)
        $master = $data[0];

        $crew_list = array();
        foreach ($data as $row) {
            $crew_list[] = array(
                'id_person'   => $row->idperson,
                'name_crew'   => $row->nama_crew,
                'jabatan'     => $row->rank,
                'vessel_name' => $row->vessel,
                'signon_date' => !empty($row->signon_date) ? date('Y-m-d', strtotime($row->signon_date)) : ''
            );
        }

        echo json_encode(array(
            'success' => true,
            'data'    => array(
                'master'    => $master,
                'crew_list' => $crew_list
            )
        ));
    }

    /**
     * Submit form multiple crew
     */
    public function submit_report_familiar()
    {
        $post = $this->input->post(NULL, TRUE);
        if (empty($post)) {
            echo json_encode(array('success' => false, 'message' => 'Data kosong'));
            return;
        }

        $crewList = isset($post['crew_list']) ? $post['crew_list'] : array();
        if (empty($crewList)) {
            echo json_encode(array('success' => false, 'message' => 'Daftar crew tidak boleh kosong'));
            return;
        }

        $batch_id = $this->input->post('batch_id', true);
        
        $this->db->trans_begin();

        // Jika update (batch_id ada isinya), kita hapus dulu semua data dengan batch_id tersebut
        if (!empty($batch_id)) {
            $this->db->where('batch_id', $batch_id);
            $this->db->or_where('id', $batch_id); // Fallback for old single data
            $this->db->delete('history_familiarization');
        } else {
            // Generate batch_id baru untuk mode insert
            $batch_id = 'FAM_' . date('YmdHis') . '_' . rand(100, 999);
        }

        $date_created = date('Y-m-d H:i:s');
        $note = $this->input->post('note', true);

        // Helper: convert radio value (0/1) or NULL if not sent
        $self = $this;
        $getItem = function($field) use ($self) {
            $val = $self->input->post($field);
            return ($val !== false && $val !== null && $val !== '') ? (int)$val : null;
        };

        foreach ($crewList as $crew) {
            $dataInsert = array(
                'batch_id'     => $batch_id,
                'idperson'     => isset($crew['id_person']) ? $crew['id_person'] : '',
                'nama_crew'    => isset($crew['name_crew']) ? $crew['name_crew'] : '',
                'rank'         => isset($crew['jabatan']) ? $crew['jabatan'] : '',
                'vessel'       => isset($crew['vessel_name']) ? $crew['vessel_name'] : '',
                'signon_date'  => isset($crew['signon_date']) && !empty($crew['signon_date']) ? date('Y-m-d', strtotime($crew['signon_date'])) : NULL,
                'note'         => $note,
                'date_created' => $date_created,
                'item_1'       => $getItem('item_1'),
                'item_2'       => $getItem('item_2'),
                'item_3'       => $getItem('item_3'),
                'item_4'       => $getItem('item_4'),
                'item_5'       => $getItem('item_5'),
                'item_6'       => $getItem('item_6'),
                'item_7'       => $getItem('item_7'),
                'item_8'       => $getItem('item_8'),
                'item_9'       => $getItem('item_9'),
                'item_10'      => $getItem('item_10'),
                'item_11'      => $getItem('item_11'),
                'item_12'      => $getItem('item_12'),
                'item_13'      => $getItem('item_13'),
                'item_14'      => $getItem('item_14'),
                'item_15'      => $getItem('item_15'),
                'item_16'      => $getItem('item_16')
            );
            $this->db->insert('history_familiarization', $dataInsert);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(array('success' => false, 'message' => 'Gagal menyimpan data'));
        } else {
            $this->db->trans_commit();
            echo json_encode(array('success' => true, 'message' => 'Data berhasil disimpan', 'batch_id' => $batch_id));
        }
    }

    /**
     * Delete Batch Familiarization
     */
    public function delete_list_familiar()
    {
        $group_id = $this->input->post('group_id', true);

        if (empty($group_id)) {
            echo json_encode(array('success' => false, 'message' => 'ID tidak ditemukan'));
            return;
        }

        $this->db->where('batch_id', $group_id);
        $this->db->or_where('id', $group_id);
        $delete = $this->db->delete('history_familiarization');

        if ($delete) {
            echo json_encode(array('success' => true, 'message' => 'Batch berhasil dihapus'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal menghapus batch'));
        }
    }

    /**
     * Search crew by name (autocomplete)
     */
    public function get_crew_by_name()
    {
        $keyword = $this->input->post('keyword', true);
        $keyword = $this->db->escape_like_str($keyword);

        if (empty($keyword)) {
            $sql = "
                SELECT 
                    A.idperson,
                    CONCAT_WS(' ', A.fname, A.mname, A.lname) AS nama_crew,
                    A.applyfor,
                    A.vesselfor
                FROM mstpersonal A
                WHERE A.deletests = '0'
                AND (A.fname NOT IN ('', '-', ' ')  
                AND A.mname NOT IN ('', '-', ' ')  
                AND A.lname NOT IN ('', '-', ' ')) 
                ORDER BY A.fname ASC
                LIMIT 30
            ";
        }else {
            $sql = "
                SELECT 
                    A.idperson,
                    CONCAT_WS(' ', A.fname, A.mname, A.lname) AS nama_crew,
                    A.applyfor,
                    A.vesselfor
                FROM mstpersonal A
            WHERE 
                (A.fname LIKE '%$keyword%'
                OR A.mname LIKE '%$keyword%'
                OR A.lname LIKE '%$keyword%')
            AND A.deletests = '0'
            ORDER BY A.fname ASC
        ";
        }

        $data   = $this->MCrewscv->getDataQuery($sql);
        $result = array();

        if (!empty($data)) {
            foreach ($data as $row) {
                $result[] = array(
                    'id'        => $row->idperson,
                    'text'      => $row->nama_crew,
                    'jabatan'   => $row->applyfor,
                    'vessel'    => $row->vesselfor
                );
            }
        }

        echo json_encode(array(
            'success' => !empty($result),
            'data'    => $result
        ));
    }

    /**
     * Get crew info for auto-filling based on idperson using tblcontract
     */
    public function get_crew_info_by_idperson()
    {
        $idperson = $this->input->post('idperson', true);

        // Join to tblcontract to get rank and vessel based on latest contract
        $sql = "
            SELECT 
                CONCAT_WS(' ', A.fname, A.mname, A.lname) AS nama_crew,
                C.nmrank AS jabatan,
                D.nmvsl AS vessel_name,
                B.signondt AS signon_date
            FROM mstpersonal A
            LEFT JOIN tblcontract B ON A.idperson = B.idperson AND B.deletests = '0'
            LEFT JOIN mstrank C ON C.kdrank = B.signonrank AND C.deletests = '0'
            LEFT JOIN mstvessel D ON D.kdvsl = B.signonvsl AND D.deletests = '0'
            WHERE A.idperson = ?
            ORDER BY B.signondt DESC, B.idcontract DESC
            LIMIT 1
        ";

        $data = $this->db->query($sql, array($idperson))->row();

        // If no contract found, fallback to mstpersonal
        if ($data && (empty($data->jabatan) || empty($data->vessel_name))) {
            $sqlFallback = "
                SELECT 
                    CONCAT_WS(' ', fname, mname, lname) AS nama_crew,
                    applyfor AS jabatan,
                    vesselfor AS vessel_name
                FROM mstpersonal
                WHERE idperson = ?
                LIMIT 1
            ";
            $dataFallback = $this->db->query($sqlFallback, array($idperson))->row();
            if ($dataFallback) {
                if (empty($data->jabatan)) $data->jabatan = $dataFallback->jabatan;
                if (empty($data->vessel_name)) $data->vessel_name = $dataFallback->vessel_name;
            }
        }

        if ($data && !empty($data->signon_date)) {
            $data->signon_date = date('Y-m-d', strtotime($data->signon_date));
        }

        echo json_encode(array(
            'success' => !empty($data),
            'data'    => $data
        ));
    }
}
