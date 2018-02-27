<?php ?>

<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Location'); ?></div>
			</div>
			<div class="shops form">
			<?php echo $this->Form->create('City',array('enctype'=>'multipart/form-data')); 
                        echo $this->Form->input('id');
                        ?>
                            
				<fieldset>
				
				 
					<?php
					
					echo $this->Form->input('name',array('required'=>'required','label'=>'Location Name'));
					
				?>
				   
				
							
					
				<?php
					
					echo $this->Form->input('is_active');
                                       
				?>
				</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
       