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



}