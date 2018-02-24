<?php ?>
<section class="pt-5 pb-5">
          <div class="container">
              <div class="row">
                  <?php if($userdetails['User']['type']=='V'){ echo ($this->element('vendor_side_menu'));}else{echo ($this->element('user_side_menu'));};?>
                  <div class="col-lg-9 col-12">
                      <div class="right-side p-3">
                          <h2 class="text-pink">Order Details</h2>
                          <div class="row order-details-row-top">
                             
                              
                              
                          </div>
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
<?php //pr($order_details);?>
  	    							
  	    							<td>
  	    							<?php echo $order_details['Coupon']['name']?>
  	    							</td>

  	    							<td class="">
  	    								<?php echo $order_details['Order']['coupon_code']?>                                             </td>
                                                                
                                                                <td class="">
  	    								<?php echo $order_details['Coupon']['offer']?>                                             </td>

  	    							<td>
  	    								<span><?php echo '$'.$order_details['Order']['total_amount']?> </span>
  	    							</td>
  	    						</tr>

  								<tr>
  									<td class="text-right" colspan="10">
                                                                            
                                                                            
                                                                            

  										<h5 class="font-weight-bold text-orange"> Total: <?php echo '$'.(($order_details['Order']['total_amount']))?> </h5>
  									</td>
  								</tr>
  	    					</tbody>
  	    				</table>
  	    			</div>
            </div>
                          
                          <div class="row">
                              
                              <div class="col-sm-6">
                                  <p class="text-grey mb-1"><b>Order Date : </b> <?php echo date('d-m-Y ',strtotime($order_details['Order']['payment_date']))?></p> 
                                 
                                 <p class="text-grey mb-1"><b>Customer Name : </b><?php echo $order_details['User']['first_name'].' '.$order_details['User']['last_name']?></p> 
                                 
                                 <p class="text-grey mb-1"><b>Payment Method : </b><?php echo $order_details['Order']['payment_type'];?></p>
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