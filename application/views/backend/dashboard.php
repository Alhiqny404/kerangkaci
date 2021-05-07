<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?=$title; ?></h1>
      <?php $this->load->view('_layouts/breadcrumb') ?>
    </div>
    <div class="section-body">

      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
              <i class="fas fa-box"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>produk</h4>
              </div>
              <div class="card-body">
                <?=$product ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
              <i class="far fa-user"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Pelanggan</h4>
              </div>
              <div class="card-body">
                <?=$pelanggan ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">

        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
              <i class="fas fa-cart-arrow-down"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Pesanan Baru</h4>
              </div>
              <div class="card-body">
                <?=$pesanan ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-success">
              <i class="fas fa-hand-holding-usd"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>Pendapatan</h4>
              </div>
              <div class="card-body">
                Rp. 1000.000
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>


<?php $this->load->view('_layouts/js.php'); ?>