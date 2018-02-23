<?php 
 $skillimages_exp=explode(',',$skill['SkillImage']['0']['image']);
 $subskill_exp=explode(',',$skill['Skill']['sub_category']);
 $avaltools_exp=explode(',',$skill['Skill']['skill_tools']);
 $skill_tool_pics_exp=explode(',',$skill['Skill']['skill_tool_pics']);

 $usrid = $this->Session->read('Auth.User.id');
?>

<link rel="stylesheet" type="text/css" href="<?php echo $this->webroot; ?>css/jquery-ui1.css" />
<div class="absolute_contact" id="absolute_contact">
  <form class="contact_form" name="reg_form_user" id="reg_form_user1" action="<?php echo $this->webroot.'skills/sendcontact/'.$skill['Skill']['id'].''; ?>" method="POST" >
	 <div class="contact_background poup_up_outer">
		<div class="contact_padding">
			<div class="popup_area">
            	<h1>SENT A MESSAGE TO <?php echo strtoupper($skill['User']['first_name']);?></h1>
	    		<div class="width_524">
	    			<div class="first_row">
	    				<div class="first_row_left">
                        	<p>When do you want do learn the skill?</p>
							<span style="color:red" id="date_err"></span>
                            <div class="calender_area">
                            	<div id="datepicker"></div>
                                <input type="hidden" name="data[Request][date_str]" id="date_str">
                            </div>
                        </div>
                        <div class="first_row_right">
                        	<p>What time suits you?</p>
							<span style="color:red" id="time_err"></span>
                            <div class="what_time">
                            	<ul>
                                	<li>
                                    	<div class="leftdiv" id="time_span">3</div>
                                        <input type="hidden" name="data[Request][hid_time_span]"  value="3" id="hid_time_span">
                                        <div class="rightdiv">
                                            <div class="arrow arrow_up" id="increse_time" onclick="increase_time()"></div>
                                            <hr style="height:1px; padding:0; margin:0; float:left">
                                            <div class="arrow arrow_down" onclick="decrease_time()"></div>
                                        </div>
                                    </li>
                                </ul>
                                <ul>
                                	<li>
                                    	<div class="leftdiv" id="time_span_am_or_pm">pm</div>
                                         <input type="hidden" name="data[Request][hid_time_am_or_pm]"  value="pm" id="hid_time_am_or_pm">
                                        <div class="rightdiv">
                                        	<div class="arrow arrow_up" onclick="changeamorpm()"></div>
                                            <hr style="height:1px; padding:0; margin:0; float:left">
                                            <div class="arrow arrow_down" onclick="changeamorpm()"></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="what_time anybody">
                            <p>Anybody joining?</p>
                            	<ul>
                                	<li>
                                    	<div class="leftdiv"><span id="person_no">1</span> persons</div>
                                        <input type="hidden" name="data[Request][hid_person_no]" value="1" id="hid_person_no">
                                        <div class="rightdiv" style="margin-left:0px;float:left;">
                                            <div class="arrow arrow_up" onclick="increase_persons()" style="float:left;margin-left:2px;width:30px;"></div>
                                            <hr style="height:1px; padding:0; margin:0; float:left">
                                            <div class="arrow arrow_down" onclick="decrease_persons()"  style="float:left;margin-left:2px;width:30px;"></div>
                                        </div>
                                    </li>
                                </ul>
                        </div>
	    			
                    </div>
	    			
	    			<div class="clearfix"></div>
	    			
	    			
	    		</div>
	    			<div class="second_row">
                    	<p>Tell makers what you interested in learning and making.<br/>
                         You can upload pictures if you have specific projects in mind.<br/>
                         Feel free to ask any logistic questions. Tell makers who you are. Warm up a little bit.</p>
						 <span style="color:red" id="cmnt_err"></span>
                        <div class="fields">
                            <textarea class="popup_textarea" name="data[Request][comment]" id="comment"></textarea>
                        </div>
                    </div>
                  <div class="third_row">
                   	<p>Add some photo’s to explain the skill</p>
                   	  <div class="fields">
                    	  <ul class="up_image add_image">
                    	    <div class="fields">
                    	     
			<div class="fields" style="position:relative">
			    <div id="preview_overlay" style="position:absolute;background: url(<?php echo($this->webroot);?>img/prevback.png) repeat;width:100%;height:100%;z-index:999999;display:none;">
				       <div style=" color: #fff;display: block;font-size: 22px;font-weight: bold;margin: 2% auto 0;text-align: center;">
					    Please wait while uploading...
					   </div>
					   <img src="<?php echo($this->webroot);?>img/green-ajax-loader.gif" style="display:block;margin:0 auto;"/>
				  </div>
				<ul class="up_image">
				
					<div id="Preview">
					</div>
				 
					<li><img src="<?php echo $this->webroot; ?>img/big_plus.png" alt="Add Pics" onclick="performClick3()" style="cursor:pointer"/></li>
				</ul>
				  <input type="file" id="theFile3" name="photos[]" style="display:none;" multiple="true"/>
				
				  <input type="hidden" name="data[Request][picnum]" value="0" id="picnum"/>
				  <input type="hidden" name="data[Request][totalpics]" value="0" id="totalpics"/>
				  <input type="hidden" name="data[List][picnumssn]" value="0" id="picnumssn"/>
				
			</div>
                  	      </div>
                    	  </ul>
                   	  </div>
					  <div style="color:red;width:100%;text-align:center" id="ordr_err_"></div>
					  <input class="btn border_btn offer_my_skill get_in_contact" type="submit" value="Get in touch and learn the skill" onclick="return booking_validate();">
                    </div>
	    	</div>
    	</div>
		</div>
	 </div>
	</form>
 </div>
<div class="contact_holder" id="contact_holder"></div>

