<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

  public function __construct() {
    parent::__construct();
    harus_login();
  }

  public function index() {

    $page = 'user/myprofile';
    $data['title'] = 'My Profile';
    pages($page, $data);
  }

  public function edit() {
    $email = $this->session->userdata('email');
    $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
    $page = 'user/edit';
    $data['title'] = 'Edit Profile';
    pages($page, $data);
  }

  public function update() {

    $this->form_validation->set_rules('nama', 'Nama', 'trim|required|max_length[10]', [
      'required' => 'Nama panggilan tidak boleh kosong',
      'max_length' => 'Nama panggilan terlalu panjang'
    ]);

    if ($this->form_validation->run() == false) {
      $err = [
        'nama' => form_error('nama')
      ];
      echo json_encode(['status' => FALSE, 'err' => $err]);

    } else {
      $nama = htmlspecialchars($this->input->post('nama'), true);
      $email = htmlspecialchars($this->input->post('email'), true);
      $avatar = htmlspecialchars($this->input->post('avatar'), true);

      $image = $_FILES['avatar']['name'];
      if ($image) {
        $config['upload_path'] = './uploads/image/profile';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['file_name'] = time().'_'.$image;
        $config['max_size'] = 20000;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('avatar')) {
          $oldAvatar = $data['user']['avatar'];
          if ($oldAvatar != 'avatar.png') {
            unlink(FCPATH . 'uploads/image/profile/' . $oldAvatar);
          }
          $this->db->set('avatar', $this->upload->data('file_name'));
        } else {
          echo $this->upload->display_errors();
        }

      }

      $this->db->where('email', $email);
      $this->db->set('nama', $nama);
      $this->db->update('user');

      echo json_encode(['status' => TRUE]);

    }




  }

  public function changepw() {
    $email = $this->session->userdata('email');
    $data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
    $page = 'user/changepw';
    $data['title'] = 'Ganti Password';

    $pwlama = $this->input->post('passwordlama');
    $pwbaru = $this->input->post('password1');

    $this->form_validation->set_rules('passwordlama', 'Passwordlama', 'required', [
      'required' => 'password harus diisi'
    ]);
    $this->form_validation->set_rules('password1', 'Password1', 'trim|required|min_length[2]',
      [
        'required' => 'password harus diisi!',
        'min_length' => 'password terlalu pendek'
      ]);
    $this->form_validation->set_rules('password2', 'Password2', 'trim|required|matches[password1]',
      [
        'required' => 'konfirmasi password harus diisi!',
        'matches' => 'password tidak sesuai'

      ]);

    if ($this->form_validation->run() == FALSE) {
      pages($page, $data);
    } else
    {

      if (password_verify($pwlama, $data['user']['password'])) {
        if ($pwlama == $pwbaru) {
          $this->session->set_flashdata('!password1', '<small class="text-danger pl-3">tidak boleh sama dengan password lama</small>');
          redirect('user/changepw');
        } else
        {
          $pwhash = password_hash($pwbaru, PASSWORD_DEFAULT);
          $this->db->set('password', $pwhash);
          $this->db->where('email', $email);
          $this->db->update('user');
          echo 'password berhasil diubah';
          $this->session->set_flashdata('!passwordlama', "<script>swal('Good job!','Password Berhasil Diubah!','success')</script>");
          redirect('profile/changepw');

        }
      } else
      {
        $this->session->set_flashdata('!passwordlama', '<small class="text-danger pl-3">Password Lama Salah</small>');
        redirect('profile/changepw');
      }
    }
  }



  public function ajax_profile() {
    $email = $this->session->userdata('email');
    $this->db->select('nama, email, avatar');
    $user = $this->db->get_where('user', ['email' => $email])->result();
    echo json_encode(['user' => $user]);
  }


}