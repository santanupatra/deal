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
                
                
                <div class="input select required">
                        <label for="ProductUserId">Seller Name</label>
                        
                        <select name="data[Coupon][user_id]" required="required" onclick="fetchshop(this.value)">
                            <option value="">--select--</option>
                            <?php foreach ($users as $user) { ?>

                                        <option value="<?php echo $user['User']['id']; ?>" <?php if($this->request->data['Coupon']['user_id']==$user['User']['id']){echo 'selected';}?>><?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></option>
                                            

                                    <?php  } ?>
                        </select>
                        
                    </div>
                    
                    
                    <div class="input select required">
                        <label for="ProductUserId">Shop</label>
                        
                        <select name="data[Coupon][shop_id]" id="shop">
                            <option value="">--select--</option>
                            
                        </select>
                        
                    </div>
                
                <?php echo $this->Form->input('hid_shop_id',array('type'=>'hidden','value'=>$this->request->data['Coupon']['shop_id'])); ?>
                
                
            <?php
                echo $this->Form->input('id');
                echo $this->Form->input('name',array('required'=>'required','label'=>'Coupon Name'));
            ?>
<!--                <div class="input text">
                    <label for="CouponCouponType">Coupon Type</label>
                    <select name="data[Coupon][type]" id="CouponCouponType" required="required">
                        <option value="">Select Coupon Type</option>
                        <option value="1" <?php if($this->request->data['Coupon']['type']==1){ echo 'selected="selected"';}?>>Amount</option>
                        <option value="2" <?php if($this->request->data['Coupon']['type']==2){ echo 'selected="selected"';}?>>Percentage</option>
                    </select>
                </div>-->
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
<script>
   
    function fetchshop(id) {
        
        //alert(id);
        
            $.ajax({
                url: '<?php echo $this->request->webroot; ?>admin/products/fetchshop', 
                cache: false,
                data: { seller_id: id},
                type: 'post',
                success: function (response) {
                    console.log(response);
                    var obj = jQuery.parseJSON(response);

                    if (obj.Ack == 1) {
                       
                        html ="";
                        for (var i = 0; i < obj.data.length; i++) {
                            
                          
                           html= html+"<option value='"+obj.data[i].Shop['id']+"'>"+obj.data[i].Shop['name']+"</option>";
                           
                        }
                        
                      $('#shop').html(html); 
                    }
                },
                error: function (response) {
                    $('#msg').html(response); // display error response from the PHP script
                }
            });
        }

</script>
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