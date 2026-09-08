<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ListContract extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}

	public function view()
	{
		$data['title'] = 'List Contract';
		$data['active_menu'] = 'list_contract';
		$this->load->view('layout/header', $data);
		$this->load->view('Report/ListContract/view_listcontract');
		$this->load->view('layout/footer');
	}

	
	public function getListContract()
	{
		$this->output->set_content_type('application/json');

		$where = "
            WHERE A.deletests = '0'
            AND (A.fname != '' OR A.mname != '' OR A.lname != '')
            AND (A.inAktif = '0' OR A.inAktif IS NULL)
            AND (A.inBlacklist = '0' OR A.inBlacklist IS NULL)
        ";

		$sql = "
			SELECT 
					A.idperson,
					b.nmcmp,
					d.nmrank AS applyfor,
					IFNULL(d.urutan, 9999) AS rank_urutan,
					CONCAT_WS(' ', A.fname, A.mname, A.lname) AS fullname,
					first_contract.first_signondt AS signondt,
					C.signoffdt,
					A.religion,
					A.gender,
					(
							SELECT COUNT(*)
							FROM tblcontract tc
							WHERE tc.idperson = A.idperson
								AND tc.deletests = 0
								AND tc.signondt != '0000-00-00'
								AND tc.signondt IS NOT NULL
					) AS total_contract

			FROM mstpersonal A
			INNER JOIN (
				SELECT t.idperson, t.kdcmprec, t.signondt, t.signoffdt, t.signonrank
				FROM tblcontract t
				INNER JOIN (
					SELECT idperson, MAX(idcontract) AS max_idcontract
					FROM tblcontract WHERE deletests = 0 AND signondt != '0000-00-00' GROUP BY idperson
				) x ON x.idperson = t.idperson AND x.max_idcontract = t.idcontract 
			) C ON A.idperson = C.idperson 
			LEFT JOIN mstvessel b ON C.kdcmprec = b.kdcmp
			LEFT JOIN mstrank d ON C.signonrank = d.kdrank AND d.urutan > 0
			LEFT JOIN (
				SELECT idperson, MIN(signondt) AS first_signondt
				FROM tblcontract
				WHERE deletests = 0 AND signondt != '0000-00-00'
				GROUP BY idperson
			) first_contract ON A.idperson = first_contract.idperson
			$where
			GROUP BY A.idperson
			ORDER BY rank_urutan ASC, fullname ASC
		";

		$rows = $this->db->query($sql)->result();

		// Fetch all valid contracts to calculate exact active contract time (excluding time on land)
		$contract_query = $this->db->query("
			SELECT idperson, signondt, signoffdt
			FROM tblcontract
			WHERE deletests = '0'
				AND signondt != '0000-00-00'
				AND signondt IS NOT NULL
			ORDER BY idperson, signondt ASC
		")->result();

		$person_contracts = array();
		foreach ($contract_query as $c) {
			if (!isset($person_contracts[$c->idperson])) {
				$person_contracts[$c->idperson] = array();
			}
			$person_contracts[$c->idperson][] = $c;
		}

		$today = date('Y-m-d');
		$data = array();
		foreach ($rows as $row) {
			$contracts = isset($person_contracts[$row->idperson]) ? $person_contracts[$row->idperson] : array();
			$contract_count = count($contracts);
			if ($contract_count === 0 && !empty($row->total_contract)) {
				$contract_count = (int)$row->total_contract;
			}

			// Sum active duration across only actual contracts on board (excluding time on land)
			$total_days = 0;
			foreach ($contracts as $c) {
				$s_on = $c->signondt;
				$s_off = (!empty($c->signoffdt) && $c->signoffdt != '0000-00-00' && $c->signoffdt != 'On Board') ? $c->signoffdt : $today;

				$start = new DateTime($s_on);
				$end = new DateTime($s_off);
				if ($end >= $start) {
					$diff = $start->diff($end);
					$days = (int)$diff->format('%r%a');
					$total_days += max(0, $days);
				}
			}

			$duration_str = "";
			if ($total_days > 0) {
				$years = floor($total_days / 365);
				$rem_days = $total_days % 365;
				$months = floor($rem_days / 30);
				$days = $rem_days % 30;

				$dur_parts = array();
				if ($years > 0) $dur_parts[] = $years . " Years";
				if ($months > 0) $dur_parts[] = $months . " Months";
				if (empty($dur_parts) && $days >= 0) $dur_parts[] = $days . " Days";

				$duration_str = implode(" ", $dur_parts);
			}

			$contract_text = $contract_count . " Contract";
			if (!empty($duration_str)) {
				$contract_text .= " (" . $duration_str . ")";
			}

			$data[] = array(
				'idperson'       => $row->idperson,
				'nmcmp'          => $row->nmcmp,
				'applyfor'       => $row->applyfor,
				'rank_urutan'    => $row->rank_urutan,
				'fullname'       => $row->fullname,
				'total_contract' => $contract_text,
				'religion'       => $row->religion,
				'gender'         => $row->gender,
				'signondt'       => (!empty($row->signondt) && $row->signondt != '0000-00-00')
									? date('d M Y', strtotime($row->signondt))
									: '',
				'signoffdt'      => (!empty($row->signoffdt) && $row->signoffdt != '0000-00-00')
									? date('d M Y', strtotime($row->signoffdt))
									: 'On Board'
			);
		}

		echo json_encode(array(
				'success' => true,
				'data'    => $data
		));
	}

	public function exportListContractExcel()
	{
		$idpersons_json = $this->input->post('idpersons');
        
        if (empty($idpersons_json)) {
            show_error('No data to export or invalid request.');
            return;
        }

        $idpersons = json_decode($idpersons_json, true);
        if (empty($idpersons)) {
            show_error('No data to export.');
            return;
        }

        // Sanitize IDs
        $ids_escaped = array();
        foreach ($idpersons as $id) {
            $ids_escaped[] = $this->db->escape_str($id);
        }
        $ids = implode("','", $ids_escaped);

		$where = "
            WHERE A.deletests = '0'
            AND (A.fname != '' OR A.mname != '' OR A.lname != '')
            AND (A.inAktif = '0' OR A.inAktif IS NULL)
            AND (A.inBlacklist = '0' OR A.inBlacklist IS NULL)
        ";

		$sql = "
				SELECT 
						A.idperson,
						b.nmcmp,
						d.nmrank AS applyfor,
						IFNULL(d.urutan, 9999) AS rank_urutan,
						CONCAT_WS(' ', A.fname, A.mname, A.lname) AS fullname,
						first_contract.first_signondt AS signondt,
						C.signoffdt,
						A.religion,
						A.gender,
						(
								SELECT COUNT(*)
								FROM tblcontract tc
								WHERE tc.idperson = A.idperson
									AND tc.deletests = 0
									AND tc.signondt != '0000-00-00'
									AND tc.signondt IS NOT NULL
						) AS total_contract

				FROM mstpersonal A
				INNER JOIN (
					SELECT t.idperson, t.kdcmprec, t.signondt, t.signoffdt, t.signonrank
					FROM tblcontract t
					INNER JOIN (
						SELECT idperson, MAX(idcontract) AS max_idcontract
						FROM tblcontract WHERE deletests = 0 AND signondt != '0000-00-00' GROUP BY idperson
					) x ON x.idperson = t.idperson AND x.max_idcontract = t.idcontract
				) C ON A.idperson = C.idperson 
				LEFT JOIN mstvessel b ON C.kdcmprec = b.kdcmp
				LEFT JOIN mstrank d ON C.signonrank = d.kdrank AND d.urutan > 0
				LEFT JOIN (
					SELECT idperson, MIN(signondt) AS first_signondt
					FROM tblcontract
					WHERE deletests = 0 AND signondt != '0000-00-00'
					GROUP BY idperson
				) first_contract ON A.idperson = first_contract.idperson
				$where
				AND A.idperson IN ('$ids')
				GROUP BY A.idperson
				ORDER BY rank_urutan ASC, fullname ASC
		";

		$rows = $this->db->query($sql)->result();

		// Fetch all valid contracts for exported IDs
		$contract_query = $this->db->query("
			SELECT idperson, signondt, signoffdt
			FROM tblcontract
			WHERE deletests = '0'
				AND signondt != '0000-00-00'
				AND signondt IS NOT NULL
				AND idperson IN ('$ids')
			ORDER BY idperson, signondt ASC
		")->result();

		$person_contracts = array();
		foreach ($contract_query as $c) {
			if (!isset($person_contracts[$c->idperson])) {
				$person_contracts[$c->idperson] = array();
			}
			$person_contracts[$c->idperson][] = $c;
		}

		$today = date('Y-m-d');
		foreach ($rows as $row) {
			$row->signoffdt = ( $row->signoffdt == '0000-00-00' ) ? 'On Board' : $row->signoffdt;

			$contracts = isset($person_contracts[$row->idperson]) ? $person_contracts[$row->idperson] : array();
			$contract_count = count($contracts);
			if ($contract_count === 0 && !empty($row->total_contract)) {
				$contract_count = (int)$row->total_contract;
			}

			// Sum active duration across only actual contracts on board (excluding time on land)
			$total_days = 0;
			foreach ($contracts as $c) {
				$s_on = $c->signondt;
				$s_off = (!empty($c->signoffdt) && $c->signoffdt != '0000-00-00' && $c->signoffdt != 'On Board') ? $c->signoffdt : $today;

				$start = new DateTime($s_on);
				$end = new DateTime($s_off);
				if ($end >= $start) {
					$diff = $start->diff($end);
					$days = (int)$diff->format('%r%a');
					$total_days += max(0, $days);
				}
			}

			$duration_str = "";
			if ($total_days > 0) {
				$years = floor($total_days / 365);
				$rem_days = $total_days % 365;
				$months = floor($rem_days / 30);
				$days = $rem_days % 30;

				$dur_parts = array();
				if ($years > 0) $dur_parts[] = $years . " Years";
				if ($months > 0) $dur_parts[] = $months . " Months";
				if (empty($dur_parts) && $days >= 0) $dur_parts[] = $days . " Days";

				$duration_str = implode(" ", $dur_parts);
			}

			$contract_text = $contract_count . " Contract";
			if (!empty($duration_str)) {
				$contract_text .= " (" . $duration_str . ")";
			}

			$row->total_contract = $contract_text;
		}

		$data['rows'] = $rows;
		
		$this->load->view('Report/ListContract/pdf_listcontract', $data);
	}
}