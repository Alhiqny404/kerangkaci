<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {



  public function __construct() {
    parent::__construct();
    $this->load->model('Submenu_model', 'submenu');
    $this->load->model('Role_Model', 'role');
    harus_login();
  }

  public function index() {
    $email = $this->session->userdata('email');
    $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
    $page = 'admin/dashboard';
    $data['title'] = 'Dashboard';
    //$this->load->view('admin/dashboard', $data);
    pages($page, $data);
  }
  /*
  public function role() {
    $data['role'] = $this->db->get('role')->result_array();
    $page = 'admin/role';
    $data['title'] = 'Role';
    pages($page, $data);
  }
*/
  public function addRole() {
    $data = ['role' => $this->input->post('role')];
    $this->db->insert('role', $data);
    redirect('admin/role');
  }

  public function access_role($roleId) {
    $data['role'] = $this->db->get_where('role', ['id' => $roleId])->row_array();

    $data['menu'] = $this->db->get_where('menu', ['id !=' => 1])->result_array();
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



  public function roleAjax() {
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
                  onclick="delete('."'".$ls->id."'".','."'".$ls->role."'".')"><i class="fa fa-trash"> hapus</i></a>';

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



}