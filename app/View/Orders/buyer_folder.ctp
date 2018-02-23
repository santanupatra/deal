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
                        <div class="col-md-12 product_title" style="margin-bottom: 0px; padding-left: 0;">
                            <h4>Mail</h4>
                        </div>
                        <?php if(isset($folder_type) && $folder_type!=''){?>
                        <div class="col-md-12">
                            <div class="order-search">
                                <form method="post" action="" class="form-inline">
                                    <input type="hidden" name="messageType" value="InboxSearch">
                                    <div class="form-group">
                                        <input id="order_no" class="form-control" type="number" value="<?php echo isset($order_no)?$order_no:'';?>" placeholder="Order ID." name="order_no" min="1">
                                    </div>
                                    <div class="form-group">
                                        <input id="exampleInputPassword3" class="form-control" type="text" value="<?php echo isset($order_name)?$order_name:'';?>" placeholder="Name" name="user_name">
                                    </div>
                                    <button class="btn btn-default" type="submit">Search</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-12">&nbsp;</div>
                        <?php }?>
                        <ul class="nav nav-tabs buyer-tab" role="tablist">
                            <?php if(isset($folder_type) && $folder_type!=''){?>
                            <li role="presentation"><a href="Javascript: void(0);" class="delete-icon delete_data"><i class="fa fa-trash"></i></a></li><?php }else{?>
                            <li role="presentation"><a href="Javascript: void(0);" class="delete-icon delete_folder_data"><i class="fa fa-trash"></i></a></li>
                            <?php }?>
                            <li role="presentation" class=""><a href="<?php echo $this->webroot.'orders/buyer_message';?>">Inbox</a></li>
                            <!--<li role="presentation" class=""><a href="<?php echo $this->webroot.'orders/buyer_sent';?>">Sent</a></li>
                            <li role="presentation" class="active"><a href="<?php echo $this->webroot.'orders/buyer_folder';?>">Folder</a></li>-->
                            <li role="presentation" class=""><a href="<?php echo $this->webroot.'orders/buyer_sent';?>" title="Sent">Sent</a></li>
                            <li role="presentation" class="folder active"><a href="<?php echo $this->webroot.'orders/buyer_folder';?>">Folder</a></li>
                            <li role="presentation" class="default_hide"><a href="Javascript: void(0);" class="move_to_folder" title="Move into folder"><i class="fa fa-folder" aria-hidden="true"></i></a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="inbox">
                                <div class="table-responsive">
                                    <?php if(isset($folder_type) && $folder_type!=''){?>
                                    <table class="table buyer-msg-table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Name</th>
                                                <th>Subject</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <form method="post" action="" name="InboxMsgFrm" id="InboxMsgFrm">
                                            <input type="hidden" name="messageType" id="messageType" value="InboxDelete">
                                            <input type="hidden" name="folderID" id="folderID" value="">
                                        <?php 
                                        if(count($messages_list)>0){
                                            foreach ($messages_list as $message): 
                                                $order_date=date('dS M, Y',strtotime($message['Comment']['cdate']));
                                                //$order_id=isset($message['Comment']['order_id'])?$message['Comment']['order_id']:'';
                                                $msg_id=isset($message['Comment']['id'])?$message['Comment']['id']:'';
                                                $seller_name=isset($message['User']['first_name'])?$message['User']['first_name'].' '.$message['User']['last_name']:'';
                                                //$sl_no=$Ord_sl_no+$order_id;
                                                $order_subject=isset($message['Comment']['subject'])?$message['Comment']['subject']:'';
                                                $msg_thread_id=isset($message['Comment']['thread_id'])?$message['Comment']['thread_id']:'';
                                                $buyer_is_read=isset($message['Comment']['is_read'])?$message['Comment']['is_read']:'';
                                                if($buyer_is_read==0){
                                                    $read_class='selected-mail';
                                                }else{
                                                    $read_class='read-mail';
                                                }
                                        ?>
                                            <tr class="<?php echo $read_class;?>">
                                                <td>
                                                    <div class="chkbx"><input type="checkbox" name="del_msg[]" class="inbox_del_msg" value="<?php echo $msg_id;?>" /></div>
                                                </td>
                                                <td><?php echo $seller_name;?></td>
                                                <td><a href="<?php echo $this->webroot.'orders/message_conversations/'.base64_encode($msg_thread_id);?>"><?php echo $order_subject;?></a><!--Order ID: Packaging Joint Shares ice--></td>
                                                <td><?php echo $order_date;?></td>
                                            </tr>    
                                        <?php 
                                            endforeach;
                                        }else{
                                            echo '<tr><td colspan="4"><h4>No records found.</h4></td></tr>';
                                        }
                                        ?>    
                                            </form>
                                        </tbody>
                                    </table>
                                    <?php }else{?>
                                    <table class="table buyer-msg-table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Folder Name</th>
                                                <th>Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <!--<form method="post" action="" name="BuyerFldFrm" id="BuyerFldFrm">-->
                                        <form method="post" action="" name="InboxMsgFrm" id="InboxMsgFrm">    
                                            <input type="hidden" name="messageType" id="messageType" value="FolderDelete">
                                            <input type="hidden" name="folderID" id="folderID" value="">
                                        <?php 
                                        if(count($messages_list)>0){
                                            foreach ($messages_list as $message): 
                                                //pr($message);
                                                $order_date=date('dS M, Y',strtotime($message['MailFolder']['cdate']));
                                                $folder_id=isset($message['MailFolder']['id'])?$message['MailFolder']['id']:'';
                                                $folder_name=isset($message['MailFolder']['folder_name'])?$message['MailFolder']['folder_name']:'';
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="chkbx"><input type="checkbox" name="del_folder_id[]" class="inbox_del_msg" value="<?php echo $folder_id;?>" /></div>
                                                </td>
                                                <td><a href="<?php echo $this->webroot.'orders/buyer_folder/'.base64_encode($folder_id);?>"><?php echo $folder_name;?></a></td>
                                                <td><?php echo $order_date;?></td>
                                                <td><a href="<?php echo $this->webroot.'orders/buyer_folder/'.base64_encode($folder_id);?>">View</a></td>
                                            </tr>    
                                        <?php 
                                            endforeach;
                                        }else{
                                            echo '<tr><td colspan="3"><h4>No records found.</h4></td></tr>';
                                        }
                                        ?> 
                                        </form>    
                                        </tbody>
                                    </table>
                                    <?php    
                                    }
                                    ?>
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
                    </div>
                </div>
	</div>
