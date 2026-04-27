<!-- ============================================================
     MCU Module View — Loaded via AJAX into list_report.php
     Features: DataTables, Detail Modal, Delete, Generate PDF
     ============================================================ -->

<div class="card shadow-sm border-0" id="mcuModuleWrapper">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-primary btn-sm" id="btnAddMcu" style="background-color: #000999; border-color: #000999;">
                <i class="fa fa-plus me-1"></i> Add MCU
            </button>
        </div>
        <div class="table-responsive">
            <table id="mcuTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                    <tr>
                        <th class="text-center" style="width:50px;">No</th>
                        <th class="text-center">Name Klinik</th>
                        <th class="text-center">Date MCU</th>
                        <th class="text-center" style="width:110px;">Status</th>
                        <th class="text-center">Remarks Reject</th>
                        <th class="text-center">Date Approve / Reject</th>
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
     MODAL: Detail MCU
     ============================================================ -->
<div class="modal fade" id="modalDetailMcu" tabindex="-1" aria-labelledby="modalDetailMcuLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <!-- Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, #000099 0%, #1a237e 100%); color: #fff;">
                <h6 class="modal-title fw-bold" id="modalDetailMcuLabel">
                    <i class="fa fa-file-text-o me-2"></i>Detail MCU Report
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Body -->
            <div class="modal-body p-0" id="modalDetailMcuBody">
                <!-- Spinner saat loading -->
                <div id="detailSpinner" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <!-- Content (hidden saat loading) -->
                <div id="detailContent" class="d-none">
                    <!-- Status Badge -->
                    <div class="px-4 pt-3 pb-2">
                        <span id="detailStatusBadge" class="badge rounded-pill px-3 py-2 fs-7"></span>
                    </div>

                    <!-- Clinic Info -->
                    <div class="px-4 py-2">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #f8f9ff;">
                                    <small class="text-muted d-block mb-1">Nama Klinik</small>
                                    <span class="fw-bold text-dark" id="detailClinicName">-</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #f8f9ff;">
                                    <small class="text-muted d-block mb-1">Tanggal MCU</small>
                                    <span class="fw-bold text-dark" id="detailDateMcu">-</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="p-3 rounded-3" style="background: #f8f9ff;">
                                    <small class="text-muted d-block mb-1">Alamat</small>
                                    <span class="text-dark" id="detailAddress">-</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #f8f9ff;">
                                    <small class="text-muted d-block mb-1">Telp</small>
                                    <span class="text-dark" id="detailTelp">-</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 rounded-3" style="background: #f8f9ff;">
                                    <small class="text-muted d-block mb-1">Fax</small>
                                    <span class="text-dark" id="detailFax">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-2 mx-4">

                    <!-- MCU Checklist -->
                    <div class="px-4 py-2">
                        <h6 class="fw-bold mb-3" style="color: #000099;">
                            <i class="fa fa-check-square-o me-2"></i>Jenis Pemeriksaan MCU
                        </h6>
                        <div class="row g-2" id="detailMcuChecklist">
                            <!-- Populated via JS -->
                        </div>
                    </div>

                    <hr class="my-2 mx-4">

                    <!-- Crew List -->
                    <div class="px-4 py-2">
                        <h6 class="fw-bold mb-3" style="color: #000099;">
                            <i class="fa fa-users me-2"></i>Daftar Crew
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle mb-0" style="font-size: 12px;">
                                <thead style="background-color: #e8eaf6;">
                                    <tr>
                                        <th class="text-center" style="width: 40px;">No</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Jabatan</th>
                                        <th class="text-center">Kapal</th>
                                    </tr>
                                </thead>
                                <tbody id="detailCrewTableBody">
                                    <!-- Populated via JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <hr class="my-2 mx-4">

                    <!-- Biaya Dibebankan (answer_9 & answer_10) — di bawah crew table, sama seperti PDF -->
                    <div class="px-4 py-2">
                        <h6 class="fw-bold mb-3" style="color: #000099;">
                            <i class="fa fa-money me-2"></i>Harap Biaya Dibebankan Pada
                        </h6>
                        <div class="row g-2" id="detailBiayaSection">
                            <!-- Populated via JS -->
                        </div>
                    </div>

                    <!-- Signature QR (if approved/rejected) -->
                    <div class="px-4 py-3 text-center d-none" id="detailSignatureArea">
                        <small class="text-muted d-block mb-2">Digital Signature</small>
                        <img id="detailSignatureImg" src="" alt="QR Signature" style="max-height: 80px;">
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">
                    Tutup
                </button>
                <button type="button" class="btn btn-sm btn-primary" id="btnGeneratePdfFromDetail">
                    Print <i class="fa fa-print ms-1"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     MODAL: Add MCU
     ============================================================ -->
