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
    //pages($page, $data);
    $this->load->view('admin/role', $data);
  }

  public function akses($id) {

    $data['role'] = $this->db->get_where('role', ['id' => $id])->row_array();
    $data['menu'] = $this->db->get('menu')->result_array();
    $page = 'admin/access-role';
    $data['title'] = 'Role';
    pages($page, $data);
  }


  public function changeAccess() {
    $menuId = $this->input->post('menuId');
    $roleId = $this->input->post('roleId');
    $data = [
      'role_id' => $roleId,
      'menu_id' => $menuId
    ];
    $result = $this->db->get_where('role_menu', $data);

    if ($result->num_rows() < 1) {
      $this->db->insert('role_menu', $data);
    } else {
      $this->db->delete('role_menu', $data);
    }

  }


  public function ajaxList() {
    $list = $this->role->get_datatables();
    $data = [];
    $no = $_POST['start'];
    foreach ($list as $ls) {
      $no++;
      $row = [];
      $row[] = '<div class="custom-checkbox custom-control"><input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="'.$ls->id.'"><label for="'.$ls->id.'" class="custom-control-label">&nbsp;</label></div>';
      $row[] = $no;
      $row[] = $ls->role;

      //add html for action
      $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit"
             onclick="edit('."'".$ls->id."'".')"><i class="fa fa-edit"></i></a> <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus"
                  onclick="delete_role('."'".$ls->id."'".','."'".$ls->role."'".')"><i class="fa fa-trash"></i></a> <a class="btn btn-sm btn-warning" href="javascript:void(0)"
                  onclick="akses('."'".$ls->id."'".')"><i class="fa fa-universal-access"></i></a>';

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



    $this->form_validation->set_rules('role', 'Role', 'required|min_length[3]',
      [
        'required' => 'role tidak boleh kosong',
        'min_length' => 'nama role terlalu pendek'
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


  }
  public function ajax_update() {


    $this->form_validation->set_rules('role', 'Role', 'required|min_length[3]',
      [
        'required' => 'role tidak boleh kosong',
        'min_length' => 'nama role terlalu pendek'
      ]
    );

    if ($this->form_validation->run() == FALSE) {
      $errors = validation_errors();
      echo json_encode(["status" => FALSE, 'errors' => $errors]);
    } else
    {
      $data = ['role' => $this->input->post('role')];
      $this->role->update(array('id' => $this->input->post('id')), $data);
      echo json_encode(array("status" => TRUE));
    }

  }
  public function ajax_delete($id) {
    $this->role->delete_by_id($id);
    echo json_encode(array("status" => TRUE));
  }



}