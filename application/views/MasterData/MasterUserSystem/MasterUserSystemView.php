<script type="text/javascript">
$(document).ready(function() {});

$(document).ready(function() {
    loadDataUserSystem();
});

function loadDataUserSystem() {

    $.ajax({
        url: "<?php echo base_url('getMasterUserSystem'); ?>",
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (res.status) {
                renderUserSystemTable(res.data);
            }
        }
    });

}

function renderUserSystemTable(data) {

    var html = '';

    if (data.length === 0) {
        html = '<tr><td colspan="7" class="text-center">No data found</td></tr>';
        $('#idTbodyUserSystem').html(html);
        return;
    }

    for (var i = 0; i < data.length; i++) {

        html += '<tr>';
        html += ' <td style="font-size:11px;text-align:center;">' + data[i].no + '</td>';
        html += ' <td style="font-size:11px;">' + data[i].userName + '</td>';
        html += ' <td style="font-size:11px;">' + data[i].fullName + '</td>';
        html += ' <td style="font-size:11px;">' + data[i].password + '</td>';
        html += ' <td style="font-size:11px;">' + data[i].jenis + '</td>';
        html += ' <td style="font-size:11px;">' + data[i].init + '</td>';
        html += ' <td style="font-size:11px;text-align:center;">';
        html += '   <button class="btn btn-success btn-xs" ';
        html += '     onclick="getDataEdit(\'' + data[i].id + '\',\'userSystem\')">';
        html += '     <i class="fa fa-edit"></i>';
        html += '   </button> ';
        html += '   <button class="btn btn-danger btn-xs" ';
        html += '     onclick="delData(\'' + data[i].id + '\',\'userSystem\')">';
        html += '     <i class="fa fa-close"></i>';
        html += '   </button>';
        html += ' </td>';
        html += '</tr>';
    }

    $('#idTbodyUserSystem').html(html);
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
                loadDataUserSystem();
                return;
            }

            $("#idLoading").show();

            $.post(
                "<?php echo base_url('getMasterUserSystem'); ?>", {
                    search: 'search',
                    txtSearch: keyword
                },
                function(res) {
                    if (res.status) {
                        renderUserSystemTable(res.data);
                    }
                    $("#idLoading").hide();
                },
                "json"
            );

        }, delay);
    });

});

function saveData() {

    var idEdit = $("#txtIdEdit").val();
    var username = $("#txtusername").val().trim();
    var fullname = $("#txtuserfullname").val().trim();
    var password = $("#txtuserpassword").val().trim();
    var jenis = $("#txtuserjenis").val().trim();
    var init = $("#txtuserinit").val().trim();

    /* VALIDATION */
    if (username === '') {
        Swal.fire('Warning', 'Username is required', 'warning');
        $("#txtusername").focus();
        return;
    }

    if (fullname === '') {
        Swal.fire('Warning', 'User full name is required', 'warning');
        $("#txtuserfullname").focus();
        return;
    }

    if (idEdit === '' && password === '') {
        Swal.fire('Warning', 'Password is required', 'warning');
        $("#txtuserpassword").focus();
        return;
    }

    var formData = new FormData();
    formData.append('idEdit', idEdit);
    formData.append('txtusername', username);
    formData.append('txtuserfullname', fullname);
    formData.append('txtuserpassword', password);
    formData.append('txtuserjenis', jenis);
    formData.append('txtuserinit', init);

    $("#idLoading").show();

    $.ajax({
        url: "<?php echo base_url('saveMasterUserSystem'); ?>",
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
                    loadDataUserSystem();

                    $("#txtusername").val('');
                    $("#txtuserfullname").val('');
                    $("#txtuserpassword").val('');
                    $("#txtuserjenis").val('');
                    $("#txtuserinit").val('');
                });
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        },
        error: function() {
            $("#idLoading").hide();
            Swal.fire('Error', 'Server error', 'error');
        }
    });
}

function getDataEdit(id, type) {

    $("#idLoading").show();

    $.post(
        "<?php echo base_url('editMasterUserSystem'); ?>", {
            idEdit: id,
            type: type
        },
        function(res) {

            if (!res.status || !res.data) {
                alert('Data not found');
                $("#idLoading").hide();
                return;
            }

            $("#txtIdEdit").val(res.data.userId);
            $("#txtusername").val(res.data.userName);
            $("#txtuserfullname").val(res.data.userFullNm);
            $("#txtuserpassword").val(res.data.userPass);
            $("#txtuserjenis").val(res.data.userJenis);
            $("#txtuserinit").val(res.data.userInit);

            $("#idLoading").hide();
        },
        "json"
    );
}

