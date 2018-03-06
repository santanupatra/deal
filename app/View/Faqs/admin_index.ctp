
<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Faq List'); ?></div>
				<div style="float:right;"><?php echo $this->Html->link(__('Add New faq'), array('controller' => 'faqs', 'action' => 'add')); ?></div>
			</div>
			<div class="block-content collapse in">
                            <div class="span12">
                                <table class="table table-hover">
                                    <thead>
					<tr>
                                            <th><?php echo $this->Paginator->sort('id'); ?></th>
                                            <th><?php echo $this->Paginator->sort('question'); ?></th>
                                            <th><?php echo $this->Paginator->sort('answer'); ?></th>
                                            <th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
                                    </thead>
                                    <tbody>
					<?php foreach ($allfaq as $faq): ?>
					<tr>
                                            <td><?php echo $faq['Faq']['id']; ?>&nbsp;</td>
                                            <td><?php echo h($faq['Faq']['question']);?></td>
                                            <td><?php echo h($faq['Faq']['answer']);?></td>
                                            <td class="actions">

                  <a href="<?php echo $this->webroot?>admin/faqs/edit/<?php echo $faq['Faq']['id']?>" ><img src="<?php echo $this->webroot;?>img/edit.png" title="Edit" width="22" height="21"></a>
                  <a href="<?php echo $this->webroot?>admin/faqs/delete/<?php echo $faq['Faq']['id']?>" class="btn btn-danger" onclick="return confirm('are you sure to delete this faq?');"><img src="<?php echo $this->webroot;?>img/delete.png" title="Delete" width="24" height="24"></a>
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