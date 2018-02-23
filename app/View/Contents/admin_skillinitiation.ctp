<?php
#pr($this->request->data);
?>
<?php echo $this->Html->script('ckeditor/ckeditor');?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Skill Initiation'); ?></div>
			</div>
			<div class="users form">
			<?php echo $this->Form->create('Content'); ?>
				<fieldset>
				<?php
					echo $this->Form->input('id',array('value'=>$this->request->data['SiteSetting']['id']));
					echo $this->Form->input('initiation_heading',array('required'=>'required','value'=>$this->request->data['SiteSetting']['initiation_heading']));
					echo $this->Form->input('initiation_field1',array('required'=>'required','value'=>$this->request->data['SiteSetting']['initiation_field1']));
                                        echo $this->Form->input('initiation_field2',array('required'=>'required','value'=>$this->request->data['SiteSetting']['initiation_field2']));
				?>
				</fieldset>
				
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
