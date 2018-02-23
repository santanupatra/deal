<?php ?>
<style>
button a {
color: #fff;
text-decoration: none;
}button a:hover, a:focus {
color: #fff;
text-decoration: underline;
}
</style>
<script>
$( document ).ready(function() {
	$("#categorySearch").on("change", function() {
	    $("#search").submit();
	});
	$("#sort").on("change", function() {
	    $("#search").submit();
	});
});
</script>
<script src="<?php echo $this->webroot;?>js/jquery.raty-fa.js"></script>
<section class="after_login">
	<div class="container">
		<div class="row">
		    <?php echo($this->element('user_leftbar'));?>
			
				
			<div class="col-md-9">
			 <div class="product_title">
					<div class="row">
						<div class="col-md-12">
							<h4>Followed Store</h4>
							<div class="table-responsive">
								<table class="table table-bordered followed-table">
									<thead>
										<tr><th>Store</th>
										<th>Added</th>
										<th>Actions</th>
									</tr></thead>
									<tbody>
										<?php if(isset($follow) && !empty($follow))
										{
											foreach($follow as $follows){
												//pr($wish);exit;
												if(!empty($follows['Shop']['logo']))
												{
													$uploadFolder = "shop_images";
													$uploadPath = WWW_ROOT . $uploadFolder;
													$imageName =$follows['Shop']['logo'];
													if(file_exists($uploadPath . '/' . $imageName) && $imageName!='')
													{
														$image = $this->webroot.'shop_images/'.$imageName;
													}
													else
													{ 
														$image = $this->webroot.'shop_images/default.png';
													} 
												}else{
													$image = $this->webroot.'shop_images/default.png';
												}
												
												$product_rating = $this->requestAction(array('controller' => 'products', 'action' => 'shop_related_rating/'.$follows['Shop']['id']));
                                                            if(!empty($product_rating[0][0]['total_rating']))
                                                                $rating = $product_rating[0][0]['total_rating'];
                                                            else 
                                                                $rating=0;
                                                            $rating_count = $product_rating[0][0]['total_count'];
                                                            $product_key = $follows['Shop']['id'];
											?>
										
										<tr>
											<td>
												
												<div class="image-holder">
												<a href="<?php echo $this->webroot.'shops/details/'.base64_encode($follows['Shop']['id']).'';?>"><img alt="" style="" src="<?php echo $image;?>"></a>
												</div>
												
												<div class="store-name">
													<h5><?php echo $follows['Shop']['name'];?></h5>
													<!--<p><a href=""><i class="fa fa-plus-square"></i> Add Notes</a></p>-->
												</div>
												<div class="rating">
													<aside id="rateStar_<?php echo $product_key;?>" style="float:left">
									<?php  echo '<script>
$(document).ready(function(){
$("#rateStar_'.$product_key.'").raty({score:'.$rating.',readOnly:true, halfShow : true});
});</script>';
 ?>
									
								</aside>
													<p style="float:left">	
													(<?php echo $rating_count; ?>)
													</p>
												</div>
											</td>
											<td>
												<p class="text-center"><?php echo date('d M, Y',strtotime($follows['Follow']['date']));?></p>
											</td>
											<td class="text-center">
												<p><a href=""><i class="fa fa-envelope"></i> Contact Seller</a></p>
												<a href="<?php echo $this->webroot.'shops/un_follow/'.base64_encode($follows['Follow']['id']);?>" class="btn btn-default">Unfollow</a>
											</td>
										</tr>
										<?php 
											}
										 }else{
										?>
											<tr>
												<td colspan="3" align="center">No Records Found.</td>
											</tr>
										<?php
										}?>
										
									</tbody>
								</table>
							</div>
						</div>
					</div>
			 </div>	
				</div>    
				
				
				
				
		</div>
		
	</div>
</section>



