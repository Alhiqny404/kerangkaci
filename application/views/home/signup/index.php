<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Bootstrap-ecommerce by Vosidiy">
  <title>Daftar Akun Baru - AnuStore</title>
  <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
  <!-- jQuery -->

  <link href="<?= base_url('assets/frontend/') ?>css/bootstrap.css" rel="stylesheet" type="text/css" />
  <!-- Font awesome 5 -->
  <link href="<?= base_url('assets/frontend/') ?>fonts/fontawesome/css/fontawesome-all.min.css" type="text/css"
  rel="stylesheet">

  <link rel="stylesheet" href="<?= base_url('stisla/'); ?>assets/modules/izitoast/css/iziToast.min.css">
  <script src="<?= base_url('stisla/'); ?>assets/modules/izitoast/js/iziToast.min.js"></script>

  <!-- custom style -->
  <link href="<?= base_url('assets/frontend/') ?>css/ui.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/frontend/') ?>css/style.css" rel="stylesheet" type="text/css" />
  <link href="<?= base_url('assets/frontend/') ?>css/responsive.css" rel="stylesheet"
  media="only screen and (max-width: 1200px)" />
  <!-- custom javascript -->


</head>

<body>
  <div class="container mb-4">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <h1 class="text-center font-weight-bold text-danger"> <i class="fas fa-shopping-cart"></i> Anu Store
        </h1>
        <div class="text-center mb-2">
          Daftar akun baru sekarang
        </div>
        <div class="card shadow-sm">
          <header class="card-header">
            <a href="<?=site_url('login') ?>" class="float-right btn btn-outline-danger mt-1">Masuk</a>
            <h4 class="card-title mt-2">Daftar</h4>
          </header>
          <article class="card-body">
            <form id="form">
              <!-- Test -->
              <div class="form-group">
                <label for="username"> <span class="text-danger">* </span>Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="">
                <div class="invalid-feedback" in="username"></div>
              </div>
              <!-- form-row end.// -->
              <div class="form-group">
                <label><span class="text-danger">* </span>Email</label>
                <input type="email" name="email" class="form-control" placeholder="">
                <div class="invalid-feedback" in="email"></div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label><span class="text-danger">* </span>Password</label>
                  <input type="password" name="password" class="form-control" placeholder="">
                  <div class="invalid-feedback" in="password"></div>
                </div>
                <div class="form-group col-md-6">
                  <label><span class="text-danger">* </span>Konfirmasi Password</label>
                  <input type="password" name="password_confirm" class="form-control" placeholder="">
                  <div class="invalid-feedback" in="password_confirm"></div>
                </div>
              </div>

              <!-- form-group end.// -->
              <div class="form-group">
                <button type="button" id="btnSubmit" class="btn btn-danger btn-block" onclick="register()"> Register </button>
              </div>
              <!-- form-group// -->
              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                  <label class="custom-control-label" for="agree">By clicking the 'Sign Up' button, you confirm that you accept our
                    <br> Terms of use and Privacy Policy.</label>
                </div>
              </div>
            </form>
          </article>
          <!-- card-body end .// -->
          <div class="border-top card-body text-center">
            Have an account? <a href="<?=site_url() ?>">Log In</a>
          </div>
        </div>
      </div>
      <div class="col-md-3"></div>
      <!-- card.// -->
    </div>
  </div>
  <!-- General JS Scripts -->
  <script src="<?= base_url('stisla/'); ?>assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <!-- Bootstrap4 files-->
  <script src="<?= base_url('stisla/'); ?>assets/modules/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#btnSubmit').prop('disabled', true);
    });

    $('#agree').change(function() {
      if (this.checked == false) {
        $('#btnSubmit').prop('disabled', true);
      } else {
        $('#btnSubmit').prop('disabled', false);
      }


    });

    function register() {
      let form = $('#form').serialize();
      console.log(form);
      let url = "<?=site_url('register/validate') ?>";
      $('#btnSubmit').prop('disabled',
        true);
      $('#btnSubmit').html('Proses..');

      $.ajax({
        url: url,
        type: "POST",
        data: form,
        dataType: "JSON",
        success: function(data) {
          $('#btnSubmit').prop('disabled',
            false);
          $('#btnSubmit').html('Register');
          if (data.status == false) {
            if (data.err.username == "") {
              $('[name="username"]').removeClass('is-invalid');
              $('[in="username"]').html();
            } else {
              $('[name="username"]').addClass('is-invalid');
              $('[in="username"]').html(data.err.username);
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
            if (data.err.password_confirm == "") {
              $('[name="password_confirm"]').removeClass('is-invalid');
              $('[in="password_confirm"]').html();
            } else {
              $('[name="password_confirm"]').addClass('is-invalid');
              $('[in="password_confirm"]').html(data.err.password_confirm);
            }
          } else {
            // MEMBERSIHKAN FORM
            $('input').removeClass('is-invalid');
            $('input').val('');
            $('textarea').val('');
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