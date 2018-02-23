<div class="siteSettings view">
<h2><?php echo __('Site Setting'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($siteSetting['SiteSetting']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Admin Email'); ?></dt>
		<dd>
			<?php echo h($siteSetting['SiteSetting']['admin_email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Site Logo'); ?></dt>
		<dd>
			<?php echo h($siteSetting['SiteSetting']['site_logo']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Site Setting'), array('action' => 'edit', $siteSetting['SiteSetting']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Site Setting'), array('action' => 'delete', $siteSetting['SiteSetting']['id']), array(), __('Are you sure you want to delete # %s?', $siteSetting['SiteSetting']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Site Settings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Site Setting'), array('action' => 'add')); ?> </li>
	</ul>
</div>
