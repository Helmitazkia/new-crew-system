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
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const input = document.querySelector(".sap-search input");
    if (input) {
        input.addEventListener("keyup", function() {
            searchTableDataMCU(input, 1);
        });
    }
    searchTableDataMCU(input, 1);
});

function searchTableDataMCU(input, page = 1) {
    const searchValue = input ? input.value : "";
    loadDataMCUCrew(page, searchValue);
}

function loadDataMCUCrew(page = 1, searchValue = "") {
    const table = document.getElementById("tableDataMCUCrew");
    if (table) table.dataset.page = page;

    const search = searchValue !== undefined ?
        searchValue :
        ($("#searchMCUCrew").val() || "");

    const rows = table?.dataset.rows ? parseInt(table.dataset.rows) : 10;

    $.ajax({
        url: '<?php echo base_url("searchTableDataMCU"); ?>',
        method: 'GET',
        data: {
            search,
            page,
            rows
        },
        dataType: 'json',
        success: function(res) {

            let html = "";

            const rowsPerPage = parseInt(res.pagination.rows_per_page) || 10;
            const currentPage = parseInt(res.pagination.current_page) || 1;
            let no = (currentPage - 1) * rowsPerPage + 1;

            if (!res.data || res.data.length === 0) {
                $("#idTbodyMCUCrew").html(`
                    <tr>
                        <td colspan="13" style="text-align:center;padding:20px;color:#adb5bd;">
                            No data found
                        </td>
                    </tr>
                `);

                renderPaginationMCU(
                    currentPage,
                    res.pagination.total_pages,
                    search,
                    res.pagination.total_rows,
                    rowsPerPage
                );
                return;
            }

            res.data.forEach(row => {

                const fullname = highlightText(row.fullname, search);
                const email = highlightText(row.email, search);
                const position = highlightText(row.position_applied, search);
                const ijazah = highlightText(row.ijazah_terakhir, search);
                const vesselType = highlightText(row.vessel_type, search);

                let vesselExp = "-";

                if (row.pengalaman_jeniskapal) {

                    vesselExp = `
                        <div style="
                            color:#868e96;
                            line-height:1.4;
                            white-space:normal;
                            word-break:break-word;
                            margin-top:4px;
                        ">
                            ${row.pengalaman_jeniskapal
                                .split(',')
                                .map(v => `
                                    <div>
                                        ${highlightText(v.trim(), search)}
                                    </div>
                                `)
                                .join('')
                            }
                        </div>
                    `;
                }

                let foreignBlock = "-";

                const foreignCrew = row.berlayardengancrewasing || "-";

                if (
                    foreignCrew !== "-" &&
                    foreignCrew.includes("-")
                ) {

                    const parts = foreignCrew.split("-");

                    const status = parts[0].trim();
                    const countries = parts.slice(1).join("-").trim();

                    foreignBlock = `
                        <div style="
                            font-weight:600;
                            color:#0b7285;
                            margin-bottom:4px;
                        ">
                            ${highlightText(status, search)} -
                        </div>

                        <div style="
                            color:#495057;
                            font-size:11px;
                            line-height:1.4;
                            text-align:center;
                            white-space:normal;
                            word-break:break-word;
                            max-width:150px;
                            margin:auto;
                        ">
                            ${countries
                                .split(',')
                                .map(country => `
                                    <div>
                                        ${highlightText(country.trim(), search)}
                                    </div>
                                `)
                                .join('')
                            }
                        </div>
                    `;

                } else {

                    foreignBlock = `
                        <div>
                            ${highlightText(foreignCrew, search)}
                        </div>
                    `;
                }

                let btnAct = `
                <div style="display:flex;flex-direction:column;gap:4px;">
                    <button style="border:1px solid #dee2e6;background:#fff;font-size:12px;padding:5px;border-radius:4px;cursor:pointer;"
                            onclick="window.open('${row.cv_url}','_blank')">
                        📄 View CV
                    </button>
                </div>`;

                let btnWithDraw = `
                <div style="display:flex;flex-direction:column;gap:4px;margin-top:4px;">
                    <button style="border:1px solid #dc3545;background:#fff;color:#dc3545;font-size:12px;padding:5px;border-radius:4px;cursor:pointer;"
                            onclick="withdrawApplicant('${row.id}')">
                        🚫 Withdraw
                    </button>
                </div>`;

                let btnUnfit = `
                <div style="display:flex;flex-direction:column;gap:4px;margin-top:4px;">
                    <button style="border:1px solid #dc3545;background:#fff;color:#dc3545;font-size:12px;padding:5px;border-radius:4px;cursor:pointer;"
                            onclick="setNotFitApplicant('${row.id}')">
                        <i class ="fas fa-user-slash"></i> Not Fit 
                    </button>
                </div>`;

                let btnfit = `
                <div style="display:flex;flex-direction:column;gap:4px;margin-top:4px;">
                    <button style="border:1px solid #28a745;background:#fff;color:#28a745;font-size:12px;padding:5px;border-radius:4px;cursor:pointer;"
                            onclick="setMCUApplicant('${row.id}')">
                        <i class ="fas fa-user-check"></i> Fit 
                    </button>
                </div>`;

                html += `
                <tr id="row_${row.id}" style="border-bottom:1px solid #eef1f5; transition: background 0.3s ease;">
                    
                    <td style="text-align:center;font-size:12px;color:#868e96;vertical-align:top;">
                        ${no++}
                    </td>

                    <td style="min-width:260px;vertical-align:top;">
                        <div style="font-weight:600;font-size:14px;color:#1f2d3d;">${fullname}</div>
                        <div style="font-size:12px;color:#868e96;margin-top:2px;">${email}</div>
                    </td>

                    <td style="min-width:160px;vertical-align:top;">
                        <div style="font-size:13px;font-weight:600;color:#34495e;">${position}</div>
                        <div style="font-size:12px;color:#7f8c8d;margin-top:2px;">${ijazah}</div>
                    </td>

                    <td style="font-size:12px;color:#495057;vertical-align:top;">
                        <div>${row.born_place}</div>
                        <div style="color:#868e96;">${row.born_date}</div>
                    </td>

                    <td style="font-size:12px;vertical-align:top;">
                        ${row.handphone}
                    </td>

                    <td style="
                        font-size:12px;
                        vertical-align:top;
                        white-space:normal;
                        word-break:break-word;
                        max-width:140px;
                    ">
                        ${vesselType}
                    </td>

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
                            ${highlightText(row.last_experience || "-", search)}
                        </div>

                        ${vesselExp}
                    </td>

                    <td style="
                        font-size:12px;
                        text-align:center;
                        vertical-align:top;
                        min-width:170px;
                        padding-top:6px;
                    ">
                        ${foreignBlock}
                    </td>

                   <td style="
                        font-size:12px;
                        text-align:center;
                        vertical-align:top;
                        padding-top:12px;
                    ">
                        <div style="
                            display:flex;
                            flex-direction:column;
                            align-items:center;
                            gap:4px;
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
                                font-size:13px;
                                font-weight:600;
                                color:#065f46;
                            ">
                                ${highlightText(
                                    formatSalary(row.last_salary, ''),
                                    search
                                )}
                            </span>
                        </div>
                    </td>

                    <td style="
                        font-size:12px;
                        text-align:center;
                        vertical-align:top;
                        padding-top:12px;
                    ">
                        <div style="
                            display:flex;
                            flex-direction:column;
                            align-items:center;
                            gap:4px;
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
                                font-size:13px;
                                font-weight:600;
                                color:#065f46;
                            ">
                                ${highlightText(
                                    formatSalary(row.expected_salary, ''),
                                    search
                                )}
                            </span>
                        </div>
                    </td>

                    <td style="font-size:12px;text-align:center;vertical-align:top;">
                        ${row.join_inAndhika}
                    </td>

                    <td style="font-size:12px;color:#868e96;vertical-align:top;">
                        ${row.submit_cv}
                    </td>

                    <td style="text-align:center;min-width:120px;vertical-align:top;">
                        ${btnAct}
                        ${btnWithDraw}
                        ${btnUnfit}
                        ${btnfit}
                    </td>

                </tr>`;
            });

            $("#idTbodyMCUCrew").html(html);

            renderPaginationMCU(
                currentPage,
                res.pagination.total_pages,
                search,
                res.pagination.total_rows,
                rowsPerPage
            );
        }
    });
}

