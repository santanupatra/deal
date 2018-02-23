<?php 
?>
<style type="text/css">
.btn-custom {
    background: #b60e09 none repeat scroll 0 0;
    border-color: #b60e09;
    box-shadow: none;
    padding-left: 20px;
    padding-right: 20px;
    text-shadow: none;
    color: #ffffff;
}
/*@media print {
tr.vendorListHeading {
    background-color: #b60e09 !important;
    -webkit-print-color-adjust: exact; 
}}

@media print {
    .vendorListHeading th {
    color: white !important;
}}*/
</style>

<section class="after_login">
    <div class="container">
        <div class="row">
            <?php echo($this->element('user_leftbar'));?>
            <div class="col-md-9">
                <div class="manage_inventory">
                    <h3>Billing Report</h3>
                    <div>&nbsp;</div>
                    <!--<input type="text" /><button> <i class="fa fa-search"></i> SEARCH</button>-->
                </div>
                <div class="col-md-12">
                    <form method="post" name="searchform" action="" class="form-inline">
                        <div class="col-md-3"><input type="text" class="form-control"  placeholder="From Date" name="from_date" id="from_date" value="<?php echo (isset($from_date) && $from_date!='')?$from_date:'';?>"></div>
                        <div class="col-md-3"><input type="text" class="form-control" placeholder="To Date" name="to_date" id="to_date" value="<?php echo (isset($to_date) && $to_date!='')?$to_date:'';?>"></div>
                        <div class="col-md-2"><button type="submit" name="frm_submit" value="search_form" class="btn btn-custom"> <i class="fa fa-search"></i> SEARCH</button></div>
                        <div class="col-md-2"><button type="button" id="print" class="btn btn-custom"> <i class="fa fa-print" aria-hidden="true"></i></button></div>
                        <div>&nbsp;</div>
                    </form>
                     <form name="pdfForm" action="<?php echo $this->webroot?>orders/create_pdf" method="post" target="_blank">
                        <input type="hidden" name="pdfhtml"  value="" id="pdfhtml" style="display:none;">
                        <div class="col-md-2" style="margin:-20px;"><button type="button" id="dwnldPDF" class="btn btn-custom"> Download PDF</button></div>
                    </form>
                </div>
                <div class="col-md-12">&nbsp;</div>
                <div class="col-md-12">
                    <div id="billing_report_div">
                        <table style="padding: 0; margin:0; border:1px solid #ccc; border-collapse: collapse;" width="100%" cell-padding="5px" cellspacing="0" class="">
                        <thead>
                            <tr class="vendorListHeading">
                                <th bgcolor="#b60e09" style="padding: 10px; text-align:center; color:#fff;"></th>
                                <th bgcolor="#b60e09" style="padding: 10px; text-align:center; color:#fff;">Transaction ID</th>
                                <th bgcolor="#b60e09" style="padding: 10px; text-align:center; color:#fff;">Amount</th>
                                <th bgcolor="#b60e09" style="padding: 10px; text-align:center; color:#fff;">For</th>
                                <th bgcolor="#b60e09" style="padding: 10px; text-align:center; color:#fff;">Date</th>
                            </tr>
                        </thead>
                        <?php 
                        if(!empty($billing_list)){
                            foreach($billing_list as $val){
                                $cdate=isset($val['Payment']['datetime'])?date('dS M, Y H:i a',strtotime($val['Payment']['datetime'])):'';
                        ?>
                        <tr style="text-align: center">
                            <td style="padding: 10px; border: none"></td>
                            <td style="padding: 10px; border: none"><?php echo $val['Payment']['transaction_id'];?></td>
                            <td style="padding: 10px; border: none">$<?php echo round($val['Payment']['amount'], 2);?></td>
                            <td style="padding: 10px; border: none"><?php echo $val['Payment']['for'];?></td>
                            <td style="padding: 10px; border: none"><?php echo $cdate;?></td>
                        </tr>
                        <?php 
                            }
                        }else{
                           echo "<tr><td colspan='5' style='text-align: center;'>Sorry No Record found</td></tr>"; 
                        }
                        ?>
                    </table>	
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
        </div>
    </div>
</section>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function(){       
        $('#from_date').datepicker({dateFormat: 'yy-mm-dd',
            onSelect: function (date, el) {
                $("#to_date").datepicker( "option", "minDate", date );
            },
            yearRange: "-150:+1"});
        $('#to_date').datepicker({dateFormat: 'yy-mm-dd'});
    });
    
    $("#print").on("click", function () {
        var divContents = $("#billing_report_div").html();
        var printWindow = window.open('', '', 'height=400,width=800');
        printWindow.document.write('<html><head><title>Billing Report</title>');
        printWindow.document.write('</head><body >');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    });
        
    $("#dwnldPDF").on("click", function ( event ) {
        event.preventDefault();
        var divContents = $("#billing_report_div").html();
        $("#pdfhtml").empty();
        $("#pdfhtml").val(divContents);
        
       document.pdfForm.submit();
    });
</script>
