<style>
.panel_text{
	text-align:justify !important;
}
</style>
<!-- breadcrumbs -->
	<div class="agileits_breadcrumbs">
		<div class="container">
			<div class="agileits_breadcrumbs_left">
				<ul>
					<li><a href="<?php echo site_url(); ?>">Home</a><i>|</i></li>
					<li>Profil</li>
				</ul>
			</div>
			<div class="agileits_breadcrumbs_right">
				<h2>Profil</h2>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- about -->
	<div class="about">
		<div class="container">
			<h3 class="head"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>Profil</h3>
			<div class="w3_about_grids">
				<div class="col-md-6 w3_about_grid_left">
					<h5>PROFIL PERHIMATEKMI</h5>
					<p>Perhimpunan Mahasiswa Teknologi Maritim se-Indonesia (PERHIMATEKMI) adalah perkumpulan lembaga kemahasiswaan (himpunan mahasiswa) yang berbasis Teknologi Maritim se- Indonesia.</p>
					<div class="panel-group about_panel" id="accordion" role="tablist" aria-multiselectable="true">
					  <div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingProfil">
						  <h4 class="panel-title asd">
							<a class="pa_italic collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseProfil" aria-expanded="false" aria-controls="collapseProfil">
							  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span><i class="glyphicon glyphicon-minus" aria-hidden="true"></i>Profil Lengkap
							</a>
						  </h4>
						</div>
						<div id="collapseProfil" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingProfil">
						  <div class="panel-body panel_text">
							<?php echo $web['profil']; ?>
						  </div>
						</div>
					  </div>
					  <div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingAsas">
						  <h4 class="panel-title asd">
							<a class="pa_italic collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseAsas" aria-expanded="false" aria-controls="collapseAsas">
							  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span><i class="glyphicon glyphicon-minus" aria-hidden="true"></i>Asas dan Landasan
							</a>
						  </h4>
						</div>
						<div id="collapseAsas" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingAsas">
						  <div class="panel-body panel_text">
							<?php echo $web['asasdanlandasan']; ?>
						  </div>
						</div>
					  </div>
					  <div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
						  <h4 class="panel-title asd">
							<a class="pa_italic collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
							  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span><i class="glyphicon glyphicon-minus" aria-hidden="true"></i>Tujuan
							</a>
						  </h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						  <div class="panel-body panel_text">
							<?php echo $web['tujuan']; ?>
						  </div>
						</div>
					  </div>
					  <div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingTwo">
						  <h4 class="panel-title asd">
							<a class="pa_italic collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
							  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span><i class="glyphicon glyphicon-minus" aria-hidden="true"></i>Visi
							</a>
						  </h4>
						</div>
						<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
						   <div class="panel-body panel_text">
							<?php echo $web['visi']; ?>
						  </div>
						</div>
					  </div>
					  <div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingThree">
						  <h4 class="panel-title asd">
							<a class="pa_italic collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
							  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span><i class="glyphicon glyphicon-minus" aria-hidden="true"></i>Misi
							</a>
						  </h4>
						</div>
						<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
						   <div class="panel-body panel_text">
							<?php echo $web['misi']; ?>
						  </div>
						</div>
					  </div>
					</div>
				</div>
				<div class="col-md-6 w3_about_grid_right">
					<div class="wmuSlider example1 animated wow slideInUp" data-wow-delay=".5s">
						<div class="wmuSliderWrapper">
							<?php
							$i=1;
							foreach($web as $key=>$value){
								if($key=='profilpic_'.$i){
							?>
							<article style="position: absolute; width: 100%; opacity: 0;"> 
								<div class="banner-wrap">
									<img src="<?php echo $value; ?>" alt=" " class="img-responsive" />
								</div>
							</article>
							<?php
								$i++;
								}
							}
							?>
						</div>
					</div>
					<script src="<?php echo base_url('assets/general/js/jquery.wmuSlider.js'); ?>"></script> 
						<script>
							$('.example1').wmuSlider();         
						</script> 
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
<!-- //about -->
<!-- team -->
	<div class="team">
		<div class="container">
			<h3 class="head"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>Kepengurusan</h3>
			<div class="agile_team_grids">
				<div class="col-md-12">
					<img style="margin:0 auto;" src="<?php if(file_exists($web['struktur'])) echo base_url($web['struktur']); elseif(substr($web['struktur'],0,4)=='http') echo $web['struktur']; else echo base_url('assets/general/images/no_image.png'); ?>" alt=" " class="img-responsive" />
				</div>
				<?php /* />
				<div class="col-md-3 agile_team_grid">
					<div class="agile_team_grid1">
						<img src="<?php echo base_url('assets/general/images'); ?>/1.png" alt=" " class="img-responsive" />
						<div class="agile_team_grid1_pos">
							<a href="#" class="facebook1"></a>
						</div>
						<div class="agile_team_grid1_pos1">
							<ul>
								<li><a href="#" class="google1"></a></li>
								<li><a href="#" class="instagram1"></a></li>
							</ul>
						</div>
					</div>
					<h4>Daniel Paul <span>Farmer</span></h4>
					<p>Morbi placerat molestie felis. Integer facilisis velit leo.</p>
				</div>
				<div class="col-md-3 agile_team_grid">
					<div class="agile_team_grid1">
						<img src="<?php echo base_url('assets/general/images'); ?>/3.png" alt=" " class="img-responsive" />
						<div class="agile_team_grid1_pos">
							<a href="#" class="twitter1"></a>
						</div>
						<div class="agile_team_grid1_pos1">
							<ul>
								<li><a href="#" class="facebook1"></a></li>
								<li><a href="#" class="instagram1"></a></li>
							</ul>
						</div>
					</div>
					<h4>Mark Doe <span>Farmer</span></h4>
					<p>Morbi placerat molestie felis. Integer facilisis velit leo.</p>
				</div>
				<div class="col-md-3 agile_team_grid">
					<div class="agile_team_grid1">
						<img src="<?php echo base_url('assets/general/images'); ?>/2.png" alt=" " class="img-responsive" />
						<div class="agile_team_grid1_pos">
							<a href="#" class="google1"></a>
						</div>
						<div class="agile_team_grid1_pos1">
							<ul>
								<li><a href="#" class="instagram1"></a></li>
								<li><a href="#" class="twitter1"></a></li>
							</ul>
						</div>
					</div>
					<h4>John Crisp <span>Farmer</span></h4>
					<p>Morbi placerat molestie felis. Integer facilisis velit leo.</p>
				</div>
				<div class="col-md-3 agile_team_grid">
					<div class="agile_team_grid1">
						<img src="<?php echo base_url('assets/general/images'); ?>/4.png" alt=" " class="img-responsive" />
						<div class="agile_team_grid1_pos">
							<a href="#" class="instagram1"></a>
						</div>
						<div class="agile_team_grid1_pos1">
							<ul>
								<li><a href="#" class="facebook1"></a></li>
								<li><a href="#" class="twitter1"></a></li>
							</ul>
						</div>
					</div>
					<h4>Michael Carl <span>Farmer</span></h4>
					<p>Morbi placerat molestie felis. Integer facilisis velit leo.</p>
				</div>
				<?php */ ?>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
<!-- //team -->
<!-- team-bottom -->
	<div class="team-bottom">
		<div class="container">
			<h3>Ingin menghubungi kami lebih lanjut?</h3>
			<p class="dolor">Silakan kirim pesan via email ke : <b>admin@perhimatekmi.com</b></p>
			<div class="more more1">
				<a href="mailto:admin@perhimatekmi.com" class="button button--nina button--size-s" data-text="Mail Us">
					<span>M</span><span>a</span><span>i</span><span>l</span> <span>U</span><span>s</span>
				</a>
			</div>
		</div>
	</div>
<!-- //team-bottom -->