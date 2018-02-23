<?php echo $this->Html->script('ckeditor/ckeditor');?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Home Page'); ?></div>
			</div>
			<div class="users form">
			<?php echo $this->Form->create('Content',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
				<input type="hidden" name="data[Content][hidsite_banner]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['banner_image']);?>"/>
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['banner_image'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'Site Banner','style'=>'width:100%')));
				}
				else
				{

				}
				?>
				
				<?php
                    echo $this->Form->input('banner_image',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font>
                 
				<br><br>Banner Text<br>
				<textarea name="data[Content][banner_text]" class="ckeditor" required><?php if(isset($sitesetting['SiteSetting']['banner_text']) && $sitesetting['SiteSetting']['banner_text']!=''){echo($sitesetting['SiteSetting']['banner_text']);}?></textarea>

				<br><br>Banner Bottom Text<br>
				<textarea name="data[Content][banner_bottom_text]" class="ckeditor" required><?php if(isset($sitesetting['SiteSetting']['banner_bottom_text']) && $sitesetting['SiteSetting']['banner_bottom_text']!=''){echo($sitesetting['SiteSetting']['banner_bottom_text']);}?></textarea>
				</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
