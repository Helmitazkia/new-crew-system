<div class="crew-rotation-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow">
          <div class="card-body">
            <div class="table-responsive">
              <table id="crewTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                  <tr>
                    <th class="text-center">No</th>
                    <th>Company</th>
                    <th>Flag Name</th>
                    <th>Vessel Name</th>
                    <th>Type</th>
                    <th>GRT</th>
                    <th>DWT</th>
                    <th>Main Engine</th>
                    <th>BHP</th>
                    <th>Rank</th>
                    <th>Date From</th>
                    <th>Date To</th>
                    <th>Exp. Foreign Crew</th>
                    <th>Reason of Signoff</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <!-- HEADER SEARCH -->
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
                    <th><input type="text" class="column-search form-control form-control-sm" placeholder="Search"></th>
                    <th><input type="text" class="column-search form-control form-control-sm" placeholder="Search"></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <!-- data xample -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="experienceModal" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header text-white" style="background-color:#000099;">
        <h5 class="modal-title" id="modalTitle">Add Experience</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="experienceForm">
          <input type="hidden" name="idexp" id="idexp">
          <input type="hidden" name="idperson" id="idperson">
          <div class="row">

            <div class="col-md-6 mb-2">
              <label>Company<span style="color: red;">*</span></label>
              <input type="text" name="cmpexp" id="cmpexp" class="form-control">
              <small id="cmpexpFeedback" class="text-danger d-none">
                Company is required
              </small>

            </div>

            <div class="col-md-6 mb-2">
              <label>Flag</label>
              <input type="text" name="flagexp" id="flagexp" class="form-control">
            </div>

            <div class="col-md-6 mb-2">
              <label>Vessel Name<span style="color: red;">*</span></label>
              <input type="text" name="vslexp" id="vslexp" class="form-control">
              <small id="vslexpFeedback" class="text-danger d-none">
                Vessel Name is required
              </small>

            </div>

            <div class="col-md-6 mb-2">
              <label>Type</label>
              <select name="typeexp" id="typeexp" class="form-control selectpicker" data-live-search="true"
                data-size="5" data-dropup-auto="false">
                <?php echo $optType; ?>
              </select>
            </div>

            <div class="col-md-3 mb-2">
              <label>GRT</label>
              <input type="text" name="grtexp" id="grtexp" class="form-control">
            </div>

            <div class="col-md-3 mb-2">
              <label>DWT</label>
              <input type="text" name="dwtexp" id="dwtexp" class="form-control">
            </div>

            <div class="col-md-3 mb-2">
              <label>Main Engine</label>
              <input type="text" name="meexp" id="meexp" class="form-control">
            </div>

            <div class="col-md-3 mb-2">
              <label>BHP</label>
              <input type="text" name="hpexp" id="hpexp" class="form-control">
            </div>

            <div class="col-md-4 mb-2">
              <label>Rank<span style="color: red;">*</span></label>
              <select class="form-control selectpicker" id="rankexp" name="rankexp" data-live-search="true"
                data-size="5" data-dropup-auto="false">
                <?php echo $optRank; ?>
              </select>
              <!-- <input type=" text" name="rankexp" id="rankexp" class="form-control"> -->
              <small id="rankexpFeedback" class="text-danger d-none">
                Rank is required
              </small>

            </div>

            <div class="col-md-4 mb-2">
              <label>Date From<span style="color: red;">*</span></label>
              <input type="date" name="fmdtexp" id="fmdtexp" class="form-control">
              <small id="fmdtexpFeedback" class="text-danger d-none">
                Date From is required
              </small>

            </div>

            <div class="col-md-4 mb-2">
              <label>Date To<span style="color: red;">*</span></label>
              <input type="date" name="todtexp" id="todtexp" class="form-control">
              <small id="todtexpFeedback" class="text-danger d-none">
                Date To is required
              </small>
            </div>

            <div class="col-md-4 mb-2">
              <label>Foreign Crew</label>
              <input type="text" name="foreign_crew" id="foreign_crew" class="form-control">
            </div>

            <div class="col-md-8 mb-2">
              <label>Reason of Signoff</label>
              <!-- <textarea class="form-control" id="reasonexp" name="reasonexp"></textarea> -->
              <input type="text" name="reasonexp" id="reasonexp" class="form-control">
            </div>

          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-success" id="btnSave">Save</button>
        <button class="btn btn-warning d-none" id="btnUpdate">Update</button>
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
</style>

