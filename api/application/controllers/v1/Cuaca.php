<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/v1/Api.php';

class Cuaca extends Api {

    function __construct(){
        // Construct the parent class
        parent::__construct();
		$this->load->model('MUserWeMo');
		$this->load->model('MCuaca');
    }
	public function listdevice_get(){
		$id_user=$this->getIdUser();
		$myLat=$this->get('lat');
		$myLng=$this->get('lng');
		$unit='Km';
		
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
				$distance=$this->getDistanceBetween($myLat, $myLng, $lat, $lng, $unit);
				// $distance=$this->getDistanceBetween(-7.0485267, 110.4408383, $lat, $lng);
				// echo $dt->device_uuid.':'.$distance.'<br/>';
				
				if($terdekat==null){
					$terdekat['jarak']=$distance;
					$terdekat['unit']=$unit;
					$terdekat['device_uuid']=$dt->device_uuid;
					$terdekat['sensor_uuid']=$dt->user_sensor_uuid;
				}elseif($distance<$terdekat['jarak']){
					$terdekat['jarak']=$distance;
					$terdekat['unit']=$unit;
					$terdekat['device_uuid']=$dt->device_uuid;
					$terdekat['sensor_uuid']=$dt->user_sensor_uuid;
				}
			}
			$listdevice[$jenis]['terdekat']=$terdekat;
			$list_jenis[]=$jenis;
			$device_terdekat[$jenis]=$terdekat;
		}
		
		if(count($listdevice)==0){
			$this->response([
				'status' => FALSE,
				'message' => 'Device tidak ditemukan',
				'jenis' =>[],
				'result'=>[],
				], REST_Controller::HTTP_OK);
		}else{
			$this->response([
				'status' => TRUE,
				'message' => 'Device ditemukan',
				'result'=>array('jenis'=>$list_jenis, 'terdekat'=>$device_terdekat)
			], REST_Controller::HTTP_OK);
		}
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
	
	public function sensorvalues_get(){
		$json='{
				"page": "1",
				"next_page": "-",
				"device_uuid": "e12c58b54b6b4b5b91d06a3991edc457",
				"results": [
					{
						"sensor_uuid": "8d3655e349b44845abaa03e93d5a3f38",
						"sensor_values": [
							{
								"value": 112,
								"time_added": 1521367900.283463
							},
							{
								"value": 14,
								"time_added": 1521367892.754341
							},
							{
								"value": 14,
								"time_added": 1521367891.550465
							},
							{
								"value": 14,
								"time_added": 1521367890.455635
							},
							{
								"value": 14,
								"time_added": 1521367889.060306
							},
							{
								"value": 14,
								"time_added": 1521367868.552272
							},
							{
								"value": 12.4,
								"time_added": 1521367864.76314
							},
							{
								"value": 12.4,
								"time_added": 1521365772.567993
							}
						]
					},
					{
						"sensor_uuid": "e6a2b64dd73d443aad765d2e7e8958d9",
						"sensor_values": [
							{
								"value": 18,
								"time_added": 1521367900.283463
							},
							{
								"value": 18,
								"time_added": 1521367892.754341
							},
							{
								"value": 18,
								"time_added": 1521367891.550465
							},
							{
								"value": 18,
								"time_added": 1521367890.455635
							},
							{
								"value": 18,
								"time_added": 1521367889.060306
							},
							{
								"value": 133,
								"time_added": 1521367868.552272
							},
							{
								"value": 133,
								"time_added": 1521367864.76314
							},
							{
								"value": 133,
								"time_added": 1521365772.567993
							}
						]
					}
				],
				"result_per_sensor_count": 8,
				"listed_sensor_count": 2
			}';
		$this->response([
				'data'=>json_decode($json),
			], REST_Controller::HTTP_OK);
	}
	
}
