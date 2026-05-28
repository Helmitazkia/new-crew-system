<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SuntechoPKL extends CI_Controller {

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
        $this->load->view('ListReport/SuntechoPKL/view_pkl_suntecho');
    }

    function getVesselByOption()
    {
        $typeVal   = isset($_GET['typeVal']) ? $_GET['typeVal'] : '';
        $searchNya = isset($_GET['searchNya']) ? $_GET['searchNya'] : '';

        $whereNya = "deletests = '0' AND st_display = 'Y'";

        if ($searchNya != "" && $searchNya != "017") {
            $whereNya .= " AND kdcmp = '".$searchNya."' ";
        }
        if ($typeVal != "") {
            $whereNya .= " AND kdvsl = '".$typeVal."' ";
        }

        $rsl = $this->MCrewscv->getData("*", "mstvessel", $whereNya, "nmvsl ASC");

        $vesselData = array();
        foreach ($rsl as $val) {
            $vesselData[] = array(
                'kdvsl'       => $val->kdvsl,
                'nmvsl'       => $val->nmvsl,
                'nmcmp'       => $val->nmcmp, 
                'imo'         => !empty($val->imo) ? trim($val->imo) : '',
                'grt'         => !empty($val->grt) ? trim($val->grt) : '',
                'serpel'      => !empty($val->serpel) ? trim($val->serpel) : '',
                'safety_cert' => !empty($val->descvsl) ? trim($val->descvsl) : '',
                'st_own'      => $val->st_own
            );
        }

        echo json_encode(array(
            'success' => true,
            'data'    => $vesselData
        ));
    }

    function getPKL($id = "")
    {
        if ($id == "") {
            echo json_encode(array('success' => false, 'message' => 'ID Person tidak ditemukan.'));
            return;
        }

        $sql = "
            SELECT 
                TRIM(CONCAT(p.fname, ' ', p.mname, ' ', p.lname)) AS fullname,
                p.dob,
                k.NmKota AS pob,
                p.idperson,
                p.nationalid AS nationality,
                p.paddress,
                p.telpno,
                p.applyfor,
                p.vesselfor,
                p.kodepelaut,
                p.passportno,
                p.seamanbookno
            FROM mstpersonal p
            LEFT JOIN tblkota k ON k.KdKota = p.pob
            LEFT JOIN tblcertdoc c ON c.idperson = p.idperson AND c.deletests = 0
            LEFT JOIN tblcontract ct 
                ON ct.idperson = p.idperson
                AND ct.deletests = 'N'
                AND ct.signondt = (
                    SELECT MAX(signondt)
                    FROM tblcontract
                    WHERE idperson = p.idperson
                    AND deletests = 'N'
                )
            LEFT JOIN mstrank r ON r.kdrank = ct.signonrank
            WHERE p.idperson = '".$id."' AND p.deletests = 0
            GROUP BY 
                p.fname, p.mname, p.lname, p.dob, k.NmKota, 
                p.idperson, p.nationalid, p.paddress, p.telpno, 
                p.applyfor, p.vesselfor, p.kodepelaut, r.nmrank
        ";

        $dataCrew = $this->MCrewscv->getDataQuery($sql);

        if (empty($dataCrew)) {
            echo json_encode(array('success' => false, 'message' => 'Data crew tidak ditemukan untuk ID: ' . $id));
            return;
        }

        $crew = $dataCrew[0];

        echo json_encode(array(
            'success' => true,
            'crew' => array(
                'idperson'      => $crew->idperson,
                'fullname'      => $crew->fullname,
                'dob'           => $crew->dob,
                'pob'           => $crew->pob,
                'kodepelaut'    => $crew->kodepelaut,
                'address'       => $crew->paddress,
                'passportno'    => $crew->passportno,
                'seamanbookno'  => $crew->seamanbookno,
                'vesselfor'     => $crew->vesselfor,
            )
        ));
    }

    function get_history()
    {
        $idperson = $this->input->post('idperson', true);

        $this->db->select("h.*, CONCAT_WS(' ', p.fname, p.mname, p.lname) as fullname", FALSE);
        $this->db->from('history_suntecho_pkl_wages h');
        $this->db->join('mstpersonal p', 'p.idperson = h.idperson', 'left');
        $this->db->where('h.deleted_status', '0');

        if (!empty($idperson)) {
            $this->db->where('h.idperson', $idperson);
        }

        $this->db->order_by('h.id_history_wages', 'DESC');
        $data = $this->db->get()->result();

        $result = array();
        foreach ($data as $row) {
            $row->created_at_fmt = !empty($row->created_at)
                ? date('d M Y H:i', strtotime($row->created_at))
                : '-';
            $result[] = $row;
        }

        echo json_encode(array(
            'success' => true,
            'data'    => $result
        ));
    }

    function get_history_detail($id = "")
    {
        if ($id == "") {
            echo json_encode(array('success' => false, 'message' => 'ID tidak ditemukan.'));
            return;
        }

        $sql = "
            SELECT 
                h.*, TRIM(CONCAT(p.fname, ' ', p.mname, ' ', p.lname)) AS fullname
            FROM history_suntecho_pkl_wages h
            LEFT JOIN mstpersonal p ON p.idperson = h.idperson
            WHERE h.id_history_wages = '".$id."' 
            AND h.deleted_status = '0'
            LIMIT 1
        ";

        $data = $this->MCrewscv->getDataQuery($sql);

        if (empty($data)) {
            echo json_encode(array('success' => false, 'message' => 'Data detail PKL tidak ditemukan.'));
            return;
        }

        echo json_encode(array(
            'success' => true,
            'data'    => $data[0]
        ));
    }

    function PrintPKL($id = "")
    {
        if ($id == "") {
            echo json_encode(array('success' => false, 'message' => 'ID tidak ditemukan.'));
            return;
        }

        $dataOut = array();
        $isHistory = false;

        // Check if $id is numeric (history ID)
        if (is_numeric($id)) {
            $sqlPKL = "
                SELECT *
                FROM history_suntecho_pkl_wages
                WHERE id_history_wages = '".$id."' 
                AND deleted_status = '0'
                LIMIT 1
            ";
            $pklData = $this->MCrewscv->getDataQuery($sqlPKL);
            if (!empty($pklData)) {
                $isHistory = true;
                $pkl = $pklData[0];
            }
        }

        if ($isHistory) {
            // Get st_own from mstpersonal joined with mstvessel
            $sqlPersonal = "
                SELECT v.st_own, TRIM(CONCAT_WS(' ', p.fname, p.mname, p.lname)) AS fullname 
                FROM mstpersonal p
                LEFT JOIN mstvessel v ON v.kdvsl = p.vesselfor AND v.deletests = 0
                WHERE p.idperson = '".$pkl->idperson."' AND p.deletests = 0 
                LIMIT 1
            ";
            $personalData = $this->MCrewscv->getDataQuery($sqlPersonal);
            $st_own = !empty($personalData) ? $personalData[0]->st_own : '';
            $fullname = !empty($personalData) ? $personalData[0]->fullname : '';

            if (!empty($st_own) && $st_own === "Y") {
                $dataOut['crewing_position'] = "CREWING MANAGER";
            } else {
                $dataOut['crewing_position'] = "HEAD OF CREWING DIVISION";
            }

            $crew = (object) array(
                'fullname'        => $fullname,
                'dob'             => $pkl->dob,
                'pob'             => $pkl->pob,
                'idperson'        => $pkl->idperson,
                'nationality'     => '',
                'duration'        => $pkl->duration_months,
                'paddress'        => $pkl->address,
                'telpno'          => '',
                'applyfor'        => $pkl->applyfor ?: '-',
                'vessel_name'     => $pkl->vessel_name ?: '',
                'company_name'    => $pkl->company_name ?: '',
                'flag'            => $pkl->flag ?: '',
                'imo'             => $pkl->imo ?: '',
                'grt_hp'          => $pkl->grt_hp ?: '',
                'competency_cert' => $pkl->competency_cert ?: '',
                'safety_cert'     => $pkl->safety_cert ?: '',
                'seafarer_code'   => $pkl->seafarer_code,
                'passportno'      => $pkl->passport_no,
                'seamanbookno'    => $pkl->seaman_book_no
            );

            $dataOut['crew'] = $crew;
            $dataOut['idPerson'] = $pkl->idperson;

            $dataOut['salary'] = (object) array(
                'basic'  => (int)$pkl->basic_wage,
                'fix'    => (int)$pkl->fix_overtime,
                'leave'  => (int)$pkl->leave_pay,
                'tanker' => (int)$pkl->tanker_allowance,
                'total'  => (int)$pkl->total_wage,
                'duration_months' => $pkl->duration_months
            );
        } else {
            // Error handling if data not found in history, as suntecho should always use history
            echo json_encode(array('success' => false, 'message' => 'Data history PKL tidak ditemukan untuk ID: ' . $id));
            return;
        }

        require("application/views/frontend/pdf/mpdf60/mpdf.php");

        $mpdf = new mPDF('utf-8', 'A4');

        ob_start();
        $this->load->view('ListReport/SuntechoPKL/form_pkl_suntecho', $dataOut);
        $html = ob_get_contents();
        ob_end_clean();

        $mpdf->WriteHTML($html);
        $mpdf->Output("PKL_Suntecho_" . $dataOut['crew']->fullname . ".pdf", 'I');
        exit;
    } 

    function saveVesselData()
    {
        $idperson          = $this->input->post('idperson');
        $dob               = $this->input->post('dob');
        $kodepelaut        = $this->input->post('kodepelaut');
        $passportno        = $this->input->post('passportno');
        $seamanbookno      = $this->input->post('seamanbookno');
        $address           = $this->input->post('paddress');
        $txtVesselFor      = $this->input->post('txtVesselFor');
        $flag              = $this->input->post('flag');
        $imo               = $this->input->post('imo');
        $grt_hp            = trim($this->input->post('grt_hp'));
        $txtSafetyCert     = $this->input->post('txtSafetyCert');
        $txtCompetencyCert = $this->input->post('txtCompetencyCert');
        
        $txtBasicWage      = (int)str_replace('.', '', $this->input->post('txtBasicWage'));
        $txtFixOvertime    = (int)str_replace('.', '', $this->input->post('txtFixOvertime'));
        $txtLeavePay       = (int)str_replace('.', '', $this->input->post('txtLeavePay'));
        $txtduration       = $this->input->post('txtduration');
        $txtTankerAllowance= (int)str_replace('.', '', $this->input->post('txtTankerAllowance'));

        $username = $this->session->userdata('userName');
        $date = date('Y-m-d H:i:s');

        if (empty($idperson)) {
            echo json_encode(array('success' => false, 'message' => 'ID Person kosong'));
            return;
        }

        $sqlCrew = "
            SELECT 
                TRIM(CONCAT(p.fname, ' ', p.mname, ' ', p.lname)) AS fullname,
                p.dob, k.NmKota AS pob, p.paddress,
                p.telpno, p.applyfor
            FROM mstpersonal p
            LEFT JOIN tblkota k ON k.KdKota = p.pob
            WHERE p.idperson = '".$idperson."' AND p.deletests = 0
            LIMIT 1
        ";
        $crewData = $this->MCrewscv->getDataQuery($sqlCrew);
        if (empty($crewData)) {
            echo json_encode(array('success' => false, 'message' => 'Data crew tidak ditemukan'));
            return;
        }
        $crew = $crewData[0];

        $sqlVessel = "
            SELECT 
                v.kdvsl, v.nmvsl, v.imo, v.grt, v.serpel AS competency_cert,
                v.descvsl AS safety_cert,
                c.nmcmp AS company_name
            FROM mstvessel v
            LEFT JOIN mstcmprec c ON c.kdcmp = v.kdcmp AND c.deletests = 0
            WHERE v.kdvsl = '".$txtVesselFor."' AND v.deletests = 0
            LIMIT 1
        ";
        
        $vesselData = $this->MCrewscv->getDataQuery($sqlVessel);
        $companyName = '';
        $vesselName = '';

        if (!empty($vesselData)) {
            $vesselName = $vesselData[0]->nmvsl;
            $companyName = $vesselData[0]->company_name;
            if (empty($flag)) $flag = 'INDONESIA';
            if (empty($imo)) $imo = $vesselData[0]->imo;
            if (empty($grt_hp)) $grt_hp = $vesselData[0]->grt;
            if (empty($txtCompetencyCert)) $txtCompetencyCert = $vesselData[0]->competency_cert;
            if (empty($txtSafetyCert)) $txtSafetyCert = $vesselData[0]->safety_cert;
        }

        $this->db = $this->load->database('default', TRUE);

        $updateData = array(
            'dob'             => $dob,
            'kodepelaut'      => $kodepelaut,
            'paddress'        => $address,
            'passportno'      => $passportno,
            'seamanbookno'    => $seamanbookno,
            'vesselfor'       => $txtVesselFor,
            'duration'        => $txtduration,
            'flag'            => $flag,
            'imo'             => $imo,
            'grt_hp'          => $grt_hp,
            'competency_cert' => $txtCompetencyCert,
            'safety_cert'     => $txtSafetyCert,
            'updusrdt'        => $username . "#" . $date
        );
        $this->db->where('idperson', $idperson);
        $this->db->update('mstpersonal', $updateData);

        $totalWage = $txtBasicWage + $txtFixOvertime + $txtLeavePay + $txtTankerAllowance;

        $insertData = array(
            'idperson'        => $idperson,
            'vessel_name'     => $vesselName,
            'company_name'    => $companyName,
            'basic_wage'      => $txtBasicWage,
            'fix_overtime'    => $txtFixOvertime,
            'leave_pay'       => $txtLeavePay,
            'tanker_allowance'=> $txtTankerAllowance,
            'total_wage'      => $totalWage,
            'duration_months' => $txtduration,
            'dob'             => $dob,
            'pob'             => $crew->pob,
            'seafarer_code'   => $kodepelaut,
            'address'         => $address,
            'passport_no'     => $passportno,
            'seaman_book_no'  => $seamanbookno,
            'flag'            => $flag,
            'imo'             => $imo,
            'grt_hp'          => $grt_hp,
            'competency_cert' => $txtCompetencyCert,
            'safety_cert'     => $txtSafetyCert,
            'applyfor'        => $crew->applyfor,
            'created_by'      => $username,
            'created_at'      => $date,
            'updated_at'      => $date,
            'deleted_status'  => '0'
        );

        $insert = $this->db->insert('history_suntecho_pkl_wages', $insertData);
        $insertedId = $this->db->insert_id();

        if ($insert) {
            echo json_encode(array(
                'success' => true,
                'message' => 'Data kapal & gaji berhasil disimpan',
                'vessel_name' => $vesselName,
                'company_name' => $companyName,
                'data_saved' => array(
                    'total_wage' => $totalWage,
                    'inserted_id' => $insertedId
                )
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'Gagal menyimpan data'
            ));
        }
    }

    function updateVesselData()
    {
        $id_history_wages  = $this->input->post('id_history_wages');
        $idperson          = $this->input->post('idperson');
        $dob               = $this->input->post('dob');
        $kodepelaut        = $this->input->post('kodepelaut');
        $passportno        = $this->input->post('passportno');
        $seamanbookno      = $this->input->post('seamanbookno');
        $address           = $this->input->post('paddress');
        $txtVesselFor      = $this->input->post('txtVesselFor');
        $flag              = $this->input->post('flag');
        $imo               = $this->input->post('imo');
        $grt_hp            = trim($this->input->post('grt_hp'));
        $txtSafetyCert     = $this->input->post('txtSafetyCert');
        $txtCompetencyCert = $this->input->post('txtCompetencyCert');
        
        $txtBasicWage      = (int)str_replace('.', '', $this->input->post('txtBasicWage'));
        $txtFixOvertime    = (int)str_replace('.', '', $this->input->post('txtFixOvertime'));
        $txtLeavePay       = (int)str_replace('.', '', $this->input->post('txtLeavePay'));
        $txtduration       = $this->input->post('txtduration');
        $txtTankerAllowance= (int)str_replace('.', '', $this->input->post('txtTankerAllowance'));

        $username = $this->session->userdata('userName');
        $date = date('Y-m-d H:i:s');

        if (empty($id_history_wages)) {
            echo json_encode(array('success' => false, 'message' => 'ID History PKL kosong'));
            return;
        }

        $sqlCrew = "
            SELECT 
                TRIM(CONCAT(p.fname, ' ', p.mname, ' ', p.lname)) AS fullname,
                p.dob, k.NmKota AS pob, p.paddress,
                p.telpno, p.applyfor, p.kodepelaut, p.passportno, p.seamanbookno
            FROM mstpersonal p
            LEFT JOIN tblkota k ON k.KdKota = p.pob
            WHERE p.idperson = '".$idperson."' AND p.deletests = 0
            LIMIT 1
        ";
        $crewData = $this->MCrewscv->getDataQuery($sqlCrew);
        if (empty($crewData)) {
            echo json_encode(array('success' => false, 'message' => 'Data crew tidak ditemukan'));
            return;
        }
        $crew = $crewData[0];

        if (empty($dob)) $dob = $crew->dob;
        if (empty($kodepelaut)) $kodepelaut = $crew->kodepelaut;
        if (empty($passportno)) $passportno = $crew->passportno;
        if (empty($seamanbookno)) $seamanbookno = $crew->seamanbookno;
        if (empty($address)) $address = $crew->paddress;

        $sqlVessel = "
            SELECT 
                v.kdvsl, v.nmvsl, v.imo, v.grt, v.serpel AS competency_cert,
                v.descvsl AS safety_cert,
                c.nmcmp AS company_name
            FROM mstvessel v
            LEFT JOIN mstcmprec c ON c.kdcmp = v.kdcmp AND c.deletests = 0
            WHERE v.kdvsl = '".$txtVesselFor."' AND v.deletests = 0
            LIMIT 1
        ";
        
        $vesselData = $this->MCrewscv->getDataQuery($sqlVessel);
        
        // Fallback to POST data if the vessel was a custom text option from history
        $vesselName = $this->input->post('vessel_name');
        $companyName = $this->input->post('company_name');

        if (!empty($vesselData)) {
            $vesselName = $vesselData[0]->nmvsl;
            $companyName = $vesselData[0]->company_name;
            if (empty($flag)) $flag = 'INDONESIA';
            if (empty($imo)) $imo = $vesselData[0]->imo;
            if (empty($grt_hp)) $grt_hp = $vesselData[0]->grt;
            if (empty($txtCompetencyCert)) $txtCompetencyCert = $vesselData[0]->competency_cert;
            if (empty($txtSafetyCert)) $txtSafetyCert = $vesselData[0]->safety_cert;
        }

        $this->db = $this->load->database('default', TRUE);

        $totalWage = $txtBasicWage + $txtFixOvertime + $txtLeavePay + $txtTankerAllowance;

        $updateDataHistory = array(
            'vessel_name'     => $vesselName,
            'company_name'    => $companyName,
            'basic_wage'      => $txtBasicWage,
            'fix_overtime'    => $txtFixOvertime,
            'leave_pay'       => $txtLeavePay,
            'tanker_allowance'=> $txtTankerAllowance,
            'total_wage'      => $totalWage,
            'duration_months' => $txtduration,
            'dob'             => $dob,
            'seafarer_code'   => $kodepelaut,
            'address'         => $address,
            'passport_no'     => $passportno,
            'seaman_book_no'  => $seamanbookno,
            'flag'            => $flag,
            'imo'             => $imo,
            'grt_hp'          => $grt_hp,
            'competency_cert' => $txtCompetencyCert,
            'safety_cert'     => $txtSafetyCert,
            'updated_at'      => $date
        );

        $this->db->where('id_history_wages', $id_history_wages);
        $update = $this->db->update('history_suntecho_pkl_wages', $updateDataHistory);

        if ($update) {
            echo json_encode(array(
                'success' => true,
                'message' => 'Data kapal & gaji berhasil diupdate',
                'vessel_name' => $vesselName,
                'company_name' => $companyName,
                'data_saved' => array(
                    'total_wage' => $totalWage,
                    'inserted_id' => $id_history_wages
                )
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'Gagal mengupdate data'
            ));
        }
    }

    function deletePKL()
    {
        $id_history_wages = $this->input->post('id_history_wages');
        $this->db = $this->load->database('default', TRUE);

        if (empty($id_history_wages)) {
            echo json_encode(array('success' => false, 'message' => 'ID tidak ditemukan'));
            return;
        }

        $updateData = array(
            'deleted_status' => '1',
            'updated_at'     => date('Y-m-d H:i:s')
        );

        $this->db->where('id_history_wages', $id_history_wages);
        $result = $this->db->update('history_suntecho_pkl_wages', $updateData);

        if ($result) {
            echo json_encode(array(
                'success' => true,
                'message' => 'Data PKL berhasil dihapus'
            ));
        } else {
            echo json_encode(array(
                'success' => false,
                'message' => 'Gagal menghapus data'
            ));
        }
    }
}
