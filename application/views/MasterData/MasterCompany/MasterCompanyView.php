<script type="text/javascript">
$(document).ready(function() {});

$(document).ready(function() {

    loadCompany();

});

function loadCompany(keyword = '') {

    let ajaxOpt = {
        url: "<?php echo base_url('company/json'); ?>",
        dataType: "json",
        success: function(res) {
            if (res.status) {
                renderCompanyTable(res.data);
            }
        }
    };

    if (keyword !== '') {
        ajaxOpt.type = "POST";
        ajaxOpt.data = {
            txtSearch: keyword
        };
    } else {
        ajaxOpt.type = "GET";
    }

    $.ajax(ajaxOpt);
}

function renderCompanyTable(data) {

    let html = '';

    if (data.length === 0) {
        html = `
            <tr>
                <td colspan="5" class="text-center">
                    No data found
                </td>
            </tr>`;
        $('#idTbodyCompany').html(html);
        return;
    }

    for (let i = 0; i < data.length; i++) {

        html += '<tr>';
        html += ' <td style="font-size:11px;text-align:center;">' + data[i].no + '</td>';
        html += ' <td style="font-size:11px;">' + data[i].company + '</td>';
        html += ' <td style="font-size:11px;">' + data[i].definition + '</td>';
        html += ' <td style="font-size:11px;text-align:center;">' + data[i].reportType + '</td>';
        html += ' <td style="font-size:11px;text-align:center;">';
        html += '   <button class="btn btn-success btn-xs" ';
        html += '     onclick="getDataEdit(\'' + data[i].id + '\',\'company\')">';
        html += '     <i class="fa fa-edit"></i>';
        html += '   </button> ';
        html += '   <button class="btn btn-danger btn-xs" ';
        html += '     onclick="delData(\'' + data[i].id + '\',\'company\')">';
        html += '     <i class="fa fa-trash"></i>';
        html += '   </button>';
        html += ' </td>';
        html += '</tr>';
    }

    $('#idTbodyCompany').html(html);
}

$(document).ready(function() {

    let typingTimer;
    let delay = 400;

    $('#txtSearchCompany').on('keyup', function() {

        let keyword = $(this).val().trim();

        clearTimeout(typingTimer);

        typingTimer = setTimeout(function() {

            if (keyword === '') {
                loadCompany();
                return;
            }

            $("#idLoading").show();

            loadCompany(keyword);

            $("#idLoading").hide();

        }, delay);

    });

});


function saveData() {

    let idEdit = $("#txtIdEdit").val();
    let txtCompanyName = $("#txtCompanyName").val().trim();
    let txtDefinitionCom = $("#txtDefinitionCom").val();
    let slcReportType = $("#slcReportType").val();

    if (txtCompanyName === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Validation',
            text: 'Company Name cannot be empty'
        }).then(() => {
            $("#txtCompanyName").focus();
        });
        return;
    }

    let formData = new FormData();
    formData.append('idEdit', idEdit);
    formData.append('txtCompanyName', txtCompanyName);
    formData.append('txtDefinitionCom', txtDefinitionCom);
    formData.append('slcReportType', slcReportType);

    $("#idLoading").show();

    $.ajax({
        url: "<?php echo base_url('company/save'); ?>",
        method: "POST",
        data: formData,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function(res) {

            $("#idLoading").hide();

            if (res.status) {

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    reloadPage();
                });

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: res.message
                });
            }
        },
        error: function() {
            $("#idLoading").hide();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Server error, please try again'
            });
        }
    });
}


function getDataEdit(id, type) {

    $("#idLoading").show();

    $.post(
        "<?php echo base_url('company/get-edit'); ?>", {
            idEdit: id,
            type: type
        },
        function(res) {

            if (!res.status || res.data === null) {
                alert('Data not found');
                $("#idLoading").hide();
                return;
            }


            if (type === 'company') {
                $("#txtIdEdit").val(res.data.kdcmp);
                $("#txtCompanyName").val(res.data.nmcmp);
                $("#txtDefinitionCom").val(res.data.desccmp);
                $("#slcReportType").val(res.data.cvtype);
            }

            $("#idLoading").hide();

        },
        "json"
    );
}


function delData(id, type) {

    Swal.fire({
        title: 'Delete data?',
        text: 'This data will be deleted',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (result.isConfirmed) {

            $("#idLoading").show();

            $.post(
                "<?php echo base_url('company/delete'); ?>", {
                    idDel: id,
                    type: type
                },
                function(res) {

                    $("#idLoading").hide();

                    if (res.status) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: res.message,
                            timer: 1200,
                            showConfirmButton: false
                        }).then(() => {
                            reloadPage();
                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: res.message
                        });
                    }
                },
                "json"
            );
        }
    });
}


function reloadPage() {
    try {
        if (parent && typeof parent.buttonMenuMaster === 'function') {
            parent.buttonMenuMaster('city');
        } else {
            location.reload();
        }
    } catch (e) {
        location.reload();
    }
}
</script>

