<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {


  public function __construct() {
    parent::__construct();
    $this->load->model('Cart_model', 'cart_m');
    if (!$this->session->userdata('email')) {
      redirect(site_url());
    }
  }


  public function index() {

    $this->db->select('products.name_products,products.price_products,products.discount_products,cart.*');
    $this->db->from('cart');
    $this->db->join('products', 'products.id_products = cart.id_product');
    $this->db->where(['cart.id_user' => $this->session->userdata('id_user'), 'status' => 0]);
    $query = $this->db->get();
    $data['prov'] = $this->db->get('wilayah_provinsi')->result_array();
    $data['items_cart'] = $query->result();
    $data['count_cart'] = $query->num_rows();
    $data['total_price'] = 0;
    $data['total_weight'] = 0;
    foreach ($query->result_array() as $sum) {
      $data['total_price'] += $sum['total_price'];
      $data['total_weight'] += $sum['total_weight'];
    }

    $this->load->view('home/templates/header');
    $this->load->view('home/templates/navbar');
    $this->load->view('home/checkout', $data);
    $this->load->view('home/templates/footer');

    if (isset($_POST['submit'])) {
      $this->checkout();
    }


  }

  private function checkout() {


    $id_user = $this->session->userdata('id_user');
    $id_transaction = $id_user.time();
    $receiver = htmlspecialchars($this->input->post('receiver'), true);
    $phone = htmlspecialchars($this->input->post('phone'), true);
    $prov = htmlspecialchars($this->input->post('nama_prov'), true);
    $kab = htmlspecialchars($this->input->post('nama_kab'), true);
    $kec = htmlspecialchars($this->input->post('nama_kec'), true);
    $kode_pos = htmlspecialchars($this->input->post('kode_pos'), true);
    $address_detail = htmlspecialchars($this->input->post('address_detail'), true);
    $kurir = htmlspecialchars($this->input->post('kurir'), true);
    $service = explode(',',
      htmlspecialchars($this->input->post('service', TRUE)))[1];
    $resi = htmlspecialchars($this->input->post('resi'),
      true);
    $pay = htmlspecialchars($this->input->post('total_price'),
      true);
    $postal_fee = htmlspecialchars($this->input->post('postal_fee'),
      true);
    $total_pay = htmlspecialchars($this->input->post('total_pay'),
      true);
    $address_customer = [
      "customer" => [
        "name" => $receiver,
        "phone" => $phone
      ],
      "address" => [
        "prov" => $prov,
        "kab" => $kab,
        "kec" => $kec,
        "kode_pos" => $kode_pos,
        "detail" => $address_detail
      ]];
    $recipient_data = json_encode($address_customer);


    $data = [
      'id_transaction' => $id_transaction,
      'id_user' => $id_user,
      'pay' => $pay,
      'postal_fee' => $postal_fee,
      'total_pay' => $total_pay,
      'kurir' => $kurir,
      'service' => $service,
      'resi' => '',
      'status' => 'new',
      'recipient_data' => $recipient_data,
      'created_at' => time()
    ];

    $insert_trans = $this->db->insert('transactions',
      $data);

    if ($insert_trans) {

      foreach ($this->input->post('id_carts') as $id_cart) {
        $cart_where = $this->db->get_where('cart', ['id_cart' => $id_cart, 'status' => 0])->row_array();
        $data = [
          'id_trans_detail' => '',
          'id_cart' => $cart_where['id_cart'],
          'id_transaction' => $id_transaction
        ];

        $this->db->insert('trans_detail', $data);
        $this->cart_m->update_cart(['status' => 1], ['id_cart' => $cart_where['id_cart']]);

      }
    }
    redirect(site_url('myorder'));

  }


}


/* End of file Chekout.php */