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
$userid = $this->Session->read('Auth.User.id');
$admin_checkid = $this->Session->read('Auth.User.is_admin');
$utype = $this->Session->read('Auth.User.type');
$cakeDescription = __d('cake_dev', 'WEDSHOPPING');
?>
<!DOCTYPE html>
<html>


<head>
    <?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <?php echo $this->Html->css('bootstrap.min'); ?>

     <!--  icon  css   -->
     <link href="<?php echo($this->webroot)?>favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" href="https://use.fontawesome.com/b245db073c.css">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <?php echo $this->Html->css('easyzoom'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo ($this->webroot);?>css/bs_leftnavi.css">
    <!--   custom  css   -->
    <?php echo $this->Html->css('style'); ?>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script>
        <?php if($this->Session->read('Auth.User.id')){?>
       setInterval(function(){ latest_message_count(); }, 1000);
        <?php } ?>
    </script>
    <?php

    echo $this->Html->script('jquery.validate'); ?>

</head>

<body>

	<!--Header Start-->
	<header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="<?php echo($this->webroot);?>">
                    <img src="<?php echo($this->webroot);?>html/img/logo.png" alt="" class="img-fluid">
                </a>
                <button class="navbar-toggler nav-toggle" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="navbar-nav mr-auto">
                        <form class="form-inline flex-nowrap header-search my-2 my-lg-0 ml-xl-5" action="<?php echo $this->webroot.'products/search_result';?>" method="post">
                            <input class="form-control" type="text" name="data[Products][keyword]" placeholder="Search for items" aria-label="Search">
                            <button class="btn my-2 my-sm-0 btn-primary" type="submit"><i class="ion-android-search"></i>
                            </button>
                        </form>
                    </div>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $this->webroot.'products/search_result';?>"> Sell on WedShopping </a>
                        </li>


                        <?php if(isset($userid) && $admin_checkid!=1){?>



<?php if(isset($utype) && $utype=='V'){?>
                        <li class="dropdown nav-item">
                        <a class="dropdown-toggle nav-link d-flex align-items-center" data-toggle="dropdown" href="#" aria-expanded="true">
                            <div class="user-top-pic">
                                <img class="user-nav-img" src="<?php echo($this->webroot);?>user_images/default.png" alt="">
                            </div>
                            <span><?php echo $userdetails['User']['first_name'].' '.$userdetails['User']['last_name']?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="<?php echo($this->webroot);?>users/vendor_dashboard"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>

<!--                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>-->
                            <li class="divider"></li>
                            <li><a href="<?php echo($this->webroot);?>users/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                     <?php }else{ ?>

                      <li class="dropdown nav-item">
                        <a class="dropdown-toggle nav-link d-flex align-items-center" data-toggle="dropdown" href="#" aria-expanded="true">
                            <div class="user-top-pic">
                                <img class="user-nav-img" src="<?php echo($this->webroot);?>user_images/default.png" alt="">
                            </div>
                            <span><?php echo $userdetails['User']['first_name'].' '.$userdetails['User']['last_name']?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="<?php echo($this->webroot);?>users/dashboard"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
<!--                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>-->
                            <li class="divider"></li>
                            <li><a href="<?php echo($this->webroot);?>users/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>

                    <?php }

                        }else{ ?>

                         <li class="nav-item">
                            <a class="nav-link btn btn-outline-primary" href="<?php echo($this->webroot);?>users/registration">Register </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary" href="<?php echo($this->webroot);?>users/login">Sign in </a>
                        </li>



                        <?php } ?>
                        <li class="nav-item cart-item">
                            <a href="<?php echo $this->webroot.'products/cart';?>" class="nav-link"><i class="ion-android-cart"></i><span><?php echo((isset($awaiting_payment) && !empty($awaiting_payment))?'<b>'.$awaiting_payment.'</b>':'<b>0</b>' );?></span></a>
                        </li>
                        <li class="nav-item cart-item2">
                            <p class="nav-link"><i class="ion-chatbox cbox"></i><span class="mcount"><b>0</b></span></p>
                        </li>
                    </ul>


                </div>
            </div>

        </nav>
            <!--start menu-->
	<!--<div class="navbar navbar-expand-lg navbar-light full-nav mt-2">
            <div class="container justify-content-lg-center">
                <div class="bottom-nav-menu">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle dropdown-menu-link" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Clothing & Accessories
        </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a>
                                </li>
                                <li><a class="dropdown-item" href="#">Another action</a>
                                </li>
                                <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">Submenu</a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Submenu action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#">Another submenu action</a>
                                        </li>


                                        <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">Subsubmenu</a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Subsubmenu action</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Another subsubmenu action</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" href="#">Second subsubmenu</a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Subsubmenu action</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Another subsubmenu action</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item"><a href="#" class="nav-link">Jewellery</a>
                        </li>
                        <li class="nav-item"><a href="#" class="nav-link">Wedding</a>
                        </li>
                        <li class="nav-item"><a href="#" class="nav-link">Entertainment</a>
                        </li>
                        <li class="nav-item"><a href="#" class="nav-link">Fashion</a>
                        </li>
                        <li class="nav-item"><a href="#" class="nav-link">Toys & Hobbies</a>
                        </li>
                        <li class="nav-item"><a href="#" class="nav-link">Deals & Gifts</a>
                        </li>
                        <li class="nav-item"><a href="#" class="nav-link">Collectibles & Arts</a>
                        </li>
                        <li class="nav-item"><a href="#" class="nav-link">Vintage  </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>-->

            <!--end menu-->

         <?php  //pr($subcategory); ?>
        <div class="navbar navbar-expand-lg navbar-light full-nav mt-2">
            <div class="container justify-content-lg-center">
                <div class="bottom-nav-menu">
                    <ul class="navbar-nav">
                        <?php foreach($menus as $menu){?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle dropdown-menu-link" href="<?php echo $this->webroot ?>products/search_option/<?php echo $menu['Category']['id']; ?>"
                                <?php foreach($subcategory as $cat){
                                    if($cat['Category']['parent_id']==$menu['Category']['id']){ ?> data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false" <?php }else{ ?> <?php }} ?>>
          <?php echo $menu['Category']['name'];?>
        </a>
                            <ul class="dropdown-menu">
                                <?php   foreach($subcategory as $cat){
                                    if($cat['Category']['parent_id']==$menu['Category']['id']){
                                    ?>
                                <li><a class="dropdown-item" href="<?php echo $this->webroot ?>products/search_option/<?php echo $cat['Category']['id']; ?>"><?php echo $cat['Category']['name'];?></a>
                                </li>
                                <?php } }  ?>

                            </ul>
                        </li>
                        <?php }  ?>
                    </ul>
                </div>
            </div>
        </div>




    </header>

	<!--Header End-->

	<?php echo '<center>'.$this->Session->flash().'</center>'; ?>
	<?php echo $this->fetch('content');?>

        
        
  <div class="msg_box" style="right:290px;display:none;">
	<div class="msg_head"><span id="chat_name"></span>
	<div class="close">x</div>
	</div>
	<div class="msg_wrap">
		<div class="msg_body">
<!--			<div class="msg_a">This is from A	</div>
			<div class="msg_b">This is from B, and its amazingly kool nah... i know it even i liked it :)</div>
			<div class="msg_a">Wow, Thats great to hear from you man </div>
			<div class="msg_push"></div>-->
		</div>
        <input type="hidden" id="last_message_id_foot" value="">
         <input type="hidden" name="friend_id"  id="friend_id" />
	<div class="msg_footer"><textarea class="msg_input" rows="1"></textarea></div>
</div>
</div>      
   <!--For message system-->
 <?php if($login_friends){ ?>
  <div class="chat_box" style="display: none;">
  <div class="chat_head up_chk" data-id="1"> <div class="col-md-10 col-sm-5">Chat Box</div><div align="right" id="chat_icon_up"><i class="" aria-hidden="true"></i></div></div>
    <div class="chat_head up_chk1" data-id="1" style="display:none;"> <div class="col-md-10 col-sm-5">Chat Box</div><div align="right" id="chat_icon_down" ><i class="" aria-hidden="true"></i></div></div>
          <div class="chat_body">
    <?php foreach($login_friends as $logf){?>
   <a href="javascript: select_friend_foot(<?php echo $logf['U']['id'];?>)"> <div class="user" data-id=<?php echo $logf['U']['id'];?>> <?php if($logf['U']['is_active']==1){?> <span class="on_line on_<?php echo $logf['U']['id'];?>" ><i class="fa fa-circle" aria-hidden="true"></i></span><?php }else{ ?><span class="off_line off_<?php echo $logf['U']['id'];?>"><i class="fa fa-circle" aria-hidden="true"></i></span><?php } ?><label style="margin-left: 17px;"><?php echo $logf['U']['first_name'].' '.$logf['U']['last_name'];?></label></div></a>
    <?php } ?>
	</div>
  </div>
  <?php } ?>      
        
     	<!--Footer Start-->
	<footer class="pt-4 bg-light">
        <div class="container">
            <div class="row justify-content-lg-around">
                <div class="col-lg-2 col-md-4 col-sm-6 col-footer">
                    <h6>Shop</h6>
                    <ul class="list-unstyled">
                        <?php if(isset($userid) && $admin_checkid!=1){?>
                        <li><a href="<?php echo($this->webroot);?>users/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        <?php }else{ ?>
                        <li><a href="<?php echo($this->webroot);?>users/registration">Registration</a></li>
                        <?php } ?>
<!--                        <li><a href="#">Money Back Guarantee</a></li>
                        <li><a href="#">Bidding & buying help</a></li>
                        <li><a href="#">Stores</a></li>-->
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 col-footer">
                    <h6>Sell</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo $this->webroot.'products/search_result';?>">Sell on wedshopping</a></li>
                        <li><a href="<?php echo $this->webroot.'pages/terms_conditions';?>">Teams</a></li>
<!--                        <li><a href="#">Forums</a></li>-->
                    </ul>
                </div>
<!--                <div class="col-lg-2 col-md-4 col-sm-6 col-footer">
                    <h6>Companies</h6>
                    <ul class="list-unstyled">
                        <li><a href="#">Classifieds</a></li>
                        <li><a href="#">Shopping.com</a></li>
                        <li><a href="#">Half.com</a></li>
                        <li><a href="#">PayPal</a></li>
                        <li><a href="#">StubHub</a></li>
                        <li><a href="#">See all companies</a></li>
                    </ul>
                </div>-->
                <div class="col-lg-2 col-md-4 col-sm-6 col-footer">
                    <h6>About us</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo $this->webroot.'pages/company_info';?>">Company info</a></li>
                        <li><a href="<?php echo $this->webroot.'pages/investors';?>">Investors</a></li>
                        <li><a href="<?php echo $this->webroot.'pages/terms_conditions';?>">Terms & Conditions</a></li>
                        <li><a href="<?php echo $this->webroot.'pages/privacy_policy';?>">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 col-footer col-ft-social">
                    <h6>Help & Contact</h6>
                     <ul class="list-unstyled">
                        <li><a href="<?php echo $sitesetting['SiteSetting']['facebook_url'];?>"><i class="ion-social-facebook"></i> Facebook</a></li>
                        <li><a href="<?php echo $sitesetting['SiteSetting']['twitter_url'];?>"><i class="ion-social-twitter"></i> Twitter</a></li>
                        <li><a href="<?php echo $sitesetting['SiteSetting']['gplus_url'];?>"><i class="ion-social-googleplus"></i> Google Plus</a></li>
                        <!--<li><a href="#"><i class="ion-social-rss"></i> Rss</a></li>-->
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom mt-5 py-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <img src="<?php echo($this->webroot);?>html/img/logo2.png" alt="">
                    </div>
                    <div class="col-md-6 text-md-right">
                        <p> Copyright ©  2017 wedshopping. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>


	<!--Footer End-->

<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script>
        $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
            if (!$(this).next().hasClass('show')) {
                $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
            }
            var $subMenu = $(this).next(".dropdown-menu");
            $subMenu.toggleClass('show');


            $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
                $('.dropdown-submenu .show').removeClass("show");
            });


            return false;
        });
    </script>
    <script>
        $(document).ready(function(){
            $(".nav-toggle").click(function(){
                $(".full-nav").toggle();
            });
        });
    </script>
    <script>
    $(function() {
            $('a[data-toggle="collapse"]').on('click', function() {

                var objectID = $(this).attr('href');

                if ($(objectID).hasClass('in')) {
                    $(objectID).collapse('hide');
                } else {
                    $(objectID).collapse('show');
                }
            });


            $('#expandAll').on('click', function() {

                $('a[data-toggle="collapse"]').each(function() {
                    var objectID = $(this).attr('href');
                    if ($(objectID).hasClass('in') === false) {
                        $(objectID).collapse('show');
                    }
                });
            });

            $('#collapseAll').on('click', function() {

                $('a[data-toggle="collapse"]').each(function() {
                    var objectID = $(this).attr('href');
                    $(objectID).collapse('hide');
                });
            });

        });
    </script>
    <?php echo $this->Html->script('easyzoom');

    ?>
    <!--<script src="js/easyzoom.js"></script>-->
    <script>
        // Instantiate EasyZoom instances
        var $easyzoom = $('.easyzoom').easyZoom();

         // Setup thumbnails example
        var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

        $('.thumbnails').on('click', 'a', function(e) {
            var $this = $(this);

            e.preventDefault();

            // Use EasyZoom's `swap` method
            api1.swap($this.data('standard'), $this.attr('href'));
        });

         // Setup toggles example
        var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

        $('.toggle').on('click', function() {
            var $this = $(this);

            if ($this.data("active") === true) {
                $this.text("Switch on").data("active", false);
                api2.teardown();
            } else {
                $this.text("Switch off").data("active", true);
                api2._init();
            }
        });
        
        
        
        $('.cbox').click(function(){

		$('.chat_box').slideToggle('slow');
                $('.cbox').hide();
		$('.cbox').show();
		
	});
        
        
        
    </script>
