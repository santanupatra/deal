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
    $("#categorySubSearch").on("change", function() {
        $("#search").submit();
    });
});
</script>
<section class="after_login">
	<div class="container">
		<div class="row">
		    <?php echo($this->element('user_leftbar'));?>
			<div class="col-md-9">
				
				<div class="product_title">
					<form name="search" id="search" action="" method="get">
					<div class="row">
						<div class="col-md-4">
							<h4>Favourites Product</h4>
						</div>
						<div class="col-md-8 header_search">
							<div class="row">
								<div class="col-md-4">
									<select name="categorySearch" id="categorySearch" >
										<option value="">Category</option>
										<?php if(isset($category) && !empty($category))
										{
											foreach($category as $k=>$v)
											{?>
												<option value="<?php echo $k;?>" <?php echo( (isset($cat) && !empty($cat))?($cat==$k?'selected':''):'')?>><?php echo $v;?></option>
											<?php 
											}
										}else{
										?>
										<option value="">No Category Found</option>
										<?php
										}?>
									</select>
								</div>
								<?php
                                                                if(isset($sub_category_list) && count($sub_category_list)>0){
                                                                ?>
                                                                <div class="col-md-4">
                                                                    <select name="categorySubSearch" id="categorySubSearch" >
                                                                        <option value="">Sub Category</option>
                                                                        <?php if(isset($sub_category_list) && !empty($sub_category_list))
                                                                        {
                                                                                foreach($sub_category_list as $k=>$v)
                                                                                {?>
                                                                                        <option value="<?php echo $k;?>" <?php echo( (isset($categorySubSearch) && !empty($categorySubSearch))?($categorySubSearch==$k?'selected':''):'')?>><?php echo $v;?></option>
                                                                                <?php 
                                                                                }
                                                                        }else{
                                                                        ?>
                                                                        <option value="">No Sub Category Found</option>
                                                                        <?php
                                                                        }?>
                                                                    </select>
								</div>
                                                                <?php
                                                                }
                                                                ?>
								<div class="col-md-4">
									<select name="sort" id="sort">
										<option value="">Sort By</option>
										<option value="desc" <?php echo( (isset($sort) && !empty($sort))?($sort=='desc'?'selected':''):'')?>>Price High to Low</option>
										<option value="asc" <?php echo( (isset($sort) && !empty($sort))?($sort=='asc'?'selected':''):'')?>>Price Low to High</option>
									</select>
								</div>
							</div>
						</div>
					</div>
					</form>
				</div>
				
				
				<div class="row">
				<?php if(isset($wishlist_skill) && !empty($wishlist_skill))
				{
					foreach($wishlist_skill as $wish){
						$PrdID=$wish['Product']['id'];
                                                $prd_img=$this->requestAction(array('controller' => 'products', 'action' => 'get_product_img', $PrdID, 'admin'=>false, 'prefix' => ''));

                                                if(!empty($prd_img)){
                                                    $uploadFolder = "product_images";
                                                    $uploadPath = WWW_ROOT . $uploadFolder;
                                                    $imageName =$prd_img[0]['ProductImage']['name'];
                                                    if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
                                                        $image = $this->webroot.'product_images/'.$imageName;
                                                    }else{ 
                                                        $image = $this->webroot.'product_images/default.png';
                                                    } 
                                                }else{
                                                    $image = $this->webroot.'product_images/default.png';
                                                }
                                                  
					?>
					<div class="col-md-4">
						<div class="product_box">
							<a href="<?php echo $this->webroot.'products/remove_wishlist/'.base64_encode($wish['Wishlist']['id']);?>" class="close fa fa-close"></a>
							<div class="product_img">
								<a href="<?php echo $this->webroot.'products/view/'.base64_encode($wish['Product']['id']).'/1';?>"><img src="<?php echo $image;?>" alt="" /></a>
							</div>
							<div class="product_des">
								<p><?php echo $wish['Product']['name']; ?></p>
								<b>$<?php echo $wish['Wishlist']['price']; ?></b>
								<button><a href="<?php echo $this->webroot.'products/view/'.base64_encode($wish['Product']['id']).'/1';?>">Shop Now</a></button>
							</div>
						</div>
					</div>
					<?php 
					}
				 }else{
				?>
					<h2>No Records Found.</h2>
				<?php
				}?>
				
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



