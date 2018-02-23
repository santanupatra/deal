 <style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #sortable li { margin: 0 3px 10px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 40px; }
  #sortable li span { position: absolute; margin-left: -1.3em; }
</style>


<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Categories'); ?></div>
				<div style="float:right;"><?php echo $this->Html->link(__('Add New Category'), array('controller' => 'categories', 'action' => 'coupon_add')); ?></div>
			</div>
			<div class="block-content collapse in">
                            <div class="span12">
                                <table class="table table-hover">
                                    <thead>
					<tr>
						<th width=20%><?php echo $this->Paginator->sort('id'); ?></th>
						<th width=30%><?php echo $this->Paginator->sort('name'); ?></th>
						<th width=30%><?php echo $this->Paginator->sort('is_active'); ?></th>
						<th class="actions" width=20%><?php echo __('Actions'); ?></th>
					</tr>
                                    </thead>
                                    <tbody id="sortable">
                                     
					<?php foreach ($categories as $category): ?>
					<tr class="ui-state-default" id="<?php echo $category['Category']['id'];?>">
                                            <td><?php echo h($category['Category']['id']); ?>&nbsp;</td>
                                            <td>
                                            <?php echo h($category['Category']['name']);?>
                                            </td>
                                            <td><?php echo h($category['Category']['is_active']==1?'Yes':'No'); ?>&nbsp;</td>
                                            <td class="actions">
                                            

                                             <a href="<?php echo $this->webroot;?>admin/categories/coupon_edit/<?php echo $category['Category']['id'];?>"><img src="<?php echo $this->webroot;?>img/edit.png" title="Edit Category" width="22" height="21"></a>

                                             <a href="<?php echo $this->webroot;?>admin/categories/delete/<?php echo $category['Category']['id'];?>" onclick="return confirm('Are you sure to delete?')"><img src="<?php echo $this->webroot;?>img/delete.png" title="Delete Category" width="24" height="24"></a>
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