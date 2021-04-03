<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Submenu extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Submenu_model', 'submenu');
    harus_login();
    akses_submenu();
  }


  public function index() {
    $data['menu'] = $this->db->get_where('menu', ['tipe' => 2])->result_array();
    $page = 'menu/submenu';
    $data['title'] = 'Sub Menu';
    $this->load->view('menu/submenu', $data);
  }

  public function status() {

    $id = $this->input->post('id');
    $status = $this->db->get_where('sub_menu', ['id' => $id])->row_array()['is_active'];
    if ($status == 1) {
      $this->db->update('sub_menu', ['is_active' => 0], ['id' => $id]);
    } else {
      $this->db->update('sub_menu', ['is_active' => 1], ['id' => $id]);
    }
    echo json_encode(['status' => true]);
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
      $row[] = site_url().$ls->url;
      $ls->is_active > 0 ?

      $row[] = '<div class="form-check"><input class="form-check-input" checked="checked" onclick="status('."'".$ls->id."'".')" type="checkbox" value="" id="defaultCheck1"></div>'
      : $row[] = '<div class="form-check"><input class="form-check-input" onclick="status('."'".$ls->id."'".')" type="checkbox" value="" id="defaultCheck1"></div>';

      //add html for action
      $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit"
             onclick="edit('."'".$ls->id."'".')"><i class="fas fa-edit"></i> edit</a><a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus"
                  onclick="delete_submenu('."'".$ls->id."'".','."'".$ls->title."'".')"><i class="fas fa-trash"> hapus</i></a>';

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

    $this->form_validation->set_rules('menu_id', 'Menu_id', 'required',
      [
        'required' => 'menu tidak boleh kosong',
        'min_length' => 'nama menu terlalu pendek'
      ]
    );
    $this->form_validation->set_rules('title', 'Title', 'required|min_length[3]',
      [
        'required' => 'title tidak boleh kosong',
        'min_length' => 'nama title terlalu pendek'
      ]
    );
    $this->form_validation->set_rules('icon', 'Icon', 'required|min_length[3]',
      [
        'required' => 'icon tidak boleh kosong',
        'min_length' => 'nama icon terlalu pendek'
      ]
    );
    $this->form_validation->set_rules('url', 'Url', 'required',
      [
        'required' => 'tipe tidak boleh kosong'
      ]
    );

    if ($this->form_validation->run() == FALSE) {
      $err = [
        'menu_id' => form_error('menu_id'),
        'title' => form_error('title'),
        'icon' => form_error('icon'),
        'url' => form_error('url')
      ];
      echo json_encode(["status" => FALSE, 'err' => $err]);
    } else
    {
      $data = [
        'menu_id' => htmlspecialchars($this->input->post('menu_id'), true),
        'title' => htmlspecialchars($this->input->post('title'), true),
        'icon' => htmlspecialchars($this->input->post('icon'), true),
        'url' => htmlspecialchars($this->input->post('url'), true),
      ];
      $insert = $this->submenu->save($data);
      echo json_encode(array("status" => TRUE));
    }




  }

  public function ajax_update() {

    $this->form_validation->set_rules('menu_id', 'Menu_id', 'required',
      [
        'required' => 'menu tidak boleh kosong',
        'min_length' => 'nama menu terlalu pendek'
      ]
    );
    $this->form_validation->set_rules('title', 'Title', 'required|min_length[3]',
      [
        'required' => 'title tidak boleh kosong',
        'min_length' => 'nama title terlalu pendek'
      ]
    );
    $this->form_validation->set_rules('icon', 'Icon', 'required|min_length[3]',
      [
        'required' => 'icon tidak boleh kosong',
        'min_length' => 'nama icon terlalu pendek'
      ]
    );
    $this->form_validation->set_rules('url', 'Url', 'required',
      [
        'required' => 'tipe tidak boleh kosong'
      ]
    );

    if ($this->form_validation->run() == FALSE) {
      $err = [
        'menu_id' => form_error('menu_id'),
        'title' => form_error('title'),
        'icon' => form_error('icon'),
        'url' => form_error('url')
      ];
      echo json_encode(["status" => FALSE, 'err' => $err]);
    } else
    {
      $data = [
        'menu_id' => htmlspecialchars($this->input->post('menu_id'), true),
        'title' => htmlspecialchars($this->input->post('title'), true),
        'icon' => htmlspecialchars($this->input->post('icon'), true),
        'url' => htmlspecialchars($this->input->post('url'), true),
      ];
      $this->submenu->update(['id' => $this->input->post('id')], $data);
      echo json_encode(array("status" => TRUE));
    }

  }

  public function ajax_delete($id) {
    $this->submenu->delete_by_id($id);
    echo json_encode(array("status" => TRUE));
  }







}