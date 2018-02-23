
<section class="pt-5 pb-5">
          <div class="container">
              <div class="row">
                 <?php if($userdetails['User']['type']=='V'){ echo ($this->element('vendor_side_menu'));}else{echo ($this->element('user_side_menu'));};?>
                  <div class="col-lg-9 col-12">
                      <div class="right-side p-3">
                          <h2 class="text-pink">Add Shipping Day</h2>
                          <div class="row">
                              <div class="col-lg-7 col-12">
                                                
                                                
                               <?php echo $this->Form->create('ShippingDay'); ?>

                                                   
                                 <fieldset>
				

				<?php
                                
					
	echo $this->Form->input('ship_name',array('required'=>'required','label'=>'Ship name','class'=>'form-control'));
	echo $this->Form->input('ship_day',array('required'=>'required','label'=>'Ship Day','class'=>'form-control'));
        echo $this->Form->input('ship_charge',array('required'=>'required','label'=>'Shipping Charges','class'=>'form-control'));
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




