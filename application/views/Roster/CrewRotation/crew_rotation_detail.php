<div class="crew-rotation-detail-content mb-0 pb-0">
  <form id="crewRotationForm">
        <input type="hidden" name="idcrewrotation" id="idcrewrotation" value="">
        <input type="hidden" name="idperson" id="idperson" value="">

        <div class="row g-3 pb-3">
          <!-- ========== LEFT: OFF-SIGNER ========== -->
          <div class="col-lg-4">
            <div class="card h-100 border">
              <div class="card-header bg-light fw-semibold fst-italic">Off Signer (yang turun)</div>
              <div class="card-body">
                <div class="d-flex align-items-center gap-2 mb-2">
                  <div class="rounded bg-primary bg-opacity-25 d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                    <i class="fa fa-user text-primary"></i>
                  </div>
                  <div class="flex-grow-1">
                    <label class="form-label mb-0 small fw-semibold">Name <span class="text-danger">*</span></label>
                    <!-- <input type="text" id="offSignerSearch" class="form-control form-control-sm" placeholder="Search name..." autocomplete="off"> -->
                    <select id="offSignerSelect" class="form-control selectpicker-on" style="max-height:120px;" data-live-search="true" data-size="5">
                      <option value="">- Select crew -</option>
                    </select>
                    <small id="offSignerSelectFeedback" class="text-danger d-none">Name is required</small>
                  </div>
                  <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" id="changeOffSigner" title="Change Off-signer">
                    <label class="form-check-label small" for="changeOffSigner">Change Off-signer</label>
                  </div>
                </div>
                <div id="offSignerContractPanel" class="small" style="display:none;">
                  <div class="row g-2 border-top pt-2">
                    <div class="col-6 mb-2">
                      <label class="form-label mb-0">Rank</label>
                      <input type="text" id="off_rank" class="form-control form-control-sm bg-light" disabled value="">
                    </div>
                    <div class="col-6 mb-2">
                      <label class="form-label mb-0">Planned Sign-off</label>
                      <input type="text" id="off_planned_signoff" class="form-control form-control-sm bg-light" disabled value="">
                    </div>
                    <div class="col-6 mb-2">
                      <label class="form-label mb-0">Relieving Port</label>
                      <input type="text" id="off_relieving_port" class="form-control form-control-sm bg-light" disabled value="">
                    </div>
                    <div class="col-6 mb-2">
                      <label class="form-label mb-0">Payscale</label>
                      <input type="text" id="off_payscale" class="form-control form-control-sm bg-light" disabled value="">
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
                <div class="row g-2">
                  <div class="col-md-6 mb-2">
                    <label class="form-label small fw-semibold">Replacement Candidate <span class="text-danger">*</span></label>
                    <select name="replacement_idperson" id="replacement_idperson" class="form-select selectpicker-on" data-live-search="true" data-size="5"></select>
                    <small id="replacement_idpersonFeedback" class="text-danger d-none">Replacement Candidate is required</small>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label class="form-label small fw-semibold">Replacement Rank</label>
                    <input type="text" name="replacement_rank" id="replacement_rank" class="form-control form-control-sm">
                  </div>
                  <div class="col-md-6 mb-2">
                    <label class="form-label small fw-semibold">Company Name <span class="text-danger">*</span></label>
                    <select name="kdcmprec" id="kdcmprec" class="form control selectpicker-on" data-live-search="true" data-size="5"></select>
                    <small id="kdcmprecFeedback" class="text-danger d-none">Company Name is required</small>
                  </div>
                  <div class="col-md-3 mb-2">
                    <label class="form-label small fw-semibold">Sign on Date <span class="text-danger">*</span></label>
                    <input type="date" name="signondt" id="signondt" class="form-control form-control-sm">
                    <small id="signondtFeedback" class="text-danger d-none">Sign on Date is required</small>
                  </div>
                  <div class="col-md-3 mb-2">
                    <label class="form-label small fw-semibold">Month</label>
                    <div class="d-flex gap-1 align-items-center">
                      <input type="number" id="month" class="form-control form-control-sm" min="1" max="24" placeholder="1-24" style="width:70px;">
                      <button type="button" class="btn btn-sm btn-primary" id="btnCalculate">Calculate</button>
                    </div>
                  </div>
                  <div class="col-md-4 mb-2">
                    <label class="form-label small fw-semibold">Estimate Sign off Date <span class="text-danger">*</span></label>
                    <input type="date" name="estsignoffdt" id="estsignoffdt" class="form-control form-control-sm">
                    <small id="estsignoffdtFeedback" class="text-danger d-none">Estimate Sign off Date is required</small>
                    <small id="estsignoffdtFeedbackDate" class="text-danger d-none">Cannot be earlier than Sign off Date</small>
                  </div>
                  <div class="col-md-4 mb-2">
                    <label class="form-label small fw-semibold">Sign on Rank <span class="text-danger">*</span></label>
                    <select name="signonrank" id="signonrank" class="form control selectpicker-on" data-live-search="true" data-size="5"></select>
                    <small id="signonrankFeedback" class="text-danger d-none">Sign on Rank is required</small>
                  </div>
                  <div class="col-md-4 mb-2">
                    <label class="form-label small fw-semibold">Sign on Vessel <span class="text-danger">*</span></label>
                    <select name="signonvsl" id="signonvsl" class="form control selectpicker-on" data-live-search="true" data-size="5"></select>
                    <small id="signonvslFeedback" class="text-danger d-none">Sign on Vessel is required</small>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label class="form-label small fw-semibold">Sign on Port <span class="text-danger">*</span></label>
                    <input type="text" name="signonport" id="signonport" class="form-control form-control-sm" placeholder="e.g. BENOA">
                    <small id="signonportFeedback" class="text-danger d-none">Sign on Port is required</small>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label class="form-label small fw-semibold">Last Vessel</label>
                    <select name="lastvsl" id="lastvsl" class="form control selectpicker-on" data-live-search="true" data-size="5">
                      <option value="">- Select -</option>
                    </select>
                  </div>
                  <div class="col-12 mb-2">
                    <label class="form-label small fw-semibold">Sign on Description <span class="text-danger">*</span></label>
                    <textarea name="signondesc" id="signondesc" class="form-control form-control-sm" rows="2" placeholder="e.g. Joining as AB"></textarea>
                    <small id="signondescFeedback" class="text-danger d-none">Sign on Description is required</small>
                  </div>
                  <div class="col-md-4 mb-2">
                    <label class="form-label small fw-semibold">No. PKL <span class="text-danger">*</span></label>
                    <input type="text" name="no_pkl" id="no_pkl" class="form-control form-control-sm">
                    <small id="no_pklFeedback" class="text-danger d-none">No. PKL is required</small>
                  </div>
                  <div class="col-md-4 mb-2">
                    <label class="form-label small fw-semibold">Remarks</label>
                    <textarea name="estremark" id="estremark" class="form-control form-control-sm" rows="2"></textarea>
                  </div>
                  <div class="col-md-4 mb-2">
                    <label class="form-label small fw-semibold">Sign off Date</label>
                    <input type="date" name="signoffdt" id="signoffdt" class="form-control form-control-sm">
                  </div>
                  <div class="col-md-6 mb-2">
                    <label class="form-label small fw-semibold">Sign off remarks</label>
                    <select name="signoffremark" id="signoffremark" class="form-select selectpicker-on" data-live-search="true" data-size="5"></select>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label class="form-label small fw-semibold">Additional / Foreign Crew</label>
                    <div class="d-flex gap-3 flex-wrap pt-1">
                      <label class="d-flex align-items-center gap-1 mb-0 small">
                        <input type="radio" name="foreigncrew_option" value="none" class="form-check-input" checked> None
                      </label>
                      <label class="d-flex align-items-center gap-1 mb-0 small">
                        <input type="radio" name="foreigncrew_option" value="additional" class="form-check-input"> Additional
                      </label>
                      <label class="d-flex align-items-center gap-1 mb-0 small">
                        <input type="radio" name="foreigncrew_option" value="foreigncrew" class="form-check-input"> Foreign Crew
                      </label>
                    </div>
                  </div>
                  <div class="col-12 mb-2">
                    <label class="form-label small fw-semibold">File Contract</label>
                    <div class="d-flex gap-2 align-items-center">
                      <input type="file" name="file_contract" id="file_contract" class="form-control form-control-sm" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif" style="max-width:220px;">
                      <span class="small text-muted" id="file_contract_label">No file selected</span>
                      <button type="button" class="btn btn-sm btn-warning" id="btnClearFile">Clear</button>
                    </div>
                  </div>
                  <div class="col-12 mb-2" id="statusFieldWrapper" style="display:none;">
                    <label class="form-label small fw-semibold">Status</label>
                    <select name="status" id="status" class="form-select">
                      <option value="Submit">Submit</option>
                      <option value="Joined">Joined</option>
                    </select>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label class="form-label small fw-semibold">Next Vessel</label>
                    <input type="text" name="next_vessel" id="next_vessel" class="form-control form-control-sm">
                  </div>
                  <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary px-4 rounded-pill fw-semibold" id="btnSubmitForm">
                      <i class="fa fa-paper-plane me-1"></i> <span id="btnSubmitText">Submit</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
