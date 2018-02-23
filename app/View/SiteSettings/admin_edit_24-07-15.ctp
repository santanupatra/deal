<?php echo $this->Html->script('ckeditor/ckeditor');?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Site Setting'); ?></div>
			</div>
			<div class="users form">
			<?php echo $this->Form->create('SiteSetting',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
				
				
				<?php
					echo $this->Form->input('id');
                    
				?>
                
				<?php
				    #echo $this->Form->input('paypal_email',array('required'=>'required','type'=>'email'));
                                    #echo $this->Form->input('paypal_developer_email',array('required'=>'required','type'=>'email'));
                                    #echo $this->Form->input('paypal_app_id',array('required'=>'required','type'=>'text','label'=>'Paypal App Id'));
                                    #echo $this->Form->input('paypal_api_username',array('required'=>'required'));
                                    #echo $this->Form->input('paypal_api_password',array('required'=>'required'));
                                    #echo $this->Form->input('paypal_api_signature',array('required'=>'required'));
                                    echo $this->Form->input('admin_email',array('required'=>'required','type'=>'email','label'=>'Contact Email'));
                                    echo $this->Form->input('phone',array('required'=>'required'));
                                    echo $this->Form->input('mobile',array('required'=>'required'));
                                    echo $this->Form->input('address',array('required'=>'required'));
				?>
				</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
