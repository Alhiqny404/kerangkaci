<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller {



  public function __construct() {
    parent::__construct();
    $this->load->model('Apps_model', 'apps');
    $this->load->model('Menu_model', 'menu');
    $this->load->model('Role_Model', 'role');
    $this->load->model('Submenu_model', 'submenu');
    harus_login();
    akses_submenu();
  }

  public function index() {
    $submenu = $this->submenu->get_where(['is_active' => 1, 'menu_id' => 24]);
    $data['submenu'] = $submenu->result_array();
    $page = 'more/master';
    $data['title'] = 'Data Master';
    pages($page, $data);
  }

  public function user() {
    //$role = $this->role->get_all();
    //$data['role'] = $role->result_array();

    $data['role'] = $this->db->get('role')->result_array();
    $page = 'backend/user';
    $data['title'] = 'Data User';
    pages($page, $data);
  }

  public function category() {
    $page = 'backend/categories';
    $data['title'] = 'Data Kategori';
    pages($page, $data);
  }

}