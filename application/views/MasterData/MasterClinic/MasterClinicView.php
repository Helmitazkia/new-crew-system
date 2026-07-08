<script type="text/javascript">
$(document).ready(function() {});

$(document).ready(function() {
    loadDataClinic()
});

function loadDataClinic() {
    $.ajax({
        url: "<?php echo base_url('dataClinic'); ?>",
        type: "GET",
        dataType: "json",
        success: function(res) {

            if (res.status) {
                renderClinicTable(res.data);
            }
        }
    });
}

function renderClinicTable(data) {

    var html = '';

    if (data.length === 0) {
        html = '<tr><td colspan="3" class="text-center">No data found</td></tr>';
        $('#idTbodyClinic').html(html);
        return;
    }

    for (var i = 0; i < data.length; i++) {

        html += '<tr>';
        html += ' <td style="font-size:11px;text-align:center;">' + data[i].id + '</td>';
        html += ' <td style="font-size:11px;">' + data[i].clinic_name + '</td>';
        html += ' <td style="font-size:11px;">' + data[i].address_clinic + '</td>';
        html += ' <td style="font-size:11px;">' + data[i].telp + '</td>';
        html += ' <td style="font-size:11px;">' + data[i].fax + '</td>';
        html += ' <td style="font-size:11px;">' + data[i].email + '</td>';
        html += ' <td style="font-size:11px;text-align:center;">';
        html += '   <button class="btn btn-success btn-xs" ';
        html += '     onclick="getDataEdit(\'' + data[i].id + '\',\'clinic\')">';
        html += '     <i class="fa fa-edit"></i>';
        html += '   </button> ';
        html += '   <button class="btn btn-danger btn-xs" style="margin-top:6px;"';
        html += '     onclick="delData(\'' + data[i].id + '\',\'dataClinic\')">';
        html += '     <i class="fa fa-close"></i>';
        html += '   </button>';
        html += ' </td>';
        html += '</tr>';
    }

    $('#idTbodyClinic').html(html);
}

$(document).ready(function() {

    var typingTimer = null;
    var delay = 400;

    $('#txtSearch').on('keyup', function() {

        var keyword = $(this).val().trim();

        if (typingTimer) {
            clearTimeout(typingTimer);
        }

        typingTimer = setTimeout(function() {

            if (keyword === '') {
                $.getJSON("<?php echo base_url('dataClinic'); ?>", function(res) {
                    if (res.status) {
                        renderClinicTable(res.data);
                    }
                });
                return;
            }

            $("#idLoading").show();

            $.post(
                "<?php echo base_url('dataClinic'); ?>", {
                    search: 'search',
                    txtSearch: keyword
                },
                function(res) {
                    if (res.status) {
                        renderClinicTable(res.data);
                    }
                    $("#idLoading").hide();
                },
                "json"
            );

        }, delay);
    });

});


function saveDataClinic() {

    var clinicName = $('#txtClinicName').val().trim();
    var clinicAddress = $('#txtClinicAddress').val().trim();
    var telp = $('#txtTelp').val().trim();
    var fax = $('#txtFax').val().trim();
    var email = $('#txtEmail').val().trim();
    var idEdit = $('#txtIdEdit').val();

    if (clinicName === '') {
        Swal.fire('Error', 'Clinic name empty', 'error');
        return;
    }

    if (clinicAddress === '') {
        Swal.fire('Error', 'Clinic address empty', 'error');
        return;
    }

    if (telp === '') {
        Swal.fire('Error', 'Telp empty', 'error');
        return;
    }

    if (fax === '') {
        Swal.fire('Error', 'Fax empty', 'error');
        return;
    }

    if (email === '') {
        Swal.fire('Error', 'Email empty', 'error');
        return;
    }


    var formData = new FormData();
    formData.append('txtClinicName', clinicName);
    formData.append('txtClinicAddress', clinicAddress);
    formData.append('txtTelp', telp);
    formData.append('txtFax', fax);
    formData.append('txtEmail', email);
    formData.append('idEdit', idEdit);

    $.ajax({
        url: "<?php echo base_url('saveClinic'); ?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(res) {
            if (res.status) {
                Swal.fire('Success', res.message, 'success')
                    .then(() => {
                        loadDataClinic();

                        $('#txtClinicName').val('');
                        $('#txtClinicAddress').val('');
                        $('#txtTelp').val('');
                        $('#txtFax').val('');
                        $('#txtEmail').val('');
                        $('#txtIdEdit').val('');
                    });
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        },
        error: function() {
            Swal.fire('Error', 'Server error', 'error');
        }
    });
}



function getDataEdit(userId, type) {

    $("#idLoading").show();

    $.post(
        '<?php echo base_url("editClinic"); ?>', {
            type: type,
            idEdit: userId
        },
        function(res) {

            if (res.status === true && res.data !== null) {

                $("#txtIdEdit").val(res.data.id);
                $("#txtClinicName").val(res.data.clinic_name);
                $("#txtClinicAddress").val(res.data.address_clinic);
                $("#txtTelp").val(res.data.telp);
                $("#txtFax").val(res.data.fax);
                $("#txtEmail").val(res.data.email);

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: res.message || 'Data not found'
                });
            }

            $("#idLoading").hide();
        },
        "json"
    );
}


