<section class="signin_sec">
    	<div class="container">
        	<div class="row">
            	<div class="profile_rapper">
                  <?php echo($this->element('user_leftbar'));?>      
                  <div class="col-md-9">
                     <div class="personal_profile">
                         <div class="personal_tables">  
                                <div class="personal_title">
                                    <p>Personal Profile</p>
                                </div>                    
                                <div class="protable_title">
                                        <p>Edit Profile</p>
                                        <div class="clearfix"></div>
                                        <span id="ep_validation_err_msg"></span>
                                    </div>
                                <div class="personal_desc personal_edit"> 
                                <form class="form-horizontal" method="post" action=''>
                                  <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">First Name*</label>
                                    <div class="col-sm-10">
                                      <input class="form-control" id="first_name" type="text" value="<?php if(isset($user['User']['first_name']) && $user['User']['first_name']!=''){echo $user['User']['first_name'];}?>" name="data[User][first_name]">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Last Name*</label>
                                    <div class="col-sm-10">
                                      <input class="form-control" id="last_name" type="text" name="data[User][last_name]" value="<?php if(isset($user['User']['last_name']) && $user['User']['last_name']!=''){echo $user['User']['last_name'];}?>">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Email*</label>
                                    <div class="col-sm-10">
                                      <input class="form-control" id="email" type="text" name="data[User][email]" value="<?php if(isset($user['User']['email']) && $user['User']['email']!=''){echo $user['User']['email'];}?>">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Mobile</label>
                                    <div class="col-sm-10">
                                      <input class="form-control" id="mobile" type="text" name="data[User][mobile_number]" value="<?php if(isset($user['User']['mobile_number']) && $user['User']['mobile_number']!=''){echo $user['User']['mobile_number'];}?>">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Paypal Business Email</label>
                                    <div class="col-sm-10">
                                      <input class="form-control" id="paypal_business_email" type="text" name="data[User][paypal_business_email]" value="<?php if(isset($user['User']['paypal_business_email']) && $user['User']['paypal_business_email']!=''){echo $user['User']['paypal_business_email'];}?>">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">About Me</label>
                                    <div class="col-sm-10">
                                      <textarea class="form-control" rows="3" id="bio" name="data[User][bio]"><?php if(isset($user['User']['bio']) && $user['User']['bio']!=''){echo $user['User']['bio'];}?></textarea>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Address</label>
                                    <div class="col-sm-10">
                                      <textarea class="form-control" rows="3" id="address" name="data[User][address]"><?php if(isset($user['User']['address']) && $user['User']['address']!=''){echo $user['User']['address'];}?></textarea>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Zip Code</label>
                                    <div class="col-sm-10">
                                      <input class="form-control" id="zip_code" type="text" name="data[User][zip_code]" value="<?php if(isset($user['User']['zip_code']) && $user['User']['zip_code']!=''){echo $user['User']['zip_code'];}?>">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Facebook</label>
                                    <div class="col-sm-10">
                                      <input class="form-control" id="facebook_url" type="text" name="data[User][facebook_url]" value="<?php if(isset($user['User']['facebook_url']) && $user['User']['facebook_url']!=''){echo $user['User']['facebook_url'];}?>">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Twitter</label>
                                    <div class="col-sm-10">
                                      <input class="form-control" id="twitter_url" type="text" name="data[User][twitter_url]" value="<?php if(isset($user['User']['twitter_url']) && $user['User']['twitter_url']!=''){echo $user['User']['twitter_url'];}?>">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Linkedin</label>
                                    <div class="col-sm-10">
                                      <input class="form-control" id="linkdin_url" type="text" name="data[User][linkdin_url]" value="<?php if(isset($user['User']['linkdin_url']) && $user['User']['linkdin_url']!=''){echo $user['User']['linkdin_url'];}?>">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Youtube</label>
                                    <div class="col-sm-10">
                                      <input class="form-control" id="youtube_url" type="text" name="data[User][youtube_url]" value="<?php if(isset($user['User']['youtube_url']) && $user['User']['youtube_url']!=''){echo $user['User']['youtube_url'];}?>">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                      <button type="submit" class="btn btn-default signin" onclick="return validate_editprofile();">update</button>
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
