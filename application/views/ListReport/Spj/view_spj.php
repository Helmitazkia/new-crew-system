<div class="card shadow-sm border-0" id="spjModuleWrapper">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-primary btn-sm" id="btnAddSpj" style="background-color: #000999; border-color: #000999;">
                <i class="fa fa-plus me-1"></i> Add SPJ
            </button>
        </div>
        <div class="table-responsive">
            <table id="spjTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                    <tr>
                        <th class="text-center" style="width:50px;">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Jabatan</th>
                        <th class="text-center">Tujuan</th>
                        <th class="text-center">Tgl Berangkat</th>
                        <th class="text-center">Tgl Dibuat</th>
                        <th class="text-center" style="width:130px;">Action</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th></th>
                        <th><input type="text" class="column-search" placeholder="Search"></th>
                        <th><input type="text" class="column-search" placeholder="Search"></th>
                        <th><input type="text" class="column-search" placeholder="Search"></th>
                        <th><input type="text" class="column-search" placeholder="Search"></th>
                        <th><input type="text" class="column-search" placeholder="Search"></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============================================================
     MODAL: Add SPJ
     ============================================================ -->
<div class="modal fade" id="modalSPJ" tabindex="-1" aria-labelledby="modalSuratLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <form id="formAddSpj" class="modal-content border-0 shadow">
      
      <!-- Header -->
      <div class="modal-header" style="background: linear-gradient(135deg, #000099 0%, #1a237e 100%); color: #fff;">
          <h6 class="modal-title fw-bold" id="modalSuratLabel">
              <i class="fa fa-file-text-o me-2"></i>Tambah SPJ (Surat Perintah Jalan)
          </h6>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1) grayscale(100%) brightness(200%);"></button>
      </div>

      <div class="modal-body" style="padding:40px; font-size:13px; line-height:1.4; overflow-y: auto;">

        <table style="width:100%; border-collapse:collapse;">
          <tr>
            <td style="width:80px; text-align:left; vertical-align:top;">
              <img src="<?php echo base_url('assets/img/Logo_Andhika_2017.jpg'); ?>" alt="Logo"
                style="width:80px; height:auto;">
            </td>
            <td style="text-align:center;">
              <div style="font-size:16px; font-weight:bold;">SURAT PERINTAH JALAN</div>
              <div style="font-size:12px; font-style:italic;">(Official Travel Letter)</div>
            </td>
            <td style="width:80px;"></td>
          </tr>
        </table>

        <div style="height:20px;"></div>

        <table style="width:100%; border-collapse:collapse; font-size:13px;">
          <tr>
            <td style="width:150px; vertical-align:top;">Berdasarkan<br><i>(Base on)</i></td>
            <td style="width:10px; vertical-align:top;">:</td>
            <td style="vertical-align:top;">
              <input type="text" id="base_on" name="base_on" class="form-control" value="Kepentingan Perusahaan"
                style="width:100%; border:1px solid #ccc; padding:4px; font-size:13px;">
              <div style="font-size:11px; font-style:italic;">(Company Occupation)</div>
            </td>
          </tr>

          <tr>
            <td style="vertical-align:top;">Diberikan perintah kepada<br><i>(Given to)</i></td>
            <td style="vertical-align:top;">:</td>
            <td style="vertical-align:top;">
              <table style="border-collapse:collapse; margin-top:4px; width:100%;">
                <tr>
                  <td style="width:150px;">Nama <i>(Name)</i></td>
                  <td style="width:10px;">:</td>
                  <td><input type="text" id="crew_name" name="name" class="form-control"
                      style="width:100%; border:1px solid #ccc; padding:4px; background-color: #e9ecef;" readonly></td>
                </tr>
                <tr>
                  <td>Jabatan <i>(Rank)</i></td>
                  <td>:</td>
                  <td><input type="text" id="crew_rank" name="rank" class="form-control"
                      style="width:100%; border:1px solid #ccc; padding:4px; background-color: #e9ecef;" readonly></td>
                </tr>
                <tr>
                  <td>Tujuan <i>(Destination)</i></td>
                  <td>:</td>
                  <td><input type="text" id="destination" name="destination" class="form-control"
                      style="width:100%; border:1px solid #ccc; padding:4px;"></td>
                </tr>
                <tr>
                  <td>Keperluan <i>(Purpose)</i></td>
                  <td>:</td>
                  <td><input type="text" id="purpose" name="purpose" class="form-control" placeholder="Sign on to [Nama Kapal]"
                      style="width:100%; border:1px solid #ccc; padding:4px;"></td>
                </tr>
                <tr>
                  <td>Berangkat Tanggal <i>(Date of Depart)</i></td>
                  <td>:</td>
                  <td><input type="date" id="depart_date" name="depart_date" class="form-control" style="width:60%; border:1px solid #ccc; padding:4px;"></td>
                </tr>
                <tr>
                  <td>Tiba Tanggal <i>(Date of Arrival)</i></td>
                  <td>:</td>
                  <td><input type="date" id="arrival_date" name="arrival_date" class="form-control" style="width:60%; border:1px solid #ccc; padding:4px;"></td>
                </tr>
                <tr>
                  <td>Kendaraan <i>(Transportation)</i></td>
                  <td>:</td>
                  <td><input type="text" id="transportation" name="transportation" class="form-control"
                      placeholder="Contoh: Pesawat / Mobil / Kapal"
                      style="width:100%; border:1px solid #ccc; padding:4px;"></td>
                </tr>
                <tr>
                  <td>Catatan <i>(Note)</i></td>
                  <td>:</td>
                  <td><textarea id="note" name="note" rows="2" class="form-control" style="width:100%; border:1px solid #ccc; padding:4px;"></textarea>
                  </td>
                </tr>
                <tr>
                  <td>Pengikut <i>(Accompany)</i></td>
                  <td>:</td>
                  <td>
                    <div id="accompanyInfo" style="font-style:italic; color:#555;">Tambahkan
                      pengikut di bawah ini.</div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>

        <div style="height:20px;"></div>

        <table id="signatureTable"
          style="width:100%; border-collapse:collapse; border:1px solid #000; text-align:center; font-size:13px;">
          <thead>
            <tr>
              <td style="border:1px solid #000; padding:6px; width:50%; font-weight:bold;">Nama/Name</td>
              <td style="border:1px solid #000; padding:6px; width:50%; font-weight:bold;">Jabatan/Rank
              </td>
            </tr>
          </thead>
          <tbody id="accompanyWrapper">
            <tr class="accompany-item">
              <td style="border:1px solid #000; padding:6px;">
                <input type="text" class="form-control acc-name" name="accompany[0][name]" placeholder="Nama pengikut"
                  style="width:90%; border:1px solid #ccc; padding:4px;">
              </td>
              <td
                style="border:1px solid #000; padding:6px; display:flex; align-items:center; justify-content:center; gap:6px;">
                <input type="text" class="form-control acc-rank" name="accompany[0][rank]" placeholder="Rank pengikut"
                  style="width:85%; border:1px solid #ccc; padding:4px;" readonly>
                <button type="button" id="addAccompany"
                  style="border:none; background:#28a745; color:#fff; font-weight:bold; font-size:16px; width:28px; height:28px; border-radius:4px; cursor:pointer;">+</button>
              </td>
            </tr>
          </tbody>
        </table>

        <div style="height:40px;"></div>

        <div style="text-align:right; margin-right:50px;">
          Jakarta, <span id="currentDateText">&lt;&lt;Tanggal&gt;&gt;</span><br>
          <span id="companyText">PT. Andhika Lines</span><br><br><br><br><br><br>
          <div style="font-weight:bold; text-decoration:underline;">Eva Marliana</div>
          <div style="font-style:italic;">Crewing Manager</div>
        </div>

        <div style="height:50px;"></div>

        <div id="cc_list" style="font-size:12px;">
          <i>(Cc)</i><br>
          1. Manager Adm & Keu<br>
          2. Master <span id="vessel_name_cc">[Nama Kapal]</span><br>
          3. File
        </div>

      </div>

      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" style="font-family: 'Times New Roman', Times, serif;">Tutup</button>
        <button type="submit" class="btn btn-sm btn-primary" id="btnSaveSPJ" style="font-family: 'Times New Roman', Times, serif;"><i class="fa fa-print"></i> Save & Print</button>
      </div>
    </form>
  </div>
