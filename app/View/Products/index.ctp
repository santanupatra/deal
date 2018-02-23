

<?php //pr($products);?>


    <!--  my account  -->

    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row">
                <?php echo ($this->element('vendor_side_menu'));?>
                <div class="col-lg-9 col-12">
                    <div class="right-side p-3">
                        <h2 class="text-pink">Product List</h2>
                        <div class="bg-light p-4">
                          <form method="post" action="<?php  echo($this->webroot);?>products/multiple_product" enctype="multipart/form-data">
                              <div class="file-upload">
                                  <label for="upload" class="file-upload__label">Choose File</label>
                                  <input id="upload" class="file-upload__input" type="file" name="csv_file">
                              </div>
                              <!--<input type="file" name="csv_file">-->
                              <input class="btn btn-primary btn-lg float-right" type="submit" name="Uplaod" value="Upload multiple product">
                          </form>


                         <div class="row"><div class="col-sm-6 p-3">
                        <?php

                        echo $this->Html->link(
                            'Download Sample',
                            array(
                                'controller' => 'products', // controller name
                                'action' => 'downloadSamplefile',  //action name
                                'full_base' => true
                            ));

                        ?>
                        </div>

                        <div class="col-sm-6 p-3 text-right">
                            <a href="<?php echo $this->webroot?>products/exporttocsv" class="btn btn-primary btn-sm">Download Products List</a>
                        </div></div>
                        </div>



                        <?php if($products!=''){foreach ($products as $product){ ?>
                        <div class="row mt-3 pb-3 product-list-row">
                            <div class="col-lg-2 col-md-3 col-4">

                                <?php if(isset($product['ProductImage'][0]['name'])) { ?>
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
<a href="<?php echo $this->webroot;?>products/vendor_uploadimage/<?php echo $product['Product']['id'];?>"><img src="<?php echo $this->webroot;?>img/uploadimage.png" title="Upload Image"></a>
                                <a href="<?php echo($this->webroot);?>products/edit/<?php echo $product['Product']['id']?>" class="btn btn-sm btn-secondary">Edit</a>
                                <a href="<?php echo($this->webroot);?>products/delete/<?php echo $product['Product']['id']?>" class="btn btn-sm btn-danger">Delete</a>
                            </div>
                        </div>
                        <?php } } ?>



		<div class="paging">
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
    </section>
