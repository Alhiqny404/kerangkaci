<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message') ?>"></div>
<nav class="navbar navbar-dark navbar-expand-sm p-0 bg-danger ">
  <div class="container ">
    <a class="navbar-brand pl-2" href="<?= base_url() ?>">
      <span class="text-white font-weight-bold">Coffee Store</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTop"
      aria-controls="navbarTop" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse " id="navbarTop">
      <ul class="navbar-nav ml-auto">
      </ul>
      <!-- navbar-nav.// -->
    </div>
    <!-- collapse.// -->
  </div>
</nav>
<section class="header-main shadow-sm">
  <div class="container">
    <div class="row-sm align-items-center">
      <div class="col-lg-4-24 col-sm-3">
        <div class="category-wrap dropdown py-1">
          <button type="button" class="btn btn-light  dropdown-toggle" data-toggle="dropdown"><i
            class="fa fa-bars"></i> Kategori</button>
          <div class="dropdown-menu">
            <?php foreach (categories() as $category): ?>
            <a class="dropdown-item" href="<?=site_url("category/{$category->slug_categories}"); ?>"><?=$category->slug_categories; ?></a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <div class="col-lg-11-24 col-sm-8">
        <form action="" method="post" class="py-1">
          <div class="input-group w-100">
            <input type="text" class="form-control" value="" name="cari" style="width:50%;"
            placeholder="Search">
            <div class="input-group-append">
              <button class="btn btn-danger" type="submit">
                <i class="fa fa-search"></i> Cari
              </button>
            </div>
          </div>
        </form>
        <!-- search-wrap .end// -->
      </div>
      <!-- col.// -->
      <div class="col-lg-9-24 col-sm-12">
        <div class="widgets-wrap float-right row no-gutters py-1">
          <?php if ($this->session->userdata('email')): ?>
          <div class="col-auto">
            <div class="widget-header dropdown">
              <a href="#" data-toggle="dropdown" data-offset="20,10">
                <div class="icontext">
                  <div class="icon-wrap">
                    <i class="text-danger icon-sm fa fa-user"></i>
                  </div>
                  <div class="text-wrap text-dark">
                    Akun
                    <i class="fa fa-caret-down"></i>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu">
                <div class="pl-1">
                  <a class="dropdown-item" href="<?=site_url('profile') ?>">
                    <div class="text-danger font-weight-light">
                      Profil
                    </div>
                  </a>
                  <a class="dropdown-item" href="<?=site_url('myorder') ?>">
                    <div class="text-danger font-weight-light">
                      Pesanan saya
                    </div>
                  </a>
                </div>
                <hr class="dropdown-divider">
                <a class="dropdown-item" href="<?=site_url('logout') ?>"><span class="text-danger">
                  Keluar
                </span></a>
              </div>
              <!--  dropdown-menu .// -->
            </div>
            <!-- widget-header .// -->
          </div>
          <?php else : ?>
          <div class="col-auto">
            <div class="widget-header dropdown">
              <a href="#" data-toggle="dropdown" data-offset="20,10">
                <div class="icontext">
                  <div class="icon-wrap">
                    <i class="text-danger icon-sm fa fa-user"></i>
                  </div>
                  <div class="text-wrap text-dark">
                    Masuk <i class="fa fa-caret-down"></i>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu">
                <form class="px-4 py-3" id="form">
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email">
                    <div class="invalid-feedback" in="email"></div>
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control">
                    <div class="invalid-feedback" in="password"></div>
                  </div>
                  <button type="button" class="btn btn-primary" id="btnlogin">Masuk</button>
                </form>
                <hr class="dropdown-divider">
                <a class="dropdown-item" href="<?=base_url('register') ?>"><span class="text-danger">Tidak
                  punya akun?
                  Daftar</span></a>
                <a class="dropdown-item" href="#">Lupa password?</a>
              </div>
              <!--  dropdown-menu .// -->
            </div>
            <!-- widget-header .// -->
          </div>
          <?php endif; ?>

          <div class="col-auto ml-1 border-left">
            <a href="<?= site_url('cart'); ?>">
              <div class="icontext">
                <div class="icon-wrap">
                  <i class="text-danger icon-sm fa fa-shopping-cart"></i>
                </div>
                <div class="count_cart">

                </div>

              </div>
            </a>
          </div>

          <div class="col-auto ml-1 border-left">
            <a href="">
              <div class="icontext">
                <div class="icon-wrap">
                  <i class=" text-danger icon-sm fa fa-bell"
                    aria-hidden="true"></i>
                </div>
              </div>
            </a>
          </div>
        </div>
        <!-- widgets-wrap.// row.// -->
      </div>
      <!-- col.// -->
    </div>
    <!-- row.// -->
  </div>
  <!-- container.// -->
</section>
<!-- header-main .// -->
</header>
<!-- section-header.// -->
<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content bg padding-y-sm" style="min-height:430px">
<div class="container">