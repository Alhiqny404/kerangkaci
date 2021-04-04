<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {


  public function __construct() {
    parent::__construct();
    harus_login();
  }

  public function index() {
    $page = 'admin/dashboard';
    $data['title'] = 'Dashboard';
    pages($page, $data);
  }



}