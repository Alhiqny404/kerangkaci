<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?=$title; ?></h1>
      <?php $this->load->view('_layouts/breadcrumb') ?>
    </div>
    <div class="section-body">

      <div class="row">
        <div class="col-lg-5 col-md-5 col-sm-5 col-12">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title">
                Detail Produk
              </h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col">
                  <img src="<?=base_url('uploads/image/product/'.$product->image_products); ?>" alt="gambar<?=$product->name_products ?>" class="img-thumbnail" />
                </div>
              </div>
              <div class="row mt-3">
                <table border="0" class="table">
                  <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <th><?=$product->name_products ?></th>
                  </tr>
                  <tr>
                    <td>SKU</td>
                    <td>:</td>
                    <th><?=$product->code_products ?></th>
                  </tr>
                  <tr>
                    <td>Harga</td>
                    <td>:</td>
                    <th><?=$product->price_products ?></th>
                  </tr>
                  <tr>
                    <td>Diskon</td>
                    <td>:</td>
                    <th><?=$product->discount_products ?>%</th>
                  </tr>
                  <tr>
                    <td>stok</td>
                    <td>:</td>
                    <th><?=$product->stock_products ?></th>
                  </tr>
                  <tr>
                    <td>Berat</td>
                    <td>:</td>
                    <th><?=$product->weight_products ?> gram</th>
                  </tr>
                </table>

              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-7 col-md-7 col-sm-7 col-12">
          <div class="card">
            <div class="card-body">
              <div class="card-header">
                <h4 class="card-title">
                  Penjualan Terbaru
                </h4>
              </div>
              <table class="table table-sm">
                <thead>
                  <tr>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Total Harga</th>
                    <th>Ulasam</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>


<?php $this->load->view('_layouts/js.php'); ?>