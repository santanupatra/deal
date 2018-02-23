<?php ?>
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
			 <span class="icon-bar"></span>
			 <span class="icon-bar"></span>
			</a>
<a href="<?php echo $this->webroot;?>admin/users/dashboard"><?php if(isset($sitesetting['SiteSetting']['site_logo']) && $sitesetting['SiteSetting']['site_logo']!=''){ ?><img src="<?php echo $this->webroot; ?>site_logo/<?php echo $sitesetting['SiteSetting']['site_logo'];?>" style="height:25px; margin-top:9px;"><?php }else{ ?><img src="<?php echo $this->webroot; ?>images/logo.png" style="height:25px;margin-top:9px;"><?php } ?></a>
				<ul class="nav pull-right">
					<li class="dropdown">
						<a href="javascript:void(0)" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i>&nbsp;&nbsp;Welcome Admin&nbsp;&nbsp;<i class="caret"></i>
						</a>
						<ul class="dropdown-menu">
							<li>
								<a tabindex="-1" href="<?php echo($this->webroot)?>admin/users/edit/<?php echo((isset($userid) && $userid!='')?$userid:'');?>">Edit Profile</a>
							</li>
							<li class="divider"></li>
							<li>
								<a tabindex="-1" href="<?php echo($this->webroot)?>admin/users/logout">Logout</a>
							</li>
						</ul>
					</li>
				</ul>
				<ul class="nav pull-right">
					
					<!--<li <?php if($this->params['controller']=='site_settings' && $this->params['action']=='admin_edit')
        {?>class="active"<?php } ?>>
						<a href="<?php echo($this->webroot)?>admin/site_settings/edit/1">Settings
						</a>
					</li>
					<li class="dropdown <?php if($this->params['controller']=='users' && $this->params['action']!='admin_dashboard'){echo 'active';} ?>">
						<a href="javascript:void(0)" role="button" class="dropdown-toggle" data-toggle="dropdown">Admin <i class="caret"></i>

						</a>
						<ul class="dropdown-menu">
							<li>
								<a tabindex="-1" href="<?php echo($this->webroot)?>admin/users/list">Admin List</a>
							</li>
						</ul>
					</li>-->
					<li class="dropdown <?php if($this->params['controller']=='site_settings'){echo 'active';} ?>">
						<a href="javascript:void(0)" role="button" class="dropdown-toggle" data-toggle="dropdown">Settings <i class="caret"></i>

						</a>
						<ul class="dropdown-menu">
							<li>
								<a tabindex="-1" href="<?php echo($this->webroot)?>admin/site_settings/edit/1">Site Settings</a>
							</li>
							<li>
								<a tabindex="-1" href="<?php echo($this->webroot)?>admin/site_settings/sitelogo/1">Manage Logo</a>
							</li>
							<li>
								<a tabindex="-1" href="<?php echo($this->webroot)?>admin/site_settings/sociallink/1">Site Social Link</a>
							</li>						
							
						</ul>
					</li>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</div>
</div>
