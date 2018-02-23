<?php //pr($Advertisement_det);
$Vat_per= Configure::read('VAT_PER');
$userid = $this->Session->read('Auth.User.id');
$adv_id=$Advertisement_det['Advertisement']['id'];
$image_name=$Advertisement_det['Advertisement']['image_name'];
$link=$Advertisement_det['Advertisement']['link'];
$amount=$Advertisement_det['Advertisement']['amount'];
$start_date=date('d/m/Y',strtotime($Advertisement_det['Advertisement']['start_date']));
$end_date=date('d/m/Y',strtotime($Advertisement_det['Advertisement']['end_date']));
$packid = $Advertisement_det['Advertisement']['package_id'];
$is_paid=$Advertisement_det['Advertisement']['is_paid'];
$type=$Advertisement_det['Advertisement']['type'];
$pos=$Advertisement_det['Advertisement']['page_position'];
$uploadPath=WWW_ROOT.'advertisement';
?>

<section class="after_login">
    <div class="container">
        <div class="row">
            <?php echo($this->element('user_leftbar'));?>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Page to display Advert</h4>
                        
                            <?php
                            if(isset($type) && $type==1){
                                if(isset($pos) && $pos!=''){
                                        echo '<p>Home page '.$pos.' banner advert</p>';
                                }
                                else{
                                        echo '<p>Home page Top banner advert</p>';
                                }
                            }elseif(isset($type) && $type==2){
                                echo '<p>Product Detail Page</p>';
                            }elseif(isset($type) && $type==3){
                                echo '<p>Home page banner advert</p>';
                                echo '<p>Product Detail Page</p>';
                            }
                            ?>
                            
                            <div class="up-file">
                                <?php
                                if(isset($image_name) && $image_name!='' && file_exists($uploadPath . '/' . $image_name)){
                                    $AdvertiseImg=$this->webroot.'advertisement/'.$image_name;
                                }else{
                                    $AdvertiseImg=$this->webroot.'shop_images/img.png';
                                }
                                ?>
                                <img src="<?php echo $AdvertiseImg;?>" alt="" style="width: 270px; height: 200px;"/>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Shop Link</label>
                                        <div class="input-group">
                                            <p><?php echo isset($link)?$link:'';?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group" id="selectedpln">
                                        <label>Selected plan</label>
                                        <div class="input-group">
                                            <p>
                                                <?php
                                                $pkg_name=$Advertisement_det['Package']['name'];
                                                $pkg_duration=$Advertisement_det['Package']['duration'];
                                                $pkg_price=$Advertisement_det['Package']['price'];
                                                echo $pkg_name.' - for '.$pkg_duration.' months $'.$pkg_price;
                                                ?>
                                                <input type="hidden" class="form-control" id="pkgdur" value="<?php echo $pkg_duration;?>">
                                                <input type="hidden" name="data[Advertisement][package_id]" class="form-control" id="pkgid" value="<?php echo $packid;?>">
                                                <input type="hidden" name="packageprice" id="packageprice"  class="form-control" value="<?php echo $pkg_price;?>">
                                                <input type="hidden" name="advtotal" id="advtotal"  class="form-control" value="<?php echo $amount;?>">
                                                <input type="hidden" name="" class="form-control" id="isplnchang" value="0">
                                                <span style="padding:10px;color:#0099ff;cursor:pointer;" id="plnchng">Change</span>
                                            </p>
                                         </div>
                                    </div>
                                    
                                        
                                     <div class="col-sm-12" id="renewpln" style="display:none;">
                                        <div class="form-group" >
					    <label>Select Plan</label>
					    <div class="input-group">
						<select class="form-control" id="adpackg" onchange="selectDateFirst(this.value)">
						    <option value="">Select plan</option>
						    <?php
						     if(count($package_list)>0){
							foreach ($package_list as $pkg): 
							    $pkg_id=$pkg['Package']['id'];
							    $pkg_name=$pkg['Package']['name'];
							    $pkg_duration=$pkg['Package']['duration'];
							    $pkg_price=$pkg['Package']['price'];
						    ?>
						    <option value="<?php echo $pkg_id;?>"> <?php echo $pkg_name.' - for '.$pkg_duration.' months $'.$pkg_price;?></option>
						    <?php
							endforeach;
						     }
						    ?>

						</select>
					    </div>
					</div>
			             </div>
                                </div>
                                <div style="clear: both;"></div>
                                <div class="col-sm-6">
                                    <div class="form-group" >
                                        <label>Start Date</label>
                                        <div class="input-group" id="startDateDiv">
                                            <input type="text" class="form-control" id="datepicker" required value="<?php //if(isset($is_paid) && $is_paid==0){ echo isset($start_date)?$start_date:'';}?>" >
                                            <label for="datepicker" class="input-group-addon"  id="calimg">
                                                <span class="fa fa-calendar"></span>
					    </label>
                                         <!-- <label for="datepicker" class="input-group-btn">
                                                <button class="btn btn-default" type="button" style="height: 34px"><i class="fa fa-calendar"></i></button>
                                          </label>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="enddate" value="<?php //echo isset($end_date)?$end_date:'';?>" readonly="readonly">
                                          <span class="input-group-btn">
                                           <button class="btn btn-default" type="button" style="height: 34px"><i class="fa fa-calendar"></i></button>
                                          </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                      
                       <div class="table-responsive">
                            <table class="table advertise-table">
                                <thead>
                                    <th colspan="2">Summary</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Banner to Display</td>
                                        <td class="text-right"><?php
                            if(isset($type) && $type==1){
                                if(isset($pos) && $pos!=''){
                                        echo '<p>Home page '.$pos.' banner advert</p>';
                                }
                                else{
                                        echo '<p>Home page Top banner advert</p>';
                                }
                                //echo '<p>Home page banner advert</p>';
                            }elseif(isset($type) && $type==2){
                                echo '<p>Product Detail Page</p>';
                            }elseif(isset($type) && $type==3){
                                echo '<p>Home page banner advert</p>';
                                echo '<p>Product Detail Page</p>';
                            }
                            ?></td>
                                    </tr>
                                    <tr>
                                        <td>No. of months</td>
                                        <td class="text-right" id="duration"><?php echo isset($Advertisement_det['Package']['duration'])?$Advertisement_det['Package']['duration']:'';?></td>
                                    </tr>
                                    <!--<tr>
                                        <td>Per day Charge</td>
                                        <td class="text-right">$25.00</td>
                                    </tr>-->
                                    <tr>
                                        <td>Net Price:</td>
                                        <td class="text-right" id="netPrice">$<?php echo isset($Advertisement_det['Package']['price'])?$Advertisement_det['Package']['price']:'';?></td>
                                    </tr>
                                    <tr>
                                        <td>V.A.T.</td>
                                        <td class="text-right" id="vat"><?php echo isset($Vat_per)?$Vat_per:'';?>%</td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td class="text-right" id="total">$<?php echo isset($amount)?$amount:'';?></td>
                                    </tr>
                                    <?php //if(isset($is_paid) && $is_paid==0){?>
                                    <tr>
                                        <td colspan="2" class="text-right"><a href="Javascript: void(0);" onclick="formSubmit();" class="btn btn-primary btn-lg" >Pay Now</a></td>
                                    </tr>
                                    <?php //}?>
                                </tbody>
                            </table>
                        </div>
                          
                    </div>
                </div>
					
            </div>
        </div>

    </div>
