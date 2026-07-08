<script>
$(document).ready(function() {
    loadOpenRecruitment();
    loadVesselType();
});

function loadOpenRecruitment() {
    $.ajax({
        url: "<?php echo base_url('getOpenRecruitment'); ?>",
        type: "POST",
        dataType: "json",
        success: function(res) {
            if (res.status) {
                renderOpenRecruitmentTable(res.data);
                renderRankOption(res.rankOption);
            }
        }
    });
}

function renderOpenRecruitmentTable(data) {

    let html = '';

    if (data.length === 0) {
        html = '<tr><td colspan="5" class="text-center">No data found</td></tr>';
        $('#idTbodyOpenRecruitment').html(html);
        return;
    }

    for (let i = 0; i < data.length; i++) {

        let publishIcon = data[i].isPublish ?
            '<i class="fa fa-check text-success"></i>' :
            '';

        let btnPub = data[i].isPublish ?
            '<button class="btn btn-warning btn-xs" onclick="pubDate(\'' + data[i].id +
            '\',\'unPublish\',\'openRecruitment\')"><i class="fa fa-history"></i></button>' :
            '<button class="btn btn-primary btn-xs" onclick="pubDate(\'' + data[i].id +
            '\',\'publish\',\'openRecruitment\')"><i class="fa fa-check"></i></button>';

        let btnAct =
            '<button class="btn btn-success btn-xs" onclick="getDataEdit(\'' + data[i].id +
            '\',\'openRecruitment\')">' +
            '<i class="fa fa-edit"></i></button> ' +
            '<button class="btn btn-danger btn-xs" onclick="delData(\'' + data[i].id + '\',\'openRecruitment\')">' +
            '<i class="fa fa-close"></i></button> ' +
            btnPub;

        html += '<tr>';
        html += '<td style="font-size:11px;text-align:center;">' + data[i].no + '</td>';
        html += '<td style="font-size:11px;">' + data[i].rankName +
            ' <span style="color:gray;font-size:10px;">(' + (data[i].urutan ?? '-') + ')</span></td>';
        html += '<td style="font-size:11px;">' + data[i].qualification + '</td>';
        html += '<td style="font-size:11px;text-align:center;">' + data[i].publishDate + '</td>';
        html += '<td style="font-size:11px;text-align:center;">' + data[i].vesselType + '</td>';
        html += '<td style="font-size:11px;text-align:center;">' + btnAct + '</td>';
        html += '</tr>';
    }

    $('#idTbodyOpenRecruitment').html(html);
}

function renderRankOption(data) {

    let html = '<option value=""> - Select Rank - </option>';

    for (let i = 0; i < data.length; i++) {
        html += '<option value="' + data[i].name + '">' + data[i].name + '</option>';
    }

    $('#slcRank').html(html);
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
                $.getJSON("<?php echo base_url('getOpenRecruitment'); ?>", function(res) {
                    if (res.status) {
                        renderOpenRecruitmentTable(res.data);
                    }
                });
                return;
            }

            $("#idLoading").show();

            $.post(
                "<?php echo base_url('getOpenRecruitment'); ?>", {
                    search: 'search',
                    txtSearch: keyword
                },
                function(res) {
                    if (res.status) {
                        renderOpenRecruitmentTable(res.data);
                    }
                    $("#idLoading").hide();
                },
                "json"
            );

        }, delay);
    });

});

function saveData() {

    let idEdit = $("#txtIdEdit").val();
    let txtSubjectName = $("#txtSubjectName").val().trim();
    let txtQualification = $("#txtQualification").val().trim();
    let slcRank = $("#slcRank").val();
    let slcVesselType = $("#slcVesselType").val();

    if (slcRank === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Validation',
            text: 'Please select a Rank!'
        });
        $("#slcRank").focus();
        return false;
    }

    if (txtSubjectName === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Validation',
            text: 'Subject Name is required!'
        });
        $("#txtSubjectName").focus();
        return false;
    }

    let formData = new FormData();
    formData.append('idEdit', idEdit);
    formData.append('slcRank', slcRank);
    formData.append('txtSubjectName', txtSubjectName);
    formData.append('txtQualification', txtQualification);
    formData.append('slcVesselType', slcVesselType);

    $("#idLoading").show();

    $.ajax({
        url: "<?php echo base_url('saveOpenRecruitment'); ?>",
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
                }).then(() => {

                    loadOpenRecruitment();
                    $("#txtIdEdit").val('');
                    $("#txtSubjectName").val('');
                    $("#txtQualification").val('');
                    $("#slcRank").val('');
                    $('#slcVesselType').val('');

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
                title: 'System Error',
                text: 'Something went wrong. Please try again.'
            });

        }
    });
}


