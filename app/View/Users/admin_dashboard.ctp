<style>
.block-content {
    margin: 1em;
    background: #e8e8e8;
    padding: 10px 10px;
    min-height: 100px;
}    
</style>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

<div class="span9" id="content">
	<div class="row-fluid">
		<div class="navbar">
			<div class="navbar-inner">
				<ul class="breadcrumb">
					
					<li>
						<a href="<?php echo($this->webroot)?>admin/users/dashboard">Dashboard</a> 
					</li>
					
				</ul>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">Statistics</div>
				<div class="pull-right">

				</div>
			</div>
			
<!--			<div class="block-content collapse in">
			 Welcome To Admin Panel. Dashboard Statistics Coming Soon...
			</div>-->
<div class="row-fluid">
    <div class="span3">
        <div class="block-content collapse in" style="text-align: center;"> 
          <i class="fa fa-user" aria-hidden="true"></i> <span style="font-size: 17px"> No of User </span> 
          <br><br><span style="font-size: 50px"><?php echo $countuser;?></span>  
        </div>
    </div>
    
    <div class="span3">
        <div class="block-content collapse in" style="text-align: center;"> 
           <i class="fa fa-user" aria-hidden="true"></i> <span style="font-size: 17px"> No of Vendor </span> 
           <br><br><span  style="font-size: 50px"><?php echo($countvendor)?></span> </a> 
        </div>        
    </div>
    
    <div class="span3">
        <div class="block-content collapse in" style="text-align: center;"> 
           <i class="fa fa-cloud-upload" aria-hidden="true"></i> <span style="font-size: 17px"> Deal Uploaded </span> 
          <br><br><span style="font-size: 50px"><?php echo $countdealupload; ?></span>  
        </div>        
    </div>
    <div class="span3">
        <div class="block-content collapse in" style="text-align: center;"> 
           <i class="fa fa-cloud-upload" aria-hidden="true"></i> <span style="font-size: 17px"> Coupon Uploaded </span> 
          <br><br><span style="font-size: 50px"><?php echo $countcouponupload; ?></span>  
        </div>        
    </div>  
</div>

<div class="row-fluid">
    <div class="span3">
        <div class="block-content collapse in" style="text-align: center;"> 
           <i class="fa fa-cart-plus" aria-hidden="true"></i> <span style="font-size: 17px"> Coupon Sold </span> 
          <br><br><span style="font-size: 50px"><?php echo $countcouponsold; ?></span>  
        </div>
    </div>
    
    
    <!--<a class="quick-btn" href=""></a>-->
</div>

                            
		</div>
		<!-- /block -->
	</div>
</div>
<style>
fieldset.scheduler-border {
    border: 1px solid #d4d4d4 !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    #margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
    box-shadow:  0px 0px 0px 0px #000;
	width:43%;
	float:left;
	margin-right:20px;
}

legend.scheduler-border {
    width:inherit; /* Or auto */
    padding:0 10px; /* To give a bit of padding on the left and right */
    border-bottom:none;
	width:auto;
}
.count_class
{
 float:left;
 width:100%;
 margin-bottom:7px;
 color:#999;
}
.table-hover a
{
  text-decoration:underline;
}
</style>
	