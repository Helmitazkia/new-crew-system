<div class="family-content">

  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
      <path
        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
    </symbol>
    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
      <path
        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
    </symbol>
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
      <path
        d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
    </symbol>
  </svg>


  <div class="container-fluid mb-4">
    <div class="row">

      <!-- ================= FAMILY CARD ================= -->
      <div class="col-6 mb-4">
        <div class="card shadow-sm h-100">
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
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-semibold fst-italic">👨‍👩‍👧 Family Information</span>

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
            <div class="row g-2">

              <div class="col-12">
                <label class="form-label mb-0 fst-italic fw-semibold">Father Name<span
                    style="color: red;">*</span></label>
                <div class="form-view fst-italic" data-field="family.father.name"></div>
                <input type="text" class="form-control form-edit d-none" data-field="family.father.name"
                  id="fatherName">
                <div id="fatherNameFeedback" class="valid-feedback">
                  Father Name is required
                </div>
              </div>

              <div class="col-12">
                <label class="form-label mb-0 fst-italic fw-semibold">Mother Name<span
                    style="color: red;">*</span></label>
                <div class="form-view fst-italic" data-field="family.mother.name"></div>
                <input type="text" class="form-control form-edit d-none" data-field="family.mother.name"
                  id="motherName">
                <div id="motherNameFeedback" class="valid-feedback">
                  Mother Name is required
                </div>
              </div>

              <div class="col-12">
                <label class="form-label mb-0 fst-italic fw-semibold">Wife/Spouse Name</label>
                <div class="form-view fst-italic" data-field="family.wife.name"></div>
                <input type="text" class="form-control form-edit d-none" data-field="family.wife.name">
              </div>


              <div class="col-12">
                <label class="form-label mb-0 fst-italic fw-semibold">Address<span style="color: red;">*</span></label>
                <div class="form-view fst-italic" data-field="family.address"></div>
                <textarea class="form-control form-edit d-none" data-field="family.address" rows="2"
                  id="address"></textarea>
                <div id="addressFeedback" class="valid-feedback">
                  Address is required
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

      <!-- ================= CHILDREN CARD ================= -->
      <div class="col-6 mb-4">
        <div class="card shadow-sm h-100">
          <!-- Alert Success Message  -->
          <div
            class="alert alert-success d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
            role="alert" id="child-success-alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
              <use xlink:href="#check-circle-fill" />
            </svg>
            <div class="flex-grow-1">
              <span id="child-success-message"></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>

          <!-- Alert wrong Message  -->
          <div
            class="alert alert-danger  d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
            role="alert" id="child-danger-alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
              <use xlink:href="#exclamation-triangle-fill" />
            </svg>
            <div class="flex-grow-1">
              <span id="child-error-message"></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <br>
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-semibold fst-italic">👶 Children Information</span>
            <div>
              <span class="badge bg-primary me-2" id="childrenCount">0</span>
              <button class="btn btn-sm btn-outline-primary rounded-pill btn-add-child " data-bs-toggle="modal"
                data-bs-target="#childModal">
                <i class="fa fa-plus"></i> Add
              </button>
            </div>
          </div>

          <div class="card-body small p-0">
            <div class="children-container" id="childrenContainer" style="max-height: 300px; overflow-y: auto;">
              <!-- Children akan ditampilkan di sini -->
              <div class="text-center text-muted py-4" id="noChildrenMessage">
                <i class="fa fa-child fa-2x mb-2"></i><br>
                No children data
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal untuk Add/Edit Child -->
      <div class="modal fade" id="childModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Child Information</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <script></script>
            <div class="modal-body ">
              <form id="childForm">
                <input type="hidden" name="idfm" id="childIdfm">
                <input type="hidden" name="idperson" id="childIdperson">
                <input type="hidden" name="fmrel" value="CHILD">

                <div class="row g-3">
                  <div class="col-md-6">
                    <label for="childFirstName" class="form-label">First Name<span style="color: red;">*</span></label>
                    <input type="text" class="form-control" name="fmfname" id="childFirstName" required>
                    <div id="childFirstNameFeedback" class="valid-feedback">
                      First Name is required
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="fmlname" id="childLastName">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Gender <span style="color: red;">*</span></label>
                    <select class="form-control" name="fmsex" id="childGender" required>
                      <option value="">- Select -</option>
                      <option value="1">Male</option>
                      <option value="2">Female</option>
                    </select>
                    <div id="childGenderFeedback" class="valid-feedback">
                      Gender is required
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Date of Birth<span style="color: red;">*</span></label>
                    <input type="date" class="form-control" name="fmdob" id="childDob" required>
                    <div id="childDobFeedback" class="valid-feedback">
                      Date of Birth is required
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Passport Number</label>
                    <input type="text" class="form-control" name="fmpassno" id="childPassport">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Passport Issue Date</label>
                    <input type="date" class="form-control" name="fmissdt" id="childIssueDate">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Passport Issue Place</label>
                    <input type="text" class="form-control" name="fmplc" id="childIssuePlace">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Passport Expiry Date</label>
                    <input type="date" class="form-control" name="fmexpdt" id="childExpiryDate">
                  </div>

                  <div class="col-md-12">
                    <label class="form-label">Visa Information</label>
                    <input type="text" class="form-control" name="fmvisa" id="childVisa">
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary rounded-pill" id="btnSaveChild">Save</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="loginLoading" class="text-center mt-3">
  <img src="<?php echo base_url('assets/img/loading-new.gif'); ?>" width="60" alt="Loading">
