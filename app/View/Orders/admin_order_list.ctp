<?php 
$Ord_sl_no= Configure::read('ORDER_SL_NO');
?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
                            <div class="muted pull-left"><?php echo __('Order Lists'); ?></div>
			</div>
			<div class="block-content collapse in">
                            <div class="span12">
                                <div class="order-search">
                                    <form class="form-inline" method="post" action="" name="" style="    width: 95%;    display: inline-flex;">
                                        <input type="hidden" name="form_type" value="SearchForm">
                                        <div class="span3">
                                            <input type="number" min="1" class="form-control" id="order_no" name="order_no" placeholder="Order No." value="<?php echo isset($order_no)?$order_no:'';?>">
                                        </div>
                                        <div class="span3">
                                            <input type="text" class="form-control" id="" name="coupon_name" placeholder="Coupon name" value="<?php echo isset($product_name)?$product_name:'';?>">
                                        </div>
                                        <div class="span3">
                                            <input type="text" class="form-control" id="" name="coupon_code" placeholder="Coupon code" value="<?php echo isset($product_sku)?$product_sku:'';?>">
                                        </div>
                                        
                                        <button style=" height: 40px; margin-left: 15px;" type="submit" class="btn btn-default">Search</button>
                                        
                                    </form>
                                </div>
                            </div>
				<div class="span12">
					<table class="table table-hover">
					<thead>
					<tr>
                                            <th><?php echo $this->Paginator->sort('order_id'); ?></th>
                                            <th>Coupon Name</th>
                                            <th>Coupon Code</th>
                                            <th>Buyer Name</th>
                                            <th>Amount</th>
                                            <th>Purchase Date</th>
                                            
                                            <th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php 
                                        if(count($orders)>0){
                                        foreach ($orders as $product):
                                            
                                            $Order_id=$product['Order']['id'];
                                            $coupon_name=$product['Coupon']['name'];
                                            $coupon_code=$product['Order']['coupon_code'];
                                            $buyer_name=$product['User']['first_name'].' '.$product['User']['last_name'];
                                            $Order_amount=$product['Order']['total_amount'];
                                            
                                            $order_date=date('dS M, Y',strtotime($product['Order']['payment_date']));
                                           
                                            ?>
					<tr>
                                            <td><?php echo h($Order_id+$Ord_sl_no); ?>&nbsp;</td>
                                            <td><?php echo h($coupon_name); ?></td>
                                            <td><?php echo h($coupon_code); ?></td>
                                            <td><?php echo h($buyer_name); ?>&nbsp;</td>
                                            <td>$<?php echo h($Order_amount); ?>&nbsp;</td>
                                            <td><?php echo h($order_date); ?>&nbsp;</td>
                                            
                                            <td class="actions">                                               
                                                <a href="<?php echo $this->webroot;?>admin/orders/order_details/<?php echo base64_encode($Order_id);?>"><img src="<?php echo $this->webroot;?>img/view.png" title="View Order"></a>

                                                
                                            </td>
					</tr>
                   
                                        <?php endforeach;
                                        }else{
                                            echo '<tr><td colspan="8" style="text-align: center;"><b>No record fount</b></td></tr>';
                                        }
                                        ?>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /block -->
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
<style>
.actions a
{
 background:none;
 border:none;
 border-radius:0px;
 box-shadow:none;
 padding:0px;
}
</style>

<script type="text/javascript">
    $(document).ready(function(){       
        $('#from_date').datepicker({dateFormat: 'yy-mm-dd',
            //minDate: dateToday,
            onSelect: function (date, el) {
                $("#to_date").datepicker( "option", "minDate", date );
            },
            yearRange: "-150:+1"});
        $('#to_date').datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>