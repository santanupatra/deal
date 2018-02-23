<?php 
$userid = $this->Session->read('Auth.User.id');
?>
  
<section class="after_login">
    <div class="container">
        <div class="row">
            <?php echo($this->element('user_leftbar'));?>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <h2 style="margin-top: 5px">Place your Advert to reach your target audience</h2>
                        <h4>Select page to display Advert</h4>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="category_tab adv">
				<ul class="nav nav-tabs" role="tablist">
				    <li role="presentation" id="homeupperli" class=""><a href="#" aria-controls="" role="tab" data-toggle="tab" onclick="showDate('top')">Home page top banner advert</a></li>
				    <li role="presentation" id="homelowerli" class="" ><a href="#" aria-controls="" role="tab" data-toggle="tab" onclick="showDate('bottom')">Home page bottom banner advert</a></li>
				    <li role="presentation" class="" id="prodpgli" ><a href="#" aria-controls="" role="tab" data-toggle="tab">Product Detail Page</a></li>
				    <input type="hidden" name="data[Advertisement][ptype][]" id="ptypecheck" value=""/> 
				    <input type="hidden" name="data[Advertisement][page_position]" id="pg_pos" value="">
				
				
                                <!--<input type="checkbox" name="data[Advertisement][ptype][]" checked="checked"  value="1"/> Home page upper banner advert
				<input type="checkbox" name="data[Advertisement][ptype][]"  value="1" /> Home page lower banner advert
                                <input type="checkbox" name="data[Advertisement][ptype][]" value="2" /> Product Detail Page -->
				</ul>
				<div class="tab-content">
				    
				    <div class="up-file choose_file">
                                        <div class="col-md-12" id="ImgErrMsg" style="display: none;"></div>
					<div style="margin-bottom:15px;"><center><img src="#"  id="blah" style="display:none;"></center></div>
				        <div class="clearfix"></div>
					<label class="btn btn-primary btn-lg" for="UserProfileImg">Upload File & Preview <br> <i class="fa fa-plus"></i><input type="file" name="data[Advertisement][image]" id="UserProfileImg" class="form-control" required="required"/></label>
					<h5 class="gry-txt"><i>Required size (270px * 200px)</i></h5>
				    </div>
				</div>
				<div class="row">
				    <div class="col-sm-6">
					<div class="form-group">
					    <label>Shop Link</label>
					    <div class="input-group">
						<input type="text" class="form-control" required="required" name="data[Advertisement][link]" placeholder="Enter website link.">
					    </div>
					</div>
				    </div>
				    <div class="col-sm-6" id="topad">
					<div class="form-group">
					    <label>Start Date</label>
					    <div class="input-group">
						<div class="input-group date" data-provide="datepicker">
						    <input type="text" name="start_date" class="form-control" id="datepicker" >
						    <label for="datepicker" class="input-group-addon"  id="calimg">
							<span class="fa fa-calendar"></span>
						    </label>
						</div>
					    </div>
					</div>
				    </div>
				    
				    <div class="col-sm-6" id="bottomad" style="display:none;">
					<div class="form-group">
					    <label>Start Date</label>
					    <div class="input-group">
						<div class="input-group date" data-provide="datepicker">
						    <input type="text" name="start_date" class="form-control" id="datepickerbtm" >
						    <label for="datepicker" class="input-group-addon"  id="calimg">
							<span class="fa fa-calendar"></span>
						    </label>
						</div>
					    </div>
					</div>
				    </div>
				    
				    <div class="col-sm-6">
					<div class="form-group">
					    <label>Select Plan</label>
					    <div class="input-group">
						<select name="data[Advertisement][package_id]" required="required" class="form-control" id="adpackg" onchange="selectDateFirst()">
						    <option value="">Select plan</option>
						    <?php
						     if(count($package_list)>0){
							foreach ($package_list as $pkg): 
							    $pkg_id=$pkg['Package']['id'];
							    $pkg_name=$pkg['Package']['name'];
							    $pkg_duration=$pkg['Package']['duration'];
							    $pkg_price=$pkg['Package']['price'];
						    ?>
						    <option value="<?php echo $pkg_id;?>"> <?php echo $pkg_name.' - for '.$pkg_duration.' months $'.$pkg_price;?></option>
						    <?php
							endforeach;
						     }
						    ?>

						</select>
					    </div>
					</div>
				    </div>
                                    <div class="text-right col-sm-12"><button type="submit" class="btn btn-primary btn-lg" id="AdvBtnSubmit">Submit</button></td>
				    </div>
				</div>
				</div>
                      </form>    
                    </div>
                </div>
					
            </div>
        </div>

    </div>
