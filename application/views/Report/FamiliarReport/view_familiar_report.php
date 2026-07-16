<!-- ============================================================
     Familiarization Report Module View
     Features: DataTables, Add/Edit Multiple Crew, View, Delete
     ============================================================ -->

<div class="card shadow-sm border-0" id="familiarModuleWrapper">
    <div class="card-body">
        <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-primary btn-sm" id="btnAddFamiliar" style="background-color: #000999; border-color: #000999;">
                <i class="fa fa-plus me-1"></i> Add Familiarization (Multiple)
            </button>
        </div>
        <div class="table-responsive">
            <table id="familiarTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                    <tr>
                        <th class="text-center" style="width:50px;">No</th>
                        <th class="text-center">Date Input</th>
                        <th class="text-center">Note</th>
                        <th class="text-center" style="width:110px;">Total Crew</th>
                        <th class="text-center" style="width:150px;">Action</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th></th>
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
     MODAL: Add / Edit Familiarization (Multiple)
     ============================================================ -->
<div class="modal fade" id="modalAddFamiliar" tabindex="-1" aria-labelledby="modalAddFamiliarLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <form id="formAddFamiliar" class="modal-content border-0 shadow">
            <input type="hidden" name="batch_id" id="fam_batch_id">
            <!-- Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, #000099 0%, #1a237e 100%); color: #fff;">
                <h6 class="modal-title fw-bold" id="modalAddFamiliarLabel">
                    <i class="fa fa-file-text-o me-2"></i>Form Familiarization
                </h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Body -->
            <div class="modal-body bg-light" style="padding:30px 40px; font-family:'Times New Roman', serif; font-size:13px;">
                
                <h6 class="fw-bold mb-3" style="color: #000099; border-bottom: 2px solid #e8eaf6; padding-bottom: 10px;">
                    <i class="fa fa-users me-2"></i>Daftar Crew
                </h6>
                
                <div class="row mb-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label fw-bold">Cari Crew</label>
                        <select class="form-control" id="searchCrewSelect"></select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-success btn-sm w-100 mt-2" id="btnAddToCrewList" style="height: 36px;">
                            <i class="fa fa-plus me-1"></i> Add to List
                        </button>
                    </div>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-sm align-middle bg-white" id="tblAddCrewList">
                        <thead style="background-color: #e8eaf6;">
                            <tr>
                                <th class="text-center" style="width:40px;">No</th>
                                <th>Name</th>
                                <th>Rank</th>
                                <th>Vessel Name</th>
                                <th>Sign On Date</th>
                                <th class="text-center" style="width:50px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dynamic rows via JS -->
                        </tbody>
                    </table>
                </div>

                <h6 class="fw-bold mb-3 mt-4" style="color: #000099; border-bottom: 2px solid #e8eaf6; padding-bottom: 10px;">
                    <i class="fa fa-check-square-o me-2"></i>Checklist Familiarization
                </h6>

                <table class="table table-bordered table-sm bg-white align-middle" style="font-size: 13px;">
                    <thead style="background-color: #e8eaf6;">
                        <tr>
                            <th class="text-center" style="width:40px;">No</th>
                            <th>Topics</th>
                            <th class="text-center" style="width:180px;">Department</th>
                            <th class="text-center" style="width:120px;">Yes / No</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- ITEM 1 -->
                        <tr>
                            <td class="text-center">1</td>
                            <td>Procedures Related Crewing (Payroll, Working Hours, etc)</td>
                            <td class="text-center">Crewing</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input fam-radio" type="radio" name="item_1" id="item_1_y" value="1">
                                    <label class="form-check-label text-success fw-bold">✓</label>
                                </div>
                                <div class="form-check form-check-inline mb-0">
                                    <input class="form-check-input fam-radio" type="radio" name="item_1" id="item_1_n" value="0">
                                    <label class="form-check-label text-danger fw-bold">✗</label>
                                </div>
                            </td>
                        </tr>
                        <tr style="background-color:#f8f9fa;"><td colspan="4" class="fw-bold">Company Policy :</td></tr>
                        <!-- ITEM 2 -->
                        <tr>
                            <td class="text-center">2</td>
                            <td>- Quality, Health, Safety and Environmental (QHSE) Policy</td>
                            <td class="text-center">QHSE</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_2" value="1"><label class="form-check-label text-success fw-bold">✓</label></div>
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_2" value="0"><label class="form-check-label text-danger fw-bold">✗</label></div>
                            </td>
                        </tr>
                        <!-- ITEM 3 -->
                        <tr>
                            <td class="text-center">3</td>
                            <td>Safety Management System Manual and Document</td>
                            <td class="text-center">DPA / Marine Safety</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_3" value="1"><label class="form-check-label text-success fw-bold">✓</label></div>
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_3" value="0"><label class="form-check-label text-danger fw-bold">✗</label></div>
                            </td>
                        </tr>
                        <!-- ITEM 4 -->
                        <tr>
                            <td class="text-center">4</td>
                            <td>Duties and Responsibility</td>
                            <td class="text-center">DPA</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_4" value="1"><label class="form-check-label text-success fw-bold">✓</label></div>
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_4" value="0"><label class="form-check-label text-danger fw-bold">✗</label></div>
                            </td>
                        </tr>
                        <!-- ITEM 5 -->
                        <tr>
                            <td class="text-center">5</td>
                            <td>Procedures Related Ship Operation</td>
                            <td class="text-center">Operation</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_5" value="1"><label class="form-check-label text-success fw-bold">✓</label></div>
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_5" value="0"><label class="form-check-label text-danger fw-bold">✗</label></div>
                            </td>
                        </tr>
                        <!-- ITEM 6 -->
                        <tr>
                            <td class="text-center">6</td>
                            <td>Procedures Related Emergency</td>
                            <td class="text-center">DPA / Marine Safety</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_6" value="1"><label class="form-check-label text-success fw-bold">✓</label></div>
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_6" value="0"><label class="form-check-label text-danger fw-bold">✗</label></div>
                            </td>
                        </tr>
                        <!-- ITEM 7 -->
                        <tr>
                            <td class="text-center" rowspan="3" style="vertical-align: middle;">7-9</td>
                            <td rowspan="3" style="vertical-align: middle;">Procedures Related Maintenance of Ship (Plan Maintenance System)</td>
                            <td class="text-center">Technical</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_7" value="1"><label class="form-check-label text-success fw-bold">✓</label></div>
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_7" value="0"><label class="form-check-label text-danger fw-bold">✗</label></div>
                            </td>
                        </tr>
                        <!-- ITEM 8 -->
                        <tr>
                            <td class="text-center">Purchasing</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_8" value="1"><label class="form-check-label text-success fw-bold">✓</label></div>
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_8" value="0"><label class="form-check-label text-danger fw-bold">✗</label></div>
                            </td>
                        </tr>
                        <!-- ITEM 9 -->
                        <tr>
                            <td class="text-center">Finance</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_9" value="1"><label class="form-check-label text-success fw-bold">✓</label></div>
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_9" value="0"><label class="form-check-label text-danger fw-bold">✗</label></div>
                            </td>
                        </tr>
                        <!-- ITEM 10 -->
                        <tr>
                            <td class="text-center">10</td>
                            <td>Procedures Related Cargo Handling</td>
                            <td class="text-center">Operation</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_10" value="1"><label class="form-check-label text-success fw-bold">✓</label></div>
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_10" value="0"><label class="form-check-label text-danger fw-bold">✗</label></div>
                            </td>
                        </tr>
                        <!-- ITEM 11 -->
                        <tr>
                            <td class="text-center">11</td>
                            <td>Safety Drill</td>
                            <td class="text-center">DPA / Marine Safety</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_11" value="1"><label class="form-check-label text-success fw-bold">✓</label></div>
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_11" value="0"><label class="form-check-label text-danger fw-bold">✗</label></div>
                            </td>
                        </tr>
                        <!-- ITEM 12 -->
                        <tr>
                            <td class="text-center">12</td>
                            <td>Procedures Related Health</td>
                            <td class="text-center">QHSE</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_12" value="1"><label class="form-check-label text-success fw-bold">✓</label></div>
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_12" value="0"><label class="form-check-label text-danger fw-bold">✗</label></div>
                            </td>
                        </tr>
                        <!-- ITEM 13 -->
                        <tr>
                            <td class="text-center">13</td>
                            <td>Procedures Related Environmental Protection</td>
                            <td class="text-center">QHSE</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_13" value="1"><label class="form-check-label text-success fw-bold">✓</label></div>
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_13" value="0"><label class="form-check-label text-danger fw-bold">✗</label></div>
                            </td>
                        </tr>
                        <!-- ITEM 14 -->
                        <tr>
                            <td class="text-center">14</td>
                            <td>Audit External / Internal</td>
                            <td class="text-center">DPA / Marine Safety</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_14" value="1"><label class="form-check-label text-success fw-bold">✓</label></div>
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_14" value="0"><label class="form-check-label text-danger fw-bold">✗</label></div>
                            </td>
                        </tr>
                        <!-- ITEM 15 -->
                        <tr>
                            <td class="text-center">15</td>
                            <td>Hazard Identification / JSA</td>
                            <td class="text-center">QHSE</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_15" value="1"><label class="form-check-label text-success fw-bold">✓</label></div>
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_15" value="0"><label class="form-check-label text-danger fw-bold">✗</label></div>
                            </td>
                        </tr>
                        <!-- ITEM 16 -->
                        <tr>
                            <td class="text-center">16</td>
                            <td>Wearing Personal Protective Equipment (PPE)</td>
                            <td class="text-center">QHSE</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_16" value="1"><label class="form-check-label text-success fw-bold">✓</label></div>
                                <div class="form-check form-check-inline mb-0"><input class="form-check-input fam-radio" type="radio" name="item_16" value="0"><label class="form-check-label text-danger fw-bold">✗</label></div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-3">
                    <label class="form-label fw-bold">Note :</label>
                    <textarea class="form-control" name="note" id="fam_note" rows="3" placeholder="Tambahkan catatan jika ada..."></textarea>
                </div>

            </div>
            <!-- Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-sm btn-primary" id="btnSubmitAddFamiliar">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<!-- ============================================================
     STYLES & JS
     ============================================================ -->
