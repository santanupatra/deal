<style>
        .timepicker .title {
         dispaly: none;   
        }
        </style>

    
    <!--  my account  -->
    
    <section class="pt-5 pb-5">
          <div class="container">
              <div class="row">
                  <?php echo ($this->element('vendor_side_menu'));?>
                  <div class="col-lg-9 col-12">
                      <div class="right-side p-3">
                          <h2 class="text-pink">Add New Deal</h2>
                          <div class="row">
                              <div class="col-lg-7 col-12">
                                  <form class="form-area" method="post" action="<?php echo $this->webroot; ?>products/add" id="frmEdit" enctype="multipart/form-data">
                                      
                                      
                                      <input type="hidden" name="data[Product][user_id]" value="<?php echo $user['User']['id'];?>">
                                      
                                      <div class="form-group">
                                          <label>Deal Name</label>
                                          <input type="text" class="form-control" required="" name="data[Product][name]"  placeholder="Deal name here">
                                      </div>
                                      
                                      
                       <div class="form-group">
                        <label>Shop</label>
                        
                        <select name="data[Product][shop_id]" class="form-control" required="required">
                            <option value="">--select--</option>
                            <?php foreach($shops as $shop){ ?>
                            <option value="<?php echo $shop['Shop']['id']?>"><?php echo $shop['Shop']['name']?></option>
                            <?php } ?>
                        </select>
                        
                    </div>
                                      
                                      
                                      <div class="form-group">
                                          <label>Categories</label>
                                          <select class="form-control" id="ShopCategories" required="required" name="data[Product][category_id]">
                                              <option value="">Select Category--</option>
                                              <?php
                                             
                                                  foreach ($categories as $category) {
                                                      ?>

                            <option value="<?php echo $category['Category']['id'] ?>"><?php echo $category['Category']['name'] ?></option>


                                                        <?php
                                                        }
                                                    
                                                    ?>
                                          </select>
                                      </div>
                                      
                                      
                                       <div class="form-group">
                        <label>City/Location</label>
                        <select class="form-control" required="required" name="data[Product][city_id]">
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
                                      
                                      
                                      
                                      <div class="form-group">
                                          <label>Price</label>
                                          <input type="text" class="form-control" name="data[Product][price_lot]" placeholder="Deal price here" required="">
                                      </div>
                                      

                                      
                                      <div class="form-group">
                                          <label>Discount Price</label>
                                          <input type="text" class="form-control" name="data[Product][discount]" placeholder="Discount price here" required="">
                                      </div>
                                      
                                      
                                      
                                      <div class="form-group">
                                          <label>Deal Image</label>
                                          <input type="file" class="form-control" name="data[Product][product_image]" required="">
                                      </div>
                                      
                                      
                                      
                                      <div class="form-group">
                                          <label>Description</label>
                                          <textarea class="form-control ckeditor" name="data[Product][item_description]"  placeholder="Description here"></textarea>
                                      </div>

                                      <div class="form-group">
                                          <label>Start Date:</label>
                                          <div>

                                              <?php echo $this->Form->input('start_date', array('required' => 'required', 'label' => false, 'class' => 'form-control', 'id' => 'fromDate', 'type' => 'text')); ?>
                                          </div>
                                          
                                          
                                      </div>
                                      <div class="form-group">
                                          <label>Expiry Date:</label>
                                          <div>

                                              <?php echo $this->Form->input('end_date', array('required' => 'required', 'id' => 'toDate', 'type' => 'text', 'label' => false, 'class' => 'form-control')); ?>
                                          </div>
                                          
                                          
                                          
                                      </div>
                                      
                                      
                                      
                                      <?php 
                                      
                                      echo $this->Form->input('status',array('required'=>'required','options'=>$status,'empty'=>'Select','class'=>'form-control','name'=>'data[Product][status]'));
                                      ?>
<br>

                                      <div class="form-group">
                                          <button type="submit" class="btn btn-lg btn-primary">Save Deal</button>
                                      </div>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </section>
    
    
    
    
  
    
    
   
     <?php echo $this->Html->script('ckeditor/ckeditor');?>
 <script type="text/javascript">
       CKEDITOR.config.toolbar = 'MyToolbar';
    CKEDITOR.config.toolbar_MyToolbar = 
      [
         ['Newplugin', 'Preview'],
         ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Scayt'],
         ['Undo', 'Redo', '-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat']
      ];
      CKEDITOR.config.height = '200';
      CKEDITOR.replace('PagePDesc');
  </script> 
  

