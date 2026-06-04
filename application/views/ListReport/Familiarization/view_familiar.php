<!-- Familiarization Module View — Loaded via AJAX -->
<div class="card shadow-sm border-0" id="familiarModuleWrapper">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-sm rounded shadow-sm" id="btnAddFamiliar"
                style="background-color: #000999; border-color: #000999;">
                <i class="fa fa-plus me-1"></i> Add Familiarization
            </button>
        </div>
        <div class="table-responsive">
            <table id="familiarTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                    <tr>
                        <th class="text-center" style="width:50px;">No</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Rank</th>
                        <th class="text-center">Vessel Name</th>
                        <th class="text-center">Sign On Date</th>
                        <th class="text-center">Date Created</th>
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
     MODAL: Add / View Familiarization
     ============================================================ -->
<div class="modal fade" id="modalFamiliar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">

            <div class="modal-header"
                style="background: linear-gradient(135deg, #000999 0%, #1a237e 100%); color: #fff;">
                <h6 class="modal-title fw-bold">
                    <i class="fa fa-file-text-o me-2"></i>Familiarization Form
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    style="filter: invert(1) grayscale(100%) brightness(200%);"></button>
            </div>

            <div class="modal-body bg-light"
                style="padding:40px 55px; font-family:'Times New Roman', serif; font-size:14px; background-color: #fff !important; max-height: 70vh; overflow-y: auto;">
                <form id="formAddFamiliar" style="width: 100%;">
                    <input type="hidden" name="idperson" id="fam_idperson">

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="fw-bold mb-1">Name</label>
                                <input type="text" class="form-control form-control-sm fam-input" name="nama_crew"
                                    id="fam_nama_crew">
                            </div>
                            <div class="form-group mb-2">
                                <label class="fw-bold mb-1">Vessel Name</label>
                                <input type="text" class="form-control form-control-sm fam-input" name="vessel"
                                    id="fam_vessel">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="fw-bold mb-1">Rank</label>
                                <input type="text" class="form-control form-control-sm fam-input" name="rank"
                                    id="fam_rank">
                            </div>
                            <div class="form-group mb-2">
                                <label class="fw-bold mb-1">Sign On Date</label>
                                <input type="date" class="form-control form-control-sm fam-input" name="signon_date"
                                    id="fam_signon_date">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="fam_note" class="fw-bold mb-2">Note :</label>
                        <textarea class="form-control" name="note" id="fam_note" rows="5"
                            placeholder="Enter familiarization notes here..."></textarea>
                    </div>

                </form>
            </div>

            <div class="modal-footer bg-light" style="justify-content:flex-end;">
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal"
                    style="font-family: 'Times New Roman', Times, serif;">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary px-4" id="btnSubmitFamiliar"
                    style="font-family: 'Times New Roman', Times, serif;"> <i class="fa fa-save"></i> Save &
                    Print</button>
                <button type="button" class="btn btn-sm btn-primary px-4 d-none" id="btnGeneratePdfFromModalFam"
                    style="font-family: 'Times New Roman', Times, serif;"> <i class="fa fa-print"></i> Print</button>
            </div>

        </div>
    </div>
</div>

<!-- Hidden form for PDF generation -->
<form id="formPdfFamiliar" method="POST" target="_blank"
    action="<?php echo base_url('ListReport/Familiarization/familiarization_pdf'); ?>" style="display:none;">
    <input type="hidden" name="id_history" id="pdf_fam_id_history">
</form>

<!-- ============================================================
     STYLES & SCRIPTS
     ============================================================ -->
<style>
    .crew-table th,
    .crew-table td {
        font-size: 12px;
        vertical-align: middle;
    }

    .crew-header th {
        background-color: #000099 !important;
        color: #fff !important;
    }

    .card-header i {
        color: #000099;
    }

    .column-search {
        width: 100%;
        padding: 4px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 11px;
    }

    .dataTables_wrapper {
        padding: 15px 0;
    }

    .dataTables_length {
        padding: 10px 0;
        margin-bottom: 10px;
    }

    .dataTables_length label,
    .dataTables_filter label {
        display: flex;
        align-items: center;
        margin: 0;
        padding: 20px 0;
    }

    .dataTables_length select {
        width: auto;
        margin: 0 8px;
        padding: 4px 8px;
        border-radius: 4px;
        border: 1px solid #ced4da;
    }

    .dataTables_filter {
        text-align: right;
        margin-bottom: 10px;
    }

    .dataTables_filter label {
        display: inline-flex;
        align-items: center;
        margin: 0;
        padding: 8px 0;
        font-weight: normal;
    }

    .dataTables_filter input {
        margin-left: 10px;
        padding: 6px 12px;
        border-radius: 4px;
        border: 1px solid #ced4da;
        width: 200px;
    }

    .dataTables_paginate {
        margin-top: 15px;
        padding-top: 10px;
        border-top: 1px solid #dee2e6;
    }

    .paginate_button {
        margin: 0 2px;
        padding: 6px 12px !important;
        border-radius: 4px;
        border: 1px solid #dee2e6;
        background: #fff !important;
        color: #0d6efd !important;
        cursor: pointer;
    }

    .paginate_button.current {
        background: #0d6efd !important;
        color: #fff !important;
        border-color: #0d6efd !important;
    }

    .paginate_button:hover {
        background: #e9ecef !important;
        border-color: #dee2e6;
    }

    .dataTables_info {
        padding: 10px 0;
        color: #6c757d;
        font-size: 14px;
    }
</style>

