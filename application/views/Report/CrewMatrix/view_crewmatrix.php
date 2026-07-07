<div class="crew-matrix-content">
  <div class="container-fluid mt-4">
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow">
          <div class="card-body">
            <div class="table-responsive">
              <table id="crewMatrixTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%;">
                <thead class="crew-header">
                  <tr>
                    <th rowspan="2" class="text-center align-middle" style="width: 40px;">No</th>
                    <th rowspan="2" class="text-center align-middle" data-col-index="1" style="min-width: 200px;">Full Name Crew <br><span class="filter-icon">☰</span></th>
                    <th rowspan="2" class="text-center align-middle" data-col-index="2">Status <br><span class="filter-icon">☰</span></th>
                    <th rowspan="2" class="text-center align-middle" data-col-index="3">Rank <br><span class="filter-icon">☰</span></th>
                    <th rowspan="2" class="text-center align-middle" data-col-index="4">Nationality <br><span class="filter-icon">☰</span></th>
                    <th rowspan="2" class="text-center align-middle" data-col-index="5">DOB <br><span class="filter-icon">☰</span></th>
                    <th rowspan="2" class="text-center align-middle" data-col-index="6">Vessel <br><span class="filter-icon">☰</span></th>
                    <th rowspan="2" class="text-center align-middle" data-col-index="7">Sign On <br><span class="filter-icon">☰</span></th>
                    <th rowspan="2" class="text-center align-middle" data-col-index="8">Sign Off <br><span class="filter-icon">☰</span></th>
                    <th rowspan="2" class="text-center align-middle" data-col-index="9">Est Sign Off <br><span class="filter-icon">☰</span></th>
                    <?php if(!empty($dynamic_certs)): ?>
                        <?php foreach($dynamic_certs as $cert): ?>
                            <th colspan="2" class="text-center align-middle border-bottom-0"><?php echo $cert['certname']; ?></th>
                        <?php endforeach; ?>
                    <?php endif; ?>
                  </tr>
                  <tr>
                    <?php if(!empty($dynamic_certs)): ?>
                        <?php $cert_col_index = 10; ?>
                        <?php foreach($dynamic_certs as $cert): ?>
                            <th class="text-center" data-col-index="<?php echo $cert_col_index++; ?>" style="min-width: 100px; border-top: none;">Iss Date <br><span class="filter-icon">☰</span></th>
                            <th class="text-center" data-col-index="<?php echo $cert_col_index++; ?>" style="min-width: 100px; border-top: none;">Exp Date <br><span class="filter-icon">☰</span></th>
                        <?php endforeach; ?>
                    <?php endif; ?>
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
                    <?php if(!empty($dynamic_certs)): ?>
                        <?php foreach($dynamic_certs as $cert): ?>
                            <th><input type="text" class="column-search" placeholder="Search"></th>
                            <th><input type="text" class="column-search" placeholder="Search"></th>
                        <?php endforeach; ?>
                    <?php endif; ?>
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
function formatDisplayDate(dateStr) {
    if (!dateStr || dateStr === '0000-00-00' || dateStr.trim() === '') return '-';
    const d = new Date(dateStr);
    if (isNaN(d)) return dateStr;
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    let day = d.getDate().toString().padStart(2, '0');
    let month = months[d.getMonth()];
    let year = d.getFullYear();
    return `${day} ${month} ${year}`;
}

