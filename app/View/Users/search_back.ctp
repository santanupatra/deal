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
<div class="container_960">
	<div class="block">
	<div class="block_padding">

		<p class="fashion_font"><?php if(isset($search_text) && $search_text!=''){echo $search_text;}else{echo 'All Talents';}?> in <span><?php if(isset($location_text) && $location_text!=''){echo $location_text;}else{echo 'Everywhere';}?></span></p>
        
		<?php if(!empty($try_also)){?>
		 <p>Try these:
		 <?php 
		  shuffle($try_also);
		  $cnt=count($try_also);
		  for($t=0;$t<$cnt;$t++){
			  if($t<5){
		?>
		   <?php echo $try_also[$t].'&nbsp;&nbsp;';?>
		<?php }} ?>
		 </p>
		<?php } ?>
		<div class="margintop30">
			<div class="show_filter">
				<p onclick="show_filter()"><span><img src="<?php echo $this->webroot;?>img/show_filter_down.png" alt="" class="shwfltrimg"></span>Show filter search result</p>
			</div>
			<?php if(!empty($srch_rslts)){?>
			<div class="view_makers" id="vewmrkrs">
				<p onclick="show_map()"><span><img src="<?php echo $this->webroot;?>img/view_makers.png" alt=""></span>View makers in map</p>
			</div>
		    <?php } ?>
		</div>

	</div>
   <div id="resdiv">
	<div class="search_by_skill_padding" id="sortfilterdiv" style="display:none">
		<div class="col-1-3 margin-right30">
			<b>Price learning skill</b><br/>
			<div class="clearfix"></div>
			<div id="slider-range"></div>
			<div id="amount">$500</div>
			<div id="amount1">$0</div>					
			<div class="clearfix"></div>
		</div>
		<div class="col-1-3">
			<div class="clearfix"></div>
			<b>Time</b>
			<ul>
				<li><input type="radio" name="tme" id="tme1" value="1" onclick="getradioval(1)"/><p>Monday</p></li>
				<li><input type="radio" name="tme" id="tme2" value="2" onclick="getradioval(2)"/><p>Tuesday</p></li>
				<li><input type="radio" name="tme" id="tme3" value="3" onclick="getradioval(3)"/><p>Wedneday</p></li>
				<li><input type="radio" name="tme" id="tme4" value="4" onclick="getradioval(4)"/><p>Thursday</p></li>
				<li><input type="radio" name="tme" id="tme5" value="5" onclick="getradioval(5)"/><p>Friday</p></li>
				<li><input type="radio" name="tme" id="tme6" value="6" onclick="getradioval(6)"/><p>Saturday</p></li>
				<li><input type="radio" name="tme" id="tme7" value="7" onclick="getradioval(7)"/><p>Sunday</p></li>
			</ul>
			<input type="hidden" name="timerange" id="timerange">
		</div>
		<div class="col-1-3">
			<b>Sort by</b>
			<div class="all">
				<select id="sortsel" onchange="getsortval(this.value)">
				  <option value="bestmatch">Best match</option>
                  <option value="nearest">Nearest to me</option>
                  <option value="review">Most reviewed</option>
				</select>
			</div>
		</div>
	</div>
    <div id="imagecontent">
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
				<p>by <?php echo $serchskill['User']['first_name'].' '.$serchskill['User']['last_name'];?><br>$<?php echo intval($serchskill['Skill']['min_price']);?> - $<?php echo intval($serchskill['Skill']['max_price']);?> /hour</p>
			</div>
			<div class="clearfix"></div>
		 </div>
        </div>
        <div class="clearfix"></div>
	 </div>
	<?php $k++;}} ?>
</div>
</div>
<div class="clearfix"></div>

<input type="button" class="loadMore_button" value="">
<!-- <?php if(!empty($srch_rslts)){?>
  <input type="button" class="loadMore_button" value="LOAD MORE SKILLS">
<?php }else{ ?>
  <input type="button" class="loadMore_button" value="NO RESULT FOUND">
<?php } ?> -->
</div>
</div>
<div class="clearfix"></div>
</div>
<div id="mapdiv" style="visibility:hidden">
   <div class="map1">
		<div class="step_map" id="map">
		</div>
	</div>
