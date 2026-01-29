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
              <button class="btn btn-sm btn-outline-primary rounded-pill btn-add-child " data-bs-toggle="modal" data-bs-target="#childModal" >
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
            <div class="modal-body">
              <form id="childForm">
                <input type="hidden" name="idfm" id="childIdfm">
                <input type="hidden" name="idperson" id="childIdperson">
                <input type="hidden" name="fmrel" value="CHILD">

                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label">First Name *</label>
                    <input type="text" class="form-control" name="fmfname" id="childFirstName" required>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="fmlname" id="childLastName">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Gender *</label>
                    <select class="form-control" name="fmsex" id="childGender" required>
                      <option value="">- Select -</option>
                      <option value="1">Male</option>
                      <option value="2">Female</option>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" name="fmdob" id="childDob">
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

<!-- ================= STYLE ================= -->
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

<!-- ================= BUTTON ACTION ================= -->
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
  $(document).ready(function () {
    loadFamilyData();

    function loadFamilyData() {
      var idperson = $('#contentArea').data('idperson');

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
        },
        error: function (xhr, status, error) {
          console.error('Failed to load family data:', error);
        }
      });
    }
  });
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
            <button class="btn btn-sm btn-outline-info btn-view-child" data-id="${child.idfm}">
              <i class="fa fa-eye"></i>
            </button>
          </div>
        </div>
      `;
    });

    $container.html(html);
  }

  // Helper function untuk mengambil nilai dari nested object
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