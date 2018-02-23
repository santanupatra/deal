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
				<input type="hidden" name="data[Content][hidlearn_image1]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['learn_image1']);?>"/>
				<input type="hidden" name="data[Content][hidlearn_hover1]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['learn_hover1']);?>"/>

				<input type="hidden" name="data[Content][hidlearn_image2]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['learn_image2']);?>"/>
				<input type="hidden" name="data[Content][hidlearn_hover2]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['learn_hover2']);?>"/>

				<input type="hidden" name="data[Content][hidlearn_image3]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['learn_image3']);?>"/>
				<input type="hidden" name="data[Content][hidlearn_hover3]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['learn_hover3']);?>"/>

				<input type="hidden" name="data[Content][hidlearn_image4]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['learn_image4']);?>"/>
				<input type="hidden" name="data[Content][hidlearn_hover4]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['learn_hover4']);?>"/>
                
				<?php
                    echo $this->Form->input('learn_image1',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['learn_image1'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'Learn')));
				}
				else{}
				?>

				<?php
                    echo $this->Form->input('learn_hover1',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				<div style="background:#e8e8e8;padding:10px;width:17%">
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['learn_hover1'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'Learn')));
				}
				else{}
				?>
				</div>
				<br><br>Learn Text1<br>
				<textarea name="data[Content][learn_text1]" class="ckeditor" required><?php if(isset($sitesetting['SiteSetting']['learn_text1']) && $sitesetting['SiteSetting']['learn_text1']!=''){echo($sitesetting['SiteSetting']['learn_text1']);}?></textarea>

				<?php
                    echo $this->Form->input('learn_image2',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['learn_image2'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'Learn')));
				}
				else{}
				?>
				<?php
                    echo $this->Form->input('learn_hover2',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				<div style="background:#e8e8e8;padding:10px;width:17%">
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['learn_hover2'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'Learn')));
				}
				else{}
				?>
				</div>
				<br><br>Learn Text2<br>
				<textarea name="data[Content][learn_text2]" class="ckeditor" required><?php if(isset($sitesetting['SiteSetting']['learn_text2']) && $sitesetting['SiteSetting']['learn_text2']!=''){echo($sitesetting['SiteSetting']['learn_text2']);}?></textarea>

				<?php
                    echo $this->Form->input('learn_image3',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['learn_image3'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'Learn')));
				}
				else{}
				?>
				<?php
                    echo $this->Form->input('learn_hover3',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				<div style="background:#e8e8e8;padding:10px;width:17%">
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['learn_hover3'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'Learn')));
				}
				else{}
				?>
				</div>
				<br><br>Learn Text3<br>
				<textarea name="data[Content][learn_text3]" class="ckeditor" required><?php if(isset($sitesetting['SiteSetting']['learn_text3']) && $sitesetting['SiteSetting']['learn_text3']!=''){echo($sitesetting['SiteSetting']['learn_text3']);}?></textarea>

				<?php
                    echo $this->Form->input('learn_image4',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['learn_image4'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'Learn')));
				}
				else{}
				?>
				<?php
                    echo $this->Form->input('learn_hover4',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				<div style="background:#e8e8e8;padding:10px;width:17%">
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['learn_hover4'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'Learn')));
				}
				else{}
				?>
				</div>
				<br><br>Learn Text4<br>
				<textarea name="data[Content][learn_text4]" class="ckeditor" required><?php if(isset($sitesetting['SiteSetting']['learn_text4']) && $sitesetting['SiteSetting']['learn_text4']!=''){echo($sitesetting['SiteSetting']['learn_text4']);}?></textarea>

				</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
