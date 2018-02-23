

<!--  my account  -->

<section class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            <?php echo ($this->element('user_side_menu')); ?>
            <div class="col-lg-9 col-12">
                <div class="right-side p-3">
                    <h2 class="text-pink">Edit Product</h2>
                    <div class="row">
                        <div class="col-lg-7 col-12">
                            <form class="form-area" method="post" action="<?php echo $this->webroot; ?>products/edit_product/<?php echo $this->request->data['Product']['id'] ?>" id="frmEdit">


                                <input type="hidden" name="data[Product][user_id]" value="<?php echo $user['User']['id']; ?>">
                                <input type="hidden" name="data[Product][id]" value="<?php echo $this->request->data['Product']['id']; ?>">

                                <div class="form-group">
                                    <label>Product Name</label>
                                    <input type="text" class="form-control" required="" name="data[Product][name]" value="<?php echo $this->request->data['Product']['name'] ?>"  placeholder="Product name here">
                                </div>

                                <div class="form-group">
                                    <label>Product Code</label>
                                    <input type="text" class="form-control" required="" name="data[Product][product_code]" value="<?php echo $this->request->data['Product']['product_code'] ?>"  placeholder="Product code here">
                                </div>

                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" class="form-control" required="" name="data[Product][quantity]" value="<?php echo $this->request->data['Product']['quantity'] ?>" placeholder="Product quantity here">
                                </div> 

                                <div class="form-group">
                                    <label>Categories</label>
                                    <select class="form-control" id="ShopCategories" required="required" name="data[Product][category_id]">
                                        <option value="">Select Category--</option>
                                        <?php
                                        if (isset($categories) && !empty($categories)) {
                                            foreach ($categories as $c1 => $category) {
                                                ?>

                                                <?php
                                                $subcats = $this->requestAction(array('controller' => 'categories', 'action' => 'getsubcat/' . $category['Category']['id']));
                                                if (!empty($subcats)) {
                                                    ?>
                                                    <optgroup label="<?php echo $category['Category']['name'] ?>">
                                                    <?php
                                                    foreach ($subcats as $c2 => $subcat) {
                                                        ?>


                                                            <?php
                                                            $subsubcats = $this->requestAction(array('controller' => 'categories', 'action' => 'getsubcat/' . $subcat['Category']['id']));
                                                            if (!empty($subsubcats)) {
                                                                ?>
                                                            <optgroup label="<?php echo $subcat['Category']['name'] ?>" style="margin-left: 12px;">
                                                                <?php
                                                                foreach ($subsubcats as $c3 => $subcat2) {
                                                                    ?>
                                                                    <option value="<?php echo $subcat2['Category']['id']; ?>" style="margin-left: 20px;" <?php if ($subcat2['Category']['id'] == $this->request->data['Product']['category_id']) {
                                                echo "selected";
                                            } ?>><?php echo $subcat2['Category']['name']; ?></value>

                                                                <?php }
                                                                ?>
                                                            </optgroup>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                            <option value="<?php echo $subcat['Category']['id']; ?>" <?php if ($subcat['Category']['id'] == $this->request->data['Product']['category_id']) {
                                                    echo "selected";
                                                } ?>><?php echo $subcat['Category']['name']; ?></value>
                                                            <?php
                                                        }
                                                        ?>

                                                        <?php }
                                                        ?>
                                                        </optgroup>
                                                        <?php
                                                    } else {
                                                        ?>
                                                    <option value="<?php echo $category['Category']['id']; ?>" <?php if ($category['Category']['id'] == $this->request->data['Product']['category_id']) {
                                                echo "selected";
                                            } ?>><?php echo $category['Category']['name']; ?></value>
                                                        <?php
                                                    }
                                                    ?>

                                                <?php
                                                }
                                            }
                                            ?>
                                    </select>
                                </div>






                                <div class="form-group">
                                    <label>Price</label>
                                    <input type="text" class="form-control" required="" name="data[Product][price_lot]" value="<?php echo $this->request->data['Product']['price_lot'] ?>" placeholder="Product price here">
                                </div>





                                <div id="phone">
