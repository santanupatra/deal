<?php ?>
	<section class="after_login">
		<div class="container">
			<div class="row">
				<?php echo($this->element('user_leftbar'));?>
				<div class="col-md-9">
					<div class="manage_inventory">
					    <h3>Manage Inventory</h3><input type="text" /><button> <i class="fa fa-search"></i> SEARCH</button><span style="float:right;"><a href="<?php echo $this->webroot.'products/add_product';?>">Add New Product</a></span>
					</div>
					<table class="seller_table">
						<tr>
							<th>Product</th>
							<th>Name</th>
							<th>SKU</th>
							<th>Category</th>
							<th>Quantity</th>
							<th>Unit Type</th>
							<th>Price</th>
							<th>Featured</th>
							<th>Action</th>
						</tr>
						<?php //pr($inventoryList);exit;
						if(!empty($inventoryList)){
						    foreach($inventoryList as $inventory){
						?>
						<tr>
						    <td><a href="<?php echo $this->webroot.'products/inventory_image/'.$inventory['Product']['id'];?>">
							<?php if(!empty($inventory['ProductImage'])){
							    $count = (count($inventory['ProductImage']))-1;
							    $path = 'product_images/'.$inventory['ProductImage'][$count]['name'];
								if (file_exists($path)) {
								
							?>
							    <img src="<?php echo $this->webroot.'product_images/'.$inventory['ProductImage'][$count]['name'];?>" alt="" style="width:60px"/>
							<?php } else{ ?> <img src="<?php echo $this->webroot?>img/uploadimage.png" alt="" style="width:60px"/> <?php } } else{ ?><img src="<?php echo $this->webroot?>img/uploadimage.png" alt="" style="width:60px"/>  <?php } ?>
							</a></td>
							<td><?php echo $inventory['Product']['name'];?></td>
							<td><?php echo $inventory['Product']['sku'];?></td>
							<td><?php echo $inventory['Category']['name'];?></td>
							<td><!--<input type="text" />--><?php echo $inventory['Product']['quantity_lot'];?></td>
							<td><?php if($inventory['Product']['unit_type']=='W'){
								echo 'WholeSale';
							    }
							    elseif($inventory['Product']['unit_type']=='S'){
								echo 'SinglePiece';
							    }
							    ?></td>
							<td><?php echo '$'.$inventory['Product']['price_lot'];?>
								<!--<form class="form-inline">
								  <div class="form-group">
								    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
								    <div class="input-group">
								      <div class="input-group-addon">$</div>
								      <input type="text" class="form-control" id="exampleInputAmount" placeholder="100">
								    </div>
								  </div>
								</form>-->
							</td>
							<td>Yes</td>
							<td>
								<a href="<?php echo $this->webroot;?>products/edit/<?php echo $inventory['Product']['id'];?>" class="fa fa-pencil"></a>
								<a a href="<?php echo $this->webroot;?>products/delete/<?php echo $inventory['Product']['id'];?>" onclick="return confirm('Are you sure to delete this user?')" class="fa fa-trash"></a>
							</td>
						</tr>
						<?php 
							}
						    } 
						else{
						   echo "<tr><td colspan='9'>Sorry Record found</td></tr>"; 
						}
						?>
					</table>
				</div>
			</div>
		</div>
</section>