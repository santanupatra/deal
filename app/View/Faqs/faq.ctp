<!--<section class="faq">

<div class="container">
	<div class="row">

		<div class="col-md-12 col-lg-12 col-sm-12">
			<div class="RHS">
                           <h3>FAQ</h3>
                                        <?php

                                           foreach ($faqs as $faq){
                                        ?>

				       <button class="accordion"><?php echo $faq['Faq']['question'];?></button>
					<div class="panel">
					  <p><?php echo $faq['Faq']['answer']?></p>
					</div>

                                       <?php
                                         }
                                       ?>


					</div>
				</div>
			</div>
		</div>

</section>

<script>


var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].onclick = function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  }
}

$(".profile_menu li a").click(function(){
    	$(".profile_menu li a").removeClass("active");
    	$(this).addClass("active");

});
</script>-->





  
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
          <h2 class="text-uppercase p-2 m-0 mt-2 mb-2">Here Your Question....</h2>
          <hr class="mt-2 mb-2">
        </div>
      </div>


      <div class="row">
        <div class="col-md-6">
          <div class="faq-imgpart">
            <img src="<?php echo $this->webroot;?>images/ff.jpg" alt="" class="img-fluid img-thumbnail">
          </div>
        </div>

        <div class="faq-mainpart col-md-6">
          <div id="accordion">
              
             <?php
                
             $id=1;
                    foreach ($faqs as $faq){
              ?> 
            <div class="card mb-2 rounded-0">
              <div class="card-header p-0" id="heading<?php echo $id;?>">
                <h5 class="mb-0">
                  <button class="btn btn-theme" data-toggle="collapse" data-target="#collapse<?php echo $id;?>" aria-expanded="true" aria-controls="collapse<?php echo $id;?>">
                    Q <?php echo $id;?>: <?php echo $faq['Faq']['question'];?>
                  </button>
                </h5>
              </div>
          
              <div id="collapse<?php echo $id;?>" class="collapse <?php if($id==1){?> show <?php } ?>" aria-labelledby="heading<?php echo $id;?>" data-parent="#accordion">
                <div class="card-body">
                  <?php echo $faq['Faq']['answer']?>
                </div>
              </div>
            </div>
                    <?php $id++;} ?>

<!--            <div class="card mb-2 rounded-0">
              <div class="card-header p-0" id="headingTwo">
                <h5 class="mb-0">
                  <button class="btn btn-theme collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Q 2: Question
                  </button>
                </h5>
              </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo.
                </div>
              </div>
            </div>-->

<!--            <div class="card mb-2 rounded-0">
              <div class="card-header p-0" id="headingThree">
                <h5 class="mb-0">
                  <button class="btn btn-theme collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Q 3: Question
                  </button>
                </h5>
              </div>
              <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                <div class="card-body">
                  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo.
                </div>
              </div>
            </div>-->
            
                       
          </div>           
        </div>
      </div>
    </div>
  </section>
  <div class="clearfix"></div>
