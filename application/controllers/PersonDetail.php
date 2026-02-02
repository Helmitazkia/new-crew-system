<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PersonDetail extends CI_Controller {

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

    public function index($idperson = '')
    {
        if (empty($idperson)) {
            show_error('ID Person not found');
        }

        $dataContext = new DataContext();
        $optCountry  = $dataContext->getCountryByOption("", "kode");
        $optCity     = $dataContext->getCityByOption("", "kode");
        $optTax = $dataContext->getTaxByOption();
        $optBlood = $dataContext->getBloodType();
        $optSize= $dataContext->getUkuran();
		$optVessel= $dataContext->getVesselType("");
        $vesselname = $dataContext->getVesselByOption("","name","");
        $optRank = $dataContext->getMstRankByOptionWithSelected("","");

        $data = array(
            'title'        => 'Active Roster',
            'active_menu'  => 'crew_roster',
            'content'      => 'CrewDetail/profile',
            'idperson'     => $idperson,
            'optCountry'   => $optCountry,
            'optCity'      => $optCity,
            'optTax'       => $optTax,
            'optBlood'     => $optBlood,
            'optSize'      => $optSize,
            'optVessel' => $optVessel,
            'optRank'      => $optRank,
            'vesselname'   => $vesselname
            
        );

        $this->load->view('menu/main_detail_person', $data);
    }


    function getCountryNameById($id)
    {
        if (empty($id)) return '';

        $id = $this->db->escape($id);

        $sql = "
            SELECT NmNegara
            FROM tblnegara
            WHERE Deletests = '0'
            AND KdNegara = $id
            LIMIT 1
        ";

        $rsl = $this->db->query($sql)->row();

        return $rsl ? $rsl->NmNegara : '';
    }


    function getCityNameById($id)
    {
        if (empty($id)) return '';

        $id = $this->db->escape($id);

        $sql = "
            SELECT NmKota
            FROM tblkota
            WHERE Deletests = '0'
            AND KdKota = $id
            LIMIT 1
        ";

        $rsl = $this->db->query($sql)->row();

        return $rsl ? $rsl->NmKota : '';
    }



 public function getDataProses()
    {
        $dataContext = new DataContext();
        $id   = $this->input->post('id', true);
        $type = $this->input->post('type', true);


        $this->output->set_content_type('application/json');

        if ($type != 'editProses' || empty($id)) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Invalid parameter'
            ));
            return;
        }

        $sql = "SELECT * FROM mstpersonal 
                WHERE deletests = '0' 
                AND idperson = ?";
        
        $rsl = $this->db->query($sql, array($id))->result();

        if (count($rsl) == 0) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Data not found'
            ));
            return;
        }

        $row = $rsl[0];
        $dataContext = new DataContext();

        $data = array(

            /* ================= BASIC IDENTITY ================= */
            'identity' => array(
                'idperson'     => $row->idperson,
                'oldCrewId'     => $row->oldcrewid,
                'oldContractNo' => $row->oldcontno,
                'seafarerCode'  => $row->kodepelaut,
                'firstName'     => trim($row->fname),
                'middleName'    => trim($row->mname),
                'lastName'      => trim($row->lname),
                'fullName'      => trim(preg_replace('/\s+/', ' ',
                                    $row->fname.' '.$row->mname.' '.$row->lname)),
                'gender'        => $row->gender,
                'nationality'   => $this->getCountryNameById($row->nationalid),
                'countryOrigin' => $this->getCountryNameById($row->ctryOfOrgn),
                'dob' => !empty($row->dob)
                    ? date('d M Y', strtotime($row->dob))
                    : '0000-00-00',
                'dobForEdit' => !empty($row->dob)  // Tambah field ini
                ? date('Y-m-d', strtotime($row->dob))
                : '',
                'pob'           => $dataContext->getCityNameById($row->pob),
                'religion'      => $row->religion,
                'maritalStatus' => $row->maritalstsid
            ),

            /* ================= FAMILY ================= */
            'family' => array(
                'fatherName' => $row->fathernm,
                'motherName' => $row->mothernm,
                'wifeName'   => $row->wname,
                'nextOfKin'  => $row->next_of_kin
            ),

            /* ================= LEGAL & TAX ================= */
            'legal' => array(
                'ssn'        => $row->ssn,
                'ssnCountry' =>  $this->getCountryNameById($row->ssnctryid),
                'taxNumber'  => $row->ptn,
                'taxCountry' => $this->getCountryNameById($row->ptnctryid),
                'taxStatus'  => $dataContext->getTaxStatusById($row->taxstsid)
            ),

            /* ================= CONTACT ================= */
            'contact' => array(
                'address'  => $row->paddress,
                'city'     => $dataContext->getCityNameById($row->pcity),
                'postcode' => $row->ppostcode,
                'country'  =>  $this->getCountryNameById($row->pctryid),
                'airport'  => $dataContext->getCityNameById($row->pnrstport),
                'mobile'   => $row->mobileno,
                'home'     => $row->telpno,
                'fax'      => $row->faxno,
                'email'    => $row->email
            ),

             /* ================= PHYSICAL ================= */
            'physical' => array(
                'bloodType'    => $row->golDrh,
                'eyeColor'     => $row->eyecol,
                'weight'       => $row->wght,
                'height'       => $row->hght,
                'shoe'         => $row->shoesz,
                'collar'       => $row->collar,
                'chest'        => $row->chest,
                'waist'        => $row->waist,
                'insideLeg'    => $row->Insdleg,
                'cap'          => $row->cap,
                'clothesSize'  => $row->clothszid,
                'sweaterSize'  => $row->sweaterszid,
                'boilerSize'   => $row->boilerszid,
                'allergy'      => $row->alergy,
                'heightPhobia' => (strtolower($row->heightphob) == 'y') ? 'Yes' : 'No',
                'claustrophob' => (strtolower($row->claustrophob) == 'y') ? 'Yes' : 'No',
            ),

            /* ================= ASSESSMENT ================= */
            'assessment' => array(
                'cesScore'    => $row->scorces,
                'marlinScore' => $row->scormarlintes,
                'trainingDate'=> $row->ismdate,
                'evaluation'  => $row->ismeval
            ),

            /* ================= CAREER ================= */
            'career' => array(
                'rankApply'     => $row->applyfor,
                'vesselApply'   => $row->vesselfor,
                'vesselType'    => $row->crew_vessel_type,
                'availableDate' => $row->availdt,
                'lowerRank'     => (strtolower($row->lower_rank) == 'y') ? 'Yes' : 'No',
            ),

            

           

            /* ================= SALARY ================= */
            'salary' => array(
                'home' => array(
                    'bank'       => $row->bank_name,
                    'accountNo'  => $row->norek,
                    'accountName'=> $row->norek_name,
                    'percentage' => $row->percentage_home_salary
                ),
                'board' => array(
                    'bank'       => $row->bank_name_boat,
                    'accountNo'  => $row->norek_boat,
                    'accountName'=> $row->norek_name_boat,
                    'percentage' => $row->percentage_board_salary
                )
            ),

            /* ================= FILES ================= */
            'files' => array(
                'photo'     => $row->pic,
                'wages'     => $row->file_statement_wages,
                'interview' => $row->file_interview,
                'evaluation'=> $row->file_evaluation,
                'statement' => $row->file_statement
            ),

            /* ================= CREW STATUS ================= */
            'crewStatus' => array(
                'newApplicant' => ($row->newapplicent == "1"),
                'nonAktif'     => ($row->inAktif == "1"),
                'blackList'    => ($row->inBlacklist == "1"),
                'nonCrew'      => ($row->noncrew == "1")
            ),

            /* ================= CONTACT METHOD ================= */
            'contactMethod' => array(
                'email'  => ($row->conmthEmail),
                'fax'    => ($row->conmthFax),
                'mobile' => ($row->conmthMob),
                'home'   => ($row->conmthHom),
                'post'   => ($row->conmthPost)
            ),

            /* ================= DECLARATION ================= */
            'declaration' => array(
                'signPlace' => $row->signplc,
                'signDate'  => $row->signdt,
                'remarks'   => $row->remarks
            )
        );



        echo json_encode(array(
            'status' => true,
            'data'   => $data
        ));


    }


