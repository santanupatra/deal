<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('View User'); ?></div>
			</div>
			<div class="users view">
				<dl>
					<dt><?php echo __('Id'); ?></dt>
					<dd>
						<?php echo h($user['User']['id']); ?>
						&nbsp;
					</dd>
                                        
                                        
					<dt><?php echo __('Profile Image'); ?></dt>
					<dd>
						<?php
						$uploadPath= Configure::read('UPLOAD_USER_IMG_PATH');
						$imageName = $user['User']['profile_image'];
						if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
							echo($this->Html->image('/user_images/'.$imageName, array('alt' => $user['User']['first_name'].'&nbsp;'.$user['User']['last_name'],'width'=>150,'height'=>150)));
						} else {
							echo($this->Html->image('/user_images/default.png', array('alt' => $user['User']['first_name'].'&nbsp;'.$user['User']['last_name'])));
						}
						?>
						&nbsp;
					</dd>
					<dt><?php echo __('First Name'); ?></dt>
					<dd>
						<?php echo h($user['User']['first_name']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Last Name'); ?></dt>
					<dd>
						<?php echo h($user['User']['last_name']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Email'); ?></dt>
					<dd>
						<?php echo h($user['User']['email']); ?>
						&nbsp;
					</dd>
					<!-- <dt><?php echo __('Company Name'); ?></dt>
					<dd>
						<?php echo h($user['User']['company_name']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Business Email'); ?></dt>
					<dd>
						<?php if(isset($user['User']['paypal_business_email']) && $user['User']['paypal_business_email']!=''){echo $user['User']['paypal_business_email'];}else{echo 'N/A';} ?>
						&nbsp;
					</dd> -->
					<dt><?php echo __('Phone'); ?></dt>
					<dd>
						<?php if(isset($user['User']['mobile_number']) && $user['User']['mobile_number']!=''){echo $user['User']['mobile_number'];}else{echo 'N/A';} ?>
						&nbsp;
					</dd>
<!--					<dt><?php echo __('Address'); ?></dt>
					<dd>
						<?php if(isset($user['User']['address']) && $user['User']['address']!=''){echo nl2br($user['User']['address']);}else{echo 'N/A';} ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Zip Code'); ?></dt>
					<dd>
						<?php if(isset($user['User']['zip_code']) && $user['User']['zip_code']!=''){echo $user['User']['zip_code'];}else{echo 'N/A';} ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Short Description'); ?></dt>
					<dd>
						<?php if(isset($user['User']['bio']) && $user['User']['bio']!=''){echo nl2br($user['User']['bio']);}else{echo 'N/A';} ?>
						&nbsp;
					</dd>-->
<!--					<dt><?php echo __('Gender'); ?></dt>
					<dd>
						<?php if(isset($user['User']['gender']) && $user['User']['gender']=='M'){echo 'Male';}elseif(isset($user['User']['gender']) && $user['User']['gender']=='F'){echo 'Female';}else{echo 'N/A';} ?>
						&nbsp;
					</dd>-->
					<dt><?php echo __('Join Date'); ?></dt>
					<dd>
						<?php echo h(date('d M, Y',strtotime($user['User']['registration_date']))); ?>
						&nbsp;
					</dd>
					<!-- <dt><?php echo __('Facebook Url'); ?></dt>
					<dd>
						<?php if(isset($user['User']['facebook_url']) && $user['User']['facebook_url']!=''){echo $user['User']['facebook_url'];}else{echo 'N/A';} ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Twitter Url'); ?></dt>
					<dd>
						<?php if(isset($user['User']['twitter_url']) && $user['User']['twitter_url']!=''){echo $user['User']['twitter_url'];}else{echo 'N/A';} ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Linkedin Url'); ?></dt>
					<dd>
						<?php if(isset($user['User']['linkdin_url']) && $user['User']['linkdin_url']!=''){echo $user['User']['linkdin_url'];}else{echo 'N/A';} ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Youtube Url'); ?></dt>
					<dd>
						<?php if(isset($user['User']['youtube_url']) && $user['User']['youtube_url']!=''){echo $user['User']['youtube_url'];}else{echo 'N/A';} ?>
						&nbsp;
					</dd> -->
					<dt><?php echo __('Active'); ?></dt>
					<dd>
						<?php echo h($user['User']['is_active']==1?'Yes':'No'); ?>
						&nbsp;
					</dd>
					<!-- <dt><?php echo __('Admin'); ?></dt>
					<dd>
						<?php echo h($user['User']['is_admin']==1?'Yes':'No'); ?>
						&nbsp;
					</dd> -->
					
				</dl>
			</div>
		</div>
	</div>
</div>
