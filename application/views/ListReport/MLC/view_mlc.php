<!-- ============================================================
     MLC Module View — Loaded via AJAX
     Features: DataTables, Add MLC Form, Generate PDF
     ============================================================ -->

<div class="card shadow-sm border-0" id="mlcModuleWrapper">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-sm rounded shadow-sm" id="btnGlobalAddMlc" style="background-color: #000999; border-color: #000999;">
                <i class="fa fa-plus me-1"></i> Add MLC
            </button>
        </div>
        <div class="table-responsive">
            <table id="mlcTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                    <tr>
                        <th class="text-center" style="width:50px;">No</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Rank</th>
                        <th class="text-center">Vessel Name</th>
                        <th class="text-center">Date MLC</th>
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
     MODAL: Add MLC Form
     ============================================================ -->
<div class="modal fade" id="modalAddMlc" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <!-- Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, #000999 0%, #1a237e 100%); color: #fff;">
                <h6 class="modal-title fw-bold" id="modalAddMlcTitle">
                    <i class="fa fa-plus-circle me-2"></i>Tambah Data MLC
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Body -->
            <div class="modal-body bg-light position-relative">
                <div id="modalAddMlcOverlay" class="position-absolute top-0 start-0 w-100 h-100 d-none" style="background: rgba(255,255,255,0.7); z-index: 10; align-items: center; justify-content: center; display: flex;">
                    <div class="spinner-border" style="color: #000999;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <form id="formAddMlc">
                    <input type="hidden" name="idperson" id="mlc_idperson">
                    
                    <!-- Section: Person Data -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white fw-bold text-primary">
                            <i class="fa fa-user me-2"></i>Data Crew
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1">Nama Crew</label>
                                    <input type="text" class="form-control form-control-sm" name="fullname" id="mlc_fullname">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1">Jabatan (Rank)</label>
                                    <input type="text" class="form-control form-control-sm" name="nmrank" id="mlc_nmrank">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted small mb-1">Nama Kapal</label>
                                    <input type="text" class="form-control form-control-sm" name="nmvsl" id="mlc_nmvsl">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Tgl. Join (Sign On)</label>
                                    <input type="text" class="form-control form-control-sm" name="signondt" id="mlc_signondt">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Est. Sign Off</label>
                                    <input type="text" class="form-control form-control-sm" name="estsignoffdt" id="mlc_estsignoffdt">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: MLC Statements -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white fw-bold text-primary">
                            <i class="fa fa-check-square-o me-2"></i>Form Pernyataan MLC
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-sm align-middle" style="font-size: 13px;">
                                <thead style="background-color: #f8f9ff;">
                                    <tr>
                                        <th class="text-center" style="width: 40px;">No</th>
                                        <th>Statement</th>
                                        <th class="text-center" style="width: 80px;">Yes</th>
                                        <th class="text-center" style="width: 80px;">No</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">1</td>
                                        <td>
                                            All items contained in my employment contract have been explained to me and I am aware of them.<br>
                                            <i class="text-muted" style="font-size:11px;">Semua hal yang terdapat dalam kontrak kerja saya telah dijelaskan kepada saya dan saya memahaminya.</i>
                                        </td>
                                        <td class="text-center"><input class="form-check-input" type="radio" name="statement_1" value="1" required></td>
                                        <td class="text-center"><input class="form-check-input" type="radio" name="statement_1" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">2</td>
                                        <td>
                                            A full sample agreement incorporating all terms and conditions to apply (including the CBA) has been provided to me prior to entering the agreement.<br>
                                            <i class="text-muted" style="font-size:11px;">Contoh perjanjian yang lengkap yang menggabungkan semua ketentuan dan persyaratan melamar (termasuk Kontrak Kerja Bersama) telah diberikan kepada saya sebelum memulai perjanjian ini.</i>
                                        </td>
                                        <td class="text-center"><input class="form-check-input" type="radio" name="statement_2" value="1" required></td>
                                        <td class="text-center"><input class="form-check-input" type="radio" name="statement_2" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">3</td>
                                        <td>
                                            I was given adequate time to review the contract and seek advice on the terms and conditions in the agreement.<br>
                                            <i class="text-muted" style="font-size:11px;">Saya diberikan waktu yang mencukupi untuk memeriksa kontrak dan meminta nasihat mengenai ketentuan dan persyaratan dalam perjanjian tersebut.</i>
                                        </td>
                                        <td class="text-center"><input class="form-check-input" type="radio" name="statement_3" value="1" required></td>
                                        <td class="text-center"><input class="form-check-input" type="radio" name="statement_3" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">4</td>
                                        <td>
                                            I freely entered into the agreement with a sufficient understanding of my rights and responsibilities.<br>
                                            <i class="text-muted" style="font-size:11px;">Saya bebas mengadakan perjanjian dengan pemahaman yang memadai mengenai hak dan tanggungjawab saya.</i>
                                        </td>
                                        <td class="text-center"><input class="form-check-input" type="radio" name="statement_4" value="1" required></td>
                                        <td class="text-center"><input class="form-check-input" type="radio" name="statement_4" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">5</td>
                                        <td>
                                            I was given an original set of my Seafarers Employment Agreement, which I must carry with me on board.<br>
                                            <i class="text-muted" style="font-size:11px;">Saya diberikan satu berkas Perjanjian Kerja Pelaut yang asli, yang saya harus bawa di atas kapal.</i>
                                        </td>
                                        <td class="text-center"><input class="form-check-input" type="radio" name="statement_5" value="1" required></td>
                                        <td class="text-center"><input class="form-check-input" type="radio" name="statement_5" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">6</td>
                                        <td>
                                            No fees or other charges for my recruitment or placement or for providing employment to me have incurred directly or indirectly, in whole or part.<br>
                                            <i class="text-muted" style="font-size:11px;">Tidak diadakan biaya maupun beban lainnya untuk perekrutan dan penempatan saya atau untuk memberikan pekerjaan kepada saya secara langsung atau tidak langsung, secara keseluruhan atau sebagian.</i>
                                        </td>
                                        <td class="text-center"><input class="form-check-input" type="radio" name="statement_6" value="1" required></td>
                                        <td class="text-center"><input class="form-check-input" type="radio" name="statement_6" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">7</td>
                                        <td>
                                            No joining advances or any other exploitation incurred with regard to the employment.<br>
                                            <i class="text-muted" style="font-size:11px;">Tidak ada biaya untuk bergabung ataupun eksploitasi lainnya sehubungan dengan pekerjaan tersebut.</i>
                                        </td>
                                        <td class="text-center"><input class="form-check-input" type="radio" name="statement_7" value="1" required></td>
                                        <td class="text-center"><input class="form-check-input" type="radio" name="statement_7" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">8</td>
                                        <td>
                                            The Company's Complaint procedure has been explained to me and I am fully aware of the process to be followed and the record to be used.<br>
                                            <i class="text-muted" style="font-size:11px;">Prosedur keluhan perusahaan telah dijelaskan kepada saya dan saya sepenuhnya mengetahui proses yang harus diikuti dan catatan yang akan digunakan.</i>
                                        </td>
                                        <td class="text-center"><input class="form-check-input" type="radio" name="statement_8" value="1" required></td>
                                        <td class="text-center"><input class="form-check-input" type="radio" name="statement_8" value="0"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">9</td>
                                        <td>
                                            The terms and conditions of employment and my particular conditions applicable to the job for which I am engaged have been explained to me.<br>
                                            <i class="text-muted" style="font-size:11px;">Ketentuan dan persyaratan pekerjaan serta persyaratan tertentu yang berlaku terhadap pekerjaan di mana saya terlibat telah dijelaskan kepada saya.</i>
                                        </td>
                                        <td class="text-center"><input class="form-check-input" type="radio" name="statement_9" value="1" required></td>
                                        <td class="text-center"><input class="form-check-input" type="radio" name="statement_9" value="0"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-2" style="font-size: 13px;">
                                <ul class="text-muted mb-0 pl-3">
                                    <li>By ticking the YES box you indicate that the documented statement is correct.</li>
                                    <li>By ticking the NO box you indicate that the documented statement is NOT correct.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Signature Section (Only visible in View Mode) -->
                    <!-- <div id="mlcSignatureBlock" class="d-none">
                        <div class="remarks-title mt-4">
                            <strong>Remarks:</strong><br>
                            <em>Keterangan:</em>
                        </div>

                        <div class="sign-container mt-3">
                            <div class="sign-table-wrapper" style="overflow-x:auto;">
                                <table style="border-collapse:separate; border-spacing:15px 0;margin-left:5px;">
                                    <tr>
                                        <td style="border:1px solid #000; width: 300px; height:100px; vertical-align:bottom; text-align:center; padding-bottom:8px;">
                                            <div style="font-weight:bold;">Seafarer's Name</div>
                                            <div style="font-size:12px;" id="detMlcSignName">-</div>
                                        </td>
                                        <td style="border:1px solid #000; width: 300px; height:90px; vertical-align:bottom; text-align:center; padding-bottom:8px;">
                                            <div style="font-weight:bold;">Rank</div>
                                            <div style="font-size:12px;" id="detMlcSignRank">-</div>
                                        </td>
                                        <td style="border:1px solid #000; width: 300px; height:90px; vertical-align:bottom; text-align:center; padding-bottom:8px;">
                                            <div style="font-weight:bold;">Date</div>
                                            <div style="font-size:12px;" id="detMlcSignDate">-</div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <br>
                        <div class="sign-container mb-4">
                            <div class="sign-table-wrapper" style="overflow-x:auto;">
                                <table style="border-collapse:separate; border-spacing:15px 0;margin-left:1px;">
                                    <tr>
                                        <td style="border:1px solid #000; width: 232px; height:70px; vertical-align:bottom; text-align:center; padding-bottom:8px;">
                                            <div style="font-weight:bold;font-size:9px;">Eva Marliana</div>
                                            <div style="font-size:9px;">Crew Manager</div>
                                        </td>
                                        <td style="border:1px solid #000; width: 232px; height:70px; vertical-align:bottom; text-align:center; padding-bottom:8px;">
                                            <div style="font-weight:bold;font-size:9px;">Vessel to Join</div>
                                            <div style="font-size:9px;" id="detMlcSignVessel">-</div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div> -->

                </form>
            </div>
            <!-- Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" style="font-family: 'Times New Roman', Times, serif;">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary px-4" id="btnSubmitMlc" style="font-family: 'Times New Roman', Times, serif;"><i class="fa fa-save"></i> Save </button>
                <button type="button" class="btn btn-sm btn-primary px-4 d-none" id="btnGeneratePdfFromModalMlc" style="font-family: 'Times New Roman', Times, serif;"><i class="fa fa-print"></i> Print</button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form for PDF generation --><form id="formPdfMlc" method="POST" target="_blank" action="<?php echo base_url('ListReport/Mlc/print_mlc_pdf'); ?>" style="display:none;">
    <input type="hidden" name="id_report_mlc" id="pdf_mlc_id_report">
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
    var BASE_URL_MLC = '<?php echo base_url("ListReport/Mlc/"); ?>';
    
    // Get idperson from contentArea
    var idperson = $('#contentArea').data('idperson');
    if (!idperson) {
        console.error('ID Person tidak ditemukan untuk MLC');
        return;
    }

    // ================================
    // DataTables Initialization
    // ================================
    var mlcTable = $('#mlcTable').DataTable({
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
            url: BASE_URL_MLC + '/get_report_mlc',
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
                        '<button type="button" class="btn btn-outline-primary btn-print-mlc" title="Print/View PDF" data-id="' + data.id + '">' +
                            '<i class="fa fa-eye"></i>' +
                        '</button>' +
                        '<button type="button" class="btn btn-outline-danger btn-delete-mlc" title="Delete" data-id="' + data.id + '">' +
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
            emptyTable: 'Tidak ada data MLC',
            zeroRecords: 'Data tidak ditemukan'
        }
    });

    // Column search sync
    $('#mlcTable thead tr:last th').each(function(i) {
        $('input', this).on('keyup change', function() {
            if (mlcTable.column(i).search() !== this.value) {
                mlcTable.column(i).search(this.value).draw();
            }
        });
    });

    // ================================
    // ADD MLC
    // ================================
    $('#btnGlobalAddMlc').on('click', function() {
        openAddMlcModal();
    });

    function openAddMlcModal() {
        $('#formAddMlc')[0].reset();
        $('#mlc_idperson').val(idperson);
        $('#modalAddMlcTitle').html('<i class="fa fa-plus-circle me-2"></i>Tambah Data MLC');

        // Apply Layout Mode: Create
        $('#btnSubmitMlc').removeClass('d-none');
        $('#btnGeneratePdfFromModalMlc').addClass('d-none');
        $('#mlcSignatureBlock').addClass('d-none');
        $('#formAddMlc input[type="radio"]').prop('disabled', false);
        
        $('#modalAddMlcOverlay').removeClass('d-none');
        $('#modalAddMlc').modal('show');

        // Fetch Person Data
        $.ajax({
            url: BASE_URL_MLC + '/get_data_form_mlc',
            type: 'POST',
            data: { idperson: idperson },
            dataType: 'json',
            success: function(res) {
                $('#modalAddMlcOverlay').addClass('d-none');
                if (res.success && res.data.length > 0) {
                    var pd = res.data[0];
                    $('#mlc_fullname').val(pd.fullname);
                    $('#mlc_nmrank').val(pd.nmrank);
                    $('#mlc_nmvsl').val(pd.nmvsl);
                    $('#mlc_signondt').val(pd.signondt);
                    $('#mlc_estsignoffdt').val(pd.estsignoffdt);
                } else {
                    mlcNotify('warning', 'Data personal tidak ditemukan atau belum ada kontrak aktif.');
                }
            },
            error: function() {
                $('#modalAddMlcOverlay').addClass('d-none');
                mlcNotify('error', 'Terjadi kesalahan sistem.');
            }
        });
    }

    $('#btnSubmitMlc').on('click', function() {
        var form = $('#formAddMlc')[0];
        if (!form.reportValidity()) return;

        var formData = new FormData(form);

        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin ms-1"></i> Menyimpan...');

        $.ajax({
            url: BASE_URL_MLC + '/save_form_mlc',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                btn.prop('disabled', false).html('Simpan');
                if (res.success) {
                    $('#modalAddMlc').modal('hide');
                    mlcTable.ajax.reload(null, false);
                    mlcNotify('success', res.message);            
                } else {
                    mlcNotify('error', res.message);
                }
            },
            error: function() {
                btn.prop('disabled', false).html('Simpan');
                mlcNotify('error', 'Terjadi kesalahan sistem');
            }
        });
    });

    // ================================
    // DELETE MLC
    // ================================
    $('#mlcTable').on('click', '.btn-delete-mlc', function() {
        var id = $(this).data('id');

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Form MLC?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus'
            }).then(function(result) {
                if (result.isConfirmed) doDeleteMlc(id);
            });
        } else {
            if (confirm('Yakin ingin menghapus form MLC ini?')) {
                doDeleteMlc(id);
            }
        }
    });

    function doDeleteMlc(id) {
        $.ajax({
            url: BASE_URL_MLC + '/delete_report_mlc',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    mlcTable.ajax.reload(null, false);
                    mlcNotify('success', res.message);
                } else {
                    mlcNotify('error', res.message);
                }
            }
        });
    }

    // ================================
    // VIEW / DETAIL MLC (Triggered from existing Modal Add)
    // ================================
    $('#mlcTable').on('click', '.btn-print-mlc', function() {
        var id = $(this).data('id');

        $('#formAddMlc')[0].reset();
        $('#pdf_mlc_id_report').val(id);
        $('#modalAddMlcTitle').html('<i class="fa fa-file-text-o me-2"></i>Detail Data MLC');

        // Apply Layout Mode: View
        $('#btnSubmitMlc').addClass('d-none');
        $('#btnGeneratePdfFromModalMlc').removeClass('d-none');
        $('#mlcSignatureBlock').removeClass('d-none');
        $('#formAddMlc input[type="radio"]').prop('disabled', true);
        
        $('#modalAddMlcOverlay').removeClass('d-none');
        $('#modalAddMlc').modal('show');

        $.ajax({
            url: BASE_URL_MLC + '/get_report_mlc_detail',
            type: 'POST',
            data: { id_report: id },
            dataType: 'json',
            success: function(res) {
                $('#modalAddMlcOverlay').addClass('d-none');
                if (res.success) {
                    var c = res.data.crew;
                    var a = res.data.answers;

                    $('#mlc_fullname').val(c.name_person || '-');
                    $('#mlc_nmrank').val(c.rank || '-');
                    $('#mlc_nmvsl').val(c.vessel_name || '-');
                    $('#mlc_signondt').val(c.signondt || '-');
                    $('#mlc_estsignoffdt').val(c.estsignoffdt || '-');

                    $('#detMlcSignName').text(c.name_person || '-');
                    $('#detMlcSignRank').text(c.rank || '-');
                    $('#detMlcSignVessel').text(c.vessel_name || '-');
                    $('#detMlcSignDate').text(c.date_request || '-');

                    // Map answers
                    if (a) {
                        for(var i=1; i<=9; i++) {
                            var val = a['answer_'+i];
                            $('#formAddMlc input[name="statement_'+i+'"][value="'+val+'"]').prop('checked', true);
                        }
                    }
                } else {
                    mlcNotify('error', res.message);
                    $('#modalAddMlc').modal('hide');
                }
            },
            error: function() {
                $('#modalAddMlcOverlay').addClass('d-none');
                mlcNotify('error', 'Gagal memuat detail');
                $('#modalAddMlc').modal('hide');
            }
        });
    });

    $('#btnGeneratePdfFromModalMlc').on('click', function() {
        $('#formPdfMlc').submit();
    });

    // Helper notification
    function mlcNotify(type, msg) {
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
