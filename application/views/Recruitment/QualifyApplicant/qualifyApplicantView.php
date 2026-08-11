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

/* CONTENT */
.sap-content {
    position: relative;
    background: #ffffff;
    border-radius: 20px;
    padding: 18px;
    box-shadow: 0 18px 40px rgba(0, 0, 0, .08);
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

/* HEADER */
#tableDataQualifiedCrew thead th {
    background: #000099 !important;
    color: #fff !important;
    border-right: 1px solid rgba(255, 255, 255, .85) !important;
    border-bottom: 1px solid rgba(255, 255, 255, .35) !important;
}

#tableDataQualifiedCrew thead th:last-child {
    border-right: none !important;
}

/* BODY */
#tableDataQualifiedCrew tbody td {
    padding: 12px 14px;
    background: #fff;
    border-right: 1px solid #e2e8f0;
    border-bottom: 1px solid #e2e8f0;
}

/* hilangkan border kanan kolom terakhir */
#tableDataQualifiedCrew tbody td:last-child {
    border-right: none;
}

#tableDataQualifiedCrew tbody tr:nth-child(even) td {
    background: #f8fafc;
}

#tableDataQualifiedCrew tbody tr:hover td {
    background: #edf4ff !important;
}

.sap-table-wrapper {
    overflow: auto;
    border: 1px solid #e9ecef;
    border-radius: 10px;
    background: #fff;
}

.sap-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
    font-family: 'Segoe UI', Roboto, Arial, sans-serif;
}

.sap-table thead {
    position: sticky;
    top: 0;
    z-index: 10;
}

.sap-table thead th {
    background: #f8fafc;
    color: #34495e;
    font-size: 12px;
    font-weight: 700;
    padding: 12px 14px;
    border-bottom: 1px solid #e5e7eb;
    white-space: nowrap;
    text-align: left;
}

.sap-table tbody tr {
    border-bottom: 1px solid #eef1f5;
    transition: all .18s ease;
}

.sap-table tbody tr:hover {
    background: #f8fbff;
}

.sap-table tbody td {
    padding: 12px 14px;
    vertical-align: middle;
}

.sap-table tbody tr:last-child {
    border-bottom: none;
}
</style>
<script>
document.addEventListener("DOMContentLoaded", function() {

    const input = document.querySelector(".sap-search input");

    if (input) {

        input.addEventListener("keyup", function() {
            searchTableDataQualifiedCrew(input, 1);
        });

    }

    searchTableDataQualifiedCrew(input, 1);

});

function goToPage(page, searchValue) {

    const table = document.getElementById("tableDataQualifiedCrew");
    const rows = table.dataset.rows || 10;

    searchTableDataQualifiedCrew({
            value: searchValue
        },
        page,
        rows
    );
}

function jumpToPage(searchValue) {

    const input = document.getElementById("jumpPageInput");
    if (!input) return;

    let page = parseInt(input.value);
    if (!page || page < 1) return;

    goToPage(page, searchValue);
}

