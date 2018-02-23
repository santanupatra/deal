<div class="orders index">
	<h2><?php echo __('Orders'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('total_amount'); ?></th>
			<th><?php echo $this->Paginator->sort('order_date'); ?></th>
			<th><?php echo $this->Paginator->sort('transaction_id'); ?></th>
			<th><?php echo $this->Paginator->sort('payment_date'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($orders as $order): ?>
	<tr>
		<td><?php echo h($order['Order']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($order['User']['first_name'].' '.$order['User']['last_name'], array('controller' => 'users', 'action' => 'view', $order['User']['id'])); ?>
		</td>
		<td>$&nbsp;<?php echo h($order['Order']['total_amount']); ?>&nbsp;</td>
		<td><?php echo h(date('d M, Y',strtotime($order['Order']['order_date']))); ?>&nbsp;</td>
		<td><?php echo h($order['Order']['transaction_id']); ?>&nbsp;</td>
		<td><?php echo h(date('d M, Y',strtotime($order['Order']['payment_date']))); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Order Details'), array('controller' => 'order_details','action' => 'index', $order['Order']['id'])); ?>
			<?php
			if($order['Order']['admin_paid']==0)
			{
			?>
			<?php echo $this->Html->link(__('Make Payments'), array('controller' => 'orders','action' => 'paynow', $order['Order']['id'])); ?>
			<?php
			}
			else
			{
			?>
			<?php echo $this->Html->link(__('Payment Details'), array('controller' => 'partnership_details','action' => 'index', $order['Order']['id'])); ?>
			<?php
			}
			?>
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
<?php echo $this->element('admin_sidebar'); ?>