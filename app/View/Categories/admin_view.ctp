<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('View'); ?></div>
			</div>
			<div class="users view">
				<dl>
				<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($category['Category']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Category Name'); ?></dt>
		<dd>
			<?php echo h($category['Category']['name']); ?>
			&nbsp;
		</dd>
		<?php
		if($category['Category']['parent_id']!=0)
		{
		?>
		<dt><?php echo __('Parent Category'); ?></dt>
		<dd>
			<?php echo h($categoryname); ?>
			&nbsp;
		</dd>
		<?php
		}
		?>
			
		<dt><?php echo __('Active'); ?></dt>
		<dd>
			<?php echo h($category['Category']['active']); ?>
			&nbsp;
		</dd>	
			</dl>
			</div>
			
		</div>
	</div>
</div>

