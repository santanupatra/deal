<?php ?>
<style>
.btn-custom {
    background: #b60e09 none repeat scroll 0 0;
    border-color: #b60e09;
    box-shadow: none;
    padding-left: 20px;
    padding-right: 20px;
    text-shadow: none;
    color: #ffffff;
}
</style>
<script src="<?php echo $this->webroot;?>js/jquery.raty-fa.js"></script>
<section class="after_login">
    <div class="container">
        <div class="row">
                <?php echo($this->element('user_leftbar'));?>
                <div class="col-md-9">
                        <div class="manage_inventory">
                            <h3>Report</h3>
                            <div>&nbsp;</div>
                            <!--<input type="text" /><button> <i class="fa fa-search"></i> SEARCH</button>-->
                        </div>
                        <div class="col-md-12">
                            <form method="post" name="searchform" action="" class="form-inline">
                                <div class="col-md-3"><input type="text" class="form-control"  placeholder="From Date" name="from_date" id="from_date" value="<?php echo (isset($from_date) && $from_date!='')?$from_date:'';?>"></div>
                                <div class="col-md-3"><input type="text" class="form-control" placeholder="To Date" name="to_date" id="to_date" value="<?php echo (isset($to_date) && $to_date!='')?$to_date:'';?>"></div>
                                <div class="col-md-2">
                                    <select name="stars" class="form-control">
                                        <option value="">Select Feedback</option>
                                        <option value="1" <?php echo (isset($stars) && $stars=='1')?'selected="selected"':'';?>>1</option>
                                        <option value="2" <?php echo (isset($stars) && $stars=='2')?'selected="selected"':'';?>>2</option>
                                        <option value="3" <?php echo (isset($stars) && $stars=='3')?'selected="selected"':'';?>>3</option>
                                        <option value="4" <?php echo (isset($stars) && $stars=='4')?'selected="selected"':'';?>>4</option>
                                        <option value="5" <?php echo (isset($stars) && $stars=='5')?'selected="selected"':'';?>>5</option>
                                    </select></div>
                                <div class="col-md-1">&nbsp;</div>
                                <div class="col-md-2"><button type="submit" name="frm_submit" value="search_form" class="btn btn-custom"> <i class="fa fa-search"></i> SEARCH</button></div>
                                
                            </form>
                        </div>
                    <div class="col-md-12">
                        <table class="seller_table">
                            <tr>
                                <th></th>
                                <th>SKU</th>
                                <th>Products</th>
                                <th>Sold/Available</th>
                                <th>Feedback</th>
                                <!--<th>Positive Feedback</th>
                                <th>Negative Feedback</th>-->
                            </tr>
                            <?php //pr($inventoryList);exit;
                            if(!empty($prd_list)){
                                foreach($prd_list as $inventory){
                                    $prd_id=$inventory['Product']['id'];
                            ?>
                            <tr>

                                <!--<td><input type="checkbox" name="data[Product][id][]" value="<?php //echo $inventory['Product']['id']?>"></td>-->
                                <td></td>
                                <td><?php echo $inventory['Product']['sku'];?></td>
                                <td><?php echo $inventory['Product']['name'];?></td>
                                <td><?php echo $inventory['Product']['sold_quantity'].'/'.$inventory['Product']['quantity'];?></td>
                                <td>
                                    <?php //echo round($inventory['Product']['total_rate'], 1);?>
                                    <aside id="rateStar_<?php echo $prd_id;?>" style="color: #fd9104;"></aside>
                                    <?php  echo '<script>
$(document).ready(function(){
$("#rateStar_'.$prd_id.'").raty({score:'.$inventory['Product']['total_rate'].',readOnly:true, halfShow : true});
});</script>';
 ?>
                                </td>
                                <!--<td>4.2</td>
                                <td>20</td>-->
                            </tr>

                                <?php 
                                    }
                                }else{
                                   echo "<tr><td colspan='5' style='text-align: center;'>Sorry No Record found</td></tr>"; 
                                }
                                ?>
                        </table>
                    </div>
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function(){       
        $('#from_date').datepicker({dateFormat: 'yy-mm-dd',
            //minDate: dateToday,
            onSelect: function (date, el) {
                //alert(date);
                $("#to_date").datepicker( "option", "minDate", date );
            },
            yearRange: "-150:+1"});
        $('#to_date').datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>