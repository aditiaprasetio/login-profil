<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/v1/Api.php';

class Artikel extends Api {

    function __construct(){
        // Construct the parent class
        parent::__construct();
		$this->load->model('MUserWeMo');
		$this->load->model('MArtikel');
    }
	public function listkategori_get(){
		$list=$this->MArtikel->getListKategori();
		$this->response([
				'status' => TRUE,
				'message' => 'Berhasil mengambil list kategori.',
				'result' => $list->result_array()
			], REST_Controller::HTTP_OK);
	}
	public function send_post(){
		$id_user=$this->getIdUser();
		$reqparams=array(
			'judul', 'isiartikel'
		);
		
		$judul=$this->post('judul');
		$tipe='informasi';
		$isiartikel=$this->post('isiartikel');
		$preview=$this->post('preview');
		$kategori=$this->post('kategori');
		
		$postdata['judul']=$judul;
		$postdata['isiartikel']=$isiartikel;
		$postdata['preview']=$preview;

		$this->cekParams($reqparams, $postdata);
		
		$unique=date('ms').rand(1000,9999);
		$slug=$this->buatslug($judul).'-'.$unique;
		
		//upload gambar
		// $upload=$this->uploadfile($_FILES, 'preview', './assets/general/images/preview/', 'jpeg||png||jpg', '10548');
		// if($upload['error']){
			// redirect(site_url('admins/articles?do=add&respon=failed&message=Failed to upload image.'));
		// }else{
			// $preview=$upload['result'];
		// }
		
		$data=array(
			'id_artikel'=>null,
			'id_user'=>$id_user,
			'slug'=>$slug,
			'tipe'=>$tipe,
			'judul'=>$judul,
			'isiartikel'=>$isiartikel,
			'preview'=>$preview,
			'youtube'=>null,
			'publish'=>1,
			'createDate'=>null,
			'lastUpdate'=>null,
			'hit'=>1
		);
		
		$insert=$this->MArtikel->create($data);
		if($insert){
			if(is_array($kategori) && count($kategori)>0){
				$insert_kategori=$this->MArtikel->addKategori($insert['last_id'], $kategori);
			}else{
				$insert_kategori=$this->MArtikel->addKategori($insert['last_id'], array($kategori));
			}
			$this->response([
					'status' => TRUE,
					'message' => 'Informasi berhasil dikirim.'
				], REST_Controller::HTTP_OK);
		}else{
			$this->response([
				'status' => FALSE,
				'message' => 'Oops. Ada sedikit masalah. Mohon coba lagi.'
			], REST_Controller::HTTP_OK);
		}
	}
	public function search_get(){
		$id_user=$this->getIdUser();
		$tipe=$this->get('tipe');
		$search=$this->get('keyword');
		
		if($search==null) $keyword=array();
		else $keyword=array($search);
		
		$listartikel=$this->MArtikel->search($keyword, $tipe, 10);
		
		if($listartikel->num_rows()==0){
			$this->response([
					'status' => FALSE,
					'message' => 'Informasi tidak ditemukan'
				], REST_Controller::HTTP_OK);
		}else{
			$artikel=array();
			foreach($listartikel->result_array() as $key=>$value){
				$artikel[$key]=$value;
				// nama
				if($value['id_user']==null && $value['id']!=null ){
					$artikel[$key]['full_name']='Administrator';
				}
				
				// preview small
				$picture=explode('.',$value['preview']);
				$name=$picture[0].'_thumb';
				// $name=$picture[0];
				$ekstensi=$picture[1];
				$artikel[$key]['preview_small']=$name.'.'.$ekstensi;
			}
			$this->response([
				'status' => TRUE,
				'message' => 'Informasi ditemukan',
				'result'=>$artikel
			], REST_Controller::HTTP_OK);
		}
	}
	
}
