

<?php ?>
<section class="pt-5 pb-5">
          <div class="container">
              <div class="row">
                  <?php if($userdetails['User']['type']=='V'){ echo ($this->element('vendor_side_menu'));}else{echo ($this->element('user_side_menu'));};?>
                  <div class="col-lg-9 col-12">
                      <div class="right-side p-3">
                          <h2 class="text-pink">Purchase Details</h2>
                          
                          <div class="mb-4 order-area">
              <div class="table-responsive">
  	    				<table class="table checkout-table table-bordered mb-0">
  	    					<thead class="table-dark">
  	    						<tr>
  	    							<th>Coupon Name</th>
  	    							<th>Coupon Code</th>
                                                                <th>Coupon Offer</th>
  	    							<th>Price</th>
  	    						</tr>
  	    					</thead>
  	    					<tbody>
  	    						<tr>
<?php //pr($purchase_details);?>
  	    							
  	    							<td>
  	    							<?php echo $purchase_details['Coupon']['name']?>
  	    							</td>

  	    							<td class="">
  	    								<?php echo $purchase_details['Order']['coupon_code']?>                                             </td>
                                                                
                                                                <td class="">
  	    								<?php echo $purchase_details['Coupon']['offer']?>                                             </td>

  	    							<td>
  	    								<span><?php echo '$'.$purchase_details['Order']['total_amount']?> </span>
  	    							</td>
  	    						</tr>

  								<tr>
  									<td class="text-right" colspan="10">
                                                                            
                                                                            
                                                                            

  										<h5 class="font-weight-bold text-orange"> Total: <?php echo '$'.(($purchase_details['Order']['total_amount']))?> </h5>
  									</td>
  								</tr>
  	    					</tbody>
  	    				</table>
  	    			</div>
            </div>
                          <div class="row">
                              <div class="col-sm-6">
                                  <p class="text-grey mb-1"><b>Order Date : </b> <?php echo date('d-m-Y',strtotime($purchase_details['Order']['payment_date']))?></p> 
                                 
                                 <p class="text-grey mb-1"><b>Seller Name : </b><?php echo $purchase_details['Seller']['first_name'].' '.$purchase_details['Seller']['last_name']?></p> 
                                 
                                 <p class="text-grey mb-1"><b>Payment Method : </b><?php echo $purchase_details['Order']['payment_type'];?></p>
                              </div>
                              

                          </div>
                     
 
                          
                      </div>
                  </div>
              </div>
          </div>
    
      </section>







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