</section>
<style type="text/css">
.choose_file input[type="file"]{
    -webkit-appearance:none; 
    position:absolute;
    top:0; left:0;
    opacity:0; 
}

.adv .nav-tabs li{width:33.3% !important;}
.adv .nav > li > a {    margin-right: 2px !important; }
</style>

<script>
/*function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah').attr('src', e.target.result);
            alert(e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}*/

function readURL(input) {
    if (input.files && input.files[0]) {
        //var FileErr=false;
        var reader = new FileReader();

        reader.onload = function (e) {
            var FileType=input.files[0].type;
                if(FileType=='image/jpeg' || FileType=='image/jpg' || FileType=='image/png' || FileType=='image/gif'){
                    var image = new Image();
                    image.src = e.target.result;
		    
                    image.onload = function() {
                        var ImgWidth=this.width;
                        var ImgHeight=this.height;
                        //console.log(ImgHeight);
                        /*if(ImgWidth <=300 && ImgHeight<=200){
                            $('#blah').attr('src', e.target.result).width(300).height(200);
                            $('#AdvBtnSubmit').removeAttr('disabled');
                            $('#ImgErrMsg').html('');
                            $('#ImgErrMsg').hide();
                            $('#blah').removeAttr("style");
                            //this.FileErr=false;
                        }else{
                            $('#AdvBtnSubmit').attr('disabled', 'disabled');
                            $('#ImgErrMsg').html('');
                            $('#ImgErrMsg').html('<div class="alert alert-danger"><strong>Error!</strong> Please upload the correct sized image.</div>');
                            $('#ImgErrMsg').show();
                            //this.FileErr=true;
                        }*/
    
			if(ImgWidth < 300 || ImgHeight< 200){
			    $('#AdvBtnSubmit').attr('disabled', 'disabled');
                            $('#ImgErrMsg').html('');
                            $('#ImgErrMsg').html('<div class="alert alert-danger"><strong>Error!</strong> Image size should be greater than 300px * 200px</div>');
                            $('#ImgErrMsg').show();
			    
			    
                            
                            //this.FileErr=false;
                        }else{
			    
			    /*var canvas = document.createElement('canvas');
			    var ctx = canvas.getContext('2d');
			    canvas.width = 250;
			    canvas.height = canvas.width * (img.height / img.width);
			    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

			    // SEND THIS DATA TO WHEREVER YOU NEED IT
			    var data = canvas.toDataURL('image/png');

			    $('#imgprvw').attr('src', img.src);*/
			    
                            $('#blah').attr('src', e.target.result).width(270).height(200);
                            $('#AdvBtnSubmit').removeAttr('disabled');
                            $('#ImgErrMsg').html('');
                            $('#ImgErrMsg').hide();
                            $('#blah').css("display","block");
                            //this.FileErr=true;
                        }
                    };
                }else{
                    $('#AdvBtnSubmit').attr('disabled', 'disabled');
                    $('#ImgErrMsg').html('');
                    $('#ImgErrMsg').html('<div class="alert alert-danger"><strong>Error!</strong> Please upload the image .jpg, .jpeg, .png format.</div>');
                    $('#ImgErrMsg').show();
                    //this.FileErr=true;
                }    
        };
        //console.log(this.FileErr);
        //if(FileErr===false){
            reader.readAsDataURL(input.files[0]);
            
        //}
    }
}