</section>

<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="paymentform">
    <input type="hidden" name="cmd" value="_xclick">
    <input type="hidden" name="business" value="<?php echo $sitesetting['SiteSetting']['paypal_email'];?>">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="notify_url" value="<?php echo $SITE_URL.'packages/payment_renew_success';?>">
    <input type="hidden" name="return" value="<?php echo $SITE_URL.'packages/payment_renew_success';?>">
    <input type="hidden" name="cancel_return" value="<?php echo $SITE_URL.'packages/advertisement_details/'.base64_encode($adv_id);?>">
    <input type="hidden" name="item_name" value="Advertisement Plan">
    <input type="hidden" name="amount" id="memberFromAmount" value="<?php echo isset($amount)?$amount:'';?>">
    <input type="hidden" name="quantity" value="1">
    <input type="hidden" name="custom" id="custom" value="">
    <input type="hidden" name="src" value="1">
    <input type="hidden" name="sra" value="1">
    <input type="hidden" name="rm" value="2">
</form>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script>
var adv_id = '<?php echo base64_encode($adv_id);?>';
var disableddates = ["<?php echo $allbdates;?>"];
    function formSubmit(){
        var isPanChange = $('#isplnchang').val();
        var pkgDur = $('#pkgdur').val();
	var pkgID = $('#pkgid').val();
	var start_date = $('#datepicker').val();
	var end_date = $('#enddate').val();
	if(isPanChange==0){
	        if(start_date==''){
	        //alert('select date');
	                $('#startDateDiv').attr('style','border:1px solid red');
	                return false;
	        }
	        else{
	           $('#startDateDiv').removeAttr('style');
	                a = disableddates.indexOf(end_date); 
	                console.log(a);
	                if(!a || a == -1){
	                        document.paymentform.submit();
	                }
	                else{
	                        alert('Please Choose other package as your package end dates are already booked');
	                        return false;
	                }
	        }
	}
	else if(isPanChange==1){
	        if(start_date==''){
	                $('#startDateDiv').attr('style','border:1px solid red');
	                return false;
	        }
	        else{
	         $('#startDateDiv').removeAttr('style');
	                a = disableddates.indexOf(end_date); 
	                 console.log(a);
	                if(!a || a == -1){
	                        document.paymentform.submit();
	                }
	                else{
	                        alert('Please Choose other package as your package end dates are already booked');
	                        return false;
	                }
	        }
    	}
    }





