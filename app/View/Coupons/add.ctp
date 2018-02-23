<?php ?>
<section class="pt-5 pb-5">
          <div class="container">
              <div class="row">
                 <?php if($userdetails['User']['type']=='V'){ echo ($this->element('vendor_side_menu'));}else{echo ($this->element('user_side_menu'));};?>
                  <div class="col-lg-9 col-12">
                      <div class="right-side p-3">
                          <h2 class="text-pink">Add Coupons</h2>
                          <div class="row">
                              <div class="col-lg-7 col-12">
                                                
                                                
                                                <?php echo $this->Form->create('Coupon',array('onsubmit'=>'check_validate();','class'=>'form-horizontal')); ?>
                                                    <div class="form-group">
                                                        <label>Coupon Name:</label>
                                                        <div>
                                                        
                                                            <?php  echo $this->Form->input('name',array('required'=>'required','label'=>false,'class'=>'form-control')); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Coupon Code:</label>
                                                        <div>
                                                        
                                                            <?php  echo $this->Form->input('coupon_code',array('required'=>'required','label'=>false,'class'=>'form-control')); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Products:</label>
                                                        <div>
                                                            <select name="data[Coupon][valid]" id="CouponProducts" class="form-control" required="required">
                                                                <option value="">Select Product</option>
                                                                <option value="1">All</option>
                                                                <?php
                                                                if(isset($PrdList) && count($PrdList)>0){
                                                                    foreach($PrdList as $key => $val){
                                                                        echo '<option value="'.$key.'"> '.$val.' </option>';
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>%age off:</label>
                                                            <div>
                                                              
                                                              <?php echo $this->Form->input('amount',array('required'=>'required','label'=>false,'class'=>'form-control'));?>
                                                            </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Start Date:</label>
                                                            <div>
                                                             
                                                              <?php echo $this->Form->input('from_date',array('required'=>'required','label'=>false,'class'=>'form-control','id'=>'fromDate','type'=>'text')); ?>
                                                            </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Expiry Date:</label>
                                                            <div>
                                                            
                                                              <?php echo $this->Form->input('to_date',array('required'=>'required', 'id'=>'toDate','type'=>'text','label'=>false,'class'=>'form-control')); ?>
                                                            </div>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-4 col-sm-6">
                                                            <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                                                        </div>
                                                    </div>

                                            <?php //echo $this->Form->end(__('Submit')); ?>
                                            </form>
                                        </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </section>
<style>
   .form-horizontal .control-label {
	text-align: left;
    }
</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 

<script type="text/javascript">
    function check_validate(){
        var CouponAmount=$('#CouponAmount').val();
        var float= /^\s*(\+|-)?((\d+(\.\d+)?)|(\.\d+))\s*$/;
        if(float.test(CouponAmount)==false){
            alert('Enter value must be float or int.');
            $("#CouponAmount").css('border', '1px solid #ff0000');
            $("#CouponAmount").focus();
            return false;
        }else{
            return true;
        }
    }
    
    $(document).ready(function(){
        var dateToday = new Date();
        $( "#fromDate" ).datepicker({ 
            dateFormat: 'yy-mm-dd',
            //changeMonth: true,
            //changeYear: true,
            minDate: dateToday,
            onSelect: function (date, el) {
                $("#toDate").datepicker( "option", "minDate", date );
                //$("endDatePicker").datepicker( "option", "maxDate", '+2y' );
            },
            yearRange: "-150:+1"
        });
        
        $( "#toDate" ).datepicker({ 
            dateFormat: 'yy-mm-dd',
            yearRange: "-150:+1"
        });
    });
</script>