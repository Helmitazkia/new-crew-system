<!-- Suntecho PKL Module View — Loaded via AJAX -->
<div class="card shadow-sm border-0" id="suntechoPklModuleWrapper">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-sm rounded shadow-sm" id="btnSuntechoAddPKL"
                style="background-color: #000999; border-color: #000999;">
                <i class="fa fa-plus me-1"></i> Add New Suntecho PKL
            </button>
        </div>
        <div class="table-responsive">
            <table id="suntechoPklTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
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
     MODAL: Add / View Suntecho PKL (Seafarer Employment Agreement)
     ============================================================ -->
<div class="modal fade" id="suntechoPklModal" tabindex="-1" role="dialog" aria-labelledby="suntechoPklModalLabel">
    <div class="modal-dialog modal-xl" style="max-width: 85%;" role="document">
        <div class="modal-content border-0 shadow">

            <div class="modal-header"
                style="background: linear-gradient(135deg, #000999 0%, #1a237e 100%); color: #fff;">
                <h5 class="modal-title fw-bold" id="suntechoPklModalLabel" style="font-family: 'Times New Roman', Times, serif;">
                    <i class="fa fa-file-text-o me-2"></i>Suntecho Seafarer Employment Agreement
                </h5>
                <button type="button" class="btn-close btn-close-white close" data-bs-dismiss="modal" aria-label="Close"
                    style="filter: invert(1) grayscale(100%) brightness(200%); border:none; background:transparent; font-size:24px; color:#fff;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body bg-light" style="padding: 25px 35px; max-height: 75vh; overflow-y: auto;">
                <form id="formSuntechoPklData" style="width: 100%;">
                    <input type="hidden" name="idperson" id="txtSuntechoIdPerson">
                    <input type="hidden" name="id_history_wages" id="txtSuntechoIdHistoryPkl">

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
                                        <input type="text" id="txtSuntechoFullnameInput" class="form-control bg-light" readonly>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Date of Birth / Tgl Lahir <span
                                                    class="text-danger">*</span></label>
                                            <input type="date" id="txtSuntechoDoBInput" name="dob"
                                                class="form-control mandatory">
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Place of Birth / Tepat Lahir</label>
                                            <input type="text" id="txtSuntechoPoB" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label fw-semibold">Seafarer Code / Kode Pelaut <span
                                                class="text-danger">*</span></label>
                                        <input type="text" id="txtSuntechoSeafarerCodeInput" name="kodepelaut"
                                            class="form-control mandatory">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label fw-semibold">Home Address / Alamat Rumah <span
                                                class="text-danger">*</span></label>
                                        <textarea id="txtSuntechoAddressInput" name="paddress" class="form-control mandatory"
                                            rows="2"></textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Passport No / No. Paspor <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="txtSuntechoPassportNoInput" name="passportno"
                                                class="form-control mandatory">
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Seaman Book No / No. Buku Pelaut <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="txtSuntechoSeamanBookNoInput" name="seamanbookno"
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
                                        <select id="txtSuntechoVesselFor" name="txtVesselFor"
                                            class="form-control selectpicker" data-live-search="true"
                                            title="-- Select Vessel --" data-size="5" data-dropup-auto="false">
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Vessel Name / Nama Kapal <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="txtSuntechoVesselName" name="vessel_name" class="form-control bg-light mandatory" readonly>
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Company / Perusahaan</label>
                                            <input type="text" id="txtSuntechoCompanyNameInput" name="company_name" class="form-control bg-light"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 form-group mb-3">
                                            <label class="form-label fw-semibold">Flag / Bendera</label>
                                            <input type="text" id="txtSuntechoFlag" name="flag" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label class="form-label fw-semibold">IMO No</label>
                                            <input type="text" id="txtSuntechoImo" name="imo" class="form-control">
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label class="form-label fw-semibold">GRT / HP</label>
                                            <input type="text" id="txtSuntechoGrtHp" name="grt_hp" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Competency Cert. / SERPEL</label>
                                            <input type="text" id="txtSuntechoCompetencyCert" name="txtCompetencyCert"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Safety Cert. / SERKES</label>
                                            <input type="text" id="txtSuntechoSafetyCert" name="txtSafetyCert"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white py-3">
                                    <h6 class="text-primary fw-bold mb-0"><i class="fa-solid fa-money-bill px-2"></i>Duration &
                                        Wages</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label class="form-label fw-semibold">Duration / Jangka Waktu (Months / Bulan)
                                            <span class="text-danger">*</span></label>
                                        <input type="number" id="txtSuntechoDuration" name="txtduration"
                                            class="form-control mandatory" min="1" max="50" placeholder="e.g. 12">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Basic Wage (US$) <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="txtSuntechoBasicWage" name="txtBasicWage"
                                                class="form-control mandatory text-end" value="0">
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Fix Overtime (US$) <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="txtSuntechoFixOvertime" name="txtFixOvertime"
                                                class="form-control mandatory text-end" value="0">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Leave Pay (US$) <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="txtSuntechoLeavePay" name="txtLeavePay"
                                                class="form-control mandatory text-end" value="0">
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="form-label fw-semibold">Tanker Allowance (US$) <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="txtSuntechoTankerAllowance" name="txtTankerAllowance"
                                                class="form-control mandatory text-end" value="0">
                                        </div>
                                    </div>

                                    <div
                                        class="p-3 bg-light rounded d-flex justify-content-between align-items-center mt-2 border">
                                        <span class="fw-bold text-secondary mb-0">Total Wages:</span>
                                        <h5 class="fw-bold text-success mb-0">US$ <span id="txtSuntechoTotalWages">0</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer bg-light py-3" style="justify-content: flex-end;">
                <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal" style="font-family: 'Times New Roman', Times, serif;">Close</button>
                <button type="button" class="btn btn-primary btn-sm px-4" id="btnSuntechoSaveAndPrint" style="font-family: 'Times New Roman', Times, serif;"><i class="fa fa-save me-1"></i> Save & Print</button>
                <button type="button" class="btn btn-success btn-sm px-4 d-none" id="btnSuntechoUpdateFromModal" style="font-family: 'Times New Roman', Times, serif;"><i
                        class="fa fa-edit me-1"></i> Update</button>
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
</style>

