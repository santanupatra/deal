<?php 
 $skillimages_exp=explode(',',$skill['SkillImage']['0']['image']);
 $subskill_exp=explode(',',$skill['Skill']['sub_category']);
 $avaltools_exp=explode(',',$skill['Skill']['skill_tools']);
 $skill_tool_pics_exp=explode(',',$skill['Skill']['skill_tool_pics']);
?>

<div class="profile_cover_photo" style="background:url(<?php echo $this->webroot;?>skill_images/<?php echo $skillimages_exp[0];?>) no-repeat">
 <div class="profile_overlay">
	<div class="container_960">
		<div class="personal_profile_left">
			<?php
			 if(isset($skill['User']['profile_image']) && $skill['User']['profile_image']!='')
			 {
			?>
			  <img src="<?php echo $this->webroot; ?>user_images/<?php echo $skill['User']['profile_image'];?>" alt="<?php echo $skill['User']['first_name'];?>" />
			<?php }else{ ?>
			   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" alt="<?php echo $skill['User']['first_name'];?>" />
			<?php } ?>
			<aside>
				<b><?php echo $skill['User']['first_name'].' '.$skill['User']['last_name'];?></b>
				<p><?php echo $skill['Skill']['skill_city'].', '.$skill['Skill']['skill_state'];?></p>
			</aside>
		</div>
		<div class="share_link">
			<a href="javascript:void(0);"><img src="<?php echo $this->webroot;?>img/share1.png" alt="Favourite" /></a>
			<a href="javascript:void(0);"><img src="<?php echo $this->webroot;?>img/share2.png" alt="Share" class='st_sharethis_large' displayText='ShareThis'/></a>
		</div>
	</div>
  </div>
</div>
<div class="container_956" style="height:auto">
	<div class="fashion_photography fashion_photography_first pull-left">
		<div class="inner_fashion_photography">
			<b><?php echo $skill['Category']['name'];?></b>
			<p><?php echo $skill['Category']['name'];?></p>
			<?php if(!empty($subskill_exp)){ ?>
				<ul class=fashion_list>
				 <?php foreach($subskill_exp as $subskill){ ?>
					<li><?php echo $subskill;?></li>
				 <?php } ?>
				</ul>
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
	<div class="card_right_div">
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
			<?php } ?>
		</div>
	</div>
	<div class="hour_rental pull-right">
		  <?php if(isset($skill['Skill']['min_price']) && $skill['Skill']['min_price']!='' && $skill['Skill']['max_price']!=''){?>
			<p><b>$<?php echo intval($skill['Skill']['min_price']);?> - $<?php echo intval($skill['Skill']['max_price']);?></b><span>/hour</span></p>
		  <?php } ?>	
			<a href="javascript:void(0)">learn more</a>
			<input class="btn border_btn offer_my_skill get_in_contact" type="button" value="Get in contact">
	</div>
	</div>
	<div class="clearfix"></div>
	<?php
	 if(!empty($skillimages_exp))
	 {
	?>
	<div class="image_galin_profile">
	    <div id="slider" class="flexslider">
		  <ul class="slides">
		   <?php foreach($skillimages_exp as $skillimage){ ?>
			<li>
			  <img src="<?php echo $this->webroot;?>skill_images/<?php echo $skillimage;?>" />
			</li>
			 <?php   }
			  if(isset($skill['Skill']['skill_video_url'])&&$skill['Skill']['skill_video_url']!='')
			  { 
				  $url = $skill['Skill']['skill_video_url'];
				  if (strpos($url,'vimeo.com') !== false) 
				  {
   					   $video_id = explode("vimeo.com/", $url); 
				?>
			   <li>
			     <iframe src="http://player.vimeo.com/video/<?php echo $video_id[1];?>" width="634" height="422" frameborder="0" allowfullscreen></iframe>
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
			  <li>
			   <iframe src="http://www.youtube.com/embed/<?php echo $video_id;?>" width="634" height="422" frameborder="0" allowfullscreen></iframe>
			  </li>
			<?php }} ?>
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
			     <iframe src="http://player.vimeo.com/video/<?php echo $video_id[1];?>" width="130" height="80" frameborder="0" allowfullscreen></iframe>
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
			   <iframe src="http://www.youtube.com/embed/<?php echo $video_id;?>" width="130" height="80" frameborder="0" allowfullscreen></iframe>
			  </li>
			<?php }} ?>
		  </ul>
		</div>
		
	</div>
	<?php } ?>
	<div class="clearfix"></div>
	<div class="spacality">
		<div class="inner_fashion_photography">
		<h2>My speciality</h2>
		<p><?php if(isset($skill['Skill']['skill_details']) && $skill['Skill']['skill_details']!=''){echo nl2br($skill['Skill']['skill_details']);}?></p>
		
		<h2>About me</h2>
		<p><?php if(isset($skill['User']['bio']) && $skill['User']['bio']!=''){echo nl2br($skill['User']['bio']);}?></p>
		</div>
	</div>
	
	<div class="container_956" style="height:auto">
		<div class="fashion_photography pull-left">
			<div class="inner_fashion_photography">
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<div class="profile_list_img" style="height: 282px !important;">
	<iframe src="<?php echo $this->webroot;?>skills/sliderframe/<?php echo $skill['Skill']['id'];?>" style="margin:0;border:0;width:100%;height:282px;overflow:hidden;" scrolling="no"></iframe> 
