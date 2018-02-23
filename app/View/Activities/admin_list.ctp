<?php ?>
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Tracking'); ?></div>
				<!--<div style="float:right;">
				  <a href="<?php echo($this->webroot)?>admin/cities/add">Add New City</a>
				</div>-->
			</div>
			<div class="block-content collapse in">
				<div class="span12">
				<?php //echo $this->request->data['userid'];//pr($users);exit;?>
					<form name="selectForm" action="" method="post">
					<select name="userid" onchange="check()">
					<option value="">Select User</option>
					<?php foreach ($users as $user){ 
					?>
					<option value="<?php echo $user['User']['id'];?>" <?php echo (isset($this->request->data['userid'])?(($this->request->data['userid']==$user['User']['id']?'Selected':'')):'');?>><?php echo $user['User']['name'];?></option>
					<?php } ?>
					</select>
					</form>
					<table class="table table-hover">
					<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('name'); ?></th>
						<th><a href="javascript:void(0);">Description</a></th>
						<th><a href="javascript:void(0);">Created On</a></th>
					</tr>
					</thead>
					<tbody>
					<?php //pr($activities);exit;
					foreach ($activities as $activity): ?>
					<tr>
						<td><?php echo h($activity['User']['name']); ?>&nbsp;</td>
						<td><?php echo h($activity['Activity']['description']); ?>&nbsp;</td>
						<td><?php echo date('d M, Y h:i:s',strtotime($activity['Activity']['created_at'])); ?>&nbsp;</td>
						
						<!--<td class="actions">
						    <a href="<?php echo $this->webroot;?>admin/cities/edit/<?php echo $city['City']['id'];?>"><img src="<?php echo $this->webroot;?>img/edit.png" title="Edit City" width="22" height="21"></a>

						    <a href="<?php echo $this->webroot;?>admin/cities/delete/<?php echo $city['City']['id'];?>" onclick="return confirm('Are you sure to delete this city?')"><img src="<?php echo $this->webroot;?>img/delete.png" title="Delete City" width="24" height="24"></a>
							
						</td>-->
					</tr>
					<?php endforeach; ?>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /block -->
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

<style>
.actions a
{
 background:none;
 border:none;
 border-radius:0px;
 box-shadow:none;
 padding:0px;
}
</style>
<script>
function check(){
	document.selectForm.submit();

}
</script>
