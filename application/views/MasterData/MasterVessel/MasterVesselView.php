<script type="text/javascript">
$(document).ready(function() {});

$(document).ready(function() {
    loadVessel();
});

function loadVessel() {
    $.ajax({
        url: "<?php echo base_url('vessel/json'); ?>",
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (res.status) {
                renderVesselTable(res.data);
                renderVesselType(res.vesselType);
                renderCompany(res.companyList);
            }
        }
    });
}



function renderVesselTable(data) {

    var html = '';

    if (data.length === 0) {
        html = '<tr><td colspan="9" class="text-center">No data found</td></tr>';
        $('#idTbodyVessel').html(html);
        return;
    }

    for (var i = 0; i < data.length; i++) {

        let displayIcon = data[i].isDisplay ?
            '<i class="fa fa-check text-success"></i>' :
            '';

        let mailInfo = data[i].email ?
            '<br><small>' + data[i].email + '</small>' :
            '';

        let btnAct =
            '<button class="btn btn-success btn-xs" ' +
            'onclick="getDataEdit(\'' + data[i].id + '\',\'vessel\')">' +
            '<i class="fa fa-edit"></i></button> ' +
            '<button class="btn btn-danger btn-xs" ' +
            'onclick="delData(\'' + data[i].id + '\',\'vessel\')">' +
            '<i class="fa fa-close"></i></button>';

        html += '<tr>';
        html += '<td style="font-size:11px;text-align:center;">' + data[i].no + '</td>';
        html += '<td style="font-size:11px;text-align:center;">' + displayIcon + '</td>';
        html += '<td style="font-size:11px;">' + data[i].name + mailInfo + '</td>';
        html += '<td style="font-size:11px;">' + data[i].imo + '</td>';
        html += '<td style="font-size:11px;">' + data[i].grt + '</td>';
        html += '<td style="font-size:11px;">' + data[i].serpel + '</td>';
        html += '<td style="font-size:11px;">' + data[i].desc + '</td>';
        html += '<td style="font-size:11px;">' + data[i].company + '</td>';
        html += '<td style="font-size:11px;text-align:center;">' + btnAct + '</td>';
        html += '</tr>';
    }

    $('#idTbodyVessel').html(html);
}

function renderVesselType(data) {

    let html = '<option value="">Select Vessel Type</option>';

    for (let i = 0; i < data.length; i++) {
        html += '<option value="' + data[i] + '">' + data[i] + '</option>';
    }

    $("#slcDefinition").html(html);
}

function renderCompany(data) {

    let html = '<option value="">Select Company</option>';

    for (let i = 0; i < data.length; i++) {
        html += '<option value="' + data[i].id + '">' +
            data[i].name +
            '</option>';
    }

    $("#slcCompany").html(html);
}


$(document).ready(function() {

    var typingTimer = null;
    var delay = 400;

    $('#txtSearch').on('keyup', function() {

        var keyword = $(this).val().trim();

        if (typingTimer) clearTimeout(typingTimer);

        typingTimer = setTimeout(function() {

            if (keyword === '') {
                loadVessel();
                return;
            }

            $("#idLoading").show();

            $.post(
                "<?php echo base_url('vessel/json'); ?>", {
                    txtSearch: keyword
                },
                function(res) {
                    if (res.status) {
                        renderVesselTable(res.data);
                    }
                    $("#idLoading").hide();
                },
                "json"
            );

        }, delay);
    });
});


function saveData() {

    var formData = new FormData();

    var idEdit = $("#txtIdEdit").val();
    var txtVesselName = $("#txtVesselName").val();

    if (txtVesselName == "") {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Vessel Name tidak boleh kosong'
        });
        $("#txtVesselName").focus();
        return false;
    }

    formData.append('idEdit', idEdit);
    formData.append('txtVesselName', txtVesselName);
    formData.append('slcDefinition', $("#slcDefinition").val());
    formData.append('slcCompany', $("#slcCompany").val());
    formData.append('slcCompanyName', $("#slcCompany option:selected").text());
    formData.append('slcStsDisplay', $("#slcStsDisplay").val());
    formData.append('txtIMO', $("#txtIMO").val());
    formData.append('txtGRT', $("#txtGRT").val());
    formData.append('txtSerpel', $("#txtSerpel").val());
    formData.append('txtLoa', $("#txtLoa").val());
    formData.append('slcOwn', $("#slcOwn").val());
    formData.append('osName', $("#txtOsName").val());
    formData.append('osMail', $("#txtOsMail").val());
    formData.append('txtMailVessel', $("#txtMailVessel").val());

    $("#idLoading").show();

    $.ajax({
        url: "<?php echo base_url('vessel/save'); ?>",
        type: "POST",
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
                    text: res.message
                }).then(function() {
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
                text: 'Terjadi kesalahan saat menyimpan data'
            });
        }
    });
}


