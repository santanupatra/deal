<div class="availabilities view">
<h2><?php echo __('Availability'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($availability['User']['id'], array('controller' => 'users', 'action' => 'view', $availability['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Any Time Email'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['any_time_email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Has Fixed Routine'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['has_fixed_routine']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Monday From'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['monday_from']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Monday To'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['monday_to']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Monday Any Time'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['monday_any_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tuesday From'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['tuesday_from']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tuesday To'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['tuesday_to']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tuesday Any Time'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['tuesday_any_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Wednesday From'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['wednesday_from']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Wednesday To'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['wednesday_to']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Wednesday Any Time'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['wednesday_any_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Thursday From'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['thursday_from']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Thursday To'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['thursday_to']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Thursday Any Time'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['thursday_any_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Friday From'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['friday_from']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Friday To'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['friday_to']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Friday Any Time'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['friday_any_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Saturday From'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['saturday_from']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Saturday To'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['saturday_to']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Saturday Any Time'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['saturday_any_time']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sunday From'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['sunday_from']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sunday To'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['sunday_to']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sunday Any Time'); ?></dt>
		<dd>
			<?php echo h($availability['Availability']['sunday_any_time']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Availability'), array('action' => 'edit', $availability['Availability']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Availability'), array('action' => 'delete', $availability['Availability']['id']), array(), __('Are you sure you want to delete # %s?', $availability['Availability']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Availabilities'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Availability'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
