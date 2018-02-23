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
				      <input style=" width: 72%;" type="text" class="form-control" name="data[Filter][keyword]" id="exampleInputAmount" placeholder="Keyword" value="<?php echo ((isset($this->request->params['named']['keyword']) && $this->request->params['named']['keyword']!='')?$this->request->params['named']['keyword']:'');?>">
				     
                                      <button style=" padding: 9px 15px;" type="submit" class="input-group-addon">Search</button>
				    </div>
				  </div>
				<?php echo $this->Form->end();?>
			</div>
		</section>-->
		
		<!--<section class="featured_banner">
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
		</section>-->
		
	</div>
</section>

<section class="featured_list">
	<div class="container">
		
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
					<div class="orderbosx">
						<h2>Seller Summery</h2>
						<div class="order_des order_des_new">
							<ul>							
								<li><p>Shop Name:</p>		   			<span><?php echo $shop['Shop']['name']; ?></span></li>
                                                                <li><p>Created at :</p>	<span><?php echo date('d M Y H:i a',strtotime($shop['Shop']['created_at'])); ?></span></li>
							</ul>
						</div>
					</div>
					<div class="orderbosx">
						<h2>Detail Seller Rating</h2>
						<div class="order_descr-wrapr">
							<ul class="DSR">
                                                                <?php
                                                                $shop_rating = $this->requestAction(array('controller' => 'products', 'action' => 'shop_related_rating/'.$shop['Shop']['id']));
                                                    //pr($product_rating);
                                                                if(!empty($shop_rating[0][0]['total_rating']))
                                                                    $rating = $shop_rating[0][0]['total_rating'];
                                                                else 
                                                                    $rating=0;

                                                                if(!empty($shop_rating[0][0]['accurate']))
                                                                    $accurate = $shop_rating[0][0]['accurate'];
                                                                else 
                                                                    $accurate=0;
                                                                

                                                                if(!empty($shop_rating[0][0]['product_description']))
                                                                    $product_description = $shop_rating[0][0]['product_description'];
                                                                else 
                                                                    $product_description=0;
                                                                

                                                                if(!empty($shop_rating[0][0]['satisfaction']))
                                                                    $satisfaction = $shop_rating[0][0]['satisfaction'];
                                                                else 
                                                                    $satisfaction=0;
                                                                
                                                                if(!empty($shop_rating[0][0]['ship_item']))
                                                                    $ship_item = $shop_rating[0][0]['ship_item'];
                                                                else 
                                                                    $ship_item=0;
                                                                

                                                                $rating_count = $shop_rating[0][0]['total_count'];
                                                                if($rating_count != 0){
                                                                    $rating = number_format(($rating/$rating_count),1,'.',',');
                                                                    $accurate = number_format(($accurate/$rating_count),1,'.',',');
                                                                    $product_description = number_format(($product_description/$rating_count),1,'.',',');
                                                                    $satisfaction = number_format(($satisfaction/$rating_count),1,'.',',');
                                                                    $ship_item = number_format(($ship_item/$rating_count),1,'.',',');
                                                                }
                                                                $accurate_percentage = number_format(($accurate/5)*100,2,'.',',');
                                                                $product_description_percentage = number_format(($product_description/5)*100,2,'.',',');
                                                                $satisfaction_percentage = number_format(($satisfaction/5)*100,2,'.',',');
                                                                $ship_item_percentage = number_format(($ship_item/5)*100,2,'.',',');
                                                                ?>
								<li>
									<p class="title">Accuracy :</p>
									<span class="rating-star" id="rateStarFirst"><!--<i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>--></span>
                                                                        <?php  echo '<script>
$(document).ready(function(){
$("#rateStarFirst").raty({score:'.$accurate.',readOnly:true, halfShow : true});
});</script>';
 ?>
									<span class="rating-txt"><?php echo $accurate; ?></span>
									<div class="progress">
										<div class="progress-bar progress-bar-success" style="width: <?php echo $accurate_percentage; ?>%;"><?php echo $accurate_percentage; ?>%</div>
									</div>
								</li>
								<li>
									<p class="title">Satisfaction :</p>
									<span class="rating-star" id="rateStarSecond"></span>
                                                                        <?php  echo '<script>
$(document).ready(function(){
$("#rateStarSecond").raty({score:'.$satisfaction.',readOnly:true, halfShow : true});
});</script>';
 ?>
                                                                        
									<span class="rating-txt"><?php echo $satisfaction; ?></span>
									<div class="progress">
										<div class="progress-bar progress-bar-success" style="width: <?php echo $satisfaction_percentage; ?>%;"><?php echo $satisfaction_percentage; ?>%</div>
									</div>
								</li>
								<li>
									<p class="title">Product as Described :</p>
									<span class="rating-star" id="rateStarThird"></span>
                                                                        <?php  echo '<script>
