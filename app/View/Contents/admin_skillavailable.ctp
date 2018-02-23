<?php
#pr($this->request->data);
?>
<?php echo $this->Html->script('ckeditor/ckeditor');?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Skill Cost Availability'); ?></div>
			</div>
			<div class="users form">
			<?php echo $this->Form->create('Content'); ?>
				<fieldset>
				<?php
					echo $this->Form->input('id',array('value'=>$this->request->data['SiteSetting']['id']));
					echo $this->Form->input('skill_availability_heading',array('required'=>'required','value'=>$this->request->data['SiteSetting']['skill_availability_heading']));
					echo $this->Form->input('skill_availability_description',array('required'=>'required','class'=>'ckeditor','type'=>'textarea','value'=>$this->request->data['SiteSetting']['skill_availability_description']));
					echo $this->Form->input('skill_availability_field1',array('required'=>'required','value'=>$this->request->data['SiteSetting']['skill_availability_field1']));
                    echo $this->Form->input('skill_availability_field2',array('required'=>'required','value'=>$this->request->data['SiteSetting']['skill_availability_field2']));
                    echo $this->Form->input('skill_availability_field3',array('required'=>'required','value'=>$this->request->data['SiteSetting']['skill_availability_field3']));
                    echo $this->Form->input('skill_availability_field4',array('required'=>'required','value'=>$this->request->data['SiteSetting']['skill_availability_field4']));
					echo $this->Form->input('skill_availability_field5',array('required'=>'required','value'=>$this->request->data['SiteSetting']['skill_availability_field5']));
					echo $this->Form->input('skill_availability_field6',array('required'=>'required','value'=>$this->request->data['SiteSetting']['skill_availability_field6']));
					echo $this->Form->input('skill_availability_field7',array('required'=>'required','value'=>$this->request->data['SiteSetting']['skill_availability_field7']));
					echo $this->Form->input('skill_availability_field8',array('required'=>'required','value'=>$this->request->data['SiteSetting']['skill_availability_field8']));
					#echo $this->Form->input('skill_availability_field9',array('value'=>$this->request->data['SiteSetting']['skill_availability_field9']));
										                                     				?>
				</fieldset>
				
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
