<!-- sub header for Crew Lifecycle menu -->
    <div class="container-fluid content-wrapper">
      <div class="row align-items-center mb-4 ms-2">
        <div class="col-md-8 d-flex justify-content-end gap-1 main-tabs">
          <button class="btn btn-primary  rounded-pill fst-italic fw-semibold active" id="activeRoster">
            Active Roster
          </button>
          <button class="btn btn-light rounded-pill fst-italic fw-semibold" id="menuCrewRotation">
            Crew Rotation
          </button>
          <button class="btn btn-light rounded-pill fst-italic fw-semibold" id="menuMasterPersonal">
            Master Personal
          </button>
        </div>
        <hr class="border-top border-1 border-secondary align-self-center mt-3" style="width: 100%;">
      </div>

      </hr>

      <!-- <script>
        /*Master Personal Menu Tab Active*/
        $(document).ready(function () {

          $('.main-tabs button').on('click', function () {
            $('.main-tabs button')
              .removeClass('btn-primary active')
              .addClass('btn-light');

            $(this)
              .addClass('btn-primary active')
              .removeClass('btn-light');
          });

          $('#menuCrewRotation')
          .addClass('btn-primary active')
          .removeClass('btn-light');

          $('#activeRoster').on('click', function () {
            $('.status-tabs button')
              .removeClass('btn-info active')
              .addClass('btn-light');
            $('.status-tabs button[data-status="All"]')
              .addClass('btn-info active')
              .removeClass('btn-light');
            loadCrew(1);
          });

          $('#menuMasterPersonal').on('click', function () {
            $('#loginLoading').show();
            $.ajax({
              url: "<?php echo base_url('MasterPersonal/MasterPersonal/getCrewRoster'); ?>",
              type: 'GET',
              success: function (html) {
                let content = $(html).find('#contentArea').html();
                $('#contentArea').html(content);
              },
              error: function (xhr) {
                alert('Gagal membuka Master Personal');
                console.error(xhr.responseText);
              },
              complete: function () {
                $('#loginLoading').hide();
              }
            });
          });

          $('#activeRoster').on('click', function () {
            $('#loginLoading').show();
            $.ajax({
              url: "<?php echo base_url('ActiveRoster/ActiveRoster/getActiveRoster'); ?>",
              type: 'GET',
              success: function (html) {
                let content = $(html).find('#contentArea').html();
                $('#contentArea').html(content);
              },
              error: function (xhr) {
                alert('Gagal membuka Active Roster');
                console.error(xhr.responseText);
              },
              complete: function () {
                $('#loginLoading').hide();
              }
            });
          });


          // $('#menuCrewRotation').on('click', function () {
          //   console.log('Crew Rotation clicked');
          //   $('#loginLoading').show();
          //   window.location.href =
          //     "<?php echo base_url('CrewRotation/CrewRotation/getCrew_rotation'); ?>";
          //   $('#loginLoading').hide();

          // });


          $('#menuCrewRotation').on('click', function () {
            console.log('Crew Rotation clicked');
            $('#loginLoading').show();

            $.ajax({
              url: "<?php echo base_url('CrewRotation/CrewRotation/ajaxCrewRotation'); ?>",
              type: 'GET',
              success: function (html) {
                let content = $(html).find('#contentArea').html();
                $('#contentArea').html(content);
                console.log('Crew Rotation content loaded');
              },
              error: function (xhr) {
                alert('Gagal membuka Crew Rotation');
                console.error(xhr.responseText);
              },
              complete: function () {
                $('#loginLoading').hide();
              }
            });
          });


          // function detailCrew(idperson) {
          //   window.location.href =
          //     "<?php echo base_url('PersonDetail/index'); ?>/" + idperson;
          // }



        });
      </script> -->
      <script>
$(document).ready(function () {

  function setActiveTab(btn) {
    $('.main-tabs button')
      .removeClass('btn-primary active')
      .addClass('btn-light');

    btn
      .addClass('btn-primary active')
      .removeClass('btn-light');
  }

  // ================= ACTIVE ROSTER =================
  $('#activeRoster').on('click', function () {
    setActiveTab($(this));
    $('#loginLoading').show();

    $.ajax({
      url: "<?php echo base_url('ActiveRoster/ActiveRoster/getActiveRoster'); ?>",
      type: 'GET',
      success: function (html) {
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
      error: function () {
        alert('Gagal membuka Active Roster');
      },
      complete: function () {
        $('#loginLoading').hide();
      }
    });
  });

  // ================= CREW ROTATION =================
  $('#menuCrewRotation').on('click', function () {
    setActiveTab($(this));
    $('#loginLoading').show();

    $.ajax({
      url: "<?php echo base_url('CrewRotation/CrewRotation/ajaxCrewRotation'); ?>",
      type: 'GET',
      success: function (html) {
        $('#contentArea').html(html);
      },
      error: function () {
        alert('Gagal membuka Crew Rotation');
      },
      complete: function () {
        $('#loginLoading').hide();
      }
    });
  });

  // ================= MASTER PERSONAL =================
  $('#menuMasterPersonal').on('click', function () {
    setActiveTab($(this));
    $('#loginLoading').show();

    $.ajax({
      url: "<?php echo base_url('MasterPersonal/MasterPersonal/getCrewRoster'); ?>",
      type: 'GET',
      success: function (html) {
        $('#contentArea').html(html);
      },
      error: function () {
        alert('Gagal membuka Master Personal');
      },
      complete: function () {
        $('#loginLoading').hide();
      }
    });
  });

});
</script>