public function updateBasicIdentity() {
    $idperson = $this->input->post('idperson');
    
    // Get all post data
    $oldCrewId = $this->input->post('oldCrewId');
    $oldContractNo = $this->input->post('oldContractNo');
    $seafarerCode = $this->input->post('seafarerCode');
    $firstName = $this->input->post('firstName');
    $middleName = $this->input->post('middleName');
    $lastName = $this->input->post('lastName');
    $gender = $this->input->post('gender');
    $nationality = $this->input->post('nationality'); // Ini ID negara
    $countryOrigin = $this->input->post('countryOrigin'); // Ini ID negara
    $dob = $this->input->post('dob');
    $pob = $this->input->post('pob'); // Ini ID kota
    $religion = $this->input->post('religion');
    $maritalStatus = $this->input->post('maritalStatus');
    
    // Validasi required fields
    if (!$idperson || !$firstName || !$lastName || !$gender) {
        echo json_encode(array(
            'status' => false,
            'message' => 'Required fields are missing'
        ));
        return;
    }
    
    // Ambil username dan timestamp
    $username = $this->session->userdata('username') ?: 'system';
    $currentDate = date('Y-m-d H:i:s');
    
    // Prepare data untuk update
    $data = array(
        'oldcrewid' => $oldCrewId,
        'oldcontno' => $oldContractNo,
        'kodepelaut' => $seafarerCode,
        'fname' => $firstName,
        'mname' => $middleName,
        'lname' => $lastName,
        'gender' => $gender,
        'dob' => $dob,
        'religion' => $religion,
        'maritalstsid' => $maritalStatus,
        'updusrdt' => $currentDate . ' - ' . $username
    );

    // var_dump($data);exit;
    
    // Handle nationality (convert dari nama negara ke ID jika perlu)
    if (!empty($nationality)) {
        // Jika $nationality adalah nama negara, cari ID-nya
        // Jika sudah ID, langsung assign
        if (is_numeric($nationality)) {
            $data['nationalid'] = $nationality;
        } else {
            // Cari ID berdasarkan nama negara
            $country = $this->db->get_where('tblnegara', array(
                'NmNegara' => $nationality,
                'Deletests' => '0'
            ))->row();
            if ($country) {
                $data['nationalid'] = $country->KdNegara;
            }
        }
    }
    
    // Handle country of origin (sama seperti nationality)
    if (!empty($countryOrigin)) {
        if (is_numeric($countryOrigin)) {
            $data['ctryOfOrgn'] = $countryOrigin;
        } else {
            $country = $this->db->get_where('tblnegara', array(
                'NmNegara' => $countryOrigin,
                'Deletests' => '0'
            ))->row();
            if ($country) {
                $data['ctryOfOrgn'] = $country->KdNegara;
            }
        }
    }
    
    // Handle place of birth (kota)
    if (!empty($pob)) {
        if (is_numeric($pob)) {
            $data['pob'] = $pob;
        } else {
            $city = $this->db->get_where('tblkota', array(
                'NmKota' => $pob,
                'Deletests' => '0'
            ))->row();
            if ($city) {
                $data['pob'] = $city->KdKota;
            }
        }
    }
    
    // Update data
    $this->db->where('idperson', $idperson);
    $this->db->where('deletests', '0');
    $this->db->update('mstpersonal', $data);
    
    if ($this->db->affected_rows() > 0) {
        echo json_encode(array(
            'status' => true,
            'message' => 'Basic identity updated successfully'
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


public function updateFamilyInfo() {
    $idperson = $this->input->post('idperson');
    $fatherName = $this->input->post('fatherName');
    $motherName = $this->input->post('motherName');
    $wifeName = $this->input->post('wifeName');
    $address = $this->input->post('address');
    $nextOfKin = $this->input->post('nextOfKin');
    
    // Validasi
    if (!$idperson) {
        echo json_encode(array(
            'status' => false,
            'message' => 'ID Person is required'
        ));
        return;
    }
    
    // Ambil username dan timestamp
    $username = $this->session->userdata('username') ?: 'system';
    $currentDate = date('Y-m-d H:i:s');
    
    // Data untuk update
    $data = array(
        'fathernm' => $fatherName,
        'mothernm' => $motherName,
        'wname' => $wifeName,
        'next_of_kin' => $nextOfKin,
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