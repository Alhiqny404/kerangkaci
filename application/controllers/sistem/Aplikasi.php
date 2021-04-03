<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aplikasi extends CI_Controller {



  public function __construct() {
    parent::__construct();
    harus_login();
    akses_submenu();
  }

  // halaman utama
  public function index() {
    $page = 'admin/apps';
    $data['title'] = 'Aplikasi';
    //pages($page, $data);
    $this->load->view('sistem/apps', $data);
  }

  public function update() {
    $this->form_validation->set_rules('name_app', 'Name_app', 'required', ['required' => 'tidak boleh kosong']);
    $this->form_validation->set_rules('color_navbar', 'Color_navbar', 'required', ['required' => 'tidak boleh kosong']);
    $this->form_validation->set_rules('color_sidebar', 'Color_sidebar', 'required', ['required' => 'tidak boleh kosong']);

    if ($this->form_validation->run() == false) {
      $err = [
        'name_app' => form_error('name_app'),
        'color_navbar' => form_error('color_navbar'),
        'color_sidebar' => form_error('color_sidebar')
      ];
      echo json_encode(['status' => false, 'err' => $err]);
    } else {
      $data = [
        'name_app' => htmlspecialchars($this->input->post('name_app'), true),
        'color_navbar' => htmlspecialchars($this->input->post('color_navbar'), true),
        'color_sidebar' => htmlspecialchars($this->input->post('color_sidebar'), true)
      ];
      $this->db->update('aplikasi', $data, 'id=1');
      echo json_encode(['status' => true]);

    }
  }

  public function ajax() {
    $data = $this->db->get('aplikasi')->result();
    echo json_encode($data);
  }




}