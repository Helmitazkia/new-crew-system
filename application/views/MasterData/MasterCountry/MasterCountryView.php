<script type="text/javascript">
$(document).ready(function() {});

$(document).ready(function() {
    loadDataCountry();
});

function loadDataCountry() {
    $.ajax({
        url: "<?php echo base_url('country/getDataCountry'); ?>",
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (res.status) {
                renderCountryTable(res.data);
            }
        }
    });
}

function renderCountryTable(data) {

    var html = '';

    if (data.length === 0) {
        html = '<tr><td colspan="3" class="text-center">No data found</td></tr>';
        $('#idTbodyCert').html(html);
        return;
    }

    for (var i = 0; i < data.length; i++) {

        html += '<tr>';
        html += ' <td style="font-size:11px;text-align:center;">' + data[i].no + '</td>';
        html += ' <td style="font-size:11px;">' + data[i].name + '</td>';
        html += ' <td style="font-size:11px;text-align:center;">';
        html += '   <button class="btn btn-success btn-xs" ';
        html += '     onclick="getDataEdit(\'' + data[i].id + '\',\'country\')">';
        html += '     <i class="fa fa-edit"></i>';
        html += '   </button> ';
        html += '   <button class="btn btn-danger btn-xs" ';
        html += '     onclick="delData(\'' + data[i].id + '\',\'country\')">';
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
                $.getJSON("<?php echo base_url('country/getDataCountry'); ?>", function(res) {
                    if (res.status) {
                        renderCountryTable(res.data);
                    }
                });
                return;
            }

            $("#idLoading").show();

            $.post(
                "<?php echo base_url('country/getDataCountry'); ?>", {
                    search: 'search',
                    txtSearch: keyword
                },
                function(res) {
                    if (res.status) {
                        renderCountryTable(res.data);
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
    var txtCountry = $("#txtCountry").val().trim();

    if (txtCountry === '') {
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Country Name tidak boleh kosong'
        });
        $("#txtCountry").focus();
        return;
    }

    $("#idLoading").show();

    $.post(
        "<?php echo base_url('country/save'); ?>", {
            idEdit: idEdit,
            txtCountry: txtCountry
        },
        function(res) {

            $("#idLoading").hide();

            if (!res.status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: res.message
                });
                return;
            }

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: res.message,
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                loadDataCountry();
                $("#txtCountry").val('');
            });

        },
        'json'
    );
}


function getDataEdit(id, type) {


    $("#idLoading").show();

    $.post(
        "<?php echo base_url('country/get-edit'); ?>", {
            idEdit: id,
            type: 'country'
        },
        function(res) {

            if (!res.status) {
                alert(res.message || 'Data tidak ditemukan');
                $("#idLoading").hide();
                return;
            }

            var data = res.data;

            $("#txtIdEdit").val(data.KdNegara);
            $("#txtCountry").val(data.NmNegara);

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
                "<?php echo base_url('country/delete'); ?>", {
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
        <input type="text" id="txtSearch" placeholder="🔍 Search country..." class="form-control input-sm" style="
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
                        <th style="width:6%;text-align:center;background:#000099 !important;color:#ffffff !important;">
                            No</th>
                        <th style="width:64%;font-weight:600;background:#000099 !important;color:#ffffff !important;">
                            Country Name</th>
                        <th
                            style="width:30%;text-align:center;background:#000099 !important;color:#ffffff !important;font-weight:600;">
                            Action</th>
                    </tr>
                </thead>

                <tbody id="idTbodyCert">
                    <!-- ajax -->
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
                color:#1f2d3d;
            ">
                Country Form
            </div>

            <div style="margin-bottom:26px;">
                <label style="
                    font-weight:600;
                    font-size:13px;
                    color:#475569;
                    margin-bottom:8px;
                    display:block;
                ">
                    Country Name
                </label>

                <input type="text" id="txtCountry" placeholder="Type country name" class="form-control input-sm" style="
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