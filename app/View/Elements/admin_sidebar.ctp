<?php
$adminhelp = $this->Helpers->load('Adminhelp');
$getTotalUser=$adminhelp->get_total_user();
$getTotalnormalUser=$adminhelp->get_total_normal_user();
$getTotalnormalVendor=$adminhelp->get_total_normal_vendor();
$pass_data=$this->params['pass'];

if(count($pass_data)>0){
    $pass_data_str=isset($pass_data[0])?$pass_data[0]:'';
}else{
    $pass_data_str='';
}
?>
<div class="span3" id="sidebar">
<ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
	
	<li <?php if($this->params['controller']=='site_settings' && $this->params['action']=='admin_edit')
        {?>class="active"<?php } ?>><a href="<?php echo($this->webroot)?>admin/site_settings/edit/1"><?php if($this->params['controller']=='site_settings' && $this->params['action']=='admin_edit')
        {?><i class="icon-chevron-right"></i><?php } ?> Site Settings</a>
	</li>
	
	<li <?php if($this->params['controller']=='site_settings' && $this->params['action']=='admin_sociallink')
        {?>class="active"<?php } ?>><a href="<?php echo($this->webroot)?>admin/site_settings/sociallink/1"><?php if($this->params['controller']=='site_settings' && $this->params['action']=='admin_sociallink')
        {?><i class="icon-chevron-right"></i><?php } ?> Site Social Link</a>
	</li>
	
	<li <?php if($this->params['controller']=='users' && ($this->params['action']=='admin_list' || $this->params['action']=='admin_add' || $this->params['action']=='admin_edit' || $this->params['action']=='admin_view'))
        {?>class="active"<?php } ?>>
		<a href="<?php echo($this->webroot)?>admin/users/list"><?php if($this->params['controller']=='users' && ($this->params['action']=='admin_list' || $this->params['action']=='admin_add' || $this->params['action']=='admin_edit' || $this->params['action']=='admin_view'))
        {?><i class="icon-chevron-right"></i><?php } ?><span <?php if($this->params['controller']=='users' && ($this->params['action']=='admin_list' || $this->params['action']=='admin_add' || $this->params['action']=='admin_edit' || $this->params['action']=='admin_view'))
        {?>class="badge badge-info1 pull-right"<?php }else{ ?>class="badge badge-info pull-right"<?php } ?>><?php echo($getTotalUser)?></span> Admin</a>
	</li>
        
        <li <?php if($this->params['controller']=='users' && ($this->params['action']=='admin_user_list' || $this->params['action']=='admin_user_add' || $this->params['action']=='admin_user_edit' || $this->params['action']=='admin_user_view'))
        {?>class="active"<?php } ?>>
		<a href="<?php echo($this->webroot)?>admin/users/user_list"><?php if($this->params['controller']=='users' && ($this->params['action']=='admin_user_list' || $this->params['action']=='admin_user_add' || $this->params['action']=='admin_user_edit' || $this->params['action']=='admin_user_view'))
        {?><i class="icon-chevron-right"></i><?php } ?><span <?php if($this->params['controller']=='users' && ($this->params['action']=='admin_user_list' || $this->params['action']=='admin_user_add' || $this->params['action']=='admin_user_edit' || $this->params['action']=='admin_user_view'))
        {?>class="badge badge-info1 pull-right"<?php }else{ ?>class="badge badge-info pull-right"<?php } ?>><?php echo($getTotalnormalUser)?></span> User</a>
	</li>
        
        
        
        
        
        
        <li <?php if($this->params['controller']=='packages' && ($this->params['action']=='admin_index' || $this->params['action']=='admin_edit'))
        {?>class="active"<?php } ?>><a href="<?php echo($this->webroot)?>admin/packages/index"><?php if($this->params['controller']=='packages' && ($this->params['action']=='admin_index' || $this->params['action']=='admin_edit')){?><i class="icon-chevron-right"></i><?php } ?> Advertising Packages</a>
	</li>
       <!--  <li <?php if($this->params['controller']=='packages' && ($this->params['action']=='admin_advertisement' || $this->params['action']=='admin_advertisement_edit'))
        {?>class="active"<?php } ?>><a href="<?php echo($this->webroot)?>admin/packages/advertisement"><?php if($this->params['controller']=='packages' && ($this->params['action']=='admin_advertisement' || $this->params['action']=='admin_advertisement_edit')){?><i class="icon-chevron-right"></i><?php } ?> Advertisement</a>
	</li>  -->
	<!-- <li <?php if($this->params['controller']=='activities')
        {?>class="active"<?php } ?>><a href="<?php echo($this->webroot)?>admin/activities/list"><?php if($this->params['controller']=='activities')
        {?><i class="icon-chevron-right"></i><?php } ?> Tracking Activity</a>
	</li> -->
	<li <?php if($this->params['controller']=='shops')
        {?>class="active"<?php } ?>><a href="<?php echo($this->webroot)?>admin/shops/list"><?php if($this->params['controller']=='shops')
        {?><i class="icon-chevron-right"></i><?php } ?><span <?php if($this->params['controller']=='shops' && ($this->params['action']=='admin_list' || $this->params['action']=='admin_add' || $this->params['action']=='admin_edit' || $this->params['action']=='admin_view'))
        {?>class="badge badge-info1 pull-right"<?php }else{ ?>class="badge badge-info pull-right"<?php } ?>><?php echo($getTotalnormalVendor)?></span> Vendor Management</a>
	</li>
        
       
        <li <?php if($this->params['controller']=='banners')
        {?>class="active"<?php } ?>><a href="<?php echo($this->webroot)?>admin/banners/list">
            <?php if($this->params['controller']=='banners')
        {?><i class="icon-chevron-right"></i><?php } ?> Banner Management</a>
	</li>
       
        
	<li <?php if($this->params['controller']=='categories' && $this->params['action']=='admin_add')
        {?>class="active"<?php } ?>><a href="<?php echo($this->webroot)?>admin/categories/add"><?php if($this->params['controller']=='categories')
         { ?><i class="icon-chevron-right"></i><?php } ?> Add Category</a>
	</li>
	
	<li <?php if($this->params['controller']=='categories' && $this->params['action']=='admin_index')
        {?>class="active"<?php } ?>><a href="<?php echo($this->webroot)?>admin/categories/"><?php if($this->params['controller']=='categories')
         { ?><i class="icon-chevron-right"></i><?php } ?> Category Management</a>
	</li>
        
        <li <?php if($this->params['controller']=='coupons')
        {?>class="active"<?php } ?>><a href="<?php echo($this->webroot)?>admin/coupons/"><?php if($this->params['controller']=='coupons'){ ?><i class="icon-chevron-right"></i><?php } ?> Coupon Management</a>
	</li>
        
        
       
        
        
        
    <li <?php if($this->params['controller']=='products' && $this->params['action']=='admin_add')
        {?>class="active"<?php } ?>><a href="<?php echo($this->webroot)?>admin/products/add"><?php if($this->params['controller']=='products' && $this->params['action']=='admin_add')
         { ?><i class="icon-chevron-right"></i><?php } ?> Add Product</a>
	</li>
	
	<li <?php if($this->params['controller']=='products' && $this->params['action']=='admin_index')
        {?>class="active"<?php } ?>><a href="<?php echo($this->webroot)?>admin/products/"><?php if($this->params['controller']=='products' && $this->params['action']=='admin_index')
         { ?><i class="icon-chevron-right"></i><?php } ?> Product Management</a>
	</li>
        <!--spandan-->
        <!--end-->
        <li <?php if($this->params['controller']=='orders' && $this->params['action']=='admin_order_list' && $pass_data_str=='')
        {?>class="active"<?php } ?>><a href="<?php echo($this->webroot)?>admin/orders/order_list"><?php if($this->params['controller']=='orders' && $pass_data_str==''){ ?><i class="icon-chevron-right"></i><?php } ?> Order Management</a>
	</li>
	
     
      <li <?php if($this->params['controller']=='email_templates')
        {?>class="active"<?php } ?>><a href="<?php echo($this->webroot)?>admin/email_templates/"><?php if($this->params['controller']=='email_templates')
        {?><i class="icon-chevron-right"></i><?php } ?> Mail Template Management</a>
	</li>
	<li <?php if($this->params['controller']=='contents')
        {?>class="active"<?php } ?>><a href="<?php echo($this->webroot)?>admin/contents/"><?php if($this->params['controller']=='contents')
        {?><i class="icon-chevron-right"></i><?php } ?> Content Management</a>
	</li>
        <!--spandan 4/10-->
        <!-- <li <?php if($this->params['controller']=='advertises')
        {?>class="active"<?php } ?>><a href="<?php echo($this->webroot)?>admin/advertises/list">
            <?php if($this->params['controller']=='advertises')
        {?><i class="icon-chevron-right"></i><?php } ?> Advertise Management</a>
	</li> -->
        <!--end-->
        
	<li>
		<a href="<?php echo($this->webroot)?>admin/users/logout">Logout</a>
	</li>
</ul>
</div>
<style>
.showall { display:none;}
</style>
