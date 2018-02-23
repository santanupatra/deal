

    
    <!--  my account  -->
    
    <section class="pt-5 pb-5">
          <div class="container">
              <div class="row">
                  <?php echo ($this->element('vendor_side_menu'));?>
                  <div class="col-lg-9 col-12">
                      <div class="right-side p-3">
                          <h2 class="text-pink">Add New Product</h2>
                          <div class="row">
                              <div class="col-lg-7 col-12">
                                  <form class="form-area" method="post" action="<?php echo $this->webroot; ?>products/add" id="frmEdit" enctype="multipart/form-data">
                                      
                                      
                                      <input type="hidden" name="data[Product][user_id]" value="<?php echo $user['User']['id'];?>">
                                      
                                      <div class="form-group">
                                          <label>Product Name</label>
                                          <input type="text" class="form-control" required="" name="data[Product][name]"  placeholder="Product name here">
                                      </div>
                                      
                                      <div class="form-group">
                                          <label>SKU</label>
                                          <input type="text" class="form-control"  name="data[Product][product_code]" required=""  placeholder="Product code here">
                                      </div>
                                      
                                     <div class="form-group">
                                          <label>Quantity</label>
                                          <input type="number" class="form-control" required="" name="data[Product][quantity]" placeholder="Product quantity here">
                                      </div> 
                                      
                                    <div class="form-group">
                                          <label>Categories</label>
                                          <select class="form-control" id="ShopCategories" required="required" name="data[Product][category_id]">
							 <option value="">Select Category--</option>
							 <?php 
							  if(isset($categories) && !empty($categories))
							  {	
								foreach($categories as $category)

								{ ?>
									   
											 <?php 
											 $subcats = $this->requestAction(array('controller' => 'categories', 'action' => 'getsubcat/'.$category['Category']['id']));
												    if(!empty($subcats))
												    {   
												    	?>
												    	<optgroup label="<?php echo $category['Category']['name']?>">
												    	<?php
														  foreach($subcats as $subcat)
														  {
												    ?>


												     <?php 
											 $subsubcats = $this->requestAction(array('controller' => 'categories', 'action' => 'getsubcat/'.$subcat['Category']['id']));
												    if(!empty($subsubcats))
												    {   
												    	?>
												    	<optgroup label="<?php echo $subcat['Category']['name']?>" style="margin-left: 12px;">
												    	<?php
														  foreach($subsubcats as $subcat2)
														  {
												    ?>
										  <option value="<?php echo $subcat2['Category']['id'];?>" style="margin-left: 20px;"><?php echo $subcat2['Category']['name'];?></value>

											 <?php	}
											 ?>
											 </optgroup>
											 <?php
												    }
												    else
												    {
												    	?>
												   <option value="<?php echo $subcat['Category']['id'];?>"><?php echo $subcat['Category']['name'];?></value>
												    	<?php
												    }
											 ?>

											 <?php	}
											 ?>
											 </optgroup>
											 <?php
												    }
												    else
												    {
												    	?>
												    	 <option value="<?php echo $category['Category']['id'];?>"><?php echo $category['Category']['name'];?></value>
												    	<?php
												    }
											 ?>
									   	
							 <?php	}
							 }
							 ?>
						</select>
                                      </div> 
                                      
                                      
                                      <div class="form-group">
                                          <label>Price</label>
                                          <input type="text" class="form-control" name="data[Product][price_lot]" placeholder="Product price here">
                                      </div>
                                      
                                      
