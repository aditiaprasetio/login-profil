		<!-- //btm-wthree-left -->
			<div class="col-md-9 btm-wthree-left">
				<?php 
				if($listartikel->num_rows()==0) echo '<div class="alert alert-info">Jadilah yang pertama berbagi! Download aplikasi WeMo di GooglePlay</div>';
				foreach($listartikel->result_array() as $artikel){ ?>
				<div class="wthree-top">
					<div class="w3agile-top">
						<div class="w3agile_special_deals_grid_left_grid" style="height: 200px;width: 100%;background-size: cover;" >
							<a href="<?php echo site_url('post/'.$artikel['slug']); ?>">
							<img src="<?php echo base_url('assets/general/images/preview/'.$artikel['preview']); ?>" class="img-responsive" alt="" />
							</a>
						</div>
						<div class="w3agile-middle">
						<ul>
							<li><a href="#"><i class="fa fa-calendar" aria-hidden="true"></i><?php echo date('d', strtotime($artikel['createDate'])).' '.date('M', strtotime($artikel['createDate'])).' '.date('Y', strtotime($artikel['createDate']));?></a></li>
							<li><a href="#"><i class="fa fa-user" aria-hidden="true"></i><?php if($artikel['id_user']==null) echo 'Administrator'; else echo 'Kiriman Pengguna ( '.$artikel['full_name'].' )'; ?></a></li>
							
						</ul>
					</div>
					</div>
					
					<div class="w3agile-bottom">
						<div class="col-md-3 w3agile-left">
							<h5>
							<?php if($artikel['tipe']=='informasi') echo '<span class="label label-info">Informasi/Artikel</span>'; 
							elseif($artikel['tipe']=='pengumuman') echo '<span class="label label-warning">Pengumuman</span>';
							?></h5>
						</div>
						<div class="col-md-9 w3agile-right">
							<h3><a href="<?php echo site_url('post/'.$artikel['slug']); ?>"><?php echo $artikel['judul']; ?></a></h3>
							<p><?php echo $artikel['isiartikel']; ?></p>
							<a class="agileits w3layouts" <?php if($artikel['tipe']=='informasi') echo 'style="background:#5bc0de"'; ?> href="<?php echo site_url('post/'.$artikel['slug']); ?>">Read More <span class="glyphicon agileits w3layouts glyphicon-arrow-right" aria-hidden="true"></span></a>
						</div>
							<div class="clearfix"></div>
					</div>
				</div>
				<?php } ?>
			</div>
			<!-- //btm-wthree-left -->