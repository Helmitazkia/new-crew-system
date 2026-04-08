<div class="row w-100 m-0">
    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 sidebar-report border-end py-3">
        <ul class="nav flex-column nav-pills text-center" id="reportTabs">
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="printcv">Print CV</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="acceptentce">Acceptentce Letter</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="covid19">Covid 19 Prevention</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="defreafing">Defreafing</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link active rounded-pill text-white fw-bold fst-italic shadow-sm" style="background-color: #1c278e;" href="#" data-report="mcu">MCU</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="letterstatement">Letter Statemment</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="statementemploye">Statement Of Employe</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="transmital">Transmital</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="statementwages">Statement Of Wages</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="covid19_2">Covid 19 Prevention</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="pkl">PKL</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="spj">SPJ</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="databank">Data Bank</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="statementemployment">Statement of Employment</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="mlcdeclaration">MLC Declaration Form</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="seafarer">Seafarer Employment Agreement</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="vaccine">Vaccine</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark fw-bold fst-italic" href="#" data-report="perfeval">Perfom Evaluation</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 col-lg-10 p-3" id="mainReportContent" style="min-height: 80vh;">
        <!-- Default MCU Content -->
        <div id="mcuContent">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                <table id="mcuTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                    <thead class="crew-header">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Name Klinik</th>
                            <th class="text-center">Date Mcu</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Remaks Reject</th>
                            <th class="text-center">Date Approve / Reject</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th></th>
                            <th><input type="text" class="column-search" placeholder="Search"></th>
                            <th><input type="text" class="column-search" placeholder="Search"></th>
                            <th><input type="text" class="column-search" placeholder="Search"></th>
                            <th><input type="text" class="column-search" placeholder="Search"></th>
                            <th><input type="text" class="column-search" placeholder="Search"></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold text-center">1</td>
                            <td class="text-center">(000003) SUJIWA</td>
                            <td class="text-center">(000003) SUJIWA</td>
                            <td class="text-center"><span class="badge text-bg-success">Approve</span></td>
                            <td></td>
                            <td class="fw-bold text-center">09 Jan 2026 13:41:55</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-primary btn-view-data" title="Detail"><i class="fa fa-eye"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete-data" title="Delete"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-center">2</td>
                            <td class="text-center">(000003) SUJIWA</td>
                            <td class="text-center">(000003) SUJIWA</td>
                            <td class="text-center"><span class="badge text-bg-danger">Rejected</span></td>
                            <td class="text-dark text-center" style="font-size: 12px;">Tolong di check lagi ya , kurang lengkap</td>
                            <td class="fw-bold text-center">10 Jan 2026 13:41:55</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-primary btn-view-data" title="Detail"><i class="fa fa-eye"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-delete-data" title="Delete"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                    </div>
                </div>
            </div>
        </div>
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

/* Table Styles (Matching Certificates) */
.crew-table th,
.crew-table td {
  font-size: var(--crew-font-sm);
  vertical-align: middle;
}
.crew-table th {
  font-weight: 600;
  text-align: center;
}
.crew-table .btn {
  font-size: var(--crew-font-xs);
  padding: 4px 8px; /* Slightly larger padding for typical icons */
}
.crew-header th {
  background-color: var(--crew-blue) !important;
  color: #fff !important;
}
.crew-header-group {
  background-color: var(--crew-blue) !important;
  color: #fff !important;
}

/* Column Search Input Styling */
.column-search {
  width: 100%;
  padding: 4px;
  border: 1px solid #ced4da;
  border-radius: 4px;
  font-size: 11px;
}

/* DataTables Customization */
.dataTables_wrapper {
  padding: 15px 0;
}
.dataTables_length {
  padding: 10px 0;
  margin-bottom: 10px;
}
.dataTables_length label,
.dataTables_filter label {
  display: flex;
  align-items: center;
  margin: 0;
  padding: 20px 0;
}
.dataTables_length select {
  width: auto;
  margin: 0 8px;
  padding: 4px 8px;
  border-radius: 4px;
  border: 1px solid #ced4da;
}
.dataTables_filter {
  text-align: right;
  margin-bottom: 10px;
}
.dataTables_filter label {
  display: inline-flex;
  align-items: center;
  margin: 0;
  padding: 8px 0;
  font-weight: normal;
}
.dataTables_filter input {
  margin-left: 10px;
  padding: 6px 12px;
  border-radius: 4px;
  border: 1px solid #ced4da;
  width: 200px;
}
.dataTables_paginate {
  margin-top: 15px;
  padding-top: 10px;
  border-top: 1px solid #dee2e6;
}
.paginate_button {
  margin: 0 2px;
  padding: 6px 12px !important;
  border-radius: 4px;
  border: 1px solid #dee2e6;
  background: #fff !important;
  color: #0d6efd !important;
  cursor: pointer;
}
.paginate_button.current {
  background: #0d6efd !important;
  color: #fff !important;
  border-color: #0d6efd !important;
}
.paginate_button:hover {
  background: #e9ecef !important;
  border-color: #dee2e6;
}
.dataTables_info {
  padding: 10px 0;
  color: #6c757d;
  font-size: 14px;
}
</style>

<script>
$(document).ready(function() {

    // === Datatables Initialization ===
    let mcuTable = $('#mcuTable').DataTable({
        searching: true,
        paging: true,
        info: true,
        lengthChange: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        initComplete: function() {
            this.api().columns().every(function() {
                var column = this;
                var header = $(column.header());
                if (header.find('.column-search').length) {
                    var input = header.find('.column-search');
                    input.on('keyup change', function() {
                        if (column.search() !== this.value) {
                            column.search(this.value).draw();
                        }
                    });
                }
            });
        },
        language: {
            lengthMenu: '_MENU_ &nbsp;Entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            infoEmpty: 'Showing 0 to 0 of 0 entries',
            infoFiltered: '(filtered from _MAX_ total entries)',
            search: 'Search:'
        }
    });

    // Handle column search sync if input value changes dynamically
    $('#mcuTable thead tr:last th').each(function(i) {
        $('input', this).on('keyup change', function() {
            if (mcuTable.column(i).search() !== this.value) {
                mcuTable
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    });

    // === Navigation logic for the report sidebar ===
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
        
        // FUTURE: Load content dynamically via AJAX based on 'reportType'
        
        // For now, since only MCU has dummy UI built locally here:
        if (reportType === 'mcu') {
            $('#mcuContent').show();
        } else {
            $('#mcuContent').hide();
            $('.report-placeholder').remove(); 
            $('#mainReportContent').append('<div class="report-placeholder text-center mt-5 text-muted"><h5>Content for ' + $(this).text() + ' is not ready yet.</h5></div>');
        }
    });

});
</script>
