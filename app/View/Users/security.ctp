<?php ?>
<section class="after_login">
	<div class="container">
		<div class="row">
			<?php echo($this->element('user_leftbar'));?>
			<div class="col-md-9">
					<div class="product_title">
						<div class="row">
							<div class="col-md-12">
								<h4>Settings</h4>
							</div>
							<div class="col-md-12">
								<div class="dash_middle_sec sequirity_info">
									<h4>Change Email Address</h4>
									<form class="form-horizontal" method="POST" action="<?php echo($this->webroot)?>users/update_email">
									  <h5>Please input a new email address below. It will be used for</h5>
									  <!--<div class="form-group">
									  	<div class="col-sm-10">
									  	<p class="text-muted">1. Account login</p>
									  	<p class="text-muted">2. Receive member messages</p>
									  	</div>
									  </div>-->
									  <div class="form-group">
									    <label for="inputEmail3" class="col-sm-4 control-label">Current Registered Email:</label>
									    <div class="col-sm-6">
									      <p class="text-muted"><?php echo($user['User']['email']);?></p>
									    </div>
									  </div>
									  <div class="form-group">
									    <label for="inputEmail3" class="col-sm-4 control-label">New email address<span>*</span></label>
									    <div class="col-sm-6">
									      <input type="email" class="form-control" id="new_email" value="<?php echo((isset($this->request->data['User']['new_email']) && $this->request->data['User']['new_email']!='')?$this->request->data['User']['new_email']:'');?>" name="data[User][new_email]" required placeholder="New email address">
									    </div>
									  </div>
									  
									  <div class="form-group">
									    <label for="inputPassword3" class="col-sm-4 control-label">Re-enter email address<span>*</span></label>
									    <div class="col-sm-6">
									      <input type="email" class="form-control" id="re_enter_email" value="<?php echo((isset($this->request->data['User']['re_enter_email']) && $this->request->data['User']['re_enter_email']!='')?$this->request->data['User']['re_enter_email']:'');?>" name="data[User][re_enter_email]" required placeholder="Re-enter email address">
									    </div>
									  </div>
									  <div class="form-group">
									    <div class="col-sm-offset-4 col-sm-6">
									      <button type="submit" class="btn btn-default active">Confirm</button>
									      <button type="button" class="btn btn-default">Cancel</button>
									    </div>
									  </div>
									 </form>
									  <br/><br/>
									  
									  
									  <h4>Change Password</h4><br/>
										<form class="form-horizontal" method="POST" action="">
										  
										  <div class="form-group">
										    <label for="inputEmail3" class="col-sm-4 control-label">Current Password<span>*</span></label>
										    <div class="col-sm-6">
										      <input type="password" class="form-control" id="current_password" value="" name="data[User][current_password]" required placeholder="Current Password">
										    </div>
										  </div>
										  
										  <div class="form-group">
										    <label for="inputPassword3" class="col-sm-4 control-label">New Password<span>*</span></label>
										    <div class="col-sm-6">
										      <input type="password" class="form-control" id="new_password" value="" name="data[User][new_password]" required placeholder="New Password">
										    </div>
										  </div>
										  <div class="form-group">
										    <label for="inputPassword3" class="col-sm-4 control-label">Re-enter Password<span>*</span></label>
										    <div class="col-sm-6">
										      <input type="password" class="form-control" id="re_enter_password" value="" name="data[User][re_enter_password]" required placeholder="Re-enter Password">
										    </div>
										  </div>
										  <div class="form-group">
										    <div class="col-sm-offset-4 col-sm-6">
										      <button type="submit" class="btn btn-default active">Confirm</button>
										      <button type="button" class="btn btn-default">Cancel</button>
										    </div>
										  </div>
										</form>
								</div>
							</div>
						</div>
					</div>



				
			</div>
		</div>
		
	</div>
</section>
<script type="text/javascript">
window.onload = function () {
    document.getElementById("new_email").onchange = validateEmail;
    document.getElementById("re_enter_email").onchange = validateEmail;
}
function validateEmail(){
var email2=document.getElementById("re_enter_email").value;
var email1=document.getElementById("new_email").value;
if(email1!=email2)
    document.getElementById("re_enter_email").setCustomValidity("Emails Don't Match");
else
    document.getElementById("re_enter_email").setCustomValidity('');  
//empty string means no validation error
}

window.onload = function () {
    document.getElementById("new_password").onchange = validatePassword;
    document.getElementById("re_enter_password").onchange = validatePassword;
}
function validatePassword(){
var pass2=document.getElementById("re_enter_password").value;
var pass1=document.getElementById("new_password").value;
if(pass1!=pass2)
    document.getElementById("re_enter_password").setCustomValidity("Passwords Don't Match");
else
    document.getElementById("re_enter_password").setCustomValidity('');  
//empty string means no validation error
}

</script>
<style>
.profile_box p a{
	color:#fff;
}
</style>
