
<div id="page-wrapper" class="gray-bg dashbard-1">
<div class="content-main">
	<!--banner-->	
	<div class="banner">
			<h2>
			<a href="<?php echo site_url('admins'); ?>">Home</a>
			<i class="fa fa-angle-right"></i>
			<span>Feedback</span>
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
                <table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>Pengirim</th>
							<th>Feedback</th>
							<th>Timestamp</th>
						</tr>
					</thead>
                    <tbody>
						<?php
						$i=1;
						foreach($listfeedback->result() as $dt){
						?>
                        <tr class="table-row">
							<td class="table-text">
                               <?php echo $i; ?>
                            </td>
                            <td class="table-text">
                            	<?php echo $dt->full_name; ?>
                            </td>
                            <td class="march">
                               <?php echo $dt->feedback; ?>
                            </td>
                            <td class="march">
                               <?php echo $dt->createDate; ?>
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