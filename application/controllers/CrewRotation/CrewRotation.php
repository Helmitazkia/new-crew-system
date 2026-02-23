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
        $sql = "SELECT R.idcrewrotation, R.idperson, R.kdcmprec, R.signondt, R.signoffdt, R.estsignoffdt,
                R.signonrank, R.signonvsl, R.signonport, R.signondesc, R.lastvsl, R.no_pkl, R.estremark,
                R.signoffremark, R.replacement_idperson, R.replacement_rank, R.status, R.next_vessel,
                P.fullName AS onboard_name,
                C.nmrank AS onboard_rank_name,
                D.nmvsl AS onboard_vessel_name,
                B.nmcmp AS company_name,
                REPL.fullName AS replacement_name
                FROM tblcrewrotation R
                LEFT JOIN (
                    SELECT idperson, TRIM(CONCAT_WS(' ', fname, mname, lname)) AS fullName
                    FROM mstpersonal WHERE deletests = '0'
                ) P ON P.idperson = R.idperson
                LEFT JOIN mstcmprec B ON B.kdcmp = R.kdcmprec AND B.deletests = '0'
                LEFT JOIN mstrank C ON C.kdrank = R.signonrank AND C.deletests = '0'
                LEFT JOIN mstvessel D ON D.kdvsl = R.signonvsl AND D.deletests = '0'
                LEFT JOIN (
                    SELECT idperson, TRIM(CONCAT_WS(' ', fname, mname, lname)) AS fullName
                    FROM mstpersonal WHERE deletests = '0'
                ) REPL ON REPL.idperson = R.replacement_idperson
                WHERE R.deletests = '0'
                ORDER BY R.signondt DESC, R.idcrewrotation DESC";
        $rows = $this->db->query($sql)->result_array();
        $data = array();
        foreach ($rows as $row) {
            $data[] = array(
                'idcrewrotation'    => $row['idcrewrotation'],
                'idperson'          => $row['idperson'],
                'onboard_name'      => isset($row['onboard_name']) ? $row['onboard_name'] : '',
                'onboard_rank'      => isset($row['onboard_rank_name']) ? $row['onboard_rank_name'] : '',
                'onboard_son'       => $row['signondt'] && $row['signondt'] !== '0000-00-00' ? date('d M Y', strtotime($row['signondt'])) : '-',
                'onboard_vessel'    => isset($row['onboard_vessel_name']) ? $row['onboard_vessel_name'] : '',
                'onboard_soff'     => $row['estsignoffdt'] && $row['estsignoffdt'] !== '0000-00-00' ? date('d M Y', strtotime($row['estsignoffdt'])) : '-',
                'remark'           => isset($row['estremark']) ? $row['estremark'] : '',
                'replacement_rank' => isset($row['replacement_rank']) ? $row['replacement_rank'] : '-',
                'replacement_name' => isset($row['replacement_name']) ? $row['replacement_name'] : '-',
                'status'           => $row['status'],
                'next_vessel'      => isset($row['next_vessel']) ? $row['next_vessel'] : '',
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
        if (!empty($idcrewrotation)) {
            $sql = "SELECT R.*, P.fullName AS onboard_name
                    FROM tblcrewrotation R
                    LEFT JOIN (
                        SELECT idperson, TRIM(CONCAT_WS(' ', fname, mname, lname)) AS fullName
                        FROM mstpersonal WHERE deletests = '0'
                    ) P ON P.idperson = R.idperson
                    WHERE R.deletests = '0' AND R.idcrewrotation = ?";
            $row = $this->db->query($sql, array($idcrewrotation))->row_array();
        }
        $data = array(
            'row'                    => $row,
            'optionsCompanyJson'     => json_encode($this->_getCompanyOptionsArray()),
            'optionsRankJson'        => json_encode($this->_getRankOptionsArray()),
            'optionsVesselJson'      => json_encode($this->_getVesselOptionsArray()),
            'optionsSignOffRemarkJson' => json_encode($this->_getSignOffRemarkOptionsArray()),
            'optionsPersonJson'      => json_encode($this->_getPersonOptionsArray()),
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
        $data = array(
            'idperson'         => $row['idperson'],
            'rank'             => isset($row['nmrank']) ? $row['nmrank'] : '-',
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
        if (empty($replacement_idperson)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'Replacement Candidate is required'))
            );
            return;
        }
        $data = array(
            'idperson'             => $idperson,
            'kdcmprec'             => $this->input->post('kdcmprec') ?: null,
            'signondt'             => $this->input->post('signondt') ?: null,
            'signoffdt'            => $this->input->post('signoffdt') ?: '0000-00-00',
            'estsignoffdt'         => $this->input->post('estsignoffdt') ?: null,
            'signonrank'           => $this->input->post('signonrank') ?: null,
            'signonvsl'            => $this->input->post('signonvsl') ?: null,
            'signonport'           => $this->input->post('signonport') ?: null,
            'signondesc'           => $this->input->post('signondesc') ?: null,
            'lastvsl'              => $this->input->post('lastvsl') ?: null,
            'no_pkl'               => $this->input->post('no_pkl') ?: null,
            'estremark'            => $this->input->post('estremark') ?: null,
            'signoffremark'        => $this->input->post('signoffremark') ?: null,
            'replacement_idperson' => $this->input->post('replacement_idperson') ?: null,
            'replacement_rank'     => $this->input->post('replacement_rank') ?: null,
            'status'               => $this->input->post('status') ?: 'Submit',
            'next_vessel'          => $this->input->post('next_vessel') ?: null,
            'addusrdt'             => $username . '/' . $currentDate,
            'deletests'            => 0,
        );
        $this->db->insert('tblcrewrotation', $data);
        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('status' => true, 'message' => 'Data saved successfully'))
        );
    }

    public function update_crewRotation()
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
        $status = $this->input->post('status') ?: 'Submit';
        $data = array(
            'kdcmprec'             => $this->input->post('kdcmprec') ?: null,
            'signondt'             => $this->input->post('signondt') ?: null,
            'signoffdt'            => $this->input->post('signoffdt') ?: '0000-00-00',
            'estsignoffdt'         => $this->input->post('estsignoffdt') ?: null,
            'signonrank'           => $this->input->post('signonrank') ?: null,
            'signonvsl'            => $this->input->post('signonvsl') ?: null,
            'signonport'           => $this->input->post('signonport') ?: null,
            'signondesc'           => $this->input->post('signondesc') ?: null,
            'lastvsl'              => $this->input->post('lastvsl') ?: null,
            'no_pkl'               => $this->input->post('no_pkl') ?: null,
            'estremark'            => $this->input->post('estremark') ?: null,
            'signoffremark'        => $this->input->post('signoffremark') ?: null,
            'replacement_idperson' => $this->input->post('replacement_idperson') ?: null,
            'replacement_rank'     => $this->input->post('replacement_rank') ?: null,
            'status'               => $status,
            'next_vessel'          => $this->input->post('next_vessel') ?: null,
            'updusrdt'             => $username . '/' . $currentDate,
        );

        $this->db->where('idcrewrotation', $idcrewrotation);
        $this->db->update('tblcrewrotation', $data);
        if (strtoupper($status) === 'Joined') {
            $this->_syncRotationToContract($idcrewrotation);
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
            "SELECT status, idcontract_synced FROM tblcrewrotation WHERE idcrewrotation = ? AND deletests = '0'",
            array($idcrewrotation)
        )->row();
        if (!$row) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'Record not found'))
            );
            return;
        }
        $current_status = $row->status;
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
            // Remarks Cancel tidak mandatory (bisa kosong)
            $username = $this->session->userdata('userName') ?: 'system';
            $currentDate = date('Ymd/H:i:s');
            if ($current_status === 'Joined' && !empty($row->idcontract_synced)) {
                $this->db->where('idcontract', $row->idcontract_synced);
                $this->db->update('tblcontract', array('deletests' => '1'));
                $this->db->where('idcrewrotation', $idcrewrotation);
                $this->db->update('tblcrewrotation', array(
                    'status'            => 'Cancel',
                    'remaks_cancel'     => $remaks_cancel,
                    'idcontract_synced' => null,
                    'updusrdt'          => $username . '/' . $currentDate,
                ));
            } else {
                $this->db->where('idcrewrotation', $idcrewrotation);
                $this->db->update('tblcrewrotation', array(
                    'status'        => 'Cancel',
                    'remaks_cancel' => $remaks_cancel,
                    'updusrdt'      => $username . '/' . $currentDate,
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
                empty($checkData->signondesc) || 
                empty($checkData->no_pkl)) {
                $this->output->set_content_type('application/json')->set_output(
                    json_encode(array('status' => false, 'message' => 'Data belum lengkap untuk Joined. Lengkapi semua field wajib (Company, Sign on Date, Estimate Sign off Date, Rank, Vessel, Port, Description, No. PKL) via Edit terlebih dahulu.'))
                );
                return;
            }
        }
        
        $username = $this->session->userdata('userName') ?: 'system';
        $currentDate = date('Ymd/H:i:s');
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

    private function _syncRotationToContract($idcrewrotation)
    {
        $check = $this->db->query(
            "SELECT idcontract_synced FROM tblcrewrotation WHERE idcrewrotation = ? AND deletests = '0'",
            array($idcrewrotation)
        )->row();
        if ($check && !empty($check->idcontract_synced)) {
            return;
        }
        $sql = "SELECT idperson, kdcmprec, signondt, signoffdt, estsignoffdt, signonrank, signonvsl,
                signonport, signondesc, lastvsl, no_pkl, estremark, signoffremark
                FROM tblcrewrotation WHERE idcrewrotation = ? AND deletests = '0'";
        $row = $this->db->query($sql, array($idcrewrotation))->row();
        if (!$row) return;
        $this->db->select_max('idcontract');
        $q = $this->db->get('tblcontract');
        $r = $q->row();
        $newId = ($r && $r->idcontract) ? (int)$r->idcontract + 1 : 1;
        $username = $this->session->userdata('userName') ?: 'system';
        $currentDate = date('Ymd/H:i:s');
        $signoffdt = $row->signoffdt && $row->signoffdt !== '0000-00-00' ? $row->signoffdt : '0000-00-00';
        $estsignoffdt = $row->estsignoffdt && $row->estsignoffdt !== '0000-00-00' ? $row->estsignoffdt : '0000-00-00';
        $data = array(
            'idcontract'    => $newId,
            'idperson'      => $row->idperson,
            'kdcmprec'      => $row->kdcmprec,
            'signondt'      => $row->signondt,
            'signoffdt'     => $signoffdt,
            'estsignoffdt'  => $estsignoffdt,
            'signonrank'    => $row->signonrank ?: '',
            'signonvsl'     => $row->signonvsl ?: '',
            'signonport'    => $row->signonport ?: '',
            'signondesc'    => $row->signondesc ?: '',
            'lastvsl'       => $row->lastvsl ?: '',
            'no_pkl'        => $row->no_pkl ?: '',
            'estremark'     => $row->estremark ?: '',
            'signoffremark' => $row->signoffremark ?: '',
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
        $sql = "SELECT R.idcrewrotation, R.idperson, R.signondt, R.estsignoffdt, R.estremark, R.status, R.next_vessel,
                R.signonrank, R.signonvsl, R.replacement_rank, R.replacement_idperson,
                P.fullName AS onboard_name, C.nmrank AS onboard_rank_name, D.nmvsl AS onboard_vessel_name,
                REPL.fullName AS replacement_name
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
                WHERE R.deletests = '0' AND R.idperson = ?
                ORDER BY R.signondt DESC, R.idcrewrotation DESC";
        $rows = $this->db->query($sql, array($idperson))->result_array();
        $data = array();
        foreach ($rows as $row) {
            $data[] = array(
                'idcrewrotation'   => $row['idcrewrotation'],
                'onboard_name'     => isset($row['onboard_name']) ? $row['onboard_name'] : '',
                'onboard_rank'     => isset($row['onboard_rank_name']) ? $row['onboard_rank_name'] : '',
                'onboard_son'      => $row['signondt'] && $row['signondt'] !== '0000-00-00' ? date('d M Y', strtotime($row['signondt'])) : '-',
                'onboard_vessel'   => isset($row['onboard_vessel_name']) ? $row['onboard_vessel_name'] : '',
                'onboard_soff'     => $row['estsignoffdt'] && $row['estsignoffdt'] !== '0000-00-00' ? date('d M Y', strtotime($row['estsignoffdt'])) : '-',
                'remark'           => isset($row['estremark']) ? $row['estremark'] : '',
                'replacement_rank' => isset($row['replacement_rank']) ? $row['replacement_rank'] : '-',
                'replacement_name' => isset($row['replacement_name']) ? $row['replacement_name'] : '-',
                'status'          => $row['status'],
                'next_vessel'      => isset($row['next_vessel']) ? $row['next_vessel'] : '',
            );
        }

        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('success' => true, 'data' => $data))
        );
    }
}



