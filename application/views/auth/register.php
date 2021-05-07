<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>

  <link rel="stylesheet" href="<?= base_url('stisla/'); ?>assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url('stisla/'); ?>assets/modules/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('stisla/'); ?>assets/modules/bootstrap-social/bootstrap-social.css">
  <link rel="stylesheet" href="<?= base_url('stisla/'); ?>assets/css/style.css">


  <link rel="stylesheet" href="<?= base_url('stisla/'); ?>assets/modules/izitoast/css/iziToast.min.css">
  <script src="<?= base_url('stisla/'); ?>assets/modules/izitoast/js/iziToast.min.js"></script>

  <!-- Start GA -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>

  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
  </script>
  <script src="<?= base_url('stisla/'); ?>assets/modules/jquery.min.js"></script>
</head>
<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <!-- <div class="login-brand">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <img src="<?php echo base_url(); ?>assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div> -->

            <div class="card card-primary">
              <div class="card-header">
                <h4>Register</h4>
              </div>

              <div class="card-body">
                <form id="form">
                  <div class="form-group">
                    <label for="nama">Nama Panggilan</label>
                    <input id="nama" type="text" class="form-control" name="nama">
                    <div class="invalid-feedback" in="nama"></div>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="text" class="form-control" name="email">
                    <div class="invalid-feedback" in="email"></div>
                  </div>
                  <div class="row">
                    <div class="form-group col-6">
                      <label for="password" class="d-block">Password</label>
                      <input id="password" type="password" class="form-control pwstrength" name="password">
                      <div class="invalid-feedback" in="password"></div>
                    </div>
                    <div class="form-group col-6">
                      <label for="password2" class="d-block">Password Confirmation</label>
                      <input id="password2" type="password" class="form-control" name="password2">
                      <div class="invalid-feedback" in="password2"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                      <label class="custom-control-label" for="agree">I agree with the terms and conditions</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="button" class="btn btn-lg btn-block" disabled id="btnSubmit" onclick="register()">
                      Register
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; Abror <?=date('Y') ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <script src="<?= base_url('stisla/'); ?>assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?= base_url('stisla/'); ?>assets/js/stisla.js"></script>
  <script src="<?= base_url('stisla/'); ?>assets/js/scripts.js"></script>
  <script src="<?= base_url('stisla/'); ?>assets/js/custom.js"></script>

  <script>
    $(document).ready(function() {
      $('#btnSubmit').addClass('btn-secondary');
    });

    $('#agree').change(function() {
      if (this.checked == false) {
        $('#btnSubmit').addClass('btn-secondary');
        $('#btnSubmit').removeClass('btn-primary');
        $('#btnSubmit').prop('disabled', true);
      } else {
        $('#btnSubmit').removeClass('btn-secondary');
        $('#btnSubmit').addClass('btn-primary');
        $('#btnSubmit').removeAttr('disabled');
      }


    });

    function register() {
      let form = $('#form').serialize();
      let url = "<?=site_url('register/validate') ?>";

      $.ajax({
        url: url,
        type: "POST",
        data: form,
        dataType: "JSON",
        success: function(data) {
          console.log(data)
          if (data.status == false) {
            if (data.err.nama == "") {
              $('[name="nama"]').removeClass('is-invalid');
              $('[in="nama"]').html();
            } else {
              $('[name="nama"]').addClass('is-invalid');
              $('[in="nama"]').html(data.err.nama);
            }
            if (data.err.email == "") {
              $('[name="email"]').removeClass('is-invalid');
              $('[in="email"]').html();
            } else {
              $('[name="email"]').addClass('is-invalid');
              $('[in="email"]').html(data.err.email);
            }
            if (data.err.password == "") {
              $('[name="password"]').removeClass('is-invalid');
              $('[in="password"]').html();
            } else {
              $('[name="password"]').addClass('is-invalid');
              $('[in="password"]').html(data.err.password);
            }
            if (data.err.password2 == "") {
              $('[name="password2"]').removeClass('is-invalid');
              $('[in="password2"]').html();
            } else {
              $('[name="password2"]').addClass('is-invalid');
              $('[in="password2"]').html(data.err.password2);
            }
          } else {
            // MEMBERSIHKAN FORM
            $('input').removeClass('is-invalid');
            $('input').val('');
            $('.invalid-feedback').html();


            iziToast.success({
              title: 'BERHASIL!',
              message: 'pendaftaran berhasil, Periksa Email untuk mengaktifkan',
              position: 'topRight'
            });
          }
        },
        error: function() {}
      });

    }
  </script>
</body>
</html>