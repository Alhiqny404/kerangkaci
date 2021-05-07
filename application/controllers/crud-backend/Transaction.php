<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Transaction_model', 'transaction');
    harus_login();
    akses_submenu();
  }

  /* ------------  GET DATA JSON   -----------------*/


  public function ajaxList() {
    $list = $this->transaction->get_datatables();
    $data = [];
    $no = $_POST['start'];
    foreach ($list as $ls) {
      $recipient_data = json_decode($ls->recipient_data);
      $no++;
      $row = [];
      $row[] = '<a href="'.site_url("dashboard/transaction/").$ls->id_transaction.'">'.$ls->id_transaction.'</a>';
      $row[] = $recipient_data->customer->name;
      $row[] = $ls->total_pay;
      if ($ls->status == 'pending') {
        $row[] = 'Pesanan Baru';
      } else if ($ls->status == 'terima') {
        $row[] = 'belum diproses';
      } else if ($ls->status == 'tolak') {
        $row[] = 'pesanan ditolak';
      } else if ($ls->status == 'kirim') {
        $row[] = 'Dalam pengiriman';
      } else {
        $row[] = $ls->status;
      }
      $row[] = date('d F Y', $ls->created_at);
      if ($ls->status != 'tolak') {
        $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit"
             onclick="edit('."'".$ls->id_transaction."'".','."'".$ls->status."'".','."'".$ls->resi."'".')"><i class="fa fa-edit"></i></a><a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus"
                    onclick="delete_menu('."'".$ls->id_transaction."'".','."'".$ls->status."'".')"><i class="fa fa-trash"></i></a>';
      } else {
        $row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus"
                    onclick="delete_menu('."'".$ls->id_transaction."'".','."'".$ls->status."'".')"><i class="fa fa-trash"></i></a>';
      }

      $data[] = $row;
    }

    $output = [
      "draw" => $_POST['draw'],
      "recordsTotal" => $this->transaction->count_all(),
      "recordsFiltered" => $this->transaction->count_filtered(),
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

  // UPDATE DATA
  public function ajax_update() {

    $this->form_validation->set_rules('opsi', 'Opsi', 'required',
      [
        'required' => 'opsi belum diubah'
      ]
    );


    if ($this->form_validation->run() == FALSE) {
      $err = [
        'opsi' => form_error('opsi')
      ];
      echo json_encode(["status" => FALSE, 'err' => $err]);
    } else
    {
      $data = [
        'status' => htmlspecialchars($this->input->post('opsi'), true),
        'note_seller' => htmlspecialchars($this->input->post('note'), true)
      ];
      if ($this->input->post('opsi') == 'kirim') {
        $data['delivered_at'] = time();
        $data['resi'] = htmlspecialchars($this->input->post('resi'), true);
      } else if ($this->input->post('opsi') == 'selesai') {
        $data['finish_at'] = time();
      }
      $this->transaction->update_transaction($data, ['id_transaction' => $this->input->post('id')]);
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