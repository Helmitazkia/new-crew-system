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
    overflow-x: auto;
    border: 1px solid #dbe4f0;
    border-radius: 12px;
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
    z-index: 10;

    background: #000099;
    color: #ffffff;

    font-weight: 600;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: .4px;

    padding: 12px 10px;

    border-bottom: 1px solid #a4a4a4;
    border-right: 1px solid #a4a4a4;

    white-space: nowrap;
}

.sap-table thead th:last-child {
    border-right: none;
}

.sap-table-wrapper.scrolling thead th {
    box-shadow: 0 2px 4px rgba(0, 0, 0, .06);
}

.sap-table tbody td {
    padding: 12px;
    border-bottom: 1px solid #a4a4a4;
    border-right: 1px solid #a4a4a4;

    vertical-align: top;
    white-space: normal;
}

.sap-table tbody td:last-child {
    border-right: none;
}

.sap-table tbody tr {
    transition: all .15s ease;
}

.sap-table tbody tr:hover {
    background: #f4f8fc;
}

.sap-table tbody tr:last-child td {
    border-bottom: #a4a4a4;
}

#tableDataPipeline td {
    white-space: normal !important;
    word-wrap: break-word !important;
    overflow-wrap: break-word !important;
}

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

@keyframes spinQualify {
    100% {
        transform: rotate(360deg);
    }
}

.salary-cell {
    text-align: center;
    vertical-align: top;
}

.salary-box {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    flex-wrap: wrap;
}

.salary-currency {
    background: #e7f5ff;
    color: #1971c2;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 700;
    border: 1px solid #d0ebff;
}

.salary-amount {
    color: #065f46;
    font-weight: 700;
    font-size: 12px;
}

.filter-popup {
    position: fixed;
    width: 280px;
    background: #fff;
    border: 1px solid #d0d7de;
    border-radius: 12px;

    box-shadow:
        0 12px 30px rgba(0, 0, 0, .12),
        0 2px 8px rgba(0, 0, 0, .08);

    overflow: hidden;
    z-index: 999999;
}

.filter-header {
    padding: 10px;
    border-bottom: 1px solid #edf2f7;
    background: #fafbfc;
}

.filter-header button {
    width: 100%;
    border: none;
    background: #e7f5ff;
    color: #1971c2;

    padding: 8px 10px;
    border-radius: 8px;

    cursor: pointer;
    font-size: 12px;
    font-weight: 600;
}

.filter-header button:hover {
    background: #d0ebff;
}

.filter-popup input[type="text"] {
    width: 100%;
    border: none;
    border-bottom: 1px solid #edf2f7;

    padding: 12px;
    font-size: 13px;
    outline: none;
}

.filter-list {
    max-height: 320px;
    overflow-y: auto;
}

.filter-item {
    padding: 8px 12px;
    transition: .15s;
}

.filter-item:hover {
    background: #f5f9ff;
}

.filter-item label {
    display: flex;
    align-items: center;
    gap: 8px;

    width: 100%;
    cursor: pointer;

    font-size: 13px;
    color: #334155;
}

.filter-item input[type="checkbox"] {
    cursor: pointer;
}

.filter-btn {
    cursor: pointer;
    margin-left: 6px;
    font-size: 10px;
    color: #fff;
    transition: .2s;
}

.filter-btn.filter-active {
    color: #ffd43b;
    font-weight: bold;
}

.filter-list::-webkit-scrollbar {
    width: 6px;
}

.filter-list::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 20px;
}

.tree-toggle {
    cursor: pointer;
    padding: 6px 8px;
    font-weight: 600;
    color: #333;
    user-select: none;
}

.tree-toggle:hover {
    background: #f5f5f5;
    border-radius: 4px;
}

.tree-content {
    margin-top: 2px;
}

.filter-popup .filter-item {
    padding: 4px 8px;
}

.filter-popup .filter-item label {
    cursor: pointer;
}
</style>
<script>
$(document).ready(function() {

    loadPipelineCrew(1);

    $("#pipelineSearch").on("keyup", function() {
        loadPipelineCrew(1);
    });

});

