<div class="crew-rotation-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow">
          <div class="card-body">
            <div class="table-responsive">
              <table id="contractTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                  <tr>
                    <th class="text-center">No</th>
                    <th>Company</th>
                    <th>Sign On</th>
                    <th>Sign Off</th>
                    <th>Sign On Rank</th>
                    <th>Sign On Vessel</th>
                    <th>Sign On Port</th>
                    <th>Last Vessel</th>
                    <th>Estimate Sign Off</th>
                    <th>No. PKL</th>
                    <th>Sign Off Remark</th>
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
                    <th><input type="text" class="column-search form-control form-control-sm" placeholder="Search"></th>
                    <th><input type="text" class="column-search form-control form-control-sm" placeholder="Search"></th>
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

<!-- Modal Add/Edit Contract -->
<div class="modal fade" id="contractModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#000099;">
        <h5 class="modal-title" id="contractModalTitle">Add Contract</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="contractForm">
          <input type="hidden" name="idcontract" id="idcontract">
          <input type="hidden" name="idperson" id="idperson_contract">
          <div class="row">
            <div class="col-md-6 mb-2">
              <label>Company Name<span style="color: red;">*</span></label>
              <select name="kdcmprec" id="kdcmprec" class="form-control selectpicker" data-live-search="true" data-size="5" data-dropup-auto="false"></select>
              <small id="kdcmprecFeedback" class="text-danger d-none">Company Name is required</small>
            </div>
            <div class="col-md-3 mb-2">
              <label>Sign on Date<span style="color: red;">*</span></label>
              <input type="date" name="signondt" id="signondt" class="form-control" value="<?php echo date('Y-m-d'); ?>">
              <small id="signondtFeedback" class="text-danger d-none">Sign on Date is required</small>
            </div>
            <div class="col-md-3 mb-2">
              <label>Sign off Date</label>
              <input type="date" name="signoffdt" id="signoffdt" class="form-control">
              <small class="text-muted">Leave empty if still on board</small>
            </div>
            <div class="col-md-4 mb-2">
              <label>Sign on Rank<span style="color: red;">*</span></label>
              <select name="signonrank" id="signonrank" class="form-control selectpicker" data-live-search="true" data-size="5"></select>
              <small id="signonrankFeedback" class="text-danger d-none">Sign on Rank is required</small>
            </div>
            <div class="col-md-4 mb-2">
              <label>Sign on Vessel<span style="color: red;">*</span></label>
              <select name="signonvsl" id="signonvsl" class="form-control selectpicker" data-live-search="true" data-size="5"></select>
              <small id="signonvslFeedback" class="text-danger d-none">Sign on Vessel is required</small>
            </div>
            <div class="col-md-4 mb-2">
              <label>Sign on Port<span style="color: red;">*</span></label>
              <input type="text" name="signonport" id="signonport" class="form-control" placeholder="e.g. BENOA">
              <small id="signonportFeedback" class="text-danger d-none">Sign on Port is required</small>
            </div>
            <div class="col-md-12 mb-2">
              <label>Sign on Description<span style="color: red;">*</span></label>
              <input type="text" name="signondesc" id="signondesc" class="form-control" placeholder="e.g. Joining as AB for international voyage">
              <small id="signondescFeedback" class="text-danger d-none">Sign on Description is required</small>
            </div>
            <div class="col-md-4 mb-2">
              <label>Last Vessel</label>
              <input type="text" name="lastvsl" id="lastvsl" class="form-control">
            </div>
            <div class="col-md-4 mb-2">
              <label>No. PKL<span style="color: red;">*</span></label>
              <input type="text" name="no_pkl" id="no_pkl" class="form-control" placeholder="e.g. AL 524/1624/10/KSOP.TPK.25">
              <small id="no_pklFeedback" class="text-danger d-none">No. PKL is required</small>
            </div>
            <div class="col-md-4 mb-2">
              <label>Month</label>
              <select name="month" id="month" class="form-control">
                <option value="">- Select -</option>
                <?php for ($m = 1; $m <= 12; $m++) { echo '<option value="'.$m.'">'.$m.'</option>'; } ?>
              </select>
              <small class="text-muted">Optional</small>
            </div>
            <div class="col-md-4 mb-2">
              <label>Estimate Sign off Date<span style="color: red;">*</span></label>
              <input type="date" name="estsignoffdt" id="estsignoffdt" class="form-control">
              <small id="estsignoffdtFeedback" class="text-danger d-none">Estimate Sign off Date is required</small>
              <small id="estsignoffdtFeedbackDate" class="text-danger d-none">Estimate Sign off Date cannot be earlier than Sign off Date</small>
            </div>
            <div class="col-md-4 mb-2">
              <label>Remarks</label>
              <textarea name="estremark" id="estremark" class="form-control"></textarea>
            </div>
            <div class="col-md-4 mb-2">
              <label>Sign off remarks</label>
              <select name="signoffremark" id="signoffremark" class="form-control selectpicker" data-live-search="true" data-size="5"></select>
            </div>
            <div class="col-md-6 mb-2">
              <label>Replacement Candidate</label>
              <input type="text" name="idcontractRepl" id="idcontractRepl" class="form-control" placeholder="Contract ID or name">
            </div>
            <div class="col-md-6 mb-6 pb-2">
              <br>
              <div class="d-flex gap-3 flex-wrap">
                <label class="d-flex align-items-center gap-1 mb-0">
                  <input type="radio" name="foreigncrew_option" value="none" id="fco_none" class="form-check-input" checked>
                  <span>None</span>
                </label>
                <label class="d-flex align-items-center gap-1 mb-0">
                  <input type="radio" name="foreigncrew_option" value="additional" id="fco_additional" class="form-check-input">
                  <span>Additional</span>
                </label>
                <label class="d-flex align-items-center gap-1 mb-0">
                  <input type="radio" name="foreigncrew_option" value="foreigncrew" id="fco_foreigncrew" class="form-check-input">
                  <span>Foreign Crew</span>
                </label>
              </div>
            </div>
            <div class="col-md-12 mb-2" id="wrapContractFile">
              <label>File Contract</label>
              <input type="file" name="file_contract" id="file_contract" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
              <small class="text-muted">Max 2 MB. Allowed: pdf, doc, docx, jpg, png, gif</small>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="btnSaveContract">Save</button>
        <button type="button" class="btn btn-warning d-none" id="btnUpdateContract">Update</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Upload File Only -->
