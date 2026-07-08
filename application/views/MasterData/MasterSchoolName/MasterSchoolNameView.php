<script type="text/javascript">
$(document).ready(function() {
    loadDataSchool();
});

function loadDataSchool() {
    $.getJSON(
        "<?php echo base_url('school/json'); ?>",
        function(res) {
            if (res.status) {
                renderSchoolTable(res.data);
            }
        }
    );
}

function renderSchoolTable(data) {

    var html = '';

    if (data.length === 0) {
        html = '<tr><td colspan="3" class="text-center">No data found</td></tr>';
        $('#idTbodySchool').html(html);
        return;
    }

    for (var i = 0; i < data.length; i++) {

        html += '<tr>';
        html += ' <td class="text-center" style="font-size:11px;">' + data[i].no + '</td>';
        html += ' <td style="font-size:11px;">' + data[i].schoolname + '</td>';
        html += ' <td class="text-center">';
        html += '   <button class="btn btn-success btn-xs" ';
        html += '     onclick="getDataEdit(\'' + data[i].id + '\',\'masterSchool\')">';
        html += '     <i class="fa fa-edit"></i>';
        html += '   </button> ';
        html += '   <button class="btn btn-danger btn-xs" ';
        html += '     onclick="delData(\'' + data[i].id + '\',\'school\')">';
        html += '     <i class="fa fa-close"></i>';
        html += '   </button>';
        html += ' </td>';
        html += '</tr>';
    }

    $('#idTbodySchool').html(html);
}

$(document).ready(function() {

    var typingTimer = null;
    var delay = 400;

    $('#txtSearchSchool').on('keyup', function() {

        var keyword = $(this).val().trim();

        if (typingTimer) {
            clearTimeout(typingTimer);
        }

        typingTimer = setTimeout(function() {

            $("#idLoading").show();

            $.ajax({
                url: "<?php echo base_url('school/json'); ?>",
                type: "POST",
                dataType: "json",
                data: {
                    txtSearch: keyword
                },
                success: function(res) {
                    if (res.status) {
                        renderSchoolTable(res.data);
                    }
                    $("#idLoading").hide();
                }
            });

        }, delay);
    });
});

function saveData() {

    var idEdit = $("#txtIdEdit").val();
    var txtnameschool = $("#txtnameschool").val();

    if (txtnameschool.trim() == "") {
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: 'School name cannot be empty!'
        });
        $("#txtnameschool").focus();
        return false;
    }

    var formData = new FormData();
    formData.append('idEdit', idEdit);
    formData.append('txtnameschool', txtnameschool);

    $("#idLoading").show();

    $.ajax({
        url: "<?php echo base_url('school/save'); ?>",
        method: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",

        success: function(response) {

            $("#idLoading").hide();

            if (response.status) {

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    loadDataSchool();
                    $("#txtnameschool").val('');
                });

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: response.message
                });
            }
        },

        error: function() {

            $("#idLoading").hide();

            Swal.fire({
                icon: 'error',
                title: 'System Error',
                text: 'Something went wrong. Please try again.'
            });
        }
    });
}


function getDataEdit(id, type) {
    $("#idLoading").show();

    $.post("<?php echo base_url('school/get-edit'); ?>", {
            idEdit: id,
            type: type
        }, function(res) {

            if (!res.status) {
                alert(res.message || "Data tidak ditemukan");
                $("#idLoading").hide();
                return;
            }

            if (!res.data) {
                alert("Data tidak ditemukan!");
                $("#idLoading").hide();
                return;
            }

            $("#txtIdEdit").val(res.data.id);
            $("#txtnameschool").val(res.data.schoolname);

            $("#idLoading").hide();

        }, "json")
        .fail(function(xhr) {
            console.error("AJAX Error:", xhr.responseText);
            alert("Terjadi kesalahan saat mengambil data.");
            $("#idLoading").hide();
        });
}



function delData(id, type) {

    Swal.fire({
        title: 'Are you sure?',
        text: "This data will be deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (!result.isConfirmed) return;

        $("#idLoading").show();

        $.ajax({
            url: '<?php echo base_url("school/delete"); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                idDel: id,
                type: type
            },
            success: function(response) {
                $("#idLoading").hide();

                if (response.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        reloadPage();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed!',
                        text: response.message
                    });
                }
            },
            error: function() {
                $("#idLoading").hide();

                Swal.fire({
                    icon: 'error',
                    title: 'System Error',
                    text: 'Something went wrong. Please try again.'
                });
            }
        });

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

<!-- SEARCH -->
<div class="row" style="margin:18px 0;">
    <div class="col-md-3 col-xs-12">
        <input type="text" id="txtSearchSchool" placeholder="🔍 Search school..." class="form-control input-sm" style="
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
                        <th style="width:10%;text-align:center;background:#000099;color:#fff;">
                            No
                        </th>
                        <th style="background:#000099;color:#fff;">
                            School Name
                        </th>
                        <th style="width:20%;text-align:center;background:#000099;color:#fff;">
                            Action
                        </th>
                    </tr>
                </thead>

                <tbody id="idTbodySchool">
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
                School Form
            </div>

            <!-- SCHOOL NAME -->
            <div style="margin-bottom:24px;">
                <label style="
                    font-weight:600;
                    font-size:13px;
                    color:#475569;
                    margin-bottom:8px;
                    display:block;
                ">
                    School Name
                </label>

                <input type="text" id="txtnameschool" placeholder="Type school name" class="form-control input-sm"
                    style="
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