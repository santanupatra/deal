<?php 
$Ord_sl_no= Configure::read('ORDER_SL_NO');
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
                                    <h4>Disputes List</h4>
                                </div>
                                <div class="col-md-12">
                                    <div class="order-search">
                                        <ul>
                                            <li><a href="<?php echo $this->webroot.'orders/awaiting_payment';?>">Awaiting Payment <span>(<?php echo $awaiting_payment;?>)</span></a></li>
                                            <li><a href="<?php echo $this->webroot.'orders/awaiting_shipment';?>">Awaiting Shipment <span>(<?php echo $awaiting_shipment;?>)</span></a></li>
                                            <li><a href="<?php echo $this->webroot.'orders/awaiting_delivery';?>">Awaiting Delivery <span>(<?php echo $awaiting_delivery;?>)</span></a></li>
                                            <li class="selected"><a href="<?php echo $this->webroot.'orders/buyer_disputes';?>">Disputes<span>(<?php echo $Disput;?>)</span></a></li>
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
                            <ul class="product_action dispute_action">
                                <li><a href="">Product</a></li>
                                <li><a href="">Problem</a></li>
                                <li><a href="">Status</a></li>
                            </ul>
                            <ul class="product_boxes">
                                <?php 
                                    $uploadFolder = "product_images";
                                    $uploadPath = WWW_ROOT . $uploadFolder;
                                                
                                    //$uploadShopPath= Configure::read('UPLOAD_SHOP_LOGO_PATH');
                                    //seller_accept
                                    if(count($orders)>0){
                                    foreach ($orders as $order): 
                                        //pr($order);
                                        $order_date=date('dS M, Y',strtotime($order['Order']['order_date']));
                                        $order_details_id=$order['OrderDetail']['id'];
                                        $order_id=$order['Order']['id'];
                                        $pay_amt=$order['OrderDetail']['amount'];
                                        $pay_price=$order['OrderDetail']['price'];
                                        $sl_no=$Ord_sl_no+$order_id;
                                        $order_status=isset($order['OrderDetail']['order_status'])?$order['OrderDetail']['order_status']:'';
                                        $product_id=isset($order['OrderDetail']['product_id'])?$order['OrderDetail']['product_id']:'';
                                        
                                        //$quantity=isset($order['OrderDetail']['quantity'])?$order['OrderDetail']['quantity']:'';
                                        $product_name=isset($order['Product']['name'])?$order['Product']['name']:'';
                                        //$product_price=isset($order['Product']['price_lot'])?$order['Product']['price_lot']:'';
                                        $prd_disput_details=$this->requestAction(array('controller' => 'orders', 'action' => 'get_dispute_details', $order_details_id, 'admin'=>false, 'prefix' => ''));
                                        if(count($prd_disput_details)>0){
                                            $dispute_date=date('dS M, Y H:i a',strtotime($prd_disput_details['Dispute']['cdate']));
                                            $seller_response=$prd_disput_details['Dispute']['seller_response'];
                                            $is_close=$prd_disput_details['Dispute']['is_close'];
                                        }
                                        
                                        $prd_img=$this->requestAction(array('controller' => 'orders', 'action' => 'get_product_image', $product_id, 'admin'=>false, 'prefix' => ''));
                                        
                                        $Prd_img_name=isset($prd_img['ProductImage']['name'])?$prd_img['ProductImage']['name']:'';
                                        
                                        if($Prd_img_name!='' && file_exists($uploadPath . '/' . $Prd_img_name)){
                                            $ShopLogoLink=$this->webroot.'product_images/'.$Prd_img_name;
                                        }else{
                                            $ShopLogoLink=$this->webroot.'product_images/default.png';
                                        }
                                        $discount_amt=($pay_price - $pay_amt);
                                ?>
                                <li>
                                    <div class="order-top">
                                        <div class="order-head1">
                                                <p>Order ID: <span><?php echo $sl_no;?></span> </p>
                                                <p>Order Date: <span><?php echo $order_date;?></span></p>
                                        </div>
                                        <div class="order-head2">
                                                <p>Dispute Date: <span><?php echo isset($dispute_date)?$dispute_date:'';?></span></p>
                                        </div>
                                        <div class="order-head3">
                                            <b>Refund Amount:<br/>
                                            <a href="Javascript: void(0);">$<?php echo $pay_amt;?></a></b>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <div class="order-bottom dispute-bottom">
                                        <div class="order_b_1">
                                            <img src="<?php echo $ShopLogoLink;?>" width="173" height="150" alt="" />
                                            <!--<a href="Javascript: void(0);">Free Shipping</a>-->
                                            <p><?php echo $product_name;?></p>
                                        </div>
                                        <div class="order_b_2 padding-top_center">
                                            <p><?php echo isset($prd_disput_details['Dispute']['select_reason'])?$prd_disput_details['Dispute']['select_reason']:'';?></p>           
                                        </div>
                                        <div class="order_b_3 padding-top_center">
                                            <?php
                                            if(isset($seller_response) && $seller_response==1 && $is_close==0){
                                                echo '<a href="'.$this->webroot.'orders/buyer_dispute_details/'.base64_encode($order_details_id).'"><button class="active">Respond</button></a>';
                                            }elseif(isset($is_close) && $is_close==1){
                                                echo '<button class="active">Closed</button>';
                                            }else{
                                                echo '<p style="text-align: center;"><b>Awaiting Response</b></p>';
                                            }
                                            ?>
                                            <a href="<?php echo $this->webroot.'orders/buyer_dispute_details/'.base64_encode($order_details_id);?>"><button>View Details</button></a>
                                            
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