<?php
#pr($sitesetting);
?>
<!-- <div class="container_825">
	<div class="step1_sec1">
		<div class="row">
			<div class="col-sm-12 lato_step_1_sec_1"><?php echo($sitesetting['SiteSetting']['skill_speciality_heading']);?></div>
			<div class="col-sm-9 lato_step_1_sec_1_small margin_zero">
				<?php echo($sitesetting['SiteSetting']['skill_speciality_description']);?>
			</div>
		</div>
	</div> 
	<div class="step1_sec2">
		<div class="width_620">
		  <form class="contact_form" name="step1" id="step1" action="<?php echo $this->webroot.'skills/step1'; ?>" method="POST" enctype="multipart/form-data">
			<div class="name lato_step_1_sec_1_small"><?php echo($sitesetting['SiteSetting']['skill_speciality_field1']);?>&nbsp;&nbsp;<span id="caterr" style="color:red"></span></div>
			<div class="fields">
				<div class="list_box">
					<select name="data[Skill][category_id]" id="category_id" onchange="remove_err('caterr',this.value)">
						<option value="">Select Skill</option>
						<?php 
						  if(!empty($categories))
						  {
							  foreach($categories as $category)
							  {
						?>
						   <option value="<?php echo $category['Category']['id'];?>"><?php echo $category['Category']['name'];?></option>
						<?php }} ?>
					</select>
				</div>   			
			</div>
			<div class="clearfix"></div>
			<div class="name lato_step_1_sec_1_small"><?php echo($sitesetting['SiteSetting']['skill_speciality_field2']);?>&nbsp;&nbsp;<span id="suberr" style="color:red"></span></div>
			<div class="fields">
			    <input type="hidden" name="data[List][tagnum]" value="0" id="tagnum"/>
		        <input type="hidden" name="data[List][totalTags]" value="0" id="totalTags"/>
				<div id="newTags">
				</div>
				<div class="tag_open"><a href="javascript:void(0)" onclick="open_tag_textbox()"><img src="<?php echo $this->webroot; ?>img/stepplus.png" alt="Add Tag" /></a></div>
				<div id="tag_textbox_div" style="display:none;width:100%">
				  <input type="text" placeholder="Add subskills" name="data[Skill][sub_category]" id="Tags" style="width:80%" onkeypress="return add_tag_enter(event);"/>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="name lato_step_1_sec_1_small"><?php echo($sitesetting['SiteSetting']['skill_speciality_field3']);?>&nbsp;&nbsp;<span id="deserr" style="color:red"></span></div>
			<div class="fields">
				<textarea name="data[Skill][skill_details]" id="skill_details" onkeyup="remove_err('deserr',this.value)"></textarea>
			</div>
			<div class="clearfix"></div>
			<div class="name lato_step_1_sec_1_small"><?php echo($sitesetting['SiteSetting']['skill_speciality_field4']);?>&nbsp;&nbsp;<span id="picerr" style="color:red"></span></div>
			<div class="fields">
				<ul class="up_image">
					<div id="Preview">
					</div>
					<li><img src="<?php echo $this->webroot; ?>img/big_plus.png" alt="Add Pics" onclick="performClick()" style="cursor:pointer"/></li>
				</ul>
				<input type="file" id="theFile" name="photos[]" style="display:none;" multiple="true"/>
				<input type="hidden" name="data[List][picnum]" value="0" id="picnum"/>
				<input type="hidden" name="data[List][totalpics]" value="0" id="totalpics"/>
			</div>
			<div class="clearfix"></div>
			<div class="name lato_step_1_sec_1_small"><?php echo($sitesetting['SiteSetting']['skill_speciality_field5']);?>&nbsp;&nbsp;<span id="urlerr" style="color:red"></span></div>
			<div class="fields">
				<input type="text" placeholder="Youtube or Vimeo Video Url" name="data[Skill][skill_video_url]" id="skill_video_url" onblur="return check_link()"/>
			</div>
			<div class="clearfix"></div>
			<div class="fields">
				<input type="submit" value="Studio" class="studio_btn" onclick="return step1_validate()"/>
			</div>
		  </form>
		</div>
	</div>
</div> -->

