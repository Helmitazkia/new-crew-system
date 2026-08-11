<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PipelineApplicant extends CI_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('MCrewscv');
        $this->load->library('../controllers/DataContext');
        $this->load->library('session');
    }

	function indexPipelineApplicant()
    {
        $data = array(
            'title' => 'Pipeline Applicant',
            'active_menu' => 'pipeline_applicant',
			'active_submenu' => 'pipeline_applicant',
            'content' => 'Recruitment/PipelineApplicant/pipelineApplicantView',
        );

        $this->load->view('menu/RecruitmentMenu/main_PipelineApplicant', $data);
    }

    function searchDataPipeline()
    {
        $this->getDataPipelineCrew(
            $this->input->get('search'),
            $this->input->get('page'),
            $this->input->get('gender'),
            $this->input->get('status'),
            $this->input->get('position'),
            $this->input->get('vessel'),
            $this->input->get('foreign'),
            $this->input->get('rank'),
            $this->input->get('handphone')
        );
    }
    
    function getDataPipelineCrew(
        $search = "",
        $page = 1,
        $gender = "",
        $status = "",
        $position = "",
        $vessel = "",
        $foreign = "",
        $rank = "",
        $phone = ""
    ){
        header("X-Robots-Tag: noindex, nofollow, noarchive, nosnippet", true);
        header("Content-Type: application/json");

        $dataContext = new DataContext();

        $page  = isset($_GET['page']) ? intval($_GET['page']) : 1;
        
        $limit = $this->input->get('rows');

        $allowedRows = array(10,20,50,100);

        $filters = json_decode(
            $this->input->get('filters'),
            true
        );

        $columnMap = array(
            1  => 'st_data',
            2  => 'position_applied',
            3  => 'born_place',
            4  => 'handphone',
            5  => 'vessel_type',
            6  => 'pengalaman_jeniskapal',
            7  => 'berlayardengancrewasing',
            8  => 'last_salary',
            9  => 'expected_salary',
            10 => 'join_inAndhika',
            11 => 'submit_cv'
        );

        $excelFilterWhere = "";

        if(!empty($filters))
        {
            foreach($filters as $col=>$values)
            {
                if(empty($values)){
                    continue;
                }

                if(!isset($columnMap[$col])){
                    continue;
                }

                if($col == 1)
                {
                    $statusWhere = array();

                    foreach($values as $v)
                    {
                        switch($v)
                        {
                            case '⭐ Favorite Candidate':
                                $statusWhere[] = "(favorite_candidate = 1)";
                                break;

                            case 'No Position':
                                $statusWhere[] = "(st_data=2)";
                                break;

                            case 'No Qualified Certificate':
                                $statusWhere[] = "
                                    (
                                        st_data=3
                                        AND (
                                            reason_not_qualified IS NULL
                                            OR reason_not_qualified=''
                                        )
                                    )
                                ";
                                break;

                            case 'No Qualified Experience':
                                $statusWhere[] = "
                                    (
                                        st_data=3
                                        AND reason_not_qualified!=''
                                    )
                                ";
                                break;

                            case 'No Qualified Interview':
                                $statusWhere[] = "(st_data=4)";
                                break;

                            case 'Withdraw MCU':
                                $statusWhere[] = "(st_data=7)";
                                break;
                        }
                    }

                    if(!empty($statusWhere))
                    {
                        $excelFilterWhere .= "
                            AND (
                                ".implode(" OR ", $statusWhere)."
                            )
                        ";
                    }

                    continue;
                }

                $field = $columnMap[$col];

                if($field == 'pengalaman_jeniskapal')
                {
                    $expWhere = array();

                    foreach($values as $v)
                    {
                        $v = addslashes($v);

                        $expWhere[] = "
                            pengalaman_jeniskapal LIKE '%$v%'
                        ";
                    }

                    $excelFilterWhere .= "
                        AND (
                            ".implode(" OR ", $expWhere)."
                        )
                    ";

                    continue;
                }

                if($field == 'berlayardengancrewasing')
                {
                    $foreignWhere = array();

                    foreach($values as $v)
                    {
                        if($v == 'Y')
                        {
                            $foreignWhere[] = "
                                (
                                    UPPER(berlayardengancrewasing) = 'Y'
                                    OR UPPER(berlayardengancrewasing) LIKE 'YES%'
                                    OR UPPER(berlayardengancrewasing) LIKE 'Y %'
                                )
                            ";
                        }
                        else
                        {
                            $foreignWhere[] = "
                                (
                                    UPPER(berlayardengancrewasing) = 'N'
                                    OR UPPER(berlayardengancrewasing) LIKE 'NO%'
                                    OR UPPER(berlayardengancrewasing) LIKE 'N %'
                                )
                            ";
                        }
                    }

                    $excelFilterWhere .= "
                        AND (
                            ".implode(" OR ", $foreignWhere)."
                        )
                    ";

                    continue;
                }

                if($field == 'submit_cv')
                {
                    $submitWhere = array();

                    foreach($values as $v)
                    {
                        if($v == 'No Date')
                        {
                            $submitWhere[] = "
                            (
                                submit_cv IS NULL
                                OR submit_cv=''
                                OR submit_cv='0000-00-00'
                                OR submit_cv='0000-00-00 00:00:00'
                            )";
                        }
                        elseif(preg_match('/^\d{4}$/',$v))
                        {
                            $submitWhere[] = "
                            YEAR(submit_cv)='$v'
                            ";
                        }
                        elseif(preg_match('/^\d{4}-\d{2}-\d{2}$/',$v))
                        {
                            $submitWhere[] = "
                            DATE(submit_cv)='$v'
                            ";
                        }
                    }

                    $excelFilterWhere .= "
                        AND (
                            ".implode(" OR ", $submitWhere)."
                        )
                    ";

                    continue;
                }

                $safeValues = array();

                foreach($values as $v)
                {
                    $safeValues[] = "'" . addslashes($v) . "'";
                }

                $excelFilterWhere .= "
                    AND $field IN (
                        ".implode(",", $safeValues)."
                    )
                ";
            }
        }

        if(!in_array((int)$limit,$allowedRows)){
            $limit = 10;
        }
        $offset = ($page-1) * $limit;

        $rank = $this->input->get('rank');

        $genderFilter = "";
        if (!empty($gender)) {
            $genderFilter = " AND gender='$gender'";
        }

        $search = trim($search);
        $searchLower = strtolower($search);

        $filterStData = " AND st_data IN (2,3,4,7) ";
        $statusFilter = "";
        $searchCondition = "";

        $isTextSearch = !empty($search)
            && !in_array($searchLower, array(
                'not position','no position','position',
                'not qualified certificate','certificate',
                'not qualified experience','experience'
            ))
            && strpos($searchLower,'interview') === false
            && strpos($searchLower,'not qualified') === false
            && strpos($searchLower,'withdraw') === false;

        if (in_array($searchLower,array('not position','no position','position'))){
            $statusFilter=" AND st_data=2";
        }
        elseif(in_array($searchLower,array('not qualified certificate','certificate'))){
            $statusFilter=" AND (st_data=3 AND (reason_not_qualified IS NULL OR reason_not_qualified=''))";
        }
        elseif(in_array($searchLower,array('not qualified experience','experience'))){
            $statusFilter=" AND (st_data=3 AND reason_not_qualified!='')";
        }
        elseif(strpos($searchLower,'interview')!==false){
            $statusFilter=" AND st_data=4";
        }
        elseif(strpos($searchLower,'not qualified')!==false){
            $statusFilter=" AND (
                (st_data=3 AND (reason_not_qualified IS NULL OR reason_not_qualified=''))
                OR (st_data=3 AND reason_not_qualified!='')
                OR st_data=4
            )";
        }
        elseif(strpos($searchLower,'withdraw')!==false){
            $statusFilter=" AND st_data=7";
        }
        else{
            $searchCondition=" AND (
                position_applied LIKE '%$search%'
                OR fullname LIKE '%$search%'
                OR email LIKE '%$search%'
                OR pengalaman_jeniskapal LIKE '%$search%'
                OR handphone LIKE '%search%'
            )";
        }

        $whereExtra="";

        if(!empty($status)){
            if($status=='3_cert'){
                $whereExtra.=" AND st_data=3 AND (reason_not_qualified IS NULL OR reason_not_qualified='')";
            }
            elseif($status=='3_exp'){
                $whereExtra.=" AND st_data=3 AND reason_not_qualified!=''";
            }
            else{
                $whereExtra.=" AND st_data='$status'";
            }
        }

        if(!empty($position)){
            $whereExtra.=" AND position_applied='$position'";
        }

        if(!empty($vessel)){
            $whereExtra.=" AND pengalaman_jeniskapal LIKE '%$vessel%'";
        }

        if(!empty($foreign)){
            $whereExtra.=" AND berlayardengancrewasing='$foreign'";
        }

        if(!empty($rank)){
            $whereExtra.=" AND position_applied='$rank'";
        }

        $whereClause="
        WHERE deletests='0'
        $filterStData
        $genderFilter
        $statusFilter
        $searchCondition
        $whereExtra
        $excelFilterWhere
        ";

        $sqlTotal="SELECT COUNT(*) total FROM new_applicant $whereClause";
        $resultTotal=$this->MCrewscv->getDataQuery($sqlTotal);

        $totalRows = $resultTotal ? $resultTotal[0]->total : 0;
        $totalPages = ceil($totalRows/$limit);

        if($isTextSearch){
            $orderBy="
            ORDER BY 
            CASE 
                WHEN position_applied LIKE '%$search%' THEN 1
                WHEN fullname LIKE '%$search%' THEN 2
                WHEN pengalaman_jeniskapal LIKE '%$search%' THEN 3
                ELSE 4
            END,
            submit_cv DESC";
            
        }else{
            
            $orderBy="
            ORDER BY 
            favorite_candidate DESC,
            CASE 
                WHEN st_data=2 THEN 1
                WHEN st_data=3 AND (reason_not_qualified IS NULL OR reason_not_qualified='') THEN 2
                WHEN st_data=3 AND reason_not_qualified!='' THEN 3
                WHEN st_data=4 THEN 4
                ELSE 5
            END,
            submit_cv DESC";
        }

        $sql="SELECT * FROM new_applicant
            $whereClause
            $orderBy
            LIMIT $limit OFFSET $offset";

        $rows=$this->MCrewscv->getDataQuery($sql);

        $data=array();

        foreach($rows as $val){

            $statusText="Unknown";
            $labelClass="badge-light";

            if($val->st_data==2){
                $statusText="No Position";
                $labelClass="badge-secondary";
            }
            elseif($val->st_data==3 && empty($val->reason_not_qualified)){
                $statusText="Not Qualified (Certificate)";
                $labelClass="badge-danger";
            }
            elseif($val->st_data==3 && !empty($val->reason_not_qualified)){
                $statusText="Not Qualified (Experience)";
                $labelClass="badge-danger";
            }
            elseif($val->st_data==4){
                $reffType = empty($val->notReff_reason) ? "No Reason" : "With Reason";
                $statusText="Not Qualified Interview ($reffType)";
                $labelClass="badge-success";
            }
            elseif($val->st_data==7){
                $statusText="Withdraw Medical Check Up";
                $labelClass="badge-primary";
            }

            $cv_file = $val->new_cv;

            $data[]=array(
                "id"=>$val->id,
                "email"=>$val->email,
                "fullname"=>$val->fullname,
                "favorite_candidate" => (int)$val->favorite_candidate,
                "status"=>$statusText,
                "label"=>$labelClass,
                "born_place"=>$val->born_place,
                "born_date"=>$dataContext->convertReturnName($val->born_date),
                "handphone"=>$val->handphone,
                "vessel_type"=>$val->vessel_type,
                "position"=>$val->position_applied,
                "education"=>$val->ijazah_terakhir,
                "last_experience"=>$val->last_experience,
                "vessel"=>$val->pengalaman_jeniskapal,
                "foreign"=>$val->berlayardengancrewasing,
                'last_salary' => $val->last_salary,
                'last_salary_currency' => $val->last_salary_currency,
                'expected_salary' => $val->expected_salary,
                'expected_salary_currency' => $val->expected_salary_currency,
                "join"=>$val->join_inAndhika,
                "submit"=>$dataContext->convertReturnNameWithTime($val->submit_cv),
                "st_data"=>$val->st_data,
                "reason1"=>$val->reason_not_qualified_layer1,
                "reason2"=>$val->reason_not_qualified,
                "missing_certificates"=>isset($val->missing_certificates) ? $val->missing_certificates : null,
                "notReff_reason"=>$val->notReff_reason,
                "cv_url"=> base_url('assets/uploads/CV_NewApplicant/'.$cv_file)
            );
        }

        echo json_encode(array(
            "data"=>$data,
            "pagination"=>array(
                "page"=>$page,
                "total_pages"=>$totalPages,
                "total_rows"=>$totalRows,
                "rows_per_page"=>$limit
            )
        ));
    }

    function getPipelineFilterOptions()
    {
        header("Content-Type: application/json");

        $field = $this->input->get('field');

        if($field == 'pengalaman_jeniskapal')
        {
            $sql = "
                SELECT pengalaman_jeniskapal
                FROM new_applicant
                WHERE deletests='0'
                AND pengalaman_jeniskapal IS NOT NULL
                AND TRIM(pengalaman_jeniskapal) != ''
            ";

            $rows = $this->MCrewscv->getDataQuery($sql);

            $result = array();

            foreach($rows as $row)
            {
                $vessels = $this->extractMasterVessel(
                    $row->pengalaman_jeniskapal
                );

                foreach($vessels as $vessel)
                {
                    $result[] = $vessel;
                }
            }

            $result = array_unique($result);

            natcasesort($result);

            echo json_encode(array_values($result));
            return;
        }

        if($field == 'berlayardengancrewasing')
        {
            $sql = "
                SELECT berlayardengancrewasing
                FROM new_applicant
                WHERE deletests='0'
                AND berlayardengancrewasing IS NOT NULL
                AND TRIM(berlayardengancrewasing) != ''
            ";

            $rows = $this->MCrewscv->getDataQuery($sql);

            $result = array();

            foreach($rows as $row)
            {
                $result[] = $this->normalizeForeignCrew(
                    $row->berlayardengancrewasing
                );
            }

            $result = array_unique($result);

            sort($result);

            echo json_encode(array_values($result));
            return;
        }

        if($field == 'submit_cv')
        {
            $sql = "
                SELECT submit_cv
                FROM new_applicant
                WHERE deletests='0'
            ";

            $rows = $this->MCrewscv->getDataQuery($sql);

            $result = array();

            foreach($rows as $row)
            {
                $submit = trim($row->submit_cv);

                if(
                    empty($submit) ||
                    $submit == '0000-00-00 00:00:00'
                ){
                    if(!isset($result['No Date'])){
                        $result['No Date'] = array(
                            'count' => 0
                        );
                    }

                    $result['No Date']['count']++;
                    continue;
                }

                $year  = date('Y', strtotime($submit));
                $month = date('M', strtotime($submit));
                $date  = date('Y-m-d', strtotime($submit));

                if(!isset($result[$year]))
                {
                    $result[$year] = array(
                        'count'  => 0,
                        'months' => array()
                    );
                }

                $result[$year]['count']++;

                if(!isset($result[$year]['months'][$month]))
                {
                    $result[$year]['months'][$month] = array(
                        'count' => 0,
                        'dates' => array()
                    );
                }

                $result[$year]['months'][$month]['count']++;

                if(!isset(
                    $result[$year]['months'][$month]['dates'][$date]
                )){
                    $result[$year]['months'][$month]['dates'][$date] = 0;
                }

                $result[$year]['months'][$month]['dates'][$date]++;
            }

            krsort($result);

            echo json_encode($result);
            return;
        }  

        $allowed = array(
            'st_data',
            'st_qualify',
            'st_qualify2',
            'gender',
            'born_place',
            'born_date',
            'handphone',
            'recruitment_id',
            'vessel_type',
            'position_applied',
            'position_existing',
            'ijazah_terakhir',
            'last_experience',
            'ipk_terakhir',
            'sekolah',
            'jurusan',
            'pengalaman_jeniskapal',
            'berlayardengancrewasing',
            'last_salary',
            'last_salary_currency',
            'expected_salary',
            'expected_salary_currency',
            'join_inAndhika',
            'join_date',
            'info_source',
            'notReff_reason',
            'reason_not_qualified_layer1',
            'reason_not_qualified',
            'alasan_gabung',
            'submit_cv',
            'favorite_candidate'
        );

        if(!in_array($field,$allowed)){
            echo json_encode(array());
            return;
        }

        $sql = "
            SELECT DISTINCT $field val
            FROM new_applicant
            WHERE deletests='0'
            AND $field IS NOT NULL
            AND TRIM($field) != ''
            ORDER BY $field
        ";

        $rows = $this->MCrewscv->getDataQuery($sql);

        $result = array();

        foreach($rows as $row){
            $result[] = trim($row->val);
        }

        echo json_encode($result);
    }
    
    function extractMasterVessel($experience)
    {
        $masterVessel = array(
            'BULK CARRIER',
            'CARGO',
            'GENERAL CARGO',
            'CONTAINER',
            'TANKER PRODUCT',
            'TANKER OIL',
            'CRUDE OIL',
            'TANKER CHEMICAL',
            'TANKER GAS',
            'FLOATING CRANE',
            'TUG BOAT',
            'SUPPLY VESSEL',
            'CREW BOAT',
            'RORO/PASSENGER'
        );

        $result = array();

        $experience = strtoupper($experience);

        foreach($masterVessel as $vessel)
        {
            if(stripos($experience, $vessel) !== false)
            {
                $result[] = $vessel;
            }
        }

        return array_unique($result);
    }

    function normalizeForeignCrew($value)
    {
        $value = strtoupper(trim($value));

        if(
            $value == 'Y' ||
            strpos($value,'YES') !== false ||
            strpos($value,'Y ') === 0
        ){
            return 'Y';
        }

        return 'N';
    }

    function setQualifiedCrewPipeline()
	{
		$id = $this->input->post('id');
		$positionExisting = $this->input->post('position_existing'); 
		$pengalamanJenisKapal = $this->input->post('pengalaman_jeniskapal'); 

		if (empty($id)) {
			echo json_encode(array('status' => 'error', 'message' => 'ID tidak valid'));
			return;
		}

		$sql = "SELECT * FROM new_applicant WHERE id = '".$id."' AND deletests = '0'";
		$result = $this->MCrewscv->getDataQuery($sql);

		if (empty($result)) {
			echo json_encode(array('status' => 'error', 'message' => 'Data tidak ditemukan'));
			return;
		}

		$fullNameUser = $this->session->userdata('fullNameCrewSystem');
		$fullNameUser = str_replace("'", "''", $fullNameUser);
		$date = date('Y-m-d H:i:s');

		$pengalamanJenisKapal = str_replace("'", "''", $pengalamanJenisKapal);

		$data = array(
			'st_data' => 0,
			'st_qualify' => 'Y',
			'st_qualify2' => 'N',
			'position_existing' => $positionExisting,
			'pengalaman_jeniskapal' => $pengalamanJenisKapal,
			'adduserdate_stQualifyPipeline' => $fullNameUser . "#" . $date,
		);

		$where = array('id' => $id);
        
        $candidateEmail = $result[0]->email;
        $candidateName  = $result[0]->fullname;

        $this->sendPositionAvailableNotification(
            $candidateEmail,
            $candidateName
        );
		$this->MCrewscv->updateData($where, $data, 'new_applicant');

		if ($this->db->affected_rows() >= 0) {
			echo json_encode(array('status' => 'success', 'message' => 'Crew has been qualified successfully.'));
		} else {
			echo json_encode(array('status' => 'error', 'message' => 'Gagal memperbarui data.'));
		}
	}

    function sendPositionAvailableNotification($recipientEmail, $fullName)
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

            // Email kandidat
            $mail->addAddress($recipientEmail);

            // BCC ke tim crewing
            $mail->addBCC('andhika.crewing@gmail.com', 'Andhika Crewing');

            $mail->AddEmbeddedImage(
                APPPATH . '../assets/img/logo_andhika.png',
                'logo_andhika'
            );

            $mail->isHTML(true);

            $mail->Subject = 'Update on Your Application - PT Andhika Lines';

            $mail->Body = "
            <div style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px;'>

                <div style='max-width: 600px; margin: auto; background-color: #ffffff;
                            border-radius: 8px; overflow: hidden;
                            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                            border: 1px solid #e0e0e0;'>

                    <div style='padding: 20px; text-align: center;'>
                        <img src='cid:logo_andhika' alt='PT Andhika Lines' style='max-width:180px;'>
                    </div>

                    <div style='padding:30px; color:#333; font-size:14px; line-height:1.7;'>

                        <p>Yth. <strong>{$fullName}</strong>,</p>

                        <p>
                            Terima kasih atas minat Anda untuk bergabung dengan
                            <strong>PT Andhika Lines</strong>.
                        </p>

                        <p>
                            Kami telah melakukan peninjauan kembali terhadap profil,
                            pengalaman, serta sertifikat yang Anda miliki.
                        </p>

                        <p>
                            Dengan senang hati kami informasikan bahwa saat ini terdapat
                            peluang yang sesuai dengan kualifikasi Anda dan profil Anda
                            telah masuk ke dalam proses rekrutmen kami untuk
                            dipertimbangkan lebih lanjut.
                        </p>

                        <p>
                            Tim Crewing kami akan menghubungi Anda apabila diperlukan
                            informasi tambahan atau untuk tahapan proses berikutnya.
                        </p>

                        <p>
                            Terima kasih atas ketertarikan Anda untuk menjadi bagian
                            dari PT Andhika Lines.
                        </p>

                        <br>

                        <p>
                            Hormat kami,<br>
                            <strong>Tim Crewing</strong><br>
                            PT Andhika Lines
                        </p>

                    </div>

                    <hr style='border:none; border-top:1px solid #ddd;'>

                    <div style='background-color:#f9f9f9; padding:20px; font-size:13px; color:#555;'>

                        <p style='margin-bottom:8px; font-weight:bold;'>
                            Ikuti kami untuk informasi terbaru:
                        </p>

                        <ul style='list-style:none; padding-left:0; margin:0;'>

                            <li style='margin-bottom:6px;'>
                                <img src='https://cdn-icons-png.flaticon.com/24/1384/1384031.png'
                                    style='vertical-align:middle; margin-right:8px;'>

                                <a href='https://www.instagram.com/andhika.group/'
                                style='text-decoration:none; color:#003366;'>
                                    @andhika.group
                                </a>
                            </li>

                            <li style='margin-bottom:6px;'>
                                <img src='https://cdn-icons-png.flaticon.com/24/1384/1384031.png'
                                    style='vertical-align:middle; margin-right:8px;'>

                                <a href='https://www.instagram.com/lifeatandhika/'
                                style='text-decoration:none; color:#003366;'>
                                    @lifeatandhika
                                </a>
                            </li>

                            <li>
                                <img src='https://cdn-icons-png.flaticon.com/24/841/841364.png'
                                    style='vertical-align:middle; margin-right:8px;'>

                                <a href='https://andhika.com/'
                                style='text-decoration:none; color:#003366;'>
                                    www.andhika.com
                                </a>
                            </li>

                        </ul>

                        <p style='margin-top:20px; font-size:12px; color:#888; text-align:center;'>
                            <em>Email ini dikirim otomatis oleh sistem Crewing PT Andhika Lines.
                            Mohon tidak membalas email ini.</em>
                        </p>

                    </div>

                </div>

            </div>
            ";

            if (!$mail->send()) {

                log_message(
                    'error',
                    'Position Available Email failed to ' .
                    $recipientEmail . ' : ' . $mail->ErrorInfo
                );

            } else {

                log_message(
                    'info',
                    'Position Available Email sent to ' .
                    $recipientEmail
                );

            }

        } catch (Exception $e) {

            log_message(
                'error',
                'Position Available Email Exception : ' .
                $e->getMessage()
            );

        }
    }
}