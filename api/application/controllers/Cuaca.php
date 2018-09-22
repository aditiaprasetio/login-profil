<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuaca extends MY_Controller {
	private $data; 

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('MCuaca');
	}

	public function index(){
		$this->isLogin();
		$this->data['title']='Dashboard Cuaca';
		$this->data['deskripsi']='Panel Admin';
		
		$this->data['listdevice']['suhu_internal']=$this->MCuaca->getListDevice('ti');
		$this->data['listdevice']['suhu_eksternal']=$this->MCuaca->getListDevice('te');
		
		$this->load->view('admins/_header', $this->data);
		$this->load->view('admins/_sidebar', $this->data);
		$this->load->view('admins/cuaca_index', $this->data);
		$this->load->view('admins/_footer');
	}
	public function sync(){
		$this->isLogin();
		$this->data['title']='Dashboard Cuaca';
		$this->data['deskripsi']='Panel Admin';
		
		// $this->data['listdevice']=$this->MCuaca->getListDevice();
		
		$this->load->view('admins/_header', $this->data);
		$this->load->view('admins/_sidebar', $this->data);
		$this->load->view('admins/cuaca_listdevice', $this->data);
		$this->load->view('admins/_footer');
	}
	public function getListDevice(){
		$this->isLogin();
		$myLat=$this->input->get('lat');
		$myLng=$this->input->get('lng');
		
		$listjenis=$this->MCuaca->getListJenis();
		foreach($listjenis->result() as $dt){
			$listdevice[$dt->id_type]=$this->MCuaca->getListDevice($dt->id_type)->result();
		}
		$terdekat=null;
		// hitung jarak
		foreach($listdevice as $jenis=>$sensor){
			foreach($sensor as $dt){
				$lat=$dt->position_lat;
				$lng=$dt->position_lng;
				$distance=$this->getDistanceBetween($myLat, $myLng, $lat, $lng);
				// $distance=$this->getDistanceBetween(-7.0485267, 110.4408383, $lat, $lng);
				echo $dt->device_uuid.':'.$distance.'<br/>';
				
				if($terdekat==null){
					$terdekat['jarak']=$distance;
					$terdekat['device_uuid']=$dt->device_uuid;
					$terdekat['sensor_uuid']=$dt->user_sensor_uuid;
				}elseif($distance<$terdekat['jarak']){
					$terdekat['jarak']=$distance;
					$terdekat['device_uuid']=$dt->device_uuid;
					$terdekat['sensor_uuid']=$dt->user_sensor_uuid;
				}
			}
			$listdevice[$jenis]['terdekat']=$terdekat;
		}
		// var_dump($jarak['suhu']);
		echo 'TERDEKAT : '.$terdekat['jarak'].' : '.$terdekat['device_uuid'];
		
		$listdevice=json_encode($listdevice);
		echo $listdevice;
	}
	function getDistanceBetween($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Mi') { 
		$theta = $longitude1 - $longitude2; 
		$distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2)))  + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta))); 
		$distance = acos($distance); 
		$distance = rad2deg($distance); 
		$distance = $distance * 60 * 1.1515; 
		switch($unit) 
		{ 
			case 'Mi': break; 
			case 'Km' : $distance = $distance * 1.609344; 
		} 
		return (round($distance,2)); 
	}
	public function createAuth(){
		$email='fauzanilzaki@gmail.com';
		$password='zakizaki';
		$body=array('email'=>$email, 'password'=>$password);
		$body=json_encode($body);
		
		$data = array("email" => $email, "password" => $password);                                                                    
		$data_string = json_encode($data);                                                                                   
																															 
		$ch = curl_init('https://sidik.rumahiot.panjatdigital.com/authenticate/email');                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, '{"email":"fauzanilzaki@gmail.com", "password":"zakizaki"}');                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/x-www-form-urlencoded',                                                                                
			'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                   
																															 
		$result = curl_exec($ch);

        curl_close( $ch );                     // Stop atau tutup script

		$result=json_decode($result);
        var_dump($result);
	}
	public function addSensor(){
		$this->isLogin();
		
		$device_uuid=$this->input->get('device_uuid');
		$position_lat=$this->input->get('position_lat');
		$position_lng=$this->input->get('position_lng');
		$location_text=$this->input->get('location_text');
		$read_key=$this->input->get('read_key');
		$write_key=$this->input->get('write_key');
		
		$dataDevice=array(
			'device_uuid'=>$device_uuid,
			'position_lat'=>$position_lat,
			'position_lng'=>$position_lng,
			'location_text'=>$location_text,
			'read_key'=>$read_key,
			'write_key'=>$write_key
		);
		
		$user_sensor_uuid=$this->input->get('user_sensor_uuid');
		$user_sensor_name=$this->input->get('user_sensor_name');
		$master_sensor_name=$this->input->get('master_sensor_name');
		$unit_name=$this->input->get('unit_name');
		$unit_symbol=$this->input->get('unit_symbol');
		$sensor_type=$this->input->get('sensor_type');
		
		$dataSensor=array(
			'user_sensor_uuid'=>$user_sensor_uuid,
			'device_uuid'=>$device_uuid,
			'user_sensor_name'=>$user_sensor_name,
			'master_sensor_name'=>$master_sensor_name,
			'unit_name'=>$unit_name,
			'unit_symbol'=>$unit_symbol,
			'sensor_type'=>$sensor_type
		);
		
		$addSensor=$this->MCuaca->addSensor($dataDevice, $dataSensor);
		
	}
	public function addSensorJs(){
		$this->isLogin();
		
		$results=$this->input->post('results'); // berisi array
		
		foreach($results as $key=>$device){
			$dataDevice=array(
				'device_uuid'=>$device['device_uuid'],
				'position_lat'=>$device['position']['lat'],
				'position_lng'=>$device['position']['lng'],
				'location_text'=>$device['location_text'],
				'read_key'=>$device['read_key'],
				'write_key'=>$device['write_key']
			);
			
			foreach($device['device_sensors'] as $key1=>$sensor){
				$dataSensor=array(
					'user_sensor_uuid'=>$sensor['user_sensor_uuid'],
					'device_uuid'=>$device['device_uuid'],
					'user_sensor_name'=>$sensor['user_sensor_name'],
					'master_sensor_name'=>$sensor['master_sensor_name'],
					'unit_name'=>$sensor['unit_name'],
					'unit_symbol'=>$sensor['unit_symbol'],
					'sensor_type'=>null
				);
				
				$addSensor=$this->MCuaca->addSensor($dataDevice, $dataSensor);
				// echo 'SENSOR '.$sensor['user_sensor_name'];
				// if($addSensor) echo ' SUKSES<br/>';
				// else echo ' GAGAL<br/>';
			}
		}
		
		echo 'Sinkronisasi Berhasil';
		// var_dump($results);
		// echo 'OKE';
	}
	public function updateJenis(){
		$user_sensor_uuid=$this->input->post('sensor_uuid');
		$sensor_type=$this->input->post('jenis_sensor');
		
		// cek
		$cek=$this->MCuaca->cekSensor($user_sensor_uuid);
		if($cek->num_rows()==0){
			echo '<div class="label label-danger">Sensor belum disimpan. Lakukan sinkronisasi terlebih dahulu </div>';
		}else{			
			$update=$this->MCuaca->updateSensor($user_sensor_uuid, array('sensor_type'=>$sensor_type));
			
			if($sensor_type=='ti') $tipe='Suhu Internal';
			elseif($sensor_type=='te') $tipe='Suhu Eksternal';
			elseif($sensor_type=='hd') $tipe='Kelembapan';
			
			echo '<div class="label label-primary">Tipe : '.$tipe.'</div>';
		}
	}
	public function getJenis(){
		$user_sensor_uuid=$this->input->post('user_sensor_uuid');
		
		// cek
		$cek=$this->MCuaca->cekSensor($user_sensor_uuid);
		if($cek->num_rows()==0){
			echo '<div class="label label-danger">Sensor belum disimpan. Lakukan sinkronisasi terlebih dahulu </div>';
		}else{
			$result=$cek->row_array();
			$sensor_type=$result['sensor_type'];
			
			if($sensor_type==null){
				echo '<div class="label label-default">Belum ditentukan</div>';
				exit;
			}
			
			if($sensor_type=='ti') $tipe='Suhu Internal';
			elseif($sensor_type=='te') $tipe='Suhu Eksternal';
			elseif($sensor_type=='hd') $tipe='Kelembapan';
			
			echo '<div class="label label-primary">Tipe : '.$tipe.'</div>';
		}
	}
}