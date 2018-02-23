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
                                    <h4>Awaiting Payment List</h4>
                                </div>
                                <div class="col-md-12">
                                    <div class="order-search">
                                        <ul>
                                            <li class="selected"><a href="<?php echo $this->webroot.'orders/awaiting_payment';?>">Awaiting Payment <span>(<?php echo $awaiting_payment;?>)</span></a></li>
                                            <li><a href="<?php echo $this->webroot.'orders/awaiting_shipment';?>">Awaiting Shipment <span>(<?php echo $awaiting_shipment;?>)</span></a></li>
                                            <li><a href="<?php echo $this->webroot.'orders/awaiting_delivery';?>">Awaiting Delivery <span>(<?php echo $awaiting_delivery;?>)</span></a></li>
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
                                <li><a href="">Product Action</a></li>
                                <li><a href="">Order Status</a></li>
                                <li><a href="">Order Action</a></li>
                            </ul>
                            <ul class="product_boxes">
                                <?php 
                                    $uploadShopPath= Configure::read('PRODUCT_IMAGE_UPLOAD_PATH');
                                    if(count($Awa_payment_list)>0){
                                    foreach ($Awa_payment_list as $order): 
                                        //pr($order);
                                        $order_date=date('dS M, Y H:i a',strtotime($order['TempCart']['cdate']));
                                        $prd_id=$order['TempCart']['prd_id'];
                                        $shop_id=$order['TempCart']['shop_id'];
                                        $name=$order['TempCart']['name'];
                                        $image=$order['TempCart']['image'];
                                        $price=$order['TempCart']['price'];
                                        $quantity=$order['TempCart']['quantity'];
                                        $pay_amt=$order['TempCart']['pay_amt'];
                                        $order_id=$order['TempCart']['id'];
                                        
                                        $sl_no=$order_id;
                                        $Seller_info=$this->requestAction(array('controller' => 'orders', 'action' => 'get_shop_details', $shop_id, 'admin'=>false, 'prefix' => ''));
                                        $store_name=isset($Seller_info['Shop']['name'])?$Seller_info['Shop']['name']:'';
                                        $store_slug=isset($Seller_info['Shop']['slug'])?$Seller_info['Shop']['slug']:'';
                                        $store_logo=isset($Seller_info['Shop']['logo'])?$Seller_info['Shop']['logo']:'';
                                        $order_owner_id=isset($Seller_info['Shop']['user_id'])?$Seller_info['Shop']['user_id']:'';
                                        if($image!=''){
                                            $ShopLogoLink=$this->webroot.'product_images/'.$image;
                                        }else{
                                            $ShopLogoLink=$this->webroot.'product_images/default.png';
                                        }
                                        
                                ?>
                                <li>
                                    <div class="order-top">
                                        <div class="order-head1">
                                                <p>Order ID: <span><?php echo $sl_no;?></span> <a href="<?php echo $this->webroot.'products/view/'.base64_encode($prd_id);?>">View Detail</a></p>
                                                <p>Order date & time : <span><?php echo $order_date;?></span></p>
                                        </div>
                                        <div class="order-head2">
                                                <p>Store Name: <span><?php echo $store_name;?></span></p>
                                                <p><a href="<?php echo $this->webroot.'shop/'.$store_slug.'/'.base64_encode($shop_id);?>">View Store</a> <i class="fa fa-envelope"></i> <span class="contact_buyer_message" buyer_id="<?php echo $order_owner_id;?>" style="cursor: pointer;">Contact Seller</span></p>
                                        </div>
                                        <div class="order-head3">
                                            <b>Order Amount:<br/>
                                            <a href="">$<?php echo $price*$quantity;?></a></b>
                                            <span class="trash">
                                                <a href="<?php echo $this->webroot.'orders/delete_cart/'.base64_encode($order_id);?>" onclick="return confirm('Are you sure you want to Cancel Order?');" style="text-decoration: none;" class="fa fa-trash"></a>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <div class="order-bottom">
                                            <div class="order_b_1">
                                                <img src="<?php echo $ShopLogoLink;?>" width="173" height="150" alt="" />
                                                <p><?php echo $name;//if($shipping_cost=='0.00'){ echo '<a href="">Free Shipping</a>';}?></p>
                                                
                                                <!--<p>2016 New Steel pipe rod
                                                Product Properties: Black</p>-->
                                            </div>
                                            <div class="order_b_2 padding-top_center">
                                                <p>Awaiting Payment</p>
                                                    <!--<p>Dispute Finished</p>
                                                    <span>(Refund Progress)</span>-->
                                            </div>
                                            <div class="order_b_3 padding-top_center">
                                                <p>Awaiting Payment</p>
                                            </div>
                                            <div class="order_b_4 padding-top_center">
                                                <a href="<?php echo $this->webroot.'shipping_addresses/review';?>" style="color: #fff;"><button class="active">Pay Now</button></a>
                                                <a href="<?php echo $this->webroot.'orders/delete_cart/'.base64_encode($order_id);?>" onclick="return confirm('Are you sure you want to Cancel Order?');" style="text-decoration: none;"><button class="active">Cancel Order</button></a>
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
    $('.contact_buyer_message').click(function(){
        var buyer_id=$(this).attr('buyer_id');
        if(buyer_id!=''){
            $("#contact_to_user_id").val(buyer_id);
            $('#contactnow').modal();
        }
    }); 
});  
</script>