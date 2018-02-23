<!DOCTYPE html>
<html lang="en">



<body>


    <section class="home-slider">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                
                <?php
                $a = 1;
                foreach($banners as $ban){ ?>
                <div class="carousel-item <?php echo (($a == 1)? 'active' : '');?>">
                    <img src="<?php echo $this->webroot.'banner_image/'.$ban['Banner']['image'];?>" alt="..." class="w-100">
                    <div class="carousel-caption d-flex flex-column flex-wrap align-items-center justify-content-center">
                        <h1 class="text-uppercase font-weight-bold"><?=$ban['Banner']['title']?></h1>
                        <a href="#" class="btn btn-primary btn-lg mt-3">Order Now</a>
                    </div>
                </div>
                <?php $a++; } ?>

                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </section>

    <!--   banner bottom  -->

    <section class="banner-bottom bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <?php if(!empty($middlesections)){
                    
                 foreach($middlesections as $mid){?>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="icon-img">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="<?php echo($this->webroot);?>middle_image/<?php echo $mid['Middle']['image']?>" alt="">
                        </div>
                    </div>
                    <div class="text-center mt-5">
                        <h5><?php echo $mid['Middle']['title']?></h5>
                        <p class="text-grey"><?php echo $mid['Middle']['description']?></p>
                    </div>
                </div>
                <?php } } ?>
                <!--<div class="col-lg-4 col-sm-6 col-12">
                    <div class="icon-img">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="<?php echo($this->webroot);?>html/img/icon/2.png" alt="">
                        </div>
                    </div>
                    <div class="text-center mt-5">
                        <h5>Independent sellers</h5>
                        <p class="text-grey">Buy directly from someone who put their heart and soul into making something special.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="icon-img">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="<?php echo($this->webroot);?>html/img/icon/3.png" alt="">
                        </div>
                    </div>
                    <div class="text-center mt-5">
                        <h5>Secure shopping</h5>
                        <p class="text-grey">We use best-in-class technology to protect your transactions.</p>
                    </div>
                </div>-->
            </div>
        </div>
    </section>
    
    <!--   product  list   -->
    
    <section class="product-list py-4">
        <div class="container">
            <h4>Popular right now</h4>
            <div class="row">
                <?php foreach($ratingproduct as $or){ ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col-product">
                    <figure class="mt-4">
                        <div class="product-pic">
                            <a href="<?php echo $this->webroot ?>products/product_details/<?php echo $or['id'] ; ?>">
                                <?php if(isset($or['image'])) { ?>
                                <img src="<?php echo($this->webroot)?>product_images/<?php echo($or['image']);?>" alt="">
                                <?php }else{ ?>
                                <img src="<?php echo($this->webroot)?>product_images/default.png" alt=""><?php } ?></a>
                        </div>
                        
                        <figcaption class="p-2">
                            <h6 class=""><?php echo $or['name']?></h6>
                            <p class="text-grey mb-1"><?php echo ($or['username']);?></p>
                            <h6 class="text-orange">
                                 <span class="stars"><?php if($or['avgrate']!=''){echo $or['avgrate'];}else{ echo 0;}?></span>
<!--                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>-->
                                <span class="text-grey">(<?php echo $or['ratecount']?>)</span>
                            </h6>
                            <h6 class="float-left mt-2 font-weight-bold"><?php echo '$'.$or['price']?></h6>
                            <a href="<?php echo $this->webroot ?>products/product_details/<?php echo $or['id'] ; ?>" class="btn btn-secondary btn-sm float-right">Shop Now</a>
                        </figcaption>
                    </figure>
                </div>
                <?php } ?>
                <!--<div class="col-lg-3 col-md-4 col-sm-6 col-12 col-product">
                    <figure class="mt-4">
                        <div class="product-pic">
                            <img src="<?php echo($this->webroot);?>html/img/item/2.png" alt="">
                        </div>
                        <figcaption class="p-2">
                            <h6 class="">Product name goes here</h6>
                            <p class="text-grey mb-1">UrbanRoseandco</p>
                            <h6 class="text-orange">
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <span class="text-grey">(71)</span>
                            </h6>
                            <h6 class="float-left mt-2 font-weight-bold">$99.00</h6>
                            <a href="#" class="btn btn-secondary btn-sm float-right">Shop Now</a>
                        </figcaption>
                    </figure>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col-product">
                    <figure class="mt-4">
                        <div class="product-pic">
                            <img src="<?php echo($this->webroot);?>html/img/item/3.png" alt="">
                        </div>
                        <figcaption class="p-2">
                            <h6 class="">Product name goes here</h6>
                            <p class="text-grey mb-1">UrbanRoseandco</p>
                            <h6 class="text-orange">
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <span class="text-grey">(71)</span>
                            </h6>
                            <h6 class="float-left mt-2 font-weight-bold">$99.00</h6>
                            <a href="#" class="btn btn-secondary btn-sm float-right">Shop Now</a>
                        </figcaption>
                    </figure>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col-product">
                    <figure class="mt-4">
                        <div class="product-pic">
                            <img src="<?php echo($this->webroot);?>html/img/item/4.png" alt="">
                        </div>
                        <figcaption class="p-2">
                            <h6 class="">Product name goes here</h6>
                            <p class="text-grey mb-1">UrbanRoseandco</p>
                            <h6 class="text-orange">
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <span class="text-grey">(71)</span>
                            </h6>
                            <h6 class="float-left mt-2 font-weight-bold">$99.00</h6>
                            <a href="#" class="btn btn-secondary btn-sm float-right">Shop Now</a>
                        </figcaption>
                    </figure>
                </div>-->
            </div>
        </div>
    </section>
    
    <section class="product-list shop-list py-4">
        <div class="container">
            <h4>Shop by Category</h4>
            <div class="row">
                
               <?php if($incategories!=''){ foreach($incategories as $cat){?> 
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col-product">
                    <a href="<?php echo $this->webroot ?>products/search_option/<?php echo $cat['Category']['id']; ?>">
                        <figure class="mt-4">
                        <div class="product-pic">
                            <?php if(isset($cat['Category']['image'])) { ?>
                            <img src="<?php echo $this->webroot.'category_images/'.$cat['Category']['image'];?>" alt="">
                            <?php }else{ ?>
                            <img src="<?php echo($this->webroot)?>product_images/default.png" alt="">
                            
                            <?php } ?>
                        </div>
                        <figcaption class="p-2">
                            <h6><?php echo $cat['Category']['name'];?></h6>
                        </figcaption>
                    </figure>
                    </a>
                </div>
               <?php } } ?>
