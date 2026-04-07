<div class="content-compotents">
  <!-- Alert Messages -->
  <div class="alert alert-success d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none" role="alert" id="comp-success-alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill" /></svg>
    <div class="flex-grow-1"><span id="comp-success-message"></span></div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <div class="alert alert-danger d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none" role="alert" id="comp-error-alert">
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill" /></svg>
    <div class="flex-grow-1"><span id="comp-error-message"></span></div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>

  <div class="row">
    <!-- =========================
     LEFT : CERTIFICATES (VIEW ONLY)
     ========================= -->
    <div class="col-md-5 mb-4">
      <div class="card shadow-sm h-100">
        <div class="card-header py-2">
          <span class="fw-semibold fst-italic">📜 List Certificates</span>
        </div>
        <div class="card-body p-2">
          <div class="table-responsive">
            <table id="compCertificatesTable" class="table table-sm table-bordered mb-0 crew-table" style="width:100%">
              <thead class="crew-header">
                <tr>
                  <th class="text-center" style="width:10%;">No</th>
                  <th class="text-left" style="width:45%;">Certificate Name</th>
                  <th class="text-center" style="width:25%;">Expiry Date</th>
                  <!-- <th class="text-center" style="width:20%;">Display</th> -->
                </tr>
              </thead>
              <tbody style="font-size:13px;"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- =========================
     RIGHT : PLANNED TRAINING (CRUD)
     ========================= -->
    <div class="col-md-7 mb-4">
      <div class="card shadow-sm h-100">
        <div class="card-header d-flex justify-content-between align-items-center py-2">
          <span class="fw-semibold fst-italic">📚 Competence List</span>
          <button type="button" class="btn btn-primary btn-sm rounded-pill fst-italic" id="btnNewCompTrainingMatrix"><i class="fa fa-plus"></i> New</button>
        </div>
        <div class="card-body p-2">
          <div class="table-responsive">
            <table id="compTrainingMatrixTable" class="table table-sm table-bordered mb-0" style="width:100%">
              <thead class="crew-header">
                <tr>
                  <th style="width:10%;" class="text-center">No</th>
                  <th style="width:60%;" class="text-center">Competence Name</th>
                  <th style="width:15%;" class="text-center">Completed</th>
                  <th style="width:15%;" class="text-center">Action</th>
                </tr>
              </thead>
              <tbody style="font-size:13px;"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Add/Edit Training List (Matrix) -->
<div class="modal fade" id="compTrainingMatrixModal" tabindex="-1">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#000099;">
        <h5 class="modal-title" id="compTrainingMatrixModalTitle">Add List Competence</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="compTrainingMatrixForm">
          <input type="hidden" name="idcrewtraining_matrix" id="comp_idcrewtraining_matrix">
          <input type="hidden" name="idperson" id="comp_idperson_matrix" value="">
          <div class="mb-2">
            <label class="form-label mb-0 fst-italic fw-semibold">Competence Name <span class="text-danger">*</span></label>
            <select name="cert_matrix_id" id="comp_cert_matrix_id" class="form-control selectpicker" data-live-search="true" data-size="8"></select>
            <small id="comp_cert_matrix_id_fb" class="text-danger d-none">Competence Name is required</small>
          </div>
          <div class="mb-2 form-check">
            <input type="checkbox" class="form-check-input" id="comp_completed_matrix" name="completed" value="1">
            <label class="form-check-label" for="comp_completed_matrix">Completed</label>
          </div>
          <div class="mb-2">
            <label class="form-label mb-0 fst-italic fw-semibold">Remarks</label>
            <textarea name="remarks" id="comp_remarks_matrix" class="form-control" rows="2" maxlength="500" ></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="btnSaveCompTrainingMatrix">Save</button>
        <button type="button" class="btn btn-warning d-none" id="btnUpdateCompTrainingMatrix">Update</button>
      </div>
    </div>
  </div>
</div>

