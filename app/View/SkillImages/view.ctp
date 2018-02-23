<div class="skillImages view">
<h2><?php echo __('Skill Image'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($skillImage['SkillImage']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Skill'); ?></dt>
		<dd>
			<?php echo $this->Html->link($skillImage['Skill']['id'], array('controller' => 'skills', 'action' => 'view', $skillImage['Skill']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image'); ?></dt>
		<dd>
			<?php echo h($skillImage['SkillImage']['image']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Skill Image'), array('action' => 'edit', $skillImage['SkillImage']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Skill Image'), array('action' => 'delete', $skillImage['SkillImage']['id']), array(), __('Are you sure you want to delete # %s?', $skillImage['SkillImage']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Skill Images'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Skill Image'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Skills'), array('controller' => 'skills', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Skill'), array('controller' => 'skills', 'action' => 'add')); ?> </li>
	</ul>
</div>
