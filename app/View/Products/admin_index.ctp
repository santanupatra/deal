<?php ?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Deals'); ?></div>
				<div style="float:right;"><?php echo $this->Html->link(__('Add New Deal'), array('controller' => 'products', 'action' => 'add')); ?></div>
                                
                              
			</div>
                    <div class="navbar navbar-inner block-header">
                        
                       
                    </div>
			<div class="block-content collapse in">
				<div class="span12">
					<table class="table table-hover">
					<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('id'); ?></th>
                                                <th><?php echo $this->Paginator->sort('user_id'); ?></th>
                                                <th><?php echo $this->Paginator->sort('category_id'); ?></th>
                                                <th><?php echo $this->Paginator->sort('name'); ?></th>
                                                
                                                <th><?php echo $this->Paginator->sort('created_at','Created On'); ?></th>
                                                <th><?php echo $this->Paginator->sort('status'); ?></th>
                                                <th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($products as $product): ?>
					<tr>
                                            <td><?php echo h($product['Product']['id']); ?>&nbsp;</td>
                                            <td>
                                                    <?php echo $this->Html->link($product['User']['first_name'], array('controller' => 'users', 'action' => 'view', $product['User']['id'])); ?>
                                            </td>
                                            <td>
                                                    <?php echo $this->Html->link($product['Category']['name'], array('controller' => 'categories', 'action' => 'view', $product['Category']['id'])); ?>
                                            </td>
                                            <td><?php echo h($product['Product']['name']); ?>&nbsp;</td>
                                            
                                            <td><?php echo h($product['Product']['created_at']); ?>&nbsp;</td>
                                            <td><?php echo h($product['Product']['status']=='A'?'Active':($product['Product']['status']=='P'?'Pending':'Inactive')); ?>&nbsp;</td>
                                            <td class="actions">                                               
                                                
                                                
<!--                                                <a href="<?php echo $this->webroot;?>admin/products/view/<?php echo $product['Product']['id'];?>"><img src="<?php echo $this->webroot;?>img/view.png" title="View Product"></a>-->

                                                <a href="<?php echo $this->webroot;?>admin/products/edit/<?php echo $product['Product']['id'];?>"><img src="<?php echo $this->webroot;?>img/edit.png" title="Edit Product" width="22" height="21"></a>

                                                <a href="<?php echo $this->webroot;?>admin/products/delete/<?php echo $product['Product']['id'];?>" onclick="return confirm('Are you sure to delete?')"><img src="<?php echo $this->webroot;?>img/delete.png" title="Delete Product" width="24" height="24"></a>
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

