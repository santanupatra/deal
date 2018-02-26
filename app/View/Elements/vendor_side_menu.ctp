
<div class="col-lg-3 col-12 side-bar">
                      
    <div class="side-bar-menu">
        <ul>
          <li>
                            <a <?php if($this->params['controller']=='users' && $this->params['action']=='vendor_dashboard'){?> class="active" <?php } ?> href="<?php echo($this->webroot);?>users/vendor_dashboard"><i class="fa fa-fw fa-user"></i>My Dashboard<span class="fa arrow"></span></a>
                        </li>  
                            

                        <li>
                            <a <?php if($this->params['controller']=='users' && $this->params['action']=='vendor_change_password') {?> class="active" <?php } ?> href="<?php echo($this->webroot);?>users/vendor_change_password"><i class="fa fa-fw fa-lock"></i> Change Password</a>
                        </li>
                        
                        <li>
                            <a <?php if($this->params['controller']=='products' && $this->params['action']=='add')
        {?> class="active" <?php } ?> href="<?php echo($this->webroot);?>products/add"><i class="fa fa-fw fa-cube"></i> Add Deal</a>
                        </li>
                            <li>
                            <a <?php if($this->params['controller']=='products' && $this->params['action']=='index')
        {?> class="active" <?php } ?> href="<?php echo($this->webroot);?>products/"><i class="fa fa-fw fa-cube"></i> Deal List</a>
                        </li>
                        <li>
                            <a <?php if($this->params['controller']=='coupons' && $this->params['action']=='add') {?> class="active" <?php } ?> href="<?php echo($this->webroot);?>coupons/add"><i class="fa fa-fw fa-cube"></i> Add coupons</a>
                        </li>
                        <li>
                            <a <?php if($this->params['controller']=='coupons' && $this->params['action']=='index'){?> class="active" <?php } ?> href="<?php echo($this->webroot);?>coupons/"><i class="fa fa-fw fa-cube"></i>coupons List</a>
                        </li>
                        
                        <li>
                            <a <?php if($this->params['controller']=='products' && $this->params['action']=='order_list'){?> class="active" <?php } ?> href="<?php echo($this->webroot);?>products/order_list"><i class="fa fa-fw fa-cube"></i> My Order</a>
                        </li> 
                        
                        
                        <li>
                            <a <?php if($this->params['controller']=='packages' && $this->params['action']=='wallet_details'){?> class="active" <?php } ?> href="<?php echo($this->webroot);?>packages/wallet_details"><i class="fa fa-fw fa-cube"></i> My Wallet</a>
                        </li>
                        
                        
                        
        </ul>
    </div>
</div>
    
                      
<!--                      <div class="collapse navbar-collapse nav-side" id="sidebar-menu">
                        <ul class="navbar-nav p-2">
                          
<button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#sidebar-menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">Dashboard Dropdown</button>
                        
                        
                        </ul>
                      </div>
                  </div>-->