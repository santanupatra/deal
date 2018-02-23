<?php ?>
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

                //alert(itemID);

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
                <div class="muted pull-left"><?php echo __('Add Product'); ?></div>
            </div>
            <!--<div class="users form">
            <?php echo $this->Form->create('Product', array('enctype' => 'multipart/form-data', 'action' => 'import')); ?>
                        <fieldset>
                          <div class="input select required">
                                <label for="ProductUserId">User Name</label>
                                <input type="text" id="UserName" maxlength="255" required="required" name="UserName">
                                <input type="hidden" id="ProductUserId" maxlength="255" required="required" name="data[Product][user_id]">

                        </div>
            <?php
            echo $this->Form->input('csv', array('label' => 'Import Csv', 'type' => 'file'));
            ?>
                </fieldset>

<?php echo $this->Form->end(__('Submit')); ?>
            </div>-->



            <div class="users form">
<?php echo $this->Form->create('Product', array('enctype' => 'multipart/form-data')); ?>
                <fieldset>
                    <div class="input select required">
                        <label for="ProductUserId">User Name</label>
                        <input type="text" id="UserName" maxlength="255" required="required" onclick="ship()" name="UserName">
                        <input type="hidden" id="ProductUserId" maxlength="255" required="required" name="data[Product][user_id]">

                    </div>
                    <?php
                        echo $this->Form->input('name', array('label' => 'Product name', 'required' => 'required'));
                    ?>
                    <div class="input select">
                        <label for="ShopCategories">Categories</label>
                        <select id="ShopCategories" required="required" name="data[Product][category_id]">
                            <option value="">Select Category--</option>
                                <?php
                                    if (isset($categories) && !empty($categories)) {
                                        foreach ($categories as $category) {
                                ?>

                                    <?php
                                    $subcats = $this->requestAction(array('controller' => 'categories', 'action' => 'getsubcat/' . $category['Category']['id']));
                                    if (!empty($subcats)) {
                                        ?>
                                        <optgroup label="<?php echo $category['Category']['name'] ?>">
                                        <?php
                                        foreach ($subcats as $subcat) {
                                            ?>


                                                <?php
                                                $subsubcats = $this->requestAction(array('controller' => 'categories', 'action' => 'getsubcat/' . $subcat['Category']['id']));
                                                if (!empty($subsubcats)) {
                                                    ?>
                                                <optgroup label="<?php echo $subcat['Category']['name'] ?>" style="margin-left: 12px;">
                                                    <?php
                                                    foreach ($subsubcats as $subcat2) {
                                                        ?>
                                                        <option value="<?php echo $subcat2['Category']['id']; ?>" style="margin-left: 20px;"><?php echo $subcat2['Category']['name']; ?></value>

                                                    <?php }
                                                    ?>
                                                </optgroup>
                                                    <?php
                                                } else {
                                                    ?>
                                                <option value="<?php echo $subcat['Category']['id']; ?>"><?php echo $subcat['Category']['name']; ?></value>
                                                        <?php
                                                    }
                                                    ?>

                                        <?php }
                                        ?>
                                            </optgroup>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $category['Category']['id']; ?>"><?php echo $category['Category']['name']; ?></value>
                                            <?php
                                        }
                                        ?>

                                    <?php
                                    }
                                }
                                ?>
                        </select>

                    </div>



                    <!--Multiple Image upload-->

                    <div>
                        <div class="company-images">


                            <input type="hidden" name="data[Product][product_image_name]" id="product_image_id" value="">
                            <div class="fileUpload btn btn-primary">

                                <input type="file" id="multiFiles" name="files[]" multiple="multiple" class="upload"/>
                            </div>

                            <span id="status" ></span>
                        </div>
                        <div class="manage-photo" id="product_images" style="overflow:scroll; height:450px;width:395px;">


                            <ul id="sortable">
                            </ul>


                        </div>
                    </div>

                    <?php                    
                        echo $this->Form->input('price_lot', array('label' => 'Price'));
                    //echo $this->Form->input('currency',array('type'=>'select','required'=>'required','label'=>'Cyrrency','options'=>$currency_value));
                    //echo $this->Form->input('keywords',array('label'=>'Keywords (Add comma separated keywords)'));
                    ?>

                   
                    <?php
                    echo $this->Form->input('item_description', array('label' => 'Item Description', 'class' => 'ckeditor'));                    
                    ?>
                    <div id="displayBySaleOn" style="display:none;">
                    <?php
                    echo $this->Form->input('discount', array('label' => 'Discount (% off)'));
                    echo $this->Form->input('start_date');
                    echo $this->Form->input('end_date');
                    ?>
                    </div>
                    <?php

                    echo $this->Form->input('status', array('required' => 'required', 'options' => $status, 'empty' => 'Select'));
                    ?>

                </fieldset>

                    <?php echo $this->Form->end(__('Submit')); ?>
            </div>
        </div>
    </div>
