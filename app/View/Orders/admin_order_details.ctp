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
		<dt><?php echo __('Coupon Name'); ?></dt>
		<dd>
			<?php echo h($product_name); ?>
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
                
                
                
		
                
	</dl>
</div>
                        </div>
                  
        </div>
</div> 



