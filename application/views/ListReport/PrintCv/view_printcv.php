<style>
/* Ensure selectpicker dropdown item text is black */
#printCvWrapper .bootstrap-select .dropdown-menu li a {
  color: #000 !important;
}
</style>
<div class="card shadow-sm border-0" id="printCvWrapper">
  <div class="card-body">
    <h5 class="mb-4" style="color: #000099;"><i class="fa fa-print me-2"></i> Print CV</h5>

    <div class="row align-items-end">
      <div class="col-md-4">
        <label class="form-label fw-semibold" style="font-size: 13px;">Company</label>
        <select class="form-control selectpicker" data-live-search="true" data-size="5"
          data-style="btn-white border text-dark" name="id_company" id="selectCompany" required>
          <!-- Options populated via JS -->
        </select>
      </div>
      <div class="col-md-2">
        <button type="button" class="btn btn-primary btn-sm w-100" id="btnPrintCv"
          style="background-color: #000999; border-color: #000999; height: 34px;">
          <i class="fa fa-print me-1"></i> Print
        </button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  var BASE_URL = '<?php echo base_url("ListReport/PrintCv"); ?>';

  // Get idperson from contentArea
  var idperson = $('#contentArea').data('idperson');
  if (!idperson) {
    console.error('ID Person tidak ditemukan');
    return;
  }

  // Load Company
  $('#selectCompany').selectpicker('refresh');
  $.ajax({
    url: BASE_URL + '/get_CompanyBaseVessel',
    type: 'GET',
    dataType: 'json',
    success: function(res) {
      if (res.success && res.data.length > 0) {
        var options = '<option value="">- Pilih Company -</option>';
        $.each(res.data, function(index, item) {
          options += '<option value="' + item.kdcmp + '">' + item.nmcmp + '</option>';
        });

        $('#selectCompany').html(options);

        if ($().selectpicker) {
          $('#selectCompany').selectpicker('refresh');
        }
      }
    },
    error: function(xhr, error, thrown) {
      console.error('Error loading companies:', error);
    }
  });

  $('#btnPrintCv').click(function() {
    var kdcmp = $('#selectCompany').val();
    if (!kdcmp) {
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          icon: 'warning',
          title: 'Peringatan',
          text: 'Silakan pilih Company terlebih dahulu',
          confirmButtonColor: '#000099'
        });
      } else {
        alert('Silakan pilih Company terlebih dahulu');
      }
      return;
    }

    // Open print CV URL in new tab
    var printUrl = BASE_URL + '/prinr_cv_view/' + idperson + '/' + encodeURIComponent(kdcmp);
    window.open(printUrl, '_blank');
  });
});
</script>