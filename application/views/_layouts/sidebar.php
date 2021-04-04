<div class="main-sidebar sidebar-style-2" style="background:<?= aplikasi()['color_sidebar']; ?>;">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="<?= site_url(); ?>dist/index"><?= aplikasi()['name_app']; ?></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="<?= site_url(); ?>dist/index"><?= substr(aplikasi()['name_app'], 0, 1); ?></a>
    </div>
    <ul class="sidebar-menu">
      <!----------------   LOOPING MENU  ---------------->
      <?php foreach (menu() as $m) : ?>
      <!----------------   KONDISI MENU BIASA  ---------------->
      <?php if ($m['tipe'] == 1) : ?>
      <li class="<?= $m['menu'] == $this->uri->segment(1) ? 'active' : ''; ?>"><a class="nav-link" href="<?=site_url($m['menu']); ?>"><i class="<?=$m['icon']; ?>"></i> <span><?= $m['title']; ?></span></a></li>
      <!----------------   KONDISI MENU DROPDOWN  ---------------->
      <?php else : ?>
      <li class="dropdown<?= $m['menu'] == $this->uri->segment(1) ? ' active' : ''; ?>">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="<?=$m['icon']; ?>"></i> <span><?=$m['title']; ?></span></a>
        <ul class="dropdown-menu">
          <!----------------   LOOPING SUBMENU  ---------------->
          <?php foreach (submenu($m['id']) as $sm): ?>
          <?php $url = explode('/', $sm['url']); ?>
          <li class="<?= $this->uri->segment(2) == end($url) ? 'active' : ''; ?>"><a class="nav-link" href="<?=site_url($sm['url']); ?>"><i class="<?=$sm['icon']; ?>"></i> <?=$sm['title']; ?></a></li>
          <?php endforeach; ?>
          <!----------------   END LOOPING SUBMENU  ---------------->
        </ul>
      </li>
      <?php endif; ?>
      <?php endforeach; ?>
      <!----------------   END LOOPING MENU  ---------------->
    </ul>
  </aside>
</div>