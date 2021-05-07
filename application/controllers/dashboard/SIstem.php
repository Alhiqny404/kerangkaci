<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sistem extends CI_Controller {



  public function __construct() {
    parent::__construct();
    $this->load->model('Apps_model', 'apps');
    $this->load->model('Menu_model', 'menu');
    $this->load->model('Role_Model', 'role');
    harus_login();
    akses_submenu();
  }

  // halaman utama
  public function index() {
    $data['submenu'] = $this->db->get_where('sub_menu', ['is_active' => 1, 'menu_id' => 20])->result_array();
    $page = 'more/sistem';
    $data['title'] = 'Pengaturan Sistem';
    pages($page, $data);
  }

  public function aplikasi() {
    $page = 'backend/aplikasi';
    $data['title'] = 'Aplikasi';
    pages($page, $data);
  }

  public function menu() {
    $data['title'] = 'Menu Group';
    $page = 'backend/menu';
    pages($page, $data);
  }

  public function urutan_menu() {
    $page = 'menu/urutan_menu';
    $menu = $this->menu->get_all();
    $data['menu'] = $menu->result_array();
    $data['title'] = 'Urutan Menu';
    $page = 'backend/urutan-menu';
    pages($page, $data);
  }

  public function submenu() {
    $menu = $this->menu->get_where(['tipe' => 2]);
    $data['menu'] = $menu->result_array();
    $page = 'backend/submenu';
    $data['title'] = 'Sub Menu';
    pages($page, $data);
  }

  public function role() {
    $role = $this->role->get_all();
    $data['role'] = $role->result_array();
    $page = 'backend/role';
    $data['title'] = 'Role';
    pages($page, $data);
  }



}