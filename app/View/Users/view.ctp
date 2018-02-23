<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Firrst Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['firrst_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['last_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Username'); ?></dt>
		<dd>
			<?php echo h($user['User']['username']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($user['User']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Profile Image'); ?></dt>
		<dd>
			<?php echo h($user['User']['profile_image']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mobile Number'); ?></dt>
		<dd>
			<?php echo h($user['User']['mobile_number']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is User'); ?></dt>
		<dd>
			<?php echo h($user['User']['is_user']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Maker'); ?></dt>
		<dd>
			<?php echo h($user['User']['is_maker']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Admin'); ?></dt>
		<dd>
			<?php echo h($user['User']['is_admin']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Active'); ?></dt>
		<dd>
			<?php echo h($user['User']['is_active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fb Userid'); ?></dt>
		<dd>
			<?php echo h($user['User']['fb_userid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Registration Date'); ?></dt>
		<dd>
			<?php echo h($user['User']['registration_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Zip Code'); ?></dt>
		<dd>
			<?php echo h($user['User']['zip_code']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dob'); ?></dt>
		<dd>
			<?php echo h($user['User']['dob']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Gender'); ?></dt>
		<dd>
			<?php echo h($user['User']['gender']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Bio'); ?></dt>
		<dd>
			<?php echo h($user['User']['bio']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Basic Interests'); ?></dt>
		<dd>
			<?php echo h($user['User']['basic_interests']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Etsy Store Url'); ?></dt>
		<dd>
			<?php echo h($user['User']['etsy_store_url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Personal Website Url'); ?></dt>
		<dd>
			<?php echo h($user['User']['personal_website_url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Work Experience'); ?></dt>
		<dd>
			<?php echo h($user['User']['work_experience']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Highest Degree'); ?></dt>
		<dd>
			<?php echo h($user['User']['highest_degree']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Facebook Url'); ?></dt>
		<dd>
			<?php echo h($user['User']['facebook_url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Twitter Url'); ?></dt>
		<dd>
			<?php echo h($user['User']['twitter_url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Linkdin Url'); ?></dt>
		<dd>
			<?php echo h($user['User']['linkdin_url']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Youtube Url'); ?></dt>
		<dd>
			<?php echo h($user['User']['youtube_url']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), array(), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
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
<div class="related">
	<h3><?php echo __('Related Availabilities'); ?></h3>
	<?php if (!empty($user['Availability'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Any Time Email'); ?></th>
		<th><?php echo __('Has Fixed Routine'); ?></th>
		<th><?php echo __('Monday From'); ?></th>
		<th><?php echo __('Monday To'); ?></th>
		<th><?php echo __('Monday Any Time'); ?></th>
		<th><?php echo __('Tuesday From'); ?></th>
		<th><?php echo __('Tuesday To'); ?></th>
		<th><?php echo __('Tuesday Any Time'); ?></th>
		<th><?php echo __('Wednesday From'); ?></th>
		<th><?php echo __('Wednesday To'); ?></th>
		<th><?php echo __('Wednesday Any Time'); ?></th>
		<th><?php echo __('Thursday From'); ?></th>
		<th><?php echo __('Thursday To'); ?></th>
		<th><?php echo __('Thursday Any Time'); ?></th>
		<th><?php echo __('Friday From'); ?></th>
		<th><?php echo __('Friday To'); ?></th>
		<th><?php echo __('Friday Any Time'); ?></th>
		<th><?php echo __('Saturday From'); ?></th>
		<th><?php echo __('Saturday To'); ?></th>
		<th><?php echo __('Saturday Any Time'); ?></th>
		<th><?php echo __('Sunday From'); ?></th>
		<th><?php echo __('Sunday To'); ?></th>
		<th><?php echo __('Sunday Any Time'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Availability'] as $availability): ?>
		<tr>
			<td><?php echo $availability['id']; ?></td>
			<td><?php echo $availability['user_id']; ?></td>
			<td><?php echo $availability['any_time_email']; ?></td>
			<td><?php echo $availability['has_fixed_routine']; ?></td>
			<td><?php echo $availability['monday_from']; ?></td>
			<td><?php echo $availability['monday_to']; ?></td>
			<td><?php echo $availability['monday_any_time']; ?></td>
			<td><?php echo $availability['tuesday_from']; ?></td>
			<td><?php echo $availability['tuesday_to']; ?></td>
			<td><?php echo $availability['tuesday_any_time']; ?></td>
			<td><?php echo $availability['wednesday_from']; ?></td>
			<td><?php echo $availability['wednesday_to']; ?></td>
			<td><?php echo $availability['wednesday_any_time']; ?></td>
			<td><?php echo $availability['thursday_from']; ?></td>
			<td><?php echo $availability['thursday_to']; ?></td>
			<td><?php echo $availability['thursday_any_time']; ?></td>
			<td><?php echo $availability['friday_from']; ?></td>
			<td><?php echo $availability['friday_to']; ?></td>
			<td><?php echo $availability['friday_any_time']; ?></td>
			<td><?php echo $availability['saturday_from']; ?></td>
			<td><?php echo $availability['saturday_to']; ?></td>
			<td><?php echo $availability['saturday_any_time']; ?></td>
			<td><?php echo $availability['sunday_from']; ?></td>
			<td><?php echo $availability['sunday_to']; ?></td>
			<td><?php echo $availability['sunday_any_time']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'availabilities', 'action' => 'view', $availability['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'availabilities', 'action' => 'edit', $availability['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'availabilities', 'action' => 'delete', $availability['id']), array(), __('Are you sure you want to delete # %s?', $availability['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Availability'), array('controller' => 'availabilities', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Inbox Messages'); ?></h3>
	<?php if (!empty($user['InboxMessage'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Sender'); ?></th>
		<th><?php echo __('Subject'); ?></th>
		<th><?php echo __('Message'); ?></th>
		<th><?php echo __('Date Time'); ?></th>
		<th><?php echo __('Read'); ?></th>
		<th><?php echo __('Trash'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['InboxMessage'] as $inboxMessage): ?>
		<tr>
			<td><?php echo $inboxMessage['id']; ?></td>
			<td><?php echo $inboxMessage['user_id']; ?></td>
			<td><?php echo $inboxMessage['sender']; ?></td>
			<td><?php echo $inboxMessage['subject']; ?></td>
			<td><?php echo $inboxMessage['message']; ?></td>
			<td><?php echo $inboxMessage['date_time']; ?></td>
			<td><?php echo $inboxMessage['read']; ?></td>
			<td><?php echo $inboxMessage['trash']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'inbox_messages', 'action' => 'view', $inboxMessage['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'inbox_messages', 'action' => 'edit', $inboxMessage['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'inbox_messages', 'action' => 'delete', $inboxMessage['id']), array(), __('Are you sure you want to delete # %s?', $inboxMessage['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Inbox Message'), array('controller' => 'inbox_messages', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Previous Makings'); ?></h3>
	<?php if (!empty($user['PreviousMaking'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Image'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['PreviousMaking'] as $previousMaking): ?>
		<tr>
			<td><?php echo $previousMaking['id']; ?></td>
			<td><?php echo $previousMaking['user_id']; ?></td>
			<td><?php echo $previousMaking['image']; ?></td>
			<td><?php echo $previousMaking['description']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'previous_makings', 'action' => 'view', $previousMaking['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'previous_makings', 'action' => 'edit', $previousMaking['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'previous_makings', 'action' => 'delete', $previousMaking['id']), array(), __('Are you sure you want to delete # %s?', $previousMaking['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Previous Making'), array('controller' => 'previous_makings', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Requests'); ?></h3>
	<?php if (!empty($user['Request'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Maker'); ?></th>
		<th><?php echo __('Request Comment'); ?></th>
		<th><?php echo __('Sent Date'); ?></th>
		<th><?php echo __('Is Active'); ?></th>
		<th><?php echo __('Is Confirmed'); ?></th>
		<th><?php echo __('Payment Amount'); ?></th>
		<th><?php echo __('TransactionId'); ?></th>
		<th><?php echo __('Is Paid'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Request'] as $request): ?>
		<tr>
			<td><?php echo $request['id']; ?></td>
			<td><?php echo $request['user_id']; ?></td>
			<td><?php echo $request['maker']; ?></td>
			<td><?php echo $request['request_comment']; ?></td>
			<td><?php echo $request['sent_date']; ?></td>
			<td><?php echo $request['is_active']; ?></td>
			<td><?php echo $request['is_confirmed']; ?></td>
			<td><?php echo $request['payment_amount']; ?></td>
			<td><?php echo $request['transactionId']; ?></td>
			<td><?php echo $request['is_paid']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'requests', 'action' => 'view', $request['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'requests', 'action' => 'edit', $request['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'requests', 'action' => 'delete', $request['id']), array(), __('Are you sure you want to delete # %s?', $request['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Request'), array('controller' => 'requests', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Reviews'); ?></h3>
	<?php if (!empty($user['Review'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Reviewer'); ?></th>
		<th><?php echo __('Rating'); ?></th>
		<th><?php echo __('Comment'); ?></th>
		<th><?php echo __('Is Active'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Review'] as $review): ?>
		<tr>
			<td><?php echo $review['id']; ?></td>
			<td><?php echo $review['user_id']; ?></td>
			<td><?php echo $review['reviewer']; ?></td>
			<td><?php echo $review['rating']; ?></td>
			<td><?php echo $review['comment']; ?></td>
			<td><?php echo $review['is_active']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'reviews', 'action' => 'view', $review['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'reviews', 'action' => 'edit', $review['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'reviews', 'action' => 'delete', $review['id']), array(), __('Are you sure you want to delete # %s?', $review['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Review'), array('controller' => 'reviews', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Sent Messages'); ?></h3>
	<?php if (!empty($user['SentMessage'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Receiver'); ?></th>
		<th><?php echo __('Subject'); ?></th>
		<th><?php echo __('Message'); ?></th>
		<th><?php echo __('Date Time'); ?></th>
		<th><?php echo __('Trash'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['SentMessage'] as $sentMessage): ?>
		<tr>
			<td><?php echo $sentMessage['id']; ?></td>
			<td><?php echo $sentMessage['user_id']; ?></td>
			<td><?php echo $sentMessage['receiver']; ?></td>
			<td><?php echo $sentMessage['subject']; ?></td>
			<td><?php echo $sentMessage['message']; ?></td>
			<td><?php echo $sentMessage['date_time']; ?></td>
			<td><?php echo $sentMessage['trash']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'sent_messages', 'action' => 'view', $sentMessage['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'sent_messages', 'action' => 'edit', $sentMessage['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'sent_messages', 'action' => 'delete', $sentMessage['id']), array(), __('Are you sure you want to delete # %s?', $sentMessage['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Sent Message'), array('controller' => 'sent_messages', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Skills'); ?></h3>
	<?php if (!empty($user['Skill'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Skill Name'); ?></th>
		<th><?php echo __('Skill Details'); ?></th>
		<th><?php echo __('Is Active'); ?></th>
		<th><?php echo __('Skill Workshop Address'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Skill'] as $skill): ?>
		<tr>
			<td><?php echo $skill['id']; ?></td>
			<td><?php echo $skill['user_id']; ?></td>
			<td><?php echo $skill['skill_name']; ?></td>
			<td><?php echo $skill['skill_details']; ?></td>
			<td><?php echo $skill['is_active']; ?></td>
			<td><?php echo $skill['skill_workshop_address']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'skills', 'action' => 'view', $skill['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'skills', 'action' => 'edit', $skill['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'skills', 'action' => 'delete', $skill['id']), array(), __('Are you sure you want to delete # %s?', $skill['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Skill'), array('controller' => 'skills', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Wishlists'); ?></h3>
	<?php if (!empty($user['Wishlist'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Maker Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Wishlist'] as $wishlist): ?>
		<tr>
			<td><?php echo $wishlist['id']; ?></td>
			<td><?php echo $wishlist['user_id']; ?></td>
			<td><?php echo $wishlist['maker_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'wishlists', 'action' => 'view', $wishlist['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'wishlists', 'action' => 'edit', $wishlist['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'wishlists', 'action' => 'delete', $wishlist['id']), array(), __('Are you sure you want to delete # %s?', $wishlist['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Wishlist'), array('controller' => 'wishlists', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
