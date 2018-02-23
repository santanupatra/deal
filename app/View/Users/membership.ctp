<?php 
if(!empty($shop)){
	$shopId = $shop['Shop']['id'];
}
?>
<section class="after_login">
	<div class="container">
		<div class="row">
				<!--<div class="col-md-3 category_tab">
				  <ul class="nav nav-tabs" role="tablist">
				    <li role="presentation" class="active" style="width:100%"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Account Settings</a></li> 
				  </ul>
				  <div class="tab-content">
				    <div role="tabpanel" class="tab-pane active" id="home">
						<ul>
							<li><a href="">My Profile</a></li>
							<li><a href="">Security Information Settings</a></li>
							<li class="selected"><a href="">Seller Membership</a></li>
							
						</ul>
				    </div>
				  </div>
				</div>-->
		    <?php echo($this->element('user_leftbar'));?>
			<div class="col-md-9">
			    <div class="product_title">
				<div class="row">
					<div class="col-md-12">
						<h4>Seller Membership</h4>
					</div>
					<div class="col-md-12">
						<div class="dash_middle_sec seller_membership">
						<h3>Supplier’s Shop for <?php echo $sitesetting['SiteSetting']['shop_price_per_month']?> pounds per month first <?php echo $sitesetting['SiteSetting']['can_post_number_of_listing']?> listings free
and <?php echo $sitesetting['SiteSetting']['price_per_listing']?> pence per listing per month thereafter.</h3>
						<?php if($shopId!=''){ ?>    
						<button onclick="formSubmit(<?php echo($shopId);?>)">Renew Membership</button>
						<?php } ?>
						</div>
					</div>
				</div>
			    </div>
			</div>
		</div>
	</div>
</section>
<script>
function formSubmit(val){
    window.location="<?php echo $this->webroot.'users/payment/';?>"+val;
    //document.membershipform.submit();
}
</script>
