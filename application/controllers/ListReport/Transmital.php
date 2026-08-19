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

	public function view()
	{
		$this->load->view('ListReport/Transmital/view_transmital');
	}

    public function get_history()
    {
        $idperson = $this->input->post('idperson');
        $idperson_esc = $this->db->escape($idperson);
        
        $sql = "SELECT id_transmital, idperson, crew_name, rank, vessel, date_transmital 
                FROM tblhistorytransmital 
                WHERE idperson = $idperson_esc 
                ORDER BY created_at DESC";
                
        $data = $this->MCrewscv->getDataQuery($sql);
        
        if ($data) {
            echo json_encode(array('success' => true, 'data' => $data));
        } else {
            echo json_encode(array('success' => true, 'data' => array()));
        }
    }

    public function get_form_data()
    {
        $idperson = $this->input->post('idperson');
        $idperson_esc = $this->db->escape($idperson);

        $sqlCrew = "SELECT 
                    TRIM(CONCAT(mp.fname, ' ', mp.mname, ' ', mp.lname)) AS fullName,
                    mr.nmrank AS rankName,
                    mv.nmvsl AS vesselName
                FROM tblcontract tc
                JOIN mstpersonal mp ON tc.idperson = mp.idperson
                LEFT JOIN mstrank mr ON tc.signonrank = mr.kdrank
                LEFT JOIN mstvessel mv ON tc.signonvsl = mv.kdvsl
                WHERE tc.idperson = $idperson_esc AND tc.deletests = '0' ORDER BY tc.idcontract DESC LIMIT 1";
        
        $crewResult = $this->MCrewscv->getDataQuery($sqlCrew);

        if (!$crewResult) {
            // fallback if no active contract
            $sqlCrewFallback = "SELECT 
                        TRIM(CONCAT(fname, ' ', mname, ' ', lname)) AS fullName,
                        '' AS rankName,
                        '' AS vesselName
                    FROM mstpersonal 
                    WHERE idperson = $idperson_esc";
            $crewResult = $this->MCrewscv->getDataQuery($sqlCrewFallback);
        }

        $sqlCert = "SELECT idcertdoc, certname, docno, issdate, expdate FROM tblcertdoc 
                    WHERE idperson = $idperson_esc AND deletests = '0' ORDER BY certname ASC";
        $certResults = $this->MCrewscv->getDataQuery($sqlCert);

        echo json_encode(array(
            'success' => true,
            'crew' => $crewResult ? $crewResult[0] : null,
            'certs' => $certResults ? $certResults : array()
        ));
    }

    public function save_transmital()
    {
        $idperson = $this->input->post('idperson');
        $crew_name = $this->input->post('fullname');
        $rank = $this->input->post('nmrank');
        $vessel = $this->input->post('nmvsl');
        $date_transmital = $this->input->post('date_transmital');
        
        // Build the cert data JSON
        $cert_data = array();
        $ids = $this->input->post('cert_id');
        $names = $this->input->post('cert_name');
        $docnos = $this->input->post('cert_docno');
        $issdates = $this->input->post('cert_issdate');
        $expdates = $this->input->post('cert_expdate');
        $submits = $this->input->post('cert_submitted'); // Array key is idcertdoc, value is '1' if checked
        $remarks = $this->input->post('cert_remarks');
        
        if (!empty($ids)) {
            foreach ($ids as $index => $id) {
                $cert_data[] = array(
                    'idcertdoc' => $id,
                    'certname' => isset($names[$index]) ? $names[$index] : '',
                    'docno' => isset($docnos[$index]) ? $docnos[$index] : '',
                    'issdate' => isset($issdates[$index]) ? $issdates[$index] : '',
                    'expdate' => isset($expdates[$index]) ? $expdates[$index] : '',
                    'submitted' => isset($submits[$id]) ? '1' : '0',
                    'remarks' => isset($remarks[$id]) ? $remarks[$id] : ''
                );
            }
        }
        
        // Other Certificates
        $other_names = $this->input->post('other_cert_name');
        $other_submits = $this->input->post('other_cert_submitted');
        $other_issdates = $this->input->post('other_cert_issdate');
        $other_expdates = $this->input->post('other_cert_expdate');
        $other_docnos = $this->input->post('other_cert_docno');
        $other_remarks = $this->input->post('other_cert_remarks');
        
        if (!empty($other_names)) {
            foreach ($other_names as $index => $name) {
                if (trim($name) !== '') {
                    $cert_data[] = array(
                        'idcertdoc' => 'other_' . $index,
                        'certname' => $name,
                        'docno' => isset($other_docnos[$index]) ? $other_docnos[$index] : '',
                        'issdate' => isset($other_issdates[$index]) ? $other_issdates[$index] : '',
                        'expdate' => isset($other_expdates[$index]) ? $other_expdates[$index] : '',
                        'submitted' => isset($other_submits[$index]) ? '1' : '0',
                        'remarks' => isset($other_remarks[$index]) ? $other_remarks[$index] : ''
                    );
                }
            }
        }

        $data = array(
            'idperson' => $idperson,
            'crew_name' => $crew_name,
            'rank' => $rank,
            'vessel' => $vessel,
            'date_transmital' => date('Y-m-d', strtotime(str_replace('/', '-', $date_transmital))),
            'cert_data' => json_encode($cert_data),
            'created_at' => date('Y-m-d H:i:s')
        );

        $insert = $this->db->insert('tblhistorytransmital', $data);

        if ($insert) {
            echo json_encode(array('success' => true, 'message' => 'Data Transmital berhasil disimpan.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal menyimpan data.'));
        }
    }

    public function delete_transmital()
    {
        $id = $this->input->post('id');
        $this->db->where('id_transmital', $id);
        $delete = $this->db->delete('tblhistorytransmital');
        
        if ($delete) {
            echo json_encode(array('success' => true, 'message' => 'Data berhasil dihapus.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Gagal menghapus data.'));
        }
    }

	public function print_pdf()
	{
        $id_transmital = $this->input->post('id_report_transmital');
        $id_transmital_esc = $this->db->escape($id_transmital);
        
        $sql = "SELECT * FROM tblhistorytransmital WHERE id_transmital = $id_transmital_esc";
        $result = $this->MCrewscv->getDataQuery($sql);
        
        if (!$result) {
            echo "Data not found!";
            exit;
        }
        
        $record = $result[0];
		
		$dataOut = array();
        
		$dataOut['crewName'] = $record->crew_name;
		$dataOut['crewRank'] = $record->rank;
		$dataOut['vesselName'] = $record->vessel;
        $dataOut['date_transmital'] = $record->date_transmital;
		
        $certs = json_decode($record->cert_data, true);
        
		$certTable = '';
        $otherCertTable = '';
        
        $hasOther = false;
        
		if (!empty($certs)) {
			foreach ($certs as $cert) {
                if (strpos($cert['idcertdoc'], 'other_') !== false) {
                    $hasOther = true;
                    $otherCertTable .= '<tr>';
                    $otherCertTable .= '<td class="cert-name" style="text-align: left; padding: 3px 3px;">' . htmlspecialchars($cert['certname']) . '</td>';
                    $check = ($cert['submitted'] == '1') ? '&#10003;' : ''; // Checkmark if 1
                    $otherCertTable .= '<td style="text-align: center; padding: 3px 3px;">' . $check . '</td>';
                    
                    $issDate = (!empty($cert['issdate']) && $cert['issdate'] !== '0000-00-00') ? date('d M Y', strtotime($cert['issdate'])) : 'N/A';
                    $otherCertTable .= '<td style="text-align: center; padding: 3px 3px;">' . $issDate . '</td>';
                    
                    $expDate = (!empty($cert['expdate']) && $cert['expdate'] !== '0000-00-00') ? date('d M Y', strtotime($cert['expdate'])) : 'Unlimited';
                    $otherCertTable .= '<td style="text-align: center; padding: 3px 3px;">' . $expDate . '</td>';
                    
                    $otherCertTable .= '<td class="document-number" style="text-align: left; padding: 3px 3px;">' . htmlspecialchars($cert['docno']) . '</td>';
                    $otherCertTable .= '<td class="remarks" style="text-align: left; padding: 3px 3px;">' . htmlspecialchars($cert['remarks']) . '</td>';
                    $otherCertTable .= '</tr>';
                } else {
                    $certTable .= '<tr>';
                    $certTable .= '<td class="cert-name" style="text-align: left; padding: 3px 3px;">' . htmlspecialchars($cert['certname']) . '</td>';
                    $check = ($cert['submitted'] == '1') ? '&#10003;' : ''; // Checkmark if 1
                    $certTable .= '<td style="text-align: center; padding: 3px 3px;">' . $check . '</td>';
                    
                    $issDate = (!empty($cert['issdate']) && $cert['issdate'] !== '0000-00-00') ? date('d M Y', strtotime($cert['issdate'])) : 'N/A';
                    $certTable .= '<td style="text-align: center; padding: 3px 3px;">' . $issDate . '</td>';
                    
                    $expDate = (!empty($cert['expdate']) && $cert['expdate'] !== '0000-00-00') ? date('d M Y', strtotime($cert['expdate'])) : 'Unlimited';
                    $certTable .= '<td style="text-align: center; padding: 3px 3px;">' . $expDate . '</td>';
                    
                    $certTable .= '<td class="document-number" style="text-align: left; padding: 3px 3px;">' . htmlspecialchars($cert['docno']) . '</td>';
                    $certTable .= '<td class="remarks" style="text-align: left; padding:3px 3px;">' . htmlspecialchars($cert['remarks']) . '</td>';
                    $certTable .= '</tr>';
                }
			}
            
            if ($hasOther) {
                $certTable .= '<tr>';
				$certTable .= '<td colspan="6" style="text-align: left; font-weight: bold;">Other Certificate:</td>';
                $certTable .= '</tr>';
                $certTable .= $otherCertTable;
            }
		}

		$dataOut['certTable'] = $certTable;

		$nama_dokumen = "Transmital_Name_" . $record->crew_name;
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