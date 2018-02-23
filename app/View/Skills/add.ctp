<div class="skills form">
<?php echo $this->Form->create('Skill'); ?>
	<fieldset>
		<legend><?php echo __('Add Skill'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('skill_name');
		echo $this->Form->input('skill_details');
		echo $this->Form->input('is_active');
		echo $this->Form->input('skill_workshop_address');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Skills'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Skill Images'), array('controller' => 'skill_images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Skill Image'), array('controller' => 'skill_images', 'action' => 'add')); ?> </li>
	</ul>
</div>
