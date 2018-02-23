<?php 
#pr($shop);

#pr($featured_product);
?>
<script src="<?php echo $this->webroot;?>js/jquery.raty-fa.js"></script>
<style>
button a {
color: #fff !important;
text-decoration: none;
}button a:hover, a:focus {
color: #fff;
text-decoration: underline;
}
</style>
<section class="featured-product_top">
	<div class="container">
		<div class="product_top_sec">
			<?php
                        echo $this->element('shop_detail_header', array('shop' => $shop,'userid'=>$userid));
                        ?>
		</div>
            <?php echo$this->element('shop_detail_header_bottom');?>
		<!--<section class="category_headr">
			<ul class="pull-left">
                                
						
                            
				<li><a href="<?php echo $this->webroot.'shops/details/'.$shop_id;?>">Home</a></li>
				<li><a href="<?php echo $this->webroot.'shops/list/'.$shop_id.'/category';?>">Category</a></li>
				<li><a href="<?php echo $this->webroot.'shops/list/'.$shop_id.'/sales';?>">Sale Item</a></li>
				<li><a href="<?php echo $this->webroot.'shops/list/'.$shop_id.'/top';?>">Top Selling</a></li>
				<li><a href="<?php echo $this->webroot.'shops/list/'.$shop_id.'/new';?>">New Arrivals</a></li>
				<li><a href="<?php echo $this->webroot.'shops/feedback/'.$shop_id;?>">Feedback</a></li>
				<li><a href="<?php echo $this->webroot.'shops/contact_details/'.$shop_id;?>">Contact Details</a></li>
			</ul>
			<div class="right_search pull-right">
				<?php echo $this->Form->create("Filter",array('class' => 'form-inline'));?>
				  <div class="form-group">
				    <div class="input-group">
				      <input style=" width: 70%;" type="text" class="form-control" name="data[Filter][keyword]" id="exampleInputAmount" placeholder="Keyword" value="<?php echo ((isset($this->request->params['named']['keyword']) && $this->request->params['named']['keyword']!='')?urldecode($this->request->params['named']['keyword']):'');?>">
				      
                                      <button style=" padding: 9px 15px;" type="submit" class="input-group-addon">Search</button>
				    </div>
				  </div>
				<?php echo $this->Form->end();?>
			</div>
		</section>-->
		
            <section class="featured_banner" style="max-height: 300px; overflow:hidden;">
			<?php
			$uploadPath= Configure::read('UPLOAD_SHOP_LOGO_PATH');
			$imageName = $shop['Shop']['cover_photo'];
			if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
				echo($this->Html->image('/shop_images/'.$imageName, array('alt' => $shop['Shop']['name'], 'class' => 'img-responsive', 'max-height' => '300')));
			} 
			else {
				echo($this->Html->image('/shop_images/img.png', array('alt' => $shop['Shop']['name'], 'class' => 'img-responsive', 'max-height' => '300')));
			     }
			?>
		</section>
		
	</div>
</section>
<section class="featured-bottom">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<?php
				$uploadPath= Configure::read('UPLOAD_SHOP_LOGO_PATH');
				$imageName = $shop['Shop']['logo'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/shop_images/'.$imageName, array('alt' => $shop['Shop']['name'], 'width' => '100%')));
				} 
				else {
					echo($this->Html->image('/shop_images/default.png', array('alt' => $shop['Shop']['name'], 'width' => '100%')));
				     }
				?>
			</div>
			<div class="col-md-9">
				<h2><?php echo($shop['Shop']['name'])?></h2>
				<p><?php echo($shop['Shop']['description'])?></p>
			</div>
		</div>
	</div>
