<?php 
//$Ord_sl_no=10000000;
$Ord_sl_no= Configure::read('ORDER_SL_NO');
$userid = $this->Session->read('Auth.User.id');
?>
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
.pro_about{height:auto;width:773px;padding:18px;background: white;border-radius:3px;box-shadow:0 0 2px #999;margin-top:20px;float:left;margin-left:20px;padding:20px;}
.profile_btn{border:1px solid #dadbda;padding:5px 10px 5px 10px;color:#747674;border-radius: 3px;margin:10px 0px 0px 0px;}
.pro_right_btn{float:right !important;margin-right:10px;border:0px !important;margin-top:13px;}
</style>

<section class="after_login">
	<div class="container">
		<div class="row">
		    <?php echo($this->element('user_leftbar'));?>
                    
                    <div class="col-md-9">
                        <div class="product_title">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4>Awaiting Shipment List</h4>
                                </div>
                                <div class="col-md-12">
                                    <div class="order-search">
                                        <ul>
                                            <li><a href="<?php echo $this->webroot.'orders/index';?>">All Orders <span>(<?php echo isset($seller_all_order)?$seller_all_order:'';?>)</span></a></li>
                                            <li class="selected"><a href="<?php echo $this->webroot.'orders/seller_awaiting_shipment';?>">Awaiting Shipment <span>(<?php echo isset($seller_awaiting_shipment)?$seller_awaiting_shipment:'';?>)</span></a></li>
                                            <li><a href="<?php echo $this->webroot.'orders/seller_completed';?>">Completed <span>(<?php echo isset($seller_complete_product)?$seller_complete_product:'';?>)</span></a></li>
                                            <li><a href="<?php echo $this->webroot.'orders/seller_disputes';?>">Disputes & Refund <span>(<?php echo isset($seller_Disput)?$seller_Disput:'';?>)</span></a></li>
                                        </ul>
                                        <form class="form-inline" method="post" action="" name="">
                                            <input type="hidden" name="form_type" value="Search Form">
                                            <div class="form-group">
                                                <input type="number" min="1" class="form-control" id="order_no" name="order_no" placeholder="Order ID" value="<?php echo isset($order_no)?$order_no:'';?>">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="exampleInputPassword3" name="product_name" placeholder="Product name" value="<?php echo isset($product_name)?$product_name:'';?>">
                                            </div>
                                            <button type="submit" class="btn btn-default">Search</button>
                                            <!--<div class="form-group">
                                                  <select name="" class="form-control">
                                                          <option>More Filter</option>
                                                  </select>
                                            </div>-->
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="product_action">
                                <li><a href="">Product</a></li>
                                <li><a href="">Payment</a></li>
                                <li><a href="">Order Status</a></li>
                                <li><a href="">Action</a></li>
                            </ul>
                            <ul class="product_boxes">
                                <?php 
                                    $uploadFolder = "product_images";
                                    $uploadPath = WWW_ROOT . $uploadFolder;
                                                
                                    //$uploadShopPath= Configure::read('UPLOAD_SHOP_LOGO_PATH');
                                    //seller_accept
                                    if(count($orders)>0){
                                    foreach ($orders as $order): 
                                        $order_details_id=$order['OrderDetail']['id'];
                                        $order_shop_id=$order['OrderDetail']['shop_id'];
                                        $order_user_id=$order['OrderDetail']['user_id'];
                                        
                                        $order_date=date('dS M, Y',strtotime($order['Order']['order_date']));
                                        $transaction_id=$order['Order']['transaction_id'];
                                        $total_amount=$order['Order']['total_amount'];
                                        $order_id=$order['Order']['id'];
                                        $pay_amt=$order['OrderDetail']['amount'];
                                        $pay_price=$order['OrderDetail']['price'];
                                        $sl_no=$Ord_sl_no+$order_id;
                                        $order_status=isset($order['OrderDetail']['order_status'])?$order['OrderDetail']['order_status']:'';
                                        $cancel_user_id=isset($order['OrderDetail']['cancel_user_id'])?$order['OrderDetail']['cancel_user_id']:'';
                                        $delivery_date=isset($order['OrderDetail']['delivery_date'])?$order['OrderDetail']['delivery_date']:'';
                                        $cancel_id=isset($order['OrderDetail']['cancel_id'])?$order['OrderDetail']['cancel_id']:'';
                                        $order_user_id=$order['OrderDetail']['user_id'];
                                        $order_owner_id=$order['OrderDetail']['owner_id'];
                                        
                                        $product_id=isset($order['OrderDetail']['product_id'])?$order['OrderDetail']['product_id']:'';
                                        $seller_accept_shipment=isset($order['OrderDetail']['seller_accept_shipment'])?$order['OrderDetail']['seller_accept_shipment']:'';
                                        $quantity=isset($order['OrderDetail']['quantity'])?$order['OrderDetail']['quantity']:'';
                                        $product_name=isset($order['Product']['name'])?$order['Product']['name']:'';
                                        $product_price=isset($order['Product']['price_lot'])?$order['Product']['price_lot']:'';
                                        $prd_disput_details=$this->requestAction(array('controller' => 'orders', 'action' => 'get_dispute_details', $order_details_id, 'admin'=>false, 'prefix' => ''));
                                        $buyer_cancel_list=$this->requestAction(array('controller' => 'orders', 'action' => 'get_cancel_details', $cancel_id, 'admin'=>false, 'prefix' => ''));
                                        if(count($buyer_cancel_list)>0){
                                            $seller_responce=$buyer_cancel_list['CancelOrder']['seller_responce'];
                                        }
                                        $prd_img=$this->requestAction(array('controller' => 'orders', 'action' => 'get_product_image', $product_id, 'admin'=>false, 'prefix' => ''));
                                        
                                        $store_name=isset($order['Shop']['name'])?$order['Shop']['name']:'';
                                        $store_slug=isset($order['Shop']['slug'])?$order['Shop']['slug']:'';
                                        $Prd_img_name=isset($prd_img['ProductImage']['name'])?$prd_img['ProductImage']['name']:'';
                                        
                                        if($Prd_img_name!='' && file_exists($uploadPath . '/' . $Prd_img_name)){
                                            $ShopLogoLink=$this->webroot.'product_images/'.$Prd_img_name;
                                        }else{
                                            $ShopLogoLink=$this->webroot.'product_images/default.png';
                                        }
                                        //$discount_amt=($pay_price - $pay_amt);
                                        $discount_amt=(($product_price*$quantity) - $pay_amt);
                                        if($order_status=='C' && $order_owner_id==$cancel_user_id){
                                            $CancelText='You Cancelled the order.';
                                        }else{
                                            $CancelText='Seller Cancelled the order.';
                                        }
                                        $get_tracking_details=$this->requestAction(array('controller' => 'orders', 'action' => 'get_tracking_details', $order_details_id, 'admin'=>false, 'prefix' => ''));
                                        $extend_processing_time=isset($order['OrderDetail']['extend_processing_time'])?$order['OrderDetail']['extend_processing_time']:'';
                                        $buyer_responce_processing_time=isset($order['OrderDetail']['buyer_responce_processing_time'])?$order['OrderDetail']['buyer_responce_processing_time']:'';
                                ?>
                                <li>
                                    <div class="order-top">
                                        <div class="order-head1">
                                                <p>Order ID: <span><?php echo $sl_no;?></span> <a href="<?php echo $this->webroot.'orders/order_details/'.base64_encode($order_id);?>">View Detail</a></p>
                                                <p>Order Date: <span><?php echo $order_date;?></span></p>
                                        </div>
                                        <div class="order-head2">
                                            <p>Store Name: <span><?php echo $store_name;?></span></p>
                                            <p><a href="<?php echo $this->webroot.'shop/'.$store_slug.'/'.base64_encode($order_shop_id);?>">View Store</a> <i class="fa fa-envelope"></i> <span class="contact_buyer_message" buyer_id="<?php echo $order_user_id;?>" style="cursor: pointer;">Contact Buyer</span></p>
                                        </div>
                                        <div class="order-head3">
                                            <b>Order Amount:<br/>
                                            <a href="">$<?php echo $pay_amt;?></a></b>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <div class="order-bottom">
                                            <div class="order_b_1">
                                                <img src="<?php echo $ShopLogoLink;?>" width="173" height="150" alt="" />
                                                <!--<a href="Javascript: void(0);">Free Shipping</a>-->
                                                <p><?php echo $product_name;?></p>
                                                
                                                <!--<p>2016 New Steel pipe rod
                                                Product Properties: Black</p>-->
                                            </div>
                                            <div class="order_b_2 padding-top_center">
                                                <p>$<?php echo $product_price.' * '.$quantity;?></p>
                                                <?php if($discount_amt>0){ echo '<p>Discount Amount ($'.$discount_amt.')</p>';}?>
                                                <!--<p>Paid</p>
                                                <span>$<?php echo $pay_amt;?></span>-->
                                                <?php //if($discount_amt>0){ echo '<p>Apply Coupon: Discount Amount ($'.$discount_amt.')</p>';}?>
                                            </div>
                                            <div class="order_b_3 padding-top_center">
                                                <?php
                                                if($order_status=='C' && isset($seller_responce) && $seller_responce==0){
                                                    echo '<p><b>Order Cancelled - Waiting Action</b></p>';
                                                }elseif($order_status=='C' && isset($seller_responce) && $seller_responce==1){
                                                    echo '<p><b>You Accepted Cancelled Order from seller</b></p>';
                                                }elseif($order_status=='C' && isset($seller_responce) && $seller_responce==2){
                                                    echo '<p><b>You Reject Cancelled Order from seller</b></p>';
                                                }elseif($order_status=='C' && isset($seller_responce) && $seller_responce==3){
                                                    echo '<p><b>You Cancelled the Order</b></p>';
                                                }elseif($seller_accept_shipment==0){
                                                    echo '<p><b>Awaiting Shipment</b></p>';
                                                    if($extend_processing_time==0){
                                                        echo '<p style="float:left; margin:5px 0;"><b class="new_ord_cls">New order</b></p>';
                                                    }
                                                    if($extend_processing_time==1 && $buyer_responce_processing_time==0){
                                                        echo '<p><b>Extended delivery time requested</b></p>';
                                                    }elseif($extend_processing_time==1 && $buyer_responce_processing_time==1){
                                                        echo '<p><b>Extended delivery time accepted</b></p>';
                                                    }elseif($extend_processing_time==1 && $buyer_responce_processing_time==2){
                                                        echo '<p><b>Extended delivery time rejected</b></p>';
                                                    }
                                                }elseif($seller_accept_shipment==1 && $order_status=='S'){
                                                    //echo '<p><b>Goods Awaiting Delivery</b></p><p><b>Dispatched</b></p>';
                                                    echo '<p><b>Dispatched</b></p>';
                                                    if(count($get_tracking_details)>0){ 
                                                        $tracking_no=$get_tracking_details['TrackDetail']['tracking_no'];
                                                        $web_address=$get_tracking_details['TrackDetail']['web_address'];
                                                        echo '<h4>Tracking no: '.$tracking_no.'</h4><div class="clearfix"></div><span>'.$web_address.'</span><div class="clearfix"></div>';
                                                        echo '<a href="http://'.$web_address.'" target="_blank">Track Order</a>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <div class="order_b_4 padding-top_center">
                                                <?php
                                                if($order_status=='S' || $order_status=='C'){ 
                                                    if($order_status=='C' && isset($seller_responce) && $seller_responce==0){
                                                ?>
                                                <a href="Javascript: void(0);" class="ConfirmCancellation" details_id="<?php echo $order_details_id;?>" style="color: #fff;"><button class="active">Confirm Cancellation</button></a>
                                                    <!--<button>Reject Request</button>-->
                                                <?php
                                                    }elseif($order_status=='S' && $extend_processing_time==0){
                                                        //echo '<a href="Javascript: void(0);" class="ExtendProcessingTime" ord_details_id="'.base64_encode($order_details_id).'"><button type="button" class="active" style="height: auto !important;">Extend Processing Time</button></a> ';
                                                    }
                                                ?>
                                                <p><?php 
                                                    $TodayDate=strtotime(gmdate('Y-m-d H:i:s'));
                                                    $prd_delivery_date=strtotime($delivery_date);
                                                    $prd_date_diff=$this->requestAction(array('controller' => 'orders', 'action' => 'date_different', $TodayDate, $prd_delivery_date, 'admin'=>false, 'prefix' => ''));
                                                    if($order_status!='C'){ 
                                                        if($prd_delivery_date>$TodayDate){
                                                            $new_prd_delivery_date=date('dS F, Y',strtotime($delivery_date));
                                                            echo 'Estimated date: '.$new_prd_delivery_date;
                                                        }else{
                                                            echo 'Estimated date: 0';
                                                        }
                                                    }
                                                    ?></p>
                                                <?php
                                                }elseif($order_status=='F'){ ?>
                                                    <p><b>Finish</b></p>
                                                <?php 
                                                }else{
                                                    if(count($prd_disput_details)< 1){
                                                        echo '<button class="active add_tracking" type="button" id="'.base64_encode($order_details_id).'"><a href="Javascript: void(0);" style="color: #fff;">Add Tracking</a></button>';
                                                    }
                                                    if($extend_processing_time==1 && ($buyer_responce_processing_time==1 || $buyer_responce_processing_time==2)){
                                                ?>
                                                    <a href="Javascript: void(0);" class="seller_cancel_order" cancel_id="<?php echo $order_details_id;?>"><button class="active" type="button">Cancel Order</button></a>
                                                    <?php } ?>
                                                    <?php if($extend_processing_time==0 && $order_status=='U'){?>
                                                    <a href="Javascript: void(0);" class="ExtendProcessingTime" ord_details_id="<?php echo base64_encode($order_details_id);?>"><button type="button" class="active" style="height: auto !important;">Extend Processing Time</button></a> 
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                    </div>
                                </li>
                                <?php endforeach;
                                    }else{
                                        echo '<li><h4>No records found.</h4></li>';
                                    }
                                ?>
                            </ul>
                            <p>
                            <?php
                            echo $this->Paginator->counter(array(
                            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                            ));
                            ?>	</p>
                            <div class="paging">
                            <?php
                                echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
                                echo $this->Paginator->numbers(array('separator' => ''));
                                echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		
	</div>
</section>


<style>
.order_b_3.padding-top_center > span {
    display: block;
    word-break: break-all;
    padding-right: 10px;
}
.new_ord_cls {
    background: rgba(182, 14, 9, 0.72) none repeat scroll 0% 0%;padding: 5px 15px;color: rgb(255, 255, 255);margin: 0px;font-size: 13px;border-radius:25px;
}
</style>

<div class="modal fade" id="AddTrackingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog dispute-request">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Tracking Details</h4>
            </div>
            <form class="form-horizontal" action="<?php echo $this->webroot.'orders/add_tracking';?>" method="post">
            <div class="modal-body">
                <div id="AjaxRpl_Tracking"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
            </form>    
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="CancelOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog dispute-request">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cancel Order Request from Buyer</h4>
            </div>
            <form class="form-horizontal" name="cancel_order_frm" method="post" action="<?php echo $this->webroot.'orders/accept_cancel_order';?>">
                <input type="hidden" name="form_type" id="cancel_form_type" value="AcceptOrder">
                <input type="hidden" name="order_details_id" id="cancel_order_details_id" value="">
                <div class="modal-body">
                    <div id="AjaxRpl_Cancel"></div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Select Reason:</label>
                        <div class="col-sm-9">
                            <select name="select_reason" class="form-control" required="required">
                                <option value="">Select Reason</option>
                                <option value="Buyer choose to cancel the order due to issue in shipping address">Buyer choose to cancel the order due to issue in shipping address.</option>
                                <option value="Unable to manage the product stock">Unable to manage the product stock</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Details:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="4" name="details"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Accept</button>
                    <button type="button" class="btn btn-default reject_order">Reject</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="SellerCancelOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog dispute-request">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cancel Order Request from Seller</h4>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo $this->webroot.'orders/seller_cancel_order';?>">
                <input type="hidden" name="order_details_id" id="seller_cancel_order_details_id" value="">
                <div class="modal-body">
                    <div id="AjaxSeller_Cancel"></div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Select Reason:</label>
                        <div class="col-sm-9">
                            <select name="select_reason" class="form-control" required="required">
                                <option value="">Select Reason</option>
                                <option value="Problem with delivery address">Problem with delivery address.</option>
                                <option value="Out of Stock">Out of Stock.</option>
                                <option value="Customer requested cancellation">Customer requested cancellation.</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Add Detail:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="4" name="details" required="required"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Cancel Order</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="ExtendProcessingTime" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog dispute-request">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Extend Processing Time</h4>
            </div>
            <form class="form-horizontal" method="post" action="">
                <input type="hidden" name="form_type" value="Extend Processing Time">
                <input type="hidden" name="OrderDetailsID" id="OrderDetailsID" value="">
            <div class="modal-body">
                <!--<p>If the shipper is having any trouble meeting the shipment date, you can extend the processing time of your order for delivery confirmation at the right time.</p>-->

                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-5 control-label">Extend Processing Time By</label>
                    <div class="col-sm-4">
                        <input type="number" min="1" max="14" name="TimeBy" class="form-control" required="required" placeholder="Days"> 
                    </div>
                    <label for="inputEmail3" class="col-sm-2 control-label" style="text-align: left;">Days</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure?');">Confirm</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
            </form>    
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="contactnow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog dispute-request">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" style="background: transparent; color: #969494;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Contact</h4>
            </div>
            <?php if(!empty($userid)){ ?>
            <form class="form-horizontal" method="post" action="<?php echo $this->webroot; ?>shops/contact_mail" enctype="multipart/form-data">
                <input type="hidden" name="data[Comment][user_id]" value="<?php echo $userid; ?>">
                <input type="hidden" name="data[Comment][to_user_id]" id="contact_to_user_id" value="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Subject</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="data[Comment][subject]" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Message:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="4" name="data[Comment][comments]" required="required"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">File:</label>
                        <div class="col-sm-9">
                            <input style="font-size: 14px;" type="file"  name="data[Comment][file_name]">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" style=" padding: 8px 20px; border-radius: 5px;">Submit</button>
                    <button type="button" class="btn btn-default" style="padding-left: 20px;padding-right: 20px; background: #e2e1e1; box-shadow: none; text-shadow: none; border-color: #e2e1e1; color: #000;     padding: 8px 20px; border-radius: 5px; " data-dismiss="modal">Cancel</button>
                </div>
            </form>
            <?php }else{
            ?>
            <div class="modal-body">
                You need to login for contact.

            </div>
            <?php
            } ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('.add_tracking').on('click', function(event) {
    //$('.add_tracking').click(function(){
        //event.stopPropagation();
        var order_detalis_id=$(this).attr('id');
        if(order_detalis_id!=''){
            $.ajax({
               type:'post' ,
               data: {'order_detalis_id':order_detalis_id},
               url:'<?php echo $this->webroot;?>orders/get_order_details/',
               success:function(data){
                   if(data!=''){
                       $("#AjaxRpl_Tracking").html('');
                       $("#AjaxRpl_Tracking").html(data);
                   }
                }

            });
            $('#AddTrackingModal').modal();
        }
        
    }); 
    
    $('.contact_buyer_message').click(function(){
        var buyer_id=$(this).attr('buyer_id');
        if(buyer_id!=''){
            $("#contact_to_user_id").val(buyer_id);
            $('#contactnow').modal();
        }
    }); 
    
    $('.reject_order').click(function(){
        $('#cancel_form_type').val('RejectOrder');
        if(confirm('Are you sure?')){
            document.cancel_order_frm.submit();
        }/*else{
            alert('hi');
        }*/
    }); 
    
    $('.ExtendProcessingTime').click(function(){
        var order_detalis_id=$(this).attr('ord_details_id');
        if(order_detalis_id!=''){
            $('#OrderDetailsID').val(order_detalis_id);
            $('#ExtendProcessingTime').modal();
        }
    }); 
    
    $('.ConfirmCancellation').click(function(){
        var RefundAmountVal=$(this).attr('details_id');
        if(RefundAmountVal!=''){
            $.ajax({
               type:'post' ,
               data: {'order_detalis_id':RefundAmountVal,'details_type':'cancel_order'},
               url:'<?php echo $this->webroot;?>orders/get_order_details_for_cancel/',
               success:function(data){
                   if(data!=''){
                       $("#AjaxRpl_Cancel").html('');
                       $("#AjaxRpl_Cancel").html(data);
                   }
                }
            });
            $('#cancel_order_details_id').val(RefundAmountVal);
            $('#CancelOrder').modal();
        }
    }); 
    
    $('.seller_cancel_order').click(function(){
        var RefundAmountVal=$(this).attr('cancel_id');
        if(RefundAmountVal!=''){
            $.ajax({
               type:'post' ,
               data: {'order_detalis_id':RefundAmountVal,'details_type':'Seller_cancel'},
               url:'<?php echo $this->webroot;?>orders/get_order_details_for_cancel/',
               success:function(data){
                   if(data!=''){
                       $("#AjaxSeller_Cancel").html('');
                       $("#AjaxSeller_Cancel").html(data);
                   }
                }
            });
            $('#seller_cancel_order_details_id').val(RefundAmountVal);
            $('#SellerCancelOrder').modal();
        }
    }); 
});  
</script>

