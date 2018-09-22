<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/v1/Api.php';

class Cuaca extends Api {

    function __construct(){
        // Construct the parent class
        parent::__construct();
		$this->load->model('MUserWeMo');
		$this->load->model('MCuaca');
    }
	public function retrieve_get(){
		
		$this->response([
			'status' => TRUE,
			'message' => 'Device ditemukan',
			'result'=>array('jenis'=>$list_jenis, 'terdekat'=>$device_terdekat)
		], REST_Controller::HTTP_OK);
	}
}
