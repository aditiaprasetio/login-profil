<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/v1/Api.php';

class Rumahiot extends Api {

    function __construct(){
        // Construct the parent class
        parent::__construct();
    }
	public function login_post(){
		header('Content-type:application/json');
		$email='fauzanilzaki@gmail.com';
		$password='zakizaki';
		
		$url = "https://sidik.rumahiot.panjatdigital.com/authenticate/email";
		
		$postfields = array(
			'email' 		=> "$email",
			'password' 		=> "$password"
		);
		
		if (!$curld = curl_init()) {exit;};

		curl_setopt($curld, CURLOPT_POST, true);
		curl_setopt($curld, CURLOPT_POSTFIELDS, $postfields);
		curl_setopt($curld, CURLOPT_URL,$url);
		curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);

		$output = curl_exec($curld);
		// $output=json_decode($output);
		
		echo $output;
		
		curl_close ($curld);
	}
}
?>