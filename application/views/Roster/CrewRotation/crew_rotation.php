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
        background-color: var(--crew-blue) !important;
        color: #fff !important;
      }

      /* HEADER GROUP (ONBOARD / REPLACEMENT) */
      .crew-header-group {
        background-color: var(--crew-blue) !important;
        color: #fff !important;
      }

      /* BADGE STATUS */
      .badge-status {
        font-size: 11px;
        padding: 4px 8px;
      }

      /* LINK NAME */
      .crew-name {
        font-weight: 600;
        color: #0d6efd;
        text-decoration: none;
      }

      .crew-name:hover {
        text-decoration: underline;
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

      /* Column Search Input */
      .column-search {
        width: 100%;
        padding: 6px 8px;
        box-sizing: border-box;
        font-size: 12px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        background: #f8f9fa;
      }

      /* Responsive Card */
      .card {
        margin-top: 20px;
        border-radius: 8px;
      }

      .card-header {
        padding: 15px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      }

      .card-body {
        padding: 20px;
        overflow-x: auto;
      }

      /* Table responsive fixes */
      .table-responsive {
        margin: 0;
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
    </style>

    <div class="row">
      <div class="col-md-12">
        <div class="card shadow">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <!-- <h6 class="mb-0 fw-semibold fst-italic">Crew Rotation Plan</h6> -->
              <!-- <button type="button" class="btn btn-sm btn-primary rounded-pill fst-italic" id="btnNewCrewRotation">
                <i class="fa fa-plus"></i> New
              </button> -->
            </div>
            <div class="table-responsive">
              <table id="crewTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                  <tr>
                    <th rowspan="2">No</th>
                    <th colspan="5" class="crew-header-group text-center">ONBOARD</th>
                    <th colspan="3" class="crew-header-group text-center">REPLACEMENT</th>
                    <th rowspan="2">Status</th>
                    <th rowspan="2">Next Vessel</th>
                    <th rowspan="2" class="text-center">Action</th>
                  </tr>
                  <tr>
                    <th>Name <span class="filter-icon">☰</span></th>
                    <th>Rank <span class="filter-icon">☰</span></th>
                    <th>S/ON <span class="filter-icon">☰</span></th>
                    <th>Vessel <span class="filter-icon">☰</span></th>
                    <th>S/OFF Plan <span class="filter-icon">☰</span></th>
                    <th>Remark <span class="filter-icon">☰</span></th>
                    <th>Rank <span class="filter-icon">☰</span></th>
                    <th>Name <span class="filter-icon">☰</span></th>
                  </tr>
                </thead>

                <!-- Search Row -->
                <thead>
                  <tr>
                    <th></th>
                    <th><input type="text" class="column-search" placeholder="Search Name"></th>
                    <th><input type="text" class="column-search" placeholder="Search Rank"></th>
                    <th><input type="text" class="column-search" placeholder="Search S/ON"></th>
                    <th><input type="text" class="column-search" placeholder="Search Vessel"></th>
                    <th><input type="text" class="column-search" placeholder="Search S/OFF"></th>
                    <th><input type="text" class="column-search" placeholder="Search Remark"></th>
                    <th><input type="text" class="column-search" placeholder="Search Rank"></th>
                    <th><input type="text" class="column-search" placeholder="Search Name"></th>
                    <th><input type="text" class="column-search" placeholder="Search Status"></th>
                    <th><input type="text" class="column-search" placeholder="Search Next Vessel"></th>
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

<script>
  var baseUrlCrewRotation = "<?php echo base_url('CrewRotation/CrewRotation'); ?>";

  function loadCrewRotationList() {
    $.ajax({
      url: baseUrlCrewRotation + "/ajaxCrewRotation",
      type: "GET",
      success: function (html) {
        $("#contentArea").html(html);
      },
      error: function () {
        alert("Gagal memuat Crew Rotation");
      }
    });
  }

  window.showCrewDetail = function (idcrewrotation) {
    $.ajax({
      url: baseUrlCrewRotation + "/detail",
      type: "GET",
      data: { idcrewrotation: idcrewrotation },
      success: function (html) {
        $("#contentArea").html(html);
      },
      error: function () {
        $("#contentArea").html('<div class="alert alert-danger">Gagal memuat detail</div>');
      }
    });
  };

  $(document).ready(function () {
    let table = $('#crewTable').DataTable({
      processing: true,
      serverSide: false,
      ajax: {
        url: baseUrlCrewRotation + "/getAllData_crewRotation",
        type: "GET",
        dataSrc: function (json) {
          return json.success ? json.data : [];
        }
      },
      columns: [
        {
          data: null,
          className: "text-center",
          orderable: false,
          render: function (data, type, row, meta) {
            return meta.row + 1;
          }
        },
        {
          data: "onboard_name",
          render: function (data, type, row) {
            var name = data || "-";
            return '<a href="#" class="crew-name" onclick="showCrewDetail(' + row.idcrewrotation + '); return false;">' + name + "</a>";
          }
        },
        { data: "onboard_rank", className: "text-center" },
        { data: "onboard_son", className: "text-center" },
        { data: "onboard_vessel" },
        { data: "onboard_soff", className: "text-center" },
        { data: "remark", className: "text-center" },
        { data: "replacement_rank", className: "text-center" },
        { data: "replacement_name" },
        {
          data: "status",
          className: "text-center",
          render: function (data) {
            var badgeClass = "bg-secondary";
            if (data === "Submit") badgeClass = "bg-success";
            else if (data === "Cancel") badgeClass = "bg-danger";
            else if (data === "Joined") badgeClass = "bg-primary";
            return '<span class="badge ' + badgeClass + ' badge-status">' + (data || "") + "</span>";
          }
        },
        { data: "next_vessel" },
        {
          data: null,
          orderable: false,
          searchable: false,
          className: "text-center",
          render: function (data, type, row) {
            var statusOpt = '<select class="form-select form-select-sm d-inline-block w-auto status-select" data-id="' + row.idcrewrotation + '">' +
              '<option value="Submit"' + (row.status === "Submit" ? " selected" : "") + '>Submit</option>' +
              '<option value="Cancel"' + (row.status === "Cancel" ? " selected" : "") + '>Cancel</option>' +
              '<option value="Joined"' + (row.status === "Joined" ? " selected" : "") + '>Joined</option></select>';
            return '<div class="d-flex gap-1 justify-content-center flex-wrap">' +
              '<button type="button" class="btn btn-sm btn-outline-primary" onclick="showCrewDetail(' + row.idcrewrotation + ')" title="Detail"><i class="fa fa-eye"></i></button>' +
              statusOpt +
              '<button type="button" class="btn btn-sm btn-outline-danger btn-delete-rotation" data-id="' + row.idcrewrotation + '" title="Delete"><i class="fa fa-trash"></i></button></div>';
          }
        }
      ],
      pageLength: 10,
      lengthMenu: [5, 10, 25, 50, 100],
      language: {
        lengthMenu: " _MENU_ &nbsp; Entries",
        search: "Search:",
        paginate: { first: "First", last: "Last", next: "Next", previous: "Previous" },
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
        infoEmpty: "Showing 0 to 0 of 0 entries"
      },
      order: [[1, "asc"]],
      initComplete: function () {
        $(".dataTables_info").css({ padding: "10px 0", color: "#6c757d", "font-size": "14px" });
      }
    });

    $(document).on("change", ".status-select", function () {
      var id = $(this).data("id");
      var status = $(this).val();
      $.post(baseUrlCrewRotation + "/updateStatus", { idcrewrotation: id, status: status })
        .done(function (res) {
          var r = typeof res === "string" ? JSON.parse(res) : res;
          if (r.status) {
            table.ajax.reload(null, false);
          } else {
            alert(r.message || "Update failed");
          }
        })
        .fail(function () {
          alert("Request failed");
        });
    });

    $(document).on("click", ".btn-delete-rotation", function () {
      var id = $(this).data("id");
      if (!confirm("Delete this crew rotation record?")) return;
      $.post(baseUrlCrewRotation + "/delete_crewRotation", { idcrewrotation: id })
        .done(function (res) {
          var r = typeof res === "string" ? JSON.parse(res) : res;
          if (r.status) {
            table.ajax.reload(null, false);
          } else {
            alert(r.message || "Delete failed");
          }
        })
        .fail(function () {
          alert("Request failed");
        });
    });

    $("#btnNewCrewRotation").on("click", function () {
      $.ajax({
        url: baseUrlCrewRotation + "/detail",
        type: "GET",
        success: function (html) {
          $("#contentArea").html(html);
        },
        error: function () {
          alert("Gagal memuat form");
        }
      });
    });

    // Column Search Functionality /klo ga pake row span bisa gini
    // $('#crewTable thead tr:eq(1) th').each(function (i) {
    //   $('input', this).on('keyup change', function () {
    //     if (table.column(i).search() !== this.value) {
    //       table
    //          .column(i)
    //         .search(this.value)
    //         .draw();
    //     }
    //   });
    // });

    // Column search (search row is the last thead tr)
    $("#crewTable thead tr:last th").each(function (i) {
      $("input", this).on("keyup change", function () {
        if (table.column(i).search() !== this.value) {
          table.column(i).search(this.value).draw();
        }
      });
    });


    // Filter Dropdown Implementation
    $('#crewTable thead th').each(function (colIndex) {
      let icon = $(this).find('.filter-icon');
      if (!icon.length) return;

      // Skip the first column (No)
      if (colIndex === 0) return;

      // Create dropdown
      let dropdown = $(`
            <div class="filter-dropdown" data-column="${colIndex}">
                <input type="text" class="filter-search" placeholder="Search...">
                <div class="filter-list"></div>
                <hr>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-primary w-100 apply-filter">
                        Apply
                    </button>
                  <button class="btn btn-sm btn-danger w-100 clear-filter">
                  Clear
                </button>
                </div>
            </div>
        `).appendTo('body');

      let listContainer = dropdown.find('.filter-list');

      // Get unique data for this column
      let column = table.column(colIndex);
      let uniqueData = column.data().unique().sort();

      uniqueData.each(function (val) {
        if (val) {
          listContainer.append(`
                    <label>
                        <input type="checkbox" value="${val}"> ${val}
                    </label>
                `);
        }
      });

      // Toggle dropdown
      icon.on('click', function (e) {
        e.stopPropagation();
        $('.filter-dropdown').hide();

        let offset = icon.offset();
        dropdown.css({
          top: offset.top + icon.outerHeight(),
          left: offset.left
        }).toggle();
      });

      // Prevent dropdown from closing when clicking inside
      dropdown.on('click', function (e) {
        e.stopPropagation();
      });

      // Search inside filter
      dropdown.find('.filter-search').on('keyup', function () {
        let keyword = $(this).val().toLowerCase();
        listContainer.find('label').each(function () {
          $(this).toggle($(this).text().toLowerCase().includes(keyword));
        });
      });

      // Clear filter
      dropdown.on('click', '.clear-filter', function (e) {
        e.stopPropagation();
        dropdown.find('input[type="checkbox"]').prop('checked', false);
        dropdown.find('.filter-search').val('');
        dropdown.find('label').show();
        table.column(colIndex).search('').draw();
        dropdown.hide();
      });

      // Apply filter
      dropdown.on('click', '.apply-filter', function () {
        let selected = [];

        dropdown.find('input[type="checkbox"]:checked').each(function () {
          selected.push($(this).val());
        });

        if (selected.length > 0) {
          // Escape regex special characters
          let escapedValues = selected.map(function (value) {
            return value.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
          });
          let regex = escapedValues.join('|');
          table.column(colIndex).search(regex, true, false).draw();
        } else {
          table.column(colIndex).search('').draw();
        }
        dropdown.hide();
      });
    });

    // Close dropdown when clicking outside
    $(document).on('click', function () {
      $('.filter-dropdown').hide();
    });

  });
</script>