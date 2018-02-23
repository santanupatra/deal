<?php ?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Site Logo'); ?></div>
			</div>
			<div class="users form">
			<?php echo $this->Form->create('SiteSetting',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
				<input type="hidden" name="data[SiteSetting][hidsite_logo]" id="SiteSettingHidSiteLogo" value="<?php echo($this->request->data['SiteSetting']['site_logo']);?>"/>
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $this->request->data['SiteSetting']['site_logo'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'Site Logo')));
				}
				else
				{

				}
				?>
				
				<?php
					echo $this->Form->input('id');
                                        echo $this->Form->input('site_logo',array('type'=>'file'));
				?>
                                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font>
                                
                    <input type="hidden" name="data[SiteSetting][hidbanner_image]" id="SiteSettingHidbanner_image" value="<?php echo($this->request->data['SiteSetting']['banner_image']);?>"/>
				<?php
				$uploadFolder = "banner_image";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $this->request->data['SiteSetting']['banner_image'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/banner_image/'.$imageName, array('alt' => 'Banner Image')));
				}
				else
				{

				}
				?>
				
				<?php
					echo $this->Form->input('banner_image',array('type'=>'file'));
				?>
                                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font>            
				
			</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
		    </div>
		</div>
	</div>
</div>