<div class="modal fade" id="modalAddMcu" tabindex="-1" aria-labelledby="modalAddMcuLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <form id="formAddMcu" class="modal-content border-0 shadow">
            <!-- Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, #000099 0%, #1a237e 100%); color: #fff;">
                <h6 class="modal-title fw-bold" id="modalAddMcuLabel">
                    <i class="fa fa-plus-circle me-2"></i>Add MCU
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Body -->
            <div class="modal-body p-0">
                <div class="px-4 py-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size: 13px;">Klinik</label>
                                <select class="form-control selectpicker" data-live-search="true" data-size="5" name="id_clinic" id="addClinic" required>
                                    <!-- <option value="">- Pilih Klinik -</option> -->
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="font-size: 13px;">Tanggal MCU</label>
                                <input type="date" class="form-control form-control-sm" name="date_mcu" id="addDateMcu" required>
                            </div>
                        </div>
                        <div class="row g-3 mt-1">
                            <div class="col-md-12">
                                <label class="form-label fw-semibold" style="font-size: 13px;">Header MCU</label>
                                <select class="form-control selectpicker" data-live-search="true" data-size="5" name="header_mcu" id="addHeaderMcu" required>
                                    <!-- <option value=""></option> -->
                                </select>
                            </div>
                        </div>
                        
                        <hr class="my-3">
                        <h6 class="fw-bold mb-3" style="color: #000099;">
                            <i class="fa fa-users me-2"></i>Data Crew
                        </h6>
                        <div class="row g-2 mb-3">
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm" id="addCrewName" placeholder="Nama Crew" required readonly style="background-color: #f1f3f8;">
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm" id="addCrewRank" placeholder="Jabatan" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control form-control-sm" id="addCrewVessel" placeholder="Kapal" required>
                            </div>
                        </div>
                        
                        <hr class="my-3">
                        <h6 class="fw-bold mb-3" style="color: #000099;">
                            <i class="fa fa-check-square-o me-2"></i>Jenis Pemeriksaan MCU
                        </h6>
                        <div class="row g-2" id="addMcuChecklist">
                            <!-- Populated via JS -->
                        </div>
                        
                        <hr class="my-3">
                        <h6 class="fw-bold mb-3" style="color: #000099;">
                            <i class="fa fa-money me-2"></i>Harap Biaya Dibebankan Pada
                        </h6>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="mcu-check-item unchecked add-mcu-biaya-item" id="itemAddMcuBiaya1" style="cursor: pointer;">
                                    <span class="mcu-check-icon"><i class="fa fa-check d-none"></i></span>
                                    <span id="lblAddMcuBiaya1" style="font-size: 13px;">PT. Andhini Eka Karya Sejahtera</span>
                                    <input type="hidden" id="addMcuBiaya1" value="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mcu-check-item unchecked add-mcu-biaya-item" id="itemAddMcuBiaya2" style="cursor: pointer;">
                                    <span class="mcu-check-icon"><i class="fa fa-check d-none"></i></span>
                                    <span id="lblAddMcuBiaya2" style="font-size: 13px;">Crew yang bersangkutan</span>
                                    <input type="hidden" id="addMcuBiaya2" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-sm btn-primary" id="btnSubmitAddMcu">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Hidden form for PDF generation -->