</div>
<div class="clearfix"></div>
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
	 //$control_next='control_next';
	 //$control_prev='control_prev';
	 $search_result_box_des='search_result_box_des';
	 $clearfix='clearfix';
	 $blackstar_rating='blackstar_rating';

	 $starrtng='<a href="javascript:void(0)"><img src="'.$this->webroot.'img/blackstar.png"></a><a href="javascript:void(0)"><img src="'.$this->webroot.'img/blackstar.png"></a><a href=""><img src="'.$this->webroot.'img/blackstar.png"></a><a href="javascript:void(0)"><img src="'.$this->webroot.'img/garystar.png"></a><a href="javascript:void(0)"><img src="'.$this->webroot.'img/garystar.png"></a>';

	 //$shareimg='<img src="'.$this->webroot.'img/share1.png" class='.$share_skil.'>';
     
	
	  $usrid = $this->Session->read('Auth.User.id');
	  if(isset($usrid) && $usrid!='')
	  {
	   if($usrid != $serchskill['Skill']['user_id'])
	   {
		  if(in_array($serchskill['Skill']['id'],$wishlist_ids)){  
				$shareimg='<div id="mapwishlisticon'.$serchskill['Skill']['id'].'" class="wishlisticon" onclick="make_fav_map('.$serchskill['Skill']['id'].',event)"><a href="javascript:void(0);"><img src="'.$this->webroot.'img/share1_black.png" title="Remove from wishlist" class="share_icon"></a></div>';
		  }else{
			   $shareimg='<div id="mapwishlisticon'.$serchskill['Skill']['id'].'" onclick="make_fav_map('.$serchskill['Skill']['id'].',event)" class="wishlisticon"><a href="javascript:void(0);"><img src="'.$this->webroot.'img/share1.png" title="Add to wishlist" class="share_icon"></a></div>';
		  }}else{
			   $shareimg='<div id="mapwishlisticon'.$serchskill['Skill']['id'].'" class="wishlisticon"><a href="javascript:void(0);"><img src="'.$this->webroot.'img/share1.png" class="share_icon"></a></div>';
		} }else{
			  $shareimg='<div id="mapwishlisticon'.$serchskill['Skill']['id'].'" class="wishlisticon"><a href="javascript:void(0);"><img src="'.$this->webroot.'img/share1.png" class="share_icon"></a></div>';
	  }


     $skllimgsli='';
	 $skllli='';

	 /*foreach($skillimages_exp as $skillimages_)
	 {
      $skllimgsli.='<li><img src="'.$this->webroot.'skill_images/'.$skillimages_.'">';
	 }*/
     $skllimgsli.='<li><img src="'.$this->webroot.'skill_images/'.$skillimages_exp[0].'">';

	 foreach($subskill_exp as $subskill_)
	 {
       $skllli.=$subskill_.' | ';
	 }
	 $skllli=trim($skllli,' | ');

	 $nme='<a href="'.$this->webroot.'skills/details/'.base64_encode($serchskill['Skill']['id']).'" style="color:#000">'.$serchskill['User']['first_name'].' '.$serchskill['User']['last_name'].'</a>';
	 $prc='$'.intval($serchskill['Skill']['min_price']).' - $'.intval($serchskill['Skill']['max_price']);


	  if(isset($serchskill['User']['profile_image']) && $serchskill['User']['profile_image']!='')
	  {
		if (preg_match('/https:/',$serchskill['User']['profile_image']))
		{
			$profimg='<img src="'.$serchskill['User']['profile_image'].'" alt="'.$serchskill['User']['first_name'].'" />';
		}else{
		   $profimg='<img src="'.$this->webroot.'user_images/'.$serchskill['User']['profile_image'].'" alt="'.$serchskill['User']['first_name'].'" />';
	    }
	  }
	  else
	  {
		$profimg='<img src="'.$this->webroot.'user_images/user_image.png" alt="'.$serchskill['User']['first_name'].'" />';
	  }
	 
	 $skill_arr.="['".$serchskill['Category']['name']."', ". $serchskill['Skill']['skill_workshop_lat'].", ".$serchskill['Skill']['skill_workshop_lang'].", ".$i."],";
       
	 $skill_data_arr.="['<div class=".$map_slider." onclick=myClick(\'".base64_encode($serchskill['Skill']['id'])."\')>".$shareimg."<div id=".$slider_map."><ul>".$skllimgsli."</ul></div><div class=".$search_result_box_des.">".$profimg."<aside><b>".$nme."</b><p>".$skllli."</p><div class=".$clearfix."></div><div class=".$blackstar_rating.">".$starrtng."</div><div class=".$clearfix."></div><strong>".$prc."<span>/hour</span></strong></aside></div></div>'],";

	  $i++;
	 }
 }
 ?>
