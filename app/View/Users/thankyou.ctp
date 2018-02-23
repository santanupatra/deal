 <div class="clearfix"></div>
    <div class="banner">
    	<div class="container">
<div style="margin:0px auto;padding-top:15px;padding-bottom:15px;">
<center>
<img src="<?php echo($this->webroot)?>images/loading.gif" style="width:50px;height:50px;"/>
</center>
</div>
   	<form method="post" action="<?php echo($this->webroot)?>users/socsignup" id="socialloginform" name="socialloginform">
			<input type="hidden" name="data[User][email]" id="socialemail" value='<?php if(isset($email) && $email!=''){ echo $email;} ?>'/>
			<input type="hidden" name="data[User][password]" id="socialpassword" value='asd@123'/>
			<div class="clearfix"></div>
		</form>
    	</div>
    </div>
  <div class="clearfix"></div>
<script src="<?=$this->webroot?>js/jquery-1.8.3.js" ></script>
<script>
jQuery(document).ready(function(){
 document.getElementById('socialloginform').action='<?php echo($this->webroot)?>users/autosignuplogin/';
document.getElementById('socialloginform').submit();
});
</script>
	