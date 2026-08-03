
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

<div class="crew-rotation-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow">
          <div class="card-body">
            <!-- Toolbar -->
            <div class="d-flex justify-content-end align-items-center mb-3">
              <button class="btn btn-sm rounded-pill fst-italic fw-semibold shadow-sm"
                      onclick="showAddModal()"
                      style="background-color:#000099; color:#fff; border-color:#000099;">
                <i class="fa fa-plus me-1"></i> Tambah Role
              </button>
            </div>
            <!-- DataTable -->
            <div class="table-responsive">
              <table id="userRoleTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                  <tr>
                    <th class="text-center" style="width:50px;">No</th>
                    <th>Role Code <span class="filter-icon">☰</span></th>
                    <th>Role Name <span class="filter-icon">☰</span></th>
                    <th>Description</th>
                    <th class="text-center">Status <span class="filter-icon">☰</span></th>
                    <th class="text-center" style="width:120px;">Action</th>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th></th>
                    <th><input type="text" class="column-search" placeholder="Search..."></th>
                    <th><input type="text" class="column-search" placeholder="Search..."></th>
                    <th><input type="text" class="column-search" placeholder="Search..."></th>
                    <th>
                        <select class="column-search">
                            <option value="">All</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </th>
                    <th></th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="roleModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content border-0 shadow">
      <div class="modal-header" style="background: linear-gradient(135deg, #000099 0%, #1a237e 100%); color:#fff;">
        <h6 class="modal-title fw-bold" id="modalTitle">
          <i class="fa fa-users-cog me-2"></i>Add Role
        </h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
            <form id="roleForm">
                <div class="modal-body">
                    <input type="hidden" name="roleId" id="roleId">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="roleCode" id="roleCode" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="roleName" id="roleName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea class="form-control form-control-sm" name="roleDesc" id="roleDesc" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" id="isActive" name="isActive" value="1" checked>
                            <label class="form-check-label" for="isActive">Active Status</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-bs-dismiss="modal">
                      <i class="fa fa-times me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-sm rounded-pill fw-semibold" id="btnSave"
                            style="background:#000099; color:#fff;">
                      <i class="fa fa-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
var table;
$(document).ready(function() {
    table = $('#userRoleTable').DataTable({
        dom: "<'row mb-2'<'col-md-6 d-flex align-items-center'l><'col-md-6 text-end'>>" +
             "<'row'<'col-md-12'tr>>" +
             "<'row mt-2'<'col-md-6'i><'col-md-6 d-flex justify-content-end'p>>",
        processing : true,
        serverSide : false,
        pageLength : 25,
        lengthMenu : [10, 25, 50, 100],
        ajax: {
            url: '<?php echo base_url("MenuRole/UserRole/getAllData") ?>',
            dataSrc: function(json) { return json.data ? json.data : []; }
        },
        orderCellsTop: true,
        columns: [
            { data: null, className: 'text-center', render: function(data, type, row, meta) { return meta.row + 1; } },
            { data: 'roleCode' },
            { data: 'roleName' },
            { data: 'roleDesc' },
            { data: 'isActive', className: 'text-center', render: function(data) {
                return data == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
            }},
            { data: 'roleId', className: 'text-center', render: function(data) {
                return `<button class="btn btn-sm text-white me-1" style="background:#000099;" onclick="editData(${data})"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger" onclick="deleteData(${data})"><i class="fas fa-trash"></i></button>`;
            }}
        ],
        initComplete: function () {
            initDropdownFilters(this.api());
        }
    });

    // Column search
    $('#userRoleTable thead tr:eq(1) .column-search').on('keyup change', function() {
        table.column($(this).parent().index()).search(this.value).draw();
    });

    $('#roleForm').on('submit', function(e) {
        e.preventDefault();
        $('#btnSave').prop('disabled', true).text('Saving...');
        $.ajax({
            url: '<?php echo base_url("MenuRole/UserRole/save") ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                $('#btnSave').prop('disabled', false).text('Save');
                if (res.status == 'success') {
                    $('#roleModal').modal('hide');
                    table.ajax.reload();
                    Swal.fire('Success', res.message, 'success');
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            },
            error: function() {
                $('#btnSave').prop('disabled', false).text('Save');
                Swal.fire('Error', 'Server error', 'error');
            }
        });
    });
});

