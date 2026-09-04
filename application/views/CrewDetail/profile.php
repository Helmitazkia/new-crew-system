<div class="profile-content">
  <div class="container-fluid mb-4">
    <div class="row g-3 mb-4">
      <!-- FOTO -->
      <div class="col-lg-3 col-md-4 col-sm-12 text-center">
        <div class="card shadow-sm h-100">
          <div class="card-body position-relative">
            <div class="crew-photo-wrap position-relative mb-3">
              <img class="img-fluid rounded d-block mx-auto" style="max-height: 240px; object-fit: cover;"
                alt="Crew Photo" data-field="identity.pictureProfile" id="crewPhoto" src="">
            </div>
            <div id="profilePhotoAlert" class="alert alert-success small py-2 d-none mb-0"></div>
            <h6 class="fw-bold mb-0 crew-name" data-field="identity.fullName"></h6>
            <small class="text-muted crew-id" data-field="identity.idperson"></small>

             <input type="file" id="profilePhotoInput" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp" class="d-none">
              <div class="text-center mt-2">
                <button type="button" class="btn btn-sm btn-outline-primary" id="btnEditPhoto" title="Edit Foto">
                  <i class="fa fa-camera"></i> Edit Foto
                </button>
              </div>
          </div>
        </div>
      </div>

      <!-- BASIC IDENTITY -->
      <div class="col-lg-7 col-md-8 col-sm-12">

        <div class="card shadow-sm h-100" id="basicIdentityCard">
          <div
            class="alert alert-success d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
            role="alert" id="basic-success-alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
              <use xlink:href="#check-circle-fill" />
            </svg>
            <div class="flex-grow-1">
              <span id="basic-success-message"></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>

          <!-- Alert wrong Message  -->
          <div
            class="alert alert-danger  d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
            role="alert" id="basic-danger-alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
              <use xlink:href="#exclamation-triangle-fill" />
            </svg>
            <div class="flex-grow-1">
              <span id="basic-error-message"></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <br>

          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-semibold fst-italic">🪪 Basic Identity</span>

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

              <!-- Old Crew ID -->
              <div class="col-md-4">
                <label class="form-label mb-0 fst-italic fw-semibold">Old Crew ID</label>
                <div class="form-view fst-italic" data-field="identity.oldCrewId"></div>
                <input type="text" class="form-control form-edit d-none" data-field="identity.oldCrewId">
              </div>

              <!-- Old Contract Number -->
              <div class="col-md-4">
                <label class="form-label mb-0 fst-italic fw-semibold">Old Contract Number</label>
                <div class="form-view fst-italic" data-field="identity.oldContractNo"></div>
                <input type="text" class="form-control form-edit d-none" data-field="identity.oldContractNo">
              </div>

              <!-- Seafarer Code -->
              <div class="col-md-4">
                <label class="form-label mb-0 fst-italic fw-semibold">Seafarer Code</label>
                <div class="form-view fst-italic" data-field="identity.seafarerCode"></div>
                <input type="text" class="form-control form-edit d-none" data-field="identity.seafarerCode">
              </div>

              <!-- First Name -->
              <div class="col-md-4">
                <label class="form-label mb-0 fst-italic fw-semibold">First Name <span style="color: red;">*</span></label>
                <div class="form-view fst-italic" data-field="identity.firstName"></div>
                <input type="text" class="form-control form-edit d-none" data-field="identity.firstName">
              </div>

              <!-- Middle Name -->
              <div class="col-md-4">
                <label class="form-label mb-0 fst-italic fw-semibold">Middle Name</label>
                <div class="form-view fst-italic" data-field="identity.middleName"></div>
                <input type="text" class="form-control form-edit d-none" data-field="identity.middleName">
              </div>

              <!-- Last Name -->
              <div class="col-md-4">
                <label class="form-label mb-0 fst-italic fw-semibold">Last Name</label>
                <div class="form-view fst-italic" data-field="identity.lastName"></div>
                <input type="text" class="form-control form-edit d-none" data-field="identity.lastName">
              </div>

              <!-- Gender -->
              <div class="col-md-4">
                <label class="form-label mb-0 fst-italic fw-semibold">Gender <span style="color: red;">*</span></label>
                <div class="form-view fst-italic" data-field="identity.gender"></div>
                <select class="form-select form-edit d-none" data-field="identity.gender">
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>

              <!-- Nationality -->
              <div class="col-md-4">
                <label class="form-label mb-0 fst-italic fw-semibold">
                  Nationality (Citizenship)
                </label>
                <div class="form-view fst-italic" data-field="identity.nationality"></div>
                <select class="form-select form-edit d-none" data-field="identity.nationality">
                  <?php echo $optCountry; ?>
                </select>
              </div>

              <!-- Country of Origin -->
              <div class="col-md-4">
                <label class="form-label mb-0 fst-italic fw-semibold">
                  Country of Origin
                </label>
                <div class="form-view fst-italic" data-field="identity.countryOrigin"></div>
                <select class="form-select form-edit d-none" data-field="identity.countryOrigin">
                  <?php echo $optCountry; ?>
                </select>
              </div>

              <!-- Date of Birth -->
              <div class="col-md-4">
                <label class="form-label mb-0 fst-italic fw-semibold">Date of Birth</label>
                <div class="form-view fst-italic" data-field="identity.dob"></div>
                <input type="date" class="form-control form-edit d-none" data-field="identity.dobForEdit">
              </div>

              <!-- Place of Birth -->
              <div class="col-md-4">
                <label class="form-label mb-0 fst-italic fw-semibold">
                  Place / City of Birth
                </label>
                <div class="form-view fst-italic" data-field="identity.pob"></div>
                <select class="form-select form-edit d-none" data-field="identity.pob">
                  <?php echo $optCity; ?>
                </select>
              </div>

              <!-- Religion -->
              <div class="col-md-4">
                <label class="form-label mb-0 fst-italic fw-semibold">Religion</label>
                <div class="form-view fst-italic" data-field="identity.religion"></div>
                <select class="form-select form-edit d-none" data-field="identity.religion">
                  <option value="Moeslem">Moeslem</option>
                  <option value="Christian">Christian</option>
                  <option value="Catholic">Catholic</option>
                  <option value="Hindu">Hindu</option>
                  <option value="Buddha">Buddha</option>
                </select>
              </div>

              <!-- Marital Status -->
              <div class="col-md-4">
                <label class="form-label mb-0 fst-italic fw-semibold">
                  Marital Status
                </label>
                <div class="form-view fst-italic" data-field="identity.maritalStatus"></div>
                <select class="form-select form-edit d-none" data-field="identity.maritalStatus">
                  <option value="Married">Married</option>
                  <option value="Single">Single</option>
                  <option value="Divorced">Divorced</option>
                  <option value="Commond Law Partner">Commond Law Partner</option>
                  <option value="Widowed">Widowed</option>
                  <option value="Separated">Separated</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-2 col-xs-12">
        <div class="card shadow-sm h-100" id="crewStatusCard">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-semibold fst-italic">🟢 Crew Status</span>

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
              <div class="col-12 form-view" id="crewStatusViewSummary">
                <label class="form-label mb-1 fst-italic fw-semibold">Crew Status</label>
                <div class="fst-italic" id="crewStatusSummaryText">-</div>
                <label class="form-label mt-2 mb-1 fst-italic fw-semibold">Notes</label>
                <div class="fst-italic text-muted" id="crewStatusNotesText">-</div>
              </div>
              <div class="col-12 form-edit d-none">
                <label class="form-label mb-1 fst-italic fw-semibold">Crew Status</label>
                <div class="d-flex flex-column gap-1">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="crewStatus_newApplicant" data-field="crewStatus.newApplicant">
                    <label class="form-check-label fst-italic text-muted" for="crewStatus_newApplicant">New Applicant</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="crewStatus_nonAktif" data-field="crewStatus.nonAktif">
                    <label class="form-check-label fst-italic" for="crewStatus_nonAktif">Non Aktif</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="crewStatus_blackList" data-field="crewStatus.blackList">
                    <label class="form-check-label fst-italic" for="crewStatus_blackList">Not for Employed</label>
                  </div>
                  <div class="form-check d-none">
                    <input class="form-check-input" type="checkbox" id="crewStatus_nonCrew" data-field="crewStatus.nonCrew" disabled>
                    <label class="form-check-label fst-italic text-muted" for="crewStatus_nonCrew">Non Crew</label>
                  </div>
                  <div class="mt-2">
                    <label class="form-label mb-1 fst-italic fw-semibold">Notes</label>
                    <textarea class="form-control form-control-sm" id="crewStatus_notes" rows="2" placeholder="Tulis catatan jika ada perubahan status..."></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer bg-transparent border-0 text-end pt-0 pb-2">
            <button class="btn btn-sm btn-outline-info btn-history">
              <i class="fa fa-history"></i> History
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Crew Status History Modal -->
  <div class="modal fade" id="crewStatusHistoryModal" tabindex="-1" aria-labelledby="crewStatusHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="crewStatusHistoryModalLabel">Crew Status History</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-bordered table-sm small">
              <thead class="table-light">
                <tr>
                  <th>Time Update</th>
                  <th>Status</th>
                  <th>Notes</th>
                  <th>Created By</th>
                </tr>
              </thead>
              <tbody id="crewStatusHistoryTableBody">
                <!-- Data will be loaded via AJAX -->
              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid mb-4">
    <div class="row">
      <div class="col-6 mb-4 col-xs-12">
        <div class="card shadow-sm h-100" id="familyinformation">
          <div
            class="alert alert-success d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
            role="alert" id="family-success-alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
              <use xlink:href="#check-circle-fill" />
            </svg>
            <div class="flex-grow-1">
              <span id="family-success-message"></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>

          <!-- Alert wrong Message  -->
          <div
            class="alert alert-danger  d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
            role="alert" id="family-error-alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
              <use xlink:href="#exclamation-triangle-fill" />
            </svg>
            <div class="flex-grow-1">
              <span id="family-error-message"></span>
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
                <label class="form-label mb-0 fst-italic fw-semibold">Father Name</label>
                <div class="form-view fst-italic" data-field="family.fatherName"></div>
                <input type="text" class="form-control form-edit d-none" data-field="family.fatherName">
              </div>

              <div class="col-12">
                <label class="form-label mb-0 fst-italic fw-semibold">Mother Name</label>
                <div class="form-view fst-italic" data-field="family.motherName"></div>
                <input type="text" class="form-control form-edit d-none" data-field="family.motherName">
              </div>

              <div class="col-12">
                <label class="form-label mb-0 fst-italic fw-semibold">Wife Name</label>
                <div class="form-view fst-italic" data-field="family.wifeName"></div>
                <input type="text" class="form-control form-edit d-none" data-field="family.wifeName">
              </div>

              <div class="col-12">
                <label class="form-label mb-0 fst-italic fw-semibold">Next of Kin</label>
                <div class="form-view fst-italic" data-field="family.nextOfKin"></div>
                <input type="text" class="form-control form-edit d-none" data-field="family.nextOfKin">
              </div>

            </div>
          </div>
        </div>
      </div>

      <div class="col-6 mb-4">
        <div class="card shadow-sm h-100" id="legalTaxCard">
          <div
            class="alert alert-success d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
            role="alert" id="tax-success-alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
              <use xlink:href="#check-circle-fill" />
            </svg>
            <div class="flex-grow-1">
              <span id="tax-success-message"></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>

          <!-- Alert wrong Message  -->
          <div
            class="alert alert-danger  d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
            role="alert" id="tax-error-alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
              <use xlink:href="#exclamation-triangle-fill" />
            </svg>
            <div class="flex-grow-1">
              <span id="tax-error-message"></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-semibold fst-italic">💼 Tax & Social Security</span>

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

              <div class="col-md-6">
                <label class="form-label mb-0 fst-italic fw-semibold">Social Security Number</label>
                <div class="form-view fst-italic" data-field="legal.ssn"></div>
                <input type="text" class="form-control form-edit d-none" data-field="legal.ssn">
              </div>

              <div class="col-md-6">
                <label class="form-label mb-0 fst-italic fw-semibold">SS Issuing Country</label>
                <div class="form-view fst-italic" data-field="legal.ssnCountry"></div>
                <select class="form-select form-edit d-none" data-field="legal.ssnCountry">
                  <?php echo $optCountry; ?>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label mb-0 fst-italic fw-semibold">Personal Tax Number</label>
                <div class="form-view fst-italic" data-field="legal.taxNumber"></div>
                <input type="text" class="form-control form-edit d-none" data-field="legal.taxNumber">
              </div>

              <div class="col-md-6">
                <label class="form-label mb-0 fst-italic fw-semibold">Tax Issuing Country</label>
                <div class="form-view fst-italic" data-field="legal.taxCountry"></div>
                <select class="form-select form-edit d-none" data-field="legal.taxCountry">
                  <?php echo $optCountry; ?>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label mb-0 fst-italic fw-semibold">Tax Status</label>
                <div class="form-view fst-italic" data-field="legal.taxStatus"></div>
                <select class="form-select form-edit d-none" data-field="legal.taxStatus">
                  <?php echo $optTax; ?>
                </select>
              </div>

            </div>
          </div>
        </div>
      </div>


      <div class="container-fluid mb-4">
        <div class="row">
          <div class="col-6 mb-4">
            <div class="card shadow-sm h-100" id="contactAddressCard">
              <div
                class="alert alert-success d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
                role="alert" id="contact-success-alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                  <use xlink:href="#check-circle-fill" />
                </svg>
                <div class="flex-grow-1">
                  <span id="contact-success-message"></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>

              <!-- Alert wrong Message  -->
              <div
                class="alert alert-danger  d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
                role="alert" id="contact-error-alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                  <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div class="flex-grow-1">
                  <span id="contact-error-message"></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold fst-italic">📞 Contact & Address</span>

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
                    <label class="form-label mb-0 fst-italic fw-semibold">Primary / Permanent Address</label>
                    <div class="form-view fst-italic" data-field="contact.address"></div>
                    <textarea class="form-control form-edit d-none" data-field="contact.address"></textarea>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">City</label>
                    <div class="form-view fst-italic" data-field="contact.city"></div>
                    <select class="form-select form-edit d-none" data-field="contact.city">
                      <?php echo $optCity; ?>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Post Code</label>
                    <div class="form-view fst-italic" data-field="contact.postcode"></div>
                    <input type="text" class="form-control form-edit d-none" data-field="contact.postcode">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Country</label>
                    <div class="form-view fst-italic" data-field="contact.country"></div>
                    <select class="form-select form-edit d-none" data-field="contact.country">
                      <?php echo $optCountry; ?>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Nearest Airport</label>
                    <div class="form-view fst-italic" data-field="contact.airport"></div>
                    <!-- <input type="text" class="form-control form-edit d-none" data-field="contact.airport"> -->
                    <select class="form-select form-edit d-none" data-field="contact.airport">
                      <?php echo $optCity; ?>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Mobile Tel.</label>
                    <div class="form-view fst-italic" data-field="contact.mobile"></div>
                    <input type="text" class="form-control form-edit d-none" data-field="contact.mobile">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Emergency Contact</label>
                    <div class="form-view fst-italic" data-field="contact.home"></div>
                    <input type="text" class="form-control form-edit d-none" data-field="contact.home">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Fax</label>
                    <div class="form-view fst-italic" data-field="contact.fax"></div>
                    <input type="text" class="form-control form-edit d-none" data-field="contact.fax">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Email</label>
                    <div class="form-view fst-italic" data-field="contact.email"></div>
                    <input type="email" class="form-control form-edit d-none" data-field="contact.email">
                  </div>

                  <!-- CONTACT METHOD -->
                  <div class="col-12 mt-2">
                    <label class="form-label mb-1 fst-italic fw-semibold">Contact Method</label>

                    <!-- VIEW -->
                    <div class="form-view fst-italic">
                      Email, Fax, Mobile Phone, Home Phone, Post
                    </div>

                    <!-- EDIT -->
                    <div class="form-edit d-none">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" data-field="contactMethod.email">
                        <label class="form-check-label">Email</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" data-field="contactMethod.fax">
                        <label class="form-check-label">Fax</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" data-field="contactMethod.mobile">
                        <label class="form-check-label">Mobile Phone</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" data-field="contactMethod.home">
                        <label class="form-check-label">Home Phone</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" data-field="contactMethod.post">
                        <label class="form-check-label">Post</label>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

          <div class="col-6 mb-4">
            <div class="card shadow-sm h-100" id="physicalMedicalCard">
              <div
                class="alert alert-success d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
                role="alert" id="physical-success-alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                  <use xlink:href="#check-circle-fill" />
                </svg>
                <div class="flex-grow-1">
                  <span id="physical-success-message"></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>

              <!-- Alert wrong Message  -->
              <div
                class="alert alert-danger  d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
                role="alert" id="physical-error-alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                  <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div class="flex-grow-1">
                  <span id="physical-error-message"></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold fst-italic">🩺 Physical & Medical</span>

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

                  <div class="col-md-4">
                    <label class="form-label mb-0 fst-italic fw-semibold">Blood Type</label>
                    <div class="form-view fst-italic" data-field="physical.bloodType"></div>
                    <select class="form-select form-edit d-none" data-field="physical.bloodType">
                      <?php echo $optBlood; ?>
                    </select>
                  </div>

                  <div class="col-md-4">
                    <label class="form-label mb-0 fst-italic fw-semibold">Eye Color</label>
                    <div class="form-view fst-italic" data-field="physical.eyeColor"></div>
                    <input type="text" class="form-control form-edit d-none" data-field="physical.eyeColor"
                      value="Brown">
                  </div>

                  <div class="col-md-4">
                    <label class="form-label mb-0 fst-italic fw-semibold">Weight (kg)</label>
                    <div class="form-view fst-italic" data-field="physical.weight"></div>
                    <input type="number" class="form-control form-edit d-none" data-field="physical.weight" value="70">
                  </div>

                  <div class="col-md-4">
                    <label class="form-label mb-0 fst-italic fw-semibold">Height (cm)</label>
                    <div class="form-view fst-italic" data-field="physical.height"></div>
                    <input type="number" class="form-control form-edit d-none" data-field="physical.height" value="175">
                  </div>

                  <div class="col-md-4">
                    <label class="form-label mb-0 fst-italic fw-semibold">Shoes (mm)</label>
                    <div class="form-view fst-italic" data-field="physical.shoesz"></div>
                    <input type="number" class="form-control form-edit d-none" data-field="physical.shoesz" value="270">
                  </div>

                  <div class="col-md-4">
                    <label class="form-label mb-0 fst-italic fw-semibold">Collar (cm)</label>
                    <div class="form-view fst-italic" data-field="physical.collar"></div>
                    <input type="number" class="form-control form-edit d-none" data-field="physical.collar" value="40">
                  </div>

                  <div class="col-md-4">
                    <label class="form-label mb-0 fst-italic fw-semibold">Chest (cm)</label>
                    <div class="form-view fst-italic" data-field="physical.chest"></div>
                    <input type="number" class="form-control form-edit d-none" data-field="physical.chest" value="98">
                  </div>

                  <div class="col-md-4">
                    <label class="form-label mb-0 fst-italic fw-semibold">Waist (cm)</label>
                    <div class="form-view fst-italic" data-field="physical.waist"></div>
                    <input type="number" class="form-control form-edit d-none" data-field="physical.waist" value="82">
                  </div>

                  <div class="col-md-4">
                    <label class="form-label mb-0 fst-italic fw-semibold">Ins. Leg (cm)</label>
                    <div class="form-view fst-italic" data-field="physical.Insdleg"></div>
                    <input type="number" class="form-control form-edit d-none" data-field="physical.Insdleg" value="78">
                  </div>

                  <div class="col-md-4">
                    <label class="form-label mb-0 fst-italic fw-semibold">Clothes Size</label>
                    <div class="form-view fst-italic" data-field="physical.clothesSize"></div>
                    <select class="form-select form-edit d-none" data-field="physical.clothesSize">
                      <?php echo $optSize; ?>
                    </select>
                  </div>

                  <div class="col-md-4">
                    <label class="form-label mb-0 fst-italic fw-semibold">Boilersuit Size</label>
                    <div class="form-view fst-italic" data-field="physical.boilerszid"></div>
                    <select class="form-select form-edit d-none" data-field="physical.boilerszid">
                      <?php echo $optSize; ?>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Height Phobia</label>
                    <div class="form-view fst-italic" data-field="physical.heightPhobia"></div>
                    <select class="form-select form-edit d-none" data-field="physical.heightPhobia">
                      <option value="No">No</option>
                      <option value="Yes">Yes</option>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Feel Claustrophobic</label>
                    <div class="form-view fst-italic" data-field="physical.claustrophob"></div>
                    <select class="form-select form-edit d-none" data-field="physical.claustrophob">
                      <option value="No">No</option>
                      <option value="Yes">Yes</option>
                    </select>
                  </div>

                  <div class="col-12">
                    <label class="form-label mb-0 fst-italic fw-semibold">Any Allergy</label>
                    <div class="form-view fst-italic" data-field="physical.allergy"></div>
                    <textarea class="form-control form-edit d-none" data-field="physical.allergy">None</textarea>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-6 mb-4">
            <div class="card shadow-sm h-100" id="assessmentCard">
              <div
                class="alert alert-success d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
                role="alert" id="assessment-success-alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                  <use xlink:href="#check-circle-fill" />
                </svg>
                <div class="flex-grow-1"><span id="assessment-success-message"></span></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <div
                class="alert alert-danger d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
                role="alert" id="assessment-danger-alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                  <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div class="flex-grow-1"><span id="assessment-error-message"></span></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
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
                <div class="row g-2">
                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">CES Score</label>
                    <div class="form-view fst-italic" data-field="assessment.cesScore"></div>
                    <input type="number" class="form-control form-edit d-none" data-field="assessment.cesScore" placeholder="">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Marlin Test Score</label>
                    <div class="form-view fst-italic" data-field="assessment.marlinScore"></div>
                    <input type="number" class="form-control form-edit d-none" data-field="assessment.marlinScore" placeholder="">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Psychometric Score</label>
                    <div class="form-view fst-italic" data-field="assessment.psychometricScore"></div>
                    <input type="number" class="form-control form-edit d-none" data-field="assessment.psychometricScore" placeholder="">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">OTG Score</label>
                    <div class="form-view fst-italic" data-field="assessment.otgScore"></div>
                    <input type="number" class="form-control form-edit d-none" data-field="assessment.otgScore" placeholder="">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Training Date</label>
                    <div class="form-view fst-italic" data-field="assessment.trainingDate"></div>
                    <input type="date" class="form-control form-edit d-none" data-field="assessment.trainingDateForEdit">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Evaluation</label>
                    <div class="form-view fst-italic" data-field="assessment.evaluation"></div>
                    <input type="text" class="form-control form-edit d-none" data-field="assessment.evaluation" placeholder="">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Career & Placement -->
          <div class="col-6 mb-4">
            <div class="card shadow-sm h-100" id="careerPlacementCard">
              <div
                class="alert alert-success d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
                role="alert" id="career-success-alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                  <use xlink:href="#check-circle-fill" />
                </svg>
                <div class="flex-grow-1">
                  <span id="career-success-message"></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>

              <!-- Alert wrong Message  -->
              <div
                class="alert alert-danger  d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
                role="alert" id="career-error-alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                  <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div class="flex-grow-1">
                  <span id="career-error-message"></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold fst-italic">🧭 Career & Placement</span>

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

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Rank Applied For</label>
                    <div class="form-view fst-italic" data-field="career.rankApply"></div>
                    <select class="form-select form-edit d-none" data-field="career.rankApply">
                      <?php echo $optRank; ?>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Vessel Applied For</label>
                    <div class="form-view fst-italic" data-field="career.vesselApply"></div>
                    <select class="form-select form-edit d-none" data-field="career.vesselApply">
                      <?php echo $vesselname; ?>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Crew Vessel Type</label>
                    <div class="form-view fst-italic" data-field="career.vesselType"></div>
                    <select class="form-select form-edit d-none" data-field="career.vesselType">
                      <?php echo $optVessel; ?>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">
                      Willing to Accept Lower Rank
                    </label>
                    <div class="form-view fst-italic" data-field="career.lowerRank"></div>
                    <select class="form-select form-edit d-none" data-field="career.lowerRank">
                      <option value="Yes">Yes</option>
                      <option value="No">No</option>
                    </select>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Available From</label>
                    <div class="form-view fst-italic" data-field="career.availableDate"></div>
                    <input type="date" class="form-control form-edit d-none" data-field="career.edt_availableDate">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- HOME SALARY -->
          <div class="col-6 mb-4">
            <div class="card shadow-sm h-100" id="salaryHomeCard">
              <div
                class="alert alert-success d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
                role="alert" id="home-success-alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                  <use xlink:href="#check-circle-fill" />
                </svg>
                <div class="flex-grow-1">
                  <span id="home-success-message"></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>

              <!-- Alert wrong Message  -->
              <div
                class="alert alert-danger  d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
                role="alert" id="home-error-alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                  <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div class="flex-grow-1">
                  <span id="home-error-message"></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold fst-italic">🏠 Home Salary</span>

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
                  <!-- <div class="col-md-6">
                      <label class="form-label mb-0 fst-italic fw-semibold">Home Salary</label>
                      <div class="form-view fst-italic" data-field="salary.home.percentage_home_salary"></div>
                      <input type="text" class="form-control form-edit d-none" value="1500">
                    </div> -->

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Percentage</label>
                    <div class="form-view fst-italic" data-field="salary.home.percentage"></div>
                    <input type="number" class="form-control form-edit d-none" value="60"
                      data-field="salary.home.percentage">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Bank Name</label>
                    <div class="form-view fst-italic" data-field="salary.home.bank"></div>
                    <input type="text" class="form-control form-edit d-none" value="BNI" data-field="salary.home.bank">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Account Number</label>
                    <div class="form-view fst-italic" data-field="salary.home.accountNo"></div>
                    <input type="text" class="form-control form-edit d-none" value="1234567890"
                      data-field="salary.home.accountNo">
                  </div>

                  <div class="col-12">
                    <label class="form-label mb-0 fst-italic fw-semibold">Account Name</label>
                    <div class="form-view fst-italic" data-field="salary.home.accountName"></div>
                    <input type="text" class="form-control form-edit d-none" value="A LOLO GADING"
                      data-field="salary.home.accountName">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Board Salary -->
          <div class="col-6 mb-4">
            <div class="card shadow-sm h-100" id="salaryBoardCard">
              <div
                class="alert alert-success d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
                role="alert" id="board-success-alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                  <use xlink:href="#check-circle-fill" />
                </svg>
                <div class="flex-grow-1">
                  <span id="board-success-message"></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>

              <!-- Alert wrong Message  -->
              <div
                class="alert alert-danger  d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
                role="alert" id="board-error-alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                  <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div class="flex-grow-1">
                  <span id="board-error-message"></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold fst-italic">🚢 Board Salary</span>

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
                  <!-- <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Board Salary</label>
                    <div class="form-view fst-italic" data-field="salary.board.salary"></div>
                    <input type="text" class="form-control form-edit d-none" value="2500">
                  </div> -->

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Percentage</label>
                    <div class="form-view fst-italic" data-field="salary.board.percentage"></div>
                    <input type="number" class="form-control form-edit d-none" value="40"
                      data-field="salary.board.percentage">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Bank Name</label>
                    <div class="form-view fst-italic" data-field="salary.board.bank"></div>
                    <input type="text" class="form-control form-edit d-none" value="Mandiri"
                      data-field="salary.board.bank">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Account Number</label>
                    <div class="form-view fst-italic" data-field="salary.board.accountNo"></div>
                    <input type="text" class="form-control form-edit d-none" value="9876543210"
                      data-field="salary.board.accountNo">
                  </div>

                  <div class="col-12">
                    <label class="form-label mb-0 fst-italic fw-semibold">Account Name</label>
                    <div class="form-view fst-italic" data-field="salary.board.accountName"></div>
                    <input type="text" class="form-control form-edit d-none" value="A LOLO GADING"
                      data-field="salary.board.accountName">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <script>
            document.addEventListener('DOMContentLoaded', function() {
                const homePerc = document.querySelector('input[data-field="salary.home.percentage"]');
                const boardPerc = document.querySelector('input[data-field="salary.board.percentage"]');
                
                if(homePerc && boardPerc) {
                    homePerc.addEventListener('input', function() {
                        let val = parseFloat(this.value) || 0;
                        if(val > 100) { val = 100; this.value = val; }
                        if(val < 0) { val = 0; this.value = val; }
                        boardPerc.value = 100 - val;
                    });
                    
                    boardPerc.addEventListener('input', function() {
                        let val = parseFloat(this.value) || 0;
                        if(val > 100) { val = 100; this.value = val; }
                        if(val < 0) { val = 0; this.value = val; }
                        homePerc.value = 100 - val;
                    });
                }
            });
          </script>

          <!-- Attachments -->
          <!-- <div class="col-6 mb-4">
            <div class="card shadow-sm">
              <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold fst-italic">📎 Attachments</span>

                <div class="action-btn">
                  <button class="btn btn-sm btn-outline-primary btn-edit">
                    <i class="fa fa-upload"></i> Upload
                  </button>
                </div>
              </div>

              <div class="card-body small">
                <div class="row g-2">

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Statement of Wages</label>
                    <input type="file" class="form-control form-control-sm">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Statement</label>
                    <input type="file" class="form-control form-control-sm">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Interview File</label>
                    <input type="file" class="form-control form-control-sm">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Evaluation File</label>
                    <input type="file" class="form-control form-control-sm">
                  </div>

                </div>
              </div>
            </div>
          </div> -->

          <div class="col-6 mb-4">
            <div class="card shadow-sm h-100" id="declarationCard">
              <div
                class="alert alert-success d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
                role="alert" id="declaration-success-alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                  <use xlink:href="#check-circle-fill" />
                </svg>
                <div class="flex-grow-1">
                  <span id="declaration-success-message"></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>

              <!-- Alert wrong Message  -->
              <div
                class="alert alert-danger  d-flex align-items-center fw-semibold fst-italic alert-dismissible fade show d-none"
                role="alert" id="decralation-error-alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="danger:">
                  <use xlink:href="#exclamation-triangle-fill" />
                </svg>
                <div class="flex-grow-1">
                  <span id="decralation-error-message"></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold fst-italic">✍️ Declaration & Signature</span>

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

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Sign Place</label>
                    <div class="form-view fst-italic" data-field="declaration.signPlace"></div>
                    <input type="text" class="form-control form-edit d-none" value="Jakarta"
                      data-field="declaration.signPlace">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Sign Date</label>
                    <div class="form-view fst-italic" data-field="declaration.signDate"></div>
                    <input type="date" class="form-control form-edit d-none" data-field="declaration.edt_signDate">
                  </div>

                  <div class="col-12">
                    <label class="form-label mb-0 fst-italic fw-semibold">Additional Remarks</label>
                    <div class="form-view fst-italic" data-field="declaration.remarks">
                    </div>
                    <textarea class="form-control form-edit d-none" rows="3" data-field="declaration.remarks">

              </textarea>
                  </div>

                </div>
              </div>
            </div>
          </div>

          <!-- Category Personal ID (below Declaration & Signature) -->
          <div class="card shadow-sm mt-3" id="personalDocCard">
            <div class="card-header d-flex justify-content-between align-items-center p-9">
              <span class="fw-semibold fst-italic">🪪 Personal ID</span>
              <button type="button" class="btn btn-sm btn-primary" id="btnNewPersonalDoc">
                <i class="fa fa-plus"></i> Add
              </button>
            </div>
            <div class="card-body small">
              <div class="table-responsive">
                <table id="personalDocTable" class="table table-bordered align-middle mb-0 crew-table" style="width:100%;font-size:12px;">
                  <thead class="crew-header">
                    <tr>
                      <th class="text-center">No</th>
                      <th>Type of Document ID</th>
                      <th>Country of Issue</th>
                      <th>No Doc</th>
                      <th>Date of Issue</th>
                      <th>Issue at (Place)</th>
                      <th>Valid Until</th>
                      <th class="text-center">Notes</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <thead>
                    <tr class="personal-doc-search-row">
                      <th></th>
                      <th><input type="text" class="form-control form-control-sm column-search" placeholder="Search"></th>
                      <th><input type="text" class="form-control form-control-sm column-search" placeholder="Search"></th>
                      <th><input type="text" class="form-control form-control-sm column-search" placeholder="Search"></th>
                      <th><input type="text" class="form-control form-control-sm column-search" placeholder="Search"></th>
                      <th><input type="text" class="form-control form-control-sm column-search" placeholder="Search"></th>
                      <th><input type="text" class="form-control form-control-sm column-search" placeholder="Search"></th>
                      <th><input type="text" class="form-control form-control-sm column-search" placeholder="Search"></th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- Modal Add/Edit Personal Doc -->
          <div class="modal fade" id="personalDocModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header text-white" style="background-color:#000099;">
                  <h5 class="modal-title" id="personalDocModalTitle">Add Personal Document</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <form id="personalDocForm">
                    <input type="hidden" name="idperdoc" id="personalDoc_idperdoc">
                    <input type="hidden" name="idperson" id="personalDoc_idperson">
                    <div class="row g-2">
                      <div class="col-md-6 d-none">
                        <label class="form-label fw-semibold">Kd Cert</label>
                        <input type="text" class="form-control" name="kdcert" id="personalDoc_kdcert" placeholder="Optional" readonly>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-semibold">Type of Document ID <span class="text-danger">*</span></label>
                        <select class="form-control" name="doctp" id="personalDoc_doctp">
                          <option value="KTP">KTP</option>
                          <option value="KK">KK</option>
                          <option value="NPWP">NPWP</option>
                          <option value="NOMOR REKENING">NOMOR REKENING</option>
                          <option value="SEAMAN BOOK">SEAMAN BOOK</option>
                          <option value="PASSPORT">PASSPORT</option>
                        </select>
                        <!-- <input type="text" class="form-control" name="doctp" id="personalDoc_doctp" placeholder="e.g. Passport, KTP"> -->
                        <small id="personalDoc_doctpFeedback" class="text-danger d-none">Type of Document ID is required</small>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-semibold">Country of Issue</label>
                        <select class="form-control" name="docissctryid" id="personalDoc_docissctryid">
                          <option value="">- Select -</option>
                          <?php echo isset($optCountry) ? $optCountry : ''; ?>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-semibold">No Doc <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="docno" id="personalDoc_docno" placeholder="Document number">
                        <small id="personalDoc_docnoFeedback" class="text-danger d-none">No Doc is required</small>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-semibold">Date of Issue <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="docissdt" id="personalDoc_docissdt">
                        <small id="personalDoc_docissdtFeedback" class="text-danger d-none">Date of Issue is required</small>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-semibold">Issue at (Place)</label>
                        <input type="text" class="form-control" name="docissplc" id="personalDoc_docissplc" placeholder="Place of issue">
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-semibold">Valid Until</label>
                        <input type="date" class="form-control" name="docexpdt" id="personalDoc_docexpdt">
                        <!-- <small id="personalDoc_docexpdtFeedback" class="text-danger d-none">Valid Until is required</small>  -->
                        <small id="personalDoc_docexpdtFeedbackDate" class="text-danger d-none">Valid Until must be on or after Date of Issue</small>
                      </div>
                      <div class="col-md-6">
                        <label class="form-label fw-semibold">Notes</label>
                        <textarea class="form-control" name="notes" id="personalDoc_notes" rows="1" placeholder="Additional notes..."></textarea>
                      </div>
                      <div class="col-12 mt-2">
                        <label class="form-label fw-semibold">Document File (optional)</label>
                        <input type="file" class="form-control" name="doc_file" id="personalDoc_doc_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
                        <small class="text-muted">PDF or image. Leave empty to keep existing file.</small>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-primary" id="btnSavePersonalDoc">Save</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Upload Personal Doc File -->
          <div class="modal fade" id="uploadPersonalDocModal" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header text-white" style="background-color:#000099;">
                  <h5 class="modal-title">Upload Document File</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="uploadPersonalDoc_idperdoc">
                  <input type="hidden" id="uploadPersonalDoc_idperson">
                  <label class="form-label fw-semibold">Select file (PDF/Image)</label>
                  <input type="file" class="form-control" id="file_personaldoc_upload" name="file_personaldoc" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
                  <small id="file_personaldoc_uploadFeedback" class="text-danger d-none">Please select a file</small>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-primary" id="btnUploadPersonalDoc">Upload</button>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>


    <style>
      /* KHUSUS PROFILE */
      .profile-content {
        font-size: 13px;
      }

      .profile-content .card-header {
        font-size: 13px;
      }

      .profile-content strong {
        font-size: 12.5px;
      }

      .profile-content small {
        font-size: 12px;
      }

      .profile-content .form-label {
        font-size: 12.5px;
      }

      .profile-content input,
      .profile-content select {
        font-size: 13px;
      }

      /* Personal ID table - sama seperti Experience */
      #personalDocTable.crew-table .crew-header th {
        background-color: #000099 !important;
        color: #fff !important;
        font-size: 12px;
        border-color: rgba(255,255,255,0.2);
      }
      #personalDocTable .personal-doc-search-row th {
        padding: 6px 4px;
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
      }
      /* Hilangkan ikon sort di header DataTables */
      #personalDocTable thead.crew-header th.sorting,
      #personalDocTable thead.crew-header th.sorting_asc,
      #personalDocTable thead.crew-header th.sorting_desc {
        background-color: #000099 !important;
        color: #fff !important;
      }
        .contract-no-icon { font-size: 1rem !important; width: 1.25em; text-align: center; }
        .contract-no-filelink .contract-no-icon { margin-right: 2px; }
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
      $(document).ready(function () {
        var id_person = "<?php echo $idperson; ?>";
        loadProfile(id_person);
      });

      function loadProfile(id_person) {
        $.ajax({
          url: "<?php echo base_url('PersonDetail/getDataProses'); ?>",
          type: "POST",
          dataType: "json",
          data: {
            id: id_person,
            type: "editProses"
          },
          success: function (res) {
            if (!res.status) return alert(res.message);
            renderProfile(res.data);
          }
        });
      }
    </script>



    <script>
      function renderProfile(data) {

        // VIEW MODE
        $('.form-view').each(function () {
          var field = $(this).data('field');
          if (!field) return;

          var value = getValueByPath(data, field);
          $(this).text(
            value !== undefined && value !== null && value !== '' ? value : '-'
          );
        });

        // EDIT MODE
        $('.form-edit').each(function () {
          var field = $(this).data('field');
          if (!field) return;

          var value = getValueByPath(data, field);

          if ($(this).is('input, textarea, select')) {
            $(this).val(value);
          }

          /*Contact Method Validate */
          $('.form-edit input[type="checkbox"]').each(function () {

            const field = $(this).data('field'); // contactMethod.email
            if (!field) return;

            const value = getValueByPath(data, field);

            // console.log('CHECKBOX', field, '=>', value);

            $(this).prop('checked', value == 1 || value === true);

          });

        });

        // Crew Status summary (view mode)
        var cs = data.crewStatus || {};
        var labels = [];
        if (cs.newApplicant) labels.push('New Applicant');
        if (cs.nonAktif) labels.push('Non Aktif');
        if (cs.blackList) labels.push('Not for Employed');
        if (cs.nonCrew) labels.push('Non Crew');
        $('#crewStatusSummaryText').text(labels.length ? labels.join(', ') : '-');
        $('#crewStatusNotesText').text(cs.notes ? cs.notes : '-');
        $('#crewStatus_notes').val(''); // Reset form edit

        // FOTO (pictureProfile ada di data.identity)
        var pic = (data.identity && data.identity.pictureProfile) ? data.identity.pictureProfile : (data.pictureProfile || '');
        if (pic) {
          $('#crewPhoto').attr(
            'src',
            "<?php echo base_url('imgProfile');?>/" + pic
          );
        }

        // HEADER
        if (data.identity) {
          $('.crew-name').text(data.identity.fullName);
          $('.crew-id').text(data.identity.idperson);
        }
      }
    </script>

    <script>
      function getValueByPath(obj, path) {
        if (!obj || !path) return '';

        var parts = path.split('.');
        var result = obj;

        for (var i = 0; i < parts.length; i++) {
          if (result[parts[i]] === undefined) {
            return '';
          }
          result = result[parts[i]];
        }

        return result;
      }
    </script>

    <script>
      /* Edit / Upload Foto Profil */
      $(document).ready(function () {
        var id_person = "<?php echo $idperson; ?>";
        var baseUrlImg = "<?php echo base_url('imgProfile'); ?>/";
        $('#btnEditPhoto').on('click', function () {
          $('#profilePhotoInput').trigger('click');
        });
        $('#profilePhotoInput').on('change', function () {
          var file = this.files[0];
          if (!file) return;
          var fd = new FormData();
          fd.append('idperson', id_person);
          fd.append('profile_photo', file);
          $('#profilePhotoAlert').addClass('d-none');
          $.ajax({
            url: "<?php echo base_url('PersonDetail/uploadProfilePhoto'); ?>",
            type: "POST",
            dataType: "json",
            data: fd,
            processData: false,
            contentType: false,
            success: function (res) {
              if (res.status && res.pictureProfile) {
                $('#crewPhoto').attr('src', baseUrlImg + res.pictureProfile);
                $('#profilePhotoAlert').removeClass('d-none').text(res.message).addClass('alert-success').removeClass('alert-danger');
                setTimeout(function () { $('#profilePhotoAlert').addClass('d-none'); }, 3000);
              } else {
                $('#profilePhotoAlert').removeClass('d-none').text(res.message || 'Upload gagal').addClass('alert-danger').removeClass('alert-success');
              }
            },
            error: function (xhr) {
              var msg = 'Upload gagal';
              try {
                var r = JSON.parse(xhr.responseText);
                if (r.message) msg = r.message;
              } catch (e) {}
              $('#profilePhotoAlert').removeClass('d-none').text(msg).addClass('alert-danger').removeClass('alert-success');
            }
          });
          this.value = '';
        });
      });
    </script>

    <script>
      /*Actin Basic Identity Save*/
      $(document).ready(function () {

        var id_person = "<?php echo $idperson; ?>";
        var alert_success = $('#basic-success-alert');
        var alert_error = $('#basic-danger-alert');
        var success_message = $('#basic-success-message');
        var error_message = $('#basic-error-message');

        $('#basicIdentityCard .btn-save').click(function () {
          saveBasicIdentity();
        });

        function saveBasicIdentity() {
          // Reset
          alert_success.addClass('d-none');
          alert_error.addClass('d-none');

          var idperson = $('#contentArea').data('idperson');
          var data = {
            idperson: idperson,
            oldCrewId: $('input[data-field="identity.oldCrewId"]').val(),
            oldContractNo: $('input[data-field="identity.oldContractNo"]').val(),
            seafarerCode: $('input[data-field="identity.seafarerCode"]').val(),
            firstName: $('input[data-field="identity.firstName"]').val(),
            middleName: $('input[data-field="identity.middleName"]').val(),
            lastName: $('input[data-field="identity.lastName"]').val(),
            gender: $('select[data-field="identity.gender"]').val(),
            nationality: $('select[data-field="identity.nationality"]').val(),
            countryOrigin: $('select[data-field="identity.countryOrigin"]').val(),
            dob: $('input[data-field="identity.dobForEdit"]').val(),
            pob: $('select[data-field="identity.pob"]').val(),
            religion: $('select[data-field="identity.religion"]').val(),
            maritalStatus: $('select[data-field="identity.maritalStatus"]').val()
          };

          // console.log('Saving basic identity data:', data);

          $.ajax({
            url: "<?php echo base_url('PersonDetail/updateBasicIdentity'); ?>",
            type: "POST",
            dataType: "json",
            data: data,
            success: function (res) {
              if (res.status) {
                loadProfile(id_person);

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

              } else {
                // Tampilkan ERROR message - hanya ubah teks
                error_message.text(res.message || 'Failed to update basic identity'); // ← Ini yang benar!
                alert_error.removeClass('d-none');
                setTimeout(function () {
                  alert_error.addClass('d-none');
                }, 5000);
              }
            },
            error: function (xhr, status, error) {
              console.error('AJAX Error:', xhr.responseText);
              error_message.text('Failed to update basic identity: ' + error);
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
      /* Crew Status (mstpersonal: inAktif, inBlacklist, newapplicent, noncrew) */
      $(document).ready(function () {
        var id_person = "<?php echo $idperson; ?>";

        // Pastikan hanya satu checkbox yang bisa dipilih (seperti radio button)
        $('#crewStatus_nonAktif').change(function() {
          if($(this).is(':checked')) {
            $('#crewStatus_blackList').prop('checked', false);
          }
        });
        
        $('#crewStatus_blackList').change(function() {
          if($(this).is(':checked')) {
            $('#crewStatus_nonAktif').prop('checked', false);
          }
        });

        $('#crewStatusCard .btn-save').off('click').on('click', function () {
          var btnSave = $(this);
          var isNonAktif = $('#crewStatus_nonAktif').is(':checked');
          var isBlacklist = $('#crewStatus_blackList').is(':checked');
          
          if (isNonAktif && isBlacklist) {
            if (typeof Swal !== 'undefined') Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Hanya boleh memilih satu status saja.' });
            else alert('Hanya boleh memilih satu status saja.');
            return;
          }

          var idperson = $('#contentArea').data('idperson') || id_person;
          var data = {
            idperson: idperson,
            inAktif: $('#crewStatus_nonAktif').is(':checked') ? '1' : '0',
            inBlacklist: $('#crewStatus_blackList').is(':checked') ? '1' : '0',
            newapplicent: $('#crewStatus_newApplicant').is(':checked') ? '1' : '0',
            noncrew: $('#crewStatus_nonCrew').is(':checked') ? '1' : '0',
            notes: $('#crewStatus_notes').val()
          };
          
          btnSave.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
          
          $.ajax({
            url: "<?php echo base_url('PersonDetail/updateCrewStatus'); ?>",
            type: "POST",
            dataType: "json",
            data: data,
            success: function (res) {
              btnSave.prop('disabled', false).html('<i class="fa fa-save"></i> Save');
              if (res.status) {
                loadProfile(id_person);
                var card = $('#crewStatusCard');
                card.find('.form-view').removeClass('d-none');
                card.find('.form-edit').addClass('d-none');
                card.find('.btn-edit').removeClass('d-none');
                card.find('.btn-save, .btn-cancel').addClass('d-none');
                $('#crewStatus_notes').val(''); // Clear notes after save
                if (typeof Swal !== 'undefined') Swal.fire({ icon: 'success', title: 'Saved', text: res.message });
                else alert(res.message);
              } else {
                if (typeof Swal !== 'undefined') Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Failed to update crew status' });
                else alert(res.message || 'Failed to update crew status');
              }
            },
            error: function (xhr, status, error) {
              btnSave.prop('disabled', false).html('<i class="fa fa-save"></i> Save');
              if (typeof Swal !== 'undefined') Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to update crew status' });
              else alert('Failed to update crew status');
            }
          });
        });
        
        // Crew Status History Modal Logic
        $('#crewStatusCard .btn-history').click(function () {
          var idperson = $('#contentArea').data('idperson') || id_person;
          $('#crewStatusHistoryTableBody').html('<tr><td colspan="4" class="text-center">Loading...</td></tr>');
          var modal = new bootstrap.Modal(document.getElementById('crewStatusHistoryModal'));
          modal.show();

          $.ajax({
            url: "<?php echo base_url('PersonDetail/getCrewStatusHistory'); ?>",
            type: "POST",
            dataType: "json",
            data: { idperson: idperson },
            success: function (res) {
              if (res.status) {
                var tbody = $('#crewStatusHistoryTableBody');
                tbody.empty();
                if (res.data.length > 0) {
                  $.each(res.data, function(index, log) {
                    var statusLabels = [];
                    if (log.newapplicent == "1") statusLabels.push("New Applicant");
                    if (log.inAktif == "1") statusLabels.push("Non Aktif");
                    if (log.inBlacklist == "1") statusLabels.push("Not for Employed");
                    
                    var tr = $('<tr>');
                    tr.append('<td>' + log.created_at + '</td>');
                    tr.append('<td>' + (statusLabels.length > 0 ? statusLabels.join(', ') : '-') + '</td>');
                    tr.append('<td>' + (log.notes ? log.notes : '-') + '</td>');
                    tr.append('<td>' + (log.created_by ? log.created_by : '-') + '</td>');
                    tbody.append(tr);
                  });
                } else {
                  tbody.html('<tr><td colspan="4" class="text-center">No history found</td></tr>');
                }
              }
            },
            error: function () {
              $('#crewStatusHistoryTableBody').html('<tr><td colspan="4" class="text-center text-danger">Failed to load history</td></tr>');
            }
          });
        });
      });
    </script>

    <script>
      /* Assessment & Training save (CrewDetail/Traning/save_training) */
      $(document).ready(function () {
        var id_person = "<?php echo $idperson; ?>";
        var alert_success = $('#assessment-success-alert');
        var alert_error = $('#assessment-danger-alert');
        var success_message = $('#assessment-success-message');
        var error_message = $('#assessment-error-message');

        $('#assessmentCard .btn-save').click(function () {
          alert_success.addClass('d-none');
          alert_error.addClass('d-none');
          var idperson = $('#contentArea').data('idperson') || id_person;
          if (!idperson) {
            error_message.text('idperson not found.');
            alert_error.removeClass('d-none');
            return;
          }
          var data = {
            idperson: idperson,
            txtCesScore: $('input[data-field="assessment.cesScore"]').val(),
            txtmarlinTest: $('input[data-field="assessment.marlinScore"]').val(),
            txtEvaluation: $('input[data-field="assessment.evaluation"]').val(),
            txtDate_training: $('input[data-field="assessment.trainingDateForEdit"]').val(),
            scor_psychometric: $('input[data-field="assessment.psychometricScore"]').val(),
            scor_otg: $('input[data-field="assessment.otgScore"]').val()
          };
          $.ajax({
            url: "<?php echo base_url('CrewDetail/Traning/save_training'); ?>",
            type: "POST",
            dataType: "json",
            data: data,
            success: function (res) {
              if (res.success) {
                loadProfile(id_person);
                var card = $('#assessmentCard');
                card.find('.form-view').removeClass('d-none');
                card.find('.form-edit').addClass('d-none');
                card.find('.btn-edit').removeClass('d-none');
                card.find('.btn-save, .btn-cancel').addClass('d-none');
                success_message.text(res.message || 'Data saved successfully');
                alert_success.removeClass('d-none');
                setTimeout(function () { alert_success.addClass('d-none'); }, 3000);
              } else {
                error_message.text(res.message || 'Save failed.');
                alert_error.removeClass('d-none');
                setTimeout(function () { alert_error.addClass('d-none'); }, 5000);
              }
            },
            error: function () {
              error_message.text('Request failed.');
              alert_error.removeClass('d-none');
              setTimeout(function () { alert_error.addClass('d-none'); }, 5000);
            }
          });
        });
      });
    </script>

    <script>
      /* Family Information actions start*/
      $(document).ready(function () {
        var id_person = "<?php echo $idperson; ?>";
        var alert_success = $('#family-success-alert');
        var success_message = $('#family-success-message');

        var error_message = $('#family-error-message');
        var alert_error = $('#family-error-alert');


        $('.btn-close').on('click', function () {
          $(this).closest('.alert').addClass('d-none');
        });

        $('#familyinformation .btn-save').click(function () {
          saveFamilyInfo();
        });


        function saveFamilyInfo() {
          var idperson = $('#contentArea').data('idperson');
          // Reset alert terlebih dahulu
          alert_error.addClass('d-none');
          alert_success.addClass('d-none');

          var data = {
            idperson: idperson,
            fatherName: $('input[data-field="family.fatherName"]').val(), // fatherName bukan father.name
            motherName: $('input[data-field="family.motherName"]').val(), // motherName bukan mother.name
            wifeName: $('input[data-field="family.wifeName"]').val(), // wifeName bukan wife.name
            nextOfKin: $('input[data-field="family.nextOfKin"]').val() // Tambah nextOfKin
          };
          // let isFatherNameValid = validateChildField(
          //   'fatherName',
          //   'fatherNameFeedback'
          // );

          // let isMotherNameValid = validateChildField(
          //   'motherName',
          //   'motherNameFeedback'
          // );

          // let isAddressValid = validateChildField(
          //   'address',
          //   'addressFeedback'
          // );

          // if (!isFatherNameValid || !isMotherNameValid || !isAddressValid) {
          //   return false;
          // }

          // var data = {
          //   idperson: idperson,
          //   fatherName: fatherName,
          //   motherName: motherName,
          //   wifeName: $('input[data-field="family.wife.name"]').val(),
          // };

          console.log('Saving family data:', data);
          // return false;

          $.ajax({
            url: "<?php echo base_url('PersonDetail/updateFamilyInfo'); ?>",
            type: "POST",
            dataType: "json",
            data: data,
            success: function (res) {
              // console.log('Response:', res);
              if (res.status) {
                loadProfile(id_person);
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
                $('.form-view[data-field="family.fatherName"]').text(data.fatherName || '');
                $('.form-view[data-field="family.motherName"]').text(data.motherName || '');
                $('.form-view[data-field="family.wifeName"]').text(data.wifeName || '');
                $('.form-view[data-field="family.nextOfKin"]').text(data.nextOfKin || '');
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
      /* Tax & Social Security */
      $(document).ready(function () {
        var alert_success = $('#tax-success-alert');
        var success_message = $('#tax-success-message');
        var error_message = $('#tax-error-message');
        var alert_error = $('#tax-error-alert');
        var id_person = "<?php echo $idperson; ?>";

        $('#legalTaxCard .btn-save').click(function () {
          saveLegalTax(id_person);
          console.log('Save Legal & Tax clicked');
        });

        function saveLegalTax(id_person) {
          var idperson = id_person;
          alert_error.addClass('d-none');
          alert_success.addClass('d-none');

          // Ambil data dari input fields
          var data = {
            idperson: idperson,
            ssn: $('input[data-field="legal.ssn"]').val(),
            ssnCountry: $('select[data-field="legal.ssnCountry"]').val(),
            taxNumber: $('input[data-field="legal.taxNumber"]').val(),
            taxCountry: $('select[data-field="legal.taxCountry"]').val(),
            taxStatus: $('select[data-field="legal.taxStatus"]').val()
          };

          // console.log('Saving legal & tax data:', data);
          // return false;
          $.ajax({
            url: "<?php echo base_url('PersonDetail/updateLegalTax'); ?>",
            type: "POST",
            dataType: "json",
            data: data,
            success: function (res) {
              if (res.status) {
                loadProfile(id_person);
                success_message.text(res.message);
                alert_success.removeClass('d-none');
                setTimeout(function () {
                  alert_success.addClass('d-none');
                }, 3000);

                const card = $('#legalTaxCard');
                card.find('.form-view').removeClass('d-none');
                card.find('.form-edit').addClass('d-none');
                card.find('.btn-edit').removeClass('d-none');
                card.find('.btn-save, .btn-cancel').addClass('d-none');
              } else {
                error_message.text(res.message || 'Failed to update legal & tax information');
                alert_error.removeClass('d-none');
                setTimeout(function () {
                  alert_error.addClass('d-none');
                }, 5000);
              }
            },
            error: function (xhr, status, error) {
              console.error('AJAX Error:', xhr.responseText);
              error_message.text('Failed to update legal & tax information');
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
      /* Contact & Address */
      $(document).ready(function () {
        var alert_success = $('#contact-success-alert');
        var success_message = $('#contact-success-message');
        var error_message = $('#contact-error-message');
        var alert_error = $('#contact-error-alert');

        $('#contactAddressCard .btn-save').click(function () {
          saveContactAddress();
          console.log('Save Contact & Address clicked');
        });

        function saveContactAddress() {
          var idperson = $('#contentArea').data('idperson');
          alert_error.addClass('d-none');
          alert_success.addClass('d-none');

          var data = {
            idperson: idperson,
            address: $('textarea[data-field="contact.address"]').val(),
            city: $('select[data-field="contact.city"]').val(),
            postcode: $('input[data-field="contact.postcode"]').val(),
            country: $('select[data-field="contact.country"]').val(),
            airport: $('select[data-field="contact.airport"]').val(),
            mobile: $('input[data-field="contact.mobile"]').val(),
            home: $('input[data-field="contact.home"]').val(),
            fax: $('input[data-field="contact.fax"]').val(),
            email: $('input[data-field="contact.email"]').val(),

            conmthEmail: $('input[data-field="contactMethod.email"]').is(':checked') ? 1 : 0,
            conmthFax: $('input[data-field="contactMethod.fax"]').is(':checked') ? 1 : 0,
            conmthMob: $('input[data-field="contactMethod.mobile"]').is(':checked') ? 1 : 0,
            conmthHom: $('input[data-field="contactMethod.home"]').is(':checked') ? 1 : 0,
            conmthPost: $('input[data-field="contactMethod.post"]').is(':checked') ? 1 : 0

          };

          $.ajax({
            url: "<?php echo base_url('PersonDetail/updateContact'); ?>",
            type: "POST",
            dataType: "json",
            data: data,
            success: function (res) {
              if (res.status) {
                loadProfile(idperson);
                success_message.text(res.message);
                alert_success.removeClass('d-none');
                setTimeout(function () {
                  alert_success.addClass('d-none');
                }, 3000);

                const card = $('#contactAddressCard');
                card.find('.form-view').removeClass('d-none');
                card.find('.form-edit').addClass('d-none');
                card.find('.btn-edit').removeClass('d-none');
                card.find('.btn-save, .btn-cancel').addClass('d-none');
              } else {
                error_message.text(res.message || 'Failed to update legal & tax information');
                alert_error.removeClass('d-none');
                setTimeout(function () {
                  alert_error.addClass('d-none');
                }, 5000);
              }
            },
            error: function (xhr, status, error) {
              console.error('AJAX Error:', xhr.responseText);
              error_message.text('Failed to update legal & tax information');
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
      /* Physical & Medical */
      $(document).ready(function () {
        var alert_success = $('#physical-success-alert');
        var success_message = $('#physical-success-message');
        var error_message = $('#physical-error-message');
        var alert_error = $('#physical-error-alert');

        $('#physicalMedicalCard .btn-save').on('click', function () {
          savePhysicalMedical();
        });

        function savePhysicalMedical() {
          var id_person = $('#contentArea').data('idperson');
          alert_error.addClass('d-none');
          alert_success.addClass('d-none');

          var data = {
            idperson: id_person,
            bloodType: $('select[data-field="physical.bloodType"]').val(),
            eyeColor: $('input[data-field="physical.eyeColor"]').val(),
            weight: $('input[data-field="physical.weight"]').val(),
            height: $('input[data-field="physical.height"]').val(),
            shoes: $('input[data-field="physical.shoesz"]').val(),
            collar: $('input[data-field="physical.collar"]').val(),
            chest: $('input[data-field="physical.chest"]').val(),
            waist: $('input[data-field="physical.waist"]').val(),
            insideLeg: $('input[data-field="physical.Insdleg"]').val(),
            clothesSize: $('select[data-field="physical.clothesSize"]').val(),
            boilerSize: $('select[data-field="physical.boilerszid"]').val(),
            heightPhobia: $('select[data-field="physical.heightPhobia"]').val(),
            claustrophob: $('select[data-field="physical.claustrophob"]').val(),
            allergy: $('textarea[data-field="physical.allergy"]').val()
          };

          // console.log('Saving physical & medical data:', data);
          // return false;

          $.ajax({
            url: "<?php echo base_url('PersonDetail/updatePhysicalMedical'); ?>",
            type: "POST",
            dataType: "json",
            data: data,
            success: function (res) {
              if (res.status) {
                loadProfile(id_person);

                success_message.text(res.message);
                alert_success.removeClass('d-none');

                setTimeout(function () {
                  alert_success.addClass('d-none');
                }, 3000);

                const card = $('#physicalMedicalCard');
                card.find('.form-view').removeClass('d-none');
                card.find('.form-edit').addClass('d-none');
                card.find('.btn-edit').removeClass('d-none');
                card.find('.btn-save, .btn-cancel').addClass('d-none');

              } else {
                error_message.text(res.message || 'Failed to update physical data');
                alert_error.removeClass('d-none');
              }
            },
            error: function () {
              error_message.text('Server error');
              alert_error.removeClass('d-none');
            }
          });
        }

      });
    </script>

    <script>
        var alert_success, success_message, error_message, alert_error;
        $(document).ready(function () {
          var id_person = "<?php echo $idperson; ?>";
          alert_success = $('#career-success-alert');
          success_message = $('#career-success-message');
          error_message = $('#career-error-message');
          alert_error = $('#career-error-alert');
          $('#careerPlacementCard .btn-save').on('click', function () {
            saveCareerPlacement(id_person);
          });
        });

      function saveCareerPlacement(id_person) {

        alert_error.addClass('d-none');
        alert_success.addClass('d-none');

        var data = {
          idperson: id_person,
          rankApply: $('select[data-field="career.rankApply"]').val(),
          vesselApply: $('select[data-field="career.vesselApply"]').val(),
          vesselType: $('select[data-field="career.vesselType"]').val(),
          availableDate: $('input[data-field="career.edt_availableDate"]').val(),
          lowerRank: $('select[data-field="career.lowerRank"]').val()
        };

        $.ajax({
          url: "<?php echo base_url('PersonDetail/updateCareerPlacement'); ?>",
          type: "POST",
          dataType: "json",
          data: data,
          success: function (res) {
            if (res.status) {
              loadProfile(id_person);

              success_message.text(res.message);
              alert_success.removeClass('d-none');

              setTimeout(() => alert_success.addClass('d-none'), 3000);

              const card = $('#careerPlacementCard');
              card.find('.form-view').removeClass('d-none');
              card.find('.form-edit').addClass('d-none');
              card.find('.btn-edit').removeClass('d-none');
              card.find('.btn-save, .btn-cancel').addClass('d-none');

            } else {
              error_message.text(res.message || 'Failed to update career & placement');
              alert_error.removeClass('d-none');
            }
          },
          error: function () {
            error_message.text('Server error');
            alert_error.removeClass('d-none');
          }
        });
      }
    </script>

    <script>
      /* Home Salary */
      $(document).ready(function () {
        var idperson = "<?php echo $idperson; ?>";
        var alert_success = $('#home-success-alert');
        var success_message = $('#home-success-message');
        var error_message = $('#home-error-message');
        var alert_error = $('#home-error-alert');

        $('#salaryHomeCard .btn-save').click(function () {
          saveSalaryHome(idperson);
        });

        function saveSalaryHome(idperson) {
          var data = {
            idperson: idperson,
            bank_home: $('input[data-field="salary.home.bank"]').val(),
            norek_home: $('input[data-field="salary.home.accountNo"]').val(),
            norek_name_home: $('input[data-field="salary.home.accountName"]').val(),
            percentage_home: $('input[data-field="salary.home.percentage"]').val()
          };

          $.ajax({
            url: "<?php echo base_url('PersonDetail/updateSalaryHome'); ?>",
            type: "POST",
            dataType: "json",
            data: data,
            success: function (res) {
              if (res.status) {
                loadProfile(idperson);

                success_message.text(res.message);
                alert_success.removeClass('d-none');

                setTimeout(() => alert_success.addClass('d-none'), 3000);

                const card = $('#salaryHomeCard');
                card.find('.form-view').removeClass('d-none');
                card.find('.form-edit').addClass('d-none');
                card.find('.btn-edit').removeClass('d-none');
                card.find('.btn-save, .btn-cancel').addClass('d-none');
              } else {
                error_message.text(res.message || 'Failed to update home salary');
                alert_error.removeClass('d-none');
              }
            },
            error: function () {
              error_message.text('Server error');
              alert_error.removeClass('d-none');
            }
          });
        }
      });
    </script>


    <script>
      /* Board  Salary */
      $(document).ready(function () {
        var idperson = "<?php echo $idperson; ?>";
        var alert_success = $('#board-success-alert');
        var success_message = $('#board-success-message');
        var error_message = $('#board-error-message');
        var alert_error = $('#board-error-alert');

        $('#salaryBoardCard .btn-save').click(function () {
          saveSalaryBoard(idperson);
        });

        function saveSalaryBoard(idperson) {
          var data = {
            idperson: idperson,
            bank_board: $('input[data-field="salary.board.bank"]').val(),
            norek_board: $('input[data-field="salary.board.accountNo"]').val(),
            norek_name_board: $('input[data-field="salary.board.accountName"]').val(),
            percentage_board: $('input[data-field="salary.board.percentage"]').val()
          };

          $.ajax({
            url: "<?php echo base_url('PersonDetail/updateSalaryBoard'); ?>",
            type: "POST",
            dataType: "json",
            data: data,
            success: function (res) {
              if (res.status) {
                loadProfile(idperson);

                success_message.text(res.message);
                alert_success.removeClass('d-none');

                setTimeout(() => alert_success.addClass('d-none'), 3000);

                const card = $('#salaryBoardCard');
                card.find('.form-view').removeClass('d-none');
                card.find('.form-edit').addClass('d-none');
                card.find('.btn-edit').removeClass('d-none');
                card.find('.btn-save, .btn-cancel').addClass('d-none');
              } else {
                error_message.text(res.message || 'Failed to update board salary');
                alert_error.removeClass('d-none');
              }
            },
            error: function () {
              error_message.text('Server error');
              alert_error.removeClass('d-none');
            }
          });
        }
      });
    </script>

    <script>
      $(document).ready(function () {
        var idperson = "<?php echo $idperson; ?>";
        var alert_success = $('#declaration-success-alert');
        var success_message = $('#declaration-success-message');
        var error_message = $('#declaration-error-message');
        var alert_error = $('#declaration-error-alert');

        $('#declarationCard .btn-save').click(function () {
          saveDeclaration(idperson);
        });

        function saveDeclaration(idperson) {

          var data = {
            idperson: idperson,

            signPlace: $('input[data-field="declaration.signPlace"]').val(),
            signDate: $('input[data-field="declaration.edt_signDate"]').val(),
            remarks: $('textarea[data-field="declaration.remarks"]').val()
          };

          $.ajax({
            url: "<?php echo base_url('PersonDetail/updateDeclaration'); ?>",
            type: "POST",
            dataType: "json",
            data: data,
            success: function (res) {
              if (res.status) {
                loadProfile(idperson);

                success_message.text(res.message);
                alert_success.removeClass('d-none');

                setTimeout(() => alert_success.addClass('d-none'), 3000);

                const card = $('#declarationCard');
                card.find('.form-view').removeClass('d-none');
                card.find('.form-edit').addClass('d-none');
                card.find('.btn-edit').removeClass('d-none');
                card.find('.btn-save, .btn-cancel').addClass('d-none');
              } else {
                error_message.text(res.message || 'Failed to update board salary');
                alert_error.removeClass('d-none');
              }
            },
            error: function () {
              error_message.text('Server error');
              alert_error.removeClass('d-none');
            }
          });
        }
      });
    </script>

    <script>
      /* Category Personal ID - DataTables & CRUD */
      $(document).ready(function () {
        var idperson = $('#contentArea').data('idperson');
        if (!idperson) return;

        function fmtDate(val) {
          if (!val || val === '0000-00-00' || val === '') return '-';
          var d = new Date(val);
          if (isNaN(d.getTime())) return val;
          return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
        }

        var personalDocTable = $('#personalDocTable').DataTable({
          dom: "<'row mb-2'<'col-md-6'l><'col-md-6 text-end'f>>" +
               "<'row'<'col-md-12'tr>>" +
               "<'row mt-2'<'col-md-8'i><'col-md-4 text-end'p>>",
          processing: true,
          serverSide: false,
          searching: true,
          paging: true,
          ordering: false,
          info: true,
          lengthChange: true,
          pageLength: 10,
          lengthMenu: [10, 25, 50, 100],
          ajax: {
            url: "<?php echo base_url('PersonDetail/getPersonalDocList'); ?>",
            type: "GET",
            data: { idperson: idperson },
            dataSrc: function (json) {
              if (json.success) return json.data;
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
                if (row.doc_file && row.doc_file.trim() !== '') {
                  below = '<div class="mt-1"><a href="<?php echo base_url("uploadFile"); ?>/' + row.doc_file + '" target="_blank" class="text-primary small contract-no-filelink" title="View file"><i class="fa-solid fa-book contract-no-icon"></i></a></div>';
                } else {
                  below = '<div class="mt-1"><button type="button" class="btn btn-sm btn-outline-info p-1 btn-upload-personaldoc" data-id="' + row.idperdoc + '" data-idperson="' + row.idperson + '" title="Upload File"><i class="fa fa-upload contract-no-icon"></i></button></div>';
                }
                return '<div>' + no + below + '</div>';
              }
            },
            { data: 'doctp' },
            { data: 'country_issue' },
            { data: 'docno' },
            { data: 'docissdt', render: function (d) { return fmtDate(d); } },
            { data: 'docissplc' },
            { data: 'docexpdt', render: function (d) { return fmtDate(d); } },
            { data: 'notes' },
            {
              data: null,
              orderable: false,
              searchable: false,
              className: 'text-center',
              render: function (data, type, row) {
                return '<button type="button" class="btn btn-sm btn-outline-primary btn-edit-personaldoc" data-id="' + row.idperdoc + '" title="Edit"><i class="fa fa-edit"></i></button> ' +
                       '<button type="button" class="btn btn-sm btn-outline-danger btn-delete-personaldoc" data-id="' + row.idperdoc + '" title="Delete"><i class="fa fa-trash"></i></button>';
              }
            }
          ],
          initComplete: function () {
            $('#personalDocTable thead tr:eq(1) th').each(function (i) {
              var that = this;
              $('input', this).off('keyup change').on('keyup change', function () {
                if (personalDocTable.column(i).search() !== this.value) {
                  personalDocTable.column(i).search(this.value).draw();
                }
              });
            });
          },
          language: {
            emptyTable: "No personal document data",
            zeroRecords: "No matching data found",
            lengthMenu: '_MENU_ &nbsp;Entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            infoEmpty: 'Showing 0 to 0 of 0 entries',
            infoFiltered: '(filtered from _MAX_ total entries)',
            search: 'Search:'
          }
        });

        function hidePersonalDocFeedback() {
          $('#personalDoc_doctpFeedback,#personalDoc_docnoFeedback,#personalDoc_docissdtFeedback,#personalDoc_docexpdtFeedback,#personalDoc_docexpdtFeedbackDate').addClass('d-none');
          $('#personalDoc_doctp,#personalDoc_docno,#personalDoc_docissdt,#personalDoc_docexpdt').removeClass('is-invalid');
        }

        function validatePersonalDocForm() {
          var ok = true;
          hidePersonalDocFeedback();
          if (!$('#personalDoc_doctp').val().trim()) {
            $('#personalDoc_doctpFeedback').removeClass('d-none');
            $('#personalDoc_doctp').addClass('is-invalid');
            ok = false;
          }
          if (!$('#personalDoc_docno').val().trim()) {
            $('#personalDoc_docnoFeedback').removeClass('d-none');
            $('#personalDoc_docno').addClass('is-invalid');
            ok = false;
          }
          if (!$('#personalDoc_docissdt').val()) {
            $('#personalDoc_docissdtFeedback').removeClass('d-none');
            $('#personalDoc_docissdt').addClass('is-invalid');
            ok = false;
          }
          // if (!$('#personalDoc_docexpdt').val()) {
          //   $('#personalDoc_docexpdtFeedback').removeClass('d-none');
          //   $('#personalDoc_docexpdt').addClass('is-invalid');
          //   ok = false;
          // }
          var dateIssue = $('#personalDoc_docissdt').val();
          var validUntil = $('#personalDoc_docexpdt').val();
          if (dateIssue && validUntil && validUntil < dateIssue) {
            $('#personalDoc_docexpdtFeedbackDate').removeClass('d-none');
            $('#personalDoc_docexpdt').addClass('is-invalid');
            ok = false;
          }
          return ok;
        }

        $('#btnNewPersonalDoc').on('click', function () {
          $('#personalDocForm')[0].reset();
          $('#personalDoc_idperdoc').val('');
          $('#personalDoc_idperson').val(idperson);
          $('#personalDoc_notes').val('');
          hidePersonalDocFeedback();
          $('#personalDocModalTitle').text('Add Personal Document');
          $('#personalDocModal').modal('show');
        });

        $('#personalDocTable').on('click', '.btn-edit-personaldoc', function () {
          var id = $(this).data('id');
          $.ajax({
            url: "<?php echo base_url('PersonDetail/getPersonalDoc'); ?>",
            type: "POST",
            dataType: "json",
            data: { id: id, idperson: idperson },
            success: function (res) {
              if (!res.status) {
                alert(res.message || 'Data not found');
                return;
              }
              var d = res.data;
              $('#personalDoc_idperdoc').val(d.idperdoc);
              $('#personalDoc_idperson').val(d.idperson);
              $('#personalDoc_kdcert').val(d.kdcert || '');
              $('#personalDoc_doctp').val(d.doctp || '');
              $('#personalDoc_docissctryid').val(d.docissctryid || '');
              $('#personalDoc_docno').val(d.docno || '');
              $('#personalDoc_docissdt').val(d.docissdt || '');
              $('#personalDoc_docissplc').val(d.docissplc || '');
              $('#personalDoc_docexpdt').val(d.docexpdt || '');
              $('#personalDoc_notes').val(d.notes || '');
              hidePersonalDocFeedback();
              $('#personalDoc_doc_file').val('');
              $('#personalDocModalTitle').text('Edit Personal Document');
              $('#personalDocModal').modal('show');
            }
          });
        });

        $('#personalDocTable').on('click', '.btn-delete-personaldoc', function () {
          var id = $(this).data('id');
          if (!confirm('Delete this personal document?')) return;
          $.ajax({
            url: "<?php echo base_url('PersonDetail/deletePersonalDoc'); ?>",
            type: "POST",
            dataType: "json",
            data: { id: id, idperson: idperson },
            success: function (res) {
              if (res.status) {
                personalDocTable.ajax.reload(null, false);
                if (typeof Swal !== 'undefined') Swal.fire({ icon: 'success', title: 'Deleted', text: res.message });
                else alert(res.message);
              } else {
                if (typeof Swal !== 'undefined') Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                else alert(res.message);
              }
            }
          });
        });

        $('#btnSavePersonalDoc').on('click', function () {
          if (!validatePersonalDocForm()) return;
          var fileInput = $('#personalDoc_doc_file')[0];
          var hasFile = fileInput.files && fileInput.files.length > 0;
          var ajaxOpt = {
            url: "<?php echo base_url('PersonDetail/savePersonalDoc'); ?>",
            type: "POST",
            dataType: "json",
            success: function (res) {
              if (res.status) {
                personalDocTable.ajax.reload(null, false);
                $('#personalDocModal').modal('hide');
                $('#personalDoc_doc_file').val('');
                if (typeof Swal !== 'undefined') Swal.fire({ icon: 'success', title: 'Saved', text: res.message });
                else alert(res.message);
              } else {
                if (typeof Swal !== 'undefined') Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                else alert(res.message);
              }
            }
          };
          if (hasFile) {
            var formData = new FormData();
            formData.append('idperdoc', $('#personalDoc_idperdoc').val());
            formData.append('idperson', $('#personalDoc_idperson').val());
            formData.append('kdcert', $('#personalDoc_kdcert').val().trim());
            formData.append('doctp', $('#personalDoc_doctp').val().trim());
            formData.append('docissctryid', $('#personalDoc_docissctryid').val());
            formData.append('docno', $('#personalDoc_docno').val().trim());
            formData.append('docissdt', $('#personalDoc_docissdt').val());
            formData.append('docissplc', $('#personalDoc_docissplc').val().trim());
            formData.append('docexpdt', $('#personalDoc_docexpdt').val());
            formData.append('notes', $('#personalDoc_notes').val().trim());
            formData.append('doc_file', fileInput.files[0]);
            ajaxOpt.data = formData;
            ajaxOpt.processData = false;
            ajaxOpt.contentType = false;
          } else {
            ajaxOpt.data = {
              idperdoc: $('#personalDoc_idperdoc').val(),
              idperson: $('#personalDoc_idperson').val(),
              kdcert: $('#personalDoc_kdcert').val().trim(),
              doctp: $('#personalDoc_doctp').val().trim(),
              docissctryid: $('#personalDoc_docissctryid').val(),
              docno: $('#personalDoc_docno').val().trim(),
              docissdt: $('#personalDoc_docissdt').val(),
              docissplc: $('#personalDoc_docissplc').val().trim(),
              docexpdt: $('#personalDoc_docexpdt').val(),
              notes: $('#personalDoc_notes').val().trim()
            };
          }
          $.ajax(ajaxOpt);
        });

        $('#personalDocTable').on('click', '.btn-upload-personaldoc', function () {
          $('#uploadPersonalDoc_idperdoc').val($(this).data('id'));
          $('#uploadPersonalDoc_idperson').val($(this).data('idperson'));
          $('#file_personaldoc_upload').val('');
          $('#file_personaldoc_uploadFeedback').addClass('d-none');
          $('#uploadPersonalDocModal').modal('show');
        });

        $('#btnUploadPersonalDoc').on('click', function () {
          var fileInput = $('#file_personaldoc_upload')[0];
          if (!fileInput.files || !fileInput.files.length) {
            $('#file_personaldoc_uploadFeedback').removeClass('d-none');
            $('#file_personaldoc_upload').addClass('is-invalid');
            return;
          }
          $('#file_personaldoc_uploadFeedback').addClass('d-none');
          $('#file_personaldoc_upload').removeClass('is-invalid');
          var formData = new FormData();
          formData.append('idperdoc', $('#uploadPersonalDoc_idperdoc').val());
          formData.append('idperson', $('#uploadPersonalDoc_idperson').val());
          formData.append('file_personaldoc', fileInput.files[0]);
          $.ajax({
            url: "<?php echo base_url('PersonDetail/uploadPersonalDocFile'); ?>",
            type: "POST",
            dataType: "json",
            data: formData,
            processData: false,
            contentType: false,
            success: function (r) {
              if (r.status) {
                $('#uploadPersonalDocModal').modal('hide');
                personalDocTable.ajax.reload(null, false);
                if (typeof Swal !== 'undefined') Swal.fire({ icon: 'success', title: 'Uploaded', text: r.message });
                else alert(r.message);
              } else {
                if (typeof Swal !== 'undefined') Swal.fire({ icon: 'error', title: 'Error', text: r.message });
                else alert(r.message);
              }
            }
          });
        });
      });
    </script>