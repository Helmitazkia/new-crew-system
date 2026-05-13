<!-- Wages Module View — Loaded via AJAX -->
<div class="card shadow-sm border-0" id="wagesModuleWrapper">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-sm rounded shadow-sm" id="btnAddWages" style="background-color: #000999; border-color: #000999;">
                <i class="fa fa-plus me-1"></i> Add Statement of Wages
            </button>
        </div>
        <div class="table-responsive">
            <table id="wagesTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                    <tr>
                        <th class="text-center" style="width:50px;">No</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Position</th>
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
     MODAL: Add / View Wages
     ============================================================ -->
<div class="modal fade" id="modalWages" tabindex="-1">
  <div class="modal-dialog modal-lg" style="max-width: 900px;">
    <div class="modal-content border-0 shadow">
      
      <div class="modal-header" style="background: linear-gradient(135deg, #000999 0%, #1a237e 100%); color: #fff;">
          <h6 class="modal-title fw-bold">
              <i class="fa fa-money me-2"></i>Statement of Wages
          </h6>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1) grayscale(100%) brightness(200%);"></button>
      </div>

      <div class="modal-body bg-light" style="padding:30px 45px; font-family:'Times New Roman', serif; font-size:13px; background-color: #fff !important; max-height: 75vh; overflow-y: auto;">
          <form id="formAddWages" style="width: 100%;">
              <input type="hidden" name="idperson" id="wg_idperson">
              
              <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px;" border="1">
                <div style="width:120px; flex-shrink:0;">
                  <img src="<?php echo base_url('assets/img/Logo_Andhika_2017.jpg'); ?>" alt="Logo" style="width:100px; height:auto; display:block;">
                </div>

                <div style="flex:1; text-align:center; line-height:1.2; margin-top:8px;padding-left:80px;">
                  <h1 style="margin:0; padding:0; font-size:18px; font-weight:700;">SURAT PERNYATAAN GAJI</h1>
                  <h2 style="margin:4px 0 0 0; padding:0; font-size:13px; font-weight:700;">STATEMENT OF WAGES</h2>
                </div>

                <div style="flex-shrink:0; display:flex; flex-direction:column; align-items:flex-end; text-align:right;">
                  <div style="font-size:12px; font-weight:700;">SRPS LICENSE NO:</div>
                  <div style="font-size:12px; font-weight:700; margin-top:2px; margin-bottom:8px;">SIUKAK 236.121 - R Tahun 2025</div>
                  <div style="display:flex; flex-direction:row; align-items:center; gap:10px;">
                    <img src="<?php echo base_url('assets/img/Bureau_Veritas_Logo.jpg'); ?>" alt="BV" style="width:120px; height:auto; display:block;">
                    <img src="<?php echo base_url('assets/img/Iso.jpg'); ?>" alt="ISO" style="width:150px; height:auto; display:block;">
                  </div>
                </div>
              </div>

              <!-- SECTION I -->
              <table style="width:100%; border-collapse:collapse; margin-bottom:12px;">
                <tr>
                  <td style="width:30%; font-weight:700; padding:4px;">I herewith the undersigned</td>
                  <td style="width:2%; padding:4px;">:</td>
                  <td style="padding:4px;"></td>
                </tr>
                <tr>
                  <td style="font-style:italic; padding:4px;">Yang bertanda tangan di bawah ini</td>
                  <td style="padding:4px;">:</td>
                  <td style="padding:4px;"></td>
                </tr>
              </table>

              <!-- CREW DETAILS -->
              <table style="width:100%; border-collapse:collapse; margin-bottom: 20px;">
                <tr>
                  <td style="width:28%; padding:8px; border:1px solid #222; background:#f7f7f7; font-weight:700;">Name/Nama</td>
                  <td style="padding:8px; border:1px solid #222;" id="txtWgName">-</td>
                </tr>
                <tr>
                  <td style="padding:8px; border:1px solid #222; background:#f7f7f7; font-weight:700;">Position/Jabatan</td>
                  <td style="padding:8px; border:1px solid #222;" id="txtWgPosition">-</td>
                </tr>
                <tr>
                  <td style="padding:8px; border:1px solid #222; background:#f7f7f7; font-weight:700;">Vessel/Kapal</td>
                  <td style="padding:8px; border:1px solid #222;" id="txtWgVessel">-</td>
                </tr>
                <tr>
                  <td style="padding:8px; border:1px solid #222; background:#f7f7f7; font-weight:700;">Sign On date/Tanggal Naik Kapal</td>
                  <td style="padding:8px; border:1px solid #222;" id="txtWgSignOn">-</td>
                </tr>
                <tr>
                  <td style="padding:8px; border:1px solid #222; background:#f7f7f7; font-weight:700;">Port of Embarkation/Pelabuhan</td>
                  <td style="padding:8px; border:1px solid #222;" id="txtWgPort">-</td>
                </tr>
                <tr>
                  <td style="padding:8px; border:1px solid #222; background:#f7f7f7; font-weight:700;">Sea Service/Masa Layar</td>
                  <td style="padding:8px; border:1px solid #222;" id="txtWgSeaService">-</td>
                </tr>
              </table>

              <!-- WAGES INPUT SECTION -->
              <div>
                <p style="margin:0 0 4px 0; font-weight:700;">Understand & agree the total salary and salary pay system as company regulation as follows:</p>
                <p style="margin:0; font-style:italic;">Mengerti & menyetujui jumlah gaji dan sistem pembayarannya sesuai dengan peraturan perusahaan sebagai berikut:</p>
              </div>

              <div class="table-responsive mt-3">
                <table style="width:100%; border-collapse:collapse; text-align:center;">
                  <thead>
                    <tr>
                      <th style="border:1px solid #222; padding:8px; background:#fafafa;">Basic Wages</th>
                      <th style="border:1px solid #222; padding:8px; background:#fafafa;">FOT</th>
                      <th style="border:1px solid #222; padding:8px; background:#fafafa;">Tanker Allow.</th>
                      <th style="border:1px solid #222; padding:8px; background:#e0e0e0;">Total Pay</th>
                      <th style="border:1px solid #222; padding:8px; background:#fafafa;">B/S (%)</th>
                      <th style="border:1px solid #222; padding:8px; background:#fafafa;">H/S (%)</th>
                      <th style="border:1px solid #222; padding:8px; background:#fafafa;">Leave Pay</th>
                      <th style="border:1px solid #222; padding:8px; background:#e0e0e0;">Total Wages</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td style="border:1px solid #222; padding:6px;">
                          <input type="text" name="basic_wages" id="valBasic" class="form-control form-control-sm text-center wage-calc" required>
                      </td>
                      <td style="border:1px solid #222; padding:6px;">
                          <input type="text" name="fot" id="valFot" class="form-control form-control-sm text-center wage-calc" required>
                      </td>
                      <td style="border:1px solid #222; padding:6px;">
                          <input type="text" name="tanker_allow" id="valTanker" class="form-control form-control-sm text-center wage-calc" required>
                      </td>
                      <td style="border:1px solid #222; padding:6px; background:#f2f2f2;">
                          <input type="text" name="total_pay" id="valTotal" class="form-control form-control-sm text-center fw-bold" readonly style="background:#e9ecef;">
                      </td>
                      <td style="border:1px solid #222; padding:6px;">
                          <input type="text" name="bs_percent" id="valBs" class="form-control form-control-sm text-center wage-calc" required>
                      </td>
                      <td style="border:1px solid #222; padding:6px;">
                          <input type="text" name="hs_percent" id="valHs" class="form-control form-control-sm text-center wage-calc" required>
                      </td>
                      <td style="border:1px solid #222; padding:6px;">
                          <input type="text" name="leave_pay" id="valLeave" class="form-control form-control-sm text-center wage-calc" required>
                      </td>
                      <td style="border:1px solid #222; padding:6px; background:#f2f2f2;">
                          <input type="text" id="valTotalWages" class="form-control form-control-sm text-center fw-bold" readonly style="background:#e9ecef;">
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- NEXT OF KIN -->
              <div style="font-weight:700; margin-top:20px; margin-bottom:8px;">B. Next Of Kin / Keluarga Terdekat</div>
              <table style="width:60%; border-collapse:collapse;">
                <tr>
                  <td style="padding:8px; border:1px solid #222; background:#f7f7f7; font-weight:700; width:35%;">Name/Nama</td>
                  <td style="padding:8px; border:1px solid #222;" id="txtWgNokName">-</td>
                </tr>
                <tr>
                  <td style="padding:8px; border:1px solid #222; background:#f7f7f7; font-weight:700;">Relationship/Hub</td>
                  <td style="padding:8px; border:1px solid #222;" id="txtWgNokRel">-</td>
                </tr>
                <tr>
                  <td style="padding:8px; border:1px solid #222; background:#f7f7f7; font-weight:700;">No Tlp/HP</td>
                  <td style="padding:8px; border:1px solid #222;" id="txtWgNokPhone">-</td>
                </tr>
              </table>

              <!-- FOOTER -->
              <p style="font-style:italic; margin-top:16px;">I hereby confirm the above contained herein is correct, without compulsion.<br>
                <em>Demikian pernyataan ini saya buat dengan sebenarnya, tanpa paksaan dari pihak lain.</em>
              </p>

              <div style="display:flex; justify-content:space-between; margin-top:30px; text-align:center;">
                <div style="width:30%;">
                  <div style="font-weight:700;">Acknowledge,</div>
                  <div>Mengetahui,</div>
                  <div style="margin-top:60px;">Head of Crewing Division</div>
                </div>
                <div style="width:30%;">
                  <div style="font-weight:700;">Seafarer,</div>
                  <div>Pelaut,</div>
                  <div style="margin-top:60px; font-weight:700; text-decoration:underline;" id="txtWgSignName"></div>
                </div>
              </div>

          </form>
      </div>

      <div class="modal-footer bg-light" style="justify-content:flex-end;">
          <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" style="font-family: 'Times New Roman', Times, serif;"> Tutup</button>
          <button type="button" class="btn btn-sm btn-primary px-4" id="btnSubmitWages" style="font-family: 'Times New Roman', Times, serif;"><i class="fa fa-save me-1" ></i> Save & Print</button>
          <button type="button" class="btn btn-sm btn-primary px-4 d-none" id="btnGeneratePdfFromModalWg" style="font-family: 'Times New Roman', Times, serif;"><i class="fa fa-print me-1" ></i> Print</button>
      </div>

    </div>
  </div>
