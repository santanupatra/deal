
<!--  my account  -->

<section class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            <?php echo ($this->element('vendor_side_menu')); ?>
            <div class="col-lg-9 col-12">
                <div class="right-side p-3">
                    <h2 class="text-pink">Edit Shop</h2>
                    <div class="row">
                        <div class="col-lg-7 col-12">
                            <form class="form-area" method="post" action="<?php echo $this->webroot; ?>shops/edit/<?= $this->request->data['Shop']['id'] ?>" id="frmEdit">


                                <input type="hidden" name="data[Shop][user_id]" value="<?php echo $user['User']['id']; ?>">
                                <input type="hidden" name="data[Shop][id]" value="<?php echo $this->request->data['Shop']['id']; ?>">

                                <div class="form-group">
                                    <label>Shop Name</label>
                                    <input type="text" class="form-control" required="" name="data[Shop][name]" value="<?php echo $this->request->data['Shop']['name'] ?>"  placeholder="Shop name here">
                                </div>

                    

                                 <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control ckeditor" name="data[Shop][description]"  placeholder="Description here"><?php echo $this->request->data['Shop']['description'] ?></textarea>
                                </div>

                                
                                
                                

<input type="hidden" name="data[Shop][hid_img]" value="<?php echo $this->request->data['Shop']['logo'] ?>" > 
                                     

                                
                                 <?php
                  //echo $this->Form->input('hid_img',array('type'=>'hidden','value'=>$this->request->data['Shop']['logo']));
                  echo $this->Form->input('logo',array('type'=>'file','class'=>"form-control"));
                  
                        if(isset( $this->request->data['Shop']['logo']) and !empty( $this->request->data['Shop']['logo']))
                    {
                            
                    ?>
                                
                    <img alt="" src="<?php echo $this->webroot;?>shop_images/<?php echo $this->request->data['Shop']['logo'];?>" style=" height:80px; width:80px;">
                    <?php
                    }
                    else{
                    ?>
                   <img alt="" src="<?php echo $this->webroot;?>shop_images/default.png" style=" height:80px; width:80px;">

                    <?php } ?>

                               
                                
                                
                                 

                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="data[Shop][is_active]">
                                        <option value="1" <?php if ($this->request->data['Shop']['is_active'] == "1") {
                                                echo 'selected';
                                            } ?>>Active</option>
                                        <option value="0" <?php if ($this->request->data['Shop']['is_active'] == "0") {
                                                echo 'selected';
                                            } ?>>Inactive</option>
                                        
                                    </select>
                                </div>


                                <div class="form-group">
                                    <button type="submit" class="btn btn-lg btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!--   footer   -->







<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->


<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
<script type="text/javascript">
    //CKEDITOR.config.toolbar = 'Custom_medium';
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


<script type="text/javascript" src="<?php echo ($this->webroot); ?>js/ajaxupload.3.5.js"></script>  