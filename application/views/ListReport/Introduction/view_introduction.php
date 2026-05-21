<!-- ============================================================
     Introduction Module View — Loaded via AJAX into list_report.php
     Features: DataTables, Add Modal, Delete, Print PDF
     ============================================================ -->

<div class="card shadow-sm border-0" id="introModuleWrapper">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-primary btn-sm" id="btnAddIntro" style="background-color: #000999; border-color: #000999;">
                <i class="fa fa-plus me-1"></i> Add Introduction
            </button>
        </div>
        <div class="table-responsive">
            <table id="introTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                    <tr>
                        <th class="text-center" style="width:50px;">No</th>
                        <th class="text-center">Date Created</th>
                        <th class="text-center">Company</th>
                        <th class="text-center">Vessel</th>
                        <th class="text-center">Port</th>
                        <th class="text-center">Crew</th>
                        <th class="text-center" style="width:100px;">Action</th>
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

<div class="modal fade" id="introModal" tabindex="-1">
  <div class="modal-dialog modal-lg" style="max-width:850px;">
    <form id="formAddIntro" class="modal-content" style="border:1px solid #000; border-radius:6px; font-family:'Times New Roman', serif;">
      
      <div class="modal-header" style="background: linear-gradient(135deg, #000999 0%, #1a237e 100%); color: #fff;">
          <h6 class="modal-title fw-bold">
              <i class="fa fa-file-text-o me-2"></i>Instruction Letter
          </h6>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1) grayscale(100%) brightness(200%);"></button>
      </div>

      <div class="modal-body" style="padding:25px; max-height:70vh; overflow-y:auto;">
          <table style="width:100%; border-collapse:collapse;">
            <tr>
              <td style="width:90px; vertical-align:top;">
                <img src="<?php echo base_url('assets/img/Logo_Andhika_2017.jpg'); ?>" style="width:80px;">
              </td>

              <td style="text-align:center; vertical-align:middle;">
                <div style="font-size:18px; letter-spacing:10px; font-weight:bold;">INSTRUKSI</div>
                <div style="font-size:15px; font-weight:bold; margin-top:3px;">INSTRUCTION LETTER</div>
              </td>

              <td style="width:170px; text-align:right; vertical-align:top;">
                <div style="font-size:11px; font-weight:bold;">SRPS LICENSE NO:</div>
                <div style="font-size:10px;">SIUKAK 236.121 - R Tahun 2025</div>
                <div style="margin-top:5px;">
                  <img src="<?php echo base_url('assets/img/Bureau_Veritas_Logo.jpg'); ?>" style="width:60px; margin-right:3px;">
                  <img src="<?php echo base_url('assets/img/Iso.jpg'); ?>" style="width:60px;">
                </div>
              </td>
            </tr>
          </table>

          <table style="width:100%; margin-top:25px; font-size:13px;">
            <tr>
              <td style="width:120px;">Berdasarkan</td>
              <td>: Kepentingan Dinas Perusahaan</td>
            </tr>
            <tr>
              <td>Base on</td>
              <td>: Shipping Company Official Regulation</td>
            </tr>
            <tr>
              <td></td>
              <td>: <span class="entitas-fill"></span></td>
            </tr>
          </table>

          <div style="margin-top:30px; text-align:center; font-weight:bold;">
            DIINSTRUKSIKAN<br>
            <span style="font-weight:normal;">INSTRUCTED</span>
          </div>

          <table style="width:100%; margin-top:20px; font-size:13px;">
            <tr>
              <td style="width:110px;">Kepada (To)</td>
              <td>: Master <span class="kapal-fill"></span></td>
            </tr>
            <tr>
              <td>Untuk (For)</td>
              <td>: _______________________________</td>
            </tr>
          </table>

          <!-- TABLE 1 RELEASE -->
          <div style="margin-top:18px; font-size:13px;">
            1. Membebaskan dari tugas dan tanggung jawab serta jabatan:
            <br><i>Release from the duty/responsibility...</i>
          </div>

          <table id="releaseTable" style="width:100%; border:1px solid #000; border-collapse:collapse; margin-top:5px; text-align:center; font-size:13px;">
            <tr class="release-header" style="background:#f2f2f2;">
              <td style="padding:6px; border:1px solid #000;">Nama / Name</td>
              <td style="padding:6px; border:1px solid #000;">Jabatan / Rank</td>
              <td style="padding:6px; border:1px solid #000;">Alasan / Reason</td>
              <td style="padding:6px; border:1px solid #000;">Tax Status</td>
            </tr>
            <tr class="release-row">
              <td style="padding:0; border:1px solid #000; vertical-align:middle;">
                <input type="text" name="release_name" id="release_name" class="form-control" style="border:none; height:38px; text-align:center;" readonly required>
              </td>
              <td style="padding:0; border:1px solid #000; vertical-align:middle;">
                <input type="text" name="release_rank" id="release_rank" class="form-control" style="border:none; height:38px; text-align:center;" readonly required>
              </td>
              <td style="padding:0; border:1px solid:#000; vertical-align:middle;">
                <select name="release_reason" id="release_reason" class="form-select form-select-sm" style="border:none; height:38px; text-align:center;" required>
                    <option value="Company Orders">Company Orders</option>
                    <option value="Personal Reason / Request">Personal Reason / Request</option>
                    <option value="Sick Onboard">Sick Onboard</option>
                    <option value="End of Contract">End of Contract</option>
                </select>
              </td>
              <td style="padding:0; border:1px solid:#000; vertical-align:middle;">
                <select name="release_others" id="release_others" class="form-select form-select-sm" style="border:none; height:38px; text-align:center;" required>
                    <option value="" disabled selected>-- Select --</option>
                    <?php echo str_replace("<option value=''></option>", "", $optTax); ?>
                </select>
              </td>
            </tr>
          </table>

          <div style="margin-top:20px; font-size:13px;">
            2. Sebagai penggantinya ditetapkan sebagai berikut:
            <br><i>As the successor:</i>
          </div>

          <table id="successorTable" style="width:100%; border:1px solid #000; border-collapse:collapse; margin-top:5px; font-size:13px; text-align:center;">
            <tr style="background:#f2f2f2;">
              <td rowspan="2" style="padding:6px; border:1px solid #000; vertical-align:middle;">Nama</td>
              <td rowspan="2" style="padding:6px; border:1px solid #000; vertical-align:middle;">Jabatan</td>
              <td colspan="3" style="padding:6px; border:1px solid #000;">Wages</td>
            </tr>
            <tr style="background:#f2f2f2;">
              <td style="padding:6px; border:1px solid #000;">B/S</td>
              <td style="padding:6px; border:1px solid #000;">OT</td>
              <td style="padding:6px; border:1px solid #000;">Leave Pay</td>
            </tr>
            <tr class="successor-row">
              <td style="padding:0; border:1px solid #000;">
                <input type="text" name="successor_name" id="successor_name" class="form-control" style="border:none; height:38px; text-align:center;" readonly required>
              </td>
              <td style="padding:0; border:1px solid #000;">
                <input type="text" name="successor_rank" id="successor_rank" class="form-control" style="border:none; height:38px; text-align:center;" readonly required>
              </td>
              <td style="padding:0; border:1px solid #000;">
                <input type="text" name="successor_bs" id="successor_bs" class="form-control format-rupiah" style="border:none; height:38px; text-align:right;" placeholder="0" required>
              </td>
              <td style="padding:0; border:1px solid #000;">
                <input type="text" name="successor_ot" id="successor_ot" class="form-control format-rupiah" style="border:none; height:38px; text-align:right;" placeholder="0" required>
              </td>
              <td style="padding:0; border:1px solid #000;">
                <input type="text" name="successor_leavepay" id="successor_leavepay" class="form-control format-rupiah" style="border:none; height:38px; text-align:right;" placeholder="0" required>
              </td>
            </tr>
          </table>
          
          <div style="margin-top:5px; text-align:right; font-size:13px; font-weight:bold;">
            Total: <span id="successor_total_label">0</span>
          </div>

          <div style="margin-top:18px; font-size:13px; line-height:1.5;">
            3. Selesai pelaksanaan sign off, agar off signer menghadapi Direksi
            <span class="entitas-fill"></span>
            Cq. Manager Personalia Laut untuk menerima instruksi selanjutnya.<br>

            <i>After completing the contract, off signer must report to
              <span class="entitas-fill"></span>
              Director Cq. Marine Personal Division Manager to receive next instruction.
            </i><br><br>

            4. Pelaksanaan Sign On/Off di pelabuhan: <span class="port-fill"></span><br>
            <i>The Signing On/Off at: <span class="port-fill"></span></i><br><br>

            5. Apabila terdapat kekeliruan dikemudian hari, akan diadakan pembetulan seperlunya.<br>
            <i>If found any mistake in the future, it will be corrected.</i><br><br>

            6. Agar dilaksanakan dengan penuh tanggung jawab.<br>
            <i>Please follow with full responsibility.</i>
          </div>

          <div style="margin-top:35px; display:flex; justify-content:space-between; font-size:13px;">
            <div>
              Instruksi: Selesai<br>
              <i>Instruction: Done</i>
            </div>
            <div style="text-align:right;">
              Jakarta, <span class="tanggal-fill"><?php echo date('d M Y'); ?></span><br>
              <span class="entitas-fill"></span>
            </div>
          </div>

          <div style="margin-top:60px; text-align:right; font-size:14px; font-weight:bold;">
            Eva Marliana<br>
            <span style="font-weight:normal;">Crewing Manager</span>
          </div>
      </div> <!-- End Modal Body -->

      <div class="modal-footer" style="border-top:none; justify-content:flex-end; padding: 15px;">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="font-family: 'Times New Roman', Times, serif;">Tutup</button>
        <input type="hidden" name="idperson" id="hid_idperson">
        <input type="hidden" name="company" id="hid_entitas">
        <input type="hidden" name="vessel" id="hid_vessel">
        <input type="hidden" name="port" id="hid_port">
        <input type="hidden" name="date_created" id="hid_tanggal" value="<?php echo date('Y-m-d'); ?>">

        <button type="button" class="btn btn-primary d-none text-white" id="btnPrintModal"><i class="fa fa-print me-1"></i> Print PDF</button>
        <button type="submit" class="btn btn-primary" id="btnSaveAndPrintIntroduction"><i class="fa fa-save me-1"></i> Save & Print</button>
      </div>

    </form>
  </div>
