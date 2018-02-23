<?php 
$uploadFolder = "product_images";
$uploadPath = WWW_ROOT . $uploadFolder;
$Ord_sl_no= Configure::read('ORDER_SL_NO');
if(isset($order_details) && count($order_details)>0){
    //pr($order_details);
    $order_date=date('dS M, Y',strtotime($order_details['Order']['order_date']));
    $order_details_id=$order_details['OrderDetail']['id'];
    $buyer_accept_dispute=$order_details['OrderDetail']['buyer_accept_dispute'];
    $order_id=$order_details['Order']['id'];
    $product_id=isset($order_details['OrderDetail']['product_id'])?$order_details['OrderDetail']['product_id']:'';
    $prd_name=$order_details['Product']['name'];
    $prd_price=$order_details['OrderDetail']['price'];
    $order_quantity=$order_details['OrderDetail']['quantity'];
    $seller_name=$order_details['User']['first_name'].' '.$order_details['User']['last_name'];
    
    $prd_disput_details=$this->requestAction(array('controller' => 'orders', 'action' => 'get_dispute_details', $order_details_id, 'admin'=>false, 'prefix' => ''));
    if(count($prd_disput_details)>0){
        $dispute_id=$prd_disput_details['Dispute']['id'];
        $dispute_date=date('dS M, Y H:i a',strtotime($prd_disput_details['Dispute']['cdate']));
        $seller_response=$prd_disput_details['Dispute']['seller_response'];
        $receive_order=$prd_disput_details['Dispute']['receive_order'];
        $payment_received=$prd_disput_details['Dispute']['payment_received'];
        $refund_request=$prd_disput_details['Dispute']['refund_request'];
        $select_reason=$prd_disput_details['Dispute']['select_reason'];
        $dispute_details=$prd_disput_details['Dispute']['dispute_details'];
        $is_close=$prd_disput_details['Dispute']['is_close'];
        $seller_dispute_action=$prd_disput_details['Dispute']['seller_dispute_action'];
        
        $dispute_history=$this->requestAction(array('controller' => 'orders', 'action' => 'get_dispute_history', $dispute_id, 'admin'=>false, 'prefix' => ''));
        $dispute_images=$this->requestAction(array('controller' => 'orders', 'action' => 'get_dispute_images', $dispute_id, 'admin'=>false, 'prefix' => ''));
    }
    
    $message_list=$this->requestAction(array('controller' => 'orders', 'action' => 'get_dispute_message', $order_details_id, 'admin'=>false, 'prefix' => ''));
    
    $prd_img=$this->requestAction(array('controller' => 'orders', 'action' => 'get_product_image', $product_id, 'admin'=>false, 'prefix' => ''));
                                        
    $Prd_img_name=isset($prd_img['ProductImage']['name'])?$prd_img['ProductImage']['name']:'';

    $order_no=$Ord_sl_no+$order_id;
}

if(isset($Prd_img_name) && $Prd_img_name!='' && file_exists($uploadPath . '/' . $Prd_img_name)){
    $PrdImgLink=$this->webroot.'product_images/'.$Prd_img_name;
}else{
    $PrdImgLink=$this->webroot.'product_images/default.png';
}
?>

