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

.sap-table {
    width: 100%;
    table-layout: fixed;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 13px;
}

/* shadow effect waktu scroll */
.sap-table-wrapper.scrolling thead th {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.06);
}

.sap-table tbody tr {
    transition: background .15s ease;
}

.sap-table tbody tr:hover {
    background: #f1f5f9;
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

/* EMPTY STATE */
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

.swal2-container {
    z-index: 99999 !important;
}

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

    white-space: normal;
    word-break: break-word;
}

.sap-table thead th:last-child {
    border-right: none;
}

/* shadow effect waktu scroll */
.sap-table-wrapper.scrolling thead th {
    box-shadow: 0 2px 4px rgba(0, 0, 0, .06);
}

.sap-table tbody td {
    padding: 10px;
    vertical-align: top;

    border-right: 1px solid #d5deea;
    border-bottom: 1px solid #d5deea;

    background: #fff;

    white-space: normal;
    word-break: break-word;
    overflow-wrap: break-word;
}

.sap-table tbody td:last-child {
    border-right: none;
}

/* zebra */
.sap-table tbody tr:nth-child(even) td {
    background: #f8fafc;
}

/* hover */
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

/* EMPTY STATE */
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

.sap-table th:last-child,
.sap-table td:last-child {
    border-right: none;
}

.sap-table tbody tr:nth-child(even) td {
    background: #f8fafc;
}

.sap-table tbody tr:hover td {
    background: #edf4ff;
    transition: .15s ease;
}

