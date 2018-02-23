
    <section class="pt-5 pb-5">
          <div class="container">
              <div class="row">

                    <?php if($userdetails['User']['type']=='V'){ 
                    	echo $this->element('vendor_side_menu');
                    }
                    	else{echo ($this->element('user_side_menu'));};?>
                  <div class="col-lg-9 col-12">
                      <div class="right-side p-3">
                          <div class="row">
                          	<div class="col-xl-6 col-sm-6 mb-3">
					          <div class="card text-white bg-primary o-hidden h-100">
					            <div class="card-body">
					              <div class="card-body-icon">
					                <i class="fa fa-fw fa-shopping-cart"></i>
					              </div>
					              <div class="mr-5">
					              	<div class="text-white">Total No. of Purchase</div>
                                                        <div class="huge text-white"><?php echo $totpurchase; ?></div>
					              	
					              </div>
					            </div>
					            <a class="card-footer text-white clearfix small z-1" href="<?php echo($this->webroot);?>products/purchase_history">
                                                        <span class="float-left">View Details</span>
					              <span class="float-right">
					                <i class="fa fa-angle-right"></i>
					              </span>
					            </a>
					          </div>
					        </div>
					        <div class="col-xl-6 col-sm-6 mb-3">
					          <div class="card text-white bg-warning o-hidden h-100">
					            <div class="card-body">
					              <div class="card-body-icon">
					                <i class="fa fa-fw fa-file-text-o"></i>
					              </div>
					              <div class="mr-5">
					              	<div class="text-white">Total No. of Orders</div>
					              	<div class="huge text-white"><?php echo $totorder; ?></div>
					              </div>
					            </div>
					            <a class="card-footer text-white clearfix small z-1" href="<?php echo($this->webroot);?>products/order_list">
					              <span class="float-left">View Details</span>
					              <span class="float-right">
					                <i class="fa fa-angle-right"></i>
					              </span>
					            </a>
					          </div>
					        </div>
					        <div class="col-xl-6 col-sm-6 mb-3">
					          <div class="card text-white bg-success o-hidden h-100">
					            <div class="card-body">
					              <div class="card-body-icon">
					                <i class="fa fa-fw fa-shopping-bag"></i>
					              </div>
					              <div class="mr-5">
					              	<div class="text-white">Total No. of Products</div>
					              	<div class="huge text-white"><?php echo $totproduct; ?></div>
					              </div>
					            </div>
                                                      
                                                    <a class="card-footer text-white clearfix small z-1" <?php if($userdetails['User']['type']=='V'){?> href="<?php echo($this->webroot);?>products/" <?php }else{ ?> href="<?php echo($this->webroot);?>products/list_product" <?php } ?>>
					              <span class="float-left">View Details</span>
					              <span class="float-right">
					                <i class="fa fa-angle-right"></i>
					              </span>
					            </a>
					          </div>
					        </div>
					        <div class="col-xl-6 col-sm-6 mb-3">
					          <div class="card text-white bg-danger o-hidden h-100">
					            <div class="card-body">
					              <div class="card-body-icon">
					                <i class="fa fa-fw fa-history"></i>
					              </div>
					              <div class="mr-5">
					              	<div class="text-white">Total No. of Wishlist</div>
					              	<div class="huge text-white"><?php echo $totwishlist;?></div>
					              </div>
					            </div>
								<a class="card-footer text-white clearfix small z-1" href="<?php echo($this->webroot);?>products/wish_list">
					              <span class="float-left">View Details</span>
					              <span class="float-right">
					                <i class="fa fa-angle-right"></i>
					              </span>
					            </a>
					          </div>
					        </div>
                          </div>
						  
						  <div class="row">
						  	<div class="col-lg-12">
						  		<h2 class="mt-4">Latest Purchase</h2>
						  	</div>
						  	<div class="col-lg-12">
						  		<table class="table table-striped tablePart">
									<thead>
									<tr>
									<th>Order No.</th>
									<th>Item Name</th>
									<th>Date</th>
									<th>Quantity</th>
                                                                        <th>Amount Pay</th>
									</tr>
									</thead>
									<tbody>
                                                                     <?php if(!empty($latestpurchase)){ foreach($latestpurchase as $dt){?>       
									<tr>
									<td><?php echo $dt['OrderDetail']['order_id']?></td>
									<td><?php echo $dt['Product']['name']?></td>
									<td><?php echo $dt['OrderDetail']['order_received_date']?></td>
									<td><?php echo $dt['OrderDetail']['quantity']?></td>
                                                                        <td>$<?php echo ($dt['OrderDetail']['quantity']*$dt['OrderDetail']['amount']);?></td>
									</tr>
									
                                                                     <?php } }else{ ?>
                                                                        <tr colspan="4">Sorry! No product purchase yet.</tr>   
                                                                        
                                                                     <?php } ?>
									
									</tbody>
									</table>
						  	</div>
						  </div>
                      </div>
                  </div> 
              </div>
          </div>
      </section>

    

    <!--   footer   -->

    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
    
    
   