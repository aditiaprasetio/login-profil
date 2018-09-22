<?php

defined('BASEPATH') OR exit('No direct script access allowed');
// require APPPATH . 'libraries/REST_Controller.php';

class Auth{

    function __construct()
    {
        // Construct the parent class
    }

	/** 
	 * Get hearder Authorization
	 * */
	function getAuthorizationHeader(){
			$headers = null;
			if (isset($_SERVER['Authorization'])) {
				$headers = trim($_SERVER["Authorization"]);
			}else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
				$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
			}elseif(isset($_SERVER['HTTP_X_AUTHORIZATION'])){
				$headers = trim($_SERVER['HTTP_X_AUTHORIZATION']);
			}elseif(isset($_SERVER['HTTP_X_API_KEY'])){
				$headers = trim($_SERVER['HTTP_X_API_KEY']);
			}elseif (function_exists('apache_request_headers')) {
				$requestHeaders = apache_request_headers();
				var_dump($requestHeaders);
				// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
				$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
				//print_r($requestHeaders);
				if (isset($requestHeaders['Authorization'])) {
					$headers = trim($requestHeaders['Authorization']);
				}
			}
			return $headers;
		}
	/**
	 * get access token from header
	 * */
	function getBasicToken(){
		$headers = $this->getAuthorizationHeader();
		// HEADER: Get the access token from the header
		if (!empty($headers)) {
			if (preg_match('/Basic\s(\S+)/', $headers, $matches)) {
				return $matches[1];
			}
		}
		return null;
	}
	
	function getIdUser(){
		$token = $this->getBasicToken();
		$token = base64_decode($token);
		$token = explode(':',$token);
		// HEADER: Get the access token from the header
		if (!empty($token)){
			return $token[0];
		}
		return null;
	}
	
	function getToken(){
		$token = $this->getBasicToken();
		$token = base64_decode($token);
		$token = explode(':',$token);
		// HEADER: Get the access token from the header
		if (!empty($token)) {
			if(isset($token[1])) return $token[1];
			else return null;
		}
		return null;
	}
	
	public function isValidToken(){
		// $this->authHeader=$auth->getAuthorizationHeader();
		// $this->basicToken=$auth->getBasicToken();
		$id_user=$this->getIdUser();
		$token=$this->getToken();
		// var_dump($token);
		$password=$token;
		// var_dump($this->password);
		// var_dump($this->authHeader);
		// var_dump($this->basicToken);
		// var_dump($this->id_user);
		// var_dump($this->token);
		
		// 
		
		$result=array('id_biquers'=>$id_user,'password'=>$password);
		// var_dump($result);
		if($id_user!=null && $password!=null){
			return $result;
		}else{
			return false;
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