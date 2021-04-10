<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?=$title; ?></h1>
      <?php $this->load->view('_layouts/breadcrumb'); ?>
    </div>

    <div class="section-body">

      <a href="<?=site_url('sistem/backup/backup'); ?>" class="btn btn-danger">backup</a>

    </div>
  </section>
</div>



<?php $this->load->view('_layouts/js'); ?>