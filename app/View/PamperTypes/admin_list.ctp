
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Pamper Types'); ?></div>
				<div style="float:right;"><a href="<?php echo($this->webroot)?>admin/pamper_types/add">Add New PamperType</a></div>
			</div>
			<div class="block-content collapse in">
				<div class="span12">
					<table class="table table-hover">
					<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('name'); ?></th>
						<th><?php echo $this->Paginator->sort('is_active'); ?></th>
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($pampertypes as $pampertype): ?>
					<tr>
						<td><?php echo h($pampertype['PamperType']['name']); ?>&nbsp;</td>
						<td><?php if(isset($pampertype['PamperType']['is_active']) && $pampertype['PamperType']['is_active']==1){echo 'Yes';}else{echo 'No';} ?>&nbsp;</td>
						<td class="actions">
							<a href="<?php echo $this->webroot;?>admin/pamper_types/edit/<?php echo $pampertype['PamperType']['id'];?>"><img src="<?php echo $this->webroot;?>img/edit.png" title="Edit Pamper Type" width="22" height="21"></a>

							<a href="<?php echo $this->webroot;?>admin/pamper_types/delete/<?php echo $pampertype['PamperType']['id'];?>" onclick="return confirm('Are you sure to delete this pamper type?')"><img src="<?php echo $this->webroot;?>img/delete.png" title="Delete Pamper Type" width="24" height="24"></a>
						</td>
					</tr>
					<?php endforeach; ?>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /block -->
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
</div>
<style>
.actions a
{
 background:none;
 border:none;
 border-radius:0px;
 box-shadow:none;
 padding:0px;
}
</style>
