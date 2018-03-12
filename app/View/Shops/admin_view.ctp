<?php ?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('View Vendor'); ?></div>
			</div>
			<div class="users view">
				<dl>
				<?php //print_r($shop);?>	
					<dt><?php echo __('Id'); ?></dt>
					<dd>
						<?php echo h($shop['User']['id']); ?>
						&nbsp;
					</dd>

					
					<dt><?php echo __('Name'); ?></dt>
					<dd>
						<?php echo h($shop['User']['first_name'].' '.$shop['User']['last_name']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Email'); ?></dt>
					<dd>
						<?php echo h($shop['User']['email']); ?>
						&nbsp;
					</dd>

					
					<dt><?php echo __('Phone'); ?></dt>
					<dd>
						<?php if(isset($shop['User']['mobile_number']) && $shop['User']['mobile_number']!=''){echo $shop['User']['mobile_number'];}else{echo 'N/A';} ?>
						&nbsp;
					</dd>
					
					
					<dt><?php echo __('No of Shops'); ?></dt>
					<dd>
						<?php echo $countshop;?>
						&nbsp;
					</dd>
					
                                        <dt><?php echo __('Deal Upload No.'); ?></dt>
					<dd>
						<?php echo $countdealupload;?>
						&nbsp;
					</dd>
                                        
                                        <dt><?php echo __('Coupon Upload No.'); ?></dt>
					<dd>
						<?php echo $countcouponupload;?>
						&nbsp;
					</dd>
					
                                        <dt><?php echo __('Coupon Sold No.'); ?></dt>
					<dd>
						<?php echo $countcouponsold;?>
						&nbsp;
					</dd>
					
					
					
					<dt><?php echo __('Active'); ?></dt>
					<dd>
						<?php echo h($shop['User']['is_active']==1?'Yes':'No'); ?>
						&nbsp;
					</dd>
				</dl>
			</div>
		</div>
	</div>
</div>
