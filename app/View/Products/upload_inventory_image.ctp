<section class="after_login">
		<div class="container">
			<div class="row">
				<?php echo($this->element('user_leftbar'));?>
				<div class="col-md-9">
					<div class="product_title">
						<div class="row">
							<div class="col-md-12">
								<h4>Upload New Image</h4>
							</div>
							<div class="col-md-12">
							    <div class="dash_middle_sec sequirity_info">
								<!--<h4>Manage Shop</h4>--><br/>
								<!--<form class="form-horizontal" method="post" action="<?php echo $this->webroot.'products/add_product';?>" enctype="multipart/form-data">-->
								    <?php echo $this->Form->create('Product',array('enctype'=>'multipart/form-data','class'=>'form-horizontal')); ?>
								    <div class="form-group">
									<label for="inputEmail3" class="col-sm-4 control-label">Product Image:</label>
									    <div class="col-sm-6">
									    <!--  <input type="text" class="form-control" id="inputEmail3" placeholder="">-->
									    <?php
									    echo $this->Form->input('product_id',array('required'=>'required','type'=>'hidden','label'=>false,'class'=>'form-control','value'=>base64_decode($this->params['pass'][0]))); 
									    
									    echo $this->Form->input('image',array('required'=>'required','type'=>'file','label'=>false,'class'=>'form-control')); ?>
                                                                            <p class="text-muted">allowed: .jpg, .jpeg, .png or .gif, Size: 400*200</p>     
									    </div>
								    </div>
								    <div class="form-group">
									<label for="inputEmail3" class="col-sm-4 control-label">Product Image Status:</label>
									    <div class="col-sm-6">
                                                                                <input type="radio" value="1" name="data[Product][status]"> &nbsp;&nbsp; Active &nbsp;&nbsp;
                                                                                <input type="radio" value="0" checked="checked" name="data[Product][status]"> Inactive
									    <?php //echo $this->Form->input('status',array('type'=>'checkbox','label'=>false)); ?>
									    </div>
								    </div>
								    <div class="form-group">
									    <div class="col-sm-offset-4 col-sm-6">
									      <button type="submit" class="btn btn-default active">Save & Update</button>
									      
									    </div>
								    </div>
									
									 </form>
									 
							    </div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
			
		</div>
	</section>
<style>
.form-horizontal .control-label {
     text-align: left;
}
.text-muted {
    color: #d43f3a;
}
</style>
<script>
	function subcatlist(val){
		//alert(val);
		$.post('<?php echo($this->webroot)?>products/getSubcat/'+val,function(data){
			//alert(data);
			$('#Subcat').html(data);
		});
	}
</script>