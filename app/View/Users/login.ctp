   <div class="clearfix"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <ol class="breadcrumb p-2 rounded-0">
            <li class="breadcrumb-item"><a href="index.html">
              <i class="fa fa-home"></i>
            </a></li>          
            <li class="breadcrumb-item active">Log In</li>
            <li class="breadcrumb-item"><a href="res.html">Registration</a></li>
          </ol>
        </div>
      </div>
    </div>

    <section class="login-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 col-xs-12 col-sm-8 col-md-6">
            <div class="login-form mt-sm-5 mb-sm-2">
              <form class="mt-4" method="post" action="<?php echo $this->webroot; ?>users/login" id="frmLogin">
                <fieldset>
                  <h2>Please Sign In</h2>
                  <hr class="colorgraph">
                  <div class="form-group">
                    <label for="email">Enter Email</label>
                    <input type="text" name="data[User][email]" class="form-control form-control-sm input-sm rounded-0" placeholder="Enter your email address">                   
                  </div>
                  <div class="form-group">
                    <label for="email">Enter Password</label>                    
                     <input type="password" name="data[User][password]" class="form-control form-control-sm input-sm rounded-0" placeholder="Enter your password">
                  </div>
                  
                  <div class="form-group">
                    <div class="row">
                      <div class="col-lg-6">
                        <a href="#">
                          <div class="bg-primary text-white text-md-center text-capitalize p-md-2 w-100">
                             <i class="fa fa-facebook fa-1x pr-2"></i> Also Login with Facebook
                          </div>
                        </a>
                      </div>

                      <div class="col-lg-6">
                        <a href="#">
                          <div class="bg-info text-white text-md-center text-capitalize p-md-2 w-100">
                             <a href="<?php echo $this->webroot ?>users/twitterlogin"><i class="fa fa-twitter fa-1x pr-2"></i> Also Login with Twitter</a>
                          </div>
                        </a>
                      </div>

                    </div>
                  </div>

                  <span class="button-checkbox">
                    <button type="button" class="btn btn-sm rounded-0 bg-info text-white">
                      <i class="fa fa-check-square-o"></i> Remember Me</button>
                    <a href="<?php echo($this->webroot);?>users/forgot_password" class="btn btn-link btn-sm pull-right">Forgot Password?</a>
                  </span>
                  <hr class="colorgraph">
                  <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <input type="submit" class="btn btn-sm bg-light btn-block rounded-0" value="Log In">
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">                      
                      <input type="button" class="btn btn-sm bg-dark text-white btn-block rounded-0" value="Register">
                    </div>
                  </div>
                </fieldset>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="clearfix"></div>

    <!-- Optional JavaScript -->
    
    <script type="text/javascript">
    $( document ).ready( function () {

    $( "#frmLogin" ).validate( {
        rules: {          
          'data[User][email]': "required",
          'data[User][password]': "required"          
        },
        messages: {           
          'data[User][email]': "Please enter username Or email", 
          'data[User][password]': "Please enter password"          
        },
        
        highlight: function ( element, errorClass, validClass ) {
          $( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
          $( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
        }
      } );
    } );
</script>
 <script>


 /*************** Sign Up Facebook ***********************/
            $.getScript('//connect.facebook.net/en_US/all.js', function(){
                FB.init({ appId: '142000989862434'});    
                $(".flogin").on("click", function(e){ 
                    
                    
                 e.preventDefault();    
                 FB.login(function(response){
                  // FB Login Failed //
                  if(!response || response.status !== 'connected') {
                   alert("Given account information are not authorised", "Facebook says");
                  }else{
                   // FB Login Successfull //
                   FB.api('/me',{fields: ['email','name']}, function(fbdata){ 
                   //alert(fbdata) ;    
                   //console.log(fbdata); 
                   var name1 = fbdata.name;
                   var name = name1.split(' ');
                    var fb_user_id = fbdata.id;      
                    var fb_first_name = name[0];
                    var fb_last_name = name[1];
                    var fb_email = fbdata.email;
                    var fb_username = fbdata.username;
                    //fb_usertype = 'S';
                   
                    //alert(fb_email);
                    
                    //console.log(fb_email);
                    
                    $.ajax({
                            url: '<?php echo $this->webroot; ?>users/fblogin',
                            dataType: 'json',
                            type: 'post',
                            data: {"data" : {"User" : {"email" : fb_email,  "first_name" : fb_first_name, "last_name" : fb_last_name, "facebook_id" : fb_user_id, "is_active" : 1,"is_admin" : 0 }}},
                            success: function(data){ 
                                if(data.status)
                                {
                                    window.location = data.url;
                                    //$(this).closest('form').find("input[type=text]").val("");
                                    //showSuccess('Registration successfull.');
                                     //$('.email_error').hide();
                                    //$('.sign-up-btn').removeAttr('disabled');
                                }  
                                else
                                {
                                    window.location = '';
                                    //showError(data.message);
                                    //showError('Internal Error. Please try again later.');
                                   // $('.email_error').show();
                                    //$('.sign-up-btn').attr('disabled','disabled');
                                }
                            }
                    });
                   

                   })
                  }
                 }, {scope:"email"});
                 
                 
                  });


                  
               });
               
     
</script>  