<script>
 $(document).ready(function(){
<?php if($this->Session->read('Auth.User.id')){?>
//	$('.up_chk').click(function(){
//		$('.chat_body').slideToggle('slow');
//		$('.up_chk').hide();
//		$('.up_chk1').show();
//	});
//	$('.up_chk1').click(function(){
//		$('.chat_body').slideToggle('slow');
//		$('.up_chk1').hide();
//		$('.up_chk').show();
//
//	});
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
                
                
                function latest_message_count(){
                
                //var last_message_id = $('#last_message_id_foot').val();
		//alert(last_message_id);
		//var friend_id = $('#friend_id').val();
		//alert (friend_id);
		$.ajax({
				type: 'POST',
				url: '<?php echo Router::url(array('controller' => 'messages', 'action' =>'latestMessage_footer_count'), true); ?>',
				//data: {last_message_id:last_message_id},
				cache: false,
                                //dataType: 'HTML',
				success: function (data){
                                    //alert(data);
					//var data_arr = data.split("||");
					if(data != ""){
						//$('#last_message_id_foot').val(data_arr[0]);
						$('.mcount').html(data);
						
					
					}
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
    <script>      $(document).ready(function(){        setTimeout(function() {           $('.message').fadeOut('slow');           $('.success').fadeOut('slow');        }, 3000);      });      var base_url = "<?php echo $this->webroot;?>";  </script>
    <?php echo $this->element('sql_dump'); ?>
</body>
</html>
