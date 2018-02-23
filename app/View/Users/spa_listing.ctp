<?php 
?>
<section class="signin_sec">
    	<div class="container">
        	<div class="row">
            	<div class="profile_rapper">
                  <?php echo($this->element('user_leftbar'));?>      
                  <div class="col-md-9"> 
                        <div class="personal_profile">
                          <div class="personal_tables">  
                                <div class="personal_title">
                                    <p>Spa Listing</p>
                                </div>                    
                          </div>  
                          <a href="<?php echo $this->webroot; ?>users/spa-listing/create-new"><input class="btn btn-default btn-sm" value="Create New" type="button" style="float:right;margin-top: 6px;background:#e50516;color: #fff;"></a>                       
                        </div>
                  	<div class="panel">  
                  	<?php 
                  	  if(!empty($spas)){     
                  	   foreach($spas as $spa){
                               
                  	?>
                         <div class="profile_photoview panel">       
                            <div class="photo-view">
                                    <div class="left-photo-view">
                                      <div class="product-image">
                                       <img src="<?php echo $this->webroot;?>spa_images/<?php echo $spa['SpaImage'][0]['image']; ?>" alt="Spa Image">
                                      </div>
                                    </div>
                                    <div class="right-photo-view">
                                      <div class="list-width-map photo-view-list">
                                        <div class="profile_agent">
                                          <input class="btn btn-default btn-sm" value="Edit" type="button" style="background:white;border:1px solid #ccc;margin-right:5px;" onclick="location.href='<?php echo $this->webroot; ?>users/spa-listing/edit/<?php echo base64_encode($spa['Spa']['id']);?>'">
                                          <input class="btn btn-default btn-sm" value="Duplicate" type="button" style="background:white;border:1px solid #ccc;margin-right:5px;" onclick="location.href='<?php echo $this->webroot; ?>users/duplicate/<?php echo base64_encode($spa['Spa']['id']);?>'">
                                          <input class="btn btn-default btn-sm" value="Delete" type="button" style="background:white;border:1px solid #ccc;margin-right:5px;" onclick="del('<?php echo base64_encode($spa['Spa']['id']); ?>')">
                                          <input class="btn btn-default btn-sm" value="Post" type="button" style="background:#2C87F0;color: #fff;" id='post_<?php echo $spa['Spa']['id']?>'>
                                        </div>
                                        <div>
                                            <h3><?php if(isset($spa['Spa']['title']) && $spa['Spa']['title']!=''){if(strlen($spa['Spa']['title'])>21){echo substr($spa['Spa']['title'],0,21).'...';}else{echo $spa['Spa']['title'];}}else{echo 'N/A';}?></h3>
                                            <div class="stars">
                                                <img src="<?php echo $this->webroot;?>images/stars.png">
                                            </div>
                                            <p>
                                              <?php if(isset($spa['Spa']['about']) && $spa['Spa']['about']!=''){if(strlen($spa['Spa']['about'])>175){echo substr($spa['Spa']['about'],0,175).'...';}else{echo $spa['Spa']['about'];}}else{echo 'N/A';}?>
                                            </p>
                                        </div>
                                      </div>
                                      <div class="clearfix"></div>
                                      <div class="listrating">
                                          <p>Avg Rating :<span> 10/10</span></p>
                                          <h6><a href="javascript:void(0);"> Preview</a></h6>
                                          <div class="clearfix"></div>
                                    </div> 
                                  </div>
                                    <div class="clearfix"></div>           
                                </div>                     
                           <div class="clearfix"></div>           
                        </div>
                      <?php }}else{ ?>
                         <div class="protable_title" style="margin:20px 0;">
                           <p style="padding-bottom: 14px;">Nothing has been added to your listing.</p>
                           <div class="clearfix"></div>
                         </div>
                      <?php } ?>
                      
                       <!-- /block -->
		        
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
        </div>
</section>
<script>
 function del(id)
 {
  tt=confirm("Are you sure you want to delete this spa?");   
  if(tt){
  location.href="<?php echo $this->webroot;?>users/spa_delete/"+id;    
  }
 }
</script>