<?php 
$sessionid = $this->Session->read('Auth.User.id');
//echo 'userid==='.$_SESSION['chatid'];
//$_SESSION['fname'] = $this->Session->read('Auth.User.first_name');

?>	

 <!--modal-->
 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="width:450px;">
      <div class="modal-content">
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal" style="float:right;">&times;</button>
          <h3 class="modal-title">Upload image </h3>
        </div>
		<form class="form-horizontal custom_horizontal" action="<?php echo $this->webroot; ?>posts/upload_profile_image_tmp" method="post" enctype="multipart/form-data" id="profile_post">
        <div class="modal-body">	      
	      <table>		    
		    <tr>
				
				<input type="hidden" name="data[User][id]" id="UserId" value="<?php echo $this->Session->read('Auth.User.id'); ?>"/>
									<input type="hidden" name="data[User][hid_img]" id="hid_img" value="57a4308763d7e.jpg"/>

<div class="form-group">
			                        	<label class="col-sm-4 control-label" for="inputEmail3"></label>
                                        <div class="col-sm-8" style="padding-top:10px;">
			                                <input type="button" name="img" id="img" class=" btn btn-default" value="Select Image" style="height:100px;width:100%;margin-left: -67px;"/>
                                            
			                            </div>
			                            <div class="col-sm-8" style="display:none;">
			                                <input type="file" name="data[User][image]" id="UserProfileImg" class="form-control" style="height: auto"/></div>
                                            <!---->
                                            <input type="hidden" name="hdn-profile-id" id="hdn-profile-id" value="1" />
						<input type="hidden" name="hdn-x1-axis" id="hdn-x1-axis1" value="" />
						<input type="hidden" name="hdn-y1-axis" id="hdn-y1-axis1" value="" />
						<input type="hidden" name="hdn-x2-axis" value="" id="hdn-x2-axi1s" />
						<input type="hidden" name="hdn-y2-axis" value="" id="hdn-y2-axis1" />
						<input type="hidden" name="hdn-thumb-width" id="hdn-thumb-width1" value="" />
						<input type="hidden" name="hdn-thumb-height" id="hdn-thumb-height1" value="" />
						<input type="hidden" name="action" value="" id="action" />
						<input type="hidden" name="image_name" value="" id="image_names" />
						
						<div id='preview-avatar-profiles'>
					</div>
					<div id="thumbs" style="padding:5px; width:50%"></div>
                    
                                            <!---->
                                            
			                           
                                        
                                        
			                       		  
			           
				<!--<td><input type="file" name="data[User][image]" id="UserProfileImg" class="form-control" style="height: auto"/></td>-->
		    </tr>
			<!--<tr><td colspan="2" style="height:10px;"></td></tr>-->
			

		    <!--<tr><td colspan="2" style="height: 5px;" id='loader'></td></tr>-->
		    <!--<tr><td colspan="2" style="height: 5px;"><input type="submit" class="btn btn-primary" value="SAVE" id="prop_upl"></td></tr>-->   
		    
		</table>
		<div class="modal-footer" style="padding-top:23px;border-top: 0 !important;">
	                <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
	                <button type="button" id="btn-crops-p" class="btn btn-primary">Crop & Save</button>
                     </div>
	    </form>		    
        </div>
        
      </div>
    </div>
  </div> 
  
			<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-7 col-sm-7">
					<ul class="footer_menu">
						<li><a href="<?php if($this->Session->read('Auth.User.id')){echo $this->webroot.'Users/timeline';}else{echo $this->webroot;}?>">Home</a></li>
                        <?php 
                       
                        foreach($all_contents as $content){ ?>
                        <li><a href="<?php echo $this->webroot; ?>contents/cms/<?php echo $content['Content']['slug']; ?>"><?php echo $content['Content']['page_name'];?></a></li>
                        <?php } ?>
						
					</ul>
				</div>
				<div class="col-md-5 col-sm-5">
					<p class="copyright"><span>Designed & Developed by: <a href="http://www.natitsolved.com/" target="_blank">NAT IT SOLVED PVT. LTD</a></span><?php echo date("Y");?> . All Rights Reserved</p>
				</div>
			</div>
		</div>
	</footer>
	<?php if($sessionid){?>
<div class="chat_box">
	<div class="chat_head up_chk" data-id="1"> <div class="col-md-10 col-sm-5">Chat Box</div><div align="right" id="chat_icon_up"><i class="fa fa-chevron-up" aria-hidden="true"></i></div></div>
    <div class="chat_head up_chk1" data-id="1" style="display:none;"> <div class="col-md-10 col-sm-5">Chat Box</div><div align="right" id="chat_icon_down" ><i class="fa fa-chevron-down" aria-hidden="true"></i></div></div>
	<div class="chat_body" style="display:none;"> 
    <?php foreach($login_friends as $logf){?>
   <a href="javascript: select_friend_foot(<?php echo $logf['U']['id'];?>)"> <div class="user" data-id=<?php echo $logf['U']['id'];?>> <?php if($logf['U']['is_loged']==1){?> <span class="on_line on_<?php echo $logf['U']['id'];?>" ><i class="fa fa-circle" aria-hidden="true"></i></span><?php }else{ ?><span class="off_line off_<?php echo $logf['U']['id'];?>"><i class="fa fa-circle" aria-hidden="true"></i></span><?php } ?><label style="margin-left: 17px;"><?php echo $logf['U']['first_name'].' '.$logf['U']['last_name'];?></label></div></a>
    <?php } ?>
	</div>
  </div>
  <?php } ?>
