<?php 
//$Ord_sl_no=10000000;
$Ord_sl_no= Configure::read('ORDER_SL_NO');

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
                        <div class="col-md-12 product_title" style="margin-bottom: 0px;">
                            <h4>Mail</h4>
                        </div>
                        <ul class="nav nav-tabs buyer-tab" role="tablist">
                            <li role="presentation"><a href="Javascript: void(0);" class="delete-icon delete_data"><i class="fa fa-trash"></i></a></li>
                            <li role="presentation"><a href="<?php echo $this->webroot.'orders/seller_mail';?>">Inbox</a></li>
                            <li role="presentation" class="active"><a href="<?php echo $this->webroot.'orders/seller_sent';?>">Sent</a></li>
                            <li role="presentation" class=""><a href="<?php echo $this->webroot.'orders/seller_folder';?>">Folder</a></li>
                        </ul>
                        <form method="post" action="" name="InboxMsgFrm" id="InboxMsgFrm">
                            <input type="hidden" name="messageType" value="InboxDelete">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="sent">
                                <div class="table-responsive">
                                    <table class="table buyer-msg-table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>To</th>
                                                <th>Message</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        if(count($sent_list)>0){
                                            foreach ($sent_list as $message): 
                                                //pr($message);
                                                $order_date=date('dS M, Y',strtotime($message['Comment']['cdate']));
                                                //$order_id=isset($message['Comment']['order_id'])?$message['Comment']['order_id']:'';
                                                $msg_id=isset($message['Comment']['id'])?$message['Comment']['id']:'';
                                                $to_name=isset($message['ToUser']['first_name'])?$message['ToUser']['first_name'].' '.$message['ToUser']['last_name']:'';
                                                //$sl_no=$Ord_sl_no+$order_id;
                                                //$order_subject=isset($message['Comment']['subject'])?$message['Comment']['subject']:'';
                                                $comments=isset($message['Comment']['comments'])?$message['Comment']['comments']:'';
                                                
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="chkbx"><input type="checkbox" name="del_msg[]" class="inbox_del_msg" value="<?php echo $msg_id;?>" /></div>
                                                </td>
                                                <td><?php echo $to_name;?></td>
                                                <td><?php echo $comments;?><!--Order ID: Packaging Joint Shares ice--></td>
                                                <td><?php echo $order_date;?></td>
                                            </tr>    
                                        <?php 
                                            endforeach;
                                            }else{
                                                echo '<tr><td colspan="4"><h4>No records found.</h4></td></tr>';
                                            }
                                        ?>    
                                        </tbody>
                                    </table>
                                    <p>
                                    <?php
                                    echo $this->Paginator->counter(array(
                                    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                                    ));
                                    ?>	
                                    </p>
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
                        </form>
                    </div>
                </div>
		
	</div>
</section>

<script> 				
    $(document).ready(function(){
	$(".delete_data").click(function () {
            if ($(".inbox_del_msg:checked").length > 0) {
		if(confirm('Are you sure to delete this message?')){
                    document.InboxMsgFrm.submit();
		}else{
                    
                }
            }else{
                alert('Pleace check at least one message.');
                return false;
            }
	});	
    });	
</script>

