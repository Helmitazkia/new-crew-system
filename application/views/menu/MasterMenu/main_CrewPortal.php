<body style="margin:0; display:flex; flex-direction:column; min-height:100vh;">

    <!-- NAVBAR -->

    <div id="contentArea" style="flex:1;">
        <?php $this->load->view($content); ?>
    </div>

    <?php $this->load->view('layout/footer'); ?>

</body>