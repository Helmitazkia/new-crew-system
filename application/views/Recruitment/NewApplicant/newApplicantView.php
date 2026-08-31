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
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {

    const input = document.querySelector(".sap-search input");

    if (input) {

        input.addEventListener("keyup", function() {
            searchTableDataReady(input, 1);
        });

    }

    searchTableDataReady(input, 1);

});

function goToPageReady(page, searchValue = "") {

    const input = document.querySelector(".sap-search input");
    if (input) input.value = searchValue;

    searchTableDataReady(input, page);
}

function jumpToPageReady(searchValue = "") {

    const input = document.getElementById("jumpPageReady");
    if (!input) return;

    let page = parseInt(input.value);
    if (!page || page < 1) return;

    goToPageReady(page, searchValue);
}

function changeRowsPerPageReady(val, searchValue = "") {

    const table = document.getElementById("tableDataReady");

    if (table) {
        table.dataset.rows = val;
    }

    goToPageReady(1, searchValue);

}

function renderPagination(currentPage, totalPages, searchValue, totalRows, rowsPerPage) {

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

    const btnStyle = `
        border:1px solid #d0d7de;
        background:#fff;
        padding:5px 11px;
        font-size:12px;
        border-radius:7px;
        cursor:pointer;
        font-weight:600;
        color:#344054;
        min-width:34px;
        transition:all .18s ease;
    `;

    const activeStyle = `
        background:#0a6ed1;
        border:1px solid #0a6ed1;
        color:#fff;
        padding:5px 11px;
        font-size:12px;
        border-radius:7px;
        font-weight:700;
        min-width:34px;
        box-shadow:0 2px 6px rgba(10,110,209,.25);
    `;

    const disabledStyle = `
        border:1px solid #e5e7eb;
        background:#f1f3f5;
        padding:5px 11px;
        font-size:12px;
        border-radius:7px;
        color:#adb5bd;
        min-width:34px;
    `;

    let html = `
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        flex-wrap:wrap;
        gap:12px;
        margin-top:14px;
        padding:12px 16px;
        background:#f8fafc;
        border:1px solid #e5e7eb;
        border-radius:10px;
        font-size:13px;">
    `;

    /* ===== LEFT INFO ===== */

    html += `
    <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;color:#475467;">
        <div>
            <strong>${totalRows}</strong> Data • 
            Page <strong>${currentPage}</strong> / <strong>${totalPages}</strong>
        </div>

        <div style="display:flex;align-items:center;gap:6px;">
            Rows :
            <select 
                onchange="changeRowsPerPageReady(this.value,'${searchValue}')"
                style="
                border:1px solid #d0d7de;
                border-radius:6px;
                padding:3px 6px;
                font-size:12px;
                background:white;
                cursor:pointer;">
                <option value="10" ${rowsPerPage == 10 ? 'selected' : ''}>10</option>
                <option value="25" ${rowsPerPage == 25 ? 'selected' : ''}>25</option>
                <option value="50" ${rowsPerPage == 50 ? 'selected' : ''}>50</option>
                <option value="100" ${rowsPerPage == 100 ? 'selected' : ''}>100</option>
            </select>
        </div>
    </div>
    `;

    /* ===== RIGHT CONTROL ===== */

    html += `<div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">`;

    /* BIG PREVIOUS */

    if (currentPage > 1) {
        html += `
        <button
            style="
                border:1px solid #0a6ed1;
                background:#e7f1ff;
                padding:6px 14px;
                font-size:13px;
                border-radius:8px;
                cursor:pointer;
                font-weight:700;
                color:#0a6ed1;
                margin-right:6px;
            "
            onclick="goToPageReady(${currentPage - 1}, '${searchValue}')">
            ← Previous
        </button>`;
    }

    /* SMALL PREV */

    if (currentPage > 1) {
        html += `
        <button
            style="${btnStyle}"
            onclick="goToPageReady(${currentPage - 1}, '${searchValue}')">
            ‹
        </button>`;
    } else {
        html += `<button disabled style="${disabledStyle}">‹</button>`;
    }

    /* FIRST */

    if (start > 1) {

        html += `
        <button
            style="${btnStyle}"
            onclick="goToPageReady(1, '${searchValue}')">
            1
        </button>`;

        if (start > 2) {
            html += `<span style="padding:0 4px;color:#98a2b3;font-weight:600;">...</span>`;
        }
    }

    /* PAGE NUMBERS */

    for (let i = start; i <= end; i++) {

        html += `
        <button
            style="${i === currentPage ? activeStyle : btnStyle}"
            onclick="goToPageReady(${i}, '${searchValue}')">
            ${i}
        </button>`;
    }

    /* LAST */

    if (end < totalPages) {

        if (end < totalPages - 1) {
            html += `<span style="padding:0 4px;color:#98a2b3;font-weight:600;">...</span>`;
        }

        html += `
        <button
            style="${btnStyle}"
            onclick="goToPageReady(${totalPages}, '${searchValue}')">
            ${totalPages}
        </button>`;
    }

    /* SMALL NEXT */

    if (currentPage < totalPages) {
        html += `
        <button
            style="${btnStyle}"
            onclick="goToPageReady(${currentPage + 1}, '${searchValue}')">
            ›
        </button>`;
    } else {
        html += `<button disabled style="${disabledStyle}">›</button>`;
    }

    /* BIG NEXT */

    if (currentPage < totalPages) {
        html += `
        <button
            style="
                border:1px solid #0a6ed1;
                background:#0a6ed1;
                padding:6px 14px;
                font-size:13px;
                border-radius:8px;
                cursor:pointer;
                font-weight:700;
                color:white;
                margin-left:6px;
            "
            onclick="goToPageReady(${currentPage + 1}, '${searchValue}')">
            Next →
        </button>`;
    }

    /* JUMP PAGE */

    html += `
    <div style="display:flex;align-items:center;gap:5px;margin-left:8px;">
        Go :
        <input
            type="number"
            min="1"
            max="${totalPages}"
            id="jumpPageReady"
            style="
                width:55px;
                border:1px solid #d0d7de;
                border-radius:6px;
                padding:3px 6px;
                font-size:12px;">
        <button
            style="${btnStyle}"
            onclick="jumpToPageReady('${searchValue}')">
            OK
        </button>
    </div>
    `;

    html += `</div></div>`;

    pagination.innerHTML = html;
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

function formatSalary(amount, currency = '') {

    const num = parseFloat(amount);

    if (isNaN(num) || num <= 0) {
        return "-";
    }

    const formatted = num.toLocaleString('en-US', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 2
    });

    return currency ?
        `${currency} ${formatted}` :
        formatted;
}