/*function readURL(input) {
        if (input.files && input.files[0]) {
            //var FileErr=false;
            var reader = new FileReader();

            reader.onload = function (e) {
                var FileType=input.files[0].type;
                if(FileType=='image/jpeg' || FileType=='image/jpg' || FileType=='image/png' || FileType=='image/gif'){
                    var image = new Image();
                    image.src = e.target.result;

                    image.onload = function() {
                        var ImgWidth=this.width;
                        //var ImgHeight=this.height;
                        console.log(ImgWidth);
                        if(ImgWidth <=300 && ImgHeight<=200){
                            $('#blah').attr('src', e.target.result).width(300).height(200);
                            $('#ImgErrMsg').hide();
                        }else{
                            $('#ImgErrMsg').html('');
                            $('#ImgErrMsg').html('<div class="alert alert-danger"><strong>Error!</strong> Please upload the correct sized image.</div>');
                            $('#ImgErrMsg').show();
                            //var FileErr=true;
                        }
                    };
                    console.log('hi');
                }else{
                    //$('#AdvBtnSubmit').attr('disabled', 'disabled');
                   
                    $('#ImgErrMsg').html('');
                    $('#ImgErrMsg').html('<div class="alert alert-danger"><strong>Error!</strong> Please upload the image .jpg, .jpeg, .png format.</div>');
                    $('#ImgErrMsg').show();
                    //var FileErr=true;
                }    
            };
            
            if(FileErr){
                reader.readAsDataURL(input.files[0]);
                $('#blah').removeAttr("style");
            }
        }
    }*/


function selectDateFirst(){
    var selectDate = $('#datepicker').val();
    var selectDatebtm = $('#datepickerbtm').val();
    var pg_pos = $('#pg_pos').val();
    if(pg_pos=='top')
    {
	    if(selectDate==''){
		alert('Please select the date first');
		$('#adpackg').val('');
		return false;
	    }
	    else{
		return true;
	    }
    }
    else if(pg_pos=='bottom')
    {
	    if(selectDatebtm==''){
		alert('Please select the date first');
		$('#adpackg').val('');
		return false;
	    }
	    else{
		return true;
	    }
    }
    
} 

$(document).ready(function(){
    $('#ptypecheck').val(1);
    $('#homeupperli').addClass('active');
    $('#pg_pos').val('top');
    $('#homeupperli').click(function(){
	
	$('#ptypecheck').empty();
	$('#ptypecheck').val(1);
	$('#pg_pos').val('top');
	$('#homeupperli').addClass('active');
	$('#homelowerli').removeClass('active');
	$('#prodpgli').removeClass('active');
    });
    
    $('#homelowerli').click(function(){
	
	$('#ptypecheck').empty();
	$('#ptypecheck').val('1');
	$('#pg_pos').val('bottom');
	$('#homelowerli').addClass('active');
	$('#homeupperli').removeClass('active');
	$('#prodpgli').removeClass('active');
    });
    
    $('#prodpgli').click(function(){
	$('#ptypecheck').empty();
	$('#ptypecheck').val('2');
	$('#pg_pos').val('home');
	$('#prodpgli').addClass('active');
	$('#homelowerli').removeClass('active');
	$('#homeupperli').removeClass('active');
	
    });
    $("#UserProfileImg").change(function(){
            
	    readURL(this);  
    });
});  

</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script>
var disableddates = ["<?php echo $allbdates;?>"];
var disableddatesbtm = ["<?php echo $allbdatesbtm;?>"];


function DisableSpecificDates(date) {
    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
    return [disableddates.indexOf(string) == -1];
  }
  
function DisableSpecificDatesbtm(date) {
    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
    return [disableddatesbtm.indexOf(string) == -1];
  }  
  
$(document).ready(function(){
 var dateToday = new Date();
        $('#datepicker').datepicker({
		beforeShowDay: DisableSpecificDates,
        	dateFormat:'yy-mm-dd',
        	//changeMonth: true,
	        //changeYear: true,
	        minDate: dateToday,
	     //maxDate: +80,
	     yearRange: "-150:+1"
        });
        
        $('#datepickerbtm').datepicker({
		beforeShowDay: DisableSpecificDatesbtm,
        	dateFormat:'yy-mm-dd',
        	//changeMonth: true,
	        //changeYear: true,
	        minDate: dateToday,
	     //maxDate: +80,
	     yearRange: "-150:+1"
        });
	
	
});

function showDate(type){
	if(type=="top")
	{
		$('#bottomad').hide();
		$('#topad').show();
		$('#adpackg').val('');$('#datepicker').val('');$('#datepickerbtm').val('');
		
	}
	else if(type=="bottom")
	{
		$('#topad').hide();
		$('#bottomad').show();
		$('#adpackg').val('');$('#datepicker').val('');$('#datepickerbtm').val('');
	}
}
</script>  
