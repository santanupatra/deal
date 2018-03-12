<?php ?>
<section class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            <?php if ($userdetails['User']['type'] == 'V') {
                echo ($this->element('vendor_side_menu'));
            } else {
                echo ($this->element('user_side_menu'));
            }; ?>
            <div class="col-lg-9 col-12">
                <div class="right-side p-3">
                    <h2 class="text-pink">Add Coupons</h2>
                    <div class="row">
                        <div class="col-lg-7 col-12">


<?php echo $this->Form->create('Coupon', array('class' => 'form-horizontal')); ?>

                            


                            <div class="form-group">
                                <label>Shop</label>

                                <select name="data[Coupon][shop_id]" class="form-control" required="required">
                                    <option value="">--select--</option>
<?php foreach ($shops as $shop) { ?>
                                        <option value="<?php echo $shop['Shop']['id'] ?>"><?php echo $shop['Shop']['name'] ?></option>
<?php } ?>
                                </select>

                            </div>

                            
                            
                            <div class="form-group">
                                          <label>Categories</label>
                                          <select class="form-control" id="ShopCategories" required="required" name="data[Coupon][category_id]">
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
                        <select class="form-control" required="required" name="data[Coupon][city_id]">
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
                                <label>Coupon Name:</label>
                                <div>

<?php echo $this->Form->input('name', array('required' => 'required', 'label' => false, 'class' => 'form-control')); ?>
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                          <label>Description</label>
                                          <textarea class="form-control ckeditor" name="data[Coupon][description]"  placeholder="Description here"></textarea>
                                      </div>


                            <div class="form-group">
                                <label>Coupon Price:</label>
                                <div>

<?php echo $this->Form->input('amount', array('required' => 'required', 'label' => false, 'class' => 'form-control')); ?>
                                </div>
                            </div>
                            
                            
                            
                            <div class="form-group">
                                <label>Coupon Offer:</label>
                                <div>

<?php echo $this->Form->input('offer', array('required' => 'required', 'label' => false, 'class' => 'form-control')); ?>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label>Start Date:</label>
                                <div>

<?php echo $this->Form->input('from_date', array('required' => 'required', 'label' => false, 'class' => 'form-control', 'id' => 'fromDate', 'type' => 'text')); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Expiry Date:</label>
                                <div>

<?php echo $this->Form->input('to_date', array('required' => 'required', 'id' => 'toDate', 'type' => 'text', 'label' => false, 'class' => 'form-control')); ?>
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label>Type of Uses</label>
                                <div>

                                    <input type="radio" name="data[Coupon][type]"  value="O" checked="">Online Use
                                    <input type="radio" name="data[Coupon][type]"  value="S">Store Use
                                </div>
                            </div>
                            
                            

                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-6">
                                    <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                                </div>
                            </div>

<?php //echo $this->Form->end(__('Submit'));  ?>
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 

<script type="text/javascript">
    function check_validate() {
        var CouponAmount = $('#CouponAmount').val();
        var float = /^\s*(\+|-)?((\d+(\.\d+)?)|(\.\d+))\s*$/;
        if (float.test(CouponAmount) == false) {
            alert('Enter value must be float or int.');
            $("#CouponAmount").css('border', '1px solid #ff0000');
            $("#CouponAmount").focus();
            return false;
        } else {
            return true;
        }
    }






</script>