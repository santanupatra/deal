<?php $params = $this->params['pass'][0];?>
<section class="signup">
		<div class="container">
			<div class="logo_signup"><a href="<?php echo($this->webroot);?>"><img src="<?php echo($this->webroot);?>images/logo.png" alt="TWOP" /></a></div>
			<div class="login_tab">
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" <?php if($params=='login'){ ?>class="active" <?php } ?> ><a href="#Sign" aria-controls="Sign" role="tab" data-toggle="tab">Sign In</a></li>
						    <li role="presentation" <?php if($params=='signup'){ ?>class="active" <?php } ?>><a href="#Create" aria-controls="Create" role="tab" data-toggle="tab">Register</a></li>
						    
						</ul>

						  <div class="tab-content">
						    <div role="tabpanel" class="tab-pane <?php if($params=='signup'){ ?>active<?php } ?>" id="Create">
						    	<form method="POST" action="<?php echo($this->webroot)?>users/signin">
								  <div class="form-group has-feedback">
									  <input type="email" class="form-control" id="signupemail" aria-describedby="inputSuccess2Status" placeholder="Email" required name="data[User][email]">
								  </div>
								  <div class="form-group has-feedback">
									  <div class="row">
									  <div class="col-md-6"><input type="text" class="form-control" id="signupfirst_name" aria-describedby="inputSuccess2Status" placeholder="First Name" required name="data[User][first_name]"></div>
									  <div class="col-md-6"><input type="text" class="form-control" id="signuplast_name" aria-describedby="inputSuccess2Status" placeholder="Last Name" required name="data[User][last_name]"></div>
									  	
									  </div>
								  </div>
								 
								  <div class="form-group has-feedback">
									  <input type="password" class="form-control" id="signuppassword" aria-describedby="inputSuccess2Status" placeholder="Password" required name="data[User][password]">
									  
									  
								  </div>
								  <div class="form-group has-feedback">
									  <input type="password" class="form-control" id="signuprepassword" aria-describedby="inputSuccess2Status" placeholder="Confirm Password" required name="data[User][repassword]">
									  
									  
								  </div>
								  <div class="form-group has-feedback">
									  <input type="text" class="form-control" id="signupcompany_name" aria-describedby="inputSuccess2Status" placeholder="Company Name" required name="data[User][company_name]">
									  
									  
								  </div>
								  <div class="form-group has-feedback">
									  <input type="text" class="form-control" id="signupmobile_number" aria-describedby="inputSuccess2Status" placeholder="Mobile Phone" required name="data[User][mobile_number]">
									 <!--<div class="country">
									 	<img src="images/us.png" alt="" />
									 </div>-->
									  
								  </div>
								  <div class="form-group">
								  	<div class="checkbox">
								    <label>
								      <input type="checkbox" required>I agree to the terms & conditions
								    </label>
								  </div>
								  </div>
								  
								  
								 
								  <button class="effect_red">register</button>
								</form>
						    </div>
						    <div role="tabpanel" class="tab-pane <?php if($params=='login'){ ?>active<?php } ?>" id="Sign">
							<form method="POST" action="<?php echo($this->webroot)?>users/login">
								<div class="form-group has-feedback">
								<input type="email" class="form-control" name="data[User][email]" id="loginemail" aria-describedby="inputSuccess2Status" placeholder="Email" required>

								</div>
								<div class="form-group has-feedback">
								<input type="password" class="form-control" name="data[User][password]" id="loginpassword" aria-describedby="inputSuccess2Status" placeholder="Password" required>


								</div>
								<div class="form-group">
								<div class="col-md-6 login">
									<div class="checkbox">
										<label>
										<input type="checkbox">Stay Logged in
										</label>
									</div>
								</div>
								<div class="col-md-6 login">
									<div class="checkbox checkboxright">
										<a href="<?php echo($this->webroot)?>users/forgot_password">Forgot Password</a>
									</div>
								</div>
								</div>
								<button class="effect_red">Login</button>
							</form>
						    </div>
						  </div>
					</div>
		</div>
	</section>
<script type="text/javascript">
window.onload = function () {
    document.getElementById("signuppassword").onchange = validatePassword;
    document.getElementById("signuprepassword").onchange = validatePassword;
}
function validatePassword(){
var pass2=document.getElementById("signuprepassword").value;
var pass1=document.getElementById("signuppassword").value;
if(pass1!=pass2)
    document.getElementById("signuprepassword").setCustomValidity("Passwords Don't Match");
else
    document.getElementById("signuprepassword").setCustomValidity('');  
//empty string means no validation error
}

</script>
<style>
.login{
	padding-left: 2px !important;
	padding-right: 2px !important;
}
.checkboxright{
	text-align:right;
}
</style>
