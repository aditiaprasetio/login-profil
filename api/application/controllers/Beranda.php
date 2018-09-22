<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends MY_Controller {
	private $data; 
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('MArtikel');
		$this->load->model('MGallery');
		
		$this->load->model('MWebsite');
		$this->data['web']=$this->MWebsite->getProfil();
		
		$keyword_news=array('Berita');
		$this->data['news']=$this->MArtikel->search($keyword_news);
		$keyword_event=array('Event');
		$this->data['event']=$this->MArtikel->search($keyword_event);
	}
	public function index()
	{
		$this->data['menu']='Homepage';
		// $this->data['title_page']='homepage';
		
		$this->data['listartikel']=$this->MArtikel->getListArtikelHomepage();
		
		$this->data['artikelterbaru']=$this->MArtikel->getListArtikelTerbaru();
		$this->data['artikelpopuler']=$this->MArtikel->getListArtikelPopuler();
		$this->data['listkategori']=$this->MArtikel->getListKategori();
		
		$this->load->view('layout/_header', $this->data);
		$this->load->view('homepage', $this->data);
		$this->load->view('layout/right_sidebar', $this->data);
		$this->load->view('layout/_footer', $this->data);
	}
	public function about()
	{
		// $this->data['title_page']='homepage';
		$this->data['menu']='Profil';
		
		$this->load->view('layout/_header', $this->data);
		$this->load->view('about', $this->data);
		$this->load->view('layout/_footer', $this->data);
	}
	public function set(){
		$lang=$this->input->get('lang');
		$go=$this->input->get('go');
		
		$cookie= array(
           'name'   => 'lang',
           'value'  => $lang,
		   'expire' => '0',
		);
		
       $this->input->set_cookie($cookie);
		redirect($go);
	}
	public function blog(){
		$type=$this->input->get('type');
		
		if($type==null) $this->data['menu']='Blog';
		else{
			if($type=='artikel') $type='Artikel';
			if($type=='informasi') $type='Informasi';
			$this->data['menu']=$type;
		}
		
		if(count($_GET)>0){
			$keyword=array();
			foreach($_GET as $key=>$value){
				if(!empty($value)) $keyword[]=$value;
			}
		}
		// $this->data['title_page']='homepage';
		
		if($type==null) $this->data['listartikel']=$this->MArtikel->getListArtikelHomepage();
		if(count($_GET)>0){
			$this->data['listartikel']=$this->MArtikel->search($keyword);
		}
		
		$this->data['artikelterbaru']=$this->MArtikel->getListArtikelTerbaru();
		$this->data['artikelpopuler']=$this->MArtikel->getListArtikelPopuler();
		$this->data['listkategori']=$this->MArtikel->getListKategori();
		
		$this->load->view('layout/_header', $this->data);
		$this->load->view('blog', $this->data);
		$this->load->view('layout/_footer', $this->data);
	}
	public function post($slug){
		$this->data['menu']='Post';
		$this->data['title_page']='Post';
		
		$this->data['artikelpopuler']=$this->MArtikel->getListArtikelPopuler();
		$this->data['artikelterbaru']=$this->MArtikel->getListArtikelTerbaru();
		$this->data['artikel']=$this->MArtikel->getDetail($slug)->row_array();
		$this->data['listkategori']=$this->MArtikel->getKategoriById($this->data['artikel']['id_artikel']);
		
		$this->MArtikel->addHit($this->data['artikel']['id_artikel']);
		
		if($this->data['artikel']['youtube']!=null && $this->data['artikel']['youtube']!=''){
			$youtube=explode('=',$this->data['artikel']['youtube']);
			$this->data['artikel']['youtube']='https://www.youtube.com/embed/'.$youtube[1];
		}else{
			$this->data['artikel']['youtube']=null;
		}
		
		$this->load->view('layout/_header',$this->data);
		$this->load->view('detail', $this->data);
		$this->load->view('layout/right_sidebar', $this->data);
		$this->load->view('layout/_footer', $this->data);
	}
	public function galeri($id_album=null){
		$this->data['menu']='Gallery';
		
		if($id_album==null){
			$this->data['listalbum']=$this->MGallery->getListAlbum();
		}else{
			$this->data['listfoto']=$this->MGallery->getListImage($id_album);
			$this->data['album']=$this->MGallery->getInfoAlbum($id_album)->row_array();
		}
		$this->load->view('layout/_header',$this->data);
		$this->load->view('gallery', $this->data);
		$this->load->view('layout/_footer', $this->data);
	}
	public function search(){
		$this->data['menu']='Search';
		$keyword=array();
		foreach($_GET as $key=>$value){
			if(!empty($value)) $keyword[]=$value;
		}
		
		$this->data['artikelterbaru']=$this->MArtikel->getListArtikelTerbaru();
		$this->data['artikelpopuler']=$this->MArtikel->getListArtikelPopuler();
		$this->data['listkategori']=$this->MArtikel->getListKategori();
		$this->data['listartikel']=$this->MArtikel->search($keyword);
		
		$this->load->view('layout/_header',$this->data);
		$this->load->view('homepage', $this->data);
		$this->load->view('layout/right_sidebar', $this->data);
		$this->load->view('layout/_footer', $this->data);
	}
	public function sendform(){
		$go=$this->input->get('go');
		$name=$this->input->post('name');
		$email=$this->input->post('email');
		$message=$this->input->post('message');
		
		$message1='Email dari '.$name.' ('.$email.')<br/><b>Pesan : </b><br/>'.$message;
		$subject='Message by Form via jihadstory.com';
		
		$this->kirimemail_keadmin($subject, $message1);
		
		redirect($go);
	}
}
