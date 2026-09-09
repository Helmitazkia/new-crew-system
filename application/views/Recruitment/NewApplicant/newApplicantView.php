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
    overflow-x: auto;
    border: 1px solid #e5e9f2;
    border-radius: 6px;
    background: #fff;
}

.sap-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 13px;
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

    /* pembatas lebih jelas */
    border-right: 1px solid rgba(255, 255, 255, .85);
    border-bottom: 1px solid rgba(255, 255, 255, .4);
}

.sap-table thead th:last-child {
    border-right: none;
}

/* shadow effect waktu scroll */
.sap-table-wrapper.scrolling thead th {
    box-shadow: 0 2px 4px rgba(0, 0, 0, .06);
}

/* BODY */
.sap-table tbody td {
    padding: 12px;
    white-space: nowrap;
    vertical-align: middle;

    /* pembatas kolom */
    border-right: 1px solid #d5deea;

    /* pembatas baris */
    border-bottom: 1px solid #d5deea;

    background: #fff;
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

/* Dropdown filter for New Applicant */
.na-filter-dropdown {
    position: absolute;
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 10px;
    width: 220px;
    max-height: 280px;
    overflow-y: auto;
    box-shadow: 0 6px 20px rgba(0,0,0,.15);
    display: none;
    z-index: 9999;
    font-size: 13px;
}
.na-filter-search {
    width: 100%;
    margin-bottom: 8px;
    padding: 5px 8px;
    font-size: 12px;
    border: 1px solid #dee2e6;
    border-radius: 6px;
    box-sizing: border-box;
}
.na-filter-list {
    max-height: 140px;
    overflow-y: auto;
    margin-bottom: 4px;
}
.na-filter-list label {
    display: block;
    font-size: 12px;
    cursor: pointer;
    padding: 4px 6px;
    border-radius: 4px;
}
.na-filter-list label:hover { background: #f0f4ff; }
.na-btn-clear-filter {
    background: transparent;
    border: 1.5px solid #000099;
    color: #000099;
    border-radius: 20px;
    padding: 3px 12px;
    font-size: 11px;
    cursor: pointer;
    transition: all .2s;
}
.na-btn-clear-filter:hover { background: #000099; color: #fff; }
</style>

<script>
var tableDataReady;
$(document).ready(function() {
    tableDataReady = $('#tableDataReady').DataTable({
        dom: "<'row mb-2'<'col-md-6 d-flex align-items-center'l><'col-md-6 text-end'f>>" +
             "<'row'<'col-md-12'tr>>" +
             "<'row mt-2'<'col-md-6'i><'col-md-6 d-flex justify-content-end'p>>",
        processing : true,
        serverSide : false,
        autoWidth  : false,
        pageLength : 10,
        lengthMenu : [10, 25, 50, 100],
        ajax: {
            url: '<?php echo base_url("searchDataReady"); ?>',
            dataSrc: function(json) { return json.data ? json.data : []; }
        },
        orderCellsTop: true,
        columns: [
            { data: null, className: 'text-center', render: function(data, type, row, meta) { return meta.row + 1; } },
            { data: 'fullname', render: function(data, type, row) { 
                if (type === 'display') {
                    let badge = '';
                    if (row.submit_cv_raw && row.submit_cv_raw.startsWith(new Date().toISOString().slice(0, 10))) {
                        badge = '<span style="background:#0a6ed1;color:white;font-size:10px;font-weight:700;padding:3px 7px;border-radius:20px;margin-left:6px;">NEW</span>';
                    }
                    return '<div style="font-weight:600;font-size:14px;color:#1f2d3d;">'+(data||'-')+badge+'</div>'+
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
                    return '<div style="font-size:12px;color:#495057;">'+(data||'-')+'</div>'+
                           '<div style="font-size:12px;color:#868e96;">'+(row.born_date||'-')+'</div>';
                }
                return data;
            }},
            { data: 'handphone', render: function(data) { return data || '-'; }, className: 'text-left' },
            { data: 'vessel_type', render: function(data, type) { 
                if (type === 'display') {
                    return '<div style="font-size:12px;color:#7f8c8d;white-space:normal;word-break:break-word;">'+(data||'-')+'</div>';
                }
                return data;
            }, className: 'text-left' },
            { data: 'last_experience', render: function(data, type, row) {
                if (type === 'display') {
                    let vesselExp = "-";
                    if (row.pengalaman_jeniskapal) {
                        vesselExp = `<div style="color:#868e96;line-height:1.4;white-space:normal;word-break:break-word;max-width:130px;">`+
                                    row.pengalaman_jeniskapal.split(',').map(v => `<div>${v.trim()}</div>`).join('') +
                                    `</div>`;
                    }
                    return `<div style="font-weight:600;color:#34495e;margin-bottom:6px;">${data || "-"}</div>${vesselExp}`;
                }
                return data;
            }},
            { data: 'foreign_crew', className: 'text-center', render: function(data, type, row) {
                if (type === 'display') {
                    let foreignBlock = "-";
                    const foreignCrew = data || "-";
                    if (foreignCrew !== "-" && foreignCrew.includes("-")) {
                        const parts = foreignCrew.split("-");
                        const status = parts[0].trim();
                        const countries = parts.slice(1).join("-").trim();
                        foreignBlock = `
                            <div style="font-weight:600;color:#0b7285;margin-bottom:4px;">${status} -</div>
                            <div style="color:#495057;font-size:11px;line-height:1.4;text-align:left;white-space:normal;word-break:break-word;max-width:160px;margin:auto;">` +
                            countries.split(',').map(c => c.trim()).join('<br>') +
                            `</div>`;
                    } else {
                        foreignBlock = foreignCrew !== "-" ? foreignCrew : "-";
                    }
                    return foreignBlock;
                }
                return data;
            }},
            { data: 'last_salary', className: 'text-right', render: function(data, type) {
                if (type === 'display') {
                    return data ? '<div style="font-size:12px;color:#495057;">' + data + '</div>' : '-';
                }
                return data;
            }},
            { data: 'expected_salary', className: 'text-right', render: function(data, type) {
                if (type === 'display') {
                    return data ? '<div style="font-size:12px;color:#495057;">' + data + '</div>' : '-';
                }
                return data;
            }},
            { data: 'prev_join', className: 'text-center', render: function(data, type) {
                if (type === 'display') {
                    return data ? '<div style="font-size:12px;color:#495057;">' + data + '</div>' : '-';
                }
                return data;
            }},
            { data: 'submit_cv', className: 'text-center', render: function(data, type) {
                if (type === 'display') {
                    return data ? '<div style="font-size:12px;color:#495057;">' + data + '</div>' : '-';
                }
                return data;
            }},
            { data: null, className: 'text-center', orderable: false, render: function(data, type, row) {
                if (type === 'display') {
                    const name = (row.fullname || '').replace(/'/g, "\\'");
                    const position = (row.position_applied || '').replace(/'/g, "\\'");
                    const lastExp = (row.last_experience || '').replace(/'/g, "\\'");
                    const btnStyle = 'display:flex;align-items:center;justify-content:center;gap:5px;padding:5px 8px;font-size:11px;font-weight:500;border-radius:8px;cursor:pointer;transition:all .2s;width:calc(50% - 3px);white-space:nowrap;';
                    return `<div style="display:flex;flex-wrap:wrap;gap:5px;min-width:170px;">
                        <a href="${row.cv_url}" target="_blank"
                            style="${btnStyle}background:#f0f4ff;color:#2563eb;border:1px solid #c7d9ff;text-decoration:none;"
                            onmouseover="this.style.background='#2563eb';this.style.color='#fff'"
                            onmouseout="this.style.background='#f0f4ff';this.style.color='#2563eb'">
                            <i class="fas fa-file-alt" style="font-size:10px;"></i> View CV
                        </a>
                        <button
                            style="${btnStyle}background:#f0fff4;color:#067740;border:1px solid #a7f3c5;"
                            onmouseover="this.style.background='#067740';this.style.color='#fff'"
                            onmouseout="this.style.background='#f0fff4';this.style.color='#067740'"
                            onclick="QualifiedCrew(${row.id}, '${name}')">
                            <i class="fas fa-check" style="font-size:10px;"></i> Qualified
                        </button>
                        <button
                            style="${btnStyle}background:#fffbf0;color:#b45309;border:1px solid #fcd97a;"
                            onmouseover="this.style.background='#b45309';this.style.color='#fff'"
                            onmouseout="this.style.background='#fffbf0';this.style.color='#b45309'"
                            onclick="notPositionCrew(${row.id}, '${name}')">
                            <i class="fas fa-exclamation-triangle" style="font-size:10px;"></i> Not Position
                        </button>
                        <button
                            style="${btnStyle}background:#fff0f0;color:#b91c1c;border:1px solid #fca5a5;"
                            onmouseover="this.style.background='#b91c1c';this.style.color='#fff'"
                            onmouseout="this.style.background='#fff0f0';this.style.color='#b91c1c'"
                            data-id="${row.id}"
                            data-name="${name}"
                            data-position="${position}"
                            data-last-experience="${lastExp}"
                            onclick="showNotQualifyModalLayer1(this)">
                            <i class="fas fa-times" style="font-size:10px;"></i> Not Qualified
                        </button>
                        <button
                            style="${btnStyle}width:100%;background:#fff5f5;color:#9b1c1c;border:1px solid #fecaca;"
                            onmouseover="this.style.background='#9b1c1c';this.style.color='#fff'"
                            onmouseout="this.style.background='#fff5f5';this.style.color='#9b1c1c'"
                            onclick="deleteData(${row.id}, '${name}')">
                            <i class="fas fa-trash-alt" style="font-size:10px;"></i> Delete
                        </button>
                    </div>`;
                }
                return '';
            }}
        ],
        initComplete: function() {
            const api = this.api();
            const total = document.getElementById('totalApplicants');
            if (total) total.innerText = api.rows().count();

            api.on('draw', function() {
                if (total) total.innerText = api.rows({ search: 'applied' }).count();
            });

            // Column search inputs
            api.columns().every(function(colIdx) {
                const column = this;
                const input = $('thead.crew-search-header tr th').eq(colIdx).find('.column-search');
                if (input.length) {
                    input.on('keyup change clear', function() {
                        if (column.search() !== this.value) {
                            column.search(this.value).draw();
                        }
                    });
                }
            });

            // Dropdown filter icons
            initNewApplicantDropdownFilters(api);
        }, 
         language: {
            lengthMenu: '_MENU_ &nbsp;Entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            infoEmpty: 'Showing 0 to 0 of 0 entries',
            infoFiltered: '(filtered from _MAX_ total entries)',
            search: 'Search:',
            emptyTable: 'Tidak ada data New Applicant',
            zeroRecords: 'Data tidak ditemukan'
        },
    });
});

function initNewApplicantDropdownFilters(api) {
    $('#tableDataReady thead.crew-header th').each(function(colIndex) {
        var icon = $(this).find('.filter-icon');
        if (!icon.length) return;
        if (colIndex === 0 || colIndex === 12) return; // skip No & Action

        var dropdown = $('<div class="na-filter-dropdown">'
            + '<input type="text" class="na-filter-search" placeholder="Search options...">'
            + '<div class="na-filter-list"></div>'
            + '<hr style="margin:6px 0;">'
            + '<div style="text-align:center;">'
            + '<button class="na-btn-clear-filter"><i class="fas fa-eraser"></i> Clear</button>'
            + '</div>'
            + '</div>').appendTo('body');

        var listContainer = dropdown.find('.na-filter-list');

        try {
            var colData = api.column(colIndex).data();
            if (colData && typeof colData.unique === 'function') {
                var uniqueVals = [];
                colData.unique().each(function(val) {
                    if (val && val !== '-' && val !== '') {
                        var tmp = document.createElement('div');
                        tmp.innerHTML = val;
                        var text = (tmp.textContent || tmp.innerText || '').trim();
                        if (text && !uniqueVals.includes(text)) uniqueVals.push(text);
                    }
                });
                uniqueVals.sort().forEach(function(val) {
                    var safe = String(val).replace(/</g,'&lt;').replace(/>/g,'&gt;');
                    listContainer.append('<label><input type="checkbox" value="'+ safe +'"> '+ safe +'</label>');
                });
            }
        } catch(err) { console.warn('Filter err col '+ colIndex, err); }

        icon.on('click', function(e) {
            e.stopImmediatePropagation();
            e.preventDefault();
            $('.na-filter-dropdown').not(dropdown).hide();
            var off = icon.offset();
            dropdown.css({ top: off.top + icon.outerHeight() + 4, left: off.left }).toggle();
        });

        dropdown.find('.na-filter-search').on('keyup', function() {
            var kw = $(this).val().toLowerCase();
            listContainer.find('label').each(function() {
                $(this).toggle($(this).text().toLowerCase().includes(kw));
            });
        });

        dropdown.on('change', 'input[type="checkbox"]', function() {
            var selected = [];
            dropdown.find('input[type="checkbox"]:checked').each(function() { selected.push($(this).val()); });
            if (selected.length > 0) {
                var regex = selected.map(function(v){ return v.replace(/[.*+?^${}()|[\]\\]/g,'\\$&'); }).join('|');
                api.column(colIndex).search(regex, true, false).draw();
            } else {
                api.column(colIndex).search('').draw();
            }
            dropdown.hide();
        });

        dropdown.on('click', '.na-btn-clear-filter', function() {
            dropdown.find('input').prop('checked', false);
            dropdown.find('.na-filter-search').val('');
            listContainer.find('label').show();
            api.column(colIndex).search('').draw();
            dropdown.hide();
        });
    });

    $(document).on('click.naFilter', function(e) {
        if (!$(e.target).closest('.na-filter-dropdown').length &&
            !$(e.target).hasClass('filter-icon')) {
            $('.na-filter-dropdown').hide();
        }
    });
}

function deleteData(id, name) {

    Swal.fire({
        title: "Confirmation",
        html: `Are you sure you want to delete <b>${name}</b>'s application? This action cannot be undone.`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#e03131",
        cancelButtonColor: "#6b7280",
        confirmButtonText: "Yes, Delete",
        cancelButtonText: "Cancel"
    }).then((result) => {

        if (!result.isConfirmed) return;

        $("#idLoadingSpinner").fadeIn();

        $.ajax({
            url: "<?php echo base_url('deleteApplicant'); ?>",
            type: "POST",
            data: {
                id: id
            },
            dataType: "json",

            success: function() {

                $("#idLoadingSpinner").fadeOut();

                if (typeof tableDataReady !== 'undefined' && tableDataReady.ajax) {
                    tableDataReady.ajax.reload(null, false);
                }

                Swal.fire({
                    title: "Deleted!",
                    text: "The applicant's data has been deleted.",
                    icon: "success",
                    timer: 1200,
                    showConfirmButton: false
                });

                const row = document.getElementById("row_" + id);

                animateRemoveRow(row);

            },

            error: function(xhr, status, error) {

                $("#idLoadingSpinner").fadeOut();

                Swal.fire({
                    title: "Error!",
                    text: "System error: " + error,
                    icon: "error"
                });

            }

        });

    });

}

function animateRemoveRow(row) {

    if (!row) return;

    const tbody = document.getElementById("idTbodylistCrewNewModal");
    const table = document.getElementById("tableDataReady");

    row.style.transition = "all .35s cubic-bezier(.4,0,.2,1)";
    row.style.background = "#fff5f5";

    setTimeout(() => {
        row.style.opacity = "0";
        row.style.transform = "translateX(-20px) scale(.97)";
    }, 10);

    setTimeout(() => {
        if (typeof tableDataReady !== 'undefined' && tableDataReady) {
            tableDataReady.row($(row)).remove().draw(false);
            
            const total = document.getElementById("totalApplicants");
            if (total) total.innerText = tableDataReady.rows().count();
        } else {
            row.remove();
        }
    }, 350);

}


function QualifiedCrew(id, name) {

    Swal.fire({
        title: "Konfirmasi",
        html: `Apakah anda yakin ingin menandai <b>${name}</b> sebagai <span style="color:#067780;font-weight:600;">Qualified</span>?`,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#067780",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Set Qualified",
        cancelButtonText: "Batal"
    }).then((result) => {

        if (!result.isConfirmed) return;

        $("#idLoadingSpinner").fadeIn();

        $.ajax({
            url: "<?php echo base_url('qualifiedCrew'); ?>",
            type: "POST",
            data: {
                id: id
            },
            dataType: "json",

            success: function() {

                $("#idLoadingSpinner").fadeOut();

                if (typeof tableDataReady !== 'undefined' && tableDataReady.ajax) {
                    tableDataReady.ajax.reload(null, false);
                }

                Swal.fire({
                    title: "Berhasil!",
                    text: "Crew telah ditandai sebagai Qualified.",
                    icon: "success",
                    timer: 1200,
                    showConfirmButton: false
                });

                const row = document.getElementById("row_" + id);

                animateRemoveRow(row);

            },

            error: function(xhr, status, error) {

                $("#idLoadingSpinner").fadeOut();

                Swal.fire({
                    title: "Error!",
                    text: "Terjadi kesalahan sistem: " + error,
                    icon: "error"
                });

            }

        });

    });

}

function showNotQualifyModalLayer1(btn) {

    const id = $(btn).data('id') || '';
    const name = $(btn).data('name') || '-';
    const position = $(btn).data('position') || '-';
    const lastExperience = $(btn).data('last-experience') || '-';

    $('#modalNotQualifyNameLayer1').html(`<i class='fas fa-user'></i> ${name}`);
    $('#modalNotQualifyPositionLayer1').html(`<i class='fas fa-briefcase'></i> ${position}`);
    $('#modalNotQualifyLastExperienceLayer1').html(`<i class='fas fa-calendar-alt'></i> ${lastExperience}`);

    $('#txtNotQualifyReason1').val('');
    $('#hiddenCrewIdLayer1').val(id);

    $('#certificateCheckboxContainer').html('<i>Loading sertifikat...</i>');

    $.ajax({
        url: '<?php echo base_url("getCertificate") ?>',
        type: 'GET',
        data: {
            position: position
        },

        success: function(response) {

            let html = '';

            if (response.length > 0) {

                response.forEach(cert => {

                    html += `
                    <div class="col-md-3">
                        <div class="form-check">
                            <input class="form-check-input cert-checkbox"
                                type="checkbox"
                                value="${cert.id}"
                                data-certname="${cert.certificate_name}"
                                id="cert_${cert.id}"
                                name="notQualifiedCertificates[]">

                            <label class="form-check-label"
                                for="cert_${cert.id}"
                                style="font-size:11px;">
                                ${cert.certificate_name}
                            </label>
                        </div>
                    </div>`;

                });

            } else {

                html = `<div class="col-12"><em>Tidak ada sertifikat untuk posisi ini.</em></div>`;

            }

            $('#certificateCheckboxContainer').html(html);

        },

        error: function() {

            $('#certificateCheckboxContainer')
                .html('<em>Gagal memuat sertifikat.</em>');

        }

    });


    $(document).off('change',
        '#certificateCheckboxContainer input[type="checkbox"], #rankCheckboxContainer input[type="checkbox"]'
    );

    $(document).on('change',
        '#certificateCheckboxContainer input[type="checkbox"], #rankCheckboxContainer input[type="checkbox"]',
        function() {

            const textarea = $('#txtNotQualifyReason1');
            const currentReason = textarea.val() || "";

            const lines = currentReason.split("\n");

            const manualLines = lines.filter(line => {

                const t = (line || "").trim().toLowerCase();

                return !(t.startsWith('sertifikat yang belum terpenuhi:') ||
                    t.startsWith('dengan melengkapi sertifikat di atas'));

            });

            const manualText = manualLines.join("\n").trim();

            let selectedCerts = [];

            $('#certificateCheckboxContainer input[type="checkbox"]:checked')
                .each(function() {

                    const certName = $(this).data('certname');

                    if (certName) selectedCerts.push(certName.trim());

                });

            let selectedRanks = [];

            $('#rankCheckboxContainer input[type="checkbox"]:checked')
                .each(function() {

                    let rankName = $(this).closest('label').text().trim();

                    if (!rankName) {
                        rankName = $(this).val();
                    }

                    if (rankName) selectedRanks.push(rankName);

                });

            let parts = [];

            if (manualText) parts.push(manualText);

            if (selectedCerts.length > 0) {
                parts.push('Sertifikat yang belum terpenuhi: ' + selectedCerts.join(', '));
            }

            if (selectedRanks.length > 0) {
                parts.push('Dengan melengkapi sertifikat di atas, Anda bisa melamar untuk posisi: ' + selectedRanks
                    .join(', '));
            }

            textarea.val(parts.join("\n"));

        });


    const $currentModal = $(btn).closest('.modal');

    if ($currentModal.length) {

        const instance = bootstrap.Modal.getInstance($currentModal[0]);

        if (instance) {
            instance.hide();
        }

    }


    const modalEl = document.getElementById('modalNotQualifyLayer1');

    loadRankCheckbox();

    const modal = new bootstrap.Modal(modalEl, {
        backdrop: 'static',
        keyboard: false
    });

    modal.show();

}

function submitNotQualifiedLayer1() {

    const id = $("#hiddenCrewIdLayer1").val();
    const name = $("#hiddenCrewNameLayer1").val() || "Crew";
    const reason = $("#txtNotQualifyReason1").val().trim();

    if (reason === "") {

        Swal.fire({
            icon: "warning",
            title: "Reason Required",
            text: "Please enter the recruitment notes."
        });

        $("#txtNotQualifyReason1").focus();
        return;
    }

    let selectedCertificates = [];

    $("#certificateCheckboxContainer input[type='checkbox']:checked")
        .each(function() {

            selectedCertificates.push($(this).data('certname'));

        });

    let selectedRanks = [];

    $("#rankCheckboxContainer input[type='checkbox']:checked")
        .each(function() {

            selectedRanks.push($(this).data('rankname') || $(this).val());

        });

    Swal.fire({
        title: "Confirmation",
        html: `Are you sure you want to mark <b>${name}</b> as 
               <span style="color:#b91c1c;font-weight:600;">Not Qualified</span>?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#b91c1c",
        cancelButtonColor: "#6b7280",
        confirmButtonText: "Yes, Set Not Qualified",
        cancelButtonText: "Cancel"
    }).then((result) => {

        if (!result.isConfirmed) return;

        $("#idLoadingSpinnerLayer1").fadeIn();


        $.ajax({

            url: "<?php echo base_url('submitNotQualified'); ?>",
            method: "POST",

            data: {
                id: id,
                reason: reason,
                missing_certificates: selectedCertificates.join(', '),
                suggested_ranks: selectedRanks.join(', ')
            },

            success: function(res) {

                let response;

                try {
                    response = JSON.parse(res);
                } catch (e) {

                    $("#idLoadingSpinnerLayer1").fadeOut();

                    Swal.fire({
                        title: "Error",
                        text: "Invalid server response.",
                        icon: "error"
                    });

                    return;
                }

                if (response.status === "success") {

                    $("#idLoadingSpinnerLayer1").fadeOut();

                    $('#modalNotQualifyLayer1').modal('hide');

                    if (typeof tableDataReady !== 'undefined' && tableDataReady.ajax) {
                        tableDataReady.ajax.reload(null, false);
                    }

                    Swal.fire({
                        title: "Success!",
                        text: "Crew has been marked as Not Qualified.",
                        icon: "success",
                        timer: 1400,
                        showConfirmButton: false
                    });

                    const row = document.getElementById("row_" + id);

                    if (row) {
                        animateRemoveRow(row);
                    }

                } else {

                    $("#idLoadingSpinnerLayer1").fadeOut();

                    Swal.fire({
                        title: "Warning",
                        text: response.message,
                        icon: "warning"
                    });

                }

            },

            error: function(xhr, status, error) {

                $("#idLoadingSpinnerLayer1").fadeOut();

                Swal.fire({
                    title: "Error!",
                    text: "System error: " + error,
                    icon: "error"
                });

            }

        });

    });

}

function toggleRankTile(el) {

    const label = el.closest(".rank-sap-tile");
    const icon = label.querySelector(".rank-check-icon");

    if (el.checked) {

        label.style.borderColor = "#0a6ed1";
        label.style.background = "#f0f7ff";
        label.style.boxShadow = "0 6px 14px rgba(10,110,209,0.15)";

        icon.style.background = "#0a6ed1";
        icon.style.borderColor = "#0a6ed1";
        icon.innerHTML = "<i class='fas fa-check'></i>";

    } else {

        label.style.borderColor = "#e2e8f0";
        label.style.background = "white";
        label.style.boxShadow = "none";

        icon.style.background = "transparent";
        icon.style.borderColor = "#cbd5e1";
        icon.innerHTML = "";

    }

}

function loadRankCheckbox() {

    $.ajax({
        url: "<?php echo base_url('getRank') ?>",
        type: "GET",
        dataType: "json",
        success: function(data) {

            const container = document.getElementById("rankCheckboxContainer");
            container.innerHTML = "";

            if (!data || !data.length) {
                container.innerHTML = "<div style='padding:10px;color:#64748b'>No rank available</div>";
                return;
            }

            data.forEach(function(rank) {

                const col = document.createElement("div");
                col.className = "col-md-4";
                col.style.padding = "8px";

                col.innerHTML = `
                
                <label class="rank-sap-tile" style="
                    display:block;
                    cursor:pointer;
                    border:1px solid #e2e8f0;
                    border-radius:12px;
                    padding:14px 16px;
                    background:white;
                    transition:all .2s ease;
                    position:relative;
                    user-select:none;
                " 
                onmouseover="this.style.borderColor='#0a6ed1';this.style.boxShadow='0 4px 10px rgba(0,0,0,0.05)'"
                onmouseout="if(!this.querySelector('input').checked){this.style.borderColor='#e2e8f0';this.style.boxShadow='none'}">

                    <input type="checkbox"
                    class="rankCheckbox"
                    value="${rank.id}"
                    data-rankname="${rank.name}"
                    style="display:none"
                    onchange="toggleRankTile(this)">

                    <div style="
                        display:flex;
                        align-items:center;
                        justify-content:space-between;
                    ">

                        <div style="
                            font-size:14px;
                            font-weight:600;
                            color:#1e293b;
                        ">
                            ${rank.name}
                        </div>

                        <div class="rank-check-icon" style="
                            width:22px;
                            height:22px;
                            border-radius:50%;
                            border:2px solid #cbd5e1;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            font-size:12px;
                            color:white;
                            transition:all .2s;
                        ">
                        </div>

                    </div>

                </label>
                `;

                container.appendChild(col);

            });

        }
    });

}

function notPositionCrew(id, name) {

    Swal.fire({
        title: 'No Position',
        html: `
            <div style="font-size:14px;margin-bottom:10px;">
                Kandidat <b>${name}</b> tidak memiliki posisi yang sesuai saat ini.
            </div>

            <div style="
                background:#f8f9fa;
                border:1px solid #dee2e6;
                border-radius:8px;
                padding:12px;
                font-size:13px;
                text-align:left;
                line-height:1.6;
            ">
                <div><b>⭐ High Potential</b></div>
                <div style="color:#6c757d;">
                    Kandidat memiliki potensi tinggi dan akan diprioritaskan ketika terdapat kebutuhan yang sesuai.
                </div>

                <hr style="margin:10px 0;">

                <div><b>📁 Talent Pool</b></div>
                <div style="color:#6c757d;">
                    Kandidat disimpan dalam database Talent Pool tanpa prioritas khusus.
                </div>
            </div>
        `,
        icon: 'question',
        showDenyButton: true,
        showCancelButton: true,

        confirmButtonText: '⭐ High Potential',
        denyButtonText: '📁 Talent Pool',
        cancelButtonText: 'Batal',

        confirmButtonColor: '#f59f00',
        denyButtonColor: '#067780'

    }).then((result) => {

        if (result.isDismissed) {
            return;
        }

        let favorite = result.isConfirmed ? 1 : 0;

        $("#idLoadingSpinner").fadeIn();

        $.ajax({
            url: '<?php echo base_url("notPosition") ?>',
            type: "POST",
            data: {
                id: id,
                favorite_candidate: favorite
            },
            dataType: "json",

            success: function(response) {

                $("#idLoadingSpinner").fadeOut();

                if (typeof tableDataReady !== 'undefined' && tableDataReady.ajax) {
                    tableDataReady.ajax.reload(null, false);
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: favorite == 1 ?
                        'Candidate berhasil dimasukkan ke High Potential Talent Pool.' :
                        'Candidate berhasil dimasukkan ke Talent Pool.',
                    timer: 1800,
                    showConfirmButton: false
                });

                const row = document.getElementById("row_" + id);

                animateRemoveRow(row);

            },

            error: function(xhr, status, error) {

                $("#idLoadingSpinner").fadeOut();

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan sistem: ' + error
                });

            }

        });

    });

}

function goToPage(page, searchValue) {

    const table = document.getElementById("tableDataReady");
    const rows = table.dataset.rows || 10;

    searchTableDataReady({
            value: searchValue
        },
        page,
        rows
    );
}
</script>

<div id="applicantsWorkspace" class="sap-workspace">

    <!-- <div class="sap-header">
        <div class="sap-header-left">
            <h2><?php echo $title; ?></h2>
            <span>Recruitment Management · Talent Intake</span>
        </div>

        <div class="sap-header-right">
            <div class="sap-kpi">
                <small>Total Applicants</small>
                <strong id="totalApplicants">0</strong>
            </div>
        </div>
    </div> -->



    <div class="sap-content">

        <div id="idLoadingSpinner" class="sap-loading" style="display:none;">
            <svg width="56" height="56" viewBox="0 0 50 50">
                <circle cx="25" cy="25" r="20" fill="none" stroke="#2563eb" stroke-width="4" stroke-linecap="round"
                    stroke-dasharray="31.4 31.4">
                    <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s"
                        repeatCount="indefinite" />
                </circle>
            </svg>
            <p>Processing data…</p>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0 sap-table" id="tableDataReady" style="width:100%;">
                <thead class="crew-header">
                    <tr>
                        <th style="width:4%;" class="text-center">No</th>
                        <th style="width:15%;">Seafarer <span class="filter-icon">☰</span></th>
                        <th style="width:12%;">Position Applied<span class="filter-icon">☰</span></th>
                        <th style="width:8%;">Birth <span class="filter-icon">☰</span></th>
                        <th style="width:8%;">Phone <span class="filter-icon">☰</span></th>
                        <th style="width:8%;">Vessel Type <span class="filter-icon">☰</span></th>
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
                        <th></th>
                        <th></th>
                        <th><input type="text" class="column-search" placeholder="Search..."></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="idTbodylistCrewNewModal"></tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalNotQualifyLayer1" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width:1300px;width:95%;">
        <div class="modal-content" style="
            border: none;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow: hidden;
        ">

            <div class="modal-header" style="
                background: linear-gradient(135deg, #0a6ed1 0%, #0854a0 100%);
                color: white;
                padding: 20px 28px;
                border: none;
                display: flex;
                align-items: center;
                justify-content: space-between;
            ">
                <div id="idLoadingSpinnerLayer1" class="sap-loading" style="display:none;">
                    <svg width="56" height="56" viewBox="0 0 50 50">
                        <circle cx="25" cy="25" r="20" fill="none" stroke="#2563eb" stroke-width="4"
                            stroke-linecap="round" stroke-dasharray="31.4 31.4">
                            <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25"
                                dur="1s" repeatCount="indefinite" />
                        </circle>
                    </svg>
                    <p>Processing data…</p>
                </div>
                <h4 style="
                    margin: 0;
                    font-weight: 600;
                    font-size: 18px;
                    letter-spacing: 0.3px;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    ">
                    <i class="fas fa-user-times" style="font-size: 20px;"></i>
                    <span>Candidate Not Qualified</span>
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="
                    color: white;
                    opacity: 0.9;
                    font-size: 28px;
                    font-weight: 300;
                    line-height: 1;
                    text-shadow: none;
                    background: transparent;
                    border: none;
                    padding: 0;
                    margin: 0;
                    transition: opacity 0.2s;
                    " onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'">
                    &times;
                </button>
            </div>

            <div class="modal-body" style="
                padding: 28px 32px;
                background: #f8fafd;
            ">

                <div style="
                    background: white;
                    border-radius: 16px;
                    padding: 18px 20px;
                    margin-bottom: 20px;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
                    border: 1px solid #edf2f7;
                    ">
                    <div style="
                        font-size: 12px;
                        font-weight: 500;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                        color: #5b6f87;
                        margin-bottom: 6px;
                    ">
                        Candidate
                    </div>
                    <div id="modalNotQualifyNameLayer1" style="
                        font-size: 18px;
                        font-weight: 700;
                        color: #1a2634;
                        line-height: 1.3;
                    "></div>
                    <div style="
                        margin-top: 8px;
                        font-size: 14px;
                        color: #4a5a6e;
                        display: flex;
                        gap: 20px;
                        align-items: center;
                    ">
                        <span id="modalNotQualifyPositionLayer1" style="display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-briefcase" style="color: #0a6ed1; font-size: 12px;"></i> <span></span>
                        </span>
                        <span style="color: #cbd5e0;">|</span>
                        <span id="modalNotQualifyLastExperienceLayer1"
                            style="display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-clock" style="color: #0a6ed1; font-size: 12px;"></i> <span></span>
                        </span>
                    </div>
                </div>

                <div style="
                    background: white;
                    border-radius: 16px;
                    padding: 20px;
                    margin-bottom: 20px;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
                    border: 1px solid #edf2f7;
                    ">
                    <div style="
                        font-size: 15px;
                        font-weight: 600;
                        margin-bottom: 16px;
                        color: #1e2b3a;
                        display: flex;
                        align-items: center;
                        gap: 8px;
                    ">
                        <i class="fas fa-certificate" style="color: #0a6ed1;"></i>
                        Required Certificates Not Fulfilled
                    </div>
                    <div id="certificateCheckboxContainer" class="row" style="
                        max-height: 210px;
                        overflow-y: auto;
                        padding-right: 8px;
                        margin: 0 -8px;
                        scrollbar-width: thin;
                        scrollbar-color: #cbd5e0 #f1f5f9;
                    "></div>
                </div>

                <div style="
                    background: white;
                    border-radius: 16px;
                    padding: 20px;
                    margin-bottom: 20px;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
                    border: 1px solid #edf2f7;
                    ">
                    <div style="
                        font-size: 15px;
                        font-weight: 600;
                        margin-bottom: 16px;
                        color: #1e2b3a;
                        display: flex;
                        align-items: center;
                        gap: 8px;
                    ">
                        <i class="fas fa-chart-line" style="color: #0a6ed1;"></i>
                        Recommended Position After Completing Certificates
                    </div>
                    <div id="rankCheckboxContainer" class="row" style="margin: 0 -8px;"></div>
                </div>

                <!-- REASON TEXTAREA -->
                <div style="
          background: white;
          border-radius: 16px;
          padding: 20px;
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
          border: 1px solid #edf2f7;
        ">
                    <div style="
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #1e2b3a;
            display: flex;
            align-items: center;
            gap: 8px;
          ">
                        <i class="fas fa-pen" style="color: #0a6ed1;"></i>
                        Reason / Notes
                    </div>
                    <textarea id="txtNotQualifyReason1" rows="4" style="
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 14px;
            font-family: inherit;
            resize: none;
            outline: none;
            background: #fcfdff;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
          " onfocus="this.style.borderColor='#0a6ed1'; this.style.boxShadow='0 0 0 3px rgba(10,110,209,0.1)'"
                        onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='inset 0 2px 4px rgba(0,0,0,0.02)'"></textarea>
                </div>

                <input type="hidden" id="hiddenCrewIdLayer1">
            </div>

            <!-- FOOTER dengan aksen tombol modern -->
            <div class="modal-footer" style="
        padding: 18px 28px;
        border-top: 1px solid #edf2f7;
        background: white;
        display: flex;
        gap: 12px;
        justify-content: flex-end;
      ">
                <button class="btn" data-bs-dismiss="modal" style="
          padding: 8px 22px;
          font-size: 14px;
          font-weight: 500;
          border-radius: 40px;
          border: 1px solid #d0d9e8;
          background: white;
          color: #2c3e50;
          transition: all 0.2s;
          cursor: pointer;
          box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        " onmouseover="this.style.backgroundColor='#f8fafd'; this.style.borderColor='#b0c0d4'"
                    onmouseout="this.style.backgroundColor='white'; this.style.borderColor='#d0d9e8'">
                    Cancel
                </button>
                <button class="btn" onclick="submitNotQualifiedLayer1()" style="
          padding: 8px 22px;
          font-size: 14px;
          font-weight: 500;
          border-radius: 40px;
          border: none;
          background: linear-gradient(145deg, #0a6ed1, #095bb0);
          color: white;
          transition: all 0.2s;
          cursor: pointer;
          box-shadow: 0 4px 10px -2px rgba(10,110,209,0.4);
          display: flex;
          align-items: center;
          gap: 8px;
        " onmouseover="this.style.background='linear-gradient(145deg, #095bb0, #074a90)'; this.style.boxShadow='0 6px 14px -2px rgba(10,110,209,0.5)'"
                    onmouseout="this.style.background='linear-gradient(145deg, #0a6ed1, #095bb0)'; this.style.boxShadow='0 4px 10px -2px rgba(10,110,209,0.4)'">
                    <i class="fas fa-check-circle" style="font-size: 16px;"></i> Submit
                </button>
            </div>

        </div>
    </div>
</div>