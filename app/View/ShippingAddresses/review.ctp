<?php
if(isset($ShippingAdd_data) && count($ShippingAdd_data)>0){
    $shipping_id=$ShippingAdd_data['ShippingAddress']['id'];
    $full_name=$ShippingAdd_data['ShippingAddress']['full_name'];
    $street=$ShippingAdd_data['ShippingAddress']['street'];
    $apartment=$ShippingAdd_data['ShippingAddress']['apartment'];
    $city=$ShippingAdd_data['ShippingAddress']['city'];
    $state=$ShippingAdd_data['ShippingAddress']['state'];
    $zip_code=$ShippingAdd_data['ShippingAddress']['zip_code'];
    $country=$ShippingAdd_data['ShippingAddress']['country'];
    $phn_no=$ShippingAdd_data['ShippingAddress']['phn_no'];
}

if(isset($BillingAdd_data) && count($BillingAdd_data)>0){
    $shipping_id1=$BillingAdd_data['BillingAddress']['id'];
    $full_name1=$BillingAdd_data['BillingAddress']['full_name'];
    $street1=$BillingAdd_data['BillingAddress']['street'];
    $apartment1=$BillingAdd_data['BillingAddress']['apartment'];
    $city1=$BillingAdd_data['BillingAddress']['city'];
    $state1=$BillingAdd_data['BillingAddress']['state'];
    $zip_code1=$BillingAdd_data['BillingAddress']['zip_code'];
    $country1=$BillingAdd_data['BillingAddress']['country'];
    $phn_no1=$BillingAdd_data['BillingAddress']['phn_no'];
}

?>

<script type="text/javascript">
function gotoPaypal(){

    var ShippingAddress = <?php echo count($ShippingAdd_data);?>;
    var BillingAddress = <?php echo count($BillingAdd_data);?>;
    var seller_business_email=$('#seller_business_email').val();
//    if(seller_business_email==''){
//        alert('You can not purches this product because seller don\'t have the paypal business email.');
//        return false;
//    }else
        if(ShippingAddress > 0 && BillingAddress>0){
        $('#loading_modal').modal({backdrop: 'static', keyboard: false});
        var order_message = $('#order_message').val();
        var chkOrdMsg=true;
        if(order_message!=''){
            var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
            var ord_message_check =order_message.match(exp);
            //alert(ord_message_check);
            if(ord_message_check!=null){
                $('#TextErrorMsg').show();
                $('#order_message').focus();
                $('#loading_modal').modal('hide');
                var chkOrdMsg=false;
            }else{
                $('#TextErrorMsg').hide();
            }
        }
//        if(chkOrdMsg){
//            $.ajax({
//                url: "<?php echo $this->webroot;?>shipping_addresses/payment",
//                type: "POST",
//                data: {'ord_msg':order_message},
//                success: function(res){
//                    if(res=='success'){
//                        //document.PayPalCheckoutForm.submit();
//                        paypal_adaptive_payments();
//                    }
//                }
//            });
//        }

if(chkOrdMsg){
    window.location.href ="<?php echo $this->webroot;?>shipping_addresses/payment";
    }

}else{
        alert('Pleace add shipping address and billing address.');
        return false;
    }
}


 function paypal_adaptive_payments(){

        var seller_business_email=$('#seller_business_email').val();
        var paypal_amount=$('#tot_amount').val();
        var paypal_custom=$('#custom_data').val();

        $.ajax({
            url: "<?php echo $this->webroot;?>shipping_addresses/paybypaypal",
            type: "POST",
            data: {'seller_business_email':seller_business_email,'paypal_custom':paypal_custom,'paypal_amount':paypal_amount},
            success: function(respro)
            {
                var resproSplit = respro.split('|');
                if(resproSplit[0]=='SUCCESS'){
                    $('#loading_modal').modal('hide');
                    window.location.href=resproSplit[1];
                } else {
                    $('#loading_modal').modal('hide');
                    $('#paymentMsg').show();
                    $('#paymentMsg').html('');
                    $('#paymentMsg').html(resproSplit[1]);
                }
            }
        });
    //}

}


