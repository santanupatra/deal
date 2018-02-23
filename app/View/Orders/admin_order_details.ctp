<?php
$Ord_sl_no= Configure::read('ORDER_SL_NO');
$uploadFolder = "product_images";
$uploadPath = WWW_ROOT . $uploadFolder;
$order_id=$orderdetail['OrderDetail']['order_id'];
if($order_id!=''){
    $Seller_info=$this->requestAction(array('controller' => 'orders', 'action' => 'get_seller_details', $order_id, 'admin'=>false, 'prefix' => ''));
    $store_name=isset($Seller_info['Shop']['name'])?$Seller_info['Shop']['name']:'';
    $store_logo=isset($Seller_info['Shop']['logo'])?$Seller_info['Shop']['logo']:'';
    $shipping_cost=isset($Seller_info['OrderDetail']['shipping_cost'])?$Seller_info['OrderDetail']['shipping_cost']:'';  
}

$product_id=isset($orderdetail['OrderDetail']['product_id'])?$orderdetail['OrderDetail']['product_id']:'';
$product_name=isset($orderdetail['Product']['name'])?$orderdetail['Product']['name']:'';
//$product_shipping_time=isset($orderdetail['Product']['shipping_time'])?$orderdetail['Product']['shipping_time']:'';
//$product_processing_time=isset($orderdetail['Product']['processing_time'])?$orderdetail['Product']['processing_time']:'';
//$shipping_address=isset($orderdetail['Order']['shipping_address'])?$orderdetail['Order']['shipping_address']:'';
$prd_img=$this->requestAction(array('controller' => 'orders', 'action' => 'get_product_image', $product_id, 'admin'=>false, 'prefix' => ''));
$Prd_img_name=isset($prd_img['ProductImage'][0]['name'])?$prd_img['ProductImage'][0]['name']:'';

if($Prd_img_name!='' && file_exists($uploadPath . '/' . $Prd_img_name)){
    $PrdImage=$this->webroot.'product_images/'.$Prd_img_name;
}else{
    $PrdImage=$this->webroot.'product_images/default.png';
}

$order_note=isset($orderdetail['Order']['notes'])?$orderdetail['Order']['notes']:'';
$order_date=isset($orderdetail['Order']['order_date'])?$orderdetail['Order']['order_date']:'';
$order_transaction_id=isset($orderdetail['Order']['transaction_id'])?$orderdetail['Order']['transaction_id']:'';

$order_price=$orderdetail['OrderDetail']['price'];
$order_quantity=$orderdetail['OrderDetail']['quantity'];
$pay_amt=$orderdetail['OrderDetail']['amount'];
//$coupon_id=$orderdetail['OrderDetail']['coupon_id'];
//$per_prd_price=$order_price*$order_quantity;

/*$coupon_str='';
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
                    $coupon_str.='<b class="prod-prop">Coupon Apply: '.$Coupon_name.' Discount Amount US $'.$Coupon_amount.'</b><br />';
                }
            }
        }
    }
}*/
                                            
$order_status=isset($orderdetail['OrderDetail']['order_status'])?$orderdetail['OrderDetail']['order_status']:'';
if($order_status=='U'){
    $order_status_text='Under Processing';
}elseif($order_status=='C'){
    $order_status_text='Cancelled';
}elseif($order_status=='D'){
    $order_status_text='Delivered';
}elseif($order_status=='DP'){
    $order_status_text='Dispute';
}elseif($order_status=='S'){
    $order_status_text='Awaiting Shipment ';
}elseif($order_status=='F'){
    $order_status_text='Completed';
}
?>

