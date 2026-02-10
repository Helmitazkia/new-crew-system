<script type="text/javascript">
$(document).ready(function() {});

$(document).ready(function() {

    $.ajax({
        url: "<?php echo base_url('certificate/json') ?>",
        type: "GET",
        dataType: "json",
        success: function(res) {

            if (res.status) {
                renderCertificateTable(res.data);
            }
        }
    });

});

function renderCertificateTable(data) {

    var html = '';
    var icon = '';

    if (data.length === 0) {
        html = '<tr><td colspan="5" class="text-center">No data found</td></tr>';
        $('#idTbodyCert').html(html);
        return;
    }

    for (var i = 0; i < data.length; i++) {

        icon = (data[i].st_icon === 'check') ?
            '<i class="fa fa-check text-success"></i>' :
            '<i class="fa fa-close text-danger"></i>';

        html += '<tr>';
        html += ' <td class="text-center">' + data[i].no + '</td>';
        html += ' <td>' + data[i].fullname + '</td>';
        html += ' <td>' + data[i].definition + '</td>';
        html += ' <td class="text-center">' + icon + '</td>';
        html += ' <td class="text-center">';
        html += '   <button class="btn btn-success btn-xs" ';
        html += '     onclick="getDataEdit(\'' + data[i].kdcert + '\',\'certificate\')">';
        html += '     <i class="fa fa-edit"></i>';
        html += '   </button> ';
        html += '   <button class="btn btn-danger btn-xs" ';
        html += '     onclick="delData(\'' + data[i].kdcert + '\',\'certificate\')">';
        html += '     <i class="fa fa-close"></i>';
        html += '   </button>';
        html += ' </td>';
        html += '</tr>';
    }

    $('#idTbodyCert').html(html);
}


