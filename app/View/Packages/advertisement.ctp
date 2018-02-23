<?php 

$userid = $this->Session->read('Auth.User.id');
?>
<style type="text/css">
/** Paging **/
.paging {
	background:#fff;
	color: #ccc;
	margin-top: 1em;
	clear:both;
}
.paging .current,
.paging .disabled,
.paging a {
	text-decoration: none;
	padding: 5px 8px;
	display: inline-block
}
.paging > span {
	display: inline-block;
	border: 1px solid #ccc;
	border-left: 0;
}
.paging > span:hover {
	background: #efefef;
}
.paging .prev {
	border-left: 1px solid #ccc;
	-moz-border-radius: 4px 0 0 4px;
	-webkit-border-radius: 4px 0 0 4px;
	border-radius: 4px 0 0 4px;
}
.paging .next {
	-moz-border-radius: 0 4px 4px 0;
	-webkit-border-radius: 0 4px 4px 0;
	border-radius: 0 4px 4px 0;
}
.paging .disabled {
	color: #ddd;
}
.paging .disabled:hover {
	background: transparent;
}
.paging .current {
	background: #efefef;
	color: #c73e14;
}
.name {
	color:#009cdb;
}
.name a {
	color:#009cdb;
}
.pro_about{height:auto;width:773px;padding:18px;background: white;border-radius:3px;box-shadow:0 0 2px #999;margin-top:20px;float:left;margin-left:20px;padding:20px;}
.profile_btn{border:1px solid #dadbda;padding:5px 10px 5px 10px;color:#747674;border-radius: 3px;margin:10px 0px 0px 0px;}
.pro_right_btn{float:right !important;margin-right:10px;border:0px !important;margin-top:13px;}
</style>

<section class="after_login">
    <div class="container">
        <div class="row">
            <?php echo($this->element('user_leftbar'));?>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-sm-8">
                        <h4>Advertisement</h4>
                    </div>
                    <div class="col-sm-4">
                        <h4 class="text-right">
                            <a href="<?php echo($this->webroot);?>packages/advertisement_add" class="btn btn-primary">Add New</a>
                        </h4>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered advertise-table">
                                <thead>
                                    <th>Advertisement</th>
                                    <th>Pay</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Actions</th>
                                </thead>
                                <tbody>
                                <?php 
                                if(count($advertisement_list)>0){
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
                                    
                            ?>
                                <tr>
                                    <td><?php echo isset($AdvertisementText)?$AdvertisementText:'';?></td>
                                    <td class="text-center">$<?php echo isset($amount)?$amount:'';?></td>
                                    <td class="text-center"><?php echo isset($start_date)?$start_date:'';?> - <?php echo isset($end_date)?$end_date:'';?></td>
                                    <td class="text-center"><?php echo isset($StatusText)?$StatusText:'';?></td>
                                    <td class="text-center"><?php echo (isset($is_paid) && $is_paid==1)?'<p class="status text-success">Paid</p>':'<p class="status text-warning">Not paid</p>';?></td>
                                    <td class="text-center action">
                                    <?php if($is_active==1 && $is_paid==1 && $order['Advertisement']['end_date'] < gmdate('Y-m-d H:i:s')){ ?>
                                        <a href="<?php echo($this->webroot);?>packages/advertisement_renew/<?php echo base64_encode($adv_id);?>" title="Edit Advertisement"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <?php } ?>
                                        <a href="<?php echo($this->webroot);?>packages/advertisement_details/<?php echo base64_encode($adv_id);?>" title="View Advertisement"><i class="fa fa-search" aria-hidden="true"></i></a>
                                        <a href="<?php echo($this->webroot);?>packages/advertisement_delete/<?php echo base64_encode($adv_id);?>" onclick="return confirm('Are you sure want to delete this advertisement?');" title="Delete"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach;
                                }else{
                                    echo '<tr><td colspan="6"><h4>No records found.</h4></td></tr>';
                                }
                            ?>
                                        
                                </tbody>
                            </table>
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
                </div>

            </div>
        </div>

    </div>
</section>
