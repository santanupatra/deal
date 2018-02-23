<div class="container_960">
	<?php echo $this->element('user_leftbar'); ?>
	<div class="dash_right pull-right">
		<div class="dash_right_head">
			<h2>My Workshops</h2>
			<ul class="workshop">
				<li id="attndli"><a href="<?php echo $this->webroot;?>users/my_workshops" style="color:#000">Workshops I attend</a></li>
				<li class="active" id="hostli"><a href="<?php echo $this->webroot;?>users/my_workshop_host" style="color:#000">Workshops I host</a></li>
			</ul>
		</div>
		<?php if(!empty($workshophosts)){ ?>
		   <div class="dash_2_page" id="workshophost">
		   <div class="dash_2_page_left pull-left">
		<?php }else{ ?>
		  <div class="dash_2_page" id="workshophost" style="width:100%">
		  <div class="dash_2_page_left pull-left" style="width:100%">
		<?php } ?>
				<div id="tabs-container_1">
					<ul class="tabs-menu_1">
						 <li class=""><a href="#tab-1">All</a></li>
						 <li class="current"></li>
					</ul>
				<div class="tab_1">
					<div id="tab-3" class="tab-content_1" style="display:block">
						<ul>
							<?php 
						     if(!empty($workshophosts)){ 
								 foreach($workshophosts as $workshophost){
									 $is_invoice=$this->requestAction('users/getinvoicedetails/'.$workshophost['Request']['id']);
									 $today=date('Y-m-d');
									if(!empty($is_invoice)){
						   ?>
							<a href="<?php echo $this->webroot.'users/my_workshop_host/'.base64_encode($workshophost['Request']['id']).''; ?>"><li>
							   <?php if(strtotime($today) < strtotime($workshophost['Request']['request_date'])){ ?>
								<div class="up_coming"><img src="<?php echo $this->webroot;?>img/upcoming.png" alt="Upcoming"/></div>
							   <?php } ?>
								<?php
								 if(isset($workshophost['User']['profile_image']) && $workshophost['User']['profile_image']!='')
								 {
								?>
								   <img src="<?php echo $this->webroot; ?>user_images/<?php echo $workshophost['User']['profile_image'];?>" alt="<?php echo $workshophost['User']['first_name'];?>" class="img_pro"/>
								<?php }else{ ?>
								   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" alt="<?php echo $workshophost['User']['first_name'];?>" class="img_pro"/>
								<?php } ?>
								<aside>
									<b><?php echo $this->requestAction('users/getskillname/'.$workshophost['Request']['skill_id'])?></b>
									<p><?php echo $workshophost['User']['first_name'].' '.$workshophost['User']['last_name'];?></p>
									<span>
									<?php echo date('M d Y',strtotime($workshophost['Request']['request_date']));?><br/>
									<?php if(strtotime($today) > strtotime($workshophost['Request']['request_date'])){ ?>
									  <a href="javascript:void(0)" style="color:blue">Write review</a><br/>
									<?php } ?>
									</span>
								</aside>
								<?php if($workshophost['Request']['is_paid']==0)
								{?>
								 
                                <?php }else{ ?>
								  <img src="<?php echo $this->webroot;?>img/paid.png" alt="paid" class="paid"/>
								<?php } ?>
							</li></a>
							<?php }}}else{ ?>
							 <li>
							  No workshop found.
							 </li>
							<?php } ?>
						</ul>
					</div>
				</div>
				</div>
			</div>

			<?php 
			  if(!empty($workshophosts)){ 
			   if(isset($this->params['pass'][0]) && $this->params['pass'][0]!=''){
				 $invoice_details1=$this->requestAction('users/getinvoicedetails/'.$particularworkshop['Request']['id']);
                if(!empty($invoice_details1)){
				 $review_details1=$this->requestAction('users/getreviews/'.$particularworkshop['Request']['id']);
			     $userdetails=$this->requestAction('users/getuserdetails/'.$invoice_details1['Invoice']['maker_id']);
			?>
			  <div class="dash_2_page_right pull-right">
				<div class="new_work_head">
					<?php
					 $mimg1=$this->requestAction('users/getmakerimage/'.$particularworkshop['Request']['user_id']);
					 if(isset($mimg1) && $mimg1!='')
					 {
					?>
					   <img src="<?php echo $this->webroot; ?>user_images/<?php echo $mimg1;?>" class="img_pro"/>
					<?php }else{ ?>
					   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" class="img_pro"/>
					<?php } ?>
					<h2><?php echo $invoice_details1['Invoice']['invoice_name'];?></h2>
				</div>
				<div class="time_of_workshop">
					<p><?php echo $invoice_details1['Invoice']['how_long'];?> workshop</p>
					<p>Extra cost</p>
				</div>
				<div class="total_pay">
					<p>Total</p>
					<?php 
						 if($invoice_details1['Request']['is_paid']==0)
						 { 
					  ?>
					   <strong style="float:right;font-size:12px">&nbsp;&nbsp;Not agree payment</strong>
					  <?php }else{
					  ?>
						<strong style="float:right;font-size:12px">&nbsp;&nbsp;Paid</strong>
					  <?php }?>
					  
					<strong>$ <?php echo $invoice_details1['Invoice']['how_mutch'];?></strong>
				</div>
				<ul class="pay_timing" style="list-style:none">
					<li><img src="<?php echo $this->webroot?>img/spite_clock.png" alt="Clock" /><span><?php echo $invoice_details1['Request']['request_time'];?>  <?php echo $invoice_details1['Request']['request_time_format'];?></span></li>
					<li><img src="<?php echo $this->webroot?>img/spite_list.png" alt="List" /><span> <?php echo date('M d Y',strtotime($invoice_details1['Request']['request_date']));?></span></li>

					<li><img src="<?php echo $this->webroot?>img/spite_call.png" alt="Call" /><span><?php echo $userdetails['User']['seller_phone'];?></span></li>

					<li><img src="<?php echo $this->webroot?>img/spite_msg.png" alt="Msg"/><span><a href="<?php echo $this->webroot;?>users/messages">See all contact with person</a></span></li>
				</ul>
				<div class="dash_1_map" id="profile_map">
				</div>
				<div class="das_2_des">
					<p><?php echo $particularworkshop['Skill']['skill_workshop_address'];?></p>
					<p><?php echo nl2br($invoice_details1['Invoice']['message']);?></p>

					<?php $today=date('Y-m-d');if(strtotime($today) > strtotime($invoice_details1['Request']['request_date'])){ ?>
					<form name="review" method="post" action="<?php echo $this->webroot;?>users/post_review1/<?php echo $particularworkshop['Request']['id'];?>">
                    <strong>Review</strong><br/>
                    <?php if(!empty($review_details1)){
					 foreach($review_details1 as $review_detail1){
					 $userdetailsr=$this->requestAction('users/getuserdetails/'.$review_detail1['Review']['reviewer']);
					?>
					 <p><?php
					 if(isset($userdetailsr['User']['profile_image']) && $userdetailsr['User']['profile_image']!='')
					 {
					?>
					   <img src="<?php echo $this->webroot; ?>user_images/<?php echo $userdetailsr['User']['profile_image'];?>" class="img_pro" style="width:22px;height:22px;border-radius:100%"/>
					<?php }else{ ?>
					   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" class="img_pro" style="width:22px;height:22px;border-radius:100%"/>
					<?php } ?>
					&nbsp;&nbsp;<b><?php echo $userdetailsr['User']['first_name'].' '.$userdetailsr['User']['last_name'];?></b><span style="float:right"><?php echo date('M d, Y',strtotime($review_detail1['Review']['date']));?></span></p>
					 <p style="margin-bottom:20px;border-bottom:1px solid #e8e8e8"><?php echo nl2br($review_detail1['Review']['comment']);?></p>
					<?php }} ?>
					
					<div class="fields new_w_text">
						<textarea name="data[review]" id="review_textarea" style="height:111px"></textarea>
						<input type="hidden" name="data[maker]" value="<?php echo $particularworkshop['Request']['user_id'];?>">
					</div>
					<strong>Upload pictures of your space and tools</strong>
					<div class="fields" style="position:relative">
						<div id="preview_overlay" style="position:absolute;background: url(<?php echo($this->webroot);?>img/prevback.png) repeat;width:100%;height:100%;z-index:999999;display:none;">
							   <div style=" color: #fff;display: block;font-size: 22px;font-weight: bold;margin: 2% auto 0;text-align: center;">
								Please wait while uploading...
							   </div>
							   <img src="<?php echo($this->webroot);?>img/green-ajax-loader.gif" style="display:block;margin:0 auto;"/>
						  </div>
						<ul class="up_image">
						
							<div id="Preview">
							</div>
						 
							<li><img src="<?php echo $this->webroot; ?>img/big_plus.png" alt="Add Pics" onclick="performClick5()" style="cursor:pointer"/></li>
						</ul>
						  <input type="file" id="theFile5" name="photos[]" style="display:none;" multiple="true"/>
						
						  <input type="hidden" name="data[Request][picnum]" value="0" id="picnum"/>
						  <input type="hidden" name="data[Request][totalpics]" value="0" id="totalpics"/>
						  
					</div>
					<input class="btn border_btn offer_my_skill pay_btn" type="submit" value="Post review" onclick="return review_validate();" id="post_review">
					</form>
                  <?php } ?>
				</div>
			</div>
			<?php }}else{ 
		     $invoice_details1=$this->requestAction('users/getinvoicedetails/'.$workshophosts[0]['Request']['id']);
			 if(!empty($invoice_details1)){
			 $review_details1=$this->requestAction('users/getreviews/'.$workshophosts[0]['Request']['id']);
			 $userdetails=$this->requestAction('users/getuserdetails/'.$invoice_details1['Invoice']['maker_id']);
		    ?>
			<div class="dash_2_page_right pull-right">
				<div class="new_work_head">
					<?php
					 $mimg1=$this->requestAction('users/getmakerimage/'.$workshophosts[0]['Request']['user_id']);
					 if(isset($mimg1) && $mimg1!='')
					 {
					?>
					   <img src="<?php echo $this->webroot; ?>user_images/<?php echo $mimg1;?>" class="img_pro"/>
					<?php }else{ ?>
					   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" class="img_pro"/>
					<?php } ?>
					<h2><?php echo $invoice_details1['Invoice']['invoice_name'];?></h2>
				</div>
				<div class="time_of_workshop">
					<p><?php echo $invoice_details1['Invoice']['how_long'];?> workshop</p>
					<p>Extra cost</p>
				</div>
				<div class="total_pay">
					<p>Total</p>
					<?php 
						 if($invoice_details1['Request']['is_paid']==0)
						 { 
					  ?>
					   <strong style="float:right;font-size:12px">&nbsp;&nbsp;Not agree payment</strong>
					  <?php }else{
					  ?>
						<strong style="float:right;font-size:12px">&nbsp;&nbsp;Paid</strong>
					  <?php }?>
					  
					<strong>$ <?php echo $invoice_details1['Invoice']['how_mutch'];?></strong>
				</div>
				<ul class="pay_timing" style="list-style:none">
					<li><img src="<?php echo $this->webroot?>img/spite_clock.png" alt="Clock" /><span><?php echo $invoice_details1['Request']['request_time'];?>  <?php echo $invoice_details1['Request']['request_time_format'];?></span></li>
					<li><img src="<?php echo $this->webroot?>img/spite_list.png" alt="List" /><span> <?php echo date('M d Y',strtotime($invoice_details1['Request']['request_date']));?></span></li>

					<li><img src="<?php echo $this->webroot?>img/spite_call.png" alt="Call" /><span><?php echo $userdetails['User']['seller_phone'];?></span></li>

					<li><img src="<?php echo $this->webroot?>img/spite_msg.png" alt="Msg"/><span><a href="<?php echo $this->webroot;?>users/messages">See all contact with person</a></span></li>
				</ul>
				<div class="dash_1_map" id="profile_map">
				</div>
				<div class="das_2_des">
					<p><?php echo $workshophosts[0]['Skill']['skill_workshop_address'];?></p>
					
					<p><?php echo nl2br($invoice_details1['Invoice']['message']);?></p>

					<?php $today=date('Y-m-d');if(strtotime($today) > strtotime($invoice_details1['Request']['request_date'])){ ?>
					<form name="review" method="post" action="<?php echo $this->webroot;?>users/post_review1/<?php echo $workshophosts[0]['Request']['id'];?>">
                    <strong>Review</strong><br/>
					<?php if(!empty($review_details1)){
					 foreach($review_details1 as $review_detail1){
					 $userdetailsr=$this->requestAction('users/getuserdetails/'.$review_detail1['Review']['reviewer']);
					?>
					 <p><?php
					 if(isset($userdetailsr['User']['profile_image']) && $userdetailsr['User']['profile_image']!='')
					 {
					?>
					   <img src="<?php echo $this->webroot; ?>user_images/<?php echo $userdetailsr['User']['profile_image'];?>" class="img_pro" style="width:22px;height:22px;border-radius:100%"/>
					<?php }else{ ?>
					   <img src="<?php echo $this->webroot; ?>user_images/user_image.png" class="img_pro" style="width:22px;height:22px;border-radius:100%"/>
					<?php } ?>
					&nbsp;&nbsp;<b><?php echo $userdetailsr['User']['first_name'].' '.$userdetailsr['User']['last_name'];?></b><span style="float:right"><?php echo date('M d, Y',strtotime($review_detail1['Review']['date']));?></span></p>
					 <p style="margin-bottom:20px;border-bottom:1px solid #e8e8e8"><?php echo nl2br($review_detail1['Review']['comment']);?></p>
					<?php }} ?>

					<div class="fields new_w_text">
					<textarea name="data[review]" id="review_textarea" style="height:111px"></textarea>
					<input type="hidden" name="data[maker]" value="<?php echo $workshophosts[0]['Request']['user_id'];?>">
					</div>
					<strong>Upload pictures of your space and tools</strong>
					<div class="fields" style="position:relative">
						<div id="preview_overlay" style="position:absolute;background: url(<?php echo($this->webroot);?>img/prevback.png) repeat;width:100%;height:100%;z-index:999999;display:none;">
							   <div style=" color: #fff;display: block;font-size: 22px;font-weight: bold;margin: 2% auto 0;text-align: center;">
								Please wait while uploading...
							   </div>
							   <img src="<?php echo($this->webroot);?>img/green-ajax-loader.gif" style="display:block;margin:0 auto;"/>
						  </div>
						  <div id="Preview">
							</div>
						<ul class="up_image">
							<li><img src="<?php echo $this->webroot; ?>img/big_plus.png" alt="Add Pics" onclick="performClick5()" style="cursor:pointer"/></li>
						</ul>
						  <input type="file" id="theFile5" name="photos[]" style="display:none;" multiple="true"/>
						
						  <input type="hidden" name="data[Request][picnum]" value="0" id="picnum"/>
						  <input type="hidden" name="data[Request][totalpics]" value="0" id="totalpics"/>

					</div>
					<input class="btn border_btn offer_my_skill pay_btn" type="submit" value="Post review" onclick="return review_validate();" id="post_review">
					</form>
                  <?php } ?>
				</div>
			</div>
			<?php }} }?>
		</div>
	</div>
</div>
<style>
#profile_map img { max-width: inherit; border-radius:0px !important;}
#profile_map{height:361px !important}
</style>
<?php echo $this->Html->scriptStart(array('inline'=>false));?>
function performClick5() {
	$('#theFile5').click();
}

    var marker;
	var geocoder = new google.maps.Geocoder();
	initialize_profile();
	function initialize_profile(lat,lng) 
	{
		lat='<?php echo $skill_lat;?>';
		lng='<?php echo $skill_lang;?>';
		var myLatLng = new google.maps.LatLng(lat,lng);
		var mapOptions = {
		    scrollwheel: false,
			zoom: 14,
			center: myLatLng,
			mapTypeId: google.maps.MapTypeId.RoadMap
		};

		var map = new google.maps.Map(document.getElementById('profile_map'),mapOptions);
	    var image = '<?php echo $this->webroot;?>img/mapmarker.png';
		var contentString = '';

	    var infowindow = new google.maps.InfoWindow({
			  content: contentString
		});

		marker = new google.maps.Marker({
			position: map.getCenter(),
			map: map,
			icon: image
		});
	}

<?php echo $this->Html->scriptEnd();?>