<section class="after_login">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="breadcmb">
                    <a href="<?php echo $this->webroot.'orders/buyer_disputes';?>">Dispute List</a> > <a href="" class="active">Dispute Detail</a>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <p class="text-right">
                    <?php if(isset($seller_response) && $seller_response==0){?>
                    <a class="btn btn-default" href="<?php echo $this->webroot.'orders/cancel_dispute_order/'.base64_encode($order_details_id);?>" onclick="return confirm('Are you sure want to cancel this dispute?');">Cancel Dispute</a>
                    <?php }elseif(isset($seller_response) && $seller_response==1 && $seller_dispute_action==2 && $is_close==0){?>
                        <a class="btn btn-warning buyer_responce" href="Javascript: void(0);">Respond</a>
                        <?php if(isset($buyer_accept_dispute) && $buyer_accept_dispute==0){?>
                        <a class="btn btn-primary" href="<?php echo $this->webroot.'orders/buyer_accept_dipute/'.base64_encode($order_details_id).'/'.base64_encode($dispute_id);?>" onclick="return confirm('Are you sure?');">Accept</a>
                        <?php }?>
                        <a class="btn btn-default" href="<?php echo $this->webroot.'orders/cancel_dispute_order/'.base64_encode($order_details_id);?>" onclick="return confirm('Are you sure want to cancel this dispute?');">Cancel</a>
                    <?php }?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <h4>Detail</h4>
                <div class="detail-info-hold Dtls">
                    <p><span>Order No:</span> <?php echo isset($order_no)?$order_no:'';?></p>
                    <p class="text-success"><span>Status:</span> <?php if(isset($seller_response) && $seller_response==0){ echo 'Awaiting Response';}elseif(isset($seller_response) && $seller_response==1 && $seller_dispute_action==1){ echo 'Seller accept issue';}elseif(isset($seller_response) && $seller_response==1 && $seller_dispute_action==2){ echo 'Supplier did not agree to the reason you mentioned in dispute';}?></p>
                </div>
                <h4>Information</h4>
                <div class="detail-info-hold Info">
                    <p><span>Did you receive your order</span> <?php echo isset($receive_order)?$receive_order:'';?></p>
                    <p><span>Do you want to return goods</span> Yes</p>
                    <p><span>Dispute Reason:</span> <?php echo isset($select_reason)?$select_reason:'';?></p>
                    <p><span>Dispute Order Total:</span> US $<?php echo isset($payment_received)?$payment_received:'';?></p>
                    <?php if(isset($seller_response) && $seller_response==1){
                        $get_return_amt=$this->requestAction(array('controller' => 'orders', 'action' => 'get_return_amount', $dispute_id, 'admin'=>false, 'prefix' => ''));
                        if(count($get_return_amt)>0){
                            $dispute_refund_amount=$get_return_amt['DisputeMessage']['refund_amount'];
                            if($dispute_refund_amount>0){
                                echo '<p><span>Refund Amount:</span> US $'.$dispute_refund_amount.'</p>';
                            }
                        }
                    }
                    ?>
                    <p><span>Dispute Opened:</span> <?php echo isset($dispute_date)?$dispute_date:'';?></p>
                    <p><span>Requests Detail:</span> <?php echo isset($dispute_details)?$dispute_details:'';?></p>
                </div>
            </div>
            <div class="col-md-5">
                <h4>Product Info</h4>
                <div class="detail-info-hold Prod-Info">
                    <div class="row">
                        <div class="col-xs-2 padding-right0">
                            <div class="square-prod-image">
                                    <img src="<?php echo $PrdImgLink;?>" alt="">
                            </div>
                        </div>
                        <div class="col-xs-10">
                            <p class="free">Free Shipping <br> <?php echo isset($prd_name)?$prd_name:'';?></p>
                            <!--<p class="color">Color: Black</p>-->
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            <p><span class="first">Order No:</span> <?php echo isset($order_no)?$order_no:'';?></p>
                            <p><span class="first">Seller:</span> <?php echo isset($seller_name)?$seller_name:'';?></p>
                            <h5>Visit Store</h5>
                            <p><span class="first">Unit Price:</span> US $<?php echo isset($prd_price)?$prd_price:'';?></p>
                            <p><span class="first">Quantity:</span> <?php echo isset($order_quantity)?$order_quantity:'';?></p>
                            <hr style="border-color:#ccc">
                            <p class="text-center"><a href="<?php echo $this->webroot.'orders/order_details/'.base64_encode($order_id);?>" class="btn btn-primary">View the Order</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <h4>History</h4>
                <div class="detail-info-hold">
                    <div class="table-responsive">
                        <table class="table table-bordered prod-history-table">
                            <thead>
                                <tr>
                                    <th>Initiator</th>
                                    <th>Received Goods</th>
                                    <th>Return Goods</th>
                                    <th>Refund Amount</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                    <th>Reason & Detail</th>
                                    <th>Attachment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $LoopCnt=0;
                                if(isset($dispute_history) && count($dispute_history)>0){
                                    foreach ($dispute_history as $DVal){
                                        $LoopCnt++;
                                        $reason=$DVal['DisputeMessage']['reason'];
                                        $received_goods=$DVal['DisputeMessage']['received_goods'];
                                        $return_goods=$DVal['DisputeMessage']['return_goods'];
                                        $refund_request=$DVal['DisputeMessage']['refund_request'];
                                        $refund_amount=$DVal['DisputeMessage']['refund_amount'];
                                        $action=$DVal['DisputeMessage']['action'];
                                        $user_type=$DVal['DisputeMessage']['user_type'];
                                        $cdate=isset($DVal['DisputeMessage']['cdate'])?date('dS M, Y H:i a',strtotime($DVal['DisputeMessage']['cdate'])):'';
                                        if($user_type==1){
                                            $user_type_text='Buyer';
                                        }elseif($user_type==2){
                                            $user_type_text='Seller';
                                        }elseif($user_type==3){
                                            $user_type_text='TWOP';
                                        }else{
                                            $user_type_text='Buyer';
                                        }
                                ?>
                                <tr>
                                    <td><?php echo $user_type_text;?></td>
                                    <td><?php echo isset($received_goods)?$received_goods:'';?></td>
                                    <td><?php echo isset($return_goods)?$return_goods:'';?></td>
                                    <td>US $<?php echo isset($refund_amount)?$refund_amount:'';?></td>
                                    <td><?php echo isset($cdate)?$cdate:'';?></td>
                                    <td><?php echo isset($action)?$action:'';?></td>
                                    <td><?php echo isset($reason)?$reason:'';?></td>
                                    <td><?php if(isset($dispute_images) && count($dispute_images)>0 && $LoopCnt==1){?> <a href="Javascript: void(0);" class="atch_btn show_attach_img" title="View" style="border: none; background-color: #fff;">&nbsp;</a><?php }?></td>
                                </tr>
                                <?php
                                    }
                                }else{
                                    echo '<tr><td colspan="8"><p style="text-align: center; font-weight: bold;">No record found.</p></td></tr>';
                                }
                                ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <h4>Message History</h4>
                <div class="detail-info-hold msg-Hist">
                    <?php
                    $message_img = "message_img";
                    $uploadMessagePath = WWW_ROOT . $message_img;
                    if(isset($message_list) && count($message_list)>0){
                        foreach ($message_list as $msg){
                            $MessageFileLink='';
                            $user_name=$msg['User']['first_name'].' '.$msg['User']['last_name'];
                            $user_comments=$msg['Comment']['comments'];
                            $file_name=$msg['Comment']['file_name'];
                            $cdate=isset($msg['Comment']['cdate'])?date('dS M, Y H:i a',strtotime($msg['Comment']['cdate'])):'';
                            if($file_name!='' && file_exists($uploadMessagePath . '/' . $file_name)){
                                $MessageFileLink=$this->webroot.'message_img/'.$file_name;
                            }
                    ?>
                        <div class="row">
                            <div class="col-sm-3 col-xs-4">
                                <p><?php echo isset($user_name)?$user_name:'';?></p>
                            </div>
                            <div class="col-sm-8 col-xs-7">
                                <p><?php echo isset($cdate)?$cdate:'';?> <br><?php echo isset($user_comments)?$user_comments:'';?></p>
                            </div>
                            <div class="col-sm-1 col-xs-1">
                                <?php 
                                if($MessageFileLink!=''){
                                    echo '<a href="'.$MessageFileLink.'" download ><i class="fa fa-download" aria-hidden="true"></i></a>';
                                }
                                ?> 
                            </div>
                        </div>
                    <?php
                        }
                    }else{
                        echo '<div class="row"><div class="col-sm-12 col-xs-12"><p style="text-align: center; font-weight: bold;">No record found.</p></div>';
                    }
                    ?>
                </div>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="form_type" value="message">
                <input type="hidden" name="data[Comment][order_id]" value="<?php echo isset($order_id)?$order_id:'';?>">
                <input type="hidden" name="data[Comment][order_details_id]" value="<?php echo isset($order_details_id)?$order_details_id:'';?>">
            <div class="col-lg-12" id="LeaveMessageDiv">
                <h4>Leave a message for the seller</h4>
                <div class="form-group">
                    <textarea class="form-control" rows="5" id="leave_message" name="data[Comment][comments]" required="required"></textarea>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                        <span class="btn btn-default btn-file">
                                <span>Upload a Photo</span>
                                <input name="data[Comment][file_name]" type="file"/>
                        </span>
                        <span class="fileinput-new">No file chosen</span>
                        </div>
                </div>
                <p>Please do not upload any personal information! You can upload one photo (max size 5MB) with your