function chkValid(){
	if(document.getElementById('full_name').value=='')
	{
		$("#errorRow1").html('Please enter Full Name');
		document.getElementById('full_name').focus();
		return false;
	}
	else if(document.getElementById('country_id').value=='')
	{
		$("#errorRow8").html('Please select Country');
		document.getElementById('country_id').focus();
		return false;
	}
	else if(document.getElementById('street').value=='')
	{
		$("#errorRow9").html('Please enter Street');
		document.getElementById('street').focus();
		return false;
	}
	else if(document.getElementById('city').value=='')
	{
		$("#errorRow11").html('Please enter City');
		document.getElementById('city').focus();
		return false;
	}
	else if(document.getElementById('state').value=='')
	{
		$("#errorRow12").html('Please enter State');
		document.getElementById('state').focus();
		return false;
	}
	else if(document.getElementById('zip_code').value=='')
	{
		$("#errorRow13").html('Please enter Zip Code');
		document.getElementById('zip_code').focus();
		return false;
	}
	else
	{
		return true;
	}
}
</script>


<section class="after_login mt-4">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-danger" id="paymentMsg" style="display: none;"></div>
            </div>
            <div class="col-sm-12 mb-4">
              <div class="row">
                <div class="col-sm-6 ">
                  <a href="<?php echo ($this->webroot);?>products/cart" class="btn btn-default"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to cart list</a>
                </div>
                <div class="col-sm-6 text-right">
                  <a href="" class="btn btn-primary">Review your Order</a>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="row">
                <div class="col-sm-6 col-md-4 col-lg-6">
                    <h3 class="font-20 mt-2 mb-4 font-weight-700">1. Select your shipping address:</h3>
                    <div class=""><a data-target="#address_add_modal" href="Javascript: void(0);" data-toggle="modal" class="btn btn-default"><i class="fa fa-plus"></i> Add New Address</a></div>
                    <?php if(isset($ShippingAdd_data) && count($ShippingAdd_data)>0){?>
                    <div class="shipping-info-hold">
                            <h4 class=" font-18"><?php echo isset($full_name)?$full_name:'';?></h4>
                            <p class="mb-0">House no. <?php echo isset($apartment)?$apartment:'';?>, Street no. <?php echo isset($street)?$street:'';?>, Town. <?php echo isset($city)?$city:'';?>, <?php echo isset($state)?$state:'';?> </p>
                            <p class="mb-0"><?php echo isset($city)?$city:'';?>, <?php echo isset($state)?$state:'';?>, <?php echo isset($zip_code)?$zip_code:'';?></p>
                            <p class="mb-0"><?php echo (isset($country) && $country==1)?'Canada':'USA';?></p>
                            <p class="mb-0">Phone Number: <?php echo isset($phn_no)?$phn_no:'';?></p>
                            <div class="row my-3">
                              <div class="col-12">
                                <a href="Javascript: void(0);" data-target="#address_edit_modal" data-toggle="modal" class="edit"><i class="fa fa-edit"></i></a>
                                <a href="<?php echo ($this->webroot);?>shipping_addresses/delete/<?php echo isset($shipping_id)?$shipping_id:'';?>" class="edit delete ml-2"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                              </div>
                            </div>
                    </div>
                    <?php }?>
                </div>

                  <!--Billing address-->

                <div class="col-sm-6 col-md-4 col-lg-6">
                    <h3 class="font-20 mt-2 mb-4 font-weight-700">2. Select your billing address:</h3>
                    <div class=""><a data-target="#billing_address_add_modal" href="Javascript: void(0);" data-toggle="modal" class="btn btn-default"><i class="fa fa-plus"></i> Add New Address</a></div>
                    <?php if(isset($BillingAdd_data) && count($BillingAdd_data)>0){?>
                    <div class="shipping-info-hold">
                            <h4 class=" font-18"><?php echo isset($full_name1)?$full_name1:'';?></h4>
                            <p class="mb-0">House no. <?php echo isset($apartment1)?$apartment1:'';?>, Street no. <?php echo isset($street1)?$street1:'';?>, Town. <?php echo isset($city1)?$city1:'';?>, <?php echo isset($state1)?$state1:'';?> </p>
                            <p class="mb-0"><?php echo isset($city1)?$city1:'';?>, <?php echo isset($state1)?$state1:'';?>, <?php echo isset($zip_code1)?$zip_code1:'';?></p>
                            <p class="mb-0"><?php echo (isset($country1) && $country1==1)?'Canada':'USA';?></p>
                            <p class="mb-0">Phone Number: <?php echo isset($phn_no1)?$phn_no1:'';?></p>
                            <div class="row my-3">
                              <div class="col-12">
                                <a href="Javascript: void(0);" data-target="#billing_address_edit_modal" data-toggle="modal" class="edit"><i class="fa fa-edit"></i></a>
                                <a href="<?php echo ($this->webroot);?>shipping_addresses/delete_billing_address/<?php echo isset($shipping_id1)?$shipping_id1:'';?>" class="edit delete ml-2"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                              </div>
                            </div>
                    </div>
                    <?php }?>
                </div>
              </div>
            </div>


            <div class="col-12">
              <h3 class="font-20 my-5 font-weight-700">3. Review and confirm your order (<?php echo ($cart?count($cart).' items':'0 item'); ?>):</h3>
            </div>






            <div class="col-12">
              <div class="table-responsive">
               <table class="table checkout-table">
                  <thead>
                     <tr>
                        <th>PRODUCT</th>
                        <th>Item</th>
                        <th class="">Quantity</th>
                        <th class="">Item Price</th>
                        <th class="text-right">Price</th>
                     </tr>
                  </thead>
                  <tbody>
                      <?php
                                    $totalPrice = 0;
                                    $Discount_coupon_arr=array();
                                    if($cart){
                                        foreach ($cart as $product){
                                            $sub = ($product['TempCart']['quantity']*($product['TempCart']['price']+$product['ShippingDay']['ship_charge']));

                                            //$dis= $product['TempCart']['pay_amt'];

                                            $coupon_id = $product['TempCart']['coupon_id'];
                                            $temp_cart_id = $product['TempCart']['id'];
                                            $temp_prd_id=$product['TempCart']['prd_id'];
                                            $coupon_str='';
                                            if($coupon_id!=''){
                                                $ExpCouponID =  explode(',', $coupon_id);
                                                if(count($ExpCouponID)>0){
                                                    $DisCountAmt=0;
                                                    foreach($ExpCouponID as $valCid){
                                                        if($valCid!=''){
                                                            $CalDiscount_price = $this->requestAction(array('controller' => 'shipping_addresses', 'action' => 'calculate_discount', $valCid,$product['TempCart']['price'],$product['TempCart']['quantity'],$temp_cart_id, 'admin'=>false, 'prefix' => ''));
                                                            $Coupon_name=isset($CalDiscount_price['coupon_name'])?$CalDiscount_price['coupon_name']:'';
                                                            $Coupon_amount=isset($CalDiscount_price['deduct_amt'])?$CalDiscount_price['deduct_amt']:0;
                                                            //pr($CalDiscount_price);
                                                            if($Coupon_amount != 0){
                                                                $coupon_str.='<b class="prod-prop">Coupon Apply: '.$Coupon_name.' Discount Amount US $'.$Coupon_amount.'</b>';
                                                                if (array_key_exists($Coupon_name, $Discount_coupon_arr)) {
                                                                    $GetPreval=$Discount_coupon_arr[$Coupon_name];
                                                                    $Discount_coupon_arr[$Coupon_name]=$GetPreval+$Coupon_amount;
                                                                }else{
                                                                    $Discount_coupon_arr[$Coupon_name]=$Coupon_amount;
                                                                }
                                                                $DisCountAmt+=$Coupon_amount;
                                                            }
                                                        }
                                                    }
                                                    $CalDisPrice=($sub-$DisCountAmt);
                                                    $this->requestAction(array('controller' => 'shipping_addresses', 'action' => 'calculate_net_pay', $CalDisPrice,$temp_cart_id, 'admin'=>false, 'prefix' => ''));
                                                }
                                            }else{
                                                $this->requestAction(array('controller' => 'shipping_addresses', 'action' => 'calculate_net_pay', $sub,$temp_cart_id, 'admin'=>false, 'prefix' => ''));
                                            }

                                            $product_woner_id = $product['TempCart']['product_woner_id'];
                                            if($product_woner_id!=''){
                                                $UserDetails = $this->requestAction(array('controller' => 'users', 'action' => 'get_user_details', $product_woner_id, 'admin'=>false, 'prefix' => ''));
                                                $SellerName=$UserDetails['User']['first_name'].' '.$UserDetails['User']['last_name'];
                                                $Seller_paypal_business_email=$UserDetails['User']['paypal_business_email'];
                                            }
                                            $product_details=$this->requestAction(array('controller' => 'products', 'action' => 'get_product_details', $temp_prd_id, 'admin'=>false, 'prefix' => ''));
                                            //$percentage = $product['TempCart']['percentage'];
                                    ?>



                      <tr>

                                            <td colspan="2"><p style="text-align: left;">Seller: <?php echo isset($SellerName)?$SellerName:'';?></p></td>
                                        </tr>
                     <tr>
                        <form method="post" action="/team6/widding/products/edit_quantity" name=""></form>
                        <td>
                           <div class="prod-image" style="width:100px">
                               <?php if(!empty($product['TempCart']['image'])) { ?>
                               <img src="<?php echo $this->webroot.'product_images/'.$product['TempCart']['image']?>" alt="" class="img-fluid">
                               <?php }else{ ?>
                               <img src="<?php echo($this->webroot)?>product_images/default.png" alt="" class="img-fluid"><?php } ?>
                           </div>
                        </td>
                        <td>
                           <b><?php echo $product['TempCart']['name'];?></b>
                           <h6 class="text-grey"></h6>
                        </td>
                        <td class="">
                           <span id="quantity_list_52"><?php echo $product['TempCart']['quantity'];?></span>
                        </td>
                        <td>
                           <span>$<?php echo $product['TempCart']['price'];?></span>
                        </td>
                        <input name="cart_prd_id" value="52" type="hidden">
                        <td class="text-right">
                           <h5><?php echo $product['TempCart']['quantity'];?> X US $<?php echo $product['TempCart']['price'];?></h5>
                        </td>
                     </tr>

                     <tr>
                        <td colspan="10" class="text-right">
                           <h5 class="font-weight-bold"> Subtotal: <?php echo '$'.$sub;?> </h5>
                           <div class="small">1x shipping charge: <?php if($product['ShippingDay']['ship_charge']!=''){ echo '$'.$product['ShippingDay']['ship_charge'];}else{ echo 'Free';}?></div>
                        </td>
                     </tr>
                     <?php
                                            $totalPrice = $totalPrice + $sub;
                                            //$totalPrice = $totalPrice + $dis;
                                        }
                                    }?>
                     <tr>
                        <td colspan="10" class="text-right">
                            <div class="row">
