<script src="<?php echo $this->webroot;?>js/jquery.raty-fa.js"></script>
<?php
 if($product['Product']['sale_on']=='Y' && $product['Product']['discount'] > 0)
 { 
     //echo 'discount';
 	$price = ($product['Product']['price_lot']-(($product['Product']['price_lot']*$product['Product']['discount'])/100)); 
 } else{ 
 	$price = $product['Product']['price_lot']; 
        
 }
 
 if($price<0)
 {
 	$price=0;
        $Cart_price=$price; 
 }else{
     $Cart_price=$price; 
 }
 $price = number_format($price,2,'.',',');
 if($product['Product']['unit_type']=='W')
 {
 	$quantityLot = $product['Product']['quantity_lot'];
 }else{
 	$quantityLot = 1;
 }
?>

<link href="<?php echo $this->webroot;?>css/jquery.bxslider.css" rel="stylesheet">
<section class="featured_list">
		<div class="container">
			
			
			<div class="row">
			
			
			<div class="product_title" style=" border-bottom: 1px solid #c4c3c3; padding-bottom: 10px; margin-bottom: 30px;">
						<div class="row">
							
							<div class="col-md-12">
							<div>
							<div role="form" style="width: 12%; float: left;">
									<div class="checkbox">
									  <label><a style="color:#feb86e;" href=""><i class="fa fa-arrow-left" aria-hidden="true"></i>  Back to Search</a></label>
									</div>
									</div>
								<ol class="breadcrumb" style=" padding: 12px 15px; margin-bottom: 12px;    background-color: transparent;width: 35%;float: left;">
								  <li><a href="<?php echo $this->webroot;?>">Home</a></li>
								  <?php 
								  if(isset($categorypro) && !empty($categorypro))
								  {
								  	if(empty($categorypro['ParentCategory']['id']))
								  	{	
								  ?>
								  		<li><a href="<?php echo $this->webroot.'products/list/'.$categorypro['Category']['name'].'/'.$categorypro['Category']['id'];?>"><?php echo $categorypro['Category']['name']?></a> </li>
								  <?php 
								  	}
								  	else{
								  ?>
								  		<li><a href="<?php echo $this->webroot.'products/list/'.$categorypro['ParentCategory']['name'].'/'.$categorypro['ParentCategory']['id'];?>"><?php echo $categorypro['ParentCategory']['name']?></a></li>
								  		
								  		<li><a href="<?php echo $this->webroot.'products/list/'.$categorypro['Category']['name'].'/'.$categorypro['Category']['id'];?>"><?php echo $categorypro['Category']['name']?></a> </li>
								  <?php
								  	}
								  }	
								  ?>
								 
								  
								</ol>
								
								  	<div role="form" style="width: 50%; float: left;">
                                                                            <?php 
                                                                            $todayDate = strtotime(gmdate('Y-m-d H:i:s'));
                                                                            $shop_created_date = strtotime($shop['Shop']['created_at']);
                                                                            
                                                                            $open_year = $this->requestAction(array('controller' => 'orders', 'action' => 'date_different_day', $shop_created_date, $todayDate, 'admin'=>false, 'prefix' => '')); 
                                                                            //shop_related_positive_rating$product_rating = $this->requestAction(array('controller' => 'products', 'action' => 'prodoct_related_rating/'.$product['Product']['id']));
                                                                            $rating = $this->requestAction(array('controller' => 'products', 'action' => 'shop_related_positive_rating', $shop['Shop']['id'], 'admin'=>false, 'prefix' => ''));
                                                                            //pr($rating);
                                                                            if($rating[1]!=0){
                                                                                $rating_percentage = ($rating[0]/$rating[1])*100;
                                                                            }else{
                                                                                $rating_percentage = 0;
                                                                            }
                                                                            ?>
									<div class="checkbox">
									  <label>Visit Store: <a href="<?php echo $this->webroot.'shop/'.$shop['Shop']['slug'].'/'.base64_encode($shop['Shop']['id']);?>"><?php echo $shop['Shop']['name']?></a> <span style="padding:2px 5px; background:#ebebeb; border-radius:5px;"> Open: <span style="color:#ff7e5d;"><?php echo $open_year; ?></span> </span><span> Feedback: <span><?php echo number_format($rating_percentage, 2, '.', '').'% Positive Feedback'; ?></span> </span></label>
									</div>
                                                    </div>
									
                                            <!--<form role="form" style="width: 25%; float: left;">
                                            <div class="checkbox">
                                              <label>Feedback Score:  <span style="padding:2px 5px; color:#7f94c0; font-size: 11px;"> 100% Positive Feedback </span></label>
                                            </div>
                                            </form>-->
								 
								
                                        </div>
                                    </div>
                                </div>
                            </div>
			
			</div>
                        <div id="AjaxMsgFrom"></div>
			<div class="row">
				<div class="col-md-5">
					<div class="image_main" style="padding: 5px;
    border: 1px solid black;">
    					<?php
                                        $PrdID=$product['Product']['id'];
                                        $prd_img=$this->requestAction(array('controller' => 'products', 'action' => 'get_product_img', $PrdID, 'admin'=>false, 'prefix' => ''));
    					if(!empty($prd_img))
					{
						$uploadFolder = "product_images";
						$uploadPath = WWW_ROOT . $uploadFolder;
						$imageName =$prd_img[0]['ProductImage']['name'];
						if(file_exists($uploadPath . '/' . $imageName) && $imageName!='')
						{
                                                    $image = $this->webroot.'product_images/'.$imageName;
                                                    $imgName=$imageName;
						}else{ 
                                                    $image = $this->webroot.'product_images/default.png';
                                                    $imgName='default.png';
						} 
					}else{
                                            $image = $this->webroot.'product_images/default.png';
                                            $imgName='default.png';
					}
    					?>
						<img src="<?php echo $image;?>" style="width: 100%;" class="img-responsive" alt="">
					</div>
					<?php 
					if(!empty($prd_img))
					{
						
					?>
					<div class="row">
                                            <div class="col-md-12">
                                                <div class="image_main_small" style="  padding: 5px;    border: 1px solid black;    margin-top: 5px;">
                                                    <ul style="padding: 0; margin:0 auto;">
                                                        <?php
                                                        foreach($prd_img as $proimage)
                                                        {
                                                                $imageName =$proimage['ProductImage']['name'];
                                                                if(file_exists($uploadPath . '/' . $imageName) && $imageName!='')
                                                                {
                                                                        $imageSmall = $this->webroot.'product_images/'.$imageName;
                                                                }
                                                                else
                                                                { 
                                                                        $imageSmall = $this->webroot.'product_images/default.png';
                                                                }
                                                        ?>
                                                        <li class="detail_image" style="width: 32.5%;display: inline-block; cursor: pointer;"><img src="<?php echo $imageSmall;?>" style="width: 100%;height:127px;" class="img-responsive more_img" alt=""></li>

                                                        <?php 
                                                        }?>
                                                    </ul>

                                                </div>
                                            </div>
					</div>
                                    <?php }?>
				</div>
				<div class="col-md-7">
					<div class="row">
						<div class="col-md-10">
							<h2 style= " margin: 0 0 15px 0;"><?php echo $product['Product']['name'];?></h2>
						</div>
                                            <div class="col-md-1">
                                                    <?php if($product['Product']['id'] != $userid) {                                                       
                                                        if($wishlist_count != 0){
                                                    ?>
                                                <a href="javascript:;" class="favourite" fab_id="<?php echo base64_encode($product['Product']['id']); ?>" fab_type="0"><img  src="<?php echo $this->webroot;?>images/red_heart.png" class="img-responsive" style="margin: 0 auto;"></a>
                                                    <?php }else{
                                                        ?>
                                                        <a href="javascript:;" class="favourite" fab_id="<?php echo base64_encode($product['Product']['id']); ?>" fab_type="1"><img src="<?php echo $this->webroot;?>images/white_heart.png" class="img-responsive" style="margin: 0 auto;"></a>
                                                <?php
                                                    }} ?>
						</div>
                                            <div class="col-md-1">
                                                    <?php if($product['Product']['id'] != $userid) {?>
							<img src="<?php echo $this->webroot;?>images/orange-message-2566.png" class="img-responsive" data-toggle="modal" data-target="#contactnow" style="margin: 0 auto;height: 25px;cursor:pointer;">
                                                        <?php } ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="btn price text-center" style="padding: 15px; background:#d6d6d6; width:100%;">
								<span style="font-size: 22px;font-weight: bold;">Price:</span> &nbsp; &nbsp; <span style="font-size: 22px;font-weight: bold; color:#ff6630;">US $<?php echo $price;?>/<?php echo $quantityLot.' Piece';?></span>
							</div>
						</div>
					</div>
					
					
					<form name="ListingCart" id="ListingCart" action="<?php echo $this->webroot; ?>products/add_to_cart/<?php echo((isset($product['Product']['id']) && $product['Product']['id']!='')?$product['Product']['id']:0);?>" method="post" autocomplete="off">
				<input type="hidden" name="data[TempCart][shop_id]" id="productShopId" class="contact_text_box" value="<?php echo((isset($product['Product']['shop_id']) && $product['Product']['shop_id']!='')?$product['Product']['shop_id']:0);?>">
				<input type="hidden" name="data[TempCart][prd_id]" id="productListId" class="contact_text_box" value="<?php echo((isset($product['Product']['id']) && $product['Product']['id']!='')?$product['Product']['id']:0);?>">
				<input type="hidden" name="data[TempCart][name]" id="productName" class="contact_text_box" value="<?php echo((isset($product['Product']['name']) && $product['Product']['name']!='')?$product['Product']['name']:'');?>">
				<input type="hidden" name="data[TempCart][image]" id="productImage" class="contact_text_box" value="<?php echo((isset($imgName) && $imgName!='')?$imgName:'');?>">
				
				<input type="hidden" name="data[TempCart][price]" id="productPrice" class="contact_text_box" value="<?php echo((isset($Cart_price) && $Cart_price!='')?$Cart_price:0);?>">
				<input type="hidden" name="data[TempCart][shipping_time]" id="productShippingTime" class="contact_text_box" value="<?php echo((isset($product['Product']['shipping_time']) && $product['Product']['shipping_time']!='')?$product['Product']['shipping_time']:'');?>">
				<input type="hidden" name="data[TempCart][processing_time]" id="productProcessingTime" class="contact_text_box" value="<?php echo((isset($product['Product']['processing_time']) && $product['Product']['processing_time']!='')?$product['Product']['processing_time']:'');?>">
                                <input type="hidden" name="data[TempCart][product_woner_id]" id="product_woner_id" class="contact_text_box" value="<?php echo((isset($product['Product']['user_id']) && $product['Product']['user_id']!='')?$product['Product']['user_id']:'');?>">
				
					<div class="row" style="margin-top: 10px">
						<div class="col-md-9">
							<div class="input_div" >
								 <span style="font-size: 18px; color:#606060">Quantity:</span> 
								 <input type="number" name="data[TempCart][quantity]" id="productQuantity" class="contact_text_box" placeholder="Enter Quantity" style="width:120px;" value="1">
								 <span id="QuantityErr" style="color:red;font-size:12px;"></span>
								 &nbsp; <span style="font-size: 15px; color:#606060">Stock (<?php echo isset($product['Product']['quantity'])?$product['Product']['quantity']:'';?> pieces) available </span>
							</div>
							 
							 <div class="input_div" style="margin:10px 0;" >
							 <span style="font-size: 18px; color:#606060">Total Price:</span>&nbsp; <span id="product_total_price" style="font-size: 20px;font-weight: bold; color:#ff6630;">USD $<?php echo isset($Cart_price)?number_format($Cart_price):'0';?></span>
							 </div>
 
						</div>
						<!--<div class="col-md-3 text-center">
							<span style="color:#649c68; font-size:15px;">Sold: 20 pieces</span>
						</div>-->
					</div>
					
					<div class="row">
                                            <?php
                                            $is_close=isset($shop['Shop']['is_close'])?$shop['Shop']['is_close']:'';
                                            $shop_id=isset($shop['Shop']['id'])?$shop['Shop']['id']:'';
                                            $shop_status = $this->requestAction(array('controller' => 'shops', 'action' => 'get_shop_status', $shop_id,'admin'=>false, 'prefix' => ''));
                                            //pr($shop_status);
                                            if(count($shop_status)>0){
                                                $from_date=date('dS M, Y',strtotime($shop_status['CloseShop']['from_date']));
                                                $to_date=date('dS M, Y',strtotime($shop_status['CloseShop']['to_date']));
                                                echo '<div class="col-md-10"><div class="alert alert-danger"><p>Shop is closed from '.$from_date.' to '.$to_date.'.</p></div></div>';
                                            }else{
                                            ?>
                                            <div class="col-md-5">
                                                <div class="btn price text-center" onclick="chkvalid()" style="padding: 15px 20px; background:#ff6624; width: 80%">
                                                    <span style="font-size: 18px;font-weight: bold; color:#fff;" >Buy Now</span>
                                                </div>

                                            </div>
                                            <div class="col-md-5">
                                                <div class="btn price text-center" style="padding: 15px 20px; background:#ffa834; width: 80%">
                                                    <span style="font-size: 18px;font-weight: bold; color:#fff;" onclick="chk_add_to_cart_valid()"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add To Cart</span>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            ?>
					</div>
					</form>
					<div class="row" style="margin:15px 0;">
						<div class="col-md-12">
						<ul style="padding: 0;">
							<li style="width:25%; display: inline-block; color: #606060;">Return Policy:</li>
							<li style="width:55%; display: inline-block; vertical-align: top; word-wrap: break-word;"><?php echo $product['Product']['return_policy'];?></li>
						</ul>
                                                <ul style="padding: 0;">
                                                    <li style="width:25%; display: inline-block; color: #606060;">Processing Time</li>
                                                    <li style="width:55%; display: inline-block;vertical-align: top; "><?php echo $product['Product']['processing_time'];?></li>
						</ul>    
						<ul style="padding: 0;">
                                                    <li style="width:25%; display: inline-block; color: #606060;">Shipment Time</li>
                                                    <li style="width:55%; display: inline-block;vertical-align: top; "><?php echo $product['Product']['shipping_time'];?></li>
						</ul>
							
						</div>
						
					</div>
					
					<div class="row">
						<?php if($product['Product']['is_featured']=='Y'){ ?>
						<div class="col-md-4">
							<span style="color:#72bb53; font-size: 20px;"><i class="fa fa-check" aria-hidden="true"></i>  Featured Product</span>
						</div>
						<?php }
                                                $product_rating = $this->requestAction(array('controller' => 'products', 'action' => 'prodoct_related_rating/'.$product['Product']['id']));
                                                    //pr($product_rating);
                                                    if(!empty($product_rating[0][0]['total_rating']))
                                                        $rating = $product_rating[0][0]['total_rating'];
                                                    else 
                                                        $rating=0;
                                                    
                                                    if(!empty($product_rating[0][0]['accurate']))
                                                        $accurate = $product_rating[0][0]['accurate'];
                                                    else 
                                                        $accurate=0;
                                                    
                                                    if(!empty($product_rating[0][0]['product_description']))
                                                        $product_description = $product_rating[0][0]['product_description'];
                                                    else 
                                                        $product_description=0;
                                                    
                                                    if(!empty($product_rating[0][0]['satisfaction']))
                                                        $satisfaction = $product_rating[0][0]['satisfaction'];
                                                    else 
                                                        $satisfaction=0;
                                                    if(!empty($product_rating[0][0]['ship_item']))
                                                        $ship_item = $product_rating[0][0]['ship_item'];
                                                    else 
                                                        $ship_item=0;
                                                    
                                                    $rating_count = $product_rating[0][0]['total_count'];
                                                    if($rating_count != 0){
                                                        $rating = $rating/$rating_count;
                                                        $accurate = $accurate/$rating_count;
                                                        $product_description = $product_description/$rating_count;
                                                        $satisfaction = $satisfaction/$rating_count;
                                                        $ship_item = $ship_item/$rating_count;
                                                    }
                                                ?>
						<div class="col-md-6">
							<span>
								<aside>
								<i style=" font-size: 25px; font-style: normal;">Rating: </i>
                                                                <span id="rateStarFirst" style="color:#ff6624; font-size: 25px;">
									<!--<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
									<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
									<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
									<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
									<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>-->
                                                                </span>
                                                                <?php  echo '<script>
$(document).ready(function(){
$("#rateStarFirst").raty({score:'.$rating.',readOnly:true, halfShow : true});
});</script>';
 ?>
									
							</span>
						</div>
                                                
                                            <div class="col-md-2">
							<span>
								<?php echo $product['Product']['sold_quantity'] ?>  Orders
									
							</span>
						</div>
					</div>
					
				</div>
			</div>
			
                        <div class="row" style="margin: 15px 0;">
                            <div class="col-md-12"  style="padding: 0px;">
                                <ul style="padding: 0px;">
                                    <li style="font-size:19px;font-weight: bold;color: #ff6630; width:10%; display: inline-block;">Keywords :</li>
                                    <li style="font-size:17px; width:80%; display: inline-block;vertical-align: -webkit-baseline-middle;"><?php echo $product['Product']['keywords'];?> </li>
                                </ul>
                            </div>
                        </div>
		</div>
	</section>
	
	
	
	
	
	
		<section class="details">
		<div class="container">
			<?php
                        $product_feedback = $this->requestAction(array('controller' => 'products', 'action' => 'prodoct_related_feedback/'.$product['Product']['id']));
                        ?>
			<div class="detail_tab">
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active" style="margin-left: 0px;"><a href="#Details"  role="tab" data-toggle="tab">Product Details</a></li>
						    <li role="presentation" ><a href="#Feeds"  role="tab" data-toggle="tab">Feedback (<?php echo count($product_feedback); ?>)</a></li>
						    <li role="presentation" ><a href="#Deliverys"  role="tab" data-toggle="tab">Delivery & Terms</a></li>
						   <!-- <li style="background: transparent; float:right; text-align: right; color:#337ab7;" >Report Product</li>-->
						    
						</ul>

						  <div class="tab-content">
						     <div role="tabpanel" class="tab-pane active" id="Details">
						    	<div class="row">
						    		<div class="col-md-12">
						    			<h2>ITEM SPECIFICATION</h2>
						    		</div>
						    	</div>
						    	<div class="row">
						    		<div class="col-md-6 col-sm-6 col-xs-6 text-center">
						    			<p>Product SKU</p>
						    			<p>Product Name</p>
						    			<p>Category</p>
						    			<p>Sub-Category</p>
						    			<p>Weight</p>
						    			<p>Size</p>
						    			
						    		</div>
                                                                
						    		
						    		<div class="col-md-6 col-sm-6 col-xs-6 text-center">
						    			<p><?php echo $product['Product']['sku'];?></p>
						    			<p><?php echo $product['Product']['name'];?></p>
						    			<p><?php echo $product['Category']['name'];?></p>
						    			<p><?php echo $product['SubCategory']['name'];?></p>
						    			<p><?php echo $product['Product']['package_weight'].$product['Product']['package_unit'];?></p>
						    			<p><?php echo $product['Product']['package_size1'].$product['Product']['package_size_unit'].' x '.$product['Product']['package_size2'].$product['Product']['package_size_unit'].' x '.$product['Product']['package_size3'].$product['Product']['package_size_unit'];?></p>
						    			
						    		</div>
						    	</div>
						    	
						    	
						    	<?php 
							if($product['Product']['item_description']!=''){?>
						    	<div class="row">
						    		<div class="col-md-12">
						    			<h2>ITEM DESCRIPTION</h2>
						    		</div>
						    	</div>
						    	<div class="row">
						    		<div class="col-md-12">
						    			<?php echo $product['Product']['item_description'];?>
						    		</div>
						    	</div>
						    	<?php 
						    	}?>
						    	
						    	<div class="row">
						    		<div class="col-md-12">
						    			<h2>PACKAGING DETAIL</h2>
						    		</div>
						    	</div>
						    	
						    	<div class="row">
						    		
						    		<div class="col-md-12">
						    			<ul>
						    				<li style="font-size: 16px; width: 15%; display: inline-block;">Package Weight :</li>
						    				<li style="font-size: 16px; width: 65%; display: inline-block;"><?php echo $product['Product']['package_weight'].$product['Product']['package_unit'];?></li>
						    			</ul>
						    		</div>
						    		<div class="col-md-12">
						    			<ul>
						    				<li style="font-size: 16px; width: 15%; display: inline-block;">Package Size :</li>
						    				<li style="font-size: 16px; width: 65%; display: inline-block;"><?php echo $product['Product']['package_size1'].$product['Product']['package_size_unit'].' x '.$product['Product']['package_size2'].$product['Product']['package_size_unit'].' x '.$product['Product']['package_size3'].$product['Product']['package_size_unit'];?></li>
						    			</ul>
						    		</div>
						    	</div>
						    	
						    	
						    	
						    </div>
						    
						      <div role="tabpanel" class="tab-pane " id="Feeds">
						    	<div class="row">
						    		<div class="col-md-6">
						    		   <div class="rating_details">
											<span>
												<aside>
													<!--<i class="fa fa-star" style="color:#ff6624; font-size: 50px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 50px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 50px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 50px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 50px;"></i>-->
                                                                                                    <span id="rateStarSecond" style="color:#ff6624; font-size: 50px;">
                                                                                                        <?php  echo '<script>
$(document).ready(function(){
$("#rateStarSecond").raty({score:'.$rating.',readOnly:true, halfShow : true});
});</script>';
 ?>
                                                                                                        
                                                                                                    </span>
												</aside>
													
											</span>
											<h2>Average Rating: <?php echo number_format($rating,1,'.',','); ?></h2>
											<h2>Total Ratings: <?php echo $rating_count; ?></h2>
										 </div>
										</div>
										
										<div class="col-md-6">
					    		<h2>Product Feedback</h2>
										<table class="table detail_table" style="margin: 10px 0;">
											
											<tbody>
											  <tr>
											    <td>Accuracy:</td>
											    <td>
											     <span>
												  <aside>
													<!--<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>-->
                                                                                                      <span id="rateStarThird" style="color:#ff6624; font-size: 25px;">
                                                                                                        <?php  echo '<script>
$(document).ready(function(){
$("#rateStarThird").raty({score:'.$accurate.',readOnly:true, halfShow : true});
});</script>';
 ?>
                                                                                                        
                                                                                                    </span>
												  </aside>
													
											     </span>
											    </td>
											    
											  </tr>
											  <tr>
											    <td>Satisfaction:</td>
											    <td>
											     <span>
												  <aside>
													<!--<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>-->
                                                                                                      <span id="rateStarFourth" style="color:#ff6624; font-size: 25px;">
                                                                                                        <?php  echo '<script>
$(document).ready(function(){
$("#rateStarFourth").raty({score:'.$satisfaction.',readOnly:true, halfShow : true});
});</script>';
 ?>
                                                                                                        
                                                                                                    </span>
												  </aside>
													
											     </span>
											    </td>
											   
											  </tr>
											  <tr>
											    <td>Product as Described:</td>
											    <td>
											     <span>
												  <aside>
													<!--<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>-->
                                                                                                      <span id="rateStarFifth" style="color:#ff6624; font-size: 25px;">
                                                                                                        <?php  echo '<script>
$(document).ready(function(){
$("#rateStarFifth").raty({score:'.$product_description.',readOnly:true, halfShow : true});
});</script>';
 ?>
                                                                                                        
                                                                                                    </span>
												  </aside>
													
											     </span>
											    </td>
											   
											  </tr>
											  <tr>
											    <td>Shipment & Delivery:</td>
											    <td>
											     <span>
												  <aside>
													<!--<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>-->
                                                                                                      <span id="rateStarSixth" style="color:#ff6624; font-size: 25px;">
                                                                                                        <?php  echo '<script>
$(document).ready(function(){
$("#rateStarSixth").raty({score:'.$ship_item.',readOnly:true, halfShow : true});
});</script>';
 ?>
                                                                                                        
                                                                                                    </span>
												  </aside>
													
											     </span>
											    </td>
											   
											  </tr>
											</tbody>
										</table>
						    		</div>
									</div>

                                <div class="row">
						    		<div class="col-md-12" style="margin: 10px 0;">
						    			<h2>PACKAGING DETAIL</h2>
						    		</div>
						    	</div>
						    	
						    	<div class="row">
                                                            <?php
                                                               
                                                               //pr($product_feedback);
                                                               if(!empty($product_feedback)){
                                                                   foreach($product_feedback as $product_feedback_key=>$product_feedback_val){
                                                                       $feedback_rating = $product_feedback_val['Rating']['rating'];
                                                                       //echo $feedback_rating;
                                                                       $feedback_review = $product_feedback_val['Rating']['review'];
                                                                       $feedback_date = date('d M Y H i a',strtotime($product_feedback_val['Rating']['date_time']));
                                                            ?>
						    		<div class="col-md-12">
						    			<ul class="gap_below">
						    				<li style="font-size: 16px; width: 15%; display: inline-block;">
						    				  <span>
												<aside id="raterStarfeedback_<?php echo $product_feedback_key;?>" style="color:#ff6624; font-size: 20px;">
											
													<!--<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>-->
                                                                                                </aside>
                                                                                      <?php  echo '<script>
$(document).ready(function(){
$("#raterStarfeedback_'.$product_feedback_key.'").raty({score:'.$feedback_rating.',readOnly:true, halfShow : true});
});</script>';
 ?>
											  </span>
											  <p><?php echo $feedback_date; ?></p>
											</li>
						    				<li style="font-size: 16px; width: 65%; display: inline-block;"><?php echo $feedback_review; ?></li>
						    			</ul>
						    		</div>
                                                                   <?php }} ?>
						    		<!--<div class="col-md-12">
						    			<ul class="gap_below">
						    				<li style="font-size: 16px; width: 15%; display: inline-block;">
						    				  <span>
												<aside>
											
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													
											  </span>
											  <p>18 Dec 2015 04:56</p>
											</li>
						    				<li style="font-size: 16px; width: 65%; display: inline-block;">written feedback goes here. written feedback goes here. written feedback goes here.</li>
						    			</ul>
						    		</div>
						    		<div class="col-md-12">
						    			<ul class="gap_below">
						    				<li style="font-size: 16px; width: 15%; display: inline-block;">
						    				  <span>
												<aside>
											
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													<i class="fa fa-star" style="color:#ff6624; font-size: 25px;"></i>
													
											  </span>
											  <p>18 Dec 2015 04:56</p>
											</li>
						    				<li style="font-size: 16px; width: 65%; display: inline-block;">written feedback goes here. written feedback goes here. written feedback goes here.</li>
						    			</ul>
						    		</div>-->
						    		
						    	</div>
					    		
						    	</div>
						
						    
						    <div role="tabpanel" class="tab-pane " id="Deliverys">
						    	<div class="row">
						    		<div class="col-md-12">
						    			
						    			<?php echo $product['Product']['delivery_terms'];?>
						    		</div>
						    	</div>
						    </div>
						  </div>
					</div>


<?php
if(isset($same_products) && !empty($same_products))
{
?>
<div class="row">
	<div class="col-md-12">
		<h3>More Products From This Seller</h3>
		<div class="row">
			<div class="slider5">
				<?php
				foreach($same_products as $relprod_key=>$relprod)
				{
                                        $product_rating = $this->requestAction(array('controller' => 'products', 'action' => 'prodoct_related_rating/'.$relprod['Product']['id']));
                                        if(!empty($product_rating[0][0]['total_rating']))
                                            $rating = $product_rating[0][0]['total_rating'];
                                        else 
                                            $rating=0;
                                        $rating_count = $product_rating[0][0]['total_count'];
                                        if($rating_count != 0){
                                            $rating = $rating/$rating_count;                                           
                                        }
                                        
                                        $MorePrdID=$relprod['Product']['id'];
                                        $More_prd_img=$this->requestAction(array('controller' => 'products', 'action' => 'get_product_img', $MorePrdID, 'admin'=>false, 'prefix' => ''));
                                        
					if(!empty($More_prd_img)){
						$uploadFolder = "product_images";
						$uploadPath = WWW_ROOT . $uploadFolder;
						$imageName =$More_prd_img[0]['ProductImage']['name'];
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
				<div class="col-md-4">
					<div class="slide">
                                                <?php if($relprod['Product']['sale_on'] == "Y" && $relprod['Product']['discount'] > 0){
                                                  ?>
                                                     <div class="sales_back">
                                                                <p style="color:#FFF; font-weight:bold;padding: 15px 18px; font-size:15px; text-align:center;"> <?php echo $relprod['Product']['discount']; ?>% <br />Off</p>
                                                     </div>
                                                <?php }  ?>
						<div class="feature_box">
							<div class="feature_box_img">
								<a href="<?php echo $this->webroot.'products/view/'.base64_encode($relprod['Product']['id']);?>"><img src="<?php echo $image?>" alt="" /></a>
							</div>
							<p><a href="<?php echo $this->webroot.'products/view/'.base64_encode($relprod['Product']['id']);?>"><?php echo $relprod['Product']['name'];?></a></p>
							<b><?php if($relprod['Product']['sale_on'] == "Y" && $relprod['Product']['discount'] > 0){?>
									<span>$<?php echo $relprod['Product']['price_lot'];?></span> $<?php echo ($relprod['Product']['price_lot']-($relprod['Product']['price_lot']*$relprod['Product']['discount'])/100);?>
								<?php }else{?>
									$<?php echo $relprod['Product']['price_lot'];?> 
								<?php }?></b>
							<div class="clearfix"></div>
                                                        <aside id="similarrateStar_<?php echo $relprod_key;?>" style="margin-top: 10px;vertical-align: -moz-middle-with-baseline;">
								<!--<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>-->
								
							</aside>
                                                        <p style="float:left">(<?php echo $rating_count; ?>) </p>
                                                        <?php  echo '<script>
$(document).ready(function(){
$("#similarrateStar_'.$relprod_key.'").raty({score:'.$rating.',readOnly:true, halfShow : true});
});</script>';
 ?>
							
						</div>
					</div>
				</div>
				<?php }?>
				
						
			</div>
		</div>
	</div>
</div>
<?php }?>	


<?php
if(isset($popular_products) && !empty($popular_products))
{
?>
<div class="row">
	<div class="col-md-12">
		<h3>Popular Products From Other Sellers</h3>
		<div class="row">
			<div class="slider5">
				<?php
				foreach($popular_products as $popprod_key=>$popprod)
				{
                                        $product_rating = $this->requestAction(array('controller' => 'products', 'action' => 'prodoct_related_rating/'.$popprod['Product']['id']));
                                        if(!empty($product_rating[0][0]['total_rating']))
                                            $rating = $product_rating[0][0]['total_rating'];
                                        else 
                                            $rating=0;
                                        $rating_count = $product_rating[0][0]['total_count'];
                                        if($rating_count != 0){
                                            $rating = $rating/$rating_count;
                                        }
                                        
                                        $PopularPrdID=$popprod['Product']['id'];
                                        $Popular_prd_img=$this->requestAction(array('controller' => 'products', 'action' => 'get_product_img', $PopularPrdID, 'admin'=>false, 'prefix' => ''));
                                        
					if(!empty($Popular_prd_img)){
                                            $uploadFolder = "product_images";
                                            $uploadPath = WWW_ROOT . $uploadFolder;
                                            $imageName =$Popular_prd_img[0]['ProductImage']['name'];
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
				<div class="col-md-4">
					<div class="slide">
                                            <?php if($popprod['Product']['sale_on'] == "Y"){ 
                                                if($popprod['Product']['discount'] > 0 ){ 
                                            ?>
                                                    <div class="sales_back">
                                                    <p style="color:#FFF; font-weight:bold;    padding: 15px 18px; font-size:15px; text-align:center;"> <?php echo $popprod['Product']['discount']; ?>% <br />Off</p>
                                                    </div>
                                            <?php } } ?>
						<div class="feature_box">
							<div class="feature_box_img">
								<a href="<?php echo $this->webroot.'products/view/'.base64_encode($popprod['Product']['id']);?>"><img src="<?php echo $image?>" alt="" /></a>
							</div>
							<p><a href="<?php echo $this->webroot.'products/view/'.base64_encode($popprod['Product']['id']);?>"><?php echo $popprod['Product']['name'];?></a></p>
							<b><?php if($popprod['Product']['sale_on']=='Y' && $popprod['Product']['discount'] > 0 ){?>
									<span>$<?php echo $popprod['Product']['price_lot'];?></span> $<?php echo ($popprod['Product']['price_lot']-($popprod['Product']['price_lot']*$popprod['Product']['discount'])/100);?>
								<?php }else{?>
									$<?php echo $popprod['Product']['price_lot'];?> 
								<?php }?></b>
							<div class="clearfix"></div>
							<aside id="popularrateStar_<?php echo $popprod_key;?>" style="margin-top: 10px;vertical-align: -moz-middle-with-baseline;">
								<!--<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>-->
								
							</aside>
                                                        <p style="float:left">(<?php echo $rating_count; ?>) </p>
                                                        <?php  echo '<script>
$(document).ready(function(){
$("#popularrateStar_'.$popprod_key.'").raty({score:'.$rating.',readOnly:true, halfShow : true});
});</script>';
 ?>
							
						</div>
					</div>
				</div>
				<?php }?>
				
						
			</div>
		</div>
	</div>
</div>
<?php }?>					
					
	</section>
	
	
    <div class="modal fade" id="contactnow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog dispute-request">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Contact</h4>
            </div>
            <?php if(!empty($userid)){ ?>
            <form class="form-horizontal" method="post" action="<?php echo $this->webroot; ?>shops/contact_mail" enctype="multipart/form-data">
                <input type="hidden" name="data[Comment][user_id]" value="<?php echo $shop['Shop']['user_id']; ?>">
                <input type="hidden" name="data[Comment][to_user_id]"  value="<?php echo $userid; ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Subject</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="data[Comment][subject]" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Message:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="4" name="data[Comment][comments]" required="required"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">File:</label>
                        <div class="col-sm-9">
                            <input type="file"  name="data[Comment][file_name]">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
            <?php }else{
            ?>
            <div class="modal-body">
                You need to login for contact.

            </div>
            <?php
            } ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
	

<script src="<?php echo $this->webroot;?>js/jquery.bxslider.min.js"></script>
 <script>
    	$(document).ready(function(){
  $('.slider5').bxSlider({
    slideWidth: 270,
    minSlides: 2,
    maxSlides: 3,
    moveSlides: 1,
    slideMargin: 10
  });
});

    function chkvalid(){
	if(document.getElementById('productQuantity').value=='')
	{
		$("#QuantityErr").html('Please Enter List Quantity');
	}
	else if(document.getElementById('productQuantity').value<=0)
	{
		$("#QuantityErr").html('Enter Greater Than Zero');
	}
	else
	{
		document.ListingCart.submit();
	}
    }

    function chk_add_to_cart_valid(){
	if(document.getElementById('productQuantity').value==''){
            $("#QuantityErr").html('Please Enter List Quantity');
	}else if(document.getElementById('productQuantity').value<=0){
            $("#QuantityErr").html('Enter Greater Than Zero');
	}else{
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->webroot; ?>products/ajax_add_to_cart/<?php echo((isset($product['Product']['id']) && $product['Product']['id']!='')?base64_encode($product['Product']['id']):0);?>',
                data: $('#ListingCart').serialize(),
                //dataType: 'json',
                success: function(data) {
                    var DataSplit = data.split(':');
                    $("#AjaxMsgFrom").html('');
                    if(DataSplit[0]=='Error'){
                        $("#AjaxMsgFrom").html('<div class="row"><div class="col-md-12"><div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Error!</strong> '+DataSplit[1]+'</div></div></div>');
                    }else if(DataSplit[0]=='Success'){
                        var CartCount=$('.top_cart').find('b').text().trim();
                        var NewCnt= parseInt(CartCount)+1;
                        $('.top_cart').find('b').text( NewCnt);
                        $("#AjaxMsgFrom").html('<div class="row"><div class="col-md-12"><div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Success!</strong> '+DataSplit[1]+'</div></div></div>');
                    }
                    /*alert(data);
                    exit();
                        $("#form-email .help-block").remove();
                        $(".form-group").removeClass("has-error");
                        $("#email.white-popup .alert").remove();
                        if(data.errors){
                                for (var index in data.errors){
                                        var element = $("#form-email #"+index);
                                        element.after("<p class='help-block'>"+data.errors[index]+"</p>");
                                        element.parents(".form-group").addClass("has-error");
                                }
                        }else if(data.success){


                                $("#form-email #phone_number").val("");
                                $("#form-email #message").val("");
                        }

                        $("#send-email-loading").hide();*/
                }
            });
	}
    }
    </script>
    
    
    <script>
    $(document).ready(function(){
        
        $('.more_img').click(function(){
            var ImgSrc=$(this).attr('src');
            if(ImgSrc!=''){
                $('.image_main').html('');
                $('.image_main').html('<img src="'+ImgSrc+'" style="width: 100%;" class="img-responsive" alt="">');
            }
        });
        
        $('.slider6').bxSlider({
          slideWidth: 270,
          minSlides: 2,
          maxSlides: 3,
          moveSlides: 1,
          slideMargin: 10
        });
    $('#productQuantity').blur(function(){
        var pro_qty = $('#productQuantity').val();
        var price = "<?php echo $Cart_price; ?>";
        price = parseInt(price);
        pro_qty =parseInt(pro_qty);
        total = (price*pro_qty);
        //alert(total);
        $('#product_total_price').html('USD $'+total);
    });
    
    $("#productQuantity").keyup(function () {
        var pro_qty = $('#productQuantity').val();
        var price = "<?php echo $Cart_price; ?>";
        price = parseInt(price);
        pro_qty =parseInt(pro_qty);
        total = (price*pro_qty);
        $('#product_total_price').html('USD $'+total);
    });
    
    $('.favourite').click(function(){
                var userid = '<?php echo $userid; ?>';
                if(!userid){
                    alert('Please Login');
                    return false;
                }
                var id = $(this).attr('fab_id');
                var type = $(this).attr('fab_type');  
                //alert(id);
                //alert(type);

                $.ajax({
               url     : "<?php echo $this->webroot;?>products/ajax_whishlist",
               type    : "POST",
               //cache   : false,
               data    : {id : id, type : type},
               //dataType: 'json',
               success : function(data){
                    //alert(data);
                    if(data='success'){
                        if(type == 1){
                            $('.favourite').html('<img  src="<?php echo $this->webroot;?>images/red_heart.png" class="img-responsive" style="margin: 0 auto;">');
                            $('.favourite').attr('fab_type',0);
                        }else if(type == 0){
                            $('.favourite').html('<img  src="<?php echo $this->webroot;?>images/white_heart.png" class="img-responsive" style="margin: 0 auto;">');
                            $('.favourite').attr('fab_type',1);
                        }
                        
                    }
                    
              }
          });
                //alert(pro_qty)
    });
});
    </script>
    
    
    <style>
    	.bx-pager.bx-default-pager {display: none;}
    	ul.gap_ul {margin: 5px 0;}
    	.nav-tabs > li {
    float: left;
    margin-bottom: -1px;
    width: 20%;
    background: #c0c0c0;
    color: #000;
    margin-left: 5px;
}
	.nav-tabs > li a {
		color: #000;	}
		
.nav-tabs > li.active {
    float: left;
    margin-bottom: -1px;
    width: 20%;
    background: #7a7a7a!important;
    color: #fff;
    font-weight: bold;
}
  ul.nav-tabs {border-bottom: 1px solid #000;}
 
.tab-content {margin: 15px 0;}



.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {   background: #7a7a7a!important; color:#fff!important;}

.detail_table tr > td {border: 1px solid #dddddd;}
.rating_details {padding: 50px 0 50px 25px; }
ul.gap_below {padding-bottom: 10px; border-bottom: 1px dotted #000; color: #c0c0c0;}
.bx-wrapper  {min-width: 95%;}
    	
    </style>
