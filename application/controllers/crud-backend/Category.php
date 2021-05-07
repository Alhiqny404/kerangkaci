<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Category_model', 'category');
    harus_login();
  }

  public function index() {
    $page = 'backend/categories';
    $data['title'] = 'Data Kategori';
    pages($page, $data);
  }



  public function ajaxList() {
    $list = $this->category->get_datatables();
    $data = [];
    $no = $_POST['start'];
    foreach ($list as $ls) {
      $no++;
      $row = [];
      $row[] = $no;
      $row[] = $ls->name_categories;
      $row[] = $ls->slug_categories;

      $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit"
             onclick="edit('."'".$ls->id_categories."'".')"><i class="fa fa-edit"></i> edit</a><a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus"
                  onclick="delete_category('."'".$ls->id_categories."'".','."'".$ls->name_categories."'".')"><i class="fa fa-trash"> hapus</i></a>';
      $data[] = $row;
    }

    $output = [
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->category->count_all(),
      "recordsFiltered" => $this->category->count_filtered(),
      "data" => $data,
    ];
    echo json_encode($output);
  }


  public function ajax_edit($id) {
    $data = $this->category->get_by_id($id);
    echo json_encode($data);
  }
  public function ajax_add() {

    $this->form_validation->set_rules('name_categories', 'Name categories', 'trim|required|min_length[2]',
      [
        'required' => 'nama kategori harus diisi!',
        'min_length' => 'nama kategori terlalu pendek!'
      ]);
    $this->form_validation->set_rules('slug_categories', 'Slug categories', 'trim|required',
      [
        'required' => 'slug harus diisi!'

      ]);



    if ($this->form_validation->run() == FALSE) {
      $err = [
        'name_categories' => form_error('name_categories'),
        'slug_categories' => form_error('slug_categories')
      ];
      echo json_encode(["status" => FALSE, 'err' => $err]);
    } else
    {

      $data = array(
        'name_categories' => htmlspecialchars($this->input->post('name_categories'), true),
        'slug_categories' => htmlspecialchars($this->input->post('slug_categories'), true)

      );

      $insert = $this->category->save($data);
      echo json_encode(array("status" => TRUE));
    }






  }
  public function ajax_update() {

    $this->form_validation->set_rules('name_categories', 'Name categories', 'trim|required|min_length[2]',
      [
        'required' => 'nama kategori harus diisi!',
        'min_length' => 'nama kategori terlalu pendek!'
      ]);
    $this->form_validation->set_rules('slug_categories', 'Slug categories', 'trim|required',
      [
        'required' => 'slug harus diisi!'

      ]);


    if ($this->form_validation->run() == FALSE) {
      $err = [
        'name_categories' => form_error('name_categories'),
        'slug_categories' => form_error('slug_categories')
      ];
      echo json_encode(["status" => FALSE, 'err' => $err]);
    } else
    {

      $data = array(
        'name_categories' => htmlspecialchars($this->input->post('name_categories'), true),
        'slug_categories' => htmlspecialchars($this->input->post('slug_categories'), true)

      );
      $this->category->update(array('id_categories' => $this->input->post('id_categories')), $data);
      echo json_encode(array("status" => TRUE));
    }


  }
  public function ajax_delete($id) {
    $this->category->delete_by_id($id);
    echo json_encode(["status" => TRUE]);
  }





}