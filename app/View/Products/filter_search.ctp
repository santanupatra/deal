

                        <?php pr($products);
                        if(isset($products) && !empty($products)){ 
                            foreach($products as $prd){ ?>
                        <?php 
                       //print_r($prd['Product']);exit; 
                        ?>
                        <div class="col-lg-4 col-sm-6 col-12 col-product">
                            <figure class="mt-4">
                                <div class="product-pic">
                                    
                                    <?php if($prd['ProductImage'][0]['name']){?>
                                    
                                    <a href="<?php echo $this->webroot ?>products/product_details/<?php echo $prd['Product']['id'] ; ?>"><img src="<?php echo $this->webroot ?>product_images/<?php echo $prd['ProductImage'][0]['name']; ?>" alt=""></a>
                                    <?php }else{ ?>
                                    <a href="<?php echo $this->webroot ?>products/product_details/<?php echo $prd['Product']['id'] ; ?>"><img src="<?php echo $this->webroot ?>product_images/default.png" alt=""></a>
                                    <?php } ?>
                                    
                                </div>
                                <figcaption class="p-2">
                                    <h6 class=""><?php echo $prd['Product']['name']; ?></h6>
                                    <p class="text-grey mb-1"><?php echo $prd['User']['first_name'].' '.$prd['User']['last_name']; ?></p>
<!--                                    <h6 class="text-orange">
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <span class="text-grey">(71)</span>
                            </h6>-->
                                    <h6 class="float-left mt-2 font-weight-bold">$<?php if($prd['ProductVariation'][0]['price']!=''){ echo $prd['ProductVariation'][0]['price'];}else{ echo $prd['Product']['price_lot'];}?></h6>
                                    <a href="<?php echo $this->webroot ?>products/product_details/<?php echo $prd['Product']['id'] ; ?>" class="btn btn-secondary btn-sm float-right">Shop Now</a>
                                </figcaption>
                            </figure>
                        </div>
                        
                       <?php }}else{ ?>
                        <div class="col-lg-12 col-sm-12 col-12 col-product">
                            <div class="mt-4"><h2>Sorry!No Product Available.</h2></div>
                        </div>
                       <?php } ?>



