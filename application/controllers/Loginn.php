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
      $this->_validation();
    }
  }


  private function _validation() {

    // SET RULES UNTUK FORM
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [
      'required' => 'email harus diisi',
      'valid_email' => 'email tidak valid'
    ]);
    $this->form_validation->set_rules('password', 'Password', 'required', [
      'required' => 'password harus diisi'
    ]);
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    // JIKA VALIDASI GAGAL
    if ($this->form_validation->run() == false) {
      $this->load->view('auth/login');
    }
    // JIKA LOLOS VALIDASI
    else
    {
      $user = $this->db->get_where('user', ['email' => $email])->row_array();
      // JIKA EMAIL BENAR
      if ($user) {
        // JIKA AKUN SUDAH VERIFIKASI
        if ($user['is_active'] == 1) {
          if (password_verify($password, $user['password'])) {
            $data = [
              'email' => $user['email'],
              'role_id' => $user['role_id'],
              'nama' => $user['nama']
            ];
            $this->session->set_userdata($data);
            // JIKA ROLE ADMIN
            if ($user['role_id'] == 1) {
              redirect('dashboard');
            }
            // JIKA ROLE USER
            else {
              redirect('profile');
            }

          }
          // JIKA PASSWORD SALAH
          else
          {
            $this->session->set_flashdata('!password', '<small class="text-danger pl-3"> password salah</small>');
            redirect('login');
          }
        } else {
          echo 'akun belum aktif';
        }
      }
      // JIKA EMAIL SALAH
      else
      {
        $this->session->set_flashdata('!email', '<small class="text-danger pl-3"> email salah</small>');
        redirect('login');

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