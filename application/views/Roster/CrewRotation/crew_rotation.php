<div class="crew-rotation-content">
  <div class="container-fluid">


    </style>
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
          <!-- <div class="card-header bg-success text-white fw-semibold d-flex justify-content-between align-items-center" style="padding: 15px 20px;">
                        <span>👨‍✈️ Crew Rotation Plan</span>
                        <div class="d-flex gap-2">
                            <button class="btn btn-light btn-sm" onclick="exportTable()">
                                <i class="fas fa-download"></i> Export
                            </button>
                            <button class="btn btn-light btn-sm" onclick="reloadTable()">
                                <i class="fas fa-sync-alt"></i> Refresh
                            </button>
                        </div>
                    </div> -->

          <div class="card-body">
            <div class="table-responsive">
              <table id="crewTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                  <tr>
                    <th rowspan="2">No</th>
                    <th colspan="5" class="crew-header-group text-center">ONBOARD</th>
                    <th colspan="3" class="crew-header-group text-center">REPLACEMENT</th>
                    <th rowspan="2">Status</th>
                    <th rowspan="2">Next Vessel</th>
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
  $(document).ready(function () {
    // Data dummy untuk crew rotation
    const crewData = [{
        no: 1,
        onboard_name: "Jefri Bernadus",
        onboard_rank: "A/B",
        onboard_son: "17-10-2025",
        onboard_vessel: "MT. ANDHIKA VIDYANATA",
        onboard_soff: "17-07-2026",
        remark: "Planned",
        replacement_rank: "A/B",
        replacement_name: "-",
        status: "Submit",
        next_vessel: "MT. ANDHIKA VIDYANATA"
      },
      {
        no: 2,
        onboard_name: "Hardi Rama",
        onboard_rank: "A/B",
        onboard_son: "17-10-2025",
        onboard_vessel: "MT. ANDHIKA VIDYANATA",
        onboard_soff: "17-07-2026",
        remark: "Planned",
        replacement_rank: "A/B",
        replacement_name: "-",
        status: "Cancel",
        next_vessel: "MT. ANDHIKA VIDYANATA"
      },
      {
        no: 3,
        onboard_name: "Hardi Rama",
        onboard_rank: "A/B",
        onboard_son: "17-10-2025",
        onboard_vessel: "MT. ANDHIKA VIDYANATA",
        onboard_soff: "17-07-2026",
        remark: "Planned",
        replacement_rank: "A/B",
        replacement_name: "-",
        status: "Joined",
        next_vessel: "MT. ANDHIKA VIDYANATA"
      },
      {
        no: 4,
        onboard_name: "Ahmad Yani",
        onboard_rank: "Captain",
        onboard_son: "15-01-2025",
        onboard_vessel: "MV. OCEAN STAR",
        onboard_soff: "15-10-2025",
        remark: "Confirmed",
        replacement_rank: "Captain",
        replacement_name: "Budi Santoso",
        status: "Submit",
        next_vessel: "MV. SEA BREEZE"
      },
      {
        no: 5,
        onboard_name: "Siti Nurhaliza",
        onboard_rank: "Chief Officer",
        onboard_son: "20-02-2025",
        onboard_vessel: "MT. SAMUDERA JAYA",
        onboard_soff: "20-11-2025",
        remark: "Pending",
        replacement_rank: "Chief Officer",
        replacement_name: "Rina Melati",
        status: "Pending",
        next_vessel: "MT. SAMUDERA JAYA"
      },
      {
        no: 6,
        onboard_name: "Rudi Hartono",
        onboard_rank: "Chief Engineer",
        onboard_son: "10-03-2025",
        onboard_vessel: "MV. GLOBAL TRADER",
        onboard_soff: "10-12-2025",
        remark: "Emergency",
        replacement_rank: "Chief Engineer",
        replacement_name: "Joko Widodo",
        status: "Emergency",
        next_vessel: "MV. GLOBAL TRADER"
      },
      {
        no: 7,
        onboard_name: "Dewi Sartika",
        onboard_rank: "2nd Officer",
        onboard_son: "05-04-2025",
        onboard_vessel: "MT. BAHARI MANDIRI",
        onboard_soff: "05-01-2026",
        remark: "Planned",
        replacement_rank: "2nd Officer",
        replacement_name: "-",
        status: "Submit",
        next_vessel: "MT. BAHARI MANDIRI"
      },
      {
        no: 8,
        onboard_name: "Bambang Pamungkas",
        onboard_rank: "Oiler",
        onboard_son: "25-05-2025",
        onboard_vessel: "MV. MARINE EXPRESS",
        onboard_soff: "25-02-2026",
        remark: "Standby",
        replacement_rank: "Oiler",
        replacement_name: "Andi Sukirman",
        status: "Standby",
        next_vessel: "MV. MARINE EXPRESS"
      },
      {
        no: 9,
        onboard_name: "Maya Sari",
        onboard_rank: "Cook",
        onboard_son: "12-06-2025",
        onboard_vessel: "MT. NUSANTARA PRIDE",
        onboard_soff: "12-03-2026",
        remark: "Planned",
        replacement_rank: "Cook",
        replacement_name: "Sari Dewi",
        status: "Submit",
        next_vessel: "MT. NUSANTARA PRIDE"
      },
      {
        no: 10,
        onboard_name: "Eko Prasetyo",
        onboard_rank: "Bosun",
        onboard_son: "30-07-2025",
        onboard_vessel: "MV. PACIFIC WAVE",
        onboard_soff: "30-04-2026",
        remark: "Confirmed",
        replacement_rank: "Bosun",
        replacement_name: "-",
        status: "Joined",
        next_vessel: "MV. PACIFIC WAVE"
      },
      {
        no: 11,
        onboard_name: "Linda Permata",
        onboard_rank: "Radio Officer",
        onboard_son: "18-08-2025",
        onboard_vessel: "MT. ASIA TRADER",
        onboard_soff: "18-05-2026",
        remark: "Pending",
        replacement_rank: "Radio Officer",
        replacement_name: "Rita Anggraini",
        status: "Pending",
        next_vessel: "MT. ASIA TRADER"
      },
      {
        no: 12,
        onboard_name: "Agus Salim",
        onboard_rank: "3rd Engineer",
        onboard_son: "22-09-2025",
        onboard_vessel: "MV. OCEAN MASTER",
        onboard_soff: "22-06-2026",
        remark: "Planned",
        replacement_rank: "3rd Engineer",
        replacement_name: "Tono Wijaya",
        status: "Submit",
        next_vessel: "MV. OCEAN MASTER"
      },
      {
        no: 13,
        onboard_name: "Rina Marlina",
        onboard_rank: "Steward",
        onboard_son: "14-10-2025",
        onboard_vessel: "MT. MARITIM JAYA",
        onboard_soff: "14-07-2026",
        remark: "Standby",
        replacement_rank: "Steward",
        replacement_name: "Dini Cahaya",
        status: "Standby",
        next_vessel: "MT. MARITIM JAYA"
      },
      {
        no: 14,
        onboard_name: "Fajar Nugroho",
        onboard_rank: "Electrical Officer",
        onboard_son: "08-11-2025",
        onboard_vessel: "MV. GLOBAL HOPE",
        onboard_soff: "08-08-2026",
        remark: "Emergency",
        replacement_rank: "Electrical Officer",
        replacement_name: "Hendra Gunawan",
        status: "Emergency",
        next_vessel: "MV. GLOBAL HOPE"
      },
      {
        no: 15,
        onboard_name: "Citra Lestari",
        onboard_rank: "Deck Cadet",
        onboard_son: "03-12-2025",
        onboard_vessel: "MT. SAMUDERA MAKMUR",
        onboard_soff: "03-09-2026",
        remark: "Planned",
        replacement_rank: "Deck Cadet",
        replacement_name: "-",
        status: "Submit",
        next_vessel: "MT. SAMUDERA MAKMUR"
      },
      {
        no: 16,
        onboard_name: "Hendra Kusuma",
        onboard_rank: "Engine Cadet",
        onboard_son: "19-01-2025",
        onboard_vessel: "MV. MARINE KING",
        onboard_soff: "19-10-2025",
        remark: "Confirmed",
        replacement_rank: "Engine Cadet",
        replacement_name: "Wawan Setiawan",
        status: "Joined",
        next_vessel: "MV. MARINE KING"
      },
      {
        no: 17,
        onboard_name: "Sari Indah",
        onboard_rank: "Nurse",
        onboard_son: "11-02-2025",
        onboard_vessel: "MT. MEDICAL SHIP",
        onboard_soff: "11-11-2025",
        remark: "Pending",
        replacement_rank: "Nurse",
        replacement_name: "Mira Utami",
        status: "Pending",
        next_vessel: "MT. MEDICAL SHIP"
      },
      {
        no: 18,
        onboard_name: "Joko Susilo",
        onboard_rank: "Welder",
        onboard_son: "27-03-2025",
        onboard_vessel: "MV. INDUSTRIAL ONE",
        onboard_soff: "27-12-2025",
        remark: "Planned",
        replacement_rank: "Welder",
        replacement_name: "Slamet Riyadi",
        status: "Submit",
        next_vessel: "MV. INDUSTRIAL ONE"
      },
      {
        no: 19,
        onboard_name: "Dian Pelangi",
        onboard_rank: "Purser",
        onboard_son: "09-04-2025",
        onboard_vessel: "MT. PASSENGER EXPRESS",
        onboard_soff: "09-01-2026",
        remark: "Standby",
        replacement_rank: "Purser",
        replacement_name: "-",
        status: "Standby",
        next_vessel: "MT. PASSENGER EXPRESS"
      },
      {
        no: 20,
        onboard_name: "Teguh Prakoso",
        onboard_rank: "Safety Officer",
        onboard_son: "23-05-2025",
        onboard_vessel: "MV. SAFETY FIRST",
        onboard_soff: "23-02-2026",
        remark: "Planned",
        replacement_rank: "Safety Officer",
        replacement_name: "Adi Wijaya",
        status: "Submit",
        next_vessel: "MV. SAFETY FIRST"
      }
    ];

    // Inisialisasi DataTable
    let table = $('#crewTable').DataTable({
      data: crewData,
      columns: [{
          data: 'no',
          className: 'text-center'
        },
        {
          data: 'onboard_name',
          render: function (data, type, row) {
            return `<a href="#" class="crew-name" onclick="showCrewDetail(${row.no})">${data}</a>`;
          }
        },
        {
          data: 'onboard_rank',
          className: 'text-center'
        },
        {
          data: 'onboard_son',
          className: 'text-center'
        },
        {
          data: 'onboard_vessel'
        },
        {
          data: 'onboard_soff',
          className: 'text-center'
        },
        {
          data: 'remark',
          className: 'text-center'
        },
        {
          data: 'replacement_rank',
          className: 'text-center'
        },
        {
          data: 'replacement_name'
        },
        {
          data: 'status',
          className: 'text-center',
          render: function (data) {
            let badgeClass = 'bg-secondary';
            if (data === 'Submit') badgeClass = 'bg-success';
            else if (data === 'Cancel') badgeClass = 'bg-danger';
            else if (data === 'Joined') badgeClass = 'bg-primary';
            else if (data === 'Pending') badgeClass = 'bg-warning';
            else if (data === 'Emergency') badgeClass = 'bg-danger';
            else if (data === 'Standby') badgeClass = 'bg-info';

            return `<span class="badge ${badgeClass} badge-status">${data}</span>`;
          }
        },
        {
          data: 'next_vessel'
        }
      ],
      pageLength: 10,
      lengthMenu: [5, 10, 25, 50, 100],
      language: {
        lengthMenu: ' _MENU_ &nbsp; Entries',
        search: "Search:",
        paginate: {
          first: "First",
          last: "Last",
          next: "Next",
          previous: "Previous"
        },
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
        infoEmpty: "Showing 0 to 0 of 0 entries",
      },
      order: [
        [0, 'asc']
      ],
     /// dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>><"row"<"col-sm-12"tr>><"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
      initComplete: function () {
        // Custom styling untuk info text
        var info = this.api().page.info();
        $('.dataTables_info').css({
          'padding': '10px 0',
          'color': '#6c757d',
          'font-size': '14px'
        });
      }
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

    // Column Search - AMBIL ROW SEARCH TERAKHIR
    $('#crewTable thead tr:last th').each(function (i) {
      $('input', this).on('keyup change', function () {
        if (table.column(i).search() !== this.value) {
          table
            .column(i)
            .search(this.value)
            .draw();
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

           // CLEAR FILTER
      dropdown.on('click', '.clear-filter', function (e) {
        e.stopPropagation();

        // uncheck semua checkbox
        dropdown.find('input[type="checkbox"]').prop('checked', false);

        // clear search dalam dropdown
        dropdown.find('.filter-search').val('');
        dropdown.find('label').show();

        // clear filter DataTable kolom ini
        table.column(colIndex).search('').draw();
        dropdown.hide();
    });

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

    // Function to show crew detail
    window.showCrewDetail = function (crewNo) {
      alert(`Showing details for crew #${crewNo}`);
      // In actual implementation, you would show a modal or redirect
      // $('#nextPlanVesselCard').removeClass('d-none');
    };

    // Function to export table
    window.exportTable = function () {
      alert('Export functionality would be implemented here');
      // You can use DataTables Buttons extension for export
    };

    // Function to reload table
    window.reloadTable = function () {
      table.draw();
    };
  });
</script>