<!--                            <div class="col-sm-6">
                            <form class="form-inline" method="post" action="">
                            <div id="Coupon_form">
                                <div class="form-group">
                                    <label for="CouponCode">Enter coupon code:</label>
                                    <input type="text" class="form-control" id="CouponCode" name="CouponCode">
                                    <button type="button" class="btn btn-primary apply_coupon d-inline-block ml-3">Apply</button>
                                </div>
                            
                                <div class="form-group">
                                    <label for="exampleInputName2"></label>
                                </div>
                                <div id="AjaxResMsg"></div>
                            </div>
                            <div id="AjaxResponceCoupon"></div>
                            </form>
                            </div>-->

                            <div class="col-sm-12">
                                <label for="exampleInputName2"></label>
                                <h5 class="font-weight-bold"> All Total: <span id="all_total_price"><?php echo '$'.$totalPrice;?></span> </h5>
                           <a class="btn btn-primary" onclick="gotoPaypal()" >Pay Now</a>
                            </div>
                            </div>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </div>
            </div>
            <input type="hidden" id="order_message">
<!--            <div class="col-12">
              <p><strong>Leave a message for this seller:</strong></p>
              <div class="form-group mb-0">
                  <textarea class="form-control" rows="4"  name="order_message" id="order_message" style="max-width: 500px"></textarea>
              </div>
              <p><small class="gry-txt">1000 English characters maximum. Not HTML codes.</small></p>
              <p class="red-txt error_msg_text" id="TextErrorMsg"> Please remove all website links</p>
              <p>
                <button type="button" name="button" class="btn btn-primary">Send</button>
              </p>


            </div>-->

        </div>
    </div>
