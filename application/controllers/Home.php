<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


  public function __construct() {
    parent::__construct();
    harus_login();
  }

  public function index() {
    $page = 'user/home';
    $data['title'] = 'Home';
    pages($page, $data);
  }



}