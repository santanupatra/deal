<?php ?>
<section class="pt-5 pb-5">
          <div class="container">
              <div class="row">
                  <?php if($userdetails['User']['type']=='V'){ echo ($this->element('vendor_side_menu'));}else{echo ($this->element('user_side_menu'));};?>
                  <div class="col-lg-9 col-12">
                      <div class="right-side p-3">
                          <h2 class="text-pink">Order Details</h2>
                          <div class="row order-details-row-top">
                             <div class="col-sm-6">
                                 <h6 class="font-weight-bold">Shipping Address</h6>
                                 <p class="text-grey"><b>Address :</b><?php echo $shipaddress['ShippingAddress']['street'].','.$shipaddress['ShippingAddress']['apartment'].', City: '.$shipaddress['ShippingAddress']['city'].', State: '.$shipaddress['ShippingAddress']['state'].',Zipcode:'.$shipaddress['ShippingAddress']['zip_code'].',Phno:'.$shipaddress['ShippingAddress']['phn_no']?></p>
                              </div>
                              <!--<div class="col-sm-4">
                                 <p class="text-grey mb-1"><b>Order Date :</b> 24 - 06 -2017</p> 
                                 <p class="text-grey mb-1"><b>Sales Channel :</b> Name</p> 
                                 <p class="text-grey mb-1"><b>Customer Name :</b> Rosy Wilson</p> 
                              </div>-->
                              <div class="col-sm-6">
                                 <h6 class="font-weight-bold">Billing Address</h6>
                                 <p class="text-grey"><b>Billing Name:</b><?php echo $billaddress['BillingAddress']['full_name']?></p>
                                 <p class="text-grey"><b>Address :</b><?php echo $billaddress['BillingAddress']['street'].','.$billaddress['BillingAddress']['apartment'].', City: '.$billaddress['BillingAddress']['city'].', State: '.$billaddress['BillingAddress']['state'].',Zipcode:'.$billaddress['BillingAddress']['zip_code'].',Phno:'.$billaddress['BillingAddress']['phn_no']?></p>
                              </div>
                          </div>
                          <div class="mb-4 order-area">
              <div class="table-responsive">
  	    				<table class="table checkout-table table-bordered mb-0">
  	    					<thead class="table-dark">
  	    						<tr>
  	    							<th>PRODUCT</th>
  	    							<th>Item</th>
  	    							<th>Quantity</th>
  	    							<th>Price</th>
  	    						</tr>
  	    					</thead>
  	    					<tbody>
  	    						<tr>
<?php //pr($order_details);?>
  	    							<td>
                        <div style="width:100px" class="prod-image pro-view-img">
                            <img src="<?php echo($this->webroot)?>product_images/<?php echo($order_details['Product']['ProductImage'][0]['name']);?>" alt="" class="img-fluid">
                        </div>
  	    							</td>

  	    							<td>
  	    							<b><?php echo $order_details['Product']['name']?></b>
                                                                <?php if($order_details['OrderDetail']['p_color']!=''){ ?><br><b>Color: <?php echo $order_details['OrderDetail']['p_color']?></b><?php } ?>
                                                                    <?php if($order_details['OrderDetail']['p_size']!=''){ ?><br><b>Size: <?php echo $order_details['OrderDetail']['p_size']?></b><?php } ?>
  	    							</td>

  	    							<td class="">
  	    								<?php echo $order_details['OrderDetail']['quantity']?>  	    							</td>

  	    							<td>
  	    								<span><?php echo '$'.$order_details['OrderDetail']['price']?> </span>
  	    							</td>
  	    						</tr>

  								<tr>
  									<td class="text-right" colspan="10">
                                                                            
                                                                            
                                                                            <h5 class="font-weight-bold text-orange"> Shipping Charge: <?php if($order_details['Shipday']['ship_charge']!=''){echo '$'.$order_details['Shipday']['ship_charge'];}else{ echo 'Free Shipping';}?> </h5>
