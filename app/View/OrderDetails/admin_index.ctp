<div class="orderdetails index">
	<h2><?php echo __('Order Details'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('order_id','Order Id'); ?></th>
			<th><?php echo $this->Paginator->sort('list_id', 'Listing'); ?></th>
			<th><?php echo $this->Paginator->sort('shop_id'); ?></th>
			<th><?php echo $this->Paginator->sort('owner_id'); ?></th>
			<th><?php echo $this->Paginator->sort('price'); ?></th>
			<th><?php echo $this->Paginator->sort('quantity'); ?></th>
			<th><?php echo $this->Paginator->sort('shipping_cost'); ?></th>
			<th><?php echo $this->Paginator->sort('amount'); ?></th>
			<th><?php echo $this->Paginator->sort('order_status'); ?></th>
			<th><?php echo $this->Paginator->sort('delivery_date'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($orderdetails as $orderdetail): ?>
	<tr>
		<td><?php echo h($orderdetail['OrderDetail']['id']); ?>&nbsp;</td>
		<td><?php echo h($orderdetail['OrderDetail']['order_id']); ?></td>
		<td><?php echo (wordwrap($orderdetail['Listing']['item_tittle'],12,'<br/>',true)); ?>&nbsp;</td>
		<td><?php echo h($orderdetail['Shop']['shop_name']); ?>&nbsp;</td>
		<td><?php echo h($orderdetail['User']['first_name'].' '.$orderdetail['User']['last_name']); ?>&nbsp;</td>
		<td>$&nbsp;<?php echo h($orderdetail['OrderDetail']['price']); ?>&nbsp;</td>
		<td><?php echo h($orderdetail['OrderDetail']['quantity']); ?>&nbsp;</td>
		<td>$&nbsp;<?php echo h($orderdetail['OrderDetail']['shipping_cost']); ?>&nbsp;</td>
		<td>$&nbsp;<?php echo h($orderdetail['OrderDetail']['amount']); ?>&nbsp;</td>
		<td><?php echo h($orderdetail['OrderDetail']['order_status']=='U'?'Undelivered':($orderdetail['OrderDetail']['order_status']=='C'?'Cancelled':'Delivered')); ?>&nbsp;</td>
		<td><?php echo h($orderdetail['OrderDetail']['delivery_date']=='0000-00-00'?'':date('d M, Y',strtotime($orderdetail['OrderDetail']['delivery_date']))); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Back To Orders'), array('controller' => 'orders', 'action' => 'index', $orderdetail['Order']['id'])); ?>
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