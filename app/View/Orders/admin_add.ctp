<div class="shippingAddresses form">
<?php echo $this->Form->create('ShippingAddress'); ?>
	<fieldset>
		<legend><?php echo __('Add Shipping Address'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('full_name');
		echo $this->Form->input('street');
		echo $this->Form->input('apartment');
		echo $this->Form->input('city');
		echo $this->Form->input('state');
		echo $this->Form->input('zip_code');
		echo $this->Form->input('country');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Shipping Addresses'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
