<?php ?>

<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Vendor'); ?></div>
			</div>
			<div class="shops form">
			<?php echo $this->Form->create('User',array('enctype'=>'multipart/form-data')); ?>
				<fieldset>
				
				<input type="hidden" id="ShopUserId" maxlength="255" required="required" name="data[User][id]" value="<?php echo $this->request->data['User']['id']?>">
					<?php
					
					echo $this->Form->input('first_name',array('required'=>'required'));
					echo $this->Form->input('last_name',array('required'=>'required'));
					echo $this->Form->input('email',array('required'=>'required','type'=>'email'));
                                         echo $this->Form->input('paypal_business_email',array('type'=>'email','label'=>'Paypal business email'));
					
					//echo $this->Form->input('company_name',array('required'=>'required','label'=>'Legit Business Name'));
					
					echo $this->Form->input('mobile_number');
					
				?>
				   
				

					
					


				<?php
					echo $this->Form->input('id');
					
					
				?>
				
				
				
					
					
					
				<?php
				//echo $this->Form->input('percentage_id', array('type'=>'select', 'label'=>'Percentage ', 'options'=>$percentage_value,'required'=>'required'));
                                
                                //echo $this->Form->input('dba',array('label'=>'DBA','value'=>$this->request->data['User']['dba']));
                                //echo $this->Form->input('ein',array('label'=>'EIN','value'=>$this->request->data['User']['ein']));
					
					echo $this->Form->input('is_active');
                                       
				?>
                                
                                <input type="checkbox"  name="data[User][is_loyalty]" value='1' <?php if($this->request->data['User']['is_loyalty']==1){echo "checked";}?>> Loyalty
                                
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
		     // alert(JSON.stringify(place));
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

  <?php echo $this->Html->script('ckeditor/ckeditor');?>
 <script type="text/javascript">
      CKEDITOR.config.toolbar = 'Custom_medium';
      CKEDITOR.config.height = '200';
      CKEDITOR.replace('PagePDesc');
  </script>       