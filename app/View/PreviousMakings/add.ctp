<div class="previousMakings form">
<?php echo $this->Form->create('PreviousMaking'); ?>
	<fieldset>
		<legend><?php echo __('Add Previous Making'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('image');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Previous Makings'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
