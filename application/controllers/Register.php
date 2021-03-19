<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
  
  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
  }
  
	public function index()
	{
	  //$this->load->view('auth/register');
	  $this->_validation();
	}
	

	
	private function _validation()
	{
	  $this->form_validation->set_rules('nama','Nama','trim|required|min_length[2]',
	  [
	    'required' => 'nama harus diisi!', 
	    'min_length' => 'naman terlalu pendek!'
	  ]);
	  $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]',
	  [
	    'required' => 'email harus diisi!', 
	    'valid_email' => 'masukan email yang benar', 
	    'is_unique' => 'email ini telah digunakan'
	    
	  ]);
	  $this->form_validation->set_rules('password1','Password','trim|required|min_length[2]',
	  [
	    'required' => 'password harus diisi!', 
	    'min_length' => 'password terlalu pendek'
	     
	    
	  ]);
	  $this->form_validation->set_rules('password2','Password confirmation','trim|required|matches[password1]',
	  [
	    'required' => 'konfirmasi password harus diisi!', 
	    'matches' => 'password tidak sesuai'
	    
	  ]);
	  
	//  $this->load->view('auth/register');
	  
	  if($this->form_validation->run() == false){
	   $this->load->view('auth/register');
	  }
	  else{
	    $data = [
	      'nama' => htmlspecialchars($this->input->post('nama'),true), 
	      'email' => htmlspecialchars($this->input->post('email'),true),
	      'password' => password_hash($this->input->post('password1'),PASSWORD_DEFAULT),
	      'avatar' => 'avatar.png', 
	      'limit_salah' => 0,
	      'is_active' => 0,
	      'role_id' => 2,
	      'created_at' => time()
	    ];
	    
	    //TOKEN
	    $token = base64_encode(random_bytes(32));
	    $user_token = [
	    	'email' => $this->input->post('email'),
	    	'token' => $token,
	    	'created_at' => time()

	    ];

	    $this->db->insert('user',$data);
	    $this->db->insert('user_token',$user_token);

	    $this->_sendemail($token,'verify');

	    $this->session->set_flashdata('pesan','pendaftaran telah berhasil');
	    return redirect('login');
	  }
	  
	}


private function _sendemail($token,$type)
  {
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

    $this->load->library('email',$config);

    $this->email->from('smtpgugel@gmail.com','Abror Company');
    $this->email->to($this->input->post('email'));

    if($type == 'verify')
    {
    	$this->email->subject('Verifikasi Akun');
    $this->email->message('Klik Link Dibawah ini untuk verifikasi <br> <a href="'.base_url() .'register/verify?email='.$this->input->post('email').'&token='.urlencode($token).'">Aktifasi Akun');

    }

    
    if($this->email->send())
    {
     return true;
    }
    else
    {
      echo $this->email->print_debugger();die;
    }
  }

public function verify()
{
	$email = $this->input->get('email');
	$token = $this->input->get('token');

	$user = $this->db->get_where('user',['email'=>$email])->row_array();
	if($user)
	{
		$user_token = $this->db->get_where('user_token',['token'=>$token])->row_array();
		if($user_token)
		{
			if(time() - $user_token['created_at'] < 60*60*24)
			{
				$this->db->set('is_active',1);
				$this->db->where('email',$email);
				$this->db->update('user');
				$this->db->delete('user_token',['email'=>$email]);

				echo 'success';

			}
			else
			{
				$this->db->delete('user',['email'=>$email]);
				$this->db->delete('user_token',['email'=>$email]);
			}
		}
		else
		{
			echo 'hayo ngubah token ya...:)';
		}
	}
	else
	{
		echo 'hayo ngubah email ya....:)';
	}
}

public function forgotpw()
{

	$this->form_validation->set_rules('email','Email','trim|required|valid_email|',
	  [
	    'required' => 'email harus diisi!', 
	    'valid_email' => 'masukan email yang benar'
	    
	  ]);

	if($this->form_validation->run() == FALSE)
	{
	$page = 'auth/lupapw';
    $data['title'] = 'Lupa Password';
    $this->load->view('auth/lupapw',$data);
	}
	else
	{
		echo 'berhasil';die;
	}
	
}  
	
}

