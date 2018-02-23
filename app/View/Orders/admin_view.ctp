<div class="shippingAddresses view">
<h2><?php echo __('Shipping Address'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($shippingAddress['ShippingAddress']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($shippingAddress['User']['id'], array('controller' => 'users', 'action' => 'view', $shippingAddress['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Full Name'); ?></dt>
		<dd>
			<?php echo h($shippingAddress['ShippingAddress']['full_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Street'); ?></dt>
		<dd>
			<?php echo h($shippingAddress['ShippingAddress']['street']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Apartment'); ?></dt>
		<dd>
			<?php echo h($shippingAddress['ShippingAddress']['apartment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($shippingAddress['ShippingAddress']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php echo h($shippingAddress['ShippingAddress']['state']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Zip Code'); ?></dt>
		<dd>
			<?php echo h($shippingAddress['ShippingAddress']['zip_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Country'); ?></dt>
		<dd>
			<?php echo h($shippingAddress['ShippingAddress']['country']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Shipping Address'), array('action' => 'edit', $shippingAddress['ShippingAddress']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Shipping Address'), array('action' => 'delete', $shippingAddress['ShippingAddress']['id']), null, __('Are you sure you want to delete # %s?', $shippingAddress['ShippingAddress']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Shipping Addresses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Shipping Address'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
