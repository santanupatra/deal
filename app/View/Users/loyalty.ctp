<div class="clearfix"></div>

  <section class="page-title p-4">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="text-white">Loyalty Card Offer Types</h1>
          <p class="text-white">choose the style that suits your business </p>
        </div>
      </div>
    </div>
  </section>
  <div class="clearfix"></div>

  
  <section class="loyality-section">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="loyality-leftdiv card mt-2 mb-2">
            <h4 class="text-center text-dark bg-light p-2 text-uppercase ">seller Name</h4>
            <ul class="list-group">
                
                <?php if(!empty($sellers)){
                    
                 foreach($sellers as $seller){?>
              <li class="list-group-item"><?php echo $seller['User']['first_name'].' '.$seller['User']['last_name']?></li>
              
                <?php } }else{ ?>
                    
                    <li class="list-group-item">No seller found. </li>
             <?php   } ?>
<!--              <li class="list-group-item">Dapibus ac facilisis in <span class="badge badge-danger badge-pill float-md-right">14</span></li>
              <li class="list-group-item">Morbi leo risus <span class="badge badge-danger badge-pill float-md-right">14</span></li>
              <li class="list-group-item">Porta ac consectetur ac <span class="badge badge-danger badge-pill float-md-right">14</span></li>
              <li class="list-group-item">Vestibulum at eros <span class="badge badge-danger badge-pill float-md-right">14</span></li>
              <li class="list-group-item">Cras justo odio <span class="badge badge-danger badge-pill float-md-right">14</span></li>
              <li class="list-group-item">Dapibus ac facilisis in <span class="badge badge-danger badge-pill float-md-right">14</span></li>-->
            </ul>            
          </div>
        </div>

        <div class="col-md-8">
          <div class="loyality-rightdiv mt-2 mb-2">
            <div class="loyality-mainpart jumbotron jumbotron-fluid p-3 rounded">
              <h5 class="pb-2"> <i class="fa fa-hand-o-right"></i> <strong>We’re confident in the Deal experience and back it with the Deal Promise.</strong></h5>
              <article class="h6">
                  We always want you to have a great experience with Groupon. That’s why we have the Groupon Promise. If you used a Local Groupon voucher before its promotional value expired, took a Getaways trip, or attended a GrouponLive event and were disappointed by your experience, contact us within fourteen days of your voucher use, trip or event and tell us about it. We’ll work with you to make it right. <br><br>

                  We also have the following refund policies:
              </article>
            </div> 
            
            <div class="row">
              <div class="col-md-4">
                <div class="loyality-imgdiv card">
                  <img src="<?php echo $this->webroot;?>images/sv1.png" alt="" class="img-fluid img-thumbnail">
                </div>
              </div>

              <div class="col-md-8">
                <div class="loyality-txtpart">
                  <h5 class="p-2 bg-light"> <i class="fa fa-star"></i> Stamps</h5>
                  <article class="h6 blockquote border border-top-0 border-bottom-0 border-left-0 border-light p-2">
                    Your voucher may always be redeemed at the merchant who issued it for at least the amount you paid for it – even if the promotional value has expired. Additionally, any unredeemed voucher may be returned to us within the first three days of purchase for a refund of the amount paid. After that three day time period, Groupon will not refund any voucher and all sales are final, unless otherwise stated in the Fine Print.
                  </article>            
                </div>                
              </div>
              <div class="clearfix"></div>

              <div class="col-md-8">
                <div class="loyality-txtpart mt-2">
                  <h5 class="p-2 bg-light"> <i class="fa fa-star"></i> Points</h5>
                  <article class="h6 blockquote border border-top-0 border-bottom-0 border-left-0 border-light p-2">
                    Your voucher may always be redeemed at the merchant who issued it for at least the amount you paid for it – even if the promotional value has expired. Additionally, any unredeemed voucher may be returned to us within the first three days of purchase for a refund of the amount paid. After that three day time period, Groupon will not refund any voucher and all sales are final, unless otherwise stated in the Fine Print.
                  </article>            
                </div>                
              </div>

              <div class="col-md-4">
                <div class="loyality-imgdiv card">
                 <iframe width="100%" height="200" src="https://www.youtube.com/embed/oNCMCEY-pHQ" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
              </div>
              <div class="clearfix"></div>

              <div class="col-md-4">
                <div class="loyality-imgdiv card mt-2">
                  <img src="<?php echo $this->webroot;?>images/cupns.png" alt="" class="img-fluid img-thumbnail">
                </div>                             
              </div>

              <div class="col-md-8">
                <div class="loyality-txtpart mt-2">
                  <h5 class="p-2 bg-light"> <i class="fa fa-star"></i> Coupons</h5>
                  <article class="h6 blockquote border border-top-0 border-bottom-0 border-left-0 border-light p-2">
                    Your voucher may always be redeemed at the merchant who issued it for at least the amount you paid for it – even if the promotional value has expired. Additionally, any unredeemed voucher may be returned to us within the first three days of purchase for a refund of the amount paid. After that three day time period, Groupon will not refund any voucher and all sales are final, unless otherwise stated in the Fine Print.
                  </article>            
                </div>                  
              </div>
              <div class="clearfix"></div>

              <div class="col-md-8">
                <div class="loyality-txtpart mt-2">
                  <h5 class="p-2 bg-light"> <i class="fa fa-star"></i> Scratch Card</h5>
                  <article class="h6 blockquote border border-top-0 border-bottom-0 border-left-0 border-light p-2">
                    Your voucher may always be redeemed at the merchant who issued it for at least the amount you paid for it – even if the promotional value has expired. Additionally, any unredeemed voucher may be returned to us within the first three days of purchase for a refund of the amount paid. After that three day time period, Groupon will not refund any voucher and all sales are final, unless otherwise stated in the Fine Print.
                  </article>            
                </div>                
              </div>

              <div class="col-md-4">
                <div class="loyality-imgdiv card">
                  <iframe width="100%" height="200" src="https://www.youtube.com/embed/Mi1QBxVjZAw" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
              </div>
              <div class="clearfix"></div>


              <div class="col-md-4">
                <div class="loyality-imgdiv card mt-md-2">
                  <img src="<?php echo $this->webroot;?>images/check-ins.png" alt="" class="img-fluid img-thumbnail">
                </div>
              </div>

              <div class="col-md-4">
                <div class="loyality-imgdiv card mt-md-2">
                  <img src="<?php echo $this->webroot;?>images/vip-1.png" alt="" class="img-fluid img-thumbnail">
                </div>
              </div>

              <div class="col-md-4">
                <div class="loyality-txtpart mt-2">
                  <h5 class="p-2 bg-light"> <i class="fa fa-star"></i> VIP Memberships</h5>
                  <article class="h6 blockquote border border-top-0 border-bottom-0 border-left-0 border-light p-2">
                    Your voucher may always be redeemed at the merchant who issued it for at least the amount you paid for it – even if the promotional value has expired. Additionally, any unredeemed voucher may be returned to us within the first three days of purchase for a refund of the amount paid.
                  </article>            
                </div>                 
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="clearfix"></div>