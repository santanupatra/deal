<?php echo $this->Html->script('ckeditor/ckeditor');?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Home Middle Section'); ?></div>
			</div>
			<div class="users form">
			<?php echo $this->Form->create('Content',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
				<input type="hidden" name="data[Content][hidhome_middle_image1]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['home_middle_image1']);?>"/>
				<input type="hidden" name="data[Content][hidhome_middle_image2]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['home_middle_image2']);?>"/>
				<input type="hidden" name="data[Content][hidhome_middle_image3]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['home_middle_image3']);?>"/>
				
                
				<?php
                    echo $this->Form->input('home_middle_image1',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['home_middle_image1'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'How It Works')));
				}
				else
				{

				}
				?>
				
				<br><br>Home Middle Header1<br>
				<textarea name="data[Content][home_middle_header1]" class="ckeditor" required><?php if(isset($sitesetting['SiteSetting']['home_middle_header1']) && $sitesetting['SiteSetting']['home_middle_header1']!=''){echo($sitesetting['SiteSetting']['home_middle_header1']);}?></textarea>
				<br><br>Home Middle Description1<br>
				<textarea name="data[Content][home_middle_desc1]" class="ckeditor" required><?php if(isset($sitesetting['SiteSetting']['home_middle_desc1']) && $sitesetting['SiteSetting']['home_middle_desc1']!=''){echo($sitesetting['SiteSetting']['home_middle_desc1']);}?></textarea>

				<?php
                    echo $this->Form->input('home_middle_image2',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['home_middle_image2'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'How It Works')));
				}
				else
				{

				}
				?>
				
				<br><br>Home Middle Header2<br>
				<textarea name="data[Content][home_middle_header2]" class="ckeditor" required><?php if(isset($sitesetting['SiteSetting']['home_middle_header2']) && $sitesetting['SiteSetting']['home_middle_header2']!=''){echo($sitesetting['SiteSetting']['home_middle_header2']);}?></textarea>
				<br><br>Home Middle Description2<br>
				<textarea name="data[Content][home_middle_desc2]" class="ckeditor" required><?php if(isset($sitesetting['SiteSetting']['home_middle_desc2']) && $sitesetting['SiteSetting']['home_middle_desc2']!=''){echo($sitesetting['SiteSetting']['home_middle_desc2']);}?></textarea>

                <?php
                    echo $this->Form->input('home_middle_image3',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['home_middle_image3'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'How It Works')));
				}
				else
				{

				}
				?>
			
				<br><br>Home Middle Header3<br>
				<textarea name="data[Content][home_middle_header3]" class="ckeditor" required><?php if(isset($sitesetting['SiteSetting']['home_middle_header3']) && $sitesetting['SiteSetting']['home_middle_header3']!=''){echo($sitesetting['SiteSetting']['home_middle_header3']);}?></textarea>
				<br><br>Home Middle Description3<br>
				<textarea name="data[Content][home_middle_desc3]" class="ckeditor" required><?php if(isset($sitesetting['SiteSetting']['home_middle_desc3']) && $sitesetting['SiteSetting']['home_middle_desc3']!=''){echo($sitesetting['SiteSetting']['home_middle_desc3']);}?></textarea>


				</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
