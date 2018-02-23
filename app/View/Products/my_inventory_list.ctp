<?php ?>
	<section class="after_login">
		<div class="container">
			<div class="row">
				<?php echo($this->element('user_leftbar'));?>
				<div class="col-md-9">
					<div class="manage_inventory">
					    <h3>Manage Inventory</h3>
					    <div>&nbsp;</div>
					    <!--<input type="text" /><button> <i class="fa fa-search"></i> SEARCH</button>-->
					    <form method="post" name="searchform" action="<?php echo $this->webroot.'products/my_inventory_list';?>" style="width:75%;">
						<input type="text"  placeholder="     Search for..." name="data[Filter][search]" id="title" value="<?php echo (isset($this->params['named']['search']) && $this->params['named']['search']!='')?$this->params['named']['search']:'';?>"  required style="width:400px;margin-left:0px;"><button type="submit"> <i class="fa fa-search"></i> SEARCH</button>
						      
					    </form>
					    <span style="float:right;margin-top:-35px;"><a href="<?php echo $this->webroot.'products/add_product';?>" class="btn btn-info">Add New Product</a></span>
					</div>
					<form action="<?php echo $this->webroot.'products/pay_multiproduct';?>" method="post" name="paymulti">
					<?php 
					if(!empty($inventoryList)){
						?>
					<button onclick="formmultisubmit()" style="margin-top: 20px;margin-left: 0px;">Pay All Selected Products</button>
					<?php }
					?>
					<table class="seller_table">
						<tr>
							<th></th>
							<th>Product</th>
							<th>Name</th>
							<th>SKU</th>
							<th>Category</th>
                                                        <th>Quantity</th>
                                                        <th>Selling Type</th>
							<th>Price</th>
							<th>Featured</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
						<?php //pr($inventoryList);exit;
						if(!empty($inventoryList)){
						    foreach($inventoryList as $inventory){
                                                        $product_id=$inventory['Product']['id'];
                                                        $prd_feature_status=$this->requestAction(array('controller' => 'products', 'action' => 'get_product_feature_status', $product_id, 'admin'=>false, 'prefix' => ''));
						?>
                                                <tr>
                                                    <input type="hidden" name="data[id][<?php echo $inventory['Product']['id'];?>]" value="<?php echo $inventory['Product']['id'];?>">
                                                    <input type="hidden" name="data[previous_quantity][<?php echo $inventory['Product']['id'];?>]" value="<?php echo $inventory['Product']['quantity'];?>">
						    <td><input type="checkbox" name="data[Product][id][]" value="<?php echo $inventory['Product']['id']?>"></td>
						    <td><a href="<?php echo $this->webroot.'products/inventory_image/'.base64_encode($inventory['Product']['id']);?>">
							<?php
                                                        $prd_img=$this->requestAction(array('controller' => 'products', 'action' => 'get_product_main_image', $product_id, 'admin'=>false, 'prefix' => ''));
                                                        if(!empty($prd_img)){
                                                            $uploadFolder = "product_images";
                                                            $uploadPath = WWW_ROOT . $uploadFolder;
                                                            $imageName =$prd_img[0]['ProductImage']['name'];
                                                            if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
                                                                $image = $this->webroot.'product_images/'.$imageName;
                                                            }else{ 
                                                                $image = $this->webroot.'product_images/default.png';
                                                            } 
                                                            
							?>
							    <img src="<?php echo $image;?>" alt="" style="width:60px"/>
							<?php } else{ ?><img src="<?php echo $this->webroot?>img/uploadimage.png" alt="" style="width:60px"/>  <?php } ?>
							</a></td>
							<td><?php echo $inventory['Product']['name'];?></td>
							<td><?php echo $inventory['Product']['sku'];?></td>
							<td><?php echo $inventory['Category']['name'];?></td>
                                                        <td><input type="number" style="width: 55px;" min="1" name="data[quantity][<?php echo $inventory['Product']['id'];?>]" value="<?php echo $inventory['Product']['quantity'];?>" placeholder="Quantity"></td>
							<td><?php if($inventory['Product']['unit_type']=='W'){
								echo 'Wholesale';
							    }
							    elseif($inventory['Product']['unit_type']=='S'){
								echo 'Retail';
							    }
							    ?></td>
                                                        <td><span class="doller" style=" border:1px solid #c6c4c4; padding: 4px;">$</span><input class="doller__value" type="number" style="width: 55px;" min="1" name="data[price_lot][<?php echo $inventory['Product']['id'];?>]" value="<?php echo $inventory['Product']['price_lot'];?>" placeholder="Price">
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
							<td><?php echo ($prd_feature_status >0?'Yes':'No'); ?></td>
							<td><?php echo ($inventory['Product']['status']=='P'?'Pending':($inventory['Product']['status']=='A'?'Active':'In-Active')); ?></td>
							<td>
                                                            <button type="submit" name="QuantitySubmit" value="<?php echo $inventory['Product']['id'];?>" class="">Update</button>
								<a href="<?php echo $this->webroot;?>products/edit/<?php echo base64_encode($inventory['Product']['id']);?>" class="fa fa-pencil"></a>
								<a a href="<?php echo $this->webroot;?>products/delete/<?php echo base64_encode($inventory['Product']['id']);?>" onclick="return confirm('Are you sure to delete this user?')" class="fa fa-trash"></a>
                                                                <br><?php if($inventory['Product']['status']=='P'){?><a href="<?php echo $this->webroot;?>products/pay_product/<?php echo base64_encode($inventory['Product']['id']);?>" style="color: #b60e09;">Pay Now</a><?php }?>
							</td>
                                                    
						</tr>
                                                
						<?php 
							}
						    } 
						else{
						   echo "<tr><td colspan='10'>Sorry No Record found</td></tr>"; 
						}
						?>
					</table>
					</form>
				</div>
			
				<div class="paging">
				<?php
					echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
					echo $this->Paginator->numbers(array('separator' => ''));
					echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
				?>
				</div>
			</div>
		</div>
</section>
<script>
function formSubmit(){
    	document.paymulti.submit();
    }
</script>
<style>
button {
height: 34px;
background: #B60E09;
border: 0;
color: #fff;
padding: 0 10px;
border-radius: 3px;
margin-left: 15px;
}
</style>