<!--                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col-product">
                    <a href="#">
                        <figure class="mt-4">
                        <div class="product-pic">
                            <img src="<?php echo($this->webroot);?>html/img/pic/2.jpg" alt="">
                        </div>
                        <figcaption class="p-2">
                            <h6>Category name</h6>
                        </figcaption>
                    </figure>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col-product">
                    <a href="#">
                        <figure class="mt-4">
                        <div class="product-pic">
                            <img src="<?php echo($this->webroot);?>html/img/pic/3.jpg" alt="">
                        </div>
                        <figcaption class="p-2">
                            <h6>Category name</h6>
                        </figcaption>
                    </figure>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col-product">
                    <a href="#">
                        <figure class="mt-4">
                        <div class="product-pic">
                            <img src="<?php echo($this->webroot);?>html/img/pic/4.jpg" alt="">
                        </div>
                        <figcaption class="p-2">
                            <h6>Category name</h6>
                        </figcaption>
                    </figure>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col-product">
                    <a href="#">
                        <figure class="mt-4">
                        <div class="product-pic">
                            <img src="<?php echo($this->webroot);?>html/img/pic/5.jpg" alt="">
                        </div>
                        <figcaption class="p-2">
                            <h6>Category name</h6>
                        </figcaption>
                    </figure>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col-product">
                    <a href="#">
                        <figure class="mt-4">
                        <div class="product-pic">
                            <img src="<?php echo($this->webroot);?>html/img/pic/6.jpg" alt="">
                        </div>
                        <figcaption class="p-2">
                            <h6>Category name</h6>
                        </figcaption>
                    </figure>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col-product">
                    <a href="#">
                        <figure class="mt-4">
                        <div class="product-pic">
                            <img src="<?php echo($this->webroot);?>html/img/pic/7.jpg" alt="">
                        </div>
                        <figcaption class="p-2">
                            <h6>Category name</h6>
                        </figcaption>
                    </figure>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col-product">
                    <a href="#">
                        <figure class="mt-4">
                        <div class="product-pic">
                            <img src="<?php echo($this->webroot);?>html/img/pic/8.jpg" alt="">
                        </div>
                        <figcaption class="p-2">
                            <h6>Category name</h6>
                        </figcaption>
                    </figure>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col-product">
                    <a href="#">
                        <figure class="mt-4">
                        <div class="product-pic">
                            <img src="<?php echo($this->webroot);?>html/img/pic/9.jpg" alt="">
                        </div>
                        <figcaption class="p-2">
                            <h6>Category name</h6>
                        </figcaption>
                    </figure>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col-product">
                    <a href="#">
                        <figure class="mt-4">
                        <div class="product-pic">
                            <img src="<?php echo($this->webroot);?>html/img/pic/10.jpg" alt="">
                        </div>
                        <figcaption class="p-2">
                            <h6>Category name</h6>
                        </figcaption>
                    </figure>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col-product">
                    <a href="#">
                        <figure class="mt-4">
                        <div class="product-pic">
                            <img src="img/pic/11.jpg" alt="">
                        </div>
                        <figcaption class="p-2">
                            <h6>Category name</h6>
                        </figcaption>
                    </figure>
                    </a>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col-product">
                    <a href="#">
                        <figure class="mt-4">
                        <div class="product-pic">
                            <img src="img/pic/12.jpg" alt="">
                        </div>
                        <figcaption class="p-2">
                            <h6>Category name</h6>
                        </figcaption>
                    </figure>
                    </a>
                </div>-->
            </div>
            <div class="text-center mt-4">
                <a href="#" class="btn btn-outline-secondary btn-lg btn-squard">Explore more</a>
            </div>
        </div>
    </section>
    
    <!--   testimonials  -->
    
    <section class="testimonials py-5 text-center">
        <div class="container">
            <h2>Recent reviews from happy people</h2>
            <div class="row">
                 <?php if(!empty($recectreview)){ foreach($recectreview as $dt){?>
                
                <div class="col-lg-4 col-12 col-test">
                    <figure class="p-3">
                        <div class="client-pic">
                            <img src="<?php echo($this->webroot);?>html/img/testimonials/client/1.jpg" alt="" class="w-100 h-100">
                        </div>
                        <figcaption>
                            <p class="mb-2"><?php echo $dt['User']['first_name']?> <span class="text-grey">wrote on <?php echo date('d M Y',strtotime($dt['Rating']['date_time']))?></span></p>
                            <h6 class="text-orange">
                                    <span class="stars"><?php echo $dt['Rating']['rating'] ?></span>
                               </h6>
                            
                            <?php if($dt['Rating']['review']!=''){?><p><?php echo $dt['Rating']['review']?></p><?php } else{?><p>&nbsp;</p><?php } ?>
                        </figcaption>
                        <div class="test-pic">
                            <img src="<?php echo($this->webroot);?>product_images/<?php echo $dt['Product']['ProductImage'][0]['name'] ?>" alt="">
                        </div>
                    </figure>
                </div>
                <?php } }else{ ?>
                <div class="col-lg-4 col-12 col-test"></div>
                <br><br><div class="col-lg-4 col-12 col-test">No recent reviews found.</div>
                <div class="col-lg-4 col-12 col-test"></div>
                <?php } ?>
