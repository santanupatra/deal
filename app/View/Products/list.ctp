<?php pr($products);?>
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
        <div class="list-updiv bg-light mt-3 mb-3 w-100 pt-3 pl-3 pr-3">
          <div class="row">
            <div class="col-lg-6">
              <h6 class="text-dark text-uppercase d-inline-block m-0"><?php echo $category['Category']['name'];?></h6>         
            </div>
            <div class="col-lg-6 text-right">
              <h6 class="text-dark text-uppercase d-inline-block m-0">Short By</h6>
              <form action="#" class="d-inline-block pl-1">
                <div class="form-group">
                  <select class="text-dark text-center h6 font-14">
                    <option value="1">- Category -</option>
                    <option value="2">High To Low Price</option>
                    <option value="3">Low To High Price</option>
                  </select>
                </div>
              </form>
            </div>
          </div>
        </div>
          

        <div class="list-innerdiv w-100" id="products">
          <div class="row">
            <?php foreach ($products as $product) {  ?>
            <div class="item col-xs-12 col-sm-12 col-md-4">
              <div class="img-thumbnail">
                <div class="ll-imgdiv">
                    <img class="group list-group-image img-responsive"  src="images/sv.jpg" alt="" />
                </div>  
                <div class="caption">
                  <h5 class="h6 m-0 p-0"><?php echo $product['Product']['name'];?></h5>

                  <h5 class="h6 m-0 p-0">
                    <span>
                     
                      <span class="h6">Price: <?php echo $product['Product']['price'];?></span>
                    </span>               
                  </h5>

                  <h5 class="m-0 p-0">
                    <a href="deal.html" class="btn-sm btn"><i class="fa fa-hand-o-right"></i> View Deal</a>
                  </h5>
                </div>
              </div>
            </div>
            <?php
                }
             ?> 
                                               
          </div>          
        </div>
      </div> <!-- container -->
    </section>
    <div class="clearfix"></div>