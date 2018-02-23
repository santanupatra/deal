
<div class="container_825">
	    	<div class="step1_sec1">
		<div class="row">
			<div class="col-sm-12 lato_step_1_sec_1"><?php echo($sitesetting['SiteSetting']['initiation_heading']);?></div>
			
		</div>
                </div> 
	    	<div class="step1_sec2">
	    		<div class="width_620">
				 <form class="contact_form" name="initiation" id="initiation" action="<?php echo $this->webroot.'skills/initiation'; ?>" method="POST">
	    			<div class="name lato_step_1_sec_1_small"><?php echo($sitesetting['SiteSetting']['initiation_field1']);?>&nbsp;&nbsp;<span id="caterr" style="color:red"></span></div>
	    			<div class="fields">
	    				<div class="list_box">
	    					<select name="data[Skill][category_id]" id="category_id" onchange="remove_err('caterr',this.value)">
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
	    				<input type="submit" value="Start Offering" class="studio_btn" onclick="return initiation_validate()"/>
	    			</div>
                            </form>
	    		</div>
	    	</div>
    	</div>

<style type="text/css">
/**********************************************step_1_new*********************************/
.studio_btn{
    width:200px !important;
}
.step1_sec1 {
    padding-bottom:0px !important;
}
.step1_sec2 {
    margin-top:0px !important;
}
</style>
