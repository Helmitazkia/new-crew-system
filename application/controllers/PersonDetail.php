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
                'maritalStatus' => $row->maritalstsid,
                'pictureProfile'         => $row->pic
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
                'shoesz'         => $row->shoesz,
                'collar'       => $row->collar,
                'chest'        => $row->chest,
                'waist'        => $row->waist,
                'Insdleg'    => $row->Insdleg,
                'cap'          => $row->cap,
                'clothesSize'  => $row->clothszid,
                'sweaterSize'  => $row->sweaterszid,
                'boilerszid'   => $row->boilerszid,
                'allergy'      => $row->alergy,
                'heightPhobia' => (strtolower($row->heightphob) == 'y') ? 'Yes' : 'No',
                'claustrophob' => (strtolower($row->claustrophob) == 'y') ? 'Yes' : 'No',
            ),

            /* ================= ASSESSMENT ================= */
            'assessment' => array(
                'cesScore'       => $row->scorces,
                'marlinScore'    => $row->scormarlintes,
                'psychometricScore' => isset($row->scor_psychometric) ? $row->scor_psychometric : '',
                'otgScore'       => isset($row->scor_otg) ? $row->scor_otg : '',
                'trainingDate'   => !empty($row->ismdate) && $row->ismdate !== '0000-00-00' ? date('d M Y', strtotime($row->ismdate)) : '',
                'trainingDateForEdit' => !empty($row->ismdate) && $row->ismdate !== '0000-00-00' ? date('Y-m-d', strtotime($row->ismdate)) : '',
                'evaluation'     => $row->ismeval
            ),

            /* ================= CAREER ================= */
            'career' => array(
                'rankApply'     => $row->applyfor,
                'vesselApply'   => $row->vesselfor,
                'vesselType'    => $row->crew_vessel_type,
                'availableDate' => date("d-M-Y", strtotime($row->availdt)),
                'edt_availableDate' => $row->availdt,
                'lowerRank'     => (strtolower($row->lower_rank) == '1') ? 'Yes' : 'No',
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
                'signDate'  => date("d-M-Y", strtotime($row->signdt)),
                'edt_signDate' => $row->signdt,
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
        

        $oldCrewId = $this->input->post('oldCrewId');
        $oldContractNo = $this->input->post('oldContractNo');
        $seafarerCode = $this->input->post('seafarerCode');
        $firstName = $this->input->post('firstName');
        $middleName = $this->input->post('middleName');
        $lastName = $this->input->post('lastName');
        $gender = $this->input->post('gender');
        $nationality = $this->input->post('nationality');
        $countryOrigin = $this->input->post('countryOrigin');
        $dob = $this->input->post('dob');
        $pob = $this->input->post('pob'); 
        $religion = $this->input->post('religion');
        $maritalStatus = $this->input->post('maritalStatus');
        

        if (!$idperson || !$firstName || !$gender) {
            echo json_encode(array(
                'status' => false,
                'message' => 'Required fields are missing'
            ));
            return;
        }
        

        $username = $this->session->userdata('username') ?: 'system';
        $currentDate = date('Y-m-d H:i:s');
        

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
 
        // Handle nationality (convert dari nama negara ke ID jika perlu)
        if (!empty($nationality)) {
            if (is_numeric($nationality)) {
                $data['nationalid'] = $nationality;
            } else {
                $country = $this->db->get_where('tblnegara', array(
                    'NmNegara' => $nationality,
                    'Deletests' => '0'
                ))->row();
                if ($country) {
                    $data['nationalid'] = $country->KdNegara;
                }
            }
        }
        
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
        

        $this->db->where('idperson', $idperson);
        $this->db->where('deletests', '0');
        $this->db->update('mstpersonal', $data);
        
        if ($this->db->affected_rows() > 0) {
            echo json_encode(array(
                'status' => true,
                'message' => 'Basic identity updated successfully'
            ));
        } else {
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


    public function updateCrewStatus() {
        $idperson = $this->input->post('idperson');
        $inAktif = $this->input->post('inAktif');
        $inBlacklist = $this->input->post('inBlacklist');
        $newapplicent = $this->input->post('newapplicent');
        $noncrew = $this->input->post('noncrew');

        if (!$idperson) {
            echo json_encode(array('status' => false, 'message' => 'ID Person is required'));
            return;
        }

        $data = array(
            'inAktif' => ($inAktif === '1') ? '1' : '0',
            'inBlacklist' => ($inBlacklist === '1') ? '1' : '0',
            'newapplicent' => ($newapplicent === '1') ? '1' : '0',
            'noncrew' => ($noncrew === '1') ? '1' : '0'
        );

        $this->db->where('idperson', $idperson);
        $this->db->where('deletests', '0');
        $this->db->update('mstpersonal', $data);

        $checkPerson = $this->db->get_where('mstpersonal', array('idperson' => $idperson, 'deletests' => '0'))->row();
        if (!$checkPerson) {
            echo json_encode(array('status' => false, 'message' => 'Person data not found'));
            return;
        }
        echo json_encode(array('status' => true, 'message' => 'Crew status updated successfully'));
    }


    public function updateFamilyInfo() {
        $idperson = $this->input->post('idperson');
        $fatherName = $this->input->post('fatherName');
        $motherName = $this->input->post('motherName');
        $wifeName = $this->input->post('wifeName');
        $address = $this->input->post('address');
        $nextOfKin = $this->input->post('nextOfKin');
        

        if (!$idperson) {
            echo json_encode(array(
                'status' => false,
                'message' => 'ID Person is required'
            ));
            return;
        }
        

        $username = $this->session->userdata('username') ?: 'system';
        $currentDate = date('Y-m-d H:i:s');
        

        $data = array(
            'fathernm' => $fatherName,
            'mothernm' => $motherName,
            'wname' => $wifeName,
            'next_of_kin' => $nextOfKin,
            'famaddrs' => $address,
            'updusrdt' => $currentDate . ' - ' . $username 
        );
        

        $this->db->where('idperson', $idperson);
        $this->db->where('deletests', '0');
        $this->db->update('mstpersonal', $data);
        
        if ($this->db->affected_rows() > 0) {
            echo json_encode(array(
                'status' => true,
                'message' => 'Family information updated successfully'
            ));
        } else {
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

    public function updateLegalTax() {
        $idperson = $this->input->post('idperson');
        $ssn = $this->input->post('ssn');
        $ssnCountry = $this->input->post('ssnCountry');
        $taxNumber = $this->input->post('taxNumber');
        $taxCountry = $this->input->post('taxCountry');
        $taxStatus = $this->input->post('taxStatus'); 
        

        if (!$idperson) {
            echo json_encode(array(
                'status' => false,
                'message' => 'ID Person is required'
            ));
            return;
        }
        

        $username = $this->session->userdata('username') ?: 'system';
        $currentDate = date('Y-m-d H:i:s');
        

        $data = array(
            'ssn' => $ssn,
            'ptn' => $taxNumber,
            'updusrdt' => $currentDate . ' - ' . $username
        );
        

        if (!empty($ssnCountry)) {
            if (is_numeric($ssnCountry)) {
                $data['ssnctryid'] = $ssnCountry;
            } else {
                $country = $this->db->get_where('tblnegara', array(
                    'NmNegara' => $ssnCountry,
                    'Deletests' => '0'
                ))->row();
                if ($country) {
                    $data['ssnctryid'] = $country->KdNegara;
                }
            }
        }
        
        if (!empty($taxCountry)) {
            if (is_numeric($taxCountry)) {
                $data['ptnctryid'] = $taxCountry;
            } else {
                $country = $this->db->get_where('tblnegara', array(
                    'NmNegara' => $taxCountry,
                    'Deletests' => '0'
                ))->row();
                if ($country) {
                    $data['ptnctryid'] = $country->KdNegara;
                }
            }
        }
        

        if (!empty($taxStatus)) {
            if (is_numeric($taxStatus)) {
                $data['taxstsid'] = $taxStatus;
            } else {
                $taxStatusObj = $this->db->get_where('tbltaxsts', array(
                    'taxstsid' => $taxStatus,
                    'Deletests' => '0'
                ))->row();
                if ($taxStatusObj) {
                    $data['taxstsid'] = $taxStatusObj->taxstsid;
                }
            }
        }
        

        $this->db->where('idperson', $idperson);
        $this->db->where('deletests', '0');
        $this->db->update('mstpersonal', $data);
        
        if ($this->db->affected_rows() > 0) {
            echo json_encode(array(
                'status' => true,
                'message' => 'Legal & Tax information updated successfully'
            ));
        } else {
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

    public function updateContact()
    {
        $idperson = $this->input->post('idperson');

        if (!$idperson) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Invalid person ID'
            ));
            return;
        }

        $username    = $this->session->userdata('username');
        $currentDate = date('Y-m-d H:i:s');

  
        $country = trim($this->input->post('country'));
        $city    = trim($this->input->post('city'));
        $airport = trim($this->input->post('airport'));

        $data = array(
            'paddress'  => $this->input->post('address'),
            'ppostcode' => $this->input->post('postcode'),
            'mobileno'  => $this->input->post('mobile'),
            'telpno'    => $this->input->post('home'),
            'faxno'     => $this->input->post('fax'),
            'email'     => $this->input->post('email'),


            'conmthEmail' => $this->input->post('conmthEmail') ? 1 : 0,
            'conmthFax'   => $this->input->post('conmthFax') ? 1 : 0,
            'conmthMob'   => $this->input->post('conmthMob') ? 1 : 0,
            'conmthHom'   => $this->input->post('conmthHom') ? 1 : 0,
            'conmthPost'  => $this->input->post('conmthPost') ? 1 : 0,
            'updusrdt'  => $currentDate . ' - ' . $username
        );

        if ($country !== '') {
            if (is_numeric($country)) {
                $data['pctryid'] = $country;
            } else {
                $row = $this->db->get_where(
                    'tblnegara',
                    array(
                        'NmNegara'   => $country,
                        'Deletests' => '0'
                    )
                )->row();

                if ($row) {
                    $data['pctryid'] = $row->KdNegara;
                }
            }
        }

        if ($city !== '') {
            if (is_numeric($city)) {
                $data['pcity'] = $city;
            } else {
                $row = $this->db->get_where(
                    'tblkota',
                    array(
                        'NmKota'     => $city,
                        'Deletests' => '0'
                    )
                )->row();

                if ($row) {
                    $data['pcity'] = $row->KdKota;
                }
            }
        }

        if ($airport !== '') {
            if (is_numeric($airport)) {
                $data['pnrstport'] = $airport;
            } else {
                $row = $this->db->get_where(
                    'tblkota',
                    array(
                        'NmKota'     => $airport,
                        'Deletests' => '0'
                    )
                )->row();

                if ($row) {
                    $data['pnrstport'] = $row->KdKota;
                }
            }
        }

        $this->db->where('idperson', $idperson);
        $this->db->where('deletests', '0');
        $update = $this->db->update('mstpersonal', $data);

        echo json_encode(array(
            'status'  => $update ? true : false,
            'message' => $update
                ? 'Contact & address updated successfully'
                : 'Failed to update contact & address'
        ));
    }

    public function updatePhysicalMedical()
    {
        $idperson = $this->input->post('idperson');

        $username    = $this->session->userdata('username');
        $currentDate = date('Y-m-d H:i:s');

        if (!$idperson) {
            echo json_encode(array(
                'status' => false,
                'message' => 'Invalid person ID'
            ));
            return;
        }

        $data = array(
            'golDrh'       => $this->input->post('bloodType'),
            'eyecol'       => $this->input->post('eyeColor'),
            'wght'         => $this->input->post('weight'),
            'hght'         => $this->input->post('height'),
            'shoesz'       => $this->input->post('shoes'),
            'collar'       => $this->input->post('collar'),
            'chest'        => $this->input->post('chest'),
            'waist'        => $this->input->post('waist'),
            'Insdleg'      => $this->input->post('insideLeg'),
            'clothszid'    => $this->input->post('clothesSize'),
            'boilerszid'   => $this->input->post('boilerSize'),
            'alergy'       => $this->input->post('allergy'),
            'heightphob'   => ($this->input->post('heightPhobia') == 'Yes') ? 'Y' : 'N',
            'claustrophob' => ($this->input->post('claustrophob') == 'Yes') ? 'Y' : 'N',
            'updusrdt'     => $currentDate . ' - ' . $username
        );

        $this->db->where('idperson', $idperson);
        $this->db->where('deletests', '0');
        $update = $this->db->update('mstpersonal', $data);

        echo json_encode(array(
            'status'  => $update ? true : false,
            'message' => $update
                ? 'Physical & medical data updated successfully'
                : 'Failed to update physical & medical data'
        ));
    }

    public function updateCareerPlacement()
    {
        $idperson = $this->input->post('idperson');

        $username    = $this->session->userdata('username');
        $currentDate = date('Y-m-d H:i:s');

        if (!$idperson) {
            echo json_encode(array(
                'status' => false,
                'message' => 'Invalid person ID'
            ));
            return;
        }

        $data = array(
            'applyfor'          => $this->input->post('rankApply'),
            'vesselfor'         => $this->input->post('vesselApply'),
            'crew_vessel_type'  => $this->input->post('vesselType'),
            'availdt'           => $this->input->post('availableDate'),
            'lower_rank'        => ($this->input->post('lowerRank') == 'Yes') ? '1' : '0',
            'updusrdt'          => $currentDate . ' - ' . $username
        );

        $this->db->where('idperson', $idperson);
        $this->db->where('deletests', '0');
        $update = $this->db->update('mstpersonal', $data);

        echo json_encode(array(
            'status'  => $update ? true : false,
            'message' => $update
                ? 'Career & placement updated successfully'
                : 'Failed to update career & placement'
        ));
    }

    public function updateSalaryHome()
    {
        $idperson = $this->input->post('idperson');

        if (!$idperson) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Invalid person ID'
            ));
            return;
        }

        $username    = $this->session->userdata('username');
        $currentDate = date('Y-m-d H:i:s');

        $data = array(
            'bank_name'              => trim($this->input->post('bank_home')),
            'norek'                  => trim($this->input->post('norek_home')),
            'norek_name'             => trim($this->input->post('norek_name_home')),
            'percentage_home_salary' => trim($this->input->post('percentage_home')),
            'updusrdt' => $currentDate . ' - ' . $username
        );

        $this->db->where('idperson', $idperson);
        $this->db->where('deletests', '0');
        $update = $this->db->update('mstpersonal', $data);

        echo json_encode(array(
            'status'  => $update ? true : false,
            'message' => $update
                ? 'Home salary updated successfully'
                : 'Failed to update home salary'
        ));
    }

     public function updateSalaryBoard()
    {
        $idperson = $this->input->post('idperson');

        if (!$idperson) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Invalid person ID'
            ));
            return;
        }

        $username    = $this->session->userdata('username');
        $currentDate = date('Y-m-d H:i:s');

        $data = array(
            'bank_name_boat'              => trim($this->input->post('bank_board')),
            'norek_boat'             => trim($this->input->post('norek_board')),
            'norek_name_boat'        => trim($this->input->post('norek_name_board')),
            'percentage_board_salary' => trim($this->input->post('percentage_board')),
            'updusrdt' => $currentDate . ' - ' . $username
        );

        $this->db->where('idperson', $idperson);
        $this->db->where('deletests', '0');
        $update = $this->db->update('mstpersonal', $data);

        echo json_encode(array(
            'status'  => $update ? true : false,
            'message' => $update
                ? 'Board salary updated successfully'
                : 'Failed to update board salary'
        ));
    }

    public function updateDeclaration()
    {
        $idperson = $this->input->post('idperson');

        if (!$idperson) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Invalid person ID'
            ));
            return;
        }

        $username    = $this->session->userdata('username');
        $currentDate = date('Y-m-d H:i:s');

        $signPlace = trim($this->input->post('signPlace'));
        $signDate  = trim($this->input->post('signDate'));
        $remarks   = trim($this->input->post('remarks'));

        $data = array(
            'signplc' => $signPlace,
            'signdt' => $signDate,
            'remarks' => $remarks,
            'updusrdt' => $currentDate . ' - ' . $username
        );

        $this->db->where('idperson', $idperson);
        $this->db->where('deletests', '0');
        $update = $this->db->update('mstpersonal', $data);

        echo json_encode(array(
            'status'  => $update ? true : false,
            'message' => $update
                ? 'Declaration updated successfully'
                : 'Failed to update declaration'
        ));
    }

    // ==================== Category Personal ID (tblpersonaldoc) ====================
    // Kolom: idperdoc, idperson, kdcert, doctp, docissctryid, docno, docissdt, docexpdt, docissplc, doc_file, addusrdt, updusrdt, delusrdt, deletests, st_display_report

    /**
     * Get list of personal docs for DataTables.
     * Table: tblpersonaldoc WHERE deletests = '0'
     */
    public function getPersonalDocList()
    {
        $idperson = $this->input->get('idperson');
        if (empty($idperson)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('success' => false, 'data' => array(), 'message' => 'idperson required'))
            );
            return;
        }

        $sql = "SELECT A.*, B.NmNegara AS country_name
                FROM tblpersonaldoc A
                LEFT JOIN tblnegara B ON B.KdNegara = A.docissctryid AND B.Deletests = '0'
                WHERE A.deletests = '0' AND A.idperson = ?
                ORDER BY A.idperdoc ASC";
        $rows = $this->db->query($sql, array($idperson))->result_array();
        $data = array();
        foreach ($rows as $row) {
            $data[] = array(
                'idperdoc' => $row['idperdoc'],
                'idperson' => $row['idperson'],
                'kdcert' => isset($row['kdcert']) ? $row['kdcert'] : '',
                'doctp' => isset($row['doctp']) ? $row['doctp'] : '',
                'country_issue' => isset($row['country_name']) ? $row['country_name'] : '',
                'docissctryid' => isset($row['docissctryid']) ? $row['docissctryid'] : '',
                'docno' => isset($row['docno']) ? $row['docno'] : '',
                'docissdt' => isset($row['docissdt']) ? $row['docissdt'] : '',
                'docissplc' => isset($row['docissplc']) ? $row['docissplc'] : '',
                'docexpdt' => isset($row['docexpdt']) ? $row['docexpdt'] : '',
                'doc_file' => isset($row['doc_file']) ? $row['doc_file'] : '',
            );
        }

        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('success' => true, 'data' => $data))
        );
    }

    /**
     * Get single personal doc for edit. Base on idperdoc + idperson.
     */
    public function getPersonalDoc()
    {
        $idperdoc = $this->input->post('id');
        $idperson = $this->input->post('idperson');
        if (empty($idperdoc) || empty($idperson)) {
            echo json_encode(array('status' => false, 'message' => 'Invalid ID or idperson'));
            return;
        }
        $row = $this->db->query(
            "SELECT * FROM tblpersonaldoc WHERE idperdoc = ? AND idperson = ? AND deletests = '0'",
            array($idperdoc, $idperson)
        )->row_array();
        if (empty($row)) {
            echo json_encode(array('status' => false, 'message' => 'Data not found'));
            return;
        }
        $row['country_name'] = $this->getCountryNameById(isset($row['docissctryid']) ? $row['docissctryid'] : '');
        $this->output->set_content_type('application/json')->set_output(json_encode(array('status' => true, 'data' => $row)));
    }

    /**
     * Save personal doc (create or update).
     */
    public function savePersonalDoc()
    {
        $idperdoc = $this->input->post('idperdoc');
        $idperson = $this->input->post('idperson');
        $kdcert = trim($this->input->post('kdcert'));
        $doctp = trim($this->input->post('doctp'));
        $docissctryid = $this->input->post('docissctryid');
        $docno = trim($this->input->post('docno'));
        $docissdt = $this->input->post('docissdt');
        $docissplc = trim($this->input->post('docissplc'));
        $docexpdt = $this->input->post('docexpdt');

        if (empty($idperson)) {
            echo json_encode(array('status' => false, 'message' => 'ID Person is required'));
            return;
        }
        if ($doctp === '') {
            echo json_encode(array('status' => false, 'message' => 'Type of Document ID is required'));
            return;
        }
        if ($docno === '') {
            echo json_encode(array('status' => false, 'message' => 'No Doc is required'));
            return;
        }
        if (empty($docissdt)) {
            echo json_encode(array('status' => false, 'message' => 'Date of Issue is required'));
            return;
        }
        // if (empty($docexpdt)) {
        //     echo json_encode(array('status' => false, 'message' => 'Valid Until is required'));
        //     return;
        // }
        if (!empty($docissdt) && !empty($docexpdt) && $docexpdt < $docissdt) {
            echo json_encode(array('status' => false, 'message' => 'Valid Until must be on or after Date of Issue'));
            return;
        }

        $username = $this->session->userdata('username') ?: 'system';
        $currentDate = date('Y-m-d H:i:s');
        $docissctryid_kd = '';
        if (!empty($docissctryid)) {
            if (is_numeric($docissctryid)) {
                $docissctryid_kd = $docissctryid;
            } else {
                $c = $this->db->get_where('tblnegara', array('NmNegara' => $docissctryid, 'Deletests' => '0'))->row();
                if ($c) {
                    $docissctryid_kd = $c->KdNegara;
                }
            }
        }

        $data = array(
            'idperson' => $idperson,
            'kdcert' => $kdcert,
            'doctp' => $doctp,
            'docissctryid' => $docissctryid_kd,
            'docno' => $docno,
            'docissdt' => $docissdt,
            'docissplc' => $docissplc,
            'docexpdt' => $docexpdt,
            'updusrdt' => $currentDate . ' - ' . $username,
        );

        $inserted_idperdoc = null;
        if (!empty($idperdoc)) {
            $this->db->where('idperdoc', $idperdoc);
            $this->db->where('idperson', $idperson);
            $this->db->where('deletests', '0');
            $this->db->update('tblpersonaldoc', $data);
            $ok = $this->db->affected_rows() >= 0;
            $inserted_idperdoc = $idperdoc;
            $message = $ok ? 'Personal document updated successfully' : 'No changes or update failed';
        } else {
            $nextId = $this->db->query("SELECT COALESCE(MAX(idperdoc), 0) + 1 AS next_id FROM tblpersonaldoc")->row()->next_id;
            $data['idperdoc'] = $nextId;
            $data['addusrdt'] = $currentDate . ' - ' . $username;
            $this->db->insert('tblpersonaldoc', $data);
            $ok = $this->db->affected_rows() > 0;
            $inserted_idperdoc = $nextId;
            $message = $ok ? 'Personal document added successfully' : 'Failed to add document';
        }

        if ($ok && $inserted_idperdoc && !empty($_FILES['doc_file']['name'])) {
            $dataContext = new DataContext();
            $dir = FCPATH . 'uploadFile/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $fileName = $_FILES['doc_file']['name'];
            $newFileName = 'personaldoc_' . $idperson . '_' . $inserted_idperdoc . '_' . time();
            $fileUploadNya = $dataContext->uploadFile(
                $_FILES['doc_file']['tmp_name'],
                $dir,
                $fileName,
                $newFileName
            );
            if ($fileUploadNya != '') {
                $this->db->where('idperdoc', $inserted_idperdoc);
                $this->db->where('idperson', $idperson);
                $this->db->where('deletests', '0');
                $this->db->update('tblpersonaldoc', array(
                    'doc_file' => $fileUploadNya,
                    'updusrdt' => $currentDate . ' - ' . $username,
                ));
            }
        }

        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('status' => $ok, 'message' => $message))
        );
    }

    /**
     * Soft delete personal doc. Base on idperdoc + idperson.
     */
    public function deletePersonalDoc()
    {
        $idperdoc = $this->input->post('id');
        $idperson = $this->input->post('idperson');
        if (empty($idperdoc) || empty($idperson)) {
            echo json_encode(array('status' => false, 'message' => 'Invalid ID or idperson'));
            return;
        }
        $username = $this->session->userdata('username') ?: 'system';
        $currentDate = date('Y-m-d H:i:s');
        $this->db->where('idperdoc', $idperdoc);
        $this->db->where('idperson', $idperson);
        $this->db->where('deletests', '0');
        $this->db->update('tblpersonaldoc', array('deletests' => '1', 'updusrdt' => $currentDate . ' - ' . $username));
        $ok = $this->db->affected_rows() > 0;
        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('status' => $ok, 'message' => $ok ? 'Document deleted successfully' : 'Delete failed'))
        );
    }

    /**
     * Upload PDF/file for personal doc (doc_file).
     */
    public function uploadPersonalDocFile()
    {
        $idperdoc = $this->input->post('idperdoc');
        $idperson = $this->input->post('idperson');

        if (empty($idperdoc) || empty($idperson)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'idperdoc and idperson required'))
            );
            return;
        }
        if (empty($_FILES['file_personaldoc']['name'])) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'Please select a file'))
            );
            return;
        }

        $dataContext = new DataContext();
        $dir = FCPATH . 'uploadFile/';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $fileName = $_FILES['file_personaldoc']['name'];
        $newFileName = 'personaldoc_' . $idperson . '_' . $idperdoc . '_' . time();
        $fileUploadNya = $dataContext->uploadFile(
            $_FILES['file_personaldoc']['tmp_name'],
            $dir,
            $fileName,
            $newFileName
        );

        if ($fileUploadNya == '') {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'Upload failed'))
            );
            return;
        }

        $username = $this->session->userdata('username') ?: 'system';
        $currentDate = date('Y-m-d H:i:s');

        $this->db->where('idperdoc', $idperdoc);
        $this->db->where('idperson', $idperson);
        $this->db->where('deletests', '0');
        $this->db->update('tblpersonaldoc', array(
            'doc_file' => $fileUploadNya,
            'updusrdt' => $currentDate . ' - ' . $username,
        ));

        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('status' => true, 'message' => 'File uploaded successfully', 'doc_file' => $fileUploadNya))
        );
    }

    /**
     * Upload foto profil crew. Simpan ke folder imgProfile dan update mstpersonal.pic.
     */
    public function uploadProfilePhoto()
    {
        $idperson = $this->input->post('idperson');
        if (empty($idperson)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'idperson required'))
            );
            return;
        }
        if (empty($_FILES['profile_photo']['name'])) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'Pilih file foto terlebih dahulu'))
            );
            return;
        }

        $allowedExt = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        $ext = strtolower(pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExt)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'Hanya file gambar (JPG, PNG, GIF, WebP) yang diizinkan'))
            );
            return;
        }
        if (@getimagesize($_FILES['profile_photo']['tmp_name']) === false) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'File bukan gambar valid'))
            );
            return;
        }

        $dataContext = new DataContext();
        $dir = FCPATH . 'imgProfile';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $fileName = $_FILES['profile_photo']['name'];
        $newFileName = 'pic_' . $idperson . '_' . time() . '.' . $ext;
        $fileUploadNya = $dataContext->uploadFile(
            $_FILES['profile_photo']['tmp_name'],
            $dir,
            $fileName,
            $newFileName
        );

        if ($fileUploadNya == '') {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'Upload gagal'))
            );
            return;
        }

        $username = $this->session->userdata('username') ?: 'system';
        $currentDate = date('Y-m-d H:i:s');
        $this->db->where('idperson', $idperson);
        $this->db->where('deletests', '0');
        $this->db->update('mstpersonal', array(
            'pic' => $fileUploadNya,
            'updusrdt' => $currentDate . ' - ' . $username
        ));

        $this->output->set_content_type('application/json')->set_output(
            json_encode(array(
                'status' => true,
                'message' => 'Foto profil berhasil diunggah',
                'pictureProfile' => $fileUploadNya
            ))
        );
    }

}