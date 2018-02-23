<?php 
?>
<script src="<?php echo $this->webroot;?>js/jquery.raty-fa.js"></script>
<style>
button a {
color: #fff !important;
text-decoration: none;
}button a:hover, a:focus {
color: #fff;
text-decoration: underline;
}
</style>
<section class="featured_list">
    <div class="container">
        <div class="row">
            <?php echo($this->element('user_leftbar'));?>
            <div class="col-md-9">
                
              <!--  <div class="orderbosx">
                    <h2>Detail Buyer Feedback</h2>
                    <div class="order_descr-wrapr">
                      
                    </div>
                </div>-->
                <div class="clearfix"></div>
                <div class="feedback_tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#frs" aria-controls="frs" role="tab" data-toggle="tab">Feedback Received as buyer</a></li>
                            
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="frs">
                              
                                <?php //pr($feedback);exit;
                                if(!empty($feedback)){
                                    foreach($feedback as $feedback_key=>$feedback_val){
                                        $PrdID=$feedback_val['Product']['id'];
                                        $prd_img=$this->requestAction(array('controller' => 'products', 'action' => 'get_product_img', $PrdID, 'admin'=>false, 'prefix' => ''));

                                        if(!empty($prd_img)){
                                            $uploadFolder = "product_images";
                                            $uploadPath = WWW_ROOT . $uploadFolder;
                                            $imageName =$prd_img[0]['ProductImage']['name'];
                                            if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
                                                $image = $this->webroot.'product_images/'.$imageName;
                                            }else{ 
                                                $image = $this->webroot.'product_images/default.png';
                                            } 
                                        }else{
                                            $image = $this->webroot.'product_images/default.png';
                                        }
   
                                ?>
                                <ul class="fedbk">
                                    <li>
                                        <div class="image-holder"><img src="<?php echo $image;?>" alt=""></div>
                                        <div class="free-ship">
                                                <p><?php echo $feedback_val['Product']['name']; ?></p>
                                        </div>
                                       <div class="order_des" style="border-style: none; padding: 15px 15px 0px;">
                                           <ul>
                                               <li style="border-bottom: medium none;"><p>Seller Name:</p><span><?php echo $feedback_val['User']['name']; ?></span></li>							
                                               <li style="border-bottom: medium none;"><p>Shop Name:</p><span><?php echo $feedback_val['Shop']['name']; ?></span></li>
                                           </ul>
                                       </div>
                                        
                                        <div class="rating">
                                            <p id="raterStarfeedback_<?php echo $feedback_key;?>"></p>
                                            <?php  echo '<script>
$(document).ready(function(){
$("#raterStarfeedback_'.$feedback_key.'").raty({score:'.$feedback_val['BuyerFeedback']['rate'].',readOnly:true, halfShow : true});
});</script>';
?>
                                            <b><?php echo date('d M Y H i a',strtotime($feedback_val['BuyerFeedback']['cdate'])); ?></b>
                                        </div>
                                        <div class="feedback-txt">
                                            <p><?php echo $feedback_val['BuyerFeedback']['comment'] ?></p>
                                        </div>
                                    </li>
                                    <!--<div class="orderbosx">
                                                <h2>Seller Summery</h2>
                                                <div class="order_des order_des_new">
                                                    <ul>
                                                        <li><p>Seller Name:</p><span><?php echo $feedback_val['User']['name']; ?></span></li>							
                                                        <li><p>Shop Name:</p><span><?php echo $feedback_val['Shop']['name']; ?></span></li>
                                                    </ul>
                                                </div>
                                        </div>-->
                                </ul>
                                
                        <?php }

                         
                        }else{
                            echo '<div class="col-md-12"><b>No feedback Found</b></div>';
                        } ?>
                        <div class="clearfix"></div>
                    </div>
                    <!--<div role="tabpanel" class="tab-pane fade" id="flb">bb</div>-->
                </div>
            </div>
            </div>

        </div>
    </div>
</section>
