<!-- Familiarization Module View — Loaded via AJAX -->
<div class="card shadow-sm border-0" id="familiarModuleWrapper">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <!-- <button class="btn btn-primary btn-sm rounded shadow-sm" id="btnAddFamiliar"
                style="background-color: #000999; border-color: #000999;">
                <i class="fa fa-plus me-1"></i> Add Familiarization
            </button> -->
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
    <div class="modal-dialog modal-xl">
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
                style="padding:30px 40px; font-family:'Times New Roman', serif; font-size:13px; background-color: #fff !important; max-height: 75vh; overflow-y: auto;">
                <form id="formAddFamiliar" style="width: 100%;">
                    <input type="hidden" name="idperson" id="fam_idperson">

                    <!-- Header Info -->
                    <div class="row mb-3">
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

                    <!-- Familiarization Items Table -->
                    <div class="mb-3">
                        <label class="fw-bold mb-2" style="font-size:13px;">Familiarization Checklist :</label>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm fam-checklist-table" style="font-size:12px; font-family:'Times New Roman', serif;">
                                <thead>
                                    <tr style="background-color:#000099; color:#fff; text-align:center;">
                                        <th style="width:55%; padding:6px;">Material</th>
                                        <th style="width:25%; padding:6px;">PIC</th>
                                        <th style="width:20%; padding:6px;">✓ / ✗</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($topics)): ?>
                                        <?php foreach ($topics as $topic): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($topic->topic_name); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars(!empty($topic->dept_name) ? $topic->dept_name : '-'); ?></td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-center gap-3">
                                                        <div class="form-check form-check-inline mb-0">
                                                            <input class="form-check-input fam-radio" type="radio" name="item_<?php echo $topic->id; ?>" id="item_<?php echo $topic->id; ?>_yes" value="1">
                                                            <label class="form-check-label text-success fw-bold" for="item_<?php echo $topic->id; ?>_yes">✓</label>
                                                        </div>
                                                        <div class="form-check form-check-inline mb-0">
                                                            <input class="form-check-input fam-radio" type="radio" name="item_<?php echo $topic->id; ?>" id="item_<?php echo $topic->id; ?>_no" value="2">
                                                            <label class="form-check-label text-danger fw-bold" for="item_<?php echo $topic->id; ?>_no">✗</label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Note -->
                    <div class="form-group mb-3">
                        <label for="fam_note" class="fw-bold mb-2">Note :</label>
                        <textarea class="form-control" name="note" id="fam_note" rows="4"
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

    /* Checklist table styling */
    .fam-checklist-table thead th {
        font-size: 12px;
        vertical-align: middle;
    }

    .fam-checklist-table td {
        vertical-align: middle;
        font-size: 12px;
    }

    .fam-checklist-table .form-check-input {
        cursor: pointer;
    }

    .fam-checklist-table .form-check-label {
        cursor: pointer;
        font-size: 14px;
    }

    /* disabled state for view mode */
    .fam-radio:disabled + label {
        opacity: 0.85;
        cursor: default;
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
                            '" data-signondate="' + data.signon_date +
                            '" data-items=\'' + JSON.stringify(data.items || {}) + '\'>' +
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

        // Helper: reset semua radio button
        function resetRadios() {
            $('input[type="radio"].fam-radio').prop('checked', false).prop('disabled', false);
        }

        // Helper: set nilai radio button dari data DB
        function setRadioValues(items) {
            if (!items) return;
            $.each(items, function (key, val) {
                if (val !== null && val !== undefined && val !== '') {
                    var radioName = (typeof key === 'string' && key.indexOf('item_') === 0) ? key : 'item_' + key;
                    var numericVal = parseInt(val, 10);
                    if (numericVal === 1 || numericVal === 2) {
                        $('input[name="' + radioName + '"][value="' + numericVal + '"]').prop('checked', true);
                    }
                }
            });
        }

        // Helper: disable semua radio (mode view)
        function disableRadios() {
            $('input[type="radio"].fam-radio').prop('disabled', true);
        }

        // ADD
        $('#btnAddFamiliar').on('click', function () {
            $('#formAddFamiliar')[0].reset();
            $('#fam_idperson').val(idperson);
            $('.fam-input').prop('readonly', false);
            $('#fam_note').prop('readonly', false);
            resetRadios();

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
            var id          = $(this).data('id');
            var note        = $(this).data('note');
            var namacrew    = $(this).data('namacrew');
            var rank        = $(this).data('rank');
            var vessel      = $(this).data('vessel');
            var signondate  = $(this).data('signondate');
            var items       = $(this).data('items');

            $('#pdf_fam_id_history').val(id);

            $('#fam_nama_crew').val(namacrew).prop('readonly', true);
            $('#fam_rank').val(rank).prop('readonly', true);
            $('#fam_vessel').val(vessel).prop('readonly', true);
            $('#fam_signon_date').val(signondate).prop('readonly', true);
            $('#fam_note').val(note).prop('readonly', true);

            // Reset, set values, then disable
            resetRadios();
            if (items) {
                setRadioValues(items);
            }
            //disableRadios();

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