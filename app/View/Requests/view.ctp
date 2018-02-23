<div class="requests view">
<h2><?php echo __('Request'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($request['Request']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($request['User']['id'], array('controller' => 'users', 'action' => 'view', $request['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Maker'); ?></dt>
		<dd>
			<?php echo h($request['Request']['maker']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Request Comment'); ?></dt>
		<dd>
			<?php echo h($request['Request']['request_comment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sent Date'); ?></dt>
		<dd>
			<?php echo h($request['Request']['sent_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Active'); ?></dt>
		<dd>
			<?php echo h($request['Request']['is_active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Confirmed'); ?></dt>
		<dd>
			<?php echo h($request['Request']['is_confirmed']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payment Amount'); ?></dt>
		<dd>
			<?php echo h($request['Request']['payment_amount']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('TransactionId'); ?></dt>
		<dd>
			<?php echo h($request['Request']['transactionId']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Paid'); ?></dt>
		<dd>
			<?php echo h($request['Request']['is_paid']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Request'), array('action' => 'edit', $request['Request']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Request'), array('action' => 'delete', $request['Request']['id']), array(), __('Are you sure you want to delete # %s?', $request['Request']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Requests'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Request'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
