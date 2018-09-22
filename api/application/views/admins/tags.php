
<div id="page-wrapper" class="gray-bg dashbard-1">
    <div class="content-main">
		<!--banner-->	
	    <div class="banner">
			<h2>
			<a href="<?php echo site_url('admins'); ?>">Home</a>
			<i class="fa fa-angle-right"></i>
			<span>Tags</span>
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
            <h2>TAGS</h2>
    <nav class="nav-sidebar">
		<ul class="nav tabs">
          <li <?php if($this->input->get('do')==null) echo 'class="active"'; ?>><a href="#tab1" data-toggle="tab"><i class="fa fa-list"></i>TAGS<div class="clearfix"></div></a></li>
          <li <?php if($this->input->get('do')=='add') echo 'class="active"'; ?>><a href="#tab2" data-toggle="tab"><i class="fa fa-plus-square"></i>Add New Tag</a></li>
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
							<a href="<?php echo site_url('admins/tags?do=add'); ?>" class="btn btn-default dropdown-toggle"><i class="fa fa-plus-square"></i> Add New Tag</a>
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
							<th>Tag</th>
							<th>Action</th>
						</tr>
					</thead>
                    <tbody>
						<?php
						$i=1;
						foreach($listkategori->result() as $dt){
						?>
                        <tr class="table-row">
							<td class="table-text">
                               <?php echo $i; ?>
                            </td>
                            <td><?php echo $dt->nama_kategori; ?></td>
                            <td >
								<a href="#" class="btn btn-danger btn-xs">
									<i class="fa fa-trash"></i> Delete
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
			$url_proses=site_url('admins/add_kategori_proses');
			?>
			<form action="<?php echo $url_proses; ?>" method="POST" enctype="multipart/form-data">
				<div class="col-md-12 form-group1 group-mail">
				  <label class="control-label">Tag</label>
				  <input name="nama_kategori" type="text" placeholder="" required="">
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