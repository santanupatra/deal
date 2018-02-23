<?php echo $this->Html->script('ckeditor/ckeditor');?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Photo Grid'); ?></div>
			</div>
			<div class="users form">
			<?php echo $this->Form->create('Content',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
				<input type="hidden" name="data[Content][hidphoto_grid1]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['photo_grid1']);?>"/>

				<input type="hidden" name="data[Content][hidphoto_grid2]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['photo_grid2']);?>"/>

				<input type="hidden" name="data[Content][hidphoto_grid3]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['photo_grid3']);?>"/>

				<input type="hidden" name="data[Content][hidphoto_grid4]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['photo_grid4']);?>"/>

				<input type="hidden" name="data[Content][hidphoto_grid5]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['photo_grid5']);?>"/>

				<input type="hidden" name="data[Content][hidphoto_grid6]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['photo_grid6']);?>"/>

				<input type="hidden" name="data[Content][hidphoto_grid7]" id="SiteSettingHidSiteLogo" value="<?php echo($sitesetting['SiteSetting']['photo_grid7']);?>"/>
                
				<?php
                    echo $this->Form->input('photo_grid1',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['photo_grid1'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'Photo Grid')));
				}
				else
				{

				}
				?>
				<br><br>Link1<br>
				<input type="text" name="data[Content][photo_grid_link1]" value="<?php echo $sitesetting['SiteSetting']['photo_grid_link1'];?>" required>

				<?php
                    echo $this->Form->input('photo_grid2',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['photo_grid2'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'Photo Grid')));
				}
				else
				{

				}
				?>
				<br><br>Link2<br>
				<input type="text" name="data[Content][photo_grid_link2]" value="<?php echo $sitesetting['SiteSetting']['photo_grid_link2'];?>" required>


                <?php
                    echo $this->Form->input('photo_grid3',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['photo_grid3'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'Photo Grid')));
				}
				else
				{

				}
				?>
				<br><br>Link3<br>
				<input type="text" name="data[Content][photo_grid_link3]" value="<?php echo $sitesetting['SiteSetting']['photo_grid_link3'];?>" required>


				<?php
                    echo $this->Form->input('photo_grid4',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['photo_grid4'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'Photo Grid')));
				}
				else
				{

				}
				?>
				<br><br>Link4<br>
				<input type="text" name="data[Content][photo_grid_link4]" value="<?php echo $sitesetting['SiteSetting']['photo_grid_link4'];?>" required>

				<?php
                    echo $this->Form->input('photo_grid5',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['photo_grid5'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'Photo Grid')));
				}
				else
				{

				}
				?>
				<br><br>Link5<br>
				<input type="text" name="data[Content][photo_grid_link5]" value="<?php echo $sitesetting['SiteSetting']['photo_grid_link5'];?>" required>

				<?php
                    echo $this->Form->input('photo_grid6',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['photo_grid6'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'Photo Grid')));
				}
				else
				{

				}
				?>
				<br><br>Link6<br>
				<input type="text" name="data[Content][photo_grid_link6]" value="<?php echo $sitesetting['SiteSetting']['photo_grid_link6'];?>" required>
               
			    <?php
                    echo $this->Form->input('photo_grid7',array('type'=>'file'));
				?>
                <font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				<?php
				$uploadFolder = "site_logo";
				$uploadPath = WWW_ROOT . $uploadFolder;
				$imageName = $sitesetting['SiteSetting']['photo_grid7'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/site_logo/'.$imageName, array('alt' => 'Photo Grid')));
				}
				else
				{

				}
				?>
				<br><br>Link7<br>
				<input type="text" name="data[Content][photo_grid_link7]" value="<?php echo $sitesetting['SiteSetting']['photo_grid_link7'];?>" required>


				</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
