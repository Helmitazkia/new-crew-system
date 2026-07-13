<!-- Medical Module View -->
<div class="card shadow-sm border-0" id="medicalModuleWrapper">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-primary btn-sm" id="btnAddMedical" style="background-color: #000999; border-color: #000999;">
                <i class="fa fa-plus me-1"></i> Add Medical
            </button>
        </div>
        <div class="table-responsive">
            <table id="medicalTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                    <tr>
                        <th class="text-center" style="width:50px;">No</th>
                        <th class="text-center">Medical Item</th>
                        <th class="text-center">Issue Date</th>
                        <th class="text-center">Remark</th>
                        <th class="text-center">File</th>
                        <th class="text-center" style="width:130px;">Action</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th></th>
                        <th><input type="text" class="column-search" placeholder="Search"></th>
                        <th><input type="text" class="column-search" placeholder="Search"></th>
                        <th><input type="text" class="column-search" placeholder="Search"></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add Medical -->
<div class="modal fade" id="modalAddMedical" tabindex="-1" aria-labelledby="modalAddMedicalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formAddMedical" class="modal-content border-0 shadow">
            <div class="modal-header" style="background: linear-gradient(135deg, #000099 0%, #1a237e 100%); color: #fff;">
                <h6 class="modal-title fw-bold" id="modalAddMedicalLabel"><i class="fa fa-plus-circle me-2"></i>Add Medical Data</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Medical Item <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" name="vaccine_name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Issue Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control form-control-sm" name="vaccine_date" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Remark</label>
                    <textarea class="form-control form-control-sm" name="remark" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="font-size: 13px;">Attachment File</label>
                    <input type="file" class="form-control form-control-sm" name="vaccine_file" accept=".pdf,.jpg,.jpeg,.png">
                    <small class="text-muted">Max 5MB (PDF, JPG, PNG)</small>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-sm btn-primary" id="btnSubmitAddMedical"><i class="fa fa-save"></i> Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Medical -->
<div class="modal fade" id="modalEditMedical" tabindex="-1" aria-labelledby="modalEditMedicalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formEditMedical" class="modal-content border-0 shadow">
            <input type="hidden" name="id" id="editMedicalId">
            <div class="modal-header" style="background: linear-gradient(135deg, #000099 0%, #1a237e 100%); color: #fff;">
                <h6 class="modal-title fw-bold" id="modalEditMedicalLabel"><i class="fa fa-edit me-2"></i>Edit Medical Data</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="editSpinnerMedical" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="editContentMedical" class="d-none">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size: 13px;">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="vaccine_name" id="editVaccineName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size: 13px;">Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-sm" name="vaccine_date" id="editVaccineDate" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size: 13px;">Remark</label>
                        <textarea class="form-control form-control-sm" name="remark" id="editRemark" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size: 13px;">Attachment File</label>
                        <div class="mb-1" id="currentFileMedical"></div>
                        <input type="file" class="form-control form-control-sm" name="vaccine_file" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="text-muted">Upload file baru untuk menggantikan (Max 5MB)</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-sm btn-primary d-none" id="btnSubmitEditMedical"><i class="fa fa-save"></i> Save Changes</button>
            </div>
        </form>
    </div>
</div>

