<!-- ============================================================
     ROLE ACCESS MANAGEMENT — Master Data
     Style: konsisten dengan active_roster.php (DataTable + filter ☰ + column search)
     ============================================================ -->

<div class="crew-rotation-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow">
          <div class="card-body">

            <!-- Toolbar -->
            <div class="d-flex justify-content-end align-items-center mb-3">
              <!-- <h6 class="fw-bold mb-0" style="color:#000099;">
                <i class="fas fa-shield-alt me-2"></i>Role Access Management
              </h6> -->
              <button class="btn btn-sm rounded-pill fst-italic fw-semibold shadow-sm"
                      id="btnAddRole"
                      style="background-color:#000099; color:#fff; border-color:#000099;">
                <i class="fa fa-plus me-1"></i> Tambah Role
              </button>
            </div>

            <!-- DataTable -->
            <div class="table-responsive">
              <table id="roleTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                  <tr>
                    <th class="text-center" style="width:50px;">No</th>
                    <th>Role Code <span class="filter-icon">☰</span></th>
                    <th>Role Name <span class="filter-icon">☰</span></th>
                    <th>Deskripsi</th>
                    <th class="text-center">Status <span class="filter-icon">☰</span></th>
                    <th class="text-center">Created At</th>
                    <th class="text-center" style="width:120px;">Action</th>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th></th>
                    <th><input type="text" class="column-search" placeholder="Search..."></th>
                    <th><input type="text" class="column-search" placeholder="Search..."></th>
                    <th><input type="text" class="column-search" placeholder="Search..."></th>
                    <th><input type="text" class="column-search" placeholder="Search..."></th>
                    <th><input type="text" class="column-search" placeholder="Search..."></th>
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

<!-- ============================================================
     MODAL: Tambah / Edit Role
     ============================================================ -->
<div class="modal fade" id="modalRole" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content border-0 shadow">
      <div class="modal-header" style="background: linear-gradient(135deg, #000099 0%, #1a237e 100%); color:#fff;">
        <h6 class="modal-title fw-bold" id="modalRoleTitle">
          <i class="fa fa-shield-alt me-2"></i>Tambah Role
        </h6>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formRole">
          <input type="hidden" id="roleIdInput" name="roleId">
          <div class="mb-3">
            <label class="form-label fw-semibold">Role Code <span class="text-danger">*</span></label>
            <select id="roleCodeInput" name="roleCode"
                    class="form-control selectpicker"
                    data-live-search="true"
                    data-size="8"
                    title="-- Pilih Role Code --"
                    required>
            </select>
            <div class="form-text text-muted">
              <i class="fas fa-info-circle me-1"></i>
              Pilih role code dari daftar. Role code yang sudah dipakai tidak bisa dipilih ulang.
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Role Name <span class="text-danger">*</span></label>
            <input type="text" id="roleNameInput" name="roleName" class="form-control form-control-sm"
                   placeholder="cth: Admin CV, Super Admin">
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Deskripsi</label>
            <textarea id="roleDescInput" name="roleDesc" class="form-control form-control-sm" rows="2"
                      placeholder="Keterangan singkat tentang role ini"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-bs-dismiss="modal">
          <i class="fa fa-times me-1"></i>Batal
        </button>
        <button type="button" class="btn btn-sm rounded-pill fw-semibold" id="btnSaveRole"
                style="background:#000099; color:#fff;">
          <i class="fa fa-save me-1"></i>Simpan
        </button>
      </div>
    </div>
  </div>
</div>

<!-- ============================================================
     MODAL: Permission Matrix — Edit Hak Akses Per Role
     ============================================================ -->
