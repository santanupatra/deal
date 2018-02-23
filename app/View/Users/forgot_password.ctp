  <section class="py-5">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-4">
                    
                    <h5 class=" mt-4 text-pink float-left">Forgot password?</h5>
                    <form class="mt-4" method="post" action="<?php echo $this->webroot; ?>users/forgot_password" id="frmLogin">
                        <div class="form-group">
                            <input type="text" name="data[User][forgotemail]" class="form-control" placeholder="Enter your email address">
                        </div>
                        
                       
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary btn-block btn-lg">SEND</button>
                        </div>
                    </form>
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
               
        },
        messages: {           
          'data[User][email]': "Please enter username Or email", 
                    
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
   