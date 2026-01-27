<div class="table-master-personal">
  <div class="container-fluid content-wrapper">
    <div class="row align-items-center">
      <!-- DROPDOWN FILTER -->
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

      <!-- RIGHT : STATUS TABS -->
      <div class="col-md-6 d-flex justify-content-end gap-1 status-tabs pe-md-4">
        <button class="btn btn-info rounded-pill fst-italic fw-semibold" data-status="All">
          All
        </button>
        <button class="btn btn-light btn-pill rounded-pill fst-italic fw-semibold" data-status="pickup">
          Data Pickup
        </button>
        <button class="btn btn-light rounded-pill fst-italic fw-semibold" data-status="onboard">
          On Board
        </button>
        <!-- <button class="btn btn-light rounded-pill fst-italic fw-semibold" data-status="onleave">
          On Leave
        </button>
        <button class="btn btn-light rounded-pill fst-italic fw-semibold" data-status="nonactive">
          Non Active
        </button>
        <button class="btn btn-light rounded-pill fst-italic fw-semibold" data-status="nonforemp">
          Non For Emp
        </button> -->
      </div>
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
  <!-- TABLE -->
  <div class="table-responsive ms-3 me-md-3 pt-3">
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
      <tbody id="crewBody">
        <!-- FILLED BY JSON -->
      </tbody>
    </table>
  </div>


  <div id="loginLoading" class="text-center mt-3">
    <img src="<?php echo base_url('assets/img/loading-new.gif'); ?>" width="60" alt="Loading">
  </div>

  <style>
    #loginLoading {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 9999;
    }
  </style>

  <style>
    .crew-table th,
    .crew-table td {
      font-size: 12px;
      /* default kecil & nyaman */
      vertical-align: middle;
    }

    .crew-table th {
      font-weight: 600;
    }

    .crew-table .btn {
      font-size: 11px;
      padding: 2px 6px;
    }
  </style>


  <!-- PAGINATION -->
  <nav class="mt-3 ms-3">
    <ul class="pagination flex-wrap" id="crewPagination"></ul>
  </nav>

  <style>
    #crewPagination {
      row-gap: 6px;
    }

    @media (max-width: 576px) {
      #crewPagination {
        justify-content: center;
      }
    }
  </style>



  <!-- PAGINATION -->

</div>