<div class="modal fade" id="modalPermission" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content border-0 shadow">
      <div class="modal-header" style="background: linear-gradient(135deg, #000099 0%, #1a237e 100%); color:#fff;">
        <div>
          <h6 class="modal-title fw-bold mb-0">
            <i class="fas fa-key me-2"></i>Hak Akses Menu
          </h6>
          <small class="opacity-75" id="permModalSubtitle">Loading...</small>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-0" id="permModalBody">

        <!-- Loading state -->
        <div id="permLoading" class="text-center py-5">
          <div class="spinner-border text-primary" style="color:#000099!important;" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
          <p class="mt-2 text-muted small">Memuat data permission...</p>
        </div>

        <!-- Warning Inactive Role -->
        <div id="permInactiveWarning" class="alert alert-warning d-none mx-3 mt-3 mb-0" style="font-size:13px; border-radius:8px; border-left:4px solid #ffc107;">
          <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
          <strong>Role ini sedang tidak aktif.</strong> Hak akses yang diatur di sini tidak akan berlaku/muncul di sisi pengguna hingga Role diaktifkan kembali.
        </div>

        <!-- Content area -->
        <div id="permContent" class="d-none">
          <div class="p-3 border-bottom bg-light d-flex align-items-center justify-content-between">
            <span class="small text-muted fst-italic">
              <i class="fas fa-info-circle me-1"></i>
              Klik toggle untuk langsung menyimpan perubahan hak akses.
            </span>
            <div class="d-flex gap-2 align-items-center">
              <span class="badge bg-success px-3 py-2" style="font-size:11px;">
                <i class="fa fa-toggle-on me-1"></i>Aktif = Boleh Akses
              </span>
              <span class="badge bg-secondary px-3 py-2" style="font-size:11px;">
                <i class="fa fa-toggle-off me-1"></i>Non-aktif = Tidak Boleh
              </span>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0" id="permTable" style="font-size:13px;">
              <thead>
                <tr style="background:#f0f4ff;">
                  <th class="text-center" style="width:50px;">No</th>
                  <th>Menu Utama</th>
                  <th>Sub Menu</th>
                  <th class="text-center" style="width:130px;">Hak Akses</th>
                </tr>
              </thead>
              <tbody id="permTableBody"></tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary rounded-pill" data-bs-dismiss="modal">
          <i class="fa fa-times me-1"></i>Tutup
        </button>
      </div>
    </div>
  </div>
</div>


<!-- ============================================================
     SCRIPTS
     ============================================================ -->
