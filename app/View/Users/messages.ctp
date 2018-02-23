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
								<p>Card type</p>
								<p>
									<a href="#"><img src="<?php echo $this->webroot;?>img/visa.png" alt=""></a>
									<a href="#"><img src="<?php echo $this->webroot;?>img/mastercard.png" alt=""></a>
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
									<p>Card type</p>
									<p>
										<a href="#"><img src="<?php echo $this->webroot;?>img/visa.png" alt=""></a>
										<a href="#"><img src="<?php echo $this->webroot;?>img/mastercard.png" alt=""></a>
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
			<h2>Messages</h2>
		</div>
		<div class="left_message_box pull-left" style="<?=!count($inboxmessage)?'width:100%':'';?>">
			<ul>
				
			<?php if(!empty($inboxmessage)) { ?>
			<?php foreach ($inboxmessage as $k=>$inv_msg) { ?>
                <a href="<?php echo $this->webroot.'users/messages/'.base64_encode($inv_msg['InboxMessage']['id']).''; ?>">
                    <?php
                    if(isset($this->params['pass'][0]) && $this->params['pass'][0]!='')
                    {
                        if(base64_encode($inv_msg['InboxMessage']['id'])==$this->params['pass'][0])
                        {
                            $class='active';
                        }
                        else {$class='';}
						if($inv_msg['InboxMessage']['is_read']==1)
						{
                            $style='background-image:none';
						}
						else
						{
                            $style='background-image:url('.$this->webroot.'img/green_circle.png);background-position:2% center;background-repeat: no-repeat;';
						}
                    }
                    else if(!isset($this->params['pass'][0]))
                    {
                        if($k==0)
                        {
                            $class='active';
                        }
                        else {$class='';}
						if($inv_msg['InboxMessage']['is_read']==1)
						{
                            $style='background-image:none';
						}
						else
						{
                            $style='background-image:url('.$this->webroot.'img/green_circle.png);background-position:2% center;background-repeat: no-repeat;';
						}
                    }
                    
                    ?>           
                    
                    
             <li class="<?=$class?>" style="<?=$style?>">
					<?php
						$inboxdetails1=$this->requestAction('users/getinboxdetails/'.$inv_msg['InboxMessage']['id']);
					?>
				     <?php
				     if(isset($inv_msg['User']['profile_image']) && $inv_msg['User']['profile_image']!='')
	                 {
				    ?>
 				       <img src="<?php echo $this->webroot; ?>user_images/<?php echo $inv_msg['User']['profile_image'];?>" alt="<?php echo $inv_msg['User']['first_name'];?>" />
					<?php }else{ ?>
					   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" alt="<?php echo $inv_msg['User']['first_name'];?>" />
					<?php } ?>
                                        
				   <aside>
						<p><?=$inv_msg['User']['first_name'];?> <?=$inv_msg['User']['last_name'];?></p>
						
						<b><?=date('M d Y',strtotime($inboxdetails1[0]['SentMessage']['date_time']));?></b>
						<div class="clearfix"></div>	
						<span><?=strlen($inboxdetails1[0]['SentMessage']['message'])>30?substr($inboxdetails1[0]['SentMessage']['message'],0,30).'...':$inboxdetails1[0]['SentMessage']['message'];?></span>

					</aside>
				</li>
                                </a>
                                <?php } } else { ?>
                                <li>No messages found.</li>
                                <?php } ?>
			</ul>
		</div>
		<div class="right_message_box pull-right" style="<?=!count($inboxmessage)?'display:none':'';?>">
                    <div class="right_meaasge_inner">
    					<div class="right_meaasge_container" style="padding: 10px;width:100%;margin:0px" id="reply_div">
    					<?php
		
                                         if(!isset($this->params['pass'][0]))
                                                    {
                                                        $inbox_id=$inboxmessage[0]['InboxMessage']['id'];
                                                        $order_id=$inboxmessage[0]['Request']['id'];
                                                        if($inboxmessage[0]['InboxMessage']['user_id']!=$this->Session->read('Auth.User.id'))
                                                        {
                                                          $receiver_id=  $inboxmessage[0]['InboxMessage']['user_id'];
                                                        }
                                                        else
                                                        {
                                                          $receiver_id=  $inboxmessage[0]['InboxMessage']['sender'];  
                                                        }
                                                        
                                                    }
                                                    else
                                                    {
                                                         $inbox_id=base64_decode($this->params['pass'][0]);
                                                          $order_id=$get_particular_message[0]['Request']['id'];
                                                         if($get_particular_message[0]['InboxMessage']['user_id']!=$this->Session->read('Auth.User.id'))
                                                        {
                                                          $receiver_id=  $get_particular_message[0]['InboxMessage']['user_id'];
                                                        }
                                                        else
                                                        {
                                                          $receiver_id=  $get_particular_message[0]['InboxMessage']['sender'];  
                                                        }
                                                        
                                                    }
                                                    
                                         $inboxdetails=$this->requestAction('users/getinboxdetails1/'.$inbox_id);
                                         
                                         //print_r($inboxdetails);
                                        
                                        ?>	
    						
							<div class="clearfix"></div>
							
							<div class="text_fild_holder">
								
								
				    			
                                                        <form action="<?php echo $this->webroot.'users/sendreply/'.$inbox_id.''; ?>" method="post">	
				    			<div class="name lato_step_1_sec_1_small only_des">Reply:</div>
								<div class="fields">
				    			<textarea name="data[SentMessage][reply]" id="reply"></textarea>
				    			</div>
                                                        <input type="hidden" name="data[SentMessage][sender_id]" value="<?=$this->Session->read('Auth.User.id')?>">
				    		<input type="hidden" name="data[SentMessage][receiver_id]" value="<?=$receiver_id?>">	
                                                
                                                <input type="hidden" name="data[SentMessage][orderid]" value="<?=$order_id?>">	
                                                        
                                       <input type="submit" value="Respond" class="btn border_btn offer_my_skill pay_btn">
                                                        </form>
                    <?php
                    if(isset($this->params['pass'][0]) && $this->params['pass'][0]!='')
                    {   
                    if($get_particular_message[0]['Request']['maker']==$this->Session->read('Auth.User.id'))
                    {
                      $invoice_details=$this->requestAction('users/getinvoicedetails/'.$order_id);
                      if(empty($invoice_details)) { 
						  if($user['User']['is_profile_complete']==1){
                    ?>             
                       <input type="button" value="Generate Invoice" class="btn border_btn offer_my_skill pay_btn" id="inv_call">
					 <?php }else{ ?>
					   <input type="button" value="Generate Invoice" class="btn border_btn offer_my_skill pay_btn" onclick="javascript:alert('Please fill your payout info first');">
                    <?php }
                    }else{
						if($invoice_details['Request']['is_paid']==0){
					?>
					  <input type="button" value="Edit Invoice" class="btn border_btn offer_my_skill pay_btn" id="inv_call_edit">
					<?php } } }
                    }
                    else
                    {
                    if($inboxmessage[0]['Request']['maker']==$this->Session->read('Auth.User.id'))
                    {
                      $invoice_details=$this->requestAction('users/getinvoicedetails/'.$order_id);
                      if(empty($invoice_details)) { 
						  if($user['User']['is_profile_complete']==1){
                     ?>
                      <input type="button" value="Generate Invoice" class="btn border_btn offer_my_skill pay_btn" id="inv_call">
					 <?php }else{ ?>
					   <input type="button" value="Generate Invoice" class="btn border_btn offer_my_skill pay_btn" onclick="javascript:alert('Please fill your payout info first');">
                    <?php }
                    }else{
						if($invoice_details['Request']['is_paid']==0){
					?>
					   <input type="button" value="Edit Invoice" class="btn border_btn offer_my_skill pay_btn" id="inv_call_edit">
					<?php }}}
                    } 
                    ?>
			    			</div>
    					</div>
    				</div>

    			<!-- invoice div -->
                    <div class="right_meaasge_inner" id="invoice_div" style="display:none;">
    					<div class="right_meaasge_container">
    						<div class="message_head">
    					    <?php
							if(!isset($this->params['pass'][0]))
							{
							   
							   $inbox_id=$inboxmessage[0]['InboxMessage']['id'];
							   $maker_id= $inboxmessage[0]['Request']['maker'];
							   $user_id= $inboxmessage[0]['Request']['user_id'];
							   $date=$inboxmessage[0]['Request']['sent_date'];
							   $date_req=$inboxmessage[0]['Request']['request_date'];
							   $time=$inboxmessage[0]['Request']['request_time'].$inboxmessage[0]['Request']['request_time_format'];
							   $total_person=$inboxmessage[0]['Request']['total_persons'];     

							   $order_id=$inboxmessage[0]['Request']['id'];
							}
							else
							{
								$inbox_id=$get_particular_message[0]['InboxMessage']['id'];
								$maker_id= $get_particular_message[0]['Request']['maker'];
								$user_id= $get_particular_message[0]['Request']['user_id'];
								$date=$get_particular_message[0]['Request']['sent_date'];
								$date_req=$get_particular_message[0]['Request']['request_date'];
								$time=$get_particular_message[0]['Request']['request_time'].$get_particular_message[0]['Request']['request_time_format'];
						   
							   $total_person=$get_particular_message[0]['Request']['total_persons'];     
							   $order_id=$inboxmessage[0]['Request']['id'];
							}
							
							$userdetails=$this->requestAction('users/getuserdetails/'.$user_id);
							if(isset($userdetails['User']['profile_image']) && $userdetails['User']['profile_image']!='')
	                        {
				      ?>
 				       <img src="<?php echo $this->webroot; ?>user_images/<?php echo $userdetails['User']['profile_image'];?>" alt="<?php echo $userdetails['User']['first_name'];?>" />
					  <?php }else{ ?>
					   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" alt="<?php echo $userdetails['User']['first_name'];?>" />
					  <?php } ?>
    							<p><?php echo $userdetails['User']['first_name'];?> <?php echo $userdetails['User']['last_name'];?></p>
    							<b><?=date('M d Y',strtotime($inboxmessage[0]['Request']['sent_date']));?></b>
    						</div>
    						<ul class="fashion_list">
								<li><?=$date_req;?> (<?=$time?>)</li>
								<li><?php echo $total_person;?> Persons</li>
							</ul>
							<div class="clearfix"></div>
							<form action="<?php echo $this->webroot.'users/addinvoice/'.$order_id.''; ?>" method="post">	
							<div class="text_fild_holder">
							    <div class="name lato_step_1_sec_1_small">Invoice name</div>
								<div class="fields">
		<input type="text" placeholder="" name="data[Invoice][invoice_name]" id="inv_name">
				    			</div>
								<div class="name lato_step_1_sec_1_small">How long does it take?</div>
								<div class="fields">
		<input type="text" placeholder="" name="data[Invoice][how_long]" id="inv_how_long">
				    			</div>
				    			<div class="name lato_step_1_sec_1_small">How much in total</div>
								<div class="fields">
				    				<input type="text" placeholder="$"  name="data[Invoice][price]" id="inv_price">
				    			</div>
				    			<div class="name lato_step_1_sec_1_small only_des">Remember to explain the price to the customer.
