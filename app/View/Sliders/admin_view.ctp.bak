<div class="blogs view">
<h2><?php echo __('Slider'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($slider['Slider']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Image'); ?></dt>
		<dd>
			<?php
			$uploadFolder = "slider_images";
			$uploadPath = WWW_ROOT . $uploadFolder;
			$imageName = $slider['Slider']['image'];
			if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
				echo($this->Html->image('/slider_images/'.$imageName, array('height' => '200','width' => '200')));
			} 
			?>
			&nbsp;
		</dd>		
		<dt><?php echo __('Active'); ?></dt>
		<dd>
			<?php echo h($slider['Slider']['active']==1?'Yes':'No'); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<?php echo($this->element('admin_sidebar'));?>