<style>
:root {
    --primary: #1e3a8a;
    --primary-soft: #e0e7ff;
    --border: #e5e7eb;
    --text-main: #0f172a;
    --text-muted: #64748b;
    --bg-soft: #f8fafc;
}

/* CARD */
.card-enterprise {
    background: #fff;
    border: 1px solid var(--border);
    border-radius: 18px;
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
}

/* HEADER */
.section-header {
    font-size: 15px;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: 18px;
}

/* INPUT */
.input-enterprise {
    padding: 11px 14px;
    font-size: 13px;
    border-radius: 12px;
    border: 1px solid var(--border);
    background: #fff;
}

.input-enterprise:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.12);
}

/* TABLE */
.table-enterprise {
    font-size: 13px;
    margin-bottom: 0;
}

.table-enterprise thead th {
    background: var(--primary);
    color: #fff;
    font-weight: 600;
    position: sticky;
    top: 0;
    z-index: 2;
}

.table-enterprise tbody tr:hover {
    background: #f1f5f9;
}

/* CERT LIST */
.cert-box {
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 12px;
    max-height: 220px;
    overflow-y: auto;
}

/* BUTTON */
.btn-primary-enterprise {
    background: linear-gradient(135deg, #2563eb, #1e40af);
    border: none;
    color: #fff;
    font-weight: 700;
    font-size: 13px;
    border-radius: 14px;
    padding: 12px 0;
    box-shadow: 0 8px 18px rgba(37, 99, 235, 0.35);
}

.btn-secondary-enterprise {
    background: #f1f5f9;
    border: 1px solid var(--border);
    color: var(--text-muted);
    font-weight: 700;
    font-size: 13px;
    border-radius: 14px;
    padding: 12px 0;
}
</style>


<script type="text/javascript">
let CURRENT_EDIT_CERT_ID = null;
$(document).ready(function() {});

$(document).ready(function() {
    loadCertificateMatrix();
});


let LAST_CERT_DATA = [];

function loadCertificateMatrix() {
    $.getJSON(
        "<?php echo base_url('getCertMatrix'); ?>",
        function(res) {
            if (res.status) {

                renderRankOption(res.rankOption);

                LAST_CERT_DATA = res.certificateOption;
                renderCertificateOption(res.certificateOption);

                renderCertificateMatrix(res.data);
            }
        }
    );
}


function initCertificateMultiselect() {
    $('#slcCertificate').multiselect({
        includeSelectAllOption: true,
        enableFiltering: true,
        buttonWidth: '100%',
        nonSelectedText: 'Pilih Sertifikat',
        numberDisplayed: 1,
        templates: {
            ul: '<ul class="multiselect-container dropdown-menu" style="max-height:200px;overflow-y:auto;"></ul>',
            filter: `
                <li class="multiselect-item multiselect-filter"
                    style="position:sticky;top:0;background:#fff;z-index:10;
                           padding:5px;border-bottom:1px solid #ddd;">
                    <div class="input-group">
                        <input class="form-control multiselect-search" type="text">
                    </div>
                </li>`
        }
    });
}

function renderRankOption(data) {

    let html = '<option value="">-- Select Rank --</option>';

    $.each(data, function(i, v) {
        html += `<option value="${v.id}">${v.name}</option>`;
    });

    $("#slcRank").html(html);
}


function renderCertificateOption(data) {

    let html = '';

    if (!data || data.length === 0) {
        $('#certificateContainer').html('<div class="text-muted">No certificate found</div>');
        return;
    }

    $.each(data, function(i, v) {

        html += `
            <label class="cert-item"
                   data-label="${v.label.toLowerCase()}"
                   style="
                       display:flex;
                       align-items:center;
                       gap:8px;
                       padding:6px 4px;
                       font-size:13px;
                       cursor:pointer;
                   ">
                <input type="checkbox"
                       class="chkCertificate"
                       value="${v.id}">
                <span>${v.label}</span>
            </label>
        `;
    });

    $('#certificateContainer').html(html);
}

if (CURRENT_EDIT_CERT_ID) {

    $(".cert-item").hide();
    $(".chkCertificate").prop("checked", false);

    let $target = $(".chkCertificate[value='" + CURRENT_EDIT_CERT_ID + "']");

    if ($target.length) {
        $target.prop("checked", true);
        $target.closest(".cert-item").show();
    }

}

function resetEditMode() {
    CURRENT_EDIT_CERT_ID = null;
    $("#txtIdEdit").val('');
    $("#slcRank").val('');
    $("#txtSearchCertificate").val('');
    $(".cert-item").show();
}


function getSelectedCertificates() {

    let certs = [];

    $('.chkCertificate:checked').each(function() {
        certs.push($(this).val());
    });

    return certs;
}


function renderCertificateMatrix(data) {

    let html = '';

    if (!data || Object.keys(data).length === 0) {
        $('#idTbodyCertMatrix').html(
            '<tr><td colspan="3" class="text-center">No data</td></tr>'
        );
        return;
    }

    Object.keys(data).forEach(rank => {

        const certs = data[rank];
        let firstRank = true;

        certs.forEach(row => {

            html += '<tr>';

            if (firstRank) {
                html += `<td rowspan="${certs.length}" style="font-weight:600;">${rank}</td>`;
                firstRank = false;
            }

            html += `<td>- ${row.certificate_name}</td>`;

            html += `
                <td class="text-center">
                    <button class="btn btn-success btn-xs"
                        onclick="getDataEdit('${row.id}','certificateMatrix')">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-xs"
                        onclick="delData('${row.id}','certificateMatrix')">
                        <i class="fa fa-close"></i>
                    </button>
                </td>
            `;

            html += '</tr>';
        });
    });

    $('#idTbodyCertMatrix').html(html);
}

$(document).ready(function() {

    var typingTimer = null;
    var delay = 400;

    $('#txtSearchCertificateMatrix').on('keyup', function() {

        var keyword = $(this).val().trim();

        if (typingTimer) {
            clearTimeout(typingTimer);
        }

        typingTimer = setTimeout(function() {

            $("#idLoading").show();

            $.ajax({
                url: "<?php echo base_url('getCertMatrix'); ?>",
                type: "POST",
                dataType: "json",
                data: {
                    txtSearch: keyword
                },
                success: function(res) {
                    if (res.status) {
                        renderCertificateMatrix(res.data);
                    }
                    $("#idLoading").hide();
                }
            });

        }, delay);
    });
});

$(document).on('input', '#txtSearchCertificate', function() {

    let keyword = $(this).val().toLowerCase().trim();

    $('.cert-item').each(function() {

        let label = $(this).data('label');

        if (!keyword || label.includes(keyword)) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
});

function saveData() {

    let idEdit = $("#txtIdEdit").val();
    let rankCode = $("#slcRank").val();
    let rankName = $('#slcRank option:selected').text();

    let certificates = [];
    $('.chkCertificate:checked').each(function() {
        certificates.push($(this).next('span').text().trim());
    });

    if (!rankCode) {
        Swal.fire("Warning", "Please select Rank!", "warning");
        return;
    }

    if (certificates.length === 0) {
        Swal.fire("Warning", "Please select Certificate!", "warning");
        return;
    }

    let formData = new FormData();
    formData.append('idEdit', idEdit);
    formData.append('rankCode', rankCode);
    formData.append('rankName', rankName);

    certificates.forEach(cert => {
        formData.append('certificates[]', cert);
    });

    Swal.fire({
        title: "Confirm Save",
        text: "Are you sure you want to save this data?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Save",
        cancelButtonText: "Cancel"
    }).then((result) => {

        if (!result.isConfirmed) return;

        $("#idLoading").show();

        $.ajax({
            url: "<?php echo base_url('saveCertMatrix'); ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(res) {

                $("#idLoading").hide();

                if (res.status) {
                    Swal.fire("Success", res.message, "success")
                        .then(() => {
                            resetEditMode();
                            loadCertificateMatrix();
                        });
                } else {
                    Swal.fire("Error", res.message, "error");
                }
            },
            error: function() {
                $("#idLoading").hide();
                Swal.fire("Error", "Server error, please try again", "error");
            }
        });
    });
}

function normalizeText(str) {
    return str
        .toLowerCase()
        .replace(/\s+/g, ' ')
        .replace(/[^\w\s]/g, '')
        .trim();
}

function setRankSelect(rankId, rankName) {

    if ($("#slcRank option[value='" + rankId + "']").length) {
        $("#slcRank").val(rankId);
        return;
    }

    let found = false;

    $("#slcRank option").each(function() {
        let optText = $(this).text().trim().toLowerCase();
        let dbText = rankName.trim().toLowerCase();

        if (optText === dbText) {
            $(this).prop("selected", true);
            found = true;
        }
    });

    if (!found) {
        console.warn("Rank tidak ketemu:", rankId, rankName);
    }
}

function getDataEdit(id, type) {

    $("#idLoading").show();

    $.post(
        "<?php echo base_url('editCertMatrix'); ?>", {
            idEdit: id,
            type: type
        },
        function(res) {

            if (!res.status || !res.data) {
                alert('Data tidak ditemukan');
                $("#idLoading").hide();
                return;
            }

            const data = res.data;

            $("#txtIdEdit").val(data.id);
            setRankSelect(data.rank_id, data.rank_name);


            $(".chkCertificate").prop("checked", false);
            $(".cert-item").hide();

            const certFromDB = normalizeText(data.certificate_name);

            let found = false;

            $(".cert-item").each(function() {

                const labelText = normalizeText(
                    $(this).find("span").text()
                );

                if (labelText.includes(certFromDB) || certFromDB.includes(labelText)) {
                    $(this).show();
                    $(this).find(".chkCertificate").prop("checked", true);
                    found = true;
                }
            });

            if (!found) {
                console.warn("Certificate tidak ketemu di list:", data.certificate_name);
                $(".cert-item").show();
            }

            $("#txtSearchCertificate").val('');
            $("#idLoading").hide();
        },
        "json"
    );
}

function delData(id, type) {

    Swal.fire({
        title: 'Delete data?',
        text: 'Data yang dihapus tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete!',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (result.isConfirmed) {

            $("#idLoading").show();

            $.post(
                '<?php echo base_url("delCertMatrix"); ?>/', {
                    type: type,
                    idDel: id
                },
                function(res) {

                    $("#idLoading").hide();

                    if (res.status) {
                        Swal.fire(
                            'Deleted!',
                            res.message,
                            'success'
                        ).then(() => {
                            reloadPage();
                        });
                    } else {
                        Swal.fire(
                            'Failed!',
                            res.message,
                            'error'
                        );
                    }
                },
                "json"
            );
        }
    });
}
</script>

<div class="row mb-4">
    <div class="col-md-3 col-xs-12">
        <input type="text" id="txtSearchCertificateMatrix" class="form-control input-enterprise"
            placeholder="🔍 Search rank or vessel...">
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-xs-12">
        <div class="card-enterprise" style="max-height:540px;overflow:auto;">
            <table class="table table-bordered table-hover table-enterprise">
                <thead>
                    <tr>
                        <th style="width:20%;">Rank</th>
                        <th style="width:40%;text-align:center;">Certificate</th>
                        <th style="width:40%;text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody id="idTbodyCertMatrix">
                    <!-- ajax -->
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-4 col-xs-12">
        <div class="card-enterprise" style="padding:28px;min-height:540px;">

            <div class="section-header">
                Certificate Matrix Form
            </div>

            <!-- RANK -->
            <label class="text-muted" style="font-size:13px;font-weight:600;">Rank</label>
            <select id="slcRank" class="form-control input-enterprise mb-4">
                <option value="">-- Select Rank --</option>
            </select>

            <!-- CERTIFICATE -->
            <label class="text-muted" style="font-size:13px;font-weight:600;">Certificate</label>

            <input type="text" id="txtSearchCertificate" class="form-control input-enterprise mb-2"
                placeholder="🔍 Search certificate...">

            <div id="certificateContainer" class="cert-box mb-4"></div>

            <input type="hidden" id="txtIdEdit">

            <!-- BUTTON -->
            <div class="row mt-4">
                <div class="col-md-6 col-xs-12 mb-2">
                    <button onclick="saveData()" class="btn btn-primary-enterprise w-100">
                        Save
                    </button>
                </div>
                <div class="col-md-6 col-xs-12 mb-2">
                    <button onclick="resetEditMode()" class="btn btn-secondary-enterprise w-100">
                        Reset
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>