<!-- SEARCH -->
<div class="row" style="margin:18px 0;">
    <div class="col-md-3 col-xs-12">
        <input type="text" id="txtSearchCompany" placeholder="🔍 Search company..." class="form-control input-sm" style="
                padding:10px 14px;
                border-radius:12px;
                border:1px solid #d0d7de;
                font-size:13px;
                box-shadow:0 2px 6px rgba(0,0,0,0.06);
            ">
    </div>
</div>

<div class="row">

    <!-- TABLE -->
    <div class="col-md-8 col-xs-12">
        <div style="
            max-height:520px;
            overflow-y:auto;
            background:#fff;
            border-radius:14px;
            border:1px solid #e3e6ea;
            box-shadow:0 4px 14px rgba(0,0,0,0.06);
        ">

            <table class="table table-bordered table-hover table-condensed" style="margin-bottom:0;font-size:13px;">
                <thead>
                    <tr style="
                        background:#f1f4f7;
                        position:sticky;
                        top:0;
                        z-index:2;
                        border-bottom:1px solid #d9dee3;
                    ">
                        <th style="width:6%;text-align:center;background:#000099;color:#fff;">
                            No
                        </th>
                        <th style="width:34%;background:#000099;color:#fff;">
                            Company Name
                        </th>
                        <th style="width:30%;background:#000099;color:#fff;">
                            Definition
                        </th>
                        <th style="width:20%;text-align:center;background:#000099;color:#fff;">
                            Report Type
                        </th>
                        <th style="width:10%;text-align:center;background:#000099;color:#fff;">
                            Action
                        </th>
                    </tr>
                </thead>

                <tbody id="idTbodyCompany">
                    <!-- ajax -->
                </tbody>
            </table>

        </div>
    </div>

    <!-- FORM -->
    <div class="col-md-4 col-xs-12">
        <div style="
            background:#ffffff;
            padding:26px;
            min-height:520px;
            border-radius:16px;
            border:1px solid #e3e6ea;
            box-shadow:0 6px 20px rgba(0,0,0,0.08);
        ">

            <div style="
                font-weight:700;
                font-size:16px;
                margin-bottom:28px;
                color:#1f2d3d;
            ">
                Company Form
            </div>

            <!-- COMPANY NAME -->
            <div style="margin-bottom:20px;">
                <label style="
                    font-weight:600;
                    font-size:13px;
                    color:#475569;
                    margin-bottom:8px;
                    display:block;
                ">
                    Company Name
                </label>

                <input type="text" id="txtCompanyName" placeholder="Type company name" class="form-control input-sm"
                    style="
                        padding:12px 14px;
                        border-radius:12px;
                        border:1px solid #cbd5e1;
                        font-size:13px;
                        box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
                    ">
            </div>

            <!-- DEFINITION -->
            <div style="margin-bottom:20px;">
                <label style="
                    font-weight:600;
                    font-size:13px;
                    color:#475569;
                    margin-bottom:8px;
                    display:block;
                ">
                    Definition
                </label>

                <input type="text" id="txtDefinitionCom" placeholder="Definition" class="form-control input-sm" style="
                        padding:12px 14px;
                        border-radius:12px;
                        border:1px solid #cbd5e1;
                        font-size:13px;
                        box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
                    ">
            </div>

            <!-- REPORT TYPE -->
            <div style="margin-bottom:30px;">
                <label style="
                    font-weight:600;
                    font-size:13px;
                    color:#475569;
                    margin-bottom:8px;
                    display:block;
                ">
                    Report Type
                </label>

                <select id="slcReportType" class="form-control input-sm" style="
                        padding:12px 14px;
                        border-radius:12px;
                        border:1px solid #cbd5e1;
                        font-size:13px;
                    ">
                    <option value="OTHERFORM">OTHER FORM</option>
                    <option value="ADNYANA">ADNYANA</option>
                    <option value="OSM">OSM</option>
                    <option value="PELICAN">PELICAN</option>
                    <option value="SAMPTA">SAMTA</option>
                    <option value="STELLAR">STELLAR</option>
                    <option value="SUNTECHNO">SUNTECHNO</option>
                    <option value="SUNTECHNO KOREA">SUNTECHNO KOREA</option>
                    <option value="TITAN">TITAN</option>
                    <option value="VSHIPS">VSHIPS</option>
                </select>
            </div>

            <input type="hidden" id="txtIdEdit">

            <!-- ACTION BUTTON -->
            <div class="row" style="margin-top:40px;">
                <div class="col-md-6 col-xs-12">
                    <button onclick="saveData();" style="
                        width:100%;
                        padding:12px 0;
                        background:linear-gradient(135deg,#2563eb,#1d4ed8);
                        color:#fff;
                        border:none;
                        border-radius:14px;
                        font-weight:700;
                        font-size:13px;
                        box-shadow:0 6px 14px rgba(37,99,235,0.4);
                        cursor:pointer;
                    ">
                        Save
                    </button>
                </div>

                <div class="col-md-6 col-xs-12">
                    <button onclick="reloadPage();" style="
                        width:100%;
                        padding:12px 0;
                        background:#f1f5f9;
                        color:#475569;
                        border:1px solid #cbd5e1;
                        border-radius:14px;
                        font-weight:700;
                        font-size:13px;
                        cursor:pointer;
                    ">
                        Cancel
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>