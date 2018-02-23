
<section class="pt-5 pb-5">
          <div class="container">
              <div class="row">
                 <?php if($userdetails['User']['type']=='V'){ echo ($this->element('vendor_side_menu'));}else{echo ($this->element('user_side_menu'));};?>
                  <div class="col-lg-9 col-12">
                      <div class="right-side p-3">
                          <h2 class="text-pink">Edit Shipping Day</h2>
                          <div class="row">
                              <div class="col-lg-7 col-12">
                                                
                                                
                               <?php echo $this->Form->create('ShippingDay'); ?>

                                                   
                                 <fieldset>
				

				<?php
                                
	echo $this->Form->input('id',array('type'=>'hidden','value'=>$this->request->data['ShippingDay']['id']));				
	echo $this->Form->input('ship_name',array('required'=>'required','label'=>'Ship name','class'=>'form-control','value'=>$this->request->data['ShippingDay']['ship_name']));
	echo $this->Form->input('ship_day',array('required'=>'required','label'=>'Ship Day','class'=>'form-control','value'=>$this->request->data['ShippingDay']['ship_day']));
        echo $this->Form->input('ship_charge',array('required'=>'required','label'=>'Shipping Charges','class'=>'form-control','value'=>$this->request->data['ShippingDay']['ship_charge']));
                                ?>
					
				</fieldset>
                                  <br>
                                                  
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-6">
                                <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            </div>
                        </div>

                                            <?php //echo $this->Form->end(__('Submit')); ?>
                                            
                                   </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </section>




