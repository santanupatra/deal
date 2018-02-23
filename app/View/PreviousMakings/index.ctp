<div class="previousMakings index">
	<h2><?php echo __('Previous Makings'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('image'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($previousMakings as $previousMaking): ?>
	<tr>
		<td><?php echo h($previousMaking['PreviousMaking']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($previousMaking['User']['id'], array('controller' => 'users', 'action' => 'view', $previousMaking['User']['id'])); ?>
		</td>
		<td><?php echo h($previousMaking['PreviousMaking']['image']); ?>&nbsp;</td>
		<td><?php echo h($previousMaking['PreviousMaking']['description']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $previousMaking['PreviousMaking']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $previousMaking['PreviousMaking']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $previousMaking['PreviousMaking']['id']), array(), __('Are you sure you want to delete # %s?', $previousMaking['PreviousMaking']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Previous Making'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
