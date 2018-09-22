<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/v1/Api.php';

class User extends Api {

    function __construct(){
        // Construct the parent class
        parent::__construct();
		$this->load->model('MUser');
		// Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['register_post']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['login_post']['limit'] = 500; // 500 requests per hour per user/key
    }
	public function default_get(){
		$this->response([
			'status' => FALSE,
			'password_sha1_md5' => sha1(md5('W123456')),
			'password_md5' => md5('W123456')
		], REST_Controller::HTTP_OK);
	}
	public function loginByApps_post(){
		$reqparams=array(
			'email','fullname','google_token'
		);
		
		$email=$this->post('email');
		$fullname=$this->post('fullname');
		$google_token=$this->post('google_token');
		
		$postdata['google_token']=$google_token;
		$postdata['email']=$email;
		$postdata['fullname']=$fullname;
		
		$this->cekParams($reqparams, $postdata);
		// cek apakah email sudah terdaftar
		if($this->MUser->isCanUse($email)){
			// Register
			$password=$this->enkripsi('apps_'.$email);
			$dataAkun=array(
				'email'=>$email,
				'password'=>'default',
				'fullname'=>$fullname,
				'token'=>sha1($email.$password.date('Y-m-d H:i:s')),
				'google_token'=>$google_token,
			);
			$insert=$this->MUser->create($dataAkun);
			if(!$insert){
				$this->response([
					'status' => FALSE,
					'message' => 'Pendaftaran akun gagal. Silakan ulangi.'
				], REST_Controller::HTTP_OK);
			}
		}
		$password='default';
		// Login
		$cekLogin=$this->MUser->cekLogin($email, $password);
		if($cekLogin['status']){
			$result=$cekLogin['result']->row_array();
			
			$update=$this->MUser->updateusers(array('id_user'=>$result['id_user']), array('google_token'=>$google_token));
			
			// hapus data privacy
			unset($result['password']);
			
			$this->set_response([
				'status'=>TRUE,
				'message'=>'Success',
				'result'=>$result
			], REST_Controller::HTTP_OK);
		}else{
			$this->set_response([
				'status'=>FALSE,
				'message'=>'Login gagal'
			], REST_Controller::HTTP_OK);
		}
	}
	public function register_post(){
		$reqparams=array(
			'email', 'fullname', 'password'
		);
		
		$email=$this->post('email');
		$password=$this->post('password'); // pre : md5 , pasca : sha1(md5(---))
		$fullname=$this->post('fullname');
		
		$postdata['email']=$email;
		$postdata['password']=$password;
		$postdata['fullname']=$fullname;

		$this->cekParams($reqparams, $postdata);
		
		$password=$this->enkripsi($password); // pre : md5 , pasca : sha1(md5(---))
		
		if ($email=='' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->response([
				'status' => FALSE,
				'message' => 'Format email salah. (Contoh : nama@domain.com)'
			], REST_Controller::HTTP_OK);
		}elseif(!$this->MUser->isCanUse($email)){
			$this->response([
				'status' => FALSE,
				'message' => 'Email sudah pernah didaftarkan. Gunakan email yang lain.'
			], REST_Controller::HTTP_OK);
		}else{
			$dataAkun=array(
				'email'=>$email,
				'password'=>$password,
				'fullname'=>$fullname,
				'token'=>sha1($email.$password.date('Y-m-d H:i:s'))
			);
			$insert=$this->MUser->create($dataAkun);
			if($insert){
				$this->response([
					'status' => TRUE,
					'message' => 'Register succesfully.'
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'status' => FALSE,
					'message' => 'There is a problem. Please, try again.'
				], REST_Controller::HTTP_OK);
			}
		}
	}
	
