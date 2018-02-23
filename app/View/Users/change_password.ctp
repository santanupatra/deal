
    <!--  my account  -->
    
    <section class="pt-5 pb-5">
          <div class="container">
              <div class="row">
                  <?php echo ($this->element('user_side_menu'));?>
                  <div class="col-lg-9 col-12">
                      <div class="right-side p-3">
                          <h2 class="text-pink">Change Password</h2>
                          <div class="row">
                              <div class="col-lg-7 col-12">
                                  <form class="form-area" method="post" action="<?php echo $this->webroot; ?>users/change_password" id="frmEdit">
                                      
                                      
                                      
                                      
                                      <div class="form-group">
                                          <label>Current Password</label>
                                          <input type="password" name="data[User][current_password]" class="form-control" placeholder="">
                                      </div>
                                      
                                      
                                      <div class="form-group">
                                          <label>New Password</label>
                                          <input type="password" name="data[User][new_password]" class="form-control" placeholder="">
                                      </div>
                                      <div class="form-group">
                                          <label>Re-type Password</label>
                                          <input type="password" name="data[User][con_password]" class="form-control" placeholder="">
                                      </div>

                                      <div class="form-group">
                                          <button type="submit" class="btn btn-lg btn-primary">Save Changes</button>
                                      </div>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </section>

    

    <!--   footer   -->

    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
   
    
   <script type="text/javascript">
    $( document ).ready( function () {

    $( "#frmEdit" ).validate( {
        rules: {
            
           'data[User][current_password]': "required",
          
          'data[User][new_password]': {
            required: true,
             minlength: 6
          },
          
          'data[User][con_password]': "required"
          
        },
        messages: {
            'data[User][current_password]': "Please enter current password.", 
         'data[User][new_password]': {
            required: "Please provide new password",
            minlength: "Your password must be at least 6 characters long"
          }, 
         'data[User][con_password]': "Please re-type password"
        },
        
      } );
    } ); 
    
        
    </script>