<div class="msg_box" style="right:290px;display:none;">
	<div class="msg_head"><span id="chat_name">Krishna Teja</span>
	<div class="close">x</div>
	</div>
	<div class="msg_wrap">
		<div class="msg_body">
			<!--<div class="msg_a">This is from A	</div>
			<div class="msg_b">This is from B, and its amazingly kool nah... i know it even i liked it :)</div>
			<div class="msg_a">Wow, Thats great to hear from you man </div>	
			<div class="msg_push"></div>-->
		</div>  
        <input type="hidden" id="last_message_id_foot" value="">                     
         <input type="hidden" name="friend_id" value="54" id="friend_id" />
	<div class="msg_footer"><textarea class="msg_input" rows="1"></textarea></div>
</div>
</div>
  </body>




	<script type="text/javascript">
		$(document).ready(function(){
			$('.bxslider').bxSlider({
				auto: true,
				autoControls: true
			});
			$('body').on('click','#img',function(){
			$('#UserProfileImg').click();
			});
			
//
		});
	</script>
	
	<script type="text/javascript">
		  $(document).ready(function(){
			$('#toggle-menu').click(function() {
			$('.menu-area').slideToggle('fast');
			return false;
		});
		});
	</script>
<script type="text/javascript">
		jQuery(document).ready(function(){
		
		
		jQuery('#UserProfileImg').on('change', function()   
		{
		   $('#img').hide();
			jQuery("#preview-avatar-profiles").html('');
			jQuery("#preview-avatar-profiles").html('Uploading....');
			jQuery("#profile_post").ajaxForm(
			{
			target: '#preview-avatar-profiles',
			success:    function() { 
					jQuery('img#photos').imgAreaSelect({
					//handles: true,
					aspectRatio: '1:1',
					onSelectEnd: getSizes,
				});
				jQuery('#image_names').val(jQuery('#photos').attr('file-name'));
				
				}
			}).submit();

		});
		
		jQuery('#btn-crops-p').on('click', function(e){//alert();
	    e.preventDefault();
	    params = {
	            targetUrl: '<?php echo $this->webroot?>posts/upload_profile_image',
	            action: 'save',
	            x_axis: jQuery('#hdn-x1-axis1').val(),
	            y_axis : jQuery('#hdn-y1-axis1').val(),
	            x2_axis: jQuery('#hdn-x2-axis1').val(),
	            y2_axis : jQuery('#hdn-y2-axis1').val(),
	            thumb_width : jQuery('#hdn-thumb-width1').val(),
	            thumb_height:jQuery('#hdn-thumb-height1').val()
	        };

	        saveCropImage(params);
	    });
	    
	 
	    
	    function getSizes(img, obj)
	    {
	        var x_axis = obj.x1;
	        var x2_axis = obj.x2;
	        var y_axis = obj.y1;
	        var y2_axis = obj.y2;
	        var thumb_width = obj.width;
	        var thumb_height = obj.height;
	        if(thumb_width > 0)
	            {

	                jQuery('#hdn-x1-axis1').val(x_axis);
	                jQuery('#hdn-y1-axis1').val(y_axis);
	                jQuery('#hdn-x2-axis1').val(x2_axis);
	                jQuery('#hdn-y2-axis1').val(y2_axis);
	                jQuery('#hdn-thumb-width1').val(thumb_width);
	                jQuery('#hdn-thumb-height1').val(thumb_height);
	                
	            }
	        else
	            alert("Please select portion..!");
	    }
	    
	    function saveCropImage(params) {
	    jQuery.ajax({
	        url: params['targetUrl'],
	        cache: false,
	        dataType: "html",
	        data: {
	            action: params['action'],
	            id: jQuery('#hdn-profile-id').val(),
	             t: 'ajax',
	                                w1:params['thumb_width'],
	                                x1:params['x_axis'],
	                                h1:params['thumb_height'],
	                                y1:params['y_axis'],
	                                x2:params['x2_axis'],
	                                y2:params['y2_axis'],
									image_name :jQuery('#image_names').val()
	        },
	        type: 'Post',
	       // async:false,
	        success: function (response) {
	                jQuery('#changePic').hide();
					jQuery('#change-pic').show();
	                jQuery(".imgareaselect-border1,.imgareaselect-border2,.imgareaselect-border3,.imgareaselect-border4,.imgareaselect-border2,.imgareaselect-outer").css('display', 'none');
	                $('.close').click();
					location.reload();
	         jQuery("#avatar-edit-imgs").attr('src', response);
	                jQuery("#preview-avatar-profiles").html('');
	                jQuery("#UserProfileImg").val('');       
	        },
	        error: function (xhr, ajaxOptions, thrownError) {
	            alert('status Code:' + xhr.status + 'Error Message :' + thrownError);
	        }
	    });
	    }
		});
	</script>
    <script>
	$(document).ready(function() 
{
 $.ajaxSetup({ cache: false }); 
 setInterval(update_logtime,300000);  // log time update
});

