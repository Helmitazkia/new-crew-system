<!-- Briefing Module View — Loaded via AJAX -->
<div class="card shadow-sm border-0" id="briefingModuleWrapper">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-sm rounded shadow-sm" id="btnAddBriefing"
                style="background-color: #000999; border-color: #000999;">
                <i class="fa fa-plus me-1"></i> Add Briefing
            </button>
        </div>
        <div class="table-responsive">
            <table id="briefingTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                    <tr>
                        <th class="text-center" style="width:50px;">No</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Rank</th>
                        <th class="text-center">Vessel Name</th>
                        <th class="text-center">Briefing Date</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Date Created</th>
                        <th class="text-center" style="width:150px;">Action</th>
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
     MODAL: Add / View Briefing
     ============================================================ -->
<div class="modal fade" id="modalBriefing" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">

            <div class="modal-header"
                style="background: linear-gradient(135deg, #000999 0%, #1a237e 100%); color: #fff;">
                <h6 class="modal-title fw-bold">
                    <i class="fa fa-file-text-o me-2"></i>Briefing Form
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    style="filter: invert(1) grayscale(100%) brightness(200%);"></button>
            </div>

            <div class="modal-body bg-light"
                style="padding:30px 40px; font-family:'Times New Roman', serif; font-size:13px; background-color: #fff !important; max-height: 75vh; overflow-y: auto;">
                
                <div class="alert alert-info" id="linkAlert" style="display:none;">
                    <strong>Link for Crew:</strong> <br>
                    <a href="#" id="linkUrl" target="_blank" class="text-break"></a>
                    <button type="button" class="btn btn-sm btn-outline-primary ms-2 mt-1" id="btnCopyLink">
                        <i class="fa fa-copy"></i> Copy
                    </button>
                </div>

                <form id="formAddBriefing" style="width: 100%;">
                    <input type="hidden" name="id" id="brf_id">
                    <input type="hidden" name="idperson" id="brf_idperson">

                    <!-- Header Info -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="fw-bold mb-1">Name</label>
                                <input type="text" class="form-control form-control-sm brf-input" name="nama_crew" id="brf_nama_crew">
                            </div>
                            <div class="form-group mb-2">
                                <label class="fw-bold mb-1">Vessel Name</label>
                                <input type="text" class="form-control form-control-sm brf-input" name="vessel" id="brf_vessel">
                            </div>
                            <div class="form-group mb-2">
                                <label class="fw-bold mb-1">Prior Joining Vessel</label>
                                <input type="text" class="form-control form-control-sm brf-input" name="prior_joining_vessel" id="brf_prior_joining_vessel">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-2">
                                <label class="fw-bold mb-1">Rank</label>
                                <input type="text" class="form-control form-control-sm brf-input" name="rank" id="brf_rank">
                            </div>
                            <div class="form-group mb-2">
                                <label class="fw-bold mb-1">Date Briefing</label>
                                <input type="date" class="form-control form-control-sm brf-input" name="date_briefing" id="brf_date_briefing">
                            </div>
                            <div class="form-group mb-2">
                                <label class="fw-bold mb-1">On the above by Mr/Ms</label>
                                <input type="text" class="form-control form-control-sm brf-input" name="mr_ms_by" id="brf_mr_ms_by">
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning mb-3">
                        <i class="fa fa-info-circle me-1"></i> The checklist questions (54 items) will be filled by the crew via the Public Link. Just click "Save & Generate Link" to obtain the URL.
                    </div>

                    <!-- Note -->
                    <div class="form-group mb-3">
                        <label for="brf_note" class="fw-bold mb-2">Note :</label>
                        <textarea class="form-control brf-input" name="note" id="brf_note" rows="3"
                            placeholder="Enter notes here..."></textarea>
                    </div>

                </form>
            </div>

            <div class="modal-footer bg-light" style="justify-content:flex-end;">
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal"
                    style="font-family: 'Times New Roman', Times, serif;">Tutup</button>
                
                <button type="button" class="btn btn-sm btn-primary px-4" id="btnSubmitBriefingModal"
                    style="font-family: 'Times New Roman', Times, serif;"> <i class="fa fa-save"></i> Save & Generate Link</button>
                
                <button type="button" class="btn btn-sm btn-primary px-4 d-none" id="btnGeneratePdfFromModalBrf"
                    style="font-family: 'Times New Roman', Times, serif;"> <i class="fa fa-print"></i> Print PDF</button>
            </div>

        </div>
    </div>
