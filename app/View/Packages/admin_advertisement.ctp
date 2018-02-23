<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Advertisement List'); ?></div>
			</div>
			<div class="block-content collapse in">
				<div class="span12">
					<table class="table table-hover">
					<thead>
					<tr>
                                            <th><?php echo $this->Paginator->sort('type', 'Advertisement'); ?></th>
                                            <th>Image</th>
                                            <th><?php echo $this->Paginator->sort('amount', 'Pay'); ?></th>
                                            <th><?php echo $this->Paginator->sort('start_date', 'Date'); ?></th>
                                            <th><?php echo $this->Paginator->sort('is_active','Status'); ?></th>
                                            <th><?php echo $this->Paginator->sort('is_paid','Payment Status'); ?></th>
                                            <th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php 
                                        $uploadPath=WWW_ROOT.'advertisement';
                                        foreach ($advertisement_list as $order): 
                                            $adv_id=$order['Advertisement']['id'];
                                            $amount=$order['Advertisement']['amount'];
                                            $is_paid=$order['Advertisement']['is_paid'];
                                            //$is_active=$order['Advertisement']['is_active'];
                                            $start_date=date('d/m/Y',strtotime($order['Advertisement']['start_date']));
                                            $end_date=date('d/m/Y',strtotime($order['Advertisement']['end_date']));
                                            $type=$order['Advertisement']['type'];
                                            $pos=$order['Advertisement']['page_position'];
                                            $is_active=$order['Advertisement']['is_active'];
                                            $image_name=$order['Advertisement']['image_name'];
                                            if($type==1){
                                                if(isset($pos) && $pos!=''){
                                                        $AdvertisementText='Home '.$pos.' Advert Box';
                                                }
                                                else{
                                                       $AdvertisementText='Home Advert Box';
                                                }

                                            }elseif($type==2){
                                                $AdvertisementText='Product Detail';
                                            }else{
                                                $AdvertisementText='Home Header & Product Detail';
                                            }

                                            if($is_active==0){
                                                $StatusText='<p class="status text-danger">Not active</p>';
                                            }
                                            elseif($order['Advertisement']['end_date'] >= gmdate('Y-m-d H:i:s')){
                                                $StatusText='<p class="status text-success">Active</p>';
                                            }else{
                                                $StatusText='<p class="status text-danger">Expired</p>';
                                            }
                                    
                                            if(isset($image_name) && $image_name!='' && file_exists($uploadPath . '/' . $image_name)){
                                                $AdvertiseImg=$this->webroot.'advertisement/'.$image_name;
                                            }else{
                                                $AdvertiseImg=$this->webroot.'shop_images/img.png';
                                            }
                                        ?>
					<tr>
                                            <td><?php echo isset($AdvertisementText)?$AdvertisementText:'';?></td>
                                            <td><img src="<?php echo $AdvertiseImg;?>" height="60" width="80" alt="" /></td>
                                            <td>$<?php echo $amount; ?>&nbsp;</td>
                                            <td><?php echo isset($start_date)?$start_date:'';?> - <?php echo isset($end_date)?$end_date:'';?></td>
                                            <td><?php echo isset($StatusText)?$StatusText:'';?></td>
                                            <td><?php echo (isset($is_paid) && $is_paid==1)?'<p class="status text-success">Paid</p>':'<p class="status text-warning">Not paid</p>';?></td>
                                            <td class="actions">
                                                <a href="<?php echo $this->webroot;?>admin/packages/advertisement_edit/<?php echo $adv_id;?>"><img src="<?php echo $this->webroot;?>img/edit.png" title="Edit Advertisement" width="22" height="21"></a>
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