$(document).ready(function() {
    let columnsDef = [
        {
            data: null,
            className: 'text-center',
            searchable: false,
            orderable: false,
            defaultContent: ''
        },
        {
            data: 'fullName',
            render: function(data, type, row) {
                var name = data || '-';
                if (type === 'display') {
                    var url = "<?php echo base_url('PersonDetail/index'); ?>/" + (row.idperson || '');
                    return '<a href="' + url + '" class="crew-name-link text-dark text-decoration-none" title="View detail" target="_blank">' + (name.replace(/</g, '&lt;').replace(/>/g, '&gt;')) + '</a>';
                }
                return name;
            }
        },
        {
            data: 'crew_status',
            className: 'text-center',
            render: function(data, type, row) {
                if (type === 'display') {
                    let badgeClass = data === 'Stand By' ? 'bg-warning text-dark' : 'bg-success';
                    return `<span class="badge ${badgeClass} w-100">${data}</span>`;
                }
                return data;
            }
        },
        { data: 'nmrank', className: 'text-center' },
        { data: 'NmNegara', className: 'text-center' },
        { 
            data: 'dob', 
            className: 'text-center text-nowrap',
            render: function(data, type) {
                if (type === 'display' || type === 'filter') return formatDisplayDate(data);
                return data;
            }
        },
        { data: 'signonvsl', className: 'text-center' },
        { 
            data: 'signondt', 
            className: 'text-center text-nowrap',
            render: function(data, type) {
                if (type === 'display' || type === 'filter') return formatDisplayDate(data);
                return data;
            }
        },
        { 
            data: 'signoffdt', 
            className: 'text-center text-nowrap',
            render: function(data, type) {
                if (type === 'display' || type === 'filter') return formatDisplayDate(data);
                return data;
            }
        },
        { 
            data: 'estsignoffdt', 
            className: 'text-center text-nowrap',
            render: function(data, type) {
                if (type === 'display' || type === 'filter') return formatDisplayDate(data);
                return data;
            }
        }
    ];

    <?php if(!empty($dynamic_certs)): ?>
        <?php foreach($dynamic_certs as $cert): ?>
            <?php 
                $alias_iss = "iss_" . preg_replace('/[^a-zA-Z0-9]/', '_', $cert['certname']);
                $alias_exp = "exp_" . preg_replace('/[^a-zA-Z0-9]/', '_', $cert['certname']);
            ?>
            columnsDef.push({
                data: '<?php echo $alias_iss; ?>',
                className: 'text-center text-nowrap',
                render: function(data, type) {
                    if (!data) return '-';
                    if (type === 'display' || type === 'filter') return formatDisplayDate(data);
                    return data;
                }
            });
            columnsDef.push({
                data: '<?php echo $alias_exp; ?>',
                className: 'text-center text-nowrap',
                render: function(data, type) {
                    if (!data) return '-';
                    if (type === 'display' || type === 'filter') return formatDisplayDate(data);
                    return data;
                }
            });
        <?php endforeach; ?>
    <?php endif; ?>

    let table = $('#crewMatrixTable').DataTable({
        dom: "<'row mb-2'<'col-md-6 d-flex align-items-center'l><'col-md-6 text-end custom-btn'B>>" +
             "<'row'<'col-md-12'tr>>" +
             "<'row mt-2'<'col-md-6'i><'col-md-6 d-flex justify-content-end'p>>",
        stateSave: true,
        processing: true,
        serverSide: false,
        pageLength: 50,
        lengthMenu: [10, 25, 50, 100, -1],
        language: {
            lengthMenu: ' _MENU_ &nbsp; Entries'
        },
        order: [[2, "asc"], [1, "asc"]],
        ajax: {
            url: "<?php echo base_url('Report/CrewMatrix/getData_crewMatrix'); ?>",
            type: "POST",
            dataSrc: function(json) {
                return json.success ? json.data : [];
            }
        },
        columns: columnsDef,
        initComplete: function() {
            initDropdownFilters(this.api());
        }
    });

    table.on('order.dt search.dt draw.dt', function () {
        let start = table.page.info().start;
        table.column(0, { search: 'applied', order: 'applied', page: 'current' }).nodes().each(function (cell, i) {
            cell.innerHTML = start + i + 1;
        });
    }).draw();

    $('.column-search').on('keyup change clear', function() {
        var colIdx = $(this).closest('th').index();
        if (table.column(colIdx).search() !== this.value) {
            table.column(colIdx).search(this.value).draw();
        }
    });

    let state = table.state.loaded();
    if (state) {
        $('.column-search').each(function() {
            let colIdx = $(this).closest('th').index();
            let colSearch = state.columns[colIdx].search;
            if (colSearch.search && !colSearch.regex) {
                $(this).val(colSearch.search);
            }
        });
    }

    $(document).on('click', function() {
        $('.filter-dropdown').hide();
    });

    function initDropdownFilters(tableApi) {
        //console.log("🚀 Memulai initDropdownFilters...");

        $('#crewMatrixTable thead th').each(function() {
            let th = $(this);
            let icon = th.find('.filter-icon');
            if (!icon.length) return; // Tidak ada icon, lewati

            // Ambil index dari attribute data-col-index yang sudah kita set secara manual di HTML
            let cellIndex = parseInt(th.attr('data-col-index'));
            if (isNaN(cellIndex)) {
                console.log("⚠️ Peringatan: Ada icon ☰ tapi tidak ada data-col-index di kolom: " + th.text());
                return;
            }

            let title = th.text().replace('☰', '').trim();
            //console.log(`🔍 Setup Dropdown untuk Kolom [${cellIndex}] : ${title}`);

            // Hapus dropdown lama jika ada untuk mencegah duplikasi
            $(`.filter-dropdown[data-col-index="${cellIndex}"]`).remove();

            let dropdown = $(`
              <div class="filter-dropdown" data-col-index="${cellIndex}">
                <input type="text" class="filter-search" placeholder="Search...">
                <div class="filter-list"></div>
                <hr>
                <div class="d-flex gap-2 text-center">
                  <button class="btn btn-sm w-100 apply-filter rounded-pill fst-italic btn-clear-filter" id="clear-filter"> 
                    <i class="fa-solid fa-eraser"></i> Clear
                  </button>
                </div>
              </div>
            `).appendTo('body');

            let listContainer = dropdown.find('.filter-list');

            try {
                let columnData = tableApi.column(cellIndex).data();
                if (columnData && typeof columnData.unique === 'function') {
                    let uniqueVals = [];
                    columnData.unique().each(function(val) {
                        if (val && val !== null && val !== '' && val !== '0000-00-00' && val !== '-') {
                            let displayVal = val;
                            if (val.match(/^\d{4}-\d{2}-\d{2}$/)) {
                                displayVal = formatDisplayDate(val);
                            }
                            let tempDiv = document.createElement("div");
                            tempDiv.innerHTML = displayVal;
                            let textVal = tempDiv.textContent || tempDiv.innerText || "";
                            
                            if(textVal && !uniqueVals.includes(textVal)) {
                                uniqueVals.push(textVal);
                            }
                        }
                    });

                    uniqueVals.sort().forEach(function(val) {
                        let safeVal = String(val).replace(/</g, '&lt;').replace(/>/g, '&gt;');
                        listContainer.append(`
                          <label>
                            <input type="checkbox" value="${safeVal}"> ${safeVal}
                          </label>
                        `);
                    });
                }
            } catch (e) {
                console.warn('Error loading filter data for column ' + cellIndex + ':', e);
            }

            // Pastikan event sebelumnya dihapus lalu set stopPropagation
            icon.off('click').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                //console.log(`🖱️ Icon diklik pada kolom: [${cellIndex}] ${title}`);

                $('.filter-dropdown').not(dropdown).hide();
                
                let offset = icon.offset();
                dropdown.css({
                  top: offset.top + icon.outerHeight() + 5,
                  left: offset.left - (dropdown.outerWidth() / 2) + (icon.outerWidth() / 2)
                }).toggle();
            });

            dropdown.on('click', function(e) {
                e.stopPropagation();
            });

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
                    tableApi.column(cellIndex).search(regex, true, false);
                } else {
                    tableApi.column(cellIndex).search('');
                }

                tableApi.draw();
            });

            dropdown.on('click', '.btn-clear-filter', function() {
                dropdown.find('input[type="checkbox"]').prop('checked', false);
                dropdown.find('.filter-search').val('');
                listContainer.find('label').show();

                tableApi.column(cellIndex).search('').draw();
                dropdown.hide();
            });
        });
    }
});
</script>

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

