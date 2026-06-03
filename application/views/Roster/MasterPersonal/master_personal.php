<div class="crew-rotation-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow">
          <div class="card-body">
            <div class="table-responsive">
              <table id="crewTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                  <tr>
                    <th>No</th>
                    <th>Full Name Crew</th>
                    <th>Rank Applied For <span class="filter-icon">☰</span></th>
                    <th>Gender <span class="filter-icon">☰</span></th>
                    <th>Religion <span class="filter-icon">☰</span></th>
                    <th>Vessel <span class="filter-icon">☰</span></th>
                    <th>City Birth <span class="filter-icon">☰</span></th>
                    <th>Status Person <span class="filter-icon">☰</span></th>
                    <th>Action</th>
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

<script>
$(document).ready(function() {

  let table = $('#crewTable').DataTable({
    stateSave: true,
    stateDuration: -1,
    processing: true,
    serverSide: false,
    language: {
      lengthMenu: ' _MENU_ &nbsp; Entries',
      loadingRecords: '',
    },
    ajax: {
      url: "<?php echo base_url('MasterPersonal/MasterPersonal/getAllData_personal'); ?>",
      type: "POST",
      dataSrc: function(json) {
        return json.success ? json.data : [];
      }
    },
    columns: [{
        data: null,
        className: 'text-center',
        render: function(data, type, row, meta) {
          return meta.row + 1;
        }
      },

      // FULL NAME (FIX)
      {
        data: 'fullName',
        render: function(data, type, row) {
          if (type === 'display') {
            return `<span class="crew-name-link text-dark" onclick="showCrewDetail('${row.idperson}')">${data}</span>`;
          }
          return data; // <-- penting buat filter
        }
      },

      // APPLY FOR
      {
        data: 'applyfor',
        className: 'text-center'
      },

      // GENDER
      {
        data: 'gender',
        className: 'text-center'
      },

      // RELIGION
      {
        data: 'religion',
        className: 'text-center'
      },

      // DOB
      {
        data: 'nmvsl',
        className: 'text-center'
      },
      {
        data: 'dob',
        className: 'text-center'
      },

      {
        data: 'statusPerson',
        className: 'text-center',
        render: function(data, type, row) {
          const STATUS_BADGE = {
            'On board': 'bg-success',
            'Stand By': 'bg-warning text-dark',
            'New Applicant': 'bg-info text-white',
            'Non Aktif': 'bg-danger text-white',
            'Not For Emp': 'bg-dark text-white'
          };
          let displayStatus = data;
          const hasContract = row.signoffdt || row.estsignoffdt;
          if ((data === 'On board' || data === 'Stand By' || hasContract) && hasContract) {
            const dateRaw = (row.signoffdt && row.signoffdt !== '0000-00-00') ? row.signoffdt : (row.estsignoffdt || '');
            displayStatus = 'On board';
            if (dateRaw && dateRaw !== '0000-00-00') {
              const today = new Date();
              const end = new Date(dateRaw);
              today.setHours(0, 0, 0, 0);
              end.setHours(0, 0, 0, 0);
              if (Math.ceil((end - today) / 86400000) < 0) displayStatus = 'Stand By';
            }
          }
          if (type === 'display') {
            const cls = STATUS_BADGE[displayStatus] || 'bg-secondary text-white';
            const style = (displayStatus === 'On board' || displayStatus === 'Stand By') ? '' : ' style="padding: 5px 10px; border-radius: 12px;"';
            return `<span class="badge ${cls}"${style}>${displayStatus || '-'}</span>`;
          }
          return displayStatus;
        }
      },

      // ACTION (TIDAK IKUT FILTER)
      {
        data: null,
        orderable: false,
        searchable: false,
        className: 'text-center',
        render: function(row, type) {
          if (type === 'display') {
            return `
                <button class="btn btn-sm btn-outline-primary"
                  onclick="showCrewDetail('${row.idperson}')">
                  <i class="fa fa-edit"></i>
                </button>`;
          }
          return '';
        }
      }
    ],
    initComplete: function() {
      initDropdownFilters(this.api());
    }
  });

  // Fungsi untuk menampilkan detail crew
  function showCrewDetail(idperson) {
    console.log('Show detail for crew ID:', idperson);
    // Contoh: window.location.href = `<?php echo base_url('MasterPersonal/detail/'); ?>${idperson}`;
  }


  // Column Search - AMBIL ROW SEARCH TERAKHIR
  $('#crewTable thead tr:last th').each(function(i) {
    $('input', this).on('keyup change', function() {
      if (table.column(i).search() !== this.value) {
        table
          .column(i)
          .search(this.value)
          .draw();
      }
    });
  });

  function initDropdownFilters(table) {

    $('#crewTable thead th').each(function(colIndex) {
      let icon = $(this).find('.filter-icon');
      if (!icon.length) return;

      // Skip No & Action
      if (colIndex === 0 || colIndex === 8) return;

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

      // ✅ AMBIL DATA SETELAH TABLE READY
      table.column(colIndex).data().unique().sort().each(function(val) {
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



  // Function to show crew detail
  window.showCrewDetail = function(crewNo) {
    window.location.href =
      "<?php echo base_url('PersonDetail/index'); ?>/" + crewNo;
  };

  // Function to export table
  window.exportTable = function() {
    alert('Export functionality would be implemented here');
    // You can use DataTables Buttons extension for export
  };

  // Function to reload table
  window.reloadTable = function() {
    table.draw();
  };
});

$(document).on('click', function(e) {
  if (!$(e.target).closest('.filter-dropdown').length) {
    $('.filter-dropdown').hide();
  }
});
</script>

<style>
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
</style>


<style>
:root {
  --crew-blue: #000099;
  --crew-font-sm: 12px;
  --crew-font-xs: 11px;
}

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
  padding: 2px 6px;
}

.crew-header th {
  background-color: var(--crew-blue) !important;
  color: #fff !important;
}


.crew-header-group {
  background-color: var(--crew-blue) !important;
  color: #fff !important;
}

/* Nama crew: outline/garis saat hover */
.crew-name-link {
  cursor: pointer;
  outline: none;
  padding: 2px 4px;
  margin: -2px -4px;
  border-radius: 3px;
  transition: outline 0.15s ease, box-shadow 0.15s ease;
}
.crew-name-link:hover {
  outline: 1px solid var(--crew-blue);
  box-shadow: 0 0 0 1px var(--crew-blue);
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