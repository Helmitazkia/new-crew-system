<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class McuApplicant extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('MCrewscv');
        $this->load->library('../controllers/DataContext');
        $this->load->library('session');
    }

	function indexMcuApplicant()
    {
        $data = array(
            'title' => 'MCU Applicant',
            'active_menu' => 'mcu_applicant',
			'active_submenu' => 'mcu_applicant',
            'content' => 'Recruitment/McuApplicant/McuApplicantView',
        );

        $this->load->view('menu/RecruitmentMenu/main_McuApplicant', $data);
    }

    function searchDataMCUcrew()
	{
		$search = $this->input->get('search');
		$page = $this->input->get('page');
		$this->getDataMCUCrew($search, $page);
	}

    function getDataMCUCrew()
    {
        $dataContext = new DataContext();

        $sql = "
            SELECT 
                a.*, 
                f.file_name AS mcu_file,
                f.uploaded_at AS mcu_uploaded_at
            FROM new_applicant a
            LEFT JOIN applicant_mcu_files f 
                ON f.applicant_id = a.id 
                AND f.deletests = '0'
            WHERE a.deletests = '0' 
                AND a.st_data = '6'
            ORDER BY a.submit_cv DESC
        ";

        $rsl = $this->MCrewscv->getDataQuery($sql);

        $data = array();

        foreach ($rsl as $val) {

            $data[] = array(
                "id" => $val->id,
                "email" => $val->email,
                "fullname" => $val->fullname,
                "born_place" => $val->born_place,
                "born_date" => $dataContext->convertReturnName($val->born_date),
                "handphone" => $val->handphone,
                "vessel_type" => $val->vessel_type,
                "position_applied" => $val->position_applied,
                "ijazah_terakhir" => $val->ijazah_terakhir,
                "last_experience" => $val->last_experience,
                "pengalaman_jeniskapal" => $val->pengalaman_jeniskapal,
                "berlayardengancrewasing" => $val->berlayardengancrewasing,
                'last_salary' => $val->last_salary,
				'last_salary_currency' => $val->last_salary_currency,
				'expected_salary' => $val->expected_salary,
				'expected_salary_currency' => $val->expected_salary_currency,
                "join_inAndhika" => $val->join_inAndhika,
                "submit_cv" => $dataContext->convertReturnNameWithTime($val->submit_cv),

                'cv_url' => base_url('assets/uploads/CV_NewApplicant/' . $val->new_cv),
            );
        }

        echo json_encode(array(
            "data" => $data
        ));
    }

    function setWithdrawApplicant()
	{
		$id = $this->input->post('id');
		$date = date('Y-m-d H:i:s');
		$username = $this->session->userdata('fullNameCrewSystem');

		if (empty($id)) {
			echo json_encode(array('status' => 'error', 'message' => 'ID tidak valid'));
			return;
		}

		$sql = "SELECT * FROM new_applicant WHERE id = '".$id."' AND deletests = '0'";
		$applicant = $this->MCrewscv->getDataQuery($sql);

		if (empty($applicant)) {
			echo json_encode(array('status' => 'error', 'message' => 'Data applicant tidak ditemukan.'));
			return;
		}

		$app = $applicant[0];
		$recipientEmail = $app->email;
		$fullName = $app->fullname;

		$this->MCrewscv->updateData(
			array('id' => $id),
			array(
				'st_data' => 7,
				'adduserWithdraw' => $username,
                'adduserdateWithdraw' => $date
			),
			'new_applicant'
		);

		$this->sendWithdrawNotification($recipientEmail, $fullName);

		echo json_encode(array(
			'status' => 'success',
			'message' => 'Crew telah diset sebagai MCU Withdraw dan notifikasi email telah dikirim.',
			'email' => $recipientEmail
		));
	}

	function sendWithdrawNotification($recipientEmail, $fullName)
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
            $mail->Subject = 'Pengunduran Diri Kandidat - PT Andhika Lines';

            $mail->AltBody = "Yth. $fullName,\n\n"
                . "Kami mengonfirmasi bahwa Anda telah mengundurkan diri dari proses rekrutmen PT Andhika Lines.\n\n"
                . "Kami mengucapkan terima kasih atas waktu dan partisipasi Anda selama proses seleksi berlangsung.\n\n"
                . "Semoga sukses untuk karier dan kesempatan Anda di masa mendatang.\n\n"
                . "Hormat kami,\nTim Crewing\nPT Andhika Lines";

            $mail->Body = "
            <div style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px;'>
                <div style='max-width: 600px; margin: auto; background-color: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #e0e0e0;'>

                    <div style='background-color: #ffffff; padding: 20px; text-align: center;'>
                        <img src='cid:logo_andhika' alt='PT Andhika Lines' style='max-width: 180px;'>
                    </div>

                    <div style='padding: 30px; color: #333; font-size: 14px; line-height: 1.6;'>
                        <p>Yth. <strong>$fullName</strong>,</p>

                        <p>Kami mengonfirmasi bahwa Anda telah <strong>mengundurkan diri dari proses rekrutmen PT Andhika Lines</strong>.

                        <p>Kami mengucapkan terima kasih atas waktu, usaha, dan partisipasi yang telah Anda berikan selama mengikuti proses seleksi bersama kami.</p>

                        <p>Kami menghormati keputusan Anda dan mendoakan kesuksesan untuk perjalanan karier Anda ke depan.</p>

                        <p>
                            Hormat kami,<br>
                            <strong>Tim Crewing</strong><br>
                            PT Andhika Lines
                        </p>
                    </div>

                    <hr style='border: none; border-top: 1px solid #ccc; margin-top: 20px;'>

                    <div style='background-color: #f9f9f9; padding: 20px; font-size: 13px; color: #555;'>

                        <p style='margin-bottom: 8px; font-weight: bold;'>
                            Ikuti kami untuk informasi terbaru:
                        </p>

                        <ul style='list-style: none; padding-left: 0; margin: 0;'>

                            <li style='margin-bottom: 6px;'>
                                <img src='https://cdn-icons-png.flaticon.com/24/1384/1384031.png'
                                    alt='Instagram'
                                    style='vertical-align: middle; margin-right: 8px;'>

                                <a href='https://www.instagram.com/andhika.group/'
                                    style='text-decoration: none; color: #003366;'>
                                    @andhika.group
                                </a>
                            </li>

                            <li style='margin-bottom: 6px;'>
                                <img src='https://cdn-icons-png.flaticon.com/24/1384/1384031.png'
                                    alt='Instagram'
                                    style='vertical-align: middle; margin-right: 8px;'>

                                <a href='https://www.instagram.com/lifeatandhika/'
                                    style='text-decoration: none; color: #003366;'>
                                    @lifeatandhika
                                </a>
                            </li>

                            <li>
                                <img src='https://cdn-icons-png.flaticon.com/24/841/841364.png'
                                    alt='Website'
                                    style='vertical-align: middle; margin-right: 8px;'>

                                <a href='https://andhika.com/'
                                    style='text-decoration: none; color: #003366;'>
                                    www.andhika.com
                                </a>
                            </li>

                        </ul>

                        <p style='margin-top: 20px; font-size: 12px; color: #888; text-align: center;'>
                            <em>Email ini dikirim otomatis oleh sistem Crewing PT Andhika Lines. Mohon tidak membalas email ini.</em>
                        </p>

                    </div>
                </div>
            </div>";

            if (!$mail->send()) {
                log_message('error', 'Withdraw email failed to ' . $recipientEmail . ': ' . $mail->ErrorInfo);
            } else {
                log_message('info', "Withdraw email sent to $recipientEmail");
            }
        } catch (Exception $e) {
            log_message('error', 'Exception while sending Withdraw email: ' . $e->getMessage());
        }
    }

    function setNotFitApplicant()
	{
		$id = $this->input->post('id');
		$date = date('Y-m-d H:i:s');
		$username = $this->session->userdata('fullNameCrewSystem');

		if (empty($id)) {
			echo json_encode(array('status' => 'error', 'message' => 'ID tidak valid'));
			return;
		}

		$sql = "SELECT * FROM new_applicant WHERE id = '".$id."' AND deletests = '0'";
		$applicant = $this->MCrewscv->getDataQuery($sql);

		if (empty($applicant)) {
			echo json_encode(array('status' => 'error', 'message' => 'Data applicant tidak ditemukan.'));
			return;
		}

		$app = $applicant[0];
		$recipientEmail = $app->email;
		$fullName = $app->fullname;

		$this->MCrewscv->updateData(
			array('id' => $id),
			array(
				'st_data' => 8,
				'adduserdate_notFit' => $username . "#" . $date
			),
			'new_applicant'
		);

		$this->sendNotFitNotification($recipientEmail, $fullName);

		echo json_encode(array(
			'status' => 'success',
			'message' => 'Crew telah diset sebagai MCU Not Fit dan notifikasi email telah dikirim.',
			'email' => $recipientEmail
		));
	}

	function sendNotFitNotification($recipientEmail, $fullName)
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

			$mail->AddEmbeddedImage(APPPATH . '../assets/img/logo_andhika.png', 'logo_andhika');

			$mail->isHTML(true);
			$mail->Subject = 'Hasil Pemeriksaan MCU - PT Andhika Lines';

			$mail->AltBody = "Yth. $fullName,\n\n"
				. "Kami sampaikan terima kasih atas partisipasi Anda dalam proses seleksi di PT Andhika Lines.\n"
				. "Berdasarkan hasil pemeriksaan Medical Check Up (MCU), dengan berat hati kami informasikan bahwa Anda dinyatakan *Not Fit* untuk proses lebih lanjut.\n\n"
				. "Kami menghargai waktu dan usaha Anda, dan semoga sukses untuk langkah selanjutnya.\n\n"
				. "Hormat kami,\nTim Crewing\nPT Andhika Lines";

			$mail->Body = "
			<div style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px;'>
				<div style='max-width: 600px; margin: auto; background-color: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #e0e0e0;'>
					<div style='background-color: #ffffff; padding: 20px; text-align: center;'>
						<img src='cid:logo_andhika' alt='PT Andhika Lines' style='max-width: 180px;'>
					</div>

					<div style='padding: 30px; color: #333; font-size: 14px; line-height: 1.6;'>
						<p>Yth. <strong>$fullName</strong>,</p>

						<p>Kami sampaikan terima kasih atas partisipasi Anda dalam proses seleksi di <strong>PT Andhika Lines</strong>.</p>
						<p>Berdasarkan hasil pemeriksaan <strong>Medical Check Up (MCU)</strong>, dengan berat hati kami informasikan bahwa Anda dinyatakan <strong style='color:#d33;'>Not Fit</strong> untuk melanjutkan ke tahap berikutnya.</p>
						<p>Kami menghargai waktu dan usaha Anda, dan semoga sukses untuk langkah karier Anda ke depan.</p>

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
t
						<p style='margin-top: 20px; font-size: 12px; color: #888; text-align: center;'>
							<em>Email ini dikirim otomatis oleh sistem Crewing PT Andhika Lines. Mohon tidak membalas email ini.</em>
						</p>
					</div>
				</div>
			</div>";

			if (!$mail->send()) {
				log_message('error', 'Not Fit email failed to ' . $recipientEmail . ': ' . $mail->ErrorInfo);
			} else {
				log_message('info', "Not Fit email sent to $recipientEmail");
			}
		} catch (Exception $e) {
			log_message('error', 'Exception while sending Not Fit email: ' . $e->getMessage());
		}
	}

    function setMCUApplicant()
	{
		$id = $this->input->post('id');

		if (empty($id)) {
			echo json_encode(array('status' => 'error', 'message' => 'ID tidak valid'));
			return;
		}

		$sql = "SELECT * FROM new_applicant WHERE id = '".$id."' AND deletests = '0'";
		$applicant = $this->MCrewscv->getDataQuery($sql);

		if (empty($applicant)) {
			echo json_encode(array('status' => 'error', 'message' => 'Data applicant tidak ditemukan.'));
			return;
		}

		$app = $applicant[0];
		$fullNameUser = str_replace("'", "''", $this->session->userdata('userFullNm'));
		$date = date('Y-m-d H:i:s');

		$this->MCrewscv->updateData(
			array('id' => $id),
			array(
				'st_data' => 1,
				'adduserdate_stMCU' => $fullNameUser . "#" . $date
			),
			'new_applicant'
		);

		$sqlLogin = "SELECT * FROM crew_login WHERE id_newapplicant = '".$id."' AND sts_delete = 0 LIMIT 1";
		$login = $this->MCrewscv->getDataQuery($sqlLogin);

		if (empty($login)) {
			echo json_encode(array('status' => 'error', 'message' => 'Akun login tidak ditemukan untuk crew ini.'));
			return;
		}

		$loginData = $login[0];
		$username = $loginData->username;
		$password = $loginData->username; 
		$recipientEmail = $app->email;
		$fullName = $app->fullname;

		$this->sendPickUpNotification($recipientEmail, $fullName, $username, $password);

		print json_encode(array(
			'status' => 'success',
			'message' => 'Crew telah diset sebagai MCU Fit dan email login telah dikirim.',
			'email' => $recipientEmail,
			'username' => $username,
			'password' => $password
		));
	}

	function sendPickUpNotification($recipientEmail, $fullName, $username, $password)
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
			$mail->AddEmbeddedImage(APPPATH . '../assets/img/logo_andhika.png', 'logo_andhika');

			$mail->isHTML(true);
			$mail->Subject = '✅ Hasil MCU Fit & Akun Login Anda - PT Andhika Lines';

			$mail->AltBody = "Yth. Bapak/Ibu $fullName,\n\n"
				. "Selamat! Anda telah dinyatakan *FIT (Lolos MCU)* oleh PT Andhika Lines.\n\n"
				. "Anda kini dapat mengakses portal Crew untuk melengkapi data diri Anda menggunakan akun berikut:\n"
				. "👤 Username: $username\n"
				. "🔒 Password: $password\n\n"
				. "Silakan login melalui portal resmi PT Andhika Lines untuk melengkapi seluruh data Anda.\n\n"
				. "Hormat kami,\nCrewing Team\nPT Andhika Lines\n\n"
				. "⚠️ Email ini dikirim otomatis oleh sistem. Mohon tidak membalas email ini.";

			$mail->Body = "
				<div style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;'>
					<div style='background-color: #ffffff; padding: 20px; text-align: center;'>
						<img src='cid:logo_andhika' alt='PT Andhika Lines' style='max-width: 180px;'>
					</div>

					<div style='max-width: 600px; margin: auto; background: #ffffff; padding: 30px; border-radius: 8px; border: 1px solid #ddd;'>
						<h2 style='color: #28a745; margin-top: 0;'>✅ Selamat, Anda Dinyatakan FIT!</h2>

						<p style='font-size: 14px; color: #333;'>👋 Yth. <strong>$fullName</strong>,</p>

						<p style='font-size: 14px; color: #333; line-height: 1.6;'>
							Kami dengan senang hati menginformasikan bahwa Anda telah <strong>lolos pemeriksaan MCU (Medical Check-Up)</strong> 
							dan dinyatakan <strong>FIT</strong> untuk melanjutkan proses di <strong>PT Andhika Lines</strong>. 🚢
						</p>

						<p style='font-size: 14px; color: #333; line-height: 1.6;'>
							Untuk melanjutkan ke tahap berikutnya, silakan login ke portal Crew dan lengkapi data diri Anda menggunakan akun berikut:
						</p>

						<ul style='font-size: 14px; color: #333; line-height: 1.6;'>
							<li><strong>Username:</strong> $username</li>
							<li><strong>Password:</strong> $password</li>
						</ul>

						<p style='font-size: 14px; color: #333; line-height: 1.6;'>
							🔗 <strong>Portal Crew:</strong> <a href='https://apps.andhika.com/crewcv/crew/getLoginCrew' style='color:#007bff;'>https://apps.andhika.com/crewcv/crew/getLoginCrew</a>
						</p>

						<p style='margin-top: 25px; font-size: 14px; color: #333;'>
							Terima kasih telah berpartisipasi dalam proses rekrutmen kami.<br>
							Tim Crewing akan menghubungi Anda apabila diperlukan untuk tahap selanjutnya.
						</p>

						<p style='margin-top: 30px; font-size: 14px; color: #333;'>
							🙏 Hormat kami,<br>
							<strong>👨‍✈️ Crewing Team</strong><br>
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

							<p style='font-size: 12px; color: #777; text-align: center; margin-top: 20px;'>
								⚠️ Email ini dikirim otomatis oleh sistem Crewing PT Andhika Lines. Mohon tidak membalas email ini.
							</p>
						</div>
					</div>
				</div>
			";

			if (!$mail->send()) {
				log_message('error', 'MCU Fit email failed to ' . $recipientEmail . ': ' . $mail->ErrorInfo);
			} else {
				log_message('info', "MCU Fit email sent to $recipientEmail");
			}
		} catch (Exception $e) {
			log_message('error', 'Exception while sending MCU Fit email: ' . $e->getMessage());
		}
	}
}