<?php ?>
<section class="after_login">
	<div class="container">
		<div class="row">
			<?php echo($this->element('user_leftbar'));?>
			<div class="col-md-9">
				<div class="product_title">
					<div class="row">
						<div class="col-md-6">
							<h4>My Profile</h4>
						</div>
						<!--<div class="col-md-6">
							<button class="btn_red pull-right">Closed for holiday</button>
						</div>-->
						<div class="col-md-12">
							
							<div class="orderbosx">
								<!--<h2>Please provide Feedback for this Purchase</h2>-->
								<div class="order_des pofile2">
									<h5>Upload My Photo</h5>
									<form class="form-horizontal profile_form" method="POST" action="<?php echo($this->webroot)?>users/edit_photo" enctype="multipart/form-data">
									<div class="row">
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-7">
													<div class="choose_file">
														<span>Choose File</span>
														<input type="file" id="files" name="data[User][profile_image]"/>
													</div>
												</div>
												<div class="col-md-5 photo_different">
													<!--<p>Preview Photo</p>-->
													<?php
												if(isset($user['User']['profile_image']) && $user['User']['profile_image']!=''){
												?>
												<img id="Preview" src="<?php echo($this->webroot)?>user_images/<?php echo($user['User']['profile_image'])?>" alt="<?php if(isset($user['User']['first_name']) && $user['User']['first_name']!=''){echo $user['User']['first_name'];}?> <?php if(isset($user['User']['last_name']) && $user['User']['last_name']!=''){echo $user['User']['last_name'];}?>" style="width:100%;height:100px;"/>
												<?php } else {?>
												<img id="Preview" src="<?php echo($this->webroot)?>images/profile.png" alt="<?php if(isset($user['User']['first_name']) && $user['User']['first_name']!=''){echo $user['User']['first_name'];}?> <?php if(isset($user['User']['last_name']) && $user['User']['last_name']!=''){echo $user['User']['last_name'];}?>" style="width:100%;height:100px;"/>
												<?php } ?>
													
													  
												</div>
												<div class="col-md-12 declration">
													<div class="checkbox">
													  <label>
													    <input type="checkbox" value="1" required name="data[User][check]">
													    I Certify that I have the right and authority to distribute this picture and that it
doesnot violate the Terms of use
													  </label>
													  
													</div>
													<button class="active">Save</button>
													<button class="">Cancel</button>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="rules"><h3>Uploading Photo Rules</h3>
											<p>
												Please upload a photo that matches the gender, age and status details in your personal Profile.<br/><br/>

Use a Photo that is appropriate for a business setting.<br/><br/>

Photos Violating the rules stated in the Terms will be removed without notice.
											</p></div>
										</div>
									</div>
									</form>
								</div>
								
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		
	</div>
</section>
<style>
.profile_box p a{
	color:#fff;
}
.choose_file{
	position:relative;
	display:inline-block;    
	border-radius:8px;
	border:#B9B8B8 solid 1px;
	width:200px; 
	padding: 4px 6px 4px 8px;
	font: normal 14px Myriad Pro, Verdana, Geneva, sans-serif;
	color: #7f7f7f;
	margin-top: 2px;
	background:white;
}
.choose_file input[type="file"]{
	-webkit-appearance:none; 
	position:absolute;
	top:0; left:0;
	opacity:0; 
}
</style>
<script>
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#Preview').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

$("#files").change(function(){
	//alert('here');
        readURL(this);
    });
</script>
