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
                    <th class="text-center">Company <span class="filter-icon">☰</span></th>
                    <th class="text-left">Full Name Crew <span class="filter-icon">☰</span></th>
                    <th class="text-center">Apply For <span class="filter-icon">☰</span></th>
                    <th class="text-center">Religion <span class="filter-icon">☰</span></th>
                    <th class="text-center">Gender <span class="filter-icon">☰</span></th>
                    <th class="text-center">Sign On <span class="filter-icon">☰</span></th>
                    <th class="text-center">Sign Off <span class="filter-icon">☰</span></th>
                    <th class="text-center">Contract <span class="filter-icon">☰</span></th>
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
$(document).ready(function() {
  var selectedContractRanges = [];

  if ($.fn.dataTable && $.fn.dataTable.ext) {
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var tableId = settings.sTableId || (settings.nTable ? settings.nTable.id : '');
        if (tableId && tableId !== 'crewTable') return true;
        if (!selectedContractRanges || selectedContractRanges.length === 0) return true;

        var row = (settings.aoData && settings.aoData[dataIndex]) ? settings.aoData[dataIndex]._aData : null;
        var contractStr = '';
        if (row && typeof row.total_contract !== 'undefined') {
            contractStr = String(row.total_contract);
        } else if (data && data.length > 8) {
            contractStr = String(data[8]);
        }

        var yMatch = contractStr.match(/(\d+)\s+Years?/i);
        var years = yMatch ? parseInt(yMatch[1], 10) : 0;
        var mMatch = contractStr.match(/(\d+)\s+Months?/i);
        var months = mMatch ? parseInt(mMatch[1], 10) : 0;
        var totalYears = years + (months / 12);

        return selectedContractRanges.some(function(range) {
            if (range === '< 1 Year') return totalYears < 1;
            if (range === '1 - 3 Years') return totalYears >= 1 && totalYears < 3;
            if (range === '3 - 5 Years') return totalYears >= 3 && totalYears <= 5;
            if (range === '> 5 Years') return totalYears > 5;
            if (range === '> 10 Years') return totalYears > 10;
            if (range === '> 15 Years') return totalYears > 15;
            if (range === '> 20 Years') return totalYears > 20;
            return false;
        });
    });
  }

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
            var detailUrl = "<?php echo base_url('PersonDetail/index'); ?>/" + encodeURIComponent(row.idperson || '');
            return '<a href="' + detailUrl + '" class="crew-name crew-name-link text-dark text-decoration-none" target="_blank" title="View detail">' + (name.replace(/</g, '&lt;').replace(/>/g, '&gt;')) + '</a>';
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
        className: 'text-center'
      }
    ],
    order: [[2, 'asc']], // default order by fullname
    initComplete: function() {
      // Inject Export Excel Button
      $('.custom-btn').html('<button type="button" id="btnExportExcel" class="btn btn-success btn-sm"><i class="fa fa-file-excel" style="margin-right: 5px;"></i> Export Excel</button>');
      initDropdownFilters(this.api());
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

  window.showCrewDetail = function(crewNo) {
    window.open("<?php echo base_url('PersonDetail/index'); ?>/" + crewNo, '_blank');
  };

  function initDropdownFilters(api) {
      $('#crewTable thead tr:first th').each(function (colIndex) {
          var icon = $(this).find('.filter-icon');
          if (!icon.length) return;
  
          var dropdown = $('<div class="filter-dropdown">'
              + '<input type="text" class="filter-search" placeholder="Search...">'
              + '<div class="filter-list"></div>'
              + '<hr>'
              + '<div class="d-flex gap-2 text-center">'
              + '<button class="btn btn-sm w-30 rounded-pill fst-italic btn-clear-filter" id="clear-filter">'
              + '<i class="fa-solid fa-eraser"></i>'
              + '</button>'
              + '</div>'
              + '</div>').appendTo('body');
  
          var listContainer = dropdown.find('.filter-list');
          var isContractCol = $(this).text().indexOf('Contract') !== -1 || colIndex === 8;

          if (isContractCol) {
              var contractRanges = [
                  '< 1 Year',
                  '1 - 3 Years',
                  '3 - 5 Years',
                  '> 5 Years',
                  '> 10 Years',
                  '> 15 Years',
                  '> 20 Years'
              ];
              contractRanges.forEach(function (val) {
                  listContainer.append('<label><input type="checkbox" value="'+ val +'"> '+ val +'</label>');
              });
          } else {
              try {
                  var colData = api.column(colIndex).data();
                  if (colData && typeof colData.unique === 'function') {
                      var uniqueVals = [];
                      colData.unique().each(function (val) {
                          if (val && val !== '-' && val !== '') {
                              var tempDiv = document.createElement('div');
                              tempDiv.innerHTML = val;
                              var text = tempDiv.textContent || tempDiv.innerText || '';
                              if (text && !uniqueVals.includes(text)) uniqueVals.push(text);
                          }
                      });
                      uniqueVals.sort().forEach(function (val) {
                          var safeVal = String(val).replace(/</g, '&lt;').replace(/>/g, '&gt;');
                          listContainer.append('<label><input type="checkbox" value="'+ safeVal +'"> '+ safeVal +'</label>');
                      });
                  }
              } catch(e) { console.warn('Filter error col '+ colIndex, e); }
          }
  
          icon.on('click', function (e) {
              e.stopPropagation();
              $('.filter-dropdown').hide();
              var off = icon.offset();
              var leftPos = off.left;
              var dropdownWidth = 200; // default from CSS
              if (leftPos + dropdownWidth > $(window).width()) {
                  leftPos = off.left - dropdownWidth + icon.outerWidth();
              }
              dropdown.css({ top: off.top + icon.outerHeight(), left: leftPos }).toggle();
          });
  
          dropdown.find('.filter-search').on('keyup', function () {
              var kw = $(this).val().toLowerCase();
              listContainer.find('label').each(function () {
                  $(this).toggle($(this).text().toLowerCase().includes(kw));
              });
          });
  
          dropdown.on('change', 'input[type="checkbox"]', function () {
              if (isContractCol) {
                  selectedContractRanges = [];
                  dropdown.find('input[type="checkbox"]:checked').each(function () {
                      selectedContractRanges.push($(this).val());
                  });
                  if (selectedContractRanges.length > 0) {
                      icon.css('color', '#ffc107');
                  } else {
                      icon.css('color', '');
                  }
                  api.draw();
              } else {
                  var selected = [];
                  dropdown.find('input[type="checkbox"]:checked').each(function () { selected.push($(this).val()); });
                  if (selected.length > 0) {
                      icon.css('color', '#ffc107');
                      var regex = selected.map(function(v){ return v.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); }).join('|');
                      api.column(colIndex).search(regex, true, false).draw();
                  } else {
                      icon.css('color', '');
                      api.column(colIndex).search('').draw();
                  }
              }
              dropdown.hide();
          });
  
          dropdown.on('click', '.btn-clear-filter', function () {
              dropdown.find('input').prop('checked', false);
              dropdown.find('.filter-search').val('');
              listContainer.find('label').show();
              icon.css('color', '');
              if (isContractCol) {
                  selectedContractRanges = [];
                  api.draw();
              } else {
                  api.column(colIndex).search('').draw();
              }
              dropdown.hide();
          });
      });
  }

  $(document).on('click', function (e) {
      if (!$(e.target).closest('.filter-dropdown').length) $('.filter-dropdown').hide();
  });
});
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
/* Filter Dropdown Styles */
.filter-icon {
    font-size: 14px;
    margin-left: 5px;
    cursor: pointer;
    color: #aac4ff;
}
.filter-icon:hover { color: #fff; }
.filter-dropdown {
    position: absolute; background: #fff; border: 1px solid #ccc;
    padding: 8px; width: 200px; max-height: 260px; overflow-y: auto;
    box-shadow: 0 4px 10px rgba(0,0,0,.2); display: none; z-index: 9999;
}
.filter-dropdown input[type="text"] {
    width: 100%; margin-bottom: 6px; padding: 4px; font-size: 12px;
    border: 1px solid #dee2e6; border-radius: 4px;
}
.filter-dropdown label {
    display: block; font-size: 13px; cursor: pointer;
    padding: 4px 8px; margin: 2px 0; border-radius: 4px;
}
.filter-dropdown label:hover { background: #f8f9fa; }
.filter-list { max-height: 120px; overflow-y: auto; margin-bottom: 6px; }
.btn-clear-filter {
    background: transparent; border: 1.5px solid #000099;
    color: #000099; transition: all .2s ease;
}
.btn-clear-filter:hover { background: #000099; color: #fff; }
.btn-clear-filter i { font-size: 14px; }

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