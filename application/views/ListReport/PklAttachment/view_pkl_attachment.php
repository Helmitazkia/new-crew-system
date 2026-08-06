<!-- PKL Attachment Module View — Loaded via AJAX -->
<div class="card shadow-sm border-0" id="pklModuleWrapper">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary btn-sm rounded shadow-sm" id="btnAddPklAttachment" style="background-color: #000999; border-color: #000999;">
                <i class="fa fa-plus me-1"></i> Add PKL Addendum
            </button>
        </div>
        <div class="table-responsive">
            <table id="pklAttachmentTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
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
     MODAL: Add / View PKL Attachment
     ============================================================ -->
<div class="modal fade" id="modalPklAttachment" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow">
      
      <div class="modal-header" style="background: linear-gradient(135deg, #000999 0%, #1a237e 100%); color: #fff;">
          <h6 class="modal-title fw-bold">
              <i class="fa fa-file-text-o me-2"></i>PKL Addendum
          </h6>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1) grayscale(100%) brightness(200%);"></button>
      </div>

      <div class="modal-body bg-light" style="padding:40px 55px; font-family:'Times New Roman', serif; font-size:14px; background-color: #fff !important; max-height: 70vh; overflow-y: auto;">
          <form id="formAddPklAttachment" style="width: 100%;">
              <input type="hidden" name="id" id="pkl_id">
              <input type="hidden" name="idperson" id="pkl_idperson">
              <input type="hidden" name="nama_crew" id="pkl_nama_crew">
              <input type="hidden" name="rank" id="pkl_rank">
              <input type="hidden" name="dob" id="pkl_dob">
              <input type="hidden" name="no_passport" id="pkl_no_passport">
              <input type="hidden" name="duration" id="pkl_duration">

              <h2 style="text-align:center; margin:0 0 20px 0; font-weight:bold; text-decoration:underline;">
                  SANKSI DAN PELANGGARAN
              </h2>

              <p>Yang bertanda tangan di bawah ini:</p>

              <table style="width:100%; margin-bottom:15px; font-size:14px;">
                <tr>
                  <td style="width:200px;">Nama</td>
                  <td>: <span id="txtPklName" contenteditable="true" style="border-bottom:1px dashed #ccc; padding:0 5px; min-width: 200px; display:inline-block;">-</span></td>
                </tr>
                <tr>
                  <td>Tempat & tgl. Lahir</td>
                  <td>: <span id="txtPklDob" contenteditable="true" style="border-bottom:1px dashed #ccc; padding:0 5px; min-width: 200px; display:inline-block;">-</span></td>
                </tr>
                <tr>
                  <td>Jabatan / Nama Kapal</td>
                  <td>: <span id="txtPklRankVessel" contenteditable="true" style="border-bottom:1px dashed #ccc; padding:0 5px; min-width: 200px; display:inline-block;">-</span></td>
                </tr>
                <tr>
                  <td>No. Passport</td>
                  <td>: <span id="txtPklPassport" contenteditable="true" style="border-bottom:1px dashed #ccc; padding:0 5px; min-width: 200px; display:inline-block;">-</span></td>
                </tr>
                <tr class="no-print">
                  <td>Vessel Name<br><span style="font-style:italic; font-size:11px;" class="text-danger">(Not printed on PDF)</span></td>
                  <td>: <input type="text" id="pkl_vessel" name="vessel" style="font-weight:700; border:none; border-bottom:1px dashed #ccc; padding:0 5px; min-width: 200px; outline:none; background:transparent; font-family: inherit;" placeholder="Enter Vessel Name"></td>
                </tr>
              </table>

              <p>Dengan ini menyatakan sebagai berikut:</p>

              <p>Masa kerja di atas kapal dengan jabatan tersebut di atas berdasarkan Perjanjian Kerja Laut (PKL) yang dibuat antara saya dan PT. Andhini Eka Karya Sejahtera (selanjutnya disebut “Perusahaan”) tanggal ……………………………….. adalah selama <span id="txtPklDuration" style="font-weight:bold; border-bottom:1px dashed #ccc; padding:0 5px; min-width: 50px; display:inline-block;" contenteditable="true"></span> Bulan. Namun saya memberi hak penuh kepada Perusahaan untuk menentukan pelabuhan tempat diturunkan (sign off) dari atas kapal dalam waktu 1 bulan sebelum atau sesudah berakhirnya masa PKL.</p>

              <p>Selama masa PKL, saya bersedia untuk tunduk dan patuh pada setiap ketentuan yang dikeluarkan oleh Perusahaan termasuk tetapi tidak terbatas: ketentuan jam kerja di atas kapal berdasarkan perundang-undangan yang berlaku disesuaikan dengan kegiatan operasional kapal yang ditetapkan oleh Nahkoda kapal dan/atau oleh Perusahaan.</p>

              <p>Saya setuju menerima gaji sebagaimana disebutkan dalam PKL dengan prosedur pembayaran sesuai ketentuan yang berlaku di Perusahaan dan perhitungan gaji dimulai sejak tanggal bekerja di atas kapal (sign on) dan akan berakhir sejak tanggal turun (sign off) dari kapal.</p>

              <p>Saya setuju menerima uang cuti (leave pay) yang besarnya ditentukan oleh Perusahaan dan pembayarannya dilakukan setelah turun dari kapal dan melaporkan diri ke Perusahaan dengan prosedur pembayaran sesuai ketentuan yang berlaku di Perusahaan.</p>

              <p>Saya bersedia dan tidak akan melakukan penuntutan di bidang keuangan ataupun lainnya, apabila Perusahaan memutuskan PKL dan/atau menurunkan (sign off) Saya dari kapal, dengan alasan sebagai berikut:<br>
                1. Secara tertulis Atasan menyatakan Saya: tidak cakap (incompetent) atau berkelakuan buruk atau lalai dalam kewajiban atau tidak patuh atau melanggar peraturan perusahaan atau tidak memiliki sertifikat yang disyaratkan;<br>
                2. Komplain tertulis dari atasan, pemilik kapal, pemilik barang, principal atau pihak ketiga lainnya berkaitan dengan tugas dan tanggung jawab Saya, yang dapat mempengaruhi usaha/bisnis Perusahaan.</p>

              <p>Saya berjanji akan mematuhi dan siap sedia dipindahkan ke kapal lain dengan dibuatkan PKL yang baru tanpa mempengaruhi masa kerja PKL ini, atas perintah atau pertimbangan Perusahaan. Apabila Saya menolak atas perintah pemindahan tersebut, maka Saya bersedia menerima konsekuensi sesuai ketentuan Perusahaan yang berlaku.</p>

              <p>Apabila Saya diturunkan dari atas kapal dan/atau diputuskan PKL karena alasan sebagaimana disebut butir 6 di atas, maka saya bersedia dan berjanji akan membayar biaya pemulangan sampai di tempat dimana Saya dipekerjakan ditambah biaya pengurusan dan pengiriman pengganti Saya.</p>

              <p>Apabila secara sepihak atas permintaan sendiri Saya mengakhiri masa PKL, maka Saya bersedia memberikan tenggang waktu kepada Perusahaan paling sedikit satu (1) bulan:<br>
                - Bila masa kerja kurang dari 3 bulan → saya bersedia membayar biaya pemulangan + pengganti.<br>
                - Bila masa kerja lebih dari 3 bulan namun belum selesai PKL → saya bersedia membayar biaya pemulangan.
              </p>

              <p>Demikian pernyataan ini dibuat dalam keadaan sadar tanpa paksaan dari pihak manapun dengan disaksikan saksi-saksi di bawah ini.</p>

              <br><br>

              <table style="width:100%; margin-top:20px; font-size:14px;">
                <tr>
                  <td style="width:50%; text-align:center;">
                    Saksi I<br><br><br><br><br>
                    (...............................)
                  </td>
                  <td style="width:50%; text-align:center;">
                    Jakarta, <span id="txtPklDate" style="font-weight:700; border-bottom:1px dashed #ccc; padding:0 5px; min-width: 150px; display:inline-block;" contenteditable="true"></span><br>
                    Yang membuat pernyataan<br><br><br><br>
                    (<span id="txtPklSignName">&lt;&lt;Nama Crew&gt;&gt;</span>)
                  </td>
                </tr>
                <tr>
                  <td style="text-align:center;">
                    Saksi II<br><br><br><br><br>
                    (...............................)
                  </td>
                  <td style="text-align:center;">
                    Meterai 10000
                  </td>
                </tr>
              </table>

              <hr style="margin:35px 0;">

              <h3 style="text-align:center; margin-bottom:20px; text-decoration:underline; font-weight:bold;">
                DAFTAR PELANGGARAN & TINDAKAN DISIPLIN
              </h3>

              <table style="width:100%; border-collapse:collapse; font-size:14px;">
                <tr>
                  <td style="width:60%; vertical-align:top; padding:10px; border:1px solid #000; font-weight:bold;">
                    Pelanggaran Hukum:
                  </td>
                  <td style="width:40%; vertical-align:top; padding:10px; border:1px solid #000; font-weight:bold; text-align:center;">
                    Tindakan Disiplin
                  </td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Pelanggaran undang-undang Republik Indonesia, Negara Bendera Kapal atau Negara Pelabuhan di mana Kapal berada mengenai penyelundupan barang-barang, memiliki bahan porno, menggunakan atau menjual-belikan obat bius atau menjual-belikan senjata api, atau melanggar setiap undang-undang yang menyebabkan keterlambatan Kapal.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">Pemecatan</td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Pernyataan tidak benar kepada pejabat bea cukai.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">
                    Pelanggaran Pertama: Peringatan<br>
                    Pelanggaran Kedua: Pemecatan
                  </td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Pelanggaran undang-undang yang sifatnya ringan.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">Sesuai Kebijaksanaan Nakhoda</td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Desersi: meninggalkan tugas atau menghasut orang lain meninggalkan tugas.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">Pemecatan</td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Lalai dalam tugas jaga sehingga mengakibatkan kapal tidak layak laut.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">Pemecatan</td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Meninggalkan waktu tugas jaga tanpa pengganti yang diberi kuasa oleh Kepala Bagian, tidur selama tugas jaga, atau berjaga di bawah pengaruh alkohol atau obat bius.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">Pemecatan</td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Meninggalkan kapal tanpa izin Nakhoda atau Kepala Bagian.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">Pemecatan</td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Menolak bekerja lembur sebagaimana diinstruksikan oleh Kepala Bagian atau wakilnya, kecuali alasan sakit yang diterima baik oleh Kepala atau wakil Kepala Bagian.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">Pemecatan</td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Ketidakmampuan untuk berjaga disebabkan mabuk.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">
                    Pelanggaran Pertama: Peringatan<br>
                    Pelanggaran Kedua: Pemecatan
                  </td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Menolak untuk mentaati perintah sah dari atasan, atau menghasut orang lain untuk melakukan hal tersebut.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">Pemecatan</td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Memukul atau berusaha memukul rekan pelaut atau menghasut orang lain untuk melakukan hal tersebut.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">Pemecatan</td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Berkelakuan tidak patuh pada atasan atau menghasut orang lain untuk berkelakuan tidak patuh.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">Pemecatan</td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Membawa seorang tamu ke kapal tanpa izin Nakhoda. Bagi yang bertugas jaga (Jurumudi/Duty Officer), tidak mengidentifikasi setiap orang yang berkunjung ke kapal.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">Pemecatan</td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Ketinggalan kapal atau tidak kembali ke kapal sebagaimana diperintahkan oleh Nakhoda atau wakilnya.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">Pemecatan</td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Setiap pelanggaran atas aturan-aturan dalam lampiran yang mengakibatkan keterlambatan kapal.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">Pemecatan</td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Pencurian atau percobaan pencurian, merusak dengan sengaja, atau menimbulkan kerusakan pada harta perusahaan atau orang lain.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">Pemecatan</td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Tidak memenuhi kewajiban sesuai jabatannya yang mengakibatkan kerusakan atau cedera pada kapal, anak buah, penumpang, atau muatan.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">Kebijaksanaan Perusahaan</td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Perbuatan melanggar peraturan atau tindakan yang merusak nama baik kapal atau perusahaan baik di kapal maupun di darat.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">
                    Pelanggaran Pertama: Peringatan<br>
                    Pelanggaran Kedua: Pemecatan
                  </td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Tidak mampu dan/atau tidak sesuai dengan standar perusahaan dalam melaksanakan tugas jabatan atau perintah yang diberikan oleh atasan.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">Pemecatan</td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Dengan sengaja membuat pernyataan atau laporan yang tidak benar untuk keuntungan pribadi atau orang lain.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">Pemecatan</td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Penggelapan atau penggunaan tidak benar dana perusahaan atau barang-barang kapal.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">Pemecatan</td>
                </tr>
                <tr>
                  <td style="padding:10px; border:1px solid #000;">
                    Menyerang atau mencoba menyerang atasan dengan kata-kata dan/atau perbuatan.
                  </td>
                  <td style="padding:10px; border:1px solid #000; text-align:center;">Pemecatan</td>
                </tr>
              </table>
          </form>
      </div>

      <div class="modal-footer bg-light" style="justify-content:flex-end;">
          <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal" style="font-family: 'Times New Roman', Times, serif;">Tutup</button>
          <button type="button" class="btn btn-sm btn-primary px-4" id="btnSubmitPklAttachment" style="font-family: 'Times New Roman', Times, serif;"> <i class="fa fa-save"></i> Save & Print</button>
          <button type="button" class="btn btn-sm btn-primary px-4 d-none" id="btnGeneratePdfFromModalPkl" style="font-family: 'Times New Roman', Times, serif;"> <i class="fa fa-print"></i> Print</button>
      </div>

    </div>
  </div>
