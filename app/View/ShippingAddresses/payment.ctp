


    <!--   checkout  -->

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-5 col-sign-up">
                    <!--<h2>Billing Details</h2>-->
                    <div class="p-3 bg-light mb-3">
                        <h5><?php  echo $ShippingAdd_data['ShippingAddress']['full_name']?></h5>
                        <p><?php  echo $ShippingAdd_data['ShippingAddress']['street'].','.$ShippingAdd_data['ShippingAddress']['apartment'].','.$ShippingAdd_data['ShippingAddress']['city'].','.$ShippingAdd_data['ShippingAddress']['state'].','.$ShippingAdd_data['ShippingAddress']['zip_code'].','.$ShippingAdd_data['Country']['name'];?></p>
                    </div>
                    <h5 class="text-grey font-weight-bold">Choose Payment Method</h5>
<!--                    <form class="mt-4">

                        <div class="form-group">
                            <label><input type="radio" name="payment"> Paypal</label>
                        </div>
                        <div class="form-group">
                            <label><input type="radio" name="payment"> Brain tree Paypal</label>
                        </div>
                        <div class="form-group">
                            <label><input type="radio" name="payment"> Cash on delivery</label>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block">Next</button>
                        </div>
                    </form>-->
                    <?php //pr($cart);?>
                     <form class="mt-4" method="post">

                         <input type="hidden" > 
                        <div class="form-group">
                            <label><input type="radio" name="data[ShipingAddress][payment]" value="paypal"> Paypal</label>
                        </div>
                        <div class="form-group">
                            <label><input type="radio" name="data[ShipingAddress][payment]" value="bpaypal"> Brain tree Paypal</label>
                        </div>
                        <div class="form-group">
                            <label><input type="radio" name="data[ShipingAddress][payment]" required="" value="cash"> Cash on delivery</label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
