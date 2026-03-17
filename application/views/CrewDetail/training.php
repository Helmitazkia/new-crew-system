<div class="content-traning">
  <div class="row">
    <!-- =========================
     LEFT : ASSESSMENT & TRAINING
     ========================= -->
    <div class="col-4 mb-4">
      <div class="card shadow-sm h-100">

        <div class="card-header d-flex justify-content-between align-items-center">
          <span class="fw-semibold fst-italic">📋 Assessment & Training</span>

          <div class="action-btn">
            <button class="btn btn-sm btn-outline-primary btn-edit">
              <i class="fa fa-edit"></i> Edit
            </button>
            <button class="btn btn-sm btn-success btn-save d-none">
              <i class="fa fa-save"></i> Save
            </button>
            <button class="btn btn-sm btn-secondary btn-cancel d-none">
              Cancel
            </button>
          </div>
        </div>

        <div class="card-body small">
          <div
            class="alert alert-success d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
            role="alert" id="training-success-alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
              <use xlink:href="#check-circle-fill" />
            </svg>
            <div class="flex-grow-1">
              <span id="training-success-message"></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <div
            class="alert alert-danger  d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
            role="alert" id="training-danger-alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
              <use xlink:href="#exclamation-triangle-fill" />
            </svg>
            <div class="flex-grow-1">
              <span id="training-error-message"></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <div class="row g-2">
            <div class="col-md-6">
              <label class="form-label mb-0 fst-italic fw-semibold">CES Score</label>
              <div class="form-view fst-italic" data-field="scorces"></div>
              <input type="number" name="txtCesScore" id="txtCesScore" maxlength="20" class="form-control form-edit d-none" data-field="scorces" placeholder="">
            </div>

            <div class="col-md-6">
              <label class="form-label mb-0 fst-italic fw-semibold">Marlin Test Score</label>
              <div class="form-view fst-italic" data-field="scormarlintes"></div>
              <input type="text" name="txtmarlinTest" id="txtmarlinTest" maxlength="20" class="form-control form-edit d-none" data-field="scormarlintes" placeholder="">
            </div>

            <div class="col-md-6">
              <label class="form-label mb-0 fst-italic fw-semibold">Psychometric Score</label>
              <div class="form-view fst-italic" data-field="scor_psychometric"></div>
              <input type="text" name="scor_psychometric" id="scor_psychometric" maxlength="20" class="form-control form-edit d-none" data-field="scor_psychometric" placeholder="">
            </div>

            <div class="col-md-6">
              <label class="form-label mb-0 fst-italic fw-semibold">OTG Score</label>
              <div class="form-view fst-italic" data-field="scor_otg"></div>
              <input type="number" name="scor_otg" id="scor_otg" maxlength="20" class="form-control form-edit d-none" data-field="scor_otg" placeholder="">
            </div>

            <div class="col-md-6">
              <label class="form-label mb-0 fst-italic fw-semibold">Last Training Date</label>
              <div class="form-view fst-italic" data-field="ismdate"></div>
              <input type="date" name="txtDate_training" id="txtDate_training" class="form-control form-edit d-none" data-field="ismdate">
            </div>

            <div class="col-md-6">
              <label class="form-label mb-0 fst-italic fw-semibold">Evaluation</label>
              <div class="form-view fst-italic" data-field="ismeval"></div>
              <input type="text" name="txtEvaluation" id="txtEvaluation" maxlength="20" class="form-control form-edit d-none" data-field="ismeval" placeholder="">
            </div>
          </div>
        </div>
      </div>
    </div>



    <!-- =========================
     RIGHT : TRAINING LIST (DataTable)
     ========================= -->
    <div class="col-8 mb-4">
      <div class="card shadow-sm h-100">
        <div class="card-header d-flex justify-content-between align-items-center py-2">
          <span class="fw-semibold fst-italic">📚 Training List</span>
          <button type="button" class="btn btn-primary btn-sm rounded-pill fst-italic" id="btnNewTrainingMatrix"><i class="fa fa-plus"></i> New</button>
        </div>
        <div class="card-body p-2">
          <div class="table-responsive">
            <table id="trainingMatrixTable" class="table table-sm table-bordered mb-0" style="width:100%">
              <thead>
                <tr>
                  <th style="width:10%; background-color:#000099; color:#FFFFFF;font-size:12px;" class="text-center">No</th>
                  <th style="width:70%; background-color:#000099; color:#FFFFFF;font-size:12px;" class="text-center">Training Name</th>
                  <th style="width:10%; background-color:#000099; color:#FFFFFF;font-size:12px;" class="text-center">Completed</th>
                  <th style="width:20%; background-color:#000099; color:#FFFFFF;font-size:12px;" class="text-center">Action</th>
                </tr>
              </thead>
              <tbody style="font-size:13px;">
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- =========================
   ROW 2 : LIST TRAINING CREW (CRUD)
   ========================= -->
  <div class="row mt-2">
    <div class="col-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="table-responsive">
            <table id="crewTrainingTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
              <thead class="crew-header">
                <tr>
                  <th class="text-center">No</th>
                  <th>Name</th>
                  <th>Rank</th>
                  <th>Vessel</th>
                  <th class="text-center">Total Training</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Finish Date</th>
                  <th>Status</th>
                  <th>Remarks</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <thead>
                <tr>
                  <th></th>
                  <th><input type="text" class="column-search form-control form-control-sm" placeholder="Search"></th>
                  <th><input type="text" class="column-search form-control form-control-sm" placeholder="Search"></th>
                  <th><input type="text" class="column-search form-control form-control-sm" placeholder="Search"></th>
                  <th><input type="text" class="column-search form-control form-control-sm" placeholder="Search"></th>
                  <th><input type="text" class="column-search form-control form-control-sm" placeholder="Search"></th>
                  <th><input type="text" class="column-search form-control form-control-sm" placeholder="Search"></th>
                  <th><input type="text" class="column-search form-control form-control-sm" placeholder="Search"></th>
                  <th><input type="text" class="column-search form-control form-control-sm" placeholder="Search"></th>
                  <th><input type="text" class="column-search form-control form-control-sm" placeholder="Search"></th>
                  <th></th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Add/Edit List Training Crew -->
