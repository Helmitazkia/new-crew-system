
<style>
  .crew-header th {
    background-color: #000099 !important;
    color: white !important;
    font-size: 13px;
    vertical-align: middle;
  }
  .column-search {
    width: 100%;
    padding: 2px 4px;
    font-size: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  .filter-icon {
    font-size: 14px;
    margin-left: 5px;
    cursor: pointer;
    color: #aac4ff;
  }
  .filter-icon:hover { color: #fff; }
  .filter-dropdown {
    position: absolute; background: #fff; border: 1px solid #ccc;
    padding: 8px; width: 200px; max-height: 260px; overflow-y: auto;
    box-shadow: 0 4px 10px rgba(0,0,0,.2); display: none; z-index: 9999;
  }
  .filter-dropdown input[type="text"] {
    width: 100%; margin-bottom: 6px; padding: 4px; font-size: 12px;
    border: 1px solid #dee2e6; border-radius: 4px;
  }
  .filter-dropdown label {
    display: block; font-size: 13px; cursor: pointer;
    padding: 4px 8px; margin: 2px 0; border-radius: 4px;
  }
  .filter-dropdown label:hover { background: #f8f9fa; }
  .filter-list { max-height: 120px; overflow-y: auto; margin-bottom: 6px; }
  .btn-clear-filter {
    background: transparent; border: 1.5px solid #000099;
    color: #000099; transition: all .2s ease;
  }
  .btn-clear-filter:hover { background: #000099; color: #fff; }
  .btn-clear-filter i { font-size: 14px; }
</style>

<script type="text/javascript">
var tableUser;

$(document).ready(function() {
    loadRoles();
    
    tableUser = $('#userSystemTable').DataTable({
        dom: "<'row mb-2'<'col-md-6 d-flex align-items-center'l><'col-md-6 text-end'f>>" +
             "<'row'<'col-md-12'tr>>" +
             "<'row mt-2'<'col-md-6'i><'col-md-6 d-flex justify-content-end'p>>",
        processing : true,
        serverSide : false,
        pageLength : 10,
        lengthMenu : [10, 25, 50, 100],
        ajax: {
            url: "<?php echo base_url('getMasterUserSystem'); ?>",
            type: "GET",
            dataSrc: function(json) { return json.data ? json.data : []; }
        },
        orderCellsTop: true,
        columns: [
            { data: 'no', className: 'text-center' },
            { data: 'userName' },
            { data: 'fullName' },
            { data: 'password', render: function() { return '********'; } },
            { data: 'jenis' },
            { data: 'init' },
            { data: null, className: 'text-center', render: function(data, type, row) {
                return '<button class="btn btn-success btn-xs" onclick="getDataEdit(\'' + row.id + '\',\'userSystem\')"><i class="fa fa-edit"></i></button> ' +
                       '<button class="btn btn-danger btn-xs" onclick="delData(\'' + row.id + '\',\'userSystem\')"><i class="fa fa-close"></i></button>';
            }}
        ],
        initComplete: function () {
            initDropdownFilters(this.api());
        },
        language: {
            lengthMenu: '_MENU_ &nbsp;Entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            infoEmpty: 'Showing 0 to 0 of 0 entries',
            infoFiltered: '(filtered from _MAX_ total entries)',
            search: 'Search:',
            emptyTable: 'Tidak ada data User System',
            zeroRecords: 'Data tidak ditemukan'
        }
    });

    // Column search
    $('#userSystemTable thead tr:eq(1) .column-search').on('keyup change', function() {
        tableUser.column($(this).parent().index()).search(this.value).draw();
    });
});

function loadRoles() {
    $.ajax({
        url: "<?php echo base_url('getRolesOption'); ?>",
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (res.status && res.data) {
                var html = '<option value="">-- Pilih User Jenis --</option>';
                for (var i = 0; i < res.data.length; i++) {
                    html += '<option value="' + res.data[i].roleCode + '">' + res.data[i].roleName + ' (' + res.data[i].roleCode + ')</option>';
                }
                $('#txtuserjenis').html(html);
            }
        }
    });
}

function initDropdownFilters(api) {
    $('#userSystemTable thead th').each(function (colIndex) {
        var icon = $(this).find('.filter-icon');
        if (!icon.length) return;
        
        var dropdown = $('<div class="filter-dropdown">'
            + '<input type="text" class="filter-search" placeholder="Search...">'
            + '<div class="filter-list"></div>'
            + '<hr style="margin: 6px 0;">'
            + '<div class="d-flex gap-2 text-center">'
            + '<button class="btn btn-sm w-100 rounded-pill fst-italic btn-clear-filter" id="clear-filter">'
            + '<i class="fa fa-eraser"></i> Clear'
            + '</button>'
            + '</div>'
            + '</div>').appendTo('body');

        var listContainer = dropdown.find('.filter-list');

        try {
            var colData = api.column(colIndex).data();
            if (colData && typeof colData.unique === 'function') {
                var uniqueVals = [];
                colData.unique().each(function (val) {
                    if (val && val !== '-' && val !== '') {
                        var tempDiv = document.createElement('div');
                        tempDiv.innerHTML = val;
                        var text = tempDiv.textContent || tempDiv.innerText || '';
                        if (text && !uniqueVals.includes(text)) uniqueVals.push(text);
                    }
                });

                uniqueVals.sort().forEach(function (val) {
                    var safeVal = val.replace(/"/g, '&quot;');
                    listContainer.append('<label><input type="checkbox" value="' + safeVal + '"> ' + val + '</label>');
                });
            }
        } catch (e) { console.error("Error populating filter:", e); }

        icon.on('click', function (e) {
            e.stopPropagation();
            $('.filter-dropdown').not(dropdown).hide();
            var offset = $(this).offset();
            dropdown.css({
                top: offset.top + 20,
                left: offset.left
            }).toggle();
        });

        dropdown.find('.filter-search').on('keyup', function () {
            var searchTerm = $(this).val().toLowerCase();
            listContainer.find('label').each(function () {
                var text = $(this).text().toLowerCase();
                $(this).toggle(text.indexOf(searchTerm) > -1);
            });
        });

        dropdown.find('input[type="checkbox"]').on('change', function () {
            var selected = [];
            listContainer.find('input:checked').each(function () {
                selected.push('^' + $.fn.dataTable.util.escapeRegex($(this).val()) + '$');
            });
            var regex = selected.join('|');
            api.column(colIndex).search(regex ? regex : '', true, false).draw();
        });

        dropdown.find('.btn-clear-filter').on('click', function () {
            listContainer.find('input[type="checkbox"]').prop('checked', false);
            dropdown.find('.filter-search').val('').trigger('keyup');
            api.column(colIndex).search('').draw();
        });

        dropdown.on('click', function (e) { e.stopPropagation(); });
    });

    $(document).on('click', function () {
        $('.filter-dropdown').hide();
    });
}

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
                    tableUser.ajax.reload(null, false);

                    $("#txtIdEdit").val('');
                    $("#txtusername").val('');
                    $("#txtuserfullname").val('');
                    $("#txtuserpassword").val('');
                    $("#txtuserjenis").val('');
                    $("#txtuserinit").val('');
                    $("#txtuserpassword").attr("placeholder", "User Password");
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
            
            // Do not fill password hash into the edit input
            $("#txtuserpassword").val("");
            $("#txtuserpassword").attr("placeholder", "Kosongkan jika tidak ingin mengubah password");
            
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
                        tableUser.ajax.reload(null, false);
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

function reloadPage() {
    window.location.reload();
}
</script>

<div class="row" style="margin:18px 0;">
    <div class="col-md-8 col-xs-12">
        <div style="
            background:#fff;
            border-radius:14px;
            border:1px solid #e3e6ea;
            box-shadow:0 4px 14px rgba(0,0,0,0.06);
            padding: 20px;
        ">
            <div class="table-responsive">
                <table id="userSystemTable" class="table table-bordered table-hover table-condensed" style="margin-bottom:0;font-size:13px; width:100%">
                    <thead class="crew-header">
                        <tr style="background:#000099; color:#fff;">
                            <th style="width:5%;text-align:center;">No</th>
                            <th>Username <span class="filter-icon">☰</span></th>
                            <th>Full Name <span class="filter-icon">☰</span></th>
                            <th>Password</th>
                            <th>User Jenis <span class="filter-icon">☰</span></th>
                            <th>User Init <span class="filter-icon">☰</span></th>
                            <th style="width:10%;text-align:center;">Action</th>
                        </tr>
                       </thead>
                    <thead>
                        <tr style="background:#f1f4f7;">
                            <th></th>
                            <th><input type="text" class="column-search" placeholder="Search..."></th>
                            <th><input type="text" class="column-search" placeholder="Search..."></th>
                            <th></th>
                            <th><input type="text" class="column-search" placeholder="Search..."></th>
                            <th><input type="text" class="column-search" placeholder="Search..."></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables -->
                    </tbody>
                </table>
            </div>
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

                <select id="txtuserjenis" class="form-control input-sm" style="
                        padding:12px 14px;
                        border-radius:12px;
                        border:1px solid #cbd5e1;
                        font-size:13px;
                        height: 45px;
                    ">
                    <option value="">-- Pilih User Jenis --</option>
                </select>
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