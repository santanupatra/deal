




    <!--  cart  page   -->

    <section class="order-list pt-5 pb-5">
        <div class="container">
          <div class="row">
         <?php if($userdetails['User']['type']=='V'){ echo ($this->element('vendor_side_menu'));}else{echo ($this->element('user_side_menu'));};?>
        <div class="col-lg-9 col-12">
            <?php //echo pr($orders);
             if($orders!='' && !empty($orders)){
            foreach($orders as $or){

                ?>
            
            <div class="mb-4 order-area">
              <div class="table-responsive">
  	    				<table class="table checkout-table table-bordered mb-0">
  	    					<thead class="table-dark">
  	    						<tr>
                                                            
                                                                <th>Buyer Name</th>
  	    							<th>Coupon Name</th>
  	    							<th>Coupon Code</th>
  	    							<th>Price</th>
  	    							<th>Buy Date</th>
  	    							<th></th>
  	    						</tr>
  	    					</thead>
  	    					<tbody>
  	    						<tr>

  	    							
                                                               <td>
  	    							<?php echo $or['User']['first_name'].' '.$or['User']['last_name']?>
  	    								
  	    							</td>
  	    							<td>
  	    							<?php echo $or['Coupon']['name']?>
  	    								
  	    							</td>

  	    							<td class="">
  	    								<?php echo $or['Order']['coupon_code']?>
  	    							</td>

  	    							<td>
  	    								<span><?php echo '$'.$or['Order']['total_amount']?> </span>
  	    							</td>
                                                                
                                                                <td>
  	    								<span><?php echo $or['Order']['payment_date']?> </span>
  	    							</td>

  	    							<td class="text-right">
                       
                                                                   
                                                                    <div class="">
                          
                          <a class="btn btn-primary btn-sm remove" href="<?php echo($this->webroot);?>products/view_order_details/<?php echo $or['Order']['id']?>">View</a>
                        </div>
                                                                    
  	    							</td>
  	    						</tr>

  								
  	    					</tbody>
  	    				</table>
  	    			</div>
            </div>

             <?php } }else{ ?>
            <div class="mt-4 order-area" style="text-align: center">Sorry!No order found.</div>
             <?php } ?>

          </div>
        </div>
      </div>
    </section>

    <!--   footer   -->
