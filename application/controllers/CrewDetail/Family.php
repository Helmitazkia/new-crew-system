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

    // public function getFamilyData()
    // {
    //     $idPerson = $this->input->post('idperson');

    //     if (!$idPerson) {
    //         echo json_encode(array(
    //             'status' => false,
    //             'message' => 'ID Person not found'
    //         ));
    //         return;
    //     }

    //     $sql = "
    //         SELECT 
    //             idfm, idperson, fmrel,
    //             CASE 
    //                 WHEN fmsex = '1' THEN 'Male'
    //                 WHEN fmsex = '2' THEN 'Female'
    //             END AS gender,
    //             fmfname, fmlname, fmdob,
    //             fmpassno, fmissdt, fmplc, fmexpdt, fmvisa
    //         FROM tblfamily
    //         WHERE idperson = '".$idPerson."'
    //         AND Deletests = '0'
    //         ORDER BY fmrel, fmfname ASC
    //     ";

    //     $result = $this->MCrewscv->getDataQuery($sql);

    //     echo json_encode(array(
    //         'status' => true,
    //         'data'   => $result
    //     ));
    // }


    // public function getDataProses()
    // {
    //     $dataContext = new DataContext();
    //     $id   = $this->input->post('id', true);
    //     $type = $this->input->post('type', true);


    //     $this->output->set_content_type('application/json');

    //     if ($type != 'editProses' || empty($id)) {
    //         echo json_encode(array(
    //             'status'  => false,
    //             'message' => 'Invalid parameter'
    //         ));
    //         return;
    //     }

    //     $sql = "SELECT * FROM mstpersonal 
    //             WHERE deletests = '0' 
    //             AND idperson = ?";
        
    //     $rsl = $this->db->query($sql, array($id))->result();

    //     if (count($rsl) == 0) {
    //         echo json_encode(array(
    //             'status'  => false,
    //             'message' => 'Data not found'
    //         ));
    //         return;
    //     }

    //     $row = $rsl[0];
    //     $dataContext = new DataContext();

    //     $data = array(
    //         'family' => array(
    //             'fatherName' => $row->fathernm,
    //             'motherName' => $row->mothernm,
    //             'wifeName'   => $row->wname,
    //             'nextOfKin'  => $row->next_of_kin,
    //             'paddress'  => $row->paddress,
    //             'pcity'     => $row->pcity,
    //         )
    //     );
    //     echo json_encode(array(
    //         'status' => true,
    //         'data'   => $data
    //     ));


    // }

}
?>