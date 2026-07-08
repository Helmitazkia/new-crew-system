<script type="text/javascript">
$(document).ready(function() {});

$(document).ready(function() {
    loadRank();
});

function loadRank() {
    $.ajax({
        url: "<?php echo base_url('rank/json'); ?>",
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (res.status) {
                renderRankTable(res.data);
            }
        }
    });
}

function renderRankTable(data) {

    var html = '';

    if (data.length === 0) {
        html = '<tr><td colspan="5" class="text-center">No data found</td></tr>';
        $('#idTbody').html(html);
        return;
    }

    for (var i = 0; i < data.length; i++) {

        let iconUp = '';
        let iconDown = '';
        let btnAct = '';

        if (data[i].canUp) {
            iconUp =
                '<button class="btn btn-success btn-xs" style="padding:2px 6px;margin-left:4px;" ' +
                'onclick="btnNavUrut(\'' + data[i].id + '\',\'up\',\'' + data[i].urutan + '\')">' +
                '<i class="fa fa-sort-asc"></i></button>';
        }

        if (data[i].canDown) {
            iconDown =
                '<button class="btn btn-danger btn-xs" style="padding:2px 6px;margin-left:2px;" ' +
                'onclick="btnNavUrut(\'' + data[i].id + '\',\'down\',\'' + data[i].urutan + '\')">' +
                '<i class="fa fa-sort-desc"></i></button>';
        }

        if (!data[i].isLocked) {
            btnAct =
                '<button class="btn btn-success btn-xs" ' +
                'onclick="getDataEdit(\'' + data[i].id + '\',\'rank\')">' +
                '<i class="fa fa-edit"></i></button> ' +
                '<button class="btn btn-danger btn-xs" ' +
                'onclick="delData(\'' + data[i].id + '\',\'rank\')">' +
                '<i class="fa fa-close"></i></button>';
        }

        html += '<tr>';

        html += '<td style="font-size:11px;text-align:center;white-space:nowrap;">' +
            data[i].no + ' ' + iconUp + iconDown +
            '</td>';

        html += '<td style="font-size:11px;">' + data[i].name + '</td>';

        html += '<td style="font-size:11px;">' + data[i].definition + '</td>';

        html += '<td style="font-size:11px;text-align:center;">' + data[i].cadangan + '</td>';

        html += '<td style="font-size:11px;text-align:center;">' + btnAct + '</td>';

        html += '</tr>';
    }

    $('#idTbody').html(html);
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
                loadRank();
                return;
            }

            $("#idLoading").show();

            $.post(
                "<?php echo base_url('rank/json'); ?>", {
                    txtSearch: keyword
                },
                function(res) {
                    if (res.status) {
                        renderRankTable(res.data);
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
    var txtRankName = $("#txtRankName").val();
    var txtDefinition = $("#txtDefinition").val();
    var txtNumber = $("#txtNumber").val();
    var txtCadangan = $("#txtCadangan").val();

    if (txtRankName === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Validation',
            text: 'Rank Name cannot be empty',
            confirmButtonColor: '#3085d6'
        }).then(function() {
            $("#txtRankName").focus();
        });
        return false;
    }

    formData.append('idEdit', idEdit);
    formData.append('txtRankName', txtRankName);
    formData.append('txtDefinition', txtDefinition);
    formData.append('txtNumber', txtNumber);
    formData.append('txtCadangan', txtCadangan);

    $("#idLoading").show();

    $.ajax({
        url: "<?php echo base_url('rank/save'); ?>",
        type: "POST",
        data: formData,
        cache: false,
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
                }).then(function() {
                    loadRank();
                    $("#txtRankName").val('');
                    $("#txtDefinition").val('');
                    $("#txtNumber").val('');
                    $("#txtCadangan").val('');
                });

            } else {

                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: res.message,
                    confirmButtonColor: '#d33'
                });
            }
        },
        error: function() {

            $("#idLoading").hide();

            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Please try again later',
                confirmButtonColor: '#d33'
            });
        }
    });
}


function getDataEdit(id, type) {

    $("#idLoading").show();

    $.post(
        '<?php echo base_url("rank/get-edit"); ?>', {
            type: type,
            idEdit: id
        },
        function(res) {

            if (!res.status || !res.data) {
                alert('Data not found');
                $("#idLoading").hide();
                return;
            }

            // khusus RANK
            if (type === 'rank') {

                $("#txtIdEdit").val(res.data.kdrank);
                $("#txtRankName").val(res.data.nmrank);
                $("#txtDefinition").val(res.data.descrank);
                $("#txtNumber").val(res.data.urutan);
                $("#txtCadangan").val(res.data.cadangan);
            }

            $("#idLoading").hide();
        },
        "json"
    );
}


function btnNavUrut(kdRank, type, urutan) {
    $("#idLoading").show();

    $.post('<?php echo base_url("rank/urutRank"); ?>', {
            kdRank: kdRank,
            type: type,
            urutan: urutan
        },
        function(data) {
            if (data == "sukses") {
                $("#idLoading").show();

                reloadPage();
            }
        },
        "json"
    );
}

function delData(id, type) {

    Swal.fire({
        title: 'Delete Data?',
        text: 'This data will be removed',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (!result.isConfirmed) return;

        $("#idLoading").show();

        $.ajax({
            url: "<?php echo base_url('rank/delete'); ?>",
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
                        title: 'Deleted!',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
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
                    title: 'Server Error',
                    text: 'Please try again later'
                });
            }
        });
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
        <input type="text" id="txtSearch" placeholder="🔍 Search rank..." class="form-control input-sm" style="
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
                        <th style="width:26%;background:#000099;color:#fff;">
                            Rank Name
                        </th>
                        <th style="width:24%;background:#000099;color:#fff;">
                            Definition
                        </th>
                        <th style="width:15%;text-align:center;background:#000099;color:#fff;">
                            Cadangan
                        </th>
                        <th style="width:15%;text-align:center;background:#000099;color:#fff;">
                            Action
                        </th>

                    </tr>
                </thead>

                <tbody id="idTbody">
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
                Rank Form
            </div>

            <!-- RANK NAME -->
            <div style="margin-bottom:20px;">
                <label style="
                    font-weight:600;
                    font-size:13px;
                    color:#475569;
                    margin-bottom:8px;
                    display:block;
                ">
                    Rank Name
                </label>

                <input type="text" id="txtRankName" placeholder="Type rank name" class="form-control input-sm" style="
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

                <input type="text" id="txtDefinition" placeholder="Definition" class="form-control input-sm" style="
                        padding:12px 14px;
                        border-radius:12px;
                        border:1px solid #cbd5e1;
                        font-size:13px;
                        box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
                    ">
            </div>

            <!-- NUMBER -->
            <div style="margin-bottom:20px;">
                <label style="
                    font-weight:600;
                    font-size:13px;
                    color:#475569;
                    margin-bottom:8px;
                    display:block;
                ">
                    Number
                </label>

                <input type="text" id="txtNumber" placeholder="Number" class="form-control input-sm" style="
                        padding:12px 14px;
                        border-radius:12px;
                        border:1px solid #cbd5e1;
                        font-size:13px;
                    ">
            </div>

            <!-- CADANGAN -->
            <div style="margin-bottom:30px;">
                <label style="
                    font-weight:600;
                    font-size:13px;
                    color:#475569;
                    margin-bottom:8px;
                    display:block;
                ">
                    Cadangan
                </label>

                <input type="text" id="txtCadangan" placeholder="Cadangan" class="form-control input-sm" style="
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