<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="main-sidebar sidebar-style-2" style="background:<?= aplikasi()['color_sidebar']; ?>;">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="<?= site_url(); ?>dist/index"><?= aplikasi()['name_app']; ?></a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="<?= site_url(); ?>dist/index"><?= substr(aplikasi()['name_app'], 0, 1); ?></a>
    </div>
    <ul class="sidebar-menu">
      <?php foreach (menu() as $m) : ?>

      <?php if ($m['tipe'] < 2) : ?>

      <li class="<?= $this->uri->segment(2) == 'blank' ? 'active' : ''; ?>"><a class="nav-link" href="<?=base_url($m['menu']); ?>"><i class="<?=$m['icon']; ?>"></i> <span><?= $m['title']; ?></span></a></li>

      <?php else : ?>

      <li class="dropdown<?= $this->uri->segment(2) == 'layout_default' || $this->uri->segment(2) == 'layout_transparent' || $this->uri->segment(2) == 'layout_top_navigation' ? 'active' : ''; ?>">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="<?=$m['icon']; ?>"></i> <span><?=$m['title']; ?></span></a>
        <ul class="dropdown-menu">
          <?php foreach (submenu($m['id']) as $sm): ?>
          <li class="<?= $this->uri->segment(2) == 'layout_default' ? 'active' : ''; ?>"><a class="nav-link" href="<?=base_url($sm['url']); ?>"><i class="<?=$sm['icon']; ?>"></i> <?=$sm['title']; ?></a></li>
          <?php endforeach; ?>
        </ul>
      </li>

      <?php endif; ?>
      <?php endforeach; ?>



    </ul>

  </aside>
</div>