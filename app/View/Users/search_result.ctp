<!--------------------Login POPUP------------------------------>
 <div class="absolute_signup" id="absolute_login" style="z-index:99999999">
  <form class="contact_form" name="reg_form_user" id="reg_form_user" action="<?php echo $this->webroot.'users/login'; ?>"method="POST" >
	 <div class="signup_background">
		<div class="sign_up_padding">
			<b>LET US KNOW WHO YOU ARE</b>
			<p>Feeling lazy? Use your social media</p>
			<input type="button" class="social_btn fb_btn" value="Facebook"/>
			<input type="button" class="social_btn gpls_btn" value="Google +"/><br/><br/>
			
			<input type="text" placeholder="Your e-mail?" class="home_search_text" name="data[User][email]" id="email_login"/>
			<span id="email_login_err"></span>
			<input type="password" placeholder="Your password?" class="home_search_text" name="data[User][password]" id="password_login"/>
			<span id="password_login_err"></span>
			<input type="submit" class="social_btn sign_up_btnn" value="Login" class="home_search_text" onclick="return validate_login();"/>

			<a class="forgot_pass" href="javascript:void(0);" onclick="forgotpassword()">Forgot Password?</a>
		</div>
	 </div>
	</form>
 </div>
 <div class="sign_up_holder" id="sign_up_login"></div>
 <!--------------------Forgot Password POPUP------------------------------>
 <div class="absolute_signup" id="absolute_fp" style="z-index:99999999">
  <form class="contact_form" name="reg_form_user" id="reg_form_user" action="<?php echo $this->webroot.'users/forgot_password'; ?>"method="POST" >
	 <div class="signup_background">
		<div class="sign_up_padding">
			<b>LET US KNOW WHO YOU ARE</b>   	 		
			<input type="text" placeholder="Your e-mail?" class="home_search_text" name="data[User][email]" id="email_fp"/>
			<span id="email_fp_err"></span>
			<input type="submit" class="social_btn sign_up_btnn" value="Recover" class="home_search_text" onclick="return validate_fp();"/>

			<a class="forgot_pass" href="javascript:void(0);" onclick="login()">Back to login</a>
		</div>
	 </div>
  </form>
 </div>
 <div class="sign_up_holder" id="sign_up_fp"></div>
 <!--------------------POPUP END------------------------------>
