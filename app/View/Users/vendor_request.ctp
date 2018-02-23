  <!--  my account  -->
    
    <section class="pt-5 pb-5">
          <div class="container">
              <div class="row">
                  <?php echo ($this->element('user_side_menu'));?>
                  <div class="col-lg-9 col-12">
                      <div class="right-side p-3">
                          <h2 class="text-pink">Request For Vendor</h2>
                          <div class="row">
                              <div class="col-lg-7 col-12">
                                  <form class="form-area" method="post" action="<?php echo $this->webroot; ?>users/vendor_request" id="frmEdit">
                                      
                                      
                                      
                                      
<!--                                      <div class="form-group">
                                          <label>Select user type</label>
                                          <select class="form-control" name="data[VendorRequest][utype_request]">
                                              <option value="V" selected="">Vendor</option>   
                                              
                                          </select>
                                      </div>-->
                                      
                                      <div class="form-group">
                                          <button type="submit" class="btn btn-lg btn-primary">Become a vendor</button>
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
