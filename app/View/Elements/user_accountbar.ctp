<?php ?>
<!--<div class="col-md-3">                  
<div class="panel" style="position:relative;">
 <span id="profpic">
  <?php
   if(isset($userdetails['User']['profile_image']) && $userdetails['User']['profile_image']!='')
   {
  ?>
	<img src="<?php echo $this->webroot; ?>user_images/<?php echo $userdetails['User']['profile_image'];?>" alt="<?php echo $userdetails['User']['first_name'];?>" class="img-responsive" style="float: none;margin: 0 auto;"/>
  <?php }else{ ?>
	<img src="<?php echo $this->webroot; ?>user_images/user_image.png" alt="<?php echo $userdetails['User']['first_name'];?>" class="img-responsive" style="float: none;margin: 0 auto;"/>
  <?php } ?>
 </span>
 <input type="file" id="theFileprofile" name="profilephoto" style="display:none;"/>
 <img title="Upload profile picture" src="<?php echo $this->webroot;?>img/upload_profile_pic.png" style="height: auto;width: auto;border-radius: 0px;position: absolute;bottom: 86px;left: 120px;cursor:pointer;" onclick="performClickprofile()" id="upload_profile_pic">
 <img src="<?php echo $this->webroot;?>img/search_mask.gif" style="height: auto;width: auto;border-radius: 0px;position: absolute;bottom: 75px;left: 110px;display:none;" id="upload_loading_pic">
 
<div class="profile_desc panel-body text-center">
<h4>
  <?php if(isset($userid) && $userid!=''){echo $userdetails['User']['first_name'].' '.$userdetails['User']['last_name'];} ?>
</h4>
</div>
</div>
<div class="">
<div class="profile-details-friends">
<div class="list-group">  
 <?php 
   if($this->params['controller']=='users' && ($this->params['action']=='spa_listing_add' || $this->params['action']=='add_overview' || $this->params['action']=='add_package' || $this->params['action']=='add_contact' || $this->params['action']=='thank_you' || $this->params['action']=='onsite_listing_add' || $this->params['action']=='onsite_add_overview' || $this->params['action']=='onsite_add_package' || $this->params['action']=='onsite_add_contact' || $this->params['action']=='onsite_thank_you'))
   {
 ?>
  <a data-toggle="tab" href="javascript:void(0);" class="list-group-item <?php if($this->params['controller']=='users' && ($this->params['action']=='spa_listing_add' || $this->params['action']=='onsite_listing_add')){echo 'active';}?>">
   <div class="round-icon">
    <i class="fa fa-picture-o"></i>
   </div>
   Top Banner
  </a>
  
  <a data-toggle="tab" href="javascript:void(0);" class="list-group-item <?php if($this->params['controller']=='users' && ($this->params['action']=='add_overview' || $this->params['action']=='onsite_add_overview')){echo 'active';}?>">
   <div class="round-icon"><i class="fa fa-tag"></i></div> 
   Overview
  </a>
  
  <a data-toggle="tab" href="javascript:void(0);" class="list-group-item <?php if($this->params['controller']=='users' && ($this->params['action']=='add_package' || $this->params['action']=='onsite_add_package')){echo 'active';}?>">
   <div class="round-icon"><i class="fa fa-gift"></i></div>
   Treatments & Packages
  </a>      
  
  <a data-toggle="tab" href="javascript:void(0);" class="list-group-item <?php if($this->params['controller']=='users' && ($this->params['action']=='add_contact' || $this->params['action']=='onsite_add_contact')){echo 'active';}?>">
   <div class="round-icon"><i class="fa fa-envelope"></i></div>Contact
  </a>   
     
  <?php if($this->params['controller']=='users' && ($this->params['action']=='spa_listing_add' || $this->params['action']=='add_overview' || $this->params['action']=='add_package' || $this->params['action']=='add_contact' || $this->params['action']=='thank_you')){ ?>                  
  <a href="<?php echo $this->webroot;?>users/spa-listing" class="list-group-item">
   <div class="round-icon"><i class="fa fa-angle-double-left"></i></div>
   Back To Spa Listing
  </a>
 <?php }else{ ?>
  <a href="<?php echo $this->webroot;?>users/on-site-listing" class="list-group-item">
   <div class="round-icon"><i class="fa fa-angle-double-left"></i></div>
   Back To Onsite Listing
  </a>
    
 <?php }}else{ ?>
  <a href="<?php echo $this->webroot;?>users/dashboard" class="list-group-item"><div class="round-icon">
  <span class="glyphicon glyphicon-signal" aria-hidden="true"></span>
  </div>Dashboard</a>
  <a href="#" class="list-group-item"><div class="round-icon"><i class="fa fa-envelope"></i>
  </div> My Messages</a>
  <a href="<?php echo $this->webroot;?>users/spa-listing" class="list-group-item"><div class="round-icon">
  <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
  </div>Spa Listing</a>
  <a href="<?php echo $this->webroot;?>users/on-site-listing" class="list-group-item"><div class="round-icon">
  <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
  </div>On-site Listing</a>
  <a href="<?php echo $this->webroot;?>users/edit-profile" class="list-group-item"><div class="round-icon">
  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
  </div>Edit Profile</a>
  <a href="<?php echo $this->webroot;?>users/change-password" class="list-group-item"><div class="round-icon">
  <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
  </div>Change Password</a>
  <a href="<?php echo $this->webroot;?>users/logout" class="list-group-item"><div class="round-icon"><i class="fa fa-power-off"></i></div>Logout</a>
 <?php } ?>