<?php foreach ($colorprice as $dt) { ?>     
                                        <div class='row' id="variation_<?php echo $dt['ProductVariation']['id'] ?>"> 

                                            <input type="hidden" name='data[ProductVariation][id][]' value='<?php echo $dt['ProductVariation']['id'] ?>'>
                                            
                                            <?php if($dt['ProductVariation']['color_id']!=''){?>
                                            <div class="form-group col-sm-4" >
                                                <label>Color</label>
                                                <select name="data[ProductVariation][color_id][]"  class="form-control" required="required">
                                                    <option value="">--select--</option>
    <?php foreach ($colors as $c) { ?>

                                                        <option value="<?php echo $c['Color']['id']; ?>" data-id="<?php echo $c['Color']['id']; ?>" <?php if ($c['Color']['id'] == $dt['ProductVariation']['color_id']) {
            echo 'selected';
        } ?>><?php echo $c['Color']['color_name']; ?></option>

                                                    <?php } ?>

                                                </select>
                                            </div>
                                            <?php } ?>
                                            <?php if($dt['ProductVariation']['size']!=''){?>
                                            <div class="form-group col-sm-4">
                                                <label for="full_name">Size</label>
                                                <input type="text" class="form-control" value='<?php echo $dt['ProductVariation']['size'] ?>'  name="data[ProductVariation][size][]" required="required" />
                                            </div>
                                            <?php } ?>
                                            <div class="form-group col-sm-4">
                                                <label for="full_name">Price</label>
                                                <input type="text" class="form-control" value='<?php echo $dt['ProductVariation']['price'] ?>'  name="data[ProductVariation][price][]" required="required" />
                                            </div>
                                        
                                        <div class="form-group col-sm-4">                     
                                            <a  onclick="delete_variation(<?php echo $dt['ProductVariation']['id'] ?>)">Remove</a>
                                        </div>
                                            </div>
                                    <?php } ?>
                                </div>

                                
                                
                                
                                
                                <div class="RegSpRight form-group">
                                    <a data-target="#variation_add_modal" href="Javascript: void(0);" data-toggle="modal"><button class="pl btn btn-primary btnsearch">Add Variation</button></a>&nbsp;

                                </div>

                                <!--                                  <div class=" form-group">
                                                                   <input type="color" name="data[Product][colour]" value="<?php echo $this->request->data['Product']['colour'] ?>">
                                                                          
                                                                  </div>  -->

                                <div class="form-group">
                                    <label>Material(optional)</label>
                                    <input type="text" class="form-control" name="data[Product][material]" value='<?php echo $this->request->data['Product']['material'] ?>' placeholder="Product material here">
                                </div>



                                <?php $ship_id = explode(',', $this->request->data['Product']['shipping_time']); ?>  


                                <div class="form-group">
                                    <label>Shipping Time</label>
                                    <div class="shippingTable">
                                        <div class="form-check">

                                            <?php foreach ($ships as $ship) { ?>                  
                                                <div class="form-check-label inputTypeRadio">
                                                    <input type="checkbox" id="test<?php echo $ship['ShippingDay']['id']; ?>" name="data[Product][shipping_time][]" value="<?php echo $ship['ShippingDay']['id'] ?>" <?php if (in_array($ship['ShippingDay']['id'], $ship_id)) {
                                                    echo 'checked';
                                                } ?>>
                                                    <label for="test<?php echo $ship['ShippingDay']['id']; ?>">USPS $<?php echo $ship['ShippingDay']['ship_charge'] ?> <small class="fixedCosts"><?php echo $ship['ShippingDay']['ship_name'] ?></small> </label>				
                                                    <p><?php echo $ship['ShippingDay']['ship_day'] ?> business day processing time, from United States</p>
                                                </div>
<?php } ?>                

                                        </div>
                                    </div>
                                </div>


                                <div>
                                    <div class="company-images">
                                      <!--<img src="<?php echo $this->webroot; ?>images/company-images-blank.png" alt="">--> 

                                        <input type="hidden" name="data[Product][product_image_name]" id="product_image_id" value="">
                                        <div class="fileUpload btn btn-primary">
                                            <span>Add Image</span>
                                            <input type="file" id="multiFiles" name="files[]" multiple="multiple" class="upload"/>
                                        </div>

                                        <span id="status" ></span> 
                                    </div>
                                    <div class="manage-photo" id="product_images" style="overflow:scroll; height:450px;width:500px;">
                                        <ul id="sortable">
                                            <?php
                                            // print_r($all_image);exit;

                                            foreach ($all_image as $image) {
                                                ?>
                                                <li id="<?php echo $image['ProductImage']['id']; ?>">
                                                    <div class="media" id="image_<?php echo $image['ProductImage']['id']; ?>">
                                                        <div class="media-left">
                                                            <a href="#">
                                                                <img style="width: 100px; height: 100px" src="<?php echo $this->webroot; ?>product_images/<?php echo $image['ProductImage']['name']; ?>" alt="" />
                                                            </a>
                                                        </div>
                                                        <div class="media-body media-middle">
                                                            <h4><?php echo $image['ProductImage']['name']; ?></h4>
                                                        </div>
                                                        <div class="media-body media-middle">
                                                            <a class="btn btn-blank" onclick="javascript: delete_image(<?php echo $image['ProductImage']['id']; ?>)"><button>Delete</button></a>                         
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>




                                    </div>
                                </div>


                                <div class="form-group">
                                    <label>Item Weight</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="data[Product][package_weight]" value="<?php echo $this->request->data['Product']['package_weight'] ?>"  placeholder="item weight here">	
                                        <span class="input-group-addon">Lbs</span>  
                                    </div>
                                </div>    





                                <div class="form-group">
                                    <label>Item Description</label>
                                    <textarea class="form-control ckeditor" name="data[Product][item_description]"  placeholder="Description here"><?php echo $this->request->data['Product']['item_description'] ?></textarea>
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
        var size = $('#size').val();
        var price = $('#price').val();
        //alert(color_id);
        if (color != '' && price != '' && size == '') {
            $('#phone').append(' <div class="row"><input type="hidden" name="data[ProductVariation][color_id][]" value=' + color_id + '><div class="form-group col-sm-6"><input type="text" class="form-control"  value=' + color + '  placeholder="color here"></div><div class="form-group col-sm-6"><input type="text" class="form-control" value=' + price + ' name="data[ProductVariation][price][]" placeholder="Price here"></div></div>');
        } else if ( size != '' && price != '' && color == '') {
            $('#phone').append(' <div class="row"><div class="form-group col-sm-6"><input type="text" class="form-control" value=' + size + ' name="data[ProductVariation][size][]" placeholder="Size here"></div><div class="form-group col-sm-6"><input type="text" class="form-control" value=' + price + ' name="data[ProductVariation][price][]" placeholder="Price here"></div></div>');
        }else{
            $('#phone').append('<div class="row"><input type="hidden" name="data[ProductVariation][color_id][]" value=' + color_id + '><div class="form-group col-sm-4"><input type="text" class="form-control"  value=' + color + '  placeholder="color here"></div><div class="form-group col-sm-4"><input type="text" class="form-control" value=' + size + ' name="data[ProductVariation][size][]" placeholder="Size here"></div><div class="form-group col-sm-4"><input type="text" class="form-control" value=' + price + ' name="data[ProductVariation][price][]" placeholder="Price here"></div></div>')
            
            }

    }

</script>


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
<script type="text/javascript" src="<?php echo ($this->webroot); ?>js/ajaxupload.3.5.js"></script>   