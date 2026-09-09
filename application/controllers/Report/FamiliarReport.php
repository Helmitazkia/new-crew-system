<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FamiliarReport extends CI_Controller {

    /**
     * Top 4 rank keywords (untuk validasi PDF 2 halaman)
     */
    private $top4Ranks = array('MASTER', 'C/O', 'C/E', '2/E');

    // -------------------------------------------------------------------
    // HELPER: Load master topics & departments secara dinamis dari DB
    // -------------------------------------------------------------------
    private function _getActiveTopics()
    {
        return $this->db->where('is_active', 1)
                        ->order_by('order_no', 'ASC')
                        ->order_by('id', 'ASC')
                        ->get('mst_fam_topic')->result();
    }

    private function _getActiveDepartments()
    {
        return $this->db->where('is_active', 1)
                        ->order_by('department_name', 'ASC')
                        ->get('mst_fam_department')->result();
    }

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
        // Ambil total topic aktif untuk cek status "Completed"
        $totalTopics = $this->db->where('is_active', 1)->count_all_results('mst_fam_topic');

        $sql = "
            SELECT
                COALESCE(batch_id, id) as group_id,
                MAX(date_created) as date_created,
                MAX(note) as note,
                GROUP_CONCAT(DISTINCT REPLACE(vessel, '.', '') SEPARATOR ', ') as vessel,
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

                // Ambil salah satu history_id dari batch ini
                $firstRow = $this->db->where('batch_id', $row->group_id)
                                     ->limit(1)
                                     ->get('history_familiarization')->row();
                $historyId = $firstRow ? $firstRow->id : $row->group_id;

                // Hitung berapa topic yang sudah diisi (is_checked) pada batch ini
                $checkedCount = 0;
                if ($firstRow) {
                    // Count distinct topics yang sudah diisi di salah satu anggota batch
                    $checkedCount = $this->db
                        ->where('history_id', $historyId)
                        ->where('is_checked', 1)
                        ->count_all_results('history_fam_topic_detail');
                }

                if ($totalTopics > 0 && $checkedCount >= $totalTopics) {
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
     * Mengembalikan juga checklist items yang sudah diisi per history_id
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

        $master = $data[0];

        // Ambil checklist topics yang sudah diisi untuk history pertama
        $topicDetails = $this->db
            ->select('d.topic_id, d.is_checked, t.topic_name, t.dept_name, t.order_no')
            ->from('history_fam_topic_detail d')
            ->join('mst_fam_topic t', 't.id = d.topic_id', 'left')
            ->where('d.history_id', $master->id)
            ->order_by('t.order_no', 'ASC')
            ->get()->result();

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
                'master'       => $master,
                'crew_list'    => $crew_list,
                'topic_detail' => $topicDetails
            )
        ));
    }

    /**
     * Submit form multiple crew - Menyimpan ke tabel Header + Detail (dinamis)
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

        // Load semua active topics untuk disimpan di detail
        $activeTopics = $this->_getActiveTopics();
        if (empty($activeTopics)) {
            echo json_encode(array('success' => false, 'message' => 'Tidak ada Topic aktif. Silahkan isi Master Familiarization Topic terlebih dahulu.'));
            return;
        }

        $this->db->trans_begin();

        // Jika update, hapus data lama
        if (!empty($batch_id)) {
            // Ambil history IDs yang akan dihapus
            $this->db->where('batch_id', $batch_id);
            $oldRows = $this->db->get('history_familiarization')->result();
            $oldIds  = array_map(function($r) { return $r->id; }, $oldRows);

            if (!empty($oldIds)) {
                $this->db->where_in('history_id', $oldIds)->delete('history_fam_topic_detail');
            }

            $this->db->where('batch_id', $batch_id)->delete('history_familiarization');
        } else {
            $batch_id = 'FAM_' . date('YmdHis') . '_' . rand(100, 999);
        }

        $date_created = date('Y-m-d H:i:s');
        $note         = $this->input->post('note', true);

        foreach ($crewList as $crew) {
            $idperson  = isset($crew['id_person']) ? $crew['id_person'] : '';
            $nama_crew = isset($crew['name_crew']) ? $crew['name_crew'] : '';

            $dataInsert = array(
                'batch_id'     => $batch_id,
                'idperson'     => $idperson,
                'nama_crew'    => $nama_crew,
                'rank'         => isset($crew['jabatan']) ? $crew['jabatan'] : '',
                'vessel'       => isset($crew['vessel_name']) ? $crew['vessel_name'] : '',
                'signon_date'  => isset($crew['signon_date']) && !empty($crew['signon_date']) ? date('Y-m-d', strtotime($crew['signon_date'])) : NULL,
                'note'         => $note,
                'date_created' => $date_created,
            );

            $this->db->insert('history_familiarization', $dataInsert);
            $newHistoryId = $this->db->insert_id();

            // Insert detail topic untuk setiap topic aktif
            foreach ($activeTopics as $topic) {
                $fieldName  = 'topic_' . $topic->id; // e.g. topic_1, topic_2
                $isChecked  = $this->input->post($fieldName);
                $checkedVal = ($isChecked !== false && $isChecked !== null && $isChecked !== '') ? (int)$isChecked : 0;

                $this->db->insert('history_fam_topic_detail', array(
                    'history_id' => $newHistoryId,
                    'topic_id'   => $topic->id,
                    'is_checked' => $checkedVal
                ));
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(array('success' => false, 'message' => 'Gagal menyimpan data'));
        } else {
            $this->db->trans_commit();
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

        // 1. Ambil semua history_id dalam batch ini
        $this->db->where('batch_id', $group_id);
        $historyRows = $this->db->get('history_familiarization')->result();
        $historyIds  = array_map(function($r) { return $r->id; }, $historyRows);

        // 2. Delete detail tables
        if (!empty($historyIds)) {
            $this->db->where_in('history_id', $historyIds)->delete('history_fam_topic_detail');
            $this->db->where_in('history_id', $historyIds)->delete('history_fam_dept_signature');
        }

        // 3. Delete header
        $this->db->where('batch_id', $group_id);
        $this->db->or_where('id', $group_id);
        $this->db->delete('history_familiarization');

        // 4. Delete dari fam_public_links
        $this->db->where('batch_id', $group_id)->delete('fam_public_links');

        // 5. Delete dari fam_checklist_audit
        $this->db->where('batch_id', $group_id)->delete('fam_checklist_audit');

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
     * Internal: Generate public links for all departments (dari mst_fam_department)
     */
    private function _generate_links_for_batch($batch_id)
    {
        $checkedBy = $this->session->userdata('userFullNm');

        // Load departments dari master (dinamis)
        $departments = $this->_getActiveDepartments();

        foreach ($departments as $dept) {
            $existing = $this->db->where('batch_id', $batch_id)
                                 ->where('department', $dept->department_name)
                                 ->where('is_active', 1)
                                 ->get('fam_public_links')->row();

            if (!$existing) {
                $token = hash('sha256', $batch_id . $dept->department_name . microtime(true) . rand(1000, 9999));
                $this->db->insert('fam_public_links', array(
                    'batch_id'   => $batch_id,
                    'department' => $dept->department_name,
                    'token'      => $token,
                    'created_by' => $checkedBy,
                    'created_at' => date('Y-m-d H:i:s'),
                    'is_active'  => 1
                ));
            }
        }

        // Generate QR Checkedby untuk setiap crew dalam batch
        $this->db->where('batch_id', $batch_id);
        $crewRows = $this->db->get('history_familiarization')->result();

        foreach ($crewRows as $crew) {
            $updateData = array();

            if (empty($crew->qr_checkedby)) {
                $qrChecked = $this->_generateQRRecord($crew->nama_crew, $checkedBy, 'fam_check');
                if ($qrChecked) $updateData['qr_checkedby'] = $qrChecked;
            }

            if (!empty($updateData)) {
                $this->db->where('id', $crew->id);
                $this->db->update('history_familiarization', $updateData);
            }
        }
    }

    /**
     * API: Get public links for a batch (dinamis dari mst_fam_department)
     */
    public function get_public_links()
    {
        $batch_id = $this->input->post('batch_id', true);
        if (empty($batch_id)) {
            echo json_encode(array('success' => false, 'message' => 'Batch ID kosong'));
            return;
        }

        $this->_generate_links_for_batch($batch_id);

        $links = $this->db->where('batch_id', $batch_id)
                          ->where('is_active', 1)
                          ->order_by('department', 'ASC')
                          ->get('fam_public_links')->result();

        $result = array();

        // Link crew
        $crewTotal  = $this->db->where('batch_id', $batch_id)->get('history_familiarization')->num_rows();
        $crewFilled = $this->db->where('batch_id', $batch_id)->where('qr_crew IS NOT NULL', null, false)->where('qr_crew !=', '')->get('history_familiarization')->num_rows();
        $crewToken  = md5($batch_id . 'CREW_ALL_SECRET');
        $crewLink   = new stdClass();
        $crewLink->department  = 'Semua Crew (Link Konfirmasi Bersama)';
        $crewLink->url         = base_url('PublicFamiliar/crew_checklist?batch=' . $batch_id . '&token=' . $crewToken);
        $crewLink->filled_count = $crewFilled;
        $crewLink->total_items  = $crewTotal;
        $crewLink->status       = ($crewFilled >= $crewTotal && $crewTotal > 0) ? 'completed' : ($crewFilled > 0 ? 'partial' : 'pending');
        $result[] = $crewLink;

        // Load topics per dept dari mst_fam_topic
        $topicsByDept = array();
        $topics = $this->_getActiveTopics();
        foreach ($topics as $t) {
            if (!isset($topicsByDept[$t->dept_name])) $topicsByDept[$t->dept_name] = 0;
            $topicsByDept[$t->dept_name]++;
        }

        foreach ($links as $link) {
            $filled     = $this->db->where('batch_id', $batch_id)->where('department', $link->department)->get('fam_checklist_audit')->num_rows();
            $totalItems = isset($topicsByDept[$link->department]) ? $topicsByDept[$link->department] : 0;

            $link->url         = base_url('PublicFamiliar/form/' . $link->token);
            $link->filled_count = $filled;
            $link->total_items  = $totalItems;
            $link->status       = ($filled >= $totalItems && $totalItems > 0) ? 'completed' : ($filled > 0 ? 'partial' : 'pending');
            $result[] = $link;
        }

        echo json_encode(array('success' => true, 'data' => $result));
    }

    // ============================================================
    //  AUDIT TRAIL
    // ============================================================

    /**
     * API: Get checklist audit trail - join mst_fam_topic untuk topic label
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

        // Load topic labels dari DB
        $topicLabels = array();
        $topicRows   = $this->db->get('mst_fam_topic')->result();
        foreach ($topicRows as $t) {
            // Support both old key format (item_N) and new key format (topic_N)
            $topicLabels['item_'  . $t->id] = $t->topic_name;
            $topicLabels['topic_' . $t->id] = $t->topic_name;
        }

        foreach ($audits as &$a) {
            $a->topic       = isset($topicLabels[$a->item_name]) ? $topicLabels[$a->item_name] : $a->item_name;
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
        
        // FETCH TOPIC DETAILS and map to $master->item_X
        $topicDetails = $this->db->where('history_id', $master->id)->get('history_fam_topic_detail')->result();
        foreach ($topicDetails as $td) {
            $prop = 'item_' . $td->topic_id;
            $master->$prop = $td->is_checked;
        }


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

            // Fetch signatures from history_fam_dept_signature
            $sqlSigs = "SELECT dept_id, qr_code_value FROM history_fam_dept_signature WHERE history_id = ?";
            $sigs = $this->db->query($sqlSigs, array($row->id))->result();
            $deptSigs = array();
            foreach ($sigs as $s) {
                $deptSigs[$s->dept_id] = $s->qr_code_value;
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
                'qr_dpa'        => isset($deptSigs['DPA']) ? $deptSigs['DPA'] : (isset($deptSigs['DPA / Marine Safety']) ? $deptSigs['DPA / Marine Safety'] : ''),
                'qr_dept_technical'    => isset($deptSigs['Technical']) ? $deptSigs['Technical'] : '',
                'qr_dept_marinesafety' => isset($deptSigs['Marine Safety']) ? $deptSigs['Marine Safety'] : '',
                'qr_dept_finance'      => isset($deptSigs['Finance']) ? $deptSigs['Finance'] : '',
                'qr_dept_purchasing'   => isset($deptSigs['Purchasing']) ? $deptSigs['Purchasing'] : '',
                'qr_dept_qhse'         => isset($deptSigs['QHSE']) ? $deptSigs['QHSE'] : '',
                'qr_dept_operation'    => isset($deptSigs['Operation']) ? $deptSigs['Operation'] : '',
                'qr_dept_crewing'      => isset($deptSigs['Crewing']) ? $deptSigs['Crewing'] : '',
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
            'times'     => $times,
            'topics'    => $this->_getActiveTopics()
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
     * API: Get active topics untuk frontend (dinamis)
     */
    public function get_active_topics()
    {
        $topics = $this->_getActiveTopics();
        echo json_encode(array('success' => true, 'data' => $topics));
    }

    /**
     * API: Get item-department mapping (compatibility / deprecated)
     */
    public function get_item_department_map()
    {
        // Build dinamis dari mst_fam_topic
        $topics = $this->_getActiveTopics();
        $map    = array();
        foreach ($topics as $t) {
            $map['topic_' . $t->id] = $t->dept_name;
        }
        echo json_encode(array('success' => true, 'data' => $map));
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
