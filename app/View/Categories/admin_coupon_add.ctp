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
                  
                   echo $this->Form->input('description', array('label' => 'Description', 'class' => 'ckeditor'));
                  echo $this->Form->input('image',array('required'=>'required','type'=>'file'));
                  
                  ?>
              
              
               
              
                  
		<?php  echo $this->Form->input('is_active');
                
	    ?>
              <input type="checkbox" name="data[Category][is_popular]" value='1'> Show in Home page
	 </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
  </div>
		</div>
	</div>
</div>
<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
<script type="text/javascript">
    CKEDITOR.config.toolbar = 'Custom_medium';
    CKEDITOR.config.height = '200';
    CKEDITOR.replace('PagePDesc');
</script>