</div>

<!--Variation Modal-->



<!--Variation Modal end-->





<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
<script type="text/javascript">
    CKEDITOR.config.toolbar = 'Custom_medium';
    CKEDITOR.config.height = '200';
    CKEDITOR.replace('PagePDesc');
</script>

<script>
    function addvariation() {

        var color = $('#color').val();
        var color_id = $('select.operations-supplier').find(':selected').data('id');
        var size = $('#size').val();
        var price = $('#price').val();
        //alert(color_id);
        if (color != '' && price != '' && size == '') {
            $('#phone').append(' <div style=" display: flex; "><input type="hidden" name="data[ProductVariation][color_id][]" value=' + color_id + '><div class="form-group col-sm-6" style="flex: 1"><input type="text" class="form-control"  value=' + color + '  placeholder="color here"></div><div class="form-group col-sm-6"  style="flex: 1"><input type="text" class="form-control" value=' + price + ' name="data[ProductVariation][price][]" placeholder="Price here"></div></div>');
        } else if (size != '' && price != '' && color == '') {
            $('#phone').append(' <div style=" display: flex; "><div class="form-group col-sm-6"  style="flex: 1"><input type="text" class="form-control" value=' + size + ' name="data[ProductVariation][size][]" placeholder="Size here"></div><div class="form-group col-sm-6"  style="flex: 1"><input type="text" class="form-control" value=' + price + ' name="data[ProductVariation][price][]" placeholder="Price here"></div></div>');
        } else if (size != '' && price != '' && color != '') {
            $('#phone').append('<div style=" display: flex; "><input type="hidden" name="data[ProductVariation][color_id][]" value=' + color_id + '><div class="form-group col-sm-4" style="flex: 1"><input type="text" class="form-control"  value=' + color + '  placeholder="color here"></div><div class="form-group col-sm-4" style="flex: 1"><input type="text" class="form-control" value=' + size + ' name="data[ProductVariation][size][]" placeholder="Size here"></div><div class="form-group col-sm-4"><input type="text" class="form-control" value=' + price + ' name="data[ProductVariation][price][]" placeholder="Price here"></div></div>')

        }


        $('.mi').click(function (e) {
            e.preventDefault();
            if ($('#phone input').length > 0) {
                $('#phone').children().last().remove();
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


    function ship() {

        var uid = $('#ProductUserId').val();

//      $.post('<?php echo ($this->webroot) ?>admin/products/fetch_ship',
//
//        {id:uid},
//        function(status){

        $.ajax({
            type: 'POST',
            url: '<?php echo ($this->webroot) ?>admin/products/fetch_ship',
            data: {id: uid},
            cache: false,
            dataType: 'HTML',
            success: function (response) {

                var obj = jQuery.parseJSON(response);

                if (obj.Ack == 1) {
                    for (var i = 0; i < obj.data.length; i++) {
                        //console.log(obj.data);
                        $('.ship').append('<input type="checkbox" id="test' + obj.data[i].ShippingDay.id + '" name="data[Product][shipping_time][]" value="' + obj.data[i].ShippingDay.id + '"><label for="test' + obj.data[i].ShippingDay.id + '">USPS $"' + obj.data[i].ShippingDay.ship_charge + '"<small class="fixedCosts">' + obj.data[i].ShippingDay.ship_name + '</small> </label><p>' + obj.data[i].ShippingDay.ship_day + ' business day processing time</p>');
                    }
                }

            }
        });


    }
    ;

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