<div class="modal fade" id="crewTrainingModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#000099;">
        <h5 class="modal-title" id="crewTrainingModalTitle">Add Training</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="crewTrainingForm">
          <input type="hidden" name="idcrewtraining" id="idcrewtraining">
          <input type="hidden" name="idperson" id="idperson_crewtraining">
          <div class="row">
            <div class="col-md-6 mb-2">
              <label>Rank <span class="text-danger">*</span></label>
              <select name="rank" id="rank_crewtraining" class="form-control" data-live-search="true" data-size="5"></select>
              <small id="rank_crewtraining_fb" class="text-danger d-none">Rank is required</small>
            </div>
            <div class="col-md-6 mb-2">
              <label>Vessel <span class="text-danger">*</span></label>
              <select name="kdvsl" id="kdvsl_crewtraining" class="form-control" data-live-search="true" data-size="5"></select>
              <small id="kdvsl_crewtraining_fb" class="text-danger d-none">Vessel is required</small>
            </div>
            <div class="col-md-4 mb-2">
              <label>Total Training <span class="text-danger">*</span></label>
              <input type="number" name="total_training" id="total_training" class="form-control" min="0" placeholder="0">
              <small id="total_training_fb" class="text-danger d-none">Total Training is required</small>
            </div>
            <div class="col-md-4 mb-2">
              <label>Start Date <span class="text-danger">*</span></label>
              <input type="date" name="start_date_training" id="start_date_training" class="form-control">
              <small id="start_date_training_fb" class="text-danger d-none">Start Date is required</small>
            </div>
            <div class="col-md-4 mb-2">
              <label>End Date</label>
              <input type="date" name="end_date_training" id="end_date_training" class="form-control">
            </div>
            <div class="col-md-4 mb-2">
              <label>Finish Date</label>
              <input type="date" name="finish_date_training" id="finish_date_training" class="form-control">
            </div>
            <div class="col-md-4 mb-2">
              <label>Status <span class="text-danger">*</span></label>
              <select name="status" id="status_crewtraining" class="form-control">
                <option value="">- Select -</option>
                <option value="Done">Done</option>
                <option value="Process">Process</option>
                <option value="Failed">Failed</option>
                <option value="Expired">Expired</option>
              </select>
              <small id="status_crewtraining_fb" class="text-danger d-none">Status is required</small>
            </div>
            <div class="col-md-12 mb-2">
              <label>Remarks</label>
              <textarea name="remarks" id="remarks_crewtraining" class="form-control" rows="2" maxlength="500"></textarea>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="btnSaveCrewTraining">Save</button>
        <button type="button" class="btn btn-warning d-none" id="btnUpdateCrewTraining">Update</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Add/Edit Training List (Matrix) -->
