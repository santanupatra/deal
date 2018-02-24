<?php ?>

<div class="span9" id="content">
    <div class="row-fluid">
        <!-- block -->
        <div class="block">
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left"><?php echo __('Add Deal'); ?></div>
            </div>
            



            <div class="users form">
<?php echo $this->Form->create('Product', array('enctype' => 'multipart/form-data')); ?>
                <fieldset>
                    <div class="input select required">
                        <label for="ProductUserId">Seller Name</label>
                        
                        <select name="data[Product][user_id]" required="required" onclick="fetchshop(this.value)">
                            <option value="">--select--</option>
                            <?php foreach ($users as $user) { ?>

                                        <option value="<?php echo $user['User']['id']; ?>"><?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></option>
                                            

                                    <?php  } ?>
                        </select>
                        
                    </div>
                    
                    
                    <div class="input select required">
                        <label for="ProductUserId">Shop</label>
                        
                        <select name="data[Product][shop_id]" id="shop" required="required">
                            <option value="">--select--</option>
                            
                        </select>
                        
                    </div>
                    
                    
                    
                    
                    
                    <?php
                        echo $this->Form->input('name', array('label' => 'Deal name', 'required' => 'required'));
                    ?>
                    <div class="input select">
                        <label for="ShopCategories">Categories</label>
                        <select id="ShopCategories" required="required" name="data[Product][category_id]">
                            <option value="">Select Category--</option>
                                <?php
                                    
                                        foreach ($categories as $category) {
                                ?>

                                        <option value="<?php echo $category['Category']['id']; ?>"><?php echo $category['Category']['name']; ?></option>
                                            

                                    <?php
                                    }
                                
                                ?>
                        </select>

                    </div>


                     <div class="input select">
                        <label>City/Location</label>
                        <select  required="required" name="data[Product][city_id]">
                            <option value="">Select--</option>
                                <?php
                                    
                                        foreach ($cities as $city) {
                                ?>

                                        <option value="<?php echo $city['City']['id']; ?>"><?php echo $city['City']['name']; ?></option>
                                            

                                    <?php
                                    }
                                
                                ?>
                        </select>

                    </div>                  

                    

                    <?php  
                    
                    
                    echo $this->Form->input('product_image',array('required'=>'required','type'=>'file'));
                    
                    echo $this->Form->input('price_lot', array('label' => 'Price'));
                    echo $this->Form->input('discount', array('label' => 'Discount Price'));
                    ?>

                   
                    <?php
                    echo $this->Form->input('item_description', array('label' => 'Deal Description', 'class' => 'ckeditor'));                    
                    ?>
                    
                    <?php
                    
                    echo $this->Form->input('start_date');
                    echo $this->Form->input('end_date');
                    ?>
                    
    

                    <?php

                    echo $this->Form->input('status', array('required' => 'required', 'options' => $status, 'empty' => 'Select'));
                    ?>

                </fieldset>

                    <?php echo $this->Form->end(__('Submit')); ?>
            </div>
        </div>
    </div>
</div>

<!--Variation Modal-->
<style>
    .datetime select {
    width: 122px;
    background-color: #fff;
    border: 1px solid #ccc;
}
    
</style>


<!--Variation Modal end-->

<script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
        </script>
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


<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
<script type="text/javascript">
    CKEDITOR.config.toolbar = 'Custom_medium';
    CKEDITOR.config.height = '200';
    CKEDITOR.replace('PagePDesc');
</script>



<script type="text/javascript" src="<?php echo ($this->webroot); ?>js/ajaxupload.3.5.js"></script>
<style media="screen">
  .modal-header .close{
    position: absolute;
    right: 15px;
    top: 15px;
  }
  .mb-0{
    margin-bottom: 0 !important;
  }
</style>


 
  
 
  
  
  
  