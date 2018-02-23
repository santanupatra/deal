<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Sliders'); ?></div>
				<div style="float:right;"><?php echo $this->Html->link(__('Add New Slider'), array('controller' => 'sliders', 'action' => 'add')); ?></div>
			</div>
			<div class="block-content collapse in">
				<div class="span12">
					<table class="table table-hover">
					<thead>
					<tr>
						<th><?php echo $this->Paginator->sort('id'); ?></th>
                                                <th><?php echo $this->Paginator->sort('image'); ?></th>
                                                <th><?php echo $this->Paginator->sort('active'); ?></th>

                                                <th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($sliders as $slider_browse): ?>
					<tr>
                                            <td><?php echo h($slider_browse['Slider']['id']); ?>&nbsp;</td>
                                            <td><?php
                                                    $uploadFolder = "slider_images";
                                                    $uploadPath = WWW_ROOT . $uploadFolder;
                                                    $imageName = $slider_browse['Slider']['image'];
                                                    if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
                                                            echo($this->Html->image('/slider_images/'.$imageName, array('height' => '100','width' => '100')));
                                                    } 
                                                    ?>&nbsp;</td>
                                            <td><?php echo h($slider_browse['Slider']['active']==1?'Yes':'No'); ?>&nbsp;</td>
                                            <td class="actions">
                                             <a href="<?php echo $this->webroot;?>admin/sliders/edit/<?php echo $slider_browse['Slider']['id'];?>"><img src="<?php echo $this->webroot;?>img/edit.png" title="Edit Slider" width="22" height="21"></a>

                                             <a href="<?php echo $this->webroot;?>admin/sliders/delete/<?php echo $slider_browse['Slider']['id'];?>" onclick="return confirm('Are you sure to delete?')"><img src="<?php echo $this->webroot;?>img/delete.png" title="Delete Slider" width="24" height="24"></a>
                                            </td>
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
