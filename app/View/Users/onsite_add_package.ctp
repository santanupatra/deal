<section class="signin_sec">
    	<div class="container">
        	<div class="row">
            	<div class="profile_rapper">
                  <?php echo($this->element('user_leftbar'));?>      
                  <div class="col-md-9">
                     <div class="personal_profile">
                         <div class="personal_tables">  
                                <div class="personal_title">
                                    <p><?php echo $getspa['Spa']['title'];?></p>
                                </div>                    
                                <div class="protable_title">
                                        <p>Treatments & Packages</p>
                                        <div class="clearfix"></div>
                                        <span id="tp_validation_err_msg"></span>
                                    </div>
                                <div class="personal_desc personal_edit"> 
                                <form class="form-horizontal" method="post" action=''>
								<input type="hidden" name="data[Spa][fratured_id]" value="<?php echo(!empty($featurePack)?$featurePack['Package']['id']:'');?>" id="fratured_id"/>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Featured Deal or Special*</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border:0px;">
                                        Title<br>
                                        <input class="form-control" id="fratured_title" type="text" name="data[Spa][fratured_title]" style="margin-bottom:10px;" value="<?php echo(!empty($featurePack)?$featurePack['Package']['title']:'');?>" >
                                        Duration (min)<br>
                                        <input class="form-control" id="fratured_duration" type="text" name="data[Spa][fratured_duration]" style="margin-bottom:10px;" onkeypress="return numbercheck(event);" value="<?php echo(!empty($featurePack)?$featurePack['Package']['duration']:'');?>">
                                        Price ($)<br>
                                        <input class="form-control" id="fratured_price" type="text" name="data[Spa][fratured_price]" style="margin-bottom:10px;" onkeypress="return numbercheck(event);" value="<?php echo(!empty($featurePack)?$featurePack['Package']['price']:'');?>">
                                        Short Description:<br>
                                        <textarea style="height:190px;width:100%;padding:4px 11px;border-radius:4px;" id="fratured_description" name="data[Spa][fratured_description]"><?php echo(!empty($featurePack)?$featurePack['Package']['description']:'');?></textarea>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Packages</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border:0px;">
                                        <?php 
										if(isset($packages) && !empty($packages))
										{
											foreach($packages as $package)
											{
											?>
												<input type="hidden" name="data[Spa][package_id][]" value="<?php echo($package['Package']['id']);?>" id="package_id<?php echo($package['Package']['id']);?>"/>
												Title<br>
												<input class="form-control" id="package_title" type="text" name="data[Spa][package_title][]" style="margin-bottom:10px;" value="<?php echo($package['Package']['title']);?>">
												Duration (min)<br>
												<input class="form-control" id="package_duration" type="text" name="data[Spa][package_duration][]" style="margin-bottom:10px;" onkeypress="return numbercheck(event);" value="<?php echo($package['Package']['duration']);?>">
												Price ($)<br>
												<input class="form-control" id="package_price" type="text" name="data[Spa][package_price][]" style="margin-bottom:10px;" onkeypress="return numbercheck(event);" value="<?php echo($package['Package']['price']);?>">
											   Short Description:<br>
												<textarea style="height:190px;width:100%;padding:4px 11px;border-radius:4px;" id="fratured_description" name="data[Spa][description][]"><?php echo($package['Package']['description']);?></textarea>

										<?php
											}
										}else{
										?>
											<input type="hidden" name="data[Spa][package_id][]" value=""/>
											Title<br>
											<input class="form-control" id="package_title" type="text" name="data[Spa][package_title][]" style="margin-bottom:10px;">
											Duration (min)<br>
											<input class="form-control" id="package_duration" type="text" name="data[Spa][package_duration][]" style="margin-bottom:10px;" onkeypress="return numbercheck(event);">
											Price ($)<br>
											<input class="form-control" id="package_price" type="text" name="data[Spa][package_price][]" style="margin-bottom:10px;" onkeypress="return numbercheck(event);">
										   Short Description:<br>
											<textarea style="height:190px;width:100%;padding:4px 11px;border-radius:4px;" id="fratured_description" name="data[Spa][description][]"></textarea>
										<?php
										}?>
										
                                        <div id="morepackages">
                                         
                                        </div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                      <button type="button" class="btn btn-default signin" id="overviewbtn" onclick="add_package();"><i class="fa fa-plus-circle"></i> Add New Package</button>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Treatments*</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border:0px;">
                                       
										<?php 
										if(isset($treatments) && !empty($treatments))
										{
											foreach($treatments as $treatment)
											{
											?>
												<input type="hidden" name="data[Spa][treatment_id][]" value="<?php echo($treatment['Treatment']['id']);?>" id="package_id<?php echo($treatment['Treatment']['id']);?>"/>
												Category (ie. Massage or Body Treatment or Facial etc.)<br>
												<input class="form-control" id="treatment_category" type="text" name="data[Spa][treatment_category][]" style="margin-bottom:10px;" value="<?php echo($treatment['Treatment']['category']);?>">
												Title<br>
												<input class="form-control" id="treatment_title" type="text" name="data[Spa][treatment_title][]" style="margin-bottom:10px;" value="<?php echo($treatment['Treatment']['title']);?>">
												Duration (min)<br>
												<input class="form-control" id="treatment_duration" type="text" name="data[Spa][treatment_duration][]" style="margin-bottom:10px;" onkeypress="return numbercheck(event);" value="<?php echo($treatment['Treatment']['duration']);?>">
												Price ($)<br>
												<input class="form-control" id="treatment_price" type="text" name="data[Spa][treatment_price][]" style="margin-bottom:10px;" onkeypress="return numbercheck(event);" value="<?php echo($treatment['Treatment']['price']);?>">
												Short Description<br>
												<textarea style="height:190px;width:100%;padding:4px 11px;border-radius:4px;" id="fratured_description" name="data[Spa][treatment_description][]"><?php echo($treatment['Treatment']['description']);?></textarea>
										<?php
											}
										}else{
										?>
											<input type="hidden" name="data[Spa][treatment_id][]" value=""/>
											Category (ie. Massage or Body Treatment or Facial etc.)<br>
											<input class="form-control" id="treatment_category" type="text" name="data[Spa][treatment_category][]" style="margin-bottom:10px;">
											Title<br>
											<input class="form-control" id="treatment_title" type="text" name="data[Spa][treatment_title][]" style="margin-bottom:10px;">
											Duration (min)<br>
											<input class="form-control" id="treatment_duration" type="text" name="data[Spa][treatment_duration][]" style="margin-bottom:10px;" onkeypress="return numbercheck(event);">
											Price ($)<br>
											<input class="form-control" id="treatment_price" type="text" name="data[Spa][treatment_price][]" style="margin-bottom:10px;" onkeypress="return numbercheck(event);">
											Short Description<br>
											<textarea style="height:190px;width:100%;padding:4px 11px;border-radius:4px;" id="fratured_description" name="data[Spa][treatment_description][]"></textarea>
										<?php
										}?>
										
                                        
                                        
                                        <div id="moretreatment">
                                         
                                        </div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                      <button type="button" class="btn btn-default signin" id="overviewbtn" onclick="add_treatment();"><i class="fa fa-plus-circle"></i> Add New Treatment</button>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                      <button type="submit" class="btn btn-default signin" id="overviewbtn" onclick="return package_validate();">Next</button>
                                    </div>
                                  </div>
                                </form>                                
                            	</div>              
                        </div>                         
                    </div>
                  </div>      
                </div>
            </div>
        </div>
    </section>
