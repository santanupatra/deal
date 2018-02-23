

<?php //pr($products);?>


    <!--  my account  -->

    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row">
                <?php echo ($this->element('user_side_menu'));?>
                <div class="col-lg-9 col-12">
                    <div class="right-side p-3">
                        <h2 class="text-pink">Product List</h2>
                        <?php
                       //pr($products);
                        if($products!=''){foreach ($products as $product){ ?>
                        <div class="row mt-3">
                            <div class="col-lg-2 col-md-3 col-4">
                                
                                <?php if($product['ProductImage'][0]['name']!=''){ ?>
                                 <img src="<?php echo($this->webroot)?>product_images/<?php echo($product['ProductImage'][0]['name']);?>" alt="" class="img-fluid">
                        <?php }else{ ?>
                                 
                             <img src="<?php echo($this->webroot)?>product_images/default.png" alt="" class="img-fluid">   
                                 
                        <?php } ?>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <h5><?php echo $product['Product']['name'];?></h5>
                                <h6>Price : <span class="text-pink font-weight-bold"><?php if($product['ProductVariation'][0]['price']!=""){  echo '$'.$product['ProductVariation'][0]['price'];}else{ echo '$'.$product['Product']['price_lot'];}?></span></h6>
                                <p class="text-grey"><?php  echo substr($product['Product']['item_description'],0,100).'...';?></p>
                            </div>
                            <div class="col-lg-4 col-md-3 col-12 text-md-right">
                                <a href="<?php echo $this->webroot;?>products/uploadimage/<?php echo $product['Product']['id'];?>"><img src="<?php echo $this->webroot;?>img/uploadimage.png" title="Upload Image"></a>
                                <a href="<?php echo($this->webroot);?>products/edit_product/<?php echo $product['Product']['id']?>" class="btn btn-sm btn-secondary">Edit</a>
                                <a href="<?php echo($this->webroot);?>products/delete_product/<?php echo $product['Product']['id']?>" class="btn btn-sm btn-danger">Delete</a>
                            </div>
                        </div>
                        <?php } } ?>
                        
                        
                       

                    </div>
                </div>
            </div>
        </div>
    </section>

