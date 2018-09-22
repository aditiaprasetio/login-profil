
			<!-- btm-wthree-right -->
			<div class="col-md-3 w3agile_blog_left">
				<div class="wthreesearch">
							<form action="<?php echo site_url('search'); ?>" method="get">
								<input type="search" name="keyword" placeholder="Cari disini..." required="">
								<button type="submit" class="btn btn-default search" aria-label="Left Align">
									<i class="fa fa-search" aria-hidden="true"></i>
								</button>
							</form>
						
				</div>
				
				<div class="agileinfo_calender">
				<h3>CONNECT SOCIALLY</h3>
				<div class="w3ls-social-icons-1">
					<a class="facebook" href="https://facebook.com/<?php echo $web['sosmed_fb']; ?>"><i class="fa fa-facebook"></i></a>
					<a class="twitter" href="#"><i class="fa fa-twitter"></i></a>
					<a class="pinterest" href="#"><i class="fa fa-pinterest-p"></i></a>
					<a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a>
					<a class="linkedin" href="#"><i class="fa fa-google-plus"></i></a>
					<a class="linkedin" href="#"><i class="fa fa-rss"></i></a>
					<a class="linkedin" href="#"><i class="fa fa-behance"></i></a>
				</div>
				</div>
				<div class="w3ls_popular_posts">
					<h3>Terbaru</h3>
					<?php foreach($artikelterbaru->result_array() as $artikel){ ?>
					<div class="agileits_popular_posts_grid">
						<div class="w3agile_special_deals_grid_left_grid" >
							<a href="<?php echo site_url('post/'.$artikel['slug']); ?>">
							<img style="height: 150px;width: 100%;background-size: cover;" src="<?php echo base_url('assets/general/images/preview/'.$artikel['preview']); ?>" class="img-responsive" alt="" /></a>
						</div>
						<h4><a href="<?php echo site_url('post/'.$artikel['slug']); ?>"><?php echo $artikel['judul']; ?></a></h4>
						<h5><i class="fa fa-calendar" aria-hidden="true"></i><?php echo date('d', strtotime($artikel['createDate'])).' '.date('M', strtotime($artikel['createDate'])).' '.date('Y', strtotime($artikel['createDate']));?></h5>
					</div>
					<?php } ?>
				</div>
				<div class="w3ls_recent_posts">
					<h3>Sering Dilihat</h3>
					<?php foreach($artikelpopuler->result_array() as $artikel){ ?>
					<div class="agileits_recent_posts_grid">
						<div class="agileits_recent_posts_gridl">
							<div class="w3agile_special_deals_grid_left_grid" >
								<a href="<?php echo site_url('post/'.$artikel['slug']); ?>">
								<img style="height: 70px;width: 100%;background-size: cover;" src="<?php echo base_url('assets/general/images/preview/'.$artikel['preview']); ?>" class="img-responsive" alt="" /></a>
							</div>
						</div>
						<div class="agileits_recent_posts_gridr">
							<h4><a href="<?php echo site_url('post/'.$artikel['slug']); ?>"><?php echo substr($artikel['judul'],0,20).'...'; ?></a></h4>
							<h5><i class="fa fa-calendar" aria-hidden="true"></i><?php echo date('d', strtotime($artikel['createDate'])).' '.date('M', strtotime($artikel['createDate'])).' '.date('Y', strtotime($artikel['createDate']));?></h5>
						</div>
						<div class="clearfix"> </div>
					</div>
					<?php } ?>
				</div>
				
				<div class="w3l_tags">
					<h3>Tags</h3>
					<ul class="tag">
						<?php foreach($listkategori->result_array() as $kategori){ ?>
						<li><a href="<?php echo site_url('search?keyword='.$kategori['nama_kategori']); ?>"><?php echo $kategori['nama_kategori']; ?></a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<!-- //btm-wthree-right -->
			<div class="clearfix"></div>