message to the seller. The format of the photo should be in jpg, png, gif, or bmp.</p>
                <input type="submit" class="btn btn-primary" value="Send"/>
            </div>
        </form>
        </div>
    </div>
</section>


<div class="modal fade" id="RejectDispute" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"">
    <div class="modal-dialog dispute-request">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Reject Dispute</h4>
            </div>
            <form class="form-horizontal" method="post" action="">
            <input type="hidden" name="form_type" value="RejectDispute">
            <input type="hidden" name="dispute_id" value="<?php echo isset($dispute_id)?$dispute_id:'';?>">
            <input type="hidden" name="order_details_id" value="<?php echo isset($order_details_id)?$order_details_id:'';?>">
            <div class="modal-body">
                <h5 class="red-txt text-center" style="margin-bottom: 15px;">By rejecting the open dispute request meant to be you are not agree with the buyer reason to open dispute.</h5>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Details:</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="reject_details" rows="4"></textarea>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Reject</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="AcceptDispute" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog dispute-request">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Accept Dispute</h4>
            </div>
            <form class="form-horizontal" method="post" action="">
                <input type="hidden" name="form_type" value="AcceptDispute">
                <input type="hidden" name="dispute_id" value="<?php echo isset($dispute_id)?$dispute_id:'';?>">
                <input type="hidden" name="full_amount" value="<?php echo isset($payment_received)?$payment_received:'';?>">
                <input type="hidden" name="order_details_id" value="<?php echo isset($order_details_id)?$order_details_id:'';?>">
                <div class="modal-body">
                    <h5 class="red-txt text-center" style="margin-bottom: 15px;">By accepting the open dispute request meant to be you are agree with the
