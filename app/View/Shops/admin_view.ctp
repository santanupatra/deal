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
						<?php echo h($shop['User']['name']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Owner'); ?></dt>
					<dd>
						<?php echo h($shop['User']['first_name'].' '.$shop['User']['last_name']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Email'); ?></dt>
					<dd>
						<?php echo h($shop['User']['email']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Company Name'); ?></dt>
					<dd>
						<?php echo h($shop['User']['company_name']); ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Business Email'); ?></dt>
					<dd>
						<?php if(isset($shop['User']['paypal_business_email']) && $shop['User']['paypal_business_email']!=''){echo $shop['User']['paypal_business_email'];}else{echo 'N/A';} ?>
						&nbsp;
					</dd>
					<dt><?php echo __('Phone'); ?></dt>
					<dd>
						<?php if(isset($shop['User']['mobile_number']) && $shop['User']['mobile_number']!=''){echo $shop['User']['mobile_number'];}else{echo 'N/A';} ?>
						&nbsp;
					</dd>
					
					
					<dt><?php echo __('Percentage'); ?></dt>
					<dd>
						<?php if(isset($shop['User']['percentage_id']) && $shop['User']['percentage_id']!=''){echo $shop['Percentage']['name'].' / '.$shop['Percentage']['percent'];}else{echo 'N/A';} ?>
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
