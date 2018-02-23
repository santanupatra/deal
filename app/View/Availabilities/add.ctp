<div class="availabilities form">
<?php echo $this->Form->create('Availability'); ?>
	<fieldset>
		<legend><?php echo __('Add Availability'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('any_time_email');
		echo $this->Form->input('has_fixed_routine');
		echo $this->Form->input('monday_from');
		echo $this->Form->input('monday_to');
		echo $this->Form->input('monday_any_time');
		echo $this->Form->input('tuesday_from');
		echo $this->Form->input('tuesday_to');
		echo $this->Form->input('tuesday_any_time');
		echo $this->Form->input('wednesday_from');
		echo $this->Form->input('wednesday_to');
		echo $this->Form->input('wednesday_any_time');
		echo $this->Form->input('thursday_from');
		echo $this->Form->input('thursday_to');
		echo $this->Form->input('thursday_any_time');
		echo $this->Form->input('friday_from');
		echo $this->Form->input('friday_to');
		echo $this->Form->input('friday_any_time');
		echo $this->Form->input('saturday_from');
		echo $this->Form->input('saturday_to');
		echo $this->Form->input('saturday_any_time');
		echo $this->Form->input('sunday_from');
		echo $this->Form->input('sunday_to');
		echo $this->Form->input('sunday_any_time');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Availabilities'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
