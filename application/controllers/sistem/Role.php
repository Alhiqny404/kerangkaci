<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends CI_Controller {



  public function __construct() {

    parent::__construct();
    $this->load->model('Submenu_model', 'submenu');
    $this->load->model('Role_Model', 'role');
    $this->load->model('MenuAccess_Model', 'access');
    harus_login();
    akses_submenu();
  }

  // halaman utama
  public function index() {
    $data['role'] = $this->db->get('role')->result_array();
    $page = 'sistem/role';
    $data['title'] = 'Role';
    pages($page, $data);
  }

  public function menu_access($id) {
    $menu = $this->db->get_where('menu')->result();
    $i = 1;
    foreach ($menu as $m) {
      $row[] = "<tr>";
      $row[] = "<td>".$i++."</td><td>{$m->menu}</td><label class=\"custom-switch mt-2\"></td>";
      $this->db->where('role_id', $id);
      $this->db->where('menu_id', $m->id);
      $return = $this->db->get('role_menu');
      $return->num_rows() > 0 ?
      $row[] = '<td><label><input type="checkbox" name="custom-switch-checkbox" checked="checked" class="custom-switch-input" onclick="changeAccess('."'".$m->id."'".','."'".$id."'".')"> <span class="custom-switch-indicator"></span></label></tr>':
      $row[] = '<td><label><input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" onclick="changeAccess('."'".$m->id."'".','."'".$id."'".')"> <span class="custom-switch-indicator"></span></label></tr>';
      $row[] = "</tr>";




    }
    echo json_encode($row);
  }

  // proses ubah akses
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


  // data ajax untuk halaman utama
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
             onclick="edit('."'".$ls->id."'".')"><i class="fa fa-edit"></i> Edit</a> <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus"
                  onclick="delete_role('."'".$ls->id."'".','."'".$ls->role."'".')"><i class="fa fa-trash"></i> Hapus</a> <a class="btn btn-sm btn-warning" href="javascript:void(0)"
                  onclick="modal_access('."'".$ls->id."'".','."'".$ls->role."'".')"><i class="fa fa-universal-access"></i>Akses Menu</a> ';

      $data[] = $row;
    }

    $output = [
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->role->count_all(),
      "recordsFiltered" => $this->role->count_filtered(),
      "data" => $data,
    ];
    echo json_encode($output);
  }
  public function ajax_edit($id) {
    $data = $this->role->get_by_id($id);
    echo json_encode($data);
  }


  private function _set_validate() {
    $this->form_validation->set_rules('role',
      'Role',
      'required|min_length[3]',
      [
        'required' => 'role tidak boleh kosong',
        'min_length' => 'nama role terlalu pendek'
      ]
    );
  }


  // insert data
  public function ajax_add() {

    $this->_set_validate();

    if ($this->form_validation->run() == FALSE) {
      $errors = validation_errors();
      echo json_encode(["status" => FALSE, 'errors' => $errors]);
    } else
    {
      $data = ['role' => htmlspecialchars($this->input->post('role'), true)];
      $insert = $this->role->save($data);
      echo json_encode(["status" => TRUE]);
    }
  }

  // update data
  public function ajax_update() {
    $this->_set_validate();

    if ($this->form_validation->run() == FALSE) {
      $errors = validation_errors();
      echo json_encode(["status" => FALSE, 'errors' => $errors]);
    } else
    {
      $data = ['role' => $this->input->post('role')];
      $this->role->update(['id' => $this->input->post('id')], $data);
      echo json_encode(["status" => TRUE]);
    }

  }

  // delete data
  public function ajax_delete($id) {
    $this->db->delete('user', ['role_id' => $id]);
    $this->role->delete_by_id($id);
    echo json_encode(["status" => TRUE]);
  }



}