<div id="page-wrapper" class="gray-bg dashbard-1">
    <div class="content-main">
		<!--banner-->	
	    <div class="banner">
			<h2>
			<a href="<?php echo site_url('admins'); ?>">Home</a>
			<i class="fa fa-angle-right"></i>
			<span>Cuaca</span>
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
			<div class="inbox-right">	
				<div class="mailbox-content">
					<div class="mail-toolbar clearfix">
						<div class="float-left">
						   
						</div>
						<div id="statusRequest" class="float-right">
							<a href="<?php echo site_url('cuaca/sync'); ?>" class="btn btn-default dropdown-toggle"><i class="fa fa-refresh"></i> SINKRONISASI DATA SERVER </a>
						</div>
					</div>
				   
					<ul class="nav nav-tabs">
					<?php 
					$i=0;
					foreach($listdevice as $key=>$value){
					?>
					  <li <?php if($i==0) echo 'class="active"'; ?>><a data-toggle="tab" href="#<?php echo $key; ?>"><?php echo $key; ?></a></li>
					<?php $i++; } ?>
					</ul>

					<div class="tab-content">
					<?php 
					$i=0;
					foreach($listdevice as $key=>$value){
					?>
					  <div id="<?php echo $key; ?>" class="tab-pane fade in <?php if($i==0) echo "active"; ?>">
						<table class="table table-hover" id="listDevice">
							<thead>
								<tr>
									<th>#</th>
									<th>Nama Sensor</th>
									<th>Lokasi</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							$i=1;
							foreach($value->result() as $dt){ 
								echo '<tr>
										<td>'.$i.'</td>
										<td>'.$dt->user_sensor_name.'</td>
										<td>'.$dt->location_text.'<br/>Lat : '.$dt->position_lat.' | Lng : '.$dt->position_lng.'</td>
									</tr>';
								$i++;
							} ?>
							</tbody>
						</table>
					  </div>
					<?php $i++; } ?>
					</div>
					
					<div id="navigasi"></div>
				</div>
			</div>
		</div>
		<div class="clearfix"> </div>
	</div>
</div>
 	<!--//grid-->