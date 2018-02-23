<?php 
//$Ord_sl_no=10000000;
$userid = $this->Session->read('Auth.User.id');
$Ord_sl_no= Configure::read('ORDER_SL_NO');
foreach ($orderdetails as $orderdetail){
    $order_id=$orderdetail['OrderDetail']['order_id'];
    $order_user_id=$orderdetail['OrderDetail']['user_id'];
    /*$order_id=$orderdetail['Shop']['order_id'];
    $order_id=$orderdetail['Shop']['order_id'];
    $order_id=$orderdetail['Shop']['order_id'];
    $order_id=$orderdetail['Shop']['order_id'];
    $order_id=$orderdetail['Shop']['order_id'];*/
    //$order_id=$orderdetail['OrderDetail']['order_id'];
    //$order_id=$orderdetail['OrderDetail']['order_id'];
}
if($order_id!=''){
    $Seller_info=$this->requestAction(array('controller' => 'orders', 'action' => 'get_seller_details', $order_id, 'admin'=>false, 'prefix' => ''));
    $store_name=isset($Seller_info['Shop']['name'])?$Seller_info['Shop']['name']:'';
    $store_id=isset($Seller_info['Shop']['id'])?$Seller_info['Shop']['id']:'';
    $store_logo=isset($Seller_info['Shop']['logo'])?$Seller_info['Shop']['logo']:'';
    $shipping_cost=isset($Seller_info['OrderDetail']['shipping_cost'])?$Seller_info['OrderDetail']['shipping_cost']:'';
    $order_status=isset($Seller_info['OrderDetail']['order_status'])?$Seller_info['OrderDetail']['order_status']:'';
    $sl_no=$Ord_sl_no+$order_id;
}

?>

