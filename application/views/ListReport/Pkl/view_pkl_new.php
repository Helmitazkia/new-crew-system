<!-- PKL Module View — Loaded via AJAX -->
<div class="card shadow-sm border-0" id="pklModuleWrapper">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-sm rounded shadow-sm" id="btnAddPKL"
                style="background-color: #000999; border-color: #000999;">
                <i class="fa fa-plus me-1"></i> Add New PKL
            </button>
        </div>
        <div class="table-responsive">
            <table id="pklTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                    <tr>
                        <th class="text-center" style="width:50px;">No</th>
                        <th class="text-center">Full Name</th>
                        <th class="text-center">Vessel Name</th>
                        <th class="text-center">Company</th>
                        <th class="text-center">Total Wage</th>
                        <th class="text-center">Duration</th>
                        <th class="text-center">Created At</th>
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
     MODAL: Add / View PKL (Seafarer Employment Agreement)
     ============================================================ -->
<div class="modal fade" id="pklModal" tabindex="-1" role="dialog" aria-labelledby="pklModalLabel">
    <div class="modal-dialog modal-xl" style="max-width: 85%;" role="document">
        <div class="modal-content border-0 shadow">

            <div class="modal-header"
                style="background: linear-gradient(135deg, #000999 0%, #1a237e 100%); color: #fff;">
                <h5 class="modal-title fw-bold" id="pklModalLabel">
                    <i class="fa fa-file-text-o me-2"></i>Seafarer Employment Agreement
                </h5>
                <button type="button" class="btn-close btn-close-white close" data-bs-dismiss="modal" aria-label="Close"
                    style="filter: invert(1) grayscale(100%) brightness(200%); border:none; background:transparent; font-size:24px; color:#fff;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body bg-light" style="padding: 25px 35px; max-height: 75vh; overflow-y: auto;">
                <form id="formPklData" style="width: 100%;">
                    <input type="hidden" name="idperson" id="txtIdPerson">
                    <input type="hidden" name="id_history_wages" id="txtIdHistoryPkl">

                    <div class="row">
                        <!-- Left Column: Personal Information -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-white py-3">
                                    <h6 class="text-primary fw-bold mb-0"><i class="fa fa-user me-2"></i>Personal
                                        Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-semibold">Full Name / Nama Lengkap</label>
                                        <input type="text" id="txtFullnameInput" class="form-control bg-light" readonly>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Date of Birth / Tgl Lahir <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" id="txtDoBInput" name="dob"
                                                class="form-control mandatory">
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Place of Birth / Tepat Lahir</label>
                                            <input type="text" id="txtPoB" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label fw-semibold">Seafarer Code / Kode Pelaut <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="txtSeafarerCodeInput" name="kodepelaut"
                                            class="form-control mandatory">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label fw-semibold">Home Address / Alamat Rumah <span
                                                class="text-danger">*</span></label>
                                        <textarea id="txtAddressInput" name="paddress" class="form-control mandatory"
                                            rows="2"></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Passport No / No. Paspor <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="txtPassportNoInput" name="passportno"
                                                class="form-control mandatory">
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Seaman Book No / No. Buku Pelaut <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="txtSeamanBookNoInput" name="seamanbookno"
                                                class="form-control mandatory">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Vessel Specifications & Wage Details -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-header bg-white py-3">
                                    <h6 class="text-primary fw-bold mb-0"><i class="fa fa-ship me-2"></i>Vessel
                                        Assignment</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-semibold">Select Vessel / Pilih Kapal <span
                                                class="text-danger">*</span></label>
                                        <select id="txtVesselFor" name="txtVesselFor"
                                            class="form-control form-select mandatory">
                                            <option value="">-- Select Vessel --</option>
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Vessel Name / Nama Kapal</label>
                                            <input type="text" id="txtVesselName" class="form-control bg-light"
                                                readonly>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Company / Perusahaan</label>
                                            <input type="text" id="txtCompanyNameInput" class="form-control bg-light"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 form-group mb-3">
                                            <label class="form-label fw-semibold">Flag / Bendera</label>
                                            <input type="text" id="txtFlag" name="flag" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label class="form-label fw-semibold">IMO No</label>
                                            <input type="text" id="txtImo" name="imo" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label class="form-label fw-semibold">GRT / HP</label>
                                            <input type="text" id="txtGrtHp" name="grt_hp" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Competency Cert. / SERPEL</label>
                                            <input type="text" id="txtCompetencyCert" name="txtCompetencyCert"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Safety Cert. / SERKES</label>
                                            <input type="text" id="txtSafetyCert" name="txtSafetyCert"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white py-3">
                                    <h6 class="text-primary fw-bold mb-0"><i class="fa fa-money me-2"></i>Duration &
                                        Wages</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-semibold">Duration / Jangka Waktu (Months / Bulan)
                                            <span class="text-danger">*</span></label>
                                        <input type="number" id="txtDuration" name="txtduration"
                                            class="form-control mandatory" min="1" max="50" placeholder="e.g. 12">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Basic Wage (Rp) <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="txtBasicWage" name="txtBasicWage"
                                                class="form-control mandatory text-end" value="0">
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Fix Overtime (Rp) <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="txtFixOvertime" name="txtFixOvertime"
                                                class="form-control mandatory text-end" value="0">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Leave Pay (Rp) <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="txtLeavePay" name="txtLeavePay"
                                                class="form-control mandatory text-end" value="0">
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Tanker Allowance (Rp) <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="txtTankerAllowance" name="txtTankerAllowance"
                                                class="form-control mandatory text-end" value="0">
                                        </div>
                                    </div>

                                    <div
                                        class="p-3 bg-light rounded d-flex justify-content-between align-items-center mt-2 border">
                                        <span class="fw-bold text-secondary mb-0">Total Wages:</span>
                                        <h5 class="fw-bold text-success mb-0">Rp <span id="txtTotalWages">0</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer bg-light py-3" style="justify-content: flex-end;">
                <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm px-4" id="btnSaveAndPrint"><i
                        class="fa fa-save me-1"></i> Save & Print</button>
                <button type="button" class="btn btn-success btn-sm px-4 d-none" id="btnPrintFromModal"><i
                        class="fa fa-print me-1"></i> Print</button>
            </div>
        </div>
    </div>
