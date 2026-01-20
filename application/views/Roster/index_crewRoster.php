  <div class="container-fluid content-wrapper">

    <div class="row align-items-center mb-4 ms-2">

      <!-- LEFT : TOP BUTTON -->
      <div class="col-md-6 d-flex gap-2 compact-form">

        <button class="btn btn-dark btn-pill rounded-pill">
          New
        </button>
        <div class="input-group">
          <button class=" btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown"
            aria-expanded="false">Filter</button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" style="font-size: 13px;">Rank</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
          </ul>
          <input type="text" class="form-control" aria-label="Text input with 2 dropdown buttons">
          <button class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button></li>
          </ul>
        </div>
      </div>

      <!-- RIGHT : STATUS TABS -->
      <div class="col-md-6 d-flex justify-content-end gap-1 status-tabs">
        <button class="btn btn-info btn-pill rounded-pill fst-italic fw-semibold active">
          Data Pickup
        </button>
        <button class="btn btn-light rounded-pill fst-italic fw-semibold">
          On Board
        </button>
        <button class="btn btn-light rounded-pill fst-italic fw-semibold">
          On Leave
        </button>
        <button class="btn btn-light rounded-pill fst-italic fw-semibold">
          Non Active
        </button>
        <button class="btn btn-light rounded-pill fst-italic fw-semibold">
          Non For Emp
        </button>
      </div>

    </div>


    <style>
      .table-header-blue th {
        background: #000099 !important;
        color: #ffffff !important;
        text-align: center;
        vertical-align: middle;
        font-weight: 600;
      }
    </style>
    <!-- TABLE -->
    <div class="table-responsive ms-3 me-md-3">
      <table class="table table-bordered crew-table">
        <thead class="table-header-blue">
          <tr>
            <th class="fst-italic">No</th>
            <th class="fst-italic">Full Name Crew</th>
            <th class="fst-italic">Rank Applied For</th>
            <th class="fst-italic">Gender</th>
            <th class="fst-italic">Religion</th>
            <th class="fst-italic">Birth</th>
            <th class="fst-italic">Status Person</th>
            <th class="fst-italic">Accept Lower Rank</th>
            <th class="fst-italic">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>(000003) SUJIWA</td>
            <td>MASTER</td>
            <td>Male</td>
            <td>Mooslem</td>
            <td>CIAMIS, 10 Jul 1977</td>
            <td>Active</td>
            <td>Yes</td>
            <td>
              <button class="btn btn-warning btn-sm btn-pill">Detail</button>
              <button class="btn btn-danger btn-sm btn-pill">Delete</button>
            </td>
          </tr>
          <tr class="table-secondary">
            <td>2</td>
            <td>(000003) SUJIWA</td>
            <td>MASTER</td>
            <td>Male</td>
            <td>Mooslem</td>
            <td>CIAMIS, 10 Jul 1977</td>
            <td>Active</td>
            <td>Yes</td>
            <td>
              <button class="btn btn-warning btn-sm btn-pill">Detail</button>
              <button class="btn btn-danger btn-sm btn-pill">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- PAGINATION -->
    <nav class="mt-3 ms-3">
      <ul class="pagination">
        <li class="page-item"><a class="page-link">Previous</a></li>
        <li class="page-item active"><a class="page-link">1</a></li>
        <li class="page-item"><a class="page-link">2</a></li>
        <li class="page-item"><a class="page-link">Next</a></li>
      </ul>
    </nav>
  </div>