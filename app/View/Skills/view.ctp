<div class="skills view">
<h2><?php echo __('Skill'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($skill['Skill']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($skill['User']['id'], array('controller' => 'users', 'action' => 'view', $skill['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Skill Name'); ?></dt>
		<dd>
			<?php echo h($skill['Skill']['skill_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Skill Details'); ?></dt>
		<dd>
			<?php echo h($skill['Skill']['skill_details']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Active'); ?></dt>
		<dd>
			<?php echo h($skill['Skill']['is_active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Skill Workshop Address'); ?></dt>
		<dd>
			<?php echo h($skill['Skill']['skill_workshop_address']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Skill'), array('action' => 'edit', $skill['Skill']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Skill'), array('action' => 'delete', $skill['Skill']['id']), array(), __('Are you sure you want to delete # %s?', $skill['Skill']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Skills'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Skill'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Skill Images'), array('controller' => 'skill_images', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Skill Image'), array('controller' => 'skill_images', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Skill Images'); ?></h3>
	<?php if (!empty($skill['SkillImage'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Skill Id'); ?></th>
		<th><?php echo __('Image'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($skill['SkillImage'] as $skillImage): ?>
		<tr>
			<td><?php echo $skillImage['id']; ?></td>
			<td><?php echo $skillImage['skill_id']; ?></td>
			<td><?php echo $skillImage['image']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'skill_images', 'action' => 'view', $skillImage['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'skill_images', 'action' => 'edit', $skillImage['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'skill_images', 'action' => 'delete', $skillImage['id']), array(), __('Are you sure you want to delete # %s?', $skillImage['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Skill Image'), array('controller' => 'skill_images', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
