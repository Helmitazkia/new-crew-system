<div class="profile-content">
  <!-- SEMUA CONTENT PROFILE MASUK SINI -->

  <div class="container-fluid mb-4">
    <div class="row g-3 mb-4">

      <!-- FOTO -->
      <div class="col-lg-3 col-md-4 col-sm-12 text-center">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <img src="<?php echo base_url('assets/img/banner/andhika-lines.png'); ?>" class="img-fluid rounded mb-3"
              alt="Crew Photo">
            <h6 class="fw-bold mb-0 crew-name" data-field="identity.fullName">A. LOLO</h6>
            <small class="text-muted crew-id" data-field="identity.idperson">ID : 004059</small>

          </div>
        </div>
      </div>

      <!-- BASIC IDENTITY -->
      <div class="col-lg-7 col-md-8 col-sm-12">
        <div class="card shadow-sm h-100">
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
                <label class="form-label mb-0 fst-italic fw-semibold">First Name</label>
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
                <label class="form-label mb-0 fst-italic fw-semibold">Gender</label>
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
                  <!-- <option value="ID">Indonesia</option>
                  <option value="PH">Philippines</option>
                  <option value="IN">India</option> -->
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
                <input type="date" class="form-control form-edit d-none" data-field="identity.dob">
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
        <div class="card shadow-sm h-100">
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
              <div class="col-12">
                <label class="form-label mb-0 fst-italic fw-semibold">Crew Status</label>
                <div class="form-view fst-italic">New Applicant</div>
                <select class="form-select form-edit d-none">
                  <option selected>New Applicant</option>
                  <option>Non Aktif</option>
                  <option>Not for Employed</option>
                  <option>Non Crew</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid mb-4">
    <div class="row">
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
        <div class="card shadow-sm h-100">
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
            <div class="card shadow-sm h-100">
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
                    <input type="text" class="form-control form-edit d-none" data-field="contact.airport">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Mobile Tel.</label>
                    <div class="form-view fst-italic" data-field="contact.mobile"></div>
                    <input type="text" class="form-control form-edit d-none" data-field="contact.mobile">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Home Tel.</label>
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
            <div class="card shadow-sm h-100">
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
                    <div class="form-view fst-italic" data-field="physical.shoes"></div>
                    <input type="number" class="form-control form-edit d-none" data-field="physical.shoes" value="270">
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
                    <div class="form-view fst-italic" data-field="physical.insLeg"></div>
                    <input type="number" class="form-control form-edit d-none" data-field="physical.insLeg" value="78">
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
                    <div class="form-view fst-italic" data-field="physical.boilersuitSize"></div>
                    <select class="form-select form-edit d-none" data-field="physical.boilersuitSize">
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
                    <div class="form-view fst-italic" data-field="physical.claustrophobic"></div>
                    <select class="form-select form-edit d-none" data-field="physical.claustrophobic">
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
                <div class="row g-2">

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">CES Score</label>
                    <div class="form-view fst-italic" data-field="assessment.cesScore"></div>
                    <input type="number" class="form-control form-edit d-none" value="85"
                      data-field="assessment.cesScore">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Marlin Test Score</label>
                    <div class="form-view fst-italic" data-field="assessment.marlinScore"></div>
                    <input type="number" class="form-control form-edit d-none" value="78"
                      data-field="assessment.marlinScore">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Training Date</label>
                    <div class="form-view fst-italic" data-field="assessment.trainingDate"></div>
                    <input type="date" class="form-control form-edit d-none" value="2024-08-15"
                      data-field="assessment.trainingDate">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Evaluation</label>
                    <div class="form-view fst-italic" data-field="assessment.evaluation"></div>
                    <select class="form-select form-edit d-none" data-field="assessment.evaluation">
                      <option value="Recommended">Recommended</option>
                      <option value="Need Improvement">Need Improvement</option>
                      <option value="Not Recommended">Not Recommended</option>
                    </select>
                  </div>

                </div>
              </div>
            </div>
          </div>

          <!-- Career & Placement -->
          <div class="col-6 mb-4">
            <div class="card shadow-sm h-100">
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
                    <div class="form-view fst-italic" data-field="career.vesselfor"></div>
                    <select class="form-select form-edit d-none" data-field="career.vesselfor">
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
                    <input type="date" class="form-control form-edit d-none" value="2024-10-01"
                      data-field="career.availableDate">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- HOME SALARY -->
          <div class="col-6 mb-4">
            <div class="card shadow-sm h-100">
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
            <div class="card shadow-sm h-100">
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

          <!-- Attachments -->
          <div class="col-6 mb-4">
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
          </div>

          <div class="col-6 mb-4">
            <div class="card shadow-sm h-100">
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
                    <div class="form-view fst-italic" data-field="signature.place"></div>
                    <input type="text" class="form-control form-edit d-none" value="Jakarta"
                      data-field="signature.place">
                  </div>

                  <div class="col-md-6">
                    <label class="form-label mb-0 fst-italic fw-semibold">Sign Date</label>
                    <div class="form-view fst-italic" data-field="signature.date"></div>
                    <input type="date" class="form-control form-edit d-none" value="2024-10-01"
                      data-field="signature.date">
                  </div>

                  <div class="col-12">
                    <label class="form-label mb-0 fst-italic fw-semibold">Additional Remarks</label>
                    <div class="form-view fst-italic" data-field="signature.remarks">
                    </div>
                    <textarea class="form-control form-edit d-none" rows="3" data-field="signature.remarks">

              </textarea>
                  </div>

                </div>
              </div>
            </div>
          </div>




        </div>
      </div>
    </div>







    <!-- </div> -->


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

            $(this).prop('checked', value == 1);

          });



        });

        // FOTO
        if (data.files && data.files.photo) {
          $('#crewPhoto').attr(
            'src',
            "<?php echo base_url('uploads/crew/'); ?>" + data.files.photo
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