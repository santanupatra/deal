<div class="container_960">
<?php echo $this->element('user_leftbar'); ?>
<div class="dash_right pull-right">
	<div class="dash_right_head">
		<h2>Settings</h2>
	</div>
	<div class="setting_page">
		<ul class="tabs-menu_1">
			<li><a href="#tab-1">Settings</a></li>
			<li class="current"><a href="#tab-2">Payment</a></li>
			<li class="current"><a href="#tab-3">Transaction </a></li>
		</ul>
		<div class="tab_1">
			<div id="tab-1" class="tab-content_1">
			 <form class="contact_form" name="reg_form_user" id="reg_form_user" action="<?php echo $this->webroot.'users/edit_password'; ?>"method="POST" >
				<div class="account_head_big">
					Account Settings
				</div>
			   <div class="edit_profile_half pull-left">
					<div class="name lato_step_1_sec_1_small">Current Password</div>
					<div class="fields">
						<input type="password" placeholder="anie56" name="data[curr_pass]" id="curr_pass"/>
						<span id="curpwerror" style="color:red"></span>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="edit_profile_half pull-left">
					<div class="name lato_step_1_sec_1_small">New Password</div>
					<div class="fields">
						<input type="password" placeholder="anie777" name="data[new_pass]" id="new_pass"/>
						<span id="newpwerror" style="color:red"></span>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="edit_profile_half pull-left">
					<div class="name lato_step_1_sec_1_small">Confirm Password</div>
					<div class="fields">
						<input type="password" placeholder="anie777" name="data[con_pass]" id="con_pass"/>
						<span id="conpwerror" style="color:red"></span>
					</div>
				</div>
				<div class="edit_profile_full">  				
					<input type="submit" value="Update" class="studio_btn update_setting" onclick="return validatepw();">
					<a href="javascript:void(0)" class="cencel_account">Cancel my account</a>
				</div>
			  </form>
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
			<div id="tab-2" class="tab-content_1">
				<div class="account_head_big">
					Account Payment
				</div>
				<div class="edit_profile_half pull-left">
					<div class="name lato_step_1_sec_1_small">ou could conveniently use Paypal to receive a payment.</div>
					<input type="submit" value="Add PayPal" class="studio_btn update_setting">
					
				</div>
			</div>
			<div id="tab-3" class="tab-content_1">
				<div class="account_head_big">
					Account Transaction
				</div>
				<table>
					<tr>
						<th>Date</th>
						<th>Detail</th>
						<th>Amout</th>
						<th>From</th>
					</tr>
					<tr>
						<td>7 Aug 2014</td>
						<td>lorum ipsum dollor semot alechem</td>
						<td>$ 50000.-</td>
						<td>Steve Marvel</td>
					</tr>
					<tr>
						<td>7 Aug 2014</td>
						<td>lorum ipsum dollor semot alechem</td>
						<td>$ 50000.-</td>
						<td>Steve Marvel</td>
					</tr>
					<tr>
						<td>7 Aug 2014</td>
						<td>lorum ipsum dollor semot alechem</td>
						<td>$ 50000.-</td>
						<td>Steve Marvel</td>
					</tr>
					<tr>
						<td>7 Aug 2014</td>
						<td>lorum ipsum dollor semot alechem</td>
						<td>$ 50000.-</td>
						<td>Steve Marvel</td>
					</tr>
					<tr>
						<td>7 Aug 2014</td>
						<td>lorum ipsum dollor semot alechem</td>
						<td>$ 50000.-</td>
						<td>Steve Marvel</td>
					</tr>
					<tr>
						<td>7 Aug 2014</td>
						<td>lorum ipsum dollor semot alechem</td>
						<td>$ 50000.-</td>
						<td>Steve Marvel</td>
					</tr>
					<tr>
						<td>7 Aug 2014</td>
						<td>lorum ipsum dollor semot alechem</td>
						<td>$ 50000.-</td>
						<td>Steve Marvel</td>
					</tr>
					<tr>
						<td>7 Aug 2014</td>
						<td>lorum ipsum dollor semot alechem</td>
						<td>$ 50000.-</td>
						<td>Steve Marvel</td>
					</tr>
					<tr>
						<td>7 Aug 2014</td>
						<td>lorum ipsum dollor semot alechem</td>
						<td>$ 50000.-</td>
						<td>Steve Marvel</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
</div>