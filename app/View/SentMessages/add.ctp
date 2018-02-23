<div class="sentMessages form">
<?php echo $this->Form->create('SentMessage'); ?>
	<fieldset>
		<legend><?php echo __('Add Sent Message'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('receiver');
		echo $this->Form->input('subject');
		echo $this->Form->input('message');
		echo $this->Form->input('date_time');
		echo $this->Form->input('trash');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Sent Messages'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
