<section class="signin_sec">
    	<div class="container">
        	<div class="row">
            	<div class="profile_rapper">
                  <?php echo($this->element('user_leftbar'));?>      
                  <div class="col-md-9">
                     <div class="personal_profile">
                         <div class="personal_tables">  
                                <div class="personal_title">
                                    <p><?php echo $getspa['Spa']['title'];?></p>
                                </div>                    
                                <div class="protable_title">
                                        <p>Contact</p>
                                        <div class="clearfix"></div>
                                        <span id="cn_validation_err_msg"></span>
                                    </div>
                                <div class="personal_desc personal_edit"> 
                                <form class="form-horizontal" method="post" action=''>
								<input type="hidden" name="data[Spa][address_id]" value="<?php echo(!empty($spaAddress)?$spaAddress['SpaAddress']['id']:'0');?>" id="address_id"/>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Spa Address*</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border:0px;">
                                        <textarea style="height:190px;width:100%;padding:4px 11px;border-radius:4px;" id="address" name="data[Spa][address]"><?php echo(!empty($spaAddress)?$spaAddress['SpaAddress']['address']:'');?></textarea>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Unit*</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border:0px;">
                                        <input class="form-control" id="unit" type="text" name="data[Spa][unit]" style="margin-bottom:10px;" value="<?php echo(!empty($spaAddress)?$spaAddress['SpaAddress']['unit']:'');?>">
                                    </div>
                                    <p style="margin-left:18.5%;"><b>Note:</b> If none say N/A.</p>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Buzzer*</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border:0px;">
                                        <input class="form-control" id="buzzer" type="text" name="data[Spa][buzzer]" style="margin-bottom:10px;" value="<?php echo(!empty($spaAddress)?$spaAddress['SpaAddress']['buzzer']:'');?>">
                                    </div>
                                    <p style="margin-left:18.5%;"><b>Note:</b> If none say N/A.</p>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Country*</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border-radius: 2px;">
                                        <select class="form-control" id="country" name="data[Spa][country]" onchange="getstates();">
                                          <option value="">Select Country</option>
                                          <?php
                                          if(isset($countries) and !empty($countries))
										  {
											foreach ($countries as $country_id=>$country){    
                                          ?>
											<option value="<?php echo $country_id;?>" <?php echo(!empty($spaAddress)?($country_id==$spaAddress['SpaAddress']['country_id']?'Selected':''):'');?>><?php echo $country?></option>
                                          <?php }
										  }?>
                                        </select>
                                    </div>
                                  </div> 
                                    <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">State/Province*</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border-radius:2px;">
                                    
                                        <select class="form-control" id="state" name="data[Spa][state]" onchange="getcities();">
                                          <option value="">Select State</option>    
                                          
                                        </select>
                                    
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">City*</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border-radius: 2px;">
                                        <select class="form-control" id="city" name="data[Spa][city]" onchange="getareas();">
                                          <option value="">Select City</option>
                                          
                                        </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Area*</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border-radius: 2px;">
                                    <select class="form-control" id="area" name="data[Spa][area]">
                                          <option value="">Select Area</option>
                                          
                                        </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Zip/Postal Code*</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border:0px;">
                                        <input class="form-control" id="zip" type="text" name="data[Spa][zip]" style="margin-bottom:10px;" value="<?php echo(!empty($spaAddress)?$spaAddress['SpaAddress']['zip']:'');?>">
                                    </div>
                                  </div>
                                   <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Phone*</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border:0px;">
                                        <input class="form-control" id="phone" type="text" name="data[Spa][phone]" style="margin-bottom:10px;" value="<?php echo(!empty($spaAddress)?$spaAddress['SpaAddress']['phone']:'');?>">
                                    </div>
                                  </div>
                                   <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Email*</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border:0px;">
                                        <input class="form-control" id="email" type="text" name="data[Spa][email]" style="margin-bottom:10px;" value="<?php echo(!empty($spaAddress)?$spaAddress['SpaAddress']['email']:'');?>">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Website</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border:0px;">
                                        <input class="form-control" id="website" type="text" name="data[Spa][website]" style="margin-bottom:10px;" value="<?php echo(!empty($spaAddress)?$spaAddress['SpaAddress']['website']:'');?>">
                                    </div>
                                  </div>
                                    <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Hours of Operation</label>
                                    
									<?php 
									?>
									<div id="dispDiv" >
									<div class="form-group">
									<label for="inputPassword3" class="col-sm-2 control-label"></label>
									<div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border:0px;">
                                        <br>
                                        Monday<br>
           <select name="Monday_start" class="form-control schedule" id="start_Monday" style="border: 1px solid #ccc;
