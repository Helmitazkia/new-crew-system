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
}
