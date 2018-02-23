
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Contents'); ?></div>
				<div style="float:right;"></div>
			</div>
			<div class="block-content collapse in">
				<div class="span12">
					<table class="table table-hover">
					<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('id'); ?></th>
						<th><?php echo $this->Paginator->sort('page_name'); ?></th>
						<th><?php echo $this->Paginator->sort('page_heading'); ?></th>
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($contents as $content): ?>
					<tr>
							<td><?php echo h($content['Content']['id']); ?>&nbsp;</td>
							<td><?php echo h($content['Content']['page_name']);?></td>
							<td><?php echo ($content['Content']['page_heading']);?></td>
							<td class="actions">
								<a href="<?php echo $this->webroot;?>admin/contents/view/<?php echo $content['Content']['id'];?>"><img src="<?php echo $this->webroot;?>img/view.png" title="View Content"></a>
								<a href="<?php echo $this->webroot;?>admin/contents/edit/<?php echo $content['Content']['id'];?>"><img src="<?php echo $this->webroot;?>img/edit.png" title="Edit Content" width="22" height="21"></a>
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