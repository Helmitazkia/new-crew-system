<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Familiarization extends CI_Controller {

    private $top4Ranks = array('MASTER', 'C/O', 'C/E', '2/E');

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MCrewscv');
        $this->load->library('../controllers/DataContext');
        $this->load->library('session');

        if (!$this->session->userdata('isLogin')) {
            redirect('auth/login');
            exit;
        }
    }

    public function view()
    {
        $this->load->view('ListReport/Familiarization/view_familiar');
    }

	function getStatementCrew()
	{
		$idperson = $this->input->post('idperson');

		if ($idperson == "") {
			echo json_encode(array('success' => false, 'status' => false, 'message' => 'Id Person Kosong!'));
			return;
		}

		$sql = "
			SELECT 
				p.idperson,
				TRIM(CONCAT(p.fname, ' ', p.mname, ' ', p.lname)) AS fullname,
				DATE_FORMAT(p.dob, '%d-%m-%Y') AS date_of_birth,
				r.nmrank AS rankname,
				v.nmvsl AS vesselnm,
                c.signondt AS signondt,
                DATE_FORMAT(c.signondt, '%d-%m-%Y') AS signon_date,
				(
					SELECT MAX(c2.docno)
					FROM tblcertdoc c2
					WHERE c2.idperson = p.idperson
					AND c2.deletests = 0
					AND c2.certname LIKE '%PASSPORT%'
				) AS passport_no
			FROM mstpersonal p
			LEFT JOIN tblcontract c 
				ON c.idperson = p.idperson
				AND c.deletests = 'N'
				AND c.signondt = (
					SELECT MAX(signondt)
					FROM tblcontract
					WHERE idperson = p.idperson
					AND deletests = 'N'
				)
			LEFT JOIN mstvessel v ON v.kdvsl = c.signonvsl
			LEFT JOIN mstrank r ON r.kdrank = c.signonrank
			WHERE p.idperson = '$idperson'
			LIMIT 1
		";

		$result = $this->MCrewscv->getDataQuery($sql);
		$data   = (!empty($result)) ? $result[0] : null;

		$response = array(
			'success' => $data ? true : false,
			'status'  => $data ? true : false,
			'data'    => $data,
			'message' => $data ? "OK" : "Data tidak ditemukan",
			'today'   => date('d F Y')
		);

		echo json_encode($response);
	}

    public function get_history()
	{
		$idperson = $this->input->post('idperson', true);

		$this->db->select('*');
		$this->db->from('history_familiarization');

		if (!empty($idperson)) {
			$this->db->where('idperson', $idperson);
		}

		$this->db->order_by('id', 'DESC');
		$data = $this->db->get()->result();

		$result = array();
		foreach ($data as $row) {
			$row->date_created_fmt = !empty($row->date_created)
				? date('d M Y H:i', strtotime($row->date_created))
				: '-';
			$result[] = $row;
		}

		echo json_encode(array(
			'success' => true,
			'data'    => $result
		));
	}

	public function save_history()
	{
		// Helper: convert radio value (0/1) or NULL if not sent
		// $self menggantikan $this agar bisa diakses di dalam closure (anonymous function)
		$self = $this;
		$getItem = function($field) use ($self) {
			$val = $self->input->post($field);
			return ($val !== false && $val !== null && $val !== '') ? (int)$val : null;
		};

		$data = array(
			'idperson'     => $this->input->post('idperson', true),
			'nama_crew'    => $this->input->post('nama_crew', true),
			'rank'         => $this->input->post('rank', true),
			'vessel'       => $this->input->post('vessel', true),
			'signon_date'  => date('Y-m-d', strtotime($this->input->post('signon_date', true))),
			'note'         => $this->input->post('note', true),
			'date_created' => date('Y-m-d H:i:s'),
			// Familiarization checklist items (1 = ✓, 0 = ✗, NULL = not answered)
			'item_1'       => $getItem('item_1'),
			'item_2'       => $getItem('item_2'),
			'item_3'       => $getItem('item_3'),
			'item_4'       => $getItem('item_4'),
			'item_5'       => $getItem('item_5'),
			'item_6'       => $getItem('item_6'),
			'item_7'       => $getItem('item_7'),
			'item_8'       => $getItem('item_8'),
			'item_9'       => $getItem('item_9'),
			'item_10'      => $getItem('item_10'),
			'item_11'      => $getItem('item_11'),
			'item_12'      => $getItem('item_12'),
			'item_13'      => $getItem('item_13'),
			'item_14'      => $getItem('item_14'),
			'item_15'      => $getItem('item_15'),
			'item_16'      => $getItem('item_16'),
		);

		$insert = $this->db->insert('history_familiarization', $data);
		$insert_id = $this->db->insert_id();

		if ($insert) {
			echo json_encode(array('success' => true, 'message' => 'History berhasil disimpan', 'id' => $insert_id));
		} else {
			echo json_encode(array('success' => false, 'message' => 'Gagal menyimpan history'));
		}
	}

	public function delete_history()
	{
		$id = $this->input->post('id', true);
		if (empty($id)) {
			echo json_encode(array('success' => false, 'message' => 'ID tidak valid'));
			return;
		}

		$this->db->where('id', $id);
		$delete = $this->db->delete('history_familiarization');

		if ($delete) {
			echo json_encode(array('success' => true, 'message' => 'Data berhasil dihapus'));
		} else {
			echo json_encode(array('success' => false, 'message' => 'Gagal menghapus data'));
		}
	}

    private function isTop4Rank($rankStr)
    {
        $rank = strtoupper(trim($rankStr));
        foreach ($this->top4Ranks as $t4) {
            if ($rank === $t4 || strpos($rank, $t4) !== false) {
                return true;
            }
        }
        return false;
    }

    function familiarization_pdf()
	{
		$id = $this->input->post('id_history');
		if (!$id) {
			$id = $this->uri->segment(4); // segment 4 for ListReport/Familiarization/familiarization_pdf/ID
		}
		
		if (!$id) {
			echo "ID History tidak dikirim.";
			return;
		}

		$this->db->where('id', $id);
		$history = $this->db->get('history_familiarization')->row();

		if (empty($history)) {
			echo "Data History tidak ditemukan.";
			return;
		}
        
        $idPerson = $history->idperson;

        // Define batch_id fallback for signature and audit fetching
        $batch_id = !empty($history->batch_id) ? $history->batch_id : $id;

        // Get signature_checkedBy from fam_public_links
        $link = $this->db->where('batch_id', $batch_id)->limit(1)->get('fam_public_links')->row();
        $signature_checkedBy = $link ? $link->created_by : '';

        // Get signature_DPA from fam_checklist_audit
        $auditDpa = $this->db->where('batch_id', $batch_id)
                             ->where('department', 'DPA')
                             ->limit(1)
                             ->get('fam_checklist_audit')->row();
        $signature_DPA = $auditDpa ? $auditDpa->filled_by_name : '';

        // Get representatives for all departments for Page 2
        $reps = array();
        $allAudits = $this->db->where('batch_id', $batch_id)->get('fam_checklist_audit')->result();
        foreach ($allAudits as $au) {
            if (!isset($reps[$au->department])) {
                $reps[$au->department] = $au->filled_by_name;
            }
        }

        // Get time_start and time_end from fam_public_links
        $times = array();
        $publicLinks = $this->db->where('batch_id', $batch_id)->get('fam_public_links')->result();
        foreach ($publicLinks as $pl) {
            if (!empty($pl->time_start) && !empty($pl->time_end)) {
                $times[$pl->department] = array(
                    'start' => date('H:i', strtotime($pl->time_start)),
                    'end'   => date('H:i', strtotime($pl->time_end))
                );
            }
        }

        // --- calculation of dob, years in rank, and license ---
        $sql = "
            SELECT DATE_FORMAT(dob, '%d-%m-%Y') AS date_of_birth
            FROM mstpersonal
            WHERE idperson = ?
            LIMIT 1
        ";
        $p = $this->db->query($sql, array($idPerson))->row();
        $dob = $p ? $p->date_of_birth : '';

        // calculate Years in Rank
        $sqlContract = "
            SELECT A.signondt, A.signoffdt, C.nmrank
            FROM tblcontract A
            JOIN mstrank C ON C.kdrank = A.signonrank
            WHERE A.idperson = ? AND A.deletests = '0'
        ";
        $contracts = $this->db->query($sqlContract, array($idPerson))->result();
        $yearsInRank = 0;
        foreach ($contracts as $c) {
            if ($this->isTop4Rank($c->nmrank)) {
                if (!empty($c->signondt) && !empty($c->signoffdt) && $c->signoffdt != '0000-00-00' && $c->signondt != '0000-00-00') {
                    $diff = strtotime($c->signoffdt) - strtotime($c->signondt);
                    if ($diff > 0) {
                        $yearsInRank += $diff / (365 * 24 * 60 * 60);
                    }
                }
            }
        }
        $yearsInRankFormatted = '';
        if ($yearsInRank > 0) {
            $years = floor($yearsInRank);
            $months = round(($yearsInRank - $years) * 12);
            if ($months == 12) {
                $years += 1;
                $months = 0;
            }
            $parts = array();
            if ($years > 0) {
                $parts[] = $years . ' Year' . ($years > 1 ? 's' : '');
            }
            if ($months > 0) {
                $parts[] = $months . ' Month' . ($months > 1 ? 's' : '');
            }
            $yearsInRankFormatted = !empty($parts) ? implode(' ', $parts) : '';
        }

        // calculate License
        $license = '';
        $rankUpper = strtoupper(trim($history->rank));
        $isTop4 = $this->isTop4Rank($history->rank);
        
        if ($isTop4) {
            $licensePrefix = '';
            if ($rankUpper === 'MASTER' || $rankUpper === 'C/O' || strpos($rankUpper, 'MASTER') !== false || strpos($rankUpper, 'C/O') !== false) {
                $licensePrefix = 'ANT';
            } elseif ($rankUpper === 'C/E' || $rankUpper === '2/E' || strpos($rankUpper, 'C/E') !== false || strpos($rankUpper, '2/E') !== false) {
                $licensePrefix = 'ATT';
            }
            
            if ($licensePrefix !== '') {
                $sqlCert = "
                    SELECT certname, dispname 
                    FROM tblcertdoc
                    WHERE idperson = ? AND deletests = '0'
                ";
                $certs = $this->db->query($sqlCert, array($idPerson))->result();
                foreach ($certs as $c) {
                    $cname = strtoupper($c->certname . ' ' . $c->dispname);
                    if (strpos($cname, $licensePrefix) !== false) {
                        preg_match('/(' . $licensePrefix . '\s*(?:[IVX]+|[1-5]+))/', $cname, $matches);
                        if (!empty($matches[1])) {
                            $license = $matches[1];
                            break;
                        } else {
                            $license = $licensePrefix;
                        }
                    }
                }
            }
        }

        $crew = (object) array(
            'fullname'      => $history->nama_crew,
            'date_of_birth' => $dob,
            'rankname'      => $history->rank,
            'vesselnm'      => $history->vessel,
            'signon_date'   => !empty($history->signon_date) ? date('d-m-Y', strtotime($history->signon_date)) : '',
            'is_top4'       => $isTop4,
            'qr_crew'       => isset($history->qr_crew) ? $history->qr_crew : '',
            'qr_checkedby'  => isset($history->qr_checkedby) ? $history->qr_checkedby : '',
            'qr_dpa'        => isset($history->qr_dpa) ? $history->qr_dpa : '',
            'qr_dept_technical'    => isset($history->qr_dept_technical) ? $history->qr_dept_technical : '',
            'qr_dept_marinesafety' => isset($history->qr_dept_marinesafety) ? $history->qr_dept_marinesafety : '',
            'qr_dept_finance'      => isset($history->qr_dept_finance) ? $history->qr_dept_finance : '',
            'qr_dept_purchasing'   => isset($history->qr_dept_purchasing) ? $history->qr_dept_purchasing : '',
            'qr_dept_qhse'         => isset($history->qr_dept_qhse) ? $history->qr_dept_qhse : '',
            'qr_dept_operation'    => isset($history->qr_dept_operation) ? $history->qr_dept_operation : '',
            'qr_dept_crewing'      => isset($history->qr_dept_crewing) ? $history->qr_dept_crewing : '',
            'signature_checkedBy'  => $signature_checkedBy,
            'signature_DPA'        => $signature_DPA,
            'license'              => $license,
            'years_in_rank'        => $yearsInRankFormatted
        );

		$dataOut['crew']    = $crew;
		$dataOut['history'] = $history;
		$dataOut['today']   = date('d F Y');
        $dataOut['reps']    = $reps;
        $dataOut['times']   = $times;

		require(APPPATH . "views/frontend/pdf/mpdf60/mpdf.php");
		$mpdf = new mPDF('utf-8', 'A4');

		ob_start();
		$this->load->view("ListReport/Familiarization/form_familiar_pdf", $dataOut);
		$html = ob_get_contents();
		ob_end_clean();

		$mpdf->WriteHTML(utf8_encode($html));
		$mpdf->Output("Familiarization_{$crew->fullname}.pdf", "I");
		exit;
	}
}
