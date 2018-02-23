<div class="absolute_signup" id="absolute_login">
    <div class="payment_area">
	  <form action="" id="payment_form" method="post">
            	<h1>MAKE THE PAYMENT AND LEARN THAT SKILL</h1>
	    		    <h2>Payment Details</h2>
					<ul class="width270 float-left" style="margin-bottom:10px">
						<li>
							<p>Payment type</p>
							<div class="selectgreybox">
								<select name="crd_type" id="crd_type" onchange="chose_crd_type(this.value)">
									<option value="">Select type</option>
									<option value="creditcard">Credit Card</option>
									<option value="paypal">Paypal</option>
								</select>
							</div>
						</li>
					</ul>
					<ul class="width270 float-right">
						<li>
							<p>Available Payment type</p>
							<p>
								<a href="#"><img src="<?php echo $this->webroot;?>img/visa.png" alt=""></a>
								<a href="#"><img src="<?php echo $this->webroot;?>img/mastercard.png" alt=""></a>
								<a href="#"><img src="<?php echo $this->webroot;?>img/paypal.png" alt=""></a>
							<p>
						</li>
					</ul>
					<div class="clearfix"></div>
					<div id="pay_type_paypal" style="display:none">
						   <ul class="width270 float-left">
								<li>
									<p>Paypal email</p>
									<div class="inputgreybox"><input type="text" id="paypal_email_field" name="paypal_email_field" autocomplete="off"></div>
									<span id="paypal_email_field_err" style="color:red"></span>
								</li>
							</ul>
							<ul class="width270 float-right">
								<li>
									<p>Payment type</p>
									<p>
										<a href="#"><img src="<?php echo $this->webroot;?>img/paypal.png" alt=""></a>
									<p>
								</li>
							</ul>
							<div class="clearfix"></div>
							<input type="button" onclick="return pay_paypal();" value="Make payment" class="social_btn sign_up_btnn" style="margin:20px auto 40px auto;display:block;width:289px;" id="purchase_giftp">
							<img src="<?php echo $this->webroot;?>img/32.gif" border="0" alt="" style="display:none;margin: 20px auto 40px auto;" id="purchase_gift_loadp">
					</div>
					<div id="pay_type_card" style="display:none">
					<?php 
					  if(!empty($previous_card_details)){
						  $count_all_cards=count($previous_card_details);
						  $c=1;
					?>
					 <ul class="width270 float-left" style="width:100%">
					<?php
						 foreach($previous_card_details as $previous_card_detail){
					?>
					 <li style="border-bottom:1px solid #efefef;padding-bottom: 8px;margin-bottom: 10px;">
					   <input type="hidden" name="braintree_customer_id_token" id="braintree_customer_id_token" value="" />
					   
					   <p>
					    <span style="float:left;">
					     <input type="radio" name="chose_card" id="chose_card<?php echo $c;?>" value="<?php echo $previous_card_detail['token'].'@$@$@'.$previous_card_detail['customerid'];?>" onclick="check_radio(<?php echo $count_all_cards;?>,<?php echo $c;?>)">&nbsp;&nbsp;<img src="<?php echo $previous_card_detail['imageurl'];?>" style="float:none">
						</span>
						<span style="float:left;">
						 <?php echo $previous_card_detail['cardtype'];?> ending in <?php echo $previous_card_detail['last4'];?><br><?php echo $previous_card_detail['expirationdate'];?>
						</span>
					   </p>
					 </li>
					<?php $c++;} ?>
					 </ul>
					 <p style="font-size: 15px;line-height: 6px;color: #000;margin-bottom:50px"><input type="radio" name="chose_new_card" id="chose_new_card" onclick="check_radio_new(<?php echo $count_all_cards;?>)">&nbsp;&nbsp;Add New Card</p>

					 <div class="clearfix"></div>
					 <input type="hidden" name="amount" id="pay_amount" value="" />
					 <input type="hidden" name="service_fee" id="service_fee" value="<?php echo $sitesetting['SiteSetting']['tax'];?>" />
					 <input type="hidden" name="request_id" id="request_id" value="" />
					 <input type="hidden" name="seller_first_name" id="seller_first_name" value="" />
					 <input type="hidden" name="seller_last_name" id="seller_last_name" value="" />
					 <input type="hidden" name="seller_email" id="seller_email" value="" />
					 <input type="hidden" name="seller_phone" id="seller_phone" value="" />
					 <input type="hidden" name="seller_dob" id="seller_dob" value="" />
					 <input type="hidden" name="seller_street_address" id="seller_street_address" value="" />
					 <input type="hidden" name="seller_region" id="seller_region" value="" />
					 <input type="hidden" name="seller_city" id="seller_city" value="" />
					 <input type="hidden" name="seller_zip" id="seller_zip" value="" />
					 <input type="hidden" name="maker_acno" id="maker_acno" value="" />
					 <input type="hidden" name="maker_rno" id="maker_rno" value="" />
                     <div id="previous_card_pay" style="display:none">
					  <input type="button" onclick="return pay_previous();" value="Make payment" class="social_btn sign_up_btnn" style="margin:20px auto 40px auto;display:block;width:289px;" id="purchase_gift_previous">
					  <img src="<?php echo $this->webroot;?>img/32.gif" border="0" alt="" style="display:none;margin: 20px auto 40px auto;" id="purchase_gift_load_previous">
					 </div>
					 <div id="new_card_pay" style="display:none">
					    <ul class="width270 float-left">
							<li>
								<p>Card number</p>
								<div class="inputgreybox"><input type="text" id="card_number" name="card_number" autocomplete="off"></div>
								<span id="card_number_err" style="color:red"></span>
							</li>
							<li>
								<p>CVV number</p>
								<div class="inputgreybox"><input type="password" id="cvv" name="cvv" autocomplete="off"></div>
								<span id="cvv_err" style="color:red"></span>
							</li>
						</ul>
						<ul class="width270 float-right">
							<li>
								<p>Payment type</p>
								<p>
									<a href="#"><img src="<?php echo $this->webroot;?>img/visa.png" alt=""></a>
									<a href="#"><img src="<?php echo $this->webroot;?>img/mastercard.png" alt=""></a>
									<a href="#"><img src="<?php echo $this->webroot;?>img/paypal.png" alt=""></a>
								<p>
							</li>
							 <li>
								<p>Expires on</p>
								<div class="half_div float-left">
									<div class="selectgreybox">
									  <select name="month" style="width:130%;">
										<?php 
											for( $month_num=1; $month_num<=12; $month_num++)
											{
											?>
												<option value="<?php echo $month_num; ?>"><?php echo $month_num; ?></option>
											<?php
											}
										?>
									  </select>
									</div>
								</div>
								<div class="half_div float-right">
									<div class="selectgreybox">
									  <select name="year" style="width:130%;">
											<?php 
												$cur_year=date('Y');
												for( $year_num=$cur_year; $year_num<=$cur_year+40; $year_num++)
												{
												?>
													<option value="<?php echo $year_num; ?>"><?php echo $year_num; ?></option>
												<?php
												}
											?>
										</select>
									</div>
								</div>
							</li>
						</ul>
						<div class="clearfix"></div>
						<h2>Billing Address</h2>
						<ul class="width270 float-left">
							<li>
								<p>First name</p>
								<div class="inputgreybox"><input type="text" name="billing_first_name" id="billing_first_name" autocomplete="off"></div>
								<span id="bnamefirst_err" style="color:red"></span>
							</li>
							<li>
								<p>Street address</p>
								<div class="inputgreybox"><input type="text" name="billing_street_add" id="billing_street_add" autocomplete="off"></div>
								<span id="bstreetadd_err" style="color:red"></span>
							</li>
							<li>
								<p>City</p>
								<div class="inputgreybox"><input type="text" name="billing_city" id="billing_city" autocomplete="off"></div>
								<span id="bcity_err" style="color:red"></span>
							</li>
						</ul>
						<ul class="width270 float-right">
							<li>
								<p>Last name</p>
								<div class="inputgreybox"><input type="text" name="billing_last_name" id="billing_last_name" autocomplete="off"></div>
								<span id="bnamelast_err" style="color:red"></span>
							</li>
							<li>
								<div class="half_div float-left">
									<p>Apt#</p>
									<div class="inputgreybox"><input type="text"  name="billing_apt" id="billing_apt" autocomplete="off"></div>
								</div>
								<div class="half_div float-right">
									<p>State</p>
									<div class="inputgreybox"><input type="text" name="billing_state" id="billing_state" autocomplete="off"></div>
									<span id="bstate_err" style="color:red"></span>
								</div>
							</li>
							<li>
								<p>Postal code</p>
								<div class="inputgreybox"><input type="text" name="billing_post_code" id="billing_post_code" autocomplete="off"></div>
								<span id="bpostcode_err" style="color:red"></span>
							</li>
						</ul>
						<div class="clearfix"></div>
						<input type="button" onclick="return pay();" value="Make payment" class="social_btn sign_up_btnn" style="margin:20px auto 40px auto;display:block;width:289px;" id="purchase_gift">
						<img src="<?php echo $this->webroot;?>img/32.gif" border="0" alt="" style="display:none;margin: 20px auto 40px auto;" id="purchase_gift_load">
					  </div>
					 </div>
					<?php }else{?>
					   <ul class="width270 float-left" style="margin-bottom:10px">
						    <li>
								<p>Payment type</p>
								<div class="selectgreybox">
									<select name="crd_type" id="crd_type" onchange="chose_crd_type(this.value)">
										<option value="">Select type</option>
										<option value="creditcard">Credit Card</option>
										<option value="paypal">Paypal</option>
									</select>
								</div>
						    </li>
						</ul>
						<ul class="width270 float-right">
							<li>
								<p>Available Payment type</p>
								<p>
									<a href="#"><img src="<?php echo $this->webroot;?>img/visa.png" alt=""></a>
									<a href="#"><img src="<?php echo $this->webroot;?>img/mastercard.png" alt=""></a>
									<a href="#"><img src="<?php echo $this->webroot;?>img/paypal.png" alt=""></a>
								<p>
							</li>
						</ul>
						<div class="clearfix"></div>
						<div id="pay_type_paypal" style="display:none">
						   <ul class="width270 float-left">
								<li>
									<p>Paypal email</p>
									<div class="inputgreybox"><input type="text" id="paypal_email_field" name="paypal_email_field" autocomplete="off"></div>
									<span id="paypal_email_field_err" style="color:red"></span>
								</li>
							</ul>
							<ul class="width270 float-right">
								<li>
									<p>Payment type</p>
									<p>
										<a href="#"><img src="<?php echo $this->webroot;?>img/paypal.png" alt=""></a>
									<p>
								</li>
							</ul>
							<div class="clearfix"></div>
							<input type="button" onclick="return pay_paypal();" value="Make payment" class="social_btn sign_up_btnn" style="margin:20px auto 40px auto;display:block;width:289px;" id="purchase_giftp">
							<img src="<?php echo $this->webroot;?>img/32.gif" border="0" alt="" style="display:none;margin: 20px auto 40px auto;" id="purchase_gift_loadp">
					  </div>
					  <div id="pay_type_card" style="display:none">
						<ul class="width270 float-left">
							<li>
								<p>Card number</p>
								<div class="inputgreybox"><input type="text" id="card_number" name="card_number" autocomplete="off"></div>
								<span id="card_number_err" style="color:red"></span>
							</li>
							<li>
								<p>CVV number</p>
								<div class="inputgreybox"><input type="password" id="cvv" name="cvv" autocomplete="off"></div>
								<span id="cvv_err" style="color:red"></span>
							</li>
						</ul>
						<ul class="width270 float-right">
							<li>
								<p>Payment type</p>
								<p>
									<a href="#"><img src="<?php echo $this->webroot;?>img/visa.png" alt=""></a>
									<a href="#"><img src="<?php echo $this->webroot;?>img/mastercard.png" alt=""></a>
									<a href="<?php echo $this->webroot;?>users/paybypaypal"><img src="<?php echo $this->webroot;?>img/paypal.png" alt=""></a>
								<p>
							</li>
							 <li>
								<p>Expires on</p>
								<div class="half_div float-left">
									<div class="selectgreybox">
									  <select name="month" style="width:130%;">
										<?php 
											for( $month_num=1; $month_num<=12; $month_num++)
											{
											?>
												<option value="<?php echo $month_num; ?>"><?php echo $month_num; ?></option>
											<?php
											}
										?>
									  </select>
									</div>
								</div>
								<div class="half_div float-right">
									<div class="selectgreybox">
									  <select name="year" style="width:130%;">
											<?php 
												$cur_year=date('Y');
												for( $year_num=$cur_year; $year_num<=$cur_year+40; $year_num++)
												{
												?>
													<option value="<?php echo $year_num; ?>"><?php echo $year_num; ?></option>
												<?php
												}
											?>
										</select>
									</div>
								</div>
							</li>
						  
						</ul>
						<div class="clearfix"></div>
						<h2>Billing Address</h2>
						<ul class="width270 float-left">
							<li>
								<p>First name</p>
								<div class="inputgreybox"><input type="text" name="billing_first_name" id="billing_first_name" autocomplete="off"></div>
								<span id="bnamefirst_err" style="color:red"></span>
							</li>
							<li>
								<p>Street address</p>
								<div class="inputgreybox"><input type="text" name="billing_street_add" id="billing_street_add" autocomplete="off"></div>
								<span id="bstreetadd_err" style="color:red"></span>
							</li>
							<li>
								<p>City</p>
								<div class="inputgreybox"><input type="text" name="billing_city" id="billing_city" autocomplete="off"></div>
								<span id="bcity_err" style="color:red"></span>
							</li>
						</ul>
						<ul class="width270 float-right">
							<li>
								<p>Last name</p>
								<div class="inputgreybox"><input type="text" name="billing_last_name" id="billing_last_name" autocomplete="off"></div>
								<span id="bnamelast_err" style="color:red"></span>
							</li>
							<li>
								<div class="half_div float-left">
									<p>Apt#</p>
									<div class="inputgreybox"><input type="text"  name="billing_apt" id="billing_apt" autocomplete="off"></div>
								</div>
								<div class="half_div float-right">
									<p>State</p>
									<div class="inputgreybox"><input type="text" name="billing_state" id="billing_state" autocomplete="off"></div>
									<span id="bstate_err" style="color:red"></span>
								</div>
							</li>
							<li>
								<p>Postal code</p>
								<div class="inputgreybox"><input type="text" name="billing_post_code" id="billing_post_code" autocomplete="off"></div>
								<span id="bpostcode_err" style="color:red"></span>
							</li>
						</ul>
						<div class="clearfix"></div>
						<input type="hidden" name="amount" id="pay_amount" value="" />
						<input type="hidden" name="service_fee" id="service_fee" value="<?php echo $sitesetting['SiteSetting']['tax'];?>" />
						<input type="hidden" name="request_id" id="request_id" value="" />
						<input type="hidden" name="seller_first_name" id="seller_first_name" value="" />
						<input type="hidden" name="seller_last_name" id="seller_last_name" value="" />
						<input type="hidden" name="seller_email" id="seller_email" value="" />
						<input type="hidden" name="seller_phone" id="seller_phone" value="" />
						<input type="hidden" name="seller_dob" id="seller_dob" value="" />
						<input type="hidden" name="seller_street_address" id="seller_street_address" value="" />
						<input type="hidden" name="seller_region" id="seller_region" value="" />
						<input type="hidden" name="seller_city" id="seller_city" value="" />
						<input type="hidden" name="seller_zip" id="seller_zip" value="" />
						<input type="hidden" name="maker_acno" id="maker_acno" value="" />
						<input type="hidden" name="maker_rno" id="maker_rno" value="" />
						<input type="button" onclick="return pay();" value="Make payment" class="social_btn sign_up_btnn" style="margin:20px auto 40px auto;display:block;width:289px;" id="purchase_gift">
						<img src="<?php echo $this->webroot;?>img/32.gif" border="0" alt="" style="display:none;margin: 20px auto 40px auto;" id="purchase_gift_load">
					</div>
				<?php } ?>
    	</div>
	 </form>
   </div>