</div>

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
        padding: 10px 0;
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

    .is-invalid {
        border-color: #dc3545 !important;
    }

    .is-invalid:focus {
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
    }
</style>

<script>
    $(document).ready(function () {
        var BASE_URL_PKL = '<?php echo base_url("ListReport/Pkl"); ?>';
        var idperson = $('#contentArea').data('idperson');
        var pklTableData = [];

        if (!idperson) {
            console.error('ID Person tidak ditemukan');
            return;
        }

        // Initialize DataTable
        var pklTable = $('#pklTable').DataTable({
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
                url: BASE_URL_PKL + '/get_history',
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
                    data: 'fullname',
                    className: 'text-center'
                },
                {
                    data: 'vessel_name',
                    className: 'text-center'
                },
                {
                    data: 'company_name',
                    className: 'text-center'
                },
                {
                    data: 'total_wage',
                    className: 'text-center',
                    render: function (data) {
                        return 'Rp ' + formatNumber(data);
                    }
                },
                {
                    data: 'duration_months',
                    className: 'text-center',
                    render: function (data) {
                        return data + ' bulan';
                    }
                },
                {
                    data: 'created_at_fmt',
                    className: 'text-center fw-bold'
                },
                {
                    data: null,
                    className: 'text-center',
                    orderable: false,
                    searchable: false,
                    render: function (data) {
                        return '<div class="btn-group btn-group-sm" role="group">' +
                            '<button type="button" class="btn btn-outline-primary btn-view-pkl" title="View Detail" data-id="' +
                            data.id_history_wages + '">' +
                            '<i class="fa fa-eye"></i>' +
                            '</button>' +
                            '<button type="button" class="btn btn-outline-warning btn-print-pkl" title="Print PDF" data-id="' +
                            data.id_history_wages + '">' +
                            '<i class="fa fa-print"></i>' +
                            '</button>' +
                            '<button type="button" class="btn btn-outline-danger btn-delete-pkl" title="Delete" data-id="' +
                            data.id_history_wages + '">' +
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
                emptyTable: 'Tidak ada data history PKL',
                zeroRecords: 'Data tidak ditemukan'
            }
        });

        $('#pklTable thead tr:last th').each(function (i) {
            $('input', this).on('keyup change', function () {
                if (pklTable.column(i).search() !== this.value) {
                    pklTable.column(i).search(this.value).draw();
                }
            });
        });

        // Load Vessels list
        loadVessels();

        function loadVessels() {
            $.ajax({
                url: BASE_URL_PKL + '/getVesselByOption',
                type: 'GET',
                data: {
                    searchNya: ''
                },
                dataType: 'json',
                success: function (res) {
                    if (res.success && res.data) {
                        pklTableData = res.data;
                        let options = '<option value="">-- Select Vessel --</option>';
                        res.data.forEach(function (vessel) {
                            options += '<option value="' + vessel.kdvsl + '">' + vessel
                                .nmvsl + '</option>';
                        });
                        $('#txtVesselFor').html(options);
                    }
                }
            });
        }

        // Format input as dot-separated thousand format & calculate total wage
        $('#txtBasicWage, #txtFixOvertime, #txtLeavePay, #txtTankerAllowance').on('input', function () {
            let cursorPosition = this.selectionStart;
            let originalLength = this.value.length;

            let formatted = formatValueWithDots($(this).val());
            $(this).val(formatted);

            let newLength = formatted.length;
            this.setSelectionRange(cursorPosition + (newLength - originalLength), cursorPosition + (
                newLength - originalLength));

            calculateTotalWage();
        });

        // Remove red borders validation on input/change
        $('.mandatory').on('input change', function () {
            let val = $(this).val();
            if (val !== null && val !== undefined && $.trim(val) !== '' && val !== '0' && val !== 0) {
                $(this).removeClass('is-invalid');
            }
        });

        // Vessel selection trigger autofill
        $('#txtVesselFor').change(function () {
            let vesselCode = $(this).val();
            if (vesselCode) {
                let vessel = pklTableData.find(v => v.kdvsl === vesselCode);
                if (vessel) {
                    $('#txtVesselName').val(vessel.nmvsl);
                    $('#txtCompanyNameInput').val(vessel.nmcmp);
                    $('#txtImo').val(vessel.imo || '');
                    $('#txtGrtHp').val(vessel.grt || '');
                    $('#txtCompetencyCert').val(vessel.serpel || '');
                    $('#txtSafetyCert').val(vessel.safety_cert || '');
                    $('#txtFlag').val(vessel.flag || 'INDONESIA');
                }
            } else {
                clearVesselFields();
            }
        });

        function clearVesselFields() {
            $('#txtVesselName').val('');
            $('#txtCompanyNameInput').val('');
            $('#txtImo').val('');
            $('#txtGrtHp').val('');
            $('#txtCompetencyCert').val('');
            $('#txtSafetyCert').val('');
            $('#txtFlag').val('');
        }

        // Add New PKL Button
        $('#btnAddPKL').on('click', function () {
            resetModalForm();
            $('#txtIdPerson').val(idperson);

            // Disable readonly states for form fields
            toggleFormFieldsReadonly(false);
            $('#btnSaveAndPrint').removeClass('d-none');
            $('#btnPrintFromModal').addClass('d-none');

            // Fetch crew personal details for auto-populating
            $.ajax({
                url: BASE_URL_PKL + '/getPKL/' + idperson,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        populateModalForm(res.crew);
                        $('#pklModal').modal('show');
                    } else {
                        notifyUser('warning', res.message || 'Gagal memuat data pelaut');
                    }
                },
                error: function () {
                    notifyUser('error', 'Terjadi kesalahan sistem saat memuat data pelaut');
                }
            });
        });

        // View Detail Action
        $('#pklTable').on('click', '.btn-view-pkl', function () {
            var idHistoryPkl = $(this).data('id');
            resetModalForm();
            $('#txtIdHistoryPkl').val(idHistoryPkl);

            // Fetch saved history details
            $.ajax({
                url: BASE_URL_PKL + '/get_history_detail/' + idHistoryPkl,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        var d = res.data;

                        // Populate details
                        $('#txtIdPerson').val(d.idperson);
                        $('#txtFullnameInput').val(d.fullname);
                        $('#txtDoBInput').val(d.dob);
                        $('#txtPoB').val(d.pob);
                        $('#txtSeafarerCodeInput').val(d.seafarer_code);
                        $('#txtAddressInput').val(d.address);
                        $('#txtPassportNoInput').val(d.passport_no);
                        $('#txtSeamanBookNoInput').val(d.seaman_book_no);

                        $('#txtVesselFor').val(d
                            .vessel_name
                            ); // Wait! Vessel selection can't match code if it's name. So let's handle setting dropdown
                        // Let's set it based on company / name
                        var matchedVessel = pklTableData.find(v => v.nmvsl === d
                            .vessel_name);
                        if (matchedVessel) {
                            $('#txtVesselFor').val(matchedVessel.kdvsl);
                        } else {
                            // Append temporary option if not found
                            $('#txtVesselFor').append(new Option(d.vessel_name, d
                                .vessel_name));
                            $('#txtVesselFor').val(d.vessel_name);
                        }

                        $('#txtVesselName').val(d.vessel_name);
                        $('#txtCompanyNameInput').val(d.company_name);
                        $('#txtFlag').val(d.flag);
                        $('#txtImo').val(d.imo);
                        $('#txtGrtHp').val(d.grt_hp);
                        $('#txtCompetencyCert').val(d.competency_cert);
                        $('#txtSafetyCert').val(d.safety_cert);

                        $('#txtDuration').val(d.duration_months);
                        $('#txtBasicWage').val(formatValueWithDots(Math.round(d
                            .basic_wage)));
                        $('#txtFixOvertime').val(formatValueWithDots(Math.round(d
                            .fix_overtime)));
                        $('#txtLeavePay').val(formatValueWithDots(Math.round(d.leave_pay)));
                        $('#txtTankerAllowance').val(formatValueWithDots(Math.round(d
                            .tanker_allowance)));

                        calculateTotalWage();

                        // Make form read-only
                        toggleFormFieldsReadonly(true);

                        $('#btnSaveAndPrint').addClass('d-none');
                        $('#btnPrintFromModal').removeClass('d-none');

                        $('#pklModal').modal('show');
                    } else {
                        notifyUser('error', res.message || 'Gagal memuat detail PKL');
                    }
                },
                error: function () {
                    notifyUser('error', 'Terjadi kesalahan sistem saat memuat detail PKL');
                }
            });
        });

        // Save & Print Button Click
        $('#btnSaveAndPrint').on('click', function () {
            var btn = $(this);

            // Remove existing error highlights
            $('.mandatory').removeClass('is-invalid');

            let isValid = true;
            let firstInvalid = null;

            $('.mandatory').each(function () {
                let val = $(this).val();
                if (val === null || val === undefined || $.trim(val) === '' || val === '0' ||
                    val === 0) {
                    $(this).addClass('is-invalid');
                    isValid = false;
                    if (!firstInvalid) {
                        firstInvalid = $(this);
                    }
                }
            });

            if (!isValid) {
                notifyUser('warning', 'Harap isi semua kolom mandatory yang bertanda *');
                if (firstInvalid) {
                    firstInvalid.focus();
                }
                return;
            }

           // Validate Duration max 50
            let duration = parseInt($('#txtDuration').val()) || 0;
            if (duration > 50) {
                $('#txtDuration').addClass('is-invalid');
                notifyUser('warning', 'Duration / Jangka Waktu tidak boleh lebih dari 50 bulan.');
                $('#txtDuration').focus();
                return;
            }

            var formData = $('#formPklData').serialize();
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Saving...');

            $.ajax({
                url: BASE_URL_PKL + '/saveVesselData',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (res) {
                    btn.prop('disabled', false).html(
                        '<i class="fa fa-save me-1"></i> Save & Print');
                    if (res.success) {
                        $('#pklModal').modal('hide');
                        pklTable.ajax.reload(null, false);
                        notifyUser('success', res.message);

                        // Trigger PDF Print in new tab automatically
                        if (res.data_saved && res.data_saved.inserted_id) {
                            printPKL(res.data_saved.inserted_id);
                        }
                    } else {
                        notifyUser('error', res.message || 'Gagal menyimpan data');
                    }
                },
                error: function () {
                    btn.prop('disabled', false).html(
                        '<i class="fa fa-save me-1"></i> Save & Print');
                    notifyUser('error', 'Terjadi kesalahan sistem saat menyimpan data');
                }
            });
        });

        // Print Action from Table
        $('#pklTable').on('click', '.btn-print-pkl', function () {
            var id = $(this).data('id');
            printPKL(id);
        });

        // Print Action from Modal
        $('#btnPrintFromModal').on('click', function () {
            var id = $('#txtIdHistoryPkl').val();
            if (id) printPKL(id);
        });

        function printPKL(id) {
            window.open(BASE_URL_PKL + '/PrintPKL/' + id, '_blank');
        }

        // Delete Action
        $('#pklTable').on('click', '.btn-delete-pkl', function () {
            var id = $(this).data('id');
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Hapus History PKL?',
                    text: 'Data PKL yang dihapus tidak dapat dikembalikan.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        doDeletePkl(id);
                    }
                });
            } else {
                if (confirm('Yakin ingin menghapus history PKL ini?')) {
                    doDeletePkl(id);
                }
            }
        });

        function doDeletePkl(id) {
            $.ajax({
                url: BASE_URL_PKL + '/deletePKL',
                type: 'POST',
                data: {
                    id_history_wages: id
                },
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        pklTable.ajax.reload(null, false);
                        notifyUser('success', res.message);
                    } else {
                        notifyUser('error', res.message || 'Gagal menghapus data');
                    }
                },
                error: function () {
                    notifyUser('error', 'Terjadi kesalahan sistem saat menghapus data');
                }
            });
        }

        // Helper functions
        function populateModalForm(crew) {
            $('#txtFullnameInput').val(crew.fullname);
            $('#txtDoBInput').val(crew.dob);
            $('#txtPoB').val(crew.pob);
            $('#txtSeafarerCodeInput').val(crew.kodepelaut);
            $('#txtAddressInput').val(crew.address);
            $('#txtPassportNoInput').val(crew.passportno);
            $('#txtSeamanBookNoInput').val(crew.seamanbookno);
        }

        function resetModalForm() {
            $('#txtIdHistoryPkl').val('');
            $('#txtIdPerson').val('');
            $('#formPklData')[0].reset();
            $('.mandatory').removeClass('is-invalid');

            // Reset custom select option additions if any
            loadVessels();

            clearVesselFields();
            $('#txtBasicWage, #txtFixOvertime, #txtLeavePay, #txtTankerAllowance').val('0');
            calculateTotalWage();
        }

        function formatValueWithDots(val) {
            let clean = val.toString().replace(/\D/g, '');
            if (clean === '') return '0';
            return parseInt(clean, 10).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function calculateTotalWage() {
            let basic = parseInt($('#txtBasicWage').val().toString().replace(/\D/g, '')) || 0;
            let fix = parseInt($('#txtFixOvertime').val().toString().replace(/\D/g, '')) || 0;
            let leave = parseInt($('#txtLeavePay').val().toString().replace(/\D/g, '')) || 0;
            let tanker = parseInt($('#txtTankerAllowance').val().toString().replace(/\D/g, '')) || 0;
            let total = basic + fix + leave + tanker;
            $('#txtTotalWages').text(formatNumber(total));
        }

        function formatNumber(num) {
            if (!num) return '0';
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function toggleFormFieldsReadonly(isReadonly) {
            $('#formPklData input, #formPklData textarea, #formPklData select').each(function () {
                var id = $(this).attr('id');
                // Keep Full Name, Vessel Name, and Company Name always read-only
                if (id !== 'txtFullnameInput' && id !== 'txtVesselName' && id !==
                    'txtCompanyNameInput') {
                    $(this).prop('disabled', isReadonly);
                    if (isReadonly) {
                        $(this).addClass('bg-light');
                    } else {
                        $(this).removeClass('bg-light');
                    }
                }
            });
        }

        function notifyUser(type, msg) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: type,
                    title: type === 'success' ? 'Sukses' : (type === 'warning' ? 'Peringatan' :
                        'Error'),
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