<?php
if(isset($skill['Skill']['banner']) && $skill['Skill']['banner']!=''){
$uploadFolder = "skill_images";
$uploadPath = WWW_ROOT . $uploadFolder . '/' . $skill['Skill']['banner'];
	if (file_exists($uploadPath))
	{
		$bgbanner = $this->webroot.'skill_images/'.$skill['Skill']['banner'];
?>
  <div class="profile_cover_photo" style="background:url(<?php echo $bgbanner;?>) no-repeat; width:100%; background-size: none;position:relative">
<?php
	}
	else
	{
?>
  <div class="profile_cover_photo" style="position:relative">
<?php
	}
}else{
?>
  <div class="profile_cover_photo" style="position:relative">
<?php } 
if($usrid == $skill['Skill']['user_id']){ ?>
 <div class="coverphoto"></div>
<?php }else{} ?>
 <div class="profile_overlay">
	<div class="container_960">
		<div class="personal_profile_left">
			<?php
			 if(isset($skill['User']['profile_image']) && $skill['User']['profile_image']!='')
			 {
	            if (preg_match('/https:/',$skill['User']['profile_image']))
			    {
			?>
			  <img src="<?php echo $skill['User']['profile_image'];?>" alt="<?php echo $skill['User']['first_name'];?>" />
		    <?php }else{ ?>
			  <img src="<?php echo $this->webroot; ?>user_images/thumb/<?php echo $skill['User']['profile_image'];?>" alt="<?php echo $skill['User']['first_name'];?>" />
			<?php }}else{ ?>
			   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" alt="<?php echo $skill['User']['first_name'];?>" />
			<?php } ?>
			<aside>
				<b><?php echo $skill['User']['first_name'].' '.$skill['User']['last_name'];?></b>
				<p style="font-size:15px;margin-bottom:0px">
				   <?php 
					if(isset($skill['User']['basic_interests']) && $skill['User']['basic_interests']!='')
					{
					   $xtr=explode(',',$skill['User']['basic_interests']);
					}
					else
					{ 
						$xtr=array();
					}
					if(isset($xtr) && !empty($xtr))
					{
					  echo $xtr[0];
					}
					else{}
				  ?>
				</p>
				<p style="font-size:15px;margin-bottom:0px"><?php echo $skill['Skill']['skill_city'].', '.$skill['Skill']['skill_state'];?></p>
			</aside>
		</div>
		<div class="share_link">
		     <span id="wishlisticontop">
				 <?php
				 if(isset($usrid) && $usrid!=''){
				  if($usrid != $skill['Skill']['user_id'])
				  {
					  if(!empty($wishlist_skill)){  
					 ?>
						<a href="javascript:void(0);" onclick="make_favtop(<?php echo $skill['Skill']['id'];?>)"><img src="<?php echo $this->webroot;?>img/share1_black.png" title="Remove from wishlist"></a>
					 <?php }else{ ?>
					   <a href="javascript:void(0);" onclick="make_favtop(<?php echo $skill['Skill']['id'];?>)"><img src="<?php echo $this->webroot;?>img/share1.png" title="Add to wishlist"></a>
				<?php }}else{ ?>
				       <a href="javascript:void(0);"><img src="<?php echo $this->webroot;?>img/share1.png"></a>
				<?php }}else{ ?>
				       <a href="javascript:void(0);"><img src="<?php echo $this->webroot;?>img/share1.png"></a>
				<?php } ?>
			  </span>
			
			 <div class="share_link_icons">

			  <a href="javascript:void(0);" class="share_fb" onclick="facebook_share()"></a>

			  <a href="javascript:twShare('<?php echo $SITE_URL;?>skills/details/<?php echo base64_encode($skill['Skill']['id']);?>', '<?php echo $sitesetting['SiteSetting']['twitter_share_text'];?>', '', '<?php echo $SITE_URL;?>img/home_logo.png', 520, 350)" class="share_tweet"></a>

			  <a href="javascript:lnShare('<?php echo $SITE_URL;?>skills/details/<?php echo base64_encode($skill['Skill']['id']);?>', 'Aktively', '<?php echo $sitesetting['SiteSetting']['linkedin_share_text'];?>', '<?php echo $SITE_URL;?>skill_images/<?php echo $skill['Skill']['banner']?>', 520, 350)" class="share_in"></a>

			  <a href="https://plus.google.com/share?url=<?php echo $SITE_URL;?>skills/details/<?php echo base64_encode($skill['Skill']['id']);?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="share_gplus"></a>

			 </div>
			 <a href="javascript:void(0);" class="share_multi"><img src="<?php echo $this->webroot;?>img/share2.png" alt="Share" /></a>
		</div>
	</div>
  </div>
