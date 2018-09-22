
<div id="page-wrapper" class="gray-bg dashbard-1">
    <div class="content-main">
		<!--banner-->	
	    <div class="banner">
			<h2>
			<a href="<?php echo site_url('admins'); ?>">Home</a>
			<i class="fa fa-angle-right"></i>
			<a href="<?php echo site_url('cuaca'); ?>">Cuaca</a>
			<i class="fa fa-angle-right"></i>
			<span>Sinkronisasi Server</span>
			</h2>
		</div>
	</div>
		<!--//banner-->
 	<!--grid-->
 	<div class="inbox-mail">
		<?php
		if($this->input->get('respon')=='success'){
			echo '<div class="alert alert-success">'.$this->input->get('message').'</div>';
		}elseif($this->input->get('respon')=='failed'){
			echo '<div class="alert alert-danger">'.$this->input->get('message').'</div>';
		}
		?>
	<!-- tab content -->
		<div class="col-md-12 tab-content tab-content-in">
			<div class="tab-pane <?php if($this->input->get('do')==null) echo 'active'; ?> text-style" id="tab1">
			  <div class="inbox-right">	
				<div class="mailbox-content">
				   <div class="mail-toolbar clearfix">
					 <div class="float-left">
					   <div class="btn-group m-r-sm mail-hidden-options" style="display: inline-block;">
							<div class="btn-group">
								<a href="<?php echo site_url('cuaca'); ?>" class="btn btn-default dropdown-toggle"><i class="fa fa-arrow-back"></i> KEMBALI</a>
							</div>
							
						</div>
					</div>
					<div id="statusRequest" class="float-right">
						
					</div>
				   </div>
					<table class="table table-hover" id="listDevice">
						<thead>
							<tr>
								<th>#</th>
								<th>Device</th>
								<th>Sensor</th>
							</tr>
						</thead>
						<tbody>
						
						</tbody>
					</table>
					<div id="navigasi"></div>
				</div>
				</div>
			</div>
		</div>
		<div class="clearfix"> </div>
	</div>
</div>
 	<!--//grid-->

<div class="modal fade" id="setTipeSensor" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Pilih Jenis Sensor</h4>
        </div>
        <div class="modal-body">
			<form id="formTipeSensor">
				<div class="form-group">
					<label>UUID Sensor</label>
					<input type="text" class="form-control" name="sensor_uuid" id="sensor_uuid" value=""/>
				</div>
				<div class="form-group">
					<label>Jenis Sensor</label>
					<select name="jenis_sensor" id="jenis_sensor" class="form-control">
						<option value="">- Pilih Jenis Sensor -</option>
						<option value="ti">Suhu Internal</option>
						<option value="te">Suhu Eksternal</option>
						<option value="hd">Kelembapan</option>
					</select>
				</div>
				<div id="modalRespon"></div>
				<div class="form-group">
					<button id="simpanTipeSensor" class="btn btn-primary">SIMPAN</button>
				</div>
				
			</form>
        </div>
        <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
	
