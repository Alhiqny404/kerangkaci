<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {


  public function __construct() {
    parent::__construct();
    $this->load->model('Submenu_model', 'submenu');
    $this->load->model('Apps_model', 'apps');
    $this->load->model('Menu_model', 'menu');
    $this->load->model('Role_Model', 'role');
    $this->load->model('Category_model', 'category');
    $this->load->model('Product_model', 'product');
    $this->load->model('Transaction_model', 'transaction');
    harus_login();
  }

  // DASHBOARD
  public function index() {
    $data['product'] = $this->db->get('products')->num_rows();
    $data['pelanggan'] = $this->db->get_where('user', ['role_id' => 2])->num_rows();
    $data['pesanan'] = $this->db->get_where('transactions', ['status' => 'pending'])->num_rows();
    $page = 'backend/dashboard';
    $data['title'] = 'dashboard';
    pages($page, $data);
  }



  // DASHBOARD/SISTEM
  public function sistem_index() {
    $data['submenu'] = $this->db->get_where('sub_menu', ['is_active' => 1, 'menu_id' => 20])->result_array();
    $page = 'more/sistem';
    $data['title'] = 'Pengaturan Sistem';
    pages($page, $data);
  }

  // DASHBOARD/SISTEM/APLIKASI
  public function sistem_aplikasi() {
    $page = 'backend/aplikasi';
    $data['title'] = 'Aplikasi';
    pages($page, $data);
  }

  // DASHBOARD/SISTEM/MENU
  public function sistem_menu() {
    $data['title'] = 'Menu Group';
    $page = 'backend/menu';
    pages($page, $data);
  }

  // DASHBOARD/SISTEM/URUTAN-MENU
  public function sistem_urutan_menu() {
    $page = 'menu/urutan_menu';
    $menu = $this->menu->get_all();
    $data['menu'] = $menu->result_array();
    $data['title'] = 'Urutan Menu';
    $page = 'backend/urutan-menu';
    pages($page, $data);
  }

  // DASHBOARD/SISTEM/SUBMENU
  public function sistem_submenu() {
    $menu = $this->menu->get_where(['tipe' => 2]);
    $data['menu'] = $menu->result_array();
    $page = 'backend/submenu';
    $data['title'] = 'Sub Menu';
    pages($page, $data);
  }

  // DASHBOARD/SISTEM/ROLE
  public function sistem_role() {
    $role = $this->role->get_all();
    $data['role'] = $role->result_array();
    $page = 'backend/role';
    $data['title'] = 'Role';
    pages($page, $data);
  }


  // DASHBOARD/MASTER/
  public function master_index() {
    $submenu = $this->submenu->get_where(['is_active' => 1, 'menu_id' => 24]);
    $data['submenu'] = $submenu->result_array();
    $page = 'more/master';
    $data['title'] = 'Data Master';
    pages($page, $data);
  }


  //DASHBOARD/MASTER/USER
  public function master_user() {
    $data['role'] = $this->db->get('role')->result_array();
    $page = 'backend/user';
    $data['title'] = 'Data User';
    pages($page, $data);
  }

  //DASHBOARD/MASTERCATEGORY/
  public function master_category() {
    $page = 'backend/categories';
    $data['title'] = 'Data Kategori';
    pages($page, $data);
  }


  //DASHBOARD/PRODUCT
  public function product_index() {
    $page = 'backend/products';
    $data['title'] = 'Data Produk';
    pages($page, $data);
  }


  //DASHBOARD/PRODUCT/DETAIL
  public function product_detail($slug) {
    $data['product'] = $this->db->get_where('products', ['slug_products' => $slug])->row();
    $page = 'backend/detail_product';
    $data['title'] = 'Detail Produk';
    pages($page, $data);
  }


  //DASHBOARD/PRODUCT/ADD
  public function product_add() {
    $page = 'backend/add_product';
    $data['title'] = 'Tambah Data Produk';
    pages($page, $data);
  }


  //DASHBOARD/PRODUCT/EDIT
  public function product_edit($id) {
    $page = 'backend/edit_product';
    $data['id_product'] = $id;
    $data['id_categories'] = $this->db->query("SELECT id_categories FROM products WHERE id_products = {$id}")->row_array()['id_categories'];
    $data['image_products'] = $this->db->query("SELECT image_products FROM products WHERE id_products = {$id}")->row_array()['image_products'];
    $data['title'] = 'Edit Data Produk';
    pages($page, $data);
  }

  // HALAMAN UTAMA MENU MANAGEMENT
  public function transaction_index() {
    $data['title'] = 'Pesanan';
    $page = 'backend/transaction';
    pages($page, $data);
  }


  // DASHBOARD/TRAMSACTION/DETAIL
  public function transaction_detail($id) {

    $data['invoice'] = $this->transaction->get_where(['id_transaction' => $id])->row();
    $data_address = json_decode($data['invoice']->recipient_data)->address;
    $data['address'] = "{$data_address->detail}, {$data_address->kec}, {$data_address->kab}, {$data_address->prov}, {$data_address->kode_pos}";

    $this->db->select('*');
    $this->db->from('trans_detail');
    $this->db->join('cart', 'cart.id_cart = trans_detail.id_cart', 'left');
    $this->db->join('products', 'products.id_products = cart.id_product', 'left');
    $this->db->where('trans_detail.id_transaction', $data['invoice']->id_transaction);
    $query = $this->db->get();
    $data['products'] = $query->result();
    //die;
    $data['title'] = 'Detail Transaksi';
    $page = 'backend/detail_transaction';
    pages($page, $data);
  }

}