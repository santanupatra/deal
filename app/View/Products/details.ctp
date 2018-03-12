<style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>

<div class="clearfix"></div>

    <section class="page-title p-4">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-white">Super Flat Car Change 55% OFF Deal </h1>
            <p class="text-white">Great Coupons, Deals, Discounts & Dealy Deals Only With CouponXL</p>
          </div>
        </div>
      </div>
    </section>          
    <div class="clearfix"></div>
    
    <section class="deal-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <h2 class="text-uppercase p-2 m-0 mt-2 mb-2">Details</h2>
            <hr class="mt-2 mb-2">
          </div>
        </div>

        <div class="row">
          <div class="col-lg-7">
            <div class="deal-leftdiv text-center mb-3 rounded">
              <img src="<?php echo $this->webroot.'product_images/'.$details['Product']['product_image'];?>" alt="" class="img-fluid" id="zoom_01" data-zoom-image="images/large/image1.jpg"> 
            </div>
            <div class="deal-detaildiv">
                <ul class="list-unstyled d-block">
                    <li class="d-inline-block font-13 text-dark mr-2">
                      <i class="fa fa-map-marker"></i> 
                      <?php echo $details['City']['name']; ?>
                    </li>
<!--                    <li class="d-inline-block font-13 text-dark">
                      <i class="fa fa-gg-circle pr-1"></i> lorem ipsum
                    </li>-->
                    
                </ul>  
                <h5 class="text-dark"><strong><?php echo $details['Product']['name'];?></strong></h5>
                <hr class="mt-2 mb-2">                            
              <p class="font-13 text-gray mb-2"><?php echo $details['Product']['item_description'];?></p>
<!--              <div class="review-div w-100">
                 <form action="#">
                   <div class="form-group">
                     <label for="wr">Write a review</label>
                     <input type="text" name="txt" id="wr" class="form-control rounded-0 form-control-sm" placeholder="Write Here. . . .">
                   </div>

                   <div class="form-group">
                     <textarea name="area" id="" cols="30" rows="5" class="form-control form-control-sm" placeholder="Message Here. . . "></textarea>
                   </div>
                   <button type="button" class="btn btn-theme mt-1 mb-1 rounded-0">
                    <i class="fa fa-hand-o-up btn-sm"></i>Post Here</button>
                 </form> 
              </div>    -->
            </div>
          </div>

          <div class="col-lg-5">
            <div class="deal-rightdiv bg-light">               
                <hr class="w-100 m-0"> 
                <h2 class="h2 text-uppercase text-center p-2">
                  $<?php echo $details['Product']['discount'];?>
                  <span class="h5 text-gray pl-3">$<?php echo $details['Product']['price_lot'];?></span>
                </h2>
                <hr class="w-100 m-0">
                <div class="timer-div">
                  <small class="text-gray text-center d-block p-2">
                  <i class="fa fa-clock-o"></i> TIME LEFT - LIMITED OFFER!
                  </small>
                  <div class="btn btn-theme w-100 rounded-0 p-3" id="getting-started">
                  <?php
                  	$seconds = strtotime($details['Product']['end_date']) - strtotime(date("Y-m-d h:i:s"));

					$days    = floor($seconds / 86400);
					$hours   = floor(($seconds - ($days * 86400)) / 3600);
					$minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
					$seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));

					echo $days.' days '.$hours.' H '.$minutes.' M '.$seconds.' S';
                  ?>
                  </div>
                  <small class="text-gray text-center d-block p-2">                  
                      <?php echo $details['Category']['name'];?>
                  </small>                
                </div>

                <div class="social-div text-center w-100 d-block">
                  <ul class="list-unstyled d-block w-100 table-bordered p-1 m-0">
                      
                      <!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5a818b2d23ba2aab"></script>
                      <!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox_s675"></div>


                  </ul>   
                </div> 
                
                <div class="deal-googldiv">
                  <h5 class="text-dark p-2 text-center">
                    Our location
                  </h5>
                 <!--  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26361218.62275926!2d-113.75471927574468!3d36.24138396069964!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54eab584e432360b%3A0x1c3bb99243deb742!2sUnited+States!5e0!3m2!1sen!2sin!4v1518689536814" width="100%" height="330" frameborder="0" style="border:0" allowfullscreen></iframe>   -->
                 <div id="map"></div>                  
                    
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="clearfix"></div>
     <style>
       #map {
        height: 400px;
        width: 100%;
       }
    </style>  
    
    <script>
      function initMap() {
        var uluru = {lat: <?php echo $details['City']['latitude']; ?>, lng: <?php echo $details['City']['longitude']; ?>};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPCFTHLy2vABYWMKAwTV6zftOl4vwMGy0&callback=initMap">
    </script>