<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notif extends MY_Controller {
	private $data; 
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('MArtikel');
		$this->load->model('MGallery');
	}
	public function index()
	{
		$this->data['menu']='Notification Tool';
		
		$this->load->view('notification', $this->data);
	}
}