$(document).ready(function() {

    var typingTimer = null; // lokal ke ready()
    var delay = 400; // debounce time

    // live search
    $('#txtSearchCert').on('keyup', function() {

        var keyword = $(this).val().trim();

        if (typingTimer) {
            clearTimeout(typingTimer);
        }

        typingTimer = setTimeout(function() {

            // kosong → load semua data
            if (keyword === '') {
                $.getJSON("<?php echo base_url('certificate/json') ?>", function(res) {
                    if (res.status) {
                        renderCertificateTable(res.data);
                    }
                });
                return;
            }

            $("#idLoading").show();

            $.post(
                "<?php echo base_url('certificate/search'); ?>", {
                    txtSearchCert: keyword
                },
                function(res) {
                    if (res.status) {
                        renderCertificateTable(res.data);
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
    var group = $("#slcIdGroup").val();
    var certName = $("#txtCertName").val();
    var certDisplay = $("#txtCertNameDisplay").val();
    var definisi = $("#txtDefinition").val();
    var slcDisplay = $("#slcDisplayCert").val();

    if (certName == "") {
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: 'Certificate Name cannot be empty'
        }).then(function() {
            $("#txtCertName").focus();
        });
        return false;
    }

    formData.append('idEdit', idEdit);
    formData.append('group', group);
    formData.append('certName', certName);
    formData.append('certDisplay', certDisplay);
    formData.append('definisi', definisi);
    formData.append('slcDisplay', slcDisplay);

    $("#idLoading").show();

    $.ajax({
        url: "<?php echo base_url('certificate/save'); ?>",
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(res) {

            $("#idLoading").hide();

            if (res.status == true) {
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
                text: 'Server error, please try again'
            });
        }
    });
}


function getDataEdit(id, type) {
    $("#idLoading").show();

    $.post('<?php echo base_url("certificate/get-edit"); ?>', {
            type: type,
            idEdit: id
        },
        function(data) {
            $("#txtIdEdit").val(data['rsl'][0]['kdcert']);
            $("#slcIdGroup").val(data['rsl'][0]['certgroup']);
            $("#txtCertName").val(data['rsl'][0]['certname']);
            $("#txtCertNameDisplay").val(data['rsl'][0]['dispname']);
            $("#txtDefinition").val(data['rsl'][0]['definition']);
            $("#slcDisplayCert").val(data['rsl'][0]['st_display']);

            $("#idLoading").hide();
        },
        "json"
    );
}

function delData(id, type) {

    Swal.fire({
        title: 'Are you sure?',
        text: 'This data will be deleted',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then(function(result) {

        if (result.isConfirmed) {

            $("#idLoading").show();

            $.ajax({
                url: '<?php echo base_url("certificate/delete"); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    type: type,
                    idDel: id
                },
                success: function(res) {

                    $("#idLoading").hide();

                    if (res.status == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
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
            parent.buttonMenuMaster('certificate');
        } else {
            location.reload();
        }
    } catch (e) {
        location.reload();
    }
}
</script>

<div class="row" style="margin-top:10px;">

    <!-- SEARCH -->
    <div class="col-md-4 col-xs-12" style="margin-bottom:10px;">
        <input type="text" class="form-control input-sm" id="txtSearchCert" placeholder="🔍 Search certificate..."
            style="
                    border-radius:6px;
                    padding:8px 10px;
                    box-shadow:0 1px 4px rgba(0,0,0,.08);
               ">
    </div>
</div>

<div class="row">

    <div class="col-md-8 col-xs-12" style="padding-bottom:15px;">
        <div style="
                background:#ffffff;
                border-radius:10px;
                box-shadow:0 2px 10px rgba(0,0,0,.08);
                padding:10px;
        ">
            <div class="table-responsive" style="height:480px;overflow-y:auto;">
                <table class="table table-bordered table-hover table-condensed" style="margin-bottom:0;">
                    <thead>
                        <tr>
                            <th style="width:5%;text-align:center;vertical-align:middle;
                                background:#000099 !important;color:#ffffff !important;">
                                No
                            </th>
                            <th style="width:35%;text-align:center;vertical-align:middle;
                                background:#000099 !important;color:#ffffff !important;">
                                CERTIFICATES NAME
                            </th>
                            <th style="width:35%;text-align:center;vertical-align:middle;
                                background:#000099 !important;color:#ffffff !important;">
                                DEFINITION
                            </th>
                            <th style="width:10%;text-align:center;vertical-align:middle;
                                background:#000099 !important;color:#ffffff !important;">
                                DISPLAY
                            </th>
                            <th style="width:15%;text-align:center;vertical-align:middle;
                                background:#000099 !important;color:#ffffff !important;">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody id="idTbodyCert">
                        <!-- dynamic -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- FORM -->
    <div class="col-md-4 col-xs-12">
        <div style="
                background:#ffffff;
                border-radius:10px;
                box-shadow:0 2px 10px rgba(0,0,0,.08);
                padding:15px;
        ">
            <div style="
                    font-weight:600;
                    margin-bottom:15px;
                    text-align:right;
                    color:#0b7c86;
            ">
                :: Form Certificate ::
            </div>

            <div class="row">
                <div class="col-md-6 col-xs-12" style="margin-bottom:10px;">
                    <label style="font-size:12px;">Group</label>
                    <select class="form-control input-sm" id="slcIdGroup" style="border-radius:6px;">
                        <option value="">- Select -</option>
                        <option value="A">(A) Reg I</option>
                        <option value="B">(B) Reg I</option>
                        <option value="C">(C) Reg I</option>
                        <option value="D">(D) Reg I</option>
                        <option value="E">(E) Reg I</option>
                        <option value="F">(F) Reg I</option>
                        <option value="G">(G) Reg I</option>
                        <option value="H">(H) Reg I</option>
                        <option value="PID">P.ID</option>
                        <option value="OTH">OTH</option>
                    </select>
                </div>

                <div class="col-md-6 col-xs-12" style="margin-bottom:10px;">
                    <label style="font-size:12px;">Display</label>
                    <select class="form-control input-sm" id="slcDisplayCert" style="border-radius:6px;">
                        <option value="Y">Y</option>
                        <option value="N">N</option>
                    </select>
                </div>

                <div class="col-md-12 col-xs-12" style="margin-bottom:10px;">
                    <label style="font-size:12px;">Certificates Name</label>
                    <input type="text" class="form-control input-sm" id="txtCertName" style="border-radius:6px;"
                        placeholder="Certificate">
                </div>

                <div class="col-md-12 col-xs-12" style="margin-bottom:10px;">
                    <label style="font-size:12px;">Display Name</label>
                    <input type="text" class="form-control input-sm" id="txtCertNameDisplay" style="border-radius:6px;"
                        placeholder="Display">
                </div>

                <div class="col-md-12 col-xs-12" style="margin-bottom:15px;">
                    <label style="font-size:12px;">Definition</label>
                    <input type="text" class="form-control input-sm" id="txtDefinition" style="border-radius:6px;"
                        placeholder="Definition">
                </div>
            </div>

            <div class="row">
                <input type="hidden" id="txtIdEdit">

                <div class="col-md-6 col-xs-12" style="margin-bottom:5px;">
                    <button class="btn btn-primary btn-sm btn-block" style="border-radius:6px;" onclick="saveData();">
                        <i class="glyphicon glyphicon-saved"></i> Save
                    </button>
                </div>

                <div class="col-md-6 col-xs-12" style="margin-bottom:5px;">
                    <button class="btn btn-danger btn-sm btn-block" style="border-radius:6px;" onclick="reloadPage();">
                        <i class="glyphicon glyphicon-ban-circle"></i> Cancel
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>