function loadPipelineCrew(page = 1) {
    const table = document.getElementById("tableDataPipeline");

    if (table) {
        table.dataset.page = page;

        if (!table.dataset.rows) {
            table.dataset.rows = 10;
        }
    }

    const rows = table ? (table.dataset.rows || 10) : 10;

    const search = $("#pipelineSearch").val();
    const gender = $("#filterGender").val();
    const status = $("#filterStatus").val();
    const position = $("#filterPosition").val();
    const vessel = $("#filterVessel").val();
    const foreign = $("#filterForeign").val();
    const rank = $("#filterRank").val();

    $.ajax({
        url: "<?php echo base_url("searchDataPipeline") ?>",
        method: "GET",
        data: {
            search: search,
            page: page,
            rows: rows,
            filters: JSON.stringify(pipelineFilters)
        },
        dataType: "json",
        success: function(res) {

            const formatSalary = (salary) => {

                if (!salary || salary === "0") {
                    return "-";
                }

                return Number(salary).toLocaleString('en-US');
            };

            let html = "";
            let no = (page - 1) * 10 + 1;
            res.data.forEach(row => {
                let reasonBlock = "";
                if (row.st_data == 3 && row.reason1) {
                    let certList = "";
                    if (row.missing_certificates) {
                        let certs = row.missing_certificates.split(",");
                        certs.forEach(c => {
                            certList +=
                                ` <div style="padding-left:18px;"> │ &nbsp; - ${c.trim()} </div>`;
                        });
                    }
                    reasonBlock =
                        ` <div style=" margin-top:8px; background:#fff5f5; border:1px solid #ffd6d6; border-radius:8px; padding:8px 10px; display:inline-block; max-width:520px; font-size:12px; line-height:1.6; color:#c92a2a; font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; "> <div style="font-weight:600;margin-bottom:4px;"> ● Not Qualified (Certificate) </div> <div>┌ Missing Certificate</div> ${certList} <div>│</div> <div>└ ${row.reason1}</div> </div> `;
                } else if (row.st_data == 3 && row.reason2) {
                    reasonBlock =
                        ` <div style=" margin-top:8px; background:#fff5f5; border:1px solid #ffd6d6; border-radius:8px; padding:8px 10px; display:inline-block; max-width:520px; font-size:12px; line-height:1.6; color:#c92a2a; font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; "><div>└ ${row.reason2}</div> </div> `;
                } else if (row.st_data == 4 && row.notReff_reason) {
                    reasonBlock =
                        ` <div style="margin-top:6px;"> <button style=" font-size:11px; border:1px solid #dee2e6; background:#fff; padding:3px 6px; border-radius:3px; cursor:pointer;" onclick="toggleReason('reason_${row.id}')"> Show Reason </button> <div id="reason_${row.id}" style=" display:none; margin-top:5px; background:#f8f9fa; border-left:3px solid #17a2b8; padding:6px; border-radius:4px; font-size:12px;"> ${row.notReff_reason} </div> </div>`;
                }

                let statusBadge = "";
                if (row.st_data == 2) {

                    let favoriteIcon = row.favorite_candidate == 1 ?
                        ' ⭐' :
                        '';

                    statusBadge =
                        ` <span style="
                        background:#f1f3f5;
                        color:#495057;
                        font-size:11px;
                        padding:3px 10px;
                        border-radius:20px;
                        font-weight:600;">
                        ● No Position${favoriteIcon}
                    </span>`;
                } else if (row.st_data == 3 && !row.reason2) {
                    statusBadge =
                        ` <span style=" background:#fff5f5; color:#c92a2a; font-size:11px; padding:3px 10px; border-radius:20px; font-weight:600;"> ● Not Qualified (Certificate) </span>`;
                } else if (row.st_data == 3 && row.reason2) {
                    statusBadge =
                        ` <span style=" background:#fff5f5; color:#c92a2a; font-size:11px; padding:3px 10px; border-radius:20px; font-weight:600;"> ● Not Qualified (Experience) </span>`;
                } else if (row.st_data == 4) {
                    statusBadge =
                        ` <span style=" background:#edf6ff; color:#1971c2; font-size:11px; padding:3px 10px; border-radius:20px; font-weight:600;"> ● Interview Rejected </span>`;
                } else if (row.st_data == 7) {
                    statusBadge =
                        ` <span style=" background:#fff0f6; color:#a61e4d; font-size:11px; padding:3px 10px; border-radius:20px; font-weight:600;"> ● Withdraw MCU </span>`;
                }
                let btnAct =
                    ` <div style="display:flex;flex-direction:column;gap:4px;"> <button style=" border:1px solid #dee2e6; background:#fff; font-size:12px; padding:5px; border-radius:4px; cursor:pointer;" onclick="window.open('${row.cv_url}','_blank')"> 📄 View CV </button> `;

                if (row.st_data != 0 && row.st_data != 1) {
                    btnAct += `
                        <button
                            style="background:#e6fcf5;
                                border:1px solid #20c997;
                                color:#087f5b;
                                font-size:12px;
                                padding:5px;
                                border-radius:4px;
                                cursor:pointer;"
                            onclick="positionAvailableCrew('${row.id}','<b><i>:: ${row.fullname} ::</i></b>');">
                            ✔ Position Available
                        </button>
                    `;
                }
                if (row.st_data == 3) {
                    btnAct +=
                        ` <button style=" background:#edf6ff; border:1px solid #4dabf7; color:#1864ab; font-size:12px; padding:5px; border-radius:4px; cursor:pointer;" onclick="showQualifyPipelineModal(this);" data-id="${row.id}" data-name="${row.fullname}" data-position="${row.position}" data-pengalaman-jenis-kapal="${row.vessel}"> ✔ Qualify </button>`;
                }
                btnAct += `</div>`;

                html +=
                    ` <tr id="row_${row.id}" style="border-bottom:1px solid #a4a4a4;"> 
                        <td style="text-align:center;font-size:12px;color:#868e96;"> ${no++} </td> 
                        <td style="min-width:260px;vertical-align:top;word-wrap:break-word;overflow-wrap:break-word;"> 
                            <div style="font-weight:600;font-size:14px;color:#1f2d3d; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">

                                ${row.favorite_candidate == 1 ? `
                                    <span style="
                                        display:inline-block;
                                        background:#fff3bf;
                                        color:#e67700;
                                        font-size:10px;
                                        font-weight:700;
                                        padding:2px 8px;
                                        border-radius:20px;
                                        margin-right:5px;">
                                        ⭐ FAVORABLE
                                    </span>
                                ` : ''}

                                ${row.fullname}

                            </div> 
                            <div style="font-size:12px;color:#868e96;margin-top:2px; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;"> ${row.email} </div> 
                            <div style="margin-top:6px;"> ${statusBadge} </div> 
                            ${reasonBlock} 
                        </td> 
                        <td style="min-width:160px;word-wrap:break-word;overflow-wrap:break-word;"> 
                            <div style="font-size:13px;font-weight:600;color:#34495e; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;"> ${row.position} </div> 
                            <div style="font-size:12px;color:#7f8c8d;margin-top:2px; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;"> ${row.education} </div> 
                        </td> 
                        <td style="font-size:12px;color:#495057;word-wrap:break-word;overflow-wrap:break-word;"> 
                            <div style="white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">${row.born_place}</div> 
                            <div style="color:#868e96; white-space: normal; word-wrap: break-word; overflow-wrap: break-word;">${row.born_date}</div> 
                        </td> 
                        <td style="font-size:12px;word-wrap:break-word;overflow-wrap:break-word;"> ${row.handphone} </td> 
                        <td style="font-size:12px;word-wrap:break-word;overflow-wrap:break-word;"> ${row.vessel_type || "-"} </td>
                        <td style="
                            font-size:12px;
                            vertical-align:top;
                            min-width:220px;
                        ">
                            <div style="
                                font-weight:600;
                                color:#34495e;
                                margin-bottom:6px;
                            ">
                                ${row.last_experience || "-"}
                            </div>

                            <div style="
                                color:#868e96;
                                line-height:1.4;
                                white-space:normal;
                                word-break:break-word;
                            ">
                                ${
                                    row.vessel
                                    ? row.vessel
                                        .split(',')
                                        .map(v => `<div>${v.trim()}</div>`)
                                        .join('')
                                    : '-'
                                }
                            </div>
                        </td>
                        <td style="font-size:12px;text-align:center;word-wrap:break-word;overflow-wrap:break-word;"> ${row.foreign} </td> 
                        <td style="
                            font-size:12px;
                            text-align:center;
                            vertical-align:top;
                        ">
                            <div style="
                                display:flex;
                                justify-content:center;
                                align-items:center;
                                gap:6px;
                                flex-wrap:wrap;
                            ">
                                <span style="
                                    background:#e7f5ff;
                                    color:#1971c2;
                                    padding:2px 6px;
                                    border-radius:10px;
                                    font-size:10px;
                                    font-weight:600;
                                ">
                                    ${row.last_salary_currency || '-'}
                                </span>

                                <span style="
                                    font-weight:600;
                                    color:#065f46;
                                ">
                                    ${formatSalary(row.last_salary)}
                                </span>
                            </div>
                        </td>

                        <td style="
                            font-size:12px;
                            text-align:center;
                            vertical-align:top;
                        ">
                            <div style="
                                display:flex;
                                justify-content:center;
                                align-items:center;
                                gap:6px;
                                flex-wrap:wrap;
                            ">
                                <span style="
                                    background:#e7f5ff;
                                    color:#1971c2;
                                    padding:2px 6px;
                                    border-radius:10px;
                                    font-size:10px;
                                    font-weight:600;
                                ">
                                    ${row.expected_salary_currency || '-'}
                                </span>

                                <span style="
                                    font-weight:600;
                                    color:#065f46;
                                ">
                                    ${formatSalary(row.expected_salary)}
                                </span>
                            </div>
                        </td> 
                        <td style="font-size:12px;text-align:center;word-wrap:break-word;overflow-wrap:break-word;"> ${row.join} </td> 
                        <td style="font-size:12px;color:#868e96;word-wrap:break-word;overflow-wrap:break-word;"> ${row.submit} </td> 
                        <td style="text-align:center;min-width:120px;"> ${btnAct} </td> 
                    </tr> `;
            });

            $("#idTbodyPipelineCrew").html(html);
            renderPagination(res.pagination, page);
        }
    });
}

