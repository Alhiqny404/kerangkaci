<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->library('form_validation');
  }

  public function index() {
    $this->load->view('home/signup/index');
  }

  public function validate() {
    $this->form_validation->set_rules('username', 'username', 'trim|required|min_length[2]|max_length[10]',
      [
        'required' => 'Username harus diisi',
        'min_lenght' => 'Username Panggilan terlalu pendek',
        'max_length' => 'Username Terlalu panjang'
      ]);
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[user.email]',
      [
        'required' => 'Email harus diisi',
        'valid_email' => 'Email tidak Valid',
        'is_unique' => 'Email sudah digunakan akun lain'
      ]);
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[2]',
      [
        'required' => 'Password harus diisi',
        'min_length' => 'Password terlalu pendek'
      ]);
    $this->form_validation->set_rules('password_confirm', 'password_confirm', 'trim|required|matches[password]',
      [
        'required' => 'Password konfirmasi harus diisi',
        'matches' => 'Pssword tidak sesuai dengan diatas'
      ]);

    if ($this->form_validation->run() == false) {
      $err = [
        'username' => form_error('username'),
        'email' => form_error('email'),
        'password' => form_error('password'),
        'password_confirm' => form_error('password_confirm')
      ];
      echo json_encode(['status' => FALSE, 'err' => $err]);
    } else {

      $data_user = [
        'username' => htmlspecialchars($this->input->post('username'), true),
        'email' => htmlspecialchars($this->input->post('email'), true),
        'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
        'avatar' => 'avatar.png',
        'is_active' => 0,
        'role_id' => 2,
        'created_at' => time()
      ];
      $this->db->insert('user', $data_user);


      $token = base64_encode(random_bytes(32));
      $user_token = [
        'token' => $token,
        'email' => $this->input->post('email'),
        'created_at' => time()
      ];

      $this->db->insert('user_token', $user_token);
      $this->_sendemail($token, 'verify');
      echo json_encode(['status' => TRUE, 'url' => 'login']);

    }

  }

  // MENGIRIM EMAIL VERIFIKASI
  private function _sendemail($token, $type) {
    $config = [
      'protocol' => 'smtp',
      'smtp_host' => 'ssl://smtp.googlemail.com',
      'smtp_user' => 'smtpgugel@gmail.com',
      'smtp_pass' => 'AkunFake987',
      'smtp_port' => 465,
      'mailtype' => 'html',
      'charset' => 'utf-8',
      'newline' => "\r\n"
    ];


    $this->load->library('email', $config); // LOAD LIBRARY EMAIL

    $this->email->from('smtpgugel@gmail.com', 'Abror Company');
    $this->email->to($this->input->post('email'));

    if ($type == 'verify') {
      $this->email->subject('Verifikasi Akun');
      $this->email->message('Klik Link Dibawah ini untuk verifikasi <br> <a href="'.base_url() .'register/verify?email='.$this->input->post('email').'&token='.urlencode($token).'">Aktifasi Akun');

    }


    if ($this->email->send()) {
      return true;
    } else
    {
      echo $this->email->print_debugger(); die;
    }
  }

  public function verify() {
    $email = $this->input->get('email');
    $token = $this->input->get('token');

    $user = $this->db->get_where('user', ['email' => $email])->row_array();
    if ($user) {
      $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
      if ($user_token) {
        if (time() - $user_token['created_at'] < 60*60*24) {
          $this->db->set('is_active', 1);
          $this->db->where('email', $email);
          $this->db->update('user');
          $this->db->delete('user_token', ['email' => $email]);

          echo 'success';

        } else
        {
          $this->db->delete('user', ['email' => $email]);
          $this->db->delete('user_token', ['email' => $email]);
        }
      } else
      {
        echo 'hayo ngubah token ya...:)';
      }
    } else
    {
      echo 'hayo ngubah email ya....:)';
    }
  }

  // LUPA PASSWORD
  public function forgotpw() {

    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|',
      [
        'required' => 'email harus diisi!',
        'valid_email' => 'masukan email yang benar'
      ]);

    if ($this->form_validation->run() == FALSE) {
      $page = 'auth/lupapw';
      $data['title'] = 'Lupa Password';
      $this->load->view('auth/lupapw', $data);
    } else
    {
      echo 'berhasil'; die;
    }

  }

}