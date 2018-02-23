<?php
/**
 *
 *
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

$cakeDescription = __d('cake_dev', 'Deal Admin Panel');
?>
<?php 
if(($this->params['controller']=='users' && $this->params['action']=='admin_index') || ($this->params['controller']=='users' && $this->params['action']=='admin_login') || ($this->params['controller']=='users' && $this->params['action']=='admin_fotgot_password'))
{
?>
<!DOCTYPE html>
<html>
<head>
<title>
  <?php echo $cakeDescription ?>:
  <?php echo $title_for_layout; ?>
</title>
<link href="<?php echo($this->webroot)?>favicon.ico" type="image/x-icon" rel="shortcut icon">
<link href="<?php echo($this->webroot)?>admin_styles/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="<?php echo($this->webroot)?>admin_styles/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
<link href="<?php echo($this->webroot)?>admin_styles/assets/styles.css" rel="stylesheet" media="screen">
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="<?php echo($this->webroot)?>admin_styles/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<script src="<?php echo($this->webroot)?>admin_styles/vendors/jquery-1.9.1.min.js"></script>
<script src="<?php echo($this->webroot)?>js/jquery-ui.js"></script>
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
</head>
<?php echo $this->Session->flash(); ?>
<?php echo $this->fetch('content'); ?>
<?php
}
else
{
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<link href="<?php echo($this->webroot)?>favicon.ico" type="image/x-icon" rel="shortcut icon">
	<link href="<?php echo($this->webroot)?>admin_styles/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="<?php echo($this->webroot)?>admin_styles/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
	
	<link href="<?php echo($this->webroot)?>admin_styles/vendors/easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
	<link href="<?php echo($this->webroot)?>admin_styles/assets/styles.css" rel="stylesheet" media="screen">
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<script src="<?php echo($this->webroot)?>admin_styles/vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
	
	<?php
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="<?php echo($this->webroot)?>admin_styles/vendors/jquery-1.9.1.min.js"></script>
	 <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
</head>
<body>
	<div id="container">
		<?php echo($this->element('admin_topbar'));?>
		<div class="container-fluid">
			<div class="row-fluid">
				<?php echo $this->Session->flash(); ?>
				<?php echo($this->element('admin_sidebar'));?>
				<?php echo $this->fetch('content'); ?>
			</div>
			<hr>
			<footer>
				<p>&copy; Widding <?php echo(date('Y'))?></p>
			</footer>
		</div>
	</div>
	
	<script src="<?php echo($this->webroot)?>admin_styles/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo($this->webroot)?>admin_styles/vendors/easypiechart/jquery.easy-pie-chart.js"></script>
	<script src="<?php echo($this->webroot)?>admin_styles/assets/scripts.js"></script>
	
<script>
	$(function() {
	   $('.chart').easyPieChart({animate: 1000});
	});
	$(document).ready(function(){ 
	   setTimeout(function() {
		$('.message').fadeOut('slow');
	   }, 2000);
	   setTimeout(function() {
		$('.success').fadeOut('slow');
	   }, 2000);
	});
</script>
<script>
$(document).ready(function(){
  $("#hideme").click(function(){
    $(".showall").toggle();
  });
});
function getstates()
{
  var country_id=$('#country_id').val();
  $('#city_id').html('<option value="">Select City</option>');
  if(country_id==''){
     $('#state_id').html('<option value="">Select State</option>');
  }
  else
  {
      $.ajax({
	    url: "<?php echo $this->webroot;?>cities/get_states",
	    type: "POST",
	    data: {'country_id':country_id},
	    success: function(res)
	    {
	       $('#state_id').html(res);
	    }
        }); 
  }
}
function getcities()
{
  var state_id=$('#state_id').val();
  if(state_id==''){
     $('#city_id').html('<option value="">Select City</option>');
  }
  else
  {
      $.ajax({
	    url: "<?php echo $this->webroot;?>cities/get_cities",
	    type: "POST",
	    data: {'state_id':state_id},
	    success: function(res)
	    {
	       $('#city_id').html(res);
	    }
        }); 
  }
}
</script>
<?php
}
?>
<?php echo $this->element('sql_dump'); ?>
</body>
</html>
