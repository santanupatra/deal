<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit State / Province'); ?></div>
			</div>
			<div class="users form">
			<?php echo $this->Form->create('State'); ?>
				<fieldset>
				<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name',array('required'=>'required'));
				?>
				 &nbsp;&nbsp;Country<br>
				     &nbsp;&nbsp;<select name="data[State][country_id]" id="country_id" required style="width:60%;font-size:14px">
					 <option value="">Select Country</option>
					 <?php foreach($allcountries as $allcountry){ ?>
					  <option value="<?php echo $allcountry['Country']['id'];?>" <?php if($this->request->data['State']['country_id']==$allcountry['Country']['id']){
					  echo 'selected';}?>><?php echo $allcountry['Country']['name'];?></option>
					 <?php } ?>
				 </select>
				<?php
					echo $this->Form->input('is_active');
				?>
				
				</fieldset>
				
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
