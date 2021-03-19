<!DOCTYPE html>
<html>
<head>

  <!-- Title -->
  <title>Users</title>

  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <meta charset="UTF-8">
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="author" content="" />
  <link rel="shortcut icon" href="<?php echo base_url().'assets/backend/images/favicon.png' ?>">
  <!-- Styles -->
  <link href="<?php echo base_url().'assets/backend/plugins/pace-master/themes/blue/pace-theme-flash.css' ?>" rel="stylesheet" />
  <link href="<?php echo base_url().'assets/backend/plugins/uniform/css/uniform.default.min.css' ?>" rel="stylesheet" />
  <link href="<?php echo base_url().'assets/backend/plugins/bootstrap/css/bootstrap.min.css' ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url().'assets/backend/plugins/fontawesome/css/font-awesome.css' ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url().'assets/backend/plugins/line-icons/simple-line-icons.css' ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url().'assets/backend/plugins/offcanvasmenueffects/css/menu_cornerbox.css' ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url().'assets/backend/plugins/waves/waves.min.css' ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url().'assets/backend/plugins/switchery/switchery.min.css' ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url().'assets/backend/plugins/3d-bold-navigation/css/style.css' ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url().'assets/backend/plugins/slidepushmenus/css/component.css' ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url().'assets/backend/plugins/datatables/css/jquery.datatables.min.css' ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url().'assets/backend/plugins/datatables/css/jquery.datatables_themeroller.css' ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url().'assets/backend/plugins/bootstrap-datepicker/css/datepicker3.css' ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url().'assets/backend/plugins/select2/css/select2.min.css' ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url().'assets/backend/plugins/toastr/jquery.toast.min.css' ?>" rel="stylesheet" type="text/css" />
  <!-- Theme Styles -->
  <link href="<?php echo base_url().'assets/backend/css/modern.min.css' ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url().'assets/backend/css/themes/green.css' ?>" class="theme-color" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url().'assets/backend/css/custom.css' ?>" rel="stylesheet" type="text/css" />
  <link href="<?php echo base_url().'assets/backend/css/dropify.min.css' ?>" rel="stylesheet" type="text/css">

  <script src="<?php echo base_url().'assets/backend/plugins/3d-bold-navigation/js/modernizr.js' ?>"></script>
  <script src="<?php echo base_url().'assets/backend/plugins/offcanvasmenueffects/js/snap.svg-min.js' ?>"></script>