</div>
<div class="container_983" style="height:auto">
	<div class="fashion_photography fashion_photography_first pull-left">
		<div class="inner_fashion_photography">
			<b><?php echo ((isset($skill['Skill']['about_specifically']) && $skill['Skill']['about_specifically']!='')?$skill['Skill']['about_specifically']:$skill['Category']['name']);?></b>
			<p><?php echo $skill['Category']['name'];?></p>
			<?php if(!empty($subskill_exp)){ ?>
				<ul class=fashion_list>
				 <?php foreach($subskill_exp as $subskill){ ?>
					<li><?php echo $subskill;?></li>
				 <?php } ?>
				</ul>
			<?php } ?>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="card_right_div">
	<div class="card_right_div_inner">
	<div class="availability_maker pull-right">
		<h3>Availability maker</h3>
		<div class="timetable_div">
			<ul class="timing">
				<li></li>
				<li>9<span>am</span></li>
				<li>12<span>pm</span></li>
				<li>3<span>pm</span></li>
				<li>6<span>pm</span></li>
				<li>9<span>pm</span></li>
				<li>12<span>am</span></li>
			</ul>
			<?php
			 if($availability['Availability']['any_time_email']==1){
		    ?>
			   <div class="date_bar">
				<div class="left_day">Mo</div>
				<div class="time_100">
					
				</div>
			   </div>
			   <div class="date_bar">
				<div class="left_day">Tu</div>
				<div class="time_100">
					
				</div>
			   </div>
			   <div class="date_bar">
				<div class="left_day">We</div>
				<div class="time_100" style="text-align:center;color:#000">
					<strong>I have a flexible schedule.</strong>
				</div>
			   </div>
			   <div class="date_bar">
				<div class="left_day">Th</div>
				<div class="time_100" style="text-align:center;color:#000">
					<strong>Contact me now!</strong>
				</div>
			   </div>
			   <div class="date_bar">
				<div class="left_day">Fr</div>
				<div class="time_100">
					
				</div>
			   </div>
			   <div class="date_bar">
				<div class="left_day">Sa</div>
				<div class="time_100">
				</div>	
			   </div>
			   <div class="date_bar">
				<div class="left_day">Su</div>
				<div class="time_100">
					
				</div>
			   </div>
			<?php }
			 elseif($availability['Availability']['any_time_email']==0){
			  $total_min=(15*60);
			  if($availability['Availability']['monday_from']!='' && $availability['Availability']['monday_to']!='')
			  {
                $monday_form_exp=explode(':',$availability['Availability']['monday_from']);
				$monday_to_exp=explode(':',$availability['Availability']['monday_to']);
				if(isset($availability['Availability']['monday_from_format']) && $availability['Availability']['monday_from_format']==1)
				{
					if($monday_form_exp[0]==12)
					{
						$time_diff=(12-9);
					}
					else
					{
                        $time_diff=(($monday_form_exp[0]+12)-9);
					}
				}
				else
				{
                   $time_diff=($monday_form_exp[0]-9);
				}
				if(isset($availability['Availability']['monday_to_format']) && $availability['Availability']['monday_to_format']==1)
				{
					
					if($monday_to_exp[0]==12)
					{
						$time_span=($monday_to_exp[0]-$monday_form_exp[0]);
					}
					else
					{
						if(isset($availability['Availability']['monday_from_format']) && $availability['Availability']['monday_from_format']==1 && $monday_form_exp[0]!=12)
						{
                          $time_span=(($monday_to_exp[0]+12)-($monday_form_exp[0]+12));
						}
						else
						{
						 $time_span=(($monday_to_exp[0]+12)-($monday_form_exp[0]));
						}
					}
				}
				else
				{
                   $time_span=($monday_to_exp[0]-$monday_form_exp[0]);
				}
				$time_diff_perc=(($time_diff*60)/$total_min)*100;
				$time_span_perc=(($time_span*60)/$total_min)*100;
			?>
			<div class="date_bar">
				<div class="left_day">Mo</div>
				<div class="time_100">
					<div class="time_bar" style="margin-left:<?php echo $time_diff_perc;?>%;width:<?php echo $time_span_perc;?>%"></div>
				</div>
			</div>
			<?php }else{ ?>
			 <div class="date_bar">
				<div class="left_day">Mo</div>
				<div class="time_100">
					
				</div>
			 </div>
			<?php }if($availability['Availability']['tuesday_from']!='' && $availability['Availability']['tuesday_to']!='')
			  {
                $tuesday_form_exp=explode(':',$availability['Availability']['tuesday_from']);
				$tuesday_to_exp=explode(':',$availability['Availability']['tuesday_to']);
				if(isset($availability['Availability']['tuesday_from_format']) && $availability['Availability']['tuesday_from_format']==1)
				{
					if($tuesday_form_exp[0]==12)
					{
						$time_diff=(12-9);
					}
					else
					{
                        $time_diff=(($tuesday_form_exp[0]+12)-9);
					}
				}
				else
				{
                   $time_diff=($tuesday_form_exp[0]-9);
				}
				if(isset($availability['Availability']['tuesday_to_format']) && $availability['Availability']['tuesday_to_format']==1)
				{
					if($tuesday_to_exp[0]==12)
					{
						$time_span=($tuesday_to_exp[0]-$tuesday_form_exp[0]);
					}
					else
					{
                        if(isset($availability['Availability']['tuesday_from_format']) && $availability['Availability']['tuesday_from_format']==1 && $tuesday_form_exp[0]!=12)
						{
                          $time_span=(($tuesday_to_exp[0]+12)-($tuesday_form_exp[0]+12));
						}
						else
						{
						 $time_span=(($tuesday_to_exp[0]+12)-($tuesday_form_exp[0]));
						}
					}
				}
				else
				{
                   $time_span=($tuesday_to_exp[0]-$tuesday_form_exp[0]);
				}
				$time_diff_perc=(($time_diff*60)/$total_min)*100;
				$time_span_perc=(($time_span*60)/$total_min)*100;
			?>
			<div class="date_bar">
				<div class="left_day">Tu</div>
				<div class="time_100">
					<div class="time_bar" style="margin-left:<?php echo $time_diff_perc;?>%;width:<?php echo $time_span_perc;?>%"></div>
				</div>
			</div>
			<?php }else{ ?>
			 <div class="date_bar">
				<div class="left_day">Tu</div>
				<div class="time_100">
					
				</div>
			 </div>
			<?php } if($availability['Availability']['wednesday_from']!='' && $availability['Availability']['wednesday_to']!='')
			  {
                $wednesday_form_exp=explode(':',$availability['Availability']['wednesday_from']);
				$wednesday_to_exp=explode(':',$availability['Availability']['wednesday_to']);
				if(isset($availability['Availability']['wednesday_from_format']) && $availability['Availability']['wednesday_from_format']==1)
				{
					if($wednesday_form_exp[0]==12)
					{
						$time_diff=(12-9);
					}
					else
					{
                        $time_diff=(($wednesday_form_exp[0]+12)-9);
					}
				}
				else
				{
                   $time_diff=($wednesday_form_exp[0]-9);
				}
				if(isset($availability['Availability']['wednesday_to_format']) && $availability['Availability']['wednesday_to_format']==1)
				{
					if($wednesday_to_exp[0]==12)
					{
						$time_span=($wednesday_to_exp[0]-$wednesday_form_exp[0]);
					}
					else
					{
                        if(isset($availability['Availability']['wednesday_from_format']) && $availability['Availability']['wednesday_from_format']==1 && $wednesday_form_exp[0]!=12)
						{
                          $time_span=(($wednesday_to_exp[0]+12)-($wednesday_form_exp[0]+12));
						 
						}
						else
						{
						 $time_span=(($wednesday_to_exp[0]+12)-($wednesday_form_exp[0]));
						}
					}
				}
				else
				{
                   $time_span=($wednesday_to_exp[0]-$wednesday_form_exp[0]);
				}
				$time_diff_perc=(($time_diff*60)/$total_min)*100;
				$time_span_perc=(($time_span*60)/$total_min)*100;
			?>
			<div class="date_bar">
				<div class="left_day">We</div>
				<div class="time_100">
					<div class="time_bar" style="margin-left:<?php echo $time_diff_perc;?>%;width:<?php echo $time_span_perc;?>%"></div>
				</div>
			</div>
			<?php }else{ ?>
			 <div class="date_bar">
				<div class="left_day">We</div>
				<div class="time_100">
					
				</div>
			 </div>
			<?php } if($availability['Availability']['thursday_from']!='' && $availability['Availability']['thursday_to']!='')
			  {
                $thursday_form_exp=explode(':',$availability['Availability']['thursday_from']);
				$thursday_to_exp=explode(':',$availability['Availability']['thursday_to']);
				if(isset($availability['Availability']['thursday_from_format']) && $availability['Availability']['thursday_from_format']==1)
				{
					if($thursday_form_exp[0]==12)
					{
						$time_diff=(12-9);
					}
					else
					{
                        $time_diff=(($thursday_form_exp[0]+12)-9);
					}
				}
				else
				{
                   $time_diff=($thursday_form_exp[0]-9);
				}
				if(isset($availability['Availability']['thursday_to_format']) && $availability['Availability']['thursday_to_format']==1)
				{
					if($thursday_to_exp[0]==12)
					{
						$time_span=($thursday_to_exp[0]-$thursday_form_exp[0]);
					}
					else
					{
                        if(isset($availability['Availability']['thursday_from_format']) && $availability['Availability']['thursday_from_format']==1 && $thursday_form_exp[0]!=12)
						{
                          $time_span=(($thursday_to_exp[0]+12)-($thursday_form_exp[0]+12));
						}
						else
						{
						 $time_span=(($thursday_to_exp[0]+12)-($thursday_form_exp[0]));
						}
					}
				}
				else
				{
                   $time_span=($thursday_to_exp[0]-$thursday_form_exp[0]);
				}
				$time_diff_perc=(($time_diff*60)/$total_min)*100;
				$time_span_perc=(($time_span*60)/$total_min)*100;
			?>
			<div class="date_bar">
				<div class="left_day">Th</div>
				<div class="time_100">
					<div class="time_bar" style="margin-left:<?php echo $time_diff_perc;?>%;width:<?php echo $time_span_perc;?>%"></div>
				</div>
			</div>
			<?php }else{ ?>
			 <div class="date_bar">
				<div class="left_day">Th</div>
				<div class="time_100">
					
				</div>
			 </div>
			<?php } if($availability['Availability']['friday_from']!='' && $availability['Availability']['friday_to']!='')
			  {
                $friday_form_exp=explode(':',$availability['Availability']['friday_from']);
				$friday_to_exp=explode(':',$availability['Availability']['friday_to']);
				if(isset($availability['Availability']['friday_from_format']) && $availability['Availability']['friday_from_format']==1)
				{
					if($friday_form_exp[0]==12)
					{
						$time_diff=(12-9);
					}
					else
					{
                        $time_diff=(($friday_form_exp[0]+12)-9);
					}
				}
				else
				{
                   $time_diff=($friday_form_exp[0]-9);
				}
				if(isset($availability['Availability']['friday_to_format']) && $availability['Availability']['friday_to_format']==1)
				{
					if($friday_to_exp[0]==12)
					{
						$time_span=($friday_to_exp[0]-$friday_form_exp[0]);
					}
					else
					{
                        if(isset($availability['Availability']['friday_from_format']) && $availability['Availability']['friday_from_format']==1 && $friday_form_exp[0]!=12)
						{
                          $time_span=(($friday_to_exp[0]+12)-($friday_form_exp[0]+12));
						}
						else
						{
						 $time_span=(($friday_to_exp[0]+12)-($friday_form_exp[0]));
						}
						
					}
				}
				else
				{
                   $time_span=($friday_to_exp[0]-$friday_form_exp[0]);
				}
				$time_diff_perc=(($time_diff*60)/$total_min)*100;
				$time_span_perc=(($time_span*60)/$total_min)*100;
			?>
			<div class="date_bar">
				<div class="left_day">Fr</div>
				<div class="time_100">
					<div class="time_bar" style="margin-left:<?php echo $time_diff_perc;?>%;width:<?php echo $time_span_perc;?>%"></div>
				</div>
			</div>
			<?php }else{ ?>
			 <div class="date_bar">
				<div class="left_day">Fr</div>
				<div class="time_100">
					
				</div>
			 </div>
			<?php } if($availability['Availability']['saturday_from']!='' && $availability['Availability']['saturday_to']!='')
			  {
                $saturday_form_exp=explode(':',$availability['Availability']['saturday_from']);
				$saturday_to_exp=explode(':',$availability['Availability']['saturday_to']);
				if(isset($availability['Availability']['saturday_from_format']) && $availability['Availability']['saturday_from_format']==1)
				{
					if($saturday_form_exp[0]==12)
					{
						$time_diff=(12-9);
					}
					else
					{
                        $time_diff=(($saturday_form_exp[0]+12)-9);
					}
				}
				else
				{
                   $time_diff=($saturday_form_exp[0]-9);
				}
				if(isset($availability['Availability']['saturday_to_format']) && $availability['Availability']['saturday_to_format']==1)
				{
					if($saturday_to_exp[0]==12)
					{
						$time_span=($saturday_to_exp[0]-$saturday_form_exp[0]);
					}
					else
					{
                        if(isset($availability['Availability']['saturday_from_format']) && $availability['Availability']['saturday_from_format']==1 && $saturday_form_exp[0]!=12)
						{
                          $time_span=(($saturday_to_exp[0]+12)-($saturday_form_exp[0]+12));
						}
						else
						{
						 $time_span=(($saturday_to_exp[0]+12)-($saturday_form_exp[0]));
						}

					}
				}
				else
				{
                   $time_span=($saturday_to_exp[0]-$saturday_form_exp[0]);
				}
				$time_diff_perc=(($time_diff*60)/$total_min)*100;
				$time_span_perc=(($time_span*60)/$total_min)*100;
			?>
			<div class="date_bar">
				<div class="left_day">Sa</div>
				<div class="time_100">
					<div class="time_bar" style="margin-left:<?php echo $time_diff_perc;?>%;width:<?php echo $time_span_perc;?>%"></div>
				</div>
			</div>
			<?php }else{ ?>
			 <div class="date_bar">
				<div class="left_day">Sa</div>
				<div class="time_100">
					
				</div>
			 </div>
			<?php } if($availability['Availability']['sunday_from']!='' && $availability['Availability']['sunday_to']!='')
			  {
                $sunday_form_exp=explode(':',$availability['Availability']['sunday_from']);
				$sunday_to_exp=explode(':',$availability['Availability']['sunday_to']);
				if(isset($availability['Availability']['sunday_from_format']) && $availability['Availability']['sunday_from_format']==1)
				{
					if($sunday_form_exp[0]==12)
					{
						$time_diff=(12-9);
					}
					else
					{
                        $time_diff=(($sunday_form_exp[0]+12)-9);
					}
				}
				else
				{
                   $time_diff=($sunday_form_exp[0]-9);
				}
				if(isset($availability['Availability']['sunday_to_format']) && $availability['Availability']['sunday_to_format']==1)
				{
					if($sunday_to_exp[0]==12)
					{
						$time_span=($sunday_to_exp[0]-$sunday_form_exp[0]);
					}
					else
					{
                        if(isset($availability['Availability']['sunday_from_format']) && $availability['Availability']['sunday_from_format']==1 && $sunday_form_exp[0]!=12)
						{
                          $time_span=(($sunday_to_exp[0]+12)-($sunday_form_exp[0]+12));
						}
						else
						{
						 $time_span=(($sunday_to_exp[0]+12)-($sunday_form_exp[0]));
						}
					}
				}
				else
				{
                   $time_span=($sunday_to_exp[0]-$sunday_form_exp[0]);
				}
				$time_diff_perc=(($time_diff*60)/$total_min)*100;
				$time_span_perc=(($time_span*60)/$total_min)*100;
			?>
			<div class="date_bar">
				<div class="left_day">Su</div>
				<div class="time_100">
					<div class="time_bar" style="margin-left:<?php echo $time_diff_perc;?>%;width:<?php echo $time_span_perc;?>%"></div>
				</div>
			</div>
			<?php }else{ ?>
			 <div class="date_bar">
				<div class="left_day">Su</div>
				<div class="time_100">
					
				</div>
			 </div>
			<?php }} ?>
		</div>
	 </div>
	 <?php if(isset($availability['Availability']['respond_time']) && $availability['Availability']['respond_time']!=''){?>
	 <div class="hour_rental pull-right">
		  <h3 style="color: #303030;font-family: 'Lato', sans-serif !important;font-size: 14px;margin: 20px 0 3px 25px;">Average Response Time</h3>
		  <p style="margin-left: 24px;font-size: 15px;"><?php echo $availability['Availability']['respond_time']?></p>
	 </div>
	 <?php } ?>
	 <div class="hour_rental pull-right">
		  <?php if(isset($skill['Skill']['max_price'])  && $skill['Skill']['max_price']!=''){?>
			<p><b>$<?php echo intval($skill['Skill']['max_price']);?></b><span>/hour</span></p>
		  <?php } ?>

		  <?php if(isset($skill['Skill']['price_details']) && $skill['Skill']['price_details']!=''){?>
			<a href="javascript:void(0)" onclick="show_price_details()">learn more</a>
            <div class="clearfix"></div>
			<p style="margin-left: 13px;font-size: 14px;margin-bottom: 20px;text-align: justify;
padding-right: 16px;display:none" id="pricedetails_p"><?php echo nl2br($skill['Skill']['price_details']);?></p>
          <?php } ?>

			<?php if(isset($usrid) && $usrid!=''){if($usrid != $skill['Skill']['user_id']){ ?>
			  <input class="btn border_btn offer_my_skill get_in_contact" type="button" value="Get in contact" onclick="open_contact_form()">
			<?php }else{ ?>
			  <input class="btn border_btn offer_my_skill get_in_contact" type="button" value="Get in contact" onclick="javascript:alert('Please login to contact');">
			<?php }}else{ ?>
			  <input class="btn border_btn offer_my_skill get_in_contact" type="button" value="Get in contact" onclick="javascript:alert('Please login to contact');">
			<?php } ?>
	 </div>
	</div>
	</div>
	<div class="clearfix"></div>
	<?php
	 if(!empty($skillimages_exp))
	 {
	?>
	<div class="image_galin_profile">
		<iframe src="<?php echo $this->webroot;?>skills/sliderframe2/<?php echo $skill['Skill']['id'];?>" style="margin:0;border:0;width:100%;height:440px;overflow:hidden;" scrolling="no"></iframe> 
	</div>
	<!-- <div class="image_galin_profile">
	    <div id="slider" class="flexslider">
		  <ul class="slides">
		   <?php foreach($skillimages_exp as $skillimage){ ?>
			<li>
			  <img src="<?php echo $this->webroot;?>skill_images/<?php echo $skillimage;?>" />
			</li>
			<?php   
			}
			if(isset($skill['Skill']['skill_video_url'])&& $skill['Skill']['skill_video_url']!='')
			{ 
				$url = $skill['Skill']['skill_video_url'];
				if (strpos($url,'vimeo.com') !== false) 
				{
					$video_id = explode("vimeo.com/", $url); 
				?>
					<li>
					<iframe src="http://player.vimeo.com/video/<?php echo $video_id[1];?>" width="634" height="422" frameborder="0" allowfullscreen></iframe>
					</li>
				<?php
				}
				else
				{
					$video_id = explode("?v=", $skill['Skill']['skill_video_url']); 
					if(empty($video_id[1]))
					{
						$video_id = explode("/v/", $skill['Skill']['skill_video_url']);
					}
					$video_id = explode("&", $video_id[1]); // Deleting any other params
					$video_id = $video_id[0];				   
			  ?>
					<li>
					<iframe src="http://www.youtube.com/embed/<?php echo $video_id;?>" width="634" height="422" frameborder="0" allowfullscreen></iframe>
					</li>
			<?php 
				}
			}
			?>
		  </ul>
		</div>
		<div id="carousel" class="flexslider" style="position:absolute;">
		  <ul class="slides">
		    <?php foreach($skillimages_exp as $skillimage){ ?>
			<li style="height:80px !important;margin-right:10px">
			  <img src="<?php echo $this->webroot;?>skill_images/<?php echo $skillimage;?>" style="height:80px;margin-right:10px"/>
			</li>
			<?php   }
			  if(isset($skill['Skill']['skill_video_url'])&&$skill['Skill']['skill_video_url']!='')
			  { 
				  $url = $skill['Skill']['skill_video_url'];
				  if (strpos($url,'vimeo.com') !== false) 
				  {
   					   $video_id = explode("vimeo.com/", $url); 
				?>
			   <li style="height:80px !important;margin-right:10px">
				 <img src="<?php echo $this->requestAction('skills/getVimeoThumb/'.$video_id[1])?>" style="height:80px;margin-right:10px"/>
			   </li>
				<?php }
				   else
				   {
						$video_id = explode("?v=", $skill['Skill']['skill_video_url']); 
						if(empty($video_id[1]))
						{
						  $video_id = explode("/v/", $skill['Skill']['skill_video_url']);
						}
						$video_id = explode("&", $video_id[1]); // Deleting any other params
						$video_id = $video_id[0];
				   
			  ?>
			  <li style="height:80px !important;margin-right:10px">
			   <img src="http://img.youtube.com/vi/<?php echo $video_id;?>/2.jpg" style="height:80px;margin-right:10px"/>
			  </li>
			<?php }} ?>
		  </ul>
		</div>
		
	</div> -->
	<?php } ?>
	<div class="clearfix"></div>
	<div class="spacality">
		<div class="inner_fashion_photography">
                      <?php
                    if(!empty($imagedescription))
                    {
                        $imagedescription=explode(',',$imagedescription['SkillImage']['description']);
                        $i=1;
                        foreach ($imagedescription as $imagedescription1)
                        {
                            ?>
                    <p id="descriptionoftheimage<?=$i?>" class="imagedetailsshowtheimage" <?php if($i==1){ ?>style="display:block"<?php }else{ ?>style="display:none;" <?php } ?>><?php echo $imagedescription1;?></p>
                    <?php
                    $i++;
                        }
                        }
                    ?>
			<h2>My speciality</h2>
			<p><?php if(isset($skill['Skill']['skill_details']) && $skill['Skill']['skill_details']!=''){echo nl2br($skill['Skill']['skill_details']);}?></p>
		
			<?php if(isset($skill['User']['bio']) && $skill['User']['bio']!=''){?>
			  <h2>About me</h2>
			  <p><?php echo nl2br($skill['User']['bio']);?></p>
			 <?php } ?>

            <div class="clearfix"></div>
			 <ul class="profile_social">
			   <?php if(isset($skill['User']['personal_website_url']) && $skill['User']['personal_website_url']!=''){?>
				 <li><img src="<?php echo $this->webroot;?>img/profile_link.png" alt="Website Link Image"/><a href="<?php echo $skill['User']['personal_website_url'];?>" target="_blank"><p><?php echo $skill['User']['personal_website_url'];?></p></a></li>
               <?php } ?>
			   <?php if(isset($skill['User']['facebook_url']) && $skill['User']['facebook_url']!=''){?>
				<li><a href="<?php echo $skill['User']['facebook_url'];?>" target="_blank"><img src="<?php echo $this->webroot;?>img/profile_social_1.png" alt="Facebook"/></a></li>
			   <?php } ?>
               <?php if(isset($skill['User']['linkdin_url']) && $skill['User']['linkdin_url']!=''){?>
				<li><a href="<?php echo $skill['User']['linkdin_url'];?>" target="_blank"><img src="<?php echo $this->webroot;?>img/profile_social2.png" alt="Linkedin"/></a></li>
			   <?php } ?>
			   <?php if(isset($skill['User']['twitter_url']) && $skill['User']['twitter_url']!=''){?>
				<li><a href="<?php echo $skill['User']['twitter_url'];?>" target="_blank"><img src="<?php echo $this->webroot;?>img/profile_social3.png" alt="Twitter" /></a></li>
               <?php } ?>
			   <?php if(isset($skill['User']['etsy_store_url']) && $skill['User']['etsy_store_url']!=''){?>
				<li><a href="<?php echo $skill['User']['etsy_store_url'];?>" target="_blank"><img src="<?php echo $this->webroot;?>img/profile_social4.png" alt="Etsy" /></a></li>
			   <?php } ?>
			</ul>
		</div>
	</div>
	
	<!-- <div class="container_983" style="height:auto">
		<div class="fashion_photography pull-left">
			<div class="inner_fashion_photography">
			</div>
		</div>
	</div> -->