</section>
<!-- onclick="gotoPaypal()" -->
<?php //$CouponIdArr=$this->Session->read('CouponId'); pr($CouponIdArr);?>
<script>
$(document).ready(function(){
    var currenturl = $(location).attr('href');
    $('.apply_coupon').click(function (){
        var CouponCode=$('#CouponCode').val();
        var tot_amount=$('#tot_amount').val();
        if(CouponCode!=''){
            $.ajax({
                url: "<?php echo $this->webroot;?>shipping_addresses/coupon_code_check",
                type: "POST",
                data: {'CouponCode':CouponCode,'tot_amount':tot_amount},
                success: function(res){
                    if(res.indexOf("success") >= 0){
                        $('#Coupon_form').hide();
                        //document.PayPalCheckoutForm.submit();
                        var DataSplit = res.split('#');
                        var TotAmt=DataSplit[1];
                        var DiscountAmt=DataSplit[2];
                        //$('#tot_amount').val(TotAmt);

                        $('#AjaxResponceCoupon').append('<div><div class="form-group"><label for="">Coupon Name: "'+CouponCode+'"</label></div><label for="exampleInputName2"> Deduct Amount US $'+DiscountAmt+'</label></div>');

                        $('#CouponSubTot').append('<h4 class="text-right"><span class="gry-txt">'+CouponCode+':</span> - US $'+DiscountAmt+'</h4>');
                        $('#all_total_price').html('');
                        $('#all_total_price').html('$'+TotAmt);
                        //window.location.href = currenturl;
                    }else{
                        $('#AjaxResMsg').html('');
                        $('#AjaxResMsg').html('<p style="color: #B60E09;"><b>Error Message:</b> '+res+'</p>');
                    }

                }
            });
        }else{
            alert('Pleace enter coupon code.');
            $("#CouponCode").css('border', '1px solid #ff0000');
            $("#CouponCode").focus();
            return false;
        }
    });

    $('.add_more_coupon').click(function (){
        $('#Coupon_form').show();
    });
});
</script>