function changeRowsPerPage(val) {

    const table = document.getElementById("tableDataQualifiedCrew");

    if (table) {
        table.dataset.rows = val;
    }

    const searchValue = table.dataset.search || "";

    searchTableDataQualifiedCrew({
            value: searchValue
        },
        1
    );
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

    html += `
    <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;color:#475467;">
        <div>
            <strong>${totalRows}</strong> Data • 
            Page <strong>${currentPage}</strong> / <strong>${totalPages}</strong>
        </div>

        <div style="display:flex;align-items:center;gap:6px;">
            Rows :
            <select 
                 onchange="changeRowsPerPage(this.value)"
                style="
                border:1px solid #d0d7de;
                border-radius:6px;
                padding:3px 6px;
                font-size:12px;
                background:white;
                cursor:pointer;">
                <option value="10" ${rowsPerPage==10?'selected':''}>10</option>
                <option value="25" ${rowsPerPage==25?'selected':''}>25</option>
                <option value="50" ${rowsPerPage==50?'selected':''}>50</option>
                <option value="100" ${rowsPerPage==100?'selected':''}>100</option>
            </select>
        </div>
    </div>
    `;

    /* ===== RIGHT CONTROL ===== */

    html += `<div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">`;

    /* BIG PREVIOUS */

    if (currentPage > 1) {
        html += `<button style="
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
        onclick="goToPage(${currentPage-1},'${searchValue}')">
        ← Previous
        </button>`;
    }

    if (currentPage > 1) {
        html += `<button style="${btnStyle}" 
            onclick="goToPage(${currentPage-1},'${searchValue}')">‹</button>`;
    } else {
        html += `<button disabled style="${disabledStyle}">‹</button>`;
    }


    if (start > 1) {
        html += `<button style="${btnStyle}"
            onclick="goToPage(1,'${searchValue}')">1</button>`;

        if (start > 2) {
            html += `<span style="padding:0 4px;color:#98a2b3;font-weight:600;">...</span>`;
        }
    }

    for (let i = start; i <= end; i++) {

        html += `<button
            style="${i===currentPage?activeStyle:btnStyle}"
            onclick="goToPage(${i},'${searchValue}')">${i}</button>`;
    }

    if (end < totalPages) {

        if (end < totalPages - 1) {
            html += `<span style="padding:0 4px;color:#98a2b3;font-weight:600;">...</span>`;
        }

        html += `<button style="${btnStyle}"
            onclick="goToPage(${totalPages},'${searchValue}')">${totalPages}</button>`;
    }

    /* SMALL NEXT */

    if (currentPage < totalPages) {
        html += `<button style="${btnStyle}"
            onclick="goToPage(${currentPage+1},'${searchValue}')">›</button>`;
    } else {
        html += `<button disabled style="${disabledStyle}">›</button>`;
    }

    /* BIG NEXT */

    if (currentPage < totalPages) {
        html += `<button style="
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
        onclick="goToPage(${currentPage+1},'${searchValue}')">
        Next →
        </button>`;
    }

    /* JUMP INPUT */

    html += `
    <div style="display:flex;align-items:center;gap:5px;margin-left:8px;">
        Go :
        <input 
            type="number"
            min="1"
            max="${totalPages}"
            id="jumpPageInput"
            style="
            width:55px;
            border:1px solid #d0d7de;
            border-radius:6px;
            padding:3px 6px;
            font-size:12px;">
        <button
            style="${btnStyle}"
            onclick="jumpToPage('${searchValue}')">
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


function searchTableDataQualifiedCrew(inputElement, page = 1) {

    const table = document.getElementById("tableDataQualifiedCrew");
    const tbody = document.getElementById("idTbodyQualifiedCrew");
    const totalEl = document.getElementById("totalApplicants");

    if (!table || !tbody) return;

    const searchValue = inputElement ? inputElement.value.toLowerCase() : "";

    table.dataset.page = page;
    table.dataset.search = searchValue;

    table.style.transition = "opacity .25s ease";
    table.style.opacity = "0.35";

    const base_url = "<?php echo base_url(); ?>";
    const sortBy = table.dataset.sortBy || "";
    const sortOrder = table.dataset.sortOrder || "";
    const rows = table.dataset.rows || 10;


    $.ajax({
        url: base_url + "searchDataQualifiedCrew",
        type: "GET",
        data: {
            search: searchValue,
            page: page,
            sortBy: sortBy,
            sortOrder: sortOrder,
            rows: rows
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

                    tr.style.transition = "all .18s ease";

                    tr.onmouseover = function() {
                        this.style.background = "#f4f8ff";
                    };

                    tr.onmouseout = function() {
                        this.style.background = "white";
                    };

                    let badge = "";

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
                                font-size:11px;
                                line-height:1.4;
                                text-align:left;
                                white-space:normal;
                                word-break:break-word;
                                max-width:140px;
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
                        </span>
                        `;

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

                        <td style="min-width:220px;vertical-align:middle;">

                            <div style="
                                display:inline-block;
                                background:#e7f5ff;
                                color:#1971c2;
                                font-size:10px;
                                font-weight:700;
                                padding:2px 6px;
                                border-radius:10px;
                                margin-bottom:3px;
                            ">
                                APPLIED POSITION
                            </div>

                            <div style="
                                font-size:13px;
                                font-weight:600;
                                color:#0b7285;
                                margin-bottom:6px;
                            ">
                                ${highlightText(row.position_applied || "-", searchValue)}
                            </div>

                            <div style="
                                display:inline-block;
                                background:#f1f3f5;
                                color:#495057;
                                font-size:10px;
                                font-weight:700;
                                padding:2px 6px;
                                border-radius:10px;
                                margin-bottom:3px;
                            ">
                                CURRENT POSITION
                            </div>

                            <div style="
                                font-size:12px;
                                color:#495057;
                                margin-bottom:6px;
                            ">
                                ${highlightText(row.position_existing || "-", searchValue)}
                            </div>

                            <div style="
                                display:inline-block;
                                background:#e7f5ff;
                                color:#1971c2;
                                font-size:10px;
                                font-weight:700;
                                padding:2px 6px;
                                border-radius:10px;
                                margin-bottom:3px;
                            ">
                                CERTIFICATE
                            </div>
                            
                            <div style="
                                font-size:11px;
                                color:#868e96;
                                border-top:1px dashed #dee2e6;
                                padding-top:4px;
                            ">
                                🎓 ${highlightText(row.ijazah_terakhir || "-", searchValue)}
                            </div>

                        </td>

                        <td style="font-size:12px;color:#495057;vertical-align:middle;">
                            <div>
                                ${highlightText(row.born_place || "-", searchValue)}
                            </div>
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

                        <td style="font-size:12px;vertical-align:middle;">
                            <div style="font-weight:500;">
                                ${highlightText(row.last_experience || "-", searchValue)}
                            </div>
                            <div style="color:#868e96;">
                                ${highlightText(row.pengalaman_jeniskapal || "-", searchValue)}
                            </div>
                        </td>

                        <td style="
                            font-size:12px;
                            text-align:center;
                            vertical-align:middle;
                        ">
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

                                <button
                                    onclick="window.open('${row.cv_url}','_blank')"
                                    style="
                                        border:1px solid #dee2e6;
                                        background:#fff;
                                        font-size:12px;
                                        padding:5px;
                                        border-radius:4px;
                                        cursor:pointer;
                                    ">
                                    📄 View CV
                                </button>

                                <button
                                    data-id="${row.id}"
                                    data-name=":: ${row.fullname} ::"
                                    data-link="${row.interview_link}"
                                    onclick="interviewCrewQualify(this)"
                                    style="
                                        background:#e6fcf5;
                                        border:1px solid #20c997;
                                        color:#087f5b;
                                        font-size:12px;
                                        padding:5px;
                                        border-radius:4px;
                                        cursor:pointer;
                                    ">
                                    ✔ Qualified
                                </button>

                                <button
                                    data-id="${row.id}"
                                    data-name="${row.fullname}"
                                    data-position="${row.position_applied}"
                                    data-vessel-type= "${row.vessel_type}"
                                    onclick="showNotQualifyModal(this)"
                                    style="
                                        background:#fff5f5;
                                        border:1px solid #ff6b6b;
                                        color:#c92a2a;
                                        font-size:12px;
                                        padding:5px;
                                        border-radius:4px;
                                        cursor:pointer;
                                    ">
                                    ✕ Not Qualified
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
                response.rows_per_page || 10
            );

            table.style.opacity = "1";

        }

    });

}

