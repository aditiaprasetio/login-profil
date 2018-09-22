<!DOCTYPE html>
<html lang="en">
<head>
<title>WeMo Update</title>    
<link href="<?php echo base_url('assets/css/'); ?>font-awesome.min.css" rel="stylesheet" type="text/css" media="all" /><!-- fontawesome -->     
<link href="<?php echo base_url('assets/css/'); ?>bootstrap.min.css" rel="stylesheet" type="text/css" media="all" /><!-- Bootstrap stylesheet -->
<link href="<?php echo base_url('assets/css/'); ?>style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="<?php echo base_url('assets/css/'); ?>flexslider.css" type="text/css" media="screen" property="" />
<!-- stylesheet -->
<!-- meta tags -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Blog Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //meta tags -->
<!--fonts-->
<link href="//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<!--//fonts-->
<script type="text/javascript" src="<?php echo base_url('assets/js/'); ?>jquery-2.1.4.min.js"></script>
<script src="<?php echo base_url('assets/js/'); ?>main.js"></script>
<!-- Required-js -->
<!-- main slider-banner -->
<script src="<?php echo base_url('assets/js/'); ?>skdslider.min.js"></script>
<link href="<?php echo base_url('assets/css/'); ?>skdslider.css" rel="stylesheet">
<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#demo1').skdslider({'delay':5000, 'animationSpeed': 2000,'showNextPrev':true,'showPlayButton':true,'autoSlide':true,'animationType':'fading'});
						
			jQuery('#responsive').change(function(){
			  $('#responsive_wrapper').width(jQuery(this).val());
			});
			
		});
</script>	
<!-- //main slider-banner --> 
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="<?php echo base_url('assets/js/'); ?>move-top.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/'); ?>easing.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>
<!-- start-smoth-scrolling -->

<!-- scriptfor smooth drop down-nav -->
<script>
$(document).ready(function(){
    $(".dropdown").hover(            
        function() {
            $('.dropdown-menu', this).stop( true, true ).slideDown("fast");
            $(this).toggleClass('open');        
        },
        function() {
            $('.dropdown-menu', this).stop( true, true ).slideUp("fast");
            $(this).toggleClass('open');       
        }
    );
});
</script>
<!-- //script for smooth drop down-nav -->
</head>
<body>
<!-- header -->
	<header>
		<div class="w3layouts-top-strip">
			<div class="container">
				<div class="logo">
					<h1><a href="<?php echo site_url(); ?>">WeMo Update</a></h1>
					<p>Be Aware to Weather Changes</p>
				</div>
				<center>
					<a href="<?php echo site_url('search?keyword=Download'); ?>" class="btn btn-primary btn-xs"><i class="fa fa-download"></i> DOWNLOAD APLIKASI ANDROID</a>
				</center>
				<div class="w3ls-social-icons">
					<a class="facebook" href="https://facebook.com/<?php echo $web['sosmed_fb']; ?>"><i class="fa fa-facebook"></i></a>
					<a class="twitter" href="#"><i class="fa fa-twitter"></i></a>
					<a class="pinterest" href="#"><i class="fa fa-pinterest-p"></i></a>
					<a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a>
					<a class="linkedin" href="#"><i class="fa fa-google-plus"></i></a>
					<a class="linkedin" href="#"><i class="fa fa-rss"></i></a>
					<a class="linkedin" href="#"><i class="fa fa-behance"></i></a>
				</div>
			</div>
		</div>
				<?php /*
		<!-- navigation -->
			<nav class="navbar navbar-default">
			  <div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				  <ul class="nav navbar-nav">
					<li><a class="active" href="<?php echo site_url(); ?>">Home</a></li>
					<li><a href="#">About</a></li>
					<!--
					<li><a href="lifestyle.php">Life Style</a></li>
					
					<li><a href="#">Fashion</a></li>
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Short Codes <span class="caret"></span></a>
					  <ul class="dropdown-menu">
					  <li><a href="icons.php">Icons Page</a></li>
						<li><a href="typo.php">Typography</a></li>
						
					  </ul>
					</li>
					<li><a href="photography.php">Photography</a></li>
					<li><a href="features.php">Features</a></li>
					<li><a href="contact.php">Contact</a></li>
					-->
				  </ul>
				</div><!-- /.navbar-collapse -->
				<div class="w3_agile_login">
					<div class="cd-main-header">
						<a class="cd-search-trigger" href="#cd-search"> <span></span></a>
						<!-- cd-header-buttons -->
					</div>
					<div id="cd-search" class="cd-search">
						<form action="#" method="post">
							<input name="Search" type="search" placeholder="Search...">
						</form>
					</div>
				</div>
				<div class="clearfix"> </div>
				
			  </div><!-- /.container-fluid -->
			</nav>
			
		<!-- //navigation -->
				 */ ?>
	</header>
	<!-- //header -->
	<?php if(isset($menu) && $menu=='Homepage'){ ?>
	<!-- top-header and slider -->
	<div class="w3-slider">	
	<!-- main-slider -->
		<ul id="demo1">
			<li>
				<img src="<?php echo base_url('assets/images/'); ?>1.jpg" alt="" />
				<!--Slider Description example-->
				<div class="slide-desc">
					<h3>SHARE YOUR AWARE</h3>
					<p>Tingkatkan awareness masyarakat Indonesia dengan saling berbagi informasi cuaca yang terjadi di sekitarmu. </p>
				</div>
			</li>
			<li>
				<img src="<?php echo base_url('assets/images/'); ?>2.jpg" alt="" />
				  <div class="slide-desc">
					<h3>Hujan Menyebabkan Banjir</h3>
					<p>Beritahu orang lain bahwa daerah anda sedang dilanda hujan dan berpotensi banjir. Peringatkan orang lain untuk berhati-hati.</p>
				</div>
			</li>
			<li>
				<img src="<?php echo base_url('assets/images/'); ?>3.jpg" alt="" />
				<div class="slide-desc">
					<h3>Rawan Berkabut</h3>
					<p>Kabut bisa mengurangi jarak pandang orang. Sangat berbahaya jika sedang berkendara. Peringatkan mereka!</p>
				</div>
			</li>
			
		</ul>
	</div>
	<!-- //main-slider -->
	<!-- //top-header and slider -->
	<?php } ?>
	<?php if(isset($menu) && $menu=='Post'){ ?>
	<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="<?php echo site_url(); ?>">Home</a></li>
				<li class="active">Artikel : <?php echo $artikel['judul']; ?></li>
			</ol>
		</div>
	</div>
	<!-- //breadcrumbs -->
	<?php } ?>
	<?php if(isset($menu) && $menu=='Search'){ ?>
	<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="<?php echo site_url(); ?>">Home</a></li>
				<li class="active">Search : <?php echo $this->input->get('keyword'); ?></li>
			</ol>
		</div>
	</div>
	<!-- //breadcrumbs -->
	<?php } ?>
	<div class="container">
		<div class="banner-btm-agile">