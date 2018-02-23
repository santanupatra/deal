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
                <div class="orderbosx">
                        <h2>Seller Summery</h2>
                        <div class="order_des order_des_new">
                            <ul>							
                                <li><p>Shop Name:</p><span><?php echo $shop['Shop']['name']; ?></span></li>
                                <li><p>Created at :</p>	<span><?php echo date('d M Y H:i a',strtotime($shop['Shop']['created_at'])); ?></span></li>
                            </ul>
                        </div>
                </div>
                <div class="orderbosx">
                    <h2>Detail Seller Rating</h2>
                    <div class="order_descr-wrapr">
                        <ul class="DSR">
                            <?php
                                $shop_rating = $this->requestAction(array('controller' => 'products', 'action' => 'shop_related_rating/'.$shop['Shop']['id']));
                                if(!empty($shop_rating[0][0]['total_rating']))
                                    $rating = $shop_rating[0][0]['total_rating'];
                                else 
                                    $rating=0;

                                if(!empty($shop_rating[0][0]['accurate']))
                                    $accurate = $shop_rating[0][0]['accurate'];
                                else 
                                    $accurate=0;


                                if(!empty($shop_rating[0][0]['product_description']))
                                    $product_description = $shop_rating[0][0]['product_description'];
                                else 
                                    $product_description=0;


                                if(!empty($shop_rating[0][0]['satisfaction']))
                                    $satisfaction = $shop_rating[0][0]['satisfaction'];
                                else 
                                    $satisfaction=0;

                                if(!empty($shop_rating[0][0]['ship_item']))
                                    $ship_item = $shop_rating[0][0]['ship_item'];
                                else 
                                    $ship_item=0;


                                $rating_count = $shop_rating[0][0]['total_count'];
                                if($rating_count != 0){
                                    $rating = number_format(($rating/$rating_count),1,'.',',');
                                    $accurate = number_format(($accurate/$rating_count),1,'.',',');
                                    $product_description = number_format(($product_description/$rating_count),1,'.',',');
                                    $satisfaction = number_format(($satisfaction/$rating_count),1,'.',',');
                                    $ship_item = number_format(($ship_item/$rating_count),1,'.',',');
                                }
                                $accurate_percentage = number_format(($accurate/5)*100,2,'.',',');
                                $product_description_percentage = number_format(($product_description/5)*100,2,'.',',');
                                $satisfaction_percentage = number_format(($satisfaction/5)*100,2,'.',',');
                                $ship_item_percentage = number_format(($ship_item/5)*100,2,'.',',');
                                ?>
                                <!--<li>
                                    <p class="title">Accuracy :</p>
                                    <span class="rating-star" id="rateStarFirst"></span>
                                    <?php  echo '<script>
$(document).ready(function(){
$("#rateStarFirst").raty({score:'.$accurate.',readOnly:true, halfShow : true});
});</script>';
?>
                                    <span class="rating-txt"><?php echo $accurate; ?></span>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-success" style="width: <?php echo $accurate_percentage; ?>%;"><?php echo $accurate_percentage; ?>%</div>
                                    </div>
                                </li>-->
                                <li>
                                    <p class="title">Satisfaction :</p>
                                    <span class="rating-star" id="rateStarSecond"></span>
                                    <?php  echo '<script>
$(document).ready(function(){
$("#rateStarSecond").raty({score:'.$satisfaction.',readOnly:true, halfShow : true});
});</script>';
?>
                                    <span class="rating-txt"><?php echo $satisfaction; ?></span>
                                    <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: <?php echo $satisfaction_percentage; ?>%;"><?php echo $satisfaction_percentage; ?>%</div>
                                    </div>
                                </li>
                                <li>
                                    <p class="title">Product as Described :</p>
                                    <span class="rating-star" id="rateStarThird"></span>
                                    <?php  echo '<script>
$(document).ready(function(){
$("#rateStarThird").raty({score:'.$product_description.',readOnly:true, halfShow : true});
});</script>';
?>
                                    <span class="rating-txt"><?php echo $product_description; ?></span>
                                    <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: <?php echo $product_description_percentage; ?>%;"><?php echo $product_description_percentage; ?>%</div>
                                    </div>
                                </li>
                                <li>
                                    <p class="title">Shipment & Delivery :</p>
                                    <span class="rating-star" id="rateStarFourth"></span>
                                    <?php  echo '<script>
$(document).ready(function(){
$("#rateStarFourth").raty({score:'.$ship_item.',readOnly:true, halfShow : true});
});</script>';
?>
                                    <span class="rating-txt"><?php echo $ship_item; ?></span>
                                    <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: <?php echo $ship_item_percentage; ?>%;"><?php echo $ship_item_percentage; ?>%</div>
                                    </div>
                                </li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="feedback_tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#frs" aria-controls="frs" role="tab" data-toggle="tab">Feedback Received as Seller</a></li>
                            <!--<li role="presentation"><a href="#flb" aria-controls="flb" role="tab" data-toggle="tab">Feedback Left for Buyers</a></li>-->
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="frs">
                                <!--<p>Viewing 1 - 04</p>-->
                                <?php
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
                                        <div class="rating">
                                            <p id="raterStarfeedback_<?php echo $feedback_key;?>"></p>
                                            <?php  echo '<script>
$(document).ready(function(){
$("#raterStarfeedback_'.$feedback_key.'").raty({score:'.$feedback_val['Rating']['rating'].',readOnly:true, halfShow : true});
});</script>';
?>
                                            <b><?php echo date('d M Y H i a',strtotime($feedback_val['Rating']['date_time'])); ?></b>
                                        </div>
                                        <div class="feedback-txt">
                                            <p><?php echo $feedback_val['Rating']['review'] ?></p>
                                        </div>
                                    </li>
                                </ul>
                        <?php }

                            echo '<div class="paging">';
                            echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
                            echo $this->Paginator->numbers(array('separator' => ''));
                            echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
                            echo '</div>';
                        }else{
                            echo '<div class="col-md-12"><b>No Review Found</b></div>';
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
