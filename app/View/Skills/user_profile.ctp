<div class="profile_cover_photo">
	<div class="profile_overlay">
		<div class="container_960">
			<div class="personal_profile_left">
				<?php
				 if(isset($profileuser['User']['profile_image']) && $profileuser['User']['profile_image']!='')
				 {
				?>
				  <img src="<?php echo $this->webroot; ?>user_images/<?php echo $profileuser['User']['profile_image'];?>" alt="<?php echo $profileuser['User']['first_name'];?>" />
				<?php }else{ ?>
				   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" alt="<?php echo $profileuser['User']['first_name'];?>" />
				<?php } ?>
				<aside>
					<b><?php echo $profileuser['User']['first_name'].' '.$profileuser['User']['last_name'];?></b>
					<p></p>
				</aside>
			</div>
		</div>
	</div>
</div>
<div class="container_983" style="height:auto">
	<div class="fashion_photography fashion_photography_first pull-left">
		<div class="inner_fashion_photography non_skill_left">
			<b>About me</b>
			<p>
				<?php if(isset($profileuser['User']['bio']) && $profileuser['User']['bio']!=''){echo nl2br($profileuser['User']['bio']);}?>
			</p>
			<b>Basic skill</b>
			<?php 
				if(isset($profileuser['User']['basic_interests']) && $profileuser['User']['basic_interests']!='')
				{
				   $xtr=explode(',',$user['User']['basic_interests']);
				}
				else
				{ 
					$xtr=array();
				}
				if(!empty($xtr))
				{
			 ?>
			<ul class=fashion_list>
				<?php foreach($xtr as $xt){ ?>
					<li><?php echo $xt;?></li>
				<?php } ?>
			</ul>
			<?php } ?>
			<div class="clearfix"></div>
			<ul class="profile_social">
				<?php if(isset($profileuser['User']['personal_website_url']) && $profileuser['User']['personal_website_url']!=''){?>
				 <li><img src="<?php echo $this->webroot;?>img/profile_link.png" alt="Website Link Image"/><a href="<?php echo $profileuser['User']['personal_website_url'];?>" target="_blank"><p><?php echo $profileuser['User']['personal_website_url'];?></p></a></li>
               <?php } ?>
			   <?php if(isset($profileuser['User']['facebook_url']) && $profileuser['User']['facebook_url']!=''){?>
				<li><a href="<?php echo $profileuser['User']['facebook_url'];?>" target="_blank"><img src="<?php echo $this->webroot;?>img/profile_social_1.png" alt="Facebook"/></a></li>
			   <?php } ?>
               <?php if(isset($profileuser['User']['linkdin_url']) && $profileuser['User']['linkdin_url']!=''){?>
				<li><a href="<?php echo $profileuser['User']['linkdin_url'];?>" target="_blank"><img src="<?php echo $this->webroot;?>img/profile_social2.png" alt="Linkedin"/></a></li>
			   <?php } ?>
			   <?php if(isset($profileuser['User']['twitter_url']) && $profileuser['User']['twitter_url']!=''){?>
				<li><a href="<?php echo $profileuser['User']['twitter_url'];?>" target="_blank"><img src="<?php echo $this->webroot;?>img/profile_social3.png" alt="Twitter" /></a></li>
               <?php } ?>
			   <?php if(isset($profileuser['User']['etsy_store_url']) && $profileuser['User']['etsy_store_url']!=''){?>
				<li><a href="<?php echo $profileuser['User']['etsy_store_url'];?>" target="_blank"><img src="<?php echo $this->webroot;?>img/profile_social4.png" alt="Etsy" /></a></li>
			   <?php } ?>
			</ul>
		</div>
	</div>
	<div class="spacality non_skill_profile pull-right">
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
				</ul>
			</div>
		 <div class="clearfix"></div>
	 </div>
</div>   	