<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="icon" href="<?php echo base_url("assets/img/andhika.gif"); ?>">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/auth-css/login.css">

</head>


<body>

  <div class="container-fluid">
    <div class="row login-wrapper">
      <div class="col-lg-6 d-flex align-items-center justify-content-center">
        <div class="login-card w-100">
          <div class="text-center mb-4">
            <img src="<?php echo base_url('assets/img/banner/andhika.png'); ?>" height="200" alt="Andhika Group">
          </div>
          <h2 class="fw-bold">Welcome back!</h2>
          <p class="text-muted mb-4">Login to access all your data</p>

          <form id="formLogin">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="user" id="user" class="form-control form-control-lg"
                placeholder="Enter your email address">
            </div>

            <div class="mb-1">
              <label class="form-label">Password</label>
              <div class="input-group">
                <input type="password" name="pass" id="pass" class="form-control form-control-lg"
                  placeholder="Enter your password">
                <span class="input-group-text bg-white" id="togglePassword">👁</span>
              </div>
            </div>

            <!-- ERROR MESSAGE -->
            <small id="loginError" class="text-danger d-none">
              Email atau password salah
            </small>

            <button type="submit" id="btnLogin" class="btn btn-login w-100 mt-3">
              Login
            </button>


            <div class="divider">
              <span>Continue with</span>
            </div>

            <button type="button" class="btn btn-outline-secondary w-100 mb-3">
              <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="18" class="me-2">
              Login with Google
            </button>

            <button type="button" class="btn btn-outline-secondary w-100">
              <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" width="18" class="me-2">
              Login with Facebook
            </button>

            <p class="text-center mt-4">
              Don’t have an account?
              <a href="#" class="text-decoration-none fw-semibold">Register</a>
            </p>
          </form>

        </div>
      </div>

      <!-- RIGHT -->
      <div class="col-lg-6 d-none d-lg-block login-image p-0">
        <img src="<?php echo base_url('assets/img/banner/andhika-lines.png'); ?>" alt="Andhika Lines">
      </div>

    </div>
  </div>

  <!-- LOADING -->
  <div id="loginLoading" class="text-center mt-3">
    <img src="<?php echo base_url('assets/img/loading-new.gif'); ?>" width="60" alt="Loading">
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</body>

</html>

<style>
  #loginLoading {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
  }
</style>

<script>
  $(document).ready(function () {

    $('#togglePassword').on('click', function () {

      var input = $('#pass');
      var type = input.attr('type');

      if (type === 'password') {
        input.attr('type', 'text');
        $(this).text('🙈'); // icon berubah
      } else {
        input.attr('type', 'password');
        $(this).text('👁');
      }

    });


    $('#loginLoading').hide();


    $('#formLogin').on('submit', function (e) {
      e.preventDefault();

      var user = $('#user').val().trim();
      var pass = $('#pass').val().trim();

      $('#loginError').addClass('d-none').text('');

      // VALIDASI
      if (user === '' || pass === '') {
        $('#loginError')
          .removeClass('d-none')
          .text('Email dan password wajib diisi');
        return;
      }

      // SHOW LOADING
      $('#loginLoading').show();

      $('#btnLogin').prop('disabled', true).text('Loading...');

      $.ajax({
        url: "<?php echo base_url('auth/login/do_login'); ?>",
        type: "POST",
        dataType: "json",
        data: {
          user: user,
          pass: pass
        },
        success: function (res) {

          if (res.status == true) {
            console.log("Login berhasil", res);

            // // REDIRECT KE DASHBOARD
            window.location.href = "<?php echo base_url('Roster/getCrewRoster'); ?>";
            setTimeout(function () {
              $('#loginLoading').hide();
            }, 5000); // 5000ms = 5 detik

          } else {
            $('#loginError')
              .removeClass('d-none')
              .text(res.msg);
          }

        },
        error: function () {
          $('#loginError')
            .removeClass('d-none')
            .text('Terjadi kesalahan sistem');
        },
        complete: function () {
          // HIDE LOADING
          $('#loginLoading').hide();
          $('#btnLogin').prop('disabled', false).text('Login');
        }
      });

    });

  });
</script>