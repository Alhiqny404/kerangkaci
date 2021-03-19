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
    pages($page, $data);
  }
  public function tambah() {
    $data = ['menu' => $this->input->post('menu')];
    $this->db->insert('menu', $data);

    redirect('menu');
  }
  public function submenu() {
    //    $data['submenu'] = $this->menu->getSubMenu();
    $data['menu'] = $this->menu->getMenu();
    $data['submenu'] = $this->submenu->getSubMenu();
    $page = 'menu/submenu';
    $data['title'] = 'Sub Menu';
    pages($page, $data);
  }
  public function submenuAdd() {
    var_dump($this->input->post());
    $data = [
      'menu_id' => $this->input->post('menu_id'),
      'title' => $this->input->post('title'),
      'icon' => $this->input->post('icon'),
      'url' => $this->input->post('url')
    ];
    $this->db->insert('sub_menu', $data);
    redirect('menu/submenu');
  }
  public function submenuAjax() {
    $list = $this->submenu->get_datatables();
    $data = [];
    $no = $_POST['start'];
    foreach ($list as $ls) {
      $no++;
      $row = [];
      $row[] = $no;
      $row[] = $ls->menu_id;
      $row[] = $ls->title;
      $row[] = $ls->icon;
      $row[] = $ls->url;

      //add html for action
      $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit"
             onclick="edit('."'".$ls->id."'".')"><i class="fa fa-edit"></i> edit</a><a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus"
                  onclick="delete('."'".$ls->id."'".','."'".$ls->title."'".')"><i class="fa fa-trash"> hapus</i></a>';

      $data[] = $row;
    }

    $output = [
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->submenu->count_all(),
      "recordsFiltered" => $this->submenu->count_filtered(),
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
      $row[] = $no;
      $row[] = $ls->menu;
      $row[] = $ls->title;
      $row[] = $ls->icon;
      $row[] = $ls->url;
      $row[] = $ls->tipe;

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
    $data = array(
      'menu' => $this->input->post('menu')
    );

    $insert = $this->menu->save($data);
    echo json_encode(array("status" => TRUE));
  }
  public function ajax_update() {
    $data = array(
      'menu' => $this->input->post('menu')
    );
    $this->menu->update(array('id' => $this->input->post('id')), $data);
    echo json_encode(array("status" => TRUE));
  }
  public function ajax_delete($id) {
    $this->menu->delete_by_id($id);
    echo json_encode(array("status" => TRUE));
  }





}