<script>
	// this is the id of the form
	$("#simpanTipeSensor").click(function(e) {
		var url = "<?php echo site_url('cuaca/updateJenis'); ?>"; // the script where you handle the form input.
		var uuid=$("#sensor_uuid").val();
		var jenis=$("#jenis_sensor").val();
		
		if(jenis==''){
			$("#modalRespon").html("<div class='alert alert-danger'>Silakan pilih jenis sensor terlebih dahulu</div>");
		}else{
			$.ajax({
				type: "POST",
				url: url,
				data: $("#formTipeSensor").serialize(), // serializes the form's elements.
				beforeSend: function(){
				    $('#setTipeSensor').modal('toggle');
					$("#tipesensor_"+uuid).html('tunggu sebentar...');
				},
				success: function(data)
				{				   
				   $("#tipesensor_"+uuid).html(data);
				}
			});
		}
			e.preventDefault(); 
	});

	$(document).on("click", ".open-setTipeSensor", function () {
		 var sensor_uuid = $(this).data('id');
		 $(".modal-body #sensor_uuid").val( sensor_uuid );
		 $(".modal-body #jenis_sensor").val( '' );
	});
	
	function getJenis(uuid){
		$.ajax({
			url:"<?php echo site_url('cuaca/getJenis'); ?>",
			type:"POST",
			data: { "user_sensor_uuid":uuid },
			dataType:"html",
			
			beforeSend: function(){
				$("#tipesensor_"+uuid).html('loading...');
			},
			success: function(data){
				$("#tipesensor_"+uuid).html(data);
			},
			error: function() {
				return false;
			}
		});
	}
	function addSensor(dataJSON){
		$.ajax({
			url:"<?php echo site_url('cuaca/addSensorJs'); ?>",
			type:"POST",
			data: dataJSON,
			dataType:"html",
			
			beforeSend: function(){
				$("#statusRequest").html('Mensinkronkan...');
			},
			success: function(data){
				$("#statusRequest").html(data);
			},
			error: function() {
				return false;
			}
		});
	}
	function getListDevice(token, page, sync=false){
		if(page=='') page=1;
		if(token==''){
			var token='';
			$.ajax({
				url:"https://sidik.rumahiot.panjatdigital.com/authenticate/email",
				// url:"https://gudang.rumahiot.panjatdigital.com/retrieve/device/list?q=Semarang&l=50&o=des",
				type:"POST",
				data: { 'email' : 'fauzanilzaki@gmail.com', 'password' : 'zakizaki' },
				dataType:"html",
				async: false,
				
				success: function(data){
					var result=JSON.parse(data);
					token=result.data.token;
					getListDevice(token, page, sync);
				},
				error: function() {
					return false;
				}
			});
		}else{
			$.ajax({
				url:"https://gudang.rumahiot.panjatdigital.com/retrieve/device/list?&l=50&o=des",
				// url:"https://gudang.rumahiot.panjatdigital.com/retrieve/device/list?q=Semarang&l=50&o=des",
				type:"GET",
				headers: { 'Authorization' : 'Bearer '+token },
				dataType:"html",
				async: false,
				
				beforeSend: function(){
					$("#statusRequest").html('<div align="center" style="text-color:#f2f2f2"><img style="height:50px;width:50px;" src="https://bikubiku.id/assets/img/squares.gif" /></div>');
				},
				success: function(dataa){
					var result=JSON.parse(dataa);
					
					var page=result.data.page;
					var next_page=result.data.next_page;
					var results=result.data.results;
					// console.log(results);
					var table = document.getElementById("listDevice");
					for(var i = table.rows.length - 1; i > 0; i--)
					{
						table.deleteRow(i);
					}
					var i=1;
					results.forEach(function(device) {
						// console.log(device);
						var table = document.getElementById("listDevice");

						var row = table.insertRow(i);
						var cell0 = row.insertCell(0);
						var cell1 = row.insertCell(1);
						var cell2 = row.insertCell(2);
						var cell3 = row.insertCell(3);
						
						cell0.innerHTML = i;
						cell1.innerHTML = device.device_name+"<br/>ID : "+device.device_uuid;
						
						sensor_text='';
						listsensor=device.device_sensors;
						listsensor.forEach(function(sensor) {
							sensor_text+= sensor.user_sensor_name+" ( "+sensor.master_sensor_name+" ) <br/>ID : "+sensor.user_sensor_uuid+"<br/>Last value : "+sensor.latest_value+" "+sensor.unit_symbol+"<br/>";
							sensor_text+="<div id='tipesensor_"+sensor.user_sensor_uuid+"'></div>"
							sensor_text+="<a data-toggle='modal' data-id='"+sensor.user_sensor_uuid+"' title='Set Tipe Sensor' class='open-setTipeSensor btn btn-warning' href='#setTipeSensor'>PILIH TIPE SENSOR</a><hr/>";
							
							getJenis(sensor.user_sensor_uuid);
						});
						cell2.innerHTML = sensor_text;
						
						i++;
					});
					
					
					if(page=='1'){
						var prev_text='';
					}else{
						var prev=page;
						prev--;
						var prev_text='<li><a onclick="return getListDevice(\'\','+prev+',false);">Previous</a></li>';
					}
					
					if(next_page=='-'){
						var next_text='';
					}else{
						var next=page;
						next++;
						var next_text='<li><a onclick="return getListDevice(\'\','+next+',false);">Next</a></li>';
					}
					
					$("#navigasi").html('<nav aria-label="..."><ul class="pager">'+prev_text+'<li><a disabled > HALAMAN '+page+'</a></li>'+next_text+'</ul></nav>');
					
					if(sync==true){
						addSensor(result.data);
					}
					
					$("#statusRequest").html('<a class="btn btn-primary" onclick="return getListDevice(\'\','+page+',true);"><i class="fa fa-sync"></i> SINKRONISASI DATABASE</a>');
					// $("#hasilLoading").html('');
				},
				error: function(jqXHR, textStatus, errorThrown) {
					if(jqXHR.status=='400'){
						var token='';
						$.ajax({
							url:"https://sidik.rumahiot.panjatdigital.com/authenticate/email",
							// url:"https://gudang.rumahiot.panjatdigital.com/retrieve/device/list?q=Semarang&l=50&o=des",
							type:"POST",
							data: { 'email' : 'fauzanilzaki@gmail.com', 'password' : 'zakizaki' },
							dataType:"html",
							async: false,
							
							success: function(data){
								var result=JSON.parse(data);
								token=result.data.token;
								getListDevice(token, page, sync);
							},
							error: function() {
								return false;
							}
						});
					}
				}
			});
		}
	}
	$(document).ready(function(){
		jQuery.fn.createAuthorization = function() {
			var token;
			$.ajax({
				url:"https://sidik.rumahiot.panjatdigital.com/authenticate/email",
				// url:"https://gudang.rumahiot.panjatdigital.com/retrieve/device/list?q=Semarang&l=50&o=des",
				type:"POST",
				data: { 'email' : 'fauzanilzaki@gmail.com', 'password' : 'zakizaki' },
				dataType:"html",
				async: false,
				
				success: function(data){
					// return data.data.token;
					var result=JSON.parse(data);
					token=result.data.token;
					// console.log('CREATE AUTH : '+token);
					return token;
				},
				error: function() {
					return false;
				}
			});
		};
		
		function insertRow(){
			var table = document.getElementById("listDevice");
			var row = table.insertRow(0);
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(1);
			cell1.innerHTML = "NEW CELL1";
			cell2.innerHTML = "NEW CELL2";
		}
		
		getListDevice('',1, false);
	});
</script>