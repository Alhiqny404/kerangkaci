<?php

function pages($page = '', $data = '') {

  $ci = get_instance();
  $ci->load->view('_layouts/header', $data);
  $ci->load->view('_layouts/layout', $data);
  $ci->load->view('_layouts/sidebar', $data);
  $ci->load->view($page, $data);
  $ci->load->view('_layouts/footer', $data);


}