function update_logtime()    // log time update function 
{
 var id = <?php echo $this->Session->read('Auth.User.id'); ?>;
 //alert(id);
 $.ajax({
 type: 'post',
 dataType: 'json',
 url: '<?php echo $this->webroot ; ?>Posts/logtime_update',
 data: {
  id:id
 },
 success: function (response) {
 
 }
 });
}
</script>
<script>
	$(document).ready(function() 
{
 $.ajaxSetup({ cache: false }); 
 setInterval(log_status,50000);  // log status update
});

function log_status()    // log status update function 
{
 var id = <?php echo $this->Session->read('Auth.User.id'); ?>;
 //alert(id);
 $.ajax({
 type: 'post',
 dataType: 'json',
 url: '<?php echo $this->webroot ; ?>Posts/logstatus_update',
 data: {
  id:id
 },
 success: function (response) { 
  $.each(response, function(index, element) {
   //alert(index);
      if(element==1)
	  {
	     //alert('.on_'+index);
		 $('.off_'+index).addClass("on_line");
		 $('.off_'+index).removeClass("off_line");
	     
	  
	  }
	  else
	  { //alert('.off_'+index);
	   $('.on_'+index).addClass("off_line");
	  $('.on_'+index).removeClass("on_line");
	 
	  }
        
        });
 }
 });
}
</script>
<link href="<?php echo $this->webroot ; ?>css/style.css" rel="stylesheet">
<!--<script src="<?php echo $this->webroot ; ?>js/script.js"></script>-->
 <script>
 $(document).ready(function(){
<?php if($this->Session->read('Auth.User.id')){?>
	$('.up_chk').click(function(){
		$('.chat_body').slideToggle('slow');
		$('.up_chk').hide();
		$('.up_chk1').show();
	});
	$('.up_chk1').click(function(){
		$('.chat_body').slideToggle('slow');
		$('.up_chk1').hide();
		$('.up_chk').show();
		
	});
	/*$('.msg_head').click(function(){
		$('.msg_wrap').slideToggle('slow');
	});*/
	
	$('.close').click(function(){
		$('.msg_box').hide();
	});
	
	$('.user').click(function(){

		$('.msg_wrap').show();
		$('.msg_box').show();
	});
	<?php } ?>
	$('.msg_input').keypress(
    function(e){
        if (e.keyCode == 13) {
            e.preventDefault();
            var message_text = $(this).val();
			var friend_id = $('#friend_id').val();
			$(this).val('');
			if(message_text!='')
			{
			$.ajax({
					type: 'POST',
					url: '<?php echo Router::url(array('controller' => 'messages', 'action' =>'insert_message_footer'), true); ?>',
					data: {friend_id:friend_id, message_text:message_text},
					cache: false,
					dataType: 'HTML',				
					success: function (data){
						var data_arr = data.split("||");
						$('#last_message_id_foot').val(data_arr[0]);			
						/*$('#msg_body').append(data_arr[1]);	*/	
						$('<div class="msg_a">'+data_arr[1]+'</div>').insertBefore('.msg_push');
						$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);										
					}
				});
			/*$('<div class="msg_a">'+message_text+'</div>').insertBefore('.msg_push');*/
			}
			
        }
    });
	setInterval(function(){ latest_message_footer(); }, 10000);
		
});
	function select_friend_foot(friend_id){
			$('#friend_id').val(friend_id);
			$.ajax({
					type: 'POST',
					url: '<?php echo Router::url(array('controller' => 'messages', 'action' =>'footer_user_message'), true); ?>',
					data: {friend_id:friend_id},
					cache: false,
					dataType: 'HTML',				
					success: function (data){
						var data_arr = data.split("||");
						$('#last_message_id_foot').val(data_arr[0]);			
						$('#chat_name').html(data_arr[1]);
						$('.msg_body').html(data_arr[2]);
						$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
					}
				});
		}
		
	function latest_message_footer(){
		var last_message_id = $('#last_message_id_foot').val();
		//alert(last_message_id);
		var friend_id = $('#friend_id').val();
		//alert (friend_id);
		$.ajax({
				type: 'POST',
				url: '<?php echo Router::url(array('controller' => 'messages', 'action' =>'latestMessage_footer'), true); ?>',
				data: {last_message_id:last_message_id, friend_id:friend_id},
				cache: false,
				dataType: 'HTML',				
				success: function (data){
					var data_arr = data.split("||");
					if(data_arr[1] != ""){
						$('#last_message_id_foot').val(data_arr[0]);				
						$('.msg_body').append(data_arr[1]);
						<!--$('<div class="msg_a">'+data_arr[1]+'</div>').insertBefore('.msg_push');-->
						$('.msg_body').scrollTop($('.msg_body')[0].scrollHeight);
					}
				}
			});
	}
 </script>
</html>