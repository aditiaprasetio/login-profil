<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/v1/Api.php';
require_once APPPATH . 'libraries/vendor/autoload.php';

class Notif extends Api {

    function __construct(){
        // Construct the parent class
        parent::__construct();
		$this->load->model('MUserWeMo');
		$this->load->model('MNotif');
		// Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['register_post']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['login_post']['limit'] = 500; // 500 requests per hour per user/key
    }
	// public function push_post(){
		// // $unique_id=$this->get('unique_id');
		
		// $status=$this->post('status'); 
		// $jenis_sensor=$this->post('master_sensor_name'); 
		// $value=$this->post('latest_value');
		// $unit_symbol=$this->post('unit_symbol');
		// $lat=$this->post('lat');
		// $lng=$this->post('lng');
		
		// $listuser=$this->MUserWeMo->getListUserByLocation($lat, $lng);
		// if($listuser->num_rows()>0){
			// foreach($listuser->result_array() as $user){
				// $id_user=$user['user_id'];
				// $token=$user['notif_token'];
				// $unique_id='wemo_'.$id_user.'';
				
				// $interestDetails = [$unique_id, $token];
		  
				// // You can quickly bootup an expo instance
				// $expo = \ExponentPhpSDK\Expo::normalSetup();
				  
				// // Subscribe the recipient to the server
				// $expo->subscribe($interestDetails[0], $interestDetails[1]);
				 
				// if($status=='1'){			
					// // Build the notification data
					// $notification = ['title'=>$value.' '.$unit_symbol, 'body' => $jenis_sensor.' lebih/kurang dari ambang batas wajar.']; // data
				// }elseif($status=='0'){
					// // Build the notification data
					// $notification = ['title'=>$value.' '.$unit_symbol, 'body' => $jenis_sensor.' telah kembali normal.'];
				// }
				  
				// // Notify an interest with a notification
				// try{
					// $expo->notify($interestDetails[0], $notification);
					// echo 'a';
				// } catch(Exceptions $e){
					// echo 'b';
				// }
			// }
		// }else{
			// $this->response([
				// 'status' => FALSE,
				// 'message' => 'Tidak ada user di area ini.'
			// ], REST_Controller::HTTP_OK);
		// }
		
		// $this->response([
			// 'status' => TRUE,
			// 'message' => 'Notifikasi berhasil dikirim.'
		// ], REST_Controller::HTTP_OK);
	// }
	public function push_get(){
		// $unique_id=$this->get('unique_id');
		
		$status=$this->get('status'); 
		$jenis_sensor=$this->get('master_sensor_name'); 
		$value=$this->get('latest_value');
		$unit_symbol=$this->get('unit_symbol');
		$lat=$this->get('lat');
		$lng=$this->get('lng');
		
		$listuser=$this->MUserWeMo->getListUserByLocation($lat, $lng);
		// var_dump($listuser->result_array());
		// echo '<br/><br/><br/>';
		$no_user=true;
		if($listuser->num_rows()>0){
			// echo 'ada '.$listuser->num_rows().' user';
			// var_dump($listuser->result_array());
			foreach($listuser->result_array() as $key=>$user){
				// if($key<=1) continue;
				$id_user=$user['user_id'];
				$token=$user['notif_token'];
				$unique_id='wemo_'.$id_user.'';
				
				if($token==null){
					echo $token;
					continue;
				}else{
					$no_user=false;
				}
				
				// var_dump($user);echo '<br/>';
				// echo $token; echo '<br/>';
				// echo '--------------------------';echo '<br/>';
				
				$interestDetails = [$unique_id, $token];
		  
				// You can quickly bootup an expo instance
				$expo = \ExponentPhpSDK\Expo::normalSetup();
				  
				// Subscribe the recipient to the server
				$expo->subscribe($interestDetails[0], $interestDetails[1]);
				 
				if($status=='1'){			
					// Build the notification data
					$notification = ['title'=>$value.' '.$unit_symbol, 'body' => $jenis_sensor.' lebih/kurang dari ambang batas wajar.'];
				}elseif($status=='0'){
					// Build the notification data
					$notification = ['title'=>$value.' '.$unit_symbol, 'body' => $jenis_sensor.' telah kembali normal.'];
				}
				  
				// Notify an interest with a notification
				try{
					$expo->notify($interestDetails[0], $notification);
					echo 'a';
				} catch(Exceptions $e){
					echo 'b';
				}
				// insert notif 
				$datanotif=array(
					'id_notif'=>null,
					'id_user'=>$id_user,
					'title'=>$notification['title'],
					'body'=>$notification['body'],
					'isRead'=>0,
					'notifCreatedDate'=>null
				);
				$insert_notif=$this->MNotif->insertNotif($datanotif);
			}
			if($no_user){
				$this->set_response([
					'status' => FALSE,
					'message' => 'Ada '.$listuser->num_rows().' user. Tapi tidak dapat mengirim notifikasi.'
				], REST_Controller::HTTP_OK);
			}else{
				$this->set_response([
					'status' => TRUE,
					'message' => 'Notifikasi berhasil dikirim.'
				], REST_Controller::HTTP_OK);
			}
		}else{
			$this->set_response([
				'status' => FALSE,
				'message' => 'Tidak ada user di area ini.'
			], REST_Controller::HTTP_OK);
		}
	}
	
