<?php ?>
<section class="after_login pt-5 pb-5">
    <div class="container">
        <div class="row">
            <?php
            if ($userdetails['User']['type'] == 'V') {
                echo ($this->element('vendor_side_menu'));
            } else {
                echo ($this->element('user_side_menu'));
            };
            ?>
            <div class="col-md-9">
                <div class="right-side p-3">
                    <div class="product_title">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-pink">Edit Coupon</h2>
                            </div>
                            <div class="col-md-12">
                                <div class="dash_middle_sec sequirity_info">
                                    <!--<h4>Manage Shop</h4>--><br/>
                                    <!--<form class="form-horizontal" method="post" action="<?php echo $this->webroot . 'products/add_product'; ?>" enctype="multipart/form-data">-->
<?php echo $this->Form->create('Coupon', array('onsubmit' => 'check_validate();', 'class' => 'form-horizontal')); ?>
<?php echo $this->Form->input('id'); ?>



                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Shop</label>
                                        <div class="col-sm-6">
                                            <select name="data[Coupon][shop_id]" class="form-control" required="required">
                                                <option value="">--select--</option>
                                                <?php foreach ($shops as $shop) { ?>
                                                    <option value="<?php echo $shop['Shop']['id'] ?>" <?php
                                                            if ($this->request->data['Coupon']['shop_id'] == $shop['Shop']['id']) {
                                                                echo 'selected';
                                                            }
                                                            ?>><?php echo $shop['Shop']['name'] ?></option>
<?php } ?>
                                            </select>
                                        </div>
                                    </div>


                                    

                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Categories</label>
                                        <div class="col-sm-6">
                                            <select class="form-control" id="ShopCategories" required="required" name="data[Coupon][category_id]">
                                                <option value="">Select Category--</option>
                                                <?php
                                                foreach ($categories as $category) {
                                                    ?>

                                                    <option value="<?php echo $category['Category']['id'] ?>" <?php
                                                    if ($this->request->data['Coupon']['category_id'] == $category['Category']['id']) {
                                                        echo 'selected';
                                                    }
                                                    ?>><?php echo $category['Category']['name'] ?></option>


    <?php
}
?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">City/Location</label>
                                        <div class="col-sm-6">
                                        <select class="form-control" required="required" name="data[Coupon][city_id]">
                                            <option value="">Select--</option>
<?php
foreach ($cities as $city) {
    ?>

                                                <option value="<?php echo $city['City']['id']; ?>" <?php if ($city['City']['id'] == $this->request->data['Coupon']['city_id']) {
                                                echo "selected";
                                            } ?>><?php echo $city['City']['name']; ?></option>


    <?php
}
?>
                                        </select>
                                        </div>

                                    </div> 



                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Coupon Name:</label>
                                        <div class="col-sm-6">

<?php echo $this->Form->input('name', array('required' => 'required', 'label' => false, 'class' => 'form-control')); ?>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    
                                    <div class="form-group row">
                                          <label class="col-sm-4 control-label">Description</label>
                                          <div class="col-sm-6">
                                          <textarea class="form-control ckeditor" name="data[Coupon][description]"  placeholder="Description here"><?php echo $this->request->data['Coupon']['description'];?></textarea>
                                          </div>
                                      </div>



                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Coupon Price:</label>
                                        <div class="col-sm-6">

                                            <?php echo $this->Form->input('amount', array('required' => 'required', 'label' => false, 'class' => 'form-control')); ?>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Coupon Offer:</label>
                                        <div class="col-sm-6">

                                            <?php echo $this->Form->input('offer', array('required' => 'required', 'label' => false, 'class' => 'form-control')); ?>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Start Date:</label>
                                        <div class="col-sm-6">

                                            <?php echo $this->Form->input('from_date', array('required' => 'required', 'label' => false, 'class' => 'form-control', 'id' => 'fromDate', 'type' => 'text')); ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label  class="col-sm-4 control-label">Expiry Date:</label>
                                        <div class="col-sm-6">

<?php echo $this->Form->input('to_date', array('required' => 'required', 'id' => 'toDate', 'type' => 'text', 'label' => false, 'class' => 'form-control')); ?>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-4 control-label">Type of Uses</label>
                                        <div class="col-sm-6">

                                            <input type="radio" name="data[Coupon][type]"  value="O" <?php if ($this->request->data['Coupon']['type'] == 'O') {
    echo "checked";
} ?>>Online Use
                                            <input type="radio" name="data[Coupon][type]" value="S"   <?php if ($this->request->data['Coupon']['type'] == 'S') {
    echo "checked";
} ?>>Store Use
                                        </div>
                                    </div>

                                    


                                    <div class="form-group row">
                                        <div class="col-sm-offset-4 col-sm-6">
                                            <button type="submit" class="btn btn-primary active">Submit</button>
                                        </div>
                                    </div>

<?php //echo $this->Form->end(__('Submit'));   ?>
                                    </form>
                                </div>
                            </div>
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

