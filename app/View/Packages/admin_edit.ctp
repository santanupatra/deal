<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
                            <div class="muted pull-left"><?php echo __('Edit Package'); ?></div>
			</div>
			<div class="users form">
			<?php echo $this->Form->create('Package',array('enctype'=>'multipart/form-data')); ?>
                            <fieldset>
				<?php
                                    echo $this->Form->input('id');
                                    echo $this->Form->input('name',array('required'=>'required'));
                                    echo $this->Form->input('duration',array('required'=>'required','label'=>'Duration (months)','placeholder'=>'Enter no of month.'));
                                    echo $this->Form->input('price',array('required'=>'required','type'=>'number'));
				?>
				<div class="input checkbox">
                                    <input id="UserIsActive_" type="hidden" value="0" name="data[Package][status]">
                                    <input id="UserIsActive" type="checkbox" value="1" name="data[Package][status]" <?php if(isset($this->request->data['Package']['status']) && $this->request->data['Package']['status']==1){echo 'checked';}?>>
                                    <label for="UserIsActive">Is Active</label>
                                </div>
                            </fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