</head>
<body class="page-header-fixed  compact-menu  pace-done page-sidebar-fixed">
  <div class="overlay"></div>

  <main class="page-content content-wrap">

    <div class="navbar">
      <div class="navbar-inner">
        <div class="sidebar-pusher">
          <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
            <i class="fa fa-bars"></i>
          </a>
        </div>
        <div class="logo-box">
          <a href="<?php echo site_url('backend/dashboard'); ?>" class="logo-text"><span>MBLOG</span></a>
        </div>
        <!-- Logo Box -->
        <div class="search-button">
          <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
        </div>
        <div class="topmenu-outer">
          <div class="top-menu">
            <ul class="nav navbar-nav navbar-left">
              <li>
                <a href="javascript:void(0);" class="waves-effect waves-button waves-classic sidebar-toggle"><i class="fa fa-bars"></i></a>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">

              <li class="dropdown">
                <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                  <span class="user-name">Alhiqny<i class="fa fa-angle-down"></i></span>

                  <img class="img-circle avatar" src="" width="40" height="40" alt="">
                </a>
                <ul class="dropdown-menu dropdown-list" role="menu">
                  <li role="presentation"><a href=""><i class="fa fa-sign-out m-r-xs"></i>Log out</a></li>
                </ul>
              </li>
              <li>
                <a href="" class="log-out waves-effect waves-button waves-classic">
                  <span><i class="fa fa-sign-out m-r-xs"></i>Log out</span>
                </a>
              </li>
            </ul>
            <!-- Nav -->
          </div>
          <!-- Top Menu -->
        </div>
      </div>
    </div>
    <!-- Navbar -->
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
          <li><a href="" class="waves-effect waves-button"><span class="menu-icon icon-home"></span><p>
            Dashboard
          </p>
          </a></li>



          <?php $i = 1; foreach (menu() as $m) : ?>
          <li class="droplink"><a href="" class="waves-effect waves-button"><span class="menu-icon icon-settings"></span><p>
            <?= $m['menu']; ?>
          </p>
            <span class="arrow"></span></a>
            <?php $is = 1; foreach (submenu($m['id']) as $sm): ?>
            <ul class="sub-menu">
              <li><a href="<?=base_url($sm['url']); ?>"><?=$sm['title']; ?></a></li>
            </ul>
          </li>
          <?php endforeach; ?>
          <?php endforeach; ?>


          <li class="droplink"><a href="" class="waves-effect waves-button"><span class="menu-icon icon-settings"></span><p>
            Settings
          </p>
            <span class="arrow"></span></a>
            <ul class="sub-menu">
              <li><a href="">Basic</a></li>
            </ul>
          </li>
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

      <div id="main-wrapper">
      </div>
      <!-- Main Wrapper -->
      <div class="page-footer">
        <p class="no-s">
          <?php echo date('Y'); ?> &copy; Powered by M Fikri Setiadi.
        </p>
      </div>
    </div>
    <!-- Page Inner -->
  </main><!-- Page Content -->

  <div class="cd-overlay"></div>


  <!-- Javascripts -->
  <script src="<?php echo base_url().'assets/backend/plugins/jquery/jquery-2.1.4.min.js' ?>"></script>
  <script src="<?php echo base_url().'assets/backend/plugins/jquery-ui/jquery-ui.min.js' ?>"></script>
  <script src="<?php echo base_url().'assets/backend/plugins/select2/js/select2.min.js' ?>" type="text/javascript"></script>
  <script src="<?php echo base_url().'assets/backend/plugins/pace-master/pace.min.js' ?>"></script>
  <script src="<?php echo base_url().'assets/backend/plugins/jquery-blockui/jquery.blockui.js' ?>"></script>
  <script src="<?php echo base_url().'assets/backend/plugins/bootstrap/js/bootstrap.min.js' ?>"></script>
  <script src="<?php echo base_url().'assets/backend/plugins/jquery-slimscroll/jquery.slimscroll.min.js' ?>"></script>
  <script src="<?php echo base_url().'assets/backend/plugins/switchery/switchery.min.js' ?>"></script>
  <script src="<?php echo base_url().'assets/backend/plugins/uniform/jquery.uniform.min.js' ?>"></script>
  <script src="<?php echo base_url().'assets/backend/plugins/offcanvasmenueffects/js/classie.js' ?>"></script>
  <script src="<?php echo base_url().'assets/backend/plugins/offcanvasmenueffects/js/main.js' ?>"></script>
  <script src="<?php echo base_url().'assets/backend/plugins/waves/waves.min.js' ?>"></script>
  <script src="<?php echo base_url().'assets/backend/plugins/3d-bold-navigation/js/main.js' ?>"></script>
  <script src="<?php echo base_url().'assets/backend/plugins/jquery-mockjax-master/jquery.mockjax.js' ?>"></script>
  <script src="<?php echo base_url().'assets/backend/plugins/moment/moment.js' ?>"></script>
  <script src="<?php echo base_url().'assets/backend/plugins/datatables/js/jquery.datatables.min.js' ?>"></script>
  <script src="<?php echo base_url().'assets/backend/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js' ?>"></script>
  <script src="<?php echo base_url().'assets/backend/js/modern.min.js' ?>"></script>
  <script src="<?php echo base_url().'assets/backend/js/dropify.min.js' ?>"></script>
  <script src="<?php echo base_url().'assets/backend/plugins/toastr/jquery.toast.min.js' ?>"></script>


</body>
</html>