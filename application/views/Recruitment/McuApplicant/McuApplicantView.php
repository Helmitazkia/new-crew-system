<style>
.sap-workspace {
    background: #f8fafc;
    border-radius: 22px;
    padding: 22px;
}

.sap-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}

.sap-header-left h2 {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    letter-spacing: -.3px;
}

.sap-header-left span {
    font-size: 13px;
    color: #6b7280;
}

.sap-kpi {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 8px 14px;
    text-align: right;
}

.sap-kpi small {
    font-size: 11px;
    color: #6b7280;
}

.sap-kpi strong {
    font-size: 18px;
    color: #111827;
}

/* TOOLBAR */
.sap-toolbar {
    margin-bottom: 14px;
}

.sap-search {
    position: relative;
    width: 360px;
}

.sap-search input {
    width: 100%;
    padding: 10px 14px 10px 38px;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    font-size: 14px;
    transition: .2s;
}

.sap-search input:focus {
    outline: none;
    background: #ffffff;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
}

.sap-search i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
}

.sap-content {
    position: relative;
    background: #ffffff;
    border-radius: 20px;
    padding: 18px;
    box-shadow: 0 18px 40px rgba(0, 0, 0, .08);
}

.sap-table-wrapper {
    max-height: 520px;
    overflow-y: auto;
    overflow-x: hidden;
    border: 1px solid #e5e9f2;
    border-radius: 6px;
    background: #fff;
}

.sap-table {
    width: 100%;
    table-layout: fixed;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 13px;
}

/* HEADER */
.sap-table thead th {
    position: sticky;
    top: 0;
    z-index: 5;

    background: #000099;
    color: #fff;
    font-weight: 600;

    padding: 10px 8px;
    text-align: left;

    border-right: 1px solid rgba(255, 255, 255, .85);
    border-bottom: 1px solid rgba(255, 255, 255, .4);
}

.sap-table thead th:last-child {
    border-right: none;
}

/* SHADOW HEADER */
.sap-table-wrapper.scrolling thead th {
    box-shadow: 0 2px 4px rgba(0, 0, 0, .06);
}

/* BODY */
.sap-table tbody td {
    padding: 12px;

    vertical-align: top;

    border-right: 1px solid #d5deea;
    border-bottom: 1px solid #d5deea;

    background: #fff;

    white-space: normal !important;
    word-break: break-word;
    overflow-wrap: break-word;
}

.sap-table tbody td:last-child {
    border-right: none;
}

/* ZEBRA */
.sap-table tbody tr:nth-child(even) td {
    background: #f8fafc;
}

/* HOVER */
.sap-table tbody tr:hover td {
    background: #edf4ff;
    transition: .15s ease;
}

/* ACTION */
.action-group {
    display: flex;
    gap: 6px;
    opacity: .55;
    transition: .15s;
}

.sap-table tr:hover .action-group {
    opacity: 1;
}

.btn-xs {
    padding: 5px 9px;
    font-size: 11px;
    border-radius: 8px;
}

/* EMPTY */
.sap-empty {
    padding: 60px 0;
    text-align: center;
    color: #6b7280;
}

.sap-empty strong {
    display: block;
    margin-bottom: 6px;
    font-size: 14px;
    color: #374151;
}

/* LOADING */
.sap-loading {
    position: absolute;
    inset: 0;
    background: rgba(255, 255, 255, .85);
    z-index: 10;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.sap-loading p {
    margin-top: 10px;
    font-weight: 600;
    color: #374151;
}

/* FIX MCU */
#tableDataMCUCrew {
    width: 100%;
    table-layout: fixed;
}

