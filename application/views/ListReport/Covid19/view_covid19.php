<div class="card shadow-sm border-0" id="covid19ModuleWrapper">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-sm rounded shadow-sm" id="btnGlobalAddCovid19" style="background-color: #000999; border-color: #000999;">
                <i class="fa fa-plus me-1"></i> Add Health
            </button>
        </div>
        <div class="table-responsive">
            <table id="covid19Table" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                    <tr>
                        <th class="text-center" style="width:50px;">No</th>
                        <th class="text-center">Tanggal Dibuat</th>
                        <th class="text-center">Nama Crew</th>
                        <th class="text-center">Rank</th>
                        <th class="text-center">Vessel Name</th>
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
     MODAL: Add / View Covid19 Form
     ============================================================ -->
<div class="modal fade" id="modalAddCovid19" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <!-- Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, #000999 0%, #1a237e 100%); color: #fff;">
                <h6 class="modal-title fw-bold" id="modalAddCovid19Title">
                    <i class="fa fa-plus-circle me-2"></i>Tambah Data Health and Pandemic
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Body -->
            <div class="modal-body bg-light position-relative">
                <div id="modalAddCovid19Overlay" class="position-absolute top-0 start-0 w-100 h-100 d-none" style="background: rgba(255,255,255,0.7); z-index: 10; align-items: center; justify-content: center; display: flex;">
                    <div class="spinner-border" style="color: #000999;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <form id="formAddCovid19">
                    <input type="hidden" name="idperson" id="covid19_idperson">
                    <input type="hidden" name="sign_on" id="covid19_sign_on">
                    
                    <div class="card shadow-sm border-0 mb-4">
                         <div class="card-header bg-white fw-bold text-primary border-bottom">
                            <i class="fa fa-medkit me-2"></i>Health and Pandemic Form
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label text-muted small mb-1">Nama Lengkap</label>
                                    <input type="text" class="form-control form-control-sm" name="fullname" id="covid19_fullname" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Rank</label>
                                    <input type="text" class="form-control form-control-sm" name="nmrank" id="covid19_nmrank" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small mb-1">Vessel</label>
                                    <input type="text" class="form-control form-control-sm" name="nmvsl" id="covid19_nmvsl" readonly>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <table style="width:100%; border-collapse:collapse; font-size:11px;">
                                    <tbody>

                                        <?php
                                        $items = array(
                                            array("Avoid these modes of travel if you have a fever or a cough.",
                                             "Hindari perjalanan moda transportasi ini apabila anda sedang sakit demam atau batuk.",
                                             "gambar1.jpg"),

                                            array("Eat only well-cooked food.",
                                             "Makanlah makanan yang dimasak matang.",
                                             "gambar2.jpg"),

                                            array("Avoid spitting in public.",
                                             "Hindari meludah di keramaian.",
                                             "gambar3.jpg"),

                                            array("Avoid close contact and travel with sick animals, particularly in wet markets.",
                                             "Hindari kontak dekat dan bepergian dengan binatang yang sakit, terutama di pasar tradisional.",
                                             "gambar4.jpg"),

                                            array("When coughing and sneezing, cover your mouth and nose with a tissue or flexed elbow.",
                                             "Ketika batuk dan bersin, tutuplah mulut dan hidung dengan tisu atau siku.",
                                             "gambar5.jpg"),

                                            array("Frequently clean hands with alcohol-based hand rub or wash with soap at least 20 seconds.",
                                             "Sering membersihkan tangan dengan hand sanitizer atau sabun selama 20 detik.",
                                             "gambar6.jpg"),

                                            array("Avoid touching eyes, nose, mouth.",
                                             "Hindari menyentuh mata, hidung, dan mulut.",
                                             "gambar7.jpg"),

                                            array("Avoid close contact with people suffering fever or cough.",
                                             "Hindari kontak dekat dengan orang yang menderita demam atau batuk.",
                                             "gambar8.jpg"),

                                            array("If wearing a mask, ensure it covers mouth and nose.",
                                             "Jika memakai masker, pastikan menutupi mulut dan hidung.",
                                             "gambar9.jpg"),

                                            array("If you become sick while traveling, tell the crew or ground staff.",
                                             "Jika sakit saat bepergian, beritahu petugas.",
                                             "gambar10.jpg"),

                                            array("Seek medical care early if you become sick and share history with the provider.",
                                             "Cari perawatan medis lebih awal jika sakit.",
                                             "gambar11.jpg"),
                                        );

                                        foreach ($items as $item): ?>
                                        <tr>
                                            <td style="padding:6px; border:1px solid #ccc;">
                                                <table style="width:100%;">
                                                    <tr>
                                                        <td style="width:72%; vertical-align:top; padding-right:6px;">
                                                            <?php echo $item[0]; ?><br>
                                                            <i><?php echo $item[1]; ?></i>
                                                        </td>

                                                        <td style="width:28%; text-align:right; vertical-align:top;">
                                                            <img src="<?php echo base_url('assets/img/' . $item[2]); ?>" style="width:80px;">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-4" style="font-size: 13px;">
                                <div class="mt-2 text-danger fst-italic">
                                    As International Chamber of Shipping Maritime Publications 2020<br>
                                    Have read, understand and will be implemented.
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" style="font-family: 'Times New Roman', Times, serif;">Tutup</button>
                <button type="button" class="btn btn-sm btn-primary px-4" id="btnSubmitCovid19" style="font-family: 'Times New Roman', Times, serif;"><i class="fa fa-save"></i> Save</button>
                <button type="button" class="btn btn-sm btn-primary px-4 d-none" id="btnGeneratePdfFromModalCovid19" style="font-family: 'Times New Roman', Times, serif;"><i class="fa fa-print"></i> Print</button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden form for PDF generation -->
