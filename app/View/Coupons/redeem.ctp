<?php //pr($coupon_details);?>
    <section class="pt-5 pb-5">
          <div class="container">
              <div class="row">
                  <div class="col-lg-6 col-12 side-bar">
                      
    <div class="side-bar-menu">
        <div class="table-responsive">
            <div class="col-lg-8">
                <h4><b>Coupon Details</b></h4>
    			</div><br>
        <table class="table checkout-table table-bordered">
            <thead>
                <tr>
                    <td>Coupon Name</td>
                    <td>Price</td>
                    <td>Offer</td>
                </tr>
            </thead>
            
            <tbody>
                <tr>

                <td>
                <?php  echo $coupon_details['Coupon']['name'];?>
                </td>
                <td>
                $<?php echo $coupon_details['Coupon']['amount'] ; ?>
                </td>
                <td class="">
                <?php echo $coupon_details['Coupon']['offer'] ; ?>% Discount	
                </td>

                </tr>
            </tbody>
            
        </table>
        </div>
    </div>
</div>
                  <div class="col-lg-6 col-12">
                      <div class="right-side p-3">
                          <h2 class="text-pink"><b>Booking Person Details</b></h2><br>
                          <div class="row">
                              <div class="col-lg-7 col-12">
                                  <form class="form-area" method="post" action="<?php echo $this->webroot; ?>coupons/redeem" id="frmEdit">
                                      
                                      
                                      <input type="hidden" name="data[OfflineOrder][user_id]" value="<?php echo $user['User']['id'];?>">
                                      <input type="hidden" name="data[OfflineOrder][coupon_id]" value="<?php echo $coupon_details['Coupon']['id'];?>">
                                      <input type="hidden" name="data[OfflineOrder][coupon_owner_id]" value="<?php echo $coupon_details['Coupon']['user_id'];?>">
                                      
                                      
                                      <div class="form-group">
                                          <label>First Name</label>
                                          <input type="text" class="form-control" name="data[OfflineOrder][first_name]" value="<?=$user['User']['first_name']?>" placeholder="">
                                      </div>
                                      <div class="form-group">
                                          <label>Last Name</label>
                                          <input type="text" class="form-control" name="data[OfflineOrder][last_name]" value="<?=$user['User']['last_name']?>" placeholder="">
                                      </div>
                                      <div class="form-group">
                                          <label>Email Id</label>
                                          <input type="text" class="form-control" name="data[OfflineOrder][book_email]" value="<?=$user['User']['email']?>" placeholder="">
                                      </div>
                                      <div class="form-group">
                                          <label>Mobile No</label>
                                          <input type="text" class="form-control" name="data[OfflineOrder][book_phone]" value="<?=$user['User']['mobile_number']?>" placeholder="">
                                      </div>
                                      
                                     
                                      
                                      

                                      <div class="form-group">
                                          <button type="submit" class="btn btn-lg btn-primary">Save</button>
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
