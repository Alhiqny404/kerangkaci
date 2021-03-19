<?php

function pages($page = '', $data = '') {

  $ci = get_instance();
  $ci->load->view('layout/header', $data);
  $ci->load->view('layout/navbar', $data);
  $ci->load->view('layout/sidebar', $data);
  $ci->load->view('layout/breadcrumb', $data);
  $ci->load->view($page, $data);
  $ci->load->view('layout/footer', $data);

}