</div>
<div class="clearfix"></div>
<div class="container_956" style="height:auto";>
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
	</div>
</div>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
<div class="profile_map" id="profile_map"></div>
<div class="reviews_profile">
	<div class="container_956" style="height:auto">
		<div class="spacality">
			<div class="inner_fashion_photography reviw_sec">	
				<h2>Reviews</h2>
				<ul class="review_list_ul">
					<li>
						<img src="<?php echo $this->webroot;?>img/message_img.png" alt="" />
						<h2>Krissi Hertick</h2>
						<span>8 Aug 2014</span>
						<div class="clearfix"></div>
						<p>
							"Fus ce at mauris et velit coho om modo commodo. Aliquam rutrum, urna sed blandit eui mod,Proin sed purus sapien. Nunc sit amet arcu eget quam molestie placerat eu eget mauris. Aliquam vitae risus pretium, molestie ipsum nec, rhon habitant morbi tristique smassa enim mattis dol or, imperdiet porttitorla. Fus ce at mauris et velit cohoha."
						</p>
					</li>
					<li>
						<img src="<?php echo $this->webroot;?>img/message_img.png" alt="" />
						<h2>Krissi Hertick</h2>
						<span>8 Aug 2014</span>
						<div class="clearfix"></div>
						<p>
							"Fus ce at mauris et velit coho om modo commodo. Aliquam rutrum, urna sed blandit eui mod,Proin sed purus sapien. Nunc sit amet arcu eget quam molestie placerat eu eget mauris. Aliquam vitae risus pretium, molestie ipsum nec, rhon habitant morbi tristique smassa enim mattis dol or, imperdiet porttitorla. Fus ce at mauris et velit cohoha."
						</p>
					</li>
					<li>
						<img src="<?php echo $this->webroot;?>img/message_img.png" alt="" />
						<h2>Krissi Hertick</h2>
						<span>8 Aug 2014</span>
						<div class="clearfix"></div>
						<p>
							"Fus ce at mauris et velit coho om modo commodo. Aliquam rutrum, urna sed blandit eui mod,Proin sed purus sapien. Nunc sit amet arcu eget quam molestie placerat eu eget mauris. Aliquam vitae risus pretium, molestie ipsum nec, rhon habitant morbi tristique smassa enim mattis dol or, imperdiet porttitorla. Fus ce at mauris et velit cohoha."
						</p>
					</li>
					<li>
						<img src="<?php echo $this->webroot;?>img/message_img.png" alt="" />
						<h2>Krissi Hertick</h2>
						<span>8 Aug 2014</span>
						<div class="clearfix"></div>
						<p>
							"Fus ce at mauris et velit coho om modo commodo. Aliquam rutrum, urna sed blandit eui mod,Proin sed purus sapien. Nunc sit amet arcu eget quam molestie placerat eu eget mauris. Aliquam vitae risus pretium, molestie ipsum nec, rhon habitant morbi tristique smassa enim mattis dol or, imperdiet porttitorla. Fus ce at mauris et velit cohoha."
						</p>
					</li>
					<li>
						<img src="<?php echo $this->webroot;?>img/message_img.png" alt="" />
						<h2>Krissi Hertick</h2>
						<span>8 Aug 2014</span>
						<div class="clearfix"></div>
						<p>
							"Fus ce at mauris et velit coho om modo commodo. Aliquam rutrum, urna sed blandit eui mod,Proin sed purus sapien. Nunc sit amet arcu eget quam molestie placerat eu eget mauris. Aliquam vitae risus pretium, molestie ipsum nec, rhon habitant morbi tristique smassa enim mattis dol or, imperdiet porttitorla. Fus ce at mauris et velit cohoha."
						</p>
					</li>
				</ul>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<div class="profile_product">
	<div class="container_956" style="height:auto;">
		<ul class="profile_product">
			<li>
				<img src="<?php echo $this->webroot;?>img/profile_product.png" alt="" />
				<aside>
					<p>$25 - $40 <span>/hour</span></p>
					<b>Lorum ipsum dollor emit</b>
					<strong>Mauris at tortor ullamcorper</strong>
				</aside>
			</li>
			<li>
				<img src="<?php echo $this->webroot;?>img/profile_product.png" alt="" />
				<aside>
					<p>$25 - $40 <span>/hour</span></p>
					<b>Lorum ipsum dollor emit</b>
					<strong>Mauris at tortor ullamcorper</strong>
				</aside>
			</li>
			<li>
				<img src="<?php echo $this->webroot;?>img/profile_product.png" alt="" />
				<aside>
					<p>$25 - $40 <span>/hour</span></p>
					<b>Lorum ipsum dollor emit</b>
					<strong>Mauris at tortor ullamcorper</strong>
				</aside>
			</li>
		</ul>
	</div>
