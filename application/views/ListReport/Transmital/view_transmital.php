<!-- ============================================================
     Transmital Module View — Loaded via AJAX
     Features: DataTables, Add Form, Generate PDF
     ============================================================ -->

<div class="card shadow-sm border-0" id="transmitalModuleWrapper">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-sm rounded shadow-sm" id="btnGlobalAddTransmital" style="background-color: #000999; border-color: #000999;">
                <i class="fa fa-plus me-1"></i> Add Transmital
            </button>
        </div>
        <div class="table-responsive">
            <table id="transmitalTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                    <tr>
                        <th class="text-center" style="width:50px;">No</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Rank</th>
                        <th class="text-center">Vessel Name</th>
                        <th class="text-center">Date Transmital</th>
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
     MODAL: Add Transmital Form
     ============================================================ -->
<div class="modal fade" id="modalAddTransmital" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <!-- Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, #000999 0%, #1a237e 100%); color: #fff;">
                <h6 class="modal-title fw-bold" id="modalAddTransmitalTitle">
                    <i class="fa fa-plus-circle me-2"></i>Tambah Data Transmital
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Body -->
            <div class="modal-body bg-light position-relative">
                <div id="modalAddTransmitalOverlay" class="position-absolute top-0 start-0 w-100 h-100 d-none" style="background: rgba(255,255,255,0.7); z-index: 10; align-items: center; justify-content: center; display: flex;">
                    <div class="spinner-border" style="color: #000999;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <form id="formAddTransmital">
                    <input type="hidden" name="id_transmital" id="transmital_id">
                    <input type="hidden" name="idperson" id="transmital_idperson">
                    
                    <!-- Section: Person Data -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white fw-bold text-primary">
                            <i class="fa fa-user me-2"></i>Data Crew
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label text-muted small mb-1">Nama Crew</label>
                                    <input type="text" class="form-control form-control-sm bg-light" name="fullname" id="transmital_fullname" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-muted small mb-1">Rank</label>
                                    <input type="text" class="form-control form-control-sm bg-light" name="nmrank" id="transmital_nmrank" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-muted small mb-1">Vessel Name</label>
                                    <input type="text" class="form-control form-control-sm bg-light" name="nmvsl" id="transmital_nmvsl" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-muted small mb-1">Date</label>
                                    <input type="date" class="form-control form-control-sm" name="date_transmital" id="transmital_date" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Certificates -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white fw-bold text-primary">
                            <i class="fa fa-certificate me-2"></i>Certificates and Documents
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-sm align-middle" style="font-size: 12px;" id="tableCertificates">
                                <thead style="background-color: #f8f9ff;">
                                    <tr>
                                        <th style="width: 25%;">Certificates</th>
                                        <th class="text-center" style="width: 10%;">Submitted</th>
                                        <th class="text-center" style="width: 15%;">Issued</th>
                                        <th class="text-center" style="width: 15%;">Expire</th>
                                        <th style="width: 15%;">Document Number</th>
                                        <th style="width: 20%;">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Populated by JS -->
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="btnAddOtherCert"><i class="fa fa-plus"></i> Add Other Certificate</button>
                        </div>
                    </div>

                </form>
            </div>
            <!-- Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" style="font-family: 'Times New Roman', Times, serif;">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary px-4" id="btnSubmitTransmital" style="font-family: 'Times New Roman', Times, serif;"><i class="fa fa-save"></i> Save </button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form for PDF generation -->
