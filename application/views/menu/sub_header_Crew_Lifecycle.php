    <!-- <div class="row align-items-center mb-4 ms-2"> -->
    <div class="container-fluid content-wrapper">
      <div class="row align-items-center mb-4 ms-2">
        <!-- RIGHT : STATUS TABS -->
        <div class="col-md-8 d-flex justify-content-end gap-1 main-tabs">
          <button class="btn btn-light  rounded-pill fst-italic fw-semibold" id ="activeRoster">
            Active Roster
          </button>
          <button class="btn btn-light rounded-pill fst-italic fw-semibold" id ="menuCrewRotation">
            Crew Rotation
          </button>
          <button class="btn btn-primary rounded-pill fst-italic fw-semibold active" id="menuMasterPersonal">
            Master Personal
          </button>
        </div>
        <hr class="border-top border-1 border-secondary align-self-center mt-3" style="width: 100%;">
      </div>

      </hr>

      <script>
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

          $('#menuMasterPersonal').on('click', function () {
            $('.status-tabs button')
              .removeClass('btn-info active')
              .addClass('btn-light');
            $('.status-tabs button[data-status="All"]')
              .addClass('btn-info active')
              .removeClass('btn-light');
            loadCrew(1);
          });

        });
      </script>

  