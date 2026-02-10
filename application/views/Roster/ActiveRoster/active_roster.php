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
                    <th class="text-center">No</th>
                    <th class="text-left">Full Name Crew</th>
                    <th>Rank Applied <br><span class="filter-icon">☰</span></th>
                    <th>Last Experience <br> <span class="filter-icon">☰</span></th>
                    <th>Gender <br><span class="filter-icon text-right">☰</span></th>
                    <th>Religion <br><span class="filter-icon">☰</span></th>
                    <th>Vessel <br><span class="filter-icon">☰</span></th>
                    <th>Next Vessel <br><span class="filter-icon">☰</span></th>
                    <th>City Birth <br><span class="filter-icon">☰</span></th>
                    <th>Status Person <br><span class="filter-icon">☰</span></th>
                    <th>Contract <br><span class="filter-icon">☰</span></th>
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
    processing: true,
    serverSide: false,
    language: {
      lengthMenu: ' _MENU_ &nbsp; Entries',
      loadingRecords: '',
    },
    ajax: {
      url: "<?= base_url('ActiveRoster/ActiveRoster/getAllData_activeRoster'); ?>",
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
      {
        data: 'fullName',
        render: function(data, type, row) {
          return data;
        }
      },
      {
        data: 'applyfor'
      },
      {
        data: 'rankexp'
      },
      {
        data: 'gender'
      },
      {
        data: 'religion'
      },
      {
        data: 'nmvsl',
        className: 'text-center'
      },
      {
        data: null,
        className: 'text-center',
        render: function() {
          return ""; // Selalu kembalikan string kosong
        }
      },
      {
        data: 'dob',
        className: 'text-center'
      },
      {
        data: 'statusPerson',
        className: 'text-center',
        render: function(data, type) {
          if (type === 'display') {
            let cls = 'bg-secondary';

            if (data === 'On board') cls = 'bg-success';
            else if (data === 'Stand By') cls = 'bg-warning text-dark';
            else if (data === 'Non Aktif') cls = 'bg-danger';

            return `<span class="badge ${cls}">${data}</span>`;
          }
          return data; // penting buat search & filter
        }
      },
      {
        data: 'estsignoffdt',
        className: 'text-center',
        render: function(data, type, row) {
          if (!data || data === '0000-00-00') return '<span class="text-muted">-</span>';

          if (type === 'display') {
            const dateNow = new Date();
            const estDate = new Date(data);
            dateNow.setHours(0, 0, 0, 0);
            estDate.setHours(0, 0, 0, 0);

            let diffTime = estDate - dateNow;
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            let displayText = row.estsignoffdt_formatted;
            let warningMsg = "";

            const getDuration = (totalDays) => {
              let days = Math.abs(totalDays);
              let months = Math.floor(days / 30);
              let remainingDays = days % 30;
              let result = "";
              if (months > 0) result += months + " Months ";
              if (remainingDays > 0) result += remainingDays + " Days";
              return result.trim();
            };

            if (diffDays < 0) {
              // 1. LOGIKA: SUDAH LEWAT (Expired Over)
              let duration = getDuration(diffDays);
              warningMsg =
                `<br><span style="font-size:10px; color:red; font-weight: bold;">Expired Over ${duration}</span>`;
            } else if (diffDays <= 90) {
              // 2. LOGIKA: AKAN DATANG (Expired In)
              let duration = getDuration(diffDays);
              warningMsg =
                `<br><span style="font-size:10px; color:orange; font-weight: bold;">Expired In ${duration}</span>`;
            }

            return `<div>${displayText}${warningMsg}</div>`;
          }
          return data;
        }
      },
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
                  <i class="fa fa-eye"></i>
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




  //Column Search - AMBIL ROW SEARCH TERAKHIR
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
      if (colIndex === 0 || colIndex === 11) return;

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

      // ✅ DEFAULT FILTER KHUSUS statusPerson
      if (table.column(colIndex).dataSrc() === 'statusPerson') {
        const defaultStatus = ['On board', 'Stand By'];

        dropdown.find('input[type="checkbox"]').each(function() {
          if (defaultStatus.includes($(this).val())) {
            $(this).prop('checked', true);
          }
        });

        applyDropdownFilter(dropdown, table, colIndex);
      }

      function applyDropdownFilter(dropdown, table, colIndex) {
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
      }



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
        // $('.filter-dropdown').hide();
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

  // function initDropdownFilters(table) {
  //   console.log("🚀 Memulai initDropdownFilters...");

  //   table.columns().every(function() {
  //     let column = this;
  //     let colIndex = column.index();
  //     let header = $(column.header());
  //     let title = header.text().trim(); // Ambil nama kolom untuk log
  //     let icon = header.find('.filter-icon');

  //     console.log(`🔍 Mengecek Kolom [${colIndex}] : ${title}`);

  //     // Skip jika tidak ada icon, atau kolom No (0) dan Action (11)
  //     if (!icon.length || colIndex === 0 || colIndex === 11) {
  //       console.warn(`⏭️ Skip kolom ${colIndex} (Tidak ada icon atau kolom pengecualian)`);
  //       return;
  //     }

  //     // Hapus dropdown lama
  //     $(`.filter-dropdown[data-column="${colIndex}"]`).remove();

  //     let dropdown = $(`
  //           <div class="filter-dropdown" data-column="${colIndex}" style="display:none; position:absolute; z-index:9999; background:white; border:1px solid #ccc; padding:10px; box-shadow: 2px 2px 10px rgba(0,0,0,0.1);">
  //               <input type="text" class="filter-search" placeholder="Search ${title}...">
  //               <div class="filter-list" style="max-height:200px; overflow-y:auto; margin-top:10px;"></div>
  //               <hr>
  //               <div class="d-flex gap-2">
  //                   <button class="btn btn-sm btn-clear-filter rounded-pill w-100 btn-danger">
  //                       <i class="fa-solid fa-eraser"></i> Clear
  //                   </button>
  //               </div>
  //           </div>
  //       `).appendTo('body');

  //     let listContainer = dropdown.find('.filter-list');
  //     let dataCount = 0;

  //     // Ambil data unik
  //     column.data().unique().sort().each(function(val) {
  //       if (val !== null && val !== '') {
  //         dataCount++;
  //         listContainer.append(`
  //                   <label class="d-block" style="cursor:pointer;">
  //                       <input type="checkbox" value="${val}"> ${val}
  //                   </label>
  //               `);
  //       }
  //     });

  //     console.log(`✅ Kolom [${colIndex}] terisi ${dataCount} data unik.`);

  //     // Event Toggle Dropdown
  //     icon.off('click').on('click', function(e) {
  //       e.stopPropagation();
  //       console.log(`🖱️ Icon diklik pada kolom: ${title}`);
  //       $('.filter-dropdown').not(dropdown).hide();
  //       let offset = icon.offset();
  //       dropdown.css({
  //         top: offset.top + icon.outerHeight() + 5,
  //         left: offset.left
  //       }).toggle();
  //     });

  //     // Event Checkbox
  //     dropdown.off('change').on('change', 'input[type="checkbox"]', function() {
  //       let selected = [];
  //       dropdown.find('input[type="checkbox"]:checked').each(function() {
  //         selected.push($(this).val());
  //       });

  //       console.log(`⚖️ Filtering ${title}:`, selected);

  //       if (selected.length > 0) {
  //         let regex = selected.map(v => $.fn.dataTable.util.escapeRegex(v)).join('|');
  //         column.search(regex, true, false).draw();
  //       } else {
  //         column.search('').draw();
  //       }
  //     });
  //   });
  // }

  // // Debugging untuk Column Search (Input Text)
  // // Debugging & Perbaikan untuk Column Search (Input Text di baris kedua header)
  // $('#crewTable thead tr:last th').each(function(i) {
  //   // Cari input di dalam TH ini
  //   let inputElemen = $(this).find('input');

  //   if (inputElemen.length) {
  //     inputElemen.off('keyup change').on('keyup change', function() {
  //       let val = this.value;
  //       console.log(`⌨️ Typing in column [${i}]: ${val}`);

  //       if (table.column(i).search() !== val) {
  //         table.column(i).search(val).draw();
  //       }
  //     });
  //   }
  // });


  // Crew Detail
  function showCrewDetail(idperson) {
    console.log('Show detail for crew ID:', idperson);
  }
  window.showCrewDetail = function(crewNo) {
    window.location.href =
      "<?php echo base_url('PersonDetail/index'); ?>/" + crewNo;
  };

  // Export table
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