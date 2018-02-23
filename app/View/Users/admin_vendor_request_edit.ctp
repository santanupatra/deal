<?php ?>

<div class="span9" id="content">
	<div class="row-fluid">
		<!-- block -->
		<div class="block">
			<div class="navbar navbar-inner block-header">
				<div class="muted pull-left">Upgrade Request</div>
			</div>
                    	
                    
                    
                    
                    <div class="users form">
			<?php echo $this->Form->create('User');
                       
                        ?>
				<fieldset>
				

				<?php
                                
	echo $this->Form->input('id',array('type'=>'hidden','value'=>$this->request->data['User']['id']));				
		?>
                                    
                                     <div class="from-group">
                                        <label>Name</label>
                                           
                                        <input type="text"  value="<?php echo $this->request->data['User']['name']?>" readonly="">    
                                     
                                    </div>
                                    
                                     <div class="from-group">
                                        <label>Email</label>
                                           
                                        <input type="text" value="<?php echo $this->request->data['User']['email']?>"  readonly="">    
                                     
                                    </div>
				   
                                    <div class="from-group">
                                        <label>User Type</label>
                                           
                                        <input type="text"  <?php if($this->request->data['User']['type']=='C'){?>value="User" <?php }?> readonly="">    
                                     
                                    </div>

				
	
					
					
					
				</fieldset>
			<div class="form-group">
                                      <button type="submit" class="btn btn-lg btn-primary">Approve as a vendor</button>
                                      </div>
			</div>
		</div>
	</div>
</div>


 
      