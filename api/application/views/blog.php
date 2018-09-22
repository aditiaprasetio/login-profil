<!-- breadcrumbs -->
	<div class="agileits_breadcrumbs">
		<div class="container">
			<div class="agileits_breadcrumbs_left">
				<ul>
					<li><a href="<?php echo site_url(); ?>">Home</a><i>|</i></li>
					<li><?php echo $menu; ?></li>
				</ul>
			</div>
			<div class="agileits_breadcrumbs_right">
				<h2><?php echo $menu; ?></h2>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- blog -->
	<div class="blog">
		<div class="container">
			<div class="col-md-8 wthree_blog_left">
				<?php
				if($listartikel->num_rows()==0){
				?>
				<div class="alert alert-danger">
					<p>Pencarian untuk kata kunci <?php echo '<b>'.$this->input->get('type').' '.$this->input->get('keyword').'</b>'; ?> tidak ditemukan. <br/><small>Silakan gunakan kata kunci lain atau hubungi admin.</small></p>
				</div>
				<?php
				}
				foreach($listartikel->result() as $dt){
				?>
				<div class="wthree_blog_left_grid">
					<div class="wthree_blog_left_grid_slider" style="background-size: cover;min-height: 300px;min-width:100%;overflow: hidden;">
						<a href="<?php echo site_url('post/'.$dt->slug); ?>">
						<?php
						if(file_exists('assets/general/images/preview/'.$dt->preview)){
							$url_picture=base_url('assets/general/images/preview/'.$dt->preview);
						}else{
							$url_picture=base_url('assets/general/images/no_image.png');
						}
						?>
						<img src="<?php echo $url_picture; ?>" alt=" " style="min-height:300px;min-width:100%;background-size:cover;overflow:hidden" class="img-responsive" />
						</a>
					</div>
					<h4>PERHIMATEKMI</h4>
					<h3><a href="<?php echo site_url('post/'.$dt->slug); ?>"><?php echo $dt->judul; ?></a></h3>
					<ul>
						<li><span class="glyphicon glyphicon-user" aria-hidden="true"></span><a href="#">ADMIN</a><i>|</i></li>
						<li><span class="glyphicon glyphicon-heart" aria-hidden="true"></span><a href="#"><?php echo $dt->hit; ?></a><i>|</i></li>
						<li><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span><a href="#"><?php echo $dt->createDate; ?></a><i></i></li>
					</ul>
					<p><?php html_cut($dt->isiartikel,200); ?></p>
					<div class="more more1">
						<a href="<?php echo site_url('post/'.$dt->slug); ?>" class="button button_single button--nina button--size-s" data-text="More">
							<span>M</span><span>o</span><span>r</span><span>e</span>
						</a>
					</div>
				</div>
				<?php
				}
				?>
				<nav>
				  <ul class="pagination w3_paging">
					<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
					<li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li><a href="#">4</a></li>
					<li><a href="#">5</a></li>
					<li>
					  <a href="#" aria-label="Next">
						<span aria-hidden="true">&raquo;</span>
					  </a>
					</li>
				  </ul>
				</nav>
			</div>
			<?php 
			$datanya=array();
			$this->load->view('layout/right_sidebar', $datanya); 
			?>
			<div class="clearfix"> </div>
			
		</div>
	</div>
<!-- //blog -->
<?php
function html_cut($text, $max_length){
	$tags   = array();
	$result = "";

	$is_open   = false;
	$grab_open = false;
	$is_close  = false;
	$in_double_quotes = false;
	$in_single_quotes = false;
	$tag = "";

	$i = 0;
	$stripped = 0;

	$stripped_text = strip_tags($text);

	while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length)
	{
		$symbol  = $text{$i};
		$result .= $symbol;

		switch ($symbol)
		{
		   case '<':
				$is_open   = true;
				$grab_open = true;
				break;

		   case '"':
			   if ($in_double_quotes)
				   $in_double_quotes = false;
			   else
				   $in_double_quotes = true;

			break;

			case "'":
			  if ($in_single_quotes)
				  $in_single_quotes = false;
			  else
				  $in_single_quotes = true;

			break;

			case '/':
				if ($is_open && !$in_double_quotes && !$in_single_quotes)
				{
					$is_close  = true;
					$is_open   = false;
					$grab_open = false;
				}

				break;

			case ' ':
				if ($is_open)
					$grab_open = false;
				else
					$stripped++;

				break;

			case '>':
				if ($is_open)
				{
					$is_open   = false;
					$grab_open = false;
					array_push($tags, $tag);
					$tag = "";
				}
				else if ($is_close)
				{
					$is_close = false;
					array_pop($tags);
					$tag = "";
				}

				break;

			default:
				if ($grab_open || $is_close)
					$tag .= $symbol;

				if (!$is_open && !$is_close)
					$stripped++;
		}

		$i++;
	}

	while ($tags)
		$result .= "</".array_pop($tags).">";

	return $result;
}
?>