<!-- Acceptentce Letter Module View — Loaded via AJAX -->
<div class="card shadow-sm border-0" id="accModuleWrapper">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-sm rounded shadow-sm" id="btnAddAcceptance" style="background-color: #000999; border-color: #000999;">
                <i class="fa fa-plus me-1"></i> Add Acceptance Letter
            </button>
        </div>
        <div class="table-responsive">
            <table id="acceptanceTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                    <tr>
                        <th class="text-center" style="width:50px;">No</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Rank</th>
                        <th class="text-center">Vessel Name</th>
                        <th class="text-center">Date Request</th>
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
     MODAL: Add / View Acceptance
     ============================================================ -->
<div class="modal fade" id="modalAcceptance" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow">
      
      <div class="modal-header" style="background: linear-gradient(135deg, #000999 0%, #1a237e 100%); color: #fff;">
          <h6 class="modal-title fw-bold">
              <i class="fa fa-file-text-o me-2"></i>Statement of Contract Acceptance
          </h6>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1) grayscale(100%) brightness(200%);"></button>
      </div>

      <div class="modal-body bg-light" style="padding:40px 55px; font-family:'Times New Roman', serif; font-size:14px; background-color: #fff !important;">
          <form id="formAddAcceptance" style="width: 100%;">
              <input type="hidden" name="idperson" id="acc_idperson">
              <input type="hidden" name="nama_crew" id="acc_nama_crew">
              <input type="hidden" name="rank" id="acc_rank">
              <input type="hidden" name="vessel" id="acc_vessel">

              <div style="display:flex; align-items:flex-start; width:100%; margin-bottom:15px;">
                <div style="width:100px;">
                  <img src="<?php echo base_url('assets/img/Logo_Andhika_2017.jpg'); ?>" style="width:90px;">
                </div>

                <div style="flex:1; text-align:center; margin-top:10px;">
                  <div style="font-size:16px; font-weight:bold;">
                    STATEMENT OF CONTRACT ACCEPTANCE
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

              <div style="margin-top:10px; width:100%;">
                <p style="margin-bottom:5px;">
                  I am the undersigned freely accept on these articles in the Employment Contract that has:
                  <br><span style="font-style:italic;">Saya yang bertanda tangan di bawah ini telah menerima pasal-pasal dalam kontrak kerja yang telah:</span>
                </p>
                <ol style="padding-left:30px; line-height:1.45;">
                    <li style="margin-bottom:12px;">
                        Reviewed the terms and condition of the employment contract, and
                        <br><span style="font-style:italic;">saya mempelajari syarat dan kondisi dalam kontrak tersebut, dan</span>
                    </li>
                    <li>
                        Well briefed on the terms and condition of the employment contract
                        <br><span style="font-style:italic;">mendapat penjelasan dengan baik mengenai syarat dan kondisi kontrak kerja tersebut.</span>
                    </li>
                </ol>
              </div>

              <div style="margin-top:20px; font-size:14px;">
                <table style="border-collapse:collapse; width: 100%;">
                  <tr>
                    <td style="width:180px;">Name<br><span style="font-style:italic;">Nama</span></td>
                    <td style="width:10px;">:</td>
                    <td><span style="font-weight:700;" id="txtAccName">&lt;&lt;Nama Crew&gt;&gt;</span></td>
                  </tr>
                  <tr>
                    <td style="padding-top:8px;">D O B<br><span style="font-style:italic;">Tanggal Lahir</span></td>
                    <td style="padding-top:8px;">:</td>
                    <td style="padding-top:8px;"><span style="font-weight:700;" id="txtAccDob">&lt;&lt;Tanggal Lahir&gt;&gt;</span></td>
                  </tr>
                  <tr>
                    <td style="padding-top:8px;">Rank<br><span style="font-style:italic;">Jabatan</span></td>
                    <td style="padding-top:8px;">:</td>
                    <td style="padding-top:8px;"><span style="font-weight:700;" id="txtAccRank">&lt;&lt;Rank&gt;&gt;</span></td>
                  </tr>
                  <tr>
                    <td style="padding-top:8px;">Certificate<br><span style="font-style:italic;">Ijazah</span></td>
                    <td style="padding-top:8px;">:</td>
                    <td style="padding-top:8px;"><span style="font-weight:700;" id="txtAccCert">&lt;&lt;Certificate&gt;&gt;</span></td>
                  </tr>
                </table>
              </div>

              <div style="margin-top:20px;">
                  <p>
                      If I deny the above statement, I am willing to pay an indemnity of which have been issued by the company.<br>
                      <span style="font-style:italic;">Jika saya menyangkal pernyataan di atas, saya bersedia membayar ganti rugi yang telah dikeluarkan oleh perusahaan.</span>
                  </p>
                  <p>
                      I hereby confirm the above contained herein is correct, without compulsion.<br>
                      <span style="font-style:italic;">Demikian pernyataan ini saya buat dengan sebenarnya tanpa paksaan dari pihak lain.</span>
                  </p>
              </div>

              <div style="margin-top:20px;">
                  Thank you.<br>
                  <span style="font-style:italic;">Terima kasih.</span>
              </div>

              <div style="margin-top:10px;">
                  Jakarta, <span style="font-weight:700;" id="txtAccDate">&lt;&lt;Tanggal&gt;&gt;</span>
              </div>

              <div style="margin-top:30px; display:flex; justify-content:space-between; width:100%; text-align:center;">
                  <div style="width:50%;">
                      Your Sincerely<br>
                      <span style="font-style:italic;">Hormat Kami</span>
                  </div>
                  <div style="width:50%;">
                      Acknowledged By<br>
                      <span style="font-style:italic;">Mengetahui</span>
                  </div>
              </div>

              <div style="margin-top:60px; display:flex; justify-content:space-between; width:100%; text-align:center;">
                  <div style="width:50%;">
                      <div style="font-weight:700;" id="txtAccSignName">&lt;&lt;Nama Crew&gt;&gt;</div>
                      <div style="border-top:1px solid #333; width:160px; margin: 0 auto;">Seafarer</div>
                  </div>
                  <div style="width:50%;">
                      <div style="font-weight:700; text-decoration:underline; margin-bottom: 2px;">EVA MARLIANA</div>
                      <div>Crew Manager</div>
                  </div>
              </div>
          </form>
      </div>

      <div class="modal-footer bg-light" style="justify-content:flex-end;">
          <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" style="font-family: 'Times New Roman', Times, serif;">Tutup</button>
          <button type="button" class="btn btn-sm btn-primary px-4" id="btnSubmitAcceptance" style="font-family: 'Times New Roman', Times, serif;"> <i class="fa fa-save"></i> Save & Print</button>
          <button type="button" class="btn btn-sm btn-primary px-4 d-none" id="btnGeneratePdfFromModalAcc" style="font-family: 'Times New Roman', Times, serif;"> <i class="fa fa-print"></i> Print</button>
      </div>

    </div>
  </div>
