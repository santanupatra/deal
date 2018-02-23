
<div id="fltrresdiv" class="fltrresdiv">
	<?php 
	  if(!empty($srch_rslts)){ 
		  $k=1;
		  foreach($srch_rslts as $serchskill){
			$skillimages_exp=explode(',',$serchskill['SkillImage']['0']['image']);
		    $subskill_exp=explode(',',$serchskill['Skill']['sub_category']);
	?>
	 <div id="ovr<?php echo $k; ?>" class="img-holder work-archive-thumb-link" onclick="myClick('<?php echo base64_encode($serchskill['Skill']['id']);?>',event)" onmouseover="open_overlay(<?php echo $k;?>)" onmouseout="close_overlay(<?php echo $k;?>)">
	 <div class="work-masonry-thumb masonry-brick">
	  <div style="float:left;position:relative">
	   <?php 
	        if(isset($skillimages_exp[0]) && $skillimages_exp[0]!=''){
			$uploadFolder = "skill_images";
			$uploadPath = WWW_ROOT . $uploadFolder . '/' . $skillimages_exp[0];
			if (file_exists($uploadPath))
			{
	  ?>
		<img alt="<?php echo $serchskill['Skill']['skill_name'];?>" src="<?php echo $this->webroot; ?>resize_search.php?pic=skill_images/<?php echo $skillimages_exp[0];?>&h=271&w=305"/>
      <?php
		}}
		else{
	  ?>
		  <img src="<?php echo $this->webroot; ?>resize_search.php?pic=img/profile_cover.jpg&h=271&w=305" alt="Cover Image"/>
	  <?php } ?>
        
        <?php
		  $usrid = $this->Session->read('Auth.User.id');
		  if(isset($usrid) && $usrid!='')
		  {
		   if($usrid != $serchskill['Skill']['user_id'])
		   {
			  if(in_array($serchskill['Skill']['id'],$wishlist_ids)){  
			 ?>
				<div id="wishlisticon<?php echo $serchskill['Skill']['id'];?>" class="wishlisticon" onclick="make_fav(<?php echo $serchskill['Skill']['id'];?>,event)"><a href="javascript:void(0);"><img src="<?php echo $this->webroot;?>img/share1_black.png" title="Remove from wishlist" class="share_icon"></a></div>
			 <?php }else{ ?>
			   <div id="wishlisticon<?php echo $serchskill['Skill']['id'];?>" onclick="make_fav(<?php echo $serchskill['Skill']['id'];?>,event)" class="wishlisticon"><a href="javascript:void(0);"><img src="<?php echo $this->webroot;?>img/share1.png" title="Add to wishlist" class="share_icon"></a></div>
		<?php }}else{ ?>
			   <div id="wishlisticon<?php echo $serchskill['Skill']['id'];?>" class="wishlisticon"><a href="javascript:void(0);"><img src="<?php echo $this->webroot;?>img/share1.png" class="share_icon"></a></div>
		<?php } }else{ ?>
			  <div id="wishlisticon<?php echo $serchskill['Skill']['id'];?>" class="wishlisticon"><a href="javascript:void(0);"><img src="<?php echo $this->webroot;?>img/share1.png" class="share_icon"></a></div>
		<?php } ?>

		<div class="overlay" id="overlaydv<?php echo $k;?>" onmouseover="open_overlay(<?php echo $k;?>)" onmouseout="close_overlay(<?php echo $k;?>)">
			<h3><?php echo $serchskill['Skill']['about_specifically'];?></h3>
			<p>by <?php echo $serchskill['User']['first_name'].' '.$serchskill['User']['last_name'];?><br>$<?php echo intval($serchskill['Skill']['max_price']);?> /hour</p>
		</div>
		<div class="clearfix"></div>
		</div>
        </div>
       <div class="clearfix"></div>
	 </div>
	<?php $k++;}} ?>
</div>
<style>
/*#fltrresdiv{width: 960px;opacity: 1;margin: 0 auto;overflow: hidden;}
.img-holder{float: left;height: 253px;margin-right: 10px;cursor: pointer;display:block;position:relative}
.img-holder:hover{cursor: pointer;}
.img-holder img{float: left;height: 100%;max-width: 100%;width:auto}
.row{width: 100%;overflow: hidden;display: block;margin-bottom: 10px;}
.row .last{margin-right: 0;float: right;}
.gallery-holder img{max-height: 507px;width: auto;}
.gallery-holder{text-align: center;margin-bottom: 10px;height: 542px;display: none;width: 100%;}
.gallery-holder .img-wrapper{width: 100%;margin-bottom: 5px;}
.gallery-holder h1{width: 100%;margin: 5px 0;text-align: left;}*/
.overlay{height:97%;}
.overlay p{margin-top:4%}
.work-archive-thumb-link img {
    margin-right: 0px;
    margin-bottom: 7px;
    float: left;
}
.work-masonry-thumb {
    float: left;
}
.fltrresdiv {
    margin: 0 auto 0 14px;
	clear:both;
}
</style>
<script src="<?php echo $this->webroot; ?>js/jquery-1.8.3.js"></script>
<script src="<?php echo $this->webroot; ?>js/jquery.masonry.min.js"></script>

