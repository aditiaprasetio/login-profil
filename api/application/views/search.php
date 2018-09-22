<?php
function html_cut($text, $max_length)
{
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

$jml=$listartikel->num_rows();
		
$page=$this->input->get('page');
if($page==null) $page=0;
$start=$page*6+1;
$end=$start+5;
	
if($this->input->cookie('lang',true)=='in'){
	$text_more='Baca Selengkapnya';
	$text_not_found='Artikel dengan kata kunci <span class="label label-default">'.$this->input->get('keyword').'</span> tidak ditemukan';
	$text_found='Ditemukan '.$listartikel->num_rows().' hasil';
}else{
	$text_more='Continue Reading';
	$text_not_found='Keyword <span class="label label-default">'.$this->input->get('keyword').'</span> is not found.';
	$text_found='Total result : '.$listartikel->num_rows().'.';
}
?>
	<div class="technology">
	<div class="container">
		<div class="col-md-9 technology-left">
		<div class="tech-no">
		<?php
		if($page==0){
		if($listartikel->num_rows()==0){
			echo '<div class="alert alert-warning">'.$text_not_found.'</div>';
		}else{
			echo '<div class="alert alert-info">'.$text_found.'</div>';
		}
		}
		$i=1;
		
		foreach($listartikel->result() as $dt){
			if($i>=$start && $i<=$end){
				
			}else{
				$i++;
				continue;
			}
			
			?>
			<div class="wthree">
				 <div class="col-md-6 wthree-left wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
					<div class="tch-img" style="widht:100%; max-height:200px; overflow:hidden; object-fit: cover;">
							<a href="<?php echo site_url('post/'.$dt->slug); ?>"><img style="min-width:100%" src="<?php echo base_url('assets/images/preview/'.$dt->preview); ?>" class="img-responsive" alt=""></a>
						</div>
				 </div>
				 <div class="col-md-6 wthree-right wow fadeInDown"  data-wow-duration=".8s" data-wow-delay=".2s">
						<h3><a href="<?php echo site_url('post/'.$dt->slug); ?>"><?php echo $dt->judul; ?></a></h3>
						<h6>BY <a href="<?php echo site_url('post/'.$dt->slug); ?>">ADMIN </a><?php echo $dt->createDate; ?></h6>
							<?php echo html_cut($dt->isiartikel,150); ?>
							<div class="bht1">
								<a href="<?php echo site_url('post/'.$dt->slug); ?>"><?php echo $text_more; ?></a>
							</div>
							<div class="soci">
								<ul>
									
									<li class="hvr-rectangle-out"><a class="twit" href="#"></a></li>
									<li class="hvr-rectangle-out"><a class="pin" href="#"></a></li>
								</ul>
							</div>
							<div class="clearfix"></div>
					
				 </div>
					<div class="clearfix"></div>
			</div>
			<?php
		$i++;
		}
		?>
				<nav aria-label="...">
				  <ul class="pager">
					<?php
					$keyword=$this->input->get('keyword');
					
					if($page>0){
						echo '<li><a href="'.site_url('search?keyword='.$keyword.'&page='.($page-1)).'">New Articles</a></li>';
					}
					if($jml>($start+$i-2)){
						echo '<li><a href="'.site_url('search?keyword='.$keyword.'&page='.($page+1)).'">Old Articles</a></li>';
					}
					?>
				  </ul>
				</nav>
			</div>
		</div>
		<!-- technology-right -->
		<div class="col-md-3 technology-right">
			<?php
			$data['listkategori']=$listkategori;
			$data['artikelpopuler']=$artikelpopuler;
			$this->load->view('_sidebar_right.php', $data);
			?>
		</div>
		<div class="clearfix"></div>
		<!-- technology-right -->
	</div>