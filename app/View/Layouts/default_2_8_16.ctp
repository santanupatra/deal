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

$cakeDescription = __d('cake_dev', 'TWOP');
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
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<!-- Bootstrap -->
	<link href="<?php echo($this->webroot);?>css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo($this->webroot);?>css/bootstrap-theme.css" rel="stylesheet">
	<link href="<?php echo($this->webroot);?>css/font-awesome.min.css" rel="stylesheet" type="text/css"/>	
	<script src="<?php echo $this->webroot;?>js/jquery.min.js"></script>
	<script src="<?php echo $this->webroot;?>js/bootstrap.min.js"></script>
</head>
<body>
	<?php 
	if(($this->params['controller']=='users' && $this->params['action']=='signin') || ($this->params['controller']=='users' && $this->params['action']=='forgot_password'))
	{
	?>
	<?php } else {?>
	<!--Header Start-->
	<section class="header_top">
	<div class="container">
		<ul class="pull-left top-left-menu">
			<li><a href="#">Sell</a></li>
			<li><a href="#">Customer Service</a></li>
		</ul>
		<ul class="pull-right top-right-menu">
			<li><a href="#">My TWOP</a></li>
			<li><a href="#" class="fa fa-bell border-0"></a></li>
			<li><a href="<?php echo $this->webroot?>products/cart" class="fa fa-shopping-cart border-0"></a></li>
		</ul>
	</div>
	</section>
	<nav class="navbar navbar-default">
	  <div class="container">
    	<div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="<?php echo $this->webroot?>"><img src="<?php echo($this->webroot);?>images/logo.png" alt="" /></a>
	    </div>
	    <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
	      	<form class="form-inline">
			  <div class="form-group search-gorup">
			    <div class="input-group">
			      <input type="text" class="form-control" id="exampleInputAmount" placeholder="Keyword">
			      <div class="input-group-addon">
			      	<select name="">
			      		<option>Country</option>
			      		<option></option>
			      		<option></option>
			      	</select>
			      </div>
			      <div class="input-group-addon">
			      	<select name="">
			      		<option>All Categories</option>
			      		<option></option>
			      		<option></option>
			      	</select>
			      </div>
			    </div>
			  </div>
			  <button type="submit" class="btn btn-primary btnsearch">Search</button>
			   <div class="form-group">
				<?php 
				if(isset($userid) && $userid!=''){
				?>
				<a href="<?php echo($this->webroot)?>users/edit-profile">My Account</a>
				<?php } else { ?>				
				    <div class="input-group buttion_log">
				     	<button class="input-group-addon" type="button" onclick="return gotoLogin()">Login</button>|
				     	<button class="input-group-addon" type="button" onclick="return gotoLogin()">Signup</button>
				    </div>
				<?php } ?>
			  </div>
			</form>
	    </div>
	  </div>
	</nav>
	<?php
	if($this->params['controller']=='shops' && $this->params['action']=='details'){	
	?>
	<?php 
	} 
	else 
	{ 
		if(isset($homecategories) && !empty($homecategories))
		{
	?>
	<section class="header_nav">
		<div class="container">
			<ul class="nav nav-pills">
				<?php foreach($homecategories as $category)
				{?>
				<li role="presentation"><a href="<?php echo $this->webroot.'products/list/'.$category['Category']['name'].'/'.$category['Category']['id'];?>"><?php echo ucwords($category['Category']['name'])?></a></li>
				<?php }?>
				
			</ul>
		</div>
	</section>
	<?php }
	} ?>
	<!--Header End-->
	<?php } ?>
	<?php echo '<center>'.$this->Session->flash().'</center>'; ?> 
	<?php echo $this->fetch('content');?>
     	<!--Footer Start-->
	<section class="footer_top">
		<div class="container">
			<div class="row">
				<div class="col-md-2">
				<ul>
					<li><h5>Buy</h5></li>
					<li><a href="<?php echo($this->webroot)?>contents/view/wishlist">Wishlist</a></li>
					<li><a href="<?php echo($this->webroot)?>contents/view/favourite">Favourite</a></li>
					<li><a href="<?php echo($this->webroot)?>contents/view/free-registration">Free Registration</a></li>
					<li><a href="<?php echo($this->webroot)?>contents/view/disputes">Disputes</a></li>
					<li><a href="<?php echo($this->webroot)?>contents/view/selling-protection">Selling Protection</a></li>
					<li><a href="<?php echo($this->webroot)?>contents/view/no-extra-shipping-charges">No Extra Shipping Charges</a></li>
				</ul>
				</div>
				<div class="col-md-2">
				<ul>
					<li><h5>Sell</h5></li>
					<li><a href="<?php echo($this->webroot)?>contents/view/shops">Shops</a></li>
					<li><a href="<?php echo($this->webroot)?>contents/view/product-showcase">Product Showcase</a></li>
					<li><a href="<?php echo($this->webroot)?>contents/view/mailing">Mailing</a></li>
					<li><a href="<?php echo($this->webroot)?>contents/view/listing">Listing</a></li>
					<li><a href="<?php echo($this->webroot)?>contents/view/feedback">Feedback</a></li>
				</ul>
				</div>
				<div class="col-md-2">
				<ul>
					<li><h5>TWOP Shops</h5></li>
					<li><a href="#">Top Rated Sellers</a></li>
					<li><a href="#">Top Rated Shops</a></li>
					<li><a href="#">Top Rated Products</a></li>
				</ul>
				</div>
				<div class="col-md-2">
				<ul>
					<li><h5>Top Categories</h5></li>
					<li><a href="#">Glass</a></li>
					<li><a href="#">Adhesive</a></li>
					<li><a href="#">Aluminium</a></li>
					<li><a href="#">Paper</a></li>
					<li><a href="#">Metal</a></li>
				</ul>
				</div>
				<div class="col-md-2">
				<ul>
					<li><h5>About TWOP</h5></li>
					<li><a href="<?php echo($this->webroot)?>contents/view/legal">Legal</a></li>
					<li><a href="<?php echo($this->webroot)?>contents/view/association">Association</a></li>
					<li><a href="<?php echo($this->webroot)?>contents/view/exhibitions">Exhibitions</a></li>
					<li><a href="<?php echo($this->webroot)?>contents/view/federations">Federations</a></li>
					<li><a href="<?php echo($this->webroot)?>contents/view/news">News</a></li>
					<li><a href="<?php echo($this->webroot)?>contents/view/magazine">Magazine</a></li>
				</ul>
				</div>
				<div class="col-md-2">
				<ul>
					<li><h5>Follow Us</h5></li>
					<li>
						<a href="#"><i class="fa fa-facebook"></i></a>
						<a href="#"><i class="fa fa-twitter"></i></a>
						<a href="#"><i class="fa fa-google-plus"></i></a>
						<a href="#"><i class="fa fa-share-alt"></i></a>
					</li>
				</ul>
				</div>
			</div>
		</div>
	</section>
	<section class="footer_bottom">
		<p> Copyright ©  <?php echo(date('Y'))?> TWOP. All rights reserved.</p>
	</section>
	<!--Footer End-->
	<script>
	function gotoLogin(){
		window.location.href="<?php echo($this->webroot);?>users/signin";
	}

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
