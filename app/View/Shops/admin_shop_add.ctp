<?php ?>

<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Add Shop'); ?></div>
			</div>
			<div class="shops form">
			<?php echo $this->Form->create('Shop',array('enctype'=>'multipart/form-data')); ?>
                            
				<fieldset>
				 <div class="input select required">
					<label for="ProductUserId">User Name</label>
                                        <select name="data[Shop][user_id]" required="required">
                                            <option value="">--select--</option>
                                            <?php foreach($vendorlist as $dt){ ?>
                                            
                                            <option value="<?php echo $dt['User']['id'];?>"><?php echo $dt['User']['first_name'].' '.$dt['User']['last_name']?></option>
                                            
                                            <?php } ?>
                                        </select>
					
					
				</div> 

				<?php
					
					echo $this->Form->input('name',array('required'=>'required','label'=>'Shop Name'));
					echo $this->Form->input('description',array('required'=>'required'));
					
                                       echo $this->Form->input('logo',array('type'=>'file')); 
					
				?>
				   
				
				<font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>  
					<?php
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


        