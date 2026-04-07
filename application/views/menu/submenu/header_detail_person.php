<div class="container-fluid content-wrapper">
  <div class="row mb-2 ms-2">
    <div class="col-12 d-flex align-items-center gap-2">
      <div class="d-flex flex-wrap justify-content-center gap-2 main-tabs flex-grow-1">
        <button id="btnBack" class="btn btn-light rounded-pill px-3 fst-italic fw-semibold">
          <i class="fa fa-arrow-left"></i> Back
        </button>
        <button id="tabProfile" class="btn btn-primary rounded-pill px-3 fst-italic fw-semibold active">
          Profile
        </button>
        <button id="tabFamily" class="btn btn-light rounded-pill px-3 fst-italic fw-semibold">
          Family
        </button>
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold"
          id="tabCertificates">Certificates</button>
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold" id="tabExperience">Experience</button>
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold" id="tabEducation">Education</button>
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold" id="tabContract">Contract</button>
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold" id="tabNextplan">Next Plan</button>
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold" id="tabtraning">Assessment &
          Tranning</button>
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold" id="tabCompotents">Competence</button>
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold">List Report</button>
        <button class="btn btn-light rounded-pill px-3 fst-italic fw-semibold">List Insident</button>
      </div>

    </div>
  </div>

  <!-- RIBBON (KANAN, DI BAWAH TAB) -->
  <!-- <div class="crew-ribbon-wrapper">
    <div class="crew-ribbon-triangle">
      <span class="crew-id">(004059)</span>
      <span class="crew-name">Muhamad Helmi Tazkia</span>
    </div>
  </div> -->

  <hr>
</div>


<style>
/* posisi kanan bawah tab */
.crew-ribbon-wrapper {
  display: flex;
  justify-content: flex-end;
  margin-right: 16px;
  margin-top: 6px;
}

