<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends MY_Controller {
	private $data; 

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('MArtikel');
		$this->load->model('MUserWeMo');
	}

	public function index(){
		$this->isLogin();
		
		$this->data['listkategori']=$this->MArtikel->getListKategori();
		$this->data['listartikel']=$this->MArtikel->getListArtikel();
		
		if($this->input->get('do')=='edit'){
			$slug=$this->input->get('id');
			$this->data['artikel']=$this->MArtikel->getDetail($slug)->row_array();
			$this->data['listkategoriArtikel']=$this->MArtikel->getKategoriById($this->data['artikel']['id_artikel']);
		}
		
		$this->load->view('admins/_header', $this->data);
		$this->load->view('admins/_sidebar', $this->data);
		$this->load->view('admins/artikel', $this->data);
		$this->load->view('admins/_footer');
	}
	
	public function feedback(){
		$this->isLogin();
		
		$this->data['listfeedback']=$this->MUserWeMo->getListFeedback();
		
		$this->load->view('admins/_header', $this->data);
		$this->load->view('admins/_sidebar', $this->data);
		$this->load->view('admins/feedback', $this->data);
		$this->load->view('admins/_footer');
	}
	public function add(){
		$this->isLogin();
		
		$this->data['listkategori']=$this->MArtikel->getListKategori();

		$this->load->view('admins/_header', $this->data);
		$this->load->view('admins/_sidebar', $this->data);
		$this->load->view('admins/artikel_add', $this->data);
		$this->load->view('admins/_footer');
	}
	public function edit($slug){
		$this->isLogin();
		
		$this->data['artikel']=$this->MArtikel->getDetail($slug);
		if($this->data['artikel']->num_rows()==0){
			redirect(site_url('artikel?respon=failed&message=Article is not found.'));
		}else{
			$this->data['artikel']=$this->data['artikel']->row_array();
		}
		$this->data['listkategori']=$this->MArtikel->getListKategori();
		$this->data['listkategoriArtikel']=$this->MArtikel->getKategoriById($this->data['artikel']['id_artikel']);

		$this->load->view('admins/_header', $this->data);
		$this->load->view('admins/_sidebar', $this->data);
		$this->load->view('admins/artikel_edit', $this->data);
		$this->load->view('admins/_footer');
	}
	public function tags(){		
		$this->isLogin();
		
		$this->data['listkategori']=$this->MArtikel->getListKategori();
		
		$this->load->view('admins/_header', $this->data);
		$this->load->view('admins/_sidebar', $this->data);
		$this->load->view('admins/tags', $this->data);
		$this->load->view('admins/_footer');
	}

	public function delete_artikel_proses($id_artikel=null){		
		$this->isLogin();
		$id=$this->session->userdata('id');
		
		if($id_artikel==null) redirect('artikel?respon=failed&message=Article is not found.');
	
		$delete=$this->MArtikel->deleteArtikel($id_artikel);
		if($delete){
			redirect('artikel?respon=success&message=Your article is success to delete.');
		}else{
			redirect('artikel?respon=failed&message=There is a problem. Please, try again.');
		}
	}
	
	public function publish_proses($id_artikel=null){		
		$this->isLogin();
		$id=$this->session->userdata('id');
		
		if($id_artikel==null) redirect('artikel?respon=failed&message=Article is not found.');
	
		$publish=$this->MArtikel->publishArtikel($id_artikel);
		if($publish){
			redirect('artikel?respon=success&message=Your article is success to publish.');
		}else{
			redirect('artikel?respon=failed&message=There is a problem. Please, try again.');
		}
	}
	public function unpublish_proses($id_artikel=null){		
		$this->isLogin();
		$id=$this->session->userdata('id');
		
		if($id_artikel==null) redirect('artikel?respon=failed&message=Article is not found.');
	
		$publish=$this->MArtikel->unpublishArtikel($id_artikel);
		if($publish){
			redirect('artikel?respon=success&message=Your article is success to unpublish.');
		}else{
			redirect('artikel?respon=failed&message=There is a problem. Please, try again.');
		}
	}
	public function add_artikel_proses(){		
		$this->isLogin();
		$id=$this->session->userdata('id');
		
		$submit=$this->input->post('submit');
		
		if($submit=='Save and Publish'){
			$publish=1;
		}elseif($submit=='Save as Draft'){
			$publish=0;
		}
		
		$judul=$this->input->post('judul');
		
		$unique=date('ms').rand(1000,9999);
		$slug=$this->buatslug($judul).'-'.$unique;
		
		$tipe=$this->input->post('tipe');
		$isiartikel=$this->input->post('isiartikel');
		$kategori=$this->input->post('kategori');
		$youtube=$this->input->post('youtube');
		
		//upload
		$upload=$this->uploadfile($_FILES, 'preview', './assets/general/images/preview/', 'jpeg||png||jpg', '10548');
		if($upload['error']){
			redirect(site_url('artikel?do=add&respon=failed&message=Failed to upload image.'));
		}else{
			$preview=$upload['result'];
		}
		
		$data=array(
			'id_artikel'=>null,
			'id'=>$id,
			'slug'=>$slug,
			'tipe'=>$tipe,
			'judul'=>$judul,
			'isiartikel'=>$isiartikel,
			'preview'=>$preview,
			'youtube'=>$youtube,
			'publish'=>$publish,
			'createDate'=>null,
			'lastUpdate'=>null,
			'hit'=>1
		);
		
		$insert=$this->MArtikel->create($data);
		if($insert){
			if(is_array($kategori) && count($kategori)>0){
				$insert_kategori=$this->MArtikel->addKategori($insert['last_id'], $kategori);
				if(!$insert_kategori){
					redirect(site_url('artikel?respon=failed&message=There is a problem while add tags. Please edit your article.'));
				}
			}
			redirect(site_url('artikel?respon=success&message=Congratulations. Your article is saved.'));
		}else{
			redirect(site_url('artikel?respon=failed&message=There is a problem. Please try again.'));
		}
	}
	public function update_artikel_proses($id_artikel=null){		
		$config['global_xss_filtering'] = FALSE;
		$this->isLogin();
		$id=$this->session->userdata('id');
		
		if($id_artikel==null) redirect('artikel?respon=failed&message=Article is not found.');
		
		$submit=$this->input->post('submit');
		$judul=$this->input->post('judul');
		
		$isiartikel=$this->input->post('isiartikel');
		$kategori=$this->input->post('kategori');
		$youtube=$this->input->post('youtube');
		
		$isiartikel=$this->input->post('isiartikel');
		// $allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
		// $allowedTags.='<li><ol><ul><span><div><br><br/><ins><del>'; 
		// $isiartikel=strip_tags(stripslashes($isiartikel),$allowedTags);
		
		if($submit=='Save and Publish'){
			$publish=1;
		}elseif($submit=='Save as Draft'){
			$publish=0;
		}
		
		//upload
		if(isset($_FILES)){
			$upload=$this->uploadfile($_FILES, 'preview', './assets/general/images/preview/', 'jpeg||png||jpg', '10548');
			if($upload['error']){
				redirect(site_url('artikel?do=add&respon=failed&message=Failed to upload image.'));
			}else{
				$data['preview']=$upload['result'];
			}
		}
		
		$datacek=array('id_artikel'=>$id_artikel);
		$data=array(
			'judul'=>$judul,
			'isiartikel'=>$isiartikel,
			'youtube'=>$youtube,
			'publish'=>$publish,
			'lastUpdate'=>date('Y-m-d')
		);
		
		$insert=$this->MArtikel->updateArtikel($datacek,$data);
		if($insert){
			if(is_array($kategori) && count($kategori)>0){
				$insert_kategori=$this->MArtikel->addKategori($id_artikel, $kategori);
				if(!$insert_kategori){
					redirect(site_url('artikel?respon=failed&message=There is a problem while add tags. Please edit your article.'));
				}
			}
			redirect(site_url('artikel?respon=success&message=Congratulations. Your article is saved.'));
		}else{
			redirect(site_url('artikel?respon=failed&message=There is a problem. Please try again.'));
		}
	}
	
	public function add_kategori_proses(){		
		$this->isLogin();
		$id=$this->session->userdata('id');
		
		$nama_kategori=$this->input->post('nama_kategori');
		
		$data=array(
			'id_kategori'=>null,
			'nama_kategori'=>$nama_kategori
			);
		$insert=$this->MArtikel->createKategori($data);
		if($insert){
			redirect(site_url('admins/tags?respon=success&message=Congratulations. Your tag is saved.'));
		}else{
			redirect(site_url('admins/tags?respon=failed&message=There is a problem. Please try again.'));
		}
	}
	function getArtikel(){
		$dt=$this->Crud->do_query('SELECT * FROM artikel ORDER BY id_artikel DESC LIMIT 0,5')->result_array();
		for($i=0;$i<5;$i++){
			if(isset($dt[$i])){
				// $url_img=base_url('assets/img/kontenpreview/'.$dt[$i]['preview_konten']);
				$url=site_url('blog/'.$dt[$i]['slug']);
				echo '<div class="blog-list-top">
							<div class="blog-text">
								<p><a href="'.$url.'">'.$dt[$i]["judul"].'</a></p>
								<span class="link">
									'.$dt[$i]["tgl_dibuat"].'
								</span>
							</div>
							<div class="clearfix"> </div>
						</div>';
			}
		}
	}
	
}
?>