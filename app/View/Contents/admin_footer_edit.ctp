<?php echo $this->Html->script('ckeditor/ckeditor');?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit I Want To Learn'); ?></div>
			</div>
			<div class="users form">
			<?php echo $this->Form->create('Content',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
				<input type="hidden" name="data[Content][hidfooter_image]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['footer_image']);?>"/>
                
				<?php
                    echo $this->Form->input('footer_image',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['footer_image'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'Learn')));
				}
				else{}
				?>
				<br><br>Footer Head<br>
				<textarea name="data[Content][footer_head]" class="ckeditor" required><?php if(isset($sitesetting['SiteSetting']['footer_head']) && $sitesetting['SiteSetting']['footer_head']!=''){echo($sitesetting['SiteSetting']['footer_head']);}?></textarea>

				<br><br>Footer Button Text<br>
				<textarea name="data[Content][footer_button_text]" class="ckeditor" required><?php if(isset($sitesetting['SiteSetting']['footer_button_text']) && $sitesetting['SiteSetting']['footer_button_text']!=''){echo($sitesetting['SiteSetting']['footer_button_text']);}?></textarea>

				<br><br>Footer Text<br>
				<textarea name="data[Content][footer_text]" class="ckeditor" required><?php if(isset($sitesetting['SiteSetting']['footer_text']) && $sitesetting['SiteSetting']['footer_text']!=''){echo($sitesetting['SiteSetting']['footer_text']);}?></textarea>

				</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
