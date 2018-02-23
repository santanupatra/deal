<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('firrst_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('username');
		echo $this->Form->input('email');
		echo $this->Form->input('password');
		echo $this->Form->input('profile_image');
		echo $this->Form->input('mobile_number');
		echo $this->Form->input('is_user');
		echo $this->Form->input('is_maker');
		echo $this->Form->input('is_admin');
		echo $this->Form->input('is_active');
		echo $this->Form->input('fb_userid');
		echo $this->Form->input('registration_date');
		echo $this->Form->input('zip_code');
		echo $this->Form->input('dob');
		echo $this->Form->input('gender');
		echo $this->Form->input('bio');
		echo $this->Form->input('basic_interests');
		echo $this->Form->input('etsy_store_url');
		echo $this->Form->input('personal_website_url');
		echo $this->Form->input('work_experience');
		echo $this->Form->input('highest_degree');
		echo $this->Form->input('facebook_url');
		echo $this->Form->input('twitter_url');
		echo $this->Form->input('linkdin_url');
		echo $this->Form->input('youtube_url');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Availabilities'), array('controller' => 'availabilities', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Availability'), array('controller' => 'availabilities', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Inbox Messages'), array('controller' => 'inbox_messages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Inbox Message'), array('controller' => 'inbox_messages', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Previous Makings'), array('controller' => 'previous_makings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Previous Making'), array('controller' => 'previous_makings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Requests'), array('controller' => 'requests', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Request'), array('controller' => 'requests', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Reviews'), array('controller' => 'reviews', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Review'), array('controller' => 'reviews', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sent Messages'), array('controller' => 'sent_messages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sent Message'), array('controller' => 'sent_messages', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Skills'), array('controller' => 'skills', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Skill'), array('controller' => 'skills', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Wishlists'), array('controller' => 'wishlists', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Wishlist'), array('controller' => 'wishlists', 'action' => 'add')); ?> </li>
	</ul>
</div>
