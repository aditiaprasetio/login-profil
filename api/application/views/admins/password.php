
<div id="page-wrapper" class="gray-bg dashbard-1">
    <div class="content-main">
		<!--banner-->	
	    <div class="banner">
			<h2>
			<a href="<?php echo site_url('admins'); ?>">Home</a>
			<i class="fa fa-angle-right"></i>
			<span>Change Password</span>
			</h2>
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
		<div class="tab-pane <?php if($this->input->get('do')=='add') echo 'active'; ?> text-style" id="tab2">
			<div class="inbox-right">
				<div class="mailbox-content">
					<?php
					$url_proses=site_url('auth/change_password_proses');
					?>
					<form action="<?php echo $url_proses; ?>" method="POST" enctype="multipart/form-data">
						<div class="col-md-12 form-group1 group-mail">
						  <label class="control-label">Old Password</label>
						  <input name="password_lama" type="password" placeholder="" required="">
						</div>
						 <div class="clearfix"> </div>
						<div class="col-md-12 form-group1 group-mail">
						  <label class="control-label">New Password</label>
						  <input name="password_baru" type="password" placeholder="" required="">
						</div>
						 <div class="clearfix"> </div>
						<div class="col-md-12 form-group1 group-mail">
						  <label class="control-label">Retype New Password</label>
						  <input name="re_password_baru" type="password" placeholder="" required="">
						</div>
						 <div class="clearfix"> </div>
						<div class="col-md-12 form-group">
						  <input type="submit" name="submit" class="btn btn-primary" value="Save" />
						</div>
						<div class="clearfix"> </div>
					</form>
				</div>
			</div>
		</div>
		<div class="clearfix"> </div>
		   </div>
		</div>

 	<!--//grid-->