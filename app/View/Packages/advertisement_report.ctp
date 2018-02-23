<?php //pr($advertisement_lists);
//pr($advertisements);

$userid = $this->Session->read('Auth.User.id');
$first  = strtotime('first day this month');

$monthyear0=date('M y', strtotime("-0 month", $first));
$monthyear1=date('M y', strtotime("-1 month", $first));
$monthyear2=date('M y', strtotime("-2 month", $first));
$monthyear3=date('M y', strtotime("-3 month", $first));
$monthyear4=date('M y', strtotime("-4 month", $first));
$monthyear5=date('M y', strtotime("-5 month", $first));
$monthyear6=date('M y', strtotime("-6 month", $first));
$monthyear7=date('M y', strtotime("-7 month", $first));
$monthyear8=date('M y', strtotime("-8 month", $first));
$monthyear9=date('M y', strtotime("-9 month", $first));
$monthyear10=date('M y', strtotime("-10 month", $first));
$monthyear11=date('M y', strtotime("-11 month", $first));

$prevmonth0=date('m', strtotime("-0 month", $first));
$prevyear0=date('Y', strtotime("-0 month", $first));
$prevmonth1=date('m', strtotime("-1 month", $first));
$prevyear1=date('Y', strtotime("-1 month", $first));
$prevmonth2=date('m', strtotime("-2 month", $first));
$prevyear2=date('Y', strtotime("-2 month", $first));
$prevmonth3=date('m', strtotime("-3 month", $first));
$prevyear3=date('Y', strtotime("-3 month", $first));
$prevmonth4=date('m', strtotime("-4 month", $first));
$prevyear4=date('Y', strtotime("-4 month", $first));
$prevmonth5=date('m', strtotime("-5 month", $first));
$prevyear5=date('Y', strtotime("-5 month", $first));
$prevmonth6=date('m', strtotime("-6 month", $first));
$prevyear6=date('Y', strtotime("-6 month", $first));
$prevmonth7=date('m', strtotime("-7 month", $first));
$prevyear7=date('Y', strtotime("-7 month", $first));
$prevmonth8=date('m', strtotime("-8 month", $first));
$prevyear8=date('Y', strtotime("-8 month", $first));
$prevmonth9=date('m', strtotime("-9 month", $first));
$prevyear9=date('Y', strtotime("-9 month", $first));
$prevmonth10=date('m', strtotime("-10 month", $first));
$prevyear10=date('Y', strtotime("-10 month", $first));
$prevmonth11=date('m', strtotime("-11 month", $first));
$prevyear11=date('Y', strtotime("-11 month", $first));
?>
<link href="<?php echo $this->webroot?>js/c3-chart/c3.css" rel="stylesheet"/>
<style type="text/css">
/** Paging **/
.paging {
	background:#fff;
	color: #ccc;
	margin-top: 1em;
	clear:both;
}
.paging .current,
.paging .disabled,
.paging a {
	text-decoration: none;
	padding: 5px 8px;
	display: inline-block
}
.paging > span {
	display: inline-block;
	border: 1px solid #ccc;
	border-left: 0;
}
.paging > span:hover {
	background: #efefef;
}
.paging .prev {
	border-left: 1px solid #ccc;
	-moz-border-radius: 4px 0 0 4px;
	-webkit-border-radius: 4px 0 0 4px;
	border-radius: 4px 0 0 4px;
}
.paging .next {
	-moz-border-radius: 0 4px 4px 0;
	-webkit-border-radius: 0 4px 4px 0;
	border-radius: 0 4px 4px 0;
}
.paging .disabled {
	color: #ddd;
}
.paging .disabled:hover {
	background: transparent;
}
.paging .current {
	background: #efefef;
	color: #c73e14;
}
.name {
	color:#009cdb;
}
.name a {
	color:#009cdb;
}
.adv_report .nav-tabs li{width:33.3% !important;}
.adv_report .nav > li > a {    margin-right: 2px !important; }
.pro_about{height:auto;width:773px;padding:18px;background: white;border-radius:3px;box-shadow:0 0 2px #999;margin-top:20px;float:left;margin-left:20px;padding:20px;}
.profile_btn{border:1px solid #dadbda;padding:5px 10px 5px 10px;color:#747674;border-radius: 3px;margin:10px 0px 0px 0px;}
.pro_right_btn{float:right !important;margin-right:10px;border:0px !important;margin-top:13px;}
</style>

<section class="after_login">
    <div class="container">
        <div class="row">
            <?php echo($this->element('user_leftbar'));?>
            <div class="col-md-9">
                  <div class="category_tab adv_report">
			<ul class="nav nav-tabs" role="tablist">
			    <li class="active">
                                <a href="#Daily" data-toggle="tab">Daily</a>
                            </li>
                           
                            <li class="">
                                <a href="#Monthly" data-toggle="tab">Monthly</a>
                            </li>
			    <li class="">
                                <a href="#Yearly" data-toggle="tab">Yearly</a>
                            </li>
			
		 	</ul>
			
			<div class="tab-content">
                            <div class="tab-pane active" id="Daily">
                                <div id="daily_graph" style="width:100%;height:400px;border:0px solid blue;">
				    
				</div>
				    <table class="seller_table">
						<tr>
							<th></th>
							<th>Image</th>
							<th>Type</th>
							<th>IP</th>
							<th>Date</th>
                                                       
						</tr>
						<?php //pr($inventoryList);exit;
						if(!empty($advertisement_lists)){
						    foreach($advertisement_lists as $advertisement){
                                                       
						?>
                                                <tr>
                                                <td>&nbsp;</td>
                                                <td><img src="<?php echo $this->webroot;?>advertisement/<?php echo $advertisement['Advertisement']['image_name'];?>" style=" height:30px; width:30px;"></td>
                                                <td>
                                                    <?php
                                                    if($advertisement['Advertisement']['type']==1)
                                                    {
                                                        echo "home page";
                                                    }
                                                    elseif ($advertisement['Advertisement']['type']==2) {echo "prodyct details page";}
                                                    else {echo "both";}
                                                    
                                                    ?>
                                                    
                                                </td>
                                                <td><?php echo $advertisement['AdvertisementReport']['ip_addr'];?></td>
                                                <td><?php echo $advertisement['AdvertisementReport']['cdate'];?></td>
                                                </tr>
						<?php 
							}
						    } 
						else{
						   echo "<tr><td colspan='5'>Sorry No Record found</td></tr>"; 
						}
						?>
				    </table>
				
				    <div class="paging">
				    <?php
					    echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
					    echo $this->Paginator->numbers(array('separator' => ''));
					    echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
				    ?>
				    </div>
                            </div>
                            <div class="tab-pane" id="Monthly">
                                <div id="monthly_graph" style="width:100%;height:400px;border:0px solid blue;"></div>
				  <table class="seller_table">
						<tr>
							<th></th>
							<th>Image</th>
							<th>Type</th>
							<th>IP</th>
							<th>Date</th>
                                                       
						</tr>
						<?php //pr($advertisementlist_month);exit;
						if(!empty($advertisementlist_month)){
						    foreach($advertisementlist_month as $advertisement){
                                                       
						?>
                                                <tr>
                                                <td>&nbsp;</td>
                                                <td><img src="<?php echo $this->webroot;?>advertisement/<?php echo $advertisement['Advertisement']['image_name'];?>" style=" height:30px; width:30px;"></td>
                                                <td>
                                                    <?php
                                                    if($advertisement['Advertisement']['type']==1)
                                                    {
                                                        echo "home page";
                                                    }
                                                    elseif ($advertisement['Advertisement']['type']==2) {echo "product details page";}
                                                    else {echo "both";}
                                                    
                                                    ?>
                                                    
                                                </td>
                                                <td><?php echo $advertisement['AdvertisementReport']['ip_addr'];?></td>
                                                <td><?php echo $advertisement['AdvertisementReport']['cdate'];?></td>
                                                </tr>
						<?php 
							}
						    } 
						else{
						   echo "<tr><td colspan='5'>Sorry No Record found</td></tr>"; 
						}
						?>
				    </table> 
				    <div class="paging">
				    <?php
					    echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
					    echo $this->Paginator->numbers(array('separator' => ''));
					    echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
				    ?>
				    </div>
                            </div>
                            <div class="tab-pane" id="Yearly">
                                <div id="yearly_graph" style="width:100%;height:400px;border:0px solid blue;"></div>
				<!--  <table class="seller_table">
						<tr>
							<th></th>
							<th>Image</th>
							<th>Type</th>
							<th>IP</th>
							<th>Date</th>
                                                       
						</tr>
						<?php //pr($inventoryList);exit;
						if(!empty($advertisementlist_year)){
						    foreach($advertisementlist_year as $advertisement){
                                                       
						?>
                                                <tr>
                                                <td>&nbsp;</td>
                                                <td><img src="<?php echo $this->webroot;?>advertisement/<?php echo $advertisement['Advertisement']['image_name'];?>" style=" height:30px; width:30px;"></td>
                                                <td>
                                                    <?php
                                                    if($advertisement['Advertisement']['type']==1)
                                                    {
                                                        echo "home page";
                                                    }
                                                    elseif ($advertisement['Advertisement']['type']==2) {echo "prodyct details page";}
                                                    else {echo "both";}
                                                    
                                                    ?>
                                                    
                                                </td>
                                                <td><?php echo $advertisement['AdvertisementReport']['ip_addr'];?></td>
                                                <td><?php echo $advertisement['AdvertisementReport']['cdate'];?></td>
                                                </tr>
						<?php 
							}
						    } 
						else{
						   echo "<tr><td colspan='4'>Sorry No Record found</td></tr>"; 
						}
						?>
				    </table> -->
                            </div>
			      
                        </div>
                     </div>   

            </div>
        </div>

    </div>
</section>
<script src="<?php echo $this->webroot?>js/anychart.min.js"></script>
<?php
$i=0;
$advertisementscount = count($advertisements);
?>
<script>
    $(document).ready(function(){
	
        
	var dataSet = anychart.data.set([
            
	    ['<?php echo date("d M", strtotime("-6 days")).",".date("Y", strtotime("-6 days"));?>',<?php for($j=0;$j< $advertisementscount;$j++){ echo  $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range', date('Y-m-d', strtotime("-6 days")),date('Y-m-d', strtotime("-6 days")),$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => '')); 
	    
	    if($j+1 !=$advertisementscount){ echo ','; } } ?>],
	    
            ['<?php echo date("d M", strtotime("-5 days")).",".date("Y", strtotime("-5 days"));?>', <?php for($j=0;$j< $advertisementscount;$j++){  echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range', date('Y-m-d', strtotime("-5 days")),date('Y-m-d', strtotime("-5 days")),$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => '')); if($j+1 !=$advertisementscount){ echo ','; } } ?>],
            ['<?php echo date("d M", strtotime("-4 days")).",".date("Y", strtotime("-4 days"));?>', <?php for($j=0;$j< $advertisementscount;$j++){ echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range', date('Y-m-d', strtotime("-4 days")),date('Y-m-d', strtotime("-4 days")),$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => '')); if($j+1 !=$advertisementscount){ echo ','; }} ?>],
	    
            ['<?php echo date("d M", strtotime("-3 days")).",".date("Y", strtotime("-3 days"));?>', <?php for($j=0;$j< $advertisementscount;$j++){ echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range', date('Y-m-d', strtotime("-3 days")),date('Y-m-d', strtotime("-3 days")),$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => '')); if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo date("d M", strtotime("-2 days")).",".date("Y", strtotime("-2 days"));?>', <?php for($j=0;$j< $advertisementscount;$j++){ echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range', date('Y-m-d', strtotime("-2 days")),date('Y-m-d', strtotime("-2 days")),$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => '')); if($j+1 !=$advertisementscount){ echo ','; } } ?>],
            ['<?php echo date("d M", strtotime("-1 days")).",".date("Y", strtotime("-1 days"));?>', <?php for($j=0;$j< $advertisementscount;$j++){ echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range', date('Y-m-d', strtotime("-1 days")),date('Y-m-d', strtotime("-1 days")),$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => '')); if($j+1 !=$advertisementscount){ echo ','; } } ?>],
            ['<?php echo date("d M", strtotime("-0 days")).",".date("Y", strtotime("-0 days"));?>', <?php for($j=0;$j< $advertisementscount;$j++){ echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range', date('Y-m-d', strtotime("-0 days")),date('Y-m-d', strtotime("-0 days")),$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => '')); if($j+1 !=$advertisementscount){ echo ','; }} ?>]
            
          
          ]);
          // map data for the first series,take value from first column of data set
          <?php 
        for($i=1;$i<=$advertisementscount;$i++)
        {
        
        ?> 
	    var seriesData_<?php echo $i;?> = dataSet.mapAs({x: [0], value: [<?php echo $i;?>]});
        <?php } ?>
          // map data for the second series,take value from second column of data set
          /*var seriesData_2 = dataSet.mapAs({x: [0], value: [2]});

          // map data for the third series, take x from the zero column and value from the third column of data set
          var seriesData_3 = dataSet.mapAs({x: [0], value: [3]});*/

          // create line chart
          chart = anychart.line();

          // turn on chart animation
          chart.animation(true);

          // turn on the crosshair
          chart.crosshair(true);

          // disable one of the chart grids
          chart.grid(0).enabled(false);

          // set container id for the chart
          chart.container('daily_graph');

          // set chart title text settings
          chart.title('Daily');
          
          

          // set yAxis title
          chart.yAxis().title('Clicks');
          chart.yScale().minimum(0);
        //  chart.yScale().ticks().interval(1);
	  //chart.yAxis().maximum(16);

          var seriesStrokeFunction = function(color, style) {
                console.log(style);
            return {color: color, dash: style};
          };

          // temp variable to store series instance
          var series;

          // we can use local variables to change series settings
	  <?php
          for($i=1;$i<=$advertisementscount;$i++)
          {
          ?>
	    series = chart.line(seriesData_<?php echo $i;?>);
	    series.stroke(seriesStrokeFunction(series.color(), '5 5'));
	    series.name('Views');
	    series.markers(true);
          
          <?php } ?>

          

          // turn the legend on
          chart.legend().enabled(true).align('center').fontSize(10);

          // initiate chart drawing
          chart.draw();
	  
	 
	 
	 /*************************** Monthly *********************************/
	<?php 
        //for($i=1;$i<=$advertisementscount;$i++)
        //{
         
        ?> 
	 var dataSet2 = anychart.data.set([
	    ['<?php echo $monthyear11; ?>', <?php for($j=0;$j< $advertisementscount;$j++){ echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_monthly', $prevmonth11,$prevyear11,$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => '')); if($j+1 !=$advertisementscount){ echo ','; } }   ?>],
            ['<?php echo $monthyear10; ?>',<?php for($j=0;$j< $advertisementscount;$j++){ echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_monthly', $prevmonth10,$prevyear10,$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo $monthyear9; ?>', <?php for($j=0;$j< $advertisementscount;$j++){ echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_monthly', $prevmonth9,$prevyear9,$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo $monthyear8; ?>', <?php for($j=0;$j< $advertisementscount;$j++){  echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_monthly', $prevmonth8,$prevyear8,$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo $monthyear7; ?>',<?php for($j=0;$j< $advertisementscount;$j++){  echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_monthly', $prevmonth7,$prevyear7,$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo $monthyear6; ?>', <?php for($j=0;$j< $advertisementscount;$j++){  echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_monthly', $prevmonth6,$prevyear6,$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo $monthyear5; ?>', <?php for($j=0;$j< $advertisementscount;$j++){  echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_monthly', $prevmonth5,$prevyear5,$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo $monthyear4; ?>', <?php for($j=0;$j< $advertisementscount;$j++){  echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_monthly', $prevmonth4,$prevyear4,$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo $monthyear3; ?>', <?php for($j=0;$j< $advertisementscount;$j++){  echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_monthly', $prevmonth3,$prevyear3,$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo $monthyear2; ?>', <?php for($j=0;$j< $advertisementscount;$j++){  echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_monthly', $prevmonth2,$prevyear2,$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo $monthyear1; ?>', <?php for($j=0;$j< $advertisementscount;$j++){  echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_monthly', $prevmonth1,$prevyear1,$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo $monthyear0; ?>',<?php for($j=0;$j< $advertisementscount;$j++){  echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_monthly', $prevmonth0,$prevyear0,$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>]                    
          ]);

          // map data for the first series,take value from first column of data set
          <?php for($i=1;$i<=$advertisementscount;$i++){ ?>
               var seriesData_<?php echo $i;?> = dataSet2.mapAs({x: [0], value: [<?php echo $i;?>]});
	<?php } ?>
          // map data for the second series,take value from second column of data set
          //var seriesData_2 = dataSet1.mapAs({x: [0], value: [2]});

          // map data for the third series, take x from the zero column and value from the third column of data set
          //var seriesData_3 = dataSet1.mapAs({x: [0], value: [3]});

          // create line chart
          chart2 = anychart.line();

          // turn on chart animation
          chart2.animation(true);

          // turn on the crosshair
          chart2.crosshair(true);

          // disable one of the chart grids
          chart2.grid(0).enabled(false);

          // set container id for the chart
          chart2.container('monthly_graph');

          // set chart title text settings
          chart2.title('Monthly');
          
          

          // set yAxis title
          chart2.yAxis().title('Clicks');

          /** We can edit series stroke by function in which context available
           *  @param color - stroke color
           *  @param style - dash lines style
           *  @return string/Object - acgraph.vector.Stroke type (string/Object)

          */
          
          
          var seriesStrokeFunction = function(color, style) {
                
            return {color: color, dash: style};
          };

          // temp variable to store series instance
          var series2;

          // we can use local variables to change series settings
	  <?php 
        for($i=1;$i<=$advertisementscount;$i++)
        {
         
        ?> 
          series2 = chart2.line(seriesData_<?php echo $i;?>);
          series2.stroke(seriesStrokeFunction(series2.color(), '5 5'));
          series2.name('VIew Count');
          series2.markers(true);
	<?php } ?>  
          

          // or just use chaining calls
          //series = chart.line(seriesData_2);
          //series.stroke(seriesStrokeFunction(series.color(), '3 5 10 5'));
         // series.name('Delivery Failure');
          //series.markers(true);

          // or access series by index from chart
         //series = chart.line(seriesData_3);
          //series.stroke(seriesStrokeFunction(series.color(), '2 5'));
          //series.name('Order Cancellation');
          //series.markers(true);

          // turn the legend on
          chart2.legend().enabled(true).align('center').fontSize(10);

          // initiate chart drawing
          chart2.draw();
	  
	  
	  
	  
	  
	   /*************************** Yearly *********************************/
	
	 var dataSet3 = anychart.data.set([
	    ['<?php echo date("Y",strtotime("-11 year"));?>', <?php for($j=0;$j< $advertisementscount;$j++){ echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_yearly', date("Y",strtotime("-11 year")),$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => '')); if($j+1 !=$advertisementscount){ echo ','; } }   ?>],
            ['<?php echo date("Y",strtotime("-10 year"));?>',<?php for($j=0;$j< $advertisementscount;$j++){ echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_yearly', date("Y",strtotime("-10 year")),$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo date("Y",strtotime("-9 year"));?>', <?php for($j=0;$j< $advertisementscount;$j++){ echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_yearly', date("Y",strtotime("-9 year")),$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo date("Y",strtotime("-8 year"));?>', <?php for($j=0;$j< $advertisementscount;$j++){  echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_yearly', date("Y",strtotime("-8 year")),$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo date("Y",strtotime("-7 year"));?>',<?php for($j=0;$j< $advertisementscount;$j++){  echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_yearly', date("Y",strtotime("-7 year")),$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo date("Y",strtotime("-6 year"));?>', <?php for($j=0;$j< $advertisementscount;$j++){  echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_yearly', date("Y",strtotime("-6 year")),$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo date("Y",strtotime("-5 year"));?>', <?php for($j=0;$j< $advertisementscount;$j++){  echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_yearly', date("Y",strtotime("-5 year")),$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo date("Y",strtotime("-4 year"));?>', <?php for($j=0;$j< $advertisementscount;$j++){  echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_yearly', date("Y",strtotime("-4 year")),$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo date("Y",strtotime("-3 year"));?>', <?php for($j=0;$j< $advertisementscount;$j++){  echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_yearly', date("Y",strtotime("-3 year")),$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo date("Y",strtotime("-2 year"));?>', <?php for($j=0;$j< $advertisementscount;$j++){  echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_yearly', date("Y",strtotime("-2 year")),$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo date("Y",strtotime("-1 year"));?>', <?php for($j=0;$j< $advertisementscount;$j++){  echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_yearly', date("Y",strtotime("-1 year")),$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>],
            ['<?php echo date("Y",strtotime("-0 year"));?>',<?php for($j=0;$j< $advertisementscount;$j++){  echo $this->requestAction(array('controller' => 'packages', 'action' => 'total_sale_range_yearly', date("Y",strtotime("-0 year")),$advertisements[$j]['AdvertisementReport']['adv_id'], 'admin'=>false, 'prefix' => ''));  if($j+1 !=$advertisementscount){ echo ','; } }  ?>]                    
          ]);

        <?php 
        for($i=1;$i<=$advertisementscount;$i++)
        {
        ?> 
          // map data for the first series,take value from first column of data set
         var seriesData_<?php echo $i;?> = dataSet3.mapAs({x: [0], value: [<?php echo $i;?>]});
	
	<?php } ?>
          // map data for the second series,take value from second column of data set
          //var seriesData_2 = dataSet1.mapAs({x: [0], value: [2]});

          // map data for the third series, take x from the zero column and value from the third column of data set
          //var seriesData_3 = dataSet1.mapAs({x: [0], value: [3]});

          // create line chart
          chart3 = anychart.line();

          // turn on chart animation
          chart3.animation(true);

          // turn on the crosshair
          chart3.crosshair(true);

          // disable one of the chart grids
          chart3.grid(0).enabled(false);

          // set container id for the chart
          chart3.container('yearly_graph');

          // set chart title text settings
          chart3.title('Yearly');
          
          

          // set yAxis title
          chart3.yAxis().title('Clicks');

          /** We can edit series stroke by function in which context available
           *  @param color - stroke color
           *  @param style - dash lines style
           *  @return string/Object - acgraph.vector.Stroke type (string/Object)

          */
          
          
          var seriesStrokeFunction = function(color, style) {
                
            return {color: color, dash: style};
          };

          // temp variable to store series instance
          var series3;

          // we can use local variables to change series settings
	  <?php 
        for($i=1;$i<=$advertisementscount;$i++)
        {
         
        ?> 
          series3 = chart3.line(seriesData_<?php echo $i;?>);
          series3.stroke(seriesStrokeFunction(series3.color(), '5 5'));
          series3.name('View Count');
          series3.markers(true);
	<?php } ?>  
          

          // or just use chaining calls
          //series = chart.line(seriesData_2);
          //series.stroke(seriesStrokeFunction(series.color(), '3 5 10 5'));
         // series.name('Delivery Failure');
          //series.markers(true);

          // or access series by index from chart
         //series = chart.line(seriesData_3);
          //series.stroke(seriesStrokeFunction(series.color(), '2 5'));
          //series.name('Order Cancellation');
          //series.markers(true);

          // turn the legend on
          chart3.legend().enabled(true).align('center').fontSize(10);

          // initiate chart drawing
          chart3.draw();
	  
	  
    });
    </script>
