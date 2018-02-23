<?php ?>
<script>
	$(document).ready(function(){
		$("#SliderAdminEditForm").validationEngine();
	});	
</script>
<div class="blogs form">
<?php echo $this->Form->create('Slider',array('enctype' => 'multipart/form-data')); ?>
	<fieldset>
		<legend><?php echo __('Edit Slider'); ?>
		
		</br>Please upload image of size 1302 X 554 px</legend>
		<dt><?php echo __('Image'); ?></dt>
		<dd>
			<?php
			$uploadFolder = "slider_images";
			$uploadPath = WWW_ROOT . $uploadFolder;
			$imageName = $this->request->data['Slider']['image'];
			if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
				echo($this->Html->image('/slider_images/'.$imageName, array('height' => '200','width' => '200')));
			} 
			?>
			&nbsp;
		</dd>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('hid_image',array('value'=>$this->request->data['Slider']['image'],'type'=>'hidden'));
		echo $this->Form->input('image', array('type'=>'file'));
		echo $this->Form->input('active',array('type'=>'checkbox'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<?php echo($this->element('admin_sidebar'));?>
