<style type="text/css">
  /* body {
    background: -webkit-linear-gradient(left, #3931af, #00c6ff);
} */

  .emp-profile {
    padding: 3%;
    margin-top: 3%;
    margin-bottom: 3%;
    border-radius: 0.5rem;
    background: #fff;
  }

  .profile-img {
    text-align: center;
  }

  .profile-img img {
    width: 70%;
    height: 100%;
  }

  .profile-img .file {
    position: relative;
    overflow: hidden;
    margin-top: -20%;
    width: 70%;
    border: none;
    border-radius: 0;
    font-size: 15px;
    background: #212529b8;
  }

  .profile-img .file input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
  }

  .profile-head h5 {
    color: #333;
  }

  .profile-head h6 {
    color: #dc3545;
  }

  .profile-edit-btn {
    border: none;
    border-radius: 1.5rem;
    width: 70%;
    padding: 2%;
    font-weight: 600;
    color: #6c757d;
    cursor: pointer;
  }

  .proile-rating {
    font-size: 12px;
    color: #818182;
    margin-top: 5%;
  }

  .proile-rating span {
    color: #495057;
    font-size: 15px;
    font-weight: 600;
  }

  .profile-head .nav-tabs {
    margin-bottom: 5%;
  }

  .profile-head .nav-tabs .nav-link {
    font-weight: 600;
    border: none;
  }

  .profile-head .nav-tabs .nav-link.active {
    border: none;
    border-bottom: 2px solid #dc3545;
  }

  .profile-work {
    padding: 14%;
    margin-top: -15%;
  }

  .profile-work p {
    font-size: 12px;
    color: #818182;
    font-weight: 600;
    margin-top: 10%;
  }

  .profile-work a {
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    font-size: 14px;
  }

  .profile-work ul {
    list-style: none;
  }

  .profile-tab label {
    font-weight: 600;
  }

  .profile-tab p {
    font-weight: 600;
    color: #dc3545;
  }
</style>
<div class="container emp-profile">
  <form method="post">
    <div class="row">
      <div class="col-md-4">

      </div>
      <div class="col-md-6">
        <div class="profile-head">
          <h5>
            <?= $user['username'] ?>
          </h5>
          <h6>
            Customer
          </h6>
          <p class="proile-rating">
            Status : <span
              class="badge badge-pill badge-success text-white">Active</span>
          </p>
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                aria-controls="home" aria-selected="true">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                aria-controls="profile" aria-selected="false">Riwayat</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-2">
        <a href="<?=site_url('profile/edit') ?>" class="profile-edit-btn">Edit Profile</a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <img src="<?=base_url('uploads/image/profile/avatar.png') ?>" class="img-thumbnail" alt="">
      </div>
      <div class="col-md-8">
        <div class="tab-content profile-tab" id="myTabContent">
          <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="row">
              <div class="col-md-6">
                <label>Username</label>
              </div>
              <div class="col-md-6">
                <p>
                  <?= $user['username'] ?>
                </p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <label>Email</label>
              </div>
              <div class="col-md-6">
                <p>
                  <?= $user['email'] ?>
                </p>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="row">
              <div class="col-md-10">
                <table class="table table-borderless ">
                  <?php foreach ($orders as $order) {
                    ?>
                    <tr>
                      <td><a
                        href="<?= base_url('myorder/').$order['id_transaction'] ?>">#<?= $order['id_transaction'] ?></a>
                      </td>
                      <td><?= $order['total_pay'] ?></td>
                      <td><?= date('d-m-Y', $order['created_at']) ?></td>
                      <?php if ($order['status'] == 'new'): ?>
                      <td>Belum Bayar</td>
                      <?php elseif ($order['status'] == 'pending') : ?>
                      <td>Menunggu Konfirmasi</td>
                      <?php elseif ($order['status'] == 'terima') : ?>
                      <td>Menunggu Pengiriman</td>
                      <?php elseif ($order['status'] == 'tolak') : ?>
                      <td>Pesanan Ditolak</td>
                      <?php elseif ($order['status'] == 'kirim') : ?>
                      <td>Dalam Pengiriman</td>
                      <?php elseif ($order['status'] == 'selesai') : ?>
                      <td>Telah diterima</td>
                      <?php endif; ?>
                    </tr>
                    <?php
                  } ?>

                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>