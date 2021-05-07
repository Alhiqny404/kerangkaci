<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Transaction_model', 'transaction');
    harus_login();
    akses_submenu();
  }

  // HALAMAN UTAMA MENU MANAGEMENT
  public function transaction_index() {
    $data['title'] = 'Pesanan';
    $page = 'backend/transaction';
    pages($page, $data);
  }


}