<!--                                  <div id="phone">
                                      <div class='form-group'>
                                        <input type="text" class="form-control" required name="data[Product][size][]" placeholder="Size here">
                                      </div>
                                  </div>

                                    <div class="RegSpRight form-group">
                        <button class="pl">Add Variation</button>&nbsp;<button class="mi">Remove</button>
                                       
                                    </div>
                                      
                                  <div class="form-group">
                                    
                                  <input type="color" name="data[Product][colour]" value="#ffffff">
                                          
                                  </div>    -->
                                      



                                  <div class="form-group">
                                      <a data-target="#variation_add_modal" href="Javascript: void(0);" data-toggle="modal"><button class="pl btn btn-primary btnsearch">Add Variation</button></a>

                                  </div>




                                  <div id="phone">
                                      
                                  </div>
                                    

                                      <div class="form-group">
                                          <label>Material(optional)</label>
                                          <input type="text" class="form-control" name="data[Product][material]" placeholder="Product material here">
                                      </div>
                                      
                                      <div class="form-group">
                                      	<label>Shipping Time</label>
                                      	<div class="shippingTable">
                       <div class="form-check">
                           
         <?php foreach($ships as $ship){?>                  
	<div class="form-check-label inputTypeRadio">
            <input type="checkbox" required="" id="test<?php echo $ship['ShippingDay']['id'];?>" name="data[Product][shipping_time][]" value="<?php echo $ship['ShippingDay']['id']?>">
<label for="test<?php echo $ship['ShippingDay']['id'];?>">USPS $<?php echo $ship['ShippingDay']['ship_charge']?> <small class="fixedCosts"><?php echo $ship['ShippingDay']['ship_name']?></small> </label>				
<p><?php echo $ship['ShippingDay']['ship_day']?> business day processing time, from United States</p>
	</div>
           <?php } ?>                

	</div>
                </div>
                    </div>

                                      
                                      <!--For image upload-->

<div>
                  <div class="company-images">
                    <!--<img src="<?php echo $this->webroot;?>images/company-images-blank.png" alt="">--> 
                     
<input type="hidden" name="data[Product][product_image_name]" id="product_image_id" value="">
                       <div class="fileUpload btn btn-primary">
                          <span>Add Image</span>
                          <input type="file" required="" id="multiFiles" name="files[]" multiple="multiple" class="upload"/>
                      </div>

                    <span id="status" ></span> 
                   </div>
                  <div class="manage-photo" id="product_images" style="overflow:scroll; height:450px;width:100%;">


<ul id="sortable" class="uisortable">
</ul>

                    
                  </div>
                </div>




<!--                        <div class="from-group">
                           <label>Upload Image </label> 
                           <input type="file[]" multiple="multiple" name="" > 
                           
                        </div>-->
                                       



                                      
<!--                                      <div class="form-group">
                                     <?php //echo $this->Form->input('currency',array('type'=>'select','required'=>'required','label'=>'Cyrrency','options'=>$currency_value,'class'=>'form-control')); ?>
                                      </div>-->
                                      



                                      <div class="form-group">
                                          <label>Item Weight</label>
                                          <div class="input-group">
                                          <input type="text" class="form-control" name="data[Product][package_weight]"  placeholder="item weight here">	
                                          <span class="input-group-addon">Lbs</span>  
                                          </div>
                                      </div>    



<!--                                     <div class="form-group">
                                          <label>Item Size (When packed)</label>
                                          <div class="row">
                                          <div class="form-group col-sm-4">
                                          <label>Length</label>
                                          <div class="input-group">
                                          <input type="text" class="form-control" name="data[Product][package_size1]"  placeholder="Length">
                                         <span class="input-group-addon">In</span> 
                                         </div>
                                      </div>
                                        <div class="form-group col-sm-4">
                                          <label>Width</label>
                                          <div class="input-group">
                                          <input type="text" class="form-control" name="data[Product][package_size2]"  placeholder="Width">           
                                          <span class="input-group-addon">In</span>
                                          </div>
                                      </div>
                                          <div class="form-group col-sm-4">
                                          <label>Height</label>
                                          <div class="input-group">
                                          <input type="text" class="form-control" name="data[Product][package_size3]"  placeholder="Height">		  <span class="input-group-addon">In</span>
                                          
                                          </div>
                                      </div>
                                          </div>
                                      </div>-->
                                      
                                      <div class="form-group">
                                          <label>Description</label>
                                          <textarea class="form-control ckeditor" name="data[Product][item_description]"  placeholder="Description here"></textarea>
                                      </div>

                                      <?php 
                                      
                                      echo $this->Form->input('status',array('required'=>'required','options'=>$status,'empty'=>'Select','class'=>'form-control','name'=>'data[Product][status]'));
                                      ?>
