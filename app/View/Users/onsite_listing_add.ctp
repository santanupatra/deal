<section class="signin_sec">
    	<div class="container">
        	<div class="row">
            	<div class="profile_rapper">
                  <?php echo($this->element('user_leftbar'));?>      
                  <div class="col-md-9">
                     <div class="personal_profile">
                         <div class="personal_tables">  
                                <div class="personal_title">
                                    <p>Create New</p>
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
                                      <input class="form-control" id="title" type="text" name="data[Spa][title]">
                                    </div>
                                     <p style="margin-left:18.5%;"><b>Note:</b> Enter your full name if you wish to publish yourself as the independent professional, or list a company name.</p>
                                  </div>
                                  <div class="form-group">
                                    <div>
                                    <label for="inputPassword3" class="col-sm-2 control-label">Images*</label>
                                    <div class="col-sm-10">
                                      <input type="file" id="thespaphotos" name="photos[]" multiple="true"/>
				      <input type="hidden" name="data[List][picnum]" value="0" id="picnum"/>
				      <input type="hidden" name="data[List][totalpics]" value="0" id="totalpics"/>
				      <input type="hidden" name="data[List][picnumssn]" value="0" id="picnumssn"/>
                                      <div id="Preview" style="margin-top:20px;display:none;"></ul></div>
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
                                            <option value="<?php echo $allcountry['Country']['id'];?>"><?php echo $allcountry['Country']['name'];?></option>
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
                                        <select class="form-control" id="spa_type" name="data[Spa][spa_type][]" style=" height:80px;" multiple="">
                                          <option value="">Select Spa Type</option>
                                          <?php foreach($allspatypes as $allspatype){ ?>
                                            <option value="<?php echo $allspatype['SpaType']['id'];?>"><?php echo $allspatype['SpaType']['name'];?></option>
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
                                          <?php foreach($allpampertypes as $allpampertype){ ?>
                                            <option value="<?php echo $allpampertype['PamperType']['id'];?>"><?php echo $allpampertype['PamperType']['name'];?></option>
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
                                        <select class="form-control" id="fit_type" name="data[Spa][fit_type][]" style="height:80px;" multiple="">
                                          <option value="">Select Fit Type</option>
                                          <?php foreach($allfittypes as $allfittype){ ?>
                                            <option value="<?php echo $allfittype['FitType']['id'];?>"><?php echo $allfittype['FitType']['name'];?></option>
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
                                          <option value="1">Yes</option>
                                          <option value="0">No</option>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                      <button type="submit" class="btn btn-default signin" id="bannerbtn" onclick="return topbanner_validate();">Next</button>
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