</div>

<!-- <style>
  .crew-rotation-detail-content .card.border { border-color: #dee2e6 !important; }
  .crew-rotation-detail-content .form-label.small { font-size: 0.875rem; }
  .crew-rotation-detail-content { padding: 0; }
</style> -->

<script>
(function () {
  var baseUrl = "<?php echo base_url('CrewRotation/CrewRotation'); ?>";
  var optionsCompany = <?php echo isset($optionsCompanyJson) ? $optionsCompanyJson : '[]'; ?>;
  var optionsRank = <?php echo isset($optionsRankJson) ? $optionsRankJson : '[]'; ?>;
  var optionsVessel = <?php echo isset($optionsVesselJson) ? $optionsVesselJson : '[]'; ?>;
  var optionsSignOffRemark = <?php echo isset($optionsSignOffRemarkJson) ? $optionsSignOffRemarkJson : '[]'; ?>;
  var optionsPerson = <?php echo isset($optionsPersonJson) ? $optionsPersonJson : '[]'; ?>;

  function fillSelect($el, arr) {
    $el.empty().append($('<option value="">- Select -</option>'));
    (arr || []).forEach(function (o) {
      if (o.value === '') return;
      $el.append($('<option></option>').val(o.value).text(o.text));
    });
  }

  // Off-signer: plain select (single only) + search input to filter options
  var $offSelect = $('#offSignerSelect');
  var $offSearch = $('#offSignerSearch');
  $offSelect.empty().append($('<option value="">- Select crew -</option>'));
  optionsPerson.forEach(function (o) {
    if (o.value) $offSelect.append($('<option></option>').val(o.value).text(o.text));
  });
  var allPersonOptions = optionsPerson.slice();
  function filterOffSignerOptions() {
    var q = $offSearch.val().toLowerCase().trim();
    var currentVal = $offSelect.val();
    $offSelect.empty().append($('<option value="">- Select crew -</option>'));
    allPersonOptions.forEach(function (o) {
      if (!o.value) return;
      if (!q || o.text.toLowerCase().indexOf(q) >= 0) {
        $offSelect.append($('<option></option>').val(o.value).text(o.text));
      }
    });
    if (currentVal && $offSelect.find('option[value="' + currentVal + '"]').length) {
      $offSelect.val(currentVal);
    }
  }
  $offSearch.on('keyup', filterOffSignerOptions);

  fillSelect($('#kdcmprec'), optionsCompany);
  fillSelect($('#signonrank'), optionsRank);
  fillSelect($('#signonvsl'), optionsVessel);
  fillSelect($('#signoffremark'), optionsSignOffRemark);
  fillSelect($('#lastvsl'), optionsVessel);
  fillSelect($('#replacement_idperson'), optionsPerson);

  $('.selectpicker-on').each(function () {
    if ($.fn.selectpicker) $(this).selectpicker({ noneSelectedText: '- Select -', liveSearch: true, size: 5 });
  });

  $('#file_contract').on('change', function () {
    var fn = $(this).val().split(/\\/).pop();
    $('#file_contract_label').text(fn || 'No file selected');
  });
  $('#btnClearFile').on('click', function () {
    $('#file_contract').val('');
    $('#file_contract_label').text('No file selected');
  });

  // When Off-signer selected → load contract (single value only)
  $offSelect.on('change', function () {
    var idperson = $(this).val();
    if (Array.isArray(idperson)) idperson = idperson[0];
    idperson = idperson || '';
    $('#idperson').val(idperson);
    if (!idperson) {
      $('#offSignerContractPanel').hide();
      return;
    }
    var $panel = $('#offSignerContractPanel');
    $panel.hide();
    $.get(baseUrl + '/getContractByPerson', { idperson: idperson })
      .done(function (res) {
        if (res.success && res.data) {
          var d = res.data;
          $('#off_rank').val(d.rank || '-');
          $('#off_planned_signoff').val(d.planned_signoff || '-');
          $('#off_relieving_port').val(d.relieving_port || '-');
          $('#off_payscale').val(d.payscale || '-');
          $('#off_status').val(d.status || '-');
          $('#off_eoc').val(d.eoc || '-');
          $('#off_remarks').val(d.remarks || '-');
          $panel.show();
        } else {
          alert(res.message || 'No contract found');
        }
      })
      .fail(function () {
        alert('Failed to load contract');
      });
  });

  $('#changeOffSigner').on('change', function () {
    var allowChange = $(this).prop('checked');
    $offSelect.prop('disabled', !allowChange);
    $offSearch.prop('disabled', !allowChange);
    if (!allowChange) {
      $offSearch.val('');
      filterOffSignerOptions();
    }
  });

  // Month → Calculate Est. Sign off
  $('#btnCalculate').on('click', function () {
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

  if (!$('#signondt').val()) {
    $('#signondt').val('<?php echo date("Y-m-d"); ?>');
  }
  var row = <?php echo isset($row) && $row ? json_encode($row) : 'null'; ?>;
  var isEditMode = row !== null && row.idcrewrotation;
  
  // Show/hide status field: hidden for New, visible for Edit
  if (isEditMode) {
    $('#statusFieldWrapper').show();
    $('#detailFormTitle').text('Crew Rotation – Edit');
    $('#btnSubmitText').text('Update');
  } else {
    $('#statusFieldWrapper').hide();
    $('#detailFormTitle').text('Crew Rotation – New');
    $('#btnSubmitText').text('Submit');
  }
  
  if (row) {
    $('#idcrewrotation').val(row.idcrewrotation || '');
    $('#idperson').val(row.idperson || '');
    $offSelect.val(row.idperson || '');
    $offSelect.trigger('change');
    $('#kdcmprec').val(row.kdcmprec || '');
    $('#signondt').val((row.signondt && row.signondt !== '0000-00-00') ? row.signondt : '');
    $('#signoffdt').val((row.signoffdt && row.signoffdt !== '0000-00-00') ? row.signoffdt : '');
    $('#estsignoffdt').val((row.estsignoffdt && row.estsignoffdt !== '0000-00-00') ? row.estsignoffdt : '');
    $('#signonrank').val(row.signonrank || '');
    $('#signonvsl').val(row.signonvsl || '');
    $('#signonport').val(row.signonport || '');
    $('#signondesc').val(row.signondesc || '');
    $('#lastvsl').val(row.lastvsl || '');
    $('#no_pkl').val(row.no_pkl || '');
    $('#estremark').val(row.estremark || '');
    $('#signoffremark').val(row.signoffremark || '');
    $('#replacement_idperson').val(row.replacement_idperson || '');
    $('#replacement_rank').val(row.replacement_rank || '');
    $('#status').val(row.status || 'Submit');
    $('#next_vessel').val(row.next_vessel || '');
    if ($.fn.selectpicker) {
      $('#kdcmprec,#signonrank,#signonvsl,#signoffremark,#lastvsl,#replacement_idperson').selectpicker('refresh');
    }
    $('#changeOffSigner').prop('checked', false);
    $offSelect.prop('disabled', true);
    $offSearch.prop('disabled', true);
  }

  function hideAllFeedback() {
    $('[id$="Feedback"]').addClass('d-none');
    $('#kdcmprec,#signondt,#signonrank,#signonvsl,#signonport,#signondesc,#estsignoffdt,#no_pkl,#replacement_idperson,#offSignerSelect').removeClass('is-invalid');
  }
  function validateField(inputId, feedbackId) {
    var $input = $('#' + inputId);
    var val = $input.val();
    // Handle select field (bootstrap-select might return array)
    if (Array.isArray(val)) {
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
    var signoffdt = $('#signoffdt').val() || '';
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
      if (!validateField('no_pkl', 'no_pklFeedback')) ok = false;
      if (!validateEstSignOff()) ok = false;
    }
    
    return ok;
  }

  // Back to List button - tidak ada lagi karena card header sudah dihapus

  $('#crewRotationForm').on('submit', function (e) {
    e.preventDefault();
    if (!validateOnSigner()) return;
    var idcrewrotation = $('#idcrewrotation').val();
    var isUpdate = idcrewrotation !== '';
    var url = isUpdate ? baseUrl + '/update_crewRotation' : baseUrl + '/save_crewRotation';
    var formData = new FormData(this);
    formData.set('idperson', $('#idperson').val());
    formData.delete('month');
    var opt = $('input[name="foreigncrew_option"]:checked').val();
    formData.set('foreigncrew_option', opt || 'none');

    $.ajax({
      url: url,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      dataType: 'json',
      success: function (r) {
        if (r.status) {
          alert(r.message || 'Saved.');
          // Jika di modal, tutup modal dan reload table. Jika di halaman terpisah, kembali ke list.
          if ($('#crewRotationForm').closest('.modal').length) {
            $('#modalCrewRotationForm').modal('hide');
            // Trigger event untuk reload table (akan di-handle di crew_rotation.php)
            $(document).trigger('crewRotationSaved');
          } else {
            $.get(baseUrl + '/ajaxCrewRotation', function (html) {
              $('#contentArea').html(html);
            });
          }
        } else {
          alert(r.message || 'Failed.');
        }
      },
      error: function () {
        alert('Request failed');
      }
    });
  });
})();
</script>