function DisableSpecificDates(date) {
    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
    return [disableddates.indexOf(string) == -1];
  }
  
$(document).ready(function(){
/* var pkgdur = parseInt($('#pkgdur').val());
 var pkgid = parseInt($('#pkgid').val());
 console.log(pkgdur);*/
 var dateToday = new Date();
        $('#datepicker').datepicker({
		beforeShowDay: DisableSpecificDates,
        	dateFormat:'yy-mm-dd',
        	//changeMonth: true,
	        //changeYear: true,
	        minDate: dateToday,
	     //maxDate: +80,
	     yearRange: "-150:+1",
	     
             onSelect: function(dateText, instance) {
                date = $.datepicker.parseDate(instance.settings.dateFormat, dateText, instance.settings);
                 var pkgdur = parseInt($('#pkgdur').val());
                 var pkgid = parseInt($('#pkgid').val());
                console.log(pkgdur);
                date.setMonth(date.getMonth() + pkgdur);
                $("#enddate").datepicker({dateFormat: "yy-mm-dd"});
                console.log(date);
                
                /*var m = (date.getMonth()+1);
                var d = date.getDate();
                var y = date.getFullYear();
        
                var end_date = y+'-'+m+'-'+d;
                console.log(end_date);*/
                $("#enddate").datepicker('setDate',date);
                var sdate = $('#datepicker').val();
                var edate = $('#enddate').val();
                var custom = adv_id+'##'+pkgid+'##'+sdate+'##'+edate;
                $('#custom').val(custom);
            }
        });
	
	$('#plnchng').click(function(){
	//alert('hiii');
                $('#selectedpln').prop('display','none');
                //alert('hiii');
                $('#renewpln').removeAttr('style');
                //alert('hiii');
                $('#renewpln').prop('display','block');
        })
});

function changeDate(date){
        console.log(date);
        //var x = 2; or whatever offset
        var pkgdur = $('#pkgdur').val();
        var CurrentDate = new Date(date);
        console.log(CurrentDate);
        var enddate = CurrentDate.setMonth(CurrentDate.getMonth() + pkgdur);
        console.log(enddate);
        
        var m = (enddate.getMonth()+1);
        var d = enddate.getDate();
        var y = enddate.getFullYear();
        
        var end_date = y+'-'+m+'-'+d;
        console.log(end_date);
}

function selectDateFirst(id){
    /*var selectDate = $('#datepicker').val();
    if(selectDate==''){
	alert('Please select the date first');
	$('#adpackg').val('');
	return false;
    }
    else{*/
	if(id!=''){
	        $.ajax({
	                url:'<?php echo $this->webroot?>packages/getdetail/'+id,
	                success:function(msg){
	                        var value = msg.split('**');
	                       // alert(msg);
	                       $('#pkgdur').empty();
	                       
	                       $('#pkgid').val(value[0]);
	                       $('#pkgdur').val(value[1]);
	                       $('#packageprice').val(value[2]);
	                       $('#advtotal').val(value[3]);
	                       
	                       
	                       $('#duration').html(value[1]);
	                       $('#netPrice').html('$ '+parseFloat(value[2]));
	                       $('#total').html('$ '+parseFloat(value[3]));
	                       
	                       $('#memberFromAmount').val(value[3]);
	                       
	                       
	                       $('#isplnchang').val(1);
	                       $('#datepicker').val('');
	                       $('#enddate').val('');
	                }
	        
	        
	        });
	
	}
	else{
	        $('#pkgid').val(0);
	        $('#pkgdur').val(0);
	        $('#packageprice').val(0);
	        $('#advtotal').val(0);
	       
	        $('#isplnchang').val(0);
	        $('#datepicker').val('');
	        $('#enddate').val('');
	        alert('Please select a plan');
	        return false;
	}
    //}
    
} 
</script>  
