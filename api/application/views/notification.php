<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta tags -->
	<title>Notification Tool</title>
	<meta name="keywords" content="" />
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- stylesheets -->
	<link rel="stylesheet" href="<?php echo base_url('assets/login/'); ?>css/font-awesome.css">
	<link rel="stylesheet" href="<?php echo base_url('assets/login/'); ?>css/style.css">
	<?php /*
	<script src="<?php echo base_url('assets/js/jquery-2.1.4.min.js'); ?>" ></script>
	*/ ?>
	
	<script src="https://kampusgo.xyz/travio/user/js/jquery.3.3.1.min.js"></script>
	<!-- google fonts  -->
	<link href="//fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Raleway:400,500,600,700" rel="stylesheet">
	
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 300px;
		width:33.3%;
		float:left;
      }
	 </style>
</head>
<body>
	<div class="agile-login">
		<div class="wrapper" style="float:left;width:33%">
			<h2>Notification Tool</h2>
			<div class="w3ls-form">
					<label>Status</label>
					<select name="status" id="status">
						<option value="1">Di atas / bawah batas wajar</option>
						<option value="0">Sudah aman</option>
					</select>
					<label>Sensor</label>
					<select name="master_sensor_name" id="master_sensor_name">
						<option value="Temperature">Temperature</option>
						<option value="Humidity">Humidity</option>
						<option value="Wind">Wind</option>
						<option value="Rain">Rain</option>
					</select>
					
					<label>Latest Value</label>
					<input type="text" name="latest_value" id="latest_value" value="100" placeholder="Latest value" required />
					
					<label>Latitude</label>
					<input type="text" name="lat" id="lat" placeholder="Latitude" value="-7.0511280" required />
					<label>Longitude</label>
					<input type="text" name="lng" id="lng" placeholder="Longitude" value="110.4409010" required />
					
					<div style="display:none">
						<label>User</label>
						<input type="text" name="nuser" id="nuser" placeholder="" value="0" required />
						<div id="user_token"></div>
					</div>
					<label>Unit Symbol</label>
					<select name="unit_symbol" id="unit_symbol">
						<option value="°C">Celcius</option>
						<option value="mm">mm</option>
					</select>
					<input type="submit" name="submit" id="submit" value="Send Notification" />
			</div>
			
			<div class="agile-icons">
				<a href="#"><span class="fa fa-twitter" aria-hidden="true"></span></a>
				<a href="#"><span class="fa fa-facebook"></span></a>
				<a href="#"><span class="fa fa-pinterest-p"></span></a>
			</div>
		</div>
		<div id="map"></div>
		<div class="wrapper" style="float:right;width:33%">
			<h2>List User</h2>
			<div class="w3ls-form" id="listuser">
			</div>
		</div>
		<br/>
	<div class="copyright">
		<p>© 2018 WeMo. All rights reserved.</a></p> 
	</div>
	</div>

	<script>
$(document).ready(function(){
	var lat= $("#lat").val();
	var lng= $("#lng").val();
	getListUser(lat, lng);
	initMap(lat,lng);
	
	$('#lat').change(function(){
		var lat= $("#lat").val();
		var lng= $("#lng").val();
		getListUser(lat, lng);
		initMap(lat,lng);
	});
	
	$('#lng').change(function(){
		var lat= $("#lat").val();
		var lng= $("#lng").val();
		getListUser(lat, lng);
		initMap(lat,lng);
	});
	
	$('#submit').click(function(){
		console.log('form disubmit');
		var nuser= $("#nuser").val();
		var status= $("#status").val();
		var master_sensor_name= $("#master_sensor_name").val();
		var latest_value= $("#latest_value").val();
		var lat= $("#lat").val();
		var lng= $("#lng").val();
		var unit_symbol= $("#unit_symbol").val();
		
		for(var i=0; i<nuser; i++){
			// console.log('masuk perulangan ke'+i);
			var token=$("#user_token_"+i).val();
			if(token!=null && token!='null'){
				// console.log('i '+i+' otw');
				sendNotif(i, token, status, master_sensor_name, latest_value, unit_symbol);
			}else{
				// console.log('i '+i+' kosong');
			}
		}
	});
});