#tableDataMCUCrew th,
#tableDataMCUCrew td {
    white-space: normal !important;
    word-break: break-word;
    overflow-wrap: break-word;
}
.column-search {
    width: 100%;
    padding: 2px 4px;
    font-size: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
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
</style>

<script>
var tableDataMCUCrew;
$(document).ready(function() {
    tableDataMCUCrew = $('#tableDataMCUCrew').DataTable({
        dom: "<'row mb-2'<'col-md-6 d-flex align-items-center'l><'col-md-6 text-end'f>>" +
             "<'row'<'col-md-12'tr>>" +
             "<'row mt-2'<'col-md-6'i><'col-md-6 d-flex justify-content-end'p>>",
        processing : true,
        serverSide : false,
        pageLength : 10,
        lengthMenu : [10, 25, 50, 100],
        ajax: {
            url: '<?php echo base_url("searchTableDataMCU"); ?>',
            dataSrc: function(json) { return json.data ? json.data : []; }
        },
        orderCellsTop: true,
        columns: [
            { data: null, className: 'text-center', render: function(data, type, row, meta) { return meta.row + 1; } },
            { data: 'fullname', render: function(data, type, row) { 
                if (type === 'display') {
                    return '<div style="font-weight:600;font-size:12px;color:#1f2d3d;">'+(data||'-')+'</div>'+
                           '<div style="font-size:11px;color:#868e96;margin-top:2px;">'+(row.email||'-')+'</div>';
                }
                return data;
            }},
            { data: 'position_applied', render: function(data, type, row) {
                if (type === 'display') {
                    return '<div style="font-size:12px;font-weight:600;color:#34495e;">'+(data||'-')+'</div>'+
                           '<div style="font-size:11px;color:#7f8c8d;margin-top:2px;">'+(row.ijazah_terakhir||'-')+'</div>';
                }
                return data;
            }},
            { data: 'born_place', render: function(data, type, row) {
                if (type === 'display') {
                    return '<div>'+(data||'-')+'</div>'+
                           '<div style="color:#868e96;">'+(row.born_date||'-')+'</div>';
                }
                return data;
            }},
            { data: 'handphone', render: function(data) { return data || '-'; } },
            { data: 'vessel_type', render: function(data) { return data || '-'; } },
            { data: 'last_experience', render: function(data, type, row) {
                if (type === 'display') {
                    let vesselExp = "-";
                    if (row.pengalaman_jeniskapal) {
                        vesselExp = `<div style="color:#868e96;line-height:1.4;white-space:normal;word-break:break-word;margin-top:4px;">`+
                                    row.pengalaman_jeniskapal.split(',').map(v => `<div>${v.trim()}</div>`).join('') +
                                    `</div>`;
                    }
                    return `<div style="font-weight:600;color:#34495e;margin-bottom:6px;">${data || "-"}</div>${vesselExp}`;
                }
                return data;
            }},
            { data: 'berlayardengancrewasing', render: function(data, type, row) {
                if (type === 'display') {
                    let foreignBlock = "-";
                    const foreignCrew = data || "-";
                    if (foreignCrew !== "-" && foreignCrew.includes("-")) {
                        const parts = foreignCrew.split("-");
                        const status = parts[0].trim();
                        const countries = parts.slice(1).join("-").trim();
                        foreignBlock = `
                            <div style="font-weight:600;color:#0b7285;margin-bottom:4px;">${status} -</div>
                            <div style="color:#495057;font-size:11px;line-height:1.4;text-align:center;white-space:normal;word-break:break-word;margin:auto;">` +
                            countries.split(',').map(c => c.trim()).join(', ') +
                            `</div>`;
                    } else {
                        foreignBlock = `<div>${foreignCrew}</div>`;
                    }
                    return foreignBlock;
                }
                return data;
            }},
            { data: null, className: 'text-center', render: function(data, type, row) {
                return `
                    <div style="display:flex;flex-direction:column;align-items:center;gap:4px;">
                        <span style="background:#e7f5ff;color:#1971c2;padding:2px 6px;border-radius:10px;font-size:9px;font-weight:600;">
                            ${row.last_salary_currency || '-'}
                        </span>
                        <span style="font-size:11px;font-weight:600;color:#065f46;">
                            ${formatSalary(row.last_salary, '')}
                        </span>
                    </div>`;
            }},
            { data: null, className: 'text-center', render: function(data, type, row) {
                return `
                    <div style="display:flex;flex-direction:column;align-items:center;gap:4px;">
                        <span style="background:#e7f5ff;color:#1971c2;padding:2px 6px;border-radius:10px;font-size:9px;font-weight:600;">
                            ${row.expected_salary_currency || '-'}
                        </span>
                        <span style="font-size:11px;font-weight:600;color:#065f46;">
                            ${formatSalary(row.expected_salary, '')}
                        </span>
                    </div>`;
            }},
            { data: 'join_inAndhika', className: 'text-center', render: function(data) { return data || '-'; } },
            { data: 'submit_cv', render: function(data) { return data || '-'; } },
            { data: null, className: 'text-center', render: function(data, type, row) {
                return `
                    <div style="display:flex;flex-direction:column;gap:4px;">
                        <button style="border:1px solid #dee2e6;background:#fff;font-size:11px;padding:4px;border-radius:4px;cursor:pointer;" onclick="window.open('${row.cv_url}','_blank')">📄 View CV</button>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:4px;margin-top:4px;">
                        <button style="border:1px solid #dc3545;background:#fff;color:#dc3545;font-size:11px;padding:4px;border-radius:4px;cursor:pointer;" onclick="withdrawApplicant('${row.id}')">🚫 Withdraw</button>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:4px;margin-top:4px;">
                        <button style="border:1px solid #dc3545;background:#fff;color:#dc3545;font-size:11px;padding:4px;border-radius:4px;cursor:pointer;" onclick="setNotFitApplicant('${row.id}')"><i class="fas fa-user-slash"></i> Not Fit</button>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:4px;margin-top:4px;">
                        <button style="border:1px solid #28a745;background:#fff;color:#28a745;font-size:11px;padding:4px;border-radius:4px;cursor:pointer;" onclick="setMCUApplicant('${row.id}')"><i class="fas fa-user-check"></i> Fit</button>
                    </div>`;
            }}
        ],
        initComplete: function () {
            initDropdownFilters(this.api());
        },
        language: {
            lengthMenu: '_MENU_ &nbsp;Entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            infoEmpty: 'Showing 0 to 0 of 0 entries',
            infoFiltered: '(filtered from _MAX_ total entries)',
            search: 'Search:',
            emptyTable: 'Tidak ada data MCU Applicant',
            zeroRecords: 'Data tidak ditemukan'
        },
        createdRow: function(row, data, dataIndex) {
            $(row).attr('id', 'row_' + data.id);
            $(row).css('border-bottom', '1px solid #eef1f5');
            $(row).css('transition', 'background 0.3s ease');
            
            $('td', row).eq(0).css({'font-size':'11px','color':'#868e96','vertical-align':'top'});
            $('td', row).eq(1).css({'vertical-align':'top'});
            $('td', row).eq(2).css({'vertical-align':'top'});
            $('td', row).eq(3).css({'font-size':'11px','color':'#495057','vertical-align':'top'});
            $('td', row).eq(4).css({'font-size':'11px','vertical-align':'top'});
            $('td', row).eq(5).css({'font-size':'11px','vertical-align':'top','white-space':'normal','word-break':'break-word','max-width':'140px'});
            $('td', row).eq(6).css({'font-size':'11px','vertical-align':'top'});
            $('td', row).eq(7).css({'font-size':'11px','text-align':'center','vertical-align':'top'});
            $('td', row).eq(8).css({'font-size':'11px','text-align':'center','vertical-align':'top','padding-top':'12px'});
            $('td', row).eq(9).css({'font-size':'11px','text-align':'center','vertical-align':'top','padding-top':'12px'});
            $('td', row).eq(10).css({'font-size':'11px','text-align':'center','vertical-align':'top'});
            $('td', row).eq(11).css({'font-size':'11px','color':'#868e96','vertical-align':'top'});
            $('td', row).eq(12).css({'text-align':'center','min-width':'120px','vertical-align':'top'});
        }
    });

    // Column search
    $('#tableDataMCUCrew thead tr:eq(1) .column-search').on('keyup change', function() {
        tableDataMCUCrew.column($(this).parent().index()).search(this.value).draw();
    });
});

function initDropdownFilters(api) {
    $('#tableDataMCUCrew thead th').each(function (colIndex) {
        var icon = $(this).find('.filter-icon');
        if (!icon.length) return;
        if (colIndex === 0 || colIndex === 12) return; // skip No & Action

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

        icon.on('click', function (e) {
            e.stopPropagation();
            $('.filter-dropdown').hide();
            var off = icon.offset();
            dropdown.css({ top: off.top + icon.outerHeight(), left: off.left }).toggle();
        });

        dropdown.find('.filter-search').on('keyup', function () {
            var kw = $(this).val().toLowerCase();
            listContainer.find('label').each(function () {
                $(this).toggle($(this).text().toLowerCase().includes(kw));
            });
        });

        dropdown.on('change', 'input[type="checkbox"]', function () {
            var selected = [];
            dropdown.find('input[type="checkbox"]:checked').each(function () { selected.push($(this).val()); });
            if (selected.length > 0) {
                var regex = selected.map(function(v){ return v.replace(/[.*+?^${}()|[\\]\\\\]/g, '\\\\$&'); }).join('|');
                api.column(colIndex).search(regex, true, false).draw();
            } else {
                api.column(colIndex).search('').draw();
            }
            dropdown.hide();
        });

        dropdown.on('click', '.btn-clear-filter', function () {
            dropdown.find('input').prop('checked', false);
            dropdown.find('.filter-search').val('');
            listContainer.find('label').show();
            api.column(colIndex).search('').draw();
            dropdown.hide();
        });
    });
}

$(document).on('click', function (e) {
    if (!$(e.target).closest('.filter-dropdown').length) $('.filter-dropdown').hide();
});

function animateRemoveRow(row) {
    if (!row) return;
    row.style.transition = "all 0.5s ease";
    row.style.backgroundColor = "#ffe8e8";
    setTimeout(() => {
        row.style.opacity = "0";
        row.style.transform = "translateX(-40px)";
        row.style.height = "0";
    }, 50);
    setTimeout(() => {
        row.remove();
        if(tableDataMCUCrew) tableDataMCUCrew.draw(false);
    }, 500);
}

function withdrawApplicant(applicantId) {

    Swal.fire({
        title: 'Withdraw Applicant?',
        text: 'This applicant will be marked as MCU Withdraw.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Withdraw',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#d33'
    }).then((result) => {

        if (!result.isConfirmed) return;

        $("#idLoadingSpinnerMCU").show();

        $.ajax({
            url: '<?php echo base_url("withdrawApplicant"); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id: applicantId
            },

            success: function(res) {

                $("#idLoadingSpinnerMCU").hide();

                if (res.status === 'success') {

                    const row = document.getElementById(`row_${applicantId}`);

                    if (row) {
                        animateRemoveRow(row);
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: res.message || 'Failed to withdraw applicant.'
                    });

                }
            },

            error: function(xhr) {

                $("#idLoadingSpinnerMCU").hide();

                console.log(xhr.responseText);

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing your request.'
                });
            }
        });

    });
}