</div>
<div class="clearfix"></div>
<div class="profile_list_img" style="height: 400px !important;">
	<iframe src="<?php echo $this->webroot;?>skills/sliderframe/<?php echo $skill['Skill']['id'];?>" style="margin:0;border:0;width:100%;height:400px;overflow:hidden;" scrolling="no"></iframe> 
</div>
<div class="clearfix"></div>
<div class="container_983" style="height:auto";>
<div class="spacality">
	<div class="inner_fashion_photography">
		<h2>About the studio</h2>
		<p>
			<?php if(isset($skill['Skill']['studio_details']) && $skill['Skill']['studio_details']!=''){echo nl2br($skill['Skill']['studio_details']);}?>
		</p>
		<h2>Available Tools</h2>
		 <?php if(!empty($avaltools_exp)){ ?>
				<ul class=fashion_list>
				 <?php foreach($avaltools_exp as $avaltool){ ?>
					<li><?php echo $avaltool;?></li>
				 <?php } ?>
				</ul>
		<?php } ?>
		<?php if(isset($skill['Skill']['party_size']) && $skill['Skill']['party_size']!=''){ ?>
			<h2 style="margin-top:45px;">Party Size</h2>
			<p>
				<?php echo $skill['Skill']['party_size'];?> people maximum
			</p>
		<?php } ?>
	</div>
