
<div id="page-wrapper" class="gray-bg dashbard-1">
    <div class="content-main">
		<!--banner-->	
	    <div class="banner">
			<h2>
			<a href="<?php echo site_url('admins'); ?>">Home</a>
			<i class="fa fa-angle-right"></i>
			<span>Gallery</span>
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
            <h2>GALLERY</h2>
    <nav class="nav-sidebar">
		<ul class="nav tabs">
          <li <?php if($this->input->get('do')==null) echo 'class="active"'; ?>><a href="#tab1" data-toggle="tab"><i class="fa fa-list"></i>GALLERY<div class="clearfix"></div></a></li>
          <li <?php if($this->input->get('do')=='add') echo 'class="active"'; ?>><a href="#tab2" data-toggle="tab"><i class="fa fa-plus-square"></i>Add New Album</a></li>
        </ul>
	</nav>
</div>
<!-- tab content -->
<div class="col-md-9 tab-content tab-content-in">
<div class="tab-pane <?php if($this->input->get('do')==null) echo 'active'; ?> text-style" id="tab1">
  <div class="inbox-right">
         	
            <div class="mailbox-content">
               <div class="mail-toolbar clearfix">
			     <div class="float-left">
			       <div class="btn-group m-r-sm mail-hidden-options" style="display: inline-block;">
						<div class="btn-group">
							<a href="<?php echo site_url('admins/gallery?do=add'); ?>" class="btn btn-default dropdown-toggle"><i class="fa fa-plus-square"></i> Add New Album</a>
						</div>
						
					</div>
			    </div>
			    <div class="float-right">
			    </div>
               </div>
                <table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>Album</th>
							<th>Action</th>
						</tr>
					</thead>
                    <tbody>
						<?php
						$i=1;
						foreach($listalbum->result() as $dt){
						?>
                        <tr class="table-row">
							<td class="table-text">
                               <?php echo $i; ?>
                            </td>
                            <td>
								<a target="_blank" href="<?php echo site_url('galeri/'.$dt->id_album); ?>"><?php echo $dt->nama_album; ?></a>
								( <?php echo $dt->jml; ?> foto )
							</td>
                            <td >
								<a onclick="return confirm('Are you sure? All photos in this album will delete automatically.'); " href="<?php echo site_url('admins/delete_album_proses/'.$dt->id_album); ?>" class="btn btn-danger btn-xs">
									<i class="fa fa-trash"></i> Delete
								</a>
								<a href="<?php echo site_url('admins/gallery?do=add_image&album='.$dt->id_album); ?>" class="btn btn-primary btn-xs">
									<i class="fa fa-plus-square"></i> Add Image
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
<div class="tab-pane <?php if($this->input->get('do')=='add') echo 'active'; ?> text-style" id="tab2">
	<div class="inbox-right">
		<div class="mailbox-content">
			<?php
			$url_proses=site_url('admins/add_album_proses');
			?>
			<form action="<?php echo $url_proses; ?>" method="POST" enctype="multipart/form-data">
				<div class="col-md-12 form-group1 group-mail">
				  <label class="control-label">Nama Album</label>
				  <input name="nama_album" type="text" placeholder="" required="">
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
<div class="tab-pane <?php if($this->input->get('do')=='add_image') echo 'active'; ?> text-style" id="tab3">
	<div class="inbox-right">
		<div class="mailbox-content">
			<?php
			$url_proses=site_url('admins/add_image_proses');
			?>
			<form action="<?php echo $url_proses; ?>" method="POST" enctype="multipart/form-data">
				<div class="col-md-12 form-group1 group-mail">
				  <label class="control-label">Foto</label>
				  <input name="file" type="file" placeholder="" required="">
				</div>
				<div class="col-md-12 form-group1 group-mail">
				  <input name="id_album" type="hidden" placeholder="" value="<?php echo $this->input->get('album'); ?>" required="">
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
		</div>
		<div class="clearfix"> </div>
		   </div>
		</div>

 	<!--//grid-->