</div>

<style>
/* Table Styles */
.crew-table th, .crew-table td { font-size: var(--crew-font-sm, 12px); vertical-align: middle; }
.crew-table th { font-weight: 600; text-align: center; }
.crew-table .btn { font-size: var(--crew-font-xs, 11px); padding: 4px 8px; }
.crew-header th { background-color: var(--crew-blue, #000099) !important; color: #fff !important; }
.column-search { width: 100%; padding: 4px; border: 1px solid #ced4da; border-radius: 4px; font-size: 11px; }

/* DataTables Customization */
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
    var BASE_URL = '<?php echo base_url("ListReport/Introduction"); ?>';
    
    // Get idperson from contentArea
    var idperson = $('#contentArea').data('idperson');
    if (!idperson) {
        console.error('ID Person tidak ditemukan');
        return;
    }

    // Format Rupiah function
    function formatRupiah(angka, prefix) {
        if (!angka) return '';
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split         = number_string.split(','),
            sisa          = split[0].length % 3,
            rupiah        = split[0].substr(0, sisa),
            ribuan        = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            var separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function unformatRupiah(rupiah) {
        if (!rupiah) return 0;
        return parseInt(rupiah.replace(/[^0-9]/g, '')) || 0;
    }

    function calculateTotal() {
        var bs = unformatRupiah($('#successor_bs').val());
        var ot = unformatRupiah($('#successor_ot').val());
        var lp = unformatRupiah($('#successor_leavepay').val());
        var total = bs + ot + lp;
        $('#successor_total_label').text(formatRupiah(total.toString(), 'Rp. '));
    }

    $('.format-rupiah').on('keyup', function() {
        $(this).val(formatRupiah($(this).val()));
        calculateTotal();
    });

    var introTable = $('#introTable').DataTable({
        processing: true,
        serverSide: false,
        searching: true,
        paging: true,
        info: true,
        lengthChange: true,
        pageLength: 10,
        order: [],
        ajax: {
            url: BASE_URL + '/get_report_introduction',
            type: 'POST',
            data: { idperson: idperson },
            dataSrc: function(json) {
                return json.success ? json.data : [];
            }
        },
        columns: [
            { data: null, className: 'text-center', render: function(d,t,r,m) { return m.row+1; } },
            { data: 'date_created', className: 'text-center' },
            { data: 'company' },
            { data: 'vessel', className: 'text-center' },
            { data: 'port', className: 'text-center' },
            { data: 'release_name', className: 'text-center' },
            {
                data: null, className: 'text-center', orderable: false,
                render: function(data) {
                    var detailJson = encodeURIComponent(JSON.stringify(data));
                    return '<div class="btn-group btn-group-sm" role="group">' +
                        '<button type="button" class="btn btn-outline-primary btn-detail-intro" title="Detail" data-detail="' + detailJson + '">' +
                            '<i class="fa fa-eye"></i>' +
                        '</button>' +
                        '<button type="button" class="btn btn-outline-danger btn-delete-intro" title="Delete" data-id="' + data.id + '">' +
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
                        if (column.search() !== this.value) { column.search(this.value).draw(); }
                    });
                }
            });
        }
    });

    $('#introTable thead tr:last th').each(function(i) {
        $('input', this).on('keyup change', function() {
            if (introTable.column(i).search() !== this.value) {
                introTable.column(i).search(this.value).draw();
            }
        });
    });

    $('#btnAddIntro').on('click', function() {
        $('#formAddIntro')[0].reset();
        
        // Make all inputs editable again
        $('#formAddIntro input, #formAddIntro select').prop('disabled', false);
        // Except names and ranks which are always readonly
        $('#release_name, #release_rank, #successor_name, #successor_rank').prop('readonly', true);
        
        $('#btnSaveAndPrintIntroduction').removeClass('d-none');
        $('#btnPrintModal').addClass('d-none');

        $('#hid_idperson').val(idperson);
        $('#successor_total_label').text('0');

        $.ajax({
            url: BASE_URL + '/get_crew_info_by_idperson',
            type: 'POST',
            data: { idperson: idperson },
            dataType: 'json',
            success: function(res) {
                if (res.success && res.data) {
                    var d = res.data;
                    $('.entitas-fill').text(d.company || '');
                    $('.kapal-fill').text(d.vessel || '');
                    $('.port-fill').text(d.port || '');

                    $('#hid_entitas').val(d.company || '');
                    $('#hid_vessel').val(d.vessel || '');
                    $('#hid_port').val(d.port || '');

                    $('#release_name').val(d.crew_name || '');
                    $('#release_rank').val(d.rank || '');
                    $('#successor_name').val(d.crew_name || '');
                    $('#successor_rank').val(d.rank || '');
                }
            }
        });

        $('#introModal').modal('show');
    });

    $('#introTable').on('click', '.btn-detail-intro', function() {
        var data = JSON.parse(decodeURIComponent($(this).data('detail')));
        
        $('#formAddIntro')[0].reset();
        $('#btnSaveAndPrintIntroduction').addClass('d-none');
        $('#btnPrintModal').removeClass('d-none').off('click').on('click', function() {
            window.open(BASE_URL + '/generatePDF_Introduction/' + data.id, '_blank');
        });

        // Fill data
        $('.entitas-fill').text(data.company || '');
        $('.kapal-fill').text(data.vessel || '');
        $('.port-fill').text(data.port || '');
        
        $('#release_name').val(data.release_name || '');
        $('#release_rank').val(data.release_rank || '');
        $('#release_reason').val(data.release_reason || '');
        $('#release_others').val(data.release_others || '');
        
        $('#successor_name').val(data.successor_name || '');
        $('#successor_rank').val(data.successor_rank || '');
        $('#successor_bs').val(formatRupiah((data.successor_bs || '0').toString()));
        $('#successor_ot').val(formatRupiah((data.successor_ot || '0').toString()));
        $('#successor_leavepay').val(formatRupiah((data.successor_leavepay || '0').toString()));
        
        calculateTotal();

        // Disable all inputs to make it readonly
        $('#formAddIntro input, #formAddIntro select').not('[type="hidden"]').prop('disabled', true);

        $('#introModal').modal('show');
    });

    $('#formAddIntro').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serializeArray();
        $.each(formData, function(i, field) {
            if (['successor_bs', 'successor_ot', 'successor_leavepay'].includes(field.name)) {
                field.value = unformatRupiah(field.value);
            }
        });

        var btn = $('#btnSaveAndPrintIntroduction');
        var originalText = btn.html();
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: BASE_URL + '/submit_report_introduction',
            type: 'POST',
            data: $.param(formData),
            dataType: 'json',
            success: function(res) {
                btn.prop('disabled', false).html(originalText);
                if (res.success) {
                    $('#introModal').modal('hide');
                    introTable.ajax.reload(null, false);
                    if (typeof showNotification === 'function') {
                        showNotification('success', res.message);
                    }
                    window.open(BASE_URL + '/generatePDF_Introduction/' + res.id_report, '_blank');
                } else {
                    if (typeof showNotification === 'function') {
                        showNotification('error', res.message || 'Gagal menyimpan data');
                    } else {
                        alert(res.message || 'Gagal menyimpan data');
                    }
                }
            },
            error: function() {
                btn.prop('disabled', false).html(originalText);
                if (typeof showNotification === 'function') {
                    showNotification('error', 'Terjadi kesalahan server');
                } else {
                    alert('Terjadi kesalahan server');
                }
            }
        });
    });

    $('#introTable').on('click', '.btn-delete-intro', function() {
        var id = $(this).data('id');
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data Introduction ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: BASE_URL + '/delete_report_introduction',
                        type: 'POST',
                        data: { id: id },
                        dataType: 'json',
                        success: function(res) {
                            if (res.success) {
                                Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                                introTable.ajax.reload(null, false);
                            } else {
                                Swal.fire('Gagal!', res.message || 'Gagal menghapus data', 'error');
                            }
                        }
                    });
                }
            });
        } else {
            if (confirm('Hapus data Introduction ini?')) {
                $.ajax({
                    url: BASE_URL + '/delete_report_introduction',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(res) {
                        if (res.success) {
                            introTable.ajax.reload(null, false);
                        } else {
                            alert(res.message || 'Gagal menghapus data');
                        }
                    }
                });
            }
        }
    });

});
</script>