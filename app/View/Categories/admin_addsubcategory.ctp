<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Add Sub Category of'); ?>&nbsp;<?php echo($categoryname);?></div>
			</div>
			<div class="users form">
            <?php echo $this->Form->create('Category'); ?>
			<fieldset>
			<?php	
			    echo $this->Form->input('name',array('required'=>'required'));
				echo $this->Form->input('is_active');
				echo $this->Form->input('parent_id',array('value' => $id, 'type' => 'hidden'));
			?>
			</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
