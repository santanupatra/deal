<section class="home-after-header">
        <section class="filter-home py-5 mb-5">
            <div class="container">
                <h3 class="text-white mb-4 text-uppercase">You will not miss any great discount never ever again!</h3>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <select class="form-control rounded-0 bg-transparent">
                            <option selected>Select Category . . . . . . .</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            </select>
                         </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <select class="form-control rounded-0 bg-transparent">
                            <option selected>Select Shop . . . . . . .</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            </select>
                         </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="search-btn">
                            <select class="form-control rounded-0 bg-transparent">
                                <option selected>Location. . . . . . .</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                          <button class="btn btn-src btn-danger rounded-0">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="bg-white mb-4">
                            <div>
                                <img src="img/img3.png" class="w-100" alt="">
                            </div>
                            <div class="right-img-btm p-3">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div>
                                            <span>
                                                <i class="fa fa-star star-color" aria-hidden="true"></i>
                                                <i class="fa fa-star star-color" aria-hidden="true"></i>
                                                <i class="fa fa-star star-color" aria-hidden="true"></i>
                                                <i class="fa fa-star star-color" aria-hidden="true"></i>
                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                            </span>
                                            <span class="mr-2">(250) rates</span>
                                            <span class="font-12">Expires in: <span class="text-red"> 22 days</span></span>
                                        </div>
                                        <h3 class="mt-2">Great Dinner For Two - 10% off</h3>
                                        <ul class="list-unstyled facility">
                                            <li class="font-12">
                                                <img src="img/dinner.png" alt="">
                                                <span>FOOD & DRINK</span>
                                            </li>
                                            <li class="font-12">
                                                <img src="img/dinner.png" alt="">
                                                <span>FOOD & DRINK</span>
                                            </li>
                                            <li class="font-12">
                                                <img src="img/dinner.png" alt="">
                                                <span>FOOD & DRINK</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 text-md-right">
                                        <div class="price">
                                            <span class="current"> $ 55.55 </span>
                                            <span class="old">$65.00</span>
                                        </div>
                                        <button type="button" name="button" class="btn btn-theme rounded-0">VIEW DEALS</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <img src="img/sdo.png" alt="" class="img-fluid w-100 image-top">

                        <div>
                          <h3 class="home-hdng">
                            <span>Popular</span>
                            Categories
                          </h3>                          
                          <div class="flexslider carousel">
                            <ul class="slides">
                              <li>
                                <img src="img/img1.png" />
                              </li>
                              <li>
                                <img src="img/img1.png" />
                              </li>
                              <li>
                                <img src="img/img1.png" />
                              </li>
                              <li>
                                <img src="img/img1.png" />
                              </li>
                              <li>
                                <img src="img/img1.png" />
                              </li>
                              <li>
                                <img src="img/img1.png" />
                              </li>
                              <li>
                                <img src="img/img1.png" />
                              </li>
                              <li>
                                <img src="img/img1.png" />
                              </li>
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
                            <img src="img/img1.png" class="w-100" alt="">
                            <div class="half-mark-header mt-5">
                                <span></span>
                            </div>
                            <h5 class="mb-3 text-uppercase">Categories</h5>
                            <ul class="cat-list p-0 m-0 list-unstyled">
                              <?php
                                foreach($right_category as $cat){
                                  echo '<li class=""><a href="'.$this->webroot.'products/list/'.base64_encode($cat['Category']['id']).'">'.$cat['Category']['name'].'</a></li>';
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
          <div class="card rounded-0">
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
          </div>
          <div class="card rounded-0">
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
          </div>
          <div class="card rounded-0">
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
          </div>
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