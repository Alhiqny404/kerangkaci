<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('dist/_partials/header');
?>
<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?=$title; ?></h1>
    </div>

    <div class="section-body">

      <a href="<?=site_url('sistem/backup/backup'); ?>" class="btn btn-danger">backup</a>

    </div>
  </section>
</div>



<?php $this->load->view('dist/_partials/footer'); ?>