float: left;margin-right: 10px;border-radius:2px;">
                                            <option value="">Open</option> 
                                            <?php
                                            for($i=7;$i<=23;$i++)
                                            {
												if($i==12)
												{
												$val=$i." PM";        
												}    
												else if($i>12)
												{
												$j=$i-12;
												$val=$j." PM";        
												}
												else{
												 $val=$i." AM";    
												}
												$mselect='';
												if(!empty($Monday))
												{
													$mexp=explode(':',$Monday['Schedule']['start']);
													$mselect = ($mexp[0]==$i)?'selected':'';	
												}
                                            ?>
												<option value="<?php echo $i.":00:00";?>" <?php echo $mselect;?>><?php echo $val;?></option>
                                            <?php
                                            }
                                            ?>
                                            
                                        </select>
                                        <select name="Monday_end" class="schedule" id="end_Monday" style="border: 1px solid #ccc;
float: left;margin-right: 10px;border-radius:2px;">
                                            <option value="">Close</option> 
                                            <?php
                                            for($i=7;$i<=23;$i++)
                                            {
                                            if($i==12)
                                            {
                                            $val=$i." PM";        
                                            }     
                                            else if($i>12)
                                            {
                                            $j=$i-12;
                                            $val=$j." PM";        
                                            }
                                            else{
                                             $val=$i." AM" ;   
                                            }
											$mselect='';
												if(!empty($Monday))
												{
													$mexp=explode(':',$Monday['Schedule']['end']);
													$mselect = ($mexp[0]==$i)?'selected':'';	
												}
                                            ?>
                                            <option value="<?php echo $i.":00:00";?>" <?php echo $mselect;?>><?php echo $val;?></option>
                                            <?php
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                  </div> 
                                    <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label"></label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border:0px;">
                                        <br>
                                        Tuesday<br>
                                        <select name="Tuesday_start" class="form-control schedule" id="start_Tuesday" style="border: 1px solid #ccc;
float: left;margin-right: 10px;border-radius:2px;">
                                            <option value="">Open</option> 
                                            <?php
                                            for($i=7;$i<=23;$i++)
                                            {
                                            if($i==12)
                                            {
                                            $val=$i." PM";        
                                            }    
                                            else if($i>12)
                                            {
                                            $j=$i-12;
                                            $val=$j." PM";        
                                            }
                                            else{
                                             $val=$i." AM";    
                                            }
											$mselect='';
												if(!empty($Tuesday))
												{
													$mexp=explode(':',$Tuesday['Schedule']['start']);
													$mselect = ($mexp[0]==$i)?'selected':'';	
												}
                                            ?>
                                            <option value="<?php echo $i.":00:00";?>" <?php echo $mselect;?>><?php echo $val;?></option>
                                            <?php
                                            }
                                            ?>
                                            
                                        </select>
                                        <select name="Tuesday_end" class="schedule" id="end_Tuesday" style="border: 1px solid #ccc;
float: left;margin-right: 10px;border-radius:2px;">
                                            <option value="">Close</option> 
                                            <?php
                                            for($i=7;$i<=23;$i++)
                                            {
                                            if($i==12)
                                            {
                                            $val=$i." PM";        
                                            }     
                                            else if($i>12)
                                            {
                                            $j=$i-12;
                                            $val=$j." PM";        
                                            }
                                            else{
                                             $val=$i." AM" ;   
                                            }
											$mselect='';
												if(!empty($Tuesday))
												{
													$mexp=explode(':',$Tuesday['Schedule']['end']);
													$mselect = ($mexp[0]==$i)?'selected':'';	
												}
                                            ?>
                                            <option value="<?php echo $i.":00:00";?>" <?php echo $mselect;?>><?php echo $val;?></option>
                                            <?php
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                  </div>
                                    <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label"></label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border:0px;">
                                        <br>
                                        Wednesday<br>
                             <select name="Wednesday_start" class="form-control schedule" id="start_Wednesday" style="border: 1px solid #ccc;
float: left;margin-right: 10px;border-radius:2px;">
                                            <option value="">Open</option> 
                                            <?php
                                            for($i=7;$i<=23;$i++)
                                            {
                                            if($i==12)
                                            {
                                            $val=$i." PM";        
                                            }    
                                            else if($i>12)
                                            {
                                            $j=$i-12;
                                            $val=$j." PM";        
                                            }
                                            else{
                                             $val=$i." AM";    
                                            }
											$mselect='';
												if(!empty($Wednesday))
												{
													$mexp=explode(':',$Wednesday['Schedule']['start']);
													$mselect = ($mexp[0]==$i)?'selected':'';	
												}
                                            ?>
                                            <option value="<?php echo $i.":00:00";?>" <?php echo $mselect;?>><?php echo $val;?></option>
                                            <?php
                                            }
                                            ?>
                                            
                                        </select>
                                        <select name="Wednesday_end" class="schedule" id="end_Wednesday" style="border: 1px solid #ccc;
float: left;margin-right: 10px;border-radius:2px;">
                                            <option value="">Close</option> 
                                            <?php
                                            for($i=7;$i<=23;$i++)
                                            {
                                            if($i==12)
                                            {
                                            $val=$i." PM";        
                                            }     
                                            else if($i>12)
                                            {
                                            $j=$i-12;
                                            $val=$j." PM";        
                                            }
                                            else{
                                             $val=$i." AM" ;   
                                            }
											$mselect='';
												if(!empty($Wednesday))
												{
													$mexp=explode(':',$Wednesday['Schedule']['end']);
													$mselect = ($mexp[0]==$i)?'selected':'';	
												}
                                            ?>
                                            <option value="<?php echo $i.":00:00";?>" <?php echo $mselect;?>><?php echo $val;?></option>
                                            <?php
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                  </div>
                                    <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label"></label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border:0px;">
                                        <br>
                                        Thursday<br>
                                        <select name="Thursday_start" class="form-control schedule" id="start_Thursday" style="border: 1px solid #ccc;
float: left;margin-right: 10px;border-radius:2px;">
                                            <option value="">Open</option> 
                                            <?php
                                            for($i=7;$i<=23;$i++)
                                            {
                                            if($i==12)
                                            {
                                            $val=$i." PM";        
                                            }    
                                            else if($i>12)
                                            {
                                            $j=$i-12;
                                            $val=$j." PM";        
                                            }
                                            else{
                                             $val=$i." AM";    
                                            }
											$mselect='';
												if(!empty($Thursday))
												{
													$mexp=explode(':',$Thursday['Schedule']['start']);
													$mselect = ($mexp[0]==$i)?'selected':'';	
												}
                                            ?>
                                            <option value="<?php echo $i.":00:00";?>" <?php echo $mselect;?>><?php echo $val;?></option>
                                            <?php
                                            }
                                            ?>
                                            
                                        </select>
                                        <select name="Thursday_end" class="form-control schedule" id="end_Thursday" style="border: 1px solid #ccc;
float: left;margin-right: 10px;border-radius:2px;">
                                            <option value="">Close</option> 
                                            <?php
                                            for($i=7;$i<=23;$i++)
                                            {
                                            if($i==12)
                                            {
                                            $val=$i." PM";        
                                            }     
                                            else if($i>12)
                                            {
                                            $j=$i-12;
                                            $val=$j." PM";        
                                            }
                                            else{
                                             $val=$i." AM" ;   
                                            }
											$mselect='';
												if(!empty($Thursday))
												{
													$mexp=explode(':',$Thursday['Schedule']['end']);
													$mselect = ($mexp[0]==$i)?'selected':'';	
												}
                                            ?>
                                            <option value="<?php echo $i.":00:00";?>" <?php echo $mselect;?>><?php echo $val;?></option>
                                            <?php
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                  </div>
                                    <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label"></label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border:0px;" >
                                        <br>
                                        Friday<br>
                                        <select name="Friday_start" class="form-control schedule" id="start_Friday" style="border: 1px solid #ccc;
float: left;margin-right: 10px;border-radius:2px;">
                                            <option value="">Open</option> 
                                            <?php
                                            for($i=7;$i<=23;$i++)
                                            {
                                            if($i==12)
                                            {
                                            $val=$i." PM";        
                                            }    
                                            else if($i>12)
                                            {
                                            $j=$i-12;
                                            $val=$j." PM";        
                                            }
                                            else{
                                             $val=$i." AM";    
                                            }
											$mselect='';
												if(!empty($Friday))
												{
													$mexp=explode(':',$Friday['Schedule']['start']);
													$mselect = ($mexp[0]==$i)?'selected':'';	
												}
                                            ?>
                                            <option value="<?php echo $i.":00:00";?>" <?php echo $mselect;?>><?php echo $val;?></option>
                                            <?php
                                            }
                                            ?>
                                            
                                        </select>
                                        <select name="Friday_end" class="form-control schedule" id="end_Friday" style="border: 1px solid #ccc;
float: left;margin-right: 10px;border-radius:2px;">
                                            <option value="">Close</option> 
                                            <?php
                                            for($i=7;$i<=23;$i++)
                                            {
                                            if($i==12)
                                            {
                                            $val=$i." PM";        
                                            }     
                                            else if($i>12)
                                            {
                                            $j=$i-12;
                                            $val=$j." PM";        
                                            }
                                            else{
                                             $val=$i." AM" ;   
                                            }
											$mselect='';
												if(!empty($Friday))
												{
													$mexp=explode(':',$Friday['Schedule']['end']);
													$mselect = ($mexp[0]==$i)?'selected':'';	
												}
                                            ?>
                                            <option value="<?php echo $i.":00:00";?>" <?php echo $mselect;?>><?php echo $val;?></option>
                                            <?php
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                  </div>
                                    <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label"></label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border:0px;">
                                        <br>
                                        Saturday<br>
                                        <select name="Saturday_start" class="form-control schedule" id="start_Saturday" style="border: 1px solid #ccc;
float: left;margin-right: 10px;border-radius:2px;">
                                            <option value="">Open</option> 
                                            <?php
                                            for($i=7;$i<=23;$i++)
                                            {
                                            if($i==12)
                                            {
                                            $val=$i." PM";        
                                            }    
                                            else if($i>12)
                                            {
                                            $j=$i-12;
                                            $val=$j." PM";        
                                            }
                                            else{
                                             $val=$i." AM";    
                                            }
											$mselect='';
												if(!empty($Saturday))
												{
													$mexp=explode(':',$Saturday['Schedule']['start']);
													$mselect = ($mexp[0]==$i)?'selected':'';	
												}
                                            ?>
                                            <option value="<?php echo $i.":00:00";?>" <?php echo $mselect;?>><?php echo $val;?></option>
                                            <?php
                                            }
                                            ?>
                                            
                                        </select>
                                        <select name="Saturday_end" class="form-control schedule" id="end_Saturday" style="border: 1px solid #ccc;
float: left;margin-right: 10px;border-radius:2px;">
                                            <option value="">Close</option> 
                                            <?php
                                            for($i=7;$i<=23;$i++)
                                            {
                                            if($i==12)
                                            {
                                            $val=$i." PM";        
                                            }     
                                            else if($i>12)
                                            {
                                            $j=$i-12;
                                            $val=$j." PM";        
                                            }
                                            else{
                                             $val=$i." AM" ;   
                                            }
											$mselect='';
												if(!empty($Saturday))
												{
													$mexp=explode(':',$Saturday['Schedule']['end']);
													$mselect = ($mexp[0]==$i)?'selected':'';	
												}
                                            ?>
                                            <option value="<?php echo $i;?>" <?php echo $mselect;?>><?php echo $val;?></option>
                                            <?php
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                  </div>
                                    <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label"></label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border:0px;">
                                        <br>
                                        Sunday<br>
                                        <select name="Sunday_start" class="form-control schedule" id="start_Sunday" style="border: 1px solid #ccc;
float: left;margin-right: 10px; border-radius:2px;">
                                            <option value="">Open</option> 
                                            <?php
                                            for($i=7;$i<=23;$i++)
                                            {
                                            if($i==12)
                                            {
                                            $val=$i." PM";        
                                            }    
                                            else if($i>12)
                                            {
                                            $j=$i-12;
                                            $val=$j." PM";        
                                            }
                                            else{
                                             $val=$i." AM";    
                                            }
											$mselect='';
												if(!empty($Sunday))
												{
													$mexp=explode(':',$Sunday['Schedule']['start']);
													$mselect = ($mexp[0]==$i)?'selected':'';	
												}
                                            ?>
                                            <option value="<?php echo $i.":00:00";?>" <?php echo $mselect;?>><?php echo $val;?></option>
                                            <?php
                                            }
                                            ?>
                                            
                                        </select>
                                        <select name="Sunday_end" class="form-control schedule" id="end_Sunday" style="border: 1px solid #ccc;
float: left;margin-right: 10px; border-radius:2px;">
                                            <option value="">Close</option> 
                                            <?php
                                            for($i=7;$i<=23;$i++)
                                            {
                                            if($i==12)
                                            {
                                            $val=$i." PM";        
                                            }     
                                            else if($i>12)
                                            {
                                            $j=$i-12;
                                            $val=$j." PM";        
                                            }
                                            else{
                                             $val=$i." AM" ;   
                                            }
											$mselect='';
												if(!empty($Sunday))
												{
													$mexp=explode(':',$Sunday['Schedule']['end']);
													$mselect = ($mexp[0]==$i)?'selected':'';	
												}
                                            ?>
                                            <option value="<?php echo $i.":00:00";?>" <?php echo $mselect;?>><?php echo $val;?></option>
                                            <?php
                                            }
                                            ?>
                                            
                                        </select>
                                    </div>
                                  </div>
									</div>
									
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Spa Type*</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border-radius: 2px;">
                                        <select class="form-control" id="location_type" name="data[Spa][location_type]">
                                          <option value="">Select Option</option>
                                          <option value="Home Spa"  <?php echo(!empty($spaAddress)?($spaAddress['SpaAddress']['location_type']=='Home Spa'?'Selected':''):'');?>>Home Spa</option>
                                          <option value="Clinic" <?php echo(!empty($spaAddress)?($spaAddress['SpaAddress']['location_type']=='Clinic'?'Selected':''):'');?>>Clinic</option>
                                        </select>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Walk-ins Welcome?*</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border-radius: 2px;">
                                        <select class="form-control" id="walkin_welcome" name="data[Spa][walkin_welcome]">
                                          <option value="">Select Option</option>
                                          <option value="1"  <?php echo(!empty($spaAddress)?($spaAddress['SpaAddress']['walkin_welcome']=='1'?'Selected':''):'');?>>Yes</option>
                                          <option value="0" <?php echo(!empty($spaAddress)?($spaAddress['SpaAddress']['walkin_welcome']=='0'?'Selected':''):'');?>>No</option>
                                        </select>
                                    </div>
                                    <p style="margin-left:18.5%;"><b>Note:</b> If you choose 'No' viewers will see the following message: "Please contact prior to arrival – all bookings must be confirmed in advance"</p>
                                  </div>
                                  <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Social Media</label>
                                    <div class="styled-select slate col-sm-10" style="width:79.7%;margin-left:16px;border:0px;">
                                        Facebook<br>
                                        <input class="form-control" id="facebook" type="text" name="data[Spa][facebook]" style="margin-bottom:10px;" value="<?php echo(!empty($spaAddress)?$spaAddress['SpaAddress']['facebook']:'');?>">
                                        Twitter<br>
                                        <input class="form-control" id="twitter type="text" name="data[Spa][twitter]" style="margin-bottom:10px;" value="<?php echo(!empty($spaAddress)?$spaAddress['SpaAddress']['twitter']:'');?>">
                                        Linkedin<br>
                                        <input class="form-control" id="linkedin" type="text" name="data[Spa][linkedin]" style="margin-bottom:10px;" value="<?php echo(!empty($spaAddress)?$spaAddress['SpaAddress']['linkedin']:'');?>">
                                        GPlus<br>
                                        <input class="form-control" id="gplus" type="text" name="data[Spa][gplus]" style="margin-bottom:10px;" value="<?php echo(!empty($spaAddress)?$spaAddress['SpaAddress']['gplus']:'');?>">
                                        Instagram<br>
                                        <input class="form-control" id="instagram" type="text" name="data[Spa][instagram]" style="margin-bottom:10px;" value="<?php echo(!empty($spaAddress)?$spaAddress['SpaAddress']['instagram']:'');?>">
                                        Flickr<br>
                                        <input class="form-control" id="flickr" type="text" name="data[Spa][flickr]" style="margin-bottom:10px;" value="<?php echo(!empty($spaAddress)?$spaAddress['SpaAddress']['flickr']:'');?>">
                                        Youtube<br>
                                        <input class="form-control" id="youtube" type="text" name="data[Spa][youtube]" style="margin-bottom:10px;" value="<?php echo(!empty($spaAddress)?$spaAddress['SpaAddress']['youtube']:'');?>">
                                    </div>
                                  </div>
                                   
                                    <input type="hidden" id="monday" name="Monday" value=""> 
                                    <input type="hidden" id="tuesday" name="Tuesday" value="">  
                                    <input type="hidden" id="wednesday" name="Wednesday" value="">  
                                    <input type="hidden" id="thursday" name="Thursday" value="">  
                                    <input type="hidden" id="friday" name="Friday" value="">  
                                    <input type="hidden" id="saturday" name="Saturday" value="">
                                    <input type="hidden" id="saturday" name="Sunday" value="">  
                                  <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                      <button type="submit" class="btn btn-default signin" id="overviewbtn" onclick="return contact_validate();">Save</button>
                                    </div>
                                  </div>
                                </form>                                
                            	</div>              
                        </div>                         
                    </div>
                  </div>      
                </div>
            </div>
        </div>
    </section>
<style>
 .schedule{ width:31% !important;}   
</style>

