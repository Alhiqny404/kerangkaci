<h1 class="h3 mb-4 text-gray-800"><?=$title; ?></h1>


<div class="row">
  <div class="col-md-4">
    <!-- TABLE STRIPED -->
    <div class="panel">
      <div class="panel-heading" style="display: flex;justify-content: space-between;">
        <h3 class="panel-title"><?=$title; ?></h3>
        <a href="<?= site_url('profile'); ?>" class="add mb-4 btn btn-primary mt-3" style="background-color: #00aaff;padding:5px 10px">Kembali</a>
      </div>
      <div class="panel-body">
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
  <!-- END TABLE STRIPED -->
</div>
</div>


<div class="row">
<div class="col">

</div>

</div>