<script>
$(document).ready(function() {
  $('.selectpicker').selectpicker();

  let idperson = $('#contentArea').data('idperson');
  if (!idperson) {
    console.error('ID Person tidak ditemukan');
    return;
  }

  let table = $('#crewTable').DataTable({
    dom: "<'row mb-2'<'col-md-6 d-flex align-items-center'l><'col-md-6 text-end custom-btn'>>" +
      "<'row'<'col-md-12'tr>>" +
      "<'row mt-2'<'col-md-5'i><'col-md-7'p>>",

    processing: true,
    serverSide: false,
    searching: true,
    paging: true,
    info: true,
    lengthChange: true,
    pageLength: 10,
    lengthMenu: [10, 25, 50, 100],

    ajax: {
      url: "<?php echo base_url('CrewDetail/Experience/getAllData_experience'); ?>",
      type: "GET",
      data: {
        idperson: idperson
      },
      dataSrc: function(json) {
        if (json.success) {
          return json.data;
        } else {
          console.error(json.message);
          return [];
        }
      }
    },

    columns: [

      {
        data: null,
        className: 'text-center',
        orderable: false,
        render: function(data, type, row, meta) {
          return meta.row + 1;
        }
      },

      {
        data: 'company'
      },
      {
        data: 'flag'
      },
      {
        data: 'vessel'
      },
      {
        data: 'type'
      },
      {
        data: 'grt'
      },
      {
        data: 'dwt'
      },
      {
        data: 'me'
      },
      {
        data: 'bhp'
      },
      {
        data: 'rank'
      },

      {
        data: 'date_from'
      },

      {
        data: 'date_to',
      },

      {
        data: 'foreign',
        className: 'text-center'
      },

      {
        data: 'reason'
      },

      {
        data: null,
        orderable: false,
        searchable: false,
        className: 'text-center',
        render: function(data, type, row) {
          return `
          <button class="btn btn-sm btn-outline-primary btn-view" data-id="${row.idexp}">
            <i class="fa fa-edit"></i>
          </button>
          <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${row.idexp}">
            <i class="fa fa-trash"></i>
          </button>
        `;
        }
      }

    ],

    initComplete: function() {

      $('.custom-btn').html(`
        <button class="btn btn-primary btn-sm rounded-pill fst-italic" id="btnNew" >
          <i class="fa fa-plus"></i> New Experience
        </button>
      `);

      $('#crewTable thead tr:eq(1) th').each(function(i) {

        $('input', this).on('keyup change', function() {

          if (table.column(i).search() !== this.value) {
            table
              .column(i)
              .search(this.value)
              .draw();
          }

        });

      });

    },
    language: {
      emptyTable: "No experience data found",
      zeroRecords: "No matching data found",
      lengthMenu: '_MENU_ &nbsp;Entries',
      info: 'Showing _START_ to _END_ of _TOTAL_ entries',
      infoEmpty: 'Showing 0 to 0 of 0 entries',
      infoFiltered: '(filtered from _MAX_ total entries)',
      search: 'Search:'
    }

  });




  $(document).on('click', '#btnNew', function() {
    $('#experienceForm')[0].reset();
    $("#btnSave").removeClass('d-none');
    $("#btnUpdate").addClass('d-none');
    $('#experienceModal').modal('show');
  });

  $(document).on('click', '#btnSave', function() {

    if (!validateExperience()) return;

    let idperson = $('#contentArea').data('idperson');
    let formData = new FormData($('#experienceForm')[0]);
    formData.append("idperson", idperson);

    $.ajax({
      url: "<?php echo base_url('CrewDetail/Experience/save_experience'); ?>",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function(res) {
        let r = JSON.parse(res);
        if (r.status) {
          const modal = bootstrap.Modal.getInstance(document.getElementById('experienceModal'));
          modal.hide();
          Swal.fire({
            title: r.message,
            icon: "success",
            draggable: true
          });

          $('#experienceForm')[0].reset();
          $('#crewTable').DataTable().ajax.reload(null, false);

        } else {
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Failed to save",
          });
        }

      },
      error: function() {
        alert("Server error");
      }
    });

  });

  $('#crewTable').on('click', '.btn-view', function(e) {
    let id = $(this).data('id');
    $("#btnUpdate").removeClass('d-none');
    $("#btnSave").addClass('d-none');
    let idperson = $('#contentArea').data('idperson');
    View(id, idperson);
  });


  function View(idexp, idperson) {

    let table = $('#crewTable').DataTable();
    table.processing(true);

    $.ajax({
      url: "<?php echo base_url('CrewDetail/Experience/get_experience_by_id'); ?>",
      type: "POST",
      data: {
        idexp: idexp,
        idperson: idperson
      },
      dataType: "json",
      success: function(res) {

        $('#idexp').val(res.idexp);
        $('#cmpexp').val(res.cmpexp);
        $('#vslexp').val(res.vslexp);
        $('#flagexp').val(res.flagexp);
        $('#typeexp').selectpicker('val', res.typeexp);
        $('#grtexp').val(res.grtexp);
        $('#dwtexp').val(res.dwtexp);
        $('#hpexp').val(res.hpexp);
        $('#meexp').val(res.meexp);
        $('#rankexp').selectpicker('val', res.rankexp);
        $('#fmdtexp').val(res.fmdtexp);
        $('#todtexp').val(res.todtexp);
        $('#foreign_crew').val(res.foreign_crew);
        $('#reasonexp').val(res.reasonexp);

        $('#experienceModal').modal('show');
      },
      complete: function() {
        table.processing(false);
      }
    });
  }


  $(document).on('click', '#btnUpdate', function() {

    if (!validateExperience()) return;

    let formData = new FormData($('#experienceForm')[0]);
    let reasonexp = $('#reasonexp').val();
    let foreign_crew = $('#foreign_crew').val();
    formData.set("reasonexp", reasonexp);
    formData.set("foreign_crew", foreign_crew);

    $.ajax({
      url: "<?php echo base_url('CrewDetail/Experience/update_experience'); ?>",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function(r) {

        if (r.status) {

          const modal = bootstrap.Modal.getInstance(
            document.getElementById('experienceModal')
          );
          modal.hide();

          Swal.fire({
            title: r.message,
            icon: "success"
          });

          $('#experienceForm')[0].reset();
          $('#idexp').val('');

          $('#btnUpdate').addClass('d-none');
          $('#btnSave').removeClass('d-none');

          table.ajax.reload(null, false);

        } else {

          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: r.message
          });

        }
      },
      error: function() {
        alert("Server error");
      }
    });

  });



  // Tangkap klik tombol delete
  $('#crewTable').on('click', '.btn-delete', function() {
    let idexp = $(this).data('id');
    let table = $('#crewTable').DataTable();
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        table.processing(true);
        $.ajax({
          url: "<?php echo base_url('CrewDetail/Experience/delete_experience'); ?>",
          type: "POST",
          data: {
            idexp: idexp
          },
          dataType: "json",
          success: function(r) {
            if (r.status) {
              table.ajax.reload(null, false); // pakai instance table
              Swal.fire({
                title: r.message,
                icon: "success",
                draggable: true
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Failed to Delete",
              });
            }
          },
          error: function() {
            alert('Failed to delete data. Please check your connection.');
          },
          complete: function() {
            table.processing(false);
          }
        });
      }
    });
  });

});