break it down to your hourly rote, extra cost, ect...</div>
								<div class="fields">
				    				<textarea name="data[Invoice][message]" id="inv_message"></textarea>
				    			</div>
								
								<input type="hidden"  name="data[Invoice][maker]" value="<?=$maker_id?>">
								<input type="hidden"  name="data[Invoice][user]" value="<?=$user_id?>">
								<input type="hidden"  name="data[Invoice][inbox]" value="<?=$inbox_id?>">
								<input type="button" class="btn border_btn offer_my_skill pay_btn" value="Cancel" id="inv_call1">&nbsp;&nbsp;<input type="submit" class="btn border_btn offer_my_skill pay_btn" value="Respond" onclick="return validate_inv()">
	                           </div>
						   </form>
    					</div>
    				</div>
                  <!-- invoice div end -->

				  <!-- invoice edit div -->
                    <div class="right_meaasge_inner" id="invoice_edit_div" style="display:none;">
    					<div class="right_meaasge_container">
    						<div class="message_head">
    					    <?php
							if(!isset($this->params['pass'][0]))
							{
							   $user_id= $inboxmessage[0]['Request']['user_id'];
							   $date=$inboxmessage[0]['Request']['sent_date'];
							   $date_req=$inboxmessage[0]['Request']['request_date'];
							   $time=$inboxmessage[0]['Request']['request_time'].$inboxmessage[0]['Request']['request_time_format'];
							   $total_person=$inboxmessage[0]['Request']['total_persons'];     

							   $order_id=$inboxmessage[0]['Request']['id'];
							}
							else
							{
								$user_id= $get_particular_message[0]['Request']['user_id'];
								$date=$get_particular_message[0]['Request']['sent_date'];
								$date_req=$get_particular_message[0]['Request']['request_date'];
								$time=$get_particular_message[0]['Request']['request_time'].$get_particular_message[0]['Request']['request_time_format'];
							    $total_person=$get_particular_message[0]['Request']['total_persons'];     
							    $order_id=$get_particular_message[0]['Request']['id'];
							}
							$invoice_details=$this->requestAction('users/getinvoicedetails/'.$order_id);
							$userdetails=$this->requestAction('users/getuserdetails/'.$user_id);
							if(isset($userdetails['User']['profile_image']) && $userdetails['User']['profile_image']!='')
	                        {
				      ?>
 				       <img src="<?php echo $this->webroot; ?>user_images/<?php echo $userdetails['User']['profile_image'];?>" alt="<?php echo $userdetails['User']['first_name'];?>" />
					  <?php }else{ ?>
					   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" alt="<?php echo $userdetails['User']['first_name'];?>" />
					  <?php } ?>
    							<p><?php echo $userdetails['User']['first_name'];?> <?php echo $userdetails['User']['last_name'];?></p>
    							<b><?=date('M d Y',strtotime($inboxmessage[0]['Request']['sent_date']));?></b>
    						</div>
    						<ul class="fashion_list">
								<li><?=$date_req;?> (<?=$time?>)</li>
								<li><?php echo $total_person;?> Persons</li>
							</ul>
							<div class="clearfix"></div>
							<form action="<?php echo $this->webroot.'users/editinvoice/'.$invoice_details['Invoice']['id'].''; ?>" method="post">	
							<div class="text_fild_holder">
							   <div class="name lato_step_1_sec_1_small">Request Date</div>
								<div class="fields">
				    				<input type="text" placeholder="YYYY-MM-DD"  name="data[Invoice][request_date]" id="request_date_edit" value="<?php echo $invoice_details['Request']['request_date'];?>" readonly>
				    			</div>
								<div class="name lato_step_1_sec_1_small">Request Time</div>
								<div class="fields">
				    				<input type="text" placeholder="7 PM"  name="data[Invoice][request_time]" id="request_time" value="<?php echo $invoice_details['Request']['request_time'].' '.$invoice_details['Request']['request_time_format'];?>" >
				    			</div>
							    <div class="name lato_step_1_sec_1_small">Invoice name</div>
								<div class="fields">
		<input type="text" placeholder="" name="data[Invoice][invoice_name]" id="inv_name1" value="<?php echo $invoice_details['Invoice']['invoice_name'];?>">
				    			</div>
								<div class="name lato_step_1_sec_1_small">How long does it take?</div>
								<div class="fields">
		<input type="text" placeholder="" name="data[Invoice][how_long]" id="inv_how_long1" value="<?php echo $invoice_details['Invoice']['how_long'];?>">
				    			</div>
				    			<div class="name lato_step_1_sec_1_small">How much in total</div>
								<div class="fields">
				    				<input type="text" placeholder="$"  name="data[Invoice][price]" id="inv_price1" value="<?php echo $invoice_details['Invoice']['how_mutch'];?>">
				    			</div>
				    			<div class="name lato_step_1_sec_1_small only_des">Remember to explain the price to the customer.
