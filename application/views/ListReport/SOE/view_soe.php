<div class="card shadow-sm border-0" id="soeModuleWrapper">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-sm rounded shadow-sm" id="btnCreateSoe" style="background-color: #000999; border-color: #000999;">
                <i class="fa fa-plus me-1"></i> Add Statement
            </button>
        </div>
        <div class="table-responsive">
            <table id="tableReportSoe" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                    <tr>
                        <th class="text-center" style="width:50px;">No</th>
                        <th class="text-center">Tgl. Dibuat (Sign On)</th>
                        <th class="text-center">Nama Pegawai / Crew</th>
                        <th class="text-center">Jabatan</th>
                        <th class="text-center">Kapal</th>
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
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- ============================================================
     MODAL: Add / View Statement
     ============================================================ -->
<div class="modal fade" id="modalStatement" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow">
      
      <!-- Header Model disamakan bila perlu, tapi karena form PDF kita pakai polos saja border atasnya -->
      <div class="modal-header" style="background: linear-gradient(135deg, #000999 0%, #1a237e 100%); color: #fff;">
          <h6 class="modal-title fw-bold">
              <i class="fa fa-file-text-o me-2"></i>Form Statement of Free of Charge
          </h6>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1) grayscale(100%) brightness(200%);"></button>
      </div>

      <div class="modal-body bg-light" style="padding:40px 55px; font-family:'Times New Roman', serif; font-size:14px; background-color: #fff !important;">
          <form id="formSoe" style="width: 100%;">
              <input type="hidden" name="idperson" id="soe_idperson">
              <input type="hidden" name="fullname" id="soe_fullname">
              <input type="hidden" name="nmrank" id="soe_nmrank">
              <input type="hidden" name="nmvsl" id="soe_nmvsl">
              <input type="hidden" name="date_request" id="soe_date">

              <div style="display:flex; align-items:flex-start; width:100%; margin-bottom:15px;">
                <div style="width:100px;">
                  <img src="<?php echo base_url('assets/img/Logo_Andhika_2017.jpg'); ?>" style="width:90px;">
                </div>

                <div style="flex:1; text-align:center; margin-top:10px;">
                  <div style="font-size:20px; font-weight:bold; letter-spacing:2px;">
                    STATEMENT FREE OF CHARGE
                  </div>
                </div>

                <div style="width:180px; text-align:right; font-size:11px;">
                  <div style="font-weight:bold;">SRPS LICENSE NO:</div>
                  <div>SIUKAK 236.121 - R Tahun 2025</div>

                  <div style="margin-top:6px;">
                    <img src="<?php echo base_url('assets/img/Bureau_Veritas_Logo.jpg'); ?>"
                      style="width:70px; margin-right:3px;">
                    <img src="<?php echo base_url('assets/img/Iso.jpg'); ?>" style="width:70px;">
                  </div>
                </div>
              </div>

              <div style="margin-top:10px; margin-left:15px; width:92%;">
                <p style="margin-bottom:5px;">
                  I <span style="font-weight:700;" id="txtNameCrew">&lt;&lt;Nama Crew&gt;&gt;</span>
                  hereby declare that I have never give Money or / and other forms of gifts to any of our Andhika Eka
                  Karya Sejahtera office staff in return for favors.
                </p>

                <p style="font-style:italic; margin-top:10px;">
                  Saya <span style="font-weight:700;" id="txtNameCrewStatement">&lt;&lt;Nama Crew&gt;&gt;</span>
                  dengan ini menyatakan dengan sesungguhnya bahwa saya tidak pernah memberi uang dan / atau Semacamnya kepada
                  siapapun staf Personalia Laut Andhika Eka Karya Sejahtera untuk diterima dan ditempatkan di atas
                  kapal.
                </p>
              </div>

              <div style="margin-top:30px; margin-left:20px; width:70%; font-size:13px;">
                <table style="border-collapse:collapse;">
                  <tr>
                    <td style="width:110px;">Date<br><span style="font-style:italic;">tanggal</span></td>
                    <td style="width:10px;">:</td>
                    <td><span style="font-weight:700;" id="txtStatementDate">&lt;&lt;Tanggal&gt;&gt;</span>
                    </td>
                  </tr>

                  <tr>
                    <td style="padding-top:8px;">Vessel<br><span style="font-style:italic;">Kapal</span></td>
                    <td>:</td>
                    <td><span style="font-weight:700;" id="txtKapal">&lt;&lt;Kapal&gt;&gt;</span></td>
                  </tr>

                  <tr>
                    <td style="padding-top:8px;">Rank<br><span style="font-style:italic;">Jabatan</span></td>
                    <td>:</td>
                    <td><span style="font-weight:700;" id="txtRankStatement">&lt;&lt;Rank&gt;&gt;</span></td>
                  </tr>
                </table>
              </div>

              <div style="
                        margin-top:40px; 
                        display:flex; 
                        justify-content:space-between; 
                        width:90%; 
                        margin-left:20px;
                        margin-right:20px;
                    ">
                <div style="text-align:left;">
                  Thank you.<br>
                  <span style="font-style:italic;">Terima kasih</span>
                </div>

                <div style="text-align:right;">
                  Acknowledge:<br>
                  <span style="font-style:italic;">Mengetahui</span>
                </div>
              </div>

              <div style="
                        margin-top:60px; 
                        display:flex; 
                        justify-content:space-between; 
                        width:90%; 
                        margin-left:20px;
                        margin-right:20px;
                        align-items:flex-end;
                    ">
                <div style="text-align:left;">
                  <div style="margin-bottom:5px;font-weight:700;" id="txtCrewNameStatement" >&lt;&lt;Nama Crew&gt;&gt;</div>
                  <div style="border-top:1px solid #333; width:160px;">
                    Seafarer
                  </div>
                </div>

                <div style="text-align:right;">
                  <div style="font-size:13px; font-weight:700; text-decoration:underline; margin-bottom:3px;">
                    EVA MARLIANA
                  </div>
                  <div style="font-size:12px;">Crew Manager</div>
                </div>
              </div>
          </form>
      </div>

      <div class="modal-footer bg-light" style="justify-content:flex-end;">
          <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Tutup</button>
          <button type="button" class="btn btn-sm btn-primary px-4" id="btnSaveAndPrintStatementCrew">Simpan & Print </button>
          <button type="button" class="btn btn-sm btn-primary px-4 d-none" id="btnGeneratePdfFromModalSoe">Print</button>
      </div>

    </div>
  </div>
