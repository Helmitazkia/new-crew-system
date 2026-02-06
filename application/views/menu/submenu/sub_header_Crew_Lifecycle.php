<div class="container-fluid content-wrapper text-center">
  <div class="row align-items-center mb-0 ms-2 ">
    <div class="col-md-8 d-flex justify-content-end gap-1 main-tabs">
      <button class="btn btn-primary rounded-pill fst-italic fw-semibold active" id="activeRoster">
        Active Roster
      </button>
      <button class="btn btn-light rounded-pill fst-italic fw-semibold" id="menuCrewRotation">
        Crew Rotation
      </button>
      <button class="btn btn-light rounded-pill fst-italic fw-semibold" id="menuMasterPersonal">
        Master Personal
      </button>
    </div>
    <hr class="border-top border-1 border-secondary mt-2 mb-1 w-100">
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
    $('#loginLoading').show();

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

        loadCrew(1);
      },
      error: function() {
        alert('Gagal membuka Active Roster');
      },
      complete: function() {
        $('#loginLoading').hide();
      }
    });
  });

  $('#menuCrewRotation').on('click', function() {
    setActiveTab($(this));
    $('#loginLoading').show();

    $.ajax({
      url: "<?php echo base_url('CrewRotation/CrewRotation/ajaxCrewRotation'); ?>",
      type: 'GET',
      success: function(html) {
        $('#contentArea').html(html);
      },
      error: function() {
        alert('Gagal membuka Crew Rotation');
      },
      complete: function() {
        $('#loginLoading').hide();
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