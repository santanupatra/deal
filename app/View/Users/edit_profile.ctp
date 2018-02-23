<?php ?>
<section class="after_login">
    <div class="container">
        <div class="row">
            <?php echo($this->element('user_leftbar'));?>
            <div class="col-md-9">
                <div class="product_title">
                    <div class="row">
                        <div class="col-md-6">
                                <h4>My Profile</h4>
                        </div>
                        <div class="col-md-6">
                                <!--<button class="btn_red pull-right">Closed for holiday</button>-->
                        </div>
                        <div class="col-md-12">
                            <div class="orderbosx">
                                    <!--<h2>Please provide Feedback for this Purchase</h2>-->
                                <div class="order_des pofile2">
                                    <h5>My profile Photo</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="profile_box">
                                                <?php
                                                if(isset($user['User']['profile_image']) && $user['User']['profile_image']!=''){
                                                ?>
                                                <img src="<?php echo($this->webroot)?>user_images/<?php echo($user['User']['profile_image'])?>" alt="<?php if(isset($user['User']['first_name']) && $user['User']['first_name']!=''){echo $user['User']['first_name'];}?> <?php if(isset($user['User']['last_name']) && $user['User']['last_name']!=''){echo $user['User']['last_name'];}?>" style="width:100%;"/>
                                                <?php } else {?>
                                                <img src="<?php echo($this->webroot)?>user_images/default.png" alt="<?php if(isset($user['User']['first_name']) && $user['User']['first_name']!=''){echo $user['User']['first_name'];}?> <?php if(isset($user['User']['last_name']) && $user['User']['last_name']!=''){echo $user['User']['last_name'];}?>" style="width:100%;"/>
                                                <?php } ?>
                                                <p><a href="<?php echo($this->webroot)?>users/edit_photo">Upload Photo <i class="fa fa-camera"></i></a></p>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="rules"><h3>Uploading Photo Rules</h3>
                                            <p>Please upload a photo that matches the gender, age and status details in your personal Profile.<br/><br/>Use a Photo that is appropriate for a business setting.<br/><br/>Photos Violating the rules stated in the Terms will be removed without notice.</p></div>
                                        </div>
                                        <div class="col-md-12">
                                            <h5>Edit My Profile</h5>
                                            <form class="form-horizontal profile_form" method="POST" action="<?php echo($this->webroot)?>users/edit_profile">
                                          <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label">Name <span style="color:red;">*</span></label>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" id="first_name" placeholder="First Name" value="<?php if(isset($user['User']['first_name']) && $user['User']['first_name']!=''){echo $user['User']['first_name'];}?>" name="data[User][first_name]" required/>
                                            </div>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" id="last_name" placeholder="Last Name" value="<?php if(isset($user['User']['last_name']) && $user['User']['last_name']!=''){echo $user['User']['last_name'];}?>" name="data[User][last_name]" required/>
                                            </div>
                                            <div class="col-sm-3">
                                              <input type="text" class="form-control" id="nick_name" placeholder="Nick Name" value="<?php if(isset($user['User']['nick_name']) && $user['User']['nick_name']!=''){echo $user['User']['nick_name'];}?>" name="data[User][nick_name]" required/>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label">Gender <span style="color:red;">*</span></label>
                                            <div class="col-sm-7">
                                                <label class="radio-inline">
                                                          <input type="radio" name="data[User][gender]" id="Male" value="M" <?php if(isset($user['User']['gender']) && $user['User']['gender']=='M'){echo 'checked';}?>> Male
                                                        </label>
                                                        <label class="radio-inline">
                                                          <input type="radio" name="data[User][gender]" id="Female" value="F" <?php if(isset($user['User']['gender']) && $user['User']['gender']=='F'){echo 'checked';}?>> Female
                                                        </label>
                                            </div>
                                          </div>
                                         <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label">Email Address <span style="color:red;">*</span></label>
                                            <div class="col-sm-6">
                                              <input type="email" class="form-control" id="email" placeholder="Email Address" value="<?php if(isset($user['User']['email']) && $user['User']['email']!=''){echo $user['User']['email'];}?>" name="data[User][email]" required>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label">Alternate email Address <span style="color:red;">*</span></label>
                                            <div class="col-sm-6">
                                              <input type="email" class="form-control" id="alternate_email" placeholder="Alternate Email Address" value="<?php if(isset($user['User']['alternate_email']) && $user['User']['alternate_email']!=''){echo $user['User']['alternate_email'];}?>" name="data[User][alternate_email]" required>
                                            </div>
                                          </div>



                                          <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label">Contact Address <span style="color:red;">*</span></label>
                                            <div class="col-sm-6">
                                              <input type="text" class="form-control margin_bottom" id="address" placeholder="Street Address" value="<?php if(isset($user['User']['address']) && $user['User']['address']!=''){echo $user['User']['address'];}?>" name="data[User][address]" required>


                                              <input type="text" class="form-control margin_bottom" id="city" placeholder="City" value="<?php if(isset($user['User']['city']) && $user['User']['city']!=''){echo $user['User']['city'];}?>" name="data[User][city]" required>

                                              <input type="text" class="form-control margin_bottom" id="state" placeholder="Province/State/County" value="<?php if(isset($user['User']['state']) && $user['User']['state']!=''){echo $user['User']['state'];}?>" name="data[User][state]" required>

                                              <!--<select name="" class="form-control margin_bottom">
                                                <option>Country</option>
                                              </select>-->
                                                <input type="text" class="form-control margin_bottom" id="country" placeholder="Country" value="<?php if(isset($user['User']['country']) && $user['User']['country']!=''){echo $user['User']['country'];}?>" name="data[User][country]" required>

                                              <input type="text" class="form-control" id="zip_code" placeholder="Zip/Postal Code" value="<?php if(isset($user['User']['zip_code']) && $user['User']['zip_code']!=''){echo $user['User']['zip_code'];}?>" name="data[User][zip_code]" required>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label">Tel <span style="color:red;">*</span></label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="telephone_country_code" placeholder="Country Code" value="<?php if(isset($user['User']['telephone_country_code']) && $user['User']['telephone_country_code']!=''){echo $user['User']['telephone_country_code'];}?>" name="data[User][telephone_country_code]" required>
                                            </div>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="telephone_area_code" placeholder="Area Code" value="<?php if(isset($user['User']['telephone_area_code']) && $user['User']['telephone_area_code']!=''){echo $user['User']['telephone_area_code'];}?>" name="data[User][telephone_area_code]" required>
                                            </div>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="telephone_number" placeholder="" value="<?php if(isset($user['User']['telephone_number']) && $user['User']['telephone_number']!=''){echo $user['User']['telephone_number'];}?>" name="data[User][telephone_number]" required>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label">Fax</label>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="fax_country_code" placeholder="Country Code" value="<?php if(isset($user['User']['fax_country_code']) && $user['User']['fax_country_code']!=''){echo $user['User']['fax_country_code'];}?>" name="data[User][fax_country_code]" >
                                            </div>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="fax_area_code" placeholder="Area Code" value="<?php if(isset($user['User']['fax_area_code']) && $user['User']['fax_area_code']!=''){echo $user['User']['fax_area_code'];}?>" name="data[User][fax_area_code]" >
                                            </div>
                                            <div class="col-sm-2">
                                              <input type="text" class="form-control" id="fax_number" placeholder="" value="<?php if(isset($user['User']['fax_number']) && $user['User']['fax_number']!=''){echo $user['User']['fax_number'];}?>" name="data[User][fax_number]" />
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label">Mobile <span style="color:red;">*</span></label>
                                            <div class="col-sm-6">
                                              <input type="text" class="form-control" id="mobile_number" placeholder="Enter Mobile No." value="<?php if(isset($user['User']['mobile_number']) && $user['User']['mobile_number']!=''){echo $user['User']['mobile_number'];}?>" name="data[User][mobile_number]" required>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label">Job Title <span style="color:red;">*</span></label>
                                            <div class="col-sm-6">
                                              <input type="text" class="form-control" id="job_title" placeholder="" value="<?php if(isset($user['User']['job_title']) && $user['User']['job_title']!=''){echo $user['User']['job_title'];}?>" name="data[User][job_title]" required>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label for="shop_address_add" class="col-sm-3 control-label">Add shop address</label>
                                            <div class="col-sm-6">
                                                <input type="checkbox" name="shop_address_add" id="shop_address_add" value="1">
                                            </div>
                                          </div>      
                                          <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-7">
                                              <button type="submit" class="btn btn-default active">Save</button>
                                              <button type="button" class="btn btn-default">Cancel</button>
                                            </div>
                                          </div>
                                        </form>
                                        <div id="ShopAddDiv" style="display: none;">    
                                        <h5>Shop Address</h5>
                                        <form class="form-horizontal profile_form" method="POST" action="<?php echo($this->webroot)?>users/edit_profile" enctype="multipart/form-data">
                                            <?php
                                            $identity_proof=  isset($user['User']['identity_proof'])?$user['User']['identity_proof']:'';
                                            $bill_proof=  isset($user['User']['bill_proof'])?$user['User']['bill_proof']:'';
                                            ?>
                                            <input type="hidden" name="data[User][hid_identity_proof]" value="<?php echo $identity_proof;?>">
                                            <input type="hidden" name="data[User][hid_bill_proof]" value="<?php echo $bill_proof;?>">
                                          <div class="form-group">
                                            <label for="inputPassword3" class="col-sm-3 control-label">Shop Address <span style="color:red;">*</span></label>
                                            <div class="col-sm-9">
                                                <div class="row">
                                                        <div class="col-sm-6 margin_bottom">
                                                              <input type="text" class="form-control" id="shop_address" placeholder="Street Address" value="<?php if(isset($user['User']['shop_address']) && $user['User']['shop_address']!=''){echo $user['User']['shop_address'];}?>" name="data[User][shop_address]" required>
                                                            </div>
                                                            <div class="col-sm-6 margin_bottom">
                                                              <input type="text" class="form-control" id="shop_vat" placeholder="VAT (as per JPEG)" value="<?php if(isset($user['User']['shop_vat']) && $user['User']['shop_vat']!=''){echo $user['User']['shop_vat'];}?>" name="data[User][shop_vat]" required>
                                                            </div>
                                                            <div class="col-sm-6 margin_bottom">
                                                              <input type="text" class="form-control" id="shop_city" placeholder="City" value="<?php if(isset($user['User']['shop_city']) && $user['User']['shop_city']!=''){echo $user['User']['shop_city'];}?>" name="data[User][shop_city]" required>
                                                            </div>
                                                            <div class="col-sm-6 margin_bottom">
                                                              <input type="text" class="form-control" id="shop_company_reg_no" placeholder="Company Registration No." value="<?php if(isset($user['User']['shop_company_reg_no']) && $user['User']['shop_company_reg_no']!=''){echo $user['User']['shop_company_reg_no'];}?>" name="data[User][shop_company_reg_no]" required>
                                                            </div>
                                                            <div class="col-sm-6 margin_bottom">
                                                              <input type="text" class="form-control" id="inputEmail3" placeholder="Country" value="<?php if(isset($user['User']['shop_country']) && $user['User']['shop_country']!=''){echo $user['User']['shop_country'];}?>" name="data[User][shop_country]" required>
                                                            </div>
                                                            <div class="col-sm-6 margin_bottom">
                                                                <label for="identity_proof" class="col-sm-3 control-label">Identity proof <span style="color:red;">*</span></label>
                                                                <div class="col-sm-4">
                                                                    <input type="file" name="data[User][identity_proof]" id="identity_proof" <?php if($identity_proof==''){ echo 'required="required"';}?>> 
                                                                </div>
                                                                <div class="col-sm-5" style="padding-right: 0;">
                                                                    <?php
                                                                    if($identity_proof!=''){
                                                                    ?>
                                                                    <img src="<?php echo($this->webroot)?>user_documents/<?php echo $identity_proof;?>" style="width:100%;height:75px;"/>
                                                                    <?php } else {?>
                                                                    <img src="<?php echo($this->webroot)?>shop_images/img.png" style="width:100%;height:75px;"/>					
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="clearfix"></div>
                                                            <div class="col-sm-6">
                                                              <input type="text" class="form-control" id="inputEmail3" placeholder="Zip/Postal Code" value="<?php if(isset($user['User']['shop_zip_code']) && $user['User']['shop_zip_code']!=''){echo $user['User']['shop_zip_code'];}?>" name="data[User][shop_zip_code]" required>
                                                            </div>
                                                            <div class="col-sm-6 margin_bottom">
                                                                <label for="utility_bill" class="col-sm-3 control-label">Utility Bill<span style="color:red;">*</span></label>
                                                                <div class="col-sm-4">
                                                                    <input type="file" name="data[User][bill_proof]" id="utility_bill" <?php if($bill_proof==''){ echo 'required="required"';}?>> 
                                                                </div>
                                                                <div class="col-sm-5" style="padding-right: 0;">
                                                                    <?php
                                                                    if($bill_proof!=''){
                                                                    ?>
                                                                    <img src="<?php echo($this->webroot)?>user_documents/<?php echo $bill_proof;?>" style="width:100%;height:75px;"/>
                                                                    <?php } else {?>
                                                                    <img src="<?php echo($this->webroot)?>shop_images/img.png" style="width:100%;height:75px;"/>					
                                                                    <?php } ?>
                                                                </div>
                                                            </div>
                                                    </div>
                                            </div>
                                           </div>
                                           <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-7">
                                              <button class="btn btn-default active" type="submit">Save</button>
                                              <button class="btn btn-default" type="button">Cancel</button>
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
                </div>

            </div>
        </div>

    </div>
</section>

<script type="text/javascript">
$(document).ready(function(){
    $('#shop_address_add').click(function(){
        if($("#shop_address_add:checked").length > 0) {
            $('#ShopAddDiv').show();
        }else{
            $('#ShopAddDiv').hide();
        }
    }); 
    
});  
</script>

<style>
.profile_box p a{
	color:#fff;
}
</style>
