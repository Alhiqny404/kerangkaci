<?php
$uris = explode('/', $this->uri->uri_string);
$role_id = $this->session->userdata('role_id');

?>
<div class="section-header-breadcrumb">
  <div class="breadcrumb-item active">
    <?php if ($role_id == 1) {
      ?>
      <?= $uris[0] != 'dashboard' ?  '<a href="'.site_url('dashboard').'">Dashboard</a>' : 'Dashboard'; ?>
      <?php
    } else {
      ?>
      <?= $uris[0] != 'home' ?  '<a href="'.site_url('home').'">Home</a>' : 'Home'; ?>
      <?php
    } ?>
  </div>
  <?php
  /*------------- KONDISI SELAIN DASHBOARD ------------------*/
  if ($uris[0] != 'dashboard' || $uris[0] != 'home') {
    if (count($uris) > 1) {
      if (count($uris) == 2) {
        $i = 1;
        foreach (array_slice($uris, 0, 1) as $uri) {
          $link = implode('/', array_slice($uris, 0, $i++));
          echo '<div class="breadcrumb-item"><a href="'.site_url($link).'">'.$uri.'</a></div>';
        };

      };
      if (count($uris) == 3) {
        $i = 1;
        foreach (array_slice($uris, 0, 2) as $uri) {
          $link = implode('/', array_slice($uris, 0, $i++));
          echo '<div class="breadcrumb-item"><a href="'.site_url($link).'">'.$uri.'</a></div>';
        };
      };
    };
    echo $uris[0] != 'dashboard' && $uris[0] != 'home' ?  '<div class="breadcrumb-item">'.end($uris).'</div>' : '';
    /*------------- END KONDISI SELAIN DASHBOARD ------------------*/
  }; ?>
</div>