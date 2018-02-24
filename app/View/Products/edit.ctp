<?php
$pass_data = $this->params['pass'];

if (count($pass_data) > 0) {
    $pass_data_str = isset($pass_data[0]) ? $pass_data[0] : '';
} else {
    $pass_data_str = '';
}
?>


<!--  my account  -->

<section class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            <?php echo ($this->element('vendor_side_menu')); ?>
            <div class="col-lg-9 col-12">
                <div class="right-side p-3">
                    <h2 class="text-pink">Edit Deal</h2>
                    <div class="row">
                        <div class="col-lg-7 col-12">
                            <form class="form-area" method="post" action="<?php echo $this->webroot; ?>products/edit/<?= $this->request->data['Product']['id'] ?>" id="frmEdit">


                                <input type="hidden" name="data[Product][user_id]" value="<?php echo $user['User']['id']; ?>">
                                <input type="hidden" name="data[Product][id]" value="<?php echo $this->request->data['Product']['id']; ?>">

                                <div class="form-group">
                                    <label>Deal Name</label>
                                    <input type="text" class="form-control" required="" name="data[Product][name]" value="<?php echo $this->request->data['Product']['name'] ?>"  placeholder="Deal name here">
                                </div>

                     <div class="form-group">
                        <label>Shop</label>
                        
                        <select name="data[Product][shop_id]" class="form-control" required="required">
                            <option value="">--select--</option>
                            <?php foreach($shops as $shop){ ?>
                            <option value="<?php echo $shop['Shop']['id']?>" <?php if ($shop['Shop']['id'] == $this->request->data['Product']['shop_id']) { echo "selected";} ?>><?php echo $shop['Shop']['name']?></option>
                            <?php } ?>
                        </select>
                        
                    </div>

                                

                                <div class="form-group">
                                    <label>Categories</label>
                                    <select class="form-control" id="ShopCategories" required="required" name="data[Product][category_id]">
                                        <option value="">Select Category--</option>
                                        <?php foreach ($categories as $c1 => $category) {  ?>

                                                    <option value="<?php echo $category['Category']['id']; ?>" <?php if ($category['Category']['id'] == $this->request->data['Product']['category_id']) { echo "selected";} ?>><?php echo $category['Category']['name']; ?></option>
                                                  
                                                <?php }  ?>
                                    </select>
                                </div>
                                
                                
                                <div class="form-group">
                        <label>City/Location</label>
                        <select class="form-control" required="required" name="data[Product][city_id]">
                            <option value="">Select--</option>
                                <?php
                                    
                                        foreach ($cities as $city) {
                                ?>

                                        <option value="<?php echo $city['City']['id']; ?>" <?php if($city['City']['id'] == $this->request->data['Product']['city_id']){echo "selected";}?>><?php echo $city['City']['name']; ?></option>
                                            

                                    <?php
                                    }
                                
                                ?>
                        </select>

                    </div> 


                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" class="form-control" required="" name="data[Product][price_lot]" value="<?php echo $this->request->data['Product']['price_lot'] ?>" placeholder="Deal price here">
                                </div>

                                <div class="form-group">
                                    <label>Discount</label>
                                    <input type="text" class="form-control" required="" name="data[Product][discount]" value="<?php echo $this->request->data['Product']['discount'] ?>" placeholder="Deal here">
                                </div>

                                 <?php
                  echo $this->Form->input('hid_img',array('type'=>'hidden','value'=>$this->request->data['Product']['product_image']));
                  echo $this->Form->input('product_image',array('type'=>'file','class'=>"form-control"));
                  
                        if(isset( $this->request->data['Product']['product_image']) and !empty( $this->request->data['Product']['product_image']))
                    {
                    ?>
                    <img alt="" src="<?php echo $this->webroot;?>product_images/<?php echo $this->request->data['Product']['product_image'];?>" style=" height:80px; width:80px;">
                    <?php
                    }
                    else{
                    ?>
                   <img alt="" src="<?php echo $this->webroot;?>product_images/default.png" style=" height:80px; width:80px;">

                    <?php } ?>

                                <div class="form-group">
                                    <label>Item Description</label>
                                    <textarea class="form-control ckeditor" name="data[Product][item_description]"  placeholder="Description here"><?php echo $this->request->data['Product']['item_description'] ?></textarea>
                                </div>
                                
                                
                                 <div class="form-group">
                                          <label>Start Date:</label>
                                          <div>

                                              <?php echo $this->Form->input('start_date', array('required' => 'required', 'label' => false, 'class' => 'form-control', 'id' => 'fromDate', 'type' => 'text')); ?>
                                          </div>
                                          
                                          
                                      </div>
                                      <div class="form-group">
                                          <label>Expiry Date:</label>
                                          <div>

                                              <?php echo $this->Form->input('end_date', array('required' => 'required', 'id' => 'toDate', 'type' => 'text', 'label' => false, 'class' => 'form-control')); ?>
                                          </div>
                                      </div>
                                
                                
                                
                                

                                <div class="form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="data[Product][status]">
                                        <option value="A" <?php if ($this->request->data['Product']['status'] == "A") {
                                                echo 'selected';
                                            } ?>>Active</option>
                                        <option value="I" <?php if ($this->request->data['Product']['status'] == "I") {
                                                echo 'selected';
                                            } ?>>Inactive</option>
                                        <option value="P" <?php if ($this->request->data['Product']['status'] == "P") {
                                                echo 'selected';
                                            } ?>>Pending</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <button type="submit" class="btn btn-lg btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
                                <?php foreach ($colors as $c) { ?>

                                    <option value="<?php echo $c['Color']['color_name']; ?>" data-id="<?php echo $c['Color']['id']; ?>"><?php echo $c['Color']['color_name']; ?></option>

<?php } ?>

                            </select>
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="full_name">Size</label>
                            <input type="text" class="form-control" id="size" name="data[ProductVariation][size]"  />
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

