<div class="crew-rotation-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow">
          <div class="card-body">
            <div class="table-responsive">
              <table id="educationTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                  <tr>
                    <th class="text-center">No</th>
                    <th>Year</th>
                    <th>School Name</th>
                    <th>Course / Finish</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <thead>
                  <tr>
                    <th></th>
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
</div>

<!-- Modal Add/Edit Education -->
<div class="modal fade" id="educationModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#000099;">
        <h5 class="modal-title" id="educationModalTitle">Add Education</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="educationForm">
          <input type="hidden" name="idscl" id="idscl">
          <input type="hidden" name="idperson" id="idperson_edu">
          <div class="row">
            <div class="col-md-6 mb-2">
              <label>Year<span style="color: red;">*</span></label>
              <input type="text" name="yearscl" id="yearscl" class="form-control">
              <small id="yearsclFeedback" class="text-danger d-none">Year is required</small>
            </div>
            <div class="col-md-6 mb-2">
              <label>School Name<span style="color: red;">*</span></label>
              <select name="namescl" id="namescl" class="form-control selectpicker" data-live-search="true"
                data-size="5" data-dropup-auto="false">
                <?php echo $OptMstSchool; ?>
              </select>
              <small id="namesclFeedback" class="text-danger d-none">School Name is required</small>
            </div>
            <div class="col-md-12 mb-2">
              <label>Course / Finish<span style="color: red;">*</span></label>
              <input type="text" name="crsfin" id="crsfin" class="form-control">
              <small id="crsfinFeedback" class="text-danger d-none">Course / Finish is required</small>
            </div>
            <div class="col-md-12 mb-2" id="wrapEducationFile">
              <label>File (optional)</label>
              <input type="file" name="scl_file" id="scl_file" class="form-control"
                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
              <small class="text-muted">Max 2 MB. Allowed: pdf, doc, docx, jpg, png, gif</small>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="btnSaveEdu">Save</button>
        <button type="button" class="btn btn-warning d-none" id="btnUpdateEdu">Update</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Upload File Only -->
<div class="modal fade" id="uploadEducationModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#000099;">
        <h5 class="modal-title">Upload Education File</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="uploadEducationForm">
          <input type="hidden" name="idscl_upload" id="idscl_upload">
          <input type="hidden" name="idperson_upload" id="idperson_upload">
          <div class="mb-3">
            <label>Select File<span style="color: red;">*</span></label>
            <input type="file" name="scl_file" id="scl_file_upload" class="form-control"
              accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
            <small id="scl_file_uploadFeedback" class="text-danger d-none">Please select a file</small>
            <small class="text-muted d-block mt-1">Max 2 MB. Allowed: pdf, doc, docx, jpg, png, gif</small>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btnUploadEdu">Upload</button>
      </div>
    </div>
  </div>
</div>

<style>
  .dataTables_length,
  .dataTables_filter {
    display: flex;
    align-items: center;
  }

  .custom-btn {
    justify-content: flex-start;
  }

  #yearscl.form-control {
    color: #212529;
    background-color: #fff;
  }

  #yearscl.form-control:focus {
    color: #212529;
    background-color: #fff;
  }
</style>

