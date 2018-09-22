<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admins extends MY_Controller {
	private $data; 

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('MArtikel');
		$this->load->model('MGallery');
	}

	public function index(){
		$this->data['title']='Dashboard';
		$this->data['deskripsi']='Panel Admin';
		
		$artikel=$this->MArtikel->getListArtikel();
		$this->data['jumlahartikel']=$artikel->num_rows();
		$kategori=$this->MArtikel->getListKategori();
		$this->data['jumlahkategori']=$kategori->num_rows();
		
		$this->load->view('admins/_header', $this->data);
		$this->load->view('admins/_sidebar', $this->data);
		$this->load->view('admins/dashboard', $this->data);
		$this->load->view('admins/_footer');
	}
	public function setting(){
		$this->data['title']='Setting';
		$this->data['deskripsi']='Setting';
		
		$this->load->model('MWebsite');
		$this->data['web']=$this->MWebsite->getProfil();
		
		$this->load->view('admins/_header', $this->data);
		$this->load->view('admins/_sidebar', $this->data);
		$this->load->view('admins/setting', $this->data);
		$this->load->view('admins/_footer');
	}
	
	public function update_setting_proses(){		
		$this->isLogin();
		$id=$this->session->userdata('id');
		
		$this->load->model('MWebsite');
		$id_setting=$this->input->post('id_setting');
		$value=$this->input->post('value');
		
		$update=$this->MWebsite->updateSetting($id_setting, $value);
		if($update){
			redirect(site_url('admins/setting?respon=success&message=Success.'));
		}else{
			redirect(site_url('admins/setting?respon=failed&message=There is a problem. Please try again.'));
		}
	}
}
?>