</div>
<div class="heldmate">
	<div class="container_956" style="height:auto;">
		<div class="helmate_left">
			<div class="heldmate_inner">
				<img src="<?php echo $this->webroot;?>img/message_img.png" alt="" />
				<aside>
					<b>Krissi Hertick</b>
					<strong>Steal worker</strong>
				</aside>
				<div class="clearfix"></div>
				<p>
					"Fus ce at mauris et velit coho om modo commodo. Aliquam rutrum, urna sed blandit eui mod,Proin sed purus sapien. Nunc sit amet arcu eget quam molestie placerat eu eget mauris. Aliquam vitae risus pretium, molestie ipsum nec, rhon habitant morbi tristique smassa enim mattis dol or, imperdiet porttitorla. Fus ce at mauris et velit cohoha."
				</p>
			</div>
		</div>
		<img src="<?php echo $this->webroot;?>img/heldmate.jpg" alt="" class="heldmate_image"/>
	</div>
</div>
<style>
.bx-wrapper{width:100% !important;max-width: 100% !important;}
.bx-viewport {height: 266px !important;}
.bx-viewport ul.studiophotos li{height: 266px !important;width: 317px !important;margin:0px !important}
.bx-pager{display:none !important}
.bx-wrapper .bx-next,.bx-wrapper .bx-prev{background:none !important;}
.bx-wrapper .bx-next{background-image:url(../../app/webroot/images/arrow_right.png) !important;background-repeat:no-repeat;width: 27px !important;height: 53px !important;}
.bx-wrapper .bx-prev{background-image:url(../../app/webroot/images/arrow_left.png) !important;background-repeat:no-repeat;width: 27px !important;height: 53px !important;}
#carousel .flex-viewport{bottom:60px}
#carousel ul li{width:130px !important;}
#carousel ul.flex-direction-nav a{top: -32% !important;}
</style>
<style>
#profile_map img { max-width: inherit; }
</style>

<?php echo $this->Html->scriptStart(array('inline'=>false));?>
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
			zoom: 14,
			center: myLatLng,
			mapTypeId: google.maps.MapTypeId.RoadMap
		};

		var map = new google.maps.Map(document.getElementById('profile_map'),mapOptions);
	    var image = '<?php echo $this->webroot;?>images/shade.png';
		var contentString = '';

	    var infowindow = new google.maps.InfoWindow({
			  content: contentString
		});

		marker = new google.maps.Marker({
			position: map.getCenter(),
			map: map,
			icon: image
		});
	}
	$(window).load(function() {
	  // The slider being synced must be initialized first
	  $('#carousel').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: true,
		slideshow: false,
		itemWidth: 200,
		itemMargin: 15,
		asNavFor: '#slider'
	  });
	   
	  $('#slider').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: true,
		slideshow: false,
		sync: "#carousel"
	  });
	});
<?php echo $this->Html->scriptEnd();?>
