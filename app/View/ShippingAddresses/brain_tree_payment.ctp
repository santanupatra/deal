<section class="creditCardArea">
   	  <div class="container">
   	  	  <div class="row my-5">
   	  	  	 <div class="col-6 mx-auto">
   	  	  	 	<div class="creditPart">
                                    
                                  	<h2 class="text-center">Credit Card</h2>
                                        
                                        <form method="post" action="<?php echo $this->webroot; ?>shipping_addresses/creditcardpay">    
   	  	  	 		<div class="form-group">
    					<label for="exampleInputEmail1">Card Owner</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input type="text" name="fname" class="form-control" placeholder="First name">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" name="lname" class="form-control" placeholder="Last name">
                                            </div>
                                        </div>
  					</div>
   	  	  	 		<div class="form-group">
    					<label for="exampleInputEmail1">Card Number</label>
                                        <input type="text" class="form-control" name="card_no" placeholder="Card number">
  					</div>
  					<div class="row">
  					<div class="col-lg-8">
  						<div class="form-group" id="expiration-date">
                        <label>Expiration Date</label>
                        <div class="row">
                        <div class="col-lg-6">
                        <select class="form-control" name="exp_month">
                            <option value="01">January</option>
                            <option value="02">February </option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
						</div>
						<div class="col-lg-6">
                        <select class="form-control" name="exp_year">
                            <option value="2016"> 2016</option>
                            <option value="2017"> 2017</option>
                            <option value="2018"> 2018</option>
                            <option value="2019"> 2019</option>
                            <option value="2020"> 2020</option>
                            <option value="2021"> 2021</option>
                        </select>
                        </div>
                        </div>
                    </div>
  					</div>
  					<div class="col-lg-4">
  						<div class="form-group">
    					<label for="exampleInputEmail1">CVV</label>
    					<input type="text" class="form-control">
  					</div>
  					</div>
                    </div>
                    
                    <div class="form-group">
    					<label for="exampleInputEmail1">Card Type</label>
    					<select class="form-control" name="type">
                            <option value="visa">Visa</option>
                            <option value="mastercard">Mastercard</option>
                            <option value="maestro">Maestro</option>
                            
                        </select>
  					</div>
  					<div class="text-center">
  						<button type="submit" value="submit" class="btn btn-primary">Submit</button>
  					</div>
                                    </form>
   	  	  	 	</div>
   	  	  	 </div>
   	  	  </div>
   	  </div>
   </section>