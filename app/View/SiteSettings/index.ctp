<div class="siteSettings index">
	<h2><?php echo __('Site Settings'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('admin_email'); ?></th>
			<th><?php echo $this->Paginator->sort('site_logo'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($siteSettings as $siteSetting): ?>
	<tr>
		<td><?php echo h($siteSetting['SiteSetting']['id']); ?>&nbsp;</td>
		<td><?php echo h($siteSetting['SiteSetting']['admin_email']); ?>&nbsp;</td>
		<td><?php echo h($siteSetting['SiteSetting']['site_logo']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $siteSetting['SiteSetting']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $siteSetting['SiteSetting']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $siteSetting['SiteSetting']['id']), array(), __('Are you sure you want to delete # %s?', $siteSetting['SiteSetting']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Site Setting'), array('action' => 'add')); ?></li>
	</ul>
</div>