<?php
//$totalPrice = 0;
//$sub = 0;
$custom = '';
//define('SITEURL','http://107.170.152.166/twop/');
if(isset($cart)){
    foreach($cart as $product){
        //$sub = ($product['TempCart']['quantity']*$product['TempCart']['price']);
        //$totalPrice = $totalPrice + $sub;
        $custom .= $product['TempCart']['id'].'_'.$product['TempCart']['quantity'].'@@@@';
    }
    $custom .= '###'.$totalPrice;
?>
<!--	<form id="PayPalCheckoutForm" name="PayPalCheckoutForm" method="post" accept-charset="utf-8" action="https://www.paypal.com/us/cgi-bin/webscr" method="post">-->
<!--<form id="PayPalCheckoutForm" name="PayPalCheckoutForm" method="post" accept-charset="utf-8" action="https://www.sandbox.paypal.com/us/cgi-bin/webscr">
        <input type="hidden" name="cmd" value="_xclick"/>
        <input type="hidden" name="business" value="<?php echo($paypal_email)?>"/>
        <input type="hidden" name="item_name" value="TWOP Purchase"/>
        <input type="hidden" name="return" value="<?php echo(SITEURL);?>orders/confirm"/>
        <input type="hidden" name="cancel_return" value="<?php echo(SITEURL);?>orders/cancel"/>
        <input type="hidden" name="amount" id="tot_amount" value="<?php echo($totalPrice)?>"/>
        <input type="hidden" name="currency_code" value="USD"/>
        <input type="hidden" name="rm" value="2"/>
        <input type="hidden" name="no_note" value="1" />
        <input type="hidden" name="src" value="1"/>
        <input type="hidden" name="sra" value="1"/>
        <input type="hidden" name="custom" value="<?php echo($custom)?>"/>
</form>-->
<input type="hidden" name="custom" id="custom_data" value="<?php echo($custom)?>"/>
<input type="hidden" name="amount" id="tot_amount" value="<?php echo($totalPrice)?>"/>
<input type="hidden" name="seller_business_email" id="seller_business_email" value="<?php echo($Seller_paypal_business_email)?>"/>

<?php
}
?>


