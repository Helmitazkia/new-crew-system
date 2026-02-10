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

			case 'user':
				$sql = "SELECT * FROM crew_login WHERE id = '".$idEdit."'";
				break;

			case 'userSystem':
				$sql = "SELECT * FROM login WHERE userId = '".$idEdit."'";
				break;

			case 'reasonEmail':
				$sql = "SELECT * FROM mstreasonemail WHERE id = '".$idEdit."'";
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
			'vesselType' => $this->getCrewVesselType('array'),
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

	function indexMasterSchool()
	{
		$data = array(
			'title' => 'School Name',
			'active_menu' => 'master_school',
			'content' => 'MasterData/MasterSchoolName/MasterSchoolNameView'
		);

		$this->load->view('menu/MasterMenu/main_masterSchoolName', $data);
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

		$sql = "SELECT R.*, M.urutan 
				FROM tblopenrecruitment R 
				LEFT JOIN mstrank M ON R.rank = M.nmrank 
				WHERE R.deletests = '0' 
				AND R.sts_publish = 'Y' 
				AND M.urutan > 0
				ORDER BY M.urutan ASC, R.subject_name ASC";
				
		$results = $this->MCrewscv->getDataQuery($sql);

		if (count($results) === 0) {
			return "<div style='
				border:1px dashed #aaa;
				background-color:#f8f9fa;
				padding:12px;
				border-radius:6px;
				color:#777;
				font-style:italic;
				text-align:center;
				margin-bottom:10px;'>No Open Recruitment</div>";
		}

		foreach ($results as $val) {
			$linkShow = "";
			$output .= "<div style='
				border:1px solid #ccc;
				background-color:#fdfdfd;
				border-radius:8px;
				padding:12px 16px;
				margin-bottom:12px;
				box-shadow:0 1px 3px rgba(0,0,0,0.06);
				transition:all 0.2s ease-in-out;'>";

			if (!empty($val->qualification)) {
				$linkShow = "<a onclick=\"showHiddenQuali(" . $val->id . ", 'show')\" style=\"cursor:pointer;\" class=\"view-requirements\" id=\"showQuali_".$val->id."\">Persyaratan</a>";
			}

			$output .= "<div id=\"rank_" . $val->id . "\" style='
				font-size:14px;
				color:#333;
				margin-bottom:4px;'>
				<strong>&bull;&nbsp;&nbsp;" .htmlspecialchars($val->rank). " - ". $val->subject_name . "</strong> 
				$linkShow, <span style='font-size:12px;color:#1adc27;'>Publish Date: ".$this->convertReturnNameWithTime($val->datePublish)."</span></div>";

			$output .= "<div id=\"qualification_" . $val->id . "\" style='
				font-size:14px;color:#555;display:none;'>
				" . nl2br(htmlspecialchars($val->qualification)) . "</div>";

			$output .= "</div>";
		}

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

		// 🔹 MODE ARRAY (JSON)
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

		// 🔹 MODE HTML (legacy)
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

	function getCrewVesselType($mode = 'html')
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

		// default: HTML option
		$opt = "<option value=''>Select Vessel Type</option>";
		foreach ($rsl as $val) {
			$opt .= "<option value='{$val->DefType}'>{$val->DefType}</option>";
		}

		return $opt;
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


}