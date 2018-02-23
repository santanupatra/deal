<?php ?>

<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left"><?php echo __('Edit Shop'); ?></div>
			</div>
			<div class="shops form">
			<?php echo $this->Form->create('Shop',array('enctype'=>'multipart/form-data')); 
                        echo $this->Form->input('id');
                        ?>
                            
				<fieldset>
				
				 <div class="input select required">
					<label for="ProductUserId">User Name</label>
                                        <select name="data[Shop][user_id]" required="required">
                                            <option value="">--select--</option>
                                            <?php foreach($vendorlist as $dt){ ?>
                                            
                                            <option value="<?php echo $dt['User']['id'];?>" <?php if($this->request->data['Shop']['user_id']==$dt['User']['id']){ echo 'selected';}?>><?php echo $dt['User']['first_name'].' '.$dt['User']['last_name']?></option>
                                            
                                            <?php } ?>
                                        </select>
					
					
				</div>
					<?php
					
					echo $this->Form->input('name',array('required'=>'required','label'=>'Shop Name'));
					echo $this->Form->input('description',array('required'=>'required'));
					echo $this->Form->input('hid_img',array('type'=>'hidden','value'=>$this->request->data['Shop']['logo']));
                                       echo $this->Form->input('logo',array('type'=>'file')); 
					
				?>
				   
				
				<font color="red">Please uploade image of .jpg, .jpeg, .png or .gif format.</font><br>  
				<?php
				$uploadPath= Configure::read('UPLOAD_SHOP_LOGO_PATH');
				$imageName = $this->request->data['Shop']['logo'];
				if(file_exists($uploadPath . '/' . $imageName) && $imageName!=''){
					echo($this->Html->image('/shop_images/'.$imageName, array('alt' => 'Shop Image', 'height' => '150', 'width' => '150')));
				} 
				else {
						echo($this->Html->image('/shop_images/default.png', array('alt' => 'Shop Image')));
					}
				?>	
					
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