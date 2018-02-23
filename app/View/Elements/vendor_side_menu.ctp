<div class="col-lg-3 col-12 side-bar">
                      <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#sidebar-menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">Dashboard Dropdown</button>
                      <div class="collapse navbar-collapse nav-side" id="sidebar-menu">
                        <ul class="navbar-nav p-2">
                          <li <?php if($this->params['controller']=='users' && $this->params['action']=='home')
        {?> class="active" <?php } ?>>
                            <a href="<?php echo($this->webroot);?>users/home"><i class="fa fa-fw fa-user"></i>My Dashboard<span class="fa arrow"></span></a>
                        </li>  
                            
                          <li <?php if($this->params['controller']=='users' && $this->params['action']=='vendor_dashboard')
        {?> class="active" <?php } ?>>
                            <a href="<?php echo($this->webroot);?>users/vendor_dashboard"><i class="fa fa-fw fa-user"></i> User Information<span class="fa arrow"></span></a>
                        </li>
                        <li <?php if($this->params['controller']=='users' && $this->params['action']=='vendor_change_password')
        {?> class="active" <?php } ?>>
                            <a href="<?php echo($this->webroot);?>users/vendor_change_password"><i class="fa fa-fw fa-cog"></i> Change Password</a>
                        </li>
                        
                        <li <?php if($this->params['controller']=='products' && $this->params['action']=='add')
        {?> class="active" <?php } ?>>
                            <a href="<?php echo($this->webroot);?>products/add"><i class="fa fa-fw ion-cube"></i> Add Product</a>
                        </li>
                            <li <?php if($this->params['controller']=='products' && $this->params['action']=='index')
        {?> class="active" <?php } ?>>
                            <a href="<?php echo($this->webroot);?>products/"><i class="fa fa-fw ion-cube"></i> Product List</a>
                        </li>
<!--                        <li <?php if($this->params['controller']=='coupons' && $this->params['action']=='add')
        {?> class="active" <?php } ?>>
                            <a href="<?php echo($this->webroot);?>coupons/add"><i class="fa fa-fw ion-cube"></i> Add coupons</a>
                        </li>
                        <li <?php if($this->params['controller']=='coupons' && $this->params['action']=='index')
        {?> class="active" <?php } ?>>
                            <a href="<?php echo($this->webroot);?>coupons/"><i class="fa fa-fw ion-cube"></i>coupons List</a>
                        </li>-->
                        <li <?php if($this->params['controller']=='shipping_addresses' && $this->params['action']=='shhipping_management_list')
        {?> class="active" <?php } ?>>
                            <a href="<?php echo($this->webroot);?>shipping_addresses/shhipping_management_list"><i class="fa fa-fw ion-cube"></i> Shipping Management</a>
                        </li>
                        <li <?php if($this->params['controller']=='products' && $this->params['action']=='order_list')
        {?> class="active" <?php } ?>>
                            <a href="<?php echo($this->webroot);?>products/order_list"><i class="fa fa-fw ion-cube"></i> My Order</a>
                        </li>
                        <li <?php if($this->params['controller']=='products' && $this->params['action']=='purchase_history')
        {?> class="active" <?php } ?>>
                            <a href="<?php echo($this->webroot);?>products/purchase_history"><i class="fa fa-fw ion-cube"></i> Purchase History</a>
                        </li>
                       <li <?php if($this->params['controller']=='products' && $this->params['action']=='wish_list')
        {?> class="active" <?php } ?>>
                            <a href="<?php echo($this->webroot);?>products/wish_list"><i class="fa fa-fw ion-cube"></i> Wish List</a>
                        </li>
                        
                        
                        </ul>
                      </div>
                  </div>