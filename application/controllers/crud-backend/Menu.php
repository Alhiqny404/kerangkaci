<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Menu_model', 'menu');
    harus_login();
    akses_submenu();
  }


  // HALAMAN PENGORDERAN MENU
  public function urutan() {
    $page = 'menu/urutan_menu';
    $data['menu'] = $this->menu->result_array();
    $data['title'] = 'Urutan Menu';
    $page = 'sistem/order_menu';
    pages($page, $data);
  }

  // FUNGSI MENAIKAN URUTAN MENU
  public function naikan() {
    $id = $this->input->post('id');
    $urutan = $this->input->post('urutan');
    if ($urutan == 1) {
      echo json_encode(array("status" => TRUE));
    } else {

      $this->menu->update(['urutan' => $urutan-1], ['urutan' => $urutan]);
      //$this->db->update('menu', ['urutan' => $urutan], ['urutan' => $urutan-1]);
      $data = array(
        'urutan' => $urutan-1
      );
      $this->menu->update(array('id' => $id), $data);
      echo json_encode(array("status" => TRUE));
    }
  }

  // FUNGSI MENURUNKAN URUTAN MENU
  public function turunkan() {
    $id = $this->input->post('id');
    $urutan = $this->input->post('urutan');

    $this->menu->update(['urutan' => $urutan+1], ['urutan' => $urutan]);
    // $this->db->update('menu', ['urutan' => $urutan], ['urutan' => $urutan+1]);
    $data = array(
      'urutan' => $urutan+1
    );
    $this->menu->update(array('id' => $id), $data);
    echo json_encode(array("status" => TRUE));
  }


  /* ------------  GET DATA JSON   -----------------*/

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
    echo json_encode($output);
  }



  /*-----------  CREATE - UPDATE - DELETE  ---------------- */


  // SET VALIDASI
  private function _set_validate() {
    $this->form_validation->set_rules('menu', 'Menu', 'required|min_length[3]|is_unique[menu.menu]',
      [
        'required' => 'menu tidak boleh kosong',
        'min_length' => 'nama menu terlalu pendek',
        'is_unique' => 'Menu sudah ada'
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
    $this->form_validation->set_rules('tipe', 'Tipe', 'required',
      [
        'required' => 'tipe tidak boleh kosong'
      ]
    );
  }


  // VIEW MODAL EDIT
  public function ajax_edit($id) {
    $data = $this->menu->get_by_id($id);
    echo json_encode($data);
  }

  // INSERT DATA
  public function ajax_add() {

    $menu = $this->input->post('menu');
    $this->_set_validate();
    if ($this->form_validation->run() == FALSE) {
      $err = [
        'menu' => form_error('menu'),
        'title' => form_error('title'),
        'icon' => form_error('icon'),
        'tipe' => form_error('tipe')
      ];
      echo json_encode(["status" => FALSE, 'err' => $err]);
    } else
    {
      $i = $this->db->query('SELECT max(urutan) FROM menu')->row_array();
      $urutan = $i['max(urutan)']+1;
      $data = [
        'menu' => htmlspecialchars(strtolower($this->input->post('menu')), true),
        'title' => htmlspecialchars($this->input->post('title'), true),
        'icon' => htmlspecialchars($this->input->post('icon'), true),
        'tipe' => htmlspecialchars($this->input->post('tipe'), true),
        'urutan' => htmlspecialchars($urutan, true)
      ];
      $insert = $this->menu->save($data);
      /*
      $this->load->helper('file');
      if ($this->input->post('tipe') == 1) {
        $data =
        "<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ".ucwords($menu)." extends CI_Controller {

  public function index()
  {
    // \$this->load->view('view');
  }

}";
        write_file("./application/controllers/".ucwords($menu).".php", $data);
      } else {
        mkdir("./application/controllers/".strtolower($menu));
      }
*/
      echo json_encode(["status" => TRUE]);
    }
  }


  // UPDATE DATA
  public function ajax_update() {
    $this->form_validation->set_rules('menu', 'Menu', 'required|min_length[3]',
      [
        'required' => 'menu tidak boleh kosong',
        'min_length' => 'nama menu terlalu pendek',
        'is_unique' => 'Menu sudah ada'
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
    $this->form_validation->set_rules('tipe', 'Tipe', 'required',
      [
        'required' => 'tipe tidak boleh kosong'
      ]
    );

    if ($this->form_validation->run() == FALSE) {
      $err = [
        'menu' => form_error('menu'),
        'title' => form_error('title'),
        'icon' => form_error('icon'),
        'tipe' => form_error('tipe')
      ];
      echo json_encode(["status" => FALSE, 'err' => $err]);
    } else
    {
      $data = [
        'menu' => htmlspecialchars(strtolower($this->input->post('menu')), true),
        'title' => htmlspecialchars($this->input->post('title'), true),
        'icon' => htmlspecialchars($this->input->post('icon'), true),
        'tipe' => htmlspecialchars($this->input->post('tipe'), true)
      ];

      $this->menu->update(array('id' => $this->input->post('id')), $data);
      echo json_encode(array("status" => TRUE));
    }

  }

  // DELETE DATA
  public function ajax_delete($id) {
    $this->load->helpers('file');
    $menu = $this->db->get_where('menu', ['id' => $id])->row_array();
    if ($menu['tipe'] == 1) {
      unlink("./application/controllers/".ucwords($menu['menu']).".php");
    } else {
      delete_files('./application/testing/'.$menu['menu'], TRUE);
      rmdir('./application/controllers/'.$menu['menu']);
    }
    $this->menu->delete_by_id($id); // DELETE MENU
    $this->db->delete('sub_menu', ['menu_id' => $id]); // DELETE SUB MENU YANG BERSANGKUTAN
    $this->db->delete('role_menu', ['menu_id' => $id]); // DELETE AKSES YANG BERSANGKUTAN
    echo json_encode(array("status" => TRUE));

  }




}