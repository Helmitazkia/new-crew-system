 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class General extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('MCrewscv');
        $this->load->library('../controllers/DataContext');
        $this->load->library('session');
    }

	function indexGeneral()
    {
        $data = array(
            'title' => 'General Recruitment',
            'active_menu' => 'general_recruitment',
			'active_submenu' => 'sub_general_recruitment',
            'content' => 'Recruitment/General/generalView'
        );

        $this->load->view('menu/RecruitmentMenu/main_General', $data);
    }
	
    function getDataApplicantPositionSummaryCombined()
	{
		$sql = "
			SELECT 
				position_applied,

				-- Qualified (sesuai tab Qualified)
				SUM(CASE WHEN st_data = 0 AND st_qualify = 'Y' AND st_qualify2 = 'N' AND position_existing != '' THEN 1 ELSE 0 END) AS qualified,

				-- Pickup
				SUM(CASE WHEN st_data = 1 THEN 1 ELSE 0 END) AS pickup,

				-- Not Position
				SUM(CASE WHEN st_data = 2 THEN 1 ELSE 0 END) AS not_position,

				-- Not Qualified Total
				SUM(CASE WHEN st_data = 3 THEN 1 ELSE 0 END) AS not_qualified_total,

				-- Not Qualified Experience (reason_not_qualified diisi)
				SUM(CASE WHEN st_data = 3 AND reason_not_qualified != '' AND reason_not_qualified IS NOT NULL THEN 1 ELSE 0 END) AS not_qualified_experience,

				-- Not Qualified Certificate (reason_not_qualified_layer1 diisi)
				SUM(CASE WHEN st_data = 3 AND reason_not_qualified_layer1 != '' AND reason_not_qualified_layer1 IS NOT NULL THEN 1 ELSE 0 END) AS not_qualified_certificate,

				-- Not Qualified Interview (notReff_reason diisi)
				SUM(CASE WHEN st_data = 4 AND notReff_reason != '' AND notReff_reason IS NOT NULL THEN 1 ELSE 0 END) AS not_qualified_interview,

				-- Not Reference Total
				SUM(CASE WHEN st_data = 4 THEN 1 ELSE 0 END) AS not_reference_total,

				-- Interview
				SUM(CASE WHEN st_data = 5 THEN 1 ELSE 0 END) AS interview,

				-- MCU
				SUM(CASE WHEN st_data = 6 THEN 1 ELSE 0 END) AS mcu,

				-- Unfit (jika ingin ditampilkan di chart, bisa ditambahkan kolom ini)
				-- SUM(CASE WHEN st_data = 7 THEN 1 ELSE 0 END) AS unfit,

				-- Total keseluruhan
				COUNT(*) AS total

			FROM new_applicant
			WHERE deletests = 0 
				AND position_applied IS NOT NULL
				AND (
					-- New Applicant (ready)
					(st_data = 0 AND st_qualify = 'N' AND st_qualify2 = 'N')

					-- Qualified (sudah di- qualify)
					OR (st_data = 0 AND st_qualify = 'Y' AND st_qualify2 = 'N' AND position_existing != '')

					-- Pickup
					OR st_data = 1

					-- Pipeline (not position, not qualified, not reference, unfit)
					OR st_data IN (2,3,4,7)

					-- Interview
					OR st_data = 5

					-- MCU
					OR st_data = 6
				)
			GROUP BY position_applied
			ORDER BY total DESC
		";

		$positions = $this->MCrewscv->getDataQuery($sql);

		$result = array();
		foreach ($positions as $row) {
			$result[] = array(
				'name'                      => $row->position_applied,
				'y'                         => (int)$row->total,
				'qualified'                 => (int)$row->qualified,
				'pickup'                    => (int)$row->pickup,
				'not_position'              => (int)$row->not_position,
				'not_qualified_total'       => (int)$row->not_qualified_total,
				'not_qualified_experience'  => (int)$row->not_qualified_experience,
				'not_qualified_certificate' => (int)$row->not_qualified_certificate,
				'not_qualified_interview'   => (int)$row->not_qualified_interview,
				'not_reference_total'       => (int)$row->not_reference_total,
				'interview'                 => (int)$row->interview,
				'mcu'                       => (int)$row->mcu
			);
		}

		echo json_encode($result);
	}

	function getSubmitCV()
	{
		$sql = "
			SELECT DATE(submit_cv) AS tanggal, COUNT(*) AS jumlah
			FROM new_applicant
			WHERE deletests = '0' 
				AND submit_cv IS NOT NULL
				AND submit_cv != '0000-00-00'
			GROUP BY DATE(submit_cv)
			ORDER BY DATE(submit_cv) ASC
		";

		$data = $this->MCrewscv->getDataQuery($sql);

		echo json_encode($data);
	}

	function getRankList()
	{
		$dataContext = new DataContext();
		$data = $dataContext->getRankByOptionArray();
		echo json_encode($data);
	}

	function generalDataFiltered()
	{
		$ranks   = $this->input->post('ranks');   
		$vessels = $this->input->post('vessels'); 
		$start   = $this->input->post('date_start');
		$end     = $this->input->post('date_end');

		$where = array();
		$join  = '';

		if (!empty($ranks)) {
			$rankIds = implode(',', array_map('intval', $ranks));

			$join .= "
				JOIN mstrank r 
					ON TRIM(UPPER(r.nmrank)) = TRIM(UPPER(new_applicant.position_applied))
			";

			$where[] = "r.kdrank IN ($rankIds)";
		}

		if (!empty($vessels)) {
			$vesselLike = array();
			foreach ($vessels as $v) {
				$v = addslashes($v);
				$vesselLike[] = "new_applicant.pengalaman_jeniskapal LIKE '%$v%'";
			}
			$where[] = '(' . implode(' OR ', $vesselLike) . ')';
		}

		if ($start && $end) {
			$where[] = "DATE(new_applicant.submit_cv) BETWEEN '$start' AND '$end'";
		}

		$whereSQL = '';
		if (!empty($where)) {
			$whereSQL = ' AND ' . implode(' AND ', $where);
		}

		$sql = "
			SELECT 
				new_applicant.position_applied,

				SUM(CASE WHEN st_data = 0 AND st_qualify = 'Y' AND st_qualify2 = 'N' THEN 1 ELSE 0 END) AS qualified,
				SUM(CASE WHEN st_data = 1 THEN 1 ELSE 0 END) AS pickup,
				SUM(CASE WHEN st_data = 2 THEN 1 ELSE 0 END) AS not_position,
				SUM(CASE WHEN st_data = 3 THEN 1 ELSE 0 END) AS not_qualified_total,
				SUM(CASE WHEN st_data = 3 AND reason_not_qualified != '' THEN 1 ELSE 0 END) AS not_qualified_experience,
				SUM(CASE WHEN st_data = 3 AND reason_not_qualified_layer1 != '' THEN 1 ELSE 0 END) AS not_qualified_certificate,
				SUM(CASE WHEN st_data = 4 THEN 1 ELSE 0 END) AS not_reference_total,
				SUM(CASE WHEN st_data = 5 THEN 1 ELSE 0 END) AS interview,
				SUM(CASE WHEN st_data = 6 THEN 1 ELSE 0 END) AS mcu,
				COUNT(*) AS total

			FROM new_applicant
			$join
			WHERE new_applicant.deletests = 0
			AND new_applicant.st_data IN (0,1,2,3,4,5,6)
			$whereSQL
			GROUP BY new_applicant.position_applied
			ORDER BY total DESC
		";

		$rows = $this->MCrewscv->getDataQuery($sql);

		$result = array();
		foreach ($rows as $r) {
			$result[] = array(
				'name' => $r->position_applied,
				'qualified' => (int)$r->qualified,
				'pickup' => (int)$r->pickup,
				'not_position' => (int)$r->not_position,
				'not_qualified_total' => (int)$r->not_qualified_total,
				'not_qualified_experience' => (int)$r->not_qualified_experience,
				'not_qualified_certificate' => (int)$r->not_qualified_certificate,
				'not_reference_total' => (int)$r->not_reference_total,
				'interview' => (int)$r->interview,
				'mcu' => (int)$r->mcu
			);
		}

		echo json_encode($result);
	}
  
	// function getFunnelSLA()
	// {
	// 	$sql = "
	// 		SELECT 
	// 			SUM(CASE WHEN st_data = 0 THEN 1 ELSE 0 END) AS applicants,

	// 			SUM(CASE WHEN st_qualify = 'Y' THEN 1 ELSE 0 END) AS qualified,
	// 			SUM(CASE WHEN st_data = 5 THEN 1 ELSE 0 END) AS interview,
	// 			SUM(CASE WHEN st_data = 6 THEN 1 ELSE 0 END) AS mcu,
	// 			SUM(CASE WHEN st_data = 1 THEN 1 ELSE 0 END) AS pickup,

	// 			-- SLA
	// 			IFNULL(AVG(
	// 				CASE 
	// 					WHEN submit_cv IS NOT NULL 
	// 					AND adduserdate_stQualify IS NOT NULL
	// 					THEN DATEDIFF(
	// 						STR_TO_DATE(SUBSTRING_INDEX(adduserdate_stQualify, '#', -1), '%Y-%m-%d %H:%i:%s'),
	// 						submit_cv
	// 					)
	// 				END
	// 			),0) AS sla_qualified,

	// 			IFNULL(AVG(
	// 				CASE 
	// 					WHEN adduserdate_stQualify IS NOT NULL
	// 					AND adduserdate_stInterview IS NOT NULL
	// 					THEN DATEDIFF(
	// 						STR_TO_DATE(SUBSTRING_INDEX(adduserdate_stInterview, '#', -1), '%Y-%m-%d %H:%i:%s'),
	// 						STR_TO_DATE(SUBSTRING_INDEX(adduserdate_stQualify, '#', -1), '%Y-%m-%d %H:%i:%s')
	// 					)
	// 				END
	// 			),0) AS sla_interview,

	// 			IFNULL(AVG(
	// 				CASE 
	// 					WHEN adduserdate_stInterview IS NOT NULL
	// 					AND adduserdate_stQualify2 IS NOT NULL
	// 					THEN DATEDIFF(
	// 						STR_TO_DATE(SUBSTRING_INDEX(adduserdate_stQualify2, '#', -1), '%Y-%m-%d %H:%i:%s'),
	// 						STR_TO_DATE(SUBSTRING_INDEX(adduserdate_stInterview, '#', -1), '%Y-%m-%d %H:%i:%s')
	// 					)
	// 				END
	// 			),0) AS sla_mcu,

	// 			IFNULL(AVG(
	// 				CASE 
	// 					WHEN adduserdate_stQualify2 IS NOT NULL
	// 					AND adduserdate_positionAvailable IS NOT NULL
	// 					THEN DATEDIFF(
	// 						STR_TO_DATE(SUBSTRING_INDEX(adduserdate_positionAvailable, '#', -1), '%Y-%m-%d %H:%i:%s'),
	// 						STR_TO_DATE(SUBSTRING_INDEX(adduserdate_stQualify2, '#', -1), '%Y-%m-%d %H:%i:%s')
	// 					)
	// 				END
	// 			),0) AS sla_pickup,

	// 			-- AGING
	// 			IFNULL(AVG(
	// 				CASE 
	// 					WHEN st_data = 0 AND submit_cv IS NOT NULL
	// 					THEN DATEDIFF(CURDATE(), submit_cv)
	// 				END
	// 			),0) AS aging_applicants,

	// 			IFNULL(AVG(
	// 				CASE 
	// 					WHEN st_qualify = 'Y'
	// 					AND adduserdate_stQualify IS NOT NULL
	// 					AND st_data < 5
	// 					THEN DATEDIFF(
	// 						CURDATE(),
	// 						STR_TO_DATE(SUBSTRING_INDEX(adduserdate_stQualify, '#', -1), '%Y-%m-%d %H:%i:%s')
	// 					)
	// 				END
	// 			),0) AS aging_qualified,

	// 			IFNULL(AVG(
	// 				CASE 
	// 					WHEN st_data = 5
	// 					AND adduserdate_stInterview IS NOT NULL
	// 					THEN DATEDIFF(
	// 						CURDATE(),
	// 						STR_TO_DATE(SUBSTRING_INDEX(adduserdate_stInterview, '#', -1), '%Y-%m-%d %H:%i:%s')
	// 					)
	// 				END
	// 			),0) AS aging_interview,

	// 			IFNULL(AVG(
	// 				CASE 
	// 					WHEN st_data = 6
	// 					AND adduserdate_stQualify2 IS NOT NULL
	// 					THEN DATEDIFF(
	// 						CURDATE(),
	// 						STR_TO_DATE(SUBSTRING_INDEX(adduserdate_stQualify2, '#', -1), '%Y-%m-%d %H:%i:%s')
	// 					)
	// 				END
	// 			),0) AS aging_mcu,

	// 			MAX(submit_cv) AS last_applicants,
	// 			MAX(adduserdate_stQualify) AS last_qualified,
	// 			MAX(adduserdate_stInterview) AS last_interview,
	// 			MAX(adduserdate_stQualify2) AS last_mcu,
	// 			MAX(adduserdate_positionAvailable) AS last_hired

	// 		FROM new_applicant
	// 		WHERE deletests = 0
	// 	";

	// 	$query = $this->MCrewscv->getDataQuery($sql);
	// 	$d = isset($query[0]) ? $query[0] : null;

	// 	$sla_map = array(
	// 		"Qualified" => $d ? $d->sla_qualified : 0,
	// 		"Interview" => $d ? $d->sla_interview : 0,
	// 		"MCU"       => $d ? $d->sla_mcu : 0,
	// 		"Hired"     => $d ? $d->sla_pickup : 0
	// 	);

	// 	$bottleneck_stage = '';
	// 	$bottleneck_value = 0;

	// 	foreach ($sla_map as $stage => $val) {
	// 		if ($val > $bottleneck_value) {
	// 			$bottleneck_value = $val;
	// 			$bottleneck_stage = $stage;
	// 		}
	// 	}

	// 	$result = array(
	// 		"applicants" => $d ? (int)$d->applicants : 0,
	// 		"qualified"  => $d ? (int)$d->qualified : 0,
	// 		"interview"  => $d ? (int)$d->interview : 0,
	// 		"mcu"        => $d ? (int)$d->mcu : 0,
	// 		"pickup"     => $d ? (int)$d->pickup : 0,

	// 		"sla_qualified" => $d ? round($d->sla_qualified, 1) : 0,
	// 		"sla_interview" => $d ? round($d->sla_interview, 1) : 0,
	// 		"sla_mcu"       => $d ? round($d->sla_mcu, 1) : 0,
	// 		"sla_pickup"    => $d ? round($d->sla_pickup, 1) : 0,

	// 		"aging_applicants" => $d ? round($d->aging_applicants, 1) : 0,
	// 		"aging_qualified"  => $d ? round($d->aging_qualified, 1) : 0,
	// 		"aging_interview"  => $d ? round($d->aging_interview, 1) : 0,
	// 		"aging_mcu"        => $d ? round($d->aging_mcu, 1) : 0,

	// 		"last_applicants" => $d && $d->last_applicants ? $d->last_applicants : '-',
	// 		"last_qualified"  => $d && $d->last_qualified ? $d->last_qualified : '-',
	// 		"last_interview"  => $d && $d->last_interview ? $d->last_interview : '-',
	// 		"last_mcu"        => $d && $d->last_mcu ? $d->last_mcu : '-',
	// 		"last_hired"      => $d && $d->last_hired ? $d->last_hired : '-',

	// 		"bottleneck_stage" => $bottleneck_stage,
	// 		"bottleneck_value" => round($bottleneck_value, 1)
	// 	);

	// 	echo json_encode($result);
	// }

	function getFunnelSLA()
	{
	        $sql = "
			SELECT 
				COUNT(*) AS applicants,

				SUM(CASE 
					WHEN adduserdate_stQualify != ''
					THEN 1 ELSE 0 
				END) AS qualified_certificate,

				SUM(CASE 
					WHEN st_qualify = 'Y'
					AND st_qualify2 = 'Y'
					AND adduserdate_stQualify2 != ''
					THEN 1 ELSE 0 
				END) AS qualified_experience,

				SUM(CASE 
					WHEN st_qualify = 'Y'
					AND st_qualify2 = 'Y'
					AND adduserdate_stInterview != ''
					AND notReff_reason = ''
					THEN 1 ELSE 0 
				END) AS qualified_interview,
 
				SUM(CASE 
					WHEN st_qualify = 'Y'
					AND st_qualify2 = 'Y'
					AND adduserdate_stInterview != ''
					AND notReff_reason = ''
					AND st_data NOT IN (5,7)
					THEN 1 ELSE 0
				END) AS mcu,

				SUM(CASE 
					WHEN st_qualify = 'Y'
					AND st_qualify2 = 'Y'
					AND adduserdate_stInterview != ''
					AND notReff_reason = ''
					AND st_data = '1'
					THEN 1 ELSE 0
				END) AS onboard

			FROM new_applicant na
			LEFT JOIN crew_login cl ON na.id = cl.id_newapplicant   
			LEFT JOIN mstpersonal mp ON cl.idperson = mp.idperson   
			WHERE na.deletests = '0'
		";

		$query = $this->MCrewscv->getDataQuery($sql); 
		$d = isset($query[0]) ? $query[0] : null;

		$a  = (int)$d->applicants;
		$q1 = (int)$d->qualified_certificate;
		$q2 = (int)$d->qualified_experience;
		$q3 = (int)$d->qualified_interview;
		$m  = (int)$d->mcu;
		$o  = (int)$d->onboard;

		function rate($num, $den) {
			return $den > 0 ? round(($num / $den) * 100, 1) : 0;
		}

		$result = array(
			"applicants" => $a,
			"qualified_certificate" => $q1,
			"qualified_experience" => $q2,
			"qualified_interview" => $q3,
			"mcu" => $m,
			"onboard" => $o,

			 
			"cr_q1" => rate($q1, $a),
			"cr_q2" => rate($q2, $q1),
			"cr_q3" => rate($q3, $q2),
			"cr_mcu" => rate($m, $q3),
			"cr_onboard" => rate($o, $m)
		);

		echo json_encode($result);
	}

}