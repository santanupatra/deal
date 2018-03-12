<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Coupon List'); ?></div>
				<div style="float:right;"><?php echo $this->Html->link(__('Add New Coupon'), array('controller' => 'coupons', 'action' => 'add')); ?></div>
			</div>
			<div class="block-content collapse in">
                            <div class="span12">
                                <table class="table table-hover">
                                    <thead>
					<tr>
                                            <th><?php echo $this->Paginator->sort('id'); ?></th>
                                            <th><?php echo $this->Paginator->sort('name'); ?></th>
                                            <!--<th><?php echo $this->Paginator->sort('type'); ?></th>-->
                                            <th><?php echo $this->Paginator->sort('amount'); ?></th>
                                            <th><?php echo $this->Paginator->sort('from_date'); ?></th>
                                            <th><?php echo $this->Paginator->sort('to_date'); ?></th>
                                            <th><?php echo $this->Paginator->sort('is_active'); ?></th>
                                            <th><?php echo $this->Paginator->sort('Store order'); ?></th>
                                            <th><?php echo $this->Paginator->sort('Online Order'); ?></th>
                                            <th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
                                    </thead>
                                    <tbody>
					<?php  foreach ($coupons as $val): ?>
					<tr>
                                            <td><?php echo h($val['coupon']['Coupon']['id']); ?>&nbsp;</td>
                                            <td><?php echo h($val['coupon']['Coupon']['name']); ?>&nbsp;</td>
                                            
<!--                                            <td><?php echo ($val['coupon']['Coupon']['type']==1)?'Amount':'Percentage'; ?>&nbsp;</td>-->
                                            <td><?php echo h($val['coupon']['Coupon']['amount']); ?>&nbsp;</td>
                                            <td><?php echo h($val['coupon']['Coupon']['from_date']); ?>&nbsp;</td>
                                            <td><?php echo h($val['coupon']['Coupon']['to_date']); ?>&nbsp;</td>
                                            <td><?php echo h($val['coupon']['Coupon']['is_active']==1?'Yes':'No'); ?>&nbsp;</td>
                                            <td><?php echo h($val['storesold']); ?>&nbsp;</td>
                                            <td><?php echo h($val['onlinesold']); ?>&nbsp;</td>
                                            <td class="actions">
                                                <a href="<?php echo $this->webroot;?>admin/coupons/edit/<?php echo $val['coupon']['Coupon']['id'];?>"><img src="<?php echo $this->webroot;?>img/edit.png" title="Edit Coupon" width="22" height="21"></a>

                                                <a href="<?php echo $this->webroot;?>admin/coupons/delete/<?php echo $val['coupon']['Coupon']['id'];?>" onclick="return confirm('Are you sure to delete?')"><img src="<?php echo $this->webroot;?>img/delete.png" title="Delete Coupon" width="24" height="24"></a>
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