<style>
.map_slider,.search_result_box_des{cursor:pointer}
.step_map{float:left;}
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
{background-color: transparent !important;box-shadow: none !important;width: auto !important;height: auto !important;}
/* arrow colour */
.gm-style > div:first-child > div + div > div:last-child > div > div:first-child > div > div > div
{background-color: #fff !important; }
/* close button */
.gm-style > div:first-child > div + div > div:last-child > div > div:last-child
{margin-right: 5px;margin-top: 5px;}
/* image icon inside close button */
.gm-style > div:first-child > div + div > div:last-child > div > div:last-child > img
{display: none;}
/* positioning of infowindow */
.gm-style-iw{top: 22px !important;left: 22px !important;background:#fff;width:auto;height:auto;overflow:hidden;}

/*#fltrresdiv{width: 960px;opacity: 0;margin: 0 auto;overflow: hidden;}
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
.overlay p{margin-top:4%;}
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

<?php echo $this->Html->scriptStart(array('inline'=>false));?>

var search_text='<?php echo ((isset($search_text) && $search_text!='')?$search_text:"empty");?>';
var location_text='<?php echo ((isset($location_text) && $location_text!='')?$location_text:"empty");?>';

var latitude_city="<?php echo ((isset($srch_rslts[0]['Skill']['skill_workshop_lat']) && $srch_rslts[0]['Skill']['skill_workshop_lat']!='')?$srch_rslts[0]['Skill']['skill_workshop_lat']:$lat);?>";
var longitude_city="<?php echo ((isset($srch_rslts[0]['Skill']['skill_workshop_lang']) && $srch_rslts[0]['Skill']['skill_workshop_lang']!='')?$srch_rslts[0]['Skill']['skill_workshop_lang']:$long);?>";



$(function() {
	$( "#slider-range" ).slider({
	range: true,
	min: 0,
	max: 500,
	values: [ 0, 500 ],
	slide: function( event, ui ) {
	  $( "#amount" ).html("$"+ui.values[ 1 ] );
	  $( "#amount1" ).html("$"+ui.values[ 0 ] );
	 }
	});

	 $('.ui-slider-handle').mouseup(function() {
			var amt1=$("#amount1").html();
			var amt=$("#amount").html();
			var timeval=$('#timerange').val();
			if(timeval=='')
		    {
			   timeval='empty';
			}
			else
		    {
			   timeval=timeval;
		    }
			var sortsel=$("#sortsel").val();
	       
			$.post('<?php echo($this->webroot);?>users/mapframe1/'+search_text+'/'+amt1+'/'+amt+'/'+location_text+'/'+timeval+'/'+sortsel, function(data){
				if(data!=''){
					$('#imagecontent').load('<?php echo($this->webroot);?>users/mapframe/'+search_text+'/'+amt1+'/'+amt+'/'+location_text+'/'+timeval+'/'+sortsel);
				} else {
					
				}
		   });
	 });
});
 
 function open_overlay(k)
 {
  $('#overlaydv'+k).stop().fadeTo(200,1);;
 }
 function close_overlay(k)
 {
  $('#overlaydv'+k).stop().fadeTo(200,0);;
 }

 function getradioval(vl)
 {
   if(vl!='')
   {
      $('#timerange').val(vl);
	  var amt1=$("#amount1").html();
	  var amt=$("#amount").html();
	  var sortsel=$("#sortsel").val();
			$.post('<?php echo($this->webroot);?>users/mapframe1/'+search_text+'/'+amt1+'/'+amt+'/'+location_text+'/'+vl+'/'+sortsel, function(data){
				if(data!=''){
					$('#imagecontent').load('<?php echo($this->webroot);?>users/mapframe/'+search_text+'/'+amt1+'/'+amt+'/'+location_text+'/'+vl+'/'+sortsel);
				} else {
					
				}
		});
   }
 }
 $(document).ready(function(){
        /*if (Modernizr.touch) {
            $(".close-overlay").removeClass("hidden");
            $(".img").click(function(e){
                if (!$(this).hasClass("hover")) {
                    $(this).addClass("hover");
                }
            });
            $(".close-overlay").click(function(e){
                e.preventDefault();
                e.stopPropagation();
                if ($(this).closest(".img").hasClass("hover")) {
                    $(this).closest(".img").removeClass("hover");
                }
            });
        } else {
            $(".img").mouseenter(function(){
                $(this).addClass("hover");
				$('.overlay').fadeIn();
            })
            .mouseleave(function(){
                $(this).removeClass("hover");
            });
        }*/
		
		$('#mapdiv').css('height','0px');
		$('.map1').css('height','0px');
		$('.step_map').css('height','0px');
 });

 
