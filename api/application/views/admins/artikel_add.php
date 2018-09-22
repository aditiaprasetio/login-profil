
<div id="page-wrapper" class="gray-bg dashbard-1">
<div class="content-main">
	<!--banner-->	
	<div class="banner">
			<h2>
			<a href="<?php echo site_url('admins'); ?>">Home</a>
			<i class="fa fa-angle-right"></i>
			<span>Add New Articles</span>
			</h2>
		</div>
		<!--//banner-->
 	<!--grid-->
 	<div class="inbox-mail">
	<?php
	if($this->input->get('respon')=='success'){
		echo '<div class="alert alert-success">'.$this->input->get('message').'</div>';
	}elseif($this->input->get('respon')=='failed'){
		echo '<div class="alert alert-danger">'.$this->input->get('message').'</div>';
	}
	?>
<!-- tab content -->
		<div class="inbox-right">
            <div class="mailbox-content">
				<?php
				$url_proses=site_url('artikel/add_artikel_proses');
				?>
				<form action="<?php echo $url_proses; ?>" method="POST" enctype="multipart/form-data">
					<div class="form-group1 group-mail">
					  <label class="control-label">Judul</label>
					  <input type="text" name="judul" placeholder="Judul" required="">
					</div>
					<div class="form-group2 group-mail">
						<label class="control-label">Tipe Konten</label>
						<select name="tipe" >
							<option >- Pilih Tipe -</option>
							<option value="informasi">Informasi / Artikel</option>
							<option value="pengumuman">Pengumuman</option>
						</select>
					</div>
					<div class="clearfix"> </div>
					<div class="form-group1 ">
					  <label class="control-label">Artikel</label>
					  <textarea name="isiartikel" placeholder="Articles..." required="">
					  </textarea>
					</div>
					<div class="clearfix"> </div>
					
					<div class="form-group1 group-mail">
					</div>
					<div class="form-group2 group-mail">
						<label class="control-label">Tags</label>
						<ul>
						</ul>
						<select onchange="selectkategori(this);" >
							<option value="">- Add a tag -</option>
							<?php
							foreach($listkategori->result() as $dt){
								echo '<option value="'.$dt->id_kategori.'">'.$dt->nama_kategori.'</option>';
							}
							?>
							
						</select>
					</div>
					<div class="clearfix"> </div>
					<div class="form-group1 group-mail">
						<label class="control-label">Preview</label>
						<input name="preview" type="file" required />
					</div>
					<div class="clearfix"> </div>
					<div class="form-group1 group-mail">
						<label class="control-label">Youtube Video</label>
						<input name="youtube" type="text" placeholder="https://youtube.com?_______"  />
					</div>
					<div class="clearfix"> </div>
                	<div class="form-group">
					  <input type="submit" name="submit" class="btn btn-primary" value="Save and Publish" />
					  <input type="submit" name="submit" class="btn btn-warning" value="Save as Draft" />
					  <button type="reset" class="btn btn-default">Reset</button>
					</div>
					<div class="clearfix"> </div>
				</form>
			</div>
		</div>
		<div class="clearfix"> </div>
   </div>
</div>

 	<!--//grid-->
<script type="text/javascript" src='<?php echo base_url('assets/tinymce/tinymce.min.js'); ?>'></script>
<!--
<script>
tinymce.init({
  selector: 'textarea',
  height: 100,
  theme: 'modern',
  menubar: ['link'],
  plugins: [
	'advlist autolink lists link image charmap print preview anchor textcolor',
	'searchreplace visualblocks code fullscreen',
	'insertdatetime media table contextmenu paste code help wordcount'
  ],
  toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
  content_css: [
	'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
	'//www.tinymce.com/css/codepen.min.css'],
  add_unload_trigger: false,
    force_br_newlines : true,
    force_p_newlines : false,
      forced_root_block : 'p',
  allow_unsafe_link_target: true,
  valid_elements : 'a[href|target=_blank],strong/b,div[align],br,ol,ul,li'
});
</script>
-->
<script>
function selectkategori(select){
  var option = select.options[select.selectedIndex];
  var ul = select.parentNode.getElementsByTagName('ul')[0];
     
  var choices = ul.getElementsByTagName('input');
  for (var i = 0; i < choices.length; i++){
    if (choices[i].value == option.value)
		return;
	else if(option.value=='')
		return;
  }
     
  var li = document.createElement('li');
  var input = document.createElement('input');
  var text = document.createTextNode(option.firstChild.data);
     
  input.type = 'hidden';
  input.name = 'kategori[]';
  input.value = option.value;

  li.appendChild(input);
  li.appendChild(text);
  li.setAttribute('onclick', 'this.parentNode.removeChild(this);');     
    
  ul.appendChild(li);
}
</script>