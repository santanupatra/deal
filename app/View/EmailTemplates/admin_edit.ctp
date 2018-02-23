<?php echo $this->Html->script('ckeditor/ckeditor');?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Email Template'); ?></div>
			</div>
			<div class="users form">
			<?php echo $this->Form->create('EmailTemplate',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
				<?php
					echo $this->Form->input('id');
					echo $this->Form->input('subject');
					echo $this->Form->textarea('content',array('class'=>'ckeditor'));
				?>
				</fieldset>
				
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
