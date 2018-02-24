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
                
                
                
                
                <div class="input select required">
                                          <label>Categories</label>
                                          <select class="form-control" id="ShopCategories" required="required" name="data[Coupon][category_id]">
                                              <option value="">Select Category--</option>
                                              <?php
                                             
                                                  foreach ($categories as $category) {
                                                      ?>

                            <option value="<?php echo $category['Category']['id'] ?>" <?php if($this->request->data['Coupon']['category_id']==$category['Category']['id']){echo "selected";}?>><?php echo $category['Category']['name'] ?></option>
                                                     <?php
                                                        }
                                                    
                                                    ?>
                                          </select>
                                      </div>
                
                
                
                
                
              <div class="input select">
                        <label>City/Location</label>
                        <select  required="required" name="data[Coupon][city_id]">
                            <option value="">Select--</option>
                                <?php
                                    
                                        foreach ($cities as $city) {
                                ?>

                                        <option value="<?php echo $city['City']['id']; ?>" <?php if($city['City']['id'] == $this->request->data['Coupon']['city_id']){echo "selected";}?>><?php echo $city['City']['name']; ?></option>
                                            

                                    <?php
                                    }
                                
                                ?>
                        </select>

                    </div>   
                
                
                
                
            <?php
                echo $this->Form->input('id');
                echo $this->Form->input('name',array('required'=>'required','label'=>'Coupon Name'));
            ?>
                <div class="input text">
                    <label for="CouponCouponType">Type of Uses</label>
                    <select name="data[Coupon][type]" id="CouponCouponType" required="required">
                        <option value="">Select Type</option>
                        <option value="O" <?php if($this->request->data['Coupon']['type']=='O'){ echo 'selected="selected"';}?>>Online Use</option>
                        <option value="S" <?php if($this->request->data['Coupon']['type']=='S'){ echo 'selected="selected"';}?>>Store Use</option>
                    </select>
                </div>
            <?php    
                //echo $this->Form->input('type',array('required'=>'required'));
                echo $this->Form->input('amount',array('required'=>'required'));
                echo $this->Form->input('offer',array('required'=>'required','label'=>'Coupon Offer'));
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