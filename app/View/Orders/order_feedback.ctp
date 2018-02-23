<?php 
//$Ord_sl_no=10000000;
$Ord_sl_no= Configure::read('ORDER_SL_NO');
$uploadFolder = "product_images";
$uploadPath = WWW_ROOT . $uploadFolder;
if(count($order)>0){
    //foreach ($orderdetails as $order){
        //pr($order);
        $order_details_id=$order['OrderDetail']['id'];
        $Completion_time=date('dS M Y, H:i a',strtotime($order['OrderDetail']['order_received_date']));
        $order_id=$order['Order']['id'];
        $sl_no=$Ord_sl_no+$order_id;
        $product_id=isset($order['OrderDetail']['product_id'])?$order['OrderDetail']['product_id']:'';
        $shop_id=isset($order['OrderDetail']['shop_id'])?$order['OrderDetail']['shop_id']:'';
        
        $Seller_info=$this->requestAction(array('controller' => 'orders', 'action' => 'get_shop_details', $shop_id, 'admin'=>false, 'prefix' => ''));
        $store_name=isset($Seller_info['Shop']['name'])?$Seller_info['Shop']['name']:'';
        $prd_img=$this->requestAction(array('controller' => 'orders', 'action' => 'get_product_image', $product_id, 'admin'=>false, 'prefix' => ''));
        $Prd_img_name=isset($prd_img['ProductImage']['name'])?$prd_img['ProductImage']['name']:'';
        if($Prd_img_name!='' && file_exists($uploadPath . '/' . $Prd_img_name)){
            $ProductLink=$this->webroot.'product_images/'.$Prd_img_name;
        }else{
            $ProductLink=$this->webroot.'product_images/default.png';
        }
        $product_name=isset($order['Product']['name'])?$order['Product']['name']:'';
        $product_price=isset($order['OrderDetail']['price'])?$order['OrderDetail']['price']:'';
        $product_quantity=isset($order['OrderDetail']['quantity'])?$order['OrderDetail']['quantity']:'';
    //}
}
?>
<script src="<?php echo $this->webroot;?>js/jquery.raty-fa.js"></script>
<section class="after_login">
	<div class="container">
		<div class="row">
		    <?php echo($this->element('user_leftbar'));?>
                    
                    <div class="col-md-9">
                        <div class="product_title">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Leave Feedback for this Purchase</h4>
                                </div>
                                <div class="col-md-12">
                                    <div class="orderbosx">
                                        <h2>Order Detail</h2>
                                        <div class="order_des">
                                            <ul>
                                                <li><p>Order Number :</p><span><?php echo isset($sl_no)?$sl_no:'';?></span></li>
                                                <li><p>Seller:</p><span><?php echo isset($store_name)?$store_name:'';?></span></li>
                                                <li><p>Order Completion Time :</p><span><?php echo isset($Completion_time)?$Completion_time:'';?></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="orderbosx">
                                        <h2>Please provide Feedback for this Purchase</h2>
                                        <form action="" method="post"> 
                                            <input type="hidden" name="data[Rating][rate_this]" value="0" id="rate_this">     
                                            <input type="hidden" name="data[Rating][product_description]" value="0" id="product_description">   
                                            <input type="hidden" name="data[Rating][seller_communication]" value="0" id="seller_communication">    
                                            <input type="hidden" name="data[Rating][ship_item]" value="0" id="ship_item">    
                                            <input type="hidden" name="data[Rating][rating]" value="0" id="avg_rating">  
                                        <div class="order_des">
                                            <div class="order-mage_left">
                                                <img src="<?php echo isset($ProductLink)?$ProductLink:'';?>" height="125" alt="" />
                                            </div>
                                            <div class="order_des_right">
                                                <!--<a>Free Shipping</a>-->
                                                <p><?php echo isset($product_name)?$product_name:'';?></p> <span class="pull-right">$<?php echo isset($product_price)?$product_price:'';?> * <?php echo isset($product_quantity)?$product_quantity:'';?> Piece</span><br/>
                                                <!--<p>Product Properties: Black</p>-->
                                                <p>Rate This: <span id="ratestar1"></span> </p>
                                                <!--<textarea name="data[Rating][review]" required="required" maxlength="1000" placeholder="Share your experience to working with the seller of the project"></textarea>-->
                                                <div class="row">
                                                    <div class="col-md-8 details_rating">
                                                        <h4>Detailed Ratings:</h4>
                                                        <p>How detailed was the product description?</p>
                                                        <p>How prompt was the seller's communication?</p>
                                                        <p>How quickly did you receive your order?</p><br/>
                                                        <button type="submit" class="active">Leave Feedback</button>
                                                        <!--<button class="">Cancel</button>-->
                                                    </div>
                                                    <div class="col-md-4 review_star">
                                                        <ul>
                                                            <li><span id="ratestar2"></span> <!--<span>Accurate</span>--></li>
                                                            <li><span id="ratestar3"></span> <!--<span>Satisfied</span>--></li>
                                                            <li><span id="ratestar4"></span> <!--<span>Quick</span>--></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </form>    
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
                    
            </div>
		
	</div>
</section>

<script type="text/javascript">
function calculate_rating(){
    var rate_this =  $("#rate_this").val();
    var product_description =  $("#product_description").val(); 
    var seller_communication =  $("#seller_communication").val(); 
    var ship_item =  $("#ship_item").val(); 
    var sum = (parseInt(rate_this)+parseInt(product_description)+parseInt(seller_communication)+parseInt(ship_item))/4;
    $('#avg_rating').val(sum);
}

$(document).ready(function(){
    $("#ratestar1").raty({
        score:'0',  
        halfShow : true,
        click: function(score, evt) {
           $("#rate_this").attr("value",score);  
           calculate_rating();
        }        
    });   
    $("#ratestar2").raty({
        score:'0',  
        halfShow : true,
        click: function(score, evt) {
           $("#product_description").attr("value",score);  
           calculate_rating();
        }        
    });   
    $("#ratestar3").raty({
        score:'0',  
        halfShow : true,
        click: function(score, evt) {
           $("#seller_communication").attr("value",score);  
           calculate_rating();
        }        
    });   
    $("#ratestar4").raty({
        score:'0',  
        halfShow : true,
        click: function(score, evt) {
           $("#ship_item").attr("value",score); 
           calculate_rating();
        }        
    });   
});  
</script>

