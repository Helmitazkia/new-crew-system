<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title><?php echo $title ?></title>
  <link rel="icon" href="<?php echo base_url("assets/img/andhika.gif"); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4 sticky-top">
    <a class="navbar-brand fw-bold text-primary" href="#">
      <img src="<?php echo base_url("/assets/img/banner/andhika.png");?>" class="rounded-circle rounded-pill"
        width="110">
    </a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <!-- <ul class="navbar-nav mx-auto gap-3">
        <li class="nav-item  fst-italic  fw-semibold"><a class="nav-link">Dashboard</a></li>
        <li class="nav-item  fst-italic fw-semibold"><a class="nav-link">Master Data</a></li>
        <li class="nav-item  fst-italic fw-semibold"><a class="nav-link ">Crew Roster</a></li>
        <li class="nav-item  fst-italic fw-semibold "><a class="nav-link">Recruitment</a></li>
        <li class="nav-item  fst-italic fw-semibold"><a class="nav-link">Training & Evaluation</a></li>
        <li class="nav-item  fst-italic fw-semibold"><a class="nav-link">Report</a></li>
      </ul> -->
      <ul class="navbar-nav mx-auto gap-3">
        <li class="nav-item fst-italic fw-semibold">
          <a class="nav-link <?php echo ($active_menu == 'dashboard') ? 'active' : '' ?>">Dashboard</a>
        </li>

        <li class="nav-item fst-italic fw-semibold">
          <a class="nav-link <?php echo ($active_menu == 'master_data') ? 'active' : '' ?>">Master Data</a>
        </li>

        <li class="nav-item fst-italic fw-semibold">
          <a class="nav-link <?php echo ($active_menu == 'crew_roster') ? 'active' : '' ?>">Crew Roster</a>
        </li>

        <li class="nav-item fst-italic fw-semibold">
          <a class="nav-link <?php echo ($active_menu == 'recruitment') ? 'active' : '' ?>">Recruitment</a>
        </li>

        <li class="nav-item fst-italic fw-semibold">
          <a class="nav-link <?php echo ($active_menu == 'training') ? 'active' : '' ?>">Training & Evaluation</a>
        </li>

        <li class="nav-item fst-italic fw-semibold">
          <a class="nav-link <?php echo ($active_menu == 'report') ? 'active' : '' ?>">Report</a>
        </li>
      </ul>


      <?php if($this->session->userdata('isLogin')): ?>
      <div class="dropdown position-relative">

        <div class="user-profile d-flex align-items-center cursor-pointer" id="profileDropdown" style="cursor: pointer;"
          data-bs-toggle="dropdown" aria-expanded="false">

          <div class="avatar-circle bg-primary text-white d-flex align-items-center justify-content-center"
            style="width: 40px; height: 40px; border-radius: 50%; font-weight: bold;">
            <?php 
                    $fullname = $this->session->userdata('userFullNm');
                    echo substr($fullname, 0, 1); // Tampilkan huruf pertama nama
                ?>
          </div>
          <span class="ms-2 d-none d-md-inline">
            <?php echo $this->session->userdata('userFullNm'); ?>
          </span>
          <i class="fas fa-chevron-down ms-2 small"></i>
        </div>

        <!-- Dropdown Menu -->
        <div class="dropdown-menu dropdown-menu-end shadow-lg border-0" aria-labelledby="profileDropdown"
          style="width: 250px; border-radius: 10px; margin-top: 10px;">

          <!-- Header Card -->
          <div class="p-3 text-center border-bottom">
            <div
              class="avatar-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-2"
              style="width: 60px; height: 60px; border-radius: 50%; font-size: 1.5rem; font-weight: bold;">
              <?php echo substr($fullname, 0, 1); ?>
            </div>
            <h6 class="mb-1"><?php echo $this->session->userdata('userFullNm'); ?></h6>
            <small class="text-muted"><?php echo $this->session->userdata('userType'); ?></small>
          </div>

          <!-- Menu Items -->
          <div class="p-2">
            <!-- Profile -->
            <a href="<?php echo base_url('profile'); ?>" class="dropdown-item d-flex align-items-center py-2">
              <i class="fas fa-user me-3 text-primary"></i>
              <span>My Profile</span>
            </a>

            <!-- Change Password -->
            <a href="<?php echo base_url('auth/change_password'); ?>"
              class="dropdown-item d-flex align-items-center py-2">
              <i class="fas fa-key me-3 text-warning"></i>
              <span>Change Password</span>
            </a>

            <!-- Divider -->
            <div class="dropdown-divider"></div>

            <!-- Logout -->
            <button type="button" class="dropdown-item d-flex align-items-center py-2 text-danger" id="btnLogout">
              <i class="fas fa-sign-out-alt me-3"></i>
              <span>Logout</span>
            </button>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </nav>



  <script>
    $(document).ready(function () {
      $(document).on('click', '#btnLogout', function (e) {
        e.preventDefault();

        Swal.fire({
          title: 'Konfirmasi Logout',
          text: 'Apakah Anda yakin ingin keluar?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Logout',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            logoutProcess();
          }
        });
      });

      function logoutProcess() {
        $.ajax({
          url: '<?php echo base_url("auth/login/do_logout"); ?>',
          type: 'POST',
          dataType: 'json',
          beforeSend: function () {
            // Update button state
            $('#btnLogout').html('<i class="fas fa-spinner fa-spin me-2"></i>Logging out...');
            $('#btnLogout').prop('disabled', true);
          },
          success: function (response) {
            if (response.status) {
              Swal.fire({
                icon: 'info',
                title: 'Memproses logout...',
                html: `
                    <div class="text-center">
                        <div class="spinner-border text-primary mb-3" role="status"></div>
                    </div>
                `,
                showConfirmButton: false,
                allowOutsideClick: false,
                timer: 1500,
                willClose: () => {
                  window.location.href = '<?php echo base_url("auth/login"); ?>';
                }
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: response.msg,
                confirmButtonColor: '#0000cc'
              });
              resetLogoutButton();
            }
          },
          error: function (xhr, status, error) {
            Swal.close();
            let errorMessage = 'Terjadi kesalahan saat logout';
            try {
              if (xhr.responseJSON && xhr.responseJSON.msg) {
                errorMessage = xhr.responseJSON.msg;
              }
            } catch (e) {
              console.error("Error parsing response:", e);
            }

            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: errorMessage,
              confirmButtonColor: '#0000cc'
            });
            console.error(xhr.responseText);
            resetLogoutButton();
          }
        });
      }

      function resetLogoutButton() {
        $('#btnLogout').html('<i class="fas fa-sign-out-alt me-2"></i>Logout');
        $('#btnLogout').prop('disabled', false);
      }

      $(document).keydown(function (e) {
        if (e.ctrlKey && e.key === 'l') {
          e.preventDefault();
          $('#btnLogout').click();
        }
      });

    });
  </script>

  <style>
    /* Profile dropdown styling */
    .user-profile:hover {
      background-color: rgba(0, 0, 0, 0.05);
      border-radius: 20px;
      padding: 5px 10px;
    }

    .avatar-circle {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .dropdown-menu {
      animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .dropdown-item:hover {
      background-color: #f8f9fa;
      border-radius: 5px;
    }

    #btnLogout:hover {
      background-color: rgba(220, 53, 69, 0.1) !important;
    }

    .cursor-pointer {
      cursor: pointer !important;
    }
  </style>


  <!-- HERO BANNER -->
  <section class="hero-banner position-relative mb-4">
    <img src="<?php echo base_url("assets/img/banner/andhika-lines.png") ;?>" class="hero-img">
    <span class="copyright">© 2026 Andhika Group</span>
  </section>

  <style>
    .hero-banner {
      height: 310px;
      overflow: hidden;
    }

    .hero-img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
    }

    .hero-banner {
      height: 35vh;
      min-height: 260px;
      max-height: 420px;
    }
  </style>

  <style>
    .content-wrapper {
      padding-left: 0;
      padding-right: 0;
    }
  </style>


  <style>
    /* Kecilkan input-group & button di form ini saja */
    .compact-form .btn {
      font-size: 12.5px;
      padding: 5px 12px;
    }

    .compact-form .form-control {
      font-size: 12.5px;
      height: 40px;
    }

    /* Button kanan (Button) */
    .compact-form #button-addon2 {
      height: 40px;
      padding: 4px 12px;
      font-size: 12.5px;
    }

    /* Dropdown button kiri */
    .compact-form .dropdown-toggle {
      height: 40px;
      padding: 4px 10px;
      font-size: 12.5px;
      width: 130px;
    }


    .compact-form .btn-pill {
      padding: 5px 14px;
    }
  </style>

  <style>
    /* Navbar clickable cursor */
    .navbar .nav-link,
    .navbar-brand,
    .navbar-toggler,
    .navbar img {
      cursor: pointer;
    }

    .navbar-nav .nav-link {
      cursor: pointer;
    }

    .navbar-nav .nav-link:hover {
      color: #000099;
      text-decoration: underline;
    }

    .navbar-nav .nav-link.active {
      color: #000099;
      font-weight: 700;
      text-decoration: underline;
    }
  </style>