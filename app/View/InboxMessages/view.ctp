<div class="inboxMessages view">
<h2><?php echo __('Inbox Message'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($inboxMessage['InboxMessage']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($inboxMessage['User']['id'], array('controller' => 'users', 'action' => 'view', $inboxMessage['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sender'); ?></dt>
		<dd>
			<?php echo h($inboxMessage['InboxMessage']['sender']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Subject'); ?></dt>
		<dd>
			<?php echo h($inboxMessage['InboxMessage']['subject']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Message'); ?></dt>
		<dd>
			<?php echo h($inboxMessage['InboxMessage']['message']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Time'); ?></dt>
		<dd>
			<?php echo h($inboxMessage['InboxMessage']['date_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Read'); ?></dt>
		<dd>
			<?php echo h($inboxMessage['InboxMessage']['read']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Trash'); ?></dt>
		<dd>
			<?php echo h($inboxMessage['InboxMessage']['trash']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Inbox Message'), array('action' => 'edit', $inboxMessage['InboxMessage']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Inbox Message'), array('action' => 'delete', $inboxMessage['InboxMessage']['id']), array(), __('Are you sure you want to delete # %s?', $inboxMessage['InboxMessage']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Inbox Messages'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inbox Message'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