	public function pushme_get(){
		date_default_timezone_set("Asia/jakarta");
		$now_week=date('w');
		$day=array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu');
		$now_day=$day[$now_week];
		
		$now_time=date('H:i:s');
		$now_time='['.$now_time.'] ';
		
		$token=$this->get('token');
		
		$status=$this->get('status'); 
		$jenis_sensor=$this->get('master_sensor_name'); 
		$value=$this->get('latest_value');
		$unit_symbol=$this->get('unit_symbol');
		
		$id_user=$token;
		$unique_id='wemo_'.$id_user.'';
		
		$interestDetails = [$unique_id, $token];
  
		// You can quickly bootup an expo instance
		$expo = \ExponentPhpSDK\Expo::normalSetup();
		  
		// Subscribe the recipient to the server
		$expo->subscribe($interestDetails[0], $interestDetails[1]);
		 
		if($status=='1'){			
			// Build the notification data
			$title=$now_day.' - '.$value.' '.$unit_symbol;
			$body=$now_time.$jenis_sensor.' lebih/kurang dari ambang batas wajar.';
			$notification = ['title'=>$title, 'body' => $body];
		}elseif($status=='0'){
			// Build the notification data
			$title=$now_day.' - '.$value.' '.$unit_symbol;
			$body=$now_time.$jenis_sensor.' telah kembali normal.';
			$notification = ['title'=>$title, 'body' => $body];
		}
		  
		// Notify an interest with a notification
		$expo->notify($interestDetails[0], $notification);
		
		$this->set_response([
			'status' => TRUE,
			'message' => 'Notifikasi berhasil dikirim.'
		], REST_Controller::HTTP_OK);
	}
	
	public function list_get(){
		$id_user=$this->getIdUser();
		$result=$this->MNotif->getListNotif($id_user);
		$result_read=$this->MNotif->getListNotifRead($id_user);
		$this->set_response([
			'status' => TRUE,
			'message' => 'Berhasil mendapatkan notif',
			'result'=>$result,
			'result_read'=>$result_read
		], REST_Controller::HTTP_OK);
	}
	public function listuser_get(){
		$lat=$this->get('lat');
		$lng=$this->get('lng');
		
		if($lat=='null' || $lng=='null' || empty($lat) || empty($lng)){
			$lat=null;
			$lng=null;
		}
		$result=$this->MUserWeMo->getListUserByLocation($lat, $lng);
		
		$this->set_response([
			'status' => TRUE,
			'message' => 'Berhasil mendapatkan list user',
			'result'=>$result->result_array()
		], REST_Controller::HTTP_OK);
	}
	public function registerToken_post(){
		$id_user=$this->getIdUser();
		$reqparams=array(
			'token'
		);
		
		$token=$this->post('token');
		
		$postdata['token']=$token;

		$this->cekParams($reqparams, $postdata);
		$update=$this->MUserWeMo->updateNotifToken($id_user, $token);
		if($update){
			$this->response([
				'status' => TRUE,
				'message' => 'Update token berhasil.'
			], REST_Controller::HTTP_OK);
		}else{
			$this->response([
				'status' => FALSE,
				'message' => 'There is a problem. Please, try again.'
			], REST_Controller::HTTP_OK);
		}
	}
}
