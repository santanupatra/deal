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
</style>

<section class="after_login">
	<div class="container">
		<div class="row">
		    <?php echo($this->element('user_leftbar'));?>
			<div class="col-md-9">
				<div class="dash_middle_sec">
				<h2>Purchase History</h2>
				<div class="listings">	
					<table cellpadding="0" cellspacing="0" class="data-table-bordered">
					<tr>
						<th class="name"><?php echo ('id'); ?></th>
						<th class="name"><?php echo ('User'); ?></th>
						<th class="name"><?php echo ('Total Amount'); ?></th>
						<th class="name"><?php echo ('Order Date'); ?></th>
						<th class="name"><?php echo ('Transaction Id'); ?></th>
						<th class="name"><?php echo ('Payment Date');; ?></th>
						<th class="actions"><?php echo ('Actions'); ?></th>
					</tr>
					<?php foreach ($orders as $order): ?>
					<tr>
						<td><?php echo h($order['Order']['id']); ?>&nbsp;</td>
						<td><?php echo h($order['User']['first_name'].' '.$order['User']['last_name']); ?></td>
						<td>$&nbsp;<?php echo h($order['Order']['total_amount']); ?>&nbsp;</td>
						<td><?php echo h(date('d M, Y',strtotime($order['Order']['order_date']))); ?>&nbsp;</td>
						<td><?php echo h($order['Order']['transaction_id']); ?>&nbsp;</td>
						<td><?php echo h(date('d M, Y',strtotime($order['Order']['payment_date']))); ?>&nbsp;</td>
						<td class="name">
							<?php echo $this->Html->link(__('View Details'), array('controller' => 'order_details','action' => 'purchasedetails', base64_encode($order['Order']['id']))); ?>
						</td>
					</tr>
				<?php endforeach; ?>
					</table>
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