function getDataEdit(id, type) {

    $("#idLoading").show();

    $.post(
            "<?php echo base_url('vessel/get-edit'); ?>", {
                idEdit: id,
                type: type
            },
            function(res) {

                if (!res.status || !res.data) {
                    alert("Data not found");
                    $("#idLoading").hide();
                    return;
                }

                let d = res.data;

                $("#txtIdEdit").val(d.kdvsl);
                $("#txtVesselName").val(d.nmvsl);
                $("#slcDefinition").val(d.descvsl);
                $("#slcStsDisplay").val(d.st_display);
                $("#slcCompany").val(d.kdcmp);
                $("#txtIMO").val(d.imo);
                $("#txtGRT").val(d.grt);
                $("#txtSerpel").val(d.serpel);
                $("#txtLoa").val(d.loa);
                $("#slcOwn").val(d.st_own);
                $("#txtOsName").val(d.os_name);
                $("#txtOsMail").val(d.os_mail);
                $("#txtMailVessel").val(d.mail_vessel);

                $("#idLoading").hide();

            },
            "json"
        )
        .fail(function() {
            $("#idLoading").hide();
            alert("Server error");
        });
}


function delData(id, type) {

    Swal.fire({
        title: 'Delete Data?',
        text: 'Data yang dihapus tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        confirmButtonColor: '#dc2626'
    }).then((result) => {

        if (result.isConfirmed) {

            $("#idLoading").show();

            $.ajax({
                url: '<?php echo base_url("vessel/delete"); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    idDel: id,
                    type: type
                },
                success: function(res) {

                    $("#idLoading").hide();

                    if (res.status === true) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        setTimeout(function() {
                            reloadPage();
                        }, 1500);

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Failed!',
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

<div class="row" style="margin:18px 0;">
    <div class="col-md-3 col-xs-12">
        <input type="text" id="txtSearch" placeholder="🔍 Search vessel..." class="form-control input-sm" style="
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
            height:750px;
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
                        <th style="width:5%;text-align:center;background:#000099;color:#fff;" colspan="2">No</th>
                        <th style="background:#000099;color:#fff;">Vessel Name</th>
                        <th style="background:#000099;color:#fff;">IMO</th>
                        <th style="background:#000099;color:#fff;">GRT</th>
                        <th style="background:#000099;color:#fff;">Serpel</th>
                        <th style="background:#000099;color:#fff;">Definition</th>
                        <th style="background:#000099;color:#fff;">Company</th>
                        <th style="background:#000099;color:#fff;text-align:center;">Action</th>
                    </tr>
                </thead>

                <tbody id="idTbodyVessel">
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
            margin-bottom:24px;
            color:#1f2d3d;
        ">
                Vessel Form
            </div>

            <!-- Vessel Name -->
            <div class="form-group">
                <label class="lbl">Vessel Name</label>
                <input type="text" id="txtVesselName" class="form-control input-sm vessel-input">
            </div>

            <!-- Definition -->
            <div class="form-group">
                <label class="lbl">Definition</label>
                <select id="slcDefinition" class="form-control input-sm vessel-input">
                    <?php echo $getCrewVesselType; ?>
                </select>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label class="lbl">Status Display</label>
                <select id="slcStsDisplay" class="form-control input-sm vessel-input">
                    <option value="Y">YES</option>
                    <option value="N">NO</option>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label class="lbl">IMO</label>
                    <input type="text" id="txtIMO" class="form-control input-sm vessel-input">
                </div>
                <div class="col-md-6">
                    <label class="lbl">GRT</label>
                    <input type="text" id="txtGRT" class="form-control input-sm vessel-input">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label class="lbl">Serpel</label>
                    <input type="text" id="txtSerpel" class="form-control input-sm vessel-input">
                </div>
                <div class="col-md-6">
                    <label class="lbl">LOA</label>
                    <input type="text" id="txtLoa" class="form-control input-sm vessel-input">
                </div>
            </div>

            <!-- Company -->
            <div class="form-group">
                <label class="lbl">Company</label>
                <select id="slcCompany" class="form-control input-sm vessel-input">
                    <?php echo $optCompany; ?>
                </select>
            </div>

            <!-- Ship Own -->
            <div class="form-group">
                <label class="lbl">Ship Own</label>
                <select id="slcOwn" class="form-control input-sm vessel-input">
                    <option value="Y">Y</option>
                    <option value="N">N</option>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label class="lbl">OS Name</label>
                    <input type="text" id="txtOsName" class="form-control input-sm vessel-input">
                </div>
                <div class="col-md-6">
                    <label class="lbl">OS Email</label>
                    <input type="text" id="txtOsMail" class="form-control input-sm vessel-input">
                </div>
            </div>

            <div class="form-group">
                <label class="lbl">Email Vessel</label>
                <input type="text" id="txtMailVessel" class="form-control input-sm vessel-input">
            </div>

            <input type="hidden" id="txtIdEdit">

            <div class="row" style="margin-top:32px;">
                <div class="col-md-6">
                    <button onclick="saveData();" style="
                    width:100%;
                    padding:12px 0;
                    background:linear-gradient(135deg,#2563eb,#1d4ed8);
                    color:#fff;
                    border:none;
                    border-radius:14px;
                    font-weight:700;
                ">
                        Save
                    </button>
                </div>

                <div class="col-md-6">
                    <button onclick="reloadPage();" style="
                    width:100%;
                    padding:12px 0;
                    background:#f1f5f9;
                    color:#475569;
                    border:1px solid #cbd5e1;
                    border-radius:14px;
                    font-weight:700;
                ">
                        Cancel
                    </button>
                </div>
            </div>

        </div>
    </div>


</div>