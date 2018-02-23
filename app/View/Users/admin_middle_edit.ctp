<?php ?>

<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit middle section'); ?></div>
			</div>
                    	
                    
                    
                    
                    <div class="users form">
			<?php echo $this->Form->create('Middle',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
				

				<?php
                                
	echo $this->Form->input('id',array('type'=>'hidden','value'=>$this->request->data['Middle']['id']));				
	echo $this->Form->input('title',array('required'=>'required','value'=>$this->request->data['Middle']['title']));
	
        echo $this->Form->input('description',array('label'=>'Description','class'=>'ckeditor','value'=>$this->request->data['Middle']['description']));
					
				?>
				   
				

				<?php
					
	echo $this->Form->input('logos', array('type' => 'hidden','default' =>$this->request->data['Middle']['image']));			
	echo $this->Form->input('image',array('type'=>'file'));
					?>
	<font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
					
	<div>
                    <?php
                        if(isset( $this->request->data['Middle']['image']) and !empty( $this->request->data['Middle']['image']))
                    {
                    ?>
                    <img alt="" src="<?php echo $this->webroot;?>middle_image/<?php echo $this->request->data['Middle']['image'];?>" style=" height:80px; width:80px;">
                    <?php
                    }
                    else{
                    ?>
                   <img alt="" src="<?php echo $this->webroot;?>middle_image/default.png" style=" height:80px; width:80px;">

                    <?php } ?>
                </div>				
					
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
 
      