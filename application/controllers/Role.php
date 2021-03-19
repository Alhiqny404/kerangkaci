<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {



  public function __construct() {
    parent::__construct();
    $this->load->model('Submenu_model', 'submenu');
    $this->load->model('Role_Model', 'role');
    harus_login();
  }

  public function index() {
    $data['role'] = $this->db->get('role')->result_array();
    $page = 'admin/role';
    $data['title'] = 'Role';
    pages($page, $data);
  }

  public function ajaxList() {
    $list = $this->role->get_datatables();
    $data = [];
    $no = $_POST['start'];
    foreach ($list as $ls) {
      $no++;
      $row = [];
      $row[] = $no;
      $row[] = $ls->role;

      //add html for action
      $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit"
             onclick="edit('."'".$ls->id."'".')"><i class="fa fa-edit"></i> edit</a><a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus"
                  onclick="delete_role('."'".$ls->id."'".','."'".$ls->role."'".')"><i class="fa fa-trash"> hapus</i></a>';

      $data[] = $row;
    }

    $output = [
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->role->count_all(),
      "recordsFiltered" => $this->role->count_filtered(),
      "data" => $data,
    ];
    //output to json format
    echo json_encode($output);
  }
  public function ajax_edit($id) {
    $data = $this->role->get_by_id($id);
    echo json_encode($data);
  }
  public function ajax_add() {
    $data = array(
      'role' => $this->input->post('role')
    );

    $insert = $this->role->save($data);
    echo json_encode(array("status" => TRUE));
  }
  public function ajax_update() {
    $data = array(
      'role' => $this->input->post('role')
    );
    $this->role->update(array('id' => $this->input->post('id')), $data);
    echo json_encode(array("status" => TRUE));
  }
  public function ajax_delete($id) {
    $this->role->delete_by_id($id);
    echo json_encode(array("status" => TRUE));
  }



}