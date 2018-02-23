<div class="container_960">
<?php echo $this->element('user_leftbar'); ?>
<div class="dash_right pull-right">
	<div class="dash_right_head">
		<h2>Account Setting</h2>
	</div>
	<ul class="tabs-menu_1">
	        <li style="width:33.33%" id="first_tab_li" onclick="open_first_tab()"><a href="javascript:void(0)">Setting</a></li>
			<li class="current" style="width:33.33%" id="second_tab_li" onclick="open_second_tab()"><a href="javascript:void(0)">Payout</a></li>
			<li class="current" style="width:33.33%" id="third_tab_li" onclick="open_third_tab()"><a href="javascript:void(0)">Transaction </a></li>
	</ul>
	<div class="edit_profile" id="first_tab">
		 <form class="contact_form" name="reg_form_user" id="reg_form_user" action="<?php echo $this->webroot.'users/edit_password'; ?>" method="POST" >
			<div class="edit_profile_half pull-left">
					<div class="name lato_step_1_sec_1_small">Current Password</div>
					<div class="fields">
						<input type="password" placeholder="anie56" name="data[curr_pass]" id="curr_pass"/>
						<span id="curpwerror" style="color:red"></span>
					</div>
			</div>
			<div class="edit_profile_half pull-right">&nbsp;</div>

			<div class="clearfix"></div>
			<div class="edit_profile_half pull-left">
					<div class="name lato_step_1_sec_1_small">New Password</div>
					<div class="fields">
						<input type="password" placeholder="anie777" name="data[new_pass]" id="new_pass"/>
						<span id="newpwerror" style="color:red"></span>
					</div>
			</div>
			<div class="edit_profile_half pull-right">&nbsp;</div>

			<div class="clearfix"></div>
			<div class="edit_profile_half pull-left">
					<div class="name lato_step_1_sec_1_small">Confirm Password</div>
					<div class="fields">
						<input type="password" placeholder="anie777" name="data[con_pass]" id="con_pass"/>
						<span id="conpwerror" style="color:red"></span>
					</div>
			</div>
			<div class="edit_profile_half pull-right">&nbsp;</div>
			<div class="clearfix"></div>
			<div class="edit_profile_full">  				
				<input type="submit" value="Update" class="studio_btn update_setting" onclick="return validatepw();">
				<a href="javascript:void(0)" class="cencel_account" onclick="open_cancel_div()">Cancel my account</a>
			</div>
		  </form>
		  <div id="cancl_div" style="display:none">
			  <div class="fullarrow"></div>
				<div class="edit_profile_full">  
					<div class="name lato_step_1_sec_1_small">Ouch... Tell us the reason please</div>
					<div class="fields">
						<ul class="radio_select">
							<li><input type="radio"/><p>In a few hours</p></li>
							<li><input type="radio"/><p>Within 1 day</p></li>
							<li><input type="radio"/><p>Within 3 days</p></li>
							<li><input type="radio"/><p>In 1 week</p></li>
						</ul>
						<input type="submit" value="Goodbye for now" class="studio_btn goodbye">
					</div>
				</div>
		  </div>
	</div>

	<div class="edit_profile" style="display:none" id="second_tab">
	     <div class="edit_profile_full account_head_text" style="margin-bottom:20px"> 
		    <?php if(isset($sitesetting['SiteSetting']['account_header_text']) && $sitesetting['SiteSetting']['account_header_text']!=''){
			  echo $sitesetting['SiteSetting']['account_header_text'];
			}else{ ?>
			  <p>Please be sure that all the information are correct.This information will be used to let user pay. We will not disclose this to anybody.</p>
			<?php } ?>
		 </div>
		 <form class="contact_form" name="reg_form_user" id="reg_form_user" action="<?php echo $this->webroot.'users/account';?>" method="POST" >
			<div class="edit_profile_half pull-left">
				<div class="name lato_step_1_sec_1_small">Street Address <img src="<?php echo $this->webroot;?>img/lock.png"/></div>
				<div class="fields">
					<input type="text" placeholder="140 Main St" name="data[seller_street_address]" id="seller_street_address" value="<?php if(isset($user['User']['seller_street_address']) && $user['User']['seller_street_address']!=''){echo $user['User']['seller_street_address'];}?>"/>
					<span id="seller_street_address_err" style="color:red"></span>
				</div>
			</div>
			<div class="edit_profile_half pull-right">
				<div class="name lato_step_1_sec_1_small">City <img src="<?php echo $this->webroot;?>img/lock.png"/></div>
				<div class="fields">
					<input type="text" placeholder="Chicago" name="data[seller_city]" id="seller_city" value="<?php if(isset($user['User']['seller_city']) && $user['User']['seller_city']!=''){echo $user['User']['seller_city'];}?>"/>
					<span id="seller_city_err" style="color:red"></span>
				</div>
			</div>
			<div class="edit_profile_half pull-left">
				<div class="name lato_step_1_sec_1_small">Zip code <img src="<?php echo $this->webroot;?>img/lock.png"/></div>
				<div class="fields">
					<input type="text" placeholder="70545" id="seller_zip" name="data[seller_zip]" value="<?php if(isset($user['User']['seller_zip']) && $user['User']['seller_zip']!=''){echo $user['User']['seller_zip'];}else{echo $user['User']['zip_code'];}?>"/>
					<span id="seller_zip_err" style="color:red"></span>
				</div>
			</div>
			<div class="edit_profile_half pull-right">
				<div class="name lato_step_1_sec_1_small">Region <img src="<?php echo $this->webroot;?>img/lock.png"/></div>
				<div class="fields">
					<input type="text" placeholder="IL" id="seller_region" name="data[seller_region]" value="<?php if(isset($user['User']['seller_region']) && $user['User']['seller_region']!=''){echo $user['User']['seller_region'];}?>"/>
					<span id="seller_region_err" style="color:red"></span>
				</div>
			</div>
			<div class="edit_profile_half pull-left">
				<div class="name lato_step_1_sec_1_small">Your phone number <img src="<?php echo $this->webroot;?>img/lock.png"/></div>
				<div class="fields">
					<input type="text" placeholder="02-1524-0054" id="seller_phone" name="data[seller_phone]" value="<?php if(isset($user['User']['seller_phone']) && $user['User']['seller_phone']!=''){echo $user['User']['seller_phone'];}?>"/>
					<span id="seller_phone_err" style="color:red"></span>
				</div>
			 </div>
			 <div class="edit_profile_half pull-right">
				<div class="name lato_step_1_sec_1_small">Date of Birth <img src="<?php echo $this->webroot;?>img/lock.png"/></div>
				<div class="fields">
					<input type="text" placeholder="1990-07-27" id="dob" name="data[dob]" value="<?php if(isset($user['User']['dob']) && $user['User']['dob']!=''){echo $user['User']['dob'];}?>"/>
					<span id="dob_err" style="color:red"></span>
				</div>
			 </div>
			 <div class="clearfix"></div>
             <div class="edit_profile_half pull-left">
				<div class="name lato_step_1_sec_1_small">Bank Account number <img src="<?php echo $this->webroot;?>img/lock.png"/></div>
				<div class="fields">
					<input type="text" placeholder="234**********567" id="seller_account_number" name="data[seller_account_number]" value="<?php if(isset($user['User']['seller_account_number']) && $user['User']['seller_account_number']!=''){echo str_pad(substr($user['User']['seller_account_number'],0,4),16,'X');}?>"/>
					<input type="hidden" name="data[hid_seller_account_number]" value="<?php if(isset($user['User']['seller_account_number']) && $user['User']['seller_account_number']!=''){echo $user['User']['seller_account_number'];}?>"/>
					<span id="seller_account_number_err" style="color:red"></span>
				</div>
			</div>
			<div class="edit_profile_half pull-right">
				<div class="name lato_step_1_sec_1_small">Bank Routing number <img src="<?php echo $this->webroot;?>img/lock.png"/></div>
				<div class="fields">
					<input type="text" placeholder="234******" id="seller_routing_number" name="data[seller_routing_number]" value="<?php if(isset($user['User']['seller_routing_number']) && $user['User']['seller_routing_number']!=''){echo str_pad(substr($user['User']['seller_routing_number'],0,3),9,'X');}?>"/>
					<input type="hidden" name="data[hid_seller_routing_number]" value="<?php if(isset($user['User']['seller_routing_number']) && $user['User']['seller_routing_number']!=''){echo $user['User']['seller_routing_number'];}?>"/>
					<span id="seller_routing_number_err" style="color:red"></span>
				</div>
			 </div>
			 <div class="clearfix"></div>
			 <div class="edit_profile_half pull-left">
				<div class="name lato_step_1_sec_1_small">Paypal Business Email <img src="<?php echo $this->webroot;?>img/lock.png"/></div>
				<div class="fields">
					<input type="text" placeholder="anie@gmail.com" id="seller_paypal_email" name="data[paypal_business_email]" value="<?php if(isset($user['User']['paypal_business_email']) && $user['User']['paypal_business_email']!=''){echo $user['User']['paypal_business_email'];}?>"/>
					<span id="seller_paypal_err" style="color:red"></span>
				</div>
				<span class="text_guide">
					<?php if(isset($sitesetting['SiteSetting']['account_footer_text']) && $sitesetting['SiteSetting']['account_footer_text']!=''){
					  echo $sitesetting['SiteSetting']['account_footer_text'];
					}else{ ?>
					  Please be sure that all the information are correct.This information will be used to let user pay. We will not disclose this to anybody.
					<?php } ?>
				</span>
			 </div>
			 <input type="submit" value="Save" class="studio_btn" onclick="return validate_editinfo();" style="margin-top: 33px;">
		  </form>
	</div>
	<div class="edit_profile" style="display:none" id="third_tab">
	 <div id="tab-2" class="tab-content_1">
	  <?php if(!empty($transactions)){ ?>
	   <table>
			<tr>
				<th>Date</th>
				<th>Detail</th>
				<th>Amount</th>
				<th>From</th>
				<th>To</th>
				<th>Status</th>
			</tr>
		  <?php foreach($transactions as $transaction){ 
		   $userid = $this->Session->read('Auth.User.id');
		   $userdetail1=$this->requestAction('users/getuserdetails/'.$transaction['Transaction']['from']);
		   $userdetail2=$this->requestAction('users/getuserdetails/'.$transaction['Transaction']['to']);
		   $skill_name=$this->requestAction('users/getskillname/'.$transaction['Request']['skill_id']);
		  ?>
			<tr>
				<td><?php echo date('d M Y',strtotime($transaction['Transaction']['date']));?></td>
				<td><?php echo $skill_name;?></td>
				<td>$<?php echo intval($transaction['Transaction']['amount']);?></td>
				<td><?php if($transaction['Transaction']['from']==$userid){echo 'You';}else{echo $userdetail1['User']['first_name'].' '.$userdetail1['User']['last_name'];}?></td>
				<td><?php if($transaction['Transaction']['to']==$userid){echo 'You';}else{echo $userdetail2['User']['first_name'].' '.$userdetail2['User']['last_name'];}?></td>
				<td><?php if($transaction['Transaction']['status']==1){echo 'Escrowed';}else{echo 'Paid';}?></td>
			</tr>
		  <?php } ?>
		</table>
		<?php } ?>
		</div>
	</div>
