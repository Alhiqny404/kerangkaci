<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?=$title; ?></h1>
      <?php $this->load->view('_layouts/breadcrumb') ?>

    </div>

    <div class="section-body">

      <div class="section-body">

        <div class="row">

          <?php foreach ($submenu as $s) : ?>
          <div class="col-lg-6">
            <div class="card card-large-icons">
              <div class="card-icon bg-primary text-white">
                <i class="<?=$s['icon']; ?>"></i>
              </div>
              <div class="card-body">
                <h4><?=$s['title']; ?></h4>
                <a href="<?=$s['url']; ?>" class="card-cta">Kunjungi <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>


    </div>
  </section>
</div>


<?php $this->load->view('_layouts/js.php'); ?>