<div class="modal fade" id="address_add_modal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Shipping Address</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form name="ShippingAddressAddForm" action="<?php echo ($this->webroot);?>shipping_addresses/add" method="post" accept-charset="utf-8">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="data[ShippingAddress][full_name]" required="required" />
                    </div>
                    <div class="form-group">
                        <label for="country_id">Country</label>
                        <select name="data[ShippingAddress][country]" id="country_id" class="form-control" required="required">
                                <option value="">-Select Country-</option>
                                <?php
                                if($countries){
                                    foreach($countries as $k=>$v){
                                ?>
                                    <option value="<?php echo($k);?>"><?php echo($v);?></option>
                                <?php
                                    }
                                }
                                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="street">Street</label>
                        <input type="text" class="form-control" id="street" name="data[ShippingAddress][street]" required="required"/>
                    </div>
                    <div class="form-group">
                        <label for="apartment">Apt/Suite/Other</label>
                        <input type="text" class="form-control" id="apartment" name="data[ShippingAddress][apartment]" />
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="data[ShippingAddress][city]" required="required"/>
                    </div>
                    <div class="form-group">
                        <label for="state">State/Province/Region</label>
                        <input type="text" class="form-control" id="state" name="data[ShippingAddress][state]" required="required"/>
                    </div>
                    <div class="form-group">
                        <label for="zip_code">Zip / Postal Code </label>
                        <input type="text" class="form-control" id="zip_code" name="data[ShippingAddress][zip_code]" maxlength="6" required="required"/>
                    </div>
                    <div class="form-group">
                        <label for="phn_no">Phone Number</label>
                        <input type="text" class="form-control" id="phn_no" name="data[ShippingAddress][phn_no]" required="required"/>
                    </div>
                    <div class="form-group">
                        <label for="default_add">Default Address</label>
                        &nbsp; <input type="radio" name="data[ShippingAddress][is_primary]" value="1" checked="checked"> Yes &nbsp; <input type="radio" name="data[ShippingAddress][is_primary]" value="0"> No

                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btnsearch" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Add billing address-->
