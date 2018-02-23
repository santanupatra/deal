<div class="inboxMessages index">
	<h2><?php echo __('Inbox Messages'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('sender'); ?></th>
			<th><?php echo $this->Paginator->sort('subject'); ?></th>
			<th><?php echo $this->Paginator->sort('message'); ?></th>
			<th><?php echo $this->Paginator->sort('date_time'); ?></th>
			<th><?php echo $this->Paginator->sort('read'); ?></th>
			<th><?php echo $this->Paginator->sort('trash'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($inboxMessages as $inboxMessage): ?>
	<tr>
		<td><?php echo h($inboxMessage['InboxMessage']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($inboxMessage['User']['id'], array('controller' => 'users', 'action' => 'view', $inboxMessage['User']['id'])); ?>
		</td>
		<td><?php echo h($inboxMessage['InboxMessage']['sender']); ?>&nbsp;</td>
		<td><?php echo h($inboxMessage['InboxMessage']['subject']); ?>&nbsp;</td>
		<td><?php echo h($inboxMessage['InboxMessage']['message']); ?>&nbsp;</td>
		<td><?php echo h($inboxMessage['InboxMessage']['date_time']); ?>&nbsp;</td>
		<td><?php echo h($inboxMessage['InboxMessage']['read']); ?>&nbsp;</td>
		<td><?php echo h($inboxMessage['InboxMessage']['trash']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $inboxMessage['InboxMessage']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $inboxMessage['InboxMessage']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $inboxMessage['InboxMessage']['id']), array(), __('Are you sure you want to delete # %s?', $inboxMessage['InboxMessage']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Inbox Message'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