</div>

<!-- ============================================================
     MODAL: Detail SPJ
     ============================================================ -->
<div class="modal fade" id="modalDetailSpj" tabindex="-1" aria-labelledby="modalDetailSpjLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <!-- Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, #000099 0%, #1a237e 100%); color: #fff;">
                <h6 class="modal-title fw-bold" id="modalDetailSpjLabel">
                    <i class="fa fa-file-text-o me-2"></i>Detail SPJ Report
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Body -->
            <div class="modal-body p-0" id="modalDetailSpjBody">
                <div id="detailSpinnerSpj" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div id="detailContentSpj" class="d-none">
                    <div class="px-4 py-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #f8f9ff;">
                                    <small class="text-muted d-block mb-1">Diberikan kepada</small>
                                    <span class="fw-bold text-dark" id="detailSpjName">-</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #f8f9ff;">
                                    <small class="text-muted d-block mb-1">Jabatan</small>
                                    <span class="fw-bold text-dark" id="detailSpjRank">-</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="p-3 rounded-3" style="background: #f8f9ff;">
                                    <small class="text-muted d-block mb-1">Keperluan</small>
                                    <span class="text-dark" id="detailSpjPurpose">-</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #f8f9ff;">
                                    <small class="text-muted d-block mb-1">Tgl Berangkat</small>
                                    <span class="text-dark" id="detailSpjDepart">-</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #f8f9ff;">
                                    <small class="text-muted d-block mb-1">Tgl Tiba</small>
                                    <span class="text-dark" id="detailSpjArrival">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-2 mx-4">

                    <!-- Crew List -->
                    <div class="px-4 py-2">
                        <h6 class="fw-bold mb-3" style="color: #000099;">
                            <i class="fa fa-users me-2"></i>Daftar Pengikut
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle mb-0" style="font-size: 12px;">
                                <thead style="background-color: #e8eaf6;">
                                    <tr>
                                        <th class="text-center" style="width: 40px;">No</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Jabatan</th>
                                    </tr>
                                </thead>
                                <tbody id="detailSpjAccompanyBody">
                                    <!-- Populated via JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" style="font-family: 'Times New Roman', Times, serif;">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary" id="btnGeneratePdfFromDetail" style="font-family: 'Times New Roman', Times, serif;"><i class="fa fa-print"></i> Print</button>
            </div>
        </div>
    </div>