<div class="modal fade" id="uploadContractModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#000099;">
        <h5 class="modal-title">Upload Contract File</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="uploadContractForm">
          <input type="hidden" name="idcontract_upload" id="idcontract_upload">
          <input type="hidden" name="idperson_upload" id="idperson_upload">
          <div class="mb-3">
            <label>Select File<span style="color: red;">*</span></label>
            <input type="file" name="file_contract" id="file_contract_upload" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
            <small id="file_contract_uploadFeedback" class="text-danger d-none">Please select a file</small>
            <small class="text-muted d-block mt-1">Max 2 MB. Allowed: pdf, doc, docx, jpg, png, gif</small>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="btnUploadContract">Upload</button>
      </div>
    </div>
  </div>
</div>

<style>
  .dataTables_length, .dataTables_filter { display: flex; align-items: center; }
  .custom-btn { justify-content: flex-start; }
  .crew-table th, .crew-table td { font-size: 12px; vertical-align: middle; }
  .crew-table th { font-weight: 600; text-align: center; }
  .crew-table .btn { font-size: 11px; padding: 2px 6px; }
  .crew-header th { background-color: #000099 !important; color: #fff !important; }
  .column-search { width: 100%; padding: 6px 8px; box-sizing: border-box; font-size: 12px; border: 1px solid #dee2e6; border-radius: 4px; background: #f8f9fa; }
  .contract-no-icon { font-size: 1rem !important; width: 1.25em; text-align: center; }
  .contract-no-filelink .contract-no-icon { margin-right: 2px; }
</style>

<script>
$(document).ready(function () {
  // --- Options dari JSON (data satu sumber, isi select di JS supaya tidak double/multi select) ---
  var optionsCompany = <?php echo isset($optionsCompanyJson) ? $optionsCompanyJson : '[]'; ?>;
  var optionsRank = <?php echo isset($optionsRankJson) ? $optionsRankJson : '[]'; ?>;
  var optionsVessel = <?php echo isset($optionsVesselJson) ? $optionsVesselJson : '[]'; ?>;
  var optionsSignOffRemark = <?php echo isset($optionsSignOffRemarkJson) ? $optionsSignOffRemarkJson : '[]'; ?>;

  function fillSelect($select, options) {
    $select.empty();
    $.each(options, function (i, o) {
      $select.append($('<option></option>').val(o.value).text(o.text));
    });
  }

  fillSelect($('#kdcmprec'), optionsCompany);
  fillSelect($('#signonrank'), optionsRank);
  fillSelect($('#signonvsl'), optionsVessel);
  fillSelect($('#signoffremark'), optionsSignOffRemark);

  $('#kdcmprec, #signonrank, #signonvsl, #signoffremark').selectpicker({
    noneSelectedText: '- Select -',
    liveSearch: true,
    size: 5
  });

  let idperson = $('#contentArea').data('idperson');
  if (!idperson) {
    console.error('ID Person tidak ditemukan');
    return;
  }
  $('#idperson_contract').val(idperson);

  function fmtDate(val) {
    if (!val || val === '0000-00-00' || val === '') return '-';
    var d = new Date(val);
    if (isNaN(d.getTime())) return val;
    return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
  }

  let table = $('#contractTable').DataTable({
    dom: "<'row mb-2'<'col-md-6 d-flex align-items-center'l><'col-md-6 text-end custom-btn'>>" +
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
      url: "<?php echo base_url("CrewDetail/Contract/getAllData_contract"); ?>",
      type: "GET",
      data: { idperson: idperson },
      dataSrc: function (json) {
        if (json.success) return json.data;
        console.error(json.message || 'Failed to load data');
        return [];
      }
    },
    columns: [
      {
        data: null,
        className: 'text-center',
        orderable: false,
        render: function (data, type, row, meta) {
          var no = meta.row + 1;
          var below = '';
          if (row.file_contract && row.file_contract.trim() !== '') {
            below = '<div class="mt-1"><a href="<?php echo base_url("uploadCertificate"); ?>/' + row.file_contract + '" target="_blank" class="text-primary small contract-no-filelink"><i class="fa-solid fa-book contract-no-icon"></i></a></div>';
          } else {
            below = '<div class="mt-1"><button type="button" class="btn btn-sm btn-outline-info btn-upload-contract p-1" data-id="' + row.idcontract + '" title="Upload File"><i class="fa fa-upload contract-no-icon"></i></button></div>';
          }
          return '<div>' + no + below + '</div>';
        }
      },
      { data: 'company' },
      { data: 'sign_on', render: function (d) { return fmtDate(d); } },
      { data: 'sign_off', render: function (d) { return fmtDate(d); } },
      { data: 'sign_on_rank' },
      { data: 'sign_on_vessel' },
      { data: 'sign_on_port' },
      { data: 'last_vessel' },
      { data: 'estimate_sign_off', render: function (d) { return fmtDate(d); } },
      { data: 'no_pkl' },
      { data: 'sign_off_remark' },
      {
        data: null,
        orderable: false,
        searchable: false,
        className: 'text-center',
        render: function (data, type, row) {
          return `
            <button type="button" class="btn btn-sm btn-outline-primary btn-view-contract" data-id="${row.idcontract}" title="Edit"><i class="fa fa-edit"></i></button>
            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-contract" data-id="${row.idcontract}" title="Delete"><i class="fa fa-trash"></i></button>
          `;
        }
      }
    ],
    initComplete: function () {
      $('.custom-btn').html('<button type="button" class="btn btn-primary btn-sm rounded-pill fst-italic" id="btnNewContract"><i class="fa fa-plus"></i> New Contract</button>');
      $('#contractTable thead tr:eq(1) th').each(function (i) {
        $('input', this).on('keyup change', function () {
          if (table.column(i).search() !== this.value) table.column(i).search(this.value).draw();
        });
      });
    },
    language: {
      emptyTable: "No contract data found",
      zeroRecords: "No matching data found",
      lengthMenu: '_MENU_ &nbsp;Entries',
      info: 'Showing _START_ to _END_ of _TOTAL_ entries',
      infoEmpty: 'Showing 0 to 0 of 0 entries',
      infoFiltered: '(filtered from _MAX_ total entries)',
      search: 'Search:'
    }
  });

  // Function to reset all selectpicker
  function resetAllSelectpicker() {
    $('#kdcmprec').selectpicker('val', '');
    $('#signonrank').selectpicker('val', '');
    $('#signonvsl').selectpicker('val', '');
    $('#signoffremark').selectpicker('val', '');
  }

  // New Contract
  $(document).on('click', '#btnNewContract', function () {
    $('#contractForm')[0].reset();
    $('#idcontract').val('');
    $('#idperson_contract').val(idperson);
    $('#wrapContractFile').show();
    hideAllContractFeedback();
    $('#contractModalTitle').text('Add Contract');
    $('#btnSaveContract').removeClass('d-none');
    $('#btnUpdateContract').addClass('d-none');
    resetAllSelectpicker();
    $('#contractModal').modal('show');
  });

  function hideAllContractFeedback() {
    $('#kdcmprecFeedback,#signondtFeedback,#signonrankFeedback,#signonvslFeedback,#signonportFeedback,#signondescFeedback,#estsignoffdtFeedback,#estsignoffdtFeedbackDate,#no_pklFeedback').addClass('d-none');
    $('#kdcmprec,#signondt,#signonrank,#signonvsl,#signonport,#signondesc,#estsignoffdt,#no_pkl').removeClass('is-invalid');
  }

  // Save Contract
  $(document).on('click', '#btnSaveContract', function () {
    if (!validateContract()) return;
    let formData = new FormData($('#contractForm')[0]);
    formData.set('idperson', idperson);
    formData.delete('month'); // Month not stored in tblcontract
    $.ajax({
      url: "<?php echo base_url("CrewDetail/Contract/save_contract"); ?>",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (r) {
        if (r.status) {
          bootstrap.Modal.getInstance(document.getElementById('contractModal')).hide();
          Swal.fire({ title: r.message, icon: "success", draggable: true });
          $('#contractForm')[0].reset();
          resetAllSelectpicker();
          table.ajax.reload(null, false);
        } else {
          Swal.fire({ icon: "error", title: "Oops...", text: r.message || "Failed to save" });
        }
      },
      error: function () { Swal.fire({ icon: "error", title: "Error", text: "Server error" }); }
    });
  });

  // Edit - load data and open modal (options dari JSON, select hanya di-set value)
  $('#contractTable').on('click', '.btn-view-contract', function () {
    var idcontract = $(this).data('id');
    $('#contractForm')[0].reset();
    resetAllSelectpicker();
    hideAllContractFeedback();
    $('#btnUpdateContract').removeClass('d-none');
    $('#btnSaveContract').addClass('d-none');
    $('#contractModalTitle').text('Edit Contract');
    $('#wrapContractFile').show();
    table.processing(true);
    $.ajax({
      url: "<?php echo base_url("CrewDetail/Contract/get_contract_by_id"); ?>",
      type: "POST",
      data: { idcontract: idcontract, idperson: idperson },
      dataType: "json",
      success: function (res) {
        $('#idcontract').val(res.idcontract);
        $('#idperson_contract').val(res.idperson);
        $('#kdcmprec').selectpicker('val', (res.kdcmprec || '').toString().trim());
        $('#signonrank').selectpicker('val', (res.signonrank || '').toString().trim());
        $('#signonvsl').selectpicker('val', (res.signonvsl || '').toString().trim());
        $('#signoffremark').selectpicker('val', (res.signoffremark || '').toString().trim());
        $('#signondt').val(res.signondt && res.signondt !== '0000-00-00' ? res.signondt : '');
        $('#signoffdt').val(res.signoffdt && res.signoffdt !== '0000-00-00' ? res.signoffdt : '');
        $('#signonport').val(res.signonport || '');
        $('#signondesc').val(res.signondesc || '');
        $('#lastvsl').val(res.lastvsl || '');
        $('#estsignoffdt').val(res.estsignoffdt && res.estsignoffdt !== '0000-00-00' ? res.estsignoffdt : '');
        $('#no_pkl').val(res.no_pkl || '');
        $('#estremark').val(res.estremark || '');
        $('#idcontractRepl').val(res.idcontractRepl || '');
        if (res.additional == 1 || res.additional === '1') {
          $('#fco_additional').prop('checked', true);
        } else if (res.foreigncrew == 1 || res.foreigncrew === '1') {
          $('#fco_foreigncrew').prop('checked', true);
        } else {
          $('#fco_none').prop('checked', true);
        }
        $('#contractModal').modal('show');
      },
      complete: function () { table.processing(false); }
    });
  });

  // Update Contract
  $(document).on('click', '#btnUpdateContract', function () {
    if (!validateContract()) return;
    let formData = new FormData($('#contractForm')[0]);
    formData.set('idperson', idperson);
    formData.delete('month');
    $.ajax({
      url: "<?php echo base_url("CrewDetail/Contract/update_contract"); ?>",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (r) {
        if (r.status) {
          bootstrap.Modal.getInstance(document.getElementById('contractModal')).hide();
          Swal.fire({ title: r.message, icon: "success" });
          $('#contractForm')[0].reset();
          resetAllSelectpicker();
          $('#idcontract').val('');
          $('#btnUpdateContract').addClass('d-none');
          $('#btnSaveContract').removeClass('d-none');
          table.ajax.reload(null, false);
        } else {
          Swal.fire({ icon: "error", title: "Oops...", text: r.message || "Failed to update" });
        }
      },
      error: function () { Swal.fire({ icon: "error", title: "Error", text: "Server error" }); }
    });
  });

  // Delete Contract (soft delete: deletests = 1)
  $('#contractTable').on('click', '.btn-delete-contract', function () {
    let idcontract = $(this).data('id');
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
          url: "<?php echo base_url("CrewDetail/Contract/delete_contract"); ?>",
          type: "POST",
          data: { idcontract: idcontract },
          dataType: "json",
          success: function (r) {
            if (r.status) {
              table.ajax.reload(null, false);
              Swal.fire({ title: r.message, icon: "success", draggable: true });
            } else {
              Swal.fire({ icon: "error", title: "Oops...", text: "Failed to delete" });
            }
          },
          error: function () { Swal.fire({ icon: "error", title: "Error", text: "Server error" }); },
          complete: function () { table.processing(false); }
        });
      }
    });
  });

  // Open Upload modal
  $('#contractTable').on('click', '.btn-upload-contract', function () {
    let idcontract = $(this).data('id');
    $('#idcontract_upload').val(idcontract);
    $('#idperson_upload').val(idperson);
    $('#file_contract_upload').val('');
    $('#file_contract_uploadFeedback').addClass('d-none');
    $('#uploadContractModal').modal('show');
  });

  // Submit Upload
  $(document).on('click', '#btnUploadContract', function () {
    let fileInput = $('#file_contract_upload')[0];
    if (!fileInput.files || !fileInput.files.length) {
      $('#file_contract_uploadFeedback').removeClass('d-none').addClass('d-block');
      $('#file_contract_upload').addClass('is-invalid');
      return;
    }
    $('#file_contract_uploadFeedback').addClass('d-none');
    $('#file_contract_upload').removeClass('is-invalid');
    let formData = new FormData();
    formData.append('idcontract', $('#idcontract_upload').val());
    formData.append('idperson', $('#idperson_upload').val());
    formData.append('file_contract', fileInput.files[0]);
    $.ajax({
      url: "<?php echo base_url("CrewDetail/Contract/upload_contract_file"); ?>",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (r) {
        if (r.status) {
          bootstrap.Modal.getInstance(document.getElementById('uploadContractModal')).hide();
          Swal.fire({ title: r.message, icon: "success" });
          table.ajax.reload(null, false);
        } else {
          Swal.fire({ icon: "error", title: "Oops...", text: r.message || "Upload failed" });
        }
      },
      error: function () { Swal.fire({ icon: "error", title: "Error", text: "Server error" }); }
    });
  });

  // Reset form saat modal ditutup
  $('#contractModal').on('hidden.bs.modal', function () {
    $('#contractForm')[0].reset();
    resetAllSelectpicker();
    $('#idcontract').val('');
    $('#btnUpdateContract').addClass('d-none');
    $('#btnSaveContract').removeClass('d-none');
    hideAllContractFeedback();
  });
});

