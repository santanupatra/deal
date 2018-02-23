<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Orders'); ?></div>
				<div style="float:right;"></div>
			</div>
			<div class="block-content collapse in">
				<div class="span12">
					<table class="table table-hover">
					<thead>
					<tr>
						<th>#<?php echo $this->Paginator->sort('id'); ?></th>
						<th>Name</th>
						<th>Maker</th>
						<th>User</th>
						<th>Order Date</th>
						<th>Status</th>
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php 
					if(!empty($requests)){
					foreach ($requests as $request): ?>
					<tr>
							<td><?php echo h($request['Request']['id']); ?>&nbsp;</td>

							<td><?php echo h($request['Skill']['skill_name']); ?>&nbsp;</td>

							<td><a href="<?php echo $this->webroot;?>admin/users/user_view/<?php echo h($request['Request']['maker']); ?>"><?php echo h($request['Skill']['User']['first_name'].' '.$request['Skill']['User']['last_name']); ?></a>&nbsp;</td>

							<td><a href="<?php echo $this->webroot;?>admin/users/user_view/<?php echo h($request['Request']['user_id']); ?>"><?php echo h($request['User']['first_name'].' '.$request['User']['last_name']); ?></a>&nbsp;</td>

							<td><?php echo date('M d, Y',strtotime($request['Request']['sent_date'])); ?>&nbsp;</td>

							<td><?php if(isset($request['Request']['is_paid']) && $request['Request']['is_paid']==1){echo 'Paid';}else{echo 'Not Paid';} ?>&nbsp;</td>

							<td class="actions">
							 <a href="<?php echo $this->webroot;?>admin/requests/view/<?php echo $request['Request']['id'];?>"><img src="<?php echo $this->webroot;?>img/view.png" title="View Order"></a>
							</td>
					</tr>
	                <?php endforeach;}else{ ?>
					  <tr>
					   <td colspan='7'>
					    No order found.
					   </td>
					  </tr>
					<?php } ?>
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