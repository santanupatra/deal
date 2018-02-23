<?php ?>

<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Add middle section'); ?></div>
			</div>
                    	
                    
                    
                    
                    <div class="users form">
			<?php echo $this->Form->create('Middle',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
                               

				<?php
                                        
     echo $this->Form->input('title',array('required'=>'required'));                                   
    echo $this->Form->input('description',array('label'=>'Description','class'=>'ckeditor'));
                                       
                                        ?>
                                        
                                 <?php
					
				
	echo $this->Form->input('image',array('type'=>'file'));
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
