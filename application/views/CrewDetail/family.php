<div class="family-content">

  <div class="container-fluid mb-4">
    <div class="row">

      <!-- ================= FAMILY CARD ================= -->
      <div class="col-6 mb-4">
        <div class="card shadow-sm h-100">
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
                <label class="form-label mb-0 fst-italic fw-semibold">Father Name</label>
                <div class="form-view fst-italic" data-field="family.father.name"></div>
                <input type="text" class="form-control form-edit d-none" data-field="family.father.name">
              </div>

              <div class="col-12">
                <label class="form-label mb-0 fst-italic fw-semibold">Mother Name</label>
                <div class="form-view fst-italic" data-field="family.mother.name"></div>
                <input type="text" class="form-control form-edit d-none" data-field="family.mother.name">
              </div>

              <div class="col-12">
                <label class="form-label mb-0 fst-italic fw-semibold">Wife/Spouse Name</label>
                <div class="form-view fst-italic" data-field="family.wife.name"></div>
                <input type="text" class="form-control form-edit d-none" data-field="family.wife.name">
              </div>


              <div class="col-12">
                <label class="form-label mb-0 fst-italic fw-semibold">Address</label>
                <div class="form-view fst-italic" data-field="family.address"></div>
                <textarea class="form-control form-edit d-none" data-field="family.address" rows="2"></textarea>
              </div>

            </div>
          </div>
        </div>
      </div>

      <!-- ================= CHILDREN CARD ================= -->
      <div class="col-6 mb-4">
        <div class="card shadow-sm h-100">
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

<div id="idSuccess" class="text-center mt-3" style="background-color: transparent;">
  <img src="<?php echo base_url('assets/img/sama.gif'); ?>" width="30%" alt="Loading"
    style="background-color: transparent;">
</div>

<style>
  #idSuccess {
    position: fixed;
    top: 70%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
  }
</style>

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
  /* Children Information actions start*/
  $(document).ready(function () {
    loadFamilyData();
    $('#idSuccess').hide();
    $('#btnSaveChild').click(function () {
      saveChild();
    });

    // Delete child
    $(document).on('click', '.btn-delete-child', function () {
      var childId = $(this).data('id');
      var childName = $(this).data('name');
      deleteChild(childId, childName);
    });

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
        console.log('Family data response:', res);
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
          // alert(res.message);
          $('#childModal').modal('hide');
          loadFamilyData();
          $('#idSuccess').show();
          setTimeout(function () {
            $('#idSuccess').hide();
          }, 2000);

        } else {
          alert(res.message || 'Failed to save child data');
          $('#idSuccess').hide();
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
      beforeSend: function () {
        // Show loading
      },
      success: function (res) {
        if (res.status) {
          $('#idSuccess').show();
          // alert(res.message);
          loadFamilyData(); // Reload data
          setTimeout(function () {
            $('#idSuccess').hide();
          }, 2000);
        } else {
          alert(res.message || 'Failed to delete child');
          $('#idSuccess').hide();
        }

      },
      error: function () {
        alert('Failed to delete child');
      }
    });
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
        console.log('Child data response:', res);
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


