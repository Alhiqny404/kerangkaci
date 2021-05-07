<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {


  public function __construct() {
    parent::__construct();
    $this->load->model('Product_model', 'product');
    $this->load->model('Category_model', 'category');
    $this->load->model('Cart_model', 'cart_m');
    $this->load->model('Transaction_model', 'transaction');
    // harus_login();
  }

  public function index() {
    if (isset($_POST['cari'])) {
      $data['products'] = $this->product->get_like(['name_products' => htmlspecialchars($this->input->post('cari'))]);
    } else {
      $data['products'] = $this->product->get();
    }
    $data['title'] = 'Home';
    $this->load->view('home/templates/header', $data);
    $this->load->view('home/templates/navbar', $data);
    $this->load->view('home/home', $data);
    $this->load->view('home/templates/footer');



  }

  public function redirect() {
    redirect(site_url());
  }

  public function count_cart() {
    if (count_cart() > 0) {
      $output = '<span id="count_cart" class="small round badge badge-secondary">'.count_cart().'</span>';
    } else {
      $output = '';
    }
    echo $output;
  }

  public function category($slug) {
    $id_category = $this->category->get_where(['slug_categories' => $slug])->row_array()['id_categories'];
    $data['products'] = $this->product->get_where(['products.id_categories' => $id_category])->result();
    $data['title'] = 'Home';
    $this->load->view('home/templates/header', $data);
    $this->load->view('home/templates/navbar', $data);
    $this->load->view('home/home', $data);
    $this->load->view('home/templates/footer');
  }

  public function product($slug) {
    $product = $this->product->get_where(['slug_products' => $slug]);
    if ($product->num_rows() > 0) {
      $data['product'] = $product->row();
      $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row();
      $data['title'] = 'Home';
      $this->load->view('home/templates/header', $data);
      $this->load->view('home/templates/navbar', $data);
      $this->load->view('home/product', $data);
      $this->load->view('home/templates/footer');
    } else {
      $this->redirect();
    }

  }

  public function myorder() {
    if (!$this->session->userdata('email')) {
      redirect(site_url());
    }
    $orders = $this->transaction->get_where(['id_user' => $this->session->userdata('id_user')]);
    $data['orders'] = $orders->result();
    $data['banks'] = $this->db->get('bank')->result();
    $this->load->view('home/templates/header');
    $this->load->view('home/templates/navbar');
    $this->load->view('home/myorder', $data);
    $this->load->view('home/templates/footer');
  }

  public function detail_order($id) {
    if (!$this->session->userdata('email')) {
      redirect(site_url());
    }
    $data['invoice'] = $this->transaction->get_where(['id_user' => $this->session->userdata('id_user'), 'id_transaction' => $id])->row();
    $data_address = json_decode($data['invoice']->recipient_data)->address;
    $data['address'] = "{$data_address->detail}, {$data_address->kec}, {$data_address->kab}, {$data_address->prov}, {$data_address->kode_pos}";
    if (!$data['invoice']) {
      redirect($this->myorder());
    }

    $this->db->select('*');
    $this->db->from('trans_detail');
    $this->db->join('cart', 'cart.id_cart = trans_detail.id_cart', 'left');
    $this->db->join('products', 'products.id_products = cart.id_product', 'left');
    $this->db->where('trans_detail.id_transaction', $data['invoice']->id_transaction);
    $query = $this->db->get();
    $data['products'] = $query->result();
    //print_r($data['products']);
    //die;
    $this->load->view('home/templates/header');
    $this->load->view('home/templates/navbar');
    $this->load->view('home/inpo',
      $data);
    $this->load->view('home/templates/footer');
  }

  public function add_cart() {
    if (!$this->session->userdata('email')) {
      redirect(site_url());
    }
    $this->form_validation->set_rules('qty', 'Qty', 'trim|required|is_natural_no_zero', [
      'required' => 'tidak boleh kosong',
      'is_natural_no_zero' => 'minimal 1'
    ]);

    if ($this->form_validation->run() == false) {
      $err = ['qty' => form_error('qty')];
      echo json_encode(['status' => false, 'err' => $err]);
    } else {
      $id_user = $this->session->userdata('id_user');
      $id_product = $this->input->post('id_product');
      $note = $this->input->post('note');
      $qty = $this->input->post('qty');
      $weight = $this->input->post('weight');
      $price = $this->input->post('price');


      $product = $this->db->get_where('products', ['id_products' => $id_product])->row_array()['stock_products'];
      $this->db->update('products', ['stock_products' => $product-$qty], ['id_products' => $id_product]);

      $carts = $this->cart_m->get_where(['id_user' => $id_user, 'id_product' => $id_product]);
      if ($carts->num_rows() > 0) {
        $cart_where = $this->cart_m->get_where(['id_user' => $id_user, 'id_product' => $id_product, 'status' => 0]);
        $cart = $cart_where->row();
        if ($cart_where->num_rows() > 0) {
          $data = [
            'id_user' => $id_user,
            'id_product' => $id_product,
            'note' => $note,
            'qty' => $cart->qty+$qty,
            'total_weight' => $weight*$qty+$cart->total_weight,
            'total_price' => $price*$qty+$cart->total_price
          ];
          $this->cart_m->update_cart($data, ['id_cart' => $cart->id_cart]);
          echo json_encode(['status' => 'diupdate']);
        } else {
          $cart_where = $this->cart_m->get_where(['id_user' => $id_user, 'id_product' => $id_product, 'status' => 1]);
          $cart = $cart_where->row();
          if ($cart_where->num_rows() > 0) {
            $data = [
              'id_user' => $id_user,
              'id_product' => $id_product,
              'note' => $note,
              'qty' => $qty,
              'total_weight' => $weight*$qty,
              'total_price' => $price*$qty
            ];
            $this->cart_m->add_cart($data);
            echo json_encode(['status' => $data]);
          }
        }
      } else {
        $data = [
          'id_user' => $id_user,
          'id_product' => $id_product,
          'note' => $note,
          'qty' => $qty,
          'total_weight' => $weight*$qty,
          'total_price' => $price*$qty
        ];
        $this->cart_m->add_cart($data);
        echo json_encode(['status' => $data]);
      }


    }

  }

  public function pay($id) {
    $transaction = $this->db->get_where('transactions', ['id_transaction' => $id])->row();
    if (!$transaction) {
      redirect(site_url('myorder'));
    }
    $data['banks'] = $this->db->get('bank')->result();
    $data['id_transaction'] = $id;
    $this->load->view('home/templates/header');
    $this->load->view('home/templates/navbar');
    $this->load->view('home/pay', $data);
    $this->load->view('home/templates/footer');

    if (isset($_POST['submit'])) {
      $this->_send_bukti();
    }

  }

  private function _send_bukti() {
    $data = [
      "id_user" => $this->session->userdata('id_user'),
      "id_transaction" => htmlspecialchars($this->input->post('id_transaction'), true),
      "code_bank" => htmlspecialchars($this->input->post('code_bank'), true),
      "acc_name" => htmlspecialchars($this->input->post('acc_name'), true),
      "dest_rek" => htmlspecialchars($this->input->post('dest_rek').true),
      "norek" => htmlentities($this->input->post('norek'), true),
      "created_at" => time()
    ];
    $upload_image = $_FILES['image']['name'];
    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    if (!empty($upload_image)) {

      $config['upload_path'] = './uploads/image/payment';
      $config['allowed_types'] = 'jpeg|jpg|png';
      $config['file_name'] = 'payment_'.time().".{$extension}";
      $config['overwrite'] = true;
      $config['max_size'] = '5048';
      $this->load->library('upload', $config);
      if (!$this->upload->do_upload('image')) {
        $error = array('error' => $this->upload->display_errors());
      } else {
        $image = $this->upload->data('file_name');
        $data['image'] = $image;
        //$this->db->set('image', $image);
      }
    }
    $insert = $this->db->insert('payment', $data);
    if ($insert) {
      $this->db->update('transactions', ['status' => "pending", "pay_at" => time()], ['id_transaction' => $this->input->post('id_transaction')]);
      redirect(site_url('myorder'));
    }
  }


  public function profile() {
    $data['orders'] = $this->transaction->get_where(['id_user' => $this->session->userdata('id_user')])->result_array();
    $data['user'] = $this->db->get_where('user', ['email' =>
      $this->session->userdata('email')])->row_array();
    //$data['category'] = $this->products->getCategories();
    $this->load->view('home/templates/header', $data);
    $email_tmp = $this->session->userdata('email');
    // $idu = $this->cart->idu($email_tmp);
    //$data['order'] = $this->history->getOrder($idu);
    $this->load->view('home/templates/navbar', $data);
    $this->load->view('home/profil/profil');
    $this->load->view('home/templates/footer');
  }

  public function profile_edit() {
    $data['orders'] = $this->transaction->get_where(['id_user' => $this->session->userdata('id_user')])->result_array();
    $data['user'] = $this->db->get_where('user', ['email' =>
      $this->session->userdata('email')])->row_array();
    $this->load->view('home/templates/header', $data);
    $this->load->view('home/templates/navbar', $data);
    $this->load->view('home/profil/edit');
    $this->load->view('home/templates/footer');

    if (isset($_POST['submit'])) {
      $username = htmlspecialchars($this->input->post('username'), true);
      $this->db->update('user', ['username' => $username], ['email' => $this->session->userdata('email')]);

      redirect(site_url('profile/edit'));
    }

  }


}