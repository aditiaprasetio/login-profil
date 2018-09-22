<!DOCTYPE HTML>
<html>
<head>
<title>Panel Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="<?php echo base_url('assets/admins/'); ?>css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<link href="<?php echo base_url('assets/admins/'); ?>css/style.css" rel='stylesheet' type='text/css' />
<link href="<?php echo base_url('assets/admins/'); ?>css/font-awesome.css" rel="stylesheet"> 
<script src="<?php echo base_url('assets/admins/'); ?>js/jquery.min.js"> </script>
<!-- Mainly scripts -->
<script src="<?php echo base_url('assets/admins/'); ?>js/jquery.metisMenu.js"></script>
<script src="<?php echo base_url('assets/admins/'); ?>js/jquery.slimscroll.min.js"></script>
<script src="<?php echo site_url('ckeditor/ckeditor.js'); ?>"></script>
<!-- Custom and plugin javascript -->
<link href="<?php echo base_url('assets/admins/'); ?>css/custom.css" rel="stylesheet">
<script src="<?php echo base_url('assets/admins/'); ?>js/custom.js"></script>
<script src="<?php echo base_url('assets/admins/'); ?>js/screenfull.js"></script>
		<script>
		$(function () {
			$('#supported').text('Supported/allowed: ' + !!screenfull.enabled);

			if (!screenfull.enabled) {
				return false;
			}

			

			$('#toggle').click(function () {
				screenfull.toggle($('#container')[0]);
			});
			

			
		});
		</script>

<!----->
<!--skycons-icons-->
<script src="<?php echo base_url('assets/admins/'); ?>js/skycons.js"></script>
<!--//skycons-icons-->
</head>
<body>
<div id="wrapper">

<!----->
        <nav class="navbar-default navbar-static-top" role="navigation">
             <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <h1> <a class="navbar-brand" href="<?php echo site_url('admins'); ?>">WEMO</a></h1>         
			   </div>
			 <div class=" border-bottom">
        	<div class="full-left">
        	  <section class="full-top">
				<button id="toggle"><i class="fa fa-arrows-alt"></i></button>	
			</section>
            <div class="clearfix"> </div>
           </div>
     
            <!-- Brand and toggle get grouped for better mobile display -->
		 
		   <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="drop-men" >
		        <ul class=" nav_1">
					<li class="dropdown">
		              <a href="#" class="dropdown-toggle dropdown-at" data-toggle="dropdown"><span class=" name-caret"><?php echo $this->session->userdata('nama'); ?><i class="caret"></i></span><img src="<?php echo base_url('assets/admins/'); ?>images/wo.jpg"></a>
		              <ul class="dropdown-menu " role="menu">
		                <li><a href="<?php echo site_url('auth/password'); ?>"><i class="fa fa-user"></i>Edit Password</a></li>
		                <li><a href="<?php echo site_url('auth/logout'); ?>"><i class="fa fa-sign-out"></i>Logout</a></li>
		              </ul>
		            </li>
		           
		        </ul>
		     </div><!-- /.navbar-collapse -->
			<div class="clearfix"></div>
		