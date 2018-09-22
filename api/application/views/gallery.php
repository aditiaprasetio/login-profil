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
			<?php
			if(isset($listalbum)){
				foreach($listalbum->result() as $dt){
				?>
				<div class="col-md-3">
					<div class="wthree_blog_left_grid">
						<div style="background-size: cover;height: 150px;overflow: hidden;">
						<a href="<?php echo site_url('galeri/'.$dt->id_album); ?>">
						<img src="<?php if($dt->url_foto==null) echo base_url('assets/general/images/noimage.png'); else echo base_url('assets/general/images/gallery/'.$dt->url_foto); ?>" alt=" " style="min-width:100%; min-height:150px;" class="img-responsive" />
						</a>
						</div>
						<h4><?php if($dt->jml==0) echo 'BELUM ADA'; else echo $dt->jml; ?> FOTO </h4>
						<h3><a href="<?php echo site_url('galeri/'.$dt->id_album); ?>"><?php echo $dt->nama_album; ?></a></h3>
						
					</div>
				</div>
				<?php
				}
			}
			?>
			<?php
			if(isset($listfoto)){
				echo '<h2> <a href="'.site_url('galeri').'">Gallery</a> | '.$album['nama_album'].' ';
				if($this->session->userdata('id')!=null){
					echo '<a onclick="return confirm(\'Are you sure? All photos in this album will delete automatically.\'); " href="'.site_url('admins/delete_album_proses/'.$album['id_album']).'" class="btn btn-danger btn-xs">
								<i class="fa fa-trash"></i> Delete Album
							</a>';
					echo ' <a href="'.site_url('admins/gallery?do=add_image&album='.$album['id_album']).'" class="btn btn-primary btn-xs">
								<i class="fa fa-plus-square"></i> Add Image
							</a>';
				}
				echo '</h2><hr/>';
				foreach($listfoto->result() as $dt){
				?>
				<div class="col-md-3">
					<div class="wthree_blog_left_grid">
						<div style="background-size: cover;height: 150px;overflow: hidden;">
						<a href="<?php echo site_url('assets/general/images/gallery/'.$dt->url_foto); ?>">
						<img src="<?php echo site_url('assets/general/images/gallery/'.$dt->url_foto); ?>" alt=" " style="min-width:100%; min-height:150px;" class="img-responsive" />
						</a>
						</div>
						<?php if($this->session->userdata('id')!=null){ 
							echo '<a onclick="return confirm(\'Are you sure? If you continue, your photo will delete and cannot cancel the process.\'); " href="'.site_url('admins/delete_foto_proses/'.$dt->id_foto).'" class="btn btn-danger btn-xs">
									<i class="fa fa-trash"></i> Delete
								</a>'; 
							} 
						?>
					</div>
				</div>
				<?php
				}
			}
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