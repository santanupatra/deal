 <!--   product  details   -->

    <section class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="thumbnail-img-zoom">
                        <div class="easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                            <a href="<?php echo($this->webroot)?>product_images/<?php echo($product_details['ProductImage'][0]['name']);?>">
                                <?php if(isset($product_details['ProductImage'][0]['name'])) { ?>
                                <img src="<?php echo($this->webroot)?>product_images/<?php echo($product_details['ProductImage'][0]['name']);?>" alt="" />
                                <?php }else{ ?>
                           <img src="<?php echo($this->webroot)?>product_images/default.png" alt="">
                                <?php } ?>
                            </a>
                        </div>
<?php //pr($product_images);?>
                        <ul class="thumbnails">
                            <?php foreach($product_images as $pi){?>
                            <li>
                                <a href="<?php echo($this->webroot)?>product_images/<?php echo($pi['ProductImage']['name']);?>" data-standard="<?php echo($this->webroot)?>product_images/<?php echo($pi['ProductImage']['name']);?>">
                                    <img src="<?php echo($this->webroot)?>product_images/<?php echo($pi['ProductImage']['name']);?>" alt="" />
                                </a>
                            </li>
                            <?php } ?>
<!--                            <li>
                                <a href="img/dress-2.jpg" data-standard="img/dress-2.jpg">
                                    <img src="img/dress-2.jpg" alt="" />
                                </a>
                            </li>
                            <li>
                                <a href="img/dress-3.jpg" data-standard="img/dress-3.jpg">
                                    <img src="img/dress-3.jpg" alt="" />
                                </a>
                            </li>-->
                        </ul>
                    </div>
                </div>











                <div class="col-lg-7">
                    <?php $imgName = $product_details['ProductImage'][0]['name']; ?>
                    <h4><?php echo $product_details['Product']['name'];?></h4>
                    <a href="javascript: select_friend_foot(<?php echo $product_details['User']['id'];?>)"  style="display: inline-block"> <div class="user userCurrent" data-id=<?php echo $product_details['User']['id'];?> style="color: #deb3b4; "> <?php if($product_details['User']['is_active']==1){?> <span class="on_line on_<?php echo $product_details['User']['id'];?>" ><i class="" aria-hidden="true"><img src='<?php echo ($this->webroot)?>img/chaticon.png' height="30px" width="30px"></i></span><?php }else{ ?><span class="off_line off_<?php echo $product_details['User']['id'];?>"><i class="ion-chatbox" aria-hidden="true"></i></span><?php } ?>
                            <label style="margin-left: 17px;"><?php echo $product_details['User']['first_name'].' '.$product_details['User']['last_name'];?></label>
                        </div></a>
                    <form name="ListingCart" id="ListingCart"  method="post" autocomplete="off">
                <input type="hidden" name="data[TempCart][shop_id]" id="productShopId" class="contact_text_box" value="<?php echo((isset($product_details['Product']['shop_id']) && $product_details['Product']['shop_id']!='')?$product_details['Product']['shop_id']:0);?>">
                <input type="hidden" name="data[TempCart][prd_id]" id="productListId" class="contact_text_box" value="<?php echo((isset($product_details['Product']['id']) && $product_details['Product']['id']!='')?$product_details['Product']['id']:0);?>">
                <input type="hidden" name="data[TempCart][name]" id="productName" class="contact_text_box" value="<?php echo((isset($product_details['Product']['name']) && $product_details['Product']['name']!='')?$product_details['Product']['name']:'');?>">
                <input type="hidden" name="data[TempCart][image]" id="productImage" class="contact_text_box" value="<?php echo((isset($imgName) && $imgName!='')?$imgName:'');?>">
                <input type="hidden" name="data[TempCart][item_description]" id="productImage" class="contact_text_box" value="<?php echo((isset($product_details['Product']['item_description']) && $product_details['Product']['item_description']!='')?$product_details['Product']['item_description']:0);?>">
                <input type="hidden" name="data[TempCart][price_lot]" id="productPrice" class="contact_text_box" value="<?php echo((isset($product_details['Product']['price_lot']) && $product_details['Product']['price_lot']!='')?$product_details['Product']['price_lot']:0);?>">

                <!--<input type="hidden" name="data[TempCart][shipping_time]" id="productShippingTime" class="contact_text_box" value="<?php echo((isset($product_details['Product']['shipping_time']) && $product_details['Product']['shipping_time']!='')?$product_details['Product']['shipping_time']:'');?>">-->
                <input type="hidden" name="data[TempCart][processing_time]" id="productProcessingTime" class="contact_text_box" value="<?php echo((isset($product_details['Product']['processing_time']) && $product_details['Product']['processing_time']!='')?$product_details['Product']['processing_time']:'');?>">
                                <input type="hidden" name="data[TempCart][product_woner_id]" id="product_woner_id" class="contact_text_box" value="<?php echo((isset($product_details['Product']['user_id']) && $product_details['Product']['user_id']!='')?$product_details['Product']['user_id']:'');?>">

                    <div><span class="stars"><?php if($avgrating[0][0]['avg_rating']!=''){echo $avgrating[0][0]['avg_rating'];}else{ echo 0;}?></span></div>
                    <h5 class="price mt-4">Price: <span>$<?php if($product_details['ProductVariation'][0]['price']!=''){ echo $product_details['ProductVariation'][0]['price'];}else{ echo $product_details['Product']['price_lot'];}?></span></h5>


                    <div class="form-group form-inline mt-4">
                        <label class="mr-3">Quantity</label>
                        <input type="number" name="data[TempCart][quantity]" id="productQuantity" class="contact_text_box" placeholder="Enter Quantity" style="width:120px;" value="1">
                    </div>


