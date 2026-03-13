<div class="content-traning">
  <div class="row">
    <!-- =========================
     LEFT : ASSESSMENT & TRAINING
     ========================= -->
    <div class="col-6 mb-4">
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
              <label class="form-label mb-0 fst-italic fw-semibold">OTG</label>
              <div class="form-view fst-italic" data-field="scor_otg"></div>
              <input type="number" name="scor_otg" id="scor_otg" maxlength="20" class="form-control form-edit d-none" data-field="scor_otg" placeholder="">
            </div>

            <div class="col-md-6">
              <label class="form-label mb-0 fst-italic fw-semibold">Training Date</label>
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
     RIGHT : TRAINING LIST
     ========================= -->
    <div class="col-6 mb-4">
      <div class="card shadow-sm h-100">

        <div class="card-header d-flex justify-content-between align-items-center">
          <div class="col-4">
            <span class="fw-semibold fst-italic">📚 Training List</span>
          </div>
          <div class="col-8">
            <div class="input-group">
              <input type="text" class="form-control form-control-sm w-50" aria-label="Recipient's username"
                aria-describedby="button-addon2">
              <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
            </div>
          </div>
        </div>
        <br>


        <div class="card-body p-0">
          <div class="table-responsive" style="max-height:420px; overflow-y:auto;">
            <table class="table table-sm table-bordered mb-0 training-table">
              <thead class="table-light sticky-top">
                <tr>
                  <th width="70%" class="text-center fst-italic" style="background-color:#000099; color:#FFFFFF;">
                    Training Name
                  </th>
                  <th width="30%" class="text-center fst-italic" style="background-color:#000099; color:#FFFFFF;">
                    Completed
                  </th>
                </tr>

              </thead>
              <tbody id="trainingTableBody">
                <tr>
                  <td>PERSONAL SAFETY</td>
                  <td class="text-center"><input type="checkbox" checked></td>
                </tr>
                <tr>
                  <td>ISM CODE</td>
                  <td class="text-center"><input type="checkbox"></td>
                </tr>
                <tr>
                  <td>PORT STATE CONTROL INSPECTIONS</td>
                  <td class="text-center"><input type="checkbox" checked></td>
                </tr>
                <tr>
                  <td>SECURITY AWARENESS</td>
                  <td class="text-center"><input type="checkbox"></td>
                </tr>
                <tr>
                  <td>RISK ASSESSMENT AND MANAGEMENT</td>
                  <td class="text-center"><input type="checkbox" checked></td>
                </tr>
                <tr>
                  <td>AWARENESS OF LIFEBOAT RELEASE AND RETRIEVAL SYSTEMS</td>
                  <td class="text-center"><input type="checkbox"></td>
                </tr>
                <tr>
                  <td>CYBER WELLNESS</td>
                  <td class="text-center"><input type="checkbox"></td>
                </tr>
                <tr>
                  <td>PIRACY AND ARMED ROBBERY 1</td>
                  <td class="text-center"><input type="checkbox" checked></td>
                </tr>
                <tr>
                  <td>PERSONAL SURVIVAL, SURVIVAL CRAFT</td>
                  <td class="text-center"><input type="checkbox"></td>
                </tr>
                <tr>
                  <td>PERSONAL SURVIVAL, RESCUE AND ABANDONING SHIP</td>
                  <td class="text-center"><input type="checkbox" checked></td>
                </tr>
                <tr>
                  <td>BEHAVIOR BASED SAFETY</td>
                  <td class="text-center"><input type="checkbox"></td>
                </tr>
                <tr>
                  <td>INCIDENT INVESTIGATION, CAUSE AND EFFECT</td>
                  <td class="text-center"><input type="checkbox"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>

<script>
  var baseUrlTraining = "<?php echo base_url('CrewDetail/Traning'); ?>";
  var alert_success = $('#training-success-alert');
  var alert_error = $('#training-danger-alert');
  var success_message = $('#training-success-message');
  var error_message = $('#training-error-message');

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

  $(document).ready(function () {
    loadTrainingData();
  });
</script>