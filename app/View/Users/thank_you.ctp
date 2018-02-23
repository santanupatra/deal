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
                                <div class="protable_title" style="margin:20px 0;">
                                    <p style="padding-bottom: 14px;">You’re done!<br>
Visit your listing page to Preview and Post!</p>
                                        <div class="clearfix"></div>
                                </div>
                                <div class="personal_desc personal_edit"> 
                                <form class="form-horizontal" method="post" action=''>
                                  <div class="form-group">
                                    <div class="col-sm-12" style="text-align:center;">
                                      <a href="<?php echo $this->webroot;?>users/spa-listing"><button type="button" class="btn btn-default signin" id="overviewbtn">Back To Spa Listing</button></a>
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
