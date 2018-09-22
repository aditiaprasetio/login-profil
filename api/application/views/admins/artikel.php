
<div id="page-wrapper" class="gray-bg dashbard-1">
<div class="content-main">
	<!--banner-->	
	<div class="banner">
			<h2>
			<a href="<?php echo site_url('admins'); ?>">Home</a>
			<i class="fa fa-angle-right"></i>
			<span>Articles</span>
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
               <div class="mail-toolbar clearfix">
			     <div class="float-left">
			       <div class="btn-group m-r-sm mail-hidden-options" style="display: inline-block;">
						<div class="btn-group">
							<a href="<?php echo site_url('artikel/add'); ?>" class="btn btn-default dropdown-toggle"><i class="fa fa-plus-square"></i> Add New Article</a>
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
							<th>Picture</th>
							<th>Title</th>
							<th>Tags</th>
							<th>Last Update</th>
							<th>Hits</th>
							<th>Action</th>
						</tr>
					</thead>
                    <tbody>
						<?php
						$i=1;
						foreach($listartikel->result() as $dt){
							if($dt->publish==5) continue;
							$kategori=$this->MArtikel->getKategoriById($dt->id_artikel);
						?>
                        <tr class="table-row">
							<td class="table-text">
                               <?php echo $i; ?>
                            </td>
                            <td class="table-img">
                               <img class="img-responsive" style="height:50px" src="<?php echo base_url('assets/general/images/preview/'.$dt->preview); ?>" alt="" />
                            </td>
                            <td class="table-text">
                            	<a target="_blank" href="<?php echo site_url('post/'.$dt->slug); ?>"><h6><?php echo $dt->judul; ?></h6></a>
                                <p><?php echo $dt->isiartikel; ?></p>
								<?php
								if($dt->publish==0) echo '<span class="label label-danger">unpublished</span>';
								elseif($dt->publish==1) echo '<span class="label label-success">published</span>';
								?>
                            </td>
                            <td>
								<?php
								foreach($kategori->result() as $dt1){
									echo '<span class="label label-warning">'.$dt1->nama_kategori.'</span> ';
								}
								?>
                            	
                            </td>
                            <td class="march">
                               <?php echo $dt->lastUpdate; ?>
                            </td>
                            <td >
								<i class="fa fa-eye icon-state-warning"></i> <?php echo $dt->hit; ?>
                            </td>
                            <td >
								<a href="<?php echo site_url('artikel/edit/'.$dt->slug); ?>" class="btn btn-info btn-xs">
									<i class="fa fa-pencil"></i> Edit
								</a>
								<a href="<?php echo site_url('artikel/delete_artikel_proses/'.$dt->id_artikel); ?>" class="btn btn-danger btn-xs">
									<i class="fa fa-trash"></i> Delete
								</a>
								
								<?php
								if($dt->publish==0) echo '<a href="'.site_url('artikel/publish_proses/'.$dt->id_artikel).'" class="btn btn-warning btn-xs"><i class="fa fa-check"></i> Publish</a>';
								elseif($dt->publish==1) echo '<a href="'.site_url('artikel/unpublish_proses/'.$dt->id_artikel).'" class="btn btn-warning btn-xs"><i class="fa fa-close"></i> Unpublish';
								?>
								
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
		<div class="clearfix"> </div>
	</div>
</div>

 	<!--//grid-->