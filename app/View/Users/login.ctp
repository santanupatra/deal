  <section class="py-5">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-4">
                    <h2>Sign in</h2>
                    <h5 class=" mt-4">Don’t have account? <a href="<?php echo($this->webroot);?>users/registration" class="text-pink">Register Now!</a></h5>
                    <form class="mt-4" method="post" action="<?php echo $this->webroot; ?>users/login" id="frmLogin">
                        <div class="form-group">
                            <input type="text" name="data[User][email]" class="form-control" placeholder="Enter your email address">
                        </div>
                        <div class="form-group">
                            <input type="password" name="data[User][password]" class="form-control" placeholder="Enter your password">
                        </div>
                        <div class="form-group overflow-hidden">
                            <label class="float-left">
                                <input type="checkbox">
                                Remember me
                            </label>
                            <a href="<?php echo($this->webroot);?>users/forgot_password" class="text-pink float-right">Forgot  password?</a>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary btn-block btn-lg">GET STARTED</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-1">
                    <h5 class="font-weight-bold text-center">OR</h5>
                </div>
                <div class="col-lg-5 mt-4">
                    <div class="p-5 social-box">
                        <h5>Sign in with Social Media</h5>
                        <p>Connect Wedshopping through your Social account</p>
                        <div class="form-group">
                            <a class="btn btn-block btn-fb flogin"><i class="fa fa-facebook-official"></i> Login with Facebook</a>
                        </div>
                        <div class="form-group">
                            <a href="<?php echo $this->webroot ?>users/twitterlogin" class="btn btn-block btn-twiter"><i class="fa fa-twitter"></i> Login with Twitter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!--   footer   -->
    
    

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