var beaches = [<?php echo ((isset($skill_arr) && $skill_arr!='')?$skill_arr:'');?>];
var map ='';
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
    zoom: 12,
    center: new google.maps.LatLng(latitude_city , longitude_city),
	styles:noPoi,
	zoomControl:true
 }
 map = new google.maps.Map(document.getElementById('map'),
                                mapOptions);

 setMarkers(map, beaches);

}

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

  /*var shape = {
      coord: [1, 1, 1, 20, 18, 20, 18 , 1],
      type: 'poly'
  };*/

 

  for (var i = 0; i < locations.length; i++) {
    var beach = locations[i];
    var myLatLng = new google.maps.LatLng(beach[1], beach[2]);
    marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        icon: image,
        title: beach[0],
        zIndex: beach[3],
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

	google.maps.event.addListener(map, 'click', (function(marker, i) {
	  return function() {
	    infoWindow.close();
	  }
    })(marker, i));

	google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
		 
		  infoWindow.setContent(infoWindowContent[i][0]);
		  infoWindow.open(map, marker);
		  	       
		   /*var slideCount = $('#slider_map ul li').length;
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
			});*/
        }
    })(marker, i));
  }
}

google.maps.event.addDomListener(window, 'load', initialize);



function show_filter()
{
  if($('#sortfilterdiv').css('display') == 'none')
  {
	 $("#sortfilterdiv").slideToggle('slow');
	 $('.shwfltrimg').attr('src','<?php echo $this->webroot;?>img/show_filter.png');
  }
  else if($('#sortfilterdiv').css('display') == 'block')
  {
	 $("#sortfilterdiv").slideToggle('slow');
	 $('.shwfltrimg').attr('src','<?php echo $this->webroot;?>img/show_filter_down.png');
  }
}

function show_result()
{
   $('#vewmrkrs').html('<p onclick="show_map()"><span><img src="<?php echo $this->webroot;?>img/view_makers.png" alt=""></span>View makers in map</p>');
   $('#mapdiv').css('height','0px');
   $('.map1').css('height','0px');
   $('.step_map').css('height','0px');
   $('#mapdiv').css('visibility','hidden');
   $('.show_filter').show();
   $('#resdiv').show();
}

function show_map()
{
   $('#vewmrkrs').html('<p onclick="show_result()"><span><img src="<?php echo $this->webroot;?>img/list_icon.png" alt=""></span>List view</p>');
   $('#resdiv').hide();
   $('#mapdiv').css('height','853px');
   $('.map1').css('height','853px');
   $('.step_map').css('height','853px');
   $('.show_filter').hide();
   $('#mapdiv').css('visibility','visible');
   
   google.maps.event.trigger(map, 'resize');
   map.setCenter(new google.maps.LatLng(latitude_city , longitude_city))
}

function getsortval(val)
{
    var amt1=$("#amount1").html();
	var amt=$("#amount").html();
	var timeval=$('#timerange').val();
	if(timeval=='')
	{
	   timeval='empty';
	}
	else
	{
	   timeval=timeval;
	}
   
	$.post('<?php echo($this->webroot);?>users/mapframe1/'+search_text+'/'+amt1+'/'+amt+'/'+location_text+'/'+timeval+'/'+val, function(data){
		if(data!=''){
			$('#imagecontent').load('<?php echo($this->webroot);?>users/mapframe/'+search_text+'/'+amt1+'/'+amt+'/'+location_text+'/'+timeval+'/'+val);
		} else {
			
		}
	});
}

function make_fav(skill_id,e)
{
	 $.post( '<?php echo($this->webroot)?>users/make_wishlist/'+skill_id, function( data ) {
	   $('#wishlisticon'+skill_id).html('');
	   $('#wishlisticon'+skill_id).html(data);
	   $('#mapwishlisticon'+skill_id).html('');
	   $('#mapwishlisticon'+skill_id).html(data);
	 });
	  if (!e) var e = window.event;
       e.cancelBubble = true;
      if (e.stopPropagation) e.stopPropagation();
}
function make_fav_map(skill_id,e)
{
	 $.post( '<?php echo($this->webroot)?>users/make_wishlist/'+skill_id, function( data ) {
	   $('#mapwishlisticon'+skill_id).html('');
	   $('#mapwishlisticon'+skill_id).html(data);
	   $('#wishlisticon'+skill_id).html('');
	   $('#wishlisticon'+skill_id).html(data);
	 });
	  if (!e) var e = window.event;
       e.cancelBubble = true;
      if (e.stopPropagation) e.stopPropagation();
}

function myClick(skill_id,e)
{
  window.location.href='<?php echo($this->webroot)?>skills/details/'+skill_id;
    if (!e) var e = window.event;
    e.cancelBubble = true;
    if (e.stopPropagation) e.stopPropagation();
}

<?php echo $this->Html->scriptEnd();?>
