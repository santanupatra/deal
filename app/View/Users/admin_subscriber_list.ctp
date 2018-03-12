<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('User'); ?></div>
				<div style="float:right;">
				<!--<a href="<?php echo($this->webroot)?>admin/users/user_add">Add New User</a>-->
                                </div>
			</div>
			<div class="block-content collapse in">
				<div class="span12">
					<table class="table table-hover">
					<thead>
					<tr>
						<th>&nbsp;</th>
						<th><?php echo $this->Paginator->sort('id'); ?></th>
						<th><?php echo $this->Paginator->sort('email'); ?></th>
						<th><?php echo $this->Paginator->sort('subscription_date'); ?></th>
						<th><?php echo $this->Paginator->sort('is_active'); ?></th>
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($users as $user): ?>
					<tr>
						<td>&nbsp;</td>
						<td><?php echo h($user['EmailSubscriber']['id']); ?>&nbsp;</td>
						
						<td><?php echo h($user['EmailSubscriber']['email_id']); ?>&nbsp;</td>
						
						<td><?php echo h(date('d M, Y',strtotime($user['EmailSubscriber']['date']))); ?>&nbsp;</td>

						
						<td><?php if(isset($user['EmailSubscriber']['status']) && $user['EmailSubscriber']['status']==1){echo 'Yes';}else{echo 'No';} ?>&nbsp;</td>
						<td class="actions">
						    

							

							<a href="<?php echo $this->webroot;?>admin/users/subscriber_delete/<?php echo $user['EmailSubscriber']['id'];?>" onclick="return confirm('Are you sure to delete this subscriber?')"><img src="<?php echo $this->webroot;?>img/delete.png" title="Delete Profile" width="24" height="24"></a>
							
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
