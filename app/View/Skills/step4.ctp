<div style="width:100%;position:fixed;bottom:0px;margin:0px auto;background-color:#FEFEFE;height:90px;z-index:999;"><div style="width:50%;padding-top:17px;"><input type="button" value="Save" class="btn border_btn offer_my_skill dash_offer_skil1" style="background-color:#4743e2;border:1px solid #4743e2 !important;font-family: montserratregular !important;" onclick="return step4_validate()" ></div></div>
<div class="container_825">
	<div class="step1_sec1">
		<div class="row">
			<div class="col-sm-12 lato_step_1_sec_1" style="font-family: montserratregular !important;"><?php echo $sitesetting['SiteSetting']['skill_availability_heading']; ?></div>
			<div class="col-sm-9 lato_step_1_sec_1_small margin_zero">
				<?php echo $sitesetting['SiteSetting']['skill_availability_description']; ?>
			</div>
		</div>
	</div>
	<div class="step1_sec2">
		<div class="width_620">
		 <form class="contact_form" name="step4" id="step4" action="<?php echo $this->webroot.'skills/step4/'.$skill_id.'';?>" method="POST" >
			<div class="name lato_step_1_sec_1_small"><input type="radio" id="alltime_radio" name="data[Availability][any_time_email]" value="1" onclick="check_alltime()" <?php if(isset($availability['Availability']['any_time_email']) && $availability['Availability']['any_time_email']==1){echo 'checked';}?>/>&nbsp;&nbsp;<?php echo $sitesetting['SiteSetting']['skill_availability_field1']; ?></div>
								
			<div class="name lato_step_1_sec_1_small"><input type="radio" id="alltime_radio" name="data[Availability][any_time_email]" value="0" onclick="check_alltime()" <?php if(isset($availability['Availability']['any_time_email']) && $availability['Availability']['any_time_email']==1){echo 'checked';}?> checked/>&nbsp;&nbsp<?php echo $sitesetting['SiteSetting']['skill_availability_field2']; ?><br><span id="availtimeerr" style="color:red"></span></div>
			<ul class="weeklist">
			    
				<li>
<div style="float:left"><input type="checkbox" id="monday" name="monday" value="1" onclick="check_allmonday()" style="margin-top:-2px;" checked/></div>
<div style="float:left;margin-left:10px;">
					<b>Monday</b>
					<div class="gray_back" style="background:#ffffff;" id="day1">

						<div class="top_date">
							<div class="time_start">From</div>
							<div class="actual_time" style="border:0px;">
<div id="sample2">
        <p>
            <input name="data[Availability][monday_from]" value="<?php if(isset($availability['Availability']['monday_from']) && $availability['Availability']['any_time_email']==0){echo $availability['Availability']['monday_from'];}?>" id="time1"/>
        </p>
    </div>
