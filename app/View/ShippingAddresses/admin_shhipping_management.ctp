<?php ?>

<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Add Shipping Day'); ?></div>
			</div>
			<div class="shops form">
			<?php echo $this->Form->create('ShippingDay'); ?>
				<fieldset>
				

				<?php
                                
					
	echo $this->Form->input('ship_name',array('required'=>'required','label'=>'Ship name'));
	echo $this->Form->input('ship_day',array('required'=>'required','label'=>'Ship Day'));
        echo $this->Form->input('ship_charge',array('required'=>'required','label'=>'Shipping Charges'));
        
        
					
				?>
				   
					
					
				</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>


        