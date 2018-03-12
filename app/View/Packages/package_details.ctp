

    <!--  cart  page   -->

    <section class="checkout-section">
		<div class="container">
    		<div class="row mt-5">
				<div class="col-lg-8">
					<h4>Purchase Details</h4>
    			</div>
    			
    		</div>
    		<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
            
	    				<table class="table checkout-table table-bordered">
	    					<thead>
	    						<tr>
	    							<th>Package Name</th>
	    							<th>Price</th>
	    							<th>No of Deal Can upload</th>
                                                                <th>No of Coupon Can upload</th>
	    							
	    						</tr>
	    					</thead>

	    					<tbody>

	    						

	    						<tr>
	    						
	    							<td>
                                               <?php  echo $package_details['Package']['name'];?>
	    							</td>
	    							<td>
                                                                    
	    							$<?php echo $package_details['Package']['price'] ; ?>
	    							</td>
	    							<td class="">
	    							<?php echo $package_details['Package']['no_deal'] ; ?>	
	    							</td>
	    							<td class="">
	    							<?php echo $package_details['Package']['no_coupon'] ; ?>	
	    							</td>

                                            
	    							
	    							
	    						</tr>
                               
                                                        
								<tr>
									<td colspan="10" class="text-right">
                                                                            <br>
										<h5 class="font-weight-bold"> Total Payable: $<?php echo $package_details['Package']['price'] ; ?></h5>
                                                                                
                        <div style="float: right; width: 200px">
                            <div style="float:left">
                                <form class="mt-4" method="post" action="<?php echo $this->webroot; ?>packages/package_request/<?php echo base64_encode($package_details['Package']['id']); ?>">                                                      
                                <button type="submit" class="btn btn-primary" >Pay Cash</button>
                            
                        </form>
                            </div>
                            <div style="float:left;padding: 1px">
                                <form class="mt-4" method="post" action="<?php echo $this->webroot; ?>packages/payment_process/<?php echo base64_decode($package_details['Package']['id']); ?>">                                                      
                            
                                <button type="submit" class="btn btn-primary" >Pay Now</button>
                            
                        </form>
                            </div>
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