</div>
							<!--<div class="actual_time actual_right">
							    <div class="on_off">
									<select name="data[Availability][monday_from_format]">
										<option value="0" <?php echo((isset($availability['Availability']['monday_from_format']) && $availability['Availability']['monday_from_format']==0 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>AM</option>
										<option value="1" <?php echo((isset($availability['Availability']['monday_from_format']) && $availability['Availability']['monday_from_format']==1 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>PM</option>
									</select>
								</div>
							</div>-->
						</div>
                                                   <div style="clear:both;"></div>
						<div class="bottom_date">
							<div class="time_start">Till</div>
							<div class="actual_time" style="border:0px;">
<div id="sample2">
        <p>
            <input name="data[Availability][monday_to]" value="<?php if(isset($availability['Availability']['monday_to']) && $availability['Availability']['any_time_email']==0){echo $availability['Availability']['monday_to'];}?>" id="time2"/>
        </p>
    </div></div>
							<!--<div class="actual_time actual_right">
							    <div class="on_off">
									<select name="data[Availability][monday_to_format]">
										<option value="0" <?php echo((isset($availability['Availability']['monday_to_format']) && $availability['Availability']['monday_to_format']==0 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>AM</option>
										<option value="1" <?php echo((isset($availability['Availability']['monday_to_format']) && $availability['Availability']['monday_to_format']==1 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>PM</option>
									</select>
								</div>
							</div>-->
						</div>
					</div>
</div>
				</li>
				<li>
<div style="float:left">
<input type="checkbox" id="tuesday" name="tuesday" value="1" onclick="check_alltuesday()" style="margin-top:-2px;" checked/>					
</div>
<div style="float:left;margin-left:10px;">
<b>Tuesday</b>
					<div class="gray_back" style="background:#ffffff;" id="day2">
						<div class="top_date">
							<div class="time_start">From</div>
							<div class="actual_time" style="border:0px;"><div id="sample2">
        <p>
            <input name="data[Availability][tuesday_from]" value="<?php if(isset($availability['Availability']['tuesday_from']) && $availability['Availability']['any_time_email']==0){echo $availability['Availability']['tuesday_from'];}?>" id="time3"/>
        </p>
    </div></div>
							<!--<div class="actual_time actual_right">
							   <div class="on_off">
									<select name="data[Availability][tuesday_from_format]">
										<option value="0" <?php echo((isset($availability['Availability']['tuesday_from_format']) && $availability['Availability']['tuesday_from_format']==0 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>AM</option>
										<option value="1" <?php echo((isset($availability['Availability']['tuesday_from_format']) && $availability['Availability']['tuesday_from_format']==1 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>PM</option>
									</select>
								</div>
							</div>-->
						</div>
						<div class="bottom_date">
							<div class="time_start">Till</div>
							<div class="actual_time" style="border:0px;"><div id="sample2">
        <p>
            <input name="data[Availability][tuesday_to]" value="<?php if(isset($availability['Availability']['tuesday_to']) && $availability['Availability']['any_time_email']==0){echo $availability['Availability']['tuesday_to'];}?>" id="time4"/>
        </p>
    </div></div>
							<!--<div class="actual_time actual_right">
							    <div class="on_off">
									<select name="data[Availability][tuesday_to_format]">
										<option value="0" <?php echo((isset($availability['Availability']['tuesday_to_format']) && $availability['Availability']['tuesday_to_format']==0 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>AM</option>
										<option value="1" <?php echo((isset($availability['Availability']['tuesday_to_format']) && $availability['Availability']['tuesday_to_format']==1 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>PM</option>
									</select>
								</div>
							</div>-->
						</div>
					</div>
</div>
				</li>
				<li>
<div style="float:left">
<input type="checkbox" id="wednesday" name="wednesday" value="1" onclick="check_allwednesday()" style="margin-top:-2px;" checked/>
</div>
<div style="float:left;margin-left:10px;">
					<b>Wednesday</b>
					<div class="gray_back" style="background:#ffffff;" id="day3">
						<div class="top_date">
							<div class="time_start">From</div>
							<div class="actual_time" style="border:0px;"><div id="sample2">
        <p>
            <input value="<?php if(isset($availability['Availability']['wednesday_from']) && $availability['Availability']['any_time_email']==0){echo $availability['Availability']['wednesday_from'];}?>" name="data[Availability][wednesday_from]" id="time5"/>
        </p>
    </div></div>
							<!--<div class="actual_time actual_right">
							    <div class="on_off">
									<select name="data[Availability][wednesday_from_format]">
										<option value="0" <?php echo((isset($availability['Availability']['wednesday_from_format']) && $availability['Availability']['wednesday_from_format']==0 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>AM</option>
										<option value="1" <?php echo((isset($availability['Availability']['wednesday_from_format']) && $availability['Availability']['wednesday_from_format']==1 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>PM</option>
									</select>
								</div>
							</div>-->
						</div>
						<div class="bottom_date">
							<div class="time_start">Till</div>
							<div class="actual_time" style="border:0px;"><div id="sample2">
        <p>
            <input name="data[Availability][wednesday_to]" value="<?php if(isset($availability['Availability']['wednesday_to']) && $availability['Availability']['any_time_email']==0){echo $availability['Availability']['wednesday_to'];}?>" id="time6"/>
        </p>
    </div></div>
							<!--<div class="actual_time actual_right">
							    <div class="on_off">
									<select name="data[Availability][wednesday_to_format]">
										<option value="0" <?php echo((isset($availability['Availability']['wednesday_to_format']) && $availability['Availability']['wednesday_to_format']==0 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>AM</option>
										<option value="1" <?php echo((isset($availability['Availability']['wednesday_to_format']) && $availability['Availability']['wednesday_to_format']==1 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>PM</option>
									</select>
								</div>
							</div>-->
						</div>
					</div>
</div>
				</li>
				<li>
<div style="float:left">
<input type="checkbox" id="thursday" name="thursday" value="1" onclick="check_allthursday()" style="margin-top:-2px;" checked/>
</div>
<div style="float:left;margin-left:10px;">
					<b>Thursday</b>
					<div class="gray_back" style="background:#ffffff;" id="day4">
						<div class="top_date">
							<div class="time_start">From</div>
							<div class="actual_time" style="border:0px;"><div id="sample2">
        <p>
            <input name="data[Availability][thursday_from]" value="<?php if(isset($availability['Availability']['thursday_from']) && $availability['Availability']['any_time_email']==0){echo $availability['Availability']['thursday_from'];}?>" id="time7"/>
        </p>
    </div></div>
							<!--<div class="actual_time actual_right">
							   <div class="on_off">
									<select name="data[Availability][thursday_from_format]">
										<option value="0" <?php echo((isset($availability['Availability']['thursday_from_format']) && $availability['Availability']['thursday_from_format']==0 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>AM</option>
										<option value="1" <?php echo((isset($availability['Availability']['thursday_from_format']) && $availability['Availability']['thursday_from_format']==1 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>PM</option>
									</select>
								</div>
							</div>-->
						</div>
						<div class="bottom_date">
							<div class="time_start">Till</div>
							<div class="actual_time" style="border:0px;"><div id="sample2">
        <p>
            <input name="data[Availability][thursday_to]" value="<?php if(isset($availability['Availability']['thursday_to']) && $availability['Availability']['any_time_email']==0){echo $availability['Availability']['thursday_to'];}?>" id="time8"/>
        </p>
    </div></div>
							<!--<div class="actual_time actual_right">
							   <div class="on_off">
									<select name="data[Availability][thursday_to_format]">
										<option value="0" <?php echo((isset($availability['Availability']['thursday_to_format']) && $availability['Availability']['thursday_to_format']==0 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>AM</option>
										<option value="1" <?php echo((isset($availability['Availability']['thursday_to_format']) && $availability['Availability']['thursday_to_format']==1 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>PM</option>
									</select>
								</div>
							</div>-->
						</div>
					</div>
</div>
				</li>
				<li>
<div style="float:left">
<input type="checkbox" id="friday" name="friday" value="1" onclick="check_allfriday()" style="margin-top:-2px;" checked/>
</div>
<div style="float:left;margin-left:10px;">
					<b>Friday</b>
					<div class="gray_back" style="background:#ffffff;" id="day5"> 
						<div class="top_date">
							<div class="time_start">From</div>
							<div class="actual_time" style="border:0px;"><div id="sample2">
        <p>
            <input value="<?php if(isset($availability['Availability']['friday_from']) && $availability['Availability']['any_time_email']==0){echo $availability['Availability']['friday_from'];}?>" name="data[Availability][friday_from]" id="time9"/>
        </p>
    </div></div>
							<!--<div class="actual_time actual_right">
							   <div class="on_off">
									<select name="data[Availability][friday_from_format]">
										<option value="0" <?php echo((isset($availability['Availability']['friday_from_format']) && $availability['Availability']['friday_from_format']==0 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>AM</option>
										<option value="1" <?php echo((isset($availability['Availability']['friday_from_format']) && $availability['Availability']['friday_from_format']==1 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>PM</option>
									</select>
								</div>
							</div>-->
						</div>
						<div class="bottom_date">
							<div class="time_start">Till</div>
							<div class="actual_time" style="border:0px;"><div id="sample2">
        <p>
            <input value="<?php if(isset($availability['Availability']['friday_to']) && $availability['Availability']['any_time_email']==0){echo $availability['Availability']['friday_to'];}?>"  name="data[Availability][friday_to]" id="time10"/>
        </p>
    </div></div>
							<!--<div class="actual_time actual_right">
							   <div class="on_off">
									<select name="data[Availability][friday_to_format]">
										<option value="0" <?php echo((isset($availability['Availability']['friday_to_format']) && $availability['Availability']['friday_to_format']==0 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>AM</option>
										<option value="1" <?php echo((isset($availability['Availability']['friday_to_format']) && $availability['Availability']['friday_to_format']==1 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>PM</option>
									</select>
								</div>
							</div>-->
						</div>
					</div>
</div>
				</li>
				<li>
<div style="float:left">
<input type="checkbox" id="saturday" name="saturday" value="1" onclick="check_allsaturday()" style="margin-top:-2px;" checked/>
</div>
<div style="float:left;margin-left:10px;">
					<b>Saturday</b>
					<div class="gray_back" style="background:#ffffff;" id="day6">
						<div class="top_date">
							<div class="time_start">From</div>
							<div class="actual_time" style="border:0px;"><div id="sample2">
        <p>
            <input value="<?php if(isset($availability['Availability']['saturday_from']) && $availability['Availability']['any_time_email']==0){echo $availability['Availability']['saturday_from'];}?>"  name="data[Availability][saturday_from]" id="time11"/>
        </p>
    </div></div>
							<!--<div class="actual_time actual_right">
							    <div class="on_off">
									<select name="data[Availability][saturday_from_format]">
										<option value="0" <?php echo((isset($availability['Availability']['saturday_from_format']) && $availability['Availability']['saturday_from_format']==0 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>AM</option>
										<option value="1" <?php echo((isset($availability['Availability']['saturday_from_format']) && $availability['Availability']['saturday_from_format']==1 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>PM</option>
									</select>
								</div>
							</div>-->
						</div>
						<div class="bottom_date">
							<div class="time_start">Till</div>
							<div class="actual_time" style="border:0px;"><div id="sample2">
        <p>
            <input value="<?php if(isset($availability['Availability']['saturday_to']) && $availability['Availability']['any_time_email']==0){echo $availability['Availability']['saturday_to'];}?>"  name="data[Availability][saturday_to]" id="time12"/>
        </p>
    </div></div>
							<!--<div class="actual_time actual_right">
							   <div class="on_off">
									<select name="data[Availability][saturday_to_format]">
										<option value="0" <?php echo((isset($availability['Availability']['saturday_to_format']) && $availability['Availability']['saturday_to_format']==0 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>AM</option>
										<option value="1" <?php echo((isset($availability['Availability']['saturday_to_format']) && $availability['Availability']['saturday_to_format']==1 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>PM</option>
									</select>
								</div>
								
							</div>-->
						</div>
					</div>
</div>
				</li>
				<li>
<div style="float:left">
<input type="checkbox" id="sunday" name="sunday" value="1" onclick="check_allsunday()" style="margin-top:-2px;" checked/>
</div>
<div style="float:left;margin-left:10px;">
					<b>Sunday</b>
					<div class="gray_back" style="background:#ffffff;" id="day7">
						<div class="top_date">
							<div class="time_start">From</div>
							<div class="actual_time" style="border:0px;"><div id="sample2">
        <p>
            <input value="<?php if(isset($availability['Availability']['sunday_from']) && $availability['Availability']['any_time_email']==0){echo $availability['Availability']['sunday_from'];}?>"  name="data[Availability][sunday_from]" id="time13"/>
        </p>
    </div></div>
							<!--<div class="actual_time actual_right">
							     <div class="on_off">
									<select name="data[Availability][sunday_from_format]">
										<option value="0" <?php echo((isset($availability['Availability']['sunday_from_format']) && $availability['Availability']['sunday_from_format']==0 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>AM</option>
										<option value="1" <?php echo((isset($availability['Availability']['sunday_from_format']) && $availability['Availability']['sunday_from_format']==1 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>PM</option>
									</select>
								</div>
							</div>-->
						</div>
						<div class="bottom_date">
							<div class="time_start">Till</div>
							<div class="actual_time" style="border:0px;"><div id="sample2">
        <p>
            <input value="<?php if(isset($availability['Availability']['sunday_to']) && $availability['Availability']['any_time_email']==0){echo $availability['Availability']['sunday_to'];}?>" name="data[Availability][sunday_to]" id="time14"/>
        </p>
    </div></div>
							<!--<div class="actual_time actual_right">
							    <div class="on_off">
									<select name="data[Availability][sunday_to_format]">
										<option value="0" <?php echo((isset($availability['Availability']['sunday_to_format']) && $availability['Availability']['sunday_to_format']==0 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>AM</option>
										<option value="1" <?php echo((isset($availability['Availability']['sunday_to_format']) && $availability['Availability']['sunday_to_format']==1 && $availability['Availability']['any_time_email']==0)?'selected':'')?>>PM</option>
									</select>
								</div>
							</div>-->
						</div>
					</div>
</div>
				</li>
				<div class="clearfix"></div>
				<p class="loato_p"><?php echo $sitesetting['SiteSetting']['skill_availability_field3']; ?></p>
			</ul>
			<div class="name lato_step_1_sec_1_small"><?php echo $sitesetting['SiteSetting']['skill_availability_field4']; ?>&nbsp;&nbsp;<span id="restimeerr" style="color:red"></span></div>
			<div class="fields">
				<ul class="radio_select">
					<li><input type="radio" name="data[Availability][respond_time]" id="respond_time1" value="Few Hours" <?php if(isset($availability['Availability']['respond_time']) && $availability['Availability']['respond_time']=='Few Hours'){echo 'checked';}?>/><p><?php echo $sitesetting['SiteSetting']['skill_availability_field5']; ?></p></li>
					<li><input type="radio" name="data[Availability][respond_time]" id="respond_time2" value="1 Day" <?php if(isset($availability['Availability']['respond_time']) && $availability['Availability']['respond_time']=='1 Day'){echo 'checked';}?>/><p><?php echo $sitesetting['SiteSetting']['skill_availability_field6']; ?></p></li>
					<li><input type="radio" name="data[Availability][respond_time]" id="respond_time3" value="3 Day" <?php if(isset($availability['Availability']['respond_time']) && $availability['Availability']['respond_time']=='3 Day'){echo 'checked';}?>/><p><?php echo $sitesetting['SiteSetting']['skill_availability_field7']; ?></p></li>
					<li><input type="radio" name="data[Availability][respond_time]" id="respond_time4" value="1 Week" <?php if(isset($availability['Availability']['respond_time']) && $availability['Availability']['respond_time']=='1 Week'){echo 'checked';}?>/><p><?php echo $sitesetting['SiteSetting']['skill_availability_field8']; ?></p></li>
				</ul>
			</div>
			<!--<div class="name lato_step_1_sec_1_small"><?php echo $sitesetting['SiteSetting']['skill_availability_field9']; ?>&nbsp;&nbsp;<span id="availdeterr" style="color:red"></span></div>
			<div class="fields">
				<textarea name="data[Availability][availability_details]" id="availability_details" onkeyup="remove_err('availdeterr',this.value)"><?php if(isset($availability['Availability']['availability_details']) && $availability['Availability']['availability_details']!=''){echo $availability['Availability']['availability_details'];}?></textarea>
			</div>-->
			<input type="hidden" name="data[Availability][availability_details]" value='' ? />
			<div class="clearfix"></div>
<!--			<div class="fields">
<a href="<?php echo $this->webroot.'skills/step3/'.$skill_id.'';?>"><div class="step_back">Price</div></a><input type="button" value="Final" class="studio_btn" onclick=""/>
			</div>-->
		  </form>
		</div>
	</div>
</div>
   
<div style="height:135px;background-color:#F1F1F1" >&nbsp;</div>
<style>
#sample2 input
{
width:150px;
}
</style>
<script>
function check_allmonday()
{
if(document.getElementById('monday').checked==true)
{
document.getElementById("time1").disabled = false;
document.getElementById("time2").disabled = false;
document.getElementById('day1').style.background='#ffffff';
}
else
{
document.getElementById("time1").disabled = true;
document.getElementById("time2").disabled = true;
document.getElementById('day1').style.background='#f1f1f1';
}

}
function check_alltuesday()
{
if(document.getElementById('tuesday').checked==true)
{
document.getElementById("time3").disabled = false;
document.getElementById("time4").disabled = false;
document.getElementById('day2').style.background='#ffffff';
}
else
{
document.getElementById("time3").disabled = true;
document.getElementById("time4").disabled = true;
document.getElementById('day2').style.background='#f1f1f1';
}
}
function check_allthursday()
{
if(document.getElementById('thursday').checked==true)
{
document.getElementById("time7").disabled = false;
document.getElementById("time8").disabled = false;
document.getElementById('day4').style.background='#ffffff';
}
else
{
document.getElementById("time7").disabled = true;
document.getElementById("time8").disabled = true;
document.getElementById('day4').style.background='#f1f1f1';
}
}
function check_allwednesday()
{
if(document.getElementById('wednesday').checked==true)
{
document.getElementById("time5").disabled = false;
document.getElementById("time6").disabled = false;
document.getElementById('day3').style.background='#ffffff';
}
else
{
document.getElementById("time5").disabled = true;
document.getElementById("time6").disabled = true;
document.getElementById('day3').style.background='#f1f1f1';
}
}
function check_allfriday()
{
if(document.getElementById('friday').checked==true)
{
document.getElementById("time9").disabled = false;
document.getElementById("time10").disabled = false;
document.getElementById('day5').style.background='#ffffff';
}
else
{
document.getElementById("time9").disabled = true;
document.getElementById("time10").disabled = true;
document.getElementById('day5').style.background='#f1f1f1';
}

}
function check_allsaturday()
{
if(document.getElementById('saturday').checked==true)
{
document.getElementById("time11").disabled = false;
document.getElementById("time12").disabled = false;
document.getElementById('day6').style.background='#ffffff';
}
else
{
document.getElementById("time11").disabled = true;
document.getElementById("time12").disabled = true;
document.getElementById('day6').style.background='#f1f1f1';
}
}
function check_allsunday()
{
if(document.getElementById('sunday').checked==true)
{
document.getElementById("time13").disabled = false;
document.getElementById("time14").disabled = false;
document.getElementById('day7').style.background='#ffffff';
}
else
{
document.getElementById("time13").disabled = true;
document.getElementById("time14").disabled = true;
document.getElementById('day7').style.background='#f1f1f1';
}
}
</script>