.crew-header th {
  background-color: var(--crew-blue) !important;
  color: #fff !important;
}

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

.filter-icon {
  font-size: 10px;
  cursor: pointer;
  color: #f8f9fa;
  background: rgba(0,0,0,0.2);
  padding: 2px 5px;
  border-radius: 4px;
  display: inline-block;
  margin-top: 4px;
  transition: background 0.2s;
}
.filter-icon:hover {
  background: rgba(0,0,0,0.5);
}

.filter-dropdown {
  display: none;
  position: absolute;
  z-index: 9999;
  background: white;
  padding: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  min-width: 220px;
  border: 1px solid #dee2e6;
  border-radius: 6px;
}
.filter-dropdown label {
  display: block;
  font-size: 13px;
  cursor: pointer;
  padding: 4px 8px;
  margin: 2px 0;
  border-radius: 4px;
  white-space: nowrap;
}
.filter-dropdown label:hover {
  background: #f8f9fa;
}
.filter-list {
  max-height: 150px;
  overflow-y: auto;
  margin-bottom: 6px;
  margin-top: 10px;
}
.filter-search {
  width: 100%;
  padding: 6px 8px;
  font-size: 12px;
  border: 1px solid #dee2e6;
  border-radius: 4px;
  background: #f8f9fa;
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

.column-search {
  width: 100%;
  padding: 6px 8px;
  box-sizing: border-box;
  font-size: 12px;
  border: 1px solid #dee2e6;
  border-radius: 4px;
  background: #f8f9fa;
}
#crewMatrixTable thead th {
  vertical-align: middle;
}
.crew-matrix-content .card {
  border-radius: 12px;
  margin-top: 20px;
}
.card-header {
  padding: 15px 20px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}
.card-body {
  padding: 20px;
  overflow-x: auto;
}
#crewMatrixTable_wrapper .dataTables_filter {
  display: none;
}
</style>
