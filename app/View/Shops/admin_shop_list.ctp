<?php ?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Users'); ?></div>
				<div style="float:right;">
				  <a href="<?php echo($this->webroot)?>admin/shops/shop_add">Add New Shop</a>
				</div>
			</div>
			<div class="block-content collapse in">
				<div class="span12">
					<table class="table table-hover">
					<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('id'); ?></th>
						<th><?php echo $this->Paginator->sort('name'); ?></th>
						
						<th><a href="javascript:void(0);">Logo</a></th>
						<th><?php echo $this->Paginator->sort('is_active'); ?></th>
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php  foreach ($shops as $shop): ?>
					<tr>
						<td><?php echo h($shop['Shop']['id']); ?>&nbsp;</td>
						<td><?php echo h($shop['Shop']['name']); ?>&nbsp;</td>
                                                <td><img src="<?php echo $this->webroot;?>shop_images/<?php echo h($shop['Shop']['logo']); ?>" width="50px" height="50px">&nbsp;</td>
						

						<td><?php if(isset($shop['Shop']['is_active']) && $shop['Shop']['is_active']==1){echo 'Yes';}else{echo 'No';} ?>&nbsp;</td>
						<td class="actions">
<!--						    <a href="<?php echo $this->webroot;?>admin/shops/shop_view/<?php echo $shop['Shop']['id'];?>"><img src="<?php echo $this->webroot;?>img/view.png" title="View Shop" width="22" height="21"></a>-->

						    <a href="<?php echo $this->webroot;?>admin/shops/shop_edit/<?php echo $shop['Shop']['id'];?>"><img src="<?php echo $this->webroot;?>img/edit.png" title="Edit Shop" width="22" height="21"></a>

						    <a href="<?php echo $this->webroot;?>admin/shops/shop_delete/<?php echo $shop['Shop']['id'];?>" onclick="return confirm('Are you sure to delete this shop?')"><img src="<?php echo $this->webroot;?>img/delete.png" title="Delete Vendor" width="24" height="24"></a>
							
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
