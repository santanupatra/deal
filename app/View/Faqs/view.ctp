<div class="emailTemplates view">
<h2><?php echo __('Email Template'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($emailTemplate['EmailTemplate']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Subject'); ?></dt>
		<dd>
			<?php echo h($emailTemplate['EmailTemplate']['subject']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Content'); ?></dt>
		<dd>
			<?php echo h($emailTemplate['EmailTemplate']['content']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd>
			<?php echo h($emailTemplate['EmailTemplate']['active']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Email Template'), array('action' => 'edit', $emailTemplate['EmailTemplate']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Email Template'), array('action' => 'delete', $emailTemplate['EmailTemplate']['id']), null, __('Are you sure you want to delete # %s?', $emailTemplate['EmailTemplate']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Email Templates'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Email Template'), array('action' => 'add')); ?> </li>
	</ul>
</div>