<!--                <div class="col-lg-4 col-12 col-test">
                    <figure class="p-3">
                        <div class="client-pic">
                            <img src="<?php echo($this->webroot);?>html/img/testimonials/client/2.jpg" alt="" class="w-100 h-100">
                        </div>
                        <figcaption>
                            <p class="mb-2">JoAnn <span class="text-grey">wrote on 26 August</span></p>
                            <h6 class="text-orange">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </h6>
                            <p>So pretty! Can't wait to use this for multiple projects.</p>
                        </figcaption>
                        <div class="test-pic">
                            <img src="<?php echo($this->webroot);?>html/img/testimonials/2.jpg" alt="">
                        </div>
                    </figure>
                </div>
                <div class="col-lg-4 col-12 col-test">
                    <figure class="p-3">
                        <div class="client-pic">
                            <img src="<?php echo($this->webroot);?>html/img/testimonials/client/3.jpg" alt="" class="w-100 h-100">
                        </div>
                        <figcaption>
                            <p class="mb-2">JoAnn <span class="text-grey">wrote on 26 August</span></p>
                            <h6 class="text-orange">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </h6>
                            <p>So pretty! Can't wait to use this for multiple projects.</p>
                        </figcaption>
                        <div class="test-pic">
                            <img src="<?php echo($this->webroot);?>html/img/testimonials/3.jpg" alt="">
                        </div>
                    </figure>
                </div>-->
            </div>
        </div>
    </section>
    
    <!--   footer   -->
    
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    
<style>
   .form-horizontal .control-label {
	text-align: left;
    }
    
    
    span.stars, span.stars span {
    display: block;
    background: url(img/stars.png) 0 -16px repeat-x;
    width: 80px;
    height: 16px;
}

span.stars span {
    background-position: 0 0;
}
    
    
</style>
<script>
$.fn.stars = function() {
    return $(this).each(function() {
        // Get the value
        var val = parseFloat($(this).html());
        // Make sure that the value is in 0 - 5 range, multiply to get width
        var size = Math.max(0, (Math.min(5, val))) * 16;
        // Create stars holder
        var $span = $('<span />').width(size);
        // Replace the numerical value with stars
        $(this).html($span);
    });
}
$(function() {
    $('span.stars').stars();
});

</script>