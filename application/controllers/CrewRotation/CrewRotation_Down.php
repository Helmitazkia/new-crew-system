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

    public function update_down_type()
    {
        $idcrewrotation = $this->input->post('idcrewrotation');
        $batch_id = $this->input->post('batch_id');
        if (empty($idcrewrotation) && empty($batch_id)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'idcrewrotation or batch_id required'))
            );
            return;
        }

        $username = $this->session->userdata('userName') ?: 'system';
        $currentDate = date('Ymd/H:i:s');

        $signoffdt = trim((string) $this->input->post('signoffdt'));
        $signoffremark = trim((string) $this->input->post('signoffremark'));
        $estremark = trim((string) $this->input->post('estremark'));

        $shared = array(
            'status_crew_change'      => 'Down',
            'signoffdt'               => ($signoffdt && $signoffdt !== '') ? $signoffdt : '0000-00-00',
            'estremark'               => ($estremark !== '') ? $estremark : null,
            'signoffremark'           => ($signoffremark !== '') ? $signoffremark : null,
            'updusrdt'                => $username . '/' . $currentDate,
        );

        $idpersons = $this->input->post('idperson');
        $idpersons = is_array($idpersons) ? $idpersons : ($idpersons ? array($idpersons) : array());
        $idpersons = array_values(array_filter(array_map('trim', array_map('strval', $idpersons))));

        if (!empty($batch_id)) {
            $batch_rows = $this->db->query("SELECT idcrewrotation, idperson, status FROM tblcrewrotation WHERE deletests = '0' AND BatchID = ?", array($batch_id))->result_array();
            if (empty($batch_rows)) {
                $this->output->set_content_type('application/json')->set_output(
                    json_encode(array('status' => false, 'message' => 'Batch not found'))
                );
                return;
            }

            $existing_pids = array();
            foreach ($batch_rows as $br) {
                if ($br['idperson']) {
                    $existing_pids[(string)$br['idperson']] = array('idcrewrotation' => $br['idcrewrotation'], 'idperson' => $br['idperson']);
                }
            }

            $idpersons_mapped = array();
            foreach ($idpersons as $p) {
                $idpersons_mapped[(string)$p] = $p;
            }

            foreach ($batch_rows as $br) {
                $pidKey = (string)$br['idperson'];
                if (!array_key_exists($pidKey, $idpersons_mapped)) {
                    if ($br['status'] !== 'Joined' && $br['status'] !== 'Cancel') {
                        $this->db->where('idcrewrotation', $br['idcrewrotation']);
                        $this->db->update('tblcrewrotation', array('deletests' => 1, 'updusrdt' => $username . '/' . $currentDate));
                    }
                } else {
                    $this->db->where('idcrewrotation', $br['idcrewrotation']);
                    $this->db->update('tblcrewrotation', $shared);
                }
            }

            foreach ($idpersons_mapped as $pidKey => $pidVal) {
                if (!array_key_exists($pidKey, $existing_pids)) {
                    $ins = array(
                        'idperson' => $pidVal,
                        'BatchID' => $batch_id,
                        'replacement_idperson' => null,
                        'replacement_rank' => null,
                        'status_crew_change' => 'Down',
                        'status' => 'Submit',
                        'signonrank' => null,
                        'kdcmprec' => null,
                        'signondt' => null,
                        'signonvsl' => null,
                        'estsignoffdt' => '0000-00-00',
                        'signonport' => null,
                        'signondesc' => null,
                        'lastvsl' => null,
                        'no_pkl' => null,
                        'signoffdt_onsigner' => '0000-00-00',
                        'signoffremark_onsigner' => null,
                        'next_vessel' => null,
                        'addusrdt' => $username . '/' . $currentDate,
                        'deletests' => 0,
                    );
                    foreach (array('signoffdt', 'estremark', 'signoffremark') as $k) {
                        $ins[$k] = isset($shared[$k]) ? $shared[$k] : null;
                    }
                    $this->db->insert('tblcrewrotation', $ins);
                }
            }
        } else {
            if (empty($idpersons)) {
                $this->output->set_content_type('application/json')->set_output(
                    json_encode(array('status' => false, 'message' => 'Candidate Down(s) is required'))
                );
                return;
            }
            $data = array_merge($shared, array(
                'idperson' => $idpersons[0],
            ));
            
            $this->db->where('idcrewrotation', $idcrewrotation);
            $this->db->update('tblcrewrotation', $data);
            
            $row_db = $this->db->query("SELECT status FROM tblcrewrotation WHERE idcrewrotation = ?", array($idcrewrotation))->row_array();
            if ($row_db && strtoupper($row_db['status']) === 'JOINED') {
                $this->_syncRotationToContract($idcrewrotation);
            }
        }

        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('status' => true, 'message' => 'Data Down updated successfully'))
        );
    }
}
