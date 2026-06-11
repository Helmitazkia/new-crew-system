<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers/CrewRotation/CrewRotation.php';

class CrewRotation_New extends CrewRotation
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

        if (!empty($idcrewrotation)) {
            $sql = "SELECT R.*, REPL.fullName AS replacement_name
                    FROM tblcrewrotation R
                    LEFT JOIN (
                        SELECT idperson, TRIM(CONCAT_WS(' ', fname, mname, lname)) AS fullName
                        FROM mstpersonal WHERE deletests = '0'
                    ) REPL ON REPL.idperson = R.replacement_idperson
                    WHERE R.deletests = '0' AND R.idcrewrotation = ?";
            $first = $this->db->query($sql, array($idcrewrotation))->row_array();
            if ($first) {
                $row = $first;
                $batch_id = isset($first['BatchID']) ? $first['BatchID'] : '';
                if ($batch_id !== '') {
                    $sqlBatch = "SELECT R.*, REPL.fullName AS replacement_name
                            FROM tblcrewrotation R
                            LEFT JOIN (
                                SELECT idperson, TRIM(CONCAT_WS(' ', fname, mname, lname)) AS fullName
                                FROM mstpersonal WHERE deletests = '0'
                            ) REPL ON REPL.idperson = R.replacement_idperson
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
            'optionsCompanyJson'            => json_encode($this->_getCompanyOptionsArray()),
            'optionsRankJson'               => json_encode($this->_getRankOptionsArray()),
            'optionsVesselJson'             => json_encode($this->_getVesselOptionsArray()),
            'optionsSignOffRemarkJson'      => json_encode($this->_getSignOffRemarkOptionsArray()),
            'optionsPersonActiveRosterJson' => json_encode($this->_getPersonActiveRosterOptionsArray()),
        );

        $this->load->view('Roster/CrewRotation/add_new_type', $data);
    }

      

    public function save_new_type()
    {
        $replacements = $this->input->post('replacement_idperson');
        if (empty($replacements)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'Replacement Candidate is required'))
            );
            return;
        }
        $replacements = is_array($replacements) ? $replacements : array($replacements);
        $replacements = array_values(array_filter(array_map('trim', array_map('strval', $replacements))));
        if (empty($replacements)) {
            $this->output->set_content_type('application/json')->set_output(
                json_encode(array('status' => false, 'message' => 'Replacement Candidate cannot be empty'))
            );
            return;
        }

        $username = $this->session->userdata('userName') ?: 'system';
        $currentDate = date('Ymd/H:i:s');
        $batch_id = 'CR-NEW-' . date('YmdHis') . '-' . substr(uniqid(), -4);

        $signonranks = $this->input->post('signonrank_multi');
        $signonranks = is_array($signonranks) ? $signonranks : ($signonranks ? array($signonranks) : array());
        $signonranks = array_values(array_filter(array_map('trim', array_map('strval', $signonranks))));

        $rankNames = array();
        if (!empty($signonranks)) {
            $r_in = $this->db->where_in('kdrank', $signonranks)->get('mstrank')->result();
            foreach ($r_in as $rw) {
                $rankNames[$rw->kdrank] = $rw->nmrank;
            }
        }

        $base = array(
            'idperson'              => null, // Empty for New
            'BatchID'               => $batch_id,
            'status_crew_change'    => 'New',
            'is_double_up'          => 0,
            'kdcmprec'              => $this->input->post('kdcmprec') ?: null,
            'signondt'              => $this->input->post('signondt') ?: null,
            'signoffdt'             => '0000-00-00',
            'estsignoffdt'          => $this->input->post('estsignoffdt') ?: null,
            'signonvsl'             => $this->input->post('signonvsl') ?: null,
            'signonport'            => $this->input->post('signonport') ?: null,
            'signondesc'            => $this->input->post('signondesc') ?: null,
            'lastvsl'               => $this->input->post('lastvsl') ?: null,
            'no_pkl'                => $this->input->post('no_pkl') ?: null,
            'estremark'             => $this->input->post('estremark') ?: null,
            'signoffremark'         => null,
            'signoffdt_onsigner'    => '0000-00-00',
            'signoffremark_onsigner' => null,
            'status'                => 'Submit',
            'next_vessel'           => $this->input->post('signonvsl') ?: null,
            'addusrdt'              => $username . '/' . $currentDate,
            'deletests'             => 0,
        );

        foreach ($replacements as $index => $rid) {
            $row = $base;
            $row['replacement_idperson'] = $rid;
            $current_rank = isset($signonranks[$index]) ? $signonranks[$index] : (isset($signonranks[0]) ? $signonranks[0] : null);
            $current_rank_name = $current_rank && isset($rankNames[$current_rank]) ? $rankNames[$current_rank] : $current_rank;
            $row['signonrank'] = $current_rank;
            $row['replacement_rank'] = $current_rank_name;
            $this->db->insert('tblcrewrotation', $row);
        }

        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('status' => true, 'message' => 'Data New saved successfully', 'batch_id' => $batch_id))
        );
    }

    public function update_new_type()
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

        $signonranks = $this->input->post('signonrank_multi');
        $signonranks = is_array($signonranks) ? $signonranks : ($signonranks ? array($signonranks) : array());
        $signonranks = array_values(array_filter(array_map('trim', array_map('strval', $signonranks))));

        $rankNames = array();
        if (!empty($signonranks)) {
            $r_in = $this->db->where_in('kdrank', $signonranks)->get('mstrank')->result();
            foreach ($r_in as $rw) {
                $rankNames[$rw->kdrank] = $rw->nmrank;
            }
        }

        $shared = array(
            'status_crew_change'      => 'New',
            'kdcmprec'                => $this->input->post('kdcmprec') ?: null,
            'signondt'                => $this->input->post('signondt') ?: null,
            'estsignoffdt'            => $this->input->post('estsignoffdt') ?: null,
            'signonvsl'               => $this->input->post('signonvsl') ?: null,
            'signonport'              => $this->input->post('signonport') ?: null,
            'signondesc'              => $this->input->post('signondesc') ?: null,
            'lastvsl'                 => $this->input->post('lastvsl') ?: null,
            'no_pkl'                  => $this->input->post('no_pkl') ?: null,
            'estremark'               => $this->input->post('estremark') ?: null,
            'next_vessel'           => $this->input->post('signonvsl') ?: null,
            'updusrdt'                => $username . '/' . $currentDate,
        );

        $replacements = $this->input->post('replacement_idperson');
        $replacements = is_array($replacements) ? $replacements : ($replacements ? array($replacements) : array());
        $replacements = array_values(array_filter(array_map('trim', array_map('strval', $replacements))));

        $normalizeRid = function ($v) {
            $v = trim((string) $v);
            return $v === '' ? '' : str_pad($v, 6, '0', STR_PAD_LEFT);
        };

        if (!empty($batch_id)) {
            $batch_rows = $this->db->query("SELECT idcrewrotation, replacement_idperson, status FROM tblcrewrotation WHERE deletests = '0' AND BatchID = ?", array($batch_id))->result_array();
            if (empty($batch_rows)) {
                $this->output->set_content_type('application/json')->set_output(
                    json_encode(array('status' => false, 'message' => 'Batch not found'))
                );
                return;
            }

            $existing_rids = array();
            foreach ($batch_rows as $br) {
                $key = $normalizeRid($br['replacement_idperson']);
                if ($key !== '') {
                    $existing_rids[$key] = array('idcrewrotation' => $br['idcrewrotation'], 'replacement_idperson' => $br['replacement_idperson']);
                }
            }

            $replacements_normalized = array();
            foreach ($replacements as $idx => $r) {
                $replacements_normalized[$normalizeRid($r)] = array(
                    'rid' => $r,
                    'rank' => isset($signonranks[$idx]) ? $signonranks[$idx] : (isset($signonranks[0]) ? $signonranks[0] : null)
                );
            }

            foreach ($batch_rows as $br) {
                $ridKey = $normalizeRid($br['replacement_idperson']);
                if (!array_key_exists($ridKey, $replacements_normalized)) {
                    if ($br['status'] !== 'Joined' && $br['status'] !== 'Cancel') {
                        $this->db->where('idcrewrotation', $br['idcrewrotation']);
                        $this->db->update('tblcrewrotation', array('deletests' => 1, 'updusrdt' => $username . '/' . $currentDate));
                    }
                } else {
                    $this->db->where('idcrewrotation', $br['idcrewrotation']);
                    $current_rank = $replacements_normalized[$ridKey]['rank'];
                    $current_rank_name = $current_rank && isset($rankNames[$current_rank]) ? $rankNames[$current_rank] : $current_rank;
                    $this->db->update('tblcrewrotation', array_merge($shared, array(
                        'replacement_idperson' => $br['replacement_idperson'],
                        'signonrank' => $current_rank,
                        'replacement_rank' => $current_rank_name
                    )));
                }
            }

            foreach ($replacements_normalized as $ridKey => $replData) {
                if (!array_key_exists($ridKey, $existing_rids)) {
                    $current_rank = $replData['rank'];
                    $current_rank_name = $current_rank && isset($rankNames[$current_rank]) ? $rankNames[$current_rank] : $current_rank;
                    $ins = array(
                        'idperson' => null,
                        'BatchID' => $batch_id,
                        'replacement_idperson' => $replData['rid'],
                        'status' => 'Submit',
                        'signonrank' => $current_rank,
                        'replacement_rank' => $current_rank_name,
                        'addusrdt' => $username . '/' . $currentDate,
                        'deletests' => 0,
                    );
                    foreach (array('status_crew_change', 'kdcmprec', 'signondt', 'estsignoffdt', 'signonvsl', 'signonport', 'signondesc', 'lastvsl', 'no_pkl', 'estremark', 'next_vessel') as $k) {
                        $ins[$k] = isset($shared[$k]) ? $shared[$k] : null;
                    }
                    $this->db->insert('tblcrewrotation', $ins);
                }
            }
        } else {
            if (empty($replacements)) {
                $this->output->set_content_type('application/json')->set_output(
                    json_encode(array('status' => false, 'message' => 'Replacement Candidate is required'))
                );
                return;
            }
            $current_rank = isset($signonranks[0]) ? $signonranks[0] : null;
            $current_rank_name = $current_rank && isset($rankNames[$current_rank]) ? $rankNames[$current_rank] : $current_rank;
            $data = array_merge($shared, array(
                'replacement_idperson' => $replacements[0],
                'signonrank'           => $current_rank,
                'replacement_rank'     => $current_rank_name,
                'status'               => $this->input->post('status') ?: 'Submit',
            ));
            $this->db->where('idcrewrotation', $idcrewrotation);
            $this->db->update('tblcrewrotation', $data);
            
            if (strtoupper($data['status']) === 'Joined') {
                $this->_syncRotationToContract($idcrewrotation);
            }
        }

        $this->output->set_content_type('application/json')->set_output(
            json_encode(array('status' => true, 'message' => 'Data New updated successfully'))
        );
    }
}