function validateContract() {
  var ok = true;
  if (!validateContractField('kdcmprec', 'kdcmprecFeedback')) ok = false;
  if (!validateContractField('signondt', 'signondtFeedback')) ok = false;
  if (!validateContractField('signonrank', 'signonrankFeedback')) ok = false;
  if (!validateContractField('signonvsl', 'signonvslFeedback')) ok = false;
  if (!validateContractField('signonport', 'signonportFeedback')) ok = false;
  if (!validateContractField('signondesc', 'signondescFeedback')) ok = false;
  if (!validateContractField('estsignoffdt', 'estsignoffdtFeedback')) ok = false;
  if (!validateContractField('no_pkl', 'no_pklFeedback')) ok = false;
  if (!validateEstSignOffVsSignOff()) ok = false;
  return ok;
}

function validateEstSignOffVsSignOff() {
  var signoffdt = $('#signoffdt').val() || '';
  var estsignoffdt = $('#estsignoffdt').val() || '';
  var $feedback = $('#estsignoffdtFeedbackDate');
  var $input = $('#estsignoffdt');
  signoffdt = signoffdt.trim();
  estsignoffdt = estsignoffdt.trim();
  if (signoffdt === '' || signoffdt === '0000-00-00') return true;
  if (estsignoffdt === '' || estsignoffdt === '0000-00-00') return true;
  var dSignOff = new Date(signoffdt);
  var dEst = new Date(estsignoffdt);
  if (dEst < dSignOff) {
    $feedback.removeClass('d-none').addClass('d-block');
    $input.addClass('is-invalid');
    return false;
  }
  $feedback.addClass('d-none').removeClass('d-block');
  $input.removeClass('is-invalid');
  return true;
}

function validateContractField(inputId, feedbackId) {
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