</div>
</div>
</div>
</div>   
-->

<div class="col-md-3 category_tab">
  <ul class="nav nav-tabs" role="tablist">
   <!-- <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Selling</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Buying</a></li>-->

        <?php if($this->params['action']=='buyer_dashboard' || $this->params['action']=='security' || $this->params['action']=='all_order' || $this->params['action']=='purchasedetails' || $this->params['action']=='awaiting_payment' || $this->params['action']=='awaiting_shipment' || $this->params['action']=='awaiting_delivery' || $this->params['action']=='buyer_disputes' || $this->params['action']=='buyer_dispute_details' || $this->params['action']=='purchased_history' || $this->params['action']=='order_feedback' || $this->params['action']=='buyer_message' || $this->params['action']=='message_conversations' || $this->params['action']=='buyer_sent' || $this->params['action']=='buyer_folder' || $this->params['action']=='wishlist' || $this->params['action']=='follow'){ $ActiveClass='active'; }else{  $ActiveClass='';} ?>

 <li role="presentation" class="<?php echo ($ActiveClass=='')?'active':'';?>"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Selling</a></li>
    <li role="presentation" class="<?php echo ($ActiveClass!='')?'active':'';?>" ><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Buying</a></li>
      
    
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel"  class="tab-pane <?php echo ($ActiveClass=='')?'active':'';?>" id="home">
	<ul>
		<li><a href="<?php echo($this->webroot);?>users/seller_dashboard">Dashboard</a></li>
		<li><a href="<?php echo($this->webroot);?>users/security">Security Information Settings</a></li>
		<li><a href="<?php echo($this->webroot);?>shops/myshop">My Shop</a></li>
		<li><a href="<?php echo($this->webroot);?>users/membership">Membership</a></li>
		<?php /*if(isset($shopIOwn) && !empty($shopIOwn) && $shopIOwn['Shop']['is_active']==1 && strtotime($shopIOwn['Shop']['last_date'])>strtotime(date('Y-m-d'))){*/?>
		<li><a href="<?php echo($this->webroot);?>products/my_inventory_list">Manage Inventory</a></li>
		<?php /*}*/?>
		<li><a href="<?php echo($this->webroot);?>orders/index">Sales Track</a></li>
                <li><a href="<?php echo($this->webroot);?>orders/seller_mail">Mail</a></li>
                <li><a href="<?php echo($this->webroot);?>coupons/index">Coupon Codes</a></li>
		<li><a href="<?php echo($this->webroot)?>users/logout">Logout</a></li>
	</ul>
    </div>
    <div role="tabpanel" class="tab-pane <?php echo ($ActiveClass!='')?'active':'';?>" id="profile">
    	<ul>
		<li><a href="<?php echo($this->webroot);?>users/buyer_dashboard">Dashboard</a></li>
    <li><a href="<?php echo($this->webroot);?>users/security">Security Information Settings</a></li>
    <li><a href="<?php echo($this->webroot);?>orders/buyer_message">Order Message </a></li>
    <li><a href="<?php echo($this->webroot);?>orders/all_order">All Orders</a></li>
		<li><a href="<?php echo($this->webroot);?>orders/purchased_history">Purchase History</a></li>
		<li><a href="<?php echo($this->webroot);?>users/wishlist">Watchlist</a></li>
		<li><a href="<?php echo($this->webroot);?>users/follow">Followed Stores</a></li>		
		<li><a href="<?php echo($this->webroot)?>users/logout">Logout</a></li>
	</ul>
    </div>
  </div>
</div>
