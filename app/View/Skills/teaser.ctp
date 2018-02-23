
<div class="container_825">
	    	<div class="step1_sec1">
	    		<div class="row">
	    			<div class="col-sm-12 lato_step_1_sec_1"><?php echo($sitesetting['SiteSetting']['teaser_heading']);?></div>
	    			<div class="col-sm-9 lato_step_1_sec_1_small margin_zero">
	    				<?php echo($sitesetting['SiteSetting']['teaser_description']);?>
                                    				 <form class="contact_form" name="initiation" id="initiation" action="<?php echo $this->webroot.'skills/initiation'; ?>" method="POST">
	    			<div class="name lato_step_1_sec_1_small"><?php echo($sitesetting['SiteSetting']['initiation_field1']);?>&nbsp;&nbsp;<span id="caterr" style="color:red"></span></div>
	    			<div class="fields">
	    				<div class="list_box">
	    					<select name="data[Skill][category_id]" id="category_id" onchange="remove_err('caterr',this.value)" style="width:107% !important;">
								<option value="">Select Skill</option>
								<?php 
								if(!empty($categories))
								{
									foreach($categories as $category)
									{
									?>
									<option value="<?php echo $category['Category']['id'];?>"><?php echo $category['Category']['name'];?></option>
									<?php 
									}
								}
								?>
							</select>
	    				</div>   			
	    			</div>
	    			<div class="clearfix"></div>
                                <div class="name lato_step_1_sec_1_small"><?php echo($sitesetting['SiteSetting']['initiation_field2']);?>&nbsp;&nbsp;<span id="Abouterr" style="color:red"></span></div>
                                <div class="fields">
                                <input type="text" placeholder="What is it about specifically?" name="data[Skill][about_specifically]" id="AboutSpecifically" style="width:100%" />

                                </div>
	    			
	    			<div class="clearfix"></div>
	    			<div class="fields">
	    				<input type="submit" value="Start Offering" class="studio_btn" style="width:200px;height:60px;font-family:Montserrat regular;" onclick="return initiation_validate()"/>
	    			</div>
                            </form>
	    			</div>
                                
<!--					<div class="col-sm-9 lato_step_1_sec_1_small margin_zero">
                      <input class="studio_btn" type="submit" onclick="window.location='<?php echo $this->webroot; ?>skills/initiation'" value="Next">
					</div>-->
	    		</div>
	    	</div>
    	</div>

<style type="text/css">
/**********************************************step_1_new*********************************/
.image_profile_upload{width:100%;height:285px;background-color:#eeeeee;position: relative;cursor:move}
.upload_image_btn{width:332px;height:52px;background-color:#4743e2;border:0;position: absolute;z-index:999;top:115px;left:150px;background-image:url(<?php echo($this->webroot);?>img/upload_image.png);background-repeat: no-repeat;background-position:60px center;color:#fff;font-size:13px;text-indent:15px;overflow: hidden}
.image_profile_upload img{width:100%;height:100%}
.fields .up_image{width:100%;margin:0;padding: 0}
.fields .up_image li{width:198px;height:332px;float:left;float:left;list-style: none;margin:0;position: relative;border:0px solid red;margin-bottom:13px;margin-right:13px;}
.fields .up_image li img{width:198px;height:129px;float:left;float:left;}
.fields .up_image li:nth-child(3n+3){margin-right: 0 ;float:right !important }
.fields .up_image li .cross{width:23px;height:23px;display:block; background:url(<?php echo($this->webroot);?>img/backcross.png) no-repeat center center;position: absolute;z-index:999;left:10px;top:10px;border:0px solid red;}
.fields .up_image li textarea{width:198px;height:90px;background:#eeeeee;overflow: hidden;color:# color: #000;font-family: 'Lato',sans-serif !important;font-size: 13px;line-height:22px;text-align: left;resize:none;}
textarea {resize:none;}
.cropper-container{height:285px !important;top:0px !important}
</style>
