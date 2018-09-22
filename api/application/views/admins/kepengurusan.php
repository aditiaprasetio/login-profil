
<div id="page-wrapper" class="gray-bg dashbard-1">
    <div class="content-main">
		<!--banner-->	
	    <div class="banner">
			<h2>
			<a href="<?php echo site_url('admins'); ?>">Home</a>
			<i class="fa fa-angle-right"></i>
			<span>Kepengurusan</span>
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
	<div class="col-md-3 compose">
        <a href="<?php echo site_url('admins/kepengurusan'); ?>"><h2>KEPENGURUSAN</h2></a>
		<nav class="nav-sidebar">
			<ul class="nav tabs">
			  <li><a href="#tabJabatan" data-toggle="tab"><i class="fa fa-user"></i>Jabatan</a></li>
			  <li><a href="#tabJabatan" data-toggle="tab"><i class="fa fa-user"></i>Jabatan</a></li>
			</ul>
		</nav>
	</div>
<!-- tab content -->
<div class="col-md-9 tab-content tab-content-in">
	<div class="tab-pane <?php if($this->input->get('do')==null) echo 'active'; ?> text-style" id="tab1">
		<div class="inbox-right">
			<div class="mailbox-content">
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>Jabatan</th>
							<th>Deskripsi</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=1;
						foreach($jabatan->result() as $dt){
						?>
						<tr class="table-row">
							<td class="table-text">
							   <?php echo $i; ?>
							</td>
							<td class="table-text">
								<h6><?php echo $dt->nama_jabatan; ?></h6>
							</td>
							<td class="march">
							   <?php echo html_cut($dt->deskripsi, 100).'...'; ?>
							</td>
							<td>
								<a href="<?php echo site_url('admins/kepengurusan?do=editjabatan&kode_jabatan='.$dt->kode_jabatan.'&nama_jabatan='.$dt->nama_jabatan); ?>" class="btn btn-info btn-xs">
									<i class="fa fa-pencil"></i> Edit
								</a>
							</td>
						</tr>
						<?php
						$i++;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
			<?php if($this->input->get('do')=='editjabatan'){ ?>
			<div class="tab-pane <?php if($this->input->get('do')=='editjabatan') echo 'active'; ?> text-style" id="tab">
				<div class="inbox-right">
					<div class="mailbox-content">
					<?php
					$url_proses=site_url('admins/update_jabatan_proses');
					?>
					<form action="<?php echo $url_proses; ?>" method="POST" enctype="multipart/form-data">
						<h3>Edit Kepengurusan : <?php echo $this->input->get('kode_jabatan'); ?></h3><br/>
						<div class="col-md-12 form-group1 group-mail">
							<input type="text" name="nama_jabatan" value="<?php echo $this->input->get('nama_jabatan'); ?>" />
						</div>
						<div class="col-md-12 form-group1 ">
						  <label class="control-label">Deskripsi (Tugas dan Fungsi)</label>
						  <textarea name="deskripsi" id="editor1" ><?php echo $this->input->get('deskripsi'); ?></textarea>
						    <script>
								// Replace the <textarea id="editor1"> with a CKEditor
								// instance, using default configuration.
								CKEDITOR.replace('editor1');
							</script>
						</div>
						<div class="clearfix"> </div>
						<div class="col-md-12 form-group1 group-mail">
							<input type="hidden" name="kode_jabatan" value="<?php echo $this->input->get('kode_jabatan'); ?>" />
						</div>
						 <div class="clearfix"> </div>
						<div class="col-md-12 form-group">
						  <input type="submit" name="submit" class="btn btn-primary" value="Save" />
						</div>
						<div class="clearfix"> </div>
					</form>
				   </div>
				</div>
			</div>
			<?php } ?>
		</div>
		<div class="clearfix"> </div>
		   </div>
		</div>

 	<!--//grid-->

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