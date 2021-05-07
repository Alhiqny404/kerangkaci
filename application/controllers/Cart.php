<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Cart_model', 'cart_m');
    if (!$this->session->userdata('email')) {
      redirect(site_url());
    }

  }

  public function index() {
    $this->db->select('products.name_products,products.image_products,products.slug_products,cart.*');
    $this->db->from('cart');
    $this->db->join('products', 'products.id_products = cart.id_product');
    $this->db->where(['cart.id_user' => $this->session->userdata('id_user'), 'status !=' => 1]);
    $query = $this->db->get();
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
    $this->load->view('home/keranjang', $data);
    $this->load->view('home/templates/footer');
  }


  public function remove_cart($id) {
    $cart = $this->db->get_where('cart', ['id_cart' => $id])->row_array();
    $product = $this->db->get_where('products', ['id_products' => $cart['id_product']])->row_array();
    $this->db->update('products', ['stock_products' => $product['stock_products']+$cart['qty']], ['id_products' => $product['id_products']]);
    $this->cart_m->delete_cart(['id_cart' => $id]);

  }


  public function ajax_update() {
    $this->form_validation->set_rules('qty', 'Qty', 'trim|required|is_natural_no_zero', [
      'required' => 'tidak boleh kosong',
      'is_natural_no_zero' => 'minimal 1'
    ]);

    if ($this->form_validation->run() == FALSE) {
      $err = ['qty' => form_error('qty')];
      echo json_encode(["status" => FALSE, 'err' => $err]);
    } else
    {
      $product = $this->db->get_where('products', ['id_products' => $this->input->post('id_product')])->row();

      $stock = $product->stock_products;
      $price_total = $product->price_total_products;
      $weight_product = $product->weight_products;
      $qty = htmlspecialchars($this->input->post('qty'), true);
      $qty_old = $this->input->post('qty_old');
      $new_qty = $qty_old - $qty + $stock;
      $this->db->update('products', ['stock_products' => $new_qty], ['id_products' => $this->input->post('id_product')]);
      $data = [
        'qty' => $qty,
        'note' => htmlspecialchars($this->input->post('note'), true),
        'total_weight' => $weight_product*$qty,
        'total_price' => $price_total*$qty
      ];

      $this->cart_m->update_cart($data, ['id_cart' => $this->input->post('id')]);
      echo json_encode(array("status" => TRUE));
    }

  }

  public function update($id) {
    $price = $this->cart->pPrice();
    $stock = $this->cart->pStock();
    $weight = $this->homp->pWeight();
    if ($this->input->post('qty') > $stock) {
      $this->session->set_flashdata('message', 'Jumlah melebihi stock');

      redirect('keranjang');
    } else {
      $data = ['note' => $this->input->post('note'),
        'c_price' => $this->input->post('qty') * $price,
        'qty' => $this->input->post('qty'),
        'c_weight' => $this->input->post('qty') * $weight


      ];
      $this->db->where('id_cart', $id);
      $this->db->update('cart', $data);
      $this->session->set_flashdata('message', 'Keranjang berhasil di update');

      redirect('keranjang');
    }

  }

  // VIEW MODAL EDIT
  public function ajax_edit($id) {
    $data = $this->cart_m->get_where(['id_cart' => $id]);
    echo json_encode($data->row());
  }

}

/* End of file Controllername.php */