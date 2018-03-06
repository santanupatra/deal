<?php
$Ord_sl_no= Configure::read('ORDER_SL_NO');

$order_id=$orderdetail['Order']['id'];


$product_id=isset($orderdetail['Order']['id'])?$orderdetail['Order']['id']:'';
$product_name=isset($orderdetail['Coupon']['name'])?$orderdetail['Coupon']['name']:'';



$order_date=isset($orderdetail['Order']['payment_date'])?$orderdetail['Order']['payment_date']:'';
$order_transaction_id=isset($orderdetail['Order']['transaction_id'])?$orderdetail['Order']['transaction_id']:'';

$order_price=$orderdetail['Order']['total_amount'];

                              

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
		
		<dt><?php echo __('Store Woner Name'); ?></dt>
		<dd>
			<?php echo isset($orderdetail['Seller']['first_name'])?$orderdetail['Seller']['first_name'].' '.$orderdetail['Seller']['last_name']:''; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Buyer Name'); ?></dt>
		<dd>
			<?php echo isset($orderdetail['User']['first_name'])?$orderdetail['User']['first_name'].' '.$orderdetail['User']['last_name']:''; ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Coupon Name'); ?></dt>
		<dd>
			<?php echo h($product_name); ?>
			&nbsp;
		</dd>
		
                <dt><?php echo __('Total Pice'); ?></dt>
		<dd>
			$<?php echo h($order_price); ?>
			&nbsp;
		</dd>
		
                
	</dl>
</div>
                        </div>
                  
        </div>
</div> 



