<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {


  public function __construct() {
    parent::__construct();
    $this->load->model('Apps_model', 'apps');
    $this->load->model('Menu_model', 'menu');
    $this->load->model('Role_Model', 'role');
    harus_login();
  }

  public function index() {
    echo 'ada';
  }





}