function delData(id, type) {
    Swal.fire({
        title: 'Delete data?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete!'
    }).then((result) => {

        if (result.isConfirmed) {

            $.post(
                "<?php echo base_url('deleteClinic'); ?>", {
                    idDel: id,
                    type: type
                },
                function(res) {

                    if (res.status) {
                        Swal.fire('Deleted!', res.message, 'success');
                        reloadPage();
                    } else {
                        Swal.fire('Error', res.message, 'error');
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
            parent.buttonMenuMaster('clinic ');
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
        <div style="position:relative;">
            <input type="text" id="txtSearch" placeholder="🔍 Search Clinic..." class="form-control input-sm" style="
                       padding:10px 14px;
                       border-radius:12px;
                       border:1px solid #d0d7de;
                       font-size:13px;
                       box-shadow:0 2px 6px rgba(0,0,0,0.06);
                   ">
        </div>
    </div>
</div>


<div class="row">

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
                        <th style="width:6%;text-align:center; background:#000099 !important;color:#ffffff !important;">
                            No</th>
                        <th style=" width:35%;font-weight:600; background:#000099 !important;color:#ffffff
                            !important;">Clinic Name</th>
                        <th style=" width:35%;font-weight:600; background:#000099 !important;color:#ffffff
                            !important;">Address Clinic</th>
                        <th style=" width:35%;font-weight:600; background:#000099 !important;color:#ffffff
                            !important;">Telp</th>
                        <th style=" width:35%;font-weight:600; background:#000099 !important;color:#ffffff
                            !important;">Fax</th>
                        <th style=" width:35%;font-weight:600; background:#000099 !important;color:#ffffff
                            !important;">Email</th>
                        <th style="width:30%;text-align:center;font-weight:600; background:#000099 !important;color:#ffffff
                            !important;">Action</th>
                    </tr>
                </thead>

                <tbody id="idTbodyClinic">

                </tbody>
            </table>
        </div>
    </div>


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
                color:#000099;
            ">

                Clinic Form
            </div>

            <!-- Input -->
            <div style="margin-bottom:26px;">
                <label style="
                    font-weight:600;
                    font-size:13px;
                    color:#475569;
                    margin-bottom:8px;
                    display:block;
                ">
                    Clinic Name
                </label>

                <input type="text" id="txtClinicName" placeholder="Type clinic name" class="form-control input-sm"
                    style="
                       padding:12px 14px;
                       border-radius:12px;
                       border:1px solid #cbd5e1;
                       font-size:13px;
                       box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
                   ">

                <!-- Input -->
                <div style="margin-bottom:26px;">
                    <label style="
                        font-weight:600;
                        font-size:13px;
                        color:#475569;
                        margin-bottom:8px;
                        display:block;
                    ">
                        Clinic Address
                    </label>

                    <input type="text" id="txtClinicAddress" placeholder="Type clinic name"
                        class="form-control input-sm" style="
                       padding:12px 14px;
                       border-radius:12px;
                       border:1px solid #cbd5e1;
                       font-size:13px;
                       box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
                   ">
                    <div style="margin-bottom:26px;">
                        <label style="
                            font-weight:600;
                            font-size:13px;
                            color:#475569;
                            margin-bottom:8px;
                            display:block;
                        ">
                            Telp
                        </label>

                        <input type="text" id="txtTelp" placeholder="Type clinic name" class="form-control input-sm"
                            style="
                            padding:12px 14px;
                            border-radius:12px;
                            border:1px solid #cbd5e1;
                            font-size:13px;
                            box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
                        ">
                        <div style="margin-bottom:26px;">
                            <label style="
                                font-weight:600;
                                font-size:13px;
                                color:#475569;
                                margin-bottom:8px;
                                display:block;
                            ">
                                Fax
                            </label>

                            <input type="text" id="txtFax" placeholder="Type clinic name" class="form-control input-sm"
                                style="
                                padding:12px 14px;
                                border-radius:12px;
                                border:1px solid #cbd5e1;
                                font-size:13px;
                                box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
                            ">
                            <div style="margin-bottom:26px;">
                                <label style="
                                    font-weight:600;
                                    font-size:13px;
                                    color:#475569;
                                    margin-bottom:8px;
                                    display:block;
                                ">
                                    Email
                                </label>

                                <input type="text" id="txtEmail" placeholder="Type clinic name"
                                    class="form-control input-sm" style="
                                    padding:12px 14px;
                                    border-radius:12px;
                                    border:1px solid #cbd5e1;
                                    font-size:13px;
                                    box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
                                ">
                            </div>

                            <input type="hidden" id="txtIdEdit">

                            <div class="row" style="margin-top:48px;">
                                <div class="col-md-6 col-xs-12">
                                    <button onclick="saveDataClinic();" style="
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
            </div>
        </div>
    </div>
</div>