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

              <form class="form" method="post" action="<?= site_url('profile/changepw/'); ?>">
                <div class="form-group">
                  <label for="passwordlama">Password Lama</label>
                  <input type="password" class="form-control" id="passwordlama" name="passwordlama">
                  <?= form_error('passwordlama', '  <small class="text-danger pl-3">', '</small>'); ?>
                  <?= $this->session->flashdata('!passwordlama'); ?>
                </div>
                <div class="form-group">
                  <label for="password1">Password Baru</label>
                  <input type="password" class="form-control" id="password1" name="password1">
                  <?= form_error('password1', '  <small class="text-danger pl-3">', '</small>'); ?>
                  <?= $this->session->flashdata('!password1'); ?>
                </div>

                <div class="form-group">
                  <label for="password2">Ulangi Password Baru</label>
                  <input type="password" class="form-control" id="password2" name="password2">
                  <?= form_error('password2', '  <small class="text-danger pl-3">', '</small>'); ?>
                  <?= $this->session->flashdata('!password2'); ?>
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

<?php $this->load->view('_layouts/js'); ?>



<?= $this->session->flashdata('success'); ?>