</div>
</div>
<style>
 .text_guide p
 {
  font-size:13px !important;
  line-height:18px !important;
 }
 .account_head_text p
 {
  font-size:14px !important;
  line-height:18px !important;
 }
 .tab-content_1
 {
  display:block;
 }
 .tab-content_1 table tr td {
  text-indent:0px;
 }
</style>
<?php echo $this->Html->scriptStart(array('inline'=>false));?>
 function open_cancel_div()
 {
       $("#cancl_div").slideToggle("slow");
 }
 function open_first_tab()
 {
   $("#second_tab").hide();
   $("#third_tab").hide();
   $("#first_tab").show();
   $('#first_tab_li').removeClass('current');
   $('#second_tab_li').addClass('current');
   $('#third_tab_li').addClass('current');
 }
 function open_second_tab()
 {
   $("#first_tab").hide();
   $("#third_tab").hide();
   $("#second_tab").show();
   $('#first_tab_li').addClass('current');
   $('#second_tab_li').removeClass('current');
   $('#third_tab_li').addClass('current');
 }
 function open_third_tab()
 {
   $("#first_tab").hide();
   $("#second_tab").hide();
   $("#third_tab").show();
   $('#first_tab_li').addClass('current');
   $('#second_tab_li').addClass('current');
   $('#third_tab_li').removeClass('current');
 }
<?php echo $this->Html->scriptEnd();?>