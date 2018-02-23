<?php echo $this->Html->script('ckeditor/ckeditor');?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Site Setting'); ?></div>
			</div>
			<div class="users form">
			<?php echo $this->Form->create('SiteSetting',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
				
				
				<?php
					echo $this->Form->input('id');
                    
				?>
                
				<?php
				    echo $this->Form->input('paypal_email',array('required'=>'required','type'=>'email'));
                                    echo $this->Form->input('paypal_developer_email',array('required'=>'required','type'=>'email'));
                                    
                                     echo $this->Form->input('braintree_loginid',array('required'=>'required','type'=>'text','label'=>'Braintree Login ID'));
                                     
                                     echo $this->Form->input('braintree_password',array('required'=>'required','type'=>'text','label'=>'Braintree Password'));
                                    
                                   // echo $this->Form->input('paypal_app_id',array('required'=>'required','type'=>'text','label'=>'Paypal App Id'));
                                   // echo $this->Form->input('paypal_api_username',array('required'=>'required'));
                                   // echo $this->Form->input('paypal_api_password',array('required'=>'required'));
                                   // echo $this->Form->input('paypal_api_signature',array('required'=>'required'));
                                    echo $this->Form->input('admin_email',array('required'=>'required','type'=>'email','label'=>'Contact Email'));
                                    //echo $this->Form->input('admin_percentage',array('required'=>'required'));
                                    //echo $this->Form->input('phone',array('required'=>'required'));
                                    //echo $this->Form->input('mobile',array('required'=>'required'));
                                    //echo $this->Form->input('address',array('required'=>'required'));
                                    
                                ?>
                                <!-- <div class="input text" style="width: 40%; float: left; clear: none;">
                                    <label for="SiteSettingFeatureShopFreeDays">Feature Shop Free Days</label>
                                    <input id="SiteSettingFeatureShopFreeDays" type="number" required="required" name="data[SiteSetting][feature_shop_free_days]" value="<?php echo $this->request->data['SiteSetting']['feature_shop_free_days'];?>">
                                </div>
                                <div class="input text" style="width: 40%; float: left; clear: none;">
                                <label for="SiteSettingFeatureProductFreeDays">Feature Product Free Days</label>
                                <input id="SiteSettingFeatureProductFreeDays" type="number" required="required" name="data[SiteSetting][feature_product_free_days]" value="<?php echo $this->request->data['SiteSetting']['feature_product_free_days'];?>">
                                </div>
                                <div class="input text" style="width: 40%; float: left; clear: none;">
                                    <label for="SiteSettingFeatureShopPaidDays">Feature Shop Paid Days</label>
                                    <input id="SiteSettingFeatureShopPaidDays" type="number" required="required" name="data[SiteSetting][feature_shop_paid_days]" value="<?php echo $this->request->data['SiteSetting']['feature_shop_paid_days'];?>">
                                </div>
                                <div class="input text" style="width: 40%; float: left; clear: none;">
                                    <label for="SiteSettingFeatureShopPaidFee">Feature Shop Paid Fee</label>
                                    <input id="SiteSettingFeatureShopPaidFee" type="number" required="required" name="data[SiteSetting][feature_shop_paid_fee]" value="<?php echo $this->request->data['SiteSetting']['feature_shop_paid_fee'];?>">
                                </div>
                                <div class="input text" style="width: 40%; float: left; clear: none;">
                                <label for="SiteSettingFeatureProductPaidDays">Feature Product Paid Days</label>
                                <input id="SiteSettingFeatureProductPaidDays" type="number" required="required" name="data[SiteSetting][feature_product_paid_days]" value="<?php echo $this->request->data['SiteSetting']['feature_product_paid_days'];?>">
                                </div>  
                                <div class="input text" style="width: 40%; float: left; clear: none;">
                                    <label for="SiteSettingFeatureProductPaidFee">Feature Product Paid Fee</label>
                                    <input id="SiteSettingFeatureProductPaidFee" type="number" required="required" name="data[SiteSetting][feature_product_paid_fee]" value="<?php echo $this->request->data['SiteSetting']['feature_product_paid_fee'];?>">
                                </div>  -->   
                                <?php
                                    /*echo $this->Form->input('feature_shop_free_days',array('required'=>'required'));
                                    echo $this->Form->input('feature_product_free_days',array('required'=>'required'));
                                    echo $this->Form->input('feature_shop_paid_days',array('required'=>'required'));
                                    echo $this->Form->input('feature_shop_paid_fee',array('required'=>'required'));
                                    echo $this->Form->input('feature_product_paid_days',array('required'=>'required'));
                                    echo $this->Form->input('feature_product_paid_fee',array('required'=>'required'));
                                    echo $this->Form->input('shop_price_per_month',array('required'=>'required'));
                                    echo $this->Form->input('can_post_number_of_listing',array('required'=>'required'));
                                    echo $this->Form->input('price_per_listing',array('required'=>'required'));*/
				?>
				</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
