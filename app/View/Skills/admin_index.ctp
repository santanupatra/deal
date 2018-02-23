<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Offers'); ?></div>
				<div style="float:right;"></div>
			</div>
			<div class="block-content collapse in">
				<div class="span12">
					<table class="table table-hover">
					<thead>
					<tr>
						<th>#<?php echo $this->Paginator->sort('id'); ?></th>
						<th>Category Name</th>
						<th>Maker</th>
						<th>Post Date</th>
						<th>Status</th>
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php 
					if(!empty($skills)){
					foreach ($skills as $skill): 
					//print_r($skill); exit;	
					
					?>
					<tr>
							<td><?php echo h($skill['Skill']['id']); ?>&nbsp;</td>

							<td><?php echo h($skill['Skill']['skill_name']); ?>&nbsp;</td>

							<td><a href="<?php echo $this->webroot;?>admin/users/user_view/<?php echo h($skill['Skill']['user_id']); ?>"><?php echo h($skill['User']['first_name'].' '.$skill['User']['last_name']); ?></a>&nbsp;</td>

							<td><?php echo date('M d, Y',strtotime($skill['Skill']['post_date'])); ?>&nbsp;</td>

							<td><?php if(isset($skill['Skill']['is_active']) && $skill['Skill']['is_active']==1){echo 'Active';}else{echo 'Not Active';} ?>&nbsp;</td>

							<td class="actions">
							 <a href="<?php echo $this->webroot;?>skills/details/<?php echo base64_encode($skill['Skill']['id']);?>" target="_blank"><img src="<?php echo $this->webroot;?>img/view.png" title="View Offer"></a>
							 <?php if(isset($skill['Skill']['is_active']) && $skill['Skill']['is_active']==1){ ?>
							    <a href="<?php echo $this->webroot;?>admin/skills/deactivate/<?php echo $skill['Skill']['id'];?>"><img src="<?php echo $this->webroot;?>img/deactivate.png" title="Deactivate" width="20" height="20"></a>
							 <?php }else{ ?>
							    <a href="<?php echo $this->webroot;?>admin/skills/activate/<?php echo $skill['Skill']['id'];?>"><img src="<?php echo $this->webroot;?>img/activate.png" title="Make Active" width="20" height="20"></a>
							 <?php } ?>

							 <?php if($skill['Skill']['category_id']!='' && $skill['Skill']['about_specifically']!='' && $skill['Skill']['skill_details']!='' && $skill['Skill']['skill_tool_pics']!='' && $skill['Skill']['address']!='' && $skill['Skill']['skill_country']!='' && $skill['Skill']['skill_city']!='' && $skill['Skill']['skill_street']!='' && $skill['Skill']['skill_zipcode']!='' && $skill['Skill']['party_size']!='' && $skill['Skill']['skill_tools']!='' && $skill['Skill']['studio_details']!='' && $skill['Skill']['min_price']!='' && $skill['Skill']['max_price']!='' && $skill['Skill']['price_details']!='')
			                 { 
								 ?>

							<img src="<?php echo $this->webroot;?>img/done.png" title="Completed" width="22" height="22">

							<?php
							 }
							else {

							 ?>
							<img src="<?php echo $this->webroot;?>img/not_done.png" title="Incomplete" width="22" height="22">
							 <?php
							 } ?>
							</td>
					</tr>
	                <?php endforeach;}else{ ?>
					  <tr>
					   <td colspan='7'>
					    No order found.
					   </td>
					  </tr>
					<?php } ?>
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