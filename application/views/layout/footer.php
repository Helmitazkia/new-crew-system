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

  <!-- <div id="idSuccess" class="text-center mt-3" style="background-color: transparent;">
    <img src="<?php echo base_url('assets/img/sama.gif'); ?>" width="30%" alt="Loading" style="background-color: transparent;">
</div> -->

  <style>
#idSuccess {
    position: fixed;
    top: 70%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
}
  </style>


  <footer class="footer text-center text-white py-3" style="background-color: #000099;">

      <small class="mt-3 d-block fw-semibold">Privacy Policy | About Andhika Group</small>
      <small class="mt-1 d-block fw-semibold">© 2026 Andhika Group. All rights reserved.</small>
  </footer>

  </body>

  </html>


  <script>
$(document).ready(function() {
    $('#loginLoading').hide();
    // $('#idSuccess').hide();
});
  </script>