<div class="span9" id="content">
    <div class="row-fluid">
        <!-- block -->
        <div class="block">
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left"><?php echo __('Order Details'); ?></div>
            </div>
            <div class="users view">
            <dl>
		<dt><?php echo __('OrderId'); ?></dt>
		<dd>
			<?php echo h($Ord_sl_no+$order_id); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Order Transaction ID'); ?></dt>
		<dd>
			<?php echo h($order_transaction_id); ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Order Date'); ?></dt>
		<dd>
			<?php echo h(date('dS M, Y',strtotime($order_date))); ?>
			&nbsp;
		</dd>
		<dt><?php //echo __('Store Name'); ?></dt>
		<dd>
			<?php //echo $this->Html->link($shippingAddress['User']['id'], array('controller' => 'users', 'action' => 'view', $shippingAddress['User']['id']))
                       // echo $store_name; 
                        ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Store Woner Name'); ?></dt>
		<dd>
			<?php echo isset($orderdetail['User']['first_name'])?$orderdetail['User']['first_name'].' '.$orderdetail['User']['last_name']:''; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Buyer Name'); ?></dt>
		<dd>
			<?php echo isset($orderdetail['Buyer']['first_name'])?$orderdetail['Buyer']['first_name'].' '.$orderdetail['Buyer']['last_name']:''; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Product Name'); ?></dt>
		<dd>
			<?php echo h($product_name); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Product Image'); ?></dt>
		<dd>
                    <img src="<?php echo $PrdImage;?>" style="height: 150px; width: 250px;" alt="">
			&nbsp;
		</dd>
                <dt><?php echo __('Total Pice'); ?></dt>
		<dd>
			$<?php echo h($order_price*$order_quantity); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pay Pice'); ?></dt>
		<dd>
			$<?php echo h($pay_amt); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Purches Quantity'); ?></dt>
		<dd>
			<?php echo h($order_quantity); ?>
			&nbsp;
		</dd>
                <?php
                if($coupon_str!=''){
                ?>
                <dt><?php echo __('Apply Coupon Code'); ?></dt>
		<dd>
			<?php echo $coupon_str; ?>
			&nbsp;
		</dd>
                <?php
                }
                ?>
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
                        
                    
                ?>
                <dt><?php echo __('Shipment Address'); ?></dt>
		<dd>
			<?php echo '<p><span>Contact Name:</span> '.$ContactName.'</p>
                            <p><span>Address:</span> House no. '.$apartment.' Street no. '.$street.'</p>
                            <p><span>City:</span> '.$city.'</p>
                            <p><span>State:</span> '.$state.'</p>  
                            <p><span>Country:</span> '.$Country_name.'</p>    
                            <p><span>Zip Code:</span> '.$zip_code.'</p>
                            <p><span>Mobile:</span> '.$phn_no.'</p>';; ?>
			&nbsp;
		</dd>
                <?php
                }
                if($order_status=='DP'){
                    $order_details_id=isset($orderdetail['OrderDetail']['id'])?$orderdetail['OrderDetail']['id']:'';
                    $prd_disput_details=$this->requestAction(array('controller' => 'orders', 'action' => 'get_dispute_details', $order_details_id, 'admin'=>false, 'prefix' => ''));
                    if(count($prd_disput_details)>0){
                        $dispute_date=date('dS M, Y H:i a',strtotime($prd_disput_details['Dispute']['cdate']));
                        $seller_response=$prd_disput_details['Dispute']['seller_response'];
                        $is_close=$prd_disput_details['Dispute']['is_close'];
                        $receive_order=$prd_disput_details['Dispute']['receive_order'];
                        $payment_received=$prd_disput_details['Dispute']['payment_received'];
                        $refund_request=$prd_disput_details['Dispute']['refund_request'];
                        $select_reason=$prd_disput_details['Dispute']['select_reason'];
                        $dispute_details=$prd_disput_details['Dispute']['dispute_details'];
                        $seller_dispute_action=$prd_disput_details['Dispute']['seller_dispute_action'];
                        $dispute_id=$prd_disput_details['Dispute']['id'];
                        $dispute_history=$this->requestAction(array('controller' => 'orders', 'action' => 'get_dispute_history', $dispute_id, 'admin'=>false, 'prefix' => ''));
                    }
                    $message_list=$this->requestAction(array('controller' => 'orders', 'action' => 'get_dispute_message', $order_details_id, 'admin'=>false, 'prefix' => ''));
                ?>
                <dt><?php echo __('Dispute Date'); ?></dt>
		<dd>
			<?php echo isset($dispute_date)?$dispute_date:'';?>
			&nbsp;
		</dd>
                <dt><?php echo __('Dispute Reason'); ?></dt>
		<dd>
			<?php echo isset($select_reason)?$select_reason:'';?>
			&nbsp;
		</dd>
                <dt><?php echo __('Dispute Status'); ?></dt>
		<dd>
			<?php if(isset($seller_response) && $seller_response==0){ echo 'Awaiting Response';}elseif(isset($seller_response) && $seller_response==1 && $seller_dispute_action==1){ echo 'Seller accept issue';}elseif(isset($seller_response) && $seller_response==1 && $seller_dispute_action==2){ echo 'Supplier did not agree to the reason you mentioned in dispute';}?>
			&nbsp;
		</dd>
                <dt><?php echo __('Dispute Information'); ?></dt>
		<dd>
                    <p><span>Did you receive your order</span> <?php echo isset($receive_order)?$receive_order:'';?></p>
                    <p><span>Do you want to return goods</span> Yes</p>
                    <p><span>Dispute Reason:</span> <?php echo isset($select_reason)?$select_reason:'';?></p>
                    <p><span>Dispute Order Total:</span> US $<?php echo isset($payment_received)?$payment_received:'';?></p>
                    <?php if(isset($seller_response) && $seller_response==1){
                        $get_return_amt=$this->requestAction(array('controller' => 'orders', 'action' => 'get_return_amount', $dispute_id, 'admin'=>false, 'prefix' => ''));
                        if(count($get_return_amt)>0){
                            $dispute_refund_amount=$get_return_amt['DisputeMessage']['refund_amount'];
                            if($dispute_refund_amount>0){
                                echo '<p><span>Refund Amount:</span> US $'.$dispute_refund_amount.'</p>';
                            }
                        }
                    }
                    ?>
                    <p><span>Dispute Opened:</span> <?php echo isset($dispute_date)?$dispute_date:'';?></p>
                    <p><span>Requests Detail:</span> <?php echo isset($dispute_details)?$dispute_details:'';?></p>
		</dd>
                <?php if(isset($is_close) && $is_close==0){ ?>
                <dt><?php echo __('Dispute Action From Admin'); ?></dt>
		<dd>
                    <a href="Javascript: void(0);" class="btn btn-primary" data-toggle="modal" data-target="#RejectDispute">Reject</a>
                    <a href="Javascript: void(0);" class="btn btn-success" data-toggle="modal" data-target="#AcceptDispute">Accept</a>
		</dd>
                <?php }?>
                <dt><?php echo __('Dispute History'); ?></dt>
		<dd>
			<table class="table table-bordered prod-history-table">
                            <thead>
                                <tr>
                                    <th>Initiator</th>
                                    <th>Received Goods</th>
                                    <th>Return Goods</th>
                                    <th>Refund Amount</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                    <th>Reason & Detail</th>
                                    <th>Attachment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(isset($dispute_history) && count($dispute_history)>0){
                                    foreach ($dispute_history as $DVal){
                                        $reason=$DVal['DisputeMessage']['reason'];
                                        $received_goods=$DVal['DisputeMessage']['received_goods'];
                                        $return_goods=$DVal['DisputeMessage']['return_goods'];
                                        $refund_request=$DVal['DisputeMessage']['refund_request'];
                                        $refund_amount=$DVal['DisputeMessage']['refund_amount'];
                                        $action=$DVal['DisputeMessage']['action'];
                                        $user_type=$DVal['DisputeMessage']['user_type'];
                                        $cdate=isset($DVal['DisputeMessage']['cdate'])?date('dS M, Y H:i a',strtotime($DVal['DisputeMessage']['cdate'])):'';
                                        if($user_type==1){
                                            $user_type_text='Buyer';
                                        }elseif($user_type==2){
                                            $user_type_text='Seller';
                                        }elseif($user_type==3){
                                            $user_type_text='TWOP';
                                        }else{
                                            $user_type_text='Buyer';
                                        }
                                ?>
                                <tr>
                                    <td><?php echo $user_type_text;?></td>
                                    <td><?php echo isset($received_goods)?$received_goods:'';?></td>
                                    <td><?php echo isset($return_goods)?$return_goods:'';?></td>
                                    <td>US $<?php echo isset($refund_amount)?$refund_amount:'';?></td>
                                    <td><?php echo isset($cdate)?$cdate:'';?></td>
                                    <td><?php echo isset($action)?$action:'';?></td>
                                    <td><?php echo isset($reason)?$reason:'';?></td>
                                    <td></td>
                                </tr>
                                <?php
                                    }
                                }else{
                                    echo '<tr><td colspan="8"><p style="text-align: center; font-weight: bold;">No record found.</p></td></tr>';
                                }
                                ?>
                                
                            </tbody>
                        </table>
		</dd>
                <dt><?php echo __('Dispute Message'); ?></dt>
		<dd>
                    <div class="detail-info-hold msg-Hist">
                    <?php
                    $message_img = "message_img";
                    $uploadMessagePath = WWW_ROOT . $message_img;
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
                                    echo '<a href="'.$MessageFileLink.'" download ><i class="fa fa-download" aria-hidden="true"></i> Download</a>';
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
		</dd>
                <?php
                }elseif($order_status=='C'){
                    $cancel_id=isset($orderdetail['OrderDetail']['cancel_id'])?$orderdetail['OrderDetail']['cancel_id']:'';
                    $buyer_cancel_list=$this->requestAction(array('controller' => 'orders', 'action' => 'get_cancel_details', $cancel_id, 'admin'=>false, 'prefix' => ''));
                    if(count($buyer_cancel_list)>0){
                        $seller_responce=$buyer_cancel_list['CancelOrder']['seller_responce'];
                        $can_select_reason=$buyer_cancel_list['CancelOrder']['select_reason'];
                        $can_description=$buyer_cancel_list['CancelOrder']['description'];
                        $cancel_date=$buyer_cancel_list['CancelOrder']['cdate'];
                        $cancel_date_str=date('dS M, Y H:i a',strtotime($cancel_date));
                    }
                    ?>
                <dt><?php echo __('Cancel Order Date'); ?></dt>
		<dd>
			<?php echo isset($cancel_date_str)?$cancel_date_str:'';?>
			&nbsp;
		</dd>
                <dt><?php echo __('Cancel Order Status'); ?></dt>
		<dd>
			<?php 
                        if($order_status=='C' && isset($seller_responce) && $seller_responce==0){
                            echo '<p><b>Order Cancel - Waiting Action From Seller</b></p>';
                        }elseif($order_status=='C' && isset($seller_responce) && $seller_responce==1){
                            echo '<p><b>Seller Accept Cancel Order from Buyer</b></p>';
                        }elseif($order_status=='C' && isset($seller_responce) && $seller_responce==2){
                            echo '<p><b>Seller Reject Cancel Order  from Buyer</b></p>';
                        }elseif($order_status=='C' && isset($seller_responce) && $seller_responce==3){
                            echo '<p><b>Seller Cancel the Order</b></p>';
                        }
                        ?>
			&nbsp;
		</dd>
                <dt><?php echo __('Cancel Order Reason'); ?></dt>
		<dd>
			<?php echo isset($can_select_reason)?$can_select_reason:'';?>
			&nbsp;
		</dd>
                <dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo isset($can_description)?$can_description:'';?>
			&nbsp;
		</dd>
                
                <?php
                }elseif($order_status=='F'){
                    $order_received_date=$orderdetail['OrderDetail']['order_received_date'];
                    $order_received_date_str=date('dS M, Y H:i a',strtotime($order_received_date));
                ?>
                <dt><?php echo __('Delivery Date'); ?></dt>
		<dd>
			<?php echo isset($order_received_date_str)?$order_received_date_str:'';?>
			&nbsp;
		</dd>
                <?php
                }
                ?>
		<dt><?php echo __('Status'); ?></dt>
		<dd>
			<?php echo h($order_status_text); ?>
			&nbsp;
		</dd>
	</dl>
