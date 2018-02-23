<div class="previousMakings view">
<h2><?php echo __('Previous Making'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($previousMaking['PreviousMaking']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($previousMaking['User']['id'], array('controller' => 'users', 'action' => 'view', $previousMaking['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image'); ?></dt>
		<dd>
			<?php echo h($previousMaking['PreviousMaking']['image']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($previousMaking['PreviousMaking']['description']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Previous Making'), array('action' => 'edit', $previousMaking['PreviousMaking']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Previous Making'), array('action' => 'delete', $previousMaking['PreviousMaking']['id']), array(), __('Are you sure you want to delete # %s?', $previousMaking['PreviousMaking']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Previous Makings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Previous Making'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