<style>
.crew-table th, .crew-table td { font-size: 12px; vertical-align: middle; }
.crew-table th { font-weight: 600; text-align: center; }
.crew-header th { background-color: #000099 !important; color: #fff !important; }
.column-search { width: 100%; padding: 4px; border: 1px solid #ced4da; border-radius: 4px; font-size: 11px; }

/* Select2 Customization */
.select2-container .select2-selection--single {
    height: 36px !important;
    border: 1px solid #ced4da !important;
    border-radius: 4px !important;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px !important;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 34px !important;
}
</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
var BASE_URL_FAM_REP = '<?= base_url('Report/FamiliarReport') ?>';
var famReportTable;

$(document).ready(function () {
    
    // 1. Inisialisasi DataTables
    famReportTable = $('#familiarTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: BASE_URL_FAM_REP + '/get_report_familiar',
            type: 'POST'
        },
        orderCellsTop: true,
        columns: [
            {
                data: null,
                className: 'text-center',
                orderable: false,
                searchable: false,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                data: 'date_created_fmt',
                className: 'text-center'
            },
            {
                data: 'note',
                render: function (data) {
                    return data ? data : '-';
                }
            },
            {
                data: 'total_crew',
                className: 'text-center',
                render: function (data) {
                    return '<span class="badge bg-info text-dark">' + data + ' Orang</span>';
                }
            },
            {
                data: null,
                className: 'text-center',
                orderable: false,
                searchable: false,
                render: function (data) {
                    return '<div class="btn-group btn-group-sm" role="group">' +
                        '<button type="button" class="btn btn-outline-info btn-view-fam" title="View / Detail" data-id="' + data.group_id + '">' +
                        '<i class="fa fa-eye"></i></button>' +
                        '<button type="button" class="btn btn-outline-primary btn-edit-fam" title="Edit / Update" data-id="' + data.group_id + '">' +
                        '<i class="fa fa-pencil"></i></button>' +
                        '<button type="button" class="btn btn-outline-danger btn-delete-fam" title="Delete Batch" data-id="' + data.group_id + '">' +
                        '<i class="fa fa-trash"></i></button>' +
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

    // 2. Select2 untuk Pencarian Crew
    $('#searchCrewSelect').select2({
        theme: 'default',
        width: '100%',
        dropdownParent: $('#modalAddFamiliar'),
        placeholder: 'Ketik nama crew...',
        allowClear: true,
        ajax: {
            url: BASE_URL_FAM_REP + '/get_crew_by_name',
            type: 'POST',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return { keyword: params.term };
            },
            processResults: function (response) {
                return {
                    results: response.success ? response.data : []
                };
            },
            cache: true
        }
    });

    // 3. Tambah Crew ke Tabel List Sementara
    $('#btnAddToCrewList').on('click', function () {
        var idperson = $('#searchCrewSelect').val();
        if (!idperson) {
            famNotify('warning', 'Pilih crew terlebih dahulu!');
            return;
        }

        // Cek apakah sudah ada di list
        var exists = false;
        $('input[name="crew_list[][id_person]"]').each(function() {
            if ($(this).val() == idperson) {
                exists = true;
            }
        });

        if (exists) {
            famNotify('warning', 'Crew sudah ada di list!');
            return;
        }

        $.ajax({
            url: BASE_URL_FAM_REP + '/get_crew_info_by_idperson',
            type: 'POST',
            data: { idperson: idperson },
            dataType: 'json',
            success: function (res) {
                if (res.success && res.data) {
                    appendCrewRow(res.data.nama_crew, res.data.jabatan, res.data.vessel_name, res.data.signon_date, idperson);
                    $('#searchCrewSelect').val(null).trigger('change');
                } else {
                    famNotify('error', 'Gagal memuat detail crew');
                }
            }
        });
    });

    function appendCrewRow(name, rank, vessel, signon, idperson) {
        var tr = '<tr>' +
            '<td class="text-center row-num" style="vertical-align: middle;"></td>' +
            '<td style="vertical-align: middle;"><input type="hidden" name="crew_list[][id_person]" value="'+idperson+'"><input type="hidden" name="crew_list[][name_crew]" value="'+(name||'')+'">' + (name||'-') + '</td>' +
            '<td><input type="text" class="form-control form-control-sm" name="crew_list[][jabatan]" value="'+(rank||'')+'"></td>' +
            '<td><input type="text" class="form-control form-control-sm" name="crew_list[][vessel_name]" value="'+(vessel||'')+'"></td>' +
            '<td><input type="date" class="form-control form-control-sm" name="crew_list[][signon_date]" value="'+(signon||'')+'"></td>' +
            '<td class="text-center" style="vertical-align: middle;"><button type="button" class="btn btn-sm btn-danger btn-remove-crew"><i class="fa fa-times"></i></button></td>' +
        '</tr>';
        $('#tblAddCrewList tbody').append(tr);
        reindexCrewRow();
    }

    function reindexCrewRow() {
        $('#tblAddCrewList tbody tr').each(function(index) {
            $(this).find('.row-num').text(index + 1);
            
            // Re-index names to assure proper array submission
            $(this).find('input[type="hidden"], input[type="text"], input[type="date"]').each(function() {
                var nameAttr = $(this).attr('name');
                if(nameAttr) {
                    var newName = nameAttr.replace(/\[\d*\]/, '[' + index + ']');
                    $(this).attr('name', newName);
                }
            });
        });
    }

    $('#tblAddCrewList').on('click', '.btn-remove-crew', function() {
        $(this).closest('tr').remove();
        reindexCrewRow();
    });

    // 4. Reset & Mode Toggle Modal
    function resetFormModal() {
        $('#formAddFamiliar')[0].reset();
        $('#fam_batch_id').val('');
        $('#tblAddCrewList tbody').empty();
        $('#searchCrewSelect').val(null).trigger('change');
        
        // Mode input (Edit/Add)
        $('#formAddFamiliar input, #formAddFamiliar textarea, #formAddFamiliar button').prop('disabled', false);
        $('#btnSubmitAddFamiliar').show();
        $('.btn-remove-crew, #btnAddToCrewList, #searchCrewSelect').show();
    }

    function disableFormForView() {
        $('#formAddFamiliar input, #formAddFamiliar textarea').prop('disabled', true);
        $('#btnSubmitAddFamiliar').hide();
        $('.btn-remove-crew, #btnAddToCrewList').hide();
        $('#searchCrewSelect').prop('disabled', true);
    }

    function fillRadioChecklist(masterData) {
        for(var i=1; i<=16; i++) {
            var val = masterData['item_'+i];
            if(val !== null && val !== undefined && val !== '') {
                $('input[name="item_'+i+'"][value="'+val+'"]').prop('checked', true);
            }
        }
    }

    // 5. Button Action: ADD Baru
    $('#btnAddFamiliar').on('click', function () {
        resetFormModal();
        $('#modalAddFamiliarLabel').html('<i class="fa fa-plus-circle me-2"></i>Tambah Familiarization Baru');
        $('#modalAddFamiliar').modal('show');
    });

    // 6. Button Action: EDIT / UPDATE
    $('#familiarTable').on('click', '.btn-edit-fam', function () {
        var group_id = $(this).data('id');
        resetFormModal();
        $('#modalAddFamiliarLabel').html('<i class="fa fa-pencil-square-o me-2"></i>Update Familiarization (Batch: '+group_id+')');
        
        $.ajax({
            url: BASE_URL_FAM_REP + '/get_report_familiar_detail',
            type: 'POST',
            data: { group_id: group_id },
            dataType: 'json',
            success: function(res) {
                if(res.success) {
                    var m = res.data.master;
                    var cList = res.data.crew_list;

                    $('#fam_batch_id').val(group_id);
                    $('#fam_note').val(m.note);
                    fillRadioChecklist(m);

                    $.each(cList, function(i, c) {
                        appendCrewRow(c.name_crew, c.jabatan, c.vessel_name, c.signon_date, c.id_person);
                    });

                    $('#modalAddFamiliar').modal('show');
                } else {
                    famNotify('error', res.message);
                }
            }
        });
    });

    // 7. Button Action: VIEW DETAIL
    $('#familiarTable').on('click', '.btn-view-fam', function () {
        var group_id = $(this).data('id');
        resetFormModal();
        $('#modalAddFamiliarLabel').html('<i class="fa fa-eye me-2"></i>Detail Familiarization (Batch: '+group_id+')');
        
        $.ajax({
            url: BASE_URL_FAM_REP + '/get_report_familiar_detail',
            type: 'POST',
            data: { group_id: group_id },
            dataType: 'json',
            success: function(res) {
                if(res.success) {
                    var m = res.data.master;
                    var cList = res.data.crew_list;

                    $('#fam_batch_id').val(group_id);
                    $('#fam_note').val(m.note);
                    fillRadioChecklist(m);

                    $.each(cList, function(i, c) {
                        appendCrewRow(c.name_crew, c.jabatan, c.vessel_name, c.signon_date, c.id_person);
                    });

                    disableFormForView();
                    $('#modalAddFamiliar').modal('show');
                } else {
                    famNotify('error', res.message);
                }
            }
        });
    });

    // 8. Submit Form (Create / Update)
    $('#formAddFamiliar').on('submit', function (e) {
        e.preventDefault();
        
        if($('#tblAddCrewList tbody tr').length === 0) {
            famNotify('warning', 'Minimal tambahkan 1 crew ke dalam daftar!');
            return;
        }

        var btn = $('#btnSubmitAddFamiliar');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin ms-1"></i> Menyimpan...');

        var formData = new FormData(this);

        $.ajax({
            url: BASE_URL_FAM_REP + '/submit_report_familiar',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (res) {
                btn.prop('disabled', false).html('Simpan Data');
                if (res.success) {
                    $('#modalAddFamiliar').modal('hide');
                    famReportTable.ajax.reload(null, false);
                    famNotify('success', res.message);
                } else {
                    famNotify('error', res.message);
                }
            },
            error: function () {
                btn.prop('disabled', false).html('Simpan Data');
                famNotify('error', 'Terjadi kesalahan sistem');
            }
        });
    });

    // 9. DELETE BATCH
    $('#familiarTable').on('click', '.btn-delete-fam', function () {
        var id = $(this).data('id');
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Hapus Batch Familiarization?',
                text: 'Data seluruh crew dalam batch ini akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus Batch'
            }).then(function (result) {
                if (result.isConfirmed) doDeleteFam(id);
            });
        } else {
            if (confirm('Yakin ingin menghapus seluruh history pada batch ini?')) {
                doDeleteFam(id);
            }
        }
    });

    function doDeleteFam(id) {
        $.ajax({
            url: BASE_URL_FAM_REP + '/delete_list_familiar',
            type: 'POST',
            data: { group_id: id },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    famReportTable.ajax.reload(null, false);
                    famNotify('success', res.message);
                } else {
                    famNotify('error', res.message);
                }
            }
        });
    }

    function famNotify(type, msg) {
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
