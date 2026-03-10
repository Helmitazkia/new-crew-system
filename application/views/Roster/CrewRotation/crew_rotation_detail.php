<div class="crew-rotation-detail-content mb-0 pb-0">
  <form id="crewRotationForm">
    <input type="hidden" name="idcrewrotation" id="idcrewrotation" value="">
    <input type="hidden" name="idperson" id="idperson" value="">
    <input type="hidden" name="batch_id" id="batch_id" value="">

    <div class="row g-3 pb-3">
      <!-- ========== LEFT: OFF-SIGNER ========== -->
      <div class="col-lg-4">
        <div class="card h-100 border">
          <div class="card-header bg-light fw-semibold fst-italic">Off Signer (yang turun)</div>
          <div class="card-body">
            <div class="mb-2">
              <label class="form-label mb-0 small fw-semibold">Batch ID</label>
              <input type="text" id="batch_id_display" class="form-control form-control-sm bg-light" disabled
                placeholder="Auto (setelah save)" value="">
            </div>
            <div class="mb-2">
              <label class="form-label mb-0 small fw-semibold">Single UP / Double UP</label>
              <div class="d-flex gap-3 pt-1">
                <label class="d-flex align-items-center gap-1 mb-0 small">
                  <input type="radio" name="is_double_up" value="0" class="form-check-input" checked> Single UP
                </label>
                <label class="d-flex align-items-center gap-1 mb-0 small">
                  <input type="radio" name="is_double_up" value="1" class="form-check-input"> Double UP
                </label>
              </div>
            </div>
            <div class="d-flex align-items-center gap-2 mb-2">
              <div class="rounded bg-primary bg-opacity-25 d-flex align-items-center justify-content-center"
                style="width:48px;height:48px;">
                <i class="fa fa-user text-primary"></i>
              </div>
              <div class="flex-grow-1">
                <label class="form-label mb-0 small fw-semibold">Name <span class="text-danger">*</span></label>
                <select id="offSignerSelect" class="form-control selectpicker-on"
                  style="max-height:120px;word-break:break-all;" data-live-search="true" data-size="5">
                  <option value="">- Select crew -</option>
                </select>
                <small id="offSignerSelectFeedback" class="text-danger d-none">Name is required</small>
              </div>
            </div>
            <div class="row g-2 mb-2">
              <div class="col-12">
                <label class="form-label mb-0 small">Sign off Date ( Off Yang Turun )</label>
                <input type="date" name="signoffdt_offsigner" id="signoffdt_offsigner" class="form-control form-control-sm">
                <small class="text-muted d-block mt-1">Single UP: auto dari Sign on Date. Double UP: biarkan kosong. Simpan ke kontrak yang turun jika diisi.</small>
              </div>
              <div class="col-12">
                <label class="form-label mb-0 small">Sign off remarks ( Off Yang Turun )</label>
                <select name="signoffremark_offsigner" id="signoffremark_offsigner" class="form-control selectpicker-on p-10"
                  data-live-search="true" data-size="5"></select>
              </div>
            </div>
            <div id="offSignerContractPanel" class="small" style="display:none;">
              <div class="row g-2 border-top pt-2">
                <div class="col-6 mb-2">
                  <label class="form-label mb-0">Vessel</label>
                  <input type="text" id="off_vessel" class="form-control form-control-sm bg-light" disabled value="">
                </div>
                <div class="col-6 mb-2">
                  <label class="form-label mb-0">Rank</label>
                  <input type="text" id="off_rank" class="form-control form-control-sm bg-light" disabled value="">
                </div>
                <div class="col-6 mb-2">
                  <label class="form-label mb-0">Planned Sign-off</label>
                  <input type="text" id="off_planned_signoff" class="form-control form-control-sm bg-light" disabled
                    value="">
                </div>
                <div class="col-6 mb-2">
                  <label class="form-label mb-0">Relieving Port</label>
                  <input type="text" id="off_relieving_port" class="form-control form-control-sm bg-light" disabled
                    value="">
                </div>
                <div class="col-6 mb-2">
                  <label class="form-label mb-0">Status</label>
                  <input type="text" id="off_status" class="form-control form-control-sm bg-light" disabled value="">
                </div>
                <div class="col-6 mb-2">
                  <label class="form-label mb-0">EOC</label>
                  <input type="text" id="off_eoc" class="form-control form-control-sm bg-light" disabled value="">
                </div>
                <div class="col-12 mb-2">
                  <label class="form-label mb-0">Remarks</label>
                  <input type="text" id="off_remarks" class="form-control form-control-sm bg-light" disabled value="">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ========== RIGHT: ON SIGNER (New Contract Details) ========== -->
      <div class="col-lg-8">
        <div class="card h-100 border">
          <div class="card-header bg-light fw-semibold fst-italic">On Signer (New Contract Details)</div>
          <div class="card-body">
            <div class="row g-2 align-items-end">
              <div class="col-md-12 mb-2 on-signer-field">
                <label class="form-label small fw-semibold">Replacement Candidate <span
                    class="text-danger">*</span></label>
                <select name="replacement_idperson[]" id="replacement_idperson" class="form-control selectpicker-on"
                  data-live-search="true" data-size="8" multiple></select>
                <small class="text-muted small">Bisa pilih lebih dari satu (plan banyak replacement)</small>
                <small id="replacement_idpersonFeedback" class="text-danger d-none">Replacement Candidate is
                  required</small>
              </div>
              <div class="col-md-6 mb-2 on-signer-field">
                <label class="form-label small fw-semibold">Replacement Rank</label>
                <input type="hidden" name="replacement_rank" id="replacement_rank" value="">
                <input type="text" id="replacement_rank_display" class="form-control form-control-sm bg-light" disabled
                  placeholder="(rank yang turun – pilih Name dulu)" value="">
              </div>
              <div class="col-md-6 mb-2 on-signer-field">
                <label class="form-label small fw-semibold">Company Name <span class="text-danger">*</span></label>
                <select name="kdcmprec" id="kdcmprec" class="form-control selectpicker-on" data-live-search="true"
                  data-size="5"></select>
                <small id="kdcmprecFeedback" class="text-danger d-none">Company Name is required</small>
              </div>
              <div class="col-md-3 mb-2 on-signer-field">
                <label class="form-label small fw-semibold">Sign on Date <span class="text-danger">*</span></label>
                <input type="date" name="signondt" id="signondt" class="form-control form-control-sm">
                <small id="signondtFeedback" class="text-danger d-none">Sign on Date is required</small>
              </div>
              <div class="col-md-3 mb-2 on-signer-field">
                <label class="form-label small fw-semibold">Month</label>
                <div class="d-flex gap-1 align-items-center">
                  <input type="number" id="month" class="form-control form-control-sm" min="1" max="24"
                    placeholder="1-24" style="width:70px;">
                  <button type="button" class="btn btn-sm btn-primary" id="btnCalculate">Calculate</button>
                </div>
              </div>
              <div class="col-md-4 mb-2 on-signer-field">
                <label class="form-label small fw-semibold">Estimate Sign off Date <span
                    class="text-danger">*</span></label>
                <input type="date" name="estsignoffdt" id="estsignoffdt" class="form-control form-control-sm">
                <small id="estsignoffdtFeedback" class="text-danger d-none">Estimate Sign off Date is required</small>
                <small id="estsignoffdtFeedbackDate" class="text-danger d-none">Cannot be earlier than Sign off
                  Date</small>
              </div>
              <div class="col-md-4 mb-2 on-signer-field">
                <label class="form-label small fw-semibold">Sign on Rank <span class="text-danger">*</span></label>
                <select name="signonrank" id="signonrank" class="form-control selectpicker-on" data-live-search="true"
                  data-size="5"></select>
                <small id="signonrankFeedback" class="text-danger d-none">Sign on Rank is required</small>
              </div>
              <div class="col-md-4 mb-2 on-signer-field">
                <label class="form-label small fw-semibold">Sign on Vessel <span class="text-danger">*</span></label>
                <select name="signonvsl" id="signonvsl" class="form-control selectpicker-on" data-live-search="true"
                  data-size="5"></select>
                <small id="signonvslFeedback" class="text-danger d-none">Sign on Vessel is required</small>
              </div>
              <div class="col-md-6 mb-2 on-signer-field">
                <label class="form-label small fw-semibold">Sign on Port <span class="text-danger">*</span></label>
                <input type="text" name="signonport" id="signonport" class="form-control form-control-sm"
                  placeholder="e.g. BENOA">
                <small id="signonportFeedback" class="text-danger d-none">Sign on Port is required</small>
              </div>
              <div class="col-md-6 mb-2 on-signer-field">
                <label class="form-label small fw-semibold">Last Vessel</label>
                <select name="lastvsl" id="lastvsl" class="form-control selectpicker-on" data-live-search="true"
                  data-size="5">
                  <option value="">- Select -</option>
                </select>
              </div>
              <div class="row g-2 mb-2">
                <div class="col-md-6 on-signer-field">
                  <label class="form-label mb-0 small">Sign off Date ( Off Yang Naik )</label>
                  <input type="date" name="signoffdt_onsigner" id="signoffdt_onsigner" class="form-control form-control-sm">
                  <small class="text-muted d-block mt-1">Opsional. Simpan ke data yang naik (kontrak replacement) jika diisi.</small>
                </div>
                <div class="col-md-6 on-signer-field">
                  <label class="form-label mb-0 small">Sign off remarks ( Off Yang Naik )</label>
                  <select name="signoffremark_onsigner" id="signoffremark_onsigner" class="form-control selectpicker-on p-10"
                    data-live-search="true" data-size="5"></select>
                </div>
              </div>
              <div class="col-12 mb-2 on-signer-field">
                <label class="form-label small fw-semibold">Sign on Description <span
                    class="text-danger">*</span></label>
                <textarea name="signondesc" id="signondesc" class="form-control form-control-sm" rows="2"
                  placeholder="e.g. Joining as AB"></textarea>
                <small id="signondescFeedback" class="text-danger d-none">Sign on Description is required</small>
              </div>
              <div class="col-md-4 mb-2 on-signer-field">
                <label class="form-label small fw-semibold">No. PKL</label>
                <input type="text" name="no_pkl" id="no_pkl" class="form-control form-control-sm">
                <small id="no_pklFeedback" class="text-danger d-none">No. PKL is required</small>
              </div>
              <div class="col-md-4 mb-2 on-signer-field">
                <label class="form-label small fw-semibold">Remarks</label>
                <textarea name="estremark" id="estremark" class="form-control form-control-sm" rows="2"></textarea>
              </div>
              <div class="col-md-6 mb-2 on-signer-field">
                <label class="form-label small fw-semibold">Additional / Foreign Crew</label>
                <div class="d-flex gap-3 flex-wrap pt-1">
                  <label class="d-flex align-items-center gap-1 mb-0 small">
                    <input type="radio" name="foreigncrew_option" value="none" class="form-check-input" checked> None
                  </label>
                  <label class="d-flex align-items-center gap-1 mb-0 small">
                    <input type="radio" name="foreigncrew_option" value="additional" class="form-check-input">
                    Additional
                  </label>
                  <label class="d-flex align-items-center gap-1 mb-0 small">
                    <input type="radio" name="foreigncrew_option" value="foreigncrew" class="form-check-input"> Foreign
                    Crew
                  </label>
                </div>
              </div>
              <div class="col-12 mb-2 on-signer-field">
                <label class="form-label small fw-semibold">File Contract</label>
                <div class="d-flex gap-2 align-items-center">
                  <input type="file" name="file_contract" id="file_contract" class="form-control form-control-sm"
                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif" style="max-width:220px;">
                  <span class="small text-muted" id="file_contract_label">No file selected</span>
                  <button type="button" class="btn btn-sm btn-warning" id="btnClearFile">Clear</button>
                </div>
              </div>
              <div class="col-12 mb-2 on-signer-field" id="statusFieldWrapper" style="display:none;">
                <label class="form-label small fw-semibold">Status</label>
                <select name="status" id="status" class="form-select">
                  <option value="Submit">Submit</option>
                  <option value="Joined">Joined</option>
                </select>
              </div>
              <div class="col-md-6 mb-2 on-signer-field d-none">
                <label class="form-label small fw-semibold">Next Vessel</label>
                <input type="text" name="next_vessel" id="next_vessel" class="form-control form-control-sm">
              </div>
              <div class="col-12 mt-3">
                <button type="button" class="btn btn-primary px-4 rounded-pill fw-semibold" id="btnSaveForm">
                  <i class="fa fa-save me-1"></i> Save
                </button>
                <button type="button" class="btn btn-success px-4 rounded-pill fw-semibold d-none" id="btnUpdateForm">
                  <i class="fa fa-edit me-1"></i> Update
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<style>
.crew-rotation-detail-content .card.border {
  border-color: #dee2e6 !important;
}