function changeRowsPerPage(rows) {
    const table = document.getElementById("tableDataPipeline");

    if (table) {
        table.dataset.rows = rows;
    }

    loadPipelineCrew(1);
}

function toggleReason(id) {

    const el = document.getElementById(id);

    if (el.style.display === "none") {
        el.style.display = "block";
    } else {
        el.style.display = "none";
    }
}

function renderPagination(p, page) {
    const table = document.getElementById("tableDataPipeline");
    const rowsPerPage = table ? (table.dataset.rows || 10) : 10;

    let html = `
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        flex-wrap:wrap;
        gap:10px;
        margin-top:14px;
        padding:10px 14px;
        background:#f8fafc;
        border:1px solid #e9ecef;
        border-radius:8px;
        font-size:13px;">
    `;

    html += `
    <div style="
        display:flex;
        align-items:center;
        gap:15px;
        flex-wrap:wrap;
        color:#495057;
    ">
        <div>
            <strong>${p.total_rows}</strong> Candidates •
            Page <strong>${page}</strong> of <strong>${p.total_pages}</strong>
        </div>

        <div>
            Rows :
            <select
                onchange="changeRowsPerPage(this.value)"
                style="
                    border:1px solid #dee2e6;
                    border-radius:6px;
                    padding:4px 8px;
                    font-size:12px;
                    background:#fff;
                    cursor:pointer;
                ">
                <option value="10" ${rowsPerPage==10?'selected':''}>10</option>
                <option value="20" ${rowsPerPage==20?'selected':''}>20</option>
                <option value="50" ${rowsPerPage==50?'selected':''}>50</option>
                <option value="100" ${rowsPerPage==100?'selected':''}>100</option>
            </select>
        </div>
    </div>
    `;

    html += `<div style="display:flex;align-items:center;gap:4px;">`;

    if (page > 1) {

        html += `
        <button
            onclick="loadPipelineCrew(${page-1})"
            style="
                border:1px solid #dee2e6;
                background:#fff;
                padding:5px 10px;
                font-size:12px;
                border-radius:6px;
                cursor:pointer;">
            ⟨ Prev
        </button>`;
    }

    let start = Math.max(1, page - 2);
    let end = Math.min(p.total_pages, page + 2);

    for (let i = start; i <= end; i++) {

        if (i == page) {

            html += `
            <button
                style="
                    background:#1971c2;
                    border:1px solid #1971c2;
                    color:#fff;
                    font-weight:600;
                    padding:5px 10px;
                    font-size:12px;
                    border-radius:6px;">
                ${i}
            </button>`;
        } else {

            html += `
            <button
                onclick="loadPipelineCrew(${i})"
                style="
                    border:1px solid #dee2e6;
                    background:#fff;
                    padding:5px 10px;
                    font-size:12px;
                    border-radius:6px;
                    cursor:pointer;">
                ${i}
            </button>`;
        }
    }

    if (page < p.total_pages) {

        html += `
        <button
            onclick="loadPipelineCrew(${page+1})"
            style="
                border:1px solid #dee2e6;
                background:#fff;
                padding:5px 10px;
                font-size:12px;
                border-radius:6px;
                cursor:pointer;">
            Next ⟩
        </button>`;
    }

    html += `</div></div>`;

    $("#pagination").html(html);
}

