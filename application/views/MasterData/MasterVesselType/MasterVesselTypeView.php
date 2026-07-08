 <script type="text/javascript">
$(document).ready(function() {});

$(document).ready(function() {

    loadVesselType();

});

function loadVesselType(keyword = '') {

    $("#idLoading").show();

    $.ajax({
        url: "<?php echo base_url('vesselType/json'); ?>",
        type: "POST",
        dataType: "json",
        data: {
            txtSearch: keyword
        },
        success: function(res) {

            if (res.status) {
                renderVesselTypeTable(res.data);
            }

            $("#idLoading").hide();
        },
        error: function() {
            $("#idLoading").hide();
        }
    });
}

function renderVesselTypeTable(data) {

    var html = '';

    if (data.length === 0) {
        html = '<tr><td colspan="4" class="text-center">No data found</td></tr>';
        $('#idTbodyCert').html(html);
        return;
    }

    for (var i = 0; i < data.length; i++) {

        html += '<tr>';
        html += ' <td class="text-center">' + data[i].no + '</td>';
        html += ' <td>' + data[i].vesseltype + '</td>';
        html += ' <td>' + data[i].definition + '</td>';
        html += ' <td class="text-center">';
        html += '   <button class="btn btn-success btn-xs" ';
        html += '     onclick="getDataEdit(\'' + data[i].kdtype + '\',\'vesselType\')">';
        html += '     <i class="fa fa-edit"></i>';
        html += '   </button> ';
        html += '   <button class="btn btn-danger btn-xs" ';
        html += '     onclick="delData(\'' + data[i].kdtype + '\',\'vesselType\')">';
        html += '     <i class="fa fa-close"></i>';
        html += '   </button>';
        html += ' </td>';
        html += '</tr>';
    }

    $('#idTbodyCert').html(html);
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

                $.getJSON("<?php echo base_url('vesselType/json'); ?>", function(res) {
                    if (res.status) {
                        renderVesselTypeTable(res.data);
                    }
                });

                return;
            }

            $("#idLoading").show();

            $.post(
                "<?php echo base_url('vesselType/json'); ?>", {
                    txtSearch: keyword
                },
                function(res) {
                    if (res.status) {
                        renderVesselTypeTable(res.data);
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
    var txtVesselType = $("#txtVesselType").val().trim();
    var txtDefinition = $("#txtDefinition").val().trim();

    if (txtVesselType === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Warning',
            text: 'Vessel Type cannot be empty!'
        });
        $("#txtVesselType").focus();
        return false;
    }

    var formData = new FormData();
    formData.append('idEdit', idEdit);
    formData.append('txtVesselType', txtVesselType);
    formData.append('txtDefinition', txtDefinition);

    $("#idLoading").show();

    $.ajax({
        url: "<?php echo base_url('vesselType/save'); ?>",
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

                    loadVesselType();

                    $("#txtIdEdit").val('');
                    $("#txtVesselType").val('');
                    $("#txtDefinition").val('');

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

    $.ajax({
        url: '<?php echo base_url("vesselType/get-edit"); ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            idEdit: id,
            type: type
        },
        success: function(response) {

            $("#idLoading").hide();

            if (!response.status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
                return;
            }

            if (!response.data) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Data not found'
                });
                return;
            }

            var data = response.data;

            $("#txtIdEdit").val(data.KdType);
            $("#txtVesselType").val(data.NmType);
            $("#txtDefinition").val(data.DefType);

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

function delData(id, type) {

    Swal.fire({
        title: 'Are you sure?',
        text: "Data will be deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {

        if (result.isConfirmed) {

            $("#idLoading").show();

            $.ajax({
                url: "<?php echo base_url('vesselType/delete'); ?>",
                type: "POST",
                dataType: "json",
                data: {
                    idDel: id,
                    type: type
                },
                success: function(response) {

                    $("#idLoading").hide();

                    if (response.status) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        loadVesselType();
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
                        title: 'Error',
                        text: 'Server error occurred!'
                    });
                }
            });

        }

    });
}
 </script>

 <div class="row" style="margin:18px 0;">
     <div class="col-md-3 col-xs-12">
         <input type="text" id="txtSearch" placeholder="🔍 Search vessel type..." class="form-control input-sm" style="
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
            height:600px;
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
                             Vessel Type
                         </th>
                         <th style="background:#000099;color:#fff;">
                             Definition
                         </th>
                         <th style="width:12%;text-align:center;background:#000099;color:#fff;">
                             Action
                         </th>
                     </tr>
                 </thead>

                 <tbody id="idTbodyCert">
                     <!-- AJAX -->
                 </tbody>

             </table>

         </div>
     </div>


     <!-- FORM -->
     <div class="col-md-4 col-xs-12">
         <div style="
            background:#ffffff;
            padding:26px;
            min-height:420px;
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
                 Vessel Type Form
             </div>

             <!-- Vessel Type -->
             <div class="form-group">
                 <label class="lbl">Vessel Type</label>
                 <input type="text" id="txtVesselType" class="form-control input-sm vessel-input" maxlength="5">
             </div>

             <!-- Definition -->
             <div class="form-group">
                 <label class="lbl">Definition</label>
                 <input type="text" id="txtDefinition" class="form-control input-sm vessel-input">
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