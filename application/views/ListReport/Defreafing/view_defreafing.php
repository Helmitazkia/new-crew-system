<!-- ============================================================
     Debriefing Module View — Loaded via AJAX
     Features: DataTables, Add Debriefing, Generate PDF
     ============================================================ -->

<div class="card shadow-sm border-0" id="debModuleWrapper">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-sm rounded shadow-sm" id="btnAddDebriefing" style="background-color: #000999; border-color: #000999;">
                <i class="fa fa-plus me-1"></i> Add Debriefing
            </button>
        </div>
        <div class="table-responsive">
            <table id="debriefingTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
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
     MODAL: Add Debriefing
     ============================================================ -->
<div class="modal fade" id="modalAddDebriefing" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <!-- Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, #000099 0%, #1a237e 100%); color: #fff;">
                <h6 class="modal-title fw-bold">
                    <i class="fa fa-plus-circle me-2"></i>Tambah Debriefing
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Body -->
            <div class="modal-body bg-light">
                <form id="formAddDebriefing">
                    <input type="hidden" name="idperson" id="deb_idperson">
                    
                    <!-- Section: Person Data -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white fw-bold text-primary">
                            <i class="fa fa-user me-2"></i>Data Crew
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1">Nama Crew</label>
                                    <input type="text" class="form-control form-control-sm" name="nama_crew" id="deb_nama_crew" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1">Jabatan</label>
                                    <input type="text" class="form-control form-control-sm" name="jabatan" id="deb_jabatan" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1">No. Telepon / HP</label>
                                    <input type="text" class="form-control form-control-sm" name="no_telp" id="deb_no_telp">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1">Nama Kapal</label>
                                    <input type="text" class="form-control form-control-sm" name="vessel" id="deb_vessel" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1">Pelabuhan</label>
                                    <input type="text" class="form-control form-control-sm" name="pelabuhan" id="deb_pelabuhan" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1">Tgl. Join (Sign On)</label>
                                    <input type="date" class="form-control form-control-sm" name="tgl_join" id="deb_tgl_join">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1">Tgl. Sign Off</label>
                                    <input type="date" class="form-control form-control-sm" name="tgl_signoff" id="deb_tgl_signoff">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small mb-1 text-dark">Kesiapan Join <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control form-control-sm border-primary" name="siap_join" id="deb_siap_join" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: certificates -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white fw-bold text-primary">
                            <i class="fa fa-file-text me-2"></i>Certificates / Documents yang harus diperbaharui
                        </div>
                        <div class="card-body">
                            <textarea class="form-control form-control-sm" name="certificates" rows="3" placeholder="Sebutkan sertifikat atau dokumen yang perlu diperbaharui/dilengkapi..."></textarea>
                        </div>
                    </div>

                    <!-- Section: Debriefing Questions -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white fw-bold text-primary">
                            <i class="fa fa-question-circle me-2"></i>Pertanyaan Evaluasi
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="answers" id="deb_answers_json">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold small">1. Apa rencana kegiatan anda selama masa cuti?</label>
                                <textarea class="form-control form-control-sm ans-field" data-key="answer_1" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">2. Penerapan K3 di kapal?</label>
                                <textarea class="form-control form-control-sm ans-field" data-key="answer_2" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">3. Training crew apa saja?</label>
                                <textarea class="form-control form-control-sm ans-field" data-key="answer_3" rows="2"></textarea>
                            </div>
                            <div class="mb-3 row g-2">
                                <label class="form-label fw-bold small mb-0">4. Masalah yang dihadapi dan penyelesaiannya?</label>
                                <div class="col-md-6">
                                    <textarea class="form-control form-control-sm ans-field" data-key="answer_4" rows="3" placeholder="Masalah..."></textarea>
                                </div>
                                <div class="col-md-6">
                                    <textarea class="form-control form-control-sm ans-field" data-key="answer_10" rows="3" placeholder="Penyelesaian..."></textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">5. Bagaimana kondisi kerja tim di kapal?</label>
                                <textarea class="form-control form-control-sm ans-field" data-key="answer_5" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">6. Kebersihan di atas kapal?</label>
                                <textarea class="form-control form-control-sm ans-field" data-key="answer_6" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">7. Makanan di atas kapal?</label>
                                <textarea class="form-control form-control-sm ans-field" data-key="answer_7" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">8. Kondisi kesehatan setelah sign off?</label>
                                <textarea class="form-control form-control-sm ans-field" data-key="answer_8" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">9. Harapan dan saran?</label>
                                <textarea class="form-control form-control-sm ans-field" data-key="answer_9" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Remarks Executive -->
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white fw-bold text-primary">
                            <i class="fa fa-commenting me-2"></i>Remarks / Comment <small class="text-danger">*diisi oleh crew executive</small>
                        </div>
                        <div class="card-body">
                            <textarea class="form-control form-control-sm" name="remask_form_deb" rows="3"></textarea>
                        </div>
                    </div>

                </form>
            </div>
            <!-- Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" style="font-family: 'Times New Roman', Times, serif;">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary px-4" id="btnSubmitDebriefing" style="font-family: 'Times New Roman', Times, serif;"><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     MODAL: Detail Debriefing
     ============================================================ -->