</div>

<!-- ============================================================
     Form untuk Print ke Tab Baru
     ============================================================ -->
<form id="formPrintSoe" target="_blank" method="POST" action="<?php echo base_url('ListReport/Soe/print_soe_pdf'); ?>" style="display: none;">
    <input type="hidden" name="id_report_soe" id="print_id_report_soe">
</form>

<!-- ============================================================
     STYLES
     ============================================================ -->
<style>
.crew-table th, .crew-table td { font-size: 12px; vertical-align: middle; }
.crew-header th { background-color: #000999 !important; color: #fff !important; }
.card-header i { color: #000999; }
.text-primary { color: #000999 !important; }

/* Column Search */
.column-search {
  width: 100%;
  padding: 4px;
  border: 1px solid #ced4da;
  border-radius: 4px;
  font-size: 11px;
}

/* DataTables Customization */
.dataTables_wrapper { padding: 15px 0; }
.dataTables_length { padding: 10px 0; margin-bottom: 10px; }
.dataTables_length label,
.dataTables_filter label { display: flex; align-items: center; margin: 0; padding: 20px 0; }
.dataTables_length select { width: auto; margin: 0 8px; padding: 4px 8px; border-radius: 4px; border: 1px solid #ced4da; }
.dataTables_filter { text-align: right; margin-bottom: 10px; }
.dataTables_filter label { display: inline-flex; align-items: center; margin: 0; padding: 8px 0; font-weight: normal; }
.dataTables_filter input { margin-left: 10px; padding: 6px 12px; border-radius: 4px; border: 1px solid #ced4da; width: 200px; }
.dataTables_paginate { margin-top: 15px; padding-top: 10px; border-top: 1px solid #dee2e6; }
.paginate_button { margin: 0 2px; padding: 6px 12px !important; border-radius: 4px; border: 1px solid #dee2e6; background: #fff !important; color: #067780 !important; cursor: pointer; }
.paginate_button.current { background: #067780 !important; color: #fff !important; border-color: #067780 !important; }
.paginate_button:hover { background: #e9ecef !important; border-color: #dee2e6; color: #045c63 !important; }
.dataTables_info { padding: 10px 0; color: #6c757d; font-size: 14px; }
</style>

<!-- ============================================================
     JAVASCRIPT LOGIC
     ============================================================ -->
<script>
$(document).ready(function() {
    var BASE_URL_SOE = '<?php echo base_url("ListReport/Soe"); ?>';

    // Ambil idperson yang sudah tersimpan di hidden field navigasi profile crew 
    var idperson = $('#idperson').val() || $('#contentArea').data('idperson');
    
    // Inisialisasi DataTable
    var tableReportSoe = $('#tableReportSoe').DataTable({
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
            url: BASE_URL_SOE + '/get_report_soe',
            type: "POST",
            data: function(d) {
                d.idperson = idperson;
            },
            dataSrc: function(json) {
                return json.success ? json.data : [];
            }
        },
        columns: [
            {
                data: null,
                className: 'fw-bold text-center',
                orderable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { 
                data: "date_request",
                className: 'text-center fw-bold'
            },
            { data: "name_person", className: 'text-center' },
            { data: "rank", className: 'text-center' },
            { data: "vessel_name", className: 'text-center' },
            {
                data: null,
                className: 'text-center',
                orderable: false,
                searchable: false,
                render: function(data) {
                    return '<div class="btn-group btn-group-sm" role="group">' +
                        '<button type="button" class="btn btn-outline-primary btn-view-soe" title="Print/View PDF" data-id="' + data.id + '">' +
                            '<i class="fa fa-eye"></i>' +
                        '</button>' +
                        '<button type="button" class="btn btn-outline-danger btn-delete-soe" title="Delete" data-id="' + data.id + '">' +
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
        },
        language: {
            lengthMenu: '_MENU_ &nbsp;Entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            infoEmpty: 'Showing 0 to 0 of 0 entries',
            infoFiltered: '(filtered from _MAX_ total entries)',
            search: 'Search:',
            emptyTable: 'Tidak ada data Statement of Employment',
            zeroRecords: 'Data tidak ditemukan'
        }
    });

    // Column search sync
    $('#tableReportSoe thead tr:last th').each(function(i) {
        $('input', this).on('keyup change', function() {
            if (tableReportSoe.column(i).search() !== this.value) {
                tableReportSoe.column(i).search(this.value).draw();
            }
        });
    });

    // Create Statement
    $('#btnCreateSoe').click(function() {
        $.ajax({
            url: BASE_URL_SOE + '/get_data_form_soe',
            type: "POST",
            data: { idperson: idperson },
            dataType: "json",
            success: function(response) {
                if (response.success && response.data.length > 0) {
                    var d = response.data[0];
                    
                    // Set span UI
                    $('#txtNameCrew').text(d.fullname);
                    $('#txtNameCrewStatement').text(d.fullname);
                    $('#txtStatementDate').text(d.date_request);
                    $('#txtKapal').text(d.nmvsl);
                    $('#txtRankStatement').text(d.nmrank);
                    $('#txtCrewNameStatement').text(d.fullname);

                    // Set hidden inputs
                    $('#soe_idperson').val(idperson);
                    $('#soe_fullname').val(d.fullname);
                    $('#soe_nmrank').val(d.nmrank);
                    $('#soe_nmvsl').val(d.nmvsl);
                    $('#soe_date').val(d.date_request);
                    
                    $('#btnSaveAndPrintStatementCrew').removeClass('d-none');
                    $('#btnGeneratePdfFromModalSoe').addClass('d-none');

                    $('#modalStatement').modal('show');
                } else {
                    soeNotify('warning', 'Data kontrak terbaru tidak ditemukan untuk crew ini.');
                }
            },
            error: function() {
                soeNotify('error', 'Terjadi kesalahan sistem saat mengambil form.');
            }
        });
    });

    // Save and Print Action Modal
    $('#btnSaveAndPrintStatementCrew').click(function() {
        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin ms-1"></i> Menyimpan...');

        $.ajax({
            url: BASE_URL_SOE + '/save_form_soe',
            type: "POST",
            data: $('#formSoe').serialize(),
            dataType: "json",
            success: function(response) {
                btn.prop('disabled', false).html('Simpan & Print PDF');
                if (response.success) {
                    $('#modalStatement').modal('hide');
                    tableReportSoe.ajax.reload(null, false);
                    
                    // Print PDF in new tab
                    $('#print_id_report_soe').val(response.id_report);
                    $('#formPrintSoe').submit();
                    
                    soeNotify('success', response.message);
                } else {
                    soeNotify('error', response.message);
                }
            },
            error: function() {
                btn.prop('disabled', false).html('Simpan & Print PDF');
                soeNotify('error', 'Terjadi kesalahan saat menyimpan data.');
            }
        });
    });

    // View / Print Detail
    $('#tableReportSoe').on('click', '.btn-view-soe', function() {
        var id = $(this).data('id');
        
        $.ajax({
            url: BASE_URL_SOE + '/get_report_soe_detail',
            type: "POST",
            data: { id_report: id },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    var d = response.data.crew;
                    
                    // Set span UI
                    $('#txtNameCrew').text(d.name_person);
                    $('#txtNameCrewStatement').text(d.name_person);
                    $('#txtStatementDate').text(d.date_request);
                    $('#txtKapal').text(d.vessel_name);
                    $('#txtRankStatement').text(d.rank);
                    $('#txtCrewNameStatement').text(d.name_person);

                    $('#print_id_report_soe').val(id);

                    // Switch Mode Detail
                    $('#btnSaveAndPrintStatementCrew').addClass('d-none');
                    $('#btnGeneratePdfFromModalSoe').removeClass('d-none');

                    $('#modalStatement').modal('show');
                } else {
                    soeNotify('error', response.message);
                }
            },
            error: function() {
                soeNotify('error', 'Terjadi kesalahan sistem saat load Detail');
            }
        });
    });

    // Generate Print via Modal Hit
    $('#btnGeneratePdfFromModalSoe').on('click', function() {
        $('#formPrintSoe').submit();
    });

    // Delete
    $('#tableReportSoe').on('click', '.btn-delete-soe', function() {
        var id = $(this).data('id');
        
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Statement?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    doDeleteSoe(id);
                }
            });
        } else {
            if (confirm('Yakin ingin menghapus statement ini?')) {
                doDeleteSoe(id);
            }
        }
    });

    function doDeleteSoe(id) {
        $.ajax({
            url: BASE_URL_SOE + '/delete_report_soe',
            type: "POST",
            data: { id: id },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    tableReportSoe.ajax.reload(null, false);
                    soeNotify('success', response.message);
                } else {
                    soeNotify('error', response.message);
                }
            },
            error: function() {
                soeNotify('error', 'Terjadi kesalahan pada sistem.');
            }
        });
    }

    // Helper notification
    function soeNotify(type, msg) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type,
                title: type === 'success' ? 'Sukses' : (type === 'warning' ? 'Info' : 'Error'),
                text: msg,
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        } else {
            alert(msg);
        }
    }
});
</script>