<?php ?>
<style type="text/css">
.listings{
	width:100%;
	border:0px solid red;
	padding:12px;
	text-align:left;
	margin:0px 0px 20px 0px;
}

/** Tables **/
table {
	border-right:0;
	clear: both;
	color: #333;
	margin: 10px 0px 10px 0px;
	width: 100%;
}
th {
	border:0;
	border-bottom:1px solid #dadbd6;
	text-align: left;
	padding:10px;
}
th a {
	display: block;
	padding: 2px 4px;
	text-decoration: none;
}
th a.asc:after {
	content: ' ⇣';
}
th a.desc:after {
	content: ' ⇡';
}
table tr td {
	padding: 10px;
	text-align: left;
	vertical-align: top;
	border-bottom:1px solid #ddd;
}
.headimg {
	background: #eeeeee;
}
table tr:nth-child(even) {
	background: #f9f9f9;
}
td.actions {
	text-align: left;
	white-space: nowrap;
}
table td.actions a {
	margin: 0px 6px;
	padding:5px 5px;
}
.data-table-bordered {
	border: 1px solid #dadbd6;
	border-collapse: separate;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border-radius: 5px;
}
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
.contact_form{margin:0 auto;width:730px;border:0px solid red;padding-top:00px;padding-bottom:00px;}
.contact_form tr{color:#6d6d6d;font-size:12px;line-height:10px;font-weight: normal;}
.contact_form tr td{float:left;margin:15px;text-align:left;color:#6d6d6d;}
.form_text{text-align:right !important;width:120px;color:#6d6d6d;font-size:12px;line-height:20px;margin-top:5px;bottom: 10px;font-weight: normal;margin-right:5px;padding-top:5px;}
.contact_text_box{height:30px;width:300px;border:1px solid #e1e1e1;background:#ffffff;border-radius:4px;-moz-box-shadow: 0px 2px 3px rgba(182, 182, 182, 0.75);-webkit-box-shadow: 0px 2px 3px rgba(182, 182, 182, 0.75);box-shadow: 0px 1px 1px rgba(182, 182, 182, 0.75);font-size:14px;line-height:20px;padding-left:10px;color:#6d6d6d;}
.btn_log{background: #0098d5;border-color: #DEDEDD #DEDEDD #DEDEDD -moz-use-text-color;border-image: none;border-style: solid solid solid none;border-width: 1px 1px 1px medium;color: #FFFFFF;cursor: pointer;float: left;font-weight: bold;height: 31px;line-height: 31px;padding: 0 21px;border-radius:4px;}
input:focus,textarea:focus,select:focus{
	border-color: #2A9BC7;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.333) inset, 0 0 6px rgba(42, 155, 199, 0.5);
    outline: 0 none;
	color:#6d6d6d;
}
.selectbox{border:1px solid #e1e1e1;width:140px;height:30px;border-radius:4px;-moz-box-shadow: 0px 2px 3px rgba(182, 182, 182, 0.75);-webkit-box-shadow: 0px 2px 3px rgba(182, 182, 182, 0.75);box-shadow: 0px 1px 1px rgba(182, 182, 182, 0.75);font-size:14px;color:#6d6d6d;padding-left:10px;}
.txtarea{border:1px solid #e1e1e1;border-radius:4px;-moz-box-shadow: 0px 2px 3px rgba(182, 182, 182, 0.75);-webkit-box-shadow: 0px 2px 3px rgba(182, 182, 182, 0.75);box-shadow: 0px 1px 1px rgba(182, 182, 182, 0.75);font-size:14px;color:#6d6d6d;padding-left:10px;}
.cart_img {width: 20%; float:left;}
    	.cart_text{width: 79%;float: left;padding-left: 20px;}
</style>

<section class="after_login">
	<div class="container">
		<div class="row">
		    <?php echo($this->element('user_leftbar'));?>
			<div class="col-md-9">
				<div class="dash_middle_sec">
				<h2>Order Detail</h2>
				<div class="listings">	
					<table cellpadding="0" cellspacing="0" class="data-table-bordered">
					<tr>
						<th class="name"><?php echo ('id'); ?></th>
						<th class="name"><?php echo ('Product'); ?></th>
						<th class="name"><?php echo ('Price'); ?></th>
						<th class="name"><?php echo ('Quantity'); ?></th>
						<!--<th class="name"><?php echo ('Shipping Cost'); ?></th>
						<th class="name"><?php echo ('Amount'); ?></th>
						<th class="name"><?php echo ('Order Status'); ?></th>
						<th class="name"><?php echo ('Delivery Date'); ?></th>-->
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					<?php foreach ($orderdetails as $orderdetail): ?>
					<?php 
					//pr($orderdetail);
					if(!empty($orderdetail['Product']['ProductImage']))
						{
							$uploadFolder = "product_images";
							$uploadPath = WWW_ROOT . $uploadFolder;
							$imageName =$orderdetail['Product']['ProductImage'][0]['name'];
							if(file_exists($uploadPath . '/' . $imageName) && $imageName!='')
							{
								$image = $this->webroot.'product_images/'.$imageName;
							}
							else
							{ 
								$image = $this->webroot.'product_images/default.png';
							} 
						}else{
							$image = $this->webroot.'product_images/default.png';
						}	?>
					<tr>
						<td><?php echo h($orderdetail['OrderDetail']['id']); ?>&nbsp;</td>
						<td style="width:30%">
							<div class="cart_img">
										<a href="<?php echo $this->webroot.'products/view/'.base64_encode($orderdetail['Product']['id']);?>"><img src="<?php echo $image;?>" alt="" style="width:100%;" /></a>
							</div>
							<div class="cart_text">
								<p style=""><a href="<?php echo $this->webroot.'products/view/'.base64_encode($orderdetail['Product']['id']);?>"><?php echo $orderdetail['Product']['name'];?></a></p>
								
							</div>
						</td>
						<td>$&nbsp;<?php echo h($orderdetail['OrderDetail']['price']); ?>&nbsp;</td>
						<td><?php echo h($orderdetail['OrderDetail']['quantity']); ?>&nbsp;</td>
						<!--<td>$&nbsp;<?php echo h($orderdetail['OrderDetail']['shipping_cost']); ?>&nbsp;</td>
						<td>$&nbsp;<?php echo h($orderdetail['OrderDetail']['amount']); ?>&nbsp;</td>
						<td><?php echo h($orderdetail['OrderDetail']['order_status']=='U'?'Undelivered':($orderdetail['OrderDetail']['order_status']=='C'?'Cancelled':'Delivered')); ?>&nbsp;</td>
						<td><?php echo h($orderdetail['OrderDetail']['delivery_date']=='0000-00-00'?'':date('d M, Y',strtotime($orderdetail['OrderDetail']['delivery_date']))); ?>&nbsp;</td>-->
						<td class="name">
							<?php echo $this->Html->link(__('Back'), array('controller' => 'orders','action' => 'index')); ?>
						</td>
					</tr>
				<?php endforeach; ?>
					</table>
					<!-- <p>
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

					</div> -->
				</div>
				<?php
				if($order_by)
				{
				?>
				<div style="float:left;margin-right:40px;margin-left:10px;">
				<h2>Buyer Details</h2>
				<table cellpadding="0" cellspacing="0" class="data-table-bordered" style="width:350px;float:left">
				<tr>
					<th class="name"><?php echo __('First Name'); ?></th>
					<td><?php echo h($order_by['User']['first_name']); ?>&nbsp;</td>
				</tr>
				<tr>
					<th class="name"><?php echo __('Last Name'); ?></th>
					<td><?php echo h($order_by['User']['last_name']); ?>&nbsp;</td>
				</tr>
				<tr>
					<th class="name"><?php echo __('Mobile Number'); ?></th>
					<td><?php echo h($order_by['User']['mobile_number']); ?>&nbsp;</td>
				</tr>
				<tr>
					<th class="name"><?php echo __('Email'); ?></th>

					<td><?php echo h($order_by['User']['email']); ?>&nbsp;</td>
				</tr>
				</table>
				</div>
				<?php
				}
				?>
				<?php
				if($shipping)
				{
				?>
				<div style="float:left">
				<h2>Shipping Details</h2>
				<table cellpadding="0" cellspacing="0" class="data-table-bordered" style="width:350px;float:left">
				<tr>
					<td class="name"><?php echo __('Full Name'); ?></td>
					<td><?php echo h($shipping['ShippingAddress']['full_name']); ?>&nbsp;</td>
				</tr>
				<tr>
					<td class="name"><?php echo __('Street Address'); ?></td>
					<td><?php echo h($shipping['ShippingAddress']['street']); ?>&nbsp;</td>
				</tr>
				<tr>
					<td class="name"><?php echo __('Apartment'); ?></td>
					<td><?php echo h($shipping['ShippingAddress']['apartment']); ?>&nbsp;</td>
				</tr>
				<tr>
					<td class="name"><?php echo __('City'); ?></td>
					<td><?php echo h($shipping['ShippingAddress']['city']); ?>&nbsp;</td>
				</tr>
				<tr>
					<td class="name"><?php echo __('State'); ?></td>
					<td><?php echo h($shipping['ShippingAddress']['state']); ?>&nbsp;</td>
				</tr>
				<tr>
					<td class="name"><?php echo __('Country'); ?></td>
					<td><?php echo h($this->requestAction('order_details/getCountryname/'.$shipping['ShippingAddress']['country'])); ?>&nbsp;</td>
				</tr>
				<tr>
					<td class="name"><?php echo __('Zip Code'); ?></td>
					<td><?php echo h($shipping['ShippingAddress']['zip_code']); ?>&nbsp;</td>
				</tr>
				</table>
				</div>
				<?php
				}
				?>
				<div >
				<!--<h2>Update Order Status</h2>
				<form name="OrderDetailEdit" id="OrderDetailEdit" method="post" action="<?php echo($this->webroot);?>order_details/editstatus/<?php echo(isset($orderdetails[0]['OrderDetail']['id'])?$orderdetails[0]['OrderDetail']['id']:0)?>">
				<table>
				<tr>
					<td class="form_text"><strong>Order Status</strong>:</td>
					<td style="width:200px;">
						<select name="data[OrderDetail][order_status]" id="OrderDetailOrderStatus" class="selectbox">
							<option value="">-Select Status-</option>
							<option value="C">Canclled</option>
							<option value="D">Delivered</option>
							<option value="U">Undelivered</option>
						</select>
					</td>
					<td><input type="submit" value="Save Changes" class="btn_log"/>
					</td>
				</tr>
				</table>
				</form>-->
				</div>
			</div>
				</div>
			</div>
		</div>
	
	</div>
</section>
	
