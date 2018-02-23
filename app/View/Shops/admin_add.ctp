<?php ?>

<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Add Vendor'); ?></div>
			</div>
			<div class="shops form">
			<?php echo $this->Form->create('User',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
				<!-- <div class="input select required">
					<label for="ProductUserId">User Name</label>
					<input type="text" id="UserName" maxlength="255" required="required" name="UserName">
					<input type="hidden" id="ShopUserId" maxlength="255" required="required" name="data[Shop][user_id]">
				</div> -->

				<?php
					
					echo $this->Form->input('first_name',array('required'=>'required'));
					echo $this->Form->input('last_name',array('required'=>'required'));
					echo $this->Form->input('email',array('required'=>'required','type'=>'email'));
                                        echo $this->Form->input('paypal_business_email',array('required'=>'required','type'=>'email','label'=>'Paypal business email'));
					
					//echo $this->Form->input('company_name',array('required'=>'required','label'=>'Legit Business Name'));
					echo $this->Form->input('password',array('required'=>'required'));
					echo $this->Form->input('mobile_number');
					
                                        
                                        
                                        //echo $this->Form->input('dba',array('required'=>'required','label'=>'DBA'));
                                        //echo $this->Form->input('ein',array('required'=>'required','label'=>'EIN'));
                                        
                                        
				?>
				   
				  
					
					
					<?php


					//echo $this->Form->input('percentage_id', array('type'=>'select', 'label'=>'Percentage ', 'options'=>$percentage_value,'required'=>'required'));
                                      
					echo $this->Form->input('is_active');
                                        
				?>
				</fieldset>
			<?php echo $this->Form->end(__('Submit')); ?>
			</div>
		</div>
	</div>
</div>
<script>     
      var placeSearch, autocomplete;   

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});   

             google.maps.event.addListener(autocomplete, 'place_changed', function() {
		      var place = autocomplete.getPlace();
		      var lat = place.geometry.location.lat();
		      var lng = place.geometry.location.lng();
		      $('#lat').val(lat);
            $('#long').val(lng);
		    
		    });     
      }

     
      function geolocate() { 
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) { 
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }
    </script>

 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQ9hl89w8uiMND1-cnmkTVnqGh37TDvvk&libraries=places&callback=initAutocomplete"
        async defer></script>


        