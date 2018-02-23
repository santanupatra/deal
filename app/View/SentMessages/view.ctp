<div class="sentMessages view">
<h2><?php echo __('Sent Message'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($sentMessage['SentMessage']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($sentMessage['User']['id'], array('controller' => 'users', 'action' => 'view', $sentMessage['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Receiver'); ?></dt>
		<dd>
			<?php echo h($sentMessage['SentMessage']['receiver']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Subject'); ?></dt>
		<dd>
			<?php echo h($sentMessage['SentMessage']['subject']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Message'); ?></dt>
		<dd>
			<?php echo h($sentMessage['SentMessage']['message']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Time'); ?></dt>
		<dd>
			<?php echo h($sentMessage['SentMessage']['date_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trash'); ?></dt>
		<dd>
			<?php echo h($sentMessage['SentMessage']['trash']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Sent Message'), array('action' => 'edit', $sentMessage['SentMessage']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Sent Message'), array('action' => 'delete', $sentMessage['SentMessage']['id']), array(), __('Are you sure you want to delete # %s?', $sentMessage['SentMessage']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sent Messages'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sent Message'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