</div>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
<div class="profile_map" id="profile_map"></div>
<?php if($is_review_exists==1){ ?>
<div class="reviews_profile">
	<div class="container_983" style="height:auto">
		<div class="spacality">
			<div class="inner_fashion_photography reviw_sec">	
			  <?php 
			    if(!empty($allrequests)){
			  ?>
				<h2>Reviews</h2>
				<ul class="review_list_ul">
				 <?php
				    foreach($allrequests as $allrequest){
					 $review_details=$this->requestAction('users/getreviews_details/'.$allrequest['Request']['id'].'/'.$allrequest['Request']['user_id']);
					 if(!empty($review_details)){
						 foreach($review_details as $review_detail)
						 {
							 $userdetailsr=$this->requestAction('users/getuserdetails/'.$review_detail['Review']['reviewer']);
				 ?>
					<li>
						<?php
						 if(isset($userdetailsr['User']['profile_image']) && $userdetailsr['User']['profile_image']!='')
						 {
						?>
						   <img src="<?php echo $this->webroot; ?>user_images/thumb<?php echo $userdetailsr['User']['profile_image'];?>"/>
						<?php }else{ ?>
						   <img src="<?php echo $this->webroot; ?>user_images/user_image.png"/>
						<?php } ?>
						<h2><?php echo $userdetailsr['User']['first_name'].' '.$userdetailsr['User']['last_name'];?></h2>
						<span><?php echo date('d M, Y',strtotime($review_detail['Review']['date']));?></span>
						<div class="clearfix"></div>
						<p>
							"<?php echo nl2br($review_detail['Review']['comment']);?>"
						</p>
					</li>
				  <?php }}} ?>
				</ul>
				<?php } ?>
				<div class="bottom_touch"></div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<?php } else { ?>
<div class="bottom_touch"></div>
<?php } ?>
<?php if(!empty($recommendskill)){
?>
<div class="profile_product">
	<div class="container_983" style="height:auto;">
		<div class="profile_product_details">
		 <?php
		   if(!empty($recommendskill)){
		   $k=1;
		   foreach($recommendskill as $recommendskl){ 
		   $skillimages_exp_single=explode(',',$recommendskl['SkillImage']['0']['image']);
		 ?>
			<div class="inner_profile_details" onmouseover="open_overlay(<?php echo $k;?>)" onmouseout="close_overlay(<?php echo $k;?>)" onclick="myClick('<?php echo base64_encode($recommendskl['Skill']['id']);?>',event)">
				 <?php 
					if(isset($skillimages_exp_single[0]) && $skillimages_exp_single[0]!=''){
					$uploadFolder = "skill_images";
					$uploadPath = WWW_ROOT . $uploadFolder . '/' . $skillimages_exp_single[0];
					if (file_exists($uploadPath))
					{
				  ?>
					<img alt="<?php echo $recommendskl['Skill']['skill_name'];?>" src="<?php echo $this->webroot;?>skill_images/<?php echo $skillimages_exp_single[0];?>"/>
				  <?php
					}}
					else{
				  ?>
					  <img src="<?php echo $this->webroot;?>img/profile_cover.jpg" alt="Banner"/>
				  <?php } ?>
        
				<!-- <aside>
				    <?php if(isset($recommendskl['Skill']['min_price']) && $recommendskl['Skill']['min_price']!='' && $recommendskl['Skill']['max_price']!=''){?>
						<p>$<?php echo intval($recommendskl['Skill']['min_price']);?> - $<?php echo intval($recommendskl['Skill']['max_price']);?><span>/hour</span></p>
					<?php } ?>
					<b><?php echo $recommendskl['User']['first_name'].' '.$recommendskl['User']['last_name'];?></b>
					<strong><a href="<?php echo $this->webroot;?>skills/details/<?php echo base64_encode($recommendskl['Skill']['id']);?>" style="color:#4743e2"><?php echo $recommendskl['Category']['name'];?></a></strong>
				</aside> -->
				<?php
				  $usrid = $this->Session->read('Auth.User.id');
				  if(isset($usrid) && $usrid!='')
				  {
				   if($usrid != $recommendskl['Skill']['user_id'])
				   {
					  if(in_array($recommendskl['Skill']['id'],$wishlist_ids)){  
					 ?>
						<div id="wishlisticon<?php echo $recommendskl['Skill']['id'];?>" class="wishlisticon" onclick="make_fav(<?php echo $recommendskl['Skill']['id'];?>,event)" style="top:0"><a href="javascript:void(0);"><img src="<?php echo $this->webroot;?>img/share1_black.png" title="Remove from wishlist" class="share_icon"></a></div>
					 <?php }else{ ?>
					   <div id="wishlisticon<?php echo $recommendskl['Skill']['id'];?>" onclick="make_fav(<?php echo $recommendskl['Skill']['id'];?>,event)" class="wishlisticon" style="top:0"><a href="javascript:void(0);"><img src="<?php echo $this->webroot;?>img/share1.png" title="Add to wishlist" class="share_icon"></a></div>
				<?php }}else{ ?>
					   <div id="wishlisticon<?php echo $recommendskl['Skill']['id'];?>" class="wishlisticon" style="top:0"><a href="javascript:void(0);"><img src="<?php echo $this->webroot;?>img/share1.png" class="share_icon"></a></div>
				<?php } }else{ ?>
					  <div id="wishlisticon<?php echo $recommendskl['Skill']['id'];?>" class="wishlisticon" style="top:0"><a href="javascript:void(0);"><img src="<?php echo $this->webroot;?>img/share1.png" class="share_icon"></a></div>
				<?php } ?>

				<div class="overlay" id="overlaydv<?php echo $k;?>" onmouseover="open_overlay(<?php echo $k;?>)" onmouseout="close_overlay(<?php echo $k;?>)" style="top:0">
					<h3><?php echo $recommendskl['Skill']['about_specifically'];?></h3>
					<p>by <?php echo $recommendskl['User']['first_name'].' '.$recommendskl['User']['last_name'];?><br>$<?php echo intval($recommendskl['Skill']['max_price']);?> /hour</p>
				</div>
			</div>
		 <?php $k++;}} ?>
		</div>
	</div>
</div>
<?php }else{ ?>
 <div style="float:left;width:100%;height:30px">
 </div>
<?php } ?>

