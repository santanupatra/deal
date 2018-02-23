<?php ?>
<style type="text/css">
.error{
color:red;
}

</style>
<script type="text/javascript">
$(document).ready(function() {
		$("#signup").validate();
});

function chkEmailexists(email) {
	$.post('<?php echo($this->webroot);?>users/emailExists/'+email, function(data){
		if(data!=''){
			$("#emailErr").html(data);
		} else {
			$("#emailErr").html(data);
		}
	});
}

/*window.onload = function () {
    document.getElementById("UserPassword").onchange = validatePassword;
    document.getElementById("UserConPassword").onchange = validatePassword;
}*/
function validatePassword(){
var pass2=document.getElementById("UserConPassword").value;
var pass1=document.getElementById("UserPassword").value;
if(pass1!=pass2)
    document.getElementById("UserConPassword").setCustomValidity("Passwords Don't Match");
else
    document.getElementById("UserConPassword").setCustomValidity('');  
//empty string means no validation error
}

</script>

<script type="text/javascript">



function onclicksignup(){
	var j=1;
	var email=$('#email').val();
	if($('#firstName').val()=='')
	{
		$('#firstNameErr').html('Please give your first name.');
		j=0;
	}
	else if($('#lastName').val()=='')
	{
		$('#lastNameErr').html('Please give your last name.');
		j=0;
	}
	else if(email=='')
	{
		$('#emailErr').html('Please give your Email.');
		j=0;
	}
	else if($('#UserPassword').val()=='')
	{
		$('#UserPasswordErr').html('Please give password.');
		j=0;
	}
	else if($('#UserConPassword').val()=='')
	{
		$('#UserConPasswordErr').html('Please retype Password.');
		j=0;
	}
	else if($('#UserConPassword').val()!=$('#UserPassword').val())
	{
		$('#UserConPasswordErr').html('Password and confirm password not matched.');
		j=0;
	}
	else if(!jQuery("#ackTermsAndConditions").is(":checked"))
	{
		$('#ackTermsAndConditionsErr').html('Please Check this box.');
		j=0;
	}
	else { $( "#signup").submit(); }

	/*data-toggle="modal" data-target="#signup-step3-modal" data-dismiss="modal" */
}






</script>
<script type="text/javascript">
	$.ajaxSetup({ cache: true });
 $.getScript('//connect.facebook.net/en_US/all.js', function(){
  FB.init({ appId: '923818997662795'});    
  $(".flogin").on("click", function(e){
   e.preventDefault();    
   FB.login(function(response){
    // FB Login Failed //
    if(!response || response.status !== 'connected') {
     //alert("Given account information are not authorised", "Facebook says");
    }else{
     // FB Login Successfull //
     FB.api('/me', function(fbdata){      
      console.log(fbdata); //
      var fb_user_id = fbdata.id;      
      var fb_first_name = fbdata.first_name;
      var fb_last_name = fbdata.last_name;
      var fb_email = fbdata.email;
      var fb_username = fbdata.username;
      
      $.post('<?php echo($this->webroot);?>users/autoLogin/'+fb_user_id, function(data){
                           
        data = data.split('@@@@');
        if(data[0]=='Register'){
                                    
									$('#firstName').val(fb_first_name);
								   $('#lastName').val(fb_last_name);
								   $('#email').val(fb_email);
								   //$('#signup-step2-modal').show('slow');
								   //$('#facebook_dispaly').css('display','block');
								   $('#signup-step2-modal').modal('show'); 
         //$('#socialpassword').val('asd@123');
                                   // document.socialloginform.action='<?php echo($this->webroot)?>users/autosignup/'+fb_user_id+'/'+fb_first_name+'/'+fb_last_name;
        // document.socialloginform.submit();
                                    
         } else if(data[0]=='Login'){
          $('#socialemail').val(fb_email);
		  $('.avatar').html('Already have Signed up with the facebook account');
		  //$('#signup-step-modal').show('slow');
		  $('#signup-step-modal').modal('show');

         
        }
      });
      
     })
    }
   }, {scope:"email"});
    })
 });
</script>	
<div class="container">
    	<div class="row">
        <div class="col-md-5 f-none">
        <div class="signuparea">
        	<div class="signin_box">
            	<h1>Sign up</h1>
                <div class="formBox">
                	<form name="signup" id="signup" method="post" action="<?php echo $this->webroot.'users/signup';?>">
                	<ul>
                    	<li>
                    		<input type="text" placeholder="First name" required class="" id="firstName" name="data[User][first_name]"  pattern="^[a-zA-Z][a-zA-Z .\-']{2,150}" onfocus="$('#firstNameErr').html('');">
                    	</li>
                        <li>
                        		<input type="text" placeholder="Last name" class="" id="lastName" required name="data[User][last_name]" pattern="^[a-zA-Z][a-zA-Z .\-']{2,150}" onfocus="$('#lastNameErr').html('');">
                        </li>
                        <li>
                        		<input type="email" placeholder="Email" id="email" name="data[User][email]" required placeholder="" maxlength="150" data-email-tld="check" class="" onkeyup="chkEmailexists(this.value)" onblur="chkEmailexists(this.value)" onfocus="$('#emailErr').html('');">
			   		<div id="emailErr" class="error"></div>
                        </li>
                        <li>
                        		<input type="number" placeholder="Phone number" name="data[User][mobile_number]" id="mobile_number" required="required" class=""/>
                        </li>
                        <li>
                        		<input type="password" placeholder="Password" name="data[User][password]" id="UserPassword" required="required" class=""/>
                        </li>
                        <li>
                        		<input type="password" class="" name="data[User][conpassword]" id="UserConPassword" required="required"  placeholder="Confirm Password"/>
                        </li>
                        <li><input type="submit" class="sign_btn" value="SIGN UP"></li>
                        <li><p>Already a member? <a href="<?php echo $this->webroot?>users/login">Sign In</a></p></li>
                    </ul>
                    </form>
                </div>
            </div>
          </div>
          </div>
        </div>
    </div>
 


		