<script>
    $(document).ready(function () {
        var BASE_URL_FAM = '<?php echo base_url("ListReport/Familiarization"); ?>';
        var idperson = $('#contentArea').data('idperson');

        if (!idperson) {
            console.error('ID Person tidak ditemukan');
            return;
        }

        var famTable = $('#familiarTable').DataTable({
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
                url: BASE_URL_FAM + '/get_history',
                type: 'POST',
                data: function (d) {
                    d.idperson = idperson;
                },
                dataSrc: function (json) {
                    return json.success ? json.data : [];
                }
            },
            columns: [{
                    data: null,
                    className: 'fw-bold text-center',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'nama_crew',
                    className: 'text-center'
                },
                {
                    data: 'rank',
                    className: 'text-center'
                },
                {
                    data: 'vessel',
                    className: 'text-center'
                },
                {
                    data: 'signon_date',
                    className: 'text-center'
                },
                {
                    data: 'date_created_fmt',
                    className: 'text-center fw-bold'
                },
                {
                    data: null,
                    className: 'text-center',
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        return '<div class="btn-group btn-group-sm" role="group">' +
                            '<button type="button" class="btn btn-outline-primary btn-view-fam" title="Print/View PDF" data-id="' +
                            data.id + '" data-note="' + (data.note ? data.note.replace(/"/g,
                                '&quot;') : '') + '" data-namacrew="' + data.nama_crew +
                            '" data-rank="' + data.rank + '" data-vessel="' + data.vessel +
                            '" data-signondate="' + data.signon_date + '">' +
                            '<i class="fa fa-eye"></i>' +
                            '</button>' +
                            '<button type="button" class="btn btn-outline-danger btn-delete-fam" title="Delete" data-id="' +
                            data.id + '">' +
                            '<i class="fa fa-trash"></i>' +
                            '</button>' +
                            '</div>';
                    }
                }
            ],
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var header = $(column.header());
                    if (header.find('.column-search').length) {
                        header.find('.column-search').on('keyup change', function () {
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

        $('#familiarTable thead tr:last th').each(function (i) {
            $('input', this).on('keyup change', function () {
                if (famTable.column(i).search() !== this.value) {
                    famTable.column(i).search(this.value).draw();
                }
            });
        });

        // ADD
        $('#btnAddFamiliar').on('click', function () {
            $('#formAddFamiliar')[0].reset();
            $('#fam_idperson').val(idperson);
            $('.fam-input').prop('readonly', false);
            $('#fam_note').prop('readonly', false);

            $.ajax({
                url: BASE_URL_FAM + '/getStatementCrew',
                type: 'POST',
                data: {
                    idperson: idperson
                },
                dataType: 'json',
                success: function (res) {
                    if (res.status) {
                        var d = res.data;

                        // Set inputs for saving
                        $('#fam_nama_crew').val(d.fullname);
                        $('#fam_rank').val(d.rankname);
                        $('#fam_vessel').val(d.vesselnm);
                        $('#fam_signon_date').val(d.signondt);

                        $('#btnSubmitFamiliar').removeClass('d-none');
                        $('#btnGeneratePdfFromModalFam').addClass('d-none');

                        $('#modalFamiliar').modal('show');
                    } else {
                        famNotify('warning', res.message ||
                        'Data personal tidak ditemukan');
                    }
                }
            });
        });

        // VIEW DETAIL
        $('#familiarTable').on('click', '.btn-view-fam', function () {
            var id = $(this).data('id');
            var note = $(this).data('note');
            var namacrew = $(this).data('namacrew');
            var rank = $(this).data('rank');
            var vessel = $(this).data('vessel');
            var signondate = $(this).data('signondate');

            $('#pdf_fam_id_history').val(id);

            $('#fam_nama_crew').val(namacrew).prop('readonly', true);
            $('#fam_rank').val(rank).prop('readonly', true);
            $('#fam_vessel').val(vessel).prop('readonly', true);
            $('#fam_signon_date').val(signondate).prop('readonly', true);

            $('#fam_note').val(note).prop('readonly', true);

            $('#btnSubmitFamiliar').addClass('d-none');
            $('#btnGeneratePdfFromModalFam').removeClass('d-none');

            $('#modalFamiliar').modal('show');
        });

        // SUBMIT
        $('#btnSubmitFamiliar').on('click', function () {
            var formData = new FormData($('#formAddFamiliar')[0]);
            var btn = $(this);
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin ms-1"></i> Menyimpan...');

            $.ajax({
                url: BASE_URL_FAM + '/save_history',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (res) {
                    btn.prop('disabled', false).html('Simpan & Print');
                    if (res.success) {
                        $('#modalFamiliar').modal('hide');
                        famTable.ajax.reload(null, false);
                        famNotify('success', res.message);

                        // Auto print PDF
                        $('#pdf_fam_id_history').val(res.id);
                        $('#formPdfFamiliar').submit();
                    } else {
                        famNotify('error', res.message);
                    }
                },
                error: function () {
                    btn.prop('disabled', false).html('Simpan & Print');
                    famNotify('error', 'Terjadi kesalahan sistem');
                }
            });
        });

        // PRINT FROM MODAL
        $('#btnGeneratePdfFromModalFam').on('click', function () {
            $('#formPdfFamiliar').submit();
        });

        // DELETE
        $('#familiarTable').on('click', '.btn-delete-fam', function () {
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
                }).then(function (result) {
                    if (result.isConfirmed) doDeleteFam(id);
                });
            } else {
                if (confirm('Yakin ingin menghapus history ini?')) {
                    doDeleteFam(id);
                }
            }
        });

        function doDeleteFam(id) {
            $.ajax({
                url: BASE_URL_FAM + '/delete_history',
                type: 'POST',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        famTable.ajax.reload(null, false);
                        famNotify('success', res.message);
                    } else {
                        famNotify('error', res.message);
                    }
                }
            });
        }

        function famNotify(type, msg) {
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