<!-- <?php if(!empty($recommend_user)){?>
<div class="heldmate">
	<div class="container_983" style="height:auto;">
		<div class="helmate_left">
			<div class="heldmate_inner">
				<?php
				 if(isset($recommend_user['User']['profile_image']) && $recommend_user['User']['profile_image']!='')
				 {
				?>
				  <img src="<?php echo $this->webroot; ?>user_images/<?php echo $recommend_user['User']['profile_image'];?>" alt="<?php echo $recommend_user['User']['first_name'];?>" />
				<?php }else{ ?>
				   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" alt="<?php echo $recommend_user['User']['first_name'];?>" />
				<?php } ?>
				<aside>
					<b><a href="<?php echo $this->webroot;?>skills/user_profile/<?php echo base64_encode($recommend_user['User']['id']);?>" style="color:#000"><?php echo $recommend_user['User']['first_name'].' '.$recommend_user['User']['last_name'];?></a></b>
					<strong>
					  <?php 
						if(isset($recommend_user['User']['basic_interests']) && $recommend_user['User']['basic_interests']!='')
						{
						   $xtr=explode(',',$recommend_user['User']['basic_interests']);
						}
						else
						{ 
							$xtr=array();
						}
						if(isset($xtr) && !empty($xtr))
						{
						  echo $xtr[0];
						}
						else{}
					  ?>
					</strong>
				</aside>
				<div class="clearfix"></div>
				<p>
					<?php if(isset($recommend_user['User']['bio']) && $recommend_user['User']['bio']!=''){echo nl2br($recommend_user['User']['bio']);}?>
				</p>
			</div>
		</div>
		<?php
		 $bnnr_arr=array();
			 if(!empty($recommend_user['Skill']))
			 {
			   foreach($recommend_user['Skill'] as $vb)
			   {
				 $bnnr_arr[]=$vb['banner'];
			   }
			   shuffle($bnnr_arr);
			 }
		
			if(isset($bnnr_arr[0]) && $bnnr_arr[0]!=''){
			$uploadFolder = "skill_images";
			$uploadPath = WWW_ROOT . $uploadFolder . '/' . $bnnr_arr[0];
			if (file_exists($uploadPath))
			{
			?>
			   <img src="<?php echo $this->webroot;?>skill_images/<?php echo $bnnr_arr[0];?>" alt="Banner" class="heldmate_image"/>
			<?php
			  }
			  else
			  {
			?>
			   <img src="<?php echo $this->webroot;?>img/profile_cover.jpg" alt="Banner" class="heldmate_image"/>
			<?php
			  }
			 }else{
			?>
			   <img src="<?php echo $this->webroot;?>img/profile_cover.jpg" alt="Banner" class="heldmate_image"/>
		<?php } ?>
	</div>
</div>
<?php } ?> -->

