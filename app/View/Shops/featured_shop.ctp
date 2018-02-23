<?php  $SITE_URL = Configure::read('SITE_URL'); ?>
<section class="after_login">
	<div class="container">
		<div class="row">
		    <?php echo($this->element('user_leftbar'));?>
			<div class="col-md-9">
			    <div class="product_title">
				<div class="row">
                                    <div class="col-md-12">
                                            <div class="dash_middle_sec seller_membership">
                                            <h3>Featured Shop $<?php echo $sitesetting['SiteSetting']['feature_shop_paid_fee']?> for <?php echo $sitesetting['SiteSetting']['feature_shop_paid_days']?> days</h3>	

                                                <div class="col-md-6"><button onclick="formSubmit();">Pay By PayPal</button></div><div class="col-md-2"> <a href="<?php echo $SITE_URL.'shops/myshop';?>"><button>Cancel </button> </a></div> 

                                            </div>
                                    </div>
				</div>
			    </div>
			</div>
		</div>
	</div>
<!--<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="membershipform">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="nits.arpita@gmail.com">
<input type="hidden" name="item_name" value="MemberShip">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="rm" value="2">
<input type="hidden" name="notify_url" value="<?php echo $SITE_URL.'users/success';?>">
<input type="hidden" name="amount" id="amount" value="">
<input type="hidden" name="src" value="1">
<input type="hidden" name="sra" value="1">
<input type="hidden" name="custom" value="">
<input type="hidden" name="return" value="<?php echo $SITE_URL.'users/success';?>">
<input type="hidden" name="cancel_return" value="<?php echo $SITE_URL.'users/membership';?>">
</form>-->


<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="membershipform">

    <!-- Identify your business so that you can collect the payments. -->
    <input type="hidden" name="business" value="<?php echo $sitesetting['SiteSetting']['paypal_email']?>">

    <!-- Specify a Subscribe button. -->
    <input type="hidden" name="cmd" value="_xclick-subscriptions">
    <!-- Identify the subscription. -->
    <input type="hidden" name="item_name" value="Featured Shop on TWOP">
    <!--<input type="hidden" name="item_number" value="Monthly">-->

    <!-- Set the terms of the regular subscription. -->
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="a3" value="<?php echo $sitesetting['SiteSetting']['feature_shop_paid_fee']?>">
    <input type="hidden" name="p3" value="<?php echo $sitesetting['SiteSetting']['feature_shop_paid_days']?>">
    <input type="hidden" name="t3" value="D">

    <!-- Set recurring payments until canceled. -->
    <input type="hidden" name="src" value="1">
    <input type="hidden" name="sra" value="1">
    <input type="hidden" name="no_shipping" value="1">
    <input type="hidden" name="rm" value="2">
    <input type="hidden" name="notify_url" value="<?php echo $SITE_URL.'shops/featured_shop_success';?>">
    <input type="hidden" name="return" value="<?php echo $SITE_URL.'shops/featured_shop_success';?>">
    <input type="hidden" name="cancel_return" value="<?php echo $SITE_URL.'shops/myshop';?>">
    <input type="hidden" name="custom" value="<?php echo $shop_id.'|'.$userid;?>">

    <!-- Display the payment button. -->
    <!--<input type="image" name="submit"
    src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribe_LG.gif"
    alt="PayPal - The safer, easier way to pay online">
    <img alt="" width="1" height="1"
    src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >-->
</form>
</section>
<script>
    function formSubmit(){
    	document.membershipform.submit();
    }   
</script>    

