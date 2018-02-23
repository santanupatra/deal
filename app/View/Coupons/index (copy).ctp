<?php ?>
<section class="after_login">
        <div class="container">
                <div class="row">
                        <?php echo($this->element('user_leftbar'));?>
                        <div class="col-md-9">
                                <div class="manage_inventory">
                                    <h3>Manage Coupons</h3>
                                    <div>&nbsp;</div>
                                    
                                    <span style="float:right;margin-top:-25px;"><a href="<?php echo $this->webroot.'coupons/add';?>">Add New Coupon</a></span>
                                </div>
                                <form action="<?php echo $this->webroot.'products/pay_multiproduct';?>" method="post" name="paymulti">
                                
                                <table class="seller_table">
                                        <tr>
                                            <th></th>
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
                                            <td><!--<input type="checkbox" name="data[Coupon][id][]" value="<?php echo $val['Coupon']['id'];?>">--></td>
                                            <td><?php echo h($val['Coupon']['name']); ?></td>
                                            <td><?php echo h($val['Coupon']['coupon_code']); ?></td>
                                            <td><?php echo h($val['Coupon']['from_date']); ?>&nbsp;</td>
                                            <td><?php echo h($val['Coupon']['to_date']); ?>&nbsp;</td>
                                            <td><?php echo h($val['Coupon']['amount']); ?>% &nbsp;</td>
                                            <td><?php echo h($val['Coupon']['is_active']==1?'Yes':'No'); ?>&nbsp;</td>
                                            <td>
                                                <a href="<?php echo $this->webroot;?>coupons/edit/<?php echo base64_encode($val['Coupon']['id']);?>" class="fa fa-pencil"></a>
                                                <a href="<?php echo $this->webroot;?>coupons/delete/<?php echo base64_encode($val['Coupon']['id']);?>" onclick="return confirm('Are you sure to delete?')" class="fa fa-trash"></a>
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
                                </form>
                        </div>

                        <div class="paging">
                        <?php
                                echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
                                echo $this->Paginator->numbers(array('separator' => ''));
                                echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
                        ?>
                        </div>
                </div>
        </div>
</section>
<script>
function formSubmit(){
    	//document.paymulti.submit();
    }
</script>
<style>
button {
    height: 34px;
    background: #B60E09;
    border: 0;
    color: #fff;
    padding: 0 10px;
    border-radius: 3px;
    margin-left: 15px;
}
.seller_table tr th a{ color: #fff;}
</style>