break it down to your hourly rote, extra cost, ect...</div>
								<div class="fields">
				    				<textarea name="data[Invoice][message]" id="inv_message1"><?php echo $invoice_details['Invoice']['message'];?></textarea>
				    			</div>
								
								<input type="button" class="btn border_btn offer_my_skill pay_btn" value="Cancel" id="inv_call_edit1">&nbsp;&nbsp;<input type="submit" class="btn border_btn offer_my_skill pay_btn" value="Submit" onclick="return validate_inv1()">
	                           </div>
						   </form>
    					</div>
    				</div>
                  <!-- invoice div end -->

                  <?php if(!empty($inboxdetails)){ ?>
                    <div class="right_meaasge_inner">
                       <div class="right_meaasge_container" style="width:100%;margin:0;padding:10px">
    					<div class="message_head">
			      <ul class="message_detail_ul">
                    <?php 
                    foreach($inboxdetails as $v=>$inv_messages) { 
                    $sender_id=  $inv_messages['SentMessage']['sender']; 
					if($inv_messages['SentMessage']['is_invoice']==0)
					{
                      $userdetails=$this->requestAction('users/getuserdetails/'.$sender_id);
                    ?>
                      <li>
                     <?php
                         if(isset($userdetails['User']['profile_image']) && $userdetails['User']['profile_image']!='')
	                 {
				    ?>
 				       <img src="<?php echo $this->webroot; ?>user_images/<?php echo $userdetails['User']['profile_image'];?>" alt="<?php echo $userdetails['User']['first_name'];?>" />
					<?php }else{ ?>
					   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" alt="<?php echo $userdetails['User']['first_name'];?>" />
					<?php } ?>
						  <strong><?php echo $userdetails['User']['first_name'];?> <?php echo $userdetails['User']['last_name'];?></strong><b><?=date('M d Y',strtotime($inv_messages['SentMessage']['date_time']));?></b>
						 <div class="clearfix"></div>
						  <p><?php echo nl2br($inv_messages['SentMessage']['message']);?></p>
						 </li>
					 <?php }else{ 
					  $invoice_details_msg=$this->requestAction('users/getinvoicedetailsmsg/'.$inv_messages['SentMessage']['invoice_id']);
					  if(!empty($invoice_details_msg))
                      {
					 ?>
					   <li>
					      <div class="right_meaasge_inner" style="background:none">
                           <div class="right_meaasge_container" style="width:93%;margin:0 auto">
    						<div class="message_head">
    						  <?php
								$userdetails=$this->requestAction('users/getuserdetails/'.$invoice_details_msg['Invoice']['maker_id']);
								if(isset($userdetails['User']['profile_image']) && $userdetails['User']['profile_image']!='')
								 {
								?>
								   <img src="<?php echo $this->webroot; ?>user_images/<?php echo $userdetails['User']['profile_image'];?>" alt="<?php echo $userdetails['User']['first_name'];?>" style="margin-left:0px"/>
								<?php }else{ ?>
								   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" alt="<?php echo $userdetails['User']['first_name'];?>" style="margin-left:0px"/>
								<?php } ?>
    							<strong><?php echo $userdetails['User']['first_name'];?> <?php echo $userdetails['User']['last_name'];?></strong>
    							<b><?=date('M d Y',strtotime($invoice_details_msg['Invoice']['date']));?></b>
    						<ul class="fashion_list" style="margin-top:0px">
							    <li style="margin-top:5px !important;font-size:20px;background:none;text-indent:0px"><?php echo $invoice_details_msg['Invoice']['invoice_name'];?></li>

								<li style="margin-top:5px !important"><?=date('M d Y',strtotime($invoice_details_msg['Request']['request_date']));?> (<?=$invoice_details_msg['Request']['request_time']?><?=$invoice_details_msg['Request']['request_time_format']?>)</li>
								<li style="margin-top:0px !important"><?php echo $invoice_details_msg['Request']['total_persons'];?> Persons</li>
								<li style="margin-top:0px !important"><?=$invoice_details_msg['Invoice']['how_long']?></li>
							</ul>
							<div class="clearfix"></div>
							
							  <div class="profile_map" id="profile_map"></div>
							
							<div class="clearfix"></div>
							<span>
							<?=nl2br($invoice_details_msg['Invoice']['message']);?>	
							</span>
							<table class="price_table">
								
								<tr>
									
									<td>Total cost</td>
									<td>$<?=$invoice_details_msg['Invoice']['how_mutch'];?></td>
								</tr>
								<tr>
									<td colspan="2">
										
                                        <?php if($this->Session->read('Auth.User.id')!=$invoice_details_msg['Invoice']['maker_id']) { 
										if($invoice_details_msg['Request']['is_paid']==0)
										{ ?>      
                                                <input type="button" class="btn border_btn offer_my_skill pay_btn" value="Pay" onclick="payment(<?=$invoice_details_msg['Invoice']['how_mutch'];?>,<?=$invoice_details_msg['Request']['id'];?>,'<?=$userdetails['User']['first_name'];?>','<?=$userdetails['User']['last_name'];?>','<?=$userdetails['User']['email'];?>','<?=$userdetails['User']['seller_phone'];?>','<?=$userdetails['User']['dob'];?>','<?=base64_encode($userdetails['User']['seller_account_number']);?>','<?=base64_encode($userdetails['User']['seller_routing_number']);?>','<?=$userdetails['User']['seller_street_address'];?>','<?=$userdetails['User']['seller_region'];?>','<?=$userdetails['User']['seller_city'];?>','<?=$userdetails['User']['seller_zip'];?>')">
                                          <?php } 
										  else{?>
                                          	 <input type="button" class="btn border_btn offer_my_skill pay_btn" value="Paid"  disabled style="background:green;border:0"/>
                                          <?php
										  }
										  } ?>	
										  <div class="clearfix"></div>
										  <?php 
										     if($invoice_details_msg['Request']['is_paid']==0)
										     { 
										  ?>
										   <strong style="float:right;font-size:12px">Not agree payment</strong>
										  <?php }else{
										    if($this->Session->read('Auth.User.id')==$invoice_details_msg['Invoice']['maker_id']) {
										  ?>
										    <strong style="float:right;font-size:12px">Paid</strong>
										  <?php }} ?>
									</td>
								  </tr>
							   </table>
    					     </div>
    				      </div>
                       </div>
					   </li>
                    <?php  }}} ?>       
                                </a>
                             </ul>                    
                    </div>
    					</div>
    				</div>
    			   <?php } ?>
                    
                    <!-- <?php
                    if(!isset($this->params['pass'][0]))
                    {
                        $order_id=$inboxmessage[0]['Request']['id'];
                    }
                    else 
                    {
                        $order_id=$get_particular_message[0]['Request']['id'];
                    }
                    $invoice_details=$this->requestAction('users/getinvoicedetails/'.$order_id);
                    if(!empty($invoice_details))
                    {
                    ?>
                    
                    <div class="right_meaasge_inner" >
                                    <div class="right_meaasge_container" >
    						<div class="message_head">
    						  <?php
								$userdetails=$this->requestAction('users/getuserdetails/'.$invoice_details['Invoice']['user_id']);
								if(isset($userdetails['User']['profile_image']) && $userdetails['User']['profile_image']!='')
	                 {
				    ?>
 				       <img src="<?php echo $this->webroot; ?>user_images/<?php echo $userdetails['User']['profile_image'];?>" alt="<?php echo $userdetails['User']['first_name'];?>" />
					<?php }else{ ?>
					   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" alt="<?php echo $userdetails['User']['first_name'];?>" />
					<?php } ?>
    							<p><?php echo $userdetails['User']['first_name'];?> <?php echo $userdetails['User']['last_name'];?></p>
    							<b><?=date('M d Y',strtotime($invoice_details['Invoice']['date']));?></b>
    						<ul class="fashion_list">
								<li><?=date('M d Y',strtotime($invoice_details['Request']['request_date']));?> (<?=$invoice_details['Request']['request_time']?><?=$invoice_details['Request']['request_time_format']?>)</li>
								<li><?php echo $invoice_details['Request']['total_persons'];?> Persons</li>
								<li><?=$invoice_details['Invoice']['how_long']?></li>
							</ul>
							<div class="clearfix"></div>
							<span>
							<?=nl2br($invoice_details['Invoice']['message']);?>	
							</span>
							<table class="price_table">
								
								<tr>
									
									<td>Total cost</td>
									<td>$<?=$invoice_details['Invoice']['how_mutch'];?></td>
								</tr>
								<tr>
									<td colspan="2">
										
                                        <?php if($this->Session->read('Auth.User.id')!=$invoice_details['Invoice']['maker_id']) { ?>      
                                                 <input type="button" class="btn border_btn offer_my_skill pay_btn" value="Pay">
                                          <?php } ?>	
										  <div class="clearfix"></div>
										<strong>Not agree payment</strong>
									</td>
								</tr>
							</table>
    					</div>
    				</div>
                    </div>
                    <?php } ?> 
                     -->
  
                    <?php
                    if(!isset($this->params['pass'][0]))
                    {
                    ?>
                    <div class="right_meaasge_inner" >
    					<div class="right_meaasge_container">
    				    <div class="message_head">
    				     <?php
                                    
                                     $userdetails=$this->requestAction('users/getuserdetails/'.$inboxmessage[0]['Request']['user_id']);
                                    
				     
                                    if(isset($userdetails['User']['profile_image']) && $userdetails['User']['profile_image']!='')
	                 {
				    ?>
 				       <img src="<?php echo $this->webroot; ?>user_images/<?php echo $userdetails['User']['profile_image'];?>" alt="<?php echo $userdetails['User']['first_name'];?>" />
					<?php }else{ ?>
					   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" alt="<?php echo $userdetails['User']['first_name'];?>" />
					<?php } ?>
    							<p><?php echo $userdetails['User']['first_name'];?> <?php echo $userdetails['User']['last_name'];?></p>
    							<b><?=date('M d Y',strtotime($inboxmessage[0]['Request']['sent_date']));?></b>
    						</div>
    						<ul class="fashion_list">
								<li><?=date('M d Y',strtotime($inboxmessage[0]['Request']['request_date']));?> (<?=$inboxmessage[0]['Request']['request_time']?><?=$inboxmessage[0]['Request']['request_time_format']?>)</li>
								<li><?php echo $inboxmessage[0]['Request']['total_persons'];?> Persons</li>
							</ul>
							<div class="clearfix"></div>
							
							<span><?php echo nl2br($inboxmessage[0]['Request']['request_comment']);?>
							</span>
    					</div>
    					<?php
	 if(!empty($inboxmessage[0]['Request']['image_paths']))
	 {
	?>
	<div class="image_galin_profile">
		<iframe src="<?php echo $this->webroot;?>users/sliderframe3/<?php echo $inboxmessage[0]['Request']['id'];?>" style="margin:0;border:0;width:100%;height:440px;overflow:hidden;" scrolling="no"></iframe> 
	</div>
    					
         <?php } ?>					
    					
    				</div>
    	  <?php } else { ?>
           <div class="right_meaasge_inner" >
    					<div class="right_meaasge_container">
    				    <div class="message_head">  
                           <?php   
                                    
                                     $userdetails=$this->requestAction('users/getuserdetails/'.$get_particular_message[0]['Request']['user_id']);
                                    
				     
                                    if(isset($userdetails['User']['profile_image']) && $userdetails['User']['profile_image']!='')
	                    {
				       ?>
 				       <img src="<?php echo $this->webroot; ?>user_images/<?php echo $userdetails['User']['profile_image'];?>" alt="<?php echo $userdetails['User']['first_name'];?>" />
					<?php }else{ ?>
					   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" alt="<?php echo $userdetails['User']['first_name'];?>" />
					<?php } ?>
    							<p><?php echo $userdetails['User']['first_name'];?> <?php echo $userdetails['User']['last_name'];?></p>
    							<b><?=date('M d Y',strtotime($get_particular_message[0]['Request']['sent_date']));?></b>
    						</div>
    						<ul class="fashion_list">
								<li><?=date('M d Y',strtotime($get_particular_message[0]['Request']['request_date']));?> (<?=$get_particular_message[0]['Request']['request_time']?><?=$get_particular_message[0]['Request']['request_time_format']?>)</li>
								<li><?php echo $get_particular_message[0]['Request']['total_persons'];?> Persons</li>
							</ul>
							<div class="clearfix"></div>
							
							<span><?php echo nl2br($get_particular_message[0]['Request']['request_comment']);?>
							</span>
    					</div>
    					<?php
							 if(!empty($get_particular_message[0]['Request']['image_paths']))
							 {
							?>
							<div class="image_galin_profile">
								<iframe src="<?php echo $this->webroot;?>users/sliderframe3/<?php echo $get_particular_message[0]['Request']['id'];?>" style="margin:0;border:0;width:100%;height:440px;overflow:hidden;" scrolling="no"></iframe> 
							</div>
							
						<?php } ?>
                 </div>
			</div>
		</div>
                    
           <?php } ?>
                
                </div>
	</div>