<div class="modal fade" id="billing_address_add_modal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Billing Address</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form name="ShippingAddressAddForm" action="<?php echo ($this->webroot);?>shipping_addresses/add_billing_address" method="post" accept-charset="utf-8">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="data[BillingAddress][full_name]" required="required" />
                    </div>
                    <div class="form-group">
                        <label for="country_id">Country</label>
                        <select name="data[BillingAddress][country]" id="country_id" class="form-control" required="required">
                                <option value="">-Select Country-</option>
                                <?php
                                if($countries){
                                    foreach($countries as $k=>$v){
                                ?>
                                    <option value="<?php echo($k);?>"><?php echo($v);?></option>
                                <?php
                                    }
                                }
                                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="street">Street</label>
                        <input type="text" class="form-control" id="street" name="data[BillingAddress][street]" required="required"/>
                    </div>
                    <div class="form-group">
                        <label for="apartment">Apt/Suite/Other</label>
                        <input type="text" class="form-control" id="apartment" name="data[BillingAddress][apartment]" />
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="data[BillingAddress][city]" required="required"/>
                    </div>
                    <div class="form-group">
                        <label for="state">State/Province/Region</label>
                        <input type="text" class="form-control" id="state" name="data[BillingAddress][state]" required="required"/>
                    </div>
                    <div class="form-group">
                        <label for="zip_code">Zip / Postal Code </label>
                        <input type="text" class="form-control" id="zip_code" name="data[BillingAddress][zip_code]" maxlength="6" required="required"/>
                    </div>
                    <div class="form-group">
                        <label for="phn_no">Phone Number</label>
                        <input type="text" class="form-control" id="phn_no" name="data[BillingAddress][phn_no]" required="required"/>
                    </div>
                    <div class="form-group">
                        <label for="default_add">Default Address</label>
                        &nbsp; <input type="radio" name="data[BillingAddress][is_primary]" value="1" checked="checked"> Yes &nbsp; <input type="radio" name="data[BillingAddress][is_primary]" value="0"> No

                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btnsearch" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="address_edit_modal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Shipping Address</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form name="ShippingAddressAddForm" action="<?php echo ($this->webroot);?>shipping_addresses/edit_address" method="post" accept-charset="utf-8">
                    <input type="hidden" name="data[ShippingAddress][id]" value="<?php echo isset($shipping_id)?$shipping_id:'';?>">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="data[ShippingAddress][full_name]" required="required" value="<?php echo isset($full_name)?$full_name:'';?>" />
                    </div>
                    <div class="form-group">
                        <label for="country_id">Country</label>
                        <select name="data[ShippingAddress][country]" id="country_id" class="form-control" required="required">
                                <option value="">-Select Country-</option>
                                <?php
                                if($countries){
                                    foreach($countries as $k=>$v){
                                ?>
                                <option value="<?php echo($k);?>" <?php if(isset($country) && $country==$k){ echo 'selected="selected"';}?>><?php echo($v);?></option>
                                <?php
                                    }
                                }
                                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="street">Street</label>
                        <input type="text" class="form-control" id="street" name="data[ShippingAddress][street]" required="required" value="<?php echo isset($street)?$street:'';?>"/>
                    </div>
                    <div class="form-group">
                        <label for="apartment">Apt/Suite/Other</label>
                        <input type="text" class="form-control" id="apartment" name="data[ShippingAddress][apartment]" value="<?php echo isset($apartment)?$apartment:'';?>"/>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="data[ShippingAddress][city]" required="required" value="<?php echo isset($city)?$city:'';?>"/>
                    </div>
                    <div class="form-group">
                        <label for="state">State/Province/Region</label>
                        <input type="text" class="form-control" id="state" name="data[ShippingAddress][state]" required="required" value="<?php echo isset($state)?$state:'';?>"/>
                    </div>
                    <div class="form-group">
                        <label for="zip_code">Zip / Postal Code </label>
                        <input type="text" class="form-control" id="zip_code" name="data[ShippingAddress][zip_code]" maxlength="6" required="required" value="<?php echo isset($zip_code)?$zip_code:'';?>"/>
                    </div>
                    <div class="form-group">
                        <label for="phn_no">Phone Number</label>
                        <input type="text" class="form-control" id="phn_no" name="data[ShippingAddress][phn_no]" required="required" value="<?php echo isset($phn_no)?$phn_no:'';?>"/>
                    </div>
                    <!--<div class="form-group">
                        <label for="default_add">Default Address</label>
                        &nbsp; <input type="radio" name="data[ShippingAddress][is_primary]" value="1" checked="checked"> Yes &nbsp; <input type="radio" name="data[ShippingAddress][is_primary]" value="0"> No

                    </div>-->
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btnsearch" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!--Edit Billing Address-->
<div class="modal fade" id="billing_address_edit_modal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Billing Address</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form name="ShippingAddressAddForm" action="<?php echo ($this->webroot);?>shipping_addresses/edit_billing_address" method="post" accept-charset="utf-8">
                    <input type="hidden" name="data[BillingAddress][id]" value="<?php echo isset($shipping_id1)?$shipping_id1:'';?>">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="data[BillingAddress][full_name]" required="required" value="<?php echo isset($full_name1)?$full_name1:'';?>" />
                    </div>
                    <div class="form-group">
                        <label for="country_id">Country</label>
                        <select name="data[BillingAddress][country]" id="country_id" class="form-control" required="required">
                                <option value="">-Select Country-</option>
                                <?php
                                if($countries){
                                    foreach($countries as $k=>$v){
                                ?>
                                <option value="<?php echo($k);?>" <?php if(isset($country1) && $country1==$k){ echo 'selected="selected"';}?>><?php echo($v);?></option>
                                <?php
                                    }
                                }
                                ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="street">Street</label>
                        <input type="text" class="form-control" id="street" name="data[BillingAddress][street]" required="required" value="<?php echo isset($street1)?$street1:'';?>"/>
                    </div>
                    <div class="form-group">
                        <label for="apartment">Apt/Suite/Other</label>
                        <input type="text" class="form-control" id="apartment" name="data[BillingAddress][apartment]" value="<?php echo isset($apartment1)?$apartment1:'';?>"/>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="data[BillingAddress][city]" required="required" value="<?php echo isset($city1)?$city1:'';?>"/>
                    </div>
                    <div class="form-group">
                        <label for="state">State/Province/Region</label>
                        <input type="text" class="form-control" id="state" name="data[BillingAddress][state]" required="required" value="<?php echo isset($state1)?$state1:'';?>"/>
                    </div>
                    <div class="form-group">
                        <label for="zip_code">Zip / Postal Code </label>
                        <input type="text" class="form-control" id="zip_code" name="data[BillingAddress][zip_code]" maxlength="6" required="required" value="<?php echo isset($zip_code1)?$zip_code1:'';?>"/>
                    </div>
                    <div class="form-group">
                        <label for="phn_no">Phone Number</label>
                        <input type="text" class="form-control" id="phn_no" name="data[BillingAddress][phn_no]" required="required" value="<?php echo isset($phn_no1)?$phn_no1:'';?>"/>
                    </div>
                    <!--<div class="form-group">
                        <label for="default_add">Default Address</label>
                        &nbsp; <input type="radio" name="data[ShippingAddress][is_primary]" value="1" checked="checked"> Yes &nbsp; <input type="radio" name="data[ShippingAddress][is_primary]" value="0"> No

                    </div>-->
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btnsearch" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="loading_modal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
        <div class="modal-content">
            <!--<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Shipping Address</h4>
            </div>-->
            <div class="modal-body">
                <div class="form-group" style="height: 200px; padding-top: 70px;">
                    <center><p>Please wait...</p>
                        <img src="<?php echo $this->webroot?>img/ajax-loader.gif" alt="Loading">
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .error_msg_text{
        display: none;
    }
</style>
