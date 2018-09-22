<div class="blo-top1">
	<div class="tech-btm">
	<div class="search-1 wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
			<form action="<?php echo site_url('search'); ?>" method="get">
				<input type="search" name="keyword" value="Search" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}" required="">
				<input type="submit" value=" ">
			</form>
		</div>
	<h4>Popular Posts </h4>
		<?php
		foreach($artikelpopuler->result() as $dt){
			if($this->input->cookie('lang',true)=='in'){
				$dt->slug=$dt->slug1;
				$dt->judul=$dt->judul1;
				$dt->isiartikel=$dt->isiartikel1;
			}
		?>
		<div class="blog-grids wow fadeInDown" data-wow-duration=".8s" data-wow-delay=".2s">
			<div class="blog-grid-left" style="height: 150px;width: 100%;background-size: cover;" >
				<a href="<?php echo site_url('post/'.$dt->slug); ?>">
				<img src="<?php echo base_url('assets/images/preview/'.$dt->preview); ?>" class="img-responsive" alt=""></a>
			</div>
			<div class="blog-grid-right">
				<h5><a href="<?php echo site_url('post/'.$dt->slug); ?>"><?php echo $dt->judul; ?></a> </h5>
			</div>
			<div class="clearfix"> </div>
		</div>
		<?php
		}
		?>
		<div class="insta wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
	<h4>Tags</h4>
			<?php
			foreach($listkategori->result() as $dt){
				if($this->input->cookie('lang',true)=='in'){
					$dt->category_name=$dt->nama_kategori;
				}
				echo '<a href="'.site_url('search?keyword='.$dt->category_name).'" class="label label-danger">'.$dt->category_name.'</a> ';
			}
			?>
	</div>
	</div>
	
</div>