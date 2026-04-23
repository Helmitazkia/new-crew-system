<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Family extends CI_Controller {

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
        $this->load->view('CrewDetail/family');
    }

    public function getFamilyData()
    {
        $idPerson = $this->input->post('idperson');

        if (!$idPerson) {
            echo json_encode(array(
                'status' => false,
                'message' => 'ID Person not found'
            ));
            return;
        }

        // 1. Ambil data dari mstpersonal (father, mother, wife)
        $sqlPersonal = "SELECT 
                            fathernm, 
                            mothernm, 
                            wname, 
                            next_of_kin,
                            famaddrs
                        FROM mstpersonal 
                        WHERE idperson = ?
                        AND deletests = '0'";
        
        $personalData = $this->db->query($sqlPersonal, array($idPerson))->row();
        
        // 2. Ambil data children dari tblfamily
        $sqlFamily = "SELECT 
                        idfm, idperson, fmrel,
                        CASE 
                            WHEN fmsex = '1' THEN 'Male'
                            WHEN fmsex = '2' THEN 'Female'
                        END AS gender,
                        fmfname, fmlname, fmdob,
                        fmpassno, fmissdt, fmplc, fmexpdt, fmvisa
                    FROM tblfamily
                    WHERE idperson = ?
                    AND Deletests = '0'
                    AND UPPER(fmrel) = 'CHILD'
                    ORDER BY fmfname ASC";
        
        $childrenData = $this->db->query($sqlFamily, array($idPerson))->result();
        
        // 3. Format response seperti di getDataProses()
        $familyData = array(
            'father' => array(
                'fullName' => $personalData ? $personalData->fathernm : '',
                'name' => $personalData ? $personalData->fathernm : ''
            ),
            'mother' => array(
                'fullName' => $personalData ? $personalData->mothernm : '',
                'name' => $personalData ? $personalData->mothernm : ''
            ),
            'wife' => array(
                'fullName' => $personalData ? $personalData->wname : '',
                'name' => $personalData ? $personalData->wname : ''
            ),
            'nextOfKin' => $personalData ? $personalData->next_of_kin : '',
            'address' => $personalData ? $personalData->famaddrs : '',
            'children' => array()
        );
        
        // 4. Format children data
        foreach ($childrenData as $child) {
            $firstName = trim($child->fmfname);
            $lastName = trim($child->fmlname);
            $fullName = trim($firstName . ' ' . $lastName);
            
            $familyData['children'][] = array(
                'idfm' => $child->idfm,
                'firstName' => $firstName,
                'lastName' => $lastName,
                'fullName' => $fullName,
                'gender' => $child->gender,
                'dob' => !empty($child->fmdob) && $child->fmdob != '0000-00-00' 
                        ? date('d M Y', strtotime($child->fmdob)) 
                        : '-',
                'passportNo' => $child->fmpassno,
                'issueDate' => !empty($child->fmissdt) && $child->fmissdt != '0000-00-00' 
                            ? date('d M Y', strtotime($child->fmissdt)) 
                            : '-',
                'issuePlace' => $child->fmplc,
                'expiryDate' => !empty($child->fmexpdt) && $child->fmexpdt != '0000-00-00' 
                                ? date('d M Y', strtotime($child->fmexpdt)) 
                                : '-',
                'visa' => $child->fmvisa
            );
        }

        echo json_encode(array(
            'status' => true,
            'data'   => $familyData
        ));
    }

public function saveChild() {
    $idfm = $this->input->post('idfm');
    $idperson = $this->input->post('idperson');
    $fmrel = $this->input->post('fmrel');
    $fmsex = $this->input->post('fmsex');
    $fmfname = $this->input->post('fmfname');
    $fmlname = $this->input->post('fmlname');
    $fmdob = $this->input->post('fmdob');
    $fmpassno = $this->input->post('fmpassno');
    $fmissdt = $this->input->post('fmissdt');
    $fmplc = $this->input->post('fmplc');
    $fmexpdt = $this->input->post('fmexpdt');
    $fmvisa = $this->input->post('fmvisa');
    
    // Validasi required fields
    if (empty($idperson) || empty($fmfname) || empty($fmsex)) {
        echo json_encode(array(
            'status' => false,
            'message' => 'Required fields are missing'
        ));
        return;
    }
    
    // Ambil username dari session atau default
    $username = $this->session->userdata('userName') ?: 'system';

    $currentDate = date('Y-m-d H:i:s');
    
    $data = array(
        'idperson' => $idperson,
        'fmrel' => !empty($fmrel) ? strtoupper($fmrel) : 'CHILD',
        'fmsex' => $fmsex,
        'fmfname' => $fmfname,
        'fmlname' => $fmlname,
        'fmdob' => !empty($fmdob) ? $fmdob : '',
        'fmpassno' => $fmpassno,
        'fmissdt' => !empty($fmissdt) ? $fmissdt : '',
        'fmplc' => $fmplc,
        'fmexpdt' => !empty($fmexpdt) ? $fmexpdt : '',
        'fmvisa' => $fmvisa,
        'deletests' => '0'
    );
    
    if (empty($idfm)) {
        // CREATE NEW
        // Generate ID (contoh: CH + timestamp + random)
        $newId = 'CH' . date('YmdHis') . rand(100, 999);
        $data['idfm'] = $newId;
        
        // Tambahkan field untuk create
        $data['addusrdt'] = $currentDate;
        // Jika ada field untuk user yang create, tambahkan:
        // $data['addusr'] = $username;
        
        $this->db->insert('tblfamily', $data);
        $insertId = $newId;
        
        $message = 'Child added successfully';
    } else {
        // UPDATE EXISTING
        // Hapus field create jika ada
        unset($data['addusrdt']);
        // unset($data['addusr']);
        
        // Tambahkan field untuk update
        $data['updusrdt'] = $username . '-' . $currentDate;
        // Jika ada field untuk user yang update, tambahkan:
        // $data['updusr'] = $username;

        //var_dump($data); // Debugging line to check data being updated
        
        $this->db->where('idfm', $idfm);
        $this->db->update('tblfamily', $data);
        $insertId = $idfm;
        
        $message = 'Child updated successfully';
    }
    
    if ($this->db->affected_rows() > 0) {
        echo json_encode(array(
            'status' => true,
            'message' => $message,
            'data' => array('idfm' => $insertId)
        ));
    } else {
        echo json_encode(array(
            'status' => false,
            'message' => 'No changes made or failed to save child data'
        ));
    }
}


