<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('User_model', 'user');
    harus_login();
  }

  public function index() {
    $page = 'master/user';
    $data['title'] = 'Data User';
    pages($page, $data);
  }


  public function ajaxList() {
    $list = $this->user->get_datatables();
    $data = [];
    $no = $_POST['start'];
    foreach ($list as $ls) {
      $no++;
      $row = [];
      $row[] = $no;
      $row[] = $ls->nama;
      $row[] = $ls->email;

      //add html for action
      $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit"
             onclick="edit('."'".$ls->id."'".')"><i class="fa fa-edit"></i> edit</a><a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus"
                  onclick="delete_user('."'".$ls->id."'".','."'".$ls->nama."'".')"><i class="fa fa-trash"> hapus</i></a>';


      $data[] = $row;
    }

    $output = [
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->user->count_all(),
      "recordsFiltered" => $this->user->count_filtered(),
      "data" => $data,
    ];
    //output to json format
    echo json_encode($output);
  }
  public function ajax_edit($id) {
    $data = $this->user->get_by_id($id);
    echo json_encode($data);
  }
  public function ajax_add() {
    $data = array(
      'user' => $this->input->post('nama'),
      'title' => $this->input->post('email')
    );

    $insert = $this->user->save($data);
    echo json_encode(array("status" => TRUE));
  }
  public function ajax_update() {
    $data = array(
      'user' => $this->input->post('nama'),
      'title' => $this->input->post('email')
    );
    $this->user->update(array('id' => $this->input->post('id')), $data);
    echo json_encode(array("status" => TRUE));
  }
  public function ajax_delete($id) {
    $this->user->delete_by_id($id);
    echo json_encode(array("status" => TRUE));
  }





}