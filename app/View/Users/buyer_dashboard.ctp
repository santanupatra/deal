<section class="after_login">
    <div class="container">
        <div class="row">
            <?php echo($this->element('user_leftbar'));?>
            <div class="col-md-9">
                <div class="dash_middle_sec">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-10 brdrDashboard"><a href="<?php echo $this->webroot.'orders/buyer_message';?>">Messages (<?php echo isset($messages_list_count)?$messages_list_count:'0';?>)</a></div>
                        </div>
                        <div class="clearfix"></div><br/>
                        <div class="col-md-6">
                            <div class="col-md-10 brdrDashboard"><a href="<?php echo $this->webroot.'orders/awaiting_payment';?>">Awaiting Payment (<?php echo isset($awaiting_payment)?$awaiting_payment:'0';?>)</a></div>
                        </div>
                        <div class="clearfix"></div><br/>
                        <div class="col-md-6">
                            <div class="col-md-10 brdrDashboard"><a href="<?php echo $this->webroot.'orders/awaiting_shipment';?>">Awaiting Shipment (<?php echo isset($awaiting_shipment)?$awaiting_shipment:'0';?>)</a></div>
                        </div>
                        <div class="clearfix"></div><br/>
                        <div class="col-md-6">
                            <div class="col-md-10 brdrDashboard"><a href="<?php echo $this->webroot.'orders/awaiting_delivery';?>">Awaiting Delivery (<?php echo isset($awaiting_delivery)?$awaiting_delivery:'0';?>)</a></div>
                        </div>
                        <div class="clearfix"></div><br/>
                        <div class="col-md-6">
                            <div class="col-md-10 brdrDashboard"><a href="<?php echo $this->webroot.'orders/buyer_disputes';?>">Disputes (<?php echo isset($Disput)?$Disput:'0';?>)</a></div>
                        </div>
                        <div class="clearfix"></div><br/>
                        <div class="col-md-6">
                            <div class="col-md-10 brdrDashboard"><a href="<?php echo $this->webroot.'orders/purchased_history';?>">Purchase History (<?php echo isset($finish_count)?$finish_count:'0';?>)</a></div>
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