	public function login_post(){
		$reqparams=array(
			'email','password'
		);
		
		$email=$this->post('email');
		$password=$this->enkripsi($this->post('password'));
		
		$postdata['email']=$email;
		$postdata['password']=$password;
		$this->cekParams($reqparams, $postdata);

		$cekLogin=$this->MUser->cekLogin($email, $password);
		if($cekLogin['status']){
			$result=$cekLogin['result']->row_array();
			
			// hapus data privacy
			unset($result['password']);
			
			$this->set_response([
				'status'=>TRUE,
				'message'=>'Success',
				'result'=>$result
			], REST_Controller::HTTP_OK);
		}else{
			// coba login via google
			$password='google';
			// Login
			$cekLogin=$this->MUser->cekLogin($email, $password);
			if($cekLogin['status']){
				$this->set_response([
					'status'=>FALSE,
					'message'=>'Login Gagal.<br/>Anda terdaftar melalui akun Google dan mungkin belum membuat password!'
				], REST_Controller::HTTP_OK);
			}else{
				// jika tidak bisa
				$this->set_response([
					'status'=>FALSE,
					'message'=>'Username dan password tidak cocok.'
				], REST_Controller::HTTP_OK);
			}
		}
    }
	public function profil_post(){
		$id_user=$this->getIdUser();
		$reqparams=array(
			'email','fullname'
		);
		
		$email=$this->post('email');
		$fullname=$this->post('fullname');
		$address=$this->post('address');
		$latlng=$this->post('latlng');
		$phone=$this->post('phone');
		
		// latitude, longitude
		$lat=null; $lng=null;
		$exp=explode(',',$latlng);
		if(count($exp)>1){
			$lat=$exp[0];
			$lng=$exp[1];
		}
		
		$postdata['email']=$email;
		$postdata['fullname']=$fullname;
		$postdata['address']=$address;
		$postdata['lat']=$lat;
		$postdata['lng']=$lng;
		$postdata['phone']=$phone;
		$this->cekParams($reqparams, $postdata);
		
		if ($email=='' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->response([
				'status' => FALSE,
				'message' => 'Format email salah. (Contoh : nama@domain.com)'
			], REST_Controller::HTTP_OK);
		}
		
		// cek username dan email
		$cek=$this->MUser->isCanUseByUpdate($email, $id_user);
		if(!$cek){
			$this->response([
				'status'=>FALSE,
				'message'=>'Email sudah digunakan.'
			], REST_Controller::HTTP_OK);
		}
		
		// update
		$update=$this->MUser->updateusers(array('id_user'=>$id_user), $postdata);
		if($update){
			$this->set_response([
				'status'=>TRUE,
				'message'=>'Berhasil memperbaharui profil'
			], REST_Controller::HTTP_OK);
		}else{
			$this->set_response([
				'status'=>FALSE,
				'message'=>'Update gagal'
			], REST_Controller::HTTP_OK);
		}
    }
	public function changepassword_post(){
		$reset_token=$this->post('reset_token');
		$check_only=$this->post('check_only');
		if($check_only!=null){
			$cekLogin=$this->MUser->cekResetToken($reset_token);
			if($cekLogin['status']){
				$this->response([
					'status'=>TRUE,
					'message'=>'You can change your password.'
				], REST_Controller::HTTP_OK);
			}else{
				$this->response([
					'status'=>FALSE,
					'message'=>'Token sudah tidak berlaku.'
				], REST_Controller::HTTP_OK);
			}
		}
		
		if($reset_token==null){
			$id_user=$this->getIdUser();
		
			$reqparams=array(
				'oldPassword','password','repassword'
			);
		}else{			
			$reqparams=array(
				'password','repassword'
			);
		}		
		$oldPassword=$this->post('oldPassword');
		if($oldPassword==sha1('dp')){
			// default password
			$oldPassword='default';
		}else{
			$oldPassword=$this->enkripsi($oldPassword);
		}
		$password=$this->enkripsi($this->post('password'));
		$repassword=$this->enkripsi($this->post('repassword'));
		
		$postdata['oldPassword']=$oldPassword;
		$postdata['password']=$password;
		$postdata['repassword']=$repassword;
		$this->cekParams($reqparams, $postdata);
		
		if($password!=$repassword){
			$this->response([
				'status'=>FALSE,
				'message'=>'Password baru tidak sama.'
			], REST_Controller::HTTP_OK);
		}
		
		if($reset_token==null){
			$cekLogin=$this->MUser->cekPassword($id_user, $oldPassword);
		}else{
			$cekLogin=$this->MUser->cekResetToken($reset_token);
		}
		if($cekLogin['status']){
			// update
			$databaru=array(
				'password'=>$password
			);
			
			if($reset_token==null) $update=$this->MUser->updateusers(array('id_user'=>$id_user), $databaru);
			else{
				$databaru['token_reset_password']=null;
				$update=$this->MUser->updateusers(array('token_reset_password'=>$reset_token), $databaru);
			}
			if($update){
				$this->set_response([
					'status'=>TRUE,
					'message'=>'Berhasil memperbaharui password'
				], REST_Controller::HTTP_OK);
			}else{
				$this->set_response([
					'status'=>FALSE,
					'message'=>'Terjadi kesalahan. Silakan coba lagi.'
				], REST_Controller::HTTP_OK);
			}
		}else{
			if($reset_token==null){
				$this->set_response([
					'status'=>FALSE,
					'message'=>'Password lama salah.'
				], REST_Controller::HTTP_OK);
			}else{
				$this->set_response([
					'status'=>FALSE,
					'message'=>'Token sudah tidak berlaku'
				], REST_Controller::HTTP_OK);
			}
		}
    }
	public function getWarning_get(){
		$id_user=$this->getIdUser();
		
		$result=$this->MUser->getDetailUser($id_user);
		if($result->num_rows()>0){
			$user=$result->row_array();
			$warning=array();
			if($user['password']=='default'){
				$warning[]='password default';
			}
			$this->response([
				'status'=>TRUE,
				'message'=>'Berhasil mendapatkan warning',
				'warning'=>$warning
			], REST_Controller::HTTP_OK);
		}else{
			$this->response([
				'status'=>FALSE,
				'message'=>'Pengguna tidak ditemukan.'
			], REST_Controller::HTTP_OK);
		}
    }
	public function location_post(){
		$id_user=$this->getIdUser();
		$reqparams=array(
			'lat','lng'
		);
		
		$lat=$this->post('lat');
		$lng=$this->post('lng');
		
		$postdata['lat']=$lat;
		$postdata['lng']=$lng;
		$this->cekParams($reqparams, $postdata);
		
		// update
		$update=$this->MUser->updateusers(array('id_user'=>$id_user), $postdata);
		if($update){
			$this->set_response([
				'status'=>TRUE,
				'message'=>'Berhasil memperbaharui lokasi.'
			], REST_Controller::HTTP_OK);
		}else{
			$this->set_response([
				'status'=>FALSE,
				'message'=>'Lokasi gagal diperbaharui.'
			], REST_Controller::HTTP_OK);
		}
    }
	
