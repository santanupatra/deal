<?php 
//$Ord_sl_no=10000000;
$Ord_sl_no= Configure::read('ORDER_SL_NO');
foreach ($orderdetails as $orderdetail){
    $order_id=$orderdetail['OrderDetail']['order_id'];
    /*$order_id=$orderdetail['Shop']['order_id'];
    $order_id=$orderdetail['Shop']['order_id'];
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
                                    <p class="text-success"><span>Status:</span> Awaiting Response</p>
                                    <p><span>Store:</span> <?php echo isset($store_name)?$store_name:'';?> <a href="" class="btn btn-primary btn-sm">Follow</a></p>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="col-md-4 col-sm-5">
                <div class="detail-info-hold prod-short-desc">
                    <?php
                    
                    ?>
                    <h4>Shipping Company Name</h4>
                    <p><b>Tracking No:</b> 8885296CN</p>
                    <p><b>Website:</b> www.test.com</p>
                    <p><b>Estimated Delivery Time:</b> 15-39</p>
                    <p><b>DaysProcessing Time:</b>7 Days</p>
                </div>
            </div>
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
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $Total_price=0;
                                        $Total_Pay=0;
                                        $Discount_coupon_arr=array();
                                        foreach ($orderdetails as $orderdetail):
                                            if(!empty($orderdetail['Product']['ProductImage'])){
                                                $uploadFolder = "product_images";
                                                $uploadPath = WWW_ROOT . $uploadFolder;
                                                $imageName =$orderdetail['Product']['ProductImage'][0]['name'];
                                                if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
                                                    $image = $this->webroot.'product_images/'.$imageName;
                                                }else{ 
                                                    $image = $this->webroot.'product_images/default.png';
                                                } 
                                            }else{
                                                $image = $this->webroot.'product_images/default.png';
                                            }
                                            $order_price=$orderdetail['OrderDetail']['price'];
                                            $order_quantity=$orderdetail['OrderDetail']['quantity'];
                                            $pay_amt=$orderdetail['OrderDetail']['amount'];
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
                                            <td><?php echo h($orderdetail['OrderDetail']['order_status']=='U'?'Undelivered':($orderdetail['OrderDetail']['order_status']=='C'?'Cancelled':'Delivered')); ?></td>
                                            <td><a href="">Open Dispute</a></td>
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
                                        <th>Agreed Price</th>
                                        <th>Discount</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>US $<?php echo $Total_price;?></td>
                                        <td></td>
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
                            <p><span>Contact Name:</span> Anum Shaheen</p>
                            <p><span>Address:</span> House no. 73 Street no. 09 Area Town Rawalpindi Pakistan</p>
                            <p><span>Zip Code:</span> 46000</p>
                            <p><span>Mobile:</span> 0092-315-5858795</p>
                            <p><span>Tel:</span> 0092-315-5879651</p>
                    </div>
            </div>
            <div class="col-lg-12">
                    <h4>Message History</h4>
                    <div class="detail-info-hold msg-Hist">
                            <div class="row">
                                    <div class="col-sm-3 col-xs-4">
                                            <p>Anum Shaheen</p>
                                    </div>
                                    <div class="col-sm-9 col-xs-8">
                                            <p>2013-09-05 23:53:38 i am going to open dispute now</p>
                                    </div>
                            </div>
                            <div class="row">
                                    <div class="col-sm-3 col-xs-4">
                                            <p>Anum Shaheen</p>
                                    </div>
                                    <div class="col-sm-9 col-xs-8">
                                            <p>2013-09-05 23:53:38 i am going to open dispute now</p>
                                    </div>
                            </div>
                            <div class="row">
                                    <div class="col-sm-3 col-xs-4">
                                            <p>Anum Shaheen</p>
                                    </div>
                                    <div class="col-sm-9 col-xs-8">
                                            <p>2013-09-05 23:53:38 i am going to open dispute now</p>
                                    </div>
                            </div>
                    </div>
                    <h4>Leave a message for the seller</h4>
                    <div class="form-group">
                            <textarea class="form-control" rows="5"></textarea>
                    </div>
            </div>
            <div class="col-sm-5">
                    <div class="form-group">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                            <span class="btn btn-default btn-file">
                                    <span>Upload a Photo</span>
                                    <input type="file"/>
                            </span>
                            <span class="fileinput-new">No file chosen</span>
                            </div>
                    </div>
                    <p>Please do not upload any personal information! You can upload one photo (max size 5MB) with your
message to the seller. The format of the photo should be in jpg, png, gif, or bmp.</p>
                    <input type="submit" class="btn btn-primary" value="Send"/>
            </div>
        </div>
    </div>
</section>
