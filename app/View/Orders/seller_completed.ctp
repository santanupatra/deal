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
                                    <h4>Completed List</h4>
                                </div>
                                <div class="col-md-12">
                                    <div class="order-search">
                                        <ul>
                                            <li><a href="<?php echo $this->webroot.'orders/index';?>">All Orders <span>(<?php echo isset($seller_all_order)?$seller_all_order:'';?>)</span></a></li>
                                            <li><a href="<?php echo $this->webroot.'orders/seller_awaiting_shipment';?>">Awaiting Shipment <span>(<?php echo isset($seller_awaiting_shipment)?$seller_awaiting_shipment:'';?>)</span></a></li>
                                            <li class="selected"><a href="<?php echo $this->webroot.'orders/seller_completed';?>">Completed <span>(<?php echo isset($seller_complete_product)?$seller_complete_product:'';?>)</span></a></li>
                                            <li><a href="<?php echo $this->webroot.'orders/seller_disputes';?>">Disputes & Refund <span>(<?php echo isset($seller_Disput)?$seller_Disput:'';?>)</span></a></li>
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
                                        $product_id=isset($order['OrderDetail']['product_id'])?$order['OrderDetail']['product_id']:'';
                                        $seller_accept_shipment=isset($order['OrderDetail']['seller_accept_shipment'])?$order['OrderDetail']['seller_accept_shipment']:'';
                                        $quantity=isset($order['OrderDetail']['quantity'])?$order['OrderDetail']['quantity']:'';
                                        $product_name=isset($order['Product']['name'])?$order['Product']['name']:'';
                                        $product_price=isset($order['Product']['price_lot'])?$order['Product']['price_lot']:'';
                                        $buyerfeed = $this->requestAction(array('controller' => 'orders', 'action' => 'get_feed', $order_details_id,$order_user_id, 'admin'=>false, 'prefix' => ''));
                                        $prd_disput_details=$this->requestAction(array('controller' => 'orders', 'action' => 'get_dispute_details', $order_details_id, 'admin'=>false, 'prefix' => ''));
                                        
                                        $prd_img=$this->requestAction(array('controller' => 'orders', 'action' => 'get_product_image', $product_id, 'admin'=>false, 'prefix' => ''));
                                        $store_name=isset($order['Shop']['name'])?$order['Shop']['name']:'';
                                        $store_slug=isset($order['Shop']['slug'])?$order['Shop']['slug']:'';
                                        $Prd_img_name=isset($prd_img['ProductImage']['name'])?$prd_img['ProductImage']['name']:'';
                                        
                                        $discount_amt=(($product_price*$quantity) - $pay_amt);
                                        if($Prd_img_name!='' && file_exists($uploadPath . '/' . $Prd_img_name)){
                                            $ShopLogoLink=$this->webroot.'product_images/'.$Prd_img_name;
                                        }else{
                                            $ShopLogoLink=$this->webroot.'product_images/default.png';
                                        }
                                        //$discount_amt=($pay_price - $pay_amt);
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
                                                <p><b>Goods  Delivered</b></p>
                                            </div>
                                            <div class="order_b_4 padding-top_center">
                                            <p style="text-align:center;"><b>Finish</b></p>
                                              <?php  if($buyerfeed==0){ ?>
                                               
                                            <p><a href="<?php echo $this->webroot;?>orders/add_to_buyer_feedback/<?php echo base64_encode($order_details_id);?>/"><button class="active">Leave Feedback</button></a></p>
						<?php } ?>
                                                <!--<p>Delivery Date: 6 Days, 3 hours, 30 mins</p>-->
                                                
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
    $('.add_tracking').click(function(){
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
});  
</script>

