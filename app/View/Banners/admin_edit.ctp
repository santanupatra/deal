<?php ?>

<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Banner'); ?></div>
			</div>
			<div class="shops form">
			<?php echo $this->Form->create('Banner',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
				

				<?php
                                
	echo $this->Form->input('id',array('type'=>'hidden','value'=>$this->request->data['Banner']['id']));				
	echo $this->Form->input('title',array('required'=>'required','value'=>$this->request->data['Banner']['title']));
	
        
					
				?>
				   
				

				<?php
					
	echo $this->Form->input('logos', array('type' => 'hidden','default' =>$this->request->data['Banner']['image']));			
	echo $this->Form->input('image',array('type'=>'file'));
					?>
	<font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
					
	<div>
                    <?php
                        if(isset( $this->request->data['Banner']['image']) and !empty( $this->request->data['Banner']['image']))
                    {
                    ?>
                    <img alt="" src="<?php echo $this->webroot;?>banner_image/<?php echo $this->request->data['Banner']['image'];?>" style=" height:80px; width:80px;">
                    <?php
                    }
                    else{
                    ?>
                   <img alt="" src="<?php echo $this->webroot;?>banner_image/default.png" style=" height:80px; width:80px;">

                    <?php } ?>
                </div>				
					
				</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>


 
      