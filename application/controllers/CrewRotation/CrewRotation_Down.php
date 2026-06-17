<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers/CrewRotation/CrewRotation.php';

class CrewRotation_Down extends CrewRotation
{
    public function __construct()
    {
        parent::__construct();
        // Login checking is inherited from parent::__construct()
    }

    public function detail()
    {
        $idcrewrotation = $this->input->get('idcrewrotation');
        $row = null;
        $batch_rows = array();
        $batch_id = '';

        // Jika nanti fitur edit untuk "Down" diimplementasikan
        if (!empty($idcrewrotation)) {
            $sql = "SELECT R.*, P.fullName AS onboard_name
                    FROM tblcrewrotation R
                    LEFT JOIN (
                        SELECT idperson, TRIM(CONCAT_WS(' ', fname, mname, lname)) AS fullName
                        FROM mstpersonal WHERE deletests = '0'
                    ) P ON P.idperson = R.idperson
                    WHERE R.deletests = '0' AND R.idcrewrotation = ?";
            $first = $this->db->query($sql, array($idcrewrotation))->row_array();
            if ($first) {
                $row = $first;
                $batch_id = isset($first['BatchID']) ? $first['BatchID'] : '';
                if ($batch_id !== '') {
                    $sqlBatch = "SELECT R.*, P.fullName AS onboard_name
                            FROM tblcrewrotation R
                            LEFT JOIN (
                                SELECT idperson, TRIM(CONCAT_WS(' ', fname, mname, lname)) AS fullName
                                FROM mstpersonal WHERE deletests = '0'
                            ) P ON P.idperson = R.idperson
                            WHERE R.deletests = '0' AND R.BatchID = ?
                            ORDER BY R.idcrewrotation ASC";
                    $batch_rows = $this->db->query($sqlBatch, array($batch_id))->result_array();
                } else {
                    $batch_rows = array($first);
                }
            }
        }

        $data = array(
            'row'                           => $row,
            'batch_rows'                    => $batch_rows,
            'batch_id'                      => $batch_id,
            'optionsSignOffRemarkJson'      => json_encode($this->_getSignOffRemarkOptionsArray()),
            'optionsPersonActiveRosterJson' => json_encode($this->_getPersonActiveRosterOptionsArray()),
        );

        $this->load->view('Roster/CrewRotation/add_down_type', $data);
    }

    public function save_down_type()
    {
        $idpersons = $this->input->post('idperson');
        if (empty($idpersons)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'Candidate Down(s) is required'))
            );
            return;
        }

        $idpersons = is_array($idpersons) ? $idpersons : array($idpersons);
        $idpersons = array_values(array_filter(array_map('trim', array_map('strval', $idpersons))));
        if (empty($idpersons)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'Candidate Down(s) cannot be empty'))
            );
            return;
        }

        $username = $this->session->userdata('userName') ?: 'system';
        $currentDate = date('Ymd/H:i:s');
        $batch_id = 'CR-DWN-' . date('YmdHis') . '-' . substr(uniqid(), -4);

        $signoffdt = trim((string) $this->input->post('signoffdt'));
        $signoffremark = trim((string) $this->input->post('signoffremark'));
        $estremark = trim((string) $this->input->post('estremark'));

        $base = array(
            'replacement_idperson'  => null, // Empty for Down
            'replacement_rank'      => null,
            'BatchID'               => $batch_id,
            'status_crew_change'    => 'Down',
            'is_double_up'          => 0,
            
            // These will be fetched from contract for display via JOIN, 
            // but we can leave them null here since it's "Down"
            'kdcmprec'              => null,
            'signondt'              => null,
            'signonvsl'             => null,
            'signonrank'            => null,
            
            'signoffdt'             => ($signoffdt && $signoffdt !== '') ? $signoffdt : '0000-00-00',
            'estsignoffdt'          => '0000-00-00',
            'signonport'            => null,
            'signondesc'            => null,
            'lastvsl'               => null,
            'no_pkl'                => null,
            
            'estremark'             => ($estremark !== '') ? $estremark : null,
            'signoffremark'         => ($signoffremark !== '') ? $signoffremark : null,
            'signoffdt_onsigner'    => '0000-00-00',
            'signoffremark_onsigner'=> null,
            
            'status'                => 'Submit',
            'next_vessel'           => null,
            'addusrdt'              => $username . '/' . $currentDate,
            'deletests'             => 0,
        );

        $this->db->trans_start();
        foreach ($idpersons as $pid) {
            $row = $base;
            $row['idperson'] = $pid;
            $this->db->insert('tblcrewrotation', $row);
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'Failed to save data. Database error.'))
            );
        } else {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => true, 'message' => 'Data Down saved successfully', 'batch_id' => $batch_id))
            );
        }
    }
}
