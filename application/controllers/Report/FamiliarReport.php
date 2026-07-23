<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FamiliarReport extends CI_Controller {

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

    /**
     * Daftar departemen unik (untuk generate link)
     */
    private $departments = array(
        'Crewing', 'QHSE', 'DPA','DPA / Marine Safety','Operation', 'Technical', 'Purchasing', 'Finance' ,'Marine Safety'
    );

    /**
     * Top 4 rank keywords (untuk validasi PDF 2 halaman)
     */
    private $top4Ranks = array('MASTER', 'C/O', 'C/E', '2/E');

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
                COUNT(id) as total_crew,
                MAX(item_1) as item_1, MAX(item_2) as item_2, MAX(item_3) as item_3, MAX(item_4) as item_4,
                MAX(item_5) as item_5, MAX(item_6) as item_6, MAX(item_7) as item_7, MAX(item_8) as item_8,
                MAX(item_9) as item_9, MAX(item_10) as item_10, MAX(item_11) as item_11, MAX(item_12) as item_12,
                MAX(item_13) as item_13, MAX(item_14) as item_14, MAX(item_15) as item_15, MAX(item_16) as item_16
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
                
                $isCompleted = true;
                for ($i = 1; $i <= 16; $i++) {
                    $itemKey = 'item_' . $i;
                    if ($row->$itemKey === null || $row->$itemKey === '') {
                        $isCompleted = false;
                        break;
                    }
                }
                
                if ($isCompleted) {
                    $row->status_html = '<span class="badge bg-success" style="font-size: 11px;">Completed</span>';
                    $row->status_text = 'Completed';
                } else {
                    $row->status_html = '<span class="badge bg-warning text-dark" style="font-size: 11px;">Pending</span>';
                    $row->status_text = 'Pending';
                }

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

        // Ambil data lama jika update untuk mempertahankan QR code
        $existingDataMap = array();
        if (!empty($batch_id)) {
            $this->db->where('batch_id', $batch_id);
            $this->db->or_where('id', $batch_id);
            $oldData = $this->db->get('history_familiarization')->result();
            foreach ($oldData as $od) {
                // map by idperson (atau nama_crew jika idperson kosong)
                $key = !empty($od->idperson) ? $od->idperson : $od->nama_crew;
                $existingDataMap[$key] = $od;
            }

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
            $idperson = isset($crew['id_person']) ? $crew['id_person'] : '';
            $nama_crew = isset($crew['name_crew']) ? $crew['name_crew'] : '';
            $key = !empty($idperson) ? $idperson : $nama_crew;
            $oldCrew = isset($existingDataMap[$key]) ? $existingDataMap[$key] : null;

            $dataInsert = array(
                'batch_id'     => $batch_id,
                'idperson'     => $idperson,
                'nama_crew'    => $nama_crew,
                'rank'         => isset($crew['jabatan']) ? $crew['jabatan'] : '',
                'vessel'       => isset($crew['vessel_name']) ? $crew['vessel_name'] : '',
                'signon_date'  => isset($crew['signon_date']) && !empty($crew['signon_date']) ? date('Y-m-d', strtotime($crew['signon_date'])) : NULL,
                'note'         => $note,
                'date_created' => $oldCrew ? $oldCrew->date_created : $date_created,
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
                'item_16'      => $getItem('item_16'),
                
                // Pertahankan QR Codes yang sudah ter-generate sebelumnya
                'qr_checkedby' => $oldCrew && isset($oldCrew->qr_checkedby) ? $oldCrew->qr_checkedby : null,
                'qr_crew'      => $oldCrew && isset($oldCrew->qr_crew) ? $oldCrew->qr_crew : null,
                'qr_dpa'       => $oldCrew && isset($oldCrew->qr_dpa) ? $oldCrew->qr_dpa : null,
                'qr_dept_technical'    => $oldCrew && isset($oldCrew->qr_dept_technical) ? $oldCrew->qr_dept_technical : null,
                'qr_dept_marinesafety' => $oldCrew && isset($oldCrew->qr_dept_marinesafety) ? $oldCrew->qr_dept_marinesafety : null,
                'qr_dept_finance'      => $oldCrew && isset($oldCrew->qr_dept_finance) ? $oldCrew->qr_dept_finance : null,
                'qr_dept_purchasing'   => $oldCrew && isset($oldCrew->qr_dept_purchasing) ? $oldCrew->qr_dept_purchasing : null,
                'qr_dept_qhse'         => $oldCrew && isset($oldCrew->qr_dept_qhse) ? $oldCrew->qr_dept_qhse : null,
                'qr_dept_operation'    => $oldCrew && isset($oldCrew->qr_dept_operation) ? $oldCrew->qr_dept_operation : null,
                'qr_dept_crewing'      => $oldCrew && isset($oldCrew->qr_dept_crewing) ? $oldCrew->qr_dept_crewing : null
            );
            $this->db->insert('history_familiarization', $dataInsert);
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(array('success' => false, 'message' => 'Gagal menyimpan data'));
        } else {
            $this->db->trans_commit();
            // Auto-generate public links jika belum ada
            $this->_generate_links_for_batch($batch_id);
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

        $this->db->trans_start();

        // 1. Delete dari history_familiarization
        $this->db->where('batch_id', $group_id);
        $this->db->or_where('id', $group_id);
        $this->db->delete('history_familiarization');

        // 2. Delete dari fam_public_links
        $this->db->where('batch_id', $group_id);
        $this->db->delete('fam_public_links');

        // 3. Delete dari fam_checklist_audit
        $this->db->where('batch_id', $group_id);
        $this->db->delete('fam_checklist_audit');

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            echo json_encode(array('success' => true, 'message' => 'Batch beserta seluruh datanya berhasil dihapus'));
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

    // ============================================================
    //  PUBLIC LINK MANAGEMENT
    // ============================================================

    /**
     * Internal: Generate public links for all departments for a batch
     */
    private function _generate_links_for_batch($batch_id)
    {
        $checkedBy = $this->session->userdata('userFullNm');

        foreach ($this->departments as $dept) {
            // Cek apakah sudah ada link aktif untuk batch+dept ini
            $existing = $this->db->where('batch_id', $batch_id)
                                ->where('department', $dept)
                                ->where('is_active', 1)
                                ->get('fam_public_links')->row();

            if (!$existing) {
                $token = hash('sha256', $batch_id . $dept . microtime(true) . rand(1000, 9999));
                $this->db->insert('fam_public_links', array(
                    'batch_id'   => $batch_id,
                    'department' => $dept,
                    'token'      => $token,
                    'created_by' => $checkedBy,
                    'created_at' => date('Y-m-d H:i:s'),
                    'is_active'  => 1
                ));
            }
        }

        // --- Generate QR Signatures (CheckedBy & Crew) ---
        $this->db->where('batch_id', $batch_id);
        $crewRows = $this->db->get('history_familiarization')->result();

        foreach ($crewRows as $crew) {
            $updateData = array();

            // 1. QR Checked By
            if (empty($crew->qr_checkedby)) {
                $qrChecked = $this->_generateQRRecord($crew->nama_crew, $checkedBy, 'fam_check');
                if ($qrChecked) $updateData['qr_checkedby'] = $qrChecked;
            }

            // 2. QR Crew
            if (empty($crew->qr_crew)) {
                // Untuk crew, createdby-nya bisa nama crew atau nama chekedBy
                $qrCrew = $this->_generateQRRecord($crew->nama_crew, $crew->nama_crew, 'fam_crew');
                if ($qrCrew) $updateData['qr_crew'] = $qrCrew;
            }

            if (!empty($updateData)) {
                $this->db->where('id', $crew->id);
                $this->db->update('history_familiarization', $updateData);
            }
        }
    }

    /**
     * API: Get public links for a batch (untuk modal share)
     */
    public function get_public_links()
    {
        $batch_id = $this->input->post('batch_id', true);
        if (empty($batch_id)) {
            echo json_encode(array('success' => false, 'message' => 'Batch ID kosong'));
            return;
        }

        // Generate links jika belum ada
        $this->_generate_links_for_batch($batch_id);

        $links = $this->db->where('batch_id', $batch_id)
                          ->where('is_active', 1)
                          ->order_by('department', 'ASC')
                          ->get('fam_public_links')->result();

        $result = array();
        foreach ($links as $link) {
            // Cek apakah departemen sudah mengisi (ada audit trail)
            $filled = $this->db->where('batch_id', $batch_id)
                               ->where('department', $link->department)
                               ->get('fam_checklist_audit')->num_rows();

            // Hitung total items untuk departemen ini
            $totalItems = 0;
            foreach ($this->itemDepartmentMap as $item => $dept) {
                if ($dept === $link->department) $totalItems++;
            }

            $link->url = base_url('PublicFamiliar/form/' . $link->token);
            $link->filled_count = $filled;
            $link->total_items = $totalItems;
            $link->status = ($filled >= $totalItems && $totalItems > 0) ? 'completed' : ($filled > 0 ? 'partial' : 'pending');
            $result[] = $link;
        }

        echo json_encode(array('success' => true, 'data' => $result));
    }

    // ============================================================
    //  AUDIT TRAIL
    // ============================================================

    /**
     * API: Get checklist audit trail for a batch
     */
    public function get_checklist_audit()
    {
        $batch_id = $this->input->post('batch_id', true);
        if (empty($batch_id)) {
            echo json_encode(array('success' => false, 'message' => 'Batch ID kosong'));
            return;
        }

        $audits = $this->db->where('batch_id', $batch_id)
                           ->order_by('item_name', 'ASC')
                           ->order_by('filled_at', 'DESC')
                           ->get('fam_checklist_audit')->result();

        // Enrich with topic labels
        $itemLabels = array(
            'item_1'  => 'Procedures Related Crewing',
            'item_2'  => 'QHSE Policy',
            'item_3'  => 'Safety Management System',
            'item_4'  => 'Duties and Responsibility',
            'item_5'  => 'Procedures Related Ship Operation',
            'item_6'  => 'Procedures Related Emergency',
            'item_7'  => 'Maintenance - Technical',
            'item_8'  => 'Maintenance - Purchasing',
            'item_9'  => 'Maintenance - Finance',
            'item_10' => 'Cargo Handling',
            'item_11' => 'Safety Drill',
            'item_12' => 'Procedures Related Health',
            'item_13' => 'Environmental Protection',
            'item_14' => 'Audit External / Internal',
            'item_15' => 'Hazard Identification / JSA',
            'item_16' => 'Wearing PPE'
        );

        foreach ($audits as &$a) {
            $a->topic = isset($itemLabels[$a->item_name]) ? $itemLabels[$a->item_name] : $a->item_name;
            $a->filled_at_fmt = !empty($a->filled_at) ? date('d M Y H:i', strtotime($a->filled_at)) : '-';
            $a->value_label = ($a->item_value == 1) ? 'Yes' : 'No';
        }

        echo json_encode(array('success' => true, 'data' => $audits));
    }

    // ============================================================
    //  PDF GENERATION (Batch, with Top 4 logic)
    // ============================================================

    /**
     * Check if a rank string matches Top 4
     */
    private function isTop4Rank($rankStr)
    {
        $rank = strtoupper(trim($rankStr));
        foreach ($this->top4Ranks as $t4) {
            if ($rank === $t4 || strpos($rank, $t4) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * Generate Familiarization PDF for a batch
     * Top 4 rank = 2 pages, selainnya = 1 page
     */
    public function familiar_report_pdf()
    {
        $batch_id = $this->input->post('batch_id');
        if (!$batch_id) {
            $batch_id = $this->uri->segment(4);
        }

        if (!$batch_id) {
            echo 'Batch ID tidak dikirim.';
            return;
        }

        // Get all crew in this batch
        $this->db->where('batch_id', $batch_id);
        $crewRows = $this->db->get('history_familiarization')->result();

        if (empty($crewRows)) {
            echo 'Data tidak ditemukan.';
            return;
        }

        // Get master data (checklist values sama untuk semua crew)
        $master = $crewRows[0];

        // Get signature_checkedBy from fam_public_links
        $link = $this->db->where('batch_id', $batch_id)->limit(1)->get('fam_public_links')->row();
        $signature_checkedBy = $link ? $link->created_by : '';

        // Get signature_DPA from fam_checklist_audit
        $auditDpa = $this->db->where('batch_id', $batch_id)
                             ->where('department', 'DPA')
                             ->limit(1)
                             ->get('fam_checklist_audit')->row();
        $signature_DPA = $auditDpa ? $auditDpa->filled_by_name : '';

        // Get representatives for all departments for Page 2
        $reps = array();
        $allAudits = $this->db->where('batch_id', $batch_id)->get('fam_checklist_audit')->result();
        foreach ($allAudits as $au) {
            // We just need one entry per department to get the filled_by_name
            if (!isset($reps[$au->department])) {
                $reps[$au->department] = $au->filled_by_name;
            }
        }

        // Get time_start and time_end from fam_public_links
        $times = array();
        $publicLinks = $this->db->where('batch_id', $batch_id)->get('fam_public_links')->result();
        foreach ($publicLinks as $pl) {
            if (!empty($pl->time_start) && !empty($pl->time_end)) {
                $times[$pl->department] = array(
                    'start' => date('H:i', strtotime($pl->time_start)),
                    'end'   => date('H:i', strtotime($pl->time_end))
                );
            }
        }

        // Enrich crew data from mstpersonal (hanya ambil Date of Birth) + history_familiarization
        $crewList = array();
        foreach ($crewRows as $row) {
            // Ambil DOB dari mstpersonal
            $sql = "
                SELECT DATE_FORMAT(dob, '%d-%m-%Y') AS date_of_birth
                FROM mstpersonal
                WHERE idperson = ?
                LIMIT 1
            ";
            $p = $this->db->query($sql, array($row->idperson))->row();
            $dob = $p ? $p->date_of_birth : '';

            // calculate Years in Rank
            $sqlContract = "
                SELECT A.signondt, A.signoffdt, C.nmrank
                FROM tblcontract A
                JOIN mstrank C ON C.kdrank = A.signonrank
                WHERE A.idperson = ? AND A.deletests = '0'
            ";
            $contracts = $this->db->query($sqlContract, array($row->idperson))->result();
            $yearsInRank = 0;
            foreach ($contracts as $c) {
                if ($this->isTop4Rank($c->nmrank)) {
                    if (!empty($c->signondt) && !empty($c->signoffdt) && $c->signoffdt != '0000-00-00' && $c->signondt != '0000-00-00') {
                        $diff = strtotime($c->signoffdt) - strtotime($c->signondt);
                        if ($diff > 0) {
                            $yearsInRank += $diff / (365 * 24 * 60 * 60);
                        }
                    }
                }
            }
            $yearsInRankFormatted = '';
            if ($yearsInRank > 0) {
                $years = floor($yearsInRank);
                $months = round(($yearsInRank - $years) * 12);
                if ($months == 12) {
                    $years += 1;
                    $months = 0;
                }
                $parts = array();
                if ($years > 0) {
                    $parts[] = $years . ' Year' . ($years > 1 ? 's' : '');
                }
                if ($months > 0) {
                    $parts[] = $months . ' Month' . ($months > 1 ? 's' : '');
                }
                $yearsInRankFormatted = !empty($parts) ? implode(' ', $parts) : '';
            }

            // calculate License
            $license = '';
            $rankUpper = strtoupper(trim($row->rank));
            $isTop4 = $this->isTop4Rank($row->rank);
            
            if ($isTop4) {
                $licensePrefix = '';
                if ($rankUpper === 'MASTER' || $rankUpper === 'C/O' || strpos($rankUpper, 'MASTER') !== false || strpos($rankUpper, 'C/O') !== false) {
                    $licensePrefix = 'ANT';
                } elseif ($rankUpper === 'C/E' || $rankUpper === '2/E' || strpos($rankUpper, 'C/E') !== false || strpos($rankUpper, '2/E') !== false) {
                    $licensePrefix = 'ATT';
                }
                
                if ($licensePrefix !== '') {
                    $sqlCert = "
                        SELECT certname, dispname 
                        FROM tblcertdoc
                        WHERE idperson = ? AND deletests = '0'
                    ";
                    $certs = $this->db->query($sqlCert, array($row->idperson))->result();
                    foreach ($certs as $c) {
                        $cname = strtoupper($c->certname . ' ' . $c->dispname);
                        if (strpos($cname, $licensePrefix) !== false) {
                            // Extract ANT/ATT string using regex
                            preg_match('/(' . $licensePrefix . '\s*(?:[IVX]+|[1-5]+))/', $cname, $matches);
                            if (!empty($matches[1])) {
                                $license = $matches[1];
                                break;
                            } else {
                                // fallback if regex fails but prefix exists
                                $license = $licensePrefix;
                            }
                        }
                    }
                }
            }

            $crewInfo = (object) array(
                'fullname'      => $row->nama_crew,
                'date_of_birth' => $dob,
                'rankname'      => $row->rank,
                'vesselnm'      => $row->vessel,
                'signon_date'   => !empty($row->signon_date) ? date('d-m-Y', strtotime($row->signon_date)) : '',
                'is_top4'       => $this->isTop4Rank($row->rank),
                'qr_crew'       => isset($row->qr_crew) ? $row->qr_crew : '',
                'qr_checkedby'  => isset($row->qr_checkedby) ? $row->qr_checkedby : '',
                'qr_dpa'        => isset($row->qr_dpa) ? $row->qr_dpa : '',
                'qr_dept_technical'    => isset($row->qr_dept_technical) ? $row->qr_dept_technical : '',
                'qr_dept_marinesafety' => isset($row->qr_dept_marinesafety) ? $row->qr_dept_marinesafety : '',
                'qr_dept_finance'      => isset($row->qr_dept_finance) ? $row->qr_dept_finance : '',
                'qr_dept_purchasing'   => isset($row->qr_dept_purchasing) ? $row->qr_dept_purchasing : '',
                'qr_dept_qhse'         => isset($row->qr_dept_qhse) ? $row->qr_dept_qhse : '',
                'qr_dept_operation'    => isset($row->qr_dept_operation) ? $row->qr_dept_operation : '',
                'qr_dept_crewing'      => isset($row->qr_dept_crewing) ? $row->qr_dept_crewing : '',
                'signature_checkedBy'  => $signature_checkedBy,
                'signature_DPA'        => $signature_DPA,
                'license'              => $license,
                'years_in_rank'        => $yearsInRankFormatted
            );

            $crewList[] = $crewInfo;
        }

        $dataOut = array(
            'master'    => $master,
            'crewList'  => $crewList,
            'today'     => date('d F Y'),
            'reps'      => $reps,
            'times'     => $times
        );

        require(APPPATH . 'views/frontend/pdf/mpdf60/mpdf.php');
        $mpdf = new mPDF('utf-8', 'A4');

        ob_start();
        $this->load->view('Report/FamiliarReport/form_familiar_report_pdf', $dataOut);
        $html = ob_get_contents();
        ob_end_clean();

        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output('Familiarization_Report_' . $batch_id . '.pdf', 'I');
        exit;
    }

    /**
     * API: Get item-department mapping (untuk frontend)
     */
    public function get_item_department_map()
    {
        echo json_encode(array('success' => true, 'data' => $this->itemDepartmentMap));
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

        // Kembali ke default DB (karena insDataDb6 mungkin mengubah active DB)
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
