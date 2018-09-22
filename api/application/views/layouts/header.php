<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="google-site-verification" content="pbMVVKrKDxyBRFmlV1oxVqyEldW93ggdTGKdLiH5Wto" />
		<?php
		if(isset($title) && isset($deskripsi)){
			echo "<title>".$title." | BikuBiku </title>";
		}
		else echo "<title>BikuBiku | Connecting, Leading, Educating</title>";
		?>
		<meta content="<?php
		if(isset($deskripsi)){
			echo $deskripsi;
		}
		else echo "Marketplace Online Edukasi dengan Pendekatan Psikologi Pertama di Indonesia";
		?>"  name="description" />
		<meta content="<?php
		if(isset($keyword)){
			echo $keyword.", ";
		}
		echo "BikuBiku, BikuBikuID, BikuBiku Indonesia, Marketplace Online Edukasi Pertama, Pendekatan Psikologi";
		?>"  name="keyword"/>
		
		<?php
		if(isset($cpage)){
			if($cpage=='lihatkonten'){
				$cpage_url=site_url('konten/'.$query['slug']);
				echo '<script>history.pushState({}, null, "'.$cpage_url.'");</script>';
				$img_thumb=site_url('assets/img/kontenpreview/'.$query['preview_konten']);
			}elseif($cpage=='lihatruang'){
				if($query['username']!='' && $query['username']!=null) {
					$cpage_url=site_url('r/'.$query['username']);
				}
				else{
					$cpage_url=site_url('ruangbelajar/lihat/'.$query['id']);
				}
				echo '<script>history.pushState({}, null, "'.$cpage_url.'");</script>';
				$img_thumb=site_url('assets/img/ruangbelajar/'.$query['foto_logo']);
			}else{
				$img_thumb=site_url('assets/img/logobiku2.png');
			}
			echo '<link rel="canonical" href="'.$cpage_url.'">';
				echo '<meta content="'.$img_thumb.'" property="og:image"/>';
		}
		?>
		
		<link rel="shortcut icon" href="<?php echo site_url('assets/img/favicon.ico'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css'); ?>">		

		<!-- external javascript -->
		<script src="<?php echo base_url('assets/js/jquery-1.11.3.min.js'); ?>" type="text/javascript"></script>
		<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
		
		<!-- notifikasi -->
		<script>
		setInterval(function(){
		$("#load_row").load('<?php echo base_url('notifikasi/load_row'); ?>')
		}, 10000); //menggunakan setinterval jumlah notifikasi akan selalu update setiap 2 detik diambil dari controller notifikasi fungsi load_row
		 
		setInterval(function(){
		$("#load_data").load('<?php echo base_url('notifikasi/load_data'); ?>')
		}, 10000); //yang ini untuk selalu cek isi data notifikasinya sama setiap 2 detik diambil dari controller notifikasi fungsi load_data
		</script>
		
		<!-- datepicker -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/js/jquery-ui-1.11.4/jquery-ui.css'); ?>">
		
		<script src="<?php echo base_url('assets/js/jquery-ui-1.11.4/jquery-ui.js'); ?>"></script>	
		<!-- lightbox -->
		<link  type="text/css" href="<?php echo base_url('assets/lightbox/dist/ekko-lightbox.min.css'); ?>" rel="stylesheet">
		<link  type="text/css" rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
		<script type="text/javascript" src="<?php echo base_url('assets/lightbox/dist/ekko-lightbox.min.js'); ?>"></script>
		<link  type="text/css" href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">
		<link  type="text/css" href="<?php echo base_url('assets/datatables/media/css/jquery.dataTables.min.css'); ?>" rel="stylesheet">
		<script type="text/javascript">
		$(document).ready(function(){
			$(".page-scroll").on('click', function(event) {
			    if (this.hash !== "") {
			      	event.preventDefault();
			      	var hash = this.hash;
			      	$('html, body').animate({
			        	scrollTop: $(hash).offset().top
			      	}, 800, function(){
			        	window.location.hash = hash;
			      	});
			    } 
		  	});
		});
		</script>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-99631540-1', 'auto');
		  ga('send', 'pageview');

		</script>
	</head>
	<body>
		<nav class="navbar-topers navbar-fixed-top">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="navbar-header">
							<ul class="list-header">
								<li class="<?php if(isset($tab1)) echo 'active'; ?>"><a href="<?php echo site_url('beranda'); ?>" class="page-scroll">Beranda</a></li>
								<li class="<?php if(isset($tab1)) echo 'active'; ?>"><a href="<?php echo site_url('p/about'); ?>" class="page-scroll">Tentang Kami</a></li>
								<li class="<?php if(isset($tab1)) echo 'active'; ?>"><a href="<?php echo site_url('p/disclaimer'); ?>" class="page-scroll">Disclaimer</a></li> 
								<?php if($this->session->userdata('id_biquers')!=null){ ?>
								<li class="<?php if(isset($tab2)) echo 'active'; ?>"><a href="<?php echo site_url('ruangbelajar'); ?>" class="page-scroll">Ruang Belajar</a></li>										
						   		<?php } ?>										
						    </ul>
						</div>
					</div>
				</div>
			</div>
		</nav>
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span> 
							</button>
							<a class="navbar-brand" href="<?php echo site_url('/beranda'); ?>"><img src="<?php echo base_url('assets/img/logobiku2.png'); ?>" class="img-responsive" style="width:100px;margin-top:0px;"></a>
						</div>
						<div class="collapse navbar-collapse" id="myNavbar">
							<div class="col-sm-6 col-sm-offset-1" style="padding:10px 10px 0px 10px">
								<form action="<?php echo site_url('kontenbelajar/index'); ?>" method="GET">
									<div class="input-group">
										<input type="text" name="keyword" placeholder="cari konten di sini..." class="form-control search" />
										<span class="input-group-btn">
											<button type="button" class="btn bg-yellow" name="search"><i style="color:#fff" class="fa fa-search"></i></button>
										</span>
									</div>
								</form>
							</div>
						    <ul class="nav navbar-nav navbar-right">
						    	<?php if($this->session->userdata('id_biquers')==null){ ?>
								<li class="<?php if(isset($tab98)) echo 'active'; ?>"><a href="<?php 
								if(isset($cpage)){
									echo site_url('daftar?go='.$cpage_url);
								}else{
									echo site_url('daftar');
								} 
								?>" class="page-scroll"><span class="glyphicon glyphicon-user"></span> Daftar</a></li>																												
								<li class="<?php if(isset($tab99)) echo 'active'; ?>"><a href="<?php 
								if(isset($cpage)){
									echo site_url('login?go='.$cpage_url);
								}else{
									echo site_url('login');
								} 
								?>" class="page-scroll"><span class="glyphicon glyphicon-log-in"></span> Masuk</a></li>																												
						    	<?php }else{ ?>
								<li class="dropdown">
								  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell-o"></i> <span class="badge badge-danger" id="load_row"><?php echo $this->mnotifikasi->notif_count(); ?></span></a>
								  </a>
								  <ul class="dropdown-menu" aria-labelledby="load_data" id="load_data">
										
								  </ul>
								</li>
								<li class="dropdown">
								  <a class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									<span class="fa fa-money"></span>
									 <small><?php echo "Rp ".number_format($this->Crud->getSaldo($this->session->userdata('id_biquers')),2,',','.'); ?></small>
									<span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
									<li class="dropdown-header">SAKU</li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo site_url('saku/?page=topup'); ?>">Top Up Saku</a></li>
									<li><a href="<?php echo site_url('saku/?page=cashout'); ?>">Cashout</a></li>
									<li><a href="<?php echo site_url('saku/?page=history'); ?>">History</a></li>
								  </ul>
								</li>
								<li class="dropdown">
								  <a class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
									<span class="glyphicon glyphicon-user"></span>
									<?php echo $this->session->userdata('nama'); ?>
									<span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
									<li><a href="<?php echo site_url('pengguna/profil'); ?>">Profil</a></li>
									<li role="separator" class="divider"></li>
									<li class="bg-yellow"><a href="<?php echo site_url('tesminat'); ?>">TES MINAT</a></li>
									<li role="separator" class="divider"></li>
									<li><a href="<?php echo site_url('pengguna/jadwal'); ?>">Jadwal Belajar</a></li>
									<li role="separator" class="divider"></li>
									
									<li><a href="<?php echo site_url('ruangbelajar/'); ?>">Ruang Belajar</a></li>
									
									<li role="separator" class="divider"></li>
									<li class=""><a href="<?php echo site_url('pengguna/ubahpassword'); ?>" class="page-scroll"><span class="fa fa-lock"></span> Ubah Password</a></li>
									<li class=""><a href="<?php
									if(isset($cpage)){
										echo site_url('pengguna/logout?go='.$cpage_url);
									}else{
										echo site_url('pengguna/logout');
									} 
									?>" class="page-scroll"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
								  </ul>
								</li>
						    	
						    	<?php } ?>
						    </ul>
						</div>
					</div>
				</div>
			</div>
		</nav>
		<?php
		if($this->input->get('ref')=='line'){
			echo '		
		<script type="text/javascript" >
		  $(document).ready(function($) {
			  event.preventDefault();
			  jQuery.noConflict(); 
			  $("#addline").modal("show");
		});
		</script>
		<!-- MODAL -->
		<div class="modal fade" id="addline" role="dialog" style="display: none;">
			<div class="modal-dialog" style="margin-top: 100px;">
						<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">x</button>
						Add BikuBiku Untuk Mendapatkan Informasi Terupdate
					</div>
					<div class="modal-body">
						<p>
						<center>
						<div class="row">
							<div>
								<a class="thumbnail" href="http://line.me/ti/p/%40uno2982p">
									<img style="height:200px" src="http://qr-official.line.me/L/rCc3gk4RZj.png" />
								</a>
							</div>
							<div>
								<a href="https://line.me/R/ti/p/%40uno2982p"><img height="36" border="0" alt="Tambah Teman" src="https://scdn.line-apps.com/n/line_add_friends/btn/en.png"></a>
							</div>
						</div>
						</center>
						</p>
					</div>
				</div>

			</div>
		</div>
		<!-- END -->';
		}
		?>