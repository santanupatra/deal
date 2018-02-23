<?php echo $this->Html->script('ckeditor/ckeditor');?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Account Content'); ?></div>
			</div>
			<div class="users form">
			<?php echo $this->Form->create('Content',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
				 Account Head Text<br>
				<textarea name="data[Content][account_header_text]" class="ckeditor" required><?php if(isset($sitesetting['SiteSetting']['account_header_text']) && $sitesetting['SiteSetting']['account_header_text']!=''){echo($sitesetting['SiteSetting']['account_header_text']);}?></textarea>

				<br><br>Account Bottom Text<br>
				<textarea name="data[Content][account_footer_text]" class="ckeditor" required><?php if(isset($sitesetting['SiteSetting']['account_footer_text']) && $sitesetting['SiteSetting']['account_footer_text']!=''){echo($sitesetting['SiteSetting']['account_footer_text']);}?></textarea>

				</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
