<script type="text/javascript">
$(document).ready(function() {});

$(document).ready(function() {
    loadDataCrewUser();
});

function loadDataCrewUser() {
    $.ajax({
        url: "<?php echo base_url('getUserCrew'); ?>",
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (res.status) {
                renderCrewUserTable(res.data);
            }
        }
    });
}

function renderCrewUserTable(data) {

    var html = '';

    if (data.length === 0) {
        html = '<tr><td colspan="6" class="text-center">No data found</td></tr>';
        $('#idTbodyCert').html(html);
        return;
    }

    for (var i = 0; i < data.length; i++) {

        html += '<tr>';
        html += ' <td style="font-size:11px;text-align:center;">' + data[i].no + '</td>';
        html += ' <td style="font-size:11px;">' + data[i].idperson + '</td>';
        html += ' <td style="font-size:11px;">' + data[i].fullname + '</td>';
        html += ' <td style="font-size:11px;">' + data[i].username + '</td>';
        html += ' <td style="font-size:11px;">' + data[i].password + '</td>';
        html += ' <td style="font-size:11px;text-align:center;">';
        html += '   <button class="btn btn-success btn-xs" ';
        html += '     onclick="getDataEdit(\'' + data[i].id + '\',\'userCrew\')">';
        html += '     <i class="fa fa-edit"></i>';
        html += '   </button> ';
        html += '   <button class="btn btn-danger btn-xs" ';
        html += '     onclick="delData(\'' + data[i].id + '\',\'userCrew\')">';
        html += '     <i class="fa fa-close"></i>';
        html += '   </button>';
        html += ' </td>';
        html += '</tr>';
    }

    $('#idTbMasterUser').html(html);
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
                loadDataCrewUser();
                return;
            }

            $("#idLoading").show();

            $.post(
                "<?php echo base_url('getUserCrew'); ?>", {
                    search: 'search',
                    txtSearch: keyword
                },
                function(res) {
                    if (res.status) {
                        renderCrewUserTable(res.data);
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
    var txtidperson = $("#txtidperson").val();
    var txtfullname = $("#txtfullname").val();
    var txtusername = $("#txtusername").val();
    var txtpassword = $("#txtpassword").val();

    if (txtidperson == "") {
        Swal.fire({
            icon: 'warning',
            title: 'Validation',
            text: 'ID Person Empty..!!'
        });
        $("#txtidperson").focus();
        return;
    }

    if (txtfullname == "") {
        Swal.fire({
            icon: 'warning',
            title: 'Validation',
            text: 'Full Name Empty..!!'
        });
        $("#txtfullname").focus();
        return;
    }

    if (txtusername == "") {
        Swal.fire({
            icon: 'warning',
            title: 'Validation',
            text: 'Username Empty..!!'
        });
        $("#txtusername").focus();
        return;
    }

    formData.append('idEdit', idEdit);
    formData.append('txtidperson', txtidperson);
    formData.append('txtfullname', txtfullname);
    formData.append('txtusername', txtusername);
    formData.append('txtpassword', txtpassword);

    $("#idLoading").show();

    $.ajax({
        url: "<?php echo base_url('saveUserCrew'); ?>",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
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
                    loadDataCrewUser();
                    $("#txtidperson").val('');
                    $("#txtfullname").val('');
                    $("#txtusername").val('');
                    $("#txtpassword").val('');
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
                text: 'Server error'
            });
        }
    });
}

function getDataEdit(id, type) {

    $("#idLoading").show();

    $.post(
        "<?php echo base_url('editUserCrew'); ?>", {
            idEdit: id,
            type: type
        },
        function(res) {

            if (!res.status || !res.data) {
                alert('Data tidak ditemukan');
                $("#idLoading").hide();
                return;
            }

            $("#txtIdEdit").val(res.data.id);
            $("#txtidperson").val(res.data.idperson);
            $("#txtfullname").val(res.data.fullname);
            $("#txtusername").val(res.data.username);
            $("#txtpassword").val(res.data.password);
        },
        "json"
    );
}


function delData(id, type) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Data yang dihapus tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete!',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (result.isConfirmed) {
            $("#idLoading").show();

            $.ajax({
                url: '<?php echo base_url("deleteUserCrew"); ?>',
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
                        }).then(() => {
                            loadDataCrewUser();
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
                        text: 'Server error, please try again.'
                    });
                }
            });
        }

    });
}
</script>

<div class="row" style="margin:18px 0;">
    <div class="col-md-3 col-xs-12">
        <input type="text" id="txtSearch" placeholder="🔍 Search full name..." class="form-control input-sm" style="
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
                        <th style="width:5%;text-align:center;background:#000099;color:#fff;">No</th>
                        <th style="width:15%;background:#000099;color:#fff;">ID Person</th>
                        <th style="background:#000099;color:#fff;">Full Name</th>
                        <th style="background:#000099;color:#fff;">Username</th>
                        <th style="width:20%;background:#000099;color:#fff;">Password</th>
                        <th style="width:15%;text-align:center;background:#000099;color:#fff;">Action</th>
                    </tr>
                </thead>

                <tbody id="idTbMasterUser">
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
                Crew User Form
            </div>

            <!-- ID PERSON -->
            <div style="margin-bottom:20px;">
                <label style="font-weight:600;font-size:13px;color:#475569;margin-bottom:8px;display:block;">
                    ID Person
                </label>
                <input type="text" id="txtidperson" placeholder="Type ID Person" class="form-control input-sm" style="
                        padding:12px 14px;
                        border-radius:12px;
                        border:1px solid #cbd5e1;
                        font-size:13px;
                        box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
                    ">
            </div>

            <!-- FULL NAME -->
            <div style="margin-bottom:20px;">
                <label style="font-weight:600;font-size:13px;color:#475569;margin-bottom:8px;display:block;">
                    Full Name
                </label>
                <input type="text" id="txtfullname" placeholder="Type full name" class="form-control input-sm" style="
                        padding:12px 14px;
                        border-radius:12px;
                        border:1px solid #cbd5e1;
                        font-size:13px;
                        box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
                    ">
            </div>

            <!-- USERNAME -->
            <div style="margin-bottom:20px;">
                <label style="font-weight:600;font-size:13px;color:#475569;margin-bottom:8px;display:block;">
                    Username
                </label>
                <input type="text" id="txtusername" placeholder="Type username" class="form-control input-sm" style="
                        padding:12px 14px;
                        border-radius:12px;
                        border:1px solid #cbd5e1;
                        font-size:13px;
                        box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
                    ">
            </div>

            <!-- PASSWORD -->
            <div style="margin-bottom:20px;">
                <label style="font-weight:600;font-size:13px;color:#475569;margin-bottom:8px;display:block;">
                    Password
                </label>
                <input type="password" id="txtpassword" placeholder="Type password" class="form-control input-sm" style="
                        padding:12px 14px;
                        border-radius:12px;
                        border:1px solid #cbd5e1;
                        font-size:13px;
                        box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
                    ">
            </div>

            <input type="hidden" id="txtIdEdit">

            <!-- ACTION -->
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
                    ">
                        Cancel
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>