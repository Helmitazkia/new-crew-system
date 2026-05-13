<!-- ============================================================
     BANK Module View — Loaded via AJAX
     Features: DataTables, Add Bank Form, Generate PDF
     ============================================================ -->

<div class="card shadow-sm border-0" id="bankModuleWrapper">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-sm rounded shadow-sm" id="btnGlobalAddBank" style="background-color: #000999; border-color: #000999;">
                <i class="fa fa-plus me-1"></i> Add Bank Record
            </button>
        </div>
        <div class="table-responsive">
            <table id="bankTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                    <tr>
                        <th class="text-center" style="width:50px;">No</th>
                        <th class="text-center">Tgl. Dibuat</th>
                        <th class="text-center">Status Data Bank</th>
                        <th class="text-center">Nama Pegawai / Crew</th>
                        <th class="text-center">Nama Bank</th>
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
     MODAL: Add / View Bank Form
     ============================================================ -->
<div class="modal fade" id="modalAddBank" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <!-- Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, #000999 0%, #1a237e 100%); color: #fff;">
                <h6 class="modal-title fw-bold" id="modalAddBankTitle">
                    <i class="fa fa-plus-circle me-2"></i>Tambah Data Bank
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Body -->
            <div class="modal-body bg-light position-relative">
                <div id="modalAddBankOverlay" class="position-absolute top-0 start-0 w-100 h-100 d-none" style="background: rgba(255,255,255,0.7); z-index: 10; align-items: center; justify-content: center; display: flex;">
                    <div class="spinner-border" style="color: #000999;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <form id="formAddBank">
                    <input type="hidden" name="idperson" id="bank_idperson">
                    
                    <div class="card shadow-sm border-0 mb-4">
                         <div class="card-header bg-white fw-bold text-primary border-bottom">
                            <i class="fa fa-bank me-2"></i>Form Pernyataan Data Bank
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label text-muted small mb-1 fw-bold">Status Data Bank <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm" name="status_data_bank" id="bank_status_data_bank" required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Baru">Baru</option>
                                        <option value="Tetap">Tetap</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Nama</label>
                                    <input type="text" class="form-control form-control-sm" name="fullname" id="bank_fullname" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">NPWP</label>
                                    <input type="text" class="form-control form-control-sm" name="npwp" id="bank_npwp" readonly>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label text-muted small mb-1">Alamat Rumah</label>
                                    <textarea class="form-control form-control-sm" name="address" id="bank_address_home" rows="2" readonly></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">No. Telp</label>
                                    <input type="text" class="form-control form-control-sm" name="phone" id="bank_phone" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">No. Telp Darurat</label>
                                    <input type="text" class="form-control form-control-sm" name="emergency_phone" id="bank_emergency_phone" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Hubungan</label>
                                    <input type="text" class="form-control form-control-sm" name="relation" id="bank_relation" readonly>
                                </div>
                                <div class="col-md-6"></div> <!-- spacer -->

                                <div class="col-md-12 mt-4 mb-2">
                                    <h6 class="text-primary fw-bold border-bottom pb-1"><i class="fa fa-info-circle me-1"></i> Informasi Rekening</h6>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Nama Bank / Cabang / Unit</label>
                                    <input type="text" class="form-control form-control-sm" name="bank_name" id="bank_name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">No. Rekening</label>
                                    <input type="text" class="form-control form-control-sm" name="bank_account" id="bank_account" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Pemilik Rekening</label>
                                    <input type="text" class="form-control form-control-sm" name="account_name" id="bank_account_name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Alamat Bank</label>
                                    <textarea class="form-control form-control-sm" name="bank_address" id="bank_address_bank" rows="1"></textarea>
                                </div>
                            </div>
                            
                            <div class="mt-4" style="font-size: 13px;">
                                <b>Ketentuan:</b>
                                <ol class="text-muted mb-0 pl-3">
                                    <li>Perusahaan tidak bertanggung jawab atas keterlambatan pengiriman yang disebabkan oleh prosedur Bank yang ditunjuk atau kesalahan penulisan data Bank oleh Crew yang bersangkutan.</li>
                                    <li>Crew harus melampirkan fotocopy rekening Bank yang ditunjuk.</li>
                                    <li>Rekening Bank yang ditunjuk ini berlaku selama kontrak kerja dan tidak dapat diganti tanpa persetujuan dari Crew Manager dengan menyebutkan alasan yang jelas.</li>
                                </ol>
                                <div class="mt-2 text-danger fst-italic">
                                    Saya menyetujui semua ketentuan yang berlaku dan mengakui formulir ini telah diisi dengan benar serta menerima semua konsekuensi dari isi form ini.
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" style="font-family: 'Times New Roman', Times, serif;">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary px-4" id="btnSubmitBank" style="font-family: 'Times New Roman', Times, serif;"><i class="fa fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-sm btn-primary px-4 d-none" id="btnGeneratePdfFromModalBank" style="font-family: 'Times New Roman', Times, serif;"><i class="fa fa-print me-1"></i> Print PDF</button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form for PDF generation -->
<form id="formPdfBank" method="POST" target="_blank" action="<?php echo base_url('ListReport/Bank/print_bank_pdf'); ?>" style="display:none;">
    <input type="hidden" name="id_report_bank" id="pdf_id_report_bank">
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
    var BASE_URL_BANK = '<?php echo base_url("ListReport/Bank/"); ?>';
    
    // Get idperson from contentArea
    var idperson = $('#contentArea').data('idperson');
    if (!idperson) {
        console.error('ID Person tidak ditemukan untuk Bank');
        return;
    }

    // ================================
    // DataTables Initialization
    // ================================
    var bankTable = $('#bankTable').DataTable({
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
            url: BASE_URL_BANK + '/get_report_bank',
            type: 'POST',
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
                data: 'created_at', 
                className: 'text-center fw-bold',
                render: function(data) {
                    if(!data) return '-';
                    var d = new Date(data);
                    var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    return ('0' + d.getDate()).slice(-2) + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
                }
            },
            { 
                data: 'status_data_bank', 
                className: 'text-center',
                render: function(data) {
                    if (data == 'Baru') {
                        return '<span class="badge bg-success">Baru</span>';
                    } else if (data == 'Tetap') {
                        return '<span class="badge bg-warning text-dark">Tetap</span>';
                    }
                    return data;
                }
            },
            { data: 'fullname', className: 'text-center' },
            { data: 'bank_name', className: 'text-center' },
            {
                data: null,
                className: 'text-center',
                orderable: false,
                searchable: false,
                render: function(data) {
                    return '<div class="btn-group btn-group-sm" role="group">' +
                        '<button type="button" class="btn btn-outline-primary btn-print-bank" title="Print/View PDF" data-id="' + data.id + '">' +
                            '<i class="fa fa-eye"></i>' +
                        '</button>' +
                        '<button type="button" class="btn btn-outline-danger btn-delete-bank" title="Delete" data-id="' + data.id + '">' +
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
            emptyTable: 'Tidak ada data Bank',
            zeroRecords: 'Data tidak ditemukan'
        }
    });

    // Column search sync
    $('#bankTable thead tr:last th').each(function(i) {
        $('input', this).on('keyup change', function() {
            if (bankTable.column(i).search() !== this.value) {
                bankTable.column(i).search(this.value).draw();
            }
        });
    });

    // ================================
    // ADD BANK
    // ================================
    $('#btnGlobalAddBank').on('click', function() {
        openAddBankModal();
    });

    function openAddBankModal() {
        $('#formAddBank')[0].reset();
        $('#bank_idperson').val(idperson);
        $('#modalAddBankTitle').html('<i class="fa fa-plus-circle me-2"></i>Tambah Data Bank');

        // Apply Layout Mode: Create
        $('#btnSubmitBank').removeClass('d-none');
        $('#btnGeneratePdfFromModalBank').addClass('d-none');
        $('#formAddBank input, #formAddBank select, #formAddBank textarea').prop('disabled', false);

        // Fetch Person Data mapping logic
        $('#modalAddBankOverlay').removeClass('d-none');
        $('#modalAddBank').modal('show');

        // Fetch Data from getDataBankCrew matching function
        $.ajax({
            url: BASE_URL_BANK + '/getDataBankCrew',
            type: 'POST',
            data: { idperson: idperson },
            dataType: 'json',
            success: function(res) {
                $('#modalAddBankOverlay').addClass('d-none');
                if (res.success && res.data.length > 0) {
                    var pd = res.data[0];
                    $('#bank_fullname').val(pd.fullname);
                    $('#bank_npwp').val(pd.npwp);
                    $('#bank_address_home').val(pd.address);
                    $('#bank_phone').val(pd.phone);
                    $('#bank_emergency_phone').val(pd.emergency_phone);
                    $('#bank_relation').val(pd.relation);
                    $('#bank_name').val(pd.bank_name);
                    $('#bank_account').val(pd.bank_account);
                    $('#bank_account_name').val(pd.account_name);
                    // bank_address not included in getDataBankCrew initially so it is empty for user to type
                } else {
                    bankNotify('warning', 'Data personal tidak ditemukan.');
                }
            },
            error: function() {
                $('#modalAddBankOverlay').addClass('d-none');
                bankNotify('error', 'Terjadi kesalahan sistem saat memuat data crew.');
            }
        });
    }

    $('#btnSubmitBank').on('click', function() {
        var form = $('#formAddBank')[0];
        if (!form.reportValidity()) return;

        var formData = new FormData(form);
        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin ms-1"></i> Menyimpan...');

        $.ajax({
            url: BASE_URL_BANK + '/save_bank',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                btn.prop('disabled', false).html('Simpan');
                if (res.success) {
                    $('#modalAddBank').modal('hide');
                    bankTable.ajax.reload(null, false);
                    bankNotify('success', res.message);
                } else {
                    bankNotify('error', res.message);
                }
            },
            error: function() {
                btn.prop('disabled', false).html('Simpan');
                bankNotify('error', 'Terjadi kesalahan sistem');
            }
        });
    });

    // ================================
    // VIEW / DETAIL BANK
    // ================================
    $('#bankTable').on('click', '.btn-print-bank', function() {
        var id = $(this).data('id');

        $('#formAddBank')[0].reset();
        $('#pdf_id_report_bank').val(id);
        $('#modalAddBankTitle').html('<i class="fa fa-file-text-o me-2"></i>Detail Data Bank');

        // Apply Layout Mode: View
        $('#btnSubmitBank').addClass('d-none');
        $('#btnGeneratePdfFromModalBank').removeClass('d-none');
        $('#formAddBank input, #formAddBank select, #formAddBank textarea').prop('disabled', true);
        
        $('#modalAddBankOverlay').removeClass('d-none');
        $('#modalAddBank').modal('show');

        $.ajax({
            url: BASE_URL_BANK + '/get_report_bank_detail',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(res) {
                $('#modalAddBankOverlay').addClass('d-none');
                if (res.success) {
                    var b = res.data;
                    $('#bank_status_data_bank').val(b.status_data_bank);
                    $('#bank_fullname').val(b.fullname);
                    $('#bank_npwp').val(b.npwp);
                    $('#bank_address_home').val(b.address);
                    $('#bank_phone').val(b.phone);
                    $('#bank_emergency_phone').val(b.emergency_phone);
                    $('#bank_relation').val(b.relation);
                    $('#bank_name').val(b.bank_name);
                    $('#bank_account').val(b.bank_account);
                    $('#bank_account_name').val(b.account_name);
                    $('#bank_address_bank').val(b.bank_address);
                } else {
                    bankNotify('error', res.message);
                    $('#modalAddBank').modal('hide');
                }
            },
            error: function() {
                $('#modalAddBankOverlay').addClass('d-none');
                bankNotify('error', 'Gagal memuat detail');
                $('#modalAddBank').modal('hide');
            }
        });
    });

    $('#btnGeneratePdfFromModalBank').on('click', function() {
        $('#formPdfBank').submit();
    });

    // ================================
    // DELETE BANK
    // ================================
    $('#bankTable').on('click', '.btn-delete-bank', function() {
        var id = $(this).data('id');

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Data Bank?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus'
            }).then(function(result) {
                if (result.isConfirmed) doDeleteBank(id);
            });
        } else {
            if (confirm('Yakin ingin menghapus data Bank ini?')) {
                doDeleteBank(id);
            }
        }
    });

    function doDeleteBank(id) {
        $.ajax({
            url: BASE_URL_BANK + '/delete_report_bank',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    bankTable.ajax.reload(null, false);
                    bankNotify('success', res.message);
                } else {
                    bankNotify('error', res.message);
                }
            }
        });
    }

    // Helper notification
    function bankNotify(type, msg) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type,
                title: type === 'success' ? 'Sukses' : 'Error',
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