<!--   footer   -->







<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->


<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
<script type="text/javascript">
    //CKEDITOR.config.toolbar = 'Custom_medium';
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


<script type="text/javascript">
    $(function () {

        $('.mi').click(function (e) {
            e.preventDefault();
            if ($('#phone input').length > 1) {
                $('#phone').children().last().remove();
            }
        });
    });



    function addvariation() {

        var color = $('#color').val();
        var color_id = $('select.operations-supplier').find(':selected').data('id');
        var price = $('#price').val();
        var size = $('#size').val();
        //alert(color_id);
       if (color != '' && price != '' && size == '') {
            $('#phone').append(' <div class="row"><input type="hidden" name="data[ProductVariation][color_id][]" value=' + color_id + '><div class="form-group col-sm-6"><input type="text" class="form-control"  value=' + color + '  placeholder="color here"></div><div class="form-group col-sm-6"><input type="text" class="form-control" value=' + price + ' name="data[ProductVariation][price][]" placeholder="Price here"></div></div>');
        } else if ( size != '' && price != '' && color == '') {
            $('#phone').append(' <div class="row"><div class="form-group col-sm-6"><input type="text" class="form-control" value=' + size + ' name="data[ProductVariation][size][]" placeholder="Size here"></div><div class="form-group col-sm-6"><input type="text" class="form-control" value=' + price + ' name="data[ProductVariation][price][]" placeholder="Price here"></div></div>');
        }else{
            $('#phone').append('<div class="row"><input type="hidden" name="data[ProductVariation][color_id][]" value=' + color_id + '><div class="form-group col-sm-4"><input type="text" class="form-control"  value=' + color + '  placeholder="color here"></div><div class="form-group col-sm-4"><input type="text" class="form-control" value=' + size + ' name="data[ProductVariation][size][]" placeholder="Size here"></div><div class="form-group col-sm-4"><input type="text" class="form-control" value=' + price + ' name="data[ProductVariation][price][]" placeholder="Price here"></div></div>')
            
            }

    }


   function delete_variation(id) {
        $.ajax({
            method: "POST",
            url: base_url + "products/delete_variation",
            data: {id: id}
        })
                .done(function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.Ack == 1) {
                       $('#variation_' + id).html("");
                    }
                });
    }

</script>



<!--  <script type="text/javascript">
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
  
  </script>-->

<script>
    $(document).ready(function () {
        $("#sortable").sortable({
            stop: function (event, ui) {
                $.ajax({
                    method: "POST",
                    url: base_url + "products/order_image",
                    data: {ids: $(this).sortable('toArray')}
                })
                        .done(function (data) {
                            var obj = jQuery.parseJSON(data);

                        });
                //alert($(this).sortable('toArray'));
            }
        });
        $("#sortable").disableSelection();
    });//ready
</script>  

<script type="text/javascript">
    $(document).ready(function () {

        $('#multiFiles').on('change', function () {
            //alert('ok');
            var image_url = '<?php echo Configure::read('SITE_URL') ?>';
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
                    var obj = jQuery.parseJSON(response);

                    if (obj.Ack == 1) {

                        //alert('ok');
                        $('#product_image_id').val(obj.image_name);
                        for (var i = 0; i < obj.data.length; i++) {
                            file_path = image_url + 'product_images/' + obj.data[i].filename;
                            $('<li id="' + obj.data[i].last_id + '"></li>').appendTo('#sortable').html('<div class="media" id="image_' + obj.data[i].last_id + '"><div class="media-left"><a href="#"><img style="width: 100px; height: 100px" src="' + file_path + '" alt="" /></a></div><div class="media-body media-middle"><h4>' + obj.data[i].filename + '</h4></div><div class="media-body media-middle"></div></div></div></li>');
                        }
                    }
                },
                error: function (response) {
                    $('#msg').html(response); // display error response from the PHP script
                }
            });
        });





    });

    function delete_image(id) {
        $.ajax({
            method: "POST",
            url: base_url + "products/delete_image",
            data: {id: id}
        })
                .done(function (data) {
                    var obj = jQuery.parseJSON(data);
                    if (obj.Ack == 1) {
                        $('#image_' + id).html("");
                    }
                });
    }
    
    
    

</script>   
<script type="text/javascript" src="<?php echo ($this->webroot); ?>js/ajaxupload.3.5.js"></script>  