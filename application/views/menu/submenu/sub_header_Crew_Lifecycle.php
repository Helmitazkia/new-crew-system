<div class="container-fluid content-wrapper">
  <div class="row justify-content-center align-items-center mb-0">
    <div class="col-12 col-xl-8 d-flex justify-content-center gap-2 main-tabs flex-wrap">
      <button class="btn btn-primary rounded-pill fst-italic fw-semibold active" id="activeRoster">
        Active Roster
      </button>
      <button class="btn btn-light rounded-pill fst-italic fw-semibold shadow-sm" id="menuCrewRotation">
        Crew Rotation
      </button>
      <button class="btn btn-light rounded-pill fst-italic fw-semibold shadow-sm" id="menuMasterPersonal">
        Master Personal
      </button>
    </div>
    <div class="col-12">
      <hr class="border-top border-1 border-secondary mt-3 mb-1 w-100">
    </div>
  </div>
</div>

<script>
$(document).ready(function() {

  function setActiveTab(btn) {
    $('.main-tabs button')
      .removeClass('btn-primary active')
      .addClass('btn-light');

    btn
      .addClass('btn-primary active')
      .removeClass('btn-light');
  }

  // ================= ACTIVE ROSTER =================
  $('#activeRoster').on('click', function() {
    setActiveTab($(this));
    $.ajax({
      url: "<?php echo base_url('ActiveRoster/ActiveRoster/getActiveRoster'); ?>",
      type: 'GET',
      success: function(html) {
        $('#contentArea').html(html);

        // optional: reset status tab
        $('.status-tabs button')
          .removeClass('btn-info active')
          .addClass('btn-light');
        $('.status-tabs button[data-status="All"]')
          .addClass('btn-info active')
          .removeClass('btn-light');

        // loadCrew(1);
      },
      error: function() {
        alert('Gagal membuka Active Roster');
      }
    });
  });

  $('#menuCrewRotation').on('click', function() {
    setActiveTab($(this));
    $.ajax({
      url: "<?php echo base_url('CrewRotation/CrewRotation/ajaxCrewRotation'); ?>",
      type: 'GET',
      success: function(html) {
        $('#contentArea').html(html);
      },
      error: function() {
        $('#contentArea').html('<div class="alert alert-danger">Gagal membuka Crew Rotation</div>');
      }
    });
  });

  $('#menuMasterPersonal').on('click', function() {
    setActiveTab($(this));
    $.ajax({
      url: "<?php echo base_url('MasterPersonal/MasterPersonal/getCrewRoster'); ?>",
      type: 'GET',
      success: function(html) {
        $('#contentArea').html(html);
      },
      error: function() {
        alert('Gagal membuka Master Personal');
      },
    });
  });

});
</script>