</div>
   <div class="sign_up_holder" id="sign_up_login"></div>
<div class="container_960">
	<?php echo $this->element('user_leftbar'); ?>
	<div class="dash_right pull-right">
		<div class="dash_right_head">
			<h2>My Workshops</h2>
			<ul class="workshop">
				<li class="active" id="attndli"><a href="<?php echo $this->webroot;?>users/my_workshops" style="color:#000">Workshops I attend</a></li>
				<li id="hostli"><a href="<?php echo $this->webroot;?>users/my_workshop_host" style="color:#000">Workshops I host</a></li>
			</ul>
		</div>
		<?php if(!empty($workshopattends)){ ?>
		   <div class="dash_2_page" id="workshopattend">
		   <div class="dash_2_page_left pull-left">
		<?php }else{ ?>
		  <div class="dash_2_page" id="workshopattend" style="width:100%">
		  <div class="dash_2_page_left pull-left" style="width:100%">
		<?php } ?>
			
				<div id="tabs-container_1">
					<ul class="tabs-menu_1">
						<li class=""><a href="#">All</a></li>
						<li class="current"></li>
					</ul>
				<div class="tab_1">
					<div id="tab-1" class="tab-content_1">
						<ul>
						   <?php 
						     if(!empty($workshopattends)){ 
								 foreach($workshopattends as $workshopattend){
                                $is_invoice=$this->requestAction('users/getinvoicedetails/'.$workshopattend['Request']['id']);
									 $today=date('Y-m-d');
								if(!empty($is_invoice)){
						   ?>
							<a href="<?php echo $this->webroot.'users/my_workshops/'.base64_encode($workshopattend['Request']['id']).''; ?>"><li>
							   <?php if(strtotime($today) < strtotime($workshopattend['Request']['request_date'])){ ?>
								<div class="up_coming"><img src="<?php echo $this->webroot;?>img/upcoming.png" alt="Upcoming"/></div>
							   <?php } ?>
								<?php
								 $mimg=$this->requestAction('users/getmakerimage/'.$workshopattend['Request']['maker']);
								 if(isset($mimg) && $mimg!='')
								 {
								?>
								   <img src="<?php echo $this->webroot; ?>user_images/<?php echo $mimg;?>" class="img_pro"/>
								<?php }else{ ?>
								   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" class="img_pro"/>
								<?php } ?>
								<aside>
									<b><?php echo $this->requestAction('users/getskillname/'.$workshopattend['Request']['skill_id'])?></b>
									<p><?php echo $this->requestAction('users/getmakername/'.$workshopattend['Request']['maker'])?></p>
									<span>
									<?php echo date('M d Y',strtotime($workshopattend['Request']['request_date']));?><br/>
									<?php if(strtotime($today) > strtotime($workshopattend['Request']['request_date'])){ ?>
									  <a href="javascript:void(0)" style="color:blue">Write review</a><br/>
									<?php } ?>
									</span>
								</aside>
								<?php if($workshopattend['Request']['is_paid']==0)
								{?>
								  <img src="<?php echo $this->webroot;?>img/pay_now.png" alt="pay_now" class="paid"/>
                                <?php }else{ ?>
								  <img src="<?php echo $this->webroot;?>img/paid.png" alt="paid" class="paid"/>
								<?php } ?>
							</li></a>
							<?php }}}else{ ?>
							 <li>
							  No workshop found.
							 </li>
							<?php } ?>
						</ul>
					</div>
				</div>
				</div>
			</div>
			<?php 
			  if(!empty($workshopattends)){ 
			   if(isset($this->params['pass'][0]) && $this->params['pass'][0]!=''){
               $invoice_details=$this->requestAction('users/getinvoicedetails/'.$particularworkshop['Request']['id']);
			   if(!empty($invoice_details)){
				    $userdetails=$this->requestAction('users/getuserdetails/'.$invoice_details['Invoice']['maker_id']);
					$review_details1=$this->requestAction('users/getreviews/'.$particularworkshop['Request']['id']);
			?>
			<div class="dash_2_page_right pull-right">
				<div class="new_work_head">
					<?php
					 $mimg=$this->requestAction('users/getmakerimage/'.$particularworkshop['Request']['maker']);
					 if(isset($mimg) && $mimg!='')
					 {
					?>
					   <img src="<?php echo $this->webroot; ?>user_images/<?php echo $mimg;?>" class="img_pro"/>
					<?php }else{ ?>
					   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" class="img_pro"/>
					<?php } ?>
					<h2><?php echo $invoice_details['Invoice']['invoice_name'];?></h2>
				</div>
				<div class="time_of_workshop">
					<p><?php echo $invoice_details['Invoice']['how_long'];?> workshop</p>
					<p>Extra cost</p>
				</div>
				<div class="total_pay">
					<p>Total</p>
					<?php 
					if($particularworkshop['Request']['is_paid']==0)
					{ ?>      
							<input type="button" class="btn border_btn offer_my_skill pay_btn" value="Pay" onclick="payment(<?=$invoice_details['Invoice']['how_mutch'];?>,<?=$invoice_details['Request']['id'];?>,'<?=$userdetails['User']['first_name'];?>','<?=$userdetails['User']['last_name'];?>','<?=$userdetails['User']['email'];?>','<?=$userdetails['User']['seller_phone'];?>','<?=$userdetails['User']['dob'];?>','<?=base64_encode($userdetails['User']['seller_account_number']);?>','<?=base64_encode($userdetails['User']['seller_routing_number']);?>','<?=$userdetails['User']['seller_street_address'];?>','<?=$userdetails['User']['seller_region'];?>','<?=$userdetails['User']['seller_city'];?>','<?=$userdetails['User']['seller_zip'];?>')">
					  <?php } 
					  else{?>
						 <input type="button" class="btn border_btn offer_my_skill pay_btn" value="Paid"  disabled style="background:green;border:0"/>
					  <?php
					  }
					 ?>	
					  
					<strong>$ <?php echo $invoice_details['Invoice']['how_mutch'];?></strong>
				</div>
				<ul class="pay_timing" style="list-style:none">
					<li><img src="<?php echo $this->webroot?>img/spite_clock.png" alt="Clock" /><span><?php echo $invoice_details['Request']['request_time'];?>  <?php echo $invoice_details['Request']['request_time_format'];?></span></li>
					<li><img src="<?php echo $this->webroot?>img/spite_list.png" alt="List" /><span> <?php echo date('M d Y',strtotime($invoice_details['Request']['request_date']));?></span></li>
                   <?php 
					if($particularworkshop['Request']['is_paid']!=0)
					{ ?>
					<li><img src="<?php echo $this->webroot?>img/spite_call.png" alt="Call" /><span><?php echo $userdetails['User']['seller_phone'];?></span></li>
				   <?php } ?>

					<li><img src="<?php echo $this->webroot?>img/spite_msg.png" alt="Msg"/><span><a href="<?php echo $this->webroot;?>users/messages">See all contact with person</a></span></li>
				</ul>
				<div class="dash_1_map" id="profile_map">
				</div>
				<div class="das_2_des">
					<?php 
					if($particularworkshop['Request']['is_paid']==0)
					{ ?>
					  <p>The exact location will be revealed once the payment is made.</p>
					<?php }else{ ?>
					  <p><?php echo $particularworkshop['Skill']['skill_workshop_address'];?></p>
                    <?php } ?>
					<p><?php echo nl2br($invoice_details['Invoice']['message']);?></p>
					<?php $today=date('Y-m-d');if(strtotime($today) > strtotime($invoice_details['Request']['request_date'])){ ?>

					<form name="review" method="post" action="<?php echo $this->webroot;?>users/post_review/<?php echo $particularworkshop['Request']['id'];?>">
					<strong>Review</strong><br/>
					<?php if(!empty($review_details1)){
					 foreach($review_details1 as $review_detail1){
					 $userdetailsr=$this->requestAction('users/getuserdetails/'.$review_detail1['Review']['reviewer']);
					?>
					 <p><?php
					 if(isset($userdetailsr['User']['profile_image']) && $userdetailsr['User']['profile_image']!='')
					 {
					?>
					   <img src="<?php echo $this->webroot; ?>user_images/<?php echo $userdetailsr['User']['profile_image'];?>" class="img_pro" style="width:22px;height:22px;border-radius:100%"/>
					<?php }else{ ?>
					   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" class="img_pro" style="width:22px;height:22px;border-radius:100%"/>
					<?php } ?>
					&nbsp;&nbsp;<b><?php echo $userdetailsr['User']['first_name'].' '.$userdetailsr['User']['last_name'];?></b><span style="float:right"><?php echo date('M d, Y',strtotime($review_detail1['Review']['date']));?></span></p>
					 <p style="margin-bottom:20px;border-bottom:1px solid #e8e8e8"><?php echo nl2br($review_detail1['Review']['comment']);?></p>
					<?php }} ?>
					<div class="fields new_w_text">
						<textarea name="data[review]" id="review_textarea" style="height:111px"></textarea>
						<input type="hidden" name="data[maker]" value="<?php echo $particularworkshop['Request']['maker'];?>">
					</div>
					<strong>Upload pictures of your space and tools</strong>
					<div class="fields" style="position:relative">
						<div id="preview_overlay" style="position:absolute;background: url(<?php echo($this->webroot);?>img/prevback.png) repeat;width:100%;height:100%;z-index:999999;display:none;">
							   <div style=" color: #fff;display: block;font-size: 22px;font-weight: bold;margin: 2% auto 0;text-align: center;">
								Please wait while uploading...
							   </div>
							   <img src="<?php echo($this->webroot);?>img/green-ajax-loader.gif" style="display:block;margin:0 auto;"/>
						  </div>
						<ul class="up_image">
						
							<div id="Preview">
							</div>
						 
							<li><img src="<?php echo $this->webroot; ?>img/big_plus.png" alt="Add Pics" onclick="performClick5()" style="cursor:pointer"/></li>
						</ul>
						  <input type="file" id="theFile5" name="photos[]" style="display:none;" multiple="true"/>
						
						  <input type="hidden" name="data[Request][picnum]" value="0" id="picnum"/>
						  <input type="hidden" name="data[Request][totalpics]" value="0" id="totalpics"/>
						  
					</div>
					<input class="btn border_btn offer_my_skill pay_btn" type="submit" value="Post review" onclick="return review_validate();" id="post_review">
					</form>
                  <?php } ?>
				</div>
			</div>
		  <?php }}else{ 
		   $invoice_details=$this->requestAction('users/getinvoicedetails/'.$workshopattends[0]['Request']['id']);
		   if(!empty($invoice_details)){
			   $userdetails=$this->requestAction('users/getuserdetails/'.$invoice_details['Invoice']['maker_id']);
			   $review_details1=$this->requestAction('users/getreviews/'.$workshopattends[0]['Request']['id']);
		  ?>
		    <div class="dash_2_page_right pull-right">
				<div class="new_work_head">
					<?php
					 $mimg=$this->requestAction('users/getmakerimage/'.$workshopattends[0]['Request']['maker']);
					 if(isset($mimg) && $mimg!='')
					 {
					?>
					   <img src="<?php echo $this->webroot; ?>user_images/<?php echo $mimg;?>" class="img_pro"/>
					<?php }else{ ?>
					   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" class="img_pro"/>
					<?php } ?>
					<h2><?php echo $invoice_details['Invoice']['invoice_name'];?></h2>
				</div>
				<div class="time_of_workshop">
					<p><?php echo $invoice_details['Invoice']['how_long'];?> workshop</p>
					<p>Extra cost</p>
				</div>
				<div class="total_pay">
					<p>Total</p>
					<?php 
					if($workshopattends[0]['Request']['is_paid']==0)
					{ ?>      
							<input type="button" class="btn border_btn offer_my_skill pay_btn" value="Pay" onclick="payment(<?=$invoice_details['Invoice']['how_mutch'];?>,<?=$invoice_details['Request']['id'];?>,'<?=$userdetails['User']['first_name'];?>','<?=$userdetails['User']['last_name'];?>','<?=$userdetails['User']['email'];?>','<?=$userdetails['User']['seller_phone'];?>','<?=$userdetails['User']['dob'];?>','<?=base64_encode($userdetails['User']['seller_account_number']);?>','<?=base64_encode($userdetails['User']['seller_routing_number']);?>','<?=$userdetails['User']['seller_street_address'];?>','<?=$userdetails['User']['seller_region'];?>','<?=$userdetails['User']['seller_city'];?>','<?=$userdetails['User']['seller_zip'];?>')">
					  <?php } 
					  else{?>
						 <input type="button" class="btn border_btn offer_my_skill pay_btn" value="Paid"  disabled style="background:green;border:0"/>
					  <?php
					  }
					 ?>	
					  
					<strong>$ <?php echo $invoice_details['Invoice']['how_mutch'];?></strong>
				</div>
				<ul class="pay_timing" style="list-style:none">
					<li><img src="<?php echo $this->webroot?>img/spite_clock.png" alt="Clock" /><span><?php echo $invoice_details['Request']['request_time'];?>  <?php echo $invoice_details['Request']['request_time_format'];?></span></li>
					<li><img src="<?php echo $this->webroot?>img/spite_list.png" alt="List" /><span> <?php echo date('M d Y',strtotime($invoice_details['Request']['request_date']));?></span></li>
                   <?php 
					if($workshopattends[0]['Request']['is_paid']!=0)
					{ ?>
					<li><img src="<?php echo $this->webroot?>img/spite_call.png" alt="Call" /><span><?php echo $userdetails['User']['seller_phone'];?></span></li>
				   <?php } ?>

					<li><img src="<?php echo $this->webroot?>img/spite_msg.png" alt="Msg"/><span><a href="<?php echo $this->webroot;?>users/messages">See all contact with person</a></span></li>
				</ul>
				<div class="dash_1_map" id="profile_map">
				</div>
				<div class="das_2_des">
				    <?php 
					if($workshopattends[0]['Request']['is_paid']==0)
					{ ?>
					  <p>The exact location will be revealed once the payment is made.</p>
					<?php }else{ ?>
					  <p><?php echo $workshopattends[0]['Skill']['skill_workshop_address'];?></p>
                    <?php } ?>
					
					<p><?php echo nl2br($invoice_details['Invoice']['message']);?></p>
					

					<?php $today=date('Y-m-d');if(strtotime($today) > strtotime($invoice_details['Request']['request_date'])){ ?>
					<form name="review" method="post" action="<?php echo $this->webroot;?>users/post_review/<?php echo $workshopattends[0]['Request']['id'];?>">
					<strong>Review</strong><br/>
					<?php if(!empty($review_details1)){
					 foreach($review_details1 as $review_detail1){
					 $userdetailsr=$this->requestAction('users/getuserdetails/'.$review_detail1['Review']['reviewer']);
					?>
					 <p><?php
					 if(isset($userdetailsr['User']['profile_image']) && $userdetailsr['User']['profile_image']!='')
					 {
					?>
					   <img src="<?php echo $this->webroot; ?>user_images/<?php echo $userdetailsr['User']['profile_image'];?>" class="img_pro" style="width:22px;height:22px;border-radius:100%"/>
					<?php }else{ ?>
					   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" class="img_pro" style="width:22px;height:22px;border-radius:100%"/>
					<?php } ?>
					&nbsp;&nbsp;<b><?php echo $userdetailsr['User']['first_name'].' '.$userdetailsr['User']['last_name'];?></b> <span style="float:right"><?php echo date('M d, Y',strtotime($review_detail1['Review']['date']));?></span></p>
					 <p style="margin-bottom:20px;border-bottom:1px solid #e8e8e8"><?php echo nl2br($review_detail1['Review']['comment']);?></p>
					<?php }} ?>
					<div class="fields new_w_text">
						<textarea name="data[review]" id="review_textarea" style="height:111px"></textarea>
						<input type="hidden" name="data[maker]" value="<?php echo $workshopattends[0]['Request']['maker'];?>">
					</div>
					<strong>Upload pictures of your space and tools</strong>
					<div class="fields" style="position:relative">
						<div id="preview_overlay" style="position:absolute;background: url(<?php echo($this->webroot);?>img/prevback.png) repeat;width:100%;height:100%;z-index:999999;display:none;">
							   <div style=" color: #fff;display: block;font-size: 22px;font-weight: bold;margin: 2% auto 0;text-align: center;">
								Please wait while uploading...
							   </div>
							   <img src="<?php echo($this->webroot);?>img/green-ajax-loader.gif" style="display:block;margin:0 auto;"/>
						  </div>
						  <div id="Preview">
							</div>
						<ul class="up_image">
							<li><img src="<?php echo $this->webroot; ?>img/big_plus.png" alt="Add Pics" onclick="performClick5()" style="cursor:pointer"/></li>
						</ul>
						  <input type="file" id="theFile5" name="photos[]" style="display:none;" multiple="true"/>
						
						  <input type="hidden" name="data[Request][picnum]" value="0" id="picnum"/>
						  <input type="hidden" name="data[Request][totalpics]" value="0" id="totalpics"/>

					</div>
					<input class="btn border_btn offer_my_skill pay_btn" type="submit" value="Post review" onclick="return review_validate();" id="post_review">
					</form>
                  <?php } ?>
				</div>
			</div>
		  <?php }}} ?>
		</div>
		</div>
	</div>
