<?php $this->load->view('dist/_partials/header'); ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1><?=$title; ?></h1>
    </div>

    <div class="section-body">

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">

              <a href="<?= site_url('profile'); ?>" class="add mb-4 btn btn-primary mt-3" style="background-color: #00aaff;padding:5px 10px">Kembali</a>
            </div>
            <div class="card-body">

              <?= form_open_multipart('profile/update'); ?>
              <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" class="form-control" id="email" name="email" readonly value="<?= $user['email']; ?>">
              </div>
              <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= $user['nama']; ?>">
              </div>
              <div class="form-group">
                <label for="avatar">Foto Profile</label>
                <input type="file" class="form-control-file" id="avatar" name="avatar">
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
</div>

<?php $this->load->view('dist/_partials/footer'); ?>