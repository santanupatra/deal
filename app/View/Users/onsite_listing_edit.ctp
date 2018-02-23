<section class="signin_sec">
    	<div class="container">
        	<div class="row">
            	<div class="profile_rapper">
                  <?php echo($this->element('user_leftbar'));?>      
                  <div class="col-md-9">
                     <div class="personal_profile">
                         <div class="personal_tables">  
                                <div class="personal_title">
                                    <p>Edit</p>
                                </div>                    
                                <div class="protable_title">
                                        <p>Top Banner</p>
                                        <div class="clearfix"></div>
                                        <span id="tb_validation_err_msg"></span>
                                    </div>
                                <div class="personal_desc personal_edit"> 
                                <form class="form-horizontal" method="post" action=''>
                                  <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Spa Title*</label>
                                    <div class="col-sm-10">
                                      <input class="form-control" id="title" type="text" name="data[Spa][title]" value="<?php echo(!empty($getspa)?$getspa['Spa']['title']:'');?>">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <div>
                                    <label for="inputPassword3" class="col-sm-2 control-label">Images*</label>
                                    <div class="col-sm-10">
                                      <input type="file" id="thespaphotos" name="photos[]" multiple="true"/>
				      <input type="hidden" name="data[List][picnum]" value="0" id="picnum"/>
				      <input type="hidden" name="data[List][totalpics]" value="0" id="totalpics"/>
				      <input type="hidden" name="data[List][picnumssn]" value="0" id="picnumssn"/>
                                      
										<?php
										if(!empty($spaImages))
										{
										?>	<div id="Preview" style="margin-top:20px;">
										<?php	
											foreach($spaImages as $spaImage)
											{
										?>
												<li id="newImage<?php echo $spaImage['SpaImage']['id']?>" style="list-style:none;float:left;margin-right: 20px;position:relative;">
													<img src="<?php echo $this->webroot.'spa_images/'.$spaImage['SpaImage']['image'];?>" alt="img" style="width:70px;height:70px;border: 1px solid #ccc;">
													<a href="javascript:void(0)" class="cross" onclick="delpic_db('<?php echo $spaImage['SpaImage']['id']?>')" id="cross<?php echo $spaImage['SpaImage']['id']?>"><img src="<?php echo $this->webroot;?>images/erase.png" alt="" style="position: absolute;right: -11px;bottom: 0;"></a>
												</li>
										<?php
											}?></div>
										<?php
										}
										else{ ?>
										<div id="Preview" style="margin-top:20px;"></div>
										<?php }?>
									  
                                    </div>
                                    <p style="margin-left:18.5%;"><b>Note:</b> Your can choose maximum 10 images. Please choose only .png, .jpg, .jpeg, .gif image type.</p>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Country*</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border-radius: 2px;">
                                        <select class="form-control" id="country" name="data[Spa][country]" onchange="getstates();">
                                          <option value="">Select Country</option>
                                          <?php foreach($allcountries as $allcountry){ ?>
                                            <option value="<?php echo $allcountry['Country']['id'];?>" <?php echo(!empty($getspa)?($allcountry['Country']['id']==$getspa['Spa']['country_id']?'Selected':''):'');?> ><?php echo $allcountry['Country']['name'];?></option>
                                          <?php } ?>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">State / Province*</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border-radius: 2px;">
                                        <select class="form-control" id="state" name="data[Spa][state]" onchange="getcities();">
                                          <option value="">Select State</option>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">City*</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border-radius: 2px;">
                                        <select class="form-control" id="city" name="data[Spa][city]" onchange="getareas();">
                                          <option value="">Select City</option>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Area</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border-radius: 2px;">
                                        <select class="form-control" id="area" name="data[Spa][area]">
                                          <option value="">Select Area</option>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Spa Type*</label>
                                    <div>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border-radius: 2px;">
                                        <select class="form-control" id="spa_type" name="data[Spa][spa_type][]" multiple="" style=" height:80px;">
                                          <option value="">Select Spa Type</option>
                                          <?php 
										  
										  $spaType = explode(',',$getspa['Spa']['spa_type_id']);
										  foreach($allspatypes as $allspatype){ 
										  ?>
                                            <option value="<?php echo $allspatype['SpaType']['id'];?>" <?php echo(!empty($spaType)?(in_array($allspatype['SpaType']['id'],$spaType)?'Selected':''):'');?>><?php echo $allspatype['SpaType']['name'];?></option>
                                          <?php } ?>
                                        </select>
                                    </div>
                                    <p style="margin-left:18.5%;"><b>Note:</b> Your listing will appear in the Spa Types you choose as a refined search result.</p>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Get Pampered*</label>
                                    <div>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border-radius: 2px;">
                                        <select class="form-control" id="pamper_type" name="data[Spa][pamper_type][]" multiple="" style=" height:80px;">
                                          <option value="">Select Pamper Type</option>
                                          <?php 
										  $parameterType = explode(',',$getspa['Spa']['pamper_type_id']);
										  foreach($allpampertypes as $allpampertype){ ?>
                                            <option value="<?php echo $allpampertype['PamperType']['id'];?>" <?php echo(!empty($parameterType)?(in_array($allpampertype['PamperType']['id'],$parameterType)?'Selected':''):'');?>><?php echo $allpampertype['PamperType']['name'];?></option>
                                          <?php } ?>
                                        </select>
                                    </div>
                                    <p style="margin-left:18.5%;"><b>Note:</b> Your listing will appear in the Get Pampered options you choose as a refined search result.</p>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Get Fit*</label>
                                    <div>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border-radius: 2px;">
                                        <select class="form-control" id="fit_type" name="data[Spa][fit_type][]" multiple="" style=" height:80px;">
                                          <option value="">Select Fit Type</option>
                                          <?php 
										  $filterType = explode(',',$getspa['Spa']['fit_type_id']);
										  foreach($allfittypes as $allfittype){ ?>
                                            <option value="<?php echo $allfittype['FitType']['id'];?>"  <?php echo(!empty($filterType)?(in_array($allfittype['FitType']['id'],$filterType)?'Selected':''):'');?>><?php echo $allfittype['FitType']['name'];?></option>
                                          <?php } ?>
                                        </select>
                                    </div>
                                    <p style="margin-left:18.5%;"><b>Note:</b> Your listing will appear in the Get Fit options you choose as a refined search result.</p>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Do you sell Gift Cards?*</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border-radius: 2px;">
                                        <select class="form-control" id="gift_card" name="data[Spa][gift_card]">
                                          <option value="">Select Option</option>
                                          <option value="1" <?php echo(!empty($getspa)?($getspa['Spa']['gift_card']==1?'Selected':''):'');?>>Yes</option>
                                          <option value="0" " <?php echo(!empty($getspa)?($getspa['Spa']['gift_card']==0?'Selected':''):'');?>>No</option>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                      <button type="submit" class="btn btn-default signin" id="bannerbtn" onclick="return topbanner_validate_edit();">Next</button>
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
<script>

</script>