
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="frmPaypal" id="frmPaypal">
<input type="hidden" name="notify_url" value="http://localhost/deal/deal/products/purchase_payment/">      
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="<?php echo $paypalid['SiteSetting']['paypal_email']?>">
<input type="hidden" name="item_name" value="Coupon Payment">
<input type="hidden" name="item_number" value="LDC-PTS">
<input type="hidden" name="item_quantity" id="item_quantity" value="1">

<input type="hidden" name="page_style" value="Primary">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="http://localhost/deal/deal/products/success_payment/">
<input type="hidden" name="cancel_return" value="http://localhost/deal/deal/products/cancel/">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="amount" id="amount" value="<?php echo $product['Coupon']['amount'];?>">
<input type="hidden" name="custom" id="custom" value="<?php echo $userid.'_'.$product['Coupon']['id'];?>">
</form> 
<script src="https://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
	$(function(){
		$('#frmPaypal').submit();
	})

</script>
