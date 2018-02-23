<?php echo $this->Html->script('ckeditor/ckeditor');?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Content'); ?></div>
			</div>
			<div class="users form">
			<?php echo $this->Form->create('Content'); ?>
				<fieldset>
				<?php
					echo $this->Form->input('id');
					#echo $this->Form->input('page_name',array('required'=>'required'));
					echo $this->Form->input('page_heading',array('required'=>'required'));
					echo $this->Form->input('content',array('required'=>'required','class'=>'ckeditor'));
				?>
				</fieldset>
				
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
