<?php ?>

<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Banner Video'); ?></div>
			</div>
			<div class="shops form">
			<?php echo $this->Form->create('Banner',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
				

				<?php
                                
	echo $this->Form->input('id',array('type'=>'hidden','value'=>$this->request->data['Banner']['id']));				
	echo $this->Form->input('title',array('required'=>'required','value'=>$this->request->data['Banner']['title'],'label'=> 'Youtube Link'));
	
        
					
				?>
				
					
				</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>


 
      