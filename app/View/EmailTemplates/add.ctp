<div class="emailTemplates form">
<?php echo $this->Form->create('EmailTemplate'); ?>
	<fieldset>
		<legend><?php echo __('Add Email Template'); ?></legend>
	<?php
		echo $this->Form->input('subject');
		echo $this->Form->input('content');
		echo $this->Form->input('active');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Email Templates'), array('action' => 'index')); ?></li>
	</ul>
</div>
