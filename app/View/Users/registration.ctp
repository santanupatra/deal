 

<div class="clearfix"></div>

  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <ol class="breadcrumb p-2 rounded-0">
          <li class="breadcrumb-item"><a href="index.html">
            <i class="fa fa-home"></i>
          </a></li>          
          <li class="breadcrumb-item"><a href="login.html">Log In</a></li>
          <li class="breadcrumb-item active">Registration</li>
        </ol>
      </div>
    </div>
  </div>

  <section class="login-section">
    <div class="container">
        <form class="mt-4" method="post" action="<?php echo($this->webroot);?>users/registration" id="frmRegister" name="frmRegister">
      <div class="row">
          
        <div class="col-lg-6 col-xs-12 col-sm-8 col-md-6">
          <div class="login-form mt-sm-5 mb-sm-5">
            
              <fieldset>
                <h2>Your Personal Details</h2>
                <hr class="colorgraph">

                <div class="form-group">
                  <div class="row">
                    <div class="col-lg-6">
                      <label for="n">First Name</label>
                      <input type="text" name="data[User][first_name]" id="n" class="form-control form-control-sm input-sm rounded-0" placeholder="Enter name . . .">

                    </div>

                    <div class="col-lg-6">
                        <label for="email">Last Name</label>
                       <input type="text" class="form-control form-control-sm input-sm rounded-0"  name="data[User][last_name]" placeholder="Last name here">                          
                    </div>
                  </div>
                </div>

               <div class="form-group">
                  <label for="t">Email</label>
                  <input type="email" name="data[User][email]" id="email" class="form-control form-control-sm input-sm rounded-0" 
                  placeholder="Type Contacts...">
                </div>

                <h2>Your Password</h2>

                <div class="form-group">
                  <div class="row">
                    <div class="col-lg-6">
                      <label for="pp">Password</label>
                      <input type="password" name="data[User][password]" id="password" class="form-control form-control-sm input-sm rounded-0" 
                      placeholder="Enter password . . .">
                    </div>

                    <div class="col-lg-6">
                        <label for="cp">Confirm</label>
                        <input type="password" name="data[User][con_password]" id="con_password" class="form-control form-control-sm input-sm rounded-0" 
                        placeholder="Confirm password . . .">                            
                    </div>
                  </div>
                </div>
                <p class="list-h1"></p>
                <hr class="colorgraph">

                <div class="row">
                  
                  <div class="col-xs-6 col-sm-6 col-md-6">
                    <input type="submit" class="btn btn-sm bg-dark text-white btn-block rounded-0" value="Register">
                  </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">

                  </div>
                </div> 
                                  
              </fieldset>
            
          </div>
        </div>

        <div class="col-lg-6 col-xs-12 col-sm-8 col-md-6">
          <div class="login-form mt-sm-5 mb-sm-5">
            
              <fieldset>
                <h2>Your Address</h2>
                <hr class="colorgraph">

                <div class="form-group">
                  <div class="row">
                    <div class="col-lg-6">
                      <label for="ad">Address</label>
                      <input type="text" name="data[User][address]" id="ad" class="form-control form-control-sm input-sm rounded-0" 
                      placeholder="Enter address . . .">
                    </div>

                    <div class="col-lg-6">
                        <label for="ct">City</label>
                        <input type="text" name="data[User][city]" id="ct" class="form-control form-control-sm input-sm rounded-0" 
                        placeholder="Enter city . . .">                            
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="row">
                    <div class="col-lg-6">
                      <label for="pc">State</label>
                      <input type="text" name="data[User][state]" id="state" class="form-control form-control-sm input-sm rounded-0" placeholder="Enter code . . .">
                    </div>

                    <div class="col-lg-3">
                        <label for="ct">Country</label>
                        <input type="text" name="data[User][country]" id="country" class="form-control form-control-sm input-sm rounded-0" placeholder="Enter code . . .">                           
                    </div>

                    <div class="col-lg-3">
                        <label for="ct">Post Code</label>
                        <input type="text" name="data[User][zip_code]" id="zip_code" class="form-control form-control-sm input-sm rounded-0" placeholder="Enter code . . .">                           
                    </div>
                  </div>
                </div>
                
                <div class="form-check">
                <h2>User Type</h2>                    
                  <div class="row">
                    <div class="col-lg-4">
                      <h4 class="bg-light p-2"> Type </h4>  
                    </div>
                    <div class="col-lg-2">
                      <div class="pt-3">
                        <input class="form-check-input" type="radio" value="V" name="data[User][type]" checked>
                        <label class="form-check-label pl-1" for="rdo">Seller</label>   
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="pt-3">
                        <input class="form-check-input" type="radio" value="U" name="data[User][type]">
                        <label class="form-check-label pl-1" for="rdo1">User</label>   
                      </div>                        
                    </div>
                    <div class="col-lg-2 d-md-none d-sm-none d-xl-none"></div>
                  </div>
                </div>

                <div class="form-check">
                  <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-11">
                      <input class="form-check-input" type="checkbox" id="chk">
                      <label class="form-check-label pl-1" for="chk">
                        I have read & agree to the Privacy policy
                      </label>                          
                    </div>
                  </div>                    
                </div>
                <hr class="colorgraph mt-0">
              </fieldset>
           
          </div>
        </div>
         
      </div>
        </form>
    </div>
  </section>
  <div class="clearfix"></div>
   
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
          'data[User][address]': "required",
          'data[User][state]': "required",
          'data[User][city]': "required",
          'data[User][country]': "required",
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
          'data[User][address]': "Please enter your address",
          'data[User][state]': "Please enter your state",
          'data[User][city]': "Please enter city", 
          'data[User][country]': "Please enter country", 
          
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
    
