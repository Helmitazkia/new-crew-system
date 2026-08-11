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
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const input = document.querySelector(".sap-search input");
    if (input) {
        input.addEventListener("keyup", function() {
            searchTableDatainterview(input, 1);
        });
    }
    searchTableDatainterview(input, 1);
});

function searchTableDatainterview(input, page = 1) {
    const searchValue = input ? input.value : "";
    loadDataInterviewCrew(page, searchValue);
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

function loadDataInterviewCrew(page = 1, searchValue = "") {
    const table = document.getElementById("tableDataInterviewCrew");
    if (table) table.dataset.page = page;

    const search = searchValue !== undefined ? searchValue : ($("#searchInterviewCrew").val() || "");


    const rows = table?.dataset.rows ? parseInt(table.dataset.rows) : 10;

    $.ajax({
        url: '<?php echo base_url("searchDataInterview"); ?>',
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
                $("#idTbodyInterviewCrew").html(`
                    <tr>
                        <td colspan="11" style="text-align:center;padding:20px;color:#adb5bd;">
                            No data found
                        </td>
                    </tr>
                `);

                renderPagination(currentPage, res.pagination.total_pages, search, res.pagination.total_rows,
                    rowsPerPage);
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
                            text-align:left;
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
                        <button style="border:1px solid #dee2e6;background:#fff;font-size:12px;padding:5px;border-radius:4px;cursor:pointer;" onclick="window.open('${row.cv_url}','_blank')">📄 View CV</button>
                        <button style="background:#e6fcf5;border:1px solid #20c997;color:#087f5b;font-size:12px;padding:5px;border-radius:4px;cursor:pointer;" onclick="passInterview('${row.id}')">✔ Qualified</button>
                        <button style="background:#fff5f5;border:1px solid #ffa8a8;color:#c92a2a;font-size:12px;padding:5px;border-radius:4px;cursor:pointer;" onclick="notQualifyInterview('${row.id}','<b><i>:: ${row.fullname} ::</i></b>')">✖ Not Qualified</button>
                    </div>`;

                html += `
                <tr id="row_${row.id}" style="border-bottom:1px solid #eef1f5; transition: background 0.3s ease;">
                    <td style="text-align:center;font-size:12px;color:#868e96;vertical-align:top;">${no++}</td>
                    <td style="vertical-align:top;">
                        <div style="font-weight:600;font-size:14px;color:#1f2d3d;">${fullname}</div>
                        <div style="font-size:12px;color:#868e96;margin-top:2px;">${email}</div>
                    </td>
                    <td style="vertical-align:top;">
                        <div style="font-size:13px;font-weight:600;color:#34495e;">${position}</div>
                        <div style="font-size:12px;
                        color:#7f8c8d;
                        white-space:normal;
                        word-break:break-word;">${ijazah}</div>
                    </td>
                    <td style="color:#495057;vertical-align:top;">
                        <div>${row.born_place}</div>
                        <div style="color:#868e96;">${row.born_date}</div>
                    </td>
                    <td style=" vertical-align:top;">${row.handphone}</td>
                    <td style="vertical-align:top;">
                        <div style="font-size:12px;
                        color:#7f8c8d;
                        white-space:normal;
                        word-break:break-word;">${vesselType}</div>
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
                    <td style="font-size:12px;text-align:right;font-weight:600;color:#065f46;vertical-align:top;">
                        ${formatSalary(
                            row.last_salary,
                            row.last_salary_currency,
                            search
                        )}
                    </td>
                    <td style="font-size:12px;text-align:right;font-weight:600;color:#065f46;vertical-align:top;">
                        ${formatSalary(
                            row.expected_salary,
                            row.expected_salary_currency,
                            search
                        )}
                    </td>
                    <td style="font-size:12px;text-align:center;vertical-align:top;">${row.join_inAndhika}</td>
                    <td style="font-size:12px;color:#868e96;vertical-align:top;">${row.submit_cv}</td>
                    <td style="text-align:center;min-width:120px;vertical-align:top;">${btnAct}</td>
                </tr>`;
            });

            $("#idTbodyInterviewCrew").html(html);
            renderPagination(currentPage, res.pagination.total_pages, search, res.pagination.total_rows,
                rowsPerPage);
        }
    });
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
            <select onchange="changeRowsPerPageInterview(this.value,'${searchValue}')" 
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
        html += `<button style="${btnStyle}" onclick="goToPageInterview(${currentPage-1},'${searchValue}')">‹</button>`;
    else
        html += `<button disabled style="${disabledStyle}">‹</button>`;

    for (let i = start; i <= end; i++) {
        html += `<button style="${i===currentPage?activeStyle:btnStyle}" 
            onclick="goToPageInterview(${i},'${searchValue}')">${i}</button>`;
    }

    if (end < totalPages) {
        if (end < totalPages - 1)
            html += `<span style="padding:0 4px;color:#98a2b3;font-weight:600;">...</span>`;

        html += `<button style="${btnStyle}" 
            onclick="goToPageInterview(${totalPages},'${searchValue}')">${totalPages}</button>`;
    }

    if (currentPage < totalPages)
        html += `<button style="${btnStyle}" onclick="goToPageInterview(${currentPage+1},'${searchValue}')">›</button>`;
    else
        html += `<button disabled style="${disabledStyle}">›</button>`;


    html += `<div style="display:flex;align-items:center;gap:5px;margin-left:8px;">
        Go :
        <input type="number" min="1" max="${totalPages}" id="jumpPageInputInterview" placeholder="Page" value="${currentPage}"
            style="width:55px;border:1px solid #d0d7de;border-radius:6px;padding:3px 6px;font-size:12px;">
        <button style="${btnStyle}" onclick="jumpToPageInterview('${searchValue}')">OK</button>
    </div>`;

    html += `</div></div>`;

    pagination.innerHTML = html;
}

function goToPageInterview(page, searchValue) {
    loadDataInterviewCrew(page, searchValue);
}

function jumpToPageInterview(searchValue) {
    const input = document.getElementById("jumpPageInputInterview");
    if (!input) return;

    let page = parseInt(input.value);
    if (!page || page < 1) return;

    loadDataInterviewCrew(page, searchValue);
}

function changeRowsPerPageInterview(val, searchValue) {
    const table = document.getElementById("tableDataInterviewCrew");
    if (table) table.dataset.rows = val;

    loadDataInterviewCrew(1, searchValue);
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
                onkeyup="searchTableDatainterview(this,'Datainterview')">
        </div>
    </div>

    <div class="sap-content">
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
                    <animateTransform attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="0.9s"
                        repeatCount="indefinite" />
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
        <div class="sap-table-wrapper">
            <div id="searchIndicator"></div>
            <table class="sap-table" id="tableDataInterviewCrew" data-page="1" data-search="">
                <thead>
                    <tr>
                        <th style="width:4%;">No</th>
                        <th style="width:15%;">Seafarer</th>
                        <th style="width:12%;">Position Applied & Certificate</th>
                        <th style="width:8%;">Birth</th>
                        <th style="width:8%;">Phone</th>
                        <th style="width:8%;">Apply Vessel Type</th>
                        <th style="width:14%;">Experience</th>
                        <th style="width:10%;">Foreign</th>
                        <th style="width:7%;">Last Salary</th>
                        <th style="width:7%;">Expected Salary</th>
                        <th style="width:5%;">Prev Join</th>
                        <th style="width:7%;">Submit Date</th>
                        <th style="width:10%;">Action</th>
                    </tr>
                </thead>

                <tbody id="idTbodyInterviewCrew"></tbody>
            </table>
        </div>

        <div id="pagination" class="mt-3"></div>
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