<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataContext extends CI_Controller {

	function __construct()
	{
		parent::__construct();		
		$this->load->model('MCrewscv');
		$this->load->helper(array('form', 'url'));
	}

	function getDataByReq($slc = "",$dbNya = "",$whereNya = "",$orderNya = "",$groupNya = "",$limitNya = "")
	{
		$rsl = $this->MCrewscv->getData($slc,$dbNya,$whereNya,$orderNya,$groupNya,$limitNya);

		if(count($rsl) > 0)
		{
			return $rsl[0]->$slc;
		}else{
			return "";
		}
	}

	function indexGeneral()
    {
        $data = array(
            'title' => 'General Recruitment',
            'active_menu' => 'general_recruitment',
            'content' => 'Recruitment/General/generalView'
        );

        $this->load->view('menu/RecruitmentMenu/main_General', $data);
    }
 
	function indexMasterCert()
    {
        $data = array(
            'title' => 'Certificate',
            'active_menu' => 'master_certificate',
            'content' => 'MasterData/MasterCertificate/MasterCertificateView'
        );

        $this->load->view('menu/MasterMenu/main_masterCert', $data);
    }

	function getDataCertificate($search = '')
	{
		$whereNya = " WHERE deletests = '0' AND certname != '' ";

		if ($search == "search") {
			$txtSearch = $this->input->post('txtSearchCert');
			$whereNya .= " AND certname LIKE '%".$this->db->escape_like_str($txtSearch)."%' ";
		}

		$sql = "SELECT * FROM mstcert ".$whereNya." ORDER BY certgroup ASC, certname ASC ";
		$rsl = $this->MCrewscv->getDataQuery($sql);

		$data = array();
		$no = 1;

		foreach ($rsl as $val) {

			$stDisplay = isset($val->st_display) ? $val->st_display : 'N';

			$data[] = array(
				'no'         => $no,
				'kdcert'     => $val->kdcert,
				'certname'   => $val->certname,
				'certgroup'  => $val->certgroup,
				'fullname'   => ($val->certgroup != '' 
									? '(' . $val->certgroup . ') ' . $val->certname 
									: $val->certname),
				'definition' => $val->definition,
				'st_display' => $stDisplay,
				'st_icon'    => ($stDisplay == 'Y' ? 'check' : 'close')
			);

			$no++;
		}


		echo json_encode(array(
			'status' => true,
			'total'  => count($data),
			'data'   => $data
		));
	}

	function getDataEditCertificate()
	{
		header('Content-Type: application/json');

		$idEdit = $this->input->post('idEdit');
		$type   = $this->input->post('type');

		if ($type != 'certificate') {
			echo json_encode(array('error' => 'Invalid type'));
			return;
		}

		$sql = "
			SELECT 
				kdcert,
				certgroup,
				certname,
				dispname,
				definition,
				IFNULL(st_display,'N') AS st_display
			FROM mstcert
			WHERE kdcert = '".$idEdit."'
		";

		$rsl = $this->MCrewscv->getDataQuery($sql);

		echo json_encode(array('rsl' => $rsl));
	}

	function saveDataCertificate()
	{
		header('Content-Type: application/json');

		$idEdit     = $this->input->post('idEdit');
		$certgroup  = $this->input->post('group');
		$certname   = $this->input->post('certName');
		$dispname   = $this->input->post('certDisplay');
		$definition = $this->input->post('definisi');
		$stDisplay  = $this->input->post('slcDisplay');

		if ($certname == '') {
			echo json_encode(array(
				'status'  => false,
				'message' => 'Certificate name cannot be empty'
			));
			return;
		}

		$data = array(
			'certgroup'  => $certgroup,
			'certname'   => $certname,
			'dispname'   => $dispname,
			'definition' => $definition,
			'st_display' => ($stDisplay == 'Y' ? 'Y' : 'N')
		);

		if ($idEdit == '') {
			// INSERT
			$data['kdcert'] = uniqid('CERT');
			$this->MCrewscv->insertData($data, 'mstcert');

			echo json_encode(array(
				'status'  => true,
				'message' => 'Certificate successfully added'
			));
		} else {
			// UPDATE
			$where = "kdcert = '".$idEdit."'";
			$this->MCrewscv->updateData($where, $data, 'mstcert');

			echo json_encode(array(
				'status'  => true,
				'message' => 'Certificate successfully updated'
			));
		}
	}
	
	function indexMasterCity()
	{
		$data = array(
			'title' => 'City',
			'active_menu' => 'master_city',
			'content' => 'MasterData/MasterCity/MasterCityView'
		);

		$this->load->view('menu/MasterMenu/main_masterCity', $data);
	}

	function getDataCity()
	{
		header('Content-Type: application/json');

		$search = $this->input->post('search');
		$txtSearch = $this->input->post('txtSearchCity');

		$whereNya = " WHERE Deletests = '0' AND NmKota != '' ";

		if ($search == 'search' && $txtSearch != '') {
			$whereNya .= " AND NmKota LIKE '%".$this->db->escape_like_str($txtSearch)."%' ";
		}

		$sql = "SELECT KdKota, NmKota FROM tblkota ".$whereNya." ORDER BY NmKota ASC";
		$rsl = $this->MCrewscv->getDataQuery($sql);

		$data = array();
		$no = 1;

		foreach ($rsl as $val) {
			$data[] = array(
				'no'     => $no,
				'id'     => $val->KdKota,
				'name'   => $val->NmKota
			);
			$no++;
		}

		echo json_encode(array(
			'status' => true,
			'data'   => $data
		));
	}

	function getDataEdit()
	{
		header('Content-Type: application/json');

		if (!$this->input->post('idEdit') || !$this->input->post('type')) {
			echo json_encode(array(
				'status'  => false,
				'message' => 'Invalid request'
			));
			return;
		}

		$idEdit = $this->input->post('idEdit');
		$type   = $this->input->post('type');

		$sql = '';

		switch ($type) {

			case 'certificate':
				$sql = "SELECT * FROM mstcert WHERE kdcert = '".$idEdit."'";
				break;

			case 'city':
				$sql = "SELECT * FROM tblkota WHERE KdKota = '".$idEdit."'";
				break;

			case 'company':
				$sql = "SELECT * FROM mstcmprec WHERE kdcmp = '".$idEdit."'";
				break;

			case 'country':
				$sql = "SELECT * FROM tblnegara WHERE KdNegara = '".$idEdit."'";
				break;

			case 'rank':
				$sql = "SELECT * FROM mstrank WHERE kdrank = '".$idEdit."'";
				break;

			case 'vessel':
				$sql = "SELECT * FROM mstvessel WHERE kdvsl = '".$idEdit."'";
				break;

			case 'vesselType':
				$sql = "SELECT * FROM tbltype WHERE KdType = '".$idEdit."'";
				break;

			case 'masterSchool':
				$sql = "SELECT * FROM mstschool WHERE id = '".$idEdit."'";
				break;

			case 'openRecruitment':
				$sql = "SELECT * FROM tblopenrecruitment WHERE id = '".$idEdit."'";
				break;

			case 'userCrew':
				$sql = "SELECT * FROM crew_login WHERE id = '".$idEdit."'";
				break;

			case 'userSystem':
				$sql = "SELECT * FROM login WHERE userId = '".$idEdit."'";
				break;
			case 'reasonEmail':
				$sql = "SELECT * FROM mstreasonemail WHERE id = '".$idEdit."'";
				break;
			case 'certificateMatrix':
				$sql = "SELECT * FROM mstcertificatematrix WHERE id = '".$idEdit."' ";
				break;
			case 'clinic':
				$sql = "SELECT * FROM master_mcu WHERE id = '".$idEdit."'";
				break;
			default:
				echo json_encode(array(
					'status'  => false,
					'message' => 'Invalid type'
				));
				return;
		}

		$rsl = $this->MCrewscv->getDataQuery($sql);

		echo json_encode(array(
			'status' => true,
			'data'   => (count($rsl) > 0 ? $rsl[0] : null)
		));
	}


	function saveDataCity()
	{
		header('Content-Type: application/json');

		$idEdit = $this->input->post('idEdit');
		$city   = strtoupper($this->input->post('txtCity'));

		if ($city == '') {
			echo json_encode(array(
				'status'  => false,
				'message' => 'City name empty'
			));
			return;
		}

		$userDateTimeNow =
			$this->session->userdata('userCrewSystem')."/".date('Ymd')."/".date('H:i:s');

		$data = array(
			'NmKota' => $city
		);

		try {
			if ($idEdit == '') {
				$data['AddUsrDt'] = $userDateTimeNow;
				$this->MCrewscv->insData("tblkota", $data);
				$msg = 'Insert City Success!';
			} else {
				$data['UpdUsrDt'] = $userDateTimeNow;
				$this->MCrewscv->updateData(
					array('KdKota' => $idEdit),
					$data,
					"tblkota"
				);
				$msg = 'Update City Success!';
			}


			echo json_encode(array(
				'status'  => true,
				'message' => $msg
			));

		} catch (Exception $e) {
			echo json_encode(array(
				'status'  => false,
				'message' => $e->getMessage()
			));
		}
	}

	function deleteData()
	{
		header('Content-Type: application/json');

		$idDel = $this->input->post('idDel');
		$type  = $this->input->post('type');

		if (empty($idDel) || empty($type)) {
			echo json_encode(array(
				'status'  => false,
				'message' => 'Invalid request'
			));
			return;
		}

		$userDateTimeNow =
			$this->session->userdata('userCrewSystem') . "/" .
			date('Ymd') . "/" .
			date('H:i:s');

		try {

			switch ($type) {

				case 'city':
					$this->MCrewscv->updateData(
						array('KdKota' => $idDel),
						array(
							'Deletests' => '1',
							'delusrdt'  => $userDateTimeNow
						),
						'tblkota'
					);
					break;
				case 'certificate':
					$this->MCrewscv->updateData(
						array('kdcert' => $idDel),
						array(
							'Deletests' => '1',
							'delusrdt'  => $userDateTimeNow
						),
						'mstcert'
					);
					break;
				case 'country':
					$this->MCrewscv->updateData(
						array('KdNegara' => $idDel),
						array(
							'Deletests' => '1',
							'delusrdt'  => $userDateTimeNow
						),
						'tblnegara'
					);
					break;
				case 'company':
					$this->MCrewscv->updateData(
						array('kdcmp' => $idDel),
						array(
							'Deletests' => '1',
							'delusrdt'  => $userDateTimeNow
						),
						'mstcmprec'
					);
					break;

				case 'rank':
					$this->MCrewscv->updateData(
						array('kdrank' => $idDel),
						array(
							'Deletests' => '1',
							'delusrdt'  => $userDateTimeNow
						),
						'mstrank'
					);
					break;
				case 'vessel':
					$this->MCrewscv->updateData(
						array('kdvsl' => $idDel),
						array(
							'deletests' => '1',
							'delusrdt'  => $userDateTimeNow
						),
						'mstvessel'
					);
					break;
				case 'school':
					$this->MCrewscv->updateData(
						array('id' => $idDel),
						array(
							'Deletests' => '1',
							'UpdUsrDt' => $userDateTimeNow		
						),
						'mstschool'
					);
					break;
				case 'vesselType':
					$this->MCrewscv->updateData(
						array('KdType' => $idDel),
						array(
							'Deletests' => '1',
							'UpdUsrDt' => $userDateTimeNow	
						),
						'tbltype'
					);
					break;
				case 'openRecruitment':
					$this->MCrewscv->updateData(
						array('id' => $idDel),
						array(
							'deletests' => '1',
							'DelUsrDt' => $userDateTimeNow,
						),
						'tblopenrecruitment'
					);
					break;
				case 'userCrew':
					$this->MCrewscv->updateData(
						array('id' => $idDel),
						array(
							'sts_delete' => '1',
							'delusrdt' => $userDateTimeNow,
						),
						'crew_login'
					);
					break;
				case 'userSystem':
					$this->MCrewscv->updateData(
						array('userid' => $idDel),
						array(
							'status' =>'1',
						),
						'login'
					);
					break;
				case 'certificateMatrix':
					$this->MCrewscv->updateData(
						array('id' => $idDel),
						array(
							'Deletests' => '1',
							'delusrdt'  => $userDateTimeNow
						),
						'mstcertificatematrix'
					);
					break;
				case 'dataClinic':
					$this->MCrewscv->updateData(
						array('id' => $idDel),
						array(
							'Deletests' => '1',
						),
						'master_mcu'
					);
					break;
				default:
					throw new Exception('Invalid type');
			}

			echo json_encode(array(
				'status'  => true,
				'message' => 'Successfully deleted!'
			));

		} catch (Exception $e) {
			echo json_encode(array(
				'status'  => false,
				'message' => $e->getMessage()
			));
		}
	}

	function indexMasterCountry()
	{
		$data = array(
			'title' => 'Country',
			'active_menu' => 'master_country',
			'content' => 'MasterData/MasterCountry/MasterCountryView'
		);

		$this->load->view('menu/MasterMenu/main_masterCountry', $data);
	}
	
	function getDataCountry()
	{
		header('Content-Type: application/json');

		$dataOut = array(
			'status' => false,
			'data'   => array()
		);

		$where = " WHERE Deletests = '0' AND NmNegara != '' ";

		if ($this->input->post('search') === 'search') {
			$keyword = trim($this->input->post('txtSearch'));
			if ($keyword !== '') {
				$where .= " AND NmNegara LIKE '%" . $this->db->escape_like_str($keyword) . "%' ";
			}
		}

		$sql = "SELECT KdNegara, NmNegara
				FROM tblnegara
				{$where}
				ORDER BY NmNegara ASC";

		$rsl = $this->MCrewscv->getDataQuery($sql);

		$total = count($rsl);

		for ($i = 0; $i < $total; $i++) {
			$dataOut['data'][$i] = array(
				'no'   => $i + 1,
				'id'   => $rsl[$i]->KdNegara,
				'name' => $rsl[$i]->NmNegara
			);
		}

		$dataOut['status'] = true;

		echo json_encode($dataOut);
	}

	function saveDataCountry()
	{
		header('Content-Type: application/json');

		$idEdit      = $this->input->post('idEdit');
		$txtCountry  = trim($this->input->post('txtCountry'));

		if ($txtCountry === '') {
			echo json_encode(array(
				'status'  => false,
				'message' => 'Country Name tidak boleh kosong'
			));
			return;
		}

		$userDateTimeNow = 
			$this->session->userdata('userCrewSystem') . '/' .
			date('Ymd') . '/' . date('H:i:s');

		$dataIns = array(
			'NmNegara' => strtoupper($txtCountry)
		);

		try {

			if ($idEdit == '') {
				$dataIns['AddUsrDt'] = $userDateTimeNow;
				$this->MCrewscv->insData('tblnegara', $dataIns);

				$msg = 'Data Country berhasil disimpan';
			} else {
				
				$dataIns['UpdUsrDt'] = $userDateTimeNow;
				$where = "KdNegara = '".$idEdit."'";
				$this->MCrewscv->updateData($where, $dataIns, 'tblnegara');

				$msg = 'Data Country berhasil diperbarui';
			}

			echo json_encode(array(
				'status'  => true,
				'message' => $msg
			));

		} catch (Exception $e) {

			echo json_encode(array(
				'status'  => false,
				'message' => $e->getMessage()
			));
		}
	}


	function indexMasterCompany()
	{
		$data = array(
			'title' => 'Company',
			'active_menu' => 'master_company',
			'content' => 'MasterData/MasterCompany/MasterCompanyView'
		);

		$this->load->view('menu/MasterMenu/main_masterCompany', $data);
	}

	function getDataCompany()
	{
		header('Content-Type: application/json');

		$dataOut = array(
			'status' => true,
			'data'   => array()
		);

		$whereNya = " WHERE Deletests = '0' AND nmcmp != '' ";

		if (!empty($_POST['txtSearch'])) {
			$txtSearch = $this->db->escape_like_str($_POST['txtSearch']);
			$whereNya .= " AND nmcmp LIKE '%{$txtSearch}%'";
		}

		$sql = "
			SELECT 
				kdcmp,
				nmcmp,
				desccmp,
				cvtype
			FROM mstcmprec
			{$whereNya}
			ORDER BY nmcmp ASC
		";

		$rsl = $this->MCrewscv->getDataQuery($sql);

		if (!$rsl) {
			echo json_encode($dataOut);
			return;
		}

		$no = 1;
		foreach ($rsl as $row) {
			$dataOut['data'][] = array(
				'no'        => $no++,
				'id'        => $row->kdcmp,
				'company'   => $row->nmcmp,
				'definition'=> $row->desccmp,
				'reportType'=> $row->cvtype
			);
		}

		echo json_encode($dataOut);
	}

	function saveDataCompany()
	{
		header('Content-Type: application/json');

		$data = $this->input->post();

		$idEdit = '';
		if (isset($data['idEdit'])) {
			$idEdit = $data['idEdit'];
		}

		$userDateTimeNow = $this->session->userdata('userCrewSystem')
			. "/" . date('Ymd') . "/" . date('H:i:s');

		try {

			$dataIns = array(
				'nmcmp'   => isset($data['txtCompanyName']) ? $data['txtCompanyName'] : '',
				'desccmp' => isset($data['txtDefinitionCom']) ? $data['txtDefinitionCom'] : '',
				'cvtype'  => isset($data['slcReportType']) ? $data['slcReportType'] : ''
			);

			if ($idEdit == '') {

				$dataIns['AddUsrDt'] = $userDateTimeNow;
				$this->MCrewscv->insData("mstcmprec", $dataIns);

				$message = "Company successfully added";

			} else {

				// UPDATE
				$dataIns['updusrdt'] = $userDateTimeNow;
				$whereNya = "kdcmp = '" . $idEdit . "'";
				$this->MCrewscv->updateData($whereNya, $dataIns, "mstcmprec");

				$message = "Company successfully updated";
			}

			echo json_encode(array(
				'status'  => true,
				'message' => $message
			));
			return;

		} catch (Exception $ex) {

			echo json_encode(array(
				'status'  => false,
				'message' => $ex->getMessage()
			));
			return;
		}
	}

	function indexMasterRank()
	{
		$data = array(
			'title' => 'Rank',
			'active_menu' => 'master_rank',
			'content' => 'MasterData/MasterRank/MasterRankView'
		);

		$this->load->view('menu/MasterMenu/main_masterRank', $data);
	}

	function getDataRankMaster()
	{
		header('Content-Type: application/json');

		$dataOut = array(
			'status' => true,
			'data'   => array()
		);

		$whereNya = " WHERE Deletests = '0' AND nmrank != '' ";

		if (!empty($_POST['txtSearch'])) {
			$txtSearch = $this->db->escape_like_str($_POST['txtSearch']);
			$whereNya .= " AND nmrank LIKE '%" . $txtSearch . "%' ";
		}

		$sql = "SELECT * FROM mstrank {$whereNya} ORDER BY urutan ASC";
		$rsl = $this->MCrewscv->getDataQuery($sql);

		if (!$rsl) {
			echo json_encode($dataOut);
			return;
		}

		$no = 1;
		$total = count($rsl);

		foreach ($rsl as $row) {

			$dataOut['data'][] = array(
				'no'        => $no,
				'id'        => $row->kdrank,
				'name'      => $row->nmrank,
				'definition'=> $row->descrank,
				'cadangan'  => $row->cadangan,
				'urutan'    => $row->urutan,
				'canUp'     => ($no > 1),
				'canDown'   => ($no < $total),
				'isLocked'  => (str_replace(' ', '', $row->nmrank) == "-")
			);

			$no++;
		}

		echo json_encode($dataOut);
	}

	function updateUrutRank()
	{
		$dataUpd = array();
		$kdRank = $_POST['kdRank'];
		$type = $_POST['type'];
		$urutan = $_POST['urutan'];
		$status = "";

		if($type == "up")
		{
			$newUrut = $urutan - 1;
		}else{
			$newUrut = $urutan + 1;
		}

		try {
			$sqlCekUrut = "SELECT kdrank FROM mstrank WHERE Deletests = '0' AND nmrank != '' AND urutan = '".$newUrut."' LIMIT 0,1 ";
			$rslCekUrut = $this->MCrewscv->getDataQuery($sqlCekUrut);

			if(count($rslCekUrut) > 0)
			{
				$dataUpd['urutan'] =  $urutan;
				$whereNya = "kdrank = '".$rslCekUrut[0]->kdrank."'";
				$this->MCrewscv->updateData($whereNya,$dataUpd,"mstrank");
			}

			$dataUpd = array();
			$dataUpd['urutan'] =  $newUrut;
			$whereNya = "kdrank = '".$kdRank."'";
			$this->MCrewscv->updateData($whereNya,$dataUpd,"mstrank");

			$status = "sukses";
		} catch (Exception $ex) {
			$status = "Failed => ".$ex->getMessages();
		}

		print json_encode($status);
	}

	function saveDataRank()
	{
		header('Content-Type: application/json');

		$data = $this->input->post();
		$idEdit = isset($data['idEdit']) ? $data['idEdit'] : '';
		$userDateTimeNow =
			$this->session->userdata('userCrewSystem') . "/" .
			date('Ymd') . "/" .
			date('H:i:s');

		try {

			$dataIns = array(
				'nmrank'   => $data['txtRankName'],
				'descrank'=> $data['txtDefinition'],
				'urutan'  => $data['txtNumber'],
				'cadangan'=> $data['txtCadangan']
			);

			if ($idEdit == '') {

				// INSERT
				$dataIns['addusrdt'] = $userDateTimeNow;
				$this->MCrewscv->insData('mstrank', $dataIns);

				$message = 'Rank successfully added';

			} else {

				// UPDATE
				$dataIns['updusrdt'] = $userDateTimeNow;
				$whereNya = "kdrank = '".$idEdit."'";
				$this->MCrewscv->updateData($whereNya, $dataIns, 'mstrank');

				$message = 'Rank successfully updated';
			}

			echo json_encode(array(
				'status'  => true,
				'message' => $message
			));
			return;

		} catch (Exception $ex) {

			echo json_encode(array(
				'status'  => false,
				'message' => $ex->getMessage()
			));
			return;
		}
	}


	function indexMasterVessel()
	{
		$data = array(
			'title' => 'Vessel',
			'active_menu' => 'master_vessel',
			'content' => 'MasterData/MasterVessel/MasterVesselView'
		);

		$this->load->view('menu/MasterMenu/main_masterVessel', $data);
	}

	function getDataVessel()
	{
		header('Content-Type: application/json');

		$dataContext = new DataContext();

		$dataOut = array(
			'status'     => true,
			'data'       => array(),
			'vesselType' => $this->getCrewVesselTypeRecruitment('array'),
			'companyList' => $this->getCompanyByOption('array')
		);

		$whereNya = " WHERE deletests = '0' AND nmvsl != '' ";

		if (!empty($_POST['txtSearch'])) {
			$txtSearch = $this->db->escape_like_str($_POST['txtSearch']);
			$whereNya .= " AND nmvsl LIKE '%{$txtSearch}%'";
		}

		$sql = "SELECT * FROM mstvessel {$whereNya} ORDER BY nmvsl ASC";
		$rsl = $this->MCrewscv->getDataQuery($sql);

		if (!$rsl) {
			echo json_encode($dataOut);
			return;
		}

		$no = 1;
		foreach ($rsl as $row) {
			$dataOut['data'][] = array(
				'no'        => $no++,
				'id'        => $row->kdvsl,
				'name'      => $row->nmvsl,
				'email'     => $row->mail_vessel,
				'imo'       => $row->imo,
				'grt'       => $row->grt,
				'serpel'    => $row->serpel,
				'desc'      => $row->descvsl,
				'company'   => $row->nmcmp,
				'isDisplay' => ($row->st_display === 'Y')
			);
		}

		echo json_encode($dataOut);
	}

	function saveDataVessel()
	{
		header('Content-Type: application/json');

		$data = $_POST;
		$dataIns = array();

		// aman tanpa ??
		$idEdit = "";
		if (isset($data['idEdit'])) {
			$idEdit = $data['idEdit'];
		}

		$userDateTimeNow = $this->session->userdata('userCrewSystem') . "/" . date('Ymd') . "/" . date('H:i:s');

		try {

			$dataIns['kdcmp']       = isset($data['slcCompany']) ? $data['slcCompany'] : "";
			$dataIns['nmcmp']       = isset($data['slcCompanyName']) ? $data['slcCompanyName'] : "";
			$dataIns['nmvsl']       = isset($data['txtVesselName']) ? $data['txtVesselName'] : "";
			$dataIns['imo']         = isset($data['txtIMO']) ? $data['txtIMO'] : "";
			$dataIns['grt']         = isset($data['txtGRT']) ? $data['txtGRT'] : "";
			$dataIns['serpel']      = isset($data['txtSerpel']) ? $data['txtSerpel'] : "";
			$dataIns['descvsl']     = isset($data['slcDefinition']) ? $data['slcDefinition'] : "";
			$dataIns['st_display']  = isset($data['slcStsDisplay']) ? $data['slcStsDisplay'] : "";
			$dataIns['os_name']     = isset($data['osName']) ? $data['osName'] : "";
			$dataIns['os_mail']     = isset($data['osMail']) ? $data['osMail'] : "";
			$dataIns['mail_vessel'] = isset($data['txtMailVessel']) ? $data['txtMailVessel'] : "";
			$dataIns['loa']         = (isset($data['txtLoa']) && $data['txtLoa'] != "") ? $data['txtLoa'] : "0";
			$dataIns['st_own']      = isset($data['slcOwn']) ? $data['slcOwn'] : "";

			if ($idEdit == "") {

				$dataIns['addusrdt'] = $userDateTimeNow;
				$this->MCrewscv->insData("mstvessel", $dataIns);
				$msg = "Data vessel berhasil disimpan";

			} else {

				$dataIns['updusrdt'] = $userDateTimeNow;
				$whereNya = "kdvsl = '" . $idEdit . "'";
				$this->MCrewscv->updateData($whereNya, $dataIns, "mstvessel");
				$msg = "Data vessel berhasil diupdate";
			}

			echo json_encode(array(
				'status'  => true,
				'message' => $msg
			));

		} catch (Exception $ex) {

			echo json_encode(array(
				'status'  => false,
				'message' => $ex->getMessage()
			));
		}
	}


	function indexMasterVesselType()
	{
		$data = array(
			'title' => 'Vessel Type',
			'active_menu' => 'master_vessel_type',
			'content' => 'MasterData/MasterVesselType/MasterVesselTypeView'
		);

		$this->load->view('menu/MasterMenu/main_masterVesselType', $data);
	}

	
	function getDataVesselType()
	{
		header('Content-Type: application/json');

		$whereNya = " WHERE Deletests = '0' AND NmType != '' ";

		
		$txtSearch = $this->input->post('txtSearch');
		if (empty($txtSearch)) {
			$txtSearch = $this->input->get('txtSearch');
		}

		if (!empty($txtSearch)) {
			$whereNya .= " AND NmType LIKE '%" . $txtSearch . "%' ";
		}

		$sql = "SELECT * FROM tbltype " . $whereNya . " ORDER BY NmType ASC ";
		$rsl = $this->MCrewscv->getDataQuery($sql);

		$data = array();
		$no = 1;

		foreach ($rsl as $row) {
			$data[] = array(
				'no'         => $no++,
				'kdtype'     => $row->KdType,
				'vesseltype' => $row->NmType,
				'definition' => $row->DefType
			);
		}

		echo json_encode(array(
			'status' => true,
			'data'   => $data
		));
	}

	function saveDataVesselType()
	{
		header('Content-Type: application/json');

		$data = $this->input->post();
		$idEdit = $data['idEdit'];
		$userDateTimeNow =
			$this->session->userdata('userCrewSystem') . "/" .
			date('Ymd') . "/" .
			date('H:i:s');

		try {

			if (empty($data['txtVesselType'])) {
				echo json_encode(array(
					'status'  => false,
					'message' => 'Vessel Type cannot be empty'
				));
				return;
			}

			$dataIns = array(
				'NmType'  => $data['txtVesselType'],
				'DefType' => $data['txtDefinition']
			);

			if ($idEdit == "") {

				$dataIns['AddUsrDt'] = $userDateTimeNow;
				$this->MCrewscv->insData("tbltype", $dataIns);

				$message = "Vessel Type successfully added!";
			} else {

				$dataIns['UpdUsrDt'] = $userDateTimeNow;
				$whereNya = "KdType = '".$idEdit."'";

				$this->MCrewscv->updateData($whereNya, $dataIns, "tbltype");

				$message = "Vessel Type successfully updated!";
			}

			echo json_encode(array(
				'status'  => true,
				'message' => $message
			));

		} catch (Exception $ex) {

			echo json_encode(array(
				'status'  => false,
				'message' => 'Failed: ' . $ex->getMessage()
			));
		}
	}

	function indexMasterSchool()
	{
		$data = array(
			'title' => 'School Name',
			'active_menu' => 'master_school',
			'content' => 'MasterData/MasterSchoolName/MasterSchoolNameView'
		);

		$this->load->view('menu/MasterMenu/main_masterSchoolName', $data);
	}

	function saveDataMasterSchool()
	{
		header('Content-Type: application/json');

		$data = $this->input->post();
		$idEdit = $data['idEdit'];
		$userDateTimeNow = 
			$this->session->userdata('userCrewSystem') . "/" .
			date('Ymd') . "/" .
			date('H:i:s');

		try {

			if (empty($data['txtnameschool'])) {
				echo json_encode(array(
					'status' => false,
					'message' => 'School name cannot be empty'
				));
				return;
			}

			$dataIns = array(
				'schoolname' => $data['txtnameschool']
			);

			if ($idEdit == "") {

				$dataIns['AddUsrDt'] = $userDateTimeNow;
				$this->MCrewscv->insData("mstschool", $dataIns);

				$message = "Data School Successfully Added!";
			} else {

				$dataIns['UpdUsrDt'] = $userDateTimeNow;
				$whereNya = "id = '".$idEdit."'";
				$this->MCrewscv->updateData($whereNya, $dataIns, "mstschool");

				$message = "Data School Successfully Updated!";
			}

			echo json_encode(array(
				'status' => true,
				'message' => $message
			));

		} catch (Exception $ex) {

			echo json_encode(array(
				'status' => false,
				'message' => 'Failed: ' . $ex->getMessage()
			));
		}
	}

	function getDataMasterSchool()
	{
		header('Content-Type: application/json');

		$whereNya = " WHERE Deletests = '0'";

		$txtSearch = $this->input->post('txtSearch');
		if (!empty($txtSearch)) {
			$whereNya .= " AND schoolname LIKE '%" . $this->db->escape_like_str($txtSearch) . "%' ";
		}

		$sql = "SELECT id, schoolname
				FROM mstschool
				{$whereNya}
				ORDER BY schoolname ASC";

		$rsl = $this->MCrewscv->getDataQuery($sql);

		$data = array();
		$no = 1;

		foreach ($rsl as $row) {
			$data[] = array(
				'no'         => $no++,
				'id'         => $row->id,
				'schoolname' => $row->schoolname
			);
		}

		echo json_encode(array(
			'status' => true,
			'data'   => $data
		));
	}

	function openRecruitment()
	{
		$data = array(
			'title' => 'Open Recruitment',
			'active_menu' => 'open_recruitment',
			'content' => 'MasterData/MasterOpenRecruitment/MasterOpenRecruitmentView'
		);

		$this->load->view('menu/MasterMenu/main_masterOpenRec', $data);
	}

	function getRankByOptionArray()
	{
		$sql = "
			SELECT kdrank, nmrank
			FROM mstrank
			WHERE deletests = '0'
			AND urutan > 0
			ORDER BY urutan ASC, nmrank ASC
		";

		$rsl = $this->MCrewscv->getDataQuery($sql); 

		$out = array();

		if ($rsl) {
			foreach ($rsl as $val) {
				$out[] = array(
					'id'   => $val->kdrank,
					'name' => $val->nmrank
				);
			}
		}

		return $out;
	}

	function getRankByOptionArrayJson()
	{
		$sql = "
			SELECT kdrank, nmrank
			FROM mstrank
			WHERE deletests = '0'
			AND urutan > 0
			ORDER BY urutan ASC, nmrank ASC
		";

		$rsl = $this->MCrewscv->getDataQuery($sql); 

		$out = array();

		if ($rsl) {
			foreach ($rsl as $val) {
				$out[] = array(
					'id'   => $val->kdrank,
					'name' => $val->nmrank
				);
			}
		}

		header('Content-Type: application/json');
		echo json_encode($out);
	}	

	function getDataOpenRecruitment()
	{
		header('Content-Type: application/json');

		$dataContext = new DataContext();

		$dataOut = array(
			'status' => true,
			'data'   => array(),
			'rankOption' => $this->getRankByOptionArray() 
		);

		$whereNya = " WHERE R.deletests = '0' ";

		if (!empty($_POST['txtSearch'])) {
			$txtSearch = $this->db->escape_like_str($_POST['txtSearch']);
			$whereNya .= " AND R.subject_name LIKE '%{$txtSearch}%'";
		}

		$sql = "SELECT R.*, M.urutan 
				FROM tblopenRecruitment R
				LEFT JOIN mstrank M ON R.rank = M.nmrank
				{$whereNya}
				ORDER BY M.urutan ASC, R.subject_name ASC";

		$rsl = $this->MCrewscv->getDataQuery($sql);

		if (!$rsl) {
			echo json_encode($dataOut);
			return;
		}

		$no = 1;

		foreach ($rsl as $val)
		{
			$rankName = '';

			if (isset($val->rank)) {
				$rankName = trim($val->rank);
			}

			if ($rankName == '') {
				$rankName = '-';
			}

			if (isset($val->subject_name) && $val->subject_name != '') {
				$rankName .= " - " . $val->subject_name;
			}

			$dataOut['data'][] = array(
				'no'            => $no++,
				'id'            => $val->id,
				'rankName'      => $rankName,
				'urutan'        => $val->urutan,
				'qualification' => $val->qualification,
				'publishDate'   => ($val->sts_publish == 'Y')
									? $this->convertReturnNameWithTime($val->datePublish)
									: '',
				'vesselType'    => $val->vesselType,
				'isPublish'     => ($val->sts_publish == 'Y')
			);
		}

		echo json_encode($dataOut);
	}

	function saveDataOpenRecruitment()
	{ 
		header('Content-Type: application/json');

		$data = $this->input->post();
		$idEdit = $data['idEdit'];
		$userDateTimeNow =
		$this->session->userdata('userCrewSystem') . "/" .
			date('Ymd') . "/" .
			date('H:i:s');

		try {

			if (empty($data['slcRank'])) {
				echo json_encode(array(
					'status' => false,
					'message' => 'Rank is required'
				));
				return;
			}

			if (empty($data['txtSubjectName'])) {
				echo json_encode(array(
					'status' => false,
					'message' => 'Subject Name is required'
				));
				return;
			}

			$rankName = $data['slcRank'];

			$dataIns = array(
				'rank'          => $rankName,
				'subject_name'  => strtoupper($data['txtSubjectName']),
				'qualification' => $data['txtQualification'],
				'vesselType'   => isset($data['slcVesselType']) ? $data['slcVesselType'] : ''
			);

			$sql = "SELECT urutan 
					FROM mstrank 
					WHERE nmrank = '".$this->db->escape_str($rankName)."' 
					AND deletests = '0' 
					LIMIT 1";

			$rankData = $this->MCrewscv->getDataQuery($sql);

			$dataIns['rank_order'] =
				(isset($rankData[0]->urutan)) ? $rankData[0]->urutan : 9999;

			if ($idEdit == "") {

				$dataIns['AddUsrDt'] = $userDateTimeNow;
				$this->MCrewscv->insData("tblopenrecruitment", $dataIns);

				$message = "Open Recruitment successfully added!";
			} else {

				$dataIns['UpdUsrDt'] = $userDateTimeNow;
				$whereNya = "id = '".$idEdit."'";

				$this->MCrewscv->updateData($whereNya, $dataIns, "tblopenrecruitment");

				$message = "Open Recruitment successfully updated!";
			}

			echo json_encode(array(
				'status' => true,
				'message' => $message
			));

		} catch (Exception $ex) {

			echo json_encode(array(
				'status' => false,
				'message' => 'Failed: '.$ex->getMessage()
			));
		}
	}

	function pubDateRecruitment()
	{
		header('Content-Type: application/json');

		$id   = $this->input->post('id');
		$type = $this->input->post('type');

		if (empty($id) || empty($type)) {
			echo json_encode(array(
				'status'  => false,
				'message' => 'Invalid request'
			));
			return;
		}

		try {

			$dataIns = array();
			$dateNow = date('Y-m-d H:i:s');

			if ($type == "publish") {

				$dataIns['sts_publish'] = 'Y';
				$dataIns['datePublish'] = $dateNow;
				$message = "Successfully Published!";

			} else {

				$dataIns['sts_publish'] = 'N';
				$dataIns['datePublish'] = '0000-00-00 00:00:00';
				$message = "Successfully Unpublished!";
			}

			$this->MCrewscv->updateData(
				array('id' => $id),
				$dataIns,
				"tblopenrecruitment"
			);

			echo json_encode(array(
				'status'  => true,
				'message' => $message
			));

		} catch (Exception $e) {

			echo json_encode(array(
				'status'  => false,
				'message' => $e->getMessage()
			));
		}
	}	
	
	function getFormNewApplicant()
	{
		$data = array(
			'title'       => 'New Applicant Form',
			'content'     => 'MasterData/MasterOpenRecruitment/viewFormNewApplicant',
			'optRank'     => $this->getRankByOptionArray(),
			'liNamaJabatan' => $this->getRecruitment()
		);
		$this->load->view('menu/MasterMenu/main_masterNewFormApplicant', $data);
	}
	
	function saveNewApplicant()
	{
		$data = $_POST; 
		$files = $_FILES;
		$dataIns = array();
		$cvFullPath = "";

		try {
			if (empty($data['txtemail']) || !filter_var($data['txtemail'], FILTER_VALIDATE_EMAIL)) {
				throw new Exception("Email tidak valid");
			}

			$applicantId = !empty($data['txtIdNewApplicant'])
				? $data['txtIdNewApplicant']
				: uniqid('applicant_');

			$email = !empty($data['txtemail'])
				? $data['txtemail']
				: '';

			$fullname = !empty($data['txtnama'])
				? $this->db->escape_str(trim($data['txtnama']))
				: '';

			$born_place = !empty($data['txttempat_lahir'])
				? $data['txttempat_lahir']
				: '';

			$born_date = !empty($data['txttanggal_lahir'])
				? date('Y-m-d', strtotime($data['txttanggal_lahir']))
				: null;

			$handphone = !empty($data['txthandphone'])
				? preg_replace('/[^0-9]/', '', $data['txthandphone'])
				: '';

			$position = !empty($data['position_applied'])
				? $data['position_applied']
				: '';
			$recruitmentId = isset($data['recruitment_id']) 
				? $data['recruitment_id'] 
				: '';

			$vesselType = isset($data['vessel_type']) 
				? $data['vessel_type'] 
				: '';
			$joinDate 	 = isset($data['join_date']) 
				? $data['join_date'] 
				: '';

			$today = new DateTime();
			$birth = DateTime::createFromFormat('Y-m-d', $born_date);
			if (!$birth) throw new Exception("Format tanggal lahir tidak valid.");
			$age = $today->diff($birth)->y;
			if ($age < 18 || $age > 55) throw new Exception("Usia pelamar harus antara 18 hingga 55 tahun.");

			$dataIns = array(
				'id'                     => $applicantId,
				'email'                  => $email,
				'fullname'               => $fullname,
				'born_place'             => $born_place,
				'born_date'              => $born_date,
				'handphone'              => $handphone,
				'position_applied'       => $position,
				'recruitment_id'         => $recruitmentId,
				'vessel_type'            => $vesselType,
				'position_existing'      => $position,
				'ijazah_terakhir'        => $data['ijazah_terakhir'],
				'join_inAndhika'         => ($data['pernah_join'] === 'Y') ? 'Y' : 'N',
				'join_date'  			 => $joinDate,
				'info_source'            => $data['info_source'],
				'gender'                 => isset($data['gender']) ? $data['gender'] : null,
			);

			if (stripos($position, 'cadet') !== false) {
				if (empty($data['ipk_terakhir'])) {
					throw new Exception("IPK wajib diisi untuk posisi Cadet.");
				}
				if (empty($data['sekolah']) || empty($data['jurusan'])) {
					throw new Exception("Sekolah dan Jurusan wajib diisi untuk posisi Cadet.");
				}

				$dataIns['ipk_terakhir']          = $data['ipk_terakhir'];
				$dataIns['last_experience']       = ''; 
				$dataIns['berlayardengancrewasing'] = 'N';
				$dataIns['pengalaman_jeniskapal'] = '';
				$dataIns['last_salary']           = '';
				$dataIns['sekolah']               = $data['sekolah'];
				$dataIns['jurusan']               = $data['jurusan'];

			} else {
				if (empty($data['pengalaman_terakhir'])) {
					throw new Exception("Pengalaman terakhir wajib diisi untuk posisi non-Cadet.");
				}
				if (empty($data['last_salary'])) {
					throw new Exception("Gaji terakhir wajib diisi untuk posisi non-Cadet.");
				}

				$crewForeign = ($data['crew_foreign'] === 'Y') 
					? 'Y - ' . (isset($data['foreign_country']) ? $data['foreign_country'] : '') 
					: 'N';

				$dataIns['last_experience']        = $data['pengalaman_terakhir'];
				$dataIns['ipk_terakhir']           = '';
				$dataIns['last_salary']            = $data['last_salary'];
				$dataIns['pengalaman_jeniskapal']  = isset($data['kapal']) ? implode(', ', $data['kapal']) : '';
				$dataIns['berlayardengancrewasing']= $crewForeign;
				$dataIns['sekolah']                = '';
				$dataIns['jurusan']                = '';
			}

			$uploadDir = 'assets/uploads/CV_NewApplicant/';
			if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

			if (!empty($files['cv_files']['tmp_name'][0])) {
				$tmpName  = $files['cv_files']['tmp_name'][0];
				$fileName = basename($files['cv_files']['name'][0]);
				$fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
				$fileSize = $files['cv_files']['size'][0];
				$fileError= $files['cv_files']['error'][0];

				if ($fileError !== UPLOAD_ERR_OK) throw new Exception("Error upload file: $fileName");
				if ($fileType !== 'pdf') throw new Exception("Hanya PDF yang diizinkan: $fileName");
				if ($fileSize > 5 * 1024 * 1024) throw new Exception("File terlalu besar (maks 5MB): $fileName");

				$newFileName = "NewApplicant_" . date('YmdHis') . "." . $fileType;
				if (!move_uploaded_file($tmpName, $uploadDir . $newFileName)) {
					throw new Exception("Gagal menyimpan CV: $fileName");
				}
				
				$dataIns['new_cv'] = $newFileName;
				
				$cvFullPath = $uploadDir . $newFileName;
			} else {
				throw new Exception("Harap unggah CV");
			}

			$this->MCrewscv->insData('new_applicant', $dataIns);
			$applicantId = $this->db->insert_id();

			$this->sendCvToN8n(
				FCPATH . $cvFullPath,
				$applicantId,
				$email,
				$position
			);

			$this->sendSubmitNotification($email, $fullname);


			echo json_encode(array('status' => 'success', 'message' => 'Data berhasil disimpan.'));			

		} catch (Exception $e) {
			echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
		}
	}

	private function sendCvToN8n($filePath, $applicantId, $email, $position)
	{
		$n8nWebhook = 'https://n8n.apps.andhika.com/webhook/read-cv';

		if (!file_exists($filePath)) return;

		
		$postData = array(
			'applicant_id' => $applicantId,
			'email'        => $email,
			'position'     => $position,
			'cv_file'      => '@' . realpath($filePath)
		);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $n8nWebhook);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'X-N8N-TOKEN: ANDHIKA_N8N_SECRET'
		));

		
		if (defined('CURLOPT_SAFE_UPLOAD')) {
			curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
		}

		curl_exec($ch);
		curl_close($ch);
	}

	function sendSubmitNotification($recipientEmail, $fullName)
	{
		require_once APPPATH . 'third_party/PHPMailer/PHPMailer/class.phpmailer.php';
		require_once APPPATH . 'third_party/PHPMailer/PHPMailer/class.smtp.php';

		$mail = new PHPMailer();

		try {
			$mail->isSMTP();
			$mail->Host       = 'smtp.zoho.com';
			$mail->SMTPAuth   = true;
			$mail->Username   = 'noreply@andhika.com';
			$mail->Password   = 'PCWLzCWDQH8C';
			$mail->SMTPSecure = 'tls';
			$mail->Port       = 587;

			$mail->setFrom('noreply@andhika.com', 'Crewing PT Andhika Lines');
			$mail->addAddress($recipientEmail);

			$mail->AddEmbeddedImage(APPPATH . '../assets/img/logo_andhika.png', 'logo_andhika');
			
			$mail->isHTML(true);
			$mail->Subject = 'Terima Kasih - Lamaran Anda Telah Diterima';

			$mail->Body = "
				<div style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px;'>
					<div style='max-width: 600px; margin: auto; background-color: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #e0e0e0;'>

						<div style='background-color: #ffffffff; padding: 20px; text-align: center;'>
							<img src='cid:logo_andhika' alt='PT Andhika Lines' style='max-width: 180px;'>
						</div>

						<div style='padding: 30px; color: #333; font-size: 14px; line-height: 1.6;'>
							<p>Yth. <strong>$fullName</strong>,</p>

							<p>Terima kasih atas lamaran Anda ke <strong>PT Andhika Lines</strong>.</p>
							<p>Formulir dan CV Anda telah berhasil kami terima. Tim Crewing kami akan meninjau informasi Anda dan menghubungi Anda lebih lanjut apabila terdapat kecocokan dengan kebutuhan kami saat ini.</p>

							<p>Hormat kami,<br>
							<strong>Tim Crewing</strong><br>
							PT Andhika Lines</p>
						</div>

						<hr style='border: none; border-top: 1px solid #ccc; margin-top: 40px;'>
						
						<div style='background-color: #f9f9f9; padding: 20px; font-size: 13px; color: #555;'>
							<p style='margin-bottom: 8px; font-weight: bold;'>Ikuti kami untuk informasi terbaru:</p>
							<ul style='list-style: none; padding-left: 0; margin: 0;'>
								<li style='margin-bottom: 6px;'>
								<img src='https://cdn-icons-png.flaticon.com/24/1384/1384031.png' alt='Instagram' style='vertical-align: middle; margin-right: 8px;'> 
								<a href='https://www.instagram.com/andhika.group/' style='text-decoration: none; color: #003366;'>@andhika.group</a>
								</li>
								<li style='margin-bottom: 6px;'>
								<img src='https://cdn-icons-png.flaticon.com/24/1384/1384031.png' alt='Instagram' style='vertical-align: middle; margin-right: 8px;'> 
								<a href='https://www.instagram.com/lifeatandhika/' style='text-decoration: none; color: #003366;'>@lifeatandhika</a>
								</li>
								<li>
								<img src='https://cdn-icons-png.flaticon.com/24/841/841364.png' alt='Website' style='vertical-align: middle; margin-right: 8px;'> 
								<a href='https://andhika.com/' style='text-decoration: none; color: #003366;'>www.andhika.com</a>
								</li>
							</ul>

							<p style='margin-top: 20px; font-size: 12px; color: #888; text-align: center;'>
								<em>Email ini dikirim otomatis oleh sistem Crewing PT Andhika Lines. Mohon tidak membalas email ini.</em>
							</p>
						</div>
					</div>
				</div>
			";

			if (!$mail->send()) {
				log_message('error', "Submit Email failed to $recipientEmail: " . $mail->ErrorInfo);
			} else {
				log_message('info', "Submit email sent to $recipientEmail");
			}
		} catch (Exception $e) {
			log_message('error', 'Exception while sending submit email: ' . $e->getMessage());
		}
	}

	function indexMasterCrewUser()
	{
		$data = array(
			'title' => 'Crew User Login',
			'active_menu' => 'crew_user_login',
			'content' => 'MasterData/MasterUserCrewLogin/MasterUserCrewLoginView'
		);

		$this->load->view('menu/MasterMenu/main_MasterUserCrewLogin', $data);
	}

	function getDataMasterCrewUser()
	{
		header('Content-Type: application/json');

		$whereNya = " WHERE sts_delete = '0'";
		$data = array();
		$no = 1;

		if ($this->input->post('search') === 'search') {
			$txtSearch = $this->input->post('txtSearch');
			if (!empty($txtSearch)) {
				$whereNya .= " AND fullname LIKE '%".$txtSearch."%'";
			}
		}

		$sql = "SELECT id, idperson, fullname, username, password 
				FROM crew_login 
				".$whereNya." 
				ORDER BY fullname ASC";

		$rsl = $this->MCrewscv->getDataQuery($sql);

		if ($rsl) {
			foreach ($rsl as $row) {
				$data[] = array(
					'no'       => $no++,
					'id'       => $row->id,
					'idperson' => $row->idperson,
					'fullname' => $row->fullname,
					'username' => $row->username,
					'password' => $row->password
				);
			}
		}

		echo json_encode(array(
			'status' => true,
			'data'   => $data
		));
	}

	function saveDataUserMaster()
	{
		if (!$this->input->is_ajax_request()) {
			return;
		}

		header('Content-Type: application/json');

		$data = $this->input->post();
		$idEdit = isset($data['idEdit']) ? $data['idEdit'] : '';
		$userDateTimeNow = $this->session->userdata('userCrewSystem')
							. "/" . date('Ymd') . "/" . date('H:i:s');

		try {

			if (empty($data['txtidperson']) || empty($data['txtfullname']) || empty($data['txtusername'])) {
				echo json_encode(array(
					'status'  => false,
					'message' => 'Required field is empty'
				));
				return;
			}

			$dataIns = array(
				'idperson' => $data['txtidperson'],
				'fullname' => $data['txtfullname'],
				'username' => $data['txtusername']
			);

			if (!empty($data['txtpassword'])) {
				$dataIns['password'] = md5($data['txtpassword']);
			}

			if ($idEdit == "") {
				$dataIns['AddUsrDt'] = $userDateTimeNow;
				$this->MCrewscv->insData("crew_login", $dataIns);

				echo json_encode(array(
					'status'  => true,
					'message' => 'Save Success'
				));
			} else {
				// UPDATE
				$dataIns['UpdUsrDt'] = $userDateTimeNow;
				$whereNya = "id = '".$idEdit."'";
				$this->MCrewscv->updateData($whereNya, $dataIns, "crew_login");

				echo json_encode(array(
					'status'  => true,
					'message' => 'Update Success'
				));
			}

		} catch (Exception $ex) {

			echo json_encode(array(
				'status'  => false,
				'message' => $ex->getMessage()
			));
		}
	}

	function indexCertMatrix() {
		$data = array(
			'title' => 'Matrix Certificate',
			'active_menu' => 'matrix_certificate',
			'content' => 'MasterData/MasterMatrixCertificate/MasterMatrixCertificateView'
		);

		$this->load->view('menu/MasterMenu/main_MasterMatrixCertificate', $data);
	}

	function getMstVesselByOptionArray()
	{
		$data = array();

		$sql = "
			SELECT 
				kdvsl,
				nmvsl,
				descvsl
			FROM mstvessel
			WHERE deletests = '0'
			ORDER BY descvsl ASC, nmvsl ASC
		";

		$rsl = $this->MCrewscv->getDataQuery($sql);

		if ($rsl) {
			foreach ($rsl as $row) {
				$data[] = array(
					'id'    => $row->kdvsl,
					'name'  => $row->nmvsl,
					'label' => '(' . $row->descvsl . ') ' . $row->nmvsl
				);
			}
		}

		return $data;
	}

	function getMstCertificateByOptionArray()
	{
		$data = array();

		$sql = "
			SELECT 
				kdcert, 
				certname, 
				certgroup
			FROM mstcert
			WHERE deletests = '0'
			ORDER BY certgroup ASC, certname ASC
		";

		$rsl = $this->MCrewscv->getDataQuery($sql);

		if ($rsl) {
			foreach ($rsl as $row) {
				$data[] = array(
					'id'    => $row->kdcert,
					'name'  => $row->certname,
					'label' => '(' . $row->certgroup . ') ' . $row->certname
				);
			}
		}

		return $data;
	}

	function getDataCertificateMatrix()
	{
		header('Content-Type: application/json');

		$data = array();
		$whereNya = "";

		$txtSearch = $this->input->post('txtSearch', true);
		if (!empty($txtSearch)) {
			$txtSearch = $this->db->escape_like_str($txtSearch);
			$whereNya .= " AND B.nmrank LIKE '%{$txtSearch}%' ";
		}

		$sql = "
			SELECT 
				A.id,
				A.rank_id,
				B.nmrank AS rank_name,
				CASE 
					WHEN UPPER(A.certificate_name) IN ('PASSPORT', 'SEAMAN BOOK') THEN ''
					ELSE A.certificate_name
				END AS certificate_name
			FROM mstcertificatematrix A
			JOIN mstrank B 
				ON A.rank_id = B.kdrank
			WHERE B.deletests = '0'
			AND B.urutan > 0
			{$whereNya}
			ORDER BY B.urutan ASC, B.nmrank ASC, A.certificate_name ASC
		";

		$rsl = $this->MCrewscv->getDataQuery($sql);

		if ($rsl) {
			foreach ($rsl as $row) {

				if ($row->certificate_name === '') {
					continue;
				}

				$data[$row->rank_name][] = array(
					'id'               => $row->id,
					'certificate_name' => $row->certificate_name
				);
			}
		}

		echo json_encode(array(
			'status' => true,
			'data'   => $data
		));
	}

	function saveDataCertificateMatrix()
	{
		header('Content-Type: application/json');

		try {

			$idEdit       = trim($this->input->post('idEdit')); 
			$kdvsl        = $this->input->post('kdvsl');
			$rank_id      = $this->input->post('rankCode');
			$rank_name    = $this->input->post('rankName');
			$certificates = $this->input->post('certificates');

			if (!$kdvsl || !$rank_id || !$rank_name) {
				echo json_encode(array(
					'status' => false,
					'message' => 'Vessel / Rank tidak valid'
				));
				return;
			}

			if (empty($certificates)) {
				echo json_encode(array(
					'status' => false,
					'message' => 'Certificate wajib dipilih'
				));
				return;
			}

			if (!empty($idEdit)) {

				$this->MCrewscv->updateData(
					array('id' => $idEdit),
					array(
						'kdvsl'     => $kdvsl,
						'rank_id'   => $rank_id,
						'rank_name' => $rank_name
					),
					'mstcertificatematrix'
				);
			}

			foreach ($certificates as $cert) {

				$exist = $this->MCrewscv->getDataQuery("
					SELECT id
					FROM mstcertificatematrix
					WHERE kdvsl = '{$kdvsl}'
					AND rank_id = '{$rank_id}'
					AND certificate_name = '{$cert}'
					LIMIT 1
				");

				if ($exist) {
					continue;
				}

				$this->MCrewscv->insData("mstcertificatematrix", array(
					'kdvsl'            => $kdvsl,
					'rank_id'          => $rank_id,
					'rank_name'        => $rank_name,
					'certificate_name' => $cert
				));
			}

			echo json_encode(array(
				'status'  => true,
				'message' => 'Certificate Matrix saved successfully'
			));

		} catch (Exception $e) {
			echo json_encode(array(
				'status' => false,
				'message' => $e->getMessage()
			));
		}
	}

	function indexCrewUser()
	{
		$data = array(
			'title' => 'User System',
			'active_menu' => 'user_system',
			'content' => 'MasterData/MasterUserSystem/MasterUserSystemView'
		);

		$this->load->view('menu/MasterMenu/main_MasterUserSystemView', $data);
	}

	function getDataMasterUserSystem()
	{
		header('Content-Type: application/json');

		$whereNya = " WHERE status = '0' ";

		$search = $this->input->post('search');
		$txtSearch = $this->input->post('txtSearch');

		if ($search === 'search' && !empty($txtSearch)) {
			$whereNya .= " AND userFullNm LIKE '%".$txtSearch."%' ";
		}

		$sql = "SELECT * FROM login ".$whereNya." ORDER BY userFullNm ASC ";
		$rsl = $this->MCrewscv->getDataQuery($sql);

		$data = array();
		$no = 1;

		foreach ($rsl as $val) {

			$data[] = array(
				'no'        => $no,
				'id'        => $val->userId,
				'userName'  => $val->userName,
				'fullName'  => $val->userFullNm,
				'password'  => $val->userPass,
				'jenis'     => $val->userJenis,
				'init'      => $val->userInit
			);

			$no++;
		}

		echo json_encode(array(
			'status' => true,
			'data'   => $data
		));
	}

	function saveDataMasterUser()
	{
		header('Content-Type: application/json');

		$data = $this->input->post();
		$idEdit = isset($data['idEdit']) ? $data['idEdit'] : '';

		$dataIns = array();

		try {

			$dataIns['userName']   = isset($data['txtusername']) ? $data['txtusername'] : '';
			$dataIns['userFullNm'] = isset($data['txtuserfullname']) ? $data['txtuserfullname'] : '';
			$dataIns['userJenis']  = isset($data['txtuserjenis']) ? $data['txtuserjenis'] : '';
			$dataIns['userInit']   = isset($data['txtuserinit']) ? $data['txtuserinit'] : '';

			if (!empty($data['txtuserpassword'])) {
				$dataIns['userPass'] = md5($data['txtuserpassword']);
			}

			if ($idEdit == "") {
				$this->MCrewscv->insData("login", $dataIns);
			} else {
				$whereNya = "userId = '".$idEdit."'";
				$this->MCrewscv->updateData($whereNya, $dataIns, "login");
			}

			echo json_encode(array(
				'status'  => true,
				'message' => 'Save success'
			));

		} catch (Exception $e) {

			echo json_encode(array(
				'status'  => false,
				'message' => $e->getMessage()
			));
		}
	}

	function indexMasterClinic()
	{
		$data = array(
			'title' => 'Master Clinic',
			'active_menu' => 'master_clinic',
			'content' => 'MasterData/MasterClinic/MasterClinicView'
		);

		$this->load->view('menu/MasterMenu/main_MasterClinic', $data);
	}

	function getDataMasterClinic()
	{
		header('Content-Type: application/json');

		$whereNya = " WHERE deletests = '0' ";

		$search = $this->input->post('search');
		$txtSearch = $this->input->post('txtSearch');

		if ($search === 'search' && !empty($txtSearch)) {
			$whereNya .= " AND clinic_name LIKE '%".$txtSearch."%' ";
		}

		$sql = "SELECT * FROM master_mcu ".$whereNya." ORDER BY clinic_name ASC ";
		$rsl = $this->MCrewscv->getDataQuery($sql);

		echo json_encode(array(
			'status' => true,
			'data'   => $rsl
		));
	}

	function saveDataClinic()
	{
		header('Content-Type: application/json');

		$data = $this->input->post();
		$idEdit = isset($data['idEdit']) ? $data['idEdit'] : '';
		
		$dataIns = array();
	
		try {

			$dataIns['clinic_name'] 	   = isset($data['txtClinicName']) ? $data['txtClinicName'] : '';
			$dataIns['address_clinic']     = isset($data['txtClinicAddress']) ? $data['txtClinicAddress'] : '';
			$dataIns['telp']               = isset($data['txtTelp']) ? $data['txtTelp'] : '';
			$dataIns['fax']                = isset($data['txtFax']) ? $data['txtFax'] : '';
			$dataIns['email']              = isset($data['txtEmail']) ? $data['txtEmail'] : '';

			if ($idEdit == "") {
				$this->MCrewscv->insData("master_mcu", $dataIns);
			} else {
				$whereNya = "id = '".$idEdit."'";
				$this->MCrewscv->updateData($whereNya, $dataIns, "master_mcu");
			}

			echo json_encode(array(
				'status'  => true,
				'message' => 'Save success'
			));

		} catch (Exception $e) {

			echo json_encode(array(
				'status'  => false,
				'message' => $e->getMessage()
			));
		}
	}

	function indexMasterVendorTraining()
	{
		$data = array(
			'title' => 'Vendor Training',
			'active_menu' => 'master_vendor_training',
			'content' => 'MasterData/MasterVendorTraining/MasterVendorTrainingView'
		);

		$this->load->view('menu/MasterMenu/main_MasterVendorTraining', $data);
	}

	function getFullNameByIdPerson($idPerson = "")
	{
		$fullName = "";

		$sql = "SELECT TRIM(CONCAT(fname,' ',mname,' ' ,lname)) AS fullName
				FROM mstpersonal WHERE deletests = '0' AND idperson = '".$idPerson."' ";
		$rsl = $this->MCrewscv->getDataQuery($sql);

		if(count($rsl) > 0)
		{
			$fullName = $rsl[0]->fullName;
		}

		return $fullName;
	}

	function getMstPersonal($return = "",$whereNya = "")
	{
		$dataOut = array();

		$dataOut = $this->MCrewscv->getData("*","mstpersonal",$whereNya);

		if($return == "")
		{
			return $dataOut;
		}else{
			print json_encode($dataOut);
		}
	}

	function cekPersonOnVessel($idPerson = "")
	{
		$stPerson = "";

		$sql = "SELECT idcontract, idperson, CASE WHEN (signoffdt != '0000-00-00' AND signoffdt <= CURDATE()) THEN 'onleave' WHEN signoffdt = '0000-00-00' THEN 'onboard' END AS status
				FROM tblcontract 
				where idperson='".$idPerson."' AND deletests=0 ORDER BY idcontract DESC limit 0,1";
		$rsl = $this->MCrewscv->getDataQuery($sql);

		if(count($rsl) > 0)
		{
			$stPerson = $rsl[0]->status;
		}

		return $stPerson;
	}

	function getDataRank()
	{
		$whereNya = " WHERE Deletests = '0' AND nmrank != '' ";
		$sql = "SELECT * FROM mstrank " . $whereNya . " ORDER BY urutan ASC";
		$rsl = $this->MCrewscv->getDataQuery($sql);

		return !empty($rsl) ? $rsl : array();
	}

	function getCrewOnLeaveByRank() {
		$sqlCrewOnLeave = "SELECT A.idperson, CONCAT(A.fname, ' ', IFNULL(A.mname, ''), ' ', A.lname) AS crew_name, 
							RANK.nmrank
						FROM mstpersonal A
						LEFT JOIN tblcontract B ON A.idperson = B.idperson
						LEFT JOIN mstrank RANK ON B.signonrank = RANK.kdrank
						WHERE A.deletests = '0' 
						AND RANK.urutan > 0
						AND B.deletests = '0' 
						AND A.inAktif = '0' 
						AND A.inBlacklist = '0'
						AND B.idcontract IN (
							SELECT MAX(idcontract) 
							FROM tblcontract 
							WHERE idperson = B.idperson 
							AND deletests = 0
						)
						AND (B.signoffdt != '0000-00-00' AND B.signoffdt <= CURDATE())
						ORDER BY RANK.urutan ASC";
		return $this->MCrewscv->getDataQuery($sqlCrewOnLeave);
	}

	function getFormatDate($date)
	{
		$timestamp = strtotime($date);
		return date('d-M-Y', $timestamp);
	}	

	function getCityByOption($return = "",$typeVal = "")
	{
		$opt = "";

		$rsl = $this->MCrewscv->getData("*","tblkota","Deletests = '0'","NmKota ASC");
		$opt .= "<option value=\"\">- Select Kota -</option>";
		foreach ($rsl as $key => $val)
		{
			if($typeVal == "name")
			{
				$opt .= "<option value=\"".$val->NmKota."\">".$val->NmKota."</option>";
			}
			if($typeVal == "kode")
			{
				$opt .= "<option value=\"".$val->KdKota."\">".$val->NmKota."</option>";
			}			
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}


	function getCityNameById($id)
	{
			if (empty($id)) return '';
			
			$this->db->select('NmKota');
			$this->db->from('tblkota');
			$this->db->where('Deletests', '0');
			$this->db->where('KdKota', $id);
			$this->db->limit(1);
			
			$query = $this->db->get();
			$result = $query->row();
			
			return $result ? $result->NmKota : '';
	}

	function getCountryByOption($return = "",$typeVal = "")
	{
		$opt = "";

		$rsl = $this->MCrewscv->getData("*","tblnegara","Deletests = '0'","NmNegara ASC");

		foreach ($rsl as $key => $val)
		{
			if($typeVal == "name")
			{
				$opt .= "<option value=\"".$val->NmNegara."\">".$val->NmNegara."</option>";
			}
			if($typeVal == "kode")
			{
				$opt .= "<option value=\"".$val->KdNegara."\">".$val->NmNegara."</option>";
			}			
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}

	function getTaxByOption($return = "") {
		$opt = "<option value=''></option>";
		$rsl = $this->MCrewscv->getData("*","tbltaxsts");

		foreach ($rsl as $key => $val) {
			$opt .= "<option value=\"".$val->id."\">".$val->stsnm."</option>";
		}

		if($return == "") {
			return $opt;
		} else {
			print json_encode($opt);
		}
	}

	function getTaxStatusById($id)
	{
		if (empty($id)) return '';
			
		$this->db->select('stsnm');
		$this->db->from('tbltaxsts');
		$this->db->where('id', $id);
		$this->db->limit(1);
			
		$query = $this->db->get();
		$result = $query->row();
			
		return $result ? $result->stsnm : '';
	}

	function getVesselByOption($return = "",$typeVal = "",$searchNya = "")
	{
		$opt = "<option value=''> - </option>";

		$whereNya = "deletests = '0' AND st_display = 'Y'";

		if($searchNya != "" AND $searchNya != "017")
		{
			$whereNya .= " AND kdcmp = '".$searchNya."' ";
		}

		$rsl = $this->MCrewscv->getData("*","mstvessel",$whereNya,"nmvsl ASC");

		foreach ($rsl as $key => $val)
		{
			if($typeVal == "name")
			{
				$opt .= "<option value=\"".$val->nmvsl."\">".$val->nmvsl."</option>";
			}
			if($typeVal == "kode")
			{
				$opt .= "<option value=\"".$val->kdvsl."\">".$val->nmvsl."</option>";
			}
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}

	function getRecruitment()
	{
		$output = "";

		$sql = "
			SELECT 
				R.*, 
				M.urutan 
			FROM tblopenrecruitment R
			LEFT JOIN mstrank M 
				ON R.rank = M.nmrank
			WHERE R.deletests = '0'
			AND R.sts_publish = 'Y'
			AND M.urutan > 0
			ORDER BY 
				R.vesselType ASC,
				M.urutan ASC,
				R.subject_name ASC
		";

		$results = $this->MCrewscv->getDataQuery($sql);

		if (empty($results)) {
			return "
				<div style='
					padding:60px 20px;
					text-align:center;
					background:#f8fafc;
					border-radius:24px;
					border:1px dashed #cbd5e1;
				'>
					<div style='font-size:52px;margin-bottom:10px;'>🚢</div>

					<div style='
						font-size:22px;
						font-weight:800;
						color:#0f172a;
					'>
						No Open Recruitment
					</div>

					<div style='
						margin-top:8px;
						color:#64748b;
						font-size:14px;
					'>
						Currently there are no active vacancies available
					</div>
				</div>
			";
		}

		/*
		|--------------------------------------------------------------------------
		| GROUPING BY VESSEL
		|--------------------------------------------------------------------------
		*/
		$grouped = array();

		foreach ($results as $row) {

			$vessel = trim($row->vesselType);

			if ($vessel == "") {
				$vessel = "OTHER VESSEL";
			}

			$grouped[$vessel][] = $row;
		}

		/*
		|--------------------------------------------------------------------------
		| MAIN CONTAINER
		|--------------------------------------------------------------------------
		*/
		$output .= "
		<div style='display:flex;flex-direction:column;gap:32px;'>
		";

		foreach ($grouped as $vesselName => $jobs) {

			$totalJobs = count($jobs);

			/*
			|--------------------------------------------------------------------------
			| VESSEL SECTION
			|--------------------------------------------------------------------------
			*/
			$output .= "
			<div style='
				background:#ffffff;
				border-radius:28px;
				border:1px solid #e2e8f0;
				overflow:hidden;
				box-shadow:0 10px 35px rgba(15,23,42,.05);
			'>
			";

			/*
			|--------------------------------------------------------------------------
			| VESSEL HEADER
			|--------------------------------------------------------------------------
			*/
			$output .= "
			<div class='vesselToggle'
				style='
					padding:24px 28px;
					background:linear-gradient(
						135deg,
						#eff6ff 0%,
						#ffffff 100%
					);
					cursor:pointer;
					display:flex;
					align-items:center;
					justify-content:space-between;
					gap:20px;
				'
			>

				<div style='display:flex;align-items:center;gap:18px;'>

					<div style='
						width:64px;
						height:64px;
						border-radius:20px;
						background:linear-gradient(135deg,#2563eb,#1d4ed8);
						display:flex;
						align-items:center;
						justify-content:center;
						font-size:28px;
						color:#fff;
						box-shadow:0 10px 25px rgba(37,99,235,.30);
					'>
						🚢
					</div>

					<div>

						<div style='
							font-size:24px;
							font-weight:900;
							color:#0f172a;
							line-height:1.2;
						'>
							".htmlspecialchars($vesselName)."
						</div>

						<div style='
							margin-top:6px;
							font-size:14px;
							color:#64748b;
						'>
							".$totalJobs." Open Position".($totalJobs > 1 ? "s" : "")."
						</div>

					</div>

				</div>

				<div class='toggleIcon'
					style='
						font-size:22px;
						color:#2563eb;
						font-weight:800;
						transition:.3s;
					'
				>
					▼
				</div>

			</div>
			";

			/*
			|--------------------------------------------------------------------------
			| JOB CONTAINER
			|--------------------------------------------------------------------------
			*/
			$output .= "
			<div class='vesselJobs'
				style='
					padding:28px;
					display:none;
					grid-template-columns:repeat(auto-fill,minmax(320px,1fr));
					gap:22px;
					overflow:hidden;
				'
			>
			";

			foreach ($jobs as $job) {

				$output .= "
				<div style='
					background:#ffffff;
					border:1px solid #e2e8f0;
					border-radius:22px;
					padding:22px;
					position:relative;
					transition:.25s;
				'
				onmouseover=\"
					this.style.transform='translateY(-4px)';
					this.style.boxShadow='0 16px 35px rgba(15,23,42,.08)';
				\"
				onmouseout=\"
					this.style.transform='translateY(0)';
					this.style.boxShadow='none';
				\"
				>

					<div style='
						display:flex;
						align-items:center;
						justify-content:space-between;
						margin-bottom:16px;
					'>

						<div style='
							font-size:12px;
							font-weight:800;
							color:#2563eb;
							background:#eff6ff;
							padding:8px 12px;
							border-radius:999px;
						'>
							⚓ ".htmlspecialchars($job->rank)."
						</div>

						<div style='
							font-size:11px;
							font-weight:800;
							color:#16a34a;
						'>
							OPEN
						</div>

					</div>

					<div style='
						font-size:18px;
						font-weight:800;
						color:#0f172a;
						line-height:1.4;
						min-height:52px;
					'>
						".htmlspecialchars($job->subject_name)."
					</div>

					<div style='
						margin-top:12px;
						font-size:13px;
						color:#64748b;
					'>
						Published ".$this->convertReturnNameWithTime($job->datePublish)."
					</div>
				";

				/*
				|--------------------------------------------------------------------------
				| REQUIREMENTS
				|--------------------------------------------------------------------------
				*/
				if (!empty($job->qualification)) {

					$output .= "

					<div onclick=\"showHiddenQuali(".$job->id.", 'show')\"
						id='showQuali_".$job->id."'
						style='
							margin-top:18px;
							display:inline-flex;
							align-items:center;
							gap:8px;
							padding:10px 14px;
							background:#f8fafc;
							border-radius:12px;
							font-size:13px;
							font-weight:700;
							color:#2563eb;
							cursor:pointer;
						'
					>
						📋 View Requirements
					</div>

					<div id='qualification_".$job->id."'
						style='
							display:none;
							margin-top:14px;
							padding:16px;
							background:#f8fafc;
							border:1px solid #e2e8f0;
							border-radius:14px;
							max-height:220px;
							overflow:auto;
						'
					>
					";

					$reqLines = explode("\n", $job->qualification);

					$output .= "<ul style='padding-left:18px;margin:0;'>";

					foreach ($reqLines as $line) {

						$line = trim($line);

						if ($line != "") {

							$output .= "
							<li style='
								font-size:13px;
								color:#334155;
								margin-bottom:8px;
								line-height:1.5;
							'>
								".htmlspecialchars($line)."
							</li>
							";
						}
					}

					$output .= "</ul></div>";
				}

				/*
				|--------------------------------------------------------------------------
				| APPLY BUTTON
				|--------------------------------------------------------------------------
				*/
				$output .= "
					<button
						type='button'
						onclick=\"selectRecruitment(
							'".$job->id."',
							'".htmlspecialchars($job->vesselType, ENT_QUOTES)."',
							'".htmlspecialchars($job->rank, ENT_QUOTES)."',
							'".htmlspecialchars($job->subject_name, ENT_QUOTES)."'
						)\"
						style='
							margin-top:22px;
							width:100%;
							border:none;
							border-radius:16px;
							padding:14px;
							background:linear-gradient(
								135deg,
								#2563eb,
								#1d4ed8
							);
							color:#ffffff;
							font-size:14px;
							font-weight:800;
							cursor:pointer;
							box-shadow:0 10px 20px rgba(37,99,235,.22);
						'
					>
						Apply Now →
					</button>

				</div>
				";
			}

			$output .= "</div>";
			$output .= "</div>";
		}

		$output .= "</div>";

		return $output;
	}


	function getRankByOption($return = "",$typeVal = "")
	{
		$opt = "<option value=''> - </option>";

		$rsl = $this->MCrewscv->getData("*", "mstrank", "deletests = '0' AND urutan > 0", "urutan ASC, nmrank ASC");
		foreach ($rsl as $key => $val)
		{
			if($typeVal == "name")
			{
				$opt .= "<option value=\"".$val->nmrank."\">".$val->nmrank."</option>";
			}
			if($typeVal == "kode")
			{
				$opt .= "<option value=\"".$val->kdrank."\">".$val->nmrank."</option>";
			}			
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}

	function getRankByCheckBox($return = "", $typeVal = "")
	{
		$html = '<div style="
			display: grid;
			grid-template-columns: repeat(13, 1fr);
			gap: 12px 20px;
			padding: 6px 0;
			align-items: center;
		">';

		$rsl = $this->MCrewscv->getData(
			"*",
			"mstrank",
			"deletests = '0' AND urutan > 0",
			"urutan ASC, nmrank ASC"
		);

		foreach ($rsl as $val) 
		{
			if ($typeVal == "name") {
				$value = $val->nmrank;
			} elseif ($typeVal == "kode") {
				$value = $val->kdrank;
			} else {
				$value = $val->kdrank; 
			}

			$label = $val->nmrank;
			$id    = "rank_" . $val->kdrank; 

			$html .= '
				<label for="'.$id.'" style="display:flex; align-items:center; gap:6px; white-space:nowrap; cursor:pointer; font-size:13px; color:#333;">
					<input type="checkbox"
						class="form-check-input"
						name="rankCheckbox[]"
						value="'.$value.'"
						id="'.$id.'"
						style="width:16px; height:16px; cursor:pointer; margin:0;">
					'.$label.'
				</label>
			';
		}

		$html .= "</div>";

		if ($return == "") {
			return $html;
		} else {
			print json_encode($html);
		}
	}

	function getCompanyByOption($mode = 'html', $typeVal = 'kode')
	{
		$rsl = $this->MCrewscv->getData(
			"*",
			"mstcmprec",
			"deletests = '0'",
			"nmcmp ASC"
		);

		if ($mode === 'array') {
			$out = array();
			foreach ($rsl as $val) {
				$out[] = array(
					'id'   => $val->kdcmp,
					'name' => $val->nmcmp
				);
			}
			return $out;
		}

		$opt = "";
		foreach ($rsl as $val) {
			if ($typeVal === "name") {
				$opt .= "<option value='{$val->nmcmp}'>{$val->nmcmp}</option>";
			} else {
				$opt .= "<option value='{$val->kdcmp}'>{$val->nmcmp}</option>";
			}
		}

		return $opt;
	}

	function getSignOffRemarkByOption($return = "",$typeVal = "")
	{
		$opt = "";

		$rsl = $this->MCrewscv->getData("*","mstremark","deletests = '0'","nmremark ASC");

		foreach ($rsl as $key => $val)
		{
			if($typeVal == "name")
			{
				$opt .= "<option value=\"".$val->nmremark."\">(".$val->nmremark.") ".$val->descremark."</option>";
			}
			if($typeVal == "kode")
			{
				$opt .= "<option value=\"".$val->kdremark."\">(".$val->nmremark.") ".$val->descremark."</option>";
			}			
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}

	function getVesselTypeByOption($return = "",$typeVal = "")
	{
		$opt = "";

		$whereNya = "Deletests = '0' AND NmType != ''";

		$rsl = $this->MCrewscv->getData("*","tbltype",$whereNya,"NmType ASC");

		foreach ($rsl as $key => $val)
		{
			if($typeVal == "name")
			{
				$opt .= "<option value=\"".$val->NmType."\">(".$val->NmType.") ".$val->DefType."</option>";
			}
			if($typeVal == "kode")
			{
				$opt .= "<option value=\"".$val->KdType."\">(".$val->NmType.") ".$val->DefType."</option>";
			}			
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}

	function getVesselTypeRecruitment()
	{
		$selected = $this->input->get('selected'); 

		$opt = "<option value=''>Select Vessel Type</option>"; 

		$whereNya = "Deletests = '0' AND DefType IN ('Bulk Carrier', 'OIL TANKER', 'CHEMICAL TANKER', 'FLOATING CRANE', 'TUG BOAT')";

		$rsl = $this->MCrewscv->getData("*", "tbltype", $whereNya, "NmType ASC");

		foreach ($rsl as $val) {

			$isSelected = ($selected == $val->DefType) ? "selected" : "";

			$opt .= "<option value=\"" . htmlspecialchars($val->DefType, ENT_QUOTES, 'UTF-8') . "\" $isSelected>" 
					. htmlspecialchars($val->DefType, ENT_QUOTES, 'UTF-8') . "</option>";
		}

		echo json_encode($opt); 
	}

	function getVesselType($return = "")
	{
		$opt = "<option value=''>Select Vessel Type</option>"; 

		$whereNya = "Deletests = '0' AND DefType IN ('Bulk Carrier', 'OIL TANKER', 'CHEMICAL TANKER', 'FLOATING CRANE', 'TUG BOAT')";

		$rsl = $this->MCrewscv->getData("*", "tbltype", $whereNya, "NmType ASC");

		foreach ($rsl as $val) {
			$opt .= "<option value=\"" . htmlspecialchars($val->DefType, ENT_QUOTES, 'UTF-8') . "\">" 
					. htmlspecialchars($val->DefType, ENT_QUOTES, 'UTF-8') . "</option>";
		}

		if ($return == "") {
			return $opt;
		} else {
			print json_encode($opt);
		}
	}


	function getCrewVesselTypeRecruitment($mode = 'html')
	{
		$whereNya = "Deletests = '0' 
					AND DefType IN ('Bulk Carrier', 'OIL TANKER', 'CHEMICAL TANKER', 'FLOATING CRANE', 'TUG BOAT')";

		$rsl = $this->MCrewscv->getData("*", "tbltype", $whereNya, "NmType ASC");

		if ($mode === 'array') {
			$out = array();
			foreach ($rsl as $val) {
				$out[] = $val->DefType;
			}
			return $out;
		}

		$opt = "<option value=''>Select Vessel Type</option>";
		foreach ($rsl as $val) {
			$opt .= "<option value='{$val->DefType}'>{$val->DefType}</option>";
		}

		return $opt;
	}

	function getCrewVesselType($return = "")
	{
		$opt = "<option value=''>Select Vessel Type</option>"; 

		$whereNya = "Deletests = '0' AND DefType IN ('Bulk Carrier', 'OIL TANKER', 'CHEMICAL TANKER', 'FLOATING CRANE', 'TUG BOAT')";

		$rsl = $this->MCrewscv->getData("*", "tbltype", $whereNya, "NmType ASC");

		foreach ($rsl as $val) {
			$opt .= "<option value=\"".$val->DefType."\">" 
					.$val->DefType."</option>";
		}

		if ($return == "") {
			return $opt;
		} else {
			print json_encode($opt);
		}
	}

	function getVesselOwnShipOption($return = "")
	{
		$options = "<label style='display: block; padding: 5px; cursor: pointer;'>
						<input type='checkbox' id='selectAllVesselsOwnShip'> <b>All</b>
					</label>";

		$whereNya = "Deletests = '0' AND st_display = 'Y' AND nmvsl IN (
			'MV. ANDHIKA ALISHA', 
			'MV. ANDHIKA ATHALIA', 
			'MT. ANDHIKA VIDYANATA', 
			'MV. ANDHIKA KANISHKA', 
			'MV. ANDHIKA PARAMESTI', 
			'MV. ANDHIKA SHAKILLA', 
			'MV. BULK HALMAHERA', 
			'MV. BULK BATAVIA', 
			'MV. BULK NUSANTARA'
		)";

		$rsl = $this->MCrewscv->getData("*", "mstvessel", $whereNya, "nmvsl ASC");

		if ($rsl) {
			foreach ($rsl as $row) {
				$options .= "<label style='display: block; padding: 5px; cursor: pointer;'>
								<input type='checkbox' name='vessels[]' value='".$row->nmvsl."'> ".$row->nmvsl."
							</label>";
			}
		}

		if ($return == "") {
			return $options;
		} else {
			print json_encode($options);
		}
	}

	function getVesselClientShipOption($return = "")
	{
		$options = "<label style='display: block; padding: 5px; cursor: pointer;'>
						<input type='checkbox' id='selectAllVesselsClientShip'> <b>All</b>
					</label>";

		$whereNya = "Deletests = '0' AND st_display = 'Y' AND nmvsl NOT IN (
			'MV. ANDHIKA ALISHA', 
			'MV. ANDHIKA ATHALIA', 
			'MT. ANDHIKA VIDYANATA', 
			'MV. ANDHIKA KANISHKA', 
			'MV. ANDHIKA PARAMESTI', 
			'MV. ANDHIKA SHAKILLA', 
			'MV. BULK HALMAHERA', 
			'MV. BULK BATAVIA', 
			'MV. BULK NUSANTARA'
		)";

		$rsl = $this->MCrewscv->getData("*", "mstvessel", $whereNya, "nmvsl ASC");

		if ($rsl) {
			foreach ($rsl as $row) {
				$options .= "<label style='display: block; padding: 5px; cursor: pointer;'>
								<input type='checkbox' name='vesselsClient[]' value='".$row->nmvsl."'> ".$row->nmvsl."
							</label>";
			}
		}

		if ($return == "") {
			return $options;
		} else {
			print json_encode($options);
		}
	}

	function getNameCompanyOption($return = "")
	{
		$options = "<label style='display: block; padding: 5px; cursor: pointer;'>
						<input type='checkbox' id='selectAllNameCompanyOption' name='NameCompanyOption[]' value ='All'> <b>All</b>
					</label>";

	
		$sql = "SELECT DISTINCT nmcmp 
				FROM mstvessel 
				WHERE Deletests = '0' 
				AND st_display = 'Y' 
				AND nmcmp IS NOT NULL 
				AND nmcmp != ''
				AND st_own ='N'
				ORDER BY nmcmp ASC";
		
		
		$query = $this->db->query($sql);
		$rsl = $query->result();

		if ($rsl) {
			foreach ($rsl as $row) {
				$options .= "<label style='display: block; padding: 5px; cursor: pointer;'>
								<input type='checkbox' name='NameCompanyOption[]' value='" . htmlspecialchars($row->nmcmp, ENT_QUOTES) . "'> " . htmlspecialchars($row->nmcmp) . "
							</label>";
			}
		}

		if ($return == "") {
			return $options;
		} else {
			echo json_encode($options);
		}
	}

	function getNameCompanyOwner($return = "")
	{

		$options = "<label style='display: block; padding: 5px; cursor: pointer;'>
						<input type='checkbox' id='selectAllNameCompanyOwner' name='NameCompanyOwner[]' value ='All'> <b>All</b>
					</label>";

		$sql = "SELECT DISTINCT nmcmp 
				FROM mstvessel 
				WHERE Deletests = '0' 
				AND st_display = 'Y' 
				AND nmcmp IS NOT NULL 
				AND nmcmp != ''
				AND st_own = 'Y'
				ORDER BY nmcmp ASC";
		
		
		$query = $this->db->query($sql);
		$rsl = $query->result();

		if ($rsl) {
			foreach ($rsl as $row) {
				$options .= "<label style='display: block; padding: 5px; cursor: pointer;'>
								<input type='checkbox' name='NameCompanyOwner[]' value='" . htmlspecialchars($row->nmcmp, ENT_QUOTES) . "'> " . htmlspecialchars($row->nmcmp) . "
							</label>";
			}
		}

		if ($return == "") {
			return $options;
		} else {
			echo json_encode($options);
		}
	}

	function getMstCertificateByOption($return = "", $typeVal = "")
	{
		$opt = "";
		
		$opt .= "<option value=\"\">Select Certificate</option>";

		$rsl = $this->MCrewscv->getData(
			"*",
			"mstcert",
			"deletests = '0'",
			"certgroup, certname ASC"
		);

		foreach ($rsl as $val) {

			$displayName = "(" . $val->certgroup . ") " . $val->certname;

			if ($typeVal == "nama") {
				$opt .= "<option value=\"" . $val->certname . "\">" . $displayName . "</option>";
			} elseif ($typeVal == "kode") {
				$opt .= "<option value=\"" . $val->kdcert . "\">" . $displayName . "</option>";
			} else {
				$opt .= "<option value=\"" . $val->kdcert . "\">" . $displayName . "</option>";
			}
		}

		if ($return == "") {
			return $opt;
		} else {
			print json_encode($opt);
		}
	}


	function getMstRankByOption($return = "")
	{
		$opt = "";

		$rsl = $this->MCrewscv->getData("*","mstrank","deletests = '0'","nmrank ASC");
		foreach ($rsl as $key => $val)
		{
			$opt .= "<option value=\"".$val->kdrank."\">".$val->nmrank."</option>";
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}

	function getMstRankByOptionWithSelected($return = "", $selectedRankName = "")
	{
		$opt = "";

		$rsl = $this->MCrewscv->getData("*","mstrank","deletests = '0'","nmrank ASC");
		foreach ($rsl as $key => $val)
		{
			$selected = "";
			if($val->nmrank == $selectedRankName)
			{
				$selected = " selected=\"selected\"";
			}
			$opt .= "<option value=\"".$val->nmrank."\"".$selected.">".$val->nmrank."</option>";
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}

	function getMstVesselTypeByOptionWithSelected($return = "", $selectedvesselType = "")
	{
		$opt = "";

		$whereNya = "deletests = '0' AND DefType IN ('Bulk Carrier', 'OIL TANKER', 'CHEMICAL TANKER', 'FLOATING CRANE', 'TUG BOAT')";
		$rsl = $this->MCrewscv->getData("*","tbltype",$whereNya,"DefType ASC");
		
		foreach ($rsl as $key => $val)
		{
			$selected = "";
			if($val->DefType == $selectedvesselType)
			{
				$selected = " selected=\"selected\"";
			}
			$opt .= "<option value=\"".$val->DefType."\"".$selected.">".$val->DefType."</option>";
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}


	function getMenuGeneralByOption($idPerson = "",$ref1 = "",$ref2 = "")
	{
		$dataOut = array();
		$opt = "";
		$opt1 = "";
		$opt2 = "";
		$opt .= "<option value=\"\">-</option>";

		$rsl = $this->MCrewscv->getData("*","tblrefcmp","deletests = '0' AND idperson = '".$idPerson."'","refcmp ASC");

		if(count($rsl) > 0)
		{
			foreach ($rsl as $key => $val)
			{
				$opt .= "<option value=\"".$val->idref."\">".$val->refcmp." (".$val->refpic.")"."</option>";
			}

			if($ref1 != "")
			{
				$opt1 .= "<option value=\"\">-</option>";
				foreach ($rsl as $key => $val)
				{
					$selNya = "";

					if($val->idref == $ref1)
					{
						$selNya = "selected=\"selected\"";
					}
					$opt1 .= "<option value=\"".$val->idref."\" ".$selNya.">".$val->refcmp." (".$val->refpic.")"."</option>";
				}
			}else{
				$opt1 = $opt;
			}

			if($ref2 != "")
			{
				$opt2 .= "<option value=\"\">-</option>";
				foreach ($rsl as $key => $val)
				{
					$selNya = "";

					if($val->idref == $ref2)
					{
						$selNya = "selected=\"selected\"";
					}
					$opt2 .= "<option value=\"".$val->idref."\" ".$selNya.">".$val->refcmp." (".$val->refpic.")"."</option>";
				}
			}else{
				$opt2 = $opt;
			}
		}

		$dataOut['ref1'] = $opt1;
		$dataOut['ref2'] = $opt2;

		return $dataOut;
	}

	function getReplacementByOption($idPerson = "",$signOnVsl = "",$return = "")
	{
		$opt = "";

		$opt .= "<option value=\"000000\"> - </option>";

		$sql = "SELECT A.idcontract,TRIM(CONCAT(B.fname,' ',B.mname,' ' ,B.lname)) AS fullName
				FROM tblcontract A
				LEFT JOIN mstpersonal B ON B.idperson = A.idperson
				AND A.idcontract IN (
					SELECT MAX(idcontract) AS idcontract
					FROM tblcontract
					WHERE deletests =0
					AND idperson = B.idperson
					)
				WHERE A.deletests=0 AND A.signoffdt = '0000-00-00' AND A.signonvsl = '".$signOnVsl."'
				GROUP BY A.idperson ORDER BY fullName ASC";

		$rsl = $this->MCrewscv->getDataQuery($sql);
		foreach ($rsl as $key => $val)
		{
			$opt .= "<option value=\"".$val->idcontract."\">".$val->fullName."</option>";
		}

		if($return == "")
		{
			return $opt;
		}else{
			print json_encode($opt);
		}
	}

	function menuTahun($thnmulai = "", $thnPilih = "")
	{
		$tahun = date("Y");
		$html="";
		$html.= "<option value=\"\"></option>";
		for($i = $tahun; $i >= $thnmulai; $i--)
		{
			$sel = "";
			if($thnPilih == $i)
			{
				$sel = "selected=\"selected\"";
			}
			$html.= "<option value=\"".$i."\" ".$sel.">".$i."</option>";	
		}
		return $html;
	}

	function getMaritalStatus($maritalstsid = "")
	{
		$opt = "";
		
		$arrayMaritalStatus = array("-", "Single", "Married", "Divorced", "Common Law Partner", "Widowed", "Separated");
		for($i = 0; $i < count($arrayMaritalStatus); $i++)
		{
			$sel = "";
			if($maritalstsid == $arrayMaritalStatus[$i])
			{
				$sel = "selected=\"selected\"";
			}
			$opt.= "<option value=\"".$arrayMaritalStatus[$i]."\" ".$sel.">".$arrayMaritalStatus[$i]."</option>";
		}
		return $opt;
	}

	function getReligion($religion = "")
	{
		$opt = "";
		
		$arrayReligion = array("-", "Buddha", "Catholic", "Christian", "Hindu", "Moeslem", "Others");
		for($i = 0; $i < count($arrayReligion); $i++)
		{
			$sel = "";
			if($religion == $arrayReligion[$i])
			{
				$sel = "selected=\"selected\"";
			}
			$opt.= "<option value=\"".$arrayReligion[$i]."\" ".$sel.">".$arrayReligion[$i]."</option>";
		}
		return $opt;
	}

	function getBloodType($golDrh = "")
	{
		$opt = "";
		
		$arrayBloodType = array("-", "A", "B", "O", "AB");
		for($i = 0; $i < count($arrayBloodType); $i++)
		{
			$sel = "";
			if($golDrh == $arrayBloodType[$i])
			{
				$sel = "selected=\"selected\"";
			}
			$opt.= "<option value=\"".$arrayBloodType[$i]."\" ".$sel.">".$arrayBloodType[$i]."</option>";
		}
		return $opt;
	}

	function getUkuran($ukuran = "")
	{
		$opt = "";
		
		$arrayUkuran = array("-", "S", "M", "L", "XL", "XXL", "XXXL", "XXXXL", "XXXXXL");
		for($i = 0; $i < count($arrayUkuran); $i++)
		{
			$sel = "";
			if($ukuran == $arrayUkuran[$i])
			{
				$sel = "selected=\"selected\"";
			}
			$opt.= "<option value=\"".$arrayUkuran[$i]."\" ".$sel.">".$arrayUkuran[$i]."</option>";
		}
		return $opt;
	}

	function getMainEngine($type = "")
	{
		$opt = "";
		
		$arrayUkuran = array("-", "Engine A", "Engine B");
		for($i = 0; $i < count($arrayUkuran); $i++)
		{
			$sel = "";
			if($type == $arrayUkuran[$i])
			{
				$sel = "selected=\"selected\"";
			}
			$opt.= "<option value=\"".$arrayUkuran[$i]."\" ".$sel.">".$arrayUkuran[$i]."</option>";
		}
		return $opt;
	}

	function getNewIdPerson($return = "")
	{
		$newIdPerson = "";

		$sql = "SELECT MAX(idperson)+1 AS idpersonmax FROM mstpersonal";
		$rsl = $this->MCrewscv->getDataQuery($sql);

		if(count($rsl) > 0)
		{
			$newIdPerson = $rsl[0]->idpersonmax;
		}

		if($return == "")
		{
			return $newIdPerson;
		}else{
			print json_encode($newIdPerson);
		}
	}

	function getVessel()
	{
		$dataOut = array();

		$dataOut = $this->MCrewscv->getData("*","mstvessel","deletests = '0' AND nmvsl != '' AND nmvsl != '-' ","nmvsl ASC");

		return $dataOut;
	}

	function getNewId($fieldId = "",$tbl = "",$whereNya = "")
	{
		$newId = "1";

		$sql = "SELECT MAX(".$fieldId.")+1 AS idNew FROM ".$tbl." ".$whereNya;
		$rsl = $this->MCrewscv->getDataQuery($sql);

		if(count($rsl) > 0)
		{
			if(!is_null($rsl[0]->idNew))
			{
				$newId = $rsl[0]->idNew;
			}
		}

		return $newId;
	}

	function uploadFile($tmpFile = "",$dir = "",$fileName = "",$newFileName = "")
	{
		$dt = explode(".", $fileName);
		$newFileName = str_replace(array(' ','/','.',',','-'), '', $newFileName).".".trim($dt[count($dt)-1]);
		move_uploaded_file($tmpFile, $dir."/".$fileName);
		rename($dir."/".$fileName, $dir."/".$newFileName);
		return $newFileName;
	}

	function hitungSelisihByHari($sDate = "",$eDate = "")
	{
		$dayNya = "";
		if($sDate != "" AND $eDate != "")
		{
			$tgl1 = new DateTime();
			$tgl2 = new DateTime($eDate);

			$dayNya = $tgl2->diff($tgl1);
			$dayNya = $dayNya->days;
		}

		return $dayNya;
	}
	
	function hitungSelisihCompleteByHari($sDate = "",$eDate = "")
	{
		$dayNya = "";

		if($sDate != "" AND $eDate != "")
		{
			$tgl1 = new DateTime($sDate);
			$tgl2 = new DateTime($eDate);

			$tempDay = $tgl2->diff($tgl1);

			if($tempDay->y > 0)
			{
				$dayNya .= $tempDay->y." Years ";
			}
			if($tempDay->m > 0)
			{
				$dayNya .= $tempDay->m." Months ";
			}
			if($tempDay->d > 0)
			{
				$dayNya .= $tempDay->d." Days ";
			}
		}

		return $dayNya;
	}

	function hitungSelisihByBulan($dateNya = "", $ttlBulan = "")
    {
    	$bulanNya = "";

    	if($dateNya != "" AND $ttlBulan != "")
    	{
	        $dates = new DateTime($dateNya);
			$timeNya = $dates->modify($ttlBulan.' month');
			
			$bulanNya = $timeNya->format('Y-m-d');
		}

        return $bulanNya;
    }

    function hitungUmur($dateNya = "")
    {
    	$umur = "";

    	if($dateNya != "" AND $dateNya != "0000-00-00")
    	{
    		$dateNya = new DateTime($dateNya);
	    	$todays = new DateTime();
	    	$hitUmur = $todays->diff($dateNya);
	    	$umur = $hitUmur->y;
	    }
	    return $umur;
    }

    function intervalBulan($tglSekarang, $month)
	{
		$sql = "SELECT DATE_ADD(".$tglSekarang.", INTERVAL ".$month." MONTH) AS hasil;";
		$rsl = $this->MCrewscv->getDataQuery($sql);
		
		return $rsl[0]->hasil;
	}

	function delFile($fileNya,$dir)
	{
		$dataDel = array();
		$dataOut = array();
		$de = explode(",",$fileNya);

		if(count($de) > 0)
		{
			for ($lan=0; $lan < count($de); $lan++)
			{
				unlink($dir."/".$de[$lan]);
				$dataDel[] = $de[$lan];
			}
		}
		if(count($dataDel) > 0)
		{
			for ($hal=0; $hal < count($dataDel) ; $hal++)
			{
				$do = explode("_", $dataDel[$hal]);
				$dl = explode(".", $do[1]);
				$dataOut[$dl[0]] = $dl[0];
			}
		}
		return $dataOut;
	}

	function convertReturnName($dateNya = "")
	{
		if($dateNya == "0000-00-00")
		{
			return "";
		}else{
			$dt = explode("-", $dateNya);
			$tgl = $dt[2];
			$bln = $dt[1];
			$thn = $dt[0];
			if($bln == "01" || $bln == "1"){ $bln = "Jan"; }
			else if($bln == "02" || $bln == "2"){ $bln = "Feb"; }
			else if($bln == "03" || $bln == "3"){ $bln = "Mar"; }
			else if($bln == "04" || $bln == "4"){ $bln = "Apr"; }
			else if($bln == "05" || $bln == "5"){ $bln = "Mei"; }
			else if($bln == "06" || $bln == "6"){ $bln = "Jun"; }
			else if($bln == "07" || $bln == "7"){ $bln = "Jul"; }
			else if($bln == "08" || $bln == "8"){ $bln = "Ags"; }
			else if($bln == "09" || $bln == "9"){ $bln = "Sep"; }
			else if($bln == "10"){ $bln = "Okt"; }
			else if($bln == "11"){ $bln = "Nov"; }
			else if($bln == "12"){ $bln = "Des"; }

			return $tgl." ".$bln." ".$thn;
		}
	}

	function convertReturnNameWithTime($dateNya = "")
	{
		$dataNya = explode(" ", $dateNya);
		$dt = explode("-", $dataNya[0]);
		$tgl = $dt[2];
		$bln = $dt[1];
		$thn = $dt[0];
		if($bln == "01" || $bln == "1"){ $bln = "Jan"; }
		else if($bln == "02" || $bln == "2"){ $bln = "Feb"; }
		else if($bln == "03" || $bln == "3"){ $bln = "Mar"; }
		else if($bln == "04" || $bln == "4"){ $bln = "Apr"; }
		else if($bln == "05" || $bln == "5"){ $bln = "Mei"; }
		else if($bln == "06" || $bln == "6"){ $bln = "Jun"; }
		else if($bln == "07" || $bln == "7"){ $bln = "Jul"; }
		else if($bln == "08" || $bln == "8"){ $bln = "Ags"; }
		else if($bln == "09" || $bln == "9"){ $bln = "Sep"; }
		else if($bln == "10"){ $bln = "Okt"; }
		else if($bln == "11"){ $bln = "Nov"; }
		else if($bln == "12"){ $bln = "Des"; }

		return $tgl." ".$bln." ".$thn." ".$dataNya[1];
	}

	function convertReturnBulanTglTahun($dateNya = "")
	{
		if($dateNya == "0000-00-00")
		{
			return "";
		}else{
			$dt = explode("-", $dateNya);
			$tgl = $dt[2];
			$bln = $dt[1];
			$thn = $dt[0];
			if($bln == "01" || $bln == "1"){ $bln = "Januari"; }
			else if($bln == "02" || $bln == "2"){ $bln = "Februari"; }
			else if($bln == "03" || $bln == "3"){ $bln = "Maret"; }
			else if($bln == "04" || $bln == "4"){ $bln = "April"; }
			else if($bln == "05" || $bln == "5"){ $bln = "Mei"; }
			else if($bln == "06" || $bln == "6"){ $bln = "Juni"; }
			else if($bln == "07" || $bln == "7"){ $bln = "Juli"; }
			else if($bln == "08" || $bln == "8"){ $bln = "Agustus"; }
			else if($bln == "09" || $bln == "9"){ $bln = "September"; }
			else if($bln == "10"){ $bln = "Oktober"; }
			else if($bln == "11"){ $bln = "November"; }
			else if($bln == "12"){ $bln = "Desember"; }

			return $bln." ".$tgl." ,".$thn;
		}
	}

	 public function getYearsByOption($return = "",$typeVal = "")
	 {
		$opt = "<option value=''></option>";
		for ($i = 2000; $i <= (int) date('Y'); $i++) {
			$opt .= "<option value=\"".$i."\">".$i."</option>";
		}
		return $opt;
	 }

		public function getMstSchoolByOption($return = "",$typeVal = "")
	 {
		$opt = "<option value=''></option>";
		$sql = "SELECT id, schoolname FROM mstschool WHERE deletests = '0' ORDER BY schoolname ASC";
		$rsl = $this->db->query($sql)->result_array();
		foreach ($rsl as $key => $val) {
			$opt .= "<option value=\"".$val['schoolname']."\">".$val['schoolname']."</option>";
		}
		return $opt;
	 }


}