<!--                    <ul class="product-overview list-unstyled">
                        <h5>Overview</h5>
                        <li>Handmade item</li>
                        <li>Occasion: Wedding</li>
                        <li>Materials: Lace, Tule, Satin</li>
                        <li>Made to order</li>
                        <li>Ships worldwide from Belarus</li>
                    </ul>-->
                    <div class=" mt-4">
                      <!-- Go to www.addthis.com/dashboard to customize your tools --> <div class="addthis_inline_share_toolbox" data-title="<?php echo $product_details['Product']['name']; ?>" data-src="<?php echo($this->webroot)?>product_images/<?php echo($product_details['ProductImage'][0]['name']);?>"></div>
                    </div>

<div id="size" style="display: flex; align-items: center;"></div>
<style media="screen">
  #size p{
    margin-bottom: 0;
    padding: 0 10px;
  }
  #size input{
    margin-right: 10px;
  }
</style>

                    <?php if(!empty($product_variation)){?>
                            <div>

                       <div class="shippingPart" style=" display: flex; margin-top: 15px; ">

                            <?php
                            //pr($product_variation);
                            foreach($product_variation as $pv){
                                if($pv['ProductVariation']['color_id']!='' && $pv['ProductVariation']['size'] == ''){
                                ?>
                           <div class="form-check-label"  style=" margin-right: 15px; border:none">
                               <input type="radio" id="variation"  name="data[TempCart][price]" value="<?php echo $pv['Color']['color_name'] . '_' . $pv['ProductVariation']['price'] ?>" >
                                           <label><?php echo $pv['Color']['color_name'] ?>  </label>
                                           <p>Price: <?php echo $pv['ProductVariation']['price'] ?></p>
                                       </div>

                             <?php }else if($pv['ProductVariation']['color_id']!='' && $pv['ProductVariation']['size']!= ''){ ?>

                           <div class="form-check-label"  style=" margin-right: 15px; border:none">

                               <input type="hidden" id="pid" value="<?php echo $pv['ProductVariation']['product_id']; ?>">

                                           <input type="radio" id="variation" onclick="javascript: fetch_size(<?php echo $pv['ProductVariation']['color_id']?>)" name="data[TempCart][color_with_size]" value="<?php echo $pv['Color']['color_name']?>">
                                           <label><?php echo $pv['Color']['color_name'] ?>  </label>

                                       </div>

                                   <?php
                                   } else {
                                       foreach ($product_variation_size as $pv) {
                                           ?>


                           <div class="form-check-label">


                                               <input type="radio" id="variation" name="data[TempCart][size_price]" value="<?php echo $pv['ProductVariation']['size'].'_'.$pv['ProductVariation']['price'] ?>">
                                               <label><?php echo $pv['ProductVariation']['size'] ?>  </label>
                                               <p>Price: <?php echo $pv['ProductVariation']['price'] ?></p>
                                           </div>

                                       <?php }
                                   }
                               } ?>

                               <div id="shippingtyErr"></div>

                               </div>

                        </div>
                    <?php } ?>

                      <div class="row mt-4">
                         <div class="col-sm-4">
                            <a href="javascript:void(0)" onclick="chk_add_to_wishlist_valid()" class="btn btn-outline-primary btn-lg btn-block">Add to Wishlist</a>
                        </div>
                        <div class="col-4">
                            <a href="javascript:void(0)" onclick="chk_add_to_cart_valid()" class="btn btn-primary btn-lg btn-block">Add To Cart</a>
                        </div>
                        <div class="col-4">
                            <!--<a href="#" class="btn btn-primary btn-lg btn-block">Buy Now</a>-->
                        </div>
                    </div>
                        <div id="AjaxMsgFrom"></div>
                    <div class="mt-3">
                        <ul class="list-unstyled list-sold">
                            <li><?php echo $productsold[0][0]['total_sold'];?> sold</li>
