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


  <footer class="footer text-center text-white py-3" style="background-color: #000099;">
    <h6 class="mb-3 fw-semibold">Find Us</h6>
    <div class="d-flex justify-content-center gap-4 my-3">
      <a href="#" class="social-link text-white" style="font-size: 1.5rem;">
        <i class="fab fa-linkedin"></i>
      </a>
      <a href="#" class="social-link text-white" style="font-size: 1.5rem;">
        <i class="fab fa-instagram"></i>
      </a>
      <a href="#" class="social-link text-white" style="font-size: 1.5rem;">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="#" class="social-link text-white" style="font-size: 1.5rem;">
        <i class="fab fa-twitter"></i>
      </a>
      <a href="#" class="social-link text-white" style="font-size: 1.5rem;">
        <i class="fab fa-youtube"></i>
      </a>
    </div>
    <small class="mt-3 d-block fw-semibold">Privacy Policy | About Andhika Group</small>
    <small class="mt-1 d-block fw-semibold">© 2026 Andhika Group. All rights reserved.</small>
  </footer>

  </body>

  </html>


  <script>
    $(document).ready(function () {
      $('#loginLoading').hide();
    });
  </script>