</div>
<style>
#profile_map img { max-width: inherit; border-radius:0px !important;}
#profile_map{height:361px !important}
</style>
<?php echo $this->Html->scriptStart(array('inline'=>false));?>
function performClick5() {
	$('#theFile5').click();
}


function review_validate()
{
  var review_textarea=$('#review_textarea').val();
 
  if(review_textarea=='')
  {
	  $('#review_textarea').css({"border":"1px solid red"});
  }
  else
  {
	 $('#review_textarea').css({"border":"0px solid red"});
  }
  if(review_textarea=='')
  {    
	return false;
  }
  else
  {
    return true;
  }
}
    var marker;
	var geocoder = new google.maps.Geocoder();
	initialize_profile();
	function initialize_profile(lat,lng) 
	{
		lat='<?php echo $skill_lat;?>';
		lng='<?php echo $skill_lang;?>';
		var myLatLng = new google.maps.LatLng(lat,lng);

	   <?php if($invoice_details['Request']['is_paid']==0){ ?>
	    var mapOptions = {
		    scrollwheel: false,
			zoom: 13,
			center: myLatLng,
			mapTypeId: google.maps.MapTypeId.RoadMap
		};

		var map = new google.maps.Map(document.getElementById('profile_map'),mapOptions);
		var circle = new google.maps.Circle({
		  scrollwheel: false,
		  center: myLatLng,
		  radius: 2000,     // 10 miles in metres
		  mapTypeId: google.maps.MapTypeId.RoadMap,
		  strokeColor: "#4743e2",
		  strokeOpacity: 0.8,
		  strokeWeight: 2,
		  fillColor: "#4743e2",
		  fillOpacity: 0.35,
		  map: map
		});
	   <?php }else{ ?>
	    var mapOptions = {
		    scrollwheel: false,
			zoom: 14,
			center: myLatLng,
			mapTypeId: google.maps.MapTypeId.RoadMap
		};

		var map = new google.maps.Map(document.getElementById('profile_map'),mapOptions);
	    var image = '<?php echo $this->webroot;?>img/mapmarker.png';
	   <?php } ?>
		var contentString = '';

	    var infowindow = new google.maps.InfoWindow({
			  content: contentString
		});

		marker = new google.maps.Marker({
			position: map.getCenter(),
			map: map,
			icon: image
		});
	}

