<?php
// â”€â”€ ROLE ACCESS FILTER untuk sub-menu Crew Lifecycle â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
$CI =& get_instance(); $CI->load->model('HakAksesModel');
$_crewRc          = $CI->session->userdata('userJenis');
$_canActiveRoster = $CI->HakAksesModel->canAccessSubMenuByCode($_crewRc, 'active_roster');
$_canCrewRotation = $CI->HakAksesModel->canAccessSubMenuByCode($_crewRc, 'crew_rotation');
$_canMasterPersonal = $CI->HakAksesModel->canAccessSubMenuByCode($_crewRc, 'master_personal');

// Tentukan tab mana yang aktif pertama (urutan prioritas: active_roster â†’ crew_rotation â†’ master_personal)
$_firstActive = '';
if ($_canActiveRoster)   $_firstActive = 'activeRoster';
elseif ($_canCrewRotation)   $_firstActive = 'menuCrewRotation';
elseif ($_canMasterPersonal) $_firstActive = 'menuMasterPersonal';
?>

<div class="container-fluid content-wrapper">
  <div class="row justify-content-center align-items-center mb-0">
    <div class="col-12 col-xl-8 d-flex justify-content-center gap-2 main-tabs flex-wrap">

      <?php if ($_canActiveRoster): ?>
      <button class="btn <?php echo $_firstActive === 'activeRoster' ? 'btn-primary active' : 'btn-light shadow-sm'; ?> rounded-pill fst-italic fw-semibold" id="activeRoster">
        Active Roster
      </button>
      <?php endif; ?>

      <?php if ($_canCrewRotation): ?>
      <button class="btn <?php echo $_firstActive === 'menuCrewRotation' ? 'btn-primary active' : 'btn-light shadow-sm'; ?> rounded-pill fst-italic fw-semibold" id="menuCrewRotation">
        Crew Rotation
      </button>
      <?php endif; ?>

      <?php if ($_canMasterPersonal): ?>
      <button class="btn <?php echo $_firstActive === 'menuMasterPersonal' ? 'btn-primary active' : 'btn-light shadow-sm'; ?> rounded-pill fst-italic fw-semibold" id="menuMasterPersonal">
        Master Personal
      </button>
      <?php endif; ?>

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
  <?php if ($_canActiveRoster): ?>
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
      },
      error: function() {
        alert('Gagal membuka Active Roster');
      }
    });
  });
  <?php endif; ?>

  // ================= CREW ROTATION =================
  <?php if ($_canCrewRotation): ?>
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
  <?php endif; ?>

  // ================= MASTER PERSONAL =================
  <?php if ($_canMasterPersonal): ?>
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
  <?php endif; ?>

  // ================= AUTO-LOAD TAB PERTAMA =================
  <?php if ($_firstActive === 'activeRoster'): ?>
  // Auto-trigger tab Active Roster jika punya akses
  $('#activeRoster').trigger('click');
  <?php elseif ($_firstActive === 'menuCrewRotation'): ?>
  // User tidak punya akses Active Roster, load Crew Rotation
  $('#menuCrewRotation').trigger('click');
  <?php elseif ($_firstActive === 'menuMasterPersonal'): ?>
  // User hanya punya akses Master Personal
  $('#menuMasterPersonal').trigger('click');
  <?php else: ?>
  // Tidak ada akses sama sekali â†’ tampilkan pesan
  $('#contentArea').html(
    '<div class="alert alert-warning m-4">'
    + '<i class="fas fa-lock me-2"></i>'
    + '<strong>Akses Ditolak.</strong> Role Anda tidak memiliki akses ke menu Crew Lifecycle.'
    + '</div>'
  );
  <?php endif; ?>

});
</script>
