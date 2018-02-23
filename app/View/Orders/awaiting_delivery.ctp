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
                                    <h4>Awaiting Delivery List</h4>
                                </div>
                                <div class="col-md-12">
                                    <div class="order-search">
                                        <ul>
                                            <li><a href="<?php echo $this->webroot.'orders/awaiting_payment';?>">Awaiting Payment <span>(<?php echo $awaiting_payment;?>)</span></a></li>
                                            <li><a href="<?php echo $this->webroot.'orders/awaiting_shipment';?>">Awaiting Shipment <span>(<?php echo $awaiting_shipment;?>)</span></a></li>
                                            <li class="selected"><a href="<?php echo $this->webroot.'orders/awaiting_delivery';?>">Awaiting Delivery <span>(<?php echo $awaiting_delivery;?>)</span></a></li>
                                            <li><a href="<?php echo $this->webroot.'orders/buyer_disputes';?>">Disputes<span>(<?php echo $Disput;?>)</span></a></li>
                                        </ul>
                                        <form class="form-inline" method="post" action="" name="">
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
                            <div class="col-md-12">
                                <div class="paging" style="margin-bottom: 10px;">
                                <?php
                                    echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
                                    echo $this->Paginator->numbers(array('separator' => ''));
                                    echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
                                ?>
                                </div>
                            </div>
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
                                     
                                    if(count($orders)>0){
                                    foreach ($orders as $order): 
                                        $order_shop_id=$order['OrderDetail']['shop_id'];
                                        $order_owner_id=$order['OrderDetail']['owner_id'];
                                        $order_details_id=$order['OrderDetail']['id'];
                                        $order_date=date('dS M, Y',strtotime($order['Order']['order_date']));
                                        $transaction_id=$order['Order']['transaction_id'];
                                        $total_amount=$order['Order']['total_amount'];
                                        $order_id=$order['Order']['id'];
                                        $pay_amt=$order['OrderDetail']['amount'];
                                        $pay_price=$order['OrderDetail']['price'];
                                        $sl_no=$Ord_sl_no+$order_id;
                                        $order_status=isset($order['OrderDetail']['order_status'])?$order['OrderDetail']['order_status']:'';
                                        $product_id=isset($order['OrderDetail']['product_id'])?$order['OrderDetail']['product_id']:'';
                                        
                                        $quantity=isset($order['OrderDetail']['quantity'])?$order['OrderDetail']['quantity']:'';
                                        $product_name=isset($order['Product']['name'])?$order['Product']['name']:'';
                                        $product_price=isset($order['Product']['price_lot'])?$order['Product']['price_lot']:'';
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
                                        $get_tracking_details=$this->requestAction(array('controller' => 'orders', 'action' => 'get_tracking_details', $order_details_id, 'admin'=>false, 'prefix' => ''));
                                        $delivery_date=isset($order['OrderDetail']['delivery_date'])?$order['OrderDetail']['delivery_date']:'';
                                        $extend_processing_time=isset($order['OrderDetail']['extend_processing_time'])?$order['OrderDetail']['extend_processing_time']:'';
                                        $buyer_responce_processing_time=isset($order['OrderDetail']['buyer_responce_processing_time'])?$order['OrderDetail']['buyer_responce_processing_time']:'';
                                        
                                ?>
                                <li>
                                    <div class="order-top">
                                        <div class="order-head1">
                                                <p>Order ID: <span><?php echo $sl_no;?></span> <a href="<?php echo $this->webroot.'orders/order_details/'.base64_encode($order_id);?>">Track your Order</a></p>
                                                <p>Order Date: <span><?php echo $order_date;?></span></p>
                                        </div>
                                        <div class="order-head2">
                                                <p>Store Name: <span><?php echo $store_name;?></span></p>
                                                <p><a href="<?php echo $this->webroot.'shop/'.$store_slug.'/'.base64_encode($order_shop_id);?>">View Store</a> <i class="fa fa-envelope"></i> <span class="contact_buyer_message" buyer_id="<?php echo $order_owner_id;?>" style="cursor: pointer;">Contact Seller</span></p>
                                        </div>
                                        <div class="order-head3">
                                            <b>Order Amount:<br/>
                                            <a href="">$<?php echo $total_amount;?></a></b>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <div class="order-bottom">
                                            <div class="order_b_1">
                                                <img src="<?php echo $ShopLogoLink;?>" width="173" height="150" alt="" />
                                                <a href="Javascript: void(0);">Free Shipping</a>
                                                <p><?php echo $product_name;?></p>
                                                
                                                <!--<p>2016 New Steel pipe rod
                                                Product Properties: Black</p>-->
                                            </div>
                                            <div class="order_b_2 padding-top_center">
                                                <p>$<?php echo $product_price.' * '.$quantity;?></p>
                                                <?php if($discount_amt>0){ echo '<p>Discount Amount ($'.$discount_amt.')</p>';}?>
                                                <p>Paid</p>
                                                <span>$<?php echo $pay_amt;?></span>
                                                <?php //if($discount_amt>0){ echo '<p>Apply Coupon: Discount Amount ($'.$discount_amt.')</p>';}?>
                                                <a href="Javascript: void(0);" class="OpenDispute" orderid="<?php echo $order_details_id;?>" amount="<?php echo $pay_amt;?>">Open Dispute</a>
                                            </div>
                                            <div class="order_b_3 padding-top_center">
                                                <?php 
                                                //if($extend_processing_time==1 && $buyer_responce_processing_time==0){ echo '<p><b>Seller Request for Extend Processing Time</b></p>';}
                                                ?>
                                                <p><b>Dispatched</b></p>
                                                <!--<p><b>Goods Awaiting Acceptance</b></p>-->
                                                <?php
                                                if(count($get_tracking_details)>0){ 
                                                    $tracking_no=$get_tracking_details['TrackDetail']['tracking_no'];
                                                    $web_address=$get_tracking_details['TrackDetail']['web_address'];
                                                    echo '<h4>Tracking no: '.$tracking_no.'</h4><p>'.$web_address.'</p>';
                                                    echo '<a href="http://'.$web_address.'" target="_blank">Track Order</a>';
                                                }
                                                ?>
                                                
                                            </div>
                                            <div class="order_b_4 padding-top_center">
                                                <a href="<?php echo $this->webroot.'orders/order_details/'.base64_encode($order_id);?>" style="color: #fff;"><button class="active">View Details</button></a>
                                                <?php
                                                //if($extend_processing_time==1 && $buyer_responce_processing_time==0){
                                                ?>
                                                <!--<a href="<?php echo $this->webroot.'orders/buyer_extend_processing_time/'.base64_encode($order_details_id).'/'.base64_encode(1);?>" style="color: #fff;" onclick="return confirm('Are you sure to accept this request.');"><button class="active" style="height: auto !important;">Accept Request</button></a>
                                                    <a href="<?php echo $this->webroot.'orders/buyer_extend_processing_time/'.base64_encode($order_details_id).'/'.base64_encode(2);?>" style="color: #fff;" onclick="return confirm('Are you sure to reject this request.');"><button class="active" style="height: auto !important;">Reject Request</button></a>-->
                                                <?php //}else{?>
                                                <a href="<?php echo $this->webroot.'orders/buyer_received_order/'.base64_encode($order_details_id);?>" onclick="return confirm('Are you sure received the order?');"><button style="height: auto !important;">Confirm Order Received</button></a>
                                                <a href="Javascript: void(0);" class="OpenDispute" orderid="<?php echo $order_details_id;?>" amount="<?php echo $pay_amt;?>"><button class="active" style="height: auto !important;">Item not received</button></a>
                                                <a href="Javascript: void(0);" class="OpenDispute" orderid="<?php echo $order_details_id;?>" amount="<?php echo $pay_amt;?>"><button class="active" style="height: auto !important;">Return item</button></a>
                                                <?php //}?>
                                                <p><?php 
                                                    $TodayDate=strtotime(gmdate('Y-m-d H:i:s'));
                                                    $prd_delivery_date=strtotime($delivery_date);
                                                    $prd_date_diff=$this->requestAction(array('controller' => 'orders', 'action' => 'date_different', $TodayDate, $prd_delivery_date, 'admin'=>false, 'prefix' => ''));
                                                    if($prd_delivery_date>$TodayDate){
                                                        $new_prd_delivery_date=date('dS F, Y',strtotime($delivery_date));
                                                        echo 'Estimated date: '.$new_prd_delivery_date;
                                                    }else{
                                                        //echo '<a href="Javascript: void(0);" class="OpenDispute" orderid="'.$order_details_id.'" amount="'.$pay_amt.'"><button class="active" style="height: auto !important;">Item not received</button></a>';
                                                        echo 'Estimated date: 0';
                                                    }
                                                    ?></p>
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

<div class="modal fade" id="OpenDisputeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog dispute-request">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Open Dispute Request For Refund</h4>
            </div>
            <form class="form-horizontal" method="post" action="<?php echo $this->webroot.'orders/open_dispute';?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="data[Dispute][order_details_id]" id="order_details_id" value="">
                    <input type="hidden" name="data[Dispute][payment_received]" id="payment_received" value="">
                    <div class="form-group">
                        <label for="receive_order" class="col-sm-5 control-label"><span style="color: #c73e14;">*</span>Did you receive your order:</label>
                        <div class="col-sm-6">
                            <div class="radio">
                                <label> <input type="radio" name="data[Dispute][receive_order]" checked="checked" value="Yes"> Yes</label>
                            </div>
                            <div class="radio">
                                <label> <input type="radio" name="data[Dispute][receive_order]" value="No"> No</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="payment_received" class="col-sm-5 control-label"><span style="color: #c73e14;">*</span>Payment Received:</label>
                        <div class="col-sm-6">
                            <label for="" class="col-sm-6 control-label" id="receive_order_amt"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="refund_request" class="col-sm-5 control-label"><span style="color: #c73e14;">*</span>Refund Requested:</label>
                        <div class="col-sm-6">
                            <div class="radio">
                                <label> <input type="radio" name="data[Dispute][refund_request]" checked="checked" value="Full Refund"> Full Refund</label>
                            </div>
                            <div class="radio">
                                <label> <input type="radio" name="data[Dispute][refund_request]" value="Partial Refund Requested"> Partial Refund Requested</label>
                            </div>
                            <div class="radio">
                                <label> <input type="radio" name="data[Dispute][refund_request]" value="Return"> Return</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="select_reason" class="col-sm-5 control-label"><span style="color: #c73e14;">*</span>Select Reason:</label>
                        <div class="col-sm-6">
                            <select name="data[Dispute][select_reason]" id="select_reason" required="required" class="form-control">
                                <option value="">Select Reason</option>
                                <option value="Goods are not as described">Goods are not as described</option>
                                <option value="Goods were damaged">Goods were damaged</option>
                                <option value="Goods did not match quality">Goods did not match quality</option>
                                <option value="I did not order the product">I did not order the product.</option>
                                <option value="Item did not received">Item did not received.</option>
                                <option value="I have changed my mind">I have changed my mind.</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dispute_details" class="col-sm-5 control-label"><span style="color: #c73e14;">*</span>Details:</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="dispute_details" name="data[Dispute][dispute_details]" rows="4" required="required"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dispute_file" class="col-sm-5 control-label">Attach File:</label>
                        <div class="col-sm-6">
                            <input style="font-size: 14px;" type="file" id="dispute_file"  name="data[dispute_file][]" multiple="multiple">
                            <p style="color: #c73e14;">You can attach multiple image file.</p>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Confirm</button>
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
    $('.OpenDispute').click(function(){
        var order_detalis_id=$(this).attr('orderid');
        var amount=$(this).attr('amount');
        if(order_detalis_id!=''){
            $('#order_details_id').val(order_detalis_id);
            $('#payment_received').val(amount);
            $("#receive_order_amt").html('');
            $("#receive_order_amt").html('USD '+amount);
            $('#OpenDisputeModal').modal();
        }
    }); 
    
    $('.contact_buyer_message').click(function(){
        var buyer_id=$(this).attr('buyer_id');
        if(buyer_id!=''){
            $("#contact_to_user_id").val(buyer_id);
            $('#contactnow').modal();
        }
    }); 
});  
</script>