<!--                                                                            <h5 class="font-weight-bold text-orange"> Discount: <?php //echo '$'.((($order_details['OrderDetail']['price']+$order_details['Shipday']['ship_charge'])*($order_details['OrderDetail']['quantity']))-(($order_details['OrderDetail']['amount'])))?> </h5>-->
  										<h5 class="font-weight-bold text-orange"> Total: <?php echo '$'.(($order_details['OrderDetail']['amount']))?> </h5>
  									</td>
  								</tr>
  	    					</tbody>
  	    				</table>
  	    			</div>
            </div>
                          <form method="post" >
                          <div class="row">
                              
                              <div class="col-sm-6">
                                  <p class="text-grey mb-1"><b>Order Date : </b> <?php echo date('d-m-Y H:i:s',strtotime($order_details['OrderDetail']['order_received_date']))?></p> 
                                 <!--<p class="text-grey mb-1"><b>Sales Channel :</b> Name</p>--> 
                                 <p class="text-grey mb-1"><b>Customer Name : </b><?php echo $order_details['Buyer']['first_name'].' '.$order_details['Buyer']['last_name']?></p> 
                                 
                                 <p class="text-grey mb-1"><b>Payment Method : </b><?php echo $order_details['Order']['payment_type'];?></p>
                              </div>
                              <input type="hidden" name="data[OrderDetail][id]" value="<?php echo $order_details['OrderDetail']['id']?>">
                              <div class="col-sm-6">
                                  <div class="form-group form-inline justify-content-end">
                                      <label class="mr-2 text-grey font-weight-bold">Order Status</label>
                                      <select class="form-control" name="data[OrderDetail][order_status]">
                                           <option value="U" <?php if($order_details['OrderDetail']['order_status']=='U'){echo 'selected';}?>>Under Process</option>
                                          <option value="D" <?php if($order_details['OrderDetail']['order_status']=='D'){echo 'selected';}?>>Delivered</option>
                                          <option value="C" <?php if($order_details['OrderDetail']['order_status']=='C'){echo 'selected';}?>>Cancel</option>
                                          <option value="DP" <?php if($order_details['OrderDetail']['order_status']=='DP'){echo 'selected';}?>>Dispute</option>
                                          <option value="S" <?php if($order_details['OrderDetail']['order_status']=='S'){echo 'selected';}?>>Shipment</option>
                                          <option value="F" <?php if($order_details['OrderDetail']['order_status']=='F'){echo 'selected';}?>>Completed</option>
                                      </select>
                                  </div>
                                  
                              </div>
                              <div class="col-12">
                                  <div class="form-group text-right mt-3">
                                   <button type="submit" class="btn btn-primary btn-lg">Save</button>
                                  </div>
                              </div>
                              
                          </div>
                          </form>
                          <!--<div class="row">
                              <div class="col-sm-3">
                                  <div>
                                      <img src="http://111.93.169.90/team6/widding/product_images/dress-2.jpg" alt="" class="img-fluid">
                                  </div>
                              </div>
                              <div class="col-sm-9">
                                  <h5>Item Name</h5>
                                  <p class="text-grey"><b>	Quantity :</b> 2</p>
                                  <h5 class="text-grey"><b>	Price :</b> <span class="text-pink font-weight-bold">$154</span></h5>
                                  <div class="form-group form-inline">
                                      <label class="mr-2 text-grey font-weight-bold">Order Status</label>
                                      <select class="form-control">
                                          <option>Shipping</option>
                                          <option>Deliveried</option>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <button class="btn btn-primary btn-lg">Save</button>
                                  </div>
                              </div>
                          </div>-->
                      </div>
                  </div>
              </div>
          </div>
      </section>
<style>
   .form-horizontal .control-label {
	text-align: left;
    }
</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 

<script type="text/javascript">
    function check_validate(){
        var CouponAmount=$('#CouponAmount').val();
        var float= /^\s*(\+|-)?((\d+(\.\d+)?)|(\.\d+))\s*$/;
        if(float.test(CouponAmount)==false){
            alert('Enter value must be float or int.');
            $("#CouponAmount").css('border', '1px solid #ff0000');
            $("#CouponAmount").focus();
            return false;
        }else{
            return true;
        }
    }
    
    $(document).ready(function(){
        var dateToday = new Date();
        $( "#fromDate" ).datepicker({ 
            dateFormat: 'yy-mm-dd',
            //changeMonth: true,
            //changeYear: true,
            minDate: dateToday,
            onSelect: function (date, el) {
                $("#toDate").datepicker( "option", "minDate", date );
                //$("endDatePicker").datepicker( "option", "maxDate", '+2y' );
            },
            yearRange: "-150:+1"
        });
        
        $( "#toDate" ).datepicker({ 
            dateFormat: 'yy-mm-dd',
            yearRange: "-150:+1"
        });
    });
</script>