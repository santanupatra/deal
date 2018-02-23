<?php
if ($this->request->data['Product']['sale_on'] == 'Y') {
    $dispsaleon = 'block';
} else {
    $dispsaleon = 'none';
}
?>
<script>
    function subcatlist(val) {
        //alert(val);
        $.post('<?php echo($this->webroot) ?>products/getSubcat/' + val, function (data) {
            //alert(data);
            $('#Subcat').html(data);
        });
    }

    $(document).ready(function () {
        $('#ProductSaleOn').change(function () {
            var saleonval = $('#ProductSaleOn').val();
            if (saleonval == 'Y')
            {
                $('#displayBySaleOn').show();
            }
            else
            {
                $('#displayBySaleOn').hide();
            }
        });
        $('#UserName').autocomplete({
            minLength: 1,
            source: function (request, response) {
                var keyword = $('#UserName').val();
                //alert(keyword);
                var url = '<?php echo $this->webroot ?>products/autoComplete/' + keyword;
                // alert(url);
                $.getJSON(url, response);
            },
            select: function (event, ui) {
                console.log(ui.item.id, ui.item.value);
                var itemID = ui.item.id;
                // var phn_nmbr = ui.item.phn;
                // var linkurl = ui.item.linkurl;
                //  $('#CityNameID').val(CityNameID);
                //  $('#phn').val(phn_nmbr);
                //  $('#search').attr('value','search');
                //location.href = linkurl + CityNameID;
                //alert(linkurl);
                document.getElementById('ProductUserId').value = ui.item.id;
                //addnewTag();
                //ui.item.value = '';

            },
            change: function (event, ui) {

            }
        });
    });
</script>
<div class="span9" id="content">
    <div class="row-fluid">
        <!-- block -->
        <div class="block">
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left"><?php echo __('Edit Product'); ?></div>
            </div>
            <div class="users form">
<?php echo $this->Form->create('Product', array('enctype' => 'multipart/form-data')); ?>
                <fieldset>
                    <div class="input select required">
                        <label for="ProductUserId">User Name</label>
                        <input type="text" id="UserName" maxlength="255" required="required" name="UserName"  value="<?php echo (isset($this->request->data['User']) && !empty($this->request->data['User'])) ? $this->request->data['User']['first_name'] . ' ' . $this->request->data['User']['last_name'] : '' ?>">
                        <input type="hidden" id="ProductUserId" maxlength="255" required="required" name="data[Product][user_id]" value="<?php echo $this->request->data['Product']['user_id'] ?>">

                    </div>
<?php
echo $this->Form->input('id');
//echo $this->Form->input('user_id',array('required'=>'required','empty'=>'Select'));
echo $this->Form->input('name', array('required' => 'required'));
echo $this->Form->input('product_code', array('required' => 'required'));
//echo $this->Form->input('quantity',array('required'=>'required'));
//echo $this->Form->input('category_id',array('required'=>'required', 'onchange'=>'subcatlist(this.value)','empty'=>'Select'));
?>
                    <!-- 		<div class="input select">
                                            <label for="ProductSubCategoryId">Sub Category</label>
                                            <span id=Subcat>
<?php
if ($this->request->data['Product']['category_id'] != '') {
    ?>
                                                <select name="data[Product][sub_category_id]" id="ProductSubCategoryId">
                                                        <option value="">Select</option>
    <?php
    if ($sub_categories) {
        foreach ($sub_categories as $k => $v) {
            ?>
                                                                        <option value="<?php echo($k); ?>" <?php echo($k == $this->request->data['Product']['sub_category_id'] ? 'selected' : ''); ?>><?php echo($v); ?></option>
                            <?php
                            }
                        }
                        ?>
                                                </select>
                    <?php } else { ?>
                                                <select name="data[Product][sub_category_id]" id="ProductSubCategoryId">
                                                        <option value="">Select</option>
                                                </select>
                    <?php } ?>
                                            </span>
                                    </div> -->

                    <div class="input select 11">
                        <label for="ShopCategories">Categories</label>
                        <select id="ShopCategories" required="required" name="data[Product][category_id]">
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


                    <!--image upload -->

                    <div class="11">
                        <div class="company-images">
                          <!--<img src="<?php echo $this->webroot; ?>images/company-images-blank.png" alt="">-->

                            <input type="hidden" name="data[Product][product_image_name]" id="product_image_id" value="">
                            <div class="fileUpload btn btn-primary">
                               <!--<span>Add Image</span>-->
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
                                                <a class="btn btn-blank" onclick="javascript: delete_image(<?php echo $image['ProductImage']['id']; ?>)">Delete</a>
                                            </div>
                                        </div>
                                    </li>
    <?php
}
?>
                            </ul>

                            <ul id="sortable">
                            </ul>


                        </div>
                    </div>