</div>

<style>
/* Same table styles as MCU for consistency */
.crew-table th, .crew-table td { font-size: 12px; vertical-align: middle; }
.crew-table th { font-weight: 600; text-align: center; }
.crew-header th { background-color: #000099 !important; color: #fff !important; }
.column-search { width: 100%; padding: 4px; border: 1px solid #ced4da; border-radius: 4px; font-size: 11px; }

/* jQuery UI Autocomplete overrides to ensure it's above Modal */
.custom-autocomplete-dropdown {
    position: absolute;
    z-index: 1060; /* Higher than bootstrap modal (1050) */
    background: #fff;
    border: 1px solid #ccc;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    max-height: 200px;
    overflow-y: auto;
    margin: 0;
    padding: 0;
    list-style: none;
}
.custom-autocomplete-item {
    font-size: 12px;
    padding: 8px 12px;
    cursor: pointer;
}
.custom-autocomplete-item:hover {
    background-color: #f1f3f8;
}
</style>

<script>
$(document).ready(function() {
    var BASE_URL = '<?php echo base_url("ListReport/Spj"); ?>';
    var idperson = $('#contentArea').data('idperson');

    if (!idperson) {
        console.error('ID Person tidak ditemukan');
        return;
    }

    // ================================
    // DataTables Initialization
    // ================================
    var spjTable = $('#spjTable').DataTable({
        processing: true,
        serverSide: false,
        searching: true,
        paging: true,
        info: true,
        lengthChange: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        order: [],
        ajax: {
            url: BASE_URL + '/get_report_spj',
            type: 'POST',
            data: { idperson: idperson },
            dataSrc: function(json) {
                return json.success ? json.data : [];
            }
        },
        columns: [
            {
                data: null, className: 'fw-bold text-center', orderable: false, searchable: false,
                render: function(data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; }
            },
            { data: 'name' },
            { data: 'rank', className: 'text-center' },
            { data: 'destination', className: 'text-center' },
            { data: 'depart_date', className: 'text-center' },
            { data: 'created_at', className: 'text-center' },
            {
                data: null, className: 'text-center', orderable: false, searchable: false,
                render: function(data) {
                    return '<div class="btn-group btn-group-sm" role="group">' +
                        '<button type="button" class="btn btn-outline-primary btn-view-spj" title="Detail" data-id="' + data.id + '">' +
                            '<i class="fa fa-eye"></i>' +
                        '</button>' +
                        // '<button type="button" class="btn btn-outline-success btn-print-spj" title="Print" data-id="' + data.id + '">' +
                        //     '<i class="fa fa-print"></i>' +
                        // '</button>' +
                        '<button type="button" class="btn btn-outline-danger btn-delete-spj" title="Delete" data-id="' + data.id + '">' +
                            '<i class="fa fa-trash"></i>' +
                        '</button>' +
                    '</div>';
                }
            }
        ],
        initComplete: function() {
            this.api().columns().every(function() {
                var column = this;
                var header = $(column.header());
                if (header.find('.column-search').length) {
                    header.find('.column-search').on('keyup change', function() {
                        if (column.search() !== this.value) {
                            column.search(this.value).draw();
                        }
                    });
                }
            });
        }
    });

    $('#spjTable thead tr:last th').each(function(i) {
        $('input', this).on('keyup change', function() {
            if (spjTable.column(i).search() !== this.value) {
                spjTable.column(i).search(this.value).draw();
            }
        });
    });

    // ================================
    // Get Crew Info for Add Form
    // ================================
    function loadMainCrewInfo() {
        $.ajax({
            url: BASE_URL + '/get_crew_info_by_idperson',
            type: 'POST',
            data: { idperson: idperson },
            dataType: 'json',
            success: function(res) {
                if(res.success && res.data) {
                    $('#crew_name').val(res.data.nama_crew);
                    $('#crew_rank').val(res.data.jabatan);
                    if(res.data.vessel_name) {
                        $('#vessel_name_cc').text(res.data.vessel_name);
                        $('#purpose').val('Sign on to  ' + res.data.vessel_name);
                    }
                }
            }
        });
    }

    // ================================
    // Autocomplete Logic
    // ================================
    function bindAutocomplete(element) {
        $(element).attr('autocomplete', 'off');

        var dropdownId = 'auto-dropdown-' + Math.random().toString(36).substr(2, 9);
        var $dropdown = $('<ul class="custom-autocomplete-dropdown" id="' + dropdownId + '"></ul>').hide();
        $('body').append($dropdown);

        var xhr = null;

        $(element).on('keyup', function() {
            var val = $(this).val();
            var $input = $(this);
            
            if (val.length < 2) {
                $dropdown.hide();
                return;
            }

            if (xhr) xhr.abort();
            
            var offset = $input.offset();
            $dropdown.css({
                top: offset.top + $input.outerHeight(),
                left: offset.left,
                width: $input.outerWidth()
            });

            xhr = $.ajax({
                url: BASE_URL + '/get_crew_by_name',
                type: 'POST',
                data: { keyword: val },
                dataType: 'json',
                success: function(data) {
                    $dropdown.empty();
                    if(data.success && data.data && data.data.length > 0) {
                        $.each(data.data, function(i, item) {
                            var li = $('<li class="custom-autocomplete-item"></li>')
                                .text(item.nama_crew)
                                .data('idperson', item.idperson)
                                .data('nama', item.nama_crew);
                            $dropdown.append(li);
                        });
                        $dropdown.show();
                    } else {
                        $dropdown.hide();
                    }
                }
            });
        });

        $dropdown.on('mousedown', '.custom-autocomplete-item', function(e) {
            e.preventDefault(); 
            var $item = $(this);
            var idperson = $item.data('idperson');
            var nama = $item.data('nama');
            
            $(element).val(nama);
            $dropdown.hide();

            var tr = $(element).closest('tr');
            $.ajax({
                url: BASE_URL + '/get_crew_info_by_idperson',
                type: 'POST',
                data: { idperson: idperson },
                dataType: 'json',
                success: function(res) {
                    if(res.success && res.data) {
                        tr.find('.acc-rank').val(res.data.jabatan);
                    }
                }
            });
        });

        $(element).on('blur', function() {
            $dropdown.hide();
        });

        $(element).on('remove', function() {
            $dropdown.remove();
        });
    }

    // ================================
    // Add SPJ actions
    // ================================
    $('#btnAddSpj').click(function() {
        $('#formAddSpj')[0].reset();
        $('#accompanyWrapper tr:not(:first)').remove(); // remove dynamic rows
        bindAutocomplete('.acc-name');
        
        // Auto fill date
        var d = new Date();
        var dateStr = d.getDate() + ' ' + d.toLocaleString('default', { month: 'long' }) + ' ' + d.getFullYear();
        $('#currentDateText').text(dateStr);
        
        loadMainCrewInfo();
        $('#modalSPJ').modal('show');
    });

    var accompanyIndex = 1;
    $('#addAccompany').click(function() {
        var rowHtml = '<tr class="accompany-item">' +
            '<td style="border:1px solid #000; padding:6px;">' +
                '<input type="text" class="form-control acc-name" name="accompany['+accompanyIndex+'][name]" placeholder="Nama pengikut" style="width:90%; border:1px solid #ccc; padding:4px;">' +
            '</td>' +
            '<td style="border:1px solid #000; padding:6px; display:flex; align-items:center; justify-content:center; gap:6px;">' +
                '<input type="text" class="form-control acc-rank" name="accompany['+accompanyIndex+'][rank]" placeholder="Rank pengikut" style="width:85%; border:1px solid #ccc; padding:4px;" readonly>' +
                '<button type="button" class="btnRemoveAccompany" style="border:none; background:#dc3545; color:#fff; font-weight:bold; font-size:16px; width:28px; height:28px; border-radius:4px; cursor:pointer;">-</button>' +
            '</td>' +
        '</tr>';
        
        $('#accompanyWrapper').append(rowHtml);
        bindAutocomplete($('#accompanyWrapper tr:last .acc-name'));
        accompanyIndex++;
    });

    $(document).on('click', '.btnRemoveAccompany', function() {
        $(this).closest('tr').remove();
    });

    // Removed purpose input listener for vessel_name_cc

    // ================================
    // Save Form
    // ================================
    $('#formAddSpj').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serializeArray();
        var postData = { idperson: idperson, accompany: [] };
        
        $.each(formData, function(i, field) {
            if (field.name.startsWith('accompany')) {
                var match = field.name.match(/accompany\[(\d+)\]\[(\w+)\]/);
                if (match) {
                    var idx = match[1];
                    var key = match[2];
                    if (!postData.accompany[idx]) postData.accompany[idx] = {};
                    postData.accompany[idx][key] = field.value;
                }
            } else {
                postData[field.name] = field.value;
            }
        });

        // Filter out empty accompanies
        postData.accompany = postData.accompany.filter(function(a) {
            return a && a.name && a.name.trim() !== '';
        });

        var btn = $('#btnSaveSPJ');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: BASE_URL + '/saveSPJ',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(postData),
            dataType: 'json',
            success: function(res) {
                btn.prop('disabled', false).html('<i class="fa fa-print"></i> Save & Print');
                if (res.success) {
                    $('#modalSPJ').modal('hide');
                    spjTable.ajax.reload(null, false);
                    if (typeof showNotification !== 'undefined') {
                        showNotification('success', res.message);
                    }
                    // Auto print PDF
                    if (res.spj_id) {
                        window.open(BASE_URL + '/getSpj/' + res.spj_id, '_blank');
                    }
                } else {
                    if (typeof showNotification !== 'undefined') {
                        showNotification('error', res.message || 'Gagal menyimpan data');
                    }
                }
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fa fa-print"></i> Save & Print');
                if (typeof showNotification !== 'undefined') {
                    showNotification('error', 'Terjadi kesalahan server');
                }
            }
        });
    });

    // ================================
    // Print PDF existing
    // ================================
    $('#spjTable').on('click', '.btn-print-spj', function() {
        var id = $(this).data('id');
        window.open(BASE_URL + '/getSpj/' + id, '_blank');
    });

    // ================================
    // Detail SPJ
    // ================================
    $('#spjTable').on('click', '.btn-view-spj', function() {
        var id = $(this).data('id');

        $('#btnGeneratePdfFromDetail').data('id', id);

        $('#detailSpinnerSpj').show();
        $('#detailContentSpj').addClass('d-none');
        $('#modalDetailSpj').modal('show');

        $.ajax({
            url: BASE_URL + '/get_report_spj_detail',
            type: 'POST',
            data: { id_report: id, idperson: idperson },
            dataType: 'json',
            success: function(res) {
                $('#detailSpinnerSpj').hide();

                if (!res.success) {
                    $('#detailContentSpj').removeClass('d-none').html(
                        '<div class="text-center py-4 text-danger"><i class="fa fa-warning fa-2x mb-2"></i><p>' + (res.message || 'Data tidak ditemukan') + '</p></div>'
                    );
                    return;
                }

                var report = res.data.report;
                var persons = res.data.persons;

                $('#detailSpjName').text(report.name || '-');
                $('#detailSpjRank').text(report.rank || '-');
                $('#detailSpjPurpose').text(report.purpose || '-');
                $('#detailSpjDepart').text(report.depart_date ? formatDate(report.depart_date) : '-');
                $('#detailSpjArrival').text(report.arrival_date ? formatDate(report.arrival_date) : '-');

                var crewHtml = '';
                if (persons && persons.length > 0) {
                    $.each(persons, function(idx, p) {
                        crewHtml += 
                            '<tr>' +
                                '<td class="text-center">' + (idx + 1) + '</td>' +
                                '<td>' + (p.name || '-') + '</td>' +
                                '<td class="text-center">' + (p.rank || '-') + '</td>' +
                            '</tr>';
                    });
                } else {
                    crewHtml = '<tr><td colspan="3" class="text-center text-muted">Tidak ada data pengikut</td></tr>';
                }
                $('#detailSpjAccompanyBody').html(crewHtml);

                $('#detailContentSpj').removeClass('d-none');
            },
            error: function() {
                $('#detailSpinnerSpj').hide();
                $('#detailContentSpj').removeClass('d-none').html(
                    '<div class="text-center py-4 text-danger"><i class="fa fa-warning fa-2x mb-2"></i><p>Gagal memuat data</p></div>'
                );
            }
        });
    });

    // ================================
    // Print from Detail Modal
    // ================================
    $('#btnGeneratePdfFromDetail').on('click', function() {
        var id = $(this).data('id');
        if (id) {
            window.open(BASE_URL + '/getSpj/' + id, '_blank');
        }
    });

    // ================================
    // Delete SPJ
    // ================================
    $('#spjTable').on('click', '.btn-delete-spj', function() {
        var id = $(this).data('id');

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Data SPJ?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fa fa-trash me-1"></i> Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (result.isConfirmed) {
                    doDeleteSpj(id);
                }
            });
        } else {
            if (confirm('Apakah Anda yakin ingin menghapus data SPJ ini?')) {
                doDeleteSpj(id);
            }
        }
    });

    function doDeleteSpj(id) {
        $.ajax({
            url: BASE_URL + '/delete_list_spj',
            type: 'POST',
            data: { id_report: id, idperson: idperson },
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    spjTable.ajax.reload(null, false);
                    if (typeof showNotification !== 'undefined') {
                        showNotification('success', res.message || 'Data berhasil dihapus');
                    }
                } else {
                    if (typeof showNotification !== 'undefined') {
                        showNotification('error', res.message || 'Gagal menghapus data');
                    }
                }
            },
            error: function() {
                if (typeof showNotification !== 'undefined') {
                    showNotification('error', 'Terjadi kesalahan server');
                }
            }
        });
    }

    // Helpers
    function showNotification(type, message) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type,
                title: type === 'success' ? 'Sukses' : 'Error',
                text: message,
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        } else {
            alert(message);
        }
    }

    function formatDate(dateStr) {
        if(!dateStr) return '';
        var d = new Date(dateStr);
        if (isNaN(d.getTime())) return dateStr;
        var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        return d.getDate() + ' ' + monthNames[d.getMonth()] + ' ' + d.getFullYear();
    }
});
</script>