<script>
$(document).ready(function () {

  // ─────────────────────────────────────────────────────────
  // DATATABLES INIT
  // ─────────────────────────────────────────────────────────
  var table = $('#roleTable').DataTable({
    dom: "<'row mb-2'<'col-md-6 d-flex align-items-center'l><'col-md-6 text-end'>>" +
         "<'row'<'col-md-12'tr>>" +
         "<'row mt-2'<'col-md-6'i><'col-md-6 d-flex justify-content-end'p>>",
    processing : true,
    serverSide : false,
    pageLength : 25,
    lengthMenu : [10, 25, 50, 100],
    stateSave  : true,
    stateDuration: -1,
    language   : { lengthMenu: ' _MENU_ &nbsp; Entries', loadingRecords: '' },
    order      : [[2, 'asc']],
    ajax: {
      url     : "<?php echo base_url('hakAkses/getRoles'); ?>",
      type    : 'GET',
      dataSrc : function (json) { return json.status ? json.data : []; }
    },
    columns: [
      // 0 No
      { data: null, className: 'text-center', orderable: false, searchable: false, defaultContent: '' },
      // 1 Role Code
      { data: 'roleCode',
        render: function(d) {
          return '<code style="background:#eef2ff;color:#000099;padding:2px 8px;border-radius:4px;font-size:12px;">'+ d +'</code>';
        }
      },
      // 2 Role Name
      { data: 'roleName' },
      // 3 Deskripsi
      { data: 'roleDesc' },
      // 4 Status
      { data: 'isActive', className: 'text-center',
        render: function(d, type, row) {
          if (type === 'display') {
            var chk = d == 1 ? 'checked' : '';
            var lbl = d == 1
              ? '<span class="badge bg-success" style="font-size:11px;">Aktif</span>'
              : '<span class="badge bg-secondary" style="font-size:11px;">Non-aktif</span>';
            return '<div class="d-flex align-items-center justify-content-center gap-2">'
              + '<div class="form-check form-switch mb-0">'
              + '<input class="form-check-input toggle-role-status" type="checkbox" role="switch" '
              + 'data-role-id="'+ row.roleId +'" '+ chk +' style="width:2.2em;height:1.1em;cursor:pointer;">'
              + '</div>' + lbl + '</div>';
          }
          return d == 1 ? 'Aktif' : 'Non-aktif';
        }
      },
      // 5 Created At
      { data: 'createdAt', className: 'text-center' },
      // 6 Action
      { data: null, orderable: false, searchable: false, className: 'text-center',
        render: function(d, type, row) {
          if (type === 'display') {
            return '<div class="d-flex gap-1 justify-content-center">'
              + '<button class="btn btn-sm btn-outline-primary btn-edit-role" '
              +   'title="Edit Role" data-role-id="'+ row.roleId +'">'
              +   '<i class="fa fa-pencil"></i>'
              + '</button>'
              + '<button class="btn btn-sm btn-outline-warning btn-set-perm" '
              +   'title="Atur Hak Akses" data-role-id="'+ row.roleId +'" data-role-name="'+ row.roleName +'" data-is-active="'+ row.isActive +'">'
              +   '<i class="fas fa-key"></i>'
              + '</button>'
              + '<button class="btn btn-sm btn-outline-danger btn-del-role" '
              +   'title="Hapus Role" data-role-id="'+ row.roleId +'">'
              +   '<i class="fa fa-trash"></i>'
              + '</button>'
              + '</div>';
          }
          return '';
        }
      }
    ],
    initComplete: function () {
      initDropdownFilters(this.api());
    }
  });

  // Row number
  table.on('draw.dt', function () {
    var info = table.page.info();
    table.column(0, { search:'applied', order:'applied', page:'applied' })
         .nodes().each(function (cell, i) { cell.innerHTML = i + 1 + info.start; });
  });

  // Column text search (baris kedua header)
  $('#roleTable thead tr:last th').each(function (i) {
    var inp = $('input', this);
    if (inp.length > 0 && table.state.loaded()) {
      var colState = table.state.loaded().columns[i];
      if (colState && colState.search && colState.search.search && !colState.search.regex) {
        inp.val(colState.search.search);
      }
    }
    inp.on('keyup change', function () {
      if (table.column(i).search() !== this.value) {
        table.column(i).search(this.value).draw();
      }
    });
  });

  // ─────────────────────────────────────────────────────────
  // DROPDOWN FILTER (☰) — sama persis seperti active_roster
  // ─────────────────────────────────────────────────────────
  function initDropdownFilters(api) {
    $('#roleTable thead th').each(function (colIndex) {
      var icon = $(this).find('.filter-icon');
      if (!icon.length) return;
      if (colIndex === 0 || colIndex === 6) return; // skip No & Action

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

  // ─────────────────────────────────────────────────────────
  // TOGGLE STATUS ROLE (langsung save)
  // ─────────────────────────────────────────────────────────
  $(document).on('change', '.toggle-role-status', function () {
    var roleId   = $(this).data('role-id');
    var isActive = $(this).is(':checked') ? 1 : 0;
    var tog      = $(this);

    $.ajax({
      url  : "<?php echo base_url('hakAkses/toggleRole'); ?>",
      type : 'POST',
      data : { roleId: roleId, isActive: isActive },
      success: function (res) {
        if (res.status) {
          Swal.fire({
            toast: true, position: 'top-end', showConfirmButton: false,
            timer: 2000, timerProgressBar: true,
            icon: 'success',
            title: isActive == 1 ? 'Role diaktifkan' : 'Role dinonaktifkan'
          });
          table.ajax.reload(null, false);
        } else {
          Swal.fire({ icon:'error', title:'Gagal', text: res.msg });
          tog.prop('checked', !tog.is(':checked'));
        }
      },
      error: function () {
        Swal.fire({ icon:'error', title:'Error', text:'Koneksi bermasalah.' });
        tog.prop('checked', !tog.is(':checked'));
      }
    });
  });

  // ─────────────────────────────────────────────────────────
  // LOAD ROLE CODE OPTIONS (selectpicker)
  // ─────────────────────────────────────────────────────────
  function loadRoleCodeOptions(selectedCode, isEdit) {
    $.get("<?php echo base_url('hakAkses/getRoleCodes'); ?>", function (res) {
      if (!res.status) return;
      var sel = $('#roleCodeInput');
      sel.empty();
      $.each(res.data, function (i, item) {
        var disabled = '';
        var subtext  = '';
        // Jika edit mode: opsi yang sudah dipakai oleh role LAIN tetap disabled
        // Jika add mode : opsi yang sudah dipakai siapapun disabled
        if (isEdit) {
          // Saat edit, hanya disable yang dipakai role lain (bukan dirinya sendiri)
          if (item.used && item.code !== selectedCode) {
            disabled = ' disabled';
            subtext  = ' data-subtext="Sudah dipakai"';
          }
        } else {
          if (item.used) {
            disabled = ' disabled';
            subtext  = ' data-subtext="Sudah dipakai"';
          }
        }
        var opt = '<option value="'+ item.code +'"'+ disabled + subtext;
        if (item.code === selectedCode) opt += ' selected';
        opt += '>'+ item.label +'</option>';
        sel.append(opt);
      });
      // Refresh selectpicker setelah isi option
      sel.selectpicker('refresh');
    }, 'json');
  }

  // ─────────────────────────────────────────────────────────
  // MODAL TAMBAH ROLE
  // ─────────────────────────────────────────────────────────
  $('#btnAddRole').on('click', function () {
    $('#formRole')[0].reset();
    $('#roleIdInput').val('');
    $('#modalRoleTitle').html('<i class="fa fa-shield-alt me-2"></i>Tambah Role');
    loadRoleCodeOptions('', false);
    var modal = new bootstrap.Modal('#modalRole');
    modal.show();
  });

  // Reset selectpicker saat modal ditutup
  $('#modalRole').on('hidden.bs.modal', function () {
    $('#roleCodeInput').empty().selectpicker('refresh');
  });

  // ─────────────────────────────────────────────────────────
  // MODAL EDIT ROLE
  // ─────────────────────────────────────────────────────────
  $(document).on('click', '.btn-edit-role', function () {
    var roleId = $(this).data('role-id');
    $.get("<?php echo base_url('hakAkses/getRole'); ?>", { roleId: roleId }, function (res) {
      if (res.status) {
        $('#roleIdInput').val(res.data.roleId);
        $('#roleNameInput').val(res.data.roleName);
        $('#roleDescInput').val(res.data.roleDesc);
        $('#modalRoleTitle').html('<i class="fa fa-pencil me-2"></i>Edit Role');
        // Load options dulu, lalu set selected = roleCode miliknya
        // Saat edit, dropdown di-disable agar roleCode tidak bisa diganti
        loadRoleCodeOptions(res.data.roleCode, true);
        $('#roleCodeInput').prop('disabled', true);
        var modal = new bootstrap.Modal('#modalRole');
        modal.show();
      }
    }, 'json');
  });

  // Saat modal Role ditutup, enable kembali roleCode select
  $('#modalRole').on('show.bs.modal', function () {
    $('#roleCodeInput').prop('disabled', false);
  });

  // ─────────────────────────────────────────────────────────
  // SAVE ROLE
  // ─────────────────────────────────────────────────────────
  $('#btnSaveRole').on('click', function () {
    var roleCode = $('#roleCodeInput').val().trim();
    var roleName = $('#roleNameInput').val().trim();

    if (!roleCode || !roleName) {
      Swal.fire({ icon:'warning', title:'Validasi', text:'Role Code dan Role Name wajib diisi.' });
      return;
    }

    var btn = $(this).html('<i class="fa fa-spinner fa-spin me-1"></i>Menyimpan...').prop('disabled', true);

    $.post("<?php echo base_url('hakAkses/saveRole'); ?>", $('#formRole').serialize(), function (res) {
      btn.html('<i class="fa fa-save me-1"></i>Simpan').prop('disabled', false);
      if (res.status) {
        bootstrap.Modal.getInstance('#modalRole').hide();
        Swal.fire({ icon:'success', title:'Berhasil', text: res.msg, timer:1800, showConfirmButton:false });
        table.ajax.reload(null, false);
      } else {
        Swal.fire({ icon:'error', title:'Gagal', text: res.msg });
      }
    }, 'json').fail(function () {
      btn.html('<i class="fa fa-save me-1"></i>Simpan').prop('disabled', false);
      Swal.fire({ icon:'error', title:'Error', text:'Koneksi bermasalah.' });
    });
  });

  // ─────────────────────────────────────────────────────────
  // HAPUS ROLE
  // ─────────────────────────────────────────────────────────
  $(document).on('click', '.btn-del-role', function () {
    var roleId = $(this).data('role-id');
    Swal.fire({
      title: 'Hapus Role?',
      text : 'Role ini dan semua permission-nya akan dihapus permanen!',
      icon : 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor : '#6c757d',
      confirmButtonText : 'Ya, Hapus!',
      cancelButtonText  : 'Batal'
    }).then(function (result) {
      if (result.isConfirmed) {
        $.post("<?php echo base_url('hakAkses/deleteRole'); ?>", { roleId: roleId }, function (res) {
          if (res.status) {
            Swal.fire({ icon:'success', title:'Dihapus!', text: res.msg, timer:1800, showConfirmButton:false });
            table.ajax.reload(null, false);
          } else {
            Swal.fire({ icon:'error', title:'Gagal', text: res.msg });
          }
        }, 'json');
      }
    });
  });

  // ─────────────────────────────────────────────────────────
  // MODAL PERMISSION — Klik tombol kunci (🔑)
  // ─────────────────────────────────────────────────────────
  $(document).on('click', '.btn-set-perm', function () {
    var roleId   = $(this).data('role-id');
    var roleName = $(this).data('role-name');
    var isActive = $(this).data('is-active');

    $('#permModalSubtitle').text('Role: ' + roleName);
    
    if (isActive == 0) {
      $('#permInactiveWarning').removeClass('d-none');
    } else {
      $('#permInactiveWarning').addClass('d-none');
    }

    $('#permLoading').removeClass('d-none');
    $('#permContent').addClass('d-none');

    var modal = new bootstrap.Modal('#modalPermission');
    modal.show();

    $.get("<?php echo base_url('hakAkses/getPermissions'); ?>", { roleId: roleId }, function (res) {
      if (!res.status) {
        Swal.fire({ icon:'error', title:'Gagal', text: res.msg });
        return;
      }
      renderPermissionTable(res.menus, res.subMenus, roleId);
      $('#permLoading').addClass('d-none');
      $('#permContent').removeClass('d-none');
    }, 'json').fail(function () {
      Swal.fire({ icon:'error', title:'Error', text:'Gagal memuat permission.' });
    });
  });

  // ─────────────────────────────────────────────────────────
  // RENDER TABEL PERMISSION
  // ─────────────────────────────────────────────────────────
  function renderPermissionTable(menus, subMenus, roleId) {
    var tbody = $('#permTableBody');
    tbody.empty();
    var no = 1;

    // Buat map subMenu per menuId
    var subMap = {};
    subMenus.forEach(function (sm) {
      if (!subMap[sm.menuId]) subMap[sm.menuId] = [];
      subMap[sm.menuId].push(sm);
    });

    menus.forEach(function (menu) {
      // Baris menu utama
      tbody.append(buildMenuRow(no++, menu, roleId));

      // Baris sub-menu (jika ada)
      if (menu.hasSubMenu == 1 && subMap[menu.menuId]) {
        subMap[menu.menuId].forEach(function (sm) {
          tbody.append(buildSubMenuRow(no++, sm, menu.menuName, roleId));
        });
      }
    });
  }

  function buildMenuRow(no, menu, roleId) {
    var chk    = menu.canAccess == 1 ? 'checked' : '';
    var badge  = menu.canAccess == 1
      ? '<span class="badge bg-success toggle-label" style="font-size:10px;">Boleh</span>'
      : '<span class="badge bg-secondary toggle-label" style="font-size:10px;">Tidak</span>';
    var iconHtml = menu.menuIcon
      ? '<i class="'+ menu.menuIcon +' me-1 text-primary"></i>'
      : '<i class="fas fa-bars me-1 text-muted"></i>';
    return '<tr class="table-light">'
      + '<td class="text-center fw-bold" style="font-size:11px;">'+ no +'</td>'
      + '<td colspan="2"><span class="fw-bold">'+ iconHtml + menu.menuName +'</span>'
      +   '<span class="badge bg-primary ms-2" style="font-size:9px;">Menu Utama</span></td>'
      + '<td class="text-center">'
      +   '<div class="d-flex align-items-center justify-content-center gap-2">'
      +     '<div class="form-check form-switch mb-0">'
      +       '<input class="form-check-input toggle-perm" type="checkbox" role="switch"'
      +         ' data-role-id="'+ roleId +'"'
      +         ' data-menu-id="'+ menu.menuId +'"'
      +         ' data-sub-menu-id=""'
      +         ' style="width:2.4em;height:1.2em;cursor:pointer;" '+ chk +'>'
      +     '</div>'
      +     badge
      +   '</div>'
      + '</td>'
      + '</tr>';
  }

  function buildSubMenuRow(no, sm, parentName, roleId) {
    var chk   = sm.canAccess == 1 ? 'checked' : '';
    var badge = sm.canAccess == 1
      ? '<span class="badge bg-success toggle-label" style="font-size:10px;">Boleh</span>'
      : '<span class="badge bg-secondary toggle-label" style="font-size:10px;">Tidak</span>';
    return '<tr>'
      + '<td class="text-center" style="font-size:11px;">'+ no +'</td>'
      + '<td class="text-muted ps-4" style="font-size:12px;">↳ '+ parentName +'</td>'
      + '<td style="font-size:12px;"><i class="fas fa-angle-right me-1 text-muted"></i>'+ sm.subMenuName +'</td>'
      + '<td class="text-center">'
      +   '<div class="d-flex align-items-center justify-content-center gap-2">'
      +     '<div class="form-check form-switch mb-0">'
      +       '<input class="form-check-input toggle-perm" type="checkbox" role="switch"'
      +         ' data-role-id="'+ roleId +'"'
      +         ' data-menu-id=""'
      +         ' data-sub-menu-id="'+ sm.subMenuId +'"'
      +         ' style="width:2.4em;height:1.2em;cursor:pointer;" '+ chk +'>'
      +     '</div>'
      +     badge
      +   '</div>'
      + '</td>'
      + '</tr>';
  }

  // ─────────────────────────────────────────────────────────
  // TOGGLE PERMISSION — AUTO SAVE + ALERT
  // ─────────────────────────────────────────────────────────
  $(document).on('change', '.toggle-perm', function () {
    var tog       = $(this);
    var roleId    = tog.data('role-id');
    var menuId    = tog.data('menu-id')     || '';
    var subMenuId = tog.data('sub-menu-id') || '';
    var canAccess = tog.is(':checked') ? 1 : 0;
    var label     = tog.closest('td').find('.toggle-label');

    // Disable sementara saat proses
    tog.prop('disabled', true);

    $.ajax({
      url  : "<?php echo base_url('hakAkses/updatePermission'); ?>",
      type : 'POST',
      data : { roleId: roleId, menuId: menuId, subMenuId: subMenuId, canAccess: canAccess },
      success: function (res) {
        tog.prop('disabled', false);
        if (res.status) {
          // Update label badge tanpa reload
          if (canAccess == 1) {
            label.removeClass('bg-secondary').addClass('bg-success').text('Boleh');
          } else {
            label.removeClass('bg-success').addClass('bg-secondary').text('Tidak');
          }
          // Toast notification
          Swal.fire({
            toast: true, position: 'top-end', showConfirmButton: false,
            timer: 1500, timerProgressBar: true,
            icon: 'success',
            title: canAccess == 1 ? '✓ Akses diberikan' : '✓ Akses dicabut'
          });
        } else {
          Swal.fire({ icon:'error', title:'Gagal', text: res.msg, timer: 2000, showConfirmButton: false });
          tog.prop('checked', !tog.is(':checked')); // rollback
        }
      },
      error: function () {
        tog.prop('disabled', false).prop('checked', !tog.is(':checked'));
        Swal.fire({ icon:'error', title:'Error', text:'Koneksi bermasalah.', timer: 2000, showConfirmButton: false });
      }
    });
  });

});
</script>


<!-- ============================================================
     STYLES — Konsisten dengan active_roster.php
     ============================================================ -->
<style>
:root {
  --crew-blue: #000099;
  --crew-font-sm: 12px;
  --crew-font-xs: 11px;
}

.crew-table th, .crew-table td {
  font-size: var(--crew-font-sm);
  vertical-align: middle;
}
.crew-table th { font-weight: 600; text-align: center; }
.crew-table .btn { font-size: var(--crew-font-xs); padding: 2px 6px; }

.crew-header th {
  background-color: var(--crew-blue) !important;
  color: #fff !important;
}

/* DataTables controls */
.dataTables_wrapper { padding: 15px 0; }
.dataTables_length label, .dataTables_filter label {
  display: flex; align-items: center; margin: 0; padding: 20px 0;
}
.dataTables_length select {
  width: auto; margin: 0 8px; padding: 4px 8px;
  border-radius: 4px; border: 1px solid #ced4da;
}
.dataTables_filter { text-align: right; margin-bottom: 10px; }
.dataTables_filter input {
  margin-left: 10px; padding: 6px 12px;
  border-radius: 4px; border: 1px solid #ced4da; width: 200px;
}

/* Pagination */
.dataTables_paginate { margin-top: 15px; padding-top: 10px; border-top: 1px solid #dee2e6; }
.paginate_button {
  margin: 0 2px; padding: 6px 12px !important;
  border-radius: 4px; border: 1px solid #dee2e6;
  background: #fff !important; color: #0d6efd !important;
}
.paginate_button.current {
  background: var(--crew-blue) !important;
  color: #fff !important; border-color: var(--crew-blue) !important;
}
.paginate_button:hover { background: #e9ecef !important; }

/* Info */
.dataTables_info { padding: 10px 0; color: #6c757d; font-size: 14px; }

/* Filter icon */
.filter-icon { cursor: pointer; font-size: 14px; margin-left: 6px; color: #aac4ff; }
.filter-icon:hover { color: #fff; }

/* Dropdown filter */
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

/* Column search */
.column-search {
  width: 100%; padding: 6px 8px; box-sizing: border-box;
  font-size: 12px; border: 1px solid #dee2e6;
  border-radius: 4px; background: #f8f9fa;
}

/* Clear filter button */
.btn-clear-filter {
  background: transparent; border: 1.5px solid #000099;
  color: #000099; transition: all .2s ease;
}
.btn-clear-filter:hover { background: #000099; color: #fff; }
.btn-clear-filter i { font-size: 14px; }

/* Card */
.card { margin-top: 20px; border-radius: 8px; }
.card-body { padding: 20px; overflow-x: auto; }
.table-responsive { margin: 0; }

/* Permission table */
#permTable th {
  background: #f0f4ff;
  color: #000099;
  font-size: 12px;
  font-weight: 700;
}
#permTable td { font-size: 12px; }
#permTable tr.table-light td { background: #f8f9ff !important; }

/* Toggle switch color override */
.form-check-input:checked { background-color: #198754 !important; border-color: #198754 !important; }

/* DT float fix */
.dt-info { float: left; margin-top: 10px; }
.dt-paging { float: right; margin-top: 10px; }
.dataTables_wrapper:after { content: ""; display: table; clear: both; }
</style>
