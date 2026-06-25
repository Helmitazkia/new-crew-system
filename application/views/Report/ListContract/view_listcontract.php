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
                    <th class="text-center">Company</th>
                    <th class="text-left">Full Name Crew</th>
                    <th class="text-center">Apply For</th>
                    <th class="text-center">Religion</th>
                    <th class="text-center">Gender</th>
                    <th class="text-center">Sign On</th>
                    <th class="text-center">Sign Off</th>
                    <th class="text-center">Contract</th>
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
                  </tr>
                </thead>
                <tbody>
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
function ordinalSup(num) {
  num = parseInt(num, 10);
  if (isNaN(num)) return '-';
  if (num % 100 >= 11 && num % 100 <= 13) {
    return num + '<sup>th</sup>';
  }
  const suffix = {
    1: 'st',
    2: 'nd',
    3: 'rd'
  };
  return num + '<sup>' + (suffix[num % 10] || 'th') + '</sup>';
}

$(document).ready(function() {
  let table = $('#crewTable').DataTable({
    dom: "<'row mb-2'<'col-md-6 d-flex align-items-center'l><'col-md-6 text-end custom-btn'>>" +
         "<'row'<'col-md-12'tr>>" +
         "<'row mt-2'<'col-md-6'i><'col-md-6 d-flex justify-content-end'p>>",
    stateSave: true,
    stateDuration: -1,
    processing: true,
    serverSide: false, // Use DataTables built-in filter
    pageLength: 50,
    language: {
      lengthMenu: ' _MENU_ &nbsp; Entries',
      loadingRecords: '',
    },
    order: [
      [1, "asc"]
    ],
    ajax: {
      url: "<?php echo base_url('Report/ListContract/getListContract'); ?>",
      type: "POST",
      dataSrc: function(json) {
        return json.success ? json.data : [];
      }
    },
    columns: [
      {
        data: null,
        className: 'text-center',
        searchable: false,
        orderable: false,
        defaultContent: ''
      },
      { data: 'nmcmp', className: 'text-center' },
      { 
        data: 'fullname', 
        className: 'text-left',
        render: function(data, type, row) {
          if (type === 'display') {
            var name = data || '-';
            return '<a href="#" class="crew-name crew-name-link text-dark text-decoration-none" onclick="showCrewDetail(\'' +
            (row.idperson || '') + '\'); return false;" title="View detail">' + (name.replace(/</g, '&lt;')
              .replace(/>/g, '&gt;')) + '</a>';
          }
          return data;
        }
      },
      { 
        data: 'applyfor', 
        className: 'text-center',
        type: 'num',
        render: function(data, type, row) {
          if (type === 'sort') {
            return row.rank_urutan;
          }
          return data;
        }
      },
      { data: 'religion', className: 'text-center' },
      { data: 'gender', className: 'text-center' },
      { data: 'signondt', className: 'text-center text-nowrap' },
      { 
        data: 'signoffdt', 
        className: 'text-center text-nowrap',
        render: function(data, type, row) {
          if (type === 'display' && data === 'On Board') {
            return '<span class="badge bg-success">On Board</span>';
          }
          return data;
        }
      },
      { 
        data: 'total_contract', 
        className: 'text-center',
        render: function(data, type, row) {
          if (type === 'display') {
             return `${ordinalSup(row.total_contract)} Contract`;
          }
          return data;
        }
      }
    ],
    order: [[2, 'asc']], // default order by fullname
    initComplete: function() {
      // Inject Export Excel Button
      $('.custom-btn').html('<button type="button" id="btnExportExcel" class="btn btn-success btn-sm"><i class="fa fa-file-excel" style="margin-right: 5px;"></i> Export Excel</button>');
    }
  });

  // Enumeration for No column
  table.on('draw.dt', function() {
    let info = table.page.info();
    table.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function(cell, i) {
      cell.innerHTML = i + 1 + info.start;
    });
  });

  // Column Search
  $('#crewTable thead tr:last th').each(function(i) {
    let inputElemen = $('input', this);

    if (inputElemen.length > 0 && table.state.loaded()) {
      let colState = table.state.loaded().columns[i];
      if (colState && colState.search && colState.search.search && !colState.search.regex) {
        inputElemen.val(colState.search.search);
      }
    }

    inputElemen.on('keyup change', function() {
      if (table.column(i).search() !== this.value) {
        table.column(i).search(this.value);
        table.draw();
      }
    });
  });

  // Export Logic
  $(document).on('click', '#btnExportExcel', function() {
    let filteredData = table.rows({ search: 'applied' }).data().toArray();
    let idpersons = filteredData.map(row => row.idperson);
    
    if(idpersons.length === 0) {
        if(typeof Swal !== 'undefined') Swal.fire({ icon: 'warning', title: 'Empty Data', text: 'No data to export!' });
        else alert("No data to export!");
        return;
    }
    
    let form = $('<form>', {
        action: "<?php echo base_url('Report/ListContract/exportListContractExcel'); ?>",
        method: 'POST',
        target: '_blank'
    }).append($('<input>', {
        type: 'hidden',
        name: 'idpersons',
        value: JSON.stringify(idpersons)
    }));
    
    $('body').append(form);
    form.submit();
    form.remove();
  });
});

  window.showCrewDetail = function(crewNo) {
    window.location.href =
      "<?php echo base_url('PersonDetail/index'); ?>/" + crewNo;
  };
</script>

<style>
:root {
  --crew-blue: #000099;
  --crew-font-sm: 12px;
}
.crew-table th, .crew-table td {
  font-size: var(--crew-font-sm);
  vertical-align: middle;
}
.crew-header th {
  font-weight: 600;
  background-color: var(--crew-blue) !important;
  color: #fff !important;
}
.card {
  border-radius: 8px;
  border: none;
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
</style>
