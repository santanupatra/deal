

    <!--  cart  page   -->

    <section class="checkout-section">
		<div class="container">
    		<div class="row mt-5">
				<div class="col-lg-8">
					<h4>My Cart (<?php echo ($cart?count($cart):'0'); ?>)</h4>
    			</div>
    			<div class="col-lg-4">
    				<div class="form-group text-right">
                        <button type="button" class="btn btn-secondary" onclick="gotoLists();">Shop More</button>
    				</div>
    			</div>
    		</div>
    		<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
            <?php if($cart){?>
	    				<table class="table checkout-table">
	    					<thead>
	    						<tr>
	    							<th>PRODUCT</th>
	    							<th>Item</th>
	    							<th class="">Quantity</th>
	    							<th class="">Item Price</th>
	    							<th class="text-right">Payable Price</th>
	    						</tr>
	    					</thead>

	    					<tbody>

	    						<?php
                                            $totalPrice = 0;
                                            $Quantity_error = 'No';

                                                foreach ($cart as $product){

                                                    $Quantity_errorStr = '';
                                                    $temp_quantity=$product['TempCart']['quantity'];
                                                    $temp_prd_id=$product['TempCart']['prd_id'];
                                                    $sub = ($product['TempCart']['quantity']*($product['TempCart']['price']+$product['ShippingDay']['ship_charge']));
                                                    $product_woner_id = $product['TempCart']['product_woner_id'];
                                                    $product_details=$this->requestAction(array('controller' => 'products', 'action' => 'get_product_details', $temp_prd_id, 'admin'=>false, 'prefix' => ''));
                                                    $UserDetails = $this->requestAction(array('controller' => 'users', 'action' => 'get_user_details', $product_woner_id, 'admin'=>false, 'prefix' => ''));
                                                    $SellerName=$UserDetails['User']['first_name'].' '.$UserDetails['User']['last_name'];
                                                    $SellerEmail=$UserDetails['User']['email'];

                                                    if(count($product_details)>0){
                                                        $AvlPrd=$product_details['Product']['quantity'];
                                                    }else{
                                                        $AvlPrd=0;
                                                    }
                                                    if($temp_quantity>$AvlPrd){
                                                        $Quantity_error='Yes';
                                                        $Quantity_errorStr.='<p style="color: #B60E09;">Quantity not available.</p>';
                                                    }



                                                	?>


	    						<tr>
	    						<form method="post" action="<?php echo $this->webroot.'products/edit_quantity';?>" name="">
	    							<td>
                                               <a href="<?php echo $this->webroot ?>products/product_details/<?php echo $product['TempCart']['prd_id'] ; ?>"><div class="prod-image" style="width:100px">
                                             <?php if(!empty($product['TempCart']['image'])) { ?>
                                        <img src="<?php echo $this->webroot ?>product_images/<?php echo $product['TempCart']['image']; ?>" alt="" class="img-fluid">
                                                <?php }else{ ?>
                           <img src="<?php echo($this->webroot)?>product_images/default.png" alt="" class="img-fluid">

                                                <?php } ?>

                                                   </div></a>
	    							</td>
	    							<td>
                                                                    <a href="<?php echo $this->webroot ?>products/product_details/<?php echo $product['TempCart']['prd_id'] ; ?>"><b><?php echo $product['TempCart']['name'] ; ?></b></a>
	    								<h6 class="text-grey"><?php echo $product['TempCart']['item_description'] ; ?></h6>
	    							</td>
	    							<td class="">
	    								<span id="quantity_list_<?php echo $product['TempCart']['prd_id'];?>"><?php echo $product['TempCart']['quantity'];?></span><span style="display: none;" id="quantity_edit_<?php echo $product['TempCart']['prd_id'];?>"><input type="number" style="width: 90px;" min="1" name="data[TempCart][quantity]" value="<?php echo $product['TempCart']['quantity'];?>"><input type="hidden" name="data[TempCart][id]" value="<?php echo $product['TempCart']['id'];?>"> <button type="submit" class="fa fa-check text-success frm_submit" name="frm_submit" title="Update"></button></span>
	    							</td>
	    							<td>

	    								<span >$<?php echo $product['TempCart']['price'];?></span>
	    							</td>

                                            <input type="hidden" name="cart_prd_id" value="<?php echo $product['TempCart']['prd_id'];?>">
	    							<td class="text-right">

	    								<h5>$<?php echo $sub ; ?></h5>
                                                                        <div class="">
                                                                        <?php
                                                                        if($product['ShippingDay']['ship_name']!=''){
                                                                        echo $product['ShippingDay']['ship_name'] .'-Delivery within '.$product['ShippingDay']['ship_day'].'Days';
                                                                        }else{
                                                                            
                                                       echo 'Free Shipping';
                                                                       }
                                                                        ?>
                                                                        </div>
                      <div class="">
                        <a href="<?php echo $this->webroot ?>products/delete_cart/<?php echo $product['TempCart']['id'] ; ?>" class="fa fa-trash text-pink" onclick="if (confirm(Are you sure you want to delete ? <?php echo $product['TempCart']['name'];  ?>)) { return true; } return false;"></a>
                        <a href="Javascript: void(0);" class="fa fa-pencil text-success mr-2  edit_quantity" id="<?php echo $product['TempCart']['prd_id'];?>" alt="Edit" title="Edit"></a>
                      </div>


	    							</td>
	    							</form>
	    						</tr>
                                <?php

                                $totalPrice = $totalPrice + $sub;
                                $delivaryprice= $delivaryprice + ($product['TempCart']['quantity']*$product['ShippingDay']['ship_charge']);
                                }  ?>

								<tr>
									<td colspan="10" class="text-right">
                                                                            <div class="">
                                                                                <b>Delivery Charges: <?php if($delivaryprice!=''){echo '$'.$delivaryprice;}else{echo 'Free Delivery';} ?></b>
                                                                            </div><br>
										<h5 class="font-weight-bold"> Total Payable: $<?php echo $totalPrice; ?> </h5>
                    <div class="">
                      <button class="btn btn-primary"  onclick="gotoShipping()">CHECKOUT</button>
                    </div>
									</td>
								</tr>
	    					</tbody>
	    				</table>
              <?php }else{ ?>

              <div class="alert alert-info">Sorry! No product available.</div>

          <?php    } ?>
	    			</div>
    			</div>
    		</div>
    	</div>
    </section>

   <script type="text/javascript">
   	 $(document).ready(function(){
       $(".edit_quantity").click(function(){
            var DivId=$(this).attr('id');
            $("#quantity_list_"+DivId).hide();
            $("#quantity_edit_"+DivId).show();
        });
    });

   	 function gotoShipping(){
    var QuantityCheck='<?php echo $Quantity_error;?>';
    if(QuantityCheck=='Yes'){
        alert('Pleace check product quantity.');
    }else{
        window.location.href='<?php echo($this->webroot)?>shipping_addresses/review';
    }

}
function gotoLists(){
    //window.location.href='<?php echo($this->webroot)?>products/list/';
    window.location.href='<?php echo($this->webroot)?>';
}
   </script>