<?php
//echo $this->Form->input('percentage_id', array('type'=>'select', 'label'=>'Percentage ', 'options'=>$percentage_value,'required'=>'required'));
echo $this->Form->input('is_featured', array('options' => $is_featured, 'empty' => 'Select'));

//echo $this->Form->input('unit_type',array('required'=>'required','options'=>$unit_type,'empty'=>'Select'));
echo $this->Form->input('quantity', array('required' => 'required', 'label' => 'Quantity'));
echo $this->Form->input('price_lot', array('required' => 'required', 'label' => 'Price'));
//echo $this->Form->input('currency',array('type'=>'select','required'=>'required','label'=>'Cyrrency','options'=>$currency_value));
//echo $this->Form->input('keywords',array('label'=>'Keywords (Add comma separated keywords)'));
?>




                   <div id="phone">
<?php foreach ($colorprice as $dt) { ?>
                                        <div id="variation_<?php echo $dt['ProductVariation']['id'] ?>" style="display: flex; align-items: center;">

                                            <input type="hidden" name='data[ProductVariation][id][]' value='<?php echo $dt['ProductVariation']['id'] ?>'>

                                            <?php if($dt['ProductVariation']['color_id']!=''){?>
                                            <div class="form-group col-sm-4" style="flex: 1;">
                                                <label>Color</label>
                                                <select name="data[ProductVariation][color_id][]"  class="form-control" required="required" style=" width: 95%; ">
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
                                            <div class="form-group col-sm-4"  style="flex: 1;">
                                                <label for="full_name">Size</label>
                                                <input type="text" class="form-control" value='<?php echo $dt['ProductVariation']['size'] ?>'  name="data[ProductVariation][size][]" required="required" />
                                            </div>
                                            <?php } ?>
                                            <div class="form-group col-sm-4" style="flex: 1;">
                                                <label for="full_name">Price</label>
                                                <input type="text" class="form-control" value='<?php echo $dt['ProductVariation']['price'] ?>'  name="data[ProductVariation][price][]" required="required" />
                                            </div>

                                        <div class="form-group col-sm-4">
                                            <a  onclick="delete_variation(<?php echo $dt['ProductVariation']['id'] ?>)" href="#">Remove</a>
                                        </div>
                                            </div>
                                    <?php } ?>
                                </div>
                                <div class="RegSpRight form-group">
                                    <a data-target="#variation_add_modal" href="Javascript: void(0);" data-toggle="modal"><button class="pl btn btn-primary btnsearch">Add Variation</button></a>&nbsp;

                                </div>




                    <div class="form-group">
                        <label>Material(optional)</label>
                        <input type="text" class="form-control" name="data[Product][material]" value='<?php echo $this->request->data['Product']['material'] ?>' placeholder="Product material here">
                    </div>

<?php $ship_id = explode(',', $this->request->data['Product']['shipping_time']);
?>


                    <div class="form-group">
                        <label>Shipping Time</label>
                        <div class="shippingTable">
                            <div class="form-check">