buyer reason to open dispute.</h5>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Refund Amount:</label>
                        <div class="col-sm-9">
                            <div class="radio">
                                <label> <input type="radio" name="refund_amount" class="RefundAmount" value="Full Refund" checked="checked"> $<?php echo isset($payment_received)?$payment_received:'';?> - Full Refund</label>
                            </div>
                            <div class="radio">
                                <label> <input type="radio" name="refund_amount" class="RefundAmount" value="Partial Refund"> Partial Refund</label>
                            </div>
                            <input type="number" min="1" class="form-control" id="EnterAmount" name="partial_amount" placeholder="Enter Amount" style="width: 60%; margin-top:15px; display: none;"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Details:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" rows="4" name="details" required="required"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Accept Dispute</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="disputeImageSlider" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog dispute-request">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Attach Dispute Images</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="slider5">
                        <?php
                        if(isset($dispute_images) && count($dispute_images)>0){
                            foreach($dispute_images as $dImgVal){
                                $imageName=$dImgVal['DisputeImage']['image_name'];
                                $uploadDisputeFolder = "dispute_images";
                                $uploadPath = WWW_ROOT . $uploadDisputeFolder;
                                if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
                                    $image = $this->webroot.'dispute_images/'.$imageName;
                            
                        ?>
                            <div class="col-md-4">
                                <div class="slide">
                                    <div class="feature_box" style="height: auto;">
                                        <div class="feature_box_img">
                                            <img src="<?php echo $image?>" alt="" />
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        <?php 
                                }
                            }
                        }?>
		    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<link href="<?php echo $this->webroot;?>css/jquery.bxslider.css" rel="stylesheet">
<script src="<?php echo $this->webroot;?>js/jquery.bxslider.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $('.slider5').bxSlider({
        slideWidth: 270,
        minSlides: 1,
        maxSlides: 2,
        moveSlides: 1,
        slideMargin: 10
    });
    
    $('.RefundAmount').click(function(){
        var RefundAmountVal=$(this).val();
        if(RefundAmountVal=='Partial Refund'){
            $('#EnterAmount').attr("required", "required");;
            $('#EnterAmount').show();
        }else{
            $('#EnterAmount').removeAttr('required');
            $('#EnterAmount').hide();
        }
    }); 
    $('.buyer_responce').click(function(){
        $('html,body').animate({
            scrollTop: $("#LeaveMessageDiv").offset().top
        }, 800);
        $('#leave_message').focus();
    });
    
    $('.show_attach_img').click(function(){
        $('.bx-viewport').css({height: 202+'px'});
        $('.slider5 .col-md-4').css({height: 270+'px',width: 270+'px'});
        $('#disputeImageSlider').modal();
    });
    
    
});  
</script>
<style>
   
</style>