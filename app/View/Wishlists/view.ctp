<div class="wishlists view">
<h2><?php echo __('Wishlist'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($wishlist['Wishlist']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($wishlist['User']['id'], array('controller' => 'users', 'action' => 'view', $wishlist['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Maker'); ?></dt>
		<dd>
			<?php echo h($wishlist['Wishlist']['maker']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Wishlist'), array('action' => 'edit', $wishlist['Wishlist']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Wishlist'), array('action' => 'delete', $wishlist['Wishlist']['id']), array(), __('Are you sure you want to delete # %s?', $wishlist['Wishlist']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Wishlists'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Wishlist'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
