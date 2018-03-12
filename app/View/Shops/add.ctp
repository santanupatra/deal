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
                          <h2 class="text-pink">Add New Shop</h2>
                          <div class="row">
                              <div class="col-lg-7 col-12">
                                  <form class="form-area" method="post" action="<?php echo $this->webroot; ?>shops/add" id="frmEdit" enctype="multipart/form-data">
                                      
                                      
                                      <input type="hidden" name="data[Shop][user_id]" value="<?php echo $user['User']['id'];?>">
                                      
                                      <div class="form-group">
                                          <label>Shop Name</label>
                                          <input type="text" class="form-control" required="" name="data[Shop][name]"  placeholder="Shop name here">
                                      </div>
                                      
                                      
                                      <div class="form-group">
                                          <label>Description</label>
                                          <textarea class="form-control ckeditor" name="data[Shop][description]"  placeholder="Description here"></textarea>
                                      </div>
                                      
                                      
                                      
                                      
                                      
                                      <div class="form-group">
                                          <label>Shop Image</label>
                                          <input type="file" class="form-control" name="data[Shop][logo]" required="">
                                      </div>
                                      
                                      
                                      
                                      
                                      <?php 
                                      
                                      echo $this->Form->input('is_active',array('required'=>'required','options'=>$status,'empty'=>'Select','class'=>'form-control','name'=>'data[Shop][is_active]'));
                                      ?>
<br>

                                      <div class="form-group">
                                          <button type="submit" class="btn btn-lg btn-primary">Save Shop</button>
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
  

