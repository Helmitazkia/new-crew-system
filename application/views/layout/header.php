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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">


</head>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body>

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
    </svg>

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
                    <a class="nav-link <?php echo ($active_menu == 'dashboard') ? 'active' : '' ?>" href="#">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item dropdown fst-italic fw-semibold" style="position: relative;">

                    <a class="nav-link dropdown-toggle <?php echo ($active_menu == 'master_data') ? 'active' : '' ?>"
                        href="#" id="masterDataDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                        style="transition: color .2s ease;">
                        Master Data
                    </a>

                    <ul class="dropdown-menu shadow-lg" aria-labelledby="masterDataDropdown" style="
                        min-width:260px;
                        padding:12px 10px;
                        border-radius:12px;
                        border:none;
                        animation: dropdownFade .2s ease-in-out;
                      ">

                        <li
                            style="font-size:11px;letter-spacing:.6px;text-transform:uppercase;color:#6c757d;padding:6px 12px;">
                            General Master
                        </li>

                        <li>
                            <a class="dropdown-item" href="<?php echo base_url('certificate') ?>"
                                style="border-radius:8px;padding:8px 12px;font-size:14px;">
                                Certificate
                            </a>
                        </li>


                        <li><a class="dropdown-item <?php echo ($active_menu == 'master_city') ? 'active' : '' ?>"
                                style="
                                border-radius:8px;padding:8px 12px;font-size:14px;"
                                href="<?php echo base_url('city') ?>">City</a>
                        </li>
                        <li><a class="dropdown-item <?php echo ($active_menu == 'master_country') ? 'active' : '' ?>"
                                style=" border-radius:8px;padding:8px 12px;font-size:14px;"
                                href="<?php echo base_url('country') ?>">Country</a></li>

                        <li><a class="dropdown-item <?php echo ($active_menu == 'master_company') ? 'active' : '' ?>"
                                style=" border-radius:8px;padding:8px 12px;font-size:14px;"
                                href="<?php echo base_url('company') ?>">Company</a></li>

                        <li><a class="dropdown-item <?php echo ($active_menu == 'master_rank') ? 'active' : '' ?>"
                                style="border-radius:8px;padding:8px 12px;font-size:14px;"
                                href="<?php echo base_url('rank') ?>">Rank</a>
                        </li>
                        <li><a class="dropdown-item <?php echo ($active_menu == 'master_vessel') ? 'active' : '' ?>"
                                style="border-radius:8px;padding:8px 12px;font-size:14px;"
                                href="<?php echo base_url('vessel') ?>">Vessel</a></li>

                        <li><a class="dropdown-item <?php echo ($active_menu == 'master_vessel_type') ? 'active' : '' ?>"
                                style="border-radius:8px;padding:8px 12px;font-size:14px;"
                                href="<?php echo base_url('vesselType') ?>">Vessel
                                Type</a></li>

                        <li><a class="dropdown-item <?php echo ($active_menu == 'master_school') ? 'active' : '' ?>"
                                style="border-radius:8px;padding:8px 12px;font-size:14px;"
                                href="<?php echo base_url('school') ?>">School
                                Name</a></li>

                        <li>
                            <hr style="margin:8px 0;">
                        </li>

                        <li
                            style="font-size:11px;letter-spacing:.6px;text-transform:uppercase;color:#6c757d;padding:6px 12px;">
                            System & User
                        </li>

                        <li><a class="dropdown-item" style="border-radius:8px;padding:8px 12px;font-size:14px;">Open
                                Recruitment</a></li>
                        <li><a class="dropdown-item" style="border-radius:8px;padding:8px 12px;font-size:14px;">User
                                Crew</a></li>
                        <li><a class="dropdown-item" style="border-radius:8px;padding:8px 12px;font-size:14px;">User
                                System</a></li>
                        <li><a class="dropdown-item fw-semibold"
                                style="border-radius:8px;padding:8px 12px;font-size:14px;color:#067780;">
                                Certificate Matrix
                            </a></li>

                    </ul>
                </li>


                <li class="nav-item fst-italic fw-semibold">
                    <a class="nav-link <?php echo ($active_menu == 'crew_roster') ? 'active' : '' ?>" href="#">
                        Crew Lifecycle
                    </a>
                </li>

                <li class="nav-item fst-italic fw-semibold">
                    <a class="nav-link <?php echo ($active_menu == 'recruitment') ? 'active' : '' ?>" href="#">
                        Recruitment
                    </a>
                </li>

                <li class="nav-item fst-italic fw-semibold">
                    <a class="nav-link <?php echo ($active_menu == 'training') ? 'active' : '' ?>" href="#">
                        Training & Evaluation
                    </a>
                </li>

                <li class="nav-item fst-italic fw-semibold">
                    <a class="nav-link <?php echo ($active_menu == 'report') ? 'active' : '' ?>" href="#">
                        Report
                    </a>
                </li>

            </ul>



            <?php if($this->session->userdata('isLogin')): ?>
            <div class="dropdown position-relative">

                <div class="user-profile d-flex align-items-center cursor-pointer" id="profileDropdown"
                    style="cursor: pointer;" data-bs-toggle="dropdown" aria-expanded="false">

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
                        <div class="avatar-circle bg-primary text-white d-inline-flex align-items-center justify-content-center mb-2"
                            style="width: 60px; height: 60px; border-radius: 50%; font-size: 1.5rem; font-weight: bold;">
                            <?php echo substr($fullname, 0, 1); ?>
                        </div>
                        <h6 class="mb-1"><?php echo $this->session->userdata('userFullNm'); ?></h6>
                        <small class="text-muted"><?php echo $this->session->userdata('userType'); ?></small>
                    </div>

                    <!-- Menu Items -->
                    <div class="p-2">
                        <!-- Profile -->
                        <a href="<?php echo base_url('profile'); ?>"
                            class="dropdown-item d-flex align-items-center py-2">
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
                        <button type="button" class="dropdown-item d-flex align-items-center py-2 text-danger"
                            id="btnLogout">
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
    $(document).ready(function() {



        $(document).on('click', '#btnLogout', function(e) {
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
                beforeSend: function() {
                    // Update button state
                    $('#btnLogout').html(
                        '<i class="fas fa-spinner fa-spin me-2"></i>Logging out...');
                    $('#btnLogout').prop('disabled', true);
                },
                success: function(response) {
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
                                window.location.href =
                                    '<?php echo base_url("auth/login"); ?>';
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
                error: function(xhr, status, error) {
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

        $(document).keydown(function(e) {
            if (e.ctrlKey && e.key === 'l') {
                e.preventDefault();
                $('#btnLogout').click();
            }
        });

    });

    document.querySelectorAll('.dropdown-menu .dropdown-item').forEach(item => {

        item.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'rgba(10, 88, 202, 0.12)'; // soft blue
            this.style.color = '#0a58ca';
            this.style.transform = 'translateX(4px)';
        });

        item.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
            this.style.color = '';
            this.style.transform = '';
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