<div class="container_825">
	    	<div class="step1_sec1">
		<div class="row">
			<div class="col-sm-12 lato_step_1_sec_1"><?php echo($sitesetting['SiteSetting']['skill_speciality_heading']);?></div>
			<div class="col-sm-9 lato_step_1_sec_1_small margin_zero">
				<?php echo($sitesetting['SiteSetting']['skill_speciality_description']);?>
			</div>
		</div>
                </div> 
	    	<div class="step1_sec2">
	    		<div class="width_620">
				 <form class="contact_form" name="step1" id="step1" action="<?php echo $this->webroot.'skills/step1'; ?>" method="POST" enctype="multipart/form-data">
	    			<div class="name lato_step_1_sec_1_small"><?php echo($sitesetting['SiteSetting']['skill_speciality_field1']);?>&nbsp;&nbsp;<span id="caterr" style="color:red"></span></div>
	    			<div class="fields">
	    				<div class="list_box">
	    					<select name="data[Skill][category_id]" id="category_id" onchange="remove_err('caterr',this.value)">
								<option value="">Select Skill</option>
								<?php 
								if(!empty($categories))
								{
									foreach($categories as $category)
									{
									?>
									<option value="<?php echo $category['Category']['id'];?>"><?php echo $category['Category']['name'];?></option>
									<?php 
									}
								}
								?>
							</select>
	    				</div>   			
	    			</div>
	    			<div class="clearfix"></div>
					<div class="name lato_step_1_sec_1_small"><?php echo($sitesetting['SiteSetting']['skill_speciality_field2']);?>&nbsp;&nbsp;<span id="suberr" style="color:red"></span></div>
					<div class="fields">
						<input type="hidden" name="data[List][tagnum]" value="0" id="tagnum"/>
						<input type="hidden" name="data[List][totalTags]" value="0" id="totalTags"/>
						<div id="newTags">
						</div>
						<div class="tag_open" style="float:left;"><a href="javascript:void(0)" onclick="open_tag_textbox()"><img src="<?php echo $this->webroot; ?>img/stepplus.png" alt="Add Tag" /></a></div>
						<div id="tag_textbox_div" style="display:none;width:100%">
						  <input type="text" placeholder="Add subskills" name="data[Skill][sub_category]" id="Tags" style="width:95%" onkeypress="return add_tag_enter(event);"/>
						</div>
					</div>
	    			<div class="clearfix"></div>
	    			<div class="name lato_step_1_sec_1_small"><?php echo($sitesetting['SiteSetting']['skill_speciality_field3']);?>&nbsp;&nbsp;<span id="deserr" style="color:red"></span></div>
	    			<div class="fields">
	    				<textarea name="data[Skill][skill_details]" id="skill_details" onkeyup="remove_err('deserr',this.value)"></textarea>
	    			</div>
	    			<!-- <div class="name lato_step_1_sec_1_small">The banner is a big images on top of you profile, make sure it's a nice one</div>
	    			<div class="fields" style="background:#eeeeee;">
	    				<div class="image_profile_upload" id="cropContainerEyecandy"> -->
						    <!-- <img src="<?php echo $this->webroot;?>img/profile_cover.jpg" alt="" class="cropper"> -->
	    					<!-- <input type="button" src="" class="upload_image_btn" value="Upload your banner image" onclick="performClick1()" /> -->
	    				<!-- </div> -->
						<!-- <input type="file" id="theFile1" required name="data[Skill][banner]" style="display:none;"/> -->
						<!-- <input type="file" id="theFile1" required name="banner" style="display:none;"/> -->
	    			<!-- </div> -->
	    			<div class="clearfix"></div>
	    			<div class="name lato_step_1_sec_1_small"><?php echo($sitesetting['SiteSetting']['skill_speciality_field4']);?>&nbsp;&nbsp;<span id="picerr" style="color:red"></span></div>
	    			<div class="fields" style="position:relative">
					<div id="preview_overlay" style="position:absolute;background: url(<?php echo($this->webroot);?>/img/prevback.png) repeat;width:100%;height:100%;z-index:999999;display:none;">
				       <div style=" color: #fff;display: block;font-size: 22px;font-weight: bold;margin: 28% auto 0;text-align: center;">
					    Please wait while uploading...
					   </div>
					   <img src="<?php echo($this->webroot);?>img/green-ajax-loader.gif" style="display:block;margin:0 auto;margin-top:3%;"/>
				     </div>
	    				<ul class="up_image">
							<div id="Preview">
							</div>
							<li style="margin-right:0px">
							    <!-- <div id="loader" style="width:100%;height:129px;background-color:#bfbfbf;display:none;position:absolute;z-index:999;top:0;left:0;background-image:url(<?php echo($this->webroot);?>img/loading.gif);background-repeat: no-repeat;background-position: center center;">
								</div> -->
								<img src="<?php echo($this->webroot);?>img/big_plus_1.png" alt=""  onclick="performClick()" style="cursor:pointer"/>
								<textarea placeholder="Add some description here" disabled></textarea>
							</li>
						</ul>
						<input type="file" id="theFile" name="photos[]" style="display:none;" multiple="true"/>
						<input type="hidden" name="data[List][picnum]" value="0" id="picnum"/>
						<input type="hidden" name="data[List][totalpics]" value="0" id="totalpics"/>
						<input type="hidden" name="data[List][picnumssn]" value="0" id="picnumssn"/>
	    			</div>
	    			<div class="clearfix"></div>
	    			<div class="name lato_step_1_sec_1_small"><?php echo($sitesetting['SiteSetting']['skill_speciality_field5']);?>&nbsp;&nbsp;<span id="urlerr" style="color:red"></span></div>
	    			<div class="fields">
	    				<input type="text" placeholder="Youtube or Vimeo Video Url" name="data[Skill][skill_video_url]" id="skill_video_url" onblur="return check_link()"/>
	    			</div>
	    			<div class="clearfix"></div>
	    			<div class="fields">
	    				<input type="submit" value="Studio" class="studio_btn" onclick="return step1_validate()"/>
	    			</div>
					</form>
	    		</div>
	    	</div>
    	</div>