</section>


<div class="modal fade" id="CancelOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog dispute-request">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Move into folder</h4>
            </div>
            <form class="form-horizontal" method="post" action="">
                <div class="modal-body">
                    <div id="AjaxFolderMsg"></div>
                    <?php
                    if(isset($mail_folder) && count($mail_folder)>0){
                        echo ' <div class="form-group select_folder_div">
                        <label for="inputEmail3" class="col-sm-3 control-label">Select Folder:</label>
                        <div class="col-sm-9">
                            <select id="select_folder_name" class="form-control" required="required"><option value="">Select Folder</option>';
                        foreach($mail_folder as $mval){
                            $folder_name=$mval['MailFolder']['folder_name'];
                            $folder_id=$mval['MailFolder']['id'];
                                echo '<option value="'.$folder_id.'">'.$folder_name.'</option>';
                        }
                        echo '</select>
                        </div>
                    </div>';
                    }
                    ?>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label"><a href="Javascript: void(0);" class="add_folder">Add Folder</a></label>
                    </div> 
                    <div class="form-group folder_name_div" style="display: none;">
                        <label for="inputEmail3" class="col-sm-3 control-label">Folder Name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="text_folder_name" required="required">
                        </div>
                    </div>              
                </div>
                <div class="modal-footer">
                    <?php if(isset($mail_folder) && count($mail_folder)>0){?>
                    <button type="button" class="btn btn-primary select_folder_cnf">Confirm</button>
                    <button type="button" class="btn btn-primary add_folder_cnf" style="display: none;">Confirm</button>
                    <?php }else{?>
                    <button type="button" class="btn btn-primary add_folder_cnf" style="display: none;">Confirm</button>
                    <?php }?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script> 				
    $(document).ready(function(){
        $('.default_hide').hide();
	$(".delete_data").click(function () {
            if ($(".inbox_del_msg:checked").length > 0) {
		if(confirm('Are you sure to delete this message?')){
                    $('#messageType').val('InboxDelete');
                    document.InboxMsgFrm.submit();
		}else{
                    
                }
            }else{
                alert('Pleace check at least one message.');
                return false;
            }
	});
        
        $(".delete_folder_data").click(function () {
            if ($(".inbox_del_msg:checked").length > 0) {
		if(confirm('Are you sure to delete this folder?')){
                    $('#messageType').val('FolderDelete');
                    document.InboxMsgFrm.submit();
		}else{
                    
                }
            }else{
                alert('Pleace check at least one folder.');
                return false;
            }
	});
        
        $(".move_to_folder").click(function () {
            if ($(".inbox_del_msg:checked").length > 0) {
		if(confirm('Are you sure to move this message into the folder?')){
                    $('#messageType').val('MoveToFolder');
                    $('#CancelOrder').modal();
                    $('.select_folder_div').show();
                    $('.folder_name_div').hide();
                    //document.InboxMsgFrm.submit();
		}else{
                    
                }
            }else{
                alert('Pleace check at least one message.');
                return false;
            }
	});
        $(".add_folder").click(function () {
            $('.select_folder_div').hide();
            $('.folder_name_div').show();
            $('.select_folder_cnf').hide();
            $('.add_folder_cnf').show();
        });
        
        $(".add_folder_cnf").click(function () {
            var text_folder_name=$('#text_folder_name').val();
            if(text_folder_name!=''){
                $.ajax({
                    type:'post' ,
                    data: {'text_folder_name':text_folder_name},
                    url:'<?php echo $this->webroot;?>orders/save_folder_name/',
                    success:function(data){
                        if(data!=''){
                            var DataSplit = data.split('|');
                            var MsgType=DataSplit[0];
                            if(MsgType=='1'){
                                $('#folderID').val(DataSplit[1]);
                                document.InboxMsgFrm.submit();
                            }else{
                                $("#AjaxFolderMsg").html('');
                                $("#AjaxFolderMsg").html('<div class="form-group"><div class="col-md-12"><div class="alert alert-danger"><strong>Error!</strong> '+DataSplit[1]+'</div></div></div>');
                            }
                        }
                    }
                });
            }else{
                alert('Please enter a folder name.');
                $('#text_folder_name').focus();
            }
        });
        
        $(".select_folder_cnf").click(function () {
            var select_folder_name=$('#select_folder_name').val();
            if(select_folder_name!=''){
                $('#folderID').val(select_folder_name);
                document.InboxMsgFrm.submit();
            }else{
                alert('Please select a folder.');
                $('#select_folder_name').focus();
            }
        });
        
        $(".inbox_del_msg").click(function () {
            if ($(".inbox_del_msg:checked").length > 0) {
		$('.default_hide').show();
                $('.folder').hide();
            }else{
                $('.default_hide').hide();
                $('.folder').show();
            }
	});
        
        /*$(".inbox_del_msg").click(function () {
            if ($(".inbox_del_msg:checked").length > 0) {
		$('.default_hide').show();
                $('.folder').hide();
            }else{
                $('.default_hide').hide();
                $('.folder').show();
            }
	});*/
    });	
</script>

