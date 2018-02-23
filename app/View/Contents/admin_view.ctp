<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Content'); ?></div>
			</div>
			<div class="users view">
				<dl>
				<dt><?php echo __('Id'); ?></dt>
				<dd>
					<?php echo h($content['Content']['id']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Page Name'); ?></dt>
				<dd>
					<?php echo h($content['Content']['page_name']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Page Heading'); ?></dt>
				<dd>
					<?php echo h($content['Content']['page_heading']); ?>
					&nbsp;
				</dd>		
				<dt><?php echo __('Content'); ?></dt>
				<dd>
					<?php echo (nl2br($content['Content']['content'])); ?>
					&nbsp;
				</dd>			
			</dl>
			</div>
			
		</div>
	</div>
</div>

