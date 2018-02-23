<div class="span9" id="content">
    <div class="row-fluid">
		<!-- block -->
        <div class="block">
            <div class="navbar navbar-inner block-header">
                    <div class="muted pull-left"><?php echo __('Edit Coupon'); ?></div>
            </div>
            
            
            <div class="users form">
            <?php echo $this->Form->create('Coupon',array('onsubmit'=>'check_validate();')); ?>
            <fieldset>
            <?php
                echo $this->Form->input('id');
                echo $this->Form->input('coupon_code',array('required'=>'required'));
            ?>
                <div class="input text">
                    <label for="CouponCouponType">Coupon Type</label>
                    <select name="data[Coupon][type]" id="CouponCouponType" required="required">
                        <option value="">Select Coupon Type</option>
                        <option value="1" <?php if($this->request->data['Coupon']['type']==1){ echo 'selected="selected"';}?>>Amount</option>
                        <option value="2" <?php if($this->request->data['Coupon']['type']==2){ echo 'selected="selected"';}?>>Percentage</option>
                    </select>
                </div>
            <?php    
                //echo $this->Form->input('type',array('required'=>'required'));
                echo $this->Form->input('amount',array('required'=>'required'));
                echo $this->Form->input('from_date',array('required'=>'required','id'=>'fromDate','type'=>'text','label'=>'Start Date'));
                echo $this->Form->input('to_date',array('required'=>'required','id'=>'toDate','type'=>'text','label'=>'Expiry Date'));
                echo $this->Form->input('is_active');
            ?>
            </fieldset>
            <?php echo $this->Form->end(__('Submit')); ?>
            </div>
            
        </div>
    </div>
</div>

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
                var selectedDate = new Date(date);
                var msecsInADay = 86400000;
                var endDate = new Date(selectedDate.getTime() + msecsInADay);
                $("#toDate").datepicker( "option", "minDate", endDate );
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