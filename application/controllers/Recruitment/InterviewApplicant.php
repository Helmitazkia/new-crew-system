<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InterviewApplicant extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('MCrewscv');
        $this->load->library('../controllers/DataContext');
        $this->load->library('session');
    }

	function indexInterviewApplicant()
    {
        $data = array(
            'title' => 'Interview Applicant',
            'active_menu' => 'interview_applicant',
			'active_submenu' => 'interview_applicant',
            'content' => 'Recruitment/InterviewApplicant/interviewApplicantView',
        );

        $this->load->view('menu/RecruitmentMenu/main_InterviewApplicant', $data);
    }

    function searchDataInterview()
	{
		$search = $this->input->get('search');
		$page = $this->input->get('page');
		$this->getDataInterviewCrew($search, $page);
	}
    
    function getDataInterviewCrew($search = "", $page = 1)
    {
        $dataContext = new DataContext();

        $search = isset($_GET['search']) ? $_GET['search'] : $search;

        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : $page;
        if ($page < 1) $page = 1;

        $limit = isset($_GET['rows']) && is_numeric($_GET['rows']) ? intval($_GET['rows']) : 10;

        if ($limit <= 0) $limit = 10;

        $sqlTotal = "SELECT COUNT(*) as total FROM new_applicant 
            WHERE deletests = '0' AND st_data = '5' 
            AND (position_applied LIKE '%$search%' 
            OR fullname LIKE '%$search%' 
            OR vessel_type LIKE '%$search%'
            OR email LIKE '%$search%' 
            OR pengalaman_jeniskapal LIKE '%$search%')";

        $resultTotal = $this->MCrewscv->getDataQuery($sqlTotal);
        $totalRows = isset($resultTotal[0]) ? $resultTotal[0]->total : 0;

        $totalPages = $limit > 0 ? ceil($totalRows / $limit) : 1;

        if ($page > $totalPages && $totalPages > 0) {
            $page = $totalPages;
        }

        $offset = max(0, ($page - 1) * $limit);

        $sql = "SELECT * FROM new_applicant 
            WHERE deletests = '0' AND st_data = '5' 
            AND (position_applied LIKE '%$search%' 
            OR fullname LIKE '%$search%' 
            OR vessel_type LIKE '%$search%'
            OR email LIKE '%$search%' 
            OR pengalaman_jeniskapal LIKE '%$search%')
            ORDER BY submit_cv DESC
            LIMIT $limit OFFSET $offset";

        $rsl = $this->MCrewscv->getDataQuery($sql);

        $data = array();

        foreach ($rsl as $val) {


            $data[] = array(
                'id' => $val->id,   
                'email' => $val->email,
                'fullname' => $val->fullname,
                'born_place' => $val->born_place,
                'born_date' => $dataContext->convertReturnName($val->born_date),
                'handphone' => $val->handphone,
                'vessel_type' => $val->vessel_type,
                'position_applied' => $val->position_applied,
                'ijazah_terakhir' => $val->ijazah_terakhir,
                'last_experience' => $val->last_experience,
                'pengalaman_jeniskapal' => $val->pengalaman_jeniskapal,
                'berlayardengancrewasing' => $val->berlayardengancrewasing,
                'last_salary' => $val->last_salary,
				'last_salary_currency' => $val->last_salary_currency,
                'expected_salary' => $val->expected_salary,
				'expected_salary_currency' => $val->expected_salary_currency,
                'join_inAndhika' => $val->join_inAndhika,
                'submit_cv' => $dataContext->convertReturnNameWithTime($val->submit_cv),
                'cv_url' => base_url('assets/uploads/CV_NewApplicant/' . $val->new_cv)
            );
        }

        $response = array(
            'data' => $data,
            'pagination' => array(
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total_rows' => $totalRows,
                'rows_per_page' => $limit,
                'search' => $search
            )
        );

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    function passInterview()
    {
        $id = $this->input->post('id');

        if (empty($id)) {
            echo json_encode(array(
                'status'  => 'error',
                'message' => 'ID applicant tidak valid'
            ));
            return;
        }

        $sql = "SELECT fullname, email 
                FROM new_applicant 
                WHERE id = '".$id."' 
                AND deletests = '0'";

        $data = $this->MCrewscv->getDataQuery($sql);

        if (empty($data)) {
            echo json_encode(array(
                'status'  => 'error',
                'message' => 'Data applicant tidak ditemukan'
            ));
            return;
        }

        $app = $data[0];
		$fullNameUser = str_replace("'", "''", $this->session->userdata('userFullNm'));
		$date = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $update = $this->db->update('new_applicant', array(
            'st_data' => '6',
			'adduserdate_stMCU' =>  $fullNameUser . "#" . $date
        ));

        if (!$update) {
            echo json_encode(array(
                'status'  => 'error',
                'message' => 'Gagal update status applicant'
            ));
            return;
        }

        $this->sendPassInterviewNotification($app->email, $app->fullname);

        echo json_encode(array(
            'status'  => 'success',
            'message' => 'Applicant lolos interview dan notifikasi email berhasil dikirim'
        ));
    }

    function sendPassInterviewNotification($recipientEmail, $fullName)
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
			$mail->Subject = 'Hasil Interview - PT Andhika Lines';

			$mail->AltBody =
				"Yth. Bapak/Ibu $fullName,\n\n" .
				"Anda telah lolos tahapan interview dan berhak melanjutkan ke proses berikutnya bersama PT Andhika Lines.\n\n" .
				"Tim Crewing PT Andhika Lines akan segera menghubungi Anda untuk tahapan selanjutnya apabila diperlukan.\n" .
				"Mohon pastikan nomor telepon dan email Anda tetap aktif.\n\n" .
				"Hormat kami,\nTim Crewing\nPT Andhika Lines\n\n" .
				"Email ini dikirim otomatis oleh sistem. Mohon tidak membalas email ini.";

			$mail->Body = "
			<div style='font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px;'>
				<div style='max-width: 600px; margin: auto; background: #ffffff; padding: 30px; border-radius: 8px; border: 1px solid #ddd;'>
					
					<div style='text-align: center; margin-bottom: 20px;'>
						<img src='cid:logo_andhika' alt='PT Andhika Lines' style='max-width: 180px;'>
					</div>

					<p style='font-size: 14px; color: #333;'>Yth. Bapak/Ibu <strong>$fullName</strong>,</p>

					<p style='font-size: 14px; color: #333; line-height: 1.6;'>
						<strong>Congratulations!</strong>
					</p>

					<p style='font-size: 14px; color: #333; line-height: 1.6;'>
						Anda telah <strong>lolos tahapan interview</strong> dan berhak melanjutkan ke proses berikutnya bersama
						<strong>PT Andhika Lines</strong>.
					</p>

					<p style='font-size: 14px; color: #333; line-height: 1.6;'>
						Tim Crewing PT Andhika Lines akan <strong>segera menghubungi Anda</strong> untuk tahapan selanjutnya apabila diperlukan.
						Mohon pastikan nomor telepon dan email Anda tetap aktif.
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

			if (!$mail->send()) {
				log_message('error', 'Pass Interview Email failed to ' . $recipientEmail . ': ' . $mail->ErrorInfo);
			} else {
				log_message('info', "Pass Interview Email sent to $recipientEmail");
			}

		} catch (Exception $e) {
			log_message('error', 'Exception while sending Pass Interview Email: ' . $e->getMessage());
		}
	}

    function setNotRefference()
	{
		$id     = $this->input->post('id');
		$reason = $this->input->post('reason'); 

		if ($id) {
			$sql = "SELECT email, fullname FROM new_applicant WHERE id = '".$id."' AND deletests = '0'";
			$result = $this->MCrewscv->getDataQuery($sql);

			if (empty($result)) {
				echo json_encode(array('status' => 'error', 'message' => 'Data tidak ditemukan'));
				return;
			}

			$applicant = $result[0];
			$fullnameUser = $this->session->userdata('fullNameCrewSystem');
			$fullnameUser = str_replace("'", "''", $fullnameUser);
			$date = date('Y-m-d H:i:s');

			$data = array(
				'st_data' => 4,
				'notReff_reason' => $reason, 
				'adduserdate_notReff' => $fullnameUser . "#" . $date,
			);
			$where = array('id' => $id);
			$this->MCrewscv->updateData($where, $data, 'new_applicant');

			$this->sendNotRefferenceNotification($applicant->email, $applicant->fullname, $reason);

			echo json_encode(array('status' => 'success', 'message' => 'Crew has not qualified.'));
		} else {
			echo json_encode(array('status' => 'error', 'message' => 'ID tidak valid'));
		}
	}

	function sendNotRefferenceNotification($recipientEmail, $fullName, $reason)
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
				. "Berdasarkan hasil evaluasi tes, kami sampaikan bahwa saat ini Anda belum memenuhi\n\n"
				. "Alasan: $reason\n\n"
				. "kriteria untuk melanjutkan ke tahapan berikutnya. Namun demikian, kami melihat potensi\n\n"
				. "dalam diri Anda dan telah memasukkan CV Anda ke dalam Talent Pool kami untuk pertimbangan di masa mendatang.\n\n"
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
							Terima kasih atas minat dan partisipasi Anda dalam proses rekrutmen di <strong>PT Andhika Lines</strong>.
						</p>

						<p style='font-size: 14px; color: #333; line-height: 1.6;'>
							 Kami sampaikan bahwa saat ini kami belum dapat melanjutkan proses Anda ke tahap berikutnya.
						</p>
						
						<p style='font-size: 14px; color: #333; line-height: 1.6;'>
							Berikut feedback dari Kami:
						</p>
						
						<div style='background:#fff5f5; padding:15px; border-left:3px solid #cc0000; margin:20px 0; font-size:13px; color:#cc0000;'>
							".$reason."
						</div>
						
						<p style='font-size: 14px; color: #333; line-height: 1.6;'>
							Namun demikian, kami melihat potensi 
							dalam diri Anda dan telah memasukkan CV Anda ke dalam Talent Pool kami untuk 
							pertimbangan di masa mendatang. 
						</p>

						<p style='font-size: 14px; color: #333; line-height: 1.6;'>
							Kami doakan yang terbaik untuk karir Anda di manapun Anda berada.
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