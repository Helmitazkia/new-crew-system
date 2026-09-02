<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MCrewscv');
        $this->load->library('../controllers/DataContext');
        $this->load->library('session');

        // Auth guard
        $allowed = array();
        $current = $this->router->fetch_method();
        if (!in_array($current, $allowed) && !$this->session->userdata('isLogin')) {
            redirect('auth/login');
            exit;
        }
    }

    public function view()
    {
        $data['title'] = 'Dashboard System';
        $data['active_menu'] = 'dashboard';
        
        // Dapatkan list vessel untuk filter
        $sqlVessel = "SELECT kdvsl, nmvsl FROM mstvessel WHERE deletests = '0' ORDER BY nmvsl ASC";
        $data['vessels'] = $this->db->query($sqlVessel)->result();

        $this->load->view('layout/header', $data);
        $this->load->view('dashboard/view_dashboard', $data);
        $this->load->view('layout/footer');
    }

    public function get_familiarization_stats()
    {
        $vessel = $this->input->post('vessel', true);
        $date_start = $this->input->post('date_start', true);
        $date_end = $this->input->post('date_end', true);

        // Base Query untuk mengambil history familiarization
        $whereClause = " 1=1 ";
        if (!empty($vessel)) {
            $whereClause .= " AND vessel = " . $this->db->escape($vessel);
        }
        if (!empty($date_start) && !empty($date_end)) {
            $whereClause .= " AND DATE(date_created) >= " . $this->db->escape($date_start) . " AND DATE(date_created) <= " . $this->db->escape($date_end . ' 23:59:59');
        }

        $sql = "
            SELECT 
                COALESCE(batch_id, id) as group_id,
                MAX(date_created) as date_created,
                MAX(vessel) as vessel,
                COUNT(id) as total_crew,
                MAX(item_1) as item_1, MAX(item_2) as item_2, MAX(item_3) as item_3, MAX(item_4) as item_4,
                MAX(item_5) as item_5, MAX(item_6) as item_6, MAX(item_7) as item_7, MAX(item_8) as item_8,
                MAX(item_9) as item_9, MAX(item_10) as item_10, MAX(item_11) as item_11, MAX(item_12) as item_12,
                MAX(item_13) as item_13, MAX(item_14) as item_14, MAX(item_15) as item_15, MAX(item_16) as item_16
            FROM history_familiarization
            WHERE $whereClause
            GROUP BY COALESCE(batch_id, id)
            ORDER BY MAX(date_created) ASC
        ";

        $data = $this->db->query($sql)->result();

        $total_batches = 0;
        $total_crew = 0;
        $completed = 0;
        $pending = 0;

        $trend_data = array();
        $vessel_data = array();

        foreach ($data as $row) {
            $total_batches++;
            $total_crew += $row->total_crew;
            
            // Check completion
            $isCompleted = true;
            for ($i = 1; $i <= 16; $i++) {
                $itemKey = 'item_' . $i;
                if ($row->$itemKey === null || $row->$itemKey === '') {
                    $isCompleted = false;
                    break;
                }
            }
            if ($isCompleted) {
                $completed++;
            } else {
                $pending++;
            }

            // Trend by month (format YYYY-MM)
            if ($row->date_created) {
                $month = date('Y-m', strtotime($row->date_created));
                if (!isset($trend_data[$month])) {
                    $trend_data[$month] = 0;
                }
                $trend_data[$month]++;
            }

            // Crew per vessel (count distinct crew instead of batches if we want, or sum crew)
            // Here we sum crew per vessel
            $v = !empty($row->vessel) ? $row->vessel : 'Unknown';
            if (!isset($vessel_data[$v])) {
                $vessel_data[$v] = 0;
            }
            $vessel_data[$v] += $row->total_crew;
        }

        // Format chart data
        ksort($trend_data); // Sort by month asc
        $labels_trend = array_keys($trend_data);
        $values_trend = array_values($trend_data);
        
        // Format trend labels nicely (e.g. Jan 2024)
        $labels_trend_fmt = array_map(function($m) {
            return date('M Y', strtotime($m . '-01'));
        }, $labels_trend);

        arsort($vessel_data); // Sort by value desc
        $labels_vessel = array_keys($vessel_data);
        $values_vessel = array_values($vessel_data);

        echo json_encode(array(
            'success' => true,
            'summary' => array(
                'total_batches' => $total_batches,
                'total_crew'    => $total_crew,
                'completed'     => $completed,
                'pending'       => $pending
            ),
            'charts' => array(
                'trend' => array(
                    'labels' => $labels_trend_fmt,
                    'data'   => $values_trend
                ),
                'vessel' => array(
                    'labels' => $labels_vessel,
                    'data'   => $values_vessel
                )
            )
        ));
    }

    public function get_crew_rotation_stats()
    {
        $vessel = $this->input->post('vessel', true);
        $status_filter = $this->input->post('status', true);
        $date_start = $this->input->post('date_start', true);
        $date_end = $this->input->post('date_end', true);

        // Build Where Clause
        $whereClause = " R.deletests = '0' ";
        
        if (!empty($vessel)) {
            $whereClause .= " AND R.next_vessel = " . $this->db->escape($vessel);
        }
        
        $sql = "SELECT R.BatchID, R.idcrewrotation, R.status, R.status_crew_change, R.replacement_idperson, R.addusrdt, 
                       NXVSL.nmvsl AS next_vessel_name
                FROM tblcrewrotation R
                LEFT JOIN mstvessel NXVSL ON NXVSL.kdvsl = R.next_vessel AND NXVSL.deletests = '0'
                WHERE $whereClause";

        $data = $this->db->query($sql)->result();
        
        $total_plans = 0;
        $planned_ready = 0;
        $joined = 0;
        $signoff_cancel = 0;
        
        $batches = array();
        $trend_map = array();
        $vessel_map = array();
        $status_map = array(
            'Planned' => 0,
            'Joined' => 0,
            'Sign Off' => 0,
            'Cancel' => 0
        );

        foreach ($data as $row) {
            // Parse Date
            $created_date_raw = '';
            if (!empty($row->addusrdt)) {
                $parts = explode('/', $row->addusrdt);
                if (isset($parts[1]) && strlen($parts[1]) >= 8) {
                    $year = substr($parts[1], 0, 4);
                    $month = substr($parts[1], 4, 2);
                    $day = substr($parts[1], 6, 2);
                    $created_date_raw = "$year-$month-$day";
                }
            }
            
            // Filter by Date
            if (!empty($date_start) && !empty($date_end) && !empty($created_date_raw)) {
                if ($created_date_raw < $date_start || $created_date_raw > $date_end) {
                    continue; 
                }
            }

            // Determine display status logic
            $displayStatus = $row->status;
            if ($row->status === "Submit") {
                $displayStatus = "Planned";
            } else if ($row->status === "Cancel") {
                $displayStatus = "Cancel";
            } else if ($row->status === "Joined" && $row->status_crew_change === 'Down') {
                $displayStatus = "Sign Off";
            } else if ($row->status === "Joined") {
                $displayStatus = "Joined";
            } else {
                $displayStatus = $row->status;
            }
            
            if (empty($displayStatus)) $displayStatus = "Planned"; // Default fallback

            // Filter by Status
            if (!empty($status_filter) && $displayStatus !== $status_filter) {
                continue;
            }

            $total_plans++;
            if (!empty($row->BatchID)) {
                $batches[$row->BatchID] = true;
            } else {
                $batches['id_'.$row->idcrewrotation] = true;
            }

            if ($displayStatus === 'Planned') {
                $planned_ready++;
            } else if ($displayStatus === 'Joined') {
                $joined++;
            } else if ($displayStatus === 'Sign Off' || $displayStatus === 'Cancel') {
                $signoff_cancel++;
            }

            if (isset($status_map[$displayStatus])) {
                $status_map[$displayStatus]++;
            } else {
                // If it happens to be another status
                $status_map[$displayStatus] = 1;
            }

            // Trend
            if (!empty($created_date_raw)) {
                $month_str = date('M Y', strtotime($created_date_raw . '-01'));
                if (!isset($trend_map[$month_str])) $trend_map[$month_str] = 0;
                $trend_map[$month_str]++;
            }

            // Vessel
            $v_name = !empty($row->next_vessel_name) ? $row->next_vessel_name : 'Unknown';
            if (!isset($vessel_map[$v_name])) {
                $vessel_map[$v_name] = array(
                    'total' => 0,
                    'Planned' => 0,
                    'Joined' => 0,
                    'Sign Off' => 0,
                    'Cancel' => 0
                );
            }
            $vessel_map[$v_name]['total']++;
            
            if (isset($vessel_map[$v_name][$displayStatus])) {
                $vessel_map[$v_name][$displayStatus]++;
            } else {
                $vessel_map[$v_name][$displayStatus] = 1;
            }
        }

        // Sort data by total descending
        uasort($vessel_map, function($a, $b) {
            return $b['total'] - $a['total'];
        });

        $vessel_labels = array_keys($vessel_map);
        $vessel_datasets = array(
            'Planned' => array(),
            'Joined' => array(),
            'Sign Off' => array(),
            'Cancel' => array()
        );

        foreach ($vessel_labels as $v_name) {
            $vessel_datasets['Planned'][] = isset($vessel_map[$v_name]['Planned']) ? $vessel_map[$v_name]['Planned'] : 0;
            $vessel_datasets['Joined'][] = isset($vessel_map[$v_name]['Joined']) ? $vessel_map[$v_name]['Joined'] : 0;
            $vessel_datasets['Sign Off'][] = isset($vessel_map[$v_name]['Sign Off']) ? $vessel_map[$v_name]['Sign Off'] : 0;
            $vessel_datasets['Cancel'][] = isset($vessel_map[$v_name]['Cancel']) ? $vessel_map[$v_name]['Cancel'] : 0;
        }

        $response = array(
            'success' => true,
            'summary' => array(
                'total_plans' => $total_plans,
                'total_batches' => count($batches),
                'planned_ready' => $planned_ready,
                'joined' => $joined,
                'signoff_cancel' => $signoff_cancel
            ),
            'charts' => array(
                'trend' => array(
                    'labels' => array_keys($trend_map),
                    'data' => array_values($trend_map)
                ),
                'status' => array(
                    'labels' => array_keys($status_map),
                    'data' => array_values($status_map)
                ),
                'vessel' => array(
                    'labels' => $vessel_labels,
                    'datasets' => $vessel_datasets
                )
            )
        );

        echo json_encode($response);
    }

    public function get_active_roster_stats()
    {
        $sql = "
            SELECT
                A.idperson,
                A.inBlacklist,
                A.inAktif,
                A.newapplicent,
                K.deletests AS kota_deletests,
                C.signoffdt,
                C.estsignoffdt
            FROM mstpersonal A
            LEFT JOIN (
                SELECT t1.idperson, t1.signoffdt, t1.estsignoffdt
                FROM tblcontract t1
                WHERE t1.deletests = 0
                AND t1.idcontract = (
                    SELECT MAX(t2.idcontract)
                    FROM tblcontract t2
                    WHERE t2.idperson = t1.idperson
                    AND t2.deletests = 0
                )
            ) C ON A.idperson = C.idperson 
                AND (A.inAktif = '0' OR A.inAktif IS NULL)
                AND (A.inBlacklist = '0' OR A.inBlacklist IS NULL)
            LEFT JOIN tblkota K ON A.pob = K.KdKota
            WHERE A.deletests = '0'
            AND (A.fname != '' OR A.mname != '' OR A.lname != '')
            GROUP BY A.idperson
        ";
        
        $rows = $this->db->query($sql)->result_array();
        
        $stats = array(
            'On board' => 0,
            'Stand By' => 0,
            'New Applicant' => 0,
            'Non Aktif' => 0,
            'Not For Emp' => 0
        );

        $today = date('Y-m-d');
        foreach ($rows as $row) {
            $displayStatus = null;
            if (isset($row['inBlacklist']) && $row['inBlacklist'] == '1') {
                $displayStatus = 'Not For Emp';
            } elseif (isset($row['inAktif']) && $row['inAktif'] == '1') {
                $displayStatus = 'Non Aktif';
            } elseif (isset($row['newapplicent']) && $row['newapplicent'] == '1') {
                $displayStatus = 'New Applicant';
            } elseif (isset($row['signoffdt']) && $row['signoffdt'] !== '' && $row['signoffdt'] !== null && $row['signoffdt'] !== '0000-00-00' && $row['signoffdt'] < $today) {
                $displayStatus = 'Stand By';
            } else {
                if (isset($row['signoffdt']) || isset($row['estsignoffdt'])) {
                    $displayStatus = 'On board';
                }
            }

            if ($displayStatus && isset($stats[$displayStatus])) {
                $stats[$displayStatus]++;
            }
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('success' => true, 'data' => $stats)));
    }
}
