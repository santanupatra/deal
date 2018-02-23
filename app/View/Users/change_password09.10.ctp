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
                                        <p>Change Password</p>
                                        <div class="clearfix"></div>
                                        <span id="cp_validation_err_msg"></span>
                                    </div>
                                <div class="personal_desc personal_edit"> 
                                <form class="form-horizontal" method="post" action=''>
                                  <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Current Password*</label>
                                    <div class="col-sm-10">
                                      <input class="form-control" id="curr_pass" type="password" name="data[User][curr_pass]">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">New Password*</label>
                                    <div class="col-sm-10">
                                      <input class="form-control" id="new_pass" type="password" name="data[User][new_pass]">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Confirm Password*</label>
                                    <div class="col-sm-10">
                                      <input class="form-control" id="con_pass" type="password" name="data[User][con_pass]">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                      <button type="submit" class="btn btn-default signin" onclick="return validate_changepassword();">update</button>
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
