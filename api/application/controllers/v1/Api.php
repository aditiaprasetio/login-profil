<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Api extends REST_Controller {

    function __construct(){
        parent::__construct();
		$this->load->helper('url');
		$this->load->library('Auth');
		$this->load->model('Crud');
		
    }
	public function buatslug($text){
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);

	  // trim
	  $text = trim($text, '-');

	  // remove duplicate -
	  $text = preg_replace('~-+~', '-', $text);

	  // lowercase
	  $text = strtolower($text);
	  $text = trim($text,'-');
	  if (empty($text)) {
		return 'n-a';
	  }

	  return $text;
	}
	function cekLogin(){
		return $this->isValidToken();
	}
	function isLogin(){
		if($this->isValidToken()===false){
			$this->response([
				'status' => FALSE,
				'message' => 'Login terlebih dahulu'
			], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
		}
	}
	function fixtags($text){
		$text = htmlspecialchars($text);
		$text = preg_replace("/=/", "=\"\"", $text);
		$text = preg_replace("/&quot;/", "&quot;\"", $text);
		$tags = "/&lt;(\/|)(\w*)(\ |)(\w*)([\\\=]*)(?|(\")\"&quot;\"|)(?|(.*)?&quot;(\")|)([\ ]?)(\/|)&gt;/i";
		$replacement = "<$1$2$3$4$5$6$7$8$9$10>";
		$text = preg_replace($tags, $replacement, $text);
		$text = preg_replace("/=\"\"/", "=", $text);
		return $text;
	}
	public function enkripsi($text){
		return sha1($text); // $text sudah di enkripsi md5 (dari android)
	}
	public function enkripsifile($text){
		return sha1('C0D3'.$text.'B1XU');
	}
	public function kirimemail_nologin($email,$subject, $message){
		$this->load->library('email');

		$this->email->initialize(array(
		  'protocol' => 'smtp',
		  'smtp_host' => 'mail.kampusgo.xyz',
		  'smtp_user' => 'logpro@kampusgo.xyz',
		  'smtp_pass' => 'q$fbK6zn=~S^',
		  'smtp_port' => 587, // SSL : 465
		  'crlf' => "\r\n",
		  'newline' => "\r\n",
		  'mailtype'=>'html'
		));
		
		$this->email->from('logpro@kampusgo.xyz', 'LOGPRO by Aditia Prasetio');
		$this->email->to($email);

		$this->email->subject($subject);
		$this->email->message($message);

		$this->email->send();
	}
	public function strtoarray($d,$text){
		$text=explode($d,$text);
		if(is_array($text)){
			foreach($text as $key=>$value){
				$res[$key]=trim($value);
			}
			return $res;
		}else{
			return $text;
		}
		
	}
	function isValidToken(){
		$auth=new Auth();
		$isValidToken=$auth->isValidToken();
		// var_dump($isValidToken);
		if($isValidToken===false){
			return false;
		}else{
			$cek=$this->MUser->isValidToken($isValidToken['id_biquers'], $isValidToken['password']);
			if($cek){
				return true;
			}else{
				return false;
			}
		}
	}
	function getIdUser(){
		$this->isLogin();
		$auth=new Auth();
		return (int) $auth->getIdUser();
	}
	
	function cleartext($text){
		$text=trim($text);
		$text=$this->db->escape($text);
		return $text;
	}
	
	function cleararray($array=array(), $exception=array()){
		foreach($array as $key=>$value){
			if(!in_array($key,$exception)){
				$res[$key]=$this->cleartext($value);
			}
		}
		return $res;
	}
	
	public function uploadFile($key, $location, $type){
		if($_FILES[$key]['type']=='application/pdf'){
			$type='file';
			$ekst='.pdf';
		}elseif($_FILES[$key]['type']=='application/vnd.openxmlformats-officedocument.wordprocessingml.document'){
			$type='file';
			$ekst='.doc';
		}elseif($_FILES[$key]['type']=='application/msword'){
			$type='file';
			$ekst='.doc';
		}elseif($_FILES[$key]['type']=='video/mp4'){
			$type='file';
			$ekst='.mp4';
		}
		
		if($type=='photo'){ 
			$max_size='5048'; 
			$ekst='.jpg';
			$config2['allowed_types'] = 'gif||jpg||png||jpeg||JPEG||JPG||PNG';
		}else{
			$config2['allowed_types'] = '*';
			$max_size='20480';
		}
		
		if(isset($_FILES[$key]) && $_FILES[$key]['name']!=''){
			//preview_konten
			$photoName2 = sha1(rand(111,999).gmdate("d-m-y-H-i-s", time()+3600*7)).$ekst;
			$config2['upload_path'] = './'.$location; 
			$config2['max_size'] = $max_size;
			$config2['file_name'] = $photoName2;	
			$this->load->library('upload',$config2);
			$this->upload->initialize($config2);
			if($this->upload->do_upload($key)){
				$upload=array('error'=>false,'result'=>$photoName2);
				
				// create small image
				$configimage['image_library'] = 'gd';
				$configimage['source_image'] = $config2['upload_path'].$photoName2;
				$configimage['create_thumb'] = TRUE;
				$configimage['maintain_ratio'] = TRUE;
				$configimage['width']         = 300;
				$configimage['height']       = 300;

				$this->load->library('image_lib', $configimage);

				$this->image_lib->resize();
			}else{
				$errors = $this->upload->display_errors();
				$upload=array('error'=>true,'result'=>'gagal upload '.$errors);
			}
		}else{
			$upload=array('error'=>true,'result'=>'file tidak ditemukan');
		}
		return $upload;
	}
	function cekParams($required=array(),$param){
		foreach($param as $key1=>$value1){
			$param1[]=$key1;
		}
		// var_dump($param1);
		$req=array();
		foreach($required as $key=>$value){
			if(!in_array($value, $param1)){
				$req[]=$value;
				// echo $value;
			}elseif($param[$value]==null){
				$req[]=$value;
				// echo $value;
			}
		}
		// var_dump($req);
		if(count($req)==0){
			
		}else{
			$this->response([
				'status' => FALSE,
				'message' => 'Required parameter missing',
				'required_params' => $req
			], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
		}
		
	}
	
	function dec_enc($action, $string){
		$output = false;
	 
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'kuncierBaju';
		$secret_iv = 'Bajukuncier';
	 
		// hash
		$key = hash('sha256', $secret_key);
		
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
	 
		if( $action == 'e' ) {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		}
		else if( $action == 'd' ){
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}
	 
		return $output;
	}
}