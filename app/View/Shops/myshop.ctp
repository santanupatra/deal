<?php 
$SITE_URL = Configure::read('SITE_URL');
$is_close=isset($this->request->data['Shop']['is_close'])?$this->request->data['Shop']['is_close']:'';
$shop_id=isset($this->request->data['Shop']['id'])?$this->request->data['Shop']['id']:'';
?>
<section class="after_login">
    <div class="container">
        <div class="row">
        <?php echo($this->element('user_leftbar'));?>
            <div class="col-md-9">
                <div class="product_title">
                    <div class="row">
                        <div class="col-md-12" style="float:right;">
                            <?php if(isset($this->request->data['Shop']['id']) && $this->request->data['Shop']['id']!=''){
                                if($is_close==1){
                                    $shop_status = $this->requestAction(array('controller' => 'shops', 'action' => 'get_shop_status_check', $shop_id,'admin'=>false, 'prefix' => ''));
                                    if(count($shop_status)>0){
                                        $from_date=date('dS M, Y',strtotime($shop_status['CloseShop']['from_date']));
                                        $to_date=date('dS M, Y',strtotime($shop_status['CloseShop']['to_date']));
                                        echo '<div class="col-md-9"><div class="alert alert-danger"><p class="text-muted">Shop is closed from '.$from_date.' to '.$to_date.'.</p></div></div>';
                                        //echo '<div class="col-md-3" style="padding-right: 0;"><a href="'.$this->webroot.'shops/myshop/"><button class="btn_red pull-right">Open for holiday</button></a></div>';
                            ?>
                            <div class="col-md-3" style="padding-right: 0;"><a href="<?php echo $this->webroot;?>shops/open_for_holiday/<?php echo base64_encode($shop_id);?>" onclick="return confirm('Are you sure?')"><button class="btn_red pull-right">Open for holiday</button></a></div>
                            <?php
                                    }else{
                                        //echo '<button class="btn_red pull-right closed_for_holiday">Closed for holiday</button>';
                                    }
                                }else{
                                    echo '<button class="btn_red pull-right closed_for_holiday">Closed for holiday</button>';
                                }
                                ?>
                            <?php }?>
			</div>
                        <div class="col-md-12">
                          
			       
                            <h3>Manage Shop
                                <?php
                                if(isset($this->request->data['Shop']['id']) && $this->request->data['Shop']['id']!=''){
                                ?>
                                <span style="float:right;"><a class="btn btn-info" href="<?php echo $this->webroot.'shop/'.$this->request->data['Shop']['slug'].'/'.base64_encode($this->request->data['Shop']['id']);?>">View Shop</a></span>
                                <?php } ?>
                            </h3>
                        </div>
                        <div class="col-md-12">
                            <div class="dash_middle_sec sequirity_info">
                                    <!--<h4>Manage Shop</h4>--><br/>
                                    <form class="form-horizontal" method="POST" action="<?php echo($this->webroot)?>shops/myshop" enctype="multipart/form-data">
                                    <input type="hidden" value="<?php if(isset($this->request->data['Shop']['id']) && $this->request->data['Shop']['id']!=''){echo $this->request->data['Shop']['id'];}?>" name="data[Shop][id]">
                                    <input type="hidden" value="<?php if(isset($this->request->data['Shop']['logo']) && $this->request->data['Shop']['logo']!=''){echo $this->request->data['Shop']['logo'];}?>" name="data[Shop][hid_logo]">
                                    <input type="hidden" value="<?php if(isset($this->request->data['Shop']['cover_photo']) && $this->request->data['Shop']['cover_photo']!=''){echo $this->request->data['Shop']['cover_photo'];}?>" name="data[Shop][hid_cover_photo]">
                                      <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Shop Name:</label>
                                        <div class="col-sm-6">
                                          <input type="text" class="form-control" id="name" value="<?php if(isset($this->request->data['Shop']['name']) && $this->request->data['Shop']['name']!=''){echo $this->request->data['Shop']['name'];}?>" name="data[Shop][name]" required>
                                        </div>
                                      </div>
                                    <?php if(isset($this->request->data['Shop']['id']) && $this->request->data['Shop']['id']!=''){?>
                                      <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Shop URL:</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" value="<?php echo $SITE_URL.'shop/'.$this->request->data['Shop']['slug'].'/'.base64_encode($this->request->data['Shop']['id']);?>" readonly="readonly">
                                        </div>
                                      </div>
                                    <?php }?>
                                      <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-4 control-label">Description:</label>
                                        <div class="col-sm-8">
                                          <textarea class="form-control" id="description" name="data[Shop][description]" required><?php if(isset($this->request->data['Shop']['description']) && $this->request->data['Shop']['description']!=''){echo $this->request->data['Shop']['description'];}?></textarea>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-4 control-label">Logo:</label>
                                        <div class="col-sm-8">
                                          <input type="file" id="logo" name="data[Shop][logo]"  placeholder="">
                                          <p class="text-muted">allowed: .jpg, .jpeg, .png or .gif, Size: 400*200</p>
                                        </div>
                                      </div>
                                    <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-4 control-label">&nbsp;</label>
                                            <div class="col-sm-8">
                                            <?php
                                            $uploadPath= Configure::read('UPLOAD_SHOP_LOGO_PATH');
                                            $imageName = $this->request->data['Shop']['logo'];
                                            if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
                                                    echo($this->Html->image('/shop_images/'.$imageName, array('alt' => 'Shop Logo', 'height' => '150', 'width' => '150')));
                                            } 
                                            else {
                                                    echo($this->Html->image('/shop_images/default.png', array('alt' => 'Shop Logo', 'height' => '150', 'width' => '150')));
                                                 }
                                            ?>
                                            </div>
                                    </div>
                                      <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-4 control-label">Cover Photo:</label>
                                        <div class="col-sm-8">
                                          <input type="file" id="cover_photo" name="data[Shop][cover_photo]"  placeholder="">
                                           <p class="text-muted">allowed: .jpg, .jpeg, .png or .gif, Size: 400*200</p>
                                        </div>
                                      </div>
                                    <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-4 control-label">&nbsp;</label>
                                            <div class="col-sm-8">
                                            <?php
                                            $uploadPath= Configure::read('UPLOAD_SHOP_LOGO_PATH');
                                                    $imageName = $this->request->data['Shop']['cover_photo'];
                                                    if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
                                                            echo($this->Html->image('/shop_images/'.$imageName, array('alt' => 'Shop Cover Photo', 'height' => '150', 'width' => '150')));
                                                    } else {
                                                            echo($this->Html->image('/shop_images/default.png', array('alt' => 'Shop Logo', 'height' => '150', 'width' => '150')));
                                                    }
                                            ?>
                                            </div>
                                    </div>
                                      <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-4 control-label">Select Categories:<br/><!--(Press Ctrl + Click to select multiple)--></label>
                                        <div class="col-sm-6">

                                        <?php
                                        $catListUp=$this->request->data['Shop']['categories'];
                                        if(isset($catListUp) && $catListUp!=''){
                                            $sub_cat = explode(',', $catListUp);
                                        }
                                        if(isset($categories) && !empty($categories)){	
                                            foreach($categories as $category){ 
                                        ?>
                                            <div class="col-sm-4"><input type="checkbox" name="data[Shop][categories][]" value="<?php echo $category['Category']['id']?>" <?php if(isset($sub_cat) && count($sub_cat)>0 && in_array($category['Category']['id'], $sub_cat)){ echo 'checked="checked"';}?>> <?php echo $category['Category']['name']?></div>
                                        <?php	
                                            }
                                        }
                                        ?>    
                                            <!--<select name="data[Shop][sub_categories][]" multiple="multiple" class="multiselect" required id="categories" style="height: 150px !important;">
                                                     <option value="">Select Category--</option>
                                                     <?php 
                                                      if(isset($categories) && !empty($categories))
                                                      {	
                                                            foreach($categories as $category)
                                                            { ?>
                                                                       <optgroup label="<?php echo $category['Category']['name']?>">
                                                                                     <?php $subcats = $this->requestAction(array('controller' => 'categories', 'action' => 'getsubcat/'.$category['Category']['id']));
                                                                                                if(!empty($subcats))
                                                                                                {
                                                                                                      foreach($subcats as $subcat)
                                                                                                      {
                                                                                                ?>
                                                                              <option value="<?php echo $subcat['Category']['id'];?>" <?php if(in_array($subcat['Category']['id'], $sub_cat)){ echo 'selected="selected"';}?>><?php echo $subcat['Category']['name'];?></value>
                                                                                     <?php	  }
                                                                                                }
                                                                                     ?>
                                                                       </optgroup>	
                                                     <?php	}
                                                     }
                                                     ?>
                                            </select>-->
                                        </div>
                                      </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Paypal Business Email:</label>
                                        <div class="col-sm-6">
                                          <input type="text" class="form-control" id="name" value="<?php if(isset($this->request->data['User']['paypal_business_email']) && $this->request->data['User']['paypal_business_email']!=''){echo $this->request->data['User']['paypal_business_email'];}?>" name="data[User][paypal_business_email]" required>
                                        </div>
                                    </div>

                                      <!--<div class="form-group">
                                        <label for="inputPassword3" class="col-sm-4 control-label">Social Media Linked Accounts:</label>
                                        <div class="col-sm-6">
                                          <div class="social_box">
                                              <span><i class="fa fa-facebook"></i><b>Facebook</b><a class="fa fa-close"></a></span>

                                              <span><i class="fa fa-twitter"></i><b>Twitter</b><a class="fa fa-close"></a></span>

                                              <span><i class="fa fa-pinterest"></i><b>Pintrest</b><a class="fa fa-close"></a></span>

                                              <span><i class="fa fa-vk"></i><b>VK</b><a class="fa fa-close"></a></span>
                                          </div>

                                        </div>
                                      </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Facebook Page:</label>
                                        <div class="col-sm-6">
                                          <input type="text" class="form-control" id="facebook" value="<?php if(isset($this->request->data['Shop']['facebook']) && $this->request->data['Shop']['facebook']!=''){echo $this->request->data['Shop']['facebook'];}?>" name="data[Shop][facebook]" >
                                        </div>
                                      </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Twitter Page:</label>
                                        <div class="col-sm-6">
                                          <input type="text" class="form-control" id="facebook" value="<?php if(isset($this->request->data['Shop']['twitter']) && $this->request->data['Shop']['twitter']!=''){echo $this->request->data['Shop']['twitter'];}?>" name="data[Shop][twitter]" >
                                        </div>
                                      </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Linkedin Page:</label>
                                        <div class="col-sm-6">
                                          <input type="text" class="form-control" id="Linkedin" value="<?php if(isset($this->request->data['Shop']['linkedin']) && $this->request->data['Shop']['linkedin']!=''){echo $this->request->data['Shop']['linkedin'];}?>" name="data[Shop][linkedin]" >
                                        </div>
                                      </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Pinterest:</label>
                                        <div class="col-sm-6">
                                          <input type="text" class="form-control" id="pinterest" value="<?php if(isset($this->request->data['Shop']['pinterest']) && $this->request->data['Shop']['pinterest']!=''){echo $this->request->data['Shop']['pinterest'];}?>" name="data[Shop][pinterest]" >
                                        </div>
                                      </div>


                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Youtube:</label>
                                        <div class="col-sm-6">
                                          <input type="text" class="form-control" id="youtube" value="<?php if(isset($this->request->data['Shop']['youtube']) && $this->request->data['Shop']['youtube']!=''){echo $this->request->data['Shop']['youtube'];}?>" name="data[Shop][youtube]" >
                                        </div>
                                      </div>-->
                                      <?php 
                                      if(isset($this->request->data['Shop']['id']) && $this->request->data['Shop']['id']!=''){
                                          if(isset($get_paid_shop) && count($get_paid_shop)>0 && date('Y-m-d H:i:s')>$get_paid_shop['FeaturedShop']['end_date']){
                                          ?>
                                      <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-4 control-label">Feature shop:</label>
                                        <div class="col-sm-8">
                                            <input type="checkbox" name="data[Shop][is_featured]" value="1">
                                        </div>
                                      </div>
                                      <?php }elseif(isset($get_free_shop) && count($get_paid_shop)==0 && count($get_free_shop)>0 && date('Y-m-d H:i:s')>$get_free_shop['FeaturedShop']['end_date']){
                                          ?>
                                      <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-4 control-label">Feature shop:</label>
                                        <div class="col-sm-8">
                                            <input type="checkbox" name="data[Shop][is_featured]" value="1">
                                        </div>
                                      </div>
                                      <?php }elseif(count($get_free_shop)==0){?>
                                      <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-4 control-label">Feature shop:</label>
                                        <div class="col-sm-8">
                                            <input type="checkbox" name="data[Shop][is_featured]" value="1">
                                            <p class="text-muted">Feature your Shop £0.00 for <?php echo $sitesetting['SiteSetting']['feature_shop_free_days']?> days.</p>
                                        </div>
                                      </div>
                                      <?php
                                      }
                                      }?>  
                                      <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-6">
                                          <button type="submit" class="btn btn-default active">Save & Update</button>
                                        </div>
                                      </div>
                                     </form>

                            </div>
                        </div>
                    </div>
                </div>	
            </div>
        </div>
		
    </div>
</section>


<div class="modal fade" id="shop_close_div" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog dispute-request">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" style="background: transparent; color: #969494;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Closed shop for holiday</h4>
            </div>
            
            <form class="form-horizontal" method="post" action="<?php echo $this->webroot; ?>shops/closed_shop">
                <input type="hidden" name="data[CloseShop][shop_id]" value="<?php echo $shop_id; ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">From date:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="data[CloseShop][from_date]" id="from_date" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">To date:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="data[CloseShop][to_date]" id="to_date" required="required">
                        </div>
                    </div>
                    <!--
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Message:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="4" name="data[CloseShop][comment]"></textarea>
                        </div>
                    </div>
                    -->
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.closed_for_holiday').click(function(){
        $('#shop_close_div').modal();
    }); 
    
    $('#from_date').datepicker({dateFormat: 'yy-mm-dd',
        //minDate: dateToday,
        onSelect: function (date, el) {
            $("#to_date").datepicker( "option", "minDate", date );
        },
        yearRange: "-150:+1"});
    $('#to_date').datepicker({dateFormat: 'yy-mm-dd'});
});  
</script>


<style>
.profile_box p a{
	color:#fff;
}
.text-muted{
    color: #d43f3a;
}
</style>
