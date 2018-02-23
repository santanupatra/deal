 <!--  my account  -->

    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row">
                <?php if($userdetails['User']['type']=='V'){ echo ($this->element('vendor_side_menu'));}else{echo ($this->element('user_side_menu'));};?>
                <div class="col-lg-9 col-12">
                    <div class="right-side p-3">
                        <h2 class="text-pink">Shipping List</h2>
                        <div style="float:right;">
                            <a href="<?php echo($this->webroot)?>shipping_addresses/shhipping_management_add">Add Shipping Day</a>
                        </div>
                        <div class="table-responsive">
                          <table class="seller_table table table-bordered  mt-0">
                                        <thead class="table-dark"><tr>
                                        <th>Ship Id</th>        
                                        <th>Ship Name</th>
                                        <th>Shipping Day</th>
                                        <th>Shipping Charge</th>
                                        <th class="actions"><?php echo __('Actions'); ?></th>
                                        </tr></thead>
                                        <?php //print_r($shippinday);exit;
                                        if(!empty($shippinday)){
                                            foreach ($shippinday as $val){
                                        ?>

                                        <tr>
                                            <td><?php echo h($val['ShippingDay']['id']); ?></td>
                                            <td><?php echo h($val['ShippingDay']['ship_name']); ?></td>
                                            <td><?php echo h($val['ShippingDay']['ship_day']); ?></td>
                                            <td><?php echo h($val['ShippingDay']['ship_charge']); ?>&nbsp;</td>
                                            
                                            <td>
                                                <a href="<?php echo $this->webroot;?>shipping_addresses/shipping_management_edit/<?php echo base64_encode($val['ShippingDay']['id']);?>" class="fa fa-pencil text-success mr-2"></a>
                                                <a href="<?php echo $this->webroot;?>shipping_addresses/shipping_management_delete/<?php echo base64_encode($val['ShippingDay']['id']);?>" onclick="return confirm('Are you sure to delete?')" class="fa fa-trash text-pink"></a>
                                            </td>
                                        </tr>
                                        <?php
                                                }
                                            }
                                        else{
                                           echo "<tr><td colspan='8'>Sorry! No Record found.</td></tr>";
                                        }
                                        ?>
                                </table>
                        </div>



		
                    </div>
                </div>
            </div>
        </div>
    </section>