function setNotFitApplicant(applicantId) {

    Swal.fire({
        title: 'Set as Not Fit?',
        text: 'This applicant will be marked as Not Fit for the position.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Set as Not Fit',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#d33'
    }).then((result) => {

        if (!result.isConfirmed) return;

        $("#idLoadingSpinnerMCU").show();

        $.ajax({
            url: '<?php echo base_url("notFitApplicant"); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id: applicantId
            },

            success: function(res) {

                $("#idLoadingSpinnerMCU").hide();

                if (res.status === 'success') {

                    const row = document.getElementById(`row_${applicantId}`);

                    if (row) {
                        animateRemoveRow(row);
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: res.message || 'Failed to withdraw applicant.'
                    });

                }
            },

            error: function(xhr) {

                $("#idLoadingSpinnerMCU").hide();

                console.log(xhr.responseText);

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing your request.'
                });
            }
        });

    });
}

function setMCUApplicant(applicantId) {

    Swal.fire({
        title: 'Konfirmasi',
        text: 'Apakah crew ini Lolos MCU?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#067780',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Lolos MCU',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if (!result.isConfirmed) return;

        $("#idLoadingSpinnerMCU").fadeIn();

        $.ajax({
            url: '<?php echo base_url("fitApplicant") ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id: applicantId,
                status: 6
            },

            success: function(response) {

                $("#idLoadingSpinnerMCU").fadeOut();

                if (response.status !== 'success') {

                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: response.message || 'Failed to set MCU applicant.'
                    });

                    return;
                }

                const row = document.getElementById(`row_${applicantId}`);

                if (row) {
                    animateRemoveRow(row);
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });

                const totalEl = document.getElementById('totalApplicants');
                if (totalEl) {
                    let total = parseInt(totalEl.innerText || 0);
                    if (total > 0) {
                        totalEl.innerText = total - 1;
                    }
                }
            },

            error: function(xhr, status, error) {

                $("#idLoadingSpinnerMCU").fadeOut();

                console.error(xhr.responseText);

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan sistem: ' + error
                });
            }
        });

    });
}