</div>

<style>
  #loginLoading {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
  }
</style>


<style>
  .family-content {
    font-size: 13px;
  }

  .family-content .card-header {
    font-size: 13px;
  }

  .family-content strong {
    font-size: 12.5px;
  }

  .family-content hr {
    margin: 6px 0;
  }

  .child-item {
    border-bottom: 1px solid #eee;
    padding: 10px 15px;
  }

  .child-item:last-child {
    border-bottom: none;
  }

  .child-item:hover {
    background-color: #f8f9fa;
  }
</style>


<script>
  $(document).on('click', '.btn-edit', function () {
    const card = $(this).closest('.card');

    card.find('.form-view').addClass('d-none');
    card.find('.form-edit').removeClass('d-none');

    card.find('.btn-edit').addClass('d-none');
    card.find('.btn-save, .btn-cancel').removeClass('d-none');
  });

  $(document).on('click', '.btn-cancel', function () {
    const card = $(this).closest('.card');

    card.find('.form-view').removeClass('d-none');
    card.find('.form-edit').addClass('d-none');

    card.find('.btn-edit').removeClass('d-none');
    card.find('.btn-save, .btn-cancel').addClass('d-none');
  });
</script>

<script>
  /* Family Information actions start*/
  $(document).ready(function () {
    var alert_error = $('#error-alert');
    var alert_success = $('#success-alert');
    var error_message = $('#error-message');
    var success_message = $('#success-message');

    $('.btn-close').on('click', function () {
      $(this).closest('.alert').addClass('d-none');
    });

    $(document).on('click', '.btn-save', function () {
      saveFamilyInfo();
    });


    function saveFamilyInfo() {
      var idperson = $('#contentArea').data('idperson');
      // Reset alert terlebih dahulu
      alert_error.addClass('d-none');
      alert_success.addClass('d-none');

      fatherName = $('input[data-field="family.father.name"]').val().trim();
      motherName = $('input[data-field="family.mother.name"]').val().trim();
      address = $('textarea[data-field="family.address"]').val().trim();
      let isFatherNameValid = validateChildField(
        'fatherName',
        'fatherNameFeedback'
      );

      let isMotherNameValid = validateChildField(
        'motherName',
        'motherNameFeedback'
      );

      let isAddressValid = validateChildField(
        'address',
        'addressFeedback'
      );

      if (!isFatherNameValid || !isMotherNameValid || !isAddressValid) {
        return false;
      }

      var data = {
        idperson: idperson,
        fatherName: fatherName,
        motherName: motherName,
        wifeName: $('input[data-field="family.wife.name"]').val(),
        address: address
      };

      console.log('Saving family data:', data);

      $.ajax({
        url: "<?php echo base_url('CrewDetail/Family/updateFamilyInfo'); ?>",
        type: "POST",
        dataType: "json",
        data: data,
        success: function (res) {
          // console.log('Response:', res);
          if (res.status) {
            success_message.text(res.message);
            alert_success.removeClass('d-none');
            setTimeout(function () {
              alert_success.addClass('d-none');
            }, 3000);

            // Switch back to view mode
            const card = $('.btn-save').closest('.card');
            card.find('.form-view').removeClass('d-none');
            card.find('.form-edit').addClass('d-none');
            card.find('.btn-edit').removeClass('d-none');
            card.find('.btn-save, .btn-cancel').addClass('d-none');

            // Update view dengan data baru
            $('.form-view[data-field="family.father.name"]').text(data.fatherName || '');
            $('.form-view[data-field="family.mother.name"]').text(data.motherName || '');
            $('.form-view[data-field="family.wife.name"]').text(data.wifeName || '');
            $('.form-view[data-field="family.address"]').text(data.address || '');

          } else {
            error_message.text(res.message || 'Failed to update family information');
            alert_error.removeClass('d-none');
            setTimeout(function () {
              alert_error.addClass('d-none');
            }, 5000);
          }
        },
        error: function (xhr, status, error) {
          $('.btn-save').prop('disabled', false).html('<i class="fa fa-save"></i> Save');
          console.error('AJAX Error:', xhr.responseText);

          error_message.text('Failed to update family information: ' + error);
          alert_error.removeClass('d-none');
          setTimeout(function () {
            alert_error.addClass('d-none');
          }, 5000);
        }
      });
    }
  });
