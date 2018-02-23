<?php 
$Ord_sl_no= Configure::read('ORDER_SL_NO');
?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
                            <div class="muted pull-left">Payment Management</div>
			</div>
			<div class="block-content collapse in">
<!--                            <div class="span12">
                                <div class="order-search">
                                    <form class="form-inline" method="post" action="" name="" style="    width: 95%;    display: inline-flex;">
                                        <input type="hidden" name="form_type" value="SearchForm">
                                        <div class="span3">
                                            <input type="number" min="1" class="form-control" id="order_no" name="order_no" placeholder="Order No." value="<?php echo isset($order_no)?$order_no:'';?>">
                                        </div>
                                        <div class="span3">
                                            <input type="text" class="form-control" id="" name="product_name" placeholder="Product name" value="<?php echo isset($product_name)?$product_name:'';?>">
                                        </div>
                                        <div class="span3">
                                            <input type="text" class="form-control" id="" name="product_sku" placeholder="Product sku" value="<?php echo isset($product_sku)?$product_sku:'';?>">
                                        </div>
                                        <div class="span3">
                                            <input type="text" class="form-control" id="from_date" name="from_date" placeholder="From Date" value="<?php echo isset($from_date)?$from_date:'';?>">
                                        </div>
                                        <div class="span3">
                                            <input type="text" class="form-control" id="to_date" name="to_date" placeholder="To Date" value="<?php echo isset($to_date)?$to_date:'';?>">
                                        </div>
                                        <button style=" height: 40px; margin-left: 15px;" type="submit" class="btn btn-default">Search</button>
                                        <div class="form-group">
                                              <select name="" class="form-control">
                                                      <option>More Filter</option>
                                              </select>
                                        </div>
                                    </form>
                                </div>
                            </div>-->
				<div class="span12">
					<table class="table table-hover">
					<thead>
					<tr>
                                            <th><?php echo $this->Paginator->sort('order_id'); ?></th>
                                            <th>Product Name</th>
                                            
                                            <th>Buyer Name</th>
                                            <th>Amount</th>
                                            <th>Order Date</th>
                                            
                                            <th>Payment status</th>
                                            <th>Pay By Admin</th>
                                            <th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php 
                                        if(count($orders)>0){
                                        foreach ($orders as $product):
                                            $Order_det_id=$product['OrderDetail']['id'];
                                            $Order_id=$product['OrderDetail']['order_id'];
                                            $product_name=$product['Product']['name'];
                                            $product_sku=$product['Product']['product_code'];
                                            $buyer_name=$product['Buyer']['first_name'].' '.$product['Buyer']['last_name'];
                                            $Order_amount=$product['OrderDetail']['amount'];
                                            //$Order_id=$product['OrderDetail']['order_id'];
                                            $order_date=date('dS M, Y',strtotime($product['Order']['order_date']));
                                            $order_status=$product['OrderDetail']['payment_status'];
                                            
                                            ?>
					<tr>
                                            <td><?php echo h($Order_id+$Ord_sl_no); ?>&nbsp;</td>
                                            <td>
                                                    <?php echo h($product_name); ?>
                                            </td>
                                            
                                            <td><?php echo h($buyer_name); ?>&nbsp;</td>
                                            <td>$<?php echo h($Order_amount); ?>&nbsp;</td>
                                            <td><?php echo h($order_date); ?>&nbsp;</td>
                                            <td><?php echo h($order_status); ?>&nbsp;</td>
                                            <td><?php if($product['OrderDetail']['pay_by_admin']==0){echo 'Pending';}else{ echo 'Complete';} ?></td>
                                            
                                            
                                            
                                            <td class="actions">                                               
                                                <a href="<?php echo $this->webroot;?>admin/orders/order_details/<?php echo base64_encode($Order_det_id);?>"><img src="<?php echo $this->webroot;?>img/view.png" title="View Order"></a>

                                                <!--<a href="<?php echo $this->webroot;?>admin/products/edit/<?php echo $product['Product']['id'];?>"><img src="<?php echo $this->webroot;?>img/edit.png" title="Edit Product" width="22" height="21"></a>

                                                <a href="<?php echo $this->webroot;?>admin/products/delete/<?php echo $product['Product']['id'];?>" onclick="return confirm('Are you sure to delete?')"><img src="<?php echo $this->webroot;?>img/delete.png" title="Delete Product" width="24" height="24"></a>-->
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