<form id="formPdfCovid19" method="POST" target="_blank" action="<?php echo base_url('ListReport/Covid19/print_covid19_pdf'); ?>" style="display:none;">
    <input type="hidden" name="id_report_covid19" id="pdf_id_report_covid19">
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
    var BASE_URL_COVID = '<?php echo base_url("ListReport/Covid19"); ?>';
    
    // Get idperson from contentArea
    var idperson = $('#contentArea').data('idperson');
    if (!idperson) {
        console.error('ID Person tidak ditemukan untuk Health and Pandemic Guidelines');
        return;
    }

    // ================================
    // DataTables Initialization
    // ================================
    var covid19Table = $('#covid19Table').DataTable({
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
            url: BASE_URL_COVID + '/get_report_covid19',
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
            { 
                data: 'created_at', 
                className: 'text-center fw-bold',
                render: function(data) {
                    if(!data) return '-';
                    var d = new Date(data);
                    var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                    return ('0' + d.getDate()).slice(-2) + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
                }
            },
            { data: 'fullname', className: 'text-center' },
            { data: 'rankname', className: 'text-center' },
            { data: 'vessel_name', className: 'text-center' },
            {
                data: null,
                className: 'text-center',
                orderable: false,
                searchable: false,
                render: function(data) {
                    return '<div class="btn-group btn-group-sm" role="group">' +
                        '<button type="button" class="btn btn-outline-primary btn-print-covid19" title="Print/View PDF" data-id="' + data.id + '">' +
                            '<i class="fa fa-eye"></i>' +
                        '</button>' +
                        '<button type="button" class="btn btn-outline-danger btn-delete-covid19" title="Delete" data-id="' + data.id + '">' +
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

    // Column search sync
    $('#covid19Table thead tr:last th').each(function(i) {
        $('input', this).on('keyup change', function() {
            if (covid19Table.column(i).search() !== this.value) {
                covid19Table.column(i).search(this.value).draw();
            }
        });
    });

    // ================================
    // ADD DATA
    // ================================
    $('#btnGlobalAddCovid19').on('click', function() {
        openAddCovid19Modal();
    });

    function openAddCovid19Modal() {
        $('#formAddCovid19')[0].reset();
        $('#covid19_idperson').val(idperson);
        $('#modalAddCovid19Title').html('<i class="fa fa-plus-circle me-2"></i>Tambah Data Health and Pandemic');

        // Apply Layout Mode: Create
        $('#btnSubmitCovid19').removeClass('d-none');
        $('#btnGeneratePdfFromModalCovid19').addClass('d-none');
        $('#formAddCovid19 input').prop('disabled', false);

        $('#modalAddCovid19Overlay').removeClass('d-none');
        $('#modalAddCovid19').modal('show');

        // Fetch Data from Contract
        $.ajax({
            url: BASE_URL_COVID + '/get_data_form_covid19',
            type: 'POST',
            data: { idperson: idperson },
            dataType: 'json',
            success: function(res) {
                $('#modalAddCovid19Overlay').addClass('d-none');
                if (res.success && res.data.length > 0) {
                    var pd = res.data[0];
                    $('#covid19_fullname').val(pd.fullname);
                    $('#covid19_nmrank').val(pd.nmrank);
                    $('#covid19_nmvsl').val(pd.nmvsl);
                    $('#covid19_sign_on').val(pd.sign_on);
                } else {
                    covidNotify('warning', 'Data contract terbaru tidak ditemukan.');
                }
            },
            error: function() {
                $('#modalAddCovid19Overlay').addClass('d-none');
                covidNotify('error', 'Terjadi kesalahan sistem saat memuat data contract.');
            }
        });
    }

    $('#btnSubmitCovid19').on('click', function() {
        var form = $('#formAddCovid19')[0];
        if (!form.reportValidity()) return;

        var formData = new FormData(form);
        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin ms-1"></i> Menyimpan...');

        $.ajax({
            url: BASE_URL_COVID + '/save_covid19',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                btn.prop('disabled', false).html('Simpan');
                if (res.success) {
                    $('#modalAddCovid19').modal('hide');
                    covid19Table.ajax.reload(null, false);
                    covidNotify('success', res.message);
                } else {
                    covidNotify('error', res.message);
                }
            },
            error: function() {
                btn.prop('disabled', false).html('Simpan');
                covidNotify('error', 'Terjadi kesalahan sistem');
            }
        });
    });

    // ================================
    // VIEW / DETAIL DATA
    // ================================
    $('#covid19Table').on('click', '.btn-print-covid19', function() {
        var id = $(this).data('id');

        $('#formAddCovid19')[0].reset();
        $('#pdf_id_report_covid19').val(id);
        $('#modalAddCovid19Title').html('<i class="fa fa-file-text-o me-2"></i>Detail Data Health and Pandemic ');

        // Apply Layout Mode: View
        $('#btnSubmitCovid19').addClass('d-none');
        $('#btnGeneratePdfFromModalCovid19').removeClass('d-none');
        $('#formAddCovid19 input').prop('disabled', true);
        
        $('#modalAddCovid19Overlay').removeClass('d-none');
        $('#modalAddCovid19').modal('show');

        $.ajax({
            url: BASE_URL_COVID + '/get_report_covid19_detail',
            type: 'POST',
            data: { id_report: id },
            dataType: 'json',
            success: function(res) {
                $('#modalAddCovid19Overlay').addClass('d-none');
                if (res.success) {
                    var b = res.data;
                    $('#covid19_fullname').val(b.fullname);
                    $('#covid19_nmrank').val(b.rankname);
                    $('#covid19_nmvsl').val(b.vessel_name);
                    $('#covid19_sign_on').val(b.sign_on);
                } else {
                    covidNotify('error', res.message);
                    $('#modalAddCovid19').modal('hide');
                }
            },
            error: function() {
                $('#modalAddCovid19Overlay').addClass('d-none');
                covidNotify('error', 'Gagal memuat detail');
                $('#modalAddCovid19').modal('hide');
            }
        });
    });

    $('#btnGeneratePdfFromModalCovid19').on('click', function() {
        $('#formPdfCovid19').submit();
    });

    // ================================
    // DELETE DATA
    // ================================
    $('#covid19Table').on('click', '.btn-delete-covid19', function() {
        var id = $(this).data('id');

        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Data?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus'
            }).then(function(result) {
                if (result.isConfirmed) doDeleteCovid19(id);
            });
        } else {
            if (confirm('Yakin ingin menghapus data ini?')) {
                doDeleteCovid19(id);
            }
        }
    });

    function doDeleteCovid19(id) {
        $.ajax({
            url: BASE_URL_COVID + '/delete_report_covid19',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    covid19Table.ajax.reload(null, false);
                    covidNotify('success', res.message);
                } else {
                    covidNotify('error', res.message);
                }
            }
        });
    }

    // Helper notification
    function covidNotify(type, msg) {
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
