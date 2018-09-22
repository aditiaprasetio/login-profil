<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'controllers/v1/Api.php';

class Device extends Api {

    function __construct(){
		date_default_timezone_set("Asia/Jakarta"); 
        // Construct the parent class
        parent::__construct();
		$this->load->model('MUserWeMo');
		$this->load->model('MCuaca');
    }
	public function list_get(){
		$list=file_get_contents(APPPATH . '/controllers/retrieve/listdevice.json');
		$list=json_decode($list);
		
		$data[]=file_get_contents(APPPATH . '/controllers/retrieve/undip_feb.json');
		$data[]=file_get_contents(APPPATH . '/controllers/retrieve/undip_fsm.json');
		$data[]=file_get_contents(APPPATH . '/controllers/retrieve/undip_rektorat.json');
		
		foreach($data as $key=>$value){
			$tmp_data=json_decode($value);
			$list->data->results[]=$tmp_data;
		}
		
		foreach($list->data->results as $key=>$value){
			foreach($list->data->results[$key]->device_sensors as $key1=>$value1){
				$master_sensor_name=$list->data->results[$key]->device_sensors[$key1]->master_sensor_name;
				if($master_sensor_name=='Atmospheric Pressure'){
					$list->data->results[$key]->device_sensors[$key1]->latest_value=rand(1000,2000)/1000;
				}else{
					$list->data->results[$key]->device_sensors[$key1]->latest_value=rand(0,100);
				}
				$list->data->results[$key]->device_sensors[$key1]->latest_value_added=time();
			}
		}
		
		$this->response($list, REST_Controller::HTTP_OK);
	}
	public function data_get(){
		$device_uuid=$this->get('device_uuid');
		
		$kode=substr($device_uuid, strlen($device_uuid)-3, 3);
		
		$l=$this->get('l');
		$fd=$this->get('fd');
		$td=$this->get('td');
		$o=$this->get('o');
		
		$fd=$td-(1*24*60*60)+1;
		$int=($td-$fd)/20;
		
		$now=time();
		if($fd>$now){
			$listsensor=array(
				"error"=>array("code"=>200, "message"=>"Data tidak ditemukan. Silakan pilih tanggal waktu saat ini atau hari sebelumnya.")
			);
			$this->response($listsensor, REST_Controller::HTTP_OK);
		}else{
			$list=file_get_contents(APPPATH . '/controllers/retrieve/undip_'.$kode.'.json');
			$list=json_decode($list);
			
			for($i=0; $i<20; $i++){
				$timestamp=$td-($i*$int);
				$str_date=gmdate("Y-m-d\TH:i:s\Z", $timestamp);
				$data_value[]=array(
					'value'=>rand(0,120),
					'time_added'=>$timestamp,
					'str_date'=>$str_date
				);
			}
			
			foreach($list->device_sensors as $key1=>$value1){
				$sensor_uuid=$list->device_sensors[$key1]->user_sensor_uuid;
				$sensor[]=array(
					'sensor_uuid'=>$sensor_uuid,
					'sensor_values'=>$data_value
				);
			}
			
			$listsensor=array(
				"data"=>array(
					"page"=>1,
					"next_page"=>'-',
					"device_uuid"=>$device_uuid,
					"results"=>$sensor
					
				)
			);

			$this->response($listsensor, REST_Controller::HTTP_OK);
		}
	}
}
