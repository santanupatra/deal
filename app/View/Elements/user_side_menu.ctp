<?php

$pass_data=$this->params['pass'];

if(count($pass_data)>0){
    $pass_data_str=isset($pass_data[0])?$pass_data[0]:'';
}else{
    $pass_data_str='';
}
?>



<div class="col-lg-3 col-12 side-bar">
                      
    <div class="side-bar-menu">
        <ul>
            
           <li <?php if($this->params['controller']=='users' && $this->params['action']=='dashboard')
        {?> class="active" <?php } ?>>
                            <a href="<?php echo($this->webroot);?>users/dashboard"><i class="fa fa-fw fa-user"></i>My Dashboard<span class="fa arrow"></span></a>
                        </li>
                        
                        <li <?php if($this->params['controller']=='users' && $this->params['action']=='change_password')
        {?> class="active" <?php } ?>>
                            <a href="<?php echo($this->webroot);?>users/change_password"><i class="fa fa-fw fa-cog"></i> Change Password<span class="fa arrow"></span></a>
                        </li>
                        
                        
                        
                       
                        <li <?php if($this->params['controller']=='products' && $this->params['action']=='purchase_history')
        {?> class="active" <?php } ?>>
                            <a href="<?php echo($this->webroot);?>products/purchase_history"><i class="fa fa-fw fa-shopping-bag"></i> Purchase History</a>
                        </li>
<!--                        <li <?php if($this->params['controller']=='products' && $this->params['action']=='wish_list')
        {?> class="active" <?php } ?>>
                            <a href="<?php echo($this->webroot);?>products/wish_list"><i class="fa fa-fw fa-heart"></i> Wish List</a>
                        </li>-->
                        
            
        </ul>

    </div>
</div>
















<!--<div class="col-lg-3 col-12 side-bar">
                      <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#sidebar-menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">Dashboard Dropdown</button>
                      <div class="collapse navbar-collapse nav-side" id="sidebar-menu">
                        <ul class="navbar-nav p-2">
                           
                            
                          
                        
                        </ul>
                      </div>
                  </div>-->