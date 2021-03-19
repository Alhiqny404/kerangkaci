<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
  public function index() {
    if ($this->session->userdata('email')) {
      redirect('admin');
    } else {

      $this->_validation();
    }
  }


  private function _validation() {

    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [
      'required' => 'email harus diisi',
      'valid_email' => 'email tidak valid'
    ]);
    $this->form_validation->set_rules('password', 'Password', 'required', [
      'required' => 'password harus diisi'
    ]);
    $email = $this->input->post('email');
    $password = $this->input->post('password');

    if ($this->form_validation->run() == false) {
      $this->load->view('auth/login');
    } else
    {
      $user = $this->db->get_where('user', ['email' => $email])->row_array();
      if ($user) {
        if ($user['is_active'] == 1) {
          if (password_verify($password, $user['password'])) {

            $limit = $this->db->query("SELECT `limit_salah` FROM `user` WHERE `email` = '$email'")->row_array()['limit_salah'];
            if ($limit < 7) {
              $data = [
                'email' => $user['email'],
                'role_id' => $user['role_id'],
                'nama' => $user['nama'],
                //'referred_from' => current_url()
              ];
              $this->session->set_userdata($data);
              if ($user['role_id'] == 1) {
                redirect('admin');
              } else {
                redirect('user');
              }
            } else
            {
              echo "akun anda telah terblokir karena memasukan password salah lebih dari 7 kali <br> silahkan hubungi admin"; die;
            }




          } else
          {


            //$this->db->where('email',$email);
            $limit = $this->db->query("SELECT `limit_salah` FROM `user` WHERE `email` = '$email'")->row_array()['limit_salah'] + 1;

            if ($limit > 7) {
              echo 'akun anda telah terblokir karena memasukan password salah lebih dari 7 kali <br> silahkan hubungi admin'; die;
            }

            $this->db->set('limit_salah', $limit);
            $this->db->where('email', $email);
            $this->db->update('user');
            $this->session->set_flashdata('!password', '<small class="text-danger pl-3"> password salah</small>');
            redirect('login');
          }
        } else
        {
          echo 'akun anda terblokir';
        }
      } else
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