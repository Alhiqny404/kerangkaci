<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?=$title; ?></h1>
      <?php $this->load->view('_layouts/breadcrumb') ?>
    </div>

    <div class="section-body">

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">

              <a href="<?= site_url('profile'); ?>" class="add mb-4 btn btn-primary mt-3" style="background-color: #00aaff;padding:5px 10px">Kembali</a>
            </div>
            <div class="card-body">

              <?//= form_open_multipart('profile/update'); ?>
              <form id="form">
                <div class="form-group">
                  <label for="email">Alamat Email</label>
                  <input type="email" class="form-control" id="email" name="email" readonly value="<?= $user['email']; ?>">
                </div>
                <div class="form-group">
                  <label for="nama">Nama Panggilan</label>
                  <input type="text" class="form-control" id="nama" name="nama" value="<?= $user['nama']; ?>">
                  <div class="invalid-feedback" in="nama"></div>
                </div>
                <div class="form-group">
                  <label for="avatar">Foto Profile</label>
                  <input type="file" class="form-control" id="avatar" name="avatar">
                </div>
                <button type="button" onclick="save()" class="btn btn-primary">Submit</button>
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
  function save() {
    var form = $('#form')[0];
    var data = new FormData(form);

    let nama = $('#nama').val();
    let avatar = $('#avatar').val();
    let email = $('#email').val();
    $.ajax({
      enctype: "multipart/form-data",
      url: "<?= site_url('profile/update') ?>",
      type: "post",
      dataType: "JSON",
      data: data,
      contentType: false,
      cache: false,
      processData: false,
      success: function(data) {
        if (data.status == false) {
          $('[name="nama"]').addClass('is-invalid');
          $('[in="nama"]').html(data.err.nama);
        } else {
          $('[name="nama"]').removeClass('is-invalid');
          $('[in="nama"]').html();
          console.log('success');
        }
      }
    });
  }


</script>