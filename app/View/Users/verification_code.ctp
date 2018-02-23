<?php ?>

<section class="signup">
        <div class="container">
            <div class="logo_signup"><a href="<?php echo($this->webroot);?>"><img src="<?php echo($this->webroot);?>images/logo.png" alt="TWOP" /></a></div>
            <div class="login_tab">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#Sign" aria-controls="Sign" role="tab" data-toggle="tab">Verification Code</a></li>
                </ul>

                <div class="tab-content">

                    <div role="tabpanel" class="tab-pane active" id="Sign">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success">
                                    <p>Please check your email to get OTP.</p>
                                </div>
                            </div>    
                        </div>
                        <form method="POST" action="">
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control" name="data[User][verification_code]" placeholder="Enter your OTP" required>

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
