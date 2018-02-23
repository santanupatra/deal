

<?php ?>
<section class="pt-5 pb-5">
          <div class="container">
              <div class="row">
                  <?php if($userdetails['User']['type']=='V'){ echo ($this->element('vendor_side_menu'));}else{echo ($this->element('user_side_menu'));};?>
                  <div class="col-lg-9 col-12">
                      <div class="right-side p-3">
                          <h2 class="text-pink">Purchase Details</h2>
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
  	    							<th class="text-right">Price</th>
  	    						</tr>
  	    					</thead>
  	    					<tbody>
  	    						<tr>
<?php //pr($purchase_details);?>
  	    							<td>
                        <div style="width:100px" class="prod-image pro-view-img">
                            <img src="<?php echo($this->webroot)?>product_images/<?php echo($purchase_details['Product']['ProductImage'][0]['name']);?>" alt="" class="img-fluid">
                        </div>
  	    							</td>

  	    							<td>
                                                                    <b><?php echo $purchase_details['Product']['name']?></b>
                                                                    <?php if($purchase_details['OrderDetail']['p_color']!=''){ ?><br><b>Color: <?php echo $purchase_details['OrderDetail']['p_color']?></b><?php } ?>
                                                                    <?php if($purchase_details['OrderDetail']['p_size']!=''){ ?><br><b>Size: <?php echo $purchase_details['OrderDetail']['p_size']?></b><?php } ?>
  	    							</td>

  	    							<td class="">
  	    								<?php echo $purchase_details['OrderDetail']['quantity']?>  	    							</td>

  	    							<td class="text-right">
  	    								<span><?php echo '$'.$purchase_details['OrderDetail']['price']?> </span>
  	    							</td>
  	    						</tr>

  								<tr>
  									<td class="text-right" colspan="10">
  										<div class="row">
                                        
                                                                                    
                                                                                    
                                    <?php if($rating_details['Rating']['rating']!='' || $rating_details['Rating']['review']!=''){?>                                                
                                    <div class="col-lg-6">
                                                <div class="starRating text-left">
                                                    
                                <?php $z=$rating_details['Rating']['rating'];?>
                                              
<!--                                        <i class="icon ion-android-star"></i>-->
                                        <span class="stars"><?php echo $z;?></span>
                               

                                </div>
                                <div class="starPara mt-2 text-left" >
                                        <p><?php echo $rating_details['Rating']['review'] ;?></p>
                                </div>
                                        </div>
                                    <?php }else{ ?> 
                                       <div class="col-lg-6"></div>                                           
                               <?php } ?>
                                                    <div class="col-lg-6"><h5 class="font-weight-bold text-orange"> Shipping Charge: <?php if($purchase_details['Shipday']['ship_charge']!=''){echo '$'.$purchase_details['Shipday']['ship_charge'];}else{ echo 'Free Shipping';}?> </h5>
<!--                                                                            <h5 class="font-weight-bold text-orange"> Discount Amount: <?php //echo '$'.((($purchase_details['OrderDetail']['price']+$purchase_details['Shipday']['ship_charge'])*($purchase_details['OrderDetail']['quantity']))-(($purchase_details['OrderDetail']['amount'])))?> </h5>-->
  										<h5 class="font-weight-bold text-orange"> Total Payable: <?php echo '$'.(($purchase_details['OrderDetail']['amount']))?> </h5>
  										</div>
  										</div>
  									</td>
  								</tr>
  	    					</tbody>
  	    				</table>
  	    			</div>
            </div>
                          <div class="row">
                              <div class="col-sm-6">
                                  <p class="text-grey mb-1"><b>Order Date : </b> <?php echo date('d-m-Y H:i:s',strtotime($purchase_details['OrderDetail']['order_received_date']))?></p> 
                                 <!--<p class="text-grey mb-1"><b>Sales Channel :</b> Name</p>--> 
                                 <p class="text-grey mb-1"><b>Customer Name : </b><?php echo $purchase_details['Buyer']['first_name'].' '.$purchase_details['Buyer']['last_name']?></p> 
                                 
                                 <p class="text-grey mb-1"><b>Payment Method : </b><?php echo $purchase_details['Order']['payment_type'];?></p>
                              </div>
                              <div class="col-sm-6">
                                  <div class="form-group form-inline justify-content-end">
                                      <label class="mr-2 text-grey font-weight-bold">Order Status:</label><b><i><?php  if($purchase_details['OrderDetail']['order_status']=='U'){echo 'Under Process';}elseif($purchase_details['OrderDetail']['order_status']=='D'){echo 'Delivered';}elseif($purchase_details['OrderDetail']['order_status']=='C'){echo 'Cancel';}elseif($purchase_details['OrderDetail']['order_status']=='DP'){echo 'Dispute';}elseif($purchase_details['OrderDetail']['order_status']=='S'){echo 'Shipment';}elseif($purchase_details['OrderDetail']['order_status']=='F'){echo 'Completed';}?></i></b>

                                  </div>

                                  
                              </div>
