<div class="crew-rotation-content">
  <div class="container-fluid">
    <style>
    /* ===============================
            GLOBAL TABLE STYLE – CREW PLAN
            =============================== */
    :root {
      --crew-blue: #000099;
      --crew-font-sm: 12px;
      --crew-font-xs: 11px;
    }

    /* TABLE BASE */
    .crew-table th,
    .crew-table td {
      font-size: var(--crew-font-sm);
      vertical-align: middle;
    }

    .crew-table th {
      font-weight: 600;
      text-align: center;
    }

    /* BUTTON INSIDE TABLE */
    .crew-table .btn {
      font-size: var(--crew-font-xs);
      padding: 2px 6px;
    }

    /* HEADER COLOR (BLUE) */
    .crew-header th {
      /* background-color: var(--crew-blue) !important; */
      color: #fff !important;
    }

    /* HEADER GROUP (ONBOARD / REPLACEMENT) */
    .crew-header-group {
      /* background-color: var(--crew-blue) !important; */
      color: #fff !important;
    }

    /* BADGE STATUS */
    .badge-status {
      font-size: 11px;
      padding: 4px 8px;
    }

    .batch-toggle {
      cursor: pointer;
      min-width: 22px;
      font-weight: bold;
      user-select: none;
    }
    .batch-toggle:hover {
      opacity: 0.8;
    }

    /* LINK NAME */
    .crew-name {
      font-weight: 600;
      color: #330000;
      text-decoration: none;
    }

    .crew-name:hover {
      text-decoration: underline;
    }

    /* DataTables Customization */
    .custom-btn {
      justify-content: flex-end;
    }

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

    /* PAGINATION STYLING */
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

    /* INFO TEXT STYLING */
    .dataTables_info {
      padding: 10px 0;
      color: #6c757d;
      font-size: 14px;
    }

    /* Baris search di bawah header (column search) */
    .crew-search-row {
      background: #f8f9fa !important;
    }

    .crew-search-row th {
      background: #f8f9fa !important;
      color: #495057 !important;
      padding: 6px 8px;
      vertical-align: middle;
    }

    .crew-search-row .column-search {
      width: 100%;
      max-width: 160px;
      margin: 0 auto;
      display: block;
    }

    /* Column Search Input */
    .column-search {
      padding: 6px 8px;
      box-sizing: border-box;
      font-size: 12px;
      border: 1px solid #dee2e6;
      border-radius: 4px;
      background: #fff !important;
    }

    /* Responsive Card */
    .card {
      /* max-width: 100%; */
      margin-top: 20px;
      border-radius: 8px;
    }

    .card-header {
      padding: 15px 20px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .card-body {
      padding: 20px;
      overflow-x: visible;
    }

    /* Table responsive fixes */
    .table-responsive {
      margin: 0;
      overflow-x: auto;
      padding-bottom: 20px;
    }

    /* Memastikan tabel selalu 100% dan teks bisa wrap */
    .crew-table {
      width: 100% !important;
      min-width: 100% !important;
      max-width: 100% !important;
      background-color: transparent;
    }
    
    .crew-table th,
    .crew-table td {
      white-space: normal !important;
      word-wrap: break-word !important;
      overflow-wrap: break-word !important;
    }

    /* Custom layout for DataTables controls */
    .dataTables_wrapper .row {
      margin: 0;
    }

    .dataTables_wrapper .col-sm-12 {
      padding: 0;
    }

    /* Ensure proper spacing */
    .dt-length {
      float: left;
    }

    .dt-search {
      float: right;
    }

    .dt-info {
      float: left;
      margin-top: 10px;
    }

    .dt-paging {
      float: right;
      margin-top: 10px;
    }

    /* Clear floats */
    .dataTables_wrapper:after {
      content: "";
      display: table;
      clear: both;
    }
    
    /* Filter Icon */
    .filter-icon {
      cursor: pointer;
      font-size: 14px;
      margin-left: 6px;
      color: #0d6efd;
    }
    
    .filter-dropdown {
      position: absolute;
      background: #fff;
      border: 1px solid #ccc;
      padding: 8px;
      width: 200px;
      max-height: 260px;
      overflow-y: auto;
      box-shadow: 0 4px 10px rgba(0, 0, 0, .2);
      display: none;
      z-index: 9999;
    }
    
    .filter-dropdown input[type="text"] {
      width: 100%;
      margin-bottom: 6px;
      padding: 4px;
      font-size: 12px;
      border: 1px solid #dee2e6;
      border-radius: 4px;
    }
    
    .filter-dropdown label {
      display: block;
      font-size: 13px;
      cursor: pointer;
      padding: 4px 8px;
      margin: 2px 0;
      border-radius: 4px;
    }
    
    .filter-dropdown label:hover {
      background: #f8f9fa;
    }
    
    .filter-list {
      max-height: 120px;
      overflow-y: auto;
      margin-bottom: 6px;
    }
    
    .btn-clear-filter {
      background: transparent;
      border: 1.5px solid #000099;
      color: #000099;
      transition: all .2s ease;
    }
    
    .btn-clear-filter:hover {
      background: #000099;
      color: #fff;
    }
    
    .btn-clear-filter i {
      font-size: 14px;
    }

    /* LINK NAME - hitam, cursor tangan (untuk Next Plan) */
    .crew-name {
      font-weight: 600;
      color: #000;
      text-decoration: none;
      cursor: pointer;
    }

    .crew-name:hover {
      text-decoration: underline;
      color: #333;
    }

    /* Column search inputs - dipaksa bisa mengecil */
    .column-search {
      width: 100% !important;
      min-width: 30px !important;
      padding: 4px !important;
    }
    </style>

    <div class="row">
      <div class="col-md-12">
        <div class="card shadow mb-4">
          <div class="card-body">
            <h6 class="card-title mb-3">Filter Tanggal Rotasi</h6>
            <div class="row align-items-center">
              <div class="col-md-3">
                <input type="date" id="filterStartDate" class="form-control form-control-sm" placeholder="Start Date">
              </div>
              <div class="col-md-1 text-center px-0" style="width: 30px;">
                <span>s/d</span>
              </div>
              <div class="col-md-3">
                <input type="date" id="filterEndDate" class="form-control form-control-sm" placeholder="End Date">
              </div>
              <div class="col-md-4">
                <button type="button" class="btn btn-sm btn-primary" id="btnFilterDate">Terapkan</button>
                <button type="button" class="btn btn-sm btn-danger" id="btnResetDate">Reset</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card shadow">
          <div class="card-body">
            <div class="table-responsive">
              <table id="crewTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100% !important;">
                <thead class="crew-header">
                  <tr>
                    <th rowspan="2" class="text-center align-middle" style="background-color: #000099 !important; color:#fff;">No</th>
                    <th colspan="8" class="text-center fw-bold" style="background-color:#000099 !important; color:#fff; border-bottom: 2px solid white;">ONBOARD</th>
                    <th colspan="6" class="text-center fw-bold" style="background-color:#000099 !important; color:#fff; border-bottom: 2px solid white;">REPLACEMENT</th>
                  </tr>
                  <tr>
                    <th style="background-color: #000099 !important;">Batch <br><span class="filter-icon">☰</span></th>
                    <th style="background-color: #000099 !important;">Type <br><span class="filter-icon">☰</span></th>
                    <th style="background-color: #000099 !important;">Name <br><span class="filter-icon">☰</span></th>
                    <th style="background-color: #000099 !important;">Rank <br><span class="filter-icon">☰</span></th>
                    <th style="background-color: #000099 !important;">S/ON <br><span class="filter-icon">☰</span></th>
                    <th style="background-color: #000099 !important;">Vessel <br><span class="filter-icon">☰</span></th>
                    <th style="background-color: #000099 !important;">S/OFF Plan <br><span class="filter-icon">☰</span></th>
                    <th style="background-color: #000099 !important;">Remark <br><span class="filter-icon">☰</span></th>
                    <th style="background-color: #000099 !important;">Remarks Cancel <br><span class="filter-icon">☰</span></th>
                    <th style="background-color: #000099 !important;">Rank <br><span class="filter-icon">☰</span></th>
                    <th style="background-color: #000099 !important;">Name <br><span class="filter-icon">☰</span></th>
                    <th style="background-color: #000099 !important;">Status <br><span class="filter-icon">☰</span></th>
                    <th style="background-color: #000099 !important;">Next Vessel <br><span class="filter-icon">☰</span></th>
                    <th class="text-center" style="background-color: #000099 !important;">Action</th>
                  </tr>
                  <tr>
                    <th></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th><input type="text" class="column-search" placeholder="Search"></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Data akan diisi oleh DataTables -->
                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Crew Rotation Form -->
<div class="modal fade" id="modalCrewRotationForm" tabindex="-1" aria-labelledby="modalCrewRotationFormLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#000099;">
        <h5 class="modal-title fw-bold" id="modalCrewRotationFormLabel"> Add Crew Rotation</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body mb-0 pb-8 pt-2" id="modalCrewRotationFormBody">
        <!-- Form akan di-load via AJAX -->
        <div class="text-center p-4">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Remarks Cancel -->
<div class="modal fade" id="modalRemarksCancel" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#000099;">
        <h5 class="modal-title">Remarks Cancel</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="remarksCancel_idcrewrotation">
        <label class="form-label fw-semibold">Remarks Cancel</label>
        <textarea class="form-control" id="remarksCancel_input" rows="4"
          placeholder="Alasan / keterangan cancel..."></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btnSubmitRemarksCancel">Submit</button>
      </div>
    </div>
  </div>
</div>

<script>
var baseUrlCrewRotation = "<?php echo base_url('CrewRotation/CrewRotation'); ?>";

function loadCrewRotationList() {
  $.ajax({
    url: baseUrlCrewRotation + "/ajaxCrewRotation",
    type: "GET",
    success: function(html) {
      $("#contentArea").html(html);
    },
    error: function() {
      alert("Gagal memuat Crew Rotation");
    }
  });
}

window.showCrewDetail = function(idcrewrotation, type) {
  $('#modalCrewRotationForm').modal('show');
  // Destroy selectpicker sebelum ganti content (agar dropdown orphan hilang)
  try {
    $('#modalCrewRotationFormBody .selectpicker-on, #modalCrewRotationFormBody .selectpicker-new').each(function() {
      var $el = $(this);
      if ($el.data('selectpicker')) { $el.selectpicker('destroy'); }
    });
  } catch (e) { /* ignore */ }
  $('#modalCrewRotationFormBody').html('<div class="text-center p-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
  
  if (type === 'Down') {
    var ajaxUrl = "<?php echo base_url('CrewRotation/CrewRotation_Down/detail'); ?>";
    $('#modalCrewRotationFormLabel').text('Add Crew Rotation - Down');
  } else if (type === 'New') {
    var ajaxUrl = "<?php echo base_url('CrewRotation/CrewRotation_New/detail'); ?>";
    $('#modalCrewRotationFormLabel').text('Add Crew Rotation - New');
  } else {
    var ajaxUrl = "<?php echo base_url('CrewRotation/CrewRotation/detail'); ?>";
    $('#modalCrewRotationFormLabel').text('Add Crew Rotation - Change');
  }
  
  $.ajax({
    url: ajaxUrl,
    type: "GET",
    data: {
      idcrewrotation: idcrewrotation
    },
    success: function(html) {
      // Hapus orphan bootstrap-select (dropdown/menu) yang mungkin tertinggal di body
      try {
        $('body > .bootstrap-select, body > .dropdown.bootstrap-select').remove();
        $('#modalCrewRotationForm .bootstrap-select').not('#modalCrewRotationFormBody .bootstrap-select').remove();
      } catch (e) { /* ignore */ }
      $('#modalCrewRotationFormBody').html(html);
    },
    error: function() {
      $('#modalCrewRotationFormBody').html('<div class="alert alert-danger">Gagal memuat detail</div>');
    }
  });
};

$(document).ready(function() {
  var collapsedBatches = {};
  var BATCH_COL_INDEX = 1;
  var TOTAL_COLUMNS = 14;

  let table = $('#crewTable').DataTable({
    stateSave: true,
    stateDuration: -1,
    dom: "<'row mb-2'<'col-md-6 d-flex align-items-center'l><'col-md-6 text-end custom-btn'>>" +
      "<'row'<'col-md-12'tr>>" +
      "<'row mt-2'<'col-md-5'i><'col-md-7'p>>",
    processing: true,
    serverSide: false,
    ajax: {
      url: baseUrlCrewRotation + "/getAllData_crewRotation",
      type: "GET",
      dataSrc: function(json) {
        var rows = json.success ? json.data : [];
        var batchIdHasJoined = {};
        rows.forEach(function(r) {
          if ((r.status || "").toUpperCase() === "JOINED") batchIdHasJoined[r.batch_id] = true;
        });
        rows.forEach(function(r) {
          r._batch_has_joined = !!batchIdHasJoined[r.batch_id];
        });
        return rows;
      }
    },
    columns: [
      // No, Batch = dari rotation
      {
        data: null,
        className: "text-center",
        orderable: false,
        render: function(data, type, row, meta) {
          return meta.row + 1;
        }
      },
      {
        data: "batch_id",
        className: "text-center",
        render: function(data) {
          return data || "-";
        }
      },
      {
        data: "status_crew_change",
        className: "text-center",
        render: function(data) {
          var type = data || "Change";
          var badgeClass = type === 'New' ? 'badge bg-success badge-status' : type === 'Down' ? 'badge bg-danger badge-status' : 'badge bg-primary badge-status';
          return '<span class="' + badgeClass + '">' + type + '</span>';
        }
      },
      // Onboard (Name, Rank, S/ON, Vessel, S/Off Plan) = dari Old Contract (tblcontract)
      {
        data: "onboard_name",
        render: function(data, type, row) {
          var name = data || "";
          var textColorClass = row.status_crew_change === 'New' ? 'text-success'  : 'text-black';
          return '<a href="#" class="crew-name ' + textColorClass + '" onclick="showCrewDetail(' + row.idcrewrotation + ', \'' + (row.status_crew_change || 'Change') + '\'); return false;" title="Edit">' + name + "</a>";
        }
      },
      {
        data: "onboard_rank",
        className: "text-center"
      },
      {
        data: "onboard_son",
        className: "text-center"
      },
      {
        data: "onboard_vessel"
      },
      {
        data: "onboard_soff",
        className: "text-center"
      },
      // Remark, Remarks Cancel, Replacement, Status, Next Vessel = dari tblcrewrotation
      {
        data: "remark",
        className: "text-center"
      },
      {
        data: "remarks_cancel",
        className: "text-center"
      },
      {
        data: "replacement_rank",
        className: "text-center"
      },
      {
        data: "replacement_name"
      },
      {
        data: "status",
        className: "text-center",
        render: function(data, type, row) {
          var displayStatus = data;
          var badgeClass = "bg-secondary";
          if (row._batch_has_joined && (data || "").toUpperCase() !== "JOINED") {
            displayStatus = "Delete";
            badgeClass = "bg-dark";
          } else {
            if (data === "Submit") {
              badgeClass = "bg-success";
              displayStatus = "Planned";
            } else if (data === "Cancel") {
              badgeClass = "bg-danger";
              displayStatus = "Cancel";
            } else if (data === "Joined" && row.status_crew_change === 'Down') {
              badgeClass = "bg-warning text-dark";
              displayStatus = "Down";
            } else if (data === "Joined") {
              badgeClass = "bg-primary";
              displayStatus = "Joined";
            } else {
              displayStatus = data || "";
            }
          }
          return '<span class="badge ' + badgeClass + ' badge-status">' + displayStatus + "</span>";
        }
      },
      {
        data: "next_vessel"
      },
      {
        data: null,
        orderable: false,
        searchable: false,
        className: "text-center",
        render: function(data, type, row) {
          var disabled = (row.status === "Cancel" || row.status === "Joined") ? " disabled" : "";
          var joinedLabel = (row.status_crew_change === 'Down') ? 'Down' : 'Joined';
          var statusOpt =
            '<select class="form-select form-select-sm d-inline-block w-auto status-select" data-id="' + row
            .idcrewrotation + '" data-batch-id="' + (row.batch_id || "") + '" data-current="' + (row.status || "") + '"' + disabled + '>' +
            '<option value="Submit"' + (row.status === "Submit" ? " selected" : "") + '>Planned</option>' +
            '<option value="Cancel"' + (row.status === "Cancel" ? " selected" : "") + '>Cancel</option>' +
            '<option value="Joined"' + (row.status === "Joined" ? " selected" : "") +
            '>' + joinedLabel + '</option></select>';
          var editBtnClass = row.status_crew_change === 'New' ? 'btn-outline-success' : row.status_crew_change === 'Down' ? 'btn-outline-danger' : 'btn-outline-primary';
          return '<div class="d-flex gap-1 justify-content-center flex-wrap">' +
            '<button type="button" class="btn btn-sm ' + editBtnClass + '" onclick="showCrewDetail(' + row
            .idcrewrotation + ', \'' + (row.status_crew_change || 'Change') + '\')" title="Detail"><i class="fa fa-edit"></i></button>' +
            statusOpt +
            '<button type="button" class="btn btn-sm btn-outline-danger btn-delete-rotation" data-id="' +
            row.idcrewrotation + '" title="Delete"><i class="fa fa-trash"></i></button></div>';
        }
      }
    ],
    pageLength: 50,
    lengthMenu: [5, 10, 25, 50, 100],
    language: {
      lengthMenu: " _MENU_ &nbsp; Entries",
      search: "",
      info: "Showing _START_ to _END_ of _TOTAL_ entries",
      infoEmpty: "Showing 0 to 0 of 0 entries"
    },
    order: [
      [1, "desc"]
    ],
    createdRow: function(row, data) {
      $(row).attr("data-batch-id", (data.batch_id || "").toString());
    },
    drawCallback: function() {
      var api = this.api();
      var data = api.rows({ page: "current" }).data();
      var nodes = api.rows({ page: "current" }).nodes();
      if (!data.length) return;

      var groups = [];
      var g = [];
      for (var i = 0; i < data.length; i++) {
        var bid = (data[i].batch_id || "").toString();
        var dateFmt = data[i].created_date_fmt || "";
        if (g.length && g[0].batch_id !== bid) {
          groups.push(g);
          g = [];
        }
        g.push({ batch_id: bid, rowIndex: i, node: nodes[i], date_fmt: dateFmt });
      }
      if (g.length) groups.push(g);
      groups.forEach(function(grp) {
        if (grp.length === 0) return;
          var first = grp[0];
          var firstNode = first.node;
          var firstCells = firstNode.getElementsByTagName("td");
          if (firstCells.length <= BATCH_COL_INDEX) return;
          var batchTd = firstCells[BATCH_COL_INDEX];
          var isCollapsed = collapsedBatches[first.batch_id];
          
          for (var j = 0; j < grp.length; j++) {
            var rowCells = grp[j].node.getElementsByTagName("td");
            if (rowCells.length > BATCH_COL_INDEX) {
              rowCells[BATCH_COL_INDEX].style.display = "";
            }
          }

          if (isCollapsed) {
            for (var j = 1; j < grp.length; j++) {
              grp[j].node.style.display = "none";
            }
            var dateHtml = first.date_fmt ? '<br><small class="text-muted">📅 ' + first.date_fmt + '</small>' : '';
            batchTd.rowSpan = 1;
            batchTd.innerHTML = (first.batch_id || "-") + ' <button type="button" class="btn btn-sm btn-link p-0 batch-toggle" data-batch="' + first.batch_id.replace(/"/g, "&quot;") + '" title="Expand">+</button>' + dateHtml;
          } else {
            // Tampilkan semua baris
            for (var j = 0; j < grp.length; j++) {
              grp[j].node.style.display = "";
            }
            // Set rowSpan sesuai jumlah baris
            var dateHtml = first.date_fmt ? '<br><small class="text-muted">📅 ' + first.date_fmt + '</small>' : '';
            batchTd.rowSpan = grp.length;
            batchTd.innerHTML = (first.batch_id || "-") + ' <button type="button" class="btn btn-sm btn-link p-0 batch-toggle" data-batch="' + first.batch_id.replace(/"/g, "&quot;") + '" title="Collapse">−</button>' + dateHtml;
            for (var j = 1; j < grp.length; j++) {
              var rowCells = grp[j].node.getElementsByTagName("td");
              if (rowCells.length > BATCH_COL_INDEX) {
                rowCells[BATCH_COL_INDEX].style.display = "none";
                rowCells[BATCH_COL_INDEX].innerHTML = "";
              }
            }
          }
      });

      $("#crewTable").off("click.batchToggle").on("click.batchToggle", ".batch-toggle", function(e) {
        e.preventDefault();
        e.stopPropagation();
        var batch = $(this).data("batch");
        if (!batch) return;
        collapsedBatches[batch] = !collapsedBatches[batch];
        table.draw(false);
      });
    },
    initComplete: function() {
      $(".dataTables_info").css({
        padding: "10px 0",
        color: "#6c757d",
        "font-size": "14px"
      });
      $(".custom-btn").html(
        '<button type="button" class="btn btn-primary" id="btnNewCrewRotation">' +
        '<i class="fa fa-plus"></i> New</button>'
      );
      initDropdownFilters(this.api());
    }
  });

  // Custom filter function for Date Range
  $.fn.dataTable.ext.search.push(function(settings, data, dataIndex, rowData, counter) {
    if (settings.nTable.id !== 'crewTable') {
        return true;
    }
    
    var min = $('#filterStartDate').val();
    var max = $('#filterEndDate').val();
    var createdAt = rowData.created_date_raw || ""; // Format: YYYY-MM-DD
    
    if (!min && !max) { return true; }
    if (!createdAt) { return false; }
    
    if (min && !max) {
        return createdAt >= min;
    } else if (!min && max) {
        return createdAt <= max;
    } else {
        return createdAt >= min && createdAt <= max;
    }
  });

  $('#btnFilterDate').on('click', function() {
      table.draw();
  });

  $('#btnResetDate').on('click', function() {
      $('#filterStartDate').val('');
      $('#filterEndDate').val('');
      table.draw();
  });

  function initDropdownFilters(table) {

    // Hanya baris header kedua (baris pertama adalah grup ONBOARD/REPLACEMENT)
    var colCount = table.columns().count();
    $('#crewTable thead tr:nth-child(2) th').each(function(index) {
      let icon = $(this).find('.filter-icon');
      if (!icon.length) return;

      // index di row kedua mulai dari Batch (kolom ke-1), karena No (kolom ke-0) menggunakan rowspan dari row 1
      let colIndex = index + 1;

      // Skip No & Action; pastikan index dalam range kolom table
      if (colIndex === 0 || colIndex >= colCount - 1) return;

      let dropdown = $(`
      <div class="filter-dropdown">
        <input type="text" class="filter-search" placeholder="Search...">
        <div class="filter-list"></div>
        <hr>
        <div class="d-flex gap-2 text-center">
          <button
            class="btn btn-sm w-30 apply-filter rounded-pill fst-italic btn-clear-filter" id="clear-filter"> 
            <i class="fa-solid fa-eraser"></i>
          </button>
        </div>

      </div>
    `).appendTo('body');

      let listContainer = dropdown.find('.filter-list');

      // ✅ AMBIL DATA SETELAH TABLE READY; hindari error bila column().data() undefined
      var colData = table.column(colIndex).data();
      if (!colData || typeof colData.unique !== 'function') return;
      colData.unique().sort().each(function(val) {
        if (val) {
          listContainer.append(`
          <label>
            <input type="checkbox" value="${val}"> ${val}
          </label>
        `);
        }
      });

      // Toggle dropdown
      icon.on('click', function(e) {
        e.stopPropagation();
        $('.filter-dropdown').hide();

        let offset = icon.offset();
        dropdown.css({
          top: offset.top + icon.outerHeight(),
          left: offset.left
        }).toggle();
      });

      // Search inside dropdown
      dropdown.find('.filter-search').on('keyup', function() {
        let keyword = $(this).val().toLowerCase();
        listContainer.find('label').each(function() {
          $(this).toggle($(this).text().toLowerCase().includes(keyword));
        });
      });


      dropdown.on('change', 'input[type="checkbox"]', function() {
        let selected = [];
        dropdown.find('input[type="checkbox"]:checked').each(function() {
          selected.push($(this).val());
        });

        if (selected.length > 0) {
          let escapedValues = selected.map(v =>
            v.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')
          );
          let regex = escapedValues.join('|');
          table.column(colIndex).search(regex, true, false).draw();
        } else {
          table.column(colIndex).search('').draw();
        }
        dropdown.show();
        $('.filter-dropdown').hide();
      });


      // Clear filter
      dropdown.on('click', '.btn-clear-filter', function() {
        dropdown.find('input').prop('checked', false);
        dropdown.find('.filter-search').val('');
        listContainer.find('label').show();

        table.column(colIndex).search('').draw();
        dropdown.hide();
      });
    });
  }
  
  $(document).on('click', function(e) {
    if (!$(e.target).closest('.filter-dropdown').length && !$(e.target).closest('.filter-icon').length) {
      $('.filter-dropdown').hide();
    }
  });

  $(document).on("change", ".status-select", function(e) {
    var $sel = $(this);
    var id = $sel.data("id");
    var currentStatus = $sel.data("current");
    var newStatus = $sel.val();
    // Tidak ada perubahan (termasuk saat kita reset setelah tolak Joined→Submit)
    if (newStatus === currentStatus) return;
    if (currentStatus === "Cancel") {
      e.preventDefault();
      e.stopPropagation();
      $sel.val("Cancel");
      if (typeof Swal !== "undefined") {
        Swal.fire({
          icon: "info",
          title: "Tidak dapat diubah",
          text: "Status sudah Cancel. Harus buat data baru."
        });
      } else {
        alert("Status sudah Cancel. Harus buat data baru.");
      }
      return false;
    }
    if (currentStatus === "Joined" && newStatus === "Submit") {
      e.preventDefault();
      e.stopPropagation();
      $sel.val("Joined");
      if (typeof Swal !== "undefined") {
        Swal.fire({
          icon: "warning",
          title: "Tidak dapat diubah",
          text: "Dari Joined tidak bisa kembali ke Submit. Data sudah masuk ke Contract. Hanya bisa di-Cancel jika dibatalkan."
        });
      } else {
        alert("Dari Joined tidak bisa kembali ke Submit. Hanya bisa di-Cancel.");
      }
      return false;
    }
    if (newStatus === "Cancel") {
      e.preventDefault();
      e.stopPropagation();
      if (typeof Swal !== "undefined") {
        Swal.fire({
          icon: "question",
          title: "Ubah ke Cancel?",
          text: "Anda yakin akan mengubah status menjadi Cancel?",
          showCancelButton: true,
          confirmButtonText: "Yes",
          cancelButtonText: "Cancel"
        }).then(function(result) {
          if (result.isConfirmed) {
            $("#remarksCancel_idcrewrotation").val(id);
            $("#remarksCancel_input").val("");
            $("#remarksCancel_feedback").addClass("d-none");
            $("#modalRemarksCancel").modal("show");
          } else {
            $sel.val(currentStatus);
          }
        });
      } else {
        if (confirm("Ubah ke Cancel? Jika Yes, isi Remarks Cancel.")) {
          $("#remarksCancel_idcrewrotation").val(id);
          $("#remarksCancel_input").val("");
          $("#remarksCancel_feedback").addClass("d-none");
          $("#modalRemarksCancel").modal("show");
        } else {
          $sel.val(currentStatus);
        }
      }
      return false;
    }
    $.post(baseUrlCrewRotation + "/updateStatus", {
        idcrewrotation: id,
        status: newStatus
      })
      .done(function(res) {
        var r = typeof res === "string" ? JSON.parse(res) : res;
        if (r.status) {
          table.ajax.reload(null, false);
          if (typeof Swal !== "undefined") Swal.fire({
            icon: "success",
            title: "Berhasil",
            text: r.message
          });
          else alert(r.message);
        } else {
          if (typeof Swal !== "undefined") Swal.fire({
            icon: "error",
            title: "Error",
            text: r.message || "Update failed"
          });
          else alert(r.message || "Update failed");
          $sel.val(currentStatus);
        }
      })
      .fail(function() {
        if (typeof Swal !== "undefined") Swal.fire({
          icon: "error",
          title: "Error",
          text: "Request failed"
        });
        else alert("Request failed");
        $sel.val(currentStatus);
      });
  });

  $("#btnSubmitRemarksCancel").on("click", function() {
    var id = $("#remarksCancel_idcrewrotation").val();
    var remaks = $("#remarksCancel_input").val().trim();
    // Remarks Cancel tidak mandatory, bisa kosong
    $.post(baseUrlCrewRotation + "/updateStatus", {
        idcrewrotation: id,
        status: "Cancel",
        remaks_cancel: remaks
      })
      .done(function(res) {
        var r = typeof res === "string" ? JSON.parse(res) : res;
        $("#modalRemarksCancel").modal("hide");
        if (r.status) {
          table.ajax.reload(null, false);
          if (typeof Swal !== "undefined") Swal.fire({
            icon: "success",
            title: "Berhasil",
            text: r.message
          });
          else alert(r.message);
        } else {
          if (typeof Swal !== "undefined") Swal.fire({
            icon: "error",
            title: "error",
            text: r.message || "Update failed"
          });
          else alert(r.message || "Update failed");
        }
      })
      .fail(function() {
        $("#modalRemarksCancel").modal("hide");
        if (typeof Swal !== "undefined") Swal.fire({
          icon: "error",
          title: "Error",
          text: "Request failed"
        });
        else alert("Request failed");
      });
  });

  $(document).on("click", ".btn-delete-rotation", function(e) {
    e.preventDefault();
    var id = $(this).data("id");
    if (typeof Swal !== "undefined") {
      Swal.fire({
        icon: "warning",
        title: "Hapus data?",
        text: "Yakin akan menghapus crew rotation ini?",
        showCancelButton: true,
        confirmButtonText: "Yes, Hapus",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#d33"
      }).then(function(result) {
        if (result.isConfirmed) {
          $.post(baseUrlCrewRotation + "/delete_crewRotation", {
              idcrewrotation: id
            })
            .done(function(res) {
              var r = typeof res === "string" ? JSON.parse(res) : res;
              if (r.status) {
                table.ajax.reload(null, false);
                Swal.fire({
                  icon: "success",
                  title: "Terhapus",
                  text: r.message || "Data berhasil dihapus."
                });
              } else {
                Swal.fire({
                  icon: "error",
                  title: "Gagal",
                  text: r.message || "Delete failed"
                });
              }
            })
            .fail(function() {
              Swal.fire({
                icon: "error",
                title: "Error",
                text: "Request failed"
              });
            });
        }
      });
    } else {
      if (!confirm("Delete this crew rotation record?")) return false;
      $.post(baseUrlCrewRotation + "/delete_crewRotation", {
          idcrewrotation: id
        })
        .done(function(res) {
          var r = typeof res === "string" ? JSON.parse(res) : res;
          if (r.status) {
            table.ajax.reload(null, false);
          } else {
            alert(r.message || "Delete failed");
          }
        })
        .fail(function() {
          alert("Request failed");
        });
    }
  });

  $(document).on("click", "#btnNewCrewRotation", function() {
    Swal.fire({
      title: 'Tipe Crew Rotation',
      html: `
        <div class="d-flex flex-column text-start gap-2 mt-3">
            <button class="btn btn-outline-primary p-3 text-start d-flex flex-column mb-2" onclick="Swal.clickConfirm()">
                <div class="fw-bold mb-1"><i class="fa fa-exchange-alt me-2"></i>Crew Rotation (Change)</div>
                <small class="text-muted" style="white-space: normal;">Digunakan untuk rotasi normal: menggantikan kru yang sedang Onboard dengan kandidat baru.</small>
            </button>
            <button class="btn btn-outline-success p-3 text-start d-flex flex-column mb-2" onclick="Swal.clickDeny()">
                <div class="fw-bold mb-1"><i class="fa fa-user-plus me-2"></i>Embarkation Only (New)</div>
                <small class="text-muted" style="white-space: normal;">Digunakan untuk memberangkatkan kru baru (sign-on) untuk mengisi kekosongan, tanpa ada kru yang turun.</small>
            </button>
            <button class="btn btn-outline-warning text-dark p-3 text-start d-flex flex-column" onclick="Swal.clickCancel()">
                <div class="fw-bold mb-1"><i class="fa fa-arrow-down me-2"></i>Disembarkation Only (Down)</div>
                <small class="text-muted" style="white-space: normal;">Digunakan untuk memulangkan kru (sign-off) tanpa ada kandidat penggantinya.</small>
            </button>
        </div>
      `,
      icon: 'question',
      scrollbarPadding: false,
      showConfirmButton: false,
      showDenyButton: false,
      showCancelButton: false,
      showCloseButton: true,
      width: '32em'
    }).then((result) => {
      var endpoint = "";
      if (result.isConfirmed) {
        endpoint = baseUrlCrewRotation + "/detail"; // Old Change flow
        $('#modalCrewRotationFormLabel').text('Add Crew Rotation - Change');
      } else if (result.isDenied) {
        var rootUrl = baseUrlCrewRotation.replace('/CrewRotation/CrewRotation', '');
        endpoint = rootUrl + "/CrewRotation/CrewRotation_New/detail"; 
        $('#modalCrewRotationFormLabel').text('Add Crew Rotation - Embarkation Only (New)');
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        var rootUrl = baseUrlCrewRotation.replace('/CrewRotation/CrewRotation', '');
        endpoint = rootUrl + "/CrewRotation/CrewRotation_Down/detail"; 
        $('#modalCrewRotationFormLabel').text('Add Crew Rotation - Disembarkation Only (Down)');
      } else {
        return;
      }
      
      $('#modalCrewRotationForm').modal('show');
      // Destroy selectpicker sebelum ganti content (agar dropdown orphan hilang)
      try {
        $('#modalCrewRotationFormBody .selectpicker-on, #modalCrewRotationFormBody .selectpicker-new').each(function() {
          var $el = $(this);
          if ($el.data('selectpicker')) { $el.selectpicker('destroy'); }
        });
      } catch (e) { /* ignore */ }
      $('#modalCrewRotationFormBody').html('<div class="text-center p-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
      
      $.ajax({
        url: endpoint,
        type: "GET",
        success: function(html) {
          try {
            $('body > .bootstrap-select, body > .dropdown.bootstrap-select').remove();
            $('#modalCrewRotationForm .bootstrap-select').not('#modalCrewRotationFormBody .bootstrap-select').remove();
          } catch (e) { /* ignore */ }
          $('#modalCrewRotationFormBody').html(html);
        },
        error: function() {
          $('#modalCrewRotationFormBody').html('<div class="alert alert-danger">Gagal memuat form</div>');
        }
      });
    });
  });
  
  // Event handler untuk reload table setelah save
  $(document).on('crewRotationSaved', function() {
    if (typeof table !== 'undefined') {
      table.ajax.reload(null, false);
    }
  });
  
  // Column search (baris search di bawah header)
  $("#crewTable thead tr:last th").each(function(i) {
    var $input = $(this).find("input.column-search");
    if (!$input.length) return;
    $input.on("keyup change", function() {
      if (table.column(i).search() !== this.value) {
        table.column(i).search(this.value).draw();
      }
    });
  });

});
</script>