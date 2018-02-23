<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Admin'); ?></div>
			</div>
			<div class="users form">
			<?php echo $this->Form->create('User',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
				<?php
					echo $this->Form->input('id');
					echo $this->Form->input('hid_pw',array('type'=>'hidden','value'=>$this->request->data['User']['password']));
					echo $this->Form->input('hid_img',array('type'=>'hidden','value'=>$this->request->data['User']['profile_image']));

					echo $this->Form->input('first_name',array('required'=>'required'));
					echo $this->Form->input('last_name',array('required'=>'required'));
					echo $this->Form->input('email',array('required'=>'required','type'=>'email'));
					echo $this->Form->input('paypal_business_email',array('type'=>'email'));
					echo $this->Form->input('username',array('required'=>'required'));
					echo $this->Form->input('password',array('value'=>''));
					echo $this->Form->input('mobile_number');
					echo $this->Form->input('bio',array('label'=>'Short Description'));
					echo $this->Form->input('address');
					echo $this->Form->input('zip_code');
				?>
				   <span style="float:left;margin-left:10px;"><input type='radio' name='data[User][gender]' id="male" required value="M" <?php if(isset($this->request->data['User']['gender'])&&$this->request->data['User']['gender']=='M'){echo 'checked';}?>>&nbsp;Male&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=
				   "float:left"><input type='radio' name='data[User][gender]' id="female" required value="F" <?php if(isset($this->request->data['User']['gender'])&&$this->request->data['User']['gender']=='F'){echo 'checked';}?>>&nbsp;Female</span>
				   <br/><br/>
				<?php
					echo $this->Form->input('facebook_url');
					echo $this->Form->input('twitter_url');
					echo $this->Form->input('linkdin_url');
					echo $this->Form->input('youtube_url');
					
					echo $this->Form->input('profile_image',array('type'=>'file'));
				?>
				<font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				<?php
				$uploadPath= Configure::read('UPLOAD_USER_IMG_PATH');
				$imageName = $this->request->data['User']['profile_image'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/user_images/'.$imageName, array('alt' => 'User Image', 'height' => '150', 'width' => '150')));
				} 
				else {
					echo($this->Html->image('/user_images/default.png', array('alt' => 'User Image')));
				     }
				?>
				<?php
					echo $this->Form->input('is_active');
				?>
				
				</fieldset>
				
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
