<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class More extends CI_Controller {


  public function __construct() {
    parent::__construct();
    harus_login();
  }

  public function master() {
    $data['submenu'] = $this->db->get_where('sub_menu', ['is_active' => 1, 'menu_id' => 24])->result_array();

    $page = 'more/master';
    $data['title'] = 'Data Master';
    pages($page, $data);
  }

  public function sistem() {
    $data['submenu'] = $this->db->get_where('sub_menu', ['is_active' => 1, 'menu_id' => 20])->result_array();

    $page = 'more/sistem';
    $data['title'] = 'Pengaturan Sistem';
    pages($page, $data);
  }



}