<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MUser extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('Crud');
	}
	
	function create($datausers){
		$result=$this->Crud->insert('users', $datausers);
		return $result;
	}
	function updateusers($cond, $data){
		$result=$this->Crud->update('users', $cond, $data);
		return $result;
	}
	function updateNotifToken($id_user, $notifToken){
		$result=$this->Crud->update('users', array('id_user'=>$id_user), array('notif_token'=>$notifToken));
		return $result;
	}
	function cekResetToken($token){
		$query='SELECT * FROM users WHERE token_reset_password="'.$token.'"';
		
		$result=$this->db->query($query);
		
		if($result->num_rows()>0){
			$data=array('status'=>true, 'result'=>$result);
		}else{
			$data=array('status'=>false);
		}
		return $data; 
	}
	function cekLogin($email, $password){
		if($password=='default') $query='SELECT * FROM users WHERE email="'.$email.'"';
		else $query='SELECT * FROM users WHERE email="'.$email.'" AND password="'.$password.'"';
		
		$result=$this->db->query($query);
		
		if($result->num_rows()>0){
			$data=array('status'=>true, 'result'=>$result);
		}else{
			$data=array('status'=>false);
		}
		return $data; 
	}
	function cekPassword($id_user, $password){
		$query='SELECT * FROM users WHERE id_user="'.$id_user.'" AND password="'.$password.'"';
		$result=$this->db->query($query);
		
		if($result->num_rows()>0){
			$data=array('status'=>true, 'result'=>$result);
		}else{
			$data=array('status'=>false);
		}
		return $data; 
	}
	function isValidToken($email, $password){
		$query='SELECT * FROM users WHERE email="'.$email.'" AND password="'.$password.'"';
		$result=$this->db->query($query);
		
		if($result->num_rows()>0){
			$data=array('status'=>true, 'result'=>$result);
		}else{
			$data=array('status'=>false);
		}
		return $data; 
	}
	
	function isCanUse($id){
		$query='SELECT * FROM users WHERE email="'.$id.'"';
		$result=$this->db->query($query);
		
		if($result->num_rows()>0) return false;
		else return true; 
	}
	
	function isCanUseByUpdate($id, $id_user){
		$query='SELECT * FROM users WHERE email="'.$id.'" AND id_user!="'.$id_user.'"';
		$result=$this->db->query($query);
		
		if($result->num_rows()>0) return false;
		else return true; 
	}

	function isConnectApps($id, $apps){
		$query='SELECT * FROM connect_apps WHERE id_user="'.$id.'" AND apps="'.$apps.'"';
		$result=$this->db->query($query);
		
		if($result->num_rows()>0) return true;
		else return false; 
	}
	
	function isAppsRegistered($account_id, $apps){
		$query='SELECT * FROM connect_apps ca LEFT JOIN users u ON ca.id_user=u.id_user WHERE ca.account_id="'.$account_id.'" AND ca.apps="'.$apps.'"';
		$result=$this->db->query($query);
		
		if($result->num_rows()>0){
			return $result->row_array();
		}else{
			return false; 
		}
	}
	
	function isKodeValid($kode_aktivasi){
		$query='SELECT * FROM users WHERE kode_aktivasi="'.$kode_aktivasi.'"';
		$result=$this->db->query($query);
		if($result->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	
	function aktivasi($kode_aktivasi){
		$result=$this->Crud->update('users', array('kode_aktivasi'=>$kode_aktivasi), array('status_users'=>1));
		return $result;
	}
	
	function getApps($id_user){
		$query='SELECT * FROM connect_apps WHERE id_user="'.$id_user.'"';
		$result=$this->db->query($query);
		
		return $result;
	}
	function addApps($id_user, $apps, $account_id, $name){
		$data=array(
			'id_user'=>$id_user,
			'apps'=>$apps,
			'account_id'=>$account_id,
			'name'=>$name
		);
		$result=$this->db->insert('connect_apps', $data);
		
		return $result;
	}
	function getDetailUser($id){
		$query='SELECT * FROM users WHERE id_user="'.$id.'"';
		$result=$this->db->query($query);
		
		return $result;
	}
	
	function getListUserByLocation($lat, $lng){
		if($lat==null || $lng==null){
			$query='SELECT *
			FROM users
			ORDER BY fullname ASC';
			// var_dump($query);
		}else{
			$query='SELECT email, fullname,
			  id_user, (
				3959 * acos (
				  cos ( radians('.$lat.') )
				  * cos( radians( lat ) )
				  * cos( radians( lng ) - radians('.$lng.') )
				  + sin ( radians('.$lat.') )
				  * sin( radians( lat ) )
				)
			  ) AS distance,
			  notif_token, lat, lng
			FROM users
			HAVING distance < 30
			ORDER BY distance';
			// var_dump($query);
		}
		
		$result=$this->db->query($query);
		
		return $result;
	}

	function createFeedback($data){
		$result=$this->db->insert('feedback', $data);
		return $result;
	}
	
	function getListFeedback(){
		$query='SELECT f.*, u.fullname, u.id_user FROM feedback f LEFT JOIN users u ON f.id_user=u.id_user ORDER BY f.id_feedback DESC';
		
		$result=$this->db->query($query);
		
		return $result;
	}
}