<form id="formGeneratePdf" method="POST" target="_blank" style="display:none;">
    <input type="hidden" name="persons" id="pdfPersons">
    <input type="hidden" name="mcu" id="pdfMcu">
    <input type="hidden" name="date_mcu" id="pdfDateMcu">
    <input type="hidden" name="clinic_name" id="pdfClinicName">
    <input type="hidden" name="status_mcu" id="pdfStatusMcu">
    <input type="hidden" name="signature_qr" id="pdfSignatureQr">
    <input type="hidden" name="address_clinic" id="pdfAddressClinic">
    <input type="hidden" name="telp" id="pdfTelp">
    <input type="hidden" name="fax" id="pdfFax">
    <input type="hidden" name="header_mcu" id="pdfHeaderMcu">
</form>

<!-- ============================================================
     STYLES
     ============================================================ -->
<style>
/* Table Styles */
.crew-table th,
.crew-table td {
  font-size: var(--crew-font-sm, 12px);
  vertical-align: middle;
}
.crew-table th {
  font-weight: 600;
  text-align: center;
}
.crew-table .btn {
  font-size: var(--crew-font-xs, 11px);
  padding: 4px 8px;
}
.crew-header th {
  background-color: var(--crew-blue, #000099) !important;
  color: #fff !important;
}

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

/* MCU Checklist Item */
.mcu-check-item {
  display: flex;
  align-items: center;
  padding: 6px 10px;
  border-radius: 6px;
  font-size: 12px;
  transition: background-color 0.2s;
}
.mcu-check-item.checked {
  background-color: #e8f5e9;
  color: #2e7d32;
}
.mcu-check-item.unchecked {
  background-color: #fafafa;
  color: #9e9e9e;
}
.mcu-check-icon {
  width: 20px;
  height: 20px;
  border-radius: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 8px;
  font-size: 11px;
  flex-shrink: 0;
}
.mcu-check-item.checked .mcu-check-icon {
  background-color: #4caf50;
  color: white;
}
.mcu-check-item.unchecked .mcu-check-icon {
  background-color: #e0e0e0;
  color: #bdbdbd;
}
</style>

<!-- ============================================================
     JAVASCRIPT LOGIC
     ============================================================ -->
<script>
$(document).ready(function() {

    var BASE_URL = '<?php echo base_url("ListReport/Mcu/"); ?>';

    // Get idperson from contentArea
    var idperson = $('#contentArea').data('idperson');
    if (!idperson) {
        console.error('ID Person tidak ditemukan');
        return;
    }

    // MCU checklist labels (matching PDF template)
    // Mapping: index 0-7 = answer_1 to answer_8, index 8 = answer_11 (Treadmill)
    var MCU_ITEMS = [
        { answer: 'answer_1',  num: 1, label: 'Medical Check Up Standart Perla' },
        { answer: 'answer_2',  num: 2, label: 'Medical Check Up Kerajaan Malaysia,Panama, Marshall Islands, Liberia, Singapore, Cyprus,Shipowner, OGUK, & Netherlands' },
        { answer: 'answer_3',  num: 3, label: 'Medical Check Up Panama + ECG + Renal Function + Lever Function + Glukosa at Random', bold: true },
        { answer: 'answer_4',  num: 4, label: 'Pemeriksaan Gigi & Gusi (Dental+Gum)' },
        { answer: 'answer_5',  num: 5, label: 'Drug & Alcoholic Test 6 (six) items', bold: true },
        { answer: 'answer_6',  num: 6, label: 'HIV Test' },
        { answer: 'answer_7',  num: 7, label: 'Chemical Contamination Test' },
        { answer: 'answer_8',  num: 8, label: 'Sleep Apnea Syndrome' },
        { answer: 'answer_11', num: 9, label: 'Treadmill' },
        { answer: 'answer_12', num: 10, label: 'PEME Gard' },
        { answer: 'answer_13', num: 11, label: 'Stool culture' }
    ];

    // Status mapping
    var STATUS_MAP = {
        0: { label: 'Pending',  class: 'text-bg-warning' },
        1: { label: 'Approved', class: 'text-bg-success' },
        2: { label: 'Rejected', class: 'text-bg-danger'  }
    };

    // ================================
    // Current detail data (for PDF)
    // ================================
    var currentDetailData = null;

    // ================================
    // DataTables Initialization
    // ================================
    console.log(idperson);
    var mcuTable = $('#mcuTable').DataTable({

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
            url: BASE_URL + '/get_report_mcu',
            type: 'POST',
            data: {
                idperson: idperson
            },
            dataSrc: function(json) {
                return json.success ? json.data : [];
            },
            error: function(xhr, error, thrown) {
                console.error('AJAX Error:', error, thrown);
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
            { data: 'clinic_name', className: 'text-center' },
            { data: 'date_mcu', className: 'text-center' },
            {
                data: 'status_mcu',
                className: 'text-center',
                render: function(data) {
                    var s = STATUS_MAP[data] || STATUS_MAP[0];
                    return '<span class="badge ' + s.class + '">' + s.label + '</span>';
                }
            },
            {
                data: 'remarks_reject',
                className: 'text-dark text-center',
                render: function(data) {
                    if (!data) return '';
                    return '<span style="font-size:12px;">' + data + '</span>';
                }
            },
            { data: 'upuserdate', className: 'fw-bold text-center' },
            {
                data: null,
                className: 'text-center',
                orderable: false,
                searchable: false,
                render: function(data) {
                    return '<div class="btn-group btn-group-sm" role="group">' +
                        '<button type="button" class="btn btn-outline-primary btn-view-mcu" title="Detail" data-id="' + data.id_report_mcu + '">' +
                            '<i class="fa fa-eye"></i>' +
                        '</button>' +
                        '<button type="button" class="btn btn-outline-danger btn-delete-mcu" title="Delete" data-id="' + data.id_report_mcu + '">' +
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
            emptyTable: 'Tidak ada data MCU',
            zeroRecords: 'Data tidak ditemukan'
        }
    });

    // Column search sync
    $('#mcuTable thead tr:last th').each(function(i) {
        $('input', this).on('keyup change', function() {
            if (mcuTable.column(i).search() !== this.value) {
                mcuTable.column(i).search(this.value).draw();
            }
        });
    });

    // ================================
    // VIEW DETAIL
    // ================================
    $('#mcuTable').on('click', '.btn-view-mcu', function() {
        var id = $(this).data('id');

        $('#detailSpinner').show();
        $('#detailContent').addClass('d-none');
        currentDetailData = null;

        var modal = new bootstrap.Modal(document.getElementById('modalDetailMcu'));
        modal.show();

        $.ajax({
            url: BASE_URL + '/get_report_mcu_detail',
            type: 'POST',
            data: { id_report: id, idperson: idperson },
            dataType: 'json',
            success: function(res) {
                $('#detailSpinner').hide();

                if (!res.success) {
                    $('#detailContent').removeClass('d-none').html(
                        '<div class="text-center py-4 text-danger"><i class="fa fa-warning fa-2x mb-2"></i><p>' + (res.message || 'Data tidak ditemukan') + '</p></div>'
                    );
                    return;
                }

                currentDetailData = res.data;
                var report  = res.data.report;
                var persons = res.data.persons;

                var s = STATUS_MAP[report.status_mcu] || STATUS_MAP[0];
                $('#detailStatusBadge').attr('class', 'badge rounded-pill px-3 py-2 fs-7 ' + s.class).text(s.label);

                $('#detailClinicName').text(report.clinic_name || '-');
                $('#detailDateMcu').text(report.date_mcu ? formatDate(report.date_mcu) : '-');
                $('#detailAddress').text(report.address_clinic || '-');
                $('#detailTelp').text(report.telp || '-');
                $('#detailFax').text(report.fax || '-');

                // MCU Checklist (9 items matching PDF)
                var checklistHtml = '';
                $.each(MCU_ITEMS, function(idx, item) {
                    var val = parseInt(report[item.answer]) || 0;
                    var cls = val ? 'checked' : 'unchecked';
                    var icon = val ? '<i class="fa fa-check"></i>' : '';
                    var labelText = item.bold ? '<strong>' + item.num + '. ' + item.label + '</strong>' : item.num + '. ' + item.label;
                    checklistHtml += 
                        '<div class="col-md-6 col-lg-6">' +
                            '<div class="mcu-check-item ' + cls + '">' +
                                '<span class="mcu-check-icon">' + icon + '</span>' +
                                '<span>' + labelText + '</span>' +
                            '</div>' +
                        '</div>';
                });
                $('#detailMcuChecklist').html(checklistHtml);

                // Biaya dibebankan (answer_9 = Perusahaan, answer_10 = Crew)
                var biayaHtml = '';
                var biaya9 = parseInt(report.answer_9) || 0;
                var biaya10 = parseInt(report.answer_10) || 0;
                var cls9 = biaya9 ? 'checked' : 'unchecked';
                var cls10 = biaya10 ? 'checked' : 'unchecked';
                var icon9 = biaya9 ? '<i class="fa fa-check"></i>' : '';
                var icon10 = biaya10 ? '<i class="fa fa-check"></i>' : '';
                var headerMcu = report.header_mcu || 'PT. Andhini Eka Karya Sejahtera';
                biayaHtml += 
                    '<div class="col-md-6">' +
                        '<div class="mcu-check-item ' + cls9 + '">' +
                            '<span class="mcu-check-icon">' + icon9 + '</span>' +
                            '<span>' + headerMcu + '</span>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                        '<div class="mcu-check-item ' + cls10 + '">' +
                            '<span class="mcu-check-icon">' + icon10 + '</span>' +
                            '<span>Crew yang bersangkutan</span>' +
                        '</div>' +
                    '</div>';
                $('#detailBiayaSection').html(biayaHtml);

                var crewHtml = '';
                if (persons.length > 0) {
                    $.each(persons, function(idx, p) {
                        crewHtml += 
                            '<tr>' +
                                '<td class="text-center">' + (idx + 1) + '</td>' +
                                '<td>' + (p.name_person || '-') + '</td>' +
                                '<td class="text-center">' + (p.rank || '-') + '</td>' +
                                '<td class="text-center">' + (p.vessel_name || '-') + '</td>' +
                            '</tr>';
                    });
                } else {
                    crewHtml = '<tr><td colspan="4" class="text-center text-muted">Tidak ada data crew</td></tr>';
                }
                $('#detailCrewTableBody').html(crewHtml);
                console.log("report.signature_qr",report.signature_qr);
                if ((report.status_mcu == 1 || report.status_mcu == 2) && report.signature_qr) {
                    $('#detailSignatureImg').attr('src', '<?php echo base_url("assets/imgQRCodeCrewCV"); ?>/' + report.signature_qr);
                    $('#detailSignatureArea').removeClass('d-none');
                } else {
                    $('#detailSignatureArea').addClass('d-none');
                }

                $('#detailContent').removeClass('d-none');
            },
            error: function() {
                $('#detailSpinner').hide();
                $('#detailContent').removeClass('d-none').html(
                    '<div class="text-center py-4 text-danger"><i class="fa fa-warning fa-2x mb-2"></i><p>Gagal memuat data</p></div>'
                );
            }
        });
    });

    // ================================
    // DELETE MCU
    // ================================
    $('#mcuTable').on('click', '.btn-delete-mcu', function() {
        var id = $(this).data('id');

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Data MCU?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fa fa-trash me-1"></i> Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (result.isConfirmed) {
                    doDeleteMcu(id);
                }
            });
        } else {
            if (confirm('Apakah Anda yakin ingin menghapus data MCU ini?')) {
                doDeleteMcu(id);
            }
        }
    });

    function doDeleteMcu(id) {
        $.ajax({
            url: BASE_URL + '/delete_list_mcu',
            type: 'POST',
            data: { id_report: id, idperson: idperson },
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    mcuTable.ajax.reload(null, false);
                    showNotification('success', res.message || 'Data berhasil dihapus');
                } else {
                    showNotification('error', res.message || 'Gagal menghapus data');
                }
            },
            error: function() {
                showNotification('error', 'Terjadi kesalahan server');
            }
        });
    }

    // ================================
    // GENERATE PDF
    // ================================
    $('#btnGeneratePdfFromDetail').on('click', function() {
        if (!currentDetailData) {
            showNotification('warning', 'Data detail belum dimuat');
            return;
        }

        var report  = currentDetailData.report;
        var persons = currentDetailData.persons;

        var personArr = [];
        $.each(persons, function(i, p) {
            personArr.push({
                name_person: p.name_person,
                rank: p.rank,
                vessel_name: p.vessel_name
            });
        });

        var mcuArr = [];
        for (var i = 1; i <= 13; i++) {
            mcuArr.push(report['answer_' + i] || '0');
        }

        var $form = $('#formGeneratePdf');
        $form.attr('action', BASE_URL + '/generatePDF_MCU');
        $('#pdfPersons').val(JSON.stringify(personArr));
        $('#pdfMcu').val(mcuArr.join(','));
        $('#pdfDateMcu').val(report.date_mcu || '');
        $('#pdfClinicName').val(report.clinic_name || '');
        $('#pdfStatusMcu').val(report.status_mcu || '0');
        $('#pdfSignatureQr').val(report.signature_qr || '');
        $('#pdfAddressClinic').val(report.address_clinic || '');
        $('#pdfTelp').val(report.telp || '');
        $('#pdfFax').val(report.fax || '');
        $('#pdfHeaderMcu').val(report.header_mcu || '');

        $form.submit();
    });

    // ================================
    // HELPER FUNCTIONS
    // ================================
    function formatDate(dateStr) {
        if (!dateStr) return '-';
        var d = new Date(dateStr);
        if (isNaN(d.getTime())) return dateStr;
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        return ('0' + d.getDate()).slice(-2) + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
    }

    function showNotification(type, message) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type,
                title: type === 'success' ? 'Berhasil!' : (type === 'error' ? 'Error!' : 'Peringatan'),
                text: message,
                timer: 2500,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        } else {
            alert(message);
        }
    }

    // ================================
    // ADD MCU REPORT
    // ================================
    function loadClinics() {
        $.ajax({
            url: BASE_URL + '/get_data_m_master_mcu',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    var options = '<option value="">- Pilih Klinik -</option>';
                    $.each(res.data, function(i, k) {
                        options += '<option value="' + k.id + '">' + k.clinic_name + '</option>';
                    });
                    $('#addClinic').html(options);
                    if ($().selectpicker) {
                        $('#addClinic').selectpicker('refresh');
                    }
                }
            }
        });
    }

    function loadCompanyBaseVessel() {
        $.ajax({
            url: BASE_URL + '/get_CompanyBaseVessel',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    var options = '<option value="">- Pilih Header MCU -</option>';
                    options += '<option value="PT. Andhini Eka Karya Sejahtera">PT. Andhini Eka Karya Sejahtera</option>';
                    $.each(res.data, function(i, k) {
                        if (k.nmcmp !== "PT. Andhini Eka Karya Sejahtera") {
                            options += '<option value="' + k.nmcmp + '">' + k.nmcmp + '</option>';
                        }
                    });
                    $('#addHeaderMcu').html(options);
                    if ($().selectpicker) {
                        $('#addHeaderMcu').selectpicker('refresh');
                    }
                }
            }
        });
    }

    $('#addHeaderMcu').on('change', function() {
        var val = $(this).val();
        if (val) {
            $('#lblAddMcuBiaya1').text(val);
        } else {
            $('#lblAddMcuBiaya1').text('PT. Andhini Eka Karya Sejahtera');
        }
    });

    function fetchCrewData() {
        $.ajax({
            url: BASE_URL + '/get_crew_info_by_idperson',
            type: 'POST',
            data: { idperson: idperson },
            dataType: 'json',
            success: function(res) {
                if (res.success && res.data) {
                    $('#addCrewName').val(res.data.nama_crew);
                    $('#addCrewRank').val(res.data.jabatan);
                    $('#addCrewVessel').val(res.data.vessel_name);
                }
            }
        });
    }

    function renderAddMcuChecklist() {
        var checklistHtml = '';
        $.each(MCU_ITEMS, function(idx, item) {
            var mcuIndex = parseInt(item.answer.replace('answer_', '')) - 1;
            var labelText = item.bold ? '<strong>' + item.num + '. ' + item.label + '</strong>' : item.num + '. ' + item.label;
            
            checklistHtml += 
                '<div class="col-md-6 col-lg-6">' +
                    '<div class="mcu-check-item unchecked add-mcu-check-item" style="cursor: pointer;" data-index="' + mcuIndex + '">' +
                        '<span class="mcu-check-icon"><i class="fa fa-check d-none"></i></span>' +
                        '<span style="font-size: 13px;">' + labelText + '</span>' +
                        '<input type="hidden" class="chk-add-mcu-hidden" data-index="' + mcuIndex + '" value="0">' +
                    '</div>' +
                '</div>';
        });
        $('#addMcuChecklist').html(checklistHtml);
    }
    
    // Call once
    renderAddMcuChecklist();

    // Toggle Checkboxes for Add Modal
    $(document).off('click', '.add-mcu-check-item, .add-mcu-biaya-item').on('click', '.add-mcu-check-item, .add-mcu-biaya-item', function() {
        var $this = $(this);
        var $icon = $this.find('.fa-check');
        var $input = $this.find('input[type="hidden"]');
        
        if ($this.hasClass('unchecked')) {
            $this.removeClass('unchecked').addClass('checked');
            $icon.removeClass('d-none');
            $input.val('1');
        } else {
            $this.removeClass('checked').addClass('unchecked');
            $icon.addClass('d-none');
            $input.val('0');
        }
    });

    $('#btnAddMcu').on('click', function() {
        $('#formAddMcu')[0].reset();
        $('#lblAddMcuBiaya1').text('PT. Andhini Eka Karya Sejahtera');
        
        // Reset checkboxes
        $('.add-mcu-check-item, .add-mcu-biaya-item').removeClass('checked').addClass('unchecked');
        $('.add-mcu-check-item .fa-check, .add-mcu-biaya-item .fa-check').addClass('d-none');
        $('input.chk-add-mcu-hidden, #addMcuBiaya1, #addMcuBiaya2').val('0');
        
        fetchCrewData();
        
        // Prevent double loading by checking if options are already loaded
        if ($('#addClinic option').length <= 1) {
            loadClinics();
        }
        if ($('#addHeaderMcu option').length <= 1) {
            loadCompanyBaseVessel();
        }
        
        if ($().selectpicker) {
            $('#addClinic').selectpicker('val', '');
            $('#addHeaderMcu').selectpicker('val', '');
        }
        
        var modal = new bootstrap.Modal(document.getElementById('modalAddMcu'));
        modal.show();
    });

    $('#formAddMcu').on('submit', function(e) {
        e.preventDefault();
        
        var btn = $('#btnSubmitAddMcu');
        var originalText = btn.html();
        btn.html('<i class="fa fa-spinner fa-spin"></i> Processing...').prop('disabled', true);
        
        var mcuData = [];
        for(var i=0; i<13; i++) mcuData.push(0);
        
        $('.chk-add-mcu-hidden').each(function() {
            if ($(this).val() === '1') {
                var idx = $(this).data('index');
                mcuData[idx] = 1;
            }
        });
        
        if ($('#addMcuBiaya1').val() === '1') mcuData[8] = 1;
        if ($('#addMcuBiaya2').val() === '1') mcuData[9] = 1;
        
        var crewList = [{
            name_crew: $('#addCrewName').val(),
            jabatan: $('#addCrewRank').val(),
            vessel_name: $('#addCrewVessel').val()
        }];
        
        var formData = {
            id_clinic: $('#addClinic').val(),
            date_mcu: $('#addDateMcu').val(),
            header_mcu: $('#addHeaderMcu').val(),
            mcu: mcuData,
            crew_list: crewList
        };
        
        $.ajax({
            url: BASE_URL + '/submit_report_mcu',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(res) {
                btn.html(originalText).prop('disabled', false);
                if (res.success) {
                    $('#modalAddMcu').modal('hide');
                    showNotification('success', res.message || 'Data berhasil ditambahkan');
                    mcuTable.ajax.reload(null, false);
                } else {
                    showNotification('error', res.message || 'Gagal menambahkan data');
                }
            },
            error: function() {
                btn.html(originalText).prop('disabled', false);
                showNotification('error', 'Terjadi kesalahan server');
            }
        });
    });

});
</script>
