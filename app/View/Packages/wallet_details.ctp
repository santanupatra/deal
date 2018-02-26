




    <!--  cart  page   -->

    <section class="order-list pt-5 pb-5">
        <div class="container">
          <div class="row">
         <?php if($userdetails['User']['type']=='V'){ echo ($this->element('vendor_side_menu'));}else{echo ($this->element('user_side_menu'));};?>
        <div class="col-lg-9 col-12">
            
            <div class="mb-4 order-area">
              <div class="table-responsive">
  	    				<table class="table checkout-table table-bordered mb-0">
  	    					<thead class="table-dark">
  	    						<tr>
                                                                
                                                                <th>Remaining Deals</th>
  	    							<th>Remaining Coupons</th>
  	    							
  	    							
  	    						</tr>
  	    					</thead>
  	    					<tbody>
  	    						<tr>

  	    							
                                                              

  	    							<td>
  	    							<?php echo $Wallet_details['User']['total_deal']?>
  	    							</td>

  	    							<td>
  	    							<?php echo $Wallet_details['User']['total_coupon']?>
  	    							</td>
                                                                
                                                              
                                                                    
  	    							
  	    						</tr>

  								
  	    					</tbody>
  	    				</table>
  	    			</div>
                
                
            </div>
            <form method="post" action="<?php echo $this->webroot;?>packages/package_details">
            <div class="row">
                
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <div class="form-group form-inline justify-content-end">
                        <label class="mr-2 text-grey font-weight-bold">Packages</label>
                        <select class="form-control" name="data[Subscriber][package_id]" required="required">
                            <option value="" >--Select--</option>
                            <?php foreach ($package as $p) { ?>
                                <option value="<?php echo $p['Package']['id'] ?>" ><?php echo $p['Package']['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                </div>

                <div class="col-12">
                    <div class="form-group text-right mt-3">
                        <button type="submit" class="btn btn-primary btn-lg">Subscribe</button>
                    </div>
                </div>

                
            </div>
            </form>
                        

             
            

          </div>
        </div>
      </div>
    </section>

    <!--   footer   -->
