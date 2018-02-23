 <!--  my account  -->

    <section class="pt-5 pb-5">
        <div class="container">
            <div class="row">
                <?php echo ($this->element('vendor_side_menu'));?>
                <div class="col-lg-9 col-12">
                    <div class="right-side p-3">
                        <h2 class="text-pink">Coupons List</h2>
                        <div class="table-responsive">
                          <table class="seller_table table mt-0">
                                        <tr>
                                            <th><?php echo $this->Paginator->sort('name','Coupon Name'); ?></th>
                                            <th><?php echo $this->Paginator->sort('coupon_code'); ?></th>
                                            <!--<th><?php echo $this->Paginator->sort('type'); ?></th>-->
                                            <th><?php echo $this->Paginator->sort('from_date', 'Start Date'); ?></th>
                                            <th><?php echo $this->Paginator->sort('to_date','Expiry Date'); ?></th>
                                            <th><?php echo $this->Paginator->sort('amount','Off %age'); ?></th>
                                            <th><?php echo $this->Paginator->sort('is_active'); ?></th>
                                            <th class="actions"><?php echo __('Actions'); ?></th>
                                        </tr>
                                        <?php //pr($inventoryList);exit;
                                        if(!empty($coupons)){
                                            foreach ($coupons as $val){
                                        ?>

                                        <tr>
                                            <td><?php echo h($val['Coupon']['name']); ?></td>
                                            <td><?php echo h($val['Coupon']['coupon_code']); ?></td>
                                            <td><?php echo h($val['Coupon']['from_date']); ?>&nbsp;</td>
                                            <td><?php echo h($val['Coupon']['to_date']); ?>&nbsp;</td>
                                            <td><?php echo h($val['Coupon']['amount']); ?>% &nbsp;</td>
                                            <td><?php echo h($val['Coupon']['is_active']==1?'Yes':'No'); ?>&nbsp;</td>
                                            <td>
                                                <a href="<?php echo $this->webroot;?>coupons/edit/<?php echo base64_encode($val['Coupon']['id']);?>" class="fa fa-pencil"></a>
                                                <a href="<?php echo $this->webroot;?>coupons/delete/<?php echo base64_encode($val['Coupon']['id']);?>" onclick="return confirm('Are you sure to delete?')" class="fa fa-trash text-pink"></a>
                                            </td>
                                        </tr>
                                        <?php
                                                }
                                            }
                                        else{
                                           echo "<tr><td colspan='8'>Sorry Record found</td></tr>";
                                        }
                                        ?>
                                </table>
                        </div>



		<div class="paging text-center paging-span-cont">
		<?php
			echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
		?>
		</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
