<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
  public function index() {
    // JIKA TELAH LOGIN
    if ($this->session->userdata('email')) {
      redirect('admin');
    }
    // JIKA BELUM KOGIN
    else {
      $this->load->view('auth/login');
      //$this->_validation();
    }
  }


  public function validate() {

    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [
      'required' => 'email harus diisi',
      'valid_email' => 'email tidak valid'
    ]);
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[2]', [
      'required' => 'password harus diisi',
      'min_length' => 'password terlalu pendek'
    ]);

    if ($this->form_validation->run() == FALSE) {
      $err = [
        'email' => form_error('email'),
        'password' => form_error('password')
      ];
      echo json_encode(['status' => FALSE, 'err' => $err]);
    } else {

      $email = $this->input->post('email');
      $password = $this->input->post('password');
      $user = $this->db->get_where('user', ['email' => $email])->row_array();
      if ($user) {
        if ($user['is_active'] == 1) {
          if (password_verify($password, $user['password'])) {
            $data = [
              'email' => $user['email'],
              'nama' => $user['nama'],
              'role_id' => $user['role_id']
            ];
            $this->session->set_userdata($data);
            if ($user['role_id'] == 1) {
              // sebagai admin
              echo json_encode(['status' => TRUE, 'url' => 'dashboard']);
            } else {
              // sebagai user
              echo json_encode(['status' => TRUE, 'url' => 'profile']);
            }
          } else {
            // password salah
            $err = ['email' => '',
              'password' => 'Password salah'];
            echo json_encode(['status' => FALSE, 'err' => $err]);
          }
        } else {
          // akun belum aktif / diblokir
          $err = ['email' => 'Akun Tidak / Belum Aktif',
            'password' => ''];
          echo json_encode(['status' => FALSE, 'err' => $err]);
        }
      } else {
        // email tidak terdaftar
        $err = ['email' => 'email tidak terdaftar',
          'password' => ''];
        echo json_encode(['status' => FALSE, 'err' => $err]);
      }


    }



  }

  public function logout() {
    $this->session->sess_destroy();
    redirect('login');
  }

  public function blokir() {
    echo 'Anda tidak bisa mengakses ini'; die;
  }


}