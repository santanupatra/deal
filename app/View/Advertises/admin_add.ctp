<?php ?>

<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Add Advertisement'); ?></div>
			</div>
			<div class="shops form">
			<?php echo $this->Form->create('Advertise',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
				<?php
				echo $this->Form->input('name',array('required'=>'required'));
				echo $this->Form->input('link',array('required'=>'required'));
        		echo $this->Form->input('description',array('required'=>'required','class'=>'ckeditor'));
				?>
				<?php
					echo $this->Form->input('logo',array('type'=>'file','required'=>'required'));
					?>
					<font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
				</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>

  <?php echo $this->Html->script('ckeditor/ckeditor');?>
 <script type="text/javascript">
      CKEDITOR.config.toolbar = 'Custom_medium';
      CKEDITOR.config.height = '200';
      CKEDITOR.replace('PagePDesc');
  </script>      