
<div id="page-wrapper" class="gray-bg dashbard-1">
    <div class="content-main">
		<!--banner-->	
	    <div class="banner">
			<h2>
			<a href="<?php echo site_url('admins'); ?>">Home</a>
			<i class="fa fa-angle-right"></i>
			<span>Setting</span>
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
        <a href="<?php echo site_url('admins/setting'); ?>"><h2>SETTING</h2></a>
		<nav class="nav-sidebar">
			<ul class="nav tabs">
			  <?php foreach($web as $key=>$value){ ?>
			  <li><a href="#tab<?php echo $key; ?>" data-toggle="tab"><i class="fa fa-gear"></i><?php echo $key; ?></a></li>
			  <?php } ?>
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
							<th>Key Setting</th>
							<th>Value</th>
							<th>Action</th>
						</tr>
					</thead>
                    <tbody>
						<?php
						$i=1;
						foreach($web as $key=>$value){
						?>
                        <tr class="table-row">
							<td class="table-text">
                               <?php echo $i; ?>
                            </td>
                            <td class="table-text">
                            	<h6><?php echo $key; ?></h6>
                            </td>
                            <td class="march">
                               <?php echo html_cut($value, 100).'...'; ?>
                            </td>
							<td>
								<a href="<?php echo site_url('admins/setting?do=edit&id='.$key); ?>" class="btn btn-info btn-xs">
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
			<?php foreach($web as $key=>$value){ ?>
			<div class="tab-pane <?php if($this->input->get('do')=='edit' && $this->input->get('id')==$key ) echo 'active'; ?> text-style" id="tab<?php echo $key; ?>">
				<div class="inbox-right">
					<div class="mailbox-content">
					<?php
					$url_proses=site_url('admins/update_setting_proses');
					?>
					<form action="<?php echo $url_proses; ?>" method="POST" enctype="multipart/form-data">
						<h3>Edit Setting : <?php echo $key; ?></h3><br/>
						<div class="col-md-12 form-group1 ">
						  <label class="control-label">Setting (Value)</label>
						  <textarea name="value" id="editor<?php echo $key; ?>" ><?php echo $value; ?></textarea>
						    <?php
							$list_use_editor=array('asasdanlandasan', 'misi', 'profil', 'tujuan', 'visi');
							if(in_array($key, $list_use_editor)){
							?>
							<script>
								// Replace the <textarea id="editor1"> with a CKEditor
								// instance, using default configuration.
								CKEDITOR.replace('editor<?php echo $key; ?>');
							</script>
							<?php
							}
							?>
						</div>
						<div class="clearfix"> </div>
						<div class="col-md-12 form-group1 group-mail">
							<input type="hidden" name="id_setting" value="<?php echo $key; ?>" placeholder="Setting..." />
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