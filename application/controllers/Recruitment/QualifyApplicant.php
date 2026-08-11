<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QualifyApplicant extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('MCrewscv');
        $this->load->library('../controllers/DataContext');
        $this->load->library('session');
    }

	function indexQualifyApplicant()
    {
        $data = array(
            'title' => 'Qualify Applicant',
            'active_menu' => 'qualify_applicant',
			'active_submenu' => 'qualify_applicant',
            'content' => 'Recruitment/QualifyApplicant/qualifyApplicantView',
        );

        $this->load->view('menu/RecruitmentMenu/main_QualifyApplicant', $data);
    }

    function searchDataQualifiedCrew()
	{
		$search = $this->input->get('search');
		$page = $this->input->get('page');
		$sortBy = $this->input->get('sortBy');
		$sortOrder = $this->input->get('sortOrder');
		
		$this->getQualifiedCrew($search, $page, '', $sortBy, $sortOrder);
	}

    function getQualifiedCrew()
	{
		header("X-Robots-Tag: noindex, nofollow, noarchive, nosnippet", true);
		header('Content-Type: application/json');

		$dataContext = new DataContext();

		$search    = $this->input->get('search', true);
		$page      = $this->input->get('page', true);
		$sortBy    = $this->input->get('sortBy', true);
		$sortOrder = $this->input->get('sortOrder', true);

		$page = (is_numeric($page) && $page > 0) ? (int)$page : 1;

		$rows = $this->input->get('rows', true);

		$allowedRows = array(10, 25, 50, 100);

		$limit = in_array((int)$rows, $allowedRows)
			? (int)$rows
			: 10;

		$offset = ($page - 1) * $limit;

		$whereSearch = "";

		if (!empty($search)) {

			$keywords   = preg_split('/\s+/', trim($search));
			$conditions = array();

			foreach ($keywords as $word) {

				$word = $this->db->escape_like_str($word);

				if ($word == '') {
					continue;
				}

				$conditions[] = "(
					LOWER(position_applied) LIKE LOWER('%$word%')
					OR LOWER(fullname) LIKE LOWER('%$word%')
					OR LOWER(email) LIKE LOWER('%$word%')
					OR LOWER(pengalaman_jeniskapal) LIKE LOWER('%$word%')
					OR LOWER(vessel_type) LIKE LOWER('%$word%')
				)";
			}

			if (!empty($conditions)) {
				$whereSearch = " AND (" . implode(" OR ", $conditions) . ")";
			}
		}

		$allowedColumns = array(
			'email',
			'fullname',
			'born_place',
			'born_date',
			'handphone',
			'vessel_type',
			'position_applied',
			'position_existing',
			'ijazah_terakhir',
			'last_experience',
			'pengalaman_jeniskapal',
			'berlayardengancrewasing',
			'last_salary',
			'expected_salary',
			'join_inAndhika',
			'submit_cv'
		);

		$order = "ORDER BY submit_cv DESC";

		if (!empty($sortBy) && in_array($sortBy, $allowedColumns)) {

			$sortOrder = strtoupper($sortOrder) === 'DESC' ? 'DESC' : 'ASC';
			$order = "ORDER BY $sortBy $sortOrder";
		}

		$sqlTotal = "
			SELECT COUNT(*) AS total
			FROM new_applicant
			WHERE deletests='0'
			AND st_qualify='Y'
			AND st_data='0'
			AND st_qualify2='N'
			AND position_existing != ''
			$whereSearch
		";

		$resultTotal = $this->MCrewscv->getDataQuery($sqlTotal);

		$totalRows  = (!empty($resultTotal))
			? (int)$resultTotal[0]->total
			: 0;

		$totalPages = ceil($totalRows / $limit);

		$sql = "
			SELECT *
			FROM new_applicant
			WHERE deletests='0'
			AND st_qualify='Y'
			AND st_data='0'
			AND st_qualify2='N'
			AND position_existing != ''
			$whereSearch
			$order
			LIMIT $limit OFFSET $offset
		";

		$rows = $this->MCrewscv->getDataQuery($sql);

		$data = array();

		foreach ($rows as $row) {

			$data[] = array(
				'id'                    => $row->id,
				'email'                 => $row->email,
				'fullname'              => $row->fullname,
				'born_place'            => $row->born_place,
				'born_date'             => $dataContext->convertReturnName($row->born_date),
				'handphone'             => $row->handphone,
				'recruitment_id'        => $row->recruitment_id,
				'vessel_type'           => $row->vessel_type,
				'position_applied'      => $row->position_applied,
				'position_existing'     => $row->position_existing,
				'ijazah_terakhir'       => $row->ijazah_terakhir,
				'last_experience'       => $row->last_experience,
				'pengalaman_jeniskapal' => $row->pengalaman_jeniskapal,
				'foreign_crew'          => $row->berlayardengancrewasing,
				'last_salary' 			=> $row->last_salary,
				'last_salary_currency'  => $row->last_salary_currency,
				'expected_salary'       => $row->expected_salary,
				'expected_salary_currency' => $row->expected_salary_currency,
				'prev_join'             => $row->join_inAndhika,
				'submit_cv'             => $dataContext->convertReturnNameWithTime($row->submit_cv),
				'cv_url'                => base_url('assets/uploads/CV_NewApplicant/' . $row->new_cv),
				'interview_link'        => base_url('crew/getLoginCrew')
			);
		}

		echo json_encode(array(
			'page'          => $page,
			'total_pages'   => $totalPages,
			'total_rows'    => $totalRows,
			'rows_per_page' => $limit,
			'start'         => ($totalRows > 0) ? $offset + 1 : 0,
			'end'           => min($offset + $limit, $totalRows),
			'data'          => $data
		));
	}
	
    function generateUniqueUsername($fullname)
	{
		$cleanFullname = strtolower(str_replace(' ', '', trim($fullname)));
		$baseUsername = substr($cleanFullname, 0, 5);

		$generatedUsername = $baseUsername . rand(100, 999);
		$checkSql = "SELECT COUNT(*) AS total FROM crew_login WHERE username = '".$generatedUsername."' AND sts_delete = 0";
		$check = $this->MCrewscv->getDataQuery($checkSql);

		while ($check[0]->total > 0) {
			$generatedUsername = $baseUsername . rand(100, 999);
			$check = $this->MCrewscv->getDataQuery("SELECT COUNT(*) AS total FROM crew_login WHERE username = '".$generatedUsername."' AND sts_delete = 0");
		}

		return $generatedUsername;
	}

    function setInterviewCrewQualify()
	{
		$id = $this->input->post('id');

		if (!$id) {
			echo json_encode(array('status' => 'error', 'message' => 'ID tidak valid'));
			return;
		}

		$applicantData = $this->MCrewscv->getDataQuery(
			"SELECT * FROM new_applicant WHERE id = '".$id."' AND deletests = '0' LIMIT 1"
		);

		if (empty($applicantData)) {
			echo json_encode(array('status' => 'error', 'message' => 'Data tidak ditemukan'));
			return;
		}

		$app = $applicantData[0];

		$username = '';
		$password = '';

		$fullName = trim(preg_replace('/\s+/', ' ', $app->fullname));
		$parts    = explode(' ', $fullName);

		$fname = '';
		$mname = '';
		$lname = '';

		$totalParts = count($parts);

		if ($totalParts == 1) {
			$fname = $parts[0];

		} elseif ($totalParts == 2) {
			$fname = $parts[0];
			$lname = $parts[1];

		} elseif ($totalParts == 3) {
			$fname = $parts[0];
			$mname = $parts[1];
			$lname = $parts[2];

		} elseif ($totalParts > 3) {
			$fname = $parts[0];
			$mname = $parts[1];
			$lname = implode(' ', array_slice($parts, 2));
		}

		$dob = $app->born_date;

		$existPersonal = $this->MCrewscv->getDataQuery("
			SELECT * FROM mstpersonal
			WHERE deletests = 0
			AND mobileno = '".$app->handphone."'
			AND fname LIKE '".$fname."%'
			AND dob = '".$dob."'
			AND email = '".$app->email."'
			LIMIT 1
		");

		if (!empty($existPersonal)) {

			$idPerson = $existPersonal[0]->idperson;

		} else {

			$last = $this->MCrewscv->getDataQuery(
				"SELECT idperson FROM mstpersonal ORDER BY idperson DESC LIMIT 1"
			);

			if (empty($last)) {
				$idPerson = '000001';
			} else {
				$idPerson = str_pad(((int)$last[0]->idperson + 1), 6, '0', STR_PAD_LEFT);
			}

			$this->MCrewscv->insData('mstpersonal', array(
				'idperson'     => $idPerson,
				'fname'        => $fname,
				'mname'        => $mname,
				'lname'        => $lname,
				'email'        => $app->email,
				'mobileno'     => $app->handphone,
				'dob'          => $app->born_date,
				'pob'          => $app->born_place,
				'applyfor'     => $app->position_applied,
				'gender'       => $app->gender,
				'newapplicent' => 1,
				'addusrdt'     => $this->session->userdata('userCrewSystem') . "/" . date('Ymd') . "/" . date('H:i:s')
			));
		}

		$loginCheck = $this->MCrewscv->getDataQuery("
			SELECT * FROM crew_login 
			WHERE idperson = '".$idPerson."' 
			AND sts_delete = 0
			LIMIT 1
		");

		if (!empty($loginCheck)) {

			$username = $loginCheck[0]->username;
			$password = '(password existing) same as Username';

		} else {

			$username = $this->generateUniqueUsername($app->fullname);
			$password = $username;

			$this->MCrewscv->insData('crew_login', array(
				'idperson'        => $idPerson,
				'id_newapplicant' => $id,
				'fullname'        => $app->fullname,
				'username'        => $username,
				'password'        => md5(strtolower($password)),
				'AddUsrDt'        => $this->session->userdata('userCrewSystem')."/".date('Ymd/H:i:s'),
				'sts_delete'      => 0
			));
		}

		$fullNameUser = str_replace("'", "''", $this->session->userdata('userFullNm'));
		$date = date('Y-m-d H:i:s');

		$this->MCrewscv->updateData(
			array('id' => $id),
			array(
				'st_data' => 5,
				'st_qualify' => 'Y',
				'st_qualify2' => 'Y',
				'adduserdate_stQualify2' => $fullNameUser . "#" . $date,
				'adduserdate_stInterview' => $fullNameUser . "#" . $date
			),
			'new_applicant'
		);

		$this->sendInterviewWithAccountNotification(
			$app->email,
			$app->fullname,
			$username,
			$password
		);
		
		echo json_encode(array(
			'status'   => 'success',
			'message'  => 'Crew has been set for interview.',
			'username' => $username,
			'password' => $password,
			'link'     => base_url('crewPortal')
		));
	}

	function sendInterviewWithAccountNotification($recipientEmail, $fullName, $username, $password)
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
			$mail->Sender = 'noreply@andhika.com';
			$mail->addAddress($recipientEmail);

			$mail->addBCC('andhikacrewing@gmail.com', 'Andhika Crewing');

			$mail->AddEmbeddedImage(APPPATH . '../assets/img/logo_andhika.png', 'logo_andhika');
			
			$mail->isHTML(true);
			$mail->Subject = 'Konfirmasi Proses Tes dan Interview';

			$body = "
			<div style='font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px;'>
				<div style='max-width: 600px; margin: auto; background: #ffffff; padding: 30px; border-radius: 8px; border: 1px solid #ddd;'>
					<div style='background-color: #ffffffff; padding: 20px; text-align: center;'>
						<img src='cid:logo_andhika' alt='PT Andhika Lines' style='max-width: 180px;'>
					</div>

					<p style='font-size: 14px; color: #333;'>Yth. <strong>$fullName</strong>,</p>

					<p style='font-size: 14px; color: #333; line-height: 1.6;'>
						Terima kasih atas minat Anda untuk bergabung bersama <strong>PT Andhika Lines</strong>.
					</p>

					<p style='font-size: 14px; color: #333; line-height: 1.6;'>
						Kami informasikan bahwa Anda telah lolos seleksi administrasi awal dan akan kami proses ke tahap berikutnya berupa <strong>tes dan interview</strong>.
					</p>

					<div style='background:#eef6ff; padding:15px; margin-top:25px; border-left:4px solid #003366;'>

						<p style='font-size:14px; margin-top:10px;'>
							Sebelum hadir untuk proses interview, mohon untuk <strong>mengisi data diri terlebih dahulu</strong> melalui link berikut dan menggunakan akun login dibawah link:<br>
							<a href='https://apps.andhika.com/new-crew-system/crewPortal' style='color:#003366; font-weight:bold;'>https://apps.andhika.com/new-crew-system/crewPortal</a>
						</p>
						
						<p style='font-size:14px; margin:0 0 10px; color:#003366;'>
							<strong>Akun Login Sistem Crewing</strong>
						</p>

						<p style='font-size:14px; margin:2px 0;'><strong>Username:</strong> $username</p>
						<p style='font-size:14px; margin:2px 0;'><strong>Password:</strong> $password</p>
					</div>

					<p style='font-size: 14px; color: #333; line-height: 1.6; margin-top:25px;'>
						Tim kami akan segera menghubungi Anda untuk menyampaikan informasi jadwal dan lokasi pelaksanaan.
						Mohon untuk menyiapkan dokumen yang diperlukan dan hadir tepat waktu.
					</p>

					<p style='margin-top: 30px; font-size: 14px; color: #333;'>
						Hormat kami,<br>
						<strong>Tim Crewing</strong><br>
						PT Andhika Lines
					</p>

					<hr style='border: none; border-top: 1px solid #ccc; margin-top: 40px;'>

					<div style='background-color: #f9f9f9; padding: 20px; font-size: 13px; color: #555;'>
						<p style='margin-bottom: 8px; font-weight: bold;'>Ikuti kami untuk informasi terbaru:</p>
						<ul style='list-style: none; padding-left: 0; margin: 0;'>
							<li style='margin-bottom: 6px;'>
								<img src='https://cdn-icons-png.flaticon.com/24/1384/1384031.png' style='vertical-align: middle; margin-right: 8px;'>
								<a href='https://www.instagram.com/andhika.group/' style='text-decoration: none; color: #003366;'>@andhika.group</a>
							</li>
							<li style='margin-bottom: 6px;'>
								<img src='https://cdn-icons-png.flaticon.com/24/1384/1384031.png' style='vertical-align: middle; margin-right: 8px;'>
								<a href='https://www.instagram.com/lifeatandhika/' style='text-decoration: none; color: #003366;'>@lifeatandhika</a>
							</li>
							<li>
								<img src='https://cdn-icons-png.flaticon.com/24/841/841364.png' style='vertical-align: middle; margin-right: 8px;'>
								<a href='https://andhika.com/' style='text-decoration: none; color: #003366;'>www.andhika.com</a>
							</li>
						</ul>

						<p style='margin-top: 20px; font-size: 12px; color: #888; text-align: center;'>
							<em>Email ini dikirim otomatis oleh sistem Crewing PT Andhika Lines. Mohon tidak membalas email ini.</em>
						</p>
					</div>
				</div>
			</div>";


			$mail->Body = $body;

			if (!$mail->send()) {
				log_message('error', 'Interview Email failed to ' . $recipientEmail . ': ' . $mail->ErrorInfo);
			} else {
				log_message('info', "Interview email sent to $recipientEmail");
			}

		} catch (Exception $e) {
			log_message('error', 'Exception while sending Interview email: ' . $e->getMessage());
		}
	}

    function setNotQualifiedCrew()
	{
		$id = $this->input->post('id');
		$reason = $this->input->post('reason');

		if ($id) {
			$sql = "SELECT email, fullname FROM new_applicant WHERE id = '".$id."' AND deletests = '0'";
			$result = $this->MCrewscv->getDataQuery($sql);


			if (empty($result)) {
				echo json_encode(array('status' => 'error', 'message' => 'Data tidak ditemukan'));
				return;
			}

			$applicant = $result[0];

			$fullNameUser = $this->session->userdata('fullNameCrewSystem');
			$fullNameUser = str_replace("'", "''", $fullNameUser);
			$date = date('Y-m-d H:i:s');

			$data = array(
				'st_data' => 3,
				'st_qualify2' => 'Y',
				'reason_not_qualified' => $reason,
				'adduserdate_notQualify2' => $fullNameUser . "#" . $date,
			);
			$where = array('id' => $id);
			$this->MCrewscv->updateData($where, $data, 'new_applicant');

			$this->sendNotQualifiedNotification($applicant->email, $applicant->fullname, $reason);

			echo json_encode(array('status' => 'success', 'message' => 'Crew has not qualified.'));
		} else {
			echo json_encode(array('status' => 'error', 'message' => 'ID tidak valid'));
		}
	}

	function sendNotQualifiedNotification($recipientEmail, $fullName, $reason)
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
			$mail->Sender = 'noreply@andhika.com';
			$mail->addAddress($recipientEmail);

			$mail->addBCC('andhikacrewing@gmail.com', 'Andhika Crewing');

			$mail->AddEmbeddedImage(APPPATH . '../assets/img/logo_andhika.png', 'logo_andhika');

			$mail->isHTML(true);
			$mail->Subject = 'Informasi Terkait Lamaran Anda';

			$mail->AltBody = "Yth. $fullName,\n\n"
				. "Terima kasih atas minat Anda untuk bergabung bersama PT Andhika Lines.\n"
				. "Saat ini kami memiliki posisi yang sesuai dengan minat Anda. Namun, berdasarkan dokumen yang kami terima, terdapat beberapa sertifikasi atau dokumen yang perlu dilengkapi atau disesuaikan dengan persyaratan posisi yang dilamar.\n\n"
				. "Kami mendorong Anda untuk melengkapi dokumen tersebut agar proses seleksi dapat berjalan lebih lanjut. Informasi mengenai persyaratan posisi dapat Anda lihat pada pengumuman lowongan kami, atau hubungi tim kami melalui WhatsApp di [no_wa].\n\n"
				. "Alasan: $reason\n\n"
				. "CV Anda telah kami simpan dalam database Talent Pool dan akan kami pertimbangkan kembali apabila terdapat kebutuhan yang sesuai di masa mendatang.\n\n"
				. "Hormat kami,\nTim Crewing\nPT Andhika Lines\n\n"
				. "Email ini dikirim otomatis oleh sistem Crewing PT Andhika Lines. Mohon tidak membalas email ini.";

			$mail->Body = "
				<div style='font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px;'>
					<div style='max-width: 600px; margin: auto; background: #ffffff; padding: 30px; border-radius: 8px; border: 1px solid #ddd;'>
						<div style='background-color: #ffffffff; padding: 20px; text-align: center;'>
							<img src='cid:logo_andhika' alt='PT Andhika Lines' style='max-width: 180px;'>
						</div>

						<p style='font-size: 14px; color: #333;'>Yth. <strong>$fullName</strong>,</p>

						<p style='font-size: 14px; color: #333; line-height: 1.6;'>
							Terima kasih atas ketertarikan Anda untuk bergabung bersama <strong>PT. Andhika Lines</strong>.
						</p>

						<p style='font-size: 14px; color: #333; line-height: 1.6;'>
							Saat ini, kami memiliki posisi yang tersedia dan sesuai dengan minat Anda, namun berdasarkan persyaratan yang telah kami tetapkan, terdapat hal yang belum sepenuhnya sesuai, yaitu:
							<span style='display: block; background-color: #fef2f2; color: #991b1b; padding: 12px 16px; border-radius: 6px; border: 1px solid #f5c2c7; font-size: 13.5px;'>
								$reason
							</span>
						</p>

						<p style='font-size: 14px; color: #333; line-height: 1.6;'>
							CV Anda telah kami simpan dalam database <strong>Talent Pool</strong> dan akan kami pertimbangkan kembali apabila terdapat kebutuhan yang sesuai di masa mendatang.
						</p>

						<p style='margin-top: 30px; font-size: 14px; color: #333;'>
							Hormat kami,<br>
							<strong>Tim Crewing</strong><br>
							PT Andhika Lines
						</p>

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
				</div>";

			if (!$mail->send()) {
				log_message('error', 'Reject Email failed to ' . $recipientEmail . ': ' . $mail->ErrorInfo);
			} else {
				log_message('info', "Reject email sent to $recipientEmail");
			}
		} catch (Exception $e) {
			log_message('error', 'Exception while sending Reject email: ' . $e->getMessage());
		}
	}
}