</div>

<!-- Hidden form for PDF generation -->
<form id="formPdfPklAttachment" method="POST" target="_blank" action="<?php echo base_url('ListReport/PKLAttachment/pkl_attachment_pdf'); ?>" style="display:none;">
    <input type="hidden" name="idperson" id="pdf_pkl_idperson">
    <input type="hidden" name="pdf_pkl_name" id="pdf_pkl_name">
    <input type="hidden" name="pdf_pkl_dob" id="pdf_pkl_dob">
    <input type="hidden" name="pdf_pkl_rank_vessel" id="pdf_pkl_rank_vessel">
    <input type="hidden" name="pdf_pkl_passport" id="pdf_pkl_passport">
    <input type="hidden" name="pdf_pkl_duration" id="pdf_pkl_duration">
    <input type="hidden" name="pdf_pkl_date" id="pdf_pkl_date">
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
    var BASE_URL_PKL = '<?php echo base_url("ListReport/PKLAttachment"); ?>';
    var idperson = $('#contentArea').data('idperson');

    if (!idperson) {
        console.error('ID Person tidak ditemukan');
        return;
    }

    var pklTable = $('#pklAttachmentTable').DataTable({
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
            data: function(d) { d.idperson = idperson; },
            dataSrc: function(json) { return json.success ? json.data : []; }
        },
        columns: [
            {
                data: null, className: 'fw-bold text-center', orderable: false, searchable: false,
                render: function(data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; }
            },
            { data: 'nama_crew', className: 'text-center' },
            { data: 'rank', className: 'text-center' },
            { data: 'vessel', className: 'text-center' },
            { data: 'date_created_fmt', className: 'text-center fw-bold' },
            {
                data: null, className: 'text-center', orderable: false, searchable: false,
                render: function(data) {
                    return '<div class="btn-group btn-group-sm" role="group">' +
                        '<button type="button" class="btn btn-outline-primary btn-view-pkl" title="Print/View PDF" data-idperson="' + data.idperson + '" data-date="' + data.date_created_fmt + '" data-id="' + data.id + '">' +
                            '<i class="fa fa-eye"></i>' +
                        '</button>' +
                        '<button type="button" class="btn btn-outline-danger btn-delete-pkl" title="Delete" data-id="' + data.id + '">' +
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

    $('#pklAttachmentTable thead tr:last th').each(function(i) {
        $('input', this).on('keyup change', function() {
            if (pklTable.column(i).search() !== this.value) {
                pklTable.column(i).search(this.value).draw();
            }
        });
    });

    // ADD
    $('#btnAddPklAttachment').on('click', function() {
        $('#formAddPklAttachment')[0].reset();
        $('#pkl_idperson').val(idperson);
        $('#pkl_id').val('');
        
        $.ajax({
            url: BASE_URL_PKL + '/getStatementCrew',
            type: 'POST',
            data: { idperson: idperson },
            dataType: 'json',
            success: function(res) {
                if (res.status) {
                    var d = res.data;
                    
                    // Hidden inputs for saving
                    $('#pkl_nama_crew').val(d.fullname);
                    $('#pkl_rank').val(d.rankname);
                    $('#pkl_vessel').val(d.vesselnm);
                    $('#pkl_dob').val(d.place_of_birth + ', ' + d.date_of_birth);
                    $('#pkl_no_passport').val(d.passport_no);
                    $('#pkl_duration').val(d.duration);

                    // Preview UI
                    $('#txtPklName').text(d.fullname);
                    $('#txtPklDob').text(d.place_of_birth + ', ' + d.date_of_birth);
                    $('#txtPklRankVessel').text(d.rankname + ' / ' + d.vesselnm);
                    $('#txtPklPassport').text(d.passport_no);
                    $('#txtPklDuration').text(d.duration);
                    $('#txtPklDate').text(res.today);
                    $('#txtPklSignName').text(d.fullname);

                    $('#btnSubmitPklAttachment').removeClass('d-none').html('<i class="fa fa-save"></i> Save & Print');
                    $('#btnGeneratePdfFromModalPkl').addClass('d-none');

                    $('#modalPklAttachment').modal('show');
                } else {
                    pklNotify('warning', res.message || 'Data personal tidak ditemukan');
                }
            }
        });
    });

    // VIEW DETAIL
    $('#pklAttachmentTable').on('click', '.btn-view-pkl', function() {
        var ip = $(this).data('idperson');
        var id = $(this).data('id');
        var createdDate = $(this).data('date');

        $('#pdf_pkl_idperson').val(ip);
        $('#pkl_idperson').val(ip);
        $('#pkl_id').val(id); // Set the history ID for update

        $.ajax({
            url: BASE_URL_PKL + '/get_history_detail',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(res) {
                if (res.status) {
                    var d = res.data;
                    
                    // Hidden inputs for saving
                    $('#pkl_nama_crew').val(d.nama_crew);
                    $('#pkl_rank').val(d.rank);
                    $('#pkl_vessel').val(d.vessel);
                    $('#pkl_dob').val(d.dob);
                    $('#pkl_no_passport').val(d.no_passport);
                    $('#pkl_duration').val(d.duration);

                    // Preview UI
                    $('#txtPklName').text(d.nama_crew);
                    $('#txtPklDob').text(d.dob);
                    // Rank & Vessel combined for display. In history they are separate fields.
                    $('#txtPklRankVessel').text(d.rank + ' / ' + d.vessel);
                    $('#txtPklPassport').text(d.no_passport);
                    $('#txtPklDuration').text(d.duration);
                    $('#txtPklDate').text(createdDate); 
                    $('#txtPklSignName').text(d.nama_crew);

                    $('#btnSubmitPklAttachment').removeClass('d-none').html('<i class="fa fa-save"></i> Update & Print');
                    $('#btnGeneratePdfFromModalPkl').removeClass('d-none'); // Allow just printing without updating

                    $('#modalPklAttachment').modal('show');
                } else {
                    pklNotify('error', 'Gagal memuat detail crew.');
                }
            }
        });
    });

    // SUBMIT
    $('#btnSubmitPklAttachment').on('click', function() {
        var formData = new FormData($('#formAddPklAttachment')[0]);
        var btn = $(this);
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin ms-1"></i> Menyimpan...');

        $.ajax({
            url: BASE_URL_PKL + '/save_history',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                btn.prop('disabled', false).html('Simpan & Print');
                if (res.success) {
                    $('#modalPklAttachment').modal('hide');
                    pklTable.ajax.reload(null, false);
                    pklNotify('success', res.message);
                    
                    // Auto print PDF
                    $('#pdf_pkl_idperson').val(idperson);
                    preparePdfDataPkl();
                    $('#formPdfPklAttachment').submit();
                } else {
                    pklNotify('error', res.message);
                }
            },
            error: function() {
                btn.prop('disabled', false).html('Simpan & Print');
                pklNotify('error', 'Terjadi kesalahan sistem');
            }
        });
    });

    function preparePdfDataPkl() {
        $('#pdf_pkl_name').val($('#txtPklName').text());
        $('#pdf_pkl_dob').val($('#txtPklDob').text());
        $('#pdf_pkl_rank_vessel').val($('#txtPklRankVessel').text());
        $('#pdf_pkl_passport').val($('#txtPklPassport').text());
        $('#pdf_pkl_duration').val($('#txtPklDuration').text());
        $('#pdf_pkl_date').val($('#txtPklDate').text());
    }

    // PRINT FROM MODAL
    $('#btnGeneratePdfFromModalPkl').on('click', function() {
        preparePdfDataPkl();
        $('#formPdfPklAttachment').submit();
    });

    // DELETE
    $('#pklAttachmentTable').on('click', '.btn-delete-pkl', function() {
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
                if (result.isConfirmed) doDeletePkl(id);
            });
        } else {
            if (confirm('Yakin ingin menghapus history ini?')) {
                doDeletePkl(id);
            }
        }
    });

    function doDeletePkl(id) {
        $.ajax({
            url: BASE_URL_PKL + '/delete_history',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    pklTable.ajax.reload(null, false);
                    pklNotify('success', res.message);
                } else {
                    pklNotify('error', res.message);
                }
            }
        });
    }

    function pklNotify(type, msg) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: type, title: type === 'success' ? 'Sukses' : 'Error', text: msg,
                timer: 3000, showConfirmButton: false, toast: true, position: 'top-end'
            });
        } else {
            alert(msg);
        }
    }

    // Sync contenteditable with hidden inputs
    $('#txtPklName').on('input', function() {
        $('#pkl_nama_crew').val($(this).text());
        $('#txtPklSignName').text($(this).text());
    });
    $('#txtPklDob').on('input', function() {
        $('#pkl_dob').val($(this).text());
    });
    $('#txtPklPassport').on('input', function() {
        $('#pkl_no_passport').val($(this).text());
    });
    $('#txtPklDuration').on('input', function() {
        $('#pkl_duration').val($(this).text());
    });

});
</script>