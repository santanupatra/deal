<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Add Category'); ?></div>
			</div>
			<div class="users form">
      <?php echo $this->Form->create('Category',array('enctype'=>'multipart/form-data')); ?>
	  <fieldset>
		<?php
		  echo $this->Form->input('name',array('required'=>'required'));
                  
                  
                  echo $this->Form->input('image',array('required'=>'required','type'=>'file'));
                  
		  echo $this->Form->input('is_active');
	    ?>
	 </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
  </div>
		</div>
	</div>
</div>
