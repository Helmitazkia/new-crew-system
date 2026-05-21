<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transmital extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MCrewscv');
        $this->load->library('session');
        // Check if user is logged in
        if (!$this->session->userdata('isLogin')) {
            redirect('auth/login');
            exit;
        }
    }

	public function transmital($idPerson = "")
	{
		$dataOut = array();
		
		$sqlCert = "SELECT certname, docno, issdate, expdate FROM tblcertdoc 
					WHERE idperson = '".$idPerson."' AND deletests = '0' ORDER BY certname ASC";
		$certResults = $this->MCrewscv->getDataQuery($sqlCert, array($idPerson));

		$sqlCrew = "SELECT 
					TRIM(CONCAT(mp.fname, ' ', mp.mname, ' ', mp.lname)) AS fullName,
					mr.nmrank AS rankName,
					mv.nmvsl AS vesselName
				FROM tblcontract tc
				JOIN mstpersonal mp ON tc.idperson = mp.idperson
				LEFT JOIN mstrank mr ON tc.signonrank = mr.kdrank
				LEFT JOIN mstvessel mv ON tc.signonvsl = mv.kdvsl
				WHERE tc.idperson = '".$idPerson."' AND tc.deletests = '0'";
		
		$crewResult = $this->MCrewscv->getDataQuery($sqlCrew, array($idPerson));

		$crewName = $crewResult ? $crewResult[0]->fullName : 'Unknown';
		$crewRank = $crewResult ? $crewResult[0]->rankName : 'Unknown';
		$vesselName = $crewResult ? $crewResult[0]->vesselName : 'Unknown';
		
		$certTable = '';
		if (!empty($certResults)) {
			foreach ($certResults as $cert) {
				$certTable .= '<tr>';
				$certTable .= '<td class="cert-name" style="text-align: left;">' . htmlspecialchars($cert->certname) . '</td>';
				$certTable .= '<td><input type="text" style="width: 50px; border: none; text-align: center;"></td>';
				$issDate = ($cert->issdate && $cert->issdate !== '0000-00-00') ? date('d M Y', strtotime($cert->issdate)) : 'N/A';
				$certTable .= '<td style="border: none; text-align: center;">' . $issDate . '</td>';
				$expDate = ($cert->expdate && $cert->expdate !== '0000-00-00') ? date('d M Y', strtotime($cert->expdate)) : 'Unlimited';
				$certTable .= '<td style="border: none; text-align: center;">' . $expDate . '</td>';
				$certTable .= '<td class="document-number" style="border-bottom: 1px solid black; text-align: left;">' . htmlspecialchars($cert->docno) . '</td>';
				$certTable .= '</tr>';
			}        
			$certTable .= '<tr>';
				$certTable .= '<td colspan="5" style="text-align: left; font-weight: bold;">Other Certificate:</td>';
			$certTable .= '</tr>';
			for ($i=1; $i <= 10; $i++) { 
				$certTable .= '<tr>';
				$certTable .= '<td class="cert-name" style="text-align: left; border-bottom: 1px dotted black;"></td>';
				$certTable .= '<td><input type="text" style="width: 50px; border: none; text-align: center;"></td>';
				$certTable .= '<td style="border-bottom: 1px dotted black; text-align: center;"></td>';
				$certTable .= '<td style="border-bottom: 1px dotted black; text-align: center;"></td>';
				$certTable .= '<td style="border-bottom: 1px dotted black; text-align: center;"></td>';
				$certTable .= '</tr>';
			}
		}

		$dataOut['crewName'] = $crewName;
		$dataOut['crewRank'] = $crewRank;
		$dataOut['vesselName'] = $vesselName;
		$dataOut['certTable'] = $certTable;

		$nama_dokumen = "Transmital_Name_" . $crewName;
		require("application/views/frontend/pdf/mpdf60/mpdf.php");
		$mpdf = new mPDF('utf-8', 'A4');

		ob_start();
		$this->load->view('ListReport/Transmital/form_transmital_pdf', $dataOut);
		$html = ob_get_contents();
		ob_end_clean();
		$mpdf->WriteHTML(utf8_encode($html));
		$mpdf->Output($nama_dokumen . ".pdf", 'I');
		exit;
	}
}
?>