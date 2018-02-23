<?php
#pr($this->request->data);
?>
<?php echo $this->Html->script('ckeditor/ckeditor');?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Skill Offering Availability'); ?></div>
			</div>
			<div class="users form">
			<?php echo $this->Form->create('Content'); ?> 
				<fieldset>
				<?php
					echo $this->Form->input('id',array('value'=>$this->request->data['SiteSetting']['id']));
					echo $this->Form->input('skill_studio_heading',array('required'=>'required','value'=>$this->request->data['SiteSetting']['skill_studio_heading']));
					echo $this->Form->input('skill_studio_description',array('required'=>'required','class'=>'ckeditor','type'=>'textarea','value'=>$this->request->data['SiteSetting']['skill_studio_description']));
					echo $this->Form->input('skill_studio_field1',array('required'=>'required','value'=>$this->request->data['SiteSetting']['skill_studio_field1']));
                                        echo $this->Form->input('skill_studio_field2',array('required'=>'required','value'=>$this->request->data['SiteSetting']['skill_studio_field2']));
                                        echo $this->Form->input('skill_studio_field3',array('required'=>'required','value'=>$this->request->data['SiteSetting']['skill_studio_field3']));
                                        echo $this->Form->input('skill_studio_field4',array('required'=>'required','value'=>$this->request->data['SiteSetting']['skill_studio_field4']));
                                        echo $this->Form->input('skill_studio_field5',array('required'=>'required','value'=>$this->request->data['SiteSetting']['skill_studio_field5']));
                                        echo $this->Form->input('skill_studio_field6',array('required'=>'required','value'=>$this->request->data['SiteSetting']['skill_studio_field6']));
                                        echo $this->Form->input('skill_studio_field7',array('required'=>'required','value'=>$this->request->data['SiteSetting']['skill_studio_field7']));
				?>
				</fieldset>
				
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