<!--                            <li><input type="color" name="data[Product][colour]" readonly="" value="#ffffff"></li>-->

                        </ul>
                    </div>
                    <div class="bg-light p-4 mt-4 seller-info">
                        <h5 class="text-pink mb-3">Seller information</h5>
                        <p><?php echo $product_details['User']['first_name'].' '.$product_details['User']['last_name'];?></p>

                    </div>

                        <div>
                        	<h4 class="my-2">Shipping</h4>
                        	<div class="shippingPart">
                            <?php  foreach($shippingdetails as $ship){?>
	<div class="form-check-label">
            <input type="radio" id="ship" name="data[TempCart][shipping_time]" value="<?php echo $ship['ShippingDay']['id']?>">
<label>USPS $<?php echo $ship['ShippingDay']['ship_charge']?> <small class="fixedCosts"><?php echo $ship['ShippingDay']['ship_name']?></small> </label>
<p><?php echo $ship['ShippingDay']['ship_day']?> business day processing time</p>
	</div>

           <?php } ?>
           <input type="radio" id="ship" name="data[TempCart][shipping_time]" value="0" checked="">
            <label>Free shipping </label>
<!--            <p>2 business day processing time</p>-->

                      <div id="shippingtyErr"></div>

                               </div>

                        </div>

                     </form>

                </div>
                <div class="col-lg-12 mt-4 product-tab-area">
                    <ul class="nav nav-tabs product-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tab1" role="tab" data-toggle="tab">Description</a>
                        </li>