/* FIX INTERVIEW */
#tableDataInterviewCrew {
    width: 100%;
    table-layout: fixed;
}
#tableDataInterviewCrew th,
#tableDataInterviewCrew td {
    white-space: normal !important;
    word-break: break-word;
    overflow-wrap: break-word;
}
.column-search {
    width: 100%;
    min-width: 0;
    box-sizing: border-box;
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
document.addEventListener("DOMContentLoaded", function() {
    // Left empty for compatibility
});

var tableDataInterviewCrew;
$(document).ready(function() {
    tableDataInterviewCrew = $('#tableDataInterviewCrew').DataTable({
        dom: "<'row mb-2'<'col-md-6 d-flex align-items-center'l><'col-md-6 text-end'f>>" +
             "<'row'<'col-md-12'tr>>" +
             "<'row mt-2'<'col-md-6'i><'col-md-6 d-flex justify-content-end'p>>",
        processing : true,
        serverSide : false,
        autoWidth  : false,
        pageLength : 10,
        lengthMenu : [10, 25, 50, 100],
        ajax: {
            url: '<?php echo base_url("searchDataInterview"); ?>',
            dataSrc: function(json) { return json.data ? json.data : []; }
        },
        orderCellsTop: true,
        columns: [
            { data: null, className: 'text-left', render: function(data, type, row, meta) { return meta.row + 1; } },
            { data: 'fullname', render: function(data, type, row) { 
                if (type === 'display') {
                    return '<div style="font-weight:600;font-size:14px;color:#1f2d3d;">'+(data||'-')+'</div>'+
                           '<div style="font-size:12px;color:#868e96;margin-top:2px;">'+(row.email||'-')+'</div>';
                }
                return data;
            }},
            { data: 'position_applied', render: function(data, type, row) {
                if (type === 'display') {
                    return '<div style="font-size:13px;font-weight:600;color:#34495e;">'+(data||'-')+'</div>'+
                           '<div style="font-size:12px;color:#7f8c8d;white-space:normal;word-break:break-word;">'+(row.ijazah_terakhir||'-')+'</div>';
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
            { data: 'vessel_type', render: function(data, type) { 
                if (type === 'display') {
                    return '<div style="font-size:12px;color:#7f8c8d;text-align:left;white-space:normal;word-break:break-word;">'+(data||'-')+'</div>';
                }
                return data;
            }},
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
                            <div style="color:#495057;font-size:11px;line-height:1.4;text-align:center;white-space:normal;word-break:break-word;max-width:150px;margin:auto;">` +
                            countries.split(',').map(c => `<div>${c.trim()}</div>`).join('') +
                            `</div>`;
                    } else {
                        foreignBlock = `<div>${foreignCrew}</div>`;
                    }
                    return foreignBlock;
                }
                return data;
            }},
            { data: null, className: 'text-right', render: function(data, type, row) {
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
            { data: null, className: 'text-right', render: function(data, type, row) {
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
                        <button style="border:1px solid #dee2e6;background:#fff;font-size:12px;padding:5px;border-radius:4px;cursor:pointer;" onclick="window.open('${row.cv_url}','_blank')">📄 View CV</button>
                        <button style="background:#e6fcf5;border:1px solid #20c997;color:#087f5b;font-size:12px;padding:5px;border-radius:4px;cursor:pointer;" onclick="passInterview('${row.id}')">✔ Qualified</button>
                        <button style="background:#fff5f5;border:1px solid #ffa8a8;color:#c92a2a;font-size:12px;padding:5px;border-radius:4px;cursor:pointer;" onclick="notQualifyInterview('${row.id}','<b><i>:: '+(row.fullname||'-')+' ::</i></b>')">✖ Not Qualified</button>
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
            emptyTable: 'Tidak ada data Interview Applicant',
            zeroRecords: 'Data tidak ditemukan'
        },
        createdRow: function(row, data, dataIndex) {
            $(row).attr('id', 'row_' + data.id);
            $(row).css('border-bottom', '1px solid #eef1f5');
            $(row).css('transition', 'background 0.3s ease');
            
            $('td', row).eq(0).css({'text-align':'center','font-size':'12px','color':'#868e96','vertical-align':'top'});
            $('td', row).eq(1).css({'vertical-align':'top'});
            $('td', row).eq(2).css({'vertical-align':'top'});
            $('td', row).eq(3).css({'color':'#495057','vertical-align':'top'});
            $('td', row).eq(4).css({'vertical-align':'top'});
            $('td', row).eq(5).css({'vertical-align':'top'});
            $('td', row).eq(6).css({'font-size':'12px','vertical-align':'top','min-width':'220px'});
            $('td', row).eq(7).css({'font-size':'12px','text-align':'center','vertical-align':'top','min-width':'170px','padding-top':'6px'});
            $('td', row).eq(8).css({'font-size':'12px','text-align':'right','font-weight':'600','color':'#065f46','vertical-align':'top'});
            $('td', row).eq(9).css({'font-size':'12px','text-align':'right','font-weight':'600','color':'#065f46','vertical-align':'top'});
            $('td', row).eq(10).css({'font-size':'12px','text-align':'center','vertical-align':'top'});
            $('td', row).eq(11).css({'font-size':'12px','color':'#868e96','vertical-align':'top'});
            $('td', row).eq(12).css({'text-align':'center','min-width':'120px','vertical-align':'top'});
        }
    });

    // Column search
    $('#tableDataInterviewCrew thead tr:eq(1) .column-search').on('keyup change', function() {
        tableDataInterviewCrew.column($(this).parent().index()).search(this.value).draw();
    });
});

function initDropdownFilters(api) {
    $('#tableDataInterviewCrew thead th').each(function (colIndex) {
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

function notQualifyInterview(id, name) {
    $("#notReffId").val(id);
    $("#notReffReason").val("");

    $("#modalInterviewCrew").modal("hide");

    setTimeout(() => {
        $("#modalNotReff").modal({
            backdrop: 'static',
            keyboard: false
        }).modal("show");

        $("#notReffReason").focus();
    }, 300);
}

function closeNotReffModal() {
    $("#modalNotReff").modal("hide");
}


function passInterview(applicantId) {

    Swal.fire({
        title: 'Konfirmasi',
        html: 'Apakah crew ini <b>lolos interview</b> dan akan lanjut ke proses <span style="color:#067780;font-weight:600;">MCU</span>?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#067780',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, lanjut ke MCU',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if (!result.isConfirmed) return;

        $("#idLoadingSpinnerNotReff").fadeIn();

        $.ajax({
            url: "<?php echo base_url("passInterview"); ?> ",
            type: "POST",
            dataType: "json",
            data: {
                id: applicantId
            },

            success: function(res) {

                $("#idLoadingSpinnerNotReff").fadeOut();

                if (res.status === "error") {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: res.message
                    });
                    return;
                }

                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: res.message,
                    timer: 1200,
                    showConfirmButton: false
                });

                const row = document.getElementById("row_" + applicantId);
                animateRemoveRow(row);

            },

            error: function(xhr, status, error) {

                $("#idLoadingSpinnerNotReff").fadeOut();

                Swal.fire({
                    icon: "error",
                    title: "System Error",
                    text: error
                });
            }
        });

    });
}

function renumberTableRows() {

    const tbody = document.getElementById("idTbodyInterviewCrew");

    if (!tbody) return;

    const rows = tbody.querySelectorAll("tr");

    rows.forEach((row, index) => {

        const firstCell = row.querySelector("td");

        if (firstCell) {
            firstCell.innerText = index + 1;
        }

    });

}

function animateRemoveRow(row) {

    if (!row) return;

    const tbody = document.getElementById("idTbodyInterviewCrew");

    row.style.transition = "all .35s ease";
    row.style.background = "#fff4e6";

    setTimeout(() => {
        row.style.opacity = "0";
        row.style.transform = "translateX(-30px)";
    }, 10);

    setTimeout(() => {

        row.remove();

        renumberTableRows();

        const total = document.getElementById("totalApplicants");
        if (total) total.innerText = parseInt(total.innerText) - 1;

    }, 350);
}

function submitNotReff() {

    let applicantId = $("#notReffId").val();
    let reason = $("#notReffReason").val().trim();

    if (reason === "") {
        Swal.fire({
            icon: "warning",
            title: "Perhatian",
            text: "Alasan wajib diisi!"
        });
        return;
    }

    Swal.fire({
        title: 'Konfirmasi',
        html: 'Apakah crew ini <b>tidak lolos interview</b> dan akan dipindahkan ke status <span style="color:#d33;font-weight:600;">Not Qualified Interview</span>?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Tidak Lolos',
        cancelButtonText: 'Batal',
        customClass: {
            container: 'swal-top-zindex'
        }
    }).then((result) => {

        if (!result.isConfirmed) return;

        $("#idLoadingSpinnerNotReff").fadeIn();

        $.ajax({
            url: '<?php echo base_url("notQualifiedInterview") ?>',
            type: "POST",
            dataType: "json",
            data: {
                id: applicantId,
                reason: reason
            },

            success: function(res) {

                $("#idLoadingSpinnerNotReff").fadeOut();

                if (res.status === "error") {
                    Swal.fire({
                        icon: "error",
                        title: "Gagal",
                        text: res.message
                    });
                    return;
                }

                $("#modalNotReff").modal("hide");

                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: res.message,
                    timer: 1200,
                    showConfirmButton: false
                });

                const row = document.getElementById("row_" + applicantId);

                if (row) {
                    animateRemoveRow(row);
                } else {
                    let currentPage = $('#tableDataInterviewCrew').attr('data-current-page') || 1;

                    if ($("#idTbodyInterviewCrew tr").length <= 2) {
                        currentPage = Math.max(1, currentPage - 1);
                    }

                    loadPageDataInterview(currentPage);
                }
            },

            error: function(xhr, status, error) {

                $("#idLoadingSpinnerNotReff").fadeOut();

                Swal.fire({
                    icon: "error",
                    title: "System Error",
                    text: error
                });
            }
        });

    });
}
</script>

<div id="applicantsWorkspace" class="sap-workspace">

    <!-- <div class="sap-header">
        <div class="sap-header-left">
            <h2><?php echo $title; ?></h2>
            <span>Recruitment Management · Talent Intake</span>
        </div>
    </div> -->


<style>
  .crew-header th {
    background-color: #000099 !important;
    color: white !important;
    font-size: 11px;
    vertical-align: middle;
  }
  .crew-search-header th {
    background-color: #ffffff !important;
    padding: 8px 4px !important;
  }
</style>

        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0 sap-table" id="tableDataInterviewCrew" style="width:100%;">
                <thead class="crew-header">
                    <tr>
                        <th style="width:5%; min-width:40px;" class="text-center">No</th>
                        <th style="width:15%;">Seafarer <span class="filter-icon">☰</span></th>
                        <th style="width:12%;">Position Applied & Cert <span class="filter-icon">☰</span></th>
                        <th style="width:8%;">Birth <span class="filter-icon">☰</span></th>
                        <th style="width:8%;">Phone <span class="filter-icon">☰</span></th>
                        <th style="width:8%;">Apply Vessel Type <span class="filter-icon">☰</span></th>
                        <th style="width:14%;">Experience <span class="filter-icon">☰</span></th>
                        <th style="width:10%;">Foreign <span class="filter-icon">☰</span></th>
                        <th style="width:7%;text-align:right;">Last Salary</th>
                        <th style="width:7%;text-align:right;">Expected Salary</th>
                        <th style="width:5%;">Prev Join <span class="filter-icon">☰</span></th>
                        <th style="width:7%;">Submit Date</th>
                        <th style="width:10%;text-align:center;">Action</th>
                    </tr>
                </thead>
                <thead class="crew-search-header">
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
                        <th><input type="text" class="column-search" placeholder="Search..."></th>
                        <th><input type="text" class="column-search" placeholder="Search..."></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="idTbodyInterviewCrew"></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNotReff" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1070;">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 480px;">
        <div class="modal-content" style="
            border-radius:16px;
            border:none;
            overflow:hidden;
            box-shadow:0 20px 60px rgba(0,0,0,0.15);
            font-family:'Segoe UI', sans-serif;
        ">

            <div id="idLoadingSpinnerNotReff" style="
                display:none;
                pointer-events:none;
                position:absolute;
                top:0; left:0;
                width:100%; height:100%;
                background:rgba(255,255,255,0.85);
                backdrop-filter: blur(6px);
                z-index:9999;
                justify-content:center;
                align-items:center;
                flex-direction:column;
                border-radius:16px;
            ">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 50 50">
                    <circle cx="25" cy="25" r="20" fill="none" stroke="#067780" stroke-width="4" stroke-linecap="round"
                        stroke-dasharray="31.4 31.4">
                        <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25"
                            dur="0.9s" repeatCount="indefinite" />
                    </circle>
                </svg>
                <p style="
                    margin-top:16px;
                    font-size:14px;
                    color:#444;
                    font-weight:500;
                ">
                    Processing data...
                </p>
            </div>

            <div class="modal-header" style="
                background:#0a6ed1;
                padding:18px 20px;
                border:none;
                display:flex;
                align-items:center;
                justify-content:space-between;
            ">
                <div style="display:flex; align-items:center; gap:10px;">
                    <div style="
                        width:36px;
                        height:36px;
                        border-radius:10px;
                        background:rgba(255,255,255,0.2);
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:18px;
                        color:#fff;
                    ">
                        ⚠️
                    </div>
                    <h5 style="
                        margin:0;
                        color:#fff;
                        font-size:16px;
                        font-weight:600;
                        letter-spacing:0.3px;
                    ">
                        Input Alasan
                    </h5>
                </div>

                <button type="button" onclick="closeNotReffModal()" style="
                    border:none;
                    background:transparent;
                    font-size:20px;
                    color:#fff;
                    opacity:0.8;
                    cursor:pointer;
                ">
                    &times;
                </button>
            </div>

            <div class="modal-body" style="padding:22px 20px;">
                <input type="hidden" id="notReffId">

                <label style="
                    font-size:13px;
                    font-weight:600;
                    color:#444;
                    margin-bottom:8px;
                    display:block;
                ">
                    Alasan
                </label>

                <textarea id="notReffReason" rows="4" placeholder="Tuliskan alasan..." style="
                    width:100%;
                    border:1px solid #dcdcdc;
                    border-radius:10px;
                    padding:12px 14px;
                    font-size:13px;
                    outline:none;
                    transition:all 0.25s ease;
                    resize:none;
                " onfocus="this.style.borderColor='#067780'; this.style.boxShadow='0 0 0 3px rgba(6,119,128,0.1)'"
                    onblur="this.style.borderColor='#dcdcdc'; this.style.boxShadow='none'"></textarea>
            </div>

            <div class="modal-footer" style="
                border:none;
                padding:16px 20px 20px;
                display:flex;
                justify-content:flex-end;
                gap:10px;
            ">

                <button type="button" onclick="closeNotReffModal()" style="
                    padding:8px 16px;
                    border-radius:8px;
                    border:1px solid #ccc;
                    background:#f5f5f5;
                    font-size:13px;
                    cursor:pointer;
                    transition:0.2s;
                " onmouseover="this.style.background='#eaeaea'" onmouseout="this.style.background='#f5f5f5'">
                    Batal
                </button>

                <button type="button" onclick="submitNotReff()" style="
                    padding:9px 18px;
                    border-radius:8px;
                    border:none;
                    background:#0a6ed1;
                    color:#fff;
                    font-size:13px;
                    font-weight:600;
                    cursor:pointer;
                    box-shadow:0 6px 14px rgba(6,119,128,0.3);
                    transition:all 0.25s ease;
                " onmouseover="this.style.background='#055e66'; this.style.transform='translateY(-1px)'"
                    onmouseout="this.style.background='#067780'; this.style.transform='none'">
                    Simpan
                </button>

            </div>
        </div>
    </div>
</div>