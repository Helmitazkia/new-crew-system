<div class="container-fluid py-4 dashboard-container" style="font-family: 'Inter', 'Segoe UI', sans-serif;">
    <div class="row mb-4">
        <!-- <div class="col-12">
            <h4 class="fw-bold mb-4" style="color: #1e293b;">
                <i class="fa fa-dashboard me-2 text-primary"></i> Dashboard System
            </h4>
        </div> -->
    </div>
    
    <!-- CREW ROTATION MODULE -->
    <?php $this->load->view('dashboard/dashboard_crewrotation'); ?>

    <!-- FAMILIARIZATION MODULE -->
    <?php $this->load->view('dashboard/dashboard_familiar'); ?>

</div>

<!-- Import Google Fonts for better aesthetics -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<!-- Scripts for Dashboard -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<style>
    /* Styling adjustments for Daterangepicker to match Bootstrap 5 / Modern Look */
    .daterangepicker {
        font-family: 'Inter', sans-serif;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .daterangepicker .drp-buttons .btn {
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 6px;
    }

    /* Dashboard Compact Styling */
    .dashboard-container {
        font-size: 0.875rem; /* 14px instead of 16px */
    }
    
    .dashboard-container h4 { font-size: 1.25rem; }
    .dashboard-container h5 { font-size: 1.1rem; }
    .dashboard-container h6 { font-size: 0.95rem; }
    .dashboard-container .h3 { font-size: 1.5rem; } /* KPI Numbers */
    
    /* Compact Cards */
    .dashboard-container .card-body {
        padding: 1.25rem !important;
    }
    .dashboard-container .card-header {
        padding-top: 1.25rem !important;
        padding-bottom: 0.75rem !important;
    }
    
    /* Inputs & Buttons */
    .dashboard-container .form-control, 
    .dashboard-container .form-select,
    .dashboard-container .bootstrap-select > .dropdown-toggle,
    .dashboard-container .btn {
        font-size: 0.875rem;
    }
    
    .dashboard-container .form-label {
        font-size: 0.8rem;
    }
</style>