</div>

<?php echo $this->Html->scriptStart(array('inline'=>false));?>
    var marker;
	var geocoder = new google.maps.Geocoder();
	initialize_profile();
	function initialize_profile(lat,lng) 
	{
		lat='<?php echo $skill_lat;?>';
		lng='<?php echo $skill_lang;?>';
		var myLatLng = new google.maps.LatLng(lat,lng);
		
	   <?php if($invoice_details_msg['Request']['is_paid']==0){ ?>
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
  function validate_inv()
  {
	var inv_name=$('#inv_name').val();
	var inv_how_long=$('#inv_how_long').val();
	var inv_price=$('#inv_price').val();
	var inv_message=$('#inv_message').val();
	
	if(inv_name=='')
    {
	  $('#inv_name').css({"border":"1px solid red"});
    }
    else
    {
	  $('#inv_name').css({"border":"0px"});
    }
	if(inv_how_long=='')
    {
	  $('#inv_how_long').css({"border":"1px solid red"});
    }
    else
    {
	  $('#inv_how_long').css({"border":"0px"});
    }
	if(inv_price=='')
    {
	  $('#inv_price').css({"border":"1px solid red"});
    }
    else
    {
	  $('#inv_price').css({"border":"0px"});
    }
	if(inv_message=='')
    {
	  $('#inv_message').css({"border":"1px solid red"});
    }
    else
    {
	  $('#inv_message').css({"border":"0px"});
    }
	
	if((inv_name=='') || (inv_how_long=='') || (inv_price=='') || (inv_message=='') )
	{
		return false;
	}
	else
	{
		return true;
	}
  }

  function validate_inv1()
  {
	var request_time=$('#request_time').val();
	var inv_name=$('#inv_name1').val();
	var inv_how_long=$('#inv_how_long1').val();
	var inv_price=$('#inv_price1').val();
	var inv_message=$('#inv_message1').val();
	
	if(inv_name=='')
    {
	  $('#inv_name1').css({"border":"1px solid red"});
    }
    else
    {
	  $('#inv_name1').css({"border":"0px"});
    }
	if(inv_how_long=='')
    {
	  $('#inv_how_long1').css({"border":"1px solid red"});
    }
    else
    {
	  $('#inv_how_long1').css({"border":"0px"});
    }
	if(inv_price=='')
    {
	  $('#inv_price1').css({"border":"1px solid red"});
    }
    else
    {
	  $('#inv_price1').css({"border":"0px"});
    }
	if(inv_message=='')
    {
	  $('#inv_message1').css({"border":"1px solid red"});
    }
    else
    {
	  $('#inv_message1').css({"border":"0px"});
    }
    if(request_time=='')
	{
	  $('#request_time').css({"border":"1px solid red"});
    }
    else
    {
	  $('#request_time').css({"border":"0px"});
    }
	
	if((inv_name=='') || (inv_how_long=='') || (inv_price=='') || (inv_message=='') || (request_time=='') )
	{
		return false;
	}
	else
	{
		return true;
	}
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
	  $('#bstate_err').html('Please enter state');
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
						data: {request_id:$('#request_id').val(),amount:$('#absolute_login #pay_amount').val(),transaction_id:data.transaction_id,billing_first_name:billing_first_name,billing_last_name:billing_last_name,billing_street_add:billing_street_add,billing_city:billing_city,billing_state:billing_state,billing_post_code:billing_post_code,braintree_token:data.braintree_token},
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
<style>
#profile_map img { max-width: inherit; border-radius:0px !important;}
#profile_map{height:361px !important}
</style>
<style>
.modal-dialog,.modal-content,.modal
{
	z-index:99999999999999999999999 !important;
}
.btn-primary {
    background-color: #428bca !important;
	}
	.btn-primary:hover
	{
		background-color:#4743E2 !important;
	}
</style>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
 <script src="http://bootboxjs.com/vendor/js/bootstrap.min.js"></script>
<script src="http://bootboxjs.com/bootbox.js"></script>