<style>
  .crew-table th, .crew-table td { font-size: 12px; vertical-align: middle; }
  .crew-table th { font-weight: 600; }
  .crew-header th { background-color: #000099 !important; color: #fff !important; }
</style>

<script>
  var baseUrlCompotents = "<?php echo base_url('CrewDetail/Compotents'); ?>";
  var baseUrlUploadCert = "<?php echo base_url('uploadCertificate'); ?>";
  var optionsCompCertMatrix = <?php echo isset($optionsCertificateMatrixJson) ? $optionsCertificateMatrixJson : '[]'; ?>;

  var alert_success_comp = $('#comp-success-alert');
  var alert_error_comp = $('#comp-error-alert');
  var success_message_comp = $('#comp-success-message');
  var error_message_comp = $('#comp-error-message');

  $(document).ready(function () {
    var idperson = $('#contentArea').data('idperson');
    if (!idperson) return;

    // ==========================================
    // 1. LEFT SIDE: CERTIFICATES DATATABLE
    // ==========================================
    var compCertificatesTable = $('#compCertificatesTable').DataTable({
      processing: true,
      serverSide: false,
      searching: true,
      paging: true,
      info: true,
      pageLength: 5,
      lengthMenu: [5,10, 25, 50, 100],
      ajax: {
        url: baseUrlCompotents + "/get_certificates",
        type: "GET",
        data: { idperson: idperson },
        dataSrc: function(json) {
          if (json.success) return json.data;
          return [];
        }
      },
      columns: [
        {
          data: null, className: 'text-center', orderable: false,
          render: function(data, type, row, meta) { return meta.row + 1; }
        },
        {
          data: 'certificate_name', className: 'text-left',
          render: function(data, type, row) {
            if (row.certificate_file) {
              return '<a href="' + baseUrlUploadCert + '/' + row.certificate_file + '" target="_blank" style="color: black; text-decoration: none;">' + data + '</a>';
            }
            return data;
          }
        },
        {
          data: 'expiry_date', className: 'text-center',
          render: function(data, type, row) {
            if (!data) return '';
            let expiry = new Date(data);
            let today = new Date();
            today.setHours(0, 0, 0, 0);
            expiry.setHours(0, 0, 0, 0);

            let sixMonthsLater = new Date();
            sixMonthsLater.setMonth(today.getMonth() + 6);

            if (expiry < today) {
              return '<span style="color:red; font-weight:600;">' + data + '</span>';
            }
            if (expiry <= sixMonthsLater) {
              return '<span style="color:orange; font-weight:600;">' + data + '</span>';
            }
            return data;
          }
        }
        //,{
          //data: 'display', className: 'text-center', orderable: false, searchable: false,
          // render: function(data, type, row) {
          //   let isYes = (data === 'Y' || data === 'Yes');
          //   if (isYes) {
          //     return '<i class="bi bi-check-circle-fill text-success" style="font-size:18px;"></i>';
          //   } else {
          //     return '<i class="bi bi-x-circle-fill text-danger" style="font-size:18px;"></i>';
          //   }
          // }
        //}
      ],
      language: {
        emptyTable: "No certificates found",
        zeroRecords: "No matching certificates found",
        lengthMenu: '_MENU_ &nbsp;Entries',
        info: 'Showing _START_ to _END_ of _TOTAL_ entries',
        search: 'Search:'
      }
    });


    // ==========================================
    // 2. RIGHT SIDE: PLANNED TRAINING DATATABLE
    // ==========================================
    var compTrainingTable = $('#compTrainingMatrixTable').DataTable({
      dom: "<'row mb-2'<'col-md-6 d-flex align-items-center'l><'col-md-6 text-end'>>" +
           "<'row'<'col-md-12'tr>>" +
           "<'row mt-2'<'col-md-6'i><'col-md-6 d-flex justify-content-end'p>>",
      processing: true,
      serverSide: false,
      searching: false,
      paging: true,
      pageLength: 10,
      lengthMenu: [10, 25, 50, 100],
      ajax: {
        url: baseUrlCompotents + '/get_training_matrix',
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
            return '<input type="checkbox" class="form-check-input comp-tm-completed" data-id="' + row.idcrewtraining_matrix + '" ' + checked + ' />';
          }
        },
        {
          data: null,
          className: 'text-center',
          orderable: false,
          searchable: false,
          render: function (data, type, row) {
            return '<button type="button" class="btn btn-sm btn-outline-primary comp-tm-edit" data-id="' + row.idcrewtraining_matrix + '"><i class="fa fa-edit"></i></button> ' +
                   '<button type="button" class="btn btn-sm btn-outline-danger comp-tm-delete" data-id="' + row.idcrewtraining_matrix + '"><i class="fa fa-trash"></i></button>';
          }
        }
      ],
      language: {
        emptyTable: 'No training data',
        zeroRecords: 'No matching training found',
        lengthMenu: '_MENU_ &nbsp;Entries',
        info: 'Showing _START_ to _END_ of _TOTAL_ entries',
      }
    });

    // Populate Matrix Selectpicker
    var $certSel = $('#comp_cert_matrix_id');
    if ($certSel.length) {
      $certSel.empty();
      $certSel.append($('<option></option>').val('').text('- Select Training -'));
      $.each(optionsCompCertMatrix, function (i, o) {
        $certSel.append($('<option></option>').val(o.value).text(o.text));
      });
      $certSel.selectpicker({
        noneSelectedText: '- Select Training -',
        liveSearch: true,
        size: 5
      });
      $certSel.selectpicker('val', '');
    }

    function showSuccess(msg) {
        success_message_comp.text(msg);
        alert_success_comp.removeClass('d-none');
        setTimeout(function() { alert_success_comp.addClass('d-none'); }, 2000);
    }
    
    function showError(msg) {
        error_message_comp.text(msg);
        alert_error_comp.removeClass('d-none');
        setTimeout(function() { alert_error_comp.addClass('d-none'); }, 3000);
    }

    function validateCompForm() {
      var ok = true;
      $('#comp_cert_matrix_id_fb').addClass('d-none');
      $('#comp_cert_matrix_id').closest('.bootstrap-select').removeClass('is-invalid');
      var val = $('#comp_cert_matrix_id').val();
      if (!val || (typeof val === 'string' && val.trim() === '')) {
        $('#comp_cert_matrix_id_fb').removeClass('d-none');
        $('#comp_cert_matrix_id').closest('.bootstrap-select').addClass('is-invalid');
        ok = false;
      }
      return ok;
    }

    $(document).on('click', '#btnNewCompTrainingMatrix', function () {
      $('#compTrainingMatrixForm')[0].reset();
      $('#comp_idcrewtraining_matrix').val('');
      $('#comp_idperson_matrix').val(idperson);
      $('#comp_cert_matrix_id').selectpicker('val', '');
      $('#comp_completed_matrix').prop('checked', false);
      $('#comp_cert_matrix_id_fb').addClass('d-none');
      
      $('#compTrainingMatrixModalTitle').text('Add List Competence');
      $('#btnSaveCompTrainingMatrix').removeClass('d-none');
      $('#btnUpdateCompTrainingMatrix').addClass('d-none');
      $('#compTrainingMatrixModal').modal('show');
    });

    $('#compTrainingMatrixTable').on('click', '.comp-tm-edit', function () {
      var id = $(this).data('id');
      $('#compTrainingMatrixForm')[0].reset();
      $('#comp_cert_matrix_id_fb').addClass('d-none');
      
      $('#compTrainingMatrixModalTitle').text('Edit List Training');
      $('#btnSaveCompTrainingMatrix').addClass('d-none');
      $('#btnUpdateCompTrainingMatrix').removeClass('d-none');
      
      $.ajax({
        url: baseUrlCompotents + '/get_training_matrix_by_id',
        type: 'POST',
        dataType: 'json',
        data: { idcrewtraining_matrix: id, idperson: idperson },
        success: function (r) {
          if (!r || r.success === false) {
             showError(r.message || 'Data not found');
             return;
          }
          $('#comp_idcrewtraining_matrix').val(r.idcrewtraining_matrix);
          $('#comp_idperson_matrix').val(r.idperson);
          $('#comp_cert_matrix_id').selectpicker('val', (r.cert_matrix_id || '').toString().trim());
          $('#comp_completed_matrix').prop('checked', r.completed == 1 || r.completed === '1');
          $('#comp_remarks_matrix').val(r.remarks || '');
          $('#compTrainingMatrixModal').modal('show');
        }
      });
    });

    $('#btnSaveCompTrainingMatrix').on('click', function () {
      if (!validateCompForm()) return;
      var fd = new FormData($('#compTrainingMatrixForm')[0]);
      fd.set('idperson', idperson);
      $.ajax({
        url: baseUrlCompotents + '/save_training_matrix',
        type: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (r) {
          if (r.status) {
            $('#compTrainingMatrixModal').modal('hide');
            showSuccess(r.message);
            compTrainingTable.ajax.reload(null, false);
          } else {
            showError(r.message || 'Save failed');
          }
        }
      });
    });

    $('#btnUpdateCompTrainingMatrix').on('click', function () {
      if (!validateCompForm()) return;
      var fd = new FormData($('#compTrainingMatrixForm')[0]);
      fd.set('idperson', idperson);
      $.ajax({
        url: baseUrlCompotents + '/update_training_matrix',
        type: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (r) {
          if (r.status) {
            $('#compTrainingMatrixModal').modal('hide');
            showSuccess(r.message);
            compTrainingTable.ajax.reload(null, false);
          } else {
            showError(r.message || 'Update failed');
          }
        }
      });
    });

    $('#compTrainingMatrixTable').on('change', '.comp-tm-completed', function () {
      var id = $(this).data('id');
      var checked = $(this).is(':checked') ? 1 : 0;
      $.ajax({
        url: baseUrlCompotents + '/update_training_completed',
        type: 'POST',
        dataType: 'json',
        data: { idcrewtraining_matrix: id, completed: checked },
        success: function(r) {
            if (r.status) {
                // optional: show small toast or ignore
            } else {
                showError("Failed to update status");
            }
        }
      });
    });

    $('#compTrainingMatrixTable').on('click', '.comp-tm-delete', function () {
      var id = $(this).data('id');
      var doDelete = function () {
        $.ajax({
          url: baseUrlCompotents + '/delete_training_matrix',
          type: 'POST',
          dataType: 'json',
          data: { idcrewtraining_matrix: id },
          success: function (r) {
            if (r.status) {
              showSuccess(r.message);
              compTrainingTable.ajax.reload(null, false);
            } else {
              showError(r.message || 'Delete failed');
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

  });
</script>
