<div class="page-sidebar sidebar">
  <div class="page-sidebar-inner slimscroll">
    <div class="sidebar-header">
      <div class="sidebar-profile">

        <a href="javascript:void(0);">
          <div class="sidebar-profile-image">
            <img src="<?= base_url('uploads/image/profile/').datauser($this->session->userdata('email'))['avatar']; ?>" class="img-circle img-responsive" alt="">
          </div>
          <div class="sidebar-profile-details">
            <span><?=datauser($this->session->userdata('email'))['nama']; ?><br>
              <small>Administrator</small>
            </span>
          </div>
        </a>
      </div>
    </div>
    <ul class="menu accordion-menu">

      <?php foreach (menu() as $m) : ?>

      <?php if ($m['tipe'] < 2) : ?>
      <li><a href="<?=base_url($m['menu']); ?>" class="waves-effect waves-button"><i class="menu-icon<?=' '.$m['icon']; ?>">
      </i><p>
        <?= $m['title']; ?>
      </p>
      </a></li>
      <?php else : ?>
      <li class="droplink"><a href="#" class="waves-effect waves-button"><i class="menu-icon<?=' '.$m['icon']; ?>"></i><p>
        <?= $m['menu']; ?>
      </p>
        <span class="arrow"></span></a>
        <ul class="sub-menu">
          <?php foreach (submenu($m['id']) as $sm): ?>
          <li><a href="<?=base_url($sm['url']); ?>"><?=$sm['title']; ?></a></li>
          <?php endforeach; ?>
        </ul>
      </li>
      <?php endif; ?>
      <?php endforeach; ?>
      <li><a href="<?=base_url('login/logout'); ?>" class="waves-effect waves-button"><span class="menu-icon icon-logout"></span><p>
        Log Out
      </p>
      </a></li>

    </ul>
  </div>
  <!-- Page Sidebar Inner -->
</div>
<!-- Page Sidebar -->
<div class="page-inner">