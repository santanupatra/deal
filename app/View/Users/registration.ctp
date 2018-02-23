
    
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-5 col-sign-up">
                    <h2>Sign Up</h2>
                    <h5 class=" mt-4">Already have account? <a href="<?php echo($this->webroot);?>users/login" class="text-pink">Log In</a></h5>
            <form class="mt-4" method="post" action="<?php echo($this->webroot);?>users/registration" id="frmRegister" name="frmRegister">
<!--                        <div class="form-group">
                            <label>User Type</label>
                            <span class="star">*</span>
                            <select class="form-control" name="data[User][type]" >
                                <option value="">select</option>
                                <option value="V"> Vendor </option>
                                <option value="C"> Buyer </option>
                            </select>
                        </div>-->
                        <div class="form-group">
                            <label>First Name</label>
                            <span class="star">*</span>
                            <input type="text" class="form-control" name="data[User][first_name]" placeholder="First name here">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <span class="star">*</span>
                            <input type="text" class="form-control"  name="data[User][last_name]" placeholder="Last name here">
                        </div>
<!--                        <div class="form-group">
                            <label>Phone No</label>
                            <span class="star">*</span>
                            <input type="text" class="form-control" name="data[User][mobile_number]" placeholder="Phone no here">
                        </div>-->
                        <div class="form-group">
                            <label>Email Id</label>
                            <span class="star">*</span>
                            <input type="email" class="form-control" name="data[User][email]" placeholder="Email id here">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <span class="star">*</span>
                            <input type="password" class="form-control"  name="data[User][password]" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control"  name="data[User][con_password]" placeholder="Re-type password">
                        </div>
                        <div class="form-group">
                   <span class="star star-bottom">* fields are mandetory</span>
                 </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary btn-block btn-lg text-uppercase">Sign up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <!--   footer   -->
    <script type="text/javascript">
    $( document ).ready( function () {
//alert('ok');
    $( "#frmRegister" ).validate({
        //alert('ok');
        rules: {
          'data[User][first_name]': "required",
          'data[User][last_name]': "required",
          'data[User][mobile_number]': "required",
          'data[User][email]': {
            required: true           
          },
          'data[User][type]': "required",          
          'data[User][password]': {
            required: true,
            minlength: 6
          },
          'data[User][con_password]': {
            required: true,
            minlength: 6
          }
          
        },
        messages: {
          'data[User][first_name]': "Please enter your firstname",
          'data[User][last_name]': "Please enter your lastname",
          'data[User][email]': "Please enter a valid email address", 
          'data[User][mobile_number]': "Please enter a valid mobileno.", 
          'data[User][type]': "Please select user type",           
          'data[User][password]': {
            required: "Please provide a password",
            minlength: "Your password must be at least 6 characters long"
          },
          'data[User][con_password]': {
            required: "Please re-type  password",
            minlength: "Your password must be same as above password"
          }
        },
        
        //highlight: function ( element, errorClass, validClass ) {
          //$( element ).parents( ".col-lg-5" ).addClass( "has-error" ).removeClass( "has-success" );
       //},
        //unhighlight: function (element, errorClass, validClass) {
         // $( element ).parents( ".col-lg-5" ).addClass( "has-success" ).removeClass( "has-error" );
        //}
      });

    });


</script>
    
