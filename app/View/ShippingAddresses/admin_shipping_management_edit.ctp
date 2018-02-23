<?php ?>

<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Shipping Day'); ?></div>
			</div>
			<div class="shops form">
			<?php echo $this->Form->create('ShippingDay',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
				

				<?php
                                
	echo $this->Form->input('id',array('type'=>'hidden','value'=>$this->request->data['ShippingDay']['id']));				
	echo $this->Form->input('ship_name',array('required'=>'required','label'=>'Ship Name','value'=>$this->request->data['ShippingDay']['ship_name']));
	echo $this->Form->input('ship_day',array('required'=>'required','label'=>'Ship Day','value'=>$this->request->data['ShippingDay']['ship_day']));
        echo $this->Form->input('ship_charge',array('required'=>'required','label'=>'Shipping Charges','value'=>$this->request->data['ShippingDay']['ship_charge']));
        
					
				?>
				   
				

				
                				
					
				</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>


 


       