<?php 
$Vat_per= Configure::read('VAT_PER');
$userid = $this->Session->read('Auth.User.id');
$adv_id=$Advertisement_det['Advertisement']['id'];
$image_name=$Advertisement_det['Advertisement']['image_name'];
$link=$Advertisement_det['Advertisement']['link'];
$amount=$Advertisement_det['Advertisement']['amount'];
$start_date=date('d/m/Y',strtotime($Advertisement_det['Advertisement']['start_date']));
$end_date=date('d/m/Y',strtotime($Advertisement_det['Advertisement']['end_date']));

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
                                <img src="<?php echo $AdvertiseImg;?>" alt="" style="width: 270px; height: 200px;" />
                                
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
                                    <div class="form-group">
                                        <label>Selected plan</label>
                                        <div class="input-group">
                                            <p>
                                                <?php
                                                $pkg_name=$Advertisement_det['Package']['name'];
                                                $pkg_duration=$Advertisement_det['Package']['duration'];
                                                $pkg_price=$Advertisement_det['Package']['price'];
                                                echo $pkg_name.' - for '.$pkg_duration.' months $'.$pkg_price;
                                                ?>
                                            </p>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div style="clear: both;"></div>
                               <?php if(isset($is_paid) && $is_paid==0){ ?>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="<?php echo $start_date;?>" readonly="readonly">
                                          <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" style="height: 34px"><i class="fa fa-calendar"></i></button>
                                          </span>
                                        </div>
                                    </div>
                                </div>
                                <?php }?>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="<?php echo isset($end_date)?$end_date:'';?>" readonly="readonly">
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
                                        <td class="text-right"><?php echo isset($pkg_duration)?$pkg_duration:'';?></td>
                                    </tr>
                                    <!--<tr>
                                        <td>Per day Charge</td>
                                        <td class="text-right">$25.00</td>
                                    </tr>-->
                                    <tr>
                                        <td>Net Price:</td>
                                        <td class="text-right">$<?php echo isset($pkg_price)?$pkg_price:'';?></td>
                                    </tr>
                                    <tr>
                                        <td>V.A.T.</td>
                                        <td class="text-right"><?php echo isset($Vat_per)?$Vat_per:'';?>%</td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td class="text-right">$<?php echo isset($amount)?$amount:'';?></td>
                                    </tr>
                                    <?php if(isset($is_paid) && $is_paid==0){?>
                                    <tr>
                                        <td colspan="2" class="text-right"><a href="Javascript: void(0);" onclick="formSubmit();" class="btn btn-primary btn-lg">Pay Now</a></td>
                                    </tr>
                                    <?php }?>
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
    <input type="hidden" name="notify_url" value="<?php echo $SITE_URL.'packages/payment_success';?>">
    <input type="hidden" name="return" value="<?php echo $SITE_URL.'packages/payment_success';?>">
    <input type="hidden" name="cancel_return" value="<?php echo $SITE_URL.'packages/advertisement_details/'.base64_encode($adv_id);?>">
    <input type="hidden" name="item_name" value="Advertisement Plan">
    <input type="hidden" name="amount" id="memberFromAmount" value="<?php echo isset($amount)?$amount:'';?>">
    <input type="hidden" name="quantity" value="1">
    <input type="hidden" name="custom" id="memberFromId" value="<?php echo isset($adv_id)?base64_encode($adv_id):'';?>">
    <input type="hidden" name="src" value="1">
    <input type="hidden" name="sra" value="1">
    <input type="hidden" name="rm" value="2">
</form>
<script type="text/javascript">
    function formSubmit(){
    	document.paymentform.submit();
    }

</script>