<script>
  $(document).ready(function () {
    $('#namescl').selectpicker({
      noneSelectedText: '- Select School -'
    });
    $('#namescl').selectpicker('refresh');


    let idperson = $('#contentArea').data('idperson');
    if (!idperson) {
      console.error('ID Person tidak ditemukan');
      return;
    }
    $('#idperson_edu').val(idperson);

    let table = $('#educationTable').DataTable({
      dom:
        "<'row mb-2'<'col-md-6 d-flex align-items-center'l><'col-md-6 text-end custom-btn'>>" +
        "<'row'<'col-md-12'tr>>" +
        "<'row mt-2'<'col-md-6'i><'col-md-6 d-flex justify-content-end'p>>",
      processing: true,
      serverSide: false,
      searching: true,
      paging: true,
      info: true,
      lengthChange: true,
      pageLength: 10,
      lengthMenu: [10, 25, 50, 100],
      ajax: {
        url: "<?php echo base_url("CrewDetail/Education/getAllData_education"); ?>",
        type: "GET",
        data: {
          idperson: idperson
        },
        dataSrc: function (json) {
          if (json.success) return json.data;
          console.error(json.message || 'Failed to load data');
          return [];
        }
      },
      columns: [{
          data: null,
          className: 'text-center',
          orderable: false,
          render: function (data, type, row, meta) {
            var no = meta.row + 1;
            var below = '';
            if (row.scl_file && row.scl_file.trim() !== '') {
              below = '<div class="mt-1"><a href="<?php echo base_url("uploadFile"); ?>/' + row.scl_file + '" target="_blank" class="text-primary small" title="View / Download"><i class="fa-solid fa-book"></i></a></div>';
            } else {
              below = '<div class="mt-1"><button type="button" class="btn btn-sm btn-outline-info p-1 btn-upload-edu" data-id="' + row.idscl + '" title="Upload File"><i class="fa fa-upload"></i></button></div>';
            }
            return '<div>' + no + below + '</div>';
          }
        },
        {
          data: 'yearscl'
        },
        {
          data: 'namescl'
        },
        {
          data: 'crsfin'
        },
        {
          data: null,
          orderable: false,
          searchable: false,
          className: 'text-center',
          render: function (data, type, row) {
            return `
            <button type="button" class="btn btn-sm btn-outline-primary btn-view-edu" data-id="${row.idscl}" title="Edit">
              <i class="fa fa-edit"></i>
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-edu" data-id="${row.idscl}" title="Delete">
              <i class="fa fa-trash"></i>
            </button>
          `;
          }
        }
      ],
      initComplete: function () {
        $('.custom-btn').html(`
        <button type="button" class="btn btn-primary btn-sm rounded-pill fst-italic" id="btnNewEdu">
          <i class="fa fa-plus"></i> New Education
        </button>
      `);
        $('#educationTable thead tr:eq(1) th').each(function (i) {
          $('input', this).on('keyup change', function () {
            if (table.column(i).search() !== this.value) {
              table.column(i).search(this.value).draw();
            }
          });
        });
      },
      language: {
        emptyTable: "No education data found",
        zeroRecords: "No matching data found",
        lengthMenu: '_MENU_ &nbsp;Entries',
        info: 'Showing _START_ to _END_ of _TOTAL_ entries',
        infoEmpty: 'Showing 0 to 0 of 0 entries',
        infoFiltered: '(filtered from _MAX_ total entries)',
        search: 'Search:'
      }
    });

    // New Education
    $(document).on('click', '#btnNewEdu', function () {
      $('#educationForm')[0].reset();
      $('#idscl').val('');
      $('#idperson_edu').val(idperson);
      $('#wrapEducationFile').show();
      $('#yearsclFeedback, #namesclFeedback, #crsfinFeedback').addClass('d-none');
      $('#yearscl, #namescl, #crsfin').removeClass('is-invalid');
      $('#educationModalTitle').text('Add Education');
      $('#btnSaveEdu').removeClass('d-none');
      $('#btnUpdateEdu').addClass('d-none');
      $('#educationModal').modal('show');
    });

    // Save Education
    $(document).on('click', '#btnSaveEdu', function () {
      if (!validateEducation()) return;
      let formData = new FormData($('#educationForm')[0]);
      formData.set('idperson', idperson);
      $.ajax({
        url: "<?php echo base_url("CrewDetail/Education/save_education"); ?>",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function (r) {
          if (r.status) {
            bootstrap.Modal.getInstance(document.getElementById('educationModal')).hide();
            Swal.fire({
              title: r.message,
              icon: "success",
              draggable: true
            });
            $('#educationForm')[0].reset();
            table.ajax.reload(null, false);
          } else {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: r.message || "Failed to save"
            });
          }
        },
        error: function () {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Server error"
          });
        }
      });
    });

    // Edit (View) - load data and open modal
    $('#educationTable').on('click', '.btn-view-edu', function () {
      let idscl = $(this).data('id');
      let formData = new FormData($('#educationForm')[0]);
      $('#educationForm')[0].reset();
      $('#btnUpdateEdu').removeClass('d-none');
      $('#btnSaveEdu').addClass('d-none');
      $('#educationModalTitle').text('Edit Education');
      $('#wrapEducationFile').show();
      table.processing(true);
      $.ajax({
        url: "<?php echo base_url("CrewDetail/Education/get_education_by_id"); ?>",
        type: "POST",
        data: {
          idscl: idscl,
          idperson: idperson
        },
        dataType: "json",
        success: function (res) {
          $('#idscl').val(res.idscl);
          $('#idperson_edu').val(res.idperson);
          var yearVal = String(res.yearscl || '').replace(/\D/g, '').substring(0, 4);
          $('#yearscl').val(yearVal || res.yearscl);
          $('#namescl').val(res.namescl).selectpicker('refresh');
          $('#crsfin').val(res.crsfin);
          $('#yearsclFeedback, #namesclFeedback, #crsfinFeedback').addClass('d-none');
          $('#yearscl, #namescl, #crsfin').removeClass('is-invalid');
          $('#educationModal').modal('show');
        },
        complete: function () {
          table.processing(false);
        }
      });
    });

    // Update Education
    $(document).on('click', '#btnUpdateEdu', function () {
      if (!validateEducation()) return;
      let formData = new FormData($('#educationForm')[0]);
      formData.set('idperson', idperson);
      $.ajax({
        url: "<?php echo base_url("CrewDetail/Education/update_education"); ?>",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function (r) {
          if (r.status) {
            bootstrap.Modal.getInstance(document.getElementById('educationModal')).hide();
            Swal.fire({
              title: r.message,
              icon: "success"
            });
            $('#educationForm')[0].reset();
            $('#idscl').val('');
            $('#btnUpdateEdu').addClass('d-none');
            $('#btnSaveEdu').removeClass('d-none');
            table.ajax.reload(null, false);
          } else {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: r.message || "Failed to update"
            });
          }
        },
        error: function () {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Server error"
          });
        }
      });
    });

    // Delete Education (soft delete)
    $('#educationTable').on('click', '.btn-delete-edu', function () {
      let idscl = $(this).data('id');
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(function (result) {
        if (result.isConfirmed) {
          table.processing(true);
          $.ajax({
            url: "<?php echo base_url("CrewDetail/Education/delete_education"); ?>",
            type: "POST",
            data: {
              idscl: idscl
            },
            dataType: "json",
            success: function (r) {
              if (r.status) {
                table.ajax.reload(null, false);
                Swal.fire({
                  title: r.message,
                  icon: "success",
                  draggable: true
                });
              } else {
                Swal.fire({
                  icon: "error",
                  title: "Oops...",
                  text: "Failed to delete"
                });
              }
            },
            error: function () {
              Swal.fire({
                icon: "error",
                title: "Error",
                text: "Server error"
              });
            },
            complete: function () {
              table.processing(false);
            }
          });
        }
      });
    });

    // Open Upload modal
    $('#educationTable').on('click', '.btn-upload-edu', function () {
      let idscl = $(this).data('id');
      $('#idscl_upload').val(idscl);
      $('#idperson_upload').val(idperson);
      $('#scl_file_upload').val('');
      $('#scl_file_uploadFeedback').addClass('d-none');
      $('#uploadEducationModal').modal('show');
    });

    // Submit Upload
    $(document).on('click', '#btnUploadEdu', function () {
      let fileInput = $('#scl_file_upload')[0];
      if (!fileInput.files || !fileInput.files.length) {
        $('#scl_file_uploadFeedback').removeClass('d-none').addClass('d-block');
        $('#scl_file_upload').addClass('is-invalid');
        return;
      }
      $('#scl_file_uploadFeedback').addClass('d-none');
      $('#scl_file_upload').removeClass('is-invalid');

      let formData = new FormData();
      formData.append('idscl', $('#idscl_upload').val());
      formData.append('idperson', $('#idperson_upload').val());
      formData.append('scl_file', fileInput.files[0]);

      $.ajax({
        url: "<?php echo base_url("CrewDetail/Education/upload_education_file"); ?>",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function (r) {
          if (r.status) {
            bootstrap.Modal.getInstance(document.getElementById('uploadEducationModal')).hide();
            Swal.fire({
              title: r.message,
              icon: "success"
            });
            table.ajax.reload(null, false);
          } else {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: r.message || "Upload failed"
            });
          }
        },
        error: function () {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Server error"
          });
        }
      });
    });
  });

  function validateEducation() {
    let ok = true;
    if (!validateChildField('yearscl', 'yearsclFeedback')) ok = false;
    if (!validateChildField('namescl', 'namesclFeedback')) ok = false;
    if (!validateChildField('crsfin', 'crsfinFeedback')) ok = false;
    return ok;
  }

  function validateChildField(inputId, feedbackId) {
    var $input = $('#' + inputId);
    var $feedback = $('#' + feedbackId);
    var value = ($input[0] && $input[0].tomselect) ? $input[0].tomselect.getValue() : $input.val();
    if (!value || (typeof value === 'string' && value.trim() === '')) {
      $feedback.removeClass('d-none').addClass('d-block');
      $input.addClass('is-invalid');
      return false;
    }
    $feedback.removeClass('d-block').addClass('d-none');
    $input.removeClass('is-invalid');
    return true;
  }
</script>

<style>
  :root {
    --crew-blue: #000099;
    --crew-font-sm: 12px;
    --crew-font-xs: 11px;
  }

  .crew-table th,
  .crew-table td {
    font-size: var(--crew-font-sm);
    vertical-align: middle;
  }

  .crew-table th {
    font-weight: 600;
    text-align: center;
  }

  .crew-table .btn {
    font-size: var(--crew-font-xs);
    padding: 2px 6px;
  }

  .crew-header th {
    background-color: var(--crew-blue) !important;
    color: #fff !important;
  }

  .column-search {
    width: 100%;
    padding: 6px 8px;
    box-sizing: border-box;
    font-size: 12px;
    border: 1px solid #dee2e6;
    border-radius: 4px;
    background: #f8f9fa;
  }
</style>