<div class="modal fade" id="modalDetailDebriefing" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header" style="background: linear-gradient(135deg, #000099 0%, #1a237e 100%); color: #fff;">
                <h6 class="modal-title fw-bold">
                    <i class="fa fa-file-text-o me-2"></i>Detail Debriefing Report
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" id="modalDetailDebBody">
                <div id="detailDebSpinner" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div id="detailDebContent" class="d-none">
                    <div class="px-4 py-3">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="p-3 rounded-3" style="background: #f8f9ff;">
                                    <small class="text-muted d-block mb-1">Nama Crew</small>
                                    <span class="fw-bold text-dark" id="detName">-</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded-3" style="background: #f8f9ff;">
                                    <small class="text-muted d-block mb-1">Jabatan</small>
                                    <span class="fw-bold text-dark" id="detRank">-</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded-3" style="background: #f8f9ff;">
                                    <small class="text-muted d-block mb-1">No Telp</small>
                                    <span class="text-dark" id="detTelp">-</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #f8f9ff;">
                                    <small class="text-muted d-block mb-1">Nama Kapal</small>
                                    <span class="text-dark" id="detVessel">-</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #f8f9ff;">
                                    <small class="text-muted d-block mb-1">Pelabuhan</small>
                                    <span class="text-dark" id="detPort">-</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded-3" style="background: #f8f9ff;">
                                    <small class="text-muted d-block mb-1">Tgl Join</small>
                                    <span class="text-dark" id="detJoin">-</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded-3" style="background: #f8f9ff;">
                                    <small class="text-muted d-block mb-1">Tgl Sign Off</small>
                                    <span class="text-dark" id="detSignOff">-</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded-3" style="background: #f8f9ff;">
                                    <small class="text-muted d-block mb-1">Kesiapan Join Berikutnya</small>
                                    <span class="text-dark" id="detReady">-</span>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h6 class="fw-bold mb-3" style="color: #000099;">Evaluasi & Pertanyaan</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle" style="font-size: 13px;">
                                <thead style="background-color: #e8eaf6;">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">No</th>
                                        <th>Pertanyaan</th>
                                        <th>Jawaban</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td class="text-center">1</td><td>Apa rencana kegiatan anda selama masa cuti?</td><td id="detA1">-</td></tr>
                                    <tr><td class="text-center">2</td><td>Penerapan K3 di kapal?</td><td id="detA2">-</td></tr>
                                    <tr><td class="text-center">3</td><td>Training crew apa saja?</td><td id="detA3">-</td></tr>
                                    <tr>
                                        <td class="text-center">4</td>
                                        <td>Masalah yang dihadapi dan penyelesaiannya?</td>
                                        <td>
                                            <strong>Masalah:</strong> <span id="detA4">-</span><br>
                                            <strong>Penyelesaian:</strong> <span id="detA10">-</span>
                                        </td>
                                    </tr>
                                    <tr><td class="text-center">5</td><td>Bagaimana kondisi kerja tim di kapal?</td><td id="detA5">-</td></tr>
                                    <tr><td class="text-center">6</td><td>Kebersihan di atas kapal?</td><td id="detA6">-</td></tr>
                                    <tr><td class="text-center">7</td><td>Makanan di atas kapal?</td><td id="detA7">-</td></tr>
                                    <tr><td class="text-center">8</td><td>Kondisi kesehatan setelah sign off?</td><td id="detA8">-</td></tr>
                                    <tr><td class="text-center">9</td><td>Harapan dan saran?</td><td id="detA9">-</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mb-3">
                            <h6 class="fw-bold mt-4 mb-2" style="color: #000099;">Sertifikat / Dokumen yang Harus Diperbarui</h6>
                            <div class="p-3 border rounded bg-light" id="detCerts" style="font-size: 13px; min-height: 50px;">-</div>
                        </div>

                        <div>
                            <h6 class="fw-bold mt-4 mb-2" style="color: #000099;">Remarks Executive</h6>
                            <div class="p-3 border rounded bg-light" id="detRemarks" style="font-size: 13px; min-height: 50px;">-</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" style="font-family: 'Times New Roman', Times, serif;">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary" id="btnGeneratePdfFromDetailDeb" style="font-family: 'Times New Roman', Times, serif;"><i class="fa fa-print"></i> Print</button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form for PDF generation -->
<form id="formPdfDebriefing" method="POST" target="_blank" action="<?php echo base_url('ListReport/Defreafing/generatePDF_Breafing'); ?>" style="display:none;">
    <input type="hidden" name="id_report" id="pdf_deb_id_report">
</form>

<!-- ============================================================
     STYLES
     ============================================================ -->
<style>
.crew-table th, .crew-table td { font-size: 12px; vertical-align: middle; }
.crew-header th { background-color: #000099 !important; color: #fff !important; }
.card-header i { color: #000099; }

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
.paginate_button { margin: 0 2px; padding: 6px 12px !important; border-radius: 4px; border: 1px solid #dee2e6; background: #fff !important; color: #0d6efd !important; cursor: pointer; }
.paginate_button.current { background: #0d6efd !important; color: #fff !important; border-color: #0d6efd !important; }
.paginate_button:hover { background: #e9ecef !important; border-color: #dee2e6; }
.dataTables_info { padding: 10px 0; color: #6c757d; font-size: 14px; }
</style>

<!-- ============================================================
     JAVASCRIPT LOGIC
     ============================================================ -->
<script>
$(document).ready(function() {
    var BASE_URL_DEB = '<?php echo base_url("ListReport/Defreafing/"); ?>';
    
    // Get idperson from contentArea
    var idperson = $('#contentArea').data('idperson');
    if (!idperson) {
        console.error('ID Person tidak ditemukan untuk Debriefing');
        return;
    }

    // ================================
    // DataTables Initialization
    // ================================
    var debTable = $('#debriefingTable').DataTable({
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
            url: BASE_URL_DEB + '/get_report_debriefing',
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
            { data: 'name_person', className: 'text-center' },
            { data: 'rank', className: 'text-center' },
            { data: 'vessel_name', className: 'text-center' },
            { data: 'date_request', className: 'text-center fw-bold' },
            {
                data: null,
                className: 'text-center',
                orderable: false,
                searchable: false,
                render: function(data) {
                    return '<div class="btn-group btn-group-sm" role="group">' +
                        '<button type="button" class="btn btn-outline-primary btn-print-deb" title="Print/View PDF" data-id="' + data.id + '">' +
                            '<i class="fa fa-eye"></i>' +
                        '</button>' +
                        '<button type="button" class="btn btn-outline-danger btn-delete-deb" title="Delete" data-id="' + data.id + '">' +
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
            emptyTable: 'Tidak ada data Debriefing',
            zeroRecords: 'Data tidak ditemukan'
        }
    });

    // Column search sync
    $('#debriefingTable thead tr:last th').each(function(i) {
        $('input', this).on('keyup change', function() {
            if (debTable.column(i).search() !== this.value) {
                debTable.column(i).search(this.value).draw();
            }
        });
    });

    // ================================
    // ADD DEBRIEFING
    // ================================
    $('#btnAddDebriefing').on('click', function() {
        $('#formAddDebriefing')[0].reset();
        $('#deb_idperson').val(idperson);
        
        // Fetch Person Data
        $.ajax({
            url: BASE_URL_DEB + '/get_data_form_defbreafing',
            type: 'POST',
            data: { idperson: idperson },
            dataType: 'json',
            success: function(res) {
                if (res.success && res.data.length > 0) {
                    var pd = res.data[0];
                    $('#deb_nama_crew').val(pd.nama_crew);
                    $('#deb_jabatan').val(pd.jabatan);
                    $('#deb_vessel').val(pd.nama_kapal);
                    $('#deb_pelabuhan').val(pd.pelabuhan);
                    $('#deb_tgl_join').val(pd.tgl_join);
                    $('#deb_tgl_signoff').val(pd.tgl_signoff);
                    $('#deb_no_telp').val(pd.no_telp);
                } else {
                    debNotify('warning', 'Data personal tidak ditemukan');
                }
            }
        });

        $('#modalAddDebriefing').modal('show');
    });

    $('#btnSubmitDebriefing').on('click', function() {
        var form = $('#formAddDebriefing')[0];
        if (!form.reportValidity()) return;

        // Build answers JSON
        var answers = {};
        $('.ans-field').each(function() {
            var key = $(this).data('key');
            var val = $(this).val();
            answers[key] = val;
        });

        $('#deb_answers_json').val(JSON.stringify(answers));

        var formData = new FormData(form);

        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin ms-1"></i> Menyimpan...');

        $.ajax({
            url: BASE_URL_DEB + '/save_debriefing',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                btn.prop('disabled', false).html('Simpan <i class="fa fa-save ms-1"></i>');
                if (res.success) {
                    $('#modalAddDebriefing').modal('hide');
                    debTable.ajax.reload(null, false);
                    debNotify('success', res.message);
                } else {
                    debNotify('error', res.message);
                }
            },
            error: function() {
                btn.prop('disabled', false).html('Simpan <i class="fa fa-save ms-1"></i>');
                debNotify('error', 'Terjadi kesalahan sistem');
            }
        });
    });

    // ================================
    // DELETE DEBRIEFING
    // ================================
    $('#debriefingTable').on('click', '.btn-delete-deb', function() {
        var id = $(this).data('id');

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Debriefing?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus'
            }).then(function(result) {
                if (result.isConfirmed) doDeleteDeb(id);
            });
        } else {
            if (confirm('Yakin ingin menghapus report Debriefing ini?')) {
                doDeleteDeb(id);
            }
        }
    });

    function doDeleteDeb(id) {
        $.ajax({
            url: BASE_URL_DEB + '/delete_debriefing',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    debTable.ajax.reload(null, false);
                    debNotify('success', res.message);
                } else {
                    debNotify('error', res.message);
                }
            }
        });
    }

    // ================================
    // VIEW / DETAIL DEBRIEFING
    // ================================
    $('#debriefingTable').on('click', '.btn-print-deb', function() {
        var id = $(this).data('id');

        $('#detailDebSpinner').show();
        $('#detailDebContent').addClass('d-none');
        $('#pdf_deb_id_report').val(id);

        $('#modalDetailDebriefing').modal('show');

        $.ajax({
            url: BASE_URL_DEB + '/get_report_debriefing_detail',
            type: 'POST',
            data: { id_report: id },
            dataType: 'json',
            success: function(res) {
                $('#detailDebSpinner').hide();
                if (res.success) {
                    var c = res.data.crew;
                    var a = res.data.answers;

                    $('#detName').text(c.name_person || '-');
                    $('#detRank').text(c.rank || '-');
                    $('#detTelp').text(c.no_telp || '-');
                    $('#detVessel').text(c.vessel_name || '-');
                    $('#detPort').text(c.pelabuhan || '-');
                    $('#detJoin').text(c.sign_on_fmt || '-');
                    $('#detSignOff').text(c.sign_off_fmt || '-');
                    $('#detReady').text(c.available_join_fmt || '-');

                    $('#detA1').text(a.answer_1 || '-');
                    $('#detA2').text(a.answer_2 || '-');
                    $('#detA3').text(a.answer_3 || '-');
                    $('#detA4').text(a.answer_4 || '-');
                    $('#detA10').text(a.answer_10 || '-');
                    $('#detA5').text(a.answer_5 || '-');
                    $('#detA6').text(a.answer_6 || '-');
                    $('#detA7').text(a.answer_7 || '-');
                    $('#detA8').text(a.answer_8 || '-');
                    $('#detA9').text(a.answer_9 || '-');

                    $('#detCerts').text(a.certificates || '-');
                    $('#detRemarks').text(a.remarks || '-');

                    $('#detailDebContent').removeClass('d-none');
                } else {
                    $('#detailDebContent').removeClass('d-none').html('<div class="p-4 text-center text-danger">' + res.message + '</div>');
                }
            },
            error: function() {
                $('#detailDebSpinner').hide();
                $('#detailDebContent').removeClass('d-none').html('<div class="p-4 text-center text-danger">Gagal memuat detail</div>');
            }
        });
    });

    $('#btnGeneratePdfFromDetailDeb').on('click', function() {
        $('#formPdfDebriefing').submit();
    });

    // Helper notification
    function debNotify(type, msg) {
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