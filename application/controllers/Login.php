<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
  public function index() {
    // JIKA TELAH LOGIN
    if ($this->session->userdata('email')) {
      redirect('dashboard');
    }
    // JIKA BELUM KOGIN
    else {
      $this->load->view('auth/login');
      //$this->_validation();
    }
  }


  public function validate() {

    // SET RULES PADA FORM LOGIN
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [
      'required' => 'email harus diisi',
      'valid_email' => 'email tidak valid'
    ]);
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[2]', [
      'required' => 'password harus diisi',
      'min_length' => 'password terlalu pendek'
    ]);


    // JIKA VALIDASI GAGAL
    if ($this->form_validation->run() == FALSE) {
      $err = [
        'email' => form_error('email'),
        'password' => form_error('password')
      ];
      echo json_encode(['status' => FALSE, 'err' => $err]);
    }
    // JIKA LOLOS VALIDASI
    else {
      // DEKLARASI VARIABLE
      $email = $this->input->post('email');
      $password = $this->input->post('password');
      // GET DATA USER BERDASARKAN EMAIL
      $user = $this->db->get_where('user', ['email' => $email])->row_array();
      // JIKA EMAIL BENAR
      if ($user) {
        // JIKA AKUN AKTIF
        if ($user['is_active'] == 1) {
          // JIKA PASSWORD BENAR
          if (password_verify($password, $user['password'])) {
            $data = [
              'email' => $user['email'],
              'nama' => $user['nama'],
              'role_id' => $user['role_id']
            ];
            $this->session->set_userdata($data);
            // JIKA ROLE ADMIN
            if ($user['role_id'] == 1) {
              echo json_encode(['status' => TRUE, 'url' => 'dashboard']);
            }
            // JIKA ROLE SELAIN ADMIN
            else {
              echo json_encode(['status' => TRUE, 'url' => 'home']);
            }
          }
          // JIKA PASSWORD SALAH
          else {
            $err = ['email' => '',
              'password' => 'Password salah'];
            echo json_encode(['status' => FALSE, 'err' => $err]);
          }
        }
        // JIKA AKUN BELUM AKTIF ATAU TERBLOKIR
        else {
          $err = ['email' => 'Akun Tidak / Belum Aktif',
            'password' => ''];
          echo json_encode(['status' => FALSE, 'err' => $err]);
        }
      }
      // JIKA EMAIL TIDAK TERDAFTAR
      else {
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