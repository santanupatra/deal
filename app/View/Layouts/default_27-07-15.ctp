<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'Spanation');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>

	<meta charset="utf-8">
	<meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<link href="<?php echo $this->webroot; ?>css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo $this->webroot; ?>css/style.css" rel="stylesheet">
        <link href="<?php echo $this->webroot; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>
<body>
    <header>
    	<div class="container">
        	<div class="row">
            	<nav class="navbar">
  		  <div class="container-fluid">
                    <div class="navbar-header">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      <a class="navbar-brand logo" href="<?php echo $SITE_URL; ?>"><?php if(isset($sitesetting['SiteSetting']['site_logo']) && $sitesetting['SiteSetting']['site_logo']!=''){ ?><img src="<?php echo $this->webroot; ?>site_logo/<?php echo $sitesetting['SiteSetting']['site_logo'];?>" class="img-responsive"><?php }else{ ?><img src="<?php echo $this->webroot; ?>images/logo.png" class="img-responsive"><?php } ?></a>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">                      
                      <ul class="nav navbar-nav navbar-right">
                      	<!--<li class="dropdown location_drop">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Locations <span class="caret"></span></a>
                          <ul class="dropdown-menu">
                            <li><a href="#">Locations</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Locations</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Locations</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Locations</a></li>
                          </ul>
                        </li>-->
                        <?php if(isset($userid) && $userid!=''){ ?>
                         <li><a href="<?php echo $SITE_URL; ?>users/dashboard">Welcome <?php echo $userdetails['User']['username']; ?></a></li>
                         <li><a href="<?php echo $SITE_URL; ?>users/logout">View Plans</a></li>
                        <?php }else{ ?>
                         <li><a href="#">Live Chat</a></li>
                         <li><a href="#">About Us</a></li>
                         <li><a href="<?php echo $SITE_URL; ?>users/signin">Log In</a></li>
                         <li><a href="<?php echo $SITE_URL; ?>users/post-ad">Post Ad</a></li>
                        <?php } ?>
                      </ul>
                    </div>
                  </div>
		</nav>
            </div>
        </div>
    </header>
    <?php echo '<center>'.$this->Session->flash().'</center>'; ?> 
    <?php echo $this->fetch('content');?>
    <section class="footer_top foot_top">
    	<div class="container">
        	<div class="row">
            	<div class="col-sm-3">
                	<div class="fttop_title">
                  	<p>spanation.ca</p>
                  </div>
                  <ul class="lower-footer-content">
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Terms of Use</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Posting Policy</a></li>
                  </ul>
                </div>
                <div class="col-sm-3">
                	<div class="fttop_title">
                  	<p>HELP DESK</p>
                  </div>
                  <ul class="lower-footer-content">
                    <li><a href="#">Live Chat</a></li>
                    <li><a href="#">FAQ</a></li>
                  </ul>
                </div>
                <div class="col-sm-3">
                	<div class="fttop_title">
                  	<p>FOR CUSTOMERS</p>
                  </div>
                  <ul class="lower-footer-content">
                    <li><a href="#">Spa Locations</a></li>
                    <li><a href="#">On-site Service</a></li>
                  </ul>
                </div>
                <div class="col-sm-3">
                	<div class="fttop_title">
                  	<p>GET FEATURED</p>
                  </div>

                  <ul class="lower-footer-content">
                    <li><a href="#">View Plans</a></li>
                    <li>
                    <?php if(isset($userid) && $userid!=''){ ?>
                     <a href="<?php echo $SITE_URL; ?>users/logout">Logout</a>
                    <?php }else{ ?>
                     <a href="<?php echo $SITE_URL; ?>users/signin">Log In</a> 
                    <?php } ?> 
                     <a href="<?php echo $SITE_URL; ?>users/post-ad">&nbsp;&nbsp;|&nbsp;&nbsp;Post Ad</a></li>
                  </ul>
                </div>
            </div>
        </div>
    </section>
    <footer>
    	<div class="container">
        	<div class="copy">Copyright © 2015 spanation.ca</div>
        </div>
    </footer>
    
    <script src="<?php echo $this->webroot; ?>js/jquery.js"></script>
    <script src="<?php echo $this->webroot; ?>js/bootstrap.min.js"></script>
    <script>
      $(document).ready(function(){       
           setTimeout(function() {
	        $('.message').fadeOut('slow');
	        $('.success').fadeOut('slow');
           }, 3000);
      });
      function open_forgotpassword()
      {
        $('#forgotpassworddiv').slideToggle('slow');
      }
      function validate_signup()
      {
        var first_name=$('#first_name').val();
        var last_name=$('#last_name').val();
        var email=$('#email').val();
        var password=$('#password').val();
        var repassword=$('#repassword').val();
        if(first_name=='')
        {
          $('#first_name').css('border','1px solid #e50516');
        }
        else
        {
          $('#first_name').css('border','1px solid #ccc');
        }
        if(last_name=='')
        {
          $('#last_name').css('border','1px solid #e50516');
        }
        else
        {
          $('#last_name').css('border','1px solid #ccc');
        }
        if(email=='')
        {
          $('#email').css('border','1px solid #e50516');
        }
        else
        {
          $('#email').css('border','1px solid #ccc');
        }
        if(password=='')
        {
          $('#password').css('border','1px solid #e50516');
        }
        else
        {
          $('#password').css('border','1px solid #ccc');
        }
        if(repassword=='')
        {
          $('#repassword').css('border','1px solid #e50516');
        }
        else
        {
          $('#repassword').css('border','1px solid #ccc');
        }
        if(first_name=='' || last_name=='' || email=='' || password=='' || repassword=='')
        {
          $('#validation_err_msg').html('<font style="color:#e50516">Please enter below required fields</font>');
          return false;
        }
        else
        {
           var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
           if (filter.test(email)) 
	   {
	     $('#email').css('border','1px solid #ccc');
	     $('#password').css('border','1px solid #ccc');
	     $('#repassword').css('border','1px solid #ccc');
	     if(password != repassword)
	     {
	       $('#password').css('border','1px solid #e50516');
	       $('#repassword').css('border','1px solid #e50516');
	       $('#validation_err_msg').html('<font style="color:#e50516">Password mismatch</font>');
               return false;
	     }
	     else
	     {
	       $('#validation_err_msg').html('');
	       return true;
	     }
	   }
	   else
	   {
	     $('#email').css('border','1px solid #e50516');
	     $('#validation_err_msg').html('<font style="color:#e50516">Please enter valid email</font>');
             return false;
	   }
        }
      }
      function validate_forgotpassword()
      {
        var forgotemail=$('#forgotemail').val();
        if(forgotemail=='')
        {
          $('#forgotemail').css('border','1px solid #e50516');
          $('#fp_validation_err_msg').html('<font style="color:#e50516">Please enter your email</font>');
          return false;
        }
        else
        {
           $('#forgotemail').css('border','1px solid #ccc');
           var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
           if (filter.test(forgotemail)) 
	   {
	     $('#fp_validation_err_msg').html('');
	     return true;
	   }
	   else
	   {
	     $('#forgotemail').css('border','1px solid #e50516');
	     $('#fp_validation_err_msg').html('<font style="color:#e50516">Please enter valid email</font>');
             return false;
	   }
        }
      }
      function validate_signin()
      {
        var loginemail=$('#loginemail').val();
        var loginpassword=$('#loginpassword').val();
        if(loginemail=='')
        {
          $('#loginemail').css('border','1px solid #e50516');
        }
        else
        {
          $('#loginemail').css('border','1px solid #ccc');
        }
        if(loginpassword=='')
        {
          $('#loginpassword').css('border','1px solid #e50516');
        }
        else
        {
          $('#loginpassword').css('border','1px solid #ccc');
        }
        if(loginemail=='' || loginpassword=='')
        {
          $('#login_validation_err_msg').html('<font style="color:#e50516">Please enter your login details</font>');
          return false;
        }
        else
        {
           $('#loginemail').css('border','1px solid #ccc');
           var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
           if (filter.test(loginemail)) 
	   {
	     $('#login_validation_err_msg').html('');
	     return true;
	   }
	   else
	   {
	     $('#loginemail').css('border','1px solid #e50516');
	     $('#login_validation_err_msg').html('<font style="color:#e50516">Please enter valid email</font>');
             return false;
	   }
        }
      }
      function validate_editprofile()
      {
        var first_name=$('#first_name').val();
        var last_name=$('#last_name').val();
        var email=$('#email').val();
        var paypal_business_email=$('#paypal_business_email').val();
        if(first_name=='')
        {
          $('#first_name').css('border','1px solid #e50516');
        }
        else
        {
          $('#first_name').css('border','1px solid #ccc');
        }
        if(last_name=='')
        {
          $('#last_name').css('border','1px solid #e50516');
        }
        else
        {
          $('#last_name').css('border','1px solid #ccc');
        }
        if(email=='')
        {
          $('#email').css('border','1px solid #e50516');
        }
        else
        {
          $('#email').css('border','1px solid #ccc');
        }
        if(first_name=='' || last_name=='' || email=='')
        {
          $('#ep_validation_err_msg').html('<font style="color:#e50516">Please enter below required fields</font>');
          return false;
        }
        else
        {
           var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
           if (filter.test(email)) 
	   {
	     $('#email').css('border','1px solid #ccc');
	     if(paypal_business_email!='')
	     {
	       if (filter.test(paypal_business_email)) 
	       {
	         $('#paypal_business_email').css('border','1px solid #ccc');
	         $('#ep_validation_err_msg').html('');
	         return true;
	       }
	       else
	       {
	         $('#paypal_business_email').css('border','1px solid #e50516');
	         $('#ep_validation_err_msg').html('<font style="color:#e50516">Please enter valid paypal email</font>');
                 return false;
	       }
	     }
	     else
	     {
	       $('#ep_validation_err_msg').html('');
	       return true;
	     }
	   }
	   else
	   {
	     $('#email').css('border','1px solid #e50516');
	     $('#ep_validation_err_msg').html('<font style="color:#e50516">Please enter valid email</font>');
             return false;
	   }
        }
      }
      function validate_changepassword()
      {
        var curr_pass=$('#curr_pass').val();
        var new_pass=$('#new_pass').val();
        var con_pass=$('#con_pass').val();
        if(curr_pass=='')
        {
          $('#curr_pass').css('border','1px solid #e50516');
        }
        else
        {
          $('#curr_pass').css('border','1px solid #ccc');
        }
        if(new_pass=='')
        {
          $('#new_pass').css('border','1px solid #e50516');
        }
        else
        {
          $('#new_pass').css('border','1px solid #ccc');
        }
        if(con_pass=='')
        {
          $('#con_pass').css('border','1px solid #e50516');
        }
        else
        {
          $('#con_pass').css('border','1px solid #ccc');
        }
        if(curr_pass=='' || new_pass=='' || con_pass=='')
        {
          $('#cp_validation_err_msg').html('<font style="color:#e50516">Please enter below required fields</font>');
          return false;
        }
        else
        {
            if(new_pass != con_pass)
	     {
	       $('#new_pass').css('border','1px solid #e50516');
	       $('#con_pass').css('border','1px solid #e50516');
	       $('#cp_validation_err_msg').html('<font style="color:#e50516">Password mismatch</font>');
               return false;
	     }
	     else
	     {
	       $('#cp_validation_err_msg').html('');
	       return true;
	     }
        }
      }
      
      function topbanner_validate()
      {
         var title=$('#title').val();
         var totalpics=$('#totalpics').val();
         var country=$('#country').val();
         var state=$('#state').val();
         var city=$('#city').val();
         var spa_type=$('#spa_type').val();
         var pamper_type=$('#pamper_type').val();
         var fit_type=$('#fit_type').val();
         var gift_card=$('#gift_card').val();
         if(title=='')
         {
           $('#title').css('border','1px solid #e50516');
         }
         else
         {
          $('#title').css('border','1px solid #ccc');
         }
         if(totalpics=='' || totalpics==0)
         {
           $('#thespaphotos').css('border','1px solid #e50516');
         }
         else
         {
          $('#thespaphotos').css('border','1px solid #ccc');
         }
         if(country=='')
         {
           $('#country').css('border','1px solid #e50516');
         }
         else
         {
          $('#country').css('border','1px solid #ccc');
         }
         if(state=='')
         {
           $('#state').css('border','1px solid #e50516');
         }
         else
         {
          $('#state').css('border','1px solid #ccc');
         }
         if(city=='')
         {
           $('#city').css('border','1px solid #e50516');
         }
         else
         {
          $('#city').css('border','1px solid #ccc');
         }
         if(spa_type=='')
         {
           $('#spa_type').css('border','1px solid #e50516');
         }
         else
         {
          $('#spa_type').css('border','1px solid #ccc');
         }
         if(pamper_type=='')
         {
           $('#pamper_type').css('border','1px solid #e50516');
         }
         else
         {
          $('#pamper_type').css('border','1px solid #ccc');
         }
         if(fit_type=='')
         {
           $('#fit_type').css('border','1px solid #e50516');
         }
         else
         {
          $('#fit_type').css('border','1px solid #ccc');
         }
         if(gift_card=='')
         {
           $('#gift_card').css('border','1px solid #e50516');
         }
         else
         {
          $('#gift_card').css('border','1px solid #ccc');
         }
         if(title=='' || totalpics=='' || totalpics==0 || country=='' || state=='' || city=='' || spa_type=='' || pamper_type=='' || fit_type=='' || gift_card=='')
         {
           $('#tb_validation_err_msg').html('<font style="color:#e50516">Please enter below required fields</font>');
           return false;
         }
         else
         {
           $('#tb_validation_err_msg').html('');
           return true;
         }
      }
      
      function overview_validate()
      {
         var about=$('#about').val();
         var feature=$('#feature').val();
         if(about=='')
         {
           $('#about').css('border','1px solid #e50516');
         }
         else
         {
          $('#about').css('border','1px solid #ccc');
         }
         if(feature=='')
         {
           $('#feature').css('border','1px solid #e50516');
         }
         else
         {
          $('#feature').css('border','1px solid #ccc');
         }
         if(about=='' || feature=='')
         {
           $('#ov_validation_err_msg').html('<font style="color:#e50516">Please enter below required fields</font>');
           return false;
         }
         else
         {
           $('#ov_validation_err_msg').html('');
           return true;
         }
      }
      
      function package_validate()
      {
        var fratured_title=$('#fratured_title').val();
        var fratured_duration=$('#fratured_duration').val();
        var fratured_price=$('#fratured_price').val();
        var fratured_description=$('#fratured_description').val();
        var treatment_title=$('#treatment_title').val();
        var treatment_duration=$('#treatment_duration').val();
        var treatment_price=$('#treatment_price').val();
        var treatment_category=$('#treatment_category').val();
         if(fratured_title=='')
         {
           $('#fratured_title').css('border','1px solid #e50516');
         }
         else
         {
          $('#fratured_title').css('border','1px solid #ccc');
         }
         if(fratured_duration=='')
         {
           $('#fratured_duration').css('border','1px solid #e50516');
         }
         else
         {
          $('#fratured_duration').css('border','1px solid #ccc');
         }
         if(fratured_price=='')
         {
           $('#fratured_price').css('border','1px solid #e50516');
         }
         else
         {
          $('#fratured_price').css('border','1px solid #ccc');
         }
         if(fratured_description=='')
         {
           $('#fratured_description').css('border','1px solid #e50516');
         }
         else
         {
          $('#fratured_description').css('border','1px solid #ccc');
         }
         if(treatment_title=='')
         {
           $('#treatment_title').css('border','1px solid #e50516');
         }
         else
         {
          $('#treatment_title').css('border','1px solid #ccc');
         }
         if(treatment_duration=='')
         {
           $('#treatment_duration').css('border','1px solid #e50516');
         }
         else
         {
          $('#treatment_duration').css('border','1px solid #ccc');
         }
         if(treatment_price=='')
         {
           $('#treatment_price').css('border','1px solid #e50516');
         }
         else
         {
          $('#treatment_price').css('border','1px solid #ccc');
         }
         if(treatment_category=='')
         {
           $('#treatment_category').css('border','1px solid #e50516');
         }
         else
         {
          $('#treatment_category').css('border','1px solid #ccc');
         }
         if(fratured_title=='' || fratured_duration=='' || fratured_price=='' || fratured_description=='' || treatment_title=='' || treatment_duration=='' || treatment_price=='' || treatment_category=='')
         {
           $('#tp_validation_err_msg').html('<font style="color:#e50516">Please enter below required fields</font>');
           $("html, body").animate({ scrollTop: "100px" });
           return false;
         }
         else
         {
           $('#tp_validation_err_msg').html('');
           return true;
         }
      }
      
      function contact_validate()
      {
        var address=$('#address').val();
        var unit=$('#unit').val();
        var buzzer=$('#buzzer').val();
        var city=$('#city').val();
        var state=$('#state').val();
        var zip=$('#zip').val();
        var phone=$('#phone').val();
        var email=$('#email').val();
        var location_type=$('#location_type').val();
        var walkin_welcome=$('#walkin_welcome').val();
        if(address=='')
         {
           $('#address').css('border','1px solid #e50516');
         }
         else
         {
          $('#address').css('border','1px solid #ccc');
         }
         if(unit=='')
         {
           $('#unit').css('border','1px solid #e50516');
         }
         else
         {
          $('#unit').css('border','1px solid #ccc');
         }
         if(buzzer=='')
         {
           $('#buzzer').css('border','1px solid #e50516');
         }
         else
         {
          $('#buzzer').css('border','1px solid #ccc');
         }
         if(city=='')
         {
           $('#city').css('border','1px solid #e50516');
         }
         else
         {
          $('#city').css('border','1px solid #ccc');
         }
         if(state=='')
         {
           $('#state').css('border','1px solid #e50516');
         }
         else
         {
          $('#state').css('border','1px solid #ccc');
         }
         if(zip=='')
         {
           $('#zip').css('border','1px solid #e50516');
         }
         else
         {
          $('#zip').css('border','1px solid #ccc');
         }
         if(phone=='')
         {
           $('#phone').css('border','1px solid #e50516');
         }
         else
         {
          $('#phone').css('border','1px solid #ccc');
         }
         if(email=='')
         {
           $('#email').css('border','1px solid #e50516');
         }
         else
         {
          $('#email').css('border','1px solid #ccc');
         }
         if(location_type=='')
         {
           $('#location_type').css('border','1px solid #e50516');
         }
         else
         {
          $('#location_type').css('border','1px solid #ccc');
         }
         if(walkin_welcome=='')
         {
           $('#walkin_welcome').css('border','1px solid #e50516');
         }
         else
         {
          $('#walkin_welcome').css('border','1px solid #ccc');
         }
         if(address=='' || unit=='' || buzzer=='' || city=='' || state=='' || zip=='' || phone=='' || email=='' || location_type=='' || walkin_welcome=='')
         {
           $('#cn_validation_err_msg').html('<font style="color:#e50516">Please enter below required fields</font>');
           $("html, body").animate({ scrollTop: "100px" });
           return false;
         }
         else
         {
           $('#cn_validation_err_msg').html('');
           return true;
         }
      }
      
      function onsite_contact_validate()
      {
        var city=$('#city').val();
        var state=$('#state').val();
        var phone=$('#phone').val();
        var email=$('#email').val();
        var walkin_welcome=$('#walkin_welcome').val();
        var distance_unit=$('#distance_unit').val();
        var distance=$('#distance').val();
         if(city=='')
         {
           $('#city').css('border','1px solid #e50516');
         }
         else
         {
          $('#city').css('border','1px solid #ccc');
         }
         if(state=='')
         {
           $('#state').css('border','1px solid #e50516');
         }
         else
         {
          $('#state').css('border','1px solid #ccc');
         }
         if(phone=='')
         {
           $('#phone').css('border','1px solid #e50516');
         }
         else
         {
          $('#phone').css('border','1px solid #ccc');
         }
         if(email=='')
         {
           $('#email').css('border','1px solid #e50516');
         }
         else
         {
          $('#email').css('border','1px solid #ccc');
         }
         if(walkin_welcome=='')
         {
           $('#walkin_welcome').css('border','1px solid #e50516');
         }
         else
         {
          $('#walkin_welcome').css('border','1px solid #ccc');
         }
         if(distance_unit=='')
         {
           $('#distance_unit').css('border','1px solid #e50516');
         }
         else
         {
          $('#distance_unit').css('border','1px solid #ccc');
         }
         if(distance=='')
         {
           $('#distance').css('border','1px solid #e50516');
         }
         else
         {
          $('#distance').css('border','1px solid #ccc');
         }
         if(city=='' || state=='' || zip=='' || phone=='' || email=='' || walkin_welcome=='' || distance_unit=='' || distance=='')
         {
           $('#cn_validation_err_msg').html('<font style="color:#e50516">Please enter below required fields</font>');
           $("html, body").animate({ scrollTop: "100px" });
           return false;
         }
         else
         {
           $('#cn_validation_err_msg').html('');
           return true;
         }
      }
      
      function numbercheck(e)
      {
        if((e.which >= 48 && e.which <= 57) || e.which == 46 || e.which ==8)
        {
          return true;
        }
        else
        {
          return false;
        }
      }
      var packagecnt=1;
      var treatmentcnt=1;
      function add_package()
      {
        var packagestr='<b>Package '+packagecnt+':</b><br>';
            packagestr+='Title<br><input class="form-control" type="text" name="data[Spa][package_title][]" style="margin-bottom:10px;">Duration (min)<br><input class="form-control" type="text" name="data[Spa][package_duration][]" style="margin-bottom:10px;" onkeypress="return numbercheck(event);">Price ($)<br><input class="form-control" type="text" name="data[Spa][package_price][]" style="margin-bottom:10px;" onkeypress="return numbercheck(event);">';
         $('#morepackages').append(packagestr);
         packagecnt++;
      }
      
      function add_treatment()
      {
        var treatmentstr='<b>Treatment '+treatmentcnt+':</b><br>';
            treatmentstr+='Category (ie. Massage or Body Treatment or Facial etc.)<br><input class="form-control" type="text" name="data[Spa][treatment_category][]" style="margin-bottom:10px;">Title<br><input class="form-control" type="text" name="data[Spa][treatment_title][]" style="margin-bottom:10px;">Duration (min)<br><input class="form-control" type="text" name="data[Spa][treatment_duration][]" style="margin-bottom:10px;" onkeypress="return numbercheck(event);">Price ($)<br><input class="form-control" type="text" name="data[Spa][treatment_price][]" style="margin-bottom:10px;" onkeypress="return numbercheck(event);">';
         $('#moretreatment').append(treatmentstr);
         treatmentcnt++;
      }
      
      function performClickprofile() {
	$('#theFileprofile').click();
      }
      
     $(document).ready(function(){     
      $("#theFileprofile").change(function(){
	   var src=$("#theFileprofile").val();
	   if(src!="")
	    {
	         formdata= new FormData(); 
	         var numfiles=this.files.length;
	         var i, file, progress, size,pic;
	         for(i=0;i<numfiles;i++)
	         {
		        file = this.files[i];
		        size = this.files[i].size;
		        name = this.files[i].name;
		        if (!!file.type.match(/image.*/))
		        {
		          if((Math.round(size))<=(5*1024*1024))
		          {
			        var reader = new FileReader(); 
			        reader.readAsDataURL(file);
			        reader.onloadend = function(e){
			          var picname = document.getElementById('theFileprofile').value;
			          image = e.target.result;
			          pic = '<img src="'+image+'" class="img-responsive" style="float: none;margin: 0 auto;"/>';
			         };
			        formdata.append("file[]", file);
			        if(i==(numfiles-1))
			        {
				        $('#upload_loading_pic').show();
				        $('#upload_profile_pic').hide();
				        $.ajax({
					    url: "<?php echo $this->webroot;?>users/upload_profile_pic",
					    type: "POST",
					    data: formdata,
					    processData: false,
					    contentType: false,
					    success: function(res)
					    {
					        if(res!="0")
					        {
					          $("#profpic").html(pic);
					          $("#theFileprofile").val('');
					          $('#upload_loading_pic').hide();
				                  $('#upload_profile_pic').show();
					        }
					        else
					         {
					           alert("Error in upload. Retry");
					           $('#upload_loading_pic').hide();
				                   $('#upload_profile_pic').show();
					         }
					     }
				        });
			        }
		         }
		         else
		         {
			        alert(name+" Size limit exceeded");
		          }
		         }
		         else
		         {
			        alert(name+" Not image file");
		         }
	           }
	        }
	        else
	        {
		     alert("Select an image file");
		     return;
	        }
	       return false;
          });
          $("#thespaphotos").change(function(){
		var src=$("#thespaphotos").val();
		if(src!="")
		{
			 formdata= new FormData();
			 var numfiles=this.files.length;
			 var i, file, progress, size;
			 for(i=0;i<numfiles;i++)
			 {  
			     var currtotalpics = document.getElementById('totalpics').value;
		             if(currtotalpics < 10)
		             {
				file = this.files[i];
				size = this.files[i].size;
				name = this.files[i].name;
				if (!!file.type.match(/image.*/))
				{
				  if((Math.round(size))<=(5*1024*1024)) 
				  {
					$("#Preview").show();
					var reader = new FileReader(); 
					reader.readAsDataURL(file); 

					reader.onloadend = function(e){
					  var picname = document.getElementById('thespaphotos').value;
					  var picnum = document.getElementById('picnum').value;
					  var picnumssn = document.getElementById('picnumssn').value;
					  if(picnum==0){
						picnum = 1;
						totalpics = 1;
					  } else {
						picnum = parseInt(picnum) + 1;
					 	totalpics = parseInt(totalpics) + 1;
					  }
					  if(picnumssn==0){
						picnumssn = 1;
					  } else {
						picnumssn = parseInt(picnumssn) + 1;
					  }

					    image = e.target.result;
					    var pic = '<li id="newImage'+picnum+'" style="list-style:none;float:left;margin-right: 20px;position:relative;"><input type="hidden" name="data[List][pic]['+picnum+']" value="'+picname+'"><img src="'+image+'" alt="img" style="width:70px;height:70px;border: 1px solid #ccc;"/><a href="javascript:void(0)" class="cross" onclick="delpic_ssn('+picnumssn+','+picnum+')" id="cross'+picnum+'"><img src="<?php echo $this->webroot; ?>images/erase.png" alt=""  style="position: absolute;right: -11px;bottom: 0;"/></a></li>';
						
					    $("#Preview").append(pic);
					    document.getElementById('picnum').value = picnum;
				            document.getElementById('totalpics').value = totalpics;
					    document.getElementById('picnumssn').value = picnumssn;
					};
					formdata.append("file[]", file); 
					if(i==(numfiles-1))
					{
						$('#bannerbtn').prop('disabled', true);
						$.ajax({
							url: "<?php echo $this->webroot;?>users/upload_spa_images",
							type: "POST",
							data: formdata,
							processData: false,
							contentType: false,
							success: function(res){
							if(res!="0")
							{
                                                          $("#bannerbtn").prop('disabled', false);
							  $("#thespaphotos").val('');
							}
							else
							 {
							  alert("Error in upload. Retry");
							  $("#bannerbtn").prop('disabled', false);
							 }
							}
						});
					}
				 }
				 else
				 {
					alert(name+" Size limit exceeded");
				  }
				}
			        else
				{
					alert(name+" Not image file");
				}
		             }
		             else
		             {
		               alert("You can upload maximum 10 images");
		             }
			  }
			}
			else
			{
				alert("Select an image file");
				return;
			}
			  return false;
	    });
	});
	
        function delpic_ssn(picnumssn,picnum){
		$.post('<?php echo($this->webroot);?>users/remove_pic/'+picnumssn, function(data){
			if(data!=''){
				$("#newImage"+picnum).remove();
				if(totalpics==1){
					totalpics = 0;
				} else {
					totalpics = parseInt(totalpics) - 1;
				}
				document.getElementById('totalpics').value = totalpics;		
			} else {
				
			}
		});
	}
	
       function getstates()
       {
          var country_id=$('#country').val();
          $('#city').html('<option value="">Select City</option>');
          $('#area').html('<option value="">Select Area</option>');
          if(country_id==''){
             $('#state').html('<option value="">Select State</option>');
          }
          else
          {
              $.ajax({
	            url: "<?php echo $this->webroot;?>cities/get_states",
	            type: "POST",
	            data: {'country_id':country_id},
	            success: function(res)
	            {
	               $('#state').html(res);
	            }
                }); 
          }
        }
        function getcities()
        {
          var state_id=$('#state').val();
          $('#area').html('<option value="">Select Area</option>');
          if(state_id==''){
             $('#city').html('<option value="">Select City</option>');
          }
          else
          {
              $.ajax({
	            url: "<?php echo $this->webroot;?>cities/get_cities",
	            type: "POST",
	            data: {'state_id':state_id},
	            success: function(res)
	            {
	               $('#city').html(res);
	            }
                }); 
          }
        }
        function getareas()
        {
          var city_id=$('#city').val();
          if(city_id==''){
             $('#area').html('<option value="">Select Area</option>');
          }
          else
          {
              $.ajax({
	            url: "<?php echo $this->webroot;?>cities/get_areas",
	            type: "POST",
	            data: {'city_id':city_id},
	            success: function(res)
	            {
	               $('#area').html(res);
	            }
                }); 
          }
        }
    </script>
</body>
</html>
