

    <!--  cart  page   -->

    <section class="checkout-section">
		<div class="container">
<!--    		<div class="row mt-5">
				<div class="col-lg-8">
					<h4>My Cart (<?php echo ($cart?count($cart):'0'); ?>)</h4>
    			</div>
    			<div class="col-lg-4">
    				<div class="form-group text-right">
                        <button type="button" class="btn btn-secondary" onclick="gotoLists();">Shop More</button>
    				</div>
    			</div>
    		</div>-->
    		<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
            
	    				<table class="table checkout-table table-bordered">
	    					<thead>
	    						<tr>
	    							<th>Coupon Name</th>
	    							<th>Price</th>
	    							<th class="">Offer get</th>
	    							
	    						</tr>
	    					</thead>

	    					<tbody>

	    						

	    						<tr>
	    						
	    							<td>
                                               <?php  echo $coupon_details['Coupon']['name'];?>
	    							</td>
	    							<td>
                                                                    
	    							<?php echo $coupon_details['Coupon']['amount'] ; ?>
	    							</td>
	    							<td class="">
	    							<?php echo $coupon_details['Coupon']['offer'] ; ?>% Discount	
	    							</td>
	    							

                                            <input type="hidden" name="cart_prd_id" value="">
	    							
	    							
	    						</tr>
                               

								<tr>
									<td colspan="10" class="text-right">
                                                                            <br>
										<h5 class="font-weight-bold"> Total Payable: $<?php echo $coupon_details['Coupon']['amount'] ; ?> </h5>
                    <div class="">
                      <button class="btn btn-primary" >Pay Now</button>
                    </div>
									</td>
								</tr>
	    					</tbody>
	    				</table>
              
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
