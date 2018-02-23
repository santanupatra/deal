<?php 
$login_userid = $this->Session->read('Auth.User.id');
$Ord_sl_no= Configure::read('ORDER_SL_NO');
if(count($conversation_list)>0){
    foreach($conversation_list as $msg_list){
        $prd_order_id=$msg_list['Comment']['order_id'];
    }
    if($prd_order_id!=''){
        $Order_details=$this->requestAction(array('controller' => 'orders', 'action' => 'get_order_IDdetails', $prd_order_id, 'admin'=>false, 'prefix' => ''));
        $OrderUserID=$Order_details['Order']['user_id'];
        $store_woner_id=$Order_details['Order']['store_woner_id'];
        if($login_userid==$OrderUserID){
            $Conversation_name=$this->requestAction(array('controller' => 'orders', 'action' => 'getUsername', $store_woner_id, 'admin'=>false, 'prefix' => ''));
        }elseif($login_userid==$store_woner_id){
            $Conversation_name=$this->requestAction(array('controller' => 'orders', 'action' => 'getUsername', $OrderUserID, 'admin'=>false, 'prefix' => ''));
        }
    }
}

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
                        <div class="">
                            <div class="search_box">
                                <h2>Conversation With <?php echo isset($Conversation_name)?$Conversation_name:''; ?></h2>
                                <div class="membership_container_right">
                                    <div class="membership_container_right_content_holder">
                                        <div class="pro_about">
                                            <div class="clearfix"></div>
                                            <?php //echo $this->element('inbox_header'); ?>
                                            <div class="clearfix"></div>
                                            <table class="conversation">
                                                <?php 
                                                $message_img = "message_img";
                                                $uploadMessagePath = WWW_ROOT . $message_img;
                                                $uploadFolder = "user_images";
                                                $uploadUserImgPath = WWW_ROOT . $uploadFolder;
                                                foreach ($conversation_list as $inboxMessage): ?>
                                                <tr <?php 
                                                        if($login_userid==$inboxMessage['Comment']['user_id']) { 
                                                        echo($inboxMessage['Comment']['is_read']==0?'style="background:#f9f9f9;"':''); 
                                                        } 
                                                        ?>>
                                                    <td>
                                                    <?php 
                                                        $imageName = $inboxMessage['User']['profile_image'];
                                                        if(file_exists($uploadUserImgPath . '/' . $imageName) && $imageName!=''){
                                                            $senderImage = $this->webroot.'user_images/'.$imageName;
                                                        } else {
                                                            $senderImage = $this->webroot.'user_images/default.png';
                                                        }
                                                        ?>
                                                        <div class="left_image_conv"> 
                                                            <?php
                                                            if($login_userid==$inboxMessage['Comment']['user_id']) { echo '<b>Me</b>'; } else { ?>
                                                            <b><?php echo $inboxMessage['User']['first_name'].' '.$inboxMessage['User']['last_name']; ?></b>
                                                            <?php } ?>
                                                            <?php echo (date('M d, Y H:i',strtotime($inboxMessage['Comment']['cdate']))); ?>
                                                                <!--<img title="<?php echo $inboxMessage['User']['first_name'].' '.$inboxMessage['User']['last_name'];?>" src="<?php echo $senderImage; ?>">-->
                                                        </div>
                                                        <div class="right_conv">
                                                        <span><?php echo isset($inboxMessage['Comment']['subject'])?$inboxMessage['Comment']['subject']:''; ?></span>
                                                        <?php echo $inboxMessage['Comment']['comments']; ?>
                                                        </div>

                                                        <?php if($login_userid!=$inboxMessage['Comment']['user_id']) {
                                                            $sendname=$inboxMessage['User']['first_name'].' '.$inboxMessage['User']['last_name'];
                                                            $user_comment_id = base64_encode($inboxMessage['Comment']['id']);
                                                            $user_thread_id = base64_encode($inboxMessage['Comment']['thread_id']);
                                                            ?>
                                                        <div>
                                                                <a href="javascript:void()" onclick="showMessage('<?php echo $user_comment_id;?>','<?php echo $sendname;?>','<?php echo $user_thread_id;?>');">Reply</a>
                                                        </div>
                                                        <?php }
                                                        $file_name=$inboxMessage['Comment']['file_name'];
                                                        if($file_name!='' && file_exists($uploadMessagePath . '/' . $file_name)){ 
                                                            $MessageFileLink=$this->webroot.'message_img/'.$file_name;
                                                        ?>

                                                        <div class="attach_ment">
                                                            <a href="<?php echo $MessageFileLink;?>" download="download"><img title="Download attachment" src="<?php echo ($this->webroot); ?>images/attach.png"></a>
                                                        </div>
                                                        <?php } ?>

                                                        <div class="clearfix"></div>
                                                        <div class="bottom_conv">
                                                        <?php //echo (date('M d, Y H:i',strtotime($inboxMessage['Comment']['cdate']))); ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                        </table>
                                        <form name="sendmesg" id="sendmesg" action="" method="post" enctype="multipart/form-data" >
                                            <input type="hidden" name="comment_id" id="CommentID" value="">
                                            <input type="hidden" name="frm_type" value="ReplyFrm">
                                            <div class="reply_covertation" id="MsgDiv" style="display:none">
                                                <div class="inner_covertation">
                                                    <span style="text-transform: none;">Send a message to  <b id="sendName"></b></span>
                                                    <textarea name="data[Comment][comments]" id="SentMessageMessage" required="required"></textarea>
                                                    <div class="send_sec">
                                                        <input type="button" class="atch_btn" value="Attach Files" onclick="$('#theFile' ).click();"/>
                                                        <input type="file" name="data[Comment][file_name]" id="theFile" class="contact_text_box" value="" style="display:none;"/>
                                                        <input type="submit" class="send_btn" value="Send"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
		
	</div>
</section>

<script>
function showMessage(commentid,name,tid){
    //alert(sid+'|'+name);
    $('#CommentID').val(commentid);
    $('#sendName').html(name);
    $('#MsgDiv').show();
    $('html, body').animate({
        scrollTop: $("#MsgDiv").offset().top
    }, 2000);
}
</script>