function getDataEdit(id, type) {

    $("#idLoading").show();

    $.ajax({
        url: "<?php echo base_url('editOpenRecruitment'); ?>",
        type: "POST",
        dataType: "json",
        data: {
            idEdit: id,
            type: type
        },
        success: function(res) {

            $("#idLoading").hide();

            if (!res.status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: res.message
                });
                return;
            }

            if (!res.data) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data not found'
                });
                return;
            }

            let data = res.data;

            $("#txtIdEdit").val(data.id);
            $("#slcRank").val(data.rank);
            $("#txtSubjectName").val(data.subject_name);
            $("#txtQualification").val(data.qualification);
            $("#slcVesselType").val(data.vesselType);

        },
        error: function() {

            $("#idLoading").hide();

            Swal.fire({
                icon: 'error',
                title: 'System Error',
                text: 'Failed to fetch data'
            });
        }
    });
}


function delData(id, type) {

    Swal.fire({
        title: 'Are you sure?',
        text: "This data will be deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {

        if (!result.isConfirmed) return;

        $("#idLoading").show();

        $.ajax({
            url: "<?php echo base_url('deleteOpenRecruitment'); ?>",
            type: "POST",
            dataType: "json",
            data: {
                type: type,
                idDel: id
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
                    }).then(() => {
                        loadOpenRecruitment();
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
                    title: 'System Error',
                    text: 'Something went wrong. Please try again.'
                });

            }
        });

    });
}


function pubDate(id, type) {

    let actionText = (type === 'publish') ? 'Publish' : 'Unpublish';

    Swal.fire({
        title: actionText + ' this data?',
        text: "You can change this later.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, ' + actionText + ' it!'
    }).then((result) => {

        if (!result.isConfirmed) return;

        $("#idLoading").show();

        $.ajax({
            url: "<?php echo base_url('publishOpenRecruitment'); ?>",
            type: "POST",
            dataType: "json",
            data: {
                id: id,
                type: type
            },
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

                        loadOpenRecruitment();
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
                    title: 'System Error',
                    text: 'Something went wrong. Please try again.'
                });

            }
        });

    });
}

function loadVesselType(selected = '') {
    $.ajax({
        url: "<?php echo base_url('getVesselTypeOptions') ?>",
        type: "GET",
        data: {
            selected: selected
        },
        dataType: "json",
        success: function(res) {
            $('#slcVesselType').html(res);
        }
    });
}

function reloadPage() {
    parent.buttonMenuMaster('openRecruitment');
}
</script>

<!-- SEARCH -->
<div class="row" style="margin:18px 0;">
    <div class="col-md-3 col-xs-12">
        <input type="text" id="txtSearch" placeholder="🔍 Search subject..." class="form-control input-sm" style="
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
                        <th style="width:8%;text-align:center;background:#000099;color:#fff;">
                            No
                        </th>
                        <th style="background:#000099;color:#fff;">
                            Subject Name
                        </th>
                        <th style="width:25%;background:#000099;color:#fff;">
                            Qualification
                        </th>
                        <th style="width:20%;text-align:center;background:#000099;color:#fff;">
                            Date Publish
                        </th>
                        <th style="width:20%;text-align:center;background:#000099;color:#fff;">
                            Vessel Type
                        </th>
                        <th style="width:15%;text-align:center;background:#000099;color:#fff;">
                            Action
                        </th>
                    </tr>
                </thead>

                <tbody id="idTbodyOpenRecruitment">
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
                Open Recruitment Form
            </div>

            <!-- RANK -->
            <div style="margin-bottom:20px;">
                <label style="
                    font-weight:600;
                    font-size:13px;
                    color:#475569;
                    margin-bottom:8px;
                    display:block;
                ">
                    Rank
                </label>

                <select id="slcRank" class="form-control input-sm" style="
                        padding:10px 14px;
                        border-radius:12px;
                        border:1px solid #cbd5e1;
                        font-size:13px;
                        box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
                    ">
                </select>
            </div>

            <!-- SUBJECT NAME -->
            <div style="margin-bottom:20px;">
                <label style="
                    font-weight:600;
                    font-size:13px;
                    color:#475569;
                    margin-bottom:8px;
                    display:block;
                ">
                    Subject Name
                </label>

                <input type="text" id="txtSubjectName" placeholder="Type subject name" class="form-control input-sm"
                    style="
                        padding:12px 14px;
                        border-radius:12px;
                        border:1px solid #cbd5e1;
                        font-size:13px;
                        box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
                    ">
            </div>

            <div style="margin-bottom:20px;">
                <label style="
                    font-weight:600;
                    font-size:13px;
                    color:#475569;
                    margin-bottom:8px;
                    display:block;
                ">
                    Qualification
                </label>

                <textarea id="txtQualification" placeholder="Type qualification" class="form-control input-sm" style="
                        padding:12px 14px;
                        border-radius:12px;
                        border:1px solid #cbd5e1;
                        font-size:13px;
                        min-height:90px;
                        resize:none;
                        box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
                    "></textarea>
            </div>

            <div style="margin-bottom:20px;">
                <label style="
                    font-weight:600;
                    font-size:13px;
                    color:#475569;
                    margin-bottom:8px;
                    display:block;
                ">
                    Vessel Type
                </label>
                <select class="form-control input-sm" id="slcVesselType" style="padding:12px 14px;
                        border-radius:12px;
                        border:1px solid #cbd5e1;
                        font-size:13px;
                        box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);">
                </select>
            </div>

            <input type="hidden" id="txtIdEdit">

            <!-- BUTTON -->
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