function searchTableDataReady(inputElement, page = 1) {

    const table = document.getElementById("tableDataReady");
    const tbody = document.getElementById("idTbodylistCrewNewModal");
    const totalEl = document.getElementById("totalApplicants");

    if (!table || !tbody) return;

    const searchValue = inputElement ? inputElement.value.toLowerCase() : "";

    if (!table.dataset.rows) {
        table.dataset.rows = 10;
    }

    const rowsPerPage = parseInt(table.dataset.rows);

    table.dataset.page = page;
    table.dataset.search = searchValue;

    table.style.transition = "opacity .25s ease";
    table.style.opacity = "0.35";

    const base_url = "<?php echo base_url(); ?>";

    $.ajax({
        url: base_url + "searchDataReady",
        type: "GET",
        data: {
            search: searchValue,
            page: page,
            rows: rowsPerPage
        },
        success: function(res) {

            let response = typeof res === "string" ? JSON.parse(res) : res;

            tbody.innerHTML = "";

            if (totalEl) totalEl.innerText = response.total_rows;

            if (searchValue) {

                document.getElementById("searchIndicator").innerHTML = `
                <div style="
                    display:inline-flex;
                    align-items:center;
                    gap:8px;
                    background:#f1f5f9;
                    padding:6px 12px;
                    border-radius:20px;
                    font-size:12px;
                    font-weight:600;
                    color:#334155;
                    margin-bottom:8px;
                ">
                🔎 Search : 
                    <span style="
                        background:linear-gradient(120deg,#c7e0ff,#8ec5ff);
                        padding:3px 8px;
                        border-radius:6px;
                        font-weight:700;
                        color:#0a3d91;
                    ">
                        ${searchValue}
                    </span>
                </div>`;
            } else {
                document.getElementById("searchIndicator").innerHTML = "";
            }

            if (!response.data.length) {

                tbody.innerHTML = `
                <tr>
                    <td colspan="15" style="padding:40px;text-align:center;color:#6b7280;">
                        No applicant found
                    </td>
                </tr>`;

            } else {

                const today = new Date().toISOString().slice(0, 10);

                response.data.forEach((row, index) => {

                    const tr = document.createElement("tr");
                    tr.id = "row_" + row.id;
                    tr.style.borderBottom = "1px solid #eef1f5";

                    let badge = "";

                    const today = new Date().toISOString().slice(0, 10);

                    let foreignCrewHtml = '-';

                    const foreignCrew = row.foreign_crew || '-';

                    if (
                        foreignCrew !== '-' &&
                        foreignCrew.includes('-')
                    ) {

                        const parts = foreignCrew.split('-');

                        const status = parts[0].trim();
                        const countries = parts.slice(1).join('-').trim();

                        foreignCrewHtml = `
                            <div style="
                                font-weight:600;
                                color:#0b7285;
                                margin-bottom:4px;
                            ">
                                ${highlightText(status, searchValue)} -
                            </div>

                            <div style="
                                color:#495057;
                                font-size:12px;
                                line-height:1.5;
                                text-align:left;
                                white-space:normal;
                                word-break:break-word;
                                max-width:160px;
                                margin:auto;
                            ">
                                ${highlightText(
                                    countries
                                        .split(',')
                                        .map(item => item.trim())
                                        .join('<br>'),
                                    searchValue
                                )}
                            </div>
                        `;

                    } else {

                        foreignCrewHtml = `
                            <div style="
                                font-size:12px;
                                color:#495057;
                            ">
                                ${highlightText(foreignCrew, searchValue)}
                            </div>
                        `;
                    }

                    if (row.submit_cv_raw && row.submit_cv_raw.startsWith(today)) {
                        badge = `
                        <span style="
                            background:#0a6ed1;
                            color:white;
                            font-size:10px;
                            font-weight:700;
                            padding:3px 7px;
                            border-radius:20px;
                            margin-left:6px;
                        ">
                        NEW
                        </span>`;
                    }

                    tr.innerHTML = `
                        <td style="text-align:center;font-size:12px;color:#868e96;vertical-align:middle;">
                            ${response.start + index}
                        </td>

                        <td style="min-width:260px;vertical-align:middle;">
                            <div style="font-weight:600;font-size:14px;color:#1f2d3d;">
                                ${highlightText(row.fullname || "-", searchValue)}
                                ${badge}
                            </div>
                            <div style="font-size:12px;color:#868e96;margin-top:2px;">
                                ${highlightText(row.email || "-", searchValue)}
                            </div>
                        </td>

                        <td style="min-width:160px;vertical-align:middle;">
                            <div style="font-size:13px;font-weight:600;color:#34495e;">
                                ${highlightText(row.position_applied || "-", searchValue)}
                            </div>
                            <div style="font-size:12px;color:#7f8c8d;margin-top:2px;">
                                ${highlightText(row.ijazah_terakhir || "-", searchValue)}
                            </div>
                        </td>

                        <td style="font-size:12px;color:#495057;vertical-align:middle;">
                            <div>${highlightText(row.born_place || "-", searchValue)}</div>
                            <div style="color:#868e96;">
                                ${highlightText(row.born_date || "-", searchValue)}
                            </div>
                        </td>

                        <td style="font-size:12px;vertical-align:middle;">
                            ${highlightText(row.handphone || "-", searchValue)}
                        </td>

                        <td style="font-size:12px;vertical-align:middle;">
                            ${highlightText(row.vessel_type || "-", searchValue)}
                        </td>

                        <td style="
                            font-size:12px;
                            vertical-align:middle;
                            min-width:220px;
                        ">
                            <div style="
                                font-weight:600;
                                color:#34495e;
                                margin-bottom:6px;
                            ">
                                ${highlightText(row.last_experience || "-", searchValue)}
                            </div>

                            <div style="
                                color:#868e96;
                                line-height:1.4;
                                white-space:normal;
                                word-break:break-word;
                                max-width:130px;
                            ">
                                ${(row.pengalaman_jeniskapal || "-")
                                    .split(',')
                                    .map(item =>
                                        `<div>${highlightText(item.trim(), searchValue)}</div>`
                                    )
                                    .join('')
                                }
                            </div>
                        </td>

                        <td style="font-size:12px;text-align:center;vertical-align:middle;">
                           ${foreignCrewHtml}
                        </td>

                        <td style="font-size:12px;text-align:right;font-weight:600;color:#065f46;text-align:center;vertical-align:middle;">
                            <span style="
                                background:#e7f5ff;
                                color:#1971c2;
                                padding:2px 6px;
                                border-radius:10px;
                                font-size:10px;
                                margin-right:4px;
                            ">
                                ${row.last_salary_currency || '-'}
                            </span>
                            ${highlightText(
                                formatSalary(row.last_salary, ''),
                                searchValue
                            )}
                        </td>

                        <td style="font-size:12px;text-align:right;font-weight:600;color:#065f46;text-align:center;vertical-align:middle;">
                            <span style="
                                background:#e7f5ff;
                                color:#1971c2;
                                padding:2px 6px;
                                border-radius:10px;
                                font-size:10px;
                                margin-right:4px;
                            ">
                                ${row.expected_salary_currency || '-'}
                            </span>
                            ${highlightText(
                                formatSalary(row.expected_salary, ''),
                                searchValue
                            )}
                        </td>
                        
                        <td style="font-size:12px;text-align:center;vertical-align:middle;">
                            ${highlightText(row.prev_join || "-", searchValue)}
                        </td>

                        <td style="font-size:12px;color:#868e96;vertical-align:middle;">
                            ${highlightText(row.submit_cv || "-", searchValue)}
                        </td>

                        <td style="text-align:center;min-width:150px;vertical-align:middle;">
                            <div style="display:flex;flex-direction:column;gap:4px;">
                                <button onclick="window.open('${row.cv_url}','_blank')"
                                    style="border:1px solid #dee2e6;background:#fff;font-size:12px;padding:5px;border-radius:4px;cursor:pointer;">
                                    📄 View CV
                                </button>

                                <button onclick="QualifiedCrew('${row.id}','${row.fullname}')"
                                    style="background:#e6fcf5;border:1px solid #20c997;color:#087f5b;font-size:12px;padding:5px;border-radius:4px;cursor:pointer;">
                                    ✔ Qualified
                                </button>

                                <button onclick="notPositionCrew('${row.id}','${row.fullname}')"
                                    style="background:#fff4e5;border:1px solid #ff922b;color:#b26a00;font-size:12px;padding:5px;border-radius:4px;cursor:pointer;">
                                    ⚠ Not Position
                                </button>

                                <button onclick="showNotQualifyModalLayer1(this)"
                                    data-id="${row.id}"
                                    data-name="${row.fullname}"
                                    data-position="${row.position_applied}"
                                    data-last-experience="${row.last_experience || ''}"
                                    style="background:#fff5f5;border:1px solid #ff6b6b;color:#c92a2a;font-size:12px;padding:5px;border-radius:4px;cursor:pointer;">
                                    ✕ Not Qualified
                                </button>
            
                                <button onclick="deleteData('${row.id}','${row.fullname}')"
                                    style="background:#fff4e5;border:1px solid #ff2b2b;color:#b26a00;font-size:12px;padding:5px;border-radius:4px;cursor:pointer;">
                                    🗑 Delete
                                </button>
                            </div>
                        </td>
                    `;

                    tbody.appendChild(tr);

                });

            }

            renderPagination(
                response.page,
                response.total_pages,
                searchValue,
                response.total_rows,
                response.rows_per_page
            );

            table.style.opacity = "1";

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

function renumberTableRows() {

    const tbody = document.getElementById("idTbodylistCrewNewModal");

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

    const tbody = document.getElementById("idTbodylistCrewNewModal");
    const table = document.getElementById("tableDataReady");

    row.style.transition = "all .35s cubic-bezier(.4,0,.2,1)";
    row.style.background = "#fff5f5";

    setTimeout(() => {
        row.style.opacity = "0";
        row.style.transform = "translateX(-20px) scale(.97)";
    }, 10);

    setTimeout(() => {

        row.remove();

        const currentPage = parseInt(table.dataset.page) || 1;
        const searchValue = table.dataset.search || "";

        const remainingRows = tbody.querySelectorAll("tr").length;

        if (remainingRows === 0 && currentPage > 1) {

            searchTableDataReady({
                    value: searchValue
                },
                currentPage - 1
            );

        } else {

            searchTableDataReady({
                    value: searchValue
                },
                currentPage
            );

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

    <div class="sap-header">
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
    </div>

    <div class="sap-toolbar">
        <div class="sap-search">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search name, email, position applied"
                onkeyup="searchTableDataReady(this,'DataReady')">
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
            <table class="sap-table" id="tableDataReady" data-page="1" data-search="">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th style="min-width:220px;">Seafarer</th>
                        <th style="min-width:160px;">Position Applied & Certificate</th>
                        <th style="min-width:140px;">Birth</th>
                        <th style="min-width:120px;">Phone</th>
                        <th style="min-width:120px;">Apply Vessel Type</th>
                        <th style="min-width:120px;">Experience</th>
                        <th style="width:90px;">Foreign</th>
                        <th style="width:120px;">Last Salary</th>
                        <th style="width:120px;">Expected Salary</th>
                        <th style="width:100px;">Prev Join</th>
                        <th style="width:120px;">Submit Date</th>
                        <th style="width:140px;">Action</th>
                    </tr>
                </thead>

                <tbody id="idTbodylistCrewNewModal"></tbody>
            </table>
        </div>

        <div id="pagination" class="mt-3"></div>
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