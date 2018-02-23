<?php ?>
<style type="text/css">
	.errorRow {
		color:red;
	}
.step_box {
height: auto;
width: 100%;
padding: 18px;
background: white;
border-radius: 3px;
box-shadow: 0 0 2px #999;
margin-top: 20px;
float: left;
font-family: 'Arial';
font-size: 17px;
color: #787776;
line-height: 35px;
}
.step_header {
height: 30px;
width: 100%;
border-bottom: 1px dotted #dedbd9;
text-align: left;
}
.form_1 {
list-style: none;
font-size: 13px;
margin-top: 10px;
}.form_1 {
list-style: none;
font-size: 13px;
margin-top: 10px;
}
.form_1 li {
float: left;
text-align: left;
width: 235px;
border: 0px solid red;
margin-left: 10px;
}
.contact_text_box {
height: 30px;
width: 300px;
border: 1px solid #e1e1e1;
background: #ffffff;
border-radius: 4px;
-moz-box-shadow: 0px 2px 3px rgba(182, 182, 182, 0.75);
-webkit-box-shadow: 0px 2px 3px rgba(182, 182, 182, 0.75);
box-shadow: 0px 1px 1px rgba(182, 182, 182, 0.75);
font-size: 14px;
line-height: 20px;
padding-left: 10px;
}
.btn_holder {
float: right;
}	
</style>
<script type="text/javascript">
function chkValid(){
	if(document.getElementById('full_name').value=='')
	{
		$("#errorRow1").html('Please enter Full Name');			
		document.getElementById('full_name').focus();
		return false;
	}
	else if(document.getElementById('country_id').value=='')
	{
		$("#errorRow8").html('Please select Country');				
		document.getElementById('country_id').focus();
		return false;
	}
	else if(document.getElementById('street').value=='')
	{
		$("#errorRow9").html('Please enter Street');			
		document.getElementById('street').focus();	
		return false;
	}
	else if(document.getElementById('city').value=='')
	{
		$("#errorRow11").html('Please enter City');				
		document.getElementById('city').focus();	
		return false;
	}
	else if(document.getElementById('state').value=='')
	{
		$("#errorRow12").html('Please enter State');				
		document.getElementById('state').focus();		
		return false;
	}
	else if(document.getElementById('zip_code').value=='')
	{
		$("#errorRow13").html('Please enter Zip Code');					
		document.getElementById('zip_code').focus();	
		return false;
	}
	else
	{
		return true;
	}	
}
</script>
<section class="featured_list">
	<div class="container">
			
		<div class="row">
<div class="details_bak">
	<div class="details_holder">		
		<form id="ShippingAddressAddForm" name="ShippingAddressAddForm" method="post" accept-charset="utf-8">
		<div class="step_box">
			<div class="step_header">
			<h4>Choose where you want the listings to be delivered.</h4>
			</div>
			<div class="clear"></div>			
			<ul class="form_1" style="width:100%;">
				<div id="chequedetails">					
					<ul class="form_1">
						<li style="width:90%;margin-left:1%;">SHIPPING ADDRESS</li>
						<li  style="width:45%;float:left;"><strong>Full Name</strong><br/>
						<input type="text" class="contact_text_box" id="full_name" name="data[ShippingAddress][full_name]" /><br/>
						<span class="errorRow" id="errorRow1">&nbsp;</span>
						</li>
						<li style="width:45%;float:left;"><strong>Country</strong><br/>
						<select name="data[ShippingAddress][country]" id="country_id" class="contact_text_box box_size" style="width:312px !important;">
							<option value="">-Select Country-</option>
							<?php
							if($countries)
							{
								foreach($countries as $k=>$v)
								{
							?>
							<option value="<?php echo($k);?>"><?php echo($v);?></option>
							<?php
								}
							}
							?>
						</select><br/>
						<span class="errorRow" id="errorRow8">&nbsp;</span></li>
						<li  style="width:45%;float:left;"><strong>Street</strong><br/>
						<input type="text" class="contact_text_box" id="street" name="data[ShippingAddress][street]" /><br/>
						<span class="errorRow" id="errorRow9">&nbsp;</span>
						</li>
						<li  style="width:45%;float:left;"><strong>Apt/Suite/Other</strong><br/>
						<input type="text" class="contact_text_box" id="apartment" name="data[ShippingAddress][apartment]" /><br/>
						<span class="errorRow" id="errorRow10">&nbsp;</span>
						</li>
						<li style="width:45%;float:left;"><strong>City</strong><br/>
						<input type="text" class="contact_text_box" id="city" name="data[ShippingAddress][city]" /><br/>
						<span class="errorRow" id="errorRow11">&nbsp;</span>
						</li>
						<li  style="width:45%;float:left;"><strong>State/Province/Region</strong><br/>
						<input type="text" class="contact_text_box" id="state" name="data[ShippingAddress][state]" /><br/>
						<span class="errorRow" id="errorRow12">&nbsp;</span>
						</li>						
						<li  style="width:45%;float:left;"><strong>Zip / Postal Code</strong><br/>
						<input type="text" class="contact_text_box" id="zip_code" name="data[ShippingAddress][zip_code]" maxlength="6"/><br/>
						<span class="errorRow" id="errorRow13">&nbsp;</span>
						</li>
					</ul>
					<div class="seperator"></div>
				</div>
				<div class="clear"></div>
			</ul>													
			<div class="clear"></div>
		</div>				
		<div class="btn_holder">
		<input type="submit" class="btn btn-primary btnsearch" value="Submit" onclick="return chkValid()"/>
		</div>				
		</form>
	<div class="clear"></div>
	</div>
<div class="clear"></div>
</div>
<div class="clear"></div>
</div>
</div>
</section>
