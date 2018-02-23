<body id="login">
 <div class="container">
   <form class="form-signin" name="UserAdminLoginForm" id="UserAdminLoginForm" action="<?php echo($this->webroot)?>admin/users/fotgot_password" method="post">
	 <center><a href="<?php echo $SITE_URL;?>"><?php if(isset($sitesetting['SiteSetting']['site_logo']) && $sitesetting['SiteSetting']['site_logo']!=''){ ?><img src="<?php echo $this->webroot; ?>site_logo/<?php echo $sitesetting['SiteSetting']['site_logo'];?>" style="margin-bottom:25px"><?php }else{ ?><img src="<?php echo $this->webroot; ?>images/logo.png" style="margin-bottom:25px"><?php } ?></a></center>
        <input type="email" class="input-block-level" placeholder="Email" name="data[User][email]" id="UserUsername" required/>
        <button class="btn btn-large btn-primary" type="submit">Submit</button>
		<p style="margin-top:10px"><a href="<?php echo($this->webroot)?>admin/users/login" id="forgot-password">Back To Login</a></p>
    </form>
 </div> 
<script src="<?php echo($this->webroot)?>admin_styles/vendors/jquery-1.9.1.min.js"></script>
<script src="<?php echo($this->webroot)?>admin_styles/bootstrap/js/bootstrap.min.js"></script>
</body>