<div class="modal fade" id="trainingMatrixModal" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#000099;">
        <h5 class="modal-title" id="trainingMatrixModalTitle">Add List Training</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="trainingMatrixForm">
          <input type="hidden" name="idcrewtraining_matrix" id="idcrewtraining_matrix">
          <input type="hidden" name="idperson" id="idperson_matrix" value="">
          <div class="mb-2">
            <label class="form-label mb-0 fst-italic fw-semibold">Training Name <span class="text-danger">*</span></label>
            <select name="cert_matrix_id" id="cert_matrix_id" class="form-control selectpicker" data-live-search="true" data-size="8"></select>
            <small id="cert_matrix_id_fb" class="text-danger d-none">Training Name is required</small>
          </div>
          <div class="mb-2 form-check">
            <input type="checkbox" class="form-check-input" id="completed_matrix" name="completed" value="1">
            <label class="form-check-label" for="completed_matrix">Completed</label>
          </div>
          <div class="mb-2">
            <label class="form-label mb-0 fst-italic fw-semibold">Remarks</label>
            <textarea name="remarks" id="remarks_matrix" class="form-control" rows="2" maxlength="500"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="btnSaveTrainingMatrix">Save</button>
        <button type="button" class="btn btn-warning d-none" id="btnUpdateTrainingMatrix">Update</button>
      </div>
    </div>
  </div>
</div>

