<div style="width:100%;position:fixed;bottom:0px;margin:0px auto;background-color:#FEFEFE;height:90px;z-index:999;"><div style="width:50%;padding-top:17px;"><input type="button" value="Save" class="btn border_btn offer_my_skill dash_offer_skil1" style="background-color:#4743e2;border:1px solid #4743e2 !important;font-family: 'Lato',sans-serif !important;" onclick="return step2_validate() " ></div></div>
<div class="container_825">
	<div class="step1_sec1">
		<div class="row">
			<div class="col-sm-12 lato_step_1_sec_1" style="font-family: 'Lato',sans-serif !important;"><?php echo($sitesetting['SiteSetting']['skill_studio_heading']);?></div>
			<div class="col-sm-9 lato_step_1_sec_1_small margin_zero">
				<?php echo($sitesetting['SiteSetting']['skill_studio_description']);?>
			</div>
		</div>
	</div>
	<div class="step1_sec2">
	<form class="contact_form" name="step2" id="step2" action="<?php echo $this->webroot.'skills/step2/'.$skill_id.'';?>" method="POST" enctype="multipart/form-data">
		<div class="width_620">
			<div class="name lato_step_1_sec_1_small"><?php echo($sitesetting['SiteSetting']['skill_studio_field1']);?>&nbsp;&nbsp;<span id="adderr" style="color:red"></span></div>
			<div class="fields">
				<!-- <input type="text" placeholder="Type your nearby location" name="data[Skill][full_address]" id="full_address" value="<?php if(isset($skill['Skill']['skill_workshop_address']) && $skill['Skill']['skill_workshop_address']!=''){echo trim($skill['Skill']['skill_workshop_address'],', ');}?>" onblur="getmarkerlocationadd()" onkeyup="remove_err_add('adderr',this.value,'full_address')"/> -->
                                <input type="text" placeholder="Type your street address" name="data[Skill][full_address]" id="full_address" value="<?php if(isset($skill['Skill']['skill_workshop_address']) && $skill['Skill']['skill_workshop_address']!=''){echo trim($skill['Skill']['skill_workshop_address'],', ');}?>" onblur="getmarkerlocationadd()" onkeyup="remove_err_add('adderr',this.value,'full_address')"/>
			</div>
			<div class="fields">
				<input type="text" placeholder="Street" name="data[Skill][skill_street]" id="route" value="<?php if(isset($skill['Skill']['skill_street']) && $skill['Skill']['skill_street']!=''){echo $skill['Skill']['skill_street'];}?>" onblur="getmarkerlocation()" onkeyup="remove_err_add('adderr',this.value,'route')"/>
			</div>
			<div class="fields">
				<input type="text" name="data[Skill][skill_country]" placeholder="Country" id="country" value="<?php if(isset($skill['Skill']['skill_country']) && $skill['Skill']['skill_country']!=''){echo $skill['Skill']['skill_country'];}?>" onkeyup="remove_err_add('adderr',this.value,'country')"/>
			</div>
			<div class="fields">
				<input type="text" placeholder="Apt number (optional)" name="data[Skill][skill_aptno]" value="<?php if(isset($skill['Skill']['skill_aptno']) && $skill['Skill']['skill_aptno']!=''){echo $skill['Skill']['skill_aptno'];}?>" />
			</div>
			<div class="fields">
				<input type="text" placeholder="City" name="data[Skill][skill_city]" id="locality" value="<?php if(isset($skill['Skill']['skill_city']) && $skill['Skill']['skill_city']!=''){echo $skill['Skill']['skill_city'];}?>" onblur="getmarkerlocation()" onkeyup="remove_err_add('adderr',this.value,'locality')"/>
			</div>
			<div class="fields">
				<input type="text" placeholder="State" name="data[Skill][skill_state]" id="administrative_area_level_1" value="<?php if(isset($skill['Skill']['skill_state']) && $skill['Skill']['skill_state']!=''){echo $skill['Skill']['skill_state'];}?>" onblur="getmarkerlocation()" onkeyup="remove_err_add('adderr',this.value,'administrative_area_level_1')"/>
			</div>
			<div class="fields">
				<input type="text" placeholder="ZIP code" name="data[Skill][skill_zipcode]" id="postal_code" value="<?php if(isset($skill['Skill']['skill_zipcode']) && $skill['Skill']['skill_zipcode']!=''){echo $skill['Skill']['skill_zipcode'];}?>" onkeyup="remove_err_add('adderr',this.value,'postal_code')"/>
			</div>
			
			<div class="clearfix"></div>
