


    <!--   category list  -->
    
    <section class="py-5 product-list">
        <div class="container">
            <h4>Shop by Category</h4>
            <div class="row">
                
               <?php if($subcategorys!=''){ foreach($subcategorys as $cat){?> 
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col-product">
                    <a href="<?php echo $this->webroot ?>products/search/sc_<?php echo $cat['Category']['id']; ?>">
                        <figure class="mt-4">
                        <div class="product-pic">
                        <?php if($cat['Category']['image']){?>
                            <img src="<?php echo $this->webroot.'category_images/'.$cat['Category']['image'] ;?>" alt="">
                            <?php }else{ ?>
                             <img src="<?php echo $this->webroot.'category_images/default.jpg' ;?>" alt="">
                            <?php } ?>
                        </div>
                        <figcaption class="p-2">
                            <h6><?php echo $cat['Category']['name'];?></h6>
                        </figcaption>
                    </figure>
                    </a>
                </div>
               <?php } } ?>
            </div>
        </div>
    </section>



    
