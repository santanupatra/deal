<div class="clearfix"></div>
<section class="page-title p-4">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="text-white">All Deals &amp; Coupons </h1>
        <p class="text-white">CouponXL deal &amp; coupons search page</p>
      </div>
    </div>
  </div>
</section>
<div class="clearfix"></div>
<section class="list-section">
  <div class="container">
    <div class="list-updiv bg-light mt-3 mb-3 w-100 pt-2 pl-3 pr-3">
      <div class="row">
        <div class="col-lg-6">
          <div class="coupon-link">
            <ul>
              <li>Coupons</li>
              <li>Department Stores</li>
              <li>Deals Coupons </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-6 text-right">
          <form action="#" class="d-inline-block pl-1">
            <div class="form-group mb-0 search-category">
              <select class="text-dark text-left h6 font-14">
                <option value="1">Search Coupon By Category</option>
                <option value="2">Option 1</option>
                <option value="3">Option 1</option>
              </select>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="list-innerdiv w-100" id="products">
      <div class="row">
        <div class="item col-xs-12 col-sm-12 col-md-3">
          <div class="coupon-list-left">
            <div class="coupon-list-left-logo"> <img alt="" src="img/logo.png" class="img-responsive" >
              <p> <a href="#"> Category Name </a> </p>
              <div class="coupon-ava">
                <h1>221</h1>
                <p>Coupons Available</p>
              </div>
            </div>
            <div class="related-coupons text-uppercase">
              <div class="half-mark-header"> <span></span> </div>
              <h4>Related Coupons</h4>
              <ul>
                <li> Coupon - 1 </li>
                <li> Coupon - 1 </li>
                <li> Coupon - 1 </li>
                <li> Coupon - 1 </li>
                <li> Coupon - 1 </li>
                <li> Coupon - 1 </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="item col-xs-12 col-sm-12 col-md-9">
          <div class="coupon-list-right">            
            <?php
              foreach($coupons as $coupon){
            ?>
            <div class="coupon-list-area">
              <div class="row">
                <div class="get-coupon-rt-area">
                  <div class="col-md-3">
                    <div class="off-part">
                      <h3><?php echo $coupon['Coupon']['offer'];?>%</h3>
                      <p>Off</p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="coupon-list-area-rt">
                      <div class="promo-code"> <span> Promo Code </span> 17,581 used today </div>
                      <h5><?php echo $coupon['Coupon']['name'];?></h5>
                      <p>Shop these deals of the day.</p>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <button type="button" class="btn btn-success get-coupon" data-toggle="modal" data-target="#myModal">Get Coupon Code</button>
                  </div>
                </div>
              </div>
            </div>
            <?php
             }
             ?>
       
          </div>
          <div class="paging text-center paging-span-cont">
            <?php
                echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
                echo $this->Paginator->numbers(array('separator' => ''));
                echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
            ?>
        </div>
        </div>
      </div>
    </div>
  </div>
  <!-- container --> 
</section>
<div class="clearfix"></div>


<!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Click below to get your coupon code</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                          </div>
                          <div class="modal-body get-coupon-modal">
                            <button type="button" class="btn btn-success get-coupon">Get Coupon Code</button>
                            <h5>Amazon: Up To 75% Off | Amazon Promo Codes & Coupons February 2018</h5>
                            <p> Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                          </div>
                          <div class="modal-body get-coupon-modal gray-bg-modal">
                            <h5>Never miss a great Amazon coupon and get our best coupons every week!</h5>
                            <div class="search-btn my-3">
                              <input type="text" placeholder="Email" class="form-control">
                              <button class="btn btn-src btn-danger">Subscribe</button>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <ul class="w-100 list-unstyled m-0 text-center">
                              <li class="d-inline p-1"> <a href="#"> <i aria-hidden="true" class="fa fa-facebook"></i> </a> </li>
                              <li class="d-inline p-1"> <a href="#"> <i aria-hidden="true" class="fa fa-twitter"></i> </a> </li>
                              <li class="d-inline p-1"> <a href="#"> <i aria-hidden="true" class="fa fa-google-plus"></i> </a> </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>