</script>






<script>
  /* Children Information actions start*/
  $(document).ready(function () {
    var alert_error = $('#child-danger-alert');
    var alert_success = $('#child-success-alert');
    var error_message = $('#child-error-message');
    var success_message = $('#child-success-message');

    loadFamilyData();

    $('#btnSaveChild').click(function () {
      saveChild();
    });

    // Delete child
    $(document).on('click', '.btn-delete-child', function () {
      var childId = $(this).data('id');
      var childName = $(this).data('name');
      deleteChild(childId, childName);
    });


    function saveChild() {
      let isFirstNameValid = validateChildField(
        'childFirstName',
        'childFirstNameFeedback'
      );

      let isGenderValid = validateChildField(
        'childGender',
        'childGenderFeedback'
      );

      let isDobValid = validateChildField(
        'childDob',
        'childDobFeedback'
      );

      if (!isFirstNameValid || !isGenderValid || !isDobValid) {
        return false;
      }

      var idperson = $('#contentArea').data('idperson');
      var data = {
        idfm: $('#childIdfm').val(),
        idperson: idperson,
        fmrel: 'CHILD',
        fmfname: $('#childFirstName').val(),
        fmlname: $('#childLastName').val(),
        fmsex: $('#childGender').val(),
        fmdob: $('#childDob').val(),
        fmpassno: $('#childPassport').val(),
        fmissdt: $('#childIssueDate').val(),
        fmplc: $('#childIssuePlace').val(),
        fmexpdt: $('#childExpiryDate').val(),
        fmvisa: $('#childVisa').val()
      };

      $.ajax({
        url: "<?php echo base_url('CrewDetail/Family/saveChild'); ?>",
        type: "POST",
        dataType: "json",
        data: data,
        beforeSend: function () {
          $('#btnSaveChild').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
        },
        success: function (res) {
          $('#btnSaveChild').prop('disabled', false).html('Save');
          console.log('Response:', res);

          if (res.status) {
            $('#childModal').modal('hide');
            loadFamilyData();
            success_message.text(res.message);
            alert_success.removeClass('d-none');
            setTimeout(function () {
              alert_success.addClass('d-none');
            }, 3000);

          } else {
            error_message.text(res.message || 'Failed to save child data');
            alert_error.removeClass('d-none');
          }
        },
        error: function (xhr, status, error) {
          $('#btnSaveChild').prop('disabled', false).html('Save');
          console.error('AJAX Error:', xhr.responseText);
          alert('Failed to save child data. Error: ' + error);
        }
      });
    }


    // Delete child
    function deleteChild(idfm, childName) {
      if (!confirm('Are you sure you want to delete "' + childName + '"?')) {
        return;
      }

      $.ajax({
        url: "<?php echo base_url('CrewDetail/Family/deleteChild'); ?>",
        type: "POST",
        dataType: "json",
        data: {
          idfm: idfm
        },
        success: function (res) {
          if (res.status) {
            loadFamilyData(); // Reload data
            success_message.text(res.message);
            alert_success.removeClass('d-none');
            setTimeout(function () {
              alert_success.addClass('d-none');
            }, 3000);

          } else {
            error_message.text(res.message || 'Failed to delete child');
            alert_error.removeClass('d-none');
            setTimeout(function () {
              alert_error.addClass('d-none');
            }, 3000);
          }

        },
        error: function () {
          alert('Failed to delete child');
        }
      });
    }

  });

  function loadFamilyData() {
    var idperson = $('#contentArea').data('idperson');
    $("#loginLoading").show();
    $.ajax({
      url: "<?php echo base_url('CrewDetail/Family/getFamilyData'); ?>",
      type: "POST",
      dataType: "json",
      data: {
        idperson: idperson
      },
      success: function (res) {
        // console.log('Family data response:', res);
        if (res.status) {
          renderFamily(res.data);
        } else {
          console.error('Error:', res.message);
        }
        $("#loginLoading").hide();
      },
      error: function (xhr, status, error) {
        console.error('Failed to load family data:', error);
      }
    });
  }


  function validateChildField(inputId, feedbackId) {
    let input = document.getElementById(inputId);
    let feedback = document.getElementById(feedbackId);
    input.classList.remove('is-valid', 'is-invalid');

    if (!input.value || input.value.trim() === '') {
      input.classList.add('is-invalid');
      feedback.style.display = 'block';
      return false;
    } else {
      input.classList.add('is-valid');
      feedback.style.display = 'none';
      return true;
    }
  }




  function renderChildren(children) {
    var $container = $('#childrenContainer');
    var $childrenCount = $('#childrenCount');

    // Update children count
    $childrenCount.text(children.length);

    if (children.length === 0) {
      $container.html(`
        <div class="text-center text-muted py-4">
          <i class="fa fa-child fa-2x mb-2"></i><br>
          No children data
        </div>
      `);
      return;
    }

    var html = '';
    children.forEach(function (child, index) {
      html += `
        <div class="child-item" data-id="${child.idfm}">
          <div class="d-flex justify-content-between align-items-start">
            <div style="flex: 1;">
              <strong class="d-block">${child.fullName}</strong>
              <small class="text-muted d-block fst-italic fw-semibold">
                <i class="fa fa-${child.gender === 'Male' ? 'mars' : 'venus'}"></i> ${child.gender}
                | DOB: ${child.dob}
              </small>
              ${child.passportNo ? `<small class="text-muted d-block fst-italic fw-semibold">Passport: ${child.passportNo}</small>` : ''}
            </div>
          <div class="child-actions">
                <button class="btn btn-sm btn-outline-primary btn-edit-child me-1" 
                        data-id="${child.idfm}" 
                        title="Edit">
                    <i class="fa fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger btn-delete-child" 
                        data-id="${child.idfm}" 
                        data-name="${child.fullName}"
                        title="Delete">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
          </div>
        </div>
      `;
    });

    $container.html(html);
  }

  // Fungsi untuk load child data ke modal (edit)
  function loadChildData(idfm) {
    $.ajax({
      url: "<?php echo base_url('CrewDetail/Family/getChildData'); ?>",
      type: "POST",
      dataType: "json",
      data: {
        idfm: idfm
      },
      beforeSend: function () {
        // Tampilkan loading jika perlu
      },
      success: function (res) {
        // console.log('Child data response:', res);
        if (res.status) {
          var childData = res.data;

          // Set data ke form
          $('#childModal .modal-title').text('Edit Child');
          $('#childIdfm').val(childData.idfm);
          $('#childIdperson').val(childData.idperson);
          $('#childFirstName').val(childData.fmfname);
          $('#childLastName').val(childData.fmlname);
          $('#childGender').val(childData.fmsex);

          // Format tanggal untuk input date (YYYY-MM-DD)
          $('#childDob').val(childData.fmdob);
          $('#childIssueDate').val(childData.fmissdt);
          $('#childExpiryDate').val(childData.fmexpdt);

          $('#childPassport').val(childData.fmpassno);
          $('#childIssuePlace').val(childData.fmplc);
          $('#childVisa').val(childData.fmvisa);

          // Tampilkan modal
          $('#childModal').modal('show');
        } else {
          alert(res.message || 'Failed to load child data');
        }
      },
      error: function (xhr, status, error) {
        console.error('Error loading child data:', error);
        alert('Failed to load child data');
      }
    });
  }

  // Event listener untuk tombol edit child
  $(document).on('click', '.btn-edit-child', function () {
    var childId = $(this).data('id');
    // console.log('Editing child ID:', childId);
    loadChildData(childId);
  });

  // Event listener untuk tombol add child
  $(document).on('click', '.btn-add-child', function () {
    var idperson = $('#contentArea').data('idperson');

    if (!idperson) {
      alert('Person ID not found!');
      return;
    }

    $('#childModal .modal-title').text('Add Child');
    $('#childForm')[0].reset(); // Reset form
    $('#childIdfm').val(''); // Kosongkan untuk add baru
    $('#childIdperson').val(idperson); // Set idperson
    $('#childModal').modal('show');
  });

  /*end of Children Information actions */
</script>

<script>
  function renderFamily(data) {
    console.log('Rendering family data:', data);

    // VIEW MODE - Family Information
    $('.form-view').each(function () {
      var field = $(this).data('field');
      if (!field) return;

      var value = getValueByPath({
        family: data
      }, field);
      $(this).text(value ? value : '-');
    });

    // EDIT MODE - Family Information
    $('.form-edit').each(function () {
      var field = $(this).data('field');
      if (!field) return;

      var value = getValueByPath({
        family: data
      }, field);
      if ($(this).is('textarea')) {
        $(this).val(value ? value : '');
      } else {
        $(this).val(value ? value : '');
      }
    });

    // Render children
    renderChildren(data.children || []);
  }

  // // Helper function untuk mengambil nilai dari nested object
  function getValueByPath(obj, path) {
    if (!obj || !path) return '';

    var parts = path.split('.');
    var current = obj;

    for (var i = 0; i < parts.length; i++) {
      if (current[parts[i]] === undefined || current[parts[i]] === null) {
        return '';
      }
      current = current[parts[i]];
    }

    return current;
  }
</script>