<script>
function createGallery(){
	jQuery('.fltrresdiv').masonry({
		itemSelector: '.work-masonry-thumb',
		columnWidth: 39
	});
}
createGallery();

  /*jQuery.fn.exists = function(){return this.length>0;}
		
			var imgUrlFullsize = "";
			var count = 1;
			var imageWidth = Number();
			var allImagesWidth = Number();
			var difference = Number();
			var numberOfImages = Number();
			var imgElement;
			var currentRow;
			var allImagesWidthWithPadding = Number();
			
		function createGallery(){
					//first we put all the image holders in a variable, then we remove them from the html
					var container = $('.fltrresdiv');
					var elements = container.children('.img-holder');
					$('.img-holder').remove();
					
					//we start by adding a new row with id row-1
					$( ".fltrresdiv" ).append('<div id="row-' + count + '" class="row"></div>');
		
						
						//for each value in elements (for each .img-holder), we add the -img-holder with contents to the row
						jQuery.each(elements, function(){
								
								$( "#row-" + count).append(this);
								
								//we put the width of the img-holder in a variable
								imageWidth = $(this).width();
								
								//and keep on adding on the width with each image
								allImagesWidth = Number(allImagesWidth) + Number(imageWidth);
								//we also keep track of the image width + the padding, keep on adding untill < 800px
								allImagesWidthWithPadding = Number(allImagesWidthWithPadding) + Number(imageWidth) + 10;
								
								 
								//when we reach over 800px in total width of the images + padding, we need to adjust the width to fit perfectly in the row
								//800 is the width of the container set in the css-file
								 if(allImagesWidthWithPadding > 960){
										
										//we calculate the overlapping difference 
										difference = allImagesWidthWithPadding - 960 - 10; //minus an extra 10px since the last img will nott have any padding-right
										numberOfImages = $( "#row-" + count).find('img').length; //number of images in current row
										
										//all images exept the last one is getting a margin-right 10px
										var numberOfImagesWithPadding = Number(numberOfImages - 1); //number of images with padding
										var totalRightPadding = Number(numberOfImagesWithPadding * 10); //total padding in this row 
										
										
										//this is how much each image must be adjusted to fit in %
										var procentCalc = difference / allImagesWidth;

										currentRow = $("#row-" + count); 
										imgElement = currentRow.children('.img-holder');
										
										$(imgElement).last().addClass('last'); //put the class .last on the last .img-holder
										$(imgElement).first().addClass('first'); //put the class .first on the first .img-holder
										
								

					if(!(difference == 0)){ //If the difference is NOT 0, meaning that images + padding is too wide.
							//We adjust the width to line up the images perfectly in width
											jQuery.each(imgElement, function(){
												
												var currentImgHolderWidth = Number();
												currentImgHolderWidth = $(this).width();
												
												//We calculate the new with of the img-holder in %
												var newWidth = Number(currentImgHolderWidth * procentCalc);
												newWidth = currentImgHolderWidth - newWidth;
												
												newWidth = parseInt(newWidth); //we make the value an integer, no decimal
												//set the new with on the current .img-holder
												$(this).css( "width", newWidth );

											});
								
										
										
										var ImageWidthWithPadding = Number();
										var AllImagesWidthWidthpadding = Number();
										
										//we find out how much width all images in one row have in total, put the padding on except for the .last
										jQuery.each(imgElement, function(){ 
											if (!$(this).hasClass("last")) { 
												ImageWidthWithPadding = $(this).width();
												AllImagesWidthWidthpadding = AllImagesWidthWidthpadding + ImageWidthWithPadding + 10;

											}else{ //then we adjust the last image to fit perfectly to make an even row
												var adjustDifferens = 960 - AllImagesWidthWidthpadding;
												$(this).css( "width", adjustDifferens );
											}
										});
					} // end of if the difference was NOT 0px		
										
										//reset the variables keeping track of the image with for each row
										allImagesWidth = 0;
										allImagesWidthWithPadding = 0;
										count++;
										$( ".fltrresdiv" ).append('<div id="row-' + count + '" class="row"></div>');
								}
								else{
									
									//if the images doesn't take up the whole row, we still put the class .first on the first img-holder
									currentRow = $("#row-" + count); 
									imgElement = currentRow.children('.img-holder');
									$(imgElement).first().addClass('first');
								}
								 
						});
						
		
		//When all images are aligned and loaded we fade in the gallery
						showGallery();	
		
		}
		
		
		
		
		function showGallery(){
			$('.fltrresdiv').animate({
			opacity: 1
			}, 1000, function() {
			});
		}
		
		createGallery();
*/
</script>