<br>

                                      <div class="form-group">
                                          <button type="submit" class="btn btn-lg btn-primary">Save Product</button>
                                      </div>
                                  </form>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </section>

    

    <!--   footer   -->

    
    <!--Variation Modal-->
    
    <div class="modal fade" id="variation_add_modal" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Variation</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action='#' accept-charset="utf-8" onsubmit="return false">
                    <div class="row" id="phone">
                    <div class="form-group col-sm-4" >
                        <label>Color</label>
                        <select name="data[ProductVariation][color_id]"  id='color' class="form-control operations-supplier">
                            <option value="">--select--</option>
                            <?php foreach($colors as $c){?>
                            
                            <option value="<?php echo $c['Color']['color_name'];?>" data-id="<?php echo $c['Color']['id'];?>"><?php echo $c['Color']['color_name'];?></option>
                            
                            <?php } ?>
                                
                        </select>
                    </div>
                        
                        <div class="form-group col-sm-4">
                            <label>Size</label>
                            <input type="text" class="form-control" id="size" name="data[ProductVariation][size]"/>
                        </div>
                   
                    <div class="form-group col-sm-4">
                        <label for="full_name">Price</label>
                        <input type="text" class="form-control" id="price" name="data[ProductVariation][price]" required="required" />
                    </div>
            </div>
                    
                    <div class="RegSpRight form-group">
                        <button class="pl btn btn-primary btnsearch" onclick='addvariation()'>Add</button>
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
</div>
    
    <!--Variation Modal end-->
    
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
   
    
   
     <?php echo $this->Html->script('ckeditor/ckeditor');?>
 <script type="text/javascript">
       CKEDITOR.config.toolbar = 'MyToolbar';
    CKEDITOR.config.toolbar_MyToolbar = 
      [
         ['Newplugin', 'Preview'],
         ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Scayt'],
         ['Undo', 'Redo', '-', 'Find', 'Replace', '-', 'SelectAll', 'RemoveFormat']
      ];
      CKEDITOR.config.height = '200';
      CKEDITOR.replace('PagePDesc');
  </script> 
  
 
<!--    <script type="text/javascript">
    $(function() {
        $('.pl').click(function(e) {
            e.preventDefault();
            $('#phone').append('<div class="form-group"><input type="text" class="form-control" required name="data[Product][size][]" placeholder="Size here"></div>');
        });
        $('.mi').click(function (e) {
            e.preventDefault();
            if ($('#phone input').length > 1) {
                $('#phone').children().last().remove();
            }
        });
    });
    
    </script> -->
    
    
    
    
  
