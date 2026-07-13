<style>
  .certificate-link:hover {
    color: #007bff !important; /* Mengubah warna menjadi biru saat di-hover */
    text-decoration: underline !important; /* Memberi garis bawah saat di-hover */
  }
</style>
<div class="crew-rotation-content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-7">
        <div class="card shadow">
          <div class="card-body">
            <div class="table-responsive">
              <table id="crewTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%">
                <thead class="crew-header">
                  <tr>
                    <th class="text-center">No</th>
                    <th class="text-left">Certificate Name</th>
                    <th class="text-center">Expiry Date</th>
                    <th class="text-center">Display</th>
                    <th class="text-center">Action</th>
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
                <tbody>
                  <!-- Data akan diisi oleh DataTables -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-5">
        <div class="card">
          <div class="card-body">
            <!-- Alert Success Message  -->
            <div
              class="alert alert-success d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
              role="alert" id="success-alert">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                <use xlink:href="#check-circle-fill" />
              </svg>
              <div class="flex-grow-1">
                <span id="success-message"></span>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <!-- Alert wrong Message  -->
            <div
              class="alert alert-danger  d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
              role="alert" id="error-alert">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                <use xlink:href="#exclamation-triangle-fill" />
              </svg>
              <div class="flex-grow-1">
                <span id="error-message"></span>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <br>
            <form id="formCertificate">
              <input type="hidden" name="idcertdoc" id="idcertdoc">
              <!-- <h5 class="card-title">:: Certificate / Document ::</h5> -->
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label>Certificate Name<span style="color: red;">*</span></label>
                  <select name="certname" id="certname" class="tom-select">
                    <option value="">- Select Certificate -</option>
                    <?php echo $optMstCert; ?>
                  </select>
                  <div id="certnameFeedback" class="valid-feedback">
                    Certificate Name is required
                  </div>
                </div>

                <div class="col-md-6 mb-3">
                  <label>Certificate File (Max : 2 MB)<span style="color: red;">*</span></label>
                  <input type="file" name="certificate_file" id="certificate_file" class="form-control">
                  <div id="certfileFeedback" class="valid-feedback">
                    Certificate File is required
                  </div>
                </div>

                <div class="col-md-6 mb-3">
                  <label>Description</label>
                  <input type="text" name="dispname" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                  <label>Display</label>
                  <select name="display" class="form-control">
                    <option value="Y">Yes</option>
                    <option value="N">No</option>
                  </select>
                </div>

                <div class="col-md-6 mb-3">
                  <label>License</label>
                  <input type="text" name="license" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                  <label>Level</label>
                  <input type="text" name="level" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                  <label>Rank</label>
                  <select name="nmrank" id="nmrank" class="tom-select">
                    <option value="">- Select Rank -</option>
                    <?php echo $optRank; ?>
                  </select>
                </div>

                <div class="col-md-6 mb-3">
                  <label>Vessel Type</label>
                  <select name="vsltype" id="vsltype" class="tom-select" style="border-radius:10px;">
                    <option value="">- Select Vessel Type -</option>
                    <?php echo $optType; ?>
                  </select>
                </div>

                <div class="col-md-6 mb-3">
                  <label>No Document</label>
                  <input type="text" name="docno" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                  <label>Date of Issue</label>
                  <input type="date" name="issdate" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="col-md-6 mb-3">
                  <label>Date of Expiry</label>
                  <input type="date" name="expdate" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="col-md-6 mb-3">
                  <label>Place of Issue</label>
                  <input type="text" name="issplace" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                  <label>Issuing Authority</label>
                  <input type="text" name="issauth" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                  <label>Remark</label>
                  <input type="text" name="remarks" class="form-control">
                </div>

              </div>

              <button type="button" id="btnSave" class="btn btn-primary rounded-pill">Save</button>
              <button type="button" id="btnUpdate" class="btn btn-success rounded-pill d-none">Update</button>
              <button type="button" id="btcCancel" class="btn btn-danger rounded-pill">Cancel</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>




