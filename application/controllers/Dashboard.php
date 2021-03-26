<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {



  public function __construct() {
    parent::__construct();
    harus_login();
  }

  public function index() {
    $email = $this->session->userdata('email');
    $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
    $page = 'admin/dashboard';
    $data['title'] = 'Dashboard';
    //pages($page, $data);
    $this->load->view('admin/dashboard', $data);
  }



}