/* main ribbon */
.crew-ribbon-triangle {
  position: relative;
  background: linear-gradient(135deg, #4b3cff, #6f5cff);
  color: #fff;
  padding: 6px 18px 6px 14px;
  font-size: 13px;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  border-radius: 16px 0 0 16px;
  white-space: nowrap;
}

/* segitiga kanan */
.crew-ribbon-triangle::after {
  content: '';
  position: absolute;
  right: -18px;
  top: 50%;
  transform: translateY(-50%);
  width: 0;
  height: 0;
  border-top: 14px solid transparent;
  border-bottom: 14px solid transparent;
  border-left: 18px solid #6f5cff;
}

/* text */
.crew-id {
  font-size: 12px;
  opacity: 0.85;
}

.crew-name {
  white-space: nowrap;
}

/* mobile */
@media (max-width: 576px) {
  .crew-ribbon-triangle {
    font-size: 11px;
    padding: 5px 14px 5px 10px;
  }
}
</style>

<script>
$(document).ready(function() {

  // Back: gunakan history.back(). Halaman list (Active Roster, dll) pakai stateSave
  // DataTables + sessionStorage agar saat kembali state tabel (halaman, search, urutan) ter-restore tanpa terasa reload.
  document.getElementById('btnBack').addEventListener('click', function() {
    if (window.history.length > 1) {
      window.history.back();
    } else {
      window.location.href = "<?php echo base_url(); ?>";
    }
  });

  // ================= TAB CLICK =================
  $('#tabProfile').on('click', function() {
    setActiveTab('tabProfile');
    loadProfileTab();
  });

  $('#tabFamily').on('click', function() {
    setActiveTab('tabFamily');
    loadFamilyTab();
  });


  $('#tabCertificates').on('click', function() {
    setActiveTab('tabCertificates');
    loadCertificatesTab();
  });


  $('#tabExperience').on('click', function() {
    setActiveTab('tabExperience');
    loadExperienceTab();
  });
  $('#tabEducation').on('click', function() {
    setActiveTab('tabEducation');
    loadEducationTab();
  });

  $('#tabContract').on('click', function() {
    setActiveTab('tabContract');
    loadContractTab();
  });

  $('#tabNextplan').on('click', function() {
    setActiveTab('tabNextplan');
    loadNextplanTab();
  });

  $('#tabtraning').on('click', function() {
    setActiveTab('tabtraning');
    loadTraningtab();
  });

  $('#tabCompotents').on('click', function() {
    setActiveTab('tabCompotents');
    loadCompotentsTab();
  });

  // ================= SET ACTIVE TAB =================
  function setActiveTab(activeBtnId) {
    $('.main-tabs button')
      .removeClass('btn-primary active')
      .addClass('btn-light');

    $('#' + activeBtnId)
      .addClass('btn-primary active')
      .removeClass('btn-light');
  }


  function loadProfileTab() {
    $('#loginLoading').show();
    var idperson = "<?php echo $idperson ?>";
    window.location.href =
      "<?php echo base_url('PersonDetail/index'); ?>/" + idperson;
    $('#loginLoading').hide();

  }


  function loadFamilyTab() {
    $('#loginLoading').show();
    $.ajax({
      url: "<?php echo base_url('CrewDetail/Family'); ?>",
      type: "GET",
      success: function(html) {
        $('#contentArea').html(html);
      },
      error: function() {
        $('#contentArea').html(
          '<div class="text-danger">Failed load family</div>'
        );
      },
      complete: function() {
        $('#loginLoading').hide();
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
      }
    });
  }

  function loadExperienceTab() {
    // $('#loginLoading').show();
    $.ajax({
      url: "<?php echo base_url('CrewDetail/Experience'); ?>",
      type: "GET",
      success: function(html) {
        $('#contentArea').html(html);
      },
      error: function() {
        $('#contentArea').html(
          '<div class="text-danger">Failed load Experience</div>'
        );
      }
    });
  }

  function loadEducationTab() {
    $.ajax({
      url: "<?php echo base_url('CrewDetail/Education'); ?>",
      type: "GET",
      success: function(html) {
        $('#contentArea').html(html);
      },
      error: function() {
        $('#contentArea').html(
          '<div class="text-danger">Failed load Education</div>'
        );
      }
    });
  }

  function loadContractTab() {
    $.ajax({
      url: "<?php echo base_url('CrewDetail/Contract'); ?>",
      type: "GET",
      success: function(html) {
        $('#contentArea').html(html);
      },
      error: function() {
        $('#contentArea').html(
          '<div class="text-danger">Failed load Contract</div>'
        );
      }
    });
  }

  function loadNextplanTab() {
    $('#loginLoading').show();
    $.ajax({
      url: "<?php echo base_url('CrewDetail/NextPlan'); ?>",
      type: "GET",
      success: function(html) {
        $('#contentArea').html(html);
      },
      error: function() {
        $('#contentArea').html(
          '<div class="text-danger">Failed load family</div>'
        );
      },
      complete: function() {
        $('#loginLoading').hide();
      }
    });
  }


  function loadTraningtab() {
    $('#loginLoading').show();
    $.ajax({
      url: "<?php echo base_url('CrewDetail/Traning'); ?>",
      type: "GET",
      success: function(html) {
        $('#contentArea').html(html);
      },
      error: function() {
        $('#contentArea').html(
          '<div class="text-danger">Failed load family</div>'
        );
      },
      complete: function() {
        $('#loginLoading').hide();
      }
    });
  }

  function loadCompotentsTab() {
    $('#loginLoading').show();
    $.ajax({
      url: "<?php echo base_url('CrewDetail/Compotents'); ?>",
      type: "GET",
      success: function(html) {
        $('#contentArea').html(html);
      },
      error: function() {
        $('#contentArea').html(
          '<div class="text-danger">Failed load Competence</div>'
        );
      },
      complete: function() {
        $('#loginLoading').hide();
      }
    });
  }

});
</script>