</div>
                        </div>
                  
        </div>
</div> 



<div class="modal fade" id="RejectDispute" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog dispute-request">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Reject Dispute</h4>
            </div>
            <form class="form-horizontal" method="post" action="">
            <input type="hidden" name="form_type" value="RejectDispute">
            <input type="hidden" name="dispute_id" value="<?php echo isset($dispute_id)?$dispute_id:'';?>">
            <input type="hidden" name="order_details_id" value="<?php echo isset($order_details_id)?$order_details_id:'';?>">
            <div class="modal-body">
                <h5 class="red-txt text-center" style="margin-bottom: 15px;">By rejecting the open dispute request meant to be you are not agree with the buyer reason to open dispute.</h5>
                <div class="form-group">
                    <label for="inputEmail3" style="width: 12%; float:left; text-align: left;" class="col-sm-2 control-label">Details:</label> 
                    <div class="col-sm-10" style="width: 72%; float:right; margin-top:-25px;">
                        <textarea class="form-control" name="reject_details" rows="4"></textarea>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Reject</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="AcceptDispute" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog dispute-request">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Accept Dispute</h4>
            </div>
            <form class="form-horizontal" method="post" action="">
                <input type="hidden" name="form_type" value="AcceptDispute">
                <input type="hidden" name="dispute_id" value="<?php echo isset($dispute_id)?$dispute_id:'';?>">
                <input type="hidden" name="full_amount" value="<?php echo isset($payment_received)?$payment_received:'';?>">
                <input type="hidden" name="order_details_id" value="<?php echo isset($order_details_id)?$order_details_id:'';?>">
                <div class="modal-body">
                    <h5 class="red-txt text-center" style="margin-bottom: 15px;">By accepting the open dispute request meant to be you are agree with the