function copyAllSafe() {

    if (!window.copyInterviewData) {
        Swal.fire('Error', 'Data belum siap untuk disalin', 'error');
        return;
    }

    navigator.clipboard.writeText(window.copyInterviewData).then(() => {

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Link & akun berhasil disalin',
            showConfirmButton: false,
            timer: 3000
        });

    }).catch(() => {
        Swal.fire('Gagal', 'Browser tidak mengizinkan copy otomatis', 'error');
    });
}

function renumberTableRows() {

    const tbody = document.getElementById("idTbodyQualifiedCrew");

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

    const tbody = document.getElementById("idTbodyQualifiedCrew");
    const table = document.getElementById("tableDataQualifiedCrew");

    row.style.transition = "all .35s cubic-bezier(.4,0,.2,1)";
    row.style.background = "#fff5f5";

    setTimeout(() => {
        row.style.opacity = "0";
        row.style.transform = "translateX(-20px) scale(.97)";
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

            searchTableDataQualifiedCrew(null, targetPage);

        } else {

            renumberTableRows();

        }

    }, 350);

}

function interviewCrewQualify(el) {

    const id = el.dataset.id;
    const name = el.dataset.name;
    const row = el.closest("tr");

    Swal.fire({
        title: 'Konfirmasi',
        html: `
            Apakah anda yakin ingin menandai <b>${name}</b> 
            untuk proses <span style="color:#067780;font-weight:600;">Interview</span>?
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#067780',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Set Interview',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if (!result.isConfirmed) return;

        $("#idLoadingSpinnerQualifiedCrew").fadeIn();

        $.ajax({
            url: '<?php echo base_url("QualifiedCrewData") ?>',
            type: "POST",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {

                $("#idLoadingSpinnerQualifiedCrew").fadeOut();

                window.copyInterviewData =
                    `Link Login:
                ${response.link}

                Username: ${response.username}
                Password: ${response.password}`;

                Swal.fire({
                    title: 'Interview Set!',
                    html: `
                        <div style="text-align:left;font-size:13px;">
                            <b>Link Login:</b><br>
                            <input type="text"
                                style="width:100%;margin-bottom:6px;"
                                value="${response.link}" readonly>

                            <b>Username:</b> ${response.username}<br>
                            <b>Password:</b> ${response.password}

                            <button
                                type="button"
                                class="btn btn-xs btn-info"
                                style="margin-top:10px;"
                                onclick="copyAllSafe()">
                                📋 Copy Semua
                            </button>
                        </div>
                    `,
                    icon: 'success',
                    confirmButtonColor: '#067780',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                });

                const row = document.getElementById("row_" + id);

                animateRemoveRow(row);

            },
            error: function(xhr) {
                $("#idLoadingSpinnerQualifiedCrew").fadeOut();
                Swal.fire('Error', xhr.responseText, 'error');
            }
        });

    });
}

function sortTable(column) {

    const table = document.getElementById("tableDataQualifiedCrew");

    let currentSortBy = table.dataset.sortBy || "";
    let currentSortOrder = table.dataset.sortOrder || "ASC";

    let newSortOrder = "ASC";

    if (currentSortBy === column) {
        newSortOrder = currentSortOrder === "ASC" ? "DESC" : "ASC";
    }

    table.dataset.sortBy = column;
    table.dataset.sortOrder = newSortOrder;

    const arrow = newSortOrder === "ASC" ? "▲" : "▼";

    document.querySelectorAll(".sort-indicator").forEach(el => el.innerHTML = "");

    const header = document.querySelector(`[data-column='${column}']`);
    if (header) {

        if (!header.querySelector(".sort-indicator")) {
            header.innerHTML += ` <span class="sort-indicator"></span>`;
        }

        header.querySelector(".sort-indicator").innerHTML =
            `<span style="font-weight:bold;color:#fff;">${arrow}</span>`;
    }

    const input = document.querySelector(".sap-search input");
    searchTableDataQualifiedCrew(input, 1);
}

function showNotQualifyModal(btn) {

    const id = $(btn).data('id');
    const name = $(btn).data('name');
    const position = $(btn).data('position');
    const vesselType = $(btn).data('vessel-type')

    const row = $(btn).closest("tr"); // ambil row

    $('#modalNotQualifyName').text(name);
    $('#modalNotQualifyPosition').text(position);
    // $('#modalNotQualifyLastExperience').text(lastExperience);
    $('#modalNotQualifyAppliedVesselType').text(vesselType);

    $('#txtNotQualifyReason').val('');
    $('#hiddenCrewId').val(id);

    $('#modalNotQualify').data('row', row);

    var modal = new bootstrap.Modal(document.getElementById('modalNotQualify'), {
        backdrop: 'static',
        keyboard: false
    });

    modal.show();
}

function submitNotQualifiedCrew() {

    const id = $('#hiddenCrewId').val();
    const reason = $('#txtNotQualifyReason').val().trim();

    if (!reason) {

        Swal.fire({
            icon: 'warning',
            title: 'Validation Required',
            text: 'Please enter the reason for Not Qualified.',
            confirmButtonColor: '#0a6ed1'
        });

        $('#txtNotQualifyReason').focus();
        return;
    }

    $("#idLoadingSpinnerNotQualify").fadeIn();

    $.ajax({
        url: '<?php echo base_url("notQualifiedCrew") ?>',
        type: 'POST',
        data: {
            id: id,
            reason: reason
        },

        success: function(response) {

            const modalEl = document.getElementById('modalNotQualify');
            const modal = bootstrap.Modal.getInstance(modalEl);

            if (modal) modal.hide();

            const row = $('#modalNotQualify').data('row');

            if (row) {
                animateRemoveRow(row[0]);
            }

            Swal.fire({
                icon: 'success',
                title: 'Evaluation Saved',
                text: 'Crew successfully marked as Not Qualified.',
                confirmButtonColor: '#0a6ed1',
                timer: 1800,
                showConfirmButton: false
            });

        },

        error: function(xhr, status, error) {

            Swal.fire({
                icon: 'error',
                title: 'System Error',
                text: 'An error occurred: ' + error,
                confirmButtonColor: '#d33'
            });

        },

        complete: function() {
            $("#idLoadingSpinnerNotQualify").fadeOut();
        }

    });

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
                onkeyup="searchTableDataQualifiedCrew(this,'DataQualifiedCrew')">
        </div>
    </div>

    <div class="sap-content">
        <div id="idLoadingSpinnerQualifiedCrew" class="sap-loading" style="display:none;">
            <svg width="56" height="56" viewBox="0 0 50 50">
                <circle cx="25" cy="25" r="20" fill="none" stroke="#2563eb" stroke-width="4" stroke-linecap="round"
                    stroke-dasharray="31.4 31.4">
                    <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="1s"
                        repeatCount="indefinite" />
                </circle>
            </svg>
            <p>Processing data…</p>
        </div>

        <div style="
            width:100%;
            max-height:700px;
            overflow:auto;
            background:white;
            border:1px solid #e5e7eb;
            border-radius:10px;
            box-shadow:0 1px 3px rgba(0,0,0,.04);
            position:relative;
        ">

            <div id="searchIndicator" style="padding:10px 10px 0 10px;"></div>

            <table class="sap-table" id="tableDataQualifiedCrew" data-page="1" data-search="" data-rows="10">

                <thead style="
                    position:sticky;
                    top:0;
                    z-index:20;
                    background:#fff;
                ">
                    <tr>
                        <th style="width:50px;">No</th>
                        <th style="min-width:240px;">Seafarer</th>
                        <th style="min-width:220px;">Applied & Existing Position</th>
                        <th style="min-width:140px;">Birth</th>
                        <th style="min-width:130px;">Phone</th>
                        <th style="min-width:140px;">Apply Vessel Type</th>
                        <th style="min-width:200px;">Experience</th>
                        <th style="width:90px;">Foreign</th>
                        <th style="width:130px;">Last Salary</th>
                        <th style="width:130px;">Expected Salary</th>
                        <th style="width:100px;">Prev Join</th>
                        <th style="width:120px;">Submit Date</th>
                        <th style="width:150px;">Action</th>
                    </tr>
                </thead>

                <tbody id="idTbodyQualifiedCrew"></tbody>

            </table>

        </div>

        <div id="pagination"></div>
    </div>
</div>

<div class="modal fade" id="modalNotQualify">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content" style="
            border:none;
            border-radius:16px;
            overflow:hidden;
            background:rgba(255,255,255,0.75);
            backdrop-filter:blur(14px);
            -webkit-backdrop-filter:blur(14px);
            box-shadow:0 20px 60px rgba(0,0,0,.25);
            animation:sapModalOpen .35s ease;
        ">


            <div style="
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:18px 22px;
            background:#0854a0;
            color:white;
            font-weight:600;
            font-size:16px;
            ">

                <div style="display:flex;align-items:center;gap:10px;">
                    <i class="fas fa-user-slash"></i>
                    <span>Not Qualified Evaluation</span>
                </div>

                <button type="button" data-bs-dismiss="modal" style="
                background:none;
                border:none;
                color:white;
                font-size:22px;
                opacity:.85;
                cursor:pointer;
                transition:.2s;
                " onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='.85'">
                    ×
                </button>

            </div>



            <div style="padding:24px">

                <div style="
                display:flex;
                gap:18px;
                padding:18px;
                border-radius:12px;
                background:rgba(255,255,255,.85);
                border:1px solid #e6eef5;
                box-shadow:0 6px 18px rgba(0,0,0,.08);
                margin-bottom:20px;
                ">

                    <div style="
                    width:46px;
                    height:46px;
                    border-radius:50%;
                    background:#e8f8f9;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    font-size:18px;
                    color:#067780;
                    ">
                        <i class="fas fa-user"></i>
                    </div>

                    <div style="flex:1">

                        <div id="modalNotQualifyName" style="
                        font-weight:600;
                        font-size:16px;
                        color:#1f2937;
                        margin-bottom:10px;
                        ">
                            -
                        </div>

                        <div style="
                        display:flex;
                        gap:30px;
                        flex-wrap:wrap;
                        font-size:13px;
                        ">

                            <div>
                                <div style="color:#6b7280;font-size:12px;">Applied Position</div>
                                <div id="modalNotQualifyPosition">-</div>
                            </div>

                            <div>
                                <div style="color:#6b7280;font-size:12px;">Applied Vessel Type</div>
                                <div id="modalNotQualifyAppliedVesselType">-</div>
                            </div>

                            <!-- <div>
                                <div style="color:#6b7280;font-size:12px;">Last Experience</div>
                                <div id="modalNotQualifyLastExperience">-</div>
                            </div> -->

                        </div>

                    </div>

                </div>


                <div>

                    <label style="
                        font-size:13px;
                        font-weight:600;
                        color:#374151;
                        margin-bottom:6px;
                        display:block;
                    ">
                        Reason for Not Qualified
                    </label>

                    <textarea id="txtNotQualifyReason" rows="4" placeholder="Provide clear evaluation notes..." style="
                    width:100%;
                    border-radius:10px;
                    border:1px solid #d1d5db;
                    padding:10px;
                    font-size:13px;
                    outline:none;
                    transition:.2s;
                    " onfocus="this.style.borderColor='#067780';this.style.boxShadow='0 0 0 3px rgba(6,119,128,.15)'"
                        onblur="this.style.borderColor='#d1d5db';this.style.boxShadow='none'"></textarea>

                    <input type="hidden" id="hiddenCrewId">

                </div>

            </div>


            <div style="
                display:flex;
                justify-content:flex-end;
                gap:10px;
                padding:16px 20px;
                border-top:1px solid #eef2f7;
                background:rgba(255,255,255,.7);
            ">

                <button type="button" data-bs-dismiss="modal" style="
                border:none;
                background:#eef2f7;
                color:#374151;
                padding:8px 16px;
                border-radius:8px;
                font-size:13px;
                font-weight:600;
                cursor:pointer;
                transition:.2s;
                " onmouseover="this.style.background='#e3e8ef'" onmouseout="this.style.background='#eef2f7'">
                    Cancel
                </button>

                <button onclick="submitNotQualifiedCrew()" style="
                border:none;
                background:#0854a0;
                color:white;
                padding:8px 18px;
                border-radius:8px;
                font-size:13px;
                font-weight:600;
                cursor:pointer;
                transition:.2s;
                box-shadow:0 4px 10px #0854a0;
                " onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 6px 14px #0854a0'"
                    onmouseout="this.style.transform='none';this.style.boxShadow='0 4px 10px #0854a0'">
                    Submit Evaluation
                </button>

            </div>


            <div id="idLoadingSpinnerNotQualify" style="
                display:none;
                position:absolute;
                top:0;
                left:0;
                width:100%;
                height:100%;
                background:rgba(255,255,255,.85);
                z-index:20;
                align-items:center;
                justify-content:center;
                flex-direction:column;
            ">

                <div style="
                width:42px;
                height:42px;
                border:3px solid #e5e7eb;
                border-top:3px solid #067780;
                border-radius:50%;
                animation:sapSpin 1s linear infinite;
                "></div>

                <p style="margin-top:12px;font-size:13px;color:#374151;font-weight:500">
                    Processing evaluation...
                </p>

            </div>

        </div>
    </div>
</div>