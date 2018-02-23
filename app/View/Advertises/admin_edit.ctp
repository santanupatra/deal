<?php ?>

<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Advertisement'); ?></div>
			</div>
			<div class="shops form">
			<?php echo $this->Form->create('Advertise',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
				

				<?php
                                
	echo $this->Form->input('id',array('type'=>'hidden','value'=>$this->request->data['Advertise']['id']));				
	echo $this->Form->input('name',array('required'=>'required','value'=>$this->request->data['Advertise']['name']));
	echo $this->Form->input('link',array('required'=>'required','value'=>$this->request->data['Advertise']['link']));
        echo $this->Form->input('description',array('required'=>'required','class'=>'ckeditor','value'=>$this->request->data['Advertise']['description']));
        
					
				?>
				   
				

				<?php
					
	echo $this->Form->input('logos', array('type' => 'hidden','default' =>$this->request->data['Advertise']['logo']));			
	echo $this->Form->input('logo',array('type'=>'file'));
					?>
	<font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>
					
	<div>
                    <?php
                        if(isset( $this->request->data['Advertise']['logo']) and !empty( $this->request->data['Advertise']['logo']))
                    {
                    ?>
                    <img alt="" src="<?php echo $this->webroot;?>advertise_logos/<?php echo $this->request->data['Advertise']['logo'];?>" style=" height:80px; width:80px;">
                    <?php
                    }
                    else{
                    ?>
                   <img alt="" src="<?php echo $this->webroot;?>advertise_logos/default.png" style=" height:80px; width:80px;">

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