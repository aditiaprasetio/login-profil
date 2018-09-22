<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('MUser');
		$this->load->model('MUserWeMo');
	}
	
	public function index(){
		$this->data['title_page']='Login';
		$this->isLogout();
		$this->load->view('auth/login_view', $this->data);
	}
	
	public function password(){
		$this->data['title_page']='Login';
		$this->isLogin();
		
		$this->load->view('admins/_header', $this->data);
		$this->load->view('admins/_sidebar', $this->data);
		$this->load->view('admins/password', $this->data);
		$this->load->view('admins/_footer');
	}
	
	public function forgot_password(){
		$this->data['title_page']='Forgot Password';
		
		$username=$this->input->get('username');
		if($username==null){
			$this->load->view('auth/forgot_password', $this->data);
		}else{
			$password=rand(10001,99999);
			$password_baru=$this->enkripsi($password);
			
			$cek=$this->MUserWeMo->isCanUse($username);
			if($cek==true){
				echo 'Oops. Email tidak terdaftar.';
			}else{
				$cond=array('username'=>$username);
				$data=array('password'=>$password_baru);
				$update=$this->MUserWeMo->updateusers($cond, $data);
				if($update){
					// kirim email
					$this->kirimemail_nologin($username, 'Reset Password', 'Password baru anda : '.$password);
					echo 'Berhasil me-reset password. Password baru dikirim ke email anda.';
				}else{
					echo 'Terjadi kesalahan. Silakan ulangi.';
				}
			}
		}
	}
	
	public function change_password_proses(){
		$this->data['title_page']='Change Password';
		$this->isLogin();
		$id=$this->session->userdata('id');
		$username=$this->session->userdata('username');
		
		$password_lama=$this->enkripsi(md5($this->input->post('password_lama')));
		$password_baru=$this->enkripsi(md5($this->input->post('password_baru')));
		$re_password_baru=$this->enkripsi(md5($this->input->post('re_password_baru')));
		
		if($password_baru!=$re_password_baru){
			redirect('auth/password?respon=failed&message=New password is not match');
		}
		
		$cek=$this->MUser->isUser($username, $password_lama);
		if(!$cek['status']){
			redirect('auth/password?respon=failed&message=Your old password is wrong.');
		}
		
		$cond=array('username'=>$username);
		$data=array('password'=>$password_baru);
		$update=$this->MUser->updateAkun($cond, $data);
		if($update){
			redirect('auth/password?respon=success&message=Congrats... Your password was updated.');
		}else{
			redirect('auth/password?respon=failed&message=There is a problem. Please try again.');
		}
	}
	
	public function login_proses(){
		$this->isLogout();
		
		$username=$this->input->post('username');
		$password=$this->enkripsi(md5($this->input->post('password')));
		
		$isUser=$this->MUser->isUser($username, $password);
		if($isUser['status']){
			//login
			$result=$isUser['result']->row_array();
			$this->session->set_userdata('id', $result['id']);
			$this->session->set_userdata('nama', $result['nama']);
			$this->session->set_userdata('username', $result['username']);
			$this->session->set_userdata('email', $result['email']);
			$this->session->set_userdata('status_akun', $result['status_akun']);
			
			redirect(site_url('admins'));
		}else{
			redirect(site_url('auth?respon=gagal&pesan=Username dan password tidak cocok.'));
		}
		
	}
	public function register_proses(){
		// $this->isLogin($this->data['tipe']);
		$this->isLogout();
		
		$username=$this->input->post('username');
		$email=$this->input->post('email');
		$password=$this->enkripsi(md5($this->input->post('password')));
		
		$nama=$this->input->post('nama');
		$tujuan=$this->input->post('tujuan');
		
		if($tujuan=='mengajar' || $tujuan=='semua'){
			$status_kabim=2; // 2 menunggu aktivasi, 1 aktif sebagai kabim
		}else{
			$status_kabim=0; // 0 bukan kabim, 5 banned
		}
		
		$kode_saku='SBK'.date('shm').rand(101010,989898);
		$kode_aktivasi=sha1('K0DE'.date('hhmmss').uniqid().rand(10100,98980).'ACT1VE');
		
		if(!$this->MUser->isCanUse($username)){
			redirect(site_url('auth?respon=gagal&pesan=Username sudah pernah didaftarkan.'));
		}elseif(!$this->MUser->isCanUse($email)){
			redirect(site_url('auth?respon=gagal&pesan=Email sudah pernah didaftarkan.'));
		}else{
			$dataAkun=array(
					'id'=>null,
					'username'=>$username,
					'email'=>$email,
					'password'=>$password,
					'kode_saku'=>$kode_saku,
					'kode_aktivasi'=>$kode_aktivasi,
					'status_akun'=>0
				);
			
			$dataDetail=array(
					'nama'=>$nama,
					'bio'=>null,
					'foto'=>null,
					'status_kabim'=>$status_kabim
				);
			$dataSaku=array(
					'kode_saku'=>$kode_saku,
					'bank'=>null,
					'rekening'=>null,
					'atas_nama'=>null,
					'keterangan'=>null
				);
			
			$insert=$this->MUser->create($dataAkun, $dataDetail, $dataSaku);
			if($insert){
				redirect(site_url('beranda?respon=berhasildaftar'));
			}else{
				redirect(site_url('beranda?respon=gagal&pesan=Terjadi kesalahan saat mendaftar. Silakan ulangi.'));
			}
		}
		
	}
	
	public function logout(){
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('nama');
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('status_akun');
		redirect(site_url('beranda'));
	}
	
	
}