<script>
    $(document).ready(function () {
        // Notification Helper
        function notifyUser(type, message) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: type === 'error' ? 'error' : (type === 'warning' ? 'warning' : 'success'),
                    title: type.charAt(0).toUpperCase() + type.slice(1),
                    text: message,
                    timer: 3000,
                    showConfirmButton: false
                });
            } else {
                alert(message);
            }
        }

        var BASE_URL_SUNTECHO = '<?php echo base_url("ListReport/SuntechoPKL"); ?>';
        var idperson = $('#contentArea').data('idperson');
        var suntechoTableData = [];

        if (!idperson) {
            console.error('ID Person tidak ditemukan');
            return;
        }

        // Initialize DataTable
        var suntechoPklTable = $('#suntechoPklTable').DataTable({
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
                url: BASE_URL_SUNTECHO + '/get_history',
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
                        return 'US$ ' + safeFormatNumber(data);
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
                emptyTable: 'Tidak ada data history PKL Suntecho',
                zeroRecords: 'Data tidak ditemukan'
            }
        });

        $('#suntechoPklTable thead tr:last th').each(function (i) {
            $('input', this).on('keyup change', function () {
                if (suntechoPklTable.column(i).search() !== this.value) {
                    suntechoPklTable.column(i).search(this.value).draw();
                }
            });
        });

        // Load Vessels list
        loadSuntechoVessels();

        function loadSuntechoVessels() {

            $('#txtSuntechoVesselFor').empty();
            $('#txtSuntechoVesselFor').selectpicker('refresh');

            $.ajax({
                url: BASE_URL_SUNTECHO + '/getVesselByOption',
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    if (res.success && res.data) {
                        suntechoTableData = res.data;
                        let options = '';
                        res.data.forEach(function (vessel) {
                            options += '<option value="' + vessel.kdvsl + '">' + vessel.nmvsl + '</option>';
                        });
                        $('#txtSuntechoVesselFor').html(options);
                        $('#txtSuntechoVesselFor').selectpicker('refresh');
                    }
                }
            });
        }

        // Safe formatter just in case global one is buggy
        function safeFormatNumber(val) {
            if (!val) return '0';
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Format input as dot-separated thousand format & calculate total wage
        $('#txtSuntechoBasicWage, #txtSuntechoFixOvertime, #txtSuntechoLeavePay, #txtSuntechoTankerAllowance').on('input', function () {
            let cursorPosition = this.selectionStart;
            let originalLength = this.value.length;

            let rawVal = $(this).val().replace(/\./g, '').replace(/[^0-9]/g, '');
            let formatted = safeFormatNumber(rawVal);
            $(this).val(formatted);

            // Cursor adjustment logic can sometimes throw errors, so we wrap it
            try {
                let newLength = formatted.length;
                this.setSelectionRange(cursorPosition + (newLength - originalLength), cursorPosition + (newLength - originalLength));
            } catch(e) {}

            calculateSuntechoTotalWage();
        });

        function calculateSuntechoTotalWage() {
            let basic = parseInt($('#txtSuntechoBasicWage').val().replace(/\./g, '')) || 0;
            let fix = parseInt($('#txtSuntechoFixOvertime').val().replace(/\./g, '')) || 0;
            let leave = parseInt($('#txtSuntechoLeavePay').val().replace(/\./g, '')) || 0;
            let tanker = parseInt($('#txtSuntechoTankerAllowance').val().replace(/\./g, '')) || 0;
            let total = basic + fix + leave + tanker;
            $('#txtSuntechoTotalWages').text(safeFormatNumber(total));
        }

        // Remove red borders validation on input/change
        $('#formSuntechoPklData .mandatory').on('input change', function () {
            let val = $(this).val();
            if (val !== null && val !== undefined && $.trim(val) !== '' && val !== '0' && val !== 0) {
                $(this).removeClass('is-invalid');
            }
        });

        // Vessel selection trigger autofill
        $('#txtSuntechoVesselFor').change(function () {
            let vesselCode = $(this).val();
            if (vesselCode) {
                let vessel = suntechoTableData.find(v => v.kdvsl === vesselCode);
                if (vessel) {
                    $('#txtSuntechoVesselName').val(vessel.nmvsl);
                    $('#txtSuntechoCompanyNameInput').val(vessel.nmcmp);
                    $('#txtSuntechoImo').val(vessel.imo || '');
                    $('#txtSuntechoGrtHp').val(vessel.grt || '');
                    $('#txtSuntechoCompetencyCert').val(vessel.serpel || '');
                    $('#txtSuntechoSafetyCert').val(vessel.safety_cert || '');
                    $('#txtSuntechoFlag').val(vessel.flag || 'INDONESIA');
                }
            } else {
                clearSuntechoVesselFields();
            }
        });

        function clearSuntechoVesselFields() {
            $('#txtSuntechoVesselName').val('');
            $('#txtSuntechoCompanyNameInput').val('');
            $('#txtSuntechoImo').val('');
            $('#txtSuntechoGrtHp').val('');
            $('#txtSuntechoCompetencyCert').val('');
            $('#txtSuntechoSafetyCert').val('');
            $('#txtSuntechoFlag').val('');
        }

        function resetSuntechoModalForm() {
            $('#formSuntechoPklData')[0].reset();
            $('#txtSuntechoIdHistoryPkl').val('');
            $('#txtSuntechoTotalWages').text('0');
            $('#formSuntechoPklData .mandatory').removeClass('is-invalid');
            clearSuntechoVesselFields();
            $('#txtSuntechoVesselFor').selectpicker('val', '');
        }

        function populateSuntechoModalForm(d) {
            $('#txtSuntechoFullnameInput').val(d.fullname);
            $('#txtSuntechoDoBInput').val(d.dob);
            $('#txtSuntechoPoB').val(d.pob);
            $('#txtSuntechoSeafarerCodeInput').val(d.kodepelaut);
            $('#txtSuntechoAddressInput').val(d.address);
            $('#txtSuntechoPassportNoInput').val(d.passportno);
            $('#txtSuntechoSeamanBookNoInput').val(d.seamanbookno);
            if(d.vesselfor) {
                $('#txtSuntechoVesselFor').selectpicker('val', d.vesselfor);
                $('#txtSuntechoVesselFor').trigger('change');
            }
        }

        function toggleSuntechoFormFieldsReadonly(isReadonly) {
            $('#formSuntechoPklData input:not([readonly]), #formSuntechoPklData textarea, #formSuntechoPklData select').prop('disabled', isReadonly);
            if (!isReadonly) {
                $('#txtSuntechoFullnameInput, #txtSuntechoVesselName, #txtSuntechoCompanyNameInput').prop('disabled', false).prop('readonly', true);
            }
        }

        function printSuntechoPKL(id) {
            var printUrl = BASE_URL_SUNTECHO + '/PrintPKL/' + id;
            window.open(printUrl, '_blank');
        }

        // Add New PKL Button
        $('#btnSuntechoAddPKL').on('click', function () {
            resetSuntechoModalForm();
            $('#txtSuntechoIdPerson').val(idperson);

            // Disable readonly states for form fields
            toggleSuntechoFormFieldsReadonly(false);
            $('#btnSuntechoSaveAndPrint').removeClass('d-none');
            $('#btnSuntechoUpdateFromModal').addClass('d-none');

            // Fetch crew personal details for auto-populating
            $.ajax({
                url: BASE_URL_SUNTECHO + '/getPKL/' + idperson,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        populateSuntechoModalForm(res.crew);
                        $('#suntechoPklModal').modal('show');
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
        $('#suntechoPklTable').on('click', '.btn-view-pkl', function () {
            var idHistoryPkl = $(this).data('id');
            resetSuntechoModalForm();
            $('#txtSuntechoIdHistoryPkl').val(idHistoryPkl);

            // Fetch saved history details
            $.ajax({
                url: BASE_URL_SUNTECHO + '/get_history_detail/' + idHistoryPkl,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        var d = res.data;

                        // Populate details
                        $('#txtSuntechoIdPerson').val(d.idperson);
                        $('#txtSuntechoFullnameInput').val(d.fullname);
                        $('#txtSuntechoDoBInput').val(d.dob);
                        $('#txtSuntechoPoB').val(d.pob);
                        $('#txtSuntechoSeafarerCodeInput').val(d.seafarer_code);
                        $('#txtSuntechoAddressInput').val(d.address);
                        $('#txtSuntechoPassportNoInput').val(d.passport_no);
                        $('#txtSuntechoSeamanBookNoInput').val(d.seaman_book_no);

                        var matchedVessel = suntechoTableData.find(v => v.nmvsl === d.vessel_name);
                        if (matchedVessel) {
                            $('#txtSuntechoVesselFor').selectpicker('val', matchedVessel.kdvsl);
                        } else {
                            // Append temporary option if not found
                            $('#txtSuntechoVesselFor').append(new Option(d.vessel_name, d.vessel_name));
                            $('#txtSuntechoVesselFor').selectpicker('refresh');
                            $('#txtSuntechoVesselFor').selectpicker('val', d.vessel_name);
                        }

                        $('#txtSuntechoVesselName').val(d.vessel_name);
                        $('#txtSuntechoCompanyNameInput').val(d.company_name);
                        $('#txtSuntechoFlag').val(d.flag);
                        $('#txtSuntechoImo').val(d.imo);
                        $('#txtSuntechoGrtHp').val(d.grt_hp);
                        $('#txtSuntechoCompetencyCert').val(d.competency_cert);
                        $('#txtSuntechoSafetyCert').val(d.safety_cert);

                        $('#txtSuntechoDuration').val(d.duration_months);
                        $('#txtSuntechoBasicWage').val(safeFormatNumber(Math.round(d.basic_wage)));
                        $('#txtSuntechoFixOvertime').val(safeFormatNumber(Math.round(d.fix_overtime)));
                        $('#txtSuntechoLeavePay').val(safeFormatNumber(Math.round(d.leave_pay)));
                        $('#txtSuntechoTankerAllowance').val(safeFormatNumber(Math.round(d.tanker_allowance)));

                        calculateSuntechoTotalWage();

                        // Make form editable for update
                        toggleSuntechoFormFieldsReadonly(false);

                        $('#btnSuntechoSaveAndPrint').addClass('d-none');
                        $('#btnSuntechoUpdateFromModal').removeClass('d-none');

                        $('#suntechoPklModal').modal('show');
                    } else {
                        notifyUser('error', res.message || 'Gagal memuat detail PKL Suntecho');
                    }
                },
                error: function () {
                    notifyUser('error', 'Terjadi kesalahan sistem saat memuat detail PKL');
                }
            });
        });

        // Save & Print Button Click
        $('#btnSuntechoSaveAndPrint').on('click', function () {
            var btn = $(this);

            $('#formSuntechoPklData .mandatory').removeClass('is-invalid');

            let isValid = true;
            let firstInvalid = null;

            $('#formSuntechoPklData .mandatory').not('button').each(function () {

                let val = $(this).val();
                console.log('Checking mandatory field:', $(this).attr('name'), 'Value:', val);
                if (val === null || val === undefined || $.trim(val) === '') {
                    $(this).addClass('is-invalid');
                    if ($(this).hasClass('selectpicker')) {
                        $(this).next('.bootstrap-select').addClass('is-invalid border border-danger');
                    }
                    isValid = false;
                    if (!firstInvalid) {
                        firstInvalid = $(this);
                        let fieldLabel = $(this).closest('.form-group').find('.form-label').text().replace('*', '').trim() || $(this).attr('name');
                        notifyUser('warning', 'Harap isi kolom: ' + fieldLabel);
                    }
                }
            });

            if (!isValid) {
                if (firstInvalid) firstInvalid.focus();
                return;
            }

            let duration = parseInt($('#txtSuntechoDuration').val()) || 0;
            if (duration > 50) {
                $('#txtSuntechoDuration').addClass('is-invalid');
                notifyUser('warning', 'Duration / Jangka Waktu tidak boleh lebih dari 50 bulan.');
                $('#txtSuntechoDuration').focus();
                return;
            }

            var formData = $('#formSuntechoPklData').serialize();
            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Saving...');

            $.ajax({
                url: BASE_URL_SUNTECHO + '/saveVesselData',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (res) {
                    btn.prop('disabled', false).html('<i class="fa fa-save me-1"></i> Save & Print');
                    if (res.success) {
                        $('#suntechoPklModal').modal('hide');
                        suntechoPklTable.ajax.reload(null, false);
                        notifyUser('success', res.message);

                        if (res.data_saved && res.data_saved.inserted_id) {
                            printSuntechoPKL(res.data_saved.inserted_id);
                        }
                    } else {
                        notifyUser('error', res.message || 'Gagal menyimpan data');
                    }
                },
                error: function () {
                    btn.prop('disabled', false).html('<i class="fa fa-save me-1"></i> Save & Print');
                    notifyUser('error', 'Terjadi kesalahan sistem saat menyimpan data');
                }
            });
        });

        // Print Action from Table
        $('#suntechoPklTable').on('click', '.btn-print-pkl', function () {
            var id = $(this).data('id');
            printSuntechoPKL(id);
        });

        // Update Action from Modal
        $('#btnSuntechoUpdateFromModal').on('click', function () {
            var btn = $(this);

            $('#formSuntechoPklData .mandatory').removeClass('is-invalid');

            let isValid = true;
            let firstInvalid = null;

            $('#formSuntechoPklData .mandatory').not('button').each(function () {
                let val = $(this).val();
                if (val === null || val === undefined || $.trim(val) === '') {
                    $(this).addClass('is-invalid');
                    if ($(this).hasClass('selectpicker')) {
                        $(this).next('.bootstrap-select').addClass('is-invalid border border-danger');
                    }
                    isValid = false;
                    if (!firstInvalid) {
                        firstInvalid = $(this);
                        let fieldLabel = $(this).closest('.form-group').find('.form-label').text().replace('*', '').trim() || $(this).attr('name');
                        notifyUser('warning', 'Harap isi kolom: ' + fieldLabel);
                    }
                }
            });

            if (!isValid) {
                if (firstInvalid) firstInvalid.focus();
                return;
            }

            let duration = parseInt($('#txtSuntechoDuration').val()) || 0;
            if (duration > 50) {
                $('#txtSuntechoDuration').addClass('is-invalid');
                notifyUser('warning', 'Duration / Jangka Waktu tidak boleh lebih dari 50 bulan.');
                $('#txtSuntechoDuration').focus();
                return;
            }

            var formData = $('#formSuntechoPklData').serialize();
            formData += '&id_history_wages=' + $('#txtSuntechoIdHistoryPkl').val();
            formData += '&idperson=' + $('#txtSuntechoIdPerson').val();

            btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Updating...');

            $.ajax({
                url: BASE_URL_SUNTECHO + '/updateVesselData',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (res) {
                    btn.prop('disabled', false).html('<i class="fa fa-edit me-1"></i> Update');
                    if (res.success) {
                        $('#suntechoPklModal').modal('hide');
                        suntechoPklTable.ajax.reload(null, false);
                        notifyUser('success', res.message);
                    } else {
                        notifyUser('error', res.message || 'Gagal update data');
                    }
       
                },
                error: function () {
                    btn.prop('disabled', false).html('<i class="fa fa-edit me-1"></i> Update');
                    notifyUser('error', 'Terjadi kesalahan sistem saat update data');
                }
            });
        });

        // Delete Action
        $('#suntechoPklTable').on('click', '.btn-delete-pkl', function () {
            var idHistoryPkl = $(this).data('id');

            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: BASE_URL_SUNTECHO + '/deletePKL',
                        type: 'POST',
                        data: {
                            id_history_wages: idHistoryPkl
                        },
                        dataType: 'json',
                        success: function (res) {
                            if (res.success) {
                                suntechoPklTable.ajax.reload(null, false);
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
            });
        });
    });
</script>