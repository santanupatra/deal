<div style="width:100%;position:fixed;bottom:0px;margin:0px auto;background-color:#FEFEFE;height:90px;z-index:999;"><div style="width:50%;padding-top:17px;"><input type="button" value="Save" class="btn border_btn offer_my_skill dash_offer_skil1" style="background-color:#4743e2;border:1px solid #4743e2 !important;font-family: montserratregular !important;" onclick="return step3_validate()" ></div></div>
<div class="container_825">
	<div class="step1_sec1">
		<div class="row">
			<div class="col-sm-12 lato_step_1_sec_1" style="font-family: montserratregular !important;"><?php echo $sitesetting['SiteSetting']['skill_cost_heading']; ?></div>
			<div class="col-sm-9 lato_step_1_sec_1_small margin_zero">
				<?php echo $sitesetting['SiteSetting']['skill_cost_description']; ?>
			</div>
		</div>
	</div>
	<div class="step1_sec2">
	<form class="contact_form" name="step2" id="step2" action="<?php echo $this->webroot.'skills/step3/'.$skill_id.'';?>" method="POST" >
		<div class="width_620">
			<div class="name lato_step_1_sec_1_small small_line_ht"><?php echo $sitesetting['SiteSetting']['skill_cost_field1']; ?></div>
			<br/><br/>
			<div class="name lato_step_1_sec_1_small"><?php echo $sitesetting['SiteSetting']['skill_cost_field2']; ?>&nbsp;&nbsp;<span id="priceerr" style="color:red"></span></div>		
			<div class="min_max_price">
				<input type="hidden" placeholder="Minimum" name="data[Skill][min_price]" id="min_price"  value="0" />
				<input type="text" placeholder="Maximum" name="data[Skill][max_price]" id="max_price" onkeypress="return only_number(event)" value="<?php if(isset($skill['Skill']['max_price']) && $skill['Skill']['max_price']!=0.00){echo $skill['Skill']['max_price'];}?>" onkeyup="remove_err_price('priceerr',this.value,'max_price')"/><b>Per hour</b>
			</div>
			
			<p class="loato_p"><a href="javascript:void(0);"><?php echo $sitesetting['SiteSetting']['skill_cost_field3']; ?></a></p>
			
			<div class="name lato_step_1_sec_1_small"><?php echo $sitesetting['SiteSetting']['skill_cost_field4']; ?>&nbsp;&nbsp;<span id="pricedeterr" style="color:red"></span></div>
			<div class="fields">
				<textarea name="data[Skill][price_details]" id="price_details" onkeyup="remove_err('pricedeterr',this.value)"><?php if(isset($skill['Skill']['price_details']) && $skill['Skill']['price_details']!=''){echo $skill['Skill']['price_details'];}?></textarea>
			</div>
			
			<div class="clearfix"></div>
			<!--<div class="fields">
                            <a href="<?php echo $this->webroot.'skills/step2/'.$skill_id.'';?>"><div class="step_back">Studio</div></a><input type="button" value="Availability" class="studio_btn" onclick="savebotton()"/>
			</div>-->
		</div>
	 </form>
	</div>
</div>
<div style="height:135px;background-color:#F1F1F1" >&nbsp;</div>
<script>
    function savebotton()
{
window.location.href='<?=$this->webroot?>skills/step4/<?=$skill_id?>';
}
</script>