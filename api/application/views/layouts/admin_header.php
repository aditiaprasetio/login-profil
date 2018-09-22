<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Barokah Catering</title>
		<link rel="shortcut icon" href="<?php echo base_url('assets/img/icon.png'); ?>">
		<link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/css/admin-style.css" rel="stylesheet'); ?>">

		<!-- external javascript -->
		<script src="<?php echo base_url('assets/js/jquery-1.11.3.min.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>

		<!-- datepicker -->
		<link rel="stylesheet" href="<?php echo base_url('assets/js/jquery-ui-1.11.4/jquery-ui.css'); ?>">
		<script src="<?php echo base_url('assets/datepicker/jquery-1.10.2.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/jquery-ui-1.11.4/jquery-ui.js'); ?>"></script>		
	
		<!-- extra javascript -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatables/media/css/jquery.dataTables.min.css'); ?>">
		<script type="text/javascript" src="<?php echo base_url('assets/datatables/media/js/jquery.dataTables.min.js'); ?>"></script>
		<script type="text/javascript">
		$(document).ready(function(){
		    $('.mytable').DataTable();
		});
		</script>
		<script type="text/javascript">
		$(document).ready(function(){
			$("#tanggal_agenda").datepicker({ dateFormat:'dd-mm-yy' });
		})
		</script>
	</head>
	<body>
		<div class="wrapper-t">
			<div class="left-nav-t">
				<ul class="sidebar-t" align="left">
					<li <?php if(isset($tab1)) echo 'class="active"'; ?>><a href="<?php echo site_url('sudo/admin/beranda'); ?>">Beranda</a></li>							
					<li <?php if(isset($tab2)) echo 'class="active"'; ?>><a href="<?php echo site_url('sudo/berita'); ?>">Berita</a></li>							
					<li <?php if(isset($tab3)) echo 'class="active"'; ?>><a href="<?php echo site_url('sudo/slider'); ?>">Slider</a></li>							
					<li <?php if(isset($tab4)) echo 'class="active"'; ?>><a href="<?php echo site_url('sudo/pekerjaan'); ?>">Agenda</a></li>										
					<li <?php if(isset($tab5)) echo 'class="active"'; ?>><a href="<?php echo site_url('sudo/foto'); ?>">Foto</a></li>										
					<li <?php if(isset($tab6)) echo 'class="active"'; ?>><a href="<?php echo site_url('sudo/profil'); ?>">Profil</a></li>	
				</ul>
			</div>
			<div class="right-content-t">
				<nav class="navbar navbar-default nav-t navbar-fixed-top">
					<div class="container">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</button>
							<a href="#" class="navbar-brand" style="margin-top:-3px;">Barokah Catering</a>
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">
							<ul class="nav navbar-nav navbar-right">
								<li class="dropdown <?php if(isset($tab7)) echo 'active'; ?>">
						        	<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $this->session->userdata('namauseradmin'); ?>
						        	<span class="caret"></span></a>
						        	<ul class="dropdown-menu">
						          		<li><a href="<?php echo site_url('sudo/admin/ganti_password'); ?>">Ganti Password</a></li>
						          		<li><a href="<?php echo site_url('sudo/admin/logout'); ?>">Logout</a></li>
						        	</ul>
						      	</li>																		
						    </ul>
						</div>
					</div>
				</nav>