<iframe id="frame" src="" width="100%">
</iframe>
<div class="search_hold_1" id="main_result_map_div">
	<div class="search_by_skill">
	<div class="search_by_skill_padding">
		<p class="fashion_font"><?php if(isset($search_text) && $search_text!='empty'){echo $search_text;}else{echo 'All Talents';}?> in <span><?php if(isset($location_text) && $location_text!=''){echo $location_text;}else{echo 'Everywhere';}?></span></p>
		<p>Try these:  <a href="">Wood turning</a>   Furniture   Reclaimed wood</p>
	</div>
	<div class="search_by_skill_padding">
		<b>Price learining skill</b><br/>
		<div class="clearfix"></div>
			<div id="slider-range"></div>
			<div id="amount"><?php echo $amt;?></div>
			<div id="amount1"><?php echo $amt1;?></div>					
		<div class="clearfix"></div>
		<hr>
		<div class="clearfix"></div>
		<b>Time</b>
		<ul>
			<li><input type="radio" /><p>Monday</p></li>
			<li><input type="radio" /><p>Tuesday</p></li>
			<li><input type="radio" /><p>Wedneday</p></li>
			<li><input type="radio" /><p>Thursday</p></li>
			<li><input type="radio" /><p>Friday</p></li>
			<li><input type="radio" /><p>Saturday</p></li>
			<li><input type="radio" /><p>Sunday</p></li>
		</ul>
	</div>
	<?php if(!empty($srch_rslts)){ ?>
		<ul class="search_result_box">
		 <?php 
		 $i=0;
		 foreach($srch_rslts as $serchskill){ 
		  $skillimages_exp=explode(',',$serchskill['SkillImage']['0']['image']);
		  $subskill_exp=explode(',',$serchskill['Skill']['sub_category']);
		 ?>
			<li id="srchrslt<?php echo $i;?>" onclick="myClick('<?php echo base64_encode($serchskill['Skill']['id']);?>')" onmouseover="myhover(<?php echo $i;?>);" onmouseout="myhoverout(<?php echo $i;?>);">
				<div class="search_result_box_img">
				   <?php
					if(isset($serchskill['Skill']['banner']) && $serchskill['Skill']['banner']!=''){
					$uploadFolder = "skill_images";
					$uploadPath = WWW_ROOT . $uploadFolder . '/' . $serchskill['Skill']['banner'];
					if (file_exists($uploadPath))
					{
				   ?>
					  <img src="<?php echo $this->webroot;?>skill_images/<?php echo $serchskill['Skill']['banner'];?>" alt="Cover Image" />
				  <?php }else{ ?>
					  <img src="<?php echo $this->webroot;?>img/profile_cover.jpg" alt="Cover Image" />
				  <?php
					}}
					else{
				  ?>
					  <img src="<?php echo $this->webroot;?>img/profile_cover.jpg" alt="Cover Image" />
				  <?php } ?>
					<img src="<?php echo $this->webroot;?>img/share1.png" alt="Wishlist" class="share_skil"/>
				</div>
				<div class="search_result_box_des">
					<?php
					 if(isset($serchskill['User']['profile_image']) && $serchskill['User']['profile_image']!='')
					 {
					?><img src="<?php echo $this->webroot; ?>user_images/<?php echo $serchskill['User']['profile_image'];?>" alt="<?php echo $serchskill['User']['first_name'];?>" />
					<?php }else{ ?><img src="<?php echo $this->webroot; ?>user_images/user_image.png" alt="<?php echo $serchskill['User']['first_name'];?>" />
					<?php } ?>

					<aside>
						<b><a href="<?php echo $this->webroot;?>skills/details/<?php echo base64_encode($serchskill['Skill']['id']);?>" style="color:#000"><?php echo $serchskill['User']['first_name'].' '.$serchskill['User']['last_name'];?></a></b>
						<p>
						<?php 
						  $subskillstrng='';
					      if(!empty($subskill_exp))
						  {
							 foreach($subskill_exp as $subskill)
							 { 
								 $subskillstrng.=$subskill.' | ';
							 } 
						  } 
						  echo trim($subskillstrng,' | ');
						?>
						</p>
						<br/>
						<p><img src="<?php echo $this->webroot;?>img/local_mp.png" alt="Location"/><span><?php echo $serchskill['Skill']['skill_city'].', '.$serchskill['Skill']['skill_state'];?></span></p>
						<div class="blackstar_rating">
							<a href="javascript:void(0);"><img src="<?php echo $this->webroot;?>img/blackstar.png" alt="" /></a>
							<a href="javascript:void(0);"><img src="<?php echo $this->webroot;?>img/blackstar.png" alt="" /></a>
							<a href="javascript:void(0);"><img src="<?php echo $this->webroot;?>img/blackstar.png" alt="" /></a>
							<a href="javascript:void(0);"><img src="<?php echo $this->webroot;?>img/garystar.png" alt="" /></a>
							<a href="javascript:void(0);"><img src="<?php echo $this->webroot;?>img/garystar.png" alt="" /></a>
						</div>
						<div class="clearfix"></div><br/>
						<?php if(isset($serchskill['Skill']['min_price']) && $serchskill['Skill']['min_price']!='' && $serchskill['Skill']['max_price']!=''){?>
						  <strong>$<?php echo intval($serchskill['Skill']['min_price']);?> - $<?php echo intval($serchskill['Skill']['max_price']);?> <span>/hour</span></strong>
						<?php } ?>
					</aside>
				</div>
			</li>
		  <?php $i++;} ?>
		</ul>
	<?php } ?>
</div>
	<div class="map1">
		
		<div class="step_map" id="map">
			
		</div>
		<input type="hidden" id="lat" name="data[Skill][skill_workshop_lat]" value="55.5314076"/>
		<input type="hidden" id="lang" name="data[Skill][skill_workshop_lang]" value="10.046474"/>
	</div>
	
 </div>
