<div class="shippingAddresses index">
	<h2><?php echo __('Shipping Addresses'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('full_name'); ?></th>
			<th><?php echo $this->Paginator->sort('street'); ?></th>
			<th><?php echo $this->Paginator->sort('apartment'); ?></th>
			<th><?php echo $this->Paginator->sort('city'); ?></th>
			<th><?php echo $this->Paginator->sort('state'); ?></th>
			<th><?php echo $this->Paginator->sort('zip_code'); ?></th>
			<th><?php echo $this->Paginator->sort('country'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($shippingAddresses as $shippingAddress): ?>
	<tr>
		<td><?php echo h($shippingAddress['ShippingAddress']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($shippingAddress['User']['id'], array('controller' => 'users', 'action' => 'view', $shippingAddress['User']['id'])); ?>
		</td>
		<td><?php echo h($shippingAddress['ShippingAddress']['full_name']); ?>&nbsp;</td>
		<td><?php echo h($shippingAddress['ShippingAddress']['street']); ?>&nbsp;</td>
		<td><?php echo h($shippingAddress['ShippingAddress']['apartment']); ?>&nbsp;</td>
		<td><?php echo h($shippingAddress['ShippingAddress']['city']); ?>&nbsp;</td>
		<td><?php echo h($shippingAddress['ShippingAddress']['state']); ?>&nbsp;</td>
		<td><?php echo h($shippingAddress['ShippingAddress']['zip_code']); ?>&nbsp;</td>
		<td><?php echo h($shippingAddress['ShippingAddress']['country']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $shippingAddress['ShippingAddress']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $shippingAddress['ShippingAddress']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $shippingAddress['ShippingAddress']['id']), null, __('Are you sure you want to delete # %s?', $shippingAddress['ShippingAddress']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
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
		<li><?php echo $this->Html->link(__('New Shipping Address'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
