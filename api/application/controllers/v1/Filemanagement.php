<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/v1/Api.php';

class Filemanagement extends Api {

    function __construct(){
        // Construct the parent class
        parent::__construct();
		$this->load->model('MUserWeMo');
		$this->load->model('MArtikel');
    }
	public function upload_post(){
		// upload gambar
		$upload=$this->uploadFile('photo' ,  './assets/general/images/preview/', 'photo');
		
		if($upload['error']){
			$this->response([
				'status' => FALSE,
				'message' => 'Terjadi kesalahan saat mengupload foto. '.$upload['result']
			], REST_Controller::HTTP_OK);
		}else{
			$preview=$upload['result'];
			
			$picture=explode('.',$preview);
			$name=$picture[0];
			$ekstensi=$picture[1];
			$this->response([
				'status' => TRUE,
				'message' => 'Berhasil mengupload foto.',
				'result' => $name.'.'.$ekstensi
			], REST_Controller::HTTP_OK);
		}
	}
}