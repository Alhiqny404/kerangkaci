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
    $data['role'] = $this->db->get('role')->result_array();
    $data['title'] = 'Data User';
    $this->load->view('master/user', $data);
  }


  public function status() {
    $id = $this->input->post('id');
    $status = $this->input->post('status');


    if ($status == 1) {
      $status = 0;
      $this->user->update(['id' => $id], ['is_active' => $status]);
      echo json_encode(array("status" => TRUE));
    } else
    {
      $status = 1;
      $this->user->update(['id' => $id], ['is_active' => $status]);
      echo json_encode(array("status" => TRUE));
    }

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
      $row[] = '<img src="'.base_url("uploads/image/profile/".$ls->avatar).'" width="70px">';
      $row[] = $ls->role;
      $row[] = date('d-m-Y', $ls->created_at);
      if ($ls->is_active == 1) {

        $row[] = '<div class="custom-checkbox custom-control"><input type="checkbox" checked="checked" data-checkboxes="mygroup" class="custom-control-input" id="'.$ls->id.'" onclick="coba('."'".$ls->id."'".','."'".$ls->is_active."'".')"><label for="'.$ls->id.'" class="custom-control-label">&nbsp;</label></div>';

      } else
      {
        $row[] = '<div class="custom-checkbox custom-control"><input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="'.$ls->id.'" onclick="coba('."'".$ls->id."'".','."'".$ls->is_active."'".')"><label for="'.$ls->id.'" class="custom-control-label">&nbsp;</label></div>';
      }


      //add html for action
      $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit"
        onclick="edit('."'".$ls->id."'".')"><i class="fa fa-edit"></i></a><a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus"
        onclick="delete_user('."'".$ls->id."'".','."'".$ls->nama."'".')"><i class="fa fa-trash"> </i></a><a class="btn btn-sm btn-info" href="javascript:void(0)" title="detail"
        onclick=""><i class="fa fa-eye"></i></a>';


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


    $this->form_validation->set_rules('nama', 'Nama', 'trim|required|min_length[2]',
      [
        'required' => 'nama harus diisi!',
        'min_length' => 'naman terlalu pendek!'
      ]);
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]',
      [
        'required' => 'email harus diisi!',
        'valid_email' => 'masukan email yang benar',
        'is_unique' => 'email ini telah digunakan'

      ]);
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[2]',
      [
        'required' => 'password harus diisi!',
        'min_length' => 'password terlalu pendek!'
      ]);
    $this->form_validation->set_rules('role_id', 'Role_id', 'trim|required',
      [
        'required' => 'role harus dipilih!'
      ]);



    if ($this->form_validation->run() == FALSE) {
      $err = [
        'nama' => form_error('nama'),
        'email' => form_error('email'),
        'password' => form_error('password'),
        'role_id' => form_error('role_id')
      ];
      echo json_encode(["status" => FALSE, 'err' => $err]);
    } else
    {

      $data = array(
        'nama' => htmlspecialchars($this->input->post('nama'), true),
        'email' => htmlspecialchars($this->input->post('email'), true),
        'avatar' => 'avatar.png',
        'password' => htmlspecialchars(password_hash($this->input->post('password'), PASSWORD_DEFAULT)),
        'limit_salah' => 0,
        'is_active' => 1,
        'role_id' => htmlspecialchars($this->input->post('role_id'), true),
        'created_at' => time()
      );

      $insert = $this->user->save($data);
      echo json_encode(array("status" => TRUE));
    }






  }
  public function ajax_update() {


    $this->form_validation->set_rules('nama', 'Nama', 'trim|required|min_length[2]',
      [
        'required' => 'nama harus diisi!',
        'min_length' => 'naman terlalu pendek!'
      ]);
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email',
      [
        'required' => 'email harus diisi!',
        'valid_email' => 'masukan email yang benar',
        'is_unique' => 'email ini telah digunakan'

      ]);
    $this->form_validation->set_rules('role_id', 'Role_id', 'trim|required',
      [
        'required' => 'role harus dipilih!'
      ]);



    if ($this->form_validation->run() == FALSE) {
      $err = [
        'nama' => form_error('nama'),
        'email' => form_error('email'),
        'role_id' => form_error('role_id')
      ];
      echo json_encode(["status" => FALSE, 'err' => $err]);
    } else
    {

      $data = array(
        'nama' => htmlspecialchars($this->input->post('nama'), true),
        'email' => htmlspecialchars($this->input->post('email'), true),
        'role_id' => htmlspecialchars($this->input->post('role_id'), true)
      );
      $this->user->update(array('id' => $this->input->post('id')), $data);
      echo json_encode(array("status" => TRUE));
    }


  }
  public function ajax_delete($id) {
    $this->user->delete_by_id($id);
    echo json_encode(array("status" => TRUE));
  }





}