<style>
.bx-wrapper{width:100% !important;max-width: 100% !important;}
.bx-viewport {height: 266px !important;}
.bx-viewport ul.studiophotos li{height: 266px !important;width: 317px !important;margin:0px !important}
.bx-pager{display:none !important}
.bx-wrapper .bx-next,.bx-wrapper .bx-prev{background:none !important;}
.bx-wrapper .bx-next{background-image:url(../../app/webroot/images/arrow_right.png) !important;background-repeat:no-repeat;width: 27px !important;height: 53px !important;}
.bx-wrapper .bx-prev{background-image:url(../../app/webroot/images/arrow_left.png) !important;background-repeat:no-repeat;width: 27px !important;height: 53px !important;}
#carousel .flex-viewport{bottom:60px; width: 524px !important; overflow: hidden; left: 60px !important;}
#carousel ul li{width:121px !important;}
#carousel ul.flex-direction-nav a{top: -32% !important;}
.flexslider { position: relative !important;}
#Preview li img{width:100%;height:100%}
</style>
<style>
#profile_map img { max-width: inherit; }
</style>
<style type="text/css">
  .coverphoto {
    width: 100%;
    height: 503px;
    margin: 0 auto;
	position:absolute;
	cursor:move;
  }
  .actions
  {
    top:278px !important;
  }
</style>

