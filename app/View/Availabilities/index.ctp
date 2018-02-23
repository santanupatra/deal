<div class="availabilities index">
	<h2><?php echo __('Availabilities'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('any_time_email'); ?></th>
			<th><?php echo $this->Paginator->sort('has_fixed_routine'); ?></th>
			<th><?php echo $this->Paginator->sort('monday_from'); ?></th>
			<th><?php echo $this->Paginator->sort('monday_to'); ?></th>
			<th><?php echo $this->Paginator->sort('monday_any_time'); ?></th>
			<th><?php echo $this->Paginator->sort('tuesday_from'); ?></th>
			<th><?php echo $this->Paginator->sort('tuesday_to'); ?></th>
			<th><?php echo $this->Paginator->sort('tuesday_any_time'); ?></th>
			<th><?php echo $this->Paginator->sort('wednesday_from'); ?></th>
			<th><?php echo $this->Paginator->sort('wednesday_to'); ?></th>
			<th><?php echo $this->Paginator->sort('wednesday_any_time'); ?></th>
			<th><?php echo $this->Paginator->sort('thursday_from'); ?></th>
			<th><?php echo $this->Paginator->sort('thursday_to'); ?></th>
			<th><?php echo $this->Paginator->sort('thursday_any_time'); ?></th>
			<th><?php echo $this->Paginator->sort('friday_from'); ?></th>
			<th><?php echo $this->Paginator->sort('friday_to'); ?></th>
			<th><?php echo $this->Paginator->sort('friday_any_time'); ?></th>
			<th><?php echo $this->Paginator->sort('saturday_from'); ?></th>
			<th><?php echo $this->Paginator->sort('saturday_to'); ?></th>
			<th><?php echo $this->Paginator->sort('saturday_any_time'); ?></th>
			<th><?php echo $this->Paginator->sort('sunday_from'); ?></th>
			<th><?php echo $this->Paginator->sort('sunday_to'); ?></th>
			<th><?php echo $this->Paginator->sort('sunday_any_time'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($availabilities as $availability): ?>
	<tr>
		<td><?php echo h($availability['Availability']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($availability['User']['id'], array('controller' => 'users', 'action' => 'view', $availability['User']['id'])); ?>
		</td>
		<td><?php echo h($availability['Availability']['any_time_email']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['has_fixed_routine']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['monday_from']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['monday_to']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['monday_any_time']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['tuesday_from']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['tuesday_to']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['tuesday_any_time']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['wednesday_from']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['wednesday_to']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['wednesday_any_time']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['thursday_from']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['thursday_to']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['thursday_any_time']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['friday_from']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['friday_to']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['friday_any_time']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['saturday_from']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['saturday_to']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['saturday_any_time']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['sunday_from']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['sunday_to']); ?>&nbsp;</td>
		<td><?php echo h($availability['Availability']['sunday_any_time']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $availability['Availability']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $availability['Availability']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $availability['Availability']['id']), array(), __('Are you sure you want to delete # %s?', $availability['Availability']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Availability'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