</div>

<!-- Hidden form for PDF generation -->
<form id="formPdfWages" method="POST" target="_blank" action="<?php echo base_url('ListReport/Wages/PrintWages'); ?>" style="display:none;">
    <input type="hidden" name="idperson" id="pdf_wg_idperson">
</form>

<!-- ============================================================
     STYLES & SCRIPTS
     ============================================================ -->
<style>
.crew-table th, .crew-table td { font-size: 12px; vertical-align: middle; }
.crew-header th { background-color: #000099 !important; color: #fff !important; }
.card-header i { color: #000099; }
.column-search { width: 100%; padding: 4px; border: 1px solid #ced4da; border-radius: 4px; font-size: 11px; }
.dataTables_wrapper { padding: 15px 0; }
.dataTables_length { padding: 10px 0; margin-bottom: 10px; }
.dataTables_length label, .dataTables_filter label { display: flex; align-items: center; margin: 0; padding: 20px 0; }
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

<script>
$(document).ready(function() {
    var BASE_URL_WG = '<?php echo base_url("ListReport/Wages"); ?>';
    var idperson = $('#contentArea').data('idperson');

    if (!idperson) {
        console.error('ID Person tidak ditemukan');
        return;
    }

    function formatNumber(num) {
        if (num === null || num === undefined || num === '') return '';
        var str = num.toString().replace(/\./g, ',');
        var parts = str.split(',');
        var whole = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        var decimal = parts.length > 1 ? ',' + parts[1] : '';
        return whole + decimal;
    }

    function unformatNumber(str) {
        if (!str) return 0;
        return parseFloat(str.toString().replace(/\./g, '').replace(/,/g, '.')) || 0;
    }

    // Auto calculate Total Pay and Total Wages
    $('.wage-calc').on('input', function() {
        // Format while typing
        var raw = $(this).val();
        var isNegative = raw.startsWith('-');
        raw = raw.replace(/[^0-9,]/g, '');
        
        var parts = raw.split(',');
        var whole = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        var decimal = parts.length > 1 ? ',' + parts[1] : '';
        var formatted = (isNegative ? '-' : '') + whole + decimal;
        
        $(this).val(formatted);

        var basic = unformatNumber($('#valBasic').val());
        var fot = unformatNumber($('#valFot').val());
        var tanker = unformatNumber($('#valTanker').val());
        var leave = unformatNumber($('#valLeave').val());
        var bs = unformatNumber($('#valBs').val());
        var hs = unformatNumber($('#valHs').val());
        
        var total_pay = basic + fot + tanker;
        $('#valTotal').val(formatNumber(total_pay));

        var total_wages = total_pay + leave;
        $('#valTotalWages').val(formatNumber(total_wages));
    });

    var wgTable = $('#wagesTable').DataTable({
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
            url: BASE_URL_WG + '/get_history',
            type: 'POST',
            data: function(d) { d.idperson = idperson; },
            dataSrc: function(json) { return json.success ? json.data : []; }
        },
        columns: [
            {
                data: null, className: 'fw-bold text-center', orderable: false, searchable: false,
                render: function(data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; }
            },
            { data: 'name', className: 'text-center' },
            { data: 'position', className: 'text-center' },
            { data: 'vessel', className: 'text-center' },
            { data: 'date_created_fmt', className: 'text-center fw-bold' },
            {
                data: null, className: 'text-center', orderable: false, searchable: false,
                render: function(data) {
                    return '<div class="btn-group btn-group-sm" role="group">' +
                        '<button type="button" class="btn btn-outline-primary btn-view-wg" title="View Detail / Print" ' +
                            'data-idperson="' + data.idperson + '" ' +
                            'data-name="' + data.name + '" ' +
                            'data-pos="' + data.position + '" ' +
                            'data-vsl="' + data.vessel + '" ' +
                            'data-signon="' + data.sign_on_date + '" ' +
                            'data-port="' + data.embarkation_port + '" ' +
                            'data-sea="' + data.sea_service + '" ' +
                            'data-nok_name="' + data.next_of_kin_name + '" ' +
                            'data-nok_rel="' + data.next_of_kin_relation + '" ' +
                            'data-nok_phone="' + data.next_of_kin_phone + '" ' +
                            'data-bw="' + data.basic_wages + '" ' +
                            'data-fot="' + data.fot + '" ' +
                            'data-tanker="' + data.tanker_allow + '" ' +
                            'data-leave="' + data.leave_pay + '" ' +
                            'data-bs="' + data.bs_percent + '" ' +
                            'data-hs="' + data.hs_percent + '" ' +
                            'data-total="' + data.total_pay + '">' +
                            '<i class="fa fa-eye"></i>' +
                        '</button>' +
                        '<button type="button" class="btn btn-outline-danger btn-delete-wg" title="Delete" data-id="' + data.id + '">' +
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
            emptyTable: 'Tidak ada data',
            zeroRecords: 'Data tidak ditemukan'
        }
    });

    $('#wagesTable thead tr:last th').each(function(i) {
        $('input', this).on('keyup change', function() {
            if (wgTable.column(i).search() !== this.value) {
                wgTable.column(i).search(this.value).draw();
            }
        });
    });

    // ADD
    $('#btnAddWages').on('click', function() {
        $('#formAddWages')[0].reset();
        $('#wg_idperson').val(idperson);
        $('.wage-calc').prop('readonly', false);
        
        $.ajax({
            url: BASE_URL_WG + '/getWages',
            type: 'POST',
            data: { idperson: idperson },
            dataType: 'json',
            success: function(res) {
                if (res.status) {
                    var d = res.data;
                    
                    // Preview UI Strings
                    $('#txtWgName').text(d.fullname);
                    $('#txtWgPosition').text(d.position);
                    $('#txtWgVessel').text(d.vessel_name);
                    $('#txtWgSignOn').text(d.sign_on_date);
                    $('#txtWgPort').text(d.embarkation_port);
                    $('#txtWgSeaService').text(d.sea_service);
                    
                    $('#txtWgNokName').text(d.next_of_kin_name);
                    $('#txtWgNokRel').text(d.next_of_kin_relation);
                    $('#txtWgNokPhone').text(d.next_of_kin_phone);
                    $('#txtWgSignName').text(d.fullname);

                    $('#btnSubmitWages').removeClass('d-none');
                    $('#btnGeneratePdfFromModalWg').addClass('d-none');

                    $('#modalWages').modal('show');
                } else {
                    wgNotify('warning', res.message || 'Data personal tidak ditemukan');
                }
            }
        });
    });

    // VIEW DETAIL
    $('#wagesTable').on('click', '.btn-view-wg', function() {
        var btn = $(this);
        
        $('#pdf_wg_idperson').val(btn.data('idperson'));

        // Load Text fields
        $('#txtWgName').text(btn.data('name'));
        $('#txtWgPosition').text(btn.data('pos'));
        $('#txtWgVessel').text(btn.data('vsl'));
        $('#txtWgSignOn').text(btn.data('signon'));
        $('#txtWgPort').text(btn.data('port'));
        $('#txtWgSeaService').text(btn.data('sea'));
        $('#txtWgNokName').text(btn.data('nok_name'));
        $('#txtWgNokRel').text(btn.data('nok_rel'));
        $('#txtWgNokPhone').text(btn.data('nok_phone'));
        $('#txtWgSignName').text(btn.data('name'));

        // Load inputs and set to readonly
        $('#valBasic').val(formatNumber(btn.data('bw'))).prop('readonly', true);
        $('#valFot').val(formatNumber(btn.data('fot'))).prop('readonly', true);
        $('#valTanker').val(formatNumber(btn.data('tanker'))).prop('readonly', true);
        $('#valLeave').val(formatNumber(btn.data('leave'))).prop('readonly', true);
        $('#valBs').val(formatNumber(btn.data('bs'))).prop('readonly', true);
        $('#valHs').val(formatNumber(btn.data('hs'))).prop('readonly', true);
        
        var total_pay = parseFloat(btn.data('total')) || 0;
        var leave_pay = parseFloat(btn.data('leave')) || 0;
        $('#valTotal').val(formatNumber(total_pay));
        $('#valTotalWages').val(formatNumber(total_pay + leave_pay));

        $('#btnSubmitWages').addClass('d-none');
        $('#btnGeneratePdfFromModalWg').removeClass('d-none');

        $('#modalWages').modal('show');
    });

    // SUBMIT
    $('#btnSubmitWages').on('click', function() {
        // Unformat before submitting
        $('.wage-calc, #valTotal').each(function() {
            var uf = unformatNumber($(this).val());
            $(this).val(uf);
        });

        var formData = new FormData($('#formAddWages')[0]);
        
        // Re-format back so UI remains correctly displayed
        $('.wage-calc, #valTotal').each(function() {
            var rf = formatNumber($(this).val());
            $(this).val(rf);
        });

        var btn = $(this);
        
        // Simple validation
        var isValid = true;
        $('.wage-calc').each(function() {
            if ($(this).val() === "") isValid = false;
        });

        if (!isValid) {
            wgNotify('warning', 'Harap lengkapi semua input wages (angka).');
            return;
        }

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin ms-1"></i> Menyimpan...');

        $.ajax({
            url: BASE_URL_WG + '/saveWagesData',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                btn.prop('disabled', false).html('Simpan & Print');
                if (res.success) {
                    $('#modalWages').modal('hide');
                    wgTable.ajax.reload(null, false);
                    wgNotify('success', res.message);
                    
                    // Auto print PDF
                    $('#pdf_wg_idperson').val(idperson);
                    $('#formPdfWages').submit();
                } else {
                    wgNotify('error', res.message);
                }
            },
            error: function() {
                btn.prop('disabled', false).html('Simpan & Print');
                wgNotify('error', 'Terjadi kesalahan sistem');
            }
        });
    });

    // PRINT FROM MODAL
    $('#btnGeneratePdfFromModalWg').on('click', function() {
        $('#formPdfWages').submit();
    });

    // DELETE
    $('#wagesTable').on('click', '.btn-delete-wg', function() {
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
            }).then(function(result) {
                if (result.isConfirmed) doDeleteWg(id);
            });
        } else {
            if (confirm('Yakin ingin menghapus history ini?')) {
                doDeleteWg(id);
            }
        }
    });

    function doDeleteWg(id) {
        $.ajax({
            url: BASE_URL_WG + '/delete_history',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    wgTable.ajax.reload(null, false);
                    wgNotify('success', res.message);
                } else {
                    wgNotify('error', res.message);
                }
            }
        });
    }

    function wgNotify(type, msg) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type, title: type === 'success' ? 'Sukses' : 'Error', text: msg,
                timer: 3000, showConfirmButton: false, toast: true, position: 'top-end'
            });
        } else {
            alert(msg);
        }
    }
});
</script>