	public function resetpassword_post(){
		$reqparams=array(
			'email'
		);
		
		$email=$this->input->post('email');
		
		$cek=$this->MUser->isCanUse($email);
		
		// jika true, email tidak terdaftar
		if($cek){
			$this->response([
				'status' => FALSE,
				'message' => 'Email tidak terdaftar.'
			], REST_Controller::HTTP_OK);
		}
		
		$token_reset_password1=rand(10000, 99999);
		$token_reset_password1=$email.$token_reset_password1;
		$token_reset_password=$this->enkripsi($token_reset_password1);
		
		$update=$this->MUser->updateusers(array('email'=>$email), array('token_reset_password'=>$token_reset_password));
		
		if($update){
			$subject='RESET PASSWORD | LOGPRO';
			$url_reset='http://localhost/login-profil/forgot-password.html?reset_token='.$token_reset_password;
			$message='Anda baru saja melakukan permintaan reset password.<br/>
					  Silakan <a href="'.$url_reset.'"><b> klik disini </b></a> <br/>
					  <br/>atau silakan salin dan buka link berikut ini.<br/>
					  <b>'.$url_reset.'</b>';
			$this->kirimemail_nologin($email, $subject, $message);
			
			$this->response([
				'status' => TRUE,
				'message' => 'Password berhasil direset. Silakan cek inbox email anda..'
			], REST_Controller::HTTP_OK);
		}else{
			$this->response([
				'status' => FALSE,
				'message' => 'Terjadi kesalahan saat me-reset password. Silakan ulangi.'
			], REST_Controller::HTTP_OK);
		}   
    }
	public function sendfeedback_post(){
		$id_user=$this->getIdUser();
		$reqparams=array(
			'feedback'
		);
		
		$feedback=$this->post('feedback');
		$additional=$this->post('additional');
		
		$postdata['feedback']=$feedback;

		$this->cekParams($reqparams, $postdata);
		
		$data=array(
			'id_feedback'=>null,
			'id_user'=>$id_user,
			'feedback'=>$feedback,
			'additional'=>$additional,
			'createDate'=>null,
			'readbyadmin'=>0
		);
		
		$insert=$this->MUser->createFeedback($data);
		if($insert){
			$this->response([
					'status' => TRUE,
					'message' => 'Terimakasih atas kritik dan saran yang anda berikan.'
				], REST_Controller::HTTP_OK);
		}else{
			$this->response([
				'status' => FALSE,
				'message' => 'Oops. Ada sedikit masalah. Mohon coba lagi.'
			], REST_Controller::HTTP_OK);
		}
	}
}
