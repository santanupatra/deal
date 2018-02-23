<?php  $SITE_URL = Configure::read('SITE_URL'); ?>
	<section class="after_login">
		<div class="container">
			<div class="row">
				<?php echo($this->element('user_leftbar'));?>
				<div class="col-md-9">
					<div class="manage_inventory">
					
					<div class="dash_middle_sec seller_membership" style="padding: 60px 40px;margin:0 auto;">
						<h3>You need to Pay <?php echo $sitesetting['SiteSetting']['price_per_listing']?> GBP for each product you add to show it on the site. Below is the list of Prodcut to pay. Click 'Pay by PayPal' button to pay for the product .</h3>	
						 
						 <table class="seller_table">
							<tr>
								<th>Name</th>
								<th>Quantity</th>
								<th>Unit Type</th>
								<th>Product Price</th>
								<th>Featured</th>
								<th>You Pay</th>
							</tr>
							<?php //pr($prod);exit;
							if(!empty($prods)){
							    $totprice = 0;
							    $custom=array();
							    foreach($prods as $prod)
							    {
							?>
							<tr>
							    
								<td><?php echo $prod['Product']['name'];?></td>
								<td><!--<input type="text" />--><?php echo $prod['Product']['quantity_lot'];?></td>
								<td><?php if($prod['Product']['unit_type']=='W'){
									echo 'WholeSale';
								    }
								    elseif($prod['Product']['unit_type']=='S'){
									echo 'SinglePiece';
								    }
								    ?></td>
								<td><?php echo '$'.$prod['Product']['price_lot'];?>
									<!--<form class="form-inline">
									  <div class="form-group">
									    <label class="sr-only" for="exampleInputAmount">Amount (in dollars)</label>
									    <div class="input-group">
										 <div class="input-group-addon">$</div>
										 <input type="text" class="form-control" id="exampleInputAmount" placeholder="100">
									    </div>
									  </div>
									</form>-->
								</td>
								<td><?php echo ($prod['Product']['is_featured']=='Y'?'Yes':'No'); ?></td>
								<td>
									<?php echo $sitesetting['SiteSetting']['price_per_listing']?> GBP
								</td>
							</tr>
							<?php 
									$totprice = $totprice+$sitesetting['SiteSetting']['price_per_listing'];
									$custom[] = base64_encode($prod['Product']['id']);
									}
							?>
							<tr>
								<td colspan="5" style="text-align:right">Total Payable Amount</td>
								<td><?php echo number_format($totprice,2);?> GBP</td>
							</tr>
							<?php		
							    $customval = implode('|',$custom);
							    } 
							else{
							   echo "<tr><td colspan='9'>Sorry Record found</td></tr>"; 
							}
							?>
						</table>   
						
						<div style="margin:0 auto;text-align:center;margin-top: 20px;">
							<button onclick="formSubmit();" style="margin: 0 auto;">Pay by PayPal</button>
							<a href="<?php echo $this->webroot.'products/add_product';?>" style="margin: 0 auto;color: white;text-decoration: none;"><button style="margin-left: auto;color: white;">Add New Product</button></a>
						</div>
					</div>
						
					    
					    <div>&nbsp;</div>
					    <!--<input type="text" /><button> <i class="fa fa-search"></i> SEARCH</button>-->
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="membershipform">
					<input type="hidden" name="cmd" value="_xclick">
		               
		               <input type="hidden" name="business" value="<?php echo $sitesetting['SiteSetting']['paypal_email'];?>">
		               <input type="hidden" name="currency_code" value="GBP">
		               <input type="hidden" name="notify_url" value="<?php echo $SITE_URL.'products/success';?>">
				     <input type="hidden" name="return" value="<?php echo $SITE_URL.'products/success';?>">
				     <input type="hidden" name="cancel_return" value="<?php echo $SITE_URL.'products/failure';?>">
				     
				     <!--<input type="hidden" name="notify_url" value="<?php echo 'http://localhost/twop/products/success';?>">
				     <input type="hidden" name="return" value="<?php echo 'http://localhost/twop/products/success';?>">
				     <input type="hidden" name="cancel_return" value="<?php echo 'http://localhost/twop/products/failure';?>">-->
				     
		               <input type="hidden" name="item_name" value="Pay to Post Product">
		               <input type="hidden" name="amount" value="<?php echo $totprice;?>">
		               <input type="hidden" name="quantity" value="1">
		               <input type="hidden" name="custom" value="<?php echo $customval;?>">
</form>

					    
					</div>
					
				
				
				</div>
			    
				
			</div>
		</div>
</section>
<script>
function formSubmit(){
    	document.membershipform.submit();
    }
</script>