<?php
 $skill_arr='';
 $skill_data_arr='';
 if(!empty($srch_rslts))
 { 
	 $i=1;
	 foreach($srch_rslts as $serchskill)
	 {
	 $skillimages_exp=explode(',',$serchskill['SkillImage']['0']['image']);
	 $subskill_exp=explode(',',$serchskill['Skill']['sub_category']);

	 $map_slider = 'map_slider';
	 $share_skil='share_skil';
	 $slider_map='slider_map';
	 $control_next='control_next';
	 $control_prev='control_prev';
	 $search_result_box_des='search_result_box_des';
	 $clearfix='clearfix';
	 $blackstar_rating='blackstar_rating';

	 $starrtng='<a href="javascript:void(0)"><img src="'.$this->webroot.'img/blackstar.png"></a><a href="javascript:void(0)"><img src="'.$this->webroot.'img/blackstar.png"></a><a href=""><img src="'.$this->webroot.'img/blackstar.png"></a><a href="javascript:void(0)"><img src="'.$this->webroot.'img/garystar.png"></a><a href="javascript:void(0)"><img src="'.$this->webroot.'img/garystar.png"></a>';

	 $shareimg='<img src="'.$this->webroot.'img/share1.png" class='.$share_skil.'>';
     $skllimgsli='';
	 $skllli='';
	 foreach($skillimages_exp as $skillimages_)
	 {
      $skllimgsli.='<li><img src="'.$this->webroot.'skill_images/'.$skillimages_.'">';
	 }
	 foreach($subskill_exp as $subskill_)
	 {
       $skllli.=$subskill_.' | ';
	 }
	 $skllli=trim($skllli,' | ');

	 $nme='<a href="'.$this->webroot.'skills/details/'.base64_encode($serchskill['Skill']['id']).'" style="color:#000">'.$serchskill['User']['first_name'].' '.$serchskill['User']['last_name'].'</a>';
	 $prc='$'.intval($serchskill['Skill']['min_price']).' - $'.intval($serchskill['Skill']['max_price']);


	  if(isset($serchskill['User']['profile_image']) && $serchskill['User']['profile_image']!='')
	  {
		$profimg='<img src="'.$this->webroot.'user_images/'.$serchskill['User']['profile_image'].'" alt="'.$serchskill['User']['first_name'].'" />';
	  }
	  else
	  {
		$profimg='<img src="'.$this->webroot.'user_images/user_image.png" alt="'.$serchskill['User']['first_name'].'" />';
	  }
	 
	 $skill_arr.="['".$serchskill['Category']['name']."', ". $serchskill['Skill']['skill_workshop_lat'].", ".$serchskill['Skill']['skill_workshop_lang'].", ".$i."],";
       
	 $skill_data_arr.="['<div class=".$map_slider." onclick=myClick(\'".base64_encode($serchskill['Skill']['id'])."\')>".$shareimg."<div id=".$slider_map."><a class=".$control_next.">></a><a class=".$control_prev."><</a><ul>".$skllimgsli."</ul></div><div class=".$search_result_box_des." onclick=myClick(\'".base64_encode($serchskill['Skill']['id'])."\')>".$profimg."<aside><b>".$nme."</b><p>".$skllli."</p><div class=".$clearfix."></div><div class=".$blackstar_rating.">".$starrtng."</div><div class=".$clearfix."></div><strong>".$prc."<span>/hour</span></strong></aside></div></div>'],";

	  $i++;
	 }
 }
 ?>