function getListUser(lat=null, lng=null){
	$.ajax({
		url:"<?php echo base_url(); ?>v1/notif/listuser?lat="+lat+"&lng="+lng,//folder/fungsinya
		type:"GET",
		// data: {},
		crossDomain: true,
		dataType:"json",
		
		beforeSend: function(){
			$("#listuser").html('<div align="center"><img src="../assets/img/Ellipsis.gif" /></div>');
		},
		success: function(result){
			if (result.status==true) {
				var pilihan='';
				var user_token='';
				var user_lat='';
				var user_lng='';
				for(var i=0; i<result.result.length; i++){
					var notif_token=result.result[i]['notif_token'];
					var full_name=result.result[i]['full_name'];
					var distance=result.result[i]['distance'];
					var notif_token=result.result[i]['notif_token'];
					var lat=result.result[i]['lat'];
					var lng=result.result[i]['lng'];
					distance_miles=(distance*1).toFixed(2);
					distance_km=(distance*1.609344).toFixed(2);
					
					pilihan+='<div id="user_ke_'+i+'"><label>'+(i+1)+'. '+full_name+' ( '+distance_km+' Km / '+distance_miles+' mi)<br/><small>> Koordinat : '+lat+','+lng+'</small> <div id="user_status_'+i+'"></div></label></div>';
					user_token+='<input type="text" id="user_token_'+i+'" value="'+notif_token+'" />';
					user_lat+='<input type="text" id="user_lat_'+i+'" value="'+lat+'" />';
					user_lng+='<input type="text" id="user_lng_'+i+'" value="'+lng+'" />';
				}

				$("#listuser").html(pilihan);
				$("#nuser").val(i);
				$("#user_token").html(user_token+''+user_lat+''+user_lng);
			}else if(result.status==false){
				$("#listuser").html("terjadi kesalahan");
			}
			
			var lat0= $("#lat").val();
			var lng0= $("#lng").val();
			initMap(lat0,lng0);
		},
		error: function(){
			$("#listuser").html("Error");
		}
	});
}
function sendNotif(i, token, status, master_sensor_name, latest_value, unit_symbol){
	$.ajax({
		url:"<?php echo base_url(); ?>/v1/notif/pushme?token="+token+"&status="+status+"&master_sensor_name="+master_sensor_name+"&latest_value="+latest_value+"&unit_symbol="+unit_symbol,//folder/fungsinya
		type:"GET",
		// data: {},
		dataType:"json",
		
		beforeSend: function(){
			$("#user_status_"+i).html(' <span class="label label-default">sedang memproses</span>');
		},
		success: function(result){
			$("#user_status_"+i).html(' <span class="label label-success">berhasil</span>');
		},
		error: function(){
			$("#user_status_"+i).html(' <span class="label label-danger">terjadi kesalahan</span>');
			// console.log("<?php echo base_url(); ?>/v1/notif/pushme?token="+token+"&status="+status+"&master_sensor_name="+master_sensor_name+"&latest_value="+latest_value+"&unit_symbol="+unit_symbol);
		}
	});
}

var map;
function initMap(lat, lng) {
	map = new google.maps.Map(document.getElementById('map'), {
	  zoom: 16,
	  center: new google.maps.LatLng(lat, lng),
	  mapTypeId: 'roadmap'
	});

	var iconBase = 'https://wemo.kampusgo.xyz/assets/images/';
	var icons = {
	  sensor: {
		icon: iconBase + 'motion-sensor.png'
	  },
	  user: {
		icon: iconBase + 'user.png'
	  },
	  smartphone: {
		icon: iconBase + 'smartphone.png'
	  }
	};
	
	var features = [
	  {
		position: new google.maps.LatLng(lat,lng),
		type: 'sensor'
	  }
	];
	
	var nuser= document.getElementById("nuser").value;
	console.log(nuser);
	for(var i=0; i<nuser; i++){
		console.log(i);
		var lat=document.getElementById("user_lat_"+i).value;
		var lng=document.getElementById("user_lng_"+i).value;
		var temp={
			position: new google.maps.LatLng(lat,lng),
			type: 'smartphone',
			useri:i
		  };
		features.push(temp);
	}

	var bounds = new google.maps.LatLngBounds();
	// Create markers.
	features.forEach(function(feature) {
	  var marker = new google.maps.Marker({
		position: feature.position,
		icon: icons[feature.type].icon,
		map: map
	  });
	  bounds.extend(marker.getPosition());
	});
	
	map.fitBounds(bounds);
}
</script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGsSjXDPjnkY3oIt8NTo2RuBXLwZ8b7Uo&callback=initMap">
</script>
</body>
</html>