<style>
.crew-table th, .crew-table td { font-size: var(--crew-font-sm, 12px); vertical-align: middle; }
.crew-table th { font-weight: 600; text-align: center; }
.crew-table .btn { font-size: var(--crew-font-xs, 11px); padding: 4px 8px; }
.crew-header th { background-color: var(--crew-blue, #000099) !important; color: #fff !important; }
.column-search { width: 100%; padding: 4px; border: 1px solid #ced4da; border-radius: 4px; font-size: 11px; }
.dataTables_wrapper { padding: 15px 0; }
.dataTables_length { padding: 10px 0; margin-bottom: 10px; }
.dataTables_filter { text-align: right; margin-bottom: 10px; }
.dataTables_paginate { margin-top: 15px; padding-top: 10px; border-top: 1px solid #dee2e6; }
.paginate_button { margin: 0 2px; padding: 6px 12px !important; border-radius: 4px; border: 1px solid #dee2e6; background: #fff !important; color: #0d6efd !important; cursor: pointer; }
.paginate_button.current { background: #0d6efd !important; color: #fff !important; border-color: #0d6efd !important; }
.paginate_button:hover { background: #e9ecef !important; border-color: #dee2e6; }
.dataTables_info { padding: 10px 0; color: #6c757d; font-size: 14px; }
</style>

<script>
$(document).ready(function() {
    var BASE_URL = '<?php echo base_url("ListReport/Medical"); ?>';
    var BASE_FILE_URL = '<?php echo base_url("uploadFile"); ?>';
    
    var idperson = $('#contentArea').data('idperson');
    if (!idperson) {
        console.error('ID Person tidak ditemukan');
        return;
    }

    var medicalTable = $('#medicalTable').DataTable({
        processing: true,
        serverSide: false,
        searching: true,
        paging: true,
        info: true,
        lengthChange: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        language: {
            lengthMenu: '_MENU_ &nbsp;Entries'
        },
        ajax: {
            url: BASE_URL + '/get_data',
            type: 'POST',
            data: { idperson: idperson },
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
            { data: 'vaccine_name' },
            { 
                data: 'vaccine_date', 
                className: 'text-center',
                render: function(data, type, row) {
                    if (type === 'display') {
                        return row.vaccine_date_formatted || data || '-';
                    }
                    return data;
                }
            },
            { data: 'remark' },
            {
                data: 'vaccine_file',
                className: 'text-center',
                render: function(data) {
                    if (data && data !== '') {
                        return '<a href="' + BASE_FILE_URL + '/' + data + '" target="_blank" class="badge bg-info text-decoration-none"><i class="fa fa-file me-1"></i> View</a>';
                    }
                    return '-';
                }
            },
            {
                data: null,
                className: 'text-center',
                orderable: false,
                searchable: false,
                render: function(data) {
                    return '<div class="btn-group btn-group-sm" role="group">' +
                        '<button type="button" class="btn btn-outline-primary btn-edit-medical" title="Edit" data-id="' + data.id + '">' +
                            '<i class="fa fa-edit"></i>' +
                        '</button>' +
                        '<button type="button" class="btn btn-outline-danger btn-delete-medical" title="Delete" data-id="' + data.id + '">' +
                            '<i class="fa fa-trash"></i>' +
                        '</button>' +
                    '</div>';
                }
            }
        ]
    });

    // Column search sync
    $('#medicalTable thead tr:last th').each(function(i) {
        $('input', this).on('keyup change', function() {
            if (medicalTable.column(i).search() !== this.value) {
                medicalTable.column(i).search(this.value).draw();
            }
        });
    });

    // Modal Add
    $('#btnAddMedical').click(function() {
        $('#formAddMedical')[0].reset();
        var modal = new bootstrap.Modal(document.getElementById('modalAddMedical'));
        modal.show();
    });

    // Form Submit Add
    $('#formAddMedical').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('idperson', idperson);
        
        var btn = $('#btnSubmitAddMedical');
        var originalText = btn.html();
        btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...').prop('disabled', true);

        $.ajax({
            url: BASE_URL + '/add_data',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                btn.html(originalText).prop('disabled', false);
                if (res.success) {
                    bootstrap.Modal.getInstance(document.getElementById('modalAddMedical')).hide();
                    medicalTable.ajax.reload(null, false);
                    medicalNotify('success', res.message);
                } else {
                    medicalNotify('error', res.message);
                }
            },
            error: function() {
                btn.html(originalText).prop('disabled', false);
                medicalNotify('error', 'Terjadi kesalahan server');
            }
        });
    });

    // Edit Medical
    $('#medicalTable').on('click', '.btn-edit-medical', function() {
        var id = $(this).data('id');
        
        $('#editMedicalId').val(id);
        $('#editSpinnerMedical').show();
        $('#editContentMedical').addClass('d-none');
        $('#btnSubmitEditMedical').addClass('d-none');
        var modal = new bootstrap.Modal(document.getElementById('modalEditMedical'));
        modal.show();

        $.ajax({
            url: BASE_URL + '/get_detail',
            type: 'POST',
            data: { id: id, idperson: idperson },
            dataType: 'json',
            success: function(res) {
                $('#editSpinnerMedical').hide();
                if (res.success) {
                    $('#editVaccineName').val(res.data.vaccine_name || '');
                    $('#editVaccineDate').val(res.data.vaccine_date || '');
                    $('#editRemark').val(res.data.remark || '');
                    
                    if (res.data.vaccine_file) {
                        $('#currentFileMedical').html('<a href="' + BASE_FILE_URL + '/' + res.data.vaccine_file + '" target="_blank" class="badge bg-info text-decoration-none mb-2 d-inline-block"><i class="fa fa-file me-1"></i> Current File</a>');
                    } else {
                        $('#currentFileMedical').html('<span class="text-muted small">No file attached</span>');
                    }
                    
                    $('#editContentMedical').removeClass('d-none');
                    $('#btnSubmitEditMedical').removeClass('d-none');
                } else {
                    $('#editContentMedical').removeClass('d-none').html('<p class="text-danger">' + res.message + '</p>');
                }
            },
            error: function() {
                $('#editSpinnerMedical').hide();
                $('#editContentMedical').removeClass('d-none').html('<p class="text-danger">Failed to load data.</p>');
            }
        });
    });

    // Form Submit Edit
    $('#formEditMedical').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('idperson', idperson);
        
        var btn = $('#btnSubmitEditMedical');
        var originalText = btn.html();
        btn.html('<i class="fa fa-spinner fa-spin"></i> Saving...').prop('disabled', true);

        $.ajax({
            url: BASE_URL + '/update_data',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                btn.html(originalText).prop('disabled', false);
                if (res.success) {
                    bootstrap.Modal.getInstance(document.getElementById('modalEditMedical')).hide();
                    medicalTable.ajax.reload(null, false);
                    medicalNotify('success', res.message);
                } else {
                    medicalNotify('error', res.message);
                }
            },
            error: function() {
                btn.html(originalText).prop('disabled', false);
                medicalNotify('error', 'Terjadi kesalahan server');
            }
        });
    });

    // Delete Medical
    $('#medicalTable').on('click', '.btn-delete-medical', function() {
        var id = $(this).data('id');

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Data?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus'
            }).then(function(result) {
                if (result.isConfirmed) {
                    doDeleteMedical(id);
                }
            });
        } else {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                doDeleteMedical(id);
            }
        }
    });

    function doDeleteMedical(id) {
        $.ajax({
            url: BASE_URL + '/delete_data',
            type: 'POST',
            data: { id: id, idperson: idperson },
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    medicalTable.ajax.reload(null, false);
                    medicalNotify('success', res.message);
                } else {
                    medicalNotify('error', res.message);
                }
            },
            error: function() {
                medicalNotify('error', 'Terjadi kesalahan server');
            }
        });
    }

    // Helper notification
    function medicalNotify(type, msg) {
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