function initDropdownFilters(api) {
    $('#userRoleTable thead th').each(function (colIndex) {
        var icon = $(this).find('.filter-icon');
        if (!icon.length) return;
        if (colIndex === 0 || colIndex === 5) return; // skip No & Action

        var dropdown = $('<div class="filter-dropdown">'
            + '<input type="text" class="filter-search" placeholder="Search...">'
            + '<div class="filter-list"></div>'
            + '<hr>'
            + '<div class="d-flex gap-2 text-center">'
            + '<button class="btn btn-sm w-30 rounded-pill fst-italic btn-clear-filter" id="clear-filter">'
            + '<i class="fa-solid fa-eraser"></i>'
            + '</button>'
            + '</div>'
            + '</div>').appendTo('body');

        var listContainer = dropdown.find('.filter-list');

        // Isi pilihan unik dari kolom
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
                    var safeVal = String(val).replace(/</g, '&lt;').replace(/>/g, '&gt;');
                    listContainer.append('<label><input type="checkbox" value="'+ safeVal +'"> '+ safeVal +'</label>');
                });
            }
        } catch(e) { console.warn('Filter error col '+ colIndex, e); }

        // Toggle dropdown
        icon.on('click', function (e) {
            e.stopPropagation();
            $('.filter-dropdown').hide();
            var off = icon.offset();
            dropdown.css({ top: off.top + icon.outerHeight(), left: off.left }).toggle();
        });

        // Search dalam dropdown
        dropdown.find('.filter-search').on('keyup', function () {
            var kw = $(this).val().toLowerCase();
            listContainer.find('label').each(function () {
                $(this).toggle($(this).text().toLowerCase().includes(kw));
            });
        });

        // Checkbox change
        dropdown.on('change', 'input[type="checkbox"]', function () {
            var selected = [];
            dropdown.find('input[type="checkbox"]:checked').each(function () { selected.push($(this).val()); });
            if (selected.length > 0) {
                var regex = selected.map(function(v){ return v.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); }).join('|');
                api.column(colIndex).search(regex, true, false).draw();
            } else {
                api.column(colIndex).search('').draw();
            }
            dropdown.hide();
        });

        // Clear
        dropdown.on('click', '.btn-clear-filter', function () {
            dropdown.find('input').prop('checked', false);
            dropdown.find('.filter-search').val('');
            listContainer.find('label').show();
            api.column(colIndex).search('').draw();
            dropdown.hide();
        });
    });
}

$(document).on('click', function (e) {
    if (!$(e.target).closest('.filter-dropdown').length) $('.filter-dropdown').hide();
});

function showAddModal() {
    $('#roleForm')[0].reset();
    $('#roleId').val('');
    $('#isActive').prop('checked', true);
    $('#modalTitle').text('Add Role');
    $('#roleModal').modal('show');
}

function editData(id) {
    $.post('<?php echo base_url("MenuRole/UserRole/getById") ?>', {id: id}, function(res) {
        if (res.status == 'success') {
            $('#roleForm')[0].reset();
            $('#roleId').val(res.data.roleId);
            $('#roleCode').val(res.data.roleCode);
            $('#roleName').val(res.data.roleName);
            $('#roleDesc').val(res.data.roleDesc);
            $('#isActive').prop('checked', res.data.isActive == 1);
            $('#modalTitle').text('Edit Role');
            $('#roleModal').modal('show');
        }
    }, 'json');
}

function deleteData(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('<?php echo base_url("MenuRole/UserRole/delete") ?>', {id: id}, function(res) {
                if(res.status == 'success') {
                    table.ajax.reload();
                    Swal.fire('Deleted!', res.message, 'success');
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            }, 'json');
        }
    });
}
</script>
