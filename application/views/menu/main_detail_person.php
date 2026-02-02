<?php $this->load->view('layout/header'); ?>
<?php $this->load->view('menu/submenu/header_detail_person'); ?>

<div id="contentArea" data-idperson="<?php echo $idperson; ?>">
    <?php $this->load->view($content); ?>
</div>

<?php $this->load->view('layout/footer'); ?>
