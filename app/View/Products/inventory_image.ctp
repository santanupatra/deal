<?php ?>
	<section class="after_login">
		<div class="container">
			<div class="row">
				<?php echo($this->element('user_leftbar'));?>
				<div class="col-md-9">
					<div class="manage_inventory">
					    <h3>Manage Inventory Image</h3><span style="float:right;"><a href="<?php echo $this->webroot.'products/upload_inventory_image/'.$this->params['pass'][0];?>">Add New</a></span>
					</div>
					<table class="seller_table">
						<tr>
                                                    <th>Main Images</th>
                                                    <th>Product Name</th>
                                                    <th>Image</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
						</tr>
						<?php //pr($products);exit;
						if(!empty($products)){
						    foreach($products as $product){
						?>
						<tr>
                                                    <td><input type="radio" name="main_img" <?php if($product['ProductImage']['is_feature']==1){ echo 'checked="checked"';}?> alt="<?php echo $product['ProductImage']['status'];?>" value="<?php echo $product['ProductImage']['id'];?>#<?php echo $product['ProductImage']['product_id'];?>" class="mainImg"></td>
						    <td><?php echo $product['Product']['name'];?></td>
						    <td><img src="<?php echo $this->webroot?>product_images/<?php echo $product['ProductImage']['name'];?>" alt="" style="width:60px"/></td>
                                                    <td><?php echo ($product['ProductImage']['status']=='1'?'<a href="'.$this->webroot.'products/change_image_status/'.base64_encode($product['ProductImage']['id']).'/0" onclick="return confirm("Are you sure to Inactive this image?")" >Active</a>':'<a href="'.$this->webroot.'products/change_image_status/'.base64_encode($product['ProductImage']['id']).'/1" onclick="return confirm("Are you sure to active this image?")" >In-Active</a>'); ?></td>
                                                    <td><a href="<?php echo $this->webroot;?>products/imgdelete/<?php echo base64_encode($product['ProductImage']['id']);?>" onclick="return confirm('Are you sure to delete this image?')" class="fa fa-trash"></a></td>
						</tr>
						<?php 
							}
						    } 
						else{
						   echo "<tr><td colspan='4'>Sorry Record found</td></tr>"; 
						}
						?>
					</table>
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
<script type="text/javascript">
$(document).ready(function(){
    $('.mainImg').click(function(){
        var imgPID=$(this).val();
        var imgAlt=$(this).attr('alt');
        if(imgPID!=''){
            if(imgAlt==0){
                alert('Please active image status first.');
            }else{
                $.ajax({
                    type:'post' ,
                    data: {'imgPID':imgPID},
                    url:'<?php echo $this->webroot;?>products/set_main_images/',
                    success:function(data){
                        if(data!=''){
                           location.reload(); 
                        }
                    }
                });
            }
        }else{
            alert('Please select one image.');
        }
    }); 
});  
</script>