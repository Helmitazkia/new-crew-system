<div class="row w-100 m-0">
    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 sidebar-report border-end py-3">
        <ul class="nav flex-column nav-pills text-center" id="reportTabs">
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="printcv">Print CV</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="covid19">Health and Pandemic</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="defreafing">Defreafing</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link active rounded-pill text-white fw-bold fst-italic shadow-sm" style="background-color: #1c278e;" href="#" data-report="mcu">MCU</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="mlcdeclaration">MLC Declaration Form</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="databank">Data Bank</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="statementemploye">Statement of free of charge</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="statementcontractacceptance">Statement of Contract Acceptance  </a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="pklattachment">PKL Attachment</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="statementwages">Statement Of Wages</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="transmital">Transmital</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="covid19_2">Covid 19 Prevention</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="pkl">PKL</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="spj">Official Travel Letter</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="seafarer">Seafarer Employment Agreement</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="perfeval">Perfom Evaluation</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 col-lg-10 p-3" id="mainReportContent" style="min-height: 80vh;">
        <!-- Content loaded via AJAX -->
        <!-- <div id="reportLoadingSpinner" class="d-none text-center py-5">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 text-muted fw-semibold">Memuat data...</p>
        </div> -->
        <div id="reportContentArea"></div>
    </div>
</div>

<style>
/* Base Styles */
:root {
  --crew-blue: #000099;
  --crew-font-sm: 12px;
  --crew-font-xs: 11px;
}

/* Sidebar Styles */
.sidebar-report {
    max-height: 80vh;
    overflow-y: auto;
    background-color: #ffffff;
}
.sidebar-report::-webkit-scrollbar {
    width: 5px;
}
.sidebar-report::-webkit-scrollbar-thumb {
    background: #d4d4d4; 
    border-radius: 10px;
}
.sidebar-report .nav-link {
    font-size: 13px;
    padding: 6px 10px;
    transition: all 0.2s ease-in-out;
}
.sidebar-report .nav-link:hover {
    background-color: #f1f3f8;
    border-radius: 20px;
}
.sidebar-report .nav-link.active {
    background-color: #171b78 !important;
    color: white !important;
}
</style>

<script>
$(document).ready(function() {

    // ================================
    // Route map: reportType → AJAX URL
    // ================================
    var reportRoutes = {
        'mcu': '<?php echo base_url("CrewDetail/ListReport/view_mcu"); ?>',
        'defreafing': '<?php echo base_url("ListReport/Defreafing/view"); ?>',
        'mlcdeclaration': '<?php echo base_url("ListReport/Mlc/view"); ?>',
        'databank': '<?php echo base_url("ListReport/Bank/view"); ?>',
        'statementemploye': '<?php echo base_url("ListReport/Soe/view"); ?>',
        'covid19': '<?php echo base_url("ListReport/Covid19/view"); ?>',
        'statementcontractacceptance': '<?php echo base_url("ListReport/AcceptentceLetter/view"); ?>',
        'printcv': '<?php echo base_url("ListReport/PrintCv/view"); ?>',
        'pklattachment': '<?php echo base_url("ListReport/PKLAttachment/view"); ?>',
        'statementwages': '<?php echo base_url("ListReport/Wages/view"); ?>'
    };

    // ================================
    // Load report content via AJAX
    // ================================
    function loadReportContent(reportType) {
        var $content = $('#reportContentArea');
        var $spinner = $('#reportLoadingSpinner');

        // Destroy existing DataTables to prevent memory leaks
        if ($.fn.DataTable) {
            $content.find('.dataTable').each(function() {
                if ($.fn.DataTable.isDataTable(this)) {
                    $(this).DataTable().destroy();
                }
            });
        }

        if (reportRoutes[reportType]) {
            $spinner.removeClass('d-none');
            $content.html('');

            $.ajax({
                url: reportRoutes[reportType],
                type: 'GET',
                success: function(html) {
                    $spinner.addClass('d-none');
                    $content.html(html);
                },
                error: function() {
                    $spinner.addClass('d-none');
                    $content.html(
                        '<div class="text-center py-5">' +
                            '<i class="fa fa-exclamation-triangle fa-3x text-warning mb-3"></i>' +
                            '<h5 class="text-muted">Gagal memuat konten</h5>' +
                            '<p class="text-muted">Silakan coba lagi nanti.</p>' +
                        '</div>'
                    );
                }
            });
        } else {
            // Placeholder untuk modul yang belum tersedia
            $spinner.addClass('d-none');
            $content.html(
                '<div class="text-center py-5">' +
                    '<div class="mb-4">' +
                        '<i class="fa fa-cogs fa-4x" style="color: #c5cae9;"></i>' +
                    '</div>' +
                    '<h5 class="text-dark fw-bold">Modul Sedang Dikembangkan</h5>' +
                    '<p class="text-muted" style="max-width: 400px; margin: 0 auto;">' +
                        'Modul <strong>' + reportType.replace(/([A-Z])/g, ' $1').trim() + '</strong> sedang dalam tahap pengembangan dan akan segera tersedia.' +
                    '</p>' +
                    '<div class="mt-3">' +
                        '<span class="badge rounded-pill" style="background-color: #e8eaf6; color: #3949ab; font-size: 12px; padding: 8px 16px;">' +
                            '<i class="fa fa-clock-o me-1"></i> Coming Soon' +
                        '</span>' +
                    '</div>' +
                '</div>'
            );
        }
    }

    // ================================
    // Sidebar navigation click handler
    // ================================
    $('.sidebar-report .nav-link').on('click', function(e) {
        e.preventDefault();
        
        // Remove active styling from all tabs
        $('.sidebar-report .nav-link')
            .removeClass('active rounded-pill text-white shadow-sm')
            .addClass('text-dark')
            .css('background-color', '');
        
        // Add active styling to clicked tab
        $(this)
            .addClass('active rounded-pill text-white shadow-sm')
            .removeClass('text-dark')
            .css('background-color', '#1c278e');

        var reportType = $(this).data('report');
        loadReportContent(reportType);
    });

    // ================================
    // Auto-load MCU on page load (default active)
    // ================================
    loadReportContent('mcu');
});
</script>
