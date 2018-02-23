<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title></title>
<meta name="" content="">
<script type='text/javascript' src='<?php echo $this->webroot;?>js_slider/jquery.js'></script>

<link rel='stylesheet' href='<?php echo $this->webroot;?>css_slider/style.css' type='text/css' media='all' />
    
<link rel='stylesheet' href='<?php echo $this->webroot;?>css_slider/jquery.mCustomScrollbar.css' type='text/css' media='all' />

<script type='text/javascript' src='<?php echo $this->webroot;?>js_slider/jquery.mCustomScrollbar.min.js'></script>

<script type='text/javascript' src='<?php echo $this->webroot;?>js_slider/imagesloaded.js'>
</script>
<script type='text/javascript' src='<?php echo $this->webroot;?>js_slider/jquery.lazyload.js'>
</script>
<script type='text/javascript' src='<?php echo $this->webroot;?>js_slider/actions.js'>
</script>
</head>
<?php
 if(isset($skill['Skill']['skill_tool_pics']) && $skill['Skill']['skill_tool_pics']!=''){
	  $skill_tool_pics_exp=explode(',',$skill['Skill']['skill_tool_pics']);
?>
 
<body style="margin:0;padding:0;">
	<div class="main_content_hold">
	    <div id="mainContent">
			<div class="contentSection first ">
				    <div id="homeGallery">
			        <div class="imageGallery story scrollable">
					<?php if(!empty($skill_tool_pics_exp)){ ?>
			          <div class="imageGalleryInner">
					   <?php foreach($skill_tool_pics_exp as $skill_tool_pic){ 
					     $testing = 'http://aktively.com/beta/tool_images/'.$skill_tool_pic;
						 list($width, $height, $type, $attr) = getimagesize($testing);
					   ?>
						 <div class="item">
						   <img src="<?php echo $this->webroot;?>tool_images/<?php echo $skill_tool_pic;?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" nopin="nopin" />
						 </div>
					   <?php } ?>
			          </div>
					 <?php }?>
			        </div>
			    </div>
			</div>
		</div>
	</div>
</body>
<?php } ?>
</html>
<style>
.mCSB_buttonRight{border:0px solid red;background:url(../../app/webroot/images/arrow_right.png) no-repeat !important;height:50px !important}
.mCSB_buttonLeft{border:0px solid red;background:url(../../app/webroot/images/arrow_left.png) no-repeat !important;height:50px !important}
.item img { width:700px !important; height: 500px !important;}
</style>