<script>
$(document).ready(function() {
  var alert_error = $('#error-alert');
  var alert_success = $('#success-alert');
  var error_message = $('#error-message');
  var success_message = $('#success-message');

  let idperson = $('#contentArea').data('idperson');
  if (!idperson) {
    console.error('ID Person tidak ditemukan');
    return;
  }

  let table = $('#crewTable').DataTable({
    processing: true,
    serverSide: false,
    searching: true,
    paging: true,
    info: true,
    lengthChange: true, // Mengizinkan pengguna mengubah jumlah entri
    pageLength: 10,
    lengthMenu: [10, 25, 50, 100], // Opsi untuk menampilkan entri

    ajax: {
      url: "<?php echo base_url('CrewDetail/Certificates/getAllData_certificates'); ?>",
      type: "GET",
      data: {
        idperson: idperson
      },
      dataSrc: function(json) {
        if (json.success) {
          return json.data;
        } else {
          console.error('Error dari server:', json.message);
          return [];
        }
      },
      error: function(xhr, error, thrown) {
        console.error('AJAX Error:', error, thrown);
        console.error('Response:', xhr.responseText);
      }
    },

    columns: [{
        data: null,
        className: 'text-center',
        orderable: false,
        render: function(data, type, row, meta) {
          return meta.row + 1;
        }
      },
      {
        data: 'certificate_name',
        className: 'text-left',
        render: function(data, type, row) {
          if (row.certificate_file) {
            return '<a href="<?php echo base_url("uploadCertificate"); ?>/' +
              row.certificate_file +
              '" target="_blank" class="certificate-link" title="Click to open/view certificate" style="color: black; text-decoration: none;">' + data + '</a>';
          }
          return data;
        }
      },
      {
        data: 'expiry_date',
        className: 'text-center',
        render: function(data, type, row) {

          if (!data) return '';
          let expiry = new Date(data);
          let today = new Date();

          // Reset jam biar tidak error perbandingan
          today.setHours(0, 0, 0, 0);
          expiry.setHours(0, 0, 0, 0);

          // Hitung 6 bulan ke depan
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
      },
      {
        data: 'display',
        className: 'text-center',
        orderable: false,
        searchable: false,
        render: function(data, type, row) {
          let isYes = (data === 'Y' || data === 'Yes');
          if (isYes) {
            return '<i class="bi bi-check-circle-fill text-success" style="font-size:18px;"></i>';
          } else {
            return '<i class="bi bi-x-circle-fill text-danger" style="font-size:18px;"></i>';
          }
        }
      },
      {
        data: null,
        orderable: false,
        searchable: false,
        className: 'text-center',
        render: function(data, type, row) {
          return `
        <button type="button" class="btn btn-sm btn-outline-primary btn-view-data" data-id="${row.idcertdoc}">
            <i class="fa fa-eye"></i>
        </button>
        <button type="button" class="btn btn-sm btn-outline-danger btn-delete-data" data-id="${row.idcertdoc}">
            <i class="fa fa-trash"></i>
        </button>
    `;
        }
      }
    ],
    initComplete: function() {
      // Inisialisasi column search
      this.api().columns().every(function() {
        var column = this;
        var header = $(column.header());
        if (header.find('.column-search').length) {
          var input = header.find('.column-search');
          input.on('keyup change', function() {
            if (column.search() !== this.value) {
              column.search(this.value).draw();
            }
          });
        }
      });
    },

    language: {
      emptyTable: "No certificates found",
      zeroRecords: "No matching certificates found",
      lengthMenu: '_MENU_ &nbsp;Entries',
      info: 'Showing _START_ to _END_ of _TOTAL_ entries',
      infoEmpty: 'Showing 0 to 0 of 0 entries',
      infoFiltered: '(filtered from _MAX_ total entries)',
      search: 'Search:'
    }

  });

  // Column Search - AMBIL ROW SEARCH TERAKHIR
  $('#crewTable thead tr:last th').each(function(i) {
    $('input', this).on('keyup change', function() {
      if (table.column(i).search() !== this.value) {
        table
          .column(i)
          .search(this.value)
          .draw();
      }
    });
  });

  // Refresh table button
  $('#refreshBtn').click(function() {
    table.ajax.reload();
  });

  //Vie Data
  $('#crewTable').on('click', '.btn-view-data', function() {
    let id = $(this).data('id');
    View(id); // Panggil fungsi View Anda
    $("#btnUpdate").removeClass('d-none');
    $("#btnSave").addClass('d-none');

  });

  $('#btcCancel').click(function() {
    $('#formCertificate')[0].reset();
    // Reset TomSelect (jika ada)
    $('.tom-select').each(function() {
      if (this.tomselect) this.tomselect.clear();
    });
    $("#btnUpdate").addClass('d-none'); // Sembunyikan Update
    $("#btnSave").removeClass('d-none'); // Tampilkan Save


  });


  $('.tom-select').each(function() {
    new TomSelect(this, {
      create: false,
      sortField: {
        field: "text",
        direction: "asc"
      }
    });
  });

  $('#btnSave').click(function() {
    let isCertNameValid = validateChildField('certname', 'certnameFeedback');
    let isFileValid = validateChildField('certificate_file', 'certfileFeedback')

    if (!isCertNameValid || !isFileValid) {
      return false; // Berhenti jika tidak valid
    }

    let idperson = $('#contentArea').data('idperson');
    console.log(idperson);
    var formData = new FormData($('#formCertificate')[0]);
    formData.append("idperson", idperson);


    $.ajax({
      url: "<?php echo base_url('CrewDetail/Certificates/save_certificate'); ?>",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function(res) {
        var r = JSON.parse(res);
        if (r.status) {
          success_message.text(r.message);
          alert_success.removeClass('d-none');
          setTimeout(function() {
            alert_success.addClass('d-none');
            loadCertificatesTab();
          }, 1000);
        } else {
          error_message.text(res.message || 'Failed to update family information');
          alert_error.removeClass('d-none');
          setTimeout(function() {
            alert_error.addClass('d-none');
          }, 5000);
        }
      }
    });

  });

  $('#btnUpdate').click(function() {
    var certname = $("#certname").val();
    // if (certname == 'SEAMAN BOOK' || certname == 'PASSPORT') {
    //   $("#message-cert").removeClass('d-none');
    //   return false;
    // }

    let isCertNameValid = validateChildField('certname', 'certnameFeedback');
    if (!isCertNameValid) {
      return false;
    }


    let idperson = $('#contentArea').data('idperson');
    let formData = new FormData($('#formCertificate')[0]);
    formData.append("idperson", idperson);


    if ($.fn.DataTable.isDataTable('#crewTable')) {
      $('#crewTable').DataTable().processing(true);
    }


    $.ajax({
      url: "<?php echo base_url('CrewDetail/Certificates/update_certificate'); ?>",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function(res) {
        var r = JSON.parse(res);
        if (r.status) {
          success_message.text(r.message);
          alert_success.removeClass('d-none');

          $("#btnUpdate").addClass('d-none');
          $("#btnSave").removeClass('d-none');

          $('#formCertificate')[0].reset();
          $('#idcertdoc').val('');
          $('.tom-select').each(function() {
            if (this.tomselect) this.tomselect.clear();
          });

          setTimeout(function() {
            alert_success.addClass('d-none');
            loadCertificatesTab();
          }, 1000);

        } else {
          error_message.text(r.message || 'Failed to update certificate');
          alert_error.removeClass('d-none');
          setTimeout(function() {
            alert_error.addClass('d-none');
          }, 5000);
        }
      },
      error: function() {
        alert("Error: Could not connect to server.");
      },
      complete: function() {
        if ($.fn.DataTable.isDataTable('#crewTable')) {
          $('#crewTable').DataTable().processing(false);
        }
      }
    });
  });


  // Tangkap klik tombol delete
  $('#crewTable').on('click', '.btn-delete-data', function() {
    let id = $(this).data('id');
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
          url: "<?php echo base_url('CrewDetail/Certificates/delete_certificate'); ?>",
          type: "POST",
          data: {
            idcertdoc: id
          },
          dataType: "json",
          success: function(r) {
            if (r.status) {
              success_message.text(r.message);
              alert_success.removeClass('d-none');
              setTimeout(function() {
                alert_success.addClass('d-none');
                loadCertificatesTab();
              }, 1300);
            } else {
              alert('Error: ' + r.message);
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



function View(id) {
  console.log("View ID:", id);
  let table = $('#crewTable').DataTable();
  table.processing(true);

  $.ajax({
    url: "<?php echo base_url('CrewDetail/Certificates/get_by_id'); ?>",
    type: "POST",
    data: {
      id: id
    },
    dataType: "json",
    success: function(response) {
      if (response.success) {
        let r = response.data;
        $('#idcertdoc').val(r.idcertdoc);

        // TomSelect handling untuk Certificate Name
        if ($('#certname')[0] && $('#certname')[0].tomselect) {
          $('#certname')[0].tomselect.setValue(r.certname);
        } else {
          $('#certname').val(r.certname);
        }

        // Mengisi input text berdasarkan atribut name/id
        // Gunakan selector ID jika input memiliki ID, jika tidak gunakan name
        $('[name="dispname"]').val(r.dispname);
        $('[name="license"]').val(r.license);
        $('[name="level"]').val(r.level);
        $('[name="docno"]').val(r.docno);
        $('[name="issdate"]').val(r.issdate);
        $('[name="expdate"]').val(r.expdate);
        $('[name="issplace"]').val(r.issplace);
        $('[name="issauth"]').val(r.issauth);
        $('[name="remarks"]').val(r.remarks);
        $('[name="display"]').val(r.display);

        // TomSelect handling untuk Rank
        if ($('#nmrank')[0] && $('#nmrank')[0].tomselect) {
          $('#nmrank')[0].tomselect.setValue(r.nmrank); // Gunakan kode rank, bukan nmrank
        } else {
          $('#nmrank').val(r.nmrank);
        }

        // TomSelect handling untuk Vessel Type
        if ($('#vsltype')[0] && $('#vsltype')[0].tomselect) {
          $('#vsltype')[0].tomselect.setValue(r.vsltype);
        } else {
          $('#vsltype').val(r.vsltype);
        }

        // Scroll halus ke form agar user tahu data sudah terisi
        $('html, body').animate({
          scrollTop: $("#formCertificate").offset().top - 100
        }, 500);

      } else {
        alert(response.message);
      }
    },
    error: function() {
      alert("Failed to get data.");
    },
    complete: function() {
      table.processing(false);
    }
  });
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
    $feedback.show().css('color', '#dc3545'); // Pastikan warna merah (Bootstrap danger)
    $input.addClass('is-invalid');
    return false;
  } else {
    $feedback.hide();
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