function delData(id, type) {

    Swal.fire({
        title: 'Delete Confirmation',
        text: 'Are you sure you want to delete this data?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (!result.isConfirmed) {
            return;
        }

        $("#idLoading").show();

        $.ajax({
            url: "<?php echo base_url('deleteMasterUserSystem'); ?>",
            type: "POST",
            dataType: "json",
            data: {
                idDel: id,
                type: type
            },
            success: function(res) {

                $("#idLoading").hide();

                if (res.status) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted',
                        text: res.message,
                        timer: 1400,
                        showConfirmButton: false
                    }).then(() => {
                        loadDataUserSystem();
                    });

                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            },
            error: function() {
                $("#idLoading").hide();
                Swal.fire('Error', 'Server error', 'error');
            }
        });

    });
}
</script>

<div class="row" style="margin:18px 0;">
    <div class="col-md-3 col-xs-12">
        <input type="text" id="txtSearch" placeholder="🔍 Search user full name..." class="form-control input-sm" style="
                padding:10px 14px;
                border-radius:12px;
                border:1px solid #d0d7de;
                font-size:13px;
                box-shadow:0 2px 6px rgba(0,0,0,0.06);
            ">
    </div>
</div>
<div class="row">


    <div class="col-md-8 col-xs-12">
        <div style="
            max-height:625px;
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
                        <th style="background:#000099;color:#fff;">Username</th>
                        <th style="background:#000099;color:#fff;">Full Name</th>
                        <th style="background:#000099;color:#fff;">Password</th>
                        <th style="background:#000099;color:#fff;">User Jenis</th>
                        <th style="background:#000099;color:#fff;">User Init</th>
                        <th style="width:10%;text-align:center;background:#000099;color:#fff;">Action</th>
                    </tr>
                </thead>

                <tbody id="idTbodyUserSystem">
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
                User System Form
            </div>

            <!-- USERNAME -->
            <div style="margin-bottom:20px;">
                <label style="
                    font-weight:600;
                    font-size:13px;
                    color:#475569;
                    margin-bottom:8px;
                    display:block;
                ">Username</label>

                <input type="text" id="txtusername" placeholder="Username" class="form-control input-sm" style="
                        padding:12px 14px;
                        border-radius:12px;
                        border:1px solid #cbd5e1;
                        font-size:13px;
                    ">
            </div>

            <!-- FULL NAME -->
            <div style="margin-bottom:20px;">
                <label style="
                    font-weight:600;
                    font-size:13px;
                    color:#475569;
                    margin-bottom:8px;
                    display:block;
                ">User Full Name</label>

                <input type="text" id="txtuserfullname" placeholder="User Full Name" class="form-control input-sm"
                    style="
                        padding:12px 14px;
                        border-radius:12px;
                        border:1px solid #cbd5e1;
                        font-size:13px;
                    ">
            </div>

            <!-- PASSWORD -->
            <div style="margin-bottom:20px;">
                <label style="
                    font-weight:600;
                    font-size:13px;
                    color:#475569;
                    margin-bottom:8px;
                    display:block;
                ">User Password</label>

                <input type="text" id="txtuserpassword" placeholder="User Password" class="form-control input-sm" style="
                        padding:12px 14px;
                        border-radius:12px;
                        border:1px solid #cbd5e1;
                        font-size:13px;
                    ">
            </div>

            <!-- JENIS -->
            <div style="margin-bottom:20px;">
                <label style="
                    font-weight:600;
                    font-size:13px;
                    color:#475569;
                    margin-bottom:8px;
                    display:block;
                ">User Jenis</label>

                <input type="text" id="txtuserjenis" placeholder="User Jenis" class="form-control input-sm" style="
                        padding:12px 14px;
                        border-radius:12px;
                        border:1px solid #cbd5e1;
                        font-size:13px;
                    ">
            </div>

            <!-- INIT -->
            <div style="margin-bottom:30px;">
                <label style="
                    font-weight:600;
                    font-size:13px;
                    color:#475569;
                    margin-bottom:8px;
                    display:block;
                ">User Init</label>

                <input type="text" id="txtuserinit" placeholder="User Init" class="form-control input-sm" style="
                        padding:12px 14px;
                        border-radius:12px;
                        border:1px solid #cbd5e1;
                        font-size:13px;
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