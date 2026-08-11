<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NewApplicant extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('MCrewscv');
        $this->load->library('../controllers/DataContext');
        $this->load->library('session');
    }

	function indexNewApplicant()
    {
        $data = array(
            'title' => 'New Applicant',
            'active_menu' => 'new_applicant',
			'active_submenu' => 'new_applicant',
            'content' => 'Recruitment/NewApplicant/newApplicantView'
        );

        $this->load->view('menu/RecruitmentMenu/main_General', $data);
    }
   
	
    function searchDataReady()
	{
		$this->getDataNewApplicent();
	}

    function getDataNewApplicent()
    {
        header("X-Robots-Tag: noindex, nofollow, noarchive, nosnippet", true);

        header('Content-Type: application/json'); 
        $dataContext = new DataContext();

        $search = $this->input->get('search', true);
		
        $page = $this->input->get('page', true);
		$rows = $this->input->get('rows', true);

		$page = (is_numeric($page) && $page > 0)
			? (int)$page
			: 1;

		$limit = (is_numeric($rows) && $rows > 0)
			? (int)$rows
			: 10;

		$offset = ($page - 1) * $limit;

        $whereSearch = "";

        if (!empty($search)) {

			$keywords = preg_split('/\s+/', trim($search));
			$conditions = array();

			foreach ($keywords as $word) {

				$word = $this->db->escape_like_str($word);

				if ($word === '') continue;

				$conditions[] = "(
					LOWER(position_applied) LIKE LOWER('%$word%')
					OR LOWER(pengalaman_jeniskapal) LIKE LOWER('%$word%')
					OR LOWER(last_experience) LIKE LOWER('%$word%')
					OR LOWER(vessel_type) LIKE LOWER('%$word%')
				)";

			}

			if (!empty($conditions)) {

				$whereSearch = " AND (" . implode(" OR ", $conditions) . ")";

			}
		}

        $sqlTotal = "
            SELECT COUNT(*) AS total
            FROM new_applicant
            WHERE deletests='0'
            AND st_data='0'
            AND st_qualify='N'
            AND st_qualify2='N'
            $whereSearch
        ";

        $resultTotal = $this->MCrewscv->getDataQuery($sqlTotal);

        $totalRows = (!empty($resultTotal)) ? (int)$resultTotal[0]->total : 0;
        $totalPages = max(1, ceil($totalRows / $limit));

        $sql = "
            SELECT *
            FROM new_applicant
            WHERE deletests='0'
            AND st_data='0'
            AND st_qualify='N'
            AND st_qualify2='N'
            $whereSearch
            ORDER BY submit_cv DESC
            LIMIT $limit OFFSET $offset
        ";

        $rows = $this->MCrewscv->getDataQuery($sql);

        $data = array();

        foreach ($rows as $row) {

			$data[] = array(
				'id' => $row->id,
				'email' => $row->email,
				'fullname' => $row->fullname,
				'born_place' => $row->born_place,
				'born_date' => $dataContext->convertReturnName($row->born_date),
				'handphone' => $row->handphone,
				'position_applied' => $row->position_applied,
				'recruitment_id' => $row->recruitment_id,
				'vessel_type' => $row->vessel_type,
				'ijazah_terakhir' => $row->ijazah_terakhir,
				'last_experience' => $row->last_experience,
				'pengalaman_jeniskapal' => $row->pengalaman_jeniskapal,
				'foreign_crew' => $row->berlayardengancrewasing,
				'last_salary' => $row->last_salary,
				'last_salary_currency' => $row->last_salary_currency,
				'expected_salary' => $row->expected_salary,
				'expected_salary_currency' => $row->expected_salary_currency,
				'prev_join' => $row->join_inAndhika,
				'submit_cv' => $dataContext->convertReturnNameWithTime($row->submit_cv),
				'cv_url' => base_url('assets/uploads/CV_NewApplicant/' . $row->new_cv)
			);
		}

        echo json_encode(array(
			'page' => $page,
			'rows_per_page' => $limit,
			'total_pages' => $totalPages,
			'total_rows' => $totalRows,
			'start' => ($totalRows > 0) ? $offset + 1 : 0,
			'end' => min($offset + $limit, $totalRows),
			'data' => $data
		));
    }
    
    function setQualifiedCrew()
	{
		$id = $this->input->post('id');

		if ($id) {
			$sql = "SELECT email, fullname FROM new_applicant WHERE id = '".$id."' AND deletests = '0'";
			$result = $this->MCrewscv->getDataQuery($sql);

			if (empty($result)) {
				echo json_encode(array('status' => 'error', 'message' => 'Data tidak ditemukan'));
				return;
			}
 
			$applicant = $result[0];

			$fullnameUser = $this->session->userdata('userFullNm');
			$datetime = date('d/m/Y-H:i:s');

			$data = array(
				'st_qualify' => 'Y',
				'st_qualify2' => 'N',
				'adduserdate_stQualify' => $fullnameUser . '#' . $datetime
			);
			$where = array('id' => $id);
			$this->MCrewscv->updateData($where, $data, 'new_applicant');
			
			$this->sendFirstQualificationNotification($applicant->email, $applicant->fullname);
			echo json_encode(array('status' => 'success', 'message' => 'Crew has qualified.'));
		} else {
			echo json_encode(array('status' => 'error', 'message' => 'ID tidak valid'));
		}
	}

    function sendFirstQualificationNotification($recipientEmail, $fullName)
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
			$mail->Subject = 'Selamat - Anda Lolos Tahap Pertama (Pengecekan Sertifikat)';

			$mail->AltBody = "Yth. $fullName,\n\n"
				. "Selamat! Anda telah lolos kualifikasi pertama yaitu tahap pengecekan sertifikat.\n\n"
				. "Tim Crewing PT Andhika Lines akan segera menghubungi Anda untuk proses seleksi berikutnya.\n\n"
				. "Hormat kami,\n"
				. "Tim Crewing\n"
				. "PT Andhika Lines\n\n"
				. "Email ini dikirim otomatis oleh sistem Crewing PT Andhika Lines. Mohon tidak membalas email ini.";

			$mail->Body = "
			<div style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px;'>
				<div style='max-width: 600px; margin: auto; background-color: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #e0e0e0;'>

					<div style='background-color: #ffffff; padding: 20px; text-align: center;'>
						<img src='cid:logo_andhika' alt='PT Andhika Lines' style='max-width: 180px;'>
					</div>

					<div style='padding: 30px; color: #333; font-size: 14px; line-height: 1.6;'>
						<p>Yth. <strong>$fullName</strong>,</p>

						<p>Selamat! Anda telah <strong>lolos kualifikasi pertama</strong> yaitu tahap <strong>pengecekan sertifikat</strong>.</p>
						<p>Tim Inti <strong>Crewing (Crew Executive) PT Andhika Lines</strong> akan melakukan proses kualifikasi lanjutan untuk menentukan kelayakan Anda pada tahap berikutnya.</p>

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
			</div>";

			if (!$mail->send()) {
				log_message('error', 'First Qualification Email failed to ' . $recipientEmail . ': ' . $mail->ErrorInfo);
			} else {
				log_message('info', "First Qualification email sent to $recipientEmail");
			}
		} catch (Exception $e) {
			log_message('error', 'Exception while sending First Qualification email: ' . $e->getMessage());
		}
	}

    function getCertificatesByPosition() {
		$position = $this->input->get('position');

		$positionEscaped = $this->db->escape($position);

		$query = "
			SELECT id, certificate_name
			FROM mstcertificatematrix
			WHERE rank_name = $positionEscaped ORDER BY certificate_name ASC
		";

		$result = $this->MCrewscv->getDataQuery($query);

		header('Content-Type: application/json');
		echo json_encode($result);
	}

    function setNotQualifiedCrewLayer1()
	{
		$id = $this->input->post('id');
		$reasonRaw = $this->input->post('reason'); 
		$certificatesRaw = $this->input->post('missing_certificates'); 
		$ranksRaw = $this->input->post('suggested_ranks'); 

		if (!$id) {
			echo json_encode(array('status' => 'error', 'message' => 'ID tidak valid'));
			return;
		}

		$reason = trim((string)$reasonRaw);

		if (is_array($certificatesRaw)) {
			$certificatesStr = implode(', ', $certificatesRaw);
		} else {
			$certificatesStr = trim((string)$certificatesRaw);
		}

		if (is_array($ranksRaw)) {
			$ranksStr = implode(', ', $ranksRaw);
		} else {
			$ranksStr = trim((string)$ranksRaw);
		}


		$lines = preg_split("/\r\n|\n|\r/", $reason);
		$manualLines = array();

		foreach ($lines as $line) {

			$trim = trim($line);
			$lower = strtolower($trim);

			if (
				strpos($lower, 'sertifikat yang belum terpenuhi:') === 0 ||
				strpos($lower, 'dengan melengkapi sertifikat di atas') === 0
			) {
				continue;
			}

			if ($trim !== '') {
				$manualLines[] = $trim;
			}
		}

		$manualReason = implode("\n", $manualLines);

		$reasonParts = array();

		if ($manualReason !== '') {
			$reasonParts[] = $manualReason;
		}

		if ($certificatesStr !== '') {
			$reasonParts[] = "Sertifikat yang belum terpenuhi: " . $certificatesStr;
		}

		if ($ranksStr !== '') {
			$reasonParts[] = "Dengan melengkapi sertifikat di atas, Anda bisa melamar untuk posisi: " . $ranksStr;
		}

		$reasonFinal = implode("\n", $reasonParts);


		$sql = "SELECT email, fullname 
				FROM new_applicant 
				WHERE id = '".$id."' 
				AND deletests = '0'";

		$result = $this->MCrewscv->getDataQuery($sql);

		if (empty($result)) {
			echo json_encode(array('status' => 'error', 'message' => 'Data tidak ditemukan'));
			return;
		}

		$applicant = $result[0];


		$fullNameUser = $this->session->userdata('userFullNm');
		$fullNameUser = str_replace("'", "''", $fullNameUser);
		$date = date('Y-m-d H:i:s');

		$data = array(
			'st_data' => 3,
			'reason_not_qualified_layer1' => $reasonFinal,
			'adduserdate_notQualify' => $fullNameUser . "#" . $date,
		);

		$where = array('id' => $id);

		$this->MCrewscv->updateData($where, $data, 'new_applicant');

		$this->sendNotQualifiedNotificationLayer1(
			$applicant->email,
			$applicant->fullname,
			$reasonFinal,
			$certificatesStr,
			$ranksStr
		);

		echo json_encode(array(
			'status' => 'success',
			'message' => 'Crew has not qualified.'
		));
	}

    function sendNotQualifiedNotificationLayer1($recipientEmail, $fullName, $reasonClean = "", $certificates = "", $ranks = "")
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

			$mail->addBCC('andhikacrewing@gmail.com', 'Andhika Crewing');

			$mail->AddEmbeddedImage(APPPATH . '../assets/img/logo_andhika.png', 'logo_andhika');

			$mail->isHTML(true);
			$mail->Subject = 'Informasi Terkait Lamaran Anda';

			$body = "
			<div style='font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px;'>
				<div style='max-width: 600px; margin: auto; background: #ffffff; padding: 30px; border-radius: 8px; border: 1px solid #ddd;'>
					<div style='padding: 20px; text-align: center;'>
						<img src='cid:logo_andhika' alt='PT Andhika Lines' style='max-width: 180px;'>
					</div>

					<p style='font-size: 14px; color: #333;'>Yth. <strong>$fullName</strong>,</p>

					<p style='font-size: 14px; color: #333; line-height: 1.6;'>
						Terima kasih atas ketertarikan Anda untuk bergabung bersama <strong>PT. Andhika Lines</strong>.
					</p>
			";

			if (!empty($reasonClean)) {
				$body .= "
					<p style='font-size: 14px; color: #333; line-height: 1.6;'> 
						Dengan berat hati kami sampaikan bahwa kami belum bisa melanjutkan Anda ke tahap berikutnya karena ada beberapa sertifikat yang Anda harus penuhi terlebih dulu
					</p>

					<div style='margin:10px 0;'>
						<strong>Sertifikat yang belum terpenuhi:</strong>
						<div style='background-color:#fef2f2; color:#991b1b; padding:8px 12px; border-radius:6px; font-size:13px;'>
							$certificates
						</div>
					</div>

					<div style='margin:10px 0;'>
						<strong>Dengan melengkapi sertifikat di atas, Anda bisa melamar untuk posisi:</strong>
						<div style='background-color:#e0f7fa; color:#004d40; padding:8px 12px; border-radius:6px; font-size:13px;'>
							$ranks
						</div>
					</div>

					<div style='margin:10px 0;'>
						<strong>Reason:</strong>
						<div style='background-color:#e0f7fa; color:#004d40; padding:8px 12px; border-radius:6px; font-size:13px;'>
							$reasonClean
						</div>
					</div>
				";
			} else {
				$body .= "
					<p style='font-size: 14px; color: #333; line-height: 1.6;'> 
						Dengan berat hati kami sampaikan bahwa kami belum bisa melanjutkan Anda ke tahap berikutnya karena ada beberapa sertifikat yang Anda harus penuhi terlebih dulu.
					</p>

					<div style='margin:10px 0;'>
						<strong>Sertifikat yang belum terpenuhi:</strong>
						<div style='background-color:#fef2f2; color:#991b1b; padding:8px 12px; border-radius:6px; font-size:13px;'>
							$certificates
						</div>
					</div>

					<div style='margin:10px 0;'>
						<strong>Dengan melengkapi sertifikat di atas, Anda bisa melamar untuk posisi:</strong>
						<div style='background-color:#e0f7fa; color:#004d40; padding:8px 12px; border-radius:6px; font-size:13px;'>
							$ranks
						</div>
					</div>
				";
			}

			$body .= "
					<p style='font-size: 14px; color: #333; line-height: 1.6;'>
						CV Anda telah kami simpan dalam database <strong>Talent Pool</strong> dan akan kami pertimbangkan kembali apabila terdapat kebutuhan yang sesuai di masa mendatang. 
						Kami nantikan lamaran anda kembali dengan dokumen persyaratan yang lebih lengkap.
					</p>

					<p style='margin-top: 30px; font-size: 14px; color: #333;'>
						Hormat kami,<br>
						<strong>Tim Crewing</strong><br>
						PT Andhika Lines
					</p>
				</div>
			</div>";

			$mail->Body = $body;
			$mail->send();

		} catch (Exception $e) {
			log_message('error', 'Reject Email gagal: ' . $e->getMessage());
		}
	}

	function setNotPositionCrew()
	{
		$id = $this->input->post('id');
		$favoriteCandidate = (int)$this->input->post('favorite_candidate');

		if ($id) {

			$sql = "SELECT email, fullname
					FROM new_applicant
					WHERE id = '".$id."'
					AND deletests = '0'";

			$result = $this->MCrewscv->getDataQuery($sql);

			if (empty($result)) {
				echo json_encode(array(
					'status' => 'error',
					'message' => 'Data tidak ditemukan'
				));
				return;
			}

			$applicant = $result[0];

			$fullnameUser = $this->session->userdata('userFullNm');
			$fullnameUser = str_replace(' ', '', $fullnameUser);

			$date = date('Y-m-d H:i:s');

			$data = array(
				'st_data' => 2,
				'favorite_candidate' => $favoriteCandidate,
				'adduserdate_notPosition' => $fullnameUser . "#" . $date
			);

			if ($favoriteCandidate == 1) {
				$data['favorite_date'] = $date;
				$data['favorite_by'] = $fullnameUser;
			} else {
				$data['favorite_date'] = null;
				$data['favorite_by'] = null;
			}

			$where = array(
				'id' => $id
			);

			$this->MCrewscv->updateData(
				$where,
				$data,
				'new_applicant'
			);

			$this->sendNotPositionNotification(
				$applicant->email,
				$applicant->fullname
			);

			echo json_encode(array(
				'status' => 'success',
				'message' => ($favoriteCandidate == 1)
					? 'Candidate berhasil dimasukkan ke High Potential Talent Pool.'
					: 'Candidate berhasil dimasukkan ke Talent Pool.'
			));

		} else {

			echo json_encode(array(
				'status' => 'error',
				'message' => 'ID tidak valid'
			));

		}
	}

	function sendNotPositionNotification($recipientEmail, $fullName)
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

			$mail->addBCC('andhikacrewing@gmail.com', 'Andhika Crewing');
			
			$mail->addAddress($recipientEmail);

			$mail->AddEmbeddedImage(APPPATH . '../assets/img/logo_andhika.png', 'logo_andhika');

			$mail->isHTML(true);
			$mail->Subject = 'Terima Kasih - Data Anda Telah Diterima';

			$mail->AltBody = "Yth. $fullName,\n\n"
				. "Terima kasih atas ketertarikan Anda untuk bergabung bersama PT Andhika Lines.\n"
				. "Saat ini, kami belum memiliki posisi yang tersedia yang sesuai dengan profil Anda. Namun, "
				. "informasi Anda telah kami masukkan ke dalam database Talent Pool kami, dan akan kami "
				. "pertimbangkan kembali apabila terdapat kebutuhan yang relevan di masa mendatang.\n\n"
				. "Hormat kami,\n"
				. "Tim Crewing\n"
				. "PT Andhika Lines\n\n"
				. "Email ini dikirim otomatis oleh sistem Crewing PT Andhika Lines. Mohon tidak membalas email ini.";


			$mail->Body = "
			<div style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px;'>
				<div style='max-width: 600px; margin: auto; background-color: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #e0e0e0;'>

					<div style='background-color: #ffffff; padding: 20px; text-align: center;'>
						<img src='cid:logo_andhika' alt='PT Andhika Lines' style='max-width: 180px;'>
					</div>

					<div style='padding: 30px; color: #333; font-size: 14px; line-height: 1.6;'>
						<p>Yth. <strong>$fullName</strong>,</p>

						<p>Terima kasih atas ketertarikan Anda untuk bergabung bersama <strong>PT Andhika Lines</strong>.</p>
						<p>Saat ini, kami belum memiliki posisi yang tersedia yang sesuai dengan profil Anda. Namun, informasi Anda telah kami masukkan ke dalam database <strong>Talent Pool</strong> kami, dan akan kami pertimbangkan kembali apabila terdapat kebutuhan yang relevan di masa mendatang.</p>

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
			</div>";

			if (!$mail->send()) {
				log_message('error', 'Draft Email failed to ' . $recipientEmail . ': ' . $mail->ErrorInfo);
			} else {
				log_message('info', "Draft email sent to $recipientEmail");
			}
		} catch (Exception $e) {
			log_message('error', 'Exception while sending Draft email: ' . $e->getMessage());
		}
	}

	function deleteData()
	{
		$id = $this->input->post('id');

		if ($id) {
			$where = array('id' => $id);
			$data = array('deletests' => '1');
			$this->MCrewscv->updateData($where, $data, 'new_applicant');
			echo json_encode(array('status' => 'success', 'message' => 'Data has been deleted.'));
		} else {
			echo json_encode(array('status' => 'error', 'message' => 'ID tidak valid'));
		}
	}
}