<?php foreach ($ships as $ship) { ?>
                                    <div class="form-check-label inputTypeRadio ship">
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






                    <div class="form-group">
                        <label>Item Weight</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="data[Product][package_weight]" value="<?php echo $this->request->data['Product']['package_weight'] ?>"  placeholder="item weight here">
                            <span class="input-group-addon">Lbs</span>
                        </div>
                    </div>



                    <!--                                     <div class="form-group">
                                                              <label>Item Size (When packed)</label>
                                                              <div class="row">
                                                              <div class="form-group col-sm-4">
                                                              <label>Length</label>
                                                              <div class="input-group">
                                                              <input type="text" class="form-control" name="data[Product][package_size1]" value="<?php echo $this->request->data['Product']['package_size1'] ?>"   placeholder="Length">
                                                             <span class="input-group-addon">In</span>
                                                             </div>
                                                          </div>
                                                            <div class="form-group col-sm-4">
                                                              <label>Width</label>
                                                              <div class="input-group">
                                                              <input type="text" class="form-control" name="data[Product][package_size2]" value="<?php echo $this->request->data['Product']['package_size2'] ?>"  placeholder="Width">
                                                              <span class="input-group-addon">In</span>
                                                              </div>
                                                          </div>
                                                              <div class="form-group col-sm-4">
                                                              <label>Height</label>
                                                              <div class="input-group">
                                                              <input type="text" class="form-control" name="data[Product][package_size3]" value="<?php echo $this->request->data['Product']['package_size3'] ?>"  placeholder="Height">		  <span class="input-group-addon">In</span>

                                                              </div>
                                                          </div>
                                                              </div>
                                                          </div>-->







<?php
echo $this->Form->input('item_description', array('label' => 'Item Description', 'class' => 'ckeditor'));
//echo $this->Form->input('shipping_time',array('required'=>'required','options'=>$shipping_time));
//echo $this->Form->input('processing_time',array('required'=>'required','options'=>$processing_time));
//echo $this->Form->input('sale_on',array('options'=>$sale_on,'empty'=>'Select'));
?>
<!--                    <div id="displayBySaleOn" style="display:<?php echo $dispsaleon; ?>;">
                    <?php
                    //echo $this->Form->input('discount', array('label' => 'Discount (% off)'));
                    //echo $this->Form->input('start_date');
                    ///echo $this->Form->input('end_date');
                    ?>
                    </div>-->
                        <?php
                        // echo $this->Form->input('package_weight',array('required'=>'required'));
                        // echo $this->Form->input('package_unit',array('required'=>'required'));
                        // echo $this->Form->input('package_size1',array('label'=>'Package Height','required'=>'required'));
                        // echo $this->Form->input('package_size2',array('label'=>'Package Width','required'=>'required'));
                        // echo $this->Form->input('package_size3',array('label'=>'Package Length','required'=>'required'));
                        // echo $this->Form->input('package_size_unit',array('required'=>'required'));
                        #echo $this->Form->input('created_at',array('required'=>'required'));
                        echo $this->Form->input('status', array('required' => 'required', 'options' => $status, 'empty' => 'Select'));
                        ?>

                </fieldset>

                    <?php echo $this->Form->end(__('Submit')); ?>
            </div>
        </div>
    </div>
</div>


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
                <form action='#' accept-charset="utf-8" onsubmit="return false" class="no-padding-div">
                    <div id="phone">
                        <div class="form-group col-sm-4" >
                            <label>Color</label>
                            <select name="data[ProductVariation][color_id]"  id='color' class="form-control operations-supplier" style=" width: 95%; ">
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









<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
<script type="text/javascript">
    CKEDITOR.config.toolbar = 'Custom_medium';
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
            $('#phone').append(' <div style=" display: flex; "><input type="hidden" name="data[ProductVariation][color_id][]" value=' + color_id + '><div class="form-group col-sm-6" style=" flex: 1; "><input type="text" class="form-control"  value=' + color + '  placeholder="color here"></div><div class="form-group col-sm-6" style=" flex: 1; "><input type="text" class="form-control" value=' + price + ' name="data[ProductVariation][price][]" placeholder="Price here"></div></div>');
        } else if (size != '' && price != '' && color == '') {
            $('#phone').append(' <div style=" display: flex; "><div class="form-group col-sm-6" style=" flex: 1; "><input type="text" class="form-control" value=' + size + ' name="data[ProductVariation][size][]" placeholder="Size here"></div><div class="form-group col-sm-6" style=" flex: 1; "><input type="text" class="form-control" value=' + price + ' name="data[ProductVariation][price][]" placeholder="Price here"></div></div>');
        } else {
            $('#phone').append('<div style=" display: flex; "><input type="hidden" name="data[ProductVariation][color_id][]" value=' + color_id + '><div class="form-group col-sm-4"><input type="text" class="form-control"  value=' + color + '  placeholder="color here"></div><div class="form-group col-sm-4"><input type="text" class="form-control" value=' + size + ' name="data[ProductVariation][size][]" placeholder="Size here"></div><div class="form-group col-sm-4"><input type="text" class="form-control" value=' + price + ' name="data[ProductVariation][price][]" placeholder="Price here"></div></div>')

        }

    }

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
            url: "<?php echo $this->webroot; ?>products/delete_image",
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
            url: "<?php echo $this->webroot; ?>products/delete_variation",
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
<style media="screen">
  .modal-header .close{
    position: absolute;
    right: 15px;
    top: 15px;
  }
  .mb-0{
    margin-bottom: 0 !important;
  }
</style>