<!--			<div class="name lato_step_1_sec_1_small"><?php echo($sitesetting['SiteSetting']['skill_studio_field2']);?></div><br/>-->
<!--			<div class="name lato_step_1_sec_1_small"><?php echo($sitesetting['SiteSetting']['skill_studio_field3']);?>&nbsp;&nbsp;<span id="maperr" style="color:red"></span></div>-->
		</div>
		<div class="step_map" id="map-canvas">
		</div>
		<input type="hidden" id="location" name="data[Skill][skill_workshop_address]" value="<?php if(isset($skill['Skill']['skill_workshop_address']) && $skill['Skill']['skill_workshop_address']!=''){echo trim($skill['Skill']['skill_workshop_address'],', ');}?>"/>
        <input type="hidden" id="lat" name="data[Skill][skill_workshop_lat]" value="<?php if(isset($skill['Skill']['skill_workshop_lat']) && $skill['Skill']['skill_workshop_lat']!=''){echo $skill['Skill']['skill_workshop_lat'];}else {echo '55.5314076';}?>"/>
	    <input type="hidden" id="lang" name="data[Skill][skill_workshop_lang]" value="<?php if(isset($skill['Skill']['skill_workshop_lang']) && $skill['Skill']['skill_workshop_lang']!=''){echo $skill['Skill']['skill_workshop_lang'];}else {echo '10.046474';}?>"/>
		<div class="width_620">
			<div class="clearfix"></div>
			<div class="name lato_step_1_sec_1_small"><?php echo($sitesetting['SiteSetting']['skill_studio_field4']);?>&nbsp;&nbsp;<span id="toolserr" style="color:red"></span></div>
			<div class="fields">
			    <?php
				  if(isset($xtr) && !empty($xtr))
				  {?>
					<input type="hidden" name="data[List][tagnum]" value="<?php echo count($xtr)?>" id="tagnum"/>
					<input type="hidden" name="data[List][totalTags]" value="<?php echo count($xtr)?>" id="totalTags"/>
					<div id="newTags">
					<?php
					for($i=0;$i<count($xtr);$i++)
					{?>
						<div class="tag_open" id="newTag<?php echo($i+1);?>"><input type="hidden" name="data[List][tag][<?php echo($i+1);?>]" value="<?php echo($xtr[$i]);?>">
						<img src="<?php echo($this->webroot)?>img/close_1.png" escape="false" onclick="delTag(<?php echo($i+1)?>);"/> <?php echo($xtr[$i]);?></div>
					<?php }
					?>
					</div>
				  <?php 
				  }else{?>
						<input type="hidden" name="data[List][tagnum]" value="0" id="tagnum"/>
						<input type="hidden" name="data[List][totalTags]" value="0" id="totalTags"/>
						<div id="newTags">
						</div>
				  <?php } ?>
				<div class="tag_open"><a href="javascript:void(0)" onclick="open_tag_textbox()"><img src="<?php echo $this->webroot; ?>img/stepplus.png" alt="Add Tag" /></a></div>
				<div id="tag_textbox_div" style="display:none;width:100%">
				  <input type="text" placeholder="Available tools" name="data[Skill][skill_tools]" id="Tags" style="width:95%" onkeypress="return add_tag_enter(event);"/>
				</div>
				<!-- <div class="clearfix"></div>
				<div id="tag_textbox_div" style="width:90%;float:left;">
				  <input type="text" placeholder="Available tools" name="data[Skill][skill_tools]" id="Tags" style="width:95%" />
				</div>
				<div class="tag_open" style="float:left;"><a href="javascript:void(0)" onclick="addnewTag()"><img src="<?php echo $this->webroot; ?>img/stepplus.png" alt="Add Tag" /></a></div> -->
			</div>
            <div class="clearfix"></div>
            <div class="name lato_step_1_sec_1_small">
				<?php echo($sitesetting['SiteSetting']['skill_studio_field7']);?>
                &nbsp;&nbsp;
                <span id="party_sizerr" style="color:red"></span>
            </div>
            <div class="fields">
                <div class="list_box">
                    <select onchange="remove_err('party_sizerr',this.value)" id="party_size" name="data[Skill][party_size]">
                        <option value="">N(number) of People</option>
                        <?php 
							for($ps=1;$ps<=20;$ps++) 
							{ ?>
                        		<option value="<?php echo $ps; ?>" <?php echo (isset($skill['Skill']['party_size']) && $skill['Skill']['party_size']==$ps)?'selected':'';?>><?php echo $ps; ?></option>
                                <?php
							}
						?>                       
                    </select>
                </div>
            </div>
			<div class="clearfix"></div>
			<div class="name lato_step_1_sec_1_small"><?php echo($sitesetting['SiteSetting']['skill_studio_field6']);?>&nbsp;&nbsp;<span id="studiodeterr" style="color:red"></span></div>
			<div class="fields">
				<textarea name="data[Skill][studio_details]" id="studio_details" onkeyup="remove_err('studiodeterr',this.value)"><?php if(isset($skill['Skill']['studio_details']) && $skill['Skill']['studio_details']!=''){echo $skill['Skill']['studio_details'];}?></textarea>
			</div>
			
			<div class="clearfix"></div>
			<div class="name lato_step_1_sec_1_small"><?php echo($sitesetting['SiteSetting']['skill_studio_field5']);?>&nbsp;&nbsp;<span id="toolspicerr" style="color:red"></span></div>
			<div class="fields" style="position:relative">
			    <div id="preview_overlay" style="position:absolute;background: url(<?php echo($this->webroot);?>img/prevback.png) repeat;width:100%;height:100%;z-index:999999;display:none;">
				       <div style=" color: #fff;display: block;font-size: 22px;font-weight: bold;margin: 8% auto 0;text-align: center;">
					    Please wait while uploading...
					   </div>
					   <img src="<?php echo($this->webroot);?>img/green-ajax-loader.gif" style="display:block;margin:0 auto;margin-top:3%;"/>
				</div>
				<ul class="up_image">
					<?php
				  if(isset($skillimages) && !empty($skillimages))
				  {?>
				    <div id="Preview">
					   <?php
						for($p=0;$p<count($skillimages);$p++)
						{?>
							<li class="image_add" id="newImage<?php echo($p+1);?>" onmouseover="show_del_img(<?php echo($p+1)?>)" onmouseout="hide_del_img(<?php echo($p+1)?>)"><input type="hidden" name="data[List][picedit][<?php echo($p+1);?>]" value="<?php echo($skillimages[$p]);?>"><img src="<?php echo $this->webroot;?>tool_images/thumb/<?php echo($skillimages[$p]);?>" height="155px" width="154px"/><a href="javascript:void(0)" class="cross" onclick="delpic(<?php echo($p+1)?>)" id="cross<?php echo($p+1)?>" style="display:none"></a></li>						
						<?php }
						?>
					</div>
				  <?php }else{ ?>
					<div id="Preview">
					</div>
				  <?php } ?>
					<li>
					 <!-- <div id="loader" style="width:100%;height:100%;background-color:#4743E2;display:none;position:absolute;z-index:999;top:0;left:0;background-image:url(<?php echo($this->webroot);?>img/loading.gif);background-repeat: no-repeat;background-position: center center;">
					 </div> -->
					 <img src="<?php echo $this->webroot; ?>img/big_plus.png" alt="Add Pics" onclick="performClickstp2()" style="cursor:pointer"/>
					</li>
				</ul>
				 <input type="file" id="theFile2" name="photos[]" style="display:none;" multiple="true"/>
				<?php
			      if(isset($skillimages) && !empty($skillimages))
			    {?>
				  <input type="hidden" name="data[List][picnum]" value="<?php echo count($skillimages)?>" id="picnum"/>
				  <input type="hidden" name="data[List][totalpics]" value="<?php echo count($skillimages)?>" id="totalpics"/>
				  <input type="hidden" name="data[List][picnumssn]" value="0" id="picnumssn"/>
				<?php }else{ ?>
				  <input type="hidden" name="data[List][picnum]" value="0" id="picnum"/>
				  <input type="hidden" name="data[List][totalpics]" value="0" id="totalpics"/>
				  <input type="hidden" name="data[List][picnumssn]" value="0" id="picnumssn"/>
				<?php } ?>
			</div>
			<!--<div class="fields">
                            <a href="<?php echo $this->webroot.'skills/edit_step1/'.$skill_id.'';?>"><div class="step_back">Your specialty</div></a><input type="button" value="Price" class="studio_btn" onclick="savebotton()"/>
			</div>-->
		</div>
	  </form>
	</div>
</div>
<div style="height:135px;background-color:#F1F1F1" >&nbsp;</div>
<style>
#map-canvas img { max-width: inherit; }
</style>
<script>
    function savebotton()
{
window.location.href='<?=$this->webroot?>skills/step3/<?=$skill_id?>';
}
</script>
