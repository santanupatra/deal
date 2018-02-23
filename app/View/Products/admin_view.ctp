<?php 
#pr($product);
?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('View Product'); ?></div>
			</div>
			<div class="users view">
				<dl>
                                    <dt><?php echo __('Id'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['id']); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('Owner'); ?></dt>
                                    <dd>
                                            <?php echo $this->Html->link($product['User']['id'], array('controller' => 'users', 'action' => 'view', $product['User']['id'])); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('Category'); ?></dt>
                                    <dd>
                                            <?php echo $this->Html->link($product['Category']['name'], array('controller' => 'categories', 'action' => 'view', $product['Category']['id'])); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('Sub Category'); ?></dt>
                                    <dd>
                                            <?php echo $this->requestAction('/products/getSubcatname/'.$product['Product']['sub_category_id']); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('Name'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['name']); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('Sku'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['sku']); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('Featured'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['is_featured']=='Y'?'Yes':'No'); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('Unit Type'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['unit_type']=='W'?'WholeSale':'SinglePiece'); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('Quantity/Lot'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['quantity_lot']); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('Price/Lot ($)'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['price_lot']); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('Keywords'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['keywords']); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('Shipping Time'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['shipping_time']); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('Processing Time'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['processing_time']); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('Sale On?'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['sale_on']=='Y'?'Yes':'No'); ?>
                                            &nbsp;
                                    </dd>
				        <?php
					if($product['Product']['sale_on']=='Y'){
					?>
                                    <dt><?php echo __('Discount (% off)'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['discount']); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('Start Date'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['start_date']); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('End Date'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['end_date']); ?>
                                            &nbsp;
                                    </dd>
					<?php } ?>
                                    <dt><?php echo __('Package Weight'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['package_weight']); ?>&nbsp;<?php echo h($product['Product']['package_unit']); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('Package Height'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['package_size1']); ?>&nbsp;<?php echo h($product['Product']['package_size_unit']); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('Package Width'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['package_size2']); ?>&nbsp;<?php echo h($product['Product']['package_size_unit']); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('Package Length'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['package_size3']); ?>&nbsp;<?php echo h($product['Product']['package_size_unit']); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('Created On'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['created_at']); ?>
                                            &nbsp;
                                    </dd>
                                    <dt><?php echo __('Status'); ?></dt>
                                    <dd>
                                            <?php echo h($product['Product']['status']=='A'?'Active':($product['Product']['status']=='P'?'Pending':'Inactive')); ?>
                                            &nbsp;
                                    </dd>
                            </dl>
			</div>


			
			<?php 
			if(!empty($product['ProductImage'])){
			?>
			<div class="block-content collapse in">
				<div class="span12">
					<table class="table table-hover">
					<thead>
					<tr>
                                                <th>&nbsp;</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($product['ProductImage'] as $data): ?>
					<tr>
                                            <td>
                                                    <img height="100" width="100" src="<?php echo($this->webroot)?>product_images/<?php echo($data['name']);?>"/></td>
					</tr>
                   
                                        <?php endforeach; ?>
					</tbody>
					</table>
				</div>
			</div>

			<?php } ?>
		</div>
	</div>
</div>
