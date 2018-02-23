




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
            <!-- <div class="mt-4 order-area">
                <div><span class="order-no"><?php echo $or['OrderDetail']['order_id']?></span></div>
                <div class="row mt-3">
                    <div class="col-lg-2 mb-3 mb-lg-0">
                        <img src="<?php echo($this->webroot)?>product_images/<?php echo($or['Product']['ProductImage'][0]['name']);?>" alt="" class="img-fluid">
                    </div>
                    <div class="col-lg-4">
                        <a href="#" class="text-grey"><p><?php echo $or['Product']['name']?></p></a>
                        <p><b>Qty:</b> <span><?php echo $or['OrderDetail']['quantity']?></span></p>
                    </div>
                    <div class="col-lg-1">
                        <h4 class="font-weight-bold"><?php echo '$'.$or['OrderDetail']['price']?></h4>
                    </div>
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-2 text-lg-right">
                        <button class="btn btn-danger">Cancel</button>
                    </div>
                </div>
                <div class="order-bottom mt-3">
                    <div class="row  pt-3">
                        <div class="col-lg-6">
                        </div>
                        <div class="col-lg-6 text-lg-right">
                            <h5 class="text-orange font-weight-bold">Total: <?php echo '$'.(($or['OrderDetail']['price'])*($or['OrderDetail']['quantity']))?></h5>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="mb-4 order-area">
              <div class="table-responsive">
  	    				<table class="table checkout-table mb-0">
  	    					<thead>
  	    						<tr>
  	    							<th>PRODUCT</th>
  	    							<th>Item</th>
  	    							<th class="">Quantity</th>
  	    							<th class="">Price</th>
  	    							<th></th>
  	    						</tr>
  	    					</thead>
  	    					<tbody>

  	    						<tr>
  	    							<td>
                        <div style="width:100px" class="prod-image">
                          <img src="<?php echo($this->webroot)?>product_images/<?php echo($or['Product']['ProductImage'][0]['name']);?>" alt="" class="img-fluid">
                        </div>
  	    							</td>
  	    							<td>
  	    							<b><?php echo $or['Product']['name']?></b>
  	    								<h6 class="text-grey"></h6>
  	    							</td>
  	    							<td class="">
  	    								<?php echo $or['OrderDetail']['quantity']?>
  	    							</td>
  	    							<td>

  	    								<span><?php echo '$'.$or['OrderDetail']['price']?> </span>
  	    							</td>
  	    							<td class="text-right">
                        <div class="">
                          <a class="btn btn-secondary btn-sm remove" href="#">Cancel</a>
                          <a class="btn btn-primary btn-sm remove" href="<?php echo($this->webroot);?>products/view_purchase_details/<?php echo $or['OrderDetail']['id']?>">View</a>
                        </div>


  	    							</td>

  	    						</tr>

  								<tr>
  									<td class="text-right" colspan="10">
  										<h5 class="font-weight-bold text-orange"> Total: <?php echo '$'.(($or['OrderDetail']['amount']))?> </h5>
  									</td>
  								</tr>
  	    					</tbody>
  	    				</table>
  	    			</div>
            </div>
             <?php } }else{ ?>
            <div class="mt-4 order-area" style="text-align: center">Sorry!No purchase found.</div>
             <?php } ?>
<!--            <div class="mt-4 order-area">
                <div><span class="order-no">ODRTOP5651245</span></div>
                <div class="row mt-3">
                    <div class="col-lg-2 mb-3 mb-lg-0">
                        <img src="img/item/2.png" alt="" class="img-fluid">
                    </div>
                    <div class="col-lg-4">
                        <a href="#" class="text-grey"><p>Wedding Dress Renaissance , Lace Wedding Dress, Bohemian Wedding Dress, Long Sleeve Dress, Open Back Gown, Vintage Wedding Dress, 2 in 1</p></a>
                        <p><b>Qty:</b> <span>2</span></p>
                    </div>
                    <div class="col-lg-1">
                        <h4 class="font-weight-bold">$154</h4>
                    </div>
                    <div class="col-lg-3">
                        <p>Delivered on Thu, 2nd Nov, 2017</p>
                    </div>
                    <div class="col-lg-2 text-lg-right">
                        <button class="btn btn-danger">Cancel</button>
                    </div>
                </div>
                <div class="order-bottom mt-3">
                    <div class="row  pt-3">
                        <div class="col-lg-6">
                            <p><b>Seller:</b> <span>abcdefgh</span></p>
                        </div>
                        <div class="col-lg-6 text-lg-right">
                            <h5 class="text-orange font-weight-bold">Total: $154</h5>
                        </div>
                    </div>
                </div>
            </div>-->
            </div>
          </div>
        </div>
    </section>


    <!--   footer   -->
