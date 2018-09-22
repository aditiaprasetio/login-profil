<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}
	
	function do_query($doquery){
		$query = $this->db->query($doquery);
		return $query;
	}

	function insert($table, $data){
		$data['query'] = $this->db->insert($table, $data);
		$data['last_id'] = $this->db->insert_id();
		return $data;
	}

	function read($table, $cond, $ordField, $ordType){
		if($cond!=null){
			$this->db->where($cond);
		}
		if($ordField!=null){
			$this->db->order_by($ordField, $ordType);
		}
		$query = $this->db->get($table);
		return $query;
	}
	
	function update($table, $cond, $data){
		$this->db->where($cond);
		$query = $this->db->update($table, $data);
		return $query;
	}

	function delete($table, $cond){
		$this->db->where($cond);
		$query = $this->db->delete($table);
		return $query;
	}
}