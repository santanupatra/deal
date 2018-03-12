

<?php //pr($products);?>


    <!--  my account  -->

    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row">
                <?php echo ($this->element('vendor_side_menu'));?>
                <div class="col-lg-9 col-12">
                    <div class="right-side p-3">
                        <h2 class="text-pink">Shop List</h2>




                        <?php if($shops!=''){foreach ($shops as $product){ ?>
                        <div class="row mt-3 pb-3 product-list-row">
                            <div class="col-lg-2 col-md-3 col-4">

                                <?php if(isset($product['Shop']['logo'])) { ?>
                                <img src="<?php echo($this->webroot)?>shop_images/<?php echo($product['Shop']['logo']);?>" alt="" class="img-fluid">
                                <?php }else{ ?>
                                 <img src="<?php echo($this->webroot)?>shop_images/default.png" alt="" class="img-fluid">
                                <?php } ?>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <h5><?php echo $product['Shop']['name'];?></h5>
                               
                                <p class="text-grey"><?php  echo substr($product['Shop']['description'],0,100).'...';?></p>
                            </div>
                            <div class="col-lg-4 col-md-3 col-12 text-md-right">

                                <a href="<?php echo($this->webroot);?>shops/edit/<?php echo $product['Shop']['id']?>" class="btn btn-sm btn-secondary">Edit</a>
                                <a href="<?php echo($this->webroot);?>shops/delete/<?php echo $product['Shop']['id']?>" onclick="return confirm('Are you sure to delete?')" class="btn btn-sm btn-danger">Delete</a>
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
