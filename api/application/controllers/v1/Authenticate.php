<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/v1/Api.php';

class Authenticate extends Api {

    function __construct(){
        // Construct the parent class
        parent::__construct();
		$this->load->model('MUserWeMo');
		// Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['register_post']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['login_post']['limit'] = 500; // 500 requests per hour per user/key
    }
	public function email_post(){
		$this->response([
			'data' => ['token'=>'aksjkasjaksaksjas']
		], REST_Controller::HTTP_OK);
	}
}
?>