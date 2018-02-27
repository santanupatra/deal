<section class="home-after-header">
        <section class="filter-home py-5 mb-5">
            <div class="container">
                <h3 class="text-white mb-4 text-uppercase">You will not miss any great discount never ever again!</h3>
                <form method="post" action="<?php echo $this->webroot; ?>products/product_list" id="frmLogin">
                <div class="row">
                
                    <div class="col-lg-4">
                        <div class="form-group">
                            <select name="data[Product][category_id]" class="form-control rounded-0 bg-transparent">
                            <option selected>Select Category . . . . . . .</option>
                            <?php
                              foreach($allcategory as $cat){
                                echo '<option value="'.$cat['Category']['id'].'">'.$cat['Category']['name'].'</option>';
                              }
                            ?>                            
                            </select>
                         </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <select name="data[Product][shop_id]" class="form-control rounded-0 bg-transparent">
                            <option value="" selected>Select Shop . . . . . . .</option>
                            <?php
                              foreach ($shops as $shop) {
                                echo '<option value="'.$shop['Shop']['id'].'">'.$shop['Shop']['name'].'</option>';
                              }
                            ?>                            
                            </select>
                         </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="search-btn">
                            <select name="data[Product][city_id]" class="form-control rounded-0 bg-transparent">
                                <option value="" selected>Select Location . . . . . . .</option>
                                <?php
                              foreach ($cities as $city) {
                                echo '<option value="'.$city['City']['id'].'">'.$city['City']['name'].'</option>';
                              }
                            ?> 
                            </select>
                          <button type="submit" class="btn btn-src btn-danger rounded-0">Search</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="bg-white mb-4">                          
                           <iframe width="100%" height="400" src="<?php echo $video['Banner']['title']?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        </div>
                        <img src="img/sdo.png" alt="" class="img-fluid w-100 image-top">

                        <div>
                          <h3 class="home-hdng">
                            <span>Popular</span>
                            Categories
                          </h3>                          
                          <div class="flexslider carousel">
                            <ul class="slides">
                              <?php
                                foreach($popular_category as $pcat){
                                  //print_r($pcat);
                                  echo '<li><a href="'.$this->webroot.'products/product_list/'.base64_encode($pcat['Category']['id']).'"><img src="'.$this->webroot.'category_images/'.$pcat['Category']['image'].'" /></a></li>';
                                }
                              ?>                             
                              
                            </ul>
                          </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="bg-white p-3">
                            <div class="half-mark-header">
                                <span></span>
                            </div>
                            <h5 class="mb-3">ADVERTISE</h5>
                            <a href="<?php echo $advertise['Advertise']['link'];?>" target="_blank"><img src="<?php echo $this->webroot.'advertise_logos/'.$advertise['Advertise']['logo'];?>" class="w-100" alt=""></a>
                            <div class="half-mark-header mt-5">
                                <span></span>
                            </div>
                            <h5 class="mb-3 text-uppercase">Categories</h5>
                            <ul class="cat-list p-0 m-0 list-unstyled">
                              <?php
                                foreach($allcategory as $cat){
                                  echo '<li class=""><a href="'.$this->webroot.'products/product_list/'.base64_encode($cat['Category']['id']).'">'.$cat['Category']['name'].'</a></li>';
                                }
                              ?>
                                                             
                            </ul>
                        </div>
                        <div class="grayBg p-3">
                            <div class="half-mark-header">
                                <span></span>
                            </div>
                            <h5 class="mb-3 text-uppercase">Rating and feedback</h5>
                            <!-- <ul class="m-0 p-0 list-unstyled feedback">
                                <li>
                                    <div class="img"></div>
                                    <div class="txt">
                                        <h5></h5>
                                    </div>
                                </li>
                            </ul> -->
                            <div class="feebbk">
                                <div class="media">
                                  <img class="mr-3" src="img/img2.png" alt="Generic placeholder image">
                                  <div class="media-body">
                                    <h5 class="mt-0 mb-0">Wyndhan garden Mar - Puerto Rico</h5>
                                    <div class="star font-12">
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                    </div>
                                  </div>
                                </div>
                                <div class="media">
                                  <img class="mr-3" src="img/img2.png" alt="Generic placeholder image">
                                  <div class="media-body">
                                      <h5 class="mt-0 mb-0">Wyndhan garden Mar - Puerto Rico</h5>
                                      <div class="star font-12">
                                          <i class="fa fa-star-o" aria-hidden="true"></i>
                                          <i class="fa fa-star-o" aria-hidden="true"></i>
                                          <i class="fa fa-star-o" aria-hidden="true"></i>
                                          <i class="fa fa-star-o" aria-hidden="true"></i>
                                          <i class="fa fa-star-o" aria-hidden="true"></i>
                                      </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
     </section>
    <section class="pt-3">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-4">
            <div class="img-wrp">
              <img src="img/bg-2.png" class="w-100" alt="">
              <div class="img-inr">
                <div class="text-white text-uppercase font-36">
                  <strong>Get the </strong> offer</div>
              </div>
            </div>
          </div>
          <div class="col-lg-8">
            <a href="" class="underline-text">Lorem ipsum dolor sit amet,.</a>
            <p class="text-secondary">Donec eget convallis purus. Nam ultrices, neque a euismod pulvinar, lectus magna varius nunc, vitae faucibus neque risus a mi. Donec ante dui, mattis vitae sapien et, rhoncus feugiat justo.</p>
          </div>
        </div>
      </div>
    </section>
    <section class="py-2">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <h3 class="home-hdng">
              <span>Deals</span>
              benefit
            </h3>
            <div>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget convallis purus. Nam ultrices, neque a euismod pulvinar, lectus magna varius nunc, vitae faucibus neque risus a mi. Donec ante dui, mattis vitae sapien.</p>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget convallis purus. Nam ultrices, neque a euismod pulvinar, lectus magna varius nunc, </p>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eget convallis purus. Nam ultrices, neque a euismod pulvinar, lectus magna varius nunc, vitae faucibus neque risus a mi. Donec ante dui, mattis vitae sapien et, rhoncus feugiat justo.</p>
            </div>
          </div>
          <div class="col-lg-4">
            <img src="img/bg-1.png" class="w-100" alt="">
          </div>
        </div>
      </div>
    </section>
    <section class="pb-4">
      <div class="container">
        <h3 class="home-hdng">
              <span>Coupons</span>
               Here
            </h3>
        <div class="card-deck card-home">
            
            <?php if(!empty($couponcategory)){ 
                foreach($couponcategory as $dt){?>
            
          <div class="card rounded-0">
            <img class="card-img-top rounded-0" src="<?php echo $this->webroot.'category_images/'.$dt['Category']['image'];?>" alt="Card image cap">
            <div class="corner-add text-white">
              <i class="fa fa-plus-square-o" aria-hidden="true"></i>
            </div>
            <div class="card-block p-2">
              <h4 class="card-title"><?php echo $dt['Category']['name'];?></h4>
              <p class="card-text"><?php echo $dt['Category']['description'];?></p>
            </div>

          </div>
            
            <?php } }else{ ?>
            
            <div class="card rounded-0">
                No Coupon available.
            </div>
            
            <?php } ?>
