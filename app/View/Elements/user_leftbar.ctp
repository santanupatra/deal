<?php ?>
<div class="col-md-3 category_tab">
  <ul class="nav nav-tabs" role="tablist">
        <?php if($this->params['action']=='buyer_dashboard' || $this->params['action']=='all_order' || $this->params['action']=='purchasedetails' || $this->params['action']=='awaiting_payment' || $this->params['action']=='awaiting_shipment' || $this->params['action']=='awaiting_delivery' || $this->params['action']=='buyer_disputes' || $this->params['action']=='buyer_dispute_details' || $this->params['action']=='purchased_history' || $this->params['action']=='order_feedback' || $this->params['action']=='buyer_message' || $this->params['action']=='message_conversations' || $this->params['action']=='buyer_sent' || $this->params['action']=='buyer_folder' || $this->params['action']=='wishlist' || $this->params['action']=='follow' || $this->params['action']=='buyer_billing_report' || $this->params['action']=='buyer_feedback' || (isset($this->params['pass'][0]) && $this->params['pass'][0]=='buyer')){ $ActiveClass='active'; }else{  $ActiveClass='';} ?>

 <li role="presentation" class="<?php echo ($ActiveClass=='')?'active':'';?>"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Selling</a></li>
    <li role="presentation" class="<?php echo ($ActiveClass!='')?'active':'';?>" ><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Buying</a></li>
      
    
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel"  class="tab-pane <?php echo ($ActiveClass=='')?'active':'';?>" id="home">
	<ul>
            <li><a href="<?php echo($this->webroot);?>users/seller_dashboard">Dashboard</a></li>
            <li><a href="<?php echo($this->webroot);?>users/edit-profile">My Profile</a></li>
            <?php if($userdetails['User']['is_all_complt']==1){ ?>
            <li><a href="<?php echo($this->webroot);?>users/security">Settings</a></li>
            <li><a href="<?php echo($this->webroot);?>shops/myshop">Manage Shop</a></li>
            <?php if(isset($shopIOwn) && !empty($shopIOwn)){?>
            <li><a href="<?php echo($this->webroot);?>users/membership">Membership</a></li>
            <?php }?>
            <?php if(isset($shopIOwn) && !empty($shopIOwn)){?>
            <li><a href="<?php echo($this->webroot);?>products/my_inventory_list">Manage Inventory</a></li>
            <?php }?>
            <li><a href="<?php echo($this->webroot);?>orders/index">All Orders <?php echo (isset($new_order_count) && $new_order_count>0)?'<span class="mail_count">'.$new_order_count.'</span>':'';?></a></li>
            <li><a href="<?php echo($this->webroot);?>orders/seller_report">Report</a></li>
            <li><a href="<?php echo($this->webroot);?>orders/seller_mail">Mail <?php echo (isset($seller_messages_list_cnt) && $seller_messages_list_cnt>0)?'<span class="mail_count">'.$seller_messages_list_cnt.'</span>':'';?></a></li>
            <li><a href="<?php echo($this->webroot);?>packages/advertisement">Advertisement</a></li>
            <li><a href="<?php echo($this->webroot);?>packages/advertisement_report">Advertisement Report</a></li>
            <li><a href="<?php echo($this->webroot);?>orders/billing_report">Billing Report</a></li>
            <?php if(isset($shopIOwn) && !empty($shopIOwn)){?>
            <li><a href="<?php echo($this->webroot);?>shops/seller_feedback">Feedback</a></li>
            <?php } } ?>
            <!--<li><a href="<?php echo($this->webroot);?>coupons/index">Coupon Codes</a></li>-->
            <li><a href="<?php echo($this->webroot)?>users/logout">Logout</a></li>
	</ul>
    </div>
    <div role="tabpanel" class="tab-pane <?php echo ($ActiveClass!='')?'active':'';?>" id="profile">
    	<ul>
            <li><a href="<?php echo($this->webroot);?>users/buyer_dashboard">Dashboard</a></li>
            <li><a href="<?php echo($this->webroot);?>users/edit-profile/buyer">My Profile</a></li>
            <?php if($userdetails['User']['is_all_complt']==1){ ?>
            <li><a href="<?php echo($this->webroot);?>users/security/buyer">Settings</a></li>
            <li><a href="<?php echo($this->webroot);?>orders/buyer_message">Mail <?php echo (isset($messages_list_cnt) && $messages_list_cnt>0)?'<span class="mail_count">'.$messages_list_cnt.'</span>':'';?></a></li>
            <li><a href="<?php echo($this->webroot);?>orders/all_order">All Orders</a></li>
            <li><a href="<?php echo($this->webroot);?>orders/purchased_history">Purchase History</a></li>
            <li><a href="<?php echo($this->webroot);?>orders/buyer_billing_report">Billing Report</a></li>
            <li><a href="<?php echo($this->webroot);?>users/wishlist">Favourites</a></li>
            <li><a href="<?php echo($this->webroot);?>users/follow">Followed Stores</a></li>
            <li><a href="<?php echo($this->webroot);?>shops/buyer_feedback">Feedback</a></li>
            <?php } ?>
            
            <li><a href="<?php echo($this->webroot)?>users/logout">Logout</a></li>
	</ul>
    </div>
  </div>
</div>
<style>
.mail_count {
    background: red none repeat scroll 0 0;
    border-radius: 10px;
    clear: both;
    color: #fff;
    font-size: 11px;
    font-weight: bold;
    line-height: 12px;
    margin: 0 auto;
    padding: 4px;
    width: auto;
}
</style>
