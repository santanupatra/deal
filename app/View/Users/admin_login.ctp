<body id="login">
 <div class="container">
   <form class="form-signin" name="UserAdminLoginForm" id="UserAdminLoginForm" action="<?php echo($this->webroot)?>admin/users/login" method="post">
	 <center><a href="<?php echo $SITE_URL;?>"><?php if(isset($sitesetting['SiteSetting']['site_logo']) && $sitesetting['SiteSetting']['site_logo']!=''){ ?><img src="<?php echo $this->webroot; ?>site_logo/<?php echo $sitesetting['SiteSetting']['site_logo'];?>" style="margin-bottom:25px"><?php }else{ ?><img src="<?php echo $this->webroot; ?>images/logo.png" style="margin-bottom:25px"><?php } ?></a></center>
        <input type="email" class="input-block-level" placeholder="Email" name="data[User][email]" id="UserUsername" required/>
        <input type="password" class="input-block-level" placeholder="Password" name="data[User][password]" id="UserPassword" required/>
		<?php
		//echo $this->Html->image($this->Html->url(array('controller'=>'users', 'action'=>'captcha'), true),array('id'=>'img-captcha','vspace'=>2));
		//echo '<p><a href="#" id="a-reload">Can\'t read? Reload</a></p>';
		//echo '<p>Enter security code shown above:</p>';
		//echo $this->Form->input('User.captcha',array('autocomplete'=>'off','label'=>false,'class'=>'','div'=>false, 'required' =>'required'));
		?>
        <button class="btn btn-large btn-primary" type="submit">Log In</button>
		<p style="margin-top:10px"><a href="<?php echo($this->webroot)?>admin/users/fotgot_password" id="forgot-password">Forgot Password?</a></p>
    </form>
 </div> 
<script src="<?php echo($this->webroot)?>admin_styles/vendors/jquery-1.9.1.min.js"></script>
<script src="<?php echo($this->webroot)?>admin_styles/bootstrap/js/bootstrap.min.js"></script>
</body>
<script>
$('#a-reload').click(function() {
    var $captcha = $("#img-captcha");
    $captcha.attr('src', $captcha.attr('src')+'?'+Math.random());
    return false;
});
</script>
