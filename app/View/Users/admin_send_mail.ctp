<?php ?>

<div class="span9" id="content">
    <div class="row-fluid">
        <!-- block -->
        <div class="block">
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left"><?php echo __('Send mail'); ?></div>
            </div>
            



            <div class="users form">

                <form method="post" href="<?php $this->webroot?>users/admin_send_mail">
                <fieldset>
                    <div class="input select required">
                        <label for="ProductUserId">Seller Name</label>
                        
                        <select  required="required" name="data[EmailSubscriber][email][]" multiple="">
                            <option value="">--select--</option>
                            <?php foreach ($users as $user) { ?>

                                        <option value="<?php echo $user['EmailSubscriber']['email_id']; ?>"><?php echo $user['EmailSubscriber']['email_id']; ?></option>
                                            

                                    <?php  } ?>
                        </select>
                        
                    </div>
                    
                    

                   
                    
                    <div class="input select required">
                        <label>Mail Content</label>
                        
                        <textarea class="ckeditor" name="data[EmailSubscriber][item_description]" ></textarea>
                        
                    </div>
                    

                </fieldset>

                <button type="submit">Send</button>
            </form>
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


 
  
 
  
  
  
  