<!--          <div class="card rounded-0">
            <img class="card-img-top rounded-0" src="img/item1.jpeg" alt="Card image cap">
            <div class="corner-add text-white">
              <i class="fa fa-plus-square-o" aria-hidden="true"></i>
            </div>
            <div class="card-block p-2">
              <h4 class="card-title">Lorem ipsum dolor sit amet.</h4>
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
            </div>
            <div class="card-footer">
              <small class="text-muted pull-left"><i class="fa fa-clock-o" aria-hidden="true"></i> June 26, 2018</small>
              <small class="pull-right text-theme">
                <i class="fa fa-plus-square-o" aria-hidden="true"></i>
              </small>
            </div>
          </div>-->
<!--          <div class="card rounded-0">
            <img class="card-img-top rounded-0" src="img/item1.jpeg" alt="Card image cap">
            <div class="corner-add text-white">
              <i class="fa fa-plus-square-o" aria-hidden="true"></i>
            </div>
            <div class="card-block p-2">
              <h4 class="card-title">Lorem ipsum dolor sit amet.</h4>
              <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
            </div>
            <div class="card-footer">
              <small class="text-muted pull-left"><i class="fa fa-clock-o" aria-hidden="true"></i> June 26, 2018</small>
              <small class="pull-right text-theme">
                <i class="fa fa-plus-square-o" aria-hidden="true"></i>
              </small>
            </div>
          </div>-->
        </div>
      </div>
    </section>
    <section class="app-link-warp pt-4">
        <div class="container">
            <h3 class="text-white text-center">Deals Browsing</h3>
            <div class="row">
                <div class="col-lg-6">
                    <img src="img/mobile.png" alt="" class="mw100">
                </div>
                <div class="col-lg-6">
                    <div class="text-center app-link-btn mt-4">
                        <a href="">
                            <img src="img/icon1.png" alt="">
                        </a>
                        <h1 class="text-white font-48 mb0">+</h1>
                        <a href="">
                            <img src="img/icon2.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5 grayBg">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 offset-lg-3">
            <div class="text-center">
              <div class="font-18"><i class="fa fa-envelope-o text-red mr-2 " aria-hidden="true"></i>Sign up for our weekly email newsletter with the best money-saving coupons.</div>
                <div class="search-btn my-3">
                  <input type="text" class="form-control" placeholder="Email">
                  <button class="btn btn-src btn-danger">Subscribe</button>
                </div>
              <p class="font-14 pb-0">Sign up for our weekly email newsletter with the best money-saving coupons.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.js"></script>