.crew-rotation-detail-content .form-label.small {
  font-size: 0.875rem;
}

.crew-rotation-detail-content {
  padding: 0;
}

/* Sejajar: label + input align bottom per row */
.crew-rotation-detail-content .on-signer-field {
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
}

.crew-rotation-detail-content .on-signer-field .form-label {
  flex-shrink: 0;
}

/* Wrapping: value panjang akan turun ke baris baru */
.crew-rotation-detail-content .form-control,
.crew-rotation-detail-content .form-select,
.crew-rotation-detail-content textarea {
  word-wrap: break-word;
  word-break: break-word;
  overflow-wrap: break-word;
}

.crew-rotation-detail-content .bootstrap-select .filter-option-inner-inner,
.crew-rotation-detail-content .bootstrap-select .btn {
  word-wrap: break-word;
  word-break: break-word;
  overflow-wrap: break-word;
  white-space: normal !important;
  text-align: left;
}
</style>

<script>
(function() {
  var baseUrl = "<?php echo base_url('CrewRotation/CrewRotation'); ?>";
  var optionsCompany = <?php echo isset($optionsCompanyJson) ? $optionsCompanyJson : '[]'; ?>;
  var optionsRank = <?php echo isset($optionsRankJson) ? $optionsRankJson : '[]'; ?>;
  var optionsVessel = <?php echo isset($optionsVesselJson) ? $optionsVesselJson : '[]'; ?>;
  var optionsSignOffRemark = <?php echo isset($optionsSignOffRemarkJson) ? $optionsSignOffRemarkJson : '[]'; ?>;
  var optionsPersonActiveRoster = <?php echo isset($optionsPersonActiveRosterJson) ? $optionsPersonActiveRosterJson : '[]'; ?>;

  // Validasi sama dengan active_roster.php: Expired Over (tanggal lewat) = Stand By; Expired In = On board
  function computeStatusFromRow(row) {
    var hasSignoff = row.signoffdt && row.signoffdt !== '' && row.signoffdt !== '0000-00-00';
    var dateRaw = hasSignoff ? row.signoffdt : (row.estsignoffdt || '');
    if (!dateRaw || dateRaw === '0000-00-00') return 'On board';
    var dateNow = new Date();
    var estDate = new Date(dateRaw);
    dateNow.setHours(0, 0, 0, 0);
    estDate.setHours(0, 0, 0, 0);
    var diffDays = Math.ceil((estDate - dateNow) / (1000 * 60 * 60 * 24));
    return diffDays < 0 ? 'Stand By' : 'On board';
  }
  var optionsPersonOnBoard = [{ value: '', text: '- Select crew -' }];
  var optionsPersonStandBy = [];
  (optionsPersonActiveRoster || []).forEach(function(o) {
    if (!o.value) return;
    var status = computeStatusFromRow(o);
    var opt = { value: o.value, text: o.text };
    if (status === 'On board') optionsPersonOnBoard.push(opt);
    else optionsPersonStandBy.push(opt);
  });
  var standByIds = {};
  optionsPersonStandBy.forEach(function(o) { standByIds[o.value] = true; });
  var batch_rows = <?php echo isset($batch_rows) ? json_encode($batch_rows) : '[]'; ?>;
  (batch_rows || []).forEach(function(r) {
    var rid = r.replacement_idperson;
    if (rid != null && rid !== '' && !standByIds[rid]) {
      var text = (r.replacement_name || '') ? (r.replacement_name + ' (' + rid + ')') : ('(' + rid + ')');
      optionsPersonStandBy.push({ value: rid.toString(), text: text });
      standByIds[rid] = true;
    }
  });

  function fillSelect($el, arr) {
    $el.empty().append($('<option value="">- Select -</option>'));
    (arr || []).forEach(function(o) {
      if (o.value === '') return;
      $el.append($('<option></option>').val(o.value).text(o.text));
    });
  }

  var $offSelect = $('#offSignerSelect');
  $offSelect.empty().append($('<option value="">- Select crew -</option>'));
  (optionsPersonOnBoard || []).forEach(function(o) {
    if (o.value) $offSelect.append($('<option></option>').val(o.value).text(o.text));
  });

  fillSelect($('#kdcmprec'), optionsCompany);
  fillSelect($('#signonrank'), optionsRank);
  fillSelect($('#signonvsl'), optionsVessel);
  fillSelect($('#signoffremark_offsigner'), optionsSignOffRemark);
  fillSelect($('#signoffremark_onsigner'), optionsSignOffRemark);
  fillSelect($('#lastvsl'), optionsVessel);
  var $replSelect = $('#replacement_idperson');
  $replSelect.empty();
  (optionsPersonStandBy || []).forEach(function(o) {
    if (o.value) $replSelect.append($('<option></option>').val(o.value).text(o.text));
  });

  var row = <?php echo isset($row) && $row ? json_encode($row) : 'null'; ?>;
  var batch_id = <?php echo isset($batch_id) ? json_encode($batch_id) : '""'; ?>;

  $('#batch_id').val(batch_id || '');
  $('#batch_id_display').val(batch_id || 'Auto (setelah save)');

  if (row) {
    $('#idcrewrotation').val(row.idcrewrotation || '');
    $('#idperson').val(row.idperson || '');
    $('#kdcmprec').val(row.kdcmprec || '');
    $('#signondt').val((row.signondt && row.signondt !== '0000-00-00') ? row.signondt : '');
    $('#signoffdt_offsigner').val((row.signoffdt && row.signoffdt !== '0000-00-00') ? row.signoffdt : '');
    $('#estsignoffdt').val((row.estsignoffdt && row.estsignoffdt !== '0000-00-00') ? row.estsignoffdt : '');
    $('#signonrank').val(row.signonrank || '');
    $('#signonvsl').val(row.signonvsl || '');
    $('#next_vessel').val(row.next_vessel || row.signonvsl || '');
    $('#signonport').val(row.signonport || '');
    $('#signondesc').val(row.signondesc || '');
    $('#lastvsl').val(row.lastvsl || '');
    $('#no_pkl').val(row.no_pkl || '');
    $('#estremark').val(row.estremark || '');
    $('#signoffremark_offsigner').val(row.signoffremark || '');
    if ($('#signoffremark_offsigner').data('selectpicker')) $('#signoffremark_offsigner').selectpicker('refresh');
    var rr = (row.replacement_rank || '').toString().trim();
    $('#replacement_rank').val(rr);
    $('#replacement_rank_display').val(rr);
    $('#status').val(row.status || 'Submit');
    var isDoubleUp = (row.is_double_up == 1 || row.is_double_up === '1');
    $('input[name="is_double_up"][value="' + (isDoubleUp ? '1' : '0') + '"]').prop('checked', true);
    if ($('#offSignerSelect').length && row.idperson != null) {
      var idValPadded = row.idperson.toString().padStart(6, '0');
      if ($('#offSignerSelect').find('option[value="' + idValPadded + '"]').length > 0) {
        $('#offSignerSelect').val(idValPadded);
      } else {
        $('#offSignerSelect').val(row.idperson.toString());
      }
    }
    var repIds = [];
    if (batch_rows && batch_rows.length > 0) {
      batch_rows.forEach(function(r) {
        if (r.replacement_idperson != null && r.replacement_idperson !== '') repIds.push(r.replacement_idperson.toString());
      });
    } else if (row.replacement_idperson != null && row.replacement_idperson !== '') {
      repIds.push(row.replacement_idperson.toString());
    }
    if (repIds.length > 0) {
      var setVal = repIds.map(function(id) {
        var pad = id.toString().padStart(6, '0');
        return $replSelect.find('option[value="' + pad + '"]').length ? pad : id;
      });
      $replSelect.val(setVal);
    }
  }

  // Init selectpicker: destroy dulu jika ada (prevent double)
  // Tanpa container: dropdown render di samping select, hindari flash/jump dari pojok kiri atas
  $('.selectpicker-on').each(function() {
    var $el = $(this);
    if ($.fn.selectpicker) {
      if ($el.data('selectpicker')) {
        try {
          $el.selectpicker('destroy');
        } catch (e) {}
      }
      var opts = {
        noneSelectedText: '- Select -',
        liveSearch: true,
        size: 5
      };
      if ($el.attr('id') === 'offSignerSelect') opts.noneSelectedText = '- Select crew -';
      if ($el.attr('id') === 'replacement_idperson') {
        opts.noneSelectedText = '- Select replacement(s) -';
        opts.size = 8;
      }
      $el.selectpicker(opts);
    }
  });
  function toggleSignoffdtRequiredStar() {
    var status = ($('#status').val() || '').trim();
    $('#signoffdtRequiredStar').toggle(status.toUpperCase() === 'JOINED');
  }
  toggleSignoffdtRequiredStar();
  $('#status').on('change', toggleSignoffdtRequiredStar);
  $('#file_contract').on('change', function() {
    var fn = $(this).val().split(/\\/).pop();
    $('#file_contract_label').text(fn || 'No file selected');
  });
  $('#btnClearFile').on('click', function() {
    $('#file_contract').val('');
    $('#file_contract_label').text('No file selected');
  });

  // When Off-signer selected → load contract (single value only)
  $offSelect.on('change', function() {
    var idperson = $(this).val();
    if (Array.isArray(idperson)) idperson = idperson[0];
    idperson = idperson || '';
    $('#idperson').val(idperson);
    if (!idperson) {
      $('#offSignerContractPanel').hide();
      $('#signoffdt_offsigner').val('');
      $('#off_vessel').val('');
      $('#replacement_rank').val('');
      $('#replacement_rank_display').val('');
      $('#lastvsl').val('');
      if ($('#lastvsl').data('selectpicker')) $('#lastvsl').selectpicker('refresh');
      return;
    }
    var $panel = $('#offSignerContractPanel');
    $panel.hide();
    $.get(baseUrl + '/getContractByPerson', {
        idperson: idperson
      })
      .done(function(res) {
        if (res.success && res.data) {
          var d = res.data;
          $('#off_rank').val(d.rank || '-');
          $('#off_vessel').val(d.nmvsl || '-');
          $('#off_planned_signoff').val(d.planned_signoff || '-');
          $('#off_relieving_port').val(d.relieving_port || '-');
          $('#off_status').val(d.status || '-');
          $('#off_eoc').val(d.eoc || '-');
          $('#off_remarks').val(d.remarks || '-');
          if (d.signoffdt) $('#signoffdt_offsigner').val(d.signoffdt);
          // Replacement Rank = rank yang turun (dari kontrak off-signer), tampil di input disabled
          var rankName = (d.rank && d.rank !== '-') ? d.rank : '';
          $('#replacement_rank').val(rankName);
          $('#replacement_rank_display').val(rankName);
          $panel.show();
        } else {
          alert(res.message || 'No contract found');
        }
      })
      .fail(function() {
        alert('Failed to load contract');
      });
  });

  // Month → Calculate Est. Sign off
  $('#btnCalculate').on('click', function() {
    var signondt = $('#signondt').val();
    var months = parseInt($('#month').val(), 10);
    if (!signondt || !months || months < 1) {
      alert('Please enter Sign on Date and Month (1-24).');
      return;
    }
    var d = new Date(signondt);
    d.setMonth(d.getMonth() + months);
    $('#estsignoffdt').val(d.toISOString().slice(0, 10));
  });

  //if (!$('#signondt').val()) {
    //$('#signondt').val('<?php echo date("Y-m-d"); ?>');
  //}
  $('#signonvsl').on('change', function() {
    $('#next_vessel').val($(this).val() || '');
  });
  function syncSignoffdtOffsigner() {
    var isDoubleUp = $('input[name="is_double_up"]:checked').val() === '1';
    if (isDoubleUp) {
      $('#signoffdt_offsigner').val('');
    } else {
      var signondt = $('#signondt').val();
      if (signondt && signondt !== '0000-00-00') {
        $('#signoffdt_offsigner').val(signondt);
      }
    }
  }
  $('#signondt').on('change input', syncSignoffdtOffsigner);
  $('input[name="is_double_up"]').on('change', syncSignoffdtOffsigner);
  var isEditMode = (row !== null && row.idcrewrotation) || (batch_id && (batch_id + '').trim() !== '');
  var batchHasJoined = (batch_rows || []).some(function(r) { return (r.status || '').toUpperCase() === 'JOINED'; });
  var batchAllCancel = (batch_rows || []).length > 0 && (batch_rows || []).every(function(r) { return (r.status || '').toUpperCase() === 'CANCEL'; });

  if (isEditMode) {
    $('#statusFieldWrapper').hide();
    $('#detailFormTitle').text('Crew Rotation – Edit');
    $('#btnSaveForm').addClass('d-none');
    $('#btnUpdateForm').removeClass('d-none');
  } else {
    $('#statusFieldWrapper').hide();
    $('#detailFormTitle').text('Crew Rotation – New');
    $('#btnSaveForm').removeClass('d-none');
    $('#btnUpdateForm').addClass('d-none');
  }
  if (batchHasJoined || batchAllCancel) {
    $('#btnSaveForm').addClass('d-none');
    $('#btnUpdateForm').addClass('d-none');
  }

  if (row) {
    $('#offSignerSelect').trigger('change');
    $('#replacement_idperson').trigger('change');
  }

  function hideAllFeedback() {
    $('[id$="Feedback"]').addClass('d-none');
    $('#kdcmprec,#signondt,#signonrank,#signonvsl,#signonport,#signondesc,#estsignoffdt,#no_pkl,#replacement_idperson,#offSignerSelect,#signoffdt_offsigner')
      .removeClass('is-invalid');
  }

  function validateField(inputId, feedbackId) {
    var $input = $('#' + inputId);
    var val = $input.val();
    if (inputId === 'replacement_idperson') {
      if (Array.isArray(val)) val = val.length > 0 ? val.join(',') : '';
      else if (!val) val = '';
    } else if (Array.isArray(val)) {
      val = val.length > 0 ? val[0] : '';
    }
    if (!val || (typeof val === 'string' && val.trim() === '')) {
      $('#' + feedbackId).removeClass('d-none');
      $input.addClass('is-invalid');
      return false;
    }
    $('#' + feedbackId).addClass('d-none');
    $input.removeClass('is-invalid');
    return true;
  }

  function validateEstSignOff() {
    var signoffdt = $('#signoffdt_offsigner').val() || '';
    var estsignoffdt = $('#estsignoffdt').val() || '';
    signoffdt = signoffdt.trim();
    estsignoffdt = estsignoffdt.trim();
    if (signoffdt === '' || signoffdt === '0000-00-00') return true;
    if (estsignoffdt === '' || estsignoffdt === '0000-00-00') return true;
    if (new Date(estsignoffdt) < new Date(signoffdt)) {
      $('#estsignoffdtFeedbackDate').removeClass('d-none');
      $('#estsignoffdt').addClass('is-invalid');
      return false;
    }
    $('#estsignoffdtFeedbackDate').addClass('d-none');
    $('#estsignoffdt').removeClass('is-invalid');
    return true;
  }

  function validateOnSigner() {
    hideAllFeedback();
    var ok = true;
    var isEditMode = $('#idcrewrotation').val() !== '';
    var status = $('#status').val() || 'Submit';

    // Always required: Off-signer (idperson) and Replacement Candidate
    if (!$('#idperson').val()) {
      $('#offSignerSelectFeedback').removeClass('d-none');
      $('#offSignerSelect').addClass('is-invalid');
      ok = false;
    }
    if (!validateField('replacement_idperson', 'replacement_idpersonFeedback')) ok = false;

    // For New mode: only 2 fields mandatory (already checked above)
    // For Edit mode with status = Joined: all fields mandatory
    if (isEditMode && status === 'Joined') {
      if (!validateField('kdcmprec', 'kdcmprecFeedback')) ok = false;
      if (!validateField('signondt', 'signondtFeedback')) ok = false;
      if (!validateField('signonrank', 'signonrankFeedback')) ok = false;
      if (!validateField('signonvsl', 'signonvslFeedback')) ok = false;
      if (!validateField('signonport', 'signonportFeedback')) ok = false;
      if (!validateField('signondesc', 'signondescFeedback')) ok = false;
      if (!validateField('estsignoffdt', 'estsignoffdtFeedback')) ok = false;
      // if (!validateField('no_pkl', 'no_pklFeedback')) ok = false;
      if (!validateEstSignOff()) ok = false;
    }

    return ok;
  }

  function buildFormData() {
    var formData = new FormData(document.getElementById('crewRotationForm'));
    formData.set('idperson', $('#idperson').val());
    formData.delete('month');
    var isDoubleUp = $('input[name="is_double_up"]:checked').val() === '1';
    var signoffdtVal = isDoubleUp ? '' : ($('#signoffdt_offsigner').val() || '');
    var signoffremarkVal = $('#signoffremark_offsigner').val() || '';
    formData.set('signoffdt', signoffdtVal);
    formData.set('signoffremark', signoffremarkVal);
    formData.set('signoffdt_onsigner', $('#signoffdt_onsigner').val() || '');
    formData.set('signoffremark_onsigner', $('#signoffremark_onsigner').val() || '');
    var opt = $('input[name="foreigncrew_option"]:checked').val();
    formData.set('foreigncrew_option', opt || 'none');
    formData.set('next_vessel', $('#signonvsl').val() || '');
    formData.set('replacement_rank', ($('#replacement_rank').val() || '').trim());
    return formData;
  }

  function onSaveSuccess(r) {
    if (r.status) {
      Swal.fire({ title: r.message, icon: "success" });
      if ($('#crewRotationForm').closest('.modal').length) {
        $('#modalCrewRotationForm').modal('hide');
        $(document).trigger('crewRotationSaved');
      }
    } else {
      Swal.fire({ title: r.message || 'Error', icon: "error" });
    }
  }

  $('#btnSaveForm').off('click').on('click', function() {
    if (!validateOnSigner()) return;
    var $btn = $(this);
    if ($btn.prop('disabled')) return;
    $btn.prop('disabled', true);
    var formData = buildFormData();
    $.ajax({
      url: baseUrl + '/save_crewRotation',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function(res) { $btn.prop('disabled', false); onSaveSuccess(res); },
      error: function() { $btn.prop('disabled', false); alert('Request failed'); }
    });
  });

  $('#btnUpdateForm').off('click').on('click', function() {
    if (!validateOnSigner()) return;
    var $btn = $(this);
    if ($btn.prop('disabled')) return;
    $btn.prop('disabled', true);
    var formData = buildFormData();
    formData.set('idcrewrotation', ($('#idcrewrotation').val() || '').trim());
    formData.set('batch_id', ($('#batch_id').val() || '').trim());

    $.ajax({
      url: baseUrl + '/update_crewRotation',
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function(res) { $btn.prop('disabled', false); onSaveSuccess(res); },
      error: function() { $btn.prop('disabled', false); alert('Request failed'); }
    });
  });

  $('#crewRotationForm').on('submit', function(e) {
    e.preventDefault();
  });
})();
</script>