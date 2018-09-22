	<div id="page-wrapper" class="gray-bg dashbard-1">
       <div class="content-main">
	    <!--banner-->	
	    <div class="banner">
			<h2>
			<a href="<?php echo site_url('admins'); ?>">Home</a>
			<i class="fa fa-angle-right"></i>
			<span>Dashboard</span>
			</h2>
		</div>
		<!--//banner-->
		<!----->
		
		<div class="content-bottom">
			<?php
			if($this->input->get('respon')=='success'){
				echo '<div class="alert alert-success">'.$this->input->get('message').'</div>';
			}elseif($this->input->get('respon')=='failed'){
				echo '<div class="alert alert-danger">'.$this->input->get('message').'</div>';
			}
			?>
			<div class="col-md-6 post-top">
				<div class="post-bottom">
					<div class="post-bottom-1">
						<a class="square" href="<?php echo site_url('artikel'); ?>"><i class="fa fa-book"></i></a>
						<p><?php echo $jumlahartikel; ?> <label>Articles</label></p>
					</div>
					<div class="post-bottom-2">
						<a class="square" href="<?php echo site_url('artikel/tags'); ?>"><i class="fa fa-tag"></i></a>
						<p><?php echo $jumlahkategori; ?> <label>Tags</label></p>
					</div>
					<div class="clearfix"> </div>
				</div>
			</div>
			<div class="clearfix"> </div>
		</div>
		<!--//content-->
     