<style>
.step_map{float:right;width:52.5% !important;}
#slider_map {position: relative;overflow: hidden;margin:0 auto;border-radius: 0px;}
#slider_map ul {position: relative;margin: 0;padding: 0;height: 186px;list-style: none;}
#slider_map ul li {position: relative;display: block;float: left;margin: 0;padding: 0;width: 312px;height: 186px;background: #ccc;text-align: center;}
#slider_map ul li img{vertical-align:top;width:100%;height:186px}
a.control_prev, a.control_next {position: absolute;top: 40%;z-index: 999;display: block;padding: 4% 3%;width: auto;height: auto;color: #fff;text-decoration: none;font-weight: 600;font-size: 18px;opacity: 0.8;cursor: pointer;}
a.control_prev:hover, a.control_next:hover {opacity: 1;-webkit-transition: all 0.5s ease;}
a.control_prev {border-radius:0;}
a.control_next {right: 0;border-radius: 0px;}
.slider_option {position: relative;margin: 10px auto;width: 160px;font-size: 18px;}
.absolute_signup span{color:red;}
#map img { max-width: inherit; }
ul.search_result_box li{cursor:pointer}
#frame{height:auto;min-height:853px;display:none;border:0}
/* white background and box outline */
.gm-style > div:first-child > div + div > div:last-child > div > div:first-child > div
{
    /* we have to use !important because we are overwritng inline styles */
    background-color: transparent !important;
    box-shadow: none !important;
    width: auto !important;
    height: auto !important;
}

/* arrow colour */
.gm-style > div:first-child > div + div > div:last-child > div > div:first-child > div > div > div
{
    background-color: #fff !important; 
}

/* close button */
.gm-style > div:first-child > div + div > div:last-child > div > div:last-child
{
    margin-right: 5px;
    margin-top: 5px;
}

/* image icon inside close button */
.gm-style > div:first-child > div + div > div:last-child > div > div:last-child > img
{
    display: none;
}

/* positioning of infowindow */
.gm-style-iw
{
    top: 22px !important;
    left: 22px !important;
	background:#fff;
	width:auto;height:auto;overflow:hidden;
}
</style>

<?php echo $this->Html->scriptStart(array('inline'=>false));?>
var latitude_city="<?php echo ((isset($srch_rslts[0]['Skill']['skill_workshop_lat']) && $srch_rslts[0]['Skill']['skill_workshop_lat']!='')?$srch_rslts[0]['Skill']['skill_workshop_lat']:$center0);?>";
var longitude_city="<?php echo ((isset($srch_rslts[0]['Skill']['skill_workshop_lang']) && $srch_rslts[0]['Skill']['skill_workshop_lang']!='')?$srch_rslts[0]['Skill']['skill_workshop_lang']:$center1);?>";

var search_text='<?php echo ((isset($search_text) && $search_text!='')?$search_text:"empty");?>';
var beaches = [<?php echo ((isset($skill_arr) && $skill_arr!='')?$skill_arr:'');?>];

function initialize() {
var noPoi = [
 {
    featureType: "poi",
    stylers: [
      { visibility: "off" }
    ]   
  }
];

  var mapOptions = {
    zoom: 11,
    center: new google.maps.LatLng(latitude_city , longitude_city),
	styles:noPoi
  }
  var map = new google.maps.Map(document.getElementById('map'),
                                mapOptions);

  setMarkers(map, beaches);

  

  google.maps.event.addListener(map,'dragend',function(event) {
     var amt1=$("#amount1").html();
	 var amt=$("#amount").html();
	 var lat0 = map.getBounds().getNorthEast().lat();
     var lng0 = map.getBounds().getNorthEast().lng();
     var lat1 = map.getBounds().getSouthWest().lat();
     var lng1 = map.getBounds().getSouthWest().lng();
	 var center0 = map.getCenter().lat();
	 var center1 = map.getCenter().lng();

	 window.location.href='<?php echo($this->webroot);?>users/search_result/'+lat0+'/'+lng0+'/'+lat1+'/'+lng1+'/'+search_text+'/'+amt1+'/'+amt+'/'+center0+'/'+center1;

	 /*alert('<?php echo($this->webroot);?>skills/mapframe/'+lat0+'/'+lng0+'/'+lat1+'/'+lng1+'/'+search_text);
	 $.post('<?php echo($this->webroot);?>skills/mapframe/'+lat0+'/'+lng0+'/'+lat1+'/'+lng1+'/'+search_text, function(data){
				if(data!=''){
					alert(data);
					var reslt=data;
					beaches = [reslt];
					alert(beaches);
					google.maps.event.trigger(map, 'resize');
					setMarkers(map, beaches);
					
				} else {
					
				}
	 });*/

  });

  /*google.maps.event.addListener(map, 'zoom_changed', function() {
     var lat0 = map.getBounds().getNorthEast().lat();
     var lng0 = map.getBounds().getNorthEast().lng();
     var lat1 = map.getBounds().getSouthWest().lat();
     var lng1 = map.getBounds().getSouthWest().lng();

  
 });*/
 $('.ui-slider-handle').mouseup(function() {
		var amt1=$("#amount1").html();
		var amt=$("#amount").html();
		var lat0 = map.getBounds().getNorthEast().lat();
		var lng0 = map.getBounds().getNorthEast().lng();
		var lat1 = map.getBounds().getSouthWest().lat();
		var lng1 = map.getBounds().getSouthWest().lng();
		var center0 = map.getCenter().lat();
	    var center1 = map.getCenter().lng();

		window.location.href='<?php echo($this->webroot);?>users/search_result/'+lat0+'/'+lng0+'/'+lat1+'/'+lng1+'/'+search_text+'/'+amt1+'/'+amt+'/'+center0+'/'+center1;
  });

}
 

 $(function() {
			$( "#slider-range" ).slider({
			range: true,
			min: 0,
			max: 500,
			values: [ <?php echo substr($amt1,1);?>, <?php echo substr($amt,1);?> ],
			slide: function( event, ui ) {
			  $( "#amount" ).html("$"+ui.values[ 1 ] );
			  $( "#amount1" ).html("$"+ui.values[ 0 ] );
			 }
		});
});

/**
 * Data for the markers consisting of a name, a LatLng and a zIndex for
 * the order in which these markers should display on top of each
 * other.
 */


var marker;
var markers = new Array();
function setMarkers(map, locations) {
  // Add markers to the map

  // Marker sizes are expressed as a Size of X,Y
  // where the origin of the image (0,0) is located
  // in the top left of the image.

  // Origins, anchor positions and coordinates of the marker
  // increase in the X direction to the right and in
  // the Y direction down.
  var image = {
    url: '<?php echo $this->webroot;?>img/mapmarker.png',
    // This marker is 20 pixels wide by 32 pixels tall.
    size: new google.maps.Size(30, 50),
    // The origin for this image is 0,0.
    origin: new google.maps.Point(0,0),
    // The anchor for this image is the base of the flagpole at 0,32.
    anchor: new google.maps.Point(0, 32)
  };

  var image_black = {
    url: '<?php echo $this->webroot;?>img/mapmarker_black.png',
    // This marker is 20 pixels wide by 32 pixels tall.
    size: new google.maps.Size(30, 50),
    // The origin for this image is 0,0.
    origin: new google.maps.Point(0,0),
    // The anchor for this image is the base of the flagpole at 0,32.
    anchor: new google.maps.Point(0, 32)
  };
  // Shapes define the clickable region of the icon.
  // The type defines an HTML &lt;area&gt; element 'poly' which
  // traces out a polygon as a series of X,Y points. The final
  // coordinate closes the poly by connecting to the first
  // coordinate.
   
  var infoWindowContent = [
        <?php echo $skill_data_arr;?>
    ];
	
    // Display multiple markers on a map
  var infoWindow = new google.maps.InfoWindow();

  var shape = {
      coord: [1, 1, 1, 20, 18, 20, 18 , 1],
      type: 'poly'
  };

 
  //var bounds = new google.maps.LatLngBounds();
  for (var i = 0; i < locations.length; i++) {
    var beach = locations[i];
    var myLatLng = new google.maps.LatLng(beach[1], beach[2]);
    marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        icon: image,
        shape: shape,
        title: beach[0],
        zIndex: beach[3],
		animation: google.maps.Animation.DROP
    });
	markers.push(marker);

	google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
	  return function() {
        marker.setIcon(image_black);
	  }
    })(marker, i));
	google.maps.event.addListener(marker, 'mouseout', (function(marker, i) {
	  return function() {
		marker.setIcon(image);
	  }
    })(marker, i));

	google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
		 for (var j = 0; j < locations.length; j++) {
		  $('#srchrslt'+j).css({"border":"0px solid #4743e2"});
		 }
         $('#srchrslt'+i).css({"border":"1px solid #4743e2"});
		  infoWindow.setContent(infoWindowContent[i][0]);
		  infoWindow.open(map, marker);
		  
            //marker.setIcon(image_black);
	       
		   var slideCount = $('#slider_map ul li').length;
			var slideWidth = $('#slider_map ul li').width();
			var slideHeight = $('#slider_map ul li').height();
			var sliderUlWidth = slideCount * slideWidth;
			
			$('#slider_map').css({ width: slideWidth, height: slideHeight });
			
			$('#slider_map ul').css({ width: sliderUlWidth, marginLeft: - slideWidth });
			
			$('#slider_map ul li:last-child').prependTo('#slider_map ul');

			function moveLeft() {
				$('#slider_map ul').animate({
					left: + slideWidth
				}, 200, function () {
					$('#slider_map ul li:last-child').prependTo('#slider_map ul');
					$('#slider_map ul').css('left', '');
				});
			};

			function moveRight() {
				$('#slider_map ul').animate({
					left: - slideWidth
				}, 200, function () {
					$('#slider_map ul li:first-child').appendTo('#slider_map ul');
					$('#slider_map ul').css('left', '');
				});
			};

			$('a.control_prev').click(function () {
				moveLeft();
			});

			$('a.control_next').click(function () {
			  moveRight();
			});
        }
    })(marker, i));
	//bounds.extend(myLatLng);
  }
 /*if(latitude_city==0)
 {
   map.fitBounds(bounds);
   map.setZoom(11);
 }
 else
 {
   map.setZoom(11);
 }*/
}

google.maps.event.addDomListener(window, 'load', initialize);

function myClick(id){
        window.location.href="<?php echo $this->webroot;?>skills/details/"+id;
}
function myhover(id){
        $('#srchrslt'+id).css({"border":"1px solid #4743e2"});
        google.maps.event.trigger(markers[id], 'mouseover');
}
function myhoverout(id){
        $('#srchrslt'+id).css({"border":"0px solid #4743e2"});
        google.maps.event.trigger(markers[id], 'mouseout');
}
 
jQuery(document).ready(function ($) {
  $('#checkbox').change(function(){
    setInterval(function () {
        moveRight();
    }, 3000);
  });
});  
<?php echo $this->Html->scriptEnd();?>
