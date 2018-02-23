<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php if ($this->request->data['Category']['parent_id']!=0) {   echo 'Edit Sub category';  } else { echo __('Edit Category'); } ?></div>
			</div>
			<div class="users form">
           <?php echo $this->Form->create('Category',array('enctype'=>'multipart/form-data'));  ?>
			<fieldset>
			   <?php
                           echo $this->Form->input('hid_img',array('type'=>'hidden','value'=>$this->request->data['Category']['image']));
				echo $this->Form->input('id');
				echo $this->Form->input('name',array('required'=>'required'));
                                
                                echo $this->Form->input('image',array('type'=>'file'));
                             ?>   
				<div>
                    <?php
                        if(isset( $this->request->data['Category']['image']) and !empty( $this->request->data['Category']['image']))
                    {
                    ?>
                    <img alt="" src="<?php echo $this->webroot;?>category_images/<?php echo $this->request->data['Category']['image'];?>" style=" height:80px; width:80px;">
                    <?php
                    }
                    else{
                    ?>
                   <img alt="" src="<?php echo $this->webroot;?>category_images/default.png" style=" height:80px; width:80px;">

                    <?php } ?>
                </div>
				
                                
                                
                              <?php  
				echo $this->Form->input('is_active');
				echo $this->Form->input('parent_id',array('type' => 'hidden'));        
			   ?>
			</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>