$(document).ready(function(){
$("#rateStarThird").raty({score:'.$product_description.',readOnly:true, halfShow : true});
});</script>';
 ?>
									<span class="rating-txt"><?php echo $product_description; ?></span>
									<div class="progress">
										<div class="progress-bar progress-bar-success" style="width: <?php echo $product_description_percentage; ?>%;"><?php echo $product_description_percentage; ?>%</div>
									</div>
								</li>
								<li>
									<p class="title">Shipment & Delivery :</p>
									<span class="rating-star" id="rateStarFourth"></span>
                                                                        <?php  echo '<script>
$(document).ready(function(){
$("#rateStarFourth").raty({score:'.$ship_item.',readOnly:true, halfShow : true});
});</script>';
 ?>
									<span class="rating-txt"><?php echo $ship_item; ?></span>
									<div class="progress">
										<div class="progress-bar progress-bar-success" style="width: <?php echo $ship_item_percentage; ?>%;"><?php echo $ship_item_percentage; ?>%</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="feedback_tab">
						<ul class="nav nav-tabs" role="tablist">
						    <li role="presentation" class="active"><a href="#frs" aria-controls="frs" role="tab" data-toggle="tab">Feedback Received as Seller</a></li>
						    <!--<li role="presentation"><a href="#flb" aria-controls="flb" role="tab" data-toggle="tab">Feedback Left for Buyers</a></li>-->
						</ul>
						<div class="tab-content">
						    <div role="tabpanel" class="tab-pane fade in active" id="frs">
						    	<!--<p>Viewing 1 - 04</p>-->
                                                        <?php
                                                        if(!empty($feedback)){
                                                            foreach($feedback as $feedback_key=>$feedback_val){
                                                                
    					if(!empty($feedback_val['Product']['ProductImage']))
					{
						$uploadFolder = "product_images";
						$uploadPath = WWW_ROOT . $uploadFolder;
						$imageName =$feedback_val['Product']['ProductImage'][0]['name'];
						if(file_exists($uploadPath . '/' . $imageName) && $imageName!='')
						{
							$image = $this->webroot.'product_images/'.$imageName;
						}
						else
						{ 
							$image = $this->webroot.'product_images/default.png';
						} 
					}else{
						$image = $this->webroot.'product_images/default.png';
					}
    				
                                                        ?>
						    	<ul class="fedbk">
						    		<li>
						    			<div class="image-holder"><img src="<?php echo $image;?>" alt=""></div>
						    			<div class="free-ship">
						    				<p><?php echo $feedback_val['Product']['name']; ?></p>
						    				<!--<p>New Female feedback</p>-->
						    			</div>
						    			<div class="rating">
						    				<p id="raterStarfeedback_<?php echo $feedback_key;?>"><!--<i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>--></p>
                                                                            <?php  echo '<script>
$(document).ready(function(){
$("#raterStarfeedback_'.$feedback_key.'").raty({score:'.$feedback_val['Rating']['rating'].',readOnly:true, halfShow : true});
});</script>';
 ?>
						    				<b><?php echo date('d M Y H i a',strtotime($feedback_val['Rating']['date_time'])); ?></b>
						    			</div>
						    			<div class="feedback-txt">
						    				<p><?php echo $feedback_val['Rating']['review'] ?></p>
						    			</div>
						    		</li>
									
						    	</ul>
                                                            <?php }
                                                            
                                                            echo '<div class="paging">';
                                                            echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
                                                            echo $this->Paginator->numbers(array('separator' => ''));
                                                            echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
                                                            echo '</div>';
                                        }else{
                                            echo '<div class="col-md-12"><b>No Review Found</b></div>';
                                        } ?>
						    	<div class="clearfix"></div>
						    	<!--<ul class="pagination">
						            <li><a href="#">«</a></li>
						            <li class="active"><a href="#">1</a></li>
						            <li><a href="#">2</a></li>
						            <li><a href="#">3</a></li>
						            <li><a href="#">4</a></li>
						            <li><a href="#">5</a></li>
						            <li><a href="#">»</a></li>
						        </ul>-->
						    </div>
						    <!--<div role="tabpanel" class="tab-pane fade" id="flb">bb</div>-->
						</div>
					</div>
				</div>
			
		</div>
	</div>
</section>
