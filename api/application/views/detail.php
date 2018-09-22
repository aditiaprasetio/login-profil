<?php
$download=false;

$slug=explode('-',$artikel['slug']);
foreach($slug as $key=>$value){
	if($value=='download'){
		$download=true;
		$text=$artikel['isiartikel'];
		$length=strlen($text);
		for($i=0; $i<$length; $i++){
			if(substr($text, $i, 4)=='http'){
				$start=$i;
			}
			if(substr($text, $i, 4)=='.apk'){
				$end=$i;
			}
		}
		$url=substr($text, $start, $end);
		$artikel['isiartikel']=str_replace($url,"",$text);
		break;
	}else{
		continue;
	}
}

?>
<div class="col-md-9 btm-wthree-left">
	<div class="single-left">
	<div class="single-left1">
		<img src="<?php echo base_url('assets/general/images/preview/'.$artikel['preview']); ?>" alt=" " class="img-responsive" />
		<h3><?php echo $artikel['judul']; ?></h3>
		<ul>
			<li><span class="glyphicon glyphicon-user" aria-hidden="true"></span><a href="#"><?php if($artikel['id_user']==null) echo 'Administrator'; else echo 'Kiriman Pengguna ( '.$artikel['full_name'].' )'; ?></a></li>
			<!--<li><span class="glyphicon glyphicon-tag" aria-hidden="true"></span><a href="#">5 Tags</a></li>-->
			<li><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
			<a href="<?php echo site_url('post/'.$artikel['slug']); ?>#disqus_thread">x Comments</a></li>
		</ul>
		<p><?php echo $artikel['isiartikel']; ?></p>
		<?php if($download) echo '<a class="btn btn-success" href="'.$url.'"><i class="fa fa-download"></i> DOWNLOAD NOW</a>'; ?>
	</div>
	<?php if($artikel['id_user']!=null){ ?>
	<div class="admin">
		<p>Informasi ini dikirimkan oleh pengguna aplikasi WeMo. Download aplikasinya sekarang di GooglePlay.</p>
		<a href="#"><i>Pengirim : <?php echo $artikel['full_name']; ?></i></a>
	</div>
	<?php } ?>
		<hr/>
	<div class="comments">
		<h3>Comments</h3>
		<div class="comments-grids">
			<div id="disqus_thread"></div>
			<script>

			/**
			*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
			*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
			
			var disqus_config = function () {
			this.page.url = "<?php echo site_url('post/'.$artikel['slug']); ?>";  // Replace PAGE_URL with your page's canonical URL variable
			this.page.identifier = "<?php echo $artikel['id_artikel']; ?>"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
			};
			
			(function() { // DON'T EDIT BELOW THIS LINE
			var d = document, s = d.createElement('script');
			s.src = 'https://wemo.disqus.com/embed.js';
			s.setAttribute('data-timestamp', +new Date());
			(d.head || d.body).appendChild(s);
			})();
			</script>
			<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
										
		</div>
		<script id="dsq-count-scr" src="//wemo.disqus.com/count.js" async></script>
	</div>
</div>

</div>