function validateExperience() {
  let isValid = true;
  if (!validateChildField('cmpexp', 'cmpexpFeedback')) isValid = false;
  if (!validateChildField('vslexp', 'vslexpFeedback')) isValid = false;
  if (!validateChildField('rankexp', 'rankexpFeedback')) isValid = false;
  if (!validateChildField('fmdtexp', 'fmdtexpFeedback')) isValid = false;
  if (!validateChildField('todtexp', 'todtexpFeedback')) isValid = false;
  if (!isValid) return false;
  // Validasi Date Compare
  let dateFrom = new Date($('#fmdtexp').val());
  let dateTo = new Date($('#todtexp').val());

  if (dateTo < dateFrom) {
    $('#todtexpFeedback')
      .text('Date To cannot be earlier than Date From')
      .removeClass('d-none')
      .show();

    $('#todtexp').addClass('is-invalid');

    return false;
  }

  return true;
}

function loadCertificatesTab() {
  $('#loginLoading').show();
  $.ajax({
    url: "<?php echo base_url('CrewDetail/Certificates'); ?>",
    type: "GET",
    success: function(html) {
      $('#contentArea').html(html);
    },
    error: function() {
      $('#contentArea').html(
        '<div class="text-danger">Failed load Certificates</div>'
      );
    },
    complete: function() {
      $('#loginLoading').hide();
    }
  });
}

function validateChildField(inputId, feedbackId) {

  let $input = $('#' + inputId);
  let $feedback = $('#' + feedbackId);
  let value = '';

  // Cek apakah ini elemen TomSelect
  if ($input[0] && $input[0].tomselect) {
    value = $input[0].tomselect.getValue();
  } else {
    value = $input.val();
  }

  if (!value || (typeof value === 'string' && value.trim() === '')) {

    $feedback
      .removeClass('d-none')
      .addClass('d-block'); // biar pasti muncul

    $input.addClass('is-invalid');

    return false;

  } else {

    $feedback
      .removeClass('d-block')
      .addClass('d-none');

    $input.removeClass('is-invalid');

    return true;
  }
}
</script>