function highlightText(text = "", search = "") {

    if (!search) return text;

    const regex = new RegExp(
        `(${search.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`,
        'gi'
    );

    return String(text).replace(regex, `
        <span style="
            background: linear-gradient(90deg, #ffe066, #ffd43b);
            color: #1c1c1c;
            padding:2px 4px;
            border-radius:4px;
            font-weight:700;
            box-shadow:0 0 4px rgba(255,200,0,0.3);
        ">$1</span>
    `);
}

function changerowsPerPageMCU(val, searchValue) {
    const table = document.getElementById("tableDataMCUCrew");
    if (table) table.dataset.rows = val;
    goToPageMCU(1, searchValue);
}

function renderPaginationMCU(currentPage, totalPages, searchValue, totalRows, rowsPerPage) {
    const pagination = document.getElementById("pagination");
    if (!pagination) return;

    if (totalPages <= 0) {
        pagination.innerHTML = "";
        return;
    }

    const maxVisible = 5;
    let start = Math.max(1, currentPage - 2);
    let end = Math.min(totalPages, start + maxVisible - 1);
    if (end - start < maxVisible - 1) {
        start = Math.max(1, end - maxVisible + 1);
    }

    const btnStyle =
        `border:1px solid #d0d7de;background:#fff;padding:5px 11px;font-size:12px;border-radius:7px;cursor:pointer;font-weight:600;color:#344054;min-width:34px;`;

    const activeStyle =
        `background:#0a6ed1;border:1px solid #0a6ed1;color:#fff;padding:5px 11px;font-size:12px;border-radius:7px;font-weight:700;min-width:34px;`;

    const disabledStyle =
        `border:1px solid #e5e7eb;background:#f1f3f5;padding:5px 11px;font-size:12px;border-radius:7px;color:#adb5bd;min-width:34px;`;

    let html =
        `<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-top:14px;padding:12px 16px;background:#f8fafc;border:1px solid #e5e7eb;border-radius:10px;font-size:13px;">`;

    html += `<div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;color:#475467;">
        <div><strong>${totalRows}</strong> Data • Page <strong>${currentPage}</strong> / <strong>${totalPages}</strong></div>

        <div style="display:flex;align-items:center;gap:6px;">
            Rows :
            <select onchange="changerowsPerPageMCU(this.value,'${searchValue}')" 
                style="border:1px solid #d0d7de;border-radius:6px;padding:3px 6px;font-size:12px;background:white;cursor:pointer;">
                
                <option value="10" ${rowsPerPage==10?'selected':''}>10</option>
                <option value="25" ${rowsPerPage==25?'selected':''}>25</option>
                <option value="50" ${rowsPerPage==50?'selected':''}>50</option>
                <option value="100" ${rowsPerPage==100?'selected':''}>100</option>
            </select>
        </div>
    </div>`;

    html += `<div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">`;

    if (currentPage > 1)
        html += `<button style="${btnStyle}" onclick="goToPageMCU(${currentPage-1},'${searchValue}')">‹</button>`;
    else
        html += `<button disabled style="${disabledStyle}">‹</button>`;

    for (let i = start; i <= end; i++) {
        html += `<button style="${i===currentPage?activeStyle:btnStyle}" 
            onclick="goToPageMCU(${i},'${searchValue}')">${i}</button>`;
    }

    if (end < totalPages) {
        if (end < totalPages - 1)
            html += `<span style="padding:0 4px;color:#98a2b3;font-weight:600;">...</span>`;

        html += `<button style="${btnStyle}" 
            onclick="goToPageMCU(${totalPages},'${searchValue}')">${totalPages}</button>`;
    }

    if (currentPage < totalPages)
        html += `<button style="${btnStyle}" onclick="goToPageMCU(${currentPage+1},'${searchValue}')">›</button>`;
    else
        html += `<button disabled style="${disabledStyle}">›</button>`;

    html += `<div style="display:flex;align-items:center;gap:5px;margin-left:8px;">
        Go :
        <input type="number" min="1" max="${totalPages}" id="jumpPageInputMCU"
            style="width:55px;border:1px solid #d0d7de;border-radius:6px;padding:3px 6px;font-size:12px;">
        <button style="${btnStyle}" onclick="jumpToPage('${searchValue}')">OK</button>
    </div>`;

    html += `</div></div>`;

    pagination.innerHTML = html;
}

