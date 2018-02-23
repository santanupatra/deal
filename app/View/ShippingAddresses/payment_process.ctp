
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="frmPaypal" id="frmPaypal">
<input type="hidden" name="notify_url" value="<?php echo ($this->webroot);?>shipping_addresses/purchase_payment/">      
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="<?php echo $paypalid['SiteSetting']['paypal_email']?>">
<input type="hidden" name="item_name" value="Wedding Payment">
<input type="hidden" name="item_number" value="LDC-PTS">
<input type="hidden" name="item_quantity" id="item_quantity" value="<?php echo $product[0]['totalquantity'];?>">

<input type="hidden" name="page_style" value="Primary">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="<?php echo ($this->webroot);?>shipping_addresses/success/">
<input type="hidden" name="cancel_return" value="<?php echo ($this->webroot);?>shipping_addresses/cancel/">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="amount" id="amount" value="<?php echo $product[0]['totalpay'];?>">
<input type="hidden" name="custom" id="custom" value="<?php echo $userid;?>">
</form> 
<script src="https://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
	$(function(){
		$('#frmPaypal').submit();
	})

</script>
