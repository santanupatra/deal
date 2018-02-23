<?php ?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Shipping day list'); ?></div>
				<div style="float:right;">
				  <a href="<?php echo($this->webroot)?>admin/shipping_addresses/shhipping_management">Add Shipping Day</a>
				</div>
			</div>
			<div class="block-content collapse in">
				<div class="span12">
					<table class="table table-hover">
					<thead>
					<tr>
						<th>&nbsp;</th>
						<th>Id</th>
						<th>Shipping Name</th>
						<th>Shipping Day</th>
                                                <th>Shipping Charges</th>
						<th class="actions">Action</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($shippinday as $ad): ?>
					<tr>
                                        <td>&nbsp;</td>
                                        <td><?php echo h($ad['ShippingDay']['id']); ?>&nbsp;</td>

                                        <td><?php echo h($ad['ShippingDay']['ship_name']); ?>&nbsp;</td>
                                    <td><?php echo h($ad['ShippingDay']['ship_day']); ?>&nbsp;</td>
                                    <td><?php echo h('$'.$ad['ShippingDay']['ship_charge']); ?>&nbsp;</td>
                                   
						<td class="actions">
						    

<a href="<?php echo $this->webroot;?>admin/shipping_addresses/shipping_management_edit/<?php echo $ad['ShippingDay']['id'];?>"><img src="<?php echo $this->webroot;?>img/edit.png" title="Edit Shipping" width="22" height="21"></a>

							<a href="<?php echo $this->webroot;?>admin/shipping_addresses/shipping_management_delete/<?php echo $ad['ShippingDay']['id'];?>" onclick="return confirm('Are you sure to delete this ad?')"><img src="<?php echo $this->webroot;?>img/delete.png" title="Delete shipping" width="24" height="24"></a>
							
						</td>
					</tr>
					<?php endforeach; ?>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /block -->
		
		
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
