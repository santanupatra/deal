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
$cakeDescription = __d('cake_dev', 'DEAL');
?>
<!doctype html>
<html lang="en">
  <head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $cakeDescription ?>:
        <?php echo $title_for_layout; ?>
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <?php echo $this->Html->css('bootstrap.min'); ?>
    <?php echo $this->Html->css('style'); ?>
    <?php echo $this->Html->css('flexslider'); ?>

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

  </head>
  <body>
     <header>
        <section class="upper-part py-2">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <ul class="header-solial">
                            <li>
                                <a href="">
                                    <i class="fa fa-facebook" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="fa fa-twitter" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="fa fa-google-plus" aria-hidden="true"></i>
                                </a>
                            </li>
                        </ul>
                        <a href="" class="header-mail">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            1 - 23456 - 789
                        </a>
                        <a href="" class="header-mail">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            info@support.com
                        </a>
                    </div>
                    
                    
                    <?php if(isset($userid) && $admin_checkid!=1){?>
                    
                    
                    <div class="col-lg-6 text-lg-right">
                        <a href="<?php echo($this->webroot);?>users/logout" class="btn btn-theme btn-sm rounded-0 btn-login font-14"><b><i class="fa fa-sign-in" aria-hidden="true"></i></b> Logout</a>                        <?php if(isset($utype) && $utype=='V'){?>
                        <a href="<?php echo $this->webroot;?>users/vendor_dashboard" class="btn btn-theme btn-sm rounded-0 font-14"><b><i class="fa fa-user-plus" aria-hidden="true"></i></b>My Dashboard</a>                        <?php }else{ ?>
                        
                        <a href="<?php echo $this->webroot;?>users/dashboard" class="btn btn-theme btn-sm rounded-0 font-14"><b><i class="fa fa-user-plus" aria-hidden="true"></i></b> My Dashboard</a> 
                        
                        
                        <?php } ?>
                    </div>
                    
                    
                    <?php }else{ ?>
                    
                    
                    <div class="col-lg-6 text-lg-right">
                        <a href="<?php echo $this->webroot;?>users/login" class="btn btn-theme btn-sm rounded-0 btn-login font-14"><b><i class="fa fa-sign-in" aria-hidden="true"></i></b> Login</a>                        
                        <a href="<?php echo $this->webroot;?>users/registration" class="btn btn-theme btn-sm rounded-0 font-14"><b><i class="fa fa-user-plus" aria-hidden="true"></i></b> Register</a>                        
                    </div>
                    
                    
                    <?php } ?>
                </div>
            </div>
        </section>
        <section class="header-btn">
            <nav class="navbar navbar-expand-lg navbar-light bg-white">
                <div class="container">
                  <a class="navbar-brand" href="<?php echo $this->webroot;?>">
                      <img src="<?php echo $this->webroot;?>img/logo.png" alt="">
                  </a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ml-auto">
                      <li class="nav-item active">
                        <a class="nav-link text-uppercase" href="<?php echo $this->webroot;?>">home <span class="sr-only">(current)</span></a>
                      </li>
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-uppercase" href="#" data-toggle="dropdown">
                           deals
                        </a>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="#">Action</a>
                          <a class="dropdown-item" href="#">Another action</a>
                          <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                      </li>
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-uppercase" href="#" data-toggle="dropdown">
                            cupons
                        </a>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="#">Action</a>
                          <a class="dropdown-item" href="#">Another action</a>
                          <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link text-uppercase" href="#"> faq</a>
                      </li>
                      <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-uppercase" href="#" data-toggle="dropdown">
                           all
                        </a>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="#">Action</a>
                          <a class="dropdown-item" href="#">Another action</a>
                          <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link text-uppercase" href="<?php echo $this->webroot;?>users/contactus"> contacts</a>
                      </li>
                    </ul>
                  </div>
              </div>
            </nav>
        </section>
     </header>
        <?php echo '<center>'.$this->Session->flash().'</center>'; ?>
        <?php echo $this->fetch('content');?>
     
    <footer class="py-1">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <a href="">
              <img src="<?php echo $this->webroot;?>img/logo2.png" alt="">
            </a>
          </div>
          <div class="col-md-6 text-md-right text-white">
            <p class="mt-1 mb-0">Copyright 2016 All right Received </p>
            <p class="mb-o">Designed By Nat-It- Solved pvt ltd</p>
          </div>
        </div>
      </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
    <?php echo $this->Html->script('bootstrap.min'); ?>
    <?php echo $this->Html->script('jquery.flexslider'); ?> 
    <?php echo $this->Html->script('jquery.validate'); ?> 
  
   <script>
  $( function() {
    $( "#toDate" ).datepicker({ 
            dateFormat: 'yy-mm-dd',
            yearRange: "-150:+1"
        });
  } );
  </script>
  
  <script>
  $( function() {
    $( "#fromDate" ).datepicker({ 
            dateFormat: 'yy-mm-dd',
            yearRange: "-150:+1"
        });
  } );
  </script>
  
  
  
    <script>
      (function() {
        // store the slider in a local variable
        var $window = $(window),
            flexslider = { vars:{} };
       
        // tiny helper function to add breakpoints
        function getGridSize() {
          return (window.innerWidth < 600) ? 2 :
                 (window.innerWidth < 900) ? 3 : 4;
        }
       
        $(function() {
          SyntaxHighlighter.all();
        });
       
        $window.load(function() {
          $('.flexslider').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 210,
            itemMargin: 5,
            minItems: getGridSize(), // use function to pull in initial value
            maxItems: getGridSize() // use function to pull in initial value
          });
        });
       
        // check grid size on resize event
        $window.resize(function() {
          var gridSize = getGridSize();
       
          flexslider.vars.minItems = gridSize;
          flexslider.vars.maxItems = gridSize;
        });
      }());
    </script>
    
    <script>
	
	$(document).ready(function(){ 
	   setTimeout(function() {
		$('.message').fadeOut('slow');
	   }, 2000);
	   setTimeout(function() {
		$('.success').fadeOut('slow');
	   }, 2000);
	});
</script>
  </body>
</html>

