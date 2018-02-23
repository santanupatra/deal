<div class="siteSettings form">
<?php echo $this->Form->create('SiteSetting'); ?>
	<fieldset>
		<legend><?php echo __('Add Site Setting'); ?></legend>
	<?php
		echo $this->Form->input('admin_email');
		echo $this->Form->input('site_logo');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Site Settings'), array('action' => 'index')); ?></li>
	</ul>
</div>
