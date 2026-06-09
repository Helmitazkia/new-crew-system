<div class="crew-rotation-detail-content mb-0 pb-0">
  <form id="crewRotationNewForm">
    <input type="hidden" name="idcrewrotation" id="new_idcrewrotation" value="">
    <input type="hidden" name="batch_id" id="new_batch_id" value="">

    <div class="row g-3 pb-3">
      <!-- ========== SINGLE PANEL: NEW CREW ROTATION ========== -->
      <div class="col-lg-12">
        <div class="card border">
          <div class="card-header bg-primary text-white fw-semibold">
            <i class="fa fa-user-plus me-2"></i> New Crew Rotation (Sign On Only)
          </div>
          <div class="card-body">
            
            <div class="alert alert-info py-2" style="font-size: 12px;">
              <i class="fa fa-info-circle me-1"></i> Mode ini digunakan jika Anda hanya ingin memasukkan Crew baru ke kapal tanpa ada Crew yang turun (Off Signer).
            </div>

            <div class="row g-3 align-items-end">
              <div class="col-md-12">
                <label class="form-label small fw-semibold">Replacement Candidate(s) <span class="text-danger">*</span></label>
                <select name="replacement_idperson[]" id="new_replacement_idperson" class="form-control selectpicker-new" data-live-search="true" data-size="8" multiple>
                  <!-- Diisi via script -->
                </select>
                <div class="alert alert-primary py-1 px-2 mb-0 mt-1 border-0 bg-primary bg-opacity-10 text-primary" style="font-size: 11px;">
                  <i class="fa fa-lightbulb me-1"></i> <strong>Tips:</strong> Bisa pilih lebih dari satu kandidat.
                </div>
                <small id="new_replacement_idpersonFeedback" class="text-danger d-none mt-1">Replacement Candidate is required</small>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Company Name</label>
                <select name="kdcmprec" id="new_kdcmprec" class="form-control selectpicker-new" data-live-search="true" data-size="5"></select>
              </div>

              <div class="col-md-3">
                <label class="form-label small fw-semibold">Sign on Date</label>
                <input type="date" name="signondt" id="new_signondt" class="form-control form-control-sm">
              </div>

              <div class="col-md-3">
                <label class="form-label small fw-semibold">Month</label>
                <div class="d-flex gap-1 align-items-center">
                  <input type="number" id="new_month" class="form-control form-control-sm" min="1" max="24" placeholder="1-24" style="width:70px;">
                  <button type="button" class="btn btn-sm btn-primary" id="btnCalculateNew">Calculate</button>
                </div>
              </div>

              <div class="col-md-4">
                <label class="form-label small fw-semibold">Estimate Sign off Date</label>
                <input type="date" name="estsignoffdt" id="new_estsignoffdt" class="form-control form-control-sm">
                <small id="new_estsignoffdtFeedbackDate" class="text-danger d-none">Cannot be earlier than Sign on Date</small>
              </div>

              <div class="col-md-4">
                <label class="form-label small fw-semibold">Sign on Rank</label>
                <select name="signonrank_multi[]" id="new_signonrank_multi" class="form-control selectpicker-new" data-live-search="true" data-size="5" multiple>
                  <!-- Diisi via script -->
                </select>
                <div class="alert alert-secondary py-1 px-2 mb-0 mt-1 border-0 bg-secondary bg-opacity-10 text-secondary" style="font-size: 11px;">
                  Urutan Rank sesuai dengan urutan Candidate.
                </div>
                <small id="new_signonrankMatchFeedback" class="text-danger d-none">Jumlah Rank harus sama dengan jumlah Candidate</small>
              </div>

              <div class="col-md-4">
                <label class="form-label small fw-semibold">Sign on Vessel</label>
                <select name="signonvsl" id="new_signonvsl" class="form-control selectpicker-new" data-live-search="true" data-size="5"></select>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Sign on Port</label>
                <input type="text" name="signonport" id="new_signonport" class="form-control form-control-sm" placeholder="e.g. BENOA">
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-semibold">Last Vessel</label>
                <select name="lastvsl" id="new_lastvsl" class="form-control selectpicker-new" data-live-search="true" data-size="5"></select>
              </div>

              <div class="col-12">
                <label class="form-label small fw-semibold">Sign on Description</label>
                <textarea name="signondesc" id="new_signondesc" class="form-control form-control-sm" rows="2" placeholder="e.g. Joining as AB"></textarea>
              </div>

              <div class="col-md-4">
                <label class="form-label small fw-semibold">No. PKL</label>
                <input type="text" name="no_pkl" id="new_no_pkl" class="form-control form-control-sm">
                <small id="new_no_pklFeedback" class="text-danger d-none">No. PKL is required</small>
              </div>

              <div class="col-md-4">
                <label class="form-label small fw-semibold">Remarks</label>
                <input type="text" name="estremark" id="new_estremark" class="form-control form-control-sm">
                <small id="new_estremarkFeedback" class="text-danger d-none">Remarks is required</small>
              </div>

              <div class="col-md-4 d-none">
                <label class="form-label small fw-semibold">Next Vessel Plan</label>
                <select name="next_vessel" id="new_next_vessel" class="form-control selectpicker-new" data-live-search="true" data-size="5"></select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal-footer d-flex justify-content-end bg-light">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
    <i class="fa fa-times"></i> Close
  </button>
  <button type="button" class="btn btn-success" id="btnSaveNewCrewRotation">
    <i class="fa fa-save"></i> Save Rotation
  </button>