<style>
  .crew-table th, .crew-table td { font-size: 12px; vertical-align: middle; }
  .crew-table th { font-weight: 600; }
  .crew-header th { background-color: #000099 !important; color: #fff !important; }
  .column-search { width: 100%; padding: 6px 8px; font-size: 12px; border: 1px solid #dee2e6; border-radius: 4px; background: #f8f9fa; }
  #trainingListCollapse.collapsing, #trainingListCollapse.show { transition: height 0.35s ease; }
</style>

<script>
  var baseUrlTraining = "<?php echo base_url('CrewDetail/Traning'); ?>";
  var alert_success = $('#training-success-alert');
  var alert_error = $('#training-danger-alert');
  var success_message = $('#training-success-message');
  var error_message = $('#training-error-message');
  var optionsRankCrewTraining = <?php echo isset($optionsRankJson) ? $optionsRankJson : '[]'; ?>;
  var optionsVesselCrewTraining = <?php echo isset($optionsVesselJson) ? $optionsVesselJson : '[]'; ?>;
  var optionsCertificateMatrix = <?php echo isset($optionsCertificateMatrixJson) ? $optionsCertificateMatrixJson : '[]'; ?>;

  function loadTrainingData() {
    var idperson = $('#contentArea').data('idperson');
    if (!idperson) return;
    $.ajax({
      url: baseUrlTraining + '/get_training',
      type: 'GET',
      data: { idperson: idperson },
      dataType: 'json',
      success: function (res) {
        if (!res.success || !res.data) return;
        var d = res.data;
        var fields = ['scorces', 'scormarlintes', 'scor_psychometric', 'scor_otg', 'ismdate', 'ismeval'];
        fields.forEach(function (key) {
          var val = (d[key] != null && d[key] !== '') ? d[key] : '';
          $('.form-view[data-field="' + key + '"]').text(val);
          var $edit = $('.form-edit[data-field="' + key + '"]');
          if ($edit.is('select')) $edit.val(val); else $edit.val(val);
        });
      }
    });
  }

  $(document).on('click', '.btn-edit', function () {
    var card = $(this).closest('.card');
    card.find('.form-view').addClass('d-none');
    card.find('.form-edit').removeClass('d-none');
    card.find('.btn-edit').addClass('d-none');
    card.find('.btn-save, .btn-cancel').removeClass('d-none');
  });

  $(document).on('click', '.btn-cancel', function () {
    var card = $(this).closest('.card');
    card.find('.form-view').removeClass('d-none');
    card.find('.form-edit').addClass('d-none');
    card.find('.btn-edit').removeClass('d-none');
    card.find('.btn-save, .btn-cancel').addClass('d-none');
  });

  $(document).on('click', '.btn-save', function () {
    var idperson = $('#contentArea').data('idperson');
    if (!idperson) {
      error_message.text('idperson not found. Open this tab from Crew Detail.');
      alert_error.removeClass('d-none');  
      return;
    }
    var card = $(this).closest('.card');
    var data = {
      idperson: idperson,
      txtCesScore: $('#txtCesScore').val(),
      txtmarlinTest: $('#txtmarlinTest').val(),
      txtEvaluation: $('#txtEvaluation').val(),
      txtDate_training: $('#txtDate_training').val(),
      scor_psychometric: $('#scor_psychometric').val(),
      scor_otg: $('#scor_otg').val()
    };
    $.ajax({
      url: baseUrlTraining + '/save_training',
      type: 'POST',
      data: data,
      dataType: 'json',
      success: function (res) {
        if (res.success) {
          var fields = ['scorces', 'scormarlintes', 'scor_psychometric', 'scor_otg', 'ismdate', 'ismeval'];
          fields.forEach(function (key) {
            var $edit = $('.form-edit[data-field="' + key + '"]');
            var val = $edit.is('select') ? $edit.val() : $edit.val();
            $('.form-view[data-field="' + key + '"]').text(val || '');
          });
          card.find('.form-view').removeClass('d-none');
          card.find('.form-edit').addClass('d-none');
          card.find('.btn-edit').removeClass('d-none');
          card.find('.btn-save, .btn-cancel').addClass('d-none');
          if (typeof alert_success !== 'undefined') {
            success_message.text(res.message);
            alert_success.removeClass('d-none');
            setTimeout(function () { alert_success.addClass('d-none'); }, 2000);
          } else {
            error_message.text(res.message || 'Save failed.');
            alert_error.removeClass('d-none');
          }
        } else {
          error_message.text(res.message || 'Save failed.');
          alert_error.removeClass('d-none');
          setTimeout(function () { alert_error.addClass('d-none'); }, 2000);
        }
      },
      error: function () {
        error_message.text('Request failed.');
        alert_error.removeClass('d-none');
        setTimeout(function () { alert_error.addClass('d-none'); }, 2000);
      }
    });
  });

  function fmtDate(val) {
    if (!val || val === '0000-00-00' || val === '') return '-';
    var d = new Date(val);
    if (isNaN(d.getTime())) return val;
    return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
  }

  $(document).ready(function () {
    loadTrainingData();

    var idperson = $('#contentArea').data('idperson');
    if (!idperson) return;

    $('#idperson_crewtraining').val(idperson);

    // Rank & Vessel: single select only, init once (destroy first to avoid duplicate/overlap)
    var $rankSelect = $('#rank_crewtraining');
    if ($rankSelect.data('selectpicker')) { try { $rankSelect.selectpicker('destroy'); } catch (e) {} }
    $rankSelect.empty().append(optionsRankCrewTraining.map(function (o) { return $('<option></option>').val(o.value).text(o.text)[0]; }));
    $rankSelect.selectpicker({ noneSelectedText: '- Select -', liveSearch: true, size: 5 });

    var $vslSelect = $('#kdvsl_crewtraining');
    if ($vslSelect.data('selectpicker')) { try { $vslSelect.selectpicker('destroy'); } catch (e) {} }
    $vslSelect.empty().append(optionsVesselCrewTraining.map(function (o) { return $('<option></option>').val(o.value).text(o.text)[0]; }));
    $vslSelect.selectpicker({ noneSelectedText: '- Select -', liveSearch: true, size: 5 });

    var crewTrainingTable = $('#crewTrainingTable').DataTable({
      dom: "<'row mb-2'<'col-md-6 d-flex align-items-center'l><'col-md-6 text-end crew-training-btn'>>" +
           "<'row'<'col-md-12'tr>>" +
           "<'row mt-2'<'col-md-6'i><'col-md-6 d-flex justify-content-end'p>>",
      processing: true,
      serverSide: false,
      searching: true,
      paging: true,
      pageLength: 10,
      lengthMenu: [10, 25, 50, 100],
      ajax: {
        url: baseUrlTraining + '/getAllData_crewtraining',
        type: 'GET',
        data: { idperson: idperson },
        dataSrc: function (json) {
          if (json.success) return json.data;
          return [];
        }
      },
      columns: [
        { data: null, className: 'text-center', orderable: false, render: function (data, type, row, meta) { return meta.row + 1; } },
        { data: 'name' },
        { data: 'rank_display' },
        { data: 'vessel' },
        { data: 'total_training', className: 'text-center', render: function (v) { return v != null && v !== '' ? v : '-'; } },
        { data: 'start_date_training', render: function (d) { return fmtDate(d); } },
        { data: 'end_date_training', render: function (d) { return fmtDate(d); } },
        { data: 'finish_date_training', render: function (d) { return fmtDate(d); } },
        { data: 'status'  , className: 'text-center', render: function (data) { if (data === 'Done') return '<span class="badge bg-success">Done</span>'; else if (data === 'Process') return '<span class="badge bg-warning text-dark">Process</span>'; else if (data === 'Failed') return '<span class="badge bg-danger">Failed</span>'; else if (data === 'Expired') return '<span class="badge bg-warning text-dark">Expired</span>'; } },
        { data: 'remarks', render: function (v) { return v || '-'; } },
        {
          data: null,
          orderable: false,
          searchable: false,
          className: 'text-center',
          render: function (data, type, row) {
            return '<button type="button" class="btn btn-sm btn-outline-primary btn-edit-crewtraining" data-id="' + row.idcrewtraining + '" title="Edit"><i class="fa fa-edit"></i></button> ' +
                   '<button type="button" class="btn btn-sm btn-outline-danger btn-delete-crewtraining" data-id="' + row.idcrewtraining + '" title="Delete"><i class="fa fa-trash"></i></button>';
          }
        }
      ],
      initComplete: function () {
        $('.crew-training-btn').html('<button type="button" class="btn btn-primary btn-sm rounded-pill fst-italic" id="btnNewCrewTraining"><i class="fa fa-plus"></i> New</button>');
        $('#crewTrainingTable thead tr:eq(1) th').each(function (i) {
          var $input = $('input', this);
          if ($input.length) {
            $input.on('keyup change', function () {
              if (crewTrainingTable.column(i).search() !== this.value) crewTrainingTable.column(i).search(this.value).draw();
            });
          }
        });
      },
     // language: { emptyTable: 'No training data found', zeroRecords: 'No matching data found', lengthMenu: '_MENU_ &nbsp;Entries', info: 'Showing _START_ to _END_ of _TOTAL_ entries', infoEmpty: 'Showing 0 to 0 of 0 entries', infoFiltered: '(filtered from _MAX_ total entries)', search: 'Search:' }
      language: {
        emptyTable: "No training data found",
        zeroRecords: "No matching data found",
        lengthMenu: '_MENU_ &nbsp;Entries',
        info: 'Showing _START_ to _END_ of _TOTAL_ entries',
        infoEmpty: 'Showing 0 to 0 of 0 entries',
        infoFiltered: '(filtered from _MAX_ total entries)',
        search: 'Search:'
      }
    });

    // =========================
    // Training List (matrix) DataTable
    // =========================

    var $certSel = $('#cert_matrix_id');
    if ($certSel.length) {
      $certSel.empty();
      // Tambah option kosong di paling atas supaya default benar-benar "belum pilih"
      $certSel.append($('<option></option>').val('').text('- Select Training -'));
      $.each(optionsCertificateMatrix, function (i, o) {
        $certSel.append($('<option></option>').val(o.value).text(o.text));
      });
      $certSel.selectpicker({
        noneSelectedText: '- Select Training -',
        liveSearch: true,
        size: 5
      });
      // Pastikan tidak ada nilai yang terpilih saat awal
      $certSel.selectpicker('val', '');
    }

    var trainingMatrixTable = $('#trainingMatrixTable').DataTable({
      dom: "<'row mb-2'<'col-md-6 d-flex align-items-center'l><'col-md-6 text-end tm-btn-wrap'>>" +
           "<'row'<'col-md-12'tr>>" +
           "<'row mt-2'<'col-md-6'i><'col-md-6 d-flex justify-content-end'p>>",
      processing: true,
      serverSide: false,
      searching: false,
      paging: true,
      pageLength: 5,
      lengthMenu: [5,10, 25, 50, 100],
      ajax: {
        url: baseUrlTraining + '/get_training_matrix',
        type: 'GET',
        data: { idperson: idperson },
        dataSrc: function (json) {
          if (json.success) return json.data;
          return [];
        }
      },
      columns: [
        { data: null, className: 'text-center', orderable: false, render: function (data, type, row, meta) { return meta.row + 1; } },
        { data: 'training_name'},
        {
          data: 'completed',
          className: 'text-center',
          orderable: false,
          render: function (d, type, row) {
            var checked = (d === 1 || d === '1') ? 'checked' : '';
            return '<input type="checkbox" class="form-check-input tm-completed" data-id="' + row.idcrewtraining_matrix + '" ' + checked + ' />';
          }
        },
        {
          data: null,
          className: 'text-center',
          orderable: false,
          searchable: false,
          render: function (data, type, row) {
            return '<button type="button" class="btn btn-sm btn-outline-primary tm-edit" data-id="' + row.idcrewtraining_matrix + '"><i class="fa fa-edit"></i></button> ' +
                   '<button type="button" class="btn btn-sm btn-outline-danger tm-delete" data-id="' + row.idcrewtraining_matrix + '"><i class="fa fa-trash"></i></button>';
          }
        }
      ],
      initComplete: function () {
        //$('.tm-btn-wrap').html('<button type="button" class="btn btn-primary btn-sm rounded-pill fst-italic" id="btnNewTrainingMatrix"><i class="fa fa-plus"></i> New</button>');
      },
      language: {
        emptyTable: 'No training data',
        zeroRecords: 'No matching training found',
        lengthMenu: '_MENU_ &nbsp;Entries',
        info: 'Showing _START_ to _END_ of _TOTAL_ entries',
        infoEmpty: 'Showing 0 to 0 of 0 entries',
        infoFiltered: '(filtered from _MAX_ total entries)',
        search: 'Search:'
      }
    });

    function validateTrainingMatrixForm() {
      var ok = true;
      $('#cert_matrix_id_fb').addClass('d-none');
      $('#cert_matrix_id').closest('.bootstrap-select').removeClass('is-invalid');
      var val = $('#cert_matrix_id').val();
      if (!val || (typeof val === 'string' && val.trim() === '')) {
        $('#cert_matrix_id_fb').removeClass('d-none');
        $('#cert_matrix_id').closest('.bootstrap-select').addClass('is-invalid');
        ok = false;
      }
      return ok;
    }

    function hideTrainingMatrixFeedback() {
      $('#cert_matrix_id_fb').addClass('d-none');
      $('#cert_matrix_id').closest('.bootstrap-select').removeClass('is-invalid');
    }

    $(document).on('click', '#btnNewTrainingMatrix', function () {
      $('#trainingMatrixForm')[0].reset();
      $('#idcrewtraining_matrix').val('');
      $('#cert_matrix_id').selectpicker('val', '');
      $('#completed_matrix').prop('checked', false);
      hideTrainingMatrixFeedback();
      $('#trainingMatrixModalTitle').text('Add List Training');
      $('#btnSaveTrainingMatrix').removeClass('d-none');
      $('#btnUpdateTrainingMatrix').addClass('d-none');
      $('#trainingMatrixModal').modal('show');
    });

    $('#trainingMatrixTable').on('click', '.tm-edit', function () {
      var id = $(this).data('id');
      $('#trainingMatrixForm')[0].reset();
      hideTrainingMatrixFeedback();
      $('#trainingMatrixModalTitle').text('Edit List Training');
      $('#btnSaveTrainingMatrix').addClass('d-none');
      $('#btnUpdateTrainingMatrix').removeClass('d-none');
      $.ajax({
        url: baseUrlTraining + '/get_training_matrix_by_id',
        type: 'POST',
        dataType: 'json',
        data: { idcrewtraining_matrix: id, idperson: idperson },
        success: function (r) {
          if (!r || r.success === false) {
            if (typeof Swal !== 'undefined') Swal.fire({ icon: 'error', title: 'Error', text: (r && r.message) || 'Data not found' });
            else alert((r && r.message) || 'Data not found');
            return;
          }
          $('#idcrewtraining_matrix').val(r.idcrewtraining_matrix);
          $('#idperson_matrix').val(r.idperson);
          $('#cert_matrix_id').selectpicker('val', (r.cert_matrix_id || '').toString().trim());
          $('#completed_matrix').prop('checked', r.completed == 1 || r.completed === '1');
          $('#remarks_matrix').val(r.remarks || '');
          $('#trainingMatrixModal').modal('show');
        }
      });
    });

    $('#btnSaveTrainingMatrix').on('click', function () {
      if (!validateTrainingMatrixForm()) return;
      var fd = new FormData($('#trainingMatrixForm')[0]);
      fd.set('idperson', idperson);
      $.ajax({
        url: baseUrlTraining + '/save_training_matrix',
        type: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (r) {
          if (r.status) {
            $('#trainingMatrixModal').modal('hide');
            if (typeof Swal !== 'undefined') Swal.fire({ title: r.message, icon: 'success' });
            else alert(r.message);
            trainingMatrixTable.ajax.reload(null, false);
          } else {
            if (typeof Swal !== 'undefined') Swal.fire({ icon: 'error', title: 'Error', text: r.message || 'Save failed' });
            else alert(r.message || 'Save failed');
          }
        }
      });
    });

    $('#btnUpdateTrainingMatrix').on('click', function () {
      if (!validateTrainingMatrixForm()) return;
      var fd = new FormData($('#trainingMatrixForm')[0]);
      fd.set('idperson', idperson);
      $.ajax({
        url: baseUrlTraining + '/update_training_matrix',
        type: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (r) {
          if (r.status) {
            $('#trainingMatrixModal').modal('hide');
            if (typeof Swal !== 'undefined') Swal.fire({ title: r.message, icon: 'success' });
            else alert(r.message);
            trainingMatrixTable.ajax.reload(null, false);
          } else {
            if (typeof Swal !== 'undefined') Swal.fire({ icon: 'error', title: 'Error', text: r.message || 'Update failed' });
            else alert(r.message || 'Update failed');
          }
        }
      });
    });

    $('#trainingMatrixTable').on('change', '.tm-completed', function () {
      var id = $(this).data('id');
      var checked = $(this).is(':checked') ? 1 : 0;
      $.ajax({
        url: baseUrlTraining + '/update_training_completed',
        type: 'POST',
        dataType: 'json',
        data: { idcrewtraining_matrix: id, completed: checked }
      });
    });

    $('#trainingMatrixTable').on('click', '.tm-delete', function () {
      var id = $(this).data('id');
      var doDelete = function () {
        $.ajax({
          url: baseUrlTraining + '/delete_training_matrix',
          type: 'POST',
          dataType: 'json',
          data: { idcrewtraining_matrix: id },
          success: function (r) {
            if (r.status) {
              if (typeof Swal !== 'undefined') Swal.fire({ title: r.message, icon: 'success' });
              else alert(r.message);
              trainingMatrixTable.ajax.reload(null, false);
            } else {
              if (typeof Swal !== 'undefined') Swal.fire({ icon: 'error', title: 'Error', text: r.message || 'Delete failed' });
              else alert(r.message || 'Delete failed');
            }
          }
        });
      };
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
          if (result.isConfirmed) doDelete();
        });
      } else {
        if (confirm('Delete this training?')) doDelete();
      }
    });

    $('#trainingMatrixModal').on('hidden.bs.modal', function () {
      $('#idcrewtraining_matrix').val('');
      $('#btnSaveTrainingMatrix').removeClass('d-none');
      $('#btnUpdateTrainingMatrix').addClass('d-none');
      hideTrainingMatrixFeedback();
    });

    $(document).on('click', '#btnNewCrewTraining', function () {
      $('#crewTrainingForm')[0].reset();
      $('#idcrewtraining').val('');
      $('#idperson_crewtraining').val(idperson);
      $('#crewTrainingModalTitle').text('Add Training');
      $('#btnSaveCrewTraining').removeClass('d-none');
      $('#btnUpdateCrewTraining').addClass('d-none');
      $('#rank_crewtraining').selectpicker('val', '');
      $('#kdvsl_crewtraining').selectpicker('val', '');
      $('#status_crewtraining').val('');
      hideCrewTrainingFeedback();
      $('#crewTrainingModal').modal('show');
    });

    $('#crewTrainingTable').on('click', '.btn-edit-crewtraining', function () {
      var id = $(this).data('id');
      $('#crewTrainingForm')[0].reset();
      $('#btnUpdateCrewTraining').removeClass('d-none');
      $('#btnSaveCrewTraining').addClass('d-none');
      $('#crewTrainingModalTitle').text('Edit Training');
      $.ajax({
        url: baseUrlTraining + '/get_crewtraining_by_id',
        type: 'POST',
        data: { idcrewtraining: id, idperson: idperson },
        dataType: 'json',
        success: function (r) {
          $('#idcrewtraining').val(r.idcrewtraining);
          $('#idperson_crewtraining').val(r.idperson);
          $('#rank_crewtraining').selectpicker('val', (r.rank || '').toString().trim());
          $('#kdvsl_crewtraining').selectpicker('val', (r.kdvsl || '').toString().trim());
          $('#total_training').val(r.total_training != null ? r.total_training : '');
          $('#start_date_training').val(r.start_date_training && r.start_date_training !== '0000-00-00' ? r.start_date_training : '');
          $('#end_date_training').val(r.end_date_training && r.end_date_training !== '0000-00-00' ? r.end_date_training : '');
          $('#finish_date_training').val(r.finish_date_training && r.finish_date_training !== '0000-00-00' ? r.finish_date_training : '');
          $('#status_crewtraining').val(r.status || '');
          $('#remarks_crewtraining').val(r.remarks || '');
          hideCrewTrainingFeedback();
          $('#crewTrainingModal').modal('show');
        }
      });
    });

    function validateCrewTrainingForm() {
      var ok = true;
      $('#rank_crewtraining_fb, #kdvsl_crewtraining_fb, #total_training_fb, #start_date_training_fb, #status_crewtraining_fb').addClass('d-none');
      $('#rank_crewtraining, #kdvsl_crewtraining, #total_training, #start_date_training, #status_crewtraining').removeClass('is-invalid');

      var rankVal = $('#rank_crewtraining').val();
      if (!rankVal || (typeof rankVal === 'string' && rankVal.trim() === '')) {
        $('#rank_crewtraining_fb').removeClass('d-none'); $('#rank_crewtraining').addClass('is-invalid'); ok = false;
      }
      var kdvslVal = $('#kdvsl_crewtraining').val();
      if (!kdvslVal || (typeof kdvslVal === 'string' && kdvslVal.trim() === '')) {
        $('#kdvsl_crewtraining_fb').removeClass('d-none'); $('#kdvsl_crewtraining').addClass('is-invalid'); ok = false;
      }
      var totalVal = $('#total_training').val();
      if (totalVal === '' || totalVal === null || totalVal === undefined) {
        $('#total_training_fb').removeClass('d-none'); $('#total_training').addClass('is-invalid'); ok = false;
      }
      var startVal = $('#start_date_training').val();
      if (!startVal || (typeof startVal === 'string' && startVal.trim() === '')) {
        $('#start_date_training_fb').removeClass('d-none'); $('#start_date_training').addClass('is-invalid'); ok = false;
      }
      var statusVal = $('#status_crewtraining').val();
      if (!statusVal || (typeof statusVal === 'string' && statusVal.trim() === '')) {
        $('#status_crewtraining_fb').removeClass('d-none'); $('#status_crewtraining').addClass('is-invalid'); ok = false;
      }
      return ok;
    }

    function hideCrewTrainingFeedback() {
      $('#rank_crewtraining_fb, #kdvsl_crewtraining_fb, #total_training_fb, #start_date_training_fb, #status_crewtraining_fb').addClass('d-none');
      $('#rank_crewtraining, #kdvsl_crewtraining, #total_training, #start_date_training, #status_crewtraining').removeClass('is-invalid');
    }

    $('#btnSaveCrewTraining').on('click', function () {
      if (!validateCrewTrainingForm()) return;
      var fd = new FormData($('#crewTrainingForm')[0]);
      fd.set('idperson', idperson);
      $.ajax({
        url: baseUrlTraining + '/save_crewtraining',
        type: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (r) {
          if (r.status) {
            $('#crewTrainingModal').modal('hide');
            if (typeof Swal !== 'undefined') Swal.fire({ title: r.message, icon: 'success' });
            else alert(r.message);
            crewTrainingTable.ajax.reload(null, false);
          } else {
            if (typeof Swal !== 'undefined') Swal.fire({ icon: 'error', title: 'Error', text: r.message || 'Save failed' });
            else alert(r.message || 'Save failed');
          }
        }
      });
    });

    $('#btnUpdateCrewTraining').on('click', function () {
      if (!validateCrewTrainingForm()) return;
      var fd = new FormData($('#crewTrainingForm')[0]);
      fd.set('idperson', idperson);
      $.ajax({
        url: baseUrlTraining + '/update_crewtraining',
        type: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (r) {
          if (r.status) {
            $('#crewTrainingModal').modal('hide');
            if (typeof Swal !== 'undefined') Swal.fire({ title: r.message, icon: 'success' });
            else alert(r.message);
            crewTrainingTable.ajax.reload(null, false);
          } else {
            if (typeof Swal !== 'undefined') Swal.fire({ icon: 'error', title: 'Error', text: r.message || 'Update failed' });
            else alert(r.message || 'Update failed');
          }
        }
      });
    });

    $('#crewTrainingTable').on('click', '.btn-delete-crewtraining', function () {
      var id = $(this).data('id');
      var doDelete = function () {
        $.ajax({
          url: baseUrlTraining + '/delete_crewtraining',
          type: 'POST',
          data: { idcrewtraining: id },
          dataType: 'json',
          success: function (r) {
            if (r.status) {
              if (typeof Swal !== 'undefined') Swal.fire({ title: r.message, icon: 'success' });
              else alert(r.message);
              crewTrainingTable.ajax.reload(null, false);
            }
          }
        });
      };
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
          if (result.isConfirmed) doDelete();
        });
      } else {
        if (confirm('Delete this training record?')) doDelete();
      }
    });

    $('#crewTrainingModal').on('hidden.bs.modal', function () {
      $('#idcrewtraining').val('');
      $('#btnUpdateCrewTraining').addClass('d-none');
      $('#btnSaveCrewTraining').removeClass('d-none');
      hideCrewTrainingFeedback();
    });
  });
</script>