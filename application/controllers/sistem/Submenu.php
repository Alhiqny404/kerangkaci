<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Submenu extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Submenu_model', 'submenu');
    harus_login();
  }


  public function index() {
    $data['menu'] = $this->db->get_where('menu', ['tipe' => 2])->result_array();
    $page = 'menu/submenu';
    $data['title'] = 'Sub Menu';
    pages($page, $data);
  }

  public function ajaxList() {
    $list = $this->submenu->get_datatables();
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

      //add html for action
      $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit"
             onclick="edit('."'".$ls->id."'".')"><i class="fa fa-edit"></i> edit</a><a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus"
                  onclick="delete_submenu('."'".$ls->id."'".','."'".$ls->title."'".')"><i class="fa fa-trash"> hapus</i></a>';

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

  public function ajax_edit($id) {
    $data = $this->submenu->get_by_id($id);
    echo json_encode($data);
  }

  public function ajax_add() {
    $data = [
      'menu_id' => htmlspecialchars($this->input->post('menu_id')),
      'title' => htmlspecialchars($this->input->post('title')),
      'icon' => htmlspecialchars($this->input->post('icon')),
      'url' => htmlspecialchars($this->input->post('url')),
    ];
    $insert = $this->submenu->save($data);
    echo json_encode(array("status" => TRUE));
  }

  public function ajax_update() {
    $data = [
      'menu_id' => htmlspecialchars($this->input->post('menu_id')),
      'title' => htmlspecialchars($this->input->post('title')),
      'icon' => htmlspecialchars($this->input->post('icon')),
      'url' => htmlspecialchars($this->input->post('url')),
    ];
    $this->submenu->update(['id' => $this->input->post('id')], $data);
    echo json_encode(array("status" => TRUE));
  }

  public function ajax_delete($id) {
    $this->submenu->delete_by_id($id);
    echo json_encode(array("status" => TRUE));
  }







}