</div>

<!-- Hidden form for PDF generation -->
<form id="formPdfBriefing" method="POST" target="_blank"
    action="<?php echo base_url('ListReport/Briefing/briefing_pdf'); ?>" style="display:none;">
    <input type="hidden" name="id_history" id="pdf_brf_id_history">
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

    .column-search {
        width: 100%;
        padding: 4px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 11px;
    }
</style>

<script>
    $(document).ready(function () {
        var BASE_URL_BRF = '<?php echo base_url("ListReport/Briefing"); ?>';
        var idperson = $('#contentArea').data('idperson');

        if (!idperson) {
            console.error('ID Person tidak ditemukan');
            return;
        }

        var briefingTable = $('#briefingTable').DataTable({
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
                url: BASE_URL_BRF + '/get_history',
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
                { data: 'nama_crew', className: 'text-center' },
                { data: 'rank', className: 'text-center' },
                { data: 'vessel', className: 'text-center' },
                { 
                    data: 'date_briefing', 
                    className: 'text-center',
                    render: function(data) {
                        return data ? data : '-';
                    }
                },
                {
                    data: 'is_submitted',
                    className: 'text-center',
                    render: function(data) {
                        if(data == 1) {
                            return '<span class="badge bg-success">Submitted</span>';
                        } else {
                            return '<span class="badge bg-warning text-dark">Pending</span>';
                        }
                    }
                },
                { data: 'date_created_fmt', className: 'text-center fw-bold' },
                {
                    data: null,
                    className: 'text-center',
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        var escNote = data.note ? data.note.replace(/"/g, '&quot;') : '';
                        var isSub = data.is_submitted == 1;
                        var colorView = isSub ? 'btn-outline-primary' : 'btn-outline-secondary';
                        
                        return '<div class="btn-group btn-group-sm" role="group">' +
                            '<button type="button" class="btn btn-outline-info btn-copy-link" title="Copy Crew Link" data-link="' + data.link_url + '">' +
                            '<i class="fa fa-link"></i>' +
                            '</button>' +
                            '<button type="button" class="btn ' + colorView + ' btn-view-brf" title="Detail / Print" ' +
                            'data-id="' + data.id + '" data-note="' + escNote + '" data-namacrew="' + data.nama_crew +
                            '" data-rank="' + data.rank + '" data-vessel="' + data.vessel +
                            '" data-date="' + data.date_briefing + '" data-mrms="' + data.mr_ms_by + 
                            '" data-prior="' + data.prior_joining_vessel + '" data-link="' + data.link_url + '">' +
                            '<i class="fa fa-eye"></i>' +
                            '</button>' +
                            '<button type="button" class="btn btn-outline-danger btn-delete-brf" title="Delete" data-id="' + data.id + '">' +
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
            }
        });

        $('#briefingTable thead tr:last th').each(function (i) {
            $('input', this).on('keyup change', function () {
                if (briefingTable.column(i).search() !== this.value) {
                    briefingTable.column(i).search(this.value).draw();
                }
            });
        });

        // ADD
        $('#btnAddBriefing').on('click', function () {
            $('#formAddBriefing')[0].reset();
            $('#brf_id').val('');
            $('#brf_idperson').val(idperson);
            $('.brf-input').prop('readonly', false);
            $('#linkAlert').hide();
            
            $.ajax({
                url: BASE_URL_BRF + '/getStatementCrew',
                type: 'POST',
                data: { idperson: idperson },
                dataType: 'json',
                success: function (res) {
                    if (res.status) {
                        var d = res.data;
                        $('#brf_nama_crew').val(d.fullname);
                        $('#brf_rank').val(d.rankname);
                        $('#brf_vessel').val(d.vesselnm);
                        $('#brf_prior_joining_vessel').val(d.vesselnm); // default dari kontrak
                        $('#btnSubmitBriefingModal').removeClass('d-none').html('<i class="fa fa-save"></i> Save & Generate Link');
                        $('#btnGeneratePdfFromModalBrf').addClass('d-none');
                        $('#modalBriefing').modal('show');
                    } else {
                        if(typeof famNotify === "function") {
                            famNotify('warning', res.message || 'Data personal tidak ditemukan');
                        } else {
                            alert(res.message);
                        }
                    }
                }
            });
        });

        // VIEW DETAIL
        $('#briefingTable').on('click', '.btn-view-brf', function () {
            var id       = $(this).data('id');
            var note     = $(this).data('note');
            var namacrew = $(this).data('namacrew');
            var rank     = $(this).data('rank');
            var vessel   = $(this).data('vessel');
            var datebrf  = $(this).data('date');
            var mrms     = $(this).data('mrms');
            var prior    = $(this).data('prior');
            var link     = $(this).data('link');

            $('#brf_id').val(id);
            $('#brf_idperson').val(idperson); // SET IDPERSON HERE
            $('#pdf_brf_id_history').val(id);

            $('#brf_nama_crew').val(namacrew);
            $('#brf_rank').val(rank);
            $('#brf_vessel').val(vessel);
            $('#brf_date_briefing').val(datebrf);
            $('#brf_mr_ms_by').val(mrms);
            $('#brf_prior_joining_vessel').val(prior);
            $('#brf_note').val(note);

            // Show link alert
            if(link) {
                $('#linkUrl').attr('href', link).text(link);
                $('#linkAlert').show();
            } else {
                $('#linkAlert').hide();
            }

            $('#btnSubmitBriefingModal').removeClass('d-none').html('<i class="fa fa-save"></i> Update');
            $('#btnGeneratePdfFromModalBrf').removeClass('d-none');
            $('#modalBriefing').modal('show');
        });

        // SUBMIT
        $('#btnSubmitBriefingModal').on('click', function () {
            var formData = new FormData($('#formAddBriefing')[0]);
            var btn = $(this);
            var originalText = btn.html();
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin ms-1"></i> Menyimpan...');

            $.ajax({
                url: BASE_URL_BRF + '/save_history',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (res) {
                    btn.prop('disabled', false).html(originalText);
                    if (res.success) {
                        briefingTable.ajax.reload(null, false);
                        
                        if(typeof famNotify === "function") famNotify('success', res.message);
                        else alert(res.message);

                        if(res.link_url) {
                            $('#linkUrl').attr('href', res.link_url).text(res.link_url);
                            $('#linkAlert').slideDown();
                            $('#btnSubmitBriefingModal').html('<i class="fa fa-save"></i> Update');
                            $('#brf_id').val(res.id);
                            $('#pdf_brf_id_history').val(res.id);
                            $('#btnGeneratePdfFromModalBrf').removeClass('d-none');
                        }
                    } else {
                        if(typeof famNotify === "function") famNotify('error', res.message);
                        else alert(res.message);
                    }
                },
                error: function () {
                    btn.prop('disabled', false).html(originalText);
                    if(typeof famNotify === "function") famNotify('error', 'Terjadi kesalahan sistem');
                    else alert('Terjadi kesalahan sistem');
                }
            });
        });

        // PRINT FROM MODAL
        $('#btnGeneratePdfFromModalBrf').on('click', function () {
            $('#formPdfBriefing').submit();
        });

        // COPY LINK
        $(document).on('click', '.btn-copy-link, #btnCopyLink', function() {
            var link = $(this).data('link'); // from table
            if(!link) {
                link = $('#linkUrl').text(); // from modal
            }
            
            if(link) {
                navigator.clipboard.writeText(link).then(function() {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Link disalin!',
                            text: 'Link berhasil disalin ke clipboard.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else if(typeof famNotify === "function") {
                        famNotify('success', 'Link disalin ke clipboard');
                    } else {
                        alert('Link copied!');
                    }
                }, function() {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Error', 'Gagal menyalin link', 'error');
                    } else {
                        alert('Gagal menyalin link');
                    }
                });
            }
        });

        // DELETE
        $('#briefingTable').on('click', '.btn-delete-brf', function () {
            var id = $(this).data('id');
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Hapus History?',
                    text: 'Data yang dihapus tidak dapat dikembalikan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        doDelete(id);
                    }
                });
            } else {
                if(confirm('Hapus History?')) doDelete(id);
            }

            function doDelete(id) {
                $.post(BASE_URL_BRF + '/delete_history', { id: id }, function (res) {
                    var r = JSON.parse(res);
                    if (r.success) {
                        briefingTable.ajax.reload(null, false);
                        if(typeof famNotify === "function") famNotify('success', r.message);
                    } else {
                        if(typeof famNotify === "function") famNotify('error', r.message);
                    }
                });
            }
        });

    });
</script>
