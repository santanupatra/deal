<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Packages Request List'); ?></div>
				<!--<div style="float:right;">
				<a href="<?php echo($this->webroot)?>admin/packages/add">Add Package</a></div>-->
			</div>
			<div class="block-content collapse in">
				<div class="span12">
					<table class="table table-hover">
					<thead>
					<tr>
                                            <th>&nbsp;</th>
                                            <th><?php echo $this->Paginator->sort('id'); ?></th>
                                            <th><?php echo $this->Paginator->sort('customer name'); ?></th>
                                            <th><?php echo $this->Paginator->sort('Email'); ?></th>
                                            <th><?php echo $this->Paginator->sort('package name'); ?></th>
                                            
                                            <th><?php echo $this->Paginator->sort('price'); ?></th>
                                            <th><?php echo $this->Paginator->sort('Order date'); ?></th>
                                            <th><?php echo $this->Paginator->sort('status'); ?></th>
                                            <th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($request_list as $p_list): ?>
					<tr>
                                            <td>&nbsp;</td>
                                            <td><?php echo h($p_list['PackageRequest']['id']); ?>&nbsp;</td>
                                            <td><?php echo h($p_list['User']['first_name'].' '.$p_list['User']['last_name']); ?>&nbsp;</td>
                                            <td><?php echo h($p_list['User']['email']); ?>&nbsp;</td>
                                            <td><?php echo h($p_list['Package']['name']); ?>&nbsp;</td>
                                            <td>$<?php echo h($p_list['Package']['price']); ?>&nbsp;</td>
                                            <td><?php echo h($p_list['PackageRequest']['request_date']); ?>&nbsp;</td>
                                            <td><?php if(isset($p_list['PackageRequest']['status']) && $p_list['PackageRequest']['status']==1){echo 'Processed';}else{echo 'Pending';} ?>&nbsp;</td>
                                            <td class="actions">
                                               <?php if($p_list['PackageRequest']['status']==0){ ?>
                                                <a href="<?php echo $this->webroot;?>admin/packages/request_edit/<?php echo base64_encode($p_list['PackageRequest']['id']);?>" onclick="return confirm('Are you sure to process this request?')" class="btn btn-primary">Process</a>
                                               <?php }else{ ?>
                                                
                                                <button disabled="">Completed</button> 
                                               <?php } ?>
                                                
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