function formatSalary(amount, currency) {
    if (amount === null || amount === undefined || amount === '' || amount === 0 || amount === '0') {
        return '-';
    }
    const num = parseFloat(String(amount).replace(/,/g, ''));
    if (isNaN(num)) {
        return String(amount);
    }
    return num.toLocaleString('en-US', { maximumFractionDigits: 2 });
}
</script>


<style>
  /* .crew-header th {
    background-color: #000099 !important;
    color: white !important;
    font-size: 11px;
    vertical-align: middle;
  } */
     .crew-header th {
    background-color: #000099 !important;
    color: white !important;
    font-size: 11px;
    vertical-align: middle;
  }
</style>

<div class="crew-rotation-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow">
          <div class="card-body">

            <div id="idLoadingSpinnerMCU" class="sap-loading" style="display:none;">
                <svg width="56" height="56" viewBox="0 0 50 50">
                    <circle cx="25" cy="25" r="20" fill="none" stroke="#2563eb" stroke-width="4" stroke-linecap="round" stroke-dasharray="31.4 31.4">
                        <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s" repeatCount="indefinite" />
                    </circle>
                </svg>
                <p>Processing data…</p>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered align-middle mb-0 crew-table" id="tableDataMCUCrew" style="width:100%; font-size:11px;">
                <thead class="crew-header">
                    <tr>
                        <th style="width:40px;" class="text-center">No</th>
                        <th style="min-width:150px;">Seafarer <span class="filter-icon">☰</span></th>
                        <th style="min-width:160px;">Position Applied & Cert <span class="filter-icon">☰</span></th>
                        <th style="min-width:100px;">Birth <span class="filter-icon">☰</span></th>
                        <th style="min-width:100px;">Phone <span class="filter-icon">☰</span></th>
                        <th style="min-width:110px;">Apply Vessel Type <span class="filter-icon">☰</span></th>
                        <th style="min-width:140px;">Experience <span class="filter-icon">☰</span></th>
                        <th style="min-width:100px;">Foreign <span class="filter-icon">☰</span></th>
                        <th style="min-width:80px;text-align:center;">Last Salary</th>
                        <th style="min-width:100px;text-align:center;">Expected Salary</th>
                        <th style="min-width:70px;">Prev Join <span class="filter-icon">☰</span></th>
                        <th style="min-width:110px;">Submit Date</th>
                        <th style="min-width:120px;">Action</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th></th>
                        <th><input type="text" class="column-search" placeholder="Search..."></th>
                        <th><input type="text" class="column-search" placeholder="Search..."></th>
                        <th><input type="text" class="column-search" placeholder="Search..."></th>
                        <th><input type="text" class="column-search" placeholder="Search..."></th>
                        <th><input type="text" class="column-search" placeholder="Search..."></th>
                        <th><input type="text" class="column-search" placeholder="Search..."></th>
                        <th><input type="text" class="column-search" placeholder="Search..."></th>
                        <th><input type="text" class="column-search" placeholder="Search..."></th>
                        <th><input type="text" class="column-search" placeholder="Search..."></th>
                        <th>
                            <select class="column-search">
                                <option value="">All</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </th>
                        <th><input type="text" class="column-search" placeholder="Search..."></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="idTbodyMCUCrew"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>