<?php

$pass_data=$this->params['pass'];

if(count($pass_data)>0){
    $pass_data_str=isset($pass_data[0])?$pass_data[0]:'';
}else{
    $pass_data_str='';
}
?>

    
    <!--  my account  -->
    
    <section class="pt-5 pb-5">
          <div class="container">
              <div class="row">
                  <?php echo ($this->element('vendor_side_menu'));?>
                  <div class="col-lg-9 col-12">
                      <div class="right-side p-3">
                          <h2 class="text-pink">My Account</h2>
                          <div class="row">
                              <div class="col-lg-7 col-12">
                                  <form class="form-area" method="post" action="<?php echo $this->webroot; ?>users/vendor_dashboard" id="frmEdit">
                                      
                                      
                                      <input type="hidden" name="data[User][id]" value="<?php echo $user['User']['id'];?>">
                                      <!--<input type="hidden" name="data[Shop][user_id]" value="<?php echo $vendor['Shop']['user_id'];?>">-->
                                      
                                      <div class="form-group">
                                          <label>First Name</label>
                                          <input type="text" class="form-control" name="data[User][first_name]" value="<?=$user['User']['first_name']?>" placeholder="">
                                      </div>
                                      <div class="form-group">
                                          <label>Last Name</label>
                                          <input type="text" class="form-control" name="data[User][last_name]" value="<?=$user['User']['last_name']?>" placeholder="">
                                      </div>
                                      <div class="form-group">
                                          <label>Email Id</label>
                                          <input type="text" class="form-control" name="data[User][email]" value="<?=$user['User']['email']?>" placeholder="">
                                      </div>
                                      <div class="form-group">
                                          <label>Mobile No</label>
                                          <input type="text" class="form-control" name="data[User][mobile_number]" value="<?=$user['User']['mobile_number']?>" placeholder="">
                                      </div>
                                      
                                      <div class="form-group">
                                          <label>Paypal Email</label>
                                          <input type="text" class="form-control" name="data[User][paypal_business_email]" value="<?=$user['User']['paypal_business_email']?>" placeholder="Enter paypal id here">
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
          'data[User][first_name]': "required",
          'data[User][last_name]': "required",
          'data[User][email]': {
            required: true           
          },
          
          'data[User][mobile_number]': "required"
          
        },
        messages: {
          'data[User][first_name]': "Please enter your firstname",
          'data[User][last_name]': "Please enter your lastname",
          'data[User][email]': "Please enter a valid email address", 
          
          'data[User][mobile_number]': "Please enter phone number"
          
        },
        
      } );
    } ); 
    
        
    </script>