<!--                              <div class="col-12">
                                  <div class="form-group text-right mt-3">
                                      <button class="btn btn-primary btn-lg">Save</button>
                                  </div>
                              </div>-->
                          </div>
                     <?php if($purchase_details['OrderDetail']['order_status']=='F'){ ?>     
                     <p><a href="javascript:void(0);" class="btn btn-primary pop" data-toggle="modal" data-target="#myModal">Review</a></p>
                     <?php } ?>
 
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

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title titletext text-center">Review and rating</h4>
        <button type="button" class="close float-right" data-dismiss="modal">&times;</button>
      </div>
      <div class="pop_msg" align="center"></div>
      <div class="modal-body">
       <form method="post" >
      
           
           <input type="hidden" name="data[Rating][product_id]" value="<?php echo $purchase_details['OrderDetail']['product_id']?>">
           <input type="hidden" name="data[Rating][order_details_id]" value="<?php echo $purchase_details['OrderDetail']['id']?>">
           <input type="hidden" name="data[Rating][order_id]" value="<?php echo $purchase_details['OrderDetail']['order_id']?>">
           <input type="hidden" name="data[Rating][rated_to]" value="<?php echo $purchase_details['OrderDetail']['owner_id']?>">
           <input type="hidden" name="data[Rating][user_id]" value="<?php echo $purchase_details['OrderDetail']['user_id']?>">
           
           
      <div id="reg_first">
      
        <div class="col-md-12">
            
         <div class="form-group">
		   <div class="row">
		    <div class="col-sm-12">
    <div class="stars">

    <input class="star star-5" id="star-5" type="radio" name="data[Rating][rating]"  value="5"/>
    <label class="star star-5" for="star-5"></label>

    <input class="star star-4" id="star-4" type="radio" name="data[Rating][rating]"  value="4"/>

    <label class="star star-4" for="star-4"></label>

    <input class="star star-3" id="star-3" type="radio" name="data[Rating][rating]"  value="3"/>

    <label class="star star-3" for="star-3"></label>

    <input class="star star-2" id="star-2" type="radio" name="data[Rating][rating]"  value="2"/>

    <label class="star star-2" for="star-2"></label>

    <input class="star star-1" id="star-1" type="radio" name="data[Rating][rating]"  value="1"/>

    <label class="star star-1" for="star-1"></label>

    </div>
							        
            </div>
          </div>
          </div>   
           
        </div>
        
        <div class="col-md-12">
         <div class="form-group">
        <h4>Review</h4>
 <textarea class="form-control" name="data[Rating][review]"   tabindex="4" placeholder=""></textarea>
        </div>
        </div>
        <div class="form-group" align="right">
       <input type="submit" class=" btn btn-primary"  value="Submit" placeholder="" style="margin-right:3%">
        </div>
        </div>
        
       </form>
      
          </div>
          
      <div class="modal-footer">
        
      </div>
    </div>
    </div>
  </div>





<style>
   .form-horizontal .control-label {
	text-align: left;
    }
    
    
    span.stars, span.stars span {
    display: block;
    background: url(../../img/stars.png) 0 -16px repeat-x;
    width: 80px;
    height: 16px;
}

span.stars span {
    background-position: 0 0;
}
    
    
</style>


<style>

div.stars {
  width: 270px;
  display: inline-block;
  margin: 0 auto;
}

input.star { display: none; }

label.star {
  float: right;
  padding: 10px;
  font-size: 36px;
  color: #f83777;;
  transition: all .2s;
}

input.star:checked ~ label.star:before {
  content: '\f005';
  color: #f83777;;
  transition: all .25s;
}

input.star-5:checked ~ label.star:before {
  color: #f83777;;
  text-shadow: 0 0 20px #952;
}

input.star-1:checked ~ label.star:before { color: #f83777;; }

label.star:hover { transform: rotate(-15deg) scale(1.3); }

label.star:before {
  content: '\f006';
  font-family: FontAwesome;
}
</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 

<!--<script type="text/javascript">
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
</script>-->
<script>
$.fn.stars = function() {
    return $(this).each(function() {
        // Get the value
        var val = parseFloat($(this).html());
        // Make sure that the value is in 0 - 5 range, multiply to get width
        var size = Math.max(0, (Math.min(5, val))) * 16;
        // Create stars holder
        var $span = $('<span />').width(size);
        // Replace the numerical value with stars
        $(this).html($span);
    });
}
$(function() {
    $('span.stars').stars();
});

</script>