<script>
  $(document).ready(function () {
    loadCrew(1);
    $('#loginLoading').hide();

    $('.status-tabs button').click(function () {
      $('.status-tabs button').removeClass('btn-info active').addClass('btn-light');
      $(this).addClass('btn-info active').removeClass('btn-light');
      loadCrew(1);
    });

    $('#button-addon2').click(function () {
      loadCrew(1);
    });

    $(document).on('click', '.filter-item', function (e) {
      e.preventDefault();

      let type = $(this).data('value');
      let label = $(this).text();

      $('#typeSearch').val(type);
      $('.dropdown-toggle').text(label);
    });


  });

  function renderPagination(total, page, limit) {
    let totalPage = Math.ceil(total / limit);
    let maxVisible = 10;
    let html = '';

    if (totalPage <= 1) {
      $('#crewPagination').html('');
      return;
    }

    let startPage = Math.floor((page - 1) / maxVisible) * maxVisible + 1;
    let endPage = startPage + maxVisible - 1;

    if (endPage > totalPage) {
      endPage = totalPage;
    }


    if (page > 1) {
      html += `
      <li class="page-item">
        <a class="page-link" href="javascript:void(0)" onclick="loadCrew(${page - 1})">
          Previous
        </a>
      </li>
    `;
    }


    if (startPage > 1) {
      html += `
      <li class="page-item">
        <a class="page-link" onclick="loadCrew(1)">1</a>
      </li>
      <li class="page-item disabled">
        <span class="page-link">...</span>
      </li>
    `;
    }

    for (let i = startPage; i <= endPage; i++) {
      html += `
      <li class="page-item ${i === page ? 'active' : ''}">
        <a class="page-link" onclick="loadCrew(${i})">${i}</a>
      </li>
    `;
    }

    if (endPage < totalPage) {
      html += `
      <li class="page-item disabled">
        <span class="page-link">...</span>
      </li>
      <li class="page-item">
        <a class="page-link" onclick="loadCrew(${totalPage})">${totalPage}</a>
      </li>
    `;
    }

    if (page < totalPage) {
      html += `
      <li class="page-item">
        <a class="page-link" href="javascript:void(0)" onclick="loadCrew(${page + 1})">
          Next
        </a>
      </li>
    `;
    }

    $('#crewPagination').html(html);
  }


  function renderTable(data, page, limit) {
    let html = '';
    let no = (page - 1) * limit + 1;

    if (data.length === 0) {
      html = `<tr>
              <td colspan="9" class="text-center text-muted">No data found</td>
            </tr>`;
    } else {
      $.each(data, function (i, v) {
        html += `
        <tr class="${i % 2 ? 'table-secondary' : ''}">
          <td>${no++}</td>
          <td>(${v.idperson}) ${v.fullName}</td>
          <td>${v.applyfor}</td>
          <td>${v.gender}</td>
          <td>${v.religion}</td>
          <td>${v.NmKota}, ${v.dob}</td>
          <td>${v.statusPerson}</td>
          <td>${v.lowerRank}</td>
          <td>
            <button class="btn btn-warning btn-sm btn-pill" onclick="detailCrew('${v.idperson}')">Detail</button>
            <button class="btn btn-danger btn-sm btn-pill" onclick="deleteCrew('${v.idperson}')">Delete</button>
          </td>
        </tr>
      `;
      });
    }

    $('#crewBody').html(html);
  }



  function detailCrew(idperson) {
    $('#loginLoading').show();

    window.location.href = "<?php echo base_url('PersonDetail'); ?>";
      setTimeout(function () {
        $('#loginLoading').hide();
    }, 5000); // 5000ms = 5 detik

    $('#loginLoading').hide();

    // $.ajax({
    //   url: '<?php echo base_url("Profile/getProfileAjax"); ?>/' + idperson,
    //   type: 'GET',
    //   success: function (html) {
    //     // $('#contentArea').html(html);
    //     console.log('Loaded Profile layout successfully');
    //   },
    //   error: function (xhr) {
    //     console.log(xhr.responseText);
    //     alert('Gagal load layout Profile');
    //   },
    //   complete: function () {
    //     $('#loginLoading').hide();
    //   }
    // });
  }








  function loadCrew(page = 1) {
    $('#loginLoading').show();
    var currentPage = 1;
    currentPage = page;
    let status = $('.status-tabs .active').data('status') || 'All';
    console.log('Status:', status);

    let url = '';
    if (status === 'onboard') {
      url = "<?php echo base_url('MasterPersonal/MasterPersonal/getDataOnboard/search'); ?>";
    } else if (status === 'onleave') {
      url = "<?php echo base_url('MasterPersonal/MasterPersonal/getDataOnLeave/search'); ?>";
    } else if (status === 'nonactive') {
      url = "<?php echo base_url('MasterPersonal/MasterPersonal/getDataNonAktif/search'); ?>";
    } else if (status === 'nonforemp') {
      url = "<?php echo base_url('MasterPersonal/MasterPersonal/getDataNotForEmp/search'); ?>";
    } else if (status === 'pickup') {
      url = "<?php echo base_url('MasterPersonal/MasterPersonal/getDataPickup/search'); ?>";
    } else if (status === 'All') {
      url = "<?php echo base_url('MasterPersonal/MasterPersonal/getAllData_personal'); ?>";
    }

    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data: {
        page: page,
        txtSearch: $('#txtSearch').val(),
        typeSearch: $('#typeSearch').val()
      },
      success: function (res) {
        if (res.success) {
          $('#loginLoading').hide();
          if (status === "All") {
            renderTable(res.data, res.page || 1, res.limit || 30);
            renderPagination(res.total || 0, res.page || 1, res.limit || 30);
          } else {
            renderTable(res.data, 1, res.data.length);
            $('#paginationNav').hide();
            $('#crewPagination').empty();
          }


        } else {
          $('#crewBody').html(
            `<tr><td colspan="9" class="text-center text-muted">No data</td></tr>`
          );
          $('#paginationContainer').html('');
        }
      },
      error: function (xhr) {
        console.error(xhr.responseText);
        $('#crewBody').html(
          `<tr><td colspan="9" class="text-center text-danger">
                      Error loading data
                  </td></tr>`
        );
      }
    });
  }
</script>