</section>
<section class="featured_list">
	<div class="container">
		<?php 
		if($featured_product){
		?>
		<h3>Featured Products</h3>
		<div class="row">
			<?php 
			foreach($featured_product as $featured){
			?>
			<div class="col-md-4">
				<div class="ftr_box_top">
					<?php
					$uploadPath= Configure::read('PRODUCT_IMAGE_UPLOAD_PATH');
                                        $PrdID=$featured['Product']['id'];
                                        $prd_img=$this->requestAction(array('controller' => 'products', 'action' => 'get_product_img', $PrdID, 'admin'=>false, 'prefix' => ''));
                                        
					if(!empty($prd_img)){
						$imageName = $prd_img[0]['ProductImage']['name'];
						if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
						echo($this->Html->image('/product_images/'.$imageName, array('alt' => $featured['Product']['name'], 'width' => '100%', 'height' => '285px')));
						} 
					} else {
						echo($this->Html->image('/product_images/default.png', array('alt' => $featured['Product']['name'], 'width' => '100%', 'height' => '285px')));
					}
					?>
					<div class="bottom_sec_ftr">
						<h4><?php echo($featured['Product']['name'])?></h4>
					</div>
				</div>
			</div>
			<?php 
			}
			?>
		</div>
		<?php 
		}
		?>
		<div class="row">
			<div class="col-md-3 category_left">
				<h2>Categories</h2>
				<div class="check_body">
						<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						  <?php
							if($shop_categories){
								$i=1;
								foreach($shop_categories as $category){
                                                                    $cats_count = $this->requestAction(array('controller' => 'products', 'action' => 'category_related_product/'.$category['Category']['id'].'/'.$shop['Shop']['id']));
						   ?>
						  <div class="panel panel-default">
						    <div class="panel-heading" role="tab" id="heading<?php echo($i);?>">
						      <h4 class="panel-title">
						        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo($i);?>" aria-expanded="true" aria-controls="collapse<?php echo($i);?>">
						          <?php echo($category['Category']['name'])?> <span>(<?php echo $cats_count; ?>) </span>
						        </a>
						      </h4>
						    </div>
						    <div id="collapse<?php echo($i);?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo($i);?>">
						      <div class="panel-body">
								<?php 
								//$sub_cat = explode(',',$shop['Shop']['sub_categories']);
								$subcats = $this->requestAction(array('controller' => 'categories', 'action' => 'getsubcat/'.$category['Category']['id']));
                                                                //pr($subcats);
								if(!empty($subcats))
							     {
								?>
								<ul>
								<?php
									  foreach($subcats as $subcat)
									  {
										if(in_array($subcat['Category']['id'], $product_related_subcategory)){
                                                                                    $subcats_count = $this->requestAction(array('controller' => 'products', 'action' => 'subcategory_related_product/'.$subcat['Category']['id'].'/'.$shop['Shop']['id']));
								?>
                                                                    <li><a href="<?php echo $this->webroot.'shop/'.$shop['Shop']['slug'].'/'.$shop_id.'/'.$subcat['Category']['id'];?>"><?php echo $subcat['Category']['name']?><span>(<?php echo $subcats_count; ?>)</span></a></li>
								<?php  	}
									  }?>
								</ul>
								<?php  
								}?>
						      </div>
						    </div>
						  </div>
							<?php $i++; } } ?>
						  
						</div>
					</div>
			</div>
			<div class="col-md-9">
				<div class="all-product">
					<ul class="pull-left">
						<li class="active"><a href="<?php echo $this->webroot.'shop/'.$shop['Shop']['slug'].'/'.$shop_id;?>">All Products</a></li>
						<li><a href="<?php echo $this->webroot.'shops/list/'.$shop_id.'/sales';?>">Sale Products</a></li>
						<li><a href="<?php echo $this->webroot.'shops/list/'.$shop_id.'/new';?>">New Arrivals</a></li>
						<!--<li><a href="#">Recommended</a></li>-->
						<li><a href="<?php echo $this->webroot.'shops/list/'.$shop_id.'/top';?>">Top Selling</a></li>
					</ul>
					<!--<div class="view pull-right">
						View <a href="" class="fa fa-th-large"></a><a href="" class="fa fa-th-list"></a>
					</div> -->
				</div>
				<div class="row">
					<?php 
					if($all_products){
						foreach($all_products as $product_key=>$featured){
                                                    //pr($featured);
                                                    $product_rating = $this->requestAction(array('controller' => 'products', 'action' => 'prodoct_related_rating/'.$featured['Product']['id']));
                                                    if(!empty($product_rating[0][0]['total_rating']))
                                                        $rating = $product_rating[0][0]['total_rating'];
                                                    else 
                                                        $rating=0;
                                                    $rating_count = $product_rating[0][0]['total_count'];
					?>
					<div class="col-md-4">
						<div class="feature_box">
							<div class="feature_box_img">
								<?php
								$uploadPath= Configure::read('PRODUCT_IMAGE_UPLOAD_PATH');
                                                                $PrdID=$featured['Product']['id'];
                                                                $prd_img=$this->requestAction(array('controller' => 'products', 'action' => 'get_product_img', $PrdID, 'admin'=>false, 'prefix' => ''));
                                                                
								if(!empty($prd_img)){
                                                                    $imageName = $prd_img[0]['ProductImage']['name'];
                                                                    if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
                                                                    echo($this->Html->image('/product_images/'.$imageName, array('alt' => $featured['Product']['name'], 'width' => '100%', 'height' => '285px')));
                                                                    } 
								} else {
                                                                    echo($this->Html->image('/product_images/default.png', array('alt' => $featured['Product']['name'], 'width' => '100%', 'height' => '285px')));
								}
								?>
							</div>
                                                    <p><a href="<?php echo $this->webroot.'products/view/'.base64_encode($featured['Product']['id']).'/'.$featured['Product']['category_id'];?>"><?php echo($featured['Product']['name'])?></a></p>
							<!--<b><span>$99.00</span> $80.00</b> -->
                                                        <b>
                                                            <?php if($featured['Product']['sale_on'] == "Y" && $featured['Product']['discount'] > 0){?>
									<span>$<?php echo $featured['Product']['price_lot'];?></span> $<?php echo ($featured['Product']['price_lot']-($featured['Product']['price_lot']*$featured['Product']['discount'])/100);?>
								<?php }else{?>
									$<?php echo $featured['Product']['price_lot'];?> 
								<?php }?>
                                                            
                                                        </b>
							<div class="clearfix"></div>
                                                        <aside id="rateStar_<?php echo $product_key;?>" style="vertical-align: -moz-middle-with-baseline; margin-top: 10px;">
								<!--<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>-->
								
							</aside>
                                                        <p style="float:left">	(<?php echo $rating_count; ?>) </p>
                                                        <?php  echo '<script>
$(document).ready(function(){
$("#rateStar_'.$product_key.'").raty({score:'.$rating.',readOnly:true, halfShow : true});
});</script>';
 ?>
							<em>Orders (<?php echo $featured['Product']['sold_quantity'] ?>)</em>
						</div>
					</div>
					<?php 
						}
                                                echo '<div class="paging">';
                                                echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
                                                echo $this->Paginator->numbers(array('separator' => ''));
                                                echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
                                                echo '</div>';
					} else{
                                            echo '<div class="col-md-12"><b>No Product Found</b></div>';
                                        }
					?>
				</div>
			</div>
			
		</div>
	</div>
</section>
