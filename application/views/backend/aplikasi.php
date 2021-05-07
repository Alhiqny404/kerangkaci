<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?=$title; ?></h1>
      <?php $this->load->view('_layouts/breadcrumb'); ?>
    </div>

    <div class="section-body">


      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form id="form">
                <div class="form-group row">
                  <label for="name_app" class="col-sm-2 col-form-label">Nama Aplikasi</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="name_app" name="name_app" required>
                    <div class="invalid-feedback" in="name_app"></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="color_navbar" class="col-sm-2 col-form-label">Warna Navbar</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="color_navbar" name="color_navbar" required>
                    <div class="invalid-feedback" in="color_navbar"></div>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="color_sidebar" class="col-sm-2 col-form-label">Warna Sidebar</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="color_sidebar" name="color_sidebar" required>
                    <div class="invalid-feedback" in="color_sidebar"></div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-10">
                    <button type="button" id="btnsave" class="btn btn-primary" onclick="save()">Simpan</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>



<?php $this->load->view('_layouts/js'); ?>


<script>
  $(document).ready(function() {
    $.ajax({
      url: "<?= site_url('crud-backend/aplikasi/ajax') ?>",
      type: 'post',
      dataType: "JSON",
      cache: false,
      success: function(data) {
        $('#name_app').val(data[0].name_app);
        $('#color_navbar').val(data[0].color_navbar);
        $('#color_sidebar').val(data[0].color_sidebar);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
      }
    });
  });


  function save() {
    $.ajax({
      url: "<?= site_url('crud-backend/aplikasi/update'); ?>",
      type: "post",
      data: $('#form').serialize(),
      dataType: "JSON",
      cache: false,
      success: function(data) {
        if (data.status == false) {
          console.log(data.err);
          if (!data.err.name_app == "") {
            $('[name="name_app"]').addClass('is-invalid');
            $('[in="name_app"]').html(data.err.name_app);
          } else {
            $('[name="name_app"]').removeClass('is-invalid');
            $('[in="name_app"]').html();
          }
          if (!data.err.color_navbar == "") {
            $('[name="color_navbar"]').addClass('is-invalid');
            $('[in="color_navbar"]').html(data.err.color_navbar);
          } else {
            $('[name="color_navbar"]').removeClass('is-invalid');
            $('[in="color_navbar"]').html();
          }
          if (!data.err.color_sidebar == "") {
            $('[name="color_sidebar"]').addClass('is-invalid');
            $('[in="color_sidebar"]').html(data.err.color_sidebar);
          } else {
            $('[name="color_sidebar"]').removeClass('is-invalid');
            $('[in="color_sidebar"]').html();
          }
        } else
        {

          $('.form-control').removeClass('is-invalid');
          $('.invalid-feedback').empty();

          iziToast.success({
            title: 'UPDATE!',
            message: 'pengaturan telah diubah',
            position: 'topRight'
          });
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
      }
    });

  }

</script>