<?php echo $this->Html->scriptStart(array('inline'=>false));?>
 function open_overlay(k)
 {
  $('#overlaydv'+k).stop().fadeTo(200,1);;
 }
 function close_overlay(k)
 {
  $('#overlaydv'+k).stop().fadeTo(200,0);;
 }

  
  function show_price_details()
  {
   $('#pricedetails_p').slideToggle('slow');
  }

    $(function() {
    $(".coverphoto").CoverPhoto({
	  post: {
        url: '<?php echo $this->webroot;?>skills/img_crop_to_file/<?php echo $skill['Skill']['id'];?>'
      },
      editable: true,
    });
	$(".coverphoto").bind('coverPhotoUpdated', function(evt, dataUrl) {
     });

	 $("#uploadcvrphto").change(function(){
		  $('.profile_overlay').hide();
	 });
	 $('#cncl').click(function(){
		  $('.coverphoto-photo-container').hide();
          $('.profile_overlay').show();
	 });
  });

	var marker;
	var geocoder = new google.maps.Geocoder();
	initialize_profile();
	function initialize_profile(lat,lng) 
	{
		lat='<?php echo $skill['Skill']['skill_workshop_lat'];?>';
		lng='<?php echo $skill['Skill']['skill_workshop_lang'];?>';
		var myLatLng = new google.maps.LatLng(lat,lng);
		var mapOptions = {
		    scrollwheel: false,
			zoom: 16,
			center: myLatLng,
			mapTypeId: google.maps.MapTypeId.RoadMap
		};

		var map = new google.maps.Map(document.getElementById('profile_map'),mapOptions);
                var circle = new google.maps.Circle({
		  scrollwheel: false,
		  center: myLatLng,
		  radius: 150,     // 10 miles in metres
		  mapTypeId: google.maps.MapTypeId.RoadMap,
		  strokeColor: "#4743e2",
		  strokeOpacity: 0.8,
		  strokeWeight: 2,
		  fillColor: "#4743e2",
		  fillOpacity: 0.35,
		  map: map
		});
		var contentString = '';

	    var infowindow = new google.maps.InfoWindow({
			  content: contentString
		});

		/*marker = new google.maps.Marker({
			position: map.getCenter(),
			map: map,
			icon: image
		});*/
	}
     
    var day1='';var day2='';var day3='';var day4='';var day5='';var day6='';var day0='';
	day1="<?php if($availability['Availability']['monday_from']=='' && $availability['Availability']['monday_to']==''){echo 1;}else{echo 'av';}?>";
	day2="<?php if($availability['Availability']['tuesday_from']=='' && $availability['Availability']['tuesday_to']==''){echo 2;}else{echo 'av';}?>";
	day3="<?php if($availability['Availability']['wednesday_from']=='' && $availability['Availability']['wednesday_to']==''){echo 3;}else{echo 'av';}?>";
	day4="<?php if($availability['Availability']['thursday_from']=='' && $availability['Availability']['thursday_to']==''){echo 4;}else{echo 'av';}?>";
	day5="<?php if($availability['Availability']['friday_from']=='' && $availability['Availability']['friday_to']==''){echo 5;}else{echo 'av';}?>";
	day6="<?php if($availability['Availability']['saturday_from']=='' && $availability['Availability']['saturday_to']==''){echo 6;}else{echo 'av';}?>";
	day0="<?php if($availability['Availability']['sunday_from']=='' && $availability['Availability']['sunday_to']==''){echo 0;}else{echo 'av';}?>";
   
   <?php if($availability['Availability']['any_time_email']==0){ ?>
	var dateToday = new Date();
	 $( "#datepicker" ).datepicker({
		   inline: true,
		   minDate: dateToday,
		   dateFormat: 'yy-mm-dd',
		   beforeShowDay: function(date) {
			var day = date.getDay();
			return [(day != day0 && day != day1 && day != day2 && day != day3 && day != day4 && day != day5 && day != day6)];
		   },
		   onSelect: function(dateText, inst) { 
		   var dateAsString = dateText; //the first parameter of this function
		   var dateAsObject = $(this).datepicker( 'getDate' ); //the getDate method
		   $("#date_str").val(dateAsString);
		  }
	});
   <?php }else{ ?>
    var dateToday = new Date();
	 $( "#datepicker" ).datepicker({
		   inline: true,
		   minDate: dateToday,
		   dateFormat: 'yy-mm-dd',
		   onSelect: function(dateText, inst) { 
		   var dateAsString = dateText; //the first parameter of this function
		   var dateAsObject = $(this).datepicker( 'getDate' ); //the getDate method
		   $("#date_str").val(dateAsString);
		  }
	});
   <?php } ?>

	function make_favtop(skill_id)
	{
	 $.post( '<?php echo($this->webroot)?>skills/make_wishlist_top/'+skill_id, function( data ) {
	   $('#wishlisticontop').html('');
	   $('#wishlisticontop').html(data);
	 });
	}

	function twShare(url, title, descr, image, winWidth, winHeight) {
        var winTop = (screen.height / 2) - (winHeight / 2);
        var winLeft = (screen.width / 2) - (winWidth / 2);
        window.open('http://twitter.com/share?url=' + encodeURI(url) + '&text=' + encodeURI(title) + '', 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width='+winWidth+',height='+winHeight);
    }

	function lnShare(url, title, descr, image, winWidth, winHeight) {
		var articleUrl = encodeURIComponent(url);
		 var articleTitle = encodeURIComponent(title);
		 var articleSummary = encodeURIComponent(descr);
		 var articleSource = encodeURIComponent('Aktively');
		 var goto = 'http://www.linkedin.com/shareArticle?mini=true'+
			 '&url='+articleUrl+
			 '&title='+articleTitle+
			 '&summary='+articleSummary+
			 '&source='+articleSource;
		 window.open(goto, "LinkedIn", "width=800,height=400,scrollbars=no;resizable=no");       
    }

	function facebook_share()
	{
		FB.init({
		appId:'369392396541736',
		cookie:true,
		status:true,
		xfbml:true
		});
		FB.ui(
		{
		method: 'feed',
		name: 'Aktively',
		link: '<?php echo $SITE_URL;?>skills/details/<?php echo base64_encode($skill['Skill']['id']);?>',
		picture: '<?php echo $SITE_URL;?>skill_images/<?php echo $skill['Skill']['banner']?>',
		caption: 'aktively.com',
		description: '<?php echo $sitesetting['SiteSetting']['facebook_share_text'];?>'
		},
		function(response){
		  if (response && response.post_id) {
		  } else {
		  }
		})
	}

	function myClick(skill_id,e)
	{
	  window.location.href='<?php echo($this->webroot)?>skills/details/'+skill_id;
		if (!e) var e = window.event;
		e.cancelBubble = true;
		if (e.stopPropagation) e.stopPropagation();
	}
	function make_fav(skill_id,e)
	{
		 $.post( '<?php echo($this->webroot)?>users/make_wishlist/'+skill_id, function( data ) {
		   $('#wishlisticon'+skill_id).html('');
		   $('#wishlisticon'+skill_id).html(data);
		   $('#mapwishlisticon'+skill_id).html('');
		   $('#mapwishlisticon'+skill_id).html(data);
		 });
		  if (!e) var e = window.event;
		   e.cancelBubble = true;
		  if (e.stopPropagation) e.stopPropagation();
	}
<?php echo $this->Html->scriptEnd();?>
<style>

#datepicker{
		font: 80% "Trebuchet MS",sans-serif;
    padding: 10px;
		
	}
</style>
