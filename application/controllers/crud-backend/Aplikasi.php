<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aplikasi extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('Apps_model', 'apps');
    harus_login();
    akses_submenu();
  }

  // Proses Update data
  public function update() {
    // deklarasi aturan input form
    $this->form_validation->set_rules('name_app', 'Name_app', 'required', ['required' => 'tidak boleh kosong']);
    $this->form_validation->set_rules('color_navbar', 'Color_navbar', 'required', ['required' => 'tidak boleh kosong']);
    $this->form_validation->set_rules('color_sidebar', 'Color_sidebar', 'required', ['required' => 'tidak boleh kosong']);

    // jika validasi gagal or belum dilakukan
    if ($this->form_validation->run() == false) {
      $err = [
        'name_app' => form_error('name_app'),
        'color_navbar' => form_error('color_navbar'),
        'color_sidebar' => form_error('color_sidebar')
      ];
      echo json_encode(['status' => false, 'err' => $err]);
    }
    // jika lolos validasi
    else {
      $data = [
        'name_app' => htmlspecialchars($this->input->post('name_app'), true),
        'color_navbar' => htmlspecialchars($this->input->post('color_navbar'), true),
        'color_sidebar' => htmlspecialchars($this->input->post('color_sidebar'), true)
      ];
      $this->apps->update($data, ['id' => 1]);
      echo json_encode(['status' => true]);
    }
  }

  // data ajax
  public function ajax() {
    $data = $this->apps->get_data();
    echo json_encode($data);
  }



}