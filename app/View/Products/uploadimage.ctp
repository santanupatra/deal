

<link href="<?php echo $this->webroot; ?>css/dropzone.css" rel="stylesheet">
<script src="<?php echo $this->webroot; ?>js/dropzone.js"></script>
 
    <section class="pt-5 pb-5">
          <div class="container">
              <div class="row">
                  <?php echo ($this->element('user_side_menu'));?>
                  <div class="col-lg-9 col-12">
                      <div class="right-side p-3">
                          <h3 class="text-pink"><?php echo 'Upload Images for'.' '.$productimages[0]['Product']['name'];?></h3>
                          <div class="row">
                              <div class="col-12">
                                <div class="block">
			
			<div class="image_upload_div" style="margin-top: 14px;margin-left: 25px;">
				<form action="<?php echo $this->webroot; ?>products/uploadProduct/<?php echo $this->params['pass'][0]; ?>" class="dropzone">
				</form>
			</div> 

			<?php 
			if(!empty($productimages)){
			?>
			<div class="block-content">
				<div class="span12">
					<table class="table table-hover">
					<thead>
					<tr>
						
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($productimages as $product): ?>
					<tr>
                                            
                                            <td>
                                             <img height="100" width="100" src="<?php echo($this->webroot)?>product_images/<?php echo($product['ProductImage']['name']);?>"/>
                                            <td class="actions"> 
                                                <a href="<?php echo $this->webroot;?>products/imagedelete/<?php echo $product['ProductImage']['id'];?>/<?php echo $product['ProductImage']['product_id'];?>" onclick="return confirm('Are you sure to delete?')"><img src="<?php echo $this->webroot;?>img/delete.png" title="Delete Product Image" width="24" height="24"></a>
                                            </td>
					</tr>
                   
                                        <?php endforeach; ?>
					</tbody>
					</table>
				</div>
			</div>

			<?php } ?>
		</div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </section>

    

    <!--   footer   -->

    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
   
    
   
     
    