<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?=$title; ?></h1>
      <?php $this->load->view('_layouts/breadcrumb') ?>
    </div>

    <div class="section-body">
      <div class="invoice">
        <div class="invoice-print">
          <div class="row">
            <div class="col-lg-12">
              <div class="invoice-title">
                <h2>Invoice</h2>
                <div class="invoice-number">
                  Order #<?=$invoice->id_transaction ?>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6 text-md-right">
                  <address>
                    <strong>Penerima:</strong><br>
                    <?= json_decode($invoice->recipient_data)->customer->name ?><br>
                    <?=json_decode($invoice->recipient_data)->customer->phone ?><br>
                    <?=$address ?>
                  </address>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6 text-md-right">
                  <address>
                    <strong>Order Date:</strong><br>
                    <?= date('d/m/Y', $invoice->created_at) ?><br><br>
                  </address>
                </div>
              </div>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-md-12">
              <div class="section-title">
                Order Summary
              </div>
              <p class="section-lead">
                All items here cannot be deleted.
              </p>
              <div class="table-responsive">
                <table class="table table-striped table-hover table-md">

                  <tr>
                    <th data-width="40">#</th>
                    <th>Item</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-right">Totals</th>
                  </tr>

                  <?php $i = 1; ?>
                  <?php foreach ($products as $product) {
                    ?>
                    <tr>
                      <th scope="row"><?=$i; ?></th>
                      <td>
                        <p>
                          <?=$product->name_products ?>
                        </p>
                        <p class="text-muted">
                          <?=$product->note ?>
                        </p>
                      </td>
                      <td class="text-center"><?= $product->price_products ?></td>
                      <td class="text-center"><?=$product->qty ?></td>
                      <td class="text-right"><?= $product->total_price ?></td>
                    </tr>
                    <?php $i++; ?>
                    <?php
                  } ?>
                </table>
              </div>
              <div class="row mt-4">
                <div class="col-lg-8">
                  <div class="section-title">
                    Payment Method
                  </div>
                  <p class="section-lead">
                    The payment method that we provide is to make it easier for you to pay invoices.
                  </p>
                  <div class="images">
                    <img src="<?php echo base_url('stisla/'); ?>assets/img/visa.png" alt="visa">
                    <img src="<?php echo base_url('stisla/'); ?>assets/img/jcb.png" alt="jcb">
                    <img src="<?php echo base_url('stisla/'); ?>assets/img/mastercard.png" alt="mastercard">
                    <img src="<?php echo base_url('stisla/'); ?>assets/img/paypal.png" alt="paypal">
                  </div>
                </div>
                <div class="col-lg-4 text-right">
                  <div class="invoice-detail-item">
                    <div class="invoice-detail-name">
                      Subtotal
                    </div>
                    <div class="invoice-detail-value">
                      <?= $invoice->pay ?>
                    </div>
                  </div>
                  <div class="invoice-detail-item">
                    <div class="invoice-detail-name">
                      Shipping
                    </div>
                    <div class="invoice-detail-value">
                      <?= $invoice->postal_fee ?>
                    </div>
                  </div>
                  <hr class="mt-2 mb-2">
                  <div class="invoice-detail-item">
                    <div class="invoice-detail-name">
                      Total
                    </div>
                    <div class="invoice-detail-value invoice-detail-value-lg">
                      <?= $invoice->total_pay ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr>
        <div class="text-md-right">
          <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
        </div>
      </div>
    </div>
  </section>
</div>


<?php $this->load->view('_layouts/js.php'); ?>