</div>

<!-- Hidden form for PDF generation -->
<form id="formPdfAcceptance" method="POST" target="_blank" action="<?php echo base_url('ListReport/AcceptentceLetter/acceptence_pdf'); ?>" style="display:none;">
    <input type="hidden" name="idperson" id="pdf_acc_idperson">
</form>

<!-- ============================================================
     STYLES & SCRIPTS
     ============================================================ -->
<style>
.crew-table th, .crew-table td { font-size: 12px; vertical-align: middle; }
.crew-header th { background-color: #000099 !important; color: #fff !important; }
.card-header i { color: #000099; }
.column-search { width: 100%; padding: 4px; border: 1px solid #ced4da; border-radius: 4px; font-size: 11px; }
.dataTables_wrapper { padding: 15px 0; }
.dataTables_length { padding: 10px 0; margin-bottom: 10px; }
.dataTables_length label, .dataTables_filter label { display: flex; align-items: center; margin: 0; padding: 20px 0; }
.dataTables_length select { width: auto; margin: 0 8px; padding: 4px 8px; border-radius: 4px; border: 1px solid #ced4da; }
.dataTables_filter { text-align: right; margin-bottom: 10px; }
.dataTables_filter label { display: inline-flex; align-items: center; margin: 0; padding: 8px 0; font-weight: normal; }
.dataTables_filter input { margin-left: 10px; padding: 6px 12px; border-radius: 4px; border: 1px solid #ced4da; width: 200px; }
.dataTables_paginate { margin-top: 15px; padding-top: 10px; border-top: 1px solid #dee2e6; }
.paginate_button { margin: 0 2px; padding: 6px 12px !important; border-radius: 4px; border: 1px solid #dee2e6; background: #fff !important; color: #0d6efd !important; cursor: pointer; }
.paginate_button.current { background: #0d6efd !important; color: #fff !important; border-color: #0d6efd !important; }
.paginate_button:hover { background: #e9ecef !important; border-color: #dee2e6; }
.dataTables_info { padding: 10px 0; color: #6c757d; font-size: 14px; }
</style>

<script>
$(document).ready(function() {
    var BASE_URL_ACC = '<?php echo base_url("ListReport/AcceptentceLetter"); ?>';
    var idperson = $('#contentArea').data('idperson');

    if (!idperson) {
        console.error('ID Person tidak ditemukan');
        return;
    }

    var accTable = $('#acceptanceTable').DataTable({
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
            url: BASE_URL_ACC + '/get_history',
            type: 'POST',
            data: function(d) { d.idperson = idperson; },
            dataSrc: function(json) { return json.success ? json.data : []; }
        },
        columns: [
            {
                data: null, className: 'fw-bold text-center', orderable: false, searchable: false,
                render: function(data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; }
            },
            { data: 'nama_crew', className: 'text-center' },
            { data: 'rank', className: 'text-center' },
            { data: 'vessel', className: 'text-center' },
            { data: 'date_created_fmt', className: 'text-center fw-bold' },
            {
                data: null, className: 'text-center', orderable: false, searchable: false,
                render: function(data) {
                    return '<div class="btn-group btn-group-sm" role="group">' +
                        '<button type="button" class="btn btn-outline-primary btn-view-acc" title="Print/View PDF" data-idperson="' + data.idperson + '" data-date="' + data.date_created_fmt + '">' +
                            '<i class="fa fa-eye"></i>' +
                        '</button>' +
                        '<button type="button" class="btn btn-outline-danger btn-delete-acc" title="Delete" data-id="' + data.id + '">' +
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
            emptyTable: 'Tidak ada data',
            zeroRecords: 'Data tidak ditemukan'
        }
    });

    $('#acceptanceTable thead tr:last th').each(function(i) {
        $('input', this).on('keyup change', function() {
            if (accTable.column(i).search() !== this.value) {
                accTable.column(i).search(this.value).draw();
            }
        });
    });

    // ADD
    $('#btnAddAcceptance').on('click', function() {
        $('#formAddAcceptance')[0].reset();
        $('#acc_idperson').val(idperson);
        
        $.ajax({
            url: BASE_URL_ACC + '/acceptence',
            type: 'POST',
            data: { idperson: idperson },
            dataType: 'json',
            success: function(res) {
                if (res.status) {
                    var d = res.data;
                    
                    // Hidden inputs for saving
                    $('#acc_nama_crew').val(d.nama_crew);
                    $('#acc_rank').val(d.nama_rank);
                    $('#acc_vessel').val(d.nama_kapal);

                    // Preview UI
                    $('#txtAccName').text(d.nama_crew);
                    $('#txtAccDob').text(d.tanggal_lahir);
                    $('#txtAccRank').text(d.nama_rank);
                    $('#txtAccCert').text(d.serpel);
                    $('#txtAccDate').text(res.today);
                    $('#txtAccSignName').text(d.nama_crew);

                    $('#btnSubmitAcceptance').removeClass('d-none');
                    $('#btnGeneratePdfFromModalAcc').addClass('d-none');

                    $('#modalAcceptance').modal('show');
                } else {
                    accNotify('warning', res.message || 'Data personal tidak ditemukan');
                }
            }
        });
    });

    // VIEW DETAIL
    $('#acceptanceTable').on('click', '.btn-view-acc', function() {
        var ip = $(this).data('idperson');
        var createdDate = $(this).data('date');

        $('#pdf_acc_idperson').val(ip);

        $.ajax({
            url: BASE_URL_ACC + '/acceptence',
            type: 'POST',
            data: { idperson: ip },
            dataType: 'json',
            success: function(res) {
                if (res.status) {
                    var d = res.data;
                    
                    // Preview UI
                    $('#txtAccName').text(d.nama_crew);
                    $('#txtAccDob').text(d.tanggal_lahir);
                    $('#txtAccRank').text(d.nama_rank);
                    $('#txtAccCert').text(d.serpel);
                    $('#txtAccDate').text(createdDate); 
                    $('#txtAccSignName').text(d.nama_crew);

                    $('#btnSubmitAcceptance').addClass('d-none');
                    $('#btnGeneratePdfFromModalAcc').removeClass('d-none');

                    $('#modalAcceptance').modal('show');
                } else {
                    accNotify('error', 'Gagal memuat detail crew.');
                }
            }
        });
    });

    // SUBMIT
    $('#btnSubmitAcceptance').on('click', function() {
        var formData = new FormData($('#formAddAcceptance')[0]);
        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin ms-1"></i> Menyimpan...');

        $.ajax({
            url: BASE_URL_ACC + '/save_history',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                btn.prop('disabled', false).html('Simpan & Print');
                if (res.success) {
                    $('#modalAcceptance').modal('hide');
                    accTable.ajax.reload(null, false);
                    accNotify('success', res.message);
                    
                    // Auto print PDF
                    $('#pdf_acc_idperson').val(idperson);
                    $('#formPdfAcceptance').submit();
                } else {
                    accNotify('error', res.message);
                }
            },
            error: function() {
                btn.prop('disabled', false).html('Simpan & Print');
                accNotify('error', 'Terjadi kesalahan sistem');
            }
        });
    });

    // PRINT FROM MODAL
    $('#btnGeneratePdfFromModalAcc').on('click', function() {
        $('#formPdfAcceptance').submit();
    });

    // DELETE
    $('#acceptanceTable').on('click', '.btn-delete-acc', function() {
        var id = $(this).data('id');
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus History?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus'
            }).then(function(result) {
                if (result.isConfirmed) doDeleteAcc(id);
            });
        } else {
            if (confirm('Yakin ingin menghapus history ini?')) {
                doDeleteAcc(id);
            }
        }
    });

    function doDeleteAcc(id) {
        $.ajax({
            url: BASE_URL_ACC + '/delete_history',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    accTable.ajax.reload(null, false);
                    accNotify('success', res.message);
                } else {
                    accNotify('error', res.message);
                }
            }
        });
    }



    function accNotify(type, msg) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type, title: type === 'success' ? 'Sukses' : 'Error', text: msg,
                timer: 3000, showConfirmButton: false, toast: true, position: 'top-end'
            });
        } else {
            alert(msg);
        }
    }
});
</script>
