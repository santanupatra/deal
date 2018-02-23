<?php ?>
<script>
	$(document).ready(function(){
		$("#SliderAdminAddForm").validationEngine();
	});	
</script>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Add Slider'); ?></div>
			</div>
			<div class="users form">
<?php echo $this->Form->create('Slider',array('enctype' => 'multipart/form-data')); ?>
	<fieldset>
		
	<?php
		echo $this->Form->input('image', array('type'=>'file','class'=>'validate[required,UploadFile1]'));
		echo $this->Form->input('active',array('type'=>'checkbox'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>


</div>
		</div>
	</div>
</div>
