<?php echo $this->Html->script('ckeditor/ckeditor');?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Maker Count'); ?></div>
			</div>
			<div class="users form">
			<?php echo $this->Form->create('Content',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
				<input type="hidden" name="data[Content][hidmaker_image]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['maker_image']);?>"/>

                
				<?php
                    echo $this->Form->input('maker_image',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['maker_image'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'Maker Count')));
				}
				else
				{

				}
				?>
				<br><br>Text Upper<br>
				<input type="text" name="data[Content][maker_count]" value="<?php echo $sitesetting['SiteSetting']['maker_count'];?>" required>

				<br><br>Text Bottom<br>
				<input type="text" name="data[Content][maker_text]" value="<?php echo $sitesetting['SiteSetting']['maker_text'];?>" required>

				</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