<?php echo $this->Html->scriptEnd();?>
<script>
 function chose_crd_type(val)
  {
	  if(val=='creditcard')
	  {
        $('#pay_type_paypal').hide();
		$('#pay_type_card').show();
	  }
	  else if(val=='paypal')
	  {
        $('#pay_type_paypal').show();
		$('#pay_type_card').hide();
	  }
  }
 function check_radio(no,idn)
  {
	 $('#chose_new_card').prop('checked', false);
	 for(var ic=1;ic<=no;ic++)
	 {
	   if(idn != ic)
	   {
	     $('#chose_card'+ic).prop('checked', false);
	   }
	 }
	 $('#braintree_customer_id_token').val($('#chose_card'+idn).val());
	 $('#previous_card_pay').show();
	 $('#new_card_pay').hide();
  }
  function check_radio_new(no)
  {
	 for(var ic=1;ic<=no;ic++)
	 {
	     $('#chose_card'+ic).prop('checked', false);
	 }
	 $('#braintree_customer_id_token').val('');
	 $('#previous_card_pay').hide();
	 $('#new_card_pay').show();
  }
function payment(amount,request_id,first_name,last_name,email,phone,dob,ac_no,r_no,seller_street_address,seller_region,seller_city,seller_zip)
  {
	$("html, body").animate({ scrollTop: "100px" });
	$('#absolute_login #pay_amount').val(amount);
	$('#request_id').val(request_id);
	$('#seller_first_name').val(first_name);
	$('#seller_last_name').val(last_name);
	$('#seller_email').val(email);
	$('#seller_phone').val(phone);
	$('#seller_dob').val(dob);
	$('#seller_street_address').val(seller_street_address);
	$('#seller_region').val(seller_region);
	$('#seller_city').val(seller_city);
	$('#seller_zip').val(seller_zip);
	$('#maker_acno').val(ac_no);
	$('#maker_rno').val(r_no);
    $("#sign_up_login").show("fast");
    $("#absolute_login").fadeIn("slow");
  }
  function pay_previous()
  {
	 $('#purchase_gift_previous').hide();
	 $('#purchase_gift_load_previous').css("display","block"); 
	 $.ajax({
			type:"post",
			dataType:"json",
			url: '<?php echo $this->webroot.'braintree/transaction_exist.php'; ?>',
			data: $('#payment_form').serialize(),
			success: function(data) {
				if(data.status=="success")
				{
						console.log(data);
						$.ajax({
						type:"post",
						dataType:"json",
						url: '<?php echo $this->webroot.'requests/save_transaction_exist'; ?>',
						data: {request_id:$('#request_id').val(),amount:$('#absolute_login #pay_amount').val(),transaction_id:data.transaction_id},
						success: function(d) {
							    $("#absolute_login").fadeOut("slow");
					            $("#sign_up_login").hide("fast");
								bootbox.alert("Payment successfull.",function() {
								location.reload();
							});
						}
						});
				}
				else
				{   
					$("#absolute_login").fadeOut("slow");
					$("#sign_up_login").hide("fast");
					console.log(data);
					bootbox.alert(data.err_msg);
				}
			}
		});
  }
  function pay()
  {
	var card_number=$('#card_number').val();
	var cvv_number=$('#cvv').val();
	var billing_first_name=$('#billing_first_name').val();
	var billing_last_name=$('#billing_last_name').val();
	var billing_street_add=$('#billing_street_add').val();
	var billing_city=$('#billing_city').val();
	var billing_state=$('#billing_state').val();
	var billing_post_code=$('#billing_post_code').val();

	if(card_number=='')
    {
	  $('#card_number').css({"border":"1px solid red"});
	  $('#card_number_err').html('Please enter your card number');
    }
    else
    {
	  $('#card_number').css({"border":"0px"});
	  $('#card_number_err').html('');
    }
	if(cvv_number=='')
    {
	  $('#cvv').css({"border":"1px solid red"});
	  $('#cvv_err').html('Please enter cvv number');
    }
    else
    {
	  $('#cvv').css({"border":"0px"});
	  $('#cvv_err').html('');
    }
	if(billing_first_name=='')
    {
	  $('#billing_first_name').css({"border":"1px solid red"});
	  $('#bnamefirst_err').html('Please enter your first name');
    }
    else
    {
	  $('#billing_first_name').css({"border":"0px"});
	  $('#bnamefirst_err').html('');
    }
	if(billing_last_name=='')
    {
	  $('#billing_last_name').css({"border":"1px solid red"});
	  $('#bnamelast_err').html('Please enter your last name');
    }
    else
    {
	  $('#billing_last_name').css({"border":"0px"});
	  $('#bnamelast_err').html('');
    }
	if(billing_street_add=='')
    {
	  $('#billing_street_add').css({"border":"1px solid red"});
	  $('#bstreetadd_err').html('Please enter street address');
    }
    else
    {
	  $('#billing_street_add').css({"border":"0px"});
	  $('#bstreetadd_err').html('');
    }
	if(billing_city=='')
    {
	  $('#billing_city').css({"border":"1px solid red"});
	  $('#bcity_err').html('Please enter your city');
    }
    else
    {
	  $('#billing_city').css({"border":"0px"});
	  $('#bcity_err').html('');
    }
	if(billing_state=='')
    {
	  $('#billing_state').css({"border":"1px solid red"});
	  $('#bstate_err').html('Please enter your state');
    }
    else
    {
	  $('#billing_state').css({"border":"0px"});
	  $('#bstate_err').html('');
    }
	if(billing_post_code=='')
    {
	  $('#billing_post_code').css({"border":"1px solid red"});
	  $('#bpostcode_err').html('Please enter your postal code');
    }
    else
    {
	  $('#billing_post_code').css({"border":"0px"});
	  $('#bpostcode_err').html('');
    }
	
	if((cvv_number!='') && (card_number!='') && (billing_first_name!='') && (billing_last_name!='') && (billing_street_add!='') && (billing_city!='') && (billing_state!='') && (billing_post_code!=''))
	{
	 $('#purchase_gift').hide();
	 $('#purchase_gift_load').css("display","block"); 
	 $.ajax({
			type:"post",
			dataType:"json",
			url: '<?php echo $this->webroot.'braintree/transaction.php'; ?>',
			data: $('#payment_form').serialize(),
			success: function(data) {
				if(data.status=="success")
				{
						console.log(data);
						$.ajax({
						type:"post",
						dataType:"json",
						url: '<?php echo $this->webroot.'requests/save_transaction'; ?>',
						data: {request_id:$('#request_id').val(),amount:$('#absolute_login #pay_amount').val(),transaction_id:data.transaction_id,billing_first_name:billing_first_name,billing_last_name:billing_last_name,billing_street_add:billing_street_add,billing_city:billing_city,billing_state:billing_state,billing_post_code:billing_post_code},
						success: function(d) {
							    $("#absolute_login").fadeOut("slow");
					            $("#sign_up_login").hide("fast");
							    bootbox.alert("Payment successfull.",function() {
								location.reload();
							});
						}
						});
				}
				else
				{   
					$("#absolute_login").fadeOut("slow");
					$("#sign_up_login").hide("fast");
					console.log(data);
					bootbox.alert(data.err_msg);
				}
			}
		});
	}
  }
  function pay_paypal()
  {
    var paypal_email_field=$('#paypal_email_field').val();
	var amount=$('#pay_amount').val();
	var service_fee=$('#service_fee').val();
	var request_id=$('#request_id').val();
	if(paypal_email_field=='')
    {
	  $('#paypal_email_field').css({"border":"1px solid red"});
	  $('#paypal_email_field_err').html('Please enter paypal email');
    }
    else
    {
	  $('#paypal_email_field').css({"border":"0px"});
	  $('#paypal_email_field_err').html('');
    }
	if(paypal_email_field!='')
	{
         var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
         if (filter.test(paypal_email_field)) 
		 {
		   $('#purchase_giftp').hide();
	       $('#purchase_gift_loadp').css("display","block"); 
		   $.post('<?php echo($this->webroot);?>users/paybypaypal/'+paypal_email_field+'/'+amount+'/'+service_fee+'/'+request_id, function(data){
               if(data=='failure')
			   {
                 bootbox.alert('Payment Failed. Please try again.');
				 $('#purchase_giftp').show();
	             $('#purchase_gift_loadp').css("display","none");
			   }
			   else
			   {
				   window.location.href=data;
			   }
			});
		 }
		 else
		 {
		   $('#paypal_email_field').css({"border":"1px solid red"});
	       $('#paypal_email_field_err').html('Please enter valid email');
		 }
	}
  }
</script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
 <script src="http://bootboxjs.com/vendor/js/bootstrap.min.js"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>