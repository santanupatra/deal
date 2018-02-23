<section class="after_login">
    <div class="container">
        <div class="row">
            <?php echo($this->element('user_leftbar'));?>
            <div class="col-md-9">
                <div class="dash_middle_sec">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-10 brdrDashboard"><a href="<?php echo $this->webroot.'orders/seller_mail';?>">Messages (<?php echo isset($messages_list_count)?$messages_list_count:'0';?>)</a></div>
                        </div>
                        <div class="clearfix"></div><br/>
                        <div class="col-md-6">
                            <div class="col-md-10 brdrDashboard"><a href="<?php echo $this->webroot.'orders/seller_awaiting_shipment';?>">Awaiting Processing (<?php echo isset($seller_awaiting_processing)?$seller_awaiting_processing:'0';?>)</a></div>
                        </div>
                        <div class="clearfix"></div><br/>
                        <div class="col-md-6">
                            <div class="col-md-10 brdrDashboard"><a href="<?php echo $this->webroot.'orders/seller_awaiting_shipment';?>">Awaiting Shipment (<?php echo isset($seller_awaiting_shipment)?$seller_awaiting_shipment:'0';?>)</a></div>
                        </div>
                        <div class="clearfix"></div><br/>
                        <div class="col-md-6">
                            <div class="col-md-10 brdrDashboard"><a href="<?php echo $this->webroot.'orders/seller_disputes';?>">Disputes (<?php echo isset($seller_Disput)?$seller_Disput:'0';?>)</a></div>
                        </div>
                        <div class="clearfix"></div><br/>
                        <div class="col-md-6">
                            <div class="col-md-10 brdrDashboard"><a href="<?php echo $this->webroot.'orders/seller_completed';?>">Completed (<?php echo isset($finish_count)?$finish_count:'0';?>)</a></div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
.brdrDashboard{
	border:1px solid #dddddd;
	padding:5px;
	border-radius: 2px;
}
</style>