<section class="after_login">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-7">
                    <!--<div class="breadcmb">
                            <a href="">Dispute List</a> > <a href="" class="active">Dispute Detail</a>
                    </div>-->
                    <h4>Order Detail</h4>
                    <div class="detail-info-hold Dtls">
                        <div class="row">
                            <div class="col-md-6">
                                    <p><span>Order No:</span> <?php echo isset($sl_no)?$sl_no:'';?></p>
                                    <!--<p><span>Tracking No:</span> 6006007848</p>-->
                            </div>
                            <div class="col-md-6">
                                    <!--<p class="text-success"><span>Status:</span> Awaiting Response</p>-->
                                    <p><span>Store:</span> <a href="<?php echo $this->webroot.'shops/details/'.base64_encode($store_id);?>"><?php echo isset($store_name)?$store_name:'';?> </a></p>
                            </div>
                        </div>
                    </div>
            </div>
            <!--<div class="col-md-4 col-sm-5">
                <div class="detail-info-hold prod-short-desc">
                    <h4><?php echo isset($store_name)?$store_name:'';?></h4>
                    <p><b>Tracking No:</b> 8885296CN</p>
                    <p><b>Website:</b> www.test.com</p>
                    <p><b>Estimated Delivery Time:</b> 15-39</p>
                    <p><b>DaysProcessing Time:</b>7 Days</p>
                </div>
            </div>-->
        </div>
        <div class="row">
            <div class="col-lg-12">
                    <h4>Product Info</h4>
                    <div class="detail-info-hold">
                        <div class="table-responsive">
                            <table class="table prod-info-table">
                                    <thead>
                                        <tr>
                                            <th>Product Details</th>
                                            <th>Unit Price:</th>
                                            <th>Quantity:</th>
                                            <th>Order Total</th>
                                            <th>Processing Times</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $uploadFolder = "product_images";
                                        $uploadPath = WWW_ROOT . $uploadFolder;
                                        $Total_price=0;
                                        $Total_Pay=0;
                                        $Discount_coupon_arr=array();
                                        foreach ($orderdetails as $orderdetail):
                                            //pr($orderdetail);
                                            $order_details_id=$orderdetail['OrderDetail']['id'];
                                            $product_id=isset($orderdetail['OrderDetail']['product_id'])?$orderdetail['OrderDetail']['product_id']:'';
                                            $product_shipping_time=isset($orderdetail['Product']['shipping_time'])?$orderdetail['Product']['shipping_time']:'';
                                            $product_processing_time=isset($orderdetail['Product']['processing_time'])?$orderdetail['Product']['processing_time']:'';
                                            $shipping_address=isset($orderdetail['Order']['shipping_address'])?$orderdetail['Order']['shipping_address']:'';
                                            $prd_img=$this->requestAction(array('controller' => 'orders', 'action' => 'get_product_image', $product_id, 'admin'=>false, 'prefix' => ''));
                                            $Prd_img_name=isset($prd_img['ProductImage']['name'])?$prd_img['ProductImage']['name']:'';
                                            
                                            if($Prd_img_name!='' && file_exists($uploadPath . '/' . $Prd_img_name)){
                                                $image=$this->webroot.'product_images/'.$Prd_img_name;
                                            }else{
                                                $image=$this->webroot.'product_images/default.png';
                                            }
                                            
                                            $order_price=$orderdetail['OrderDetail']['price'];
                                            $order_quantity=$orderdetail['OrderDetail']['quantity'];
                                            $pay_amt=$orderdetail['OrderDetail']['amount'];
                                            $order_status=$orderdetail['OrderDetail']['order_status'];
                                            $per_prd_price=$order_price*$order_quantity;
                                            
                                            $Total_price+=$per_prd_price;
                                            $Total_Pay+=$pay_amt;
                                            $coupon_id=$orderdetail['OrderDetail']['coupon_id'];
                                            $coupon_str='';
                                            if($coupon_id!=''){
                                                $ExpCouponID =  explode(',', $coupon_id);
                                                if(count($ExpCouponID)>0){
                                                    $DisCountAmt=0;
                                                    foreach($ExpCouponID as $valCid){
                                                        if($valCid!=''){
                                                            $CalDiscount_price = $this->requestAction(array('controller' => 'orders', 'action' => 'coupon_details', $valCid,$per_prd_price, 'admin'=>false, 'prefix' => ''));
                                                            $Coupon_name=isset($CalDiscount_price['coupon_name'])?$CalDiscount_price['coupon_name']:'';
                                                            $Coupon_amount=isset($CalDiscount_price['deduct_amt'])?$CalDiscount_price['deduct_amt']:0;
                                                            //pr($CalDiscount_price);
                                                            if($Coupon_amount != 0){
                                                                $coupon_str.='<b class="prod-prop">Coupon Apply: '.$Coupon_name.' Discount Amount US $'.$Coupon_amount.'</b>';
                                                                /*if (array_key_exists($Coupon_name, $Discount_coupon_arr)) {
                                                                    $GetPreval=$Discount_coupon_arr[$Coupon_name];
                                                                    $Discount_coupon_arr[$Coupon_name]=$GetPreval+$Coupon_amount;
                                                                }else{
                                                                    $Discount_coupon_arr[$Coupon_name]=$Coupon_amount;
                                                                }
                                                                $DisCountAmt+=$Coupon_amount;*/
                                                            }
                                                        }
                                                    }
                                                    //$CalDisPrice=($sub-$DisCountAmt);
                                                }
                                            }
                                            
                                            $extend_processing_time=isset($orderdetail['OrderDetail']['extend_processing_time'])?$orderdetail['OrderDetail']['extend_processing_time']:'';
                                            $buyer_responce_processing_time=isset($orderdetail['OrderDetail']['buyer_responce_processing_time'])?$orderdetail['OrderDetail']['buyer_responce_processing_time']:'';
                                            
                                            if($order_status=='U'){
                                                $processing_time_data = $this->requestAction(array('controller' => 'orders', 'action' => 'extend_processing_time_data', $order_details_id, 'admin'=>false, 'prefix' => ''));
                                                $no_of_day=isset($processing_time_data['ExtendProcessingTime']['no_of_day'])?$processing_time_data['ExtendProcessingTime']['no_of_day']:'';
                                                $processing_data='';
                                                if($extend_processing_time==1 && $buyer_responce_processing_time==0 && $no_of_day!=''){
                                                    $processing_data= '<p><b>Extended delivery time requested for '.$no_of_day.' days</b></p>';
                                                }elseif($extend_processing_time==1 && $buyer_responce_processing_time==1  && $no_of_day!=''){
                                                    $processing_data= '<p><b>Extended delivery time accepted for '.$no_of_day.' days</b></p>';
                                                }elseif($extend_processing_time==1 && $buyer_responce_processing_time==2  && $no_of_day!=''){
                                                    $processing_data= '<p><b>Extended delivery time rejected for '.$no_of_day.' days</b></p>';
                                                }
                                                $order_status_text='Undelivered'.$processing_data;
                                            }elseif($order_status=='C'){
                                                $order_status_text='Cancelled';
                                            }elseif($order_status=='D'){
                                                $order_status_text='Delivered';
                                            }elseif($order_status=='DP'){
                                                $order_status_text='Dispute';
                                            }elseif($order_status=='S'){
                                                $order_status_text='Shipment';
                                            }elseif($order_status=='F'){
                                                $order_status_text='Finish';
                                            }
                                            $get_tracking_details=$this->requestAction(array('controller' => 'orders', 'action' => 'get_tracking_details', $order_details_id, 'admin'=>false, 'prefix' => ''));
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="prod-info-image">
                                                    <img src="<?php echo $image;?>" alt="">
                                                </div>
                                                <div class="Prod-info-desc">
                                                    <p><a href="<?php echo $this->webroot.'products/view/'.base64_encode($orderdetail['Product']['id']);?>"><?php echo $orderdetail['Product']['name'];?></a><!--<br>Female Handbag Retro<br> Fluorescent Candy Color
                                                        <b>Color:Black</b>--></p>
                                                    <?php echo $coupon_str;?>
                                                </div>
                                            </td>
                                            <td>US $<?php echo $order_price; ?></td>
                                            <td><?php echo $order_quantity; ?></td>
                                            <td>US $<?php echo $per_prd_price; ?></td>
                                            <td><?php echo $product_processing_time; ?></td>
                                            <td><?php echo $order_status_text; ?></td>
                                            <td><?php 
                                            if(count($get_tracking_details)>0){ 
                                                $tracking_no=$get_tracking_details['TrackDetail']['tracking_no'];
                                                $web_address=$get_tracking_details['TrackDetail']['web_address'];
                                                if($tracking_no!=''){
                                                    echo '<a href="Javascript: void(0);" class="TrackingDetails" trac_no="'.$tracking_no.'" website="'.$web_address.'" shipping_time="'.$product_shipping_time.'" ptime="'.$product_processing_time.'">Tracking Details</a>';
                                                }
                                                //echo '<h4>Tracking no: '.$tracking_no.'</h4><p>'.$web_address.'</p>';
                                                //echo '<a href="http://'.$web_address.'" target="_blank">View Detail</a>';
                                            }
                                            if($order_status=='F'){
                                                $rating_given=$this->requestAction(array('controller' => 'orders', 'action' => 'check_rating_given', $product_id,$order_details_id, 'admin'=>false, 'prefix' => ''));
                                                if(count($rating_given)==0 && $userid==$order_user_id){
                                                    echo '<br /><a href="'.$this->webroot.'orders/order_feedback/'.base64_encode($order_details_id).'">Leave Feedback</a>';
                                                }
                                            }
                                            ?><!--<a href="">Open Dispute</a>--></td>
                                        </tr>
                                        <?php endforeach; ?>
                                            
                                    </tbody>
                            </table>
                        </div>
                    </div>
                    <h4>Total Payment</h4>
                    <div class="detail-info-hold">
                        <div class="table-responsive">
                            <table class="table prod-info-table">
                                <thead>
                                    <tr>
                                        <th>Price</th>
                                        <!--<th>Agreed Price</th>-->
                                        <th>Discount</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>US $<?php echo $Total_price;?></td>
                                        <!--<td></td>-->
                                        <td>US $<?php echo (($Total_price - $Total_Pay)>0)?($Total_price - $Total_Pay):'0.00';?> </td>
                                        <td>US $<?php echo $Total_Pay;?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
            <div class="col-sm-5">
                <h4>Payment Received:</h4>
                <div class="detail-info-hold">
                    <div class="table-responsive">
                        <table class="table prod-info-table grey-top-table">
                            <thead>
                                <tr>
                                    <th>Total</th>
                                    <th>Received</th>
                                    <th>Payment Method</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>US $<?php echo $Total_price;?></td>
                                    <td>US $<?php echo $Total_Pay;?></td>
                                    <td>PayPal</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-7">
                <h4>Shipment Address</h4>
                <div class="detail-info-hold Info">
                    <?php
                    if(isset($shipping_address) && $shipping_address!=''){
                        $shipping_address_str=explode('#',$shipping_address);
                        $ContactName=isset($shipping_address_str[0])?$shipping_address_str[0]:'';
                        $street=isset($shipping_address_str[1])?$shipping_address_str[1]:'';
                        $apartment=isset($shipping_address_str[2])?$shipping_address_str[2]:'';
                        $city=isset($shipping_address_str[3])?$shipping_address_str[3]:'';
                        $state=isset($shipping_address_str[4])?$shipping_address_str[4]:'';
                        $zip_code=isset($shipping_address_str[5])?$shipping_address_str[5]:'';
                        $phn_no=isset($shipping_address_str[6])?$shipping_address_str[6]:'';
                        $Country_name=isset($shipping_address_str[7])?$shipping_address_str[7]:'';
                        echo '<p><span>Contact Name:</span> '.$ContactName.'</p>
                            <p><span>Address:</span> House no. '.$apartment.' Street no. '.$street.'</p>
                            <p><span>City:</span> '.$city.'</p>
                            <p><span>State:</span> '.$state.'</p>  
                            <p><span>Country:</span> '.$Country_name.'</p>    
                            <p><span>Zip Code:</span> '.$zip_code.'</p>
                            <p><span>Mobile:</span> '.$phn_no.'</p>';
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-12">
                    <h4>Message History</h4>
                    <div class="detail-info-hold msg-Hist">
                        <?php
                        $message_img = "message_img";
                        $uploadMessagePath = WWW_ROOT . $message_img;
                        $message_list=$this->requestAction(array('controller' => 'orders', 'action' => 'get_order_message', $order_id, 'admin'=>false, 'prefix' => ''));
                        if(isset($message_list) && count($message_list)>0){
                            foreach ($message_list as $msg){
                                $MessageFileLink='';
                                $user_name=$msg['User']['first_name'].' '.$msg['User']['last_name'];
                                $user_comments=$msg['Comment']['comments'];
                                $file_name=$msg['Comment']['file_name'];
                                $cdate=isset($msg['Comment']['cdate'])?date('dS M, Y H:i a',strtotime($msg['Comment']['cdate'])):'';
                                if($file_name!='' && file_exists($uploadMessagePath . '/' . $file_name)){
                                    $MessageFileLink=$this->webroot.'message_img/'.$file_name;
                                }
                        ?>
                        <div class="row">
                            <div class="col-sm-3 col-xs-4">
                                <p><?php echo isset($user_name)?$user_name:'';?></p>
                            </div>
                            <div class="col-sm-8 col-xs-7">
                                <p><?php echo isset($cdate)?$cdate:'';?> <br><?php echo isset($user_comments)?$user_comments:'';?></p>
                            </div>
                            <div class="col-sm-1 col-xs-1">
                                <?php 
                                if($MessageFileLink!=''){
                                    echo '<a href="'.$MessageFileLink.'" download ><i class="fa fa-download" aria-hidden="true"></i></a>';
                                }
                                ?> 
                            </div>
                        </div>
                        <?php
                            }
                        }else{
                            echo '<div class="row"><div class="col-sm-12 col-xs-12"><p style="text-align: center; font-weight: bold;">No record found.</p></div>';
                        }
                        ?>
                    </div>
            </div>
            <div class="col-sm-5">
                <form method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="form_type" value="message">
                <input type="hidden" name="data[Comment][order_id]" value="<?php echo isset($order_id)?$order_id:'';?>">
                <input type="hidden" name="data[Comment][order_details_id]" value="0">
                    <h4>Leave a message</h4>
                    <div class="form-group">
                            <textarea class="form-control" rows="5" name="data[Comment][comments]" required="required"></textarea>
                    </div>
                    <div class="form-group">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                            <span class="btn btn-default btn-file">
                                <span>Upload a Photo</span>
                                <input name="data[Comment][file_name]" type="file"/>
                            </span>
                            <span class="fileinput-new">No file chosen</span>
                            </div>
                    </div>
                    <p>Please do not upload any personal information! You can upload one photo (max size 5MB) with your
message to the seller. The format of the photo should be in jpg, png, gif, or bmp.</p>
                    <input type="submit" class="btn btn-primary" value="Send"/>
                </form>
            </div>
        </div>
    </div>
</section>



<div class="modal fade" id="TrackingDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog dispute-request">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tracking Details</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-7 control-label">Tracking No:</label>
                    <div class="col-sm-5">
                        <p id="ajaxTrackNo"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-7 control-label">Website:</label>
                    <div class="col-sm-5">
                        <p id="ajaxWebsite"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-7 control-label">Estimated Delivery Time:</label>
                    <div class="col-sm-5">
                        <p id="ajaxDeliveryTime"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-7 control-label">Days Processing Time:</label>
                    <div class="col-sm-5">
                        <p id="ajaxProcessingTime"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
$(document).ready(function(){
    $('.TrackingDetails').click(function(){
        var trac_no=$(this).attr('trac_no');
        var website=$(this).attr('website');
        var shipping_time=$(this).attr('shipping_time');
        var ptime=$(this).attr('ptime');
        if(trac_no!=''){
            $("#ajaxTrackNo").html('');
            $("#ajaxWebsite").html('');
            $("#ajaxDeliveryTime").html('');
            $("#ajaxProcessingTime").html('');
            
            $("#ajaxTrackNo").html('<b>'+trac_no+'</b>');
            $("#ajaxWebsite").html('<a href="http://'+website+'" target="_blank">'+website+'</a>');
            $("#ajaxDeliveryTime").html(shipping_time);
            $("#ajaxProcessingTime").html(ptime);
            
            $('#TrackingDetails').modal();
        }
    }); 
    
});  
</script>