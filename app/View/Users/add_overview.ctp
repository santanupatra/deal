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
                                        <p>Overview</p>
                                        <div class="clearfix"></div>
                                        <span id="ov_validation_err_msg"></span>
                                    </div>
                                <div class="personal_desc personal_edit"> 
                                <form class="form-horizontal" method="post" action=''>
                                  <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label"></label>
                                    <div class="col-sm-10" style="font-size:15px;margin-bottom:4px;">
                                      Welcome to <b><?php echo $getspa['Spa']['title'];?></b>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">About*</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;padding:0;border:0px;">
                                        <textarea style="height:190px;width:100%;padding:4px 11px;border-radius: 4px;" id="about" name="data[Spa][about]"><?php echo(!empty($getspa)?$getspa['Spa']['about']:'');?></textarea>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Features*</label>
                                    <div>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;padding:0;border:0px;">
                                        <textarea style="height:190px;width:100%;padding:4px 11px;border-radius: 4px;" id="feature" name="data[Spa][feature]"><?php echo(!empty($getspa)?$getspa['Spa']['features']:'');?></textarea>
                                    </div>
                                    <p style="margin-left:18.5%;"><b>Note:</b> Please press Enter for every feature. They will be displayed in a bulleted list.</p>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                      <button type="submit" class="btn btn-default signin" id="overviewbtn" onclick="return overview_validate();">Next</button>
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