<style>
.btn-clear-filter {
  background: transparent;
  border: 1.5px solid #000099;
  color: #000099;
  transition: all .2s ease;
}

.btn-clear-filter:hover {
  background: #000099;
  color: #fff;
}

.btn-clear-filter i {
  font-size: 14px;
}
</style>


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


.crew-header-group {
  background-color: var(--crew-blue) !important;
  color: #fff !important;
}

/* DataTables Customization */
.dataTables_wrapper {
  padding: 15px 0;
}

.dataTables_length {
  padding: 10px 0;
  margin-bottom: 10px;
}

.dataTables_length label,
.dataTables_filter label {
  display: flex;
  align-items: center;
  margin: 0;
  padding: 20px 0;
}

.dataTables_length select {
  width: auto;
  margin: 0 8px;
  padding: 4px 8px;
  border-radius: 4px;
  border: 1px solid #ced4da;
}

.dataTables_filter {
  text-align: right;
  margin-bottom: 10px;
}

.dataTables_filter label {
  display: inline-flex;
  align-items: center;
  margin: 0;
  padding: 8px 0;
  font-weight: normal;
}

.dataTables_filter input {
  margin-left: 10px;
  padding: 6px 12px;
  border-radius: 4px;
  border: 1px solid #ced4da;
  width: 200px;
}

/* PAGINATION STYLING */
.dataTables_paginate {
  margin-top: 15px;
  padding-top: 10px;
  border-top: 1px solid #dee2e6;
}

.paginate_button {
  margin: 0 2px;
  padding: 6px 12px !important;
  border-radius: 4px;
  border: 1px solid #dee2e6;
  background: #fff !important;
  color: #0d6efd !important;
}

.paginate_button.current {
  background: #0d6efd !important;
  color: #fff !important;
  border-color: #0d6efd !important;
}

.paginate_button:hover {
  background: #e9ecef !important;
  border-color: #dee2e6;
}

/* INFO TEXT STYLING */
.dataTables_info {
  padding: 10px 0;
  color: #6c757d;
  font-size: 14px;
}

/* Filter Icon */
.filter-icon {
  cursor: pointer;
  font-size: 14px;
  margin-left: 6px;
  color: #0d6efd;
}

.filter-dropdown {
  position: absolute;
  background: #fff;
  border: 1px solid #ccc;
  padding: 8px;
  width: 200px;
  max-height: 260px;
  overflow-y: auto;
  box-shadow: 0 4px 10px rgba(0, 0, 0, .2);
  display: none;
  z-index: 9999;
}

.filter-dropdown input[type="text"] {
  width: 100%;
  margin-bottom: 6px;
  padding: 4px;
  font-size: 12px;
  border: 1px solid #dee2e6;
  border-radius: 4px;
}

.filter-dropdown label {
  display: block;
  font-size: 13px;
  cursor: pointer;
  padding: 4px 8px;
  margin: 2px 0;
  border-radius: 4px;
}

.filter-dropdown label:hover {
  background: #f8f9fa;
}

.filter-list {
  max-height: 120px;
  overflow-y: auto;
  margin-bottom: 6px;
}

/* Column Search Input */
.column-search {
  width: 100%;
  padding: 6px 8px;
  box-sizing: border-box;
  font-size: 12px;
  border: 1px solid #dee2e6;
  border-radius: 4px;
  background: #f8f9fa;
}

/* Responsive Card */
.card {
  margin-top: 20px;
  border-radius: 8px;
}

.card-header {
  padding: 15px 20px;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.card-body {
  padding: 20px;
  overflow-x: auto;
}

/* Table responsive fixes */
.table-responsive {
  margin: 0;
}

/* Custom layout for DataTables controls */
.dataTables_wrapper .row {
  margin: 0;
}

.dataTables_wrapper .col-sm-12 {
  padding: 0;
}

/* Ensure proper spacing */
.dt-length {
  float: left;
}

.dt-search {
  float: right;
}

.dt-info {
  float: left;
  margin-top: 10px;
}

.dt-paging {
  float: right;
  margin-top: 10px;
}

/* Clear floats */
.dataTables_wrapper:after {
  content: "";
  display: table;
  clear: both;
}
</style>