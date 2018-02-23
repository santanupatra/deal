<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Sub Categories of'); ?>&nbsp;<?php echo($categoryname);?></div>
				<div style="float:right;"><?php echo $this->Html->link(__('Back To Category'), array('controller' => 'categories', 'action' => 'index')); ?></div>
			</div>
			<div class="block-content collapse in">
				<div class="span12">
				<table class="table table-hover">
				<tr>
						<th><?php echo $this->Paginator->sort('id'); ?></th>
						<th><?php echo $this->Paginator->sort('name'); ?></th>
								  
						<th><?php echo $this->Paginator->sort('active'); ?></th>
						<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
                                
				<?php 
                                //pr($categories);
                                foreach ($categories1 as $category): ?>
				<tr>
					<td><?php echo h($category['Category']['id']); ?>&nbsp;</td>
					<td><?php #echo h($category['Category']['name']);?><?php echo ($this->Html->link(__($category['Category']['name']), array('action' => 'subcategories', $category['Category']['id'])));?></td>

					 <td><?php echo h($category['Category']['is_active']==1?'Yes':'No'); ?>&nbsp;</td>
					 <td class="actions">
						<a href="<?php echo $this->webroot;?>admin/categories/addsubcategory/<?php echo $category['Category']['id'];?>"><img src="<?php echo $this->webroot;?>img/subcat_add.png" title="Add Sub Category" width="22" height="21"></a>

						 <a href="<?php echo $this->webroot;?>admin/categories/edit/<?php echo $category['Category']['id'];?>"><img src="<?php echo $this->webroot;?>img/edit.png" title="Edit Sub Category" width="22" height="21"></a>

						 <a href="<?php echo $this->webroot;?>admin/categories/delete/<?php echo $category['Category']['id'];?>" onclick="return confirm('Are you sure to delete?')"><img src="<?php echo $this->webroot;?>img/delete.png" title="Delete Sub Category" width="24" height="24"></a>
					</td>
				</tr>
			<?php endforeach; ?>
	        </table>
	       </div>
		</div>
	 </div>
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
