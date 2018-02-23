<?php ?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">Vendor Request</div>
				
			</div>
			<div class="block-content collapse in">
				<div class="span12">
					<table class="table table-hover">
					<thead>
					<tr>
						<th>&nbsp;</th>
						<th><?php echo $this->Paginator->sort('id'); ?></th>
						<th><?php echo $this->Paginator->sort('name'); ?></th>
                                                <th><?php echo $this->Paginator->sort('email'); ?></th>
						
						
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					</thead>
                                        
					<tbody>
					<?php  foreach ($vendorrequests as $ad): ?>
					<tr>
                                        <td>&nbsp;</td>
                                        <td><?php echo h($ad['VendorRequest']['id']); ?>&nbsp;</td>

                                        <td><?php echo h($ad['User']['name']); ?>&nbsp;</td>
                                        <td><?php echo h($ad['User']['email']); ?>&nbsp;</td>
                                        
                                    
						

						
                                    <td class="actions">
				<?php if($ad['VendorRequest']['status']=='pending'){?>		    

<a href="<?php echo $this->webroot;?>admin/users/vendor_request_edit/<?php echo $ad['VendorRequest']['user_id'];?>"><img src="<?php echo $this->webroot;?>img/edit.png" title="Edit" width="22" height="21"></a>
                                <?php }else{ ?>
                                    
<p style="color: green"><i>Approved</i></p>

                                <?php } ?>

<!--							<a href="<?php echo $this->webroot;?>admin/users/middle_delete/<?php echo $ad['Middle']['id'];?>" onclick="return confirm('Are you sure to delete this section?')"><img src="<?php echo $this->webroot;?>img/delete.png" title="Delete" width="24" height="24"></a>-->
							
				   </td>
					</tr>
					<?php endforeach; ?>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /block -->
		<p>
		<?php
		echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
		));
		?>	</p>
		<div class="paging">
		<?php
			echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
		?>
		</div>
	</div>
</div>

<style>
.actions a
{
 background:none;
 border:none;
 border-radius:0px;
 box-shadow:none;
 padding:0px;
}
</style>
