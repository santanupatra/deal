<?php ?>
<!--<section class="registration">
	<div class="left_registration">
		<h1>Forgot Password</h1>
		<h2> <a href="<?php echo $this->webroot.'users/login'?>">Sign In</a></h2>
		<form method="post" action="<?php echo $this->webroot.'users/forgotpassword'; ?>" id="forgotpass">
			<li>
				<p>Email Address</p>
				<input type="text" name="data[User][email]" id="email" class="text validate[required,custom[email]]" />
			</li>

			<li>
				&nbsp;
			</li>
			<li>
				<input type="submit" value="Continue"/>
			</li>

		</form>
	</div>
	<div class="or">
		OR
	</div>
	<div class="right_registration">
		<h2>Please Check your Email Addres after continue</h2>
		<p>Enter your Email and we will send you instruction to Reset your password.</p>
		
	</div>
</section>-->


<section class="signup">
		<div class="container">
			<div class="logo_signup"><a href="<?php echo($this->webroot);?>"><img src="<?php echo($this->webroot);?>images/logo.png" alt="TWOP" /></a></div>
			<div class="login_tab">
						<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#Sign" aria-controls="Sign" role="tab" data-toggle="tab">Forgot Password</a></li>
						    
						</ul>

						  <div class="tab-content">
						    
						    <div role="tabpanel" class="tab-pane active" id="Sign">
							<form method="POST" action="<?php echo($this->webroot)?>users/forgot_password">
								<div class="form-group has-feedback">
								<input type="email" class="form-control" name="data[User][forgotemail]" id="forgotemail" aria-describedby="inputSuccess2Status" placeholder="Email" required>

								</div>
								<div class="form-group">
								<div class="col-md-6">
									<div class="checkbox">
										<a href="<?php echo($this->webroot)?>users/signin">Back To Login</a>
									</div>
								</div>
								</div>
								<button class="effect_red">Submit</button>
							</form>
						    </div>
						  </div>
					</div>
		</div>
	</section>
<style>
.col-md-6{
	padding-left: 2px !important;
}
</style>
