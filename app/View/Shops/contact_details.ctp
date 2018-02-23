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