// Method untuk get data child (untuk edit)
public function getChildData() {
    $idfm = $this->input->post('idfm');
    $idperson = $this->input->post('idperson');
    
    if (!$idfm) {
        echo json_encode(array(
            'status' => false,
            'message' => 'Child ID not found'
        ));
        return;
    }
    
    $sql = "SELECT 
                idfm, idperson, fmrel, fmsex,
                fmfname, fmlname, fmdob,
                fmpassno, fmissdt, fmplc, fmexpdt, fmvisa
            FROM tblfamily
            WHERE idfm = ? AND idperson = ?
            AND deletests = '0'";
    
    $query = $this->db->query($sql, array($idfm, $idperson));
    
    if ($query->num_rows() > 0) {
        $row = $query->row();
        
        // Format tanggal untuk ditampilkan di input date
        $fmdob_formatted = (!empty($row->fmdob) && $row->fmdob != '0000-00-00') ? $row->fmdob : '';
        $fmissdt_formatted = (!empty($row->fmissdt) && $row->fmissdt != '0000-00-00') ? $row->fmissdt : '';
        $fmexpdt_formatted = (!empty($row->fmexpdt) && $row->fmexpdt != '0000-00-00') ? $row->fmexpdt : '';
        
        echo json_encode(array(
            'status' => true,
            'data' => array(
                'idfm' => $row->idfm,
                'idperson' => $row->idperson,
                'fmrel' => $row->fmrel,
                'fmsex' => $row->fmsex,
                'fmfname' => $row->fmfname,
                'fmlname' => $row->fmlname,
                'fmdob' => $fmdob_formatted,
                'fmpassno' => $row->fmpassno,
                'fmissdt' => $fmissdt_formatted,
                'fmplc' => $row->fmplc,
                'fmexpdt' => $fmexpdt_formatted,
                'fmvisa' => $row->fmvisa
            )
        ));
    } else {
        echo json_encode(array(
            'status' => false,
            'message' => 'Child data not found'
        ));
    }
}

// Method untuk delete child
public function deleteChild() {
    $idfm = $this->input->post('idfm');
    
    if (!$idfm) {
        echo json_encode(array(
            'status' => false,
            'message' => 'Child ID not found'
        ));
        return;
    }
    
    // Soft delete
    $data = array(
        'deletests' => '1',
        'delusrdt' => date('Y-m-d H:i:s'),
        // Jika ada field untuk user yang delete, tambahkan:
        // 'delusr' => $this->session->userdata('username') ?: 'system'
    );
    
    $this->db->where('idfm', $idfm);
    $this->db->update('tblfamily', $data);
    
    if ($this->db->affected_rows() > 0) {
        echo json_encode(array(
            'status' => true,
            'message' => 'Child deleted successfully'
        ));
    } else {
        echo json_encode(array(
            'status' => false,
            'message' => 'Failed to delete child or child already deleted'
        ));
    }
}

public function updateFamilyInfo() {
    $idperson = $this->input->post('idperson');
    $fatherName = $this->input->post('fatherName');
    $motherName = $this->input->post('motherName');
    $wifeName = $this->input->post('wifeName');
    $address = $this->input->post('address');
    
    // Validasi
    if (!$idperson) {
        echo json_encode(array(
            'status' => false,
            'message' => 'ID Person is required'
        ));
        return;
    }
    
    // Ambil username dan timestamp
    $username = $this->session->userdata('userName') ?: 'system';
    $currentDate = date('Y-m-d H:i:s');
    
    // Data untuk update
    $data = array(
        'fathernm' => $fatherName,
        'mothernm' => $motherName,
        'wname' => $wifeName,
        'famaddrs' => $address,
        'updusrdt' => $currentDate . ' - ' . $username // Format sesuai request Anda
    );
    
    // Update data di mstpersonal
    $this->db->where('idperson', $idperson);
    $this->db->where('deletests', '0');
    $this->db->update('mstpersonal', $data);
    
    if ($this->db->affected_rows() > 0) {
        echo json_encode(array(
            'status' => true,
            'message' => 'Family information updated successfully'
        ));
    } else {
        // Cek apakah data person exists
        $checkPerson = $this->db->get_where('mstpersonal', array(
            'idperson' => $idperson,
            'deletests' => '0'
        ))->row();
        
        if (!$checkPerson) {
            echo json_encode(array(
                'status' => false,
                'message' => 'Person data not found'
            ));
        } else {
            echo json_encode(array(
                'status' => true,
                'message' => 'No changes made (data already up to date)'
            ));
        }
    }
}

}
?>