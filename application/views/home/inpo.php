<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Bootstrap-ecommerce by Vosidiy">
  <title>Anu Store - #<?=$invoice->id_transaction ?></title>
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
  <!-- jQuery -->
  <script src="<?= base_url('assets/') ?>js/jquery-2.0.0.min.js" type="text/javascript"></script>
  <!-- Bootstrap4 files-->
  <script src="<?= base_url('assets/') ?>js/bootstrap.bundle.min.js" type="text/javascript"></script>
  <link href="<?= base_url('assets/') ?>css/bootstrap.css" rel="stylesheet" type="text/css" />

  <!-- custom style -->
  <link href="<?= base_url('assets/') ?>css/ui.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/') ?>css/style.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/') ?>css/responsive.css" rel="stylesheet"
  media="only screen and (max-width: 1200px)" />

</head>

<body class="" style="background-color:#ffffff">
  <br />

  <div class="container bg-white ">
    <div class="content-body ">
      <section class="shadow-sm card">

        <div id="invoice-template" class="card-body">
          <div id="section-to-print">
            <!-- Invoice Company Details -->
            <div id="invoice-company-details" class="row">
              <div class="col-md-6 col-sm-12 text-center text-md-left">
                <div class="col-sm-12 text-center text-md-left">
                  <p class="text-muted">
                    Status
                  </p>
                </div>
                <div class="col-md-6 col-sm-12 text-center text-md-left">
                  <ul class="px-0 list-unstyled">
                    <?php if ($invoice->status == 'new'): ?>
                    <li class="font-weight-bold bg-danger text-center text-white">
                      BELUM DIBAYAR
                    </li>
                    <?php elseif ($invoice->status == 'pending'): ?>
                    <li class="font-weight-bold bg-warning text-center text-white">
                      MENUNGGU KONFIRMASI
                      <?php elseif ($invoice->status == 'terima'): ?>
                      <li class="font-weight-bold bg-warning text-center text-white">
                        MENUNGGU PENGIRIMAN
                        <?php elseif ($invoice->status == 'tolak'): ?>
                        <li class="font-weight-bold bg-danger text-center text-white">
                          PESANAN DITOLAK
                          <?php else : ?>
                          <li class="font-weight-bold bg-success text-center text-white">
                            <?=$invoice->status ?>
                          </li>
                          <?php endif ?>
                        </ul>
                      </div>

                    </div>
                    <div class="col-md-6 col-sm-12 text-center text-md-right">
                      <h2>INVOICE</h2>
                      <p class="pb-3">
                        #<?=$invoice->id_transaction ?>
                      </p>
                      <ul class="px-0 list-unstyled">
                        <li>Total Bayar</li>
                        <li class="lead text-bold-800"><?= $invoice->total_pay ?></li>
                      </ul>
                    </div>
                  </div>
                  <!--/ Invoice Company Details -->

                  <!-- Invoice Customer Details -->
                  <div id="invoice-customer-details" class="row pt-2">
                    <div class="col-sm-12 text-center text-md-left">
                      <p class="text-muted">
                        Penerima
                      </p>
                    </div>
                    <div class="col-md-6 col-sm-12 text-center text-md-left">
                      <ul class="px-0 list-unstyled">
                        <li class="text-bold-800">Nama : <?= json_decode($invoice->recipient_data)->customer->name ?></li>
                        <li>Alamat : <?=$address ?></li>
                        <li>Phone : <?=json_decode($invoice->recipient_data)->customer->phone ?></li>
                      </ul>
                    </div>
                    <div class="col-md-6 col-sm-12 text-center text-md-right">
                      <p>
                        <span class="text-muted">Invoice Date :</span>
                        <?= date('d/m/Y', $invoice->created_at) ?>
                      </p>
                    </div>
                  </div>
                  <!--/ Invoice Customer Details -->

                  <!-- Invoice Items Details -->
                  <div id="invoice-items-details" class="pt-2">
                    <div class="row">
                      <div class="table-responsive col-sm-12">
                        <table class="table table-sm">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Item &amp; Catatan</th>
                              <th class="text-right">Harga</th>
                              <th class="text-right">Jumlah</th>
                              <th class="text-right">Total Harga</th>
                            </tr>
                          </thead>

                          <tbody>
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
                                <td class="text-right"><?= $product->price_products ?></td>
                                <td class="text-right"><?=$product->qty ?></td>
                                <td class="text-right"><?= $product->total_price ?></td>
                              </tr>
                              <?php $i++; ?>
                              <?php
                            } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-7 col-sm-12 text-center text-md-left">
                        <p class="lead">
                          Payment Methods:
                        </p>
                        <div class="row">
                          <div class="col-md-8">
                            <table class="table table-borderless table-sm">
                              <tbody>
                                <tr>
                                  <td>Kurir:</td>
                                  <?php if ($invoice->kurir == "pos"): ?>
                                  <td class="">POS</td>
                                  <?php elseif ($invoice->kurir == "jne"): ?>
                                  <td class="">JNE</td>
                                  <?php endif ?>
                                </tr>
                                <tr>
                                  <td>Layanan:</td>
                                  <td class=""><?=$invoice->service ?></td>
                                </tr>
                                <tr>
                                  <td>Resi:</td>
                                  <td class=""><?=$invoice->resi ?></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-5 col-sm-12">
                        <p class="lead">
                          Total Harga
                        </p>
                        <div class="table-responsive">
                          <table class="table table-sm">
                            <tbody>
                              <tr>
                                <td>Sub Total</td>
                                <td class="text-right"><?= $invoice->pay ?></td>
                              </tr>
                              <tr>
                                <td>Ongkir</td>
                                <td class="text-right"><?= $invoice->postal_fee ?></td>
                              </tr>
                              <tr>
                                <td class="font-weight-bold">Total </td>
                                <td class="font-weight-bold text-right"><?= $invoice->total_pay ?>
                                </td>
                              </tr>

                            </tbody>
                          </table>
                        </div>

                      </div>
                    </div>
                  </div>

                </div>
                <div class="float-right">
                  <a href="<?= base_url() ?>">
                    <button type="button" id="home" class="btn btn-danger  my-1">Home</button>
                  </a>
                  <button type="button" id="cetak" onclick="cetak()" class="btn btn-success  my-1">Cetak
                  </button>

                  <script>
                    function cetak() {
                      document.getElementById("cetak").style.visibility = "hidden";
                      document.getElementById("home").style.visibility = "hidden";
                      window.print();
                      window.location.pathname.split('/')

                    }
                  </script>


                </div>
                <!-- Button trigger modal -->


                <!-- Modal -->
                <div class="modal fade" id="upload<?=$invoice->id_transaction ?>" tabindex="-1" role="dialog"
                  aria-labelledby="uploadTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="uploadTitle">Bukti Pembayaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <?php echo form_open_multipart(''); ?>
                      <?= form_hidden('id_user', $this->session->userdata('id_user')); ?>
                      <?= form_hidden('id_order', $invoice->id_transaction); ?>
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="accname">A/N</label>
                          <input type="text" name="acc_name" class="form-control" required id="accname"
                          placeholder="name@example.com">
                        </div>
                        <div class="form-group">
                          <label for="daribank">Dari Bank</label>
                          <select class="form-control" id="daribank" required name="code_bank">
                            <?php foreach ($banks as $bank) {
                              ?>
                              <option value="<?=$bank->code ?>"><?=$bank->name ?></option>
                              <?php
                            } ?>

                          </select>
                        </div>
                        <div class="form-group">
                          <label for="norek">No.Rek</label>
                          <input type="text" name="norek" class="form-control" required id="norek"
                          placeholder="Nama">
                        </div>
                        <div class="form-group">
                          <label for="banktujuan">Bank tujuan</label>
                          <select class="form-control" id="banktujuan" required name="dest_rek">
                            <option value="" disabled selected>Pilih Bank Tujuan</option>
                            <option value="BCA">BCA</option>
                            <option value="Mandiri">Mandiri</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <div class="align-self-center ">
                            <div class="custom-file">
                              <input type="file" class="custom-file-input" id="image" name="image">
                              <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                          </div>

                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="upload"
                          value="upload">Upload</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <!-- Invoice Footer -->
            <!-- <div id="invoice-footer">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <div class="row">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <div class="col-md-7 col-sm-12">

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <div class="col-md-5 col-sm-12 text-center">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <button type="button" class="btn btn-primary btn-lg my-1"><i
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      class="fa fa-paper-plane-o"></i> Send Invoice</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  </div> -->
            <!--/ Invoice Footer -->

            <!-- </div> -->
          </section>
        </div>
      </div>
      <style>
        .height {
          min-height: 200px;
        }

        .icon {
          font-size: 47px;
          color: #5CB85C;
        }

        .iconbig {
          font-size: 77px;
          color: #5CB85C;
        }

        .table>tbody>tr>.emptyrow {
          border-top: none;
        }

        .table>thead>tr>.emptyrow {
          border-bottom: none;
        }

        .table>tbody>tr>.highrow {
          border-top: 3px solid;
        }

        #invoice-template {
          padding: 4rem;
        }
      </style>
      <br /><br /><br />
    </body>
    <script>
      $('.custom-file-input').on('change', function() {
        //get the file name
        var fileName = $(this).val();
        //replace the "Choose a file" label
        $(this).next('.custom-file-label').html(fileName);
      })
    </script>

  </html>