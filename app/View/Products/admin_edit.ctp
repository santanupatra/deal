
<div class="span9" id="content">
    <div class="row-fluid">
        <!-- block -->
        <div class="block">
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left"><?php echo __('Edit Product'); ?></div>
            </div>
            <div class="users form">
<?php echo $this->Form->create('Product', array('enctype' => 'multipart/form-data')); ?>
                <fieldset>
                    
                    
                    <div class="input select required">
                        <label for="ProductUserId">Seller Name</label>
                        
                        <select name="data[Product][user_id]" required="required" onclick="fetchshop(this.value)">
                            <option value="">--select--</option>
                            <?php foreach ($users as $user) { ?>

                                        <option value="<?php echo $user['User']['id']; ?>" <?php if($this->request->data['Product']['user_id']==$user['User']['id']){echo 'selected';}?>><?php echo $user['User']['first_name'].' '.$user['User']['last_name']; ?></option>
                                            

                                    <?php  } ?>
                        </select>
                        
                    </div>
                    
                    
                    <div class="input select">
                        <label for="ProductUserId">Shop</label>
                        
                        <select name="data[Product][shop_id]" id="shop">
                            <option value="">--select--</option>
                            
                        </select>
                        
                    </div>
                    
                    <?php echo $this->Form->input('hid_shop_id',array('type'=>'hidden','value'=>$this->request->data['Product']['shop_id'])); ?>
                    
<?php
echo $this->Form->input('id');

echo $this->Form->input('name', array('required' => 'required','label'=>'Deal Name'));

?>
                    

                    <div class="input select 11">
                        <label for="ShopCategories">Categories</label>
                        <select id="ShopCategories" required="required" name="data[Product][category_id]">
                            <option value="">Select Category--</option>
                            <?php
                            
                                foreach ($categories as $c1 => $category) {
                                    ?>

                                        <option value="<?php echo $category['Category']['id']; ?>" <?php if ($category['Category']['id'] == $this->request->data['Product']['category_id']) {
                                    echo "selected";
                                } ?>><?php echo $category['Category']['name']; ?></value>
                                            
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

                                        <option value="<?php echo $city['City']['id']; ?>" <?php if($city['City']['id'] == $this->request->data['Product']['city_id']){echo "selected";}?>><?php echo $city['City']['name']; ?></option>
                                            

                                    <?php
                                    }
                                
                                ?>
                        </select>

                    </div> 
                    
                    
                    


                  <?php
                  echo $this->Form->input('hid_img',array('type'=>'hidden','value'=>$this->request->data['Product']['product_image']));
                  echo $this->Form->input('product_image',array('type'=>'file'));
                  
                        if(isset( $this->request->data['Product']['product_image']) and !empty( $this->request->data['Product']['product_image']))
                    {
                    ?>
                    <img alt="" src="<?php echo $this->webroot;?>product_images/<?php echo $this->request->data['Product']['product_image'];?>" style=" height:80px; width:80px;">
                    <?php
                    }
                    else{
                    ?>
                   <img alt="" src="<?php echo $this->webroot;?>category_images/default.png" style=" height:80px; width:80px;">

                    <?php } ?> 


            <?php

            echo $this->Form->input('price_lot', array('required' => 'required', 'label' => 'Price'));
            echo $this->Form->input('discount', array('required' => 'required', 'label' => 'discount'));
            ?>




            <?php
            echo $this->Form->input('item_description', array('label' => 'Item Description', 'class' => 'ckeditor'));

            
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



<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
<script type="text/javascript">
    CKEDITOR.config.toolbar = 'Custom_medium';
    CKEDITOR.config.height = '200';
    CKEDITOR.replace('PagePDesc');
</script>

<style>
    .datetime select {
    width: 122px;
    background-color: #fff;
    border: 1px solid #ccc;
}
    
</style>



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