function positionAvailableCrew(id, name) {

    Swal.fire({
        title: "Konfirmasi",
        html: `Posisi yang dilamar oleh <b>${name}</b> sudah tersedia.<br>Apakah ingin mengembalikan crew ini ke status <span style="color:#067780;font-weight:600;">Ready</span>?`,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#067780",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Set Ready",
        cancelButtonText: "Batal"
    }).then((result) => {

        if (!result.isConfirmed) return;

        $("#idLoadingSpinner").fadeIn();

        $.ajax({
            url: '<?php echo base_url("positionAvail") ?>',
            type: "POST",
            data: {
                id: id
            },
            dataType: "json",

            success: function(response) {

                $("#idLoadingSpinner").fadeOut();

                Swal.fire({
                    title: "Berhasil!",
                    text: response.message,
                    icon: "success",
                    timer: 1300,
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

function renumberTableRows() {

    const tbody = document.getElementById("idTbodyPipelineCrew");

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

    const tbody = document.getElementById("idTbodyPipelineCrew");
    const table = document.getElementById("tableDataPipeline");

    row.style.transition = "all .35s cubic-bezier(.4,0,.2,1)";
    row.style.background = "#fff5f5";

    setTimeout(() => {
        row.style.opacity = "0";
        row.style.transform = "translateX(-30px)";
        row.style.pointerEvents = "none";;
    }, 10);

    setTimeout(() => {

        row.remove();

        const total = document.getElementById("totalApplicants");

        if (total) {
            total.innerText = parseInt(total.innerText) - 1;
        }

        const remainingRows = tbody.querySelectorAll("tr").length;

        if (remainingRows === 0) {

            const currentPage = parseInt(table.dataset.page) || 1;
            const searchValue = table.dataset.search || "";

            const targetPage = currentPage > 1 ? currentPage - 1 : 1;

            loadPipelineCrew(null, targetPage);

        } else {

            renumberTableRows();

        }

    }, 350);

}

function updateQualifyStepUI() {

    const $modal = $('#modalQualifyPipeline');
    let step = parseInt($modal.data('step')) || 1;

    $modal.find(".qualifyStep").hide();
    $modal.find("#qualifyStep" + step).show();

    $modal.find("#stepIndicator1").css("background", step >= 1 ? "white" : "rgba(255,255,255,.3)");
    $modal.find("#stepIndicator2").css("background", step >= 2 ? "white" : "rgba(255,255,255,.3)");
    $modal.find("#stepIndicator3").css("background", step >= 3 ? "white" : "rgba(255,255,255,.3)");

    $modal.find("#btnPrevStep").toggle(step > 1);
    $modal.find("#btnNextStep").toggle(step < 3);
    $modal.find("#btnSubmitQualified").toggle(step === 3);
}

$(document).off("click", "#btnNextStep").on("click", "#btnNextStep", function() {

    const $modal = $('#modalQualifyPipeline');
    let step = parseInt($modal.data('step')) || 1;

    if (step < 3) {
        step++;
        $modal.data('step', step);
        updateQualifyStepUI();
    }

});

$(document).off("click", "#btnPrevStep").on("click", "#btnPrevStep", function() {

    const $modal = $('#modalQualifyPipeline');
    let step = parseInt($modal.data('step')) || 1;

    if (step > 1) {
        step--;
        $modal.data('step', step);
        updateQualifyStepUI();
    }

});

$('#modalQualifyPipeline').on('shown.bs.modal', function() {

    const $modal = $(this);
    $modal.data('step', 1);
    updateQualifyStepUI();

});

function showQualifyPipelineModal(btn) {

    const $modal = $('#modalQualifyPipeline');

    const state = {
        id: $(btn).data('id'),
        name: $(btn).data('name') || '-',
        position: $(btn).data('position') || '-',
        vesselRaw: $(btn).data('pengalaman-jenis-kapal') || ''
    };


    $modal.find('#modalQualifyPipelineName')
        .html("<i class='fas fa-user'></i> " + state.name);

    $modal.find('#modalQualifyPipelinePosition')
        .html("<i class='fas fa-briefcase'></i> " + state.position);

    $modal.find('#hiddenCrewIdPipeline').val(state.id);


    $.ajax({
        url: "<?php echo base_url('getRank'); ?>",
        type: "GET",
        dataType: "json"
    }).done(function(res) {

        const options = res.map(r =>
            `<option value="${r.id}">${r.name}</option>`
        ).join("");

        const $rank = $modal.find("#rankSelectPipeline");
        $rank.html(options);

        let found = false;
        const pos = (state.position || "").toUpperCase();

        $rank.find("option").each(function() {

            const text = $(this).text().toUpperCase();

            if (text === pos) {
                $(this).prop("selected", true);
                found = true;
                return false;
            }

        });

        if (!found) {

            $rank.find("option").each(function() {

                const text = $(this).text().toUpperCase();

                if (text.includes(pos) || pos.includes(text)) {
                    $(this).prop("selected", true);
                    return false;
                }

            });

        }

    });

    const vesselMaster = [
        "BULK CARRIER", "CARGO", "GENERAL CARGO", "CONTAINER",
        "TANKER PRODUCT", "TANKER OIL", "CRUDE OIL",
        "TANKER CHEMICAL", "TANKER GAS", "FLOATING CRANE",
        "TUG BOAT", "SUPPLY VESSEL", "CREW BOAT", "RORO/PASSENGER"
    ];

    const vessels = state.vesselRaw
        .split(',')
        .map(v => v.trim())
        .filter(v => v);

    let otherValue = vessels.find(v => !vesselMaster.includes(v)) || "";

    const vesselHtml = `
        <div style="
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:6px 12px;
            padding:8px;
            border:1px solid #dde5ea;
            border-radius:12px;
            background:white;
        ">
            ${vesselMaster.map((v,i)=>`
                <label style="
                    display:flex;
                    align-items:center;
                    gap:6px;
                    font-size:13px;
                    border-right:${(i+1)%3!==0?'1px solid #eef2f4':'none'};
                    padding:4px 6px;
                ">
                    <input type="checkbox"
                        class="vessel-check"
                        value="${v}"
                        ${vessels.includes(v)?'checked':''}>
                    ${v}
                </label>
            `).join('')}

            <label style="display:flex;align-items:center;gap:6px;font-size:13px;">
                <input type="checkbox"
                    id="otherKapalCheckbox"
                    value="OTHER"
                    ${otherValue?'checked':''}>
                OTHER
            </label>
        </div>

        <div id="inputOtherKapal"
            style="margin-top:8px;display:${otherValue?'block':'none'};">
            <input type="text"
                id="otherKapalInput"
                value="${otherValue}"
                placeholder="Specify other vessel"
                style="
                    width:100%;
                    border:1px solid #d6dde3;
                    border-radius:10px;
                    padding:8px 10px;
                ">
        </div>
    `;

    $modal.find("#modalQualifyPipelineVesselTypeExperience").html(vesselHtml);

    $modal.off("change", "#otherKapalCheckbox")
        .on("change", "#otherKapalCheckbox", function() {

            if (this.checked) {
                $modal.find("#inputOtherKapal").show();
            } else {
                $modal.find("#inputOtherKapal").hide()
                    .find("input").val("");
            }

        });

    const modalEl = document.getElementById('modalQualifyPipeline');

    if (typeof bootstrap !== "undefined") {

        const modalObj = bootstrap.Modal.getOrCreateInstance(modalEl, {
            backdrop: 'static',
            keyboard: false
        });

        modalEl.dataset.step = 1;
        modalObj.show();

    } else {

        $('#modalQualifyPipeline')
            .data('step', 1)
            .modal({
                backdrop: 'static',
                keyboard: false
            });

    }

}

function submitQualifiedCrewPipeline() {
    const id = $('#hiddenCrewIdPipeline').val();
    const position_existing = $('#rankSelectPipeline').val();

    let vessels = [];
    $('.vessel-check:checked').each(function() {
        const val = $(this).val();
        if (val === 'OTHER') {
            const otherVal = $('#otherKapalInput').val().trim();
            if (otherVal) vessels.push(otherVal);
        } else {
            vessels.push(val);
        }
    });
    const pengalaman_jeniskapal = vessels.join(', ');

    if (!id || !position_existing) {
        alert('Please select rank and vessel type!');
        return;
    }

    $('#idLoadingSpinnerQualifyPipeline').show();

    $.ajax({
        url: "<?php echo base_url('qualifyPipeline'); ?>",
        type: "POST",
        dataType: "json",
        data: {
            id: id,
            position_existing: position_existing,
            pengalaman_jeniskapal: pengalaman_jeniskapal
        },
        success: function(res) {

            $('#idLoadingSpinnerQualifyPipeline').hide();

            if (res.status === 'success') {

                alert(res.message);

                if (typeof bootstrap !== "undefined") {
                    bootstrap.Modal.getInstance(
                        document.getElementById('modalQualifyPipeline')
                    ).hide();
                } else {
                    $('#modalQualifyPipeline').modal('hide');
                }
                const row = document.getElementById("row_" + id);
                animateRemoveRow(row);

            } else {

                alert(res.message || 'Process failed');

            }
        },
        error: function() {
            $('#idLoadingSpinnerQualifyPipeline').hide();
            alert('Error', 'Terjadi kesalahan pada server', 'error');
        }
    });
}

const pipelineColumnMap = {
    1: "st_data",
    2: "position_applied",
    3: "born_place",
    4: "handphone",
    5: "vessel_type",
    6: "pengalaman_jeniskapal",
    7: "berlayardengancrewasing",
    8: "last_salary",
    9: "expected_salary",
    10: "join_inAndhika",
    11: "submit_cv"
};

let pipelineFilters = {};

function showColumnFilter(event, colIndex) {

    $(".filter-popup").remove();

    const field = pipelineColumnMap[colIndex];

    if (!field) {
        return;
    }

    if (field === "st_data") {

        const values = [
            "⭐ Favorite Candidate",
            "No Position",
            "No Qualified Certificate",
            "No Qualified Experience",
            "No Qualified Interview",
            "Withdraw MCU"
        ];

        renderFilterPopup(
            values,
            colIndex,
            event
        );

        return;
    }

    if (field === "submit_cv") {

        $.get(
            "<?php echo base_url();?>filterPipeline", {
                field: field
            },
            function(values) {

                renderSubmitCvTreeFilter(
                    values,
                    colIndex,
                    event
                );

            },
            "json"
        );

        return;
    }

    $.get(
        "<?php echo base_url();?>filterPipeline", {
            field: field
        },
        function(values) {

            let html = `
                <div class="filter-popup">

                    <div class="filter-header">
                        <button onclick="clearColumnFilter(${colIndex})">
                            Clear Filter
                        </button>
                    </div>

                    <input
                        type="text"
                        placeholder="Search..."
                        onkeyup="filterPopupSearch(this)"
                    >

                    <div class="filter-list">
            `;

            values.forEach(v => {

                const checked =
                    pipelineFilters[colIndex] &&
                    pipelineFilters[colIndex].includes(v) ?
                    "checked" :
                    "";

                html += `
                    <div class="filter-item">
                        <label>
                            <input
                                type="checkbox"
                                value="${String(v).replace(/"/g,'&quot;')}"
                                onchange="applyColumnFilter(${colIndex})"
                                ${checked}
                            >
                            <span>${v}</span>
                        </label>
                    </div>
                `;
            });

            html += `
                    </div>
                </div>
            `;

            $("body").append(html);

            const btn = event.target;
            const rect = btn.getBoundingClientRect();

            const popup = $(".filter-popup");

            let popupLeft = rect.left;
            let popupTop = rect.bottom + 5;

            popup.css({
                top: popupTop + "px",
                left: popupLeft + "px"
            });

            // kalau mepet kanan layar
            const popupWidth = popup.outerWidth();
            const windowWidth = $(window).width();

            if ((popupLeft + popupWidth) > windowWidth) {

                popup.css({
                    left: (windowWidth - popupWidth - 15) + "px"
                });
            }

        },
        "json"
    );
}

function renderSubmitCvTreeFilter(data, colIndex, event) {

    let html = `
    <div class="filter-popup">

        <div class="filter-header">
            <button onclick="clearColumnFilter(${colIndex})">
                Clear Filter
            </button>
        </div>

        <input
            type="text"
            placeholder="Search..."
            onkeyup="filterPopupSearch(this)"
        >

        <div class="filter-list">
    `;

    Object.keys(data).forEach(year => {

        if (year === "No Date") {

            const checked =
                pipelineFilters[colIndex] &&
                pipelineFilters[colIndex].includes("No Date") ?
                "checked" :
                "";

            html += `
            <div class="filter-item">
                <label>
                    <input
                        type="checkbox"
                        value="No Date"
                        onchange="applyColumnFilter(${colIndex})"
                        ${checked}
                    >
                    No Date (${data[year].count})
                </label>
            </div>
            `;

            return;
        }

        html += `
        <div class="tree-year">

            <div class="tree-toggle"
                 onclick="$(this).next().slideToggle(150)">
                ▶ ${year} (${data[year].count})
            </div>

            <div class="tree-content"
                 style="display:none;">
        `;

        Object.keys(data[year].months).forEach(month => {

            const monthData = data[year].months[month];

            html += `
            <div class="tree-month">

                <div class="tree-toggle"
                     style="padding-left:20px;"
                     onclick="$(this).next().slideToggle(150)">
                    ▶ ${month} (${monthData.count})
                </div>

                <div class="tree-content"
                     style="display:none;">
            `;

            Object.keys(monthData.dates)
                .sort()
                .reverse()
                .forEach(date => {

                    const checked =
                        pipelineFilters[colIndex] &&
                        pipelineFilters[colIndex].includes(date) ?
                        "checked" :
                        "";

                    html += `
                    <div class="filter-item"
                         style="padding-left:45px;">

                        <label>
                            <input
                                type="checkbox"
                                value="${date}"
                                onchange="applyColumnFilter(${colIndex})"
                                ${checked}
                            >

                            ${date}
                            (${monthData.dates[date]})
                        </label>
                    </div>
                    `;
                });

            html += `
                </div>
            </div>
            `;
        });

        html += `
            </div>
        </div>
        `;
    });

    html += `
        </div>
    </div>
    `;

    $("body").append(html);

    const rect = event.target.getBoundingClientRect();

    positionFilterPopup(rect);
}

function renderFilterPopup(values, colIndex, event) {
    let html = `
        <div class="filter-popup">

            <div class="filter-header">
                <button onclick="clearColumnFilter(${colIndex})">
                    Clear Filter
                </button>
            </div>

            <input
                type="text"
                placeholder="Search..."
                onkeyup="filterPopupSearch(this)"
            >

            <div class="filter-list">
    `;

    values.forEach(v => {

        const checked =
            pipelineFilters[colIndex] &&
            pipelineFilters[colIndex].includes(v) ?
            "checked" :
            "";

        html += `
            <div class="filter-item">
                <label>
                    <input
                        type="checkbox"
                        value="${String(v).replace(/"/g,'&quot;')}"
                        onchange="applyColumnFilter(${colIndex})"
                        ${checked}
                    >
                    <span>${v}</span>
                </label>
            </div>
        `;
    });

    html += `
            </div>
        </div>
    `;

    $("body").append(html);

    const btn = event.target;
    const rect = btn.getBoundingClientRect();

    const popup = $(".filter-popup");

    popup.css({
        top: (rect.bottom + 5) + "px",
        left: rect.left + "px"
    });
}

function filterPopupSearch(input) {

    const keyword = $(input)
        .val()
        .toLowerCase()
        .trim();

    $(input)
        .closest(".filter-popup")
        .find(".filter-list .filter-item")
        .each(function() {

            const text = $(this)
                .text()
                .toLowerCase();

            $(this).toggle(
                text.includes(keyword)
            );
        });
}

$(document).ready(function() {

    $(window).on("scroll", function() {
        closeFilterPopup();
    });

    $(".sap-table-wrapper").on("scroll", function() {
        closeFilterPopup();
    });

    $(document).on("click", function(e) {

        if (
            !$(e.target).closest(".filter-popup").length &&
            !$(e.target).closest(".filter-btn").length
        ) {
            closeFilterPopup();
        }
    })
});

function positionFilterPopup(rect) {

    const popup = $(".filter-popup");

    let left = rect.left;
    let top = rect.bottom + 5;

    const popupWidth = popup.outerWidth();
    const popupHeight = popup.outerHeight();

    const windowWidth = $(window).width();
    const windowHeight = $(window).height();

    // kanan layar
    if ((left + popupWidth) > windowWidth) {
        left = windowWidth - popupWidth - 20;
    }

    // kiri layar
    if (left < 10) {
        left = 10;
    }

    // bawah layar
    if ((top + popupHeight) > windowHeight) {
        top = rect.top - popupHeight - 5;
    }

    popup.css({
        left: left + "px",
        top: top + "px"
    });
}

function applyColumnFilter(colIndex) {

    const checked = [];

    $(".filter-popup input[type='checkbox']:checked")
        .each(function() {
            checked.push($(this).val());
        });

    if (checked.length > 0) {
        pipelineFilters[colIndex] = checked;
    } else {
        delete pipelineFilters[colIndex];
    }

    updateFilterIndicators();

    loadPipelineCrew(1);
}

function clearColumnFilter(colIndex) {

    delete pipelineFilters[colIndex];

    updateFilterIndicators();

    loadPipelineCrew(1);

    $(".filter-popup").remove();
}


function updateFilterIndicators() {

    $(".filter-btn")
        .removeClass("filter-active")
        .html("▼");

    Object.keys(pipelineFilters).forEach(function(colIndex) {

        const value = pipelineFilters[colIndex];

        if (
            value &&
            (
                (Array.isArray(value) && value.length > 0) ||
                (!Array.isArray(value) && value !== "")
            )
        ) {

            $(`th[data-col="${colIndex}"] .filter-btn`)
                .addClass("filter-active")
                .html("🔵");
        }
    });
}

function closeFilterPopup() {
    $(".filter-popup").remove();
}
</script>

<div id="applicantsWorkspace" class="sap-workspace">

    <div class="sap-header">
        <div class="sap-header-left">
            <h2><?php echo $title; ?></h2>
            <span>Recruitment Management · Talent Intake</span>
        </div>
    </div>

    <div class="sap-toolbar">
        <div class="sap-search">
            <i class="fas fa-search"></i>
            <input type="text" id="pipelineSearch" placeholder="Search name, email, position applied">
        </div>
    </div>

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

        <div class="sap-table-wrapper">
            <div id="searchIndicator"></div>
            <table class="sap-table" id="tableDataPipeline" data-page="1" data-search="">
                <thead>
                    <tr>
                        <th data-col="0">
                            No
                        </th>

                        <th data-col="1">
                            Seafarer
                            <span class="filter-btn" onclick="showColumnFilter(event,1)">▼</span>
                        </th>

                        <th data-col="2">
                            Position
                            <span class="filter-btn" onclick="showColumnFilter(event,2)">▼</span>
                        </th>

                        <th data-col="3">
                            Born
                            <span class="filter-btn" onclick="showColumnFilter(event,3)">▼</span>
                        </th>

                        <th data-col="4">
                            Phone
                            <span class="filter-btn" onclick="showColumnFilter(event,4)">▼</span>
                        </th>

                        <th data-col="5">
                            Apply Vessel Type
                            <span class="filter-btn" onclick="showColumnFilter(event,5)">▼</span>
                        </th>

                        <th data-col="6">
                            Experience
                            <span class="filter-btn" onclick="showColumnFilter(event,6)">▼</span>
                        </th>

                        <th data-col="7">
                            Foreign
                            <span class="filter-btn" onclick="showColumnFilter(event,7)">▼</span>
                        </th>

                        <th data-col="8">
                            Last Salary
                            <span class="filter-btn" onclick="showColumnFilter(event,8)">▼</span>
                        </th>

                        <th data-col="9">
                            Expected Salary
                            <span class="filter-btn" onclick="showColumnFilter(event,9)">▼</span>
                        </th>

                        <th data-col="10">
                            Prev Join
                            <span class="filter-btn" onclick="showColumnFilter(event,10)">▼</span>
                        </th>

                        <th data-col="11">
                            Submit
                            <span class="filter-btn" onclick="showColumnFilter(event,11)">▼</span>
                        </th>

                        <th>Action</th>
                    </tr>
                </thead>

                <tbody id="idTbodyPipelineCrew"></tbody>
            </table>
        </div>

        <div id="pagination" class="mt-3"></div>
    </div>
</div>

<div class="modal fade" id="modalQualifyPipeline">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"
            style="border-radius:20px;border:none;box-shadow:0 25px 70px rgba(0,0,0,.25);overflow:hidden;">

            <!-- HEADER -->
            <div style="
                background:#0854a0;
                color:white;
                padding:20px 26px;
                position:relative;
            ">

                <div id="idLoadingSpinnerQualifyPipeline" style="
                    display:none;
                    position:fixed;
                    inset:0;
                    background:rgba(5,25,30,.75);
                    z-index:9999;
                    justify-content:center;
                    align-items:center;
                    flex-direction:column;
                ">
                    <div style="
                        width:70px;height:70px;
                        border-radius:50%;
                        border:5px solid rgba(255,255,255,.2);
                        border-top:5px solid white;
                        animation:spinQualify 1s linear infinite;
                    "></div>

                    <div style="
                        color:white;
                        margin-top:18px;
                        font-weight:600;
                        letter-spacing:.5px;
                    ">
                        Processing qualification...
                    </div>
                </div>

                <div style="display:flex;align-items:center;gap:12px;font-size:18px;font-weight:600;">
                    <i class="fas fa-user-shield"></i>
                    Qualification Adjustment Wizard
                </div>

                <button data-dismiss="modal" style="
                    position:absolute;
                    right:18px;
                    top:18px;
                    border:none;
                    background:rgba(255,255,255,.2);
                    color:white;
                    width:34px;
                    height:34px;
                    border-radius:8px;
                    font-size:18px;
                ">&times;</button>

                <!-- STEP INDICATOR -->
                <div style="
                    display:flex;
                    gap:8px;
                    margin-top:18px;
                ">
                    <div id="stepIndicator1" style="flex:1;height:6px;background:white;border-radius:10px;"></div>
                    <div id="stepIndicator2"
                        style="flex:1;height:6px;background:rgba(255,255,255,.3);border-radius:10px;"></div>
                    <div id="stepIndicator3"
                        style="flex:1;height:6px;background:rgba(255,255,255,.3);border-radius:10px;"></div>
                </div>

            </div>

            <!-- BODY -->
            <div style="background:#f4f7f9;padding:26px 28px;min-height:360px;">

                <!-- STEP 1 -->
                <div class="qualifyStep" id="qualifyStep1">

                    <div style="
                        background:white;
                        border-radius:14px;
                        padding:16px;
                        margin-bottom:14px;
                        box-shadow:0 6px 18px rgba(0,0,0,.05);
                    ">
                        <div style="font-size:12px;color:#7a8a96;">Candidate Name</div>
                        <div id="modalQualifyPipelineName" style="font-weight:600;font-size:15px;color:#2b3e50;"></div>
                    </div>

                    <div style="
                        background:white;
                        border-radius:14px;
                        padding:16px;
                        box-shadow:0 6px 18px rgba(0,0,0,.05);
                    ">
                        <div style="font-size:12px;color:#7a8a96;">Applied Rank</div>
                        <div id="modalQualifyPipelinePosition" style="font-weight:600;font-size:15px;color:#2b3e50;">
                        </div>
                    </div>

                </div>

                <!-- STEP 2 -->
                <div class="qualifyStep" id="qualifyStep2" style="display:none;">

                    <div style="margin-bottom:8px;font-weight:600;color:#5b6b77;font-size:13px;">
                        Select Rank Adjustment
                    </div>

                    <select id="rankSelectPipeline" name="rankSelectPipeline" style="
                            width:100%;
                            border-radius:12px;
                            border:1px solid #d6dde3;
                            padding:10px 12px;
                            background:white;
                        ">
                    </select>

                </div>

                <!-- STEP 3 -->
                <div class="qualifyStep" id="qualifyStep3" style="display:none;">

                    <div style="margin-bottom:8px;font-weight:600;color:#5b6b77;font-size:13px;">
                        Vessel Type Experience
                    </div>

                    <div id="modalQualifyPipelineVesselTypeExperience"></div>

                </div>

                <input type="hidden" id="hiddenCrewIdPipeline">

            </div>

            <!-- FOOTER -->
            <div style="
                background:#eef3f6;
                padding:18px 24px;
                border-top:1px solid #dde5ea;
                display:flex;
                justify-content:space-between;
            ">

                <button id="btnPrevStep" style="
                    border-radius:10px;
                    padding:8px 20px;
                    border:1px solid #cfd8df;
                    background:white;
                    font-weight:600;
                    display:none;
                ">Back</button>

                <div style="margin-left:auto;display:flex;gap:10px;">

                    <button id="btnCancelQualifiedPipeline" data-dismiss="modal" style="
                        border-radius:10px;
                        padding:8px 20px;
                        border:1px solid #cfd8df;
                        background:white;
                        font-weight:600;
                    ">Cancel</button>

                    <button id="btnNextStep" style="
                        border-radius:10px;
                        padding:8px 20px;
                        border:none;
                        font-weight:600;
                        color:white;
                        background:#0854a0;
                        box-shadow:0 8px 20px rgba(0,0,0,.2);
                    ">Next</button>

                    <button id="btnSubmitQualified" onclick="submitQualifiedCrewPipeline()" style="
                        display:none;
                        border-radius:10px;
                        padding:8px 20px;
                        border:none;
                        font-weight:600;
                        color:white;
                        background:#c0392b;
                        box-shadow:0 8px 20px rgba(0,0,0,.2);
                    ">Submit</button>

                </div>

            </div>

        </div>
    </div>
</div>