<div style="height:135px;background-color:#F1F1F1" >&nbsp;</div>
<style type="text/css">
/**********************************************step_1_new*********************************/
.image_profile_upload{width:100%;height:285px;background-color:#eeeeee;position: relative;cursor:move}
.upload_image_btn{width:332px;height:52px;background-color:#4743e2;border:0;position: absolute;z-index:999;top:115px;left:150px;background-image:url(<?php echo($this->webroot);?>img/upload_image.png);background-repeat: no-repeat;background-position:60px center;color:#fff;font-size:13px;text-indent:15px;overflow: hidden}
.image_profile_upload img{width:100%;height:100%}
.fields .up_image{width:100%;margin:0;padding: 0}
.fields .up_image li{width:198px;height:332px;float:left;float:left;list-style: none;margin:0;position: relative;border:0px solid red;margin-bottom:13px;margin-right:13px;}
.fields .up_image li img{width:198px;height:129px;float:left;float:left;}
.fields .up_image li:nth-child(3n+3){margin-right: 0 ;float:right !important }
.fields .up_image li .cross{width:23px;height:23px;display:block; background:url(<?php echo($this->webroot);?>img/backcross.png) no-repeat center center;position: absolute;z-index:999;left:10px;top:10px;border:0px solid red;}
.fields .up_image li textarea{width:198px;height:90px;background:#eeeeee;overflow: hidden;color:# color: #000;font-family: 'Lato',sans-serif !important;font-size: 13px;line-height:22px;text-align: left;resize:none;}
textarea {resize:none;}
.cropper-container{height:285px !important;top:0px !important}
</style>
<?php echo $this->Html->scriptStart(array('inline'=>false));?>
/*var croppicContainerEyecandyOptions = {
        uploadUrl:'<?php echo $this->webroot;?>skills/img_save_to_file',
		cropUrl:'<?php echo $this->webroot;?>skills/img_crop_to_file',
		imgEyecandy:true,
		loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
		onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
		onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
		onImgDrag: function(){ console.log('onImgDrag') },
		onImgZoom: function(){ console.log('onImgZoom') },
		onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
		onAfterImgCrop:function(){ console.log('onAfterImgCrop') }
}
var cropContainerEyecandy = new Croppic('cropContainerEyecandy', croppicContainerEyecandyOptions);
cropper.destroy(); 	// no need explaining here :) 
cropper.reset(); 	// destroys and then inits the cropper
*/
/*function performClick1() {
	$('#theFile1').click();
}*/
/*$(document).ready( function(){
	var preview1 = $("#Preview1");
	$('#theFile1').change(function(event){
		var input = $(event.currentTarget);
		var file = input[0].files[0];
		var reader = new FileReader();
		reader.onload = function(e){
		   image = e.target.result;
		   var ext = image.split(';');
		   if(ext[0]!=''){
			   var ext1 = ext[0].split('/');
			   if(ext1[1]!='' && (ext1[1]=='jpg' || ext1[1]=='jpeg' || ext1[1]=='gif' || ext1[1]=='png')){
					//preview1.html("<img src='"+image+"' />");
					$('.cropper').attr("src", image);
					$('.cropper-container img').attr("src", image);
					$("#photoErr").html('');
			   } else {
					$("#photoErr").html('Please select only jpg, jpeg, png, gif format images.');
					$('#theFile').val('');
			   }
		   }
		};
		reader.readAsDataURL(file);
	});
});

var  $dataX = $("#data-x"),
	 $dataY = $("#data-y"),
	 $dataHeight = $("#data-height"),
	 $dataWidth = $("#data-width");

$(".cropper").cropper({
  aspectRatio: 1.618,
  data: {
	x: 100,
    y: 100,
    width: 300,
    height: 200
  },
  done: function(data) {
    $dataX.val(data.x);
    $dataY.val(data.y);
    $dataHeight.val(data.height);
    $dataWidth.val(data.width);
  }
});*/
 
<?php echo $this->Html->scriptEnd();?>