<form id="formPdfTransmital" method="POST" target="_blank" action="<?php echo base_url('ListReport/Transmital/print_pdf'); ?>" style="display:none;">
    <input type="hidden" name="id_report_transmital" id="pdf_transmital_id_report">
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
    var BASE_URL_TRANSMITAL = '<?php echo base_url("ListReport/Transmital"); ?>';
    
    // Get idperson from contentArea
    var idperson = $('#contentArea').data('idperson');
    if (!idperson) {
        console.error('ID Person tidak ditemukan untuk Transmital');
        return;
    }

    // ================================
    // DataTables Initialization
    // ================================
    var transmitalTable = $('#transmitalTable').DataTable({
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
            url: BASE_URL_TRANSMITAL + '/get_history',
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
            { data: 'crew_name', className: 'text-center' },
            { data: 'rank', className: 'text-center' },
            { data: 'vessel', className: 'text-center' },
            { data: 'date_transmital', className: 'text-center fw-bold' },
            {
                data: null,
                className: 'text-center',
                orderable: false,
                searchable: false,
                render: function(data) {
                    return '<div class="btn-group btn-group-sm" role="group">' +
                        '<button type="button" class="btn btn-outline-primary btn-print-transmital" title="Print/View PDF" data-id="' + data.id_transmital + '">' +
                            '<i class="fa fa-print"></i>' +
                        '</button>' +
                        '<button type="button" class="btn btn-outline-warning btn-edit-transmital" title="Edit" data-id="' + data.id_transmital + '">' +
                            '<i class="fa fa-edit"></i>' +
                        '</button>' +
                        '<button type="button" class="btn btn-outline-danger btn-delete-transmital" title="Delete" data-id="' + data.id_transmital + '">' +
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
            emptyTable: 'Tidak ada data history Transmital',
            zeroRecords: 'Data tidak ditemukan'
        }
    });

    // Column search sync
    $('#transmitalTable thead tr:last th').each(function(i) {
        $('input', this).on('keyup change', function() {
            if (transmitalTable.column(i).search() !== this.value) {
                transmitalTable.column(i).search(this.value).draw();
            }
        });
    });

    // ================================
    // ADD TRANSMITAL
    // ================================
    $('#btnGlobalAddTransmital').on('click', function() {
        $('#formAddTransmital')[0].reset();
        $('#transmital_idperson').val(idperson);
        $('#transmital_id').val('');
        $('#modalAddTransmitalTitle').html('<i class="fa fa-plus-circle me-2"></i>Tambah Data Transmital');
        $('#tableCertificates tbody').empty();
        
        // Set today as default date
        var today = new Date().toISOString().split('T')[0];
        $('#transmital_date').val(today);
        
        $('#modalAddTransmitalOverlay').removeClass('d-none');
        $('#modalAddTransmital').modal('show');

        // Fetch Data
        $.ajax({
            url: BASE_URL_TRANSMITAL + '/get_form_data',
            type: 'POST',
            data: { idperson: idperson },
            dataType: 'json',
            success: function(res) {
                $('#modalAddTransmitalOverlay').addClass('d-none');
                if (res.success) {
                    if (res.crew) {
                        $('#transmital_fullname').val(res.crew.fullName);
                        $('#transmital_nmrank').val(res.crew.rankName);
                        $('#transmital_nmvsl').val(res.crew.vesselName);
                    }
                    
                    var tbody = $('#tableCertificates tbody');
                    if (res.certs && res.certs.length > 0) {
                        $.each(res.certs, function(i, cert) {
                            var tr = '<tr>' +
                                '<td class="fw-bold">' + 
                                    cert.certname + 
                                    '<input type="hidden" name="cert_id[]" value="' + cert.idcertdoc + '">' +
                                    '<input type="hidden" name="cert_name[]" value="' + cert.certname + '">' +
                                '</td>' +
                                '<td class="text-center">' +
                                    '<input type="checkbox" class="form-check-input" name="cert_submitted[' + cert.idcertdoc + ']" value="1">' +
                                '</td>' +
                                '<td class="text-center">' + 
                                    ((cert.issdate && cert.issdate !== '0000-00-00') ? cert.issdate : 'N/A') + 
                                    '<input type="hidden" name="cert_issdate[]" value="' + cert.issdate + '">' +
                                '</td>' +
                                '<td class="text-center">' + 
                                    ((cert.expdate && cert.expdate !== '0000-00-00') ? cert.expdate : 'Unlimited') + 
                                    '<input type="hidden" name="cert_expdate[]" value="' + cert.expdate + '">' +
                                '</td>' +
                                '<td>' + 
                                    cert.docno + 
                                    '<input type="hidden" name="cert_docno[]" value="' + cert.docno + '">' +
                                '</td>' +
                                '<td><input type="text" class="form-control form-control-sm" name="cert_remarks[' + cert.idcertdoc + ']"></td>' +
                            '</tr>';
                            tbody.append(tr);
                        });
                    } else {
                        tbody.append('<tr><td colspan="6" class="text-center text-muted">Belum ada sertifikat di database.</td></tr>');
                    }
                } else {
                    transmitalNotify('error', 'Gagal mengambil data.');
                }
            },
            error: function() {
                $('#modalAddTransmitalOverlay').addClass('d-none');
                transmitalNotify('error', 'Terjadi kesalahan sistem.');
            }
        });
    });
    
    // ================================
    // EDIT TRANSMITAL
    // ================================
    $('#transmitalTable').on('click', '.btn-edit-transmital', function() {
        var id = $(this).data('id');
        $('#formAddTransmital')[0].reset();
        $('#transmital_idperson').val(idperson);
        $('#transmital_id').val(id);
        $('#tableCertificates tbody').empty();
        
        $('#modalAddTransmitalTitle').html('<i class="fa fa-edit me-2"></i>Edit Data Transmital');
        $('#modalAddTransmitalOverlay').removeClass('d-none');
        $('#modalAddTransmital').modal('show');

        $.ajax({
            url: BASE_URL_TRANSMITAL + '/get_transmital_by_id',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(res) {
                $('#modalAddTransmitalOverlay').addClass('d-none');
                if (res.success && res.data) {
                    var data = res.data;
                    $('#transmital_fullname').val(data.crew_name);
                    $('#transmital_nmrank').val(data.rank);
                    $('#transmital_nmvsl').val(data.vessel);
                    $('#transmital_date').val(data.date_transmital);
                    
                    var certs = [];
                    if (data.cert_data) {
                        try {
                            certs = JSON.parse(data.cert_data);
                        } catch(e) {}
                    }
                    
                    var tbody = $('#tableCertificates tbody');
                    if (certs && certs.length > 0) {
                        $.each(certs, function(i, cert) {
                            var isOther = String(cert.idcertdoc).indexOf('other_') !== -1;
                            var isChecked = cert.submitted == '1' ? 'checked' : '';
                            
                            if (isOther) {
                                otherIdx++;
                                var tr = '<tr>' +
                                    '<td><input type="text" class="form-control form-control-sm" name="other_cert_name[' + otherIdx + ']" value="' + cert.certname + '" placeholder="Cert Name"></td>' +
                                    '<td class="text-center"><input type="checkbox" class="form-check-input" name="other_cert_submitted[' + otherIdx + ']" value="1" ' + isChecked + '></td>' +
                                    '<td><input type="date" class="form-control form-control-sm" name="other_cert_issdate[' + otherIdx + ']" value="' + cert.issdate + '"></td>' +
                                    '<td><input type="date" class="form-control form-control-sm" name="other_cert_expdate[' + otherIdx + ']" value="' + cert.expdate + '"></td>' +
                                    '<td><input type="text" class="form-control form-control-sm" name="other_cert_docno[' + otherIdx + ']" value="' + cert.docno + '" placeholder="Doc No"></td>' +
                                    '<td>' +
                                        '<div class="input-group input-group-sm">' +
                                            '<input type="text" class="form-control" name="other_cert_remarks[' + otherIdx + ']" value="' + cert.remarks + '" placeholder="Remarks">' +
                                            '<button class="btn btn-outline-danger btn-remove-other-cert" type="button" title="Remove"><i class="fa fa-times"></i></button>' +
                                        '</div>' +
                                    '</td>' +
                                '</tr>';
                                tbody.append(tr);
                            } else {
                                var tr = '<tr>' +
                                    '<td class="fw-bold">' + 
                                        cert.certname + 
                                        '<input type="hidden" name="cert_id[]" value="' + cert.idcertdoc + '">' +
                                        '<input type="hidden" name="cert_name[]" value="' + cert.certname + '">' +
                                    '</td>' +
                                    '<td class="text-center">' +
                                        '<input type="checkbox" class="form-check-input" name="cert_submitted[' + cert.idcertdoc + ']" value="1" ' + isChecked + '>' +
                                    '</td>' +
                                    '<td class="text-center">' + 
                                        ((cert.issdate && cert.issdate !== '0000-00-00') ? cert.issdate : 'N/A') + 
                                        '<input type="hidden" name="cert_issdate[]" value="' + cert.issdate + '">' +
                                    '</td>' +
                                    '<td class="text-center">' + 
                                        ((cert.expdate && cert.expdate !== '0000-00-00') ? cert.expdate : 'Unlimited') + 
                                        '<input type="hidden" name="cert_expdate[]" value="' + cert.expdate + '">' +
                                    '</td>' +
                                    '<td>' + 
                                        cert.docno + 
                                        '<input type="hidden" name="cert_docno[]" value="' + cert.docno + '">' +
                                    '</td>' +
                                    '<td><input type="text" class="form-control form-control-sm" name="cert_remarks[' + cert.idcertdoc + ']" value="' + cert.remarks + '"></td>' +
                                '</tr>';
                                tbody.append(tr);
                            }
                        });
                    } else {
                        tbody.append('<tr><td colspan="6" class="text-center text-muted">Belum ada sertifikat di database.</td></tr>');
                    }
                } else {
                    transmitalNotify('error', 'Gagal mengambil data.');
                }
            },
            error: function() {
                $('#modalAddTransmitalOverlay').addClass('d-none');
                transmitalNotify('error', 'Terjadi kesalahan sistem.');
            }
        });
    });

    // Add Other Certificate dynamically
    var otherIdx = 0;
    $('#btnAddOtherCert').on('click', function() {
        otherIdx++;
        var tr = '<tr>' +
            '<td><input type="text" class="form-control form-control-sm" name="other_cert_name[' + otherIdx + ']" placeholder="Cert Name"></td>' +
            '<td class="text-center"><input type="checkbox" class="form-check-input" name="other_cert_submitted[' + otherIdx + ']" value="1"></td>' +
            '<td><input type="date" class="form-control form-control-sm" name="other_cert_issdate[' + otherIdx + ']"></td>' +
            '<td><input type="date" class="form-control form-control-sm" name="other_cert_expdate[' + otherIdx + ']"></td>' +
            '<td><input type="text" class="form-control form-control-sm" name="other_cert_docno[' + otherIdx + ']" placeholder="Doc No"></td>' +
            '<td>' +
                '<div class="input-group input-group-sm">' +
                    '<input type="text" class="form-control" name="other_cert_remarks[' + otherIdx + ']" placeholder="Remarks">' +
                    '<button class="btn btn-outline-danger btn-remove-other-cert" type="button" title="Remove"><i class="fa fa-times"></i></button>' +
                '</div>' +
            '</td>' +
        '</tr>';
        $('#tableCertificates tbody').append(tr);
    });

    // Remove Other Certificate row
    $('#tableCertificates').on('click', '.btn-remove-other-cert', function() {
        $(this).closest('tr').remove();
    });

    $('#btnSubmitTransmital').on('click', function() {
        var form = $('#formAddTransmital')[0];
        if (!form.reportValidity()) return;

        var formData = new FormData(form);

        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin ms-1"></i> Menyimpan...');

        $.ajax({
            url: BASE_URL_TRANSMITAL + '/save_transmital',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                btn.prop('disabled', false).html('<i class="fa fa-save"></i> Save');
                if (res.success) {
                    $('#modalAddTransmital').modal('hide');
                    transmitalTable.ajax.reload(null, false);
                    transmitalNotify('success', res.message);            
                } else {
                    transmitalNotify('error', res.message);
                }
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fa fa-save"></i> Save');
                transmitalNotify('error', 'Terjadi kesalahan sistem');
            }
        });
    });

    // ================================
    // DELETE TRANSMITAL
    // ================================
    $('#transmitalTable').on('click', '.btn-delete-transmital', function() {
        var id = $(this).data('id');

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus History Transmital?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus'
            }).then(function(result) {
                if (result.isConfirmed) doDeleteTransmital(id);
            });
        } else {
            if (confirm('Yakin ingin menghapus form ini?')) {
                doDeleteTransmital(id);
            }
        }
    });

    function doDeleteTransmital(id) {
        $.ajax({
            url: BASE_URL_TRANSMITAL + '/delete_transmital',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    transmitalTable.ajax.reload(null, false);
                    transmitalNotify('success', res.message);
                } else {
                    transmitalNotify('error', res.message);
                }
            }
        });
    }

    // ================================
    // PRINT PDF
    // ================================
    $('#transmitalTable').on('click', '.btn-print-transmital', function() {
        var id = $(this).data('id');
        $('#pdf_transmital_id_report').val(id);
        $('#formPdfTransmital').submit();
    });

    // Helper notification
    function transmitalNotify(type, msg) {
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
