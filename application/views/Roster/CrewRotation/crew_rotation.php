<div class="crew-rotation-content">
  <div class="container-fluid mb-4">


    <style>
      /* ===============================
   GLOBAL TABLE STYLE – CREW PLAN
   =============================== */

      :root {
        --crew-blue: #000099;
        --crew-font-sm: 12px;
        --crew-font-xs: 11px;
      }

      /* TABLE BASE */
      .crew-table th,
      .crew-table td {
        font-size: var(--crew-font-sm);
        vertical-align: middle;
      }

      .crew-table th {
        font-weight: 600;
        text-align: center;
      }

      /* BUTTON INSIDE TABLE */
      .crew-table .btn {
        font-size: var(--crew-font-xs);
        padding: 2px 6px;
      }

      /* HEADER COLOR (BLUE) */
      .crew-header th {
        background-color: var(--crew-blue) !important;
        color: #fff !important;
      }

      /* HEADER GROUP (ONBOARD / REPLACEMENT) */
      .crew-header-group {
        background-color: var(--crew-blue) !important;
        color: #fff !important;
        font-style: italic;
      }

      /* BADGE STATUS */
      .badge-status {
        font-size: 11px;
        padding: 4px 8px;
      }

      /* LINK NAME */
      .crew-name {
        font-weight: 600;
        color: #0d6efd;
        text-decoration: none;
      }

      .crew-name:hover {
        text-decoration: underline;
      }
    </style>

    <div class="col-md-6 d-flex gap-2 compact-form">
      <button class="btn btn-dark btn-pill rounded-pill ms-3">
        New
      </button>
      <div class="input-group">

        <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
          aria-expanded="false">
          Filter
        </button>
        <ul class="dropdown-menu">
          <li>
            <a class="dropdown-item filter-item" href="#" data-value="id">ID</a>
          </li>
          <li>
            <a class="dropdown-item filter-item" href="#" data-value="name">Name</a>
          </li>
          <li>
            <a class="dropdown-item filter-item" href="#" data-value="age">Age</a>
          </li>
          <li>
            <a class="dropdown-item filter-item" href="#" data-value="rank">Rank</a>
          </li>
          <li>
            <a class="dropdown-item filter-item" href="#" data-value="applied">Applied For</a>
          </li>
          <li>
            <a class="dropdown-item filter-item" href="#" data-value="vessel">Vessel</a>
          </li>
        </ul>
        <input type="text" class="form-control" id="txtSearch" placeholder="Type keyword...">
        <input type="hidden" id="typeSearch" value="name">
        <button class="btn btn-outline-secondary" type="button" onclick="loadCrew(1)">
          Search
        </button>
      </div>
      <button class="btn btn-success" type="button" onclick="loadCrew(1)">
        Export
      </button>
    </div>

    <div class="">
      <div class="card-body p-0 ms-1 me-md-1 pt-3">
        <div class="table-responsive">

          <table class="table table-sm table-bordered align-middle mb-0 crew-table">

            <thead class="crew-header">
              <tr>
                <th rowspan="2">No</th>
                <th colspan="5" class="crew-header-group">ONBOARD</th>
                <th colspan="3" class="crew-header-group">REPLACEMENT</th>
                <th rowspan="2">Status</th>
                <th rowspan="2">Next Vessel</th>
              </tr>
              <tr>
                <th>Name</th>
                <th>Rank</th>
                <th>S/ON</th>
                <th>Vessel</th>
                <th>S/OFF Plan</th>
                <th>Remark</th>
                <th>Rank</th>
                <th>Name</th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td class="text-center">1</td>

                <td>
                  <a href="#" class="crew-name">
                    Jefri Bernadus
                  </a>
                </td>
                <td class="text-center">A/B</td>
                <td class="text-center">17-10-2025</td>
                <td>MT. ANDHIKA VIDYANATA</td>
                <td class="text-center">17-07-2026</td>

                <td class="fst-italic text-muted">Planned</td>
                <td class="text-center">A/B</td>
                <td class="text-muted">-</td>

                <td class="text-center">
                  <span class="badge bg-success badge-status">Submit</span>
                </td>
                <td>MT. ANDHIKA VIDYANATA</td>
              </tr>
              <tr>
                <td class="text-center">2</td>

                <td>
                  <a href="#" class="crew-name">
                    Hardi Rama
                  </a>
                </td>
                <td class="text-center">A/B</td>
                <td class="text-center">17-10-2025</td>
                <td>MT. ANDHIKA VIDYANATA</td>
                <td class="text-center">17-07-2026</td>

                <td class="fst-italic text-muted">Planned</td>
                <td class="text-center">A/B</td>
                <td class="text-muted">-</td>

                <td class="text-center">
                  <span class="badge bg-danger badge-status">Cancel</span>
                </td>
                <td>MT. ANDHIKA VIDYANATA</td>
              </tr>
              <tr>
                <td class="text-center">3</td>

                <td>
                  <a href="#" class="crew-name">
                    Hardi Rama
                  </a>
                </td>
                <td class="text-center">A/B</td>
                <td class="text-center">17-10-2025</td>
                <td>MT. ANDHIKA VIDYANATA</td>
                <td class="text-center">17-07-2026</td>

                <td class="fst-italic text-muted">Planned</td>
                <td class="text-center">A/B</td>
                <td class="text-muted">-</td>

                <td class="text-center">
                  <span class="badge bg-primary badge-status">Joined</span>
                </td>
                <td>MT. ANDHIKA VIDYANATA</td>
              </tr>
            </tbody>

          </table>

        </div>
      </div>
    </div>



  </div>

</div>

<script>
  $('.crew-name').on('click', function (e) {
    e.preventDefault();
    $('#nextPlanVesselCard').removeClass('d-none');
  });

  $('#btnCloseNextPlan').on('click', function () {
    $('#nextPlanVesselCard').addClass('d-none');
  });
</script>