buyer reason to open dispute.</h5>

                    <div class="form-group">
                        <label style="  padding-top: 5px;    text-align: left;    width: 25%;" for="inputEmail3" class="col-sm-3 control-label">Refund Amount:</label>
                        <div class="col-sm-9" style="    width: 72%;  float: right;    margin-top: -39px;">
                            <div class="radio" style="    margin: 0;    padding-bottom: 0;">
                                <label style=" margin: 0 0 0px 20px;"> <input type="radio" name="refund_amount" class="RefundAmount" value="Full Refund" checked="checked"> $<?php echo isset($payment_received)?$payment_received:'';?> - Full Refund</label>
                            </div>
                            <div class="radio" style="    margin: 0;    padding-bottom: 0;">
                                <label style=" margin: 0 0 0px 20px;"> <input type="radio" name="refund_amount" class="RefundAmount" value="Partial Refund"> Partial Refund</label>
                            </div>
                            <input type="number" min="1" class="form-control" id="EnterAmount" name="partial_amount" placeholder="Enter Amount" style="width: 60%; margin-top:10px; margin-left:20px; display: none;"/>
                        </div>
                    </div>
                    <div class="row" style="margin-left: 0;" >
                        <label style="float: left; width:12%; text-align: right;" for="inputEmail3" class="col-sm-3 control-label">Details:</label>
                        <div class="col-sm-9" style="width: 72%; float: right;    margin-top: -25px;">
                            <textarea class="form-control" rows="4" name="details" required="required"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Accept Dispute</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">
$(document).ready(function(){
    $('.RefundAmount').click(function(){
        var RefundAmountVal=$(this).val();
        if(RefundAmountVal=='Partial Refund'){
            $('#EnterAmount').attr("required", "required");;
            $('#EnterAmount').show();
        }else{
            $('#EnterAmount').removeAttr('required');
            $('#EnterAmount').hide();
        }
    }); 
});  
</script>