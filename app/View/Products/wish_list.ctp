 
    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row">
                <?php if($userdetails['User']['type']=='V'){ echo ($this->element('vendor_side_menu'));}else{echo ($this->element('user_side_menu'));};?>
                <div class="col-lg-9 col-12">
                    <div class="right-side p-3">
                        <h2 class="text-pink">Wish List</h2>
                        
                        <?php if($orders!='' && !empty($orders)){
            foreach($orders as $or){ ?>
                       
                        
                        <div class="row mt-3 pb-3 product-list-row">
                            <div class="col-lg-2 col-md-3 col-4">
                                
                                
                                <img src="<?php echo($this->webroot)?>product_images/<?php echo($or['Product']['ProductImage'][0]['name']);?>" alt="" class="img-fluid">
                                
                                
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <h5><?php echo $or['Product']['name'];?></h5>
                                <h6>Price : <span class="text-pink font-weight-bold"><?php  echo '$'.$or['Wishlist']['price'];?></span></h6>
                                <p class="text-grey"><?php  echo substr($or['Product']['item_description'],0,100).'...';?></p>
                            </div>
                            
                        
                            
                            <div class="col-lg-4 col-md-3 col-12 text-md-right">

                                <a href="<?php echo($this->webroot);?>products/product_details/<?php echo $or['Product']['id']?>" class="btn btn-sm btn-primary">View</a>
                                
                                <a href="<?php echo($this->webroot);?>products/remove_wishlist/<?php echo $or['Wishlist']['id']?>" class="btn btn-sm btn-danger" >Remove</a>
                                
                            </div>
                         
                        </div>
                               
                        
 
                        <?php } }else{ ?>
                        <div class="row mt-3">Sorry!No product found.</div>
                        
                        <?php } ?>
                       
                    </div>
                </div>
            </div>
        </div>
    </section>