<!--                        <li class="nav-item">
                            <a class="nav-link" href="#tab2" role="tab" data-toggle="tab">Shipping and Payments</a>
                        </li>-->
                        <li class="nav-item">
                            <a class="nav-link" href="#tab3" role="tab" data-toggle="tab">Ratting and Review</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade in show active" id="tab1">
                            <div class="py-4">

                             <?php echo $product_details['Product']['item_description'] ?>



                            </div>
                        </div>


						<div role="tabpanel" class="tab-pane fade" id="tab3">
                            <div class="py-4">
                                <h6 class="font-weight-bold text-orange">Ratting and Review</h6>
                                <div class="ratingAndReviews">


                                    <?php //pr($ratingreview);
                                    if(!empty($ratingreview)){
                                    foreach($ratingreview as $rv){?>
                                	<div class="rating">
                                		<div class="row">

                                			<div class="col-lg-11">
                                				<div class="profText">
                                					<h3 class="text-orange mb-2"><?php echo $rv['User']['first_name'].' '.$rv['User']['last_name'] ?></h3>
                                                    <div class="ratingCount mb-2">
                                                            <span class="stars"><?php if($rv['Rating']['rating']!=''){echo $rv['Rating']['rating'];}else{ echo 0;}?></span>

 </div>
                                                            <div class="ratingPara">
                                                                    <p><?php echo $rv['Rating']['review']?></p>
                                                            </div>
                                				</div>
                                			</div>
                                		</div>
                                	</div>

                                    <?php } }else{ ?>
                                    <div class="rating">No review and rating found.</div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!--                <div class="col-lg-12 mt-4">
                    <h4>Product Description</h4>
                    <p><?php echo $product_details['Product']['item_description'];?></p>

                </div>-->
            </div>
        </div>
    </section>

    <section class="product-list py-4">
        <div class="container">
            <h4>Related Products</h4>
            <div class="row">
                <?php //pr($related_products);
                foreach($related_products as $rp){?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12 col-product">
                    <figure class="mt-4">
                        <div class="product-pic">
                            <?php if($rp['ProductImage'][0]['name']){?>

                                    <a href="<?php echo $this->webroot ?>products/product_details/<?php echo $rp['Product']['id'] ; ?>"><img src="<?php echo $this->webroot ?>product_images/<?php echo $rp['ProductImage'][0]['name']; ?>" alt=""></a>
                                    <?php }else{ ?>
                                    <a href="<?php echo $this->webroot ?>products/product_details/<?php echo $rp['Product']['id'] ; ?>"><img src="<?php echo $this->webroot ?>product_images/default.png" alt=""></a>
                                    <?php } ?>
                        </div>
                        <figcaption class="p-2">
                            <h6 class=""><?php echo $rp['Product']['name'];?></h6>
                            <p class="text-grey mb-1"><?php echo $rp['User']['first_name'].' '.$rp['User']['last_name'];?></p>
<!--                            <h6 class="text-orange">
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <i class="ion-android-star"></i>
                                <span class="text-grey">(71)</span>
                            </h6>-->
                            <h6 class="float-left mt-2 font-weight-bold">$<?php if($rp['ProductVariation'][0]['price']!=''){ echo $rp['ProductVariation'][0]['price'];}else{ echo $rp['Product']['price_lot'];}?></h6>
                            <a href="<?php echo $this->webroot ?>products/product_details/<?php echo $rp['Product']['id'] ; ?>" class="btn btn-secondary btn-sm float-right">Shop Now</a>
                        </figcaption>
                    </figure>
                </div>
                <?php } ?>

            </div>
        </div>
    </section>

 <style>
   .form-horizontal .control-label {
	text-align: left;
    }


    span.stars, span.stars span {
    display: block;
    background: url(../../img/stars.png) 0 -16px repeat-x;
    width: 80px;
    height: 16px;
}

span.stars span {
    background-position: 0 0;
}


</style>
<script>
$.fn.stars = function() {
    return $(this).each(function() {
        // Get the value
        var val = parseFloat($(this).html());
        // Make sure that the value is in 0 - 5 range, multiply to get width
        var size = Math.max(0, (Math.min(5, val))) * 16;
        // Create stars holder
        var $span = $('<span />').width(size);
        // Replace the numerical value with stars
        $(this).html($span);
    });
}
$(function() {
    $('span.stars').stars();
});

</script>
<!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5901b54babf8a4ca"></script>

<script>

    function fetch_size(id) {

             var pid= $("#pid").val();
             var cid= id;
     //alert(cid);exit;

            $.ajax({
                url: '<?php echo $this->webroot; ?>products/fetch_size',
                cache: false,
                data: { cid: cid, pid: pid },
                type: 'post',
                success: function (response) {
                    console.log(response);
                    var obj = jQuery.parseJSON(response);

                    if (obj.Ack == 1) {
                        html ="";
                        for (var i = 0; i < obj.data.length; i++) {

                           html= html+"<input type='radio' name='data[TempCart][size_with_price]' value='"+obj.data[i].ProductVariation.size+'_'+obj.data[i].ProductVariation.price+"'>"+ obj.data[i].ProductVariation.size+"<p>Price:"+obj.data[i].ProductVariation.price+"</p>";
                        }

                      $('#size').html(html);
                    }
                },
                error: function (response) {
                    $('#msg').html(response); // display error response from the PHP script
                }
            });
        }







</script>





    <script type="text/javascript">
   var base_url = "<?php echo $this->webroot ?>";


       function chk_add_to_cart_valid(){

        var op= $('#productPrice').val();
        var c = $('#variation:checked').val();


    if(document.getElementById('productQuantity').value==''){
            $("#QuantityErr").html('Please Enter List Quantity');
    }else if(document.getElementById('productQuantity').value<=0){
            $("#QuantityErr").html('Enter Greater Than Zero');
    }else if(op == 0 && c == null){

        alert('please select one option');

        } else{
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->webroot; ?>products/ajax_add_to_cart/<?php echo((isset($product_details['Product']['id']) && $product_details['Product']['id']!='')?base64_encode($product_details['Product']['id']):0);?>',
                data: $('#ListingCart').serialize(),
                //dataType: 'json',
                success: function(data) {
                    var DataSplit = data.split(':');
                    $("#AjaxMsgFrom").html('');
                    if(DataSplit[0]=='Error'){
                        $("#AjaxMsgFrom").html('<div class="row"><div class="col-md-12"><div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Error!</strong> '+DataSplit[1]+'</div></div></div>');
                    }else if(DataSplit[0]=='Success'){
                        var CartCount=$('.cart-item').find('b').text().trim();
                        var NewCnt= parseInt(CartCount)+1;
                        $('.cart-item').find('b').text( NewCnt);
                        $("#AjaxMsgFrom").html('<div class="row"><div class="col-md-12"><div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Success!</strong> '+DataSplit[1]+'</div></div></div>');
                    }
                    /*alert(data);
                    exit();
                        $("#form-email .help-block").remove();
                        $(".form-group").removeClass("has-error");
                        $("#email.white-popup .alert").remove();
                        if(data.errors){
                                for (var index in data.errors){
                                        var element = $("#form-email #"+index);
                                        element.after("<p class='help-block'>"+data.errors[index]+"</p>");
                                        element.parents(".form-group").addClass("has-error");
                                }
                        }else if(data.success){


                                $("#form-email #phone_number").val("");
                                $("#form-email #message").val("");
                        }

                        $("#send-email-loading").hide();*/
                }
            });
    }
    }

    function chk_add_to_wishlist_valid(){


            var op= $('#productPrice').val();
            var c = $('#variation:checked').val();

    if(document.getElementById('productQuantity').value==''){
            $("#QuantityErr").html('Please Enter List Quantity');
    }else if(document.getElementById('productQuantity').value<=0){
            $("#QuantityErr").html('Enter Greater Than Zero');
    }else if(op == 0 && c == null){

        alert('please select one option');

        } else{
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->webroot; ?>products/ajax_add_to_wishlist/<?php echo((isset($product_details['Product']['id']) && $product_details['Product']['id']!='')?base64_encode($product_details['Product']['id']):0);?>',
                data: $('#ListingCart').serialize(),
                //dataType: 'json',
                success: function(data) {
                    var DataSplit = data.split(':');
                    $("#AjaxMsgFrom").html('');
                    if(DataSplit[0]=='Error'){
                        $("#AjaxMsgFrom").html('<div class="row"><div class="col-md-12"><div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Error!</strong> '+DataSplit[1]+'</div></div></div>');
                    }else if(DataSplit[0]=='Success'){
                        //var CartCount=$('.cart-item').find('b').text().trim();
                        //var NewCnt= parseInt(CartCount)+1;
                        //$('.cart-item').find('b').text( NewCnt);
                        $("#AjaxMsgFrom").html('<div class="row"><div class="col-md-12"><div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Success!</strong> '+DataSplit[1]+'</div></div></div>');
                    }
                    /*alert(data);
                    exit();
                        $("#form-email .help-block").remove();
                        $(".form-group").removeClass("has-error");
                        $("#email.white-popup .alert").remove();
                        if(data.errors){
                                for (var index in data.errors){
                                        var element = $("#form-email #"+index);
                                        element.after("<p class='help-block'>"+data.errors[index]+"</p>");
                                        element.parents(".form-group").addClass("has-error");
                                }
                        }else if(data.success){


                                $("#form-email #phone_number").val("");
                                $("#form-email #message").val("");
                        }

                        $("#send-email-loading").hide();*/
                }
            });
    }
    }


   </script>