function goToPageMCU(page, searchValue) {
    loadDataMCUCrew(page, searchValue);
}

function jumpToPage(searchValue) {
    const input = document.getElementById("jumpPageInputMCU");
    if (!input) return;
    let page = parseInt(input.value);
    if (!page || page < 1) return;
    goToPageMCU(page, searchValue);
}



function renumberTableRows() {

    const tbody = document.getElementById("idTbodyMCUCrew");

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

    row.style.transition = "all 0.5s ease";
    row.style.backgroundColor = "#ffe8e8";

    setTimeout(() => {
        row.style.opacity = "0";
        row.style.transform = "translateX(-40px)";
        row.style.height = "0";
    }, 50);

    setTimeout(() => {

        row.remove();

        renumberTableRows();

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

function formatSalary(amount, currency, searchValue = '') {

    if (
        amount === null ||
        amount === undefined ||
        amount === '' ||
        amount === 0 ||
        amount === '0'
    ) {
        return '-';
    }

    const num = parseFloat(
        String(amount).replace(/,/g, '')
    );

    if (isNaN(num)) {
        return `
            <span style="
                background:#e7f5ff;
                color:#1971c2;
                padding:2px 6px;
                border-radius:10px;
                font-size:10px;
            ">
                ${currency || '-'}
            </span>
            ${highlightText(String(amount), searchValue)}
        `;
    }

    return `
        <span style="
            background:#e7f5ff;
            color:#1971c2;
            padding:2px 6px;
            border-radius:10px;
            font-size:10px;
        ">
            ${currency || '-'}
        </span>
        ${highlightText(
            num.toLocaleString('en-US', {
                maximumFractionDigits: 2
            }),
            searchValue
        )}
    `;
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
            <input type="text" placeholder="Search name, email, position applied"
                onkeyup="searchTableDataMCU(this,'Datainterview')">
        </div>
    </div>

    <div class="sap-content">

        <div id="idLoadingSpinnerMCU" class="sap-loading" style="display:none;">
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

            <table class="sap-table" id="tableDataMCUCrew" data-page="1" data-search="">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th style="min-width:220px;">Seafarer</th>
                        <th style="min-width:160px;">Position Applied & Certificate</th>
                        <th style="min-width:140px;">Birth</th>
                        <th style="min-width:120px;">Phone</th>
                        <th style="min-width:120px;">Apply Vessel Type</th>
                        <th style="min-width:220px;">Experience</th>
                        <th style="width:90px;">Foreign</th>
                        <th style="width:140px;text-align:center;">Last Salary</th>
                        <th style="width:140px;text-align:center;">Expected Salary</th>
                        <th style="width:100px;">Prev Join</th>
                        <th style="width:120px;">Submit Date</th>
                        <th style="width:140px;">Action</th>
                    </tr>
                </thead>

                <tbody id="idTbodyMCUCrew"></tbody>
            </table>
        </div>

        <div id="pagination" class="mt-3"></div>
    </div>
</div>