</div>

<script>
  $(document).ready(function() {
    var isEditMode = false;

    // --- 1. Ambil Data JSON dari Controller ---
    var dataCompany = <?php echo isset($optionsCompanyJson) ? $optionsCompanyJson : '[]'; ?>;
    var dataRank = <?php echo isset($optionsRankJson) ? $optionsRankJson : '[]'; ?>;
    var dataVessel = <?php echo isset($optionsVesselJson) ? $optionsVesselJson : '[]'; ?>;
    var dataPersonActive = <?php echo isset($optionsPersonActiveRosterJson) ? $optionsPersonActiveRosterJson : '[]'; ?>;
    
    var existingRow = <?php echo isset($row) && $row ? json_encode($row) : 'null'; ?>;
    var batchRows = <?php echo isset($batch_rows) && $batch_rows ? json_encode($batch_rows) : '[]'; ?>;
    var batchId = <?php echo isset($batch_id) ? json_encode($batch_id) : '""'; ?>;

    if (existingRow && existingRow.idcrewrotation) {
      isEditMode = true;
      $('#new_idcrewrotation').val(existingRow.idcrewrotation);
      $('#new_batch_id').val(batchId);
    }

    // --- 2. Fungsi Populate Dropdown ---
    function populateDropdown(selId, dataArray) {
      var $sel = $(selId);
      $sel.empty();
      
      var cleanArray = (dataArray || []).filter(function(item) {
        return item.value !== '';
      });

      if (!$sel.prop('multiple')) {
        $sel.append('<option value="" class="fw-bold text-dark">- Select -</option>');
      }
      
      $.each(cleanArray, function(i, item) {
        $sel.append('<option value="' + item.value + '" class="fw-bold text-dark">' + item.text + '</option>');
      });
    }

    populateDropdown('#new_kdcmprec', dataCompany);
    populateDropdown('#new_signonrank_multi', dataRank);
    populateDropdown('#new_signonvsl', dataVessel);
    populateDropdown('#new_lastvsl', dataVessel);
    populateDropdown('#new_next_vessel', dataVessel);
    
    function computeStatusFromRow(row) {
      if (row.newapplicent == '1') return 'Stand By';
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

    var dataPersonStandBy = [];
    (dataPersonActive || []).forEach(function(o) {
      if (!o.value) return;
      var status = computeStatusFromRow(o);
      if (status !== 'On board') {
        dataPersonStandBy.push({ value: o.value, text: o.text });
      }
    });

    // Termasuk candidate yang sudah di-save sebelumnya meskipun statusnya berubah
    var standByIds = {};
    dataPersonStandBy.forEach(function(o) { standByIds[o.value] = true; });
    (batchRows || []).forEach(function(r) {
      var rid = r.replacement_idperson;
      if (rid != null && rid !== '' && !standByIds[rid]) {
        var text = (r.replacement_name || '') ? (r.replacement_name + ' (' + rid + ')') : ('(' + rid + ')');
        dataPersonStandBy.push({ value: rid.toString(), text: text });
        standByIds[rid] = true;
      }
    });

    populateDropdown('#new_replacement_idperson', dataPersonStandBy);

    // --- 3. Isi Data Jika Edit ---
    if (isEditMode) {
      var rids = [];
      var sranks = [];
      if (batchRows.length > 0 && batchId !== '') {
        $.each(batchRows, function(i, br) {
          if (br.replacement_idperson && br.deletests !== '1') {
            rids.push(br.replacement_idperson);
            if (br.signonrank) sranks.push(br.signonrank);
          }
        });
      } else {
        if (existingRow.replacement_idperson) rids.push(existingRow.replacement_idperson);
        if (existingRow.signonrank) sranks.push(existingRow.signonrank);
      }

      $('#new_replacement_idperson').val(rids);
      $('#new_kdcmprec').val(existingRow.kdcmprec);
      
      var sdt = existingRow.signondt;
      if (sdt && sdt !== '0000-00-00') $('#new_signondt').val(sdt.substring(0,10));
      var edt = existingRow.estsignoffdt;
      if (edt && edt !== '0000-00-00') $('#new_estsignoffdt').val(edt.substring(0,10));

      $('#new_signonrank_multi').val(sranks);
      $('#new_signonvsl').val(existingRow.signonvsl);
      $('#new_signonport').val(existingRow.signonport);
      $('#new_lastvsl').val(existingRow.lastvsl);
      $('#new_signondesc').val(existingRow.signondesc);
      $('#new_no_pkl').val(existingRow.no_pkl);
      $('#new_estremark').val(existingRow.estremark);
      $('#new_next_vessel').val(existingRow.next_vessel);
    }

    // Initialise selectpicker
    $('.selectpicker-new').selectpicker({
      style: 'btn-outline-secondary btn-sm',
      size: 5
    });

    // --- 4. Logic Calculator ---
    $('#btnCalculateNew').on('click', function() {
      var sdt = $('#new_signondt').val();
      var m = parseInt($('#new_month').val());
      if (!sdt) {
        Swal.fire("Info", "Pilih Sign on Date terlebih dahulu", "info");
        return;
      }
      if (!m || m < 1) {
        Swal.fire("Info", "Masukkan Month minimal 1", "info");
        return;
      }
      var d = new Date(sdt);
      d.setMonth(d.getMonth() + m);
      var mStr = (d.getMonth() + 1).toString().padStart(2, '0');
      var dStr = d.getDate().toString().padStart(2, '0');
      var yStr = d.getFullYear();
      $('#new_estsignoffdt').val(yStr + '-' + mStr + '-' + dStr);
    });

    // --- 5. Validasi & Submit ---
    function validateFormNew() {
      var isValid = true;
      $('#crewRotationNewForm small.text-danger').addClass('d-none');
      $('#crewRotationNewForm .is-invalid').removeClass('is-invalid');

      var reqObj = {
        '#new_replacement_idperson': '#new_replacement_idpersonFeedback'
      };

      $.each(reqObj, function(id, fbId) {
        var val = $(id).val();
        if (!val || (Array.isArray(val) && val.length === 0)) {
          $(id).addClass('is-invalid');
          $(id).siblings('.dropdown-toggle').addClass('is-invalid');
          $(fbId).removeClass('d-none');
          isValid = false;
        }
      });

      var sdt = $('#new_signondt').val();
      var edt = $('#new_estsignoffdt').val();
      if (sdt && edt && new Date(sdt) > new Date(edt)) {
        $('#new_estsignoffdt').addClass('is-invalid');
        $('#new_estsignoffdtFeedbackDate').removeClass('d-none');
        isValid = false;
      }

      var repl = $('#new_replacement_idperson').val() || [];
      var sranks = $('#new_signonrank_multi').val() || [];
      if (repl.length > 0 && sranks.length > 0 && repl.length !== sranks.length) {
        $('#new_signonrank_multi').siblings('.dropdown-toggle').addClass('is-invalid');
        $('#new_signonrankMatchFeedback').removeClass('d-none');
        isValid = false;
      }

      return isValid;
    }

    $('#btnSaveNewCrewRotation').on('click', function() {
      if (!validateFormNew()) {
        Swal.fire("Warning", "Lengkapi kolom yang wajib diisi dengan benar.", "warning");
        return;
      }

      var formData = $('#crewRotationNewForm').serializeArray();
      var url = isEditMode 
          ? baseUrlCrewRotation.replace('/CrewRotation/CrewRotation', '') + '/CrewRotation/CrewRotation_New/update_new_type'
          : baseUrlCrewRotation.replace('/CrewRotation/CrewRotation', '') + '/CrewRotation/CrewRotation_New/save_new_type';

      var $btn = $(this);
      $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

      $.ajax({
        url: url,
        type: 'POST',
        data: $.param(formData),
        dataType: 'json',
        success: function(r) {
          $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Save Rotation');
          if (r.status) {
            Swal.fire('Sukses', r.message, 'success');
            $('#modalCrewRotationForm').modal('hide');
            $(document).trigger('crewRotationSaved');
          } else {
            Swal.fire('Gagal', r.message || 'Gagal menyimpan data.', 'error');
          }
        },
        error: function(xhr) {
          $btn.prop('disabled', false).html('<i class="fa fa-save"></i> Save Rotation');
          Swal.fire('Error', xhr.responseText || 'Request failed.', 'error');
        }
      });
    });

  });
</script>
