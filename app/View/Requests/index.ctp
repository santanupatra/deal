<div class="requests index">
	<h2><?php echo __('Requests'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('maker'); ?></th>
			<th><?php echo $this->Paginator->sort('request_comment'); ?></th>
			<th><?php echo $this->Paginator->sort('sent_date'); ?></th>
			<th><?php echo $this->Paginator->sort('is_active'); ?></th>
			<th><?php echo $this->Paginator->sort('is_confirmed'); ?></th>
			<th><?php echo $this->Paginator->sort('payment_amount'); ?></th>
			<th><?php echo $this->Paginator->sort('transactionId'); ?></th>
			<th><?php echo $this->Paginator->sort('is_paid'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($requests as $request): ?>
	<tr>
		<td><?php echo h($request['Request']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($request['User']['id'], array('controller' => 'users', 'action' => 'view', $request['User']['id'])); ?>
		</td>
		<td><?php echo h($request['Request']['maker']); ?>&nbsp;</td>
		<td><?php echo h($request['Request']['request_comment']); ?>&nbsp;</td>
		<td><?php echo h($request['Request']['sent_date']); ?>&nbsp;</td>
		<td><?php echo h($request['Request']['is_active']); ?>&nbsp;</td>
		<td><?php echo h($request['Request']['is_confirmed']); ?>&nbsp;</td>
		<td><?php echo h($request['Request']['payment_amount']); ?>&nbsp;</td>
		<td><?php echo h($request['Request']['transactionId']); ?>&nbsp;</td>
		<td><?php echo h($request['Request']['is_paid']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $request['Request']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $request['Request']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $request['Request']['id']), array(), __('Are you sure you want to delete # %s?', $request['Request']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
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
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Request'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
