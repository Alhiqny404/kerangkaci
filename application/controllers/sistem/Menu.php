<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Menu_model', 'menu');
    harus_login();
  }

  public function index() {
    $page = 'menu/index';
    $data['title'] = 'Menu Group';
    $this->load->view('menu/index', $data);
  }


  public function urutan() {
    $page = 'menu/urutan_menu';
    $data['menu'] = $this->db->get('menu')->result_array();
    $data['title'] = 'Urutan Menu';
    $this->load->view('menu/urutan_menu', $data);
  }

  public function naikan() {
    $id = $this->input->post('id');
    $urutan = $this->input->post('urutan');
    if ($urutan == 1) {
      echo json_encode(array("status" => TRUE));
    } else {
      $this->db->update('menu', ['urutan' => $urutan], ['urutan' => $urutan-1]);
      $data = array(
        'urutan' => $urutan-1
      );
      $this->menu->update(array('id' => $id), $data);
      echo json_encode(array("status" => TRUE));
    }
  }


  public function turunkan() {
    $id = $this->input->post('id');
    $urutan = $this->input->post('urutan');
    $this->db->update('menu', ['urutan' => $urutan], ['urutan' => $urutan+1]);
    $data = array(
      'urutan' => $urutan+1
    );
    $this->menu->update(array('id' => $id), $data);
    echo json_encode(array("status" => TRUE));
  }



  public function ajaxUrutan() {
    $list = $this->menu->get_datatables();
    $data = [];
    $no = $_POST['start'];
    foreach ($list as $ls) {
      $no++;
      $row = [];
      $row[] = $ls->urutan;
      $row[] = $ls->menu;
      $row[] = '<button class="btn btn-sm btn-success" onclick="naikan('."'".$ls->id."'".','."'".$ls->urutan."'".')">Naikan</button> <button class="btn btn-sm btn-danger" onclick="turunkan('."'".$ls->id."'".','."'".$ls->urutan."'".')">Turunkan</button>';

      $data[] = $row;
    }

    $output = [
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->menu->count_all(),
      "recordsFiltered" => $this->menu->count_filtered(),
      "data" => $data,
    ];
    //output to json format
    echo json_encode($output);
  }

  public function ajaxList() {
    $list = $this->menu->get_datatables();
    $data = [];
    $no = $_POST['start'];
    foreach ($list as $ls) {
      $no++;
      $row = [];
      $row[] = $ls->urutan;
      $row[] = $ls->menu;
      $row[] = $ls->title;
      $row[] = $ls->icon;
      if ($ls->tipe == 1) {
        $row[] = 'biasa';
      } else {
        $row[] = 'dropdown';
      }

      //add html for action
      $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit"
             onclick="edit('."'".$ls->id."'".')"><i class="fa fa-edit"></i> edit</a><a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus"
                  onclick="delete_menu('."'".$ls->id."'".','."'".$ls->menu."'".')"><i class="fa fa-trash"> hapus</i></a>';


      $data[] = $row;
    }

    $output = [
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->menu->count_all(),
      "recordsFiltered" => $this->menu->count_filtered(),
      "data" => $data,
    ];
    //output to json format
    echo json_encode($output);
  }
  public function ajax_edit($id) {
    $data = $this->menu->get_by_id($id);
    echo json_encode($data);
  }
  public function ajax_add() {


    $this->form_validation->set_rules('memu', 'Menu', 'required|min_length[3]',
      [
        'required' => 'role tidak boleh kosong',
        'min_length' => 'nama role terlalu pendek'
      ]
    );
    $this->form_validation->set_rules('title', 'Title', 'required|min_length[3]',
      [
        'required' => 'role tidak boleh kosong',
        'min_length' => 'nama role terlalu pendek'
      ]
    );
    $this->form_validation->set_rules('icon', 'Icon', 'required|min_length[3]',
      [
        'required' => 'role tidak boleh kosong',
        'min_length' => 'nama role terlalu pendek'
      ]
    );
    $this->form_validation->set_rules('tipe', 'Tipe', 'required',
      [
        'required' => 'role tidak boleh kosong'
      ]
    );

    if ($this->form_validation->run() == FALSE) {
      $errors = validation_errors();
      echo json_encode(["status" => FALSE, 'errors' => $errors]);
    } else
    {
      $data = ['role' => $this->input->post('role')];
      $insert = $this->role->save($data);
      echo json_encode(["status" => TRUE]);
    }





    $data = array(
      'menu' => $this->input->post('menu'),
      'title' => $this->input->post('title'),
      'icon' => $this->input->post('icon'),
      'tipe' => $this->input->post('tipe')
    );

    $insert = $this->menu->save($data);
    echo json_encode(array("status" => TRUE));
  }
  public function ajax_update() {
    $data = array(
      'menu' => $this->input->post('menu'),
      'title' => $this->input->post('title'),
      'icon' => $this->input->post('icon'),
      'tipe' => $this->input->post('tipe')
    );
    $this->menu->update(array('id' => $this->input->post('id')), $data);
    echo json_encode(array("status" => TRUE));
  }
  public function ajax_delete($id) {
    $this->menu->delete_by_id($id);
    echo json_encode(array("status" => TRUE));
  }





}