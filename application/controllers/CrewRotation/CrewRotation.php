<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CrewRotation extends CI_Controller
{
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

    private function _getCompanyOptionsArray()
    {
        $rows = $this->MCrewscv->getData("kdcmp, nmcmp", "mstcmprec", "deletests = '0'", "nmcmp ASC");
        $out = array(array("value" => "", "text" => "- Select -"));
        foreach ($rows as $r) {
            $out[] = array("value" => $r->kdcmp, "text" => $r->nmcmp);
        }
        return $out;
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

    private function _getSignOffRemarkOptionsArray()
    {
        $rows = $this->MCrewscv->getData("kdremark, nmremark, descremark", "mstremark", "deletests = '0'", "nmremark ASC");
        $out = array(array("value" => "", "text" => "- Select -"));
        foreach ($rows as $r) {
            $label = isset($r->descremark) && $r->descremark !== '' ? "(" . $r->nmremark . ") " . $r->descremark : $r->nmremark;
            $out[] = array("value" => $r->kdremark, "text" => $label);
        }
        return $out;
    }

    private function _getPersonOptionsArray()
    {
        $sql = "SELECT idperson, TRIM(CONCAT_WS(' ', fname, mname, lname)) AS fullName
                FROM mstpersonal
                WHERE deletests = '0' AND (fname != '' OR mname != '' OR lname != '')
                ORDER BY fullName ASC";
        $rows = $this->db->query($sql)->result();
        $out = array(array("value" => "", "text" => "- Select -"));
        foreach ($rows as $r) {
            $out[] = array("value" => $r->idperson, "text" => $r->fullName . ' (' . $r->idperson . ')');
        }
        return $out;
    }

    /**
     * Satu list person untuk On Board & Stand By (sama pool dengan Active Roster).
     * Validasi On Board vs Stand By dilakukan di view crew_rotation_detail.php
     * (logika sama dengan active_roster.php: hirarki signoffdt → estsignoffdt; Expired Over = Stand By).
     */
    private function _getPersonActiveRosterOptionsArray()
    {
        $sql = "SELECT P.idperson, TRIM(CONCAT_WS(' ', P.fname, P.mname, P.lname)) AS fullName,
                C.signoffdt, C.estsignoffdt,
                P.newapplicent
                FROM mstpersonal P
                LEFT JOIN (
                    SELECT t.idperson, t.signoffdt, t.estsignoffdt
                    FROM tblcontract t
                    INNER JOIN (
                        SELECT idperson, MAX(idcontract) AS max_idcontract
                        FROM tblcontract WHERE deletests = 0 GROUP BY idperson
                    ) x ON x.idperson = t.idperson AND x.max_idcontract = t.idcontract
                ) C ON P.idperson = C.idperson
                WHERE P.deletests = '0' AND P.inaktif = '0'
                AND (P.fname != '' OR P.mname != '' OR P.lname != '')
                ORDER BY fullName ASC";
        $rows = $this->db->query($sql)->result();
        $out = array();
        foreach ($rows as $r) {
            $out[] = array(
                'value'      => $r->idperson,
                'text'       => $r->fullName . ' (' . $r->idperson . ')',
                'signoffdt'  => isset($r->signoffdt) ? $r->signoffdt : '',
                'estsignoffdt' => isset($r->estsignoffdt) ? $r->estsignoffdt : '',
                'newapplicent' => isset($r->newapplicent) ? $r->newapplicent : ''
            );
        }
        return $out;
    }

    public function index()
    {
        $data = array(
            'title'   => 'Crew Rotation',
            'content' => 'Roster/CrewRotation/crew_rotation'
        );
        $this->load->view('menu/main_CrewLifecycle', $data);
    }

    public function ajaxCrewRotation()
    {
        $this->load->view('Roster/CrewRotation/crew_rotation');
    }

    public function getAllData_crewRotation()
    {
        // Onboard (Name, Rank, S/ON, Vessel, S/Off Plan) = dari kontrak terakhir off-signer (tblcontract, MAX idcontract)
        // Pakai kontrak terakhir agar tetap ada data setelah sign off (signoffdt sudah diisi)
        $sql = "SELECT R.idcrewrotation, R.idperson, R.BatchID, R.is_double_up, R.kdcmprec, R.signondt, R.signoffdt, R.estsignoffdt,
                R.signonrank, R.signonvsl, R.signonport, R.signondesc, R.lastvsl, R.no_pkl, R.estremark,
                R.signoffremark, R.remaks_cancel, R.replacement_idperson, R.replacement_rank, R.status, R.next_vessel,
                P.fullName AS onboard_name,
                C_ONBOARD.nmrank AS onboard_rank_name,
                D_ONBOARD.nmvsl AS onboard_vessel_name,
                COFF.signondt AS contract_signondt,
                COFF.estsignoffdt AS contract_estsignoffdt,
                B.nmcmp AS company_name,
                REPL.fullName AS replacement_name,
                NXVSL.nmvsl AS next_vessel_name
                FROM tblcrewrotation R
                LEFT JOIN (
                    SELECT idperson, TRIM(CONCAT_WS(' ', fname, mname, lname)) AS fullName
                    FROM mstpersonal WHERE deletests = '0'
                ) P ON P.idperson = R.idperson
                LEFT JOIN (
                    SELECT t.idperson, t.idcontract, t.signonrank, t.signonvsl, t.signondt, t.estsignoffdt
                    FROM tblcontract t
                    INNER JOIN (
                        SELECT idperson, MAX(idcontract) AS max_idcontract
                        FROM tblcontract WHERE deletests = '0' GROUP BY idperson
                    ) x ON x.idperson = t.idperson AND x.max_idcontract = t.idcontract
                    WHERE t.deletests = '0'
                ) COFF ON COFF.idperson = R.idperson
                LEFT JOIN mstrank C_ONBOARD ON C_ONBOARD.kdrank = COFF.signonrank AND C_ONBOARD.deletests = '0'
                LEFT JOIN mstvessel D_ONBOARD ON D_ONBOARD.kdvsl = COFF.signonvsl AND D_ONBOARD.deletests = '0'
                LEFT JOIN mstcmprec B ON B.kdcmp = R.kdcmprec AND B.deletests = '0'
                LEFT JOIN (
                    SELECT idperson, TRIM(CONCAT_WS(' ', fname, mname, lname)) AS fullName
                    FROM mstpersonal WHERE deletests = '0'
                ) REPL ON REPL.idperson = R.replacement_idperson
                LEFT JOIN mstvessel NXVSL ON NXVSL.kdvsl = R.next_vessel AND NXVSL.deletests = '0'
                WHERE R.deletests = '0'
                ORDER BY (R.BatchID IS NULL OR R.BatchID = ''), R.BatchID ASC, R.idcrewrotation ASC";

        // print_r($sql);
        // exit;
        $rows = $this->db->query($sql)->result_array();
        $data = array();
        foreach ($rows as $row) {
            $signondt = isset($row['contract_signondt']) && $row['contract_signondt'] && $row['contract_signondt'] !== '0000-00-00'
                ? $row['contract_signondt'] : null;
            $estsignoffdt = isset($row['contract_estsignoffdt']) && $row['contract_estsignoffdt'] && $row['contract_estsignoffdt'] !== '0000-00-00'
                ? $row['contract_estsignoffdt'] : null;
            $data[] = array(
                'idcrewrotation'    => $row['idcrewrotation'],
                'idperson'          => $row['idperson'],
                'batch_id'          => isset($row['BatchID']) ? $row['BatchID'] : '',
                'is_double_up'      => isset($row['is_double_up']) ? (int)$row['is_double_up'] : 0,
                'onboard_name'      => isset($row['onboard_name']) ? $row['onboard_name'] : '',
                'onboard_rank'      => isset($row['onboard_rank_name']) ? $row['onboard_rank_name'] : '',
                'onboard_son'       => $signondt ? date('d M Y', strtotime($signondt)) : '-',
                'onboard_vessel'    => isset($row['onboard_vessel_name']) ? $row['onboard_vessel_name'] : '',
                'onboard_soff'     => $estsignoffdt ? date('d M Y', strtotime($estsignoffdt)) : '-',
                'remark'           => isset($row['estremark']) ? $row['estremark'] : '',
                'remarks_cancel'   => isset($row['remaks_cancel']) ? $row['remaks_cancel'] : '',
                'replacement_rank' => isset($row['replacement_rank']) ? $row['replacement_rank'] : '-',
                'replacement_name' => isset($row['replacement_name']) ? $row['replacement_name'] : '-',
                'status'           => $row['status'],
                'next_vessel'      => isset($row['next_vessel_name']) && $row['next_vessel_name'] ? $row['next_vessel_name'] : (isset($row['next_vessel']) ? $row['next_vessel'] : ''),
            );
        }
        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('success' => true, 'data' => $data))
        );
    }

    public function detail()
    {
        $idcrewrotation = $this->input->get('idcrewrotation');
        $row = null;
        $batch_rows = array();
        $batch_id = '';
        if (!empty($idcrewrotation)) {
            $sql = "SELECT R.*, P.fullName AS onboard_name, REPL.fullName AS replacement_name
                    FROM tblcrewrotation R
                    LEFT JOIN (
                        SELECT idperson, TRIM(CONCAT_WS(' ', fname, mname, lname)) AS fullName
                        FROM mstpersonal WHERE deletests = '0'
                    ) P ON P.idperson = R.idperson
                    LEFT JOIN (
                        SELECT idperson, TRIM(CONCAT_WS(' ', fname, mname, lname)) AS fullName
                        FROM mstpersonal WHERE deletests = '0'
                    ) REPL ON REPL.idperson = R.replacement_idperson
                    WHERE R.deletests = '0' AND R.idcrewrotation = ?";
            $first = $this->db->query($sql, array($idcrewrotation))->row_array();
            if ($first) {
                $row = $first;
                $batch_id = isset($first['BatchID']) ? $first['BatchID'] : '';
                if ($batch_id !== '') {
                    $sqlBatch = "SELECT R.*, P.fullName AS onboard_name,
                            REPL.fullName AS replacement_name
                            FROM tblcrewrotation R
                            LEFT JOIN (
                                SELECT idperson, TRIM(CONCAT_WS(' ', fname, mname, lname)) AS fullName
                                FROM mstpersonal WHERE deletests = '0'
                            ) P ON P.idperson = R.idperson
                            LEFT JOIN (
                                SELECT idperson, TRIM(CONCAT_WS(' ', fname, mname, lname)) AS fullName
                                FROM mstpersonal WHERE deletests = '0'
                            ) REPL ON REPL.idperson = R.replacement_idperson
                            WHERE R.deletests = '0' AND R.BatchID = ?
                            ORDER BY R.idcrewrotation ASC";
                    $batch_rows = $this->db->query($sqlBatch, array($batch_id))->result_array();
                } else {
                    $batch_rows = array($first);
                }
            }
        }
        $data = array(
            'row'                    => $row,
            'batch_rows'             => $batch_rows,
            'batch_id'               => $batch_id,
            'optionsCompanyJson'     => json_encode($this->_getCompanyOptionsArray()),
            'optionsRankJson'        => json_encode($this->_getRankOptionsArray()),
            'optionsVesselJson'      => json_encode($this->_getVesselOptionsArray()),
            'optionsSignOffRemarkJson' => json_encode($this->_getSignOffRemarkOptionsArray()),
            'optionsPersonJson'      => json_encode($this->_getPersonOptionsArray()),
            'optionsPersonActiveRosterJson' => json_encode($this->_getPersonActiveRosterOptionsArray()),
        );
        $this->load->view('Roster/CrewRotation/crew_rotation_detail', $data);
    }

    /**
     * GET: Search person by name (for Off-signer). Returns list { idperson, fullName }.
     */
    public function searchPerson()
    {
        $q = $this->input->get('q');
        $q = trim($q);
        $out = array();
        if (strlen($q) < 2) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $out)));
            return;
        }
        $sql = "SELECT idperson, TRIM(CONCAT_WS(' ', fname, mname, lname)) AS fullName
                FROM mstpersonal
                WHERE deletests = '0' AND (fname != '' OR mname != '' OR lname != '')
                AND (CONCAT_WS(' ', fname, mname, lname) LIKE ? OR idperson LIKE ?)
                ORDER BY fullName ASC
                LIMIT 50";
        $term = '%' . $q . '%';
        $rows = $this->db->query($sql, array($term, $term))->result_array();
        foreach ($rows as $r) {
            $out[] = array('idperson' => $r['idperson'], 'fullName' => $r['fullName']);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode(array('success' => true, 'data' => $out)));
    }

    /**
     * GET: Latest contract for idperson (for Off-signer panel read-only).
     */
    public function getContractByPerson()
    {
        $idperson = $this->input->get('idperson');
        if (empty($idperson)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('success' => false, 'message' => 'idperson required'))
            );
            return;
        }
        $sql = "SELECT A.idcontract, A.idperson, A.signondt, A.signoffdt, A.estsignoffdt, A.signonport, A.estremark,
                A.signonrank, A.signonvsl,
                B.nmrank, C.nmvsl, E.nmremark AS signoffremark_name
                FROM tblcontract A
                LEFT JOIN mstrank B ON B.kdrank = A.signonrank AND B.deletests = '0'
                LEFT JOIN mstvessel C ON C.kdvsl = A.signonvsl AND C.deletests = '0'
                LEFT JOIN mstremark E ON E.kdremark = A.signoffremark AND E.deletests = '0'
                WHERE A.deletests = '0' AND A.idperson = ?
                ORDER BY A.idcontract DESC LIMIT 1";
        $row = $this->db->query($sql, array($idperson))->row_array();
        if (!$row) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('success' => false, 'message' => 'No contract found for this person'))
            );
            return;
        }
        $planned_signoff = isset($row['estsignoffdt']) && $row['estsignoffdt'] !== '0000-00-00' ? $row['estsignoffdt'] : (isset($row['signoffdt']) ? $row['signoffdt'] : '-');
        $status = (isset($row['signoffdt']) && $row['signoffdt'] !== '0000-00-00' && $row['signoffdt'] <= date('Y-m-d')) ? 'On Leave' : 'On Board';
        $signoffdt_fmt = (isset($row['signoffdt']) && $row['signoffdt'] !== '' && $row['signoffdt'] !== '0000-00-00') ? $row['signoffdt'] : '';
        $data = array(
            'idperson'         => $row['idperson'],
            'rank'             => isset($row['nmrank']) ? $row['nmrank'] : '-',
            'signonrank'       => isset($row['signonrank']) ? $row['signonrank'] : '',
            'signonvsl'        => isset($row['signonvsl']) ? $row['signonvsl'] : '',
            'signoffdt'        => $signoffdt_fmt,
            'planned_signoff'  => $planned_signoff,
            'relieving_port'   => isset($row['signonport']) ? $row['signonport'] : '-',
            'payscale'         => '-',
            'status'           => $status,
            'eoc'              => isset($row['signoffremark_name']) ? $row['signoffremark_name'] : '-',
            'remarks'          => isset($row['estremark']) ? $row['estremark'] : '-',
            'nmvsl'            => isset($row['nmvsl']) ? $row['nmvsl'] : '-',
        );
        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('success' => true, 'data' => $data))
        );
    }

    public function save_crewRotation()
    {
        $username = $this->session->userdata('userName') ?: 'system';
        $currentDate = date('Ymd/H:i:s');
        $idperson = $this->input->post('idperson');
        $replacement_idperson = $this->input->post('replacement_idperson');
        if (empty($idperson)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'Crew (idperson) is required'))
            );
            return;
        }
        $replacements = is_array($replacement_idperson) ? $replacement_idperson : ($replacement_idperson ? array($replacement_idperson) : array());
        $replacements = array_filter(array_map('trim', array_map('strval', $replacements)));
        if (empty($replacements)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'Replacement Candidate is required'))
            );
            return;
        }
        $is_double_up = (int) $this->input->post('is_double_up');
        $signoffdt = trim((string) $this->input->post('signoffdt'));
        $signoffremark = trim((string) $this->input->post('signoffremark'));
        $signoffdt_onsigner = trim((string) $this->input->post('signoffdt_onsigner'));
        $signoffremark_onsigner = trim((string) $this->input->post('signoffremark_onsigner'));
        $batch_id = 'CR-' . date('YmdHis') . '-' . substr(uniqid(), -4);
        $base = array(
            'idperson'              => $idperson,
            'BatchID'               => $batch_id,
            'is_double_up'          => $is_double_up ? 1 : 0,
            'kdcmprec'              => $this->input->post('kdcmprec') ?: null,
            'signondt'              => $this->input->post('signondt') ?: null,
            'signoffdt'             => ($signoffdt && $signoffdt !== '') ? $signoffdt : '0000-00-00',
            'estsignoffdt'          => $this->input->post('estsignoffdt') ?: null,
            'signonrank'            => $this->input->post('signonrank') ?: null,
            'signonvsl'             => $this->input->post('signonvsl') ?: null,
            'signonport'            => $this->input->post('signonport') ?: null,
            'signondesc'            => $this->input->post('signondesc') ?: null,
            'lastvsl'               => $this->input->post('lastvsl') ?: null,
            'no_pkl'                => $this->input->post('no_pkl') ?: null,
            'estremark'             => $this->input->post('estremark') ?: null,
            'signoffremark'         => ($signoffremark !== '') ? $signoffremark : null,
            'signoffdt_onsigner'    => ($signoffdt_onsigner !== '') ? $signoffdt_onsigner : '0000-00-00',
            'signoffremark_onsigner' => ($signoffremark_onsigner !== '') ? $signoffremark_onsigner : null,
            'replacement_rank'      => $this->input->post('replacement_rank') ?: null,
            'status'             => 'Submit',
            'next_vessel'        => $this->input->post('next_vessel') ?: null,
            'addusrdt'           => $username . '/' . $currentDate,
            'deletests'           => 0,
        );
        foreach ($replacements as $rid) {
            $row = $base;
            $row['replacement_idperson'] = $rid;
            $this->db->insert('tblcrewrotation', $row);
        }
        if (!$is_double_up && $signoffdt !== '' && $signoffdt !== '0000-00-00') {
            $this->_updateOffSignerContract($idperson, $signoffdt, $signoffremark);
        }
        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('status' => true, 'message' => 'Data saved successfully', 'batch_id' => $batch_id))
        );
    }

    public function update_crewRotation()
    {
        $idcrewrotation = $this->input->post('idcrewrotation');
        $batch_id = $this->input->post('batch_id');
        if (empty($idcrewrotation) && empty($batch_id)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'idcrewrotation or batch_id required'))
            );
            return;
        }
        $username = $this->session->userdata('userName') ?: 'system';
        $currentDate = date('Ymd/H:i:s');
        $is_double_up = (int) $this->input->post('is_double_up');
        $signoffdt_input = trim((string) $this->input->post('signoffdt'));
        $signoffremark_input = trim((string) $this->input->post('signoffremark'));
        $signoffdt_onsigner_input = trim((string) $this->input->post('signoffdt_onsigner'));
        $signoffremark_onsigner_input = trim((string) $this->input->post('signoffremark_onsigner'));
        $shared = array(
            'kdcmprec'                => $this->input->post('kdcmprec') ?: null,
            'signondt'                => $this->input->post('signondt') ?: null,
            'signoffdt'               => ($signoffdt_input !== '') ? $signoffdt_input : '0000-00-00',
            'estsignoffdt'            => $this->input->post('estsignoffdt') ?: null,
            'signonrank'              => $this->input->post('signonrank') ?: null,
            'signonvsl'               => $this->input->post('signonvsl') ?: null,
            'signonport'              => $this->input->post('signonport') ?: null,
            'signondesc'              => $this->input->post('signondesc') ?: null,
            'lastvsl'                 => $this->input->post('lastvsl') ?: null,
            'no_pkl'                  => $this->input->post('no_pkl') ?: null,
            'estremark'               => $this->input->post('estremark') ?: null,
            'signoffremark'           => ($signoffremark_input !== '') ? $signoffremark_input : null,
            'signoffdt_onsigner'      => ($signoffdt_onsigner_input !== '') ? $signoffdt_onsigner_input : '0000-00-00',
            'signoffremark_onsigner' => ($signoffremark_onsigner_input !== '') ? $signoffremark_onsigner_input : null,
            'replacement_rank'        => $this->input->post('replacement_rank') ?: null,
            'next_vessel'    => $this->input->post('next_vessel') ?: null,
            'is_double_up'   => $is_double_up ? 1 : 0,
            'updusrdt'       => $username . '/' . $currentDate,
        );
        $replacements = $this->input->post('replacement_idperson');
        $replacements = is_array($replacements) ? $replacements : ($replacements ? array($replacements) : array());
        $replacements = array_filter(array_map('trim', array_map('strval', $replacements)));

        // Normalize replacement ID for comparison (DB might return 4177, form sends 004177)
        $normalizeRid = function ($v) {
            $v = trim((string) $v);
            return $v === '' ? '' : str_pad($v, 6, '0', STR_PAD_LEFT);
        };

        if (!empty($batch_id)) {
            $batch_rows = $this->db->query("SELECT idcrewrotation, idperson, replacement_idperson, status FROM tblcrewrotation WHERE deletests = '0' AND BatchID = ?", array($batch_id))->result_array();
            // Debug: set to true to log to application/logs/log-*.php
            $debug_update_batch = isset($_GET['debug_batch']) || (defined('ENVIRONMENT') && ENVIRONMENT === 'development' && $this->input->post('debug_batch'));
            if ($debug_update_batch) {
                log_message('info', '[update_crewRotation] batch_id=' . $batch_id . ' replacements=' . json_encode($replacements) . ' batch_rows_count=' . count($batch_rows));
            }
            if (empty($batch_rows)) {
                $this->output->set_content_type('application/json')->set_output(
                    json_encode(array('status' => false, 'message' => 'Batch not found'))
                );
                return;
            }
            $idperson = $batch_rows[0]['idperson'];
            $existing_rids = array();
            foreach ($batch_rows as $br) {
                $key = $normalizeRid($br['replacement_idperson']);
                if ($key !== '') {
                    $existing_rids[$key] = array('idcrewrotation' => $br['idcrewrotation'], 'replacement_idperson' => $br['replacement_idperson']);
                }
            }
            $replacements_normalized = array();
            foreach ($replacements as $r) {
                $replacements_normalized[$normalizeRid($r)] = $r;
            }
            if ($debug_update_batch) {
                log_message('info', '[update_crewRotation] existing_rids_keys=' . json_encode(array_keys($existing_rids)) . ' replacements_normalized_keys=' . json_encode(array_keys($replacements_normalized)));
            }
            foreach ($batch_rows as $br) {
                $ridKey = $normalizeRid($br['replacement_idperson']);
                if (!array_key_exists($ridKey, $replacements_normalized)) {
                    if ($br['status'] !== 'Joined' && $br['status'] !== 'Cancel') {
                        $this->db->where('idcrewrotation', $br['idcrewrotation']);
                        $this->db->update('tblcrewrotation', array('deletests' => 1, 'updusrdt' => $username . '/' . $currentDate));
                    }
                } else {
                    $this->db->where('idcrewrotation', $br['idcrewrotation']);
                    $this->db->update('tblcrewrotation', array_merge($shared, array('replacement_idperson' => $br['replacement_idperson'])));
                }
            }
            foreach ($replacements_normalized as $ridKey => $ridValue) {
                if (!array_key_exists($ridKey, $existing_rids)) {
                    $ins = array(
                        'idperson' => $idperson,
                        'BatchID' => $batch_id,
                        'replacement_idperson' => $ridValue,
                        'status' => 'Submit',
                        'addusrdt' => $username . '/' . $currentDate,
                        'deletests' => 0,
                    );
                    foreach (array('kdcmprec', 'signondt', 'signoffdt', 'estsignoffdt', 'signonrank', 'signonvsl', 'signonport', 'signondesc', 'lastvsl', 'no_pkl', 'estremark', 'signoffremark', 'signoffdt_onsigner', 'signoffremark_onsigner', 'replacement_rank', 'next_vessel', 'is_double_up') as $k) {
                        $ins[$k] = isset($shared[$k]) ? $shared[$k] : null;
                    }
                    $this->db->insert('tblcrewrotation', $ins);
                }
            }
        } else {
            if (empty($replacements)) {
                $this->output->set_content_type('application/json')->set_output(
                    json_encode(array('status' => false, 'message' => 'Replacement Candidate is required'))
                );
                return;
            }
            $data = array_merge($shared, array(
                'replacement_idperson' => $replacements[0],
                'status'               => $this->input->post('status') ?: 'Submit',
            ));
            $this->db->where('idcrewrotation', $idcrewrotation);
            $this->db->update('tblcrewrotation', $data);
            if (strtoupper($data['status']) === 'Joined') {
                $this->_syncRotationToContract($idcrewrotation);
            }
        }
        $off_idperson = null;
        if (!empty($batch_id) && !empty($batch_rows)) {
            $off_idperson = $batch_rows[0]['idperson'];
        } elseif (!empty($idcrewrotation)) {
            $r = $this->db->query("SELECT idperson FROM tblcrewrotation WHERE idcrewrotation = ? AND deletests = '0'", array($idcrewrotation))->row();
            $off_idperson = $r ? $r->idperson : null;
        }
        if (!$is_double_up && $signoffdt_input !== '' && $signoffdt_input !== '0000-00-00' && $off_idperson) {
            $this->_updateOffSignerContract($off_idperson, $signoffdt_input, $signoffremark_input);
        }
        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('status' => true, 'message' => 'Data updated successfully'))
        );
    }

    public function updateStatus()
    {
        $idcrewrotation = $this->input->post('idcrewrotation');
        $status = $this->input->post('status');
        $remaks_cancel = trim($this->input->post('remaks_cancel') ?: '');
        if (empty($idcrewrotation) || empty($status)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'idcrewrotation and status required'))
            );
            return;
        }
        $status = ucfirst(strtolower($status));
        if (!in_array($status, array('Submit', 'Cancel', 'Joined'))) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'Invalid status'))
            );
            return;
        }
        $row = $this->db->query(
            "SELECT status, idcontract_synced, BatchID, idperson, signondt FROM tblcrewrotation WHERE idcrewrotation = ? AND deletests = '0'",
            array($idcrewrotation)
        )->row();
        if (!$row) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'Record not found'))
            );
            return;
        }
        $current_status = $row->status;
        $batch_id = isset($row->BatchID) ? trim($row->BatchID) : '';
        if ($current_status === 'Cancel') {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'Status sudah Cancel. Tidak dapat diubah. Harus buat data baru.'))
            );
            return;
        }
        if ($current_status === 'Joined' && $status === 'Submit') {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'Dari Joined tidak bisa kembali ke Submit. Data sudah masuk Contract. Hanya bisa di-Cancel jika dibatalkan.'))
            );
            return;
        }
        if ($status === 'Cancel') {
            $username = $this->session->userdata('userName') ?: 'system';
            $currentDate = date('Ymd/H:i:s');
            if ($remaks_cancel === '') {
                $this->output->set_content_type('application/json')->set_output(
                    json_encode(array('status' => false, 'message' => 'Reason Cancel wajib diisi.'))
                );
                return;
            }
            if ($batch_id !== '') {
                $batch_rows = $this->db->query("SELECT idcrewrotation, idcontract_synced FROM tblcrewrotation WHERE deletests = '0' AND BatchID = ?", array($batch_id))->result();
                foreach ($batch_rows as $br) {
                    if (!empty($br->idcontract_synced)) {
                        $this->db->where('idcontract', $br->idcontract_synced);
                        $this->db->update('tblcontract', array('deletests' => '1'));
                    }
                    $this->db->where('idcrewrotation', $br->idcrewrotation);
                    $this->db->update('tblcrewrotation', array(
                        'status'            => 'Cancel',
                        'remaks_cancel'     => $remaks_cancel,
                        'idcontract_synced' => null,
                        'updusrdt'          => $username . '/' . $currentDate,
                    ));
                }
            } else {
                if ($current_status === 'Joined' && !empty($row->idcontract_synced)) {
                    $this->db->where('idcontract', $row->idcontract_synced);
                    $this->db->update('tblcontract', array('deletests' => '1'));
                }
                $this->db->where('idcrewrotation', $idcrewrotation);
                $this->db->update('tblcrewrotation', array(
                    'status'            => 'Cancel',
                    'remaks_cancel'     => $remaks_cancel,
                    'idcontract_synced' => null,
                    'updusrdt'          => $username . '/' . $currentDate,
                ));
            }
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => true, 'message' => 'Status updated to Cancel successfully'))
            );
            return;
        }
        // Validasi kelengkapan data jika status = Joined
        if ($status === 'Joined') {
            $checkData = $this->db->query(
                "SELECT kdcmprec, signondt, estsignoffdt, signonrank, signonvsl, signonport, signondesc, no_pkl 
                 FROM tblcrewrotation 
                 WHERE idcrewrotation = ? AND deletests = '0'",
                array($idcrewrotation)
            )->row();
            if (!$checkData || 
                empty($checkData->kdcmprec) || 
                empty($checkData->signondt) || 
                empty($checkData->estsignoffdt) || 
                empty($checkData->signonrank) || 
                empty($checkData->signonvsl) || 
                empty($checkData->signonport) || 
                empty($checkData->signondesc)) 
                // empty($checkData->no_pkl)) 
                {
                $this->output->set_content_type('application/json')->set_output(
                    json_encode(array('status' => false, 'message' => 'Data belum lengkap untuk Joined. Lengkapi semua field wajib (Company, Sign on Date, Estimate Sign off Date, Rank, Vessel, Port, Description, No. PKL) via Edit terlebih dahulu.'))
                );
                return;
            }
        }

        $username = $this->session->userdata('userName') ?: 'system';
        $currentDate = date('Ymd/H:i:s');

        if ($status === 'Joined' && $batch_id !== '') {
            $others = $this->db->query("SELECT idcrewrotation FROM tblcrewrotation WHERE deletests = '0' AND BatchID = ? AND idcrewrotation != ?", array($batch_id, $idcrewrotation))->result_array();
            foreach ($others as $o) {
                $this->db->where('idcrewrotation', $o['idcrewrotation']);
                $this->db->update('tblcrewrotation', array(
                    'status'        => 'Cancel',
                    'remaks_cancel' => $remaks_cancel,
                    'updusrdt'      => $username . '/' . $currentDate,
                ));
            }
        }

        $this->db->where('idcrewrotation', $idcrewrotation);
        $this->db->update('tblcrewrotation', array(
            'status'   => $status,
            'updusrdt' => $username . '/' . $currentDate,
        ));
        if ($status === 'Joined') {
            $this->_syncRotationToContract($idcrewrotation);
        }
        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('status' => true, 'message' => 'Status updated successfully'))
        );
    }

    /**
     * Update Off Signer's tblcontract (MAX idcontract) with signoffdt and signoffremark.
     * Only updates active contract (signoffdt empty/null).
     */
    private function _updateOffSignerContract($idperson, $signoffdt, $signoffremark = '')
    {
        $signoffdt = trim((string) $signoffdt);
        if ($signoffdt === '' || $signoffdt === '0000-00-00') return;
        $off_contract = $this->db->query(
            "SELECT idcontract FROM tblcontract WHERE idperson = ? AND (signoffdt = '0000-00-00' OR signoffdt IS NULL OR signoffdt = '') AND deletests = '0' ORDER BY idcontract DESC LIMIT 1",
            array($idperson)
        )->row();
        if ($off_contract) {
            $upd = array('signoffdt' => $signoffdt);
            if ($signoffremark !== '') {
                $upd['signoffremark'] = $signoffremark;
            }
            $this->db->where('idcontract', $off_contract->idcontract);
            $this->db->update('tblcontract', $upd);
        }
    }

    private function _syncRotationToContract($idcrewrotation)
    {
        $check = $this->db->query(
            "SELECT idcontract_synced, idperson, signondt, is_double_up FROM tblcrewrotation WHERE idcrewrotation = ? AND deletests = '0'",
            array($idcrewrotation)
        )->row();
        if ($check && !empty($check->idcontract_synced)) {
            return;
        }
        $sql = "SELECT R.replacement_idperson, R.idperson, R.kdcmprec, R.signondt, R.signoffdt, R.estsignoffdt,
                R.signonrank, R.signonvsl, R.signonport, R.signondesc, R.lastvsl, R.no_pkl, R.estremark, R.signoffremark,
                R.signoffdt_onsigner, R.signoffremark_onsigner, R.is_double_up,
                L.nmvsl AS lastvsl_nmvsl
                FROM tblcrewrotation R
                LEFT JOIN mstvessel L ON L.kdvsl = R.lastvsl AND L.deletests = '0'
                WHERE R.idcrewrotation = ? AND R.deletests = '0'";
        $row = $this->db->query($sql, array($idcrewrotation))->row();
        if (!$row) return;

        $is_double_up = isset($row->is_double_up) ? (int)$row->is_double_up : 0;
        if (!$is_double_up && !empty($row->idperson)) {
            $signoffdt_val = ($row->signoffdt && $row->signoffdt !== '0000-00-00') ? $row->signoffdt : ($row->signondt && $row->signondt !== '0000-00-00' ? $row->signondt : null);
            if ($signoffdt_val) {
                $this->_updateOffSignerContract($row->idperson, $signoffdt_val, isset($row->signoffremark) ? $row->signoffremark : '');
            }
        }

        $r = $this->db->query("SELECT COALESCE(MAX(idcontract), 0) AS maxid FROM tblcontract")->row();
        $newId = (int)(isset($r->maxid) ? $r->maxid : 0) + 1;
        $username = $this->session->userdata('userName') ?: 'system';
        $currentDate = date('Ymd/H:i:s');
        $signoffdt_naik = isset($row->signoffdt_onsigner) && $row->signoffdt_onsigner && $row->signoffdt_onsigner !== '0000-00-00' ? $row->signoffdt_onsigner : '0000-00-00';
        $estsignoffdt = $row->estsignoffdt && $row->estsignoffdt !== '0000-00-00' ? $row->estsignoffdt : '0000-00-00';
        $signoffremark_naik = isset($row->signoffremark_onsigner) ? $row->signoffremark_onsigner : '';
        $lastvsl_for_contract = !empty($row->lastvsl_nmvsl) ? $row->lastvsl_nmvsl : ($row->lastvsl ?: '');
        $data = array(
            'idcontract'    => $newId,
            'idperson'      => $row->replacement_idperson,
            'kdcmprec'      => $row->kdcmprec,
            'signondt'      => $row->signondt,
            'signoffdt'     => $signoffdt_naik,
            'estsignoffdt'  => $estsignoffdt,
            'signonrank'    => $row->signonrank ?: '',
            'signonvsl'     => $row->signonvsl ?: '',
            'signonport'    => $row->signonport ?: '',
            'signondesc'    => $row->signondesc ?: '',
            'lastvsl'       => $lastvsl_for_contract,
            'no_pkl'        => $row->no_pkl ?: '',
            'estremark'     => $row->estremark ?: '',
            'signoffremark' => $signoffremark_naik ?: '',
            'idcontractRepl'=>  $newId,
            'additional'    => 0,
            'foreigncrew'   => 0,
            'file_contract' => '',
            'deletests'     => '0',
            'addusrdt'      => $username . '/' . $currentDate,
        );
        $this->db->insert('tblcontract', $data);
        $this->db->where('idcrewrotation', $idcrewrotation);
        $this->db->update('tblcrewrotation', array('idcontract_synced' => $newId));
    }

    public function delete_crewRotation()
    {
        $idcrewrotation = $this->input->post('idcrewrotation');
        if (empty($idcrewrotation)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'idcrewrotation required'))
            );
            return;
        }
        $username = $this->session->userdata('userName') ?: 'system';
        $currentDate = date('Ymd/H:i:s');
        $this->db->where('idcrewrotation', $idcrewrotation);
        $this->db->update('tblcrewrotation', array(
            'deletests' => 1,
            'updusrdt' => $username . '/' . $currentDate,
        ));
        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('status' => true, 'message' => 'Data deleted successfully'))
        );
    }

    public function getHistoryByPerson()
    {
        $idperson = $this->input->get('idperson');
        if (empty($idperson)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('success' => false, 'data' => array(), 'message' => 'idperson required'))
            );
            return;
        }
        $sql = "SELECT R.idcrewrotation, R.idperson, R.BatchID, R.signondt, R.estsignoffdt, R.estremark, R.remaks_cancel, R.status, R.next_vessel,
                R.signonrank, R.signonvsl, R.replacement_rank, R.replacement_idperson,
                P.fullName AS onboard_name, C.nmrank AS onboard_rank_name, D.nmvsl AS onboard_vessel_name,
                REPL.fullName AS replacement_name, NXVSL.nmvsl AS next_vessel_name
                FROM tblcrewrotation R
                LEFT JOIN (
                    SELECT idperson, TRIM(CONCAT_WS(' ', fname, mname, lname)) AS fullName
                    FROM mstpersonal WHERE deletests = '0'
                ) P ON P.idperson = R.idperson
                LEFT JOIN mstrank C ON C.kdrank = R.signonrank AND C.deletests = '0'
                LEFT JOIN mstvessel D ON D.kdvsl = R.signonvsl AND D.deletests = '0'
                LEFT JOIN (
                    SELECT idperson, TRIM(CONCAT_WS(' ', fname, mname, lname)) AS fullName
                    FROM mstpersonal WHERE deletests = '0'
                ) REPL ON REPL.idperson = R.replacement_idperson
                LEFT JOIN mstvessel NXVSL ON NXVSL.kdvsl = R.next_vessel AND NXVSL.deletests = '0'
                WHERE R.deletests = '0' AND R.idperson = ?
                ORDER BY R.signondt DESC, R.idcrewrotation DESC";
        $rows = $this->db->query($sql, array($idperson))->result_array();
        $data = array();
        foreach ($rows as $row) {
            $data[] = array(
                'idcrewrotation'   => $row['idcrewrotation'],
                'batch_id'        => isset($row['BatchID']) ? $row['BatchID'] : '',
                'onboard_name'     => isset($row['onboard_name']) ? $row['onboard_name'] : '',
                'onboard_rank'     => isset($row['onboard_rank_name']) ? $row['onboard_rank_name'] : '',
                'onboard_son'      => $row['signondt'] && $row['signondt'] !== '0000-00-00' ? date('d M Y', strtotime($row['signondt'])) : '-',
                'onboard_vessel'   => isset($row['onboard_vessel_name']) ? $row['onboard_vessel_name'] : '',
                'onboard_soff'     => $row['estsignoffdt'] && $row['estsignoffdt'] !== '0000-00-00' ? date('d M Y', strtotime($row['estsignoffdt'])) : '-',
                'remark'           => isset($row['estremark']) ? $row['estremark'] : '',
                'remarks_cancel'   => isset($row['remaks_cancel']) ? $row['remaks_cancel'] : '',
                'replacement_rank' => isset($row['replacement_rank']) ? $row['replacement_rank'] : '-',
                'replacement_name' => isset($row['replacement_name']) ? $row['replacement_name'] : '-',
                'status'          => $row['status'],
                'next_vessel'     => isset($row['next_vessel_name']) && $row['next_vessel_name'] ? $row['next_vessel_name'] : (isset($row['next_vessel']) ? $row['next_vessel'] : ''),
            );
        }

        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('success' => true, 'data' => $data))
        );
    }
}