<script>
        $(document).ready(function(){
          $("#sortable").sortable({
              stop : function(event, ui){
                  $.ajax({
                    method: "POST",
                    url: base_url+"products/order_image",
                    data: { ids : $(this).sortable('toArray')}
                  })
                .done(function( data ) {
                 var obj = jQuery.parseJSON( data );
                  
                });
                //alert($(this).sortable('toArray'));
              }
          });
        $("#sortable").disableSelection();
      });//ready
      
      
      
    function addvariation(){
     
    var color= $('#color').val();
    var color_id= $('select.operations-supplier').find(':selected').data('id');
    var size = $('#size').val();
    var price= $('#price').val();
    //alert(color_id);
    if (color != '' && price != '' && size == '') {
            $('#phone').append(' <div class="row"><input type="hidden" name="data[ProductVariation][color_id][]" value=' + color_id + '><div class="form-group col-sm-6"><input type="text" class="form-control"  value=' + color + '  placeholder="color here"></div><div class="form-group col-sm-6"><input type="text" class="form-control" value=' + price + ' name="data[ProductVariation][price][]" placeholder="Price here"></div></div>');
        } else if ( size != '' && price != '' && color == '') {
            $('#phone').append(' <div class="row"><div class="form-group col-sm-6"><input type="text" class="form-control" value=' + size + ' name="data[ProductVariation][size][]" placeholder="Size here"></div><div class="form-group col-sm-6"><input type="text" class="form-control" value=' + price + ' name="data[ProductVariation][price][]" placeholder="Price here"></div></div>');
        }else if(size != '' && price != '' && color != ''){
            $('#phone').append('<div class="row"><input type="hidden" name="data[ProductVariation][color_id][]" value=' + color_id + '><div class="form-group col-sm-4"><input type="text" class="form-control"  value=' + color + '  placeholder="color here"></div><div class="form-group col-sm-4"><input type="text" class="form-control" value=' + size + ' name="data[ProductVariation][size][]" placeholder="Size here"></div><div class="form-group col-sm-4"><input type="text" class="form-control" value=' + price + ' name="data[ProductVariation][price][]" placeholder="Price here"></div></div>')
            
            }

    
    $('.mi').click(function (e) {
            e.preventDefault();
            if ($('#phone input').length > 0) {
                $('#phone').children().last().remove();
            }
        });
    
    }  
      
      
      
      
      
      
      
  </script>  
  
<script type="text/javascript">
    $( document ).ready( function () {

    $( "#frmEdit" ).validate( {
        rules: {
          'data[User][first_name]': "required",
          'data[User][last_name]': "required",
          'data[User][email]': {
            required: true           
          },
          
          'data[User][mobile_number]': "required"
          
        },
        messages: {
          'data[User][first_name]': "Please enter your firstname",
          'data[User][last_name]': "Please enter your lastname",
          'data[User][email]': "Please enter a valid email address", 
          
          'data[User][mobile_number]': "Please enter phone number"
          
        },
        
      } );
      
      
       $('#multiFiles').on('change',function(){
           //alert('ok');
               var image_url = '<?php  echo Configure::read('SITE_URL') ?>';
               //alert(image_url);
              //alert($('#product_id').val());
                    var form_data = new FormData();
                    var ins = document.getElementById('multiFiles').files.length;
                   // alert(ins);
                 //alert(JSON.stringify(document.getElementById('multiFiles')));
                    for (var x = 0; x < ins; x++) {
                        form_data.append("files[]", document.getElementById('multiFiles').files[x]);
                        //alert('ok');
                       // alert(JSON.stringify(document.getElementById('multiFiles').files[x]));
                    }
                    console.log(form_data);
                    $.ajax({
                        url: '<?php echo $this->webroot; ?>products/upload_photo_add', // point to server-side PHP script 
                        dataType: 'text', // what to expect back from the PHP script
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'post',
                        success: function (response) {
                          console.log(response);
                             var obj = jQuery.parseJSON( response );
                            
                             if(obj.Ack == 1){
                                 
                            //alert('ok');
                              $('#product_image_id').val(obj.image_name);
                              for(var i = 0; i < obj.data.length; i++){
                                  file_path = image_url+'product_images/'+obj.data[i].filename;
                                $('<li id="'+obj.data[i].last_id+'"></li>').appendTo('#sortable').html('<div class="media" id="image_'+obj.data[i].last_id+'"><div class="media-left"><a href="#"><img style="width: 100px; height: 100px" src="'+file_path+'" alt="" /></a></div><div class="media-body media-middle"><h4>'+obj.data[i].filename+'</h4></div><div class="media-body media-middle"></div></div></div></li>');
                              }
                             }
                        },
                        error: function (response) {
                            $('#msg').html(response); // display error response from the PHP script
                        }
                    });
                });
      
      
      
      
      
    } ); 
    
     </script>   
     <script type="text/javascript" src="<?php echo ($this->webroot);?>js/ajaxupload.3.5.js"></script>