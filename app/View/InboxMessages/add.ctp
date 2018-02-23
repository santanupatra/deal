<div class="inboxMessages form">
<?php echo $this->Form->create('InboxMessage'); ?>
	<fieldset>
		<legend><?php echo __('Add Inbox Message'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('sender');
		echo $this->Form->input('subject');
		echo $this->Form->input('message');
		echo $this->Form->input('date_time');
		echo $this->Form->input('read');
		echo $this->Form->input('trash');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Inbox Messages'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
