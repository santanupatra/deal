

<div class="span9" id="content">
    <div class="row-fluid">
		<!-- block -->
        <div class="block">
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left"><?php echo __('Add Faq'); ?></div>
            </div>
            <div class="users form">
            <?php echo $this->Form->create('Faq'); ?>
            <fieldset>
                
             <?php
		echo $this->Form->input('question',array('required' => 'required','style'=>'width:500px;'));
                echo $this->Form->input('answer',array('required' => 'required','style'=>'width:500px;'));

	?>
            </fieldset>
            <?php echo $this->Form->end(__('Submit')); ?>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 
<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
<script type="text/javascript">
    CKEDITOR.config.toolbar = 'Custom_medium';
    CKEDITOR.config.height = '200';
    CKEDITOR.replace('PagePDesc');
</script>
<script>
   
    function fetchshop(id) {
        
        //alert(id);
        
            $.ajax({
                url: '<?php echo $this->request->webroot; ?>admin/products/fetchshop', 
                cache: false,
                data: { seller_id: id},
                type: 'post',
                success: function (response) {
                    console.log(response);
                    var obj = jQuery.parseJSON(response);

                    if (obj.Ack == 1) {
                       
                        html ="";
                        for (var i = 0; i < obj.data.length; i++) {
                          
                           html= html+"<option value='"+obj.data[i].Shop['id']+"'>"+obj.data[i].Shop['name']+"</option>";
                           
                        }
                        
                      $('#shop').html(html); 
                    }
                },
                error: function (response) {
                    $('#msg').html(response); // display error response from the PHP script
                }
            });
        }

 
 




</script>




<script type="text/javascript">
    function check_validate(){
        var CouponAmount=$('#CouponAmount').val();
        var float= /^\s*(\+|-)?((\d+(\.\d+)?)|(\.\d+))\s*$/;
        if(float.test(CouponAmount)==false){
            alert('Enter value must be float or int.');
            $("#CouponAmount").css('border', '1px solid #ff0000');
            $("#CouponAmount").focus();
            return false;
        }else{
            return true;
        }
    }
    
    $(document).ready(function(){
        var dateToday = new Date();
        $( "#fromDate" ).datepicker({ 
            dateFormat: 'yy-mm-dd',
            //changeMonth: true,
            //changeYear: true,
            minDate: dateToday,
            onSelect: function (date, el) {
                var selectedDate = new Date(date);
                var msecsInADay = 86400000;
                var endDate = new Date(selectedDate.getTime() + msecsInADay);
                $("#toDate").datepicker( "option", "minDate", endDate );
                //$("endDatePicker").datepicker( "option", "maxDate", '+2y' );
            },
            yearRange: "-150:+1"
        });
        
        $( "#toDate" ).datepicker({ 
            dateFormat: 'yy-mm-dd',
            yearRange: "-150:+1"
        });
    });
</script>