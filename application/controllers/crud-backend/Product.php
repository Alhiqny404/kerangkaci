<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

  public function __construct() {
    parent::__construct();

    $this->load->model('Category_model', 'category');
    $this->load->model('Product_model', 'product');
    harus_login();
  }



  public function save() {

    $name_products = strip_tags($this->input->post('name_products'), ENT_QUOTES);
    $code_products = strip_tags($this->input->post('code_products'), ENT_QUOTES);
    $id_categories = strip_tags($this->input->post('id_categories'));
    $stock_products = strip_tags($this->input->post('stock_products'));
    $weight_products = strip_tags($this->input->post('weight_products'));
    $dsc = $this->input->post('dsc');
    $price_products = strip_tags($this->input->post('price_products'));
    $discount_products = strip_tags($this->input->post('discount_products'));
    $price_total_products = strip_tags($this->input->post('price_total_products'));
    $slug_products = $this->input->post('slug_products');

    $this->form_validation->set_rules('name_products', 'Name_product', 'trim|required|min_length[2]',
      [
        'required' => 'Nama Produk harus diisi!',
        'min_length' => 'Nama Produk terlalu pendek!'
      ]);
    $this->form_validation->set_rules('code_products', 'Code product', 'trim|required',
      [
        'required' => 'Kode Produk harus diisi!'
      ]);
    $this->form_validation->set_rules('id_categories', 'Id Categories', 'trim|required',
      [
        'required' => 'Kategori Produk harus diisi!'
      ]);
    $this->form_validation->set_rules('dsc', 'Description product', 'trim|required|min_length[10]',
      [
        'required' => 'Deskripsi Produk harus diisi!',
        'min_length' => 'Deskripsi Produk terlalu pendek!'
      ]);
    $this->form_validation->set_rules('price_products', 'Price product', 'trim|required',
      [
        'required' => 'Harga Produk harus diisi!'
      ]);
    $this->form_validation->set_rules('weight_products', 'Weight product', 'trim|required',
      [
        'required' => 'Berat Produk harus diisi!'
      ]);
    $this->form_validation->set_rules('stock_products', 'Stock product', 'trim|required',
      [
        'required' => 'Stok Produk harus diisi!'
      ]);


    if ($this->form_validation->run() == FALSE) {
      $err = [
        'name_products' => form_error('name_products'),
        'code_products' => form_error('code_products'),
        'id_categories' => form_error('id_categories'),
        'dsc' => form_error('dsc'),
        'price_products' => form_error('price_products'),
        'weight_products' => form_error('weight_products'),
        'stock_products' => form_error('stock_products')
      ];
      echo json_encode(["status" => false, 'err' => $err]);
    } else
    {
      // STOREGE IMAGE FUNCTION
      $image = $_FILES['image_products']['name'];
      $extension = pathinfo($_FILES['image_products']['name'], PATHINFO_EXTENSION);

      if (!empty($image)) {
        $config['upload_path'] = './uploads/image/product/';
        $config['allowed_types'] = 'jpeg|jpg|png|gif';
        $config['max_size'] = '5048';
        $config['file_name'] = 'product_'.time().".{$extension}";

        $this->load->library('upload', $config);
        if ($this->upload->do_upload('image_products')) {
          //$data['image_products'] = $config['file_name'];
          $data = [
            'name_products' => $name_products,
            'description_products' => $dsc,
            'price_products' => $price_products,
            'discount_products' => $discount_products,
            'price_total_products' => $price_total_products,
            'weight_products' => $weight_products,
            'stock_products' => $stock_products,
            'code_products' => $code_products,
            'created_at_products' => time(),
            'image_products' => $config['file_name'],
            'slug_products' => $slug_products,
            'id_categories' => $id_categories,
          ];
          $insert = $this->product->save($data);
          echo json_encode(array("status" => TRUE));
        } else {
          $image_error = array('image_products' => $this->upload->display_errors());
          echo json_encode(["status" => false, 'err' => $image_error]);
        }
      } else {
        $image_error = array('image_products' => 'Gambar Produk Masih Kosong');
        echo json_encode(["status" => false, 'err' => $image_error]);
      }

    }

  }

  public function update() {
    $id_products = $this->input->post('id_products');
    $name_products = strip_tags($this->input->post('name_products'), ENT_QUOTES);
    $code_products = strip_tags($this->input->post('code_products'), ENT_QUOTES);
    $id_categories = strip_tags($this->input->post('id_categories'));
    $stock_products = strip_tags($this->input->post('stock_products'));
    $weight_products = strip_tags($this->input->post('weight_products'));
    $dsc = $this->input->post('dsc');
    $price_products = strip_tags($this->input->post('price_products'));
    $discount_products = strip_tags($this->input->post('discount_products'));
    $price_total_products = strip_tags($this->input->post('price_total_products'));
    $slug_products = $this->input->post('slug_products');

    $this->form_validation->set_rules('name_products', 'Name_product', 'trim|required|min_length[2]',
      [
        'required' => 'Nama Produk harus diisi!',
        'min_length' => 'Nama Produk terlalu pendek!'
      ]);
    $this->form_validation->set_rules('code_products', 'Code product', 'trim|required',
      [
        'required' => 'Kode Produk harus diisi!'
      ]);
    $this->form_validation->set_rules('id_categories', 'Id Categories', 'trim|required',
      [
        'required' => 'Kategori Produk harus diisi!'
      ]);
    $this->form_validation->set_rules('dsc', 'Description product', 'trim|required|min_length[10]',
      [
        'required' => 'Deskripsi Produk harus diisi!',
        'min_length' => 'Deskripsi Produk terlalu pendek!'
      ]);
    $this->form_validation->set_rules('price_products', 'Price product', 'trim|required',
      [
        'required' => 'Harga Produk harus diisi!'
      ]);
    $this->form_validation->set_rules('weight_products', 'Weight product', 'trim|required',
      [
        'required' => 'Berat Produk harus diisi!'
      ]);
    $this->form_validation->set_rules('stock_products', 'Stock product', 'trim|required',
      [
        'required' => 'Stok Produk harus diisi!'
      ]);


    if ($this->form_validation->run() == FALSE) {
      $err = [
        'name_products' => form_error('name_products'),
        'code_products' => form_error('code_products'),
        'id_categories' => form_error('id_categories'),
        'dsc' => form_error('dsc'),
        'price_products' => form_error('price_products'),
        'weight_products' => form_error('weight_products'),
        'stock_products' => form_error('stock_products')
      ];
      echo json_encode(["status" => false, 'err' => $err]);
    } else
    {

      $data = [
        'name_products' => $name_products,
        'description_products' => $dsc,
        'price_products' => $price_products,
        'discount_products' => $discount_products,
        'price_total_products' => $price_total_products,
        'weight_products' => $weight_products,
        'stock_products' => $stock_products,
        'code_products' => $code_products,
        'slug_products' => $slug_products,
        'id_categories' => $id_categories,
      ];

      $image = $_FILES['image_products']['name'];
      $extension = pathinfo($_FILES['image_products']['name'], PATHINFO_EXTENSION);

      if (!empty($image)) {
        $config['upload_path'] = './uploads/image/product/';
        $config['allowed_types'] = 'jpeg|jpg|png|gif';
        $config['max_size'] = '5048';
        $config['file_name'] = 'product_'.time().".{$extension}";

        $this->load->library('upload', $config);
        if ($this->upload->do_upload('image_products')) {
          $data['image_products'] = $config['file_name'];
          $old_image = $this->db->get_where('products', ['id_products' => $id_products])->row_array()['image_products'];
          if ($old_image != 'default_product.jpg') {
            $cek = file_exists(FCPATH."uploads/image/product/{$old_image}");
            if ($cek) {
              unlink(FCPATH."uploads/image/product/{$old_image}");
            }
          }
        } else {
          $image_error = array('image_products' => $this->upload->display_errors());
          echo json_encode(["status" => false, 'err' => $image_error]);
        }
      } else {}

      $this->product->update(['id_products' => $id_products], $data);
      echo json_encode(array("status" => TRUE));

    }

  }


  public function ajax_delete($id) {
    $image_product = $this->product->get_by_id($id);
    unlink(FCPATH.'uploads/image/product/'.$image_product->image_products);
    $this->product->delete_by_id($id);
    echo json_encode(["status" => TRUE]);
  }

  public function ajaxList() {
    $list = $this->product->get_datatables();
    $data = [];
    $no = $_POST['start'];
    foreach ($list as $ls) {
      $no++;
      $row = [];
      //$row[] = $no;
      $row[] = '<img src="'.base_url('uploads/image/product/').$ls->image_products.'" alt="gambar '.$ls->name_products.'" class="img-thumbnail" width="100" />';
      $row[] = $ls->name_products;
      $row[] = $ls->name_categories;
      $row[] = $ls->price_products;
      $row[] = $ls->stock_products;

      $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit"
             onclick="edit('."'".$ls->id_products."'".')"><i class="fa fa-edit"></i></a><a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus"
                  onclick="delete_product('."'".$ls->id_products."'".','."'".$ls->name_products."'".')"><i class="fa fa-trash"></i></a><a class="btn btn-sm btn-info" href="javascript:void(0)" title="Detail"
             onclick="detail('."'".$ls->slug_products."'".')"><i class="fa fa-eye"></i></a>';
      $data[] = $row;
    }

    $output = [
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->product->count_all(),
      "recordsFiltered" => $this->product->count_filtered(),
      "data" => $data,
    ];
    echo json_encode($output);
  }

  public function ajax_edit($id) {
    $data = $this->product->get_by_id($id);
    echo json_encode($data);
  }

  public function category_ajax() {
    $category = $this->category->get();
    echo json_encode($category);
  }




}